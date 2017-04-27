{include file="../header.php"}


{if $CA=='main' && $CM=='channel'}
    {if $channel.picurl}
        <div class="_auto_ad" data-picurl="{$channel.picurl}" data-url="{$cate.org_url}"></div>
    {/if}

    {if $sub.sub}

    <div class="wp container cate_font">
     <a class="waves-effect waves-purpleSEND btn {if $channel.fup ==0}cyan lighten-3{else}white  grey-text text-darken-1{/if}"><i class="iconfont">&#xe687;</i>&nbsp;分类</a>
        {foreach from=$sub.sub item=v}
            <a href="{$v.url}" class="waves-effect waves-light btn {if $_G.fid==$v.fid}cyan lighten-3{else}white grey-text text-darken-4{/if}">{$v.name}</a>
        {/foreach}

    </div>



    {/if}
{elseif $CA=='cate' && $CM=='index' && $cate.picurl}
    <div class="_auto_ad" data-picurl="{$cate.picurl}" data-url="{$cate.pic_url}"></div>

{/if}




{include file="../goods_list.php"}



{include file="../footer.php"}
