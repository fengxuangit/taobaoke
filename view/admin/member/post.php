{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" method="post"   action="">

  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
      <tr class="noborder">
          <td class="td_l">会员名称:</td>
          <td class="vtop rowform">

          <input value="{$member.username}" type="text" class="txt username"  name="postdb[username]" {if $_GET.uid} readonly="readonly"{/if} >


          </td>
          <td class="vtop tips2"><p>禁止修改,淘宝分配的唯一用户名.如果是手动添加的,请确保一次添加好,添加好后不能再修改.除非删除</p>
          <p>如果想获取一个当前正在浏览用户的用户名,请确保用户已登录再在网址后加上&getnick=1即可得到当前用户的用户名</p>
          </td>
        </tr>


        <tr class="noborder">
          <td class="td_l">Email:</td>
          <td class="vtop rowform"><input name="postdb[email]" value="{$member.email}" type="text" class="txt" autocomplete="off" >
          {if $member.email}<span class="red">{if $member.email_check == 1}已验证{else}未验证{/if}</span>{/if}
          </td>
          <td class="vtop tips2">可空</td>
        </tr>
         <tr class="noborder">
          <td class="td_l">登录密码:</td>
          <td class="vtop rowform"><input name="password" value="" type="password" class="txt" autocomplete="off" ></td>
          <td class="vtop tips2">U站的不用理,只适用于站外的,不修改请留空</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">账户余额:</td>
          <td class="vtop rowform">
          <input name="postdb[money]" value="{$member.money}" type="text" class="txt">
          <input type="hidden" name="org_money" value="{$member.money}">

          </td>
          <td class="vtop tips2">可用余额</td>
        </tr>


       <tr class="noborder">
          <td class="td_l">真实姓名:</td>
          <td class="vtop rowform"><input name="postdb[name]" value="{$member.name}" type="text" class="txt"></td>
          <td class="vtop tips2"></td>
        </tr>


        <tr class="noborder">
          <td class="td_l">旺旺名称:</td>
          <td class="vtop rowform"><input name="postdb[wangwang]" value="{$member.wangwang}" type="text" class="txt"></td>
          <td class="vtop tips2">可空</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">手机号码:</td>
          <td class="vtop rowform"><input name="postdb[phone]" value="{$member.phone}" type="text" class="txt">
          {if $member.phone}
            <span class="red">{if $member.phone_check == 1}已验证{else}未验证{/if}</span>
            {/if}
          </td>
          <td class="vtop tips2">手机</td>
        </tr>
<tr class="noborder">
          <td class="td_l">qq:</td>
          <td class="vtop rowform"><input name="postdb[qq]" value="{$member.qq}" type="text" class="txt"></td>
          <td class="vtop tips2">联系qq</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">所在地址:</td>
          <td class="vtop rowform"><input name="postdb[address]" value="{$member.address}" type="text" class="txt"></td>
          <td class="vtop tips2">同收货地址,如果有兑换奖品或其它的,可填写快递寄送的地址</td>
        </tr>
          <tr class="noborder">
          <td class="td_l">积分:</td>
          <td class="vtop rowform"><input name="postdb[jf]" value="{$member.jf}" type="text" class="txt"></td>
          <td class="vtop tips2">一般无须修改</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">最高积分:</td>
          <td class="vtop rowform"><input name="postdb[max_jf]" value="{$member.max_jf}" type="text" class="txt"></td>
          <td class="vtop tips2">历史最高积分</td>
        </tr>

       <tr class="noborder">
          <td class="td_l">支付宝账号:</td>
          <td class="vtop rowform"><input name="postdb[alipay]" value="{$member.alipay}" type="text" class="txt"></td>
          <td class="vtop tips2">一般无须修改</td>
        </tr>
         <tr class="noborder">
          <td class="td_l">支付宝姓名:</td>
          <td class="vtop rowform"><input name="postdb[alipay_name]" value="{$member.alipay_name}" type="text" class="txt"></td>
          <td class="vtop tips2">一般无须修改</td>
        </tr>

{if $_G.setting.fanli ==1 }
		<tr class="noborder">
          <td class="td_l">淘宝订单后4位:</td>
          <td class="vtop rowform"><input name="postdb[order_number]" value="{$member.order_number}" maxlength="4" type="text" class="txt"></td>
          <td class="vtop tips2">一般是用户自行填写</td>
        </tr>
{/if}

        <tr class="noborder">
          <td class="td_l">注册IP:</td>
          <td class="vtop rowform"><input name="postdb[regip]" value="{$member.regip}" readonly type="text" class="txt" style="background:#ddd;"></td>
          <td class="vtop tips2">禁止修改</td>
        </tr>
          <tr class="noborder">
          <td class="td_l">注册时间:</td>
          <td class="vtop rowform"><input name="postdb[regdate]" value="{$member.regdate}"   type="text" class="txt _dateline"  style="background:#ddd;"></td>
          <td class="vtop tips2">禁止修改</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">最后登录IP:</td>
          <td class="vtop rowform"><input name="postdb[login_ip]" value="{$member.login_ip}" readonly type="text" class="txt"  style="background:#ddd;"></td>
          <td class="vtop tips2">禁止修改</td>
        </tr>
         <tr class="noborder">
          <td class="td_l">最后登录时间:</td>
          <td class="vtop rowform"><input name="postdb[login_time]" value="{$member.login_time}"  readonly  type="text" class="txt _dateline"  style="background:#ddd;"></td>
          <td class="vtop tips2">禁止修改</td>
        </tr>
         <tr class="noborder hide">
          <td class="td_l">用户结束时间:</td>
          <td class="vtop rowform"><input type="text" name="postdb[end_time]" value="{$member.end_time}" class="txt _dateline" /></td>
          <td class="vtop tips2">超过此时间则无法登录</td>
        </tr>

		{if $member.t_uid>0}
          <tr class="noborder">
          <td class="td_l">推荐者:</td>
          <td class="vtop rowform">
          <input value="{$t.username}"  readonly type="text" class="txt"  style="background:#ddd;"></td>
          <td class="vtop tips2">禁止修改</td>
        </tr>
        {/if}
        {if $member.login_name}
         <tr class="noborder">
          <td class="td_l">登录类型:</td>
          <td class="vtop rowform red">
           <!--{foreach from=$login_type item=v key=k}-->
             {if $k == $member.login_name }
             {$v}
              {/if}
              <!--{/foreach}-->

          </td>
          <td class="vtop tips2">禁止修改</td>
        </tr>
        {/if}
        <tr class="noborder">
          <td class="td_l">个人简介:</td>
          <td class="vtop rowform"><textarea rows="6" name="postdb[content]" cols="70" class="tarea">{$member.content}</textarea></td>
          <td class="vtop tips2">可空</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;&nbsp;</td>
        </tr>


        <tr class="noborder">
          <td class="td_l">是否审核:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[check]" value="1" {if $member.check==1 || !$_GET.uid}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[check]" value="0" {if $member.check==0 && $_GET.uid}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>

          </td>
          <td class="vtop tips2">选中的话,前台则不显示</td>
        </tr>

        <tr class="noborder">
          <td class="td_l">是否商家:</td>
          <td class="vtop rowform">
			<ul>
            <li >
              <input class="radio" type="radio" name="postdb[seller]" value="1" {if $member.seller=='1' || !$_GET.uid}checked="checked"{/if}>
              &nbsp;是</li>
            <li>
              <input class="radio" type="radio" name="postdb[seller]" value="0" {if $member.seller=='0' && $_GET.uid}checked="checked"{/if}>
              &nbsp;否</li>
          </ul>

          </td>
          <td class="vtop tips2">选中的话,前台则不显示</td>
        </tr>


         <tr class="noborder">
          <td class="td_l">所属用户组:</td>
          <td class="vtop rowform">
          <select name="postdb[groupid]" class="select_fid check_text  {if $member.group.jf_min>0 ||  $member.group.jf_max>0  } check_select {/if} " data-msg="用户组不能为空" >
            <option value="">---请选择用户组---</option>
              <!--{foreach from=$_G.group item=vv}-->
              <option value="{$vv.id}" {if ($member.groupid==0 && $vv.id ==10)  ||  $member.groupid==$vv.id} selected="selected" class="on"  {/if}>{$vv.name}</option>
              <!--{/foreach}-->
            </select>
             {if $member.group.jf_min>0 ||  $member.group.jf_max>0  }
             <input type="checkbox" value="1"  name="postdb[auto_update]" class="check_select_input"  data-update="{$member.auto_update}" />取消根据用户组积分自动升级
             {/if}

            </td>
          <td class="vtop tips2">
           {if $member.group.jf_min>0 ||  $member.group.jf_max>0  } <span class="red">当前用户组设为根据积分自动升级,无法手动修改,如果修改请进入当用户组管理,修改积分升级范围 为 0,或强制取消自动升级 </span>{/if}
          </td>



        </tr>
<tr class="noborder" >
          <td class="td_l">个人头像:</td>
          <td class="vtop rowform _hover_img">

<div class="upload_img" data-name="postdb[picurl]">
<input name="postdb[picurl]" value="{if $member.org_picurl}{$member.org_picurl}{/if}" type="text" class="txt pic_upload" >
{if $member.org_picurl}
<a href="#"  class="ajax_del" >删除</a>&nbsp;&nbsp;
{/if}
</div>
<a href="{$member.org_picurl}" target="_blank" ><img src="{$member.org_picurl}"  /></a>

<input type="file" name="file" class="J_TCajaUploadImg upload_file_btn" data-url="/upload.php" />
          </td>
          <td class="vtop tips2" >当前会员的头像</td>
        </tr>

        <tr>
          <td>&nbsp;</td>
          <td colspan="2"><div class="fixsel">
              <!--{if $_GET.uid}-->
              <input type="hidden" name="uid" value="{$_GET.uid}" />
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
