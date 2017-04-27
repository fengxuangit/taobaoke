{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        
        <tr>
          <td colspan="2" class="td27">后台显示名称:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="postdb[name]" value="{$type.name}" type="text" class="txt"></td>
          <td class="vtop tips2">必填,供后台添加幻灯片区分选择,中英文均可</td>
        </tr>
		<tr>
          <td colspan="2" class="td27">前台显示信息:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform">
          <textarea rows="6" name="postdb[content]" cols="70" class="tarea">{$type.content}</textarea>
          </td>
          <td class="vtop tips2">可空,如前台有需要时可填写并调用.支持HTML</td>
        </tr>


        <tr>
         
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