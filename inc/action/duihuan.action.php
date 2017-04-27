<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class duihuan extends app{
	public function main(){
			global $_G;
			if(!$_GET['id']){
				msg('兑换商品ID不存在');
 				return false;
			}

			$id = intval($_GET[id]);

			$goods = D(array('table'=>'duihuan','and'=>'id='.$id,'key'=>'duihuan_'.$id));
			if(!$goods[id]){
				msg('抱歉,未找到兑换商品');
 				return false;
			}
			$duihuan_apply =array();
			if($_G[uid]){
				$duihuan_apply = D(array('table'=>'duihuan_apply','and'=>'uid='.$_G[uid]." AND duihuan_id=".$id));
			}
			$shop = $goods[shop];
			save_history(__CLASS__,$id);
			$this->add(array('goods'=>$goods,'duihuan_apply'=>$duihuan_apply,'shop'=>$shop));
			seo($goods[title] . '- 商品兑换');
			$this->show('duihuan/main');
		}

	function _list(){
			global $_G;

			if(isset($_GET[all])){

			}else{
				$and_time.= " AND start_time < ".TIMESTAMP;
				$and_time .= " AND ( end_time = 0 or  end_time > ".TIMESTAMP.")";
				$and = ' AND  `hide`=0 ' .$and_time;
				$url = '';
			}
			if(isset($_GET['tag']) && $_GET['tag']){
				$tag = intval($_GET['tag']);
				$and .=" AND   tag = ".$tag;
				$url .="&tag=".$tag;
			}

			if(isset($_GET['cate'])){
				$cate_id = intval($_GET['cate']);

				$cate = $_G['duihuan_cate'][$cate_id];
				$this->add(array('cate'=>$cate));
				$and .=" AND cate  in (".$cate['id_in'].")";
				$url.="&cate=".$cate_id;
				seo(!MOBILE ? $cate[title]:$cate['name'],$cate[keywords],$cate[description]);
			}else{

				$name = __CLASS__;
				seo($_G['setting'][$name.'_seo_tit'],$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);
			}


			$rs = D(array('and'=> $and,'order'=>' `sort` DESC,id DESC ','table'=>'duihuan','key'=>'duihuan_'.$_GET['tag']),
					array('url'=>URL."m=duihuan&a=list".$url,'size'=>20)
					);

			$this->add($rs);
			$this->show('duihuan/list');
	}



	function apply(){
			global $_G;

		$id = intval($_GET[id]);

		is_login();


		check_user_power();

		$rs  =  D(array('table'=>'duihuan_apply','and'=>" duihuan_id=".$id ." AND uid=".$_G[uid]));

		if($rs[id]>0){
			$rs[statustime] = dgmdate($rs[statustime]);
			$rs[dateline] = dgmdate($rs[dateline]);
			$msg = '抱歉,您已申请了兑换过本商品,无法再次申请,申请时间: <span class="red">'.$rs[dateline].'</span> <br/>';
			$msg .= '当前申请状态为: <span class="red">'.$rs[status_text].'</span>';

			$msg .= '<br/>客服最后操作时间: <span class="red">'.$rs[statustime].'</span>';
			msg($msg,'error','m=duihuan&id='.$id);
			return false;
		}
		$goods = D(array('table'=>'duihuan','and'=>'id='.$id));

		if($goods[hide]==1) {
			msg('抱歉,当前兑换商品已下架','error','m=duihuan&id='.$id);
			return false;
		}
		if($goods[start_time]>0 && $goods[start_time]>TIMESTAMP) {
			msg('抱歉,当前兑换未开始','error','m=duihuan&id='.$id);
			return false;
		}

		if($goods[end_time]>0 && $goods[end_time]<TIMESTAMP) {
			msg('抱歉,当前兑换已结束','error','m=duihuan&id='.$id);
			return false;
		}

		if($goods[num]>=$goods[sum]) {
			msg('抱歉,当前兑换已申请完毕','error','m=duihuan&id='.$id);
			return false;
		}

		$arr = get_filed('duihuan_apply',$_GET[postdb]);

		if(!$arr['wangwang']){
			msg('抱歉,联系旺旺不能为空','error','m=duihuan&id='.$id);
			return false;
		}


		if(!$arr['truename']){
			msg('抱歉,联系人姓名不能为空','error','m=duihuan&id='.$id);
			return false;
		}

		if(!$arr['address']){
			msg('抱歉,收货地址不能为空','error','m=duihuan&id='.$id);
			return false;
		}

		if(!$arr['phone']){
			msg('抱歉,联系电话不能为空','error','m=duihuan&id='.$id);
		}elseif(!is_phone($arr['phone'])){
			msg('抱歉,联系电话格式不正确','error','m=duihuan&id='.$id);

		}

		if($arr[alipay]){
			if(!is_email($arr[alipay]) && !is_phone($arr[alipay])){
				msg('抱歉,支付宝账号不正确,只能为邮箱或手机号码','error','m=duihuan&id='.$id);
			}
		}


		if($goods[jf]>0) {
			if($_G[member][jf]<$goods[jf]){
					msg('抱歉,当前兑换需要'.$goods[jf].'积分,您当前积分为'.$_G[member][jf].',无法申请兑换','error','m=duihuan&id='.$id);
					return false;
			}else{
				//更新用户积分..

					$jf  	=	0-$goods[jf];
					$add_jf = 	$_G['member']['jf']+$jf;
					$sid =insert_sign(array('desc'=>'申请兑换-'.$goods[title],'type'=>'duihuan','org_jf'=>$add_jf,'jf'=>$jf));
					if($sid){
							update_member(array('jf'=>$_G[member][jf]-$goods[jf]),$_G[uid]);
					}
			}
		}

		$arr['uid']  = $_G[uid];
		$arr['username']  = $_G[username];
		$arr['dateline']  = TIMESTAMP;
		$arr['ip']  = $_G[clientip];
		$arr['duihuan_id']  = $id;
		$arr = daddslashes($arr);
		DB::insert('duihuan_apply',$arr);
		msg('兑换申成功,请等待客服审核...','success','m=duihuan&id='.$id);



	}

}
?>
