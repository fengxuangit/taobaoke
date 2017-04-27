{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="assets/global/css/public_img.css"  media="all" />

<div class="articleDetail container wp">
    <div class="row">
        <div class="col-md-12">
            <div class="articleContent">
                <div class="title">{$img.title}</div>
                <div class="secTitleBar">
                    <ul>
                        <li>发表：<span class="_dgmdate" data-time="{$img.dateline}"></span>
                        </li>
                        <li>来源: {$img.from_name}</li>
                        <li>编辑: {$_G.setting.title}</li>
                    </ul>
                </div>
                <!-- 内容 -->
                <div class="articleCon post_content">
<div class="article_content">
                    {$img.message}
</div>
                    <br/>

                     <div class="_share" data-style="2" data-more="0" data-count="0" data-picurl="{$img.picurl}" data-title="{$img.title}" ></div>


                    <div class="downBox cl">
                        <ul class="downul ">
                            <li class="_add_like" data-id="{$img.id}"><a ><i class="iconfont icon-xihuan2"></i>喜欢 <span>{$img.like}</span></a></li>
                            <li class="middleli _add_like2" data-id="{$img.id}" ><a ><i class="iconfont icon-diancai"></i>踩 <span>{$img.hate}</span></a></li>
                            <li><a href="{$_G.siteurl}"><i class="fa fa-home"></i>返回首页</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- 标签 -->
                <div class="articleTagsBox">
                    <ul><span>标签：</span>
                        {foreach from=$img.tags item=tag key=k1}
                        <a href="{$URL}m=img&a=list&tag={$k1}" rel="tag">{$tag}</a>
                        {/foreach}

                    </ul>
                </div>
                <!-- 评论 -->
                <div class="post_content">
                <a id"#comment"></a>
                    <div class="_duoshuo" data-id="{$img.id}"></div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>


{include file="../footer.php"}
