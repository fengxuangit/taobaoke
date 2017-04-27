<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class comment extends app{
	

	function main(){
					global $_G;

				if($_GET['onsubmit'] && check() ){
						foreach($_GET[ids] as $k=>$v){
							$id = intval($v);
							if($_GET[del][$k] ==0) continue;
							if($_GET['_del_all']==1 && $_GET['del'][$k]){
								DB::delete(__CLASS__,"id=".intval($id));
							}
						}
						cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
						return false;
				}
					
				
				
				$url ='m='.__CLASS__.'&a='.__FUNCTION__;
				$and = '';
				if($_GET['uid']){
					$uid = intval($_GET[uid]);
					$and .= " AND uid =".$uid;
					$url.="&uid=".$uid;
				}
				
				if($_GET['username']){
					$username = urldecode_utf8(trim($_GET[username]));

					$and .= " AND username ='".$username."'";
					$url.="&username=".urlencode_utf8($username);
				}
				if(isset($_GET['is_reply'])){
					$is_reply = intval($_GET[is_reply]);
					$and .= " AND is_reply =".$is_reply;
					$url.="&is_reply=".$is_reply;
				}
				if(($_GET['type_id'])){
					$type_id = intval($_GET[type_id]);
					$and .= " AND type_id =".$type_id;
					$url.="&type_id=".$type_id;
				}
				if($_GET['type'] && array_key_exists($_GET['type'],$_G[setting][comment_types])){
					$type = trim($_GET[type]);
					$and .= " AND type ='$type'";
					$url.="&type=".$type;
				}
				if(($_GET['reply_id'])){
					$reply_id = intval($_GET[reply_id]);
					$and .= " AND reply_id =".$reply_id;
					$url.="&reply_id=".$reply_id;
				}
				
				if($_GET['ip']){
					$ip = trim($_GET[ip]);
					$and .= " AND ip ='".$ip."'";
					$url.="&ip=".$ip;
				}
				
				if($_GET[type] && array_key_exists($_GET[type],$_G[setting][comment_types])){
					$type = addslashes(trim($_GET[type]));
					$and .= " AND type='$type'";
					$url.="&type=".$type;
				}
				
				$rs = D(array('table'=>__CLASS__,'and'=>$and,'order'=>' id DESC'),array('url'=>$url,'size'=>40));
				
				
				$this->add($rs);
				$this->show('comment/main');
	}
	

	function del(){
			  global $_G;
			  if(!$_GET['id']){
				   cpmsg('抱歉,要删除的评论ID不存在','error',"m=comment&a=main");
				   return false;
			  }
			  $id = intval($_GET['id']);
			  if(!$_GET['ok']){
				  cpmsg('您确定要删除当前评论记录吗?删除后不可恢复?','error',"m=comment&a=del&ok=1&id=".$id,'确定删除',
						  "<p><a href='".URL."m=comment&a=main'>取消</a></p>");
			  }else{
				  $rs = DB::fetch_first("SELECT * FROM ".DB::table('comment')." WHERE id = ".$id);
				  if($rs[jf]>0){
					  $jf = 0-$rs[jf];
					  $org_jf = DB::fetch_first(" SELECT jf FROM ".DB::table('member')." WHERE uid = ".$rs[uid]);
					  $del= array('desc'=>'删除评论扣除积分','type'=>'comment','org_jf'=>$org_jf[jf],'jf'=>$jf,'uid'=>$rs[uid],'username'=>$rs[username]);
					  insert_sign($del);
					  update_member(array('jf'=>$org_jf[jf]+$jf),$rs[uid]);
				  }
				  DB::delete("comment","id=".$id);
				  cpmsg('删除成功','success',"m=comment&a=main");
				  
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
		function check(){
			$check = intval($_GET[check]);		
			ajax_check(__CLASS__,array('check' => $check),'id='.intval($_GET[id]));

				
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
	
}
?>

