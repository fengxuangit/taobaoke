{include file="../header.php"}

<div class="wp cl">

<div class="friendlink_page cl">
    <h2 class="link">友情链接</h2> 
<div class="content cl">文字链接</div>
<ul class="links_content desc cl">



<!--{foreach from= $_G.friend_link item = v}-->
<!--{if $v.sort>=1000 && $v.hide == 0}-->
<li class="textlink">   <a href="{$v.url}" target="_blank">{$v.name}</a></li>
<!--{/if}-->
<!--{/foreach}-->     


    </li>
</ul>
<div class="content cl">图片链接</div>
<ul class="links_content cl imglink">
   
   
<!--{foreach from= $_G.friend_link item = v}-->
<!--{if $v.sort<1000  && $v.hide == 0}-->
    <li class="li2">
        <a href="{$v.url}" title="{$v.name}" target="_blank">
            <img src="{$v.picurl}" width="120" height="80"/>
        </a>
    </li>
<!--{/if}-->
<!--{/foreach}-->     
    
   
</ul>
</div>
</div>










{include file="../footer.php"} 