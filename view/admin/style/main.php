{include file='../common_admin/left_bar.php'}

  
  <div class="table_top">
  <div class="table_top_l">共找到({$count})条相关信息</div>
      <div class="table_top_r">
        <ul>


<li><a href="{$URL}m=style&a=main"><span>全部</span></a></li>
<li {if  $_GET.danpin ==1}class="on"{/if}><a href="{$URL}m=style&a=main&danpin=1"><span>0单品</span></a></li>
<li {if  $_GET.check ==1}class="on"{/if}><a href="{$URL}m=style&a=main&check=1"><span>已审核</span></a></li>
<li {if  $_GET.check ==0}class="on"{/if}><a href="{$URL}m=style&a=main&check=0"><span>待审核</span></a></li>

   
<li>标签:</li>
  <!--{foreach from=$_G.style_cate item=vv key=k}-->

  <li {if  $_GET.cate== $vv.id  }class="on"{/if}><a href="{$URL}m=style&a=main&cate={$vv.id}"><span>{$vv.name}</span></a></li>
  <!--{/foreach}-->
        </ul>
  </div>  
  
  
  </div>
  <form enctype="multipart/form-data" method="post" action="">
    <div class="table_main">
  <table class="tb tb2 ">
    <tbody>      
      <tr class="hover">
        <th class="td25">删除</th>
        <th>id</th>
        
        <th>发布者</th>
        <th>标题</th>
          <th>喜欢</th>
        <th>分类</th>
       


        <th>添加时间</th>

		<th>排序</th>
		<th>审核</th>
        <th>编辑</th>
        <th>删除</th>
      </tr>
      <!--{foreach from=$goods item=v name=f}-->
      <tr class="hover">
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del del_{$smarty.foreach.f.index}" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}"  class="ids"/></td>
        <td>{$v.id}</td>
     	<td><a href="{$URL}m=style&a=main&uid={$v.uid}">{$v.username}</a></td>

        <td class="_hover_img" style="width:350px;">      
        <!-- <input type="text" name="title[{$v.id}]"  value="{$v.title}" style="width:300px" /> -->  
        <span class="" style="width:300px;overflow:hidden;height:16px;display:block;float:left;">
        <a href="{$v.url}" target="_blank">{$v.title}</a>
        </span> ({$v.length}条)
        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>        
        </td>

          <td><!-- <input type="text" name="like[{$v.id}]" value="{$v.like}" class="w40"/> -->  {$v.like}</td>

        <td>
        
<select name="cates[{$v.id}]" class="fup select_fid">
{foreach from=$_G.style_cate item=vv key=kk}
 <option value="{$vv.id}" {if $v.cate==$vv.id} selected="selected" class="on"  {/if}>{$vv.name}</option>
{/foreach}
</select>

        </td>
        

        <td  class="_dgmdate" data-time="{$v.dateline}"></td>

   <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}" class="w40"/></td>
   	<td>
    
<select name="check[{$v.id}]" class="fup select_fid">

 <option value="0" {if $v.check==0} selected="selected" class="on"  {/if}>待审核</option>
  <option value="1" {if $v.check==1} selected="selected" class="on"  {/if}>已通过</option>
   <option value="2" {if $v.check==2} selected="selected" class="on"  {/if}>未通过</option>

</select>
    </td>
        <td><a href="{$URL}m=style&a=post&id={$v.id}">编辑</a></td>
        <td><a href="{$URL}m=style&a=del&id={$v.id}&t=del&ok=1" class="_confirm" data-msg="您确定删除当前搭配信息吗?删除后不可恢复"  >删除</a></td>
      </tr>
      <!--{/foreach}-->
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
       <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="9">
        <div class="y">{$showpage} </div>
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

