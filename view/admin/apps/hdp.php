{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  <div class="table_top">app首页幻灯片设置</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">

     <input type="hidden" name="size" value="{$size}" class="add_size">
<tbody class="hdp_m">
{foreach from=$hdp item=v key=k}
        <tr class="noborder" > 
                <td class="td_l" style="width:110px">幻灯片{$k+1}:</td>
                  <td class="vtop rowform " colspan="2">
                  <div class="cl">
                    <div class="z _hover_img" style="width:360px;"  data-left="300">
                  
                   图片地址:<input name="picurl[]" value="{$v.picurl}" type="text" class="txt"  style="margin-bottom:10px;">
                   
                   链接地址:<input name="url[]" value="{$v.url}" type="text" class="txt" >
                   
                   显示标题:<input name="title[]" value="{$v.title}" type="text" class="txt" >
                  
                     <a href="{$v.picurl}" target="_blank"  ><img src="{$v.picurl}"  /></a>
                   </div>
                   <div class="z">
                      <input type="file" name="file{$k}" class="file" style="width:180px;"/><a href="" style="margin-left:20px; " class="red del_hdp">删除</a>
                  </div>
               </div>
                    <div class="cl" style="height:20px"></div>
                  </td>
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