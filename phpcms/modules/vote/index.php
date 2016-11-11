<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	
	function __construct() {
		pc_base::load_app_func('global');
		$this->vote = pc_base::load_model('vote_subject_model');//投票標題
		$this->vote_option = pc_base::load_model('vote_option_model');//投票選項
		$this->vote_data = pc_base::load_model('vote_data_model'); //投票統計的數據模型
		$this->username = param::get_cookie('_username');
		$this->userid = param::get_cookie('_userid'); 
		$this->groupid = param::get_cookie('_groupid'); 
		$this->ip = ip();
		
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
 	}
	
	public function init() {
		$siteid = SITEID;
 		$page = intval($_GET['page']);
 		if($page<=0){
 			$page = 1;
 		}
     	include template('vote', 'list_new');
	}
	
	 /**
	 *	投票列表頁
	 */
	public function lists() {
 		$siteid = SITEID;
 		$page = intval($_GET['page']);
 		if($page<=0){
 			$page = 1;
 		}
     	include template('vote', 'list_new');
	}
	
	/**
	 * 投票顯示頁
	 */
	public function show(){
		$type = intval($_GET['type']);//調用方式ID
		$subjectid = abs(intval($_GET['subjectid']));
		if(!$subjectid) showmessage(L('vote_novote'),'blank');
 		//取出投票標題
		$subject_arr = $this->vote->get_subject($subjectid);
		
		$siteid = $subject_arr['siteid'];

		//增加判斷，防止模板調用不存在投票時js報錯 wangtiecheng
		if(!is_array($subject_arr)) {
			if(isset($_GET['action']) && $_GET['action'] == 'js') {
				exit;
			} else {
				showmessage(L('vote_novote'),'blank');
			}
		}
		extract($subject_arr);
		//顯示模版
		$template = $template ? $template: 'vote_tp';
 		//獲取投票選項
		$options = $this->vote_option->get_options($subjectid);
		
		//新建一數組用來存新組合數據
        $total = 0;
        $vote_data =array();
		$vote_data['total'] = 0 ;//所有投票選項總數
		$vote_data['votes'] = 0 ;//投票人數
		
		//獲取投票結果信息
        $infos = $this->vote_data->select(array('subjectid'=>$subjectid),'data');	
		//循環每個會員的投票記錄
		foreach($infos as $subjectid_arr) {
				extract($subjectid_arr);
 				$arr = string2array($data);
 				foreach($arr as $key => $values){
 					$vote_data[$key]+=1;
				}
 				$total += array_sum($arr);
				$vote_data['votes']++ ;
		}
 		$vote_data['total'] = $total ;
 		
 		
		//取出投票時間，如果當前時間不在投票時間範圍內，則選項變灰不可選
		if(date("Y-m-d",SYS_TIME)>$todate || date("Y-m-d",SYS_TIME)<$fromdate){
			$check_status = 'disabled';
			$display = 'display:none;';
 		}else {
 			$check_status = '';
 		}
 		
 		
  		//JS調用 
		if($_GET['action']=='js'){
		 	if(!function_exists('ob_gzhandler')) ob_clean();
			ob_start();
 			//$template = 'submit';
 			$template = $subject_arr['template'];
 			//根據TYPE值，判斷調用模版
 			switch ($type){
				case 3://首頁、欄目頁調用
				$true_template = 'vote_tp_3';
				break; 
				case 2://內容頁調用
				$true_template = 'vote_tp_2';	
				break;
				default:
				$true_template = $template;
 			}
  		 	include template('vote',$true_template);
			$data=ob_get_contents();
			ob_clean();
			exit(format_js($data));
		}
		
 		//SEO設置 
		$SEO = seo(SITEID, '', $subject, $description, $subject);
 		//前台投票列表調用默認頁面,以免頁面樣式錯亂.
 		if($_GET['show_type']==1){
 			include template('vote', 'vote_tp');
 		}else {
 			include template('vote', $template);
 		}
 		
	} 
	
	/**
	 * 處理投票
	 */
	public function post(){
		$subjectid = intval($_POST['subjectid']);
		if(!$subjectid)	showmessage('no optionid','blank');
		//當前站點
		$siteid = SITEID;
		//判斷是否已投過票,或者尚未到第二次投票期
		$return = $this->check($subjectid);
 		switch ($return) {
		case 0:
		  showmessage(L('vote_voteyes'),"?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
		  break;
		case -1:
		  showmessage(L('vote_voteyes'),"?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
		  break;
		}
		if(!is_array($_POST['radio'])) showmessage(L('vote_nooption'),'blank');
    	$time = SYS_TIME;
 		
   		$data_arr = array();
  		foreach($_POST['radio'] as $radio){
  			$data_arr[$radio]='1';
  		}
  		$new_data = array2string($data_arr);//轉成字符串存入數據庫中  
  		//添加到數據庫
		$this->vote_data->insert(array('userid'=>$this->userid,'username'=>$this->username,'subjectid'=>$subjectid,'time'=>$time,'ip'=>$this->ip,'data'=>$new_data));
 		//查詢投票獎勵點數，並更新會員點數
 		$vote_arr = $this->vote->get_one(array('subjectid'=>$subjectid));
  		pc_base::load_app_class('receipts','pay',0);
		receipts::point($vote_arr['credit'],$this->userid, $this->username, '','selfincome',L('vote_post_point'));
 		//更新投票人數 
 		$this->vote->update(array('votenumber'=>'+=1'),array('subjectid'=>$subjectid));

 		if($_POST['ajax']==1){
 			//ajax 返回
 			echo 1;
 		}else{
 			//普通返回
			showmessage(L('vote_votesucceed'), "?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
 		}
	}

	//提交測試，是否允許多次提交等測試  
	public function ajax_check($subjectid){
		//查詢本投票配置
 		$siteid = SITEID;
		$subject_arr = $this->vote->get_subject($subjectid);
		if($subject_arr['enabled']==0){
			return 0;
 		}
 		if(date("Y-m-d",SYS_TIME)>$subject_arr['todate']){
 			return 0;
 		}
 		//遊客是否可以投票
		if($subject_arr['allowguest']==0 ){
			if(!$this->username){
				return 0;
 			}elseif($this->groupid == '7'){
 				return 0;
			}
 		}
		
 		//是否有投票記錄 
		$user_info = $this->vote_data->select(array('subjectid'=>$subjectid,'ip'=>$this->ip,'username'=>$this->username),'*','1',' time DESC'); 
		if(!$user_info){
			return 1;
		} else {
			if($subject_arr['interval']==0){
				return 0;
			}
			if($subject_arr['interval']>0){ 
 				$condition = (SYS_TIME - $user_info[0]['time'])/(24*3600)> $subject_arr['interval'] ? 1	: 0;
 				return $condition;
 			}
		}  
	}

	/**
	 * ajax 處理投票
	 */
	public function ajax_post(){
		$subjectid = intval($_POST['subjectid']);
		$radio = intval($_POST['radio']); 
		if(!$subjectid){
			echo 0;exit;
		}
		//當前站點
		$siteid = SITEID;
		//判斷是否已投過票,或者尚未到第二次投票期
		// $return = $this->check($subjectid); 
		// if($return == 0){
		// 	echo 0;exit;
		// }
    	$time = SYS_TIME;
   		$data_arr = array(); 
  		$data_arr[$radio]='1';
  		$new_data = array2string($data_arr);//轉成字符串存入數據庫中  
  		//添加到數據庫
		$this->vote_data->insert(array('userid'=>$this->userid,'username'=>$this->username,'subjectid'=>$subjectid,'time'=>$time,'ip'=>$this->ip,'data'=>$new_data));
 		//查詢投票獎勵點數，並更新會員點數
 		$vote_arr = $this->vote->get_one(array('subjectid'=>$subjectid));
  		pc_base::load_app_class('receipts','pay',0);
		receipts::point($vote_arr['credit'],$this->userid, $this->username, '','selfincome',L('vote_post_point'));
 		//更新投票人數 
 		$this->vote->update(array('votenumber'=>'+=1'),array('subjectid'=>$subjectid));

 		if($_POST['ajax']==1){
 			echo 1;
 		}else{
 			echo 0;
 		}
	}
	
	/**
	 * 
	 * 投票結果顯示 
	 */
	public function result(){
		$siteid = SITEID;
		$subjectid = abs(intval($_GET['subjectid']));
		if(!$subjectid)	showmessage(L('vote_novote'),'blank');
		//取出投票標題
		$subject_arr = $this->vote->get_subject($subjectid);
		if(!is_array($subject_arr)) showmessage(L('vote_novote'),'blank');
		extract($subject_arr);
		//獲取投票選項
		$options = $this->vote_option->get_options($subjectid);
		
		//新建一數組用來存新組合數據
        $total = 0;
        $vote_data =array();
		$vote_data['total'] = 0 ;//所有投票選項總數
		$vote_data['votes'] = 0 ;//投票人數
		
		//獲取投票結果信息
        $infos = $this->vote_data->select(array('subjectid'=>$subjectid),'data');	
		//循環每個會員的投票記錄
		foreach($infos as $subjectid_arr) {
				extract($subjectid_arr);
 				$arr = string2array($data);
 				foreach($arr as $key => $values){
 					$vote_data[$key]+=1;
				}
 				$total += array_sum($arr);
				$vote_data['votes']++ ;
		}
 		$vote_data['total'] = $total ;
 		//SEO設置 
		$SEO = seo(SITEID, '', $subject, $description, $subject);
   		include template('vote','vote_result');
	}

	


	//魔方網新的投票調查結果
	public function vote_result_new(){

		$siteid = SITEID;
		$subjectid = abs(intval($_GET['subjectid']));
		if(!$subjectid)	showmessage(L('vote_novote'),'blank');
		//取出投票標題
		$subject_arr = $this->vote->get_subject($subjectid);
		if(!is_array($subject_arr)) showmessage(L('vote_novote'),'blank');
		extract($subject_arr);
		//獲取投票選項
		$options = $this->vote_option->get_options($subjectid);
		
		//新建一數組用來存新組合數據
        $total = 0;
        $vote_data =array();
		$vote_data['total'] = 0 ;//所有投票選項總數
		$vote_data['votes'] = 0 ;//投票人數
		
		//獲取投票結果信息
        $infos = $this->vote_data->select(array('subjectid'=>$subjectid),'data');	
		//循環每個會員的投票記錄
		foreach($infos as $subjectid_arr) {
				extract($subjectid_arr);
 				$arr = string2array($data);
 				foreach($arr as $key => $values){
 					$vote_data[$key]+=1;
				}
 				$total += array_sum($arr);
				$vote_data['votes']++ ;
		}
 		$vote_data['total'] = $total ;

 		//循環投票選項，算出來正反方比例
 		$zf_votes = 0;
		$ff_votes = 0;
 		foreach ($options as $key => $value) {
 			# code...
 			if($value['type']==1){
 				$zf_votes +=$vote_data[$value['optionid']];
 			}else{
 				$ff_votes +=$vote_data[$value['optionid']];
 			}

 		}

 		//計算百分比
 		$zf_per=ceil(($zf_votes/$vote_data['total'])*100);
 		$ff_per= (100-$zf_per);

 		//SEO設置 
		$SEO = seo(SITEID, '', $subject, $description, $subject);
		//使用smarty 解析模版文件 
		require(PC_PATH."init/smarty.php"); 
		$smarty = use_v4();
		$smarty->assign("subject_id",$subjectid);
		$smarty->assign("vote_data",$vote_data);
		$smarty->assign("zf_per",$zf_per);
		$smarty->assign("ff_per",$ff_per);
	    $smarty->display('ac_huati/index.tpl'); 

	}
	
	/**
	 * 
	 * 投票前檢測
	 * @param $subjectid 投票ID 
	 * @return 返回值 (1:可投票  0: 多投,時間段內不可投票  -1:單投,已投票,不可重復投票)
	 */
	public function check($subjectid){
		//查詢本投票配置
 		$siteid = SITEID;
		$subject_arr = $this->vote->get_subject($subjectid);
		if($subject_arr['enabled']==0){
			showmessage(L('vote_votelocked'),"?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
 		}
 		if(date("Y-m-d",SYS_TIME)>$subject_arr['todate']){
			showmessage(L('vote_votepassed'),"?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
 		}
 		//遊客是否可以投票
		if($subject_arr['allowguest']==0 ){
			if(!$this->username){
				showmessage(L('vote_votenoguest'),"?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
 			}elseif($this->groupid == '7'){
				showmessage('對不起，不允許郵件待驗證用戶投票！',"?m=vote&c=index&a=result&subjectid=$subjectid&siteid=$siteid");
			}
 		}
		
 		//是否有投票記錄 
		$user_info = $this->vote_data->select(array('subjectid'=>$subjectid,'ip'=>$this->ip,'username'=>$this->username),'*','1',' time DESC'); 
		if(!$user_info){
			return 1;
		} else {
			if($subject_arr['interval']==0){
				return -1;
			}
			if($subject_arr['interval']>0){ 
 				$condition = (SYS_TIME - $user_info[0]['time'])/(24*3600)> $subject_arr['interval'] ? 1	: 0;
 				return $condition;
 			}
		}  
	}



	/**
	 * 投票顯示頁  - 眾籌投票程序
	 */
	public function show_zc(){
		$type = intval($_GET['type']);//調用方式ID
		$subjectid = abs(intval($_GET['subjectid']));
		if(!$subjectid) showmessage(L('vote_novote'),'blank');
 		//取出投票標題
		$subject_arr = $this->vote->get_subject($subjectid);
		
		$siteid = $subject_arr['siteid'];

		//增加判斷，防止模板調用不存在投票時js報錯 wangtiecheng
		if(!is_array($subject_arr)) {
			if(isset($_GET['action']) && $_GET['action'] == 'js') {
				exit;
			} else {
				showmessage(L('vote_novote'),'blank');
			}
		}
		extract($subject_arr);
		//顯示模版
		$template = $template ? $template: 'vote_tp';
 		//獲取投票選項
		$options = $this->vote_option->get_options($subjectid);
		
		//新建一數組用來存新組合數據
        $total = 0;
        $vote_data =array();
		$vote_data['total'] = 0 ;//所有投票選項總數
		$vote_data['votes'] = 0 ;//投票人數
		
		//獲取投票結果信息
        $infos = $this->vote_data->select(array('subjectid'=>$subjectid),'data');	
		//循環每個會員的投票記錄
		foreach($infos as $subjectid_arr) {
				extract($subjectid_arr);
 				$arr = string2array($data);
 				foreach($arr as $key => $values){
 					$vote_data[$key]+=1;
				}
 				$total += array_sum($arr);
				$vote_data['votes']++ ;
		}
 		$vote_data['total'] = $total ;
 		
 		
		//取出投票時間，如果當前時間不在投票時間範圍內，則選項變灰不可選
		if(date("Y-m-d",SYS_TIME)>$todate || date("Y-m-d",SYS_TIME)<$fromdate){
			$check_status = 'disabled';
			$display = 'display:none;';
 		}else {
 			$check_status = '';
 		}
 		
 		
  		//JS調用 
		if($_GET['action']=='js'){
		 	if(!function_exists('ob_gzhandler')) ob_clean();
			ob_start();
 			//$template = 'submit';
 			$template = $subject_arr['template'];
 			//根據TYPE值，判斷調用模版
 			switch ($type){
				case 3://首頁、欄目頁調用
				$true_template = 'vote_tp_3';
				break; 
				case 2://內容頁調用
				$true_template = 'vote_tp_2';	
				break;
				default:
				$true_template = $template;
 			}
  		 	include template('vote',$true_template);
			$data=ob_get_contents();
			ob_clean();
			exit(format_js($data));
		}
		
 		//SEO設置 
		$SEO = seo(SITEID, '', $subject, $description, $subject);
 		//前台投票列表調用默認頁面,以免頁面樣式錯亂.
 		if($_GET['show_type']==1){
 			include template('vote', 'vote_tp');
 		}else {
 			include template('vote', $template);
 		}
 		
	} 
	
}
?>