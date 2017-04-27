{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">  
  <div class="table_top">共找到({$count})条选品分类信息

<span style="margin-left:20px;"  class="red">
使用方法: 打开 
<a href="http://pub.alimama.com/promo/search/index.htm" target="_blank" >淘宝联盟</a>
 -->将商品选取-->加入到选品库即可(注意登录阿里妈妈的账号,必须和后台->站点配置-> <a href="?m=admin&a=caiji" target="_blank">采集配置</a>->淘宝客appkey所属同一账户)</span>


  </div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th >id</th>       
       <th>分类标题</th>
       <th>类型</th>
       <th>入库栏目</th>

       <th>上次执行时间</th>
		   <th>开始采集</th>
      </tr>

       <!--{foreach from=$data item=v}-->
         <tr class="hover">  
        <td>{$v.id}</td>        
        <td>{$v.title}</td>
         <td>{$v.type_name}</td>
         <td>

<select name="fids[{$v.id}]" class="select_fid"> 
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $goods.fid==$vv.fid || $vv.fid==$v.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $goods.fid==$vvv.fid || $vvv.fid==$v.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $goods.fid==$a.fid || $a.fid==$v.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
</select>

         </td>
		     <td class="_dgmdate" data-time="{$v.updatetime}"></td>
         <td><a class="red" href="{$URL}m=fetch&a=lianmeng_start&favid={$v.id}" target="_blank">开始采集</a></td>
        </tr>
       <!--{/foreach}-->
  
 <tr>
        <td colspan="6">
        <div class="y showpage">{$showpage}</div>
        <div class="fixsel">
            <input type="submit" class="btn submit_btn" name="onsubmit"  value=" 提 交 保 存" >
          </div></td>
      </tr>


      </tbody>     

  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 