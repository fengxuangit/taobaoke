{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
         <tr class="noborder">
              <td class="td_l">9块9seo标题:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[jk9_seo_tit]" value="{$_G.setting.jk9_seo_tit}" />
                </td>
              <td class="vtop tips2">9块9列表页SEO标题</td>
      	  </tr>
           <tr class="noborder">
              <td class="td_l">9块9seo关键字:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[jk9_seo_kw]" value="{$_G.setting.jk9_seo_kw}" />
                </td>
              <td class="vtop tips2">9块9列表页SEO关键字,多个用英文豆号(,)格开</td>
      	  </tr>
      
       
       <tr class="noborder">
              <td class="td_l">9块9seo描述:</td>
              <td class="vtop rowform">
                <textarea rows="3"  name="postdb[jk9_seo_desc]"  cols="50" class="tarea">{$_G.setting.jk9_seo_desc}</textarea>
                </td>
              <td class="vtop tips2">9块9列表页SEO描述</td>
      	  </tr>
      
        <tr class="noborder">
              <td class="td_l">&nbsp;</td>
              <td class="vtop rowform">&nbsp;
               
                </td>
              <td class="vtop tips2">&nbsp;</td>
      	  </tr>
      


 <tr class="noborder">
              <td class="td_l">19块9seo标题:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[sjk9_seo_tit]" value="{$_G.setting.sjk9_seo_tit}" />
                </td>
              <td class="vtop tips2">19块9列表页SEO标题</td>
      	  </tr>
           <tr class="noborder">
              <td class="td_l">19块9seo关键字:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[sjk9_seo_kw]" value="{$_G.setting.sjk9_seo_kw}" />
                </td>
              <td class="vtop tips2">19块9列表页SEO关键字,多个用英文豆号(,)格开</td>
      	  </tr>
      
       
       <tr class="noborder">
              <td class="td_l">19块9seo描述:</td>
              <td class="vtop rowform">
                <textarea rows="3"  name="postdb[sjk9_seo_desc]"  cols="50" class="tarea">{$_G.setting.sjk9_seo_desc}</textarea>
                </td>
              <td class="vtop tips2">19块9列表页SEO描述</td>
      	  </tr>
      
       <tr class="noborder">
              <td class="td_l">&nbsp;</td>
              <td class="vtop rowform">&nbsp;
               
                </td>
              <td class="vtop tips2">&nbsp;</td>
      	  </tr>
      
		 <tr class="noborder">
              <td class="td_l">今日新品seo标题:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[today_seo_tit]" value="{$_G.setting.today_seo_tit}" />
                </td>
              <td class="vtop tips2">今日新品列表页SEO标题</td>
      	  </tr>
           <tr class="noborder">
              <td class="td_l">今日新品seo关键字:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[today_seo_kw]" value="{$_G.setting.today_seo_kw}" />
                </td>
              <td class="vtop tips2">今日新品列表页SEO关键字,多个用英文豆号(,)格开</td>
      	  </tr>
      
       
       <tr class="noborder">
              <td class="td_l">今日新品seo描述:</td>
              <td class="vtop rowform">
                <textarea rows="3"  name="postdb[today_seo_desc]"  cols="50" class="tarea">{$_G.setting.today_seo_desc}</textarea>
                </td>
              <td class="vtop tips2">今日新品列表页SEO描述</td>
      	  </tr>
          
          
          
      	 <tr class="noborder">
              <td class="td_l">&nbsp;</td>
              <td class="vtop rowform">&nbsp;</td>
              <td class="vtop tips2">&nbsp;</td>
      	  </tr>
		 <tr class="noborder">
              <td class="td_l">明日预告seo标题:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[tomorrow_seo_tit]" value="{$_G.setting.tomorrow_seo_tit}" />
                </td>
              <td class="vtop tips2">明日预告列表页SEO标题</td>
      	  </tr>
           <tr class="noborder">
              <td class="td_l">明日预告seo关键字:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[tomorrow_seo_kw]" value="{$_G.setting.tomorrow_seo_kw}" />
                </td>
              <td class="vtop tips2">明日预告列表页SEO关键字,多个用英文豆号(,)格开</td>
      	  </tr>
      	 <tr class="noborder">
              <td class="td_l">明日预告seo描述:</td>
              <td class="vtop rowform">
                <textarea rows="3"  name="postdb[tomorrow_seo_desc]"  cols="50" class="tarea">{$_G.setting.tomorrow_seo_desc}</textarea>
                </td>
              <td class="vtop tips2">明日预告列表页SEO描述</td>
      	  </tr>
          
          
          


      	 <tr class="noborder">
              <td class="td_l">&nbsp;</td>
              <td class="vtop rowform">&nbsp;</td>
              <td class="vtop tips2">&nbsp;</td>
      	  </tr>
		 <tr class="noborder">
              <td class="td_l">全部商品seo标题:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[all_seo_tit]" value="{$_G.setting.all_seo_tit}" />
                </td>
              <td class="vtop tips2">全部商品列表SEO标题</td>
      	  </tr>
           <tr class="noborder">
              <td class="td_l">全部商品seo关键字:</td>
              <td class="vtop rowform">
                <input class="txt " type="text" name="postdb[all_seo_kw]" value="{$_G.setting.all_seo_kw}" />
                </td>
              <td class="vtop tips2">全部商品列表页SEO关键字,多个用英文豆号(,)格开</td>
      	  </tr>
      	 <tr class="noborder">
              <td class="td_l">全部商品seo描述:</td>
              <td class="vtop rowform">
                <textarea rows="3"  name="postdb[all_seo_desc]"  cols="50" class="tarea">{$_G.setting.all_seo_desc}</textarea>
                </td>
              <td class="vtop tips2">明日预告列表页SEO描述</td>
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