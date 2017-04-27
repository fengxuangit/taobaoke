<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class comment extends app{
	

	
	function main(){
			global $_G;
			$type = trim($_GET[type]);
			$id = intval($_GET[id]);
			if(!$_G[setting][say_status])json(array('msg'=>'系统已关闭评论','data'=>-1));
			if(!$id)json(array('msg'=>'分类id不存在'));
			if(!$type)json(array('msg'=>'获取的类型不存在'));
			if(!preg_match("/^[a-z_]+$/",$type)) json(array('msg'=>'类型格式不正确'));			

			if(!array_key_exists($type,$_G[setting][comment_types]))json(array('msg'=>'当前模块不允许评论或留言'));
			
			$page_size =$_G[setting][comment_page_size];
			$and = " AND  type_id = $id AND type = '$type'  AND  `check` = 1   AND is_reply = 0 ";
			if($_GET['num_iid'])$and.=" AND num_iid = ".trim_html($_GET['num_iid']);
			$rs = D(array('and'=>$and,'order'=>' id DESC  ','table'=>'comment'),
				array('size'=>$page_size,'url'=>''));
			$comment  = array();
			
			foreach($rs[goods] as $k=>$v){	
				//$tmp = array('id'=>$v['id'],'uid'=>$v[uid],'username'=>$v[username],'content'=>$v[content],'ip'=>$v[ip],'user_pic'=> $v['user_pic'],'dateline'=>$v[dateline]);
				//$user_picurl = DB::fetch_first("SELECT picurl FROM ".DB::table('member')." WHERE uid = ".$v['uid']);
				$v['user_pic'] = avatar($v['username'],$v['uid']);
				//if($user_picurl['picurl'])$v['user_pic'] = $user_picurl['picurl'];
				
				$and2 = "AND type = '$type' AND type_id = ".$v[type_id]."  AND  `check` = 1   AND is_reply=1 AND reply_id = ".$v[id];
				if($_GET['num_iid'])$and2.=" AND num_iid = ".trim_html($_GET['num_iid']);
				$v[comment_list] = D(array('table'=>'comment','and'=>$and2,'order'=>' id DESC ','limit'=>30));
				$comment[] = $v;
			}
			$max_page = ceil($rs[count]/$page_size);
			
			if($_G['uid']>0){
				if($_G['member']['picurl']){
					$picurl =$_G['member']['picurl'];
				}else{
					$picurl =avatar($_G['username'],$_G['uid']);
				}
			}else{
				$picurl ='assets/global/images/avatar.png';
			}
			
			$comment_msg = $_G[setting][comment_msg] ? trim($_G[setting][comment_msg]):'';
			$data = array('user_pic'=>$picurl,'max_page'=>$max_page,'comment_msg'=>$comment_msg,'data'=>$comment);
			
			$rt =array('status'=>'success','data'=>$data); 
			if(defined('APP'))return $rt;
			json($rt);
	}
	
	
	
	function post(){
			global $_G;
			check_user_power();			
			if($_G[setting][say_status] !=1){				
				 msg('系统已关闭评论功能');
			}
			
			
			
			
			if($_SESSION['comment'] && $_SESSION['comment']['time']>0){
				$last_comment_time  =($_SESSION['comment']['time'])>0 ? TIMESTAMP-intval($_SESSION['comment']['time']):0;
				if($last_comment_time <5) msg('发言太快,请休息一下吧');
			}
			$type = trim($_GET[type]);
			$id = intval($_GET[id]);
			
			if(!$id)msg('抱歉,您要提交的id不能为空');			
			if(!$type)msg('抱歉,评论类型不能为空');
			if(!preg_match("/^[a-z_]+$/",$type)) msg('评论类型格式不正确');
			
			
						
			if(!array_key_exists($type,$_G[setting][comment_types]))msg('当前模块不允许评论或留言');
			
			
			$content = trim($_GET[content]);
			if(!$content)msg('您要评论的内容不能为空');
			$content = safe_filter($content);
			
			$comment_day = $_G[setting][comment_day]>0?$_G[setting][comment_day]:30;			
			
				//天限制
				$today = TODAY;	 							
				$count_day = getcount('comment'," uid=".$_G[uid] ." AND type = '".$type."' AND dateline>".$today);
				if($count_day>$comment_day){
					msg('您今日发布的评论已超过'.$comment_day.'条,待明日再评论吧.');
				}
			
			$comment_month_mod = $_G[setting][comment_month_mod]>0?$_G[setting][comment_month_mod]:300;			
				//月限制
				$day30 = strtotime(date('Y-m-d',strtotime("+30 day")));		
				$count = getcount('comment'," uid=".$_G[uid] ." AND type = '".$type."' AND dateline>".$day30);
				
				if($count_day>$comment_month_mod){
					msg('您本月发布的 '.$_G[setting][comment_types][$type].' 评论已超过'.$comment_month_mod.'条,待下月再来吧.');
				}
			
			
			
			$comment_month_sum = $_G[setting][comment_month_sum]>0?$_G[setting][comment_month_sum]:1000;
			//不限制分类,月限制
			$day30 =  strtotime(date('Y-m-d',strtotime('-1 month')));	
			$count = getcount('comment'," uid=".$_G[uid] ." AND dateline>".$day30);
			if($count_day>$comment_month_sum)	msg('您本月发布的总评论已超过'.$comment_month_sum.'条,待下月再来吧.');
			
			//检查回复的主题id是否存在
			$idname = $type == 'goods' ? 'aid':'id';
			$count_len = getcount($type,$idname.'='.$id);
			if(!$count_len) msg('回复的主题不存在');
			

			if($_G['setting']['comment_filter'] !=1){
				$content  = trim($content);
			//	$html_arr = array('<p><img><a><b><strong><h1><h2><h3><h4><h5><h6><span><em><i><div><table><tr><td><th>');
				//$html_arr = array('<p><img>');
				$content=strip_tags($content);
				$content = str_replace(array('"',"'"),'',$content);
				$content = trim_html($content,1);
			}

			$content = daddslashes($content);
			if($_SESSION['comment'] && $_SESSION['comment']['time']>0){
				$last_content = $_SESSION['comment']['content'] ;
				if($last_content && $content == $last_content)msg('请勿发布同样的内容');
			}
			$arr = array();
			$arr['uid']  = $_G[uid];
			$arr['username']  = $_G[username];
			$arr['dateline']  = TIMESTAMP;
			$arr['ip']  = $_G[clientip];

			$arr['type_id']  = $id;
			$arr['type']  = $type;
			$arr['content']  = $content;
			if($_GET['num_iid'])$arr['num_iid']=trim_html($_GET['num_iid']);
						
			if($_GET[is_reply] && $_GET[reply_id]>0){
				$arr['is_reply']  = 1;
				$arr['reply_id']  = intval($_GET[reply_id]);
			}else{
				$arr['is_reply']  = 0;
				$arr['reply_id']  = 0;
			}
			$arr['picurl']  = '';	
			$arr['check']  = intval($_G[setting][comment_check]);
			
			$jf = 	intval($_G[setting][comment_jf]);
			
			$arr['jf']=$jf;
			$insert_id = DB::insert('comment',$arr,1);
			if(!$insert_id)msg('评论失败');
			
			$msg = '评论成功';
			if($jf>0)	{
					$msg  .= ',恭喜您获得'.$jf.'积分';
					insert_sign(array('desc'=>$msg,'type'=>'comment','org_jf'=>$_G[member][jf],'jf'=>$jf,'type_id'=>$insert_id));
					update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
			}
			
			$_SESSION['comment']['time'] = TIMESTAMP;
			$_SESSION['comment']['content'] = $arr['content'];
			
			
			
			
			$fd = table($type);
			if(isset($fd['comment_count'])){
				$where = '';
				if(isset($fd['id'])){
					$where = 'id=' .$id;
				}else if(isset($fd['aid'])){
					$where ='aid=' .$id;
				}
				$count = getcount(__CLASS__," AND type = '$type' AND type_id = ".$id . " AND `check` =1 ");
				if($where){
					 $r = DB::update($type,array('comment_count'=>$count),$where);
				}
			}

			
			$data = array('user_pic'=>$_G[member][picurl],'id'=>$insert_id,'username'=>$_G[username],
					'dateline'=>TIMESTAMP,'content'=>$arr[content]);			
			if($arr[check] == 0) $msg .= ' 需待审核后才能显示';
			
			if($_G['inajax'] ==1 ){
				json(array('status'=>'success','msg'=>$msg,'data'=>$data));

			}else{			
				msg($msg,'success','',$data);
			}
		
	}
	
	

	function del(){
			global $_G;
			
			
			check_user_power();
			
			$id = intval($_GET[id]);			
			if(!$id)msg('要删除的评论id不存在');
			
			$type = trim($_GET[type]);		
			if(!$type)msg('获取的类型不存在');
			if(!preg_match("/^[a-z_]+$/",$type)) msg('类型格式不正确');
			
			if(!array_key_exists($type,$_G[setting][comment_types]))msg('当前模块不存');
			
			$type_id = intval($_GET[type_id]);			
			if(!$type_id)msg('要删除的评论分类id不存在');
			
			$and = " id = ".$id." AND uid = ".$_G[uid]." AND type = '$type' AND type_id = ".$type_id;
			$comment = DB::fetch_first("select * FROM ".DB::table('comment')." WHERE ".$and);
			if(!$comment[id])msg('未找到要删除的评论');
			if($comment[uid]!= $_G[uid])msg('您无法删除非自己评论的内容');
			
			DB::delete('comment',$and);
			if($comment[is_reply] == 0){
				$and2 = " reply_id = ".$comment[id]."  AND type = '$type' AND type_id = ".$type_id;
				DB::delete('comment',$and2);
			}
			
			$fd = table($type);
			if(isset($fd['comment_count'])){
				$where = '';
				if(isset($fd['id'])){
					$where = 'id = '.$type_id;
				}else if(isset($fd['aid'])){
					$where ='aid=' .$type_id;
				}				
				if($where) {
					$count = getcount(__CLASS__," AND type = '{$type}' AND type_id = ".$type_id );
					DB::update($type,array('comment_count'=>$count),$where);
				}
				
			}
			
			//扣掉用户积分
			
			$jf = $comment['jf'];			
			$msg = '';
			if($jf>0) {
					$msg  .= ',删除评论扣除'.$jf.'个积分';
					$jf = 0-$jf;
					$add_jf = 	$_G['member']['jf']+$jf;
					update_member(array('jf'=>$_G[member][jf]+$jf),$_G[uid]);
					DB::delete('sign'," uid = ".$_G['uid']." AND type_id=".$id." AND type = '".__CLASS__."' ");
			}
			
			if($_G[in_ajax] ==1 ){
				$arr = array('status'=>'success','msg'=>'删除成功'.$msg);
				json($arr);
			}else{
				msg('删除成功'.$msg,'success');
			}
	}

		
}
?>