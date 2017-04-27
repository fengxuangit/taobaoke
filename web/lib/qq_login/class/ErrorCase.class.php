<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright  2013, Tencent Corporation. All rights reserved.
 */

require_once(CLASS_PATH."Recorder.class.php");

/*
 * @brief ErrorCase类，封闭异常
 * */
class ErrorCase{
    private $errorMsg;

    public function __construct(){
        $this->errorMsg = array(
            "20001" => "<h2>配置文件损坏或无法读取，请重新执行intall</h2>",
            "30001" => "<h2>The state does not match. You may be a victim of CSRF.</h2>",
            "50001" => "<h2>可能是服务器无法请求https协议</h2>可能未开启curl支持,请尝试开启curl支持，重启web服务器，如果问题仍未解决，请联系我们"
            );
    }

    /**
     * showError
     * 显示错误信息
     * @param int $code    错误代码
     * @param string $description 描述信息（可选）
     */
    public function showError($code, $description = '$'){
		
		 if($description == "$"){
            $description= ($this->errorMsg[$code]);
		 }
		msg('登录错误,错误信息:'.$description.'错误代码:'.$code,'error','?m=member&a=login');





        $recorder = new Recorder();
        if(! $recorder->readInc("errorReport")){
            exit('配置文件不正确');//die quietly
        }

		header('Content-Type: text/html; charset=UTF-8');
      //  echo "<meta charset=\"GBK\">";
        if($description == "$"){
            die($this->errorMsg[$code]);
        }else{
            echo "<h3>error:</h3>$code";
            echo "<h3>msg  :</h3>$description";
            exit(); 
			//return 'error:'.$code.'msg:'.$description;
        }
    }
    public function showTips($code, $description = '$'){
    }
}
