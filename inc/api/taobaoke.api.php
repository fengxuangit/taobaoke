<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

//获取后台可发布的分类...
include_once	(ROOT_PATH.'top/tbk/TbkItemGetRequest.php');
include_once	(ROOT_PATH.'top/taobaoke/AtbItemsDetailGetRequest.php');

//include_once ROOT_PATH.'inc/api/baichuan.api.php';

//百川的 无线开放百川淘客包 
class api_taobaoke{
		public $total = 0 ;
		
		
		 function get($arr,$get_url){
        		global $_G;
    

        	$req = new TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
		if(!$arr['keyword'] && !$arr['cid']){
			return array('count'=>0,'goods'=>array());
		}
		
		if($arr['keyword'])$req->setQ($arr['keyword']);
		if($arr['cid'])$req->setCat($arr['cid']);
		$req->setItemloc($arr['area']);
		$req->setSort($arr['sort']);
		$req->setIsTmall($arr['mall_item']);
		if($arr['start_price'])$req->setStartPrice($arr['start_price']);
		if($arr['end_price'])$req->setEndPrice($arr['end_price']);
		if($arr['start_commission_rate'])$req->setStartTkRate($arr['start_commission_rate']* 100) ;
		if($arr['end_commission_rate'])$req->setEndTkRate($arr['end_commission_rate']* 100) ;

		$req->setPageNo($arr['page_no']);
		$req->setPageSize($arr['page_size']);


        $resp = $_G['TOP']->execute($req);

        top_check_error($resp, 1);

		$rt = array();
		$rt['count'] = $resp->total_results;
		
		if($rt['count']==0) return array('count'=>0,'goods'=>array());
		$rt['goods'] =  $this->parse($resp);

        return $rt;

        }


      function parse($resp) {
        $items=$resp->results->n_tbk_item;
		$goods_list = array();
	
		foreach($items as $k=>$item){
				$arr = array();
				
				$num_iid = $arr['num_iid'] =		(string)$item->num_iid ;						//商品ID
				$arr['title'] = 		trim_html($item->title,1);							//商品标题
				
				$arr['picurl'] = 		$item->pict_url;						//商品缩略图
				$arr['url'] = 			$item->item_url;						//商品链接地址
				$arr['price'] =			fix($item->reserve_price,1);			//原价
				$arr['yh_price'] =			fix($item->zk_final_price,1);			//原价
				$arr['images'] =	implode(',',$item->small_images->string);
				$arr['shop_type'] =		$item->user_type ==1 ?'1':'2';	
                $arr['sid'] =       $item->seller_id."";    

                //新加的字段
                $arr['nick'] =      $item->nick;    
				$arr['sum'] =		$item->volume;	
				$arr['bili']  = '';
				
				//所有淘客API不返回这些字段
				// $arr['bili'] ='';
				// $tmp['yongjin'] = '';	
				
			     $goods_list[] = $arr;
		}
		return $goods_list;

    }

		
		function get_ext_for_baichuan($goods_arr){
			$iids = array();
			foreach($goods_arr as $k=>$v){
				$iids[] = $v['open_iid'];
			}
			if(!$iids ) return ;
			$iids = implode(',',$iids);			
			$rs = top('baichuan','get_goods','',$iids);			
			
			foreach($goods_arr as $k=>$v){
				foreach($rs as $k1=>$v1){
					if($v1['open_iid'] == $v['open_iid']){
						
						$goods_arr[$k]['num_iid'] = $v1['num_iid'];
						$goods_arr[$k]['url'] = $v1['url'];
					}
				}
			}
			
			return $goods_arr;
		}
		
		
		
		
		//参数: 商品列表数组,每组商品中,必须有open_iid字段
		//不限数组长度,会自动进行10个分组去查询.
		function get_url($goods_arr){
			global $_G;
			$iids = array();
			foreach($goods_arr as $k=>$v){
				$iids[] = $v['open_iid'];
			}
			
			//每10个一组.获取详情信息
			$iids2 = array_chunk($iids,10);
			$rt = array();
			
			foreach($iids2 as $k=>$v){
				$rt = array_merge($rt,$this->get_ext_info($v)); 
			}
				
			$list = array();
			//将详情信息和商品信息合并
			foreach($goods_arr as $k=>$v){
				//$list[$k] = array_merge($v,$rt[$v['open_iid']]);		//这个API中,有些商品返回是空的,就要过滤掉..
				if(array_key_exists($v['open_iid'],$rt)){
					$list[$k] =  array_merge($v,$rt[$v['open_iid']]);
				}
			}
			return $list;
		}
		
		
		
		//获取商品扩展信息字段,需入商品的open_iid,最多10个
		function get_ext_info($open_iids,$all=false){
			global $_G;
			if(is_array($open_iids)) $open_iids = implode(',',$open_iids);
			$req = new AtbItemsDetailGetRequest;

			//http://open.taobao.com/apidoc/dataStruct.htm?spm=a219a.7386789.0.0.4vyC0e&path=scopeId:11483-dataStructId:115030-apiId:23806-invokePath:atb_item_details.item
			//上方字段都可获取
			//desc
			$fd = "open_iid,detail_url,num,freight_payer,approve_status,item_imgs,post_fee,express_fee,ems_fee,item_img.url,nick";
			
			
			if($all) $fd.=",title,cid,pic_url,location,shop_type,price";

			if($_G['setting']['get_message'])$fd.=",desc";
			$req->setFields($fd);
			$req->setOpenIids($open_iids);
			$resp = $_G['TOP']->execute($req);	
			top_check_error($resp,1);		

			$rt = $this->parse_ext_info($resp,$all);
			
			return $rt;
		}		
		
		function parse_ext_info($rs,$all=false){
			global $_G;
			$arr = array();
			$item = $rs->atb_item_details->aitaobao_item_detail;
			$rt = array();

			foreach($item as $k=>$v){
				$tmp = array();
				if($all) {

					$tmp['title'] =  trim_html($v->item->title,1);
					$tmp['shop_type'] =  $v->item->shop_type == 'B' ?1 :2;
					$tmp['price'] =  $v->item->price;
					$tmp['picurl'] =  $v->item->pic_url;
				}
				
				$tmp['url'] =  $v->item->detail_url;
				$tmp['num_iid'] = get_goods_id($v->item->detail_url);
				
				$tmp['nick'] =  $v->item->nick;
				$img = $v->item->item_imgs->item_img;
				if($_G['setting']['get_message']) $tmp['message'] = $v->item->desc;
				$img_list = array();
				foreach($img as $k1=>$v1){
					$img_list[] = $v1->url;
				}
				
				$tmp['images'] = implode(',',$img_list);

				
				$open_iid =   $v->item->open_iid;
				$arr[$open_iid] = $tmp;
				
			}

			return $arr;
		}	
		
}