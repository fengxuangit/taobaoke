{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_top">
  <div class="table_top_l">共找到({$count})条对兑记录</div>
     <div class="table_top_r">
        <ul>
        	<li>
            <a href="{$URL}m=duihuan&a=apply">全部</a></li>
            
             {foreach from=$_G.setting.duihuan_status item=v1 key=k1} 
             <li> 
            <a href="{$URL}m=duihuan&a=apply&status={$k1}" {if $_GET.status == $k1} class="on"{/if}>{$v1}</a>
            </li>
             {/foreach}

        </ul>
  </div>  
  </div>
    <div class="table_main">
  <table class="tb tb2 ">
    <tbody>      
      <tr class="hover">
        <th class="td25">删除</th>
        <th>id</th>
	    <th>兑换商品</th>
        <th>用户名</th>
 <th>旺旺</th>
 <th>真实姓名</th>
 <th>ip</th>
  <th>状态</th>
 
        <th>编辑状态</th>
        <th>最后操作时间</th>
        
        <th>申请时间</th>
       
      </tr>
    <!--{foreach from=$goods item=v}-->
      <tr class="hover">
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
          <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" />
           <input type="hidden" name="duihuan_id[{$v.id}]" value="{$v.goods.id}" />
          </td>
        <td><a href="/index.php?m=duihuan&id={$v.id}" target="_blank" title="前台查看">{$v.id}</a></td>
        <td  style="width:400px;overflow:hidden;"><a href="{$URL}m=duihuan&a=apply&id={$v.duihuan_id}" title="{$v.goods.title}"  >{$v.goods.title}</a></td>
        <td><a href="{$URL}m=duihuan&a=apply&uid={$v.uid}">{$v.username}</a></td>
        <td><a href="#" target="_blank" class="_wangwang" data-nick="{$v.wangwang}"></a></td>
        <td>{$v.truename}</td>
        <td>{$v.ip}</td>
         <td  class="red">{$v.status_text}</td>

        <td >
			<a href="{$URL}m=duihuan&a=apply_edit&id={$v.id}" class="red">编辑状态</a>
            <input type="hidden" name="status[{$v.id}]"  value="{$v.status}"/>
             <input type="hidden" name="org_status[{$v.id}]"  value="{$v.status}"/>
        </td>
         <td  class="_dgmdate" data-time="{$v.statustime}"></td>
         <td  class="_dgmdate" data-time="{$v.dateline}"></td>
      </tr>
    <!--{/foreach}-->
      
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
          <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="10"><div class="fixsel">
        
        
        <select name="in_status"  class="select">
        <option value="">----批量修改状态----</option>
            {foreach from=$_G.setting.duihuan_status item=v1 key=k1}
            <option value="{$k1}" > {$v1} </option>
            {/foreach}
            </select>
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