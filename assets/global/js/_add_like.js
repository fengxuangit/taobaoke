

/*
var cfg = {box:'',obj:'',className:'',type:'',text:'',target:'',success_text:'',error_text:'',parent:'',parame:'',name:'',a:'like'};
new _add_like(cfg);

*/

function _add_like(config){

			this.error_text='';		//没喜欢的内容
			this.success_text='';  //成功后显示的内容

			this.type ='';			//喜欢的类型  goods,zj_goods,style,zj,say
			this.className='';   //待加的class
			this.like_list=[];	 //已添加的列表
			this.obj=null;		//喜欢的参数信息,都是在这个元素上面,就是当前点击的节点
			this.parent=null;	//有此参数,说明元素是动态添加的,则是需要用on方式绑定事件,也就是this.box的父结点
			this.box='';		//当前元素的父节点
			this.text='';		//要显示数字的节点

			this.url = '';		//ajax请求地址
			this.id='';			//当前el的id
			this.check=false;	//是否检查本地有没喜欢过
			this.target='';		   //目标元素添加class,留空则是当前点击的元素
			this.parame = '';
			this._box = null;	//当前分组的parent,就是当前点击对象的parent(this.box)
			this.name = '';		//cookie name	为空则取this.type
			this.a = 'like';	//代表当前执行的哪个方法 like || favorite
			this.callback = null;
			this.init =function(){
				var _this = this;
				//var cname = this.name ? this.name : this.type;
				if(!this.name) this.name = this.type;
				if(_load(this.name)){
					this.like_list = _load(this.name).split(',');
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
							if(!is_login()) return false;
							_this.obj = obj;
							var id   = $(obj).attr('data-id');

							var url ='';
							if(_this.url){
									url = _this.url;
							}else{
								if (_this.a == 'auto' || !_this.a) _this.a = $(obj).attr('data-type');
								var url = get_url(obj);
								url = '/index.php?m=ajax&a=' + _this.a + '&type=' + _this.type + '&id=' + id;
								if (_this.type.indexOf('_goods') != -1) {
									var num_iid = $(obj).attr('data-num_iid');
									url += '&num_iid=' + num_iid;
									id = num_iid;
								}
							}
							url+=_this.parame;
							_this.id = id;
							_this.add_like(url);
							return false;
				}

			};
			this.add_like=function(url){
				var _this = this;

					if(_this.check  && $(_this.obj).attr('like') ==1 && in_array(_this.id,_this.like_list)){
						//已喜欢,直接取消
						var pp = _this.box ? $(_this.obj).parents(_this.box) :$(_this.obj);
						_this.like_list = del_array(_this.id,_this.like_list);
						var num = _this.error_text ? _this.error_text : '';
						if(_this.error_text ==1 ){
							num = parseInt(pp.find(_this.text).text().trim());
						}
						$(_this.obj).attr('like',0);

						pp.find(_this.text).text(num);
						$(_this.target).removeClass(_this.className);
						_save(_this.name,_this.like_list.join(','));
						Dialog.info('取消成功','success');
						return ;
					}
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


						if(s.data == 0 || s.data !=''){
							num = parseInt(s.data);
						}else if(_this.error_text ==1){

							num = parseInt(pp.find(_this.text).text().trim());
						}

						if(in_array(_this.id,_this.like_list) || (s.msg && s.msg.indexOf('取消') != -1)){
							//取消
							_this.like_list = del_array(_this.id,_this.like_list);

							if(_this.error_text && _this.success_text !=1){
								num = _this.error_text;
							}
							$(_this.obj).attr('like',0);

							if(_this.text)pp.find(_this.text).text(num);
							if(_this.className)$(_this.target).removeClass(_this.className);

						}else{
							//增加

							if(_this.success_text && _this.success_text !=1){
								num = _this.success_text;
							}

							if(_this.text)pp.find(_this.text).text(num);
							if(_this.className) $(_this.target).addClass(_this.className);
							$(_this.obj).attr('like',1);
							if(in_array(_this.id,_this.like_list)) return ;

							_this.like_list.push(_this.id);
						}
						_this.run_callback(s);
						var tmp_list = '';
						for(var i =0;i<_this.like_list.length;i++){
							if(_this.like_list[i] ){
								tmp_list+=_this.like_list[i]+',';
							}
						}
						tmp_list= tmp_list.replace(/,$/,'');
						_save(_this.name,tmp_list);

					});
			};
			this.hask_like=function(){
				var _this = this;

					$(this.box).find(_this.obj).each(function(i) {
						//注意,parent和box不要弄反,不然会导至所有元素都给加了success_text
						var pp = _this.box ? $(this).parents(_this.box) :$(this);

						if(_this.type == 'zj_goods'){
							 var id = $(this).attr('data-num_iid');
						}else{
							 var id = $(this).attr('data-id');
						}

						if (id && in_array(id, _this.like_list)) {
							var st = in_array(id, _this.like_list) ? '是':'否';

							var target = _this.target ? _this.target : this;
							if(_this.className)	$(target).addClass(_this.className);
							if(_this.text && _this.success_text && _this.success_text != 1){
								pp.find(_this.text).text(_this.success_text);
							}
							$(this).attr('like',1);
						}
					});
			}
			this.run_callback = function(s){
				if(typeof this['callback'] == 'function'){
					var cback = this['callback'];
					cback(s,this);
				}
			}
		for(var i in config){
			this[i] = config[i];
		}
		this.init();
		return this;
}

