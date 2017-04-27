<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class duihuan extends app{
	
	
	function main(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
					$page = $_G[page]>1 ? '&page='.$_G[page] : '';
										
					foreach($_GET[ids] as $k=>$v){
						if($_GET[del][$k] ==0) continue;
						$id = intval($v);
						$arr =array();
						$arr['start_time'] = $_GET['start_time'][$k] ? dmktime($_GET['start_time'][$k]) : 0;
						$arr['end_time'] 	= $_GET['end_time'][$k] ? dmktime($_GET['end_time'][$k]) : 0;
						$arr['sort'] =	intval($_GET['sort'][$k]);
						$arr['hide'] =	intval($_GET['hide'][$k]);
						$arr['cate'] =	intval($_GET['cate'][$k]);

						if($_GET['hide_in'] ==1 ) $arr['hide'] =	1;	
						if($_GET['_del_all']==1 && $_GET['del'][$k]){
							DB::delete("duihuan","id=".$id);
						}else{							
							DB::update("duihuan",$arr,"id=".$id);
						}
					}

					cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$page);
					return false;
				}

				
				$url ='';
				$and = '';
			if(isset($_GET['cate'])){
					$cate = intval($_GET['cate']);
					$and .=  " AND `cate` =".$cate;	
					$url .= "&cate=".$cate;
			}
			$goods = D(array('table'=>'duihuan','and'=>$and,'order'=>' `sort` DESC,id DESC '),array('size'=>40,'url'=>$url));
			$this->add($goods);	
			$this->show();
	}

	function post(){
			global $_G;
				$goods_id = '';
			if($_GET[goods_id] && $_GET[get_submit]){
				 $goods_id =get_goods_id($_GET['goods_id']);
				 if(!$goods_id) {
						cpmsg('商品ID或链接不存在或填写错误');
						 return false;
				  }
				
				 
				
				 $gd = top('goods','get_goods',$goods_id);
				 
				 $goods_id = $gd[num_iid];
				 $goods = get_filed('duihuan');
				 unset($gd[num],$gd[sum],$gd[hide],$gd[shopid]);
				 $gd[price] = $gd[yh_price];
				 foreach($gd as $k=>$v){
					 $goods[$k] = $v;
				 }

				
			}elseif($_GET[onsubmit] && check()){
					$arr = get_filed('duihuan',$_GET[postdb],$_GET[id]);

					 
					if($_FILES[file]){	
						$src = upload();
						if($src)	$arr[picurl] = $src;
					}
					unset($arr[id]);
					if($_GET[id]>0){

						$id = intval($_GET[id]);
						DB::update('duihuan',$arr,' id = '.$id);
						cpmsg('编辑兑换商品成功','success','m='.__CLASS__.'&a='.__FUNCTION__.'&id='.$id);
						return false;
					}else{
						if(!$arr['content'] ){
								 $message = top('m_taobao','get_message',$arr[num_iid],true);	
								if($message)		$arr['content']	  = $message;		
						}
						
						$arr['dateline'] = TIMESTAMP;
						DB::insert('duihuan',$arr);
						cpmsg('发布兑换商品成功','success');
						return false;
					}

			}elseif($_GET[id]>0){
				$id = intval($_GET[id]);
				$goods = D(array('table'=>'duihuan','and'=>'id='.$id));
				if(!$goods['content']){	 
								 $message = top('m_taobao','get_message',$goods[num_iid]);		
								
								if($message)		$goods['content']	  = $message;		
								
				}
			}else{
				$goods = get_filed('duihuan');
			}
			
			$this->add(array('goods'=>$goods,'goods_id'=>$goods_id));	
			$this->show();
	}
	
	function apply(){
		global $_G;
		if($_GET['onsubmit'] && check() ){
					$page = $_G[page]>1 ? '&page='.$_G[page] : '';
										
					foreach($_GET[ids] as $k=>$v){
						if($_GET[del][$k] ==0) continue;
						$id = intval($v);
						$arr =array();

						if($_GET['status'][$k] != $_GET['org_status'][$k]){
							$arr['status'] =	intval($_GET['status'][$k]);
						}
						if($_GET['in_status']!=''){
							$arr['status'] =	intval($_GET['in_status']);
						}
						
						if($_GET['_del_all']==1 && $_GET['del'][$k]){
							DB::delete("duihuan_apply","id=".$id);
						}else{
							if($arr){
								$arr['statustime'] = TIMESTAMP;
								DB::update("duihuan_apply",$arr,"id=".$id);
							}
						}
					}

					cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$page);
					return false;
				}

				
				$url ='';
				$and = '';
		
			
			if($_GET[id]>0){
				$id = intval($_GET[id]);
				$and.=" AND duihuan_id=".$id;
				$url.="&duihuan_id=".$id;
			}
			if(isset($_GET[status])){
				$status = intval($_GET[status]);
				$and.=" AND status=".$status;
				$url.="&status=".$status;
			}

			if(isset($_GET[uid])){
				$uid = intval($_GET[uid]);
				$and.=" AND uid=".$uid;
				$url.="&uid=".$uid;
			}
			
		
			$goods = D(array('table'=>'duihuan_apply','and'=>$and,'order'=>' id DESC '),array('size'=>40,'url'=>$url));

			$this->add($goods);	
			
			$this->show();
		
	}
	
	function setting(){
		global $_G;
				global $_G;
				if($_GET['onsubmit'] && check() ){
					insert_setting();
					cpmsg('修改成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
					return false;
				}
				if($_G['setting']['duihuan_status'] && is_array($_G['setting']['duihuan_status'])){
					$_G[setting]['duihuan_status'] = implode(',',$_G[setting]['duihuan_status']);
				}
				
			$this->show();
		
	}
	
	function apply_edit(){
		global $_G;
				global $_G;
				if($_GET['onsubmit'] && check() ){
					
					
						$id = intval($_GET[id]);
						$arr = get_filed('duihuan_apply',$_GET[postdb],$_GET[id]);

						$arr['status'] =	intval($_GET['postdb']['status']);
						$org_status =	intval($_GET['org_status']);
						
						if($arr[status]){
							$arr['statustime'] = TIMESTAMP;							
						}
					DB::update("duihuan_apply",$arr,"id=".$id);
					cpmsg('修改成功','success','m='.__CLASS__.'&a='.__FUNCTION__.'&id='.$id);
					return false;
				}
			$id = intval($_GET[id]);
			if(!$id){
				cpmsg('id不能为空','error');
				return false;
			}
			$and = ' AND id = '.$id;
			$goods = D(array('table'=>'duihuan_apply','and'=>$and));
			

			$this->add(array('goods'=>$goods,'referer'=>dreferer()));	
			$this->show();
		
	}
	
	
	
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

