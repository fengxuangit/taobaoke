<?php
if(!defined('IN_ADMIN')) exit('Access Denied'); 

class module extends app{
	
		function main(){
				global $_G;
				$this->friend_link();
		}
		
		
		function friend_link(){
				global $_G;
				if($_GET['onsubmit'] && check() ){
					foreach($_GET[ids] as $k=>$v){
						if($_GET[del][$k] ==0) continue;
						$id = intval($v);
						$arr =array();
						$arr['sort'] =	intval($_GET['sort'][$k]);
						$arr['hide'] = $_GET['hide'][$k] ? 1 :0;
						
						if( $_GET['_del_all']==1 && $_GET['del'][$k]){
							
							DB::delete(__FUNCTION__,"id=".intval($id));
							api_post(array('a'=>'delete','table'=>'friend_link','id'=>$id,'pre_key'=>'id'));
						}else{
							api_post(array('a'=>'update','table'=>'friend_link','data'=>$arr,'pre_key'=>'id','id'=>$id));
							DB::update(__FUNCTION__,$arr,"id=".$id);
						}
					}
					api_post(array('m'=>'cache','a'=>'update','cache_list'=>'friend_link'));
					loadcache(__FUNCTION__,'update');
					cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
					return false;
					
				}elseif($_GET['t'] =='del' && $_GET['id']){
					$id = intval($_GET['id']);
					DB::delete(__FUNCTION__,"id=".$id);
					loadcache(__FUNCTION__,'update');
					api_post(array('a'=>'delete','table'=>'friend_link','id'=>$id,'pre_key'=>'id','cache'=>'friend_link'));
					cpmsg('操作成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
					return false;
				}else{
					$friend_link = DB::fetch_all("SELECT * FROM ".DB::table('friend_link')." ORDER BY sort DESC,id DESC",'id');
					foreach($friend_link as $k=>$v){
						$friend_link[$k]['dateline'] = dgmdate($v['dateline'],'u');
					}	
					$_G['friend_link'] = $friend_link;
				}
				
				foreach($_G[friend_link] as $k=>$v){
						if($v[id])$_G[friend_link][$k]['extends'] = '-1';
				}
				
				$this->add(array('count'=>count($_G['friend_link'])));
				$this->show('module/friend_link');
		}
		function friend_link_check(){
				global $_G;

				$host = $_SERVER['HTTP_HOST'];
				$host = str_replace(array('-0','-1','http://','/'),'',$host);
				
				if(count($_G[friend_link])>0){
					foreach($_G[friend_link] as $k=>$v){
						$res= fetch($v[url]);
						if(!$res){
							 $extends =-1;
						}elseif(stripos($res,$host)){
							$extends= 1;
						}else{
							$extends = 0;
						}
						$_G[friend_link][$k]['extends'] = $extends;
					}
				}
				
				$this->add(array('count'=>count($_G['friend_link'])));
				$this->show('module/friend_link');			
		}
		function friend_link_check_ajax(){
				global $_G;

				$host = $_SERVER['HTTP_HOST'];
				$host = str_replace(array('http://','https://','/'),'',$host);
				$id  = intval($_GET[id]);
				$url = $_G[friend_link][$id]['url'];
				if(!$url){
					json(array('status'=>'success','msg'=>'-1'));
				}else{
					try{
						$res= fetch($url);
					}catch(Exception $e){
						$res = false;
					}
						if(!$res){
							 $extends =-1;
						}elseif(stripos($res,$host) !== false){
							$extends= 1;
						}else{
							$extends = 0;
						}
						json(array('status'=>'success','msg'=>$extends));
				}
		}
		function friend_link_add(){
				global $_G;
				//节省一个模板,就得先把这些字段给定义,不然在模板中显示都是NULL,正常的PHP是显示'',TAE的PHP与普通的PHP不一样
				
				
				if($_GET['onsubmit'] && check() ){				
					$friend_link = get_filed('friend_link',$_GET['postdb'],$_GET['id']);
					if($_FILES[file]){	
							$src = upload();
							if($src)	$friend_link[picurl] = $src;
					}
					if($_GET['id']){
						$id = intval($_GET['id']);
						DB::update('friend_link',$friend_link,"id=".$id);
						loadcache('friend_link','update');
						api_post(array('a'=>'update','table'=>'friend_link','data'=>$friend_link,'pre_key'=>'id','id'=>$id,'cache'=>'friend_link'));
						cpmsg('修改成功','success','m='.__CLASS__.'&a='.__FUNCTION__.'&id='.$id);
						return false;
					}else{
						$friend_link['dateline'] = TIMESTAMP;
						$r=DB::insert('friend_link',$friend_link,true);
						if($r>0) api_post(array('a'=>'insert','table'=>'friend_link','data'=>$friend_link,'cache'=>'friend_link','id'=>$r));
						loadcache('friend_link','update');
						cpmsg('添加成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
						return false;
					}
					
				}elseif($_GET['id']){	//编辑
						$id = intval($_GET['id']);
						if(!$_G['friend_link'][$id]) {
							cpmsg('抱歉,该友情链接不存在','error','m='.__CLASS__.'&a=friend_link');
							return false;
						}else{
							$friend_link = $_G['friend_link'][$id];
						}

				}else{
					$friend_link =get_filed('friend_link');
				}
		
				$this->add(array('friend_link'=>$friend_link));
				$this->show();

		}
	
}
?>

