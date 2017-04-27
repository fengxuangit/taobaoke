<?php
if(!defined('IN_TTAE')) exit('Access Denied FROM UZ-SYSTEM'); 
$sql = DB::out(false,true);
$user_agent = daddslashes($_SERVER['HTTP_USER_AGENT']);
?>
<div class="uz_system_debug cl">
  <div class="uz_info cl">
    <div class="info_list">
      <div class="info_con">
        <h1>uz-system debug info</h1>
      </div>
    </div>
    <div class="info_list">
      <div class="tit">系统版本</div>
      <div class="info_con">
        <div class="y hide"><a href="#">TOP</a>&nbsp;&nbsp;
        <a href="<?php echo URL ?>?m=tools&a=clear_cache&type=goods" class="ajax_dialog">清空商品调用缓存</a>&nbsp;&nbsp;
        <a href="<?php echo URL ?>?m=tools&a=clear_cache&type=system" class="ajax_dialog">清空系统缓存</a>&nbsp;&nbsp;
         <a href="<?php echo URL ?>?m=tools&a=clear_cache&type=user" class="ajax_dialog">清空用户缓存</a>&nbsp;&nbsp;</div>
        uz-system <?php  echo TTAE_VERSION . '&nbsp;&nbsp;&nbsp;'; echo TTAE_UPDATE_TIME; ?>&nbsp;&nbsp;&nbsp;&nbsp;by 
        <a href="//www.uz-system.com" target="_blank">http://www.uz-system.com</a>&nbsp;&nbsp;&nbsp;&nbsp;
        系统执行时间:<?php echo (microtime(true) - $_G['starttime']);?> </div>
    </div>
   
    <div class="info_list">
      <div class="tit">当前模块</div>
      <div class="info_con"><?php  echo CURSCRIPT .'::'.CURMODULE ; ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php  echo dgmdate(TIMESTAMP,'dt'); ?>
      </div>
    </div>
   
    <div class="info_list">
      <div class="tit">SQL信息</div>
      <div class="info_con global_list">( <span class="red"><?php  echo count($sql); ?></span> )<a href="#" class="debug_list">[SQL列表]</a></div>
    </div>
    <div class="info_list">
      <div class="tit">客户端信息</div>
      <div class="info_con">
        <p>IP:     <?php  echo $_G[clientip]; ?></p>
        <p>User Agent :     <?php  echo ($user_agent); ?></p>
      </div>
    </div>
     
    <div class="info_list">
      <div class="tit">缓存列表</div>
      <div class="info_con global_list">
	  <?php  
	  if(count($_G['memory_debug'])>0){
			foreach($_G[memory_debug] as $k=>$v){
				echo  '['.$k.'=>'.count($v).' ] ';
			}
	}
	  ?><a href="#"  class="debug_list">[当前为<?php echo $_G['cache_type'] ?>缓存]</a></div>
    </div>
    <div class="info_list">
      <div class="tit">用户缓存</div>
      <div class="info_con global_list">     
		<a href="#"  class="debug_list">[会员信息]</a>
		<?php
		if(count($_G[user])>0){
			foreach($_G[user] as $k=>$v){
				echo  "'".$k."'=>'".$v."',";
			}
		}
		; ?>
     
      </div>
    </div>
    
  
    
    <div class="info_list">
      <div class="tit">缓存列表</div>
      <div class="info_con global_list"><a href="#"  class="debug_list on" >[$_G]</a>
       <?php
	   		$i=6;
			foreach($_G[_config][cache_list] as $k=>$v){
				echo  '<a href="#" class="debug_list" data-index="'.($i++).'">'.$v.'</a>';
			}; 
		?>
      </div>
    </div>
  </div>
  <div class="uz_debug_info cl">
<div class="debug_info_list cl">
 <?php  debug($sql); ?>
</div>

<div class="debug_info_list "> <?php  dump($_G['memory_debug']); ?></div>
<div class="debug_info_list">  <?php  debug($_G['member']);?></div>
<div class="debug_info_list">  <?php  debug($_G); ?></div>
<?php
foreach($_G[_config][cache_list] as $v){
	echo  '<div class="debug_info_list  cl">';
	debug($_G[$v]);
	echo  '</div>';
}; ?>

  </div>
</div>
