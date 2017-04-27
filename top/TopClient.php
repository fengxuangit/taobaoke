<?php


class LtLogger
{
	public $conf = array(
		"separator" => "\t",
		"log_file" => ""
	);

	private $fileHandle;

	protected function getFileHandle()
	{
		if (null === $this->fileHandle)
		{
			if (empty($this->conf["log_file"]))
			{
				trigger_error("no log file spcified.");
			}
			$logDir = dirname($this->conf["log_file"]);
			if (!is_dir($logDir))
			{
				mkdir($logDir, 0777, true);
			}
			$this->fileHandle = fopen($this->conf["log_file"], "a");
		}
		return $this->fileHandle;
	}

	public function log($logData)
	{
		
		if ("" == $logData || array() == $logData)
		{
			return false;
		}
		if (is_array($logData))
		{
			$logData = implode("----", $logData);
		}
		$logData = $logData. "\n";

        L($logData);

		//fwrite($this->getFileHandle(), $logData);
	}
}

class RequestCheckUtil
{

	public static function checkNotNull($value,$fieldName) {

		if(self::checkEmpty($value)){
			throw new Exception("client-check-error:Missing Required Arguments: " .$fieldName , 40);
		}
	}


	public static function checkMaxLength($value,$maxLength,$fieldName){
		if(!self::checkEmpty($value) && strlen($value) > $maxLength){
			throw new Exception("client-check-error:Invalid Arguments:the length of " .$fieldName . " can not be larger than " . $maxLength . "." , 41);
		}
	}

	public static function checkMaxListSize($value,$maxSize,$fieldName) {

		if(self::checkEmpty($value))
			return ;

		$list=preg_split("/,/",$value);
		if(count($list) > $maxSize){
				throw new Exception("client-check-error:Invalid Arguments:the listsize(the string split by \",\") of ". $fieldName . " must be less than " . $maxSize . " ." , 41);
		}
	}


	public static function checkMaxValue($value,$maxValue,$fieldName){

		if(self::checkEmpty($value))
			return ;

		self::checkNumeric($value,$fieldName);

		if($value > $maxValue){
				throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " can not be larger than " . $maxValue ." ." , 41);
		}
	}


	public static function checkMinValue($value,$minValue,$fieldName) {

		if(self::checkEmpty($value))
			return ;

		self::checkNumeric($value,$fieldName);

		if($value < $minValue){
				throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " can not be less than " . $minValue . " ." , 41);
		}
	}


	protected static function checkNumeric($value,$fieldName) {
		if(!is_numeric($value))
			throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " is not number : " . $value . " ." , 41);
	}


	public static function checkEmpty($value) {
		if(!isset($value))
			return true ;
		if($value === null )
			return true;
		if(trim($value) === "")
			return true;

		return false;
	}

}


class TopClient
{
	public $appkey;

	public $secretKey;

	public $gatewayUrl = "http://gw.api.taobao.com/router/rest";

	public $format = "json";


	public $checkRequest = true;

	protected $signMethod = "md5";

	protected $apiVersion = "2.0";

	protected $sdkVersion = "top-sdk-php-20120723";

	protected function generateSign($params)
	{
		
		ksort($params);

		$stringToBeSigned = $this->secretKey;

		foreach ($params as $k => $v)
		{
			if("@" != substr($v, 0, 1))
			{
				$stringToBeSigned .= "$k$v";

			}
		}
		unset($k, $v);
		$stringToBeSigned .= $this->secretKey;
       
		 
		return strtoupper(md5($stringToBeSigned));
	//	return strtoupper(md5(iconv("GBK","UTF-8", $stringToBeSigned)));	//如果是GBK的就要转码
	}

	public function curl($url, $postFields = null)
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v)
			{
				
				if("@" != substr($v, 0, 1))				{
					$postBodyString .= "$k=" . urlencode_utf8($v) . "&";
				}
				else
				{
					$postMultipart = true;
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart)
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}
			else
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
          
		}
		$reponse = curl_exec($ch);
		
		if (curl_errno($ch))
		{
			throw new Exception(curl_error($ch),0);
		}
		else
		{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode)
			{
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}

	protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt)
	{
				
		L($apiName.'-'.$requestUrl.'-'.$errorCode.'-'.$responseTxt);
	}

	public function execute($request, $session = null)
	{
		
		if($this->checkRequest) {
			try {
				$request->check();
			} catch (Exception $e) {
				$result->code = $e->getCode();
				$result->msg = $e->getMessage();
				return $result;
			}
		}

		$sysParams["app_key"] = $this->appkey;
		$sysParams["v"] = $this->apiVersion;
		$sysParams["format"] = $this->format;

		$sysParams["sign_method"] = $this->signMethod;
		$sysParams["method"] = $request->getApiMethodName();
		$sysParams["timestamp"] = date("Y-m-d H:i:s");
		$sysParams["partner_id"] = $this->sdkVersion;
		if (null != $session)
		{
			$sysParams["session"] = $session;
		}


		$apiParams = $request->getApiParas();


		$sysParams["sign"] = $this->generateSign(array_merge($apiParams, $sysParams));

		$requestUrl = $this->gatewayUrl . "?";

		foreach ($sysParams as $sysParamKey => $sysParamValue)
		{
			
			$requestUrl .= "$sysParamKey=" . urlencode_utf8($sysParamValue) . "&";
				
		}
		$requestUrl = substr($requestUrl, 0, -1);


       


		try
		{
			$resp = ($this->curl($requestUrl, $apiParams));
			//非TAE,不用转码,不然出问题
			if(TAE){
			//	$resp = utf8_decode($resp);		
			}
           
		}
		catch (Exception $e)
		{
			$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_ERROR_" . $e->getCode(),$e->getMessage());
			$result->code = $e->getCode();
			$result->msg = $e->getMessage();
			return $result;
		}
		$respWellFormed = false;
		if ("json" == $this->format)
		{
			$respObject = json_decode($resp);

			if (null !== $respObject)
			{
				$respWellFormed = true;
				
					foreach ($respObject as $propKey => $propValue)
					{
						$respObject = $propValue;
					}
				
			}
		}
		else if("xml" == $this->format)
		{

			$respObject = @simplexml_load_string($resp);
			if (false !== $respObject)
			{
				$respWellFormed = true;
			}

		}

    if (false === $respWellFormed)
		{
			$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_RESPONSE_NOT_WELL_FORMED",$resp);
			$result->code = 0;
			$result->msg = "HTTP_RESPONSE_NOT_WELL_FORMED";
			return $result;
		}

		if (isset($respObject->code))
		{
			/*$logger = new LtLogger;
			$logger->log(array(
				date("Y-m-d H:i:s"),
				$resp
			));*/
			L($resp);
		}
		return $respObject;
	}

	public function exec($paramsArray)
	{
		
		if (!isset($paramsArray["method"]))
		{
			trigger_error("No api name passed");
		}
		$inflector = new LtInflector;
		$inflector->conf["separator"] = ".";
		$requestClassName = ucfirst($inflector->camelize(substr($paramsArray["method"], 7))) . "Request";

        if (!class_exists($requestClassName))
		{
			L("No such api: " . $paramsArray["method"]);
		}

		$session = isset($paramsArray["session"]) ? $paramsArray["session"] : null;

		$req = new $requestClassName;
		foreach($paramsArray as $paraKey => $paraValue)
		{
			$inflector->conf["separator"] = "_";
			$setterMethodName = $inflector->camelize($paraKey);
			$inflector->conf["separator"] = ".";
			$setterMethodName = "set" . $inflector->camelize($setterMethodName);
			if (method_exists($req, $setterMethodName))
			{
				$req->$setterMethodName($paraValue);
			}
		}
		return $this->execute($req, $session);
	}
}


