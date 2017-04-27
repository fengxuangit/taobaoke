<?php
/**
 * TOP API: taobao.sp.item.feed.info.get request
 * 
 * @author auto create
 * @since 1.0, 2014-02-27 17:06:31
 */
class SpItemFeedInfoGetRequest
{
	/** 
	 * 閸熷枣鎼D
	 **/
	private $itemId;
	
	/** 
	 * 閸楁牕顔嶉弫鏉跨搂ID
	 **/
	private $sellerId;
	
	/** 
	 * 濮ｅ繋閲灭粩娆戝仯闀勫嫬鏁稉钪琄ey(阌风姴鐦戦曦鍓唅te id)
	 **/
	private $siteKey;
	
	private $apiParas = array();
	
	public function setItemId($itemId)
	{
		$this->itemId = $itemId;
		$this->apiParas["item_id"] = $itemId;
	}

	public function getItemId()
	{
		return $this->itemId;
	}

	public function setSellerId($sellerId)
	{
		$this->sellerId = $sellerId;
		$this->apiParas["seller_id"] = $sellerId;
	}

	public function getSellerId()
	{
		return $this->sellerId;
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
		return "taobao.sp.item.feed.info.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->itemId,"itemId");
		RequestCheckUtil::checkNotNull($this->sellerId,"sellerId");
		RequestCheckUtil::checkNotNull($this->siteKey,"siteKey");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
