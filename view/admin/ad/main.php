{include file='../common_admin/left_bar.php'}
  <div class="table_top">共找到({$count})条广告信息</div>
<form enctype="multipart/form-data" method="post" action="">  

  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">id</th>       
        <th>广告名称</th>
        <th>广告类型</th>
        <th>开始时间</th>
        <th>结束时间</th>  
        <th>当前状态</th>
        <th>隐藏</th>      
        <th>编辑</th>
        <th>删除</th>        
        <th>添加时间</th>
      </tr>
      </tbody>
      <!--{foreach from=$_G.ad item=v}-->
       <tbody>
      <tr class="hover">  
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
        <td class="td25">{$v.id}</td>        
        <td><input type="text" name="name[{$v.id}]" value="{$v.name}"  class="txt" /></td>
        <td  {if $v.type == 2}class="_hover_img"{/if}>{$v.type_name}
        {if $v.type == 2}
        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
        {/if}
        </td>
        <td><input type="text" name="start_time[{$v.id}]" value="{$v.start_time}"  class="txt _dateline" /></td>
        <td><input type="text" name="end_time[{$v.id}]" value="{$v.end_time}"  class="txt _dateline" /></td>
        <td>
        {if $v.show}
        正常显示
        {else}
        <span class="red">不显示</span>
        {/if}
        </td>
        <td><input name="hide[{$v.id}]" value="1" type="checkbox" {if $v.hide==1} checked="checked"{/if} class="checkbox"></td>
        <td><a href="{$URL}m=ad&a=post&id={$v.id}">编辑</a></td>
        <td><a href="{$URL}m=ad&a=del&id={$v.id}" >删除</a></td>
         <td class="_dgmdate" data-time="{$v.dateline}"></td>
      </tr>
      </tbody>     
       <!--{/foreach}-->
       <tbody>
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />反选</td>
        <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="9"><div class="fixsel">
            <input type="submit" class="btn submit_btn" name="onsubmit"  value=" 提 交" >
          </div>
          </td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 