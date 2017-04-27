<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class agreement extends app{

	public function main(){
			global $_G;


			seo('用户使用许可协议');
			$this->show();
		}

	function privacy(){
			global $_G;

			seo('隐私保护声明');

			$this->show();
	}

}
?>
