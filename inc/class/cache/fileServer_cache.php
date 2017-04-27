<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";
include_once ROOT_PATH . "inc/class/fileServer.class.php";
class  fileServer_cache extends cache_base {
    public function __construct() {
        $this->name = "fileServer";
    }
    public function init($config) {

		if(!class_exists('fileServer')){
			 $this->enable = false;
			 return false;
		}
        $this->obj = new fileServer();
		 $this->enable = true;
        return true;
    }

	//文件缓存,时间无效
    public function set($key, $value, $time) {
        if (!$this->enable)   return false;
		
		if(is_array($key)){
			foreach($key as $k=>$v) {
				if($v){
					$this->obj->add($k, $v,$time);	
				}else{
					$this->obj->add($k, ($value[$v] ? $value[$v] : $value[$k]),$time);
				}
		 	 }
		  return true;
		} 
		
	   return $this->obj->add($key,$value,$time);
    }


    public function get($key) {		
        if (!$this->enable)   return false;
		
		
		if(is_array($key)){
				$lostcaches = array();
				foreach($key as $cachename) {		
				 $cache=	$this->obj->get($cachename); 
				 if($cache){
					  $lostcaches[$cachename] = $cache;
				 }else{
					  $lostcaches[$cachename] = false;
				}
		  }
		
		 	 return $lostcaches;
		}else{
			return $this->obj->get($key);
		}
    }

    public function delete($key) {
        if (!$this->enable)  return false;
		return $this->obj->delete($key);
    }

    public function clear() {
       if (!$this->enable)  return false;
		return $this->obj->flush();
		
    }
}

?>