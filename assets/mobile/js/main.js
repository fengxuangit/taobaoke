$(function(){
	var width = document.documentElement.clientWidth;
	if(width<360){
		$('.log').css({'margin-left':-80});
	}

	$("body").on('tap','._open',function(){
		var url = $(this).attr('href');
		if(url) {
			$(this).data('url',url);
			$(this).removeAttr('href');
		}
		url = $(this).data('url');
		open_url(url,true);
		return false;
	});
});

$(".close-btn-con").click(function(){
	$('.download-con').hide();
})

$F('_count');

$('.index2_menud li').click(function(){
	var text = $(this).text();
	_count.add(1,text);
})


$('.i2_cagdd li').click(function(){
	var text = $(this).text();
	_count.add(100,text);
})



$('.item_list a').click(function(){
	if($(this).hasClass('juan_btn')){
		_count.add(22,0);
	}else{
		_count.add(7,0);
	}
})


$('.index2_menud li').click(function(){
	_count.add(24,0);
})
$('.log').click(function(){
	_count.add(12,0);
})

$('.banner li').click(function(){
	_count.add(10,1);
})

$('.i2_botd li').click(function(){
	var text = $(this).text();
	_count.add(101,text);
})