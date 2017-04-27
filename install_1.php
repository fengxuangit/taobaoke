<?php
define('IN_TTAE',true);
define('DEBUG',false);
define('CHARSET','utf-8');
session_start();
define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
$basename = explode('.', basename($_SERVER['SCRIPT_FILENAME']));
define('CURSCRIPT', reset($basename));
if(function_exists('error_reporting')) error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);//E_ALL
include ROOT_PATH.'web/smarty/Smarty.class.php';	
include ROOT_PATH.'inc/function/core.function.php';	
include ROOT_PATH.'inc/function/web.function.php';	
include ROOT_PATH.'inc/function/extends.function.php';	
include ROOT_PATH.'install/mysql.class.php';
include ROOT_PATH.'inc/class/db.class.php';

$a = 'main';
if($_GET['a']) $a = $_GET['a'];
$install = new install();
if(method_exists($install,$a)){
	$install->$a();
}else{
	json('未知的操作方法'.$a);
}



class install{
	private $_config = array('db'=>array());
	private $is_init = false;
	public $debug = false;			//debug的话,则安装后不删除当前文件
	private $system=2;		//api=1 导购=2
	function __construct(){
				$tae = false;
				if(class_exists('Alibaba')) $tae = true;
				define('TAE',$tae);
				$file = ROOT_PATH.'install/init_config.txt';
				
				
				if(!isset($_GET['a'])) {
					$_SESSION['_config'] = null;
					if(is_file($file))@unlink($file);
					//$file2 = ROOT_PATH.'install/install_ok.txt';
					//@unlink($file2);
				}
				
				
				include  ROOT_PATH.'inc/config/db.config.php';
				$this->_config['db'] = $_config['db'];

				
				if($_SESSION['_config']){
					$this->_config = $_SESSION['_config'];
					$this->init_db();
				}else if(TAE){					
					include ROOT_PATH.'inc/config/tae.config.php';
					$this->_config['db'] = $_config['db'];
					$this->init_db();					
				}else{
					$this->_config['db']['dbhost'] = 'localhost';
					$this->_config['db']['dbport'] = 3306;
					$this->_config['db']['dbuser'] ='';
					$this->_config['db']['dbpw'] = '';					
					$this->_config['db']['dbname'] = '';
					$this->_config['db']['dbcharset'] = 'utf8';
					$this->_config['db']['tablepre'] = 'ttae_';
					$this->_config['db']['pconnect'] = 0;
				}
		
	}
	
private function init_db(){

		if($this->is_init) return  ;
		$db = new mysql($this->_config);
		$db->connect();
		DB::init($db,$this->_config['db']['tablepre']);
		$this->is_init = true;
}	
	function main(){
		global $_G;
		
		//已经安装成功
		$file = ROOT_PATH.'install/install_ok.txt';
		if(is_file($file)) {			
			echo ('系统已安装完成') ;	
			exit;
		}
		//$_SESSION['_config'] = null;
		
		include  ROOT_PATH.'inc/config/db.config.php';
		$smarty =	new Smarty();	
		$siteurl =  get_siteurl();
		$smarty->assign('TAE',TAE ? 1:0);
		$smarty->assign('version',TTAE_VERSION);
		$smarty->assign('updatetime',TTAE_UPDATE_TIME);
		$smarty->assign('system',$this->system);
		$smarty->assign('siteurl',$siteurl);
		$smarty->display('install/main.php');	

	}
	function check(){
		$this->run('check');
	}
	
	function init(){
		$this->run('init');
	}
	
	function del_tab(){
		$this->run('del');
	}

private		function run($type){

		if(!TAE &&  $type == 'check') {
			$address = trim($_POST['address']);
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$name = trim($_POST['name']);
			$port = intval($_POST['port']);
			$pre = trim($_POST['pre']);
			if(!$address) json('数据库地址不能为空');
			if(!$username) json('数据库用户名不能为空');
			if(!$password) json('数据库密码不能为空');
			if(!$name) json('数据库名称不能为空');
			if(!$pre) $pre = 'ttae_';
			if(!$port) $port = 3306;
		
			$this->_config['db']['dbhost'] = $address;
			$this->_config['db']['dbport'] = $port;
			$this->_config['db']['dbuser'] =$username;
			$this->_config['db']['dbpw'] = $password;
			$this->_config['db']['dbname'] = $name;	
			$this->_config['db']['tablepre'] = $pre;	
			
			$this->init_db();
			if($this->is_init)$_SESSION['_config'] = $this->_config;
		}
		if($_POST['debug'] ==1 ){
			$exists =true;
		}else{
			$exists = $this->table_exists($this->_config['db']['dbname']);
		}
		if($exists &&  $type == 'del'){
			$table = DB::fetch_all("SHOW TABLES");		
			$count = 0;
		
			foreach($table as $k=>$v){
				$name =$v['Tables_in_'.$this->_config['db']['dbname']];
				if(strpos($name,$this->_config['db']['tablepre']) !== false){
					$count++;
					DB::query("DROP TABLE ".$name);
				}
			}
			json(array('status'=>'success','msg'=>'旧数据表删除成功'.$count.'条,您现在可以进行全新数据库安装'));

		}
		
		if($exists ){
			//安装
			if($type == 'init'){
				$this->insert_table();
				return ;
			}
			if($type == 'check')$this->save_config(true);		
			$table = DB::fetch_all("SHOW TABLES");				
			if(count($table) == 0){
				json(array('status'=>'success','msg'=>'数据库连接成功,可直接点下一步进行安装'));
			}
			$count = 0;
			foreach($table as $k=>$v){
				$name =$v['Tables_in_'.$this->_config['db']['dbname']];
				if(strpos($name,$this->_config['db']['tablepre']) !== false){
					$count ++;
				}
			}
			
			if($count == 0){				
				json(array('status'=>'success','msg'=>'数据库连接成功,您现在可以正常安装优淘TAE系统'));
			}else{
				json('当前数据库中已存在相同的系统表共'.$count.'张');
			}

		}else{
			if(is_numeric($this->_config['db']['dbname'])){
				json('数据库不在存,创建数据库的名称不能为纯数字');
			}
			
			$create_sql = "CREATE DATABASE IF NOT EXISTS ".$this->_config['db']['dbname']." DEFAULT CHARSET utf8 COLLATE utf8_general_ci;";
			DB::query($create_sql);
			if($type == 'check')	$this->save_config(true);
			
			//安装
			if($type == 'init'){
				$this->insert_table();
				return ;
			}
			
			json(array('msg'=>'数据库创建成功,您现在可以正常安装优淘TAE系统','status'=>'success'));
		}

	}
	
	function inset_data(){
		
				$username = trim($_POST['user_name']);
				$password = trim($_POST['user_password']);
				$inset_test_data = intval($_POST['inset_test_data']);
				
				if(!$username)json('后台管理员用户名不能为空');
				if(!$password)json('管理员密码不能为空');
				$this->init_db();	
				if(!$this->is_init){
					if(!$this->_config['db']['dbname']){
						json('数据库配置不存在');
					}
				}
				$file = 'install/sql/data.sql';
				include  ROOT_PATH.'inc/class/sql.class.php';	
				if(!is_file(ROOT_PATH.$file)) json('数据表文件'.$file.'不存在');				
				$sql = new sql();				
				$len = $sql->insert_file(ROOT_PATH.$file,'ttae_',$this->_config['db']['tablepre']);				
				if($len == 0)json('安装数据库'.$file.'失败,执行成功0条');
				//json(array('msg'=>"初始化成功,成功创建{$len}个表",'status'=>'success'));
				
				//不安装测试数据,请把几个常用的数据表清空
				if($inset_test_data ==0){
					$clear_table = array('sign','shop','duihuan','duihuan_apply','goods','img','like','like_type','message','member','cache','fetch');
					foreach($clear_table as $k=>$v){
						DB::query("TRUNCATE ttae_".$v);
					}
				}
				
				//创建管理员
				
				$ip = get_client_ip();
				//添加用户
				$arr = array();
				$arr['username'] = $username;
				$arr['password'] = $password;
				$arr['uid'] = 1;
				$arr['key'] = random(10);
				
				$arr['password'] = md5(md5($password).$arr['key']);
				$arr['groupid'] = 1;
				$arr['regip'] =$ip;
				$arr['login_ip'] = $ip;
				$arr['login_time'] = TIMESTAMP;
				$arr['login_count'] = 1;
				$arr['regdate'] = TIMESTAMP;
				$arr['check'] = 1;
				$arr['jf'] =0;
				
				$uid  = 	DB::insert('member',$arr,true,true);
				$msg = ',请登录后台更新缓存';
				if($inset_test_data ==1)$msg = ',测试数据安装成功';
				
				if($uid){		
				$this->over();
					$msg.="请登录后台更新缓存";
					remove_dir('web/templates_c/',false);
					remove_dir('web/log/',false);
					remove_dir('web/cache/',false);
					json(array('msg'=>'创建管理员成功'.$msg,'status'=>'success'));
				}else{
					json('创建管理员失败,请修改名称或密码重试一次');
				}
		
				
	}
	
private 	function over(){
				if($this->debug)return;
				
				file_put_contents(ROOT_PATH.'install/install_ok.txt','install ok');						
				@unlink(ROOT_PATH.CURSCRIPT.'.php');
				remove_dir('install',true);
			}
			
	
private 	function save_config($focus = false){
				if(TAE)	return true;
				$file = ROOT_PATH.'install/init_config.txt';
				if(is_file($file) && !$focus) return false;
				$db_file = ROOT_PATH.'inc/config/db.config.php';
				
				$authkey = random(10);
				$rs = arrayeval($this->_config['db']);
				
				$text ="\r\n";		
				$text .= "\$_config['authkey'] = '$authkey';\r\n";
				$text .= "\$_config['db']=".$rs.";\r\n";
				$text .="\r\n?>";
				
				//检查原db.config.php文件是否存在数据库信息
				$db_content = file_get_contents($db_file);
				
				//如存在,则将原db.config.php中的内容正则提取出来,并替换成新的追加到db.config.php
				if(strpos($db_content,'authkey') !== false){
					$new_content = preg_replace("/\\\$_config\['authkey'\](.*)$/is",$text,$db_content);
				}else{
					$new_content = preg_replace("/\?>/is",$text,$db_content);
				}
				
				if(!$new_content)json('写入配置文件失败,请检查inc/config/目录是否有写入权限');
				$len = file_put_contents($db_file,$new_content);
				if($len <=0){
					json('写入数据库配置文件失败,请检查inc/config/目录是否有写入权限');
				}
				
				file_put_contents($file,'init ok');
				return true;
	}

	
	private function insert_table(){
		
			include  ROOT_PATH.'inc/class/sql.class.php';	
			$file = ROOT_PATH.'install/sql/table.sql';
			if(!is_file($file)) json('数据表文件install/sql/table.sql不存在');
			
			$sql = new sql();
			$len = $sql->insert_file($file,'ttae_',$this->_config['db']['tablepre']);
			if($len == 0)json('初始化数据表失败,执行成功0条');
			json(array('msg'=>"初始化成功,成功创建{$len}个表",'status'=>'success'));
	}
	
	private function table_exists($name){
		$exists = false;
		$tb = DB::fetch_all("show databases");
		
		foreach($tb as $k=>$v1){
			if($v1['Database'] == $name){
				$exists = true;
				break;
			}
		}
		return $exists;
	}
	
	
	
	
}

?>