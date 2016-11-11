<?php
/**
 *功能：支付寶接口公用函數
 *詳細：該頁面是請求、通知返回兩個文件所調用的公用函數核心處理文件，不需要修改
 *版本：3.0
 *修改日期：2010-05-24
 '說明：
 '以下代碼只是為了方便商戶測試而提供的樣例代碼，商戶可以根據自己網站的需要，按照技術文檔編寫,並非一定要使用該代碼。
 '該代碼僅供學習和研究支付寶接口使用，只是提供一個參考。

*/
 
/**
 * 生成簽名結果
 * @param $array要加密的數組
 * @param return 簽名結果字符串
*/
function build_mysign($sort_array,$security_code,$sign_type = "MD5") {
    $prestr = create_linkstring($sort_array);     	//把數組所有元素，按照“參數=參數值”的模式用“&”字符拼接成字符串
    $prestr = $prestr.$security_code;				//把拼接後的字符串再與安全校驗碼直接連接起來
    $mysgin = sign($prestr,$sign_type);			    //把最終的字符串加密，獲得簽名結果
    return $mysgin;
}	


/**
 * 把數組所有元素，按照“參數=參數值”的模式用“&”字符拼接成字符串
 * @param $array 需要拼接的數組
 * @param return 拼接完成以後的字符串
*/
function create_linkstring($array) {
    $arg  = "";
    while (list ($key, $val) = each ($array)) {
        $arg.=$key."=".$val."&";
    }
    $arg = substr($arg,0,count($arg)-2);		     //去掉最後一個&字符
    return $arg;
}

/********************************************************************************/

/**除去數組中的空值和簽名參數
 * @param $parameter 加密參數組
 * @param return 去掉空值與簽名參數後的新加密參數組
 */
function para_filter($parameter) {
    $para = array();
    while (list ($key, $val) = each ($parameter)) {
        if($key == "sign" || $key == "sign_type" || $val == "")continue;
        else	$para[$key] = $parameter[$key];
    }
    return $para;
}

/********************************************************************************/

/**對數組排序
 * @param $array 排序前的數組
 * @param return 排序後的數組
 */
function arg_sort($array) {
    ksort($array);
    reset($array);
    return $array;
}

/********************************************************************************/

/**加密字符串
 * @param $prestr 需要加密的字符串
 * @param return 加密結果
 */
function sign($prestr,$sign_type) {
    $sign='';
    if($sign_type == 'MD5') {
        $sign = md5($prestr);
    }elseif($sign_type =='DSA') {
        //DSA 簽名方法待後續開發
        die(L('dsa', 'pay'));
    }else {
        die(L('alipay_error','pay'));
    }
    return $sign;
}

// 日志消息,把支付寶返回的參數記錄下來
function  log_result($word) {
    $fp = fopen("log.txt","a");
    flock($fp, LOCK_EX) ;
    fwrite($fp, L('execute_date', 'pay')."：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}	


/**實現多種字符編碼方式
 * @param $input 需要編碼的字符串
 * @param $_output_charset 輸出的編碼格式
 * @param $_input_charset 輸入的編碼格式
 * @param return 編碼後的字符串
 */
function charset_encode($input,$_output_charset ,$_input_charset) {
    $output = "";
    if(!isset($_output_charset) )$_output_charset  = $_input_charset;
    if($_input_charset == $_output_charset || $input ==null ) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
    } elseif(function_exists("iconv")) {
        $output = iconv($_input_charset,$_output_charset,$input);
    } else die("sorry, you have no libs support for charset change.");
    return $output;
}

/********************************************************************************/

/**實現多種字符解碼方式
 * @param $input 需要解碼的字符串
 * @param $_output_charset 輸出的解碼格式
 * @param $_input_charset 輸入的解碼格式
 * @param return 解碼後的字符串
 */
function charset_decode($input,$_input_charset ,$_output_charset) {
    $output = "";
    if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
    if($_input_charset == $_output_charset || $input ==null ) {
        $output = $input;
    } elseif (function_exists("mb_convert_encoding")) {
        $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
    } elseif(function_exists("iconv")) {
        $output = iconv($_input_charset,$_output_charset,$input);
    } else die("sorry, you have no libs support for charset changes.");
    return $output;
}

/*********************************************************************************/

/**用於防釣魚，調用接口query_timestamp來獲取時間戳的處理函數
注意：由於低版本的PHP配置環境不支持遠程XML解析，因此必須服務器、本地電腦中裝有高版本的PHP配置環境。建議本地調試時使用PHP開發軟件
 * @param $partner 合作身份者ID
 * @param return 時間戳字符串
*/
function query_timestamp($partner) {
    $URL = "https://mapi.alipay.com/gateway.do?service=query_timestamp&partner=".$partner;
	$encrypt_key = "";
    return $encrypt_key;
}
?>