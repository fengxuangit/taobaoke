<?php /* Smarty version Smarty-3.1.15, created on 2017-04-26 23:54:15
         compiled from "/Users/apple/wwwroot/webapp/tae/view/ttae/goods_list.php" */ ?>
<?php /*%%SmartyHeaderCode:7234542635900c2a7acc569-81290173%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b21c3e437dcfffa14042445f261c2e7d3e56c03b' => 
    array (
      0 => '/Users/apple/wwwroot/webapp/tae/view/ttae/goods_list.php',
      1 => 1493218591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7234542635900c2a7acc569-81290173',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'goods' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.15',
  'unifunc' => 'content_5900c2a7b1ad64_80974123',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5900c2a7b1ad64_80974123')) {function content_5900c2a7b1ad64_80974123($_smarty_tpl) {?>  <div class="i2_goodscond ">
        <ul class="i2_goodsul">

         <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
             <li class="i2_goodsli shadow">

                <div class="i2_goodsd">
                   <a class="daddfavorite" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['aid'];?>
"></a>
                   <?php if ($_smarty_tpl->tpl_vars['v']->value['new']==1) {?><i class="index2_ico i2_gdp1 i2_gnew0" style=""></i><?php }?>

                   <?php if ($_smarty_tpl->tpl_vars['v']->value['over']==1) {?><a class="i2_gdpover2"></a><?php }?>
                   <a class="i2_goodsjzbk" href="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_url'];?>
" target="_blank" >
                   <img width="250" height="250" src="<?php echo $_smarty_tpl->tpl_vars['v']->value['picurl'];?>
_250x250.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
"  class="ver_img" >
                   </a>
                   <a class="i2_goodsname" href="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a>


              <div class="cl">
                  <div class="i2_goodprice">
                        <span class="i2_gprw1">￥</span>
                        <b class="i2_gprw2"><?php echo $_smarty_tpl->tpl_vars['v']->value['yh_price']-$_smarty_tpl->tpl_vars['v']->value['juan_price'];?>
</b>
                          <div class="i2_gprw3">
                           <?php if ($_smarty_tpl->tpl_vars['v']->value['zk']>0) {?> <span class="index2_ico i2_gprw4"><?php echo $_smarty_tpl->tpl_vars['v']->value['zk'];?>
折</span><?php }?>
                             <?php if ($_smarty_tpl->tpl_vars['v']->value['price']>0) {?><del class="i2_gprw5">￥<?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
</del><?php }?>
                          </div>
                          <?php if ($_smarty_tpl->tpl_vars['v']->value['juan_url']) {?>
                          <div class="juan_btn"><a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['juan_url'];?>
"  rel="nofollow" target="_blank">领券</a></div>
                          <?php } else { ?>
                             <div class="goods_sum" >售:<?php echo $_smarty_tpl->tpl_vars['v']->value['sum'];?>
</div>
                          <?php }?>

                      </div>

                  <?php if ($_smarty_tpl->tpl_vars['v']->value['status']==3) {?>
                     <a class="i2_gbuybtn btgotobuy_isover4"  href="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" ><span><?php echo $_smarty_tpl->tpl_vars['v']->value['h'];?>
点开始</span></a>
                   <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status']==2) {?>
                     <a class="i2_gbuybtn btgotobuy_isover6"  href="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" >已下架</a>
                  <?php } else { ?>
                   <a class="i2_gbuybtn btgotobuy_isover1" href="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_url'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
">
                  去看看</a>

                  <?php }?>
            </div>

                


                </div>
            </li>
  <?php } ?>
         </ul>

            <div style="clear:both;"></div>
         </div>
<?php }} ?>
