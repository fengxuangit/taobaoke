{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">


  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody class="{if $_G.setting.apicloud_appid}hide{/if}">
        
          <tr class="noborder">
          <td class="td_l">appid:</td>
          <td class="vtop rowform"><input name="postdb[apicloud_appid]" value="{$_G.setting.apicloud_appid}" type="text" class="txt" ></td>
          <td class="vtop tips2">应用ID</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">appkey:</td>
          <td class="vtop rowform"> <input name="postdb[apicloud_appkey]" value="{$_G.setting.apicloud_appkey}" type="text" class="txt" >
          </td>
          <td class="vtop tips2">应用密钥</td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
            </div></td>
        </tr>

 </tbody>
 <tbody>
 
      <tr>
          <td colspan="8">
          <div class="count_tab">
          <ul>
            <li {if $_GET.type == 'app' || !$_GET.type}class="on"{/if} ><a href="{$URL}m=apps&a=count&type=app">应用统计</a></li>
            <li {if $_GET.type == 'version' }class="on"{/if}><a href="{$URL}m=apps&a=count&type=version">版本统计</a></li>
          <!--   <li {if $_GET.type == 'local' }class="on"{/if}><a href="{$URL}m=apps&a=count&type=local">地理分布统计</a></li> -->

          </ul>
    </div>
         </td>

        </tr>

        
{if $_GET.type == 'local'}
{include file='./count_local.php'}
{elseif $_GET.type == 'version'}
{include file='./count_version.php'}

{else}
{include file='./count_app.php'}
{/if}


</tbody>
 
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
