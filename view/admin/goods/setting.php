{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">

  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">商品默认显示条数:</td>
          <td class="vtop rowform">
            <input class="txt w90" type="text" name="postdb[cate_page]" value="{$_G.setting.cate_page}" />
          </td>
          <td class="vtop tips2">商品默认显示条数,不填或0则默认为120</td>
        </tr>



        <tr class="noborder">
          <td class="td_l">显示商品详情页:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="postdb[show_goods]" value="1" {if $_G.setting.show_goods==1}checked="checked" {/if}> &nbsp;是
            <input class="radio" type="radio" name="postdb[show_goods]" value="0" {if $_G.setting.show_goods==0}checked="checked" {/if}> &nbsp;否 </td>
          <td class="vtop tips2">开启前请确定您已开发了详情页模板,未开启的话,则不会采集商品详情,因这个比较占数据库</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">前台可展示的商品:</td>
          <td class="vtop rowform">
            <input type="hidden"  class="goods_filter_text" value="{$_G.setting.goods_filter}"> 
            {foreach from=$_G.setting.goods_status item=v key=k}
            <label  {if $k==1} redonly{/if} for="{$v}">{$v}<input type="checkbox"  name="goods_filter[{$k}]" class="checkbox goods_filter" value="{$k}" />
            </label>&nbsp; {/foreach}
          </td>
          <td class="vtop tips2">
          选中的才会在网站中展示,不选中的会过滤掉,正常上架是必选,其它都可不必选择
<p>通用其实是可以选中的,因为他是等待转换高佣链接(定向或鹊桥),没有转换的商品,如果有优惠券则走鹊桥二合一,没券则走淘点金</p>
<p>根据各站长使用情况不同,推荐以下组合进行筛选</p>
<p>强制全站走高佣+优惠券:&nbsp;&nbsp;&nbsp;&nbsp;正常上架,非二合一</p>
<p>强制全站走高佣:&nbsp;&nbsp;&nbsp;&nbsp;正常上架,无优惠券,非二合一</p>
<p>强制全站优惠券:&nbsp;&nbsp;&nbsp;&nbsp;通用,正常上架,预告商品,非二合一</p>
<p>无佣金及优惠券要求:&nbsp;&nbsp;&nbsp;&nbsp;通用,正常上架,预告商品,无优惠券,非二合一,低佣金</p>
          </td>

        </tr>

        <tr class="noborder">
          <td class="td_l">商品排序规则:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="postdb[goods_sort]" value="1" {if $_G.setting.goods_sort==1}checked="checked" {/if}> &nbsp;手动排序
            <input class="radio" type="radio" name="postdb[goods_sort]" value="0" {if $_G.setting.goods_sort==0}checked="checked" {/if}> &nbsp;时间排序 </td>
          <td class="vtop tips2">手动排序是指您随机打乱商品的排序,越大越前,时间是指发布时间的降序来展示,最通用在前面</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">今日新品展示方式:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="postdb[today_type]" value="0" {if $_G.setting.today_type==0}checked="checked" {/if}> &nbsp;上线时间
            <input class="radio" type="radio" name="postdb[today_type]" value="1" {if $_G.setting.today_type==1}checked="checked" {/if}> &nbsp;发布时间 </td>
          <td class="vtop tips2">
            今日新品按上线时间是当天,或是发布时间是当天来展示
          </td>
        </tr>


        <tr class="noborder">
          <td class="td_l">默认上线时间:</td>
          <td class="vtop rowform">
            +
            <input class="txt w90" type="text" name="postdb[start_day]" value="{$_G.setting.start_day}" />天&nbsp;&nbsp;
            <input class="txt w90" type="text" name="postdb[start_hour]" value="{$_G.setting.start_hour}" />点
          </td>
          <td class="vtop tips2">
            <p>发布商品时,默认的上线时间+多少天(默认为当天),+0就是当天,+1就是明天,以此类加</p>
            <p>?点,一般是9点或是10点(具体可以修改后,点击 添加商品,找到上线时间段进行测试)</p>
          </td>
        </tr>



        <tr class="noborder">
          <td class="td_l">商品上线天数:</td>
          <td class="vtop rowform">
            <input class="txt w90" type="text" name="postdb[end_day]" value="{$_G.setting.end_day}" />
          </td>
          <td class="vtop tips2">以开始时间为起点,加多少天,如上线5天后自动下架则填5,7天后下架就填7</td>
        </tr>


        <tr>
          <td>&nbsp;</td>
          <td colspan="2">
            <div class="fixsel">
              <input type="submit" class="btn submit_btn" name="onsubmit" value="提交">
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <input type="hidden" name="m" value="{$CURMODULE}" />
  <input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}