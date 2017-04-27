
/*

var config = {box:'#j_box',el:'.list-auction-box',max_list:5,
							margin:10,index:1,url:'/index.php?m=zj&a=list',page:2,callback:call};			
new _waterfall(config).run();
*/

function _waterfall(config){
	//必填参
	this.box 	= 			'';		//放置瀑布流的父容器  el的parent
	this.el 		=		'';		//瀑布流元素的,要随机position的元素名	
	this.max_list 	=		6;		//最多多少列

	//可选属性	
	this.margin		= 		10;		//el的左右间距,默认为12
	this.index 		=		0;		//从第几个元素开始排列，默认为 0	
	
	//自动计算的属于
	this.size=		[]		//存放列高度的数组	
	this.totalwidth = 0;
	this.totalheight = 0;		
	this.mincolumn = {"value": 0, "index": 0};
	this.el_list =  [];		//当前节点列表
	this.singlewidth = 0;	
	this.width = 0;			//每列宽度
	this.column = 1;		//最终显示的列数
	
	
	/*
	//自动加载需要的,具体参数可查看 _scroll_get
	this.scroll_obj			//滚动的对象.默认为window
	this.scroll_get = null;
	this.is_run = false;	//是否正在ajax获取数据状态中...
	this.last_time = 0;		//最后请求的时间截
	this.stop = false;		//强制停止,不再滚动条加载
	this.time = 2000;		//每一次获取间格时间
	this.scroll_top = 0;	//当前滚动条的位置,防止向上滚动也去加载
	this.height = 1500;				//间距底部距离多少
	//ajax后的回调 参数1,当前请求后得到的数据,参数2,当前瀑布流对象,参数3,ajax对象
	this.callback  = null;	
	this.run_end = null;			//ajax执行结束,并插入数据后的回调
	this.page 		= 		2;		//起始页面,ajax请求时需要
	this.url 		= 		'';		//自动加载下一页需要的URL
	*/

	if(typeof config == 'object'){
		for(var i in config){
			this[i] = config[i];
		}
	}else{
		L('waterfall config is null');
		return ;
	}
	this.box = $(this.box).css({position:'relative'});	
	
	this.waterfall = function(){
				this.el_list =  this.box.find(this.el);
				if(this.el_list.length == 0) {					
					return ;
				}
				
				if(this.index == this.el_list.length)  return ;
				
				if(this.width == 0)this.width =  this.el_list.eq(0).outerWidth();
				
				var offsetWidth = this.box.outerWidth();
				this.column = Math.floor((offsetWidth + this.margin) / (this.width + this.margin));
								
				if(this.max_list && this.column > this.max_list) {
					this.column = this.max_list;
				}
				if(!this.column) {
					this.column = 1;
				}
				//如果存放列高的数组长度和列数不一致，说明需要重新计算每个元素的位置
				
				if(this.size.length != this.column) {
					this.size = [];
					for(var i = 0; i < this.column; i++) {
						this.size[i] = 0;
					}
					this.index = 0;
				}				
				
				this.singlewidth = this.width + this.margin;
				this.totalwidth = this.singlewidth * this.column - this.margin;
				
				for(var i = this.index, j = this.el_list.length; i < j; i++) {		
					this.mincolumn = this.size.waterfallMin();
					
					var left = this.singlewidth * this.mincolumn.index;
					var top = this.mincolumn.value;
					
					this.el_list.eq(i).css({position:"absolute",left:left,top:top});
					var height = this.el_list.eq(i).outerHeight();
					this.size[this.mincolumn.index] = this.size[this.mincolumn.index] + height + this.margin;
					this.totalheight = Math.max(this.totalheight, this.size.waterfallMax());
					this.index++;
				}
				
				this.box.css({width:this.totalwidth,height:this.totalheight});
			
	}
	,
	//自动滚动条加载...
	this.run = function(){	
			if(!this.url) {
				L('url未配置');
				return ;
			}
			var _this = this;
			var cfg = {};
			for(var i in this){					
					if(i !='get' && i !='run'&& i !='callback')	cfg[i] = this[i];
			}
			
			cfg.callback = function(s){
						if(s.status == 'error'){
							Dialog.info(s.status,'error');
							return false;
						}					
						if(typeof _this.callback == 'function'){
							//回调  ajax返回的数据,当前瀑布流对象,ajax对象
							var rs = _this.callback(s,_this,this);
							if(rs)$(rs).appendTo(_this.box);
							if(typeof $['fadeIn'] == 'function'){
								if(rs)$(rs).appendTo(_this.box);
							}else{
								if(rs)$(rs).appendTo(_this.box).fadeIn(1000);
							}
						}
						_this.waterfall();
						if(typeof _this.run_end == 'function') _this.run_end(_this);
			};

		 new _scroll_get(cfg);
		return this;
	}
	this.waterfall();
	return this;
}

 

Array.prototype.waterfallMin = function () {
	var min = 0;
	var index = 0;
	if(this.length > 0) {
		min = Math.min.apply({}, this);
		for(var i = 0, j = this.length; i < j; i++) {
			if(this[i] == min) {
				index = i;
				break;
			}
		}
	}
	return {"value": min, "index": index};
}

Array.prototype.waterfallMax = function () {
	return Math.max.apply({}, this);
}




/*
	demo
	var cfg = {'box':'','url':'',callback:function(s){	}};
	new _scroll_get(cfg);

*/
function _scroll_get(config){
	
	//3个必填参
	this.box = null;				//将获取的数据,插入到这个里面
	this.url = '';					//自动加载下一页需要的URL
	
	this.callback = null;			//ajax后的回调 参数1,当前ajax请求后得到的数据,参数2,当前类对象,参数3,ajax对象
	
	//可选参
	this.last_time = 0;				//最后请求的时间截
	this.page = 2;					//起始页面,ajax请求时需要
	this.time = 2000;				//每一次获取间格时间
	this.stop = false;				//强制停止,不再滚动条加载
	this.next_btn = '';
	this.run_end = null;			//ajax执行结束,并插入数据后的回调
	this.height = 1500;				//间距底部距离多少
	this.scroll_obj = '';			//滚动的对象,默认为windows
	this.ext = '';					//url加上的后缀
	this.loading = '';					//加载中的元素,el
	
	//系统参
	this.is_run = false;			//是否正在ajax获取数据状态中...
	this.scroll_top = 0;			//当前滚动条的位置,防止向上滚动也去加载
	
	if(typeof config == 'object'){
		for(var i in config){
			this[i] = config[i];
		}
	}else{
		L('config is null');
		return ;
	}
	if(typeof this.box == 'string') this.box = $(this.box);
	
	this.get = function(){
		if(this.stop) return ;
		if(this.is_run) return;
		this.is_run = true;
		
		this.last_time =  parseInt(Date.parse(new Date()));
		if(this.url.indexOf('?') == -1) this.url+='?';
		
		var url = this.url + ('&page='+this.page);
		var _this = this;
		if(this.loading) $(this.loading).show();
		ajaxget(url,function(s){
				if(_this.loading) $(_this.loading).hide();
				if(s.status == 'error'){
					Dialog.info(s.status,'error');
					return false;
				}
			
				if(typeof _this.callback == 'function'){
					//回调  ajax返回的数据,当前瀑布流对象,ajax对象
					//return string;
					var rs = _this.callback(s,_this,this);
					if(rs){
						if(typeof $('body')['fadeIn'] == 'function'){
							//$(rs).appendTo(_this.box).fadeIn(1000);
							if('Zepto' in window){
								$(rs).each(function(){
									if(this.nodeType == 1){
										$(this).appendTo(_this.box).fadeIn(1000);
									}
								});
							}else{
								$(rs).appendTo(_this.box).fadeIn(1000);
							}

						}else{
							$(rs).appendTo(_this.box);
						}
					}
				}
				_this.page++;
				_this.is_run = false;
				if(typeof _this.run_end == 'function') _this.run_end(_this);
		});
	}
	//自动滚动条加载...
	this.run = function(){			
			if(!this.url) {
				L('url未配置');
				return ;
			}
			
			var url = this.url;
			if(url.indexOf('#') != -1) url = url.replace("#",'');
			if(url.indexOf('?') == -1){
				if(url.replace('://','').indexOf('/') == -1) url += '/';
				url += '?';
			}
			if(CURACTION == 'search') url+= '&kw='+encodeURIComponent($_GET['kw']);
			if(this.ext) url+=this.ext;
			this.url = url;
			
			
			var _this = this;
			_scroll(function(top,el){
				
				if(_this.stop || _this.is_run) return ;
				if(_this.scroll_top>top) return ;
				  _this.scroll_top = top;
					var height = el.scrollHeight;
					if(top>height-_this.height){
					  var now = parseInt( Date.parse( new Date() ) );
					  //间隔两秒才能下一页
					  if( now - _this.last_time > _this.time ) {
						 _this.get();
					  }
				  }
			},_this.scroll_obj);
			
			if(this.next_btn){
				$(this.next_btn).click(function(){
 					 if(_this.stop) return false;
					 _this.get();
					return false;
				});
			}
	}
	this.run();
	return this;	
}



