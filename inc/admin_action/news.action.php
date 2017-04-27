<?php
if(!defined('IN_ADMIN')) exit('Access Denied');

class news extends app{

		function main(){
			global $_G;
			$url = "m=news&a=main";


			if($_GET['onsubmit'] && check() ){
							foreach($_GET[ids] as $k=>$v){
								if($_GET['del'][$k]){
										$id = intval($k);
										$arr =array();
										$arr['sort'] = intval($_GET['sort'][$k]);
										//$arr['title'] = trim($_GET['title'][$k]);
										$arr['cate'] =	intval($_GET['cates'][$k]);
										$arr['check'] = intval($_GET['check'][$k]);
                                    	//$arr['like'] = intval($_GET['like'][$k]);
                                    if( $_GET['_del_all']==1 && $_GET['del'][$k]){
											DB::delete('news',"id=".$id);
										}else{
											DB::update('news',$arr,"id=".$id);
										}

								}
							}

							msg('修改成功','success','?');

				}

			$and = '';

			if($_GET[cate]){
				$cate = intval($_GET[cate]);
				$and .=" AND cate = ".$cate;
				$url.="&cate=".$cate;
			}

			if($_GET['goods']){				
				$and .=" AND goods = '' ";
				$url.="&danpin=1";
			}

			if(isset($_GET['image_type'])){
				$image_type= intval($_GET['image_type']);				
				$and .=" AND image_type = ".$image_type;
				$url.="&image_type=".$image_type;
			}

			$rs = D(array('table'=>'news','and'=>$and,'order'=>' `sort` DESC,id DESC '),array('url'=>$url,'size'=>40));
			$this->add($rs);
			$this->show();


		}
		function post(){
			global $_G;
			$url = "m=news&a=main";

			$goods  =get_filed('news',$_GET[postdb]);
			if($_GET['onsubmit'] && check() ){
								$dp = get_filed('news',$_GET[postdb],$_GET['id']);
								if(!$dp[title]){
									cpmsg('标题不能为空','error');
									return false;
								}

								$dp['picurl'] = preg_replace("/\.jpg(.*?)$/i",'.jpg',$dp['picurl']);

								if($_FILES[file]){
										$pic = upload();
										if($pic) $dp[picurl] = $pic;
								}

								if($_GET['images']){
									$dp['images'] = $_GET['images'];
									if(is_array($dp['images'])){
										$dp['images'] = array_filter($dp['images']);
										$dp['images'] = implode(',',$dp['images']);
									}else if(is_string($dp['images'])){

									}
								}
								$imgs = array();
								//单品
								$goods = array();
								foreach($_GET[dp_title] as $k=>$v){


										if($_GET[dp_del][$k] ==1) continue;
										$arr = array();
										$arr[title] = $_GET['dp_title'][$k];
										$arr[fid] = $_GET['dp_fids'][$k];
										$arr[price] = sprintf("%.1f",$_GET['dp_price'][$k]);
                                        if (isset($_GET['url'])) {
                                            $arr[url] = ($_GET['url'][$k]);
                                        } else {
                                            $arr[num_iid] = get_goods_id($_GET['dp_num_iid'][$k]);
                                        }

										$arr[picurl] =$_GET['dp_picurl'][$k];
										//将单品的图片加到副图中.
										$imgs = explode(',',$dp['images']);
										if($_GET[postdb]['image_type']==1 && count($imgs)<3)$dp['images'] .=  ','.$arr[picurl];

										if(!$arr[title]) continue;

											$content =$_GET['dp_content'][$k];
											if(!$content) continue;

											$content = json_decode($content,true);

											if(!is_array($content)) continue;

											unset($content['num'],$content['shop_logo'],$content['shop_url'],$content['num']);
											$content['yh_price'] = $arr[price];
											$content['title'] = $arr[title];
											$content['picurl'] = $arr[picurl];
											$content['fid'] = $arr[fid];
											if( $arr['url']) $content['url'] = $arr[url];

											if($content['aid']){
												$aid =$content['aid'];
												unset($content['aid']);

												top('goods','update',$content,$aid);
											}else{
												$content['num_iid'] = $arr[num_iid];
												$content['type']  = __CLASS__;

												$aid = top('goods','insert',$content);
												$content['type_id']  =$aid;
											}

										$goods[] =  $arr['num_iid'];

								}
								$dp[goods] = implode(",",$goods);

								$ext='';
                                $page = '';

								if($_GET['id']){
									$id = intval($_GET['id']);
									$page.="&id=".$id;
									DB::update('news',$dp,"id=".$id);

									if($dp['goods'])DB::query("UPDATE ".DB::table('goods')." set type_id='".$id."',type='news' WHERE num_iid in ( ".$dp['goods']." )");
									$msg = '修改';
								}else{
									$dp['dateline'] = TIMESTAMP;
									$dp[uid] = $_G[uid];
									$dp[username] = $_G[username];
									$dp[check] = 1;
                                    $dp['post'] = 0;
									$r=DB::insert('news',$dp,true);
									//DB::update('goods',array('type'));
					if($r>0 && $dp['goods']) DB::query("UPDATE ".DB::table('goods')." set type_id='".$r."',type='news' WHERE num_iid in ( ".$dp['goods']." )");
									$page.="&id=".$r;
									$msg = '发布';
									$ext.='<a href="'.URL.'m=news&a=post">继续发布</a>';
								}

								cpmsg($msg.'成功','success','m='.__CLASS__.'&a='.__FUNCTION__.$page,'编辑此商品',$ext);
								return false;
				}else if($_GET[id]){

					$goods = D(array('table'=>'news','and'=>' AND id = '.$_G[id]));
						// foreach($goods['goods'] as $k1=>$v1){
						// 	unset($v1['id_url']);
						// 	$content = json_encode($v1);
						// 	$content = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $content);
						// 	$content = stripcslashes($content);
						// 	$goods['goods'][$k1]['content'] =$content;
						// }


					$news_goods = array();
					$num_iids = $goods['goods'];
					if($num_iids && preg_match("/^[0-9,]+$/is",$num_iids)){
							$num_iids = trim($num_iids,',');
							if($num_iids){
								$rs = DB::fetch_all("SELECT aid,fid,num_iid,title,price,yh_price,picurl,url FROM ".DB::table('goods') .
								" WHERE num_iid in (".$num_iids.") ORDER BY aid ASC ");
							}
							if($rs && count($rs)>0){
								foreach($rs as $k=>$v){
									
									$content = json_encode($v);
									$content = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $content);
									$content = stripcslashes($content);
									$v['content'] = $content;
									$news_goods[] = $v;
								}
							}
					}
					
				$goods['goods'] = $news_goods;
			}


			$this->add(array('goods'=>$goods));
			$this->show();


		}

		function check(){
			$check = intval($_GET[check]);
			ajax_check(__CLASS__,array('check' => $check),'id='.intval($_GET[id]));
		}


		function setting(){
				global $_G;
				global $_G;
				if($_GET['onsubmit'] && check() ){
					insert_setting();
					cpmsg('修改成功','success','m='.__CLASS__.'&a='.__FUNCTION__);
					return false;
				}


			$this->show();
		}


		function del(){
					global $_G;
					if(!$_GET['id']){
						cpmsg('抱歉,要删除的资讯ID不存在','error',"m=news&a=main");
						return false;
					}
					$id = intval($_GET['id']);
					if(!$_GET['ok']){
						cpmsg('您确定要删除当前资讯吗?删除后不可恢复?','error',"m=news&a=del&ok=1&id=".$id,'确定删除',
							"<p><a href='".URL."m=news&a=main'>取消</a></p>");
						return false;
					}else{
						DB::delete("news","id=".$id);
						cpmsg('删除成功','success',"m=news&a=main");
						return false;
					}
		}


    function insert() {
        global $_G;
        $dp = get_filed('news', $_GET[postdb], $_GET['id']);
        $cate = intval($_GET['cate']);
        $index = 0;

        foreach ($_GET[data] as $k => $v) {
            if ($_GET['del'][$k] == 1) {
                $dp = json_decode($v, true);
                if ($dp[length] > 0) {
                    $dp[goods] = serialize($dp[goods]);
                }
                $dp['dateline'] = TIMESTAMP;
                $dp[uid] = $_G[uid];
                $dp[username] = $_G[username];
                $dp[check] = 1;
                $dp['post'] = 0;
                $dp['cate'] = $cate;
                unset($dp['id']);
                $r = DB::insert('news', $dp, true);


                $index++;
            }
        }
        $ext = '<a href="' . URL . 'm=news&a=fetch&cate=' . $cate . '&page=' . ($_G['page'] + 1) . '">下一页</a>';
        cpmsg('发布成功' . $index . '条', 'success', 'm=' . __CLASS__ . '&a=fetch','返 回', $ext);

    }




	//	new cate(分类的类型,数据表名);

		function cate(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->main();
		}
		function cate_post(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->post();
		}

		function cate_clear(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->clear();
		}
		function batpost(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->batpost();
		}
		function cate_del(){
			require_once libfile('class/cate');
			$cate = new cate(__CLASS__,__CLASS__);
			$cate->del();
		}

}
?>
