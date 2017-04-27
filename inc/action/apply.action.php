<?php
if(!defined('IN_TTAE')) exit('Access Denied TTAE');

class apply extends app{


	function info(){
		seo('商家报名中心');
		$this->show();
	}

	function main(){
		global $_G;

		seo('商家报名');
		if($_G['setting']['bm']==0){
			msg('抱歉,系统关闭了商家报名功能,暂时无法进行报名操作','error');
		}
		if($_G[setting][bm_login] ==1) is_login();


		$goods = get_filed('apply');
		$readonly = '';

				if($_GET['onsubmit'] && check() ){		//发布商品


					if(!check_yzm($_GET['yzm'])){
						msg('验证码效验失败,请重新输入','error');
					}

						$picurl = trim($_GET['postdb']['picurl']);
						if(!preg_match("/^http:\/\//",$picurl)){
							msg('抱歉,图片格式不正确,请重新提交');
							return false;
						}


						$title  = trim($_GET['postdb']['title']);
						if(!$title){
							msg('抱歉,商品标题不存在');
						}
						$num_iid  = ($_GET['postdb']['num_iid']);
						if(!get_goods_id($num_iid)) msg('商品id不正确');



						if(!$num_iid){
							msg('抱歉,商品ID不存在');
						}else{
							$rs =DB::fetch_first("SELECT id FROM ".DB::table('apply')." WHERE num_iid='$num_iid'");
							if($rs['id']>0){
								msg('禁止重复报名,您所提交的商品已报名了');
							}

							$rs2 =DB::fetch_first("SELECT aid FROM ".DB::table('goods')." WHERE num_iid='$num_iid'");
							if($rs['aid']>0){
								msg('您所提交的商品已存在了');
							}

						}


						$arr =  get_filed('apply',$_GET['postdb']);
						 $nick = trim($arr[nick]);
						  if($_G[setting][apply_user] == 1 && $nick){

							if(!is_login(1) || !$_G['username']){
								$web = '站点';
								msg('您必须先登录'.$web.'后,才可进行报名');
							}

								 $s_name = mb_substr($_G['username'],0,1,'utf-8');
								 $s_nick = mb_substr($nick,0,1,'utf-8');

							 if($s_name != $s_nick){
								 $msg = '您当前登录淘宝的账号和当前提交商品的卖家不属同一账号,请用当前商品的卖家主旺旺登录淘宝才可提交报名';
								 msg($msg);
							 }
						  }


						if($_G[setting][apply_max]>0 && $nick){
						 	 $count = getcount('goods'," nick = '".$nick."'");
						 	 if($count>=$_G[setting][apply_max]){
							  $msg = '抱歉,系统设置同一卖家店铺,最多能报名'.$_G[setting][apply_max].'款商品,您已到达最多限制,无法报名';
							    msg($msg);
							 }
					 	 }

						  if($_G[setting][bm_black] && $nick){
						   $user = explode(',',$_G[setting][bm_black]);
					  		if(in_array($nick,$user)){
								  msg('抱歉,当前店铺已被列为黑名单,禁止此店铺所有商品报名');

							}
					    }
						$arr['uid'] = $_G['uid'];
						$arr['images']  = $_GET['images'];
						$arr['check']  = 0;
						$arr['title']  = cutstr($arr[title],60,'');
						$arr['dateline']  = TIMESTAMP;
						if($_FILES[file]){
								$pic =upload();
								if($pic)$arr[picurl] = $pic;
						}


						$picurl = trim($arr['picurl']);
						/*if(!preg_match("/^http:\/\//",$picurl)){
							msg('抱歉,图片格式不正确,请重新提交');
							return false;
						}*/

						$arr = daddslashes($arr);
						DB::insert('apply',$arr);

						//top('goods','insert',$arr);
						msg('报名成功！请耐心等待审核（2个工作日内）','success',URL.'m='.__CLASS__.'&a='.__FUNCTION__);

				}elseif($_GET['get_submit'] && check() && $_GET['goods_id']){
					//提交ID采集商品
					  if(get_goods_id(trim($_GET['goods_id']))){
						  $goods_id =get_goods_id(trim($_GET['goods_id']));
					  }

					  if(!$goods_id) {
						  msg('抓取失败,商品ID或链接不存在或填写错误');
						  return false;
						}
					  $gd = top('goods','get_goods',$goods_id);
					  $nick = trim($gd[nick]);
					 //同一账号验证
					  if($_G[setting][apply_user] == 1 && $nick ){
						if(!is_login() || !$_G['username']){
							$web = '站点';
							msg('您必须先登录'.$web.'后,才可进行报名');
							return false;
						}

							 $s_name = mb_substr($_G['username'],0,1,'utf-8');
							 $s_nick = mb_substr($nick,0,1,'utf-8');

						 $msg = '您当前登录淘宝的账号和当前提交商品的卖家不属同一账号,请用当前商品的卖家主旺旺登录淘宝才可提交报名';
						 msg($msg,'error');
						 return false;
					  }

					  if($_G[setting][apply_max]>0 && $nick){
						  $count = getcount('goods'," nick = '".$nick."'");
						  if($count>=$_G[setting][apply_max]){
							  $msg = '抱歉,系统设置同一卖家店铺,最多能报名'.$_G[setting][apply_max].'款商品,您已到达最多限制,无法报名';
							    msg($msg,'error');
								return false;
						 }
					  }

					   if($_G[setting][bm_black] && $nick){
						   $user = explode(',',$_G[setting][bm_black]);
					  		if(in_array($nick,$user)){
								  msg('抱歉,当前店铺已被列为黑名单,禁止报名');
								return false;
							}
					    }

					  $gd[goods_id] = $goods_id;
					  $gd['start_time'] =0;
					  $gd['end_time'] = 0;

					  foreach($gd as $k=>$v){
						  $goods[$k] = $v;
					  }
					  if($_G['setting']['bm_edit']==0){
						$readonly = "readonly='readonly'";
					 }

				}else{
					$_GET[goods_id] = '';
				}

		$this->add(array('goods'=>$goods,'readonly'=>$readonly));
		$this->show();
	}
	function apply_check_ajax(){
			global $_G;
			$id = get_goods_id($_GET['num_iid']);
			$id = daddslashes($id);

			if(!$id){
				json("商品ID为空或格式不正确");
				return false;
			}else{
				$goods = DB::fetch_first("SELECT * FROM ".DB::table('apply')." WHERE num_iid = '$id'");
				if(!$goods[id])json("抱歉,您要查询的商品不存在");
					$msg = '';
					if($goods[check] ==0 ){
						json("抱歉,您要查询的商品当前为待审核");
					}else if($goods[check] ==2){
						json("抱歉,您要查询的商品未通过审核<br/>原因: ".$goods[check_msg]);
					}
					$msg ="您报名的商品 ".$goods[title]."审核已通过.";
					if($goods[start_time]==0 && $goods[end_time]==0){
						$msg.="状态:现在已正常显示.";
					}elseif($goods[start_time]>0){
						 $msg.="上线时间为:".dgmdate($goods[start_time],'dt');
					}
					if($goods[end_time]>0){
						 $msg.="下线时间为:".dgmdate($goods[end_time],'dt');
					}
					json(array('status'=>'success','msg'=>$msg));
			}

	}

	function bm_check(){
			global $_G;

			$goods = array();
			$kw = '';
			if($_GET['onsubmit'] && check() && $_GET[kw]){
				$types = array('num_iid','title','nick','qq','phone');
				if(!in_array($_GET['type'],$types)){
					msg('抱歉,查询的字段不存在','error','m=apply&a=bm_check');
					return false;
				}
				$kw = ($_GET['kw']);
				if(!$kw){
					msg('抱歉,要查询的关键字不能为空');
					return false;
				}

				if($_GET['type'] == 'num_iid'){
					$num_iid = get_goods_id($_GET['kw']);
					if(!$num_iid){
						msg('商品ID为空或格式不正确');
						return false;
					}
					$and .= " AND num_iid = '".$num_iid."'";
				}elseif($_GET['type'] == 'title'){
					$and .= " AND title = '".$kw."'";
				}elseif($_GET['type'] == 'nick'){
					$and .= " AND nick = '".$kw."'";
				}elseif($_GET['type'] == 'qq'){
					$and .= " AND qq = '".$kw."'";
				}elseif($_GET['type'] == 'phone'){
					$and .= " AND phone = '".$kw."'";
				}else{
					msg('抱歉,查询的字段不存在');
				}
				$goods = D(array('and'=>$and,'limit'=>30,'table'=>'apply'));
				if(!$goods){
					msg('抱歉,您要查询的商品不存在','error');
					return false;
				}
				$this->add(array('search'=>1));

			}
			seo('商家报名中心');
			$this->add(array('goods'=>$goods,'kw'=>$kw));
			$this->show();
	}



}
?>
