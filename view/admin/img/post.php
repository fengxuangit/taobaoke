{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">标题:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="{$img.title}" type="text" class="txt _keywords"></td>
          <td class="vtop tips2" >必填 {if $_GET.id} <a href="/index.php?m=img&id={$img.id}" target="_blank">前台查看当前值得买</a> {/if}</td>
        </tr>
        
        
        <tr class="noborder" >
          <td class="td_l">缩略图:</td>
          <td class="vtop rowform _hover_img">
          
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$img.picurl}" type="text" class="txt pic_upload" >
{if $img.picurl}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div>
<a href="{$img.picurl}" target="_blank" ><img src="{$img.picurl}"  /></a>

<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />

 <!--<input name="postdb[picurl]" value="{$img.picurl}" type="text" class="txt upload_btn">-->
 
          </td>
          <td class="vtop tips2" >可给当前设置独立的缩略图</td>
        </tr>
        

         <tr class="noborder">
          <td class="td_l">分类:</td>
          <td class="vtop rowform">
          <select name="postdb[cate]">
          <option value="0">----请选择分类----</option>
        
<!--{foreach from=$_G.img_cate item=vv}-->
 <option value="{$vv.id}" {if $img.cate == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}" {if $img.cate == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $img.cate == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->

          
          </select> 
          </td>
          <td class="vtop tips2">所属分类</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">隐藏:</td>
          <td class="vtop rowform"><ul>
              <li >
                <input class="radio" type="radio" name="postdb[hide]" value="1" {if $img.hide==1} checked="checked"{/if} >
                &nbsp;是</li>
              <li>
                <input class="radio" type="radio" name="postdb[hide]" value="0" {if $img.hide==0} checked="checked"{/if}>
                &nbsp;否</li>
            </ul></td>
          <td class="vtop tips2" >在前台调用时“不显示”,但用户通过ID访问则可直接打开</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$img.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2" >越大越靠前</td>
        </tr>
       <tr class="noborder" >
          <td class="td_l">喜欢/踩:</td>
          <td class="vtop rowform"><input name="postdb[like]" value="{$img.like}" type="text" class="txt w90">
          &nbsp;&nbsp;
          <input name="postdb[hate]" value="{$img.hate}" type="text" class="txt w90">
          </td>
          <td class="vtop tips2" >喜欢/踩</td>
        </tr>
        
           
        
         <tr class="noborder" >
          <td class="td_l">跳转url:</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$img.url}" type="text" class="txt"></td>
          <td class="vtop tips2" >可空.可填写当前值得买跳转的链接地址,如跳转到帮派或淘宝论坛等地址..</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">来源站点名称:</td>
          <td class="vtop rowform"><input name="postdb[from_name]" value="{$img.from_name}" type="text" class="txt"></td>
          <td class="vtop tips2" >可空.来源站点名称</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">来源页面:</td>
          <td class="vtop rowform"><input name="postdb[from_url]" value="{$img.from_url}" type="text" class="txt"></td>
          <td class="vtop tips2" >可空.来源页面</td>
        </tr>
        
          <tr class="noborder" >
          <td class="td_l">SEO关键字:</td>
          <td class="vtop rowform"><input name="postdb[keywords]" value="{$img.keywords}" type="text" class="txt _in_keywords"></td>
          <td class="vtop tips2" >可空.SEO优化才会用到,多少个,格开.在U站内一般用不到,站外才会用到</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">SEO描述:</td>
          <td class="vtop rowform">
           <textarea rows="3" name="postdb[description]" cols="50" class="textarea">{$img.description}</textarea>
          </td>
          <td class="vtop tips2" >可空.SEO描述,200字内,不填或空则会默认截取值得买内容前200字.在U站内一般用不到,站外才会用到</td>
        </tr>
       
        
        
        <tr class="noborder" >
          <td class="td_l">内容:</td>
          <td class="vtop rowform" colspan="3"><div class="kg_editorContainer"  data-config='{
          "width":"1100","height":"500"
        }'>
              <textarea rows="6" name="postdb[message]" cols="70" class="ks-editor-textarea _keywords" id = "web_editor" >{$img.message}</textarea>
            </div>
            
            </td>
        </tr>
        <tr class="noborder" >
        <td class="td_l">&nbsp;</td>
          <td class="vtop rowform" colspan="3"><div class="fixsel"> {if $_GET.id}
              <input type="hidden" name="id" value="{$_GET.id}" />
              {/if}
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 