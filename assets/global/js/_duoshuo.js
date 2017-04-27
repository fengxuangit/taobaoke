
var _duoshuo = {
		key:'',
		is_init:false,
		init:function(){
			if(this.is_init) return ;
			this.key = DUOSHUO_KEY;
			this.is_init  = true;
		},getcount:function(thread_key,call){
			this.init();
			
			if(!thread_key) thread_key = $("._duoshuo").attr('data-thread-key');
			if(!thread_key) {			
				throw "thread key 没有找到";
				return ;
			}
			var url = 'http://api.duoshuo.com/threads/counts.jsonp?short_name='+this.key+'&threads='+thread_key;
			$.ajax({type:'GET',url:url,data:'',dataType:'jsonp',success:function(s){
				if(s.code !=0) {
					throw ('获取评论信息失败:'+s.errorMessage);
					return ;
				}
				var data = s.response[thread_key];			
				var rs= {comment:data.comments,like:data.likes,share:data.reposts,key:data.thread_key,id:data.thread_id};
				if(typeof call == 'function') call.call(s,rs,this);
			}});
		},get_user:function(call){
			if(typeof DUOSHUO =='undefined' || typeof DUOSHUO['visitor']['data'] == 'undefined'){
				var _this = this;
				setTimeout(function(){
					_this.get_user();
				},200);
			}else{
				this.init();
				if(typeof call == 'function') call.call(this,DUOSHUO.visitor.data);
			}			
		}
}

