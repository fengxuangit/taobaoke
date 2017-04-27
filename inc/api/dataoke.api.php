<?php
/**
 * 
 * @authors TTAE (d_cms@qq.com)
 * @date    2016-08-09 10:06:00
 * @version 1.0.0
 */

class api_dataoke  {
    private $appkey= null;
    private $type = '';
    public $msg = '';
    public $sum = 0;
    private $result = array();
    private $url  = '';
    private $time = 600;
    private $for_cache = false;
    public $is_cache =true;
    public $page = 1;
    public $flag = 0;


    private $cates =array();
    function __construct(){
        global $_G;
        $this->appkey = $_G['setting']['dataoke_appkey'];
        if($_G['setting']['syn_quan_time']>0){
            $this->time = $_G['setting']['syn_quan_time']*60;
        }
        $this->cates = $_G['setting']['dataoke_cate'];
    }


    private function get(){
    	if (!$this->appkey)  {
    		$this->msg='appkey 不能为空';
    		return false;
    	}
         $cachename = $this->type.'_quan_'.$this->page;

		if($this->is_cache){
                $ch = memory('get',$cachename);
                if($ch && is_array($ch) && count($ch)>0){
                        $this->for_cache = true;
                        $this->result = $ch;
          
                        $this->sum = count($ch);

                      return $ch;
                }
        }
        $this->result =  array();
        $url = $this->url .='&appkey='.$this->appkey.'&v=2&page='.$this->page;
         try{
            $rs = fetch ($url);
        }catch(Exception $e){
            L($e->getMessage());
            return false;
        }
      
        if (!$rs) {
            $this->msg = '获取的数据为空';
            return false;
        }

        $data = json_decode($rs,true);
        if (!$data) {
            $this->msg = '解析数据失败';
            return false;
        }

        $this->sum = $data['data']['total_num'];
        $result = false;


        if(!$data['result'] && !$data['data']['result']){
            $result =array();
        }else{
             if (isset($data['result'])) {
                 $result = $this->parse($data['result']);
            }else if(isset($data['data']['result'])){
                  $result = $this->parse($data['data']['result']);
            }else{
                $this->log('接口数据字段未知');
            }
        }

        
        $this->result = $result;


       if($result && $this->is_cache) memory('set',$cachename,$result,$this->time);
        return $result;

    }

    private function parse($goods_list){
        if(!$goods_list || count($goods_list) ==0) return array();
        $rs = array();
        foreach ($goods_list as $k => $v) {
            $tmp            = array();
            $tmp['title']   = $v['Title'];
            $tmp['num_iid'] = $v['GoodsID'];
            $tmp['picurl']   = $v['Pic'];
            $tmp['yh_price']   = $v['Org_Price'];
            $tmp['shop_type']   = $v['IsTmall'] ;
            $tmp['ly']   = $v['Introduce'] ;

            $tmp['sum']   = $v['Sales_num'];
            $tmp['bili']   = intval($v['Commission_jihua']);
         
            $tmp['end_time']   = dmktime($v['Quan_time']);
            
            $tmp['quan_num']   = $v['Quan_surplus'];    //剩余券
            $tmp['quan_sum']   = $v['Quan_receive']+$v['Quan_surplus'];    //券总数
            $tmp['juan_url']   = $v['Quan_link'];
            $tmp['juan_price']   = $v['Quan_price'];
            $cid = $v['Cid'];

            $tmp['fid']   =  $this->cates[$cid];

            // if ($v['ali_click'] && strpos($v['ali_click'],'item.htm') === false) {
            //      $tmp['url']   = $v['ali_click'];
            // }
           $rs[] = $tmp;
        }
        return $rs;
    }

    public function auto_update($flag){
            global $_G;
            if($flag) $this->flag = $flag;
                $this->page = intval($_G['page']);
                if($this->page == 1)  {
                    $_SESSION['sucess'] =0;
                     $_SESSION['error_count'] =0;
                }
                $this->is_cache = false;
                $rs = $this->get_all();
                if($rs || $_SESSION['error_count'] <3){
                    
                    if($rs){
                        $len = $this->update();
                        $_SESSION['sucess'] += $len;
                    }else{
                        $len = 0;
                        $this->msg = '找到0条';
                        $_SESSION['error_count']++;
                    }

                    $msg = $len == 0 ? $this->msg : '更新成功'.$len.'条,4秒后自动下一页,当前第'.$this->page.'页,已更新成功'.$_SESSION['sucess'].'条';
                    echo $msg.'<br/>';
                    $href = '?m='.CURMODULE.'&a='.CURACTION.'&page='.($this->page+1);
                    echo "<script>setTimeout(function(){location.href = '".$href."'},4000);</script>";
                    exit;
                }else{
                    msg('所有商品更新完成,共'.$_G['page'].'页'.$_SESSION['sucess'].'条');
                }
    }

    public function is_update($page=1){
            global $_G;
            if(!$this->is_cache) return true;
            $cachename = 'web_quan_'.$page;
            $ch = memory('get',$cachename);
            if ($ch) {
                return false;
            }else {
                return true;
            }

    }

    public function update(){
        if($this->for_cache) {
            $this->msg = '数据从缓存中提取,无须更新';
            return 0;
        }
        if (count($this->result) == 0) {

            $this->msg = '采集的结果不能为空';
            return false;
        }

        $success = 0;
        foreach ($this->result as $k => $v) {
            $update = array();
            $update['sum'] = $v['sum'];
            $update['quan_num'] = $v['quan_num'];
            $update['quan_sum'] = $v['quan_sum'];
            $update['ly'] = $v['ly'];
           
            $update['fid'] = $v['fid'];
            $update['dateline'] = TIMESTAMP;
             $update['flag'] = $this->flag;

            $num = DB::fetch_first("SELECT aid,juan_url FROM ".DB::table('goods')." WHERE num_iid =".$v['num_iid']);
           if($num['aid']>0){
                       if($num['juan_url'] && strpos($num['juan_url'],'uland.taobao.com') !== false){
                                 unset($update['juan_url']);
                        }

                $r = DB::update('goods',$update,"aid=".$num['aid']);
            }else{
                $r = top('goods','insert',$v);
            }
            
            if($r>0) $success++;
        }
        return $success;
    }

    public function get_web(){
    	$this->type = 'web';
        $this->url = 'http://api.dataoke.com/index.php?r=goodsLink/www&type=www_quan';
    	return   $this->get();
       
    }

	public function get_android(){
        $this->url = 'http://api.dataoke.com/index.php?r=goodsLink/android&type=android_quan';
		$this->type = 'android';
		return   $this->get();
	}

	public function get_ios(){
          $this->url = 'http://api.dataoke.com/index.php?r=goodsLink/ios&type=ios_quan';
		$this->type = 'ios';
		return   $this->get();
    }

    /**
     * 获取全站商品
     * @return [type] [description]
     */
	public function get_all(){
		$this->type = 'all';
        $this->url = 'http://api.dataoke.com/index.php?r=Port/index&type=total';
        return   $this->get();
    }

    /**
     * 实时跑量榜
     * @return [type] [description]
     */
	public function get_hot(){
		$this->type = 'hot';
        $this->url = 'http://api.dataoke.com/index.php?r=Port/index&type=paoliang';
		return   $this->get();
    }

    /**
     * TOP100人气榜
     * @return [type] [description]
     */
	public function get_top(){
		$this->type = 'top';
        $this->url = 'http://api.dataoke.com/index.php?r=Port/index&type=top100';
		return   $this->get();
    }


}