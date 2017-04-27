<?php
if(!defined('IN_TTAE')) exit('Access Denied');
class cate extends app{
	public $type = '';
	public $table ='';
		function __construct($type,$table=''){
			if($type){
				 $this->type = $type;
			}else{
				msg('分类的类型不能为空');
			}
			if($table) {
				$this->table = $table;
			}else{
				$this->table = $type;
			}
		}
		function main(){
				global $_G,$app;
				if($_GET['onsubmit'] && check() ){
					foreach($_GET['ids'] as $k=>$v){
						$id = intval($v);
						$arr =array();
						$arr['sort'] = intval($_GET['sort'][$k]);
						$arr['name'] = trim($_GET['name'][$k]);
						$arr['fup'] =	intval($_GET['fup'][$k]);
						$arr['hide'] = $_GET['hide'][$k] ? 1 :0;

						$arr['picurl'] = $_GET['picurl'][$k] ? trim($_GET['picurl'][$k]) :'';
						$arr['pic_url'] = $_GET['pic_url'][$k] ? trim($_GET['pic_url'][$k]) :'';
						DB::update(__CLASS__,$arr,"id=".$id." AND type = '".$this->type."'");
					}
					$this->update_cache();

					cpmsg('修改成功','success','');
					return false;
				}

				$cate = $this->get_cate();
				$count = getcount(__CLASS__,"type='".$this->type."'");

				$this->add(array('count'=>$count,'cate'=>$cate));
				$this->show(__CLASS__.'/'.__FUNCTION__);
		}

		function get_cate($id){
				global $_G;

				if($id){
					$cate = DB::fetch_first("SELECT * FROM ".DB::table(__CLASS__)." WHERE id = $id AND type='".$this->type."'");
					return $cate;
				}
				$all_cate = DB::fetch_all("SELECT * FROM ".DB::table(__CLASS__). " WHERE type='".$this->type."' ORDER BY `sort` DESC,id DESC ",'id');
				$cate = array();
									//一级
									foreach($all_cate as $k=>$v){
										if($v[fup] ==0) {
											$v['count'] = getcount($this->table," AND cate = ".$v[id]);

											$v[url] = 'index.php?m='.$v['type'].'&a=list&cid='.$v[id];
											$cate[$k] = $v;
										}
									}
									//二级

									$tmps = $all_cate;
									foreach($cate as $k=>$v){
													$sub = array();
													$id_in = array();
													unset($tmps[$v[id]]);
													foreach($all_cate as $kk=>$vv){
														if($vv['fup'] == $k){
															$vv[count] = getcount($this->table," AND cate = ".$vv[id]);


															$vv[url] =  'index.php?m='.$v['type'].'&a=list&cid='.$vv[id];

															$sub[$kk]  = $vv;	//二级分类
															$id_in2 = array();
															unset($tmps[$vv[id]]);
															foreach($all_cate as $k3=>$v3){
																		if($v3['fup'] == $kk){


																			$v3[url] = 'index.php?m='.$v['type'].'&a=list&cid='.$v3[id];
																			$v3[count] = getcount($this->table," AND cate = ".$v3[id]);
																			unset($tmps[$v3[id]]);
																			$sub[$kk]['sub'][$k3] = $v3;	//三级分类
																			$id_in2[] = $v3['id'];
																			$id_in[] = $v3['id'];
																			$sub[$kk]['sub'][$k3]['id_in'] =$v3['id'];
																		}
															}
															$id_in[] = $vv['id'];
															$id_in2[] = $vv['id'];
															$sub[$kk]['id_in'] = implode(',',$id_in2);
														}
													}
									$id_in[] = $v['id'];
									$cate[$k]['id_in'] =implode(',',$id_in);
									if($sub)$cate[$k]['sub'] = $sub;
								}
								if(count($tmps)>0){
									foreach($tmps as $k=>$v){
										if(!array_key_exists($k)){
											$v[id_in] =$v[id];
											$cate[$k] = $v;
										}
									}

								}
								$cache_data = $cate;

				return $cate;
		}

		public function update_cache(){
					global $_G;

					$cache_name = $this->type.'_cate';
					loadcache($cache_name,'update');
		}


		function post(){
				global $_G,$app;


				if($_GET['onsubmit'] && check() ){
							$arr = array();
							$cate =get_filed(__CLASS__,$_GET['postdb'],$_GET[id]);
							if($_FILES[file]){
								$src = upload();
								if($src)	$cate[picurl] = $src;
							}
							$id = intval($_GET['id']);
							$url = '';
							if($cate['page'] ==0) $cate['page']=20;
							if($_GET[id]){
								$msg = '修改';
								$url = '&id='.$id;
								$id = DB::update('cate',$cate,"id=".$id." AND type='".$this->type."'");

							}else{
								$msg = '添加';
								$cate['type']= $this->type;
								$r = DB::insert('cate',$cate,true);
								if($r>0){
									$cate['id'] = $r;
								}
							}
							$this->update_cache();
							cpmsg($msg.'成功','success','m='.CURMODULE.'&a=cate_post'.$url);
							return false;

				}elseif($_GET[id]){
					$id = intval($_GET[id]);
					$cate = $this->get_cate($id);

				}else{
					$cate = get_filed(__CLASS__);
				}
				//$cate_list = $_G['cate'][$this->type];
				$cate_list = $this->get_cate();

				$this->add(array('cate'=>$cate,'cate_list'=>$cate_list));
				$this->show(__CLASS__.'/'.__FUNCTION__);
		}

		function del(){
					global $_G;


					if(!$_GET['id']) {
						cpmsg('抱歉,要删除的分类ID不存在','error');
						return false;
					}
					$id = intval($_GET['id']);



					$count = getcount($this->table,"cate=".$id);
					if($count>0){
						cpmsg('当前分类下还存在'.$count.'条信息,请先删除本分类的所有信息后再删除本分类','error','m='.CURMODULE.'&a=cate');
						return false;
					}

					if(!$_GET['ok']){
						cpmsg('您确定要删除当前分类吗?删除后不可恢复?','error',"m=".CURMODULE."&a=cate_del&ok=1&id=".$id,'确定删除',
								"<p><a href='".URL."m=".CURMODULE."&a=cate'>取消</a></p>");
						return false;
					}else{
						DB::delete("cate","id=".$id." AND type='".$this->type."'");
						$this->update_cache();
						cpmsg('删除成功','error',"m=".CURMODULE."&a=cate");
						return false;
					}

		}
		function clear(){
					global $_G;
					if(!$_GET['id']){
						 cpmsg('抱歉,要清空的分类ID不存在','error','m='.CURMODULE.'&a=cate');
						 return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						$msg = "<p><a href='".URL."m=".CURMODULE."&a=cate_clear&ok=1&all=1&id=".$id."'>清空当前分类</a></p>";
						$msg .="<p><a href='".URL."m=".CURMODULE."&a=cate_clear&ok=1&all=2&id=".$id."'>清空当前分类和所有子分类信息</a></p>";
						cpmsg('您确定要清空当前分类中的所有信息吗?清空后不可恢复?','error',"m=".CURMODULE."&a=cate",'取消',$msg);
						return false;
					}else{

						$cate = get_sub($id);
						if(table(__CLASS__)){
							$tb = table($this->table);
							$name = 'cate';
							if(array_key_exists('cid',$tb)) $name = 'cid';
								if($_GET['all']==1){
								$count =	DB::delete($this->table,$name."=".$id);
								}elseif($_GET['all']==2){
								$count =	DB::delete($this->table,$name." in (".$cate[id_in].")");
								}
						}

						$this->update_cache();
						cpmsg('清空成功,共清空'.$count.'条','success','m='.CURMODULE.'&a=cate');
						return false;
					}
		}


		function batpost(){
			global $_G,$app;

				if($_GET['onsubmit'] && check() ){
							$cate = get_filed(__CLASS__);

									$all_cate= count($_G['chennels']);
									foreach($_GET['tmp'] as $k=>$v){
										$arr = $cate;
										if($_GET['fup'][$k]){ //一级分类
											$arr['name'] = $_GET['fup'][$k];
											$arr['sort'] =$all_cate+($k+1);
											$arr['type']= $this->type;
											$arr['page']=120;
											$fup_id= DB::insert(__CLASS__,$arr,true);
											if($fup_id>0){
												$arr['id'] = $fup_id;
											}

										}else{
											$fup_id = $_GET['fup2'][$k] ? intval($_GET['fup2'][$k]) :0;
										}

										if($_GET['name'][$k]){
											$sub  = explode(',',$_GET['name'][$k]);
											$sub = array_filter($sub);
											$sub = array_unique($sub);

											if($sub){
												foreach($sub as $k1=>$v1){
													$arr2 = $cate;
													if($v1 != $v){
														$arr2['name']=$v1;
														$arr2['fup']=$fup_id;
														$arr2['sort'] = 0;
														$arr2['type']= $this->type;
														$arr2['page']=20;
														$id = DB::insert('cate',$arr2,true);
														if($id>0){
															$arr2['id'] = $id;
														}
													}
												}
											}
										}

								}
					$this->update_cache();
					cpmsg('批量添加成功','success','m='.CURMODULE.'&a=cate');
					return false;
				}
				$cate = $this->get_cate();

				$this->add(array('cate'=>$cate));
				$this->show(__CLASS__.'/'.__FUNCTION__);
		}


}
?>
