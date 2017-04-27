{include file='../header.php'}

{$CSS}
<div class="score_body">
  <div class="score_head">
    <div class="score_head_user">
      <div class="score_user_top">
        <div class="score_user_icon"> {if $_G.uid} <img src="{$_G.member.picurl}" width="80" height="80">
          <div class="score_user_topTxt">
            <p class="firstList">您好，<a class="buy" href="{$URL}m=home">{$_G.username}</a></p>
            <p>可用积分:<em>{$_G.member.jf}</em></p>
            <p style="margin-top:5px;">完善资料可获得10积分</p>
            <p></p>
          </div>
          {else} <img src="{$IMGDIR}/userpic.png" width="80" height="80">
          <div class="score_user_topTxt">
            <p class="firstList">您好，请<a target="_blank" href="{$URL}m=member&a=login">登录</a></p>
            <p>可用积分:<em>0</em></p>
          </div>
          {/if} </div>
        <div class="score_user_but"> {if !$sign.id} <a  href="{$URL}m=ajax&a=sign" class="_ajax_dialog login">立即参与</a>
          <p>您今天还没有签到</p>
          {else} <a  style="background:#ccc;cursor: inherit;">已签到</a>
          <p>获得<em>{$sign.jf}</em>积分</p>
          {/if} </div>
      </div>
      <div class="score_user_bottom"> <a href="{$URL}a=task">赚取积分</a><i>|</i> <a href="#exchange">积分兑换</a> </div>
    </div>
    <div class="score_head_banner">
      <ul class="scoreindexul1" style="margin-left: 0px;">
        {foreach from=$_G.pics.k30 item = v}
        
        {if $v.hide==0}
        <li class="show_li"><a href="{$v.url}"><img src="{$v.picurl}"  width="830" height="240" /></a></li>
        {/if}
        
        {/foreach}
      </ul>
      <ul class="indexiocns scoreindexul2">
        {foreach from=$_G.pics.k30 item =v name=gd}
        
        {if $v.hide==0}
        <li class="bar_li" data-index="{$smarty.foreach.gd.index}"></li>
        {/if}
        
        {/foreach}
      </ul>
    </div>
  </div>
  <div class="score_state">
    <div class="score_state_left">
      <h3>积分夺宝</h3>
      <p><img src="http://img04.taobaocdn.com/imgextra/i4/1644048454/T2Ba5nXJVaXXXXXXXX-1644048454.jpg" width="233" height="298"></p>
    </div>
    <div class="score_state_right">
      <h3>
        <p><a target="_blank" href="{$URL}a=task">赚更多积分&gt;</a></p>
        做任务赚积分</h3>
      <ul class="score_state_rightUl">
        <li class="border">
          <div class="score_rightUl_list">
            <div class="icon"><img src="{$IMGDIR}/score_11.jpg" width="90" height="90"></div>
            <div class="score_rightUl_list_r">
              <h4>网站签到</h4>
              <p class="score_rightUl_r_txt"> 签到
                
                {foreach from = $_G.setting.sign_jf item=v key =k name = a}                    
                
                {if $smarty.foreach.a.index <9}
                
                {$k}天{$v}分，
                
                {/if}
                
                {/foreach}
                
                如果连续签到中断则从头开始。</p>
              <span> {if !$sign.id} <a id="sign_3_a" href="{$URL}m=ajax&a=sign" class="_ajax_dialog">立即参与</a>
              <p>获得<em>1-10</em>积分</p>
              {else} <a id="sign_3_b" style="background:#ccc;cursor: inherit;">已签到</a>
              <p>今日已获得<em>{$sign.jf}</em>积分</p>
              {/if} </span> </div>
          </div>
        </li>
        <li class="border">
          <div class="score_rightUl_list">
            <div class="icon"><img src="{$IMGDIR}/score_13.jpg" width="90" height="90"></div>
            <div class="score_rightUl_list_r">
              <h4>分享宝贝</h4>
              <p class="score_rightUl_r_txt">通过网站组件分享不同的商品，每分享一个链接可获得{$_G.setting.share_goods}积分。每日最多10个</p>
              <span> <a  href="{$URL}a=all" target="_blank">立即参与&gt;</a>
              <p>共获得<em>{$_G.setting.share_goods}</em>积分</p>
              </span> </div>
          </div>
        </li>
        <li>
          <div class="score_rightUl_list">
            <div class="icon"><img src="{$IMGDIR}/score_18.jpg" width="90" height="90"></div>
            <div class="score_rightUl_list_r">
              <h4>分享站点首页</h4>
              <p class="score_rightUl_r_txt">分享站点首页到微博</p>
              <span> <a id="vb_b" style="background:#ccc;cursor:inherit;display:none;">已完成</a> <a href="{$URL}a=share&type=web"  target="_blank" >立即参与&gt;</a>
              <p>获得<em>{$_G.setting.share_web}</em>积分</p>
              </span> </div>
          </div>
        </li>
        <li>
          <div class="score_rightUl_list">
            <div class="icon"><img src="{$IMGDIR}/score_19.jpg" width="90" height="90"></div>
            <div class="score_rightUl_list_r">
              <h4>邀请任务</h4>
              <p class="score_rightUl_r_txt">通过专属的邀请代码发送给朋友并成功注册激活，每月最多可邀请20人。（同一IP仅限第一个注册的好友加积分）</p>
              <span> <a target="_blank" href="{$URL}a=yaoqing">立即参与&gt;</a>
              <p>共获得<em>{$_G.setting.yaoqing}</em>积分</p>
              </span> </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <a name="exchange"></a>
  <div class="score_producte">
    <div class="score_producte_title">
      <h3>积分兑换</h3>
      <ul class="score_producte_title_ul">
        <li class="on" data-index="0">全部</li>
        {foreach from= $tags item= v key=k}
        <li  data-index="{$k+1}"><a>{$v.name}</a></li>
        {/foreach}
      </ul>
    </div>
    <div class="score_producte_list" data-2="" data-1="" style="display: block;">
      <ul class="score_producte_listUl">
        {foreach from= $tags item= s key=key}
        
        {foreach from= $s.goods item=v}
        <li>
          <div class="score_listUl_img"> <a href="{$v.id_url}" target="_blank"><img src="{$v.picurl}_250x250.jpg" width="250" height="250"></a>
            <p><a href="{$v.id_url}" target="_blank">{$v.title}</a></p>
            <div class="score_listUl_but"> <a href="{$v.id_url}" target="_blank">立即兑换</a>
              <p><em>￥{$v.price}</em>剩余{$v.sum - $v.num}件</p>
              <p><i class="colorRed">{$v.jf}</i>积分</p>
            </div>
          </div>
        </li>
        {/foreach}  
        
        {/foreach}
      </ul>
    </div>
    {foreach from= $tags item= s key=key}
    <div class="score_producte_list" data-2="" data-1="{$key+1}" style="display: none;">
      <ul class="score_producte_listUl">
        {foreach from= $s.goods item=v}
        <li>
          <div class="score_listUl_img"> <a href="{$v.id_url}" target="_blank"><img src="{$v.picurl}_250x250.jpg" width="250" height="250"></a>
            <p><a href="{$v.id_url}" target="_blank">{$v.title}</a></p>
            <div class="score_listUl_but"> <a href="{$v.id_url}" target="_blank">立即兑换</a>
              <p><em>￥{$v.price}</em>剩余{$v.sum - $v.num}件</p>
              <p><i class="colorRed">{$v.jf}</i>积分</p>
            </div>
          </div>
        </li>
        {/foreach}
      </ul>
    </div>
    {/foreach} </div>
</div>
{include file='../footer.php'}

