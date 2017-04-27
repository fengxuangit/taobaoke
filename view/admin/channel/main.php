{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data"  method="post" action="" >

<div class="table_top">共找到({$count})条栏目信息</div>
  <div class="table_main">

  <table class="tb tb2 nobdb" >
    <tbody>

      <tr class="hover" >
        <td class="td25">fid</td>
        <td class="td25">排序</td>
        <td class="td28">栏目名称</td>
        
         <td class="td28">栏目图片</td>
          <td class="td28">栏目图片链接</td>
          
        <td class="td28">上级栏目</td>
         <td class="td28">classname</td>
        <td class="td28">隐藏</td>
         <td class="td28">编辑/删除</td>
        <td class="td28">清空商品</td>
        
      </tr>
      </tbody>
    {foreach from=$_G.channels item=v}
     <tbody>
      <tr class="hover" >
        <td class="td25"><a href="{$URL}m=goods&a=main&fid={$v.fid}">{$v.fid}</a>&nbsp;
        <a href="/index.php?&fid={$v.fid}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif" ></a>
          <input type="hidden" name="fid[{$v.fid}]" value="{$v.fid}"></td>
        <td class="td25"><input type="text" name="sort[{$v.fid}]" value="{$v.sort}" class="w40"></td>
        <td class="td28">
          <input type="text" name="name[{$v.fid}]" value="{$v.name}">1级</td>
          
           <td class="td28 _hover_img"> <input type="text" name="picurl[{$v.fid}]" value="{$v.picurl}">
             <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}" /></a>
           </td>
         <td class="td28"> <input type="text" name="url[{$v.fid}]" value="{$v.org_url}"></td>
         

        <td class="td28">
        <select name="fup[{$v.fid}]" class="fup select_fid">
 <option value="0" {if $v.fid==0} selected="selected" class="on"  {/if}>----顶级栏目----</option>
<!--{foreach from=$_G.channels item=vv}-->
 <option value="{$vv.fid}" {if $v.fup==$vv.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
<!--{if $vv.sub}-->
      <!--{foreach from=$vv.sub item=vvv}-->
          <option value="{$vvv.fid}" {if $v.fid==$vvv.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
          <!--{if $vvv.sub ==3}-->
           <!--{foreach from=$vvv.sub item=a}-->
           <option value="{$a.fid}" {if $v.fid==$a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
          <!--{/foreach}-->
          <!--{/if}-->  
      <!--{/foreach}-->
<!--{/if}-->              
<!--{/foreach}-->
</select>

          </td>

           <td class="td28"> <input type="text" name="classname[{$v.fid}]" value="{$v.classname}"></td>


        <td class="td28"><input type="checkbox" name="hide[{$v.fid}]" value="{$v.fid}" {if $v.hide==1} checked{/if}></td>
        <td class="td28">
        <a href="{$URL}m=channel&a=post&fid={$v.fid}">编辑</a>&nbsp; 
        <a href="{$URL}m=channel&a=del&fid={$v.fid}">删除</a></td>
        <td class="td28"> <a href="{$URL}m=channel&a=clear&fid={$v.fid}">清空商品({$v.count})</a></td>
      </tr>
      </tbody>

<!--显示二级栏目-->
{if $v.sub}
   
        <!--{foreach from=$v.sub item=v1}-->
         <tbody>
        <tr class="hover" >
          <td class="td28"><a href="{$URL}m=goods&a=main&fid={$v1.fid}">{$v1.fid}</a>&nbsp;&nbsp;
           <a href="/index.php?&fid={$v1.fid}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif" ></a>
            <input type="hidden" name="fid[{$v1.fid}]" value="{$v1.fid}"></td>
          <td class="td25" >
          <div class="board">
          <input type="text" name="sort[{$v1.fid}]" value="{$v1.sort}"  class="w40">
          </div>
          </td>
          <td class="td28"><div class="board"> <input type="text" name="name[{$v1.fid}]" value="{$v1.name}">2级</div>
            </td>
            
         <td class="td28 _hover_img"> <input type="text" name="picurl[{$v1.fid}]" value="{$v1.picurl}">
           <a href="{$v1.picurl}" target="_blank"><img src="{$v1.picurl}" /></a>
         </td>
         <td class="td28"> <input type="text" name="url[{$v1.fid}]" value="{$v1.org_url}"></td>
            

          <td class="td28"><select name="fup[{$v1.fid}]" class="fup">
           <option value="0" {if $v1.fid==0} selected="selected" class="on"  {/if}>----顶级栏目----</option>
            <!--{foreach from=$_G.channels item=vv}-->
             <option value="{$vv.fid}" {if $v1.fup==$vv.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
                    <!--{if $vv.sub}-->
                          <!--{foreach from=$vv.sub item=vvv}-->
                              <option value="{$vvv.fid}" {if $v1.fup==$vvv.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
                              <!--{if $vvv.sub ==3}-->
                                   <!--{foreach from=$vvv.sub item=a}-->
                                   <option value="{$a.fid}" {if $v1.fup==$a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
                                  <!--{/foreach}-->
                             <!--{/if}-->            
                         <!--{/foreach}-->
       				 <!--{/if}--> 
       	 <!--{/foreach}-->          
            </select></td>

                  <td class="td28"> <input type="text" name="classname[{$v1.fid}]" value="{$v1.classname}"></td>

          <td><input type="checkbox" name="hide[{$v1.fid}]"  value="{$v1.fid}" {if $v1.hide==1} checked{/if}></td>
          <td><a href="{$URL}m=channel&a=post&fid={$v1.fid}">编辑</a>&nbsp; 
          <a href="{$URL}m=channel&a=del&fid={$v1.fid}"  class="_confirm" data-msg="您确定要删除当前栏目吗?删除后不可恢复">删除</a></td>
          <td> <a href="{$URL}m=channel&a=clear&fid={$v1.fid}" >清空商品({$v1.count})</a></td>
        </tr>
        
        
        
        

        
        
        
        
        
        
        
<!--显示三级栏目-->
{if $v1.sub}
    <tbody>
        <!--{foreach from=$v1.sub item=a1}-->
        <tr class="hover" >
          <td class="td28"><a href="{$URL}m=goods&a=main&fid={$a1.fid}">{$a1.fid}</a>&nbsp;&nbsp;
           <a href="/index.php?&fid={$va.fid}" target="_blank" title="前台查看"><img src="{$IMGDIR}/open.gif" ></a>
            <input type="hidden" name="fid[{$a1.fid}]" value="{$a1.fid}"></td>
          <td class="td25" >
          <div class="board"  style="margin-left: 30px;">
         	 <input type="text" name="sort[{$a1.fid}]" value="{$a1.sort}"  class="w40">
          </div>
          </td>
          <td class="td28"><div class="board" style="margin-left: 70px;"> <input type="text" name="name[{$a1.fid}]" value="{$a1.name}"><span class="red">3级</span></div>
            </td>
            
             <td class="td28 _hover_img"> <input type="text" name="picurl[{$a1.fid}]" value="{$a1.picurl}">
             <a href="{$a1.picurl}" target="_blank"><img src="{$a1.picurl}" /></a>
             </td>
         <td class="td28"> <input type="text" name="url[{$a1.fid}]" value="{$a1.org_url}"></td>

          <td class="td28"><select name="fup[{$a1.fid}]" class="fup">
           <option value="0" {if $a1.fid==0} selected="selected" class="on"  {/if}>----顶级栏目----</option>
            <!--{foreach from=$_G.channels item=vv}-->
             <option value="{$vv.fid}" {if $a1.fup==$vv.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;{$vv.name}</option>
                    <!--{if $vv.sub}-->
                          <!--{foreach from=$vv.sub item=vvv}-->
                              <option value="{$vvv.fid}" {if $a1.fup==$vvv.fid} selected="selected" class="on" {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$vvv.name}</option>
                              <!--{if $vvv.sub ==3}-->
                                   <!--{foreach from=$vvv.sub item=a}-->
                                   <option value="{$a.fid}" {if $a1.fup==$a.fid} selected="selected" class="on"  {/if}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$a.name}</option>
                                  <!--{/foreach}-->
                             <!--{/if}-->            
                         <!--{/foreach}-->
       				 <!--{/if}--> 
       	 <!--{/foreach}-->          
            </select></td>

                <td class="td28"> <input type="text" name="classname[{$a1.fid}]" value="{$a1.classname}"></td>
                
          <td><input type="checkbox" name="hide[{$a1.fid}]"  value="{$a1.fid}" {if $a1.hide==1} checked{/if}></td>
          <td><a href="{$URL}m=channel&a=post&fid={$a1.fid}">编辑</a>&nbsp; 
          <a href="{$URL}m=channel&a=del&fid={$a1.fid}" >删除</a></td>
          <td><a href="{$URL}m=channel&a=clear&fid={$a1.fid}" >清空商品({$a1.count})</a></td>
        </tr>
        <!--{/foreach}-->
    </tbody>
    
    
    
    
{/if}
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
         </tbody>
        <!--{/foreach}-->
   
    
    
    
    
{/if}

    {/foreach}
	 <tbody class="tb tb2 ">
      <tr>
      <td>&nbsp;</td>
        <td colspan="4"><div class="fixsel">
            <input type="submit" class="btn submit_btn"  name="onsubmit"  value="提交修改"></div></td>
      </tr>
    </tbody>
  </table>
  </div>
<input type="hidden" name="m" value="{$CURMODULE}" />
<input type="hidden" name="a" value="{$CURACTION}" />
</form>
{include file='../common_admin/right_bar.php'} 