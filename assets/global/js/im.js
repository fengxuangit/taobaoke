var im = {
	url:'/index.php?m=im&a=',
	log:true,		//足迹
	config: {
		container: null,
		logo: '', // 左上角logo,  移动端设置无效
		pluginUrl: '',
		theme: 'red',
		width: 800,
		height: 820,
		placeholder: '请输入您要咨询的问题',
		toAvatar: "", // 对方用户的头像
		sendBtn: true,
		sendMsgToCustomService: true,
		hideLoginSuccess:true,
		titleBar:true,

		customData:{},
		onBack:function(){
			history.back();
		},
		onLoginError: function(s) {
			L(s);
			alert('初始化失败:'+s.resultText);
		},
		onLoginSuccess: function() {
			//$(".wkit-powered-by").remove();		
		}
	},
	init: function() {
		var _this = this;		
		this.config.pluginUrl = this.url +'left_bar';
		if(location.href.indexOf('full') ==-1) {
			this.config.container = document.getElementById('im_box');
		}
		if(location.href.indexOf('&title') >-1) {
			//取消顶部返回框
			this.config.titleBar = false;
		}

		$.getJSON('/?m=im&a=get_info',function(rs){
				if(rs.status == 'error'){
					alert(rs.msg);
					return ;
				}
				var user = rs.data.user;
				var cfg = rs.data.cfg;
				if(!cfg.ww_key || !cfg.ww_group_id) {
					alert('抱歉,系统未启用客服功能');
					return ;
				}

				_this.config.uid = user.uid;
				_this.config.avatar = user.picurl;
				_this.config.credential = user.pw;
				_this.config.appkey = cfg.ww_key;
				_this.config.touid = cfg.ww_name;
				if(cfg.ww_group_id)_this.config.groupId = cfg.ww_group_id;
				var num_iid = getUrlParam('num_iid') || getUrlParam('itemid');
				if(num_iid) _this.config.customData.item = {id:num_iid};

				L(_this.config);
				WKIT.init(_this.config);

				if(_this.log){
					var channel = '';
					var ref = document.referrer;
					var cfg = { 
						uid:user.uid,appkey:_this.config.appkey,fromChannel:channel,
						dataForDisplay:{'网站名称':_this.config.touid,'网站首页':location.origin,'来源':ref},	// 自定义足迹
						//extraData:{b:2} // 自定义参数	
					};
					WLOG.init(cfg);
				}


		})

	}
}
 function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]); return null; //返回参数值
        }

function L(s){
	console.trace(s);
}

$(function() {
	im.init();
})