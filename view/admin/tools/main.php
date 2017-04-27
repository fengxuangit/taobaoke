{include file='../common_admin/left_bar.php'}

  
  <div class="table_top">系统的各类工具聚合</div>
<div class="table_main">
    <table class="tb tb2 ">
      <tbody>
      
        <tr>
          <td class="td27" ><p>删除商品:</p></td>
        </tr>
        <tr>
        <td colspan="4">

  {foreach from=$status_goods item=v key=k}
  {if $k==6}<br/><br/>{/if}
  {if $v.key != 1}
  <a href="{$URL}m=tools&a=del_status&status={$v.key}" class="btn submit_btn">{$v.name}({$v.count})</a>
  {/if}
{/foreach}
        </td>
        </tr>     

   
        <tr>
          <td class="td27" >&nbsp;</td>
        </tr>
        <tr>
          <td class="td27" ><a href="{$URL}m=tools&a=muster_del_goods" class="btn submit_btn">删除重复商品</a></td>
          <!--<td class="td27" ><a href="{$URL}m=tools&a=muster_del_aid" class="btn submit_btn">删除重复主键</a></td>-->
          <td class="td27" ><a href="{$URL}m=tools&a=muster_views" class="btn submit_btn">随机浏览次数</a></td>
           <td class="td27" ><a href="{$URL}m=tools&a=clear_sort" class="btn submit_btn">一键清空所有商品排序({$del.sort})</a></td>
        </tr>     
    <tr>
        <td class="10"> </td>
    </tr>
           
    
    <tr>
         <td class="td27" > <a href="{$URL}m=tools&a=muster_sort" class="btn submit_btn">随机打乱今日商品({$day.d0})</a></td>
          <td class="td27" > <a href="{$URL}m=tools&a=muster_sort&day=3" class="btn submit_btn">随机打乱3天内发布的商品({$day.d3})</a></td>
          <td class="td27" > <a href="{$URL}m=tools&a=muster_sort&day=7" class="btn submit_btn">随机打乱7天内发布的商品({$day.d7})</a></td>
          <td class="td27" > <a href="{$URL}m=tools&a=muster_sort&day=30" class="btn submit_btn">随机打乱30天内发布的商品({$day.d30})</a></td>
        </tr>
 <tr>
        <td class="10">&nbsp;</td>
    </tr>
    
<tr>
         <td class="td27" > <a href="{$URL}m=tools&a=del&t=line" class="btn submit_btn">删除所有下线商品({$del.line})</a></td>

          <td class="td27" > <a href="{$URL}m=tools&a=del&t=tk" class="btn submit_btn">删除所有非淘客商品({$del.tk})</a></td>
        </tr>




  <tr>
    
  <td class="td27" >删除佣金率低于
           <span><input type="text" name="bili"  value="" class="w40 del_yongjin"></span>
           %的商品
<a href="{$URL}m=tools&a=del_yongjin" class="btn submit_btn del_yongjin_btn">提交</a>
<script type="text/javascript">

  $(".del_yongjin_btn").click(function(event) {
    var val = $('.del_yongjin').val();
    if(!val){
      Dialog.info('佣金比例不能为空');
      return false;
    }
     var url  =$(this).attr('href') + '&bili='+val;
      location.href =url;
    return false;
  });
</script>
           </td>

  </tr>


        <tr>
        	<td  colspan="10">数据量太多则处理速度较慢,执行后请耐心等待...</td>
            
        </tr>
      </tbody>
    </table>
  </div>

{include file='../common_admin/right_bar.php'} 