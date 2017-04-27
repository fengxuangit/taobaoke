<?php
/**
 * 
 * @authors Super Man (d_cms@qq.com)
 * @date    2016-07-14 19:59:42
 * @version 1.0
 */

if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Shanghai');
include _ROOT_PATH.'inc/base/appBase.php';

abstract class topBase extends appBase {
    static $TOP= NULL;
    function __construct(){
           parent::__construct();    
    }
    
   function T($name='',$method='',$data='',$data1=''){
        if(self::$TOP   == NULL){
            include_once    (_ROOT_PATH.'inc/top/TopClient.php');
            $c = new TopClient;
            $c->format= 'json';

            if($this->appKey && $this->secretKey){
              $c->appkey =  $this->appKey;
              $c->secretKey = $this->secretKey;
            }else{
                msg('百川appKey未配置,无法进行操作');
            }
            self::$TOP = & $c;
        }

        if(!$name) return $this->TOP;
        if(is_array($name)){
            $arr = $name;
        }else {
            $arr = array('name'=>$name,'method'=>$method,'data'=>$data,'data1'=>$data1);
        }

        $file_name = _ROOT_PATH.'inc/api/'.$arr["name"].'.api.php';
        if((include_once $file_name) === false){
            msg('api文件不存在'.$arr["name"]);
            return;
        }

        $class = "api_".$arr["name"];
        $res =  new $class;

        if($arr['method'] && method_exists($res,$arr['method'])){
            $me = $arr['method'];
            return $res->$me($arr['data'],$arr['data1']);
        }

        return $res;
}
   
}


