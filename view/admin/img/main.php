{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="POST"  action="">
  
  <div class="table_top">
 <div class="table_top_l">共找到({$count})条值得买信息</div>
     <div class="table_top_r">
        <ul>

<li><a href="{$URL}m=img&a=main"><span>全部</span></a></li>
  <!--{foreach from=$_G.img_cate item=v }-->
  <li {if  $_GET.cate == $v.id }class="on"{/if}><a href="{$URL}m=img&a=main&cate={$v.id}"><span>{$v.name}</span></a></li>
  <!--{/foreach}-->
<li {if  $_GET.hide ==1}class="on"{/if}><a href="{$URL}m=img&a=main&hide=1"><span>隐藏</span></a></li>
<li {if  $_GET.hide ==2}class="on"{/if}><a href="{$URL}m=img&a=main&hide=2"><span>非隐藏</span></a></li>
<li {if  $_GET.picurl ==1}class="on"{/if}><a href="{$URL}m=img&a=main&picurl=1"><span>有图片</span></a></li>
<li {if  $_GET.picurl ==2 }class="on"{/if}><a href="{$URL}m=img&a=main&picurl=2"><span>无图片</span></a></li>
<li {if  $_GET.url ==1}class="on"{/if}><a href="{$URL}m=img&a=main&url=1"><span>有跳转</span></a></li>
<li {if  $_GET.url ==2}class="on"{/if}><a href="{$URL}m=img&a=main&url=2"><span>无跳转</span></a></li>

        </ul>
  </div>  

</div>

    <div class="table_main">
  <table class="tb tb2 ">
    <tbody>      
      <tr class="hover">
        <th class="td25">删除</th>
        <th>id</th>
        <th>排序</th>
        <th  class="goods_title">标题</th>
        <th>分类</th>
        <th>发布时间</th>
        <th>喜欢</th>
        <th>踩</th>
        <th>隐藏</th>
        <th>编辑</th>
        <th>删除</th>
      </tr>
      <!--{foreach from=$img item=v}-->
      <tr class="hover">
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
               <td><a href="/index.php?m=img&id={$v.id}" target="_blank">{$v.id}</a></td>
        <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}"  class="w40"/></td>
        <td class="goods_title _hover_img"><a href="/index.php?m=img&id={$v.id}" target="_blank">{$v.title}</a>
        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
        </td>

 <td >
          <select name="cate[{$v.id}]">
        <option value="0">----请选择分类----</option>
       <!--{foreach from=$_G.img_cate item=vv}-->
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
        </td>
        <td  class="_dgmdate" data-time="{$v.dateline}"></td>
        <td><input type="text" name="like[{$v.id}]" value="{$v.like}"  class="w40"/></td>
         <td><input type="text" name="hate[{$v.id}]" value="{$v.hate}"  class="w40"/></td>
        <td><input type="checkbox" name="hide[{$v.id}]" value="1" {if $v.hide==1} checked="checked" {/if} /></td>
        <td><a href="{$URL}m=img&a=post&id={$v.id}">编辑</a></td>
        <td><a href="{$URL}m=img&a=del&id={$v.id}" >删除</a></td>
      </tr>
      <!--{/foreach}-->
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
          <td class="td25"><input type="checkbox"  name="_del_all" value="1"/>删除</td>
          <td class="td25">
          <select name="cates">
        <option value="0">----请选择分类----</option>
       <!--{foreach from=$_G.img_cate item=vv}-->
<option value="{$vv.id}" >&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
    <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
        <!--{if $vvv.sub}-->
         <!--{foreach from=$vvv.sub item=a}-->
         <option value="{$a.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
        <!--{/foreach}-->
        <!--{/if}-->  
    <!--{/foreach}-->	
<!--{/if}-->              
<!--{/foreach}-->
          </select> 
          
          </td>
          
        <td colspan="7">
        <div class="y">{$showpage}</div>
        <div class="fixsel">

            <input type="submit" class="btn submit_btn" name="onsubmit"  value=" 提 交" >
          </div></td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 