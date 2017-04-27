<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 

class im extends app{
	function __construct(){
     global $_G;

      if($_G['setting']['ww_status'] != 1){
          msg('系统未开启在线客服功能');
      }
       if(!$_G['setting']['appkey']){
          msg('未设置百川的appkey');
      }

  }

  
	function main(){
    global $_G;
   
			$this->show();
	}


	private function del(){
        global $_G;
       
        $rs = false;
        if($_G['uid'] >0){
             $rs =top('im','delete',$_G['uid']);   
        }
        if($rs){
            json(array('status'=>'success','删除成功'));
        }else{
            json('删除失败');
        }
       
    }

    public function get_goods($return = false){
       $rs = array();
        if($return) return $rs;
       json(array('status'=>'success','data'=>$rs));
    }

     private function get_user($return= false){
        global $_G;
       
          if($_G['uid']>0){
            	  $rs =top('im','get_user',$_G['uid']);
            		if(!$rs){
            			 $len =top('im','add',$_G['member']);
                  if($len>0) $rs= top('im','get_user',$_G['uid']);
                }

          }else{
          		    $rs = top('im','get_guest');
              		if(!$rs){
              			top('im','add_guest');	
                		$rs = top('im','get_guest');
              		} 
          }


        $user = array('username'=>$rs['nick'],'uid'=>$rs['userid'],'pw'=>$rs['password'],'picurl'=>$rs['icon_url']);   

         if(strpos($user['picurl'],'http') === false) $user['picurl']= $_G['siteurl'].$user['picurl'];
        if($return) return $user;
        json(array('status'=>'success','data'=>$user));
    }


    public function get_info() {
        global $_G;
       
        $user = $this->get_user(true);
        $goods = $this->get_goods(true);
        $cfg = array('ww_key'=>$_G['setting']['appkey'],'ww_name'=>$_G['setting']['ww_name'],'ww_group_id'=>$_G['setting']['ww_group_id']);

       json(array('status'=>'success','data'=>array('user'=>$user,'goods'=>$goods,'cfg'=>$cfg)));
    }

    public function right_bar(){
        global $_G;
        if($_GET['appkey'] != $_G['setting']['appkey']){
            echo 'Appkey Access Denied';
            exit;
        }
        $uid = substr($_GET['chatNick'],8,100);

        $rs = array('uid'=>$uid,'用户名'=>'匿名');
        if(strpos($uid,'ip_') !== false){
           //匿名用户
        
        }else{
              $uid = intval($uid);
              $data = getuser($uid,'uid');
              $rs['uid'] = $data['uid'];
              $rs['用户名'] = $data['username'];
              $rs['账户积分'] =$data['jf'];
              $rs['账户余额'] =$data['money'];
              $rs['qq'] =$data['qq'];
              $rs['手机号码'] =$data['phone'];
              $rs['姓名'] =$data['name'];
              $rs['邮箱'] =$data['email'];
              $rs['用户组'] =$data['group_name'];
              $rs['地址'] =$data['address'];
              
              $login_time =date('Y-m-d H:i',$data['login_time']);
              if(is_numeric($data['regdate'])){
                $rs['注册时间'] = date('Y-m-d H:i',$data['regdate']);
              }else{
                $rs['注册时间'] = $data['regdate'];
              }
              
              $rs['最后登录ip'] = $data['login_ip'];
              $rs['最后登录时间'] = $data['login_time'];

        }
        $this->add(array('user'=>$rs));
        $this->show();

    }


     function left_bar(){
            $css = '';
            $bar = array(
                array('name'=>'投诉建议','classname'=>'icon-tousu','url'=>''),
                array('name'=>'技术支持','classname'=>'icon-jishu','url'=>''),
                array('name'=>'退换货','classname'=>'icon-tuihuo','url'=>''),
                array('name'=>'订单查询','classname'=>'icon-chaxun','url'=>''),
                array('name'=>'订单修改','classname'=>'icon-dingdan','url'=>''),
                array('name'=>'帮助中心','classname'=>'icon-importedlayerscopy6fill1fill2','url'=>'')
            );
          	$this->add(array('bar'=>$bar));
            $this->show();
    }

    //http://shop.w4000148590.com/im8590.php?a=plugin
  
    //千牛插件接口
    public function plugin(){
        global $_G;
       if(!isset($_GET['method']) || !isset($_GET['ts']) || !isset($_GET['s']) ) die('request error');

       //校验签名
      // if($_GET['ts'] < TIMESTAMP - 60) json('timeout');
       $key = $_G['setting']['ww_synkey'];
       $str = md5( urldecode($_GET['q']) .$key. $_GET['ts']);
       if($str != $_GET['s']) json('check error');
       $data = json_decode(urldecode($_GET['q']),true);
       if($_GET['method'] == 'getprofile'){      
            $this->getProfile($data); 
       }else if($_GET['method'] == 'setprofile'){
       
       }else if($_GET['method'] == 'getitemdetail'){
            $this->getItemDetail($data);
       }else if($_GET['method'] == 'gettradefocus'){    //交易信息

       }

    }


    private function getItemDetail($data){
         $uid = intval($data['userid']);

         $list = array();
         foreach ($data['itemsId'] as $id) {
          if(!is_numeric($id)) continue;
           $tmp = $this->getGoodsInfo($id,$uid);
           if($tmp) $list[] = $tmp;
         }
        $this->json(array('itemDetail'=>$list,'code'=>200,'desc'=>''));        
    }

    private function getGoodsInfo($itemid,$uid){
         global $_G;
      
	     	$goods = D(array('and'=>"AND num_iid=".$itemid));
       
        if(!$goods['aid']) return false;
        $rs = array();

        $rs['itemid'] = $goods['num_iid'];
        $rs['itempic'] = $goods['picurl'];
        $rs['itemname'] = $goods['title'];
        $rs['itemurl'] = $_G['siteurl'].$goods['id_url'];
        $rs['itemprice'] = $goods['yh_price'];

        $extra = array('销量'=>$goods['sum']);
        if($goods['juan_url']) {
            $extra['优惠券链接'] = $goods['juan_url'];
            $extra['优惠券面额'] = $goods['juan_price'];
            $extra['券后价'] = $goods['yh_price'] - $goods['juan_price'];

        }
        $extra['发布时间'] = date('Y-m-d H:i',$goods['posttime']);

        $rs['extra'] = $extra;
        return $rs;
    }

    //获取用户信息
    private function getProfile($data){
          $list = array();

         foreach ($data['userids'] as $uid) {
            $list[] = $this->getUserInfo($uid);
          }

         $this->json(array('users'=>$list));
    }


    private function getUserInfo($uid=0){
      global $_G;
              $user = array('nickname'=>'匿名用户','userid'=>0,'avatar'=>'https://gw.alicdn.com/tps/i3/TB1yeWeIFXXXXX5XFXXuAZJYXXX-210-210.png_100x100.jpg',
                'level'=>'未登录用户');
              //$user['vip'] =array('text'=>$user['level'],'level'=>'','vippic'=>'');
              //$user['trade'] = null;
          if($uid > 0){
                  if($_G['uid']>0 && $_G['uid'] == $uid){
                     $data = $_G['member'];
                  }else{
                      $data = getuser($uid,'uid');
                  }

            			$login_time =date('Y-m-d H:i',$data['login_time']);
            			$extra = array('当前IP'=>$data['login_ip'],'最后登录'=>$login_time,'账户积分'=>$data['jf']);
                  $extra['用户组'] =$data['group_name'];

                  if(is_numeric($data['regdate'])){
                    $extra['注册时间'] = date('Y-m-d H:i',$data['regdate']);
                  }else{
                    $extra['注册时间'] = $data['regdate'];
                  }
                  $picurl = $data['picurl'];
                  if(strpos($picurl,'http') === false)  $picurl= $_G['siteurl'].$picurl;
                  
            			$user = array(
            				'userid'=>$data['uid'],
            				'nickname'=>$data['username'],
            				'email'=>$data['email'],
            				'name'=>$data['name'],
            				'avatar'=>$picurl,
            				'phone'=>$data['phone'],
            				'gender'=>'',
            				'age'=>0,
                    'qq'=>$data['qq'],
            				'address'=>$data['address'],
            				'extra'=>$extra                            
            			);

        }
        return $user;
    }

	function json($arr){
        header("Content-Type: text/json");
        header("KissyIoDataType:json");
        echo json_encode($arr);
        exit;
  }


  
	
}
?>