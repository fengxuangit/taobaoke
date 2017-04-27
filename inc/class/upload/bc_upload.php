<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

include_once ROOT_PATH.'inc/class/upload/upload_base.php';

//百川老版本上传
class bc_upload extends upload_base{
	public function init($appkey,$accessKey,$type,$namespace){
		return $this;
	}
	
	function upload($file){
				global $_G;		
				
				$picService = Alibaba::Pic();				
				if(is_string($file)){
					$file  = file_get_contents(ROOT_PATH.$file);
				}else{
					$file  = file_get_contents($file['tmp_name']);
				}
				if(!$file) false ;
				$response=$picService->savePic($this->dir,$this->name,$file);
			
				if($response->getStatus() && $response->isSuccess()){
					$result=$response->getResult();	
					return 	$result[0]->fullUrl;						
				}else{
						$code = array(200=>"请求成功",
							400=>"参数错误",
							404=>"图片不存在",
							405=>"目录不存在",
							408=>"图片大小超限",
							406=>"目录非空不能删除",
							406=>"存在同名目录或文件",
							408=>"请求超时",
							500=>"系统错误");
							$codeInt = $response->getStatus();
							$this->code = $codeInt;
							$this->msg = $code[$codeInt];
						$msg = ('图片上传错误,错误代码:'.$codeInt.',错误信息:'.$code[$codeInt]);
						L($msg);						
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