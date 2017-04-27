
{if $_G.tag_list}
<div class="wp cl" style="margin-top:15px;">
<div class="tag_list">
    <div class="tags_m cl">
    <a href="{$_G.siteurl}" title="{$_G.setting.title}">{$_G.setting.title}</a>
	{foreach from=$_G.tag_list item=v}
     <a href="{$v.url}" title="{$v.title}" target="_blank">{$v.title}</a>
	{/foreach}
    </div>
</div>
</div>
{/if}
