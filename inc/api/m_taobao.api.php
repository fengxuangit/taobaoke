<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 


//商品抓取类
class api_m_taobao {
		public $get_message = false;
		public $data = null;
		public $get_comment = false;
		function update_goods($arr,$aid,$posttime){
				global $_G;
				 
				if(!$arr[num_iid]) return false;
				
				if(!$aid || !$posttime){
					$goods = DB::fetch_first("SELECT aid,dateline FROM " .DB::table('goods')." WHERE num_iid ='".$arr[num_iid]."' ");				
					$aid = $goods[aid];
					$posttime = $goods[dateline];
				}
				
				if($aid>0){
					$data = array();
					
					foreach($_G['setting']['filter_field'] as $k=>$v){
							if(isset($arr[$v]))	$data[$v] = $arr[$v];	
					}
					
									
					//只更新10天前的商品,一般上线时间是5天,可能5天后卖家没有修改价格..
					if($data[yh_price] && $posttime + 864000 > TIMESTAMP) unset($data[yh_price]);
					
					if($data){
						$data[dateline] = TIMESTAMP;
						$rt= top('goods','update',$data,$aid);
						return $rt;
					}
				}
				return false;
		}
		
		function get($goods_id,$update=false,$aid){
			global $_G;
			if(!$goods_id) return false;
			$url = "http://hws.m.taobao.com/cache/wdetail/5.0/?id=".$goods_id;
			
			
			$content = fetch($url);
			if(!$content) return false;
			//if(TAE)$content = unicode_decode($content,'UTF-8',"\xe");
			$data = json_decode($content,true);		
			if(!is_array($data)) return false;
			
			
			if($data[ret][0] != 'SUCCESS::调用成功'){
				$_G['msg'] = $data[ret][0];
						L('详情获取失败:'.$data[ret][0].',url=>'.$url);
						 return false;
			}		
			$this->data = $data;
			$rt = $this->parse_goods($data[data]);			
				
			if($update){
				$this->update_goods($rt,$aid);
			}		
			
			return $rt;
			
		}
		
private		function parse_goods($arr){
			global $_G;

			$tmp = array();
			$tmp['title'] 		= 		$arr['itemInfoModel']['title'];
			$tmp['num_iid'] 	= 		$arr['itemInfoModel']['itemId'];			
			$tmp['images'] 		= 		$arr['itemInfoModel']['picsPath'];
			foreach($tmp['images'] as $k=>$v){
				$tmp['images'][$k]  =  str_replace("_320x320.jpg","",$v);
			}
			$tmp['views'] 		= 		$arr['itemInfoModel']['favcount'];
			$tmp['picurl'] 		= 		$tmp[images][0];			
			
			$tmp['nick'] 		= 		$arr['seller']['nick'];
			
			$tmp['shop_type'] 	= 		$arr['itemInfoModel']['itemTypeName'] == 'tmall'?1:2;
			$tmp['url']			= 		($tmp['shop_type'] ==1?'http://detail.tmall.com':'http://item.taobao.com').'/item.htm?id='.$tmp['num_iid'];
			$tmp['shop_logo'] 	=   $arr['seller']['picUrl'];
			$tmp['shop_url'] 	=   'https://shop'. $arr['seller']['shopId'].'.taobao.com';
			if(TAE)$content = unicode_decode($content,'UTF-8',"\xe");
			
			$tmp2 = json_decode($arr['apiStack'][0]['value'],true);
			if(!is_array($tmp2)) return $tmp;
			
			
			if($tmp2[ret][0] != 'SUCCESS::调用成功')return $tmp;
			$tmp[sum] = $tmp2[data][itemInfoModel][totalSoldQuantity];
			$tmp[num] =$tmp2[data][itemInfoModel][quantity];
			
			$priceUnits = $tmp2[data][itemInfoModel][priceUnits];			
			$tmp['yh_price'] = $priceUnits[0]['price'];
			
			if(strpos($tmp['yh_price'],'-') !==false){
				$tmp1 = explode('-',$tmp['yh_price']);
				$tmp['yh_price'] = min($tmp1[0],$tmp1[1]);
			}
			if($priceUnits[1]){
				$tmp[price] = $priceUnits[1]['price'];
			}else{
				$tmp[price] = $priceUnits[0]['price'];
			}
				
			if(strpos($tmp[price],'-') !==false){
				$tmp1 = explode("-",$tmp['price']);
				$tmp['price'] = min($tmp1[0],$tmp1[1]);
			}			
			$tmp['yh_price'] =sprintf("%.1f",$tmp['yh_price']) ;
			$tmp['price'] = sprintf("%.1f",$tmp['price']);
			$tmp[message] = $this->get_message($tmp['num_iid']);		
			if($this->get_comment) $tmp['comment'] = $this->parse_comment($arr['rateInfo']);
					
			return $tmp;
		}
		
		function get_message($num_iid,$focus = false){
				global $_G;
			
				if($_G[setting][get_message] || $focus || $this->get_message){
					
						//	$url =    'http://hws.m.taobao.com/cache/mtop.wdetail.getItemDescx/4.1/?data=%7B%22item_num_id%22%3A%2243151340941%22%7D';
						$url = 'http://hws.m.taobao.com/cache/mtop.wdetail.getItemDescx/4.1/?data=';						
						$url .= urlencode_utf8('{"item_num_id":"'.$num_iid.'"}');
						
						$message = fetch($url);		
						
						if(!$message) return '';						
						//if(TAE)$content = unicode_decode($content,'UTF-8',"\xe");
						
						$data2 = json_decode($message,1);	
						if(!is_array($data2)){
							$_G['msg'] = $data2[ret][0];
							L('详情获取失败:'.$data2[ret][0].',url=>'.$url);
							return '';
						}elseif($data2[ret][0] != 'SUCCESS::接口调用成功'){
							$_G['msg'] = $data2[ret][0];
							L('详情获取失败:'.$data2[ret][0].',url=>'.$url);
							return false;
						}elseif(is_array($data2[data][images])){
							$message = '';
							foreach($data2[data][images] as $k=>$v){
								$message .='<p class="goods_imgs"><img src="'.$v.'" ></p>';
							}
							return  $message;
						}
				}
			return '';
			
		}
		
		function parse_comment($list){
			$arr = array();
			$arr['count'] = $list['rateCounts'];
			$arr['goods'] = array();
			if($arr['count']>0){
				foreach($list['rateDetailList'] as $k=>$v){
					$tmp = array();
					$tmp['username'] = $v['nick'];
					$tmp['picrul'] = $v['headPic'];
					$tmp['star'] = $v['star'];
					$tmp['content'] = $v['feedback'];
					
					$tmp2 = explode(" ",$v['subInfo']);
					$tmp['dateline'] = $tmp2[0];
					$tmp['info'] = $tmp2[1];
					$arr['goods'][] = $tmp;
				}				
			}

			return $arr;
		}
}

?>