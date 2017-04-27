

/*
var cfg = {box:'',obj:'',className:'',type:'',text:'',target:'',parent:'',parame:'',a:'like'};
new _add_like(cfg);

*/

function _add_like2(config){

			this.type ='';			//喜欢的模型  goods,zj_goods,style,zj,say
			this.className='';   //待加的class
			this.like_list=[];	 //已添加的列表
			this.obj=null;		//喜欢的参数信息,都是在这个元素上面,就是当前点击的节点
			this.parent=null;	//有此参数,说明元素是动态添加的,则是需要用on方式绑定事件,也就是this.box的父结点
			this.box='';		//当前元素的父节点


			this.url = '';		//ajax请求地址
			this.id='';			//当前el的id
			this.check=true;	//是否检查本地有没喜欢过

			this.target='';		   //目标元素添加class,留空则是当前点击的元素
			this.parame = '';
			this._box = null;	//当前分组的parent,就是当前点击对象的parent(this.box)

			this.a = 'like';	//代表当前执行的哪个方法 like || favorite
			this.callback = null;
			this.haslike = null;
			this.init =function(){
				var _this = this;
				this.name = this.type +'_'+this.a;
				if(!this.name) this.name = this.type;
				if(C(this.name)){
					this.like_list = C(this.name).split('|');
				}else{
					this.like_list = [];
				}
				this.hask_like();
				if(this.parent){
					$(this.parent).on('click', this.obj,function(){
						_this.target = this;
						click(this);
						return false;
					});
				}else{
					var box = 	this.box? this.box :'';
					$(box + ' '+ this.obj).click(function(){
						if(!_this.target)_this.target = this;
						click(this);
						return false;
					});
				}
				function click(obj){
							_this.obj = obj;
							var id   = $(obj).attr('data-id');
							if(in_array(id,_this.like_list)) return ;

							var url ='';
							if(_this.url){
									url = _this.url;
							}else{
								if (_this.a == 'auto' || !_this.a) _this.a = $(obj).attr('data-type');
								var url = get_url(obj);
								url = '/index.php?a=' + _this.a + '&m=' + _this.type + '&id=' + id;
							}
							url+=_this.parame;
							_this.id = id;
							_this.add_like(url);
							return false;
				}

			};

			this.add_like=function(url){
				var _this = this;

					var liked = $(_this.obj).attr('like');
					ajaxget(url,function(s){
						Dialog.info(s.msg,s.status);
						if(s.status == 'error') {
							_this.run_callback(s);
							return ;
						}
						var pp = _this.box ? $(_this.obj).parents(_this.box) :$(_this.obj);
						_this._box = pp;
						var num =  '';

						num = ~~(s.data);

							if(_this.text)pp.find(_this.text).text(num);
							if(_this.className) $(_this.target).addClass(_this.className);
							if(in_array(_this.id,_this.like_list)) return ;
							_this.like_list.push(_this.id);
						_this.run_callback(s);
					});
			};
			this.hask_like=function(){
				var _this = this;
					$(this.box).find(_this.obj).each(function(i) {

						var pp = _this.box ? $(this).parents(_this.box) :$(this);
						 var id = $(this).attr('data-id');

						if (id && in_array(id, _this.like_list)) {
							if(typeof _this['haslike'] == 'function') _this.haslike.call(_this,this);
						}

					});
			};
			this.run_callback = function(s){
				if(typeof this['callback'] == 'function'){
					var cback = this['callback'];
					cback(s,this.target);
				}
			}
		for(var i in config){
			this[i] = config[i];
		}
		this.init();
		return this;
}

