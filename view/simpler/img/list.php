{include file="../header.php"}

<div class="container wp">
            {foreach from=$goods item=v}
                <div class="article hvr-overline-from-center">
                    <div class="articleHeader">
                        <div class="articleTitle"><a href="{$v.id_url}" target="_blank">{$v.title}</a></div>
                    </div>
                    <div class="articleBody cl">
                        <!--缩略图-->
                        <div class="articleThumb">
                            <a href="{$v.id_url}"  target="_blank"><img src="{$v.picurl}_300x300.jpg" alt="{$v.title}" class="wp-post-image"></a>
                        </div>
                        <!--摘要-->
                        <div class="articleFeed">
                        <p> <a href="{$v.id_url}"  target="_blank"  class="grey-text text-darken-1">{$v.description} </a></p>
                        </div>
                        <!--tags-->
                        <div class="articleTags">
                            <ul>
                            {foreach from=$v.tags item=tag key=k1}
                            <a href="{$URL}m=img&a=list&tag={$k1}" rel="tag"  target="_blank">{$tag}</a>
                            {/foreach}

                        </div>
                    </div>
                    <div class="articleFooter cl">
                        <ul class="articleStatu">
                            <li><i class="iconfont icon-riqixuanzetubiao"></i><span class="_dgmdate" data-time="{$v.dateline}"></span></li>
                            <li class="_add_like cur" data-id="{$v.id}"><i class="iconfont icon-xihuan2"></i>喜欢 <span>{$v.like}</span></li>
                            <li class="_add_like2 cur" data-id="{$v.id}" data-type="hite"><i class="iconfont icon-diancai"></i>踩 <span>{$v.hate}</span></li>


                            <li><i class="iconfont icon-gengduo"></i>
                            <a href="{$v.id_url}#comment" rel="category tag"  target="_blank">评论</a></li>
                        </ul>
                        <a href="{$v.id_url}" class="btn btn-readmore btn-info btn-md right cyan lighten-3"  target="_blank">阅读更多</a>
                    </div>
                </div>
            {/foreach}
</div>

<div class="cl bluepage">{$showpage}</div>
{include file="../footer.php"}
