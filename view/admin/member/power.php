{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  <div class="table_top">权限管理</div>
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <th >一级模块</th>
          <th >分类模块</th>
        </tr>
        <!--{foreach from=$menu item=v key=k}-->
        <tr class="hover _hover_img">
          <td><input type="checkbox"  name="_del_all" value="1" class="red" />
            {$v.name} </td>
          <td style="height:auto"> {foreach from=$v.nav item=vv key = kk}
            <div class="cl z" style="min-width:105px">
              <input type="checkbox"  name="_del_all" value="1"  style="margin-left:20px;" />
              {$vv.name} </div>
            {/foreach} </td>
        </tr>
        <!--{/foreach}-->
        <tr>
          <td>&nbsp;</td>
          <td  ><div class="fixsel">
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