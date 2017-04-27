{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>



        
         <tr class="noborder">
          <td class="td_l">连续签到天数:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[qd_days]" value="{$_G.setting.qd_days}" /></td>
          <td class="vtop tips2">连续签到天数,会定义下面连续签到天数数量</td>
        </tr>
        
      
      {foreach from=$sign item=v key =k}
        <tr class="noborder">
          <td class="td_l">连续签到第{$k}天</td>
          <td class="vtop rowform"><input name="qd[{$k}]" value="{$v}" type="text" class="txt"></td>
          <td class="vtop tips2">留空或0则不奖励积分</td>
        </tr>
      {/foreach}

  		 <tr class="noborder">
          <td class="td_l">特别奖励</td>
          <td class="vtop rowform"><textarea rows="6" name="tb" cols="70" class="tarea">{$tb}</textarea></td>
          <td class="vtop tips2">总签到次数到达某一个值时,奖励多少积分(和连续签到无关,属于系统级别)
          <p>格式一行一组(次数=奖励积分数),1=5代表第一次签到奖励5积分,如:</p>
          <p>1=5</p>
          <p>3=10</p>
          <p>5=15</p>
          <p>10=20</p>
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