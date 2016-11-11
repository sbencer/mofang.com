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

			//分頁
			$this->since_id = isset($_GET['since_id']) ? intval($_GET['since_id']) : 0;
			$this->maxid = isset($_GET['maxid']) ? intval($_GET['maxid']) : 0;
			$this->pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) :10;
			$this->pagesize = ($this->pagesize > 0) && ($this->pagesize < 100) ? $this->pagesize : 10;

			$check_array['source'] = $_GET['source'];
			$check_array['expire'] = $_GET['expire'];
			$check_array['sign'] = $_GET['sign'];
			$this->check( $check_array );

			$this->get_info();
		}

		/* 獲取全部遊戲包列表(現暫僅為android)  */
		private function get_package_list(){

			$db_content = pc_base::load_model('content_model');
			$db_content->set_model(21);
			$package_list_temp = $db_content->select("`package_name` != ''",'DISTINCT `package_name`');
			$package_list = array();
			foreach( $package_list_temp as $value ){
				$package_list[] = $value['package_name'];
			}
			sort($package_list);
			return $package_list;
		}

		/**
		  * 信息列表(這一層看起來很多余)
		  * @Param	$modelid	信息所對應模型id
		  *		$type		信息類型
		  *
		 */
		private function info_list( $modelid, $type ){
			$game_info = array();
			switch( $type ){
				case 'news':
					$news_catid = '101,188'; 
					$game_info = $this->info_list_base( $news_catid, $type, $modelid );
					break;
				case 'guide':
					$guide_catid = '103,190';
					$game_info = $this->info_list_base( $guide_catid, $type, $modelid );
					break;
				case 'review':
					$review_catid = '102,189';
					$game_info = $this->info_list_base( $review_catid, $type, $modelid );
					break;

				//暫未啟用,預留接口
				case 'kaifu':
					break;

				//暫未啟用,預留接口
				case 'gift':
					break;
				case 'video':
					$video_catid = '472,473,477';
					$game_info = $this->info_list_video( $video_catid, $type, $modelid );
					break;
			}
			return $game_info;
		}


		/**
		  * 構造符合結構的信息列表(視頻)
		  * @Param
		  *		$catids 	要查詢的catid
		  *		$type 		查詢的數據類型
		  *		$modelid 	數據模型id
		  *
		 */
		private function info_list_video( $catids, $type, $modelid ){

			$video_content = pc_base::load_model('video_model');


			//根據包名查詢相應的內容列表
			$db_curr_game = pc_base::load_model('content_model');
			$db_curr_game->set_model( 21 );
			$curr_gameid = $db_curr_game->get_one("`package_name`='".$this->package."'", 'id');
			
			$sql = '`catid` IN ('.$catids.')';
			$sql .= $this->maxid ? ' AND `id`<='.$this->maxid : '';
			$sql .= $this->since_id ? ' AND `id`>='.$this->since_id : '';

			$sql .= " AND `gameid`='|21-".$curr_gameid['id']."|'";

			$info_list = $video_content->select($sql, 'id,title,updatetime,thumb,url,gameid,youkuid,videotime,description', $this->pagesize, '`id` DESC');

			foreach( $info_list as $key=>$value ){

				//更新時間
				$info_list[$key]['update_time'] = $value['updatetime'];

				//youkuid
				$info_list[$key]['youku_id'] = $value['youkuid'];
				//時長
				$info_list[$key]['video_length'] = $value['videotime'];

				//描述
				$info_list[$key]['description'] = $value['description'];
				//內容
				$info_list[$key]['content'] = $value['description'];

				//文章來源
				$temp_column['copyfrom'] = explode( '|', $value['copyfrom'] );
				$temp_column['copyfrom'] = $temp_column['copyfrom'][0] ? $temp_column['copyfrom'][0] : '魔方網';
				$info_list[$key]['source'] = $temp_column['copyfrom'];

				//關聯遊戲
				if( $value['gameid'] ){

					$db_content_game = pc_base::load_model('content_model');
					$temp_relate_game = trim( $value['gameid'], '|' );
					$temp_relate_game = explode( '-', $temp_relate_game );
					switch( $temp_relate_game[0] ){
						case '20':
							$db_content_game->set_model(20);
							$select_fields = 'title';
							break;
						case '21':
							$db_content_game->set_model(21);
							$select_fields = 'title,package_name';
							break;
					}
					$temp_game_name = $db_content_game->get_one('`id`='.$temp_relate_game[1], $select_fields);
					$info_list[$key]['game_name'] = $temp_game_name['title'];
					$info_list[$key]['package_name'] = $temp_game_name['package_name'] ? $temp_game_name['package_name'] : '';
				}else{
					$info_list[$key]['game_name'] = '';
					$info_list[$key]['package_name'] = '';
				}
				
				$info_list[$key]['type'] = $type;

				unset($info_list[$key]['youkuid']);
				unset($info_list[$key]['videotime']);
				unset($info_list[$key]['updatetime']);
				unset($info_list[$key]['gameid']);

			}

			return $info_list;
		}

		/**
		  * 構造符合結構的信息列表
		  * @Param
		  *		$catids 	要查詢的catid
		  *		$type 		查詢的數據類型
		  *		$modelid 	數據模型id
		  *
		 */
		private function info_list_base( $catids, $type, $modelid ){

			$db_content = pc_base::load_model('content_model');
			//$db_content->set_model( $modelid );

			$db_curr_game = $db_content;
			$db_curr_game->set_model(21);
			$curr_gameid = $db_curr_game->get_one("`package_name`='".$this->package."'", 'id');

			$sql = '`catid` IN ('.$catids.')';
			$sql .= $this->maxid ? ' AND `id`<='.$this->maxid : '';
			$sql .= $this->since_id ? ' AND `id`>='.$this->since_id : '';
			
			$sql .= " AND `gameid`='|21-".$curr_gameid['id']."|'";

			$db_content->set_model( $modelid );
			$info_list = $db_content->select($sql, 'id,title,updatetime,thumb,url,gameid', $this->pagesize, '`id` DESC');

			foreach( $info_list as $key=>$value ){

				//更新時間
				$info_list[$key]['update_time'] = $value['updatetime'];

				$news_data_content = pc_base::load_model('content_model');
                $news_data_content->table_name = 'www_news_data';
				$temp_column = $news_data_content->get_one( '`id`='.$value['id'], 'content,copyfrom' );
				//內容
				$info_list[$key]['content'] = $temp_column['content'];
				//文章來源
				$temp_column['copyfrom'] = explode( '|', $value['copyfrom'] );
				$temp_column['copyfrom'] = $temp_column['copyfrom'][0] ? $temp_column['copyfrom'][0] : '魔方網';
				$info_list[$key]['source'] = $temp_column['copyfrom'];

				//關聯遊戲
				if( $value['gameid'] ){
					$db_content_game = $db_content;
					$temp_relate_game = trim( $value['gameid'], '|' );
					$temp_relate_game = explode( '-', $temp_relate_game );
					switch( $temp_relate_game[0] ){
						case '20':
							$db_content_game->set_model(20);
							$select_fields = 'title';
							break;
						case '21':
							$db_content_game->set_model(21);
							$select_fields = 'title,package_name';
							break;
					}
					$temp_game_name = $db_content_game->get_one('`id`='.$temp_relate_game[1], $select_fields);
					$info_list[$key]['game_name'] = $temp_game_name['title'];
					$info_list[$key]['package_name'] = $temp_game_name['package_name'] ? $temp_game_name['package_name'] : '';

				}else{
					$info_list[$key]['game_name'] = '';
					$info_list[$key]['package_name'] = '';
				}
				
				$info_list[$key]['type'] = $type;

				unset($info_list[$key]['updatetime']);
				unset($info_list[$key]['gameid']);

			}

			return $info_list;
		}

		private function get_info(){
			//$this->package;
			switch( $this->info_type ){
				case 'news':
					$game_info = $this->info_list(1, 'news');
				break;
				case 'guide':
					$game_info = $this->info_list(1, 'guide');
				break;
				case 'review':
					$game_info = $this->info_list(1, 'review');
				break;
				case 'kaifu':
					$game_info[0]['title'] = '王者之劍開服';
					$game_info[0]['game_name'] = '王者之劍';
					$game_info[0]['update_time'] = 1375142400;
					$game_info[0]['type'] = 'kaifu';
					$game_info[0]['thumb']= 'http://pics.mofang.com/2013/0723/20130723044658901.jpg!120x120';
					$game_info[0]['content']= '王者之劍是一款手遊。';
					$game_info[0]['url']= 'http://www.mofang.com';
				break;
				case 'gift':
					$game_info[0]['title'] = '玩《王者之劍》送高溫大禮包';
					$game_info[0]['game_name'] = '王者之劍';
					$game_info[0]['update_time'] = 1375056000;
					$game_info[0]['type'] = 'gift';
					$game_info[0]['thumb']= 'http://pics.mofang.com/2013/0726/20130726124204881.jpg!120x120';
					$game_info[0]['content']= '玩《王者之劍》送高溫大禮包';
					$game_info[0]['gift_intro']= '累計消耗數額(元寶)500—1999 獎勵青銅大禮包*1';
					$game_info[0]['gift_ends']= 1376956740;
					$game_info[0]['url']= 'http://www.mofang.com';
				break;
				case 'video':
					$game_info = $this->info_list(11, 'video');
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
	
			$game_information['code'] = 0;
			if( $this->info_type != 'packages'  ){
				//$game_information['data'][] = $game_info;
				$game_information['data'] = $game_info;
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
		private function check( $check ){
			$check_code = 0;
			foreach( $check as $key=>$value ){
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
		private function make_sign( $expire ){
			return urlencode(substr(base64_encode(md5($this->package.date("YmdHis",$expire).$this->secretkey)), 5, 10));
		}



	}

	$handle = new SougouApi();
