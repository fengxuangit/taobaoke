{include file="../header.php"}
{if $_G.fid}
<div class="indexmenu2"><div class="indexmenu2d"><div class="cag_headt">
<a href="{$_G.siteurl}">&lt;</a><span> {$_G.channel.name}</span></div></div>
</div>
{/if}
<section class="deals" id="stage">
{foreach from=$goods item=v}
<div class="item_list">
    <a class="imgd _open" data-url="{$v.url}">
        <img width="140" src="{$v.picurl}_250x250.jpg">
        {if $v.new ==1}<i class="mb_ico goodsdpi gisnew1"></i>{/if}
        <span class="goodsisover1"></span>
    </a>
    <h2><span><a class="_open"  data-url="{$v.url}">{$v.title}</a></span></h2>
    <aside>
 {if $v.juan_url}
<a data-url="{$v.juan_url}"  rel="nofollow"  class="y juan_btn _open">领{if $v.juan_price}{$v.juan_price}元{/if}优惠券</a>
{/if}
    ￥<span>{$v.yh_price-$v.juan_price}</span></aside>
   <p> {if $v.price>0}<del>￥{$v.price}</del>{/if}{if $v.zk>0}<cite>{$v.zk}折</cite>{/if}
    {if $v.sum>0}<b class="b1">已售{$v.sum}</b>{/if}</p>
</div>
{/foreach}
</section>

<div class=" redpage cl">
  {$showpage}
</div>

<script type="text/javascript" src="{$JSDIR}/slider.js"></script>
<script type="text/javascript" src="{$JSDIR}/sliderrun.js"></script>
<script type="text/javascript" src="{$JSDIR}/hp.js"></script>
<script type="text/javascript" src="{$JSDIR}/index.js"></script>
{include file="../footer.php"}


