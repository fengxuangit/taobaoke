{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
<div class="table_top">

<div class="table_top_l">共找到({$count})条提现信息</div>
     <div class="table_top_r">
        <ul>

<li class="{if $_GET.status ==''}select{/if}"><a href="{$URL}m=fanli&a=tixian">全&nbsp;&nbsp;部</a></li>
{foreach from=$_G.setting.tixian_status item=v key=k}
<li class="{if $_GET.status != ''&& $_GET.status==$k}on{/if}"> <a href="{$URL}m=fanli&a=tixian&status={$k}">{$v}</a></li>
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

        <th>提现金额</th>
        <th>手续费</th>
        <th>最终提现金额</th>
        <th>上次账号余额</th>
        
        <th>状态</th>
        <th>回复消息</th>
        <th>编辑</th>
        <th>删除</th>  
         <th>申请时间</th>
         <th>最后审核时间</th>
      </tr>
      </tbody>   
      <!--{foreach from=$goods item=v}-->
       <tbody>
<tr class="hover">  
<td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
     <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
<td class="td25">{$v.id}</td>  
<td>	<a href="{$URL}m=fanli&a=tixian&uid={$_G.uid}">{$v.username}</a></td>    
<td>{$v.money}</td>
<td>{$v.shouxufei}</td>
<td class="red">{$v.money-$v.shouxufei}</td>
<td>{$v.org_money}</td>
<td>
<select name="status[{$v.id}]" class="select_fid"> 

<!--{foreach from=$_G.setting.tixian_status item=vv key=k}-->
 <option value="{$k}" {if $v.status ==$k} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv}</option>
          
<!--{/foreach}-->
</select>

</td>
<td class="_showDialog" data-msg="{$v.msg}">{$v.msg_cut}</td>
<td><a href="{$URL}m=fanli&a=post_tixian&id={$v.id}" >编辑</a></td>
     

<td><a href="{$URL}m=fanli&a=del_tixian&id={$v.id}&ok=1" class="_confirm" data-msg="您确认删除当前记录吗?删险后不可恢复">删除</a></td>
<td>{$v.dateline}</td>      
<td>{$v.updatetime}</td>    
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
       <select name="status_in" class="select_fid"> 
 <option value="-1">请选择要修改的状态</option>
<!--{foreach from=$_G.setting.tixian_status item=vv key=k}-->
 <option value="{$k}">&nbsp;&nbsp;&nbsp;&nbsp;{$vv}</option>
<!--{/foreach}-->
</select>

          &nbsp;&nbsp;
        
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