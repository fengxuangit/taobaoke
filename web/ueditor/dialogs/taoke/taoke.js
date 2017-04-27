(function () {

    var editor = null;
	
    UM.registerWidget('taoke', {
        tpl: "<link type=\"text/css\" rel=\"stylesheet\" href=\"<%=taoke_url%>taoke.css\">" +
            "<div class=\"edui-taoke-wrapper\">" +
            "<div class=\"edui-tab-findbox\"></div>" +
            "<div class=\"edui-tab-content\"></div>" +
			 "<div class=\"edui-modal-footer\"></div>" +
            "</div>",
        initContent: function (_editor, $widget) {

            var me = this,
                taokeUrl = UMEDITOR_CONFIG.UMEDITOR_HOME_URL + 'dialogs/taoke/',
                options = $.extend({}, { 'taoke_url': taokeUrl }),
                $root = me.root();

            if (me.inited) {
				
                me.preventDefault();
                return;
            }
            me.inited = true;
            editor = _editor;
            me.$widget = $widget;
            $root.html($.parseTmpl(me.tpl, options));

			//加载搜索的表单
			$root.find('.edui-tab-findbox').append(this.insert_find_box())		
			
			//获取按钮点击
			$root.find('.edui-tab-findbox .find_button').click(function(){
				var iid = $('.edui-tab-findbox .find_input').val();
				if(!iid){
					Dialog.info('请输入淘宝或天猫商品链接或商品id');
				}else{
					
					me.cover_result = '';
					$root.find('.edui-tab-content').html('');
					
					tdj.get_goods(iid,function(s){
					
						if(s.status == 'error'){
							Dialog.info(s.msg);
							return ;
						}
						var value = encodeURIComponent(s.title);						
						$.ajax({type:'POST',url:'/index.php?m=ajax&a=keywords',data:{title:value},success:function(s1){
						
							if(typeof s1 != 'object' || !s1 || s1.status!='success' || typeof s1.data !='string'){
								var s2 = [];
							}else{
								var s2 = s1.data.split(',');								
							}						
							var rs = me.cover_data(s,s2);	
							$root.find('.edui-tab-content').append(rs);
						},dataType:'json'});						
					});					
				}
                 return false;
			});
			
			
			
			
			//底部按钮初始化
			var footer = '<div class="edui-modal-tip"></div>'
				footer+=	'<div class="edui-btn edui-btn-primary" data-ok="modal">确认</div>';
				footer+=	'<div class="edui-btn edui-btn-hide" data-hide="modal">取消</div>';
			 	$root.find('.edui-modal-footer').append(footer);				
			$root.find('.edui-btn-hide').click(function(){
				 me.$widget.edui().hide();
                 return false;
			});
			$root.find('.edui-btn').hover(function(){
				$(this).addClass('edui-hover');
			},function(){
				$(this).removeClass('edui-hover');
			});
			
			//确定按钮
			$root.find('.edui-btn-primary').click(function(){				
				if(!me.cover_result) return ;
				var data = '<p>&nbsp;</p>'+me.cover_result+'<p>&nbsp;</p>';
				 editor.execCommand('insertHtml', data);
				 $root.find('.edui-tab-content').html('');
				 $root.find('.find_input').val('');
				 
				 me.$widget.edui().hide();
				 me.cover_index++;
				 me.cover_result = '';
                 return false;
			});
        },
		num_iid:'',
        initEvent: function () {
            var me = this;

            //防止点击过后关闭popup
            me.root().on('click', function (e) {
                return false;
            });
           
            //点击选中公式
            me.root().find('.edui-tab-pane').delegate('.edui-taoke-latex-item', 'click', function (evt) {
                var $item = $(this),
                    latex = $item.attr('data-latex') || '';
                if (latex) {
                    me.insertLatex(latex.replace("{/}", "\\"));
                }
                me.$widget.edui().hide();
                return false;
            });
        },
       
        autoHeight: function () {
            this.$widget.height(this.root() + 2);
        },
        insertLatex: function (latex) {
            editor.execCommand('taoke', latex );
        },
        width: 690,
        height: 320,
		insert_find_box:function(){
			var rs = '';
			rs+='<div class="find_box ff cl">';
			rs+='<input type="text" class="find_input" name="" id="" placeholder="请输入淘宝或天猫商品链接或商品id">';
			rs+='<input type="button" class="find_button" value="获取"></div>';
			return rs;
		},
		cover_index:0,
		cover_result:'',
		
		cover_data:function(obj,keyword_arr){
			var rs = '';
			var iid = obj.num_iid+'';
			var sid = obj.sid;
			var url = '/index.php?a=go_pay&num_iid='+obj.num_iid;
			rs+='<div class="item_box ff itembox_'+this.cover_index+'" data-num_iid="'+iid+'"><div class="item"><div class="item_pic">';
			rs+='<a class="item_url" href="'+url+'" data-num_iid="'+iid+'" isconvert="1" target="_blank" title="'+obj.title+'" rel="nofollow" >';
			rs+='<img src="'+obj.picurl+'_250x250.jpg"  alt="'+obj.title+'" /></a>';
			rs+='</div><div class="item_info"><div class="item_title">';
			rs+='<a class="item_url"  href="'+url+'" data-num_iid="'+iid+'" isconvert="1" target="_blank" ';
			rs+=' title="'+obj.title+'" rel="nofollow" >'+obj.title+'</a>';
			rs+='</div><div class="item_price cl">';
				rs+='<div class="price_new">折扣价:¥&nbsp;<strong>'+obj.yh_price+'</strong></div>';
				rs+='<div class="price_old">原价:¥&nbsp;<strong>'+obj.price+'</strong></div>';
				rs+='<div class="item_shop"><span>店铺:</span>';
				rs+='<a href="'+url+'&shop=1" isconvert="1" target="_blank" data-sellerid="'+sid+'" title="'+obj.nick+'" rel="nofollow" >'+obj.nick+'</a></div>';
			rs+='</div>';
			if(keyword_arr && keyword_arr.length>0){
					rs+='<div class="item_kw cl"><a class="item_kw_first">标签</a>';			
					for(var i =0;i<keyword_arr.length;i++){
						var img_url = '/index.php?m=img&a=list&tag='+ encodeURIComponent(keyword_arr[i]);
						rs+='<a href="'+img_url+'" target="_blank" title="'+keyword_arr[i]+'"  >'+keyword_arr[i]+'</a>';
					}
					rs+='</div>';
			}
			rs+='<div class="item_btn">';
			rs+='<a  class="item_url"  href="'+url+'" data-num_iid="'+iid+'" isconvert="1" target="_blank" rel="nofollow">去购买</a>';
			rs+='</div></div></div>';
			
			var pic = $("input[name='postdb[picurl]']").val();
			if(!pic)$("input[name='postdb[picurl]']").val(obj.picurl);
			
			if(keyword_arr){
				var kw = $("input[name='postdb[keywords]']").val();
				if(!kw)$("input[name='postdb[keywords]']").val(keyword_arr.join(','));
			}
			
			this.cover_result = rs;
			return rs;
		}
		
    });

})();

