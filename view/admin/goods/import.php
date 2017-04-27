{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post">
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">导入说明:</td>
          <td class="vtop rowform" data-left="150" colspan="2">
          可以在淘宝联盟中选择自定义商品并导出选品库,然后在此入进行批量导入
<a href="http://pub.alimama.com/promo/search/index.htm?" target="_blank" class="red">查看导入地址</a>

        </tr>


        <tr class="noborder" >
          <td class="td_l">上传的栏目:</td>
          <td class="vtop rowform"  colspan="2" >


<select name="postdb[fid]" class="select_fid">
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $goods.fid==$vv.fid || $vv.fid==$_GET.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $goods.fid==$vvv.fid || $vvv.fid==$_GET.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $goods.fid==$a.fid || $a.fid==$_GET.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>
          </td>
           <td class="vtop tips2" >可以留空,留空则可以稍后在商品管理处手动批量设置栏目</td>
        </tr>


  <tr class="noborder" >
        <td class="td_l">商品分类:</td>
        <td class="vtop rowform">

<select name="postdb[cate]" class="select_fid">
 <option value="0">----请选择分类----</option>
<!--{foreach from=$_G.goods_cate item=vv}-->
 <option value="{$vv.id}" {if $goods.cate == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}" {if $goods.cate == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $goods.cate == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>


          </td>
        <td class="vtop tips2" >可以留空,留空则可以稍后在商品管理处手动批量设置分类</td>
      </tr>

  <tr class="noborder" >
        <td class="td_l">上线时间段:</td>
        <td class="vtop rowform"><input  name="postdb[start_time]" value="{$goods.start_time}" type="text" class="txt _dateline" style="width: 250px;" ></td>
        <td class="vtop tips2" >未到时间,此商品不会在首页及列表页中显示,0或空则不限时间</td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">下线时间段:</td>
        <td class="vtop rowform"><input  name="postdb[end_time]" value="{$goods.end_time}" type="text" class="txt _dateline" style="width: 250px;"  ></td>
        <td class="vtop tips2" >已到时间,则不会显示,0或空则不限时间</td>
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
