<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
class fanliBase {
			public  $user  = array();
			public  $order = array();
			public  $count = 0;		//共导入成功多少条
			public  $update = 0;	//更新成功多少条
			public  $check_history = false;	//检查浏览记录
			
			function init($data){
					$type = $data[1][2];
					$data = array_slice($data,1);
					if($type == '订单编号'){
						$this->init_ruyitou($data);
					}else if($type == '商品信息'){
						$this->init_taobakke($data);
					}else{						
						msg('上传的数据格式不正确');
					}
					
			}
			
			function init_ruyitou($data){
				$table = get_filed('order_list');
				//创建时间	订单编号	订单状态	效果预估	结算时间	预估收入	成交平台
				$this->check_history = false;
				foreach($data as $k=>$v){	
						if(!$v || !$v[1] ||  !$v[4] || !$v[7] ) continue;						
						//if(!in_array($v[5],$write_status)) continue;	
						$arr = array();						
	
						$arr['yongjin'] = $v[4];						
						$arr['pingtai'] = $v[7];						
						$order_number = $arr['order_number'] = $v[2];	
						$arr['create_time'] = dmktime($v[1]);	
						
						
						$text = $v[3];
						
						//阿里妈妈订单状态
						//  0 = 订单付款  1 =订单结算   2 = 订单失效

						if($text == '订单付款'){
							$arr['status'] =0;
						}else if($text == '订单结算'){
							$arr['status'] = 1;
						}else if($text == '订单失效'){
							$arr['status'] = 2;
						}else{
							 continue;	
						}
						
						//已经导入过的,再导就是更新了
						$rs = DB::fetch_first("SELECT * FROM ".DB::table('order_list')." WHERE  order_number = '$order_number'");

						if($rs['id']>0){							
							$res = $this->update_check($rs,$arr);	
							if($res === true)$this->update++;
							
						}else{							
							if($arr['status'] == 2) continue;	//已经失效的, 就不用入库了.
							$arr['status'] = 1;					//默认,全是待认领
							$arr['dateline'] = TIMESTAMP;
							$arr['id'] = 	DB::insert('order_list',$arr,true);
							//if($arr['status'] == 1){
								unset($arr['status']); 								
								$this->check_order($arr);	
							//}
							$this->count++;
						}
					
											
											
											
				}
			}
			function init_taobakke($data){

				$table = get_filed('order_list');
					
					//创建时间0	商品信息1	商品数2		商品单价3	订单状态4	收入比率5	付款金额6	效果预估7	结算金额8	
					//预估收入9	成交平台10	所属店铺11	结算时间12	补贴金额13	补贴类型14	补贴比率15	商品ID16	订单编号17	分成比率18	第三方服务来源19
					
					//$write_status = array( '订单付款', '订单结算');
					
				foreach($data as $k=>$v){	
						if(!$v || !$v[1] ||  !$v[5] || !$v[6] || !$v[7] ||!$v[18] || !$v[19]) continue;						
						//if(!in_array($v[5],$write_status)) continue;	
						$arr = array();						
						$arr['title'] = $v[2];	
						$arr['num'] = $v[3];	
						$arr['price'] = $v[7];
						$arr['yongjin'] = $v[8];
						$arr['bili'] = str_replace(' %','',$v[6]);	
						
						$arr['pingtai'] = $v[11];	
						$num_iid = $arr['num_iid'] = $v[17];	
						$order_number = $arr['order_number'] = $v[18];	
						$arr['create_time'] = dmktime($v[1]);	
						if($arr['price'] == 0 || $arr['yongjin'] == 0) continue;
											
						
						$text = $v[5];
						
						//阿里妈妈订单状态
						//  0 = 订单付款  1 =订单结算   2 = 订单失效

						if($text == '订单付款'){
							$arr['status'] =0;
						}else if($text == '订单结算'){
							$arr['status'] = 1;
						}else if($text == '订单失效'){
							$arr['status'] = 2;
						}else{
							 continue;	
						}
						
						//已经导入过的,再导就是更新了
						$rs = DB::fetch_first("SELECT * FROM ".DB::table('order_list')." WHERE  order_number = '$order_number'  AND num_iid = '$num_iid' ");
						
						if($rs['id']>0){							
							$res = $this->update_check($rs,$arr);	
							if($res === true)$this->update++;
							
						}else{							
							if($arr['status'] == 2) continue;	//已经失效的, 就不用入库了.
							$arr['status'] = 1;					//默认,全是待认领
							$arr['dateline'] = TIMESTAMP;
							
							$arr['id'] = 	DB::insert('order_list',$arr,true);
							//if($arr['status'] == 1){
								unset($arr['status']); 								
								$this->check_order($arr);	
							//}
							$this->count++;
						}
					}
				
			}
			
			
			
			
			//如果是订单结算.再检查或更新原记录,并分配佣金给用户
						
						
						
			//阿里妈妈订单状态
			//  0 = 订单付款  1 =订单结算   2 = 订单失效
			function update_check($org_order,$new_order){
						
						if(!$org_order || !$new_order) return ;
						
						if($new_order['status'] ==0 ){	//新状态为 订单付款,什么都不做,原始的也不用			
								
										
						}elseif($new_order['status'] ==1 ){		//订单结算
								//如果历史记录为已认领,则不需要再更新了
								//if($org_order['status'] ==3) return ;
							
								//新状态为 订单结算,匹配用户,分配佣金								
								
								//unset($new_order['status']);								
								foreach($new_order as $k1=>$v1){
									$org_order[$k1] = $v1;
								}
								DB::update('order_list',$org_order,'id='.$org_order['id']);
								$this->check_order($org_order);
								//$this->update++;
								return true;
						}elseif($new_order['status'] ==2){
								//新状态为 订单失效 更新数据库中的状态

								//如 已认领 则 
								//1,退回之前的佣金,
								//2,更新现在订单的状态,锁定
								if($org_order['status'] ==3){
									 if($org_order['uid'] >0){
										 $update = array();
										$user = getuser($org_order['uid'],'uid'); 
										
										
										 //追回用户奖劢的积分
										 
										$jf_info = DB::fetch_first("SELECT * FROM ".DB::table('sign')." WHERE uid = ".$org_order['uid'].
										 				" AND aid = ".$org_order['id']." AND type = 'fanli' AND jf>0");										 
										if($jf_info['id']>0){										
												$add_jf = 	$user['jf']-$jf_info['jf'];
												$jf = 0 - $jf_info['jf'];
												//DB::delete('sign',$jf_info['id']);
												
												
												$msg = '您购买 '.$org_order['title']." ,订单已失效,扣除之前所得积分".$jf_info['jf'];
													insert_sign(array('desc'=>$msg,'type'=>'fanli','org_jf'=>$add_jf,'jf'=>$jf,
														'uid'=>$org_order['uid'],'username'=>$org_order['username'],'aid'=>$this->order['id'])
												);
												
												$update['jf'] = $add_jf;										
										}
						
										 
										 
										//追回用户佣金
										$money_info = DB::fetch_first("SELECT * FROM ".DB::table('money')." WHERE order_id = ".$org_order['id']." AND uid = ".$org_order['uid']);
										
										if($money_info && $money_info['money']>0){
												$log = array();										
												$log['desc'] = '订单失效  '.$org_order['title'].',扣除所得返利'.$money_info['money'];										
												$log['org_money'] =$user['money'];
												$log['money'] =  (0-$money_info['money']);
												$log['uid'] = $user['uid'];
												$log['username'] =$user['username'];
												$log['is_add'] = 0;
												$log['order_id'] = $org_order['id'];
												$log['status'] = 3;	
												$this->write_log($log);												
												$dec_money = $user['money'] - $money_info['money'];
												$update['money'] = $dec_money;	
										
										}
										
										if($update)update_member($update,$org_order['uid']);
										
										
										//追回推荐者的佣金										
										if($user['t_uid']>0){
											$tuser = getuser($user['t_uid'],'uid');
											$t_money_info = DB::fetch_first("SELECT * FROM ".DB::table('money')." WHERE order_id = ".$org_order['id']." AND uid = ".$tuser['uid']);
											
											if($t_money_info && $t_money_info['money']>0){
													$log = array();										
													$log['desc'] = '订单失效  '.$org_order['title'].',扣除推荐者所得'.$t_money_info['money'];
													$log['org_money'] =$tuser['money'];
													$log['money'] =(0-$t_money_info['money']);
													$log['uid'] =  $t_money_info['uid'];
													$log['username'] =$t_money_info['username'];
													$log['is_add'] = 0;
													$log['order_id'] = $org_order['id'];
													$log['status'] = 3;	
													$this->write_log($log);												
													$t_dec_money = $tuser['money'] - $t_money_info['money'];
													update_member(array('money'=>$t_dec_money),$t_money_info['uid']);											
											}											
										}									
										
									 }
									 
									
								
								}
								
								 DB::update('order_list',array('status'=>2),'id='.$org_order['id']);
								
						}
				
			}
			
			/*
				1,检查某一个订订单号,该分配给哪位用户.
				
			*/
			function check_order($order){
					global $_G;
					if(!$this->order && !$order) return ;
					$this->order = $order;
					
					$num = substr($this->order['order_number'],-4);
					$user = DB::fetch_all("SELECT * FROM ".DB::table('member')." WHERE order_number = '$num'");
					
					$len = count($user);	
					if($len == 0 || !$user){		//没找到,不管
					
					}else if($len == 1){
								$this->user = $user[0];
								//只有一个用户的,是否要检查这个用户是否浏览过本商品
								if($this->check_history){
										if($this->user['order_list']){
											$list = (array)dunserialize($this->user['order_list']);
											foreach($list as $k=>$v){
												list($id,$time) = explode(',',$v);
												//当前用户的浏览记录中,存在了这个订单记录中的商品,则把这个订单分配给此用户.
												//1个用户,就不用检查时间了												
												if($id == $this->order['num_iid']){
													$this->band_user_order();
													break;
												}
											}
										}		
								}else{
									$this->band_user_order();									
								}
						
					}else if($this->check_history){	//检查记录时才行...
						//有多个用户的,比较时间和商品id
						$index = array();
						// dump($user);
						foreach ($user as $k=>$v){
							  if($user[$k]['order_list']){								  
									  $list = (array)dunserialize($user[$k]['order_list']);									
									  foreach($list as $k1=>$v1){
										  list($id,$time) = explode(',',$v1);
										  //当前用户的浏览记录中,存在了这个订单记录中的商品,则把这个订单临时分配给此用户.
										  if($id == $this->order['num_iid']){
												  // $this->user = $user[$k];
												 // $this->band_user_order();
												 // break;
												 $tmp = array();
												 $tmp['num_iid'] = true;
												 $tmp['time'] = false;												
												 $tmp['index'] = $k;
												 $pay_time = $this->order['create_time'];
												 $jiange_time = $pay_time - $time;
												 												 
												 //2天内下的单
												 if($jiange_time < 86400*2){
														$tmp['time'] =  true; 
												 }
												 $index[] = $tmp;
										  }
									  }
							  }
						}
						
						if($index && count($index) ==1  && $index[0]['time']&& $index[0]['num_iid']){
							$i = $index[0]['index'];							
							$this->user = $user[$i];
							
							$this->band_user_order();
						}
					}
					
			}
			
			/*
				将这个订单,分配给当前用户	
				@ 订单信息
				@ 用户
			*/
			function band_user_order(){
				global $_G;
				if(!$this->user) return ;
				

				//修改订单状态
				$update = array();
				$update['status'] = 3;		//已认领
				$update['uid'] = $this->user['uid'];
				$update['username'] = $this->user['username'];
				DB::update('order_list',$update,'id='.$this->order['id']);
				
				if($this->order['status'] != 1) return ;		// 如果是订单付款,就再继续
				
				//从日志中检查当前用户,是否有返利过				
				$res =  DB::fetch_first("SELECT * FROM ".DB::table('money')." WHERE order_id = ".$this->order['id']." AND uid = ".$this->user['uid']);
				if($res['id']>0) return ;
				
				
				
				
				//给用户增加返利积分
				$jifen = intval($_G['setting']['order_jf_bili']);
				if($jifen>0 && $this->order['price']>0){
						$result_jf = $this->order['price'] * ($jifen / 100);
						$jf  = intval($result_jf);
						if($jf<1) $jf = 1;
						$add_jf = 		$this->user['jf']+$jf;
						$msg = '通过淘客购买 '.$this->order['title']." ,消费".$this->order['price']."元,系统奖励".$jf."积分({$jifen}%)";
						insert_sign(array('desc'=>$msg,'type'=>'fanli','org_jf'=>$add_jf,'jf'=>$jf,
							'uid'=>$this->user['uid'],'username'=>$this->user['username'],'aid'=>$this->order['id'])
						);
						update_member(array('jf'=>$add_jf),$this->user['uid']);
						$this->user = getuser($this->user['uid'],'uid');
						//检查当前用户是否需要升级用户组
				}
				
				$groupid = $this->user['groupid'];

				if(!$groupid || $groupid ==3) return ;	//禁止用户 无法返利
				$group = $_G['group'][$groupid];
				$bili = $group['fanli'];
				
			
				//检查用户积分等级,得出奖劢的佣金比例
				/*$bili = 0;
				foreach($_G['setting']['fanli_bili'] as $k=>$v){
					list($down,$up,$bl) = $v;
					if($this->user['jf']>=$down && $this->user['jf']<$up ){
						$bili = $bl;
						break;
					}
				}*/
				
				//没有找到当前用户所属等级,则不返了....
				if($bili<=0)  return ;
				//dump($bili.'---'.$this->user['groupid'].'---'.$this->user['username']);
				//用户(20)%+推荐人 (10)% +  20%的税 
				
				//将佣金分为4份
				$money = $this->order['yongjin']  - ($this->order['yongjin'] * (20 / 100));		//先扣20%税

				//给用户账户增加佣金
				$member_arr = array();				
				$user_money = $money * ($bili / 100);		//返给用户的实际佣金

				$yingde_money = $money;
				
				//给推荐者返利
				if($this->user['t_uid']>0){
					//扣税后佣金 - 用户所得的  = 站长的, 推荐者,也是分站长的
					 $money = $this->t_fanli($this->user['t_uid'],$money);		//返回 减掉推荐者所得的,就是站长所得
				}


				//剩下的money 就是站长所得的
				if($money<=0) return ;
				$org_money = $this->user['money'];
				$member_arr['money'] = $this->user['money'] + $user_money;				
				update_member($member_arr,$this->user[uid]);
				$this->user['money'] = $member_arr['money'] ;
				
				
				//给佣金表,增加记录,供用户查询		
				$log = array();				
				$log['desc'] = '购物 '.$this->order['title'].' 获得'.$user_money.'元'.'('.$bili.'%)'.'返利';				
				$log['org_money'] =$org_money;
				$log['money'] = $user_money;
				$this->write_log($log);
				
				
			}
			
			/*
					写入佣金记录
					@ 字段数组
			*/
			function write_log($money_arr){
					$arr =  get_filed('money');
					if($this->user){
						$arr['uid'] = $this->user['uid'];
						$arr['username'] = $this->user['username'];
					}
					$arr['status'] = 0	;	//佣金的状态	0=获得购物返利
					$arr['order_id'] = $this->order['id']; 
					$arr['is_add'] = 1;
					$arr['desc'] = '';
					$arr['dateline'] = TIMESTAMP;	
					
					foreach($money_arr as $k=>$v){
						$arr[$k] = $v;
					}
					$id = DB::insert('money',$arr);				
					return $id;
			}
			
			/*
				推荐人返利
				@ 推荐人uid
				@ 原用户应得的金额
				return 原用户应得的金额 - 推荐人的金额 = 站点所得的佣金
			*/
			
			function t_fanli($uid,$money){
					global  $_G;
					
	
					$org_money = $money;
					if($uid == $this->user['uid']){
						$user = $this->user;
					}else{
						$user = getuser($uid,'uid');
					}
					
					//if($user['uid'] == $this->user[uid]) return $money;
					//if($user['t_uid'] && $user['t_uid'] == $this->user[uid]) return $money;		//防止死循环
//4,3,1,1,2
						
					$rank = $user['rank'];
					if(!$rank || !$_G['rank'][$rank]) return $money;

					$group = $_G['rank'][$rank];
					$bili = intval($group['bili']);						//当前推荐者所在推荐的返利比例
				
					if($bili<=0)  return $money;
					$yongjin = fix($money * ( $bili / 100),2);
					$money  = $money- $yongjin;
				
					//给佣金表,增加记录,供用户查询
					$log = array();
					//第'.($k+1).'级
					if(!$this->order['price'] || $yongjin<=0) return $money;
					$log['desc'] = '您推荐的用户'.$this->user['username'].'购物消费,您获得:'.$yongjin.'元('.$bili.'%)';
					
					$add_money = $user['money']+$yongjin;
					update_member(array('money'=>$add_money),$user['uid']);
					
					
					$log['org_money'] =$user['money'];
					$log['money'] = $yongjin;
					$log['status'] = 1;
					$log['uid'] = $user['uid'];
					$log['username'] = $user['username'];
					$this->write_log($log);
					
					//无限上级推荐人返利
					/*if($user['t_uid']>0){
						if($user['t_uid'] == $this->user['uid'] || $user['t_uid'] == $user['uid'])continue;	//防止死循环
						$money =  $this->t_fanli($user['t_uid'],$org_money);
					}*/
			
				return $money;
		}
			
			
}

?>