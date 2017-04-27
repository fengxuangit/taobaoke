<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class message extends app{
	
	function main(){
		global $_G;
		
		$this->show();
	}
	function post($jump){
			global $_G;
			
			if(!$jump && !check_yzm($_GET['yzm'])){
				msg('验证码效验失败,请重新输入','error');
			}


			$type = trim_html($_GET['type'],1);
			$type_arr = array('message','feedback');
			if(!$type || !in_array($type,$type_arr)){
				$type = 'message';
			}
			if(!$_GET['content']) msg('您提交的留言内容不能为空');

			$arr = array();
			$arr['type'] = $type;
			$arr['content'] = trim_html($_GET['content'],1);			
			$arr['name'] = trim_html($_GET['name'],1);
			$arr['contact'] = trim_html($_GET['contact'],1);
			$arr['company_name'] = trim_html($_GET['company_name'],1);
			$arr['url'] = trim_html($_GET['url'],1);
			$arr['check'] =0;
			$arr['dateline'] =TIMESTAMP;
			
			if($_G['uid']>0 && !$arr['name']) $arr['name'] = $_G['username'];
			if($arr['email'] && !is_email($arr['email']))msg('邮箱格式不正确');
			
			$count = getcount('message',"content = '".$arr['content']."'");
			if($count>0) msg('您的信息我们已收到,感谢提交');
			
			DB::insert('message',$arr);

			msg('您的信息已提交成功','success');
	}
	
	

		
}
?>