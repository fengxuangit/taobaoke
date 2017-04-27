<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
/**
 * Class Curl
 * $referer = 'http://ai.taobao.com/style/index.htm';
 * demo $rs = $curl->post($url, $post_data, $referer);
 * return str
 */


class Curl {
    public $CURLOPT_MAXREDIRS = 5;  //指定最多的HTTP重定向的数量
    public $ch = null;
    public $error = '';
    public $info = array();
    public $header = array();

    public $debug = false;
    public $cookie_dir = '';
    public $cookie_file = '';
    public $is_save_cookie = true;
    public $is_get_headers = false;
    public $ip = '';
    public $url = '';
    public $msg = '';
    public $referer = '';
    public $header_info = '';
	public $proxy='http://127.0.0.1:8888';
    public $location =array();
	
	
    function __construct($cookie_file,$proxy) {
		$this->ip = gethostbyname($_SERVER["SERVER_NAME"]);
        if($cookie_file) $this->cookie_file = $cookie_file;
		if($proxy) $this->proxy = $proxy;
    }
	
	public function add_head($k,$v){
		$this->head[$k] = $v;
	}
    private function init() {
		if(!function_exists('curl_init'))   throw new Exception ( '您的当前环境不支持curl,请开通后再使用');
		
        $this->ch = curl_init();
        if ($this->debug && $this->proxy) {
            //本机开启代理,抓包时非常有用.
           curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy);
        }
		
        curl_setopt($this->ch, CURLOPT_HEADER, false);        //将头文件的信息作为数据流输出。
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true); // 使用自动跳转
        curl_setopt($this->ch, CURLOPT_MAXREDIRS, 5);     //指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的。
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true); // 自动设置Referer
		curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
       // curl_setopt($this->ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));


        if ($this->is_save_cookie) {
            if (!$this->cookie_file) {
                $uri = parse_url($this->url);
                $this->cookie_file = str_replace('.','_',$uri['host']). '.txt';
            }

            if(!is_dir(dirname(__FILE__).'/'.$this->dir)) dmkdir(dirname(__FILE__).'/'.$this->dir);
            $this->cookie_file = dirname(__FILE__).'/'.$this->dir.$this->cookie_file ;
            if (!file_exists($this->cookie_file)) {
                file_put_contents($this->cookie_file, '');
            }

            curl_setopt($this->ch, CURLOPT_COOKIE, true);
            curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookie_file); // 存放Cookie信息的文件名称
            curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie_file); // 读取上面所储存的Cookie信息
        }
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
        curl_setopt($this->ch, CURLOPT_HEADER, $this->is_get_headers); // 显示返回的Header区域内容


        curl_setopt($this->ch, CURLOPT_REFERER, $this->referer ? $this->referer : $this->url);

        $header = array(
            "Accept: */*",
            "Accept-Language: zh-CN,zh;q=0.8",
            "Cache-Control:no-cache",
            "Connection:keep-alive",
            "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'],
        );
        if ($this->ip) {
            $header[] = "X-Forwarded-For: " . $this->ip;
            $header[] = "CLIENT-IP: " . $this->ip;
        }
		
		if($this->header && count($this->header)>0){
			foreach($this->header as $k=>$v){
				 $header[] = $k.": ".$v;
			}
		}
		
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header); //设置头信息的地方

    }

    function get($url, $data, $refere) {
          if (!$url)   throw new Exception ( 'URL不能为空');

        $this->referer = $refere;
        $this->method = __FUNCTION__;
        $this->data = $data;

        $this->init();

        if ($data) {
            if (is_array($data)) {
                $data = http_build_query($data);
            }
            if (strpos($url, '?') === false) {
                $url .= "?" . $data;
            } else {
                $url .= $data;
            }
        }
        $this->url = $url;

        return $this->exec();
    }

    function post($url, $data, $refere) {
        if (!$url)   throw new Exception ( 'URL不能为空');

        $this->method = __FUNCTION__;
        $this->url = $url;
        $this->referer = $refere;
        $this->data = $data;
        $this->init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        if ($data) {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        }

        return $this->exec();
    }
	
	

    private function exec() {

        $this->url = str_replace("&amp;", '&', $this->url);

        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        $rs= curl_exec($this->ch);
		
		 
        if ($rs === false) {	
			$this->msg = curl_getinfo($this->ch); 
			if(is_array($this->msg)) $this->msg = 'curl exec error,url:'.$this->msg['url'].',contentType:'.$this->msg['content_type'].',httpCode:'.$this->msg['http_code'];
            curl_close($this->ch);

            throw new Exception ( $this->msg);
        }
        if($this->is_get_headers){
            $headerSize = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
            $this->header_info = substr($rs, 0, $headerSize);
            $rs = substr($rs, $headerSize);
        }

        $code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		
		$this->msg = curl_getinfo($this->ch); 
		if(is_array($this->msg)){
			$this->msg = 'curl exec error,url:'.$this->msg['url'].',contentType:'.$this->msg['content_type'].',httpCode:'.$this->msg['http_code'];
            if($rs)$this->msg .=",return ".$rs;
		}
      
        if ($code == 200) {
            if ($this->is_get_headers) {
                preg_match("/Location: (.*?)$/is", $this->header_info, $arr);
                if ($arr[1]) {
                    $this->location[] = $arr[1];
					curl_close($this->ch);
                    return $this->get($arr[1], '', $this->url);
                }
            }
            return $rs;
        } elseif ($code == 301 || $code == 302 && count($this->location) < $this->CURLOPT_MAXREDIRS) {
            preg_match("/Location: (.*?)\r\n/is", $this->header_info, $arr);
            if ($arr[1]) {
                $this->location[] = $arr[1];
				curl_close($this->ch);
                return $this->get($arr[1], '', $this->url);
            }
        } else {			
			curl_close($this->ch);
            throw new Exception ( $this->msg);
        }
	 	curl_close($this->ch);
        return $rs;

    }

    function rand_ip() {
        $this->ip = rand(10, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
    }


}

?>