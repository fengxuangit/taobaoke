<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class channel extends app{
function main(){
		global $_G;
		$fid = intval ($_GET['fid']);
		$_G['channel']	=$channel = $_G['channels'][$fid] ? $_G['channels'][$fid] : $_G['all_channel']['k'.$fid];
		if($fid<1 || !$channel && !$_G[mobile]) {
			showmessage('抱歉FID不存在');
 			return false;
		}

		$size = $channel['page'] >0 ? intval($channel['page']):$_G[setting][cate_page];
		$url =URL;
        $and = "";
		$sql = make_sql();
		
		if($sql[order]){
			$order = $sql[order];
		}else{
			if($_G['setting']['goods_sort'] == 1){
				$order = ' `sort` DESC ';
			}else{
				$order = ' aid DESC ';
			}
		}
		
		if($_G['setting']['main_table'] && array_key_exists($_G['setting']['main_table'],table())){	
				
			$rs = D(array('and'=>$and.$sql['and'],'order'=>$order,'table'=>$_G['setting']['main_table'],'key'=>'channel_'.$_G['fid']),
				array('url'=>$url.$sql[url],'size'=>$size));
			ajaxoutput($rs['goods']);
			
			$this->add($rs);
			
		}

		$this->add(array('channel'=>$channel));
		seo(!MOBILE ? $channel['title'] :$channel['name'],$channel['name'].','.$channel['keywords'],$channel['description']);		
		$this->show($channel['channel_tpl'] ? $channel['channel_tpl'] : '');	
	}
	
	function all(){
			global $_G;
			include_once libfile('action/index');
			$index = new index();
			$index->all('index/all');
		
	}

	

}
?>