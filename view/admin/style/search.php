{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        
        <tr>
          <td colspan="2" class="td27" >用户名:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="username" value=""  type="text" class="txt"></td>
          <td class="vtop tips2" >要搜索的用户名</td>
        </tr>
       
          
        <tr>
          <td colspan="2" class="td27" >ip:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="ip" value=""  type="text" class="txt"></td>
          <td class="vtop tips2" >要搜索的ip</td>
        </tr>
        
        
  

        <td colspan="3"><div class="fixsel"> 
        	<input type="hidden" name="search"  value="1" />
            <input type="submit" class="btn submit_btn" name="onsearch" value="提交">
          </div></td>
      </tr>
        </tbody>
      
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 