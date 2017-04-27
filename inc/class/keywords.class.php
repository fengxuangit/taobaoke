<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
class keywords {
	public $type = 0;
	public $length = 10;
	public $type_name ='';
		/*
			详情查看	http://www.uz-system.com/m-article-id-114.html
			中文分词接口,可实现关键字,热词自动获取 提供3种方法,每一种都有长处有短处
			默认为0
			
			type = 0		discuz热词接口		大小0,不占空间			http远程获取速度比不上其它两个,关键字长度不可自定义获取个数	准确率	高			
			type = 1		简易中文分词系统	大小13M,非常占空间		本地获取,可自定义获取个数									准确率	中			
			type = 2		汉景中文分词系统	体积1M,					本地获取,获取个数不定,但分词可能不太准						准确率	低
		
		*/
		function __construct($type,$length){
			if($type)$this->type = $type;
			if($length)$this->length = $length;
		}
		
		//return 	string
		function get($title,$data){
			$TrimChars=array("▲","△","▼","▽","★","☆","◆","◇","■","□","●","○","⊙","㊣","◎","▂","▁","▃","▄",
								"▅","▆","▇","█","▏","▎","▍","▌","▋","▊","◢","◣","◥","◤","▲","▼","♀","♂","卍","※","【","】");
			$title = str_replace($TrimChars,'',$title);

			if($this->type ==1){
				$rs = 	$this->pscws4($title,$data);
			}else if($this->type ==2){
				$rs = 	$this->HJ_Segword($title,$data);
			}else{
				$rs = 	$this->discuz($title,$data);
			}
			return $rs;
		}
		
		//type = 1
		function pscws4($title,$num){
					$this->type_name = __FUNCTION__;
					if(!$num) $num=$this->length;
					
					
					
					$title = urldecode_utf8($title);
					$title = trim_html($title,1);			
					if(strlen($title)>2400)  $title =  cutstr($title,  800,'');	
					
					$file = ROOT_PATH.'web/lib/pscws4/pscws4.class.php';
					if(!is_file($file))return $this->discuz($title);
					
					
					include_once ROOT_PATH.'web/lib/pscws4/pscws4.class.php';
					$cws = new PSCWS4('utf8');
					$cws->set_dict(ROOT_PATH.'web/lib/pscws4/dict.utf8.xdb');
					//$cws->set_dict(ROOT_PATH.'web/lib/pscws4/a.xdb');
					$cws->set_rule(ROOT_PATH.'web/lib/pscws4/rules.ini');
					//$cws->set_multi(3);
					$cws->set_ignore(true);
					//$cws->set_debug(true);
					//$cws->set_duality(true);
					$cws->send_text($title);
					$words = $cws->get_tops(10,'r,v,p');
					$cws->close();
					$tags = array();
					foreach ($words as $val) {
						$tags[] = $val['word'];
					}
					if(count($tags)>$num) $tags = array_slice($tags,0,$num);
					$tags = implode(',',$tags);
					return $tags;
		}
		//type = 2
		function HJ_Segword($title,$num){
					global $_G;
					$this->type_name = __FUNCTION__;
					if(!$title) return '';
					if(!$num) $num=$this->length;

					
					$title = urldecode($title);
					$title = trim_html($title,1);					
					$file = ROOT_PATH.'web/lib/HJ_SegWord/HJ_SegWord_Class.php';
					if(!is_file($file))return $this->discuz($title);

					
					include_once ROOT_PATH.'web/lib/HJ_SegWord/HJ_SegWord_Class.php';
					$HJ_SegWord = new HJ_Segword_Class();
					if(CHARSET != 'GBK')$title = _iconv($title,CHARSET,'GB2312');	//先转进去
					$tags = $HJ_SegWord->Seg_Word_MM($title);
					$HJ_SegWord->Clear();
					
					if(CHARSET != 'GBK')$tags = _iconv($tags,'GBK',CHARSET);   // 再转回来
					if(count($tags)>$num) $tags = array_slice($tags,0,$num);
					$tags = implode(',',$tags);	
					return $tags;
		}
		//type = 0
		function discuz($title,$content){
					$this->type_name = __FUNCTION__;
					$title = urldecode_utf8($title);
					if($content && !is_numeric($content)){
						if(strlen($content)>2400)  $content =  cutstr($content,  800,'');
						$content = urldecode_utf8($content);
					}else{
						$content = '';
					}
					
					$org_content = $title.$content;					
					$title = rawurlencode(trim_html($title,1));
					$content = rawurlencode(trim_html($content,1));
					$charset = strtolower(CHARSET);
					
					$data = @implode('', file("http://keyword.discuz.com/related_kw.html?ics=utf-8&ocs=utf-8&title=$title&content=$content"));
					if($data) {
									$parser = xml_parser_create();
									xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
									xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
									xml_parse_into_struct($parser, $data, $values, $index);
									xml_parser_free($parser);
									
									$kws = array();							
									foreach($values as $valuearray) {							
										if($valuearray['tag'] == 'kw' || $valuearray['tag'] == 'ekw') {
											$kws[] =trim($valuearray['value']);
										}
									}
									
									$tags = array();									
									if($kws) {
										foreach($kws as $kw) {
											$kw = dhtmlspecialchars($kw);
											$tags[] .= dhtmlspecialchars($kw);
										}
									}
									if(count($tags)==0) return '';									
									if(count($tags)>$this->length) $tags = array_slice($tags,0,$this->length);
									$tags = implode(',',$tags);	
									return $tags;
									
					}else{
						return '';
					}
		}
		
		
}
?>