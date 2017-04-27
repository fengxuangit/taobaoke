<?php /* Smarty version Smarty-3.1.15, created on 2017-04-27 11:18:40
         compiled from "/Users/apple/wwwroot/webapp/tae/view/admin/admin/main.php" */ ?>
<?php /*%%SmartyHeaderCode:1895120233590163102f4793-75061261%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c17d54ac74dd53f388aa2617bfa367e557b9095' => 
    array (
      0 => '/Users/apple/wwwroot/webapp/tae/view/admin/admin/main.php',
      1 => 1493218591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1895120233590163102f4793-75061261',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info' => 0,
    'v' => 0,
    'CURMODULE' => 0,
    'CURACTION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5901631035dcb0_22767380',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5901631035dcb0_22767380')) {function content_5901631035dcb0_22767380($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ('../common_admin/left_bar.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<form enctype="multipart/form-data" name="channel_add" method="post">

  
<div class="table_main" >
<table class="tb tb2 fixpadding">
<tbody>
<tr><th colspan="5" class="partition">系统信息</th></tr>

<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<tr  <?php if ($_smarty_tpl->tpl_vars['v']->value['color']==1) {?> style="background:#f00"<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['bg']==1) {?> style="background:#eee"<?php }?>>
<td class="vtop td24 lineheight " <?php if ($_smarty_tpl->tpl_vars['v']->value['color']==1) {?> style="color:#fff"<?php }?>>&nbsp;<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
<td class="lineheight smallfont"  <?php if ($_smarty_tpl->tpl_vars['v']->value['color']==1) {?> style="color:#fff"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
</td>
</tr>
<?php } ?>
	</tbody>
	</table>  
    
  </div>

<input type="hidden" name="m" value="<?php echo $_smarty_tpl->tpl_vars['CURMODULE']->value;?>
" />
<input type="hidden" name="a" value="<?php echo $_smarty_tpl->tpl_vars['CURACTION']->value;?>
" />
</form>

<?php echo $_smarty_tpl->getSubTemplate ('../common_admin/right_bar.php', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <?php }} ?>
