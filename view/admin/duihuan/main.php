{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post"  >

<div class="table_top">
   <div class="table_top_l">共找到({$count})个兑换商品信息</div>
      <div class="table_top_r">
      <ul>
       <li><a href="{$URL}m=duihuan&a=main">全部</a></li>
        <!--{foreach from=$_G.duihuan_cate item=vv key=k}-->
              <li {if $_GET.cate && $_GET.cate==$k}class="on"{/if}><a href="{$URL}m=duihuan&a=main&cate={$k}">{$vv.name}</a></li>
        <!--{/foreach}-->
      
        
      </ul>
      </div>
  </div>
  
  
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <td>删除</td>
          <td>id</td>
          <td  class="goods_title">标题</td> 
          <td>标签/分类</td>

          <td>兑换状态</td>


          <td>上线/下线时间</td>

          <td>所需积分</td>
          <td>兑换总数</td>
          <td>兑换成功</td>
          
          <td>排序</td>
          <td>下架</td>
          <td>编辑</td>
          <td>添加时间</td>
        </tr>
        <!--{foreach from=$goods item=v}-->
        <tr class="hover">
          <td><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
            &nbsp;
            <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" />
            <a href="{$v.id_url}" target="_blank" title="新窗口打开"> <img src="{$IMGDIR}/open.gif" ></a></td>
          <td><a href="index.php?m=duihuan&a=apply&id={$v.id}" target="_blank">{$v.id}</a></td>
          <td class="_hover_img goods_title"><a href="{$v.id_url}" target="_blank">{$v.title}</a> <span class="red">({$v.count}人申请)</span>
           {if $v.picurl}<a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}" alt="" /></a>{/if}
          </td>
           <td>
			 <select name="cate[{$v.id}]">

               <!--{foreach from=$_G.duihuan_cate item=vv key=k}-->
            <option value="{$k}" {if $v.cate==$k} selected="selected"{/if} >{$vv.name}</option>
            <!--{/foreach}-->
              </select>
          </td>
          

          <td>{if $v.status}{$v.status_text}{else}<span class="red">{$v.status_text}</span>{/if}</td>

          <td>
          <p><input type="text" name="start_time[{$v.id}]" value="{$v.start_time}" class="txt _dateline" /></p>
          <p><input type="text" name="end_time[{$v.id}]" value="{$v.end_time}" class="txt _dateline" /></p></td>

          <td>{$v.jf}</td>
          
          <td>{$v.sum}</td>
          <td>{$v.num}</td>
          
          <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}"  class="txt w40"/></td>
          <td><input type="checkbox" name="hide[{$v.id}]" value="1" {if $v.hide==1} checked="checked" {/if} /></td>
          <td><a href="{$URL}m=duihuan&a=post&id={$v.id}&page={$_G.page}">编辑</a></td>
          <td  class="_dgmdate" data-time="{$v.dateline}"></td>
        </tr>
        <!--{/foreach}-->
        
        <tr>
          <td class="td28" colspan="4"><input type="checkbox" class="_del_all" />
            反选  (选中的才会执行相关操作...)</td>
          <td colspan="12"><div class="y">{$showpage} </div></td>
        </tr>
        <tr>
          <td class="td28"><input type="checkbox" name="_del_all"  value="1"  />
            删除</td>

          <td class="td28"><input type="checkbox" name="hide_in"  value="1" />
           下架</td>
          <td  colspan="12"><input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
            提示:上方有独立选择了类型或分类,则不采用此处全部设置</td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 