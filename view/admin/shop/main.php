{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >
  

  
<div class="table_top">
 <div class="table_top_l">共找到({$count})条店铺信息</div>
     <div class="table_top_r">
        <ul>


<li><a href="{$URL}m=shop&a=main"><span>全部</span></a></li>
  
  <li class="red">所属分类</li> 
  <!--{foreach from=$_G.shop_cate item=v }-->
  <li {if  $_GET.cate == $v.id }class="on"{/if}><a href="{$URL}m=shop&a=main&cate={$v.id}"><span>{$v.name}</span></a></li>
  <!--{/foreach}-->

<li  class="red">店铺类型</li>
  <li {if $_GET.shop_type=='0'}class="on"{/if}><a href="{$URL}m=shop&a=main&shop_type=0"><span>商城</span></a></li>  
  <li {if $_GET.shop_type &&  $_GET.shop_type==1}class="on"{/if}><a href="{$URL}m=shop&a=main&shop_type=1"><span>商城</span></a></li>
<li {if $_GET.shop_type &&  $_GET.shop_type==2}class="on"{/if}><a href="{$URL}m=shop&a=main&shop_type=2"><span>集市</span></a></li>

  
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
          <td class="td28">促销标题</td>
          <td >店铺类型</td>
          <td >店铺分类</td>
           <td >店铺标签</td>
          <td>店标图片</td>     

          <td>旺旺</td>
          <td>隐藏</td>
          <td>编辑</td>
          <td>删除</td>
          <td>添加时间</td>
        </tr>
      </tbody>
      {foreach from=$goods item=v}
        <tr class="hover" >
          <td  class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
            <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" />
            <input type="hidden" name="sid[{$v.id}]" value="{$v.sid}" />
            </td>
          <td  class="td25">
          <a href="{$URL}m=goods&a=main&nick={$v.nick}" target="_blank">{$v.id}</a>&nbsp;
          <a href="{$v.url}" target="_blank" title="点击查看"><img src="{$IMGDIR}/open.gif" ></a></td>
          <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}" class="w40"></td>
          <td  class="_hover_img td28" style="width:320px;">
          
          <a href="{$v.id_url}" target="_blank">{$v.title}</a>
          <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
          </td>
           <td >
          <select name="shop_type[{$v.id}]">
          
          	<option value="0" {if $v.shop_type==0} selected="selected"{/if}>未知</option>
              <option value="1" {if $v.shop_type==1} selected="selected"{/if} >集市</option>
              <option value="2" {if $v.shop_type==2} selected="selected"{/if} >商城</option>
          </select> 
           </td>
          <td >
          <select name="cate[{$v.id}]">
        <option value="0">----请选择店铺分类----</option>
       <!--{foreach from=$_G.shop_cate item=vv}-->
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
          
         <td >
          <select name="shop_tag[{$v.id}]">
         <!-- {foreach from=$_G.setting.shop_tag item = vv key = kk }-->
          <option value="{$kk}" {if $kk == $v.shop_tag} selected="selected"{/if}>{$vv}</option>
          <!--{/foreach}-->
          </select> 
          </td>
          <td class="_hover_img"><a href="{$v.pic_path}" target="_blank">点击查看</a>
          <a href="{$v.pic_path}" target="_blank"><img src="{$v.pic_path}"  /></a>
          </td>
          
       
          <td><a href="" class="_wangwang" data-nick="{$v.nick}" title="点击这里给我发消息"></a>
          </td>
          <td ><input type="checkbox" name="hide[{$v.id}]" value="1" {if $v.hide==1} checked{/if}></td>
          <td ><a href="{$URL}m=shop&a=post&id={$v.id}">编辑</a></td>
          <td><a href="{$URL}m=shop&a=del&id={$v.id}">删除</a></td>
          <td  class="_dgmdate" data-time="{$v.dateline}"></td>
        </tr>
      {/foreach}
        <tr>
          <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
          <td  class="td25"><input type="checkbox"  name="_del_all" value="1"/>删除</td>
          <td  colspan="11"><div class="y">{$showpage}</div>
            <div class="fixsel">
            
             <select name="shop_type_in">
             <option value="-1" >店铺类型</option>
              <option value="1" >集市</option>
              <option value="2" >商城</option>
          </select> &nbsp;&nbsp;&nbsp;
            
              <select name="cate_in">
               <option value="-1" >----请选择店铺分类----</option>
            
 <option value="-1">请选择要移动的分类</option>
<!--{foreach from=$_G.shop_cate item=vv}-->
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
            
            <select name="shop_tag_in">
             <option value="-1" >店铺标签</option>
             <!-- {foreach from=$_G.setting.shop_tag item = vv key = kk }-->
              <option value="{$kk}" >{$vv}</option>
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