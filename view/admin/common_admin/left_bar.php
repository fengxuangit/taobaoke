{include file="../../common/header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/admin2.css" media="all" />

<div class="admin cl " data-version="{$_G.version}" data-updatetime="{$_G.update_time}" >

<table cellpadding="0" cellspacing="0" width="100%" height="100%" style="width: 100%;">
<tbody>
  <tr>
    <td valign="top" width="160" class="menutd "><a href="{$URL}" title="uz-system.com" ><img src="{$IMGDIR}/logo.png" /></a>
      <div id="leftmenu" class="menu"> 
      
      
      {foreach from=$_G.menu item=nav key=key}
      {foreach from=$nav.nav item=v key=k name = menu}
          {if $SYSTEM_TYPE >=$nav.type && $smarty.foreach.menu.index ==0 && $nav.select ==1}
                <div class="line"></div>
                <ul {if $CURMODULE==$key}class="on"{/if}>          
                  <li><a {if $CURMODULE==$key && $CURACTION==$k } class="tabon" {/if} href="{$URL}m={$key}&a={$v.a}"   ><em  title="打开"></em>{$nav.name}</a></li>
                </ul>
         {/if}
          {/foreach}
        {/foreach} </div>
      <div class="line"></div>
      <div class="copyright">
        <p>Copyright © 2014</p>
        <p><a target="_blank" href="http://www.uz-system.com">www.uz-system.com</a></p>
        <p><a target="_blank" href="http://www.hbkfz.cn/">湖北开发者网络科技</a></p>
        <p>版本: v{$_G.version} {$_G.update_time}</p>
        <p>技术qq: <a  class="_qq" data-qq="85914984" data-img="0">85914984</a></p>
        <p>客服qq: <a  class="_qq" data-qq="2076814361" data-img="0">2076814361</a></p>
        
        <p>qq群交流: <a href="http://shang.qq.com/wpa/qunwpa?idkey=eb99dac6ce6afa2399fb63cbd3929fd12cbdc52fc3693da2af150ac79ae7f43c" target="_blank">229255390</a></p>
      
         <p><a href="http://help.uz-system.com" target="_blank" class="red">帮助中心</a>
        <a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=9ZGqlpiGtYSE25aamA" class="red">意见反馈</a>
         </p>
      </div></td>
    <td valign="top" width="100%" class="mask"><div class="admin_main cl">
    
    
<div class="itemtitle">
  <div class="y right_bar">
    <ul>
    
      <li><a href="{$_G.siteurl}" target="_blank" class="red">查看站点</a></li>
       <li><a href="{$URL}" >后台首页</a></li>
      <li><a href="{$URL}m=login&a=logout" onclick="return confirm('您确定退出登录?')">退出登录</a></li>
      <li>当前版本:v{$_G.version} {$_G.update_time}</li>      
    </ul>
  </div>
  
{foreach from=$menu item=nav key=key  }
{if $CURMODULE == $key}
 		<h3>{$nav.name}</h3>
        <ul class="tab1">
        
 
        
          {foreach from=$nav.nav item=v key=k}
          		{if !$v.type || $v.type<=$SYSTEM_TYPE }
                    {if $v.select =='1'}
                      <li {if $CURACTION==$v.a}class="current"{/if}> <a href="{$URL}m={$key}&a={$v.a}"><span>{$v.name}</span></a></li> 
                   {/if}
                   
               {/if}
          {/foreach}
        </ul>
  {/if}
{/foreach} 
</div>

  <!--main start-->
      
