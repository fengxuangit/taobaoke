{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >

  <div class="table_main">
  <table class="tb tb2 nobdb" id="table">
    <tbody>
      <tr>
        <th colspan="12" class="partition">批量加添分类&nbsp;&nbsp; </th>
      </tr>
      <tr class="hover" style="text-align:left">
        <td>&nbsp;</td>
        <td >分类名称或上级分类(手动填写的分类名称和选择的上级分类只填一个,优先手动填写的)</td>
       
        <td >子分类称名(多个用,格开)</td>
        <td >排序</td>
      </tr>
    </tbody>
    <tbody class="row_main">
      <tr class="hover" style="text-align:left">
        <td>&nbsp;</td>
        <td><input type="text" name="fup[]" value="" />
          &nbsp;
          <select name="fup2[]" class="select_id">
           <option value="0">----顶级分类----</option>
<!--{foreach from=$cate item=vv}-->
 <option value="{$vv.id}" {if $_GET.id == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.id}" {if $_GET.id == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub==3}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $_GET.id == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
          </select>
          <input type="hidden" name="tmp[0]" />
          (不填写也不选择,则全为1级分类) </td>

        <td ><input type="text" name="name[]" value=""  style="width:300px"/></td>

        <td ><input type="text" name="sort[]" value=""  style="width:30px"/></td>
      </tr>
    </tbody>
    <tbody>
      <tr>
        <td colspan="3"><div class="fixsel">
            <input type="button" class="btn add_row" value="添加一行">
            <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提 交">
          </div></td>
      </tr>
    </tbody>
  </table>


</div> 
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 