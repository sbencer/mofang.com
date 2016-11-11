    //存儲關聯遊戲
    function games($field,$value) {
        // 判斷是否有關聯遊戲，來控制後面插入數據是否執行
        if(isset($value) && !empty($value)){$relation_game = ture;}

        $rldb = pc_base::load_model('content_model');
        // 選擇數據庫關聯表
        $rldb->table_name = $rldb->db_tablepre.'relation';
        // 本欄目id
        $where['scat'] = $relation['scat'] = $this->data['catid']; 
        // 本文章的id
        $where['sid'] = $relation['sid'] = $this->data['id'];
        // 刪除原有所有關聯關系
        $rldb->delete($where);

        if($relation_game){

            $games = explode('|', $value);

            array_pop($games);

            array_shift($games);

            foreach ($games as $key => $value) {

                $game = explode('-',$value);

                $relation['tcat'] = $game[0]; 

                $relation['tid'] = $game[1]; 
                // 將所有關聯遊戲作為新關聯進行插入
                $reid = $rldb->insert($relation);

                // 萬遊攻略接口通信
                if ($game[0] == 21 && ($this->data['catid'] == 103 || $this->data['catid'] == 190)) {
                    // 選擇數據表
                    $model_arr = getcache('model', 'commons');
                    $rldb->table_name = $rldb->db_tablepre.$model_arr[$game[0]]['tablename'];
                    // 獲得關聯遊戲的信息
                    $appinfo = $rldb->get_one(array('id'=>$game[1]), 'appid,id,title,package_name');
                    // 有appid 則通信萬遊接口
                    if ($appinfo['appid']) {
                        $api_info = wanyou_tui_api($appinfo['appid']);
                        $res = substr(($api_info),0,3);
                        if (ord($res[0]) == 239 && ord($res[1]) == 187 && ord($res[2]) == 191){
                            $api_info = substr($api_info,3);
                        }
                        $package_info = "wanyou_gonglue_api-{$appinfo['id']}-{$appinfo['title']}-{$appinfo['package_name']}-{$appinfo['appid']}";
                        $response = json_decode($api_info);
                        // 執行狀態記錄
                        if ($response->result == 1) {
                            syslog(LOG_ERR, $package_info.' success');
                        } else {
                            syslog(LOG_ERR, $package_info.' error');
                        }
                    } else {
                            // 無appid 遊戲記錄
                            syslog(LOG_ERR, "wanyou_gonglue_api-{$appinfo['id']}-{$appinfo['title']}-{$appinfo['package_name']} noappid");
                    }
                }
            }

        }

    }
