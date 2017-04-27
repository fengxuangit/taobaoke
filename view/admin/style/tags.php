{include file='../common_admin/left_bar.php'}
  

<div class="table_top">请选择要发布的栏目</div>

<div class="table_main">
  <table class="tb tb2 nobdb">
    <tbody>
      <tr class="hover">
		 <td class="td25">fid</td>
        <td class="td28">栏目名称</td>
        <td>采集管理</td>
      </tr>
    </tbody>
    <!--{foreach from=$_G.style_cate item=v key=k}-->
      {if $k>0}
    <tbody>
      <tr class="hover" height="35">
		<td class="td25">{$k}</td>
        <td class="td28">{$v}</td>
        <td><a href="{$URL}m=style&a=fetch&cate={$k}" target="_blank">开始采集</a></td>
      </tr>
      {/if}
   <!--{/foreach}-->
      </tbody>
  </table>
  <tbody>
    <tr class="hover">
      <td class="td25">&nbsp;</td>
      <td class="td25">&nbsp;</td>
      <td class="td25">&nbsp;</td>
      <td class="td28">&nbsp;</td>
    </tr>
  </tbody>
</div>
{include file='../common_admin/right_bar.php'} 