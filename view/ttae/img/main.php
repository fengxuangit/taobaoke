{include file="../header.php"}
{$CSS}

<div class="nav_position">
当前位置: 
      <a href="{$_G.siteurl}" title="{$_G.setting.title}">{$_G.setting.title}</a> &gt; 
      <a href="{$URL}m=img&a=list">淘头条</a> &gt;
       <a href="{$img.url}" title="{$img.title}" class="on">{$img.title}</a>
</div>

<div class="w990 etao-content feed-detail cl">
  <div class="main">
    <div class="region feed-region ">
      
      <div class="feed-title J_feedTitle cl">
        <h1 class="cl">{$img.title}{if $img.new ==1}<span class="new"></span>{/if}</h1>
      </div>
      <div class="feed-buy-box cl" >
        <div class="feed-meta cl">
         
          <div class="feed-meta-action">
            <div class="fx y">
<div class="_share" data-size="24" data-style="2" data-picurl="{$img.picurl}"  data-desc="{$img.description}"></div>
            </div>
           <span>来源：{$img.from_name}</span><span  class="_dgmdate" data-time="{$img.dateline}">发表于 </span>
          </div>
        </div>
      </div>
      <!-- /info -->
      
      <div class="intro" >{$img.description}..</div>
      
      <div class="feed-cnt">
      {$img.message}
      </div>

      
      <div class="explain"> 
      “<a href="{$_G.siteurl}"><b>{$_G.setting.title}</b></a>
      ”是一个中立的导购平台，致力于打造为广大网友买到高性价比包邮商品,每天为网友们提供严谨的、准确的、新鲜的、丰富的网购产品特价资讯。
      网站资讯信息大部分来自于网友爆料和其它站点收集，经过编辑审核后的内容也会得到大量网友的评价，这是一个大家帮助大家的互动社区。 
      </div>
      <div class="biao cl">
        <dl>
          <dt class="titb cl">标<br>签</dt>
{foreach from=$img.tags item=v key=k}
          <dd class="bga"><a href="{$URL}m=img&a=list&tag={$k}" target="_blank" title="{$v}">{$v}</a></dd>
{/foreach}

        </dl>
        <dl class="like" style="margin:15px;">


        </dl>
      </div>
      <div class="page">
        <li>上一篇：{$img.up} </li>
        <li class="right">下一篇：{$img.down}</li>
      </div>
    </div>
    <div class="cai"> <span>你可能<br>
      还喜欢</span>
      <ul>
{foreach from=$like item=v}
        <li><a href="{$v.url}"  title="{$v.title}" ><img src="{$v.picurl}_100x100.jpg" alt="{$v.title}"></a></li>
{/foreach}
      </ul>
    </div>
    <div class="region comment-region" id="feed_comments"> 
	<div class="_duoshuo" data-id="{$img.id}"></div>
    </div>
  </div>
    {include file="./right_bar.php"}
  
</div>

{include file="../footer.php"}