{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
         <tr class="noborder " >
          <td class="td_l">标记:</td>
          <td class="vtop rowform">
          <input class="txt" type="text" name="postdb[flag]" value="{$_G.setting.flag}" /></td>
          <td class="vtop tips2">可以给商品或文章定义一个标记.</td>
        </tr>
        
        <tr class="noborder">
          <td class="td_l">商品标签:</td>
          <td class="vtop rowform">
          <input class="txt" type="text" name="postdb[tags]" value="{$_G.setting.tags}" /></td>
          <td class="vtop tips2">商品标签,可以给商品定义不同的标签,多个用,格开</td>
        </tr>
        {if $SYSTEM_TYPE>2}
        <tr class="noborder">
          <td class="td_l">店铺标签:</td>
          <td class="vtop rowform">
          <input class="txt" type="text" name="postdb[shop_tag]" value="{$_G.setting.shop_tag}" /></td>
          <td class="vtop tips2">店铺标签,可以给店铺定义不同的标签,多个用,格开,不要随意插队,需要添加的话请在后面按顺序添加.</td>
        </tr>
        {/if}

  	
        
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