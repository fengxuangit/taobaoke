{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">规则名称:</td>
          <td class="vtop rowform"><input name="title" value="{$fetch.title}" type="text" class="txt"></td>
          <td class="vtop tips2">规则名称</td>
        </tr>
        
  <tr class="noborder" >
        <td class="td_l">所属栏目:</td>
        <td class="vtop rowform">

<select name="fid" class="select_fid"> 
 <option value="0">----请选择栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $goods.fid==$vv.fid || $vv.fid==$fetch.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $goods.fid==$vvv.fid || $vvv.fid==$fetch.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $goods.fid==$a.fid || $a.fid==$fetch.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
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
          <td class="td_l">关键字</td>
          <td class="vtop rowform" ><input name="postdb[keyword]" value="{$fetch.keyword}" type="text" class="txt " >
            (<span class="red">*</span>) </td>
          <td class="vtop tips2">关键字与pid必填一项</td>
        </tr>
        
        
      <tr class="noborder">
          <td class="td_l">商品类目Id</td>
          <td class="vtop rowform" >         

                <select name="postdb[fup]"  class="select select_cates" >
                <option value="">----不限----</option>
                 <!--{foreach from=$cates item=vv}-->
                <option value="{$vv.cid}"  {if $fetch.fup==$vv.cid } selected{/if} >{$vv.name}</option>
                <!--{/foreach}-->
                </select>
			<span class="select_cates_sub"  data-cid="{$fetch.cid}"></span>
            
            (*) </td>
          <td class="vtop tips2">cid关与键字必填一项</td>
        </tr>
      
      
     <tr class="noborder">
          <td class="td_l">是否商城:</td>
          <td class="vtop rowform">
          <input class="radio" type="radio" name="postdb[mall_item]" value="true" {if $fetch.mall_item=='true'}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[mall_item]" value="false"  {if $fetch.mall_item=='false'}checked="checked"{/if}>
            &nbsp;不限
			</td>
          <td class="vtop tips2">可空</td>
        </tr>
        
        
        <tr class="noborder">
          <td class="td_l">排序</td>
          <td class="vtop rowform" ><select name="postdb[sort]"  class="select auto_select" data-value="{$fetch.sort}" >
              <option value="default" >默认</option>
              <option value="price_desc">原价从高到低</option>
              <option value="price_asc">原价从低到高</option>
              <option value="credit_desc">信用等级从高到低</option>
              <option value="credit_asc">信用等级从低到高</option>
              <option value="commission_num_desc">佣金比率从高到低</option>
              <option value="commission_rate_asc">佣金比率从低到高</option>
<!--              <option value="commission_num_desc">成交量成高到低</option>
              <option value="commission_num_asc">成交量从低到高</option>     -->         
            </select></td>
          <td class="vtop tips2"></td>
        </tr>
        
        <tr class="noborder">
          <td class="td_l">卖家信用</td>
          <td class="vtop rowform" ><select name="postdb[startcredit]" class="select auto_select"   style="width:120px;"  data-value="{$fetch.startcredit}">
              <option value="">----不限----</option>
              <option value="1heart">一心</option>
              <option value="2heart ">二心</option>
              <option value="3heart ">三心</option>
              <option value="4heart ">四心</option>
              <option value="5heart ">五心</option>
              <option value="1diamond">一钻</option>
              <option value="2diamond">二钻</option>
              <option value="3diamond">三钻</option>
              <option value="4diamond">四钻</option>
              <option value="5diamond">五钻</option>
              <option value="1crown">一冠</option>
              <option value="2crown">二冠</option>
              <option value="3crown">三冠</option>
              <option value="4crown">四冠</option>
              <option value="5crown">五冠</option>
              <option value="1goldencrown">一黄冠</option>
              <option value="2goldencrown">二黄冠</option>
              <option value="3goldencrown">三冠</option>
              <option value="4goldencrown">四黄冠</option>
              <option value="5goldencrown">五黄冠</option>
            </select>            
            &nbsp;--&nbsp;
            <select name="postdb[endcredit]"   style="width:120px;" data-value="{$fetch.endcredit}" class="select auto_select">
              <option value="">----不限----</option>
              <option value="1heart">一心</option>
              <option value="2heart ">二心</option>
              <option value="3heart ">三心</option>
              <option value="4heart ">四心</option>
              <option value="5heart ">五心</option>
              <option value="1diamond">一钻</option>
              <option value="2diamond">二钻</option>
              <option value="3diamond">三钻</option>
              <option value="4diamond">四钻</option>
              <option value="5diamond">五钻</option>
              <option value="1crown">一冠</option>
              <option value="2crown">二冠</option>
              <option value="3crown">三冠</option>
              <option value="4crown">四冠</option>
              <option value="5crown">五冠</option>
              <option value="1goldencrown">一黄冠</option>
              <option value="2goldencrown">二黄冠</option>
              <option value="3goldencrown">三黄冠</option>
              <option value="4goldencrown">四黄冠</option>
              <option value="5goldencrown">五黄冠</option>
            </select>

            
           </td>
          <td class="vtop tips2">可空,上限的值一定要小于或等于下限的值。注：上限与下限一起使用才生效</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">佣金比例范围</td>
          <td class="vtop rowform" ><input name="postdb[start_commission_rate]" value="{$fetch.start_commission_rate}" type="text" class="txt w90" >%
            &nbsp;--&nbsp;
            <input name="postdb[end_commission_rate]" value="{$fetch.end_commission_rate}" type="text" class="txt w90" >%</td>
          <td class="vtop tips2">可空,整数,1-100</td>
        </tr>
      
        <tr class="noborder">
          <td class="td_l">30天累计推广量范围</td>
          <td class="vtop rowform" ><input name="postdb[start_commission_num]" value="{$fetch.start_commission_num}" type="text" class="txt w90" >
            &nbsp;--&nbsp;
            <input name="postdb[end_commission_num]" value="{$fetch.end_commission_num}" type="text" class="txt w90" ></td>
          <td class="vtop tips2">可空,整数,需要上限和下限一起设置才有效</td>
        </tr>
       
       
       <!-- <tr class="noborder">
          <td class="td_l">商品总成交量范围</td>
          <td class="vtop rowform" ><input name="postdb[start_totalnum]" value="" type="text" class="txt w90" >
            &nbsp;--&nbsp;
            <input name="postdb[end_totalnum]" value="" type="text" class="txt w90" ></td>
          <td class="vtop tips2">可空,整数,需要上限和下限一起设置才有效</td>
        </tr>
        -->
         <tr class="noborder">
          <td class="td_l">价格范围</td>
          <td class="vtop rowform" ><input name="postdb[start_price]" value="{$fetch.start_price}" type="text" class="txt w90" >
            &nbsp;--&nbsp;
            <input name="postdb[end_price]" value="{$fetch.end_price}" type="text" class="txt w90" ></td>
          <td class="vtop tips2">可空,整数,需要上限和下限一起设置才有效</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">商品所在地</td>
          <td class="vtop rowform" ><input name="postdb[area]" value="{$fetch.area}" type="text" class="txt" ></td>
          <td class="vtop tips2">可空,如:杭州,北京,上海</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">每页结果数</td>
          <td class="vtop rowform" ><input name="postdb[page_size]" value="{if $fetch.page_size}{$fetch.page_size}{else}100{/if}" type="text" class="txt" ></td>
          <td class="vtop tips2">可空,最大每页100</td>
        </tr>
        
        </tbody>
      
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
  </div>
  <input type="hidden" name="m" value="{$CURMODULE}" />
  <input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 