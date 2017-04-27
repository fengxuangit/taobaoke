{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  
  <div class="table_top">共找到({$count})条友情链接</div>
    <div class="table_main">
  <table class="tb tb2 ">
    <tbody>      
      <tr class="hover">
        <th class="td25">删除</th>
        <th>id</th>
        <th>排序</th>
        <th>网站名称</th>
        <th>网站地址</th>
        <th>内容</th>
        <th>类型</th>
       <th title="是否存在本站友链">是否存在</th>
        <th>添加时间</th>
        <th>隐藏</th>
        <th>编辑</th>
        <th>删除</th>
      </tr>
      <!--{foreach from=$_G.friend_link item=v name=f}-->
      <tr class="hover _hover_img">
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del del_{$smarty.foreach.f.index}" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}"  class="ids"/></td>
        <td>{$v.id}</td>
        <td><input type="text" name="sort[{$v.id}]" value="{$v.sort}"  class="w40"/></td>
        <td>{$v.name}
        <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>
        </td>
        <td><a href="{$v.url}" target="_blank">{$v.name}</a></td>
        <td>{$v.content}</td>
        <td>{if $v.picurl}图片链{else}文字链{/if}</td>
       <td class="frined_{$smarty.foreach.f.index}"   title="是否存在本站友链">{if $v.extends==1}是{elseif $v.extends==0} <span class="red">否</span>{else}未知 {/if}</td>
        <td  class="_dgmdate" data-time="{$v.dateline}"></td>
        <td><input type="checkbox" name="hide[{$v.id}]" value="1" {if $v.hide==1} checked="checked" {/if} /></td>
        <td><a href="{$URL}m=module&a=friend_link_add&id={$v.id}">编辑</a></td>
        <td><a href="{$URL}m=module&a=friend_link&id={$v.id}&t=del" >删除</a></td>
      </tr>
      <!--{/foreach}-->
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
                  <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="8">
        
          {if $TAE==0}
          <input type="button" class="check_friend_link y"  value=" 一键检查所有"  style="margin: 3px 0;padding: 5px 10px;border-color: #DDD #666 #666 #DDD;background: #DDD;color: #000;cursor: pointer;vertical-align: middle;">
          {/if}
        <div class="fixsel">
            <input type="submit" class="btn submit_btn" name="onsubmit"  value=" 提 交" >
          </div>
        
          
          </td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 