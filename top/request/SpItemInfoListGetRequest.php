<?php
/**
 * TOP API: taobao.sp.item.info.list.get request
 * 
 * @author auto create
 * @since 1.0, 2014-08-14 16:41:32
 */
class SpItemInfoListGetRequest
{
	/** 
	 * 鍟嗗搧ID,鍙壒閲忔煡璇? 澶氢釜鍟嗗搧ID涓棿鐢ㄩ€楀佛鍒嗛殧, 链€澶氩彲镆?0涓猧d, ID涔嬮棿涓嶈兘链夌┖镙?
	 **/
	private $id;
	
	/** 
	 * 姣忎釜绔欑偣镄勫敮涓€Key(锷犲瘑镄剆ite id)
	 **/
	private $siteKey;
	
	private $apiParas = array();
	
	public function setId($id)
	{
		$this->id = $id;
		$this->apiParas["id"] = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setSiteKey($siteKey)
	{
		$this->siteKey = $siteKey;
		$this->apiParas["site_key"] = $siteKey;
	}

	public function getSiteKey()
	{
		return $this->siteKey;
	}

	public function getApiMethodName()
	{
		return "taobao.sp.item.info.list.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->id,"id");
		RequestCheckUtil::checkNotNull($this->siteKey,"siteKey");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
