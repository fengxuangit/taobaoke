{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" target="_blank" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
     <tr class="noborder" >

          <td class="vtop tips2 " colspan="3"><span class="red">本功能可更新商品信息,在更新过程中会检查并删除淘宝已下架的商品</span></td>
        </tr>
     
      <tr class="noborder" >
          <td class="td_l">吏新类型:</td>
          <td class="vtop rowform">
<ul>
           <li><input class="radio" type="radio" name="type" value="0" checked="true">
              &nbsp;上架商品</li>
            <li >
              <input class="radio" type="radio" name="type" value="1" >
              &nbsp;全站商品</li>
</ul>
          </td>
          <td class="vtop tips2" >全站更新会比较慢,建议上架商品</td>
        </tr>
    
     
       <tr class="noborder" >
          <td class="td_l">大于多少小时未更新的商品:</td>
          <td class="vtop rowform"><input name="time" value="" type="text" class="txt w90">/小时</td>
          <td class="vtop tips2" >如:填10 则更新所有>10小时以前未更新的商品</td>
        </tr>
  		  <tr class="noborder">
          <td class="td_l">需要更新的字段:</td>
          <td class="vtop rowform">
          {foreach from=$field item=v key=k}
          <label for="{$v.key}">{$v.name}<input type="checkbox" name="field[{$v.key}]" class="checkbox" value="1" {if $v.check==1} checked="checked" {/if}/></label>&nbsp;
          {/foreach}
           </td>
          <td class="vtop tips2">
          <p>未选中的则不更新此字段,销量字段.只有淘宝接口才返回,百川接口不返回</p>
          </td>
        </tr>

        <td colspan="3"><div class="fixsel"> 
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