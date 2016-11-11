<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 新遊接口
  *
  *     @Description
  *         1.根據指定禮包id獲取禮包相關信息專區
  *         2.領號action
  *         3.淘號action
  *
  */

$appkey='mofang_001';

$sign = $_GET;
unset($sign['sign']);
ksort($sign);
$param = array();
foreach($sign as $k=>$v) {
    $param[] = $k."=".$v;
}
$sign = implode('',$param);
$sign = $sign.$appkey;

$db_privilege_account = pc_base::load_model('privilege_account_model');
$db_privilege_account_nums = pc_base::load_model('privilege_account_nums_model');
$db_content = pc_base::load_model('content_model');

$giftid = intval(trim($_GET['giftid']));
$userid = intval(trim($_POST['userid']));

if(!check_sign($_GET['sign'])){
	$data['code'] = 10;
	$data['msg'] = '簽名校驗失敗';
	echo json_encode($data);
	exit();
}
if(!$giftid){
	$data['code'] = 11;
	$data['msg'] = '無禮包id!';
	echo json_encode($data);
	exit();
}
if($_GET['action']!='get_info'&&!$userid){
	$data['code'] = 12;
	$data['msg'] = '無userid!';
	echo json_encode($data);
	exit();
}

switch($_GET['action']){
    case 'get_info':
            $data = get_info($giftid);
        break;
    case 'get_hao':
            $data = get_hao($giftid, $userid);
        break;
    case 'tao_hao':
            $data = tao_hao($giftid, $userid);
        break;
    default:
        $data['code'] = 13;
        $data['msg'] = '參數異常!';
}

echo json_encode($data);
exit();

/*
 * 獲取禮包相關信息
 *
 *  @Param
 *      $giftid 禮包id
 *
 *
 **/
function get_info($giftid){
    global $db_privilege_account,$db_privilege_account_nums;
    $giftid = intval($giftid);
    $sql = '`id`='.$giftid;
    $privilege_info = $db_privilege_account->get_one($sql);

    $all_nums = $db_privilege_account_nums->count('`privilegeid`='.$giftid);
    $last_nums = $db_privilege_account_nums->count('`privilegeid`='.$giftid.' AND `occupy_userid`=0');
    $privilege_info['all_nums'] = $all_nums;
    $privilege_info['last_nums'] = $last_nums;

    $data['code'] = 0;
    $data['data'] = $privilege_info;
    return $data;
}


/*
 * 領號action
 *
 **/
function get_hao($giftid, $userid){
    global $db_privilege_account_nums;

    $user_info = user_info($userid);
    $number_info = $db_privilege_account_nums->get_one('`privilegeid`='.$giftid.' AND `occupy_userid`=0', 'id,number');
    if( $user_info['code']!=1 ){//用戶信息異常
        $data['code'] = 1;
        $data['msg'] = '用戶信息異常!';
    }else if( !$number_info ){//號碼不存在
        $data['code'] = 2;
        $data['msg'] = '號碼已發完!';
    }else if( $has_privilege = $db_privilege_account_nums->get_one( '(`occupy_userid`='.$user_info['data']['uid'].') AND `privilegeid`='.$giftid, 'id,number' ) ){
        $data['code'] = 3;
        $data['number'] = $has_privilege['number'];
        $data['msg'] = '該優惠您已經搶過了!';
    }else{
        $data['code'] = 0;
		$hao_data['number'] = $number_info['number'];
		$hao_data['total'] = $db_privilege_account_nums->count('`privilegeid`='.$giftid);
		$hao_data['last'] = $db_privilege_account_nums->count('`privilegeid`='.$giftid.' AND `occupy_userid`=0');
		$hao_data['last'] -= 1;
        $data['data'] = $hao_data;

		$update_data = array('occupy_userid'=>$user_info['data']['uid'],'occupy_username'=>$user_info['data']['username'],'send_time'=>time());
		$ok = $db_privilege_account_nums->update( $update_data, '`id`='.intval($number_info['id']) );
    }
    return $data;
}

/*
 * 淘號action
 *
 **/
function tao_hao($giftid, $userid){
   global $db_privilege_account_nums;
   $user_info = user_info($userid);
   if( $user_info['code']!=1 ){//用戶信息異常
       $data['code'] = 1;
       $data['msg'] = '用戶信息異常!';
   }else{
       $number_info = $db_privilege_account_nums->get_one('`privilegeid`='.$giftid, 'id,number', '`tao_nums` ASC');
       $update_data['tao_nums'] = '+=1';
       if ($db_privilege_account_nums->update($update_data, '`id`='.$number_info['id'])){
            $data['code'] = 0;
            $hao_data['number'] = $number_info['number'];
            $data['data'] = $hao_data;
       }else{
            $data['code'] = 4;
            $data['msg'] = '淘號失敗!';
       }
   }
   return $data;
}

/*
 * 獲取用戶信息
 *  @Param
 *      $userid 用戶id
 *
 **/
function user_info($userid){
    $data['user'] = $userid;
    $user_api = 'http://u.mofang.com/api/get_detail_by_user';
    $response = mf_curl($user_api, $data);
    $response = json_decode($response, true);
    return $response;
}


/**
* 校驗簽名(成功-0;失敗-1)
* @Param $receive_sign string 簽名
*
**/
function check_sign($receive_sign){
    global $sign;
	$make_sign = make_sign($sign);
	if($receive_sign != $make_sign){
		return 0;
	}else{
		return 1;
	}
}
/**
* 生成簽名字符串
* @Param $appkey string 簽名
*
**/
function make_sign($sign){
	return md5($sign);
}

?>
