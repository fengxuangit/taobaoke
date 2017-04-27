{include file="./home_header.php"}





 <div class="uc_scored1">

              <span style="float: left">我的兑换记录</span>

              <span style="float: right; font-size: 12px;"></span>

</div>





<ul class="uc_scoredtab" style="background-color: rgb(245, 245, 245);">

            <li class="uc_scoreli2" style="width:400px;"><b>标题</b></li>


            <li class="uc_scoreli4" style="width:80px"><b>剩余份证</b></li>

            <li class="uc_scoreli2"  style="width:100px"><b>状态</b></li>            
 <li class="uc_scoreli2"  style="width:100px"><b>最后操作时间</b></li>    


</ul>



 {foreach from=$goods item=v key=k}

<ul class="uc_scoredtab" {if $k%2==1}style="background-color: rgb(245, 245, 245);"{/if}>

            <li class="uc_scoreli2 _hover_img"  style="width:400px;"><a href="{$v.id_url}" target="_blank">{$v.title}</a>

            <a href="{$v.picurl}" target="_blank"><img src="{$v.picurl}"  /></a>

            </li>

             <li class="uc_scoreli4"  style="width:80px"><i style="color: #e32014">{$v.sum}</i></li>

             <li class="uc_scoreli2"  style="width:100px">{$v.status_text}  
             {if $v.status==1 && $v.content} <a href="#" class="_showDialog red"  data-msg="{$v.message}" >查看</a> {/if}</li>

            <li class="uc_scoreli2 _dgmdate" data-time="{$v.dateline}" title="{$v.desc}"  style="width:100px"></li>

 </ul>

{/foreach}



</div></div>

<!--分页会因为上面的浮动而有点走位,关掉div的结束,重开始-->

<div class="cl redpage">{$showpage}</div>

<div><div>



{include file="./home_footer.php"}