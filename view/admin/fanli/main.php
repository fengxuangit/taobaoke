{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
<div class="table_top">

<div class="table_top_l">共找到({$count})条订单信息</div>
     <div class="table_top_r">
        <ul>

<li class="{if $_GET.status ==''}select{/if}"><a href="{$URL}m=fanli&a=main">全&nbsp;&nbsp;部</a></li>
{foreach from=$_G.setting.order_status item=v key=k}
<li class="{if $_GET.status != ''&& $_GET.status==$k}on{/if}"> <a href="{$URL}m=fanli&a=main&status={$k}">{$v}</a></li>
{/foreach}


<li  style="margin-left: 20px;">提交类型</li>

<li class="{if $_GET.type=="0"}on{/if}"> <a href="{$URL}m=fanli&a=main&type=0">手动提交</a></li>
<li class="{if $_GET.type=="1"}on{/if}"> <a href="{$URL}m=fanli&a=main&type=1">ios下单</a></li>
<li class="{if $_GET.type=="2"}on{/if}"> <a href="{$URL}m=fanli&a=main&type=2">android下单</a></li>

        </ul>
  </div>  

</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">id</th>

        <th>标题</th>
        <th>获得积分</th>  
        <th>支付价格</th>
       
        <th>平台</th>
        <th>提交类型</th>
       <th>订单号</th>
       
       <th>订单创建时间</th>
       <th>订单结算时间</th>
       <th>所属用户</th>
       <th>导入时间</th>
		<th>状态</th>
       <th>删除</th>        
      </tr>
      </tbody>   
      <!--{foreach from=$goods item=v}-->
       <tbody>
<tr class="hover">  
<td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
     <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
<td class="td25">{$v.id}</td>        
<td><a href="http://item.taobao.com/item.htm?id={$v.num_iid}" target="_blank">{$v.title}</a></td>

<td>{$v.jf}</td>
<td>{$v.price}</td>

<td>{$v.pingtai}</td>
<td>
{if $v.type == 1}
  ios下单
{elseif $v.type ==2}
  android下单
{else}
  手动提交
{/if}
</td>
<td>{$v.order_number}</td>
<td class="_dgmdate" data-time="{$v.create_time}"></td>
<td class="_dgmdate" data-time="{$v.end_time}" ></td>
<td>
{if $v.uid>0}
	<a href="{$URL}m=fanli&a=main&uid={$v.uid}">{$v.username}</a>
{else}
	{$v.status_text}
{/if}
</td>  
<td class="_dgmdate" data-time="{$v.dateline}" ></td>           
<td>{$v.status_text}</td>
<td><a href="{$URL}m=fanli&a=del&id={$v.id}&ok=1" class="_confirm" data-msg="您确认删除当前记录吗?删险后不可恢复">删除</a></td>

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