{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
    <div class="table_top">其它设置</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>


         <tr class="noborder" >
          <td class="td_l">推送接口:</td>
          <td class="vtop rowform">
          <input class="radio" type="radio" name="postdb[app_push]" value="jpush" {if $_G.setting.app_push=='jpush'}checked="checked"{/if}>
            &nbsp;激光推送
             <input class="radio" type="radio" name="postdb[app_push]" value="baichuan" {if $_G.setting.app_push=='baichuan'}checked="checked"{/if}>
            &nbsp;百川推送
            <!--  <input class="radio" type="radio" name="postdb[app_push]" value="apiColud" {if $_G.setting.app_push=='apiColud'}checked="checked"{/if}>
            &nbsp;APIColud -->

              <input class="radio" type="radio" name="postdb[app_push]" value="xg" {if $_G.setting.app_push=='xg'}checked="checked"{/if}>
            &nbsp;腾迅信鸽

             </td>
          <td class="vtop tips2">选择推送的接口
          </td>
        </tr>

         <tr class="noborder">
          <td class="td_l">推送appkey:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[push_appkey]" value="{$_G.setting.push_appkey}" /></td>
          <td class="vtop tips2">对应推送接口类型的appkey</td>
        </tr>

		 <tr class="noborder">
          <td class="td_l">推送secretKey:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[push_secret_key]" value="{$_G.setting.push_secret_key}" /></td>
          <td class="vtop tips2">对应推送接口类型的secretKey</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">推送appkey2:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[push_appkey_ios]" value="{$_G.setting.push_appkey_ios}" /></td>
          <td class="vtop tips2">某些平台安卓和IOS appkey是分开的,这里可填写IOS的appkey</td>
        </tr>

		 <tr class="noborder">
          <td class="td_l">推送secretKey2:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[push_secret_key_ios]" value="{$_G.setting.push_secret_key_ios}" /></td>
          <td class="vtop tips2">某些平台安卓和IOS appkey是分开的,这里可填写IOS的secretKey</td>
        </tr>


         <tr class="noborder">
          <td class="td_l">APP搜索标签:</td>
          <td class="vtop rowform"><textarea rows="6" name="postdb[app_kw]" cols="70" class="tarea">{$_G.setting.app_kw}</textarea></td>
          <td class="vtop tips2">展示在APP搜索页面,多个用英文豆号(,)格开</td>
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
