<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

include_once ROOT_PATH.'inc/class/upload/upload_base.php';

//在优站上用的上传方式
class uz_upload extends upload_base{
	public function init($appkey,$accessKey,$type,$namespace){
		return $this;
	}
	
	
	function upload($fileItem){
				global $_G;		
				if($fileItem){
					$name=$fileItem->getName();
					$content=$fileItem->getContent();
					if(!$content) false ;
					$picService = $PicServiceFactory->getPicService();
					$response=$picService->savePic($this->dir,$this->name,$content);
					if($response->success){
						$result=$response->getResult();							
						return 	$response->getResult()->fullUrl;						
					}else{
						$this->code = $response->status;
						$this->msg = $response->errorMsg;
						$msg = ('图片上传错误,错误代码:'.$response->status.',错误信息:'.$response->errorMsg);
						L($msg);						
					}
				}
			
	
}
	
	
	public function check($rs){		
		if($this->debug){
			$this->dump($this->code);
			$this->dump($this->msg);
			
		}
		return false;
		
	}
	
	 
}




?>