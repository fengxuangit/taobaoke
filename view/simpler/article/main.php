{include file="../header.php"}


<div class="container wp ">
<div class="card white">
         <div class="card-content">

         <h3 class="center-align">{$article.title}</h3>
<blockquote class="article_content">
           {$article.message}
</blockquote>
         </div>
         <div class="card-action">
          <!--  <a href="#">This is a link</a>
           <a href='#'>This is a link</a> -->
          <span class="right _dgmdate" data-time="{$article.dateline}"> 发布时间: </span>
           浏览: {$article.views}
         </div>
       </div>
</div>
{include file="../footer.php"}
