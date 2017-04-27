{include file="../../common/header.php"}
<link rel="stylesheet" type="text/css" href="{$TPLDIR}/login/login.css" media="all" />


<a href="#" class="close_pic"></a>
<div class="login_box">
	<div class="logo"><a href="/">&nbsp;</a></div>
    <form enctype="multipart/form-data" action="" method="post"  name="login">
    <div class="login_form">
    	<div class="user">
        	<input class="text_value" value="" name="username" type="text" placeholder="用户名">
            <input class="text_value" value="" name="password" type="password"  placeholder="密码">
        </div>
        <input type="hidden" name="login" value="1" />
        <input type="submit" value="登录" name="login_submit"  class="button"/>
    </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
    </form>
    <div class="tip">{$message}</div>
    <div class="foot">
	Copyright &copy; 2014.Company <a href="http://www.hbkfz.cn" target="_blank" >湖北开发者网络科技有限公司</a> All rights reserved 
    </div>
</div>
{include file="../../common/footer.php"}