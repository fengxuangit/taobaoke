{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  <div class="table_top"><a href="{$URL}m=member&a=group_post" class="red">添加用户组</a>
  
<!-- <span>1-10 系统用户组	10-20站内用户组	20++ 其它登录用户组</span>-->
  </div>
  <div class="table_main">
    <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <th>id</th>
          <th>名称</th>
          <th>是否可登录后台</th>
          <th>编辑权限</th>
          <th>积分范围</th>
         {if $_G.setting.fanli ==1} <th>返利比例</th>{/if}
          <th>删除</th>
          <th>添加时间</th>
        </tr>
        <!--{foreach from=$_G.group item=v name=f}-->
        <tr class="hover ">
          <td>{$v.id}
            <input type="hidden" name="ids[{$v.id}]" value="{$v.id}"  class="ids"/></td>
          <td>{$v.name} </td>
          <td> {if $v.login_admin==1 || $v.id==1} <span class="red">是</span> {else} 否
            {/if} </td>
          <td>
          {if $v.id ==1}
          <a href="javascript:;" class="red">无法修改</a>
          {else}
          <a href="{$URL}m=member&a=group_post&id={$v.id}">编辑权限</a>
          {/if}
          
          </td>
          <td>{$v.jf_min} - {$v.jf_max}</td>

          {if $_G.setting.fanli ==1}  <td>{$v.fanli}</td>{/if}
          <td>{if $v.system==1} <a href="#" class="_showDialog red" data-msg="当前用户组为系统保留用户组,无法删除">无法删除</a> 
          {else}<a href="{$URL}m=member&a=group_del&id={$v.id}" >删除</a>{/if}</td>
         
         {if $v.system ==1}
         <td>-</td>
         {else}
          <td class="_dgmdate"  data-time="{$v.dateline}"></td>
          {/if}
        </tr>
        <!--{/foreach}-->
        
      </tbody>
    </table>
  </div>
  <input type="hidden" name="m" value="{$CURMODULE}" />
  <input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} <strong></strong>