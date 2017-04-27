{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  <div class="table_top">
<!-- <span>1-10 系统用户组	10-20站内用户组	20++ 其它登录用户组</span>-->
  </div>
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <th>id</th>
          <th>名称</th>
          <th>返利比例</th>
          <th>编辑</th>

          <th>删除</th>
          <th>添加时间</th>
        </tr>
        <!--{foreach from=$goods item=v name=f}-->
        <tr class="hover ">
           <td class="td25">
           {$v.id}
         	<input type="hidden" name="ids[{$v.id}]" value="{$v.id}" />
            </td>
          <td>{$v.name} </td>
          <td>{$v.bili} %</td>
          <td><a href="{$URL}m=member&a=rank_post&id={$v.id}">编辑</a></td>
          <td><a href="{$URL}m=member&a=rank_del&id={$v.id}" >删除</a></td>
          <td class="_dgmdate"  data-time="{$v.dateline}"></td>
        </tr>
        <!--{/foreach}-->
        

      <tr>
        

        <td colspan="6">
        <div class="y">{$showpage}</div>
        </td>
      </tr>

        
        
      </tbody>
    </table>
  </div>
  <input type="hidden" name="m" value="{$CURMODULE}" />
  <input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} <strong></strong>