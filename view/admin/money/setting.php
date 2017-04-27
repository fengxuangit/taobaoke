{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
       
       
       
    	   <tr class="noborder">
              <td class="td_l">提现最小金额:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[tixian_min]" value="{$_G.setting.tixian_min}" />&nbsp;元
                
                </td>
              <td class="vtop tips2">用户提现时的最小金额,填0则没有限制</td>
      	  </tr>
          
           <tr class="noborder">
              <td class="td_l">提现手续费:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[shouxufei]" value="{$_G.setting.shouxufei}" />&nbsp;%
                
                </td>
              <td class="vtop tips2">用户提现时的手续费,填0则没有手续费</td>
      	  </tr>
          
          
       

        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
              &nbsp;&nbsp;
             <!--  <input type="button" class="btn add_row" value="增加一行">-->
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 