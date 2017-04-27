{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"   action="">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      <tr class="noborder">
          <td class="td_l">推广组名称:</td>
          <td class="vtop rowform">

          <input value="{$rank.name}" type="text" class="txt"  name="postdb[name]" >

          
          </td>
          <td class="vtop tips2"></td>
        </tr>
      
       
        <tr class="noborder">
          <td class="td_l">返利比例:</td>
          <td class="vtop rowform"><input name="postdb[bili]" value="{$rank.bili}" type="text" class="txt"> %
          </td>
          <td class="vtop tips2">为0则不返</td>
        </tr>
       
      

        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel"> 
              <!--{if $_GET.uid}-->
              <input type="hidden" name="uid" value="{$_GET.uid}" />
              <!--{/if}-->
              <input type="submit" class="btn submit_btn" name="onsubmit" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>

<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 