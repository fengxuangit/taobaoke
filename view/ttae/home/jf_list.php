{include file="./home_header.php"}
<div class="uc_scored1"> <span style="float: left">&nbsp;我的账户可用积分：<i style="color: #e32014;">{$_G.member.jf}</i></span> <span style="float: right; font-size: 12px;"></span> </div>
<div class="uc_scoremenu">
  <ul>
    <li class="{if !$_GET.type}select{/if}"><a href="{$URL}m=home&a=jf_list">全&nbsp;&nbsp;部</a></li>
    {foreach from=$_G.setting.jf_type item=v key=k}
    <li class="{if $_GET.type==$k}select{/if}"> <a href="{$URL}m=home&a=jf_list&type={$k}">{$v}</a></li>
    {/foreach}
  </ul>
</div>
<ul class="uc_scoredtab" style="background-color: rgb(245, 245, 245);">
  <li class="uc_scoreli2" style="width:160px;"><b>时间</b></li>
  <li class="uc_scoreli4" style="width:80px"><b>积分</b></li>
  <li class="uc_scoreli2"  style="width:100px"><b>累计</b></li>
  <li class="uc_scoreli3" ><b>事项</b></li>
</ul>
{foreach from=$sign item=v key=k}
<ul class="uc_scoredtab" {if $k%2==1}style="background-color: rgb(245, 245, 245);"{/if}>
  <li class="uc_scoreli2 _dgmdate" data-time="{$v.dateline}"  style="width:160px;"></li>
  <li class="uc_scoreli4"  style="width:80px"><i style="color: #e32014">{$v.jf}</i></li>
  <li class="uc_scoreli2"  style="width:100px">{$v.org_jf}</li>
  <li class="uc_scoreli3" title="{$v.desc}">{$v.desc}</li>
</ul>
{/foreach}
</div>
</div>

<!--分页会因为上面的浮动而有点走位,关掉div的结束,重开始-->

<div class="cl redpage">{$showpage}</div>
<div>
<div>
{include file="./home_footer.php"}