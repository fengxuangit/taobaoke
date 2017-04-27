{include file='../common_admin/left_bar.php'}

<!--{if $_GET.aid && $CURMODULE == 'goods'}-->
<div class="table_top">
<a href="/index.php?{if $_G.setting.link_type ==1}itemid={$goods.num_iid}{else}aid={$_GET.aid}{/if}" target="_blank">前台查看</a>&nbsp;&nbsp;
<a href="{$URL}m=channel&a=main&fid={$goods.fid}">查看本栏目商品</a>&nbsp;&nbsp;
<a href="{$URL}m=channel&a=post&fid={$goods.fid}">编辑栏目信息</a>&nbsp;&nbsp;

</div>
<!--{/if}-->

  <div class="table_main">
<form enctype="multipart/form-data"  method="post" action="" >
  <table class="tb tb2 nobdb">

       <tbody>
          <tr class="noborder" >
            <td  class="td_l">自动抓取:</td>
            <td class="vtop rowform">
            <input name="goods_id" value="{$_GET.goods_id}"  type="text" class="txt web_num_iid" >
              &nbsp;
              {if $_GET.aid}
              <input type="hidden" name="goods_aid"  class="goods_aid"  value="{$_GET.aid}" />
              {/if}
              <input type="submit" class="btn web_btn"  name="get_submit" value="抓取" >
              </td>
            <td class="vtop tips2" >填写商品ID或是商品链接,可自动获取商品信息</td>
          </tr>
          </tbody>
          </table>
      <input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>

      <form enctype="multipart/form-data"  method="post" action="" >
        <table class="tb tb2 nobdb">
     <tbody>

      <tr class="noborder" >
        <td  class="td_l">商品标题:</td>
        <td class="vtop rowform"><input name="postdb[title]" value="{$goods.title}" type="text" class="txt _keywords"></td>
        <td class="vtop tips2" >必填</td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">所属栏目:</td>
        <td class="vtop rowform">

<select name="postdb[fid]" class="select_fid">
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $goods.fid==$vv.fid || $vv.fid==$_GET.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $goods.fid==$vvv.fid || $vvv.fid==$_GET.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $goods.fid==$a.fid || $a.fid==$_GET.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>

          </td>
        <td class="vtop tips2" >本栏目的上级栏目或分类</td>
      </tr>

		<tr class="noborder" >
        <td class="td_l">商品分类:</td>
        <td class="vtop rowform">

<select name="postdb[cate]" class="select_fid">
 <option value="0">----请选择分类----</option>
<!--{foreach from=$_G.goods_cate item=vv}-->
 <option value="{$vv.id}" {if $goods.cate == $vv.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
<option value="{$vvv.id}" {if $goods.cate == $vvv.id} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" {if $goods.cate == $a.id} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->
      <!--{/foreach}-->
<!--{/if}-->
<!--{/foreach}-->
</select>


          </td>
        <td class="vtop tips2" >给商品添加分类,可在不同区域按需调用</td>
      </tr>

 	<tr class="noborder" >
        <td class="td_l">商品标记:</td>
        <td class="vtop rowform"><select name="postdb[flag]">
            <!--{foreach from=$_G.setting.flag item=vv key=k}-->
            <option value="{$k}" {if $goods.flag==$k} selected="selected"{/if} >{$vv}</option>
            <!--{/foreach}-->
          </select></td>
       <td class="vtop tips2" >商品标记,可在全局设置里添加修改,方便调用特定数据</td>
      </tr>
{if $_G.brand}
   <tr class="noborder" >
        <td class="td_l">所属品牌:</td>
        <td class="vtop rowform">

        <select name="postdb[brand_id]" class="z brand_select">
         <option value="0">----请选择品牌----</option>
            <!--{foreach from=$_G.brand item=vv key=k}-->
            <option value="{$vv.id}" {if $goods.brand_id==$vv.id} selected="selected"{/if} >{$vv.name}</option>
            <!--{/foreach}-->
          </select>
              <div class="z">  搜索 <input   value="" type="text" class="txt w90 brand_kw" ></div>

              <div class="cl hide brand_list">{$band_list}</div>
          </td>
       <td class="vtop tips2" >所属品牌</td>
      </tr>
{/if}
      <tr class="td_l noborder" >
        <td >店铺类型:</td>
        <td class="vtop rowform"><ul>
            <li >
              <input class="radio" type="radio" name="postdb[shop_type]" value="1" {if $goods.shop_type==1}checked="checked"{/if}>
              &nbsp;商城</li>
            <li>
              <input class="radio" type="radio" name="postdb[shop_type]" value="2" {if $goods.shop_type==2}checked="checked"{/if}>
              &nbsp;集市</li>
              <li>
              <input class="radio" type="radio" name="postdb[shop_type]" value="0" {if $goods.shop_type==0}checked="checked"{/if}>
              &nbsp;未知</li>
          </ul></td>
        <td class="vtop tips2" >卖家店铺类型</td>
      </tr>

  <tr class="td_l noborder" >
        <td >显示状态:</td>
        <td class="vtop rowform">


<select name="postdb[status]" class="select">
{foreach from=$_G.setting.goods_status item=v key=k}
 <option value="{$k}" {if $goods.status == "{$k}"} selected {/if}>{$v}</option>
 {/foreach}
 </select>

</td>
        <td class="vtop tips2" >
只有正常上架的商品才会在前台和APP展示
        </td>
      </tr>

 <tr class="td_l noborder" >
        <td >佣金类型:</td>
        <td class="vtop rowform"><ul>


           <li><input class="radio" type="radio" name="postdb[bili_type]" value="0" {if $goods.bili_type==0}checked="checked"{/if}>
              &nbsp;普通</li>
            <li >
              <input class="radio" type="radio" name="postdb[bili_type]" value="1" {if $goods.bili_type==1}checked="checked"{/if}>
              &nbsp;鹊桥</li>
            <li>
              <input class="radio" type="radio" name="postdb[bili_type]" value="2" {if $goods.bili_type==2}checked="checked"{/if}>
              &nbsp;定向</li>
              <li>
             
          </ul></td>
        <td class="vtop tips2" >当前商品的佣金类型</td>
      </tr>

       <tr class="noborder" >
        <td class="td_l">优惠卷地址</td>
        <td class="vtop rowform"><input type="txt" name="postdb[juan_url]" value="{$goods.juan_url}"  class="txt"/></td>
        <td class="vtop tips2" >如果有优惠券的话可以填写领取的地址</td>
      </tr>

 <tr class="noborder" >
        <td class="td_l">优惠卷金额</td>
        <td class="vtop rowform"><input type="txt" name="postdb[juan_price]" value="{$goods.juan_price}"  class="txt"/></td>
        <td class="vtop tips2" >优惠卷金额</td>
      </tr>


    <tr class="noborder" >
        <td class="td_l">券总数:</td>
        <td class="vtop rowform"><input  name="postdb[quan_sum]" value="{$goods.quan_sum}" type="text" class="txt w90" ></td>
        <td class="vtop tips2" >已经领取的优惠券数量</td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">剩余券数:</td>
        <td class="vtop rowform"><input  name="postdb[quan_num]" value="{$goods.quan_num}" type="text" class="txt w90" ></td>
        <td class="vtop tips2" >剩余的优惠券数量</td>
      </tr>

      <tr class="noborder" >
        <td class="td_l">淘口令:</td>
        <td class="vtop rowform"><input  name="postdb[tkl]" value="{$goods.tkl}" type="text" class="txt tkl_input" >
            {if !$goods.tkl}<a href="#" class="create_tkl red">生成淘口令</a>{/if}
        </td>
        <td class="vtop tips2" >如果有豆号分格两组的话,则第一组是商品的淘口令,第二组为优惠券的淘口令.没有豆号分格则只是商品的淘口令</td>
      </tr>


<tr class="noborder" >
          <td class="td_l">seo keywords:</td>
          <td class="vtop rowform">
          <input name="postdb[keywords]" value="{$goods.keywords}" type="text" class="txt _in_keywords">
          </td>
          <td class="vtop tips2" >seo的关键字,便于搜索引擎收录,多个用,分格开</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">seo description:</td>
          <td class="vtop rowform"><textarea rows="3"  name="postdb[description]"  cols="50" class="tarea">{$goods.description}</textarea></td>
          <td class="vtop tips2" >seo的描述,便于搜索引擎收录,120字内</td>
        </tr>
      <tr class="noborder" >
        <td class="td_l">排序:</td>
        <td class="vtop rowform"><input  name="postdb[sort]" value="{$goods.sort}" type="text" class="txt w90" ></td>
        <td class="vtop tips2" >在列表页显示时,值越大越靠前,留空则默认发布时间降序</td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">浏览次数:</td>
        <td class="vtop rowform"><input  name="postdb[views]" value="{$goods.views}" type="text" class="txt w90" ></td>
        <td class="vtop tips2" >当前商品的浏览次数</td>
      </tr>

     <tr class="noborder" >
        <td class="td_l">赞/喜欢:</td>
        <td class="vtop rowform"><input  name="postdb[like]" value="{$goods.like}" type="text" class="txt" ></td>
        <td class="vtop tips2" ></td>
      </tr>
      <tr class="noborder hide" >
        <td  class="td_l">商品ID:</td>
        <td class="vtop rowform"><input name="postdb[num_iid]" value="{$goods.num_iid}" type="text" class="txt"></td>
        <td class="vtop tips2" >采集的请不要更改</td>
      </tr>
 <tr class="noborder" >
        <td class="td_l">销量:</td>
        <td class="vtop rowform"><input  name="postdb[sum]" value="{$goods.sum}" type="text" class="txt" ></td>
        <td class="vtop tips2" >商品销量</td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">商品主图:</td>
        <td class="vtop rowform _hover_img">

<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$goods.picurl}" type="text" class="txt pic_upload change_pic_main" >
{if $goods.picurl}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;

{/if}
</div>
<a href="{$goods.picurl}" target="_blank" ><img src="{$goods.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />

        </td>
        <td class="vtop tips2" >前台显示时,都将会显示这个为缩略图</td>
      </tr>

      <tr class="noborder" >
        <td class="td_l">商品副图:</td>
        <td class="vtop rowform goods_img2">
        {if $goods.images}
        {foreach from=$goods.images item=v1 key =k}
       <p class="_hover_img">
        <input  name="images[]" value="{$v1}" type="text" class="txt change_pic_value" >
        <a href="#" title="{$v1}" data-index="{$k}" class="change_pic red">选为主图</a>
        <a href="{$v1}" target="_blank" ><img src="{$v1}"  /></a>
       </p>
        {/foreach}
        {else}
        <input  name="images[]" value="" type="text" class="txt" >
        {/if}
          </td>
        <td class="vtop tips2" >一般可不用理会</td>
      </tr>

      <tr class="noborder" >
        <td class="td_l">卖家昵称:</td>
        <td class="vtop rowform"><input  name="postdb[nick]" value="{$goods.nick}" type="text" class="txt" >
        {if $goods.nick}&nbsp;&nbsp;<a href="#"  class="_wangwang" data-nick="{$goods.nick}"></a>{/if}
        </td>
        <td class="vtop tips2" >卖家的旺旺{if $goods.nick},可以点击联系卖家{/if}</td>
      </tr>
<tr class="noborder" >
        <td class="td_l">卖家用户id:</td>
        <td class="vtop rowform"><input  name="postdb[sid]" value="{$goods.sid}" type="text" class="txt" >

        </td>
        <td class="vtop tips2" >卖家的用户id</td>
      </tr>


      <tr class="noborder" >
        <td class="td_l">商品链接地址:</td>
        <td class="vtop rowform"><input  name="postdb[url]" value="{if $goods.org_url}{$goods.org_url}{else}{$goods.url}{/if}" type="text" class="txt" ></td>
        <td class="vtop tips2" ></td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">商品原价:</td>
        <td class="vtop rowform"><input  name="postdb[price]" value="{$goods.price}" type="text" class="txt" ></td>
        <td class="vtop tips2" >最多一位小数</td>
      </tr>

      <tr class="noborder" >
        <td class="td_l">上线时间段:</td>
        <td class="vtop rowform"><input  name="postdb[start_time]" value="{$goods.start_time}" type="text" class="txt _dateline" ></td>
        <td class="vtop tips2" >未到时间,此商品不会在首页及列表页中显示,0或空则不限时间</td>
      </tr>
      <tr class="noborder" >
        <td class="td_l">下线时间段:</td>
        <td class="vtop rowform"><input  name="postdb[end_time]" value="{$goods.end_time}" type="text" class="txt _dateline" ></td>
        <td class="vtop tips2" >已到时间,则不会显示,0或空则不限时间</td>
      </tr>

      <tr class="noborder" >
        <td class="td_l">商品现价:</td>
        <td class="vtop rowform"><input  name="postdb[yh_price]" value="{$goods.yh_price}" type="text" class="txt " > 元</td>
        <td class="vtop tips2" >优惠价,最多一位小数</td>
      </tr>
      <tr class="noborder" >
          <td  class="td_l">佣金比例:</td>
          <td class="vtop rowform">
          <input name="postdb[bili]" value="{$goods.bili}" type="text"  class="txt w90"> %{if $goods.yongjin}&nbsp;&nbsp;= &nbsp;{$goods.yongjin} 元{/if}</td>
          <td class="vtop tips2" >佣金比例,如果自动查询的是为-1,则说明当前商品不是淘宝客商品,无佣金的</td>
	</tr>

    <tr class="noborder" >
            <td class="td_l">推荐理由:</td>
            <td class="vtop rowform">
            <textarea rows="6" name="postdb[ly]" cols="70" class="textarea _keywords">{$goods.ly}</textarea>
            </td>
            <td class="vtop tips2">商品推荐理由,250字以内,可空</td>
    </tr>



    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>


{if $_G.setting.get_message==1}
      <tr class="noborder" >
        <td class="td_l">商品详细描述:</td>
        <td class="vtop rowform" colspan="3">
<div class="kg_editorContainer"  data-config='{
"width":"900","height":"400"
        }'>
        <textarea rows="6" name="postdb[message]" cols="70" class="ks-editor-textarea" id = "web_editor">{$goods.message}</textarea></div>
        </td>
        <td>&nbsp;</td>
      </tr>
{/if}
      <tr>
      <td>&nbsp;</td>
        <td colspan="5"><div class="fixsel">
            <input type="submit" class="btn submit_btn"   name="onsubmit" title="按 Enter 键可随时提交您的修改" value="提交" >
          </div></td>
      </tr>
{if $goods.aid}
<input type="hidden" name="aid" value="{$goods.aid}" />
{/if}
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />

    </tbody>

  </table>
      </form>
  </div>
{include file='../common_admin/right_bar.php'}
