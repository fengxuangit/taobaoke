{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
    <div class="table_top">其它设置</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>


         <tr class="noborder" >
          <td class="td_l">是否开启校验接口:</td>
          <td class="vtop rowform">
          <input class="radio" type="radio" name="postdb[app_sign_check]" value="1" {if $_G.setting.app_sign_check=='1'}checked="checked"{/if}>
            &nbsp;开启
             <input class="radio" type="radio" name="postdb[app_sign_check]" value="0" {if $_G.setting.app_sign_check=='0'}checked="checked"{/if}>
            &nbsp;关闭
             </td>
          <td class="vtop tips2">开启校验将大大提高接口信息安全,可防止被恶意请求
          <p>接口加密方式为md5和sha1,默认为md5,无法从网站设置,必须从APP设置</p>
          </td>
        </tr>

         <tr class="noborder">
          <td class="td_l">校验key:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[app_sign_key]" value="{$_G.setting.app_sign_key}" /></td>
          <td class="vtop tips2">加密字符串的key,必须和app中配置一至否则会验证失败
          <p class="red">(禁止随意更改,必须和app中一致否则所有请求会失败)</p></td>
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
