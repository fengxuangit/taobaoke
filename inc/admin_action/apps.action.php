<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class apps extends app{
		function main(){
			$this->hdp();
		}
	
		function version(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
				insert_setting();
				cpmsg('修改成功','success','m=apps&a=version');
				return false;
			}
			$this->show();
		}
		function other(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
				insert_setting();
				cpmsg('修改成功','success','m=apps&a=other');
				return false;
			}
			$this->show();
		}
		function api(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
				insert_setting();
				cpmsg('修改成功','success','m=apps&a=api');
				return false;
			}
			$this->show();
		}

		function tpl(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
				insert_setting();
				cpmsg('修改成功','success','m=apps&a=tpl');
				return false;
			}

			$this->show();
		}


		function push(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
				$title = trim($_GET['postdb']['title']);
				$content = trim($_GET['postdb']['content']);
				$type = intval($_GET['postdb']['type']);

				if($_G['setting']['app_push'] == 'xg'){
					$android = 0;
					$ios = 0;
					if($_GET['phone'] ==2){
						$ios = 1;
					}else {
						$android =1;
					}
				}else{
					$android = intval($_GET['phone']['android']);
					$ios = intval($_GET['phone']['ios']);
				}
				$extar = array();
				if($_GET['type'] != -1 && $_GET['data']){
					$data = trim($_GET['data']);
					
					if(($_GET['type'] == 4 || $_GET['type'] == 5 )&&$data[0] != '&') $data = '&'.$data;
					$extar = array('type'=>$_GET['type'],'data'=>$data,'title'=>$title);
				}
				$msg = push(array('type'=>$type,'title'=>$title,'content'=>$content,'android'=>$android,'ios'=>$ios),$extar);
				cpmsg($msg,'success','m=apps&a=push');
				return false;
			}
			$this->add(array('push_type'=>$push_type));
			$this->show();
		}
		function hdp(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
					$arr = array();
					
					foreach($_POST[picurl] as $k=>$v){
						$tmp = array();
						$tmp['picurl'] = $_POST[picurl][$k];
						$tmp['url'] =$_POST[url][$k];
						$tmp['title'] =$_POST[title][$k];
						if($_FILES['file'.$k]){							
							$pic = upload($_FILES['file'.$k]);
							if($pic)$tmp['picurl'] = $pic;
						}

						if(!$tmp['picurl'] && $tmp['url']) continue;
						$arr[] = $tmp;
					}
					
					$arr = serialize($arr);
					if(isset($_G['setting']['app_hdp'])){
						set_setting('app_hdp',$arr );
					}else{
						insert_setting('app_hdp',$arr );
					}
					loadcache('setting','update');
					cpmsg('修改成功','success','m=apps&a=hdp');
					return false;
				}

			
			if($_G[setting]['app_hdp']){
				$hdp = dunserialize($_G[setting]['app_hdp']);
			}else{
				$hdp = array(array('picurl'=>'','url'=>''));
			}
			
			$size = 6;
			$this->add(array('hdp'=>$hdp,'size'=>$size ));
			$this->show('apps/hdp');
		}
		
		function nav(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
					$arr = array();
					
					foreach($_POST[name] as $k=>$v){
						
						$tmp = array();
						$tmp['name'] = $_POST[name][$k];
						$tmp['url'] =$_POST[url][$k];
						if(!$tmp[name] && $tmp['url']) continue;
						$arr[] = $tmp;
					}
					
					
					$arr = serialize($arr);
					if(isset($_G['setting']['app_nav'])){
						set_setting('app_nav',$arr );
					}else{
						insert_setting('app_nav',$arr );
					}
					loadcache('setting','update');
					cpmsg('修改成功','success','m=apps&a=nav');
					return false;
				}

			
			if($_G[setting]['app_nav']){				
				$hdp = dunserialize($_G[setting]['app_nav']);
			}else{
				$hdp = array(array('name'=>'','url'=>''));
				//$nav = array(array('name'=>'给家换新衣','url'=>'#4','name'=>'百变萝莉','url'=>'#3'	,'name'=>'腊八专场','url'=>'#2'	,'name'=>'吃货9.9','url'=>'#1'));
			}

			$size = 4;
			$this->add(array('hdp'=>$hdp,'size'=>$size ));
			$this->show();
		}
		
		
		
		function gezi(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
					$arr = array();
					
					foreach($_POST[picurl] as $k=>$v){
						$tmp = array();
						$tmp['picurl'] = $_POST[picurl][$k];
						$tmp['url'] =$_POST[url][$k];
						$tmp['title'] =$_POST[title][$k];
						if($_FILES['file'.$k]){							
							$pic = upload($_FILES['file'.$k]);
							if($pic)$tmp['picurl'] = $pic;
						}

						if(!$tmp['picurl'] && $tmp['url']) continue;
						$arr[] = $tmp;
					}
					
					$arr = serialize($arr);
					if(isset($_G['setting']['app_gezi'])){
						set_setting('app_gezi',$arr );
					}else{
						insert_setting('app_gezi',$arr );
					}
					loadcache('setting','update');
					cpmsg('修改成功','success','m=apps&a=gezi');
					return false;
				}

			
			if($_G[setting]['app_gezi']){
				$hdp = dunserialize($_G[setting]['app_gezi']);
			}else{
				$hdp = array(array('picurl'=>'','url'=>''));
			}
			$size = 6;
			
			$this->add(array('hdp'=>$hdp,'size'=>$size ));
			$this->show('apps/gezi');
		}
		
		function im(){
			parent::seo_setting();
			$this->show();
		}

		function count(){
			global $_G;
			if($_GET['onsubmit'] && check() ){
				parent::seo_setting();
			}

			if($_G['setting']['apicloud_appid'] && $_G['setting']['apicloud_appkey']){

						$start = date("Y-m-d",strtotime("-30 day"));
						$end = date("Y-m-d");
						$type = $_GET['type'] ? $_GET['type'] : 'app';

						$rs = top('cloud','count_'.$type,$start,$end);
						if($rs === false ) msg('获取数据失败');
						$this->add(array('data'=>$rs,'start'=>$start,'end'=>$end));

			}

			$this->show();
		}
		
}
?>