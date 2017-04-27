<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright 漏 2013, Tencent Corporation. All rights reserved.
 */

require_once(CLASS_PATH."ErrorCase.class.php");
class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
		global $_G;
        $this->error = new ErrorCase();

		
		$tmp = array(
				'appid'=>$_G[setting][qq_appid],
				'appkey'=>$_G[setting][qq_appkey],
				'host'=>$_G[host],
				'callback'=>$_G[siteurl],
				'scope'=>"all",
				'errorReport'=>true,
				'storageType'=>'file'
		);
		$incFileContents = json_encode($tmp);
        $this->inc = json_decode($incFileContents);
		
        if(empty($this->inc)){
            $this->error->showError("20001");
        }
        if(empty($_SESSION['QC_userData'])){
            self::$data = array();
        }else{
            self::$data = &$_SESSION['QC_userData'];
        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
		$_SESSION['QC_userData'] = self::$data;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
		$_SESSION['QC_userData'] = self::$data;
    }

    function __destruct(){
        $_SESSION['QC_userData'] = self::$data;
    }
}
