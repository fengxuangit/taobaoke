{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
<div class="table_top">

<div class="table_top_l">共找到({$count})条积分记录</div>
     <div class="table_top_r">
        <ul>
          
<li class="{if !$_GET.type}select{/if}"><a href="{$URL}m=sign&a=main&type=jf_list{if $_GET.uid}&uid={$_GET.uid}{/if}">全&nbsp;&nbsp;部</a></li>
{foreach from=$_G.setting.jf_type item=v key=k}
<li class="{if $_GET.type==$k}on{/if}"> <a href="{$URL}m=sign&a=main&type={$k}{if $_GET.uid}&uid={$_GET.uid}{/if}">{$v}</a></li>
{/foreach}
           

        </ul>
  </div>  



</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">id</th>       
        <th>用户名</th>
        <th>领取积分</th>  
        <th>ip</th>
         <th>积分描述</th>
          <th>上次积分</th>
        <th>创建时间</th>
       
        
        <th>删除</th>        
      </tr>
      </tbody>   
      <!--{foreach from=$sign_list item=v}-->
       <tbody>
      <tr class="hover">  
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
         				 <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
        <td class="td25">{$v.id}</td>        
        <td><a href="{$URL}m=sign&a=main&uid={$v.uid}">{$v.username}</a></td>
        <td>{$v.jf}</td>
        <td>{$v.ip}</td>
         <td>{$v.desc}</td>
          <td>{$v.org_jf}</td>
        <td  class="_dgmdate" data-time="{$v.dateline}"></td>
        <td><a href="{$URL}m=sign&a=del&id={$v.id}" >删除</a></td>
        <td>
      </tr>
      </tbody>     
       <!--{/foreach}-->
       <tbody>
      <tr>
        <td class="td25">
        <input type="checkbox" class="_del_all" />反选</td>
        <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="9">
        <div class="y">{$showpage}</div>
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