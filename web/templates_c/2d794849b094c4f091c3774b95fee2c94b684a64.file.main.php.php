<?php /* Smarty version Smarty-3.1.15, created on 2017-04-27 11:12:35
         compiled from "/Users/apple/wwwroot/webapp/tae/view/admin/login/main.php" */ ?>
<?php /*%%SmartyHeaderCode:87151103590161a3ad7031-96881405%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d794849b094c4f091c3774b95fee2c94b684a64' => 
    array (
      0 => '/Users/apple/wwwroot/webapp/tae/view/admin/login/main.php',
      1 => 1493218591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '87151103590161a3ad7031-96881405',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TPLDIR' => 0,
    'CURMODULE' => 0,
    'CURACTION' => 0,
    'message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_590161a3b69558_47031472',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590161a3b69558_47031472')) {function content_590161a3b69558_47031472($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../../common/header.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['TPLDIR']->value;?>
/login/login.css" media="all" />


<a href="#" class="close_pic"></a>
<div class="login_box">
	<div class="logo"><a href="/">&nbsp;</a></div>
    <form enctype="multipart/form-data" action="" method="post"  name="login">
    <div class="login_form">
    	<div class="user">
        	<input class="text_value" value="" name="username" type="text" placeholder="用户名">
            <input class="text_value" value="" name="password" type="password"  placeholder="密码">
        </div>
        <input type="hidden" name="login" value="1" />
        <input type="submit" value="登录" name="login_submit"  class="button"/>
    </div>
<input type="hidden" name="m" value="<?php echo $_smarty_tpl->tpl_vars['CURMODULE']->value;?>
" />
<input type="hidden" name="a" value="<?php echo $_smarty_tpl->tpl_vars['CURACTION']->value;?>
" />
    </form>
    <div class="tip"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div>
    <div class="foot">
	Copyright &copy; 2014.Company <a href="http://www.hbkfz.cn" target="_blank" >湖北开发者网络科技有限公司</a> All rights reserved 
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../../common/footer.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
