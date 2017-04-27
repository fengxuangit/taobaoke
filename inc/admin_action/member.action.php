<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class member extends app{	


		function power(){
         global $_G;
				$this->show();
		}
		
		function group(){
         global $_G;
				$this->show();
		}
		function group_del(){
         global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要删除的ID不存在','error',"m=member&a=group");
						 return false;
					}
					$id = intval($_GET['id']);
					
					if($_G['group'][$id]['system'] ==1)cpmsg('系统级别的用户组无法删除','error',"m=member&a=group");
					
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前的用户组吗?删除后不可恢复?当前所有的用户将全部成为 普通用户组成员','error',
							"m=member&a=group_del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=member&a=group'>取消</a></p>");

					}else{
						DB::update('member',array('groupid'=>10),'groupid='.$id);
						DB::delete('group','id='.$id);
						loadcache('group','update');		
						cpmsg('删除成功','success',"m=member&a=group");

					}
		}
		
		
		function group_post(){
        	 global $_G;
			 $group = array();
			  if($_GET['id']){
				 if($_G[id] ==1)cpmsg('管理员佣有所有权限,无法编辑','error','m='.__CLASS__.'&a=group');
				$group = $_G['group'][$_G[id]];				
				
			 }
			 
			 if($_GET['onsubmit'] && check() ){
				
				
							$arr = array();
							
							$arr['name'] = $_GET['name'];	
							if($group['system'] ==1) unset($arr['name']);
							$arr['login_admin'] =intval($_GET[login_admin]);	
							$arr['picurl'] = $_GET['picurl'];	

							$arr['jf_min'] = intval($_GET['jf_min'])	;
							$arr['jf_max'] = intval($_GET['jf_max'])	;
							$arr['fanli'] = intval($_GET['fanli'])	;
							
							if($_FILES[file]){	
								$pic  = upload();
								if($pic) $arr[picurl] = $pic;
							}
							$arr['power'] ='';
							if(count($_GET[model])>0){
								$power = array();
								foreach($_GET[model] as $k=>$v){
									$power[$k] = $_GET[$k];
								}
								if($power) {
									$arr['power'] = serialize($power);	
								}
							}
							
							//普通会员组,无法设置范围.
							if($_GET['id'] == 10){
								$arr['jf_min'] =0;
								$arr['jf_max']=0;
								$arr['login_admin'] =0;
								$arr['power'] = '';
							}
							
					 if($_GET['id']){
						 
						 DB::update('group',$arr,'id='.$_G['id']);
						 $msg = '修改';
					 }else{
						 $arr['dateline'] = TIMESTAMP;
						  DB::insert('group',$arr);
						  $msg = '添加';
					}
					loadcache('group','update');
					cpmsg( $msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__."&id=".$_G[id]);
				 
			 }
			
			
			$menu = $_G['menu'];
			foreach($menu as $k=>$v){
				$menu[$k]['select'] = 0;
				if(array_key_exists($k,$group[power]))  $menu[$k]['select'] = 1;
					//dump($v[name]);
					foreach($v['nav'] as $k1=>$v1){
						if(array_key_exists($v1['a'],$group[power][$k]) ){
							$menu[$k]['nav'][$k1]['select'] = 1;
						}else{
							$menu[$k]['nav'][$k1]['select'] = 0;
						}						
					}					
			}
			$is_show = 1;
			if($_GET['id'] && in_array($_GET['id'],array(1,2,3,4,19,20,21,22))){
				$is_show = 0;
			}
			
			$this->add(array('group'=>$group,'user_menu'=>$menu,'is_show'=>$is_show)); 
			$this->show();
		}
		
	function main(){
					global $_G;

					if($_GET['onsubmit'] && check() ){
							foreach($_GET[ids] as $k=>$v){
								$id = intval($v);
								if($_GET[del][$k] ==0) continue;
								if($_GET['_del_all']==1 && $_GET['del'][$k]){									
									delete_member($id);

								}
							}
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
					}
				$size = 30;
				$start = ($_G['page']-1)*$size;
				$url ='';
				$and = '';
				
				
				if($_GET[groupid]>0){
					$groupid = intval($_GET[groupid]);
					$and .= " AND groupid = ".$groupid;
					$url.="&groupid=".$groupid;
				}
				if($_GET[uid]>0){
					$uid = intval($_GET[uid]);
					$and .= " AND uid = ".$uid;
					$url.="&uid=".$uid;
				}
				
				if($_GET[phone]){
					$phone = trim_html(($_GET[phone]),1);
					$and .= " AND phone = ".$phone;
					$url.="&phone=".$phone;
				}
				if($_GET[jf_min]>0){
					$jf_min = intval($_GET[jf_min]);
					$and .= " AND jf >= ".$jf_min;
					$url.="&jf_min=".$jf_min;
				}
				if($_GET[jf_max]>0){
					$jf_max = (intval($_GET[jf_max]));
					$and .= " AND jf <= ".$jf_max;
					$url.="&jf_max=".$jf_max;
				}
				if(isset($_GET[check])){
					$check = (intval($_GET[check]));
					$and .= " AND `check` = ".$check;
					$url.="&check=".$check;
				}
				if(isset($_GET[seller])){
					$seller = (intval($_GET[seller]));
					$and .= " AND `seller` = ".$seller;
					$url.="&seller=".$seller;
				}
				
				if(($_GET[wangwang])){
					$wangwang = (($_GET[wangwang]));
					$and .= " AND `wangwang` = ".$wangwang;
					
					$url.="&wangwang=".$wangwang;
				}
				
				if(($_GET[qq])){
					$qq = (intval($_GET[qq]));
					$and .= " AND `qq` = ".$qq;
					$url.="&qq=".$qq;
				}
				if(($_GET[email])){
					$email = (trim($_GET[email]));
					$and .= " AND `email` = '$email'";
					$url.="&email=".$email;
				}
				if(($_GET[phone])){
					$phone = (trim($_GET[phone]));
					$and .= " AND `phone` = '$phone'";
					$url.="&phone=".$phone;
				}
				if(($_GET[alipay])){
					$alipay = (trim($_GET[alipay]));
					$and .= " AND `alipay` = '$alipay'";
					$url.="&alipay=".$alipay;
				}
				
				if(($_GET[order_number])){
					$order_number = (trim($_GET[order_number]));
					$and .= " AND `order_number` = '$order_number'";
					$url.="&order_number=".$order_number;
				}
				
				if(($_GET[t_user_name])){
					$t_user_name = (trim($_GET[t_user_name]));
					
					$t_uid = DB::result_first("SELECT uid FROM ".DB::table('member')." WHERE username = '$t_user_name'");
					if($t_uid>0){
						$and .= " AND `t_uid` = ".$t_uid;
						$url.="&t_uid=".$t_uid;
					}
				}				
				
				if(($_GET[t_uid])){
					$t_uid = (intval($_GET[t_uid]));
					$and .= " AND `t_uid` = ".$t_uid;
					$url.="&t_uid=".$t_uid;
				}
			
				if($_GET['username']){
					$username = trim_html(trim($_GET[username]));					
					//$and .= " AND (username = '$username'  or  `nick` =  '$username' )";
					$and.=" AND ( `username` LIKE '%".$username."%' )";
					$url.="&username=".urlencode_utf8($_GET[username]);
			  }
				
				$sql = make_sql('member');
				$sql['and'].= $and;
				$sql['url']= 'm=member&a=main'.$sql['url'];
				$sql['table']='member'; 
				//$member_list =DB::fetch_all("SELECT * FROM ".DB::table(__CLASS__)." where 1 $and  ORDER BY uid DESC LIMIT $start,$size");	
				$member_list =D($sql,array('size'=>40,'url'=>$sql[url]));
				
				//$count = getcount(__CLASS__,$and);
				//$showpage = multi($count,$size,$_G[page],URL."m=member&a=main".$url);
				
				if(!isset($_GET[order])) $sql['order'] = ' uid DESC ';
				
				foreach($member_list[goods] as $k=>$v){

					if(array_key_exists('sign',table('member'))){
						$member_list[$k][sign] = getcount('sign',"uid = ".$v[uid]." AND type = 'sign'");					
					}else{
						$member_list[$k][sign] = 0;
					}				
				}
				
				$this->add($member_list);
				$this->show('member/main');
	}
	function search(){
		if($_GET['onsubmit_search']){
			$this->main();
		}else{
			$this->show();
		}
	}
	function info(){
		global $_G;
		$uid = intval($_GET[uid]);
		$user = getuser($uid,'uid');
		
		if(!$user[uid]){
			json(array('status'=>'error','msg'=>'未找到用户信息'));
			return false;
		}
		
		
		$admin	=	$user[admin]==1 ? '是':'否';		
		$wangwang='';
		if($user[wangwang]){
			$w= urlencode_utf8($user[wangwang]);
			$wangwang = '<a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&touid='.$w.'&siteid=cntaobao&status=1&charset=utf-8" >
			<img border="0" src="http://amos.alicdn.com/online.aw?v=2&uid='.$w.'&site=cntaobao&s=1&charset=utf-8" alt="点击这里给我发消息" /></a>';
		}
		$user[regdate] = dgmdate($user[regdate],'u');
		$text = "
		用户名:		$user[username]	<br/>

		是否管理员:	$admin			<br/>
		旺旺:		$wangwang		<br/>		
		电话:		$user[phone]	<br/>
		收货地址:	$user[address]	<br/>
		留言或介绍信息:	$user[content]	<br/>
		注册IP:		$user[regip]	<br/>
		注册时间:	$user[regdate]	<br/>";
		//$text .= '编辑会员信息:	<a href="'.URL.'m=member&a=post&uid='.$user[uid].'" target="_blank">点击修改</a><br/>';		
		json(array('status'=>'success','msg'=>$text));
		
	}

	function post(){
					global $_G;
					
					$login_type = array();
					$t = array();
					if($_GET['onsubmit'] && check() ){
						
							$arr = get_filed(__CLASS__,$_GET['postdb'],$_GET[uid]);
							$arr['auto_update'] =intval($_GET['postdb']['auto_update']);
							$arr[jf] = intval($arr[jf]);							
							if($_GET[password]){
								$password = trim($_GET[password]);
								$arr['key'] = random(10);
								$arr[password] =md5(md5($password).$arr['key']);
							}else{
								unset($arr[password]);
							}
							if($_FILES[file]){	
							
								if($pic) $arr[picurl] = $pic;
							}
							$org_money = intval($_GET['org_money']);
							$money = intval($arr['money']);
							
							$tb = table('money');
							if($tb &&  count($tb) > 0) 	unset($arr['money']);
							
							$url = 'm=member&a=post';
							$msg = '添加会员成功';
							
							if($_GET[uid]>0){
								unset($arr['username']);
								$uid = intval($_GET['uid']);
								update_member($arr,$uid);			
								$url.="&uid=".$uid;
								$msg = '编辑成功';
							}else{					
								$uid = DB::insert('member',$arr,true);								
							}
							
							if($money != $org_money  ){								
									$ml = $money-$org_money;
									if($money > $org_money){	//新增加余额
										
										add_money($uid,2,$ml,'系统增加账户余额'.$ml);
									}else{					//扣除余额										
										add_money($uid,1,$ml,'系统扣除账户余额'.$ml);
									}
							}
							
							cpmsg($msg,'success',$url);
							return false;
					}elseif($_GET['uid']>0){
							$uid = intval($_GET['uid']);
							$mb = getuser($uid,'uid');
							foreach($mb as $k=>$v){						
								$member[$k] = $v;
							}

							$login_type = array('qq'=>'qq','weibo'=>'微博','taobao'=>'淘宝');
							
							if($member[t_uid]>0){
								$t = getuser($member[t_uid],'uid');
							}
					}else{
						$member = get_filed(__CLASS__);
					}

					$this->add(array('member'=>$member,'login_type'=>$login_type,'t'=>$t));
					$this->show();
	}
	function del(){
					global $_G;
					if(!$_GET['uid']){
						 cpmsg('抱歉,要删除的会员ID不存在','error',"m=member&a=main");
						 return false;
					}
					$uid = intval($_GET['uid']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前的会员吗?删除后不可恢复?','error',"m=member&a=del&ok=1&uid=".$uid,'确定删除',"<p><a href='".URL."m=member&a=main'>取消</a></p>");
						return false;
					}else{
						$user = getuser($uid,'uid');						
						delete_member($uid);
						cpmsg('删除成功','success',"m=member&a=main");
						return false;
					}
	}
	
	

	
}
?>

