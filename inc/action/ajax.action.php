<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class ajax extends app{
	public function main(){
		json(array('status'=>'error','msg'=>'Action Error'));
	}

	function m_get_goods(){
			global $_G;
			if(!$_GET['num_iid']) json('商品id不存在');
			$num_iid = get_goods_id($_GET['num_iid']);
			$rs = top('goods','get_goods',$num_iid);
			if($rs == false || !$rs['num_iid']) json('获取失败'.$_G['msg']);
			if($_GET['get_message'] != 1) unset($rs['message']);


			json(array('status'=>'success','data'=>$rs));
	}


	function get_goods(){
		global $_G;
		if(!$_GET['num_iid']) json('商品id不存在');
		$num_iid = get_goods_id($_GET['num_iid']);
		$goods = DB::fetch_first("SELECT * FROM ".DB::table('goods')." WHERE num_iid = '$num_iid'");
		json(array('status'=>'success','data'=>$goods));
	}

	function get_url(){
			global $_G;
			if(!$_G['setting']['caiji_web']) json('远程采集站点未配置');
			json(array('status'=>'success','data'=>trim($_G['setting']['caiji_web'],'/')));
	}

	function sign(){
			global $_G;
			/*if(!$_G[setting][jf]){
				json(array('status'=>'error','msg'=> '系统已关闭签到功能,无法领取积分'));
				return false;
			}else
			*/
			check_user_power();
			$arr = array();
			$today = TODAY;
			$tomorrow = TOMORROW; 
			$and =" AND dateline >$today && dateline < $tomorrow   AND type = 'sign' " ;

			$time = TIMESTAMP - 86400 ;
			$res = DB::fetch_first("SELECT * FROM ".DB::table('sign')." WHERE uid=".$_G[uid]."" .$and);

			if($res[id] && $res[id]>0){
				msg('您今日已签到,待明日再来吧','error');
				return false;
			}


			$count_days = get_sign_jf();
			$jf  = $_G[setting][sign_jf][$count_days];
			$add_jf = 		$_G['member']['jf']+$jf;
			$id =insert_sign(array('desc'=>'签到:连续签到第'.$count_days.'天','type'=>'sign','org_jf'=>$add_jf,'jf'=>$jf));
			if($id){
					$arr = array('jf'=>$add_jf);
					update_member($arr,$_G[member][uid]);
			}


			$count = getcount("sign"," AND uid =".$_G[uid]." AND type = 'sign'");
			$ext_msg = '';
			if($_G[setting][sign_tb][$count]>0){
				$j = intval($_G[setting][sign_tb][$count]);
				insert_sign(array('desc'=>'第'.$count.'次签到系统奖励','type'=>'system','org_jf'=>$add_jf+$j,'jf'=>$j));
				$arr = array('jf'=>$add_jf+$j);
				update_member($arr,$_G[member][uid]);
				$ext_msg .='您的是第'.$count.'次签到,系统额外奖励您积分'.$j;
			}

			$arr['status'] = 'success';
			$arr['msg'] = '恭喜您签到成功,获得'.$jf.'个积分!';

			if($count_days=='n' || $count_days+1>7){
				$next = 'n';
			}else{
				$next = $count_days+1;
			}
			//'.$_G[setting][sign_jf][$next].'
			$arr['msg'] .='今天是连续签到第'.$count_days.'天,再接再劢.';
			$arr['msg'] .=$ext_msg ;


			msg($arr[msg],$arr[status]);
	}

	function keywords(){
		global $_G;

		if(!$_GET['title'] && !$_GET['content'])  return json(array('status'=>'error','data'=>'','msg'=>'数据不能为空'));
		$title = urldecode($_GET[title]);
		$rt = (get_keywords($title));

		if($rt =='' || !$rt) return json(array('status'=>'error','data'=>'','msg'=>'false'));

		json(array('status'=>'success','data'=>$rt,'msg'=>''));
	}

	function email_check(){
		global $_G;
		if(!$_G[uid]){
			msg('未登录无法进行验证操作','error');
		}elseif(!$_G[setting][email][status]){
			msg('系统未开启发送邮件功能','error');

		}else if($_G[member][email_check] == 1){
			msg('您当前账号已经通过邮箱验证,无须再次进行验证','error');

		}elseif($_SESSION['verify']){
			msg('已经向您账户发送了验证邮件,请登录您的邮箱进行验证.','error');
		}elseif(!$_GET[email]){
			msg('邮箱不存在,无法进行验证','error');
		}
		$email = urldecode_utf8($_GET[email]);
		if(!is_email($email))  msg('邮箱格式不正确','error');

		$p = DB::fetch_first("SELECT * FROM ".DB::table('member')." WHERE email ='".$email."' AND uid != ".$_G[uid]);
		if($p[uid]>0) msg('邮箱已被注册','error');

		if($_G[member][email] != $email){
			update_member(array('email'=>$email,'email_check'=>0),$_G[uid]);
		}

		$rs = send_email($email,'email_check');
		if($rs['status']=='success'){
			$msg = '我们已向您的邮箱'.$arr['email'].'发送了一封验证邮件,请在15分钟内查看并验证';
			msg($msg,'success');
		}else{
			msg($rs[msg],'error');
		}

	}

	function phone_check(){
		global $_G;
		msg('系统未开启发送短信功能','error');
		if(!$_G[uid]){
			msg('未登录无法进行验证操作','error');
		//}elseif(!$_G[setting][phone_status] || !$_G[setting][phone_username]||!$_G[setting][phone_password]){
		//	msg('系统未开启发送短信功能','error');
		}else if($_G[member][phone_check] == 1){
			msg('您当前账号已经通过手机验证,无须再次进行验证','error');
		}elseif(!$_GET[phone]){
			msg('手机号码不存在,无法进行验证','error');
		}
		$phone = trim($_GET[phone]);
		if(!is_phone($phone))  msg('手机号码格式不正确','error');
		$p = DB::fetch_first("SELECT uid FROM ".DB::table('member')." WHERE phone ='".$phone."' AND uid != ".$_G[uid]);
		if($p[uid]>0) msg('手机号码已被注册','error');

		if($_GET[code]){
			if($_SESSION['verify_phone']==$phone.'_'.intval($_GET[code])){
				update_member(array('phone'=>$phone,'phone_check'=>1),$_G[uid]);
				unset($_SESSION['verify_phone'],$_SESSION['verify_phone_len']);
				msg('手机号码验证成功','success');
			}else{
				msg('您的验证码校验失败','error');
			}
			return false;
		}

		if($_G[member][phone] != $phone){
			update_member(array('phone'=>$phone,'phone_check'=>0),$_G[uid]);
		}

		$rs = send_verify_phone($phone);
		if($rs['status']=='success'){

			$msg = '我们已向您的手机'.$arr['phone'].'发送了一封验证短信,请在10分钟内查看并验证【' .$_G[setting][title].'】';
			msg($msg,'success');
		}else{
			msg($rs[msg],'error');
		}
	}

	function yzm(){
		referer_yzm(1);
	}





	function favorite(){
		global $_G;
		check_user_power();
		$type = trim_html($_GET['type'],1);


		if(!array_key_exists($type,$_G['setting']['favorite_types'])) msg('未定义的类型,无法收藏','error');

		$id = intval($_GET[id]);
		if(!$id){
			msg('抱歉,要收藏的id不存在','error');
			return false;
		}
		$table = $type;
		$num_iid = '';
		if(strpos($type,"_goods") !== false){
				$num_iid = get_goods_id($_GET['num_iid']);
				if(!$num_iid)msg('抱歉,要收藏的商品id不正确','error');
				$and .=" AND num_iid='$num_iid'";
				$table = str_replace("_goods",'',$table);
		}

		$and = ' AND type_id = '.$id ." AND type = '".$type."'";

		$rs = DB::fetch_first("SELECT id,jf FROM ".DB::table(__FUNCTION__)." WHERE  uid=".$_G[uid] .$and);
		$msg = '';
		$jf = intval($_G[setting][addfavorite_jf]);

		//没收藏过
		if(!$rs ||  !$rs[id]){

					$id_name = $table == 'goods' ? 'aid':'id';
					$fd = 'title,picurl';
					if(strpos($type,"_goods") !== false) $fd.=",goods";

					if(defined('APP') && $type == 'goods') $fd.=",start_time";

					$data = DB::fetch_first("SELECT $fd FROM ".DB::table($type)." WHERE  $id_name =".$id);
					if(!$data['title']) msg('未找到待收藏的商品');

					$arr = get_filed(__FUNCTION__);
					$arr['jf'] = $jf;
					$arr['username'] = $_G['username'];
					$arr['uid'] = $_G['uid'];
					$arr['type_id'] = $id;
					$arr['type'] = $type;

					$arr['title'] = $data['title'];
					$arr['picurl'] = $data['picurl'];
					$arr['url'] = 'index.php?m='.$type.'&'.$id_name.'='.$id;
					$arr['dateline']= TIMESTAMP;
					if($arr['jf']>0) {
						update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
						$msg=",系统奖劢你".$jf."个积分";
						insert_sign(array('desc'=>'收藏商品-'.$data[title],'type'=>__FUNCTION__,'org_jf'=>$_G['member']['jf'],'jf'=>$jf,'type_id'=>$id));
					}

					DB::insert(__FUNCTION__,$arr,1);
					$count = getcount(__FUNCTION__,$and);
					$fd = table($type);

					if(isset($fd['favorite_count'])){
						$where = '';
						if(isset($fd['id'])){
							$where = 'id=' .$id;
						}else if(isset($fd['aid'])){
							$where ='aid=' .$id;
						}
						if($where) DB::update($type,array('favorite_count'=>$count),$where);

					}

					if(defined('APP') && $type == 'goods'){

					}

					msg('收藏成功'.$msg,'success','',$count);

		}else{
					$len = DB::delete(__FUNCTION__,"id=".$rs['id']);
					if($jf>0) {
							$msg=",系统扣除你".$jf."个积分";
							$dec_jf = 0-$rs['jf'];
							update_member(array('jf'=>$_G[member][jf]+$dec_jf),$_G[uid]);
							DB::delete('sign'," uid = ".$_G['uid']." AND type_id=".$id." AND type = '".__FUNCTION__."' ");
					}
					$count = getcount(__FUNCTION__,$and);

					$fd = table($type);

					if(isset($fd['favorite_count'])){
						$where = '';
						if(isset($fd['id'])){
							$where = 'id=' .$id;
						}else if(isset($fd['aid'])){
							$where ='aid=' .$id;
						}

						if($where)DB::update($type,array('favorite_count'=>$count),$where);
					}

					msg('取消收藏成功'.$msg,'success','',$count);
		}

	}










	function like(){
		global $_G;
		check_user_power();

		if(!$_GET['type']) {
			msg('喜欢类型不存在');
			return ;
		}
		$type = trim_html($_GET['type'],1);
		if(!array_key_exists($type,$_G['setting']['like_types'])) msg('未定义的类型,无法喜欢','error');

		$id = intval($_GET[id]);
		if(!$id){
			msg('抱歉,要喜欢的id不存在','error');
			return false;
		}

		$and = ' AND type_id = '.$id ." AND type = '".$type."'";
		$table = $type;
		$num_iid = '';

		if(strpos($type,"_goods") !== false){
				$num_iid = get_goods_id($_GET['num_iid']);
				if(!$num_iid)msg('抱歉,要喜欢的商品id不正确','error');
				$and .=" AND num_iid='$num_iid'";
				$table = str_replace("_goods",'',$table);
		}


		$rs = DB::fetch_first("SELECT id,jf FROM ".DB::table(__FUNCTION__)." WHERE  uid=".$_G[uid] .$and);
		$msg = '';
		$jf = intval($_G[setting][like_jf]);

		//没喜欢过
		if(!$rs ||  !$rs[id]){
					$id_name = $table == 'goods' ? 'aid':'id';

					$fd = 'title,picurl';

					if(strpos($type,"_goods") !== false){
						$fd.=",goods";
					}

					$data = DB::fetch_first("SELECT $fd FROM ".DB::table($table)." WHERE  $id_name =".$id);
					if(!$data['title']) msg('未找到待喜欢的商品');

					$arr = get_filed(__FUNCTION__);
					if(isset($arr['groupid']) && $_GET['groupid']) $arr['groupid'] = intval($_GET['groupid']);
					$arr['jf'] = $jf;
					$arr['username'] = $_G['username'];
					$arr['uid'] = $_G['uid'];
					$arr['type_id'] = $id;
					$arr['type'] = $type;
					$arr['num_iid'] = $num_iid;

					$arr['title'] = $data['title'];
					$arr['picurl'] = $data['picurl'];
					$arr['url'] = 'index.php?m='.$table.'&'.$id_name.'='.$id;
					$arr['dateline']= TIMESTAMP;


					if($arr['jf']>0) {
						update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
						$msg=",系统奖劢你".$jf."个积分";
						insert_sign(array('desc'=>'喜欢商品-'.$data[title],'type'=>__FUNCTION__,'org_jf'=>$_G['member']['jf'],'jf'=>$jf,'type_id'=>$id));
					}

					$rid = DB::insert(__FUNCTION__,$arr,1);
					$count = getcount(__FUNCTION__,$and);
					$fd = table($table);
						if(isset($fd['like_count']) || isset($fd['like'])){
						$where = '';
						if(isset($fd['id'])){
							$where = 'id=' .$id;
						}else if(isset($fd['aid'])){
							$where ='aid=' .$id;
						}
						$fd_name =isset($fd['like_count'])  ? 'like_count': 'like';

						if($where) {
								$update = array($fd_name=>$count);

								if($num_iid && strpos($type,"_goods") !== false){
										//要将子商品来增加
										$goods = stripcslashes($data['goods']);
										$goods = dunserialize($goods);
										$num = 0;
										$title = '';
										foreach($goods as $k=>$v){
											$v['like'] = intval($v['like']);
											if($v['num_iid'] == $num_iid){
												$title = $v['title'];
												if($is_like){
													$v['like']--;
												}else{
													$v['like']++;
												}
												if($v['like']<0) $v['like'] = 0;
												$num = $v['like'];
											}
											$goods[$k] =$v;
										}
									  $update[goods] = serialize($goods);
									 if($title && $rid)DB::update(__FUNCTION__,array('title'=>$title),'id='.$rid);
								}

								DB::update($table,$update,$where);
						}

					}

					msg('喜欢成功'.$msg,'success','',$count);

		}else{
					$len = DB::delete(__FUNCTION__,"id=".$rs['id']);
					if($jf>0) {
							$msg=",系统扣除你".$jf."个积分";
							$dec_jf = 0-$rs['jf'];
							update_member(array('jf'=>$_G[member][jf]+$dec_jf),$_G[uid]);
							DB::delete('sign'," uid = ".$_G['uid']." AND type_id=".$id." AND type = '".__FUNCTION__."' ");

					}
					$count = getcount(__FUNCTION__,$and);
					$fd = table($table);
					if(isset($fd['like_count']) || isset($fd['like'])){
						$where = '';
						if(isset($fd['id'])){
							$where = 'id=' .$id;
						}else if(isset($fd['aid'])){
							$where ='aid=' .$id;
						}
						$fd_name =isset($fd['like_count'])  ? 'like_count': 'like';

						if($where){
							DB::update($table,array($fd_name=>$count),$where);
						}
					}

					msg('取消喜欢成功'.$msg,'success','',$count);
		}

	}






	function share(){
		global $_G;
		check_user_power();

		if(!$_GET['type']) {
			msg('喜欢类型不存在');
			return ;
		}
		$type = trim_html($_GET['type'],1);
		if(!array_key_exists($type,$_G['setting']['share_types'])) msg('未定义的分享','error');

		$id = intval($_GET[id]);
		if(!$id){
			msg('抱歉,要分享的id不存在','error');
			return false;
		}

		$and = ' AND type_id = '.$id ." AND type = '".$type."'";
		$table = $type;
		$num_iid = '';


		if(strpos($type,"_goods") !== false){
				$num_iid = get_goods_id($_GET['num_iid']);
				if(!$num_iid)msg('抱歉,要分享的商品id不正确','error');
				$and .=" AND num_iid='$num_iid'";
				$table = str_replace("_goods",'',$table);
		}


		$rs = DB::fetch_first("SELECT id,jf FROM ".DB::table(__FUNCTION__)." WHERE  uid=".$_G[uid] .$and);
		$msg = '';
		$jf = intval($_G[setting][like_jf]);

		//没喜欢过
		if(!$rs ||  !$rs[id]){
					$id_name = $table == 'goods' ? 'aid':'id';
					$fd = 'title,picurl';
					if(strpos($type,"_goods") !== false){
						$fd.=",goods";
					}
					$data = DB::fetch_first("SELECT $fd FROM ".DB::table($table)." WHERE  $id_name =".$id);
					if(!$data['title']) msg('未找到待分享的商品');

					$arr = get_filed(__FUNCTION__);
					//if(isset($arr['groupid']) && $_GET['groupid']) $arr['groupid'] = intval($_GET['groupid']);
					$arr['jf'] = $jf;
					$arr['username'] = $_G['username'];
					$arr['uid'] = $_G['uid'];
					$arr['type_id'] = $id;
					$arr['type'] = $type;
					$arr['num_iid'] = $num_iid;

					$arr['title'] = $data['title'];
					$arr['picurl'] = $data['picurl'];
					$arr['url'] = 'index.php?m='.$table.'&'.$id_name.'='.$id;
					$arr['dateline']= TIMESTAMP;


					if($arr['jf']>0) {
						update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
						$msg=",系统奖劢你".$jf."个积分";
					}

					$rid = DB::insert(__FUNCTION__,$arr,1);
					$count = getcount(__FUNCTION__,$and);
					$fd = table($table);
						if(isset($fd['share_count']) || isset($fd['share'])){
						$where = '';
						if(isset($fd['id'])){
							$where = 'id=' .$id;
						}else if(isset($fd['aid'])){
							$where ='aid=' .$id;
						}
						$fd_name =isset($fd['share_count'])  ? 'share_count': 'share';

						if($where) {
								$update = array($fd_name=>$count);

								if($num_iid && strpos($type,"_goods") !== false){
										//要将子商品来增加
										$goods = stripcslashes($data['goods']);
										$goods = dunserialize($goods);
										$num = 0;
										$title = '';
										foreach($goods as $k=>$v){
											$v['share'] = intval($v['share']);
											if($v['num_iid'] == $num_iid){
												$title = $v['title'];
												if($is_like){
													$v['share']--;
												}else{
													$v['share']++;
												}
												if($v['share']<0) $v['share'] = 0;
												$num = $v['share'];
											}
											$goods[$k] =$v;
										}
									  $update[goods] = serialize($goods);
									 if($title && $rid)DB::update(__FUNCTION__,array('title'=>$title),'id='.$rid);
								}

								DB::update($table,$update,$where);
						}

					}

					msg('增加分享成功'.$msg,'success','',$count);

		}
		msg('已分享无须再次分享','error','',$count);
	}
	function get_open_iid(){
		$id = ($_GET[num_iid]);
		$rs = top('baichuan','get_goods',$id);

		if($rs[open_iid]){
			$iid =$rs[open_iid];
		}else{
			$iid =array();
			foreach($rs as $k=>$v){
				$iid[$v[num_iid]] = $v[open_iid];
			}
		}
		json(array('status'=>'success','data'=>$iid));
	}

    function goods() {
        global $_G;
        $sql = make_sql();
        $url = 'm=ajax&a=goods';
     	$size = $_G[setting][cate_page] ? $_G[setting][cate_page] : 120;
      //  if($_GET['field']) $sql['field'] = trim_html($_GET['field'],1);
        $and = '';
        if($_GET['kw']) {
            $string = stripsearchkey(trim($_GET['kw']));
            if (preg_match("/^%+$|^_+$|^\*+$/is", $string)) {
                msg('非法搜索关键字');
            }
            $string = safe_output($string);
            if (dstrlen($string) < 2) {
                msg('要搜索的关键字长度不能小于2');
            }
            $_GET[kw] = $string;
            $and .= " AND title like '%$string%' ";
            $url .= "&kw=" . urlencode_utf8($string);
        }


		if($_GET[tag]){
						$tag  = trim_html($tag,1);
						$tag = daddslashes($_GET[tag]);
						$and .="AND FIND_IN_SET('".$tag."', keywords) ";
						$url .="&tag=".urlencode_utf8($tag);
						$sql['and'] .= $and;
						$sql['url'] .= $url;

		}



        $rs = D(array('and' => $and . $sql['and'], 'all' => false, 'order' => $sql[order]),
            array('url' => $url . $sql[url], 'size' => $size));

		$goods = array();
		foreach($rs['goods'] as $k=>$v){
			$tmp = array();
			$tmp['picurl'] = $v['picurl'];
			$tmp['url'] =$v['url'];
			$tmp['id_url'] =$v['id_url'];
			$tmp['num_iid'] =$v['num_iid'];
			$tmp['aid'] =$v['aid'];
			$tmp['yh_price'] =$v['yh_price'];
			$tmp['sum'] =$v['sum'];
			$tmp['like'] =$v['like'];
			$tmp['title'] =$v['title'];
			$tmp['username'] =$v['username'];
			$tmp['price'] =$v['price'];
			$tmp['status'] =$v['status'];
			$tmp['status_text'] =$v['status_text'];
			$tmp['start_time'] =$v['start_time'];

			$tmp['over'] =$v['over'];

			$goods[] = $tmp;
		}


        json(array('data' => $goods, 'status' => 'success'));
    }


	function share_callback(){
		global $_G;
		//if($_G['inajax'] !=1) json('Eroor');

		check_user_power();
		if(!$_SERVER['HTTP_REFERER'])json(array('msg' => '非法分享', 'status' => 'error'));

		if($_SESSION['share_count'] && $_SESSION['share_count']>10){
			json(array('msg' => '分享过于频繁,请稍后再分享', 'status' => 'error'));
		}
		if(!$_SESSION['share_count'])$_SESSION['share_count']  =1;

		if(!$_GET['type']) {
			msg('分享类型不存在');
			return ;
		}
		$type = trim_html($_GET['type'],1);
		if(!array_key_exists($type,$_G['setting']['share_type_callback'])) msg('未定义的类型,无法分享','error');
		$id = intval($_GET[id]);
		if(!$id){
			msg('抱歉,要分享的id不存在','error');
			return false;
		}
		$name = $_G['setting']['share_type_callback'][$type];
		$desc = '分享内容到 '.$name.' id='.$id;

		//$count = getcount('sign'," uid = ".$_G[uid]." AND `desc`='".$desc."' AND type = '".$type."'");
		$count = 0 ;
		$is_add = false;
		if($count == 0 ) {
			$is_add = true;
		}else{
			$today = TODAY;
			$count_day = getcount('sign'," uid = ".$_G[uid]." AND type = '".$type."'  AND dateline >=".$today);
			if($count_day > $_G[setting][share_goods_num]) $is_add =false;
		}


		if($is_add){
				$jf  	=	$_G[setting][share_goods];
				$add_jf = 	$_G['member']['jf']+$jf;
				$sid =insert_sign(array('desc'=>$desc,'type'=>'share','org_jf'=>$add_jf,'jf'=>$jf));
				if($sid){
					update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
				}
		}
		$_SESSION['share_count']++;
		json(array('msg' => '分享成功', 'status' => 'success'));
	}


	/**
	 * 删除优惠券
	 * @return [type] [description]
	 */
	function del_quan(){
		global $_G;
		$act_id = $_GET['quan_id'];

		if(preg_match("/^[a-z0-9A-Z]{30,35}$/is",$act_id)){
			DB::update('goods',array('end_time'=>TIMESTAMP),"juan_url like '%".$act_id."%'");
		}
	}


	function get_message(){
		global $_G;
		if(!$_GET['num_iid']) json('商品id不存在');
		$num_iid = get_goods_id($_GET['num_iid']);
		$msg = top('m_taobao','get_message',$num_iid,true);
		if(!$msg){
			json('获取详情失败');
		}
		json(array('msg' => '分享成功', 'status' => 'success','data'=>$msg));


	}
	
}
?>
