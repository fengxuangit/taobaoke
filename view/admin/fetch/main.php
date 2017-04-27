{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">  
  <div class="table_top">共找到({$count})条采集规则信息</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">id</th>       
        <th>规则标题</th>
		 <th>总采集条数</th>
			<th>总执行次数</th>

        <th>编辑</th>
        <th>删除</th>        
        <th>添加时间</th>
        <th>执行</th>
        <th>最后执行时间</th>
      </tr>
      </tbody>
      <!--{foreach from=$goods item=v}-->
       <tbody>
      <tr class="hover">  
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
        <td class="td25">{$v.id}</td>        
        <td>{$v.title}</td>
		<td>{$v.sum}</td>
        <td>{$v.count}</td>
        <td><a href="{$URL}m=fetch&a=post&id={$v.id}">编辑</a></td>
        <td><a href="{$URL}m=fetch&a=del&id={$v.id}&page={$_G.page}"  class="_confirm" data-msg="您确定删除本商品?删除后不可恢复">删除</a></td>
         <td  class="_dgmdate" data-time="{$v.dateline}"></td>
         
         <td><a href="{$URL}m=fetch&a=start&id={$v.id}" target="_blank" class="red" >执行</a></td>
         <td  class="_dgmdate" data-time="{$v.updatetime}"></td>
      </tr>
      </tbody>     
       <!--{/foreach}-->
       <tbody>
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />反选</td>
        <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="9">
        <div class="y showpage">{$showpage}</div>
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