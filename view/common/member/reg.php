{include file="../../$TPLNAME/header.php"}

<link rel="stylesheet" type="text/css" href="{$COMMONDIR}/member/main.css">

<div class="login_box reg_box">
    <div class="container">
        <div class="Login-box">
            <h2 class="Login-title">{$_G.setting.title}用户注册</h2>
            <div class="Login-form">
                <form class="Form" method="post">
                    <!--<p class="error" style="display:none">您输入的密码和账户名不匹配，请重新输入。</p>-->
                    <div class="cell">
                        <input type="text" name="username" id="js-mobile_ipt" class="text" placeholder="用户名" data-type="null" data-msg="用户名不能为空" >
                    </div>
                      
                    <div class="cell">
                        <input type="text" name="email" id="js-mobile_pwd_ipt" class="text" placeholder="邮箱" data-type="email">
                    </div>
                    
                    <div class="cell">

                        <input type="password" name="password" id="js-mobile_pwd_ipt" class="text" placeholder="输入密码" data-type="password">
                    </div>
                    <div class="cell">

                        <input type="password" name="password2" id="js-mobile_pwd_ipt" class="text" placeholder="确认密码" data-type="password" data-msg="确认密码不能为空">
                    </div>
                  
                    
                    <div class="cell">
                        <input type="text" name="phone" id="js-mobile_pwd_ipt" class="text" placeholder="手机号码" data-type="phone">
                    </div>
                    
              {if $_G.setting.reg_yzm ==1}

                 <div class="cell" style="margin-bottom:10px;">
                         <input type="text" class="text" name="yzm" style="width:140px;margin-right:10px;float:left;"  placeholder="请输入验证码" data-type="yzm">
                           <img   height="40" src="{$URL}m=ajax&a=yzm" class="yzm_img yzm">
                            <a class="yzm" href="#" >刷新</a>
                    </div>
                
                 {/if}
                 
                    
                    <div class="bottom"><a id="js-mobile_btn" going="0" href="javascript:;" class="button ff _check_form _onsubmit">注&nbsp;&nbsp;册</a></div>
                    <input type="hidden" name="reg_submit" value="1">
                    <input type="hidden" name="m" value="{$CM}">
                    <input type="hidden" name="a" value="{$CA}">
                    <input type="hidden" name="referer" value="{$_G.referer}">
                    
                </form>
                

                <div class="qita">
                 {if $CA=='reg'}
               		 <div class="cl">
                      <a href="{$URL}m=member&a=login" class="f-fr onusernumber">已有账号？</a>
                    <span class="qit">使用其他账户登录</span>
                    </div>
                    {/if}
                    {if $_G.setting.weibo_appkey || $_G.setting.qq_appkey || $_G.setting.taobao_appkey}
                    <div class="cl login_other">
                        {if $_G.setting.weibo_appkey}
                        <a href="{$URL}m=member&a=weibo_login" class="weibo" id="sina_login_btn"><em class="wb_bg"></em>微博登录</a>
                        {/if}
                        
                        {if $_G.setting.qq_appkey}
                         <a href="{$URL}m=member&a=qq_login" class="qq" id="qq_login_btn"><em class="qq_bg"></em>QQ登录</a>
                        {/if}
                        
                        {if $_G.setting.taobao_appkey}
                          <a href="{$URL}m=member&a=taobao_login" class="tb" id="taobao_login_btn"><em class="tb_bg"></em>淘宝登录</a>
                        {/if}
                    </div>
                    {/if}
                   
                </div>

                
                
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


         
    


    

{include file="../../$TPLNAME/footer.php"}