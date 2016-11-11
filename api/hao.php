<?php
	class HaoApi{

		private $appkey='100002';
		private $info_type;
        private $userid;
		private $expire;
		private $secretkey;

		public function __construct(){

			$this->info_type = $_GET['type'];
			$this->userid = $_GET['userid'];

			$this->expire = $_GET['expire'];
			$this->secretkey = md5('hao');

			//分頁
			$this->since_id = isset($_GET['since_id']) ? intval($_GET['since_id']) : 0;
			$this->maxid = isset($_GET['maxid']) ? intval($_GET['maxid']) : 0;
			$this->pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) :10;
			$this->pagesize = ($this->pagesize > 0) && ($this->pagesize < 100) ? $this->pagesize : 10;
			$this->page = isset($_GET['page']) ? intval($_GET['page']) :1;

			$check_array['source'] = $_GET['source'];
			$check_array['expire'] = $_GET['expire'];
			$check_array['sign'] = $_GET['sign'];
			$this->check( $check_array );

			$this->get_info();
		}


		/**
		  * 構造符合結構的信息列表
		  * @Param
		  *		$catids 	要查詢的catid
		  *		$type 		查詢的數據類型
		  *		$modelid 	數據模型id
		  *
		 */
		private function hao_list( $userid, $type, $modelid ){

		    $db_privilege_account = pc_base::load_model('privilege_account_model');
		    $db_privilege_account_nums = pc_base::load_model('privilege_account_nums_model');
		    $db_content = pc_base::load_model('content_model');

            if( $this->page ){//分頁
                $offset = ($this->page-1) * $this->pagesize;
                $temp_id = $db_privilege_account_nums->query('SELECT `id` FROM www_privilege_account_nums WHERE `occupy_userid`='.$this->userid.' ORDER BY `id` DESC limit '.$offset.',1');
                $temp_id = $db_privilege_account_nums->fetch_array();
                $this->maxid = $temp_id[0]['id'];
            }

            $sql = '`occupy_userid`='.$this->userid;
			$sql .= $this->maxid ? ' AND `id`<='.$this->maxid : '';
			$sql .= $this->since_id ? ' AND `id`>='.$this->since_id : '';
            
			
            $result = $db_privilege_account_nums->select($sql, 'id,number,occupy_userid,privilegeid,occupy_username', $this->pagesize, '`id` DESC');

            foreach( $result as $key=>$value ){
                $temp_privilege_name = $db_privilege_account->get_one('`id`='.$value['privilegeid'], 'name,howtouse,whattodeliver,modelid,gameid,effect_to');
                $result[$key]['name'] = $temp_privilege_name['name'];
                $result[$key]['howtouse'] = $temp_privilege_name['howtouse'];
                $result[$key]['whattodeliver'] = $temp_privilege_name['whattodeliver'];
                $result[$key]['effect_to'] = $temp_privilege_name['effect_to'];

    			$db_content->set_model( $temp_privilege_name['modelid'] );
    			$game_info = $db_content->get_one('`id`='.$temp_privilege_name['gameid'], 'icon,url');
                $result[$key]['icon'] = $game_info['icon'];
                $result[$key]['url'] = $game_info['url'];
            }

            $return['lists'] = $result;
            $return['count'] = $db_privilege_account_nums->count('`occupy_userid`='.$this->userid);

            return $return;
		}

		private function get_info(){
			switch( $this->info_type ){
                //對應用戶搶號列表
				case 'lists':
					$data_info = $this->hao_list($this->userid);
				break;
				default:
					$err_info['code'] = 99;
					$err_info['msg'] = '數據類別異常!';
					echo json_encode( $err_info  );
					exit();
				break;
			}
	
			$game_information['code'] = 0;
            $game_information['data'] = $data_info;
				
			echo json_encode( $game_information );
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
			if( $receive_sign != $make_sign  ){
				return 1;
			}else{
				return 0;
			}
		}
		private function make_sign( $expire ){
			return urlencode(substr(base64_encode(md5(date("YmdHis",$expire).$this->secretkey)), 5, 10));
		}

	}

	$handle = new HaoApi();
