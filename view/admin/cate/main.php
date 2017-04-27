{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >

<div class="table_top">共找到({$count})条分类信息</div>
  <div class="table_main">

  <table class="tb tb2 nobdb" >
    <tbody>

      <tr class="hover" >
        <td class="td25">id</td>
        <td class="td25">排序</td>
        <td class="td28">分类名称</td>

         <td class="td28">分类图片</td>
          <td class="td28">分类图片链接</td>

        <td class="td28">上级分类</td>
        <td class="td28">隐藏</td>
         <td class="td28">编辑/删除</td>
        <td class="td28">清空商品</td>

      </tr>
      </tbody>
    {foreach from=$cate item=v}
     <tbody>
      <tr class="hover" >
        <td class="td25"><a href="{$URL}m={$CM}&a=main&cate={$v.id}">{$v.id}</a>&nbsp;

        <a href="index.php?{if $CM=='goods'}a=cate&id={$v.id}{else}m={$CM}&a=list&cate={$v.id}{/if}" target="_blank" title="前台查看">
        <img src="{$IMGDIR}/open.gif" ></a>
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}"></td>
        <td class="td25"><input type="text" name="sort[{$v.id}]" value="{$v.sort}" class="w40"></td>
        <td class="td28">
          <input type="text" name="name[{$v.id}]" value="{$v.name}">1级</td>

           <td class="td28 _hover_img"> <input type="text" name="picurl[{$v.id}]" value="{$v.picurl}">
             <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}" /></a>
           </td>
         <td class="td28"> <input type="text" name="pic_url[{$v.id}]" value="{$v.pic_url}"></td>


        <td class="td28">
        <select name="fup[{$v.id}]" class="fup select_id">
 <option value="0" {if $v.id==0} selected="selected" class="on"  {/if}>----顶级分类----</option>
<!--{foreach from=$cate item=vv}-->
 <option value="{$vv.id}" {if $v.fup==$vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.id}" {if $v.id==$vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub ==3}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $v.id==$a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>

          </td>
        <td class="td28"><input type="checkbox" name="hide[{$v.id}]" value="{$v.id}" {if $v.hide==1} checked{/if}></td>
        <td class="td28"><a href="{$URL}m={$CM}&a=cate_post&id={$v.id}">编辑</a>&nbsp;
        <a href="{$URL}m={$CM}&a=cate_del&id={$v.id}">删除</a></td>
        <td class="td28"><a href="{$URL}m={$CM}&a=cate_clear&id={$v.id}">清空商品({$v.count})</a></td>
      </tr>
      </tbody>

<!--显示二级分类-->
{if $v.sub}

        <!--{foreach from=$v.sub item=v1}-->
         <tbody>
        <tr class="hover" >
          <td class="td28"><a href="{$URL}m={$CM}&a=main&cate={$v1.id}">{$v1.id}</a>&nbsp;&nbsp;
           <a href="index.php?m={$CM}&id={$v1.id}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif" ></a>
            <input type="hidden" name="ids[{$v1.id}]" value="{$v1.id}"></td>
          <td class="td25" >
          <div class="board">
          <input type="text" name="sort[{$v1.id}]" value="{$v1.sort}"  class="w40">
          </div>
          </td>
          <td class="td28"><div class="board"> <input type="text" name="name[{$v1.id}]" value="{$v1.name}">2级</div>
            </td>

         <td class="td28 _hover_img"> <input type="text" name="picurl[{$v1.id}]" value="{$v1.picurl}">
           <a href="{$v1.picurl}" target="_blank"><img src="{$v1.picurl}" /></a>
         </td>
         <td class="td28"> <input type="text" name="pic_url[{$v1.id}]" value="{$v1.pic_url}"></td>


          <td class="td28"><select name="fup[{$v1.id}]" class="fup">
           <option value="0" {if $v1.id==0} selected="selected" class="on"  {/if}>----顶级分类----</option>
            <!--{foreach from=$cate item=vv}-->
             <option value="{$vv.id}" {if $v1.fup==$vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
                    <!--{if $vv.sub}-->
                          <!--{foreach from=$vv.sub item=vvv}-->
                              <option value="{$vvv.id}" {if $v1.fup==$vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
                              <!--{if $vvv.sub ==3}-->
                                   <!--{foreach from=$vvv.sub item=a}-->
                                   <option value="{$a.id}" {if $v1.fup==$a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
                                  <!--{/foreach}-->
                             <!--{/if}-->
                         <!--{/foreach}-->
       				 <!--{/if}-->
       	 <!--{/foreach}-->
            </select></td>
          <td><input type="checkbox" name="hide[{$v1.id}]"  value="{$v1.id}" {if $v1.hide==1} checked{/if}></td>
          <td><a href="{$URL}m={$CM}&a=cate_post&id={$v1.id}">编辑</a>&nbsp;
          <a href="{$URL}m={$CM}&a=cate_del&id={$v1.id}"  class="_confirm" data-msg="您确定要删除当前分类吗?删除后不可恢复">删除</a></td>
          <td> <a href="{$URL}m={$CM}&a=cate_clear&id={$v1.id}" >清空商品({$v1.count})</a></td>
        </tr>












<!--显示三级分类-->
{if $v1.sub}
    <tbody>
        <!--{foreach from=$v1.sub item=a1}-->
        <tr class="hover" >
          <td class="td28"><a href="{$URL}m={$CM}&a=main&cate={$a1.id}">{$a1.id}</a>&nbsp;&nbsp;
           <a href="index.php?m={$CM}&id={$va.id}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif" ></a>
            <input type="hidden" name="ids[{$a1.id}]" value="{$a1.id}"></td>
          <td class="td25" >
          <div class="board"  style="margin-left: 30px;">
         	 <input type="text" name="sort[{$a1.id}]" value="{$a1.sort}"  class="w40">
          </div>
          </td>
          <td class="td28"><div class="board" style="margin-left: 70px;"> <input type="text" name="name[{$a1.id}]" value="{$a1.name}"><span class="red">3级</span></div>
            </td>

             <td class="td28 _hover_img"> <input type="text" name="picurl[{$a1.id}]" value="{$a1.picurl}">
             <a href="{$a1.picurl}" target="_blank"><img src="{$a1.picurl}" /></a>
             </td>
         <td class="td28"> <input type="text" name="pic_url[{$a1.id}]" value="{$a1.pic_url}"></td>

          <td class="td28"><select name="fup[{$a1.id}]" class="fup">
           <option value="0" {if $a1.id==0} selected="selected" class="on"  {/if}>----顶级分类----</option>
            <!--{foreach from=$cate item=vv}-->
             <option value="{$vv.id}" {if $a1.fup==$vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
                    <!--{if $vv.sub}-->
                          <!--{foreach from=$vv.sub item=vvv}-->
                              <option value="{$vvv.id}" {if $a1.fup==$vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
                              <!--{if $vvv.sub ==3}-->
                                   <!--{foreach from=$vvv.sub item=a}-->
                                   <option value="{$a.id}" {if $a1.fup==$a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
                                  <!--{/foreach}-->
                             <!--{/if}-->
                         <!--{/foreach}-->
       				 <!--{/if}-->
       	 <!--{/foreach}-->
            </select></td>
          <td><input type="checkbox" name="hide[{$a1.id}]"  value="{$a1.id}" {if $a1.hide==1} checked{/if}></td>
          <td><a href="{$URL}m={$CM}&a=cate_post&id={$a1.id}">编辑</a>&nbsp;
              <a href="{$URL}m={$CM}&a=cate_del&id={$a1.id}" >删除</a></td>
          <td><a href="{$URL}m={$CM}&a=cate_clear&id={$a1.id}" >清空商品({$a1.count})</a></td>
        </tr>
        <!--{/foreach}-->
    </tbody>

{/if}


         </tbody>
        <!--{/foreach}-->

{/if}

    {/foreach}
	 <tbody class="tb tb2 ">
      <tr>
      <td>&nbsp;</td>
        <td colspan="4"><div class="fixsel">
            <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改"></div></td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
