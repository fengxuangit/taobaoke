{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        
        <tr>
          <td colspan="2" class="td27" ></td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform" colspan="2" style="font-size:24px;">
         共{$count}条商品信息.请将下列商品复制到优淘采集插件中进行转换.(每次最多300条)
          
          
         
          
          </td>
        </tr>
 <tr class="noborder">
          <td class="vtop rowform" colspan="2">
         
        <textarea class="textarea" cols="120" name="goods_list"  rows="16">{$goods}</textarea>
          
          </td>
        </tr>


        <td colspan="3"><div class="fixsel"> 
        	<input type="hidden" name="search"  value="1" />
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