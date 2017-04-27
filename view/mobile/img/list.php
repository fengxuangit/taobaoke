{include file="../header.php"}
{$CSS}

<div class="content cl" style="padding-top:50px;">

<ul class="list list_preferential" id="post_list_preferential">
{foreach from=$goods item=v}
    <li>
		<a href="{$v.id_url}" target="_blank" >
		<div class="image_wrap">
			<i class=""></i>
			<div class="image"><img src="{$v.picurl}" alt="{$v.title}"></div>
		</div>
		<span>{$v.title}</span>
		<h2  style="font-weight:100;">{$v.description}</h2>
	
        </a>
	</li>
{/foreach}
</ul>

</div>

<div class="cl redpage">{$showpage}</div>
{include file="../footer.php"}