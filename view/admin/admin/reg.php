{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
    

        <tr class="noborder">
          <td class="td_l">是否开启会员注册:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[reg_status]" value="1" {if $_G.setting.reg_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[reg_status]" value="0" {if $_G.setting.reg_status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启会员注册,否则禁止新用户注册</td>
        </tr> 
         <tr class="noborder">
          <td class="td_l">注册是否自动审核:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[reg_check]" value="1" {if $_G.setting.reg_check==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[reg_check]" value="0" {if $_G.setting.reg_check==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">为否则必须后台管理员手动审核,未审核的用户只能不能签到,兑换,收藏,等等</td>
        </tr> 
        <tr class="noborder">
          <td class="td_l">注册是否需要邮件验证:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[email_check]" value="1" {if $_G.setting.email_check==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[email_check]" value="0" {if $_G.setting.email_check==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">注册是否需要邮件验证</td>
        </tr> 
           <tr class="noborder">
          <td class="td_l">注册开启验证码:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[reg_yzm]" value="1" {if $_G.setting.reg_yzm==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[reg_yzm]" value="0" {if $_G.setting.reg_yzm==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启注册页面的验证码,防止恶意用户</td>
        </tr> 
          <tr class="noborder">
          <td class="td_l">登录开启验证码:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[login_yzm]" value="1" {if $_G.setting.login_yzm==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[login_yzm]" value="0" {if $_G.setting.login_yzm==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启登录页面的验证码,防止恶意用户</td>
        </tr> 
        
        
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 