<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="assets/global/css/mobile_global.css" media="all">
<title>{$message}</title>
</head>
<body class="taeapp {if $TAE==1}tae{else}web{/if} _{$CM}_{$CA}">
<div class="uz_system"></div>

<div class="cl showmessage">
  <div class="nfl">
    <div class="f_c altw">
      <div class="{$alerttype}">
        <p>{$message}</p>
        <p class="alert_btnleft"><p class="alert_btnleft">
        {if $url}
         <a href="{$url}">返回上一页</a>      
        {else}
         <a href="{$_G.siteurl}">返回首页</a>
        {/if}
        </p>
	       {if $ext_msg}{$ext_msg}{/if}
           </p>
      </div>
    </div>
  </div>
</div>
</body>
</html>