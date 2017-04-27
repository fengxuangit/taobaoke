<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 


//商品抓取和发布类
class api_channel {
		
		
		function parse($resp){
			if(!$resp->value) return false;
			
			$resp->value = urldecode_utf8($resp->value);
			$value = $resp->value;

			$value = str_replace(array("[","]","\""),'',$value);
			if($value)$value = explode(',',$value);			
			return $value;
		}

		function get_channel(){
			global $_G;
			if(!class_exists('SpContentGetallclassRequest')) include_once ROOT_PATH.'top/request/SpContentGetallclassRequest.php';
			
			$req = new SpContentGetallclassRequest;
			$req->setSiteKey($_G['setting'][sitekey]);
			
			
			$resp = $_G['TOP']->execute($req);
			
			top_check_error($resp,$this->show_error);
							
			$value=$this->parse($resp);
			
			if(is_array($value) && count($value)>0){
				$rs = implode(',',$value);
				if(!isset($_G['setting']['uz_type'])){
					insert_setting('uz_type',$rs);
				}else{
					set_setting('uz_type',$rs);
				}
				loadcache('setting','update');
			}
			
			return $value;	
		}
		function update_channel($new_name,$old_name){
			global $_G;			
			if(!class_exists('SpContentUpdateclassRequest')) include_once ROOT_PATH.'top/request/SpContentUpdateclassRequest.php';
			$req = new SpContentUpdateclassRequest;
			$req->setSiteKey($_G['setting'][sitekey]);
			$req->setNewname($new_name);
			$req->setOldname($old_name);
			$resp = $_G['TOP']->execute($req);			
			if(!$resp->is_success){
				top_check_error($resp,$this->show_error,true);	
			}
			return $resp;
		}
		function delete_channel($name){
			global $_G;			
			if(!class_exists('SpContentDeleteclassRequest')) include_once ROOT_PATH.'top/request/SpContentDeleteclassRequest.php';
			$req = new SpContentDeleteclassRequest;
			$req->setSiteKey($_G['setting'][sitekey]);
			$req->setClassname($name);

			$resp = $_G['TOP']->execute($req);			
			if(!$resp->is_success){
				top_check_error($resp,$this->show_error,true);	
			}

			return $resp;
		}
	
}

?>