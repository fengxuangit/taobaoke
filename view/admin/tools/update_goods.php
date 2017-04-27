{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" target="_blank" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      {if $info}
      <tr class="noborder" >
          <td class="td_l"> </td>
          <td class="vtop rowform" colspan="2">{$info}</td>
        </tr>
      {/if}
      <tr class="noborder" >
          <td class="td_l">每页条数:</td>
          <td class="vtop rowform"><input name="size" value="" type="text" class="txt"></td>
          <td class="vtop tips2" >每一次更新多少条商品,不填或0则默认为50</td>
        </tr>
    
        
        <tr class="noborder" >
          <td class="td_l">发布商品时间范围:</td>
          <td class="vtop rowform">
          <input name="posttime1" value="" type="text" class="txt _dateline" style="width:150px"> --
           <input name="posttime2" value="" type="text" class="txt _dateline" style="width:150px">
          </td>
          <td class="vtop tips2" >更新在此时间范围内的商品</td>
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
          <p>未选中的则不更新此字段,全不选则默认全部都检查和更新,默认配置在 站点配置-采集配置里面设定</p>
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