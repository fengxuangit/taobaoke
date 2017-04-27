{include file="../../$TPLNAME/header.php"}
<div class="cl rss_box ff">
<h1>填写您的Email,进行订阅最新商品信息</h1>
<form action="http://list.qq.com/cgi-bin/qf_compose_send"  method="post" id="rss_task">
<input name="t" value="qf_booked_feedback" type="hidden">
<input name="id" value="{$id}" type="hidden">
<input id="to" name="to" class="rsstxt"  value="{$email}" type="text">
<input value="提交" type="submit" class="submit_btn">
</form>
</div>
<script type="text/javascript">
$(function(){
	
	$(".submit_btn").click(function(){
		var rs = check_email();
		if(rs === true) return true;
		Dialog.info(rs,'error');
	});

	if( check_email() === true) document.getElementById("rss_task").submit();
	
	function check_email(){
		var em = $(".rsstxt").val();
		if(em) return  _check.is_email(em);
		return 'Email 不能为空';
	}
	
 })
</script>
{include file="../../$TPLNAME/footer.php"}