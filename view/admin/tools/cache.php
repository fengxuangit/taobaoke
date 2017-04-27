{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  
  <div class="table_top">更新系统各类设置的缓存</div>
  <div class="table_main">
    <div class="infobox"> <br>
       <input type="checkbox" name="postdb[system_cache]" value="1" class="checkbox" checked="checked" >系统缓存
      &nbsp;&nbsp;
      <input type="checkbox" name="postdb[goods_cache]" value="1" class="checkbox" >所有商品内存缓存
     
      <br>
      <p class="margintop">
        <input type="submit" class="btn submit_btn" name="onsubmit" value="提交">
      </p>
    </div>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 