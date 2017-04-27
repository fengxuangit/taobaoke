{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">

  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>

<tr class="noborder">
          <td class="td_l">使用方法:</td>
          <td class="vtop rowform" >
            <p>1,先进入<a href="http://www.dataoke.com/quan_list/" target="_blank">大淘客优惠券列表页</a>,将商品点击"加入推广"加入到用户中心</p>
            <p>2,在此处点击立即更新,可手动同步或采集数据</p>
            <p>3,设定好Appkey和缓存时间,即可开启自动同步优惠券信息</p>
          </td>
            <td class="vtop tips2 "><div class="btn" style="width:60px;line-height: 34px;">
            <a href="{$URL}m=goods&a=update_quan" target="_blank"  style="margin: 0;color: #fff;text-decoration: none;">立即更新</a></div></td>
        </tr>
  
      <tr class="noborder hide">
          <td class="td_l">同步接口类型:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[syn_quan_type]" value="0" {if $_G.setting.syn_quan_type==0}checked="checked"{/if}>
            &nbsp;同步接口
            <input class="radio" type="radio" name="postdb[syn_quan_type]" value="1" {if $_G.setting.syn_quan_type==1}checked="checked"{/if}>
            &nbsp;全站接口 </td>
          <td class="vtop tips2">
<p>同步接口是指在大淘客网站将商品加入到个人中心,接口再去同步这些数据.</p>
<p>全站接口是直接将大淘客的商品全部获取来.</p>
<p>推荐使用同步接口(全站接口比较慢,而且商品多非常占内存,频繁大量操作数据库有可能导至数据库压力过大)</p>


          </td>
        </tr>


      <tr class="noborder" >
          <td class="td_l">大淘客接口appKey:</td>
          <td class="vtop rowform"><input name="postdb[dataoke_appkey]" value="{$_G.setting.dataoke_appkey}" type="text" class="txt" ></td>
          <td class="vtop tips2">同步领取优惠券商品的接口 <a href="http://www.dataoke.com/ucenter/appkey_apply.asp" target="_blank">立即采集</a></td>
        </tr>



 <tr class="noborder" >
          <td class="td_l">自动同步栏目:</td>
          <td class="vtop rowform">

  <div class="cl">
  <span style="width:197px;display: block;float:left;">大淘客分类</span>
  <span>网站栏目</span>
</div>

 {foreach from=$dataoke item=v1 key=k1}
      <select disabled="disabled"  class="select" style="width:156px;margin-bottom: 5px;" >
         <option>{$v1}</option>
      </select>

      <select name="web_cate[{$k1}]"  class="select" style="width:156px;margin-bottom: 5px;" >
      <option value="0">--选择对应网站栏目--</option>
        {foreach from=$_G.channels item=v}
         <option value="{$v.fid}" {if $_G.setting.dataoke_cate[$k1] == $v.fid} selected {/if}>{$v.name}</option>
         {/foreach}

      </select>
{/foreach}

          </td>
          <td class="vtop tips2" >设置好分类,在自动采集时就会自动给商品分配栏目</td>
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
