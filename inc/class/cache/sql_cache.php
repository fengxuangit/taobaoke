<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH . "inc/class/cache/cache_base.php";

class  sql_cache extends cache_base {
    public function __construct() {
        $this->name = "sql";
    }
    public function init($config) {
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
					$rt =	$this->set($k, $v,$time);					
				}else{
					$rt =	$this->set($k, ($value[$v] ? $value[$v] : $value[$k]),$time);
				}
		  }
		  return $rt;
		}
		if($time>0)$time=TIMESTAMP+$time;
		$arr = array( 'cname'=>$key, 'dateline' => $time, 'data' => serialize($value));
		return DB::insert('cache',$arr,true,true);
		
    }

    public function get($key) {
        if (!$this->enable) {
            return false;
        }
		$fd = 'dateline,cname,data';
		if(is_array($key)){
			$lostcaches = array();
			$arr = DB::fetch_all("SELECT $fd FROM ".DB::table('cache')." WHERE ".DB::field('cname', $key),"cname");
			
			foreach($arr as $k=>$v){
					if($v['dateline']>0  && TIMESTAMP > $v['dateline']){
						$lostcaches[$v['cname']] = false;
					}else{	
						$lostcaches[$v['cname']] = $v['data'] ? unserialize($v['data']) : NULL;					
					}					
			}
		 	return $lostcaches;
		}
		$rs = DB::fetch_first("SELECT $fd FROM ".DB::table('cache')." WHERE cname= '$key'");
		$data =  $rs['data'] ? dunserialize($rs['data']) : NULL;
        return $data;
    }

    public function delete($key) {
        if (!$this->enable) {
            return false;
        }
        return $this->set($key,'');
    }
	  public function clear() {
		     DB::update('cachen',array('dateline'=>0,'data'=>''));
			 return true;
    }
}

?>