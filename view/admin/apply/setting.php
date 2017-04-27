{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
       
         <tr class="noborder">
          <td class="td_l">是否允许商家报名:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[bm]" value="1" {if $_G.setting.bm==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[bm]" value="0" {if $_G.setting.bm==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">商品报名</td>
        </tr>
        
        
<tr class="noborder">
          <td class="td_l">商品报名是否要登录:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[bm_login]" value="1" {if $_G.setting.bm_login==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[bm_login]" value="0" {if $_G.setting.bm_login==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">商品报名是否要登录</td>
        </tr>
        
         <tr class="noborder">
          <td class="td_l">同一卖家报名数量限制:</td>
          <td class="vtop rowform">
            <input class="txt" type="text" name="postdb[apply_max]" value="{$_G.setting.apply_max}" />
            
            </td>
          <td class="vtop tips2">同一卖家大可报名多少个商品,不限制留空或填0即可</td>
        </tr>

        <tr class="noborder" >
          <td class="td_l">卖家黑名单:</td>
          <td class="vtop rowform"><textarea rows="6" name="postdb[bm_black]" cols="70" class="tarea">{$_G.setting.bm_black}</textarea></td>
          <td class="vtop tips2" >填写卖家旺旺昵称,多个用英文逗,号格开,在此黑名单中的商品,则禁止报名</td>
        </tr>
          
        <tr class="noborder" >
          <td class="td_l">报名审核状态:</td>
          <td class="vtop rowform"><textarea rows="6" name="postdb[bm_status_text]" cols="70" class="tarea">{$_G.setting.bm_status_text}</textarea></td>
          <td class="vtop tips2" >如果报名后的商品需要增加状态请按格式填写,大条状态用回车分格开,不需要多审状态请留空,状态ID必须从10开始
          <p>10|一审通过|您提交报名的商口已通过一审,请邮寄商品进行质检,质检通过后会进行二审</p>
          <p>11|二审通过|您提交报名的商口已通过二审,请等待客服排期后上线</p>
          </td>
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