<?php
if(!defined('IN_TTAE')) exit('Access Denied');
$menu = array();
$menu['admin'] = array(
		'type'=>1,
		'name'=>'站点配置',
		'nav'=>array(
			array('name'=>'站点配置',		'a'=>'setting'),
			array('name'=>'全局配置',		'a'=>'config'),
			array('name'=>'标签分类',		'a'=>'tag'),
			array('name'=>'采集配置',		'a'=>'caiji'),
			array('name'=>'全局SEO配置',	'a'=>'seo_setting'),
			array('name'=>'页面SEO配置',	'a'=>'page_seo'),

			array('name'=>'签到设置',		'a'=>'sign'),
			array('name'=>'积分设置',		'a'=>'share'),
			array('name'=>'邮件设置',		'a'=>'email',),
			array('name'=>'登录组件',		'a'=>'login_setting'),
			array('name'=>'手机版',			'a'=>'mobile'),
			array('name'=>'注册登录',		'a'=>'reg'),
			array('name'=>'短信设置',		'a'=>'sms'),
	
		)
);

$menu['apps'] = array(
		'type'=>1,
		'name'=>'app设置',
		'nav'=>array(
				array('name'=>'首页幻灯片',		'a'=>'hdp'		),
				array('name'=>'首页六宫格',		'a'=>'gezi'		),
				array('name'=>'二级导航',		'a'=>'nav'		),
				array('name'=>'版本配置',		'a'=>'version'	),
				array('name'=>'模板设置',		'a'=>'tpl'	),
				array('name'=>'其它设置',		'a'=>'other'	),
				array('name'=>'接口安全',		'a'=>'api'	),
				array('name'=>'消息推送',		'a'=>'push'	),
						array('name'=>'在线客服',		'a'=>'im'),
						array('name'=>'APP统计',		'a'=>'count'),
		)
);
$menu['nav'] = array(
		'type'=>1,
		'name'=>'导航管理',
		'nav'=>array(
			array('name'=>'导航管理',		'a'=>'main'),
			array('name'=>'添加导航',		'a'=>'post'),
			array('name'=>'批量添加导航',	'a'=>'batpost'	,'type'=>	1),
		)
);


$menu['channel'] = array(
		'type'=>1,
		'name'=>'栏目管理',
		'nav'=>array(
			array('name'=>'栏目管理',		'a'=>'main'),
			array('name'=>'添加栏目',		'a'=>'post'),
			array('name'=>'批量添加栏目',	'a'=>'batpost'),
		)
);


$menu['goods'] = array(
		'type'=>1,
		'name'=>'商品管理',
		'nav'=>array(
			array('name'=>'商品管理',		'a'=>'main'),
			array('name'=>'添加商品',		'a'=>'post'),
			array('name'=>'分类管理',		'a'=>'cate'),
			array('name'=>'添加分类',		'a'=>'cate_post'),
			array('name'=>'商品搜索',		'a'=>'search'),
			array('name'=>'商品设置',		'a'=>'setting'),
			array('name'=>'商品自动检查',		'a'=>'goods_check'),
			array('name'=>'商品导入',		'a'=>'import'),
			array('name'=>'优惠券导入',		'a'=>'quan_import'),
			array('name'=>'大淘客优惠券设置',		'a'=>'quan_setting'),
			array('name'=>'淘口令生成',			'a'=>'tkl'),
			array('name'=>'更新全站商品',		'a'=>'update_goods'),

		)
);
$menu['apply'] = array(
		'type'=>2,
		'name'=>'商品审核',
		'nav'=>array(
			array('name'=>'投稿管理',		'a'=>'main'),
			array('name'=>'投稿设置',		'a'=>'setting'),
		)
);
$menu['fetch'] = array(
		'type'=>2,
		'name'=>'商品采集',
		'nav'=>array(
			array('name'=>'规则列表',		'a'=>'main'),
			array('name'=>'添加规则',		'a'=>'post'),
			array('name'=>'联盟商品采集',		'a'=>'lianmeng_list'),

		)
);
$menu['img'] = array(
	'type'=>2,
	'name'=>'值得买',
	'nav'=>array(
		array('name'=>'值得买',			'a'=>'main'),
		array('name'=>'添加值得买',		'a'=>'post'),
		array('name'=>'搜索',			'a'=>'search'),
		array('name'=>'SEO设置',		'a'=>'seo_setting'),
				array('name'=>'分类管理',		'a'=>'cate'),
		array('name'=>'添加分类',		'a'=>'cate_post')
	)
);

$menu['style'] = array(
	  'type'=>2,
	  'name'=>'搭配管理',
	  'nav'=>array(
	  		array('name'=>'搭配管理',				'a'=>'main'),
			array('name'=>'添加搭配',				'a'=>'post'),
			array('name'=>'设置',					'a'=>'setting'),
			array('name'=>'SEO设置',		'a'=>'seo_setting'),
			array('name'=>'分类管理',		'a'=>'cate'),
			array('name'=>'添加分类',		'a'=>'cate_post'),
	)
);


$menu['shop'] = array(
	'type'=>2,
	'name'=>'店铺管理',
	'nav'=>array(
		array('name'=>'店铺管理',		'a'=>'main'),
		array('name'=>'添加店铺',		'a'=>'post'),
		array('name'=>'分类管理',		'a'=>'cate'),
		array('name'=>'添加分类',		'a'=>'cate_post'),
		array('name'=>'SEO设置',		'a'=>'seo_setting'),

	)
);

$menu['duihuan'] = array(
		'type'=>2,
		'name'=>'积分兑换',
		'nav'=>array(
			array('name'=>'积分兑换',		'a'=>'main'),
			array('name'=>'兑换商品发布',	'a'=>'post'),
			array('name'=>'申请记录',		'a'=>'apply'),
			array('name'=>'分类管理',		'a'=>'cate'),
			array('name'=>'添加分类',		'a'=>'cate_post'),
			array('name'=>'SEO设置',		'a'=>'seo_setting'),
		)
);


$menu['fanli'] = array(
	'type'=>3,
	'name'=>'返利管理',
	'nav'=>array(
		array('name'=>'订单列表',				'a'=>'main'),
		//array('name'=>'上传订单号',				'a'=>'upload_order'),
		// array('name'=>'返利记录',				'a'=>'money'),
		array('name'=>'返利设置',				'a'=>'setting'),
		// array('name'=>'提现记录',				'a'=>'tixian'),
	)
);

$menu['member'] = array(
	'type'=>2,
	'name'=>'会员管理',
	'nav'=>array(
		array('name'=>'会员管理',				'a'=>'main'),
		array('name'=>'添加会员',				'a'=>'post'),
		array('name'=>'会员搜索',				'a'=>'search'),
		array('name'=>'用户组',					'a'=>'group'),
		array('name'=>'添加用户组',				'a'=>'group_post')


	)
);


$menu['sign'] = array(
	'type'=>2,
	'name'=>'积分管理',
	'nav'=>array(
		array('name'=>'积分管理',				'a'=>'main'),
		array('name'=>'搜索',					'a'=>'search'),
		array('name'=>'邀请记录',					'a'=>'yaoqing'),
	)
);
$menu['message'] = array(
	'type'=>1,
	'name'=>'留言建议',
	'nav'=>array(
		/*array('name'=>'留言管理',				'a'=>'main'),*/
		array('name'=>'建议反馈',				'a'=>'feedback'),
	)
);


$menu['pics'] = array(
	'type'=>2,
	'name'=>'幻灯片',
	'nav'=>array(
		array('name'=>'幻灯片',				'a'=>'main'),
		array('name'=>'添加幻灯片',			'a'=>'post'),
		array('name'=>'幻灯片分类',			'a'=>'type'),
		array('name'=>'添加幻灯片分类',		'a'=>'type_post'),
	)
);
$menu['ad'] = array(
	'type'=>2,
	'name'=>'广告管理',
	'nav'=>array(
		array('name'=>'广告管理',				'a'=>'main'),
		array('name'=>'添加广告',				'a'=>'post'),
	)
);
$menu['article'] = array(
	'type'=>1,
	'name'=>'文章管理',
	'nav'=>array(
		array('name'=>'文章管理',				'a'=>'main'),
		array('name'=>'添加文章',				'a'=>'post'),
		array('name'=>'分类管理',				'a'=>'cate'),
		array('name'=>'添加分类',				'a'=>'cate_post'),
		array('name'=>'文章搜索',				'a'=>'search'),
		array('name'=>'SEO设置',				'a'=>'seo_setting'),
	)
);

$menu['module'] = array(
	'type'=>1,
	'name'=>'友情链接',
	'nav'=>array(
		array('name'=>'友情链接',				'a'=>'friend_link'),
		array('name'=>'添加友情链接',			'a'=>'friend_link_add')
	)
);
$menu['tools'] = array(
	'type'=>1,
	'name'=>'更新缓存',
	'nav'=>array(
			array('name'=>'更新缓存',				'a'=>'cache'),
			array('name'=>'工具集合',				'a'=>'main'),
			array('name'=>'更新站内商品',			'a'=>'update_goods','type'=>9),
	)
);





?>
