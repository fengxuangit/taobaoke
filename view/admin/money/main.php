{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
<div class="table_top">

<div class="table_top_l">共找到({$count})条资金信息</div>
     <div class="table_top_r">
        <ul>

<li class="{if $_GET.status ==''}select{/if}"><a href="{$URL}m=money&a=main">全&nbsp;&nbsp;部</a></li>
{foreach from=$_G.setting.money_type item=v key=k}
<li class="{if $_GET.type != ''&& $_GET.type==$k}on{/if}"> <a href="{$URL}m=money&a=main&type={$k}">{$v}</a></li>
{/foreach}
        </ul>
  </div>  

</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">id</th>
		<th>用户</th>

        <th>获得返利</th>
        <th>上次账号余额</th>
        <th>类型</th>
        <th>描述</th>
        <th>时间</th>
        <th>删除</th>  
              
      </tr>
      </tbody>   
      <!--{foreach from=$goods item=v}-->
       <tbody>
<tr class="hover">  
<td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
     <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
<td class="td25">{$v.id}</td>  
<td>	<a href="{$URL}m=money&a=main&uid={$v.uid}">{$v.username}</a></td>    
<td>{$v.money}</td>
<td>{$v.org_money}</td>
<td>{$v.type_name}</td>
<td>{$v.desc}</td>
<td  class="_dgmdate" data-time="{$v.dateline}"></td>           

<td><a href="{$URL}m=money&a=del_money&id={$v.id}&ok=1" class="_confirm" data-msg="您确认删除当前记录吗?删险后不可恢复">删除</a></td>

      </tr>
      </tbody>     
       <!--{/foreach}-->
       <tbody>
      <tr>
        <td class="td25">
        <input type="checkbox" class="_del_all" />反选</td>
        <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="12">
        <div class="y">{$showpage}</div>
        <div class="fixsel">
            <input type="submit" class="btn submit_btn" name="onsubmit"  value=" 提 交" >
          </div></td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 