<div style="clear:both;"></div>

<!--底部menu-->
 <div style="width: 100%; height: 30px;border-bottom: 1px solid #eee"></div>
<!--底部-->
<div class="hpz_bottom">
    <a href="{$_G.siteurl}"><img src="{$IMGDIR}/logo2.png"></a>
    <ul>
        <li class="hpz_bottomli1"><h1>关于我们</h1></li>
        <li><a href="{$URL}m=article&id=1" target="_blank">公司简介</a></li>
        <li><a href="{$URL}m=article&id=2" target="_blank">联系我们</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>商务合作</h1></li>
        <li><a href="{$URL}m=apply&a=info" target="_blank">商家报名</a></li>
        <li><a href="{$URL}m=home&a=goods" target="_blank">报名查询</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>下次怎么来</h1></li>
        <li><a href="#" class="_addfavorite">Ctrl+D加入收藏</a></li>
        <li><a href="{$URL}a=desktop">下载桌面快捷方式</a></li>
        <li><a href="{$URL}mobile=yes">手机版</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>关注我们</h1></li>
        <li class="hpzfootobj"><i class="indexiocns index_icon9" style="background-position: -300px -121px;"></i><a href="#" >&nbsp;微淘</a></li>
        <li class="hpzfootobj"><i class="indexiocns index_icon10" style="background-position: -320px -121px;"></i><a href="#">&nbsp;微信</a></li>
        <li><i class="indexiocns index_icon11" style="background-position: -113px -121px;"></i><a href="#" target="_blank">&nbsp;微博</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>帮助中心</h1></li>
        <li><a href="{$URL}m=article&id=3" target="_blank">新手上路</a></li>
        <li><a href="{$URL}m=article&id=5" target="_blank">积分问题</a></li>
        <li><a href="{$URL}m=article&id=6" target="_blank">常见问题</a></li>
    </ul>


</div>


<div class="hpz_bottomtext">
    {$_G.setting.copyright}  {$_G.runtime}
    
</div>



<!--右边栏-->

<div class="rightnfixd">
    <span>
    <a href="#" class="rfixedico rightnfixda1"></a>
    <a class="rfixedico rightnfixda2"></a>
    <a href="javascript:;"  class="rfixedico rightnfixda3 _addfavorite"></a>
    </span>
    <i class="rfixedico rightnfixdspan1"><img src="{$IMGDIR}/wt.png"  /></i>
</div>

{if $_G.setting.left_bar ==1}
{if $CM=='index' || $CM=='channel'}
<!--悬浮框-->
<div class="menufixd" style="{if $CURMODULE == 'home'}display:none;{/if}">
    <h3 class="menufixedlog" style="display: block;"></h3>
    <span></span>
    <h1>商品分类</h1>	
        <ul class="fixedmenu1 cl">
 	  <li class="indexajaxlink" ><a href="{$_G.siteurl}" class="{if $_G.fid ==0}fixedselect{/if}">全部</a></li>
        {foreach from = $_G.channels item=v name= a}
         {if $v.hide ==0}
         <li><a href="{$URL}fid={$v.fid}" class="{if $_G.fid == $v.fid }fixedselect{/if}">{$v.name}</a></li>
         {/if}
         {/foreach}
         
        <li><a class="" href="{$URL}a=tomorrow">预告</a></li>
        <li ><a  href="{$URL}a=over">即将结束</a></li>
    </ul>
    <ul class="fixedmenu2_1 cl">
    
{foreach $_G.nav item=v}
{if $v.type =="3"}
<li><a href="{$v.url}" class="iconfont  {$v.classname}" {if $v.target=="1"} target="_blank"{/if}>{$v.name}</a></li>
{/if}
{/foreach}
       
         
    </ul>

</div>
{/if}	
{/if}
<div class="share_box_menu" style="display:none">
 <table cellpadding="0" cellspacing="0" class="fwin">
    <tbody>
      <tr>
        <td class="t_l"></td>
        <td class="t_c"></td>
        <td class="t_r"></td>
      </tr>
      <tr>
        <td class="m_l"></td>
        <td class="m_c fwin_content_sign"><h3 class="flb"><em>提示</em><span> <a title="关闭" class="fwin_window_close_sign flbc _hideMemu" target="_blank">关闭</a> </span></h3>
          <div class="content_box_0"><div class="_share" data-style="2" data-more="0" data-count="0" data-picurl="{$goods.picurl}" style="  padding: 20px 0 0 100px;"></div></div>
          
          </td>
        <td class="m_r"></td>
      </tr>
      <tr>
        <td class="b_l"></td>
        <td class="b_c"></td>
        <td class="b_r"></td>
      </tr>
    </tbody>
  </table>
</div>
<!--<div class="share_box hide">
<div class="_share" data-style="2" data-more="0" data-count="0"></div></div>
</div>-->

{include file="../common/footer.php"}