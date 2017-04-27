<?php
if(!defined('IN_TTAE')) exit('Access Denied');
abstract class  cache_base{
    public $name="";
    public $obj;
    public $enable = false;
	public $pre = '';
	public function __construct(){
		//将当前域名设为pre
        $host =   str_replace(array('www.','.com','.cn','.net'),'',$_SERVER['HTTP_HOST']);
        $pre = str_replace('.','_',$host).'_';
		$this->pre = $pre;


	}
    public abstract  function init ($config);
	public abstract  function set($key,$value,$time);
	public abstract function get($key);
    public abstract function delete($key);
 	public abstract function clear();

    public function check(){
        return $this->enable;
    }

	public function dump($rs){
		echo "<pre>";
		var_dump($rs);
		echo "</pre>";
	}
}

?>
