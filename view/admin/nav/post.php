{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  >

<!--{if $_GET.id}-->
<div class="table_top">
<a href="/index.php?m=nav&id={$_GET.id}" target="_blank">前台查看</a>&nbsp;&nbsp;
 <a href="{$URL}m=goods&a=post&id={$_GET.id}">发布商品</a>
 </div>
<!--{/if}-->
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder" >
          <td class="td_l">导航名称:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$nav.name}" type="text" class="txt"></td>
          <td class="vtop tips2" >必填</td>
        </tr>

        <tr class="noborder" >
          <td class="td_l">导航链接</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$nav.url}" type="text" class="txt"></td>
          <td class="vtop tips2" >站内地址以/index.php开头或是以?开头(如:/index.php?m=img&a=list ,?m=img&a=list)</td>
        </tr>

        <tr class="noborder" >
          <td class="td_l">当前导航class:</td>
          <td class="vtop rowform"><input name="postdb[classname]" value="{$nav.classname}" type="text" class="txt w90"></td>
          <td class="vtop tips2" >一般不用填写</td>
        </tr>


        <tr class="noborder" >
          <td class="td_l">导航排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$nav.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2" >越大越靠前</td>
        </tr>


        <tr class="noborder" >
          <td class="td_l">打开方式:</td>
          <td class="vtop rowform"><ul>
              <li >
                <input class="radio" type="radio" name="postdb[target]" value="0" {if $nav.target==0} checked="checked"{/if} >
                &nbsp;当前页面</li>
              <li>
                <input class="radio" type="radio" name="postdb[target]" value="1" {if $nav.target==1} checked="checked"{/if}>
                &nbsp;新窗口</li>
            </ul></td>
          <td class="vtop tips2" >点击导航后打开的方式</td>
        </tr>


        <tr class="noborder" >
          <td class="td_l">导航类型:</td>
          <td class="vtop rowform"><ul>



          <select name="postdb[type]" class="select" >
           {foreach from=$_G.setting.nav item=v key=k}
              <option value="{$k}" {if $nav.type == $k} selected {/if}>{$v}</option>
             {/foreach}

            </select>


            </ul></td>
          <td class="vtop tips2" >设置导航在哪个位置显示</td>
        </tr>



        <tr class="noborder" >
        <td class="td_l">&nbsp;</td>
          <td colspan="2"><div class="fixsel">
          {if $_GET.id}
                <input type="hidden" name="id" value="{$_GET.id}" />
           {/if}
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改"></div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
