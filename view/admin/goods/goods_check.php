{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">

  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
       
 <tr class="noborder ">
          <td class="td_l">提示:</td>
          <td class="vtop rowform" colspan="2">
          通用是指商品的淘客短链链接为空,也能正常打开商品,但是走淘点金链接.
          一般采集通用商品,或是大淘客,或是插件采集,或是后台->商品采集->规则采集 这类默认都是没有url的,默认都是走淘点金
            <a href="{$URL}m=goods&a=goods_check_start" class="btn" >立即检查</a>
          </td>
       
        </tr>
     


        <tr class="noborder ">
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
          <td class="td_l">商品检测间隔时间:</td>
          <td class="vtop rowform">
            <input class="txt w90" type="text" name="postdb[check_time]" value="{$_G.setting.check_time}" /> 分钟
          </td>
          <td class="vtop tips2">每隔多久检测一次商品(单位:分钟),填0则全都不检测,因要大量操作数据库,时间限定最低为5分钟,根据网站流量和更新商品频繁度,建议5-30分钟左右检测一次</td>
        </tr>


        <tr class="noborder">
          <td class="td_l">检测商品预告:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_start]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_start]" value="0"  > &nbsp;否 </td>
          <td class="vtop tips2">检测商品,是否已到开始时间,已到设定时间,则将商品状态标记为:已上架</td>
        </tr>

<tr class="noborder">
          <td class="td_l">检测商品下架:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_end]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_end]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">检测已上线的商品, 如果优惠活动时间或已结束则将商品标记为:已下架</td>
        </tr>



<tr class="noborder">
          <td class="td_l">优惠券到期:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_quan_end]" value="1" > &nbsp;删除商品
            <input class="radio" type="radio" name="check_list[check_quan_end]" value="0" > &nbsp;清空优惠券
           <!--  <input class="radio" type="radio" name="check_list[check_quan_end]" value="0" > &nbsp;不检查 -->
            </td>
          <td class="vtop tips2">检测已上线的商品, 如果优惠券不存在或已结束则自动删除当前商品:</td>
        </tr>

        
<tr class="noborder">
          <td class="td_l">检测商品url:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_url]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_url]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">检测已上线的商品, 如果没有转换url或url为空,则当前商品是没有转换高佣的商品,将商品标记为:通用
          </td>
        </tr>

<tr class="noborder">
          <td class="td_l">检测商品价格:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_price]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_price]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">防止出现价格混乱,检测已上架的商品的活动价低于优惠券价,则标记为:信息有误</td>
        </tr>


<tr class="noborder">
          <td class="td_l">检测优惠券:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_juan]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_juan]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">检测已上线的商品, 将不存在优惠券的商品状态标记为:无优惠券</td>
        </tr>


<tr class="noborder">
          <td class="td_l">检测二合一:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_ehy]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_ehy]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">检测已上线的商品,将没有二合一券的商品标记为:非二合一,在上方前台可展示商品中如果勾选,则会动态进行转换商品的二合一.已保证站内所有商品有优惠券的全都可用二合一.</td>
        </tr>

<tr class="noborder">
          <td class="td_l">自动转换二合一:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[cover_ehy]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[cover_ehy]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">自动将全站有优惠券的的商品转换成二合一,如果商品是非二合一,则更新状态为:正常上架,如是其它状态则不修改状态
<p class="red">建议为否,这样会动态转换,不做入库.如果设置为是:则会直接将转换结果写入库数据中.</p>
          </td>
        </tr>

<tr class="noborder">
          <td class="td_l">检测佣金比例:</td>
          <td class="vtop rowform">
   <input class="txt w90" type="text" name="postdb[check_bili]" value="{$_G.setting.check_bili}" /> %
             </td>
          <td class="vtop tips2">检测已上架的商品的佣金率低于设定值,标记为:低佣金</td>
        </tr>


<tr class="noborder">
          <td class="td_l">检测商品是否有sid:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_sid]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_sid]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">检测商品是否有sid,原价,昵称,如没有则用淘客接口更新全部
          (如果要生成二合一优惠券则必选),如没有则用淘客接口更新全部(注意必须在后台,采集配置中设定好淘宝客的appkey)</td>
        </tr>


<tr class="noborder">
          <td class="td_l">自动删除下线商品:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[del_end_time]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[del_end_time]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">自动删除已结束活动,或到期下线的商品或优惠券(包括:活动到期,优惠券到期,低佣金,价格有误,卖家下架)</td>
</tr>

<tr class="noborder">
          <td class="td_l">返利订单检测:</td>
          <td class="vtop rowform">
            <input class="radio" type="radio" name="check_list[check_fanli]" value="1" > &nbsp;是
            <input class="radio" type="radio" name="check_list[check_fanli]" value="0" > &nbsp;否 </td>
          <td class="vtop tips2">检测后自动返积分给用户</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">
            <div class="fixsel">
            <div class="hide check_list">{$_G.setting.goods_check}</div>
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