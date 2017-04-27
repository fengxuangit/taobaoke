



</div>



</div>


<div class="wp cl">
    {if $history}
<div class="ppt_goodscontent">
     <a class="left_btn"></a>
     <div class="ppt_box">
             <div class="ppt_box_m">
            {foreach from=$history item=v}     
             <div class="ppt_goodsd">
                 <a href="{$v.url}"  target="_blank"><img width="220" height="220" src="{$v.picurl}_220x220.jpg"></a>
                 <i class="newindexicon ppt_dbico"></i>
                 <i class="newindexicon ppt_dbicoh"></i>
                 <a class="ppt_gtit" href="{$v.url}" target="_blank">{$v.title}</a>
                 <div class="ppt_ginfo">
                    <ul>
                        <li><b>￥</b><span>{$v.yh_price}</span></li>
                        <li><del>￥{$v.price}</del></li>
                    </ul>
                 </div>
                 <a href="{$v.url}" target="_blank" class="ppticons pptgobuy ppt2btn"></a>
             </div>
          {/foreach}        
          </div> 
  </div>
   <a class="right_btn"></a>
</div>
     {/if}
</div>



{include file="../footer.php"}          

    

