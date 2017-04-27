<?php
define('ROOT_PATH','../');
define('CURSCRIPT','fetch');
define('FETCH',true);
$cache_list = array('setting','channels','cate','shop');
include ROOT_PATH.'inc/class/application.class.php';
application::init();
$api = new api();
$api->init();
header("Content-Type: text/json");
header("KissyIoDataType:json");
header('Content-Type: text/html; charset='.CHARSET);

class api{

	function json($arr){
					global $_G;
					if(DB::object()->curlink) DB::object()->close();
					if($_G['json_status']) return false;
					$_G['json_status']= true;
					if(!isset($arr['status'])) $arr['status'] = 'error';
					$arr[tae] = TAE ? 1 :0;
					$arr['domain'] = $_SERVER['HTTP_HOST'];
					echo json_encode($arr);
	}


	function init(){
				global $_G,$app;
				$_G[inajax] = 1;
				foreach($_GET as $k=>$v){
					if(!isset($_GET[$k])) $_GET[$k] = $v;
				}
				if(!$_G[setting][syn_key]){
					$this->json(array('msg'=>'当前站点禁止进行同步采集发布'));
					return false;
				}
				if(!isset($_GET[syn_key]) || trim($_GET[syn_key])=='' ||  $_GET[syn_key] != $_G[setting][syn_key]) {
					$this->json(array('msg'=>'站点安全同步key不正确'));
					return false;
				}

				$a = $_GET['a'];
				if(!preg_match("/^[a-z_]+$/is",$a)){
						$this->json(array('status'=>'error','msg'=>'Module String Error'));
						return false;
				}
				if(method_exists($this,$a)){
					$this->$a();
					return false;
				}else{
					$this->json(array('status'=>'error','msg'=>'Action not Found'));
					return false;
				}
	}

	protected function get_cate($name){
			global $_G;
			$cate = array();
			if(!isset($_G[$name])) return $cate;

			foreach($_G[$name] as $k=>$v){
				$tmp = array('id'=>$v[id],'name'=>$v[name],'sub'=>array());
				if($v['sub']){
					foreach($v['sub'] as $k1=>$v1){
						$tmp['sub'][]    = array('id'=>$v1[id],'name'=>$v1[name]);
					}
				}
				$cate[] = $tmp;
			}
			return $cate;
	}

	protected function get_channels(){
			global $_G;
			$channel = array();
			foreach($_G[channels] as $k=>$v){
				$tmp = array('fid'=>$v[fid],'name'=>$v[name]);
				if(isset($v[sub]) && $v[sub] && count($v[sub])>0){
					foreach($v[sub] as $k1=>$v1){
						$t1 =  array('fid'=>$v1[fid],'name'=>$v1[name]);
						if(isset($v1[sub]) && $v1[sub] && count($v1[sub])>0){
								foreach($v1[sub] as $k2=>$v2){
									$t1[sub][] = array('fid'=>$v2[fid],'name'=>$v2[name]);
								}
						}
						$tmp[sub][] = $t1;
					}
				}
				$channel[] = $tmp;
			}
			return $channel;
	}	

	function get_config(){
			global $_G;

			$data = array('channel'=>$this->get_channels(),
					'article_cate'=>$this->get_cate('article_cate'),
					'goods_cate'=>$this->get_cate('goods_cate'),
					'style_cate'=>$this->get_cate('style_cate'),
					'img_cate'=>$this->get_cate('img_cate'),
					'pid'=>$_G['setting']['pid']
				);
			$data['title'] = array('channel'=>'栏目','cate'=>'分类');

			$this->json(array('data'=>$data,'status'=>'success'));

	}


	function get_config2(){
			global $_G;

			$rt = array();
			$channel = array();
			$cate = array();

			foreach($_G[channels] as $k=>$v){
				$tmp = array('fid'=>$v[fid],'name'=>$v[name]);
				if(isset($v[sub]) && $v[sub] && count($v[sub])>0){
					foreach($v[sub] as $k1=>$v1){
						$t1 =  array('fid'=>$v1[fid],'name'=>$v1[name]);
						if(isset($v1[sub]) && $v1[sub] && count($v1[sub])>0){
								foreach($v1[sub] as $k2=>$v2){
									$t1[sub][] = array('fid'=>$v2[fid],'name'=>$v2[name]);
								}
						}
						$tmp[sub][] = $t1;
					}
				}
				$channel[] = $tmp;
			}
			$data = array('channel'=>$channel,'cate'=>array());

			if(count($_G[goods_cate])>0 && $_G[goods_cate]){
				foreach($_G[goods_cate] as $k=>$v){
					$data['cate'][] = array('id'=>$v[id],'name'=>$v[name]);
				}
			}


			/*$data[shop] = array(
				array('id'=>0,'title'=>'取消推荐'),
				array('id'=>1,'title'=>'首页推荐'),
				array('id'=>2,'title'=>'整点抢10点'),
				array('id'=>3,'title'=>'整点抢20点')
			);*/

			$data[title] = array('channel'=>'栏目','cate'=>'分类');
			$this->json(array('data'=>$data,'status'=>'success'));

	}

	function post_goods(){
		global $_G,$app;


		if(!$_GET['len']) {
				$this->json(array('msg'=>'要同步的数据长度不能为空','code'=>1));
				return false;
		}
		if(!$_GET['data']){
			$this->json(array('msg'=>'要同步的数据不能为空','code'=>2));
			return false;
		}

		$data = ($_GET['data']);
			$arr = json_decode($data,true);
           if(!is_array($arr) || !$arr) $arr=json_decode(urldecode_utf8($data),true);


		if(!is_array($arr) || !$arr){
			$this->json(array('msg'=>'要同步的数据解析失败','code'=>3));
			return false;
		}
		if(count($arr) != $_GET['len']){
			$this->json(array('msg'=>'要同步的数据长度和原数据长度不一致','code'=>4));
			return false;
		}


		$filed =table('goods');
		$len = 0;
		$top = top('goods');
		foreach($arr as $k=>$v){
			foreach($v as $k1=>$v1){
				if(!array_key_exists($k1,$filed)){
					unset($v[$k1]);
				}
			}
			if($v['ly']) $v['ly'] = trim_html($v['ly'],1);
			$v['title'] = trim_html($v['title'],1);
			$v['dateline'] = TIMESTAMP;

			$return_id =$top->insert($v);
			if($return_id) $len++;
		}

		if(defined('ERROR') && ERROR ===true && count($arr)-$len>10){
			if(DB::error()){
				$msg = 'DB Error : '.(DB::error());
			}else{
				$msg = urlencode_utf8($_G['error_msg']);
			}
			$msg = '错误条数:'.(count($arr)-$len).',错误信息:'.$msg;
			L($msg);
			$this->json(array('status'=>'error','id'=>$return_id,'msg'=>$msg));
			return false;
		}
		$this->json(array('status'=>'success','len'=>$len,'msg'=>'发布成功'.$len.'条单品'));

	}


	function post_img(){
		global $_G,$app;
		if(!$_GET['data']){
			$this->json(array('msg'=>'要同步的数据不能为空','code'=>2));
			return false;
		}

		$data = ($_GET['data']);
		$arr =$data;
		$filed =table('img');
		$img = get_filed('img',$arr);

		$img['hide'] = intval($img['hide']);
		$img['sort'] = intval($img['sort']);
		$img['hate'] = intval($img['hate']);
		$img['like'] = intval($img['like']);

		$img[title] = trim_html($img[title],1);
		$img[description] = trim_html($img[description],1);
		$img[message] = trim(str_replace("&amp;",'&',$img[message]));

		$img['dateline'] = TIMESTAMP;
		foreach($img as $k1=>$v1){
			if(!array_key_exists($k1,$filed)){
				unset($img[$k1]);
			}
			if(is_string($v1))$img[$k1] = str_replace(array('&yen;','￥'),array('',''),$v1);
		}

		$count = getcount('img',"title='".$img[title]."'");
		$update = false;
		if($count>0){
			$update =true;
			if(!isset($_GET['update'])){
				$this->json(array('status'=>'error','id'=>0,'msg'=>'当前信息已发布过'));
				return false;
			}
		}
		if(!$img[title]){
			$this->json(array('status'=>'error','id'=>0,'msg'=>'标题不能为空'));
			return false;
		}


		if($update){
			$aid = DB::result_first("SELECT id FROM ".DB::table('img')." WHERE title='".$img['title']."'");
			DB::update('img',$img,"id=".$aid);
			$id= $aid;
		}else {
			$id=DB::insert('img',$img,true);
		}


		if($id>0){
			$this->json(array('status'=>'success','id'=>$id,'msg'=>'发布成功'));
			return false;
		}else if(defined('ERROR') && ERROR ===true){
			if(DB::error()){
				$msg = 'DB Error : '.(DB::error());
			}else{
				$msg = urlencode_utf8($_G['error_msg']);
			}
			$this->json(array('status'=>'error','id'=>$return_id,'msg'=>$msg));
			return false;
		}else{
			$this->json(array('status'=>'error','id'=>$id,'msg'=>'未成功,数据库未报错'));
			return false;
		}

	}




	function post_style(){
		global $_G;

		if(!$_GET['data']){
			$this->json(array('msg'=>'要同步的数据不能为空','code'=>2));
			return false;
		}

		$data = ($_GET['data']);
		$success = 0;
		$error = 0;
		$repeat = 0;
		//sort($_G['spyder_cate']);
		//$max = count($_G['spyder_cate'])-1;

		$last_id = 0;
		foreach($data as $k=>$v){
			$v['images'] = stripcslashes($v['images']);
			$tmp = array('title'=>$v['title'],'picurl'=>$v['picurl'],'images'=>$v['images'],'keywords'=>$v['keywords'],
				'content'=>$v['content'] ? $v['content'] :$v['title'],
				'length'=>$v['count'],'goods'=>$v['goods'],'uid'=>0,'username'=>'火星人','check'=>1,'cate'=>$v['cate']
			);

			$tmp['keywords'] = explode(',',$tmp['keywords']);
			$tmp['keywords'] = array_unique($tmp['keywords']);
			$tmp['keywords'] = array_filter($tmp['keywords']);
			$tmp['keywords'] = implode(',',$tmp['keywords']);

			$rs = DB::fetch_first("SELECT id FROM ".DB::table('style')." WHERE title = '".$v['title']."'");
			if($rs['id']>0) {
				$repeat++;
				continue;
			}

			//$rand = rand(0,$max);
			//$tmp['cate'] = $_G['spyder_cate'][$rand]['id'];
			$tmp['dateline'] = TIMESTAMP;
			//$tmp['flag'] = rand(0,2);

			$last_id = DB::insert('style',$tmp,true);
			if($last_id>0){
				$success ++;
			}else{
				$error ++;
			}
		}
		//memory('clear');
		//loadcache ($_G[_config][cache_list],'update');
		$this->json(array('status'=>'success','msg'=>'共发布搭配成功'.$success.'条,失败'.$error.'条,重复'.$repeat.'条','id'=>$last_id));

	}

	public function del_goods(){
		global $_G;
		if(!$_GET['num_iid']) json('商品id不能为空');
		$num_iid = $_GET['num_iid'];

		DB::delete('goods',"num_iid = '".$num_iid."'");
		json(array('status'=>'success','msg'=>'删除成功'));

	}

	public function update_goods(){
			global $_G;

			if(!$_GET['data']['num_iid']) json('商品id不能为空');
			$num_iid = $_GET['data']['num_iid'];

			$arr = get_filed('goods',$_GET['data'],$num_iid);
			unset($arr['title'],$arr['picurl'],$arr['yh_price'],$arr['cid']);
			if(isset($arr['end_time'])){
				$arr['end_time'] = intval($arr['end_time']);
				$end_time = DB::result_first("SELECT end_time FROM ".DB::table('goods')." WHERE num_iid = '".$num_iid."'");
				if($end_time>0) unset($arr['end_time']);
			}

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

	public function get_gaoyongjin(){
			global $_G;

			$and = '';
			if(isset($_GET['flag'])){
				$flag = intval($_GET['flag']);
				$and .= ' AND flag = '.$flag;
			}
			
			$and .= " AND posttime > ". (TODAY - 86400*3);
			$and.=" AND (url='' or url like '%item.htm?id=%' ) ";

			$sum = getcount('goods',$and);
			$rs = DB::fetch_all("SELECT num_iid FROM ".DB::table('goods')." WHERE 1 ".$and." ORDER BY DESC ASC LIMIT 100");
			$data = array();
			foreach($rs as $k=>$v){
				$data[] = $v['num_iid'];
			}
			json(array('data'=>array('sum'=>$sum,'goods'=>$data),'status'=>'success'));
		}


		/**
		 * 二合一优惠券采集更新....
		 * @return [type] [description]
		 */
		public function get_erheyi_quan(){
			global $_G;

			$and = '';
			if(isset($_GET['flag'])){
				$flag = intval($_GET['flag']);
				$and .= ' AND flag = '.$flag;
			}
			
			$and .=" AND status in (0,6) ";

			$sum = getcount('goods',$and);
			$rs = DB::fetch_all("SELECT num_iid,juan_url FROM ".DB::table('goods')." WHERE 1 ".$and." ORDER BY aid DESC LIMIT 100");
			json(array('data'=>array('sum'=>$sum,'goods'=>$rs),'status'=>'success'));
		}




	public function get_goods_list(){
		global $_G;

		$and = '';
		if(isset($_GET['flag'])){
			$flag = intval($_GET['flag']);
			$and .= ' AND flag = '.$flag;
		}
		if(isset($_GET['quan'])){
				$and .= " AND juan_url ='' ";
		}


		// $now = TIMESTAMP - 3600;	//1小时之前更新的
		// $and .=" AND dateline < ".$now;

		$sum = getcount('goods',$and);
		$rs = DB::fetch_all("SELECT num_iid FROM ".DB::table('goods')." WHERE 1 ".$and." ORDER BY aid DESC LIMIT 100");
		$data = array();
		foreach($rs as $k=>$v){
			$data[] = $v['num_iid'];
		}
		json(array('data'=>array('sum'=>$sum,'goods'=>$data),'status'=>'success'));
	}

	public function get_quan_list(){
			global $_G;
		 	
		 	$and =" status < 2 AND  juan_url !='' AND sid !='' AND sid !='0' ";
		 	$sum = getcount('goods',$and);
		 	$start = ($_G['page'] * 40);
			$rs = DB::fetch_all("SELECT num_iid,juan_url,sid FROM ".DB::table('goods')." WHERE ".$and." ORDER BY aid DESC LIMIT $start,40",'num_iid');
			if(isset($_GET['sid'])){
					if($rs && count($rs)>0){
						foreach($rs as $k=>$v){
							if(!$v['sid']) continue;
							$rs[$k]['juan_url'] .= '&sid='.$v['sid'];
						}
					}
			}
			sort($rs);
			json(array('data'=>array('sum'=>$sum-$start,'goods'=>$rs),'status'=>'success'));
	}

	public function update_quan(){
			global $_G;

			if(!$_GET['data']['num_iid']) json('商品id不能为空');
			$num_iid = $_GET['data']['num_iid'];
			$arr = get_filed('goods',$_GET['data'],$num_iid);
			if($arr['end_time'])	$arr['end_time'] = dmktime($arr['end_time']) + 86399;
			if($arr['start_time'])	$arr['start_time'] = dmktime($arr['start_time']);
			$arr['dateline'] = TIMESTAMP;
		
			$r = DB::update('goods',$arr,"num_iid='$num_iid'");
			if($r>0){
				json(array('status'=>'success','data'=>'','msg'=>'更新优惠券信息成功'));
			}else{
				json('更新失败');
			}
	}

	public function get_pid(){
			global $_G;
			json(array('status'=>'success','data'=>'','msg'=>$_G['setting']['pid']));
	}


	public function upload_order(){
				global $_G;
				$is_add_all = false;
				$success = $update = 0;
				$post_data = json_decode($_GET['data'],true);

				foreach($post_data as $k=>$v){
						$rs = array();
						$number = $rs['order_number'] = (sprintf("%.0f",$v['taobaoTradeParentId'])."");
						
						$data = DB::fetch_first("SELECT id,uid,status FROM ".DB::table('order_list') ." WHERE order_number = ".$number);
						if($is_add_all){

						}else{
							if( !$data || !$data['id']) continue;	//不存在网站中的就跳过.避免太多无用订单被导入进来
						}

						$rs['create_time'] = dmktime($v['createTime']);
						if($v['earningTime'])$rs['end_time'] = dmktime($v['earningTime']);
						$rs['title'] = $v['auctionTitle'];
						$rs['num'] = $v['auctionNum'];
						$rs['price'] = $v['totalAlipayFeeString'];	//付款金额
						$rs['pingtai'] = $v['terminalType'];
						$rs['num_iid'] = (sprintf("%.0f",$v['auctionId'])."");
						$rs['bili'] = $v['finalDiscountToString'];
						$rs['yongjin'] = $v['tkPubShareFeeString'];		//最终结算金额
						$rs['dateline'] = TIMESTAMP;
						
						if($data['status'] ==3) continue;	//已返现,不理会


						switch($v['payStatus']){
								case 3:		//订单结算
								case 11:	//订单创建
								case 12:	//订单付款
								case 14:	//订单成功
									$rs['status'] =  (!$data || $data['uid']==0 )? 1 :4;
								break;
								case 13:	//订单失效
									$rs['status'] = 2;
								break;						
								default:	//其它
									$rs['status'] = 99;
								break;
						}
						
						if($is_add_all){
							if($data['id>0']){
								$r = DB::update('order_list',$rs,'id='.$data['id']);
								if($r>0)$update++;
							}else{
								$r = DB::insert('order_list',$rs,true);
								if($r>0)$success++;
							}
						}else{
							$r = DB::update('order_list',$rs,'id='.$data['id']);
							if($r>0)$update++;
						}
				}

				$msg = '提交成功'.count($post_data).'条';
				if($is_add_all){
					$msg .=',新增加'.$success.'条,更新成功'.$update.'条';
				}else{
					$msg .= ',更新成功'.$update.'条订单信息';
				}
				
				json(array('status'=>'success','data'=>'','msg'=>$msg));
	}


}


?>
