{include file="../{$TPLNAME}/header.php"}
<div class="cl showmessage">
  <div class="nfl">
    <div class="f_c altw">
      <div class="{$alerttype}">
        <p>{$message}</p>
        <p class="alert_btnleft"><p class="alert_btnleft">
        {if $url}
         <a href="{$url}">返回上一页</a>      
        {else}
         <a href="{$_G.siteurl}">返回首页</a>
        {/if}
        </p>
	       {if $ext_msg}{$ext_msg}{/if}
           </p>
      </div>
    </div>
  </div>
</div>
{include file="../{$TPLNAME}/footer.php"}