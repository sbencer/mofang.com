<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
*  通過愛奇藝取得數據，並插入對應的視頻模型  
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-3).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 

class qiyi_video {
	protected static $db_content='';
	
	/*遊戲通用數據獲取*/
	public static function get_data($pagesize){
	 self::$db_content = pc_base::load_model('content_model');
		$data = getcache("from_iqy_keyword","commons"); //加載關鍵字庫
		$arr = array(); //容器
		foreach($data as $key =>$val){
			if(count($val) >1){ //id 對應多個關鍵字
				foreach($val as $ke =>$va){
					$keywords = urlencode($va); //關鍵字...
					$game_api = "http://expand.video.iqiyi.com/api/search/list.json?apiKey=5fcc2a4aa60f4be7a5a6fe30fed244ed&keyWord=".$keywords."&pageSize=".$pagesize."&pageNo=1&categoryId=8";
					$datas = mf_curl_get($game_api);
					$datas = json_decode($datas,true);
					foreach($datas['data'] as $k=>$v){ 
						$arr['albumName']=$v['albumName']; //標題
						$arr['desc']=$v['desc'];//描述
						$arr['albumUrl']=$v['albumUrl'];//地址
						$arr['albumId']=$v['albumId'];//id
						$arr['createdTime']=strtotime($v['createdTime']);//創建時間
						$arr['keyword']=$va;//關鍵字
						$arr['picUrl']=$v['picUrl'];//小縮率圖
						$arr1[$v['albumId']]=$arr;
						unset($arr);
					}
				}
				$arr2[$key]=$arr1; //多個關鍵字的結果 二維數組

				unset($arr1);
			}else{ //單個關鍵字
				
				$keywords = urlencode(trim($val[0])); //關鍵字...
				$game_api = "http://expand.video.iqiyi.com/api/search/list.json?apiKey=5fcc2a4aa60f4be7a5a6fe30fed244ed&keyWord=".$keywords."&pageSize=".$pagesize."&pageNo=1&categoryId=8";
				$datas = mf_curl_get($game_api);
				$datas = json_decode($datas,true);
				foreach($datas['data'] as $k=>$v){ 
						$arr['albumName']=$v['albumName']; //標題
						$arr['desc']=$v['desc'];//描述
						$arr['albumUrl']=$v['albumUrl'];//地址
						$arr['albumId']=$v['albumId'];//id
						$arr['createdTime']=strtotime($v['createdTime']);//創建時間
						$arr['keyword']=$val[0];//關鍵字
						$arr['picUrl']=$v['picUrl'];//小縮率圖
						$arr1[$v['albumId']]=$arr;
						
						unset($arr);
				}
				$arr2[$key]=$arr1; //多個關鍵字的結果 二維數組

				unset($arr1);
				
			}
		}
		$prev_month = strtotime("-1 month"); //一個月之內的時間
		$new_data = self::filter($arr2,$prev_month,$data); //過濾

		if(!empty($new_data)){
			$rs = self::add_video($new_data);//添加ADD
			return $rs;
		}else{
			return false;
		}
	}
	
	/*遊戲ugc數據獲取*/
	public static function get_ugc_data($pagesize){
	 self::$db_content = pc_base::load_model('content_model');
		$data = getcache("from_iqy_keyword","commons"); //加載關鍵字庫
		$arr = array(); //容器
		foreach($data as $key =>$val){
			if(count($val) >1){ //id 對應多個關鍵字
				foreach($val as $ke =>$va){
					$keywords = urlencode($va); //關鍵字...
					$game_api = "http://expand.video.iqiyi.com/api/search/list.json?apiKey=5fcc2a4aa60f4be7a5a6fe30fed244ed&keyWord=".$keywords."&pageSize=".$pagesize."&pageNo=1&categoryId=8&source_type=ugc";
					$datas = mf_curl_get($game_api);
					$datas = json_decode($datas,true);
					foreach($datas['data'] as $k=>$v){ 
						$arr['albumName']=$v['albumName']; //標題
						$arr['desc']=$v['desc'];//描述
						$arr['albumUrl']=$v['albumUrl'];//地址
						$arr['albumId']=$v['albumId'];//id
						$arr['createdTime']=strtotime($v['createdTime']);//創建時間
						$arr['keyword']=$va;//關鍵字
						$arr['picUrl']=$v['picUrl'];//小縮率圖
						$arr['iqiyi_url']=$v['swf'];//UGC視頻，播放器地址
						$arr1[$v['albumId']]=$arr;
						unset($arr);
					}
				}
				$arr2[$key]=$arr1; //多個關鍵字的結果 二維數組
				unset($arr1);
			}else{ //單個關鍵字
				
				$keywords = urlencode(trim($val[0])); //關鍵字...
				$game_api = "http://expand.video.iqiyi.com/api/search/list.json?apiKey=5fcc2a4aa60f4be7a5a6fe30fed244ed&keyWord=".$keywords."&pageSize=".$pagesize."&pageNo=1&categoryId=8&source_type=ugc";
				$datas = mf_curl_get($game_api);
				$datas = json_decode($datas,true);
				foreach($datas['data'] as $k=>$v){ 
						$arr['albumName']=$v['albumName']; //標題
						$arr['desc']=$v['desc'];//描述
						$arr['albumUrl']=$v['albumUrl'];//地址
						$arr['albumId']=$v['albumId'];//id
						$arr['createdTime']=strtotime($v['createdTime']);//創建時間
						$arr['keyword']=$val[0];//關鍵字
						$arr['picUrl']=$v['picUrl'];//小縮率圖
						$arr['iqiyi_url']=$v['swf'];//UGC視頻，播放器地址
						$arr1[$v['albumId']]=$arr;
						
						unset($arr);
				}
				$arr2[$key]=$arr1; //多個關鍵字的結果 二維數組
				unset($arr1);
				
			}
		}

		$prev_month = strtotime("-1 month"); //一個月之內的時間
		$new_data = self::filter($arr2,$prev_month,$data); //過濾
		if(!empty($new_data)){
			$rs = self::add_video($new_data);//添加ADD
			return $rs;
		}else{
			return false;
		}
	}
	
	/*按時間過濾出需要的數組*/
	protected static function filter($arr,$date="",$keyword,$is_filter_title=true){
		if(empty($date)){
			$date=strtotime("-1 week");
		}

		if(is_array($arr)){
			foreach($arr as $k=>$v){
				foreach($v as $ke=>$va){
					if($va['createdTime'] < $date){ //如果當前的視頻時間小於指定時間就unset
						unset($v[$ke]);
					}else{
						if($is_filter_title){
							if(is_array($keyword)){
								if(count($keyword[$k])>1){ //大於1 
									if(strpos($va['albumName'],$va['keyword']) !== false){ //沒有就是匹配失敗									
									$arr1[$ke]=$va;
									}
								}elseif(count($keyword[$k])==1){
									if(strpos($va['albumName'],$keyword[$k][0]) !== false){ //沒有就是匹配失敗
									
									$arr1[$ke]=$va;
									}
								}
							}
						}else{
							$arr1[$ke]=$va;
						}

					}
				}
				$arr2[$k]=$arr1;
				unset($arr1);
			}
			return $arr2;
		}else{
		return false;
		}
	}
	/*執行插入視頻模型的方法,默認是視頻模型的*/
	protected static function add_video($info,$modelid=11){
		if(is_array($info)){
		foreach($info as $key=>$val){ //重組
			foreach($val as $k=>$v){
				$arr['title']=mb_strimwidth($v['albumName'],0,40,"...");//add的標題
				//$arr['title']=$v['albumName'];//add的標題
				$arr['description']=$v['desc'];//add的描述
				$arr['inputtime']=date("Y-m-d H:i:s",$v['createdTime']);//add的發布時間
				$arr['iqiyi_id']=$v['albumId'];//愛奇藝ID
				$arr['keywords']=$v['keyword'];//add的關鍵字
				$arr['thumb']=$v['picUrl'];//add的縮略圖
				$arr['iqiyi_url']=$v['iqiyi_url'];//UGC的視頻播放器地址
				$arr['status']=99;//add的狀態
				$arr['catid']=$key;//add的欄目id
				$arr['vision']=2;//add的縮略圖
				$arr['video_category']=3;//add的類型
				$arr['allow_comment']=1;//add的類型
				$arr1[]=$arr;
			}
		}
		unset($arr);

		 self::$db_content ->set_model(11);
		 $return_infos=array();
		 foreach($arr1 as $k=>$v){
			//echo $v['description']."|";
			$return_id = self::$db_content ->add_content($v);
			if($return_id>0){
				$arr['title']=$v['title'];
				$arr['id']=$return_id;
				$arr['catid']=$v['catid'];
				$arr['code']=1;
				$return_infos[]=$arr;
				unset($arr);
			}else{
				$arr['title']=$v['title'];
				$arr['id']=$return_id;
				$arr['catid']=$v['catid'];
				$arr['code']=0;
				$return_infos[]=$arr;
				unset($arr);
			}
			
		 }
		 $succ=0;
		 $err=0;
		foreach($return_infos as $v){
			if($v['code']){
				$succ++;
			}else{
				$err++;
			}
		}
		 $return_infos['query_total']=(intval(count($return_infos)));//執行多少條
		 $return_infos['from_total']=count($arr1);//開始多少條
		 $return_infos['succ']=$succ;//成功幾條
		 $return_infos['err']=$err;//錯誤幾條
			return $return_infos;
		}else{
		return false;
		}
	}

}


$return_data =  qiyi_video::get_data(20);
$return_ugc_data =  qiyi_video::get_ugc_data(20);
?>
