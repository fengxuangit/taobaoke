<?php
if(!defined('IN_TTAE')) exit('Access Denied');


class cache {
	var $obj;
	var $name;
	function __construct(){
			global $_G;
			$this->obj =memory('obj');
			if(!is_object($this->obj)){
				$this->load('fileServer');
				if(!is_object($this->obj)){
					$this->load('file');
				}
			}

			$_G['cache_type'] =$this->name = $this->obj->name;


	}
	private function load($type){
			if($this->obj && $this->obj->enable) return true;
			$class = $type.'_cache';
			if(!class_exists($class)){
					$file = ROOT_PATH.'inc/class/cache/'.$class.'.php';
					include_once $file;
			}
			$obj = new $class();
			$rs = $obj->init();

			if($obj->enable && method_exists($obj,'get')){
				$this->obj = & $obj;
			}
			return  $obj->enable;
	}

	public function fetch($cachename) {
		$data = $this->fetch_all($cachename);
		return isset($data[$cachename]) ? $data[$cachename] : false;
	}

	public function fetch_all($cachenames,$lv) {
		global $_G;

		$data = array();
		if($lv>1 && !$cachenames){
			$cachenames = $_G[_config][cache_list];
		}

		if(defined('DEBUG')){
			$name = $this->obj->name;
			if(in_array($name,array('memcache','baichuan'))){
					$_G['memory_debug']['get'] = array();
					if(is_array($cachenames)){
						$_G['memory_debug']['get'] = $cachenames;
					}else{
						$_G['memory_debug']['get'][] = $key;
					}
			}
		}

		$data = $this->obj->get($cachenames);
		if($data === false || $data === NULL ){
			$this->update($cachenames);
		}

		if (is_array($cachenames)){
			foreach($data as $k=>$v){
				if($v === false){
					$data[$k] = $this->update($k);
				}
			}
		}
		return $data;
	}

	public function set($cachename, $data,$update,$lv=0) {
				global $_G;
				if(!$cachename) return false;
				$this->obj->set($cachename,$data);
	}
	public function delete($cachename){
		if(!$cachename) return false;
		$this->obj->delete($cachename);
		$cachename = (array)$cachename;
	}

	public function update($cachename) {
		global $_G;

		$sys = true;			//$syn = false,代表不写入缓存,每次都读取
		if(strpos($cachename,'_cate') !==false){
			$tmp = explode('_',$cachename);
			$cate = new cate($tmp[0],$tmp[0]);
			$cache_data = $cate->get_cate();
			$this->set($cachename,$cache_data,true,1);
			return $cache_data;
		}


		switch($cachename){
			case 'all_channel':
					$all_channel = DB::fetch_all("SELECT * FROM ".DB::table('channel')." ORDER BY `sort` DESC,fid ASC ",'fid');
									$tmp  = array();
									foreach($all_channel as $k=>$v){
										$v[org_url] = $v[url];
										$v[url] = 'index.php?fid='.$v[fid];
										$tmp['k'.$k]	 = $v;
									}
									$cache_data  = $tmp;
			break;
			case 'channels':
						$all_channel = DB::fetch_all("SELECT * FROM ".DB::table('channel')." ORDER BY `sort` DESC,fid ASC ",'fid');

									$channel = array();
									//一级
									foreach($all_channel as $k=>$v){
										if($v[fup] ==0) {

											//$v[count] = getcount('goods'," AND fid = ".$v[fid]);
											$v[org_url] = $v[url];
											$v[url] = 'index.php?fid='.$v[fid];
											$channel[$k] = $v;
										}
									}
									//二级

									$tmps = $all_channel;
									foreach($channel as $k=>$v){
													$sub = array();
													$fid_in = array();
													unset($tmps[$v[fid]]);
													foreach($all_channel as $kk=>$vv){
														if($vv['fup'] == $k){
															//$vv[count] = getcount('goods'," AND fid = ".$vv[fid]);

															$vv[org_url] = $vv[url];
															$vv[url] = 'index.php?fid='.$vv[fid];

															$sub[$kk]  = $vv;	//二级栏目
															$fid_in2 = array();
															unset($tmps[$vv[fid]]);
															foreach($all_channel as $k3=>$v3){
																		if($v3['fup'] == $kk){
																			$v3[org_url] = $v3[url];

																			$v3[url] = 'index.php?fid='.$v3[fid];
																			//$v3[count] = getcount('goods'," AND fid = ".$v3[fid]);
																			unset($tmps[$v3[fid]]);
																			$sub[$kk]['sub'][$k3] = $v3;	//三级栏目
																			$fid_in2[] = $v3['fid'];
																			$fid_in[] = $v3['fid'];
																			$sub[$kk]['sub'][$k3]['fid_in'] =$v3['fid'];
																		}
															}
															$fid_in[] = $vv['fid'];
															$fid_in2[] = $vv['fid'];
															$sub[$kk]['fid_in'] = implode(',',$fid_in2);
														}
													}
									$fid_in[] = $v['fid'];
									$channel[$k]['fid_in'] =implode(',',$fid_in);
									if($sub)$channel[$k]['sub'] = $sub;
								}
								if(count($tmps)>0){
									foreach($tmps as $k=>$v){
										if(!array_key_exists($k)){
											$v[fid_in] =$v[fid];
											$channel[$k] = $v;
										}
									}

								}
								$cache_data = $channel;
			break;
			case 'setting':

									set_setting('time',TIMESTAMP);
									$st  = DB::fetch_all("SELECT * FROM ".DB::table('setting'));
										foreach($st as $k=>$v){
											$setting[$v['name']] = $v['value'];
									}

									if($setting['qq']){
										$setting['qq'] = explode(',',$setting['qq']);
									}

									if($setting['flag']){
											$setting['flag'] = explode(',',$setting['flag']);
											$setting['flag']  = array_filter($setting['flag'] );
									}
									if($setting['shop_tag']){
											$setting['shop_tag'] = explode(',',$setting['shop_tag']);
											$setting['shop_tag']  = array_filter($setting['shop_tag'] );
									}
									if($setting['goods_tag']){
											$setting['goods_tag'] = explode(',',$setting['goods_tag']);
											$setting['goods_tag']  = array_filter($setting['goods_tag'] );
									}
									if($setting['article_tag']){
											$setting['article_tag'] = explode(',',$setting['article_tag']);
											$setting['article_tag']  = array_filter($setting['article_tag'] );
									}


									if($setting['filter_field']) $setting['filter_field']  = explode(',',$setting['filter_field']);

									if($setting['duihuan_status']) $setting['duihuan_status']  = explode(',',$setting['duihuan_status']);

									if($setting['activity_tags']) $setting['activity_tags']  = explode(',',$setting['activity_tags']);


									if($setting['movie_tags']) $setting['movie_tags']  = explode(',',$setting['movie_tags']);
									if($setting['zj_tags']) $setting['zj_tags']  = explode(',',$setting['zj_tags']);

									if($setting['shishang_flag']) $setting['shishang_flag']  = explode(',',$setting['shishang_flag']);

									if($setting['tags']){
											$setting['tags'] = explode(',',$setting['tags']);
											$tags = array();
											foreach($setting['tags'] as $k=>$v){
												$uname = urlencode_utf8($v);
												$tags[$uname] = $v;
											}
											$setting['tags'] =$tags;
									}
									if($setting['sign_jf']) $setting['sign_jf'] = (array)dunserialize($setting['sign_jf']);

									if($setting['sign_tb']) $setting['sign_tb'] = (array)dunserialize($setting['sign_tb']);
									if($setting['syn_table']) $setting['syn_table'] =  explode(',',$setting['syn_table']);
									if($setting['syn_domain']) $setting['syn_domain'] =  explode("\r\n",$setting['syn_domain']);

									if($setting['uz_tag']) $setting['uz_tag'] =  explode(',',$setting['uz_tag']);
									if($setting['uz_type']) $setting['uz_type'] = explode(',',$setting['uz_type']);
									$setting['time'] = TIMESTAMP;
									if($setting['email'])$setting['email'] = (array)dunserialize($setting['email']);
									if($setting['dataoke_cate'])$setting['dataoke_cate'] = (array)dunserialize($setting['dataoke_cate']);



									$cache_data =$setting;

			break;

			case 'friend_link':
									//友情链接
									$friend_link = DB::fetch_all("SELECT * FROM ".DB::table('friend_link')." ORDER BY sort DESC,id DESC",'id');

									$cache_data =$friend_link;

			break;

			case 'pics_type':
									$cache_data = DB::fetch_all("SELECT * FROM ".DB::table('pics_type')." ORDER BY id DESC",'id');
			break;
			case 'pics':
								$pics_type = DB::fetch_all("SELECT * FROM ".DB::table('pics_type')." ORDER BY id DESC",'id');
								$pics_tmp = DB::fetch_all("SELECT * FROM ".DB::table('pics')." ORDER BY sort ASC,id DESC ",'id');
								$pics = array();
								foreach($pics_type as $k=>$v){
										$pics[$k]  = array();
										foreach($pics_tmp as $k1=>$v1){
											if($v1['fup'] == $k) $pics[$k][$k1] = $v1;
										}
								}
							$cache_data=set_key($pics);

			break;
			case 'brand':

									$cache_data = DB::fetch_all("SELECT * FROM ".DB::table('brand')." ORDER BY sort desc ,id DESC",'id');
									$filter = $_G['setting']['goods_filter'];
									if(!$filter) $filter = 1;
									$and =" AND status in ( ".$filter." )";
									foreach($cache_data as $k=>$v){
										$cache_data[$k]['count'] = getcount('goods','brand_id='.$v['id']. $and);
									}

			break;
			case 'ad':
						$ad  = DB::fetch_all("SELECT * FROM ".DB::table('ad')." ORDER BY id DESC ",'id');
						foreach($ad as $k=>$v){

							$ad[$k]['show'] = 	false;
							$ad[$k]['show_html'] = '';
							//先判断是否在显示时间内

							$show = 0;
							if($v['start_time'] < TIMESTAMP && ($v['end_time']==0 || $v['end_time'] > TIMESTAMP)){
								$show = 1;
							}


							if($show ==true && $v['hide'] == 0){
								$html = '';
								if($v['type'] ==1){
									$html = $v['content'];
								}elseif($v['type'] ==2){
									$width = $v['width']>0 		? 	"width='".$v['width']."'" 		: '';
									$height = $v['height'] > 0		 ? 	"height='".$v['height']."'" 	: '';
									$img = "<img class='system_ad_".$k."' src='".$v['picurl']."' ".$width."".$height." />";
									if($v['url']){
										$target = $v['target'] == 1 ? "target='_blank'" : '';
										$html = "<a href='".$v['url']."' ".$target." >".$img."</a>";
									}else{
										$html =$img;
									}
								}else{
									$html = $v['html'];
								}
								if(!empty($html)) {
									$ad[$k]['show'] = 	true;
									$ad[$k]['show_html'] = $html;
								}else{
									$ad[$k]['show_html'] = '';
								}
							}
						}
						$cache_data=set_key($ad);

			break;
			case 'goods_cate':


					$cate = new cate('goods','goods');
					$cache_data = $cate->get_cate();

			break;
		case 'shop':

						$shop =DB::fetch_all("SELECT * FROM ".DB::table('shop')." ORDER BY sort DESC,id DESC",'id');
						foreach( $shop as $k=>$v){
							$shop[$k] =  parse('shop',$v);
						}
						$cache_data = $shop;

		break;

		case 'shop_cate':
						$cate = new cate('shop','shop');
						$cache_data = $cate->get_cate();
		break;


		case 'table':
					$cache_data = update_table();
		break;
		case 'group':

					$rs =DB::fetch_all("SELECT * FROM ".DB::table('group')." ORDER BY id ASC",'id');
					foreach($rs as $k=>$v){
						$rs[$k][power] =dunserialize($v['power']);
					}
					$cache_data = $rs;
		break;

		case 'nav':

					$cache_data =DB::fetch_all("SELECT * FROM ".DB::table('nav')." ORDER BY `sort` DESC",'id');
		break;


		default:
			$sys = false;
			$cache_data = '';
		break;

		}

		if($sys == true) 	$this->set($cachename,$cache_data,true,1);
		return $cache_data;
	}




}

?>
