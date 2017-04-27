{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
    <div class="table_top">app模板设置,可直接控制APP展示页面的模板,后续将不断的开发增加新的模板.</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>




         <tr class="noborder">
          <td class="td_l">商品列表模板:</td>
          <td class="vtop rowform">
                <select name="postdb[app_goods_tpl]" class="select" multiple="multiple" >
                {foreach from=$_G.setting.app_tpl.goods item=v}
                  <option value="{$v.tpl_name}" data-pic="{$v.pic}"  {if $_G.setting.app_goods_tpl == $v.tpl_name} selected="selected" {/if} >{$v.name}</option>
                {/foreach}
                </select>
          </td>
           <td class="vtop tips2">商品列表模板</td>
        </tr>

		 <tr class="noborder">
          <td class="td_l">商品栏目分类模板:</td>
          <td class="vtop rowform">
                <select name="postdb[app_channel_tpl]" class="select" multiple="multiple" >
                {foreach from=$_G.setting.app_tpl.channel item=v}
                  <option value="{$v.tpl_name}" data-pic="{$v.pic}" {if $_G.setting.app_channel_tpl == $v.tpl_name} selected="selected" {/if} >{$v.name}</option>
                {/foreach}
                </select>
          </td>
          <td class="vtop tips2">商品栏目模板</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">值得买列表模板:</td>
          <td class="vtop rowform">
               <select name="postdb[app_img_tpl]" class="select" multiple="multiple" >
                {foreach from=$_G.setting.app_tpl.img item=v}
                  <option value="{$v.tpl_name}" data-pic="{$v.pic}"  {if $_G.setting.app_img_tpl == $v.tpl_name} selected="selected" {/if} >{$v.name}</option>
                {/foreach}
                </select>
          </td>
          <td class="vtop tips2">值得买列表模板</td>
        </tr>


        <tr class="noborder">
          <td class="td_l">搭配列表模板:</td>
          <td class="vtop rowform">
              <select name="postdb[app_style_tpl]" class="select" multiple="multiple" >
                {foreach from=$_G.setting.app_tpl.style item=v}
                  <option value="{$v.tpl_name}" data-pic="{$v.pic}"  {if $_G.setting.app_style_tpl == $v.tpl_name} selected="selected" {/if} >{$v.name}</option>
                {/foreach}
                </select>
          </td>
          <td class="vtop tips2">搭配列表模板</td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<div class="app_pic hide" style="border:5px solid #03a9f4"><img src="" width="420"  ></div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'}
