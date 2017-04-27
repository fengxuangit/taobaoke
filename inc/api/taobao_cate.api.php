<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
//获取后台可发布的分类...
include_once	(ROOT_PATH.'top/baichuan/ItemcatsGetRequest.php');
class api_taobao_cate{

	
		function get($cate_id=0){
			global $_G;
			$req = new ItemcatsGetRequest;
			//$req->setFields("cid,parent_cid,name,is_parent");
			$req->setFields("cid,name");
			$req->setParentCid($cate_id);
			$resp = $_G['TOP']->execute($req);
			top_check_error($resp,1);
			return $this->parse($resp->item_cats->item_cat);
		}
		
		function parse($obj){
			$tmp = array();
			foreach ($obj as $k=>$v){
				$v = (array)$v;
				$tmp[$v['cid']] = $v;
			}
			return $tmp;
		}
		
		function get_all(){
			$cates = $this->get(0);
			foreach($cates as $k=>$v){
				$cates[$v['cid']]['sub'] = $this->get($v['cid']);
			}
			return $cates;			
		}
		function get_user(){
		$cates = array ( 50026523 => array ( 'cid' => 50026523, 'name' => '休闲娱乐', ), 50008075 => array ( 'cid' => 50008075, 'name' => '餐饮美食', ), 
						50020808 => array ( 'cid' => 50020808, 'name' => '家居饰品', ), 30 => array ( 'cid' => 30, 'name' => '男装', ), 
						50008164 => array ( 'cid' => 50008164, 'name' => '住宅家具', ), 50020611 => array ( 'cid' => 50020611, 'name' => '商业/办公家具', ), 
						50023904 => array ( 'cid' => 50023904, 'name' => '国货精品数码', ), 50010788 => array ( 'cid' => 50010788, 'name' => '彩妆/香水/美妆工具', ),
						1801 => array ( 'cid' => 1801, 'name' => '美容护肤/美体/精油', ), 50023282 => array ( 'cid' => 50023282, 'name' => '美发护发/假发', ),
						1512 => array ( 'cid' => 1512, 'name' => '手机', ), 14 => array ( 'cid' => 14, 'name' => '数码相机/单反相机/摄像机', ),
						1201 => array ( 'cid' => 1201, 'name' => 'MP3/MP4/iPod/录音笔', ), 1101 => array ( 'cid' => 1101, 'name' => '笔记本电脑', ),
						11 => array ( 'cid' => 11, 'name' => '电脑硬件/显示器/电脑周边', ), 50018264 => array ( 'cid' => 50018264, 'name' => '网络设备/网络相关', ),
						50008090 => array ( 'cid' => 50008090, 'name' => '3C数码配件', ), 50012164 => array ( 'cid' => 50012164, 'name' => '闪存卡/U盘/存储/移动硬盘', ),
						50007218 => array ( 'cid' => 50007218, 'name' => '办公设备/耗材/相关服务', ), 50018004 => array ( 'cid' => 50018004, 'name' => '电子词典/电纸书/文化用品', ), 
						20 => array ( 'cid' => 20, 'name' => '电玩/配件/游戏/攻略', ), 50022703 => array ( 'cid' => 50022703, 'name' => '大家电', ),
						50011972 => array ( 'cid' => 50011972, 'name' => '影音电器', ), 50012100 => array ( 'cid' => 50012100, 'name' => '生活电器', ), 
						50012082 => array ( 'cid' => 50012082, 'name' => '厨房电器', ), 21 => array ( 'cid' => 21, 'name' => '居家日用', ), 
						50016349 => array ( 'cid' => 50016349, 'name' => '厨房/烹饪用具', ), 50016348 => array ( 'cid' => 50016348, 'name' => '家庭/个人清洁工具', ),
						50008163 => array ( 'cid' => 50008163, 'name' => '床上用品', ), 35 => array ( 'cid' => 35, 'name' => '奶粉/辅食/营养品/零食', ),
						50014812 => array ( 'cid' => 50014812, 'name' => '尿片/洗护/喂哺/推车床', ), 50022517 => array ( 'cid' => 50022517, 'name' => '孕妇装/孕产妇用品/营养', ),
						50008165 => array ( 'cid' => 50008165, 'name' => '童装/婴儿装/亲子装', ), 50020275 => array ( 'cid' => 50020275, 'name' => '传统滋补营养品', ),
						50002766 => array ( 'cid' => 50002766, 'name' => '零食/坚果/特产', ), 50016422 => array ( 'cid' => 50016422, 'name' => '粮油米面/南北干货/调味品', ),
						121380001 => array ( 'cid' => 121380001, 'name' => '国内机票/国际机票/增值服务', ), 121536003 => array ( 'cid' => 121536003, 'name' => '数字娱乐', ),
						121536007 => array ( 'cid' => 121536007, 'name' => '全球购代购市场', ), 50010728 => array ( 'cid' => 50010728, 'name' => '运动/瑜伽/健身/球迷用品', ),
						50013886 => array ( 'cid' => 50013886, 'name' => '户外/登山/野营/旅行用品', ), 50011699 => array ( 'cid' => 50011699, 'name' => '运动服/休闲服装', ),
						25 => array ( 'cid' => 25, 'name' => '玩具/模型/动漫/早教/益智', ), 50011740 => array ( 'cid' => 50011740, 'name' => '流行男鞋', ), 
						16 => array ( 'cid' => 16, 'name' => '女装/女士精品', ), 50006843 => array ( 'cid' => 50006843, 'name' => '女鞋', ),
						50006842 => array ( 'cid' => 50006842, 'name' => '箱包皮具/热销女包/男包', ), 1625 => array ( 'cid' => 1625, 'name' => '女士内衣/男士内衣/家居服', ),
						50010404 => array ( 'cid' => 50010404, 'name' => '服饰配件/皮带/帽子/围巾', ), 50011397 => array ( 'cid' => 50011397, 'name' => '珠宝/钻石/翡翠/黄金', ), 
						28 => array ( 'cid' => 28, 'name' => 'ZIPPO/瑞士军刀/眼镜', ), 2813 => array ( 'cid' => 2813, 'name' => '成人用品/避孕/计生用品', ), 
						50012029 => array ( 'cid' => 50012029, 'name' => '运动鞋new', ), 50013864 => array ( 'cid' => 50013864, 'name' => '饰品/流行首饰/时尚饰品新', ),
						50468001 => array ( 'cid' => 50468001, 'name' => '手表', ), 50510002 => array ( 'cid' => 50510002, 'name' => '运动包/户外包/配件', ), 
						50008141 => array ( 'cid' => 50008141, 'name' => '酒类', ), 122650005 => array ( 'cid' => 122650005, 'name' => '童鞋/婴儿鞋/亲子鞋', ), 
						122684003 => array ( 'cid' => 122684003, 'name' => '自行车/骑行装备/零配件', ), 122718004 => array ( 'cid' => 122718004, 'name' => '家庭保健', ), 
						122852001 => array ( 'cid' => 122852001, 'name' => '居家布艺', ), 122950001 => array ( 'cid' => 122950001, 'name' => '节庆用品/礼品', ), 
						122952001 => array ( 'cid' => 122952001, 'name' => '餐饮具', ),
				);
				
			foreach($cates as $k=>$v){
				$cates[$v['cid']]['sub'] = $this->get($v['cid']);
			}
			return $cates;		
			
		}
		
		
		
}