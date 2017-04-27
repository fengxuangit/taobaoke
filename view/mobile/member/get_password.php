 {include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/member.css" media="all" />
<div class="forgetpwd-wrap">
  <div class="forgetpwd-form"> 
  {if $step ==1}
<div class="hpz_returntop" style=""><span>忘记密码</span></div>
  <div class="logindd">
    <div class="logind">
        <ul>
          <form action="" method="post">
                <input type="hidden" name="type" value="yz">
            <li><input class="loginname" type="text" value="" name="username" placeholder="用户名"></li>
            <li><input class="loginname" type="text " value="" placeholder="注册邮箱" name="email"> 
            
            </li>
            <li>
            </li><li><input style="margin-top: 20px;" type="submit" value="获取验证码" class="loginbtn1" name="onsubmit"></li>
             <input type="hidden" name="m" value="{$CURMODULE}" />
     		 <input type="hidden" name="a" value="{$CURACTION}" />
            </form>
        </ul>
    </div>
</div>

    
    {elseif $step==2}
 <div class="hpz_returntop" style=""><span>登录邮箱验证</span></div>

    <div class="find-password step2">
      <dl>

        <dd style="height: auto">
          <div style="text-align:center;color: #666; font-size: 18px; line-height: 1.5;padding-bottom: 10px;overflow-y: auto;"> 
          我们已经向您的邮箱(<b class="email_value">{$email}</b>)发送了一封验证身份的邮件，请登录邮件，点击邮件中的链接修改密码！ </div>
        </dd>

      </dl>
    </div>
    {elseif $step==3}
<div class="hpz_returntop"><span>确认修改密码</span></div>
<div class="logindd">
    <div class="logind">
          <form action="{$URL}m=member&a=login" method="post" id="formg">
         <input type="hidden" name="new_password" value="1" />
           <input type="hidden" name="onsubmit" value="1" />
           <input type="hidden" name="m" value="{$CURMODULE}" />
            <input type="hidden" name="a" value="{$CURACTION}" />
            <ul>
                <li>
                    <input class="loginname" style="margin-top: 5px" value="" name="password1" type="text" placeholder="新密码">
                </li>
                <li><input class="loginname" style="margin-top: 15px;" value="" type="password2" name="password" placeholder="确认新密码"></li>
                <li>&nbsp;</li>
                <li><a type="submit" class="loginbtn1 external" href="javascript:void(0)" onclick="document.getElementById('formg').submit()">确认修改</a></li>
            </ul>
        </form>
    </div>
</div>
    
    {/if} 
    
    </div>
</div>
{include file="../footer.php"} 