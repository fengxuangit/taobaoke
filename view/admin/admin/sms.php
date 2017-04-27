{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      
       <tr class="noborder">
          <td class="td_l">是否开启短信发送:</td>
          <td class="vtop rowform">
          <input class="radio" type="radio" name="postdb[sms_status]" value="1" {if $_G.setting.sms_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[sms_status]" value="0" {if $_G.setting.sms_status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">开启前请确定您已申请通过了阿里大于短信的短信签名及配置了短信模板
           <a href="https://www.alidayu.com" target="_blank">点击申请</a>
  {literal}
           <p>短信模板内容申请时可填写:   您的验证码为${code}  ,10分钟内有效</p>
  {/literal}
           </td>
        </tr>
      
      

       <tr class="noborder">
          <td class="td_l">appkey:</td>
          <td class="vtop rowform"><input name="postdb[sms_appkey]" value="{$_G.setting.sms_appkey}" type="text" class="txt"></td>
          <td class="vtop tips2">在阿里大于,申请的应用列表详情中查看,填写不正确将导至发送短信不成功</td>
        </tr>
        

         <tr class="noborder">
          <td class="td_l">appSecreKey:</td>
          <td class="vtop rowform"><input name="postdb[sms_secrekey]" value="{$_G.setting.sms_secrekey}" type="text" class="txt"></td>
          <td class="vtop tips2">在阿里大于,申请的应用列表详情中查看,填写不正确将导至发送短信不成功</td>
        </tr>
        
 
         <tr class="noborder">
          <td class="td_l">短信模板ID:</td>
          <td class="vtop rowform"><input name="postdb[sms_id]" value="{$_G.setting.sms_id}" type="text" class="txt"></td>
          <td class="vtop tips2">短信模板ID，传入的模板必须是在阿里大于“管理中心-短信模板管理”中的可用模板。示例：SMS_585014</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">短信签名:</td>
          <td class="vtop rowform"><input name="postdb[sms_name]" value="{$_G.setting.sms_name}" type="text" class="txt"></td>
          <td class="vtop tips2">短信签名，传入的短信签名必须是在阿里大于“管理中心-短信签名管理”中的可用签名。如“阿里大于”已在短信签名管理中通过审核，则可传入”阿里大于“（传参时去掉引号）作为短信签名。短信效果示例：【阿里大于】欢迎使用阿里大于服务。</td>
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