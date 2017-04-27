{include file='../common_admin/left_bar.php'}
  
<form method="post" >
  <div class="table_top">共找到({$count})条商品信息</div>
    <div class="table_main">
  <table class="tb tb2 ">
    <tbody>      
      <tr class="hover">
        <th>采集</th>   
        <th>商品名称</th>  
         <th>卖家昵称</th>
         <th>栏目</th> 
        <th>现价</th>
        <th>原价</th>         
        <th>淘宝客佣金</th>
        <th>佣金比率</th>
        <th>店铺类型</th>

       
        <th>30天交易量</th>
      </tr>

      <!--{foreach from=$goods item=v}-->
      <tr class="hover">
        <td>
         <input type="checkbox" name="del[{$v.num_iid}]" value="1" class="_del" title="{$v.num_iid}" />
        <input type="hidden" name="ids[{$v.num_iid}]" value="{$v.num_iid}" />
       
         <textarea name="data[{$v.num_iid}]"  class="hide">{$v.data}</textarea>
        
        </td>
        <td class="_hover_img"><a href="{$v.url}" target="_blank" title="">{$v.title}</a>
           <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}_300x300.jpg"  /></a>
        </td>
        <td>{$v.nick}</td>
        <td>
			{$fetch.channel_name}
        </td>

         <td  class="red">{$v.yh_price}</td>
        <td>{$v.price}</td>
        <td class="red">{$v.yongjin}</td>
        <td>{$v.bili}%</td>       
        <td>{if $v.shop_type==1}商城{else}集市{/if}</td>
        <td>{$v.sum}</td>
      </tr>
      <!--{/foreach}-->
      
<tr><td colspan="10">
<input type="checkbox" class="_del_all" />反选(选中的才会进行采集)
<div class="y">{$showpage} </div></td></tr>
      
      
      <tr >
        <td class="td25">&nbsp;</td>
          <td colspan="8">

<div class="hide">
<select name="postdb[cate]">
<option value="0">---请选择商品分类---</option>
<!--{foreach from=$_G.cate item=vv}-->
<option value="{$vv.id}" >{$vv.name}</option>
<!--{/foreach}-->
</select>&nbsp;&nbsp;
</div>

         上线时间:
          <input  name="postdb[start_time]" value="" type="text" class="txt _dateline" title="上线时间">&nbsp;&nbsp;
          下线时间:
          <input  name="postdb[end_time]" value="" type="text" class="txt _dateline"  title="下线时间">
      </tr>
      
      <tr>
      <td>&nbsp;</td>
      <td colspan="17">
        <div class="fixsel" style="padding-bottom:100px;">
      		<input type="hidden" name="postdb[fid]" value="{$fetch.fid}">
            <input type="submit" class="btn submit_btn" name="onsubmit"  value=" 开始采集" >在列中未选择分类和标签,将使用此处理的...
          </div></td>
      </tr>
      
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 