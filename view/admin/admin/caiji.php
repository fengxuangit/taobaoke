{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">

  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>


       <tr class="noborder">
          <td class="td_l">批量采集接口:</td>
          <td class="vtop rowform">
           <input class="radio api_type" type="radio" name="postdb[api_type]" value="0" {if $_G.setting.api_type==0}checked="checked"{/if}>
            &nbsp;淘宝客API

          <input class="radio api_type" type="radio" name="postdb[api_type]" value="1" {if $_G.setting.api_type==1}checked="checked"{/if}>
            &nbsp;百川API
            </td>
          <td class="vtop tips2"><span class="red">
		<p>百川采集的字段更多一些,但是申请麻烦一些,不过有多媒体图片上传,发短信等接口
        <span class="red">(<a href="http://help.uz-system.com/?id=104" target="_blank">点击查看获取方法</a>)</span>推荐</p>
        <p>淘宝客API几乎不用申请,有在阿里妈妈申请了网站,有PID即有API权限
         <span class="red">(<a href="http://help.uz-system.com/?id=106" target="_blank">点击查看获取方法</a>)</span></p>
         </span></td>
        </tr>

          <tr class="noborder">
          <td class="td_l">单品采集接口:</td>
          <td class="vtop rowform">
           <input class="radio _click_show" data-hide=".body_web" type="radio" name="postdb[goods_api_type]" value="0" {if $_G.setting.goods_api_type==0}checked="checked"{/if}>
            &nbsp;淘点金1.0
          <input class="radio _click_show" data-hide=".body_web"  type="radio" name="postdb[goods_api_type]" value="1" {if $_G.setting.goods_api_type==1}checked="checked"{/if}>
            &nbsp;淘宝API接口
            <input class="radio _click_show"  data-show=".body_web"  type="radio" name="postdb[goods_api_type]" value="2" {if $_G.setting.goods_api_type==2}checked="checked"{/if}>
            &nbsp;优淘官方接口

            </td>
          <td class="vtop tips2">
		<p> 因淘宝的API接口经常升级,防止不能采集,提供3种单品采集方式</p>
        <p>淘宝API接口:自动根据后台设置自行分配,</p>
        <p>推荐顺序为:官方->阿里妈妈->百川->淘宝客</p>
        <p>百川和官方接口可采集佣金,其它采集不了佣金</p>
       </td>
        </tr>
        </tbody>

        <tbody class="body_web" {if $_G.setting.goods_api_type!=2}style="display:none;"{/if}>
        <tr class="noborder">
          <td class="td_l red">官方接口 :</td>
          <td class="vtop rowform"><input name="postdb[caiji_web]" value="{$_G.setting.caiji_web}" type="text" class="txt"></td>
          <td class="vtop tips2 red">
          在遇到不能采集时可用优淘官方服务器采集(可采集佣金及销量,不对免费用户开放,如需使用请咨询在线客服)
          </td>
        </tr>
       </tbody>


        <tbody>
        <tr class="noborder">
          <td class="td_l">百川Appkey:</td>
          <td class="vtop rowform"><input name="postdb[appkey]" value="{$_G.setting.appkey}" type="text" class="txt baichuan_key"></td>
          <td class="vtop tips2">appkey,在采集商品时需要提供
            <span class="red">(<a href="http://help.uz-system.com/?id=104" target="_blank">点击查看获取方法</a>)</span>
          <p>如果是用百川接口,必须填写百川的appkey,图片上传到百川时需要百川的appkey <span class="red">(必须申请)</span></p>
          </td>
        </tr>
        <tr class="noborder">
          <td class="td_l">百川secretKey:</td>
          <td class="vtop rowform"><input name="postdb[secretKey]" value="{$_G.setting.secretKey}" type="text" class="txt"></td>
          <td class="vtop tips2">百川secretKey,同appkey相对应</td>
        </tr>
        </tr>

        <tr class="noborder">
          <td class="td_l">淘宝客Appkey:</td>
          <td class="vtop rowform"><input name="postdb[taoke_appkey]" value="{$_G.setting.taoke_appkey}" type="text" class="txt taobao_key"></td>
          <td class="vtop tips2">
          appkey,在采集商品时需要提供
          <span class="red">(<a href="http://help.uz-system.com/?id=106" target="_blank">点击查看获取方法</a>)</span></p>
          <p>如果是淘客API,则需要填写淘宝客的appkey</p>
          </td>
        </tr>
        <tr class="noborder">
          <td class="td_l">淘宝客secretKey:</td>
          <td class="vtop rowform"><input name="postdb[taoke_secretKey]" value="{$_G.setting.taoke_secretKey}" type="text" class="txt"></td>
          <td class="vtop tips2">淘宝客secretKey,同appkey相对应</td>
        </tr>
        </tr>






 		<tr class="noborder">
          <td class="td_l">安全同步key:</td>
          <td class="vtop rowform"><input name="postdb[syn_key]" value="{$_G.setting.syn_key}" type="text" class="txt syn_key">&nbsp;<a href="#" class="srandom">生成</a></td>
          <td class="vtop tips2">使用采集插件,或是站点同步时进行验证的KEY,请不要随意池漏安全key,否则会有很大风险,留空不填则禁止采集和同步

          </td>
        </tr>




        <tr class="noborder">
          <td class="td_l">是否采集商品详情:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[get_message]" value="1" {if $_G.setting.get_message==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[get_message]" value="0" {if $_G.setting.get_message==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2"><span class="red">一般不是必要请不要选择,详情非常占数据库空间</span></td>
        </tr>


          <tr class="noborder">
          <td class="td_l">非蛛蜘是否自动跳转爱淘宝:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[robot_jump]" value="1" {if $_G.setting.robot_jump==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[robot_jump]" value="0" {if $_G.setting.robot_jump==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">非蛛蜘是否自动跳转爱淘宝</td>
        </tr>

 <tr class="noborder">
          <td class="td_l">商品链接形式:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[tdj_type]" value="1" {if $_G.setting.tdj_type==1}checked="checked"{/if}>
            &nbsp;淘点金1.0
            <input class="radio" type="radio" name="postdb[tdj_type]" value="2" {if $_G.setting.tdj_type==2}checked="checked"{/if}>
            &nbsp;淘点金2.0 </td>
          <td class="vtop tips2">
          <p>淘点金1.0,不限制域名,只是淘点金网址和pid就可使用</p>
          <p>淘点金2.0,就要求淘点金网址和当前域名匹配,不然会没佣金直接跳到淘宝详情页了</p>
          </td>
        </tr>

      <tr class="noborder" >
          <td class="td_l">淘点金网址:</td>
          <td class="vtop rowform">
          <input name="postdb[taodianjing_url]" value="{if $_G.setting.taodianjing_url}{$_G.setting.taodianjing_url}{/if}" type="text" class="txt"></td>
          <td class="vtop tips2">在阿里妈妈申请淘点金时验证成功网址,只有这个pid和此网址才能正常使用淘点金!</td>
        </tr>
         <tr class="noborder" >
          <td class="td_l">淘点金pid:</td>
          <td class="vtop rowform"><input name="postdb[pid]" value="{if $_G.setting.pid && $_G.setting.pid !='mm_13204895_7438858_25680126'}{$_G.setting.pid}{/if}" type="text" class="txt"></td>
          <td class="vtop tips2">来自阿里妈妈推广位生成的.格式为:mm_000000000_11111111_2222222
          </td>
        </tr>




        <tr class="noborder hide">
          <td class="td_l">自动更需要更新的字段:</td>
          <td class="vtop rowform">
          <input type="hidden" name="postdb[field]" value="" />
          {foreach from=$field item=v key=k}
          <label for="{$v.key}">{$v.name}<input type="checkbox" name="field[{$v.key}]" class="checkbox" value="1" {if $v.check==1} checked="checked" {/if}/></label>&nbsp;
          {/foreach}
           </td>
          <td class="vtop tips2">
          <p>全不选则默认全部都检查和更新,不选中则不更新</p>
          <p>因为系统会自动检查商品上下架或卖出数量等信息然后同部更新站内的数据</p>
          </td>
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
