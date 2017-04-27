
{include file="../header.php"}


<div class="cl friend_link_more" >
<div class="h1">友情链接:</div>
<!--{foreach from= $_G.friend_link item = v name=a}-->
                 	<!--{if $v.hide == 0}-->
        			<a href="{$v.url}" target="_blank">{$v.name}</a>
                    <!--{/if}-->
 <!--{/foreach}-->  
</div>
{include file="../footer.php"}


