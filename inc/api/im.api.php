<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH.'inc/api/apiBase.class.php';
class api_im extends apiBase{
		public $is_open = true;

		function parse($data){
			return $data;
		}
		function get($uid){
			return $this->get_user($uid);
		}
	    function add($member= array(),$bat = false){
			global $_G;
			$this->use_baichuan();
			if(!class_exists('OpenimUsersAddRequest'))include_once	(ROOT_PATH.'/top/im/OpenimUsersAddRequest.php');	
			
			if(!$bat){
				$user = $this->cover_user($member);
			}else{
				$user = array();
				foreach($member as $k=>$v){
					$user[] = $this->cover_user($v);
				}
			}

			$req = new OpenimUsersAddRequest;
			$req->setUserinfos(json_encode($user));
			$this->resp =  $_G['TOP']->execute($req);
			top_check_error($this->resp);
						
			$count = 0;
			if($this->resp->uid_succ->string){
				$count = count($this->resp->uid_succ->string);
			}else if($this->resp->uid_fail->string){
				$count = count($this->resp->uid_fail->string);
			}else if($this->resp->fail_msg->string){

			}

			return $count;
		}
		
private		function cover_user($member){
				global $_G;
			if(isset($member['username']) && isset($member['userid']) && $user['password']) return $member;
			
			$user = array();
			if(isset($member['uid']) 	&& $member['uid'])				$user['userid']  	= $member['uid'] ;
			if(isset($member['username']) && $member['username'])		$user['nick']  		= $member['username'];			
			if(isset($member['email'])	 && $member['email'])			$user['email']  	= $member['email'] ;
			if(isset($member['phone'])	 && $member['phone'])			$user['mobile']  	= $member['phone'] ;

			if(isset($member['picurl']) && $member['picurl']){
				if(strpos($member['picurl'],'http') === false){
					$member['picurl'] = $_G['siteurl'].$member['picurl'];
				}
				$user['icon_url'] = $member['picurl'];
			}else{
				$user['icon_url'] = 'https://gw.alicdn.com/tps/i3/TB1yeWeIFXXXXX5XFXXuAZJYXXX-210-210.png_100x100.jpg';
			}
			if(!isset($user['password'])){
				$rand = rand(1000,999999);
				$user['password'] = substr(md5($rand),0,10);
			}			
			return $user;
		}
		
		function get_password($uid){
				global $_G;				
				$rs = $this->get_user($uid);
				return $rs['password'];		
		}
		
		function get_user($uid){		
		global $_G;	
		$this->use_baichuan();
			if(!class_exists('OpenimUsersGetRequest'))include_once	(ROOT_PATH.'/top/im/OpenimUsersGetRequest.php');	
			$req = new OpenimUsersGetRequest;
			$req->setUserids($uid);

			$resp =  $_G['TOP']->execute($req);
			top_check_error($resp,true);

			if(!$resp->userinfos->userinfos) return false;
			$user = (array)$resp->userinfos->userinfos[0];

			return $user;				
		}
		
		
		//将站内用户全部同步到云账号,一个站只执行一次就行,在第一次要使用IM时执行.其它时候都会自动同步的
		function bat_add_user(){
			global $_G;
			
			$this->use_baichuan();
			if(!class_exists('OpenimUsersAddRequest'))include_once	(ROOT_PATH.'top/im/OpenimUsersAddRequest.php');	
			$rs = DB::fetch_all("SELECT username,picurl,email,phone,uid FROM ".DB::table('member')." ORDER BY uid DESC");
			$arr = array_chunk($rs,50);
			
			foreach($arr as $k=>$v){
				$this->add($v,true);
			}

			return true;
		}
		
		public function get_guest(){
			global $_G;
			$name ='ip_'.str_replace('.','_',$_G['clientip']);
			return $this->get_user($name);
		}

		public function add_guest(){
				global $_G;
			$user = array();
			$user['uid']  = 'ip_'.str_replace('.','_',$_G['clientip']);
			$user['username']     ='匿名用户';
			$user['picurl'] ='https://img.alicdn.com/sns_logo/T1xEBCFnhXXXb1upjX.jpg_40x40.jpg';


			return  $this->add($user);
			
		}

		public function delete($uids){
			global $_G;
			if(!$uids) return false;
			if(is_array($uids)) $uids = implode(',',$uids);
			$this->use_baichuan();
			if(!class_exists('OpenimUsersDeleteRequest'))include_once	(ROOT_PATH.'/top/im/OpenimUsersDeleteRequest.php');	
			$req = new OpenimUsersDeleteRequest;
			$req->setUserids($uids);
			$resp =$_G['TOP']->execute($req);
			$rs = false;

			if( $resp->result->string[0] == 'ok')$rs = true;
			return $rs;
		}


		
		
		
}

?>