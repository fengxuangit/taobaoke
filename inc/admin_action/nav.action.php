<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class nav extends app{
	
		function main(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
					foreach($_GET[ids] as $k=>$v){
						$id = intval($v);
						$arr =array();
						$arr['sort'] = intval($_GET['sort'][$k]);
						$arr['name'] = trim($_GET['name'][$k]);
						$arr['url'] =trim($_GET['url'][$k]);
						$arr['classname'] =trim($_GET['classname'][$k]);
						$arr['target'] =intval($_GET['target'][$k]);
						$arr['type'] =intval($_GET['type'][$k]);
						$arr['url'] = str_replace($_G['siteurl'],'',$arr['url']);
						if($_GET['_del_all']==1 && $_GET['del'][$k]){
							DB::delete("nav","id=".$id);
						}else{
							DB::update("nav",$arr,"id=".$id);
						}
					}
					loadcache("nav",'update');
					cpmsg('修改成功','success','');
					return false;
				}
				$and = '';
				$url = '';
				if(isset($_GET['types'])){
					$type = intval($_GET['types']);
					$and .= " AND type = ".$type;
					$url.="&types=".$type;
				}

				$nav =  D(array('table'=>__CLASS__,'and'=>$and,'order'=>' `sort` DESC '),array('size'=>100,'url'=>$url));
				$this->add($nav);
				$this->show('nav/main');
		}
	
		
		function post(){
				global $_G;
			
				
				if($_GET['onsubmit'] && check() ){
							$arr = array();
							$nav =get_filed(__CLASS__,$_GET['postdb'],$_GET[id]);
							
							$id = intval($_GET['id']);
							$url = '';
						
						$nav['url'] = str_replace($_G['siteurl'],'',$nav['url']);
						
					
						if(!$nav['url']){
								$nav['url'] = '#';
						}else if( $nav['url'][0] =="?"){
								$nav['url'] = 'index.php'.$nav['url'];
						}
						
						/*else if(strpos($nav['url'],'http') !== false){
						
						}else if( $nav['url'][0] =="?"){
								$nav['url'] = 'index.php'.$nav['url'];
						}else if( substr($nav['url'],0,2) == 'm=' ||  substr($nav['url'],0,2)=='a='){
								$nav['url'] = 'index.php?'.$nav['url'];
						}else if( $nav['url'][0] =="/" &&  strpos($nav['url'],'=') === false &&  strpos($nav['url'],'&') === false  &&  substr($nav['url'],-1) !== "/" ){
								 $nav['url'] .= "/";
						}else if(strpos($nav['url'],'?') === false && strpos($nav['url'],'=') !== false){
								$nav['url'] = 'index.php?'.$nav['url'];						
						}else if(strpos($nav['url'],'?') === false && strpos($nav['url'],'/') === false && strpos($nav['url'],'=') === false){
								$nav['url'] = 'index.php?'.$nav['url'];
						}*/
						
						
							if($_GET[id]){
								$msg = '修改';
								$url = '&id='.$id;
								$id = DB::update('nav',$nav,"id=".$id);

							}else{
								$msg = '添加';
								$nav['dateline'] = TIMESTAMP;
								$r = DB::insert('nav',$nav,true);
								if($r>0){
									$nav['id'] = $r;
								}
							}
							loadcache("nav",'update');							
							cpmsg($msg.'成功','success','m=nav&a=post'.$url);
							
				}elseif($_GET[id]){
					$id = intval($_GET[id]);
					$nav = $_G['nav'][$id];
				}
				
				$this->add(array('nav'=>$nav));
				$this->show();
		}
		
		function del(){
					global $_G;
					
				
					if(!$_GET['id']) {
						cpmsg('抱歉,要删除的导航ID不存在','error',"m=nav&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前导航吗?删除后不可恢复?','error',"m=nav&a=del&ok=1&id=".$id,'确定删除',
								"<p><a href='".URL."m=nav&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("nav","id=".$id);
						loadcache("nav",'update');
						cpmsg('删除成功','success',"m=nav&a=main");
						return false;
					}
					
		}
		
		
		function batpost(){
			global $_G;

				if($_GET['onsubmit'] && check() ){
						$channel = get_filed(__CLASS__);
						
						$all_nav= count($_G['nav']);
						foreach($_GET['tmp'] as $k=>$v){
							$arr = array();
							foreach($channel as $k1=>$v1){
								if($channel == 'id'){
									
								}else if(($k1 == 'name')&& !($_GET[$k1][$k])){
									break;
								}else{
									$arr[$k1] = $_GET[$k1][$k];	
								}
								
							}
							
							if(count($arr)>0){
								$arr['url'] = str_replace($_G['siteurl'],'',$arr['url']);
								
								if(!$arr['url']){
									$arr['url'] = '#';
								}else if( $arr['url'][0] =="?"){
									$arr['url'] = 'index.php'.$arr['url'];
								}
								
								$arr['dateline'] = TIMESTAMP;
								DB::insert('nav',$arr,true);
							}
							
						}
					loadcache("nav",'update');
					cpmsg('批量添加成功','success','m=nav&a=batpost');
				}
						
				$this->show();
		}
		
		
}
?>