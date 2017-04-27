{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/brandgroup.css" media="all" />

<div class="score_nav cl">
    <ul class="score_nav_ul">
        <li><a href="{$URL}m=shop&a=list" style="{if $CA == 'all' }color:#E32014;{/if}">分类</a></li>
        {foreach from = $_G.shop_cate item=v name= a}
         <li><a href="{$URL}m=shop&a=list&cate={$v.id}" style="{if $_G.fid == $v.fid }color:#E32014;{/if}">{$v.name}</a></li>
          <li class="iconBack"><em>|</em></li>
        {/foreach}
       
        
         </span>
    </ul>
</div>


<div class="nav_position">
当前位置: 
      <a href="{$_G.siteurl}" title="{$_G.setting.title}">{$_G.setting.title}</a> &gt; 
      <a href="{$URL}m=shop&a=list" class="on">品牌店铺</a>
</div>


<div class="hpz_ppt_hotsell">
    <div class="hpz_ppt_title">
        <h1>本期品牌</h1>
       <!-- <h2>每周二早10点更新</h2>-->
                <span class="hpz_ppt_qhbtn" style="display:none;">
        	6月23品牌&nbsp;&nbsp;抢鲜看
        </span>
            </div>
</div>

<div class="hpz_ppt_logosd" style="border-color: rgb(238, 238, 238);">
    <ul class="hpz_pptlogul" style="display: block;">

	{foreach from=$shop_list item=s}
 
       <li class="hpz_pptlogli hpz_pptlogli3">
            <a class="hpz_pptloglia" href="{$s.id_url}" title="{$s.title}" target="_blank">
                <div class="ppt_be"></div>
                <div class="hpz_pptlogliaa">
                    <h5>{$s.title}</h5>
                    <span><i>全场{$s.zk}折封顶</i></span>
                </div>
            </a>
            <a title="{$s.title}" target="_blank"><img src="{$s.pic_path}" width="100"  height="50"></a>
        </li>

	{/foreach}
    </ul>
    
</div>

{foreach from=$shop_list item=shop}


<div class="shop_desc wp cl" style=" margin-top: 20px; ">


            <div class="ppTitle area">
                <div class="ppLogo" >
                  <span><a target="_blank" href="{$shop.id_url}"  ><img src="{$shop.pic_path}" alt="{$shop.name}"></a></span>
                </div>
                <div class="ppName">
                  <h1><a target="_blank" href="{$shop.url}" data-sellerid="{$shop.sid}" data-itemid="{$shop.num_iid}"  isconvert="1">{$shop.title}</a></h1>
                  
                  <div class="ppInfor">                    
                      <div class="desc_title_bg"></div>
                      <span>
                            <a target="_blank" href="{$shop.id_url}" >{$shop.title}卖专场<b>{$shop.zk}</b>折起 &gt; </a>
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

    {if $shop.goods && $shop.count>0}
<div class="ppt_goodscontent">
    
	{foreach from=$shop.goods item=v}     
     <div class="ppt_goodsd">
         <a href="{$v.url}" ><img width="220" height="220" src="{$v.picurl}_220x220.jpg"></a>
         <i class="newindexicon ppt_dbico"></i>
         <i class="newindexicon ppt_dbicoh"></i>
         <a class="ppt_gtit" href="{$v.url}" target="_blank">{$v.title}</a>
         <div class="ppt_ginfo">
            <ul>
                <li><b>￥</b><span>{$v.yh_price}</span></li>
                <li><del>￥{$v.price}</del></li>
            </ul>
         </div>
         <a href="{$v.url}" class="ppticons pptgobuy ppt2btn"></a>
     </div>
  {/foreach}         
    <a class="ppt_moregoods" href="{$shop.id_url}" >
         <span>
             查看更多
         </span>
        <i class="ppticons"></i>
    </a>
</div>
     {/if}
	{/foreach}
<div style="width: 100%; height: 30px;border-bottom: 1px solid #eee"></div>



<div class="cl redpage">{$showpage}</div>





{include file="../footer.php"} 