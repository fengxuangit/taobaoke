{include file="../header.php"}
<!--<link rel="stylesheet" type="text/css" href="{$CSSDIR}/brandgroup.css" media="all" />-->


<div class="ppt_detail hide">
    <a href="{$shop.id_url}" target="_blank" class="ppt_detaidover1"></a>
    <a href="{$shop.id_url}" target="_blank">
    <img class="detaigoodsimg" width="540" height="280" src="{$shop.picurl}"></a>
	 <i class="newindexicon tggoodsico pos_first"></i>
     <i class="newindexicon tggoodsicohot pos_first"></i>
    <span class="ppt_date">
     <i  class="_dgmdate" data-time="{$shop.start_time}"  data-type="m/d H:i"></i> ~ 
       <i  class="_dgmdate" data-time="{$shop.end_time}" data-type="m/d H:i"></i>
    </span>
    <span class="pptdat_log"><img width="140"  height="70" src="{$shop.pic_path}"></span>

    <h1 class="ppt_dailname">{$shop.title}</h1>
    <span class="ppt_dailzhekou">{$shop.zk}折起</span>
    <a class="ppt_detaitit" href="{$shop.id_url}" target="_blank">{$shop.title}</a>
    <div class="ppt_dtailprice">
        <b>￥</b><span>{$shop.yh_price}</span>  <em>￥</em>  <del>{$shop.price}</del>
    </div>
        <a href="{$shop.id_url}" target="_blank" class="ppt_detailgobuy"></a>
        <div class="ppt_timeu _start_time" data-time="{$v.end_time}" id="display_lefttime"></div>

</div>

<div class="shop_bg cl">
{if $shop.picurl}
 <div class="_auto_ad" data-picurl="{$shop.picurl}" ></div>
{/if}
<div class="shop_desc wp cl">


<div class="ppTitle area">
    <div class="ppLogo" >
 <span><a target="_blank" href="{$shop.url}"  data-sellerid="{$shop.sid}" data-itemid="{$shop.num_iid}" rel="nofollow"    isconvert="1">
 <img src="{$shop.pic_path}" alt="{$shop.name}"></a></span>
    </div>
    <div class="ppName">
      <h1><a target="_blank" href="{$shop.url}"  data-sellerid="{$shop.sid}"   data-itemid="{$shop.num_iid}"  rel="nofollow"  isconvert="1">{$shop.title}</a></h1>

      <div class="ppInfor">
          <div class="desc_title_bg"></div>
          <span>
                <a target="_blank" href="{$shop.url}"  data-sellerid="{$shop.sid}"  data-itemid="{$shop.num_iid}" rel="nofollow"   isconvert="1">{$shop.title}卖专场<b>{$shop.zk}</b>折起 &gt; </a>
        
                 
      <i  class="_dgmdate" data-time="{$shop.start_time}"  data-type="m/d H:i"></i> ~ 
       <i  class="_dgmdate" data-time="{$shop.end_time}" data-type="m/d H:i"></i>
       
       
          </span>
      </div>
       <div class="ppInfor">
       {$shop.desc}
       </div>
    </div>
    <div class="clear"></div>
  </div>


</div>



<div class="index2_contend cl">


{include file="../goods_list.php"}

</div>
 <div class="redpage cl" >{$showpage}</div>
</div>






{include file="../footer.php"}
