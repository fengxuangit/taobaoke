<?php



class data_api {
		function main(){
			return array('width'=>1280);
		}

		function index_main(){
					global $_G;

					$size = $_G['setting']['cate_page']  ? intval($_G['setting']['cate_page']):120;
					$index = D(array('and'=>'','key'=>'index'),array('size'=>$size,'url'=>'/index.php?a=all'));
					$today = TODAY;
					$index['today_count'] = getcount('goods','dateline>'.$today);

					return $index;
		}


		function goods_main(){
				global $_G,$assign;
				$data = $assign['goods'];
				$fid = intval($data['fid']);
				$goods =  D(array('and'=>' AND fid = '.$fid,'limit'=>16,'order'=>'aid DESC','key'=>'gkm'));
				return array('goods'=>$goods,'data'=>$data);
		}

		function article_main(){
				global $_G;
				$article_list = D(array('and'=>' `hide`=0  ','limit'=>12,'table'=>'article','order'=>' `sort`  DESC, id DESC ','key'=>'article'));
				return array('article_list'=>$article_list);
		}

		function channel_main(){
				global $_G;

				if($_G[channel]['fup']>0){
					$sub = get_fup($_G['fid']);
				}else{
					$sub = get_sub($_G['fid']);
				}
				return array('sub'=>$sub);
		}

}





?>
