{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_main" style="padding-bottom:300px;">
    <table class="tb tb2 nobdb" >
      <tbody>

        <tr class="noborder">
          <td class="td_l">标题:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="{$goods.title}" type="text" class="txt check_text _keywords" data-msg="标题不能为空"></td>
          <td class="vtop tips2">请输入标题,30字以内</td>
        </tr>
        
         <tr class="noborder">
          <td class="td_l">所属分类:</td>
          <td class="vtop rowform">

<select name="postdb[cate]" class="fup select_fid">
{foreach from=$_G.style_cate item=vv key=kk}
 <option value="{$vv.id}" {if $goods.cate==$vv.id} selected="selected" class="on"  {/if}>{$vv.name}</option>
{/foreach}
</select>
          </td>
          <td class="vtop tips2">当前搭配所属分类</td>
        </tr>
        


 <tr class="noborder">
          <td class="td_l">关键字:</td>
          <td class="vtop rowform"><input name="postdb[keywords]" value="{$goods.keywords}" type="text" class="txt _in_keywords"></td>
          <td class="vtop tips2">自定义关键字(用,隔开,每个标签少于2-5个汉字)</td>
  </tr>

        
        <tr class="noborder">
          <td class="td_l">排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$goods.sort}" type="text" class="txt w90"></td>
          <td class="vtop tips2">越大越靠前</td>
        </tr>


        <tr class="noborder">
            <td class="td_l">喜欢:</td>
            <td class="vtop rowform"><input name="postdb[like]" value="{$goods.like}" type="text" class="txt w90"></td>
            <td class="vtop tips2">喜欢统计</td>
        </tr>


        <tr class="noborder">
          <td class="td_l">是否审核:</td>
          <td class="vtop rowform">
          
          
<input class="radio check_radio2" type="radio" name="postdb[check]" value="1" {if $goods.check ==1 || !$goods.id} checked="checked"{/if}>
 &nbsp;是
            <input class="radio  check_radio2" type="radio" name="postdb[check]" value="0"  {if $goods.check ==0 && $goods.id} checked="checked"{/if}>
 &nbsp;否
            
            
          </td>
          <td class="vtop tips2">选中了前台显不显示</td>
        </tr>
       
      <tr class="noborder">
          <td class="td_l">搭配主图:</td>
          <td class="vtop rowform _hover_img">
         <div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$goods.picurl}" type="text" class="txt pic_upload" >
{if $channel.picurl}
<a class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div> 
<a href="{$goods.picurl}" target="_blank" ><img src="{$goods.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />

          </td>
          <td class="vtop tips2">当前主题的图片</td>
        </tr>
        
          <tr class="noborder">
          <td class="td_l">搭配副图:</td>
          <td class="vtop rowform _hover_img">
          
          <div class="upload_items" data-images="{implode(',',$goods.images)}"></div>
                <input name="images[]" value="" type="text" class="txt upload_btn" data-max="3">
          </td>
          <td class="vtop tips2">当前主题的图片</td>
        </tr>
        
        <tr class="noborder">
          <td class="td_l">内容描述:</td>
          <td class="vtop rowform"><textarea rows="5" name="postdb[content]" cols="70" class="tarea">{$goods.content}</textarea></td>
          <td class="vtop tips2">可填入当前主题的描述或介绍信息</td>
        </tr>

        <tr class="noborder">
          <td class="vtop rowform" colspan="3" style="color:#f00">
          ==================================================单品信息共{$goods.length}条========================================================
          </td>
        </tr>
         </tbody>
         

{foreach from =$goods.goods item=v name=d}

<tbody class="tbody_dp" data-index="{$smarty.foreach.d.index+1}">
		<input type="hidden" name="dp_like[]" value="{$v.like}">
          <tr class="noborder">
          <td class="vtop rowform" colspan="3" zj="color:#00F">
            ID<span zj="padding-left:150px;">单品({$smarty.foreach.d.index+1})</span>
            <input name="dp_del[]" value="1" type="checkbox"  title="选中后当前单品将为删除" class="del_dp">删除
            <input type="hidden" name="dp_new[]"  value=""/>
          </td>
        </tr>

		 <tr class="noborder">
          <td class="td_l">标题:</td>
          <td class="vtop rowform"><input name="dp_title[]" value="{$v.title}" type="text" class="txt title_"></td>
          <td class="vtop tips2">请输入标题</td>
        </tr>
        
        

         <tr class="noborder">
          <td class="td_l">商品ID:</td>
          <td class="vtop rowform"><input name="dp_num_iid[]" value="{$v.num_iid}" type="text" class="txt num_iid_" zj="width:280px">&nbsp;
          <input type="button" value="一键抓取" class="btn get_goods" title=""/>&nbsp;
         {if $v.num_iid} <a href="http://item.taobao.com/item.htm?id={$v.num_iid}" target="_blank">查看</a>{/if}
          </td>
          <td class="vtop tips2">填写淘宝商品的ID或是淘宝商品的链接地址</td>
        </tr>
          
		
        
         <tr class="noborder" >
        <td class="td_l">所属栏目:</td>
        <td class="vtop rowform">

<select name="dp_fids[]" class="select_fid"> 
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $v.fid==$vv.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $v.fid==$vvv.fid } selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $v.fid==$a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
</select>

          </td>
        <td class="vtop tips2" >本栏目的上级栏目或分类</td>
      </tr>
      
      
         <tr class="noborder">
          <td class="td_l">价格:</td>
          <td class="vtop rowform"><input name="dp_price[]" value="{$v.price}" type="text" class="txt price_"></td>
          <td class="vtop tips2">请输入当前单品的价格</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">图片链接:</td>
          <td class="vtop rowform _hover_img">
                <input name="dp_picurl[]" value="{$v.picurl}" type="text" class="txt picurl_" >
                 {if $v.picurl}<a href=""  class="ajax_del" >删除</a>
                 <a href="{$v.picurl}" target="_blank" ><img src="{$v.picurl}"  /></a>
                {/if}

          </td>
          <td class="vtop tips2">当前单品的图片</td>
        </tr>       
        <tr class="noborder hide">
          <td class="td_l">描述:</td>
          <td class="vtop rowform"><textarea rows="3" name="dp_content[]" cols="50" class="tarea content_">{$v.content}</textarea></td>
          <td class="vtop tips2">可填入当前单品的描述或介绍信息</td>
        </tr>
</tbody>

{/foreach}

         
         
 <tbody class="postbody">
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel"> 
              <!--{if $_GET.id}-->
              <input type="hidden" name="id" value="{$goods.id}" />
              <!--{/if}-->
                <span > <input type="button" value="添加单品"  class="btn add_dp"/>&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <input type="submit" class="btn check_form" name="onsubmit" value="提交">
            </div></td>
        </tr>

      </tbody>
    </table>
  </div>

<div class="select_box hide">

<select name="dp_fids[]" class="select_fid"> 
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}">&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
</select>

</div>
  
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 