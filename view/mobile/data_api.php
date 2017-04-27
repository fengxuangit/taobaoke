<?php

global $_G;
class data_api {

		
		function index_main(){
					global $_G;
					$url = URL.'a=all';
					$sql = make_sql();
	
					$index_goods = D(array('and'=>$sql['and'],'order'=>$sql[order]),array('url'=>$url.$sql[url],'size'=>90));
					foreach($index_goods[goods] as $k=>$v){
						$index_goods[goods][$k][title] .= '('.$v[yh_price].($v[baoyou]==1?'包邮':'').')';
					}					
					return $index_goods; 
		}		
		function home(){
				global $_G;
				$today = dgmdate(TIMESTAMP,'dt');
				$sign = D(array('table'=>'sign','and'=>"AND uid = ".$_G[uid]." AND type ='sign' "),array('url'=>'m=home','size'=>10));
				
				$sign[today] = $today;
				
				return $sign;
		}
}





?>