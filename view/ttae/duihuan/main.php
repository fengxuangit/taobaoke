{include file='../header.php'}

{$CSS}

<div class="score_body">
  <div class="score_producte">
    <div class="score_producte_dobk">
      <div class="score_producte_dobkl">
        <div class="score_dobkl_title"> <a href="{$URL}m=home&a=duihuan" target="_blank">我的兑换&gt;</a>
          <ul class="score_dobkl_titleNav">
            <li><a href="{$URL}m=duihuan&a=list">积分兑换</a></li>
            <li>&lt;</li>
            <li><a href="{$URL}m=duihuan&a=list#exchange">女装</a></li>
            <li>&lt;</li>
            <li>详情</li>
          </ul>
        </div>
        <div class="score_dobkl_cont">
          <p class="leftImg"><img src="{$goods.picurl}_350x350.jpg" width="350" height="350"></p>
          <div class="score_dobkl_cont_explain">
            <h4><em>[{$goods.jf}积分]</em>{$goods.title}</h4>
            <ul class="list">
              <li>积分：<em><i>{$goods.jf}</i>积分</em></li>
              <li>价值：￥{$goods.price}</li>
              <li>库存：{$goods.sum - $goods.num}件</li>
            </ul>
            <div class="but  {if $goods.status >1}disable{/if}"> {if $goods.status >1} <a  class="now disable" >{$goods.status_text}</a> {elseif !$_G.uid} <a  class="showdialog disable now" data-msg="未登录无法进行兑换操作" >未登录</a> {elseif $_G.member.jf>=$v.jf} <a href="#" class="now duihuan_start" data-id="{$goods.id}" >立即兑换</a> {else} <a href="{$URL}m=duihuan&a=apply&id={$goods.id}" data-msg="您的积分不足{$goods.jf},无法申请兑换" class="showdialog now" >积分不足</a> {/if} </div>
          </div>
          <div class="miaoshu">
            <ul>
              <li class="dbli dbli1 dbseclect" data-index="0">商品详情</li>
              <li class="dbli dbli1" data-index="1">兑换规则</li>
              <li class="dbli dbli1" data-index="2">注意事项</li>
              <li class="dbli dbli1" data-index="3">已成功兑换</li>
               <li class="dbli dbli1" data-index="4">评论</li>
            </ul>
          </div>
          <div class="dbmiaoshuobj" style="display: block" > {$goods.content} </div>
          <div class="dbmiaoshuobj" style="display: none">
         
         
         
          <p>
    <br/>
</p>
<p>
    <br/><span style="font-size:14px;"><span style="font-family: 宋体;">1、本站注册会员均可通过积分换购礼品。&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;<br/><br/>
	2、所有的商品均可享受包邮，您不用承担任何费用。&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;<br/><br/>
	3、一旦进行积分兑换，消耗的积分不予返还。&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;<br/><br/>
	4、兑换后，我们会在7个工作日内完成发货，详情见个人中心---兑换中心。&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>
	5、同一商品每个用户仅允许兑换一件。&nbsp;&nbsp; </span></span>
</p>
          </div>
          <div class="dbmiaoshuobj" style="display: none"> 兑换后，我们会在7个工作日内完成发货，详情见个人中心---兑换中心。            
同一商品每个用户仅允许兑换一件。  </div>
          <div class="dbmiaoshuobj" style="display: none">
            <div class="cgdh">
              <ul>
                {foreach from = $duihuan_success item=v}
                <li><img src="{$v.user.picurl}" width="80" height="80"/>
                  <p>{$v.user.nick}</p>
                </li>

                {/foreach}
              </ul>
            </div>
          </div>
           <div class="dbmiaoshuobj" >
<div class="_duoshuo" data-id="{$goods.id}"  data-name="{$_G.setting.duoshuo}" style="margin-top:30px;"></div>
            </div>
          
        </div>
      </div>
      <div class="score_producte_dobkr">
        <h3>积分兑换</h3>
        <ul class="score_producte_listUl rightBlock">
          {foreach from=$duihuan_goods item=v}
          <li>
            <div class="score_listUl_img"> <a href="{$v.id_url}"><img src="{$v.picurl}_220x220.jpg" width="215" height="215"></a>
              <p><a href="{$v.id_url}">{$v.title}</a></p>
              <div class="score_listUl_but"> <a href="{$v.id_url}">立即兑换</a>
                <p><em>￥{$v.price}</em>剩余{$v.sum -$v.num}件</p>
                <p><i class="colorRed">{$v.jf}</i>积分</p>
              </div>
            </div>
          </li>
          {/foreach}
        </ul>
      </div>
    </div>
  </div>
</div>





 
<div class="duihuan_box cl duihuan_box_menu" style="display:none; position:fixed;">
  <div class="duihuan_box_close"></div>
  <div class="duihuan_box_m cl">
    <ul>
      <form action="" method="post">
        <li style="font-size:14px;color:#F00;">请填写收货信息,方便我们审核成功后直接发放的宝贝给您</li>
        <li><span>旺旺:</span>
          <input type="text" name="postdb[wangwang]" value="{$_G.member.wangwang}"  class="check_text"  data-reg="wangwang" style="width:200px">
        </li>
        <li><span>姓名:</span>
          <input name="postdb[truename]"  value="{$_G.member.name}" type="text" class="check_text"   data-reg="truename" style="width:200px">
        </li>
        <li><span>联系电话:</span>
          <input name="postdb[phone]" type="text" value="{$_G.member.phone}" class="check_text" data-reg="phone" style="width:200px">
        </li>
        <li><span>地址:</span>
          <input name="postdb[address]" type="text" value="{$_G.member.address}" class="check_text" data-type="address" style="width:200px">
        </li>
        <li><span>支付宝:</span>
          <input name="postdb[alipay]" type="text" value="{$_G.member.alipay}" class="check_text" data-type="alipay" style="width:200px">
        </li>
       

        <li><span>&nbsp;</span>
          <input type="submit" value="提交申请" name="onsubmit" class="btn _check_form" >
        </li>
        <input type="hidden"  value="{$goods.id}" class="shiyong_id" name="id" />

        <input type="hidden" name="m" value="{$CM}" >
        <input type="hidden" name="a" value="apply" >
      </form>
    </ul>
  </div>
</div>




{include file='../footer.php'} 

