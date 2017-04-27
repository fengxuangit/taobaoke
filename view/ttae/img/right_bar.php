  <div class="side">
    
    <div class="mod wanke-digest fixed-mod pad cl">
      <div class="hd cl">
        <h3><span class="ir">最新导购</span></h3>
        <a class="more dib" href="{$URL}m=img&a=list" title="最新导购" >更多</a> </div>
      <ul class="wl">
{foreach from=$new item=v}
        <div class="fl">
          <li class="wd-head pic"> <a class="cont" href="{$v.url}" target="_blank" title="{$v.title}"> <img src="{$v.picurl}_150x150.jpg" alt="{$v.title}"> </a></li>
          <p class="wd-hl al"><a class="wd-link" href="{$v.url}" target="_blank" title="{$v.title}">{$v.title}</a></p>
        </div>
{/foreach}
        
        <div class="clear8"></div>
      </ul>
    </div>
    
    <div class="mod ytaghot fixed-mod cl">
      <div class="hd cl">
        <h3><span class="ir">热门搜索</span></h3>
        </div>
      <div class="bd">
        <dl>
{foreach from=$tags key=k item=v}
           <dd><a href="{$URL}m=img&a=list&tag={$k}" target="_blank" title="{$v}">{$v}</a></dd>
{/foreach}

        </dl>
        <div class="clear8"></div>
      </div>
    </div>
  </div>