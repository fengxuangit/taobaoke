<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

include_once ROOT_PATH.'inc/class/upload/upload_base.php';
if(!class_exists('AlibabaImage'))require_once(ROOT_PATH.'web/lib/alibaba_upload_class/alimage.class.class.php');
class baichuan_upload extends upload_base{
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
	
	public function upload($file){
		global $_G;
		if(!$this->appkey){
			if(!$_G['setting']['baichuan_name']){
				$this->msg ='百川上传空间名称未配置';
				return false;
			}
			
			$this->init($_G['setting']['appkey'],$_G['setting']['secretKey'],'TOP',$_G['setting']['baichuan_name']);
		}
		$image  = new AlibabaImage($this->appkey, $this->accessKey, $this->type);
		$uploadPolicy = new uploadPolicy();
		$uploadPolicy->dir =$this->dir;    // 
		$uploadPolicy->name =$this->name;  // 文件名不能包含"/"
		$uploadPolicy->namespace= $this->namespace; // type =TOP 必填		
		$rs = $image->upload($file, $uploadPolicy, $opts = array());	
		
		return $this->check($rs);
		
	}
	public function check($rs){
		$this->code = $rs['code'];
		$this->msg = $rs['message'];
			
		if($rs['isSuccess']){
			return $rs['url'];
		}		
		if($this->debug){
			$this->dump($rs);
		}
		return false;
		
	}
	
	 
}




?>