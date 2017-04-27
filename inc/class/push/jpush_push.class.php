<?php

include_once ROOT_PATH.'inc/class/push/BasePush.php';
include_once ROOT_PATH.'web/lib/jpush/JPush.php';
class jpush_push extends BasePush{

	private $client = null;
	private $extar =  null;
	public $data = array(
		'title'=>'',
		'content'=>'',
		'type'=>'',
		'userIds'=>'',
		'platform'=>'',
		'version'=>'',
		'title'=>''
	);

	public function __construct($appid,$appkey){
		if($appid && $appkey){
			$this->app_id = $appid;
			$this->app_key = $appkey;
		}
		$this->data['platform'] = array();
		//$obj = new JPush($this->app_id,$this->app_key);
		//$this->client  = $obj->push();

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
		// if($this->data['platform'] ==1 || $this->data['platform'] ==0){
		// 	$this->data['platform'] = 0;
		// }else{
		// 	$this->set('platform',2);
		// }
		if($val)$this->data['platform'][] = 'android';
	}
	public  function set_ios($val){
		// if($this->data['platform'] ==2 || $this->data['platform'] ==0){
		// 	$this->data['platform'] = 0;
		// }else{
		// 	$this->set('platform',1);
		// }
		if($val)$this->data['platform'][] = 'ios';
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

	public   function send(){



		try{

					$client = new JPush($this->app_id,$this->app_key);
					$result = $client->push();
					$result->addAllAudience();
					if($this->data['version'])$result->addTag(array('version', $this->data['version']));
					$result->setNotificationAlert($this->data['title']);
					$result->setPlatform($this->data['platform']);

					//$result->addAlias('alias1');
					if($this->data['type'] == 0){
							//通知
							if(in_array('android', $this->data['platform'])){
								$result->addAndroidNotification($this->data['content'], $this->data['title'],  null, $this->extar);
							}

							if(in_array('ios', $this->data['platform'])){
								$result->addIosNotification($this->data['content'], null, null,  null,  null, $this->extar);
							}

					}else if($this->data['type'] == 1){
						//消息
						$result->setMessage($this->data['content'], $this->data['title'], null,$this->extar);
					}

					$result->setOptions(100000, 3600, null, true);



					$rs = $result->send();
					$msg = ',未知错误';
					if(is_object($rs)){
						$code = $rs->data->sendno;
						if($code == 100000){
							return '推送成功,消息id:'.$rs->data->msg_id;
						}
						$msg = ",错误码:".$code;
					}
					return '推送失败'.$msg;

		}catch(Exception $e){
				return ($e->getMessage());
		}
	}


}



?>
