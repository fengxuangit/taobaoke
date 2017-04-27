<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
abstract class  apiBase{

	public $show_error = true;	
	public $parse = true;
	public $goods_list = array();
	
	public abstract  function get($file);
	
	
	public abstract function parse($obj);
	
	
	public function get_iids($goods_list){
		if (!is_array($goods_list))  return $goods_list;
		$iids = array();
		foreach($goods_list as $k=>$v){
			$iids[] = $v['num_iid'];
		}
		return implode(',',$iids);
	}
	
	
	public function use_taobaoke(){
			global $_G;
			 if($_G['setting']['taoke_appkey'] && $_G['setting']['taoke_secretKey']){
		          $_G['TOP']->appkey =  trim($_G['setting']['taoke_appkey']);
		          $_G['TOP']->secretKey = trim($_G['setting']['taoke_secretKey']);
		      }else{
		        msg('淘宝客appkey未配置,无法进行操作');
		      }
	}


	public function use_baichuan(){
			global $_G;
			 if($_G['setting']['appkey'] && $_G['setting']['secretKey']){
		          $_G['TOP']->appkey =  trim($_G['setting']['appkey']);
		          $_G['TOP']->secretKey = trim($_G['setting']['secretKey']);
		      }else{
		        msg('百川appkey未配置,无法进行操作');
		      }
	}
	

	
}

?>