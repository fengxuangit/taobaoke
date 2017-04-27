<?php
if(!defined('IN_TTAE')) exit('Access Denied');


class ad extends app{
    public function main(){
        global $_G;
        if(!$_GET['id']){
            showmessage('抱歉,ID不存在');
            return false;
        }
        
        $id = intval($_GET[id]);
        
        $ad = $_G[ad]['k'.$id];
        if(!$ad[id] || $ad[hide]==1 || $ad[show]==false){
            showmessage('抱歉,未找到广告或广告禁止查看..');
            return false;
        }
        
        $this->add(array('ad'=>$ad));
        seo($ad[title] .' - '.$_G['setting'][title]);
        $this->show();
    }
    
    
}
?>