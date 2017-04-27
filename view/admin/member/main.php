{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">

<div class="table_top">
    <div class="table_top_l">共找到({$count})条会员信息</div>
    <div class="table_top_r">
      <ul>
        <li ><a href="{$URL}m=member&a=main">全部</a></li>

{foreach from=$_G.group item=v}
 <li {if $_GET.groupid==$v.id} class="on"{/if}><a href="{$URL}m=member&a=main&groupid={$v.id}">{$v.name}</a></li>
{/foreach}

<li {if $_GET.check == '1'} class="on"{/if}><a href="{$URL}m=member&a=main&check=1">待审核</a></li>
<li {if $_GET.check == '0'} class="on"{/if}><a href="{$URL}m=member&a=main&check=0">未审核</a></li>

<li {if $_GET.seller == '1'} class="on"{/if}><a href="{$URL}m=member&a=main&seller=1">商家</a></li>
<li {if $_GET.seller == '0'} class="on"{/if}><a href="{$URL}m=member&a=main&seller=0">普通用户</a></li>

<li {if $_GET.order == 'login_count'} class="on"{/if}>
<a href="{$URL}m=member&a=main&{if $_GET.groupid!=''}groupid={$v.id}{/if}&order=login_count&sort={if $_GET.sort=='desc'}asc{else}desc{/if}">登录次数</a>
</li>

<li {if $_GET.order == 'regdate'} class="on"{/if}>
<a href="{$URL}m=member&a=main&{if $_GET.groupid!=''}groupid={$v.id}{/if}&order=regdate&sort={if $_GET.sort=='desc'}asc{else}desc{/if}">注册时间</a>
</li>

<li {if $_GET.order == 'login_time'} class="on"{/if}>
<a href="{$URL}m=member&a=main&{if $_GET.groupid!=''}groupid={$v.id}{/if}&order=login_time&sort={if $_GET.sort=='desc'}asc{else}desc{/if}">登录时间</a>
</li>
<li {if $_GET.order == 'jf'} class="on"{/if}>

<a href="{$URL}m=member&a=main&{if $_GET.groupid!=''}groupid={$v.id}{/if}&order=jf&sort={if $_GET.sort=='desc'}asc{else}desc{/if}">积分</a>
</li>

      </ul>
    </div>
  </div>



  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">删除</th>
       <th class="td25">uid</th>       
        <th>用户名</th>

        <th>积分</th> 
     <th>签到次数</th>  
        <th>旺旺</th>  
        <th>qq</th>  
        <th>电话</th>  
        <th>登录ip</th>  
        <th>登录时间</th>
        <th>注册ip</th>  
        <th>注册时间</th>
     <th>登录次数</th>
        <th>编辑</th> 

        <th>删除</th>    
 
      </tr>
      </tbody>   
      <!--{foreach from=$goods item=v}-->
       <tbody>
      <tr class="hover">  
        <td class="td25"><input type="checkbox" name="del[{$v.uid}]" value="1" class="_del" />
         				 <input type="hidden" name="ids[{$v.uid}]" value="{$v.uid}" />
                         <input type="hidden" name="username[{$v.uid}]" value="{$v.username}" />
                         </td>
        <td class="td25">{$v.uid}</td>        
        <td title="{$v.email}">{$v.username}</td>
        <td>{$v.jf}</td>
         <td><a href="{$URL}m=sign&a=main&uid={$v.uid}&type=sign" title="点击查看">{$v.sign} 次</a></td>
        <td>
        {if $v.wangwang} 
      	 <a href="#" class="_wangwang" data-nick="{$v.wangwang}"></a>        {/if}&nbsp;
        </td>
        <td>{if $v.qq}<a class="qq" data-qq="{$v.qq}">{$v.qq}</a>{/if} &nbsp;</td>
        <td>{$v.phone}</td>         
         <td>{$v.login_ip}</td>     
        <td  class="_dgmdate" data-time="{$v.login_time}"></td>
        
        <td>{$v.regip}</td>     
        <td  class="_dgmdate" data-time="{$v.regdate}"></td>
       <td>{$v.login_count}</td>
        
        <td><a href="{$URL}m=member&a=post&uid={$v.uid}" >编辑</a></td>
        
        <td><a href="{$URL}m=member&a=del&uid={$v.uid}" >删除</a></td>
       
        <td>
      </tr>
      </tbody>     
       <!--{/foreach}-->
       <tbody>
      <tr>
        <td class="td25">
        <input type="checkbox" class="_del_all" />反选</td>
        <td><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="12">
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