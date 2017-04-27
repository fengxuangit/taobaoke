{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >

  <div class="table_top">共找到({$count})条幻灯片</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">id</th>
        <th>排序</th>
        <th>名称</th>
        <th>图片地址</th>
        <th>链接地址</th>
        <th>所属分类</th>
        <th>隐藏</th>
        <th>编辑</th>

        <th>删除</th>
        <th>添加时间</th>

      </tr>
      </tbody>
      <!--{foreach from=$pics item=v}-->
       <tbody>
      <tr class="hover">
        <td class="td25" >&nbsp;</td>
        <td>{$v.id}</td>
        <td>&nbsp;</td>
        <td colspan="5" class="red">{$v.name} ({$v.content})</td>
        <td><a href="{$URL}m=pics&a=type_post&id={$v.id}">编辑</a></td>

        <td><a href="{$URL}m=pics&a=type_del&id={$v.id}" >删除</a></td>
       <td>&nbsp;</td>
      </tr>
      </tbody>
{if $v.sub}
<tbody>
  <!--{foreach from=$v.sub item=vv}-->
    <tr class="hover">
        <td class="td25"><input type="checkbox" name="del[{$vv.id}]" value="1" class="_del" />
          <input type="hidden" name="ids[{$vv.id}]" value="{$vv.id}" /></td>
        <td>&nbsp;</td>
        <td><div class="board"><input type="text" name="sort[{$vv.id}]" value="{$vv.sort}"  class="w40"/></div></td>
        <td><div class="board">{$vv.title}</div></td>

        <td class="_hover_img"><input type="text" name="picurl[{$vv.id}]" value="{$vv.picurl}"  />
        <a href="{$vv.picurl}" target="_blank"><img src="{$vv.picurl}"  /></a>
        </td>
        <td><input type="text" name="url[{$vv.id}]" value="{$vv.url}"  /></td>
        <td >
        <select name="fup[{$vv.id}]">
          <!--{foreach from=$_G.pics_type item=vvv}-->
         <option value="{$vvv.id}" {if $vv.fup == $vvv.id} selected="selected" {/if} >{$vvv.name}</option>
          <!--{/foreach}-->
          </select>
        </td>

        <td><input type="checkbox" name="hide[{$vv.id}]" value="1" {if $vv.hide==1} checked="checked" {/if} /></td>
        <td><a href="{$URL}m=pics&a=post&id={$vv.id}">编辑</a></td>

        <td><a href="{$URL}m=pics&a=del&id={$vv.id}" >删除</a></td>
         <td  class="_dgmdate" data-time="{$vv.dateline}"></td>

      </tr>
    <!--{/foreach}-->
</tbody>
{/if}
       <!--{/foreach}-->
       <tbody>
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />反选</td>
         <td class="td25"><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="8"><div class="fixsel">
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
