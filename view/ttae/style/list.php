{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$ASSDIR}/style.css" media="all">

{if $cate}
{if $cate.picurl}
<div class="_auto_ad" data-picurl="{$cate.picurl}" data-url="{$cate.pic_url}"></div>
{/if}
{else}
<div class="_auto_ad" data-picurl="{$_G.ad.k10.picurl}" data-url="{$_G.ad.k10.url}"></div>
{/if}



<div class="con-wrap page-content lis-page">

<div class="list-main ff" style="margin:10px 0;padding-top:10px;">
  <div class="list-title cl" style="margin-bottom:0;">
  <h3>全部</h3>
    <span id="J_tagDes" class="list-tag-des">统统奉献给你啦！好好挑个够吧!</span>
  </div>
</div>
    


  <div class="ucenter-list-wrap cl style-listpage">


<div class="mate-box dapei-listnav " id="J_style_nav">
	<div class="nav-tags cl">
    
	  <a href="{$URL}m=style&a=list"  {if !$_GET.cate}class="current"{/if}>全部</a>
	 {foreach from=$_G.style_cate item=v key=k}
     {if $k>0}
      <a href="{$URL}m=style&a=list&cate={$v.id}" {if $_GET.cate==$v.id}class="current"{/if}>{$v.name}</a>
      {/if}
      {/foreach}
	</div>
</div>

      <div class="cl style-waterfall " id="J_listFlowCon">

<div id="j_box">

      {foreach from=$goods item=v key = k}
      
    	  <div class="ks-waterfall-col">      
     		{if $k==0} <div class="mate-box nav-palce listtop" data-waterfall-index="0" style="width:226px;"></div>{/if}
                
                 		 <div class="mate-box ks-waterfall" >
                          <div class="info-wrap">
                              <div class="info-img">
                                <a href="{$v.id_url}" target="_blank">
                                  <img src="{$v.picurl}_220x10000.jpg" alt="" width="230" height="345">
                                </a>
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
                                        <a class="favorite add_like" data-id="{$v.id}" >收藏</a>
                                    </p>
                          </div>              
                            <div class="share-user">
                                <p class="user-line">
                                    <a href="{$v.id_url}" target="_blank" class="user-img">
                                        <img src="{$v.user_pic}" alt="">
                                    </a>
                                    <em class="uname"><a href="{$v.id_url}" target="_blank">{$v.username}</a></em>
                                    <span class="daren-icon"></span>
                                </p>
                            </div>
                      </div>  

          </div>
       {/foreach}
          </div>
  </div>
</div>
  
  </div>
<div class="cl redpage">{$showpage}</div>



{include file="../footer.php"}


