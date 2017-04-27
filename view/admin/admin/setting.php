{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>

        <tr class="noborder" >
          <td class="td_l">站点名称:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="{$_G.setting.title}" type="text" class="txt"></td>
          <td class="vtop tips2" >站点名称，将显示在浏览器窗口标题等位置</td>
        </tr>
         <tr class="noborder" >
          <td class="td_l">站点网址:</td>
          <td class="vtop rowform"><input name="postdb[siteurl2]" value="{$_G.setting.siteurl2}" type="text" class="txt"></td>
          <td class="vtop tips2" >以http://开头,结尾不要/,如:http://aimeizhuang.uz.taobao.com,在接口商品中会用到,必须和采集配置Appkey和siteKey对应同一个U站</td>
        </tr>
        

        <tr class="noborder" > 
        <td class="td_l">站点logo:</td>
          <td class="vtop rowform _hover_img">

<div class="upload_img" data-name="postdb[logo]">
<input name="postdb[logo]" value="{$_G.setting.logo}" type="text" class="txt pic_upload" >
{if $_G.setting.logo}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
           </div>
<a href="{$_G.setting.logo}" target="_blank" ><img src="{$_G.setting.logo}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          
          </td>
          <td class="vtop tips2" >站点logo,如果无法上传,请手动粘贴图片地址</td>
        </tr>
      
        <tr class="noborder" >
         <td class="td_l">客服QQ:</td>
          <td class="vtop rowform"><input name="postdb[qq]" value="{$_G.setting.qq}" type="text" class="txt"></td>
          <td class="vtop tips2" >多个请用,分格开</td>
        </tr>

        <tr class="noborder" >
         <td class="td_l">管理员邮箱:</td>
          <td class="vtop rowform"><input name="postdb[admin_email]" value="{$_G.setting.admin_email}" type="text" class="txt"></td>
          <td class="vtop tips2" >管理员 E-mail，将作为系统发邮件的时候的发件人地址</td>
        </tr>

        <tr class="noborder" >
        <td class="td_l">站点默认分享内容:</td>
          <td class="vtop rowform"><input name="postdb[share]" value="{$_G.setting.share}" type="text" class="txt"></td>
          <td class="vtop tips2" >在分享的地方,默认显示的内容</td>
        </tr>

        <tr class="noborder" >
          <td class="td_l">网站版权信息:</td>
          <td class="vtop rowform"><textarea rows="6" name="postdb[copyright]" cols="70" class="tarea">{$_G.setting.copyright}</textarea></td>
          <td class="vtop tips2" >网站版权或介绍信息</td>
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