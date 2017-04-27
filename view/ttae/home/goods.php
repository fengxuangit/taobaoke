{include file="../header.php"}
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/home_goods_list.css" media="all" />
<link rel="stylesheet" type="text/css" href="{$CSSDIR}/apply.css" media="all" />
{include file="../apply/hd.php"}
<div class="index2_box cl" >
 {foreach from=$goods item=v key=k}
<div class="by_end cl">
	<div class="nav_p_top cl">

              <span>报名时间：<i  class="_dgmdate" data-time="{$v.dateline}"></i>&nbsp;&nbsp;</span>
          
              <em>审核结果：<i>{$v.check_status}</i>
               {if  $v.check !=1 }
             	<a href="{$URL}m=home&a=apply_post&id={$v.id}">编辑</a>
                <a href="{$URL}m=home&a=apply_del&id={$v.id}" class="_confirm" data-msg="你确认是否删除当前商品">删除</a>
             	{/if}
              </em>
    </div>
	<div class="nav_pq cl">
		<div class="p_img">		
		<a href="{$v.org_url}"><img width="90" height="90" src="{$v.picurl}_100x100.jpg"></a>
		</div>
		<ul class="p_text _hover_img">
			<li class="">
				<a href="{$v.url}" target="_blank">{$v.title}</a>
                <a href="{$v.picurl}" target="_blank"><img  src="{$v.picurl}"></a>
			</li>
			<li>
				<span>所属分类：{$v.channel_name}</span>
				<span>原价：<b>{$v.price}</b>元</span>
				<span>活动价：<b>{$v.yh_price}</b>元</span>
			</li>
			<li>  
				<span>佣金比例：{$v.bili}%</span>
				<span>上线时间：<i  class="_dgmdate" data-time="{$v.start_time}"></i> - <i  class="_dgmdate" data-time="{$v.end_time}"></i></span>
			</li>
		</ul>
    </div>
    <div class="pdly cl"><span>审核留言:</span>{$v.check_msg}</div>
    <div class="clear"></div>

</div>

{/foreach}

</div>
<!--分页会因为上面的浮动而有点走位,关掉div的结束,重开始-->

<div class="cl redpage">{$showpage}</div>

{include file="../footer.php"}