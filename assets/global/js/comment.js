
var comment = {
	box:null,
	data:null,
	user_pic:'assets/global/images/avatar.png',
	comment_msg:'',
	success_callback:null,
	onload:null,
	placeholder:'请输入要评论的内容',
	init:function(){
		var _this = this;
		if($("._comment").length == 0) return false;
		if($(".admin").length > 0) return false;
		
		$("._comment").each(function(){
				var parent = $(this);
				$(this).addClass('comment_box hide');
				$(this).append('<div  class="comment_main"><ul class="comment_comments"></ul></div>');
				var id = parent.attr('data-id');
				var type = parent.attr('data-type');
				parent.attr('data-page',1);
				_this.get_list(this,function(){
					var rs = _this.make_post_form();
					parent.find('.comment_main').prepend(rs);
					if(typeof _this.onload == 'function') _this.onload(_this);
				});

				$(this).on('click','.comment_post_button',function(){
					if(!is_login()) return false;

					//window.$ = jQuery;
						var id = $(this).attr('data-replyid');
						var obj = null;

						// 回复某条评论
						if(id){
							var parent = $(this).parents("li.comment_post");
							obj = _this.make_obj(parent);
							obj.is_reply = 1;
							obj.reply_id = id;
						}else{

							var parent = $(this).parents(".comment_box");
							obj = _this.make_obj(parent);
						}						
						if(obj == false ||obj == null || typeof obj !='object') return false;
						_this.post(obj);						
						return false;
				});
		});


		$(".comment_comments").on('click','.comment_post_reply',function(){
				if(!is_login()) return false;
				var box = $(this).parents('.comment_body').find('.comment_replybox');
				var len =  box.length;
				
				if(len>0) {
					box.remove();
					return false;
				}
				var id = $(this).parents('li.comment_post').attr('data-replyid');
				
				var rs = _this.make_post_form(id);	
				$(this).parents('.comment_body').append(rs);
				return false;				
				
		});
		$(".comment_comments").on('click','.comment_post_delete,.comment_del_replay',function(){
						var _this = this;
						showDialog('您确定删除当前评论?删除后不可恢复','confirm','',function(){
							var url = "";							
							if($(_this).attr('data-replyid')){
								var id = $(_this).attr('data-replyid');
							}else{
								var id = $(_this).parents('li.comment_post').attr('data-replyid');
							}
							var type = $(_this).parents('.comment_box').attr('data-type');
							var type_id = $(_this).parents('.comment_box').attr('data-id');
							
							var url = "/index.php?m=comment&a=del&inajax=1&id="+id+'&type='+type+'&type_id='+type_id;
							ajaxget(url,function(s){
									Dialog.info(s.msg,s.status);
									if(s.status == 'success'){	
										$(_this).parents('.comment_post').remove();
										return false;
									}
							});
							return false;	
				});
				return false;
		});
		
		$(".comment_box").on('click','.comment_paginator a',function(){
			
			var p  = $(this).parents('.comment_box');
			var page = parseInt(p.attr('data-page'));
			p.attr('data-page',page+1)
			_this.get_list(p);
			return false;
		})
		
	},
	post:function(data){
		var _this = this;
			$.ajax({
					url:"/index.php?m=comment&a=post&inajax=1",data: data,dataType:"json",type:"POST",
					success: function(s) {
						
						if(s.status == 'error'){
							Dialog.info(s.msg,s.status);
							return false;
						}
						_this.data = data;
						_this.box.find(".comment_comments").prepend(_this.make_html(s.data));
						_this.box.find(".commen_message").val('');						
						
						if(typeof _this.success_callback =='function' ){
							_this.success_callback(s,_this);
						}else{
							Dialog.info(s.msg,s.status);
						}
						
					},
					error: function(s){
						Dialog.info('发布失败');
						L(s);
					}
			});
	},
	make_post_form:function(reply_id){
				
				var rs='<div class="comment_replybox"><a class="comment_avatar" ><img src="'+this.user_pic+'" ></a><div class="cl comment_form">';
					rs+='<div class="comment_post_wrapper comment_rounded-top">';
					rs+='<textarea name="message" class="commen_message" title="Ctrl+Enter快捷提交" placeholder="'+this.placeholder+'"></textarea>';
					rs+='<pre class="comment_hidden-text"></pre></div><div class="comment_post_toolbar">';
					rs+='<div class="comment_post_options comment_gradient-bg"></div>';
					var reply = '';
					if(reply_id>0) reply = " data-replyid='"+reply_id+"'";
					var text = UID ? '发言':'登录后发言';
					rs+='<button class="comment_post_button" type="button" name="onsubmit" '+reply+'>'+text+'</button>';
					rs+='<div class="comment_toolbar-buttons"><span class="comment_msg">'+this.comment_msg+'</span>';
					rs+='<a class="comment_toolbar-button comment_add-emote" title="插入表情"></a>';
					rs+='<a class="comment_toolbar-button comment_add-image" title="插入图片"></a></div></div></div></div>';
					return rs;
	},
	make_html:function(rs){
				
				var str='<li class="comment_post" data-replyid="'+rs.id+'"><div class="comment_post_self" >';				
					str+='<div class="comment_avatar"><img src="'+rs.user_pic+'"></div>';
					str+='<div class="comment_body"><div class="comment_header">'+rs.username+'</div>';				
					str+='<div class="comment_content">'+rs.content+'</div><div class="comment_footer comment_actions">';
					str+='<span class="comment_time" >'+(rs.dateline)+'</span>';
					str+='<a class="comment_post_reply" href="#"><span class="comment_icon comment_icon-reply"></span>回应</a>';
					str+='<a class="comment_post_report" href="#"><span class="comment_icon comment_icon-report"></span>举报</a>';
					if(rs.username == USERNAME){
						str+='<a class="comment_post_delete" href="#"><span class="comment_icon comment_icon-delete"></span>删除</a>';
					}
					str+='</div>';
					
					
					
					if(typeof rs.comment_list == 'object' && rs.comment_list.length>0){
						var data = 	rs.comment_list;
						for(var i =0;i<data.length;i++){							
							var rs='<div class="comment_list cl"><div class="comment_list_body comment_list_top" >';
							rs+='<span>'+data[i].username+' 回复</span> '+dgmdate(data[i].dateline);
							if(data[i].username == USERNAME) rs+=' <a href="#" class="comment_del_replay"  data-replyid="'+data[i].id+'">删除</a>';
							rs+='</div><div class="comment_list_body" >'+data[i].content+'</div></div>';	
							str+=rs;
						}						
					}
					str+='</div></div></li>';	
					return str;
	},
	make_obj:function(parent){
						var _this = this;
						_this.box = parent;
						var reply_box= parent.find(".comment_replybox");
						
						var comment_box = parent.find(".comment_comments");
						var list = parent.find(".comment_post");
						var content = reply_box.find(".commen_message").val();
						
						if(content == '' || !content){
							Dialog.info('要评论的内容不能为空');
							return false;
						}
						content = $("<div>"+content+"</div>").text();
						content = content.replace(/\"\'/g,'');
						if(!content ||content =='' ){
							Dialog.info('要评论的内容不能为空');
							return false;
						}
						content = cutstr(content,330);
						if(parent.attr('data-replyid')){
							var id = parent.parents('.comment_box').attr('data-id');
							var type = parent.parents('.comment_box').attr('data-type');
						}else{
								var id = parent.attr('data-id');
								var type = parent.attr('data-type');
						}
					
						var reg = /^[a-z_]+$/;
						if(!reg.test(type)) {
							Dialog.info('Type Error');					
							return false;
						}
						if(!/^[0-9]+$/.test(id)){
							Dialog.info('Id Error');
							return false;
						}
						var obj = {'content':content,'id':id,'type':type};
						return obj;
	},
	get_list:function(obj,call){
			var _this = this;
			var id = $(obj).attr('data-id');
			var type = $(obj).attr('data-type');
			var page = $(obj).attr('data-page');
			if(!id || !type) return false;
			ajaxget("/index.php?m=comment&a=main&inajax=1&id="+id+'&type='+type+'&page='+page,function(s){
				
				if(s.status == false || typeof s.data !='object') {
					if(s.data == -1){
						$(obj).remove();
					}else{
						if(s.msg != '当前模块不允许评论或留言') L(s);
					}
					return false;
				}
				
				$(obj).removeClass('hide');
				
				
				if(s.data.data.length == 0 && page>1){
					Dialog.info('已加载全部','error');
					$(obj).find(".comment_paginator").remove();
				}
				
				_this.comment_msg = s.data.comment_msg;
				
				var data = s.data.data;	
				if(page==1 && s.data.max_page>page){
					$(obj).find('.comment_main').append(' <div class="comment_paginator ff" ><a href="#">下一页</a></div>');
				}else if(s.data.max_page <=page && page>1){
					$(obj).find(".comment_paginator").remove();
				}				
				for(var i =0;i<data.length;i++){					
					var rs = _this.make_html(data[i]);
					$(obj).find(".comment_comments").append(rs);
				}
				
				if(typeof call == 'function')call(s);
								
			});
	
	}
}

