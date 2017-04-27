{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/yaoqing.css" media="all" />



<div class="score_inventbk">
        <div class="score_inventd">
          <span class="score_inventban"></span>
          <div class="score_inventmorejf">
               <h1>积分可用于</h1>
               <ul>
                   <li style="display:none;">
                       <a href="#" class="scoreicons inventico inventico1"></a>
                       <div class="inventmored">
                           <span>积分夺宝</span>
                           <i></i>
                           <a href="#" class="inventbtn">立即参与&gt;</a>
                       </div>
                   </li>
                   <li>
                       <a href="{$URL}m=duihuan&a=goods_list#exchange" class="scoreicons inventico inventico2"></a>
                       <div class="inventmored">
                           <span>积分兑换</span>
                           <i></i>
                           <a href="{$URL}m=duihuan&a=goods_list#exchange" class="inventbtn" target="_blank">立即参与&gt;</a>
                       </div>
                   </li>
               </ul>
          </div>

          <div class="scoreinventnav">
              
               {if !$_G.uid}
               	 <h2>
                   <span>马上邀请&nbsp;赚积分</span><b>登录后，邀请才能获得积分哦，<a href="{$URL}m=member&a=login" target="_blank" style="color: #e32014">立即登录</a></b>
               	 </h2>
               {/if}
              
              <h2>
                  <span style="font-size: 16px">邀请链接</span><b style="margin-top: 15px;">复制下面的专属链接，通过QQ，旺旺，微博，论坛发帖等方式发给好友，对方通过该链接注册激活即可。</b>
              </h2>

              <div class="score_inventform">
                 <div style="width: 580px; height: 120px;float: left">
					<p><input type="text" id="inventurl" value="{$_G.siteurl}?u={$_G.uid}">  
                    <a class="invent_btnfz">复制</a></p>
                    <p style="clear:both;"></p>
                    <b class="inventspan">一键邀请</b>
                    <div class="index_fxshared">
 {foreach from =$share item=v key=k name =a}
{if $smarty.foreach.a.index>2}
<a class="index_fxsharea index_fxsharea{$smarty.foreach.a.index+2}" target="_blank" href="{$v}"></a>
{else}
<a class="index_fxsharea index_fxsharea{$smarty.foreach.a.index+1}" target="_blank" href="{$v}"></a>
{/if}
 {/foreach}

                        
                        
                    </div>
                 </div>
                 <span class="inventimgbk">


                 </span>


              </div>

              <h2>
                  <span>奖励规则</span>
              </h2>
              <ul class="invent_ul">
                  <li>1.邀请您的好友加入{$_G.setting.title}，好友通过您的的专属邀请链接<a style="cursor:text;">成功注册并激活账户</a>，您将获得10个积分。</li>
                  <li>2.<a style="cursor:text;">切勿更改以上您专属的邀请链接</a>，一旦更改可能导致积分不能奖励到您的账号。</li>
                  <li>3.注意事项：禁止通过各种作弊手段进行虚假邀请注册好友获得积分，一旦反作弊系统检测到有作弊行为，我们将取消您的积分，情节严重者，我们直接对账号进行封号处理。</li>
                  <li>4.{$_G.setting.title}拥有最终活动解释权。</li>
              </ul>

          </div>
          <span class="score_inventbtm"></span>
        </div>
   </div>

<script type="text/javascript" src="{$JSDIR}/jquery.zclip.js"></script>
<script type="text/javascript">
$('.invent_btnfz').zclip({
	path:'assets/global/images/copy.swf',
	copy:$('#inventurl')[0].value,
	afterCopy: function(){
		alert('已复制');
		//Dialog.show('已复制', true);
	}
});
</script>


{include file="../footer.php"}


