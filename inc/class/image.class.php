<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
class image {
	
	function mkdir($dir){
			$dir = trim($dir,'/');
			 $d= $imgService->createUZDir($dir, "/");		
			return $d->isSuccess();
	}
	function isdir($dir){
			$dir = trim($dir,'/');
			$d = $imgService->getUZDir("/".$dir);
			return $d->isSuccess();
	}
	function upload($dir,$insert=true){
	
		$dir = $dir  ? $dir : date("Ym");
		if(!$this->isdir($dir)){
		 	if($this->mkdir($dir) == false) {
				return array('status'=>'error','msg'=>'目录创建失败.'.$d->getErrorMsg());
			}
		}
		$dir = trim($dir,'/');		
		$response = $imgService->uzUpload("/".$dir."/".md5(TIMESTAMP).'.jpg', NULL);
		$json = array();
		if($response->isSuccess()){
			$img = $response->getResult();			
			$json['img_name'] 		= $img->name;
			$json['img_id'] 		= $img->id;
			$json['dir_id'] 		= $img->dirId;
			$json['img_size'] 		= $img->size;
			$json['img_url']		=	stripcslashes($img->url);
			$json['dir_name'] 		= $dir;
			$json['dateline'] 		= TIMESTAMP;
			if($insert){
			//	$json['id'] = $this->insert($json);	
			}
			$json['status'] = 'success';
			$json['msg'] = '上传成功';
			
		} else {
			$json['status'] = 'error';
			$json['msg'] ='上传失败.'. $response->getErrorMsg();
		}
		return $json;
	}
	
	function insert($arr){
		global $_G;
		return true;
		$image  =  get_filed(__CLASS__);
		$image[dateline] = TIMESTAMP;
		$image[uid] = $_G[uid];
		foreach($arr as $k=>$v){
			if(array_key_exists($k,$image)){
				$image[$k] = $v;
			}
		}
		$image[uid] = intval($image[uid]);
		return DB::insert('images',$image,true); 
	}
	function delete($value,$key="id"){
			global $_G;
			if(!$value) {
				 return array('status'=>'error','msg'=>'要删除的图片值不能为空');
			}
			$value = addslashes($value);
			$key = addslashes($key);
			
			$rs = DB::fetch_first("SELECT * FROM ".DB::table('images')." WHERE $key = '$value'");
			if(!$rs['id']){
				return array('status'=>'error','msg'=>'图片不存在,或不是通过后台上传的,如果图片连接失效,您可手动清空图片内容','a'=>'readonly');
			}
			
			if($rs['location'] ==1 ){
				if($_G[adminid]!=1 && $_G[uid]!=$rs[uid]){
					return array('status'=>'error','msg'=>'您无法删除非自己上传的图片','a'=>'readonly');
				}
					DB::delete('images',"id=".$rs[id]); 
					@unlink(ROOT_PATH.$rs[img_url]);
					return array('status'=>'success','msg'=>'删除成功,请提交表单保存','a'=>'del');
			}
			
			
			$response= $imgService->deleteUZImgById($rs['img_id']);
			if($response->isSuccess()){	
					DB::delete('images',"id=".$rs[id]); 
					return array('status'=>'success','msg'=>'删除成功,请提交表单保存','a'=>'del');
			}else{
				return array('status'=>'error','msg'=>'图片删除失败'.$response->getErrorMsg());
			}
	}


}

?>