/*
	@superMan
	@2015.10.16 21:57 

*/


function _tb_search(input){
	if($(input).length==0) return ;
	var list_name = 'search_list_box';
	
	var name = 'search_result_'+$('.'+list_name).length;
	this.box =$('<div class="'+list_name+' '+name+'"></div>').appendTo('body');
	this.is_show  = false;
	this.input = $(input);	
	this.input.attr('autocomplete','off');
	this.kw = '';
	var _this = this;
	
	var rs  = fetchOffset(this.input[0]);
	this.box.css({'left':rs.left,top:rs.top+this.input.outerHeight(),position:'absolute',zIndex:'99999'}).width(this.input.outerWidth());
	this.input.keyup(function(){
			if(_this.is_show && event.keyCode == 38 || event.keyCode == 40) return false;
			return _this.search_start();
	});				
	this.input.click(function(e){
			_this.clear_all();
			_this.is_show = true;
			return _this.search_start();
	});	
	
	this.box.on('hover','a',function(){
		_this.box.find('a').removeClass('on');
		$(this).addClass('on');
	});
	
	
	this.box.on('click','a',function(){
		return _this.submit();
		
		is_show = false;
		var con = $(this).text();	
		_this.input.val(con);		
		_this.input.closest('form').get(0).submit();	
	});
	
	$("body").click(function(){
		_this.clear();
	});
	
	this.clear = function (){
		is_show = false;
		_this.box.html('');
	}
	
	this.clear_all = function(){
		$('.'+list_name).html('');
	}
	
	this.search_start = function(){
			_this.kw = _this.input.val();
			if(_this.kw =='') {
				_this.clear();
				return true;
			}

			var kw = encodeURIComponent(_this.kw);
			var len = _this.kw.length;
			var area = 'c2c';	//普通商品
			///if(val.length==1)area = 'ssrch'; //店铺							
			var url = 'https://suggest.taobao.com/sug?code=utf-8&q='+kw+'&area='+area+'&k=1';
			$.ajax({type:'GET',url:url,dataType:'jsonp',data:'',success:function(s){
				if(s.result.length == 0) return false;
				var html = '';
				var index = 0;
				for(var i =0;i<s.result.length;i++){
					if(s.result[i][0].indexOf(' ') == -1){
						html+='<a href="#" data-index="'+index+'">'+s.result[i][0]+'</a>';
						index++;
					}
				}
				_this.box.html(html);
			}});						
			return false;
	}
	
	
	this.input.keydown(function(event){
			if(event.keyCode ==13 ){	//回车
						return _this.submit();
			}else if(event.keyCode == 38){	//上
					return _this.select('up');

			}else if(event.keyCode ==40){ //下
				return _this.select('down');
			}
	});
	
	this.submit = function (){
						var on = _this.box.find('a.on');
						var con = on.text();
						if(on.length>0 && con != ''){
							_this.clear();
							_this.input.val(con);	
							_this.input.closest('form').get(0).submit();	
						}else if($(this).val() != ''){
							_this.input.closest('form').get(0).submit();	
						}						
						_this.is_show = true;
						return false;
	}
	this.select = function(type){
				var a = _this.box.find('a');
				if(a.length > 0){
					var on =  _this.box.find('a.on');
					
					if(type == 'up'){
							if(on.length>0){
								var index = parseInt(on.attr('data-index'))-1;
							}else{
								var index = a.length-1;
							}
					}else{
						if(on.length>0){
							var index = parseInt(on.attr('data-index'))+1;
							if(index>a.length-1) index = 0;
						}else{
							var index =0;
						}	
					}
					
					var con = a.removeClass('on').removeClass('on').eq(index).addClass('on').text();
					_this.input.val(con);							
				}
				is_show = true;
				return false;
	}
	return this;	
}
