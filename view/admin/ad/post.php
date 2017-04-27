{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">广告名称:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$ad.name}" type="text" class="txt"></td>
          <td class="vtop tips2">供后台查看,前台一般不显示</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">隐藏:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[hide]" value="1" {if $ad.hide==1}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[hide]" value="0" {if $ad.hide==0}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>
          
          </td>
          <td class="vtop tips2">选中的话,前台则不显示</td>
        </tr>
        
        
 		 <tr class="noborder">
          <td class="td_l">开始时间:</td>
          <td class="vtop rowform">
          <input name="postdb[start_time]" value="{$ad.start_time}" type="text" class="txt _dateline"></td>
          <td class="vtop tips2">未到时间,不会显示.留空或0,则一直显示</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">结束时间:</td>
          <td class="vtop rowform">
          <input name="postdb[end_time]" value="{$ad.end_time}" type="text" class="txt _dateline" ></td>
          <td class="vtop tips2">已到时间,不会显示.留空或0,则一直显示</td>
        </tr>
        
        
		 <tr class="noborder">
          <td class="td_l">广告类型:</td>
          <td class="vtop rowform">
          {foreach from=$ad_types item =v key=k}
           <input type="radio" name="postdb[type]"  value="{$k}"  class="ad_types radio" {if $ad.type==$k} checked="checked"{/if} />{$v} 
           
          {/foreach}
			</td>
          <td class="vtop tips2"></td>
        </tr>
        
      
     </tbody>
   <tbody class="show_ads {if $ad.type!=1 || !$ad.type}hide{/if}">
       <tr class="noborder">
        <td class="td_l">内容:</td>
        <td class="vtop rowform">
        <textarea rows="6" name="postdb[content]" cols="70">{$ad.content}</textarea></td>
        <td class="vtop tips2"></td>
      </tr>
   </tbody>
   
  
 	<tbody class="show_ads {if $ad.type !=2}hide{/if}">
   		 <tr class="noborder">
          <td class="td_l">图片宽:</td>
          <td class="vtop rowform"><input name="postdb[width]" value="{$ad.width}" type="text" class="txt"></td>
          <td class="vtop tips2">留空或0,则默认是自适应宽</td>
        </tr>   
        <tr class="noborder">
          <td class="td_l">图片高:</td>
          <td class="vtop rowform">
          <input name="postdb[height]" value="{$ad.height}" type="text" class="txt"></td>
          <td class="vtop tips2">留空或0,则默认是自适应高</td>
        </tr>   
         
            <tr class="noborder">
          <td class="td_l">图片地址:</td>
          <td class="vtop rowform _hover_img">
          
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$ad.picurl}" type="text" class="txt pic_upload" >
{if $ad.picurl}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div>
<a href="{$ad.picurl}" target="_blank" ><img src="{$ad.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" /></td>
          <td class="vtop tips2"></td>
        </tr>
        <tr class="noborder">
          <td class="td_l">链接地址:</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$ad.url}" type="text" class="txt"></td>
          <td class="vtop tips2">链接地址</td>
        </tr>
          
          


        
        <tr class="noborder">
          <td class="td_l">新窗口打开:</td>
          <td class="vtop rowform">


<ul>
            <li >
              <input class="radio" type="radio" name="postdb[target]" value="1" {if $ad.target==1}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[target]" value="0" {if $ad.target==0}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>
          
          
          </td>
          <td class="vtop tips2">选中则新窗口打开,否则本窗口打开,默认为新窗口打开</td>
        </tr>
     </tbody>
      <tbody class="show_ads {if $ad.type !=3}hide{/if}">
       <tr class="noborder">
        <td class="td_l">内容:</td>
        <td class="vtop" colspan="3"><div class="kg_editorContainer"  data-config='{
        "width":"1000","height":"400"
        }'>
        <textarea rows="6" name="postdb[html]" cols="70" class="ks-editor-textarea" id = "web_editor">{$ad.html}</textarea></div></td>
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