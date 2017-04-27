<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<link rel="stylesheet" href="https://at.alicdn.com/t/font_1441957734_410811.css"/>
{literal}
<style>
* { margin: 0; padding: 0 }
html, body { overflow: hidden; }
.plugin-wrap { width: 140px; margin: 0 auto; }
.plugin-wrap a { display: block; width: 50px; height: 80px; float: left; color: #333; text-decoration: none; font-size: 12px; text-align: center; margin: 10px; }
.plugin-wrap a span { display: block; width: 50px; height: 50px; background: #f9f3f3; border-radius: 100%; margin-bottom: 5px; }
.plugin-wrap a span .iconfont { font-size: 26px; line-height: 50px; color: #ff6d71; }
.tab { width: 100%; height: 30px; background: #f6f6f6; line-height: 30px; text-align: center; color: #dc2a2e; font-size: 12px; }
    </style>
{/literal}
</head>
<body>
<div class="tab">
    <span>快捷工具</span>
</div>
<div class="plugin-wrap">

{foreach from=$bar item=v}
<a href="{$v.url}" {if $v.url} target="_blank"{/if}><span><i class="iconfont {$v.classname}"></i></span>{$v.name}</a>
{/foreach}
</div>

</body></html>


