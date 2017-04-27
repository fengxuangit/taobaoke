<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class apps extends app{
	public function main(){		
				seo('手机app');
				$this->show();			
		}
		
		function help(){
			seo('帮助中心 '.$_G[setting][title]);
			$this->show();
		}
		function about(){
			seo('关于'.$_G[setting][title]);
			$this->show();
		}
		
		
		
}
?>