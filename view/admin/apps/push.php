{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">
    <div class="table_top">其它设置</div>
  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>
       {if $_G.setting.app_push == "xg"}
            <tr class="noborder" >
              <td class="td_l">推送类型:</td>
              <td class="vtop rowform">
               <input class="radio"  type="radio" name="postdb[type]" value="2" checked>
                &nbsp;通知
                 </td>
              <td class="vtop tips2">
              <p>消息不会直接显示在状态栏上.是后台操作的.用户不可见</p>
              <p>通知是直接显示在手机状态栏上.用户是可见的</p>
              </td>
            </tr>
             <tr class="noborder" >
                  <td class="td_l">推送终端:</td>
                  <td class="vtop rowform">
                    <input type="radio" name="phone" class="radio" value="1" > &nbsp;android
                    <input type="radio" name="phone" class="radio" value="2" > &nbsp;ios
                     </td>
                  <td class="vtop tips2">选择接收的手机类型
                  </td>
                </tr>


      {elseif $_G.setting.app_push == "jpush"}
        <tr class="noborder" >
              <td class="td_l">推送类型:</td>
              <td class="vtop rowform">
               <input class="radio"  type="radio" name="postdb[type]" value="0" checked>
                &nbsp;通知
                 </td>
              <td class="vtop tips2">
              <p>消息不会直接显示在状态栏上.是后台操作的.用户不可见</p>
              <p>通知是直接显示在手机状态栏上.用户是可见的</p>
              </td>
            </tr>
             <tr class="noborder" >
                  <td class="td_l">推送终端:</td>
                  <td class="vtop rowform">


            <input type="checkbox" name="phone[android]" class="checkbox" value="1" > &nbsp;android
            <input type="checkbox" name="phone[ios]" class="checkbox" value="1" > &nbsp;ios
                     </td>
                  <td class="vtop tips2">选择接收的手机类型
                  </td>
                </tr>
        {else}
               <tr class="noborder" >
                  <td class="td_l">推送类型:</td>
                  <td class="vtop rowform">

                  <input class="radio _click_show" data-show=".xiaoxi" type="radio" name="postdb[type]" value="1" >
                    &nbsp;消息
                     <input class="radio _click_show"  data-hide=".xiaoxi" type="radio" name="postdb[type]" value="2">
                    &nbsp;通知

                     </td>
                  <td class="vtop tips2">
                  <p>消息不会直接显示在状态栏上.是后台操作的.用户不可见</p>
                  <p>通知是直接显示在手机状态栏上.用户是可见的</p>
                  </td>
                </tr>
                 <tr class="noborder" >
          <td class="td_l">推送终端:</td>
          <td class="vtop rowform">

            <input type="checkbox" name="phone[android]" class="checkbox" value="1" > &nbsp;android
            <input type="checkbox" name="phone[ios]" class="checkbox" value="1" > &nbsp;ios

             </td>
          <td class="vtop tips2">选择接收的手机类型
          </td>
        </tr>
      {/if}



          <tr class="noborder">
          <td class="td_l">推送标题:</td>
          <td class="vtop rowform"><input name="postdb[title]" value="" type="text" class="txt" ></td>
          <td class="vtop tips2">推送的标题20字以内</td>
        </tr>

         <tr class="noborder">
          <td class="td_l">推送内容:</td>
          <td class="vtop rowform"> <input name="postdb[content]" value="" type="text" class="txt" >
          </td>
          <td class="vtop tips2">120字以内</td>
        </tr>

      </tbody>

     <tbody class="{if $_G.setting.app_push != "xg" &&  $_G.setting.app_push != "jpush"} hide{/if} xiaoxi">

        <tr class="noborder">
          <td class="td_l">消息类型:</td>
          <td class="vtop rowform">
          <select name="type"  class="select type_select">
          			<option value="-1" data-text="一般留空">不附加字段</option>
                  <option value="0" data-text="一般留空">进入APP首页</option>
                  <option value="2" data-text="填写详细网址" data-default"http://">打开网址</option>
                  <option value="6" data-text="一般留空">强制用户退出</option>
                  <option value="4" data-text="一般留空,可以加URL参数">打开商品列表页</option>
                  <option value="1" data-text="填写淘宝商品num_iid" >打开商品的详情页</option>
                  <option value="5" data-text="一般留空,可以加URL参数">打开搭配列表</option>
                  <option value="3" data-text="填写搭配的id" >打开搭配详情页</option>
                  <option value="7" data-text="一般留空,可以加URL参数">打开值得买列表</option>
                  <option value="8" data-text="填写值得买的id">打开值得买详情</option>

          </select>

          </td>
          <td class="vtop tips2"></td>
        </tr>
         <tr class="noborder">
          <td class="td_l">推送字段值:</td>
          <td class="vtop rowform" colspan="2"><input name="data" value="" type="text" class="txt push_text" ><span style="margin-left:10px;" class="tui_text"></span></td>

        </tr>
         </tbody>


    <tbody>
    <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
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
