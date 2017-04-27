<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

include_once ROOT_PATH.'inc/class/upload/upload_base.php';

class uz_http_upload extends upload_base{
	public $appkey;
	public $accessKey;
	public $type;
	public $namespace;
	
	public function init($appkey,$accessKey,$type,$namespace){
		$this->appkey =$appkey;
		$this->accessKey =$accessKey;
		$this->type =$type;
		$this->namespace =$namespace;		
		return $this;
	}
	
	
	function upload($file){
				global $_G;
				$url = 'http://taobaoshangcheng.uz.taobao.com/upload.php?new=1';		
				$_G[upload_index]  = intval($_G[upload_index])+1;

				$file_path ='@'.realpath($file).'';
				$data = array('token'	=>random(10),'file'=>$file_path);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true );
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_REFERER, $_G[siteurl]);
				curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:110.75.74.69','CLIENT-IP:110.75.74.69'));//IP
				$rs = curl_exec($ch);
				curl_close($ch);
				
				if(strpos($rs,'img_url') !==false){
					$rs = json_decode($rs,1);
					return $this->check($rs);
				}else if((strpos($rs,"淘宝系统缓冲")!== false && $_G[upload_index]<5)){
					return  $this->upload($file);
				}else{	
						$rs = trim_html($rs,1);
						L('上传图片到淘宝服务器失败'.$rs);		
						return false;				
				}
				return $file;
	
}
	
	
	public function check($rs){		
		$this->code = $rs['status'];
		$this->msg = $rs['msg'];
			
		if($rs['status'] =='success'){
			return $rs['img_url'];
		}		
		if($this->debug){
			$this->dump($rs);
		}
		return false;
		
	}
	
	 
}




?>