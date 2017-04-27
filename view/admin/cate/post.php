{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  >

<!--{if $_GET.id}--> 
<div class="table_top">
<a href="index.php?m=cate&id={$_GET.id}" target="_blank">前台查看</a>&nbsp;&nbsp;
 <a href="{$URL}m=goods&a=post&id={$_GET.id}">发布商品</a> 
 </div>
<!--{/if}--> 
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>        
        <tr class="noborder" >
          <td class="td_l">分类名称:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$cate.name}" type="text" class="txt"></td>
          <td class="vtop tips2" >必填</td>
        </tr>
        
        <tr class="noborder" >
        <td class="td_l">上级分类:</td>
        <td class="vtop rowform"><select name="postdb[fup]" class="select_fid"> 
 <option value="0">----请选择分类----</option>
<!--{foreach from=$cate_list item=vv}-->
 <option value="{$vv.id}" {if $cate.fup >0 && $cate.fup == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
       <option value="{$vvv.id}" {if  $cate.fup >0 && $cate.fup == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $cate.fup >0 &&  $cate.fup == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
</select></td>
       <td class="vtop tips2" >文章分类,可给文章分组或做分类标记</td>
      </tr>
      
      
        <tr class="noborder" >
          <td class="td_l">分类图片:</td>
          <td class="vtop rowform _hover_img">
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$cate.picurl}" type="text" class="txt pic_upload" >
{if $cate.picurl}
<a class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div> 
<a href="{$cate.picurl}" target="_blank" ><img src="{$cate.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          
          </td>
          <td class="vtop tips2" >可给当前分类设置独立的banner</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">图片链接</td>
          <td class="vtop rowform"><input name="postdb[pic_url]" value="{$cate.pic_url}" type="text" class="txt"></td>
          <td class="vtop tips2" >如果填了分类图片,可给它加个链接,如果没有图片,则无须添加</td>
        </tr>
        
         <tr class="noborder" >
          <td class="td_l">跳转地址</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$cate.url}" type="text" class="txt"></td>
          <td class="vtop tips2" >可空</td>
        </tr>
        
        
        <tr class="noborder" >
          <td class="td_l">隐藏分类:</td>
          <td class="vtop rowform"><ul>
              <li >
                <input class="radio" type="radio" name="postdb[hide]" value="1" {if $cate.hide==1} checked="checked"{/if} >
                &nbsp;是</li>
              <li>
                <input class="radio" type="radio" name="postdb[hide]" value="0" {if $cate.hide==0} checked="checked"{/if}>
                &nbsp;否</li>
            </ul></td>
          <td class="vtop tips2" >隐藏后只有后台可见</td>
        </tr>

        <tr class="noborder" >
          <td class="td_l">分类排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$cate.sort}" type="text" class="txt"></td>
          <td class="vtop tips2" >越大越靠前</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">分类模板:</td>
          <td class="vtop rowform"><input name="postdb[tpl]" value="{$cate.tpl}" type="text" class="txt"></td>
          <td class="vtop tips2" >当前分类使用的模板,如不填,默认使用cate.php(如要使用 当前模板目录下的/main.php,则只填main就行)</td>
        </tr>

        <tr class="noborder" >
          <td class="td_l">分类分页大小:</td>
          <td class="vtop rowform"><input name="postdb[page]" value="{$cate.page}" type="text" class="txt"></td>
          <td class="vtop tips2" >列表页分页大小,默认为20条</td>
        </tr>
         <tr class="noborder" >
          <td class="td_l">seo title:</td>
          <td class="vtop rowform">
          <input name="postdb[title]" value="{$cate.title}" type="text" class="txt">
          </td>
          <td class="vtop tips2" >seo的标题,便于搜索引擎收录</td>
        </tr>
        
         <tr class="noborder" >
          <td class="td_l">seo keywords:</td>
          <td class="vtop rowform">
          <input name="postdb[keywords]" value="{$cate.keywords}" type="text" class="txt _in_keywords">
          </td>
          <td class="vtop tips2" >seo的关键字,便于搜索引擎收录,多个用,分格开</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">seo description:</td>
          <td class="vtop rowform"><textarea rows="3"  name="postdb[description]"  cols="50" class="tarea">{$cate.description}</textarea></td>
          <td class="vtop tips2" >seo的描述,便于搜索引擎收录,120字内</td>
        </tr>
        
        
         <tr class="noborder" >
        	 <td class="td_l">分类内容:</td>
           <td class="vtop rowform" colspan="3">
<div class="kg_editorContainer"  data-config='{
"width":"900","height":"400"
        }'>
<textarea rows="6" name="postdb[content]" cols="70" class="ks-editor-textarea" id = "web_editor">{$cate.content}</textarea></div>
           </td>
        </tr>
        <tr class="noborder" >
          <td colspan="3"><div class="fixsel">
          {if $_GET.id}
                <input type="hidden" name="id" value="{$_GET.id}" />
           {/if}
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改"></div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 