{include file='../common_admin/left_bar.php'}
  

<div class="table_top">请选择要发布的栏目</div>

<div class="table_main">
  <table class="tb tb2 nobdb">
    <tbody>
      <tr class="hover">
		 <td class="td25">fid</td>
        <td class="td25">前台查看</td>
       
        <td class="td28">栏目名称</td>
        <td>添加信息</td>
        <td>管理商品</td>
      </tr>
    </tbody>
    <!--{foreach from=$_G.channels item=v}-->
    <tbody>
      <tr class="hover" height="35">
		<td class="td25">{$v.fid}</td>
        <td class="td25"><a href="index.php?m=channel&fid={$v.fid}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif"></a></td>
        
        <td class="td28">
        <!--{if $v.sub}--> 
          {$v.name} 
          <!--{else}--> 
          <a href="{$URL}m=goods&a=post&fid={$v.fid}">{$v.name}</a> 
          <!--{/if}--></td>
        <td><!--{if !$v.sub}--> 
          <a href="{$URL}m=goods&a=post&fid={$v.fid}">添加商品</a> 
          <!--{else}--> 
          &nbsp; 
          <!--{/if}--></td>
        <td><a href="{$URL}m=goods&a=main&fid={$v.fid}">管理商品</a></td>
      </tr>
  
            <!--{if $v.sub}-->                   
             <!--{foreach from=$v.sub item=vv}-->
              <tr class="hover">
                <td class="td25">{$vv.fid}</td>
                <td class="td25"><a href="index.php?m=channel&fid={$vv.fid}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif"></a></td>
                <td  class="td28" ><div class="board"><a href="{$URL}m=goods&a=post&fid={$vv.fid}">{$vv.name}</a></div></td>
                <td><div class="board"><a href="{$URL}m=goods&a=post&fid={$vv.fid}">添加商品</a></div></td>
                <td><a href="?m=goods&a=main&fid={$vv.fid}">管理商品</a></td>
              </tr>
               <!--{/foreach}-->                   
            <!--{/if}--> 
    
    
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