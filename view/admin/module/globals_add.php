{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="td27" ><div class="cl">提示:在任何模板中可通过($_G.globals.变量名称)调用此处添加的内容</div></td>
        </tr>
        <tr>
          <td colspan="2" class="td27" >变量描述:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="postdb[title]" value="{$globals.title}"  type="text" class="txt"></td>
          <td class="vtop tips2" >可中文,供后台管理查看</td>
        </tr>
        
        <tr>
          <td colspan="2" class="td27" >变量名称:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="postdb[name]" value="{$globals.name}"  type="text" class="txt"></td>
          <td class="vtop tips2" >变量名必须唯一,不能为中文且只能为_或英文开头的数字和字母和_组合,最少两位,也不能和之前添加的重复</td>
        </tr>
        
         <tr>
          <td colspan="2" class="td27" >类型:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"> <input type="radio"  value="0" name="postdb[html]"  class="radio global_radio" {if $globals.html!=1} checked="checked" {/if}/>纯文本&nbsp;&nbsp;
           <input type="radio"  value="1" class="radio global_radio" name="postdb[html]" {if $globals.html==1} checked="checked"{/if}/>HTML
          </td>
          <td class="vtop tips2" >&nbsp;</td>
        </tr>
                
        <tr>
          <td colspan="2" class="td27">变量值:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform" colspan="2">


<div class="show_globals hide" {if $globals.html==1} style="display:block;"{/if}>
<div class="kg_editorContainer"  data-config='{
"width":"900","height":"300"
        }'>
<textarea rows="6" name="value_html" cols="70" class="ks-editor-textarea" id = "web_editor">{$globals.value}</textarea></div>
</div>


<div class="show_globals hide" {if $globals.html!=1} style="display:block;"{/if}>
          <textarea rows="6" name="postdb[value]" cols="70" class="tarea">{$globals.value}</textarea>
</div>

          
          </td>
          <td class="vtop tips2" >变量值,任意代码或文字都可以</td>
        </tr>
      
        <td colspan="3"><div class="fixsel"> {if $_GET.id}
            <input type="hidden" name="id" value="{$_GET.id}" />
            {/if}
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