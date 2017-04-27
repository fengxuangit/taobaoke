var _hook = {
	init:function(get){
		if(get) return this;
		this.jquery_extends();
		this.addfavorite();
		this.check_status();
		this.start_time();
		this.hover_img();
		this.calendar();
		this.del();
		this.keywords();
		this._confirm();
		this.onfocus();
		this.show_dialog();
		this.ajax_dialog();
		this.go_top();
		this.click_show();
		this.check_form();
		this.onsubmit();
		this.wangwang();
		this.qq();
		this.debug_info();
		this.ueditor();
		this.form();

		this.dgmdate();
		this.check_login();
		this.get_goods();
		this.init_tdj();
		this.ding();
		this.one_key_share();
		this.duoshuo();
		this.baidu_share();
		this.yzm();
		
		this.show_content();
		this.hide_menu();
		this.init_click();
		this.auto_ad();
		this.show_menu();
		this.baidu_push();
		this.init_comment();
		this.init_upload();
		//var _this = this;
		//setTimeout(function(){
			this.img_onerror();
		//},00)
	},
	jquery_extends:function(){

			(function($) {
					$.fn.scrollLoading = function(options) {
						var defaults = {
							attr: "data-url",
							container: $(window),
							callback: $.noop
						};
						var params = $.extend({}, defaults, options || {});
						params.cache = [];
						$(this).each(function() {
							var node = this.nodeName.toLowerCase(), url = $(this).attr(params["attr"]);
							//重组
							var data = {
								obj: $(this),
								tag: node,
								url: url
							};
							params.cache.push(data);
						});

						var callback = function(call) {
							if ($.isFunction(params.callback)) {
								params.callback.call(call.get(0));
							}
						};

						//动态显示数据
						var loading = function() {

							var contHeight = params.container.height();
							if (params.container.get(0) === window) {
								contop = $(window).scrollTop();
							} else {
								contop = params.container.offset().top;
							}

							$.each(params.cache, function(i, data) {

								var o = data.obj, tag = data.tag, url = data.url, post, posb;

								if (o) {
									post = o.offset().top - contop, posb = post + o.height();
									if ((post >= 0 && post < contHeight) || (posb > 0 && posb <= contHeight)) {

										if (url) {
											//在浏览器窗口内
											if (tag === "img") {
												//图片，改变src
												callback(o.attr("src", url));
											} else {
												o.load(url, {}, function() {
													callback(o);
												});
											}
										} else {
											// 无地址，直接触发回调
											callback(o);
										}
										data.obj = null;
									}
								}
							});
						};

						//事件触发
						//加载完毕即执行
						loading();
						//滚动执行
						params.container.bind("scroll", loading);
					};
				})(jQuery);

				$("._loading,_loadding").scrollLoading({
						attr:'data-src',
						container: $(window),
						callback: function() {
							$(this).addClass("FadeIn");
							//$(this).hide().fadeIn(200);
								/*if($(this).attr('init_load') !=1 ){
									$(this).hide().fadeIn(500).attr('init_load',1);
								}*/
						}
				});

	},
	addfavorite:function(){
				var el =  '._addfavorite';
				if($(el).length == 0) return ;
				click(el,function(){
					var siteurl =  'http://'+getHost(URL);
					addFavorite(siteurl, document.title);
					return false;
				});
	},
	check_status:function(){
				var el =  '._check_status';
				if($(el).length == 0) return ;
				$(el).each(function(){
							var check =parseInt($(this).attr('data-check'));
							var text= '待审核';
							if(check ==1){
								text = '已通过';
							}else if(check==2){
								text = '已拒绝';
							}
							$(this).html(text);
							if(check !=1)$(this).addClass('red');
							$(this).click(function(){
									var _this = $(this);
									var url =_this.attr('href');
									if(!url || url == '#' || url.indexOf('javascript') != -1)url = _this.attr('data-url');
									var status = parseInt(_this.attr('data-check'));
									if(_this.attr('data-default')){
										var df =_this.attr('data-default').split('|');
										status++;
										if(status>=df.length)status = 0;
										var t = parseInt(df[status]);
									}else{
										var t = status == 1 ? 0 :1;
									}

									url  = url.replace(/check=(\d)/,'');

									ajaxget(url+'&check='+t+'&inajax=1',function(s){
										if(s.status == 'success'){

											_this.attr('data-check',t);
											_this.html(s.msg) ;
											if(t==1){
												_this.removeClass('red');
											}else{
												_this.addClass('red');
											}
										}
										Dialog.info(s.msg,s.status);
									});
								return false;
							});
				});
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
						  if(_this.attr('init') == 1) return true;
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
							   _this.attr('init',1);
							  start(o,new Date(time),text,type,tag);
						  }
				});
	},hover_img:function(){
				var el =  '._hover_img';
				if($(el).length == 0) return ;
				hover(el,function(){
						var img = $(this).find('a>img').eq(0);

						var len = img.length;
						if(len==0 || !img.attr('src')) return true;
						var height = $(this).height();
						if($(this).attr('data-init') !=1){

								if($(this).attr('data-left')){
									var left = parseInt($(this).attr('data-left'));
									img.css({'left':left});
								}else{
									img.css({'left':parseInt($(this).width())/2});
								}
								if($(this).attr('data-bottom')) img.css({'bottom': parseInt($(this).attr('data-bottom'))});
								var he = $(this).attr('data-top') ? parseInt($(this).attr('data-top')):height;
								if(he!=0)img.css({'top': he});
								if($(this).attr('data-right')) img.css({'right': parseInt($(this).attr('data-right'))});
								$(this).attr('data-init',1);
						}
						img.show();


				},function(){
					 var img = $(this).find('a>img').eq(0);
					  var len = img.length;
					  if(len>0 && img.attr('src')) img.hide();
				})
	},
	calendar:function(){
				var el =  "._dateline";
				if($(el).length == 0) return ;
				var controlid = null;
							var currdate = null;
							var startdate = null;
							var enddate  = null;
							var halfhour = false;
							var yy = null;
							var mm = null;
							var dds = null;
							var hh = null;
							var ii = null;
							var currday = null;
							var addtime = false;
							var today = new Date();
							var lastcheckedyear = false;
							var lastcheckedmonth = false;


							function loadcalendar() {
								var s = '';
								s += '<div class="calendar" style="display:none; position:absolute; z-index:100000;">';
								s += '<div style="width: 210px;"><table cellspacing="0" cellpadding="0" width="100%" style="text-align: center;">';
								s += '<tr align="center" class="calendar_week"><td  title="上一月" >';
								s +='<a href="javascript:;" class="up_month" >&laquo;</a></td>';
								s += '<td colspan="5" style="text-align: center"><a href="javascript:;" title="点击选择年份" class="year dropmenu"></a> - ';
								s += '<a class="month dropmenu" title="点击选择月份" href="javascript:;"></a></td>';
								s += '<td  title="下一月" ><a href="javascript:;" class="next_month">&raquo;</a></td></tr>';
								s += '<tr class="calendar_header"><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>';

							var len = 0;
								for(var i = 0; i < 6; i++) {
									s += '<tr>';
									for(var j = 1; j <= 7; j++)
										if(i == 0){

											s += "<td class='calendar_td d" + j + "' height=\"19\">0</td>";
										}else{
											s += "<td class='calendar_td d" + (i * 7 + j) + "' height=\"19\">0</td>";
										}
									s += "</tr>";
								}

								s += '<tr class="hourminute pns"><td colspan="4" align="left">';
								s+='<select class="minutehalfhourly hour" ><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option></select>';


								s += '<span class="fullhourselector"><select class="minute" >';
								s +='<option value="00">00</option><option value="30">30</option></select></span>';
								s += '</td><td align="right" colspan="3" style="position:relative;">';
								s += '<div  class="timeee_m">';
								s += '<a  class="timeee">00</a> <a  class="timeee">10</a> <a  class="timeee">15</a> <a  class="timeee">20</a>';
								s += '</div>';

								s += '<button class="pn cur_ok" ><em>确定</em></button></td></tr>';
								s += '</table></div></div>';
								var div = document.createElement('div');
								div.innerHTML = s;

								var uz_sys = $('.uz_system')[0];
								if(uz_sys)uz_sys.appendChild(div);


								$('body').click(function(event){
									closecalendar();
								});

								$('.up_month').click(function(event){
									refreshcalendar(yy, mm-1);
									return false;
								});

								$('.next_month').click(function(event){
									refreshcalendar(yy, mm+1);
									return false;
								});

								$('.month,.year,.calendar').click(function(event){
									return false;
								});

								$('.cur_ok').click(confirmcalendar);

								$('.timeee').click(function(event){
									var value = this.innerHTML;
									select_option('.minutehalfhourly',value);
									settime(dds);
									return false;
								});


								$('.minutehalfhourly,.minute').change(function() {
									settime(dds);
									return false;
								});

								$('.minutehalfhourly,.minute').click(function(){
									return false;
								});


								$(".calendar").on('click',".calendar_td",function(){
										dds = $(this).children().eq(0).html();
										settime(dds);
										$(".calendar td").removeClass('calendar_checked');
										$(this).addClass('calendar_checked');
										return false;
								});

							}


							function closecalendar() {
								$('.calendar').hide();

							}

							function parsedate(s) {
								if(!s) return false;
								var s1 = s.split(" ");
								var s2 = s1[0].split("-");
								var m1 = s2[0];
								var m2 = s2[1];
								var m3 = s2[2];
								if(s1[1]){
										var s3 = s1[1].split(":");
										var m4 = s3[0];
										var m5 = s3[1];
								}else{
										m4 = 0;
										m5 = 0;
								}
								yy = m1;
								mm = m2;
								dds = m3;
								hh = m4;
								ii = m5;

								$('.hour').val(hh);
								$('.minute').val(ii);

								$(".calendar td").removeClass('calendar_checked')
								$('.day_'+m3).addClass('calendar_checked');
								return new Date(m1, m2 - 1, m3, m4, m5);
							}

							function settime(d) {
								if(!addtime) {
									$('.calendar').hide();
								}
								controlid.value = yy + "-" + zerofill(mm + 1) + "-" + zerofill(d) +
								(addtime ? ' ' + zerofill($('.hour').val()) + ':' +
									zerofill($((halfhour).length>0 ? '.minutehalfhourly' : '.minute').value) : '');
							}

							function confirmcalendar() {
								settime(dds);
								closecalendar();
							}

							function showcalendar( controlid1, addtime1, startdate1, enddate1, halfhour1) {

								controlid = controlid1;
								addtime = addtime1;
								startdate = startdate1 ? parsedate(startdate1) : false;
								enddate = enddate1 ? parsedate(enddate1) : false;
								currday = controlid.value ? parsedate(controlid.value) : today;

								hh =  $('.hour').val() ?  zerofill($('.hour').val()) :currday.getHours();
								ii =  $('.minute').val() ?  zerofill($('.minute').val()) :currday.getMinutes();

								halfhour = halfhour1 ? true : false;
								var p = fetchOffset(controlid);

								$('.calendar').show();

								var top = parseInt($(controlid).css('padding-top'));
								var left = parseInt($(controlid).css('padding-left'));


								$('.calendar').css({'left':p['left']});
								$('.calendar').css({'top':p['top']+20});



								refreshcalendar(currday.getFullYear(), currday.getMonth());

								if(addtime){
									$('.hourminute').show();
								}else{
									$('.hourminute').hide();
								}

								lastcheckedyear = currday.getFullYear();
								lastcheckedmonth = currday.getMonth() + 1;
								return false;
							}

							function refreshcalendar(y, m) {

								var x = new Date(y, m, 1);
								var mv = x.getDay();
								var d = x.getDate();
								var dd = dds ? dds :null;
								yy = x.getFullYear();
								mm = x.getMonth();
								$(".year").html(yy);
								$(".month").html( mm + 1 > 9  ? (mm + 1) : '0' + (mm + 1));

								for(var i = 1; i <= mv; i++) {
									$(".d" + i).html('&nbsp;');
								}

								while(x.getMonth() == mm) {
									dd = $(".d" + (d + mv)).addClass('cursor').html('<a href="javascript:;">' + d + '</a>').addClass('day_'+d);
									if(x.getTime() < today.getTime() || (enddate && x.getTime() > enddate.getTime()) ||
											(startdate && x.getTime() < startdate.getTime())) {
											dd.addClass('calendar_expire');

									} else {
											dd.addClass('calendar_default');
									}
									if(x.getFullYear() == today.getFullYear() && x.getMonth() == today.getMonth() && x.getDate() == today.getDate()) {
										dd.addClass('calendar_today');
										dds = d;
										dd.children().eq(0).attr('title','今天');
									}
									if(x.getFullYear() == currday.getFullYear() && x.getMonth() == currday.getMonth() &&
											 x.getDate() == currday.getDate()) {
										$(".calendar td").removeClass('calendar_checked');
										dd.addClass('calendar_checked');
									}
									x.setDate(++d);
								}

								while(d + mv <= 42) {
									$(".d" +  (d + mv)).html('&nbsp;');
									d++;
								}

								if(addtime) {
									$('.hour').val(zerofill(hh));
									$('.minute').val(zerofill(ii));
								}
							}

							function showdiv(id) {
								var p = fetchOffset($('.'+id)[0]);

								$('.calendar_' + id).css({left:p['left'],top:p['top']+16}).show();


							}

							function zerofill(s) {
								var s = parseFloat(s);
								s = isNaN(s) ? 0 : s;
								return (s < 10 ? '0' : '') + s.toString();
							}

							loadcalendar();
							$(el).each(function(){
									if(typeof this.value == 'udefined'|| this.value=='0' || this.value=='null') this.value = '';
									if(this.value.length == 10){
										this.value = dgmdate(this.value,'Y-m-d hh:ii');
									}

									$(this).click(function(){
										if(typeof this.value == 'udefined'|| this.value=='0' || this.value=='null') this.value = '';
										showcalendar( this,this.alt ? this.alt :1);
										return false;
									})
							});
	},
	del:function(){
					var el = ".submit_btn";
					if($(el).length == 0) return ;

					$("._del_all").click(function(){

						$('._del').each(function(i){
							if(this.checked == true){
								this.checked =false;
							}else{
								this.checked =true;
							}

						});


					});
					$('.submit_btn').click(function(){

								var count = 0;
								if($('._del').length>0){
										$('._del').each(function(){
											if(this.checked) count++;
										});
										if(count == 0){
											Dialog.info('您必须选择至少一行才能提交...');
											return false;
										}
								}


					});


	},
	keywords:function(input,output){

				input = input || '._keywords';
				output = output || '._in_keywords';
				if($(input+','+output).length == 0) return ;
				$(input).blur(function (){

					get_keywords(this.value,function(tag){
						 if($(output).val()=='')$(output).val(tag);
					})
				});


	},
	_confirm:function(){
				var el =  "._confirm";
				if($(el).length == 0) return ;
				$(el).each(function(){
					$(this).click(function(){
						 var msg = $(this).attr('data-msg');
						  if(!msg) msg =  $(this).attr('data-text');
						  if(!msg) return true;
						  var url =  this.href && this.href!='#' && this.href!='javascript:;'? this.href: $(this).attr('data-url') ;
						   url = tae_url(url);
							showDialog(msg,'confirm','',function(){
								if(url)jump(url);
							});
							return false;
					});
				});

	},
	onfocus:function(){
				var el =  '._onfocus';
				if($(el).length == 0) return ;
				$(el).each(function(){
					var org_kw =$(this).attr('data-kw');
					var value = $(this).val();
					if(typeof org_kw == 'string')if(!value)$(this).val(org_kw);
					$(this).focus(function(){
							var kw =$(this).attr('data-kw');
							if(kw && $(this).val() == kw){
								$(this).val('');
							}
							$(this).addClass('on');
					});
					$(this).blur(function(){
							var kw =$(this).attr('data-kw');
							if(kw && $(this).val() == ''){
								$(this).val(kw)	;
							}
							if(!$(this).val() || $(this).val() == '') $(this).removeClass('on');
					});
				});

	},ajax_dialog:function(){
				var el =  '._ajax_dialog,._ajaxDialog';
				if($(el).length == 0) return ;
				$(el).click(function(){
						var json = $(this).attr('data-config');
						var info = $(this).attr('data-info');
						var url = '';
						if(json){
							json = $.parseJSON(json);
							url = json.url;
						}else{
							url = $(this).attr('data-url') ? $(this).attr('data-url') : (this.href && this.href!='#' && this.href!='javascript:;'? this.href :'') ;
						}
						if(typeof admin_url == 'string') url+='&ok=1';
						var that = this;
						if(!url) return false;
						  ajaxget(url,function(s){
								s.msg = decodeURIComponent(s.msg);
								s.msg = s.msg.replace(/\+/g,'');
								if(typeof s.url == 'string' &&  s.url != ''){
									var url =  decodeURIComponent(s.url);
									url = tae_url(url);

									Dialog.info(s.msg,s.status,'',function(){
										jump(url);
									});

								}else{
									if(s.status == 'success'){
										var remove = $(that).attr('data-remove');
										if(!remove)remove = $(that).attr('data-del');
										var parent = $(that).attr('data-parent');
										if(typeof remove == 'string' && remove){
											$(remove).remove();
										}else if(typeof parent == 'string' && parent){
											$(that).parents(parent).remove();
										}
									}
									Dialog.info(s.msg,s.status);
								}
						 });
						 return false;

				});
	},show_dialog:function(){

				var el =  '._showdialog,._showDialog';
				if($(el).length == 0) return ;
				$(el).click(function(){
							var msg = '';
							var status = 'error';
							var org_msg= $(this).attr('data-msg');
							var org_img =$(this).attr('data-img');
							var org_html =$(this).attr('data-html');
							var org_status = $(this).attr('data-status');
							if(typeof org_status == 'string')status =org_status;

							if(typeof org_msg == 'string'){
								msg =org_msg;
							}else if(typeof org_img == 'string'){
								org_img = org_img + "?t="+Math.random();
								status = 'none';
								msg  = '<img src=" '+org_img+'"/>';
							}else if(typeof org_html == 'string'){
								msg =$(org_html).html();
							}

							if(!msg) return false;
							if(!status) status='error';
							showDialog(msg,status);
							return false;

				 });
	},go_top:function(){
						var el =  '._go_top,._gotop';
						if($(el).length == 0) return ;
						$(el).click(function(){
							 $('body,html').animate({scrollTop:0},300);
							 return false;
						});
					  var c =$(el).attr('data-class');
					  if(c){
						  hover(el,function(){
							  $(this).addClass(c);
						  },function(){
							  $(this).removeClass(c);
						  });
					  }
					 var sc = $(el).attr('data-scroll');
					 var hide = $(el).attr('data-hide');
					 if(!isUndefined(hide) || !isUndefined(sc)) return false;

					  _scroll(function(top){
							if(top>20){
								$(el).slideDown();
							}else{
							  	$(el).slideUp();
						 	}
						});

	},click_show:function(){					//待测试

				var el =  '._click_show';
				if($(el).length == 0) return ;
				$(el).click(function(){
						var _this = $(this);
						var s = _this.attr('data-show');
						var h = _this.attr('data-hide');
						if(h){
							if(h.charAt(0)!='.' && h.charAt(0)!='#')h = '.'+h;
							$(h).hide()
						}
						if(s){
							if(s.charAt(0)!='.' && s.charAt(0)!='#')s = '.'+s;
							$(s).show();
						}
						if(this.tagName.toLowerCase() == 'a'){
							return false;
						}
				});
	},check_form:function(el,check_el){		//待测试
				var el =  '._check_form';
				if($(el).length == 0) return ;
				$(el).closest('form').submit(function(ev){

					var flag = true;
					//var form = $(this).parents('form');
					var form = $(this);

					form.find('input,textarea').each(function(){
						var that = this;
						if($(this).attr('data-type') || $(this).attr('data-reg') ){

								var value = $(this).val();
								if(!value){	//表单内容是空,就跳过不管
									if($(this).attr('data-null')){
										flag = false;
										return false;
									}
								}
								var reg =$(this).attr('data-type');
								if(typeof reg != 'string')reg =$(this).attr('data-reg');

								if(typeof reg == 'string'){
									if(typeof _check['is_'+reg] == 'function') reg = 'is_'+reg;

									if(reg  == 'is_kw'){
											var kw = $(this).attr('data-kw');
											if(value && value == kw){
												flag = false;
												Dialog.info('请输入要搜索的关键字','error','',function(){
													that.focus();
												});
												return false;
											}
									}

									if(typeof _check[reg] == 'function' && _check[reg](value) !== true){
										var msg = _check[reg](value);
										flag = false;
										var msg_text = $(this).attr('data-msg');
										if(msg_text) msg = msg_text;

										Dialog.info(msg,'error','',function(){
											that.focus();
										});
										return false;
									}
								}else if(!value){
									flag = false;
									var msg = $(this).data('msg');
									Dialog.info(msg,'error','',function(){
										that.focus();
									});
									return false;
								}
						}
					});
					return flag;
				});



	},onsubmit:function(){
				var el =  '._onsubmit';
				if($(el).length === 0) return ;
				$(el).click(function(){

					var form = $(this).attr('data-form');
					if(!form){
						 form =$(this).closest('form');
					}else{
						form = $(form);
					}
					//form.get(0).submit();
					form.trigger('submit');
					return false;
				});
	},wangwang:function(){
				var el =  '._wangwang';
				if($(el).length === 0) return ;
				var _this = this;
				$(el).each(function(i){
					if($(this).attr('data-init') ==1) return true;
					if(!TAE && $(this).attr('data-qq')){
						_this.qq(this);
						return true;
					}

						var nick = $(this).attr('data-wangwang');
						if(!nick)nick = $(this).attr('data-nick');
						if(!nick) return true;
						nick = decodeURIComponent(nick);
						nick = encodeURIComponent(nick);
						var img = $(this).attr('data-img');
						if(typeof img != 'string')img=1;
						var url1 = 'http://www.taobao.com/webww/ww.php?ver=3&touid='+nick+'&siteid=cntaobao&status='+img+'&charset=utf-8';
						$(this).attr('href' ,url1);
						$(this).attr('target','_blank');
						$(this).attr('data-init',1);
						if(img != '0'){
							var url2 = '';
								url2 ='http://amos.alicdn.com/realonline.aw?v=2&uid='+nick+'&site=cntaobao&s='+img+'&charset=utf-8';

							$(this).html('<img src="'+url2+'"/>');
						}
				});
	},
	qq:function(){
			var el = "._qq";

			if($(el).length === 0) return ;
			var _this = this;
			$(el).each(function(){
					if($(this).attr('data-init') ==1) return true;
					if($(this).attr('data-wangwang')){
						_this.wangwang(this);
						return true;
					}

					var qq = $(this).attr('data-qq');
					if(!qq) return false;
					var icon = $(this).attr('data-icon');
					var title = $(this).attr('data-title');
					if(!title) title = '点击立即联系我';
					var s =1;
					if(icon && icon>0) s=icon;
					var url1 = 'http://wpa.qq.com/msgrd?v=3&uin='+qq+'&site=qq&menu=yes';
					var url2 ='http://wpa.qq.com/pa?p=2:'+qq+':5'+s;
					$(this).attr('href' ,url1);
					if(typeof $(this).attr('data-img')  != 'string')$(this).html('<img src="'+url2+'"/>');
					$(this).attr('target','_blank');
					$(this).attr('title',title);
					$(this).attr('data-init',1);
			});
	},
	debug_info:function(){
					if($('.uz_system_debug').length===0)return false;
					$(".debug_list").each(function(i){
						$(this).attr('data-index',i);
					});
					$(".debug_list").click(function(i){
						var index =parseInt($(this).attr('data-index'));
						$(".uz_debug_info .debug_info_list").hide().eq(index).show();
						return false;
					});

	},um_plugin:function(){
					if(CURMODULE != 'img') return false;
					if(CURACTION !='post')  return false;

					UM.registerUI('taoke',function(name){
							var btn = $.eduibutton({name:name,title:'插入淘宝客模板',icon: name,
								click:function () {

								}
							});

							var me = this, currentRange, $dialog,
							opt = {
								title: '插入淘宝客模板',
								url: me.options.UMEDITOR_HOME_URL + 'dialogs/' + name + '/' + name + '.js',

							};

							//加载模版数据
							UM.utils.loadFile(document,{
								src: opt.url,
								tag: "script",
								type: "text/javascript",
								defer: "defer"
							},function(){
								//调整数据
								var data = UM.getWidgetData(name);
								if(!data) return;
								if(data.buttons){
									var ok = data.buttons.ok;
									if(ok){
										opt.oklabel = ok.label || me.getLang('ok');
										if(ok.exec){
											opt.okFn = function(){
												return $.proxy(ok.exec,null,me,$dialog)();
											};
										}
									}
									var cancel = data.buttons.cancel;
									if(cancel){
										opt.cancellabel = cancel.label || me.getLang('cancel');
										if(cancel.exec){
											opt.cancelFn = function(){
												return $.proxy(cancel.exec,null,me,$dialog)();
											};
										}
									}
								}
								data.width && (opt.width = data.width);
								data.height && (opt.height = data.height);

								$dialog = $.eduimodal(opt);

								$dialog.attr('id', 'edui-dialog-' + name).addClass('edui-dialog-' + name)
									.find('.edui-modal-body').addClass('edui-dialog-' + name + '-body');

								$dialog.edui().on('beforehide',function () {
									var rng = me.selection.getRange();
									if (rng.equals(currentRange)) {
										rng.select()
									}
								}).on('beforeshow', function () {
										var $root = this.root(),
											win = null,
											offset = null;
										currentRange = me.selection.getRange();
										if (!$root.parent()[0]) {
											me.$container.find('.edui-dialog-container').append($root);
										}

										//IE6下 特殊处理, 通过计算进行定位
										if( $.IE6 ) {

											win = {
												width: $( window ).width(),
												height: $( window ).height()
											};
											offset = $root.parents(".edui-toolbar")[0].getBoundingClientRect();
											$root.css({
												position: 'absolute',
												margin: 0,
												left: ( win.width - $root.width() ) / 2 - offset.left,
												top: 100 - offset.top
											});

										}
										UM.setWidgetBody(name,$dialog,me);
										UM.setTopEditor(me);
								}).on('afterbackdrop',function(){
									this.$backdrop.css('zIndex',me.getOpt('zIndex')+1).appendTo(me.$container.find('.edui-dialog-container'))
									$dialog.css('zIndex',me.getOpt('zIndex')+2)
								}).on('beforeok',function(){
									try{
										currentRange.select()
									}catch(e){}
								}).attachTo(btn)
							});

							return btn;
				});
	},
	um:function(){
		var el =  '#web_editor';
		if($(el).length==0) return false;
		window.UEDITOR_HOME_URL = "/web/ueditor/";

		var css = '<link href="'+UEDITOR_HOME_URL+'themes/default/css/umeditor.css" type="text/css" rel="stylesheet">';
		$('body').append(css);
		//'third-party/jquery.min.js',
		var script = ['third-party/jquery.min.js','umeditor.config.js','umeditor.js','lang/zh-cn/zh-cn.js'];
		$(el).hide();
		var insert_index  = 0;
		function insert_script(){
			appendscript(UEDITOR_HOME_URL+script[insert_index],function(){
				insert_index++;
				if(insert_index<script.length){
					insert_script();
				}else{
					init_ueditor();
				}
			});
		}

		var _this = this;
		insert_script();
		//加载编辑框
			function init_ueditor(){

				//后台获取的字段名是script上定义的name
				var name = $(el).attr('name');
				var content = '<script type="text/plain" id="UM_box"  name="'+name+'" ></script>';
				var tb = $(el).attr('data-bar');

				$(el).parent().append(content);
				_this.um_plugin();
				UMEDITOR_CONFIG.UMEDITOR_HOME_URL = UEDITOR_HOME_URL;
				var cfg = {};
				cfg.UMEDITOR_HOME_URL = UEDITOR_HOME_URL;
				if(tb ==1 ){
					cfg.toolbar=['bold italic underline strikethrough | forecolor ','link unlink | emotion']

				}else if(tb ==2){
					cfg.toolbar = [
						'bold italic underline strikethrough  | forecolor backcolor',
						' fontsize |  link unlink | emotion image ',
					]

				}else{
					cfg.toolbar = [
						'source | undo redo | bold italic underline strikethrough| forecolor backcolor | removeformat |',
						'insertorderedlist insertunorderedlist | selectall  paragraph | fontfamily fontsize' ,
						'| justifyleft justifycenter justifyright justifyjustify |',
						'link unlink | emotion image ',
						'| horizontal preview fullscreen', 'drafts', 'formula taoke'
					]
				}


				var um = UM.getEditor('UM_box',cfg);

				 um.ready(function(){

					var text = $(el).text();
					um.setContent(text);
				});


				 if(typeof um !='object') return false;
				 var par = $(el).parents('.kg_editorContainer');

				   var config = par.attr('data-config');
					try{
						var obj = (JSON.parse(config))
						if(typeof obj == 'object'){
							config = obj;
						}
					}catch(e){ };

					var height = 0;
					var width = 0 ;

					if(typeof config == 'object'){
						if(config['width'])width = config.width;
						if(config['height'])height = config.height;
					}
					if($(el).attr('data-width')) width = parseInt($(el).attr('data-width'));
					if($(el).attr('data-height')) height = parseInt($(el).attr('data-height'));

					if(width>0) um.setWidth(width);
					if(height>0) um.setHeight(height);
					$(el).remove();


			}


	},
	ueditor:function(){
		this.um();
		return false;

		window.UEDITOR_HOME_URL = "/web/ueditor/";
		var el =  '._ueditor';
		var url1 = '/web/ueditor/ueditor.config.js';
		var url2 = '/web/ueditor/ueditor.all.js';
		appendscript(url1,function(){
			appendscript(url2,function(){
				init_ueditor();
			});
		});
		//加载编辑框
			function init_ueditor(){
						if($('.kg_editorContainer').length>0){
						var par = $("#web_editor").parents('.kg_editorContainer');
						var config = par.attr('data-config');
							try{
								var obj = (JSON.parse(config))
								if(typeof obj == 'object'){
									config = obj;
								}
							}catch(e){ };
							if($("#web_editor").attr('data-width')){
								config = {};
								config.initialFrameWidth = parseInt($("#web_editor").attr('data-width'));
								if($("#web_editor").attr('data-height')) config.initialFrameHeight = parseInt($("#web_editor").attr('data-height'));
							}else if(typeof config == 'object'){
								if(config.widht)config.initialFrameWidth = config.widht;
								if( config.height)config.initialFrameHeight = config.height;
							}

							if($("#web_editor").attr('data-bar') ==2 || $("#web_editor").attr('data-type') ==2){
							config.toolbars = [['FullScreen','Source','Undo','Redo','Bold','Italic','lineheight','indent',"|",
								'RemoveFormat','PastePlain','ForeColor','Paragraph','FontFamily','FontSize','JustifyLeft',
								'JustifyCenter','JustifyRight','JustifyJustify',"|",'Link','Unlink','Image','Horizontal',"|",
								'simpleupload','wordimage','Preview']];
							}
						var ue = UE.getEditor('web_editor',config);
						ue.ready(function(){
								if(typeof config == 'object'){
									if(config.height)ue.setHeight(config.height);
								}
								$("input:submit[name='onsubmit']").click(function(){
									$(".ks-editor-textarea").val(ue.getContent());
								});
						});

					}
			}


	},form:function(){
		var el = 'input,textarea';
		if($(el).length == 0) return ;
		 $(el).each(function(){
			var value = $(this).val();
			if(value == 'null')$(this).val('');
		});

		$('form').attr( 'enctype','multipart/form-data');
	},get_goods:function(){
			var el = "input[name=get_submit]";

			$(el).click(function(){
				if($(this).attr('data-return')) return true;

				var iid = $("input[name=goods_id]").val();
				if(!iid){
					Dialog.info('请输入淘宝商品id或商品链接');
					return ;
				}

				tdj.get_goods(iid,function(s){
					if(typeof s != 'object') return false;

					$("input[name='postdb[title]']").val(s.title);
					$("input[name='postdb[baoyou]'][value='"+s.baoyou+"']").attr('checked','checked');
					$("input[name='postdb[shop_type]'][value='"+s.shop_type+"']").attr('checked','checked');
					$("input[name='postdb[num_iid]']").val(s.num_iid);
					$("input[name='postdb[nick]']").val(s.nick);
					$("input[name='postdb[sid]']").val(s.sid);


					$("input[name='postdb[picurl]']").val(s.picurl);
					if(s.url && s.url.indexOf('item.taobao.com') == -1){
						$("input[name='postdb[url]']").val(s.url);
					}



					if(s['images'] && s.images.length>0){
						$("input[name='images[]']").val(s.images.join(','));
					}

					$("input[name='postdb[price]']").val(s.price);
					if(s.sum && s.sum>0){
							$("input[name='postdb[sum]']").val(s.sum);
					}


					$("input[name='postdb[yh_price]']").val(s.yh_price);
					$("input[name='postdb[bili]']").val(s.bili);
					$(".hover_img>a>img").attr('src',s.picurl).parent('a').attr('href',s.picurl);

				});
				return false;
			});
	},init_tdj:function(type,call){
			var cpid = getcookie('pid');

			var tk = $("meta[name='tk']").attr('content').split('|');
			var pid = cpid;
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
	},check_login:function(){
		var el =  '._check_login';

		if($(el).length == 0) return ;
		$(el).click(function(e){

			if(!is_login(e)) return false;
		});
	},ding:function(){

		//暂时取消
		return ;
		var el= '._ding';
		 if($(el).length == 0) return ;
		$(el ).click(function(){

			var _this = this;
			if(!is_login()) return false;
			var url = $(this ).attr('data-url') ?  $(this ).attr('data-url') :  (this.href && this.href!='#' && this.href!='javascript:;'? this.href :'');
			if(!url) return false;
			var show  = $(this ).attr('data-show') ? $(this ).attr('data-show') : $(this ).attr('data-target');
			if(show == 'this' || show ==1) show = this;
			var id = $(this ).attr('data-id');
			var name = $(this ).attr('data-name');
			var save_list = [];
			var className = $(this ).attr('data-class');
			var succss_msg = '收藏成功';
			var error_msg = '取消成功';

			if($(this ).attr('data-succss_msg'))succss_msg = $(this ).attr('data-succss_msg');
			if($(this ).attr('data-error_msg'))error_msg = $(this ).attr('data-error_msg');


			if(id && name){
				if(_load(name)){
					save_list = _load(name).split(',');
					if(save_list && save_list.length>0  && in_array(id,save_list)){
						if(className)$(_this).removeClass(className);
						save_list = del_array(id,save_list);
						_save(name,save_list.join(','));
						Dialog.info(error_msg, 'success');
						if (show) {
							var len = parseInt($(show).html());
							if(len)$(show).html(len-1);
						}

						return false;
					}
				}
			}


			ajaxget(url, function(s) {
				Dialog.info(s.msg, s.status);
				if (s.status == 'success' && s.data && show) {
					$(show).html(s.data);
					if (id && name) {
						if (className)
							$(_this).addClass(className);
						save_list.push(id);
						_save(name, save_list.join(','));
					}
				}
				return false;
			});
			return false;
		});
	},one_key_share:function(){
			var el = 	'._one_key_share';
			if($(el).length == 0) return ;
			$(el).click(function() {
				var type = $(this).attr('data-type');
				var url = $(this).attr('data-url');
				var title = $(this).attr('data-title');
				var picurl = $(this).attr('data-picurl') ||'';
				var content = $(this).attr('data-content');

				if(!url) url = location.href;
				if(!title) title = document.title;
				if(!content) content = $("meta[name='description']").attr('content');

				var share = {"qzone":"","weibo":"","t":"","renren":"","kaixin":"","douban":""};

				url = encodeURIComponent(url);
				title = encodeURIComponent(title);
				content = encodeURIComponent(content);
				if(picurl)picurl = encodeURIComponent(picurl);

				share.qzone = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+url+'&title='+title+'&summary='+content+'&pic='+picurl+'&site=';
				share.weibo = 'http://service.weibo.com/share/share.php?url='+url+'&title='+title+'&pic='+picurl;
				share.t = 'http://share.v.t.qq.com/index.php?c=share&a=index&url='+url+'&title='+title+'&pic='+picurl;
				share.renren = 'http://widget.renren.com/dialog/share?resourceUrl='+url+'&title='+title+'&pic='+picurl+'&description='+content;
				share.kaixin = 'http://www.kaixin001.com/rest/records.php?url='+url+'&content='+content+'&pic='+picurl+'&style=11&stime=&sig=';
				share.douban = 'http://www.douban.com/share/service?bm=&image=&href='+url+'name='+title+'&text='+content;

				if(share[type]){
					window.open(share[type]);
				}
				return false;
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
							if(url.indexOf('-') != -1){
								str = url.replace(/\.html/,'')+'-u-'+UID+'.html';
							}else{
								str = url.replace(/\.html/,'')+'/u/'+UID+'.html';
							}
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




		},yzm:function(el){
				el = el || ".yzm,.yzm_img";
				$(el).click(function(){
					$('.yzm_img').attr('src','/index.php?m=ajax&a=yzm&t='+Math.random());
					return false;
				})
		},img_onerror:function(e){

			  $('img').each(function(){
				 // if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth <2) {
				
				 if (this.complete && (typeof this.naturalWidth == "undefined" || this.naturalWidth <2)) {
					  return _onerror(this);
				  }
			  });
	},show_content:function(el){

	},hide_menu:function(el){
		el = el || '._hideMemu';
		$(el).click(function(){
			hideMenu();
			return false;
		});

	},init_click:function(){
		var tk = $("meta[name='tk']").attr('content').split('|');

		  $("a[isconvert='1']").click(function(){
		  var href = $(this).attr('href');
		    if(href && href.indexOf('s.click.taobao.com')!=-1)  return true;

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
	},auto_ad:function(el){
		el  = el || '._auto_ad';
		$(el).each(function(){
			var pic = $(this).attr('data-picurl');
			var url = $(this).attr('data-url');
			if(pic){
				var _this = this;
				var img = new Image();
				img.src = pic;
				img.onload = function(){
					$(_this).height(this.height).css({'background':'url('+pic+') no-repeat 50% 0'}).addClass('cl');
					if(url && url!='#')$(_this).append('<a href="'+url+'" target="_blank"></a>');
				}
			}
		});
	},show_menu:function(){

			$('._show_menu,._showMenu').click(function(){

					var config = $(this).attr('data-config');

					if(config){
							config = $.parseJSON(config);
							if(config && config.ctrlid){
									//config.pos = '00!';
									var evn = config.evn || 'mouseenter';
									var evn_hide = config.evn_hide || 'mouseleave';

									$(this).on(evn,function(){
										var cf =   $.parseJSON($(this).attr('data-config'));
										cf.cover = 0;
										showMenu(cf);
										return false;
									});
									if(config.hidemenu){
										$(this).on(evn_hide,function(){
											var cf =   $.parseJSON($(this).attr('data-config'));
											hideMenu(cf.ctrlid+'_menu','menu');
											return false;
										});
									}
							}

					}else{

							var id   =$(this).attr('data-menu');
							var cover = $(this).attr('data-cover');
							cover = cover || 0;

							if(id)showMenu({ctrlid:id,pos:'!00',zindex:2,'duration':3,cover:cover});
							return false;

					}
			});
	},baidu_push:function(){
		var not = ['apps','home','member','comment','apply','ajax'];
		if(!in_array(CURMODULE,not)){
			/*var url = location.protocol + '//push.zhanzhang.baidu.com/push.js';
			try{
				appendscript(url);
			}catch(e){
				L(e.message);
			};*/

			var  r = window.location.href,
			o = document.referrer;
			var n = "//api.share.baidu.com/s.gif";
			o ? (n += "?r=" + encodeURIComponent(document.referrer), r && (n += "&l=" + r)) : r && (n += "?l=" + r);
			var t = new Image;
			t.src = n;

		}
	},init_comment:function(){
		if($("._comment").length>0){
			$F('comment',function(){
				comment.init();
			})
		}
	},init_upload:function(){
		if($('.upload_btn').length>0)upload('.upload_btn');
	}
};



var _check = {
		is_email:function(str){
			if(!str || str == '')return '邮箱不能为空';
			var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
			return reg.test(str) ? true:'邮箱校式校验失败,请重新输入';
		},
		is_phone:function (str){
			if(!str || str == '')return '手机号码不能为空';
			var reg = /^1\d{10}$/;
			return reg.test(str) ? true:'手机号码格式校验失败,请重新输入';
		},
		is_tell:function (str){
			if(!str || str == '')return '电话号码不能为空';
			var reg=/\d{3}-\d{8}|\d{4}-\d{7}/;
			return reg.test(str) ? true:'电话号码格式校验失败,只能输入:0511-4405222 或 021-87888822 样式';
		},
		is_idcard:function (str){
			if(!str || str == '')return '身份证号码不能为空';
			var reg=/\d{15}|\d{18}|\d{17}x/i;
			return reg.test(str) ? true:'身份证号码格式校验失败,请重新输入';
		},
		is_qq:function (str){
			if(!str || str == '')return 'qq号码不能为空';
			 var reg=/^\d{5,11}$/;
			return reg.test(str) ? true:'qq号码格式校验失败,请重新输入';
		},is_number:function(str){
			if(!str || str == '')return '数字不能为空';
			return !isNaN(str) ? true:'数字格式校验失败 ,只能输入0-9';

		},is_zip:function (str){
			if(!str || str == '')return '邮政编码不能为空';
			var reg=/^[1-9]\d{5}$/;
			return reg.test(str) ? true:'邮政编码只能为6位数字,请重新输入';
		},is_int:function (str){
			var reg=/^(-|\+)?\d{1,11}$/;
			return reg.test(str) ? true:'数字格式校验失败,只能为 整数 1-9';
		},
		is_datetime:function (str){
		// 判断输入是否是有效的长日期格式 - "YYYY-MM-DD HH:MM:SS" || "YYYY/MM/DD HH:MM:SS"
			var reg=/^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
			return reg.test(str) ? true:'日期时间格式校验失败,只能输入 2014-08-24 12:05:18 样式';
		},
		is_date:function (str){
			if(!str || str == '')return '日期不能为空';
			// 检查是否为 YYYY-MM-DD || YYYY/MM/DD 的日期格式
		   var reg = /^(\d{4})(-|\/)(\d{1,2})\2(\d{1,2})$/;
			return reg.test(str) ? true:'日期格式校验失败,只能输入 2014-08-24 样式';
		},is_chinese:function(str){
			var reg = /^[\u4e00-\u9fa5]+$/
			return reg.test(str) ? true:'中文格式校验失败';
		},is_truename:function(str){
			if(!str || str == '')return '姓名不能为空';
			 var reg = /^[\u4e00-\u9fa5]+$/
			return reg.test(str) ? true:'姓名格式校验失败,必须为中文,请重新输入';
		},is_url:function(str){
			if(!str || str == '')return '网址不能为空';
			 var strRegex = "^((https|http)?://)?("
				+ "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
				+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
				+ "[a-z]{2,6})" // first level domain- .com or .museum
				+ "(:[0-9]{1,4})?" // 端口- :80
				+ "((/?)|" // a slash isn't required if there is no file name
				+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
        	var reg=new RegExp(strRegex);
			return reg.test(str) ? true:'网址格式校验失败,必须以http://开头,请重新输入';
		},is_ip:function(str){
			if(!str || str == '')return 'ip地址不能为空';
			var reg = /\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/;
			return reg.test(str) ? true:'ip地址格式校验失败,请重新输入';
		},is_char:function(str){
			var reg = /^[A-Za-z]+$/;
		   return reg.test(str) ? true:'字母格式校验失败,只能输入a-z,请重新输入';
		},is_password:function(str){
			if(!str || str == '')return '密码不能为空';
			var reg = /^[A-Za-z0-9\u4E00-\u9FA5-@!#~]{6,20}$/;
		   return reg.test(str) ? true:'密码格式校验失败,只能输入6-20个字母、数字、下划线,请重新输入';
		},is_kw:function(str){
			if(!str || str == '') return '要搜索的关键字不能为空,请重新输入';
			return true;
			var reg = /^[^`~!@#$%^&*()+=|\\\][\]\{\}:;'\,.<>\/?]{1}[^`~!@$%^&()+=|\\\] [\]\{\}:;'\,.<>?]{0,10}$/;
			return reg.test(str) ? true:'非法搜索关键字,请重新输入';
		},is_username:function(str){
			if(!str || str == '')return '用户名不能为空';
			var reg = /^([\u4e00-\u9fa5]|[\ufe30-\uffa0]|[a-zA-Z0-9_\-]){4,20}$/;
			return reg.test(str) ? true:'用户名只能为 大小写英文字母、汉字、数字、下划线,4-20位请重新输入';
		},is_wangwang:function(str){
			if(!str || str == '')return '旺旺不能为空';
			var reg = /^([\u4e00-\u9fa5]|[\ufe30-\uffa0]|[a-zA-Z0-9_\-]){2,20}$/;
			return reg.test(str) ? true:'旺旺只能为 大小写英文字母、汉字、数字、下划线,请重新输入';

		},is_alipay:function(str){
			if(!str || str == '')return '支付宝账号不能为空';
			var reg = /^1\d{10}$/;
			var reg2 = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
			return reg.test(str) || reg2.test(str) ? true:'支付宝账号格式只能为手机号码或邮箱,请重新输入';
		},is_address:function(str){
			if(!str || str == '')return '地址不能为空';
			return true;
		},is_yzm:function(str){
			if(!str || str == '')return '验证码不能为空';
			var reg = /^[0-9a-zA-Z]{4,6}$/;
			return reg.test(str)  ? true:'验证码格式不正确,请重新输入';
		},is_tag:function(str){
			if(!str || str == '')return '标签不能为空';
			return true;
		},is_title:function(str){
			if(!str || str == '')return '标题不能为空';
			return true;
		},is_null:function(str){
			if(!str || str == '')return '内容不能为空';
			return true;
		},is_picurl:function(str){
			if(!str || str == '')return '图片不能为空';
			var reg = /^(http|\/)/;
			return reg.test(str) ? true:'图片格式不正确';
			return true;
		}
}


$(function(){

	_hook.init();

})






