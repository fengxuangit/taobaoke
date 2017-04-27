<?php
/**
 * 商品检测类
 */

class api_cloud  {
			public $app ;
			public $msg = '';

			function __construct(){
				 
			}

			function setAppId($app){
				global $_G;
				$appid = $_G['setting']['apicloud_appid'];
				$appkey = $_G['setting']['apicloud_appkey'];
				
				$now = TIMESTAMP;
				$app->httpheader = array(
		            "X-APICloud-AppId: ".$appid,
		            "X-APICloud-AppKey: ".sha1($appid."UZ".$appkey."UZ".$now).".".$now
		        );
			}
			function count_app($start,$end){
				
				$data =  $this->count($start,$end,'getAppStatisticDataById');
				return $data;
			}

			function count_version($start,$end){
				$data=  $this->count($start,$end,'getVersionsStatisticDataById');
				
				$vers = array();
				foreach($data as $k=>$v){
					$key = $v['versionCode'].'';
					$vers[$key] = array('versionCode'=>$key,'devicesCount'=>0,'newRegsCount'=>0,'newUpdateCount'=>0,'totalOperations'=>0);
				}


				$rs = array();
				foreach($data as $k=>$v){

					$key = $v['versionCode'].'';
					$vers[$key]['reportDate'] = $v['reportDate'];
					$vers[$key]['versionCode'] = $v['versionCode'];
					
					$vers[$key]['newRegsCount'] += $v['newRegsCount'];
					$vers[$key]['newUpdateCount'] += $v['newUpdateCount'];
					$vers[$key]['totalOperations'] += $v['totalOperations'];

					$vers[$key]['devicesCount'] =  $vers[$key]['newRegsCount']+$vers[$key]['newUpdateCount'];
				}
				return $vers;
			}

			function count_local($start,$end,$version){
				$data= $this->count($start,$end,'getGeoStatisticDataById',$version);
				$vers = array();
				foreach($data as $k=>$v){
					$key = $v['versionCode'].'';
					$vers[$key] = array(
						'versionCode'=>$key,'geoNewRegsResult'=>array(),'geoDevicesCountResult'=>array(),'geoStartupCountResult'=>array(),'geoActiveCountResult'=>array());
				}


				$rs = array();
				foreach($data as $k=>$v){
					$key = $v['versionCode'].'';
					$vers[$key]['reportDate'] = $v['reportDate'];
					$vers[$key]['versionCode'] = $v['versionCode'];
					
					$vers[$key]['geoNewRegsResult'] = $v['geoNewRegsResult'];
					$vers[$key]['geoDevicesCountResult'] = $v['geoDevicesCountResult'];
					$vers[$key]['geoStartupCountResult'] = $v['geoStartupCountResult'];
					$vers[$key]['geoActiveCountResult'] = $v['geoActiveCountResult'];

					//$vers[$key]['devicesCount'] =  $vers[$key]['newRegsCount']+$vers[$key]['newUpdateCount'];
				}

				dump($vers);
				return $vers;
			}

			private function count($startDate,$endDate,$type,$version){

				include ROOT_PATH.'/web/lib/Apicloud/ApicloudModel.php';
				$app = new ApicloudModel();
				$this->setAppId($app);
				$url = "https://p.apicloud.com/analytics/".$type;
    			$body = "startDate=$startDate&endDate=$endDate";
    			if($version) $body.="&versionCode=".$version;

				$rs = $app->post($url,$body);
				$rs = json_decode($rs,true);

				if($rs['st'] != 1){
					$this->msg = $rs['msg'];
					return false;
				} 
				foreach($rs['msg'] as $k=>$v){
					$rs['msg'][$k]['reportDate'] = preg_replace("/T(.*)$/is","",$v['reportDate']);
					$rs['msg'][$k]['totalUseTime'] = ceil($v['totalUseTime']/60);
					$rs['msg'][$k]['todayUsingTime'] = ceil($v['todayUsingTime']/60);
				}
				return $rs['msg'];
			}

}

?>