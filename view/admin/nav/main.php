{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >


 <div class="table_top">
  <div class="table_top_l">共找到({$count})条导航信息</div>
      <div class="table_top_r">
        <ul>

<li><a href="{$URL}m=nav&a=main"><span>全部</span></a></li>

 {foreach from=$_G.setting.nav item=v key=k}
<li {if  $_GET.types =="{$k}"}class="on"{/if}><a href="{$URL}m=nav&a=main&types={$k}"><span>{$v}</span></a></li>
 {/foreach}
  </ul>

</div>


  </div>

  <div class="table_main">

  <table class="tb tb2 nobdb" >
    <tbody>

      <tr class="hover" >
        <td class="td25">删除</td>
        <td class="td25">排序</td>
        <td class="td28">导航名称</td>

        <td class="td28">导航链接</td>
         <td class="td28">导航class</td>
        <td class="td28">新窗口打开</td>

        <td class="td28">导航类型</td>

         <td class="td28">编辑</td>
         <td class="td28">删除</td>
         <td>添加时间</td>

      </tr>
      </tbody>
    {foreach from=$goods item=v name="f"}
     <tbody>
      <tr class="hover" >
        <td class="td25">
       {$v.id}&nbsp;<input type="checkbox" name="del[{$v.id}]" value="1" class="_del del_{$smarty.foreach.f.index}" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}"  class="ids"/></td>
        <td class="td25"><input type="text" name="sort[{$v.id}]" value="{$v.sort}" class="w40"></td>
        <td class="td28"> <input type="text" name="name[{$v.id}]" value="{$v.name}"></td>
         <td class="td28"> <input type="text" name="url[{$v.id}]" value="{$v.url}"></td>
		<td class="td28"> <input type="text" name="classname[{$v.id}]" value="{$v.classname}"></td>
        <td class="td28">

        <input type="checkbox" class="checkbox" name="target[{$v.id}]" value="1" {if $v.target=="1"} checked {/if}/>

        </td>

        <td class="td28">
            <select name="type[{$v.id}]" >
             {foreach from=$_G.setting.nav item=v1 key=k1}
              <option value="{$k1}" {if $v.type == $k1} selected {/if}>{$v1}</option>
             {/foreach}

            </select></td>
        <td class="td28">
        <a href="{$URL}m=nav&a=post&id={$v.id}">编辑</a></td>
        <td class="td28"><a href="{$URL}m=nav&a=del&id={$v.id}">删除</a></td>
        <td class="_dgmdate" data-time="{$v.dateline}"></td>
      </tr>
      </tbody>

    {/foreach}
	 <tbody class="tb tb2 ">
      <tr>
       <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
       <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="7"><div class="fixsel">
            <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改"></div></td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
