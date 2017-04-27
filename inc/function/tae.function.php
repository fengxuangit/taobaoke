<?php
if(!defined('IN_TTAE')) exit('Access Denied');


function top($name,$method,$data,$data1){
	global $_G;

	if($_G['TOP']	== NULL ){
		include_once	(ROOT_PATH.'top/TopClient.php');
		$c = new TopClient;
		$c->format= 'json';
		$_G['TOP'] =  $c;
	}
	//1=百川接口	0=淘客接口
	if($_G['setting']['api_type'] == 1){
		if($_G['setting'][appkey] && $_G['setting'][secretKey]){
		  $c->appkey = 	trim($_G[setting]['appkey']);
		  $c->secretKey = trim($_G[setting]['secretKey']);
		}else{
			msg('百川appkey未配置,无法进行操作');
		}
	}else{
		if($_G['setting'][taoke_appkey] && $_G['setting'][taoke_secretKey]){
		  $c->appkey = 	trim($_G[setting]['taoke_appkey']);
		  $c->secretKey = trim($_G[setting]['taoke_secretKey']);
		}else{
			msg('淘宝客appkey未配置,无法进行操作');
		}
	}



	if(!$name) return $_G['TOP'];

	if(defined('ERROR') && ERROR === true) return false;

	if(is_array($name)){
		$arr = $name;
	}else {
		$arr = array('name'=>$name,'method'=>$method,'data'=>$data,'data1'=>$data1);
	}

	if(!preg_match("/^[a-zA-Z_]+$/is",$arr[name])) return false;

	$file_name = 'api/'.$arr[name];

	if((include_once libfile($file_name)) === false){
		system_error('system','api文件不存在'.$v);
		return false;
	}

	$class = "api_".$arr[name];
	$res =	new $class;

	if($arr[method] && method_exists($res,$arr[method])){

		$me = $arr[method];
		return $res->$me($arr[data],$arr[data1]);
	}
//	$rs = $res->send('18627922987','code','1234');
	//dump($rs,1);
	return $res;
}



//API检查错误
function top_check_error($resp,$show=true){
		global $_G;
			//7 老是提示API超次限制.所以就pass掉
			$pass_code = array(7);
			$code['10008'] =	$code['11'] = '开发者权限不足';
			$code['12'] = '用户权限不足';
			$code['7'] = 'API应用调用次数超限或调用频率超限';

			if(in_array(CURSCRIPT,array('fetch','api')))$show = false;

			if($resp->code){
					$msg = '';
					$msg .= $code[$resp->code] ?  $code[$resp->code] .$resp->sub_msg: $resp->sub_msg;
					$msg .=",错误码:".$resp->code.'<p>错误信息:'.$resp->msg.'</p><p>错误代码:'.$resp->sub_code.'</p>';
					$_G['error_msg'] = $msg;

					if($show){
						msg($msg,'error');
						exit;
					}else{
						L($msg);
						return false;

					}
			}
			return true;
}



//调用了商品数据后,解析商品



function get_rand($proArr) {
    $result = '';
    $proSum = array_sum($proArr);
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    return $result;
}



//方便在模板中直接调用数组的键值类型是整数,给这个键值加一个k
function set_key($arr){
	$tmp =array();
	if(!$arr || !is_array($arr)) return false;
	foreach($arr as $k=>$v){
		$tmp['k'.$k] = $v;
	}
	return $tmp;
}


function get_goods_id($str,$get_pattern=false){
	$pattern = "/id=(\d{10,13})/is";
	if($get_pattern == true) return $pattern;
	if(!$str) return false;
	$str = trim($str);

	if(preg_match($pattern,$str,$arr)){
		return $arr[1];
	}elseif(preg_match("/(\d{10,13})/is",$str,$arr)){
		return $arr[1];
	}elseif(is_numeric($str)){
		return $str;
	}else{
		return false;
	}
}
function reg($user){
	global $_G;

	if($_G[uid]) return $_G[uid];


	$jf=intval($_G[setting][jf]);
	$member =get_filed('member',$member);
	$member[jf]  = $jf;
	$member[login_ip]  = $_G[clientip];
	$member[login_time]  = TIMESTAMP;
	$member[login_count]  = 1;

	$user[username]  = $user[username] ? $user[username] :$_G['username'];



	if(!$user[username]) return false;

	$u = getuser($user[username],'username');
	if($u && $u[uid]>0){
		$_G[member] = $u;
		$_G[username] = $u[username];
		$_G[uid] = $u['uid'];
		return $u['uid'];
	}

	foreach($user as $k=>$v){
		$member[$k] = $v;
	}
	 $member['regdate'] =TIMESTAMP;
	 $member['regip'] =$_G[clientip];
	 $member['groupid'] = 10;

	$member['login_ip'] = $_G[clientip];
	$member['login_time'] = TIMESTAMP;
	$member['login_count'] = 1;
	$member['email_check'] =intval($_G[setting][email_check]);
	$member['check'] = intval($_G[setting][reg_check]);

	$member['jf'] =intval($_G[setting][jf]);
	if(isset($_GET['seller']) )$member[seller] = intval($_GET['seller']);
	$id = DB::insert('member',$member,true);
		 if($id>0){
			 $_G[member] = $member;
			 $_G[member][uid] = $id;
			 $_G[uid] = $id;
			 $_G[username] = $member[username];
			 if($member['jf']>0) insert_sign(array('desc'=>'注册奖励积分','type'=>'system','org_jf'=>$jf,'jf'=>$jf));

		 }
	 return $id;
}



function get_sign_jf($uid){
		global $_G;
		$jf= $_G['setting']['jf'];
		if(!$uid) $uid = $_G[uid];
		$size = $_G[setting][qd_days] ? $_G[setting][qd_days] : 7;
		$rs = DB::fetch_all("SELECT dateline FROM ".DB::table('sign')." WHERE uid=".$uid ." AND type='sign' ORDER BY id DESC LIMIT ".($size+1));
		$sign_days =1;	
		$i= 1;
		$toady = date('Ymd',TIMESTAMP);
		foreach($rs as $k=>$v){
			$t =date('Ymd',$v['dateline']);
			$today =date('Ymd',TIMESTAMP);
			if($t == $today)$i = 0;
			$now =date('Ymd',TIMESTAMP-($i*86400));
			if($now == $toady){
				$i++;
			} else if($t ==$now){
				$sign_days++;
				$i++;
			}else{
				break;
			}
		}

		if($sign_days>$size) $sign_days = 'n';
		return $sign_days;
}





function api_post($parent){
	global $_G;
	if(defined('API') || API ===true || TAE) return false;	//死循环
	
	if($_G[setting][syn_status] !=1 )return false;
	if($_G[setting][syn_web_type] !=1)return false;
	if(!$_G[setting][syn_domain] || !is_array($_G[setting][syn_domain]))return false;
	
	if($_G[setting]['syn_'.$parent[a]] != 1) return false;
	if($parent['m'] !='cache' && $_G[setting][syn_table] &&  !in_array($parent['table'],$_G[setting][syn_table] )) return false;

	$link = "/fetch/api.php?syn_key=".($_G['setting']['syn_key']);
	$parent['id'] = (string) $parent['id'];
	if($parent['a'] == 'insert' && $parent['id']) $parent['data']['id'] = $parent['id'];
	$parent['data'] = json_encode($parent['data']);
	foreach($_G[setting][syn_domain] as $k=>$v){
			try{
				$org_rs = $rs= fetch($v.$link,$parent);
			}catch(Exception $e){
				$rs = $e->getMessage();
			}
			if(!$rs){				
				echo "同步出错,未返回任何信息";
			}else{
				$out = json_decode($rs,true);				
				if(!$out && (!TAE || BC)){
				
					$rt = json_decode($rt,true);
					if(is_array($rt) && $rt[msg]) $rt[msg] =  utf8_decode($rt[msg]);
					$out = $rt;
				}
				
				if(!$out || !is_array($out)){					
					echo "<h1 class='admin_msg'>{$v} 返回信息格式化失败,原始信息:".$org_rs."</h1>";
				}elseif($out['status']=='error' && $out['msg']){					
					$str="<div class='admin_msg'>同步至目标站点:".$out['domain'].",同步失败,错误信息:<b>";
					$str .=$out['msg'].'</b><p>'.$out['ext_msg']."</p></div>";
					echo $str;
				}
			}
	}
}






//使用时需要try cache 捕获异常
function fetch($url,$parameters,$use_class = true){
		global $_G;
		if(!$url) return false;
		 if(!function_exists('curl_init')) {
			 $_G['msg'] = '您的当前环境不支持curl,请开通后再使用';
			  return false;
		 }
		 if(is_array($parameters)) $parameters= http_build_query($parameters);
		 //功能性强的curl,支持301,302抓取
		 if($use_class){
				include_once libfile('class/curl');
				 $curl = new Curl();
				// $curl->debug=true;

				try{
				 	if ($parameters) {
						$rs=  $curl->post($url, $parameters);
				 	}else{
						$rs= $curl->get($url);
				 	}

				}catch(Exception $e){
					$msg = $e->getMessage();
					 $_G['msg'] ="Curl Response Error ".$msg ;
					L($msg);
					$rs= false;
				}
				return $rs;
		 }

		if(!function_exists('curl_init'))   throw new Exception ( '您的当前环境不支持curl,请开通后再使用');
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_FAILONERROR, false );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

			$ssl  = strpos($url,'https') !== false ? true:false;
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, $ssl );

		if ($parameters) {
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $parameters);
		}
		$reponse = curl_exec ( $ch );
		$msg = curl_errno ( $ch );

		if ($msg) {
			curl_close ( $ch );
			$_G['msg'] ='Curl exec error:'.$msg;
			L('curl exec error:'.$msg);
			//throw new Exception ( $msg, 0 );
		} else {
			$httpStatusCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			if (200 !== $httpStatusCode) {
				curl_close ( $ch );
				//throw new Exception ( $reponse, $httpStatusCode );
				$_G['msg'] ='curl response error:'.$reponse;
				L('curl exec error:'.$reponse);
			}
		}

		return $reponse;

}





function get_share($arr){
	global $_G;
	//$type,$title,$picurl,$cotent


	$title = $arr[title] ?  $arr[title] : $_G[setting][seo_title];
	$title.='-'. $_G[setting][title];
	$picurl = $arr[picurl] ?  $arr[picurl] : $_G[setting][logo];

	if($arr[num_iid]){

		if(!preg_match("/^http:/is",$arr[url]))$arr[url] = $_G[siteurl].str_replace('/index.php','/index.php',$arr[url]);
		$url = $arr[url];
		$content=$arr[ly] ? $arr[ly]:$arr[title];
		$content.='-'.$arr[channel][name].'-'.$_G[setting][title];
	}else{
		$url = $arr[url] ?  $_G[siteurl].$arr[url] : $_G[siteurl];
		$content = $arr[content] ?  $arr[content] : $_G[setting][seo_description];
		$content .= '-'.$_G[setting][title];
	}

	$url = urlencode_utf8($url);
	$title = urlencode_utf8($title);
	$content = urlencode_utf8($content);
	$picurl = urlencode_utf8($picurl);
	$share[qzone] =$share[qqzone] = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='.$url.'&title='.$title.'&summary='.$content.'&pic='.$picurl."&site=";
	$share[weibo] = 'http://service.weibo.com/share/share.php?url='.$url.'&title='.$title.'&pic='.$picurl;
	$share[t] = 'http://share.v.t.qq.com/index.php?c=share&a=index&url='.$url.'&title='.$title.'&pic='.$picurl;
	$share[renren] = 'http://widget.renren.com/dialog/share?resourceUrl='.$url.'&title='.$title.'&pic='.$picurl.'&description='.$content;
	$share[kaixin] = 'http://www.kaixin001.com/rest/records.php?url='.$url.'&content='.$content.'&pic='.$picurl.'&style=11&stime=&sig=';
	$share[douban] = 'http://www.douban.com/share/service?bm=&image=&href='.$url.'name='.$title.'&text='.$content;



	if($arr[type]){
		return $share[$arr[type]];
	} else{
		return $share;
	}
}



function C($name, $value=null, $time){
	global $_G;
	$rt = '';
		if($value === null){
			$rt =getcookie($name);
		}else{
			$rt= dsetcookie($name,$value, $time ? $time : 2592000);
		}

	return $rt;
}

function get_tomorrow($and,$size){
	if(!$size || $size<=0 || $_GET[price]) return array();
	$h = intval(dgmdate(TIMESTAMP,'H'));
	if($h<10){		//未到10点显示今日上架的商品
		$tomorrow =  TOMORROW;
	}elseif($h>=16){	//上架第二天的商品
		$tomorrow = TOMORROW_2;
	}else{
		return array();
	}
	$and 	=' AND  `check` =1  AND start_time>='.TIMESTAMP.' AND start_time<'.$tomorrow .$and;
	$yugao =  D(array('and'=>$and,'limit'=>intval($size),'all'=>true,'order'=>'start_time ASC'));
	return $yugao;
}

function email_check($type='') {
    global $_G;

    if (!$_SESSION[$type]) {
        msg('报歉,当前链接已过期', 'error', '?');
    }
    if (!$_SESSION[$type]) {
        msg('当前链接已失效');
    }
    if ($type == 'get_password') {
        $uid = intval($_GET['key']);
        if ($uid < 1) {
            msg('未找到要找回密码的用户');
        }
        $u = getuser($uid, 'uid');
        if (!$u[uid]) {
            msg('未找到对应的用户');
        }
        $rs = md5($u[username] . '|' . $u[uid] . '|' . $type . '|' . $_G[clientip]);
    } else {
        if (!$_G[uid]) {
            msg('请登录后再进行操作');
        }
        $rs = md5($_G[username] . '|' . $_G[uid] . '|' . $type . '|' . $_G[clientip]);
    }

    if ($_SESSION[$type] != $rs) {
        msg('验证失败,当前链接已过期');
    }
    return true;
}

function send_email($touser,$type){
		global $_G;

		if($_G[setting][email][status] !=1){
			return array('status'=>'error','msg'=>'系统未开启发送邮件功能,无法发送邮件');
		}
		if(!$_G[setting][email][smtp]  || !$_G[setting][email][address]  ||  !$_G[setting][email][password]){
			return array('status'=>'error','msg'=>'系统发送邮件设置不完整,请联系在线客服或管理员');
		}
		if(!$type)  return array('status'=>'error','msg'=>'要发送邮件的类型不能为空');

		$url = $_G[siteurl];

		if($type == 'email_check'){
			$title = "来自【".$_G[setting][title]."】的email绑定验证邮件";
			$url .= "/index.php?m=member&a=email_check";
			$key = 'email_check';
			$content_title = "绑定验证";
		}else if($type == 'reg'){
			$title = "来自【".$_G[setting][title]."】的注册验证邮件";
			$url .= "/index.php?m=member&a=email_check";
			$key = 'email_check';
			$content_title = "注册验证";
		}else if($type == 'get_password'){
			$title = "来自【".$_G[setting][title].'】重置密码邮件';
			$url .= "/index.php?m=member&a=get_password";
			$key = 'get_password';
				$content_title = "重置密码验证";
		}else{
			  return array('status'=>'error','msg'=>'要发送邮件的类型不存在');
		}

		if($type == 'get_password'){
			$u = getuser($touser,'email');
			if(!$u[uid]) return array('status'=>'error','msg'=>'未找到对应的用户');
			$rs = md5($u[username].'|'.$u[uid].'|'.$key.'|'.$_G[clientip]);
			$url.='&key='.$u[uid];
		}else{
			$rs = md5($_G[username].'|'.$_G[uid].'|'.$key.'|'.$_G[clientip]);
		}

		$_SESSION[$key] =$rs;

		$ip = $_G[clientip];
		$username = $_G[uid] ? $_G[username]:'';
		$message = "<strong>{$username} {$content_title}邮件说明 ---- {$_G[setting][title]} </strong>
		<br>---------------------------------------------------------------------<br>
		您必需在15分钟内，通过点击下面的链接进行{$content_title}：<br><a href='{$url}' target='_blank'>{$url}</a>
		<br>(如果上面不是链接形式，请将该地址手工粘贴到浏览器地址栏再访问)<br>
		<br>{$url}<br>
		<p>在上面的链接所打开的页面进行{$content_title},您可以在用户会员中心随时修改您的信息。</p>
		<p>本请求提交者的IP为 {$ip}</p><p>此致<br></p><p>{$_G[setting][title]} 管理团队.
		<a href='{$_G[siteurl]}' target='_blank'>{$_G[siteurl]}</a></p>";


		//$_SESSION['verify_email_len'] = intval($_SESSION['verify_email_len']) +1;
		if($_SESSION['verify_email_len']>5){
			$status = array('status'=>'error','msg'=>'频繁发送多条邮件,请等2小时后再重新发送');
			return false;
		}

		include_once ROOT_PATH."web/lib/email/class.phpmailer.php";

	/*	dump($message);
		return array('status'=>'success','msg'=>'邮件已成功发送到'.$touser.'----测试状态');
		*/

		$mail = new PHPMailer();
		$mail->CharSet = CHARSET;
		$mail->IsSMTP();
		$mail->Host = $_G[setting][email][smtp];
		$mail->SMTPAuth = true;
		$mail->Username = $_G[setting][email][address];
		$mail->Password = $_G[setting][email][password];
		$mail->Port=$_G[setting][email][port] ? $_G[setting][email][port] : 25;
		$mail->From = $_G[setting][email][address];
		$mail->FromName = $_G[setting][title];
		$mail->AddAddress($touser);
		$mail->IsHTML(true);
		$mail->Subject = $title;
		$mail->Body = $message;
		if(!$mail->Send()){
			return array('status'=>'error','msg'=>'发送邮件失败,错误信息:'.$mail->ErrorInfo);
		}else{
			return array('status'=>'success','msg'=>'邮件已成功发送到'.$touser);
		}
}



//发送短信验证邮件
function send_verify_phone($to_phone,$title){
	global $_G;

	$key =random(6,1);
	$_SESSION['verify_phone']=$to_phone.'_'.$key;
	$_SESSION['verify_phone_len'] = intval($_SESSION['verify_phone_len']) +1;
	if($_SESSION['verify_phone_len']>15){
		return array('status'=>'error','msg'=>'频繁发送多条短信,请等2小时后再重新发送');

	}
	if(!$title) $title = '您的验证码为 ' .  $key . '  ,切勿告诉他人【' .$_G[setting][title]."】";

	//开始发短信

	if(!class_exists('SMS'))include_once ROOT_PATH.'web/lib/message/sms.class.php';

	//即时发送
	$sms = new SMS();
	$rt = $sms->send($to_phone,$title);
	if($rt === true){
			return  array('status'=>'success','msg'=>'','data'=>$key);
	}else{
		return array('status'=>'error','msg'=>$rt);
	}

}


function upload($file,$type){
		global $_G;
		if(!$file && !$_FILES[file]) return false;
		if(is_string($file) && $file){
					$file = str_replace(ROOT_PATH,'',$file);
					$target_file = ROOT_PATH.$file;
					if(!file_exists($target_file))  return false;
		}elseif($file['tmp_name']) {
					$target_file = $file['tmp_name'];
		}else if($_FILES['file'] && $_FILES['file']['tmp_name']){
					$target_file =$_FILES['file']['tmp_name'];
					$file = $_FILES['file'];
		}else{
			return false;
		}


		if(!is_string($target_file)) return ;
			if($type){
				$class = $type;
			}else{
				$class = $_G['setting']['upload_url'];
			}
			if(!$class) $class = 'baichuan';

			if($class =='baichuan' && !$_G['setting']['appkey']){
				$msg = '百川appkey未配置,无法进行图片上传操作';
				msg($msg);
				L($msg);
			}

			if(!class_exists($class.'_upload')) include_once ROOT_PATH.'inc/class/upload/'.$class.'_upload.php';
			$cname = $class.'_upload';
			$bc = new $cname();
			$bc->file = &$file;

			if(!is_file($target_file)) return  false ;
			$rs = $bc->upload($target_file);

			if($rs && is_string($rs)){
				@unlink($target_file);
				return $rs;
			}else{
				$msg = ('图片上传错误,错误代码:'.$bc->code.',错误信息:'.$bc->msg);
				L($msg);
			}

}

?>
