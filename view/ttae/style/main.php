{include file="../header.php"}
<link href="{$TPLDIR}/style/style_main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$TPLDIR}/style/style_common.css" />


  <script type="text/javascript" src="http://g.tbcdn.cn/??kissy/k/1.3.0/kissy-min.js"></script>
  <script type="text/javascript" src="http://g.tbcdn.cn/??thx/brix/2.0/brix-min.js" charset="utf-8" bx-config="{
	  autoPagelet:true,componentsPath:'http://g.tbcdn.cn/mm/yellowstone/0.17.01/', tag: '20.4.245'
  }">
  </script>
 <script type="text/javascript">
var PID = '{$_G.setting.pid}';
var UNID = '199';
</script>
<script type="text/javascript" src="{$JSDIR}/click_track.js"></script>




   <div  class="ff" bx-name="styleDetail" bx-path="components/style/detail">
   <div class="con-wrap dapei-list-detail clearfix" id="J_listDetail">
    <div class="dapei-detail-con clearfix" id="J_listDetailCon">
     <div class="detail-left-wrap">
      <div class="detail-left">
       <div class="detail-con clearfix" id="J_detailCon">

  {foreach from=$style.images item=v key=k}
   <img src="{$v}"  {if $k==0}class="first"{/if}  id="mate_pic_{$k+1}"/>
{/foreach}
<div class="detail-nav" id="J_detailNav" >
 {foreach from=$style.images item=v key=k}
 <a href="#mate_pic_{$k+1}"  >
      <img src="{$v}" {if $k==0}class="first"{/if} />
      <span class="pic-border" style="width: 64px; height: 98px;"></span>
  </a>
 {/foreach}
</div>


       </div>
      </div>
     </div>
     <div class="detail-right-wrap" id="J_listDetailRight">
      <div class="daren-info clearfix">

       <div class="daren-desc">
        <p class="name-line">

          <a href="{$style.user_url}" target="_blank">

          </a>
        </p>
        <p class="sing-line">{$style.content}</p>

       </div>
      </div>
      <div class="detail-right" id="J_detailRight">


      <div class="cl">


                <div class="share J_Share _share z" data-style="2" data-more="0" data-count="0" data-picurl="{$style.picurl}" style="margin-left:20px;">
                </div>
          <div class="follow-wrap follow J_Follow" data-id="{$style.id}"   >收藏</div>

      </div>

       <div class="dp-detail-buyimgs" id="dp-detail-buys">
        <h3>可购买宝贝</h3>
        <ul class="">
 {foreach from=$style.goods item=v}
  <li>
  <a href="{$v.url}" target="_blank" class="cl">
    <span class="img">
        <img src="{$v.picurl}_90x90.jpg" >
        <span class="img-tag">{$v.title}</span>
        <span class="txt-detail">查看详情</span>
    </span>

    <span class="title" title="{$v.title}">{$v.title}</span>
       <span class="price-del">原价：<i>￥{$v.price}</i></span>
    <span class="price-current">价格：￥<em class="em">{$v.yh_price}</em></span>
                             <span class="gobuy">去购买</span>
  </a>
</li>
{/foreach}

        </ul>
       </div>


          <!--评论组件-->
          <div class="mate-model-box mate-model-comment">
                <div class="_duoshuo" data-id="{$_G.id}"></div>
          </div>


      </div>
     </div>
    </div>
   </div>

  </div>




<div class="con-wrap">
    <div class="style-detail-recommend">
        <h3 class="recommend-title">相似推荐</h3>

        <div class="recommend-list-wrap"  id="J_listFlowCon"  style="position:relative;" >
            <div class="recommend-list cl" id="j_box" >
                   {foreach from=$xiangsi item=v}
                   <div class="ks-waterfall-col">
                    <div class="mate-box">
                        <div class="info-wrap">
                            <div class="info-img">
                                <a href="{$v.id_url}"><img src="{$v.picurl}_240x10000Q90.jpg" width="230" height="345"></a>
                                <div class="info-detail">
                                    <span>{$v.length}件搭配宝贝</span>
                                    <div class="thumb-goods">
                                        <div class="thumb-mL10 cl">
                                              {foreach from=$v.goods item=c key=kk}
                                                 {if $kk<4}
                                                  <a href="{$v.id_url}" target="_blank">
                                                      <img src="{$c.picurl}_72x72xz.jpg" >
                                                  </a>
                                                  {/if}
                                              {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="goods-txt"> <a href="{$v.id_url}" target="_blank">{$v.content} </a></p>


                            <p class="share-action cl">
                                <a class="favorite add_like" data-id="{$v.id}"  >收藏</a>
                            </p>


                        </div>


                        <div class="share-user">
                            <p class="user-line">
                                <a href="#" target="_blank" class="user-img">
                                    <img src="{$v.user_pic}" alt="">
                                </a>
                                <em class="uname"><a href="{$v.id_url}" target="_blank">{$v.username}</a></em>
                                <span class="daren-icon"></span>
                            </p>
                        </div>


                    </div> </div>

                    {/foreach}
            </div>
        </div>

    </div>
</div>
</div>


{include file="../footer.php"}


