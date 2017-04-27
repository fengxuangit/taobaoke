var tdj  ={
	focus_tdj:false,		//强制淘点金
	config:null,
	type:null,	//0 = '淘点金'   1 = 百川或是淘宝接口(后台自动分配)	2= 优淘官方服务器
	get_goods:function(num_iid,call){
		this.init();
		if(!/^\d{10,15}$/.test(num_iid)){
			num_iid = decodeURIComponent(num_iid);
			 num_iid = sub_str(num_iid+'&','id=','&');
		}

		 if(this.type == 1){
			 this.m_get(num_iid,call);
		}else if(this.type == 2){
			 this.http_get(num_iid,call);
		}else if(this.type == 3 && 'mtop' in window && mtop.is_init){
			mtop.get_goods(num_iid,call);
		}else {
			this.get(num_iid,call);
		}
	},
	init:function(){
		if(this.type == null){
			this.type = CAIJI_TYPE;
		}

		if(this.config ==null){
			var tk = $("meta[name='tk']").attr('content').split('|');
			this.config = {pid:tk[0],url:tk[1],et:this._get_et(),pgid:this._get_pgid(),error:0};
			if(this.config.pid == '0'){
				this.config.pid = getcookie('pid');
			}
		}
	},
	m_get:function(num_iid,call){
		m_get_goods(num_iid,call);
		return ;
	},
	http_get:function(num_iid,call){
		var web = C('weburl');

		if(web && web.indexOf('http') !== -1){
			get_start(web);
		}else{
			ajaxget('/index.php?m=ajax&a=get_url',function(s){
				if(s.status == 'error'){
					Dialog.info(s.msg,s.status);
					return ;
				}
				C('weburl',s.data,86400);
				get_start(s.data);
			});
		}
		function get_start(url){

			var url = url+"/get_goods/index.php";
			$.ajax({type:'GET',url:url,data:{num_iid:num_iid},dataType:'jsonp',success:function(s){
				if(typeof call == 'function')	 call(s.data);
			 }})
		}
	},
	get:function(num_iid,call){
				this.init();

				if(this.config == null){
					var tk = $("meta[name='tk']").attr('content').split('|');
					if(tk[2] != 0  && !this.focus_tdj){
						m_get_goods(num_iid,call);
						return ;
					}
					this.init();
				}
				var rf = encodeURIComponent(this.config.url);
				var data = 'pid='+this.config.pid+'&wt=0&ti=625&tl=230x45&rd=1&ct=itemid='+num_iid+'&st=s&rf='+rf+'&et='+this.config.et+'&pgid='+this.config.pgid+'&v=2.0';
				var _this = this;
				$.ajax({url: 'http://g.click.taobao.com/display?cb=?',type: 'GET',    dataType: 'jsonp',jsonp: 'cb',
					data: data,
					success: function(msg) {

						if(msg.code == 200 || msg.code == 201){
							var tmp =msg.data.items[0];

							tmp = _this._parse_tdj(tmp);
							if(typeof call == 'function')call(tmp);
						}else{

							var text ='';
							L(msg);
							if(msg.error_msg){
								text = msg.error_msg;
								if(msg.error_msg == "基本权限校验不通过"){
									text+=',可能是采集设置中的淘点金pid与淘点金网址不一至造成';
								}
							}else{
								text = '商品不存在';
							}
							if($('.admin.menutd_fixed').length>0){
								Dialog.info(text);
							}

							if(_this.error<3){
								showDialog('获取商品信息失败,code:' + msg.code+',msg:'+msg.error_msg);
							}
							_this.config.error ++ ;
						}
					},
					error: function(msg){
						if(tdj_config.error<3){
							showDialog('查询错误,请查看日志');
						}
						_this.config.error ++ ;
						L('错误:');
						L(msg);
					}
				});
	},get_comment:function(iid,call){

					this.focus_tdj = true;
					this.get(iid,function(s){

								var uid = s.sid;
								var iid = s.num_iid;
								var url ='https://rate.tmall.com/list_detail_rate.htm?itemId='+iid+'&spuId=&sellerId='+uid;
								url+='&order=1&currentPage=1&append=0&content=1&tagId=&posi=&picture=0&p=1';
								$.ajax({
									url : url,
									data :'',
									dataType : "jsonp",
									success : function(s, textStatus) {

										var count = 0;
										try {
											count = s.rateDetail.rateCount.total;
										} catch (e) {
											L(e);
										}
										if (count > 0 && call )call(s.rateDetail.rateList);
									},
									error : function(s) {
										L(s);
									}
								});
					});
	},_get_et:function(){
		 var s = new Date(),
			  l = +s / 1000 | 0,
			  r = s.getTimezoneOffset() * 60,
			  p = l + r,
			  m = p + (3600 * 8),
			  q = m.toString().substr(2, 8).split(""),
			  o = [6, 3, 7, 1, 5, 2, 0, 4],
			  n = [];
			  for (var k = 0; k < o.length; k++) {
				  n.push(q[o[k]])
			  }
			  n[2] = 9 - n[2];
			  n[4] = 9 - n[4];
			  n[5] = 9 - n[5];
			  return n.join("");
	},_setCookie:function(j, k){
		document.cookie = j + "=" + encodeURIComponent(k.toString()) + "; path=/";
	},_getCookie:function(l){
		var m = (" " + document.cookie).split(";"),
		j = "";
		for (var k = 0; k < m.length; k++) {
			if (m[k].indexOf(" " + l + "=") === 0) {
				j = decodeURIComponent(m[k].split("=")[1].toString());
				break;
			}
		}
		return j;
	},_get_pgid:function(){
		  var l = "",
		  k = "",
		  n,
		  o,
		  t,
		  u,
		  s = location,
		  m = "",
		  q = Math;
		  function r(x, z) {
			  var y = "",
			  v = 1,
			  w;
			  v = Math.floor(x.length / z);
			  if (v == 1) {
				  y = x.substr(0, z);
			  } else {
				  for (w = 0; w < z; w++) {
					  y += x.substr(w * v, 1);
				  }
			  }
			  return y;
		  }

		 n = (" " + document.cookie).split(";");
		  for (o = 0; o < n.length; o++) {
			  if (n[o].indexOf(" cna=") === 0) {
				  k = n[o].substr(5, 24);
				  break;
			  }
		  }

		  if (k === "") {
			  cu = (s.search.length > 9) ? s.search: ((s.pathname.length > 9) ? s.pathname: s.href).substr(1);
			  n = document.cookie.split(";");
			  for (o = 0; o < n.length; o++) {
				  if (n[o].split("=").length > 1) {
					  m += n[o].split("=")[1];
				  }
			  };
			  if (m.length < 16) {
				  m += "abcdef0123456789"
			  };
			  k = r(cu, 8) + r(m, 16);
		  };
		  for (o = 1; o <= 32; o++) {
			  t = q.floor(q.random() * 16);
			  if (k && o <= k.length) {
				  u = k.charCodeAt(o - 1);
				  t = (t + u) % 16
			  }
			  l += t.toString(16);
		  };
		  this._setCookie('amvid', l);
		  var p = this._getCookie('amvid');
		  if (p) {
			  return p;
		  }
		  return l;
	},_parse_tdj:function(rs){
			var s = {};
			s.title = rs.ds_title.replace(/<(.*?)>/g,'');;
			s.price = rs.ds_reserve_price;
			s.yh_price=rs.ds_discount_price;
			s.zk = rs.ds_discount_rate;
			s.shop_type = rs.ds_istmall ==1 ? 1 :2;
			s.num_iid = rs.ds_nid;
			s.bili = rs.ds_taoke ==0 ? '-1':'';
			s.sum = rs.ds_sell;
			s.baoyou = rs.ds_post24 == 0 && rs.ds_postfee == 0 ? 1 :0;
			s.nick = rs.ds_nick;

			s.sid = rs.ds_user_id;
			s.picurl = rs.ds_img.src;
			s.url = 'http://item.taobao.com/item.htm?id=' + rs.ds_nid;
			s.shop_url = 'http://store.taobao.com/shop/view_shop.htm?user_number_id='+rs.ds_user_id;

				// var tmp = rs.ds_provcity.split(' ');
				// s.state = tmp[0];
				// s.city = tmp[1];
				//s.click_url = rs.ds_item_click;
				//s.shop_click_url = rs.ds_shop_click;
				//s.org = rs;
				//s.num = 9999;

			return s;
	}
}
