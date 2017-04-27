<?php
if(!defined('IN_TTAE')) exit('Access Denied');
//ini_set('allow_url_fopen', 'off');
class member extends app{
	private $qq;
	private $weibo;
	public $login_time = 259200;	// 86400 * 3

	function main(){
		global $_G;
		if(isset($_GET['state'])){
			$action  = authcode($_GET['state'],'DECODE');

			if($action){
				$this->$action();
				return ;
			}
		}

		if(isset($_GET['code']) && isset($_GET['state'])){
			$this->qq_load();
		}
		$this->login();
	}




	function weixin_login(){
		global $_G;

		//微信登录需要开发者 有进行开发者认证才能继续...
		$redirect_uri = urlencode($_G['siteurl']);
		if(!$_G[setting][weixin_appkey] || !$_G[setting][weixin_appsecret] ) msg('抱歉,站点未开启微信登录','error','m=member&a=login');
		$appid = $_G['setting']['weixin_appkey'];
		$appsecret = $_G['setting']['weixin_appsecret'];



		if(isset($_GET['code']) && isset($_GET['state'])){
			if($_SESSION['weixin_state_key'] != $_GET['state']) msg('抱歉,CSRF验证失败');
			//get token
			$code = trim_html($_GET['code']);
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
			$rs = fetch($token_url);
			if(!$rs) msg('接口验证失败');
			$data = json_decode($rs,1);
			if($data['errcode']>0 && $data['errmsg']) 	msg( $data['errmsg']);
			$user_id = $data['openid'];		//针对开发者用户唯一id

			//获取用户信息
			$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$data['access_token'].'&openid='.$user_id;
			$rs1 = fetch($url);
			if(!$rs1) msg('获取用户信息失败');
			$info = json_decode($rs1,1);
			if($info['errcode']>0 && $info['errmsg']) msg( $info['errmsg']);

			$arr = array();
			$arr[login_id] =$info[unionid];	//用户的唯一ID
			$arr[address] = $info[province] .$info[city];
			$arr[username] = $info[nickname];
			$arr[set] = intval($info[sex]);
			$arr[groupid] = 23;
			$arr[login_name] = 'weixin';
			$arr[picurl] =$info[headimgurl];
			$this->login_callback($arr);

		}else if($_GET['state'] && !$_GET['code']){
			msg('授权取消');
		}

		$state_key  = authcode('weixin_login','ENCODE');		//防止crfs攻略的随机字符串
		$_SESSION['weixin_state_key'] = $state_key;

		$start_url = "https://open.weixin.qq.com/connect/qrconnect?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_login&state=".$state_key."#wechat_redirect";
		_header("Location:".$start_url);

	}



	function qq_load(){
				global $_G;

				if(!$_G[setting][qq_appid] || !$_G[setting][qq_appkey] ){
					msg('抱歉,站点未开启QQ登录','error','m=member&a=login');
					return false;
				}

				$url = ROOT_PATH.'web/lib/qq_login/';
				require_once($url."qqConnectAPI.php");
				$this->qq = new QC();
				if(isset($_GET['code']) && $_GET['code'] && isset($_GET['state']) && $_GET['state']){
					$access_token  = $this->qq->qq_callback();

					if(!preg_match("/[a-zA-Z0-9]+/s",$access_token)){
						msg('登录失败,错误信息'.$access_token);
						return false;
					}else{
						$id = $this->qq->get_openid();
						$this->qq = new QC($access_token,$id );
						$info =$this->qq->get_user_info();

						if($info[ret]<0) msg('登录错误,错误信息:'.$info[msg]);

						$info[address] = $info[province] .$info[city];
						$info[username] = $info[nickname];
						$info[login_id] =$id;	//用户的唯一ID
						$info[groupid] = 20;
						$info[login_name] = 'qq';
						$picurl  = $info['figureurl_qq_2'] ? $info['figureurl_qq_2']:($info[figureurl_2]?$info[figureurl_2]:'');
						$info[picurl] = $picurl ? $picurl :$info[figureurl_qq_1];


						/*$content = $_G[setting][title].' - 九块九包邮天天有,省钱的行家 -'.$_G['siteurl'];
						$weibo = array('type'=>1,'img'=>urlencode($_G[setting][logo]),'syncflag'=>0,'content'=>$content);
						if(!getcookie('qq_weibo')){
							$ret = ($this->qq->add_t($weibo));
							if($ret[data][id]) dsetcookie('qq_weibo',1,86400*2);
						}
						*/

						$this->login_callback($info);
					}
				}else{
					$this->qq->qq_login();
				}
				return $this->qq;
	}
	function qq_login(){
				if($_G[uid]) msg('您已登录,请退出后再进行操作','error');
				$this->qq_load();
	}
	private function login_callback($arr){
				global $_G;
				if(!$arr) msg('抱歉,登录信息不能为空','error');
				if(!$arr['username']) msg('抱歉,用户名不能为空','error');
				$arr['username'] =trim_html($arr['username']);
				$user = getuser($arr['login_id'],'login_id');
				$arr['username'] =filter_utf8_char($arr['username']);

				//$uname = mysql_real_escape_string($uname);
				if($user['uid']>0){

							if($user[groupid] ==3){
										msg('抱歉,您的账户已禁止,无法登录,如有疑问,请联系客服','error');
										return false;
							}elseif($user[login_name] != $arr[login_name]){
										msg('抱歉,登录失败,登录类型不匹配','error');
										return false;
							}else{
										$update = array('login_time'=>TIMESTAMP,'login_ip'=>$_G['clientip'],'login_count'=>$user[login_count]+1);
										if(!$user['login_id'] && $arr['login_id']) $update['login_id'] = $arr['login_id'];
										$auth = authcode($user[login_name].'|'.$user[uid].'|'.$user[username],'encode','',86400 * 3);
										DB::update('member',$update,"uid=".$user[uid]);
										dsetcookie("auth",$auth,$this->login_time);
										 $referer = $_GET['referer'] ? $_GET['referer'] : dreferer();
											if(preg_match("/member/is",$referer))$referer = URL.'m=home';
											$ext = '<script type="text/javascript">
												setTimeout(function(){
													location.href = "'.$referer.'";
												},2000);
											</script>';
											msg('登录成功,欢迎您回来 '.$user[username],'success',$referer,$ext);
										return false;
							}
				}else{

								$user = get_filed('member');
								$user['login_ip'] =$user['regip'] = $_G[clientip];
								$user['t_uid'] = intval(getcookie('t'));
								$user['login_time'] = TIMESTAMP;
								$user['login_count'] = 1;
								$user['regdate'] = TIMESTAMP;
								$user['check'] = 1;
								$user['jf'] = $_G[setting][jf];
								$t = intval(getcookie('t'));
								if($t>0)$user['t_uid'] = $t;


								foreach($arr as $k=>$v){
									if(array_key_exists($k,$user) && $v) $user[$k] = $v;
								}
								$user[uid]=$uid  = 	DB::insert('member',$user,1);
								if($uid>0){
											 $auth = authcode($user[login_name].'|'.$user[uid].'|'.$user[username],'encode','',86400 * 3);
											  dsetcookie("auth",$auth,$this->login_time);
											  if($_G[setting][jf]>0){
												  $jf  	=	 $_G[setting][jf];
												  $sid =insert_sign(array('uid'=>$uid,'username'=>$user['username'],'desc'=>'新会员注册系统奖励','type'=>'system','org_jf'=>$jf,'jf'=>$jf));
											  }



											  $this->check_yaoqing($t,$user);
											 $referer = $_GET['referer'] ? $_GET['referer'] : dreferer();
											if(preg_match("/member/is",$referer))$referer = URL.'m=home';

											$ext = '<script type="text/javascript">
												setTimeout(function(){
													location.href = "'+$referer+'";
												},2000);
											</script>';

											msg('登录成功,欢迎您回来 '.$user[username],'success',$referer,$ext);

											 return false;
								  }

					}
	}


	function weibo_login(){
				global $_G;
				if(!$_G[setting][weibo_appkey] || !$_G[setting][weibo_appsecret] ){
					msg('抱歉,站点未开启微博登录','error','m=member&a=login');
					return false;
				}
				$url = ROOT_PATH.'web/lib/weibo_login/';
				$callback =$_G['siteurl'].URL.'m=member&a=weibo_login';

				include_once( $url.'saetv2.ex.class.php' );
				$o = new SaeTOAuthV2($_G[setting][weibo_appkey], $_G[setting][weibo_appsecret] );
				$code_url = $o->getAuthorizeURL( $callback );


				if (isset($_GET['code']) && $_GET['code']) {
					$keys = array();
					$keys['code'] = ($_GET['code']);
					$keys['redirect_uri'] = $callback;

					try {

						$token = $o->getAccessToken( 'code', $keys ) ;

					} catch (OAuthException $e) {

					}

					if (!$token)  msg('授权失败');
					$_SESSION['token'] = $token;
					setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
					$c = new SaeTClientV2( $_G[setting][weibo_appkey] , $_G[setting][weibo_appsecret] , $_SESSION['token']['access_token'] );
					$ms  = $c->home_timeline(); // done
					$uid_get = $c->get_uid();

					$uid = $uid_get['uid'];
					$info = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息

					if($info[error_code]) msg('登录接口返回错误,错误信息:'.$info[error]);
					if(!$info[id]) msg('获取用户信息失败');

					$member = array('username'=>$info[screen_name],'address'=>$info[location],'content'=>$info[description],
					'picurl'=>$info[profile_image_url],'groupid'=>21,'login_name'=>'weibo','login_id'=>$uid);
					$this->login_callback($member);


				}else{
					header("Location:".$code_url);
					echo '<script type="text/javascript">window.location.href = "'.$code_url.'";</script>';
					exit;
				}
	}

	function taobao_login(){
				global $_G;

				if(!$_G[setting][taobao_appkey] || !$_G[setting][taobao_appsecret]){
					msg('抱歉,系统未开启淘宝登录组件','error','m=member&a=login');
				}

				$callbak_url=$_G[siteurl]."index.php?m=member&a=taobao_login";

				//Web对应PC端（淘宝logo）浏览器页面样式；Tmall对应天猫的浏览器页面样式；Wap对应无线端的浏览器页面样式。
				$wiew = 'web';
				if(MOBILE !== false) $wiew = 'wap';
				if(isset($_GET["state"]) && !empty($_GET["state"])){
						if($_GET[error]){
							$msg = trim_html(urldecode_utf8($_GET[error_description],1));
							msg('登录失败,错误信息:'.$msg,'error','m=member&a=login');
						}

						if( $_GET["state"]!=$_SESSION["tb_state"] ) msg('请求非法或超时!','error','member&a=login');

						$code = trim($_GET["code"]);
						$postfields = array ('grant_type'=>"authorization_code",'client_id' => $_G[setting][taobao_appkey],'client_secret' => $_G[setting][taobao_appsecret],
								'code' => $code,'redirect_uri' => $callbak_url,'view'=>$wiew);
						$url = 'https://oauth.taobao.com/token';					
						$rs = fetch($url,$postfields);
						if(!$rs) msg($_G['msg']);


						$info = json_decode ($rs,1);

						// $psdata = array ('grant_type'=>"refresh_token",'client_id' => $_G[setting][taobao_appkey],'client_secret' => $_G[setting][taobao_appsecret],'refresh_token'=>$info['refresh_token']);
						// $data = fetch($url,$psdata);
						// dump($data,1);

							
						if(!$info['taobao_user_nick'] || !$info[open_uid]){
							msg('获取用户名称或用户ID或失败','error','m=member&a=login');
						}

						$nick = urldecode_utf8($info['taobao_user_nick']);
						$nick = cutstr($nick,2,'***');

						$member = array('username'=>$nick,'address'=>'','content'=>$info[taobao_user_id],
						'picurl'=>'','groupid'=>22,'login_name'=>'taobao','login_id'=>$info[open_uid]);
						$this->login_callback($member);

				}else{
						$state = TIMESTAMP;
						$_SESSION["tb_state"] = $state;
						$url= "https://oauth.taobao.com/authorize";
						$params = array("response_type"	=>"code","client_id"=>$_G[setting][taobao_appkey],"redirect_uri"=>$callbak_url,"state"=>$state
								,'view'=>$wiew	
							);
						foreach($params as $key=>$val){
							$get[] = $key."=".urlencode($val);
						}
						$ret_url = $url."?".join("&", $get);
						header("location:".$ret_url);
				}

	}




	//邮箱验证
	function verify(){
		global $_G;
		if(!$_G[uid]){
			msg('您必须登录后才能进行验证','error','m=member&a=login');
			return false;
		}
		if(!$_SESSION['verify']){
			msg('当前验证已过期,请重新发送验证邮件','error','m=home&a=setting');
			return false;
		}

		if(isset($_GET['key'])){
			$key = trim($_GET['key']).'_'.$_G[uid];
			if($_SESSION['verify'] !=$key){
				msg('您的邮箱验证不正确,如果您由于时间太长导至验证失败,请重新发送验证邮件','error','m=home&a=setting');
			}else{
				update_member(array('email_check'=>1),$_G[uid]);
				unset($_SESSION['verify']);
				msg('邮箱验证成功,您现在可以正常浏览站点','success','index.php');
			}
		}else{
			msg('验证失败,验证地址不对');
		}
	}


	function login(){
			global $app,$_G;


				if($_G[uid])msg('您已登录,请退出后再进行操作','error','m=index');


						if( $_GET[username]&& $_GET[login_submit] && check()){
								$username = daddslashes(trim($_GET[username]));
								$password = daddslashes(trim($_GET[password]));

								if(!$username || trim($username) == ''){
									msg('抱歉,用户名不能为空','error','?');
									return false;
								}
								if(!$password){
									msg('抱歉,密码不能为空','error','?');
									return false;
								}

								if($_G[setting][login_yzm] && !check_yzm($_GET[yzm])){
									msg('验证码效验失败,请重新输入','error','?');
									return false;
								}

								if(strpos($username,'@') !== false){
									$name = 'email';
								}elseif(is_phone($username)){
									$name = 'phone';
								}else{
									$name = 'username';
								}
								$user = getuser($username,$name);
								if(!$user[uid])msg('账号不存在','error','?');
								if($user[groupid] ==3){
									msg('抱歉,您的账户已禁止,无法登录,如有疑问,请联系客服','error','?');
								}elseif($user[check] ==0){
									msg('抱歉,您的账户未审核,无法登录','error','?');
								}elseif($user['end_time'] >0 && $user['end_time']<TIMESTAMP){
									msg('登录失败,您当前账号已到期,无法登录');
								}

								if($_GET['seller'] == 1 && $user[seller] != 1){
									msg('抱歉,您的账户非商家用户,无法登录','error','?');
								}

								if(!$user['password'] && $user['login_id']){
									msg('登录失败,您当前账号为'.$user['login_name'].'登录账号,需要从'.$user['login_name'].'登录');
								}
								if(!$user[uid])msg('用户不存在或密码不正确','error','m=member&a=login');
								$pw =md5(md5($password).$user['key']);
								 if($user[password] == $pw ){
										$update = array('login_time'=>TIMESTAMP,'login_ip'=>$_G['clientip'],'login_count'=>$user[login_count]+1);
										$_G[member] = $user;
										$_G[member][group] = $_G[group][$user[groupid]];
										$_G[uid] = $user[uid];
										$_G[groupid] =$user[groupid];
										if($user[groupid] ==1) $_G[adminid] = 1;
										$_G[username] =  $user[username];
										update_group($user);

										$auth = authcode($user[uid].'|'.$user[password],'encode','',$this->login_time);
										DB::update('member',$update,"uid=".$user[uid]);
										dsetcookie("auth",$auth,$this->login_time);
										$referer = $_GET['referer'] ? $_GET['referer'] : dreferer();
										if(preg_match("/member/is",$referer))$referer = URL.'m=home';

											$ext = '<script type="text/javascript">
												setTimeout(function(){
													location.href = "'.$referer.'";
												},2000);
											</script>';
											msg('登录成功,欢迎您回来 '.$user[username],'success',$referer,$ext);
								}else{
									msg('用户密码不正确','error','m=member&a=login');
								}
						}
						seo('会员登录');
						$this->show('member/login');
	}

	function logout(){
				global $_G;
				$referer = dreferer();
				if(preg_match("/member|home/is",$referer))$referer = $_G['siteurl'];
				if(!$_G[uid]) msg('您未登录无须退出操作','error');
				logout();
				msg('退出登录成功','success',$referer);
	}

	function reg(){
					global $_G;

					if($_G[uid])msg('您已登录,请退出后再进行操作','error','m=index');

					if($_GET['reg_submit'] && check()){

						$arr =  get_filed(__CLASS__);
						$arr[username] =  trim($_GET['username']);
						$arr[password] =  trim($_GET['password']);
						$password2  =  trim($_GET['password2']);
						$arr[email] =  trim($_GET['email']);
						$arr[qq] =  isset($_GET['qq']) && trim($_GET['qq']) ? trim($_GET['qq']) :'' ;
						$arr[phone] =  isset($_GET['phone']) && trim($_GET['phone']) ? trim($_GET['phone']) :'' ;

						if($arr[username]){	//用户名注册
							 $name = 'username';
							 $tit = '用户名';
							 if(!$arr[email] )  msg('邮箱不能为空','error');
							 if(!is_email($arr['email']))  msg('邮箱格式不正确','error');

						}else if($arr[email]){
							$name = 'email';
							 $tit = '邮箱';
							if(empty($arr['email'])) msg('邮箱不能为空','error');
							if(!is_email($arr['email']))  msg('邮箱格式不正确','error');
						}elseif($arr[phone]){
							$name = 'phone';
							 $tit = '手机';
							 $phone = $_GET[phone];
							if(!preg_match("/^1\d{10}$/",$phone)){
								 msg('手机号码格式不正确','error');
							}
						}else{
							 msg('抱歉,注册用户名不能为空','error');
						}
						$arr[username] = $arr[$name];

						if(empty($arr['password'])) msg('密码不能为空','error');
						if(empty($password2)) msg('确认密码不能为空','error');
						if($arr['password']!= $password2)msg('两次输入密码不一致','error');

						if($_G[setting][reg_yzm] && !check_yzm($_GET[yzm])){
								msg('验证码效验失败,请重新输入','error');
								return false;
						}

						$username = daddslashes($arr[username]);
						$p1 = DB::fetch_first("SELECT uid FROM ".DB::table('member')." WHERE username='$username' ");
						if($p1[uid]>0) msg($tit.'已被注册','error');


						if($arr[email]){
							$email = trim_html($arr[email],1);
							$p = DB::fetch_first("SELECT uid FROM ".DB::table('member')." WHERE email ='$email' ");
							if($p[uid]>0) msg('邮箱已被注册','error');
						}

						if($arr[phone]){
							$phone = trim_html($_GET[phone],1);
							$p = DB::fetch_first("SELECT uid FROM ".DB::table('member')." WHERE phone ='$phone' ");
							if($p[uid]>0) msg('手机号码已被注册','error');
							$arr['phone'] = $phone;
						}


						$arr['key'] = random(10);
						$arr['password'] = md5(md5($arr['password']).$arr['key']);

						$arr['groupid'] = 10;
						$arr['regip'] = $_G[clientip];
						$arr['login_ip'] = $_G[clientip];
						$arr['login_time'] = TIMESTAMP;
						$arr['login_count'] = 1;
						$arr['picurl'] = 'assets/global/images/avatar.png';	//注册时默认给定随机头象
						$arr['regdate'] = TIMESTAMP;
						if($_G[setting][email_check] ==1)$arr['email_check'] =0;
						$arr['check'] = intval($_G[setting][reg_check]);
						if($_G[setting][jf]>0){
							$arr['jf'] =$_G[setting][jf];
						}

						if(isset($_GET['seller']) ){
							$arr[seller] = intval($_GET['seller']);
							//$arr['check'] = 0;
						}

						$t = intval(getcookie('t'));
						if($t>0)$arr['t_uid'] = $t;
						$arr = daddslashes($arr);
						$uid  = 	DB::insert('member',$arr,1);
						if($uid>0){
							$arr['uid'] = $uid;
							$_G[member] = $arr;
							$_G[member][group] = $_G[group][$arr[groupid]];
							$_G[uid] = $uid;
							$_G[groupid] =$arr[groupid];
							$_G[username] =  $arr[username];

							$auth = authcode($uid.'|'.$arr[password],'encode','',$this->login_time);
							dsetcookie("auth",$auth,$this->login_time);

							top('im','add',$arr);

							if($_G[setting][jf]>0){
								$jf  	=	 $_G[setting][jf];
								$sid =insert_sign(array('uid'=>$uid,'username'=>$arr['username'],'desc'=>'新会员注册系统奖励','type'=>'system','org_jf'=>$jf,'jf'=>$jf));
							}
							$this->check_yaoqing($t,$arr);

							$referer = $_GET['referer'] ? $_GET['referer'] : dreferer();
							if(preg_match("/member/is",$referer))$referer = URL.'m=home';
							if($_G[setting][email_check] == 1 && $_G[setting][email][status]){
									$status	=send_email($arr['email'],'reg');

									if($status['status']=='success'){
										$msg = '恭喜您成功,您的账户还需要验证,我们已向您的邮箱'.$arr['email'].'发送了一封验证邮件,请在15分钟内查看并验证';
										msg($msg,'success',$referer);
									}else{
										msg($status[msg],'error',$referer);
									}
									return ;
							}else{
								msg('恭喜您注册成功','success',$referer);
								return ;
							}

						}else{
							msg('注册失败','error','m=member&a=reg');
						}


					}
					seo('会员注册');
					$this->show('member/reg');
	}

		function check_yaoqing($t,$arr){
						global $_G;


						if($t>0 && array_key_exists('yaoqing',$_G['table'])){
							$ip = $_G['clientip'];
							$reg_platform = MOBILE === true  ? 1 :0;
							//$platform = array(0=>'',1=>'pc',2=>'android',3=>'ios',4=>'weixin',5=>'wap iphone',6=>'wap android',7=>'wap');

							$platform = 1;	// android app

							$useragent = @$_SERVER['HTTP_USER_AGENT'];
							if($useragent){
								if(stripos($useragent,'MicroMessenger') !==false ) {
									$platform = 4;	
								}else if(stripos($useragent,'iphone') !==false ) {
									$platform = 5;	
								}else if(stripos($useragent,'android') !==false){
									$platform = 6;
								}else if(MOBILE === true ){
									$platform =  7;
								}
							}	

							$rs = DB::update('yaoqing',array('uid'=>$arr['uid'],'regdate'=>TIMESTAMP,'reg_platform'=>$platform),"t_uid= $t AND ip = '".$ip."' AND uid= 0 ");
						}


							if($t>0 && $_G[setting][yaoqing]>0){
								//月限制
								$day30 = TIMESTAMP-3600*24*30;
								$count = getcount('member',' AND t_uid='.$t." AND regdate>".$day30);

								//天限制
								$today = TODAY;
								$count_day = getcount('member',' AND t_uid='.$t." AND regdate>".$today);

								  if($count<=$_G[setting][yaoqing_num] && $count_day <=$_G[setting][yaoqing_day]  ){

										$tmp =DB::fetch_first("SELECT * FROM ".DB::table('member')." WHERE uid ='$t' ");
										if($tmp[uid]>0 && $tmp[groupid] != 3 && $tmp[check] ==1){
											$update_arrr = array();
											$jf  	=	 $_G[setting][yaoqing];
											$add_jf = 	$tmp['jf']+$jf;
											$sid =insert_sign(array('uid'=>$tmp[uid],'username'=>$tmp[username],'desc'=>$tmp[username].'邀请'.$arr[username].'注册',
														'type'=>'yaoqing','type_id'=>$arr['uid'],'org_jf'=>$add_jf,'jf'=>$jf)
											);

											if($sid){
												 $update_arrr['jf'] = $tmp[jf]+$jf;
												 dsetcookie("t",'0',-1);
											}
											if(count($update_arrr)>0)	update_member(array('jf'=>$tmp[jf]+$jf),$tmp[uid]);
										}
								  }
							}
			}


	//注册协议
	function xy(){
		$this->show();
	}

	function get_password(){
			global $_G;

			if($_G[uid]){
				msg('您已登录成功，无须找回密码');
				return false;
			}

			$step  = 1;
			$email = '';
			if($_GET['onsubmit'] && check() && !$_GET[new_password]){

				if(!$_GET[username]){
					msg('用户名不能为空');
					return false;
				}

				if(!$_GET[email]){
					msg('注册email不能为空');
					return false;
				}

				if(!check_yzm($_GET[yzm])){
					msg('验证码效验失败,请重新输入','error','?');
					return false;
				}


				$username =trim($_GET[username]);
				$email = trim($_GET[email]);

				if(!$username){
					msg('用户名不能为空','error');
					return false;
				}
				if(!is_email($email)){
					msg('邮箱格式不正确','error');
					return false;
				}


				$username = daddslashes($username);
				$user = getuser($username,'username');
				if($user[email] && $user[email] == $email){
						$rs = send_email($email,'get_password');
						if($rs['status']=='success'){
							msg('邮件已发送到您的邮箱'.$email.'请登录邮箱打开链接获取修改密码地址','success','m=member&a=login');
						}else{
							msg($rs[msg],'error','m=member&a=get_password');
						}
						return false;

				}else{
					msg('email与用户名不符','error');
					return false;
				}

			}elseif($_GET['key'] || $_GET['new_password'] == 1){
					email_check('get_password');

					if($_GET['new_password'] ==1){
						if(!$_GET[password1] || !$_GET[password2]){
							msg('报歉,你要设置的新密码或确认密码不能为空');
							return false;
						}elseif($_GET[password1] && $_GET[password1] != $_GET[password2]){
							msg('报歉,你要设置新密码和确认密码不一致');
							return false;
						}else{
							$user = getuser(intval($_GET['key']),'uid');

							if(!$user[uid]){
								msg('报歉,用户ID不存在');
								return false;
							}else{
								$new_password = (trim($_GET[password1]));
								$arr = array();
								$arr['key'] = random(10);
								$arr[password] =md5(md5($new_password).$arr['key']);
								$id = DB::update('member',$arr,'uid='.$user[uid]);
								if($id){

									unset($_SESSION['get_password']);
									msg('重置密码成功,现在您可以用新密码进行登录','success','m=member&a=login');
									return false;
								}else{
									msg('报歉,重置密码失败');
									return false;
								}
							}
						}

					}else{
						$step = 3;
					}

			}
			seo('找回密码');
			$this->add(array('step'=>$step,'email'=>$email));
			$this->show();
	}

	function email_check(){
		global $_G;
		email_check('email_check');
		DB::update('member',array('email_check'=>1),'uid='.$_G[uid]);
		unset($_SESSION['email_check']);
		msg('邮箱验证成功','success','m=home&a=setting');

	}
}
/*

1,上传图片
2,上传到本地成功后,定义所存文件夹及路径,根据用户uid %500 = 文件夹名
	如要否上传到百川,需定义域名,将图片删除,只存1个只留1kb的大小的文件


php获取时,检查本地是否存在文件,
	如存在,获取内容,如果==1 则修改域名,前往百川获取图片
	如不存在,则生成当前用户的图象


*/
?>
