<?php
error_reporting(E_ALL ^ E_NOTICE);
$con = @mysql_connect('10.6.16.194', 'mofang_www', 'RnJ6hp8FQdSW') or die('數據庫連接失敗！');
// $con = @mysql_connect('localhost', 'root', 'mofangmysql') or die('數據庫連接失敗！');
mysql_select_db('linshi',$con);
mysql_query('set names utf8');

$phone = $_GET['phone'];
$qq = $_GET['qq'];
$callback_name = $_GET['jsonpcallback'];

if( !empty($_GET['phone']) && !empty($_GET['qq']) ){
    $sql = "select id,code from libao_code where type = 1 limit 1"; // 查詢一個未發放的禮包碼
    $result = mysql_query($sql);
    if( $row = @mysql_fetch_assoc($result) ){
        $code_id = $row['id'];
        $code = $row['code'];

        $sql = "select * from user_survey where phone = \"".$phone."\" or qq = \".$qq.\"";
        $result = mysql_query($sql);
        if( $row = @mysql_fetch_assoc($result) ){
            $code = $row['code'];
            if($callback_name){
                $data['code'] = 0;
                $data['message'] = 'Success!';
                $data['data'] = $code;
                echo $callback_name.'('.json_encode($data).')';
            }
        }else{
            $sql = "insert into user_survey (phone, qq, code) values ('".$phone."', '".$qq."', '".$code."')"; // 插入發放記錄
            if( mysql_query($sql) ){
                $sql = "update libao_code set type = 0 where id = '".$code_id."'"; // 修改禮包碼狀態
                mysql_query($sql);
                if($callback_name){
                    $data['code'] = 0;
                    $data['message'] = 'Success!';
                    $data['data'] = $code;
                    echo $callback_name.'('.json_encode($data).')';
                }
            }
        }
    }else{
        echo '禮包碼已經發放完！';exit;
    }
}else{
    echo '缺少必要參數！';exit;
}
mysql_close($con);
