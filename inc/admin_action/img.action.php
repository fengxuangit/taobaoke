<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class img extends app{
	
		
		
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
								$arr['like']			= 	intval($_GET['like'][$k]);	
								$arr['hate']			= 	intval($_GET['hate'][$k]);	
								$arr['hide']		= 	$_GET['hide'][$k] ? 1 :0;	
								$arr['sort']		= 	$_GET['sort'][$k] ? intval($_GET['sort'][$k]) :0;	
								$arr['cate']			= 	intval($_GET['cate'][$k]);	
								if($_GET['cates'] > 0){
									$arr['cate'] = intval($_GET['cates']);
								}
							
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									DB::delete(__CLASS__,"id=".$id);
								}else{									
									DB::update(__CLASS__,$arr,"id=".$id);
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
				
				if(isset($_GET['from_url']) && $_GET['from_url']){
					$from_url = (trim($_GET['from_url']));
					$and.=" AND `from_url` LIKE '%".$from_url."%'";
					$url.="&from_url=".urlencode_utf8($from_url);
				}
				
				if($_GET['from_name']){
					$from_name = trim($_GET['from_name']);
					$and.=" AND `from_name` LIKE '%".$from_name."%'";
					$url.="&from_name=".urlencode_utf8($from_name);
				}
				
				if($_GET['keywords']){
					$keywords = trim($_GET['keywords']);
					$and.=" AND `keywords` LIKE '%".$keywords."%'";
					$url.="&keywords=".urlencode_utf8($keywords);
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
				
				if(isset($_GET['cate']) && $_GET['cate']>0){
					$cate = intval($_GET['cate']);
					$and .=  " AND `cate` =".$cate;
					$url .= "&cate=".$cate;
				}
				
				if(isset($_GET['url']) && $_GET['url']>0){
					$a_url = intval($_GET['url']);
					$and .= $a_url == 2 ?  " AND `url` =''" :  " AND `url` !=''";
					$url .= "&hide=".$a_url;
				}
				
				$img = DB::fetch_all("SELECT * FROM ".DB::table('img')." WHERE 1 $and ORDER BY sort DESC,id DESC LIMIT $start,$size");
				foreach($img as $k=>$v){
					$img[$k] = parse('img',$v);
				}
				
				$count = getcount("img",$and);
				$showpage = multi($count,$size,$_G['page'],URL."m=img&a=main".$url);
			
				$tag = isset($_GET['tag']) ? intval($_GET['tag']) : -1;
				$this->add(array('img'=>$img,'showpage'=>$showpage,'count'=>$count,'tag'=>$tag));
				$this->show('img/main');
		}
		
		function post(){
			global $_G;

					
					if($_GET['onsubmit'] ){
									$img = get_filed(__CLASS__,$_GET['postdb'],$_GET['id']);
									$img['hide'] = intval($img['hide']);
									$img['sort'] = intval($img['sort']);
									
									$img['like'] = intval($img['like']);	
									$img['hate'] = intval($img['hate']);							
									if($_FILES[file]){	
											$src = upload();
											if($src)	$img[picurl] = $src;
									}
									
									if(!$img['keywords'] && $_G[setting][auto_keywords] == 1){
										$img['keywords'] = get_keywords($img['title']);
									}
									if(preg_match("/^[0-9\.]+$/is",$img[description]))$img[description] = '';
									if(!$img[description]){
										$tmp =preg_replace("/###\{(.*?)\}###/is",'',$img[message]);
										$img[description] = trim(cutstr(trim_html($tmp),250,''));
									}
									if(!$img[picurl] && preg_match("/<img.*?src=\"http:(.*?)\"/is",$img[message],$img_arr)){
										if($img_arr[1])$img[picurl] = "http:".$img_arr[1];
									}
									
									

									$url = '';
									if($_GET['id']){
										$id = intval($_GET['id']);
										DB::update(__CLASS__,$img,"id=".$id);
										$url = '&id='.$id;
										$msg = '修改';
									}else{
										$msg = '发布';
										$img['dateline'] = TIMESTAMP;
										
										if(!$img[description]) $img[description] = cutstr(trim_html($img[message]),250,'');
										$r=DB::insert(__CLASS__,$img,true);
									}
								cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
								return false;
					}elseif($_GET['id']) {
						$id = intval($_GET['id']);
						$img =DB::fetch_first("SELECT * FROM ".DB::table("img")." WHERE id = ".$id);
						$img=  dstripcslashes($img);
					}else{
						$img =get_filed(__CLASS__);
					}
					$this->add(array('img'=>$img));
					$this->show();
		}
		
		function del(){
					global $_G;
					if(!$_GET['id']){ 
						cpmsg('抱歉,要删除的值得买ID不存在','error',"m=img&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前值得买吗?删除后不可恢复?','error',"m=img&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=img&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("img","id=".$id);
						cpmsg('删除成功','success',"m=img&a=main");
						return false;
					}
		}
		
		
		//	new cate(分类的类型,数据表名);
	
		function cate(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->main();
		}
		function cate_post(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->post();
		}
		
		function cate_clear(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->clear();
		}
		function batpost(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->batpost();
		}
		function cate_del(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->del();
		}
		
}
?>