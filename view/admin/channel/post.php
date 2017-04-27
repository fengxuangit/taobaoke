{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"  >

<!--{if $_GET.fid}--> 
<div class="table_top">
<a href="/index.php?m=channel&fid={$_GET.fid}" target="_blank">前台查看</a>&nbsp;&nbsp;
 <a href="{$URL}m=goods&a=post&fid={$_GET.fid}">发布商品</a> 
 </div>
<!--{/if}--> 
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>        
        <tr class="noborder" >
          <td class="td_l">栏目名称:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$channel.name}" type="text" class="txt"></td>
          <td class="vtop tips2" >必填</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">栏目图片:</td>
          <td class="vtop rowform _hover_img">
<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{$channel.picurl}" type="text" class="txt pic_upload" >
{if $channel.picurl}
<a href="/index.php?m=ajax&a=del_img&img_url={$channel.picurl}"  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div> 
<a href="{$channel.picurl}" target="_blank" ><img src="{$channel.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          
          </td>
          <td class="vtop tips2" >可给当前栏目设置独立的banner,如果无法上传,请手动粘贴图片地址</td>
        </tr>
        
        <tr class="noborder" >
          <td class="td_l">图片链接</td>
          <td class="vtop rowform"><input name="postdb[url]" value="{$channel.org_url}" type="text" class="txt"></td>
          <td class="vtop tips2" >如果填了栏目图片,可给它加个链接,如果没有图片,则无须添加</td>
        </tr>

         <tr class="noborder {if !$_G.setting.api} hide {/if}" >
          <td class="td_l red">绑定淘宝分类:</td>
          <td class="vtop rowform">

                <select name="postdb[fup_cid]"  class="select select_cates" style="width:180px;"  >
                <option value="">----不限----</option>
                 <!--{foreach from=$cates item=vv}-->
                <option value="{$vv.cid}"  {if $channel.cid==$vv.cid || $fup == $vv.cid } selected{/if} >{$vv.name}</option>
                <!--{/foreach}-->
                </select>
            
			<span class="select_cates_sub"  data-cid="{$channel.cid}"></span>
           
           
          
          </td>
          <td class="vtop tips2" >绑定分类,则当前栏目会自动展示当前分类下的商品,不绑定,则会根据栏目标题搜索相关商品</td>
        </tr>

        
        <tr class="noborder" >
          <td class="td_l">隐藏栏目:</td>
          <td class="vtop rowform"><ul>
              <li >
                <input class="radio" type="radio" name="postdb[hide]" value="1" {if $channel.hide==1} checked="checked"{/if} >
                &nbsp;是</li>
              <li>
                <input class="radio" type="radio" name="postdb[hide]" value="0" {if $channel.hide==0} checked="checked"{/if}>
                &nbsp;否</li>
            </ul></td>
          <td class="vtop tips2" >选择“不显示”将在前台导航和栏目列表页将栏目隐藏，但栏目内容仍将保留，且用户仍可通过直接提供带有 fid 的 URL 访问到此栏目</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">当前栏目class:</td>
          <td class="vtop rowform"><input name="postdb[classname]" value="{$channel.classname}" type="text" class="txt"></td>
          <td class="vtop tips2" >一般不用填写</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">栏目排序:</td>
          <td class="vtop rowform"><input name="postdb[sort]" value="{$channel.sort}" type="text" class="txt"></td>
          <td class="vtop tips2" >越小越靠前</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">上级栏目:</td>
          <td class="vtop rowform">
          
          <select name="postdb[fup]" class="select_fid">
           <option value="0" {if 0 == $channel.fup} selected="selected" class="on"  {/if}>----顶级栏目----</option>

<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $channel.fup>0 &&  $channel.fup == $vv.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $channel.fup>0 && $channel.fup == $vvv.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub==3}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if  $channel.fup>0 && $channel.fup == $a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
            </select>
            
            </td>
          <td class="vtop tips2" >本栏目的上级栏目或分类</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">栏目模板:</td>
          <td class="vtop rowform"><input name="postdb[channel_tpl]" value="{$channel.channel_tpl}" type="text" class="txt"></td>
          <td class="vtop tips2" >当前栏目使用的模板,如不填,默认使用channel.php(如要使用 当前模板目录下的/main.php,则只填main就行)</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">内容页模板:</td>
          <td class="vtop rowform"><input name="postdb[goods_tpl]" value="{$channel.goods_tpl}" type="text" class="txt"></td>
          <td class="vtop tips2" >当前栏目的内容页使用的模板,如不填,默认使用goods.php</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">栏目分页大小:</td>
          <td class="vtop rowform"><input name="postdb[page]" value="{$channel.page}" type="text" class="txt w90"></td>
          <td class="vtop tips2" >列表页分页大小,0或不填则默认为是全局设置中 商品默认显示条数</td>
        </tr>
        
        
        
         <tr class="noborder" >
          <td class="td_l">seo title:</td>
          <td class="vtop rowform">
          <input name="postdb[title]" value="{$channel.title}" type="text" class="txt">
          </td>
          <td class="vtop tips2" >seo的标题,便于搜索引擎收录</td>
        </tr>
        
         <tr class="noborder" >
          <td class="td_l">seo keywords:</td>
          <td class="vtop rowform">
          <input name="postdb[keywords]" value="{$channel.keywords}" type="text" class="txt _in_keywords">
          </td>
          <td class="vtop tips2" >seo的关键字,便于搜索引擎收录,多个用,分格开</td>
        </tr>
        <tr class="noborder" >
          <td class="td_l">seo description:</td>
          <td class="vtop rowform"><textarea rows="3"  name="postdb[description]"  cols="50" class="tarea">{$channel.description}</textarea></td>
          <td class="vtop tips2" >seo的描述,便于搜索引擎收录,120字内</td>
        </tr>
        
        
         <tr class="noborder" >
        	 <td class="td_l">栏目内容:</td>
           <td class="vtop rowform" colspan="3">
<div class="kg_editorContainer"  data-config='{
"width":"1000","height":"400"
        }'>
<textarea rows="6" name="postdb[content]" cols="70" class="ks-editor-textarea" id = "web_editor">{$channel.content}</textarea></div>
           </td>
        </tr>
        <tr class="noborder" >
        <td class="td_l">&nbsp;</td>
          <td colspan="2"><div class="fixsel">
          {if $_GET.fid}
                <input type="hidden" name="fid" value="{$_GET.fid}" />
           {/if}
              <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改"></div></td>
        </tr>
      </tbody>
    </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 