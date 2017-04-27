{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  action="">
  
<div class="table_top">

<div class="table_top_l">共找到({$count})条邀请记录</div>
     <div class="table_top_r">
        <ul>
          

        </ul>
  </div>  



</div>
  <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
       <th class="td25">&nbsp;</th>
       <th class="td25">id</th>       
        <th>推荐者</th>
         <th>访问平台</th>  
         <th>注册者</th>  
         <th>注册时间</th>
         <th>注册平台</th>
          <th>ip</th>
          <th>邀请时间</th>
      </tr>
      </tbody>   
      <!--{foreach from=$goods item=v}-->
       <tbody>
      <tr class="hover">  
        <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
         				 <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
        <td class="td25">{$v.id}</td>        
        <td><a href="{$URL}m=sign&a=yaoqing&t_uid={$v.t_uid}">{$v.t_username}</a></td>
        <td>{$v.platform_text}</td>
        <td>{$v.username}</td>
        <td class="_dgmdate" data-time="{$v.regdate}"></td>
      <td>{$v.reg_platform_text}</td>
        <td>{$v.ip}</td>
        <td  class="_dgmdate" data-time="{$v.dateline}"></td>
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