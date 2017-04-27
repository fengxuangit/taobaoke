<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class login extends app{


		function main(){

				global $_G;
				$message='';
				$ip = str_replace('.','_',$_G[clientip]);
				$time = $_SESSION[$ip.'_time'] ? TIMESTAMP-$_SESSION[$ip.'_time'] :0;		
				
				
				if( $_GET[username]&& $_GET[login_submit] && check()){
					
							if($_SESSION[$ip]>=5){									
								if($time<=0){
									$old_time = intval(0-$time/60);
									$message="由于您的密码重试次数太多,您的IP已被禁止,您可在".$old_time.'分钟后重新登录';
									$this->add(array('message'=>$message));			
									$this->show();
									exit;
								}else{
									unset($_SESSION[$ip]); 
									unset($_SESSION[$ip.'_time']);
								}
							}							

							$username = (trim($_GET[username]));
							$password = (trim($_GET[password]));		
				
							$user = getuser($username,'username');
							
						
							 if($user[uid]>0 ){								   
									//authcode($user[password],'decode',$user['key']) ==$password
									$pw =md5(md5($password).$user['key']);
									if($user[password] == $pw){
											$update = array('login_time'=>TIMESTAMP,'login_ip'=>$_G['clientip'],'login_count'=>$user[login_count]+1);
											$_G[member] = $user;
											$_G[member][group] = $_G[group][$user[groupid]];
											$_G[uid] = $user[uid];
											$id  =$_G[groupid] =$user[groupid];

											if($user[groupid] != 1 && $_G[group][$id]['login_admin'] != 1 ){
												//权限验证
														$message = '您所在用户组无权登录后台';
														$this->add(array('message'=>$message));			
														$this->show();
														exit;											
											}
											if($user[groupid] ==1) $_G[adminid] =1;
											$_G[username] =  $user[username];
											
											//登录成功
											$auth = authcode($user[uid].'|'.$user[password],'encode','',86400*30);
											DB::update('member',$update,"uid=".$user[uid]);
											dsetcookie("auth",$auth,86400*30);
											$_SESSION['auth']=$auth;
											unset($_SESSION[$ip]); 
											unset($_SESSION[$ip.'_time']);
											
											$url = URL;								
											 header("Location:".$url);									 
											 echo '<script type="text/javascript">window.location.href = "'.$url.'";</script>';	
											exit;
									}
							}
							
								$message = '用户不存在或密码不正确';
								if(!$_SESSION[$ip]) $_SESSION[$ip] = 0;
								$_SESSION[$ip]+=1;
								if($_SESSION[$ip]>=5){
									 $message="由于您的密码重试次数太多,您在30分钟禁止登录";
									 $_SESSION[$ip.'_time'] = TIMESTAMP+1800;
								}else if($_SESSION[$ip] >2 && $_SESSION[$ip]<5){
									 $message ="您还有".(5-$_SESSION[$ip]).'次机会,否则您将会在30分钟禁止登录';
								}
				}
				$_G['title'] = '欢迎登录优淘TAE后台';
				$this->add(array('message'=>$message));
				$this->show();
			
		}
		
		function logout(){
			logout();
			msg('退出登录成功','success','m=login');
		}
		
		
}
?>