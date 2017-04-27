<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class style extends app{
	function main(){
			global $_G;
			$id = intval($_GET[id]);
			if(!$id)msg('抱歉,要查看的搭配id不能为空');
			$and = ' AND id = '.$id;
			$goods = D(array('and'=>$and,'table'=>'style'));


			if(!$goods[id]) msg('抱歉,未找到相关搭配');
			if($goods[check] !=1) msg('抱歉,当前搭配信息未审核');


            $user = getuser($goods['uid'],'uid');
            $goods['member'] = $user;

			$update = array();
			$update[views] = $goods['views'] + 1;
            DB::update('style', $update, ' id=' . $goods['id']);
			save_history(__CLASS__,$id);
			seo($goods[title],$goods[title],$goods[title]);
			$this->add(array('style'=>$goods,'user'=>$user));
			$this->show();


	}

	function goods(){
		global $_G;
			$id = intval($_GET[id]);
			if(!$id)msg('抱歉,要查看的搭配id不能为空');
			$and = ' AND id = '.$id;

			$num_iid = get_goods_id($_GET[num_iid]);
			if(!$num_iid)msg('抱歉,要查看的商品id不能为空');


			$rs = D(array('and'=>$and,'table'=>'style'));

			if(!$rs[id]) msg('抱歉,未找到相关搭配');
			if($rs[check] !=1) msg('抱歉,当前搭配信息未审核');


			$goods = array();
			foreach($rs['goods'] as $k=>$v){
				if($v['num_iid'] == $num_iid){
					$goods = $v;
					break;
				}
			}
			if(count($goods) ==0) msg('抱歉,未找到相关商品');

			$goods['id'] = $id;
			$update = array();
			$update[views] = $rs['views'] + 1;
            DB::update('style', $update, ' id=' . $rs['id']);
			seo($goods[title],$rs[keywords],$rs[description]);
			$this->add(array('goods'=>$goods,'rs'=>$rs));
			$this->show();
	}

	function _list(){
			global $_G;

			$and='';
			$url = 'm=style&a=list';
			if($_GET[chunk]) $url.='&chunk='.intval($_GET[chunk]);
			// if($_GET[cate]){
			// 	if(is_numeric($_GET[cate])){
			// 			$cate = intval($_GET[cate]);
			// 			$and .="  AND cate= ".$cate;
			// 			$url .="&cate=".$cate;
			// 			$this->add(array('cate'=>$_G['style_cate'][$cate]));
			// 	}

			// }

			if(isset($_GET['cate'])){
				$cate_id = intval($_GET['cate']);
				$cate_obj = $_G['style_cate'][$cate_id];
				if(!$cate_obj){
					foreach($_G['style_cate'] as $k=>$v){
						if($v['sub']){
							foreach($v['sub'] as $k1=>$v1){
								if($v1['id'] == $cate_id){
									$cate_obj = $v1;
									break;
								}
							}

						}

					}
				}

				$and .=" AND cate  in (".$cate_obj['id_in'].")";
				$url.="&cid=".$cate_id;
				$this->add(array('cate'=>$cate_obj));

				seo(!MOBILE ? $cate_obj[title]:$cate_obj['name'],$cate_obj[keywords],$cate_obj[description]);
			}
			if($_GET[tag]){
				$tag = $_GET['tag'];

				$string  = trim_html(stripsearchkey($tag));

				if(preg_match("/^%+$|^_+$|^\*+$/is",$string)) {
					msg('非法搜索关键字');
				}
				$string = safe_output($string);
				if(dstrlen($string)<2){
					msg('要搜索的关键字长度不能小于2');
				}else if(dstrlen($string)>15){
					msg('要搜索的关键字长度不能大于15');
				}
				$tag = urldecode_utf8($string);
				$tag = daddslashes($tag);

				$and .=" AND  ( title like '%$tag%' or FIND_IN_SET('".$tag."', keywords)  ) ";
				$url .="&tag=".urlencode_utf8($tag);
			}

			if($_GET[uid]){
				$uid = intval($_GET[uid]);
				$and .="  AND uid= ".$uid;
				$url .="&uid=".$uid;
			}


			$and .= ' AND `check` =1 ';
			$size = 20;
			$key = substr(md5($and),0,10);
			$rs = D(array('and'=>$and,'table'=>'style','order'=>' `sort` DESC, id DESC'),array('size'=>$size,'url'=>$url));



		ajaxoutput($rs['goods'],false);


		$name = __CLASS__;
		if(!isset($_GET['cate'])){
			seo($_G['setting'][$name.'_seo_tit'],$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);
		}

		$this->add($rs);
		$this->show('style/list');

	}


	function like(){
		global $_G;
		$rs = $this->_like('style','like',$_G['id']);
		json($rs);
	}



}
?>
