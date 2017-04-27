<?php

if(!defined('IN_TTAE')) exit('Access Denied'); 
class api_goods {
	private $top = null;
	private $query = array();
	private $count = 0;			//获取次数统计,有时会获取会空,最多重试3次
	public $max_size = 48;		//每页最大个数
	public $max_page = 200;		//最大返回页数
	public $cache = true;		//是否缓存
	public $url = '';			//自动生成的URL链接
	public $sort =array(
							'default',				//默认
							'price_desc',			//原价从高到低
							'price_asc',			//原价从低到高
							'credit_desc',			//信用等级从高到低
							'credit_asc',			//信用等级从低到高
							'commission_num_desc',	//佣金比率从高到低
							'commission_rate_asc'	//佣金比率从低到高
			);
			
		
	function get($arr,$url){
			global $_G;
			if(is_string($arr)){
				$tmp = array();
				$tmp['keyword'] = $arr;
				$arr = $tmp;
			}
			
			if($this->cache){
					$time = $_G['setting']['cache_time'];
					if($arr['time']) $time = intval($arr['time']);
					if($time>0){
						$time = $time*60;
						if($arr['key']){
							$key = $arr['key'];
						}else{
							$key = md5(http_build_query($arr));
							$key = 'api_'.substr($key,0,10);
						}
						if($_G['mobile']) $key.='_mb';
						$rs = memory('get',$key);
						if($rs) return $rs;
					}
			}
						
			if(isset($arr['key']))unset($arr['key']);
			if(isset($arr['time']))unset($arr['time']);
			
			$this->count++;
			$this->url = $url;		
			if($this->url)$this->url = URL.str_replace(array(URL,' '),'',$this->url);
			
			$get_type = $_G['setting']['api_type'];		//1 = 百川淘宝客	0=阿里妈妈淘客
			if($get_type ==1 ) $this->max_size = 100;
			
			
			$arr =$this->check($arr);
			if($arr['page_size']>$this->max_size || !$arr['page_size']) $arr['page_size'] =	$this->max_size;
			
			
			if($arr['keyword']){
				$arr['keyword'] = trim_html($arr['keyword'],1);
				$this->query['kw'] = trim_html($this->query['kw'],1);
			}
			if($get_type == 1){
				$this->top = top('taobaoke');				
				$rs =$this->top->get($arr,1);
			
			}else if($get_type ==0){				
				
				$this->top = top('tbk');
				$this->top->get_ext = false;
				$rs  = $this->top->get($arr);
				
			}else {
				msg('请先在采集设置中设置采集接口');
			}
			
			
			if($rs['count'] >0 && $this->url) {	
				$max_page = $this->max_page;
				$count = $rs['count'];
				$max_count = $arr['page_size']*$max_page;
				if($count>$max_count)$count = $max_count;
				
				$max_page = 0;
				if($_G['mobile']==1) $max_page = 3;
				$rs['showpage'] = multi($count,$arr['page_size'],$_G[page],$this->url,$max_page);	
				$rs['query'] = $url.http_build_query($this->query);
				
			}else{
				$rs= $rs['goods'];
			}
			if($this->count <3 && !$rs){				
				return  $this->get($arr,$url);
			}

			if($this->cache && $time>0 && $rs)memory('set',$key,$rs,$time);		
			$this->count = 0;		
			return $rs;
		
	}
private 	function check($arr){
			$fd = array('page'=>'page_no','size'=>'page_size','kw'=>'keyword','price1'=>'start_price','price2'=>'end_price',
						'sort'=>'sort','cid'=>'cid','key'=>'key','time'=>'time'
			);
			$new_arr = array();
			
			foreach($fd as $k=>$v){
					if($arr[$k]){
						$new_arr[$v] = $arr[$k];
					}else if($arr[$v]){
						$new_arr[$v] = $arr[$v];
					}
			}

			if($new_arr['sort'] && $new_arr['sort'] =='rand'){
				$index = rand(0,count($this->sort)-1);
				$new_arr['sort'] = $this->sort[$index];
			}
			if(!$new_arr['start_price'])$new_arr['start_price'] = 5;
			if(!$new_arr['end_price'])$new_arr['end_price'] 	= 999;
			
			return $new_arr;
	}
	function auto_get($url){
			global $_G;
			$arr = array();
			$arr['page_no'] = $_G['page'];
			$arr['sort'] = 'default';
			if($_G['fid']){
				$fid = intval($_G['fid']);
				$url .='&fid='.$fid;
				$this->query['fid']  = $fid;
			}

			if($_GET['cid']){
				$arr['cid'] = intval($_GET['cid']);
				$url .='&cid='.$arr['cid'];	
				$this->query['cid']  = $arr['cid'];
			}
			if($_GET['kw']){
				$arr['keyword'] = $_GET['kw'];
				$url .='&kw='.($arr['keyword']);
				$this->query['kw']  = $arr['keyword'];
			}
			
			if($_G['fid']){				
				if(!$arr['cid'] && $_G['channel'] && $_G['channel']['cid']){
					$arr['cid'] = $_G['channel']['cid'];
					$url .='&cid='.$arr['cid'];
					$this->query['cid']  = $arr['cid'];
				}else if(!$arr['keyword']){
					$arr['keyword'] = $_G['channel']['name'];
					$url .='&kw='.($arr['keyword']);
					$this->query['kw']  = $arr['keyword'];
				}
			}
			if(!$arr['keyword'] && !$arr['cid']){
				$arr['keyword'] = '女折';
				$url .='&kw='.($arr['keyword']);
				$this->query['kw']  = $arr['keyword'];
			}

			if($_GET['price1'] || $_GET['price2']){
				$arr['start_price'] = 5;
				$arr['end_price'] 	= 999;				
				if($_GET['price1'])$arr['start_price'] = intval($_GET['price1']);
				if($_GET['price2'])$arr['end_price']  = intval($_GET['price2']);
				$url .='&price1='.$arr['start_price'].'&price2='.$arr['end_price'];
				
				$this->query['price1']  = $arr['start_price'];
				$this->query['price2']  = $arr['end_price'];
				
			}

			if($_GET['tmall']){
				$arr['mall_item'] = "true";
				$url .='&tmall=1';
				$this->query['tmall']  = 1;
			}
			
			
				
			if($_GET['sort'] && in_array($_GET['sort'],$this->sort)) {
				$arr['sort'] = $_GET['sort'];
				$url .='&sort='.$arr['sort'];
				$this->query['sort']  = $arr['sort'];
			}
			return $this->get($arr,$url);
			
	}
  	
	
	


}