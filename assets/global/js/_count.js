var _count = {
	update:'2016.12.29',
	platform:0,
	id:0,
	s:'',
	action_list: {  // 1-100=pc  100-200=wap  200-300=app 

		k0: '',
		k1: '主导航被点击',
		k2: '侧边栏分类被点击',
		k3: '商品详情按钮被点击',
		k4: '网站内部其它点击',
		k5: 'android下载按钮点击',
		k6: 'iphone下载按钮点击',
		k7: '跳转到淘宝去购买',
		k8: '跳转到领券页面',
		k9: '搜索按钮被点击',
		k10: '幻灯片广告点击',
		k11: '侧边栏广告点击',
		k12: '网站Logo点击',
		k13: '网站底部链接点击',
		k14: '下一页被点击',
		k15: '商品报名点击',
		k16: '登录按钮点击',
		k17: '退出按钮点击',
		k18: '跳转到APP下载页按钮点击',
		k19: '图片广告点击',
		k20: '二级导航点击',
		k21: '返回顶部按钮',
		k22: '优惠券按扭点击',
		k23: '分享商品按扭点击',
		k24: '签到按钮点击',
		k25: '友情链接点击',
		k26: '收藏商品点击',
		k27: '进入店铺按钮点击',



		k100: '商品分类点击',
		k101: '底部导航点击',
		k102: '进入wap页面按钮点击',
		k103: '分享淘口令',
		k104: '分享优惠券',
		k105: '用本站APP打开',
		k106: '用手淘打开',
		k107: '用淘口令购买',
		k108: '用网页购买',


		k200: '进入详情页浏览商品',
		k201: '复制淘口令按钮点击',
		k202: '复制淘口后进入淘宝',
		k203: '分享商品成功',
		k204: '分享优惠券成功',
		k205: '领券并下单点击',
		k206: '首页格子点击',
		k207: 'app启动',
		k208: '栏目被点击',
		


	},
	page_list:{
		k0: '通用页面',
		k1: '首页',
		k2: '商品列表页',
		k3: '商品详情页',
		k4: '搜索页列表',
		k5: '值得买列表页',
		k6: '值得买详情页',
		k7: '搭配列表页',
		k8: '搭配详情页',
		k9: '店铺列表页',
		k10: '店铺详情页',
		k11: 'APP下载页',
		k12: '登录页',
		k13: '注册页',
		k14: '找回密码页',
		k15: '商品报名页',
		k16: '商品分类页',
		k17: '商品栏目页',
	},
	init_platform:function(){
				var platform = 1; // pc
				var useragent = navigator.userAgent.toLowerCase();
				//$platform = array(0=>'',1=>'pc',2=>'android',3=>'ios',4=>'weixin',5=>'wap iphone',6=>'wap android',7=>'wap');
				if (useragent.indexOf('micromessenger') > -1) {
					platform = 4;
				} else if (useragent.indexOf('iphone') > -1) {
					platform = 5;
				} else if (useragent.indexOf('android') > -1) {
					platform = 6;
				} else if (useragent.indexOf('mobile') > -1) {
					platform = 7;
				}
				this.platform = platform;
	},
	add: function(action, lable) {

		if(this.id == 0) {
			if(CNZZID && CNZZID>0){
				this.id = ~~CNZZID;
			}else{
				L('count id not extends');
				return ;
			}
		}

		if (this.platform == 0 ) this.init_platform();
		if(!isNaN(action)){
			action = ~~action;
			var act = this.action_list['k' + action];
		}else{
			var act =action;
		}

		var page = ['unkown', 'pc', 'app_android', 'app_iphone', 'weixin', 'wap_iphone', 'wap_android', 'wap'];
		var pl = this.platform;
		var name = page[pl];

		// this.add2(name, act, lable);
		// return ;

		var showp = window.screen.width+'x'+window.screen.height;
		if(lable){
				if(!isNaN(lable)){
					var lb = 'k'+(~~lable);
					lable = this.page_list[lb];
				}
				lable= this.encode(lable)
		}else{
			lable = '';
		}

		var ei = (this.encode(name)+'|'+this.encode(act)+'|'+lable+'|0|');
		var cnzz_eid = Math.floor(2147483648 * Math.random()) + "-" + (~~(Date.now() / 1000) - 3600*2) + "-" +location.origin;

		var cfg = [];
		cfg.push("id="+this.id);
		cfg.push("r="+location.href);
		cfg.push("ntime="+ (~~(Date.now() / 1000)));
		cfg.push("lg=zh-cn");
		cfg.push("showp="+showp);
		cfg.push("ei="+ei);
		cfg.push("t="+document.title);
		cfg.push("h=1");
		cfg.push("cnzz_eid="+cnzz_eid);
		cfg.push("rnd=" + Math.floor(2147483648 * Math.random()));
		(new Image).src = "http"+this.s+"://ei.cnzz.com/stat.htm?" + cfg.join("&");
	
	},add2:function(name,act,lable){
		if (typeof _czc == 'undefined') {
			console.log('cnzz not include');
			return;
		}
		_czc.push(﻿["_trackEvent", name, act, lable]);
	},encode:function(str,is_app){
		if(is_app){
			return (encodeURIComponent(str));
		}
		return encodeURIComponent(encodeURIComponent(str));
	},app:function(action, lable,url,title){
		if(this.id == 0) {
			app.alert('cnzz id 不能为空');
			return ;
		}

		if (this.platform == 0 ){
			this.platform = api.systemType =='android' ? 2 :3;
		}
		if(!isNaN(action)){
			action = ~~action;
			var act = this.action_list['k' + action];
		}else{
			var act =action;
		}

		var page = ['unkown', 'pc', 'app_android', 'app_iphone', 'weixin', 'wap_iphone', 'wap_android', 'wap'];
		var pl = this.platform;
		var name = page[pl];


		var showp = api.winWidth+'x'+ api.winHeight;
		if(lable){
				if(!isNaN(lable)){
					var lb = 'k'+(~~lable);
					lable = this.page_list[lb];
				}
				lable= this.encode(lable,1)
		}else{
			lable = '';
		}

		url = url || URL;
		title = title || api.appName;

		var ei = (this.encode(name,1)+'|'+this.encode(act,1)+'|'+lable+'|0|');
		var cnzz_eid = Math.floor(2147483648 * Math.random()) + "-" + (~~(Date.now() / 1000) - 3600*2) + "-" +url;

		var cfg = [];
		cfg.push("id="+this.id);
		cfg.push("r="+url);
		cfg.push("ntime="+ (~~(Date.now() / 1000)));
		cfg.push("lg=zh-cn");
		cfg.push("showp="+showp);
		cfg.push("ei="+ei);
		cfg.push("t="+title);
		cfg.push("h=1");
		cfg.push("cnzz_eid="+cnzz_eid);
		cfg.push("rnd=" + Math.floor(2147483648 * Math.random()));
		//(new Image).src = "http://ei.cnzz.com/stat.htm?" + cfg.join("&");
		var ors = api.debug ? 'http':'https';
		var geturl = ors+"://ei.cnzz.com/stat.htm?" + cfg.join("&");
		app.ajax({
			url:geturl,
			dataType:'html'
		},'get',{'Referer':url},'',function(){
			
		});
	}
}