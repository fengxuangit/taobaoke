{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="POST"  action="">

  <div class="table_top">
 <div class="table_top_l">共找到({$count})条留言信息</div>
     <div class="table_top_r">
        <ul>


<li><a href="{$URL}m=message&a=main"><span>全部</span></a></li>

<li {if  $_GET.check ==1}class="on"{/if}><a href="{$URL}m=message&a={$CA}&check=1"><span>已审核</span></a></li>
<li {if  $_GET.check =='0'}class="on"{/if}><a href="{$URL}m=message&a={$CA}&check=0"><span>待审核</span></a></li>
<li {if  $_GET.check ==2}class="on"{/if}><a href="{$URL}m=message&a={$CA}&check=2"><span>拒绝审核</span></a></li>

        </ul>
  </div>

</div>

    <div class="table_main">
  <table class="tb tb2 ">
    <tbody>
      <tr class="hover">
        <th class="td25">删除</th>
        <th>id</th>

        <th >姓名</th>
        <th >联系方式</th>
        {if $CA=='main'}
        <th>公司名称</th>
        <th>公司网址</th>
        {/if}

         <th>详细内容</th>

        <th>是否已审核</th>

        <th>删除</th>
         <th>发布时间</th>
      </tr>
      <!--{foreach from=$goods item=v}-->
            <tr class="hover">
                    <td class="td25"><input type="checkbox" name="del[{$v.id}]" value="1" class="_del" />
                    <input type="hidden" name="ids[{$v.id}]" value="{$v.id}" /></td>
                    <td>{$v.id}</td>
                    <td>{$v.name}</td>

                    <td>{$v.contact} </td>

                     {if $CA=='main'}
                    <td>{$v.company_name} </td>
                    <td> {if $v.url} <a href="{$v.url}" target="_blank">点击查看</a>{else}无{/if} </td>
                    {/if}
                    <td class="_showDialog" data-msg="{$v.message}">{$v.content}</td>
                    <td>
                    <a href="{$URL}m=message&a=check&id={$v.id}" data-check="{$v.check}" data-default="0|1|2" class="_check_status {if $v.check==0}red{/if}"></a>
                    </td>
                    <td><a href="{$URL}m=message&a=del&id={$v.id}&page={$_G.page}"   class="_confirm" data-msg="您确定要删除当前信息吗?删除后不可恢复?"  >删除</a></td>
                    <td  class="_dgmdate" data-time="{$v.dateline}"></td>
            </tr>
      <!--{/foreach}-->
      <tr>
        <td class="td25"><input type="checkbox" class="_del_all" />
          反选</td>
          <td class="td25"><input type="checkbox"  name="_del_all" value="1"/>删除</td>
        <td colspan="9">
        <div class="y">{$showpage}</div>
        <div class="fixsel">
        <select name="checkin">
        	<option value="-1">批量审核</option>

           <option value="1">审核通过</option>
           <option value="2">审核拒绝</option>
           <option value="0">待审核</option>
          </select>
          &nbsp;&nbsp;
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
