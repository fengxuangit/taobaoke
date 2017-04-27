<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class ad extends app{
	

	//广告
	function main(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
						foreach($_GET[ids] as $k=>$v){
							if($_GET[del][$k] ==0) continue;
							$id = intval($v);
							$arr =array();
							$arr['name']		= 	$_GET['name'][$k];
							$arr['hide']		= 	$_GET['hide'][$k] ? 1 :0;
							$arr['start_time']	= 	dmktime($_GET['start_time'][$k]);
							$arr['end_time']  	= 	dmktime($_GET['end_time'][$k]);
							
							if($_GET['_del_all']==1 && $_GET['del'][$k]){
								DB::delete(__CLASS__,"id=".intval($id));
								api_post(array('a'=>'delete','table'=>'ad','id'=>$id,'pre_key'=>'id'));
							}else{
								DB::update(__CLASS__,$arr,"id=".$id);
								api_post(array('a'=>'update','table'=>'ad','data'=>$arr,'pre_key'=>'id','id'=>$id));	
							}
						}
						api_post(array('m'=>'cache','a'=>'update','cache_list'=>'ad'));
						loadcache(__CLASS__,'update');
						cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
						return false;
				}
				if(is_array($_G) && $_G[ad] != ''){
					$count = count($_G['ad']);
					$ad_types = array(1=>'文字',2=>'图片',3=>'HTML代码');
					foreach($_G['ad'] as $k=>$v){
						
						$_G['ad'][$k]['type_name'] = $ad_types[$v[type]];
					}
				}else{
					$_G[ad] = array();
					$count = 0;
				}
				$this->add(array('count'=>$count));
				$this->show();
	}
	
	function post(){
					global $_G;
					
					if($_GET['onsubmit'] && check() ){
									$ad = get_filed(__CLASS__,$_GET['postdb'],$_GET['id']);
									$ad['start_time'] = dmktime($ad['start_time']);;
									$ad['end_time']  = dmktime($ad['end_time']);;
									$ad['width']  =intval($ad['width']) ;
									$ad['height']  =intval($ad['height']) ;
									$ad['hide']  =intval($ad['hide']) ;
									$ad['type']  =intval($ad['type']) ;
									$ad['target']  =intval($ad['target']) ;
									
									if($_FILES[file]){	
									
										$pic =  upload();
										if($pic)$ad[picurl] = $pic;
										
									}
									
									
									$url = '';
									if($_GET['id']){
										$id = intval($_GET['id']);
										DB::update(__CLASS__,$ad,"id=".$id);
										$url = '&id='.$id;
										$msg = '修改';
										api_post(array('a'=>'update','table'=>'ad','data'=>$ad,'pre_key'=>'id','id'=>$id,'cache'=>'ad'));	
									}else{
										$msg = '添加';
										$ad['dateline'] = TIMESTAMP;
										$r = DB::insert(__CLASS__,$ad,true);
										if($r>0) api_post(array('a'=>'insert','table'=>'ad','data'=>$ad,'cache'=>'ad','id'=>$r));
									}
									loadcache(__CLASS__,'update');
									cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
					}elseif($_GET['id']) {
						
						$id = intval($_GET['id']);
						$ad = $_G['ad']['k'.$id];
					}else{
						$ad = get_filed(__CLASS__);
					}
					$ad_types = array(1=>'文字',2=>'图片',3=>'HTML代码');
					$this->add(array('ad'=>$ad,'ad_types'=>$ad_types));
					$this->show();
	}
	function del(){
					global $_G;
					if(!$_GET['id']){ 
						cpmsg('抱歉,要删除的广告ID不存在','error',"m=ad&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前广告吗?删除后不可恢复?','error',"m=ad&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=ad&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete(__CLASS__,"id=".$id);
						loadcache(__CLASS__,'update');
						api_post(array('a'=>'delete','table'=>'ad','id'=>$id,'pre_key'=>'id','cache'=>'ad'));
						cpmsg('删除成功','success',"m=ad&a=main");
						return false;
					}
	}
	
}
?>

