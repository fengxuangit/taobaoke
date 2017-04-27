<?php

/**
 * 验证验证码
 * @author auto create
 */
class CheckVerCodeRequest
{
	
	/** 
	 * app key
	 **/
	public $appKey;
	
	/** 
	 * 业务类型
	 **/
	public $bizType;
	
	/** 
	 * 最多验证错误几次
	 **/
	public $checkFailLimit;
	
	/** 
	 * 最多验证成功几次
	 **/
	public $checkSuccessLimit;
	
	/** 
	 * 短信验证码域
	 **/
	public $domain;
	
	/** 
	 * 手机号
	 **/
	public $mobile;
	
	/** 
	 * isv user id
	 **/
	public $userId;
	
	/** 
	 * 验证码
	 **/
	public $verCode;	
}
?>