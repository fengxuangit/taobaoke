<div style="width: 100%; height: 60px; margin: 0 auto"></div>
<div class="i2_botd cl">
    <ul class="uline">
      <li><a href="{$_G.siteurl}">首页</a></li>
      <li><a href="{$URL}mobile=no">电脑版</a></li>
      <li><a href="{$URL}mobile=yes" style="color: #666">手机版</a></li>
    </ul>
</div>
{if !$_G.uid}
<div class="botmlogind">
    <a href="{$URL}m=member&a=login" class="a1">登录</a>
    <a href="{$URL}m=member&a=reg" class="a2">注册</a>
</div>
{/if}
<div class="bottom">
copyright @2016 {$_G.host}
</div>

{if $_G.setting.app_andorid_url || $_G.setting.app_ios_url}
<div class="download-con tishi_1" style="bottom: 0px;">
	<div class="down_app">
    	<div class="download-logo">
        	<img src="{$IMGDIR}/icon150x150.png" width="100%" height="100%">
        </div>
        <div class="alogo">
        	<p class="client-name">客户端购物更方便！</p>
        </div>
        <div class="open_now">
        	<a href="/index.php?m=apps">
            	<span class="open_btn">立刻下载</span>
            </a>
        </div>
        <div class="close-btn-con" >
        	<span class="close-btn-icon"><img src="{$IMGDIR}/closeft.png" width="12" height="12"></span>
        </div>
    </div>
</div>
{/if}

<script type="text/javascript" src="{$JSDIR}/main.js"></script>
{include file="../common_mobile/footer.php"}