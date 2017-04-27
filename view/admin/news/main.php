{include file='../common_admin/left_bar.php'}

  
  <div class="table_top">
  <div class="table_top_l">共找到({$count})条相关信息</div>
      <div class="table_top_r">
        <ul>
<li {if $_GET.image_type == "2"}on{/if}> <a href="{$URL}m=news&a=main&image_type=2">视频</a></li>
<li {if $_GET.image_type == "1"}on{/if}> <a href="{$URL}m=news&a=main&image_type=1">大图</a></li>
<li {if $_GET.image_type == "0"}on{/if}> <a href="{$URL}m=news&a=main&image_type=0">小图</a></li>
<li {if $_GET.goods == "1"}on{/if}> <a href="{$URL}m=news&a=main&goods=1">无单品</a></li>

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
        
        <th>标题</th>
          <th>喜欢</th>
        <th>分类</th>
       


        <th>添加时间</th>

		<th>排序</th>
        <th>编辑</th>
        <th>删除</th>
      </tr>
      <!--{foreach from=$goods item=v name=f}-->
      <tr class="hover">
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del del_{$smarty.foreach.f.index}" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}"  class="ids"/></td>
        <td>{$v.id}</td>

        <td class="_hover_img" news="width:350px;">      
        <!-- <input type="text" name="title[{$v.id}]"  value="{$v.title}" news="width:300px" /> -->  
        <span class="" news="width:300px;overflow:hidden;height:16px;display:block;float:left;">
        <a href="{$v.url}" target="_blank">{$v.title}</a>
        </span> ({$v.count}条)
        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>        
        </td>

          <td><!-- <input type="text" name="like[{$v.id}]" value="{$v.like}" class="w40"/> -->  {$v.like}</td>

        <td>
        
<select name="cates[{$v.id}]" class="fup select_fid">
{foreach from=$_G.news_cate item=vv key=kk}
 <option value="{$vv.id}" {if $v.cate==$vv.id} selected="selected" class="on"  {/if}>{$vv.name}</option>
{/foreach}
</select>

        </td>
        

        <td  class="_dgmdate" data-time="{$v.dateline}"></td>

   <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}" class="w40"/></td>

        <td><a href="{$URL}m=news&a=post&id={$v.id}">编辑</a></td>
        <td><a href="{$URL}m=news&a=del&id={$v.id}&t=del&ok=1" class="_confirm" data-msg="您确定删除当前资讯信息吗?删除后不可恢复"  >删除</a></td>
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

