<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
class sitemap extends app{	
	private $size = 1000;
	function main(){
		global $_G;
			if($_G['setting']['api'] ==1 ){
				$this->api_out();
				return ;
			}
		
			$rs ='<?xml version="1.0" encoding="utf-8"?>
   <urlset>
';
			$rs .=$this->sitemap_create('a=today');
			$rs .=$this->sitemap_create('a=tomorrow');
			$rs .=$this->sitemap_create('a=all');
			$rs .=$this->sitemap_create('a=over');
			$rs .=$this->sitemap_create('a=history');
			if(array_key_exists('shop',$_G['table'])){
				if(count($_G[shop])>0)$rs .=$this->sitemap_create('m=shop&a=shop_list');			
			}
			foreach($_G[channels] as $k=>$v){
				if($v['hide'] == 1) continue;
				$rs .=$this->sitemap_create('fid='.$v[fid]);
				
				foreach($v['sub'] as $k1=>$v1){
					if($v1['hide'] == 1) continue;
					$rs .=$this->sitemap_create('fid='.$v1[fid]);
					foreach($v1['sub'] as $k2=>$v2){
						if($v2['hide'] == 1) continue;
						$rs .=$this->sitemap_create('fid='.$v2[fid]);					
					}
				}
			}
			

		$goods = DB::fetch_all("SELECT dateline,num_iid FROM ".DB::table('goods')." WHERE 1 ORDER BY aid DESC LIMIT ".$this->size);
		foreach($goods as $v){
			$tmp_url = 'itemid='.$v['num_iid'];
			$rs.= $this->sitemap_create($tmp_url,$v['dateline']);
		}
		
		if(array_key_exists('style',$_G['table'])){
				$style = D(array('table'=>'style','order'=>'id DESC','limit'=>300,'field'=>'goods,id,dateline','key'=>'sitemap_style'));
				foreach($style as $v){
					$url = 'm=style&id='.$v['id'];
					$rs.= $this->sitemap_create($url,$v['dateline']);
					foreach($v['goods'] as $v1){
						$url2 =  'm=style&a=goods&id='.$v['id'].'&num_iid='.$v1[num_iid];
						$rs.= $this->sitemap_create($url2,$v['dateline']);
					}
				}
		}
		if(array_key_exists('zj',$_G['table'])){
				$style = D(array('table'=>'zj','order'=>'id DESC','limit'=>300,'field'=>'goods,id,dateline','key'=>'sitemap_zj'));
				foreach($style as $v){
					$url = 'm=zj&id='.$v['id'];
					$rs.= $this->sitemap_create($url,$v['dateline']);
					foreach($v['goods'] as $v1){
						$url2 =  'm=zj&a=goods&id='.$v['id'].'&num_iid='.$v1[num_iid];
						$rs.= $this->sitemap_create($url2,$v['dateline']);
					}
				}
		}
		
		if(array_key_exists('img',$_G['table'])){
				$img = D(array('table'=>'img','order'=>'id DESC','limit'=>300,'field'=>'id,dateline','key'=>'sitemap_img'));
				//$img = DB::fetch_all("SELECT id,dateline FROM ".DB::table('img')." WHERE hide = 0 ORDER BY id DESC LIMIT 300");
				
				foreach($img as $v){
					$url = 'm=img&id='.$v['id'];
					$rs.= $this->sitemap_create($url,$v['dateline']);
				}
		}
		
		$rs.='  </urlset>';
		header('Content-Type: text/xml; charset='.CHARSET);
		echo $rs;
	}
	
private function api_out(){
			global $_G;
			
			$rs = '';
			foreach($_G[channels] as $k=>$v){
					if($v['hide'] == 1) continue;
					$rs .=$this->sitemap_create('fid='.$v[fid]);				
					foreach($v['sub'] as $k1=>$v1){
						if($v1['hide'] == 1) continue;
						$rs .=$this->sitemap_create('fid='.$v1[fid]);
						foreach($v1['sub'] as $k2=>$v2){
							if($v2['hide'] == 1) continue;
							$rs .=$this->sitemap_create('fid='.$v2[fid]);					
						}
					}
			}		
						
			$rs.= $this->sitemap_create('a=all&price1=1&price2=10',TIMESTAMP);
			$rs.= $this->sitemap_create('a=all&price1=10&price2=20',TIMESTAMP);
			
			if($_G['setting']['sitemap_kw']){
					$arr = explode(",",$_G['setting']['sitemap_kw']);				
					shuffle($arr);
					$arr = array_slice($arr,0,5);
					include_once libfile('class/api_goods');
					$api_goods = new api_goods;
					$parem   =array('time'=>60);
					foreach($arr as $k=>$v){
						$parem['kw'] = trim($v);
						if(!$parem['kw']) continue;
						$tmp  = $api_goods->get($parem);
						if($tmp && count($tmp)>0){
							foreach($tmp as $k=>$v){					
								$rs.= $this->sitemap_create('itemid='.$v['num_iid'],TIMESTAMP);
							}
						}
					}
			}
			


$text ='<?xml version="1.0" encoding="utf-8"?>
   <urlset>
';

			$text.=$rs;
			$text.='  </urlset>';
			header('Content-Type: text/xml; charset='.CHARSET);
			echo $text;
	
	}
	
	function sitemap_create($url,$dateline){
		global $_G;
		//$url= $_G[siteurl].rewrite_url($url);
		
		if($_G['setting']['rewrite']){
			$url= $_G[siteurl].rewrite_url($url);
		}else{
			$url= $_G[siteurl].'index.php?'.($url);
			$url = str_replace('&','&amp;',$url);
		}
		
		
		$url = str_replace('"','',$url);
		$rs='        <url>';
		$rs.='<loc>'.$url.'</loc>'; 
		$dateline = $dateline ? $dateline :TIMESTAMP;
		$rs.='<lastmod>'.dgmdate($dateline,'Y-m-d').'</lastmod>';
		$rs.='<changefreq>daily</changefreq>';
		$rs.='<priority>0.8</priority>';
		if(isset($_GET[mb])){
			$rs.='<data><display><html5_url>'.$url.'</html5_url></display></data>';
		}else{
			//$rs.='<mobile:mobile type="autoadapt"/>';
			$rs.='<mobile type="autoadapt"></mobile>';
		}
		
		
		$rs.='</url>
';
		return $rs;
	}
	
	//360移动适配
	function sll(){
		global $_G;


		$goods = DB::fetch_all("SELECT num_iid FROM ".DB::table('goods')." WHERE ORDER BY aid DESC LIMIT ".$this->size);
		$url = array();
		$url[] = 'a=today';
		$url[] = 'a=tomorrow';
		$url[] = 'a=all';
		$url[] = 'a=over';
		$url[] = 'a=history';
		$url[] = 'a=map';
		foreach($_G[channels] as $k=>$v){
			$url[] = 'fid='.$v[fid];
		}
		foreach($_G[cate] as $k=>$v){
			$url[] = 'cate='.$v[id];
		}
		foreach($goods as $k=>$v){
			$url[] = 'itemid='.$v['num_iid'];
		}
		$content = '';
		foreach($url as $k=>$v){
			$content.= $_G[siteurl].rewrite_url($v).'	'.$_G[siteurl].rewrite_url($v)."
";
		}
		echo $content;
	}
	
	
	
	function map(){
		global $_G;
		$this->show();
	}

}
?>
