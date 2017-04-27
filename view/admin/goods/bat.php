{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" action="">
  
    <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      
        
      <tr class="noborder" >
       <td class="td_l">商品id列表</td>
          <td class="vtop rowform" colspan="2">
  		  <textarea rows="8"  name="postdb[ids]"  cols="80" class="tarea"></textarea> <span class="red">多个以英文,逗号格开</span>
          </td>

        </tr>
      
      
      
      <tr class="noborder" >
          <td class="td_l"><input type="checkbox" class="checkbox" name="del_check" value="1" /> 删除</td>
          <td class="vtop rowform">
      删除上面列表框中的所有商品
          </td>
          <td class="vtop tips2" >删除上面列表框中的所有商品</td>
        </tr>
    
      
        <tr class="noborder" >
          <td class="td_l"><input type="checkbox" class="checkbox" name="flag_check" value="1" /> 修改标签: </td>
          <td class="vtop rowform">
           <select name="postdb[flag]">
					<option value="-1">----请选择商品标签----</option>
                    <!--{foreach from=$_G.setting.flag item=vv key=k}-->
                    <option value="{$k}">{$vv}</option>
                    <!--{/foreach}-->
                  </select>
          </td>
          <td class="vtop tips2" >修改商品标签</td>
        </tr>

 <tr class="noborder">
          <td class="td_l"><input type="checkbox" class="checkbox" name="fid_check" value="1" /> 修改栏目: </td>
          <td class="vtop rowform">
              <select name="postdb[fid]"  class="select">
                    <option value="0">----选择搜索的栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" >&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
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
            </td>
          <td class="vtop tips2">修改商品所属栏目</td>
</tr>

 <tr class="noborder">
          <td class="td_l"><input type="checkbox" class="checkbox" name="cate_check" value="1" /> 修改分类: </td>
          <td class="vtop rowform">
             <select name="postdb[cate]">
                     <option value="0">----请选择商品分类----</option>
                        <!--{foreach from=$_G.goods_cate item=vv}-->
 <option value="{$vv.id}" >&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.id}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->    
                        <!--{/foreach}-->
                      </select>
            </td>
          <td class="vtop tips2">修改商品所属分类</td>
</tr>


        <tr class="noborder" >
          <td class="td_l"><input type="checkbox" class="checkbox" name="start_time_check" value="1" /> 上线时间: </td>
          <td class="vtop rowform"> <input name="postdb[start_time]" value="" type="text" class="txt _dateline"></td>
          <td class="vtop tips2" >修改商品上线时间</td>
        </tr>

        
     <tr class="noborder">
          <td class="td_l"><input type="checkbox" class="checkbox" name="end_time_check" value="1" /> 下线时间: </td>
          <td class="vtop rowform">  <input name="postdb[end_time]" value="" type="text" class="txt _dateline"></td>
          <td class="vtop tips2">修改商品下线时间</td>
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
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 