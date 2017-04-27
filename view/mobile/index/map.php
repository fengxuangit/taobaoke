{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/map.css" media="all" />
<div class="map">
<div class="content">
<div class="map_tit">
<a href="{$_G.siteurl}">{$_G.setting.title}</a>>>
<a href="{$URL}a=map">网站地图</a>
</div>
            <div class="map-web">
               


<!--{foreach from=$_G.channels item=vv}-->
  <!--{if $vv.hide==0 }--> 
   <div class="cl">
   <h3><a href="{$vv.url}" target="_blank">{$vv.name}</a>  </h3>       	
            <!--{if $vv.sub}-->
                  <!--{foreach from=$vv.sub item=vvv}-->
                    <!--{if $vvv.hide ==0}-->        
                            <a href="{$vvv.url}" target="_blank">{$vvv.name}</a>
                           <!--{foreach from=$vvv.sub item=a}-->
                             <!--{if $a.hide == 0}-->
                           		   <a href="{$a.url}" target="_blank">{$a.name}</a>
                          	<!--{/if}-->  
                          <!--{/foreach}-->
                      <!--{/if}-->  
                  <!--{/foreach}-->
            <!--{/if}-->   
      </div>
 <!--{/if}-->                    
<!--{/foreach}-->

<div class="cl">
 <h3><a href="">分类:</a></h3>
 <!--{foreach from=$_G.cate item=vv}-->
 <a href="{$URL}a=cate&id={$vv.id}" target="_blank">{$vv.name}</a> 
 <!--{/foreach}-->
</div>
            

<div class="cl">
 <h3><a href="">标签:</a></h3>
  <!--{foreach from=$tags item=v}-->
 <a href="{$URL}a=all&tag={$v}" target="_blank">{$v}</a> 
 <!--{/foreach}-->
</div>  
             
            </div>
        </div>

</div>

{include file="../footer.php"}


