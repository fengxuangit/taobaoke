<?php
if(!defined('IN_TTAE')) exit('Access Denied');

class Csv{
    public $csv_array; //csv数组数据
    public $csv_str;  //csv文件数据
    public $path;
	public $msg;
	public $filesize = 1; //1MB

    /**
     * 导出

     * */
    public function export($nav_arr,$data_arr){

       $export_str = implode(',',$nav_arr)."\n";

        //组装数据
        foreach($data_arr as $k=>$v){
                $export_str .= implode(',',$v)."\n";
        }

        //将$export_str导出
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header("Content-type:application/vnd.ms-excel");
        $name = time();
        header("Content-Disposition:attachment;filename=".$name.".csv");
        header('Content-Type:APPLICATION/OCTET-STREAM');
        ob_start();
        $export_str=  iconv("utf-8",'gbk',$export_str);
        ob_end_clean();
        echo $export_str;
    }

    /**
     * 导入
     * */
    public function import($path){
        $flag = false;
        $code = 0;
        $this->msg = '未处理';
        $maxsize = $this->filesize * 1024 * 1024;
        $max_column = 1000;

        //检测文件是否存在
        if($flag === false){
            if(!file_exists($path)){
                $this->msg = '文件不存在';
                $flag = true;
            }
        }
        //检测文件格式
        if($flag === false){
			$ext = end(explode('.',$path));
			if($ext != 'csv'){
				 $this->msg = '只能导入CSV格式文件';
				 $flag = true;
			}
        }

        //检测文件大小
        if($flag === false){
            if(filesize($path)>$maxsize){
                $this->msg = '导入的文件不得超过'.$maxsize.'B文件';
                $flag = true;
            }
        }

        //读取文件
        if($flag == false){
            $row = 0;
            $handle = fopen($path,'r');
            $dataArray = array();
            while($data = fgetcsv($handle,$max_column,",")){
                  $num = count($data);
				  for($i=0;$i<$num;$i++){
					  if($row == 0){
						  break;
					  }
					  $dataArray[$row-1][$i] = iconv("gbk", "utf-8",$data[$i]);
				  }
                $row++;
            }
        }

        return $dataArray;
    }
}


?>
