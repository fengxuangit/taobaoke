<?php
define('IN_TTAE',true);
define('TODAY',strtotime(date('Y-m-d')));
define('TOMORROW',strtotime(date('Y-m-d',strtotime("+1 day"))));
define('TOMORROW_2',strtotime(date('Y-m-d',strtotime("+2 day"))));
if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Shanghai');
define('TIMESTAMP', time());


class application {
	static	function init($init = true){
					define('CHARSET', 'UTF-8');
					

					if(is_file(ROOT_PATH.'install.php')){
						header("Location:install.php");
						exit;
					}

					if(!defined('URL'))define('URL','/'.CURSCRIPT.'.php?');
					header('Content-Type: text/html; charset='.CHARSET);
					if(CURSCRIPT == 'index'){
						if(isset($_SERVER['QUERY_STRING']) || (isset($_SERVER['REDIRECT_URL']) &&  $_SERVER['REDIRECT_URL'] =='index.html'  )){
							if(is_file(ROOT_PATH.'index.html')){
								echo file_get_contents(ROOT_PATH.'index.html');
								exit;
							}
						}
					}


					$method = strtolower($_SERVER['REQUEST_METHOD']);
					if($method != 'get' && $method != 'post' ) {
						exit;
					}


					if(isset($_GET['debug']) && function_exists('xhprof_enable')){
						xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
					}

					if(defined('IN_ADMIN') && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['a']) && $_POST['a'] =='setting'){
						
					}else{
						$safe_file = ROOT_PATH.'inc/function/safe_check.function.php';
						if(is_file($safe_file)) include_once $safe_file;
					}
					include 	 ROOT_PATH . 'inc/class/app.class.php';
		 			include_once ROOT_PATH.'inc/function/core.function.php';
					include_once ROOT_PATH.'inc/function/extends.function.php';
					include_once ROOT_PATH.'inc/function/tae.function.php';

					if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) {
			            $postData=file_get_contents('php://input', true);
			            if($postData){
			                parse_str ($postData,$_POST);
			            }
			        }
			        
					define('DEBUG', isset($_GET['debug']) ? true:false);
					//set_error_handler('error_handler');
					_xss_check();


					if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
						foreach($_POST as $k=>$v){
							if(!isset($_GET[$k]))  $_GET[$k] =  ($v);
						}
					}

					self::_init_tae();
					self::_init_rewrite();

					foreach($_GET as $k=>$v){
						$k1 = trim_html($k,1);
						//$v1 = safe_filter($v);
						$v1 = defined('IN_ADMIN') && $_GET['m'] != 'login' ? $v: safe_filter($v);
						$_GET[$k1] = $v1;
					}




					define('ROBOT',checkrobot());

					if(ROBOT && defined('IN_ADMIN')) _404();

					if($init){
							ob_start();
							self::_init_global();
							self::_init_web();
							self::_init_db();
							self::_init_cache();
							self::_init_mobile();
							self::_init_tpl();
							self::_init_user();
					}

	}



	 static function _init_tae(){
					$tae = false;
					if(class_exists('Alibaba')){
						define("TOP_SDK_WORK_DIR","/ace/log/");
						$tae = true;
					}
					define('TAE', $tae);
	}

	static  function _init_global(){
					global $_G;

					include_once ROOT_PATH .'inc/config/db.config.php';


					$_G = array(
								  'uid' 			=> 		0,
								  'adminid' 		=> 		0,
								  'siteurl'			=>		'http://'.$_SERVER['HTTP_HOST'].'/',
								  'clientip'		=>		get_client_ip(),
								  'referer' 		=> 		empty($_SERVER['HTTP_REFERER']) ?'':$_SERVER['HTTP_REFERER'],
								  'host'			=>		$_SERVER['HTTP_HOST'],
								  'domain'			=>		$_SERVER['HTTP_HOST'],
								  'username'		=> 		'',
								  'is_show'			=>		false,
								  'cpmsg'			=>		false,
								  'login_img'		=> 		'',
								  'cache_type'		=> 		$_config['cache_type'],
								  'today'			=>		strtotime(date('Y-m-d')),
								  'tomorrow'		=>		strtotime(date('Y-m-d',strtotime("+1 day"))),
								  'authkey'			=> 		$_config['authkey'],
								  'inajax'			=>		isset($_GET['inajax']) && intval($_GET['inajax']) >0 ? true :false,
								  'id' 				=> 		isset($_GET['id']) && $_GET['id']>0 ? intval($_GET['id']):0,
								  'aid' 			=> 		isset($_GET['aid']) && $_GET['aid']>0 ? intval($_GET['aid']):0,
								  'fid'				=> 		isset($_GET['fid']) && $_GET['fid']>0 ? intval($_GET['fid']):0,
								  'cate'			=> 		isset($_GET['cate']) &&$_GET['cate']>0 ? intval($_GET['cate']):0,
								  'page' 			=> 		isset($_GET['page']) &&$_GET['page']>0 ? intval($_GET['page']):1,
								  'page_end'		=>		'',
								  'qq_zone'			=>		0,
								  'mobile'			=>		false,
								  'pad'				=>		false,
								  'html'			=>		isset($_GET['html']) ? 1:0,

								  '_config'			=>		$_config,
								  'goods_sql'		=>		array(),
								  'memory_list'		=>		array(),
								  'goods_cache'		=>		array(),
								  'member'			=> 		array(),
								  'user'			=> 		array(),
								  'setting'			=> 		array(),
								  'api_list'		=>		array(),
								  'channel' 		=> 		array(),
								  'channels' 		=> 		array(),
								  'friend_link' 	=> 		array(),
								  'goods' 			=> 		array(),
								  'pics_type' 		=> 		array(),
								  'pics' 			=> 		array(),
								  'ad' 				=> 		array(),
								  'table' 			=> 		array(),
								  'showpage'		=>		'',
								  'keywords'		=>		'',
								  'description'		=>		'',
								  'TOP'=>NULL,

					);
					if(DEBUG){
						$_G['starttime'] = microtime(true);
						$_G['runtime'] = 0;
					}



					if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) $_G[inajax]=1;

					$_G['siteurl'] = get_siteurl();
					$_G['siteurl2']  =  $_G['siteurl'];
					unset($_config);


	}

	static function _init_web(){
					global $_G;

					_session_start(86400);
					
					if(!TAE && function_exists('ini_set')) {
						ini_set('memory_limit', '128m');
						ini_set('date.timezone','Asia/Shanghai');
						ini_set("max_execution_time",60);
					}


					include_once libfile('function/web');

					define('MAGIC_QUOTES_GPC', function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc());
					if(MAGIC_QUOTES_GPC) {
						$_GET = dstripslashes($_GET);
						$_POST = dstripslashes($_POST);
						$_COOKIE = dstripslashes($_COOKIE);
					}

					$prelength = strlen('ttae_');
					if(count($_COOKIE)>0){
							foreach($_COOKIE as $key => $val) {
								if(substr($key, 0, $prelength) == 'ttae_') {
									//$val = trim_html($val,1);
									$_G['cookie'][substr($key, $prelength)] = $val;
								}
							}
					}

					



	}

	static function _init_rewrite(){

					if(!defined('IN_ADMIN') && isset($_GET['rewrite']) && $_GET['rewrite']) {
                        $rewrite = str_replace(array('amp;', '\'', '"', '<', '>', '*', ')', '('), '', $_GET['rewrite']);
                       	$rewrite =  trim($rewrite,'/');
						$rewrite =  trim($rewrite,'-');

                        if (strpos($rewrite, "/")  !== false) {
                             $exp_str = "/";
							 $rewrite = str_replace('//', $exp_str, $rewrite);
                        }else{
                            $exp_str = "-";
							 $rewrite = str_replace('--', $exp_str, $rewrite);
                        }

                        $detail=explode($exp_str,$rewrite);
                        if(count($detail)>16) system_error('system','请求来源失败');

							//是个目录,就读取目录中的文件
							if(is_dir(ROOT_PATH.$detail[0])){
								//rewrite_check_file($detail);
							}elseif(count($detail)==1){
							//伪静态和 已经存在HTML文件 分区分
								//rewrite_check_file($detail);
								$_GET['m']=$detail[0];
							}elseif($detail[0] == 'm'){
								for($i=0;$i<count($detail) ;$i++ ){
									$_GET[$detail[$i]] = $detail[++$i];
								}
							}elseif($detail[0] == 'u'){
								$_GET['m']='index';
							}elseif($detail[0] == 'a'){
									$_GET['m']='index';
									$_GET['a']=$detail[1];
									for($i=2;$i<count($detail) ;$i++ ){
										$_GET[$detail[$i]] = $detail[++$i];
									}
							}elseif($detail[0] == 'fid' || $detail[0] == 'aid'|| $detail[0] == 'itemid'){
								if($detail[0] == 'fid'){
									$_GET['m']='channel';
									$_GET['fid']=intval($detail[1]);
								}elseif($detail[0] == 'aid'){
									$_GET['m']='goods';
									$_GET['aid']=($detail[1]);
								}else if( $detail[0] == 'itemid'){
									$_GET['m']='goods';
									$_GET['itemid']=($detail[1]);
								}

								for($i=2;$i<count($detail) ;$i++ ){
									$_GET[$detail[$i]] = $detail[++$i];
								}
							}elseif($detail[0] == 'kw'){
								$_GET['m']='index';
								$_GET['a']='search';
								$_GET['kw'] = $detail[1];
							}elseif($detail[0] == 'mobile'){
								$_GET['m']='index';
								$_GET['a']='main';
								$_GET['mobile'] = $detail[1] =='yes' ? 'yes':'no';

							}else if(count($detail)==2 || is_numeric($detail[1])){

								$_GET['m'] = $detail[0];
								if(is_numeric($detail[1])){
									$_GET['id'] = intval($detail[1]);
								}else{
									$_GET['a'] = $detail[1];
								}

								for($i=2;$i<count($detail) ;$i++ ){
										$_GET[$detail[$i]] = $detail[++$i];
								}
							}else if($detail[1]=='list'){
									$_GET['m']=$detail[0];
									$_GET['a']='list';
									for($i=2;$i<count($detail) ;$i++ ){
										$_GET[$detail[$i]] = $detail[++$i];
									}
							}else if(count($detail)==3){

								$_GET['m'] = $detail[0];
								if(is_numeric($detail[2])){
									$_GET['a'] =$detail[1];
									$_GET['id'] = intval($detail[2]);
								}else{
									$k = $detail[1];
									$v = $detail[2];
									$_GET[$k] = $v;
								}
							}else{

								$_GET['m']=$detail[0];
								$_GET['a']=$detail[1];
								$start = 2;
								if(is_numeric($detail[2])){
									$_GET['id']=intval($detail[2]);
									$start = 3;
								}
								for($i=$start;$i<count($detail) ;$i++ ){

									$k = $detail[$i];
									$v=  $detail[++$i];
									if(is_numeric($k) && !$v){
										$_GET['id'] = intval($k);
									}else{
										$_GET[$k] = $v;
									}
								}
							}


							unset($_GET['file_type'],$_GET['rewrite']);
							$request = $_SERVER['REQUEST_URI'];

							$index = strpos($request,'?');
							if($index !== false){
								$par = substr($request,$index+1);
								$par = str_replace(array('amp;', '\'', '"', '<', '>', '*', ')', '('), '', $par);
								$par = explode('&',$par);
								foreach($par as $k=>$v){
									if($v){
										list($k,$v) = explode('=',$v);
										$_GET[$k]  =urldecode($v);
									}

								}
							}

					}else{


						if(!isset($_GET['m'])){
							if(isset($_GET['a'])){
								$_GET['m'] = 'index';
							}elseif(isset($_GET['aid']) || isset($_GET['itemid'])){
								$_GET['m']= 'goods';
							}else if(isset($_GET['fid'])){
								$_GET['m']= 'channel';
							}else if(defined('IN_ADMIN')){
								$_GET['m']= 'admin';
							}else{
								$_GET['m'] = 'index';
							}
						}

					}


					if(isset($_GET['rewrite']))unset($_GET['rewrite']);

	}


	static  function _init_db(){
					global $_G;
					include_once libfile('class/database');
					require_once libfile('class/cate');


					$_config = $_G['_config'];
					if(TAE) {
						include ROOT_PATH .'inc/config/tae.config.php';
						$_G['_config']['cache_config'] = $_config['cache_config'];
					}


					include_once libfile ( 'class/db');
					$db_server = function_exists('mysql_connect') ? 'mysql' : 'db_mysqli';
					include_once libfile ('class/'.$db_server);
					$db = new $db_server($_config);
					$db->connect();

					DB::init($db,$_config['db']['tablepre']);
	}
	static  function _init_cache(){
					global $_G;

					include_once libfile('class/parse');
					include_once libfile('class/cache');

					$cache_list = $_G['_config']['cache_list'];

					loadcache($cache_list,'load');
					if(!$_G['setting']['template']) {
						 loadcache ($cache_list,'update',1);
					}

					if($_G['setting']['siteurl2'])$_G['siteurl2'] = $_G['setting']['siteurl2'];
					include_once libfile('config/ext');
					foreach($ext as $k=>$v){
						$_G['setting'][$k]=$v;
					}
					unset($ext);
					if(!getcookie('pid')){
						dsetcookie('pid',$_G['setting']['pid'],3600*24*30);
					}

					top('check','check_all');
					

	}
	static  function _init_mobile(){
					global $_G;
					if($_G['setting']['qq_zone_url']){
						$host = str_replace(array('http://','/'),'',$_G[setting][qq_zone_url]);
						if($host == $_G['host']) $_G['qq_zone'] = 1;
					}
					$mobile = checkmobile();


					//手台设定的,手机版强制跳转到某个网站
					if($_G['mobile'] && $_G['setting']['mobile_jump']){
						$url1 = parse_url($_G['siteurl']);
						$url2 = parse_url($_G['setting']['mobile_jump']);
						if($url1 !== false && $url2 !== false &&  $url1['host'] != $url2['host']){
							_header("Location:".$_G['setting']['mobile_jump']);
						}
					}

					if($_G['setting']['mobile_status'] == 0){
						$_G['mobile'] = false;
						define('MOBILE',false);
						return false;
					}


					if(isset($_GET['mobile']) ){
						if($_GET['mobile'] == 'no'){	//强制pc版
							$mobile = false;
							dsetcookie('nomobile',1,86400*3);
						}else if($_GET['mobile'] == 'yes'){ //强制是手机版
							dsetcookie('nomobile',2,86400*3);
							$mobile = true;
						}
					}

					$is_mobile = getcookie('nomobile');

					if($is_mobile == 1 ){
						$mobile = false;
					}else if($is_mobile ==2){
						$mobile = true;
					}


					$_G['mobile']=$mobile;
					define('MOBILE',$mobile);
					define('PAD',$_G['pad']);

	}
	static  function _init_user(){
					global $_G;

					login();


					if(isset($_GET['u']) && $_GET['u']) {
						$u = intval($_GET['u']);
						$t = getcookie('t');
						if(!$t){
							if($u>0) dsetcookie('t',$u,3600*24*30);
							if(array_key_exists('yaoqing',$_G['table'])){
									$len =getcount('yaoqing',"t_uid= $u AND uid = 0 AND ip = '".$_G['clientip']."'");
									if($len ==0){
										$arr = array();
										$arr['t_uid'] =  $u;
										//$arr['platform'] =  MOBILE === true  ? 1 :0;
										
										//$platform = array(0=>'',1=>'pc',2=>'android',3=>'ios',4=>'weixin',5=>'wap iphone',6=>'wap android',7=>'wap');

										$platform = 1;	// pc
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

										$arr['platform'] =$platform;
										$arr['ip'] =  $_G['clientip'];
										$arr['dateline'] =  TIMESTAMP;
										DB::insert('yaoqing',$arr);
									}
							}
						}

					}

	}
	static  function _init_tpl(){
						global $_G;


						if(defined('IN_ADMIN')){
							$tpldir ="admin";
						}else if($_G['mobile'] && $_G['setting']['mobile_status']){
							$tpldir =$_G['setting']['mobile_tpl']? trim($_G['setting']['mobile_tpl']):'mobile';
						}else{
									//定义系统当前模板
									$tpldir = trim($_G['setting']['template']);
									$set_tpl = C('template');
									if($set_tpl && is_dir(ROOT_PATH.'view/'.$set_tpl)){
										$tpldir =trim_html($set_tpl,1);
									}elseif($_GET['tpl']){
											$tpl = trim_html($_GET['tpl'],1);
											if(is_dir(ROOT_PATH.'view/'.$tpl)){
												$tpldir = $tpl;
												C('template',$tpl);
											}
									}

						}

						define('TPLNAME',$tpldir);
						define('TPLDIR',ROOT_PATH.'view/'.TPLNAME);
						define('JSDIR','assets/'.TPLNAME.'/js');
						define('CSSDIR','assets/'.TPLNAME.'/css');
						define('IMGDIR','assets/'.TPLNAME.'/images');
			}
	static  function run(){
					global $_G;

					$m = 'index';
					$a = 'main';
					if(CURSCRIPT=='main'){
						$m = 'index';
					}elseif(isset($_GET['m'])){
						$m = (trim($_GET['m']));
					}elseif(isset($_GET['fid']) && $_GET['fid']>0){
						$m = 'channel';
					}elseif((isset($_GET['aid']) && $_GET['aid']>0) || isset($_GET['itemid']) && $_GET['itemid']>0 ){
						$m = 'goods';
					}else{
						$m = defined('IN_ADMIN') ? 'admin': 'index';
					}

					$a =  isset($_GET['a']) ?  $_GET['a'] :'main';

					if(!preg_match("/^[a-z_]+$/is",$m)){
						system_error('system','Module String Error');
						return false;
					}


					if(!preg_match("/^[a-z_]+$/is",$a)){
						system_error('system','Action String Error');
					}
					if(defined('IN_ADMIN') && !$_G['uid']){
						login();
					}
					$jump_url = '';



					if(defined('IN_ADMIN')){
							include libfile('config/admin');
							$group = $_G['group'][$_G['member']['groupid']];

							foreach($menu as $k=>$v){
								$menu[$k]['select'] = 0;
								if(array_key_exists($k,$group[power]) || $_G['adminid'] ==1  )  $menu[$k]['select'] = 1;
									foreach($v['nav'] as $k1=>$v1){
										if(array_key_exists($v1['a'],$group[power][$k])  || $_G['member']['groupid'] ==1 ){
											$menu[$k]['nav'][$k1]['select'] = 1;
											$menu[$k]['select'] = 1;
											if(!$jump_url) $jump_url = 'm='.$k.'&a='.$v1['a'];
										}else{
											$menu[$k]['nav'][$k1]['select'] = 0;
										}
									}
							}

							$_G['menu'] = $menu;
							seo('优淘淘客系统后台管理          power by uz-system.com');
							include_once (ROOT_PATH."inc/admin_action/".$m.".action.php");

					}else{

							include_once libfile("action/".$m);
					}

					if($m == 'list') {
						$mm = '_'.$m;
						if(!class_exists($mm)) system_error('system','Module not exists');
						$class = new $mm();
					}else{
						if(!class_exists($m)) system_error('system','Module not exists');
						$class = new $m();
					}

					define('CURMODULE',$m);


					if(defined('IN_ADMIN') && $_G[uid]  &&  $_G[member][groupid] != 1){

						$group = $_G['group'][$_G['member']['groupid']];
						$gid = $_G['member']['groupid'];
						$power = $_G['group'][$gid]['power'];
						$power['login']['logout'] =1 ;
						//验证登录进后入台权限
						if( $_G[group][$gid]['login_admin'] != 1 ) {
							logout();
							_header("Location:".CURSCRIPT.".php");
							//system_error('system','您当前用户组无权进入后台');
						}

						//验证后台模块权限
						if(!$power[$m]) {
								if($m == 'admin' && $a=='main' && $_G['member']['groupid'] !=1 && $jump_url){
									 header("Location:".URL.$jump_url);
									 echo '<script type="text/javascript">window.location.href = "'.URL.$jump_url.'";</script>';
									 exit;
								}else{
									 cpmsg('当前模块您无法进行操作','errr',$jump_url);
								}
						}
						if($a == 'del' && $power[$m]['post'] ==1 ){

						}else if($m=='apply' && $a=='post' && $power['goods'] && $power['goods']['post']==1){

						}else{
							if($power[$m][$a] !=1 )  cpmsg('当前模块分类您无法进行操作','errr',$jump_url);
						}
					}

					if($a == 'list') $a='_list';

					if(method_exists($class,$a)){
						if($a=='_list'){
							define('CURACTION',"list");
						}else{
							define('CURACTION',$a);
						}
						$class->$a();
						unset($class,$a,$power,$m);

					}elseif($a == 'pages' && $_GET[show]){
						$tpl = trim($_GET[show]);
						if(!preg_match("/^[a-z_]+$/is",$tpl)) system_error('system','Action String Error');
						define('CURACTION',$tpl);
						$app = new app();
						$app->show(CURMODULE.'/'.$tpl);
					}else{
						if(!$_G[uid] && defined('IN_ADMIN')){
							header("Location:index.php");
							echo '<script type="text/javascript">window.location = "index.php";</script>';
							exit;
						}

						system_error('system','Action not exists');
					}


	}

}

?>
