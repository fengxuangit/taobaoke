<?php

include_once ROOT_PATH.'inc/class/push/BasePush.php';

class apiColud_push extends BasePush{
	//public $app_id='A6909202264743';
	//public $app_key='5DEC3254-A2B4-BA8C-7A23-4F15374BB9A2';
	public $url = 'https://p.apicloud.com/api/push/message';
	public $data = array(
		'title'=>'',
		'content'=>'',
		'type'=>'',
		'userIds'=>'',
		'platform'=>'',
		'groupName'=>'all',
		'title'=>''
	);
	
	public function __construct($appid,$appkey){
		if($appid && $appkey){
			$this->app_id = $appid;
			$this->app_key = $appkey;
		}
	}
	
	public function set($key,$val){
		$this->data[$key] = $val;
	}

	public  function set_type($val){
		$this->set('type',$val);
	}

	public  function set_content($val){
		$this->set('content',$val);
	}
	public  function set_title($val){
		$this->set('title',$val);
	}
	public  function set_android($val){
		if($this->data['platform'] ==1 || $this->data['platform'] ==0){
			$this->data['platform'] = 0;
		}else{
			$this->set('platform',2);
		}
	}
	public  function set_ios($val){
		if($this->data['platform'] ==2 || $this->data['platform'] ==0){
			$this->data['platform'] = 0;
		}else{
			$this->set('platform',1);
		}
	}

	public  function set_header($val){
		$this->header = array(
			  'X-APICloud-AppId'=>$this->app_id,
              'X-APICloud-AppKey'=>$this->get_key(),
		 );
	}
	
	public  function set_data($val){
		$this->data = $val;
	}
	public  function set_extar($val){
		if(is_array($val))$this->data['content'] =json_encode($val);
	}
	public   function send(){
		$rs = $this->exec();

		if($this->msg) return $this->msg;
		$data = json_decode($rs,1);
		if(is_array($data)){
			$this->msg = $data &&  $data['status'] == 1 ? "推送成功" :"推送失败: ".$data['msg'];	
		}
		return $this->msg;
	}

private    function get_key(){
		 list($s1, $s2) = explode(' ', microtime()); 
         $time = (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); 
		//$time = time() * 1000;
        return sha1($this->app_id.'UZ'.$this->app_key.'UZ'.$time).'.'.$time;
     }


}


?>
