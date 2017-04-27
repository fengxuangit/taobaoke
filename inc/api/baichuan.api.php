<?php
if(!defined('IN_TTAE')) exit('Access Denied');


//百川API
//include_once	(ROOT_PATH.'top/request/TaeItemsListRequest.php');
include_once	(ROOT_PATH.'top/baichuan/TaeItemsListRequest.php');

include_once ROOT_PATH.'inc/api/apiBase.class.php';


//商品抓取和发布类
//百川高级电商能力
class api_baichuan extends apiBase{


		function parse($i){

		}

		function get($i){
			
		}

		function get_list($list){
				return $this->get_goods($list);
		}

		//最大50 / 1组
		//http://open.taobao.com/apidoc/api.htm?path=scopeId:11681-apiId:23731
		//字段都会返回,只是查询是不能全写上,不然会报错.
		function get_goods($ids,$open_iid){
				global $_G;

				$req = new TaeItemsListRequest;


				$field = 'title,num,nick,pic_url,price,location,shop_name,post_fee';
				if(is_string($ids)){
					$ids = trim($ids,',');
				}else if(is_array($ids)){
					$ids = implode(',',$ids);
				}
				$req->setFields($field);
				$req->setNumIids($ids);
				$req->setOpenIids($open_iid);

				$resp = $_G['TOP']->execute($req);

				top_check_error($resp,true);

				$arr = array();
				$item = $resp->items->x_item;

				if(count($resp->items->x_item) ==1) {
						  $rs = $resp->items->x_item[0];
						  $arr = $this->parse_goods($rs);
						  return $arr;
				  }else{
					  $arr = array();
					  foreach($resp->items->x_item as $k=>$v){
						  $numiid = (string)$v->open_id;
						  $arr[$numiid] =$this->parse_goods($v);
					  }
					  return $arr;
				  }
				return false;

		}



		function parse_goods($item){
				global $_G;

				$arr = array();
				$arr['open_iid'] =		(string)$item->open_iid ;
				$arr['num_iid'] =		(string)$item->open_id ;						//商品ID
				$arr['title'] = 		$item->title;							//商品标题
				$arr['nick'] = 			$item->nick;							//卖家昵称
				$arr['picurl'] = 		$item->pic_url ;						//商品缩略图
				$arr['url'] = 			'http://item.taobao.com/item.htm?id=' .$arr['num_iid'] ;						//商品链接地址
				$arr['price'] =			sprintf("%.1f",$item->reserve_price);			//原价


				$arr['shop_type'] =		$item->mall?'1':'2';

				//注意价格,有些优惠价是原价,返回时可以过滤
				if($item->price_wap){
					$arr['yh_price'] =		$item->price_wap;
				}else if($item->price){
					$arr['yh_price'] =		$item->price;
				}else if($item->ju_price){
					$arr['yh_price'] =		$item->ju_price;
				}else{
					$arr['yh_price'] =		$item->reserve_price;
				}

				$arr['yh_price'] =sprintf("%.1f",$arr['yh_price']);


				$arr['bili'] =		$item->tk_rate ? ($item->tk_rate/100):'-1';
				if($item->tk_rate>0){
					$arr['bili'] =	$item->tk_rate/100;
					//$arr['bili'] = intval($item->tk_rate) * $arr['yh_price']/100;
					$tmp['yongjin'] 			= 			($arr['yh_price'] * $v->tk_rate) /100 / 100;

				}else if($item->istk){
					//$arr['bili'] =	'';	//防止是更新时,给替换了

				}else{
					$arr['bili'] =	'-1';
				}
				return $arr;
		}

		function get_sku($num_iid,$open_iid){
				global $_G;
				if(!$num_iid && !$open_iid) return false;
				if(!class_exists('TaeItemDetailGetRequest'))include_once	(ROOT_PATH.'top/baichuan/TaeItemDetailGetRequest.php');

				if(!$open_iid){
					$rs = $this->get_goods($num_iid);
					$open_iid = $rs['open_iid'];
				}

				$req = new TaeItemDetailGetRequest;
				//$req->setFields("itemInfo,priceInfo,skuInfo,stockInfo,rateInfo,descInfo,sellerInfo,mobileDescInfo,deliveryInfo,storeInfo,itemBuyInfo,couponInfo");
				$req->setFields("priceInfo,skuInfo,stockInfo");
				$req->setOpenIid($open_iid);
				$resp = $_G['TOP']->execute($req, $sessionKey);
				top_check_error($resp,true);
				$rs =  $resp->data;
				return $rs;
		}
}

?>
