<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class brand extends app{
		function __construct(){
			global $_G;
			$rs = loadcache('brand_cate');
			if(!$rs)loadcache('brand_cate','update');
			$_G['brand_cate'] = $_G['cache']['brand_cate'];
			
		}

		function main(){
				global $_G;

				if($_GET['onsubmit'] && check() ){											
						foreach($_GET[ids] as $k=>$v){
							if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['sort'] 	=		intval($_GET['sort'][$k]);
								$arr['cate'] 	=		intval($_GET['cate'][$k]);
								$arr['tui'] 	=		intval($_GET['tuis'][$k]);
								$arr['picurl'] 	=		trim($_GET['picurls'][$k]);


								if($_GET['cate_in']!='-1') 		$arr['cate'] 	=		intval($_GET['cate_in']);
								
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									DB::delete('brand',"id=".intval($id));
								}else{
									DB::update('brand',$arr,"id=".$id);
								}
							}
							loadcache("brand",'update');
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
				}
				
			
				$and  = '';
				$url = 'm=brand&a=main';
				if($_GET['cate']){
					$cate = intval($_GET[cate]);
					$and .=" AND cate = ".$cate;
					$url.="&cate=".$cate;
				}

				$rs = D(array('table'=>__CLASS__,'and'=>$and,'order'=>' `sort` DESC ,id DESC  '),array('size'=>30,'url'=>$url));
				foreach($rs['goods'] as $k=>$v){
					$rs['goods'][$k]['count'] = getcount('goods','brand_id='.$v['id']);
				}


				$this->add($rs);
				$this->show('brand/main');
				
		}
		

		function post(){
					global $_G;
					
					
					$goods_id = '';
					
					if($_GET['onsubmit'] && check() ){
						
						$brand = get_filed(__CLASS__,$_GET['postdb'],$_GET[id]);
						
						if($_FILES[file]){	
								$src = upload();
								if($src)	$brand['picurl'] = $src;
						}

						$url = '';
						if($_GET['id']){
							$id = intval($_GET['id']);
							DB::update(__CLASS__,$brand,'id='.$id);
							$url = '&id='.$id;
							$msg = '修改';
						}else{
							$msg = '添加';
							$brand['dateline'] =TIMESTAMP;
							DB::insert(__CLASS__,$brand);
						}
						loadcache("brand",'update');
						cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
						return false;
					
					}elseif($_GET['id']) {
						$id = intval($_GET['id']);
						$brand = DB::fetch_first("SELECT * FROM ".DB::table(__CLASS__)." WHERE id = $id ");
					}else{
						$brand = get_filed(__CLASS__);
					}					
					$this->add(array('brand'=>$brand));					
					$this->show();
		}




		function del(){
					global $_G;
					if(!$_GET['id']) {
						cpmsg('抱歉,要删除的店铺ID不存在','error',"m=brand&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前店铺吗?删除后不可恢复?','error',"m=brand&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=brand&a=main'>取消</a></p>");
						return false;
					}else{
											
						DB::delete("brand","id=".$id);

						cpmsg('删除成功','success',"m=brand&a=main");
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