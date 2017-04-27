{include file="../../common/header.php"}
</head>
<body>
<div class="uz_system"></div>
<a class="go_pay"  style="display:none;" data-tao_num_iid ="{$num_iid}" data-taoappkey="{$_G.setting.appkey}" data-tao_pid="{$_G.setting.pid}"  target="_blank" href="http://item.taobao.com/item.htm?id={$num_iid}" data-type="0" biz-itemid="{$num_iid}"  data-style="2"  data-tmpl="0" data-weburl="{$_G.setting.taodianjing_url}"></a>
<script type="text/javascript" src="assets/global/js/jquery-1.8.3.min.js"></script> 
<script type="text/javascript" src="assets/global/js/go_pay.js"></script>
</body>
</html>
