<?php
if(!defined('IN_ADMIN')) exit('Access Denied');

class pics extends app{


	function main(){
					global $_G;
					if($_GET['onsubmit'] && check() ){
							foreach($_GET[ids] as $k=>$v){
								$id = intval($v);
								if($_GET[del][$k] ==0) continue;

								$arr =array();
								$arr['sort'] 	=	intval($_GET['sort'][$k]);
								$arr['hide']	= 	$_GET['hide'][$k] ? 1 :0;
								$arr['fup'] 	=	intval($_GET['fup'][$k]);
								$arr['picurl'] 	=	$_GET['picurl'][$k] ? trim($_GET['picurl'][$k]) : '';
								$arr['url'] 	=	$_GET['url'][$k] ? trim($_GET['url'][$k]) : '';

								if($_GET['_del_all']==1 && $_GET['del'][$k]){
									DB::delete(__CLASS__,"id=".intval($id));
									api_post(array('a'=>'delete','table'=>__CLASS__,'id'=>$id,'pre_key'=>'id'));
								}else{
									DB::update(__CLASS__,$arr,"id=".$id);

									api_post(array('a'=>'update','table'=>__CLASS__,'data'=>$arr,'pre_key'=>'id','id'=>$id));
								}
							}
							api_post(array('m'=>'cache','a'=>'update','cache_list'=>'pics'));
							loadcache('pics','update');
							loadcache('pics_type','update');
							cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
							return false;
					}

					$pics =array();
					$count = 0;

					foreach($_G[pics] as $k=>$v){
						  $k  = str_replace('k','',$k);
						  $count+= count($v);
						  $pics[$k] = $_G['pics_type'][$k];
						  $pics[$k][sub]  = $v;
					}

					$this->add(array('count'=>$count,'pics'=>$pics));
					$this->show();
	}

	function post(){
				global $_G;

				if(!$_G['pics_type']) cpmsg('幻灯片分类不存在,请先添加','error','m='.__CLASS__.'&a=type_post');
				if($_GET['onsubmit'] && check() ){
					$pics = get_filed(__CLASS__,$_GET['postdb'],$_GET['id']);
					$url = '';
					if($_FILES[file]){
								$src = upload();
								if($src)	$pics[picurl] = $src;
					}


					if($_GET['id']){
						$id = intval($_GET['id']);
						DB::update('pics',$pics,"id=".$id);
						$url = '&id='.$id;
						$msg = '修改';
						api_post(array('a'=>'update','table'=>'pics','data'=>$pics,'pre_key'=>'id','id'=>$id,'cache'=>'pics,pics_type'));
					}else{
						$msg = '添加';
						$pics['dateline'] = TIMESTAMP;
						$r = DB::insert('pics',$pics,true);
						if($r>0) api_post(array('a'=>'insert','table'=>'pics','data'=>$pics,'cache'=>'pics,pics_type','id'=>$r));
					}
					loadcache("pics_type",'update');
					loadcache("pics",'update');
					cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
					return false;
				}elseif($_GET['id']) {
					$id = intval($_GET['id']);
					foreach($_G['pics'] as $k=>$v){
						if(array_key_exists($id,$v)){
							$pics = $v[$id];
						}

					}
					$pics = dhtmlspecialchars($pics);
				}else{
					$pics = get_filed(__CLASS__);
				}
				$this->add(array('pics'=>$pics));
				$this->show();
	}

	function del(){
					global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要删除的幻灯片ID不存在','error',"m=pics&a=main");
						 return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前幻灯片吗?删除后不可恢复?','error',"m=pics&a=del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=pics&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("pics","id=".$id);
						api_post(array('a'=>'delete','table'=>'pics','id'=>$id,'pre_key'=>'id','cache'=>'pics'));
						loadcache("pics",'update');
						cpmsg('删除成功','success',"m=pics&a=main");
						return false;
					}
	}

		//幻灯片
	function type(){
						global $_G;

						if($_GET['onsubmit'] && check() ){

								foreach($_GET[ids] as $k=>$v){
									if($_GET[del][$k] ==0) continue;
									$id = intval($v);
									if($_GET['_del_all']==1 && $_GET['del'][$k]){
										DB::delete(__CLASS__.'_'.__FUNCTION__,"id=".$id);
										DB::delete("pics","fup=".$id);
										api_post(array('a'=>'delete','table'=>__CLASS__.'_'.__FUNCTION__,'id'=>$id,'pre_key'=>'id'));
										api_post(array('a'=>'delete','table'=>'pics','id'=>$id,'pre_key'=>'id'));
									}
								}
								api_post(array('m'=>'cache','a'=>'update','cache_list'=>'pics_type,pics'));
								loadcache(__CLASS__.'_'.__FUNCTION__,'update');
								loadcache(__CLASS__,'update');
								cpmsg('删除成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
								return false;
						}

						$this->add(array('count'=>count($_G[pics_type])));
						$this->show();

	}

	function type_del(){

						if(!$_GET['id']) cpmsg('抱歉,要删除的幻灯片分类ID不存在','error',"m=pics&a=type");
						$id = intval($_GET['id']);
						if(!$_GET['ok']){
							cpmsg('您确定要删除当前幻灯片分类吗?本操作会将当前分类下的幻灯片全部删除,删除后不可恢复?','error',
									"m=pics&a=type_del&ok=1&id=".$id,'确定删除',"<p><a href='".URL."m=pics&a=type'>取消</a></p>");
						}else{
							DB::delete(__CLASS__.'_type',"id=".$id);
							DB::delete(__CLASS__,"fup=".$id);
							loadcache(__CLASS__.'_type','update');
							loadcache(__CLASS__,'update');

							api_post(array('a'=>'delete','table'=>'pics_type','id'=>$id,'pre_key'=>'id','cache'=>'pics_type'));
							api_post(array('a'=>'delete','table'=>'pics','id'=>$id,'pre_key'=>'fup','cache'=>'pics'));

							cpmsg('删除成功','error',"m=pics&a=type");
							return false;
						}
	}

	function type_post(){
				global $_G;


				if($_GET['onsubmit'] && check() ){
					$type =	get_filed('pics_type',$_GET['postdb'],$_GET['id']);
					$url = '';
					if($_GET['id']){
						$id = intval($_GET['id']);
						DB::update('pics_type',$type,"id=".$id);
						api_post(array('a'=>'update','table'=>'pics_type','data'=>$type,'pre_key'=>'id','id'=>$id,'cache'=>'pics_type'));
						$url = '&id='.$id;
						$msg = '修改';
					}else{
						$msg = '添加';
						$r = DB::insert('pics_type',$type,true);
						if($r>0) api_post(array('a'=>'insert','table'=>'pics_type','data'=>$type,'cache'=>'pics_type','id'=>$r));
					}
					loadcache('pics','update');
					loadcache('pics_type','update');
					cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$url);
					return false;
				}elseif($_GET['id']){
					$type = DB::fetch_first("SELECT * FROM ".DB::table('pics_type')." WHERE id = ".intval($_GET['id']));

				}else{
					$type =	get_filed('pics_type');
				}
				$this->add(array('type'=>$type));
				$this->show();
	}

}
?>

