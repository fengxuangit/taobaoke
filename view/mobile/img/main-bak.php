{include file="../header.php"}
{$CSS}

<!-- <link rel="stylesheet" href="/view/app/css/img.css"> -->
<link rel="stylesheet" href="http://www.ddapei.com/view/app/css/app.css">

<div class="cl content"  >



<article id="content_show" class="detail">
	
	<h1>{$img.title}</h1>

	<div class="userMsg">推荐人：{$img.username} | {$img.dateline}</div>
    <div class="detail_content feed-cnt">

               <div class="cl">
               {$img.message}
               
               </div>
               
    </div>


    
</article>


</div>





{include file="../footer.php"}