{include file="../header.php"}

<link rel="stylesheet" type="text/css" href="{$CSSDIR}/apply.css" media="all" />

<div style="background:#F2F2F2" class="cl">



{include file="./hd.php"}







{if !$_GET.t}
<div class="cl _auto_ad" data-picurl="{$_G.ad.k9.picurl}"></div>
{/if}

    

<div class="nav_3 w1000 cl">

{if !$_GET.t}


    <div class="pro_li">

		<div class="biaoti">9块9包邮劲爆秒杀</div>

		<div class="main">价格必须9.9元以下并包邮,少数偏远地区可不包邮商品市场价值在20元以上。集市店信誉3钻以上,天猫店不限,商品必须有20条以上真实好评、无较差评价,月销交易成功量需为50件以上, </div>

		<div class="botom">

				<a href="{$URL}m=apply">活动报名</a>

				</div>

   </div>

	<div class="pro_li marginleft">

    <div class="biaoti">19块9包邮</div>

		<div class="main">价格必须19.9元以下并包邮,少数偏远地区可不包邮商品市场价值在30元以上。集市店信誉1钻以上,天猫店不限,商品必须20条以上真实好评、无较差评价, 月销交易成功量需为50件以上, </div>

        <div class="botom">

				<a href="{$URL}m=apply">活动报名</a>

		</div>

    </div>

    <div class="pro_li marginleft">

        <div class="biaoti">品牌店铺</div>

        <div class="main">

                 品牌秒杀是针对知名品牌商，推出的全方位多角度的推广方案。{$_G.setting.title}会根据品牌制定符合品牌定位的推广方案，最大限度的将品牌价值传递给网站用户。 报名前联系客服

		</div>

		<div class="botom"><a href="{$URL}m=apply">活动报名</a></div>

    </div>    



{elseif $_GET.t == 'yq'}

		{$_G.ad.k5.show_html}

{elseif $_GET.t == 'sh'}

		{$_G.ad.k6.show_html}

{elseif $_GET.t == 'hz'}

		{$_G.ad.k7.show_html}

{/if}

 <div class="clear"></div>

<div class="cl kefuqq">
<a >报名咨询:</a>
{foreach from=$_G.setting.qq item=v}
<a href="" data-qq="{$v}" class="_qq"></a>
{/foreach}

</div>

</div>



{include file="../footer.php"}