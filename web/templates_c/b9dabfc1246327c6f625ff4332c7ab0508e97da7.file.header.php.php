<?php /* Smarty version Smarty-3.1.15, created on 2017-04-26 23:54:15
         compiled from "/Users/apple/wwwroot/webapp/tae/view/ttae/header.php" */ ?>
<?php /*%%SmartyHeaderCode:14127079475900c2a79d90d6-04823695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b9dabfc1246327c6f625ff4332c7ab0508e97da7' => 
    array (
      0 => '/Users/apple/wwwroot/webapp/tae/view/ttae/header.php',
      1 => 1493218591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14127079475900c2a79d90d6-04823695',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CSSDIR' => 0,
    'today' => 0,
    '_G' => 0,
    'h' => 0,
    'IMGDIR' => 0,
    'URL' => 0,
    '_GET' => 0,
    'v' => 0,
    'CM' => 0,
    'CA' => 0,
    'CURMODULE' => 0,
    'CURACTION' => 0,
    'TAE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5900c2a7a9d786_10292438',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5900c2a7a9d786_10292438')) {function content_5900c2a7a9d786_10292438($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common/header.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['CSSDIR']->value;?>
/main.css" media="all" />
 



<a name="index_top"></a>
<div class="hpz_headd" style="display: none;" data-time="<?php echo $_smarty_tpl->tpl_vars['today']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['_G']->value['timestamp'];?>
,<?php echo $_smarty_tpl->tpl_vars['today']->value+86400;?>
,<?php echo $_smarty_tpl->tpl_vars['_G']->value['timestamp']+86400;?>
,<?php echo $_smarty_tpl->tpl_vars['h']->value;?>
">
   <div class="hpz_headdd">
       <span class="addFavorite">每天精选推荐超值正品，按键<b>Crtl+D</b>收藏，帮您省钱更简单！</span>
       <i class="indexiocns delheadddi close_toptip"></i>
       <a class="delheaddda close_toptip">关闭</a>
   </div>

</div>

<div class="hpz_headmenu">
	            <div id="user_login_state">
                        
            <h1>您好，欢迎来到<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['title'];?>
！
            <?php if (!$_smarty_tpl->tpl_vars['_G']->value['uid']) {?>请  <a href="/index.php?m=member&a=login" style="color: #e32014;">登录</a><?php }?></h1>
            <ul>
            <?php if (!$_smarty_tpl->tpl_vars['_G']->value['uid']) {?>
           
                <li>|</li>
                <li><a href="/index.php?m=member&a=reg" style="color: #e32014;">免费注册</a></li> <li>|</li>
              
           
            <?php } else { ?>
           
             <li><a href="/index.php?m=home"><?php echo $_smarty_tpl->tpl_vars['_G']->value['username'];?>
</a></li>
                <li>|</li>
                <li><a href="/index.php?m=home">会员中心</a></li>
                <li>|</li>
                <li><a href="/index.php?m=member&a=logout" class="a_logout">退出</a></li> <li>|</li>
          
            <?php }?>
            
<!--             <li> <a href="/index.php?m=apps">app下载</a></li> -->
              </ul>
           
                        </div>
            
            <ul style="float: right">
                <li class="testguanzhumou"><i class="indexiocns headmenuicon3"></i>
                <a href="http://weibo.com/u/2106992135" target="_blank" style="">关注<em class="all_or">∨</em></a></li>
                <li>|</li>
                <li class="headsharebox"><i class="indexiocns headmenuicon4"></i><a href="#" class="show_share_box">分享</a></li>
                <li>|</li>
                <li><i class="indexiocns headmenuicon5"></i><a href="/index.php?a=desktop">收藏到桌面</a></li>
                <li><a href="/index.php?m=apply&a=info">商家报名</a></li>
            </ul>
           <div class="guanzhuobjd">
                 <img class="wxword" style="display:block" src="<?php echo $_smarty_tpl->tpl_vars['IMGDIR']->value;?>
/wt.png">
            </div>
           
</div>

<div class="hpz_head">

    <a href="<?php echo $_smarty_tpl->tpl_vars['_G']->value['siteurl'];?>
" class="hpz_log"><img src="<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['logo'];?>
"></a>

    
    <div class="search_box y">
        	<div class="header-srh">
        <div class="srh-box">
            <form action="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=search" method="POST"  id="search_form">
                                <div class="srh-inp">
                    <div class="srh-xl" id="searchxl">
                        <ul class="triggers">
                           <li class="selected">搜 索</li>        
                         </ul>
                        
                    </div>
     			  <input placeholder="搜&quot;精品女装&quot;试试" type="text" class="so_kw" data-type="kw" name="kw" value="<?php if ($_smarty_tpl->tpl_vars['_GET']->value['kw']) {?><?php echo $_smarty_tpl->tpl_vars['_GET']->value['kw'];?>
<?php }?>" autocomplete="off" accesskey="s" aria-expanded="true" />
                </div>
                <input type="submit" class="srh-sub so_web _check_form" url="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=search" value="搜本站" >
                <input type="submit" class="srh-sub so_tb _check_form" url="http://ai.taobao.com/search/index.htm" value="搜淘宝">
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['pid'];?>
" name="pid">

                
            </form>
        </div>
    </div>
        
        </div>

        <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=ad&id=1" class="head_gg2"><img width="180" height="65" src="<?php echo $_smarty_tpl->tpl_vars['IMGDIR']->value;?>
/nav2.png" ></a>

</div>

<div class="hpz_menubk">
    <div class="hpzmenu">
        <ul>


<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_G']->value['nav']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['v']->value['type']=="1") {?>
<li class="<?php echo $_smarty_tpl->tpl_vars['v']->value['classname'];?>
"><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['target']=="1") {?> target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
<?php }?>
<?php } ?>

<!--
<li <?php if ($_smarty_tpl->tpl_vars['CM']->value=='index'&&$_smarty_tpl->tpl_vars['CA']->value=='main') {?>class="hpzmenusel" <?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
">首页</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['_GET']->value['price']=='10') {?>class="hpzmenusel" <?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=all&price=10">9块9包邮</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['_GET']->value['price']=='10_20') {?>class="hpzmenusel"<?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=all&price=10_20">19.9包邮</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='img') {?>class="hpzmenusel"<?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=img&a=list">值得买</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='style') {?>class="hpzmenusel"<?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=style&a=list">搭配</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='shop') {?>class="hpzmenusel"<?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=shop&a=list">品牌店铺</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='duihuan') {?>class="hpzmenusel" <?php }?>><a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=duihuan&a=list">积分中心</a></li>
<li <?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='index'&&$_smarty_tpl->tpl_vars['CURACTION']->value=='yaoqing') {?>class="hpzmenusel" <?php }?>>
<a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=yaoqing">免费赚钱</a>
</li>
<li <?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='index'&&$_smarty_tpl->tpl_vars['CURACTION']->value=='today') {?>class="hpzmenusel" <?php }?> style="position: relative">
<a class="is_color is_bold" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=today">今日新品</a><span class="m_tj"></span>
</li>-->
                 
                 
         </ul>


       <span class="hpz_head_qd" style="float: right;<?php if ($_smarty_tpl->tpl_vars['TAE']->value==1) {?> display:none;<?php }?>">
             <a target="_blank" style="color: #fff">签到</a>
        </span>


        <div class="head_qiandao" style="display: none;">
            <div class="head_qd_d1">

                <div class="h_qdd1d1">
                <?php if ($_smarty_tpl->tpl_vars['_G']->value['uid']) {?>                
               		 <div class="cl">
                        <span class="h_qdd1d1name"><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=home" class="h_qdd1a1"><?php echo $_smarty_tpl->tpl_vars['_G']->value['username'];?>
</a></span>
                        
                        <?php if ($_smarty_tpl->tpl_vars['TAE']->value==0) {?><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=logout" class="h_qdd1a1 a_logout">退出</a><?php }?>
                        <b class="h_qdd1b1">可用积分：<i id="user_ownscore"><?php echo $_smarty_tpl->tpl_vars['_G']->value['member']['jf'];?>
</i></b>
                   </div>
                   <a class="h_qdd1btn1 h_qdd1btn2 _ajax_dialog"  href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=ajax&a=sign" style="margin-left:0;">签到，领积分</a>
                <?php } else { ?>
					 <a class="h_qdd1btn1" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=login">用户登录</a>
                    <p style="display:block; margin-top:60px; width:130px; text-align:center;">登录签到拿积分</p>
                <?php }?>
				</div>
            </div>
            <div class="head_qd_d2">
                 <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=yaoqing" class="head_qd_d2a1">赚积分</a>
                 <span>|</span>
                 <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=duihuan&a=list" class="head_qd_d2a2">花积分</a>
            </div>
        </div>

    </div>
</div>
<?php if ($_smarty_tpl->tpl_vars['CM']->value!='shop'&&$_smarty_tpl->tpl_vars['CM']->value!='home') {?>
<div class="score_nav cl">
    <ul class="score_nav_ul">
    
    
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_G']->value['nav']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['v']->value['type']=="2") {?>
<li class="<?php echo $_smarty_tpl->tpl_vars['v']->value['classname'];?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['target']=="1") {?> target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
<?php }?>
<?php } ?>
        <!--<li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=all" style="<?php if ($_smarty_tpl->tpl_vars['CA']->value=='all') {?>color:#E32014;<?php }?>">全部</a></li>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_G']->value['channels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value['hide']==0) {?>
         <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
fid=<?php echo $_smarty_tpl->tpl_vars['v']->value['fid'];?>
<?php if ($_smarty_tpl->tpl_vars['_GET']->value['price']) {?>&price=<?php echo $_smarty_tpl->tpl_vars['_GET']->value['price'];?>
<?php }?>" style="<?php if ($_smarty_tpl->tpl_vars['_G']->value['fid']==$_smarty_tpl->tpl_vars['v']->value['fid']) {?>color:#E32014;<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
          <li class="iconBack"><em>|</em></li>
          <?php }?>
         <?php } ?>
         
         <?php if ($_smarty_tpl->tpl_vars['_G']->value['goods_cate']) {?>
         <li style="margin-left:20px;color:#09F;">分类</li> <li class="iconBack"><em>|</em></li>
         <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_G']->value['goods_cate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
          <?php if ($_smarty_tpl->tpl_vars['v']->value['hide']==0) {?>
         <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=cate&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['CA']->value=='cate'&&$_smarty_tpl->tpl_vars['_G']->value['id']==$_smarty_tpl->tpl_vars['v']->value['id']) {?>style="color:#E32014;"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
          <li class="iconBack"><em>|</em></li>
          <?php }?>
         <?php } ?>
         <?php }?>
         -->
        <?php if ($_smarty_tpl->tpl_vars['CM']->value=='index'||$_smarty_tpl->tpl_vars['CM']->value=='channel') {?>
        <span class="y">
         <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=index&a=all<?php if ($_smarty_tpl->tpl_vars['_G']->value['fid']) {?>&fid=<?php echo $_smarty_tpl->tpl_vars['_G']->value['fid'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['_G']->value['id']) {?>&id=<?php echo $_smarty_tpl->tpl_vars['_G']->value['id'];?>
<?php }?>" style="<?php if (!$_smarty_tpl->tpl_vars['_GET']->value['order']) {?>color:#E32014;<?php }?>">默认</a></li>
         <li>
         <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=index&a=all<?php if ($_smarty_tpl->tpl_vars['_G']->value['fid']) {?>&fid=<?php echo $_smarty_tpl->tpl_vars['_G']->value['fid'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['_G']->value['id']) {?>&id=<?php echo $_smarty_tpl->tpl_vars['_G']->value['id'];?>
<?php }?>&order=yh_price&sort=asc" style="<?php if ($_smarty_tpl->tpl_vars['_GET']->value['order']=='yh_price') {?>color:#E32014;<?php }?>">价格</a>
         </li>
		<?php }?>
        
         </span>
    </ul>
</div>
<?php }?>
<?php }} ?>
