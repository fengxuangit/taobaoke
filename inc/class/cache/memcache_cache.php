<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";

class  memcache_cache extends cache_base {
    public function __construct() {
		//	开启	memcached -d -m 64 -u root -l 127.0.0.100 -p 11211 -c 128
        $this->name = "memcache";
		parent::__construct();
    }

    /*
        * 初始化配置
        $config = array(
           'host'     => '',
           'port'     => '',
       );
       */
    public function init($config) {
		global $_G;
       
		if(!class_exists('Memcache')) return false;
		
        if (!$config) {
            $config["host"] = "127.0.0.1";
            $config["port"] = 11211;
        }
        $this->config = $config;
        $this->obj = new Memcache();
        $enable = $this->obj->pconnect($config['host'], $config['port']);
        $this->enable = $enable;
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
					$rt =$this->obj->set($this->pre.$k, $v,MEMCACHE_COMPRESSED,$time);	
				}else{
					$rt =$this->obj->set($this->pre.$k, ($value[$v] ? $value[$v] : $value[$k]),MEMCACHE_COMPRESSED,$time);
				}
		  }
		  return $rt;
		}
		
       return $this->obj->set($this->pre.$key, $value,MEMCACHE_COMPRESSED,$time);
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