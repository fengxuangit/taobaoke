{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      
        <tr class="noborder">
          <td class="td_l">是否开启邮件发送功能:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[status]" value="1" {if $_G.setting.email.status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[status]" value="0" {if $_G.setting.email.status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启邮件发送功能</td>
        </tr>
      
      <tr class="noborder" >
          <td class="td_l">SMTP 服务器:</td>
          <td class="vtop rowform">
          <input name="postdb[smtp]" value="{$_G.setting.email.smtp}" type="text" class="txt">
          </td>
          <td class="vtop tips2" >如果是qq邮箱，则填smtp.qq.com，其它类似</td>
        </tr>
        
 		<tr class="noborder" >
          <td class="td_l">发件人邮箱地址:</td>
          <td class="vtop rowform">
          <input name="postdb[address]" value="{$_G.setting.email.address}" type="text" class="txt">
          </td>
          <td class="vtop tips2" >发件人的完整地址，如：123456789@qq.com</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">发件人邮箱密码:</td>
          <td class="vtop rowform"> <input name="postdb[password]" value="{$_G.setting.email.password}" type="password" class="txt"></td>
          <td class="vtop tips2" >如果是QQ邮箱则一般是QQ登录密码，如果不正确请自己尝试登录邮箱确认密码后再填写</td>
        </tr>

		<tr class="noborder" >
          <td class="td_l">端口:</td>
          <td class="vtop rowform"> <input name="postdb[port]" value="{$_G.setting.email.port}" type="text" class="txt w90"></td>
          <td class="vtop tips2" >一般是25</td>
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