<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
abstract class  upload_base{
	public $dir;
	public $dir2;
	public $host;
	public $name;
	public $time;
	public $debug = false;
	public $code;
	public $msg;
	public $file_type = '.jpg';
	public $file = array();
	public function __construct(){
		$this->time = time();
		if($_SERVER['HTTP_REFERER']){
			$url =$_SERVER['HTTP_REFERER'];
		}else{
			$url =$_SERVER['HTTP_HOST'];
		}
		$url = str_replace("http://",'',$url);
		$url = explode('/',$url);
		$referer = str_replace('.','_',$url[0]);
		$this->host = $referer;
		$this->dir = $referer.'/'.date('Y',$this->time).'/'.date('m',$this->time).'/';
		$this->dir2 = date('Y',$this->time).'/'.date('m',$this->time).'/';
		$this->name  =  (rand(100000,9999999)). $this->file_type;
		if(DEBUG === true) $this->debug = true;
		
	}
	
	public abstract  function upload($file);
	
	public abstract function check($obj);

	public function dump($rs){
		echo "<pre>";
		var_dump($rs);
		echo "</pre>";
	}
}

?>