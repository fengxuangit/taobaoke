{include file='../common_admin/left_bar.php'}
<form enctype="multipart/form-data" name="channel_add" method="post">


  <div class="table_main">
    <table class="tb tb2 nobdb">
      <tbody>

          <tr class="noborder ">
          <td class="td_l">图片上传地址:</td>
          <td class="vtop rowform">

           <select name="postdb[upload_url]" class="select select_upload" style="width:190px">
                  <option value="web" {if $_G.setting.upload_url =='web'} selected{/if}>本地</option>
                <!--  <option value="uz" {if $_G.setting.upload_url =='uz'} selected{/if}>优站本地</option>
                  <option value="uz_http" {if $_G.setting.upload_url =='uz_http'} selected{/if}>优站远程</option>
                  <option value="bc" {if $_G.setting.upload_url =='bc'} selected{/if}>百川本地</option>-->
                  <option value="baichuan" {if $_G.setting.upload_url =='baichuan'} selected{/if}>百川api</option>
          </select>
          <span class="baichuan_name {if $_G.setting.upload_url !='baichuan'}hide{/if}">
       <input class="txt w90" type="text" name="postdb[baichuan_name]" value="{$_G.setting.baichuan_name}" />
      &nbsp;&nbsp;百川图片空间名称
        </span>

          </td>
          <td class="vtop tips2">
          <p>本地:当前网站所有的服务器上(如果是百川环境,必须选百川,不然本地文件会失效)</p>
<!--          <p>  优站本地,如果当前程序在优站上必须选择. 优站远程,如果空间是在外站,可以选择</p>
          <p>百川本地,当前空间是在拖管在百川上可以直接使用</p>-->
          <p>百川api,空间是在外站或百川都可使用,必须有百川的appkey
          <a href="http://help.uz-system.com/?id=109" target="_blank" class="red"> 创建方法</a>
          <span class="red">建议百川api方式</span></p>
          </td>
        </tr>



         <tr class="noborder hide">
          <td class="td_l">主表:</td>
          <td class="vtop rowform">
          <select name="postdb[main_table]" class="select">
              <option value="" {if $_G.setting.main_table ==''} selected{/if}>无</option>
              <option value="goods" {if $_G.setting.main_table =='goods'} selected{/if}>商品</option>
              <option value="article" {if $_G.setting.main_table =='article'} selected{/if}>文章</option>
              <option value="news" {if $_G.setting.main_table =='news'} selected{/if}>信息</option>
          </select>
           </td>
          <td class="vtop tips2">
          	设置错误,将导至数据库出错,一般不用选择
          </td>
        </tr>

		 <tr class="noborder">
          <td class="td_l">多说站点域名:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[duoshuo]" value="{$_G.setting.duoshuo}" /></td>
          <td class="vtop tips2">评论时会调用,如果不填则不会显示多说的评论框,申请地址 <a href="http://duoshuo.com/" class="red" target="_blank">http://duoshuo.com/</a>
          <p>申请好后,在多说后台工具->通用代码中找到 short_name:"这里面就是多说域名" 这段代码,将引号中的内容填上即可</p>
          </td>
        </tr>



   <tr class="noborder">
          <td class="td_l">cnzz统计id:</td>
          <td class="vtop rowform"><input name="postdb[cnzz_id]" value="{$_G.setting.cnzz_id}" type="text" class="txt"></td>
          <td class="vtop tips2">可统计全站的点击数如(导航,广告,商品详情) 
          <a href="http://help.uz-system.com/?id=180" class="red" target="_blank">详情请点击查看</a></td>
        </tr>


	 <tr class="noborder">
          <td class="td_l">前台数据缓存时间:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[cache_time]" value="{$_G.setting.cache_time}" />&nbsp;分钟</td>
          <td class="vtop tips2">前台数据调用缓存时间,单位,分钟,填0则禁止缓存,只有在环境中有memcache或是ocs缓存时才有用,强烈建议开启,大大提升网站效率</td>
        </tr>



        <tr class="noborder">
          <td class="td_l">系统当前模板:</td>
          <td class="vtop rowform"><input class="txt" type="text" name="postdb[template]" value="{$_G.setting.template}" /></td>
          <td class="vtop tips2">请不要随便修改.不填或空默认为main,修改前请确定你已开发好了模板</td>
        </tr>





    <tr class="noborder">
          <td class="td_l">开启前台侧边栏:</td>
          <td class="vtop rowform"><input class="radio" type="radio" name="postdb[left_bar]" value="1" {if $_G.setting.left_bar==1}checked="checked"{/if}>
            &nbsp;是
            <input class="radio" type="radio" name="postdb[left_bar]" value="0" {if $_G.setting.left_bar==0}checked="checked"{/if}>
            &nbsp;否 </td>
          <td class="vtop tips2">是否开启前台侧边栏</td>
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
