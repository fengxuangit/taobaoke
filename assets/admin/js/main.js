var admin_url = '/'+CURSCRIPT+'.php';
if(window.parent != window.self) window.parent.location = window.parent.location;



var modue_list = {


	main:function(){
		_scroll(function(top){
			if(top>110){
				$('.admin').addClass ('menutd_fixed');
			}else{
				$('.admin').removeClass('menutd_fixed');
			}
		});


		var height = document.documentElement.clientHeight || document.body.clientHeight; 
		 var copy_height = $('.copyright').height();
		 height = height - 50 -copy_height ;
		 var a_height = ~~(height /  $('#leftmenu ul').length );
		if(a_height>30) a_height = 30;
		 $(".menu ul li a").css({height:a_height,'line-height4':a_height});
	

		$(".ajax_del").click(function(){
			$(this).parent().find('.pic_upload').val('');
			return false;
		});



		var h = document.documentElement.clientHeight;
		$(".menutd").height(h);

		window.addEventListener("message", function(event) {
          if (event.source != window) return;
          if (event.data.type && (event.data.type == "FROM_TTAE")) {
            	//alert("网页脚本接收到：" + event.data.text);
            	var text = event.data.text;
            	if(text == 'init_mtop'){
            		 appendscript('assets/global/js/top/mtop.js',function(){
            		 	mtop.init(function(){
            		 		tdj.type = 3;
            		 	});
            		 });
            	}
          }
        }, false);

	},

	login_main:function(){

		var is_stop = _load('close_pic');

		if(is_stop != 1){
			is_stop = 0;
			var picurl = 'http://818zhekou.image.alimmdn.com/big_bg/';
			var pic_arr = [];
			var max = 25;
			for(var i =0;i<5;i++){
				var tmp = ranDom(0,max);
				var pic = picurl+tmp+'.jpg';
				if(in_array(pic,pic_arr)){
					 tmp = ranDom(0,max);
					 pic = picurl+tmp+'.jpg';
				}
				pic_arr.push(pic);
			}

			run_bg('body',pic_arr);

			$(".close_pic").text('关闭动画');
		}else{
			$(".close_pic").text('开启动画');
		}

		//1=关闭,其它,开启

		$(".close_pic").click(function(){
			if(is_stop ==1){
				_save('close_pic',0);
			}else{
				_save('close_pic',1);
			}
			location.reload();
			$(this).remove();
			return false;
		});

	},
	admin_config:function(){
		$(".select_upload").on('change',function(){
			if(this.value == 'baichuan'){
				$(".baichuan_name").show();
			}else{
				$(".baichuan_name").hide();
			}
		});
	},
	admin_setting:function(){
		//this.check_updata();
	},
	ad_post:function(){
				//绑定添加广告时的选择类型	//文件module_ad_add.php
				$(".ad_types").each(function(i){
					this.index = i;
				});
				$(".ad_types").click(function(){
					$('.show_ads').hide().eq(this.index).show();

				});

	},admin_caiji:function(){
				click('.srandom',function(){
					for(var i=0;i<30;i++){
						$('.syn_key').val(_random());
					}
					return false;
				});

				$('.api_type').click(function() {
					var val = $(this).val();
					if(val == 1){
						//百川
						if(!$('.baichuan_key').val()) {
							Dialog.info('您必须先配置百川appkey才能切换采集接口');
							return false;
						}
					}else{
						if(!$('.taobao_key').val()) {
							Dialog.info('您必须先配置淘宝客appkey才能切换采集接口');
							return false;
						}
					}

				});

	},module_friend_link:function(){
				var f_timer = null;
				var f_index = 0;

				function get_link(){
					var val = $('.ids').eq(f_index).val();
					ajaxget(admin_url+"?m=module&a=friend_link_check_ajax&id="+val,function(s){

						  var msg = '';
						  if(s.msg=='0'){
							   msg='<span class="red">不存在</span>';
								$('.del_'+f_index)[0].checked =true;
						  }else if(s.msg =='-1'){
							  msg = '未知';
						  }else if(s.msg=='1'){
							  msg = '存在';
						  }
						  $('.frined_'+f_index).html(msg);

						  if(f_index >= $('._del').length-1){
							 f_index = 0;
							 Dialog.info('检查完成.对方站点不存在的,都给选中了,且字为蓝字.','success',60000);
						  }else{
							 f_index++;
							 get_link();
						 }
					});
				}

				$('.check_friend_link').click(function(){
					$('._del').each(function(){
						this.checked =false;
					});
					get_link();
				})

	},

	reward_ticket_post:function(){

					var chars = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p',
									'q','r','s','t','u','v','w','x','y','z'];
					$('.ticket_btn').click(function(){

								var len = $('.ticket_len').val();
								var len = $('.ticket_ge').val();
								c = !c  ? 20 :parseInt(c);
								len = !len  ? 20 : parseInt(len);
								var res = '';
								for(var i = 0;i<len;i++){
									res +=_random(c)+"\r\n";
								}
								$('.ticket_value').val(res);
					});

	},reward_prize_post:function(){

						$('.prize_type').each(function(i){
							this.index = i;
						});
						$('.prize_type').click(function(){
							$('.prize_t1').hide().eq(this.index).show();
						});



	},
	goods_main:function(){
						
						$(".select_jump").on('change',function(){
								var key = $(this).data('key');
								//var url = admin_url+"?m=goods&a=main&";
								var url = admin_url+"?";
								for(var i in $_GET){
									if(i != key) url+= i+'='+$_GET[i]+'&';
								}
								
								if(this.value  >-1 ) url +=  key+"="+this.value;
								location.href =url;
						});

						$(".select_li").each(function(){
							var key = $(this).data('key');
							var val = $(this).data('val');
							if(key in $_GET && $_GET[key] && $_GET[key] ==val ){
								$(this).addClass('red');
							}
						});

						$(".select_li").click(function(){
								var key = $(this).data('key');
								var val = $(this).data('val');
								var url = admin_url+"?";
								for(var i in $_GET){
									if(i != key) url+= i+'='+$_GET[i]+'&';
								}
								if(val  >-1 ) url +=  key+"="+val;
								location.href =url;
						})



						// $(".start_time_in").on('change',function(){
						// 	location.href = admin_url+"?m=goods&a=main&cate="+this.value;
						// 	$('.table_main').css({"paddingBottom":"300"});
						// });

						$(".update_btn").click(function(){


							var ids = [];
							var open_iids = [];


							$('.commission').each(function(i){
								var iid = $('.commission').eq(i).attr('data-iid');
								var open_iid = $('.commission').eq(i).attr('data-open_iid');
								ids.push(iid);
								if(open_iid)open_iids.push(open_iid);
							});


							var num_iid =  ids.join(',');
							var open_id =  open_iids.join(',');
							var url  = admin_url+'?m=goods&a=update';
							showDialog('', 'info', '<img src="assets/global/images/loading.gif">正在更新中,大概需3-10秒左右,请不要关闭本窗口...');

							$.post(url,{'num_iid':num_iid,'open_iid':open_id},function(s){
								if(s['msg'] &&( s.msg.indexOf('&gt;') != -1 || s['html'] ==1))s.msg = htmldecode(s.msg);
								if(s.status == 'error'){
									showDialog(s.msg);
									return false;
								}else{

									hideMenu('','');
									showDialog('更新完毕,成功更新'+s.len+'条,请刷新页面,然后看采集时间','success','',function(){
										location.href = location.href;
									});
								}
							},'json');


							return false;
						})

    },goods_post:function(){

		//品牌搜索
		// if($('.brand_list').text()){
		// 	var list  = JSON.parse($('.brand_list').text().trim());
		// }else{
		// 	var list = [];
		// }
		// var org_list = [];
		// $('.brand_kw').keyup(function(event){
		// 	if(event.keyCode == 13) return false;
		// 	var text = $(this).val().trim();
		// 	$('.brand_select').empty();
			
		// 	if(text == ''){
		// 		org_list.forEach(function(el){
		// 				$('.brand_select').append('<option value="'+el.id+'">'+el.name+'</option>');
		// 		});
		// 	}else{
		// 		var daxie = pinyin.getCamelChars(text).toLowerCase();
		// 			list.forEach( function(item, index) {
		// 				if(item.py.indexOf(text)>-1){
		// 					//拼音查找
		// 					$('.brand_select').append('<option value="'+item.id+'">'+item.name+'</option>');
		// 				}else if(item.name.toLowerCase().indexOf(text)>-1){
		// 					//文字直接查看
		// 					$('.brand_select').append('<option value="'+item.id+'">'+item.name+'</option>');
		// 				}else if(item.daxie.indexOf(daxie)>-1){
		// 					//前字母查找
		// 					$('.brand_select').append('<option value="'+item.id+'">'+item.name+'</option>');
		// 				}
		// 			});
		// 	}

		// })

		// //生成拼音
		// $F('pinyin',function(){
		// 	list.forEach( function(item, index) {
		// 		var p = pinyin.getFullChars(item.name).toLowerCase();
		// 		var daxie = pinyin.getCamelChars(item.name).toLowerCase();
		// 		list[index].py = p ;
		// 		list[index].daxie = daxie ;
		// 	});
		// })
		// //保存默认的列表
		// $('.brand_select option').each(function(item){
		// 	org_list.push({name:$(this).text(),id:$(this).val(),select:false})
		// });

		$('.create_tkl').click(function(){
			var aid = $('.goods_aid').val();
			if(!aid){
				showDialog('您必须先发布商品,然后商品有优惠券链接,或是商品链接地址是淘宝转换后的长链(或短链),才能生成淘口令');
				return false;
			}

			ajaxget(admin_url+'?m=goods&a=get_tkl&aid='+aid,function(rs){
				Dialog.info(rs.msg,rs.status);
				if(rs.status == 'success'){
					$('.tkl_input').val(rs.data);
				}
			});
			return false;
		})
						

	},goods_setting:function(){
			this.goods_goods_check();


	},goods_goods_check:function(){
			var val = $('.goods_filter_text').val().split(',');
			val.push(1);
			for(var i =0;i<val.length;i++){
				$(".goods_filter[value="+val[i]+"]")[0].checked = true;;
			}
			$(".goods_filter[value=1]").click(function(){
				return false;
			});
			if(CURACTION == 'goods_check'){
				$(".radio[value=0]").prop('checked',true)
				var check_list = $('.check_list').text().trim();

				if(!check_list) return ;
				check_list = check_list.split(',');
				for(var i =0;i<check_list.length;i++){
					$(".radio[name='check_list["+check_list[i]+"]']")[0].checked = true;
				}
			}
	}
	,shiyong_post:function(){
					$('.shiyong_type').on('change',function(){

						var type = this.value;
						if(type == 1){
							$(".diejia").show();
						}else{
							$(".diejia").hide();
						}
						})

	},channel_batpost:function(){

				var index = 1;
				var se = $('.select_fid,.select_id')[0].options;
				var opt = '';
				for(var i =0;i<se.length;i++){
					opt+="<option value='"+se[i].value+"'>"+se[i].text+"</option>";
				}

				click('.add_row',function(){

						var text = "<td>&nbsp;</td><td><input type='text' name='fup[]' value='' />&nbsp;&nbsp;";
						text +="<select name='fup2[]'>";
						text +=opt;
						text +="</select><input type='hidden' name='tmp["+(index++)+"]' /></td>";
						text +="<td><input type='text' name='name[]' value='' style='width:300px' /></td>";
						text += "<td><input type='text' name='sort[]' value='' style='width:30px' /></td>"
						//D('row').innerHTML +=text;
						var tr =document.createElement('tr');
						tr.setAttribute('class','hover');
						tr.setAttribute('style','text-align:left');
						tr.innerHTML = text;
						$('.row_main').append(tr);
						return false;
				});
	},
	admin_syn:function(){
				click('.web_type',function(){
					if(this.value == 1){
						$(".sub_domain").show();
					}else{
						$(".sub_domain").hide();
					}
				});
	},shop_post:function(){



			$("input[name=get_submit1]").click(function(){
				if($(this).attr('data-return')) return true;
				var iid = $("input[name=goods_id]").val();
				if(!iid){
					Dialog.info('请输入淘宝商品id或商品链接');
					return false;
				}

				tdj.get_goods(iid,function(s){
					if(typeof s != 'object') return false;
					$("input[name='postdb[shop_type]'][value='"+s.shop_type+"']").attr('checked','checked');
					$("input[name='postdb[title]']").val(s.title);
					$("input[name='postdb[url]']").val(s.shop_url);

					$("input[name='postdb[nick]']").val(s.nick);
					$("input[name='postdb[sid]']").val(s.sid);
					if('shop' in s){
						$("input[name='postdb[pic_path]']").val(s.logo);
					}
				});

				return false;
			});


	},style_post:function(){

		//append_btn
		var _this = this;
		// setTimeout(function(){
		// 	if ('mtop' in window && mtop.is_init) {
		// 		var dmsg = '填写爱淘宝<a href="http://ai.taobao.com/style/index.htm" target="_blank" calss="red">http://ai.taobao.com/style/index.htm</a>'
		// 		dmsg+='中某一个搭配的链接即可采集';
		// 		_this.append_btn(dmsg);
		// 		$(".web_btn").click(function(){
		// 		var id = $(".web_id").val();

		// 		if(!id){
		// 			Dialog.info('id不能为空');
		// 			return ;
		// 		}
		// 		if(id.indexOf('http') != -1){
		// 			id = sub_str(id,'&id=','&pid');
		// 		}
		// 		mtop.get_style(id,function(rs){

		// 			if(typeof rs !='object') return ;

		// 			for(var key in rs ){
		// 				var text = "postdb["+key+"]";
		// 				var el = "input[name='"+text+"'],textarea[name='"+text+"']";
		// 				$(el).val(rs[key]);
		// 			}
		// 			rs.images = rs.images.join(',');
		// 			$(".upload_btn").val(rs.images).attr('name','images');

		// 			if (rs.goods.length == 0) {
		// 				Dialog.info('当前搭配的单品可能全部已下架,采集到0个','success');
		// 				return ;
		// 			}

		// 			$(".tbody_dp .num_iid_").each(function(){
		// 				if(!$(this).val()) $(this).parents('.tbody_dp').remove();
		// 			});

		// 			for (var i = 0; i < rs.goods.length; i++) {
		// 				var goods= rs.goods[i];
		// 				$('.add_dp').trigger('click');
		// 				var parent = $('.tbody_dp').last();
		// 				//add_goods_info(parent,rs);
		// 				parent.find('.num_iid_').val(goods.num_iid);
		// 				parent.find('.get_goods').trigger('click');
		// 			}
		// 			Dialog.info('采集成功,添加'+rs.goods.length+'个单品','success');

		// 		});

		// 		return false;
 	// 	});
		// 	}
		// },1500);


		$('.table_main').on('click','.undeltb',function(){
			$(this).parents('.tbody_dp').remove();
			return false;
		});

		$("form").on('submit',function(){
			$(".select_box").remove();
		});

		function add_goods_info(parent,s){
			parent.find('.num_iid_').val(s.num_iid);
				parent.find('.title_').val(s.title);
				parent.find('.picurl_').val(s.picurl) ;
				parent.find('.price_').val(s.yh_price);
				parent.find('._hover_img a').eq(0).attr('href','');
				parent.find('.content_').val(json(s));

				if(s.fid>0){
					parent.find('.select_fid').find("option[value='"+s.fid+"']").attr("selected",true);
				}
				var img_box = parent.find('._hover_img');
				img_box.find('a').remove();
				img_box.removeAttr('data-init');
				img_box.append('<a href="'+s.picurl+'" target="_blank"><img src="'+s.picurl+'" /></a>');
				_hook.hover_img(img_box);

			if(parent.find('.get_goods').closest('tr').find('a').length == 0){
				parent.find('.get_goods').after("<a target='_blank' href='http://item.taobao.com/item.htm?id="+s.num_iid+"'>查看</a>");
			}
		}
		$('.table_main').on('click','.get_goods',function(){
			if($(this).attr('data-return')) return true;
							var parent = $(this).parents('.tbody_dp');
							var iid = parent.find('.num_iid_').val();
							if(!iid) {
								showDialog('请填写商品ID或是商品链接地址');
								return false;
							}
							iid = encodeURIComponent(iid);
							var _this = this;
							ajaxget('/index.php?m=ajax&a=get_goods&num_iid='+iid,function(s){
								if(typeof s.data == 'object' && s.data.aid>0){
									var rs = {'aid':s.data.aid,'title':s.data.title,'yh_price':s.data.yh_price,'num_iid':s.data.num_iid,
										'picurl':s.data.picurl,'url':s.data.url,fid:s.data.fid};

									add_goods_info(parent,rs);
								}else{
									tdj.get_goods(iid,function(s1){
										s1.fid = 0;
										add_goods_info(parent,s1);
									});
								}

							});

							return false;

		});


					click('.add_dp',function(){
						var num = $('.tbody_dp').length;
							var index = num +1;

								var rs = '';
								rs+='<tbody class="tbody_dp" data-index="'+index+'"><tr class="noborder">';
								rs+='<td class="vtop rowform" colspan="3" style="color:#00F">';
								rs+='ID<span style="padding-left:150px;">单品('+index+')</span>';
								rs+='&nbsp;<a href="#" class="undeltb">删除</a>';
//								rs+='<input type="hidden" name="dp_new[]"  value=""/></td></tr>';
								rs+='<tr class="noborder"><td class="td_l">标题:</td>';
								rs+='<td class="vtop rowform"><input name="dp_title[]" value="" type="text" class="txt title_"></td>';
								rs+='<td class="vtop tips2">请输入标题</td></tr><tr class="noborder">';
								rs+='<td class="td_l">商品ID:</td><td class="vtop rowform">';
								rs+='<input name="dp_num_iid[]" value="" type="text" class="txt num_iid_" style="width:280px">&nbsp; ';
								rs+='<input type="button" value="一键抓取" class="btn get_goods" title=""/>&nbsp;';
								rs+='<a href="" target="_blank" ><img src=""  /></a></td>';
								rs+='<td class="vtop tips2">填写淘宝商品的ID或是淘宝商品的链接地址</td></tr>';

								rs+='<tr class="noborder" ><td class="td_l">所属栏目:</td><td class="vtop rowform">';
								rs+=$(".select_box").html();
								rs+='</td><td class="vtop tips2" >本商品的所属栏目</td></tr>';

								rs+='<tr class="noborder"><td class="td_l">价格:</td><td class="vtop rowform">';
								rs+='<input name="dp_price[]" value="" type="text" class="txt price_"></td>';
								rs+='<td class="vtop tips2">请输入当前单品的价格</td></tr><tr class="noborder">';
								rs+='<td class="td_l">图片链接:</td><td class="vtop rowform _hover_img">';
								rs+='<input name="dp_picurl[]" value="" type="text" class="txt picurl_" >';
								rs+='';
								rs+='</td>';
								rs+='<td class="vtop tips2">当前单品的图片</td></tr><tr class="noborder hide">';
								rs+='<td class="td_l">描述:</td><td class="vtop rowform">';
								rs+='<textarea rows="3" name="dp_content[]" cols="50" class="tarea content_"></textarea></td>';
								rs+='<td class="vtop tips2">可填入当前单品的描述或介绍信息</td></tr></tbody>';
								$(".postbody").before(rs);
						});
	},
	zj_post:function(){
		this.style_post();
	}
	,news_post:function(){
		this.style_post();
	}
	,apps_hdp:function(title){
		title = title || '幻灯片';
		var html ='<tr class="noborder" ><td class="td_l" style="width:110px">新'+title+':</td>';
		html+='<td class="vtop rowform " colspan="2"><div class="cl">';
		html+='<div class="z _hover_img" style="width:360px;"  data-left="300">';
		html+='图片地址:<input name="picurl[]" value="" type="text" class="txt" style="margin-bottom:10px;">';
		html+='链接地址:<input name="url[]" value="" type="text" class="txt" >';
		html+='显示标题:<input name="title[]" value="" type="text" class="txt" ></div>';
		html+='<div class="z"><input type="file" name="file" class="file" style="width:180px;"/>';
		html+='<a href="" style="margin-left:20px; " class="red del_hdp">删除</a>';
		html+='</div></div><div class="cl" style="height:20px"></div></td></tr>';
		$(".hdp_m").on('click','.del_hdp',function(){
			$(this).parents('.noborder').remove();
			return false;
		});
		$(".add_btn").click(function(){
			var count = $('.file').length;

			var size = parseInt( $(".add_size").val());
				if(count>= size) {
					Dialog.info('您最多可添加'+size+'条');
					return false;
				}
			$(".hdp_m").append(html);
			$('.file').eq(count).attr('name','file'+count);

		});

	},apps_gezi:function(){
		this.apps_hdp('格子');
	}
	,apps_tpl:function(){
		$(".select option").each(function(i){
			var pic = $(this).data('pic');
			if(pic==1){
				pic = $(this).val();
				pic = 'http://818zhekou.image.alimmdn.com/app_img/'+pic+'.jpg';
				$(this).data('pic',pic);
			}
		});

		var width = $(".select").eq(0).width()+5;
		$(".select option").on('click',function() {
			var pic = $(this).data('pic');
			if(!pic) return true;
			var off = fetchOffset(this,1);
			off.left +=width;
			off.position="absolute";
			$(".app_pic").show().css(off).find('img').attr('src',pic);
		});

		$(".select").hover('',function(){
			setTimeout(function(){
				$(".app_pic").hide();
			},300);
			
		})

	}
	,apps_nav:function(){
			var html ='<tr class="noborder" > <td class="td_l" style="width:110px">新导航:</td>';
			html+='<td class="vtop rowform "><p>名称:<input name="name[]" value="" type="text" class="txt" ></p>';
			html+='<p style="margin-top:10px;">链接:<input name="url[]" value="" type="text" class="txt" >';
			html+='<a href="" style="margin-left:20px; " class="red del_hdp">删除</a></p>';
			html+='<div class="cl" style="height:20px"></div></td><td>APP二级导航名称,最多可添加4个</td></tr>';

			$(".hdp_m").on('click','.del_hdp',function(){
				$(this).parents('.noborder').remove();
				return false;
			});

			$(".add_btn").click(function(){
				var count  = $(".hdp_m .noborder").length;

				var size = parseInt( $(".add_size").val());
				if(count>= size) {
					Dialog.info('您最多可添加'+size+'条');
					return false;
				}
				$(".hdp_m").append(html);
				return false;
			});

	},
	member_post:function(){
		$('.select_fid').on('mousedown',function(){
			if($(this).hasClass('check_select')){
					return false;
			}
			return true;
		});
		/*$('body').on('click','.check_select',function(){
			return false;
		});*/
		$(".check_select_input").click(function(){
			if(this.checked){
				$(".select_fid").removeClass('check_select');
			}else{
				$(".select_fid").addClass('check_select');
			}

		});

		var update = $(".check_select_input").attr('data-update');
		if(update == 1){
			$(".check_select_input").attr('checked',true);
			$(".select_fid").removeClass('check_select');
		}


	},member_group_post:function(){
		$(".model").click(function(){
			var _this = this;
				$(this).parents(".model_item").find(".model_sub").each(function(){
						this.checked = _this.checked;
				});
		});
		$(".model_sub").click(function(){
			var parent = $(this).parents(".model_item").find(".model")[0];
			//if(!this.checked && parent.checked) parent.checked = false;

			//自己选中  父节点必须选中
			//自己没选中   检查兄弟节点.如有选中.则父节点选中
			if(this.checked){
					parent.checked = true;
			}else{
				var is_select = false;
				$(this).parents(".model_item").find(".model_sub").each(function(i){

					if(this.checked) {
						is_select = true;
					}
				});
				parent.checked = is_select;
			}

		});

		//能进后台,全部可点击
		$(".login_admin1").click(function(){
			$("input:checkbox").attr('disabled',false);
		});


		//不能登录后.全部禁止掉
		$(".login_admin2").click(function(){
			$("input:checkbox").attr('disabled',true);
		});

		//一打开就检查,是否可以点击
		if($(".login_admin2")[0].checked){
			$("input:checkbox").attr('disabled',true);

		}
		//提交前,去掉disabled,不然后台接受不表单值
		$(".submit_btn").click(function(){
			$("input:checkbox").attr('disabled',false);
		});


	},
	channel_post:function(){
		this.fetch_post();
		return ;
		$('.select_cates').change(get_sub);
		function get_sub(){
					if($('.select_cates_sub').length ==0) return ;
					if($('.select_cates').val() == 0 ){
						//$('.select_cates').attr('name','postdb[cid]');
						$('.select_cates_sub').html('');
						return ;
					}
					var url = admin_url+"?m=fetch&a=ajax_get_sub&cid="+$('.select_cates').val();
					ajaxget(url,function(s){
						if(s.status == 'error'){
							Dialog.info(s.msg);
							return false;
						}else if(s.status=='success'){

							//$('.select_cates').removeAttr('name');
							$('.select_cates_sub').html((s.msg));
						}
					});
		}

	},
	fetch_post:function(){

		$('.select_cates').change(get_sub);
		function get_sub(first){
					if($('.select_cates').val() == 0 ){
						//$('.select_cates').attr('name','postdb[cid]');
						$('.select_cates_sub').html('');
						return ;
					}
					var url = admin_url+"?m=fetch&a=ajax_get_sub&cid="+$('.select_cates').val();
					ajaxget(url,function(s){
						if(s.status == 'error'){
							Dialog.info(s.msg);
							return false;
						}else if(s.status=='success'){


							$('.select_cates_sub').html((s.msg));
							if(first){
								var cid = $('.select_cates_sub').attr('data-cid');
								if(cid>0){
									$('.select_sub').attr('data-value',cid);
									auto_select('.select_sub');
								}
							}
						}
					});
		}
		get_sub(1);
		auto_select('.auto_select');
	},fanli_setting:function(){
			 $('.add_row').click(function(){
				  var rs  = '<tr class="noborder bili_row">';
				  rs +='<td class="td_l">返利比例:</td><td class="vtop rowform">';
				  rs +='<input class="txt w90" type="text" name="money_up[]" value="" />&nbsp;&nbsp;';
				  rs +='-&nbsp;<input class="txt w90" type="text" name="money_down[]" value="" />&nbsp;&nbsp;';
				  rs +='返&nbsp; <input class="txt w90" type="text" name="money_bili[]" value="" />&nbsp;%';
				  rs +='</td><td class="vtop tips2">用户通过淘客下单,匹配正确后返利时,另外返多少积分给当前用户';
				  rs +='</td></tr>';
				  $('.bili_box').append(rs);

				 return false;
			  });
	},gift_post:function(){
		this.style_post();
	},say_post:function(){
		$(".check_radio").click(function(){
			var val = $(this).val();
			if(val ==2 ){
				$(".check_msg").show();
			}else{
				$(".check_msg").hide();
			}
		});
	},apply_main:function(){
		var index = 0;
		var index2 = 0;
		$(".change_fid").click(function(){
			index = $(this).data('index');
			var offset = fetchOffset(this);
			offset.left +=20;
			offset.top +=20;
			$(".change_channel").slideDown().css(offset);

			var fi = $(".fid_"+index).val();
			if(fi<1) return false;

			$(".select_channel_fid option").each(function(){
				if($(this).val() == fi){
					 $(this).attr('selected',true);
				}
			});

			return false;
		});
		$(".channel_btn").click(function(){
			var fid = $(".select_channel_fid").val();
			if(fid >0){
				$(".fid_"+index).val(fid);
				var text = $(".select_channel_fid").find("option:selected").text().trim();
				$(".channel_name_"+index).text(text).css({'color':'#f00'});
			}
			$(".change_channel").slideUp();
		});
		$(".close_channel").click(function(){
			$(".change_channel").slideUp();
		});

		$(".msg_click").click(function(){
			index2 = $(this).data('index');
			var offset = fetchOffset(this);
			offset.left -=$(".change_msg").outerWidth()-100;
			offset.top +=20;
			$(".change_msg").slideDown().css(offset);
			var org_text = $(".msg_"+index2).val();
			$(".msg_text").val(org_text);

		});
		$(".msg_btn").click(function(){
			var text = $(".msg_text").val().trim();
			$(".msg_"+index2).val(text);
			$(".change_msg").slideUp();
			$(".msg_text").val('');

		});
		$(".close_msg").click(function(){
			$(".change_msg").slideUp();
		});


	},nav_batpost:function(){
				var index = 1;
				var html = $(".first").removeClass('.first').parent().html();
				click('.add_row',function(){
						$(html).appendTo('.row_main').find('.tmp_index').attr('name','tmp['+index+']');
						index++;
						return false;
				});
	},apps_push:function(){

		$(".type_select").change(function(){

			var val  = $(this).find("option:selected").attr('data-default');
			var text = $(this).find("option:selected").attr('data-text');
			$(".tui_text").text(text);
			$(".push_text").val(val);
		});
	},append_btn:function(msg){
            var _this = this;
            var str = '';
            str+='<tbody style="background:rgba(255, 102, 0, 0.56)">';
            str+='<tr class="noborder" > <td  class="td_l">一键抓取:</td>';
            str+='<td class="vtop rowform" >';
            str+='<input name="" value="" type="text" class="txt web_id" >';
            if (msg) {
                str+='&nbsp;&nbsp;&nbsp;&nbsp;<a class="on_help_btn cur">帮助</a>&nbsp;&nbsp;&nbsp;&nbsp;';
            }
            str+='<input type="button" class="btn web_btn" value="抓取" ></td>';
            str+='<td class="vtop tips2 web_tip"></td></tr>';
            str+='</tbody>';
            $(".table_main table").prepend(str);
            if (msg) {
                $('.on_help_btn').click(function(){
                        showDialog(msg,'success');
                });
             }

    },duihuan_post:function(){
    		var el = "input[name=goods_id]";
    		
			$("input[name=get_submit]").click(function(){
					var num_iid  = $(el).val();
					if(!/^\d{10,15}$/.test(num_iid)) num_iid = sub_str(num_iid+'&','id=','&');

			    	if(!num_iid) return true;
			    	ajaxget('/index.php?m=ajax&a=get_message&num_iid='+num_iid,function(rs){
			    		if(rs.status){
			    			UM.getEditor('UM_box').setContent(rs.data);
			    		}else{
			    			Dialog.info(rs.msg);
			    		}
			    	});

			})
  	}  	


};

function auto_select(el,value){
	el = el || 'select';
	$(el).each(function(){
		var text = value || $(this).attr('data-value');
		if(text){
				$(this).find("option").each(function(){
					L($(this).val() + '--'+text);
					if($(this).val() == text){

						$(this).attr('selected',true);
					}
				});
		}

	});

}
modue_list.main();
if(typeof modue_list[CURMODULE] == 'function') (modue_list[CURMODULE])();
if(typeof modue_list[CURMODULE+'_'+CURACTION] == 'function') (modue_list[CURMODULE+'_'+CURACTION])();


