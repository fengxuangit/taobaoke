{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/home.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/brandgroup.css" media="all" />

<div class="hpz_usercenter cl {$CLASS}" >

<!--用户中心左侧-->

<div class="uc_left cl">
  <div class="uc_photo"> <img id="thumbnails_big" width="160" height="160" src="{$_G.member.picurl}"></div>
  <ul>
    <li><a href="{$URL}m=home&a=setting" class="{if $CURACTION == 'setting'}uc_leftselect{/if}">基本资料</a></li>
    <li><a href="{$URL}m=home&a=password" class="{if $CURACTION == 'password'}uc_leftselect{/if}">密码修改</a></li>
    
    <!-- <li><a href="{$URL}m=home&a=goods"   class="{if $CURACTION == 'goods'}uc_leftselect{/if}" >报名商品</a></li>-->
    
    <li><a href="{$URL}m=home&a=duihuan" class="{if $CURACTION == 'duihuan'}uc_leftselect{/if}">积分兑换</a></li>
    
    <!--<li><a href="{$URL}m=home&a=jf_task" class="{if $CURACTION == 'jf_task'}uc_leftselect{/if}">积分任务</a></li>-->
    
    <li><a href="{$URL}m=home&a=jf_list" class="{if $CURACTION == 'jf_list'}uc_leftselect{/if}">积分明细</a></li>
    
    <li><a href="{$URL}m=home&a=favorite_list&type=goods" class="{if $CURACTION == 'favorite_list'}uc_leftselect{/if}">我的收藏</a></li>
    
    

  </ul>
</div>

<!--用户中心右侧-->

<div class="uc_right ucinfo_right cl">
<h1>您好，欢迎加入{$_G.setting.title}！今天是{$today}</h1>
