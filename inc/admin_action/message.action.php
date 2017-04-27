<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class message extends app{
		
		function main(){
					global $_G;
					if($_GET['onsubmit'] && check()  && !$_GET[search]){
							foreach($_GET[ids] as $k=>$v){
								if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['check']		= 	$_GET['check'][$k] ? intval($_GET['check'][$k]) :0;									
								if($_GET['checkin']!='-1') $arr['check']	 = intval($_GET['checkin']);
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									DB::delete(__CLASS__,"id=".$id);
								}else{									
									DB::update(__CLASS__,$arr,"id=".$id);
								}
							}
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
					}
					
				$size = 40;
				$start = ($_G['page']-1)*$size;
				$url ='m=message';
				$and = '';
				
				
				if(isset($_GET['check'])){
					$check = intval($_GET['check']);
					$and .= " AND `check` =".$check;
					$url .= "&check=".$check;
				}
				$and .= " AND type = 'message' ";
				
				$rs = D(array('and'=>$and,'order'=>'id DESC','table'=>'message'),array('size'=>$size,'url'=>$url));
				
				$this->add($rs);
				$this->show();
		}
		
		function check(){
			$check = intval($_GET[check]);		
			ajax_check(__CLASS__,array('check' => $check),'id='.intval($_GET[id]));

				
		}
		
		function del(){
					global $_G;
					if(!$_GET['id']){ 
						cpmsg('抱歉,要删除的ID不存在','error');
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前地址吗?删除后不可恢复?','error',"m=message&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=message&a=".CURACTION."'>取消</a></p>");
						return false;
					}else{
						DB::delete("message","id=".$id);
						cpmsg('删除成功','success',"m=message&a=".CURACTION."&page=".$_G['page']);
						return false;
					}
	}
	function feedback(){
					global $_G;
					if($_GET['onsubmit'] && check()  && !$_GET[search]){
							foreach($_GET[ids] as $k=>$v){
								if($_GET[del][$k] ==0) continue;
								$id = intval($v);
								$arr =array();
								$arr['check']		= 	$_GET['check'][$k] ? intval($_GET['check'][$k]) :0;									
								if($_GET['checkin']!='-1') $arr['check']	 = intval($_GET['checkin']);
								if($_GET['_del_all']==1 &&$_GET['del'][$k]){
									DB::delete(__CLASS__,"id=".$id);
								}else{									
									DB::update(__CLASS__,$arr,"id=".$id);
								}
							}
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
					}
					
				$size = 40;
				$start = ($_G['page']-1)*$size;
				$url ='m=message&a=feedback';
				$and = '';
				
				
				if(isset($_GET['check'])){
					$check = intval($_GET['check']);
					$and .= " AND `check` =".$check;
					$url .= "&check=".$check;
				}
				$and .= " AND type = 'feedback' ";
				
				$rs = D(array('and'=>$and,'order'=>'id DESC','table'=>'message'),array('size'=>$size,'url'=>$url));
				
				$this->add($rs);
				$this->show('message/main');
		}
		
		
}
?>