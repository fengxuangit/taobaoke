
var modue_list = {
	main:function(){
				//显示分享弹窗

				$(".show_share_box").click(function(){
						showMenu({ctrlid:'share_box',pos:'!00','mtype':'win','duration':3});
					return false;
				});


				$(".so_tb").click(function(){
					var val = $(".so_kw").val();

					if(!val) return false;
					var url = $(this).attr('url');

					$("#search_form").attr("action",url).attr("target","_blank");
					$(".so_kw").attr('name','key');
					$("#search_form").attr('method','GET');
					
					if(val)_count.add(9,val);
				});

				$(".so_web").click(function(){
					var val = $(".so_kw").val();
					if(!val) return false;

					$("#search_form").attr('method','POST');
					var url = $(this).attr('url');
					$("#search_form").attr("action",url).removeAttr("target");
					$(".so_kw").attr('name','kw');

					if(val)_count.add(9,val);
				});

				hover(".rightnfixda2",function(){
					$(".rightnfixdspan1").show();
				},function(){
					$(".rightnfixdspan1").hide();
				});


				_scroll(function(top){
					if(top>810){
						$(".i2_cagmenud_m").addClass('index_fixed');
					}else{
						$(".i2_cagmenud_m").removeClass('index_fixed');
					}
					// if(top>300){
					// 	$(".menufixd").show();
					// }else{
					// 	$(".menufixd").hide();
					// }
				});


				//右边侧边栏
				hover(".testguanzhumou",function(){
					$(".guanzhuobjd").show();

				},function(){
					$(".guanzhuobjd").hide();
				})

				//顶部关注
				var wx_time = null;
				hover(".wxword",function(){
					clearTimeout(wx_time);
					$(".wtword").eq(0).show();
					$(".wtword").eq(1).hide();

				},function(){
					wx_time=setTimeout(function(){
					$(".wtword").eq(0).hide();
					$(".wtword").eq(1).show();
					},500)
				})



				//顶部分享
				var fixzt=null;
				hover(".headsharebox",function(){
					clearTimeout(fixzt);
					$(".jiathis_style").show();
				},function(){

				   fixzt=setTimeout(function(){
						$(".jiathis_style").hide();
					},500)
				})
				hover(".jiathis_style",function(){
					clearTimeout(fixzt);
					$(".jiathis_style").show();
				},function(){
					clearTimeout(fixzt);
				   fixzt=setTimeout(function(){
						$(".jiathis_style").hide();
					},500)
				})

				//签到
					function qiandao(){
						var head_qiandao=$(".head_qiandao");
						var qdtime;
						hover(".hpz_head_qd",function(){
							 clearTimeout(qdtime);
							head_qiandao.css('display','block');
							$(".head_qiandao").show();
						},function(){
							  qdtime=setTimeout(function(){
								$(".head_qiandao").hide();
							},200);
						})

						hover(".head_qiandao",function(){
							 clearTimeout(qdtime);
						   $(".head_qiandao").show();
						},function(){
							 $(".head_qiandao").hide();
						})
					}
					qiandao();


				hover(".rightnfixda2",function(){
					 $(".rightnfixdspan1").show();
				  },function(){
						$(".rightnfixdspan1").hide();
				});




				click('.a_logout',function(){
					return confirm('您确定退出登录吗?');
				});

				$F('_count');

				$('.hpzmenu li').click(function(){
					var text = $(this).text();
					_count.add(1,text);
				})
				$('.score_nav_ul li').click(function(){
					var text = $(this).text();
					_count.add(20,text);
				})
				
				$('.fixedmenu14 li').click(function(){
					var text = $(this).text();
					_count.add(2,text);
				})
				

				$('.hpz_log').click(function(){
					_count.add(12,0);
				})
				
				$('.daddfavorite').click(function(){
					var val = $(this).closest('.i2_goodsd').find('.i2_goodsname').text();
					_count.add(26,val);
				})

				$('.hpz_bottom li').click(function(){
					var val = $(this).text();
					_count.add(13,val);
				})
				
				$('.h_qdd1btn2').click(function(){
					var val = $(this).text();
					_count.add(24,0);
				})
				
				$('.rightnfixda1').click(function(){
					var val = $(this).text();
					_count.add(21,0);
				})



				

				/*var pic = $(".ads_2").attr('src');
				if(pic){
					var img = new Image();
					img.src = pic;
					img.onload = function(){
						$(".ads_2").height(this.height);
					}

				}*/
		//收藏商品
		var cfg1 =  {box:'.i2_goodsli',obj:'.daddfavorite',className:'on',type:'goods',
					text:'',success_text:'',error_text:'',parent:'.i2_goodsul',check:false,a:'favorite'};

		$F('_add_like',function(){
			new _add_like(cfg1);
		});



	},
	index_main:function(){
			hover('.headsharebox',function(){
				$(".jiathis_style").show();
			});
			hover(".hpz_headmenu",function(){},function(){
				$(".jiathis_style").hide();
			})

			hover(".kt_box li",function(){
				$(this).children('.tit_desc').slideDown();
			},function(){
				$(this).children('.tit_desc').slideUp();
			})

			$('.i2_goodscond  li').click(function(){
				_count.add(3,1);
			})
			$('.i2_goodscond  .juan_btn').click(function(ev){
				_count.add(22,1);
				ev.stopPropagation();
			})

			$('.links_list_box  a').click(function(){
				var text = $(this).text();
				_count.add(25,text);
			})

			$('.system_ad_2').click(function(){
				_count.add(19,1);
			})


	},search_shop:function(){

			$(".item_bar li").each(function(i){
				  this.index = i;
			});
			$(".item_bar li").hover(function() {

				$(".item_list").hide().eq(this.index).show();
			});

			$(".item_bar li").click(function(i){
				  $(".item_list").hide().eq(this.index).show();
				  return false;
			});
    },goods_main:function(){
			$(".bucuo_detail_bmenu li").each(function(i){
				$(this).attr('data-index',i);
			});
			$(".bucuo_detail_bmenu li").hover(function(){
				var index = $(this).attr('data-index');
				index = parseInt(index);
				$(".index_contentul2").hide().eq(index).show();
				$(".bucuo_detail_bmenu li").removeClass('bucuo_current').eq(index).addClass('bucuo_current');
			});
			$(".bucuo_detail_bmenu li").click(function(){
				var index = $(this).attr('data-index');
				index = parseInt(index);
				$(".index_contentul2").hide().eq(index).show();
				$(".bucuo_detail_bmenu li").removeClass('bucuo_current').eq(index).addClass('bucuo_current');
			});

			if($('._comment_list').length==0) return false;
			var id = $('._comment_list').attr('data-num_iid');
			function make_html(obj){
				if(obj.tamllSweetLevel>3)obj.tamllSweetLevel=3;
				obj.displayRatePic=obj.displayRatePic.replace(/\.gif/,'');
				obj.displayRatePic=obj.displayRatePic.replace(/b_/g,'');
				var rs='<li><div class="rate-user-info"> <span class="rate-user"> '+obj.displayUserNick+' <span class="rate-user-grade"> ';
					rs+='<em class="tm-icon t'+obj.tamllSweetLevel+'"> </em> <em class="tm-icon vip-icon '+obj.displayRatePic+'"></em> </span> </span> ';
					rs+='<span class="rate-right y"> <em class="rate-time">'+obj.rateDate+'</em> <em> 评论来自 '+obj.cmsSource+' </em> </span>';
					rs+='<div class="rate-leirong">'+obj.rateContent+'</div>';
					rs+='</div></li>';
					return rs;
			}

			var goods_juan_url = $('.goods_juan_url a').attr('href');
			var url = $('.go_btn').attr('href');
			if(url && url.indexOf('a=go_pay')>-1 && goods_juan_url && goods_juan_url.indexOf('uland.taobao.com')>-1){
				$('.go_btn').attr('href',goods_juan_url).removeAttr('isconvert data-itemid');
			}

			appendscript("assets/global/js/tdj.js",function(){
					tdj.get_comment(id,function(list){
						var str = '';
						for (var i = 0; i < list.length; i++) {

							str += make_html(list[i]);
						}
						$(".bucuo_detail_bmenu li a span").text( list.length+'+');
						$("._comment_list").append(str);
					});
			});


			

			$('.goods_juan_url').click(function(){
					_count.add(8,3);
			})

			$('.go_btn,.bucuo_goods_img').click(function(){
					_count.add(7,3);
			})

			$('.bucuo_de_bkico').click(function(){
					_count.add(27,3);
			})
			
			$('.index_bucuozhekou li').click(function(){
					_count.add(3,'同类热销推荐');
			})


	},activity_main:function(){
				Marquee({'box':'.actindexlfd','show':'.actilful1 li','bar':'.indexiocns li','time':'4000','type':3});
	},duihuan_main:function(){
				click('.duihuan_start',function(){
					showMenu({ctrlid:'duihuan_box',pos:'!00','duration':3});
					$('.shiyong_id').val($(this).attr('data-id'));
					return false;
				});
				click('.duihuan_box_close',function(){
					hideMenu('duihuan_box','menu');
				});

				click('.dbli',function(){
					$(".dbli").removeClass('dbseclect');
					$(this).addClass('dbseclect');
					var index = parseInt($(this).attr('data-index'));
					$(".dbmiaoshuobj").hide().eq(index).show();

				});
	},duihuan_list:function(){
		hover(".score_producte_title_ul li",function(){
			var index = parseInt($(this).attr('data-index'));

			$(".score_producte_title_ul li").removeClass('on').eq(index).addClass('on');
			$(".score_producte_list").hide().eq(index).show();
		});

		Marquee({'box':'.score_head_banner','show':'.show_li','bar':'.bar_li','time':'4000','type':3});
	},img_main:function(){
		$('.feed-cnt .div').remove();
	},index_yaoqing:function(){
		copy('.invent_btnfz',$("#inventurl").val());
	},shop:function(){
		_hook.init_tdj(2);
	},shop_list:function(){
		Marquee2({box:'.hpz_ppt_logosd',run_box:'.hpz_pptlogul',time:4000,size:980,type:'left','split':7,'each_time':200});
	},home:function(){
		Marquee2({box:'.ppt_goodscontent',run_box:'.ppt_box_m',up:'.left_btn',next:'.right_btn',time:2000,size:970,type:'left','split':4,'each_time':200});
	},home_favorite_list:function(){
		//收藏商品
		var type = $('.uc_scoredtab').attr('data-type');
		if(!type)type = 'auto';

		var cfg1 =  {box:'.uc_scoredtab',obj:'.afavorite',className:'on',type:type,
					text:'',success_text:'',error_text:'',parent:'.uc_scoredtab',check:false,a:'favorite'};

		$F('_add_like',function(){
			new _add_like(cfg1);
		});

	}
	,apply:function(){
		$(".apply_check_btn").click(function(){

					var iid = $(".apply_check_value").val();
					if(!iid) {
						Dialog.info('要查询商品ID不能为空');
						return ;
					}
					var url = '/index.php?m=apply&a=apply_check_ajax&num_iid='+iid;

					ajaxget(url,function(s){
						showDialog(s.msg);
					});

		});
	},
	member:function(){
		if($('.member_hdp').length>0){
			Marquee({'box':'.member_hdp','show':'.cell','up':'.onleft','next':'.onright','time':'3000','type':2,'className':'FadeIn'});
		}
	}
	,style:function(){
		window.$ = jQuery;
		setInterval(function(){
			$ = jQuery;
		},500);
		$(".style-waterfall,.recommend-list").on('mouseenter mouseleave','.info-wrap',function(e){
			if(e.type == 'mouseenter'){
				$(this).find('.info-detail span').hide();
				//$(this).find('.info-detail span').hide();
				$(this).find('.thumb-goods').slideDown();
			}else if(e.type == 'mouseleave'){
				$(this).find('.thumb-goods').slideUp();
				//if($(this).find('.info-detail span').length>0)	$(this).find('.info-detail span').show();
			}
		});

		//收藏搭配
		var cfg1 =  {box:'.ks-waterfall-col',obj:'.favorite',className:'hasFavorite',type:'style',a:'favorite',
					text:'',success_text:'',error_text:'',parent:'#J_listFlowCon',check:false};

		$F('_add_like',function(){
			new _add_like(cfg1);
		});
	}

	//搭配的瀑布流通用回调
	,styleCallBack:function(rs,obj){

		 			var data = rs.data;

					  for(var i=0;i<data.length;i++){

							 //data[i].id_url ="/style/"+data[i].id+'.html';;		//伪静态地址
							 var rs = '';
							  rs+='<div class="ks-waterfall-col" style="display:none;"><div class="mate-box ks-waterfall" >';
							  rs+='<div class="info-wrap"><div class="info-img">';
							  rs+='<a href="'+data[i].id_url+'" target="_blank">';
							  var width = data[i].w ? data[i].w :230;
							  var height = data[i].h ? data[i].h :345;
							  if(width>230){
								  if(height>345){
									  var v = width / 230;
									  height = parseInt(height/v);
								  }
								  width = 230;
							  }
							  if(width == 0) width = 230;
							  if(height ==0) height = 345;

							  rs+='<img src="'+data[i].picurl+'_220x10000.jpg" width="'+width+'" height="'+height+'" onerror="_onerror(this);" ></a>';
							  rs+='<div class="info-detail"><span>'+data[i].goods.length+'件搭配宝贝</span><div class="thumb-goods">';
							  rs+='<div class="thumb-mL10 clearfix">';
							  for(var j=0;j<data[i].goods.length;j++){
								  var tmp = data[i].goods[j];
								  if(j<4){
									  rs+='<a href="'+data[i].id_url+'" target="_blank"><img src="'+tmp.picurl+'_72x72xz.jpg" ></a>';
								  }
							  }
							  rs+='</div></div></div></div><p class="goods-txt">'+data[i].content+'</p>';
							  rs+='<p class="share-action cl"> <a class="favorite add_like" data-id="'+data[i].id+'" ';
							  rs+=' data-type="style"  >收藏</a></p>';
							  rs+='</div>';
							  rs+='<div class="share-user"> <p class="user-line"> <a href="'+data[i].id_url+'" target="_blank" class="user-img">';
							  rs+=' <img src="'+data[i].user_pic+'" alt="">';
							  rs+='</a> <em class="uname"><a href="'+data[i].picurl+'" target="_blank">'+data[i].username+'</a>';
							  rs+='</em> <span class="daren-icon"></span>';
							  rs+='</p> </div>';
							   rs+='</div></div>';

							$(rs).appendTo(obj.box).fadeIn(1000);

					  }
					  //return rs;
	}
	,style_list:function(){

		  var url = '/index.php?m=style&a=list&json=1';
		  if('cate' in $_GET) url+='&cate='+ ~~$_GET.cate;
		  var config = {box:'#J_listFlowCon',el:'.ks-waterfall-col',max_list:5,
						  margin:7,index:1,url:url,page:2,callback:this.styleCallBack};
		  $(".listtop").height($("#J_style_nav").outerHeight());
		  $F('waterfall',function(){

			 new _waterfall(config).run();
		  });

	}
	,style_main:function(){
		 var url = '/index.php?m=style&a=list&json=1';
		  if('cate' in $_GET) url+='&cate='+ ~~$_GET.cate;
		  var config = {box:'#J_listFlowCon',el:'.ks-waterfall-col',max_list:5,
						  margin:5,index:1,url:url,page:2,callback:this.styleCallBack};

		   $F('waterfall',function(){
				 new _waterfall(config);
		  });
		//上面喜欢专辑
		var cfg = {'box':'#J_detailRight','obj':'.J_Follow','className':'followed','type':'style',a:'favorite',
					'text':'1','success_text':'已收藏|取消','error_text':'收藏搭配'};

		$F('_add_like',function(){
			new _add_like(cfg);
		});
	},index_all:function(){

		$('.i2_goodscond  li').click(function(){
			_count.add(3,2);
		})

		$('.i2_goodscond  .juan_btn').click(function(ev){
			_count.add(22,2);
			ev.stopPropagation();
		})


	},index_cate:function(){
		$('.i2_goodscond  li').click(function(){
			_count.add(3,16);
		})
		$('.i2_goodscond  .juan_btn').click(function(ev){
			_count.add(22,16);
			ev.stopPropagation();
		})

	},channel:function(){
		$('.i2_goodscond  li').click(function(){
			_count.add(3,17);
		})

		$('.i2_goodscond  .juan_btn').click(function(ev){
			_count.add(22,17);
			ev.stopPropagation();
		})


	},apps:function(){
		$('.code_area .code_btn').click(function(){
				var index = $(this).index();
				var act = 5;
				if(index == 1) act = 6;
				_push.add(act,8);
		});
	}

}
modue_list.main();
if(typeof modue_list[CURMODULE] == 'function') (modue_list[CURMODULE])();
if(typeof modue_list[CURMODULE+'_'+CURACTION] == 'function') (modue_list[CURMODULE+'_'+CURACTION])();


