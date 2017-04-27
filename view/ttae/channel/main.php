{include file="../header.php"}
 <link type="text/css" rel="stylesheet" href="{$CSSDIR}/index.css">
{if $CURMODULE == 'index' && $CURACTION == 'over'}
<div class="listtopcontent">
        <h1>即将结束</h1>
        <h2>最后疯抢，不容错过</h2>
        <div class="listlast_time">
           <h3>剩余时间：</h3>
           <b data-time="{$time}" id="display_lasttime" class="_start_time"></b>
        </div>

 </div>
{/if}


{if $CA=='main' && $CM=='channel'}

    {if $channel.picurl}
        <div class="_auto_ad" data-picurl="{$channel.picurl}" data-url="{$cate.org_url}"></div>
    {/if}

    {if $channel.sub}
	 <div class="nav_position">
       <a href="{$URL}fid={$_G.fid}" class="on">分类</a> >
        {foreach from=$channel.sub item=v}
			<a href="{$v.url}" {if $_G.fid == $v.fid}class="on"{/if}>{$v.name}</a>
        {/foreach}
     </div>

    {else}
    <div class="nav_position">
    <a href="{$_G.siteurl}">首页</a> > <a href="{$URL}fid={$_G.fid}" class="on">{$channel.name}</a>
    </div>

    {/if}
{/if}

{if $CA=='cate' && $CM=='index' && $cate.picurl}
    <div class="_auto_ad" data-picurl="{$cate.picurl}" data-url="{$cate.pic_url}"></div>

{/if}



  {include file="../goods_list.php"}

 <div class="redpage cl" >{$showpage}</div>








{include file="../footer.php"}


