{include file="../../$TPLNAME/header.php"}

<div class="wp cl firend_link_postbox">

<div class="cl friend_box ff">
<h1>填写您的留言反馈内容</h1>
<form action="{$URL}m=message&a=post"  method="post" id="rss_task">
<p>
<span>您的姓名:</span><input id="to" name="name" class="rsstxt"  value="" type="text">
</p>
<p>
<span>留言内容<em class="red">(*)</em></span><input id="to" name="content" class="rsstxt"  value="" type="text" data-type="null" data-msg="留言内容不能为空" >
</p>
<p>
<span>联系方式<em class="red">(*)</em></span><input id="to" name="contact" class="rsstxt"  value="" type="text"  >
</p>

<p>
<span>您的网址:</span><input id="to" name="url" class="rsstxt"  value="" type="text"  >
</p>

<p>
<span>验证码:</span>
  <input type="text" class="text" name="yzm" style="width:140px;margin-right:10px;float:left;height: 34px;font-size: 16px;"  placeholder="请输入验证码" data-type="yzm">
 <img   height="40" src="{$URL}m=ajax&a=yzm" class="yzm_img yzm">
 <a class="yzm" href="#" >刷新</a>
</p>


<br>
<input type="hidden" name="type" value="feedback">
<input value="提交" type="submit" class="submit_btn _check_form" name="onsubmit">
</form>
</div>
</div>

{include file="../../$TPLNAME/footer.php"}


