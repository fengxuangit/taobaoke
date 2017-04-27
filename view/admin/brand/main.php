{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >
  

  
<div class="table_top">
 <div class="table_top_l">共找到({$count})条品牌信息</div>
     <div class="table_top_r">
        <ul>


<li><a href="{$URL}m=brand&a=main"><span>全部</span></a></li>
  
  <li class="red">所属分类</li> 
  <!--{foreach from=$_G.brand_cate item=v }-->
  <li {if  $_GET.cate == $v.id }class="on"{/if}><a href="{$URL}m=brand&a=main&cate={$v.id}"><span>{$v.name}</span></a></li>
  <!--{/foreach}-->

  
        </ul>
  </div>  

</div>

  
  <div class="table_main">
    <table class="tb tb2 nobdb" >
      <tbody>
        <tr class="hover" >
          <td  class="td25">删除</td>
          <td  class="td25">id</td>
          <td >排序</td>
          <td class="td28">品牌名称</td>
          <td >品牌分类</td>
          <td>品牌logo</td>     
          <td>推荐</td>     

          <td>编辑</td>
          <td>删除</td>
          <td>添加时间</td>
        </tr>
      </tbody>
      {foreach from=$goods item=v}
        <tr class="hover" >
          <td  class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
            <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" />
          
            </td>
          <td  class="td25">
          <a href="{$URL}m=goods&a=main&brand_id={$v.id}" target="_blank">{$v.id}</a>&nbsp;
          <a href="{$v.url}" target="_blank" title="点击查看"><img src="{$IMGDIR}/open.gif" ></a></td>
          <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}" class="w40"></td>
          <td  class="_hover_img td28" style="width:320px;">
          
          <a href="{$URL}m=goods&a=main&brand_id={$v.id}" target="_blank">{$v.name}</a>
          <span class="red">({$v.count})</span>
          <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
          </td>
          
          <td >
          <select name="cate[{$v.id}]">
        <option value="0">----请选择品牌分类----</option>
       <!--{foreach from=$_G.brand_cate item=vv}-->
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

          <td class="_hover_img"> 

  <input type="text" name="picurls[{$v.id}]" value="{$v.picurl}" style="width: 350px" />
      <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
          </td>

          <td >
            

             <select name="tuis[{$v.id}]">
           
            <option value="0" {if $v.tui=="0"} selected="selected"{/if} >否</option>
            <option value="1" {if $v.tui=="1"} selected="selected"{/if} >是</option>
          </select></td>

          <td ><a href="{$URL}m=brand&a=post&id={$v.id}">编辑</a></td>
          <td><a href="{$URL}m=brand&a=del&id={$v.id}">删除</a></td>
          <td  class="_dgmdate" data-time="{$v.dateline}"></td>
        </tr>
      {/foreach}
        <tr>
          <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
          <td  class="td25"><input type="checkbox"  name="_del_all" value="1"/>删除</td>
          <td  colspan="11"><div class="y">{$showpage}</div>
            <div class="fixsel">
            
            
              <select name="cate_in">
               <option value="-1" >----请选择品牌分类----</option>
            
<!--{foreach from=$_G.brand_cate item=vv}-->
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

              
              </select> &nbsp;&nbsp;&nbsp;            
            
          
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改">
              
            </div></td>
        </tr>

    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 