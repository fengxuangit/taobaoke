{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">


  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>


    <tr class="noborder">
          <td class="td_l" colspan="3">
            <p>在线客服可让用户或访问者,能直接通过网页或APP与站长或站内的客服即时咨询,使用前请确定申请了百川接口,并开通了 <span class="red">百川即时通讯权限</span></p>
            <p>详情教程请查看帮助中心: <a href="http://help.uz-system.com/?id=179" target="_blank" class="red">http://help.uz-system.com/?id=179</a></p>
            <p> 打开咨询页面:<a href="{$_G.siteurl}/?m=im" target="_blank" class="red">{$_G.siteurl}/?m=im</a></p>
          </td>
        </tr>



    <tr class="noborder">
          <td class="td_l">开启在线客服:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[ww_status]" value="1" {if $_G.setting.ww_status==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[ww_status]" value="0" {if $_G.setting.ww_status==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启在线咨询客服</td>
        </tr>



   <tr class="noborder">
          <td class="td_l">在线客服账号:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[ww_name]" value="{$_G.setting.ww_name}" /></td>
          <td class="vtop tips2">在线客服聊天的账号名称,需在百川控制台开通IM权限
          <a class="red" href="http://baichuan.taobao.com/docs/doc.htm?spm=a3c0d.7629140.0.0.iajWHR&treeId=41&articleId=103363&docType=1" target="_blank">详细教程请点击</a></td>
        </tr>
                 <tr class="noborder">
          <td class="td_l">在线客服密钥:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[ww_synkey]" value="{$_G.setting.ww_synkey}" /></td>
          <td class="vtop tips2">随便设置数字和字母,必须和百川中设置的一致,不然会在千牛插边栏栏中验证失败,获取不到用户信息</td>
        </tr>
        
  <tr class="noborder">
          <td class="td_l">在线客服分组ID:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[ww_group_id]" value="{$_G.setting.ww_group_id}" /></td>
          <td class="vtop tips2">在线客服分类ID,没有可以不填</td>
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
