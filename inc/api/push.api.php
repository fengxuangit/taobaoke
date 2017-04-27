<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 


//短信发送类
class api_push {
	
		//taobao.open.sms.sendvercode 发送短信验证码
		//http://open.taobao.com/apidoc/api.htm?path=scopeId:11826-apiId:25596
		//发送验证码,百川需要验证
	public	function send($phone){
			global $_G;
			
			include_once	(ROOT_PATH.'top/baichuan/OpenSmsSendvercodeRequest.php');
			include_once	(ROOT_PATH.'top/baichuan/SendVerCodeRequest.php');
			

			
			$req = new OpenSmsSendvercodeRequest;	
			
			$SendVerCodeRequest = json_encode($arr);
			$req->setSendVerCodeRequest($SendVerCodeRequest);
			
			$resp = $_G['TOP']->execute($req);
			
			top_check_error($resp,false);
			$rs = $resp->result;
			
			if(!$rs->successful){
				if($this->debug) L('发送验证码错误:'.$rs->message.',手机号'.$phone.',domain:'.$arr['domain']);
				return $rs->message;
			}else{
				return true;
			}
		}	
	
	
}

?>