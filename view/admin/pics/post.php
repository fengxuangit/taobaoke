{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">标题:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="{$pics.title}" type="text" class="txt"></td>
          <td class="vtop tips2">显示标题,可不填</td>
        </tr>
        
		 <tr class="noborder">
          <td class="td_l">所属分类:</td>
          <td class="vtop rowform">
          <select name="postdb[fup]">
            <!--{foreach from=$_G.pics_type item=v}--> 
         <option value="{$v.id}" {if $pics.fup && $pics.fup == $v.id} selected="selected" {/if} >{$v.name}</option>
          <!--{/foreach}-->
          </select> 
          </td>
          <td class="vtop tips2">所属分类</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$pics.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2">越大越靠前</td>
        </tr>

        
        
        <tr class="noborder">
          <td class="td_l">隐藏:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[hide]" value="1" {if $pics.hide==1}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[hide]" value="0" {if $pics.hide==0}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>
          
          </td>
          <td class="vtop tips2">选中的话,前台则不显示</td>
        </tr>
        
        
        <tr class="noborder">
          <td class="td_l">图片地址:</td>
          <td class="vtop rowform _hover_img">
          
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$pics.picurl}" type="text" class="txt pic_upload" >
{if $pics.picurl}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div>
<a href="{$pics.picurl}" target="_blank"><img src="{$pics.picurl}"  /></a>

<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>

          <td class="vtop tips2">幻灯片的图片地址</td>
        </tr>
		 <tr class="noborder">
          <td class="td_l">链接地址:</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$pics.url}" type="text" class="txt"></td>
          <td class="vtop tips2">图片链接跳转地址</td>
        </tr>
        
        
        <tr class="noborder">
        <td class="td_l">描述内容:</td>
        <td class="vtop rowform">
     <!--   <div class="kg_editorContainer"  data-config='{
        "width":"900"
        }'>-->
        
        <textarea rows="4" name="postdb[content]" cols="50" > {$pics.content}</textarea>
        <!--</div>-->
        
        </td>
        <td class="vtop tips2"></td>
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