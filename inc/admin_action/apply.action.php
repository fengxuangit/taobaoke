<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class apply extends app{
	
		
		
		function main(){
				global $_G;
				
				
				if($_GET['onsubmit'] && check()  && !$_GET[search]){
					$page = $_G[page]>1 ? '&page='.$_G[page] : '';
					foreach($_GET[ids] as $k=>$v){
								if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['start_time'] = dmktime($_GET['start_time'][$k]);
								$arr['end_time'] = dmktime($_GET['end_time'][$k]);
								$arr['fid'] = intval($_GET['fids'][$k]);
								$arr['title'] = trim($_GET['titles'][$k]);
								$arr['yh_price'] = fix($_GET['yh_prices'][$k],1);
								$arr['sum'] = intval($_GET['sums'][$k]);
								$arr['cate'] = intval($_GET['cates'][$k]);
								$arr['check'] = intval($_GET['check_es'][$k]);
								$arr['check_msg'] = trim($_GET['check_msgs'][$k]);
								
								if(($_GET['checks_in'] !='-1')) $arr['check'] =	intval($_GET['checks_in']);
								if($_GET['in_fid']) $arr['fid'] = intval($_GET['in_fid']);
								
								

								if(	$_GET['cate_in'] != '-1') $arr['cate'] = intval($_GET['cate_in']);
								if(	trim($_GET['msgs'])) $arr['check_msg'] = trim($_GET['msgs']);
								
								if($_GET['start_time_in'] && dmktime($_GET['start_time_in'])>0){
									$arr['start_time'] = dmktime($_GET['start_time_in']);
								}
								if($_GET['end_time_in'] && dmktime($_GET['end_time_in'])>0){
									$arr['end_time'] = dmktime($_GET['end_time_in']);
								}
								
								if($arr['check'] == 1) $arr['check_msg'] = '';
								
								if($_GET['_del_all']==1 && $_GET['del'][$k]){
									DB::delete("apply","id=".intval($id));
								}else{
									DB::update("apply",$arr,"id=".$id);
								}
								if($arr['check'] ==1 ){
									//添加新商品
									$rs = DB::fetch_first("SELECT * FROM ".DB::table('apply')." WHERE id = ".$k);
									$rs['flag'] =	intval($_GET['flag_in']);
									unset($rs['check'],$rs['uid'],$rs['name'],$rs['qq'],$rs['phone'],$rs['check_msg'],$rs['id']);
									$rs['status'] = 1;
									top('goods','insert',$rs);
								}else {									
									//删除
									$num_iid = $_GET['num_iids'][$k];
									DB::delete('goods',"num_iid='".$num_iid."'");									
								}
								
								
					}
	
					$this->add(array('goods'=>$goods,'field'=>$field,'bm_status_text'=>$bm_status_text));
					cpmsg('操作成功','success');
					return false;
				}
				
				if(isset($_GET['checks'])){
					$check = intval($_GET['checks']);
					if($check == -1){
						
					}else{
						$and = " AND `check` = ".$check;
						$url.="&checks=".$check;
					}
				}else{
					$check = 0;
					$and = " AND `check` = ".$check;
					$url.="&checks=".$check;
				}
				
				

				$url = '';
				$rs = D(array('and'=>$and,'order'=>'id ASC','table'=>'apply'),array('url'=>URL."m=apply&a=main".$url,'size'=>40));

				if($_G[setting][bm_status_text]){
					if(!is_array($_G[setting][bm_status_text])) {
						$bm_status_text = array();
						$tmp = explode("\r\n",$_G[setting][bm_status_text]);
						foreach($tmp as $k=>$v){
							$v = explode("|",$v);
							$bm_status_text[$v[0]] = array('status'=>$v[0],'name'=>$v[1],'content'=>$v[2]);
						}
					}else{
						$bm_status_text=$_G[setting][bm_status_text];
					}
				}
				
				  $rs[bm_status_text]=$bm_status_text;
				$this->add($rs); 
				$this->show('apply/main');

		}
		

		
		function post(){
				global $_G;
				$a_goods = new goods;
				$a_goods->post();
		}

		function check(){
					global $_G;
					$a_goods = new goods;
					$a_goods->check();
		}
		
		function del(){
					global $_G;
					$page = $_G[page]>1 ? '&page='.$_G[page] : '';					
					$id = intval($_GET['id']);
										
					if(!$_GET['ok']){
						msg('您确定要删除当前商品信息吗?删除后不可恢复?','error',"m=apply&a=del&ok=1&id=".$id.$page,'确定删除',"<p><a href='".URL."m=apply&a=main".$page."'>取消</a></p>");
					}else{						
						DB::delete("apply","id=".$id);
						msg('删除成功','success');
					}
		}
		
		
		function setting(){
				global $_G;
				global $_G;
				if($_GET['onsubmit'] && check() ){
					insert_setting();					
					cpmsg('修改成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
					return false;
				}

			$this->show();
	}
	
		
		
}
?>