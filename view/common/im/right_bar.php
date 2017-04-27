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
.title_bar{background: #E77474;text-align: center;height: 40px;line-height: 40px;color: #fff;}
.plugin_box{font-size: 14px;}
.plugin_item{height: 30px;line-height: 30px;}
.plugin_l{width: 35%;float: left;background: #f5f5f5;border-bottom: 1px solid #e3dbe4;height: 30px;line-height: 30px;overflow: hidden;text-indent: 5px;}
.plugin_r{width: 63%;padding-left: 2%;float: left;    background: #b7e0c4;color: #2196F3;border-bottom: 1px solid #eee;min-width: 5px;height: 30px;line-height: 30px;overflow: hidden;}

</style>
{/literal}
</head>
<body>
<div class="title_bar">
    <span>用户信息</span>
</div>

<div class="plugin_box">

{foreach from=$user item=v key=k}
<div class="plugin_item">
	<div class="plugin_l">{$k}: </div>
	<div class="plugin_r">{$v} </div>
</div>
{/foreach}

</div>


</body></html>


