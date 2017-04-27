<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class article extends app{

	function main(){
		global $_G;
		$id = intval($_GET['id']);

		if($id<1) {
			msg('ID不存在');
 			return false;
		}

		$cache_name = 'article_'.$id;
		if($_G['setting']['cache_time']>0)$cache = memory('get',$cache_name);
		if(is_array($cache)){
			$article = $cache;
		}else{
					$article =D(array('table'=>'article','and'=>' id = ' . $id.'  AND `hide`=0 '));
					if(!$article[id]){
						msg('抱歉,当前文章不存在或未审核');
					}
					$up =D(array('and'=>' AND id <'.$id,'table'=>__CLASS__,'order'=>'id DESC'));
					$down =   D(array('and'=>' AND id >'.$id,'table'=>__CLASS__,'order'=>'id ASC'));

					$article[up] = $up[id]? '<a href="'.$up[id_url].'">'.$up[title].'</a>' : '没有了';
					$article[down] = $down[id]? '<a href="'.$down[id_url].'">'.$down[title].'</a>' : '没有了';

					save_history(__CLASS__,$article[id]);
					DB::update('article',array('views'=>$article[views]+1),'id='.$article[id]);
					if($_G['setting']['cache_time']>0){
							$time =  intval($_G['setting']['cache_time'])*60;		//默认5分钟
							memory('set',$cache_name,$article);
					}

		}
		$this->add(array(
			'article'=>$article
		));

		seo($article['title'],$article['keywords'],$article['description']);
		$this->show($article['tpl']);
	}



	function _list(){
		global $_G;
		$id = intval($_GET['id']);
		$and = '';
		$url = URL."m=article&a=list";
		if($id>0){
				foreach($_G[setting][article_tag] as $k=>$v){
					if($k == $id) $tag = $v;
				}
				if(!$tag) {
					showmessage('未找到分类');
					return false;
				}
				$and.=" AND tag = ".$id;
				$url.="&id=".$id;
		}



		if(isset($_GET['cate'])){
				$cate_id = intval($_GET['cate']);
				$cate = $_G['article_cate'][$cate_id];
				$this->add(array('cate'=>$cate));
				$and .=" AND cate  in (".$cate['id_in'].")";
				$url.="&cate=".$cate_id;
				seo(!MOBILE ? $cate[title]:$cate['name'],$cate[keywords],$cate[description]);
			}else{

				$name = __CLASS__;
				seo($_G['setting'][$name.'_seo_tit'],$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);
			}



		$rs = D(array('and'=>$and.' AND `hide` = 0 ','table'=>'article','order'=>'`sort` DESC,`id` DESC'),array('size'=>10,'url'=>$url));
		foreach($rs[goods] as $k=>$v){
			$rs[goods][$k][message] = trim_html($v[message],1);
		}
		$this->add(array('tag'=>$tag));
		$this->add($rs);


		$this->show();
	}





}
?>
