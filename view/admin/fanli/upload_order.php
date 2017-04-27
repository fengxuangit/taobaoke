{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post">
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">导入格式样例:</td>
          <td class="vtop rowform _hover_img" data-left="150"> 鼠标移动查看 <a href="{$IMGDIR}/geshi.png" target="_blank"> <img src="{$IMGDIR}/geshi.png"  style="max-width:800px"></a></td>
          <td class="vtop tips2" ></td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">excel文件:</td>
          <td class="vtop rowform "><input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>
          <td class="vtop tips2" >待上传的excel文件</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">&nbsp;</td>
          <td class="vtop rowform" colspan="3"><input type="submit" class="btn submit_btn"  name="onsubmit"  value="立即上传"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <input type="hidden" name="m" value="{$CURMODULE}" />
  <input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 