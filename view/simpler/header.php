{include file="../common/header.php"}
<link rel="stylesheet" href="//at.alicdn.com/t/font_noeq7zjgb0ggb9.css">
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/materialize.css" media="all" />

<link rel="stylesheet" type="text/css" href="assets/global/css/hover.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/ihover.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/tip.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/duoshuo.css" media="all" />
<link rel="stylesheet" type="text/css" href="assets/global/css/animator.min.css" media="all" />

<script src="{$JSDIR}/materialize.js"></script>
<style>
.wp{
    width:{$width}px;
}
</style>



<header class="cl">
    <div class="container wp" style="margin-top: 0;">


            <a href="{$_G.siteurl}" class="left logo" >
              <img src="{$_G.setting.logo}" alt="{$_G.setting.title}">
            </a>

            <div class="hd_search right hvr-underline-reveal">
                <form  action="{$URL}m=index&a=search" method="POST">

                  <button class="waves-effect waves-light btn right cyan lighten-3" type="submit" name="onsubmit" value="1">
                   <span class="iconfont icon-sousuo1"></span>
                  </button>
                   <input type="text" name="kw" id="" class="left search_input lighten-3 ">

                   <!--  <input type="hidden" name="a" value="search">
                    <input type="hidden" name="m" value="index"> -->
                </form>

            </div>


    </div>
</header>



<nav class="container wp">

<ul class="hide-on-med-and-down">
 <!-- <li ><a class="grey-text text-darken-3" data-activates='dropdown1' ><i class="iconfont icon-xiangxia right grey-text"></i>分类导航</a></li> -->

{foreach from=$_G.nav item=v}
    {if $v.type =="1"}
    <li class="hvr-float {$v.classname}"><a href="{$v.url}" class="grey-text text-darken-3" {if $v.target=="1"} target="_blank"{/if}>{$v.name}</a></li>
    {/if}
  {/foreach}

</ul>
</nav>

