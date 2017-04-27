{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post" >
  <div class="table_top">用户组信息</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">用户组名称:</td>
          <td class="vtop rowform">
          {if $group.system==1}
         <span class="red">{$group.name}</span>   
          {else}
          <input name="name" value="{$group.name}" type="text" class="txt"/>
          {/if}
          
          </td>
          <td class="vtop tips2">请输入网站名称</td>
        </tr>
        
        <tr class="noborder">
          <td class="td_l">是否可登录后台:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio login_admin1" type="radio" name="login_admin" value="1" {if $group.login_admin==1 ||  $group.id==1}checked="checked"{/if} {if $group.id==1} readonly{/if}/>
              &nbsp;是</li>
            <li>
              <input class="radio login_admin2" type="radio" name="login_admin" value="0" {if $group.login_admin==0 || $_GET.id ==10 }checked="checked"{/if}    />
              &nbsp;否</li>
          </ul>
          
          </td>
          <td class="vtop tips2">选中的话,当前用户组的成员可直接进入后台{if $_GET.id ==10 } <span class="red">安全起见,普通用户组无法设定进入后台</span> {/if}</td>
        </tr>
        


        <tr class="noborder" > 
        <td class="td_l">用户组图片:</td>
          <td class="vtop rowform _hover_img">

<div class="upload_img">
<input name="picurl" value="{$group.picurl}" type="text" class="txt pic_upload" >
{if $_G.setting.logo}
<a href=""  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div>
<a href="{$group.picurl}" target="_blank" ><img src="{$group.picurl}"  /></a>
<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          
          </td>
          <td class="vtop tips2" >用户组图片</td>
        </tr>
        
        
        
        
         {if $is_show == 1}
            <tr class="noborder">
              <td class="td_l">积分升级范围:</td>
              <td class="vtop rowform">
                <input name="jf_min" value="{$group.jf_min}" type="text" class="txt w90" {if $_GET.id == 10}  disabled  readonly style="background:#ddd" {/if}>
                &nbsp;&nbsp;-&nbsp;&nbsp;
                <input name="jf_max" value="{$group.jf_max}" type="text" class="txt w90"  {if $_GET.id == 10}  disabled readonly style="background:#ddd" {/if} >
                
              </td>
              <td class="vtop tips2">用户的积分达到此范围内,自动升级至当前用户组,如:0-100,100-500,5000-1000
              <p>普通用户组,无法设置范围,它系统默认用户组,初始注册,或积分降为0,都将回到当前用户组</p>
              </td>
            </tr>
         {/if}
        
         {if $_G.setting.fanli == 1}
            <tr class="noborder">
              <td class="td_l">返利比例:</td>
              <td class="vtop rowform">
                <input name="fanli" value="{$group.fanli}" type="text" class="txt" >&nbsp;%
                
              </td>
              <td class="vtop tips2">如开始了返利模式,用户升级至当前用户组后,返利比例将按此处设置,为0则不返利
              </td>
            </tr>
         {/if}
         
        
        
      </tbody>
    </table>
    <br>

     <div class="table_top">权限分配  <span class="red">(注)某模块有添加发布功能,则默认就有了删除功能</span></div>
     <br>

     <table class="tb tb2 ">
      <tbody>
        <tr class="hover">
          <th >一级模块</th>
          <th >分类模块</th>
        </tr>
         
        <!--{foreach from=$user_menu item=v key=k}-->
        {if !$v.type || $SYSTEM_TYPE >=$v.type}
        <tr class="hover model_item">
          <td><input type="checkbox"  name="model[{$k}]" value="1" class="red model" {if $v.select == 1}  checked{/if} />
            {$v.name}
            </td>
          <td style="height:auto"> 
          {foreach from=$v.nav item=vv key = kk}
                  {if !$vv.type || $SYSTEM_TYPE >=$vv.type}                  
                  <div class="cl z" style="min-width:105px">
                  <input type="checkbox"  {if $vv.select == 1}  checked{/if}   name="{$k}[{$vv.a}]" value="1" class="model_sub"  style="margin-left:20px;"  />{$vv.name} </div>
                  {/if}
            {/foreach} 
            
            </td>
        </tr>
        {/if}
        <!--{/foreach}-->
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