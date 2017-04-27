{include file="./home_header.php"}
<ul class="cl">
  <form method="post">
    <li class="uc_zlli2"><span>提示:您必须输入原密码,然后输入两次新密码,才能进行修改</span></li>
    <li class="uc_zlli1">
      <label>原密码：</label>
      <input class="uinfo uc_zlli1text text check_text" name="password1" type="text" value="" data-msg="原密码不能为空">
    </li>
    <li class="uc_zlli1">
      <label>新  密  码：</label>
      <input class="uinfo uc_zlli1text text check_text" name="password2" type="text" value=""  data-msg="新密码不能为空">
    </li>
    </li>
    <li class="uc_zlli1">
      <label>确认新密码：</label>
      <input class="uinfo uc_zlli1text text check_text" name="password3"  type="text" value=""  data-msg="确认新密码不能为空">
      <h2></h2>
    </li>
    <li class="uc_zlli4">
      <label></label>
      <input type="submit" class="seting_onsubmit u_submit check_form"   name="onsubmit"value=" 保 存" />
    </li>
    <input type="hidden" name="m" value="{$CURMODULE}" />
    <input type="hidden" name="a" value="{$CURACTION}" />
  </form>
</ul>
{include file="./home_footer.php"}