 {include file='../header.php'}

{$CSS}
<div class="actindexlf">
  <div class="actindexlfd">
    <ul class="actilful1">
      {foreach from=$_G.pics.k31 item = v}      
      {if $v.hide==0}
      <li><a href="{$v.url}" target="_blank"><img src="{$v.picurl}"  /></a></li>
      {/if}
      
      {/foreach}
    </ul>
    <ul class="indexiocns actilful2">
      {foreach from=$_G.pics.k31 item = v name=a}      
      {if $v.hide==0}
      <li data-index="{$smarty.foreach.a.index}"></li>
      {/if}
      
      {/foreach}
    </ul>
  </div>
</div>
<div class="activitycontent">
  <div class="actleftcontent">
    <h1>促销活动</h1>
    <ul>
      <li><a href="{$URL}m=activity" {if !$_GET.tag}class="actmeunselect"{/if}>全部</a></li>
      
      <!--{foreach from=$_G.setting.activity_tags item=vv key=k}--> 
      
      {if $k>0}
      <li><a href="{$URL}m=activity&tag={$k}" class="{if $_GET.tag && $_GET.tag==$k}actmeunselect{/if}">{$vv}</a></li>
      {/if} 
      
      <!--{/foreach}-->
      
    </ul>
    {foreach from=$goods item=v} <a class="act_hdimg" href="{$v.url}" target="_blank" title="{$v.title}"> <img src="{$v.picurl}" width="740" height="200"> </a> {/foreach} </div>
  <div class="actrightcontent">
    <div class="actrightban" >
      <h1 style="line-height: 40px; margin-top: 0px;">今日推荐活动</h1>
      {foreach from=$ding item=v} <a href="{$v.url}" target="_blank"><img src="{$v.picurl}" width="235" height="290"></a> {/foreach} </div>
  </div>
</div>
<div class="redpage cl">{$showpage}</div>
{include file='../footer.php'}

