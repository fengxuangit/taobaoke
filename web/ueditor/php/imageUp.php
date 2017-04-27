<?php
    header("Content-Type:text/html;charset=utf-8");
    error_reporting( E_ERROR | E_WARNING );
    date_default_timezone_set("Asia/chongqing");
	
	define('ROOT_PATH','./../../../');
	include ROOT_PATH."index.php";
	
	
/*	
    include "Uploader.class.php";
    //上传配置
	$target ='assets/uploads/'.date('Y').'/'.date('m')."/".date('d').'/';	
	
    $config = array(
        "savePath" => $target,             //存储文件夹
        "maxSize" => 2048000 ,                   //允许的文件最大尺寸，单位KB
        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
		 ,"pathFormat"=> "assets/uploads/{yyyy}/{mm}/{dd}/{time}_{rand:10}",
    );
    //上传文件目录
    $Path = $target;

    //背景保存在临时目录中
    $config[ "savePath" ] = $Path;
    $up = new Uploader( "file" , $config );
    $type = $_REQUEST['type'];
    $callback=$_GET['callback'];

    $info = $up->getFileInfo();

    if($callback) {
        echo '<script>'.$callback.'('.json_encode($info).')</script>';
    } else {
		
        echo json_encode($info);
		exit;
    }*/