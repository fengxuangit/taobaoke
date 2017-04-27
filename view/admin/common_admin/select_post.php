{include file='./left_bar.php'}
  

<div class="table_top">请选择要发布的分类</div>

<div class="table_main">
  <table class="tb tb2 nobdb">
    <tbody>
      <tr class="hover">
		 <td class="td25">id</td>
        <td class="td25">前台查看</td>
       
        <td class="td28">栏目名称</td>
        <td>添加信息</td>
        <td>管理信息</td>
      </tr>
    </tbody>
    <!--{foreach from=$cate item=v}-->
    <tbody>
      <tr class="hover" height="35">
		<td class="td25">{$v.id}</td>
        <td class="td25"><a href="{$v.url}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif"></a></td>
        
        <td class="td28">
        <!--{if $v.sub}--> 
          {$v.name} 
          <!--{else}--> 
          <a href="{$v.url}">{$v.name}</a> 
          <!--{/if}--></td>
        <td><!--{if !$v.sub}--> 
          <a href="{$URL}m={$CM}&a=post&cate={$v.id}">添加信息</a> 
          <!--{else}--> 
          &nbsp; 
          <!--{/if}--></td>
        <td><a href="{$URL}m={$CM}&a=main&cate={$v.id}">管理信息</a></td>
      </tr>
  
            <!--{if $v.sub}-->                   
             <!--{foreach from=$v.sub item=vv}-->
              <tr class="hover">
                <td class="td25">{$vv.id}</td>
                <td class="td25"><a href="{$v.url}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif"></a></td>
                <td  class="td28" ><div class="board"><a href="{$URL}m={$CM}&a=post&cate={$vv.id}">{$vv.name}</a></div></td>
                <td><div class="board"><a href="{$URL}m={$CM}&a=post&cate={$vv.id}">添加信息</a></div></td>
                <td><a href="?m={$CM}&a=main&id={$vv.id}">管理信息</a></td>
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
{include file='./right_bar.php'} 