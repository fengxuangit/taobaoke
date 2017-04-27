<!DOCTYPE html>
<html  class="taeapp {if $TAE==1}tae{else}web{/if} _{$CM} _{$CM}_{$CA}">
<head>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $_G.title}{$_G.title}{else}{$_G.setting.title}{/if}</title>
<meta name="keywords" content="{$_G.keywords}"/>
<meta name="description" content="{$_G.description}"/>
<meta name="tk" content="{$_G.setting.pid}|{$_G.setting.taodianjing_url}|1"/>
<meta name="get" content="{$query_text}"/>
<meta name="set" content="{$global_str}"/>
<!-- <script type='text/javascript' src='http://g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script> -->
<script src="assets/global/js/zepto.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/global/css/mobile_global.css" media="all">
</head>
<body>
<div class="uz_system"></div>