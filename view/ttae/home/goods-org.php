{include file="./home_header.php"}





 <div class="uc_scored1">

              <span style="float: left">我的报名商品</span>

              <span style="float: right; font-size: 12px;"></span>

</div>





<ul class="uc_scoredtab" style="background-color: rgb(245, 245, 245);">

            <li class="uc_scoreli2" style="width:340px;"><b>标题</b></li>

            <li class="uc_scoreli4" style="width:80px"><b>报名价格</b></li>

            <li class="uc_scoreli4" style="width:80px"><b>状态</b></li>

            <li class="uc_scoreli2"  style="width:100px"><b>报名时间</b></li> 

            <li class="uc_scoreli4" style="width:80px"><b>编辑</b></li>



</ul>



 {foreach from=$goods item=v key=k}

<ul class="uc_scoredtab" {if $k%2==1}style="background-color: rgb(245, 245, 245);"{/if}>

            <li class="uc_scoreli2 _hover_img"  style="width:340px;">

           

            {if $v.status == 1}<a href="{$v.url}" target="_blank">{$v.title}</a>{else}{$v.title}{/if}

            <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>

            </li>

             <li class="uc_scoreli4"  style="width:80px">{$v.yh_price}</li>

             <li class="uc_scoreli2"  style="width:80px">

             <a href="{$URL}m=apply&a=apply_check_ajax&id={$v.num_iid}" class="_ajax_dialog"><i style="color: #e32014">{$v.status_text}</i></a></li>

            <li class="uc_scoreli3  _dgmdate" data-time="{$v.posttime}" title="{$v.desc}" style="width:100px"></li>

             <li class="uc_scoreli4" style="width:80px"><b>

             {if  $v.check ==0 || $v.check==2}

             <a href="{$URL}m=home&a=post&aid={$v.aid}">编辑</a>

             {/if}

             </b></li>

 </ul>

{/foreach}



</div></div>

<!--分页会因为上面的浮动而有点走位,关掉div的结束,重开始-->

<div class="cl redpage">{$showpage}</div>

<div><div>



{include file="./home_footer.php"}