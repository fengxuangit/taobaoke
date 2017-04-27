<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";

//百川上使用cache	,兼容TAE2.0
class  baichuan_cache extends cache_base {
    public function __construct() {
        $this->name = "baichuan";
		parent::__construct();
    }

    /*
     * 自购形可传入config
     * $config = array(
            'host'  => '',
            'port'  => '',
            'username' => '',
            'password' => '',
            'endpoint' => 'oss-cn-qingdao.aliyuncs.com', # 对于青岛机房的 ocs 实例时可以配置, 其它类型 ocs 可以不配置, 忽略此项
     );
     * */
    public function init($config) {
		global $_G;
		$this->obj = Alibaba::Cache($config);
        $this->enable = $this->obj ? true : false;
        $this->config = $config;
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
		return false;
    }
}

?>