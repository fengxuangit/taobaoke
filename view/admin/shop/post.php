{include file='../common_admin/left_bar.php'}


  <div class="table_main" style="padding-bottom:100px;">
   <form enctype="multipart/form-data"  method="post" action="" >
    <table class="tb tb2 nobdb">
      <tbody>


          <tr class="noborder" >
            <td  class="td_l">自动抓取:</td>
            <td class="vtop rowform">
            <input name="goods_id" value="{$goods_id}" type="text" class="txt" >
              &nbsp;
              <input type="submit" class="btn submit_btn"  name="get_submit1" value="抓取" >
              </td>
            <td class="vtop tips2" style="color:#f00" >填写卖家店铺中的任何一款的商品链接或ID即可获取当前店铺的信息</td>
          </tr>


 </tbody>
</table>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
<form enctype="multipart/form-data" method="post">
  <table class="tb tb2 nobdb">
      <tbody>

        <tr class="noborder">
          <td class="td_l">促销标题:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="{$shop.title}" type="text" class="txt _keywords"></td>
          <td class="vtop tips2">促销标题,必填</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">卖家昵称:</td>
          <td class="vtop rowform"><input name="postdb[nick]" value="{$shop.nick}" type="text" class="txt"></td>
          <td class="vtop tips2">店家昵称,必填</td>
        </tr>


         <tr class="noborder">
          <td class="td_l">店铺宣传图片:</td>
          <td class="vtop rowform _hover_img">
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$shop.picurl}" type="text" class="txt pic_upload" >
{if $shop.picurl}
<a href=""  class="ajax_del" >删除</a>
{/if}
</div>
<a href="{$shop.picurl}" target="_blank"><img src="{$shop.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>
          <td class="vtop tips2">店铺宣传图片,一般是用在店铺详情页,可空</td>
        </tr>



        <tr class="noborder">
          <td class="td_l">店铺类型:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[shop_type]" value="1" {if $shop.hide==1}checked="checked"{/if}>
              &nbsp;天猫商城</li>
            <li>
              <input class="radio" type="radio" name="postdb[shop_type]" value="2" {if $shop.hide==2}checked="checked"{/if}>
              &nbsp;淘宝C店</li>

              <li>
              <input class="radio" type="radio" name="postdb[shop_type]" value="0" {if $shop.hide==0}checked="checked"{/if}>
              &nbsp;未知</li>
          </ul>

          </td>
          <td class="vtop tips2"></td>
        </tr>



         <tr class="noborder">
          <td class="td_l">店铺分类:</td>
          <td class="vtop rowform">
          <select name="postdb[cate]">
          <option value="0">----请选择店铺分类----</option>

<!--{foreach from=$_G.shop_cate item=vv}-->
 <option value="{$vv.id}" {if $shop.cate == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}" {if $shop.cate == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $shop.cate == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->


          </select>
          </td>
          <td class="vtop tips2">店铺所属分类</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">店铺标签:</td>
          <td class="vtop rowform">
          <select name="postdb[shop_tag]">
         <!-- {foreach from=$_G.setting.shop_tag item = v key = k }-->
          <option value="{$k}" {if $k == $shop.shop_tag} selected="selected"{/if}>{$v}</option>
          <!--{/foreach}-->
          </select>
          </td>
          <td class="vtop tips2">店铺所属分类</td>
        </tr>
          <tr class="noborder">
          <td class="td_l">最低折扣:</td>
          <td class="vtop rowform"><input name="postdb[zk]" value="{$shop.zk}" type="text" class="txt"></td>
          <td class="vtop tips2">折扣期内最低的折扣</td>
        </tr>
      <tr class="noborder">
          <td class="td_l">开始时间:</td>
          <td class="vtop rowform"><input name="postdb[start_time]" value="{$shop.start_time}" type="text" class="txt _dateline"></td>
          <td class="vtop tips2">折扣开始时间</td>
        </tr>
  <tr class="noborder">
          <td class="td_l">结束时间:</td>
          <td class="vtop rowform"><input name="postdb[end_time]" value="{$shop.end_time}" type="text" class="txt _dateline"></td>
          <td class="vtop tips2">折扣结束时间</td>
        </tr>



         <tr class="noborder">
          <td class="td_l">卖家用户id:</td>
          <td class="vtop rowform"><input name="postdb[sid]" value="{$shop.sid}" type="text" class="txt"></td>
          <td class="vtop tips2">卖家用户ID</td>
        </tr>



        <tr class="noborder">
          <td class="td_l">店标地址:</td>
          <td class="vtop rowform _hover_img">
<div class="upload_img" data-name="postdb[pic_path]">
<input name="postdb[pic_path]" value="{$shop.pic_path}" type="text" class="txt pic_upload" >
{if $shop.pic_path}
<a href=""  class="ajax_del" >删除</a>
{/if}
</div>
<a href="{$shop.pic_path}" target="_blank"><img src="{$shop.pic_path}"  /></a>
<input type="file" name="pic_path" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />


          </td>
          <td class="vtop tips2">大小120x60</td>
        </tr>
		 <tr class="noborder">
          <td class="td_l">店铺地址:</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$shop.url}" type="text" class="txt"></td>
          <td class="vtop tips2"></td>
        </tr>


        <tr class="noborder">
          <td class="td_l">店铺排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$shop.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2">越大越靠前</td>
        </tr>




        <tr class="noborder">
          <td class="td_l">隐藏:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[hide]" value="1" {if $shop.hide==1}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[hide]" value="0" {if $shop.hide==0}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>

          </td>
          <td class="vtop tips2">选中的话,前台则不显示</td>
        </tr>

         <tr class="noborder" >
          <td class="td_l">seo keywords:</td>
          <td class="vtop rowform">
          <input name="postdb[keywords]" value="{$shop.keywords}" type="text" class="txt _in_keywords">
          </td>
          <td class="vtop tips2" >seo的关键字,便于搜索引擎收录,多个用,分格开</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">seo description:</td>
          <td class="vtop rowform"><textarea rows="3"  name="postdb[description]"  cols="50" class="tarea _keywords">{$shop.description}</textarea></td>
          <td class="vtop tips2" >seo的描述,便于搜索引擎收录,120字内</td>
        </tr>


        <tr class="noborder">
          <td class="td_l">店铺描述:</td>
          <td class="vtop rowform" colspan="3">
<textarea rows="3" name="postdb[desc]" cols="50" class="textarea _keywords">{$shop.desc}</textarea>
          </td>
          <td class="vtop tips2"></td>
        </tr>


      {if $_shop.t_num_iid}
      <tbody>
         <tr class="noborder">
          <td class="td_l">&nbsp;&nbsp;</td>
          <td class="vtop rowform" colspan="3">
          <a href="#" class="tshop">推荐商品,点击添加</a>
          </td>
          <td class="vtop tips2"></td>
        </tr>
        </tbody>
        {/if}

     <tbody>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <!--{if $_GET.id}-->
              <input type="hidden" name="id" value="{$_GET.id}" />
              <!--{/if}-->
              <input type="submit" class="btn submit_btn" name="onsubmit" value="提交">
            </div></td>
        </tr>

      </tbody>
    </table>
            <input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
  </div>

{include file='../common_admin/right_bar.php'}
