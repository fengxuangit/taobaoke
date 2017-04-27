<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class shop extends app{

	function __construct(){
			global $_G;
			$rs = loadcache('shop_cate');
			if(!$rs)loadcache('shop_cate','update');
			$_G['shop_cate'] = $_G['cache']['shop_cate'];

	}
	public function main(){
			global $_G;

			if(!$_GET['id']){
				showmessage('抱歉店铺ID不存在');
 				return false;
			}

			$id = intval($_GET[id]);
			$shop = D(array('table'=>'shop','and'=>'id='.$id,'key'=>'shop_'.$id));
			if(!$shop[id]){
				showmessage('抱歉,未找到店铺');
			}
			$nick = $shop['nick'];
			$rs = D(array('and'=>"nick='$nick'",'order'=>' `sort` DESC,aid DESC ','table'=>'goods','key'=>'shop_goods_'.$id),
			array('size'=>60,'url'=>URL.'m=shop&id='.$id));
			if(count($rs['goods'])>0) $shop['num_iid'] = $rs['goods'][0]['num_iid'];
			$this->add($rs);
			$this->add(array('shop'=>$shop));
			seo($shop[title].'---'.$shop[nick] . ' - 合作商家',$shop[keywords],$shop[description]);
			$this->show();
		}

	function _list(){
			global $_G;

			$url ='m=shop&a=list';
			$and = '';
			$size = 10;
			seo('品牌店铺 - 合作商家');

			if($_GET['cate']){
					$cateid = intval($_GET[cate]);
					$cate = $_G['shop_cate'][$cateid];
					$and .=" AND cate = ".$cateid;
					$url.="&cate=".$cateid;
					if($cate['page']>0) $size = intval($cate['page']);

					// if($cate['title'] ){
					// 	seo($cate[title],$cate[keywords],$cate[description]);
					// }else{
					// 	seo($cate['name'].' - 品牌店铺',$cate[keywords],$cate[description]);
					// }

					seo(!MOBILE ? $cate[title]:$cate['name'],$cate[keywords],$cate[description]);

				}
			if(isset($_GET['shop_type'])){
				$shop_type = intval($_GET[shop_type]);
				$and .=" AND shop_type = ".$shop_type;
				$url.="&shop_type=".$shop_type;
			}


			$and .= " AND start_time < ".TIMESTAMP;
			$and .= " AND ( end_time = 0 or  end_time > ".TIMESTAMP.")";


				$rs = D(array('table'=>'shop','and'=>$and,'order'=>' `sort` DESC,id DESC  ','key'=>''),array('size'=>$size,'url'=>$url));


			$name = __CLASS__;
			if(!isset($_GET['cate'])){
				seo($_G['setting'][$name.'_seo_tit'],$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);
				}
			$this->add($rs);
			$this->show();
	}

}
?>
