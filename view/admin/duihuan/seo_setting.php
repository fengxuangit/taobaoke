{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
         <tr class="noborder">
              <td class="td_l">seo标题:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[duihuan_seo_tit]" value="{$_G.setting.duihuan_seo_tit}" />
                </td>
              <td class="vtop tips2">列表页SEO标题</td>
      	  </tr>
           <tr class="noborder">
              <td class="td_l">seo关键字:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[duihuan_seo_kw]" value="{$_G.setting.duihuan_seo_kw}" />
                </td>
              <td class="vtop tips2">列表页SEO关键字,多个用英文豆号(,)格开</td>
      	  </tr>
      
       
       <tr class="noborder">
              <td class="td_l">seo描述:</td>
              <td class="vtop rowform">
                <textarea rows="3"  name="postdb[duihuan_seo_desc]"  cols="50" class="tarea">{$_G.setting.duihuan_seo_desc}</textarea>
                </td>
              <td class="vtop tips2">列表页SEO描述</td>
      	  </tr>
      
      


        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
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