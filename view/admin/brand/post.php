{include file='../common_admin/left_bar.php'}


  <div class="table_main" style="padding-bottom:100px;">

<form enctype="multipart/form-data" method="post">
  <table class="tb tb2 nobdb">
      <tbody>

        <tr class="noborder">
          <td class="td_l">品牌名称:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$brand.name}" type="text" class="txt _keywords"></td>
          <td class="vtop tips2">品牌名称,必填</td>
        </tr>


         <tr class="noborder">
          <td class="td_l">品牌logo:</td>
          <td class="vtop rowform _hover_img">
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$brand.picurl}" type="text" class="txt pic_upload" >
{if $brand.picurl}
<a href=""  class="ajax_del" >删除</a>
{/if}
</div>
<a href="{$brand.picurl}" target="_blank"><img src="{$brand.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>
          <td class="vtop tips2">品牌logo,可空</td>
        </tr>



         <tr class="noborder">
          <td class="td_l">品牌分类:</td>
          <td class="vtop rowform">
          <select name="postdb[cate]">
          <option value="0">----请选择品牌分类----</option>

<!--{foreach from=$_G.brand_cate item=vv}-->
 <option value="{$vv.id}" {if $brand.cate == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}" {if $brand.cate == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $brand.cate == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->


          </select>
          </td>
          <td class="vtop tips2">品牌所属分类</td>
        </tr>


<tr class="td_l noborder">
        <td>推荐:</td>
        <td class="vtop rowform"><ul>


           <li><input class="radio" type="radio" name="postdb[tui]" value="0" {if $brand.tui == "0"}checked="checked"{/if}>
              &nbsp;否</li>
            <li>
              <input class="radio" type="radio" name="postdb[tui]" value="1" {if $brand.tui == "1"}checked="checked"{/if}>
              &nbsp;是</li>
          </li></ul></td>
        <td class="vtop tips2">推荐的品牌会在APP列表中展示</td>
      </tr>

        <tr class="noborder">
          <td class="td_l">排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$brand.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2">越大越靠前</td>
        </tr>


        <tr class="noborder">
          <td class="td_l">品牌描述:</td>
          <td class="vtop rowform" colspan="3">
<textarea rows="5" name="postdb[content]" cols="70" class="textarea _keywords">{$brand.content}</textarea>
          </td>
        </tr>

    
     <tbody>
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
            <input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
  </div>

{include file='../common_admin/right_bar.php'}
