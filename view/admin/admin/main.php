{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">

  
<div class="table_main" >
<table class="tb tb2 fixpadding">
<tbody>
<tr><th colspan="5" class="partition">系统信息</th></tr>

{foreach from=$info item=v}
<tr  {if $v.color == 1} style="background:#f00"{elseif $v.bg == 1} style="background:#eee"{/if}>
<td class="vtop td24 lineheight " {if $v.color == 1} style="color:#fff"{/if}>&nbsp;{$v.name}</td>
<td class="lineheight smallfont"  {if $v.color == 1} style="color:#fff"{/if}>{$v.value}</td>
</tr>
{/foreach}
	</tbody>
	</table>  
    
  </div>

<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>

{include file='../common_admin/right_bar.php'} 