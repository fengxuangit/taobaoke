{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
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
          <td colspan="2" class="td27" >用户ID:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="uid" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >要搜索的用户ID</td>
        </tr>
        
        <tr>
          <td colspan="2" class="td27" >email:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="email" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >要搜索的用户用的email</td>
        </tr>
        
          <tr>
          <td colspan="2" class="td27" >旺旺:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="wangwang" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >要搜索的用户用的旺旺</td>
        </tr>
        
          <tr>
          <td colspan="2" class="td27" >qq:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="qq" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >要搜索的用户用的qq</td>
        </tr>

        
  		<tr>
          <td colspan="2" class="td27" >用户电话:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="phone" value=""  type="text" class="txt"></td>
          <td class="vtop tips2" >要搜索的用户电话</td>
        </tr>
        
        
         <tr>
          <td colspan="2" class="td27" >支付宝账号:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="alipay" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >要搜索的用户用的支付宝账号</td>
        </tr>
        
         
        {if $_G.setting.fanli == 1}
         <tr>
          <td colspan="2" class="td27" >用户订单后4位:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="order_number" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >用户订单后4位</td>
        </tr>
        {/if}
         
         <tr>
          <td colspan="2" class="td27" >推荐者用户名:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="t_user_name" value=""  type="text" class="txt "></td>
          <td class="vtop tips2" >推荐者用户名</td>
        </tr>
        
        
        <tr>
          <td colspan="2" class="td27" >积分区间:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform">
          <input name="jf_min" value=""  type="text" class="txt w90">
--            
          <input name="jf_max" value=""  type="text" class="txt w90"></td>
          <td class="vtop tips2" >要搜索的用户积分区间</td>
        </tr>
        

        
         
        <tr class="noborder">
          <td class="vtop rowform">所属用户组</td>
          <td class="vtop tips2" ></td>
        </tr>
         <tr class="noborder">
          <td class="vtop rowform">
<select name="groupid" class="select_fid check_text">
  <option value="">---请选择用户组---</option>
    <!--{foreach from=$_G.group item=vv}-->
    <option value="{$vv.id}" >{$vv.name}</option>
    <!--{/foreach}-->
  </select>
          
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>
       
        <td colspan="3"><div class="fixsel"> 
        	<input type="hidden" name="search"  value="1" />
            <input type="submit" class="btn submit_btn" name="onsubmit_search" value="提交">
          </div></td>
      </tr>
        </tbody>
      
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 