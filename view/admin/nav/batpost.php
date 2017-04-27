{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >

  <div class="table_main">
  <table class="tb tb2 nobdb" id="table">
    <tbody>
      <tr>
        <th colspan="12" class="partition">批量加添栏目&nbsp;&nbsp; </th>
      </tr>
      <tr class="hover" style="text-align:left">
        <td>&nbsp;</td>
        <td >导航名称</td>
        <td >导航链接</td>
        <td >导航class</td>
        <td >打开方式</td>
        <td >导航类型</td>
        <td >排序</td>

      </tr>
    </tbody>
    <tbody class="row_main">
      <tr class="hover first" style="text-align:left">
        <td>&nbsp;</td>
        <td><input type="text" name="name[]" value="" />
          <input type="hidden" name="tmp[0]" class="tmp_index" /></td>
        <td><input type="text" name="url[]" value=""/></td>
        <td ><input type="text" name="classname[]" value="" /></td>
        <td > <select name="target[]" >
                <option value="0" >当前页面</option>
                <option value="1" >新窗口</option>
            </select></td>
        <td > <select name="type[]" >
           {foreach from=$_G.setting.nav item=v key=k}
              <option value="{$k}" {if $v.type == $k} selected {/if}>{$v}</option>
             {/foreach}

            </select></td>
        <td ><input type="text" name="sort[]" value=""/></td>
      </tr>


    </tbody>
    <tbody>
      <tr>
        <td colspan="3"><div class="fixsel">
            <input type="button" class="btn add_row" value="添加一行">
            <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提 交">
          </div></td>
      </tr>
    </tbody>
  </table>


</div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
