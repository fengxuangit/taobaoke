{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      
       <tr class="noborder">
          <td class="td_l">是否开启手机版:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[mobile_status]" value="1" {if $_G.setting.mobile_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[mobile_status]" value="0" {if $_G.setting.mobile_status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">开启前请确定您已开发了手机HTML5模板</td>
        </tr>
      
      
 
         <tr class="noborder">
          <td class="td_l">手机模板名称:</td>
          <td class="vtop rowform"><input name="postdb[mobile_tpl]" value="{$_G.setting.mobile_tpl}" type="text" class="txt"></td>
          <td class="vtop tips2">默认为mobile文件夹,如果有其它的,可以手动填写模板目录</td>
        </tr>
        
		 <tr class="noborder">
          <td class="td_l">手机域名:</td>
          <td class="vtop rowform"><input name="postdb[mobile_host]" value="{$_G.setting.mobile_host}" type="text" class="txt"></td>
          <td class="vtop tips2">如有开通手机版,则需开一个二级域名指向,这样使SEO更好的收录.
          <p>如果您的域名是http://www.baidu.com,你则可只需填写http://m.baidu.com</p>
          <p>如没有手机版域名可不填写也能直接展示手机版</p>
          </td>
        </tr>

          <tr class="noborder">
          <td class="td_l">手机强制跳转域名:</td>
          <td class="vtop rowform"><input name="postdb[mobile_jump]" value="{$_G.setting.mobile_jump}" type="text" class="txt"></td>
          <td class="vtop tips2">用户是手机访问,则强制跳往到刚地址,留空则不进行跳转</td>
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