




function ymonusecag(){
  var cagam=$(".cagam");
  if(cagam.length==0)return false;
  var i2_cagd=$(".i2_cagd");
  var itar=0;
  cagam[0].onclick=function(){
	  if(itar==0){
	  cagam.addClass('currr');
	  i2_cagd[0].style.display='block';
		  itar=1;
	  }else{
		  cagam.removeClass('currr');
		  i2_cagd[0].style.display='none';
		  itar=0;
	  }
  }
}
ymonusecag();

(function(a) {
  a.fn.carousel = function(g) {
	  var h = a.extend({
						  auto: true
					  },
					  g),
			  d = this,
			  o = d.find(".carousel-inner"),
			  k = d.find(".carousel-indicators"),
			  j = null,
			  b = o.find(".item"),
			  c = b.outerWidth(true),
			  s = b.length,
			  m = 0,
			  r = swipe = false,
			  f = null,
			  e = null,
			  u = "ontouchstart" in window,
			  i = {
				  start: u ? "touchstart": "mousedown",
				  move: u ? "touchmove": "mousemove",
				  end: u ? "touchend": "mouseup"
			  },
			  t = {
				  start: {
					  x: 0,
					  y: 0
				  },
				  obj: {
					  x: 0,
					  y: 0
				  },
				  end: {
					  x: 0,
					  y: 0
				  }
			  };
	  p();
	  o.get(0).addEventListener(i.start,
			  function(w) {
				  e = new Date();
				  clearInterval(f);
				  if (r) {
					  return;
				  }
				  swipe = false;
				  var n = y = 0;
				  r = true;
				  o.addClass("moving");
				  if (w.touches && w.touches.length) {
					  n = w.touches[0].pageX;
					  y = w.touches[0].pageY;
				  } else {
					  n = w.pageX;
					  y = w.pageY;
				  }
				  o.removeClass("flow");
				  t.start = {
					  x: n,
					  y: y
				  };
				  document.addEventListener(i.move, l, false);
			  },
			  false);
	  o.bind("click",
			  function(n) {
				  swipe && n.preventDefault();
			  });
	  document.addEventListener(i.end,
			  function(A) {
				  if (!r) {
					  return;
				  }
				  var z = t.obj.x,
						  n = z % c,
						  x = -Math.floor(z / c),
						  w = new Date();
				  if (w - e > 300) {
					  swipe = true;
				  }
				  o.removeClass("moving");
				  o.addClass("flow");
				  if (n) {
					  if (Math.abs(n) < c / 2) {
						  x--;
					  }
				  }
				  t.end.x = v(x);
				  document.removeEventListener(i.move, l, false);
				  r = false;
				  if (h.auto) {
					  f = setInterval(q, 3000);
				  }
			  },
			  false);
	  function l(A) {
		  A.preventDefault();
		  var n = y = 0;
		  if (A.touches && A.touches.length) {
			  n = A.touches[0].pageX;
			  y = A.touches[0].pageY;
		  } else {
			  n = A.pageX;
			  y = A.pageY;
		  }
		  var z = n - t.start.x,
				  w = y - t.start.y;
		  t.obj.x = t.end.x + z;
		  o.css("webkitTransform", "translate(" + t.obj.x + "px,0)");
	  }
	  function v(w) {
		  if (w >= s) {
			  var n = w % s,
					  A = -n * c;
			  setTimeout(function() {
						  var B = o.hasClass("flow");
						  B && o.removeClass("flow");
						  t.obj.x = v(n);
						  B || o.removeClass("flow");
					  },
					  300);
		  }
		  m = w >= s ? s: w < 0 ? 0 : w;
		  var x = -m * c,
				  z = j.eq(m);
		  z.hasClass("active") || z.addClass("active").siblings().removeClass("active");
		  o.css("webkitTransform", "translate(" + x + "px,0)");
		  t.end.x = x;
		  return x;
	  }
	  function q() {
		  o.hasClass("flow") || o.addClass("flow");
		  v(++m);
	  }
	  function p() {
		  var n = "";
		  b.clone().appendTo(o);
		  o.width(c * s * 2);
		  for (var w = 0; w < s; w++) {
			  n += "<li></li>";
		  }
		  k.html(n);
		  j = k.find("li");
		  j.eq(0).addClass("active");
		  if (h.auto) {
			  f = setInterval(q, 3000);
		  }
	  }
  };
  a(document).ready(function() {
	  var c = a(".carousel"),
			  b = c.find("img").eq(0);
	  if (b[0] && b[0].complete) {
		  c.carousel();
	  } else {
		  b.bind("load",
				  function() {
					  c.carousel();
				  });
	  }
  });
})(Zepto);



    var _page = 1; 
	var _url = location.href;
	var _in_run = false;
	/*$(".mobile_get").click(function(){
		var url = $(this).attr('href');
		jsonajax(url);
		return false;
	});	
	$(".index2_menud a").click(function(){
		$(".index2_menud li").removeClass('curr');
		$(this).parent('li').addClass('curr');
		jsonajax($(this).attr('href'));
		return false;
	});	
	$(".i2_menu2d a").click(function(){
		$(".i2_menu2d li").removeClass('curr');
		$(this).parent('li').addClass('curr');
		return false;
	});*/
    function jsonajax(url){
		if(_in_run) return false;
		_in_run   = true;
		var add = false;
		
		if(_url == url) {
			add=true;
			_page++;
		}else if(url.indexOf('page') != -1){
			if(url.indexOf('.html') != -1) {
				_page = parseInt(sub_str(url,'-page-','.html'));
			}else{
				_page = parseInt(sub_str(url,'&page=',-1));
			}
			_page++;
			add=true;			
		}else{
			_page=1;			
		}
		_url = url;
		
		$(".next_page").attr('href',url);
		if(url.indexOf('.html') == -1 && url.indexOf('.php') == -1){
			url +='/';
		}
		if(url.indexOf('.html') != -1){
			url = url.replace(/inajax\-1/i,'');
			url = url.replace(/page\-(\d{0,3})/,'');			
			var str = '-page-'+_page+"-inajax-1.html";
			url = url.replace(/\.html/i,str);
		}else{
			url = url.replace(/&inajax=1/i,'');
			url = url.replace(/page\-(\d{0,3})/,'');
			var sp = url.indexOf('?') == -1 ? '?':'&';
			url+= sp+"-page="+_page+"&inajax=1";
		}
		url = url.replace(/\-\-/i,'-');
        	     $.ajax({
					 url:url,
                	  type:'GET',
                	  dataType:'json',
                	  success:function(rs){
						 _in_run = false;
						 
						  if(rs.status =='error'){
							L(rs);							
							alert(rs.msg);
							return false;  
						  }						 
						  if(rs.data.length == 0) {
							if(!add)_page--;
							alert('已加载完全部商品');
							return false;  
						  }
							var str = '';							
							var timestamp = (new Date()).valueOf();
							timestamp = parseInt(timestamp/1000);
							var news = rs.data;
							var html ='';
							for(var i=0,l=news.length;i<l;i++){
								if(add) html="";
								if(news[i].status!=1){
									str = " <b class='b2'>"+news[i].status_text+"</b>";
								}else{
									str = " <b class='b1'>已售"+news[i].sum+"</b>";
								}
								html+="<div  class='item_list'><a class='imgd' href='"+news[i].url+"'><img width='140'  src='"+news[i].picurl+"_250x250.jpg'/>";
								if(news[i].new == 1)html+="<i class='mb_ico goodsdpi gisnew"+news[i].new+"'></i>";
								html+="<span class='goodsisover'"+news[i].state+"'></span></a><h2><span>";
								html+="<a href='"+news[i].url+"'>"+news[i].title+"</a></span></h2><aside>";


if(news[i].juan_url){
	html+='<a href="'+news[i].juan_url+'"  rel="nofollow" target="_blank" class="y juan_btn">领';
	if(news[i].juan_price)html+= news[i].juan_price+'元'
	html+='优惠券</a>'
}

								html+="￥<span>"+news[i].yh_price+"</span></aside><p><del>￥"+news[i].price+"</del>";
								html+="<cite>"+news[i].zk+"折</cite>";
								html+= str+"</p></div>";
								if(add)$("#stage").append(html);
							}							
							if(!add) $("#stage").html(html);
							 
					},error:function(){
						  _in_run = false;
					}
        	     });
    	 }
		 

function append_data(rs){
			var str = '';							
			var timestamp = (new Date()).valueOf();
			timestamp = parseInt(timestamp/1000);
			var news = rs.data;
			var html ='';
			for(var i=0,l=news.length;i<l;i++){
				if(add) html="";
				if(news[i].status!=1){
					str = " <b class='b2'>"+news[i].status_text+"</b>";
				}else{
					str = " <b class='b1'>已售"+news[i].sum+"</b>";
				}
				html+="<div  class='item_list'><a class='imgd' href='"+news[i].url+"'><img width='140'  src='"+news[i].picurl+"_150x150.jpg'/>";
				if(news[i].new == 1)html+="<i class='mb_ico goodsdpi gisnew"+news[i].new+"'></i>";
				html+="<span class='goodsisover'"+news[i].state+"'></span></a><h2><span>";
				html+="<a href='"+news[i].url+"'>"+news[i].title+"</a></span></h2><aside>￥";
				html+="<span>"+news[i].yh_price+"</span></aside><p><del>￥"+news[i].price+"</del>";
				html+="<cite>"+news[i].zk+"折</cite>";
				html+= str+"</p></div>";
				if(add)$("#stage").append(html);
			}							
			if(!add) $("#stage").html(html);
}
