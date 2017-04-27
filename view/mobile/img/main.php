{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/img.css" media="all">

<div class="top_img"><img src="{$picurl}" ></div>
 <h1 class="title">{$img.title}</h1>

<div class="content content_box" data-urlscche="{$img.urlsche}">
<div class="content_top">
<div class="dingcai"><span class="iconfont">&#xe62f;</span><i>({$img.like})</i>  <span class="iconfont">&#xe630;</span><i>({$img.hate})</i></div>

发布时间: <i class="_dgmdate" data-time="{$img.dateline}"></i>
</div>
     {$img.message}

 </div>


{include file="../footer.php"}


