<?php
if(!defined('IN_TTAE')) exit('Access Denied');
$ext = array();
$ext['comment_types']	= array();

$ext['jf_type'] 		= array('system'=>'系统奖励','sign'=>'签到积分','yaoqing'=>'邀请任务','share'=>'内容分享','favorite'=>'添加收藏','duihuan'=>'积分兑换');
$ext['duihuan_status']	= array('待审核','已拒绝','已通过待兑换','已兑换成功');
$ext['goods_status']	= array('通用','正常上架','活动到期','预告商品','优惠券到期','无优惠券','非二合一','低佣金','价格有误','卖家下架','信息有误','被举报','其它');

$ext['favorite_types']	= array('goods'=>'商品','style'=>'搭配');
$ext['like_types']		= array('goods'=>'商品','style'=>'搭配');
$ext['share_types']		= array('goods'=>'商品','style'=>'搭配');
$ext['history_views'] 	= array('goods');
$ext['order_status'] 	= array(0=>'待结算',1=>'待认领',2=>'已失效',3=>'已认领');
$ext['order_status'] = array(0=>'待审核',1=>'待用户认领',2=>'已失效',3=>'已返积分',4=>'待返积分');											//返利订单类型

$ext['money_type']  = array(0=>'购物返现',1=>'系统扣除',2=>'系统增加',3=>'用户冲值',4=>'用户提现');						//资金记录类型
$ext['tixian_status'] = array(0=>'提现申请',1=>'已提现成功',2=>'提现失败');


$ext['share_type_callback']= array('mshare'=>'一键分享','qzone'=>'QQ空间','tsina'=>'新浪微博','renren'=>'人人网','tqq'=>'',
								'kaixin001'=>'开心网','douban'=>'豆瓣网','sqq'=>'QQ好友','weixin'=>'微信');
$ext['get_tag'] = true;
$ext['avatar_type'] = 2;	//用户头像
$ext['favorite_jf'] = 1;	//收藏增加积分
$ext['like_jf'] = 1;		//喜欢商品增加积分
$ext['api'] = 0;

$ext['ajax_goods_list'] = true;
$ext['ajax_goods_field'] = 'aid,fid,num_iid,title,nick,picurl,url,price,start_time,end_time,yh_price,like,shop_type,sum,zk,status_text,status,over,new,id_url,juan_price,juan_url';

$ext['sms']['signature_id'] = 0;
$ext['sms']['template'] = array('code'=>'0','change_password'=>'0');

$ext['nav'] = array(1=>'一级导航',2=>'二级导航',3=>'侧边导航',4=>'APP模板1首页导航');


$ext['app_tpl'] = array(
					'goods'=>array(
						array('name'=>'两商品一行','pic'=>'1','tpl_name'=>'goods_list_0'),
						array('name'=>'单商品一行1','pic'=>'1','tpl_name'=>'goods_list_1'),
						array('name'=>'单商品一行2','pic'=>'1','tpl_name'=>'goods_list_2')
					),'channel'=>array(
						array('name'=>'一行4个分类','pic'=>'1','tpl_name'=>'channel_list_0'),
						array('name'=>'一行展示所有','pic'=>'1','tpl_name'=>'channel_list_1'),
					),'img'=>array(
						array('name'=>'默认模板','pic'=>'1','tpl_name'=>'img_list_0'),
					),'style'=>array(
						array('name'=>'默认模板','pic'=>'1','tpl_name'=>'style_list_0'),
					),
			);


?>
