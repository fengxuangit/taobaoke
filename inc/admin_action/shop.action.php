<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class shop extends app{
		function __construct(){
			global $_G;
			$rs = loadcache('shop_cate');
			if(!$rs)loadcache('shop_cate','update');
			$_G['shop_cate'] = $_G['cache']['shop_cate'];
			
		}

		function main(){
				global $_G;

				if($_GET['onsubmit'] && check() ){											
						foreach($_GET[ids] as $k=>$v){
							if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['sort'] 	=		intval($_GET['sort'][$k]);
								$arr['hide']	= 		intval($_GET['hide'][$k]);
								$arr['cate'] 	=		intval($_GET['cate'][$k]);
								$arr['shop_type'] 	=		intval($_GET['shop_type'][$k]);
								$arr['shop_tag'] 	=	intval($_GET['shop_tag'][$k]);
							
								if($_GET['shop_type_in']!='-1') 		$arr['shop_type'] 	=		intval($_GET['shop_type_in']);
								if($_GET['cate_in']!='-1') 		$arr['cate'] 	=		intval($_GET['cate_in']);
								if($_GET['shop_tag_in']!='-1') 	$arr['shop_tag'] 	=	intval($_GET['shop_tag_in']);
								
								$sid = $_GET['sid'][$k];		
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									api_post(array('a'=>'delete','table'=>'shop','id'=>$sid,'pre_key'=>'sid'));
									DB::delete('shop',"id=".intval($id));
								}else{
									api_post(array('a'=>'update','table'=>'shop','data'=>$arr,'pre_key'=>'sid','id'=>$sid));	
									DB::update('shop',$arr,"id=".$id);
								}
							}
							api_post(array('m'=>'cache','a'=>'update','cache_list'=>'shop_type,shop'));
							loadcache("shop_type",'update');
							loadcache("shop",'update');
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
				}
				
			
				$and  = '';
				$url = 'm=shop&a=main';
				if($_GET['cate']){
					$cate = intval($_GET[cate]);
					$and .=" AND cate = ".$cate;
					$url.="&cate=".$cate;
				}


				if(isset($_GET['shop_type'])){
					$shop_type = intval($_GET[shop_type]);
					$and .=" AND shop_type = ".$shop_type;
					$url.="&shop_type=".$shop_type;
				}

				$rs = D(array('table'=>__CLASS__,'and'=>$and,'order'=>' `sort` DESC ,id DESC  '),array('size'=>30,'url'=>$url));

				$this->add($rs);

				$this->show('shop/main');
				
		}
		

		function post(){
					global $_G;
					
					
					$goods_id = '';
					
					if($_GET['onsubmit'] && check() ){
						
						$shop = get_filed(__CLASS__,$_GET['postdb'],$_GET[id]);
						
						if($_FILES[file]){	
								$src = upload();
								if($src)	$shop[picurl] = $src;
						}

						if($_FILES['pic_path']['tmp_name']){	
								$src = upload($_FILES['pic_path']);
								
								if($src)	$shop[pic_path] = $src;
						}
						

						$url = '';
						if($_GET['id']){
							$id = intval($_GET['id']);

							top('shop','insert',$shop,$id);
							$url = '&id='.$id;
							$msg = '修改';
						}else{
							$msg = '添加';
							$top = top('shop','insert',$shop); 
						}
						
						cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
						return false;
					}elseif($_GET[get_submit] && $_GET['goods_id']) {
						$goods_id =get_goods_id($_GET['goods_id']);						
						if(!$goods_id) {
							cpmsg('抓取失败,商品ID或链接不存在或填写错误','error','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
						}						
						$goods = top('goods','get_goods',$goods_id);
						
						if($goods === false) {
							cpmsg('当前商品未成功获取,可能是商品未上线,请更换当前店铺中的其它一款商品再重试,或是请手动添加');
							return false;
						}
						$query =top('shop','get_shop',$goods['sid']);

						$query[nick] = $goods[nick];
						if($query ===false){
							cpmsg('抱歉,获取失败,请检查用户名是否正确');
							return false;
						}
						foreach($query as $k=>$v){
							$shop[$k] = trim_html($v,1);
						}
						$shop = get_filed(__CLASS__,$shop);
						
					}elseif($_GET['id']) {
						$id = intval($_GET['id']);
						$shop = DB::fetch_first("SELECT * FROM ".DB::table('shop')." WHERE id = $id ");
					}else{
						$shop = get_filed(__CLASS__);
					}					
					$this->add(array('shop'=>$shop,'goods_id'=>$goods_id));					
					$this->show();
		}




		function del(){
					global $_G;
					if(!$_GET['id']) {
						cpmsg('抱歉,要删除的店铺ID不存在','error',"m=shop&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前店铺吗?删除后不可恢复?','error',"m=shop&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=shop&a=main'>取消</a></p>");
						return false;
					}else{
						$sid = DB::result_first("SELECT sid FROM ".DB::table('shop')." WHERE id = ".$id);
						api_post(array('a'=>'delete','table'=>'shop','id'=>$sid,'pre_key'=>'sid','cache'=>'shop,shop_type'));
						
						DB::delete("shop","id=".$id);

						cpmsg('删除成功','success',"m=shop&a=main");
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