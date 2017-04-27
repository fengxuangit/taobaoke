<?
/*--------------------------------
功能:		PHP HTTP接口 发送短信
修改日期:	2013-05-08
说明:		http://m.5c.com.cn/api/send/?username=用户名&password=密码&mobile=手机号&content=内容&apikey=apikey
状态:
	发送成功	success:msgid
	发送失败	error:msgid

注意，需curl支持。

返回值											说明
success:msgid								提交成功，发送状态请见4.1
error:msgid								提交失败
error:Missing username						用户名为空
error:Missing password						密码为空
error:Missing apikey						APIKEY为空
error:Missing recipient					手机号码为空
error:Missing message content				短信内容为空
error:Account is blocked					帐号被禁用
error:Unrecognized encoding				编码未能识别
error:APIKEY or password error				APIKEY 或密码错误
error:Unauthorized IP address				未授权 IP 地址
error:Account balance is insufficient		余额不足
error:Black keywords is:党中央				屏蔽词
--------------------------------*/


class SMS{
			function error_5c($code){
				$error = array(
					'msgid'=>'提交失败',
					'Missingusername'=>'用户名为空',
					'Missingpassword'=>'密码为空',
					'Missingapikey'=>'APIKEY为空',
					'Missingrecipient'=>'手机号码为空',
					'Missingmessagecontent'=>'短信内容为空',
					'Accountisblocked'=>'帐号被禁用',
					'Unrecognizedencoding'=>'编码未能识别',
					'APIKEYorpassworderror'=>'APIKEY或密码错误',
					'UnauthorizedIPaddress'=>'未授权IP地址',
					'Accountbalanceisinsufficient'=>'余额不足',
					'Blackkeywordsis'=>'屏蔽词'
				);
				
				$code = str_replace(' ','',$code);
				return $error[$code];
			}
		
			function send($phone,$content){
				
				$url = 'http://m.5c.com.cn/api/send/?';
				$data = array
					('username'=>'ygwy',
					'password'=>'fjj123456',
					'mobile'=>$phone,
					'content'=>$content,
					'apikey'=>'db4f9d6b9af47b6fd16bef4fbba551d9',
					);
				$result= $this->curlSMS($url,$data);			//POST方式提交
				$rt = explode(':',$result);
				
				if($rt[0] == 'success') {
					return true;
				}elseif($rt[0] == 'error'){
					return $this->error_5c($rt[1]);
				}else{
					return $result;
				}
			}
			
			function curlSMS($url,$post_fields=array()){
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_TIMEOUT, 3600); //60秒 
					curl_setopt($ch, CURLOPT_HEADER,1);
					curl_setopt($ch, CURLOPT_REFERER,'http://www.yourdomain.com');
					curl_setopt($ch,CURLOPT_POST,1);
					curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
					$data = curl_exec($ch);
					curl_close($ch);
					$res = explode("\r\n\r\n",$data);
					return $res[2]; 
			}

}

?>