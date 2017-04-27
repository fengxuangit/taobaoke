{include file="./home_header.php"}
<ul class="cl">
  <form method="post">
    <li class="uc_zlli2"><span>请完善以下用户信息，以便我们更好的为您提供服务。</span></li>
    <li class="uc_zlli1">
      <label>用 户 名：</label>
      ：
      
      {if $_G.member.login_type && !$_G.username}
      <input class="uinfo text"  name="postdb[username]" type="text" value="{$_G.member.username}">
      {else}
      
      {$_G.username}
      
      {/if} <span style="margin-left:100px;">注册时间: <i  class="_dgmdate" data-time="{$_G.member.regdate}"></i>&nbsp;&nbsp;登录IP: {$_G.member.login_ip}</span> </li>
    <li class="uc_zlli1">
      <label>邮箱地址：</label>
      <input class="uinfo text"  name="postdb[email]" type="text" value="{$_G.member.email}">
    <li class="uc_zlli3 _hover_img" style="position: relative;">
      <div class="cl">
        <label>头　　像：</label>
        <div class="upload_img" data-name="postdb[picurl]">
          <input name="postdb[picurl]" value="{$_G.member.picurl}" type="text" class="txt pic_upload text" >
          图片大小建议尺寸为：160*160 </div>
      </div>
      <div class="cl">
        <label>&nbsp;</label>
        <a href="{$_G.member.picurl}" target="_blank" ><img src="{$_G.member.picurl}"  /></a>
        <input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
      </div>
    </li>
    <li class="uc_zlli1">
      <label>收货人姓名：</label>
      <input class="uinfo uc_zlli1text text" name="postdb[name]" type="text" value="{$_G.member.name}">
    </li>
    <li class="uc_zlli1">
      <label>旺　　旺：</label>
      <input class="uinfo uc_zlli1text text" name="postdb[wangwang]" type="text" value="{$_G.member.wangwang}">
    </li>
    <li class="uc_zlli1">
      <label>q　　q：</label>
      <input class="uinfo uc_zlli1text text" name="postdb[qq]" type="text" value="{$_G.member.qq}">
    </li>
    </li>
    <li class="uc_zlli1">
      <label>手　　机：</label>
      <input class="uinfo uc_zlli1text text" name="postdb[phone]"  type="text" value="{$_G.member.phone}">
      <h2></h2>
    </li>
    <li class="uc_zlli1">
      <label>收货地址：</label>
      <input class="uinfo uc_zlli1text text" name="postdb[address]"  type="text" value="{$_G.member.address}">
    </li>
    <li class="uc_zlli6">
      <label>个人简介：</label>
      <textarea class="uinfo text" name="postdb[content]">{$_G.member.content}</textarea>
    </li>
    <li class="uc_zlli4">
      <label></label>
      <input type="submit" class="seting_onsubmit u_submit"   name="onsubmit"value=" 保 存" />
    </li>
    <input type="hidden" name="m" value="{$CURMODULE}" />
    <input type="hidden" name="a" value="setting" />
  </form>
</ul>
{include file="./home_footer.php"}