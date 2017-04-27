{include file="../header.php"}

<link rel="stylesheet" type="text/css" href="{$CSSDIR}/home_goods_list.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/apply-new.css" media="all" />



<div class="index2_box cl home_post " >

    <ul class="cl">

       <form method="post">

      <li class="uc_zlli2 ff" style="height:auto;">
{if $goods.status >9}<span style="font-size:18px;color:#F00;">当前状态:{$goods.status_text} {$goods.status_text2}</span>{/if}
      <span style="color:#03C;">
      
      重新提交未通过审核的商品,,请认真填写相关内容,否则多次申核后还不成功,将禁止此商品报名,严重者将禁止店铺所有商品报名

      </span>      

      </li>

      

<li style="font-size:24px;text-align:center;">

{if $goods.check ==0}

 当前商品{$goods.status_text}

{elseif $goods.check ==2}

     当前商品 <span  style="color:#F00;">未通过审核原因:{$goods.return_msg}</span>

{/if}

</li>

      <li class="uc_zlli1">

       <label>标题：</label>

        <input class="uinfo text"  name="postdb[title]" type="text" value="{$goods.title}" style="width: 380px;">

     </li>

        

        

     <li class="uc_zlli1">

       <label>报名栏目：</label>

<select name="postdb[fid]">

              <option value="0">----请选择报名的栏目----</option>



<!--{foreach from=$_G.channels item=vv}-->

  <!--{if $vv.hide==0 }--> 

         	<option value="{$vv.fid}" {if $vv.fid==$goods.fid } selected="selected"{/if} >&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>

            <!--{if $vv.sub}-->

                  <!--{foreach from=$vv.sub item=vvv}-->

                    <!--{if $vvv.hide ==0}-->                     

                          <option value="{$vvv.fid}" {if $vvv.fid==$goods.fid } selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>

                           <!--{foreach from=$vvv.sub item=a}-->

                             <!--{if $a.hide == 0}-->

                           		<option value="{$a.fid}" {if $a.fid==$goods.fid } selected="selected"{/if} >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>

                          	<!--{/if}-->  

                          <!--{/foreach}-->

                      <!--{/if}-->  

                  <!--{/foreach}-->

            <!--{/if}-->   

 <!--{/if}-->                     

<!--{/foreach}-->

       </select>

     </li> 

     

      <li class="uc_zlli1">

       <label>报名分类：</label>

<select name="postdb[cate]">


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

     </li> 

     <li class="uc_zlli3 _hover_img" style="position: relative;">

      <div class="cl">

        <label>商品主图：</label>

        <div class="upload_img" data-name="postdb[picurl]">

        <input name="postdb[picurl]" value="{$goods.picurl}" type="text" class="txt pic_upload text" >

        </div>

       </div>

       <div class="cl ">

        <label>&nbsp;</label>

        <a href="{$goods.picurl}" target="_blank" ><img src="{$goods.picurl}"  /></a>

        <input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />

        </div>

        

      </li>

     

      <li class="uc_zlli1">

       <label>是否包邮：</label>

 <input class="radio" type="radio" name="postdb[baoyou]" value="1" {if $goods.baoyou==1}checked="checked"{/if} {$readonly}>

                &nbsp;是  &nbsp;&nbsp;&nbsp;&nbsp;

<input class="radio" type="radio" name="postdb[baoyou]" value="0" {if !$goods.baoyou}checked="checked"{/if} {$readonly}>

                &nbsp;否

     </li> 

     

     

      <li class="uc_zlli1">

       <label>店铺类型：</label>

 <input class="radio" type="radio" name="postdb[shop_type]" value="1" {if $goods.shop_type==1}checked="checked"{/if}>

                &nbsp;商城&nbsp;&nbsp;&nbsp;&nbsp;

 <input class="radio" type="radio" name="postdb[shop_type]" value="2" {if $goods.shop_type==2}checked="checked"{/if}>

                &nbsp;集市

     </li> 

     

      <li class="uc_zlli1">

       <label>商品库存数：</label>

        <input class="uinfo text"  name="postdb[num]" type="text" value="{$goods.num}">

     </li> 

      

      <li class="uc_zlli1">

        <label>商品优惠价：</label>

        <input class="uinfo uc_zlli1text text" name="postdb[yh_price]" type="text" value="{$goods.yh_price}">

      </li>

      <li class="uc_zlli1">

         <label>销    量：</label>

        <input class="uinfo uc_zlli1text text" name="postdb[sum]" type="text" value="{$goods.sum}">

      </li>

         <li class="uc_zlli1">

         <label>上线时间段：</label>

        <input class="uinfo uc_zlli1text text _dateline" name="postdb[start_time]" type="text" value="{$goods.start_time}">

      </li> 



       

      </li>

      <li class="uc_zlli1">

        <label>下线时间段：</label>

        <input class="uinfo uc_zlli1text text _dateline" name="postdb[end_time]"  type="text" value="{$goods.end_time}">

        <h2></h2>

      </li>



        <li class="uc_zlli1">

        <label>佣金比例：</label>

         <input class="uinfo uc_zlli1text text" name="postdb[bili]"  type="text" value="{$goods.bili}">%
         

      </li>

      

      <li class="uc_zlli6">

        <label>推荐理由：</label>

        <textarea class="uinfo textarea" name="postdb[ly]">{$goods.ly}</textarea>

      </li>

      

      <li class="uc_zlli1">

        <label>联系人：</label>

         <input class="uinfo uc_zlli1text text" name="postdb[apply_user]"  type="text" value="{$goods.apply_user}">

      </li>

      

     

      <li class="uc_zlli1">

        <label>旺旺：</label>

         <input class="uinfo uc_zlli1text text" name="postdb[apply_wangwang]"  type="text" value="{$goods.apply_wangwang}">

      </li>

        <li class="uc_zlli1">

        <label>联系电话：</label>

         <input class="uinfo uc_zlli1text text" name="postdb[apply_phone]"  type="text" value="{$goods.apply_phone}">

      </li>

       <li class="uc_zlli1">

        <label>联系qq：</label>

         <input class="uinfo uc_zlli1text text" name="postdb[apply_qq]"  type="text" value="{$goods.apply_qq}">

      </li>

      



      

      

      <li class="uc_zlli4">

        <label></label>

         <input type="submit" class="seting_onsubmit u_submit"   name="onsubmit"value=" 保 存" />

            

      </li>

<input type="hidden" name="aid" value="{$goods.aid}" />

<input type="hidden" name="m" value="{$CURMODULE}" />

<input type="hidden" name="a" value="{$CURACTION}" />

</form>

    </ul>

</div>

{include file="../footer.php"}
