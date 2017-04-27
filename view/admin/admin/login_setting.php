{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">

  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="td_l">qq空间应用域名:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[qq_zone_url]" value="{$_G.setting.qq_zone_url}" /></td>
          <td class="vtop tips2">如果是做了QQ空间应用的话, 则需配置独立域名.没有则不用理会</td>
        </tr>
        <tr class="noborder">
          <td class="td_l">qq appid:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[qq_appid]" value="{$_G.setting.qq_appid}" /></td>
          <td class="vtop tips2">QQ登录必须要设置的,不填写则不开启QQ登录,开启前请确保你已在腾讯申请了QQ登录组件
           <p>授权回调页：{$_G.siteurl}就是你当前网址,不能带有参数

           </p>
          </td>
        </tr>

		 <tr class="noborder">
          <td class="td_l">qq appkey:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[qq_appkey]" value="{$_G.setting.qq_appkey}" /></td>
          <td class="vtop tips2">QQ登录必须要设置的 <a href="https://connect.qq.com" class="red" target="_blank">点击申请QQ登录组件</a></td>
        </tr>

         <tr class="noborder">
          <td class="td_l">新浪微博appkey:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[weibo_appkey]" value="{$_G.setting.weibo_appkey}" /></td>
          <td class="vtop tips2">新浪微博appkey,不填写则不开启微博登录,开启前请确保你已在新浪申请了新浪微博登录组件
          <p>授权回调页：{$_G.siteurl}index.php?m=member&a=weibo_login</p>
          </td>
        </tr>

         <tr class="noborder">
          <td class="td_l">新浪微博appsecret:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[weibo_appsecret]" value="{$_G.setting.weibo_appsecret}" /></td>
          <td class="vtop tips2">新浪微博appsecret
          <a href="http://open.weibo.com/" class="red" target="_blank">点击申请微博登录组件</a>
<p>取消授权回调页：{$_G.siteurl}index.php?m=member&a=login</p>
          </td>
        </tr>



        <tr class="noborder">
          <td class="td_l">淘宝appkey:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[taobao_appkey]" value="{$_G.setting.taobao_appkey}" /></td>
          <td class="vtop tips2">淘宝appkey,不填写则不开启淘宝登录,填写百川的appKey和secretKey即可.回调地址为{$_G.siteurl}
          <a href="http://help.uz-system.com/?id=177" target="_blank">查看配置方法</a>
          </td>
        </tr>

         <tr class="noborder">
          <td class="td_l">淘宝appsecret:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[taobao_appsecret]" value="{$_G.setting.taobao_appsecret}" /></td>
          <td class="vtop tips2">淘宝appsecret<a href="http://open.taobao.com/" class="red" target="_blank">点击申请淘宝登录组件</a></td>
        </tr>


       <tr class="noborder">
          <td class="td_l">微信appkey:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[weixin_appkey]" value="{$_G.setting.weixin_appkey}" /></td>
          <td class="vtop tips2">微信appkey,不填写则不开启,开启前请确保你已申请了网页登录接口</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">微信appsecret:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[weixin_appsecret]" value="{$_G.setting.weixin_appsecret}" /></td>
          <td class="vtop tips2">微信appsecret
          <a href="https://open.weixin.qq.com/" class="red" target="_blank">点击申请微信登录组件(注:微信登录需认证每年300元)</a></td>
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
