{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post"  >

<div class="table_top">

 <div class="table_top_l">共找到({$count})个商品信息</div>
     <div class="table_top_r">
        <ul>

<li>按条件查看商品</li>
<li><a href="{$URL}m=apply&a=main&checks=-1">全部</a></li>
<li {if $_GET.check && $_GET.checks==1}class="on"{/if}><a href="{$URL}m=apply&a=main&checks=1"><span>已审核</span></a></li>
<li {if $_GET.check && $_GET.checks==2}class="on"{/if}><a href="{$URL}m=apply&a=main&checks=2"><span>已拒绝</span></a></li>
<li {if $_GET.check && $_GET.checks==0}class="on"{/if}><a href="{$URL}m=apply&a=main&checks=0"><span>未审核</span></a></li>

{if $bm_status_text}
{foreach from=$bm_status_text item=v}
<li {if $_GET.check && $_GET.checks==$v.status}class="on"{/if}><a href="{$URL}m=apply&a=main&checks={$v.status}"><span>{$v.name}</span></a></li>

{/foreach}
{/if}

        </ul>
  </div>

</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>

      <tr class="hover">
        <td>删除</td>

        <td>报名用户</td>
        <td >所属栏目</td>
        <td class="goods_title">标题</td>
        <td>qq</td>
        <td>优惠价</td>
        <td>销量</td>
        <td>佣金</td>
        <td>分类</td>
         <td>上线/下线时间</td>
        <td>审核</td>
        <td>推荐理由</td>
        <td>删除</td>
        <td>报名时间</td>
      </tr>
      <!--{foreach from=$goods item=v key=k}-->
      <tr class="hover">
        <td>{$v.id}<input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
          &nbsp;
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" />
           <input type="hidden" name="num_iids[{$v.id}]" value="{$v.num_iid}" />
           </td>
        <td>{if $v.uid>0}<a href="{$URL}m=apply&a=main&uid={$v.uid}">{$v.username}</a>{else}游客{/if}</td>
        <td ><span class="channel_name_{$k}">{$v.channel_name}</span> <a  class=" red change_fid " data-index="{$k}">修改栏目</a>
         <input type="hidden" name="fids[{$v.id}]" value="{$v.fid}" class="fid_{$k}" />
        </td>
        <td class="_hover_img goods_title" style="width:430px">

       <input type="text" name="titles[{$v.id}]" class="text" value="{$v.title}" style="width:370px;" />

        {if $v.shop_type==1}(商城){else}(淘宝){/if}&nbsp;
        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
        </td>

        <td >{if $v.qq}<a href="#" target="_blank" class="_qq" data-qq="{$v.qq}"></a>{/if}</td>
        <td> <input type="text" name="yh_prices[{$v.id}]" class="text w90" value="{$v.yh_price}" /></td>
        <td> <input type="text" name="sums[{$v.id}]" class="text w90" value="{$v.sum}" /></td>

        <td>{if $v.bili == "-1"} <span class="red">无佣金</span> {elseif $v.bili>0} {$v.bili}%{/if}&nbsp;</td>

        <td>

<select name="cates[{$v.id}]" class="select_fid">
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
           <td><p><input type="text" name="start_time[{$v.id}]" value="{$v.start_time}" class="txt _dateline" /></p>
        <p><input type="text" name="end_time[{$v.id}]" value="{$v.end_time}" class="txt _dateline" /></p>
        </td>

          <td>
          <select name="check_es[{$v.id}]" >
              <option value="0" {if $v.check ==0} selected{/if}>待审核</option>
              <option value="1" {if $v.check ==1} selected class="red"{/if}>通过</option>
              <option value="2" {if $v.check ==2} selected{/if}>拒绝</option>
{foreach from=$bm_status_text item=v1}
 <option value="{$v1.status}" {if $v.check ==$v1.status } selected{/if}>{$v1.name}</option>
{/foreach}
          </select>
          &nbsp; <a class="red msg_click" data-index="{$k}">留言</a>
          <input type="hidden" name="check_msgs[{$v.id}]" value="{$v.check_msg}" class="txt msg_{$k}" />

          </td>
             <td class="_showDialog " data-msg="{$v.ly}" data-status="success">点击查看</td>
        <td><a href="{$URL}m=apply&a=del&id={$v.id}&page={$_G.page}" class="_confirm" data-msg="您确定删除本商品?删除后不可恢复">删除</a></td>
        <td  class="_dgmdate" data-time="{$v.dateline}"></td>
      </tr>
      <!--{/foreach}-->



     <tr>
      <td class="td28" colspan="1"><input type="checkbox" class="_del_all" />反选 </td>
      <td colspan="12">审核:
       <select name="checks_in" >
        <option value="-1">无修改</option>
              <option value="0">待审核</option>
              <option value="1">通过</option>
              <option value="2">拒绝</option>
{foreach from=$bm_status_text item=v1}
 <option value="{$v1.status}" {if $v.check ==$v1.status } selected{/if}>{$v1.name}</option>
{/foreach}
      </select>
    拒绝理由 <input type="text" name="msgs" value="" class="txt" />
      <div class="y">{$showpage} </div></td>
     </tr>



      <tr>

        <td class="td28"><input type="checkbox" name="_del_all"  value="1"  />删除</td>
        <td  colspan="13">
          <div class="fixsel cl">


<select name="in_fid" class="select_fid">
 <option value="0">请选择要移动的栏目</option>
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


标记:<select name="flag_in">
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
上线时间:
<input type="text" name="start_time_in" value="" class="txt _dateline start_time_in" style="width:180px" />&nbsp;&nbsp;
下线时间:
<input type="text" name="end_time_in" value="" class="txt _dateline start_time_in" style="width:180px" />


          </div></td>

      </tr>


      <tr>
      	<td >&nbsp;</td>
          <td  colspan="11"><input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交">

          </td>
      </tr>


    </tbody>
  </table>
<div class="change_msg" style="display:none;position:absolute;background:#fff;padding:10px 20px;border:5px solid #ccc;">
<input type="text"  value="" class="txt msg_text"  />
<input type="button" class="btn msg_btn" value="确定">
&nbsp;&nbsp;<a href="#" class="close_msg">关闭</a>
</div>

<div class="change_channel " style="display:none;position:absolute;background:#fff;padding:20px;border:5px solid #ccc;">

<select class="select_channel_fid">
 <option value="0">请选择要移动的栏目</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" >&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>
<input type="button" class="btn channel_btn" value="确定">
&nbsp;&nbsp;<a href="#" class="close_channel">关闭</a>
</div>

  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
