{include file="../common_mobile/header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/main.css" media="all" />
<link type="text/css" rel="stylesheet" href="{$CSSDIR}/slider.css">
<script type="text/javascript" src="assets/global/js/mobile.js"></script>


<div class="index2_head">
		{if $_G.uid}
        	 <a href="{$_G.siteurl}" class="login">首页</a>
        {else}
            <a href="{$URL}m=member&a=login" class="login">登录</a>
         {/if}
            <a href="{$_G.siteurl}" class="log"><img src="{$IMGDIR}/logo.png"> </a>
    <ul><li>
    {if $_G.uid}
    <a href="{$URL}m=ajax&a=sign" class="_ajax_dialog" >签到</a> | 
    <a href="{$URL}m=home&a=jf_list">我的积分</a>
    <a href="{$URL}m=member&a=logout">退出</a>
    {else}
    <a href="{$URL}m=member&a=reg">注册</a>
    {/if}
    </li></ul>
</div>

<div class="index2_menud">
    <ul>
        <li {if $CM=='index' && $CA=='today'}class="curr"{/if}><a href="{$URL}a=today" class="mobile_get"><span>今日新品</span></a></li>
        <!--<li {if $CM=='index' && $CA=='over'}class="curr"{/if}><a href="{$URL}a=over" class="mobile_get"><span>即将下线</span></a></li>
        <li style="border-right:none " {if $CM=='index' && $CA=='history'}class="curr"{/if}><a href="{$URL}a=history" class="mobile_get"><span>往期精品</span></a></li>-->
        
        <li {if $CM=='index' && $CA=='all' && $_GET.price=='10'}class="curr"{/if}><a href="{$URL}a=all&price=10" class="mobile_get"><span>9块9</span></a></li>
        <li style="border-right:none " {if $CM=='index' && $CA=='all' && $_GET.price=='10_20'}class="curr"{/if}><a href="{$URL}a=all&price=10_20" class="mobile_get"><span>19块9</span></a></li>
        
    </ul>
</div>


{if $CM=='index' && $CA=='main'}
<div class="new-ct main" style="">
    <div class="banner scroll-wrapper" id="idContainer2" ontouchstart="touchStart(event)" ontouchmove="touchMove(event);" ontouchend="touchEnd(event);" style="overflow: hidden;">

<ul class="scroller" style="position: relative; left: -781px; width: 300%;" id="idSlider2">
{foreach from=$_G.pics.k32 item = v}
    {if $v.hide==0}
        <li><a class="_open" data-url="{$v.url}"><img src="{$v.picurl}"  /></a></li>
    {/if}
{/foreach}
</ul>
        <ul class="new-banner-num new-tbl-type" id="idNum"></ul>
    </div>
    <input type="hidden" value="15" id="crazy">
</div>
{/if}


{if $CM=='index' || $CM=='channel'}




<div class="i2_menu2d">
    <ul>
        <li style="position: relative" class="cagam_bg"><a class="cagam"><span>分类</span></a></li>
        {if $CM=='index' || $CM=='channel'}
         <li style="position: relative" {if !$_GET.order}class="curr"{/if}>
         <a href="{$URL}m={$CM}&a={$CA}{if $_G.fid}&fid={$_G.fid}{/if}{if $_G.id}&id={$_G.id}{/if}" data-sort="" data-order="" class="mobile_get"><span>默认</span></a>
         </li>
         <li  style="position: relative" {if $_GET.order == 'yh_price' }class="curr"{/if}>
         <a href="{$URL}m={$CM}&a={$CA}{if $_G.fid}&fid={$_G.fid}{/if}{if $_G.id}&id={$_G.id}{/if}&order=yh_price&sort=asc" data-sort="asc" data-order="yh_price" class="mobile_get">
         <span>价格</span></a></li>
        {/if}
    </ul>
</div>


<div class="i2_cagd" style="border-top:1px solid #ddd; display:none; ">

<div class="i2_cagdd">
        <ul>
         <li><a href="{$URL}m=index&a=all" class="mobile_get"><i></i><span>全部</span></a></li>
        {foreach from=$_G.channels item=v}
        {if $v.hide == 0}
            <li><a href="{$v.url}" class="mobile_get"><i ></i><span>{$v.name}</span></a></li>
         {/if}
        {/foreach}
           
        </ul>
</div>



    <!--<div class="i2_cagdd">
        <ul>
            <li><a href="{$URL}m=index&a=all" class="mobile_get"><i class="i2_icon one"></i><span>全部</span></a></li>
            <li><a href="{$URL}fid=1"  data-fid="1" class="mobile_get"><i class="i2_icon two"></i><span>女装</span></a></li>
            <li style="border-right: none">
            <a href="{$URL}fid=2" data-fid="2" class="mobile_get"><i class="i2_icon three"></i><span>男装</span></a></li>
        </ul>
    </div>
    <div class="i2_cagdd">
        <ul>
        <li><a href="{$URL}fid=3" data-fid="3" class="mobile_get"><i class="i2_icon four"></i><span>母婴</span></a></li>
        <li><a href="{$URL}fid=4" data-fid="4" class="mobile_get"><i class="i2_icon five"></i><span>鞋子</span></a></li>
        <li style="border-right: none">
        	<a href="{$URL}fid=5" data-fid="5" class="mobile_get"><i class="i2_icon six"></i><span>家居</span></a></li>
        </ul>
    </div>
    <div class="i2_cagdd">
        <ul>
        <li><a href="{$URL}fid=8" data-fid="8" class="mobile_get"><i class="i2_icon seven"></i><span>美妆</span></a></li>
        <li><a href="{$URL}fid=6" data-fid="6" class="mobile_get"><i class="i2_icon eight"></i><span>其他</span></a></li>
        <li style="border-right: none"></li>
        </ul>
    </div>-->
</div>

<div class="search_box">
   <form action="?" method="post">
       <input type="text" name="kw" placeholder="请输入你要搜索的内容" class="search_input"  value="{if $_GET.kw}{$_GET.kw}{/if}" />
       <button type="submit" name="onsubmit" value="1"  class="search_btn">搜 索</button>
       <input type="hidden" name="m" value="index" />
       <input type="hidden" name="a" value="search" />

   </form>

</div>
{/if}