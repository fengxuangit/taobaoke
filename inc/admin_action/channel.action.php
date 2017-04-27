<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class channel extends app{
	
		function main(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
					foreach($_GET[fid] as $k=>$v){
						$fid = intval($v);
						$arr =array();
						$arr['sort'] = intval($_GET['sort'][$k]);
						$arr['name'] = trim($_GET['name'][$k]);
						$arr['fup'] =	intval($_GET['fup'][$k]);
						$arr['hide'] = $_GET['hide'][$k] ? 1 :0;
						
						$arr['picurl'] = $_GET['picurl'][$k] ? trim($_GET['picurl'][$k]) :'';
						$arr['url'] = $_GET['url'][$k] ? trim($_GET['url'][$k]) :'';
							$arr['classname'] = $_GET['classname'][$k] ? trim($_GET['classname'][$k]) :'';
							
						DB::update("channel",$arr,"fid=".$fid);
					}
					loadcache("channels",'update');
					loadcache("all_channel",'update');
					cpmsg('修改成功','success','');
					return false;
				}
				if($_G['setting']['main_table'] && array_key_exists($_G['setting']['main_table'],table())){		
					foreach($_G['channels'] as $k=>$v){					
						$_G['channels'][$k]['count'] = getcount($_G['setting']['main_table'],'fid='.$v['fid']);
						if($v['sub']){							
							foreach($v['sub'] as $k1=>$v1){
								$_G['channels'][$k]['sub'][$v1['fid']]['count'] = getcount($_G['setting']['main_table'],'fid='.$v1['fid']);
								if($v1['sub']){
									foreach($v1['sub'] as $k2=>$v2){
										$_G['channels'][$k]['sub'][$v1['fid']]['sub'][$v2['fid']]['count'] = getcount($_G['setting']['main_table'],'fid='.$v2['fid']);
									}
								}
								
							}
						}
					}
				}
				
				$this->add(array('count'=>count($_G[all_channel])));
				$this->show('channel/main');
		}
	
		
		function post(){
				global $_G;
			
				
				if($_GET['onsubmit'] && check() ){
							$arr = array();
							$channel =get_filed(__CLASS__,$_GET['postdb'],$_GET[fid]);
							if($_FILES[file]){	
								$src = upload();
								if($src)	$channel[picurl] = $src;
							}
							$fid = intval($_GET['fid']);
							$url = '';
							
							
							if($_GET['postdb']['cid']>0){
								$channel['cid'] = intval($_GET['postdb']['cid']);
							}else if($_GET['postdb']['fup_cid']>0){
								$channel['cid'] = intval($_GET['postdb']['fup_cid']);
							}
							
							if($_GET[fid]){
								$msg = '修改';
								$url = '&fid='.$fid;
								$id = DB::update('channel',$channel,"fid=".$fid);

							}else{
								$msg = '添加';

								$r = DB::insert('channel',$channel,true);
								if($r>0){
									$channel['fid'] = $r;
								}
							}
							loadcache("channels",'update');
							loadcache("all_channel",'update');
							cpmsg($msg.'成功','success','m=channel&a=post'.$url);
							return false;
							
				}elseif($_GET[fid]){
					$fid = intval($_GET[fid]);
					$channel = $_G[all_channel]['k'.$fid];
					
				}
				$cates = include (libfile('config/taobao_cate'));
				if($channel['cid']>0){
					$cid = $channel['cid'];
					$fup = 0;
					if(!$cates[$cid]){
						foreach($cates as $k=>$v){
							if($v['sub'][$cid]){
								$fup = $k;
								break;
							}
						}
					}
				}
				
				
				$this->add(array('channel'=>$channel,'cates'=>$cates,'fup'=>$fup));
				$this->show();
		}
		
		function del(){
					global $_G;
					
				
					if(!$_GET['fid']) {
						cpmsg('抱歉,要删除的栏目ID不存在','error',"m=channel&a=main");
						return false;
					}
					$fid = intval($_GET['fid']);
					
				
					if(table('goods')){
						$count = getcount("goods","fid=".$fid);
							if($count>0){
								cpmsg('当前栏目下还存在商品信息,请先删除本栏目的所有商品后再删除本栏目','error',"m=channel&a=main");
								return false;
							}
					}
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前栏目吗?删除后不可恢复?','error',"m=channel&a=del&ok=1&fid=".$fid,'确定删除',
								"<p><a href='".URL."m=channel&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("channel","fid=".$fid);
						loadcache("channels",'update');
						loadcache("all_channel",'update');
						cpmsg('删除成功','error',"m=channel&a=main");
						return false;
					}
					
		}
		function clear(){
					global $_G;
					if(!$_GET['fid']){
						 cpmsg('抱歉,要清空的分类ID不存在','error',"m=channel&a=main");
						 return false;
					}
					$fid = intval($_GET['fid']);
					if(!$_GET['ok']){
						$msg = "<p><a href='".URL."m=channel&a=clear&ok=1&all=1&fid=".$fid."'>清空当前栏目</a></p>"; 
						$msg .="<p><a href='".URL."m=channel&a=clear&ok=1&all=2&fid=".$fid."'>清空当前栏目和所有子栏目商品</a></p>";
						cpmsg('您确定要清空当前栏目中的所商品吗?清空后不可恢复?','error',"m=channel&a=main",'取消',$msg);
						return false;
					}else{
						$channel = get_sub($fid);
						if(table('goods')){
								if($_GET['all']==1){
									DB::delete("goods","fid=".$fid);
								}elseif($_GET['all']==2){
									DB::delete("goods","fid in (".$channel[fid_in].")");
								}
						}
						$count = DB::affected_rows();
						loadcache("channels",'update');
						loadcache("all_channel",'update');
						cpmsg('清空成功,共清空'.$count.'条商品','error',"m=channel&a=main");
						return false;
					}
		}
		
		
		function batpost(){
			global $_G;

				if($_GET['onsubmit'] && check() ){
							$channel = get_filed(__CLASS__);

									$all_channel= count($_G['chennels']);
									foreach($_GET['tmp'] as $k=>$v){
										$arr = $channel;									
										if($_GET['fup'][$k]){ //一级栏目
											$arr['name'] = $_GET['fup'][$k];
											$arr['sort'] =$all_channel+($k+1);

											$fup_id= DB::insert(__CLASS__,$arr,true);
											if($fup_id>0){
												$arr['fid'] = $fup_id;
											}
				
										}else{
											$fup_id = $_GET['fup2'][$k] ? intval($_GET['fup2'][$k]) :0;
										}
								
										if($_GET['name'][$k]){
											$sub  = explode(',',$_GET['name'][$k]);
											$sub = array_filter($sub);
											$sub = array_unique($sub);
											
											if($sub){
												foreach($sub as $k1=>$v1){
													$arr2 = $channel;
													if($v1 != $v){
														$arr2['name']=$v1;
														$arr2['fup']=$fup_id;
														$arr2['sort'] = 0;		

														$fid = DB::insert('channel',$arr2,true);
														if($fid>0){
															$arr2['fid'] = $fid;
														}
													}
												}
											}
										}
									
								}
					loadcache("channels",'update');
					loadcache("all_channel",'update');
					cpmsg('批量添加成功','success','m=channel&a=batpost');
					return false;
				}
						
				$this->show();
		}
		
		
}
?>