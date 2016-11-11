
<?php
/**
 * @author mofang
 *
 */
class partition_tag {
	
	public function __construct() {

		$this->db_content = pc_base::load_model('content_model');
		$this->db_partition = pc_base::load_model('partition_model');
		$this->db_partition_game = pc_base::load_model('partition_games_model');
	}

	/**
	 * 列表頁標簽
	 * @param $data
	 */
	public function lists($data) {

		$part_info_ids = $this->db_partition_game->select('`part_id`='.$data['partid'], 'modelid,gameid', $data['infonum']);
		$part_info_array = array();
		foreach( $part_info_ids as $key=>$value ){
			$this->db_content->set_model($value['modelid']);
			$temp1 = $this->db_content->get_one('`id`='.$value['gameid']);
			$this->db_content->table_name .= '_data';
			$temp2 = $this->db_content->get_one('`id`='.$value['gameid']);

			$part_info_array[] = array_merge($temp1, $temp2);
		}
		$part_info_array_end['count_all'] = $this->db_partition_game->count('`part_id`='.$data['partid']);
		$part_info_array_end['contents'] = $part_info_array;

		return $part_info_array_end;
	}

	/**
	 * 列表頁標簽
	 * @param $data
	 */
	public function lists2($data) {

		$currpage = $data['currpage'] ? $data['currpage'] : 1;
		$pagenum = $data['pagenum'] ? $data['pagenum'] : 30;

        if( strpos($data['partid'],',') ){
            $temp_arrchildid['arrchildid'] = $data['partid'];
        }else{
            $temp_arrchildid = $this->db_partition->get_one('`catid`='.$data['partid'], 'arrchildid');
        }

        if( $data['listorder'] ){
            $listorder = '`listorder` DESC, `inputtime` DESC';
        }else{
            $listorder = $data['order'] ? $data['order'] : '`inputtime` DESC, `listorder` DESC';
        }

		$part_info_ids = $this->db_partition_game->listinfo('`part_id` IN ('.$temp_arrchildid['arrchildid'].')', $listorder, $currpage, $pagenum);
		$content_total = $this->db_partition_game->count('`part_id` IN ('.$temp_arrchildid['arrchildid'].')');

		if( $data['vieworder'] ){//看訪問量排序
			//這裡可以調用get_views函數
			$db_hits = pc_base::load_model('hits_model');
			foreach( $part_info_ids as $k_il=>$v_il ){
				$hits_where['hitsid'] = 'c-'.$v_il['modelid'].'-'.$v_il['gameid'];
				$temp_views = $db_hits->get_one($hits_where, 'views');
				$part_info_ids[$k_il]['views'] = $temp_views['views'];
			}
			usort( $part_info_ids, "partition_list_cmp_views" );
		}
		
		$part_info_array = array();
		foreach( $part_info_ids as $key=>$value ){
			$this->db_content->set_model($value['modelid']);
			$temp1 = $this->db_content->get_one('`id`='.$value['gameid']);
			$this->db_content->table_name .= '_data';
			$temp2 = $this->db_content->get_one('`id`='.$value['gameid']);

			$part_info_array[] = array_merge($temp1, $temp2);
		}
        
        if(is_wap()){
            foreach($part_info_array as $k_pi=>$v_pi){
                $part_info_array[$k_pi]['url'] = wap_url($v_pi['url']);
            }
        }

		$part_info_array_end['count_all'] = $content_total;
		$part_info_array_end['contents'] = $part_info_array;

		return $part_info_array_end;
	}

	public function partition_contents( $data ){
		if( $data['partition'] ){//所有欄目內容
			$temp_childid = $this->db_partition->get_one("`domain_dir`='".$data['partition']."'", 'arrchildid');
			$data['partid'] = $temp_childid['arrchildid'];
		}

        $listorder = $data['order'] ? $data['order'] : '`inputtime` DESC';

		//信息列表
		$info_list = $this->db_partition_game->select('`part_id` IN ('.$data['partid'].')', 'DISTINCT `gameid`,`modelid`', $data['nums'], $listorder);
		$partid = explode( ',', $data['partid']);

		if($data['makeurl']){
			$arrparentid = $this->db_partition->get_one('`catid`='.$partid[0], 'arrparentid');
			$arrparentid = $arrparentid['arrparentid'];
			$arrparentid = explode(',',$arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $data['partid'];
			if( $data['partition'] ){//所有欄目內容
				$top_parentid = $partid[0];
			}
			$short_name = $this->db_partition->get_one('`catid`='.$top_parentid, 'domain_dir');
			$short_name = $short_name['domain_dir'];
		}

		if( $data['vieworder'] ){//看訪問量排序
			//這裡可以調用get_views函數
			$db_hits = pc_base::load_model('hits_model');
			foreach( $info_list as $k_il=>$v_il ){
				$hits_where['hitsid'] = 'c-'.$v_il['modelid'].'-'.$v_il['gameid'];
				$temp_views = $db_hits->get_one($hits_where, 'views');
				$info_list[$k_il]['views'] = $temp_views['views'];
			}
			usort( $info_list, "partition_list_cmp_views" );
		}

		$info_list_array = array();
		if( $info_list ){
			foreach( $info_list as $info_v ){
				$this->db_content->set_model($info_v['modelid']);
                if($info_v['modelid'] == 11) {
				    $temp_item_1 = $this->db_content->get_one('`id`='.$info_v['gameid'], $data['fields'].',youtube_id');
                } else {
				    $temp_item_1 = $this->db_content->get_one('`id`='.$info_v['gameid'], $data['fields']);
                }
				$this->db_content->table_name .= '_data';
				$temp_item_2 = $this->db_content->get_one('`id`='.$info_v['gameid']);
				$info_list_item = array_merge( $temp_item_1, $temp_item_2 );
				if( $data['makeurl'] && $info_list_item['url'] && $short_name ){
					$info_list_item['url'] = get_info_url($info_list_item['catid'], $info_list_item['id'],$short_name);
				}
				$info_list_array[] = $info_list_item;
			}
		}

		//usort( $info_list_array, "partition_list_cmp" );
		return $info_list_array;
	}

   	/**
	 * 排行榜標簽
     * @author Jozh liu
	 */
	public function ranking($data) {
        //定義變量[初始化]
		$catid = $data['partid'];
        $num = isset($data['limit']) && !empty($data['limit']) ? intval($data['limit']) : 10;
        $sql = '';

		$temp_arrchildid = $this->db_partition->get_one('`catid`='.$catid, 'arrchildid');
        $sql .= ' `part_id` IN ('.$temp_arrchildid['arrchildid'].')';

        // 排行類型
        $domain = str_ireplace( '.mofang.com', '', $_SERVER['HTTP_HOST'] );
        $desc = trim($data['desc']);
        switch($desc){
            case 'week':
                $inputtime = SYS_TIME-7*86400;
                break;
            case 'month':
                $inputtime = SYS_TIME-30*86400;
                break;
            default: // day
                $inputtime = mktime(0,0,0,date('m'),date('d'),date('Y'));
                break;
        }
        $sql .= " AND inputtime>'$inputtime'";

		$part_info_ids = $this->db_partition_game->select($sql, 'modelid,gameid,inputtime');

        $db_hits = pc_base::load_model('hits_model');
        foreach( $part_info_ids as $k=>$v ){
            $hits_where['hitsid'] = 'c-'.$v['modelid'].'-'.$v['gameid'];
            $view_type = $desc.'views';

            $temp_views = $db_hits->get_one($hits_where, $view_type);
            $views = $temp_views[$view_type];
            $hits_arr[$views]['modelid'] = $v['modelid'];
            $hits_arr[$views]['gameid'] = $v['gameid'];
            $hits_arr[$views]['inputtime'] = $v['inputtime'];
            $hits_arr[$views][$view_type] = $temp_views[$view_type];
        }
        krsort($hits_arr);
        $hits_arr = array_slice($hits_arr, 0, $num);
		
		$array = array();
		foreach( $hits_arr as $key=>$value ){
			$this->db_content->set_model($value['modelid']);
			$temp1 = $this->db_content->get_one('`id`='.$value['gameid']);
			$this->db_content->table_name .= '_data';
			$temp2 = $this->db_content->get_one('`id`='.$value['gameid']);

			$array[] = array_merge($temp1, $temp2);
		}

        // 查緩存
        // $cache_key = 'content_tag-ranking-'.implode('-', $data);
        // if ( $ret = @apc_fetch($cache_key)) {
        //     return $ret;
        // }

        // 加緩存
		// apc_add($cache_key, $array, 86400);
		return $array;
	}

    /**
     * 根據catid獲取子欄目圖片
     */
    public function get_subpic_by_catid($data){
        $catid = intval($data['catid']);
		$array_info = $this->db_partition->select('`parentid`='.$catid, 'catid,setting');
        foreach( $array_info as $k_ai=>$v_ai ){
            $temp_pic = string2array($v_ai['setting']);
            $temp_pic = $temp_pic['tj_pic'] ? $temp_pic['tj_pic'] : '';
            $array_info[$k_ai]['pic'] = $temp_pic;
            unset($array_info[$k_ai]['setting']);
        }
        return $array_info;
    }

    /**
     * 根據catid查詢子集欄目id
     * @author Jozh liu
     */
    public function get_son_info_by_catid($data){
        $catid = intval($data['catid']);
		
        $channel_str = $this->db_partition->get_one('`catid`='.$data['catid'], 'arrchildid');
		$channel_arr = $this->db_partition->select('`catid` IN ('.$channel_str['arrchildid'].') AND `catid` !='.$data['catid'], 'catid,catname,setting');
        foreach( $channel_arr as $k_ai=>$v_ai ){
            $temp_pic = string2array($v_ai['setting']);
            $channel_arr[$k_ai]['tj_pic'] = $temp_pic['tj_pic'] ? $temp_pic['tj_pic'] : '';
            $channel_arr[$k_ai]['tj_link'] = $temp_pic['tj_link'] ? $temp_pic['tj_link'] : '';
            unset($channel_arr[$k_ai]['setting']);
        }
        return $channel_arr;
    }

	/**
	 * 調取子集欄目（同上，兩個方法待統一）
	 *
	 */
	public function copy_list( $data ){
		$channel_str = $this->db_partition->get_one('`catid`='.$data['catid'], 'arrchildid');
		$channel_array = $this->db_partition->select('`catid` IN ('.$channel_str['arrchildid'].') AND `catid` !='.$data['catid'], 'catid,catname,listorder');
        $sign = 1;
        foreach ($channel_array as $key=>$val) {
            if ($val['listorder'] == 0) {
                $sign = 0;
                break;
            }
        }
        if ($sign) {
            $channel_array = keysort($channel_array, 'listorder');
        }
		return $channel_array;
	}

	/**
	 * 通過id返回name
	 */
	public function idtoname( $data ){
		$catid = $data['catid'];
		$catname = $this->db_partition->select('`catid` = '.$catid,'catname');
		return $catname[0];
	}

	/**
     * 論壇熱貼
     * @author Jozh liu
	 */
	public function bbs_list($data) {
        return array();
        $fid = intval($data['fid']);
        $nums = intval($data['nums']);
        $list_order = isset($data['list_order']) ? : 'default';
        
        switch($list_order){
            case 'heat':
                $order = 'filter=heat&orderby=heats';
                break;
            case 'reply':
                $order = 'filter=reply&orderby=replies';
                break;
            default:
                $order = 'no_stick=1';
                break;
        }

        $bbs_api = 'http://bbs.mofang.com/api/mobile/index.php?module=forumdisplay&fid='.$fid.'&'.$order.'&tpp='.$nums;
        $data = mf_curl_get($bbs_api);
        $data = json_decode($data,true);
        $data = $data['Variables']['forum_threadlist'];
		return $data;
	}

	/**
	 * 查詢專區信息字段(可再優化為查詢指定配置項)
	 * @param $data
	 */
	public function partition_info($data) {
		$partid = $data['partid'];

		$part_info = $this->db_partition->get_one('`catid`='.$data['partid'], $data['fields']);
        if(strstr($data['fields'], 'setting') !== FALSE){//配置字段
            $part_info['setting'] = string2array($part_info['setting']);
        }
		return $part_info;
	}

	/**
	 * 查詢後台配置[遊戲下載]
	 */
	public function app_down_help($data) {
		$partid = $data['partid'];
        //信息類型
        $field_name = '';
        switch( $data['apptype'] ){
            case 'down':
                $field_name = 'app_down';
                break;
            case 'help':
                $field_name = 'app_help';
                break;
        }

		$app_info = $this->db_partition->get_one('`catid`='.$data['partid'], 'setting');
        $app_info = string2array($app_info['setting']);
		return empty($app_info[$field_name]) ? array() : $app_info[$field_name];
	}

	/**
	 * 查詢後台配置[四格漫畫]
	 */
	public function four_pics(){
		$info_list = $this->db_partition_game->select('`part_id`=180','modelid,gameid',8,'`listorder` ASC');
		$info_list_array = array();
		foreach( $info_list as $key=>$value ){
			if($key==4 || $key==6) $info_list_array[$key]['class'] = 'class="img5"';
			$this->db_content->set_model($value['modelid']);
			$temp_thumb = $this->db_content->get_one('`id`='.$value['gameid'], 'thumb, id');
			$info_list_array[$key]['thumb'] = $temp_thumb['thumb'];
			$info_list_array[$key]['id'] = $temp_thumb['id'];
		}
		return $info_list_array;
	}

	public function gonglue_lists( $data ){
		$glid = $data['gonglueid'];
		$temp_result_list = $this->db_partition_game->select('`part_id` IN('.$glid.')', 'modelid,gameid,listorder', '', '`listorder` ASC');
		$result_list = array();
		foreach( $temp_result_list as $key=>$value ){
			$result_list[$key]['typeid'] = substr($value['listorder'],-1);
			$result_list[$key]['channelid'] = substr($value['listorder'], 0, -1);
			$result_list[$key]['url'] = get_stra_url($value['gameid'], $value['modelid']);
            if(is_wap()){//wap url
			    $result_list[$key]['url'] = wap_url($result_list[$key]['url']);
            }
		}
		return $result_list;
	}

	public function gonglue_lists_cont( $data ){
		$glcatid = $data['glcatid'];
		$glid = $data['glid'];
		$temp_pid = $this->db_partition_game->get_one('`gameid`='.$glid.' AND `part_id` IN(38,263,262,261,260,46,257,256,258,259)', 'part_id');
		$temp_result_list = $this->db_partition_game->select('`part_id`='.$temp_pid['part_id'], 'modelid,gameid,listorder', '', '`listorder` ASC');
		$result_list = array();
		foreach( $temp_result_list as $key=>$value ){
			$result_list[$key]['typeid'] = substr($value['listorder'],-1);
			$result_list[$key]['channelid'] = substr($value['listorder'], 0, -1);
			$result_list[$key]['url'] = get_stra_url($value['gameid'], $value['modelid']);
            if(is_wap()){//wap url
			    $result_list[$key]['url'] = wap_url($result_list[$key]['url']);
            }
		}
		return $result_list;
	}

	/**
	 * 攻略內容
	 */
	public function partition_stratogy( $data ){
		//信息列表
		$info_list = $this->db_partition_game->select('`part_id`='.$data['partid'], 'modelid,gameid', $data['nums']);
	
		if($data['makeurl']){
			$arrparentid = $this->db_partition->get_one('`catid`='.$data['partid'], 'arrparentid');
			$arrparentid = $arrparentid['arrparentid'];
			$arrparentid = explode(',',$arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $data['partid'];
			$short_name = $this->db_partition->get_one('`catid`='.$top_parentid, 'domain_dir');
			$short_name = $short_name['domain_dir'];
		}

		$info_list_array = array();
		if( $info_list ){
			foreach( $info_list as $info_v ){
				$this->db_content->set_model($info_v['modelid']);
				$info_list_item = $this->db_content->get_one('`id`='.$info_v['gameid'], $data['fields']);
				if( $data['makeurl'] && $info_list_item['url'] && $short_name ){
                    if(is_wap()){
					    $info_list_item['url'] = wap_url($info_list_item['url']);
                    }
				}
				$info_list_array[] = $info_list_item;
			}
		}
		return $info_list_array;
	}

	/**
	 * 根據短標題獲取url
	 */
	public function short_name_list( $data ){
		$temp_info_list = $this->db_partition_game->select('`part_id`='.$data['partid'], 'modelid,gameid', '', '`listorder` DESC');
		$shortname_array = array();
		foreach( $temp_info_list as $key=>$value){
			if (count($shortname_array) >= 16){
				break;
			}
			$this->db_content->set_model($value['modelid']);
			$temp_item = $this->db_content->get_one("`shortname` !='' AND `id`=".$value['gameid'], 'id,shortname');

			if($temp_item['shortname'] && strlen($temp_item['shortname'])<=12 ){
				$shortname_array[] = $temp_item;
			}
		}
		return $shortname_array;
	}

	/**
	 * 列表頁標簽
	 * @param $data
	 */
	public function part_channel_list($data) {
		$partid = $data['partid'];

		$arrchildid = $this->db_partition->get_one('`catid`='.$data['partid'], 'arrchildid');
		$result = explode(',', $arrchildid['arrchildid']);

		$part_info = array();
		foreach( $result as $key=>$value ){
			$temp_title = $this->db_partition->get_one('`catid`='.$value, 'catname');
			$part_info[$key]['name'] = $temp_title['catname'];
			$part_info[$key]['catid'] = $value;
		}

		return $part_info;
	}

	/**
	 * 欄目標簽
	 * @param $data
	 */
	public function category($data) {
		$data['catid'] = intval($data['catid']);
		$array = array();
		$siteid = $data['siteid'] && intval($data['siteid']) ? intval($data['siteid']) : get_siteid();
		$categorys = getcache('category_content_'.$siteid,'commons');
		$site = siteinfo($siteid);
		$i = 1;
		foreach ($categorys as $catid=>$cat) {
			if($i>$data['limit']) break;
			if((!$cat['ismenu']) || $siteid && $cat['siteid']!=$siteid) continue;
			if (strpos($cat['url'], '://') === false) {
				$cat['url'] = substr($site['domain'],0,-1).$cat['url'];
			}
			if($cat['parentid']==$data['catid']) {
				$array[$catid] = $cat;
				$i++;
			}
		}
		return $array;
	}
	/*
	*huoqu dianzan
	*/
	public function select_com($data){
	$cid = trim($data['contentid']);
	$catid = trim($data['catid']);
	$mood_db = pc_base::load_model('mood_model');
		$rs= $mood_db->get_one(array("catid"=>$catid,"contentid"=>$cid),"n5,n7");
		
	return $rs;
	}
	/*
	*表情數據
	*
	*/
	public function select_total($data){
		$cid = trim($data['contentid']);
		$catid = trim($data['catid']);
		$mood_db = pc_base::load_model('mood_model');
		$rs= $mood_db->get_one(array("catid"=>$catid,"contentid"=>$cid));
		
		return $rs;
	}

    public function activity_lists($data) {
	
       $db = pc_base::load_model('partition_activity_model');
       $return['setting'] = $db->get_one(array('pid'=>$data['pid']));
        
       $sql = <<<SQL
            SELECT * FROM `phpcms_partition_activity_data`
            WHERE `pid` = {$data['pid']}
            AND (`end_time` > UNIX_TIMESTAMP(NOW())
                OR `limit_time` = 1
            )
            ORDER BY `circle` ASC, 
            `start_time` ASC 

SQL;

        $result = $db->query($sql);
        $data= $db->fetch_array();
        foreach($data as &$val) {
            if($val.start_time >= time() || $val['circle'] < 9) $val['status'] = 'color_o'; 
            else $val['status'] = 'color_w';

        }
        $return['data'] = $data;

        return $return;
        

    }

	/**
	 * 更新緩存
	 */
	public function wiki($data) {
		$categorys = $this->categorys = array();
        $result = $this->db_partition->select("`module`='partition' AND `ismenu` = 1 AND `arrparentid` like '%".$data['partid']."%'", 
            'catid,parentid,arrparentid,arrchildid,catname,url,listorder', 
            '', 
            '`listorder` ASC');
        foreach($result as $key=>$r){
            $data[$r['catid']] = $r;
            $data[$r['catid']]['url'] = get_part_url($r['catid'], 'tyong');
        }
        foreach( $data as $key=>$value ){
            $dir = array();
            if($value['arrparentid']) {
                $dir = explode(',',$value['arrparentid']);
            }
            $count = count($dir);
            switch($count) {
                case 2:
                    $category[$key] = array_merge($value, $category[$key]?:array());    
                    break;
                case 3:
                    $category[$dir[2]]['child'][$key] = array_merge($value, $category[$dir[2]]['child'][$key]?:array());    
                    break;
                case 4:
                    $category[$dir[2]]['child'][$dir[3]]['child'][$key] = $value;    
                    break;
                
            }
                
        }

        // 栏目按照listorder进行排序
        $category = array_sort($category, 'listorder', SORT_ASC);

		return $category;
	}

    /**
     * 获取最新导入文章
     */
    public function latest($data) {
        // 传入partid
        $partid = $data['partid'];

        // 获取数据条数
        $nums = intval($data['limit']) ? : 10;
        
        // 获得当前专区的所有栏目
        $catids = $this->db_partition->select("arrparentid like '%{$partid}%'", 'catid');
        
        // 将catid组成查询字符串
        foreach($catids as $val) {
            $catid_arr[] = $val['catid']; 
        }
        $catid_str = implode(',', $catid_arr);

        // 通过栏目获得最新被导入的文章id
        $ids = $this->db_partition_game->select("modelid = 1 AND part_id in ({$catid_str})", 'distinct `gameid`,`inputtime`', $nums, 'inputtime desc');

        // 将文章id组成查询字符串
        foreach($ids as $val) {
            $id_arr[] = $val['gameid']; 
            $id_date[$val['gameid']] = $val['inputtime'];
        }
        $id_str = implode(',', $id_arr);
        
        // 从www_news 获得文章的标题等相关信息     
		$this->db_content->set_model(1);
        $result = $this->db_content->select("id in ($id_str)", "id,catid,title,shortname", "", "field(id,$id_str)");
        foreach($result as &$val) {
            $val['inputtime'] = $id_date[$val['id']];    
        }

        // 返回数据
        return $result ? : array();
    }

    /**
     * 论坛最新帖子查询
     */
    public function bbs_post($data) {
        // 接口地址
        $url = "http://bbs.mofang.com.tw/api.php?mod=mofang_post";

        // 获取专区对应BBS版块id
        $num = $data['limit']?:10;
        $fid = (int)$data['fid'];
        $type = $data['type'];

        if($fid && $type) {
            $url .= "&threadsType={$type}&fid={$fid}&thread_num={$num}";
        } else {
            return array();
        }

        $result = json_decode(mf_curl_get($url),true); 
        if($result['code'] == 0) {
            return $result['data']['threads'];
        } else {
            return array();    
        }

    }

    /**
     * 论坛最新帖子查询
     */
    public function feed_post($data) {
        // 接口地址
        $url = "http://api.mofang.com.tw/feed/v3/web/thread/";

        // 获取专区对应BBS版块id
        $param['fid'] = $fid = (int)$data['fid'];
        $param['size'] = $data['limit']?:10;
        $param['page'] = (int)$data['page']?:1;

        // 接口类型定义
        $typeid = $data['type'];
        $types = array(
            'weekHots' => 'bjxhotlist',
            'newPost' => 'bjxnewlist',
            'newReply' => 'bjxnewpostlist',
        );

        // 拼接最终请求url
        if($fid && $typeid) {
            $url .= $types[$typeid];
        } else {
            return array();
        }

        $result = json_decode(mf_curl($url, json_encode($param)),true); 
        if($result['code'] == 0) {
            return $result['data']['threads'];
        } else {
            return array();    
        }

    }

    public function card_category($data) {
        // 銷毀CMS的路由參數
        unset($_GET['m'],$_GET['c'],$_GET['a']);
        $domain_dir = $_GET['p'];

        if(empty($data['dbid'])) return;
        $dbid = $data['dbid'];

        $other_condition = '/dbid/'.$dbid.'/setid/0';

        // 加載卡牌數據庫
        $card_api = pc_base::load_config('api','card_api');
        $api_url = $card_api.'/gettables'.$other_condition;
        $table_info = mf_curl_get($api_url);
        $table_info = json_decode($table_info, true);
        if($table_info['code'] == 0) {
            return $table_info['data']['list'];    
        } else {
            return array();
        }
    }


}
