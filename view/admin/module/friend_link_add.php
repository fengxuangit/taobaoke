{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">网站名称:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$friend_link.name}" type="text" class="txt"></td>
          <td class="vtop tips2">请输入网站名称</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">网站地址:</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$friend_link.url}" type="text" class="txt"></td>
          <td class="vtop tips2">目标网站地址,必须加http://完整的地址</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$friend_link.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2">越大越靠前</td>
        </tr>

        
        <tr class="noborder">
          <td class="td_l">隐藏:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[hide]" value="1" {if $friend_link.hide==1}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[hide]" value="0" {if $friend_link.hide==0}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>
          
          </td>
          <td class="vtop tips2">选中的话,前台则不显示</td>
        </tr>
        
        
        <tr class="noborder">
          <td class="td_l">图片链接:</td>
          <td class="vtop rowform _hover_img">
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$friend_link.picurl}" type="text" class="txt pic_upload" >
{if $friend_link.picurl}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;

{/if}
</div>
<a href="{$friend_link.picurl}" target="_blank" ><img src="{$friend_link.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          
          </td>
          <td class="vtop tips2">有图片则为图片链,无图片则为文字链</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">其它信息:</td>
          <td class="vtop rowform"><textarea rows="6" name="postdb[content]" cols="70" class="tarea">{$friend_link.content}</textarea></td>
          <td class="vtop tips2">可填入联系方式或其它介绍信息</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel"> 
              <!--{if $_GET.id}-->
              <input type="hidden" name="id" value="{$_GET.id}" />
              <!--{/if}-->
              <input type="submit" class="btn submit_btn" name="onsubmit" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 