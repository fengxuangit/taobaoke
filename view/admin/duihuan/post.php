{include file='../common_admin/left_bar.php'}

  
  <div class="table_main">  
  
   
   
 <form enctype="multipart/form-data"  method="post" action="" >
 <table class="tb tb2 nobdb">   
       <tbody>
      
          <tr class="noborder" >
            <td  class="td_l">自动抓取:</td>
            <td class="vtop rowform">
            <input name="goods_id" value="{$goods_id}" type="text" class="txt" >
              &nbsp;

              <input type="submit" class="btn submit_btn"  name="get_submit" value="抓取" >
              </td>
            <td class="vtop tips2" >如果是淘宝商品,则可填写商品ID或是商品链接,可自动获取商品信息</td>
          </tr>

 </tbody>

</table>
   <input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
   <form enctype="multipart/form-data" method="post">    
    <table class="tb tb2 nobdb">   
   
      <tbody> 
        <tr class="noborder" >
          <td class="td_l">标题:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="{$goods.title}" type="text" class="txt"></td>
          <td class="vtop tips2" >必填</td>
        </tr>
        
     <tr class="noborder" >
          <td class="td_l">商品id:</td>
          <td class="vtop rowform"><input name="postdb[num_iid]" value="{$goods.num_iid}" type="text" class="txt">
        {if $goods.num_iid} <a style="margin-left:10px;" class="red" href="https://item.taobao.com/item.htm?id={$goods.num_iid}" target="_blank">点击查看商品</a>{/if}
          </td>
          <td class="vtop tips2" >可填卖家店铺中商品的ID或链接地址</td>
        </tr>
       <tr class="noborder">
          <td class="td_l">标签/分类:</td>
          <td class="vtop rowform">           
          <select name="postdb[cate]">
            <!--{foreach from=$_G.duihuan_cate item=vv key=k}-->
            <option value="{$k}" {if $goods.cate==$k} selected="selected"{/if} >{$vv.name}</option>
            <!--{/foreach}-->
          </select>
            </td>
          <td class="vtop tips2">可空</td>
        </tr>

        


        <tr class="noborder" >
          <td class="td_l">商品主图:</td>
          <td class="vtop rowform _hover_img">
          
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$goods.picurl}" type="text" class="txt pic_upload" >
{if $goods.picurl}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div>
<a href="{$goods.picurl}" target="_blank"><img src="{$goods.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          </td>
          <td class="vtop tips2" >商品图片</td>
        </tr>
 
       
         <tr class="noborder" >
          <td class="td_l">商品原价:</td>
          <td class="vtop rowform"><input name="postdb[price]" value="{$goods.price}" type="text" class="txt"></td>
          <td class="vtop tips2" >商品原价,整数</td>
        </tr>
          

        <tr class="noborder" >
          <td class="td_l">开始时间:</td>
          <td class="vtop rowform"><input name="postdb[start_time]" value="{if $goods.start_time>0}{$goods.start_time}{/if}" type="text" class="txt _dateline"></td>
          <td class="vtop tips2" >未开始则不能兑换,留空则不限时间</td>
        </tr>

        
      <tr class="noborder" >
          <td class="td_l">结束时间:</td>
          <td class="vtop rowform"><input name="postdb[end_time]" value="{if $goods.end_time>0}{$goods.end_time}{/if}" type="text" class="txt _dateline"></td>
          <td class="vtop tips2" >已结束则不能兑换,留空则不限时间</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">兑换总份数:</td>
          <td class="vtop rowform"><input name="postdb[sum]" value="{$goods.sum}" type="text" class="txt"></td>
          <td class="vtop tips2" >提供兑换商品的份数</td>
        </tr>
         <tr class="noborder" >
          <td class="td_l">已申请份数:</td>
          <td class="vtop rowform"><!--<input name="postdb[num]" value="{$goods.num}" type="text" class="txt">-->
          {$goods.num}
          
          
          </td>
          <td class="vtop tips2" >一般无需更改(除非你要做假),在确认审核通过后,此数量会自动增加</td>
        </tr>
  <tr class="noborder" >
          <td class="td_l">兑换所需积分:</td>
          <td class="vtop rowform"><input name="postdb[jf]" value="{$goods.jf}" type="text" class="txt"></td>
          <td class="vtop tips2" >需要扣除多少积分才能申请兑换,留空或0则不需扣积分</td>
        </tr>


         
        <tr class="noborder" >
          <td class="td_l">下架:</td>
          <td class="vtop rowform"><ul>
              <li >
                <input class="radio" type="radio" name="postdb[hide]" value="1" {if $goods.hide==1} checked="checked"{/if} >
                &nbsp;是</li>
              <li>
                <input class="radio" type="radio" name="postdb[hide]" value="0" {if $goods.hide==0} checked="checked"{/if}>
                &nbsp;否</li>
            </ul></td>
          <td class="vtop tips2" >在前台调用时不显示,且无法兑换此商品</td>
        </tr>
       <tr class="noborder" >
          <td class="td_l">排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$goods.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2" >越大越靠前</td>
        </tr>
       

      <tr class="noborder" >
        <td class="td_l">兑换详细描述:</td>
        <td class="vtop rowform" colspan="3" >
<div class="kg_editorContainer"  data-config='{
          "width":"1100","height":"500"
        }'>
 			<textarea rows="6" name="postdb[content]" cols="70" class="ks-editor-textarea" id = "web_editor" >{$goods.content}</textarea>
</div>
        </td>

      </tr>

        
        <tr class="noborder" >
        <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel"> 
          	{if $_GET.id}
              <input type="hidden" name="id" value="{$_GET.id}" />
              {/if}
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改">
            </div></td>
        </tr>
 



     </tbody>
    </table>
    <input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
  </div>

{include file='../common_admin/right_bar.php'} 