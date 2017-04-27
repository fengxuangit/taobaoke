{include file="../header.php"}
{$CSS}

{include file="../apply/hd.php"}

<div class="b6_baomingbk goods_apply">

  <div class="b6_baomingnav cl">

  <div class="b6_bm_d2 cl">
  
   <div class="b6_bm_d2d1" style="margin:20px 0;">
         <div class="cl kefuqq">
		<a >报名咨询:</a>
        {foreach from=$_G.setting.qq item=v}
        <a href="" data-qq="{$v}" class="_qq"></a>
        {/foreach}
        
        </div>

      </div>

      <div class="b6_bm_d2d1">
        <h1>商家报名结果查询</h1>
          <span> <b>商品ID:</b>
          <input type="text" name="item_id"  class="apply_check_value" value="" style="width:120px;">
          </span>
          <div style="text-align:center;">

            <input type="submit" value="查询" class="apply_check_btn">

          </div>
      </div>

      <div class="b6_bm_d2d1 b6_bm_d2d2 cl">

        <h1>商家报名要求</h1>

        <ul>

         {$_G.ad.k5.show_html}

        </ul>

      </div>

    </div>

  

 <div  class="cl z">

    <table class="tb tb2 nobdb" >

      <tbody>

      <form  method="post" action="" >

        <tr class="noborder" >

          <td  class="td_l">自动抓取:</td>

          <td class="vtop rowform"><input name="goods_id" value="{$_GET.goods_id}" type="text" class="txt" >

            &nbsp;

            <input type="submit" class="btn"  name="get_submit" value="抓取"  ></td>

          <td class="vtop tips2" >填写商品ID或是商品链接,获取商品信息</td>

        </tr>

      <input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>

          <form  method="post" action="" >

        <tr class="noborder" >

          <td  class="td_l">商品标题:</td>

          <td class="vtop rowform"><input name="postdb[title]" value="{$goods.title}" type="text" class="txt"></td>

          <td class="vtop tips2" >必填!10个字以内!</td>

        </tr>

        <tr class="noborder" >

          <td class="td_l">所属栏目:</td>

          <td class="vtop rowform" ><select name="postdb[fid]">

              <option value="0">----请选择报名的栏目----</option>



<!--{foreach from=$_G.channels item=vv}-->

  <!--{if $vv.hide==0 }--> 

         	<option value="{$vv.fid}" {if $vv.fid==$_GET.fid } selected="selected"{/if} >&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>

            <!--{if $vv.sub}-->

                  <!--{foreach from=$vv.sub item=vvv}-->

                    <!--{if $vvv.hide ==0}-->                     

                          <option value="{$vvv.fid}" {if $vvv.fid==$_GET.fid } selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>

                           <!--{foreach from=$vvv.sub item=a}-->

                             <!--{if $a.hide == 0}-->

                           		<option value="{$a.fid}" {if $a.fid==$_GET.fid } selected="selected"{/if} >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>

                          	<!--{/if}-->  

                          <!--{/foreach}-->

                      <!--{/if}-->  

                  <!--{/foreach}-->

            <!--{/if}-->   

 <!--{/if}-->                     

<!--{/foreach}-->

              

              

            </select></td>

          <td class="vtop tips2" >选择商品类别,如果没有请选择其他</td>

        </tr>

        

        {if $_GET.cate>0}        

        <input type="hidden" name="postdb[cate]"  value="{$_GET.cate}"/>

        {else}

        <tr class="noborder hide" >

          <td class="td_l">商品分类:</td>

          <td class="vtop rowform"><select name="postdb[cate]">

              <option value="0">----请选择商品分类----</option>

              <!--{foreach from=$_G.goods_cate item=vv}-->

              <option value="{$vv.id}" >{$vv.name}</option>

              <!--{/foreach}-->

            </select></td>

          <td class="vtop tips2" >商品报名所属分类</td>

        </tr>

         {/if}



        <tr class="td_l noborder" >

          <td  class="td_l">店铺类型:</td>

          <td class="vtop rowform"><ul>

              <li >

                <input class="radio" type="radio" name="postdb[shop_type]" value="1" {if $goods.shop_type==1}checked="checked"{/if}>

                &nbsp;商城</li>

              <li>

                <input class="radio" type="radio" name="postdb[shop_type]" value="2" {if $goods.shop_type==2}checked="checked"{/if}>

                &nbsp;集市</li>

				</li>

            </ul></td>

          <td class="vtop tips2" >卖家店铺类型</td>

        </tr>

        <tr class="noborder"  style="display:none;">

          <td  class="td_l">商品ID:</td>

          <td class="vtop rowform"><input name="postdb[num_iid]" value="{$goods.num_iid}" type="text" class="txt" {$readonly}></td>

          <td class="vtop tips2" >采集的请不要更改</td>

        </tr>

        

        <tr class="noborder" >

          <td class="td_l">商品主图:</td>

          <td class="vtop rowform _hover_img">

          

<div class="upload_img" data-name="postdb[picurl]">

<input name="postdb[picurl]" value="{$goods.picurl}" type="text" class="txt pic_upload change_pic_main" >



</div>

<a href="{$goods.picurl}" target="_blank" ><img src="{$goods.picurl}"  /></a>

<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />  

          </td>

          <td class="vtop tips2" >请填写或者上传320X220像素的图片!</td>

        </tr>



        <tr class="noborder"  style="display:none;">

          <td class="td_l">商品副图:</td>

          <td class="vtop rowform"> {if $goods.images}

            {foreach from=$goods.images item=v1 key =k}

            <p  class="_hover_img">

              <input  name="images[]" value="{$v1}" type="text" class="txt change_pic_value" {$readonly}>

             <a href="#" title="{$v1}" data-index="{$k}" class="change_pic red">选为主图</a>

             <a href="{$v1}" target="_blank"><img src="{$v1}"  /></a>

              </p>

            {/foreach}

            {else}

            <input  name="images[]" value="" type="text" class="txt" >

            {/if} </td>

          <td class="vtop tips2" >留空则删除当前图片</td>

        </tr>



        <tr class="noborder" >

          <td class="td_l">商品原价:</td>

          <td class="vtop rowform"><input  name="postdb[price]" value="{$goods.price}" type="text" class="txt" {$readonly}></td>

          <td class="vtop tips2" >采集的请不要修改,最多一位小数</td>

        </tr>

         <tr class="noborder" >

          <td class="td_l" style="color: red;">活动价:</td>

          <td class="vtop rowform"><input  name="postdb[yh_price]" value="{$goods.yh_price}" type="text" class="txt" ></td>

          <td class="vtop tips2" >优惠价,最多一位小数</td>

        </tr>


        <tr class="noborder hide" >

          <td class="td_l">上线时间段:</td>

          <td class="vtop rowform"><input  name="postdb[start_time]" value="{$goods.start_time}" type="text" class="txt _dateline" ></td>

          <td class="vtop tips2" >报名期望上线的时间段(具体时间客服会根据站内情况调整),如果报名整点秒杀请选择正确时间否则影响上线</td>

        </tr>

        <tr class="noborder hide" >

          <td class="td_l">下线时间段:</td>

          <td class="vtop rowform"><input  name="postdb[end_time]" value="{$goods.end_time}" type="text" class="txt _dateline" ></td>

          <td class="vtop tips2" >报名期望下线的时间段(具体时间客服会根据站内情况调整)</td>

        </tr>

        <tr class="noborder" style="display:none;">

          <td class="td_l">商品所在地:</td>

          <td class="vtop rowform"><input  name="postdb[city]" value="{$goods.city}" type="text" class="txt w90" {$readonly}>

            省&nbsp;

            <input  name="postdb[state]" value="{$goods.state}" type="text" class="txt w90" {$readonly}>

            市 </td>

          <td class="vtop tips2" >发货城市</td>

        </tr>

       

        <tr class="noborder" >

          <td  class="td_l">联系人:</td>

          <td class="vtop rowform"><input name="postdb[name]" value="{$goods.name}" type="text" class="txt"></td>

          <td class="vtop tips2" >请填写联系人姓名</td>

        </tr>

      

         <tr class="noborder" >

          <td  class="td_l">佣金比例:</td>

          <td class="vtop rowform"><input name="postdb[bili]" value="{$goods.bili}" type="text" class="txt">%</td>

          <td class="vtop tips2" >5%以上!关系到审核通过的条件之一,填写不实则商品会直接删除或审核不通过</td>

		</tr>

    

        <tr class="noborder" >

          <td  class="td_l">联系电话:</td>

          <td class="vtop rowform"><input name="postdb[phone]" value="{$goods.phone}" type="text" class="txt"></td>

          <td class="vtop tips2" >请填写联系电话</td>

        </tr>

        

         <tr class="noborder" >

            <td class="td_l">推荐理由:</td>

            <td class="vtop rowform">

            <textarea rows="3" name="postdb[ly]" cols="35" class="ks-editor-textarea">{$goods.ly}</textarea>

            </td>

            <td class="vtop tips2">商品亮点或推荐理由,100字以内,关系到审核通过的条件之一</td>

   	 </tr>




 <tr class="noborder" >

            <td class="td_l">验证码</td>
            <td class="vtop rowform" colspan="2">
           <input type="text" class="text" name="yzm" style="width:140px;margin-right:10px;float:left;height: 34px;font-size: 16px;"  placeholder="请输入验证码" data-type="yzm">
             <img   height="40" src="{$URL}m=ajax&a=yzm" class="yzm_img yzm">
              <a class="yzm" href="#" >刷新</a>
            </td>
     </tr>

     

        <tr>

          <td>&nbsp;</td>

          <td colspan="5">
              <input type="submit" class="btn"   name="onsubmit" title="按 Enter 键可随时提交您的修改" value="提交" >

            </div></td>

        </tr>

        
<input  name="postdb[nick]" value="{$goods.nick}" type="hidden" class="txt"{$readonly} >
          <input  name="postdb[url]" value="{$goods.url}" type="hidden" class="txt" {$readonly}>
<input  name="postdb[sum]" value="{$goods.sum}" type="hidden" class="txt" >
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>

        </tbody>

      

    </table>

  </div>
  </div>

</div>

{include file="../footer.php"} 
