<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";
//include_once ROOT_PATH . "inc/class/file_class.class.php";
class  file_cache extends cache_base {
    public function __construct() {
        $this->name = "file";
		
    }

    /*
        * 初始化配置 dir可空
        $config = array(
           'dir'     => '',
       );
     */
    public function init($config) {
        if (!$config) {
            $config["dir"] = ROOT_PATH.'web/cache/';
         }
		
		if(!is_dir($config["dir"] )) {
			$this->dmkdir($config["dir"]);
		}
	 
        $this->config = $config;
        $this->enable =is_dir($config["dir"]);
        return $this->enable;
    }

	//文件缓存,时间无效
    public function set($key, $value, $time) {
        if (!$this->enable) {
            return false;
        }
		
		if(is_array($key)){
			$lostcaches = array();
			$rt = false;
			foreach($key as $k=>$v) {
				if($v){
					$rt =	$this->set($k, $v,$time);	
				}else{
					$rt =	$this->set($k, ($value[$v] ? $value[$v] : $value[$k]),$time);
				}
		  }
		  return $rt;
		}
       
		$dir = $this->config['dir'];
		$value = $this->arrayeval($value);
		$prefix = 'cache_';		
		$save_dir = $dir.$prefix.$key.'.php'; 
		$content = "<?php\n";
		$content .="if(!defined('IN_TTAE')) exit('Access Denied');\n ";
		$content .="//UZ-SYSTEM! cache file, DO NOT modify me!\n//Identify:";
		$content .=md5($prefix.$script.'.php'.$value);
		$content .="\n\n return $value \n?>";
		$len =  file_put_contents($save_dir,$content);
		if($len>0){
			return true;
		}else{
			return false;
		}
    }

	private function dmkdir($dir){
		if(!is_dir($dir)) {
			$this->dmkdir(dirname($dir),0777, $makeindex);
			@mkdir($dir, $mode);
		}
		return true;
	}
	private function arrayeval($array, $level = 0) {
		if(!is_array($array)) {
			return "'".$array."'";
		}
		if(is_array($array) && function_exists('var_export')) {
			return var_export($array, true);
		}
	
		$space = '';
		for($i = 0; $i <= $level; $i++) {
			$space .= "\t";
		}
		$evaluate = "Array\n$space(\n";
		$comma = $space;
		if(is_array($array)) {
			foreach($array as $key => $val) {
				$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
				$val = !is_array($val) && (!preg_match("/^\-?[1-9]\d*$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
				if(is_array($val)) {
					$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
				} else {
					$evaluate .= "$comma$key => $val";
				}
				$comma = ",\n$space";
			}
		}
		$evaluate .= "\n$space)";
		return $evaluate;
	}
	 
    public function get($key) {
		
        if (!$this->enable) {
            return false;
        }
		
		if(is_array($key)){
			$lostcaches = array();
			foreach($key as $cachename) {		
			$file = $this->config['dir'].'cache_'.$cachename.'.php';	  
			  if(file_exists($file) && filesize($file)>0 ){									
				  $cache  = include $file;
				  $lostcaches[$cachename] = $cache;
			  }else{
				  $lostcaches[$cachename] = false;
			  }
		  }
		  return $lostcaches;
		}else{
			$file = $this->config['dir'].'cache_'.$key.'.php';
			if(!file_exists($file)) return false;
			return include $file;
		}
		
    }

    public function delete($key) {
        if (!$this->enable) {
            return false;
        }
		$file = $this->config['dir'].'cache_'.$key.'.php';
		if(!file_exists($file)) return false;
        return @unlink($file);
    }

    public function clear() {
       $fp = opendir($this->config['dir']);
	   $no_del = array( '.','..');
        while(!false == ($fn = readdir($fp))) {
            if(in_array($fn,$no_del)) {
                continue;
            }
            @unlink($this->config['dir'] . $fn);
        }
		return true;
    }
}

?>