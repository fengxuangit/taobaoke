<?php /* Smarty version Smarty-3.1.15, created on 2017-04-26 23:54:35
         compiled from "/Users/apple/wwwroot/webapp/tae/view/common/member/login.php" */ ?>
<?php /*%%SmartyHeaderCode:10569061575900c2bb75d466-92447615%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c6828716c8fd0a1eb7501e4310cb7e3f292bb23b' => 
    array (
      0 => '/Users/apple/wwwroot/webapp/tae/view/common/member/login.php',
      1 => 1493218591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10569061575900c2bb75d466-92447615',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'COMMONDIR' => 0,
    '_G' => 0,
    'URL' => 0,
    'CM' => 0,
    'CA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5900c2bb7bb024_68744802',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5900c2bb7bb024_68744802')) {function content_5900c2bb7bb024_68744802($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../../".((string)$_smarty_tpl->tpl_vars['TPLNAME']->value)."/header.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['COMMONDIR']->value;?>
/member/main.css">



<div class="login_box">
    <div class="container">
        <div class="Login-box">
            <h2 class="Login-title">登录<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['title'];?>
</h2>
            <div class="Login-form">
                <form class="Form" method="post">
                    <!--<p class="error" style="display:none">您输入的密码和账户名不匹配，请重新输入。</p>-->
                    <div class="cell">
                        <input type="text" name="username" id="js-mobile_ipt" class="text" placeholder="用户名/邮箱/手机号" data-type="null"  data-msg="用户名不能为空">
                    </div>
                    <div class="cell">
                        <input type="password" name="password" id="js-mobile_pwd_ipt" class="text"  placeholder="输入密码" data-type="password">
                    </div>
                 <?php if ($_smarty_tpl->tpl_vars['_G']->value['setting']['login_yzm']==1) {?>

                 <div class="cell" style="margin-bottom:10px;">
                         <input type="text" class="text" name="yzm" style="width:140px;margin-right:10px;float:left;"  placeholder="请输入验证码" data-type="yzm">
                           <img   height="45" src="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=ajax&a=yzm" class="yzm_img yzm">
                            <a class="yzm" href="#" >刷新</a>
                    </div>
                
                 <?php }?>
                 
                    <div class="cell cell1">
                        <input type="checkbox" checked="true" id="js-mail_chk" name="js-mail_chk" class="qiek"><label class="next">下次自动登录</label>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=get_password" class="f-fr">忘记密码？</a>
                    </div>
                    <div class="bottom"><a id="js-mobile_btn" going="0" href="javascript:;" class="button _onsubmit ff _check_form">登&nbsp;&nbsp;录</a></div>
                     <input type="hidden" name="login_submit" value="1">
                    <input type="hidden" name="m" value="<?php echo $_smarty_tpl->tpl_vars['CM']->value;?>
">
                    <input type="hidden" name="a" value="<?php echo $_smarty_tpl->tpl_vars['CA']->value;?>
">
                    <input type="hidden" name="referer" value="<?php echo $_smarty_tpl->tpl_vars['_G']->value['referer'];?>
">
                </form>
                <div class="cell cell2">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=reg" class="f-fr ms-btn">马上注册</a>
                    <span class="f-fr">还没有<?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['title'];?>
账号？</span>
                </div>
                
<?php if ($_smarty_tpl->tpl_vars['_G']->value['setting']['weibo_appkey']||$_smarty_tpl->tpl_vars['_G']->value['setting']['qq_appkey']||$_smarty_tpl->tpl_vars['_G']->value['setting']['taobao_appkey']) {?>
                <div class="qita">
                 <?php if ($_smarty_tpl->tpl_vars['CA']->value=='reg') {?>
                <div class="cl">
                      <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=login" class="f-fr onusernumber">已有账号？</a>
                    <span class="qit">使用其他账户登录</span>
                    </div>
                    <?php }?>
                    <div class="cl login_other">
                        <?php if ($_smarty_tpl->tpl_vars['_G']->value['setting']['weibo_appkey']) {?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=weibo_login" class="weibo" id="sina_login_btn"><em class="wb_bg"></em>微博登录</a>
                        <?php }?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['_G']->value['setting']['qq_appkey']) {?>
                         <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=qq_login" class="qq" id="qq_login_btn"><em class="qq_bg"></em>QQ登录</a>
                        <?php }?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['_G']->value['setting']['taobao_appkey']) {?>
                          <a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=member&a=taobao_login" class="tb" id="taobao_login_btn"><em class="tb_bg"></em>淘宝登录</a>
                        <?php }?>
                    </div>
                  
                </div>
                
<?php }?>
                
            </div>
        </div>
    </div>
    <div id="flash" class="member_hdp">
        <div class="banner-show" id="js_ban_content">
            <div class="cell bns-01" ><div class="con"></div></div>
            <div class="cell bns-02" ><div class="con"></div></div>
            <div class="cell bns-03" ><div class="con"></div></div>
            <div class="cell bns-04" ><div class="con"></div></div>
            <div class="cell bns-05" style=" display:block;"><div class="con"></div></div>
        </div>
        <div class="banner-control" id="js_ban_button_box" >
            <a href="javascript:;" class="onleft">左</a>
            <a href="javascript:;" class="onright">右</a>
        </div>
    </div>
</div>


<?php echo $_smarty_tpl->getSubTemplate ("../../".((string)$_smarty_tpl->tpl_vars['TPLNAME']->value)."/footer.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
