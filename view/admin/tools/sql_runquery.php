{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
   
  <!--<div class="table_top"></div>-->
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr>
          <td colspan="2" class="td27" >数据库升级或修改 - 请将数据库升级语句粘贴在下面:表前缀使用uz_system_即可.多行必须以;结束</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><textarea cols="85" rows="10" name="query_string"></textarea></td>
          <td class="vtop tips2" ></td>
        </tr>
        <tr>
          <td colspan="2" class="td27" ></td>
        </tr>
        <tr>
          <td colspan="15"><div class="fixsel">
              <input type="submit" class="btn submit_btn" name="onsubmit" title="按 Enter 键可随时提交您的修改" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 