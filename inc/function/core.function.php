<?php
if(!defined('IN_TTAE')) exit('Access Denied FROM UZ-SYSTEM');

//post提交数据检查...
function check(){
	$host = str_ireplace(array('-0','-1'),'',$_SERVER['HTTP_HOST']);
	$referer = str_ireplace(array('-0','-1'),'',$_SERVER['HTTP_REFERER']);
	if(!$_SERVER['HTTP_REFERER'] || !preg_match("/".$host."/",$referer)){
		system_error('system','非法数据提交');
		return false;
	}
	return true;
}

//系统级错误,中断一切操作....
function system_error($type,$msg){
	global $_G;
	define('ERROR',true);
	$_G['error_msg'] = $msg;
	include_once libfile('class/error');
	if($type =='db'){
		error::db_error($msg);
	}else{
		$write_msg = '系统错误:'.$msg;
		L($write_msg);

		error::show_error($type,$msg);
	}
}


function daddslashes($string) {
	if(is_array($string)) {
		$keys= array();
		foreach($string as $k=>$v){
			$keys[] = $k;
		}
		foreach($keys as $key) {
			$val = $string[$key];
			unset($string[$key]);
			$string[addslashes($key)] =  addslashes($val);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}

function dstripcslashes($string){
	if(is_array($string)) {
		$string = array_map('dstripcslashes',$string);
	}elseif(is_string($string)){
		$string = stripcslashes($string);
	}
	return $string;
}


function checkrobot($useragent = '') {
	$kw_spiders = array('bot', 'crawl', 'spider' ,'slurp', 'sohu-search', 'lycos', 'robozilla');
	$kw_browsers = array('msie', 'netscape', 'opera', 'konqueror', 'mozilla');

	$useragent = $useragent ?  $useragent:@$_SERVER['HTTP_USER_AGENT'] ;
	$useragent= strtolower($useragent) ;
	if(strpos($useragent, 'http://') === false && dstrpos($useragent, $kw_browsers)) return false;
	if(dstrpos($useragent, $kw_spiders)) return true;
	return false;
}
function checkmobile($useragent) {
	global $_G;

	$useragent = $useragent ?  $useragent:$_SERVER['HTTP_USER_AGENT'] ;
	$useragent= strtolower($useragent) ;
	$mobile = array();
	$touchbrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
				'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
				'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
				'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
				'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
				'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
				'benq', 'haier', '^lct', '320x320', '240x320', '176x220', 'windows phone','micromessenger');


	if(($v = dstrpos($useragent, $touchbrowser_list, true))){
		$_G['mobile'] = $v;
	}
	if($_G[setting][mobile_host] && $_G[setting][mobile_host] == 'http://'.$_G[host]){
		$_G['mobile'] = true;
	}
	return $_G['mobile'];
}

function dstrpos($string, $arr, $returnvalue = false) {
	if(empty($string)) return false;
	foreach((array)$arr as $v) {
		if(strpos($string, $v) !== false) {
			$return = $returnvalue ? $v : true;
			return $return;
		}
	}
	return false;
}

//清空HTML并保留内容,s=删除空格
function trim_html($str='',$s=false){
	if(!$str) return '';
	if(is_array($str)){
		foreach($str as $k=>$v){
			$str[$k] = trim_html($v,$s);
		}
	}else if(!is_string($str) || !$str){
		return $str;
	}

	$str = trim($str);
	$str= preg_replace("/<[\s\S]*?>/is","",$str );
	if($s)$str= preg_replace("/\s+/is","",$str );
	$str= str_replace(array('"',"'","<",">","(",")","&",'#','%','nbsp;','../'),"",$str);

	return $str;
}

function safe_output($arr){
	if(!$arr) return $arr;
	if(is_array($arr)){
		foreach($arr as $k=>$v){
			$arr[$k]  = safe_output($v);
		}
	}else if(is_string($arr)){
		$arr = str_replace(array('<','>','(','"',')','\'','&gt;','&lt;','\\','&#','x0','0x','%','u00','eval','.js','.php','0000'),'',$arr);
	}
	return $arr;
}

function safe_filter($str){
	if(is_array($str)){
		foreach($str as $k=>$v){
			$str[$k] = safe_filter($v);
		}
		return $str;
	}else if(!is_string($str) || !$str){
		return $str;
	}
	$str = preg_replace( "/<script[\s\S]*?<\/script>/is", "", $str );
	$str = preg_replace( "/<i?frame[\s\S]*?<\/i?frame>/is", "", $str );
	$str = preg_replace( "/<style[\s\S]*?<\/style>/is", "", $str );
	$str = preg_replace( "@<link(.*?)>@is", "", $str );
	$str = preg_replace( "@<meta(.*?)>@is", "", $str );

	$st = array(
			"/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/si",
			"/(javascript:)?(window|document|navigator,history,screen,location)\./is",
			"/(<|&lt;)script(.*?)(<|&gt;)(.*?)(<|&lt;)\/script(<|&gt;)/is",
			"/<\?|\?>/si",
			"//iesU",
			"/eval/si",
			"/&#/si",
			"/\(/si",    "/\)/si",    "/\*/is"
		);
		$replace = array(
			"o\\2n",
			"a\\2_",
			"\\4",
			'?',
			'',
			"eva1",
			"&_#",
			"（"   ,"）"   ,   "_*"
		);

	$str= @preg_replace($st,$replace,$str);

	//$str=filter_xss($str);
	return $str;
}


function _xss_check(){

		$check = array('"',    '>',     '<',     '\'',     '(',     ')', 'CONTENT-TRANSFER-ENCODING');

		$arr = array(
			"%3c","&#60;",	//	<
			"%28","&#40;",	//	(
			"%22","&#34;",	//	"
			"%27","&#39;",	//	'
			"\u00","&#x","0x2","0x3",
			"..%2F", "../",
			"fromCharCode","javascript","\\","eval","alert"
		);
		$request_url = $_SERVER['REQUEST_URI'];
		$check = array_merge($check,$arr);

		if(!empty($temp)) {

			$temp = strtoupper(urldecode(urldecode($request_url)));
			foreach ($check as $str) {
				if(stripos($temp, $str) !== false) {
					system_error('system','您当前的访问请求当中含有非法字符，已经被系统拒绝');
					 exit;
				}
			}
		}
		return true;
}

function filter_xss($val) {
	if(is_array($val)){
		foreach($val as $k=>$v){
			$val[$k] = filter_xss($v);
		}
		return $val;
	}else if(!is_string($val) || !$val){
		return $val;
	}
   $val = str_replace(",","，",$val);
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
   $val = str_replace("，",",",$val);

   $search = 'abcdefghijklmnopqrstuvwxyz';
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $search .= '1234567890!@#$%^&*()';
   $search .= '~`";:?+/={}[]-_|\'\\';
   for ($i = 0; $i < strlen($search); $i++) {
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
   }

   $replace = array('javascript', 'vbscript', 'expression','meta', 'xml', '<link', 'script', 'embed', 'object', 'iframe',
   				'frame', 'frameset', 'ilayer','.js','.cookie','document.',"fromCharCode","throw","alert");

	 foreach($replace as $k=>$v){
		$rand  = random(5);
		$tmp = substr($v, 0, 2).$rand.substr($v, 2);
		$val = str_replace($v,$tmp,$val);
	}

   $ra1 = array('applet',  'blink' ,'layer', 'bgsound'); //去掉style
   $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
   $ra = array_merge($ra1, $ra2);
   $found = true; // keep replacing as long as the previous round replaced something
   while ($found == true) {
      $val_before = $val;
      for ($i = 0; $i < sizeof($ra); $i++) {
         $pattern = '/';
         for ($j = 0; $j < strlen($ra[$i]); $j++) {
            if ($j > 0) {
               $pattern .= '(';
              // $pattern .= '(&#[xX]0{0,8}([9ab]);)';
			   $pattern .= '(&#[xX]0{0,8}([9abd]);)';
               $pattern .= '|';
               $pattern .= '|(&#0{0,8}([9|10|13]);)';
               $pattern .= ')*';
            }
            $pattern .= $ra[$i][$j];
         }
         $pattern .= '/i';
		 $rand  = random(5);
         $replacement = substr($ra[$i], 0, 2).'<'.$rand.'>'.substr($ra[$i], 2);
         $val = preg_replace($pattern, $replacement, $val);
         if ($val_before == $val) {

            $found = false;
         }
      }
   }
   return $val;
}



function is_email($email) {
	return strlen($email) > 6 && strlen($email) <= 32 && preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
}

function is_phone($tel){
	//return preg_match("/^1\d{10}$/",$tel);
	$regxArr = array(
	  'sj'  =>  '/^(\+?86-?)?1[0-9]{10}$/',
	  'tel' =>  '/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',
	  '400' =>  '/^400(-\d{3,4}){2}$/',
	  );
	  if($type && isset($regxArr[$type])) {
		return preg_match($regxArr[$type], $tel) ? true:false;
	  }
	  foreach($regxArr as $regx)
	  {
		if(preg_match($regx, $tel ))
		{
		  return true;
		}
	  }
  return false;

}




function encode($string = '', $skey = '') {
	 global $_G;
	 if($skey == '') $skey = $_G['authkey'];

    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value){
        $key < $strCount && $strArr[$key].=$value;
	}
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
 }

function decode($string = '', $skey = '') {
	 global $_G;
	 if($skey == '') $skey = $_G['authkey'];
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    return base64_decode(join('', $strArr));
 }


function _authcode($str,$decode){
	if($decode){
		$rs =str_replace(array("_",'-'),array("/",'+'),$str);

	}else{
		$rs =str_replace(array("/",'+'),array("_",'-'),$str);
	}
	return $rs;
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	global $_G;
	$ckey_length = 4;
	$operation =strtoupper($operation);
	if($operation == 'DECODE') $string= _authcode($string,true);
	$key = md5($key != '' ? $key : $_G['authkey']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {

			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		$rs = $keyc.str_replace('=', '', base64_encode($result));
		return _authcode($rs,false);
	}

}


function dhtmlspecialchars($string, $flags = null) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val, $flags);
		}
	} else {
		if($flags === null) {
			$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
			if(strpos($string, '&amp;#') !== false) {
				$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
			}
		} else {
			if(PHP_VERSION < '5.4.0') {
				$string = htmlspecialchars($string, $flags);
			} else {
				if(strtolower(CHARSET) == 'utf-8') {
					$charset = 'UTF-8';
				} else {
					$charset = 'ISO-8859-1';
				}
				$string = htmlspecialchars($string, $flags, $charset);
			}
		}
	}
	return $string;
}


function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['HTTP_HOST']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}


function dintval($int, $allowarray = false) {
	$ret = intval($int);
	if($int == $ret || !$allowarray && is_array($int)) return $ret;
	if($allowarray && is_array($int)) {
		foreach($int as &$v) {
			$v = dintval($v, true);
		}
		return $int;
	} elseif($int <= 0xffffffff) {
		$l = strlen($int);
		$m = substr($int, 0, 1) == '-' ? 1 : 0;
		if(($l - $m) === strspn($int,'0987654321', $m)) {
			return $int;
		}
	}
	return $ret;
}



function dgmdate($timestamp, $format = 'dt') {
	global $_G;
	if($timestamp == 0) return '';


	$dformat = 'Y-n-j';
	$tformat = 'H:i';
	$dtformat = $dformat.' '.$tformat;

	$timeoffset = 8;
	$timestamp += $timeoffset* 3600;
	$format = empty($format) || $format == 'dt' ? $dtformat : ($format == 'd' ? $dformat : ($format == 't' ? $tformat : $format));

	if($format == 'u') {
			$lang = array(	'before' => '前','day' => '天','yday' => '昨天','byday' => '前天','hour' => '小时','half' => '半',	'min' => '分钟','sec' => '秒','now' => '刚刚');
			$todaytimestamp = TIMESTAMP - (TIMESTAMP + $timeoffset * 3600) % 86400 + $timeoffset * 3600;
			$s = gmdate(!$uformat ? $dtformat : $uformat, $timestamp);
			$time = TIMESTAMP + $timeoffset * 3600 - $timestamp;
			if($timestamp >= $todaytimestamp) {
				if($time > 3600) {
					return intval($time / 3600).' '.$lang['hour'].$lang['before'];
				} elseif($time > 1800) {
					return $lang['half'].$lang['hour'].$lang['before'];
				} elseif($time > 60) {
					return intval($time / 60).' '.$lang['min'].$lang['before'];
				} elseif($time > 0) {
					return $time.' '.$lang['sec'].$lang['before'];
				} elseif($time == 0) {
					return $lang['now'];
				} else {
					return $s;
				}
			} elseif(($days = intval(($todaytimestamp - $timestamp) / 86400)) >= 0 && $days < 7) {
				if($days == 0) {
					return $lang['yday'].' '.gmdate($tformat, $timestamp);
				} elseif($days == 1) {
					return $lang['byday'].' '.gmdate($tformat, $timestamp);
				} else {
					return ($days + 1).' '.$lang['day'].$lang['before'];
				}
			} else {
				return $s;
			}
	} else {
		return gmdate($format, $timestamp);
	}
}

function dmktime($date,$time=true) {
	global $_G;
	if(!$date) return 0;

	if(is_numeric($date)) return $date;

	if(strpos($date, '-')) {

		$date = explode(' ', $date);
		$time1 = explode('-', $date[0]);
		if($date[1] && $time){
			$time2 = explode(':', $date[1]);
		}else{
			$time2= array(0,0,0);
		}

		$rs = mktime($time2[0], $time2[1], $time2[2], $time1[1], $time1[2], $time1[0]);

		return $rs;
	}
	return 0;
}



function libfile($libname, $folder = '') {
	$libpath = 'inc'.$folder;
	if(strstr($libname, '/')) {
		list($pre, $name) = explode('/', $libname);
		$path = "{$libpath}/{$pre}/{$name}.{$pre}";
	} else {
		$path = "{$libpath}/{$libname}";
	}
	return ROOT_PATH.$path.'.php';

}

function dstrlen($str) {
	if(strtolower(CHARSET) != 'utf-8') {
		return strlen($str);
	}
	$count = 0;
	for($i = 0; $i < strlen($str); $i++){
		$value = ord($str[$i]);
		if($value > 127) {
			$count++;
			if($value >= 192 && $value <= 223) $i++;
			elseif($value >= 224 && $value <= 239) $i = $i + 2;
			elseif($value >= 240 && $value <= 247) $i = $i + 3;
	    	}
    		$count++;
	}
	return $count;
}

function cutstr($string, $length, $dot = ' ...') {

	if(!$string) return '';


	if(strlen($string) <= $length) return $string;
	$pre = chr(1);
	$end = chr(1);
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		$_length = $length - 1;
		for($i = 0; $i < $length; $i++) {
			if(ord($string[$i]) <= 127) {
				$strcut .= $string[$i];
			} else if($i < $_length) {
				$strcut .= $string[$i].$string[++$i];
			}
		}
	}

	$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	$pos = strrpos($strcut, chr(1));
	if($pos !== false) {
		$strcut = substr($strcut,0,$pos);
	}
	return $strcut.$dot;
}
function sub_str($str,$start,$end){
	$str = preg_replace("/\s+/",'',$str);
	$start = preg_replace("/\s+/",'',$start);
	if($end != -1)$end = preg_replace("/\s+/",'',$end);
	$s = strpos($str,$start);
	$str1=substr($str,$s+dstrlen($start));
	$e = $end == -1 ? dstrlen($str1):strpos($str1,$end);
	return  substr($str1,0,$e);
}

function sub_str2($str,$star,$end){
    $str=substr($str,strpos($str,$star));//去除前面
    $n=strpos($str,$end);//寻找位置
    if ($n) $str=substr($str,0,$n);//删除后面
    return $str;
}

function dstripslashes($string) {
	if(empty($string)) return $string;
	if(is_array($string)) {
		$string = array_map('dstripslashes',$string);
	} else {
		$string = stripslashes($string);
	}
	return $string;
}


function debug($var = null, $exit = false) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
	if($exit) exit;

}

function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = false, $simple = false, $jsfunc = false) {
    if (!class_exists('page')) {
        include_once ROOT_PATH . 'inc/class/page.class.php';
    }
    return $num > $perpage ? page::multi($num, $perpage, $curpage, $mpurl, $maxpages, $page, $autogoto, $simple, $jsfunc) : '';
}

function simplepage($num, $perpage, $curpage, $mpurl) {
	if(!class_exists('page')) include_once ROOT_PATH.'inc/class/page.class.php';
	return page::simplepage($num, $perpage, $curpage, $mpurl);
}

function stripsearchkey($string) {
	$string = trim($string);
	$string = str_replace('*', '%', addcslashes($string, '%_'));
	$string = str_replace('_', '\_', $string);
	return $string;
}

function dreferer(){
	global $_G;
	if($_G['referer_init'] == 1) return $_G['referer'];
	$_G['referer_init']  =1;

	if($_GET['referer']){
		$referer =urldecode($_GET['referer']);
	}else if($_SERVER['HTTP_REFERER']){
		$referer = $_SERVER['HTTP_REFERER'];
	}else{
		$referer = $_G[siteurl];
		$_G['referer'] = $referer;
		return $referer;
	}


	$referer = dhtmlspecialchars($referer, ENT_QUOTES);
	$referer = safe_filter($referer);

	$referer = str_replace('amp;', '', $referer);
	$reurl = parse_url($referer);
	$host = preg_replace("/:\d+/is",'',$_SERVER['HTTP_HOST']);
	if(!empty($reurl['host']) && !in_array($reurl['host'], array($host, 'www.'.$host)) && !in_array($host, array($reurl['host'], 'www.'.$reurl['host']))) {
		$referer = $_G[siteurl];
	}else{
		if($_G[uid] && preg_match("/member/is",$_G['referer'])){
				$referer= URL."m=home";
		}elseif(!$_G[uid] && preg_match("/home/is",$_G['referer'])){
			$referer = URL."m=member&a=login";
		}
	}
	if(!$referer) $referer = $_G[siteurl];
	$_G['referer'] = $referer;
	return $referer;
}


function dreferer111() {
	global $_G;
	if($_G['referer_init'] == 1) return $_G['referer'];
	$_G['referer'] = !empty($_GET['referer']) ? $_GET['referer'] : !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_G['siteurl'];
	$_G['referer'] = substr($_G['referer'], -1) == '?' ? substr($_G['referer'], 0, -1) : $_G['referer'];
	$_G['referer'] = dhtmlspecialchars($_G['referer'], ENT_QUOTES);
	$_G['referer'] = str_replace('amp;', '', $_G['referer']);
	$reurl = parse_url($_G['referer']);
	$host = preg_replace("/:\d+/is",'',$_SERVER['HTTP_HOST']);
//dump($_SERVER['HTTP_REFERER']);



	//来源域名不是来自本站内部
	if(!empty($reurl['host']) && !in_array($reurl['host'], array($host, 'www.'.$host)) && !in_array($host, array($reurl['host'], 'www.'.$reurl['host']))) {
		$_G['referer'] =URL;

	}else{
		if($_G[uid] && preg_match("/member/is",$_G['referer'])){

				$_G['referer'] = URL."m=home";
		}elseif(!$_G[uid] && preg_match("/home/is",$_G['referer'])){

			$_G['referer'] = URL;
		}elseif($_GET[referer]){

			$referer = trim($_GET['referer']);
			$referer = explode('/',$referer);
			for($i=0;$i<count($referer) ;$i++ ){
				$a[$referer[$i]] = $referer[++$i];
			}
			$a = http_build_query($a);
			$_G['referer'] = URL.$a;
		}else{
			$_G['referer'] = URL;
		}
	}

	$_G['referer'] = preg_replace("/spm=(.*?)&/is",'',$_G['referer']);
	$_G['referer'] = preg_replace("/^(.*?)/([a-zA-Z0-9_]+)\.php/is",'/$2.php',$_G['referer']);
	$_G['referer_init'] = 1;
	return strip_tags($_G['referer']);
}


function getcount($tablename, $condition='') {
	if(empty($condition)) {
		$where = '1';
	} elseif(is_array($condition)) {
		$where = DB::implode_field_value($condition, ' AND ');
	} else {
		$where =  preg_replace("/^(\s*)AND/is",'',$condition);
	}

	$ret = intval(DB::result_first("SELECT COUNT(*) AS num FROM ".DB::table($tablename)." WHERE $where"));
	return $ret;
}
function dunserialize($data) {

	if(!TAE && ($ret = unserialize($data)) === false){

		$data = preg_replace("/^(.*?)\{|;\}$|\"/s",'',$data);
		$data = preg_replace("/U:(.*?):/s",'',$data);
		$data = preg_replace("/s:(.*?):/s",'',$data);
		$data = preg_replace("/i:(.*?):/s",'',$data);
		$arr = explode(';',$data);
		$tmp = array();
		foreach($arr as $k=>$v){
			if($k%2==0){
			$v = preg_replace("/i:/s",'',$v);
				$v2 = $arr[$k+1];
				$tmp[$v] = $v2;
			}
		}
		return $tmp;
	}

	$data=str_replace('U:', 's:',$data);		//U站得特别处理一下
	if(($ret = unserialize($data)) === false) {
		$ret = unserialize(stripslashes($data));
	}
	return $ret;
}


function _unserialize($data){
	if($data == '') return array();
	$data = stripslashes($data);
	@eval("\$array = $data;");
	$data = _iconv($data,'GBK','UTF-8');
	$arr = unserialize($data);
    return $arr;
}
function _serialize($data){
	if(!is_array($data)) return $data;
	$rt = (var_export($data, true));

	$rt = serialize($data);
	return $rt;
}



function get_setting($name){
	$value = DB::result_first('SELECT value FROM '.DB::table('setting')." WHERE name='$name'");
	$value = html_entity_decode($value);
	return $value ;
}
function set_setting($name,$value){
	 $value = trim($value);
	$rt = DB::update('setting',array('value'=>$value),"name='$name'");
	 return $rt;
}

function insert_setting($name,$value){
	global $_G;

	if(!$name && !$value){
			foreach($_GET['postdb'] as $k=>$v){

				if(isset($_G['setting'][$k]) || array_key_exists($k,$_G['setting'])){
					set_setting($k,$v);
				}else{
					insert_setting($k,trim($v));
				}
			}

	}else{
		if(isset($_G['setting'][$name]) || array_key_exists($name,$_G['setting'])){
			  set_setting($name,$value);
		  }else{
			  $value = trim($value);
			   DB::insert('setting',array('name'=>$name,'value'=>$value),true);
		  }

	}
	 loadcache('setting','update');
}

function show_tpl($tpl,$arr){
	global $_G,$app;
		if(!defined('TPLNAME')){
			if($_G['setting']['template']){
				define('TPLNAME',$_G['setting']['template']);
			}else{
				if(ERROR){
					if(!class_exists('error')) include_once libfile('class/error');
					error::show_error('system',$msg);
				}else{
					define('TPLNAME','common');
				}
			}
		}

		include_once ROOT_PATH.'web/smarty/Smarty.class.php';
		$smarty =	new Smarty();
		/*include  ROOT_PATH.'web/smarty/SimpleSmarty.php';
		$smarty =	new SimpleSmarty();
		$smarty->compile_dir = ROOT_PATH.'web/templates_c';*/
		$ass = array(
				'TPLNAME'=>TPLNAME ? TPLNAME :'common',
				"IMGDIR"=>IMGDIR,
				"TPLDIR"=> TPLDIR,
				"ASSDIR"=> 'assets/'.TPLNAME.'/'.CURMODULE,
				"TPLDIR"=>'assets/'.TPLNAME.'/',
				"CSSDIR"=> CSSDIR,
				"JSDIR"=> JSDIR,
				"CM"=> CURMODULE,
				"CA"=>CURACTION,
				"TAE"=>TAE ? 1:0,

				"URL"=>URL,
				"SYSTEM_TYPE"=>SYSTEM_TYPE,
		);
		$_G['version'] = TTAE_VERSION;
		$_G['update_time'] = TTAE_UPDATE_TIME;
		if(!$_G['cpmsg']){
				$tae = TAE ? 1 :0;
				$data = array();
				$data[] = $tae;
				$data[] = CURSCRIPT;
				$data[] = CURMODULE;
				$data[] = CURACTION;
				$data[] = $_G[uid];
				$data[] = $_G[username];
				$global_str = implode('|',$data);
				$smarty->assign("global_str", $global_str);
				$safe_get = safe_output($_GET);
				$query_text = http_build_query($safe_get);
				$smarty->assign("query_text",$query_text);
		}

		if($arr && is_array($arr))$ass  = array_merge($ass,$arr);
		$unset = array('table','_config','goods_sql','memory_list','cache_list');
		$tmp = array();
		foreach($_G as $k=>$v){
			if(!in_array($k,$unset)) $tmp[$k]= $v;
		}
		$smarty->assign("_G", $tmp);

		if(defined('IN_ADMIN')){
			$smarty->assign("menu", $_G['menu']);
		}else{

			$ap = new app();
			$data = $ap->data_api();

			if($data && is_array($data))$ass = array_merge($data,$ass);
		}
		foreach($ass as $k=>$v){
			$smarty->assign($k, $v);
		}
		$show_tpl = ROOT_PATH.$tpl;
		if(DB::object()->curlink) DB::object()->close();
		try{
			$smarty->display($show_tpl);
		}catch (Exception $e){
					//$e->trace = '';
					$file = end(explode('\\',$e->getFile()));
					$msg = '<br/> File : '.$file  . ' On line '.$e->getLine() . ' Code '.$e->getCode();
					$msg = $e->getMessage().$msg;
					$msg = str_replace(ROOT_PATH.'view/','',$msg);
					system_error('system',$msg);
					//msg($msg);
					exit;
		}


}

function showmessage($message, $alert='right',$url = '',$ext_msg='') {
	global $_G,$app;
	$_G[cpmsg] = true;

	if(!$url ||  $url == '-1' ||  $url == '?'){
		 $url =dreferer();
	}else if($url == 'index'){
		$url = $_G[siteurl];
	}elseif(strpos($url,'.html') ===false){
		$url = str_replace($_G[siteurl],'',$url);
		if($url == '/' || $url ==''){
			$url = URL;
		}else{
			$url = URL. preg_replace("/.*?\?/is",'',$url);
		}
	}
	$alert  =$alert == 'success' ?'right':$alert;
	$alerttype = 'alert_'.$alert;

	if($_G[setting][mobile_status] ==1 && $_G[mobile]){
		$tpl = 'view/common/mobile_showmessage.php';
	}else{
		$tpl = 'view/common/showmessage.php';
	}

	$arr = array("url"=> $url,"alerttype"=>$alerttype,"message"=>$message,"ext_msg"=> $ext_msg);
	show_tpl($tpl,$arr);
	exit;

}
function msg($message="",$status="error",$url="",$ext_msg=""){
	global $_G;
	define('ERROR',true);
	if(!$status) $status = 'error';
	

	if(($_G['get_content'])){
		$_G['message'] = array('status'=>$status,'msg'=>($message));
		return $message;
	}

	if($_G[inajax] ==1 || defined('APP')){
		json(array('status'=>$status,'msg'=>($message),'url'=>$url,'data'=>$ext_msg));
	}elseif(defined('IN_ADMIN')){
		cpmsg($message,$status,$url,$ext_msg);
	}else{

		showmessage($message,$status,$url,$ext_msg);
	}
}

function cpmsg($message='操作失败', $type = '', $url = '',$title='',$ext_message='') {
	global $_G,$app;
	if(!$url || $url == '?' || $url == '-1'){
		 $url =dreferer();

	}else{
		$url = str_replace($_G[siteurl],'',$url);
		if(substr($url,0,1) != '/')	$url =  URL.preg_replace("/.*?\?/is",'',$url);
	}
	$title = $title ? $title : '点击返回';
	switch($type) {
		case 'succeed': $classname = 'infotitle2';break;
		case 'error': $classname = 'infotitle3';break;
		default: $classname = 'marginbot normal';break;
	}
	$_G[cpmsg] = true;
	$arr = (array("url"=> $url,"title"=>$title,"ext_message"=>$ext_message,'classname'=>$classname,"message"=>$message));

	show_tpl('view/admin/common_admin/cpmsg.php',$arr);

	exit;
}

function output() {
	global $_G;
	if($_G['setting']['login_rewrite'] ==1 &&  $_G['uid']>0) return ;
	if(defined('IN_ADMIN') || $_GET['inajax'] || defined('IN_MOBILE')) return ;
	if($_G['setting']['rewrite'] &&  !$_G[mobile]) {
		$content = ob_get_contents();
		$content = str_replace("<!---->","",$content);
		$content = preg_replace("/(\"|')\/index\.php\?(.*?)(\"|')/ies","rewrite_url('\\2')",$content);
		ob_end_clean();
		echo $content;
	}
}

function rewrite_url($content,$s){
	global $_G;

	if(!$content) return $_G[siteurl];
    preg_match("/\#(.*)$/is", $content, $arr);
    $content = str_replace('&&', '&', $content);
    $exp = "-";
    if ($_G["setting"]["rewrite_mode"] == 1) {
		$exp = "/";
	}
    $content = preg_replace("/\#(.*?)$/is", "", $content);

	//采用新的path info 方式
	if($_G["setting"]["rewrite_mode"] == 2){
		return rewrite_path_info($content).($arr[0] ? $arr[0] : '');
	}

    $content = str_replace(array("?&", '?', '&', '='), array('', '', $exp, $exp), $content);
    $content = str_replace('amp;', '', $content);

    if ($_G["setting"]["rewrite_mode"] == 1) {
        $content = preg_replace("/^\//", '', $content);
    }else{
        $content = preg_replace("/^-/", '', $content);
    }

		$rs = '';
		if ($s) {
            $rs = "'" . '/' . $content . ".html" . ($arr[0] ? $arr[0] : '') . "'";
        } else {
            $rs = "\"" . '/' . $content . ".html" . ($arr[0] ? $arr[0] : '') . "\"";
        }
		return $rs;
}

function rewrite_path_info($url){
		global $_G;


		$url = trim($url,'/');
		$url = trim($url,'&');
		$first = substr($url,0,1);
		$is_add =false;
		$first3 = substr($url,0,3);
		if($first == 'm'){
			$url = str_replace(array('m=','&a='),'/',$url);
		}else if($first  == 'a' && $first3 !='aid'){
			$url = '/index'.str_replace('a=','/',$url);
		}else{
			$url = '/'.str_replace('=','/',$url);
		}
		$url = preg_replace("/&([a-z_]+)=/is","/$1/",$url);

		$search = array('/id','/fid','/itemid','/cid','/num_iid','/aid');
		if(dstrpos($url,$search)) $is_add = true;

		$url =str_replace(array('&','='),'/',$url);

		if(strpos($url,'/id/') !== false) {
			$url = str_replace("/id/",'/',$url);
		}

		$url .= $is_add ? ".html":'/';
		//$_G['rel'][] = $url;
		return $url;
}

function rewrite_check_file($detail){
	$file_type = '.html';
	if($_GET[file_type] && in_array($_GET[file_type],array('txt','html')))$file_type = '.'.$_GET[file_type];

	//if($_GET['file_type'] &&  in_array($_GET[file_type],$file_type)){

		  $count = count($detail);

		  if(is_dir(ROOT_PATH.$detail[0])){
			  if(in_array($detail[0],array('inc','view','top'))){
				 // _header("Location:/index.php");
				 _404();
			  }

			  $path = implode('/',$detail);
			  $file = ROOT_PATH.$path.$file_type;
			  if(is_file($file)){
					$con= file_get_contents($file);
					$con = str_replace(array('<?php','<?','?>'),'',$con);
					echo $con;
					exit;
			  }else{
				_404();
			  }

		  }elseif( is_file(ROOT_PATH.$detail[0].$file_type)){
				  $file=ROOT_PATH.$detail[0].$file_type;
					$con= file_get_contents($file);
					$con = str_replace(array('<?php','<?','?>'),'',$con);
					echo $con;
					exit;
		  }
	//}
}
function _404($url=''){
				_header("HTTP/1.1 404 Not Found");
				_header("Status: 404 Not Found");

				 if($url){
					_header('location:'.$url);
				 }else{
				 $sys = $_SERVER['SERVER_SOFTWARE'];
$c404="<html>
<head><title>404 Not Found</title></head>
<body bgcolor='#fff'>
<center><h1>404 Not Found</h1></center>
<hr><center>".$sys."</center>
</body>
</html>";
				echo $c404;
				 }
				exit;
}

function json2($arr){
			global $_G;
			ob_clean();
			header("KissyIoDataType:json");
			header('Content-Type: text/json; charset='.CHARSET);

			$rs = array('status'=>'error','msg'=>'','data'=>'');

			if(is_array($arr)){
				foreach($arr as $k=>$v){
					$rs[$k] = $v;
				}
			}else{
				$rs['msg'] =$arr;
			}
			if($rs['msg'] && (strpos($rs['msg'],'>') !==false || strpos($rs['msg'],'<') !==false)){
					$rs['msg'] = dhtmlspecialchars($rs['msg']);
			}

   			echo json_encode($rs);
			exit;
}

function json($arr){
			global $_G;
			header("KissyIoDataType:json");
			header('Content-Type: application/json; charset='.CHARSET);
			//header( 'Content-Type: text/json' );

			if(DB::object()->curlink) DB::object()->close();
			$rs = array('status'=>'error','msg'=>'','data'=>'','login'=>0,'html'=>0);
			if(is_array($arr)){
				foreach($arr as $k=>$v){
					$rs[$k] = $v;
				}
			}else{
				$rs['msg'] =$arr;
			}
			if($rs['msg'] && (strpos($rs['msg'],'>') !==false || strpos($rs['msg'],'<') !==false)){
					$rs['msg'] = dhtmlspecialchars($rs['msg']);
					$rs['html'] = 1;
			}
			//兼容APP的json
			if(defined('APP')){
				unset($rs['html'],$rs['login'],$rs['url']);
				//$rs['uid']=$_G[uid];
				//$rs['username'] = $_G[username];
			}
   			echo json_encode($rs);
			exit;
}

function update_table(){
		global $_G;

		$tablepre =$_G[_config][db][tablepre];
		$table = DB::fetch_all("SHOW TABLES");
			foreach($table as $k=>$v){
				if(is_array($v)){
					foreach($v as $kk=>$vv){
						if(preg_match("/".$tablepre."/is",$vv)){
								$name = str_replace($tablepre,'',$vv);
								$arr[$name] =	array();
								$rs =  DB::fetch_all("SHOW FULL FIELDS FROM $vv");
								foreach($rs as $k1=>$v1){
										$f =array(
											//'name'=>$v1['Field'],
											'type'=> preg_replace("/\(.*/",'',$v1['Type']),
											//'default'=>$v1['Default'],
											//'pre'=> $v1['Extra'] == 'auto_increment' ? true :false
										);
										if($v1['Extra'] == 'auto_increment') $f[pre]=true;
										$arr[$name][$v1['Field']] = $f;

							 }
						}
					}
				}
			}

			//写缓存,字段一定要写文件缓存.
			writetocache('table',arrayeval($arr));
			copy(ROOT_PATH.'web/cache/cache_table.php',ROOT_PATH.'inc/config/cache_table.php');
			$_G[table] = $arr;
			return $arr;
}

function table($table_name=''){
			global $_G;
			if($_G[table] && count($_G[table])>0){
				if($table_name){
					return $_G[table][$table_name];
				}else{
					return $_G[table];
				}
			}

			$arr  = include (ROOT_PATH.'inc/config/cache_table.php');
			$_G[table]=$arr;
			if($table_name){
				return $arr[$table_name];
			}else{
				return $arr;
			}
}



function get_filed($name,$data='',$id=''){
		global $_G;
		$arr = array();

		if(!$_G[table][$name]) $_G['table'][$name]=table($name);
		$int = array('int','tinyint','decimal','smallint','float');
		$float = array('decimal','float');
		$times = array('start_time','end_time','dateline','posttime','regdate','login_time');


		foreach($_G[table][$name] as $k=>$v){
				//表单中提交的数据,和数据库中的字段名和类型对比
				if($data && is_array($data)){
								if($v['pre']) continue;
								if($id){	//编辑
									if(isset($data[$k])){
										if(in_array($k,$times)){
											$arr[$k] = $data[$k] ?  dmktime($data[$k]) : 0;
										}elseif(in_array($v[type],$float))	{
											$arr[$k] =  $data[$k] ? floatval($data[$k]):0;
										}elseif(in_array($v[type],$int)){
											$arr[$k] = $data[$k] ? intval($data[$k]) : 0;
										}elseif(is_string($data[$k])){
											$arr[$k] = $data[$k] ?trim($data[$k]) :'';
										}else{
											$arr[$k] = $arr[$k] ? $data[$k] : '';
										}
									}
								}else{   //添加发布
									if(in_array($k,$times)){
										$arr[$k] = $data[$k] ?  dmktime($data[$k]) : 0;
									}elseif(in_array($v[type],$float))	{
										$arr[$k] =  $data[$k] ? floatval($data[$k]):0;
									}elseif(in_array($v[type],$int)){
										$arr[$k] = $data[$k] ? intval($data[$k]) : 0;
									}elseif(is_string($data[$k])){
										$arr[$k] = $data[$k] ?trim($data[$k]) :'';
									}else{
										$arr[$k] = $arr[$k] ? $data[$k] : '';
									}
								}
				}else{

					if($v['pre']) continue;
					if(in_array($k,$times)){
						$arr[$k] =  0;
					}elseif(in_array($v[type],$float))	{
						$arr[$k] = 0;
					}elseif(in_array($v[type],$int)){
						$arr[$k] =  0;
					}elseif(is_string($data[$k])){
						$arr[$k] ='';
					}else{
						$arr[$k] ='';
					}

				}
		}

	unset($arr['dateline'],$arr['posttime']);
	return $arr;
}

function get_siteurl() {
		global $_G;

			$siteurl = '';
			$scriptName = basename($_SERVER['SCRIPT_FILENAME']);
			if(basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
				$siteurl = $_SERVER['SCRIPT_NAME'];
			} else if(basename($_SERVER['PHP_SELF']) === $scriptName) {
				$siteurl = $_SERVER['PHP_SELF'];
			} else if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
				$siteurl = $_SERVER['ORIG_SCRIPT_NAME'];
			} else if(($pos = strpos($_SERVER['PHP_SELF'],'/'.$scriptName)) !== false) {
				$siteurl = substr($_SERVER['SCRIPT_NAME'],0,$pos).'/'.$scriptName;
			} else if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['DOCUMENT_ROOT']) === 0) {
				$siteurl = str_replace('\\','/',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));
				$siteurl != '/' && $siteurl = '/'.$siteurl;
			}elseif(count( explode("/",$_SERVER[PHP_SELF]))>2){
				$siteurl=$_SERVER[PHP_SELF];
			} else {
				$siteurl ='http://'.$_SERVER['HTTP_HOST'];
			}
		$siteurl= dhtmlspecialchars($siteurl);
		$sitepath = substr($siteurl, 0, strrpos($siteurl, '/'));
		$sitepath = preg_replace("/\/$/is",'',$sitepath);
		$_G['siteurl'] = dhtmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$sitepath);

		return $_G['siteurl'];
}

function dump($arr='',$exit=false){
	if(defined('IN_ADMIN')) $ss = "padding-left:160px";
	echo "<br><br><pre style='text-align:left;{$ss}'>";
	var_dump($arr);
	echo "</pre><br><br>";
	if($exit)exit;
}



function _json_decode($json, $assoc = true) {
		$comment = false;
		$out     = '$x=';
		$json = preg_replace('/:([^"}]+?)([,|}])/i', ':"\1″\2', $json);
		for ($i=0; $i<strlen($json); $i++) {
		if (!$comment) {
		if (($json[$i] == '{') || ($json[$i] == '[')) {
		$out .= 'array(';
		}
		elseif (($json[$i] == '}') || ($json[$i] == ']')) {
		$out .= ')';
		}
		elseif ($json[$i] == ':') {
		$out .= '=>';
		}
		elseif ($json[$i] == ',') {
		$out .= ',';
		}
		elseif ($json[$i] == '"') {
		$out .= '"';
		}
		}
		else $out .= $json[$i] == '$' ? '\$' : $json[$i];
		if ($json[$i] == '"' && $json[($i-1)] != '\\')  $comment = !$comment;
		}

		eval($out. ';');
		return $x;
}


function _json_encode($array = array()) {
		if(!is_array($array)) return NULL;
		$json = "";
		$i = 1;
		$comma = ",";
		$count = count($array);
		foreach($array as $k=>$v){
				if($i==$count) $comma = "";
				if(!is_array($v)){
					$v = daddslashes($v);
					$json .= '"'.$k.'":"'.$v.'"'.$comma;
				}
				else{
					$json .= '"'.$k.'":'._json_encode($v).$comma;
				}
			$i++;
		}
		$json = '{'.$json.'}';
		return $json;
}

function get_keywords($title='',$content='',$type = 'auto'){
	global $_G;
	$type  = $type == 'auto' ? $_G['setting']['auto_keywords'] : $type;
	if(!class_exists('keywords')) include_once libfile('class/keywords');
	$kw = new keywords($type);
	$title = trim_html($title,1);
	return $kw->get($title,$content);
}


function _iconv($arr,$in,$out){
	$out = $out ? $out :CHARSET;
	if(is_array($arr)) {
		foreach($arr as $k=>$v){
			$arr[$k] =_iconv($v,$in,$out);
		}
	}else if(is_string($arr)){

		$arr = iconv($in,$out,$arr);
	}
	return $arr;
}




function check_yzm($yzm){
	global $_G;

	if($yzm){
		$yzm = trim($yzm);
	}else if($_GET[yzm]){
		$yzm = trim($_GET[yzm]);
	}else{
		return false;
	}

	$code = strtolower($_SESSION[yzm]);
	$yzm = strtolower($yzm);
	if($yzm != $code) {
		referer_yzm();
		return false;
	}else{
		referer_yzm();
		return true;
	}


}

//刷新验证码
function referer_yzm($show){
		if(!class_exists('yzm'))include_once libfile('class/yzm');
		$yzm5=new yzm();
		if(!$show){
			$code= $yzm5->randText();
			$_SESSION[yzm] =$code;
			return $code;
		}
		$yzm5->setWidth(160); 	//@设置验证码宽度
		$yzm5->setHeight(60); 	//@设置验证码高度
		$yzm5->setFontFamily(ROOT_PATH.'assets/global/fonts/font-1.ttf');
		$yzm5->setTextNumber(4); 	//@设置字符个数
		$yzm5->setFontColor('#666'); 	//@设置字符颜色
		$yzm5->setFontSize(30); 		//@设置字号大小
		//$yzm5->setTextLang('cn'); 	//中文必须是中文字体
		$yzm5->setBgColor('#FFFFFF'); 	//@设置背景颜色
		$yzm5->setNoisePoint(0); 		//@设置干扰点数量
		$yzm5->setNoiseLine(0); 		//@设置干扰线数量
		$yzm5->setDistortion(false); 	//@设置是否扭曲
		$yzm5->setShowBorder(true); 	//@设置是否显示边框
		header("Content-type:image/png");
		$code=$yzm5->createImage(); 	//输出验证码
		$_SESSION[yzm] = $code;
}


function unicode_encode($name,$in_charset="UTF-8")
{
    $name = iconv($in_charset, 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {    // 两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}


function unicode_decode($unistr, $encoding = 'UTF-8', $prefix = '&#', $postfix = ';') {

	if(!$unistr) return $unistr;
	if(is_array($unistr)){
			foreach($unistr as $k=>$v){
				$unistr[$k]=unicode_decode($v,$encoding,$prefix,$postfix);
			}
	}else if(is_string($unistr)){
			$arruni = explode($prefix, $unistr);
			$unistr = '';
			for($i = 1, $len = count($arruni); $i < $len; $i++) {
				if (strlen($postfix) > 0) {
					$arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
				}
				$temp = intval($arruni[$i]);
				$unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
			}
			$unistr = iconv('UCS-2', $encoding, $unistr);
	}
    return $unistr;
}



function error_handler($errorType, $errorMsg, $errorFile, $errorLine ) {
	/*$error_types = array(1,4,16,64,256);
	if(in_array($errorType,$error_types)){
  	 	$msg = ("Run Error: ". $errorType."<br/>MSG: ".$errorMsg."<br/>File: " .$errorFile ."<br/>Line: ".$errorLine);
		system_error('system',$msg);
		// throw new Exception($errorMsg, 0, $errorType, $errorFile, $errorLine);
	}*/

}

function get_client_ip() {
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
			foreach ($matches[0] as $xip) {
				if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
					$ip = $xip;
					break;
				}
			}
		}
		$ip = trim_html($ip,1);
		return $ip;
}

function _session_start($expire = 0){
			if ($expire == 0) {
				$expire = ini_get('session.gc_maxlifetime');
			} else {
				ini_set('session.gc_maxlifetime', $expire);
			}
			if (empty($_COOKIE['PHPSESSID'])) {
				session_set_cookie_params($expire);
				session_start();
			} else {
				session_start();
				setcookie('PHPSESSID', session_id(), time() + $expire);
			}
}


function cache($key,$val,$time){
		if(!class_exists('cache')) include libfile('class/cache');
		$cache_server=new cache();
		if($val){
			return $cache_server->set($key,$val,$time);
		}else{
			return $cache_server->get($key);
		}
}


//parse_arr = 解析每一列成数组返回
function load_excel($file,$parse_arr = true,$del = false){
	include_once ROOT_PATH."inc/class/excel_reader2.class.php";

	$load_file = ROOT_PATH.ltrim($file,'/');
	if(!is_file($load_file))
	if(!file_exists($load_file)) {
		msg('要读取的文件不存在');
	}
	$ext = end(explode('.',$load_file));

	if(!in_array($ext,array('xlsx','xls'))){
		msg('文件非excel文件格式');
	}

	$data = new Spreadsheet_Excel_Reader($load_file);
	$rs= $data->sheets[0]['cells'];
	if($del) unlink($load_file);
	if($parse_arr){
		$arr = array();
		foreach($rs as $k=>$v){
			$tmp = array();
			foreach($rs[1] as $k1=>$v1){
				$tmp[] = $v[$k1];
			}
			$arr[] = $tmp;
		}

		return $arr;
	}

	return $rs;
}

function load_cvs($file,$del=true){
	include_once ROOT_PATH."inc/class/csv.class.php";
	$load_file = ROOT_PATH.ltrim($file,'/');
	if(!is_file($load_file))
	if(!file_exists($load_file)) {
		msg('要读取的文件不存在');
	}

	$cvs = new Csv();
	$rs = $cvs->import($load_file);
	if($del) unlink($load_file);
	if(!$rs ||!is_array($rs) || count($rs) == 0)msg($cvs->msg);
	//$rs = _iconv($rs,'GBK',CHARSET);
	return $rs;

}


/*
	$node = array(array('el'=>'css的选择器','attr'=>'text || el属性节点 ','name'=>'返回后数组键值','replace'=>'待替换的内容','content'=>'替换后的内容'));
	$node 是一个多维数组
	$el = html元素节点,可是为css的选择器
	attr = text,获取文本内容,否则就是获取el节点attr
	name = 返回数组中的键名

*/
function dom($html_dom, $node = array()) {

    if (!class_exists('ParserDom')) {
        include_once ROOT_PATH . 'inc/class/dom/ParserInterface.php';
        include_once ROOT_PATH . 'inc/class/dom/ParserAbstract.php';
        include_once ROOT_PATH . 'inc/class/dom/ParserDom.php';
    }

    $html_dom = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>' . $html_dom;
    $dom = new ParserDom($html_dom);
    $arr = array();
    foreach ($node as $k => $v) {
        $find = $dom->find($v['el']);
        foreach ($find as $k1 => $v1) {
            if ($v['attr'] == '' || $v['attr'] == 'text') {
                $value = $v1->getPlainText();
            } else {
                $value = $v1->getAttr($v['attr']);
            }
            if ($v['replace']) {
                $con = $v['content'] ? $v['content'] : '';
                $value = str_replace($v['replace'], $con, $value);
            }
            $name = $v['name'];
            $arr[$k1][$name] = $value;
        }

    }
    unset($dom);
    return $arr;
}

//从HTML中获取出后有文字
function get_text($html_dom,$length){
	$html_dom  = "<div class='get_text_box'>".$html_dom."</div>";
	$el = array(array('el'=>'.get_text_box','attr'=>'text','name'=>'content'));
	$arr = dom($html_dom,$el);
	$content = $arr[0]['content'];
	if($length && $length>0)$content = cutstr($content,$length,'');
	return $content;

}

//格式化小数位
function fix($price,$len =2 ){
	//$price  = $price+ 10005423.2541236;
	//$price =number_format($price,$len,'.','');

	$price =sprintf("%.".$len."f",$price);

	$price = rtrim($price,'0');
	$price = (float)rtrim($price,'.');
	//$price = round($price,$len);
	return $price;

	$size = 100;
	if($len == 1) {
		$size = 10;
		$price=floor($price*$size)/$size;
	}elseif($len == 0){
		$price= intval($price);
	}
	return $price;
}


function _header($string, $replace = true, $http_response_code = 0) {
	$islocation = substr(strtolower(trim($string)), 0, 8) == 'location';

	$string = str_replace(array("\r", "\n"), array('', ''), $string);
	if(empty($http_response_code) || PHP_VERSION < '4.3' ) {
		@header($string, $replace);
	} else {
		@header($string, $replace, $http_response_code);
	}
	if($islocation) {
		$url = str_replace('Location:','',$string);
		echo '<script type="text/javascript">window.location.href = "'.$url.'";</script>';
		exit();
	}
}
function end_time($end_time,$start_time){
	$time = $start_time?$start_time:TIMESTAMP;
	$end_time = is_numeric($end_time) ? $end_time: dmktime($end_time);
    $interval = $end_time - $time;

	$text = '';
	switch($interval){
		case $interval>86400*30:
			$text = intval($interval/(86400*30)).'月';
			$text .=intval(ceil($interval%86400*30)/86400).'天';
			//$text .=intval(ceil($interval%3600)/60).'小时';
		break;
		case $interval>86400:
			$text =intval($interval/86400).'天';
			$text .=intval(ceil($interval%86400)/3600).'小时';
			$text .=intval(ceil($interval% (3600))/60).'分';
		break;
		case $interval>3600:
			$text =intval($interval/3600).'小时';
			$text .=intval(ceil($interval%3600)/60).'分';
			$text .=intval(ceil($interval%60)).'秒';
		break;
		case $interval>60:
			$text =intval($interval/(60)).'分';
			$text .=intval(ceil($interval%60)).'秒';
		break;
		case $interval>0:
			$text =intval($interval).'秒';
		break;
	}
	return $text;

}

function end_time2($end_time,$start_time){
	$time = $start_time?$start_time:TIMESTAMP;
    //$kaoyantime  = '2014-01-04';//（设置倒计时日期,可再添加一行新命名一个函数加一个倒计时）
    //$kaoyantime  = strtotime($kaoyantime);

	$end_time = is_numeric($end_time) ? $end_time: dmktime($end_time);
    $interval = $end_time - $time;

    $days = $interval/(24*60*60);//精确到天数
    $days = intval($days);

    $hours = $interval /(60*60) - $days*24;//精确到小时
    $hours = intval($hours);

    $minutes = $interval /60 - $days*24*60 - $hours*60;//精确到分钟
    $minutes = intval($minutes);

    $seconds = $interval - $days*24*60*60 - $hours*60*60 - $minutes*60;//精确到秒
    $seconds = intval($seconds);

	$rt = $days."天".$hours."小时".$minutes."分";

    return $rt;
}




function hight_link($txt='',$linkdatas=array() ,$url='', $replacenum = 15){
	global $_G;

	if(!is_array($linkdatas)) $linkdatas = explode(',',$linkdatas);
	if(!$url) return $txt;

	$linkdatas = array_filter($linkdatas);
	$linkdatas = array_unique($linkdatas);
	if(!$linkdatas || count($linkdatas) ==0) return $txt;

	//暂时屏蔽超链接
	$txt = preg_replace("/(<a(.*))(>)(.*)(<)(\/a>)/isU", '\\1-]-\\4-[-\\6', $txt);
	$_G['replaced'] = array();

		$word = $replacement = array();
		foreach($linkdatas as $v){
		   $word[] = $v;
		   $_G['replaced'][$v] = 0;
		   $link_url = ($url. urlencode_utf8($v));
		   $replacement[] = '<a href="'.$link_url.'" target="_blank" class="hight_link">'.$v.'</a>';
	 	 }

	$txt = preg_replace("/(^|>)([^<]+)(?=<|$)/sUe", "_highlight('\\2', \$word, \$replacement, '\\1',\$replacenum)", $txt);
	//恢复超链接
	$txt = preg_replace("/(<a(.*))-\]-(.*)-\[-(\/a>)/isU", '\\1>\\3<<A href="file://\\4">\\4', $txt);
	return $txt;
}

//高亮专用, 替换多次是可能不能达到最多次
function _highlight($string, $words, $result, $pre ,$cfg_replace_num){
	global $_G;

	$string = str_replace('\"', '"', $string);
	if($cfg_replace_num > 0){
		  foreach ($words as $key => $word)  {
				if($_G['replaced'][$word] == 1)   continue;
			 $string = preg_replace("/".preg_quote($word)."/", $result[$key], $string, $cfg_replace_num);
			   if(strpos($string, $word) !== false){
				$_G['replaced'][$word] = 1;
			   }
		  }
	}else{
 		 $string = str_replace($words, $result, $string);
  }

	return $pre.$string;
}

function getUrlParam($url){
		$query = parse_url($url);
		$query = $query['query'];
	    $queryParts = explode('&', $query);
	    $params = array();
	    foreach ($queryParts as $param) {
	        $item = explode('=', $param);
	        $params[$item[0]] = $item[1];
	    }
	    return $params;
	}


?>
