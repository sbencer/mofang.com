<?php
	class SougouApi{

		private $appkey='100001';
		private $info_type;
		private $package;
		private $expire;
		private $secretkey;

		public function __construct(){

			$this->package = $_GET['package'];
			$this->info_type = $_GET['type'];
			$this->expire = $_GET['expire'];
			$this->secretkey = md5('sogou');

			$check_array['source'] = $_GET['source'];
			$check_array['expire'] = $_GET['expire'];
			$check_array['sign'] = $_GET['sign'];
			//$this->check( $check_array );

			$this->get_info();
		}

		/* 獲取全部遊戲包列表(現暫僅為android)  */
		private function get_package_list(){
			//$pack_type = isset( $_GET['pack_type'] ) ? $_GET['pack_type'] : '';
			/*
			switch( $pack_type  ){
				case 'ios':
					$tb_name = 'www_iosgames';
					break;
				case 'android':
					$tb_name = 'www_androidgames';
					break;
				default:
					$tb_name = '';
			}*/

			$conn = mysql_connect('localhost', 'mofang_www', 'RnJ6hp8FQdSW');
			if( !$conn  ){//連接數據庫失敗
				$err_info['code'] = 101;
				$err_info['msg'] = '系統異常!';
				echo json_encode( $err_info  );
				exit();
			}
			if( !mysql_select_db('mofang_www', $conn)){//選擇數據庫失敗
				$err_info['code'] = 102;
				$err_info['msg'] = '系統異常!';
				echo json_encode( $err_info  );
				exit();
			};
			mysql_set_charset('utf8', $conn);

			//if( !$tb_name  ){//ios and android遊戲包列表
				//$result_ios = mysql_query("SELECT `package_name` FROM `www_iosgames` WHERE `package_name` != ''");
				$result_android = mysql_query("SELECT DISTINCT `package_name` FROM `www_androidgames` WHERE `package_name` != ''");
				/*while( $pack_one=mysql_fetch_assoc($result_ios) ){//ios
					$package_list[] = $pack_one['package_name'];
				}*/
				while( $pack_one=mysql_fetch_assoc($result_android) ){//安卓
					$package_list[] = $pack_one['package_name'];
				}
			//}else{//ios or android遊戲包列表
			//	$result = mysql_query("SELECT DISTINCT `package_name` FROM ".$tb_name." WHERE `package_name` != ''");
			//	while( $pack_one=mysql_fetch_assoc($result) ){
			//		$package_list[] = $pack_one['package_name'];
			//	}
			//}
			mysql_close( $conn );

			sort($package_list);
			return $package_list;
		}

		private function get_info(){
			//$this->package;
			switch( $this->info_type ){
				case 'news':
					$game_info['title'] = '藍港在線《王者之劍》持續火爆 年內推新遊';
					$game_info['game_name']= '王者之劍';
					$game_info['update_time']= 1374796800;
					$game_info['type'] = 'news';
					$game_info['thumb']= 'http://pics.mofang.com/2013/0726/20130726124204881.jpg!120x120';
					$game_info['content']= '此次Chinajoy藍港在線攜知名手遊《王者之劍》亮相W4館。';
					$game_info['url']= 'http://i.mofang.com/wyxinyou/182-1354-1.html';
				break;
				case 'guide':
					$game_info['title'] = '《王者之劍》驚天地泣鬼神的刺客屬性攻略';
					$game_info['game_name']= '王者之劍';
					$game_info['update_time']= 1374710400;
					$game_info['type'] = 'guide';
					$game_info['thumb']= 'http://test.mofang.com/www/uploadfile/2013/0724/20130724055516721.jpg';
					$game_info['content']= '王者之劍裡劍客——具有多樣攻擊方式和瞬間爆發傷害';
					$game_info['url']= 'http://i.mofang.com/wygonglue/184-983-1.html';
				break;
				case 'review':
					$game_info['title'] = '王者之劍實驗室版評測';
					$game_info['game_name'] = '王者之劍';
					$game_info['update_time'] = 1375142400;
					$game_info['type'] = 'review';
					$game_info['thumb']= 'http://test.mofang.com/www/uploadfile/2013/0730/20130730055441891.jpg';
					$game_info['content']= '你可能玩過《王者之劍》這個遊戲。';
					$game_info['url']= 'http://www.mofang.com';
				break;
				case 'kaifu':
					$game_info['title'] = '王者之劍開服';
					$game_info['game_name'] = '王者之劍';
					$game_info['update_time'] = 1375142400;
					$game_info['type'] = 'kaifu';
					$game_info['thumb']= 'http://pics.mofang.com/2013/0723/20130723044658901.jpg!120x120';
					$game_info['content']= '王者之劍是一款手遊。';
					$game_info['url']= 'http://www.mofang.com';
				break;
				case 'gift':
					$game_info['title'] = '玩《王者之劍》送高溫大禮包';
					$game_info['game_name'] = '王者之劍';
					$game_info['update_time'] = 1375056000;
					$game_info['type'] = 'gift';
					$game_info['thumb']= 'http://pics.mofang.com/2013/0726/20130726124204881.jpg!120x120';
					$game_info['content']= '玩《王者之劍》送高溫大禮包';
					$game_info['gift_intro']= '累計消耗數額(元寶)500—1999 獎勵青銅大禮包*1';
					$game_info['gift_ends']= 1376956740;
					$game_info['url']= 'http://www.mofang.com';
				break;
				case 'video':
					$game_info['title'] = '新遊介紹：《王者之劍》';
					$game_info['game_name'] = '王者之劍';
					$game_info['update_time'] = 1375056000;
					$game_info['type'] = 'video';
					$game_info['thumb']= 'http://pics.mofang.com/2013/0721/20130721065525695.jpg!168x110';
					$game_info['content']= '《王者之劍》遊戲畫面精美';
					$game_info['video_length']= 7200;
					$game_info['youku_id']= 'XNTg1Mjk0NDIw';
					$game_info['url']= 'http://i.mofang.com/shipin/91-76-1.html';
				break;
				case 'packages':
					$game_info = $this->get_package_list();
				break;
				default:
					$err_info['code'] = 99;
					$err_info['msg'] = '數據類別異常!';
					echo json_encode( $err_info  );
					exit();
				break;
			}
			if( $this->info_type != 'packages'  ){
				$game_info['package_name']= $this->package;
				$game_info['source']= '魔方網';
			}
	
			$game_information['code'] = 0;
			if( $this->info_type != 'packages'  ){
				$game_information['data'][] = $game_info;
			}else{//遊戲包名列表
				$game_information['data'] = $game_info;
			}
				
			echo json_encode( $game_information  );
		} 

		/**
		* 校驗字段
		* @Param $check array 待校驗的數組信息
		*
		**/
		private function check( $check  ){
			$check_code = 0;
			foreach( $check as $key=>$value  ){
				switch( $key  ){
					case 'source':
						$check_code = !$this->check_appkey($value)  ? 0 : 1;
					break;
					case 'expire':
						$check_code = !$this->check_expire($value) ? 0 : 2;
					break;
					case 'sign':
						$check_code = !$this->check_sign($value) ? 0 : 3;
					break;
				}

				if( $check_code  ){
					break;
				}

			}
			
			switch( $check_code  ){
				case 1:
					$err_msg = 'appkey錯誤!';
				break;
				case 2:
					$err_msg = '已過期!';
				break;
				case 3:
					$err_msg = '簽名錯誤!';
				break;
			}
			
			if( $check_code  ){
				$err_info['code'] = $check_code;
				$err_info['msg'] = $err_msg;
				echo json_encode( $err_info  );
				exit();
			}

		}

		/**
		* 校驗appkey(成功-0;失敗-1)
		*
		*
		**/
		private function check_appkey( $appkey  ){
			if( $this->appkey != $appkey  ){
				return 1;
			}else{
				return 0;
			}
		}

		/**
		* 校驗expire(成功-0;失敗-1)
		* @Param $expire int 時間戳
		*
		**/
		private function check_expire( $expire  ){
			if( $expire<time()  ){
				return 1;
			}else{
				return 0;
			}
		}

		/**
		* 校驗簽名(成功-0;失敗-1)
		* @Param $receive_sign string 簽名
		*
		**/
		private function check_sign( $receive_sign ){
			$make_sign = $this->make_sign( $this->expire  );
			//echo $this->make_sign( $this->expire  );
			if( $receive_sign != $make_sign  ){
				return 1;
			}else{
				return 0;
			}
		}
		private function make_sign( $expire  ){
			return urlencode(substr(base64_encode(md5($this->package.date("YmdHis",$expire).$this->secretkey)), 5, 10));
		}



	}

	$handle = new SougouApi();
