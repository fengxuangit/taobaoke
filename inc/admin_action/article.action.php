<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class article extends app{
	
		
		function search(){
					global $_G;
					if($_GET[onsubmit] && check()){
						$this->main();
						return false;
					}
					$this->show();
		}
		
		function main(){
					global $_G;
					if($_GET['onsubmit'] && check()  && !$_GET[search]){
							foreach($_GET[ids] as $k=>$v){
								if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['views']			= 	intval($_GET['views'][$k]);	
								$arr['cate']			= 	intval($_GET['cates'][$k]);	
								$arr['hide']		= 	$_GET['hide'][$k] ? 1 :0;	
								$arr['sort']		= 	$_GET['sort'][$k] ? intval($_GET['sort'][$k]) :0;									
								if($_GET['in_cate']!='-1') $arr['cate']	 = intval($_GET['in_cate']);
								
								
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									DB::delete(__CLASS__,"id=".$id);
									api_post(array('a'=>'delete','table'=>'article','id'=>$id,'pre_key'=>'id'));
								}else{									
									DB::update(__CLASS__,$arr,"id=".$id);
									api_post(array('a'=>'update','table'=>'article','data'=>$arr,'pre_key'=>'id','id'=>$id));	
								}
							}
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
					}
					
				$size = 30;
				$start = ($_G['page']-1)*$size;
				$url ='';
				$and = '';
				
				if($_GET[search]==1){					
					$url.="&search=1";
				}				
				
				if(isset($_GET['cate']) && $_GET['cate']){
					$cate = intval($_GET['cate']);
					$and .=" AND cate = $cate ";
					$url.="&cate=".$cate;
				}
				
				if($_GET['title']){
					$title = trim($_GET['title']);
					$and.=" AND `title` LIKE '%".$title."%'";
					$url.="&title=".urlencode_utf8($title);
				}
				
				
				if(isset($_GET['hide']) && $_GET['hide']>0){
					$hide = intval($_GET['hide']);
					$and .= $hide == 2 ?  " AND `hide` =0" :  " AND `hide` =1";
					$url .= "&hide=".$hide;
				}
				
				if(isset($_GET['picurl']) && $_GET['picurl']>0){
					$picurl = intval($_GET['picurl']);
					$and .= $picurl == 2 ?  " AND `picurl` =''" :  " AND `picurl` !=''";
					$url .= "&hide=".$picurl;
				}
				
				if(isset($_GET['url']) && $_GET['url']>0){
					$a_url = intval($_GET['url']);
					$and .= $a_url == 2 ?  " AND `url` =''" :  " AND `url` !=''";
					$url .= "&hide=".$a_url;
				}
				
				$article = DB::fetch_all("SELECT * FROM ".DB::table('article')." WHERE 1 $and ORDER BY sort DESC,id DESC LIMIT $start,$size");
				
				
				$count = getcount("article",$and);
				$showpage = multi($count,$size,$_G['page'],URL."m=article&a=main".$url);
			

				$this->add(array('article'=>$article,'showpage'=>$showpage,'count'=>$count));
				$this->show('article/main');
		}
		
		function post(){
				global $_G;

					
					if($_GET['onsubmit'] ){
						//dump($_GET,1);
						
									$article = get_filed(__CLASS__,$_GET['postdb'],$_GET['id']);
									$article['hide'] = intval($article['hide']);
									$article['sort'] = intval($article['sort']);
									$article['cate'] = intval($article['cate']);
									$article['views'] = intval($article['views']);								
									if($_FILES[file]){	
											$src = upload();
											if($src)	$article[picurl] = $src;
									}

									if(!$article['keywords'] && $_G[setting][auto_keywords] == 1){
										$article['keywords'] = get_keywords($article['title']);
									}
									if(!$article[description]){
											
											$article[description] = cutstr(trim_html($article[message],1),250,'');
										}
										
									$url = '';
									if($_GET['id']){
										$id = intval($_GET['id']);
										DB::update(__CLASS__,$article,"id=".$id);
										$url = '&id='.$id;
										$msg = '修改';
										api_post(array('a'=>'update','table'=>'article','data'=>$article,'pre_key'=>'id','id'=>$id));	
									}else{
										$msg = '发布';
										$article['dateline'] = TIMESTAMP;
										
										
										
										$r=DB::insert(__CLASS__,$article,true);
										if($r>0) api_post(array('a'=>'insert','table'=>'article','data'=>$article,'id'=>$r));
									}
								cpmsg($msg.'成功','success');
								return false;
					}elseif($_GET['id']) {
						$id = intval($_GET['id']);
						$article =DB::fetch_first("SELECT * FROM ".DB::table("article")." WHERE id = ".$id);
						$article=  dstripcslashes($article);
					}else if(!$_GET[cate]){
						$cate = $_G[__CLASS__.'_cate'];
						$this->add(array('cate'=>$cate));
						$this->show('common_admin/select_post');
						return;
					
					}else{
						$article =get_filed(__CLASS__);
					}
					$this->add(array('article'=>$article));
					$this->show();
		}
		
		function del(){
					global $_G;
					if(!$_GET['id']){ 
						cpmsg('抱歉,要删除的文章ID不存在','error',"m=article&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前文章吗?删除后不可恢复?','error',"m=article&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=article&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("article","id=".$id);
						api_post(array('a'=>'delete','table'=>'article','id'=>$id,'pre_key'=>'id'));
						cpmsg('删除成功','success',"m=article&a=main");
						return false;
					}
		}
		
		
				
		//	new cate(分类的类型,数据表名);
		function cate(){
			$cate = new cate(__CLASS__);
			$cate->main();
		}
		function cate_post(){
			$cate = new cate(__CLASS__);
			$cate->post();
		}
		
		function cate_clear(){
			$cate = new cate(__CLASS__);
			$cate->clear();
		}
		function batpost(){
			$cate = new cate(__CLASS__);
			$cate->batpost();
		}
		function cate_del(){
			$cate = new cate(__CLASS__);
			$cate->del();
		}
		
		
}
?>