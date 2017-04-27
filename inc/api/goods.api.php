<?php
if(!defined('IN_TTAE')) exit('Access Denied');

include_once	(ROOT_PATH.'top/request/SpItemInfoListGetRequest.php');

if(!class_exists('ShopGetRequest')){
	include_once	(ROOT_PATH.'top/request/ShopGetRequest.php');
}

//商品抓取和发布类
class api_goods{
		public 	$get_sid = true;
		function get_list($list){
					global $_G;
					return $this->get_goods($list);
		}
		function parse_goods($resp){
							global $_G;

							$arr = array();
							$arr['num_iid'] =		$resp->item_id ;						//商品ID
							$arr['title'] = 		$resp->title;							//商品标题
							$arr['nick'] = 			$resp->nick;							//卖家昵称
							$arr['picurl'] = 		'http://img4.tbcdn.cn/tfscom/'.$resp->pic_url ;						//商品缩略图
							$arr['url'] = 			$resp->item_url ;					//商品链接地址
							$arr['price'] =			sprintf("%.1f",$resp->price);			//原价

							$arr['yh_price'] =		$resp->final_price;
							$arr['bili'] 		= 	$resp->tk == 0 ? '-1' : '';
							$arr['shop_type'] = 	$resp->tmall ==1 ? 1:2;
							$arr['images']	 =explode(',',$resp->item_imgs);



							$list_time = dmktime($resp->list_time);
							$delist_time = dmktime($resp->delist_time);


							$arr['message'] = 		'' ;



							return $arr;
		}


		//获取一个商品

		function get_goods($num_iid=''){
			global $_G;


						if($_G['setting']['api_type'] ==0 ){	//淘宝客
							$rs = top('tbk','get_goods',$num_iid);
						}else if($_G['setting']['api_type'] ==1 ){	//百川
							$rs = top('baichuan','get_goods',$num_iid);
						}else{
							$rs = top('m_taobao','get',$num_iid);
						}

						return $rs;

		}



		function update($arr,$aid){

					if(!$aid || !$arr) return false;

					if(isset($arr['images']) && $arr['images'] && is_array($arr['images'])){
						$arr['images'] = array_filter($arr['images']);
						$arr['images'] = implode(',',$arr['images']);

					}

					if(isset($arr['ly'])) 		$arr['ly']		=	trim($arr['ly']);

					if(isset($arr['picurl'])) 	$arr['picurl']		=	trim($arr['picurl']);
					if(isset($arr['yh_price']))$arr['yh_price'] 	=	floatval($arr['yh_price']);
					if(isset($arr['sort']))	$arr['sort'] 			=	intval($arr['sort']);
					if(isset($arr['views']))	$arr['views'] 			=	intval($arr['views']);
					if(isset($arr['sum']))		$arr['sum'] 			=	intval($arr['sum']);

					if(isset($arr['fid']))		$arr['fid'] 			=	intval($arr['fid']);
					if(isset($arr['flag']))	$arr['flag'] 			= 	intval($arr['flag']);
					if(isset($arr['sort']))	$arr['sort'] 			=	intval($arr['sort']);

					if(isset($arr['views']))	$arr['views']			=	intval($arr['views']);

					if(isset($arr['cate']))	$arr['cate']			=	intval($arr['cate']);

					if(isset($arr['shop_type']))$arr['shop_type']			=	intval($arr['shop_type']);
					if(isset($arr['start_time']))	 		{
							$arr['start_time']		=	 is_string($arr['start_time']) 	? dmktime($arr['start_time'])		 : intval($arr['start_time']);
					}
					if(isset($arr['end_time']))	{
							$arr['end_time']		= 	 is_string($arr['end_time']) 		? dmktime($arr['end_time']) 		: intval($arr['end_time']);
					}
					if(isset($arr['bili']))	$arr['bili']			=	intval($arr['bili']);
					unset($arr['zk']);

					if(isset($arr['like']))	$arr['like'] = intval($arr['like']);

					$aid = DB::update('goods',$arr,'aid='.$aid);

				//	api_post(array('a'=>'update','table'=>'goods','data'=>$arr,'pre_key'=>'num_iid','id'=>$arr['num_iid']));
					return $aid;
		}

		function insert($arr,$update = false){
						global $_G;

						if(!is_array($arr) || !$arr || !$arr['num_iid']) return false;

						$num_iid = trim($arr['num_iid']);
						$res = DB::fetch_first("SELECT aid FROM ".DB::table('goods')." WHERE num_iid='$num_iid'");
						if($res[aid]>0) {
							if($update){
								return $this->update($arr,$res['aid']);
							}else{
								return false;
							}
						}
						if($arr['images'] && is_array($arr['images'])){
							$arr['images'] = array_filter($arr['images']);
							$arr['images'] = implode(',',$arr['images']);
						}elseif(!$arr['images']){
							$arr['images'] = '';
						}
						$arr = get_filed('goods',$arr);

						if(!$arr['sort'] && $_G['setting']['goods_sort'] == 1){
							$sort = memory('get','goods_sort');
							if($sort>0){
								$arr['sort'] = $sort+1;
							}else{
								$aid = DB::result_first("SELECT aid FROM ".DB::table('goods')." ORDER BY aid DESC ");
								$arr['sort'] = $aid+1;
							}
							memory('set','goods_sort',$arr['sort']);
						}




						$arr['fid']         =	intval($arr['fid']);
						$arr['flag']        = 	intval($arr['flag']);
						$arr['sort']        =	intval($arr['sort']);

						$arr['views']       =	intval($arr['views']);

						$arr['cate']        =	intval($arr['cate']);

						$arr['shop_type']   =	intval($arr['shop_type']);


						$arr['bili']        = 	$arr['bili'] 					? 	intval($arr['bili']) : 0;

						$arr['keywords']    = 	$arr['keywords'] 				? 	trim($arr['keywords']):'';
						$arr['description'] = 	$arr['description'] 			? 	trim($arr['description']):'';

						if($arr['ly']){
							$arr['ly'] = trim($arr['ly']);
							$arr['ly'] = strip_tags($arr['ly']);
						}

							$arr['num_iid'] 		= 	$arr['num_iid'] 		? 	trim($arr['num_iid']):'';

							$arr['title'] 			=	$arr['title'] 	 		? 	trim($arr['title']):'';
							$arr['nick'] 			= 	$arr['nick']		 	? 	trim($arr['nick']):'';
							$arr['picurl'] 			= 	$arr['picurl']		 	? 	trim($arr['picurl']):$arr['images'][0];
							//$arr['picurl'] = preg_replace("/\.jpg(.*?)$/i",'.jpg',$arr['picurl']);
							$arr['picurl'] = preg_replace("/_(\d+)x(\d+)\.jpg/is",'',$arr['picurl']);


							
							//$arr['url'] 			= 	 'http://item.taobao.com/item.htm?id='.$arr['num_iid'];
							$arr['price'] 			= 	$arr['price']  	  		?	sprintf("%.1f",$arr['price']):0;

							$arr['message'] 		= 	$arr['message']		 	? 	trim($arr['message']):'';

							$arr['yh_price']		= 	$arr['yh_price']		?	sprintf("%.1f",$arr['yh_price']) :$arr['price'];


							$arr['start_time']		= 	dmktime($arr['start_time']);
							$arr['end_time']		= 	dmktime($arr['end_time']);
							//if($arr['juan_url'] && $arr['end_time']>0) $arr['end_time'] +=86399;
							$arr['dateline']=	$arr['dateline']>0? $arr['dateline'] :TIMESTAMP;
							$arr['like'] = intval($arr[like]);
							$arr['posttime']= TIMESTAMP;

							$arr['title'] = trim_html($arr['title'],1);
							$arr['title'] = cutstr($arr['title'],250,'');
							$arr['ly'] = cutstr($arr['ly'],250,'');


							if(isset($arr['zk']))unset($arr['zk']);
							if(isset($arr['open_iid']))unset($arr['open_iid']);
							if(isset($arr['baoyou']))unset($arr['baoyou']);
							if(isset($arr['shop']))unset($arr['shop']);

							//批量入库时会卡死
							// if(!$arr['keywords'] && $_G[setting][auto_keywords] == 1){
							// $arr['keywords'] = get_keywords($arr['title']);
							// }


						if( strpos($arr['url'],'a=go_pay') !== false ||  strpos($arr['url'],'itemid=') !== false ||  strpos($arr['url'],'item.htm') !== false){
								$arr['url'] = '';
						}


						try{
							$id =DB::insert('goods',$arr,1);
						}catch(Exception $e){
							L('商品ID重复','error');
							return false;
						}

						if($id>0) {

								$arr['id'] = $arr['num_iid'];
								api_post(array('a'=>'insert','table'=>'goods','data'=>$arr));
						}
						return $id;
		}

}

?>
