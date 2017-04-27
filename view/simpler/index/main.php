{include file="../header.php"}

<div class="container wp">
  <div class="slider">
    <ul class="slides">
    {foreach from=$_G.pics.k33 item=v}
       <li>
         <a {if $v.url} href="{$v.url}" target="_blank"{/if}><img src="{$v.picurl}" /></a>
       </li>
    {/foreach}

    </ul>
  </div>
</div>

{include file="../goods_list.php"}



{include file="../footer.php"}
