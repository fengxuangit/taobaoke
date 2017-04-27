{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
 
         <tr class="noborder " >
          <td class="td_l">兑换商品名称 :</td>
          <td class="vtop rowform">
          <a href="{$goods.goods.id_url}" class="red" target="_blank">{$goods.goods.title}</a>
       </td>
          <td class="vtop tips2"><a href="{$referer}">返回上一页</a></td>
        </tr>
        
           <tr class="noborder " >
          <td class="td_l">商品信息 :</td>
          <td class="vtop rowform">
          当前商品共提供 <span class="red">{$goods.goods.sum}</span> 份,
          已申请成功 <span class="red">{$goods.goods.num}</span> 份,
          还有 <span class="red">{$goods.goods.sum-$goods.goods.num}</span> 份未兑换
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
          <tr class="noborder " >
          <td class="td_l">兑换时间 :</td>
          <td class="vtop rowform red">
         兑换时间<span class="_dgmdate" data-time="{$goods.goods.start_time}"></span> ~ <span class="_dgmdate" data-time="{$goods.goods.end_time}"></span>
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
      <tr class="noborder " >
          <td class="td_l">兑换申请时间 :</td>
          <td class="vtop rowform _dgmdate" data-time="{$v.dateline}">

     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
           
      <tr class="noborder " >
          <td class="td_l">上次修改状态时间 :</td>
          <td class="vtop rowform _dgmdate" data-time="{$goods.statustime}"></td>
          <td class="vtop tips2"></td>
        </tr>
              
   
   
          <tr class="noborder " >
          <td class="td_l">用户名 :</td>
          <td class="vtop rowform">
          {$goods.username} <span class="red">(ip   {$goods.ip})</span>
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
          <tr class="noborder " >
          <td class="td_l">旺旺 :</td>
          <td class="vtop rowform">
           <div class="cl _wangwang" data-nick="{$goods.wangwang}"></div>
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
        
          <tr class="noborder " >
          <td class="td_l">收货人姓名 :</td>
          <td class="vtop rowform">
             <input class="txt" type="text" name="postdb[truename]" value="{$goods.truename}" />
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
       <tr class="noborder " >
          <td class="td_l">收货人电话 :</td>
          <td class="vtop rowform">
           <input class="txt" type="text" name="postdb[phone]" value="{$goods.phone}" />
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
           
       <tr class="noborder " >
          <td class="td_l">收货人支付宝 :</td>
          <td class="vtop rowform">
            <input class="txt" type="text" name="postdb[alipay]" value="{$goods.alipay}" />
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
            <tr class="noborder " >
          <td class="td_l">申请者地址 :</td>
          <td class="vtop rowform">
         
             <input class="txt" type="text" name="postdb[address]" value="{$goods.address}" />
     	  </td>
          <td class="vtop tips2"></td>
        </tr>
        
       
        
                   
      <tr class="noborder " >
          <td class="td_l">当前状态 :</td>
          <td class="vtop rowform">

			<select name="postdb[status]"  class="select">
            {foreach from=$_G.setting.duihuan_status item=v1 key=k1}
            <option value="{$k1}" {if $k1 == $goods.status} selected="selected"{/if}>{$v1}</option>
            {/foreach}
            </select>
            <input type="hidden" name="org_status"  value="{$goods.status}"/>
     	  </td>
          <td class="vtop tips2">修改当前兑换的状态</td>
        </tr>
        
       
        
          <tr class="noborder " >
          <td class="td_l">备注留言 :</td>
          <td class="vtop rowform">

			<textarea rows="6" name="postdb[content]" cols="70" >{$goods.content}</textarea>
     	  </td>
          <td class="vtop tips2">可填写发货快递信息或留言</td>
        </tr>
        
       
        
        
      
        

    
        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <input type="submit" class="btn submit_btn"  name="onsubmit" value="提交">
              <input type="hidden" name="id" value="{$goods.id}">
              <input type="hidden" name="duihuan_id" value="{$goods.duihuan_id}">
            </div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 