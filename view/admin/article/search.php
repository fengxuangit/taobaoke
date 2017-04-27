{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        
        <tr>
          <td colspan="2" class="td27" >关键字:</td>
        </tr>
        <tr class="noborder">
          <td class="vtop rowform"><input name="title" value=""  type="text" class="txt"></td>
          <td class="vtop tips2" >要搜索的关键字</td>
        </tr>
        <tr>
          <td colspan="2" class="td27">所属标签:</td>
        </tr>
  		<tr class="noborder">
          <td class="vtop rowform">
<select name="cate" class="select_fid"> 
 <option value="">请选择要搜索的分类</option>
<!--{foreach from=$_G.article_cate item=vv}-->
 <option value="{$vv.id}">&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.id}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
</select>
       
          </select>
          </td>
          <td class="vtop tips2" >请选择一个字段,配合关键字进行搜索</td>
        </tr>
         
        
       
    <tr class="noborder">
          <tr class="noborder">
          <td class="vtop rowform">是否隐藏</td>
          <td class="vtop tips2" ></td>
        </tr>
        
         <tr class="noborder">
          <td class="vtop rowform">
               <ul>
                <li > <input class="radio" type="radio"  name="hide" value="" checked="checked">
                  &nbsp;不限</li>
                <li >
                  <input class="radio" type="radio" name="hide" value="1">
                  &nbsp;是</li>
                <li>
                  <input class="radio" type="radio" name="hide" value="2" >
                  &nbsp;否</li>
                  <li>
                 
          </ul>
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>     


       
    <tr class="noborder">
          <tr class="noborder">
          <td class="vtop rowform">是否有缩略图</td>
          <td class="vtop tips2" ></td>
        </tr>
        
         <tr class="noborder">
          <td class="vtop rowform">
               <ul>
                <li > <input class="radio" type="radio"  name="picurl" value="" checked="checked">
                  &nbsp;不限</li>
                <li >
                  <input class="radio" type="radio" name="picurl" value="1">
                  &nbsp;是</li>
                <li>
                  <input class="radio" type="radio" name="picurl" value="2" >
                  &nbsp;否</li>
                  <li>
                 
          </ul>
          </td>
          <td class="vtop tips2" >可空</td>
        </tr>   


 <tr class="noborder">
          <tr class="noborder">
          <td class="vtop rowform">是否有跳转URL</td>
          <td class="vtop tips2" ></td>
        </tr>
        
         <tr class="noborder">
          <td class="vtop rowform">
               <ul>
                <li > <input class="radio" type="radio"  name="url" value="" checked="checked">
                  &nbsp;不限</li>
                <li >
                  <input class="radio" type="radio" name="url" value="1">
                  &nbsp;是</li>
                <li>
                  <input class="radio" type="radio" name="url" value="2" >
                  &nbsp;否</li>
                  <li>
                 
          </ul>
          </td>
          <td class="vtop tips2" >可空</td>
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