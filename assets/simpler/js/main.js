

var modue_list = {
	main:function(){

		$('.readpage li').addClass('waves-effect');
		$('.btn').addClass('waves-effect waves-light');

		_scroll(function(top){
			if(top>110){
				$('nav').removeClass('container wp').addClass('nav_fixed').find('ul').addClass('container wp').css({'margin':'0 auto'});
			}else{
				$('nav').addClass('container wp').removeClass('nav_fixed').find('ul').removeClass('container wp').removeAttr('style');
			}
		});

	},
	index_main:function(){

			$('.slider').slider({full_width: true});
	},img_list:function(){

			var cfg = {box:'.container',obj:'._add_like',className:'',type:'img',a:'like',callback:function(rs,obj){
				var data = ~~rs.data;
				$(obj).find('span').text(data);
				$(obj).find('i').removeClass('icon-xihuan2').addClass('icon-xihuan on');
			},haslike:function(obj){
				$(obj).find('i').removeClass('icon-xihuan2').addClass('icon-xihuan on');
			}};
			var cfg2 = {box:'.container',obj:'._add_like2',className:'',type:'img',a:'hate',callback:function(rs,obj){
				var data = ~~rs.data;
				$(obj).find('span').text(data);
				$(obj).find('i').removeClass('icon-diancai').addClass('icon-cai2 on');
			},haslike:function(obj){
				$(obj).find('i').removeClass('icon-diancai').addClass('icon-cai2 on');
			}};

			$F('_add_like2',function(){
				new _add_like2(cfg);
				new _add_like2(cfg2);
			});
	},img_main:function(){

			this.img_list();

	},goods_main:function(){
		var iid = $('.comment_list').data('num_iid');
		if(!iid) return ;
		var _this =this;
		$F('tdj',function(){
			tdj.get_comment(iid,function(rs){
				_this.append_comment_list(rs);
			})
		});

		var images = $('.goods_em').data('images');
		if (images) {
			images = images.split(',');
			for (var i = 0; i < images.length; i++) {
				new Image().src = images[i];
			};
			var index = 0;
			$('.goods_em').hover(function(){
				var pic = images[index];
				$(this).find('.info').css({backgroundImage:'url('+pic+')'});
				index++;
				if (index>=images.length)index = 0;
			});
		}


	},append_comment_list:function(rs){
		var str = '';
		for (var i = 0; i < rs.length; i++) {
			var v = rs[i];
			str += '<li class="collection-item avatar">';
			if('pics' in v && v.pics[0]){
				//var pic = v.pics[0];
				var pic = 'https://gw.alicdn.com/tps/i3/TB1yeWeIFXXXXX5XFXXuAZJYXXX-210-210.png_60x60.jpg'
				str += '<img class="circle" src="'+pic+'" />';
			}else{

				str += '<i class="circle  iconfont icon-circularlogin1"></i>';
			}

			str += '<span class="title">' + v.displayUserNick + ": " + v.rateContent + '</span>';
			str += '<p>' + v.auctionSku;
			str += "<br/>";

			str += v.rateDate + '</p>';
			str += '<a href="#!" class="secondary-content">';
			if (v.tmallSweetPic) {
				str += '<img src="https://g.alicdn.com/tm/member-club/4.6.0/img/' + v.tmallSweetPic + '" />';
			}
			str += '</a></li>';
		}
		$('.comment_list>ul').append(str);

	}

}

	modue_list.main();
	if (typeof modue_list[CURMODULE] == 'function')(modue_list[CURMODULE])();
	if (typeof modue_list[CURMODULE + '_' + CURACTION] == 'function')(modue_list[CURMODULE + '_' + CURACTION])();

