

//添加专辑
var _zj = {
	el:null,	//要发布的商品属性在当前元素上
	id:0,		//发布目标专辑ID
	data:null,  //待发布的商品数据
	init:function(el){
			if(el)this.el = el;
			if(!is_login()) return false;
			//先AJAX获取个人的所有分类
			this.get_user_list();
					
	},get_user_list:function(){
		var num_iid = $(this.el).attr('data-num_iid');
		if(!num_iid) {
			Dialog.info('添加专辑失败,ID不存在');
			return ;
		}
		var url ='/index.php?m=zj&a=get_user_list&num_iid='+num_iid;
		$.getJSON(url,'',function(s){
			if(s.status == 'error'){
				Dialog.info(s.msg,s.status);
				return ;
			}
			_zj.show();	
			_zj.append(s.data);
		});	
	}
	,show:function(){
					var ele = this.el;
					var obj = {};
					obj.title = $(ele).attr('data-title');
					obj.content = $(ele).attr('data-content');
					obj.price = $(ele).attr('data-price');
					obj.num_iid = $(ele).attr('data-num_iid');
					obj.picurl = $(ele).attr('data-picurl');
					
					this.data = obj;
					this.create();				
					
	},append:function(data){
		//添加分类,到当前窗体中供用户选择..
			var str = '';		
			for(var i =0;i<data.length;i++){
				if(data[i]['post'] ==1 ){
					str+='<li> <a class="add-album-list-item add-album-list-item-select" href="javascript:void(0);" > ';
         			str+=' <span class="text-overflow"><i>已加入</i>'+data[i].title+'</span> </a></li>';
				}else{
					str +='<li class="add-album-list-item-unselect"> ';
					str+='<a class="add-album-list-item " href="javascript:void(0);" title="'+data[i].title+'"> ';
					str+='<label class="text-overflow"> ';
					str+=' <input class="J_AlbumRadio" name="id" type="radio" value="'+data[i].id+'">'+data[i].title;
					str+=' </label> </a> </li>';
				}
			}
			$(".add-album-list").append(str);
			return str;
	},add_type:function(){
			//动态创建分类
			var val = $(".fluid-input-text").val();
			if(!val || val == ''){
				Dialog.info('要创建的分类标题不能为空');
				return ;
			}
			if(val.length>30){
				Dialog.info('分类标题长度不能超过30个字符');
				return ;
			}
			
			var title = encodeURIComponent( val );
			var url = '/index.php?m=zj&a=add_type';
			$.get(url,{'title':title},function(s){
				if(s.status == 'error'){
					Dialog.info(s.msg,s.status);
					return ;
				}
				_zj.append(s.data);
				$(".fluid-input-text").val('');
			});
	},post:function(){
			if(!this.data){
				Dialog.info('要添加的数据为空');
				return ;
			}
			var id = $('.J_AlbumRadio:checked').val();
			if(!id){
				Dialog.info('您必须选择一个专辑');
				return ;
			}
			this.id = id;
			var url = '/index.php?m=zj&a=post&id='+id;
			$.ajax({type:'POST',url:url,data:this.data,success:function(s){
				
				if(s.status == 'success'){
					_zj.success(s.msg);
				}else{
					Dialog.info(s.msg,s.status);
				}							
			},error:function(rs){
				L(rs);
				Dialog.info('发布失败');
			}});
	},
	create:function(){
			var str = '';
			str+='<div  class="ks-dialog ks-overlay g-modal zj_menu" style="display:none;"> ';
			str+='<a href="#" class="ks-dialog-close ks-overlay-close">';
			str+='<span class="ks-dialog-close-x ks-overlay-close-x">close</span> </a> ';
			str+='<div class="ks-dialog-content ks-overlay-content"> ';
			str+='<div class="ks-dialog-header ks-overlay-header">加入专辑</div> ';
			str+='<div class="ks-dialog-body ks-overlay-body">';
			str+='<div class="add-album-container">';
			
			
			str+='<div class="add-album-img"><img src="'+this.data.picurl+'_180x180.jpg"  /> </div>';
			str+='<div class="add-album-action"> <div class="xform create-album-form" > ';
			str+='<div class="form-group" style="margin:0;"> <div class="input-group"> ';
			str+='<div class="form-ipt"> <b class="fluid-input"> <b class="fluid-input-inner"> ';
			str+='<input class="fluid-input-text form-control" placeholder="创建新专辑（30字以内）" maxlength="30" /> ';
			str+='</b> </b> </div> <div class="form-btn-w"> ';
			str+='<button class="form-submit-btn form-btn add_zj_type">创建</button> ';
			str+='</div> </div> </div> </div> <div class="xform add-album-form"> ';
			str+='<div class="add-album-list-scroller"> <ul class="add-album-list" id="J_AddAlbumList"> ';
			str+='</ul> </div> <div class="form-group"> ';
			str+='<button class="form-submit-btn form-btn">确定</button> </div> </div> </div>';
			
			
			str+=' </div></div> </div> </div>';
			
			
			//$('.add-album-img img').attr('src',this.data.picurl+'_180x180.jpg');
			$('body').append(str);			
			
			$(".add_zj_type").click(function(){
				_zj.add_type();
				return false;						
			});
			
			$(".form-submit-btn").click(function(){
				_zj.post();					
				return false;
			});
			
			$(".ks-overlay-close").click(function(){
				//hideMenu('.zj_menu','menu');
				$('.zj_menu').remove();
				$('.zj_menu_cover').remove();
				return false;
			});
			
			showMenu({
				 'cover':1,
				 'duration':3,
				'mtype': 'menu',
				'menuid': '.zj_menu',
				'pos': '00!'
			});
			
			
	},success:function(msg){
			var text ='';
			text+='<div class="ks-dialog-body ks-overlay-body" >';
			text+='<div class="add-album-success"> ';
			text+='<h5> <i></i>'+msg+'</h5> ';
			text+='<p> <a href="/index.php?m=zj&id='+this.id+'" target="_blank" class="success_jump_url">去看看 &gt;</a>';
			text+='<span class="J_TimerClose"></span>';
			text+='秒后自动关闭 </p> </div></div> ';
			$(".add-album-container").html(text);
			var i = 3;
			var timer = setInterval(function(){
				if(i==0){
					$('.zj_menu').remove();
					$('.zj_menu_cover').remove();
					clearInterval(timer);
					timer = null;					
				}else{
					$(".J_TimerClose").text(i);
					i--;
				}				
			},1000);
	}
}
