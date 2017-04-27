<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class index extends app{
	public function main(){
			global $_G,$app;
			
			if(isset($_GET[code]) || isset($_GET[state])){
				include_once libfile('action/member');
				$mb = new member();
				$mb->main();
				return false;
			}
			
			seo(!MOBILE ? $_G['setting'][seo_title]:$_G['setting']['title'],$_G['setting'][seo_keywords],$_G['setting'][seo_description],false);
			$this->show();
			
		}
		function desktop(){
			global $_G;
			header("Content=type: text/html charset=".CHARSET);
			$file_name=urlencode_utf8($_G[setting][title]).'.url';
			$content = "[InternetShortcut]
			URL=".$_G[siteurl]."
			IconFile=C:\Windows\system32\SHELL32.dll
			IconIndex=130
			IDList=[{000214A0-0000-0000-C000-000000000046}]
			";
			
			header("Content-type: application/octet-stream");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".strlen($content)); 
			header("Content-Disposition: attachment; filename=".$file_name);
			echo $content;

		}
		
		function all($tpl=''){
				global $_G;				
				
				
				$url = URL.'a=all';
				$sql = make_sql();
				$size = $_G[setting][cate_page] ? $_G[setting][cate_page] : 120;	
				
				$title = '全部商品';
				$name = 'all';
				if(isset($_GET['price']) && ($_GET['price'] == '10' || $_GET['price'] == '10_20')){
					$name = $_GET['price'] == '10' ? 'jk9':'sjk9' ;
					
				}
				seo(!MOBILE ? $_G['setting'][$name.'_seo_tit']:$title,$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);	
			
				if($_GET[tag]){					
							$tag  = trim_html($tag,1);
							$tag = daddslashes($_GET[tag]);				
							$and .="AND FIND_IN_SET('".$tag."', keywords) ";
							$url .="&tag=".urlencode_utf8($tag); 	
							$sql['and'] .= $and;
							$sql['url'] .= $url;	
							$title = $tag;	
				}
				$sql['key'] = 'all_';
				$rs = D($sql,array('url'=>$url.$sql[url],'size'=>$size));		
				ajaxoutput($rs['goods']);				
				$this->add($rs);
				$this->show();
				
				
				
				
		}
			
		function cate(){
				global $_G;
				$and = '';
				$url = URL.'a=cate';
				$id = intval($_GET[id]);
				$cate = $_G[goods_cate][$id];
				$sql = make_sql();
				if(!$cate[id]){
					foreach($_G[goods_cate] as $k=>$v){
						if($cate) break;
						if($v['sub']){
							foreach($v['sub'] as $k1=>$v1){
								if($v1['id'] == $id){
									$cate  = $v1;
									break;
								}
							}
							
						}
					}
					if(!$cate[id]) msg('分类不存在');
					
				}

				if($id){
					
					if($cate['sub']){
						$and .= " AND cate in ( " .$cate['id_in']. "  ) ";
					}else{					
						$and .= " AND cate = ".$id;
					}
					$url .="&id=".$id;
				}
				$sql['and'].=$and;
				$sql[url] = $url.$sql[url];
				$size = $cate[page] ? $cate[page]: $_G[setting][cate_page] ;	
				
				$rs = D($sql,array('url'=>$sql[url],'size'=>$size));
				ajaxoutput($rs['goods']);

				$this->add($rs);
				$this->add(array('cate'=>$cate));
				
				seo(!MOBILE ? $cate[title]:$cate['name'],$cate[keywords],$cate[description]);
				$this->show($cate['tpl'] ? $cate['tpl'] : '');
				
		}
		
		function over(){
					global $_G;
					

					$and=" AND end_time > ".TIMESTAMP;
					$url = URL.'a=over';
					$sql = make_sql();	
					$size = $_G[setting][cate_page] ? $_G[setting][cate_page] : 120;	
					
				
					$rs = D(array('and'=>$and .$sql['and'],'all'=>true,'order'=>' end_time ASC '),
						array('url'=>$url.$sql[url],'size'=>$size));	
					ajaxoutput($rs['goods']);
					seo('已结束活动');
					$this->add($rs);
					$this->show();
		}
		
		function tomorrow(){
					global $_G;
					$h = intval(dgmdate(TIMESTAMP,'H'));
					
					
					if($h<10){		//未到10点显示今日上架的商品
						$start =TODAY;
						$tomorrow = TOMORROW;
						//$tomorrow = TOMORROW_2;	//在10点和16点中间默认显示
					}else{	//上架第二天的商品
						$start =TOMORROW;
						$tomorrow = TOMORROW_2;
					}
					
					$and 	=' AND start_time>='.$start.' AND start_time<'.$tomorrow;
					$url = URL.'a=tomorrow';

					$sql = make_sql();	
					$size = $_G[setting][cate_page] ? $_G[setting][cate_page] : 120;	
					
					$rs = D(array('and'=>$and .$sql['and'],'all'=>true,'order'=>$sql[order],'key'=>'tomorrow'),
						array('url'=>$url.$sql[url],'size'=>$size));	
					
					$rs[h] = $h;
					
					ajaxoutput($rs['goods']);
					
					$name = 'tomorrow';
					seo(!MOBILE ? $_G['setting'][$name.'_seo_tit']:'明日预告',$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);	
					$this->add($rs);
					$this->show();
		}
		function 	history(){
					global $_G;							
					$and =" AND end_time>0 AND end_time < ".TIMESTAMP;

					$url = URL.'a=history';
					$sql = make_sql();	
					$size = $_G[setting][cate_page] ? $_G[setting][cate_page] : 120;	
					
					$rs = D(array('and'=>$and.$sql['and'],'order'=>$sql[order],'all'=>true),
						array('url'=>$url.$sql[url],'size'=>$size));
					ajaxoutput($rs['goods']);
					seo('历史活动');
					$this->add($rs);
					$this->show();
		}
		
		function 	today(){
					global $_G;
					$today = TODAY;
					$tomorrow = TOMORROW;
					
					if($_G['setting']['today_type'] == 1){
						$and = " dateline >=$today AND dateline < $tomorrow  ";
					}else{
						$and =" start_time >=$today AND start_time < $tomorrow  ";
					}


					$url = URL.'a=today';
					$sql = make_sql();	
					$size = $_G[setting][cate_page] ? $_G[setting][cate_page] : 120;	
					
					$rs = D(array('and'=>$and .$sql['and'],'all'=>true,'order'=>$sql[order],'key'=>'today','time'=>120),
							array('url'=>URL.'a=today'.$sql[url],'size'=>$size));	
					ajaxoutput($rs['goods']);
					$name = 'today';
					seo(!MOBILE ? $_G['setting'][$name.'_seo_tit']:'今日新品',$_G['setting'][$name.'_seo_kw'],$_G['setting'][$name.'_seo_desc']);	

					$this->add($rs);
					$this->show();
		}
		
		
		function search(){
				global $_G;
					$and ='';
					$url = URL.'a=search';
					

					
					if($_GET['kw']){		
							$string  = trim_html(stripsearchkey($_GET['kw']));
							
							if(preg_match("/^%+$|^_+$|^\*+$/is",$string)) {
								msg('非法搜索关键字'); 
							}
							$string = safe_output($string);
							if(dstrlen($string)<2){
								msg('要搜索的关键字长度不能小于2'); 
							}else if(dstrlen($string)>20){
								msg('要搜索的关键字长度不能大于20');
							}
							
							$_GET[kw] =$string;
							$url .="&kw=".urlencode_utf8($string);

							$rt = get_keywords($string,'',0);
							if($rt){
								$str = explode(',',$rt);
								foreach ($str as $k => $v) {
									$and .=" AND title like '%$v%' ";
								}
							}else{
								$and .=" AND title like '%$string%' ";
							}

							$sql = make_sql();	
							$size =60;
							
							$rs = D(array('and'=>$and .$sql['and'],'order'=>$sql[order]),array('url'=>$url.$sql[url],'size'=>$size));	
					}else if($_GET['price1'] && $_GET['price2']){						
							$sql = make_sql();	
							$size =60;
							$rs = D(array('and'=>$and .$sql['and'],'all'=>true,'order'=>$sql[order],'key'=>'search'),
							array('url'=>$url.$sql[url],'size'=>$size));						
					}
					ajaxoutput($rs['goods']);
					seo($string.' - 商品搜索');
					$this->add($rs);
					$this->show();

		}
		
		
		function go_pay(){
			global $_G;
			$num_iid = ($_GET['num_iid']);
			$num_iid = get_goods_id($num_iid);
			if(!$num_iid){
				showmessage('宝贝id不正确'); 
				return false;
			}
			
						
			seo('查看商品详情');
			$this->add(array('num_iid'=>$num_iid));
			$this->show();
		}
		
		
		
		

    function task() {
        seo('积分任务');
        $this->show();
    }

    function yaoqing() {
        global $_G;
        seo('会员邀请赚积分');
        $this->show();
    }
		
		function friend_link(){
				seo('友情链接');
				$this->show();
		}
		
		function share(){
					global $_G;
					
						$type = ($_GET[type]);
						if($_GET[id] || $_GET[aid]){
							$aid = $_GET[id] ? intval($_GET[id]) : intval($_GET[aid]);	
							$goods = D(array('and'=>'and aid = '.$aid));
							if($goods[aid]>0){
								$share = get_share($goods);
							}
							
							$desc = '分享商品-'.$goods[title].'-'.$type.'-aid='.$aid;
							$share_type = 'share_goods';
						}else{
							$share = get_share($goods);
							$desc = '分享站点';
							$share_type = 'share_web';
						}						

						if(isset($share[$type]) && $share[$type]){
							$url =  $share[$type];
							if($_G[uid]){								
								
								$count = getcount('sign'," uid = ".$_G[uid]." AND `desc`='".$desc."' AND type = '".$share_type."'");
								
								$is_add = false;
								if($count == 0 ) $is_add = true;
								$today = TODAY;
								
								$count_day = getcount('sign'," uid = ".$_G[uid]." AND type = '".$share_type."' AND dateline >=".$today);
								
								if($share_type == 'web' || $share_type == 'share_web'){
									if($count_day > $_G[setting][share_web_num]) $is_add =false;
								}elseif($share_type == 'share_goods'){
									if($count_day > $_G[setting][share_goods_num]) $is_add =false;
								}
								
								
								if($is_add){
										$jf  	=	$_G[setting][share_goods];
										$add_jf = 	$_G['member']['jf']+$jf;
										$sid =insert_sign(array('desc'=>$desc,'type'=>'share_goods','org_jf'=>$add_jf,'jf'=>$jf));
										if($sid){
											update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
										}
								}
								
							}
						}else{
							$url =  $share['weibo'];
						}
						_header("Location:".$url);
		}
		
		function map(){
			global $_G;
			$tmp = DB::fetch_all("SELECT tag FROM ".DB::table('goods')." WHERE tag != '' ORDER BY aid DESC LIMIT 1000");
			$tags = array();
			foreach($tmp as $k=>$v){
				$tmp2= explode(',',$v[tag]);
				foreach($tmp2 as $v2){
					$tags[] =$v2;
				}
			}
			foreach($_G[setting][goods_tag] as $k=>$v){
				$tags[]=$v;
			}
			$tags = array_filter($tags);
			$tags = array_unique($tags);
			$this->add(array('tags'=>$tags));
			seo('站点地图');
			$this->show();			
		}
		
		  
		function rss(){
			global $_G; 
			$goods = DB::fetch_all("SELECT title,aid,dateline FROM ".DB::table('goods')." ORDER BY aid DESC LIMIT 100");

$rs ='<?xml version="1.0" ?>
<rss version="2.0" xmlns:blogChannel="http://backend.userland.com/blogChannelModule">
  <channel>
	<title>'.$_G[setting][title].'</title>
	<link>'.$_G[siteurl].'</link>
	<description>'.trim_html($_G[setting][seo_description],1).'</description>
	<language>zh-cn</language>
	<copyright>'.trim_html($_G[setting][copyright],1).'</copyright>
	<lastBuildDate>'.gmstrftime(TIMESTAMP).'</lastBuildDate>
	<generator>优淘TAE系统'.TTAE_VERSION.' by d_cms@qq.com</generator>
	<managingEditor>'.$_G[setting][admin_email].'</managingEditor>
	<webMaster>85914984@qq.com</webMaster>
	<ttl>40</ttl>';

foreach ($goods as $k=>$v){
	  $rs .='
	  <item>
	  	<title>'.$v[title].'</title>			
		  <category>'.$_G[all_channel][$v[fid]][name].'</category>
		  <description>'.trim_html($v[description].$v[ly],1).'</description>
		  <pubDate>'.gmstrftime('%a,%d %b %Y %H:%M:%S',$v[dateline]).' GMT</pubDate>
		  <guid>'.$_G[siteurl].URL.'aid='.$v[aid].'</guid>
		  <link>'.$_G[siteurl].URL.'aid='.$v[aid].'</link>
	  </item>';
}
$rs .='
  </channel>
</rss>';
			header('Content-Type: text/xml; charset='.CHARSET);
			echo $rs;
		}
		
		
		function rss_task(){
			global $_G;
			$url = $_G[setting][rss_task];
			if(!$url) msg('站点未开启邮箱订阅功能,无法进行订阅');
			$id = sub_str($url,'id=',-1);
			if(!$id) msg('抱歉,订阅链无效');
			
			$email = '';
			if($_GET['email'] || $_GET['to']){
				$email = urldecode_utf8($_GET['email']?$_GET['email'] : $_GET['to']);
			}elseif($_G[uid] && $_G[member][email]){
				$email = $_G[member][email];
			}
			/*if(!$email){
				msg('必须填写Email地址才能进行订阅..');
			}*/
			
			seo('RSS 订阅');
			$this->add(array('email'=>$email,'id'=>$id));
			$this->show();
			
		}
		function app(){
				seo($_G[setting][title].'手机端app');
				$this->show();
		}
		
		function upload(){
			global $_G;			
			check();
			if(isset($_GET['j'])){
				$arr = array('msg'=>'上传失败,文件不存在','status'=>'error','data'=>'');
			}else{
				$arr = array('state'=>'上传失败,文件不存在','url'=>'','title'=>'','original'=>'','type'=>'.jpg','size'=>1);
			}
			if($_FILES['file']){
				
				/*$arr['status'] = 'success';
				$arr['data']='http://gaitaobao1.alicdn.com/tfscom/TB1eZ1yLXXXXXa.XpXXXXXXXXXX.jpg_220x10000Q90.jpg';
				$arr['msg']='上传成功';
				json($arr);*/
				
				$url = upload($_FILES['file']);
				if($url && is_string($url)){

					if(isset($_GET['j'])){
						$arr['status'] = 'success';
						$arr['data']=$url;
						$arr['msg']='上传成功';
						
					}else{
						$arr['state']='SUCCESS';
						$arr['url']=$url;
					}
				}
			}
			if(isset($_GET['j'])){
				json($arr);
			}else{
				echo json_encode($arr);
				exit;
			}
		}
		
		function friend_link_post(){
			global $_G;
			if($_G['setting']['friend_post'] != 1)  msg('后台已关闭友链自助申请');
			if($_GET['onsubmit'] && check() ){

					if(!check_yzm($_GET['yzm'])){
						msg('验证码效验失败,请重新输入','error');
					}


					$arr = array();
					
					if(!$_GET['url'])msg('您的网址不能为空');
					if(!$_GET['name'])msg('您的网址不能为空');
					
					
					$arr['url'] = trim_html($_GET['url'],1);

					if(strpos($arr['url'],'http') === false) msg('您的网址不正确');

					$arr['name'] = trim_html($_GET['name'],1);
					$arr['content'] = trim_html($_GET['content'],1);
					$arr['hide'] =1;
					$arr['dateline'] =TIMESTAMP;					
					
					
					$count = getcount('friend_link',"url='".$arr['url']."'");
					if($count>0) msg('您的站点已提交成功,请不要重复提交');
					
					$arr = daddslashes($arr);					
					DB::insert('friend_link',$arr);
					
					msg('提交成功,我们会尽快与您联系','success');
				}
			
			
			
			seo('友情链接自助申请');
			$this->show();
			
		}
		

}
?>