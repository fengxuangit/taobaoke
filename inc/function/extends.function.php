<?php
if(!defined('IN_TTAE')) exit('Access Denied');

include 'inc/class/cache/fileServer_cache.php';

function getuserpic($user){

	if($user[picurl])  return  $user[picurl];

        $picurl = avatar($user[username],$user['uid']);

	return $picurl;
}


function browserversion($type) {
	static $return = array();
	static $types = array('ie' => 'msie', 'firefox' => '', 'chrome' => '', 'opera' => '', 'safari' => '', 'mozilla' => '', 'webkit' => '', 'maxthon' => '', 'qq' => 'qqbrowser');
	if(!$return) {
		$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$other = 1;
		foreach($types as $i => $v) {
			$v = $v ? $v : $i;
			if(strpos($useragent, $v) !== false) {
				preg_match('/'.$v.'(\/|\s)([\d\.]+)/i', $useragent, $matches);
				$ver = $matches[2];
				$other = $ver !== 0 && $v != 'mozilla' ? 0 : $other;
			} else {
				$ver = 0;
			}
			$return[$i] = $ver;
		}
		$return['other'] = $other;
	}
	return $return[$type];
}

function get_fup($fid,$type='channels'){
	global $_G;

	if($_G[$type][$fid]) return $_G[$type];
		foreach($_G[$type] as $k=>$v){
			if($v[sub][$fid]) return $v;
			foreach($v[sub] as $k1=>$v1){
				if($v1[sub][$fid]) return $v1;
				foreach($v1[sub] as $k2=>$v2){
					if($v2[$fid]) return $v2;
				}

			}
		}
		return false;
}
function get_sub($fid,$type='channels'){
	global $_G;
	$id = $type=='channels' ? 'fid':'id';
		foreach($_G[$type] as $k=>$v){
			if($v[$id] == $fid)  return $v;
			foreach($v[sub] as $k1=>$v1){
				if($v1[$id] == $fid)  return $v1;
				foreach($v1[sub] as $k2=>$v2){
					if($v2[$id] == $fid) {
						 return $v2;
					}
				}

			}
		}
}

function make_sql($in_talbe=''){
		global $_G,$app;
		$get = ($_GET);
		$in_talbe = $in_talbe ? $in_talbe :'goods';

		$and =$sort =$order =$url= '';
		if(isset($get[fid]) && $get[fid]>0){
			$fid = intval($get[fid]);
			$fup = get_sub($fid);
			if($fup && $fup[fid_in]){
				$and .= " AND fid in ( ".$fup[fid_in]." )";
			}else{
				$and .= " AND fid =".$fid;
			}
			$url .="&fid=".$fid;
		}

		if(isset($get[cate]) &&   $get['cate']>0){
			$cate = intval($get['cate']);
			$and .= " AND cate = ".$cate;
			$url .= '&cate='.$cate;
		}





	//&and = yh_price_gt_100
		if(isset($get['and']) && trim($get['and'])){
			$tmp = explode('_',$get['and']);
			if(count($tmp) == 4){
				$tmp1 = array($tmp[0].'_'.$tmp[1],$tmp[2],$tmp[3]);
			}else{
				$tmp1 = $tmp;
			}
			if(!$table)$table = table($in_talbe);

			if(array_key_exists($tmp1[0],$table)){
					$and_f = ' = ';
					if($tmp1[1] == 'gt'){
						$and_f =' > ';
					}else if($tmp1[1] == 'lt'){
						$and_f =' < ';
					}else if($tmp1[1] == 'neq'){
						$and_f =' != ';
					}
					$and .= " AND ".$tmp1[0] .$and_f . $tmp1[2];
					$url .= '&'.$get['and'];

			}

		}

		if(isset($get['price']) && $get['price']>0){
			if(strpos($get[price],'_') !==false){
				$price = explode('_',$get[price]);
				$price[0] = intval($price[0]);
				$price[1] = intval($price[1]);
				$and .=" AND yh_price-juan_price >= ".$price[0]." AND yh_price-juan_price < ".$price[1];
				$url .= '&price='.$price[0].'_'.$price[1];
			}else{
				$price = intval($get['price']);
				$and .=" AND yh_price-juan_price < ".$price;
				$url .= '&price='.$price;
			}
		}

		if(isset($get['and_in']) && trim($get['and_in']) && $get[where] && array_key_exists($get[where],table('goods'))){
			$and_in = trim($get['and_in']);
			$field = trim($get[where]);
			if(!$table)$table = table($in_talbe);
			if(array_key_exists($field,$table) && preg_match("/^[a-z_0-9-,.]+$/",$and_in) && preg_match("/^[a-z_]+$/",$get[where])){
				$tmp = explode('-',$and_in);
				$tmp2 = explode(',',$and_in);
				if($tmp && count($tmp)==2){
					$and .=" AND `$field` >= '".floatval($tmp[0])."' AND `$field` <='".floatval($tmp[1])."'";
				}elseif($tmp2 && count($tmp2)>1){
					$and .=" AND `$field` in (".$and_in.")" ;
				}else{
					$and .=" AND `$field` = '".$and_in."'";
				}
				$url.="&and_in=".$and_in."&where=".$get[where];
			}

		}
		//sort
		if(isset($get['sort']) && $get['sort']){
			$url .= '&sort='.trim($get[sort]);
			$sort = $get['sort'] == 'asc' ? ' ASC '  : ' DESC ';

		}
		//order
		if($get['order'] && preg_match("/^[a-z_]+$/",$get['order'])){
		if(!$table)$table = table($in_talbe);
			if(array_key_exists($get[order],$table)){
					$order = trim($get[order]);
					$url .= '&order='.$order;
					if(!$sort) $sort = ' DESC ';
					$order = ' `'.$order.'` '. $sort;
			}
		}

		return array('and'=>$and,'url'=>$url,'order'=>$order);
}


function loadcache($cachenames,$type='load',$lv=0) {
	global $_G;
	static $cache_server;
	if(!$cachenames) return false;
	if(!$cache_server) {
		$cache_server=new cache();
	}

	$cache =  $cache_server;

	$cachenames = (array)$cachenames;
	if($type =='load'){
		  $data = $cache->fetch_all($cachenames,$lv);
		  foreach($data as $k => $v) {
				if(in_array($k,$_G[_config][cache_list])){
					$_G[$k] =$v;
				}else{
					$_G['cache'][$k] = $v;
				}
		  }
	}elseif($type =='update'){
		foreach($cachenames as $k => $v) {
			$res = $cache->update($v);
			$_G['cache'][$k] = $v;
			if(in_array($v,$_G[_config][cache_list])){
				 $_G[$v] = $res;
			}else{
				$_G['cache'][$v] = $res;
			}
		}
	}elseif($type =='delete'){
		foreach($cachenames as $v) {
		  $cache->del($v);
		}
	}
	return true;
}
function savecache($cachenames,$data,$update=false,$lv=0){
	global $_G;
	static $cache_server;
	if(!$cache_server) $cache_server=new cache();
	return $cache_server->insert($cachenames,$data,$update,$lv);
}


function update_member($arr,$uid ){
		global $_G;
		if(!$uid) $uid = $_G[uid];
		$uid = intval($uid);
		if(isset($arr['jf'])){
			update_group($uid);
			if($_G['uid'] == $uid){
				$jf = $_G['member']['jf'];
			}else{
				$jf = DB::fetch_first("SELECT max_jf,jf FROM ".DB::table('member')." WHERE uid=".$uid);
			}
			$add_jf = $arr['jf']-$jf['jf'];
			if($add_jf>0){
				 $arr['max_jf'] =$jf['max_jf'] +$add_jf;
			}
		}

		return DB::update('member',$arr,"uid =".$uid);


}
function delete_member($uid){
		if(!$uid) return false;

		return DB::delete("member","uid =".$uid);
}


//更新用户的用户组,  uid  || user_arr
function update_group($user_arr){
		global $_G;

		if(is_numeric($user_arr)){
			$user_arr = getuser($user_arr,'uid');
		}else if(!$user_arr ){
			$user_arr = $_G['member'];
		}else if(is_array($user_arr)){
			if(!$user_arr['jf'] || !$user_arr['groupid']) $user_arr = getuser($user_arr,$user_arr['uid']);
		}

		if(!$user_arr['uid'] || $user_arr['auto_update'] == 1) return false;

		//系统用户组不能升级
		$not_update = array(1,2,3,4,19,20,21,22);
		if(in_array($user_arr['groupid'],$not_update )) return false;

		if($user_arr['jf']<=0 && $user_arr['groupid']!=10){
			DB::update('member',array('groupid'=>10),'uid='.$user_arr['uid']);
			return false;
		}
		$min = 10000;
		$update = false;
		//1,遍利所有用户组,查看当前用户积分是否存在此当中
		foreach($_G['group'] as $k=>$v){
			if(in_array($v['id'],$not_update)) continue;

			if($v['jf_min'] ==0  && $v['jf_max'] == 0) continue;
			if($user_arr['jf']>=$v['jf_min'] && $user_arr['jf']<$v['jf_max']){
				if($user_arr['groupid'] == $v['id']){
					//已经是当前用户组了,就不用更新了
					$update = true;
					break;
				}
				//自动更新当前用户组
				DB::update('member',array('groupid'=>$v['id']),'uid='.$user_arr['uid']);
				if($user_arr['uid'] == $_G['uid']){
					$_G['member']['groupid'] = $v['id'] ;
					$_G['member']['group'] = $v;
					$_G['member']['group_name'] = $v['name'];
				}
				$update= true;
				break;
			}
			if($v['jf_min']<$min)  $min =$v['jf_min'];
		}

		//没有更新,而且有最小的积分, 并且用户的积分又小于最小的积分,则直接降为初始用户组
		if(!$update && $min != 10000 && $user_arr['jf']<$min){
			DB::update('member',array('groupid'=>10),'uid='.$user_arr['uid']);
			if($user_arr['uid'] == $_G['uid']){
					$_G['member']['groupid'] = 10 ;
					$_G['member']['group'] =$_G['group'][10];
					$_G['member']['group_name'] = $_G['group'][10]['name'];
			}
			$update = true;
		}
		return $update;
}



function seo($title='',$keywords='',$description='',$focus=1){
	global $_G;
	$title = safe_output($title);
	$keywords = safe_output($keywords);
	$description = safe_output($description);

	if(!$title) $title = $_G[setting][seo_title];
	if(!$keywords) $keywords = $title.','.$_G[setting][seo_keywords];
	if(!$description) $description = $_G[setting][seo_description].$title;


	if($_G[setting][long_keywords] && !MOBILE){
			if(CURMODULE =='index' && CURACTION == 'main'){

			}else{
				if($title != $_G[setting][title]) $title.= $_G[setting][long_keywords];
			}
			$keywords.=','.$_G[setting][long_keywords];
			$description.=' - '.$_G[setting][long_keywords];
	}

	$title .= $_G[page] >1 ? ' - 第'.$_G[page].'页' : '';

	$_G[title] = $title;
	$_G[keywords] = $keywords;
	$_G[description] = $description;

}


/*	后台专用的 ajax 一键审核 */
function ajax_check($table="",$field="",$where=""){
			global $_G;

			if(!$table) msg('要更新的表不能为空','error');
			if(!array_key_exists($table,table())) msg('要更新的表不能为空','error');
			if(!$where){
				$id = intval($_GET[id]);
				if(!$id) msg('id不能为空','error');
				$check = intval($_GET[check]);
				$where = 'id='.$id;
			}else{
				$check = $field['check'];

			}
			if(!is_array($field) || !$field)  $field = array('check'=>$check);


			DB::update($table,$field,$where);

			if($check == 1){
				msg('已通过','success',$_G[referer]);
			}else if($check == 2){
				msg('已拒绝','success',$_G[referer]);
			}else if($check==0){
				msg('待审核','success',$_G[referer]);
			}
}


function parse($table="",$value="",$f1="",$f2="",$f3=""){
	$_parse = new parse();
	if(method_exists($_parse,$table)){
		if(!$value) return true;
		return $_parse->$table($value,$f1,$f2,$f3);
	}else{
		return $value;
	}
}





function L($msg){
	global $_G;
	if(!$msg)return ;

	
	if(class_exists('DB')){
		$db = & DB::object();
		if(method_exists($db,'errorInfo')){
			if($db->errorInfo()){
				$dberror = str_replace(DB::table(),  '', $db->errorInfo());
				$msg.="\r\nDB:error_info:".$dberror;
				$msg.="\r\nDB:cur_sql:".$db->currentSql;
			}
		}
	}

	if(TAE){
		$appLog = Alibaba::Applog();
		$appLog->error($msg);
	}else{
		if(!class_exists('error'))include_once libfile('class/error');
		error::writeErrorLog($msg);
	}

}

function F($file,$content){
			$ret = '';
			if($content){
				$ret =	file_put_contents(ROOT_PATH.'web/templates_c/'.$file,$content);
			}else{
				$ret =file_get_contents(ROOT_PATH.'web/templates_c/'.$file);
			}
			return $ret;
}



//百川或优站上使用,外站只能用memCache
function memory($cmd='',$key='', $value='', $time) {
	global $_G,$_CACHE;

	if(!is_object($_CACHE)){

			//缓存类型
			  $type = $_G['cache_type'];
			  if($type == 'auto'){
				  if(TAE){
					  $type = 'baichuan';
				  }else if(class_exists('Memcache')){
					  $type = 'memcache';
				  }else{
					  $type = 'fileServer';
				  }
			  }

			$config = array();
			if($type == 'baichuan' || $type == 'aliyun_ocs')$config = $_G['_config']['cache_config'];
			$class = $type.'_cache';
			if(!class_exists($class)){
					$file = ROOT_PATH.'inc/class/cache/'.$class.'.php';
					include_once $file;
			}
			$obj = new $class();
			$enable = $obj->init($config);
			if(!$enable){
				$_G['cache_type']  ='fileServer';
				 return memory($cmd,$key, $value, $time);
			}
			$_CACHE  = $obj;
	}else{
		$obj = & $_CACHE;
	}

	if(!$time) $time = 86400;
	if(defined('DEBUG'))	$_G['memory_debug'][$cmd][] = is_array($key) ?implode(',',$key) : $key;

	if($cmd == 'set'){
		return  $obj->set($key,$value,$time);
	}else if($cmd == 'get'){
		return $obj->get($key);
	}else if($cmd == 'delete'){
		return $obj->delete($key);
	}else if($cmd == 'clear'){
		return $obj->clear();
	}else if($cmd == 'obj'){
		return $obj;
	}
	return false;

}

function insert_sign($arr){
	global $_G;
	$sign =array();

	$sign[uid]=$_G[uid];
	$sign[username]=$_G[username];
	$sign[jf]=$_G[setting][jf];
	$sign[ip]=$_G[clientip];
	$sign[org_jf]=0;
	$sign =get_filed('sign',$sign);

	$sign[dateline]=TIMESTAMP;

	foreach($arr as $k=>$v){
		if(array_key_exists($k,$sign)){
			$sign[$k]= $v;
		}
	}
	$sign[jf] = intval($sign[jf]);
	if(!$sign[org_jf]) $sign[org_jf] = $_G[member][jf]+$sign[jf];
	$sign[uid] = intval($sign[uid]);
	$sign['add'] = $sign[jf]<0?0:'1';
	if(isset($sign['aid'])) unset($sign['aid']);
	if(isset($arr['type_id']))$sign['type_id']=$arr['type_id'];
	if($sign[jf]>0) update_group($sign[uid]);

	return DB::insert('sign',$sign,1);
}


function getuser($username,$type='username'){
	  global $_G;

	  $member = DB::fetch_first("SELECT * FROM ".DB::table('member')." WHERE $type='$username'");
	  if($member && $member['uid']>0){
		  $member[org_picurl]= $member[picurl];
		  $member[picurl] = getuserpic($member);
          $gid = $member['groupid'];
          $member['group'] = $_G['group'][$gid];
          $member['group_name']  =  $member['group']['name'];
		  return $member;
	  }
	  return false;
}


function make_tags($kw,$url){
			global $_G;
			if(!$kw) return array();
			$tag 	=	explode(',',$kw);
			$keywords= array();
			if($tag){
				$tag = array_unique($tag);
				$tag = array_filter($tag);
				foreach($tag as $k=>$v){
					if($v){
						$uname = urlencode_utf8($v);
						$keywords[$uname] = $v;
						if($_G['setting']['get_tag'] && $url && !array_key_exists($v,$_G['tag_list']))$_G['tag_list'][$v] =array('url'=>$url.$uname,'title'=>$v);
					}
				}
			}

			return $keywords;
}


//获取积分分类,或是某个会员的积分统计
function get_jf($uid){
			global $_G;
			$share = array();

			$share_type = $_G[setting][jf_type];

			if(!$uid) return $share_type;
			$and = " uid = ".$uid;
			foreach($share_type as $k=>$v){
				$where = $and ." AND type = '".$k."' ";
				$sum = DB::result_first(" SELECT sum(jf) as jf FROM ".DB::table('sign')." WHERE ". $where);
				if(!$sum) $sum = 0;
				$share[$k] = $sum;
			}
			return $share;
}

/*
 * 自动生成用户头象
 *
 * */
function avatar($user_name, $uid = 0, $size = 120) {
    global $_G;
    if (!$user_name) {
        return 'assets/global/images/avatar.png';
    }

	if($uid>0 && $uid == $_G['uid']){
		if($_G['member']['picurl']) return $_G['member']['picurl'];
	}

    $name = $uid;
    if (!$uid) {
        $name = $_G['uid'];
    }
    if (!$uid) {
        $name = cutstr(md5($user_name), 5, '');
    }

    $path = 'assets/' . $_G['setting']['template'] . '/avatars/' . $name . '.png';
    if (file_exists(ROOT_PATH . $path)) {
        return $path;
	   //dmkdir(ROOT_PATH .'assets/' . $_G['setting']['template'] . '/avatars/');
    }

	$dir = dirname(ROOT_PATH . $path);
	if(!is_dir($dir)) dmkdir($dir);
    $atavar_type = $_G['setting']['avatar_type'];

    if ($atavar_type == 1) {
        if (!class_exists('MDAvtars')) {
            require_once ROOT_PATH . "web/lib/md_avtars/MaterialDesign.Avatars.class.php";
        }
        $Avatar = new MDAvtars($user_name, $size);
        $Avatar->Save(ROOT_PATH . $path, $size);
        $Avatar->Free();
    } elseif ($atavar_type == 2) {
        if (!class_exists('Identicon')) {
            require_once ROOT_PATH . "web/lib/generator_avatar/Identicon.php";
        }
        $identicon = new Identicon();
        $identicon->save($user_name, ROOT_PATH . $path, $size);
    }
    return $path;
}

/*
	保存历史浏览记录,最多保存20条
	@cookies name
	@保存的id
	return void
*/
function save_history($name,$id){
		global $_G;
		if(!$name || !$id) return false;
		if(!in_array($name,$_G['setting']['history_views'])) return ;
		$name .='_views';
		$ids = C($name);
		if($ids){
			$ids = explode(',',$ids);
			$ids = array_filter($ids);
			$ids = array_unique($ids);
			if(!in_array($id,$ids)){
				$ids =array_slice($ids,-20);
			}
		}else{
			$ids = array();
		}
		if(!in_array($id,$ids)){
			$ids[] = $id;
			C($name,implode(',',$ids),86400*30);
		}

}
/*
	获取历史浏览记录
	@cookies name
	@ 获取的个数
	@ return string
*/

function get_history($name,$len){
		global $_G;
		if(!$name)return false;
		if(!in_array($name,$_G['setting']['history_views'])) return ;

		$name .='_views';
		$ids = C($name);
		if(!$ids)return false;
		if(!$len) return $ids;

		$ids = explode(',',$ids);
		$ids = array_filter($ids);
		$ids = array_unique($ids);
		$data =array_slice($ids,0-$len);
		return implode(',',$data);
}


//给用户资金增加记录
//$ext['money_type']
function add_money($to_uid,$type,$add_money,$desc){
	$tb = table('money');
	if(!$tb ||  count($tb) == 0) return false;
	if(!$to_uid) return false;
	$user = getuser($to_uid,'uid');
	if(!$user['uid']) return false;
	$arr = array();
	$arr['uid'] = $to_uid;
	$arr['username'] = $user['username'];
	$arr['money'] = $add_money;
	$arr['org_money'] = $user['money'];
	$arr['desc'] = $desc;
	$arr['type'] = $type;
	$arr['dateline'] = TIMESTAMP;
	$id = DB::insert('money',$arr,1);
	if($id>0 && $add_money !=0){
		$rs = array();
		$rs[money] = $user['money'] + $add_money;
		update_member($rs,$to_uid);
	}
	return $id;

}


//快速发布评论,可用于申诉等环境,无须审核,不加积分,只适用简单的文字,不能加HTML
function post_comment($uid,$type,$id,$content,$is_reply=0){
			$fd = table('comment');
			if(!$fd || count($fd) == 0 ) return false;
			$arr = array();
			$arr['uid']  = $_G[uid];
			$arr['username']  = $_G[username];
			$arr['dateline']  = TIMESTAMP;
			$arr['ip']  = $_G[clientip];
			$arr['type_id']  = $id;
			$arr['type']  = $type;
			$arr['content']  = $content = trim_html($content,1);

			if($is_reply>0){
				$arr['is_reply']  = 1;
				$arr['reply_id']  = intval($is_reply);
			}
			$arr['picurl']  = '';
			$arr['check']  =1;
			$insert_id = DB::insert('comment',$arr,1);
			return $insert_id;
}

//商家将普通用户加入黑名单
function black_add($seller_uid,$to_uid,$desc,$check_seller=true){
		$tb = table('black');
		if(!$tb) return false;

		if(!$seller_uid) msg('加入黑名单失败,商家uid不能为空');
		if(!$to_uid) msg('加入黑名单失败,被列为黑名单的用户uid不能为空');


		if(black_check($seller_uid,$to_uid)) msg('当前用户已被您加入黑名单,无须再次增加');

		$seller = getuser($seller_uid,'uid');

		if($seller_uid == -1){
			$seller_name = '系统';
		}else{
			$seller_name = $seller['username'];
			if(!$seller['uid'])msg('商家不存在');
			if($check_seller && $seller['seller'] !=1) msg('非商家无法进行操作');
		}
		$user = getuser($to_uid,'uid');
		if(!$user['uid'])msg('被列为黑名单的用户不存在');

		$arr = array();
		$arr['seller_uid'] = $seller_uid;
		$arr['seller_username'] = $seller_name;
		$arr['uid'] = $user['uid'];
		$arr['username'] =$user['username'];
		$arr['desc'] = $desc;
		$arr['dateline'] = TIMESTAMP;
		return 	DB::insert('black',$arr);
}

//检查用户是否在商家的黑名单中
function black_check($seller_uid,$check_uid){
		$tb = table('black');
		if(!$tb) return false;
		$rs = DB::fetch_first("SELECT id FROM ".DB::table('black')." WHERE uid=".$check_uid." AND seller_uid = ".$seller_uid);
		return $rs['id']>0 ;
}

function is_login(){
		global $_G;

		if(!$_G[uid]) {
			msg('您必须登录后才能进行操作','error','m=member&a=login');
		}else if($_G[member][groupid] == 3){
				msg('抱歉,您当前是禁止用户,无法继续操作','error');
		}else if($_G[member][check] == 0){
				msg('抱歉,您当前账号未审核无法继续操作','error');
		}
		return true;
}


function check_user_power(){
		global $_G;
		is_login();
		if($_G[member][groupid] == 3){
				msg('抱歉,您当前是禁止用户,无法继续操作','error');
				return false;
		}else if($_G[member][check] == 0){
				msg('抱歉,您当前账号未审核无法继续操作','error');
				return false;
		}

}

if (!function_exists('getallheaders')){
    function getallheaders() {
        $headers = '';
       foreach ($_SERVER as $name => $value){
           if (substr($name, 0, 5) == 'HTTP_'){
		 	$new_key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
			//$akey = strtolower($new_key);
			//if(in_array($akey,array('ime','auth','deviceid','version','build'))) $new_key=$akey;
		      $headers[$new_key] = $value;
           }
       }
       return $headers;
    }
}

function ajaxoutput($goods_list,$check_field = true){
		global $_G;

		if(isset($_GET['json']) && $_GET['json'] ==1 && $_G['setting']['ajax_goods_list']){

				$data = array();
				if($check_field){
					$fd = explode(',',$_G['setting']['ajax_goods_field']);
					foreach($goods_list as $k=>$v){
						$tmp = array();
						foreach($fd as $v1){
							$tmp[$v1] = $v[$v1];
						}
						$data[] = $tmp;
					}
				}else{
					$data=$goods_list;
				}
			json(array('status'=>'success','data'=>$data));
		}
}


function push($data,$extar){
	global $_G;
	//有时推送会报502 ,原因是curl问题 .切换一下php版本即可.

	if(!$_G['setting']['push_appkey'] || !$_G['setting']['push_secret_key']) msg('推送接口未配置');

	if(!$_G['setting']['app_push']){
		return '系统未开启推送功能';
	}
	$class = $_G['setting']['app_push'].'_push';

	if($class == '') msg('未找到推送的接口');
	if(!class_exists($class))include_once ROOT_PATH.'inc/class/push/'.$class.'.class.php';
	$push = new $class($_G['setting']['push_appkey'],$_G['setting']['push_secret_key'],$_G['setting']['push_appkey_ios'],$_G['setting']['push_secret_key_ios']);

	$push->set_title($data['title']);
	$push->set_type($data['type']);
	$push->set_content($data['content']);
	$push->set_android($data['android']);
	$push->set_ios($data['ios']);
	if(is_array($extar)) $push->set_extar($extar);
	return  $push->send();
}


function download_image($url,$filename='',$type=0,$upload = true){
			global $_G;
			if($url=='')return false;

			$dir = ROOT_PATH . 'assets/tmp/';
			if(is_dir($dir)) dmktime($dir);

			if($filename==''){
				$ext=strrchr($url,'.');
				if($ext!='.gif' && $ext!='.jpg') $ext = '.jpg';
				$filename=random(10).$ext;
			}
			$filename = $dir.$filename;
			//文件保存路径
			if($type){
				  $ch=curl_init();
				  $timeout=5;
				  curl_setopt($ch,CURLOPT_URL,$url);
				  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
				  $img=curl_exec($ch);
				  curl_close($ch);
			}else{
				 ob_start();
				 readfile($url);
				 $img=ob_get_contents();
				 ob_end_clean();
			}
			$size=strlen($img);
			if($size ==0) return false;

			//文件大小
			$fp2=@fopen($filename,'a');
			fwrite($fp2,$img);
			fclose($fp2);
			if($upload && $_G['setting']['upload_url'] !='web'){
				$src  = upload($filename);
				if($src && is_string($src)) {
					@unlink($filename);
					return $src;
				}
			}
			$filename = str_replace(ROOT_PATH,$_G['siteurl'],$filename);

			return $filename;
		}


function filter_utf8_char($ostr){
    preg_match_all('/[\x{FF00}-\x{FFEF}|\x{0000}-\x{00ff}|\x{4e00}-\x{9fff}]+/u', $ostr, $matches);
    $str = join('', $matches[0]);
    if($str==''){   //含有特殊字符需要逐個處理
        $returnstr = '';
        $i = 0;
        $str_length = strlen($ostr);
        while ($i<=$str_length){
            $temp_str = substr($ostr, $i, 1);
            $ascnum = Ord($temp_str);
            if ($ascnum>=224){
                $returnstr = $returnstr.substr($ostr, $i, 3);
                $i = $i + 3;
            }elseif ($ascnum>=192){
                $returnstr = $returnstr.substr($ostr, $i, 2);
                $i = $i + 2;
            }elseif ($ascnum>=65 && $ascnum<=90){
                $returnstr = $returnstr.substr($ostr, $i, 1);
                $i = $i + 1;
            }elseif ($ascnum>=128 && $ascnum<=191){ // 特殊字符
                $i = $i + 1;
            }else{
                $returnstr = $returnstr.substr($ostr, $i, 1);
                $i = $i + 1;
            }
        }
        $str = $returnstr;
        preg_match_all('/[\x{FF00}-\x{FFEF}|\x{0000}-\x{00ff}|\x{4e00}-\x{9fff}]+/u', $str, $matches);
        $str = join('', $matches[0]);
    }
    return $str;
}
?>
