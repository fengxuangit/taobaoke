{include file="../common/header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/main.css" media="all" />
 



<a name="index_top"></a>
<div class="hpz_headd" style="display: none;" data-time="{$today},{$_G.timestamp},{$today+86400},{$_G.timestamp+86400},{$h}">
   <div class="hpz_headdd">
       <span class="addFavorite">每天精选推荐超值正品，按键<b>Crtl+D</b>收藏，帮您省钱更简单！</span>
       <i class="indexiocns delheadddi close_toptip"></i>
       <a class="delheaddda close_toptip">关闭</a>
   </div>

</div>

<div class="hpz_headmenu">
	            <div id="user_login_state">
                        
            <h1>您好，欢迎来到{$_G.setting.title}！
            {if !$_G.uid}请  <a href="index.php?m=member&a=login" style="color: #e32014;">登录</a>{/if}</h1>
            <ul>
            {if !$_G.uid}
           
                <li>|</li>
                <li><a href="index.php?m=member&a=reg" style="color: #e32014;">免费注册</a></li> <li>|</li>
              
           
            {else}
           
             <li><a href="index.php?m=home">{$_G.username}</a></li>
                <li>|</li>
                <li><a href="index.php?m=home">会员中心</a></li>
                <li>|</li>
                <li><a href="index.php?m=member&a=logout" class="a_logout">退出</a></li> <li>|</li>
          
            {/if}
            
<!--             <li> <a href="index.php?m=apps">app下载</a></li> -->
              </ul>
           
                        </div>
            
            <ul style="float: right">
                <li class="testguanzhumou"><i class="indexiocns headmenuicon3"></i>
                <a href="http://weibo.com/u/2106992135" target="_blank" style="">关注<em class="all_or">∨</em></a></li>
                <li>|</li>
                <li class="headsharebox"><i class="indexiocns headmenuicon4"></i><a href="#" class="show_share_box">分享</a></li>
                <li>|</li>
                <li><i class="indexiocns headmenuicon5"></i><a href="index.php?a=desktop">收藏到桌面</a></li>
                <li><a href="index.php?m=apply&a=info">商家报名</a></li>
            </ul>
           <div class="guanzhuobjd">
                 <img class="wxword" style="display:block" src="{$IMGDIR}/wt.png">
            </div>
           
</div>

<div class="hpz_head">

    <a href="{$_G.siteurl}" class="hpz_log"><img src="{$_G.setting.logo}"></a>

    
    <div class="search_box y">
        	<div class="header-srh">
        <div class="srh-box">
            <form action="{$URL}a=search" method="POST"  id="search_form">
                                <div class="srh-inp">
                    <div class="srh-xl" id="searchxl">
                        <ul class="triggers">
                           <li class="selected">搜 索</li>        
                         </ul>
                        
                    </div>
     			  <input placeholder="搜&quot;精品女装&quot;试试" type="text" class="so_kw" data-type="kw" name="kw" value="{if $_GET.kw}{$_GET.kw}{/if}" autocomplete="off" accesskey="s" aria-expanded="true" />
                </div>
                <input type="submit" class="srh-sub so_web _check_form" url="{$URL}a=search" value="搜本站" >
                <input type="submit" class="srh-sub so_tb _check_form" url="http://ai.taobao.com/search/index.htm" value="搜淘宝">
                <input type="hidden" value="{$_G.setting.pid}" name="pid">

                
            </form>
        </div>
    </div>
        
        </div>

        <a href="{$URL}m=ad&id=1" class="head_gg2"><img width="180" height="65" src="{$IMGDIR}/nav2.png" ></a>

</div>

<div class="hpz_menubk">
    <div class="hpzmenu">
        <ul>


{foreach $_G.nav item=v}
{if $v.type =="1"}
<li class="{$v.classname}"><a class="is_color is_bold" href="{$v.url}" {if $v.target=="1"} target="_blank"{/if}>{$v.name}</a></li>
{/if}
{/foreach}

<!--
<li {if $CM=='index' && $CA=='main'}class="hpzmenusel" {/if}><a class="is_color is_bold" href="{$URL}">首页</a></li>
<li {if $_GET.price=='10'}class="hpzmenusel" {/if}><a class="is_color is_bold" href="{$URL}a=all&price=10">9块9包邮</a></li>
<li {if $_GET.price=='10_20'}class="hpzmenusel"{/if}><a class="is_color is_bold" href="{$URL}a=all&price=10_20">19.9包邮</a></li>
<li {if $CURMODULE == 'img'}class="hpzmenusel"{/if}><a class="is_color is_bold" href="{$URL}m=img&a=list">值得买</a></li>
<li {if $CURMODULE == 'style'}class="hpzmenusel"{/if}><a class="is_color is_bold" href="{$URL}m=style&a=list">搭配</a></li>
<li {if $CURMODULE == 'shop'}class="hpzmenusel"{/if}><a class="is_color is_bold" href="{$URL}m=shop&a=list">品牌店铺</a></li>
<li {if $CURMODULE == 'duihuan'}class="hpzmenusel" {/if}><a class="is_color is_bold" href="{$URL}m=duihuan&a=list">积分中心</a></li>
<li {if $CURMODULE == 'index' && $CURACTION == 'yaoqing'}class="hpzmenusel" {/if}>
<a class="is_color is_bold" href="{$URL}a=yaoqing">免费赚钱</a>
</li>
<li {if $CURMODULE == 'index' && $CURACTION == 'today'}class="hpzmenusel" {/if} style="position: relative">
<a class="is_color is_bold" href="{$URL}a=today">今日新品</a><span class="m_tj"></span>
</li>-->
                 
                 
         </ul>


       <span class="hpz_head_qd" style="float: right;{if $TAE==1} display:none;{/if}">
             <a target="_blank" style="color: #fff">签到</a>
        </span>


        <div class="head_qiandao" style="display: none;">
            <div class="head_qd_d1">

                <div class="h_qdd1d1">
                {if $_G.uid}                
               		 <div class="cl">
                        <span class="h_qdd1d1name"><a href="{$URL}m=home" class="h_qdd1a1">{$_G.username}</a></span>
                        
                        {if $TAE==0}<a href="{$URL}m=member&a=logout" class="h_qdd1a1 a_logout">退出</a>{/if}
                        <b class="h_qdd1b1">可用积分：<i id="user_ownscore">{$_G.member.jf}</i></b>
                   </div>
                   <a class="h_qdd1btn1 h_qdd1btn2 _ajax_dialog"  href="{$URL}m=ajax&a=sign" style="margin-left:0;">签到，领积分</a>
                {else}
					 <a class="h_qdd1btn1" href="{$URL}m=member&a=login">用户登录</a>
                    <p style="display:block; margin-top:60px; width:130px; text-align:center;">登录签到拿积分</p>
                {/if}
				</div>
            </div>
            <div class="head_qd_d2">
                 <a href="{$URL}a=yaoqing" class="head_qd_d2a1">赚积分</a>
                 <span>|</span>
                 <a href="{$URL}m=duihuan&a=list" class="head_qd_d2a2">花积分</a>
            </div>
        </div>

    </div>
</div>
{if $CM !='shop' && $CM !='home'}
<div class="score_nav cl">
    <ul class="score_nav_ul">
    
    
{foreach $_G.nav item=v}
{if $v.type =="2"}
<li class="{$v.classname}"><a href="{$v.url}" {if $v.target=="1"} target="_blank"{/if}>{$v.name}</a></li>
{/if}
{/foreach}
        <!--<li><a href="{$URL}a=all" style="{if $CA == 'all' }color:#E32014;{/if}">全部</a></li>
        {foreach from = $_G.channels item=v name= a}
        {if $v.hide ==0}
         <li><a href="{$URL}fid={$v.fid}{if $_GET.price}&price={$_GET.price}{/if}" style="{if $_G.fid == $v.fid }color:#E32014;{/if}">{$v.name}</a></li>
          <li class="iconBack"><em>|</em></li>
          {/if}
         {/foreach}
         
         {if $_G.goods_cate}
         <li style="margin-left:20px;color:#09F;">分类</li> <li class="iconBack"><em>|</em></li>
         {foreach from = $_G.goods_cate item=v name= a}
          {if $v.hide ==0}
         <li><a href="{$URL}a=cate&id={$v.id}" {if $CA=='cate' && $_G.id == $v.id}style="color:#E32014;"{/if}>{$v.name}</a></li>
          <li class="iconBack"><em>|</em></li>
          {/if}
         {/foreach}
         {/if}
         -->
        {if $CM=='index' || $CM=='channel'}
        <span class="y">
         <li><a href="{$URL}m=index&a=all{if $_G.fid}&fid={$_G.fid}{/if}{if $_G.id}&id={$_G.id}{/if}" style="{if !$_GET.order}color:#E32014;{/if}">默认</a></li>
         <li>
         <a href="{$URL}m=index&a=all{if $_G.fid}&fid={$_G.fid}{/if}{if $_G.id}&id={$_G.id}{/if}&order=yh_price&sort=asc" style="{if $_GET.order == 'yh_price' }color:#E32014;{/if}">价格</a>
         </li>
		{/if}
        
         </span>
    </ul>
</div>
{/if}
