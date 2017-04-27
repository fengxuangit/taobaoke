<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";

class  baichuan_user_cache extends cache_base {
    public function __construct() {
        $this->name = "baichuan_user";
		parent::__construct();
    }

    /*
     * 初始化配置,必须填写配置信息 字段全部要设置
	 *	https://ocs.console.aliyun.com/console/
     $config = array(
        'host'     => '',
        'port'     => '',
        'username' => '',
        'password' => '',
		'endpoint'=>'' //青岛才要,其它不填
    );
    */
    public function init($config) {
        if (!$config) {
            return false;
        }
        $this->config = $config;
        $connect = Alibaba::cache($config);	 
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