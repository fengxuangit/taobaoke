<?php
if(!defined('IN_TTAE')) exit('Access Denied');
class app{
	 function add($arr){
					global $assign;
					if(!$arr|| !is_array($arr)) return false;
					foreach($arr as $k=>$v){
						if($k){
							$assign[$k]  = $v;
						}
					}
	}

	function data_api(){
							//加载用户数据接口
							//if(defined('ERROR') === true) return false;
							include_once TPLDIR.'/data_api.php';
							$data = array();
							if(class_exists('data_api')){
								$data_api = new data_api();

								if(method_exists($data_api,'main')){
									$data = $data_api->main();
									if($data && is_array($data))$this->add($data);
								}

								$module = CURMODULE;
								if(method_exists($data_api,$module)){
									$data = $data_api->$module();
									if($data && is_array($data))$this->add($data);
								}
								$curmodule = CURMODULE.'_'.CURACTION;
								if(method_exists($data_api,$curmodule)){
									$data = $data_api->$curmodule();
									if($data && is_array($data))$this->add($data);
								}

								unset($data_api);
							}

							return $data;
	}
	 function show($tpl='',$dir=''){
					global $_G,$assign;
					var_dump($_G);
					exit();
					if($_G['is_show']) return ;
					$_G['is_show'] = true;

					include ROOT_PATH.'web/smarty/Smarty.class.php';
					$smarty =	new Smarty();


					/*
					include  ROOT_PATH.'web/smarty/SimpleSmarty.php';
					$smarty =	new SimpleSmarty();
					$smarty->compile_dir = ROOT_PATH.'web/templates_c';
					$smarty->caching = true;

					*/

					/*if(DEBUG === true){
						$smarty->force_compile = true;
					}else{
						$smarty->compile_check = false;
					}*/

					if(defined('IN_ADMIN')){
						$smarty->assign("menu", $_G['menu']);
					}else{
						$this->data_api();
					}

					$tae = TAE == true ? 1 : 0;

					if($_G['adminid'] ==1 &&DEBUG)$_G['runtime'] = (microtime(true) - $_G['starttime']);
					$_G['version'] = TTAE_VERSION;
					$_G['update_time'] = TTAE_UPDATE_TIME;
					$smarty->assign("MOBILE", MOBILE?1:0);

					$smarty->assign("CURSCRIPT", CURSCRIPT);
					$smarty->assign("CURMODULE", CURMODULE);
					$smarty->assign("CURACTION", CURACTION);

					$smarty->assign("CM", CURMODULE);
					$smarty->assign("CA", CURACTION);
					$smarty->assign("SYSTEM_TYPE", SYSTEM_TYPE);
					$smarty->assign("TAE", $tae);
					$smarty->assign("CSSDIR", CSSDIR);
					$smarty->assign("JSDIR", JSDIR);
					$smarty->assign("IMGDIR", IMGDIR);
					$smarty->assign("TPLDIR", TPLDIR);
					$smarty->assign("ASSDIR", 'assets/'.TPLNAME.'/'.CURMODULE);
					$smarty->assign("TPLDIR", 'assets/'.TPLNAME.'/');


					$commondir = 'assets/common/';
					if($_G[mobile])$commondir = 'assets/common_mobile/';
					$smarty->assign("COMMONDIR",$commondir);
					$smarty->assign("TPLNAME", TPLNAME);
					$smarty->assign("URL",URL);

					$css ='<link rel="stylesheet" type="text/css" href="'.CSSDIR.'/'.CURMODULE.'.css" media="all" />';
					$smarty->assign("CSS", $css);
					$js ='<script type="text/javascript" src="'.JSDIR.'/'.CURMODULE.'.js" ></script>';
					$smarty->assign("JS", $js);

					$safe_get = safe_output($_GET);
					$query_text = http_build_query($safe_get);
					$smarty->assign("query_text",$query_text);
					$smarty->assign("_GET", $safe_get);
					$unset = array('table','_config','goods_sql','memory_list','cache_list');
					$tmp = array();
					foreach($_G as $k=>$v){
						if(!in_array($k,$unset)) $tmp[$k]= $v;
					}

					$smarty->assign("_G", $tmp);
					if(count($assign)>0){
						foreach($assign as $k=>$v){
							$smarty->assign($k, $v);
						}
					}

					if($_G[mobile] && $_G[setting][cnzz_id]){
						include_once ROOT_PATH.'web/lib/cs.php';
						$cnzz = '';
						$cnzz_img_url = _cnzzTrackPageView($_G[setting][cnzz_id]);
						if(strpos($cnzz_img_url,'http') !== false){
							$cnzz = '<img src="'.$cnzz_img_url.'" style="display:none;" class="cnzz_img" >';
						}
						$smarty->assign("cnzz", $cnzz);
					}
					unset($assign);
					$data = array();
					$data[] = $tae;
					$data[] = CURSCRIPT;
					$data[] = CURMODULE;
					$data[] = CURACTION;
					$data[] = $_G[uid];
					$data[] = $_G[username];
					$data[] = $_G['setting']['duoshuo'];
					$data[] = $_G['setting']['left_bar'];
					$data[] = $_G['setting']['goods_api_type'];
					$data[] = $_G['setting']['cnzz_id'];
					$global_str = implode('|',$data);
					$smarty->assign("global_str", $global_str);

					$dir = $dir ? $dir : TPLDIR;


					$common_dir  = ROOT_PATH.'view/common';
					if($_G['mobile'] == true)$common_dir.='_mobile';

					if($tpl){
						$show_tpl=($dir.'/'.$tpl.'.php');
						$show_tpl2=($common_dir.'/'.$tpl.'.php');
					}else{
						$show_tpl=($dir.'/'.CURMODULE.'/'.CURACTION.'.php');
						$show_tpl2=($common_dir.'/'.CURMODULE.'/'.CURACTION.'.php');
					}
					if(!is_file($show_tpl)) {
						if(!is_file($show_tpl2)){

							//在这里重新加载
							//修改常地址,重显示

							$show_tpl = str_replace(array(ROOT_PATH.'view/'.TPLNAME.'/','.php'),'',$show_tpl);
							msg('Unable to load template file '.$show_tpl);
						}else{
							$show_tpl = $show_tpl2;
						}
					}


					try{
						$smarty->display($show_tpl);
						$obj = DB::$db;
						if($_G[adminid] ==1 && isset($_GET['debug'])){

						}else{
							unset($smarty,$data,$app,$obj,$db,$_confog);
						}
					}catch (Exception $e){

								//$e->trace = '';
								$file = end(explode('\\',$e->getFile()));
								$msg = '<br/> File : '.$file  . ' On line '.$e->getLine() . ' Code '.$e->getCode();
								$msg = $e->getMessage().$msg;
								$msg = str_replace(ROOT_PATH.'view/','',$msg);
								//system_error('system',$msg);
								msg($msg);
								exit;
					}

					output();

					if($_G[adminid] ==1 && isset($_GET['debug'])){
						if(function_exists('xhprof_enable')){
							$XHPROF_ROOT = ROOT_PATH.'web/lib/xhprof/';
							if(is_dir($XHPROF_ROOT)){

								$xhprof_data = xhprof_disable();
								include_once $XHPROF_ROOT . "xhprof_lib.php";
								include_once $XHPROF_ROOT . "xhprof_runs.php";
								$xhprof_runs = new XHProfRuns_Default();
								$name = str_replace(array('www','com','app','.'),'',$_SERVER['SERVER_NAME']);
								$run_id = $xhprof_runs->save_run($xhprof_data, $name);
							}
						}
						include_once libfile('function/debug');
					}

					if($_GET['update'] ==1 && $_G[adminid] ==1 ){
						memory('clear');
					}
					unset($_G);
					if(DB::object()->curlink) DB::object()->close();


			}

	function seo_setting($tpl){
					global $_G;
					if($_GET['onsubmit'] && check() ){
						insert_setting();
						cpmsg('修改成功','success');
						return false;
					}
					$this->show($tpl);
	}



	function  _like($db,$fd,$id,$text='喜欢'){
		$rt = array('msg'=>'','status'=>'error');
		if(!$db)return '要操作的表不能空';
		if(!$fd)return '子段不能空';
		if(!$id)return 'id不能空';
		$id = intval($id);

		$name =$db.'_'.$fd;
		$ids = C($name);
		if($ids){
			$ids = explode('|',$ids);
			$ids = array_filter($ids);
			$ids = array_unique($ids);
		}else{
			$ids = array();
		}

		if(!in_array($id,$ids)){
			$ids[] = $id;
			C($name,implode('|',$ids),86400*30);
			$id_fd = $fd =='goods' ? 'aid':'id';
			$data = DB::result_first("SELECT `$fd` FROM ".DB::table($db)." WHERE  $id_fd = ".$id);
			$data++;
			DB::update($db,array($fd=>$data),$id_fd.'='.$id);
			return array('status'=>'success','msg'=>$text.'成功','data'=>$data);
		}else{
			return '您已'.$text.'过本商品';
		}
	}








}

?>
