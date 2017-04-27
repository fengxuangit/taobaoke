{include file="../../common/header.php"}
<link type="text/css" rel="stylesheet" href="{$COMMONDIR}apps/main.css">
</head>
<body class="taeapp {if $TAE==1}tae{else}web{/if} _{$CM}_{$CA}">
<div class="uz_system"></div>


<!-- 页头 -->
<div class="header header_other mobile_header">
  <div class="area">
    <div class="logo other juan-iphone">
     <a title="{$_G.setting.title}首页" class="juan-other-logo fl" href="{$_G.siteurl}"> </a>  
    </div>
    <div class="other_nav" >
      <ul>
        <li><a href="{$_G.siteurl}"  class="jp active">返回首页</a></li>
       
      </ul>
    </div>
  </div>
</div>
<!-- /页头 --> 
<!-- 主体 --> 

<!--main start-->
<div id="stage_1" class="stage stage_1" >
  <div class="stage_in" style="margin-top: 163px;">
    <div class="stage_left tabjp" style="display: block;">
      <div class="opa goods_01" ><img src="{$COMMONDIR}apps/goods01.png" class="_loading"></div>
      <div class="lady_01"><img src="{$COMMONDIR}apps/lady001.png"></div>
    </div>
    <div class="stage_left tabjky" style="display: none;">
      <div class="opa goods_01 demo1" style="visibility: hidden; opacity: 0; top: 291px;"><img src="{$COMMONDIR}apps/goods01.png"></div>
      <div class="lady_01"><img src="{$COMMONDIR}apps/lady01.png" class="_loading"></div>
    </div>
  </div>
</div>
<div id="stage_2" class="stage stage_2" >
  <div class="stage_in" style="margin-top: 163px;">
    <div class="stage_left">
      <div class="opa shirt demo2" ><img src="{$COMMONDIR}apps/shirt.png" class="_loading"></div>
      <div class="boy"><img src="{$COMMONDIR}apps/boy.png" class="_loading"></div>
    </div>
  </div>
</div>
<div id="stage_3" class="stage stage_3" >
  <div class="stage_in" style="margin-top: 163px;">
    <div class="stage_left">
      <div class="opa phone_01 demo3" ><img src="{$COMMONDIR}apps/phone01.png" class="_loading"></div>
      <div class="lady_02"><img src="{$COMMONDIR}apps/lady02.png" class="_loading"></div>
    </div>
  </div>
</div>
<div id="stage_4" class="stage stage_4" >
  <div class="stage_in" style="margin-top: 163px;">
    <div class="stage_left">
      <div class="opa goods_02 demo4"><img src="{$COMMONDIR}apps/goods02.png" class="_loading"></div>
      <div class="phone_02"><img src="{$COMMONDIR}apps/phone02.png" class="_loading" ></div>
    </div>
  </div>
</div>

<div  class="fixed_right tabjky">
  <div class="step_text step_01" style="opacity: 1;">
    <h2>淘宝天猫特卖9.9元包邮</h2>
  </div>

  <div class="code_area">
  {if $_G.setting.app_andorid_url} 
   <a {if $_G.setting.app_andorid_url} href="{$_G.setting.app_andorid_url}" target="_blank" {/if} class="code_btn ff">android下载</a>
  {/if}
  {if $_G.setting.app_iphone_url}
  <a {if $_G.setting.app_iphone_url} href="{$_G.setting.app_iphone_url}" target="_blank" {/if}  class="code_btn ff">iphone下载</a>
    {/if}
   </div>
</div>
<a id="next_arrow" class="download_arrow" href="javascript:;" style="display: block;"></a>

{include file="../../common/footer.php"}

