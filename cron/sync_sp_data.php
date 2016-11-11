<?php

	$www_db_info_ary = require("../caches/configs/database.php");
  //echo $www_db_info_ary["default"]["hostname"];
	$www_hostname = $www_db_info_ary["default"]["hostname"];
	$www_username = $www_db_info_ary["default"]["username"];
	$www_password = $www_db_info_ary["default"]["password"];
	$www_db_name  = $www_db_info_ary["default"]["database"];
	
	
	$acg_db_info_ary = require("../spatialgate_new/caches/configs/database.php");
	
	$acg_hostname = $acg_db_info_ary["default"]["hostname"];
	$acg_username = $acg_db_info_ary["default"]["username"];
	$acg_password = $acg_db_info_ary["default"]["password"];
	$acg_db_name  = $acg_db_info_ary["default"]["database"];
	
	
	$catid = "10000142";
	$tag = "4";
	/*
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully";
	*/	
	
	//連線區*************************************************************
	try {
				//連線次元角落
			   $acg_db=new PDO("mysql:host=".$acg_hostname.";
			                dbname=".$acg_db_name, $acg_username, $acg_password,
			                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			                //PDO::MYSQL_ATTR_INIT_COMMAND 設定編碼
			    $acg_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //錯誤訊息提醒
			    
			    //連線主站
			    $www_db=new PDO("mysql:host=".$www_hostname.";
			                dbname=".$www_db_name, $www_username, $www_password,
			                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			                //PDO::MYSQL_ATTR_INIT_COMMAND 設定編碼
			    $www_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //錯誤訊息提醒
			    
			    
					
    }
	catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    /***************************************************************************/
    
  
    
		//執行區
		get_acg_news();
	echo "執行結束";
	
	
	
	
	
//取得次元角落的新聞資料
function get_acg_news()
{
	Global $acg_db;
	
	//用inputtime排序
	$rv = $acg_db->query("select * from acg_news order by inputtime desc limit 50 ; ");
			    
			    while($row=$rv->fetch(PDO::FETCH_OBJ)){    
			        //PDO::FETCH_OBJ 指定取出資料的型態
			        
			        //echo $row->title."\n";  		       
			     	set_www_news($row->title,$row->thumb,$row->keywords,$row->description,$row->url,$row->status,$row->sysadd,$row->username,$row->inputtime,$row->updatetime,$row->authorname,$row->shortname);
			    }
	
	
	//$www_rv = $www_db->exec(" insert www_news(title) Values(?);",array("123"));
	
}    


//塞資料進主站news
function set_www_news($title,$thumb,$keywords,$desc,$url,$status,$sysadd,$username,$inputtime,$updatetime,$authorname,$shortname)
{
	$title = addslashes($title);
	$keywords = addslashes($keywords);
	$desc = addslashes($desc);


	Global $www_db;
	Global $catid;
	Global $tag;
	//用catid+thumb當主鍵
	//判斷有無該資料
	$rv = $www_db->query(" select id from www_news where catid='$catid' and thumb = '$thumb' ; ");
	
	if($rv->fetchColumn() == 0 )
	{
		$sql = " insert www_news(catid,title,thumb,keywords,description,url,status,sysadd,username,inputtime,updatetime,outhorname,shortname,tag) Values( ";
		
		$sql .= " '$catid','$title','$thumb','$keywords','$desc' ,'$url','$status','$sysadd','$username','$inputtime','$updatetime','$authorname','$authorname','$tag' ";
		
		$sql .= ");";
		
	
		$insert_rv = $www_db->exec($sql);
		
	}
}
	
?>