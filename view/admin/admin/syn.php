{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
  
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      
       
        <tr class="noborder">
          <td class="td_l">是否开启同步:</td>
          <td class="vtop rowform">
          <input class="radio" type="radio" name="postdb[syn_status]" value="1" {if $_G.setting.syn_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[syn_status]" value="0" {if $_G.setting.syn_status==0}checked="checked"{/if}>
            &nbsp;否
          </td>
          <td class="vtop tips2">选否的话则站点不会进行同步</td>
        </tr>
         <tr class="noborder">
          <td class="td_l">站点类型:</td>
          <td class="vtop rowform">
          <input class="radio web_type" type="radio" name="postdb[syn_web_type]" value="1" {if $_G.setting.syn_web_type==1}checked="checked"{/if}>
            &nbsp;主站
            <input class="radio web_type" type="radio" name="postdb[syn_web_type]" value="2" {if $_G.setting.syn_web_type==2}checked="checked"{/if}>
            &nbsp;子站
          </td>
          <td class="vtop tips2">标记当前站点为主站还是子站,只能从主站操作了数据才会更新到子站
          <p>如果你有N个站点,请保证只有一个是主站,其它的全是子站(注意:U站不能同步站外,站外可以同步U站,且U站可以同步其它U站)</p>
          </td>
        </tr>
        

        <tr class="noborder">
          <td class="td_l">可同步的方法</td>
          <td class="vtop rowform">
           <label for="insert">添加数据&nbsp;<input type="checkbox" name="syn[syn_insert]" class="checkbox" value="1" {if $_G.setting.syn_insert==1} checked="checked" {/if}/></label>&nbsp;
           <label for="update">修改数据&nbsp;<input type="checkbox" name="syn[syn_update]" class="checkbox" value="1" {if $_G.setting.syn_update==1} checked="checked" {/if}/></label>&nbsp;
           <label for="delete">删除数据&nbsp;<input type="checkbox" name="syn[syn_delete]" class="checkbox" value="1" {if $_G.setting.syn_delete==1} checked="checked" {/if}/></label>&nbsp;
          </td>
          <td class="vtop tips2">只有选中的则会进行同步,全不选则全都不同步</td>
        </tr>
			<tr class="noborder">
          <td class="td_l">可同步的数据</td>
          <td class="vtop rowform" colspan="2">
          {foreach from=$syn_table item=v key=k}
          <label for="{$v.key}">{$v.name}<input type="checkbox" name="syn_table[{$v.key}]" class="checkbox" value="1" {if $v.check==1} checked="checked" {/if}/></label>&nbsp;
          {/foreach}
           <p>选中的则会进行同步,全不选则默认全部同步</p>
          </td>
          
        </tr>
         </tbody>
         
        <tbody class="sub_domain" {if $_G.setting.syn_web_type!=1} style="display:none"{/if}>
         <tr class="noborder" >
          <td class="td_l">子站点域名列表</td>
          <td class="vtop rowform"><textarea rows="6" name="syn_domain" cols="70" class="tarea">{$_G.setting.syn_domain}</textarea></td>
          <td class="vtop tips2">如果当前站点是主站,则必须填写所有子站点域名.如果当前是子站点则可不用填写
          <p>格式一行一个,如:</p>
          <p>http://99999.uz.taobao.com</p>
          <p>http://aimeizhuang.uz.taobao.com</p>
          <p>http://maimai.uz.taobao.com</p>
          </td>
        </tr>

        </tbody>
         <tbody>
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