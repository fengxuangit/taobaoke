<?php

/**
 * 发送验证码请求
 * @author auto create
 */
class SendVerCodeRequest
{
	
	/** 
	 * appKey
	 **/
	public $appKey;
	
	/** 
	 * 业务类型
	 **/
	public $bizType;
	
	/** 
	 * 设备id
	 **/
	public $deviceId;
	
	/** 
	 * 设备级别的发送次数限制
	 **/
	public $deviceLimit;
	
	/** 
	 * 发送次数限制的时间，单位为秒
	 **/
	public $deviceLimitInTime;
	
	/** 
	 * 场景域，比如登录的验证码不能用于注册
	 **/
	public $domain;
	
	/** 
	 * 验证码失效时间，单位为秒
	 **/
	public $expireTime;
	
	/** 
	 * 外部的id
	 **/
	public $externalId;
	
	/** 
	 * 手机号
	 **/
	public $mobile;
	
	/** 
	 * 手机号的次数限制
	 **/
	public $mobileLimit;
	
	/** 
	 * 手机号的次数限制的时间
	 **/
	public $mobileLimitInTime;
	
	/** 
	 * session id
	 **/
	public $sessionId;
	
	/** 
	 * session级别的发送次数限制
	 **/
	public $sessionLimit;
	
	/** 
	 * 发送次数限制的时间，单位为秒
	 **/
	public $sessionLimitInTime;
	
	/** 
	 * 签名id
	 **/
	public $signatureId;
	
	/** 
	 * 模板id
	 **/
	public $templateId;
	
	/** 
	 * 用户id
	 **/
	public $userId;	
}
?>