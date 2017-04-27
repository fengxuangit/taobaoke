{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
       
         <tr class="noborder">
          <td class="td_l">全局是否允许评论:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[say_status]" value="1" {if $_G.setting.say_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[say_status]" value="0" {if $_G.setting.say_status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">选否,则所有模块,全不能评论.</td>
        </tr>
        
       
         <tr class="noborder">
          <td class="td_l">评论后自动审核:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[comment_check]" value="1" {if $_G.setting.comment_check==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[comment_check]" value="0" {if $_G.setting.comment_check==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">前台只能在审核后才能正常浏览</td>
        </tr>
        
          <tr class="noborder">
          <td class="td_l">是否开启HTML回复:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[comment_filter]" value="1" {if $_G.setting.comment_filter==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[comment_filter]" value="0" {if $_G.setting.comment_filter==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">开始HTML回复,会降低安全性.一般情况下建议关闭,默认为否</td>
        </tr>
        
         <tr class="noborder">
          <td class="td_l">评论增加积分:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[comment_jf]" value="{$_G.setting.comment_jf}" />
            
            </td>
          <td class="vtop tips2">会员评论是否增加积分,0或空则不加积分</td>
        </tr>
        
               
          <tr class="noborder">
          <td class="td_l">列表分页大小:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[comment_page_size]" value="{$_G.setting.comment_page_size}" />
            
            </td>
          <td class="vtop tips2">评论列表每页数量,默认为10条</td>
        </tr>
         
        <tr class="noborder">
          <td class="td_l">同用户同日同模块限制:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[comment_day]" value="{$_G.setting.comment_day}" />
            
            </td>
          <td class="vtop tips2">同一会员,同一模块,同一日,最多少评论数,默认30条(模块是指 文章,商品,兑换,试用)</td>
        </tr>
       <tr class="noborder">
          <td class="td_l">同用户同月同模块限制:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[comment_month_mod]" value="{$_G.setting.comment_month_mod}" />
            
            </td>
          <td class="vtop tips2">同一会员,同一模块,同一月,最多少评论数,默认300条(模块是指 文章,商品,兑换,试用)</td>
        </tr>
         
         <tr class="noborder">
          <td class="td_l">每月共评论数:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[comment_month_sum]" value="{$_G.setting.comment_month_sum}" />
            
            </td>
          <td class="vtop tips2">同一会员,每月最多少评论数,默认1000条</td>
        </tr>
          <tr class="noborder">
          <td class="td_l">评论提示:</td>
          <td class="vtop rowform">
            <input class="txt " type="text" name="postdb[comment_msg]" value="{$_G.setting.comment_msg}" />
            
            </td>
          <td class="vtop tips2">提示显示在评论框的发言按钮右侧</td>
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