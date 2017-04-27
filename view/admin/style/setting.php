{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
       
         <tr class="noborder">
          <td class="td_l">是允许投稿:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[style_status]" value="1" {if $_G.setting.style_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[style_status]" value="0" {if $_G.setting.style_status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">选否,则禁止投稿.</td>
        </tr>
        
         <tr class="noborder">
          <td class="td_l">发布后自动审核:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[style_check]" value="1" {if $_G.setting.style_check==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[style_check]" value="0" {if $_G.setting.style_check==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">前台只能在审核后才能正常浏览</td>
        </tr>
       
         <tr class="noborder">
          <td class="td_l">投稿增加积分:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[style_jf]" value="{$_G.setting.style_jf}" />
            
            </td>
          <td class="vtop tips2">会员投稿是否增加积分,0或空则不加积分</td>
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