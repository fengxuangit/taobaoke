{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
    <div class="table_top">app首页二级导航设置,最多4个</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
     <input type="hidden" name="size" value="{$size}" class="add_size">
<tbody class="hdp_m">
{foreach from=$hdp item=v key=k}
        <tr class="noborder" > 
                <td class="td_l" style="width:110px">导航{$k+1}:</td>
                  <td class="vtop rowform ">
                       <p>名称:<input name="name[]" value="{$v.name}" type="text" class="txt" ></p>
                       
                       <p style="margin-top:10px;">链接:<input name="url[]" value="{$v.url}" type="text" class="txt" >
                       <a href="" style="margin-left:20px; " class="red del_hdp">删除</a>
                       </p>
                    <div class="cl" style="height:20px"></div>
                  </td>
                  <td>APP二级导航名称,最多可添加4个</td>
        </tr>
{/foreach}
</tbody>   
   
   
      
 <tbody>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
           <input type="button" class="btn add_btn" value="添加">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 