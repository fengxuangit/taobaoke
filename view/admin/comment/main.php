{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
<div class="table_top">

<div class="table_top_l">共找到({$count})条评论记录</div>
     <div class="table_top_r">
        <ul>
          
<li class="{if !$_GET.type && $_GET.is_reply ==''}on{/if}"><a href="{$URL}m=comment&a=main{if $_GET.uid}&uid={$_GET.uid}{/if}">全&nbsp;&nbsp;部</a></li>
{foreach from=$_G.setting.comment_types item=v key=k}
<li class="{if $_GET.type==$k}on{/if}"> <a href="{$URL}m=comment&a=main&type={$k}{if $_GET.uid}&uid={$_GET.uid}{/if}">{$v}</a></li>
{/foreach}
  <li class="{if $_GET.is_reply ==1}on{/if}"><a href="{$URL}m=comment&a=main&is_reply=1">回复</a></li>
    <li class="{if $_GET.is_reply =='0'}on{/if}"><a href="{$URL}m=comment&a=main&is_reply=0">非回复</a></li>    
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
        <th>类型</th>
        <th>内容</th>
        <th>领取积分</th>  
        <th>ip</th>
        <th>回复数</th>
         <th>顶</th>
        <th>踩</th>
        <th>审核</th>
        <th>删除</th>
        <th>评论时间</th>
      </tr>
      </tbody>   
      <!--{foreach from=$goods item=v}-->
       <tbody>
      <tr class="hover">  
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
         				 <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
        <td class="td25"><a href="{$URL}m=comment&a=main&is_reply=1">{$v.id}</a></td>
        <td><a href="{$URL}m=comment&a=main&uid={$v.uid}{if $_GET.type}&type={$_GET.type}{/if}">{$v.username}</a></td>
        <td><a href="{$URL}m=comment&a=main&type={$v.type}">{$v.type_name}</a></td>
        <td width="700" title="点击查看详情" ><a class="_showDialog"  data-msg="{$v.content}" data-status="success">{$v.c_content}</a></td>
       
        <td>{$v.jf}</td>
        <td><a href="{$URL}m=comment&a=main&ip={$v.ip}" >{$v.ip}</a></td>

        <td>{$v.count}</td>
        <td>{$v.ding}</td>
        <td>{$v.cai}</td>
        <td><a href="{$URL}m=comment&a=check&id={$v.id}" data-check="{$v.check}" class="_check_status {if $v.check==0}red{/if}"></a>
        
        </td>
       
        <td><a href="{$URL}m=comment&a=del&id={$v.id}" class="_confirm" data-msg="您确定要删除当前评论记录吗?删除后不可恢复?" >删除</a></td>
         <td  class="_dgmdate" data-time="{$v.dateline}"></td>
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