<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class tools extends app{
	
		function main(){
         global $_G;
				$time = TIMESTAMP;
				$del[line] = getcount('goods'," end_time>0  AND end_time<".$time);

				$del[tk] = getcount('goods'," bili ='-1' ");
				$del['sort'] = getcount('goods'," `sort` >0 ");
				
				$day0 = TODAY;
				
				$day3 =  strtotime(date('Y-m-d',strtotime('-3 day')));
				$day7 =  strtotime(date('Y-m-d',strtotime('-7 day')));
				$day30 =  strtotime(date('Y-m-d',strtotime('-1 month')));
				
				
				$day[d0] = getcount('goods',"dateline>".$day0);
				$day[d3] = getcount('goods',"dateline>".$day3);
				$day[d7] = getcount('goods',"dateline>".$day7);
				$day[d30] = getcount('goods',"dateline>".$day30);


				$status_goods = array();
				foreach($_G['setting']['goods_status'] as $k=>$v){
					$count = getcount("goods",'status='.$k);
					$status_goods[] = array('name'=>$v,'key'=>$k,'count'=>$count);
				}
				
				$this->add(array('del'=>$del,'day'=>$day,'status_goods'=>$status_goods)); 
				$this->show('tools/main');
		}
		
		function cache(){
					global $_G;
					if($_GET['onsubmit'] && check() ){
							if($_GET[postdb][system_cache] ==1){	
									memory('clear');
									loadcache ($_G[_config][cache_list],'update');
							}							
							api_post(array('m'=>'cache','a'=>'update','cache_list'=>implode(',',$_G[_config][cache_list])));
							remove_dir('web/templates_c/');
							
							cpmsg('更新成功','success','m=tools&a=cache');
							return false;
					}
					 $this->show('tools/cache');
		}
		
		function sql_runquery(){
				global $_G;				
				if($_GET['onsubmit'] && check()  && $_GET['query_string']){
					$query_string = trim($_GET['query_string']);
					if(strstr($query_string,';'))  $query_string = explode(';',$query_string);
					$query_string = (array)$query_string; 
					$update = true;

					$msg = '';
					$query_string = array_filter($query_string);
					$query_string = array_unique($query_string);
					$i = 0;
					foreach($query_string as $k=>$v){
						if($v){
							$cmd = trim(strtoupper(substr($v, 0, strpos($v, ' '))));
							if ($cmd === 'UPDATE' || $cmd === 'DELETE') $update = false;
							DB::query($v,array(),$update);
							$msg  .= '<p>'.$v.',影响行数:'.DB::affected_rows().'</p>';
							$i++;
						}
					}
					cpmsg('成功执行:'.$i.'条SQL语句'.$msg,'success','m='.__CLASS__.'&a='.__FUNCTION__,'',"<p claaa='red'>如果更改了某些系统数据,请手动更新系统缓存</p>");
					return false;
				}
				 $this->show();
		}
		
		
		/*工具聚合*/
		
		function muster_zhekou(){
				global $_G;
				return false;
				//工具不需要.删除了字段....
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
				$main_url = URL.'m='.__CLASS__.'&a=main';

				
				if(!$_GET['ok']){
						cpmsg('您确定要执行当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}
				$list  = DB::fetch_all("SELECT aid,price,yh_price FROM ".DB::table('goods')." ORDER BY aid DESC  ");
				$res = array_chunk($list,100);
				$index = 0;
				foreach($res as $vv){
						foreach($vv as $k=>$v){
							$zk = (sprintf("%.1f",($v['yh_price']/$v['price']*10)));
							DB::update('goods',array('zhekou_shu'=>$zk),"aid=".$v[aid]);
							$index++;
						}
				}
				$msg  .= '<p>影响行数:'.$index.'</p>';
				cpmsg('操作成功'.$msg,'success','m=tools&a=main');
		}
		
		function muster_del_goods(){
				global $_G;
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
				$main_url = URL.'m='.__CLASS__.'&a=main';
				if(!$_GET['ok']){
						cpmsg('您确定要执行当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}				
				$list  =  DB::fetch_all("Select aid,num_iid,title,Count(num_iid) From ".DB::table('goods')." Group By num_iid Having Count(num_iid) > 1");
				$res = array_chunk($list,100);
				$index = 0;
				$arr = array();
				foreach($res as $vv){
						foreach($vv as $k=>$v){
							DB::delete('goods',"num_iid=".$v[num_iid]);	
							$index+=DB::num_rows();
						}
				}
				$ext = '<p>共删除:'.$index.'条重复记录</p>';
				cpmsg('操作成功'.$ext,'success','m=tools&a=main');
		}
		
		function muster_del_aid(){
				global $_G;
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
				$main_url = URL.'m='.__CLASS__.'&a=main';
				if(!$_GET['ok']){
						cpmsg('您确定要执行当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}				
				$list  =  DB::fetch_all("Select aid,num_iid,title,Count(aid) From ".DB::table('goods')." Group By aid Having Count(aid) > 1");
				
			
				$res = array_chunk($list,100);
				$index = 0;
				$arr = array();
				foreach($res as $vv){
						foreach($vv as $k=>$v){
							DB::delete('goods',"aid=".$v[aid]);	
							$index+=DB::num_rows();
						}
				}
				$ext = '<p>共删除:'.$index.'条重复记录</p>';
				cpmsg('操作成功'.$ext,'success','m=tools&a=main');
		}
		
function muster_views(){
				global $_G;
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
				$main_url = URL.'m='.__CLASS__.'&a=main';
				
				if(!$_GET['ok']){
						cpmsg('您确定要执行当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}
				
				
				$index = DB::query("UPDATE ".DB::table('goods')." SET  `views` =  rand() * 10000");
							
				$msg  .= '<p>影响行数:'.$index.'</p>';
				cpmsg('操作成功'.$msg,'success','m=tools&a=main');
		}
		
		
		
		
		function muster_cate(){
				global $_G;
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
				$main_url = URL.'m='.__CLASS__.'&a=main';

				
				if(!$_GET['ok']){
						cpmsg('操作前请确定你的商品分类名称都是数字型的,如9,9.9,29.9,否则将执行失败.您确定要执行当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}
				$list  = DB::fetch_all("SELECT aid,price,yh_price FROM ".DB::table('goods')." ORDER BY aid DESC  ");
				$res = array_chunk($list,100);
				$index = 0;
				foreach($res as $vv){
						foreach($vv as $k=>$v){
									foreach ($_G[cate] as $k3=>$v3){
												if(is_numeric($v3[name])){
														$now_price = floatval($v3[name]);
														if ($now_price>0.1 &&  $v[yh_price] <= $now_price &&  $v[yh_price]+9 >= $now_price){
															DB::update('goods',array('cate'=>$v3[id]),"aid=".$v[aid]);
															$index++;
														}
												}
									}
						}
				}
				$msg  .= '<p>影响行数:'.$index.'</p>';
				cpmsg('操作成功'.$msg,'success','m=tools&a=main');
		}
		
		
		
		
			
		 function muster_sort(){
			  global $_G;
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
				$main_url = URL.'m='.__CLASS__.'&a=main';
				
				if($_GET['day']>0)  $url .="&day=".intval($_GET[day]);				
				
				if(!$_GET['ok']){
						cpmsg('您确定要批量修改发布商品的排序吗?当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}
				
				if($_GET['day']>0){
					$day = TIMESTAMP-intval($_GET[day]) *86400 ;
					$today = dmktime(dgmdate($day ,'d'));
				}else{
					$today = TODAY;
				}


				$list  = DB::fetch_all("SELECT aid FROM ".DB::table('goods')." WHERE  posttime> $today AND `sort` < 1000000 ORDER BY aid DESC ");
				$count = count($list)-1;
				
				$amax = $list[0][aid];
				$amin = $list[count($list)-1][aid];

				$index = 0;					
				  foreach($list as $k=>$v){
						  $sort = mt_rand($amin,$amax);
						  DB::update('goods',array('sort'=>$sort),"aid=".$v[aid]);
						  $index++;
				  }
				
				
				$msg  .= '<p>影响行数:'.$index.'</p>';
				cpmsg('操作成功'.$msg,'success','m=tools&a=main');
		  }
		
		
		
		
		
		
		function del(){
				$url = 'm='.__CLASS__.'&a='.__FUNCTION__.'&t=';
				$main_url = URL.'m='.__CLASS__.'&a=main';
				
				$t = isset($_GET[t]) ? ($_GET[t]) : '';
				$url.=$t;
				if(!$_GET['ok']){
						cpmsg('您确定要执行当前操作吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
						return false;
				}
				$time = TIMESTAMP;
				$and = '';
				
				if($t == 'line'){
						$and .=  " end_time>0  AND end_time<".$time;

				}elseif($t=='tk'){
					$and .=  " `bili` =-1 ";	
				}
				
				$index =DB::delete('goods',$and);
				$msg  .= '<p>共删除:'.$index.'条商品信息</p>';
				cpmsg('操作成功'.$msg,'success','m=tools&a=main');
		}
		

		function del_status(){
				global $_G;
			$status = intval($_GET['status']);
			if($status==1) msg('您不能删除正常上架的商品');

			$url = 'm='.__CLASS__.'&a='.__FUNCTION__.'&status='.$status;
			$main_url = URL.'m='.__CLASS__.'&a=main';
			
			if(!$_GET['ok']){
				$text = '您确定要删除所有 '.$_G['setting']['goods_status'][$status].' 的商品吗?执行后不可恢复';

					cpmsg($text,'error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
			}
			
			$index =  DB::delete('goods',"  status = ".$status);
			$msg  .= '<p>共删除:'.$index.'条商品信息</p>';
			cpmsg('操作成功'.$msg,'success','m=tools&a=main');

		}
		
		function cover_user_name(){
			global $_G;		
			
			$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
			$main_url = URL.'m='.__CLASS__.'&a=main';	
			$user = DB::fetch_all(" SELECT uid,username FROM ".DB::table('member').' ORDER BY uid DESC');
			
			if(!$_GET['ok']){
				cpmsg('您确定要批量转换会员昵称吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
				return false;
			}
			$index = 0;
			foreach($user as $k=>$v){
				if(strlen($v[username])>20 && strlen($v[username])<36){
					$new = $nickConvertingService->convert($v[username]);
					$u = DB::fetch_first(" SELECT uid,username FROM ".DB::table('member')." WHERE username='$new' ORDER BY uid DESC");
					if($u[uid]>0){
						DB::delete('member','uid='.$v[uid]);
					}else{					
						DB::update('member',array('username'=>$new),'uid='.$v[uid]);
					}
					$index++;
				}
			}
			$msg  .= '<p>影响行数:'.$index.'</p>';
			cpmsg('操作成功'.$msg,'success','m=tools&a=main');

		}
		
		function clear_sort(){
			$url = 'm='.__CLASS__.'&a='.__FUNCTION__;
			$main_url = URL.'m='.__CLASS__.'&a=main';	
			if(!$_GET['ok']){
				cpmsg('您确定要一键清空所有商品的排序吗?执行后不可恢复','error',$url.'&ok=1','确定',"<p><a href='".$main_url ."'>取消</a></p>");
				return false;
			}
			//$index = DB::update('goods',' `sort`= 0 ','aid>1289');
			DB::query("UPDATE ".DB::table('goods')." set `sort`=0");
			$index = DB::num_rows();
			$msg  .= '<p>影响行数:'.$index.'</p>';
			cpmsg('操作成功'.$msg,'success','m=tools&a=main');
		}
		
		
			
		

		function download(){
			global $_G;
			if(!$_GET['picurl']) json('图片不存在');
			$picurl = urldecode($_GET['picurl']);
			$new_pic = download_image($picurl,'',0,true);
			if($new_pic === false) {
				$new_pic = download_image($picurl,'',1,true);
				if($new_pic === false) json('下载失败');
			}
			json(array('status'=>'success','data'=>$new_pic));
			
		}


		function del_yongjin(){
        global $_G;


        $bili = intval($_GET['bili']);
        if($bili == 0) msg('要删除的最低佣金比例不能为0');
        $main_url = URL.'m=tools&a=main';
        $url = URL.'m=tools&a=del_yongjin&bili='.$bili;
          $and = '';
          $text = '';

        if(!$_GET['ok']){
            cpmsg('您确定要一键清空所有商品佣金低于 '.$bili.'% '.$text.' 的商品吗?','error',$url.'&ok=1','确定',
                "<p><a href='".$main_url ."'>取消</a></p>");
            return false;
        }


        $count = DB::delete("goods",'bili>0 AND bili<'.$bili.$and);
		$num = DB::num_rows();

        msg('删除成功'.$num.'条','success',$main_url);
    }
		
}
?>
