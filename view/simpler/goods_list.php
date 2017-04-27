
<div class="{if $CM !='goods'}container wp{/if} cl  goods_list ">
<div class="row ">


{foreach from=$goods item=v}

      <div class="col s3 ">
        <div class="card   hvr-grow ">
          {if $v.new ==1}<span class="iconfont icon-new goods_new cyan-text text-lighten-3"></span>{/if}
             <div class="card-image default_bg">
           <!--   <div class="ih-item circle effect13 from_left_and_right"> -->
               <a href="{$v.id_url}" class="width_height">
               <img class="_loading" data-src="{$v.picurl}_300x300.jpg" width="{if $width <= 980}200{elseif $width>1080}300{else}250{/if}" height="{if $width <= 980}200{elseif $width>1080}300{else}250{/if}">

        <!-- <div class="info">
          <div class="info-back">
            <h3>{if $v.new==1}新品上架{elseif $v.sum>999}爆款推荐{else}编辑精选{/if}</h3>
            <p>{if $v.ly}{$v.ly}{else}已售:{$v.sum}{/if}</p>
          </div>
        </div> -->
               </a>

              <!--  </div> -->
             </div>
             <div class="card-content ">
                <a href="{$v.id_url}" class="{if $v.status ==3 || $v.status ==6}grey-text{else}grey-text text-darken-3{/if}">{$v.title}</a>
             </div>
             <div class="card-action">

              {if $v.status==3}
                 <a class="cyan btn right"  href="{$v.id_url}" target="_blank" title="{$v.title}" ><span>{$v.h}点开始</span></a>
              {elseif $v.status==2}
                 <a class="grey btn right"  href="{$v.id_url}" target="_blank" title="{$v.title}" >抢光了</a>
              {else}
                 <a class="cyan lighten-3 btn right" href="{$v.id_url}" target="_blank" title="{$v.title}">
                去购买</a>
              
              {/if}

 {if $v.juan_url}
 <a class="pink accent-2 btn right juan_link"  href="{$v.juan_url}" target="_blank" rel="nofollow">优惠券</a>
{/if}
               <i>￥</i>
               <span class="yh_price {if $v.status ==3 || $v.status ==6}grey-text{else}pink-text text-accent-2{/if}">{$v.yh_price-$v.juan_price}</span>
               {if $width>980 && $v.price >0} <del>￥{$v.price}</del>{/if}
                <span class="sum amber lighten-1">已售:{$v.sum}</span>
             </div>
           </div>
        </div>

{/foreach}

</div>
</div>
<div class="bluepage pagination cl">{$showpage}</div>

