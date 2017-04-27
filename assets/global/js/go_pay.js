
function get_et()
{
  var s = new Date(),
  l = +s / 1000 | 0,
  r = s.getTimezoneOffset() * 60,
  p = l + r,
  m = p + (3600 * 8),
  q = m.toString().substr(2, 8).split(""),
  o = [6, 3, 7, 1, 5, 2, 0, 4],
  n = [];
  for (var k = 0; k < o.length; k++) {
	  n.push(q[o[k]])
  }
  n[2] = 9 - n[2];
  n[4] = 9 - n[4];
  n[5] = 9 - n[5];
  return n.join("")
}

function setCookie(j, k)
{
    document.cookie = j + "=" + encodeURIComponent(k.toString()) + "; path=/"
}

function getCookie(l)
{
	var m = (" " + document.cookie).split(";"),
	j = "";
	for (var k = 0; k < m.length; k++) {
		if (m[k].indexOf(" " + l + "=") === 0) {
			j = decodeURIComponent(m[k].split("=")[1].toString());
			break
		}
	}
	return j
}

function get_pgid()
{
  var l = "",
  k = "",
  n,
  o,
  t,
  u,
  s = location,
  m = "",
  q = Math;
  function r(x, z) {
	  var y = "",
	  v = 1,
	  w;
	  v = Math.floor(x.length / z);
	  if (v == 1) {
		  y = x.substr(0, z)
	  } else {
		  for (w = 0; w < z; w++) {
			  y += x.substr(w * v, 1)
		  }
	  }
	  return y
  }
  
 n = (" " + document.cookie).split(";");
  for (o = 0; o < n.length; o++) {
	  if (n[o].indexOf(" cna=") === 0) {
		  k = n[o].substr(5, 24);
		  break
	  }
  }
  
  if (k === "") {
	  cu = (s.search.length > 9) ? s.search: ((s.pathname.length > 9) ? s.pathname: s.href).substr(1);
	  n = document.cookie.split(";");
	  for (o = 0; o < n.length; o++) {
		  if (n[o].split("=").length > 1) {
			  m += n[o].split("=")[1]
		  }
	  }
	  if (m.length < 16) {
		  m += "abcdef0123456789"
	  }
	  k = r(cu, 8) + r(m, 16)
  }
  for (o = 1; o <= 32; o++) {
	  t = q.floor(q.random() * 16);
	  if (k && o <= k.length) {
		  u = k.charCodeAt(o - 1);
		  t = (t + u) % 16
	  }
	  l += t.toString(16)
  }
  setCookie('amvid', l);
  var p = getCookie('amvid');
  if (p) {
	  return p
  }
  return l
}



$(function(){
		var btn = $(".go_pay").eq(0);
		var num_iid = btn.attr('data-tao_num_iid');

		var ua = navigator.userAgent.toLowerCase();
		if(ua.indexOf('micromessenger') != -1){
			var jumpurl = encodeURIComponent('/index.php?itemid='+num_iid);
			location.href = 'assets/common/jump.html?jumpurl='+jumpurl;
			//location.href = '/index.php?itemid='+num_iid+"&focus=1";
			return ;
		}

				
				var org_url = btn.attr('href');
				var click_url = 'http://item.taobao.com/item.htm?id='+num_iid;
				var pid = btn.attr('data-tao_pid');
				var wt = '0';
				var ti = '625';
				var tl = '230x45';
				var rd = '1';
				var ct = encodeURIComponent('itemid='+num_iid);
				var st = '2';
				var url = btn.attr('data-weburl') ? btn.attr('data-weburl') :document.URL;
				var rf = encodeURIComponent(url);
				var et = get_et();
				var pgid = get_pgid();
				var v = '2.0';
				var data = 'pid='+pid+'&wt='+wt+'&ti='+ti+'&tl='+tl+'&rd='+rd+'&ct='+ct+'&st='+st+'&rf='+rf+'&et='+et+'&pgid='+pgid+'&v='+v;
				
				$(function(){
					$.ajax({
						url: 'http://g.click.taobao.com/display?cb=?',
						type: 'GET',    
						dataType: 'jsonp',
						jsonp: 'cb', 
						data: 'pid='+pid+'&wt='+wt+'&ti='+ti+'&tl='+tl+'&rd='+rd+'&ct='+ct+'&st='+st+'&rf='+rf+'&et='+et+'&pgid='+pgid+'&v='+v,
						success: function(msg) {
						//$('body').append('<iframe src="'+url+'"  frameborder="0" id="fr" name="fr" width="100%" height="100%" onLoad="iFrameHeight();"></iframe>');
							
							if(msg.code == 200 || msg.code == 201){
								if(window.location.href.indexOf('shop')   ==-1  ){
										var url = msg.data.items[0].ds_item_click;
								}else{
										var url = msg.data.items[0].ds_shop_click;
								}
								document.location.href = url;
								/*try{
									document.location.href	= '/index.php?a=aitaobao&url='+encodeURIComponent(url);		
								}catch(e){
									document.location.href = url;
								}*/
							}
							else{
								document.location.href = org_url;
							}
						},    
						error: function(msg){    
							document.location.href = org_url;
						}    
					});  
				});
	
	
})