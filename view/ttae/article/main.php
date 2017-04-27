{include file="../header.php"}
{$CSS}


<div class="about">  
<div class="xf-layout"> 
    <div class="xf-sub">
    	<div class="xf-box">
        {foreach from=$article_list item=v}
          <h3>{$v.name}</h3>
          <ul class="art-list">
          {foreach from=$v.goods item=s}
                            <li><a href="{$s.url}" >{$s.title}</a></li>
          {/foreach}
          </ul>
         {/foreach}

        </div>
    </div>
    <div class="xf-main">
       <div class="xf-box">
          <div class="xf-article">
              <div class="xf-article-header">
                  <h1>{$article.title}</h1>
              </div>
              <div class="xf-article-cnt">
                  {$article.message}
          </div>  
       </div>
    </div>
</div>
</div>



{include file="../footer.php"}