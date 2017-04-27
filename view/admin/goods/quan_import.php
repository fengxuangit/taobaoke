{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post">
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">导入说明:</td>
          <td class="vtop rowform" data-left="150" colspan="2">
                    在阿里妈妈后台下单优惠券订单信息,然后在此入进行批量导入
          <a href="http://pub.alimama.com/myunion.htm?#!/promo/self/items" target="_blank" class="red">立即下载</a>
            </td>
          </tr>



        <tr class="noborder" >
          <td class="td_l">xls文件:</td>
          <td class="vtop rowform "><input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>
          <td class="vtop tips2" >淘宝联盟导出的选品库,格式为xls文件</td>
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
