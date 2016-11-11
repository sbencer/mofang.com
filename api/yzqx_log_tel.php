<?php
$tel = addslashes($_GET['tel']);
$preg = '/(^0?1[2,3,5,6,8,9]\d{9}$)|(^(\d{3,4})-(\d{7,8})$)|(^(\d{7,8})$)|(^(\d{3,4})-(\d{7,8})-(\d{1,4})$)|(^(\d{7,8})-(\d{1,4})$)/';

$length = strlen($tel);
$time = date('Y-m-d H:i:s',time());
$file_path = dirname(__FILE__) . '/' . 'yzqx_';

if(!preg_match($preg, $tel)){
    $front_num = file_get_contents($file_path . 'front_num.txt');
    echo $front_num;
    if(!isset($_GET['num'])){
        exit;
    }
}
//如果不為空則判斷是否存在電話
if($tel && $length != ''){
    $content = file_get_contents($file_path . 'tels.txt');
    $result = strpos($content,$tel.' ');
}elseif( isset($_GET['num']) ){
    $result = false;    
}

if($result === false){
    if( isset($_GET['tel']) || isset($_GET['num']) ){
        // 加num時，顯示指定條數
        if (isset($_GET['num']) && !isset($_GET['tel'])) {
            $front_num = $_GET['num']-1;
            file_put_contents($file_path . 'front_num.txt' , $front_num);
            $front_num = file_get_contents($file_path . 'front_num.txt');
        }
        // 初始請求預約個數
        if ($tel == 'true_num') {
            $front_num = file_get_contents($file_path . 'front_num.txt');
        } else { // 有人預約
            $line = $tel . ' ' . $time . PHP_EOL;
            file_put_contents($file_path . 'tels.txt', $line, FILE_APPEND);
            $front_num = file_get_contents($file_path . 'front_num.txt');
            $front_num++;
            file_put_contents($file_path . 'front_num.txt' , $front_num);
        }

        echo $front_num;
    }else{// 獲取真實數量
        $num = 0 ;
        $fp = fopen($file_path . 'tels.txt', 'r') or die("open file failure!");
        if($fp){
            while(stream_get_line($fp,8192,"\n")){
                $num++;
            }
            fclose($fp);
        }
        echo $num;
    }
}else{// 已經存在該電話
    echo 'error';
}
