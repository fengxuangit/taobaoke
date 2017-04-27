

function init(type){
		var address = $("input[name='address']").val();
		if(!address){
			Dialog.info('数据库地址不能为空');
			return false;
		}
		var port = $("input[name='port']").val();
		if(!port){
			Dialog.info('数据库端口不能为空');
			return false;
		}
		
		var username = $("input[name='username']").val();
		if(!username){
			Dialog.info('数据库用户名不能为空');
			return false;
		}
		var password = $("input[name='password']").val();
		if(!password){
			Dialog.info('数据库密码不能为空');
			return false;
		}
		var name = $("input[name='name']").val();
		if(!name){
			Dialog.info('数据库名称不能为空');
			return false;
		}
		
		var pre = $("input[name='pre']").val();
		if(!pre){
			Dialog.info('数据库表前缀不能为空');
			return false;
		}
		
		$('.install_box,.hd_m').removeClass('shake');
		var url = '/install.php?a='+type+'&t='+Math.random();
		var debug = 0;
		if(location.href.indexOf('debug') != -1) debug = 1;
		var data = {address:address,username:username,password:password,name:name,port:port,debug:debug,pre:pre};
	
		
		$.ajax({type:'POST',url:url,data:data,dataType:'json',success:function(s){
			if(s.status == 'error'){
				if(s.msg.indexOf('using password: YES') != -1){
					s.msg = '数据库用户名或密码不正确';
				}else if(s.msg.indexOf('存在相同的系统表') != -1){
					var msg = s.msg;
					msg+=',是否删除已存在的表?删除后不可恢复';
					showDialog(msg,'confirm','',function(){
						if(confirm('确认要删除已存的表吗?删除后不可恢复')){
							del_tab();
						}
					});
					return ;
				}
				$('.install_box,.hd_m').addClass('shake');
			}else if(s.status == 'success'){
				$(".check_btn").remove();
				$(".install_btn").show();
				if(type == 'init'){
					

					$('.step1').addClass('BounceOutB');
					$(".box1").addClass('FlipOutX');
					setTimeout(function(){
						//切换标题
						$(".step1").hide();
						$('.step2').show().addClass('BounceInT');
						
						//切换内容
						$(".box1").hide();
						$(".box2").show().addClass('FlipInX');
					},1200)
				}
				
			}
			var time = s.status == 'success' ? 4000:15000;
			Dialog.info(s.msg,s.status,time);
		},error:function(s){
			showDialog(s.responseText);
		}})
}

function del_tab(){
	var url = '/install.php?a=del_tab&t'+Math.random();
	$.get(url,'',function(s){
		Dialog.info(s.msg,s.status);	
	})
}

function install_data(){
		var user_name = $("input[name='user_name']").val();
		if(!user_name){
			Dialog.info('用户名不能为空');
			return false;
		}
		
		var user_password = $("input[name='user_password']").val();
		if(!user_password){
			Dialog.info('用户名密码不能为空');
			return false;
		}		
		var inset_test_data =  $("input[name='inset_test_data']:checked").val();
		var url = '/install.php?a=inset_data&t'+Math.random();
		var data = {user_name:user_name,user_password:user_password,inset_test_data:inset_test_data};
		$.ajax({type:'POST',url:url,data:data,dataType:'json',success:function(s){
			Dialog.info(s.msg,s.status);
			if(s.status == 'success'){
				$(".box2").addClass('FlipOutX');
				pic();
				window.onbeforeunload = null;
				setTimeout(function(){
						//切换标题
						$(".step2").hide();
						$('.step3').show().addClass('BounceInT');
						
						//切换内容
						$(".box2").hide();
						$(".box3").show().addClass('FlipInX');
						
						
					},1200);
			}
		},error:function(s){			
			var msg = s.status != 200 ? '错误码:'+s.status:'';
			if(!s['responseText']) msg+=',错误信息:';
			showDialog(msg+s.responseText);
		}})
}
function pic(){
	if(_load('pic') ==1) return ;
	var pic = new Image();
	var version = $('.body').attr('data-version');
	var time = $('.body').attr('data-updatetime');
	var s = $('.body').attr('data-system');
	var tae = $('.body').attr('data-tae');
	pic.src = 'http://www.uz-system.com/?m=pic&url='+encodeURIComponent('http://'+location.host)+'&version='+version+'&time='+time+'&s='+s+'&tae='+tae;
	_save('pic',1);
	window.onbeforeunload = null;
}

function check_new_version(){
	var ver = $('.body').attr('data-version');
	var time = $('.body').attr('data-updatetime');
	var s = $('.body').attr('data-system');
	var url = 'http://www.uz-system.com/download/check_update.php?version='+ver+'&updatatime='+time+'&s='+s;
	
	  $.ajax({type:'GET',url:url,data:'',dataType:'jsonp',success:function(s){
		  if(s.status == 'success'){
			  if((s['version'] && s['version'] > ver) || (s['updatatime'] && s['updatatime'] > time)){
					  showDialog('检查到系统最新版为'+s.version+',您当前版本:'+ver+',点击确定进入下载页面','confirm','',function(){
						 if(s.url)window.open(s.url);
					});
		  	  }
		  }		
	  },error:function(s){
		 
	  }})
	
}
 

$(function(){
	check_new_version();
	var tae = $('body').attr('data-tae');
	if(tae != '0' && tae != '1') {
		window.onbeforeunload = null;
		location.href = '/install.php';
	}
	var pic_arr = ['install/static/slide1.jpg','install/static/slide2.jpg','install/static/slide3.jpg'];
	var h = document.documentElement.clientHeight;
	$('.body').height(h);
	
	run_bg('.body',pic_arr);

	$('.step1').show();
	$(".check_btn").click(function(){
		init('check')
		return false;
	});
	$(".admin_url,.index_url").hover(function(){
		$(this).addClass('RubberBand');
	},function(){
		$(this).removeClass('RubberBand');
	})
	$(".install_btn").click(function(){
		init('init')
		return false;
	});
	
	$(".install_data_btn").click(function(){
		install_data();
		return false;
	});

})

window.onbeforeunload  = function(ev){
	return confirm('您确要关闭或刷新本窗口吗?如果您当前系统只安装一半请点击取消');
}


