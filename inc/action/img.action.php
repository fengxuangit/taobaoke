<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class img extends app{
	function main(){
		global $_G;
		$id = intval($_GET['id']);
		if(!$id) {
			msg('抱歉,ID不存在');
 			return false;
		}
		$cache_name = 'img_'.$id;
		if($_G['setting']['cache_time']>0)$cache = memory('get',$cache_name);
		if(is_array($cache)){
			$img = $cache;
		}else{
				$img = D(array('and'=>' AND id = '.$id,'table'=>__CLASS__));
				if(!$img[id]){
					msg('抱歉,当前信息不存在');
					return false;
				}
				if($img['hide'] ==1) {
					msg('抱歉,当前信息未审核');
				}
				DB::update('img',array('like'=>$img[like]+1),'id='.$id);
				$up =D(array('and'=>' AND id <'.$id,'table'=>__CLASS__,'order'=>'id DESC'));
				$down =   D(array('and'=>' AND id >'.$id,'table'=>__CLASS__,'order'=>'id ASC'));

				$img[up] = $up[id]? '<a href="'.$up[url].'">'.$up[title].'</a>' : '没有了';
				$img[down] = $down[id]? '<a href="'.$down[url].'">'.$down[title].'</a>' : '没有了';

			//	$img[message] = preg_replace("/###\{(.*?)\}###/ies","parse_img_goods('\\1')",$img[message]);
				//$img[message] = preg_replace("/###\{(.*?)\}###/ies","parse('img_goods','\\1')",$img[message]);
				if($_G['setting']['cache_time']>0){
					$time =  intval($_G['setting']['cache_time'])*60;		//默认5分钟
					memory('set',$cache_name,$img);
				}
		}

		$this->add(array(
			'img'=>$img
		));
		seo($img['title'],$img['keywords'],$img['description']);
		$this->show();
	}

	function _list(){
		global $_G;

		$url = URL.'m=img&a=list';
		$and = ' `hide` = 0 ';
		$tag = '';
		if($_GET[tag]){
			$tag = $_GET['tag'];
			$tag = urldecode_utf8($tag);
			$tag = daddslashes($tag);
			$and .="AND FIND_IN_SET('".$tag."', keywords) ";
			$url .="&tag=".urlencode_utf8($tag);
		}
		if(isset($_GET['cate'])){
			$cate_id = intval($_GET['cate']);

			$cate = $_G['img_cate'][$cate_id];
			$this->add(array('cate'=>$cate));
			$and .=" AND cate  in (".$cate['id_in'].")";
			$url.="&cate=".$cate_id;
			seo(!MOBILE ? $cate[title]:$cate['name'],$cate[keywords],$cate[description]);
		}else{
			$name = __CLASS__;
			seo($_G['setting'][$name.'_seo_tit'],$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);
		}

		$img = D(array('and'=>$and,'table'=>'img','order'=>'`sort` DESC,id DESC','key'=>'img_list_'.$tag),array('size'=>10,'url'=>$url));
		$this->add($img);
		ajaxoutput($img['goods']);
		

		$this->show();
	}


	function like(){
		global $_G;
		$rs = $this->_like('img','like',$_G['id']);
		if(is_array($rs) && $rs['status'] =='success'){
			$cache_name = 'img_'.$_G['id'];
			memory('delete',$cache_name);
		}
		json($rs);
	}

	function hate(){
			global $_G;
			$rs = $this->_like('img','hate',$_G['id'],'踩');
			if(is_array($rs) && $rs['status'] =='success'){
				$cache_name = 'img_'.$_G['id'];
				memory('delete',$cache_name);
			}
			json($rs);
		}



}
?>
