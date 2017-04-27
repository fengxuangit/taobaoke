/*--------------global start ------------------*/

var DEBUG =true;
var slide_all = ["easeNone","easeIn","easeOut","easeBoth","easeInStrong","easeOutStrong","easeBothStrong","elasticIn","elasticOut","elasticBoth","backIn","backOut","backBoth","bounceIn","bounceOut","bounceBoth"];
var slide_in = ["easeNone","easeIn","easeBoth","easeInStrong","easeBothStrong","elasticOut","elasticBoth","backIn","backBoth","bounceOut","bounceBoth"]
var slide_out =["easeNone","easeOut","easeBoth","easeOutStrong","easeBothStrong","elasticOut","elasticBoth","backOut","backBoth","bounceOut","bounceBoth"]
var BROWSER = {};
var CURMODULE = null,CURSCRIPT=null,CURACTION=null,$_GET={},TAE=false,UID=false,USERNAME=false,QQ_ZONE=false,DUOSHUO_KEY='',LEFT_BAR = 0,CAIJI_TYPE,CNZZID;
var $ = jQuery;

function jump(url){
		if(url){
			location.href = url;
		}else {
			return location.href;
		}
}
var URL = 	jump();
var HOST = 'http://'+getHost(URL);

(function (){
	var set_obj = $("meta[name='set']");
	if(set_obj.length>0)	{
			var set = set_obj.attr('content').split('|');
			TAE			=  set[0] == 1 ? true:false;
			CURSCRIPT	=  set[1] ;
			CURMODULE	=  set[2] ;
			CURACTION	=  set[3] ;
			UID			= parseInt(set[4]);
			USERNAME	=  set[5];
			DUOSHUO_KEY	=  set[6];
			LEFT_BAR	=  set[7];
			CAIJI_TYPE	=  set[8];
			CNZZID	=  set[9];
	}
	var get 	=	$("meta[name='get']").attr('content');
	if(get =='') return ;
	get  = decodeURIComponent(get);
	var filter = ['<',">","\\(",'"',"\\)",'\'',"&gt;","&lt;",'\\\\','&#','x0','0x','%','u00','eval','.js','.php','0000','\\*'];
	for(var i=0;i<filter.length;i++){
		var reg = new RegExp(filter[i]);
		get = get.replace(reg,'').replace(reg,'');
	}
	get= get.split('&');
	for(var i = 0;i<get.length;i++){
		if(get[i]){
			var s = get[i].split('=');
			var k =s[0];
			var v = s[1];
			if(k.match(/^[a-z0-9A-Z_\-]{1,10}$/)){
				$_GET[k] = v;
			}
		}
	}

})();

function _scroll(call,obj){
	if(obj){
			$(obj).scroll(function(e){
				var top =  $(this).scrollTop();
				call(top,this);
			})
	}else{

		if(BROWSER.ie){
			var el = document.documentElement;
		}else{
			var el = document.body;
		}

		$(window).scroll(function(e){
			call(el.scrollTop,el);
		})
	}
}

(function () {
	var USERAGENT = navigator.userAgent.toLowerCase();
	if(BROWSER.safari)  BROWSER.firefox = true;
	BROWSER.opera = BROWSER.opera ? opera.version() : 0;
	var other = 1;
	var types =['msie','firefox','chrome','opera','safari','mozilla','webkit','maxthon','qqbrowser'];

	for(var i =0;i<types.length ;i++){
					var v = types[i];
					if(USERAGENT.indexOf(v) != -1) {
						var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
						var matches = re.exec(USERAGENT);
						var ver = matches != null ? matches[2] : 0;
						other = ver !== 0 && v != 'mozilla' ? 0 : other;


						if(types[i] =='msie' && ver >0){
							$('html').addClass('ie_all ie'+parseInt(ver));
						}
					}else {
						var ver = 0;
					}
					BROWSER[v] = ver;
	}
	BROWSER.ie = BROWSER.msie;
	BROWSER.other = other;
})();
if(BROWSER.ie) DEBUG = false;


function L(s){
	if(DEBUG) console.log(s);
}


function callback(){}
var user = {islogin:false};

function tae_url(url){
	if(typeof url == 'undefined' || !url) return '';
	if(url.charAt(0) == '?'){
		 url = '/index.php'+url;
	}else if(url.indexOf('http://') != -1){
			var index = url.indexOf('/',7);
			url = url.substr(index,url.length);
	}else if(url.charAt(0) == 'a' || url.charAt(0) == 'm'){
		url = '/index.php?'+url;
	}
	return url;
}

function ajaxget(url,success,error,dataType){
			url = tae_url(url);
			try{
				var type = dataType ?dataType:'json';
					$.ajax({type:'GET',url:url,data:'',success:function(s){
						if(s['msg'] && typeof s.msg == 'string' &&( s.msg.indexOf('&gt;') != -1 ) )s.msg = htmldecode(s.msg);
						if(typeof success == 'function')success(s);
					},dataType:type,error: function(s,d,e){
						if(typeof error == 'function')error(s,d,e);
						 console.log('ajax error,msg:' +  s );
						 return false;
					}});
			}catch(e){
				L(e);
			}
}


//随机数
function ranDom(Min,Max){
	if(Min>Max) {
		var tmp = Min;
		Min= Max;
		Max = tmp;
	}
 var  x1 = Math.min(Min,Max);
 var x2 = Math.max(Min,Max);
 return x1 + Math.floor(Math.random() * (x2 - x1 + 1));
}

//随机字符
function _random(strlen){
	var chars = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
	strlen = strlen ?strlen:ranDom(25,35);
	var res = '';
		for(var i = 0;i<strlen;i++){
			res +=chars[Math.ceil(Math.random()*chars.length-1)];
		}
	return res;
}


function trim(str){
	return str.replace(/\s+/g,'');
}

function sub_str(str,start,end){
	str = trim(str);
	start = trim(start);
	if(end!=-1)end = trim(end);

	var s = str.indexOf(start);
	var str1= str.substring(s+start.length,str.length);
	var e = end == -1 ? str1.length :str1.indexOf(end);
	return  str1.substring(0,e);
};

//添加收藏夹
function addFavorite(url, title) {
	try {
		window.external.addFavorite(url, title);
	} catch (e){
		try {
			window.sidebar.addPanel(title, url, '');
        	} catch (e) {
			showDialog("请按 Ctrl+D 键添加到收藏夹", 'notice');
		}
	}
}


function isUndefined(str) {
	return typeof str == 'undefined' ? true : false;
}



function select_option(obj,value){
	var pos = $(obj)[0];
	for (var i = 0; i < pos.options.length; i++) {
		if (pos.options[i].text ==value) {
			pos.options[i].selected = true;
			break;
		}
  	 }



}
function hover(obj,move,out){
	$(obj).hover(move,out)
}

function click(obj,fun){
	if(fun && typeof fun == 'function'){
		$(obj).click(fun);
	}
}



/*
box 区块元素,父级el
run_box	需要转动的节点
type 运动的方式 (margin,left,right等)	可空
run 运动函数	可空
time 自动滚动的间隔时间
size 转一次大小
len 最多可滚动的次数 ,如果不给len,则取当前box里的所有子节点个数,为滚动翻页的次数,如: run_box共5个子节点,刚滚动5次 ,如果直接len=2,则只滚动2次
callbakc 结束后的回调
bar 鼠标控制滑动
className bar的className
time 每次动画的间隔时间 毫秒
each_time  动画运行时间
split 每一次滚动的子节点个数  如:split=5,  共16个节点,每次5个,则滚动  Math.ceil(16/5) 4次
next  下一个的按钮
up	上一个的按钮
split 和len 只存在一个即可 ,len = 总翻页次数,一般是固定了子节点元素. split是不固定子节点个数,自动根据 子节点个数/每页个数 来求翻页大小

Marquee2({box:'',run_box:'',up:'',next:'',time:4000,size:900,type:'left',run:function,callback:function,bar:'el',className:'on','split':0,'each_time':200});
*/



function Marquee2(cf){

		var obj = new Object(cf);
		obj.timer = null;
		obj.index = 0;
		if(!obj.time) obj.time = 4000;
		//var each_arr = ['linear','swing'];
		//if(!TAE  || (obj.each && !in_array(obj.each,each_arr))) obj.each = '';
		if(!obj['each']) obj.each = '';
		if(!obj['each_time']) obj.each_time = 200;

		if(typeof cf.fun == 'function'){
			obj.run = function(){
				if(obj.bar)$(obj.box).find(obj.bar).removeClass(obj.className).eq(obj.index).addClass(obj.className);
				if(obj.index>obj.len-1)obj.index=0;
				cf.fun(obj.index);
			};
		}else if(obj.type == 'display'){
			obj.run =function (){
				if(obj.bar)$(obj.box).find(obj.bar).removeClass(obj.className).eq(obj.index).addClass(obj.className);
				if(obj.index>obj.len-1)obj.index=0;
				$(obj.box).find(obj.run_box).hide().eq(obj.index).show();
			}
		}else{
			obj.run =function (){

						if(obj.index>obj.len-1)obj.index=0;
						if(obj.bar)$(obj.box).find(obj.bar).removeClass(obj.className).eq(obj.index).addClass(obj.className);
						if(!obj.size) obj.size = 750;
						var left = -parseInt(obj.index*obj.size);
						var o = {};

						o[obj.type] = left;

						//obj.each = '';
						$(obj.box).find(obj.run_box).animate(o,obj.each_time,obj.each,function(){
							if(typeof obj['callback'] == 'function') obj.callback(obj.index);
						});

			}

		}



		if(typeof obj.next == 'string' && obj.next){
				click($(obj.box).find(obj.next),function(){
					clearInterval(obj.timer);
					obj.index++;
					if(obj.index>obj.len-1)obj.index=0;
					obj.run();

					return false;
				});



		}
		if(typeof obj.up == 'string' && obj.up){

				click($(obj.box).find(obj.up),function(){
					clearInterval(obj.timer);
					obj.index--;

					if(obj.index<0) obj.index=obj.len-1;
					obj.run();

					return false;
				});
		}

		if(obj.bar){
			if(!obj.className)obj.className = 'on';
			obj.len =$(obj.box+' '+obj.bar).length;
			$(obj.box).find(obj.bar).each(function(i){
				$(this).attr('data-index',i);
			});

			hover(obj.box +' '+obj.bar,function(){
				clearInterval(obj.timer);
				var index  = $(this).attr('data-index');
				if(index){
					obj.index = parseInt(index);
					obj.run();
				}else if(typeof this.index == 'number'){
					obj.index = parseInt(this.index);
					obj.fun();
				}
				return false;
			});
		}else{


			if(!obj['len'] || obj['len'] =='' || obj['len'] <1){
				obj.len = $(obj.box).find(obj.run_box).children().length;

			}

			if(typeof obj['split'] != 'undefined' && obj['split'] > 0 ){
					obj.len =parseInt(Math.ceil(obj.len / parseInt(obj['split'])));
			}



		}
		hover(obj.box,function(){
			clearInterval(obj.timer);
		},function(){
			obj.timer = setInterval(obj.auto_run,obj.time);
		});

		if(obj.bar)$(obj.box).find(obj.bar).removeClass(obj.className).eq(obj.index).addClass(obj.className);
		obj.auto_run = function (){

			obj.index++;

			if(obj.index>obj.len-1)obj.index=0;

			obj.run();
		}
		obj.run();
		obj.timer = setInterval(obj.auto_run,obj.time);

		return obj;

}


/*
	动画类
	box 	父接点的class
	show  	要运行的接点class
	bar		鼠标控制器的class
	time	间隔时间
	type	1=渐隐渐显	2=向右无缝滚动(配合运动)	3=普通显示隐藏
	show_parent	只有当type==2是就得设置这个参数.运动的父接点
	Example		Marquee({'box':'.gd','show':'.show_li','bar':'.bar_li','up':'','next':'','time':'3000','type':2,'show_parent':'.show_ul','className':''});
*/

function Marquee(o){

	var obj  = new Object();
	var box = $(o.box)[0];
	obj.show 		=	$(o.box).find(o.show);
	if(!obj.show || obj.show.length == 0){
		 console.log('Marquee box is NULL');
		 return false;
	}
	obj.bar = [];
	obj.next = [];
	obj.up = [];

	$(o.box).find(o.bar).each(function(){
		obj.bar.push(this);
	});

	$(o.box).find(o.next).each(function(){
		obj.next.push(this);
	});
	$(o.box).find(o.up).each(function(){
		obj.up.push(this);
	});

	obj.type 		=	o.type	?	o.type				:1;
	obj.className 		=	o.className	?	o.className	:'on';

	obj.show_parent	=	null;
	obj.fun 		=	null;
	obj.time 		= 	o.time 	? o.time :0;
	var len  		= obj.show.length;


	obj.box			 = 	box;
	obj.length = len;
	obj.index = 0;
	obj.timer = null;
	//obj.width =obj.show.eq(0).width();
	obj.width = $(obj.show[0]).width();
	obj.log_len = 0;

	obj.an = null;
	obj.resize = function (){
		obj.width = $(obj.show[0]).width();
		return obj;
	}
	//动画1
			function sport_field_in(){
					$(obj.show).hide().removeClass(obj.className).eq(obj.index).fadeIn().addClass(obj.className);
					return obj;
			}
			//动画3
			function sport_display(){

				$(obj.show).hide().removeClass(obj.className).eq(obj.index).show().addClass(obj.className);
				return obj;
			}

	if(o.type == 1){
			obj.fun=sport_field_in;
	}else if(o.type==3){
			obj.fun = sport_display;
	}else{
			obj.fun = sport_display;
	}

	if(obj.bar && obj.bar.length>0){

		for(var i =0;i<len;i++){
			//obj.bar[i].index = i;
			$(obj.bar[i]).attr('data-index',i);
			hover(obj.bar[i],function(){

				obj.stop();
				$(obj.bar).removeClass(obj.className);
				$(this).addClass(obj.className);
				if($(this).attr('data-index')){
					//索引只能预先定义,也只能通过这方法拿到索引...
					obj.index = parseInt($(this).attr('data-index'));
					obj.fun();
				}else if(typeof this.index == 'number'){
					obj.index = parseInt(this.index);
					obj.fun();
				}
			});
		}
	}
	hover(obj.box,function(){

			obj.stop();
	},function(){
		obj.run();
	});
	obj.run = function(){
		if(obj.timer)clearInterval(obj.timer);

		if(len ==1)	{
			$(obj.show).eq(0).show();
			return false;
		}
		obj.timer = setInterval(function(){
			obj.index++;
			if(obj.index>=obj.length)  obj.index = 0;
			try{
			if(obj.bar) $(obj.bar).removeClass(obj.className).eq(obj.index).addClass(obj.className);
			}catch(e){
				if(obj.log_len<3){
					L('js升级,Marquee中的一些函数在线下不可用,线上正常.2');
					obj.log_len++;

				}
			}
			obj.fun();
		},obj.time);
		return obj;
	}
	obj.stop = function(){
		clearInterval(obj.timer);
		if(obj.an != null )obj.an.stop(false);
		return obj;
	}
	//默认要加载一次
	//obj.index++;
	try{
		if(obj.bar) $(obj.bar).removeClass(obj.className).eq(obj.index).addClass(obj.className);
	}catch(e){
		if(obj.log_len<3){
			L('js升级,Marquee中的一些函数在线下不可用,线上正常.3');
			obj.log_len++;
		}
	};
	obj.fun().run();


	if(obj.up){
		$(obj.up).click(function(){
				obj.stop();
				obj.index--;
				if(obj.index<0)  obj.index = obj.length-1;
				$(obj.bar).removeClass(obj.className);
				$(obj.bar).eq(obj.index).addClass(obj.className);
				obj.fun();
		});
	}

	if(obj.next){
		$(obj.next).click(function(){

				obj.stop();
				obj.index++;
				if(obj.index>=obj.length)  obj.index = 0;
				$(obj.bar).removeClass(obj.className);
				$(obj.bar).eq(obj.index).addClass(obj.className);
				obj.fun();

		});
	}


	obj.isinit = true;
	//开始自动运行
	return obj;
}


function getHost(url) {
	var host = "null";
	if(typeof url == "undefined"|| null == url) {
		url = URL;
	}
	var regex = /^\w+\:\/\/([^\/]*).*/;

	var match = url.match(regex);
	if(typeof match != "undefined" && null != match) {
		host = match[1];
	}
	return host;
}

function hostconvert(url) {

	var url_host = getHost(url);
	var cur_host = getHost().toLowerCase();
	if(url_host && cur_host != url_host) {
		url = url.replace(url_host, cur_host);
	}
	return url;
}

function cutstr(str, maxlen, dot) {
	var len = 0;
	var ret = '';
	var dot = dot ? dot : '';
	maxlen = maxlen - dot.length;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ?2: 1;
		if(len > maxlen) {
			ret += dot;
			break;
		}
		ret += str.substr(i, 1);
	}
	return ret;
}

function dgmdate(timestamp,str){
	if(!timestamp || timestamp == 0 || timestamp==''){
		return '';
	}
	timestamp=~~(timestamp);
	if(str){
		return  data_format(timestamp,str) ;
	}else{
		return  data_format2(timestamp) ;
	}
}

function data_format(time,formatStr) {
	time = time || '';
	if(formatStr =='u') return data_format2(time);
    var str = formatStr;
    var Week = ['日', '一', '二', '三', '四', '五', '六'];
    if(time>0) time = time*=1000;
	var date = new Date(time);

    str = str.replace(/yyyy|YYYY|Y|YY/, date.getFullYear());
    str = str.replace(/yy|y/, (date.getYear() % 100) > 9 ? (date.getYear() % 100).toString() : '0' + (date.getYear() % 100));
    str = str.replace(/MM|mm/, (date.getMonth() + 1) > 9 ? (date.getMonth() + 1).toString() : '0' + (date.getMonth() + 1));
    str = str.replace(/M|m/g, (date.getMonth() + 1));
    str = str.replace(/w|W/g, Week[date.getDay()]);
    str = str.replace(/dd|DD/, date.getDate() > 9 ? date.getDate().toString() : '0' + date.getDate());
    str = str.replace(/d|D/g, date.getDate());
    str = str.replace(/hh|HH/, date.getHours() > 9 ? date.getHours().toString() : '0' + date.getHours());
    str = str.replace(/h|H/g, date.getHours());
    str = str.replace(/I|ii/, date.getMinutes() > 9 ? date.getMinutes().toString() : '0' + date.getMinutes());
    str = str.replace(/i/g, date.getMinutes());
    str = str.replace(/ss|SS/, date.getSeconds() > 9 ? date.getSeconds().toString() : '0' + date.getSeconds());
    str = str.replace(/s|S/g, date.getSeconds());
    return str;
}


/*
1、< 60s, 显示为“刚刚”
2、>= 1min && < 60 min, 显示与当前时间差“XX分钟前”
3、>= 60min && < 1day, 显示与当前时间差“今天 XX:XX”
4、>= 1day && < 1year, 显示日期“XX月XX日 XX:XX”
5、>= 1year, 显示具体日期“XXXX年XX月XX日 XX:XX”
*/

function data_format2(time_stamp) {

	var now_d = new Date();
	var now_time = ~~(now_d.getTime() / 1000); //获取当前时间的秒数
	var f_d = new Date();
	f_d.setTime(time_stamp);
	var f_time = f_d.toLocaleDateString();
	var ct = now_time - time_stamp;
	var day = 0;
	if (ct < 0) {
		// f_time = "【预约】" + f_d.toLocaleString();
	} else if (ct < 60) {
		f_time = Math.floor(ct) + '秒前';
	} else if (ct < 3600) {
		f_time = Math.floor(ct / 60) + '分钟前';
	} else if (ct < 86400) //一天
	{
		f_time = Math.floor(ct / 3600) + '小时前';
	} else if (ct < 604800) //7天
	{
		day = Math.floor(ct / 86400);
		if (day < 2)
			f_time = '昨天';
		else
			f_time = day + '天前';
	} else {
		day = Math.floor(ct / 86400);
		if(day>365){
			day = Math.floor(ct / 365/86400);
			f_time = day + '年前';
		}else{
			f_time = day + '天前';
		}
	}
	return f_time;
}


function appendscript(url, call) {
	if(url.indexOf('/') == -1) url ='assets/global/js/'+url;
	if(url.indexOf('.js') == -1) url+='.js';
	var tmp = url.split("/");
	var id  = tmp[tmp.length-1].replace(/\./g,'_').replace(/\?(.*)$/,'');
	var obj = document.getElementById(id);
	if(obj) {
		if(obj['_load_over'] === true){
			 if(typeof call == 'function') call(obj);
		}else{
			var check_timer = setInterval(function(){
				if(obj['_load_over'] === true){
					if(typeof call == 'function')call(obj);
					clearInterval(check_timer);
				}
			},100);
		}
		return ;
	}
    var script = document.createElement("script");
    script.type = "text/javascript";
	script.id = id;
    if (script.readyState) {
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" || script.readyState == "complete") {
                script.onreadystatechange = null;
				script._load_over = true;
                if(typeof call == 'function') call(script);
            }
        };
    } else {
        script.onload = function () {
			script._load_over = true;
           if(typeof call == 'function') call(script);
        };
    }
    script.src = url;
    document.body.appendChild(script);
}



/*--------------global end ------------------*/




/*--------------dialog start ------------------*/

var JSMENU = [];
JSMENU['active'] = [];
JSMENU['timer'] = [];
JSMENU['drag'] = [];
JSMENU['layer'] = 0;
JSMENU['zIndex'] = {'win':990000,'menu':991000,'dialog':992000,'prompt':993000};
JSMENU['float'] = '';
var EXTRAFUNC = [];
EXTRAFUNC['showmenu'] = [];


function del_array(value,arr){
    var tmp = [];
    for(var i =0;i<arr.length;i++){
        if(value != arr[i]) tmp.push(arr[i]);
    }
    return tmp;

}

function unique(array){
  var n = [];
  for(var i = 0; i < array.length; i++){
    if (n.indexOf(array[i]) == -1) n.push(array[i]);
  }
  return n;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}
function getEvent() {
	if(document.all) return window.event;
	var func = getEvent.caller;
	while(func != null) {
		var arg0 = func.arguments[0];
		if (arg0) {
			if((arg0.constructor  == Event || arg0.constructor == MouseEvent) || (typeof(arg0) == "object" && arg0.preventDefault && arg0.stopPropagation)) {
				return arg0;
			}
		}
		func=func.caller;
	}
	return null;
}
function doane(event, preventDefault, stopPropagation) {
	var preventDefault = isUndefined(preventDefault) ? 1 : preventDefault;
	var stopPropagation = isUndefined(stopPropagation) ? 1 : stopPropagation;
	var e = event ? event : window.event;
	if(!e) {
		e = getEvent();
	}
	if(!e) {
		return null;
	}
	if(preventDefault) {
		if(e.preventDefault) {
			e.preventDefault();
		} else {
			e.returnValue = false;
		}
	}
	if(stopPropagation) {
		if(e.stopPropagation) {
			e.stopPropagation();
		} else {
			e.cancelBubble = true;
		}
	}
	return e;
}



var showDialogST = null;
function showDialog(msg, mode, t, func, cover, funccancel, leftmsg, confirmtxt, canceltxt, closetime, locationtime) {

	clearTimeout(showDialogST);
	if(msg && typeof msg == 'string' && msg.indexOf('&gt;') != -1) msg = htmldecode(msg);
	cover = isUndefined(cover) ? (mode == 'info' ? 0 : 1) : cover;
	leftmsg = isUndefined(leftmsg) ? '' : leftmsg;

	mode = mode && mode == 'success' ? 'right' :mode;
	mode = mode && in_array(mode, ['confirm', 'notice', 'info', 'right','none']) ? mode : 'alert';

	var menuid = 'fwin_dialog';
	var menuObj = $('.'+menuid)[0];
	var showconfirm = 1;
	var confirmtxtdefault = '确定';
	var closetime = isUndefined(closetime) ? '' : closetime;
	var closefunc = function () {
		if(func && typeof func == 'function') func();
		hideMenu(menuid, 'dialog');
	};

	if(closetime) {
		leftmsg = closetime + ' 秒后窗口关闭';
		clearTimeout(showDialogST);
		showDialogST = setTimeout(closefunc, closetime * 1000);
		showconfirm = 0;
	}
	locationtime = isUndefined(locationtime) ? '' : locationtime;
	if(locationtime) {
		leftmsg = locationtime + ' 秒后页面跳转';
		clearTimeout(showDialogST);
		showDialogST = setTimeout(closefunc, locationtime * 1000);
		showconfirm = 0;
	}
	confirmtxt = confirmtxt ? confirmtxt : confirmtxtdefault;
	canceltxt = canceltxt ? canceltxt : '取消';

	if(menuObj) hideMenu('fwin_dialog', 'dialog');
	menuObj = document.createElement('div');
	menuObj.style.display = 'none';
	menuObj.className = 'fwinmask ' +menuid;
	menuObj.id = menuid;
	menuObj.className = menuid;
	$('.uz_system').append(menuObj);
	var hidedom = '';
	var s = hidedom + '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l">&nbsp;&nbsp;</td><td class="m_c"><h3 class="flb"><em>';
	s += t ? t : '提示信息';
	s += '</em><span><a href="javascript:;" class="fwin_dialog_close flbc" data-menuid="'+menuid+'"  title="关闭">关闭</a></span></h3>';
	s +='<div class="cl c">';
	if(mode == 'info') {
		s += msg ? msg : '';
	} else {

		var mod_img = '';
		if(mode == 'alert'){
			mod_img='alert_error';
		}else if(mode == 'right'){
			mod_img= 'alert_right' ;
		}else if(mode =='none'){
			mod_img = 'alert_none';
		}else {
			mod_img = 'alert_info';
		}

		s += '<div class="c altw"><div class="' + mod_img + '"><p>' + msg + '</p></div></div>';
		s += '<p class="o pns">' + (leftmsg ? '<span class="z xg1">' + leftmsg + '</span>' : '') + (showconfirm ? '<button class="fwin_dialog_submit" value="true" class="pn pnc">'+confirmtxt+'</button>' : '');
		s += mode == 'confirm' ? '<button class="fwin_dialog_cancel" value="true" class="pn btn" data-menuid="'+menuid+'" >'+canceltxt+'</button>' : '';
		s += '</p>';
	}
	s += '</div></td><td class="m_r"></td></tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></table>';
	menuObj.innerHTML = s;
	function close_window(){
			if(typeof funccancel == 'function') {
				funccancel();
			}
			hideMenu(menuid, 'dialog');
	}
	click('.fwin_dialog_submit',closefunc);

	click('.fwin_dialog_close',close_window);
	if($('.fwin_dialog_cancel').length>0) {
		click('.fwin_dialog_cancel',close_window);
	}

	showMenu({'mtype':'dialog','menuid':'.'+menuid,'duration':3,'pos':'00','zIndex':JSMENU['zIndex']['dialog'],'cache':0,'cover':cover});
	try {
		if($('.fwin_dialog_submit').length) $('.fwin_dialog_submit').focus();
	} catch(e) {}
}

function getCurrentStyle(obj, cssproperty, csspropertyNS) {
	if(obj.style[cssproperty]){
		return obj.style[cssproperty];
	}
	if (obj.currentStyle) {
		return obj.currentStyle[cssproperty];
	} else if (document.defaultView.getComputedStyle(obj, null)) {
		var currentStyle = document.defaultView.getComputedStyle(obj, null);
		var value = currentStyle.getPropertyValue(csspropertyNS);
		if(!value){
			value = currentStyle[cssproperty];
		}
		return value;
	} else if (window.getComputedStyle) {
		var currentStyle = window.getComputedStyle(obj, "");
		return currentStyle.getPropertyValue(csspropertyNS);
	}
}
function fetchOffset(obj, mode) {
	if(typeof obj == 'string') obj = $(obj)[0];
	var left_offset = 0, top_offset = 0, mode = !mode ? 0 : mode;

	if(obj.getBoundingClientRect && !mode) {

		var rect = obj.getBoundingClientRect();

		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		if(document.documentElement.dir == 'rtl') {
			scrollLeft = scrollLeft + document.documentElement.clientWidth - document.documentElement.scrollWidth;
		}

		left_offset = rect.left + scrollLeft - document.documentElement.clientLeft;
		top_offset = rect.top + scrollTop - document.documentElement.clientTop;
	}

	if(left_offset <= 0 || top_offset <= 0) {
		left_offset = obj.offsetLeft;
		top_offset = obj.offsetTop;
		while((obj = obj.offsetParent) != null) {
			var position = getCurrentStyle(obj, 'position', 'position');
			if(position == 'relative') {
				continue;
			}
			left_offset += obj.offsetLeft;
			top_offset += obj.offsetTop;
		}
	}

	return {'left' : left_offset, 'top' : top_offset};
}

function setMenuPosition(showid, menuid, pos) {
	var showObj = $(showid)[0];
	if(!showObj)showObj= $(showid + '_menu')[0];
	var menuObj = menuid ? $(menuid)[0] : $(showid + '_menu')[0];
	if(isUndefined(pos) || !pos) pos = '43';
	var basePoint = parseInt(pos.substr(0, 1));
	var direction = parseInt(pos.substr(1, 1));
	var important = pos.indexOf('!') != -1 ? 1 : 0;
	var sxy = 0, sx = 0, sy = 0, sw = 0, sh = 0, ml = 0, mt = 0, mw = 0, mcw = 0, mh = 0, mch = 0, bpl = 0, bpt = 0;

	if(!menuObj || (basePoint > 0 && !showObj)) return;

	if(showObj) {
		sxy = fetchOffset(showObj);
		sx = sxy['left'];
		sy = sxy['top'];
		sw = showObj.offsetWidth;
		sh = showObj.offsetHeight;
	}

	mw = menuObj.offsetWidth;
	mcw = menuObj.clientWidth;
	mh = menuObj.offsetHeight;
	mch = menuObj.clientHeight;

	switch(basePoint) {
		case 1:
			bpl = sx;
			bpt = sy;
			break;
		case 2:
			bpl = sx + sw;
			bpt = sy;
			break;
		case 3:
			bpl = sx + sw;
			bpt = sy + sh;
			break;
		case 4:
			bpl = sx;
			bpt = sy + sh;
			break;
	}
	switch(direction) {
		case 0:
			menuObj.style.left = (document.body.clientWidth - menuObj.clientWidth) / 2 + 'px';
			mt = (document.documentElement.clientHeight - menuObj.clientHeight) / 2;
			break;
		case 1:
			ml = bpl - mw;
			mt = bpt - mh;
			break;
		case 2:
			ml = bpl;
			mt = bpt - mh;
			break;
		case 3:
			ml = bpl;
			mt = bpt;
			break;
		case 4:
			ml = bpl - mw;
			mt = bpt;
			break;
	}
	var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
	var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);

	if(!important) {

		if(in_array(direction, [1, 4]) && ml < 0) {

			ml = bpl;
			if(in_array(basePoint, [1, 4])) ml += sw;
		} else if(ml + mw > scrollLeft + document.body.clientWidth && sx >= mw) {

			ml = bpl - mw;
			if(in_array(basePoint, [2, 3])) {
				ml -= sw;
			} else if(basePoint == 4) {
				ml += sw;
			}
		}
		if(in_array(direction, [1, 2]) && mt < 0) {

			mt = bpt;
			if(in_array(basePoint, [1, 2])) mt += sh;
		} else if(mt + mh > scrollTop + document.documentElement.clientHeight && sy >= mh) {

			mt = bpt - mh;
			if(in_array(basePoint, [3, 4])) mt -= sh;
		}
	}

	if(pos.substr(0, 3) == '210') {
		ml += 69 - sw / 2;
		mt -= 5;
		if(showObj.tagName == 'TEXTAREA') {
			ml -= sw / 2;
			mt += sh / 2;
		}
	}


	if(direction == 0 || menuObj.scrolly) {
		if(BROWSER.ie && BROWSER.ie < 7) {
			if(direction == 0) mt += scrollTop;
		} else {
			if(menuObj.scrolly) mt -= scrollTop;
			menuObj.style.position = 'fixed';
		}
	}else{

	}


	var dc = document.documentElement.clientHeight;

	if(getCurrentStyle(menuObj,'height') == 'auto'){
		var top =300;
	}else{
		//var top = parseInt(dc-parseInt(getCurrentStyle(menuObj,'height'))  )/2;
		var top =mt;
	}

	if(ml) menuObj.style.left = ml + 'px';
	if(mt) menuObj.style.top = top+ 'px';

	if(direction == 0 && BROWSER.ie && !document.documentElement.clientHeight) {
		menuObj.style.position = 'absolute';
		menuObj.style.top = (document.body.clientHeight - menuObj.clientHeight) / 2 + 'px';

	}

	if(menuObj.style.clip && !BROWSER.opera) {
		menuObj.style.clip = 'rect(auto, auto, auto, auto)';
	}

}
function showMenu(v) {
	var ctrlid = isUndefined(v['ctrlid']) ? '' : (v['ctrlid'] && typeof v['ctrlid'] == 'string' && v['ctrlid'].substr(0,1) !='.' ? '.'+v['ctrlid']:v['ctrlid']);
	var showid = isUndefined(v['showid']) ? ctrlid : (v['showid'] && typeof v['showid'] == 'string' && v['showid'].substr(0,1) !='.' ? '.'+v['showid']:v['showid']);
	var menuid = isUndefined(v['menuid']) ? showid + '_menu' :(v['menuid'] && typeof v['menuid'] == 'string' && v['menuid'].substr(0,1) !='.' ? '.'+v['menuid']:v['menuid']);
	var ctrlObj = $(ctrlid)[0];
	var menuObj = $(menuid)[0];

	if(!menuObj) return;

	var mtype = isUndefined(v['mtype']) ? 'menu' : v['mtype'];
	var evt = isUndefined(v['evt']) ? 'mouseover' : v['evt'];
	var pos = isUndefined(v['pos']) ? '43' : v['pos'];
	var layer = isUndefined(v['layer']) ? 1 : v['layer'];
	var duration = isUndefined(v['duration']) ? 2 : v['duration'];
	var timeout = isUndefined(v['timeout']) ? 250 : v['timeout'];
	var maxh = isUndefined(v['maxh']) ? 600 : v['maxh'];
	var cache = isUndefined(v['cache']) ? 1 : v['cache'];
	var drag = '';
	var dragobj = '';

	var cover = isUndefined(v['cover']) ? 0 : v['cover'];
	var zindex = isUndefined(v['zindex']) ? JSMENU['zIndex']['menu'] : v['zindex'];

	var ctrlclass = isUndefined(v['ctrlclass']) ? '' : v['ctrlclass'];
	var winhandlekey = isUndefined(v['win']) ? '' : v['win'];
	var zindex = cover ? zindex + 99 : zindex;


	if(typeof JSMENU['active'][layer] == 'undefined') {
		JSMENU['active'][layer] = [];
	}

	/*for(i in EXTRAFUNC['showmenu']) {
		try {
			eval(EXTRAFUNC['showmenu'][i] + '()');
		} catch(e) {}
	}*/

	if(evt == 'click' && in_array(menuid, JSMENU['active'][layer]) && mtype != 'win') {
		hideMenu(menuid, mtype);
		return;
	}
	if (mtype == 'menu')
		hideMenu(layer, mtype);

	if (ctrlObj && $(ctrlObj).attr( 'fwin')) {
		menuObj.scrolly = true;
	}
	try {
		if (mtype != 'dialog')
			menuObj.style.position = 'absolute';
	} catch (e) {
	}

	menuObj.style.zIndex = zindex + layer;

	$(menuObj).click(function(e){
		return doane(e, 0, 1);
	});


	if(ctrlObj) {
		if(!ctrlObj.getAttribute('initialized')) {
			ctrlObj.setAttribute('initialized', true);
			ctrlObj.unselectable = true;

			ctrlObj.outfunc = typeof ctrlObj.onmouseout == 'function' ? ctrlObj.onmouseout : null;
			ctrlObj.onmouseout = function() {
				if(this.outfunc) this.outfunc();
				if(duration < 3 && !JSMENU['timer'][menuid]) {
					JSMENU['timer'][menuid] = setTimeout(function () {
						hideMenu(menuid, mtype);
					}, timeout);
				}
			};

			ctrlObj.overfunc = typeof ctrlObj.onmouseover == 'function' ? ctrlObj.onmouseover : null;
			ctrlObj.onmouseover = function(e) {
				doane(e);
				if(this.overfunc) this.overfunc();
				if(evt == 'click') {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				} else {
					for(var i in JSMENU['timer']) {
						if(JSMENU['timer'][i]) {
							clearTimeout(JSMENU['timer'][i]);
							JSMENU['timer'][i] = null;
						}
					}
				}
			};
		}
	}



		if(duration < 3) {
			if(duration > 1) {
				hover(menuObj,function(){
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				});
			}
			if(duration != 1) {
				hover(menuObj,function(){},function(){
					JSMENU['timer'][menuid] = setTimeout(function () {
						hideMenu(menuid, mtype);
					}, timeout);
				});

			}


		}

	if(cover) {
		var coverObj = document.createElement('div');
		coverObj.className = menuid.substr(1) + '_cover fwin_cover';
		menuObj.cover = 1;
		coverObj.style.position  = 'absolute';
		try{
			//coverObj.style.position  = 'fixed';
		}catch(e){
			//coverObj.style.position  = 'absolute';
		}

		coverObj.style.zIndex = menuObj.style.zIndex - 1;
		coverObj.style.left = coverObj.style.top = '0px';
		coverObj.style.width = '100%';
		coverObj.style.height = Math.max(document.documentElement.clientHeight, document.body.offsetHeight) + 'px';
		coverObj.style.backgroundColor = '#000';
		coverObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=50)';
		coverObj.style.filter = 'Alpha(opacity=50)';
		coverObj.style.opacity = 0.6;
		$(coverObj).click(hideMenu);
		$('.uz_system').append(coverObj);

		coverObj.style.height = Math.max(document.documentElement.clientHeight, document.body.offsetHeight) + 'px';
	}




	if(cover) $(menuid + '_cover').show();
	menuObj.style.display = 'block';

	if(ctrlObj && ctrlclass) {
		ctrlObj.className += ' ' + ctrlclass;
		menuObj.setAttribute('ctrlid', ctrlid);
		menuObj.setAttribute('ctrlclass', ctrlclass);
	}


	if(pos != '*')  setMenuPosition(showid, menuid, pos);

	if(BROWSER.ie){
		var  h= getCurrentStyle(menuObj,'height');
		if(h =='auto') h  =300;
		var dt = document.documentElement.clientHeight ;
		var top = parseInt(dt-parseInt(h)  )/2;
		menuObj.style.top = top + 'px';

	}

	if(maxh && menuObj.scrollHeight > maxh) {
		menuObj.style.height = maxh + 'px';
		if(BROWSER.opera) {
			menuObj.style.overflow = 'auto';
		} else {
			menuObj.style.overflowY = 'auto';
		}
	}

	if(!duration) {
		setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
	}

	if(!in_array(menuid, JSMENU['active'][layer])) JSMENU['active'][layer].push(menuid);
	if(layer > JSMENU['layer']) {
		JSMENU['layer'] = layer;
	}

}

function hideMenu(attr, mtype) {
	attr = isUndefined(attr) ? '' : (attr && typeof attr == 'string' && attr.substr(0,1) !='.' ? '.'+attr:attr);
	mtype = isUndefined(mtype) ? 'menu' : mtype;

	if(attr == '') {
		for(var i = 1; i <= JSMENU['layer']; i++) {
			hideMenu(i, mtype);
		}
		return;
	} else if(typeof attr == 'number') {
		for(var j in JSMENU['active'][attr]) {
			hideMenu(JSMENU['active'][attr][j], mtype);
		}
		return;
	}else if(typeof attr == 'string') {
		var menuObj = $(attr)[0];

		if(!menuObj || (menuObj.mtype && mtype && menuObj.mtype != mtype)) return;
		var ctrlObj = '', ctrlclass = '';
		if((ctrlObj == $(menuObj).attr('ctrlid')) && (ctrlclass == $(menuObj).attr('ctrlclass'))) {
			var reg = new RegExp(' ' + ctrlclass);
			ctrlObj.className = ctrlObj.className.replace(reg, '');
		}
		clearTimeout(JSMENU['timer'][attr]);
		var hide = function() {

			if(mtype == 'dialog'){
				menuObj.parentNode.removeChild(menuObj);
				$(attr + '_cover').remove();
			}else{
				$(attr).hide();
				if(menuObj.cover) $(attr + '_cover').remove();
			}

			var tmp = [];
			for(var k in JSMENU['active'][menuObj.layer]) {
				if(attr != JSMENU['active'][menuObj.layer][k]) tmp.push(JSMENU['active'][menuObj.layer][k]);
			}
			JSMENU['active'][menuObj.layer] = tmp;
		};
		hide();
	}
}

function showError(msg) {
	if(msg !== '')  showDialog(msg, 'alert', '错误信息', null, true, null, '', '', '', 10);
}

function showWindow(k, url, mode, cache, menuv) {
	mode = isUndefined(mode) ? 'get' : mode;
	cache = isUndefined(cache) ? 1 : cache;
	var menuid = 'fwin_' + k;
	var menuObj = $('.'+menuid)[0];
	var drag = null;
	var loadingst = null;
	var hidedom = '';

	var fetchContent = function() {

		if(mode == 'get') {
			ajaxget(url, function(s) {
						if(!s) return false;
						var html ='<h3 class="flb"><em>提示</em><span><a title="关闭" class="fwin_window_close_'+k+' flbc" target="_blank">关闭</a></span></h3>';
						html += s.msg;
						$('.fwin_content_' + k).html(html);
						initMenu();
						show();

						$(".fwin_window_close_"+k).click(function(){
							hideWindow(k,false);
						});

			});
		} else if(mode == 'post') {
			menuObj.act = D(url).action;
			ajaxpost(url, 'fwin_content_' + k, '', '', '', function() {initMenu();show();});
		}
		if(parseInt(BROWSER.ie) != 6) {
			loadingst = setTimeout(function() {showDialog('', 'info', '<img src="assets/images/default/loading.gif"> 请稍候...')}, 500);
		}
		return false;
	};

	var initMenu = function() {
		clearTimeout(loadingst);
	};

	var show = function() {
		hideMenu('fwin_dialog', 'dialog');
		var v = {'mtype':'win','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['win'],'cache':cache,'cover':'1'};
		for(k in menuv) {
			v[k] = menuv[k];
		}

		showMenu(v);
	};

	if(!menuObj) {
		menuObj = document.createElement('div');
		menuObj.id = menuid;
		menuObj.className = 'fwinmask '+menuid;
		menuObj.style.display = 'none';
		$('.uz_system').append(menuObj);
		var evt = '';
		var html = '';
		html = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"' + evt + '></td><td class="t_r"></td></tr><tr><td class="m_l"' + evt + '></td><td class="m_c fwin_content_' + k + '"><div class="cl c">'
		html+= '</div></td><td class="m_r"' + evt + '></td></tr><tr><td class="b_l"></td><td class="b_c"' + evt + '></td><td class="b_r"></td></tr></table>';
		menuObj.innerHTML=html;
		if(mode == 'html') {
			$('.fwin_content_' + k).html(html);
			initMenu();
			show();
		} else {
			fetchContent();
		}

	} else if(mode == 'get') {
		fetchContent();
	} else {
		show();
	}
	doane();
}

//显示纯文字,或是不带事件的window弹窗,克隆显示,不影响原元素
function showHtml(className,size,isAddEvent){
	size = size || 0;
	if(className.indexOf('.') == -1) className ='.'+className;
	if($(className).length>0){
		var obj = $(className).clone(true);
	}else{
		var obj = $(className+"_menu").clone(true);
	}
	if(!obj){
		L('className is not exists');
		return ;
	}
	obj.show();
	showContent(obj, size);
}
//显示纯文字,或是不带事件的window弹窗
function showContent(text, size) {
	size = size || 0;
	var k = 'content_box';
	var menuid = 'fwin_' + k;
	var menuObj = $('.'+menuid)[0];
	var drag = null;
	var loadingst = null;
	var hidedom = '';

	var fetchContent = function() {
		  var html ='<h3 class="flb"><em>提示</em><span><a title="关闭" class="fwin_window_close_'+k+' flbc" target="_blank">关闭</a></span></h3>';
		  html += '<div class="content_box content_box_'+size+'"></div>';
		  $('.fwin_content_' + k).html(html);
		  $('.fwin_content_' + k).find('.content_box').append(text);


		  clearTimeout(loadingst);
		  show();
		  $(".fwin_window_close_"+k).click(function(){
			  hideWindow(k,false);
		  });

	};

	var show = function() {
		hideMenu('fwin_dialog', 'dialog');

		var v = {'mtype':'win','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['win'],'cache':0,'cover':'1'};
		showMenu(v);
	};
	if(!menuObj) {
			menuObj = document.createElement('div');
			menuObj.id = menuid;
			menuObj.className = 'fwinmask '+menuid;
			menuObj.style.display = 'none';
			$('.uz_system').append(menuObj);
			var evt = '';
			var html = '';
			html = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"' + evt + '></td><td class="t_r"></td></tr><tr><td class="m_l"' + evt + '></td><td class="m_c fwin_content_' + k + '"><div class="cl c">'
			html+= '</div></td><td class="m_r"' + evt + '></td></tr><tr><td class="b_l"></td><td class="b_c"' + evt + '></td><td class="b_r"></td></tr></table>';
			menuObj.innerHTML=html;
			fetchContent();
	} else {
		show();
	}
	doane();
}

//将原HTML的内容弹窗显示出来
function showWrapHtml(className,size){
	var str = "";
	size = size || 0;
	var k  = 'wrap_html';
	str+='<div id="fwin_'+k+'" class="fwinmask fwin_'+k+'" >';
	str+='<table cellpadding="0" cellspacing="0" class="fwin">';
	str+='<tbody><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r">';
	str+='</td></tr><tr><td class="m_l"></td><td class="m_c fwin_content_'+k+'">';
	str+='<h3 class="flb"><em>提示</em><span>';
	str+='<a title="关闭" class="fwin_window_close_'+k+' flbc" target="_blank">关闭</a>';
	str+='</span></h3> <div class="content_box content_box_'+size+'">您今日已签到,待明日再来吧</div>';
	str+='</td><td class="m_r"></td></tr><tr><td class="b_l">';
	str+='</td><td class="b_c"></td><td class="b_r">';
	str+='</td></tr></tbody></table></div>';
	//$(className).show().wrap(str);
	//$(str).wrap(className);

}
function hideWindow(k, all, clear) {
	all = isUndefined(all) ? 1 : all;
	clear = isUndefined(clear) ? 1 : clear;
	hideMenu('fwin_' + k, 'win');

	if(clear && $('.fwin_' + k).length>0) {
		$('.uz_system .fwin_' + k ).remove();
		$('.fwin_' + k+'_cover').remove();

	}

	if(all) hideMenu();
}

function htmldecode ( str ) {
	var converter = document.createElement("div");
	converter.innerHTML = str;
	var output = converter.innerText;
//var output = converter.innerHTML.
	converter = null;
	//output = output.replace(/eval|cookie|String|form|window|src/ig,'');
	return output;
}


//绑定showWindow
$('.showwindow').click(function(e){

	var json = $(this).attr('data-config');
	var url = '';
	var key = 'showwindow_box';
	if(json){
		json = $.parseJSON(json);
		url = json.url;
		if(json.key)key = json.key;
	}else{
		if( $(this).attr('data-key'))key =  $(this).attr('data-key');
		url = $(this).attr('data-url') ? $(this).attr('data-url') : (this.href && this.href!='#' && this.href!='javascript:;'? this.href :'') ;
	}

	if(!url || !key) return false;
	ajaxget(url, function(s) {
					if(!s) return false;
					var k = key;
					var menuid = 'fwin_' + k;
					var menuObj = document.createElement('div');
					menuObj.className = 'fwinmask '+menuid;
					var evt = '';
					var html = '';
					html = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"' + evt + '></td><td class="t_r"></td></tr><tr><td class="m_l"' + evt + '></td><td class="m_c fwin_content_' + k + '">'
					html +='<h3 class="flb"><em>提示</em><span><a title="关闭" class="fwin_window_close_'+k+' flbc" target="_blank">关闭</a></span></h3><div class="cl c">';
					html += s.msg;
					html+= '</div></td><td class="m_r"' + evt + '></td></tr><tr><td class="b_l"></td><td class="b_c"' + evt + '></td><td class="b_r"></td></tr></table>';
					menuObj.innerHTML = html;
					$('.uz_system').append(menuObj);
					hideMenu('fwin_dialog', 'dialog');
					showMenu({'mtype':'win','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['win'],'cache':0,'cover':'1'});



					$(".fwin_window_close_"+k).click(function(){

					});hideWindow(k,false);

		});

	doane(e);
	return false;
})

/*--------------dialog end ------------------*/









/*--------------------------------------------------------------------模板才需要的----------------------------------------------------------------*/









function time(){
	return Date.parse(new Date());
}
function U(str){
	return typeof str == 'undefined' ? true : false;
}


//绑定更换商品图片
if((CURMODULE == 'apply') || (CURMODULE == 'goods' && CURACTION =='post')){
		//绑定更换商品图片
		$('.change_pic').click(function(){
			var index = parseInt($(this).attr('data-index'));
			var url = $('.change_pic_value').eq(index).val();
			if(!url) return false;
			var org_url =$('.change_pic_main').val();
			$('.change_pic_main').val(url);
			$('.change_pic_value').eq(index).val(org_url);
			return false;
		});
}
//报名AJAX查询
if(CURMODULE == 'apply'){
	$('.apply_check_btn').click(function(){
		var id =$('.apply_check_value').val();
		if(!id){
			showDialog('请填写商品ID或链接');
			return false;
		}
		id = encodeURIComponent(id);
		ajaxget("/index.php?m=apply&a=apply_check_ajax&id="+id,function(s){
			showDialog(s.msg,s.status);
		});
        return false;

	})
}

function strlen(str){
   return str.replace(/[^\x00-\xff]/g, "**").length;
}

function get_keywords(title,call){
		if(!title) return false;
		var value = encodeURIComponent(title);
		$.ajax({type:'POST',url:'/index.php?m=ajax&a=keywords',data:{title:value},success:function(s){

			if(typeof s != 'object' || !s || s.status!='success' || typeof s.data !='string') return false;
			if(typeof call =='function') call(s.data);
		},dataType:'json'});
}

var Dialog ={
		//status = 'success/error/alert/notice/question/forbidden/';
		length:0,
		show : function(msg,status,time,call){

			this.length++;
			status = status || 'error';

			var html = '<div class="dialog_box dialog_status-'+status+'">';
			//html += '<div class="dialog_shadow"></div>';
			html += '<div class="dialog_content">';
			html += '<div class="dialog_text"><pre><a class="dialog_icon"></a>'+msg+'</pre></div></div></div>';
			var n = document.createElement("div");
			n.className ='dialog_main dialog_box_'+this.length;
			n.innerHTML =html;

			$('.uz_system').append(n);

			var box = $(n).children(".dialog_box");
			var content = $(n).find(".dialog_content")[0];
			var height=content.outerHeight();
			var width=content.outerWidth();
			var w = 0;

				w =$(window).width();

			var left = (w-width)/2-50;
			box.css({'width':width,'left':left,'top':0-height});
			content.css({'width':width});
			var _this = this;
			$(box).animate({top:0},500,'',function(){
				time = time || 3500;
				setTimeout(function(){
					_this.hide(box);
					if(typeof call == 'function') call();
				},time);
				$(n).click(function(){
					_this.hide(box);
				});
			})
		},hide:function(box){
			box = box || '.dialog_box';
			var p = $(box).parents('.dialog_main');
			var height = p.find('.dialog_content').outerHeight();
			$(box).animate({top:-10-height},500,'',function(){
				if(typeof call == 'function') call();
				p.remove();
			})
		},info:function(msg,status,time,call){



			var _this = this;
			$(".dialog_info_hint").remove();

			if(!status) status = 'error';
			var status_class = 'dialog_info_'+status;
			var html = '<div class="dialog_info_hint dialog_info_suc cl '+status_class+'">';
			html += '<div class="dialog_info_status"></div><div class="dialog_info_con"></div></div>';
			var box = $(html);
			box.appendTo('.uz_system').show();
			var content = box.find(".dialog_info_con");
			this.length++;
			content.html(msg);
			var w = 0;
			var h = 0;

				w =$(window).width();
				h=$(window).height();

			w = parseInt(w);
			h = parseInt(h);

			var top=h/2-150;

			var width=content.outerWidth();
			var left = (w-width)/2;

			box.css({'left':left,top:top,'z-index':9999999});
			var class_name =  '';
			if(status =='success' || status =='none'){
				class_name='bouncein';
			}else if(status =='error'){
				class_name='shake';
			}else if(status =='info'){
				class_name='bounce';
			}
			box.addClass(class_name);
			time = time || 4000;

			 function remove(time){
				   setTimeout(function(){
				 	 box.addClass('bounceout');
						 setTimeout(function(){
							 box.remove();
							 if(typeof call == 'function') call();
							_this.length--;
						},1000);
			 	   },time);
			 }
			 remove(time);
			 box.click(function(){
				remove(50);
				if(typeof call == 'function') call();
			});
		}
}




function C(cookieName, cookieValue, time, path, domain, secure){

	if(typeof cookieValue == 'undefined') return getcookie(cookieName);
	setcookie(cookieName, cookieValue, time, path, domain, secure);
}

function is_login(e){

	if(!USERNAME && !UID){
			var msg = '请先登录站点后才能进行操作';
			var referer = encodeURIComponent(URL);
			var url = '/index.php?m=member&a=login&referer='+referer;

		  showDialog(msg,'confirm','',function(){
			  //jump(url);
			 window.open(url);
		  });
		return false;
	}

	return true;
}


function _save(name, data) {
		if(window.localStorage){
			return localStorage.setItem('ttae_' + name, data);
		} else if(window.sessionStorage){
			return sessionStorage.setItem('ttae_' + name, data);
		}else{
			return false;
		}

}

function _load(name) {
	if(window.localStorage){
		return localStorage.getItem('ttae_' + name);
	} else if(window.sessionStorage){
		return sessionStorage.getItem('ttae_' + name);
	} else{
		return false;
	}
}



var cookiepre = 'ttae_';
function setcookie(cookieName, cookieValue, time, path, domain, secure) {

	var expires = new Date();
	if(cookieValue == '' || time < 0) {
		cookieValue = '';
		time = -2592000;
	}
	expires.setTime(expires.getTime() + time * 1000);
	domain = !domain ? '' : domain;
	path = !path ? '/' : path;
	document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

function getcookie(name) {
	var result = null;
    var myCookie = ""+document.cookie+";";
    var searchName = cookiepre+name+"=";
    var satrt = myCookie.indexOf(searchName);
    var end;
    if(satrt != -1){
        satrt += searchName.length;
        end = myCookie.indexOf(";",satrt);
       result = unescape(myCookie.substring(satrt,end));
    }
    return result;
}






function share(){
	var types = ['qqzone','weibo','t','renren','kaixin','douban'];
	$('.share,.sns-widget').click(function(){
		var aid = $(this).attr('data-aid');
		var append = $(this).attr('data-append');
		var text =  $(this).attr('data-text');
		if(!text) {
			text='';
		}else{
			text='<p>'+text+'</p>';
		}
		var html = '<div class="share_box">'+text+'<p>';
		for(var i =0;i<types.length;i++){
			  var url = '/index.php?a=share';
			  if(aid) url+='&id='+aid;
			  url+="&type="+types[i];
			  html +='<a href="'+url+'" target="_blank" class="share_'+types[i]+'"></a>';
		}
		html+='</p></div>';
		if(append) {
			$(this).append(html);
		}else{
			showDialog(html,'none','分享');
		}
		return false;
	});
}

function copy(el,value,callback){
		var src = 'assets/global/js/jquery.zclip.js';
		if($(el).attr('init') ==1) return ;
		appendscript(src,function(){
				$(el).zclip({
					path:'assets/global/images/copy.swf',
					copy:value,
					afterCopy: function(){

						$(el).attr('init',1);
						if(typeof callback == 'function'){
							callback(this);
						}else{
							Dialog.info('已复制', 'success');
						}
					}
				});
		});

}


function copy_data(data,call){
	var str = '<textarea class="copy_box" style="width:500px;height: 550px;position: fixed;top:0px;left:-9999px;z-index: 99999999;"></textarea>';
	$('body').append(str);
	var el = $('.copy_box');
	el.val(data).focus().select();
	var rt = document.execCommand('copy', false, null);
	if(!rt) return false;
	el.remove();
	if (call && typeof call == 'function') {
		call();
	} else {
		alert('复制到剪贴版成功');
	}
	return true;
}

function str_to_json(str){
	if(typeof str == 'object') return str;
	var obj = '';
	str = $.trim(str);
	try{
		obj = eval('('+str+')');
	}catch(e){
		try{
			obj = JSON.parse(str);
		}catch(e1){
			try{
				obj  = new Function("return " + str)();
			}catch(e2){
				obj = false;
			}
		}
	}
	return obj;
}

function json(data){
	if(typeof data == 'string'){
		return str_to_json(data);
	}else if(typeof data == 'object'){
		return JSON.stringify(data);
	}

	return null;
}

function get_url(obj){

		var url = '';
		if($(obj).attr('data-url')){
			url=	 $(obj).attr('data-url')
		}else if($(obj).attr('href')){
			var href = $(obj).attr('href');
			if(href && href!='#' && href!='javascript:;'){
				url = href;
			}
		}
		if(url && url.charAt(0) != '/'){
			url = '/index.php?'+url;
		}
		return url;
}



function hash(string, length) {
	var length = length ? length : 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for(i = 0; i < filllen; i++){
		string += "0";
	}
	while(start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for(var i=0; i<max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}



function m_get_goods(num_iid,call){
	if(!/^\d{10,15}$/.test(num_iid)) num_iid = sub_str(num_iid+'&','id=','&');

	var url = '/index.php?m=ajax&a=m_get_goods&num_iid='+num_iid;
	$.ajax({type:'GET',url:url,data:'','dataType':'json',success:function(s){
		if(s.status == 'error'){
			Dialog.info(s.msg,s.status);
			return ;
		}
		if(typeof call == 'function')call(s.data);
		return ;
	}})
}

function run_bg(obj,arr,height){
	var h = document.documentElement.clientHeight;
	var run_obj = [];
	var max = 0;
	var y = 0;
	var now = 0;
	var down = true;
	var el = $(obj);
	var count = 0;

	for(var i =0;i<arr.length;i++){
		var img = new Image();
		img.src = arr[i];
		img.index = i;
		img.onload = function(){

			var tmp =  {'picurl':this.src,width:this.width,height:this.height,max:0,index:this.index};
			tmp.max = h-this.height;
			run_obj[this.index] = tmp;
			if(count==0){
				now = this.index;
				run_bg_start();
			}
			count++;
		}
	}

	function run_bg_start(){
			el.addClass('pulse').css({'background':'url('+run_obj[now].picurl+') no-repeat'});

			run_bg_timer = setInterval(function(){

				var this_max = run_obj[now].max;
				if(down){
					y--;
					if(y<this_max) {
						el.removeClass('pulse');
						down = !down;
						y++;
					}

				}else{

					y++;
					if(y<this_max || y >0){
						y--;
						down = !down;
						now++;
						if(now>=run_obj.length)now=0;
						el.addClass('pulse').css({'background':'url('+run_obj[now].picurl+') no-repeat'});
					}
				}
				el.css({'background-position': '50% '+y+'px'});
			},50);

	}

}
function cover_img(src){
		var picurl ='';
		if(!src) return '';
		if(src.indexOf('.png') != -1){
			  var t = sub_str(picurl,'.png',-1);
		  }else{
			  var t = sub_str(picurl,'.jpg',-1);
		  }
		  try{
			  var reg = new RegExp(t);
			  picurl = picurl.replace(t,'');
		  }catch(e){
			  picurl = picurl.replace(/_(\d+)x([a-z0-9A-Z]+)(\.jpg)$/,'');
		  };
		if(picurl.indexOf('.jpg') == -1)  picurl = src.replace(/_(\d+)x(.*?)$/,'');
		  return picurl;
}
function _onerror(obj){

	if (!obj.complete || typeof obj.naturalWidth == "undefined" || obj.naturalWidth == 0) {

	  try{
	  	obj.complete = true;
	  }catch(e){};
	  var src =  obj.src;

	  if(src.indexOf('.jpg_')  == -1  && src.indexOf('.png_')  == -1 ){
		  return true;
	  }

	  if(src.indexOf('alimmdn.com') != -1){
		  var ext = sub_str(src,'.jpg',-1);
		  //_150x150.jpg	org
		  //@150w_150h.jpg    new
		  ext = ext.replace(/^_/,'@');
		  ext = ext.replace(/x/,'w_');
		  ext = ext.replace(/\./,'h.');
		  ext = ext.replace("10000",'1000');
		  var new_src  = src.replace(/\.jpg(.*)/,'')+'.jpg';
		  obj.src = new_src + ext;
	  }else{
		 var img =  cover_img(src);
		 if(img)obj.src = img;
	  }
	  obj.onerror=null;
	}
}

function tb_search(input){
	appendscript('tb_search',function(){
		var js = '_'+name;
		new _tb_search(input);
	});
}


function $F(url,call){
	appendscript(url,function(){
		if(typeof call == 'function'){
			var obj = window[''+url];
			if(typeof window[''+url] == 'object' && obj!=null){
				call.call(obj);
			}else{
				 call();
			}
		}
	});
}


function upload(el,config,callback){
	$F('upload',function(){
			if(typeof callback!='function'){
				callback = function(file, rs){

					if(typeof rs == 'string')rs = json(rs);
					if(typeof rs != 'object'){
						Dialog.info('上传失败');
						L(rs);
						L(file.xhr.responseText);
						return ;
					}

					if(rs.status == 'success'){

						if(!file.uploading){
							$(this).show().val(rs.data);
							var size = $(this).attr('data-max');
							if(size && size>1){
								//cfg.multi = true;
								append_item(this,rs.data);
							}else{

								this.uploadifive('destroy');
								ondel(this,rs.data);
							}
						}
					}else{
						Dialog.info(rs.msg);
					}
				}
			}
			function append_item(obj,picurl,par){
								if(!par){
									par = $(obj).parent().parent();
								}
								var upload_items=par.find('.upload_items')
								if(par.length ==0){
									var upload_items = $('<div class="upload_items"></div>');
									par.prepend(upload_items);
								}else{
									var upload_items = par.find('.upload_items');
								}
								var name = $(obj).attr('data-name');
								var html = '<div class="upload_item _hover_img">';
								html+='<input name="'+name+'" value="'+picurl+'" type="text" class="txt">';
								html+='&nbsp;<a href="#"  class="upload_del" >删除</a></div>';

								upload_items.append(html);
			}
			$('body').on('click','.upload_del',function(){
				$(this).parents('.upload_item').remove();
				return false;
			});
		  var cfg = {'auto': true,'buttonText':'点击上传',

			  'checkScript'      : '',itemTemplate:'','formData': {timestamp:'',token:''},
			  'queueID'          : '',removeCompleted:true,multi:false,
			  'fileObjName':'file','fileType':['png','jpg','jpeg','gif'],buttonClass:'upload_parent',
			  'uploadScript'     : '/index.php?m=index&a=upload&j=1',
			  'onUploadComplete' : callback
			  };
			if(config && typeof config =='object')cfg = $.extend(cfg,config);
			function ondel(obj,picurl){
							var hv = $('<a href="'+picurl+'" target="_blank"><img src="'+picurl+'"  /></a>');
							var del =$('<a href=""  class="ajax_del" >&nbsp;&nbsp;删除</a>');

							if($(obj).parents(".upload_item").find('a').length<2){
								$(obj).after(del);
								$(obj).after(hv);
							}
							del.click(function(){
									obj.uploadifive(cfg);
									hv.parents('._hover_img').removeAttr('data-init');
									hv.remove();
									del.remove();
									//ip.remove();
									return false;
							});
			}
			//$(el).uploadifive(cfg);
			$(el).each(function(){
				var size = $(this).attr('data-max');
				cfg.multi = false;
				if(size &&size >1) cfg.multi = true;
				var pic = $(this).val();
				if( cfg.multi){
					$(this).attr('data-name',$(this).attr('name'));
					$(this).attr('name','');
					var par = $(this).parent()	;
					if(par.find('.upload_items').length >0){
						var images = par.find('.upload_items').attr('data-images');
						if(images){
							var img = images.split(',');
							for(var i =0;i<img.length;i++){
								append_item(this,img[i],par);
							}
						}

					}

				}
				//多图上传
				if(!cfg.multi && pic && !$(this).attr('data-init')){
					$(this).show();
					ondel($(this),pic);
				}else{
					$(this).uploadifive(cfg);
				}
			});
	});
}
