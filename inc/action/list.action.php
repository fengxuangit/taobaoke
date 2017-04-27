<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class _list extends app{
function main(){
		global $_G;

		$title =$_G[setting][seo_title];
		$and='';
		$url=URL.'m=list';
		$rs = array('showpage'=>'','count'=>0,'goods'=>array());
		$size = $channel['page'] >0 ? intval($channel['page']):$_G['setting'][cate_page];
		

		
	
		$this->add($rs);		
		$this->add(array('channel'=>$channel));
		seo($channel['title'],$channel['keywords'],$channel['description']);		
		$this->show();	
	}
	
private  function api_get($add_page){
		global $_G;
		$url = URL.'m=list';
		if($_G['fid']>0)	$url.="&fid=".$_G['fid'];
		$channel = $_G['channel'];
		$cid = 0;
		$arr = array();		

		if($_GET['cid']){
			
			$cid = intval($_GET['cid']);
			$cates = include libfile('config/taobao_cate');
			
			$cate = array();
			foreach($cates as $k=>$v){
				if($v['cid']== $cid){
					$cate = $v;
					break;
				}elseif($v['sub']){
					foreach($v['sub'] as $k1=>$v2){
						if($v2['cid'] == $cid){
							$cate = $v2;
							break;
						}
					}
				}
			}
			if(!$cate['cid']){
				msg('分类ID不存在');
			}
			$title = $cate['name'];			
		}elseif($channel){
			$cid = intval($channel['classname']);
			$title = $channel[name];
		}
		if($cid>0) $arr['cid'] = $cid;
		
		if($_GET['kw']){		
			  $string  = stripsearchkey(trim($_GET['kw']));			  
			  if(preg_match("/^%+$|^_+$|^\*+$/is",$string)) {
				  msg('非法搜索关键字'); 
			  }
			  $string = safe_output($string);
			  if(dstrlen($string)<2){
				  msg('要搜索的关键字长度不能小于2'); 
			  }
			  $_GET[kw] =$string;

			  $arr['keyword'] = $string;
			  $url.="&kw=".$string;
			  $title .=" ".$string;
			  unset($arr['cid']);			  
		}
		
		if($_GET['sort']){
			$order_in = array('price_asc','sales_desc','credit_desc');
			if(in_array($_GET['sort'],$order_in)){
				$arr['sort'] = $_GET['sort'];
				$url.="&sort = ".$_GET['sort'];
				unset($_GET['sort']);
				
			}
		}
		if(!$_GET[kw])unset($_GET['kw']);
		if(!$arr[keyword] && !$arr['cid']) $arr[keyword] = '特价';
		
		$arr['start_price']  = 1;
		$arr['end_price']  =99999;
		
		if($_GET['price1']){
			$_GET['price1'] = 	$arr['start_price']  = floatval($_GET['price1']);
			$url.="&price1=".$arr['start_price'];
		}
		if($_GET['price2']){
			$_GET['price2'] = 	$arr['end_price']  = floatval($_GET['price2']);
			$url.="&price2=".$arr['end_price'];
		}
		if($_GET['sort']){
			$sort_arr = array("price_desc","price_asc","credit_desc","credit_asc","commission_num_desc","commission_rate_asc");
			if(in_array($_GET['sort'],$sort_arr)){
				$arr['sort']  = $_GET['sort'];
				$url.="&sort=".$arr['sort'];
			}
		}
		
		//分页大小,优站 40   淘客 40 - 100
		$size = $channel['page'] >0 ? intval($channel['page']):$_G['setting'][cate_page];
		if($size>100) $size = 100;
		
		$arr[page_no] = $add_page ?( $_G[page] +$add_page ):  $_G[page];
		$arr[page_size] = $size;		
		$key = md5(http_build_query($arr));


		$size =40;
		$rs = memory('get',$key);
		//接口类型  1 = 优站  2= 淘客
		if(!$rs)	{
			
			
			if($goods){
					$rs = array('showpage'=>$showpage,'count'=>$count,'goods'=>$goods);
					memory('set',$key,$rs,3600);
			}
		}
		return $rs;
	}
	
	function parse($goods_arr){
		global $_G;
		foreach($goods_arr as $k=>$v){

			$goods_arr[$k] =$v;
		}

		return $goods_arr;
			
	}


}
?>