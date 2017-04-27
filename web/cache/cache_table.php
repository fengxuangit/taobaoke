<?php
if(!defined('IN_TTAE')) exit('Access Denied');
 //UZ-SYSTEM! cache file, DO NOT modify me!
//Identify: afd2596d76106e0869122ab747264d1c

 return array (
  'ad' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'type' => 
    array (
      'type' => 'tinyint',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'html' => 
    array (
      'type' => 'text',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'width' => 
    array (
      'type' => 'int',
    ),
    'height' => 
    array (
      'type' => 'int',
    ),
    'target' => 
    array (
      'type' => 'tinyint',
    ),
    'start_time' => 
    array (
      'type' => 'int',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'apply' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'fid' => 
    array (
      'type' => 'int',
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'nick' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'images' => 
    array (
      'type' => 'text',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'price' => 
    array (
      'type' => 'decimal',
    ),
    'start_time' => 
    array (
      'type' => 'int',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
    'yh_price' => 
    array (
      'type' => 'decimal',
    ),
    'bili' => 
    array (
      'type' => 'int',
    ),
    'shop_type' => 
    array (
      'type' => 'tinyint',
    ),
    'ly' => 
    array (
      'type' => 'varchar',
    ),
    'sum' => 
    array (
      'type' => 'int',
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'qq' => 
    array (
      'type' => 'varchar',
    ),
    'phone' => 
    array (
      'type' => 'varchar',
    ),
    'check' => 
    array (
      'type' => 'tinyint',
    ),
    'check_msg' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'article' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'tpl' => 
    array (
      'type' => 'varchar',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'message' => 
    array (
      'type' => 'text',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'description' => 
    array (
      'type' => 'varchar',
    ),
    'views' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'black' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'seller_uid' => 
    array (
      'type' => 'int',
    ),
    'seller_username' => 
    array (
      'type' => 'varchar',
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'desc' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'brand' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'tui' => 
    array (
      'type' => 'tinyint',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'cache' => 
  array (
    'cname' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
    'data' => 
    array (
      'type' => 'longtext',
    ),
  ),
  'cate' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'fup' => 
    array (
      'type' => 'int',
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'description' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'pic_url' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'tpl' => 
    array (
      'type' => 'varchar',
    ),
    'page' => 
    array (
      'type' => 'tinyint',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'channel' => 
  array (
    'fid' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'fup' => 
    array (
      'type' => 'int',
    ),
    'cid' => 
    array (
      'type' => 'int',
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'classname' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'description' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'channel_tpl' => 
    array (
      'type' => 'varchar',
    ),
    'goods_tpl' => 
    array (
      'type' => 'varchar',
    ),
    'page' => 
    array (
      'type' => 'tinyint',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
  ),
  'comment' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'type_id' => 
    array (
      'type' => 'int',
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'check' => 
    array (
      'type' => 'tinyint',
    ),
    'ip' => 
    array (
      'type' => 'varchar',
    ),
    'is_reply' => 
    array (
      'type' => 'tinyint',
    ),
    'reply_id' => 
    array (
      'type' => 'int',
    ),
    'jf' => 
    array (
      'type' => 'int',
    ),
    'ding' => 
    array (
      'type' => 'int',
    ),
    'cai' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'detail' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'price' => 
    array (
      'type' => 'decimal',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'bili' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'duihuan' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'cate' => 
    array (
      'type' => 'tinyint',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'price' => 
    array (
      'type' => 'int',
    ),
    'sum' => 
    array (
      'type' => 'int',
    ),
    'apply_count' => 
    array (
      'type' => 'int',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'jf' => 
    array (
      'type' => 'int',
    ),
    'start_time' => 
    array (
      'type' => 'int',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'duihuan_apply' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'duihuan_id' => 
    array (
      'type' => 'int',
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'wangwang' => 
    array (
      'type' => 'varchar',
    ),
    'truename' => 
    array (
      'type' => 'varchar',
    ),
    'address' => 
    array (
      'type' => 'varchar',
    ),
    'phone' => 
    array (
      'type' => 'varchar',
    ),
    'ip' => 
    array (
      'type' => 'varchar',
    ),
    'status' => 
    array (
      'type' => 'tinyint',
    ),
    'statustime' => 
    array (
      'type' => 'int',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'alipay' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'favorite' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'type_id' => 
    array (
      'type' => 'int',
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'jf' => 
    array (
      'type' => 'tinyint',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'fetch' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'fid' => 
    array (
      'type' => 'int',
    ),
    'value' => 
    array (
      'type' => 'text',
    ),
    'count' => 
    array (
      'type' => 'int',
    ),
    'sum' => 
    array (
      'type' => 'int',
    ),
    'updatetime' => 
    array (
      'type' => 'int',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'friend_link' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'goods' => 
  array (
    'aid' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'fid' => 
    array (
      'type' => 'int',
    ),
    'sid' => 
    array (
      'type' => 'varchar',
    ),
    'flag' => 
    array (
      'type' => 'tinyint',
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'description' => 
    array (
      'type' => 'varchar',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'nick' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'images' => 
    array (
      'type' => 'text',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'price' => 
    array (
      'type' => 'decimal',
    ),
    'message' => 
    array (
      'type' => 'text',
    ),
    'start_time' => 
    array (
      'type' => 'int',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
    'yh_price' => 
    array (
      'type' => 'decimal',
    ),
    'views' => 
    array (
      'type' => 'int',
    ),
    'like' => 
    array (
      'type' => 'int',
    ),
    'bili' => 
    array (
      'type' => 'int',
    ),
    'shop_type' => 
    array (
      'type' => 'tinyint',
    ),
    'ly' => 
    array (
      'type' => 'varchar',
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'type_id' => 
    array (
      'type' => 'int',
    ),
    'sum' => 
    array (
      'type' => 'int',
    ),
    'juan_url' => 
    array (
      'type' => 'varchar',
    ),
    'juan_price' => 
    array (
      'type' => 'int',
    ),
    'quan_num' => 
    array (
      'type' => 'int',
    ),
    'quan_sum' => 
    array (
      'type' => 'int',
    ),
    'tkl' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
    'posttime' => 
    array (
      'type' => 'int',
    ),
    'bili_type' => 
    array (
      'type' => 'tinyint',
    ),
    'status' => 
    array (
      'type' => 'tinyint',
    ),
    'brand_id' => 
    array (
      'type' => 'int',
    ),
  ),
  'group' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'power' => 
    array (
      'type' => 'text',
    ),
    'login_admin' => 
    array (
      'type' => 'tinyint',
    ),
    'system' => 
    array (
      'type' => 'tinyint',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'jf_min' => 
    array (
      'type' => 'int',
    ),
    'jf_max' => 
    array (
      'type' => 'int',
    ),
    'fanli' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'img' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'text',
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'description' => 
    array (
      'type' => 'varchar',
    ),
    'like' => 
    array (
      'type' => 'int',
    ),
    'hate' => 
    array (
      'type' => 'int',
    ),
    'message' => 
    array (
      'type' => 'text',
    ),
    'from_name' => 
    array (
      'type' => 'varchar',
    ),
    'from_url' => 
    array (
      'type' => 'varchar',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'like' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'type_id' => 
    array (
      'type' => 'int',
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'jf' => 
    array (
      'type' => 'tinyint',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'like_type' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'member' => 
  array (
    'uid' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'password' => 
    array (
      'type' => 'varchar',
    ),
    'email' => 
    array (
      'type' => 'varchar',
    ),
    'key' => 
    array (
      'type' => 'varchar',
    ),
    'money' => 
    array (
      'type' => 'decimal',
    ),
    'groupid' => 
    array (
      'type' => 'tinyint',
    ),
    'seller' => 
    array (
      'type' => 'tinyint',
    ),
    'jf' => 
    array (
      'type' => 'int',
    ),
    'max_jf' => 
    array (
      'type' => 'int',
    ),
    'wangwang' => 
    array (
      'type' => 'varchar',
    ),
    'qq' => 
    array (
      'type' => 'varchar',
    ),
    'weixin' => 
    array (
      'type' => 'varchar',
    ),
    'phone' => 
    array (
      'type' => 'varchar',
    ),
    'address' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'varchar',
    ),
    'regip' => 
    array (
      'type' => 'varchar',
    ),
    'login_ip' => 
    array (
      'type' => 'varchar',
    ),
    'login_time' => 
    array (
      'type' => 'int',
    ),
    'login_count' => 
    array (
      'type' => 'int',
    ),
    'regdate' => 
    array (
      'type' => 'int',
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'sex' => 
    array (
      'type' => 'tinyint',
    ),
    'order_number' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'login_name' => 
    array (
      'type' => 'varchar',
    ),
    't_uid' => 
    array (
      'type' => 'int',
    ),
    'alipay' => 
    array (
      'type' => 'varchar',
    ),
    'alipay_name' => 
    array (
      'type' => 'varchar',
    ),
    't_name' => 
    array (
      'type' => 'varchar',
    ),
    'login_id' => 
    array (
      'type' => 'varchar',
    ),
    'email_check' => 
    array (
      'type' => 'tinyint',
    ),
    'phone_check' => 
    array (
      'type' => 'tinyint',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
    'check' => 
    array (
      'type' => 'tinyint',
    ),
    'auto_update' => 
    array (
      'type' => 'tinyint',
    ),
  ),
  'message' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'contact' => 
    array (
      'type' => 'varchar',
    ),
    'company_name' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'check' => 
    array (
      'type' => 'tinyint',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'money' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'type' => 
    array (
      'type' => 'tinyint',
    ),
    'money' => 
    array (
      'type' => 'decimal',
    ),
    'org_money' => 
    array (
      'type' => 'decimal',
    ),
    'desc' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'nav' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'target' => 
    array (
      'type' => 'tinyint',
    ),
    'classname' => 
    array (
      'type' => 'varchar',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'type' => 
    array (
      'type' => 'tinyint',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'news' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'images' => 
    array (
      'type' => 'text',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'views' => 
    array (
      'type' => 'int',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'goods' => 
    array (
      'type' => 'text',
    ),
    'check' => 
    array (
      'type' => 'tinyint',
    ),
    'like' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
    'image_type' => 
    array (
      'type' => 'tinyint',
    ),
    'vedio' => 
    array (
      'type' => 'varchar',
    ),
  ),
  'order_list' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'num' => 
    array (
      'type' => 'int',
    ),
    'price' => 
    array (
      'type' => 'decimal',
    ),
    'yongjin' => 
    array (
      'type' => 'decimal',
    ),
    'bili' => 
    array (
      'type' => 'decimal',
    ),
    'pingtai' => 
    array (
      'type' => 'varchar',
    ),
    'num_iid' => 
    array (
      'type' => 'varchar',
    ),
    'order_number' => 
    array (
      'type' => 'varchar',
    ),
    'create_time' => 
    array (
      'type' => 'int',
    ),
    'status' => 
    array (
      'type' => 'tinyint',
    ),
    'type' => 
    array (
      'type' => 'tinyint',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'jf' => 
    array (
      'type' => 'int',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
  ),
  'pics' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'fup' => 
    array (
      'type' => 'int',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
  ),
  'pics_type' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
  ),
  'setting' => 
  array (
    'name' => 
    array (
      'type' => 'varchar',
    ),
    'value' => 
    array (
      'type' => 'text',
    ),
  ),
  'shop' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'shop_type' => 
    array (
      'type' => 'tinyint',
    ),
    'shop_tag' => 
    array (
      'type' => 'tinyint',
    ),
    'nick' => 
    array (
      'type' => 'varchar',
    ),
    'sid' => 
    array (
      'type' => 'varchar',
    ),
    'start_time' => 
    array (
      'type' => 'int',
    ),
    'end_time' => 
    array (
      'type' => 'int',
    ),
    'zk' => 
    array (
      'type' => 'float',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'description' => 
    array (
      'type' => 'varchar',
    ),
    'desc' => 
    array (
      'type' => 'text',
    ),
    'pic_path' => 
    array (
      'type' => 'varchar',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'banner' => 
    array (
      'type' => 'varchar',
    ),
    'url' => 
    array (
      'type' => 'varchar',
    ),
    'hide' => 
    array (
      'type' => 'tinyint',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'sign' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'jf' => 
    array (
      'type' => 'int',
    ),
    'ip' => 
    array (
      'type' => 'varchar',
    ),
    'org_jf' => 
    array (
      'type' => 'int',
    ),
    'type' => 
    array (
      'type' => 'varchar',
    ),
    'type_id' => 
    array (
      'type' => 'int',
    ),
    'add' => 
    array (
      'type' => 'tinyint',
    ),
    'desc' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'style' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'cate' => 
    array (
      'type' => 'int',
    ),
    'keywords' => 
    array (
      'type' => 'varchar',
    ),
    'title' => 
    array (
      'type' => 'varchar',
    ),
    'content' => 
    array (
      'type' => 'text',
    ),
    'images' => 
    array (
      'type' => 'text',
    ),
    'picurl' => 
    array (
      'type' => 'varchar',
    ),
    'views' => 
    array (
      'type' => 'int',
    ),
    'sort' => 
    array (
      'type' => 'int',
    ),
    'goods' => 
    array (
      'type' => 'text',
    ),
    'length' => 
    array (
      'type' => 'tinyint',
    ),
    'check' => 
    array (
      'type' => 'tinyint',
    ),
    'like' => 
    array (
      'type' => 'int',
    ),
    'post' => 
    array (
      'type' => 'tinyint',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'user_url' => 
    array (
      'type' => 'varchar',
    ),
    'user_pic' => 
    array (
      'type' => 'varchar',
    ),
    'user_desc' => 
    array (
      'type' => 'varchar',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'tixian' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    'username' => 
    array (
      'type' => 'varchar',
    ),
    'status' => 
    array (
      'type' => 'tinyint',
    ),
    'money' => 
    array (
      'type' => 'decimal',
    ),
    'org_money' => 
    array (
      'type' => 'decimal',
    ),
    'shouxufei' => 
    array (
      'type' => 'decimal',
    ),
    'msg' => 
    array (
      'type' => 'varchar',
    ),
    'updatetime' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
  'yaoqing' => 
  array (
    'id' => 
    array (
      'type' => 'int',
      'pre' => true,
    ),
    'uid' => 
    array (
      'type' => 'int',
    ),
    't_uid' => 
    array (
      'type' => 'int',
    ),
    'platform' => 
    array (
      'type' => 'tinyint',
    ),
    'reg_platform' => 
    array (
      'type' => 'tinyint',
    ),
    'ip' => 
    array (
      'type' => 'varchar',
    ),
    'regdate' => 
    array (
      'type' => 'int',
    ),
    'dateline' => 
    array (
      'type' => 'int',
    ),
  ),
) 
?>