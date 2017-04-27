{include file="../header.php"}

<div class="container wp goods_detial wp_{$width}">

  <div class="row white ">

    <div class="col m5">
     <!--  <a href="{$data.url}" target="_blank" rel="nofollow">
      <img src="{$data.picurl}_500x500.jpg" width="500" height="500" class="responsive-img" ></a> -->

<!-- normal -->
    <div class="goods_em ih-item circle effect10 top_to_bottom grey lighten-5" data-images="{implode(',',$data.images)}">
    <a  href="{$data.url}" target="_blank" rel="nofollow">
        <div class="img"><img src="{$data.picurl}{if $width>1280}_800x800.jpg{else}_500x500.jpg{/if}"></div>
        <div class="info" >
          <h3>{if $data.new==1}新品上架{elseif $data.sum>999}爆款推荐{else}编辑精选{/if}</h3>
          {if $data.start_time>0 || $data.end_time>0}
          <p>{if $data.start_time>0}上线时间: 
          <span class="_dgmdate" data-time="{$data.start_time}"  data-type="m/d H:i"></span> ~~ {/if}{if $data.end_time>0}下线时间:
          <span class="_dgmdate" data-time="{$data.end_time}"  data-type="m/d H:i"></span>{/if}</p>
          {else}
         <p>卖家: {$data.nick} 已售: {$data.sum}</p>
          {/if}
        </div>
     </a>
</div>
<!-- end normal -->


    </div>
    <div class="col m7 relative">
    <span class="iconfont icon-tryiconew detial_new right cyan-text text-lighten-1 waves-effect waves-light"  ></span>
    <br/>
      <h5 class="grey-text text-darken-1 goods_title">{$data.title}</h5>
      <blockquote class="grey-text">{$data.ly}</blockquote>

<table>
      <tbody>
        <tr>
          <td class="goods_price">

{if $data.shop_type==1}
  <span class="iconfont icon-tianmao red-text text-accent-4 f20 tooltipped" data-position="top" data-tooltip="商品来源于天猫"></span>
  {else}
  <span class="iconfont icon-taobaotese deep-orange-text f20 tooltipped" data-position="top" data-tooltip="商品来源于淘宝"></span>
{/if}
            <span class="red-text text-darken-1"><i>￥</i>{$data.yh_price-$data.juan_price}</span>
          {if $data.price>0}<del>原价:￥{$data.price}</del>{/if}
          </td>
        </tr>
    <tr>
      <td>
      {if $data.juan_url}
       <a class="waves-effect waves-light btn-large tooltipped pink accent-2 pay_btn " href="{$data.juan_url}" target="_blank" rel="nofollow" data-delay="50" data-tooltip="当前商品可领取{if $data.juan_price} {$data.juan_price}元 {/if}优惠券后再下单">
               <i class="iconfont icon-liquan left goods_juan"></i>领券下单{if $data.juan_price}{$data.yh_price-$data.juan_price}元{/if}</a>
      {/if}
       <!--   <a class="waves-effect waves-light btn-large cyan lighten-3 pay_btn" href="{$data.url}" target="_blank" rel="nofollow">
      去购买</a> -->
         <!-- <i class="iconfont {if $data.shop_type==1}icon-taobaotese red-text text-accent-4 {else}icon-taobaotese deep-orange-text{/if} right"></i> -->
      </td>
    </tr>

<tr>   <td>&nbsp;</td></tr>
    <tr>
      <td>
      分享到:
        <div class="_share" data-style="2" data-more="0" data-count="0" data-picurl="{$data.picurl}" data-title="{$data.title}" ></div>

      </td>
    </tr>

     <tr>
      <td>
        <span class="iconfont icon-jubao"></span>
        本商品支持七天无理由退货,请放心购买

      </td>
    </tr>

      </tbody>
    </table>

    </div>
  </div>





<div class="row">
        <div class="">
        <ul class="tabs">
          {if $data.message}
               <li class="tab col s3"><a href="#detial_tab_1">商品详情</a></li>
          {/if}
                <li class="tab col s3"><a href="#detial_tab_2">同类推荐</a></li>
                <li class="tab col s3"><a href="#detial_tab_3">评论列表</a></li>
                <li class="tab col s3"><a href="#detial_tab_4">我要评论</a></li>
          </ul>
         </div>

         {if $data.message}
          <div id="detial_tab_1" class="white">
              <div class="pd30">{$data.message}</div>
          </div>
         {/if}

          <div id="detial_tab_2" >
              {include file="../goods_list.php"}
        </div>

          <div id="detial_tab_3" class="white">

                <div class="comment_list" data-num_iid="{$data.num_iid}">
                   <ul class="collection"></ul>
                </div>

          </div>

          <div id="detial_tab_4" class="white">
              <div class="pd30">
                    <div class="_duoshuo" data-id="{$data.num_iid}"></div>
              </div>
          </div>

  </div>

</div>





{include file="../footer.php"}
