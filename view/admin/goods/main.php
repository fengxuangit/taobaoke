{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post"  >

<div class="table_top">


 <div class="table_top_l">共找到({$count})个商品信息</div>
     <div class="table_top_r">
        <ul>


<!--{if $_GET.fid}-->
<li><a href="/index.php?m=channel&fid={$_GET.fid}" target="_blank">前台查看</a></li>
<li  style="display:none"><a href="{$URL}m=channel&a=post&fid={$_GET.fid}">编辑栏目</a></li>
<li  style="display:none"><a href="{$URL}m=goods&a=post&fid={$_GET.fid}">立即发布</a> </li>
<li>&nbsp;&nbsp;</li>
<!--{/if}-->

<li><a href="{$URL}m=goods&a=main">全部</a></li>

<li class="select_li" data-key="shop_type" data-val="1" >商城</li>
<li class="select_li" data-key="shop_type" data-val="2" >集市</li>
<li class="select_li" data-key="shop_type" data-val="0" >未知</li>


<li>
<select class="select_jump"  data-key="flag">
<option value="-1">--标记--</option>
  <!--{foreach from=$_G.setting.flag item=vv key=k}-->
   <option value="{$k}" {if $_GET.flag == "{$k}"} selected="selected" class="on"  {/if}>{$vv}</option>
  <!--{/foreach}-->
</select>
</li>


<li >
<select class="select_jump"  data-key="fid">
<option value="-1">--栏目--</option>
<option value="0" {if $_GET.fid == "0"} selected="selected" class="on"  {/if}>-未分类-</option>

<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $_GET.fid == $vv.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $_GET.fid == $vvv.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $_GET.fid == $a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>
</li>


<li >
<select class="select_jump"  data-key="cate">
<option value="-1">--分类--</option>
<!--{foreach from=$_G.goods_cate item=vv}-->
 <option value="{$vv.id}" {if $_GET.cate =="{$vv.id}"} selected {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.id}"  {if $_GET.cate =="{$vvv.id}"} selected {/if} >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}"  {if $_GET.cate =="{$a.id}"} selected {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>
</li>

<li >
<select class="select_jump" data-key="status">
<option value="-1">--状态--</option>
<!--{foreach from=$_G.setting.goods_status item=vv key=kk}-->
<option value="{$kk}" {if  $_GET.status=="{$kk}"} selected="selected"{/if} >{$vv}</option>
<!--{/foreach}-->
</select>
</li>



<li><a href="{$URL}m=tools&a=muster_sort" class="red">随机打乱今日商品</a></li>

        </ul>
  </div>

</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>

      <tr class="hover">
        <td>删除</td>
        <td>aid</td>
        <td >所属栏目</td>
        <td class="goods_title">标题</td>

        <td>显示状态</td>

        <td>优惠价</td>

        <td>佣金</td>
  <td>标记</td>
         <td>分类</td>

        <td>上线/下线时间</td>

        <td>排序</td>

        <td>编辑</td>
        <td>删除</td>

        <td>采集时间</td>


      </tr>
      <!--{foreach from=$goods item=v key=k}-->
      <tr class="hover">
        <td><input type="checkbox" name="del[{$v.aid}]" value="1" class="_del" />
          &nbsp;
          <input type="hidden" name="ids[{$v.aid}]" value="{$v.aid}" />
           <input type="hidden" name="num_iid[{$v.aid}]" value="{$v.num_iid}" />
          <a href="https://item.taobao.com/item.htm?id={$v.num_iid}" target="_blank" title="新窗口打开"> <img src="{$IMGDIR}/open.gif" ></a></td>
        <td title="{$v.num_iid}">{$v.aid}</td>
        <td >
        <!-- <a href="{$URL}m=goods&a=main&fid={$v.fid}">{$v.channel_name}</a> -->

<select name="fids[{$v.aid}]" class="select" >
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $v.fid==$vv.fid } selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $v.fid==$vvv.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $v.fid==$a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>



        </td>
        <td class="_hover_img goods_title" style="width:500px">
       <a href="{$v.url}" target="_blank">{if $v.title}{$v.title}{/if}</a>
        {if $v.shop_type==1}(商城){elseif $v.shop_type==2}(集市){/if}&nbsp;
        {if $v.hide == 1} <span class="red">(下架)</span>{/if}

        {if $v.juan_url && $v.juan_price} <a href="{$v.juan_url}" class="red" target="_blank">({$v.juan_price}元券)</a>{/if}

        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
        </td>

        <td title="商品 {$v.status_text}" >{if $v.status==1}正常显示{else}<span class="red">{$v.status_text}</span>{/if}</td>

        <td><div class="price">{$v.yh_price}</div></td>
         <td class="commission" title="{$v.yongjin}" data-iid="{$v.num_iid}">{$v.bili}%</td>

           <td><select name="flags[{$v.aid}]">
            <!--{foreach from=$_G.setting.flag item=vv key=k}-->
            <option value="{$k}" {if $v.flag==$k} selected="selected"{/if} >{$vv}</option>
            <!--{/foreach}-->
          </select></td>


           <td>

<select name="cate[{$v.aid}]" class="select_fid">
<option value="0">----请选择分类----</option>
<!--{foreach from=$_G.goods_cate item=vv}-->
<option value="{$vv.id}" {if $v.cate == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
    <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}" {if $v.cate == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
        <!--{if $vvv.sub}-->
         <!--{foreach from=$vvv.sub item=a}-->
         <option value="{$a.id}" {if $v.cate == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
        <!--{/foreach}-->
        <!--{/if}-->
    <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>

          </td>

        <td><p><input type="text" name="start_time[{$v.aid}]" value="{$v.start_time}" class="txt _dateline" /></p>
        <p><input type="text" name="end_time[{$v.aid}]" value="{$v.end_time}" class="txt _dateline" /></p>
        </td>


        <td><input type="text" name="sort[{$v.aid}]" value="{$v.sort}"  class="txt w40"/></td>

        <td><a href="{$URL}m=goods&a=post&aid={$v.aid}&page={$_G.page}">编辑</a></td>

        <td><a href="{$URL}m=goods&a=del&aid={$v.aid}&page={$_G.page}" class="_confirm" data-msg="您确定删除本商品?删除后不可恢复">删除</a></td>

        <td  class="_dgmdate" data-time="{$v.dateline}" title="发布时间:{dgmdate($v.posttime,'u')}"></td>

      </tr>
      <!--{/foreach}-->

     <tr>
      <td class="td28" colspan="4"><input type="checkbox" class="_del_all" />反选  (选中的才会执行相关操作...)
{if $_G.setting.api_type == 1}
      <input type="button" class="btn update_btn" value="一键更新本页商品">
{/if}
      </td>
      <td colspan="13"><div class="y">{$showpage} </div></td>
     </tr>
      <tr>

        <td class="td28"><input type="checkbox" name="_del_all"  value="1"  />删除</td>
        <td  colspan="13">
          <div class="fixsel cl">





<select name="in_fid" class="select_fid">
 <option value="0">请选择要移动的栏目</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}">&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>


标记:<select name="flag_in">
 <option value="-1">请选择要修改的标记</option>
  <!--{foreach from=$_G.setting.flag item=vv key=k}-->
  <option value="{$k}">{$vv}</option>
  <!--{/foreach}-->
</select>&nbsp;&nbsp;


<select name="cate_in" class="select_fid">
 <option value="-1">请选择要移动的分类</option>
<!--{foreach from=$_G.goods_cate item=vv}-->
 <option value="{$vv.id}">&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>



 &nbsp;&nbsp;
<select name="status_in" class="select_fid">
 <option value="-1">设置商品状态</option>
<!--{foreach from=$_G.setting.goods_status item=vv key=k}-->
 <option value="{$kk}">&nbsp;&nbsp;&nbsp;&nbsp;{$vv}</option>
<!--{/foreach}-->
</select>



 &nbsp;&nbsp;
{if $_GET.fid}
<input type="hidden" name="cur_fid" value="{$_GET.fid}" />
{/if}

&nbsp;&nbsp;
上线时间:
<input type="text" name="start_time_in" value="" class="txt _dateline start_time_in" style="width:180px" />&nbsp;&nbsp;
下线时间:
<input type="text" name="end_time_in" value="" class="txt _dateline start_time_in" style="width:180px" />


          </div></td>

      </tr>
      <tr>
      	<td >&nbsp;</td>
          <td  colspan="15"><input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">&nbsp;&nbsp;全局设置,将会把所有选中的商品修改成此处设置的

          </td>
      </tr>
    </tbody>
  </table>
  </div>
    <input type="hidden" name="referer" value="{$url}" />
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
