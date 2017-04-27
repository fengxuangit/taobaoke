{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_top">共找到({$count})条分类</div>
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <th class="td25">删除</th>
          <th class="td25">id</th>
          <th>后台显示名称</th>
          <th>前台显示名称</th>
        </tr>
      </tbody>
      <!--{foreach from=$_G.pics_type item=v}-->
      <tbody>
        <tr class="hover">
          <td class="td25" ><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
          <td>{$v.id}</td>
          <td>{$v.name}</td>
          <td>{$v.content}</td>
          <td><a href="{$URL}m=pics&a=type_post&id={$v.id}">编辑</a></td>
          <td><a href="{$URL}m=pics&a=type_del&id={$v.id}" >删除</a></td>
          <td >&nbsp;</td>
        </tr>
      </tbody>
      <!--{/foreach}-->
      <tbody>
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