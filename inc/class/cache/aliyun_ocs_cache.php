<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";

class  aliyun_ocs_cache extends cache_base {
    public function __construct() {
        $this->name = "ocs";
		parent::__construct();
    }

    /*
     * 初始化配置
     $config = array(
        'host'     => '',
        'port'     => '',
        'username' => '',
        'password' => '',
    );
    */
    public function init($config) {
			global $_G;		
        if (!$config) {
			if(TAE){
				$config["host"] = "127.0.0.1";
				$config["port"] = 11211;
			}else{
				$config = $_G['_config']['cache_config'];
			}
        }
        $this->config = $config;
	  
	    $connect = new Memcached;  //声明一个新的memcached链接
        $connect->setOption(Memcached::OPT_COMPRESSION, false); //关闭压缩功能
        $connect->setOption(Memcached::OPT_BINARY_PROTOCOL, true); //使用binary二进制协议
        $connect->addServer($config['host'], $config['port']); //添加OCS实例地址及端口号
		
        if ($config['username'] && $config['password']) {
            //设置OCS帐号密码进行鉴权，如已开启免密码功能，则无需此步骤
            $connect->setSaslAuthData($config['username'], $config['password']);
        }
        $this->enable = true;
        $this->obj = $connect;

        return $this->enable;
    }

    public function set($key, $value, $time) {
        if (!$this->enable) {
            return false;
        }
		
		if(is_array($key)){
			$lostcaches = array();
			$rt = false;
			foreach($key as $k=>$v) {
				if($v){
					$rt =	$this->obj->set($this->pre.$k, $v,$time);	
				}else{
					$rt =	$this->obj->set($this->pre.$k, ($value[$v] ? $value[$v] : $value[$k]),$time);
				}
		  }
		  return $rt;
		}
        return $this->obj->set($this->pre.$key, $value,$time);
    }

    public function get($key) {
        if (!$this->enable) {
            return false;
        }
		if(is_array($key)){
			$lostcaches = array();
			foreach($key as $cachename) {		
			  $cache  = $this->obj->get($this->pre.$cachename);
			  if($cache){									
				  $lostcaches[$cachename] = $cache;
			  }else{
				  $lostcaches[$cachename] = false;
			  }
		  }
		  return $lostcaches;
		}
        return $this->obj->get($this->pre.$key);
    }

    public function delete($key) {
        if (!$this->enable) {
            return false;
        }
        return $this->obj->delete($this->pre.$key);
    }
	  public function clear() {
        return $this->obj->flush();
    }
}

?>