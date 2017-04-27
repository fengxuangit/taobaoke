<?php
if(!defined('IN_TTAE')) exit('Access Denied');

include_once ROOT_PATH.'inc/api/apiBase.class.php';

class api_wetao  extends apiBase{
    public $total = 0;

    //通过微淘接口批量获取商品信息
    function get($ids) {
        global $_G;
        $rs =$this->get_list((array)$ids);
        sort($rs);
        return $rs[0];
    }

	function get_list($ids){
         if(!class_exists('Curl')) include_once libfile('class/curl');
        $curl = new Curl();
       // $curl->debug = true;
        $curl->rand_ip();
        $referer = "http://we.taobao.com/daren/newUserFeed.htm";
        if(!$ids) return '商品id不能为空';

        if(is_string($ids)) $ids = explode(',',$ids);
        if(count($ids)>80) return '您最多可一次查询80个商品信息';
        $urls = array();
        foreach($ids as $k=>$v){
           if($v) $urls[] = "https://item.taobao.com/item.htm?id=".$v;
        }

        $data = array('api'=>'primus_feed_item_addItems','_ksTS'=>TIMESTAMP + "224_124",'url'=>json_encode($urls));
        $rs = $curl->get("http://we.taobao.com/action.do",$data,$referer);
        $rs  = json_decode($rs);
        if(!$rs->success) return $rs->msg;
        return $this->parse($rs);
	}

    function parse($resp) {
       $items = $resp->data->success;
       $rs = array();
       foreach($items as $k=>$v){
        $iid = $v->itemId."";
        $tmp = array();
        $tmp['title'] = $iid;
        $tmp['yh_price'] = $v->itemPrice;
        $tmp['num_iid'] = $iid;
        $tmp['num'] = $v->quantity; //库存
        $tmp['picurl'] = "http://gw.alicdn.com/tfscom/".$v->imgUrl;
        $tmp['images'] = implode(',',$v->imgList);
        $tmp['bili'] = fix(($v->taokprice /  $v->itemPrice * 100 ),1);
        $rs[$iid] = $tmp;
       }
       return $rs;
    }

	

}
