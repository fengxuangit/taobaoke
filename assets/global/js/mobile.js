var DEBUG =true;
var BROWSER = {};
var CURMODULE = null,CURSCRIPT=null,CURACTION=null,$_GET={},TAE=false,UID=false,USERNAME=false,QQ_ZONE=false,DUOSHUO_KEY='',LEFT_BAR = 0,CNZZID=0;
var URL  =location.href;
var TAE = false;

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

function L(s){
	console.log(s);
}



function ajaxget(url,success,dataType){
			try{
				var type = dataType ?dataType:'json';
					$.ajax({type:'GET',url:url,data:'',success:function(s){		
						if(s['msg'] &&( s.msg.indexOf('&gt;') != -1 || s['html'] ==1))s.msg = htmldecode(s.msg);							
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



function is_login(e){
	
	if(!USERNAME && !UID){
			var msg = '请先登录站点后才能进行操作';
			var referer = encodeURIComponent(URL);
			var url = '/index.php?m=member&a=login&referer='+referer;
	
		  showDialog(msg,'error',4000,function(){			
			  //jump(url);
			 window.open(url);
			//location.herf = url;
		  });
		return false;
	}

	return true;
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

function click(obj,fun){
	$(obj).click(fun);
}

function htmldecode ( str ) { 
	var converter = document.createElement("div"); 
	converter.innerHTML = str; 
	var output = converter.innerText; 
	converter = null; 
	return output; 
} 



function _scroll(call,obj){
	if(obj){
			$(obj).scroll(function(e){
				var top =  $(this).scrollTop();
				call(top,this);
			})
	}else{
		$(window).scroll(function(e){
				if(document.documentElement && document.documentElement['scrollTop']){
					var el = document.documentElement;
				}else{
					var el = document.body;
				}
				call(el.scrollTop,el);
		})
	}
}

var Dialog = {
	info:function(msg,status,time,call){
		showDialog(msg,status,time,call);
	}
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



function  showDialog (msg,status,time,call){
			$(".dialog_info_hint").remove();
			
			if(!status) status = 'error';
			var status_class = 'dialog_info_'+status;
			var html = '<div class="dialog_info_hint dialog_info_suc cl '+status_class+'">';
			html += '<div class="dialog_info_status"></div><div class="dialog_info_con"></div></div>';
			var box = $(html);	
			box.appendTo('.uz_system')
			box.show();
			
			var content = box.find(".dialog_info_con");
			this.length++;
			content.html(msg);
			var w = 0;
			var h = 0;			
			
				w =$(window).width();
				h=$(window).height();

			
			w = parseInt(w);
			h = parseInt(h);
			
			var top=h/2-30;
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
							 if(typeof call == 'function')	call();
						},1000);
			 	   },time);
			 }
			 remove(time);
			 box.click(function(){
				remove(50); 
			});
}


function C(cookieName, cookieValue, time, path, domain, secure){
	if(typeof cookieValue == 'undefined') return getcookie(cookieName);
	setcookie(cookieName, cookieValue, time, path, domain, secure);
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


function del_array(value,arr){
    var tmp = [];
    for(var i =0;i<arr.length;i++){
        if(value != arr[i]) tmp.push(arr[i]);
    }
    return tmp;

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

//browser.weixin

var browser={
	  trident:navigator.userAgent.indexOf('Trident') > -1, //IE内核
	  presto:navigator.userAgent.indexOf('Presto') > -1, //opera内核
	  webkit:navigator.userAgent.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
	  gecko:navigator.userAgent.indexOf('Gecko') > -1 && navigator.userAgent.indexOf('KHTML') == -1, //火狐内核
	  mobile: !!navigator.userAgent.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
	  ios: !!navigator.userAgent.match(/i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
	  android:navigator.userAgent.indexOf('Android') > -1 || navigator.userAgent.indexOf('Linux') > -1, //android终端或uc浏览器
	  iphone:navigator.userAgent.indexOf('iPhone') > -1 , //是否为iPhone或者QQHD浏览器
	  ipad:navigator.userAgent.indexOf('iPad') > -1, //是否iPad
	  weixin:navigator.userAgent.indexOf('MicroMessenger') > -1, //是否微信
	  webapp:navigator.userAgent.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
	  uc:navigator.userAgent.match(/UCBrowser/i) == "UCBrowser",
	  qq:navigator.userAgent.match(/MQQBrowser/i) == "MQQBrowser",
    };
for(var i in browser){
	if(browser[i])$('html').addClass(i);
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



var _hook = {
	init:function(){
				this.ajax_dialog();
				this.init_click();
				this.tdj();
				this.weixin();
				this.yzm();
				this.onsubmit();
				this.pupup();
				this.img_onerror();
				this.duoshuo();
				this.baidu_share();
				this.start_time();
				this.dgmdate();
	},
	ajax_dialog:function(){
				var el =  '._ajax_dialog,._ajaxDialog';		
				if($(el).length == 0) return ;			
				$(el).click(function(){
					var url = $(this).attr('data-url') ? $(this).attr('data-url') : (this.href && this.href!='#' && this.href!='javascript:;'? this.href :'') ;
					if(!url) return false;
					ajaxget(url,function(s){
						showDialog(s.msg,s.status);
					});
					return false;
					
				});
	},init_click:function(){
			var tk = $("meta[name='tk']").attr('content').split('|');
		
		  $("a[isconvert='1']").click(function(){
		  var href = $(this).attr('href');
		
		  if(typeof alimamatk_show != 'function' || (tk[2] ==1 && (href.indexOf('item.htm?id=') != -1 || href.indexOf('num_iid=')!=-1 ))){
			  var iid = $(this).attr('data-itemid');
			   if(!iid && $(this).attr('num_iid')) iid = $(this).attr('num_iid');
			  
			  if(!iid && $(this).attr('href')){
				   var url = $(this).attr('href')+'&';
				    if(url.indexOf('id=') == -1){
						return ;
					}
				   iid = sub_str(url,'id=','&');				   
			  }
			  
			  var url = '/index.php?a=go_pay&num_iid='+iid;
			  var shop =   $(this).attr('data-shop');
			  if(!shop) shop = $(this).attr('data-sellerid');
			  if(shop)url+="&shop=1";
			  $(this).attr('href',url);	 
		  }else{
			 L('淘点金加载失败,当前URL未找到淘宝相关链接'); 
		  }
		 });
	  
	},tdj:function(type,call){

			var tk = $("meta[name='tk']").attr('content').split('|');
			var pid = tk[0];
			var url = tk[1];
			type = type ||  tk[2];
			//type =1 ,tdj 1.0接口, type =2 , tdj 2.0 接口
			if(typeof tdj != 'object') appendscript("assets/global/js/tdj.js",call);	
			
			if(type ==2){				
					//2.0必须域名和pid申请时的一致才行,就是说非当前这个站点申请的pid,无法在其它域名下使用. 1.0的可以
					var o = {pid: pid,appkey:'',unid: "",evid: "",type: "click",plugins: [{name: "keyword"},{name: "aroundbox"}]};
					var mamaLoad = window.alimamatk_onload || [];
					mamaLoad.push(o);
			}

	},weixin:function(){
			// if (browser.weixin) {
			// 	var html = '<div class="is-weixin ad hide">';
			// 	html+='<img src="http://img02.taobaocdn.com/imgextra/i2/1038081966/TB2.yqpbpXXXXc_XXXXXXXXXXXX_!!1038081966-2-tae.png">';
			// 	html+='</div>';
			// 	$(html).appendTo('body');
			// 	$(function(){
			// 			$('a').click(function(){
			// 					  var url=$(this).attr('href');
			// 					  if(url.indexOf('num_iid') != -1 || url.indexOf('item.htm') !=-1){
			// 						   $(".is-weixin").show();
			// 						  return false;
			// 					}
			// 			});
			// 	})
				
			// }
		
	},dialog:function(){
			$("._ajax_dialog").click(function(){
				var href = $(this).attr('href');
				if(href && href!='#'){
					var url = href;
				}else{
					var url = $(this).attr('data-url')
				}
				if(!url) return false;			
				 ajaxget(url,function(s){
						s.msg = decodeURIComponent(s.msg);			
						if(s.html == 1)  s.msg = htmldecode(s.msg);
						s.msg = s.msg.replace(/\+/g,'');
						showDialog(s.msg,s.status);
				 });
				return false;
			});	
		
			$(".showdialog").click(function(){
				var msg =$(this).attr('data-msg');
				var status =$(this).attr('data-status');
				showDialog(msg,status);
				return false;
			});
	},yzm:function(){
				var  el =  ".yzm,.yzm_img";
				$('body').on('click',el,function(){
					$('.yzm_img').attr('src','/index.php?m=ajax&a=yzm&t='+Math.random());
					return false;
				})
	},onsubmit:function(){
				var el =  '._onsubmit';
				
				$('body').on('click',el,function(){
					var form = $(this).attr('data-form');
					if(!form){
						 form =$(this).closest('form');
					}else{
						form = $(form);
					}
					form.get(0).submit();
					//form.trigger('submit');
					return false;
				});	
	},pupup:function(){
		var _this = this;
		$('body').on('click','._popup',function(){
			var url = $(this).attr('data-url');
			if(!url) {
				url = $(this).attr('href');
				if(!$(this).attr('data-url')){
					$(this).attr('data-url',$(this).attr('href'));
				}
			}
			if(!url) return ;
			if(url.indexOf('?') == -1) url +='?';
			url+='&html=1';
			var id = $(this).attr('data-id');
			if(!id){
				id = id || 'popup_'+_random(8);
				$(this).attr('data-id',id);				
			}
			if($('#'+id).length>0){				
				$.popup('#'+id);
				return ;
			}
			//var callback = $(this).attr('data-callback');
			//if(window[callback])callback = window[callback];			
			$.ajax({type:'GET',url:url,data:'',success:function(s){
				if(typeof s =='object'){
					if(s.status =='error'){
						$.toast(s.msg);
						return ;
					}					
				}
				_this.show_popup(s,id);
				if(typeof popup_callback =='function')popup_callback(s);
			},error:function(){
				$.toast(s.msg);
			}})
			$(this).removeAttr('href');
			return false;
		});		
	},show_popup:function(rs,id,call){
		var close_popup = '<div class="content-padded"><span class="y  close-popup close-popup_top" data-popup="'+'#'+id+'"></span></div>';
		var close_popup2 = '<div class="content-padded"><span class="y close-popup close-popup_bottom" data-popup="'+'#'+id+'"></span></div>';
		var content = '<div class="popup" id="'+id+'">'+close_popup+rs+close_popup2+'</div>';
		$("body").append(content);
		$.popup('#'+id);
		
		//if($('#'+id).height()>700)$('#'+id).find('.close-popup_bottom').show();
		if(call && typeof call == 'function')call($('#'+id),rs);
	},img_onerror:function(e){
			  $('img').each(function(){
				  if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {					 
					  return _onerror(this);
				  }
			  });			  
	},duoshuo:function(){
				var  el= '._duoshuo';
				var len = $(el).length;
				if(len == 0)return;
				
				var name = DUOSHUO_KEY;
				if(!name) return ;
				var id = $(el).attr('data-id');					
				if(!id) id = $_GET['id'] ? $_GET['id'] : ($_GET['aid'] ? $_GET['aid'] : $_GET['num_iid']);
				if(!id) id= $_GET['itemid'];
				$(el).attr({'data-url':location.href,'data-title':document.title, 'data-thread-key':CURMODULE+'_'+CURACTION+'_'+id});
			
				$(el).addClass('ds-thread');
				window.duoshuoQuery = {short_name:name};
				appendscript('http://static.duoshuo.com/embed.js',function(){					
					
				});
				
				
	},baidu_share:function(){
			var el =  '._share'; 		
			var len = $(el).length;
			if( len== 0) return;
			var share_config = {
				common : {bdText : '',bdDesc : '',bdUrl : '', bdPic : ''},
				share : []
			}

			$('._share').each(function(i){
				if($(this).attr('init') ==1) return true;
				$(this).attr('init',1);
				
				
				var tmp_html = $(this).html();
				if(!tmp_html || !$.trim(tmp_html)){
					var more = true;
					if(!U($(this).attr('data-more')))  more = false;
					
					var count = true;
					if(!U($(this).attr('data-count')))  count = false;
					
					var html = '<a class="bds_qzone" data-cmd="qzone" href="#"></a>	';
						html+='<a class="bds_tsina" data-cmd="tsina"></a>';
						html+='<a class="bds_weixin" data-cmd="weixin"></a>';
						html+='<a class="bds_sqq" data-cmd="sqq"></a>';
						html+='<a class="bds_renren" data-cmd="renren"></a>';
						html+='<a class="bds_tqq" data-cmd="tqq"></a>';
						if(more)html+='<a class="bds_more" data-cmd="more"></a>';
						if(count)html+='<a class="bds_count" data-cmd="count"></a>';

					$(this).html(html);
				}
				
				
				var id = i;
				
				if(!id || _check.is_int(id) !== true)  id = i;
				id = 100+id;
				
				
				$(this).addClass('share_tag_'+id).attr('data-tag',id);		
				
				var size = $(this).attr('data-size') ? $(this).attr('data-size') :24;	//16｜24｜32
				var style = $(this).attr('data-style') ? $(this).attr('data-style') :0;	//0,1,2
				
				
				var user_style = '';
				if(style === '0') user_style = 'assets/global/css/null.css';
				$(this).addClass('bdsharebuttonbox');
				function add_t_uid (url){
						
						if(!url) return '';
						var str = '';
						if(url.indexOf('#') != -1) url = url.replace(/#(.*)$/i,'');
						//去掉QQ空间后的默认链接
						//if(url.indexOf('#0-') != -1)url = url.replace(/#0-(.*?)/i,'');
						
						if(url.indexOf('/u/') != -1 || url.indexOf('&uid=') != -1 ) return url;
						
						if(!UID) return url;
						if(url.indexOf('.php') != -1){
							str = url+'&u='+UID;
						}else if(url.indexOf('.html') != -1){
							str = url.replace(/\.html/,'')+'/u/'+UID+'.html';
						}else if(url.substr(-1) == '/'){
							str = url+'u/'+UID+'/';
						}else if(url.indexOf('?') == -1){
							str = url+'?u='+UID;
						}else if(url.indexOf('&u=') == -1 && url.indexOf('/u/') == -1 && url.indexOf('?u=') == -1 ){
							str = url+'&u='+UID;
						}else{
							str = url;
						}
						
						return str;
				}
				
				share_config.share.push({'tag':id,'bdSize':size,bdStyle:style,bdCustomStyle:user_style});
				share_config.common.onBeforeClick = function(cmd,cfg){
					var obj = $('.share_tag_'+cfg.tag);			
					var url = obj.attr('data-url');
					if(url){
						if(url.charAt(0) == '/' )  url = HOST+url; 
					}else{
						url = URL;
					}					
					url = add_t_uid(url);					
					
					var picurl = obj.attr('data-picurl');
					if(picurl && picurl.indexOf('http') == -1){
						picurl =  HOST+'/'+picurl; 
					}
					var desc = obj.attr('data-desc');
					if(!desc)desc = obj.attr('data-content');					
					if(!desc)desc = $("meta[name='description']").attr('content');
					
					var config = {
						bdText: obj.attr('data-title') ? obj.attr('data-title') : document.title,
						bdUrl : url,
						bdPic : picurl,
						bdDesc :desc			
					};
					return config;			
				}
				
				share_config.common.onAfterClick = function(cmd){
					//var url = '/index.php?m=ajax&a=share_callback&id='+id+'&type='+cmd;
					//ajaxget(url);
				}
				
			});
			
			var s = ~(-new Date()/36e5);
			window._bd_share_config = share_config;
			var url = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+s;
			appendscript(url);
					
			
			
			
		},start_time:function(){
				var el =  '._start_time';
				if($(el).length == 0) return ;
				function start(obj, Day,text,type,tag){
						var today = new Date();	
						if(!tag) tag = 'em';
						var timeold = (Day.getTime() - today.getTime());
						var html = '';
						if(timeold < 0) {
							html = '<'+tag+'>0</'+tag+'> '+type[0]+' <'+tag+'>0</'+tag+'> '+type[1]+' <'+tag+'>0</'+tag+'>';
							obj.html(html);
							return;
						}
						
						setTimeout(function () { start(obj, Day,text,type,tag); }, 1000);
						
						var sectimeold = timeold / 1000 ;
						var secondsold = Math.floor(sectimeold);
						var msPerDay = 86400000;
						var e_daysold = timeold / msPerDay
						var daysold = Math.floor(e_daysold);
						var e_hrsold = (e_daysold - daysold) * 24;
						var hrsold = Math.floor(e_hrsold);
						var e_minsold = (e_hrsold - hrsold) * 60;
						var minsold = Math.floor((e_hrsold - hrsold) * 60);
						var seconds = Math.floor((e_minsold - minsold) * 60);
						if(hrsold < 10) {
							hrsold = '0' + hrsold;
						}
						if(minsold < 10) {
							minsold = '0' + minsold;
						}
						if(seconds < 10) {
							seconds = '0' + seconds;
						}
						if(!type) type = ['时','分',"秒"];
						
						html = text + (daysold ? '<'+tag+'>' + daysold + '</'+tag+'>天' : '') + '<'+tag+'>' + 
											hrsold + '</'+tag+'>'+type[0]+'<'+tag+'>' + minsold + '</'+tag+'>'+type[1]+'<'+tag+'>' + seconds + '</'+tag+'>';
						obj.html(html);
				}						
				$(el).each(function(){
						var _this = $(this);
						var time  = parseInt(_this.attr('data-time'));		
						  if(!isNaN(time) && time && time>0){
							  time =  time*1000;				
							  var text = _this.attr('data-text');
							  text = text ? text :'';						
							  var type =_this.attr('data-type');	
							  type = (typeof type == 'string') ? type.split("|") :[':',':'];	
							  var tag = _this.attr('data-tag');					
							  tag = tag ?tag :'b';
							  var o = $(this);
							  start(o,new Date(time),text,type,tag);		
						  }
				});
	},dgmdate:function(){
		var el = '._dgmdate';
		if($(el).length == 0) return ;
		$(el).each(function(){
			var time = $(this).attr('data-time');
			var type = $(this).attr('data-type');

			if(!time) time = '';
			var rs = dgmdate(time,type);
			$(this).append(rs);
		});

	}
}
function U(str){
	return typeof str == 'undefined' ? true : false;
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
function fetchOffset(obj, mode) {
	obj = $(obj)[0];
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

function $F(url,call){
	appendscript(url,call);
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
	  }else if(src.indexOf('assets/') != -1){
		 var img =  cover_img(src);
		 if(img)obj.src = img;
	  }
	  obj.onerror=null;
	} 
}



var aui = {
	id:'',
	remove:function(){
		if(this.id)$('#'+this.id).remove();
		this.remove_layer();
	},
	confirm:function(title,content,ok,cancel){
				var text = '';
				var id = 'aui_confirm_el';
				this.id = id;
				$('#'+id).remove();
				
				text+='<div class="aui-dialog layer_bg_index" id="'+id+'">';
		        text+='<div class="aui-dialog-header"> <div class="iconfont"></div>'+title+'</div>';
		        text+='<div class="aui-dialog-body aui-text-left">'+content+'</div>';
		        text+='<div class="aui-dialog-footer">';
		        text+='<div class="aui-dialog-btn aui-text-danger aui_cancel_btn" tapmode >取消</div>';
		        text+='<div class="aui-dialog-btn aui-text-info aui_ok_btn" tapmode >确定</div>';
		        text+='</div></div>';
		        var cfg = {title:title,content:content,ok:ok,cancel:cancel};
		        var _this  =this;
    			$(text).appendTo('body').css('background','#fff');
    			this.add_layer();

				$('#'+id).find('.aui_cancel_btn').click(function(){
					if(cancel) cancel.call(_this,id);
					_this.remove();
					return false;
				});
				$('#'+id).find('.aui_ok_btn').click(function(){
					if(ok) ok.call(_this,id);
					_this.remove();
					return false;
				});
				
	},toast:function(msg,time){
		time = ~~time || 3000;
		var text = '';
		var id = 'aui_toast_el';
		$('#'+id).remove();
		this.id = id;

		text+='<div class="aui-toast bouncein" id="'+id+'">';
	    text+='<i class="aui-iconfont aui-icon-check"></i>';
	    text+='<div class="aui-toast-content">'+msg+'</div></div>';
	    $('body').append(text);
	    var _this = this;
	    setTimeout(function(){
	    	_this.remove();
	    },time);
	    return $('#'+id)
	},loading:function(time){
		time = ~~time || 5000;
		var text = '';
		var id = 'aui_loading';
		$('#'+id).remove();
		this.id = id;
		
		text+='<div class="aui-toast"  id="'+id+'" >';
		text+='<div class="aui-toast-loading"></div>';
		text+='<div class="aui-toast-content">加载中</div></div>';
		$('body').append(text);
		var _this = this;
	    this.add_layer();

		    setTimeout(function(){
		    	_this.remove();
		    },time);
	    
	
	},tip:function(title,cls,click,parent){
		//cls = danger warning  primary success error
		if(cls =='error') cls = 'danger';
		var clss = 'aui-tips-';
		clss += cls ? cls :'warning';
		var text = '';
		var id = 'aui_tip_el';
		$('#'+id).remove();
		this.id = id;
		
		text+='<div class="aui-tips '+clss+'" id="'+id+'">';
	    text+='<div class="aui-tips-content aui-ellipsis-1" >';
	    text+='<i class="aui-iconfont aui-icon-warnfill"></i>';
	    text+= title;
	    text+='<i class="aui-iconfont aui-icon-roundclosefill" tapmode ></i>';
	    text+=' </div></div>';
	   	var par = parent || 'body';
	   
	    $(text).prependTo(par).click(function(){
	    	_this.remove();
	    	if(click) click();
	    	return false;
	    });

	},add_layer:function(){
		var height = Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);
		$('<div class="layer_bg"></div>').appendTo('body').css({height:height});
	},remove_layer:function(){
		$('.layer_bg').remove();
	},app_open_goods:function(urlscheme,rs){
		 if(location.href.indexOf('refresh=1') > -1) {
		 	 location.reload();
		 	 return ;
		 }
		var data = '';
		if(typeof rs == 'object'){
			for(var i in rs){
				data+='&'+i+'='+rs[i];
			}
		}else{
			data = rs;
		}

        location.href = urlscheme+'://?'+data;
        // setTimeout(function () {
        //         location.href += '&refresh=1' // 附加一个特殊参数，用来标识这次刷新不要再调用myapp:// 了
        // }, 1500);

	}
}
function go_top(stime){
               var acceleration = 0.1;
              stime = stime || 10;
               var x1 = 0;
               var y1 = 0;
               var x2 = 0;
               var y2 = 0;
               var x3 = 0;
               var y3 = 0; 
               if (document.documentElement) {
                   x1 = document.documentElement.scrollLeft || 0;
                   y1 = document.documentElement.scrollTop || 0;
               }
               if (document.body) {
                   x2 = document.body.scrollLeft || 0;
                   y2 = document.body.scrollTop || 0;
               }
               var x3 = window.scrollX || 0;
               var y3 = window.scrollY || 0;
             
               // 滚动条到页面顶部的水平距离
               var x = Math.max(x1, Math.max(x2, x3));
               // 滚动条到页面顶部的垂直距离
               var y = Math.max(y1, Math.max(y2, y3));
             
               // 滚动距离 = 目前距离 / 速度, 因为距离原来越小, 速度是大于 1 的数, 所以滚动距离会越来越小
               var speeding = 1 + acceleration;
               window.scrollTo(Math.floor(x / speeding), Math.floor(y / speeding));
               // 如果距离不为零, 继续调用函数
               if(x > 0 || y > 0) {
                   window.setTimeout(go_top, stime);
               }
           
    }




function open_url(url,open,app_data){
		if(!url) return ;
		var is_weixin = false;
		if(navigator.userAgent.toLowerCase().indexOf('micromessenger') > -1) {
			is_weixin = true;
			open = false;
		}
		if(url[0] == '/' || url[0] == '?' || url.indexOf(location.host) >-1) {
			if(is_weixin && url.indexOf('a=go_pay') > -1){
				url = 'assets/common/jump.html?jumpurl='+encodeURIComponent(url);
			}else{
				open = false;
			}
		}else if(is_weixin || app_data){
				url = 'assets/common/jump.html?jumpurl='+encodeURIComponent(url);
		}

		if(is_weixin ||  (app_data && typeof app_data == 'object')){
			if('open_app' in app_data) url+='&open_app='+app_data.open_app;
			if('num_iid' in app_data) url+='&num_iid='+app_data.num_iid;
			if('key' in app_data) url+='&key='+app_data.key;
			if('a' in app_data) url+='&a='+app_data.a;
		}

		if(open){
			window.open(url)
		}else{
			location.href = url;
		}
}




if('Zepto' in window){
		Zepto.fn.outerWidth = function() {
		    return $(this).width();
		}
	}
$(function(){
	
	_hook.init();
})


