<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

//店铺API
include_once	(ROOT_PATH.'top/request/SpShopInfoGetRequest.php');	




//商品抓取和发布类
class api_shop {
		
		
		function get_shop($sid){
				global $_G;
				
				if(!$sid) return false;				
				
				$req = new SpShopInfoGetRequest;
				$req->setSiteKey($_G[setting][sitekey]);
				$req->setSellerId($sid);			
				$resp = $_G['TOP']->execute($req);
				
				
				
				top_check_error($resp,true);
					$arr = array();
					$arr['nick'] 			= 				'';
					$arr['sid'] 			= 				$sid;
					$arr['cid'] 			= 				0;
					$arr['title'] 			= 				$resp->shop->shop_title;
					$arr['desc'] 			= 				'';
					
					$arr['url'] 			=				$resp->shop->shop_url;
					$arr['type'] 			=				$resp->shop->tmall == 1 ? 2:1;
					$arr['pic_path']	=				'';
											
					return $arr;
				
				
				
		}
		
		
		function insert($arr,$id){
					global $_G;
					if(!$arr) return false;	
					$arr['nick'] 			= 		$arr['nick']		?		trim($arr['nick']) 			:	'';
					$arr['sid'] 			= 		$arr['sid']			?		trim($arr['sid']) 				:	'';
					$arr['title'] 			= 		$arr['title']		?		trim($arr['title']) 			:	'';
					$arr['desc'] 			= 		$arr['desc']		?		trim($arr['desc']) 			:	'';
					
					$arr['pic_path'] 		= 		$arr['pic_path']	?		trim($arr['pic_path']) 		:	'';
					$arr['picurl'] 			= 		$arr['picurl']	?		trim($arr['picurl']) 		:	'';
					$arr['banner'] 			= 		$arr['banner']	?		trim($arr['banner']) 		:	'';

					$arr['url'] 			= 		$arr['url']			?		trim($arr['url']) 				:	'';
					
					
					$arr['start_time'] 		=	dmktime($arr['start_time']);
					$arr['end_time'] 		=	dmktime($arr['end_time']);
					$arr['zk'] 				=	floatval($arr['zk']);
					
					$arr['cate'] 			=	intval($arr['cate']);
					$arr['shop_type'] 			=	intval($arr['shop_type']);
					$arr['hide'] 			=	intval($arr['hide']);
					$arr['sort'] 			=	intval($arr['sort']);


					if($id>0){
						$id = DB::update('shop',$arr,'id='.$id);
						api_post(array('a'=>'update','table'=>'shop','data'=>$arr,'pre_key'=>'sid','id'=>$arr['sid'],'cache'=>'channels,all_channel'));	
					}else{
						$arr['dateline'] =	TIMESTAMP;
						$id = DB::insert('shop',$arr,1);
						if($id>0)api_post(array('a'=>'insert','table'=>'shop','data'=>$arr,'cache'=>'shop,shop_type','id'=>$id));	

					}					
					return $id;				
		}
		

	
}

?>