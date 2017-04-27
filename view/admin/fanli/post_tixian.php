{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">提现金额:</td>
          <td class="vtop rowform">{$goods.money}</td>
          <td class="vtop tips2" ></td>
        </tr>
        
         <tr class="noborder" >
          <td class="td_l">手续费:</td>
          <td class="vtop rowform">{$goods.shouxufei}</td>
          <td class="vtop tips2" ></td>
        </tr>
        
         <tr class="noborder" >
          <td class="td_l">最终提现金额:</td>
          <td class="vtop rowform red">{$goods.money-$goods.shouxufei}</td>
          <td class="vtop tips2" ></td>
        </tr>
        
      <tr class="noborder" >
          <td class="td_l">上次更新时间:</td>
          <td class="vtop rowform">
          {$goods.updatetime}
          </td>
          <td class="vtop tips2" ></td>
        </tr>
        
        
          <tr class="noborder" >
          <td class="td_l">修改状态:</td>
          <td class="vtop rowform">
       <select name="postdb[status]" class="select_fid"> 

<!--{foreach from=$_G.setting.tixian_status item=vv key=k}-->
 <option value="{$k}" {if $goods.status == $k} selected{/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv}</option>
<!--{/foreach}-->
</select>
          </td>
          <td class="vtop tips2" ></td>
        </tr>
        
        
        
        <tr class="noborder" >
          <td class="td_l">审核留言:</td>
          <td class="vtop rowform">
           <textarea rows="3" name="postdb[msg]" cols="50" class="textarea">{$goods.msg}</textarea>
          </td>
          <td class="vtop tips2" >审核拒绝,不通过的情况下可以给用户留言</td>
        </tr>
       
       
       
     
        <tr class="noborder" >
        <td class="td_l">&nbsp;</td>
          <td class="vtop rowform" colspan="3"><div class="fixsel"> 
          {if $_GET.id}
              <input type="hidden" name="id" value="{$_GET.id}" />
              {/if}
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 