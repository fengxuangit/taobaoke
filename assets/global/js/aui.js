
var aui = {
	id:'',
	layer:true,
	remove:function(){
		if(this.id)$('#'+this.id).remove();
		this.remove_layer();
	},
	hide:function(){
		this.remove();
	},confirm:function(title,content,ok,cancel){
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
		if(!this.layer) return ;

		var height = Math.max(document.body.scrollHeight,document.documentElement.scrollHeight);
		$('<div class="layer_bg"></div>').appendTo('body').css({height:height});
	},remove_layer:function(){
		if(!this.layer) return ;
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