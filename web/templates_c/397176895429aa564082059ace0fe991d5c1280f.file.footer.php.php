<?php /* Smarty version Smarty-3.1.15, created on 2017-04-26 23:54:15
         compiled from "/Users/apple/wwwroot/webapp/tae/view/ttae/footer.php" */ ?>
<?php /*%%SmartyHeaderCode:3474653015900c2a7b1e3d5-69531322%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '397176895429aa564082059ace0fe991d5c1280f' => 
    array (
      0 => '/Users/apple/wwwroot/webapp/tae/view/ttae/footer.php',
      1 => 1493218591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3474653015900c2a7b1e3d5-69531322',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_G' => 0,
    'IMGDIR' => 0,
    'URL' => 0,
    'CM' => 0,
    'CURMODULE' => 0,
    'v' => 0,
    'goods' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5900c2a7b67235_10375798',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5900c2a7b67235_10375798')) {function content_5900c2a7b67235_10375798($_smarty_tpl) {?><div style="clear:both;"></div>

<!--底部menu-->
 <div style="width: 100%; height: 30px;border-bottom: 1px solid #eee"></div>
<!--底部-->
<div class="hpz_bottom">
    <a href="<?php echo $_smarty_tpl->tpl_vars['_G']->value['siteurl'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['IMGDIR']->value;?>
/logo2.png"></a>
    <ul>
        <li class="hpz_bottomli1"><h1>关于我们</h1></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=article&id=1" target="_blank">公司简介</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=article&id=2" target="_blank">联系我们</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>商务合作</h1></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=apply&a=info" target="_blank">商家报名</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=home&a=goods" target="_blank">报名查询</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>下次怎么来</h1></li>
        <li><a href="#" class="_addfavorite">Ctrl+D加入收藏</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=desktop">下载桌面快捷方式</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
mobile=yes">手机版</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>关注我们</h1></li>
        <li class="hpzfootobj"><i class="indexiocns index_icon9" style="background-position: -300px -121px;"></i><a href="#" >&nbsp;微淘</a></li>
        <li class="hpzfootobj"><i class="indexiocns index_icon10" style="background-position: -320px -121px;"></i><a href="#">&nbsp;微信</a></li>
        <li><i class="indexiocns index_icon11" style="background-position: -113px -121px;"></i><a href="#" target="_blank">&nbsp;微博</a></li>
    </ul>
    <ul>
        <li class="hpz_bottomli1"><h1>帮助中心</h1></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=article&id=3" target="_blank">新手上路</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=article&id=5" target="_blank">积分问题</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
m=article&id=6" target="_blank">常见问题</a></li>
    </ul>


</div>


<div class="hpz_bottomtext">
    <?php echo $_smarty_tpl->tpl_vars['_G']->value['setting']['copyright'];?>
  <?php echo $_smarty_tpl->tpl_vars['_G']->value['runtime'];?>

    
</div>



<!--右边栏-->

<div class="rightnfixd">
    <span>
    <a href="#" class="rfixedico rightnfixda1"></a>
    <a class="rfixedico rightnfixda2"></a>
    <a href="javascript:;"  class="rfixedico rightnfixda3 _addfavorite"></a>
    </span>
    <i class="rfixedico rightnfixdspan1"><img src="<?php echo $_smarty_tpl->tpl_vars['IMGDIR']->value;?>
/wt.png"  /></i>
</div>

<?php if ($_smarty_tpl->tpl_vars['_G']->value['setting']['left_bar']==1) {?>
<?php if ($_smarty_tpl->tpl_vars['CM']->value=='index'||$_smarty_tpl->tpl_vars['CM']->value=='channel') {?>
<!--悬浮框-->
<div class="menufixd" style="<?php if ($_smarty_tpl->tpl_vars['CURMODULE']->value=='home') {?>display:none;<?php }?>">
    <h3 class="menufixedlog" style="display: block;"></h3>
    <span></span>
    <h1>商品分类</h1>	
        <ul class="fixedmenu1 cl">
 	  <li class="indexajaxlink" ><a href="<?php echo $_smarty_tpl->tpl_vars['_G']->value['siteurl'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['_G']->value['fid']==0) {?>fixedselect<?php }?>">全部</a></li>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_G']->value['channels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
         <?php if ($_smarty_tpl->tpl_vars['v']->value['hide']==0) {?>
         <li><a href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
fid=<?php echo $_smarty_tpl->tpl_vars['v']->value['fid'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['_G']->value['fid']==$_smarty_tpl->tpl_vars['v']->value['fid']) {?>fixedselect<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
         <?php }?>
         <?php } ?>
         
        <li><a class="" href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=tomorrow">预告</a></li>
        <li ><a  href="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
a=over">即将结束</a></li>
    </ul>
    <ul class="fixedmenu2_1 cl">
    
<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_G']->value['nav']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['v']->value['type']=="3") {?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" class="iconfont  <?php echo $_smarty_tpl->tpl_vars['v']->value['classname'];?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value['target']=="1") {?> target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</a></li>
<?php }?>
<?php } ?>
       
         
    </ul>

</div>
<?php }?>	
<?php }?>
<div class="share_box_menu" style="display:none">
 <table cellpadding="0" cellspacing="0" class="fwin">
    <tbody>
      <tr>
        <td class="t_l"></td>
        <td class="t_c"></td>
        <td class="t_r"></td>
      </tr>
      <tr>
        <td class="m_l"></td>
        <td class="m_c fwin_content_sign"><h3 class="flb"><em>提示</em><span> <a title="关闭" class="fwin_window_close_sign flbc _hideMemu" target="_blank">关闭</a> </span></h3>
          <div class="content_box_0"><div class="_share" data-style="2" data-more="0" data-count="0" data-picurl="<?php echo $_smarty_tpl->tpl_vars['goods']->value['picurl'];?>
" style="  padding: 20px 0 0 100px;"></div></div>
          
          </td>
        <td class="m_r"></td>
      </tr>
      <tr>
        <td class="b_l"></td>
        <td class="b_c"></td>
        <td class="b_r"></td>
      </tr>
    </tbody>
  </table>
</div>
<!--<div class="share_box hide">
<div class="_share" data-style="2" data-more="0" data-count="0"></div></div>
</div>-->

<?php echo $_smarty_tpl->getSubTemplate ("../common/footer.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
