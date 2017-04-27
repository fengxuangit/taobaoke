{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/goods.css" media="all">

<div class="nav_position">
<a href="{$_G.siteurl}">首页</a> > <a href="{$_G.channel.url}">{$_G.channel.name}</a> > <a href="{$goods.id_url}" class="on">{$goods.title}</a>
</div>


<div class="bucuo_detail_con">
   <div class="bucuo_goods_img">

   <a href="{$goods.url}" target="_blank" title="{$goods.title}" isconvert="1" data-itemid= "{$v.num_iid}">
     <img width="300" height="300" src="{$goods.picurl}_300x300.jpg" alt="{$goods.title}">
   </a>
    </div>
   <div class="bucuo_de_goodsd">
      <ul>
          <li class="li1" style="width:670px;">
		  <b class="bucuo_de_bkico bucuo_icosource{$goods.shop_type}"></b>
              <span><a href="{$goods.url}" target="_blank" rel="nofollow" isconvert="1" data-itemid= "{$v.num_iid}">{if $goods.baoyou ==1}[包邮]{/if}{$goods.title}</a></span>
          </li>
          <li class="bucuo_de_bkico li2 lic{if $goods.status ==3 || $goods.status ==6}2{elseif $goods.status ==5}3{else}1{/if}">

              <b>￥</b><span>{$goods.yh_price-$goods.juan_price}</span>
            {if $goods.price>0}   <span class="del">原价:{$goods.price}元</span>{/if}

          {if $goods.juan_url}
               <div class="goods_juan_url shadow"><a href="{$goods.juan_url}" target="_blank">领{if $goods.juan_price}{$goods.juan_price}元{/if}优惠券</a></div>
        {/if}
        
              <a href="{$goods.url}" class="go_btn" target="_blank" rel="nofollow" title="{$goods.title}" isconvert="1" data-itemid= "{$goods.num_iid}"></a>
          </li>
          <li class="li3">
      {if $goods.price>0}
              <span>
                  <h1>原价</h1>
                  <em>{$goods.price}</em>
              </span>

              {/if}

              {if $goods.zk>0}
              <span>
                   <h1>折扣</h1>
                   <em>{$goods.zk}折</em>
              </span>
              {/if}

              {if $goods.price>0}
              <span>
                   <h1>共节省</h1>
                   <em style="color:#00AA00;">{$goods.price-$goods.yh_price}</em>
              </span>
              {/if}

               <span>
                   <h1>已售</h1>
                   <em style="color:#00AA00;">{$goods.sum}</em>
              </span>

          </li>
<li class="li4">
<em>
标签:
{foreach from=$goods.tags item=v key=k name=a}
<a href="{$URL}&a=search&kw={$k}" target="_blank" title="{$v}">{$v}</a>
{/foreach}

</em>
					<!--<span class="ai_bucuobtw1">{$goods.state}-{$goods.city}</span>-->
					<span class="ai_bucuobtw2">现价{$goods.yh_price}元</span>
         </li>
          <li class="li5">
               <div class="bucuo_de_fxd">

                  <em class="bucuo_de_bkico" style="background-position:-222px -41px;"></em><b>浏览({$goods.views})</b>
                  <em class="bucuo_de_bkico" style="background-position:-246px -42px;margin-left:10px;"></em><b>
                  <a href="#" class="show_share_box" style="margin-left:0px;">分享</a></b>
				  <i class="bucuo_de_bkico" style="background-position:-270px -35px;"></i><a href="javascript:;">投诉</a>

               </div>
          </li>
        <li class="li6">{$_G.title} 在 <span class="_dgmdate" data-time="{$goods.start_time}"></span>进行特惠折扣减价促销活动,原价{$goods.price}现价{$goods.yh_price},开始时间<span class="_dgmdate" data-time="{$goods.start_time}"></span>结束时间<span class="_dgmdate" data-time="{$goods.end_time}"></span>,过后恢复原价.
当前商品来自：{if $goods.shop_type ==1}天猫{else}淘宝集市{/if},发货城市为：{$goods.state}-{$goods.city},
标签关键字:
{foreach from=$goods.tags item=v key=k name=a}
{$v},
{/foreach}
卖家{if $goods.baoyou==1}已{else}未{/if}包邮,商品近30天销量{$goods.sum+864},报名商家为{$goods.username},
请具体参看商家{$goods.nick}的活动信息,点
击可立即进入卖家{$goods.nick}商铺查看最新特惠活动.一切尽在{$_G.setting.title}
本商品关键为{$goods.keywords},商品ID为{$goods.num_iid}</li>
      </ul>

   </div>

   <div class="bucuo_shop_info">
     <ul>
         <li class="li1"><em class="bucuo_de_bkico bucuo_icosource1"></em><span>
         <a href="{$URL}a=go_pay&num_iid={$goods.num_iid}&shop=1" target="_blank" rel="nofollow">{$goods.nick}</a></span></li>
         <li class="li2">包邮：{if $goods.baoyou ==1}是{else}否{/if}</li>

         <!--<li class="li2">地址：{$goods.state}{$goods.city}</li>-->
         <li class="li2">类型：{if $goods.shop_type ==1}天猫{else}淘宝集市{/if}</li>
         <li class="li2">卖家：{$goods.nick}</li>
         <li class="li2">浏览：{$goods.views}</li>
         <li class="li3">
           <a class="bucuo_de_bkico" href="{$URL}a=go_pay&num_iid={$goods.num_iid}&shop=1" target="_blank" rel="nofollow"></a>
         </li>
     </ul>
     <div class="bucuo_det_zpbzd">
         <a class="bucuo_de_bkico" style="cursor:text;"> </a>
     </div>

   </div>
</div>


<div class="shuaixuan2 ff">
<div class="bucuo_detail_bmenu">
    <ul>
     	{if $goods.message}<li class="bucuo_current"><a>商品详情</a></li>{/if}
        <li  {if !$goods.message} class="bucuo_current"{/if}><a>同类热销推荐</a></li>
        <li class=""><a>买过的人说<span></span></a></li>
        <li class=""><a>用户讨论区</a></li>
    </ul>
</div>


  <div class="index_bucuozhekou " style="overflow:hidden;">

  {if $goods.message}
   <ul class="index_contentul2 id-itemlist" style="padding:10px;">
   {$goods.message}
   </ul>

  {/if}
    <ul class="index_contentul2 other_goods id-itemlist {if $goods.message}hide{/if}">


{foreach from=$tuijuan  item=v}
	 <li>
            <div class="ai_bucuowk">
                <a href="{$v.id_url}" target="_blank" title="{$goods.title}" rel="nofollow" isconvert="1" data-itemid= "{$v.num_iid}">
                <img width="245" height="245" src="{$v.picurl}_250x250.jpg"></a>
                <div class="ai_bucuoinfo11">
                    <div class="ai_bucuosginfol1">
                        <a href="{$v.id_url}" target="_blank" title="{$goods.title}">{if $v.baoyou ==1}<b>【包邮】</b>{/if}{$v.title}</a>
                     <span>
                        ￥<em>{$v.yh_price-$v.juan_price}</em>
                        {if $v.price>0}<del>￥{$v.price}</del>{/if}
                        {if $v.zk>0}<b>（{$v.zk}折）</b>{/if}
                     </span>
                    </div>
                    <a class="ai_bucuomsgbtn22" href="{$v.url}" target="_blank" title="{$goods.title}" rel="nofollow" isconvert="1" data-itemid= "{$v.num_iid}">立即抢购</a>
                </div>

            </div>
        </li>
{/foreach}
    </ul>


     <ul class="index_contentul2 id-itemlist hide" style="padding:10px;">

     <div class="comment">
     <div class="comment-title">
     				 <div class="pl-box">
                        <p>以下是来自{if $goods.shop_type==1}天猫{else}淘宝{/if}买家的评论</p>
                      </div>
                      <div class="cf_b com-big">
                        <div class="com-list user-info-r">
                          <ul class="_comment_list" data-num_iid="{$goods.num_iid}"></ul>
                        </div>
                      </div>
                      <p class="more"><a href="{$goods.url}" target="_blank" rel="nofollow" title="{$goods.title}" isconvert="1" data-itemid= "{$goods.num_iid}">查看更多评论&gt;&gt;</a></p>
     </div>
         </div>
    </ul>

     <ul class="index_contentul2 id-itemlist hide" style="padding:10px;">
    		 <div class="cl _duoshuo" data-id="{$goods.aid}" data-name="{$_G.setting.duoshuo}" ></div>
    </ul>


  </div>
  </div>





{include file="../footer.php"}
