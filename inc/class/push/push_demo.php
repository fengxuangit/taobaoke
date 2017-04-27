<?php


class APICloud {  
        var $AppID = 'A6909202264743';
        var $AppKey = '5DEC3254-A2B4-BA8C-7A23-4F15374BB9A2';
        var $AppPath = 'https://p.apicloud.com/api/push/message/';
        var $timeOut = 30;
        
        function APICloud()
        {
                $this->headerInfo = array(
                        'X-APICloud-AppId:'.$this->AppID,
                        'X-APICloud-AppKey:'.$this->getSHAKey()
                );
        }
        
        //毫秒
        function getMilliSecond()
        { 
          list($s1, $s2) = explode(' ', microtime()); 
          return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); 
        }
        
        function getSHAKey()
        {
          $time = $this->getMilliSecond();
          return sha1($this->AppID.'UZ'.$this->AppKey.'UZ'.$time).'.'.$time;
        }

        function push($data)
        {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt ($ch, CURLOPT_URL, $this->AppPath);
                curl_setopt ($ch, CURLOPT_HTTPHEADER, $this->headerInfo);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
                $result = curl_exec($ch);
                curl_close($ch);
                 return $result;        
        }
}
	//测试
	$test = new APICloud();
	
	$data = array (
			'title' => '测试标题',
					'content' => '测试内容',
					'type' => 2,
					'timer' => '',
					'platform' => 2,
					'groupName' => '',
	);
	print_r(json_decode($test->push($data)));

?>