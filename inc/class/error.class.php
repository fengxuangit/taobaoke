<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
class error
{

	public static function db_error($message) {
		global $_G;	
		
				$db = DB::object();
				
				if(method_exists($db,'errorInfo')){
					$dberrno = $db->errorInfo();
					$sql = $db->currentSql;
					$dberror = str_replace(DB::table(),  '', $db->errorInfo());
				}else{
					$dberror = $message;
				}
				if(stristr($dberror,'** BEGIN NESTED EXCEPTION **')){
					$dberror = '<br/>'.$dberror;
					$dberror = nl2br($dberror);
				}
				$sql = dhtmlspecialchars(str_replace(DB::table(),  '', $sql));


				$msg = '';
				$msg .=  '<li>[Message] 数据库执行错误,请检查错误日志</li>';
				if($dberror != $message)$msg .= $dberrno ? '<li>[info] '.$dberror.'</li>' : '';					
				//if($_GET[debug]==$_G[setting][debug_str]){
							$msg .= $sql ? '<li>[Query] '.$sql.'</li>' : '';							
							$msg .= $message ? "<li>[msg] ".$message."</li>" :'';						
				//}
				
					$msg.="\r\n";
					$write_msg = '错误信息:'.$msg."\r\n\r\n,--错误sql:".$sql.",\r\n--错误提示:".$message."\r\n\r\n";
				
				L($write_msg,1); 
				
				
				if(($_G[mobile] && $_G[inajax]) || (defined('FETCH') || defined('API'))){
					if($_GET[debug]==$_G[setting][debug_str]){
						msg('数据库执行错误:'.$write_msg,'error');
					}else{
						msg('数据库执行错误:'.$dberror,'error');
					}
				}
				$_G['error_msg'] =$sql; 
				error::show_error('db', $msg);
	}

	public static function show_error($type, $errormsg, $phpmsg = '', $typemsg = '') {
		global $_G,$app;
		
		if(defined('API') && API === true )exit;
		if($_G[mobile]){
			msg($errormsg,'error');
		}else if(defined('FETCH') || defined('APP')){
			json($errormsg);
		}else if($_G[inajax]){
			msg($errormsg,'error');
		}
		
		seo('Error  by优淘TAE系统');
		$title = $type == 'db' ? 'Database Error' : 'System Error';
		$str='<link rel="stylesheet" type="text/css" href="assets/global/css/global.css" media="all" />';
		$str .= '<div class="system_error"><div class="error_main"><a class="y go_home" href="'.$_G[siteurl].'">返回首页</a><h1>'. $title
				.' by uz-system </h1><div class="info">'.$errormsg.' </div>';	
		$helplink = "<a href='http://help.uz-system.com' target=\"_blank\"><span>Need Help? open http://help.uz-system.com</span></a>";
		$str .= '<div class="help">Note. '.$helplink.'</div>';

ob_clean();


$str='<!doctype html>
<html>
<head>
<title>Error  by优淘TAE系统</title>
<meta name="robots" content="noindex,nofollow">
<meta http-equiv="Content-Type" content="text/html; charset='.CHARSET.'" />
</head>
<body class="taeapp system_error">
'.$str."
</body></html>";

	
		echo $str;
		die();
		
	}
	
	
	public static function writeErrorLog($msg) {
		global $_G;

		$msg = trim_html($msg);
		
		$time = date('Y-m-d H:i:s',time());
		$file = ROOT_PATH . 'web/log/' . date('Y.m.d') . '_errorlog.php';		
		$dir = dirname($file);
		if(!is_dir($dir)  && !TAE) dmkdir($dir);
		if (!is_file($file))  file_put_contents($file,"<?php exit;?>\r\n");
	
		$message = "\r\ntime={$time} ;username=". ($_G[username]) . ' ;IP:'. $_SERVER['REMOTE_ADDR']." ;";
		$message.="\rmsg={$msg};";
		$url = $_SERVER['REQUEST_METHOD'].':'.$_SERVER['HTTP_HOST'].'?'.$_SERVER['QUERY_STRING'];
		$message .="\rRequest_URL =".$url;
		if($_SERVER[HTTP_REFERER])$message .="\rReferer =".$_SERVER[HTTP_REFERER];

		// 判断该$message是否在时间间隔$maxtime内已记录过，有，则不用再记录了		
		
		$fp = @fopen($file, 'rb');
		$lastlen = 50000;		// 读取最后的 $lastlen 长度字节内容
		$maxtime = 60 * 10;		// 时间间隔：10分钟
		$offset = filesize($file) - $lastlen;
		if ($offset > 0) {
			fseek($fp, $offset);
		}
		if ($data = fread($fp, $lastlen)) {
			$array = explode("\n", $data);
			if (is_array($array))
				foreach ($array as $key => $val) {
					$row = explode("\t", $val);
					if ($row[0] != '<?php exit;?>') {
						continue;
					}
					if ($row[3] == $hash && ($row[1] > $time - $maxtime)) {
						return;
					}
				}
		}
		

		error_log($message, 3, $file);
	}

	/**
	 * 清除文本部分字符
	 *
	 * @param string $message
	 */
	public static function clear($message) {
		return str_replace(array("\t", "\r", "\n"), " ", $message);
	}

	/**
	 * sql语句字符清理
	 *
	 * @static
	 * @access public
	 * @param string $message
	 * @param string $dbConfig
	 */
	public static function sqlClear($message) {
		$message = self::clear($message);
		$message = htmlspecialchars($message);
		return $message;
	}



}