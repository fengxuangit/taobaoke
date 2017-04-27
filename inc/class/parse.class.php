<?php
if(!defined('IN_TTAE')) exit('Access Denied');
class parse {

			public function goods($goods){
					global $_G;

					$goods['channel_name'] = 	$goods[fid]	?	$_G['all_channel']['k'.$goods[fid]][name]:'';
					$goods['flag_name'] 	=	$_G['setting']['flag'][$goods[flag]];
					$goods['cate_name'] 	=	$goods[cate]	?	$_G['cate'][$goods[cate]][name]	:	'';
					$goods['shop_type_name'] =$goods['shop_type'] ==1? '天猫':($goods['shop_type'] ==2?'集市':'');
					$goods['brand_name'] 	=	$goods['brand_id']	?	$_G['brand'][$goods['brand_id']]['name']	:	'';

					$goods['h'] = 0;
					//$goods['tags']= make_tags($goods['keywords'],'/index.php?a=all&tag=');
					if($goods['images']){
						$goods['images']	=	explode(',',$goods['images']);
						$goods['images'] = array_filter($goods['images']);
					}

					if(!$goods['yh_price']) $goods['yh_price'] =$goods['price'];

					$goods['price']		=	intval($goods['price']);
					$goods['yh_price']		= 	fix($goods['yh_price'],1);
					if($goods['yh_price']!=$goods['price']) {
						$goods['zk']	= fix($goods['yh_price']/$goods['price']*10,1);
					}else{
						$goods['zk'] = 0;
					}
					if(!$goods['picurl'] && count($goods['images'])>0) {
						$goods['picurl'] = $goods['images'][0];
					}


					//$goods['picurl']=
					//先判断是否在显示时间内
					 $status = $goods['status'];
					 $goods['status_text']	= $_G['setting']['goods_status'][$status];
					 if($goods['start_time']>0 || $goods['end_time'] > 0){

										if(($goods['start_time']>TIMESTAMP) && ($goods['end_time'] > 0 && $goods['end_time']<TIMESTAMP)){
											 $goods['status_text']	="已下架";
											 $status  =2;
										}elseif($goods['start_time']>TIMESTAMP)  {
											$goods['status_text']		='未开始';
											$status  =3;
											$goods[h] = intval(dgmdate($goods['start_time'],'H'));
										}elseif($goods['end_time'] > 0 && $goods['end_time']<TIMESTAMP)  {
											$goods['status_text']		='已结束';
											$status  =2;
										}

					 }

					 $goods['status']		=	$status;

					$today = TODAY;
					$tomorrow = TOMORROW;

					if(($goods['dateline']>$today) || ($goods['dateline'] >= $today && $goods['dateline'] < $tomorrow)){
						$goods['new'] = 1;
					}else{
						$goods['new'] = 0;
					}


					//动态生成二合一
					if(!defined('IN_ADMIN') && $goods['juan_url'] &&  strpos($goods['juan_url'],'shop.m.taobao.com') !== false){
							$param = getUrlParam($goods['juan_url']);
							$activity_id = $param['activity_id'] ? $param['activity_id'] : $param['activityId'];
							$sid = $param['seller_id'] ? $param['seller_id'] : $param['sellerId'];
							if(!$sid) $sid = $goods['sid'];
							if($activity_id && $sid){
								$pid = $_G['setting']['pid'] ? $_G['setting']['pid'] : 'mm_13204895_15412677_59200383';
								$quan_url =  'https://uland.taobao.com/coupon/edetail?activityId='.$activity_id;	
								$quan_url .= "&itemId=".$goods['num_iid']."&pid=".$pid."&src=kfz_utao";
								//if($sid)$quan_url .= "&sid=".$sid;
								if($goods['bili_type'] ==2 ) $quan_url.="&dx=1";
								$goods['juan_url'] =$quan_url;
								if(!$goods['url'] || strpos($goods['url'],'s.click.taobao.com') === false){
									$goods['url'] = $quan_url;
								}
							}
					}

					if( strpos($goods['url'],'itemid=') !== false ||  strpos($goods['url'],'item.htm') !== false) $goods['url']='';

					if(!$goods['url']) {
						$goods['url'] ='/index.php?a=go_pay&num_iid='.$goods['num_iid'];
					}
					$goods['id_url'] = '/index.php?itemid='.$goods['num_iid'];

					if(defined('IN_ADMIN') && $goods['bili'] >0 ){
						$goods['yongjin'] = fix(($goods['yh_price'] - $goods['juan_price']) * $goods['bili'] / 100,2);
					}
					return $goods;
			}

			public function goods_url($goods,$focus=false){
					global $_G;

					if(!$goods[url]) $goods[url]="http://item.taobao.com/item.htm?id=".$goods[num_iid];
					$goods['org_url'] = $goods['url'];

					$goods['id_url'] = '/index.php?itemid='.$goods['num_iid'];
					$goods['jump_url'] ='/index.php?a=go_pay&num_iid='.$goods[num_iid];

					//淘点金1.0  则跳到站内详情页
					//淘点金2.0  则跳到爱淘宝

					//if($_G['setting']['tdj_type'] ==1) $goods['url'] ;

					if($_G[setting][show_goods] ==1){
						if( CURMODULE == 'goods' || $focus || $_G[mobile]) {
							$goods['url'] =$goods['jump_url'];
						}else if(!ROBOT && $_G[setting][robot_jump] ==1){
							//非蜘蛛 则直接跳到卖家首页
							$goods['url']=$goods['jump_url'];
						}else{
							$goods['url'] =$goods['id_url'];
						}

					}else{
						$goods['url'] =$goods['jump_url'];
					}

					return $goods;
			}

			public function shop($shop){
				global $_G;
				$shop[id_url]  ='/index.php?m=shop&id='.$shop[id];
				//if(!$shop[url])		$shop[url]	 =  'https://shop'. $shop['sid'].'.taobao.com';

				return $shop;
			}

			public function article($article){
				global $_G;
				if(!$article) return false;
				if(!$article[url]){
					$article['target'] = '';
					$article[url]  = '/index.php?m=article&id='.$article[id];

				}else{
					$article['target'] = "target='_blank'";
				}
				$article[id_url]  = '/index.php?m=article&id='.$article[id];
				$article[tag_name] = $_G[setting][article_tag][$article[tag]];

				if(!$article['picurl'])		$article['picurl'] = 'http://img03.taobaocdn.com/imgextra/i3/1905489005/T2sui3XrVXXXXXXXXX_!!1905489005-1-dgshop.gif';
				return $article;

			}

			public function img_goods($rs){
					global $_G;
					if(!$rs) return '';
					$rs = urldecode_utf8($rs);

					$rs = json_decode($rs,true);
					if(in_array($rs[num_iid],$_G[img_item]))return '';
					$_G[img_item][] = $rs[num_iid];
					$goods = '';
					$rs[id]=0;

					if(count($rs) == 3){
						$rs = self::goods_url($rs,1);
						$goods = '<a href="'.$rs[url].'"  target="_blank"><img src="'.$rs[picurl].'" /></a>';
					}elseif(count($rs)>4){

						$rs = self::goods_url($rs,1);
						$rs['yh_price']	= sprintf("%.1f",($rs['yh_price']));
						$rs['yh_price']	=str_replace('.0','',$rs['yh_price']);
						$rs['price']	= sprintf("%.1f",($rs['price']));
						$rs['price']	=str_replace('.0','',$rs['price']);

						  $goods.= '<div class="img_goods"><a rel="nofollow" href="'.$rs[url].'" title="'.$rs[title].'" target="_blank">';
						  $goods.='<img src="'.$rs[picurl].'_480x480.jpg" alt="'.$rs[title].'"></a>';
						  $goods.='<ul><span class="tit"><a rel="nofollow" href="'.$rs[url].'" title="'.$rs[title].'" target="_blank" >'.$rs[title].'</a></span>';
						  $goods.='<div class="rr_price"><em>￥</em>'.$rs[yh_price].($rs[baoyou]==1 ? '<span class="by">/包邮</span>':'').'</div>';
						  $goods.='<div class="many cl"><del>原价:￥'.$rs[price].'</del>  <i>立省<em>'.($rs[price]-$rs[yh_price]).'</em>元</i><span><b>'.$rs[sum].'</b>人已买</span></div>';
						  $goods.='<div class="butt_div"><a rel="nofollow" href="'.$rs[url].'" title="'.$rs[title].'" target="_blank" class="butt">立即抢购</a></div>';
						$str = '';
						if($rs[tags]){
							$kw = make_tags($rs[tags]);
							$str.='<div class="goods_tags"><span>标<br/>签</span>';
							foreach($kw as $k1=>$v1){
								$str.='<a href="/index.php?m=img&a=list&tag='.$k1.'" target="_blank">'.$v1.'</a>';
							}
							$str.='</div>';
						}
						$goods.=$str.'</ul></div>';
					}
					return $goods;
			}


			public function img($img){
				global $_G;
				if(!$img) return false;
				$img[id_url]  = '/index.php?m=img&id='.$img[id];

				if(!defined('IN_ADMIN')){
					if(!$img[url]) $img[url]  = '/index.php?m=img&id='.$img[id];
						$today = TODAY;
						if($img[dateline]>$today){
							$img['new'] = 1;
						}else{
							$img['new'] = 0;
						}
						$img['tags']	=	make_tags($img[keywords]);
						if(!$img['picurl'])		$img['picurl'] = 'http://img03.taobaocdn.com/imgextra/i3/1905489005/T2sui3XrVXXXXXXXXX_!!1905489005-1-dgshop.gif';
				}
				return $img;
			}


			public function sign($gd){
				global $_G;
				$arr = $_G['setting']['jf_type'];
				$gd[name]=$arr[$gd[type]];
				return $gd;
			}

			public function theme($theme){
				global $_G;
				if(!$theme) return false;
				$fid = intval($theme[fid]);
				$theme[count] = getcount('danpin','dp_id='.$theme[id]);

				$theme[url] = 'http://item.taobao.com/item.htm?id='.$theme[num_iid];
				$theme['url'] ='/index.php?a=go_pay&num_iid='.$theme[num_iid];



				$theme[id_url] = '/index.php?m=dapei&a=theme&id='.$theme[id];
				if($_G[dapei][$fid]){
					$dapei = $_G[dapei][$fid];
				}else{
					$continue = false;
					foreach($_G[dapei] as $k=>$v){
						if($continue) continue;
						if($v[sub][$fid]) {
							$dapei= $v;
							$continue= true;
						}
						foreach($v[sub] as $k1=>$v1){
							if($continue) continue;
							if($v1[sub][$fid]) {
								$dapei= $v1;
								$continue= true;
							}
							foreach($v1[sub] as $k2=>$v2){
								if($continue) continue;
								if($v2[$fid]) {
									$dapei= $v2;
									$continue= true;
								}
							}
						}
					}
				}
				$theme[dapei]  = $dapei;
				return $theme;
			}




			public function say($dp,$get_count){
					global $_G;

					$status = intval($dp[check]);

					if($dp[check] ==0){
						$dp[status_text] = '待审核';
					}else if($dp[check] ==1){
						$dp[status_text] = '审核通过';
					}else if($dp[check] ==2){
						$dp[status_text] = '拒绝';
					}
					if($dp[hide] ==1){
						$dp[status_text] = '已隐藏';
						$status = 3;
					}

					if($get_count !== false)$dp['comment_count'] = getcount('comment'," type_id = ".$dp[id]." AND type = 'say' AND `check`=1 ");
					$dp['cate_name']	=	$_G['say_cate'][$dp['cate']][name];
					$dp['tags']	=	make_tags($dp[keywords]);
					$dp[img] = 1;
					if(!$dp['picurl'])		{
						$dp['picurl2'] = 'http://img03.taobaocdn.com/imgextra/i3/1905489005/T2sui3XrVXXXXXXXXX_!!1905489005-1-dgshop.gif';
						$dp[img] = 0;
					}
					$dp[url] = URL.'m=say&id='.$dp[id];
					$dp[flag_name] = $_G[setting][flag][$dp[flag]];
					$dp['user_pic'] = avatar($dp['username'], $dp['uid']);

					return $dp;
			}



			public function duihuan_apply($dp){
					global $_G;
					$dp['statustime']		 	= dgmdate($dp['statustime'],'dt');
					$dp[status_text] = $_G[setting][duihuan_status][$dp[status]];

					if(defined('IN_ADMIN'))$dp[goods] = D(array('table'=>'duihuan','and'=>'id='.$dp[duihuan_id]));
					
					return $dp;
			}



			public function duihuan($dp){
					global $_G;

					$dp[status] = 1;
					$dp[status_text] = '已开始';
					if($dp[start_time]>0 && $dp[start_time]>TIMESTAMP) {
						$dp[status] = 2;
						$dp[status_text] = '未开始';

					}

					if($dp[end_time]>0 && $dp[end_time]<TIMESTAMP) {
						$dp[status] = 3;
						$dp[status_text] = '已结束';
					}
					if($dp[hide]==1) {
						$dp[status] = 4;
						$dp[status_text] = '已下架';
					}



					if(defined('IN_ADMIN')){
						$str = " AND status > 1";
						$dp['count'] = getcount('duihuan_apply','duihuan_id='.$dp[id]);	//所有申请统计
					}else{
						$str = ' AND status !=1';	//不计算已拒绝的
					}

					$dp['num'] = getcount('duihuan_apply','duihuan_id='.$dp[id].$str);	//已提交的的统计 ,不算拒绝的

					if($dp[num]>=$dp[sum]) {
						$dp[status] = 5;
						$dp[status_text] = '已完结';
					}

					// if($dp[num_iid]){
					// 	$dp['url'] ='http://item.taobao.com/item.htm?id='.($dp[num_iid]);
					// 	$dp['url'] ='/index.php?a=go_pay&num_iid='.$dp[num_iid];
					// }else{
					// 	$dp['url'] = '';
					// }
			
					 $dp['id_url'] ='/index.php?m=duihuan&id='.($dp[id]);
					//$dp[shop] = $dp[shopid] && $_G[shop][$dp[shopid]] ? $_G[shop][$dp[shopid]] :array();

					return $dp;

			}




			public function addfavorite_apply($dp){
					global $_G;
					if(defined('IN_ADMIN'))$dp[goods] = D(array('table'=>'addfavorite','and'=>'id='.$dp[addfavorite_id]));
					return $dp;
			}
			public function favorite($dp){
					global $_G;

					$dp['name']			= $_G['setting']['favorite_types'][$dp['type']];

					return $dp;
			}

			public function addfavorite($dp){
					global $_G;

					$dp['url'] ='http://item.taobao.com/item.htm?id='.($dp[num_iid]);
					$dp['url'] ='/index.php?a=go_pay&num_iid='.$dp[num_iid];

					$dp['id_url'] ='/index.php?m=addfavorite';
					if($_G[uid] && !defined('IN_ADMIN')){
						$dp[is_apply] = getcount('addfavorite_apply'," addfavorite_id=".$dp[id] ." AND uid=".$_G[uid]);
					}else{
						$dp[is_apply] = 0;
					}
					$dp['count'] = getcount('addfavorite_apply','addfavorite_id='.$dp[id]);
					return $dp;

			}






			public function activity($dp){
					global $_G;

					$dp[status] = 1;
					$dp[status_text] = '正常显示';
					if($dp[start_time]>0 && $dp[start_time]>TIMESTAMP) {
						$dp[status] = 2;
						$dp[status_text] = '未开始';

					}
					if($dp[end_time]>0 && $dp[end_time]<TIMESTAMP) {
						$dp[status] = 3;
						$dp[status_text] = '已结束';
					}
					if($dp[hide]==1) {
						$dp[status] = 4;
						$dp[status_text] = '已隐藏';
					}

					return $dp;

			}

			public function cate($dp){
				$dp[url] = '/index.php?a=cate&id='.$dp[id];
				$dp[count] = getcount('goods'," AND cate = ".$dp[id]);
				return $dp;
			}

			public function comment($dp){
				global $_G;
				//回复统计
				$dp['count'] = getcount('comment'," AND type = '".$dp[type]."' AND type_id = ".$dp[type_id]." AND `check`=1 AND is_reply=1 AND reply_id =".$dp[id]);
				$dp['content']  = dstripcslashes($dp['content']);
				if(defined('IN_ADMIN')){
					$dp['content']  = htmlspecialchars($dp['content']);
				}
				$dp['c_content'] = cutstr($dp['content'],80);

				if (!$dp['user_pic']) {
					$dp['user_pic'] = avatar($dp['username'], $dp['uid']);
				}

				$dp['type_name'] = $_G[setting][comment_types][$dp[type]];
				return $dp;
			}

			public function style($dp){
				global $_G;

				if(!$dp[content]){
					$dp['content'] =$dp['title'] ;
				}else{
					$dp['content'] =trim_html($dp[content],1);
				}
				$dp['cate_name'] = $_G[style_cate][$dp[cate]]['name'];
				$dp['tags'] = make_tags($dp[keywords],'/index.php?m=style&a=list&tag=');
				if($dp[images]){
					$dp[images] = explode(',',$dp[images]);
				}else{
					$dp[images] =array($dp['picurl']);
				}

				$dp[id_url] =$dp[url] = '/index.php?m=style&id='.$dp[id];
				$check_text = array('待审核','已通过','未通过');
				$dp[check_text] = $check_text[$dp[check]];

				$today = TODAY;
				if ($dp[dateline] > $today) {
					$dp['new'] = 1;
				} else {
					$dp['new'] = 0;
				}

				if (!$dp['user_pic']) {
					$dp['user_pic'] = avatar($dp['username'], $dp['uid']);
				}
				$style_goods = array();

						$num_iids = $dp['goods'];
						if($num_iids && preg_match("/^[0-9,]+$/is",$num_iids)){
							$num_iids = trim($num_iids,',');

							if($num_iids){
							$goods = DB::fetch_all("SELECT aid,fid,num_iid,title,price,yh_price,picurl,url FROM ".DB::table('goods') .
								" WHERE num_iid in (".$num_iids.") ORDER BY aid ASC ");
							}

							if($goods && count($goods)>0){
								foreach($goods as $k=>$v){
									$v['id_url']  = '/index.php?itemid='.$v[num_iid];
									if(!$v['url']){
										$v['url']  = '/index.php?a=go_pay&num_iid='.$v[num_iid];
									}
									$style_goods[] = $v;
								}

							}
					}
				$dp[goods] = $style_goods;

				$dp[length] = count($dp[goods]);

				$dp['price']  = $dp[goods][0]['yh_price'];
				$dp['num_iid']  = $dp[goods][0]['num_iid'];

				return $dp;
			}


			function fetch($rs){
				global $_G;
				$rs['channel_name'] = $_G['all_channel']['k'.$rs['fid']]['name'];

				$rs['value'] = dunserialize($rs['value']);

				return $rs;
			}



			public function movie($dp,$get_count){
					global $_G;

					if($get_count !== false)$dp['comment_count'] = getcount('comment'," type_id = ".$dp[id]." AND type = 'movie' AND `check`=1 ");

					$dp['tags']	=	make_tags($dp[keywords]);
					$dp[img] = 1;

					if(!$dp['picurl'] && !defined('IN_ADMIN'))		{
						$dp['picurl'] = 'http://img03.taobaocdn.com/imgextra/i3/1905489005/T2sui3XrVXXXXXXXXX_!!1905489005-1-dgshop.gif';
						$dp[img] = 0;
					}
					$dp[url] = '/index.php?m=movie&id='.$dp[id];

					//if(defined('IN_ADMIN'))$dp[user] = getuser($dp[uid],'uid');
					$dp[flag_name] = $_G[setting][flag][$dp[flag]];
					$dp[tag_name] = $_G[setting][movie_tags][$dp[tag]];


					$today = TODAY;
					if($dp[dateline]>$today){
							$dp['new'] = 1;
						}else{
							$dp['new'] = 0;
					}
					$dp['user_pic'] =avatar($dp['username'],$dp[uid]);


					return $dp;
			}


			public function zj($dp){
				global $_G;

				if(!$dp[content]){
					$dp['content'] =$dp['title'] ;
				}else{
					$dp['content'] =trim_html($dp[content],1);
				}
				$dp['tag_name'] = $_G[setting][zj_cate][$dp[tag]];
				$dp['tags'] = make_tags($dp[keywords],'/index.php?m=zj&a=list&tag=');


				$dp[id_url] =$dp[url] = '/index.php?m=zj&id='.$dp[id];
				$check_text = array('待审核','已通过','未通过');
				$dp[check_text] = $check_text[$dp[check]];

				$today = TODAY;
				if ($dp[dateline] > $today) {
					$dp['new'] = 1;
				} else {
					$dp['new'] = 0;
				}
				$dp['user_url2'] = '/index.php?m=zj&a=list&u='.$dp['uid'];
				if (!$dp['user_pic']) {
					$dp['user_url2'].='&c=1';
					$dp['user_pic'] = avatar($dp['username'], $dp['uid']);
				}
				if(!$dp['user_url'])$dp['user_url'] =$dp['user_url2'];


				$min = 0;
				if($dp[goods]){
					$tmp =$dp[goods];
					//$dp[goods] = str_replace("\\",'',$dp[goods]);
					//if(defined('IN_ADMIN'))dump($dp['goods'],1);

					$dp[goods] = stripcslashes($dp[goods]);
					$dp[goods]  =dunserialize($dp[goods]);

					if(!$dp[goods]){
						//$dp[goods] = dunserialize($tmp);
					}
					if(is_array($dp[goods]) && $dp[goods]){
						$goods = array();
						foreach($dp[goods] as $k=>$v){
							if(!$v['num_iid'] && $v['url']) continue;
							if($v['num_iid']){
                               // $url = "http://item.taobao.com/item.htm?id=".$v[num_iid];

							   if(CURACTION=='goods'){
							 	 $url = '/index.php?a=go_pay&id=0&num_iid='.$v[num_iid];
							   }else{
								 $url = '/index.php?m=zj&a=goods&id='.$dp['id'].'&num_iid='.$v[num_iid];
							  }
							   $url = '/index.php?a=go_pay&id=0&num_iid='.$v[num_iid];
                               $v[url]  =$url;
                            }
							if($v[content]) $v[content]=trim_html($v[content],1);
							//if($dp[images] && $v[picurl] && !in_array($v[picurl],$dp[images])) $v[images][] = $v[picurl];
							$v[picurl] = str_replace('http:http:','http:',$v[picurl]);
							//$dp[goods][$k] = $v;
							$goods [] =$v;
						}

						$dp[goods]=$goods ;
						$dp[length] = count($goods);
					}else{
						$dp[goods] = array();
					}
				}else{
					$dp[goods] = array();
				}

				$dp['price']  = $dp[goods][0]['price'];
				$dp['num_iid']  = $dp[goods][0]['num_iid'];

				return $dp;
			}

			public function shishang($dp,$get_count){
					global $_G;
					if($get_count !== false)$dp['comment_count'] = getcount('comment'," type_id = ".$dp[id]." AND type = 'movie' AND `check`=1 ");
					$dp['tags']	=	make_tags($dp[keywords]);
					$dp[url] = '/index.php?m=shishang&id='.$dp[id];
					$dp[flag_name] = $_G[setting][flag][$dp[flag]];
					$today = TODAY;
					if($dp[dateline]>$today){
							$dp['new'] = 1;
						}else{
							$dp['new'] = 0;
					}
					$dp['user_pic'] =avatar($dp['username'],$dp[uid]);
					if(!$dp['description'] && $dp['message'])$dp['description'] = cutstr(trim_html($dp['message'],1),260);

					return $dp;
			}




			function youhui($dp,$get_count){
					global $_G;
					$status = intval($dp[check]);

					if($dp[check] ==0){
						$dp[status_text] = '待审核';
					}else if($dp[check] ==1){
						$dp[status_text] = '审核通过';
					}else if($dp[check] ==2){
						$dp[status_text] = '拒绝';
					}

					$dp[cate_name] = $_G[youhui_cate][$dp[cate]]['name'];
					if(!$dp['description']) $dp['description'] = cutstr(trim_html($dp['message'],1),300);

					$dp['tags']	=	make_tags($dp[keywords]);

					if(!$dp['picurl'])		{
						$dp['picurl'] = 'http://img03.taobaocdn.com/imgextra/i3/1905489005/T2sui3XrVXXXXXXXXX_!!1905489005-1-dgshop.gif';
					}
					$dp[id_url] = '/index.php?m=youhui&id='.$dp[id];
					if($get_count !== false)$dp['comment_count'] = getcount('comment'," type_id = ".$dp[id]." AND type = 'youhui' AND `check`=1 ");
					//if(defined('IN_ADMIN'))$dp[user] = getuser($dp[uid],'uid');
					return $dp;
			}

			function order_list($dp){
					global $_G;
					$satus_text = $_G['setting']['order_status'];
					$dp['status_text']		= $satus_text[$dp['status']];

					if($dp['uid']>0 && $dp['status'] == 1){
						DB::update(__FUNCTION__,array('status'=>3),'id='.$dp['id']);
					}

				return $dp;
			}
			function money($dp){
					global $_G;
					$satus_text = $_G['setting']['money_type'];
					$dp['type_name']		= $satus_text[$dp['type']];
					//$dp['money']  = fix($dp['money'],2);
					if(!defined('IN_ADMIN')){
						$dp['desc'] = preg_replace("/\(.*?\)/is",'',$dp['desc']);
					}
					return $dp;
			}



			public function gift($dp){
				global $_G;

				if(!$dp[content]){
					$dp['content'] =$dp['title'] ;
				}else{
					$dp['content'] =trim_html($dp[content],1);
				}
				$dp['duixiang_name'] = $_G[setting][duixiang][$dp[duixiang]]['name'];
				$dp['changhe_name'] = $_G[setting][changhe][$dp[changhe]]['name'];
				$dp['gexing_name'] = $_G[setting][gexing][$dp[gexing]]['name'];

				$dp['leimu_name'] = $_G[setting][leimu][$dp[leimu]]['name'];
				$cate = $dp['cate'];

				if($_G[gift_cate][$cate]){
						$dp['cate_name'] = $_G[gift_cate][$cate]['name'];
				}else{

						//最多遍利两级
						foreach($_G[gift_cate] as $k=>$v){
							if($v['id'] == $cate){
								$dp['cate_name'] =$v['name'];
								break;
							}else{
								foreach($v['sub'] as $k1=>$v1){
									if($v1['id'] == $cate){
										$dp['cate_name'] =$v1['name'];
										break;
									}
								}
							}
						}

				}


				$dp['tags'] = make_tags($dp[keywords],'/index.php?m=gift&a=list&tag=');
				$dp[images] = explode(',',$dp[images]);

				$dp[id_url] =$dp[url] = '/index.php?m=gift&id='.$dp[id];
				$check_text = array('待审核','已通过','未通过');
				$dp[check_text] = $check_text[$dp[check]];

				$today = TODAY;
				if ($dp[dateline] > $today) {
					$dp['new'] = 1;
				} else {
					$dp['new'] = 0;
				}


				$min = 0;
				if($dp[goods]){
					$dp[goods] = stripcslashes($dp[goods]);
					$dp[goods]  =unserialize($dp[goods]);
					if(is_array($dp[goods]) && $dp[goods]){
						foreach($dp[goods] as $k=>$v){
							if($v['num_iid']){
                               // $url = "http://item.taobao.com/item.htm?id=".$v[num_iid];
                               $url = '/index.php?a=go_pay&num_iid='.$v[num_iid];
                               $v[url]  =$url;
                            }
							if($v[content]) $v[content]=trim_html($v[content],1);
							//if($dp[images] && $v[picurl] && !in_array($v[picurl],$dp[images])) $v[images][] = $v[picurl];
							//if(!$v['price'])$v['price']=$v['yh_price'];
							$v['like'] = intval($v['like']);
							$dp[goods][$k] = $v;
						}
						//最多只能添加10条
						$dp[goods] = array_splice($dp[goods],0,10);
					}else{
						$dp[goods] = array();
					}
				}else{
					$dp[goods] = array();
				}
				$dp['price']  = $dp[goods][0]['price'];
				return $dp;
			}

		public function message($dp){
				global $_G;
				return $dp;
		}


		public function tixian($dp){
				global $_G;

				$satus_text = $_G['setting']['tixian_status'];
				$dp['status_text']		= $satus_text[$dp['status']];

				return $dp;
		}

		public function apply($v){
				global $_G;
					static $bm_status_text;
					if(!$v) return $v;
					if($v['uid']>0){
						$v['username'] =DB::result_first("SELECT username FROM ".DB::table('member')." WHERE uid = ".$v['uid']);
					}else{
						$v['username'] ='';
					}

					$v['channel_name'] = '';
					$v['cate_name'] = '';

					if($v['fid'] >0){
						$name = $_G['all_channel']['k'.$v['fid']]['name'];
						$v['channel_name'] = $name;
					}
					if($v['cate'] >0){
						$cate_name =  $_G['goods_catge'][$v['cate']]['name'];
						$v['cate_name'] = $cate_name;
					}

					if(!is_array($bm_status_text)){
						$bm_status_text = array(0=>'待审核',1=>'审核通过',2=>'审核拒绝');
						$tmp = explode("\r\n",$_G[setting][bm_status_text]);
						foreach($tmp as $k=>$v1){
							$v1 = explode("|",$v1);
							$bm_status_text[$v[0]] = array('status'=>$v1[0],'name'=>$v1[1],'content'=>$v1[2]);
						}
					}

					$ck = $v['check'];
					$v['check_status'] = $bm_status_text[$ck];

					return $v;
		}


}

?>
