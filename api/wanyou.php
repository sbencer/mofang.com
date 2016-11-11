<?php
	class WanyouApi{

		private $info_type;
		private $package;

		public function __construct(){

			$this->package = $_GET['package'];
			$this->info_type = $_GET['type'];
			$this->appid = $_GET['appid'];

			$this->pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) :10;
			$this->pagesize = ($this->pagesize > 0) && ($this->pagesize < 100) ? $this->pagesize : 10;

            //攻略/資訊對應專區id
			$this->appid = isset($_GET['appid']) ? intval($_GET['appid']) : 0;
            //攻略對應catid
			$this->catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;

            //用戶id
			$this->uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;

            $this->curr_page = intval($_GET['page']) ? intval($_GET['page']) : 1;
            $this->pagenum = intval($_GET['nums']) ? intval($_GET['nums']) : 15;

            //搜索
            $this->typeid  = intval($_GET['typeid']) ? intval($_GET['typeid']): 0;
            $this->keyword = $_POST['search'] ? $_POST['search'] : '';

			$this->get_info();
		}

		/**
		  * 
          * @Param
          *
		 */
		public function info_list_part($partid){

            //分頁
		    $currpage = $_GET['currpage'] ? $_GET['currpage'] : 1;
		    $pagenum = $_GET['pagenum'] ? $_GET['pagenum'] : 100;
		    $ajax = ($_GET['ajax']&&$_GET['ajax']==1) ? 1 : 0;

			$db_content = pc_base::load_model('content_model');
			$db_content_part = $db_content;

		    $db_partition = pc_base::load_model('partition_model');
		    $db_partition_game = pc_base::load_model('partition_games_model');


            //查是否是專區/子欄目
            $partition_info = $db_partition->get_one('`catid`='.$partid, 'parentid,setting');
            if($partition_info['parentid']==0){//專區

                // $tab_channel = $db_partition->select("`arrparentid` like '%,".$partid.",%' AND `is_tab2`=1", 'catid,catname,setting');
                $tab_channel = $db_partition->select("(`arrparentid` like '%,".$partid."' OR `arrparentid` like '%,".$partid.",%') AND `is_tab2`=1", 'catid,catname,setting');
                $result['tab'] = array();
                $temp_array = array();
                $catids = '';
                foreach( $tab_channel as $k_tc=>$v_tc ){
                    $temp_setting = string2array($v_tc['setting']);
                    $temp_array['image'] = $temp_setting['new_tab_image'];
                    $temp_array['url'] = 'http://www.mofang.com/zhushou/gonglue/'.$this->appid.'.html?catid='.$v_tc['catid'];
                    $temp_array['title'] = $v_tc['catname'];
                    $result['tab'][] = $temp_array;
                    $catids .= ','.$v_tc['catid'];
                }
                $catids = trim($catids, ',');
                if(empty($catids)){
                    $game_id = get_wanyou_games($this->appid);
                    $modelid = 1;
					$guide_catid = '103,190';
					$info_list = $this->info_list_base($guide_catid, $this->info_type, $modelid, "`gameid`='|21-".$game_id."|'");
                    if(empty($info_list)){//無攻略內容
                        echo "暫無攻略!";
                    }else{
		                include template('api', 'list', 'mofang_v2');
                    }
                    exit();
                }

                //home內容
                $result['type'] = 0;
                //查Tab項


                //1.查詢專區下攻略欄目內容(一樣全查,因為需要排序)
                //$part_set = string2array($partition_info['setting']);
                //$catids = $part_set['app_gonglue_cha'];
            }else{//子欄目
                //列表內容
                $result['type'] = 1;
                $catids = $partid;
            }
            //專區攻略->所有子欄目
            //$catids可能為空
            $arrchildids = $db_partition->select('`catid` IN ('.$catids.')', 'arrchildid');
            $str_arrchildid = '';
            foreach( $arrchildids as $k_as=>$v_as ){
                $str_arrchildid .= ','.$v_as['arrchildid'];
            }
            $str_arrchildid = trim($str_arrchildid, ',');
            $guide_list = $db_partition_game->listinfo('`part_id` IN ('.$str_arrchildid.')', '`listorder` DESC');
            $guide_total = $db_partition_game->count('`part_id` IN ('.$str_arrchildid.')');
            //總數
            $result['total'] = $guide_total;


            $info_list = array();
            foreach( $guide_list as $k_gl=>$v_gl){//攻略列表
                $db_content_part->set_model($v_gl['modelid']);
                //最好限字段
                $info_list[]=$db_content_part->get_one('`id`='.$v_gl['gameid']);
            }

            //這個列表需增加按更新時間排序
            if($this->appid!=526804){
                usort($info_list, 'partition_list_cmp');
            }
            $info_list = array_slice($info_list, $currpage, $pagenum);
            $result['list'] = $info_list;

            if( $ajax ){
		        echo json_encode($result);
            }else{
			    return $result;
            }
        }

		/**
		  * 構造符合結構的信息列表
		  * @Param
		  *		$catids 	要查詢的catid
		  *		$type 		查詢的數據類型
		  *		$modelid 	數據模型id
		  *
		 */
		private function info_list_base($catids, $type, $modelid, $sql_add=''){

            //分頁
		    $currpage = $_GET['currpage'] ? $_GET['currpage'] : 1;
		    $pagenum = $_GET['pagenum'] ? $_GET['pagenum'] : 100;
		    $ajax = ($_GET['ajax']&&$_GET['ajax']==1) ? 1 : 0;

			$db_content = pc_base::load_model('content_model');
			//$db_content->set_model( $modelid );

			$sql = '`catid` IN ('.$catids.')';
			$sql .= ' AND `status`=99';
            $sql .= $sql_add ? ' AND '.$sql_add : '';

			$db_content->set_model( $modelid );
			$info_list = $db_content->listinfo($sql, '`updatetime` DESC,`id` DESC', $currpage, $pagenum );

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

            if( $ajax ){//ajax請求數據
		        echo json_encode($info_list);
            }else{
			    return $info_list;
            }
		}
        /*
         * 禮包列表
         *
         **/
        private function gift_list( $game_id='', $keyword='' ){

		    $db_privilege_account_model = pc_base::load_model('privilege_account_model');
            $db_privilege_rule = pc_base::load_model('privilege_rule_model');
		    $db_privilege_account_nums_model = pc_base::load_model('privilege_account_nums_model');
			$db_content = pc_base::load_model('content_model');
            
            if(!empty($keyword)){
                $sql = "`name` like '%".$keyword."%' AND `modelid`=21";
            }else{
                //有效期內的
                $sql = "1 AND `modelid`=21";
                $sql .= $game_id ? ' AND `gameid`='.$game_id : '';
            }

            $limit = '';
            $privilege_list = $db_privilege_account_model->select($sql,'*',$limit,'`intime` DESC');

            foreach( $privilege_list as $k_dc=>$v_dc ){

                //魔方app禮包
                $temp_rule = $db_privilege_rule->get_one('`privilege_id`='.$v_dc['id'], 'rule_json');
                if($temp_rule['rule_json'] && ($temp_rule_array=json_decode($temp_rule['rule_json'], true)) ){
                    $temp_rule_array = json_decode($temp_rule['rule_json'], true);
                    if(!$temp_rule_array['mofang_app'] && !$temp_rule_array['zhushou_redirect']){
                        unset($privilege_list[$k_dc]);
                        continue;
                    }
                }

                $db_content->set_model($v_dc['modelid']);
                $temp_game_info = $db_content->get_one('`id`='.$v_dc['gameid'], 'title,url,icon');
                $privilege_list[$k_dc]['game_title'] = $temp_game_info['title'];
                $privilege_list[$k_dc]['game_url'] = $temp_game_info['url'];
                $privilege_list[$k_dc]['game_icon'] = $temp_game_info['icon'];

                //號碼
                $privilege_list[$k_dc]['total_hao'] = $db_privilege_account_nums_model->count('`privilegeid`='.$v_dc['id']);
                $privilege_list[$k_dc]['last_hao'] = $db_privilege_account_nums_model->count('`privilegeid`='.$v_dc['id'].' AND `occupy_userid`=0');
            }


            return $privilege_list;
        }

		/**
		  * 信息列表
		  * @Param	
          *         None
		  *
		 */
		private function get_info(){
			//$this->package;
			$info_list = array();
			switch( $this->info_type ){
                //資訊
				case 'news':
                    $modelid = 1;
					$news_catid = '101,188'; 
					$info_list = $this->info_list_base( $news_catid, $this->info_type, $modelid );
                    $news=1;
		            include template('api', 'list', 'mofang_v2');
                    exit();
				break;
                //攻略
				case 'guide':
                    $game_id = get_wanyou_games($this->appid);

                    //關聯專區
                    $part_id = 0;
                    if( $game_id ){//查詢關聯專區
		                $db_partition_relationgames = pc_base::load_model('partition_relationgames_model');
                        $part_id = $db_partition_relationgames->get_one('`modelid`=21 AND `gameid`='.$game_id, 'part_id');
                        $part_id = $part_id['part_id'];
                    }

                    if($this->appid==611906 && !$this->catid){//天天愛西遊

		                $db_partition_game = pc_base::load_model('partition_games_model');
                        //$db_partition_game->select(``);

                        $db_content = pc_base::load_model('content_model');
                        $channel_id = array(5359,5360,5361,5362,5363,5364);
                        $pos_list = array();
                        foreach($channel_id as $channel_val){
                            $long_res = $db_content->query("SELECT b.id,b.modelid FROM www_partition_games AS a,www_position_data AS b WHERE a.gameid=b.id AND a.modelid=b.modelid AND b.posid=127 AND a.part_id=".$channel_val);
                            $pos_list['long'][$channel_val] = array();
                            foreach( $db_content->fetch_array() as $k_long=>$v_long ){
                                $db_content->set_model($v_long['modelid']);
                                $temp_title = $db_content->get_one("`id`=".$v_long['id'], 'title');
                                $pos_list['long'][$channel_val][$k_long]['title'] = $temp_title['title'];
                                $temp_url = $db_content->get_one("`id`=".$v_long['id'], 'url');
                                $pos_list['long'][$channel_val][$k_long]['url'] = $temp_url['url'];
                            }
                            $short_res = $db_content->query("SELECT b.id,b.modelid FROM www_partition_games AS a,www_position_data AS b WHERE a.gameid=b.id AND a.modelid=b.modelid AND b.posid=128 AND a.part_id=".$channel_val);
                            $pos_list['short'][$channel_val] = array();
                            foreach( $db_content->fetch_array() as $k_long=>$v_long ){
                                $db_content->set_model($v_long['modelid']);
                                $temp_title = $db_content->get_one("`id`=".$v_long['id'], 'shortname');
                                $pos_list['short'][$channel_val][$k_long]['title'] = $temp_title['shortname'];
                                $temp_url = $db_content->get_one("`id`=".$v_long['id'], 'url');
                                $pos_list['short'][$channel_val][$k_long]['url'] = $temp_url['url'];
                            }
                        }

		                include template('api', 'ttaxy2', 'mofang_v2');
                    }elseif($this->appid==526804 && !$this->catid ){
		                include template('api', 'luobo2', 'mofang_v2');
                    }elseif($part_id){//有game_id關聯專區
                        //這裡需要轉換為partid
                        if( $this->catid ){
				            $return_info = $this->info_list_part($this->catid);
                        }else{
				            $return_info = $this->info_list_part($part_id);
                        }
                        $info_list = $return_info['list'];
                        switch( $return_info['type'] ){//展現形式
                            //home頁
                            case 0:
                                $tab=$return_info['tab'];
		                        include template('api', 'home', 'mofang_v2');
                                break;
                            //列表
                            case 1:
		                        include template('api', 'list', 'mofang_v2');
                                break;
                        }
                    }elseif($game_id){//有game_id,無關聯專區
                        $modelid = 1;
					    $guide_catid = '103,190';
					    $info_list = $this->info_list_base($guide_catid, $this->info_type, $modelid, "`gameid`='|21-".$game_id."|'");
                        if(empty($info_list)){//無攻略內容
                            echo "暫無攻略!";
                        }else{
		                    include template('api', 'list', 'mofang_v2');
                        }
                    }else{
                        $modelid = 1;
					    $guide_catid = '103,190';
					    $info_list = $this->info_list_base($guide_catid, $this->info_type, $modelid);
                        if(empty($info_list)){//無攻略內容
                            echo "暫無攻略!";
                        }else{
		                    include template('api', 'list', 'mofang_v2');
                        }
                    }
                    exit();
				break;
                //禮包
				case 'gift':
                        
                    $game_id = get_wanyou_games($this->appid);

                    $db_privilege_account_model = pc_base::load_model('privilege_account_model');
                    $db_privilege_rule = pc_base::load_model('privilege_rule_model');
                    $db_privilege_account_nums_model = pc_base::load_model('privilege_account_nums_model');
                    //判斷是否有對應遊戲優惠
                    //禮包剩余量
                    $last_nums=0;
                    if($game_id){
                        $privilege_info = $db_privilege_account_model->select('`modelid`=21 AND `gameid`='.$game_id, 'id');
                        $last_privilege_id=0;
                        foreach( $privilege_info as $k_pi=>$v_pi ){
                            $last_privilege_id = $v_pi['id'];
                            $last_nums = $db_privilege_account_nums_model->count('`occupy_userid`=0 AND `privilegeid`='.$v_pi['id']);
                            if($last_nums>0){
                                break;
                            }
                        }
                    }
                    if($game_id){//有遊戲有對應禮包
                        $info_list = $this->gift_list($game_id);
                    }elseif($this->appid){//無對應遊戲或無對應禮包
                        echo "暫無禮包!";
                        exit();
                    }else{
                        //所有禮包
                        $info_list = $this->gift_list();
                    }

                    $uid = $this->uid ? intval($this->uid) : 0;

                    $currpage = $this->curr_page;
                    $pagenum = $this->pagenum;
                    //$part_info_ids = $this->db_partition_game->listinfo('`part_id` IN ('.$temp_arrchildid['arrchildid'].')', $listorder, $currpage, $pagenum);
                    //$content_total = $this->db_partition_game->count('`part_id` IN ('.$temp_arrchildid['arrchildid'].')');
                    if(!$_GET['page']){//無page參數
		                include template('api', 'fahao_list', 'mofang_v2');
                        exit();
                    }
				break;
                case 'search':
                    $info_list = $this->search($this->typeid, $this->keyword);
                    switch($this->typeid){
                        case 1:
		                    include template('api', 'fahao_list', 'mofang_v2');
                            break;
                        case 2:
                            break;
                    }
                    exit();
                break;
				default:
					$err_info['code'] = 99;
					$err_info['msg'] = '數據類別異常!';
					echo json_encode( $err_info );
					exit();
				break;
			}
	
			$game_information['code'] = 0;
			$game_information['data'] = $info_list;
				
			echo json_encode( $game_information );
		} 


        /*
         * 搜索
         *  @Param
                $typeid 類型id
                $keyword 搜索詞
         *
         **/
        public function search($typeid, $keyword){
            $db_privilege_account_model = pc_base::load_model('privilege_account_model');
            $db_privilege_account_nums_model = pc_base::load_model('privilege_account_nums_model');
            switch($typeid){
                //禮包
                case 1:
                    $result = $this->gift_list('', $keyword);
                    break;
                //攻略
                case 2:
                    break;
            }
            return $result;
        }

	}

	$handle = new WanyouApi();
