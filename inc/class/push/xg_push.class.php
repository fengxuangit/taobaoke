<?php

include_once ROOT_PATH.'inc/class/push/BasePush.php';
include_once ROOT_PATH.'web/lib/xg/XingeApp.php';

class xg_push extends BasePush{	
	
	private $client = null;
	private $extar =  null;
	public $data = array(
		'title'=>'',
		'content'=>'',
		'type'=>'',
		'platform'=>'',
		'title'=>'',
		'android'=>0,
		'ios'=>0
	);
	
	public function __construct($appid,$appkey,$appid_ios,$appkey_ios){
		if($appid && $appkey){
			$this->app_id = $appid;
			$this->app_key = $appkey;
		}
		if($appid_ios && $appkey_ios){
			$this->appid_ios = $appid_ios;
			$this->appkey_ios = $appkey_ios;
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
	public  function set_extar($val){
		$this->extar = $val;
	}
	public  function set_android($val){
		$this->set('android',$val);
		
	}
	public  function set_ios($val){
		$this->set('ios',$val);
	}

	public  function set_header($val){		
	}
	
	public  function set_data($val){
		$this->data = $val;
	}
	
	public  function send(){
	
			
	
			//ios 和安卓要分开推送 ios需要专门的推送appkey

			if($this->data['ios'] == 1){
				$push = new XingeApp($this->appid_ios,$this->appkey_ios);
				$mess2 = new MessageIOS();
				$mess2->setAlert($this->data['title']);
				$mess2->setCustom($this->extar);
				//IOSENV_PROD	生产环境
				//IOSENV_DEV	开发环境
				$ret = $push->PushAllDevices(0, $mess2,XingeApp::IOSENV_DEV);

			}else{
				$push = new XingeApp($this->app_id,$this->app_key);
				$mess = new Message();
				if($this->data['type'] ==1){
					//消息
					$mess->setContent(json_encode($this->extar));
					$mess->setType(Message::TYPE_MESSAGE);
					$mess->setTitle($this->data['title']);
				}else{
					//通知
					$mess->setExpireTime(86400);
					$mess->setType(Message::TYPE_NOTIFICATION);
					$mess->setTitle($this->data['title']);
					$mess->setContent($this->data['content']);
					$mess->setCustom($this->extar);
					
					#含义：样式编号0，响铃，震动，不可从通知栏清除，不影响先前通知
					$style = new Style(0,1,1,0,1);
					$mess->setStyle($style);
					
				}			
				$ret = $push->PushAllDevices(0, $mess);
			}

			
			
			if($ret['ret_code'] == 0 ){
				return '发送成功';
			}else{
				return($ret['ret_code'].','.$ret['err_msg']);
			}
	}
}



?>
