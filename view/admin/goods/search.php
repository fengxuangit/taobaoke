{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="{$URL}m=goods&a=main">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        
        <tr>
          <td colspan="2" class="td27" >关键字:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="keyword" value=""  type="text" class="txt"></td>
          <td class="vtop tips2" >要搜索的关键字</td>
        </tr>
        <tr>
          <td colspan="2" class="td27">搜索字段:</td>
        </tr>
  		<tr class="noborder">
          <td class="vtop rowform">
                  <select name="search_type"  class="select">
                  <option value="title">商品标题</option>
                  <option value="num_iid">商品ID</option>
                  <option value="nick">卖家昵称</option>
                 
          </select>
          </td>
          <td class="vtop tips2" >请选择一个字段,配合关键字进行搜索</td>
        </tr>
         
        <tr class="noborder">
          <td class="vtop rowform">所在栏目</td>
          <td class="vtop tips2" ></td>
        </tr>
         <tr class="noborder">
          <td class="vtop rowform">
                 <select name="fid"  class="select">
                    <option value="0">----选择搜索的栏目----</option>
                    <!--{foreach from=$_G.channels item=vv}-->
                     <option value="{$vv.fid}">&nbsp;&nbsp;{$vv.name}</option>
                    <!--{if $vv.sub }-->                           
                                <!--{foreach from=$vv.sub item=vvv}-->
                                <option value="{$vvv.fid}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
                                <!--{/foreach}-->

                     <!--{/if}-->              
                    <!--{/foreach}-->
          		</select>
          
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform">所在分类</td>
          <td class="vtop tips2" ></td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform">
                 <select name="cate">
                     <option value="0">----请选择商品分类----</option>
                        <!--{foreach from=$_G.goods_cate item=vv}-->
                        <option value="{$vv.id}" >{$vv.name}</option>
                        <!--{/foreach}-->
                      </select>
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform">商品标签</td>
          <td class="vtop tips2" ></td>
        </tr>
         <tr class="noborder">
          <td class="vtop rowform">
                <select name="flag">
					<option value="-1">----请选择商品标签----</option>
                    <!--{foreach from=$_G.setting.flag item=vv key=k}-->
                    <option value="{$k}">{$vv}</option>
                    <!--{/foreach}-->
                  </select>
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>
    <tr class="noborder">
          <tr class="noborder">
          <td class="vtop rowform">卖家店铺类型</td>
          <td class="vtop tips2" ></td>
        </tr>
        
         <tr class="noborder">
          <td class="vtop rowform">
               <ul>
                <input class="radio" type="radio"  name="shop_type" value="-1" checked="checked">
                  &nbsp;不限</li>
                <li >
                  <input class="radio" type="radio" name="shop_type" value="1">
                  &nbsp;商城</li>
                <li>
                  <input class="radio" type="radio" name="shop_type" value="2" >
                  &nbsp;集市</li>
                  <li>
                 
          </ul>
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>  
        
        
                
         <tr>
          <td colspan="2" class="td27" >商品价格范围:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform">
          <input name="yh_price_down" value=""  type="text" class="txt w90">
           - 
          <input name="yh_price_up" value=""  type="text" class="txt w90">
          
          </td>
          <td class="vtop tips2" >要搜索的商品价格范围</td>
        </tr>
       
        
        
           

        <td colspan="3"><div class="fixsel"> 
        	<input type="hidden" name="search"  value="1" />
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