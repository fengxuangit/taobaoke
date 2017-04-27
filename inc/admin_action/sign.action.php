<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class sign extends app{
	

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
					
				
				$size = 30;
				$start = ($_G['page']-1)*$size;
				$url ='';
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
				if($_GET['ip']){
					$ip = trim($_GET[ip]);
					$and .= " AND ip ='".$ip."'";
					$url.="&ip=".$ip;
				}
				
				if($_GET['jf_down']){
					$jf_down = intval($_GET[jf_down]);
					$and .= " AND org_jf >='".$jf_down."'";
					$url.="&jf_down=".$jf_down;
				}
				if($_GET['jf_up']){
					$jf_up = intval($_GET[jf_up]);
					$and .= " AND org_jf <='".$jf_up."'";
					$url.="&jf_up=".$jf_up;
				}
				

				
			
								
				if($_GET[type] && array_key_exists($_GET[type],$_G['setting']['jf_type'])){
					$type = addslashes(trim($_GET[type]));
					$and .= " AND type='$type'";
					$url.="&type=".$type;
				}		
				
				$sign_list =DB::fetch_all("SELECT * FROM ".DB::table(__CLASS__)." where 1 $and  ORDER BY id DESC LIMIT $start,$size");	
				$count = getcount(__CLASS__,$and);
				$showpage = multi($count,$size,$_G[page],URL."m=sign&a=main".$url);
				foreach($sign_list as $k=>$v){
					$sign_list[$k][username_url] = urlencode_utf8($v[username]);
				}
				
				$this->add(array('count'=>$count,'sign_list'=>$sign_list,'showpage'=>$showpage));
				$this->show('sign/main');
	}
	

	function del(){
					global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要删除的签到ID不存在','error',"m=sign&a=main");
						 return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前签到记录吗?删除后不可恢复?','error',"m=sign&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=sign&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("sign","id=".$id);
						cpmsg('删除成功','success',"m=sign&a=main");
						return false;
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


		function yaoqing(){
					global $_G;
					if($_GET['onsubmit'] && check() ){
				
						foreach($_GET['ids'] as $k=>$v){
							$id = intval($v);
							if($_GET[del][$k] ==0) continue;
							if($_GET['_del_all']==1 && $_GET['del'][$k]){
								DB::delete(__FUNCTION__,"id=".intval($id));
							}
						}
						cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
					}
					$and ='';
					$url = 'm=sign&a=yaoqing';
					$rs = D(array('table'=>'yaoqing','and'=>$and,'order'=>'id DESC'),array('size'=>40,'url'=>$url));
					$platform = array(0=>'',1=>'pc',2=>'android',3=>'ios',4=>'weixin',5=>'wap iphone',6=>'wap android',7=>'wap');

					foreach($rs['goods'] as $k=>$v) {
						if($v['t_uid']>0){
							$rs['goods'][$k]['t_username'] = DB::result_first("SELECT username FROM ".DB::table('member')." where uid=".$v['t_uid']);
						}
						
						if($v['uid']>0){
							$rs['goods'][$k]['username'] = DB::result_first("SELECT username FROM ".DB::table('member')." where uid=".$v['uid']);
						}
						$rs['goods'][$k]['platform_text'] = $platform[$v['platform']];
						$rs['goods'][$k]['reg_platform_text'] = $platform[$v['reg_platform']];
						

					}

					$this->add($rs);
					$this->show();
		}
		

	
}
?>

