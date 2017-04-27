{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_top">共找到({$count})条全局变量</div>
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <th class="td25">删除</th>
          <th>id</th>
          <th>变量描述</th>
          <th>名称</th>
      
          <th>添加时间</th>
          <th>编辑</th>
          <th>删除</th>
        </tr>
        <!--{foreach from=$globals item=v}-->
        <tr class="hover">
          <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
            <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
          <td>{$v.id}</td>
           <td>{$v.title}</td>
          <td>{$v.name}</td>

          <td  class="_dgmdate" data-time="{$v.dateline}"></td>
          <td><a href="{$URL}m=module&a=globals_add&id={$v.id}">编辑</a></td>
          <td><a href="{$URL}m=module&a=globals_del&id={$v.id}" >删除</a></td>
        </tr>
        <!--{/foreach}-->
        <tr>
          <td class="td25"><input type="checkbox" class="_del_all" />
            反选</td>
            <td class="td25"><input type="checkbox"  name="_del_all" value="1"/>删除</td>
          <td colspan="8"><div class="fixsel">
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