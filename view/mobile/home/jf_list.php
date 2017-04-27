{include file="../header.php"}

<div class="hpz_returntop"><span>我的积分</span></div>
<div class="mysinfobk cl">
    <span class="mysphotod">
        <img width="60" height="60" src="{$_G.member.picurl}">
    </span>
	    <ul>
        <li>{$_G.username}</li>
        <li>{$_G.member.jf}积分</li>
    </ul>
    <img class="" style="float: right" src="{$IMGDIR}/mysimg.png">
</div>


<div class="mystabd cl">
    <div class="mystab">
        <i class="sign"></i>
        <ul>
            <li><a href="{$URL}m=ajax&a=sign" class="_ajax_dialog external" ><h1>签到赚积分</h1></a></li>
            <li>今天有<span>792</span>人获得积分</li>
        </ul>
    </div>
{foreach from=$goods item=v key=k}
 <div class="mystab">
        <i class="{if $v.jf<1}dec{else}add{/if}"></i>
        <ul>
            <li>积分:{$v.jf} 累计:{$v.org_jf}   - <span class="_dgmdate" data-time="{$v.dateline}"></span></li>
            <li>{$v.desc}</li>
        </ul>
    </div>
{/foreach}
</div>

<div class="cl redpage">{$showpage}</div>
{include file="../footer.php"}