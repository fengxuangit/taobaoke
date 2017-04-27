<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
include_once ROOT_PATH.'inc/class/upload/upload.class.php';
include_once ROOT_PATH.'inc/class/upload/upload_base.php';

class web_upload extends upload_base{
	
	public function init(){
		return $this;
	}
	
	function upload($file){
				global $_G;
				
				
				if(!class_exists('upload')) include ROOT_PATH.'inc/class/upload.class.php';
				
				if(!is_array($file)) 	$file =$this->file;	
				
				$upload = new upload();
				$img_arr= $attach = array();
				$upload_path = 'assets/uploads/';
				
				$rs = $upload->init($file,$upload_path);
				if(!$rs) return false;
				
				$attach  = & $upload->attach;
				if($attach['extension'] != 'jpg' && $attach['extension'] != 'png'){
					$this->file_type = '.'.$attach['extension'];
					$this->__construct();
				}
				
				if($attach['extension'] == 'attach' && $attach['isimage']!=1) {					
					$this->msg = '上传的文件格式不在允许范围内';
					 L ($this->msg.$attach['tmp_name']);
					@unlink($attach['tmp_name']);
					return false;	//非可上传的文件,就禁止上传了
				}
				
				$upload_max_size  =$_G['setting']['upload_max_size'] ? intval($_G['setting']['upload_max_size']):2;
				
				if($attach['size']>1024*1024*$upload_max_size){
					$this->msg = '上传文件失败,系统设置最大上传大为:'.$upload_max_size.'MB';
					 L ($this->msg);
					 @unlink($attach['tmp_name']);
					return false;
				 }
				if($attach['errorcode']){
					$this->msg = '上传图片失败'.errormessage();
					 @unlink($attach['tmp_name']);
					 L ($this->msg);
					return false;					
				}
				
				$lang_path = ROOT_PATH.$upload_path.$this->dir2;
				if(!is_dir($lang_path)) dmkdir($lang_path);				
				$attach['target'] = $lang_path.$this->name;			
				
				$upload->save();				
				return $upload_path.$this->dir2.$this->name;
	
}
	
	
	public function check($rs){		
		if($this->debug){
			$this->dump($this->mmsg);
		}
		return false;
		
	}
	
	 
}




?>