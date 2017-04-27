<?php
if(!defined('IN_ADMIN')) exit('Access Denied');

class goods extends app{

		function search(){
					global $_G;
					if($_GET['onsubmit'] && check()){
						$this->main();
						return false;
					}
					$this->show();
		}
		function setting(){
			global $_G;
			if($_GET['onsubmit'] && check()){
				$arr =implode(',',$_GET['goods_filter']);
				insert_setting('goods_filter',$arr);
			}
	
			parent::seo_setting();
		}


		function quan_setting(){
			global $_G;

			//$dataoke = array(1=>'服装',2=>'母婴',3=>'化妆品',4=>'居家',5=>'鞋包配饰',6=>'美食',7=>'文体车品',8=>'数码家电');
			$dataoke = array(1=>'女装',2=>'母婴',3=>'化妆品',4=>'居家',5=>'鞋包配饰',6=>'美食',7=>'文体车品',8=>'数码家电',9=>'男装',10=>'内衣');
			$this->add(array('dataoke'=>$dataoke));

			if($_GET['onsubmit'] && check()){
				$arr =serialize($_GET['web_cate']);
				insert_setting('dataoke_cate',$arr);
			}
			//dump($_G['setting']['dataoke_cate']);
			parent::seo_setting();
		}

		function goods_check(){
			global $_G;

			if($_GET['onsubmit'] && check()){
				$goods_check = array();
				foreach($_GET['check_list'] as $k=>$v){
					if($v ==1)$goods_check[]=$k;
				}

				$arr =implode(',',$goods_check);
				insert_setting('goods_check',$arr);

				$arr =implode(',',$_GET['goods_filter']);
				insert_setting('goods_filter',$arr);

			}

			parent::seo_setting();
		}

		function goods_check_start(){
			top('check','check_all',true);
			msg('全部更新完毕');
		}



		function main(){
				global $_G;


				if($_GET['onsubmit'] && check()  && $_GET[ids]){
					$page = $_G['page']>1 ? '&page='.$_G['page'] : '';

					foreach($_GET[ids] as $k=>$v){
								if($_GET[del][$k] ==0) continue;
								$aid = intval($v);
								$arr =array();
								$arr['start_time'] = dmktime($_GET['start_time'][$k]);
								$arr['end_time'] = dmktime($_GET['end_time'][$k]);
								$arr['sort'] =	intval($_GET['sort'][$k]);
								$arr['flag'] =	intval($_GET['flags'][$k]);

								if(	$_GET['cate'][$k] > 0) $arr['cate'] = intval($_GET['cate'][$k]);
								if(	$_GET['fids'][$k] > 0) $arr['fid'] = intval($_GET['fids'][$k]);


								if($_GET['cate_in'] != '-1') $arr['cate'] =	intval($_GET['cate_in']);
								if($_GET['flag_in']  != '-1' ) $arr['flag'] 	=	intval($_GET['flag_in']);
								if($_GET['status_in']  != '-1' ) $arr['status'] 	=	intval($_GET['status_in']);

								if($_GET['in_fid']) $arr['fid'] = intval($_GET['in_fid']);

								if($_GET['start_time_in'] && dmktime($_GET['start_time_in'])>0){
									$arr['start_time'] = dmktime($_GET['start_time_in']);
								}
								if($_GET['end_time_in'] && dmktime($_GET['end_time_in'])>0){
									$arr['end_time'] = dmktime($_GET['end_time_in']);
								}
								$num_iid = $_GET['num_iid'][$k];

								if($_GET['_del_all']==1 && $_GET['del'][$k]){
									api_post(array('a'=>'delete','table'=>'goods','id'=>$num_iid,'pre_key'=>'num_iid'));
									DB::delete("goods","aid=".intval($aid));
								}else{
									api_post(array('a'=>'update','table'=>'goods','data'=>$arr,'pre_key'=>'num_iid','id'=>$num_iid));
									DB::update("goods",$arr,"aid=".$aid);
								}
								$num_iid = $_GET['num_iid'][$k];
								if($num_iid) memory('remove', 'goods_'.$num_iid);
					}
					$url = '';
					if(($_GET['post']) ==1) $url .= "&post=1";
					$page .= $_GET[cur_fid]>0 ? '&fid='.$_GET[cur_fid] : '';
					cpmsg('操作成功','success');
					return false;
				}



				if($_GET[search]==1 && $_GET['keyword'] && $_GET[search_type]){
					$keyword = trim($_GET['keyword']);
					$search_type =trim($_GET['search_type']);
					$and.=" AND `". $search_type."` LIKE '%".$keyword."%'";
					$url.="&search=1&keyword=".urlencode_utf8($keyword).'&search_type='.$search_type;
				}

				if(isset($_GET['fid']) && $_GET['fid']>0){
					$fid = intval($_GET['fid']);
					$and .=  " AND fid = $fid ";
					$url .= "&fid=".$fid;
				}

				if(isset($_GET['flag']) && $_GET['flag']!='-1'){
					$flag = intval($_GET['flag']);
					$and .=  " AND `flag` =".$flag;
					$url .= "&flag=".$flag;
				}
				if($_GET[cate]>0){
					$cate = intval($_GET[cate]);
					$and .=  " AND `cate` =".$cate;
					$url .= "&cate=".$cate;
				}
				if($_GET[nick]){
					$nick = urldecode_utf8($_GET[nick]);
					$and .=  " AND `nick` ='$nick'";
					$url .= "&nick=".$nick;
				}

				if(isset($_GET[shop_type])  && $_GET['shop_type']!='-1'){
					$shop_type = intval($_GET[shop_type]);
					$and .=  " AND `shop_type` =".$shop_type;
					$url .= "&shop_type=".$shop_type;
				}


				
				if(isset($_GET[status])){
					$status = intval($_GET[status]);
					$and .=  " AND `status` =".$status;
					$url .= "&status=".$status;
				}

				if(isset($_GET['brand_id'])){
					$brand_id = intval($_GET[brand_id]);
					$and .=  " AND `brand_id` =".$brand_id;
					$url .= "&brand_id=".$brand_id;
				}

				
				if($_GET[display]>0){
					$time = TIMESTAMP;
					$display = intval($_GET[display]);
					$and .=  " AND   (start_time>0  AND start_time> $time )  OR (end_time>0  AND end_time< $time ) ";
					$url .= "&display=".$display;
				}


				if($_GET['commission_down']){
					$commission_down = intval($_GET[commission_down]);
					$and .= " AND bili >=".$commission_down;
					$url.="&commission_down=".$commission_down;
				}
				if($_GET['commission_up']){
					$commission_up = intval($_GET[commission_up]);
					$and .= " AND bili <=".$commission_up;
					$url.="&commission_up=".$commission_up;

				}

				if($_GET['yh_price_down']){
					$yh_price_down = intval($_GET[yh_price_down]);
					$and .= " AND yh_price >=".$yh_price_down;
					$url.="&yh_price_down=".$yh_price_down;
				}
				if($_GET['yh_price_up']){
					$yh_price_up = intval($_GET[yh_price_up]);
					$and .= " AND yh_price <=".$yh_price_up;
					$url.="&yh_price_up=".$yh_price_up;
				}

				if(isset($_GET['juan'])){
					if($_GET['juan'] ==1 ){
						$and .= " AND juan_url !='' ";
					}else{
						$and .= " AND  juan_url =''  ";
					}	
					$url.="&juan=".$_GET['juan'];
				}

				if($_G['setting']['goods_sort'] == 1){
					$order = ' `sort` DESC ';
				}else{
					$order = ' aid DESC ';
				}



				$rs = D(array('and'=>$and,'all'=>true,'order'=>$order),array('url'=>URL."m=goods&a=main".$url,'size'=>40));
				foreach($rs['goods'] as $k=>$v){
						$rs['goods'][$k][title] = cutstr($v[title],'60','');
				}

				$rs['url']=URL."m=goods&a=main".$url.'&page='.$_G['page'];

				// $status_goods = array();
				// foreach($_G['setting']['goods_status'] as $k=>$v){
				// 	$count = getcount("goods",'status='.$k);
				// 	$status_goods[] = array('name'=>$v,'key'=>$k,'count'=>$count);
				// }
				// $this->add(array('status_goods'=>$status_goods));

				$this->add($rs);
				
				$this->show('goods/main');
		}

		function apply(){
				global $_G;
				$and = ' AND `post` > 0';
				$url = '';

				if(isset($_GET['check'])){
					$check = intval($_GET['check']);
					$and .=  " AND `check` =".$check;
					$url .= "&check=".$check;
				}

				$rs = D(array('and'=>$and,'all'=>true),array('url'=>URL."m=goods&a=apply".$url,'size'=>40));
				$this->add($rs);
				$this->show();

		}

		function bat(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
					if(!$_GET['postdb']['ids'])msg('您必须填入淘宝商品ID才能继续操作');

					$iids = trim($_GET['postdb']['ids']);
					$iids = explode(',',$iids);
					if(count($iids) == 0) msg('淘宝商品id不能为空');

					$arr = array();

					if($_GET['flag_check'] ==1 )$arr['flag'] = intval($_GET['postdb']['flag']);
					if($_GET['cate_check'] ==1 )$arr['cate'] = intval($_GET['postdb']['cate']);
					if($_GET['start_time_check'] ==1 )$arr['start_time'] = dmktime($_GET['postdb']['start_time']);
					if($_GET['end_time_check'] ==1 )$arr['end_time'] = dmktime($_GET['postdb']['end_time']);
				if($_GET['fid_check'] ==1 )$arr['fid'] = intval($_GET['postdb']['fid']);

					$del = 0;
					$update = 0;
					foreach($iids as $k=>$v){
						if($_GET['del_check'] ==1 ){
							$r = DB::delete('goods',"num_iid=".$v);
							if($r>0)$del++;
						}else{
							$r = DB::update('goods',$arr,"num_iid=".$v);
							if($r>0)$update++;
						}
					}
					$not_exists = count($iids) - $del - $update;
					msg('共提交'.count($iids).'个商品id,已删除'.$del.'条商品,更新'.$update.'条商品,'.$not_exists.'条商品操作失败或不存在','success');
			}



			$this->show();
		}

		function post(){
				global $_G;



				$goods =get_filed(__CLASS__);
				$page = $_G['page']>1 ? '&page='.$_G['page'] : '';
				$field = array();


				if($_GET['onsubmit'] && check() ){		//发布商品
						$arr = array();
						$arr = get_filed(__CLASS__,$_GET['postdb'],$_GET['aid']);

						$arr['images']  = $_GET['images'];

						$aid = '';
						$url = '&fid='.$arr['fid'];
						$msg = '发布';

						if($_FILES[file]){
								$src = upload();
								if($src)	$arr[picurl] = $src;
						}

						if($_GET['aid']) {
							 $aid = intval($_GET['aid']);
							 $url = '&aid='.$aid;
							 $msg = '修改';
							 $id=top('goods','update',$arr,$aid);

							 if($arr['num_iid']) memory('remove', 'goods_'.$arr['num_iid']);
						}else{

							$id=top('goods','insert',$arr);
							$url.='&aid='.$id;
						}

						if(CURMODULE == 'goods'){
								$ext = "<p><a href='".URL."m=goods&a=post&fid=".$arr['fid'].$page."'>继续发布</a>&nbsp;&nbsp;&nbsp;&nbsp;";
								$ext.="<a href='".URL."m=goods&a=main".$page."'>返回列表页</a>&nbsp;&nbsp;&nbsp;&nbsp;";
								$ext.="<a href='".URL."m=goods&a=main&fid=".$arr[fid].$page."'>返回栏目列表页</a>";
						}elseif(CURMODULE == 'apply'){
							$ext.="<a href='".URL."m=apply&a=main".$page."'>返回待审核列表</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						$ext.="</p>";

						if($id ===false){
							  cpmsg('发布失败,不能重复发布同一商品','error','m='.__CLASS__.'&a='.__FUNCTION__.'&fid='.$_G[fid]);
						}else{
							cpmsg($msg.'成功','success','m='.CURMODULE.'&a='.__FUNCTION__.$url,'编辑此商品',$ext);
						}
						return false;

				}elseif($_GET['get_submit']&& check() && $_GET['goods_id']){

						//提交ID采集商品
					 $goods_id =get_goods_id($_GET['goods_id']);

					  if(!$goods_id) {
						  cpmsg('抓取失败,商品ID或链接不存在或填写错误','error','m='.__CLASS__.'&a='.__FUNCTION__);
						  return false;
					  }
					  if($_GET['goods_aid'] >0) $goods = D(array('and'=>" AND aid = ".intval($_GET['goods_aid']),'limit'=>1,'all'=>true));

					  $gd = top('goods','get_goods',$goods_id);

					  $gd[goods_id] = $goods_id;
					    list($tomorrow2,$tomorrow5) = $this->get_start_time();
						$goods['keywords'] = get_keywords($goods['title']);

					  if($gd['yh_price'] != $gd['price'] && $gd['yh_price'] && $gd['price']){
						  $gd[zhekou_shu] =sprintf("%.1f",$gd['yh_price']/$gd['price'] * 10);
					  }
					  foreach($gd as $k=>$v){
						  $goods[$k] = $v;
					  }


					  if((!$goods[yh_price])) echo '<h1 class="admin_msg">商品优惠价格采集失败,请注意手动填写</h1>';
				}elseif($_GET['aid']){
							$aid	= 	intval($_GET['aid']);
							$gd = D(array('and'=>" AND aid = ".$aid,'limit'=>1,'all'=>true));
							if(!$gd[aid]){
								 cpmsg('抱歉,未找到任何信息','error');
								 return false;
							}

							$_GET['goods_id']=$gd['num_iid'];

							foreach($gd as $k=>$v){
						  		$goods[$k] = $v;
					  		}

							if($_G['setting']['get_message']&& !$goods['message'] ){
								 $message = top('m_taobao','get_message',$goods[num_iid]);
								if($message)		$goods['message']	  = $message;
							}

							if( strpos($goods['url'],'a=go_pay') !== false ||  strpos($goods['url'],'itemid=') !== false ||  strpos($goods['url'],'item.htm') !== false){
								$goods['url'] = '';
							}





				}else{
					$_GET[goods_id] = '';
					$goods =get_filed(__CLASS__);

					  if($_G['setting']['start_day']>0|| $_G['setting']['end_day']>0){
						  list($tomorrow2,$tomorrow5) = $this->get_start_time();
						  if($_G['setting']['start_day']>0)$goods['start_time'] = $tomorrow2;
						   if($_G['setting']['end_day']>0)$goods['end_time'] = $tomorrow5;
					  }
				}


				//品牌搜索
				$band_list = DB::fetch_all("SELECT name,id FROM ".DB::table('brand'). " ORDER BY id DESC");
				$band_list = json_encode($band_list);
				$this->add(array('goods'=>$goods,'field'=>$field,'bm_status_text'=>$bm_status_text,'band_list'=>$band_list));


				$tpl = '';
				if(!$_GET[fid] && !$_GET['aid'])$tpl = "goods/select_post";
				$this->show($tpl);
		}

		function get_start_time(){
					global $_G;
					 $st = intval( 86400* $_G['setting']['start_day']);
					 $ed = intval( 86400* $_G['setting']['end_day']);
					 if(!$ed)$ed=5;
					 $ho = intval($_G['setting']['start_hour']);
					 $tomorrow2= dmktime(dgmdate(TIMESTAMP+$st,'d') .' '.$ho.':00');
					 $tomorrow5= dmktime(dgmdate(TIMESTAMP+$st+$ed,'d') .' '.$ho.':00');
					 return array($tomorrow2,$tomorrow5);
		}


		function del(){
					global $_G;
					$page = $_G['page']>1 ? '&page='.$_G['page'] : '';
					if(!$_GET['aid']) {
						msg('抱歉,要删除的栏目ID不存在','error',"m=channel&a=main".$page);
						return false;
					}
					$aid = intval($_GET['aid']);

					if(!$_GET['ok']){
						msg('您确定要删除当前商品信息吗?删除后不可恢复?','error',"m=goods&a=del&ok=1&aid=".$aid.$page,'确定删除',"<p><a href='".URL."m=goods&a=main".$page."'>取消</a></p>");
						return false;
					}else{
						$num_iid = DB::result_first("SELECT num_iid FROM ".DB::table('goods')." WHERE aid = ".$aid);
						api_post(array('a'=>'delete','table'=>'goods','id'=>$num_iid,'pre_key'=>'num_iid'));

						DB::delete("goods","aid=".$aid);
						msg('删除成功','error','m=goods&a=main');
						return false;
					}
		}

		function cate_add(){
					global $_G;

					if($_GET['onsubmit'] && check() ){
						$cate = get_filed('cate',$_GET['postdb'],$_GET['id']);
						$cate['page'] = $cate['page'] ? intval($cate['page']) : 20;
						$url = '';
						if($_FILES[file]){
								$pic= upload();
								if($pic)$cate[picurl]  = $pic;
						}

						if($_GET['id']){
							$id = intval($_GET['id']);
							$r =DB::update('cate',$cate,"id=".$id);
							if($r>0)api_post(array('a'=>'update','table'=>'cate','data'=>$cate,'pre_key'=>'id','id'=>$id,'cache'=>'cate'));
							$url = '&id='.$id;
							$msg = '修改';
						}else{
							$msg = '添加';
							$cate['dateline'] = TIMESTAMP;

							$r = DB::insert('cate',$cate,true);
							if($r>0) api_post(array('a'=>'insert','table'=>'cate','data'=>$cate,'cache'=>'cate','id'=>$r));
						}
						loadcache("cate",'update');
						cpmsg($msg.'分类成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
						return false;
					}elseif($_GET['id']) {
						$id = intval($_GET['id']);
						$cate = $_G['cate'][$id];
					}else{
						$cate = get_filed('cate');
					}

					$this->add(array('cate'=>$cate));
					$this->show();
		}

	function update(){
		global $_G;
		$success = 0;
		$type = $_G['setting']['api_type'];
		if(!$_GET[num_iid]) msg('商品num_iid不存在');

		//1,用淘宝客权限的API来获取,只能获取部分字段,一次最多10条,只能用open_iid
		//2,用百川高级商品权限,获取字段较多较完整,可返回open_iid,num_iid,url . 一次最多50条, 可用num_iid,open_iid	(推荐)
		//3,远程抓取,一般外站来用

		//0=阿里妈妈淘客	1 = 百川淘宝客

		if($type == 1){
			$rs = top('baichuan','get_goods',$_GET[num_iid]);

			if(!$rs){
				msg('更新失败'+$_G['msg']);
			}
			if($rs['num_iid']) $rs = array($rs);
			foreach($rs as $k=>$v){
				if(!$v['num_iid']) continue;
				$id = $v['num_iid'];

				$v['dateline'] = TIMESTAMP;

				if(isset($v['open_iid']))unset($v['open_iid']);
				$len = DB::update('goods',$v,"num_iid='$id'");
				if($len>0) $success++;
			}
		}else if($type == 0){
			msg('更新商品需要百川接口才能更新'.$_G['msg']);


			$tmp = explode(',',trim($_GET[num_iid]));
			$arr = array();
			foreach($tmp as $k=>$v){
				$arr[$v.''] = array('num_iid'=>$v);
			}

			//$rs = top('tbk','get',$arr);
			$rs = top('tbk','get_info',$arr);

			foreach($rs as $k=>$v){
				$id = $v['num_iid'];
				$v['dateline'] = TIMESTAMP;
				if(is_array($v['images'])) $v['images'] = implode(',',$v['images']);

				if(isset($v['open_iid']))unset($v['open_iid']);

				$len = DB::update('goods',$v,"num_iid='$id'");

				if($len>0) $success++;
			}
		}else{
			$tmp = explode(',',trim($_GET[num_iid]));
			$ids = array();
			$m = top('m_taobao');
			foreach($tmp as $k=>$v){
				$v = get_goods_id($v);
				$len = $m->get($v,true);
				if($len>0) $success++;
			}

		}
		json(array('status'=>'success','len'=>$success,'data'=>''));

	}



	function link(){
			global $_G;

			if($_GET['onsubmit']){

				$goods = json_decode($_GET['goods_list'],true);
				if(!$goods)msg('转换链接失败');
				$count = 0;

				foreach($goods as $k=>$v){
					foreach($v as $k1=>$v1){
						$key = str_replace('k','',$k1);
						if($v1){
							$count ++;
							DB::update('goods',array('url'=>$v1),"num_iid='$key'");
						}
					}

				}
				msg('转换成功'.$count.'条链接');

			}

			$goods = DB::fetch_all("SELECT num_iid FROM ".DB::table('goods')." WHERE url='' or url like '%item.htm?id=%' LIMIT 300 ");
			$rs['count'] = count($goods);

				$data = array();
				foreach($goods as $k=>$v){
					$data[] = $v['num_iid'];
				}
				$rs['goods']  = implode($data,',');
				$this->add($rs);
				$this->show();


	}

	function parse_12($v){
				$arr              = array();
				$arr['num_iid']   = $v[0];
				$arr['title']     = $v[1];
				$arr['picurl']    = $v[2];
				$arr['yh_price']  = $v[5];
				$arr['sum']       = $v[6];
				$arr['dateline']  = TIMESTAMP;

				$arr['bili']      = $v[7];
				$arr['nick']      = $v[9];
				$arr['url']       = $v[10];
				return $arr;
	}

	function parse_17($v){
		
				$arr              = array();
				$arr['num_iid']   = $v[0];
				$arr['title']     = $v[1];
				$arr['picurl']    = $v[2];
				$arr['yh_price']  = $v[5];
				$arr['sum']       = $v[6];
				$arr['dateline']  = TIMESTAMP;

				$arr['bili']      = $v[10] ?  $v[10] : $v[7];
				$arr['nick']      = $v[14];
				$arr['url']       = $v[15];
				if($v[12] && $v[12] != '1970-01-01 08:00:00'){
					$arr['start_time']       = dmktime($v[12]);
				}
				if($v[13] && $v[13] != '1970-01-01 08:00:00'){
					$arr['end_time']       = dmktime($v[13]);
				}
		return $arr;
	}

	function parse_18($v){
		return $this->parse_17($v);

	}

	function parse_19($v){
		$arr =  $this->parse_12($v);
		$arr['tkl'] = $v[11];
				if($v[12]>0 && $v[13]>0){
					$arr['quan_sum'] = $v[12];
					$arr['quan_num'] = $v[13];
					preg_match("/满([\d\.]{1,6})元减([\d\.]{1,6})元/is",$v[14],$tmp);

					if($tmp && $tmp[2]){
						$arr['juan_price']    = $tmp[2];
					}else if(!$tmp && strpos($v[14],'元无条件券') !== false){
						$arr['juan_price']    = str_replace('元无条件券','',$v[14]);
					}

					//防止无条件券,价格为负数
					if($arr['yh_price'] - $arr['juan_price'] <0) continue;
										
					$arr['juan_url'] = $v[17];
					$arr['start_time'] = dmktime($v[15]);
					$arr['end_time'] = dmktime($v[16]);
					$arr['tkl'] = $v[18];
				}
				return $arr;
	}

	function parse_20($v){
				$arr = $this->parse_12($v);
				$arr['tkl'] = $v[12];
				if($v[13]>0 && $v[14]>0){
					$arr['quan_sum'] = $v[13];
					$arr['quan_num'] = $v[14];
					preg_match("/满([\d\.]{1,6})元减([\d\.]{1,6})元/is",$v[15],$tmp);
					if($tmp && $tmp[2]){
						$arr['juan_price']    = $tmp[2];
					}else if(!$tmp && strpos($v[15],'元无条件券') !== false){
						$arr['juan_price']    = str_replace('元无条件券','',$v[15]);
					}
					//防止无条件券,价格为负数
					if($arr['yh_price'] - $arr['juan_price'] <0) continue;

					$arr['juan_url'] = $v[18];
					$arr['start_time'] = dmktime($v[16]);
					$arr['end_time'] = dmktime($v[17]);
					$arr['tkl'] = $v[19];
				}
		
		return $arr;
	}

	function parse_21($v){
		return $this->parse_20($v);
	}

	function parse_22($v){
		return $this->parse_20($v);
	}
	
	function parse_25($v){
				$arr              = array();
				$arr['num_iid']   = $v[0];
				$arr['title']     = $v[1];
				$arr['picurl']    = $v[2];
				$arr['yh_price']  = $v[5];
				$arr['sum']       = $v[6];
				$arr['dateline']  = TIMESTAMP;
				if($v[9] =='推广中'){
					$arr['bili']      = $v[10];
					$arr['start_time'] = dmktime($v[12]);
					$arr['end_time'] = dmktime($v[13]);
				}else{
					$arr['bili']      = $v[7];
				}
				
				$arr['nick']      = $v[14];
				$arr['url']       = $v[15];
				$arr['tkl'] = $v[17];

				if($v[18]>0 && $v[19]>0){
						$arr['quan_sum'] = $v[18];
						$arr['quan_num'] = $v[19];
						preg_match("/满([\d\.]{1,6})元减([\d\.]{1,6})元/is",$v[20],$tmp);

						if($tmp && $tmp[2]){
							$arr['juan_price']    = $tmp[2];
						}else if(!$tmp && strpos($v[20],'元无条件券') !== false){
							$arr['juan_price']    = str_replace('元无条件券','',$v[20]);
						}

						//防止无条件券,价格为负数
						if($arr['yh_price'] - $arr['juan_price'] <0) continue;

						$arr['juan_url'] = $v[23];
						$arr['start_time'] = dmktime($v[21]);
						$arr['end_time'] = dmktime($v[22]);
						$arr['tkl'] = $v[24];
				}

				return $arr;
	}

	function parse_26($v){
		return $this->parse_25($v);
	}

	function import(){
			global $_G;
			if($_GET['onsubmit'] ){
							if(!$_FILES['file'])cpmsg('抱歉,您必须提交一个excel文件才能进行批量导入','error');
							$src = upload('','web');

							if(!$src)	cpmsg('抱歉,文件上传失败','error');
							$data = load_excel($src,true,true);

							$postdb = $_GET['postdb'];
							if($postdb['start_time']) $postdb['start_time'] = dmktime($postdb['start_time']);
							if($postdb['end_time']) $postdb['end_time'] = dmktime($postdb['end_time']);

							$all_count = count($data)-1;
							$success =0;
							if(!$data || $all_count ==0 ) msg('查找到的商品为0');

							$goods_list = array();
							$iids = array();


						
							foreach ($data as $k => $v) {
								if($k==0) continue;
								if($k==0) continue;
								$count = count($v);
								
								$md = 'parse_'.$count;

								if(method_exists($this, $md)){
									$arr = $this->$md($v);
								}else{
									msg('您所提交的excel格式字段未识别');
								}
								if(!$arr || count($arr) ==0 ) continue;

								$arr   = array_merge($postdb,$arr);
								$iid              = 'k'.$v[0];
								$goods_list[$iid] = $arr;
								$iids[]           = $v[0];

							}
							if(!$goods_list || count($goods_list) ==0 )msg('未解析出任何商品');
							//不存在以下三个字段,需要重新用api获取
							//$arr['images'] = $v[];
							//$arr['price'] = $v[];
							//$arr['shop_type'] = $v[];
							
							//0=阿里妈妈淘客	1 = 百川淘宝客
							//拆分成50/40个一组来获取
							if($_G['setting']['api_type'] ==1){

								$chunk_data = array_chunk($iids,50);
								$rs_list = array();
								foreach ($chunk_data as $key => $value) {
									$tmp_data = top('baichuan','get_goods',$value);
									$rs_list = array_merge($rs_list,$tmp_data);
								}

								foreach($rs_list as $k=>$v){
										if(!$v['num_iid']) continue;
										$id = 'k'.$v['num_iid'];
										$goods_list[$id]['price'] =  $v['price'];
										$goods_list[$id]['shop_type'] =  $v['shop_type'];
									}
							}else if($_G['setting']['api_type'] ==0){

									$chunk_data = array_chunk($iids,40);
									$rs_list = array();
									foreach ($chunk_data as $key => $value) {
										$tmp_data =  top('tbk','get_info',$value);
										$rs_list = array_merge($rs_list,$tmp_data);
									}
										foreach($rs_list as $k=>$v){
											$id                           = 'k'.$v['num_iid'];
											$goods_list[$id]['price']     =  $v['price'];
											$goods_list[$id]['shop_type'] =  $v['shop_type'];
											$goods_list[$id]['images']    = $v['images'];
										}
							}


							foreach ($goods_list as $k=> $v) {
								$id = top('goods','insert',$v);
								if($id>0) $success++;
							}
							msg('共找到'.$all_count.'条品信息,导入成功'.$success.'条','success');

				}


				$this->show();



	}

	public function update_quan(){
			global $_G;
			if ($_G['setting']['dataoke_appkey'] ) {
				$dataoke = top('dataoke');
				$dataoke->auto_update();
			}else{
				msg('未开启自动优惠券同步功能,或是大淘客appkey未设置');
			}
	}


	/**
	 * 插件高佣接口
	 * @return [type] [description]
	 */
	public function get_goods_link (){
		global $_G;
		//if($_GET['today']){
			$and = " posttime > ". (TODAY-86400) ." AND ";
		//}
		$sum = getcount('goods', $and ." (url='' or url like '%item.htm?id=%' ) ");
		$rs = DB::fetch_all("SELECT num_iid,aid FROM ".DB::table('goods')." WHERE $and (url='' or url like '%item.htm?id=%' ) ORDER BY aid DESC LIMIT 100");
		$data = array();
		foreach($rs as $k=>$v){
			if(!$v['num_iid']){
				DB::delete('goods','aid='.$v['aid']);
				continue;
			}
			$data[] = $v['num_iid'];
		}
		json(array('data'=>array('sum'=>$sum,'goods'=>$data,'pid'=>$_G['setting']['pid']),'status'=>'success'));

	}

	public function get_pid(){
		global $_G;
		json(array('data'=>array('pid'=>$_G['setting']['pid'],'key'=>$_G['setting']['syn_key']),'status'=>'success'));
	}

	public function del_goods(){
		global $_G;
		if(!$_GET['num_iid']) json('商品id不能为空');
		$num_iid = $_GET['num_iid'];

		DB::delete('goods',"num_iid = '".$num_iid."'");
		json(array('status'=>'success','msg'=>'删除成功'));

	}

	public function update_goods_link(){
			global $_G;
			if(!$_GET['data']['num_iid']) json('商品id不能为空');
			$num_iid = $_GET['data']['num_iid'];

			$arr = get_filed(__CLASS__,$_GET['data'],$num_iid);

			unset($arr['title'],$arr['picurl'],$arr['yh_price'],$arr['cid']);
			$arr['end_time'] = intval($arr['end_time']);

			$end_time = DB::result_first("SELECT end_time FROM ".DB::table('goods')." WHERE num_iid = '".$num_iid."'");
			if($end_time>0) unset($arr['end_time']);

			if(isset($arr['images']) && $arr['images'] && is_array($arr['images'])){
				$arr['images'] = array_filter($arr['images']);
				$arr['images'] = implode(',',$arr['images']);
			}

			$arr['dateline'] = TIMESTAMP;
			$r = DB::update('goods',$arr,"num_iid='".$num_iid."'");
			if($r>0){
				json(array('status'=>'success','data'=>'','msg'=>'更新成功'));
			}else{
				json('商品不存在');
			}
	}





function quan_import(){
			global $_G;
			if($_GET['onsubmit'] ){
							if(!$_FILES['file'])cpmsg('抱歉,您必须提交一个excel文件才能进行批量导入','error');
							$src = upload('','web');

							if(!$src)	cpmsg('抱歉,文件上传失败','error');
							$data = load_excel($src,true,true);

							$count = count($data)-1;
							$success =0;
							if(!$data || $count ==0 ) msg('查找到的商品为0');

							$goods_list = array();
							$iids = array();
					
							foreach ($data as $k => $v) {

								if($k==0 && $v[0] == '商品id') continue;
								$count = count($v);
									
								if($count !=22) continue;

								$arr              = array();
								$arr['num_iid']   = $v[0];
								$arr['title']     = $v[1];
								$arr['picurl']    = $v[2];
								// if($v[13] == '天猫'){
								// 	$arr['shop_type'] = 1;
								// }else{
								// 	$arr['shop_type'] = 0;
								// }
								
								$arr['yh_price']  = $v[5];
								$arr['sum']       = $v[6];
								$arr['bili']      = $v[7];
								$arr['nick']    = $v[9];
								$arr['url']    = $v[10];
								//$arr['sid']    = $v[11];

								$arr['tkl']    = $v[12];
								$arr['quan_sum']    = $v[13];
								$arr['quan_num']    = $v[14];

								preg_match("/满([\d\.]{1,6})元减([\d\.]{1,6})元/is",$v[15],$tmp);
								if($tmp && $tmp[2]){
									$arr['juan_price']    = $tmp[2];
								}else if(!$tmp && strpos($v[15],'元无条件券') !== false){
									$arr['juan_price']    = str_replace('元无条件券','',$v[15]);
								}
								//防止无条件券,价格为负数
								if($arr['yh_price'] - $arr['juan_price'] <0) continue;

								$arr['start_time']       = dmktime($v[16]);
								$arr['end_time']       = dmktime($v[17]);

								//$arr['juan_url']    = $v[21];
								// $pid = sub_str($v[18],'&pid=','&af=1');
								// $arr['juan_url']  = 'https://uland.taobao.com/coupon/edetail?activityId='.$v[14].'&itemId='.$v[0].'&pid='.$pid.'&src=kfz_utao';

								$arr['juan_url']  = $v[18].'&src=kfz_utao';
								if($v[19])$arr['tkl']    = $v[19];

								$arr['dateline']  = TIMESTAMP;
								$arr['posttime']  = TIMESTAMP;

								$id = top('goods','insert',$arr,true);
							 	if($id && $id>0) $success++;
							}
							msg('共找到'.$count.'条品信息,导入成功'.$success.'条','success');

				}


				$this->show();



	}


	function tkl(){
			global $_G;
			$count_tkl = getcount('goods'," status =1 AND tkl = '' ");
			$this->add(array('count_tkl'=>$count_tkl));

			if($_GET['onsubmit'] && check()){
				$arr =serialize($_GET['web_cate']);
				insert_setting('dataoke_cate',$arr);
			}

			parent::seo_setting();
		}

		function tkl_create(){
				global $_G;

				$text = $_G['setting']['tkl_text'];
				if(!$text) msg('淘口令详情不能为空');


				$_G['setting']['api_type']  = 0;
				$mama = top('tbk');
				// $url = 'http://uland.taobao.com/coupon/edetail?activityId=341dc0f7b0414ee18b40773c63880064&itemId=535731552007&pid=mm_13204895_7438858_59218184&src=kfz_utao';
				// $text='浪莎浪莎秋衣秋裤 薄款保暖内衣 女士性感蕾丝领美体修身内衣套装';
				// $logo = 'http://img04.taobaocdn.com/bao/uploaded/i4/TB11qqKOXXXXXaxXFXXXXXXXXXX_!!0-item_pic.jpg';
				// $kl = $mama->tkl($url,$text,$logo);
				
				$count_tkl = getcount('goods'," status =1 AND tkl = '' ");
				$rs = DB::fetch_all("SELECT juan_url,aid,title,juan_price,yh_price,title,picurl,url FROM ".DB::table('goods').
								" WHERE status =1 AND tkl = ''  ORDER by aid DESC LIMIT 5");
				if(count($rs) == 0 ) msg('所有淘口令转换完成','error','?m=goods&a=tkl');

				$success = 0 ;
				//{title},原价{yh_price}元,现领{juan_price}元优惠券,下单只需{final_price}
				foreach($rs as $k=>$v){
					$share_text = $text;
					$share_text = str_replace('{title}',$v['title'],$share_text);
					$share_text = str_replace('{yh_price}',$v['yh_price'],$share_text);
					$share_text = str_replace('{juan_price}',$v['juan_price'],$share_text);

					$final_price = intval($v['yh_price'] - $v['juan_price']);
					$share_text = str_replace('{final_price}',$final_price,$share_text);

					 $tkl = $mama->tkl($v['juan_url'],$share_text,$v['picurl']);
					 if($tkl && strpos($tkl,'￥') !== false){
					 	$r = DB::update('goods',array('tkl'=>$tkl),'aid='.$v['aid']);
					 	if($r>0) $success++;
					 }
				}

	            $rs = '共找到待生成的淘口令 '.$count_tkl.' 条,已生成 '.$success.' 条,3秒后继续生成....
							<script type="text/javascript">
							var timer = null;
							function start(){
								timer =setTimeout(function(){
									window.location.reload();
								},3000);
							};
							function stop(t){
								clearTimeout(timer);
								t.value = "已暂时,继续采集请刷新页面";
							}
							start();
							</script>;
							<input type="button" value="停止" onClick="stop(this);" style="height:24px;line-height:24px;color:#f00">';

	            echo $rs;


		}



		function get_tkl(){
				global $_G;
				$aid = intval($_GET['aid']);
				if(!$aid) json('商品id不能为空');

				$rs = get_tkl($aid);
				json($rs);
				return ;


				$goods = DB::fetch_first("SELECT aid,num_iid,url,juan_url,title,tkl FROM ".DB::table('goods')." WHERE aid =".$aid);
				
				if($goods['tkl']){
						json(array('status'=>'success','data'=>$goods['tkl'],'msg'=>'生成淘口令成功'));
				}



				if($goods['juan_url'] &&  strpos($goods['juan_url'],'shop.m.taobao.com') !== false){
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



				$url = '';
				if( $goods['juan_url'] && strpos($goods['juan_url'],'uland.taobao.com') !== false){
					$url =$goods['juan_url'];
				}else if($goods['url'] && strpos($goods['url'],'s.click.taobao.com') !== false){
						$url =$goods['url'];
				}else {
					json('当前商品没有二合一链接,并且商品链接不是淘宝官方短链,无法生成淘口令');
				}

				$mama = top('tbk');
				$url = $goods['juan_url'];
				$text=$goods['title'];
				$logo = $goods['picurl'];
				$tkl = $mama->tkl($url,$text,$logo);

				 if($tkl && strpos($tkl,'￥') !== false){
				 	DB::update('goods',array('tkl'=>$tkl),'aid='.$aid);
				 	json(array('status'=>'success','data'=>$tkl,'msg'=>'生成淘口令成功'));
				 }else{
				 	json('转换淘口令失败');
				 }

		}



		
		
		function update_goods(){
			global $_G;
			$url = '?m='.__CLASS__.'&a='.__FUNCTION__;
			$main_url = URL.'m='.__CLASS__.'&a=main';	
			
			
			$get_type = $_G['setting']['api_type'];		//1 = 百川淘宝客	0=阿里妈妈淘客

			 $size = $get_type == 1 ? 50 : 40;
			 $start = ($_G[page]-1) * $size;
			if($_GET[onsubmit]){
				$and = '';
				$url .= '&onsubmit=1&page='.($_G[page]+1).'&size='.$size;
				if($_GET['type'] == '0'){
					$filter = $_G['setting']['goods_filter'];
					if(!$filter) $filter = 1;
					$and .=" AND status in ( ".$filter." )";
				}

				$url.="&type=". intval($_GET['type']);

				if($_GET['time']>0){
					$time = TIMESTAMP - intval($_GET['time']) * 3600;					
					$and.=" AND dateline <=" .$time;
					$url.="&time=".$time;
				}

				
				$field =$_GET[field];
				
				foreach($_GET[field] as $k=>$v){
						$url.="&field[".$k."]=1" ;
				}

				$count = getcount('goods',$and);
				
				if($count == 0){
					cpmsg('未找到任何商品信息,请修改更新条件后再试...'.$msg,'success','m=goods&a=main');
					return false;
				}
				
				$page_size = intval(ceil($count/$size));
				$rs =  ('<p>共找到'.$count . '条商品,每页'.$size.'条,共'.$page_size.'页,当前正在更新'.$_G[page].'页</p>');
				$rs .=   '<p><b>本更新比较费资源,请勿关闭本页面或胡乱点击本页面....</b></p>';
				
			
				$list = DB::fetch_all("SELECT aid,num_iid,title,dateline FROM ".DB::table('goods').
						" WHERE 1 ".$and ." ORDER BY aid DESC LIMIT $start,$size",'num_iid');
				
				if($_G[page] ==1) {
					$_SESSION[update_goods][start_time]  = TIMESTAMP;
					$_SESSION[update_goods][page_size]  = $page_size;
					$_SESSION[update_goods][del_len] = 0 ;
				}
				$_SESSION[update_goods][page]=intval($_G[page]);
				$_SESSION[update_goods][url]=$url;

				if($_G[page]<$page_size){
						$rs .= '准备更新下一页....
						<script type="text/javascript">
						var timer = null;
						function start(){
							var url  = "'.$url.'"
							timer =setTimeout(function(){
							window.location.href = url;
							},5000);	
						};
						function stop(t){
							clearTimeout(timer);
							t.value = "继续更新请刷新页面";
						}
						start();
						</script>;
						<input type="button" value="停止" onClick="stop(this);" style="height:24px;line-height:24px;color:#f00">';
				}else{
					$rs .= "<p style='color:#F00;'>更新完毕,成功: ".$_SESSION[update_goods][success_len].' 条';
				}


					$iids = array();
					foreach($list as $k=>$v){
						$iids [ $v['num_iid'] ] = $v['num_iid'];
					}
				
					 $file = $get_type == 1 ? 'baichuan':'tbk';
					 $top = top($file);
			         if($get_type ==1 ){
			            $top->use_baichuan();
			        }else{
			            $top->use_taobaoke();
			        }
			        $list = $top->get_goods($iids);

  

				foreach($list as $k=>$v){

					$iid = $v['num_iid'];
					$data = array();
					foreach($field as $k1=>$v1){
						$data[$k1] = $v[$k1];						
					}
					if(!$data['sum']) unset($data['sum']);
					if(!$v['sid']) $data['sid'] = $v['sid'];
					if($v['images']) $data['images'] = implode(',',$v['images']);
					if(isset($v['shop_type'])) $data['shop_type'] = intval($v['shop_type']);


					$data[dateline] = TIMESTAMP;
					$len = DB::update('goods',$data,"num_iid='".$v['num_iid']."'");
					unset($iids[$iid]);				
					if($len) {
						//$rs.= '<p>id='.$v[num_iid].',更新成功 '.$v[title].'</p>';
						$_SESSION[update_goods][success_len] = intval($_SESSION[update_goods][success_len])+1;
					}
				}

				$del =0;
				$del_ids = '';
				foreach($iids as $k=>$v){
					DB::delete("goods","num_iid='".$v."'");
					$del ++;
					$_SESSION[update_goods][del_len] ++;
					$del_ids.= $v.',';
				}

				if($del>0){
					$rs.= '<p>num_iid='.$del_ids.'删除成功 '.$del.'条下架的商品</p>';
				}

				if($_G[page]>=$page_size){
					$msg ="更新完毕,成功: ".$_SESSION[update_goods][success_len].' 条,删除成功'.$_SESSION[update_goods][del_len].'条';
					unset($_SESSION[update_goods]);
					msg($msg,'success','m=goods&a=update_goods'); 
					return false;					
				}
				echo "<div style='font-size:18px;'>".$rs.'</div>';
				exit;
				
			}
			
			
			$field = array(
						'picurl'=>array('key'=>'picurl','name'=>'主图','check'=>0),
						'title'=>array('key'=>'title','name'=>'标题','check'=>0),
						
						'yh_price'=>array('key'=>'yh_price','name'=>'优惠价','check'=>1),
						'price'=>array('key'=>'price','name'=>'原价','check'=>1),
						'sum'=>array('key'=>'sum','name'=>'销量','check'=>1),
			);
			
			unset($_SESSION[update_goods]);
			$this->add(array('field'=>$field));
			$this->show();
			
		}



	//	new cate(分类的类型,数据表名);

		function cate(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->main();
		}
		function cate_post(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->post();
		}

		function cate_clear(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->clear();
		}
		function batpost(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->batpost();
		}
		function cate_del(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->del();
		}


}
?>
