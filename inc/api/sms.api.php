<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 


//短信发送类
include_once ROOT_PATH.'inc/api/apiBase.class.php';
class api_sms  extends apiBase{
	public $debug = true;
	
	public function __construct(){
		$this->use_dayu();
	}


	public function use_dayu(){
			global $_G;
			if($_G['setting']['sms_status'] != 1){
				msg('系统未开启发送短信功能');
			}
			 if($_G['setting']['sms_appkey'] && $_G['setting']['sms_secrekey']){
		          $_G['TOP']->appkey =  trim($_G['setting']['sms_appkey']);
		          $_G['TOP']->secretKey = trim($_G['setting']['sms_secrekey']);
		      }else{
		        msg('短信appkey未配置,无法进行操作');
		      }
	}

	function save_code($phone){
				$key = 'sms_'.$phone;
				$code = rand(1000, 9999);
				memory('set',$key,$code,600);	//10分钟有效
				return $code;
	}

		
		//发送验证码,百川需要验证
	public	function send($phone){
			global $_G;
			$this->use_dayu();

			$key2  = 'count_'.$phone;
			$count = intval(memory('get',$key2));
			//if($count>5) return  '短信发送过于频繁,请于15分钟后再发送';
			$count++;
			memory('set',$key2,$count,60*15);


			include_once	(ROOT_PATH.'top/dayu/AlibabaAliqinFcSmsNumSendRequest.php');	
				$req = new AlibabaAliqinFcSmsNumSendRequest;
				$req ->setExtend("");
				$req ->setSmsType( "normal" );
				$req ->setSmsFreeSignName( $_G['setting']['sms_name'] );
				
				$code= $this->save_code($phone);
				$req ->setSmsParam( "{'code':'$code'}" );
				$req ->setRecNum( $phone );
				$req ->setSmsTemplateCode($_G['setting']['sms_id']);
				$resp = $_G['TOP']->execute( $req );

				if($resp->code > 0 && $resp->sub_msg) {
					if($resp->code == 15) return '发送过于频繁,请1分钟后重试';
					if($this->debug) L('发送验证码错误:'.$resp->msg.',手机号'.$phone);
					return $resp->sub_msg;
				}else if($resp->result && $resp->result->success === true){
					return true;
				}else{
					return '未知错误';
				}
			
		}	
		

	public	function check($phone,$code,$is_del = false){
			global $_G;
			$key = 'sms_'.$phone;
			$org_code = memory('get',$key);
			$rt = '验证码校验失败';
			if($code == $org_code)  	$rt =  true;
			if($is_del) $this->del($phone);
			return $rt;
		}
		

		function del($phone){
				$key = 'sms_'.$phone;
				memory('delete',$key);
		}
		
		

	function get($rs){

	}

	function parse($rs){
		
	}
	
}

?>