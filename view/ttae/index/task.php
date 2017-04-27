{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/duihuan.css" media="all" />

<div class="score_task">
    <h1>每日任务</h1>
    <ul>
        <li>
            <a style="cursor:default;" class="scoreicons tasklog scoreicoqd"></a>
            <div class="score_taskinfo">
                <h2>网站签到</h2>
                <span>
                 签到
                     {foreach from = $_G.setting.sign_jf item=v key =k name = a}                    
                     {if $smarty.foreach.a.index <9}
                   		 {$k}天{$v}分，
                     {/if}
                    {/foreach}
                    如果连续签到中断则从头开始。
                </span>
               
                {if !$sign.id}
				 <a id="sign_3_a" href="{$URL}m=ajax&a=sign" class="_ajax_dialog">立即参与</a>
                 <b>获得<i>1-10</i>积分</b>
                 {else}
				<a id="sign_3_b" style="background:#ccc;cursor: inherit;">今日已获得</a>
                 <b>获得<i>{$sign.jf}</i>积分</b>
                {/if}
				            </div>

        </li>
        <li>
            <a style="cursor:default;" class="scoreicons tasklog scoreicoshare"></a>
            <div class="score_taskinfo">
                <h2>分享宝贝</h2>
                <span>通过网站组件分享不同的商品，每分享一个链接可获得{$_G.setting.share_goods}积分。</span>
                <b>共获得<i>{$share.share_goods}</i>积分</b>
                <a target="_blank" href="{$_G.siteurl}">立即参与&gt;</a>
            </div>
        </li>

    </ul>
</div>



<div class="score_task" >
    <h1>新手任务</h1>
    <ul>
        <li style="display:none;">
            <a style="cursor:default;" class="scoreicons tasklog scoreicoinfo"></a>
            <div class="score_taskinfo">
                <h2>完善个人信息</h2>
                <span>进入个人中心完善全部内容</span>
                <b>获得<i>10</i>积分</b>
				                <a target="_blank" href="#">立即参与&gt;</a>

				 </div>

        </li>
        <li  style="display:none;">
            <a style="cursor:default;" class="scoreicons tasklog scoreicowx"></a>
            <div class="score_taskinfo">
                <h2>关注微信</h2>
                <span>首次关注{$_G.setting.title}微信，并将专属代码发给我们官方微信</span>
                <b>获得<i>10</i>积分</b>
				  
					<a class="score_taskbtn" href="#"> 立即参与&gt;</a>
				             </div>
            <div class="task_wxobj">
                <img src="{$IMGDIR}/task_img.jpg">
            </div>
        </li>
        <li>
            <a style="cursor:default;" class="scoreicons tasklog scoreicowb"></a>
            <div class="score_taskinfo">
                <h2>分享站点首页</h2>
                <span>分享站点首页到微博</span>
                <b>获得<i>{$share.share_web}</i>积分</b>				 
					<a href="{$URL}a=share&type=web" target="_blank"> 立即参与&gt;</a>
            </div>
        </li>
        <li  style="display:none;">
            <a style="cursor:default;" class="scoreicons tasklog scoreicomobil"></a>
            <div class="score_taskinfo">
                <h2>下载手机客户端</h2>
                <span>下载{$_G.setting.title}APP应用，并登录账号获得积分</span>
                <b>获得<i>20</i>积分</b>
              <a onmouseover="$('#id-gf_android').show();" onmouseout="$('#id-gf_android').hide();">立即参与&gt;</a>
                
            </div>
        </li>
    </ul>
</div>


<div id="id-gf_android" style="width: 990px; margin: 0px auto; position: relative; clear: both; display: none;">
	<div class="gf_android"><img src="{$IMGDIR}/gf_android.jpg"></div>
</div>

<div class="score_task">
    <h1>邀请任务</h1>
    <ul>
        <li>
            <a style="cursor:default;" class="scoreicons tasklog scoreicofriend"></a>
            <div class="score_taskinfo">
                <h2>邀请任务</h2>
                <span>通过专属的邀请代码发送给朋友并成功注册激活，每月最多可邀请20人。（同一IP仅限第一个注册的好友加积分）</span>
                <b>共获得<i>{$share.yaoqing}</i>积分</b>
                <a href="{$URL}a=yaoqing">立即参与&gt;</a>
            </div>

        </li>

    </ul>
</div>
{include file="../footer.php"}


