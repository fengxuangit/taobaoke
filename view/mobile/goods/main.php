{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/goods.css" media="all" />
<div class="guide guide-platform-2"></div>

<div id="mobileBlock cl">
<div class="share-list">
<div class="goods">
    <div class="goodsItemImg">
        <img class="img" src="{$goods.picurl}">
    </div>
    <div class="goods-content">{$goods.title}</div>

    <div class="cl goods_bt">
            <a href="{$goods.url}" target="_blank" class="y pay_btn">去购买</a>
            <div class="goods-price z"><span>¥</span>{$goods.yh_price}</div>

{if $goods.juan_url}
<a href="{$goods.juan_url}"  rel="nofollow" target="_blank" class="y juan_btn2">领{if $goods.juan_price}{$goods.juan_price}元{/if}优惠券</a>
{else}
  <div class="goods_oprice z">原价: <del>{$goods.price}</del></div>
{/if}
          

    </div>

    </div>
    </div>
</div>


{include file="../footer.php"}


