<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

include_once libfile('class/fanliBase');

class fanli extends app{
	

	function main(){
				global $_G;

				if($_GET['onsubmit'] && check() ){
						foreach($_GET[ids] as $k=>$v){
							$id = intval($v);
							if($_GET[del][$k] ==0) continue;
							if($_GET['_del_all']==1 && $_GET['del'][$k]){
								DB::delete('order_list',"id=".intval($id));
							}
						}
						cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
						return false;
				}
					
				
				$size = 30;
				$start = ($_G['page']-1)*$size;
				$url ='m=fanli&a=main';
				$and = '';
				if($_GET['uid']){
					$uid = intval($_GET[uid]);
					$and .= " AND uid =".$uid;
					$url.="&uid=".$uid;
				}
				if(isset($_GET['status'])){
					$status = intval($_GET[status]);
					$and .= " AND status =".$status;
					$url.="&status=".$status;
				}

				if(isset($_GET['type'])){
					$type = intval($_GET[type]);
					$and .= " AND type =".$type;
					$url.="&type=".$type;
				}

				$rs =D(array('table'=>'order_list','and'=>$and,'order'=>' id DESC'),array('size'=>40,'url'=>$url));
				$this->add($rs);
				$this->show();
	}
	
	function upload_order(){
			global $_G;
			if($_GET['onsubmit'] ){
					
					//$fanli = new fanliBase();
					//$fanli->init($data);
					if(!$_G['setting']['fanli']) msg('系统未开启购物返积分功能');
					if(!$_FILES['file'])msg('抱歉,您必须提交一个excel文件才能进行批量导入','error');
					$src = upload($_FILES['file'],'web');
					if(!$src)	msg('抱歉,文件上传失败','error');
					$data = load_excel($src,true);
					$success = 0;
					$error = 0;
					foreach($data as $k=>$v){						
						$number = $v[22];
						$status = $v[7];
						if(!$number || !$status) continue;					
						$sql = "SELECT * FROM ".DB::table('order_list')." WHERE order_number = '$number' ";
						$rs = DB::fetch_first($sql);

						if(!$rs['id']) continue;
						//if($rs['status'] >0 ) continue;
						if($rs['status'] ==2 )continue;
								//if(!in_array($v[5],$write_status)) continue;	
								$arr = array();					
								//dump($rs);

								if($status == '订单付款'){									
									if($rs['status'] ==1 ) continue;
									$arr['status'] =1;
									
								}else if($status == '订单结算'){
									if($rs['status'] ==1 ) continue;
									$arr['status'] = 1;
									
								}else if($status == '订单失效'){
									$error ++;
									if($rs['status'] ==1 && $rs['jf']>0){
										//回退积分										
										$result_jf =0-$rs['jf'];	
										$user = DB::fetch_first("SELECT jf,uid,username FROM ".DB::table('member')." WHERE uid = ".$rs['uid']);
										$add_jf = 		$user['jf'] + $result_jf;
										$msg = '订单失效 '.$rs['title']." ,扣除上次奖劢积分".$result_jf;
	
										insert_sign(array('desc'=>$msg,'type'=>'fanli','org_jf'=>$user['jf'],'jf'=>$add_jf,
											'uid'=>$user['uid'],'username'=>$user['username'],'type_id'=>$rs['id'])
										);
										update_member(array('jf'=>$add_jf),$user['uid']);		
										DB::update('order_list',array('status'=>2,'jf'=>0),'id='.$rs['id']);								
										continue;
									}else{
										DB::update('order_list',array('status'=>2,'jf'=>0),'id='.$rs['id']);	
										continue;
									}
								
								}else if($status == '交易成功'){
									if($rs['status'] ==1 ) continue;
									$arr['status'] = 1;
								}else{
									 continue;	
								}
								
								$arr['title'] = $v[1];	
								$arr['num'] = $v[5];	
								$arr['price'] = intval($v[10]);
								//$arr['yongjin'] = $v[11];
								//$arr['bili'] = str_replace(' %','',$v[9]);	
																
								$arr['pingtai'] = $v[20];	
								$num_iid = $arr['num_iid'] = $v[2];	
								$order_number = $number;	
								$arr['create_time'] = dmktime($v[0]);	
								
								//给用户增加返利积分
								$jifen = intval($_G['setting']['order_jf_bili']);
								if($jifen>0){
									$result_jf =$arr['price'] * ($jifen / 100);
									$arr['jf']  = intval($result_jf);
									if($arr['jf']<1) $arr['jf'] = 1;
									$user = DB::fetch_first("SELECT jf,uid,username FROM ".DB::table('member')." WHERE uid = ".$rs['uid']);
									
									$add_jf = 		$user['jf']+$arr['jf'];
									$msg = '通过站点购买 '.$arr['title']." ,消费".$arr['price']."元,系统奖励".$arr['jf']."积分({$jifen}%)";

									insert_sign(array('desc'=>$msg,'type'=>'fanli','org_jf'=>$user['jf'],'jf'=>$arr['jf'],
										'uid'=>$user['uid'],'username'=>$user['username'],'type_id'=>$rs['id'])
									);
									update_member(array('jf'=>$add_jf),$user['uid']);
						
								}
								
								DB::update('order_list',$arr,'id='.$rs['id']);
								$success++;
				
					}
					$msg='更新'.$success.'条记录,失败订单'.$error.'条';
					msg($msg,'success');
					
					

					//cpmsg('导入成功,共发现'.count($data).'条数据,增加成功'.$fanli->count.'条,更新'.$fanli->update.'条','success',"m=fanli&a=upload_order");
					//return false;					
			}
			
			$this->show();
	}
	

	function del(){
					global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要删除的订单ID不存在','error',"m=fanli&a=main");
						 return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前订单记录吗?删除后不可恢复?','error',"m=fanli&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=fanli&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("order_list","id=".$id);
						cpmsg('删除成功','success');
						return false;
					}
	}
	
	
	function del_money(){
				global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要删除的返利ID不存在','error',"m=fanli&a=money");
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前返利记录吗?删除后不可恢复?','error',"m=fanli&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=fanli&a=money'>取消</a></p>");
					}else{
						DB::delete("money","id=".$id);
						cpmsg('删除成功','success');
					}
	}
	
	function search(){
				global $_G;
				if($_GET[onsearch] && check()){
					$this->main();
					return false;
				}
				$this->show();
	}
	
	
		
	function setting(){
			global $_G;

			if($_GET['onsubmit'] && check() ){
				insert_setting();
				cpmsg('修改成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
				return false;
			}
		$this->show();
	}
	
	
	function money(){
				global $_G;

				if($_GET['onsubmit'] && check() ){
						foreach($_GET[ids] as $k=>$v){
							$id = intval($v);
							if($_GET[del][$k] ==0) continue;
							if($_GET['_del_all']==1 && $_GET['del'][$k]){
								DB::delete(__FUNCTION__,"id=".intval($id));
							}
						}
						cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
						return false;
				}
					
				
				$size = 30;
				$start = ($_G['page']-1)*$size;
				$url ='m=fanli&a=money';
				$and = '';
				if($_GET['uid']){
					$uid = intval($_GET[uid]);
					$and .= " AND uid =".$uid;
					$url.="&uid=".$uid;
				}
				if(isset($_GET['status'])){
					$status = intval($_GET[status]);
					$and .= " AND status =".$status;
					$url.="&status=".$status;
				}

				$rs =D(array('table'=>__FUNCTION__,'and'=>$and,'order'=>' id DESC'),array('size'=>40,'url'=>$url));
				$this->add($rs);
				$this->show();
	}
	
	function tixian(){
				global $_G;

				if($_GET['onsubmit'] && check() ){
						foreach($_GET[ids] as $k=>$v){
								if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['status']		= 	intval($_GET['status'][$id]);									
								if($_GET['status_in']!='-1') $arr['status']	 = intval($_GET['status_in']);
								
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									DB::delete(__FUNCTION__,"id=".$id);
								}else{
									$arr['updatetime'] = TIMESTAMP;
									DB::update(__FUNCTION__,$arr,"id=".$id);
								}
						}
						cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
						return false;
				}
					
				$url ='m=fanli&a=tixian';
				$and = '';
				if($_GET['uid']){
					$uid = intval($_GET[uid]);
					$and .= " AND uid =".$uid;
					$url.="&uid=".$uid;
				}
				if(isset($_GET['status'])){
					$status = intval($_GET[status]);
					$and .= " AND status =".$status;
					$url.="&status=".$status;
				}

				$rs =D(array('table'=>__FUNCTION__,'and'=>$and,'order'=>' id DESC'),array('size'=>30,'url'=>$url));
				
					foreach($rs['goods'] as $k=>$v){
						$rs['goods'][$k]['msg_cut'] =  cutstr($v['msg'],30);
					}
				$this->add($rs);
				$this->show();
	}
	
	
	
	
	function del_tixian(){
				global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要删除的返利ID不存在','error',"m=fanli&a=tixian");
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前返利记录吗?删除后不可恢复?','error',"m=fanli&a=del_tixian&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=fanli&a=tixian'>取消</a></p>");
					}else{
						DB::delete("tixian","id=".$id);
						cpmsg('删除成功','success');
					}
	}
	
	function post_tixian(){
			global $_G;
				if(!$_GET['id'])msg('要编辑的id不能为空');
				$url = 'm=fanli&a=post_tixian&id='.$_G['id'];
				if($_GET['onsubmit'] ){
								
					  $url = '';
					  $arr = array();
					  $arr['status'] = intval( $_GET[postdb]['status']);
					  $arr['updatetime'] = TIMESTAMP;
					  $arr['msg'] = $_GET[postdb]['msg'];
					  $id = intval($_GET['id']);
					  DB::update('tixian',$arr,"id=".$id);
					  
					  cpmsg('修改成功','success',$url);

				}else{
					$id = intval($_GET['id']);
					$goods = D(array('table'=>'tixian','and'=>'AND id = '.$id));
				
					
					if(!$goods['id']) msg('未找到要编辑的提现信息');
					$this->add(array('goods'=>$goods));
				}

				
				$this->show();
					
					
	}
	
	
}
?>

