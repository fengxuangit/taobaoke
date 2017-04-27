<?php

abstract class BasePush{
	protected  $data = array();
	protected $url = '';
	protected $msg = '';
	public $debug = true;
	protected $header  = array();
	protected $curl = NULL;

	public abstract  function send();
	public abstract  function set_type($val);
	public abstract  function set_extar($val);

	public abstract  function set_content($val);
	public abstract  function set_title($val);
	public abstract  function set_android($val);
	public abstract  function set_ios($val);
	public abstract  function set_header($val);
	public abstract  function set_data($val);

	
	public  function exec(){
		
		if(!$this->app_id || !$this->app_key){
			$this->msg= "推送的appkey 或 SecretKey未配置";
			return ;
		}
		
		include_once ROOT_PATH .'inc/class/curl.class.php';
		$curl = new Curl();
		if(!$this->header)$this->set_header();
		$curl->header = $this->header;
		
		$curl->debug=$this->debug;
		try{
			$rs=  $curl->post($this->url, $this->data);
		}catch(Exception $e){
			$this->msg= $e->getMessage();
		}
		return $rs;
	}
	
	
}


?>