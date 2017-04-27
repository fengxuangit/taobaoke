<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class goods extends app{
	public function main(){
			global $_G;



			$aid = $_GET['aid'] ? ($_GET['aid']) : get_goods_id($_GET['itemid']);

			if($aid && $aid<1) {
				msg('抱歉ID不存在');
			}

			if( $_GET['aid']){
				$aid = intval($aid);
				$goods = D(array('and'=>"aid = ".$aid ,'limit'=>1,'key'=>'goods_'.$aid));
			}else{
				$goods = D(array('and'=>"num_iid = '$aid'",'limit'=>1,'key'=>'goods_'.$aid));
				
			}

			if(!$goods['aid'] ){
				msg('抱歉,当前商品已下架或未审核暂时无法查看');
			}
			$apply = false;
			if(isset($_GET['apply'])){
				dsetcookie('apply',1,86400*2);
				$apply = true;
			}else if(getcookie('apply') ==1){
				$apply = true;
			}
			
			if($apply){
				$this->add(array('goods' => $goods));
				$title = $goods['seo_title'] ? $goods['seo_title'] :$goods['title'];
		        seo($title, $goods['keywords'], $goods['description']);
		        $this->show('goods/apply');
			}

			if(isset($_GET['focus'])){	//强制要展示详情页

			}else if($_G[mobile] || !$_G['setting']['show_goods'] || (!ROBOT && $_G[setting][robot_jump] ==1)){
				if($goods['juan_url']){
					$url = $goods['juan_url'];
				}else{
					$url = $goods['url'];
				}
				if(stripos($_SERVER['HTTP_USER_AGENT'],'micromessenger') !== false){
						$url = 'assets/common/jump.html?jumpurl='.$url;
				}
				_header("Location:".$url);
				exit;
			}

			if( $goods['fid']) $channel =$_G['all_channel']['k'.$goods[fid]];

			$tpl  = '';
			if($channel)$tpl = trim($channel['goods_tpl']);

			$_G['channel']=$channel;

			if($goods[fid])$_G[fid] = $goods[fid];




      /*  $up = D(array('and' => ' AND aid <' . $goods['aid'], 'table' => 'goods', 'order' => 'aid DESC'));
        $down = D(array('and' => ' AND aid >' . $goods['aid'], 'table' => 'goods', 'order' => 'aid ASC'));

        $goods[up] = $up[id] ? '<a href="' . $up[id_url] . '">' . $up[title] . '</a>' : '没有了';
        $goods[down] = $down[id] ? '<a href="' . $down[id_url] . '">' . $down[title] . '</a>' : '没有了';*/

        $this->add(array('goods' => $goods, 'up' => $up, 'down' => $down));


		save_history(__CLASS__,$goods['aid']);
		$title = $goods['seo_title'] ? $goods['seo_title'] :$goods['title'];
        seo($title, $goods['keywords'], $goods['description']);
        $this->show($tpl);
    }


    function like(){
        global $_G;
        $rs = $this->_like('goods','like',$_G['id']);
        json($rs);
    }

    /**
     * 自动更新优惠券
     * @return [type] [description]
     */
     function auto_update(){
    		
    }


}
?>
