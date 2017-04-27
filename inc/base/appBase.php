<?php
/**
 * 
 * @authors Super Man (d_cms@qq.com)
 * @date    2016-07-14 19:59:42
 * @version 1.0
 */
if(!defined('IN_APP')) exit('Access Denied');
define('CHARSET', 'UTF-8');
header('Content-Type: text/html; charset='.CHARSET);
define('TIMESTAMP', time());
if(!defined('DEBUG')){
    if(function_exists('error_reporting')) error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR);//E_ALL
}

if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Shanghai');
include _ROOT_PATH.'inc/function/core.function.php';
ob_start();

global $_G;
$_G = array(
    'uid'=>0,
    'username'=>'',
    'member'=>array()
);

abstract class appBase {
    protected $appKey='';
    protected $secretKey='';
    abstract function main();
    function __construct(){

              //  $this->initRequest();

                define("URL",'http://'.$_SERVER['HTTP_HOST'].'/');
                if(!isset($_GET['a']) || !$_GET['a']){
                    if(method_exists($this,'main')){
                        $this->main();
                    }else{
                        msg('未实现的方法main');
                    }                    
                    return ;
                }

                
                $a = $_GET['a'];
                if(!preg_match("/^[a-z_]+$/is",$a)){
                        $this->json("Module String Error");
                }

                if(method_exists($this,$a)){
                    $this->$a();
                }else{
                    $this->json('Action not Found');
                }               
    }

    private  function initRequest(){

                    if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) {
                        $postData=file_get_contents('php://input', true);
                        if($postData){
                            parse_str ($postData,$_POST);
                        }
                    }
                    define('MAGIC_QUOTES_GPC', function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc());
                    if(MAGIC_QUOTES_GPC) {
                        $_GET = dstripslashes($_GET);
                        $_POST = dstripslashes($_POST);
                        $_COOKIE = dstripslashes($_COOKIE);
                    }
                    
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
                        foreach($_POST as $k=>$v){
                            if(!isset($_GET[$k]))  $_GET[$k] =  ($v);
                        }
                    }

    }
    
    public function json($arr,$parse=true){
            header("Content-Type: text/json");
            header("KissyIoDataType:json");
            if(!$parse) {
                echo json_encode($arr);
                exit;
            }
            
            $rs = array('status'=>'error','msg'=>'','data'=>'');
            if(is_array($arr)){
                foreach($arr as $k=>$v){
                    $rs[$k] = $v;
                }
            }else{
                $rs['msg'] =$arr;                
            }
            if($rs['msg'] && (strpos($rs['msg'],'>') !==false || strpos($rs['msg'],'<') !==false)){
                    $rs['msg'] = htmlspecialchars($rs['msg']);
            }

            echo json_encode($rs);
            exit;
	}

    public function setAppKey($appKey='',$secretKey=''){
        if($appKey)$this->appKey = trim($appKey);
        if($secretKey)$this->secretKey = trim($secretKey);
    }
   
}


