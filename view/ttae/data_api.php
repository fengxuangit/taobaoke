<?php


class data_api {

		//main 方法返回全局的assign
		

		function index_main(){
					global $_G;
				
					//$tomorrow2= TOMORROW_2;
					//$and 	=' AND start_time>'.TIMESTAMP.' AND start_time<'.$tomorrow2;

					$url = URL.'a=all';
					$sql = make_sql();
					$size =$_G['setting']['cate_page'];
					
					$index = D(array('and'=>$sql['and'],'order'=>$sql[order],'key'=>'index_goods'),array('url'=>$url.$sql[url],'size'=>$size));

					$h = dmktime(dgmdate(TIMESTAMP,'H'));
					$img = D(array('and'=>'','table'=>'img','order'=>'id DESC','limit'=>7,'key'=>'index_img'));

					$index['img'] = $img;
					return $index;

		}
		function index_over(){
				$time = $tomorrow = dmktime(dgmdate(TIMESTAMP+(86400),'d'). ' 10:00');
				return array('time'=>$time);
		}

		function list_main(){
			return $this->channel_main();
		}

		function channel_main(){
					global $assign;


					$cid = $_G[channel][classname];
					$cates =include  libfile("config/taobao_cate");
					$sub = $cates[$cid]['sub'];
					$name = $cates[$cid]['name'];

					$index = array();
					$index['sub']=$sub;
					$index['name']=$name;
					//$index['tag_kw'] = $this->get_tags();

					return $index;
		}



		function shop_list(){
				global $_G,$assign;

				$shop_list = array();

				foreach($assign[goods] as $k=>$v){
					$nick = $v['nick'];
					if(!$nick) continue;
					$and = "nick='$nick'";

					$count = getcount('goods',$and);
					$arr = $v;
					$arr[desc] = cutstr(trim_html($v[desc],1),150);
					$arr[goods] =  D(array('and'=> $and ,'limit'=>4));
					if(count($arr[goods])>0){
						$arr['num_iid'] = $arr[goods][0]['num_iid'];
					}
					$arr['count'] = $count;
					$shop_list[] = $arr;
				}

				return array('shop_list'=>$shop_list);
		}

		function home(){
				$today = dgmdate(TIMESTAMP,'dt');
				$list = get_history('goods',12);
				$history = array();
				if($list && preg_match("/^[\d,]*$/",$list)){
					$history = D(array('and'=>" AND aid in ( $list ) ",'limit'=>12,'order'=>" rand()"));
				}

				return array('today'=>$today,'history'=>$history);
		}

		function duihuan_list(){
				global $_G;
				if($_G[uid]){
					$today = TODAY;
					$tomorrow = TOMORROW;
					$and =" AND dateline > $today AND dateline < $tomorrow   AND type = 'sign' " ;

					$time = TIMESTAMP - 86400 ;
					$sign = DB::fetch_first("SELECT * FROM ".DB::table('sign')." WHERE uid=".$_G[uid].$and);
				}else{
					$sign  = array();
				}

				$tags = array();
				foreach($_G[duihuan_cate] as $k=>$v){
					if($k==0) continue;
					$goods = D(array('and'=>' AND cate = '.$k,'table'=>'duihuan','limit'=>8,'cut'=>'title|34','key'=>'duihuan_cate'.$k));
					$tags [] = array('name'=>$v['name'],'goods'=>$goods);

				}
				return array('sign'=>$sign,'tags'=>$tags);

		}

		function duihuan_main(){
			global $_G,$assign;
			$and ='';
			//if($assign[goods][tag])  $and .=' AND `tag` ='.$assign[goods][tag];
			if( $assign[goods][id]){
				$and .= ' AND id != '.$assign[goods][id];
				$duihuan_success = D(array('and'=>' AND duihuan_id = '.$assign[goods][id]." AND status=4",'order'=>'id DESC ',
									'table'=>'duihuan_apply','limit'=>80,'key'=>'duihuan_main_'.$assign[goods][id]));
				foreach($duihuan_success as $k=>$v){
					$duihuan_success[$k][user] = getuser($v[uid],'uid');
				}

			}
			$and_time.= " AND start_time < ".TIMESTAMP;
			$and_time .= " AND ( end_time = 0 or  end_time > ".TIMESTAMP.")";
			$and .= ' AND  `hide`=0 ' .$and_time;
			$duihuan_goods = D(array('and'=> $and,'order'=>' `sort` DESC,id DESC ','table'=>'duihuan','limit'=>4,'key'=>'duihuan_goods'));



			return array('duihuan_goods'=>$duihuan_goods,'duihuan_success'=>$duihuan_success);
		}

		function index_task(){
				global $_G;
				if(!$_G[uid]) return array();
				$today = TODAY;
				$tomorrow = TOMORROW;
				$and =" AND dateline > $today AND dateline < $tomorrow   AND type = 'sign' " ;
				$time = TIMESTAMP - 86400 ;
				$sign = DB::fetch_first("SELECT * FROM ".DB::table('sign')." WHERE uid=".$_G[uid].$and);
				$share = get_jf($_G[uid]);
				return array('sign'=>$sign,'share'=>$share);
		}
		function index_yaoqing(){
				global $_G;
				$content = $_G[setting][title];
				$content.="，独家精品优惠购，为你精心挑选最优惠的折扣商品，每天9点限时限量秒杀，汇聚淘宝网千款精品1折起，惊喜不断，疯抢不停，更有9.9秒杀、品牌团、热门活动给您带来惊喜！";
				$arr = array(
					'content'=>$content
					,'title'=>'要是早点发现'.$_G[setting][title].'就好了，就不用花那么多冤枉钱啦!'.$_G[siteurl].'/?u='.$_G[uid],
					'picurl'=>$_G[siteurl].$_G[setting][logo],
					'url'=>$_G[siteurl].'/?u='.$_G[uid]
				);
				$share = get_share($arr);
				return array('share'=>$share);
		}




		function goods_main(){
			global $_G,$assign,$_page;

			$fid = intval($_G[fid]);
			$len = 28;
			if($fid>0)$and = " AND aid != ".$_G[aid];

			if($fid){
					if($_G[channels][$fid][fid_in]){
						$tuijuan = D(array('and'=>$and." AND fid in (".$_G[channels][$fid][fid_in].") ",'limit'=>$len ,'key'=>'goods_main_a'));
					}elseif($fid){
						$tuijuan = D(array('and'=>$and." AND fid = ".$fid,'limit'=>$len,'key'=>'goods_main_b'));
					}
			}else{
				$tuijuan = D(array('and'=>$and,'limit'=>$len,'key'=>'goods_main_c'));
			}


			//$index['xiangguan']=$xiangguan;
			//$index['tag_kw'] = $this->get_tags();
		   // $index['shop'] = $this->get_shop();
			$index['tuijuan'] = $tuijuan;

			return $index;
		}


		function article(){
				global $_G;
				$article_list = array();
				$cache_name = 'article_all_list';
				$cache = memory('get',$cache_name);
				if(is_array($cache)){
					$article_list = $cache;
				}else{
						foreach($_G[article_cate] as $k=>$v){
								$tmp = array();
								$tmp[id] = $v['id'];
								$tmp[name] = $v['name'];
								$tmp[goods] = D(array('and'=>' cate = '.$v['id'] . " AND hide = 0 ",'order'=>'`sort` DESC,id ASC','table'=>'article','limit'=>6,
								'cut'=>'title|16'));
								$article_list[] = $tmp;
						}
						memory('set',$cache_name,$article_list);
				}
				return array('article_list'=>$article_list);
		}

		function img_main(){
				global $_G;

				$new = D(array('and'=>' `hide` = 0','table'=>'img','limit'=>12,'cutstr'=>'title|14','key'=>'img_main_a'));
				$like = D(array('and'=>' `hide` = 0','table'=>'img','limit'=>6,'cutstr'=>'title|14','order'=>'rand()','key'=>'img_main_b'));
				$tags = array();
				foreach($like as $k=>$v){
					$v[keywords] = explode(',',$v[keywords]);
					$v[keywords] = array_filter($v[keywords]);
					$v[keywords] = array_unique($v[keywords]);

					foreach($v[keywords] as $k1=>$v1){
						if(!in_array($v1,$tags)){
							$uname = urlencode_utf8($v1);
							$tags[$uname] = $v1;
						}
					}
				}
				$img_data =  array('new'=>$new,'like'=>$like,'tags'=>$tags);


				return $img_data;
		}

		function img_list(){
				global $_G,$assign;
				$new = D(array('and'=>' `hide` = 0','table'=>'img','limit'=>12,'cutstr'=>'title|30','order'=>'rand()','key'=>'img_list'));
				//$goods = $assign[goods];
				$tags = array();
				foreach($new as $k=>$v){
					$v[keywords] = explode(',',$v[keywords]);
					$v[keywords] = array_filter($v[keywords]);
					$v[keywords] = array_unique($v[keywords]);
					foreach($v[keywords] as $k1=>$v1){
						if(!in_array($v1,$tags)){
							$uname = urlencode_utf8($v1);
							$tags[$uname] = $v1;
						}
					}
				}
				return array('new'=>$new,'tags'=>$tags);
		}

		 function  search_shop(){
				global $_G,$assign;
				$sid =  $_GET['sid'] ? $_GET['sid'] : $_GET['shop'];
				$index = array();
				//获取相关的
				$rs  = memory('get',$sid);
				if($rs){
					 $index['xiangguan'] =$rs;
				}else{
					$index['xiangguan'] = top('taobaoke','get_recommend',4,$sid,20);
					if($index['xiangguan'])  memory('set',$sid,$index['xiangguan'],86400);
				}

			   $title = $assign['shop']['shop_title'];
			   $shop1 = "专营";
			   $shop2 = "旗舰";
				$shop3 = "专卖";

			   $and = "";
			   if(strpos($title, $shop1) !== false){
					$and = " AND shop_title like '%$shop1%'";
			   }else if (strpos($title, $shop2) !== false) {
					$and = " AND shop_title like '%$shop2%'";
			   }else if (strpos($title, $shop3) !== false) {
					$and = " AND shop_title like '%$shop3%'";
			   }

			//	$index['tag_shop'] = $this->get_shop($and);

				$tehui =  D(array('and'=>'','limit'=>20));
				$index['tehui'] = $tehui;

				return $index;
		}

	 function  search_main(){
        return $this->goods_main();
    }

	function style_main(){
			global $_G,$assign;
			$and = '';
			$cate = $assign[style][cate];
			if($tag>0) {
				$and = " AND cate = ".$cate;
			}else{
				$and = ' AND id <'.$_G['id'];
			}
			$and.=" AND `check` = 1 ";
			$xiangsi = D(array('and'=>$and,'table'=>'style','order'=>'  id DESC','limit'=>10,'key'=>'style'));

			if(!$assign[style]['user_desc']){
				$assign[style]['user_desc'] = '这家伙很懒,什么也没留下.';
				$assign[style]['url'] = '';
			}
			return array('xiangsi'=>$xiangsi);
		}


}





?>
