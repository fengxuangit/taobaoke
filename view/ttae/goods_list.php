  <div class="i2_goodscond ">
        <ul class="i2_goodsul">

         {foreach from=$goods item=v}
             <li class="i2_goodsli shadow">

                <div class="i2_goodsd">
                   <a class="daddfavorite" data-id="{$v.aid}"></a>
                   {if $v.new ==1}<i class="index2_ico i2_gdp1 i2_gnew0" style=""></i>{/if}

                   {if $v.over ==1}<a class="i2_gdpover2"></a>{/if}
                   <a class="i2_goodsjzbk" href="{$v.id_url}" target="_blank" >
                   <img width="250" height="250" src="{$v.picurl}_250x250.jpg" alt="{$v.title}"  class="ver_img" >
                   </a>
                   <a class="i2_goodsname" href="{$v.id_url}" target="_blank">{$v.title}</a>


              <div class="cl">
                  <div class="i2_goodprice">
                        <span class="i2_gprw1">￥</span>
                        <b class="i2_gprw2">{$v.yh_price-$v.juan_price}</b>
                          <div class="i2_gprw3">
                           {if $v.zk>0} <span class="index2_ico i2_gprw4">{$v.zk}折</span>{/if}
                             {if $v.price >0}<del class="i2_gprw5">￥{$v.price}</del>{/if}
                          </div>
                          {if $v.juan_url}
                          <div class="juan_btn"><a href="{$v.juan_url}"  rel="nofollow" target="_blank">领券</a></div>
                          {else $v.sum>0 && $v.sum != 999}
                             <div class="goods_sum" >售:{$v.sum}</div>
                          {/if}

                      </div>

                  {if $v.status==3}
                     <a class="i2_gbuybtn btgotobuy_isover4"  href="{$v.id_url}" target="_blank" title="{$v.title}" ><span>{$v.h}点开始</span></a>
                   {elseif $v.status==2}
                     <a class="i2_gbuybtn btgotobuy_isover6"  href="{$v.id_url}" target="_blank" title="{$v.title}" >已下架</a>
                  {else}
                   <a class="i2_gbuybtn btgotobuy_isover1" href="{$v.id_url}" target="_blank" title="{$v.title}">
                  去看看</a>

                  {/if}
            </div>

                


                </div>
            </li>
  {/foreach}
         </ul>

            <div style="clear:both;"></div>
         </div>
