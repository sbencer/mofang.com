<?php

//引入app排行
define('EXT_PATH', PC_PATH . 'modules' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);
define('CRON_PATH', PC_PATH . '../cron/' );

class content_tag {

    private $appkey = '10005';
    private $secret = '59d37a2a4d60a22a4d673a00b1a14236';
    private $recommend_url = "http://fahao.mofang.com.tw/api/v1/gift/recommend?";
    private $lasest_games_url = "http://game.mofang.com.tw/api/web/GetGameByType?";
    private $db;

    public function __construct() {
        $this->db = pc_base::load_model('content_model');
        $this->type_db = pc_base::load_model('type_model');
        $this->position = pc_base::load_model('position_data_model');

        $this->game_ranking = pc_base::load_model('game_ranking_model');
        $this->ranking_history = pc_base::load_model('game_ranking_top20_model');
    }

    /**
     * 初始化模型
     * @param $catid
     */
    public function set_modelid($catid) {
        static $CATS;
        $siteids = getcache('category_content', 'commons');
        if (!$siteids[$catid])
            return false;
        $siteid = $siteids[$catid];
        if ($CATS[$siteid]) {
            $this->category = $CATS[$siteid];
        } else {
            $CATS[$siteid] = $this->category = getcache('category_content_' . $siteid, 'commons');
        }
        if ($this->category[$catid]['type'] != 0)
            return false;
        $this->modelid = $this->category[$catid]['modelid'];
        $this->db->set_model($this->modelid);
        $this->tablename = $this->db->table_name;
        if (empty($this->category)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 分頁統計
     * @param $data
     */
    public function count($data) {
        if ($data['iosgame'] == 1) {
            return $this->iosgame_count($data);
        }
        if ($data['action'] == 'lists' || $data['action'] == 'hits' || $data['action'] == 'user_lists') {
            $catid = intval($data['catid']);
            $outhorname = $data['outhorname'] ? : '';
            if (!$this->set_modelid($catid))
                return false;
            if (isset($data['where'])) {
                $sql = $data['where'];
            } else {
                if (strpos($data['catid'], ',')) {
                    $catids_str = addslashes(trim($data['catid']));
                    $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
                } elseif ($this->category[$catid]['child']) {
                    $catids_str = $this->category[$catid]['arrchildid'];
                    $pos = strpos($catids_str, ',') + 1;
                    $catids_str = substr($catids_str, $pos);
                    $sql = "status=99 AND catid IN ($catids_str)";
                } else {
                    $sql = "status=99 AND catid='$catid'";
                }
                if (!empty($outhorname)) {
                    $sql .= " AND `outhorname` = '$outhorname'";
                }
            }
            return $this->db->count($sql);
        }
    }

    /**
     * iOS遊戲列表分頁統計
     * @param $data
     */
    public function iosgame_count($data) {
        $catid = intval($data['catid']);
        if (!$this->set_modelid($catid))
            return false;
        if ($data['linktagids']) {
            $linktag_ids = explode(',', $data['linktagids']);
            $ids = array();
            $l2c_db = pc_base::load_model('linktag_to_content_model');
            foreach ($linktag_ids as $linktag_id) {
                if ($linktag_id) {
                    if ($ids) {
                        $ids_str = join(',', $ids);
                        $rows = $l2c_db->select("linktag_id = $linktag_id AND catid = $catid AND content_id IN ($ids_str)", 'content_id');
                    } else {
                        $rows = $l2c_db->select(array('linktag_id' => $linktag_id, 'catid' => $catid), 'content_id');
                    }
                    $ids = array_map('array_pop', $rows);
                }
            }
        }

        if (isset($data['where'])) {
            $sql = $data['where'];
        } else {
            $sql = "m.status=99 AND m.catid='$catid'";
        }

        if ($data['price'] == 1) {
            $sql .= " AND d.price_number = 0";
        } elseif ($data['price'] == 2) {
            $sql .= " AND d.limit_free = 1";
        }

        if ($data['device'] == 3) {
            $sql .= " AND d.device='3'";
        } elseif ($data['device'] == 1) {
            $sql .= " AND d.device IN (1,3)";
        } elseif ($data['device'] == 2) {
            $sql .= " AND d.device IN (2,3)";
        }

        if (!empty($data['linktagids']) && $ids) {
            $ids_str = join(',', $ids);
            $sql .= " AND m.id IN ($ids_str)";
        } elseif (!empty($data['linktagids']) && empty($ids)) {
            return 0;
        }

        $sql .= " AND m.id = d.id";

        $order = $data['order'];
        $limit = $data['limit'];

//$return = $this->db->select($sql, '*', $data['limit'], $order, '', 'id');
        $sql = sprintf("SELECT COUNT(*) as cnt FROM %s m, %s d WHERE %s", $this->db->table_name, $this->db->table_name . '_data', $sql);
        $res = $this->db->query($sql);
        $return = $this->db->fetch_array();
        if ($return) {
            return $return[0]['cnt'];
        }
    }

    /**
     * 返回子集ids
     * @param $data
     * @author jozh liu
     */
    public function get_catid_son($data) {
        $catids = explode(',', $data['catid']);
        if (!$this->set_modelid($catids[0]))
            return false;

        foreach ($catids as $catid) {
            if ($this->category[$catid]['child']) {
                $catids = array_merge($catids, explode(',', $this->category[$catid]['arrchildid']));
            }
        }
        $catids = array_unique(array_filter($catids, 'trim'));
        $catids_str = join(',', $catids);

        $type = isset($data['type']) && $data['type'] ? 1 : 0;
        if ($type) {
            $catids_str = explode(',', $catids_str);
        }
        $return = $catids_str;

        return $return;
    }

    /**
     * 遊戲相關資訊列表
     * @param $data
     */
    public function gameinfo_lists($data) {
        $catids = explode(',', $data['catid']);
        if (!$this->set_modelid($catids[0]))
            return false;
        if (!isset($data['gameid']) || !$data['gameid']) {
            return false;
        }
        foreach ($catids as $catid) {
            if ($this->category[$catid]['child']) {
                $catids = array_merge($catids, explode(',', $this->category[$catid]['arrchildid']));
            }
        }
        $catids = array_unique(array_filter($catids, 'trim'));
        $catids_str = join(',', $catids);
//增加對新老ID的判斷
        if ($data['game_type'] == 'old') {
            $gameid_sqls = array();
            foreach ($data['gameid'] as $gameid) {
                $gameid_sqls[] = "`gameid` LIKE '%|{$gameid['model_id']}-{$gameid['content_id']}|%'";
            }
            if (isset($data['where'])) {
                $sql = $data['where'];
            } else {
                $thumb = intval($data['thumb']) ? " AND thumb != ''" : '';
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            }
            $sql .= ' AND ( ' . join(' OR ', $gameid_sqls) . ' )';
            $order = $data['order'];
            $return = $this->db->select($sql, '*', $data['limit'], $order, '', 'id');
        } else {
//文章内调用，过滤当前文章 yzg
            if (isset($data['id'])) {
                $sql = " `id` != {$data['id']} AND";
            } else {
                $sql = '';
            }
//兼容多游戏绑定，使用IN查询 yzg
            $gameid_str = join(',', array_filter($data['gameid']));
            $order = 'addtime desc';
//使用新庫關聯表查詢
            $relation_game_db = pc_base::load_model('relation_game_model');
            $new_sql = $sql . " `catid` IN ($catids_str) AND `gameid` IN ($gameid_str)";
            $return = $relation_game_db->select($new_sql, '*', $data['limit'], $order, '', '');
            if (!empty($return)) {
                $ids = array();
                foreach ($return as $key => $v) {
# code...
                    if (isset($v['id']) && !empty($v['id'])) {
                        $ids[] = $v['id'];
                    } else {
                        continue;
                    }
                }
//查詢基本信息
                $ids = implode('\',\'', $ids);
                $return = $this->db->select("`id` IN ('$ids')", '*', '', 'id desc', '', 'id');
            }
            $get_num = count($return);
            if ($get_num < $data['limit']) {
//获得已经查询到的信息，不再重复查询
                $has_ids = join(',', array_keys($return))? : 0;
                $need_num = $data['limit'] - $get_num;
//数量不足，取当前栏目中的最新数据进行填充 yzg
                $other_sql = $sql . " catid IN ($catid) AND id NOT IN ($has_ids)";
                $other_data = $this->db->select($other_sql, '*', $need_num, 'id desc', '', 'id');
//数据合并作为返回值 yzg
                $return = array_merge($return, $other_data);
            }
        }

//調用副表的數據
        if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {

            $ids = array();
            foreach ($return as $v) {
                if (isset($v['id']) && !empty($v['id'])) {
                    $ids[] = $v['id'];
                } else {
                    continue;
                }
            }
            if (!empty($ids)) {
                $this->db->table_name = $this->db->table_name . '_data';
                $ids = implode('\',\'', $ids);
                $r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
                if (!empty($r)) {
                    foreach ($r as $k => $v) {
                        if (isset($return[$k]))
                            $return[$k] = array_merge($v, $return[$k]);
                    }
                }
            }
        }
//排重
        foreach ($return as $k => $v) {
            if ($v['id'] == $data['id']) {
                unset($return[$k]);
            }
        }
        return $return;
    }

    /**
     * 列表頁標簽
     * @param $data
     */
    public function lists($data) {

        $catid = intval($data['catid']);
        $field = $data['field'] ? : '*';
        $keywords = $data['key_words'] ? : '';
        if (!$this->set_modelid($catid))
            return false;
        if (isset($data['where'])) {
            $sql = $data['where'];
        } else {
            $thumb = intval($data['thumb']) ? " AND thumb != ''" : '';
            if (strpos($data['catid'], ',')) {
                $catids_str = addslashes(trim($data['catid']));
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            } elseif ($this->category[$catid]['child']) {
                $catids_str = $this->category[$catid]['arrchildid'];
                $pos = strpos($catids_str, ',') + 1;
                $catids_str = substr($catids_str, $pos);
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            } else {
                $sql = "status=99 AND catid='$catid'" . $thumb;
            }
            if (!empty($keywords)) {
                $sql .= " AND `title` like '%$keywords%'";
            }
            if (isset($data['type']) && $data['type'] == 'coupon') {
                $sql .= " AND end_time >" . time();
            }
        }
        
        
        //加入tag標籤查詢條件
        if($data['listtype']=="intag")
        {
        	$val = "";
        	switch ($catid) {
				    case "10000056": //情報=>情報+採訪
				        $val = "1,7";
				        break;
				    case "10000051": //遊戲=>評測+攻略+專訪
				        $val = "5,6,8";
				        break;
				    case "10000054": //產業=>產業
				        $val = "2";
				        break;
				   	case "10000053": //趣味=>趣味
				        $val = "3";
				        break;
						case "10000272": //動漫=>動漫
				        $val = "4";
				        break;		
				    case "10000222": //女性向=>女性向
				        $val = "9";
				        break;		
				    default:   
				    		$val = "10"; //綜合
				    		break;
					}	
					
					//判斷是不是綜合(複數catid)
					if($val!="10") //如果是綜合就不動作
        		$sql = "status=99 AND (catid='$catid' or tag in (" . $val . "))";
        }
        
        
        //使用tag標籤查詢 by sbencer
        	switch ($catid) {
				    case "10000286": //情報
				        $sql = "status=99 AND tag='1' ";
				        break;
				    case "10000287": //產業
				        $sql = "status=99 AND tag='2' ";
				        break;
				    case "10000288": //趣味
				        $sql = "status=99 AND tag='3' ";
				        break;
				   	case "10000289": //動漫
				        $sql = "status=99 AND tag='4' ";
				        break;
						case "10000290": //評測
				        $sql = "status=99 AND tag='5' ";
				        break;		
				    case "10000291": //攻略
				        $sql = "status=99 AND tag='6' ";
				        break;		
				    case "10000292": //採訪
				        $sql = "status=99 AND tag='7' ";
				        break;
				    case "10000293": //專訪
				        $sql = "status=99 AND tag='8' ";
				        break;	
				    case "10000294": //女性向
				        $sql = "status=99 AND tag='9' ";
				        break;	
				    default:   
				    		break;
         }
        
       
        
        $order = $data['order'];
        
        //動漫-從次元角落同步過來的，要改用inputtime desc來排序
        if($catid == "10000142")
        {
	        $order = " inputtime desc ";
				}
        
        if (!empty($data['limitd']))
            $data['limit'] = $data['limitd'];

        $siteids = getcache('category_content', 'commons');
        $siteid = $siteids[$catid];
			
        $return = $this->db->select($sql, $field, $data['limit'], $order, '', 'id');
//調用遊戲數據
        if (isset($data['gameinfo']) && intval($data['gameinfo']) == 1) {
            $return = $this->gameinfo_pingce($return);
        }
//調用副表的數據
        if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {
            $ids = array();
            foreach ($return as $v) {
                if (isset($v['id']) && !empty($v['id'])) {
                    $ids[] = $v['id'];
                } else {
                    continue;
                }
            }
            if (!empty($ids)) {
                $this->db->table_name = $this->db->table_name . '_data';
                $ids = implode('\',\'', $ids);
                $r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
                if (!empty($r)) {
                    foreach ($r as $k => $v) {
                        if (isset($return[$k]))
                            $return[$k] = array_merge($v, $return[$k]);
                    }
                }
            }
        }
        if ($data['comment_order']) {
            $new = array();
            foreach ($return as $key => $val) {
                $total = get_comments(id_encode('content_' . $val['catid'], $val['id'], 1));
                $val['total'] = $total;
                $new[] = $val;
            }
            unset($return);
            $return = arr_ksort($new, 'total');
            $return = array_slice($return, 0, $data['comment_num']);
        }

        if ($data['total']) {
            $return['contents'] = $return;
            $return['content_total'] = $content_total;
        }
        return $return;
    }

    /**
     * 列表頁標簽
     * @param $data
     */
    public function lists_bydata($data) {
        $catid = intval($data['catid']);
        if (!$this->set_modelid($catid))
            return false;
        $ids = array();

        $sql = " m.status=99 AND m.catid='$catid' ";
        if (isset($data['where'])) {
            $sql .= ' AND ' . $data['where'];
        }

        $sql .= " AND m.id = d.id";

        $order = $data['order'];
        $limit = $data['limit'];

//$return = $this->db->select($sql, '*', $data['limit'], $order, '', 'id');
        $sql = sprintf("SELECT %s FROM %s m, %s d WHERE %s ORDER BY %s LIMIT %s", "m.*, d.*", $this->db->table_name, $this->db->table_name . '_data', $sql, $order, $data['limit']);
        $res = $this->db->query($sql);
        $return = $this->db->fetch_array('id');

        return $return;
    }

    /**
     * iOS遊戲列表頁標簽
     * @param $data
     */
    public function iosgame_lists($data) {

        $catid = intval($data['catid']);
        if (!$catid && $data['modelid']) {
            if ($data['modelid'] == 20) {
                $catid = 20;
            } else {
                $catid = 134;
            }
        }
        if (!$this->set_modelid($catid))
            return false;

        if ($data['linktagids']) {
// 直接填寫大分類linktagid，則從數據庫緩存表中查詢數據
            if (in_array($data['linktagids'], array(4, 94, 95))) {
                $weekgames_db = pc_base::load_model('content_model');
                $weekgames_db->table_name = $this->db->db_tablepre . 'weekgames_tmp';
                $updatetime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $rows = $weekgames_db->get_one(array('linktag_pid' => $data['linktagids'], 'updatetime' => $updatetime), 'data');
                $res = string2array($rows['data']);
                return $res;
            }
            $linktag_ids = explode(',', $data['linktagids']);

            $ids = array();
            $l2c_db = pc_base::load_model('linktag_to_content_model');
            foreach ($linktag_ids as $linktag_id) {
                if ($linktag_id) {
                    if ($ids) {
                        $ids_str = join(',', $ids);
                        $rows = $l2c_db->select("linktag_id = $linktag_id AND catid = $catid AND content_id IN ($ids_str)", 'content_id', NULL, 'id');
                    } else {
                        $rows = $l2c_db->select(array('linktag_id' => $linktag_id, 'catid' => $catid), 'content_id');
                    }
                    $ids = array_map('array_pop', $rows);
                }
            }
        }

        if (isset($data['where'])) {
            $sql = $data['where'];
        } else {
            $sql = "m.status=99 AND m.catid='$catid'";
        }

        if ($data['price'] == 1) {
            $sql .= " AND d.price_number = 0";
        } elseif ($data['price'] == 2) {
            $sql .= " AND d.limit_free = 1";
        }

        if ($data['device'] == 3) {
            $sql .= " AND d.device='3'";
        } elseif ($data['device'] == 1) {
            $sql .= " AND d.device IN (1,3)";
        } elseif ($data['device'] == 2) {
            $sql .= " AND d.device IN (2,3)";
        }

        $id = @intval($data['id']);
        if ($id) {
            $sql .= " AND m.id = '{$id}'";
        }

        if (!empty($data['linktagids']) && $ids) {
            $ids_str = join(',', $ids);
            $sql .= " AND m.id IN ($ids_str)";
        } elseif (!empty($data['linktagids']) && empty($ids)) {
            return;
        }

        if (isset($data['day'])) {
            $updatetime = SYS_TIME - intval($data['day']) * 86400;
            $sql .= " AND m.updatetime>'$updatetime'";
        }

//$sql .= " AND m.id = d.id AND h.hitsid = CONCAT('c-{$this->category[$catid]['modelid']}-',m.id)";

        $order = $data['order']? : "m.inputtime DESC";
        $limit = $data['limit'];

//$return = $this->db->select($sql, '*', $data['limit'], $order, '', 'id');
        $sql = sprintf("SELECT %s FROM %s m inner join %s d on m.id = d.id left outer join %s h on h.hitsid = CONCAT('c-{$this->category[$catid]['modelid']}-',m.id) WHERE %s ORDER BY %s LIMIT %s", "m.id, m.title, m.en_title, m.stars, m.icon, m.url, m.keywords, m.description, d.content, d.package, d.brief, d.version,d.icon_tag, d.price_number, d.price_unit, d.filesize, d.limit_free, d.limit_free_timeline, d.release_time, d.screenshots, h.views, m.language, d.author_name", $this->db->table_name, $this->db->table_name . '_data', $this->db->db_tablepre . 'hits', $sql, $order, $data['limit']);
// $res = $this->db->query($sql);
// $return = $this->db->fetch_array('id');
//對SQL查詢進行緩存 ,進一步提升頁面加載速度 
        $cache_key = sha1($sql);
        $cache_key .= '_d';
        if (!$res = getcache($cache_key, '', 'memcache', 'html')) {
//未取對應SQL的緩存數據，讀數據庫，並生成緩存，下次使用
            $res = $this->db->query($sql);
            $return = $this->db->fetch_array('id');
            setcache($cache_key, $return, '', 'memcache', 'html', 1800);
        } else {
//有數據就直接獲取
            $return = getcache($cache_key, '', 'memcache', 'html');
        }



        $ids = array_keys($return);
        if (!$ids)
            return NULL;
        $sql = sprintf("SELECT tag_id, content_id, tag_name, parent_id FROM %slinktag t INNER JOIN %slinktag_to_content lt ON t.tag_id = lt.linktag_id WHERE catid = %d AND content_id IN (%s)", $this->db->db_tablepre, $this->db->db_tablepre, $catid, join(',', $ids));
//增加緩存
        $cache_key = sha1($sql);
        $cache_key .= '_d';
        if (!$res = getcache($cache_key, '', 'memcache', 'html')) {
            $res = $this->db->query($sql);
            $tags = $this->db->fetch_array();
            setcache($cache_key, $tags, '', 'memcache', 'html', 1800);
        } else {
            $tags = getcache($cache_key, '', 'memcache', 'html');
        }


        if ($tags) {
            foreach ($tags as $tagrow) {
                $return[$tagrow['content_id']]['tags'][$tagrow['parent_id']] = array('id' => $tagrow['tag_id'], 'tag' => $tagrow['tag_name']);
                $return[$tagrow['content_id']]['alltags'][] = array('id' => $tagrow['tag_id'], 'tag' => $tagrow['tag_name']);
            }
        }
        if ($data['count']) {
// 資訊
            $sql = sprintf("SELECT count(*) as count FROM %srelation WHERE tcat = %d AND tid IN (%s) AND scat IN (81,182,796,101,188,797,264)", $this->db->db_tablepre, $catid, join(',', $ids));
            $res = $this->db->query($sql);
            $news = $this->db->fetch_array();
            if ($news) {
                $return[$ids[0]]['news_count'] = $news[0]['count'];
            } else {
                $return[$ids[0]]['news_count'] = 0;
            }
// 攻略
            $sql = sprintf("SELECT count(*) as count FROM %srelation WHERE tcat = %d AND tid IN (%s) AND scat IN (83,184,103,190,264)", $this->db->db_tablepre, $catid, join(',', $ids));
//以下為本段原代碼
// $res = $this->db->query($sql);
// $strategy = $this->db->fetch_array();
//以下為修改，增加緩存
            $cache_key = sha1($sql);
            $cache_key .= '_d';
            if (!$res = getcache($cache_key, '', 'memcache', 'html')) {
                $res = $this->db->query($sql);
                $strategy = $this->db->fetch_array();
                setcache($cache_key, $strategy, '', 'memcache', 'html', 1800);
            } else {
                $strategy = getcache($cache_key, '', 'memcache', 'html');
            }
//修改結束 

            if ($strategy) {
                $return[$ids[0]]['strategy_count'] = $strategy[0]['count'];
            } else {
                $return[$ids[0]]['strategy_count'] = 0;
            }
// 視頻
            $sql = sprintf("SELECT count(*) as count FROM %srelation WHERE tcat = %d AND tid IN (%s) AND scat IN (472,473,474,475,476,477)", $this->db->db_tablepre, $catid, join(',', $ids));
            $res = $this->db->query($sql);
            $video = $this->db->fetch_array();
            if ($video) {
                $return[$ids[0]]['video_count'] = $video[0]['count'];
            } else {
                $return[$ids[0]]['video_count'] = 0;
            }
// 表態
            $sql = sprintf("SELECT total as count FROM %smood WHERE catid=%s AND contentid=%s", $this->db->db_tablepre, $catid, join(',', $ids));
            $res = $this->db->query($sql);
            $mood = $this->db->fetch_array();
            if ($mood) {
                $return[$ids[0]]['mood_count'] = $mood[0]['count'];
            } else {
                $return[$ids[0]]['mood_count'] = 0;
            }
// 吐槽
            $sql = sprintf("SELECT count(*) as count FROM %ssarcasm_data_1 WHERE sarcasmid='content_%s-%s-1'", $this->db->db_tablepre, $catid, join(',', $ids));
            $res = $this->db->query($sql);
            $sarcasm = $this->db->fetch_array();
            if ($sarcasm) {
                $return[$ids[0]]['sarcasm_count'] = $sarcasm[0]['count'];
            } else {
                $return[$ids[0]]['sarcasm_count'] = 0;
            }
// 評論
            $sql = sprintf("SELECT count(*) as count FROM %scomment_data_1 WHERE commentid='content_%s-%s-1'", $this->db->db_tablepre, $catid, join(',', $ids));
            $res = $this->db->query($sql);
            $comment = $this->db->fetch_array();
            if ($comment) {
                $return[$ids[0]]['comment_count'] = $comment[0]['count'];
            } else {
                $return[$ids[0]]['comment_count'] = 0;
            }
        }
//ddd($return);
        return $return;
    }

    /**
     * 相關文章標簽
     * @param $data
     */
    public function relation($data) {
        $catid = intval($data['catid']);
        $modelid = intval($data['modelid']);
        if (!$this->set_modelid($catid) && $modelid) {
            $this->db->set_model($modelid);
            $this->tablename = $this->db->table_name;
        } elseif (!$this->set_modelid($catid)) {
            return false;
        }
        $order = $data['order'];
        $time_start = time() - 3600 * 24 * 30 * 3;
        $sql = "`status`=99 AND `inputtime`>{$time_start}";
        if ($data['relation']) {
            $limit = $data['id'] ? $data['limit'] + 1 : $data['limit'];
            $relations = explode('|', trim($data['relation'], '|'));
            $relations = array_diff($relations, array(null));
            $relations = implode(',', $relations);
            $sql = " `id` IN ($relations)";
            $key_array = $this->db->select($sql, '*', $limit, $order, '', 'id');
        } elseif ($data['keywords']) {
            $limit = $data['limit'];
            if (is_string($data['keywords'])) {
                $keywords = str_replace('%', '', $data['keywords']);
                $keywords_arr = explode(',', $keywords);

                $key_array = array();
                $number = 0;
                $i = 1;
                foreach ($keywords_arr as $_k) {
                    $_k = addslashes($_k);
                    $sql2 = $sql . " AND `keywords` LIKE '%$_k%'" . (isset($data['id']) && intval($data['id']) ? " AND `id` != '" . abs(intval($data['id'])) . "'" : '');
                    $r = $this->db->select($sql2, '*', $limit, '', '', 'id');
                    $number += count($r);
                    foreach ($r as $id => $v) {
                        if ($i <= $limit && !in_array($id, $key_array))
                            $key_array[$id] = $v;
                        $i++;
                    }
                    if ($limit < $number)
                        break;
                }
            } elseif (is_array($data['keywords'])) {
                $keywords_arr = $data['keywords'];

                $key_array = array();
                foreach ($keywords_arr as $key => $_k) {
                    $_k = addslashes($_k);
                    $sql2 = $sql . " AND `keywords` LIKE '%$_k%'" . (isset($data['id']) && intval($data['id']) ? " AND `id` != '" . abs(intval($data['id'])) . "'" : '');
                    $r = $this->db->select($sql2, '*', $limit, '', '', 'id');

                    foreach ($r as $id => $v) {
                        if (!in_array($id, $key_array)) {
                            $key_array[$id] = $v;
                        }
                    }
                }
                if ((!isset($data['fullnum']) || $data['fullnum'] != 1) && count($key_array) > $limit) {
                    $key_array = keyword_arr($key_array, 0, $limit);
                }
            }
        }
        if ($data['id'])
            unset($key_array[$data['id']]);
        return $key_array;
    }

    /**
     * 排行榜標簽
     * @param $data
     * order規則：dayviews,weekviews,monthviews,views
     */
    public function hits($data) {
        $catid = intval($data['catid']);
        if (!$this->set_modelid($catid))
            return false;

        $this->hits_db = pc_base::load_model('hits_model');
        $desc = $ids = '';
        $array = $ids_array = array();
        $order = $data['order'];
        $hitsid = 'c-' . $this->modelid . '-%';
        $sql .= "hitsid LIKE '$hitsid'";

        if (isset($data['day'])) {
            $inputtime = SYS_TIME - intval($data['day']) * 86400;
            $sql .= " AND inputtime>'$inputtime'";
        }
        if (strpos($data['catid'], ',')) {
            $catids_str = addslashes(trim($data['catid']));
            $sql .= "AND catid IN ($catids_str)" . $thumb;
        } elseif ($this->category[$catid]['child']) {
            $catids_str = $this->category[$catid]['arrchildid'];
            $pos = strpos($catids_str, ',') + 1;
            $catids_str = substr($catids_str, $pos);
            $sql .= " AND catid IN ($catids_str)";
        } else {
            $sql .= " AND catid='$catid'";
        }
        $hits = array();
        $result = $this->hits_db->select($sql, '*', $data['limit'] * 3, $order);
        foreach ($result as $r) {
            $pos = strpos($r['hitsid'], '-', 2) + 1;
            $ids_array[] = $id = substr($r['hitsid'], $pos);
            $hits[$id] = $r;
        }
        $ids = implode(',', $ids_array);
        if ($ids) {
            $sql = "status=99 AND id IN ($ids)";
        } else {
            $sql = '';
        }
        $this->db->table_name = $this->tablename;
        $result = $this->db->select($sql, '*', $data['limit'], '', '', 'id');
        foreach ($ids_array as $id) {
            if ($result[$id]['title'] != '') {
                $array[$id] = $result[$id];
                $array[$id] = array_merge($array[$id], $hits[$id]);
            }
        }
        return $array;
    }

    /**
     * 欄目標簽
     * @param $data
     */
    public function category($data) {
        $data['catid'] = intval($data['catid']);
        $array = array();
        $siteid = $data['siteid'] && intval($data['siteid']) ? intval($data['siteid']) : get_siteid();
        $categorys = getcache('category_content_' . $siteid, 'commons');
        $site = siteinfo($siteid);
        $i = 1;
        foreach ($categorys as $catid => $cat) {
            if ($i > $data['limit'])
                break;
            if ((!$cat['ismenu']) || $siteid && $cat['siteid'] != $siteid)
                continue;
            if (strpos($cat['url'], '://') === false) {
                $cat['url'] = substr($site['domain'], 0, -1) . $cat['url'];
            }
            if ($cat['parentid'] == $data['catid']) {
                $array[$catid] = $cat;
                $i++;
            }
        }
        return $array;
    }

    /**
     * 推薦位
     * @param $data
     */
    public function position($data) {
        $sql = '';
        $array = array();
        $posid = intval($data['posid']);
        $order = $data['order'];
        $thumb = (empty($data['thumb']) || intval($data['thumb']) == 0) ? 0 : 1;
        $siteid = $GLOBALS['siteid'] ? $GLOBALS['siteid'] : 1;
        $catid = (empty($data['catid']) || $data['catid'] == 0) ? '' : intval($data['catid']);
        if ($catid) {
            $siteids = getcache('category_content', 'commons');
            if (!$siteids[$catid])
                return false;
            $siteid = $siteids[$catid];
            $this->category = getcache('category_content_' . $siteid, 'commons');
        }
        if ($catid && $this->category[$catid]['child']) {
            $catids_str = $this->category[$catid]['arrchildid'];
            $pos = strpos($catids_str, ',') + 1;
            $catids_str = substr($catids_str, $pos);
            $sql = "`catid` IN ($catids_str) AND ";
        } elseif ($catid && !$this->category[$catid]['child']) {
            $sql = "`catid` = '$catid' AND ";
        }
        if ($thumb)
            $sql .= "`thumb` = '1' AND ";
        if (isset($data['where']))
            $sql .= $data['where'] . ' AND ';
        if (isset($data['expiration']) && $data['expiration'] == 1)
            $sql .= '(`expiration` >= \'' . SYS_TIME . '\' OR `expiration` = \'0\' ) AND ';
        if (!empty($data['limitd']))
            $data['limit'] = $data['limitd'];
        $sql .= "`posid` = '$posid' AND `siteid` = '" . $siteid . "' AND `inputtime` < '" . time() . "'";
        $pos_arr = $this->position->select($sql, '*', $data['limit'], $order);
        if (!empty($pos_arr)) {
            foreach ($pos_arr as $info) {
                $key = $info['catid'] . '-' . $info['id'];
                $array[$key] = string2array($info['data']);
                $array[$key]['url'] = go($info['catid'], $info['id']);
                $array[$key]['id'] = $info['id'];
                $array[$key]['catid'] = $info['catid'];
                $array[$key]['listorder'] = $info['listorder'];
            }
        }
        return $array;
    }

    /**
     * 排行榜標簽
     * @param $data[catid]
     * @param $data[desc]
     * @param $data[num]
     * @param $data[limit]
     * @param array $data
     */
    public function ranking($data) {
        $catid = intval($data['catid']);
        if (!$this->set_modelid($catid))
            return false;

        $this->hits_db = pc_base::load_model('hits_model');
        $sql = $desc = $ids = '';
        $array = $ids_array = array();

        if (strpos($data['catid'], ',')) {
            $catids_str = addslashes(trim($data['catid']));
            $sql .= " catid IN ($catids_str)" . $thumb;
        } elseif ($this->category[$catid]['child']) {
            $catids_str = $this->category[$catid]['arrchildid'];
            $pos = strpos($catids_str, ',') + 1;
            $catids_str = substr($catids_str, $pos);
            $sql .= " catid IN ($catids_str)";
        } else {
            $sql .= " catid='$catid'";
        }

        if (isset($data['desc'])) {
            $desc = trim($data['desc']);
            if ($desc == 'day') {
                $updatetime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $sql .= " AND updatetime>'$updatetime' ORDER BY dayviews DESC";
            } elseif ($desc == 'week') {
                $updatetime = SYS_TIME - 7 * 86400;
                if (strpos($_SERVER['HTTP_HOST'], 'zc.test') === 0) {
                    $sql .= " ORDER BY weekviews DESC";
                } else {
                    $sql .= " AND updatetime>'$updatetime' ORDER BY weekviews DESC";
                }
            } else {
                $updatetime = SYS_TIME - 30 * 86400;
                if (strpos($_SERVER['HTTP_HOST'], 'zc.test') === 0) {
                    $sql .= " ORDER BY monthviews DESC";
                } else {
                    $sql .= " AND updatetime>'$updatetime' ORDER BY monthviews DESC";
                }
            }
        } else {
            $sql .= " ORDER BY views DESC";
        }

        $apc_cache = function_exists('apc_fetch');
        $cache_key = 'content_tag-ranking-' . implode('-', $data);
        if ($apc_cache) {
            if ($ret = apc_fetch($cache_key)) {
                return $ret;
            }
        }

        $hits = array();
        $result = $this->hits_db->select($sql, '*', $data['limit'], $order);
        foreach ($result as $r) {
            $pos = strpos($r['hitsid'], '-', 2) + 1;
            $ids_array[] = $id = substr($r['hitsid'], $pos);
            $hits[$id] = $r;
        }
        $ids = implode(',', $ids_array);
        if ($ids) {
            $sql = "status=99 AND id IN ($ids)";
            $this->db->table_name = $this->tablename;
            $result = $this->db->select($sql, '*', $data['limit'], '', '', 'id');
            foreach ($ids_array as $id) {
                if ($result[$id]['title'] != '') {
                    $array[$id] = $result[$id];
                    $array[$id] = array_merge($array[$id], $hits[$id]);
                }
            }

// 查詢遊戲標簽
            if (in_array($catid, array(20, 134))) {
                $sql = sprintf("SELECT tag_id, content_id, tag_name, parent_id FROM %slinktag t INNER JOIN %slinktag_to_content lt ON t.tag_id = lt.linktag_id WHERE catid = %d AND content_id IN (%s)", $this->db->db_tablepre, $this->db->db_tablepre, $catid, $ids);
                $res = $this->db->query($sql);
                $tags = $this->db->fetch_array();
                if ($tags) {
                    foreach ($tags as $tagrow) {
                        $array[$tagrow['content_id']]['tags'][$tagrow['parent_id']] = array('id' => $tagrow['tag_id'], 'tag' => $tagrow['tag_name']);
                        $array[$tagrow['content_id']]['alltags'][] = array('id' => $tagrow['tag_id'], 'tag' => $tagrow['tag_name']);
                    }
                }
            }

//調用副表的數據
            if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {
                $ids = array();
                foreach ($array as $v) {
                    if (isset($v['id']) && !empty($v['id'])) {
                        $ids[] = $v['id'];
                    } else {
                        continue;
                    }
                }
                if (!empty($ids)) {
                    $this->db->table_name = $this->db->table_name . '_data';
                    $ids = implode('\',\'', $ids);
                    $r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
                    if (!empty($r)) {
                        foreach ($r as $k => $v) {
                            if (isset($array[$k]))
                                $array[$k] = array_merge($v, $array[$k]);
                        }
                    }
                }
            }
        } else {
            $array = array();
        }
        if ($apc_cache) {
            apc_add($cache_key, $array, 86400);
        }
        return $array;
    }

    /**
     * 隨機欄目下文章
     * @author Jozh liu
     */
    public function recommend($data) {
        $catid = intval($data['catid']);
        $id = intval($data['id']);
        $limit = intval($data['limit']) ? intval($data['limit']) : 8;
        $array = array();

        $sql = 'SELECT * 
                FROM www_picture AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM www_picture)-(SELECT MIN(id) FROM www_picture))+
                (SELECT MIN(id) FROM www_picture)) AS id) AS t2 
                WHERE t1.id >= t2.id 
                AND catid = ' . $catid . '
                ORDER BY t1.id
                LIMIT ' . $limit;
        $result = $this->db->query($sql);
        $_k = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $array[$_k] = $row;
            $_k++;
        }

        return $array;
    }

    /**
     * 點贊數據
     */
    public function select_com($data) {
        $cid = trim($data['contentid']);
        $catid = trim($data['catid']);
        $mood_db = pc_base::load_model('mood_model');
        $array = $mood_db->get_one(array("catid" => $catid, "contentid" => $cid), "n5,n7");

        return $array;
    }

    /**
     * 發號列表請求標簽
     */
    public function hao_list($data) {
        $sendData = array(
            'appkey' => 10005,
            'offset' => 1,
            'limit' => 6,
            'expire' => time() + 600
        );
        $sign = getsign($sendData, '59d37a2a4d60a22a4d673a00b1a14236');
        $other = http_build_query($sendData);
        $api = "http://fahao.mofang.com.tw/api/v1/gift/list?&sign=" . $sign . "&" . $other;
        $return = json_decode(mf_curl_get($api), true);
        $arr = array();
        $arr1 = array();
//$return = array_flip($return['data']);
        foreach ($return['data'] as $key => $value) {
            if (isset($value['icon'])) {
                $value['game_icon'] = $value['icon'];
                unset($value['icon']);
            }
            $arr[] = $value;
        }
        $arr1['data'] = $arr;
        return $arr1['data'];
    }

    /**
     * 可視化標簽
     */
    public function pc_tag() {
        $positionlist = getcache('position', 'commons');
        $sites = pc_base::load_app_class('sites', 'admin');
        $sitelist = $sites->pc_tag_list();

        foreach ($positionlist as $_v)
            if ($_v['siteid'] == get_siteid() || $_v['siteid'] == 0)
                $poslist[$_v['posid']] = $_v['name'];
        return array(
            'action' => array('lists' => L('list', '', 'content'), 'position' => L('position', '', 'content'), 'category' => L('subcat', '', 'content'), 'relation' => L('related_articles', '', 'content'), 'hits' => L('top', '', 'content')),
            'lists' => array(
                'catid' => array('name' => L('catid', '', 'content'), 'htmltype' => 'input_select_category', 'data' => array('type' => 0), 'validator' => array('min' => 1)),
                'order' => array('name' => L('sort', '', 'content'), 'htmltype' => 'select', 'data' => array('id DESC' => L('id_desc', '', 'content'), 'updatetime DESC' => L('updatetime_desc', '', 'content'), 'listorder ASC' => L('listorder_asc', '', 'content'))),
                'thumb' => array('name' => L('thumb', '', 'content'), 'htmltype' => 'radio', 'data' => array('0' => L('all_list', '', 'content'), '1' => L('thumb_list', '', 'content'))),
                'moreinfo' => array('name' => L('moreinfo', '', 'content'), 'htmltype' => 'radio', 'data' => array('1' => L('yes'), '0' => L('no')))
            ),
            'position' => array(
                'posid' => array('name' => L('posid', '', 'content'), 'htmltype' => 'input_select', 'data' => $poslist, 'validator' => array('min' => 1)),
                'catid' => array('name' => L('catid', '', 'content'), 'htmltype' => 'input_select_category', 'data' => array('type' => 0), 'validator' => array('min' => 0)),
                'thumb' => array('name' => L('thumb', '', 'content'), 'htmltype' => 'radio', 'data' => array('0' => L('all_list', '', 'content'), '1' => L('thumb_list', '', 'content'))),
                'order' => array('name' => L('sort', '', 'content'), 'htmltype' => 'select', 'data' => array('listorder DESC' => L('listorder_desc', '', 'content'), 'listorder ASC' => L('listorder_asc', '', 'content'), 'id DESC' => L('id_desc', '', 'content'))),
            ),
            'category' => array(
                'siteid' => array('name' => L('siteid'), 'htmltype' => 'input_select', 'data' => $sitelist),
                'catid' => array('name' => L('catid', '', 'content'), 'htmltype' => 'input_select_category', 'data' => array('type' => 0))
            ),
            'relation' => array(
                'catid' => array('name' => L('catid', '', 'content'), 'htmltype' => 'input_select_category', 'data' => array('type' => 0), 'validator' => array('min' => 1)),
                'order' => array('name' => L('sort', '', 'content'), 'htmltype' => 'select', 'data' => array('id DESC' => L('id_desc', '', 'content'), 'updatetime DESC' => L('updatetime_desc', '', 'content'), 'listorder ASC' => L('listorder_asc', '', 'content'))),
                'relation' => array('name' => L('relevant_articles_id', '', 'content'), 'htmltype' => 'input'),
                'keywords' => array('name' => L('key_word', '', 'content'), 'htmltype' => 'input')
            ),
            'hits' => array(
                'catid' => array('name' => L('catid', '', 'content'), 'htmltype' => 'input_select_category', 'data' => array('type' => 0), 'validator' => array('min' => 1)),
                'day' => array('name' => L('day_select', '', 'content'), 'htmltype' => 'input', 'data' => array('type' => 0)),
            ),
        );
    }

    /**
     * 按表態排序查詢文章及綁定遊戲
     * @author jozh liu
     */
    public function moods($data) {
        $catid = intval($data['catid']);
        if (!$this->set_modelid($catid))
            return false;

        $sql = sprintf("SELECT total,contentid as count FROM %smood WHERE catid=%s ORDER BY %s limit %s", $this->db->db_tablepre, $catid, '`total` DESC', $data['limit']);
        $res = $this->db->query($sql);
        $mood = $this->db->fetch_array();
        foreach ($mood as $k => $v) {
            $moods[$v['count']] = $v;
            $ids_array[$k] = $v['count'];
        }
        $ids = implode(',', $ids_array);
        if ($ids) {
            $sql = "status=99 AND id IN ($ids)";
            $this->db->table_name = $this->tablename;
            $r = $this->db->select($sql, '*', $data['limit'], '', '', 'id');
            foreach ($ids_array as $id) {
                if ($r[$id]['title'] != '') {
                    $array[$id] = $r[$id];
                }
            }
        } else {
            $array = array();
        }
        $return = $this->gameinfo_pingce($array);

        return $return;
    }

    /**
     * 遊戲信息查詢，針對評測
     * @author jozh liu
     */
    public function gameinfo_pingce($return) {

//調取遊戲數據
        $gameinfos = array();
        $num = 0;
        foreach ($return as $k => $v) {
            $num ++;
            $model_gameid = trim($v['gameid'], '|');
            $infos = explode('-', $model_gameid);
            $infos['modelid'] = $infos[0];
            $infos['id'] = $infos[1];
            $infos['limit'] = 1;

            if (isset($infos[1])) {//是否存在gameid
                $result = $this->iosgame_lists($infos);

                foreach ($result as $val) {
                    $v['game_title'] = $val['title'];
                    $v['game_icon'] = $val['icon'];
                    $v['game_author_name'] = $val['author_name'];
                    $v['game_filesize'] = $val['filesize'];
                    $v['game_brief'] = $val['brief'];
                    $v['game_url'] = $val['url'];
                    if (isset($data['gameinfo']) && intval($data['gameinfo']) == 1) {
                        $v['comment_num'] = get_comments(id_encode("content_" . $val['catid'], $val['id'], $siteid));
                    }
                }
            }

            $return[$k] = $v;
        }

        return $return;
    }

    /**
     * 攻略助手總數
     * @author jozh liu
     */
    public function mf_app_sum($data) {
        $this->set_modelid(277);

        if ($this->category[277]['child']) {
            $catids_str = $this->category[277]['arrchildid'];
            $pos = strpos($catids_str, ',') + 1;
            $catids_str = substr($catids_str, $pos);
            $sql = "status=99 AND catid IN ($catids_str)";
        } else {
            $sql = "status=99 AND catid=277";
        }

        $content_total = count($this->db->select($sql));
        $ids_arr = $this->db->select($sql, 'id');

//調用副表的數據
        foreach ($ids_arr as $v) {
            if (isset($v['id']) && !empty($v['id'])) {
                $ids[] = $v['id'];
            } else {
                continue;
            }
        }
        if (!empty($ids)) {
            $this->db->table_name = $this->db->table_name . '_data';
            $ids = implode('\',\'', $ids);
            $r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
            if (!empty($r)) {
                foreach ($r as $k => $v) {
                    if (strlen($v['iospackage']) > 21) {
                        $iospackages[$k] = $v['iospackage'];
                    }
                    if (strlen($v['andpackage']) > 21) {
                        $andpackages[$k] = $v['andpackage'];
                    }
                }
            }
        }
        $return['ios'] = count($iospackages);
        $return['and'] = count($andpackages);

        return $return;
    }

    /**
     * 獲取遊戲詳細信息
     * */
    public function get_game_info($data) {
        $gameid = intval($data['gameid']);
        $game_api = "http://game.mofang.com.tw/api/web/GetGameInfo?id=" . $gameid;
        $datas = mf_curl_get($game_api);
        $datas = json_decode($datas, true);
        $return = array();
        if ($datas['code'] == '0') {
            $return['id'] = $datas['data']['id'];
            $return['title'] = $datas['data']['name'];
            $return['comment'] = $datas['data']['comment'];
            $return['url'] = $datas['data']['url'];
            $return['icon'] = $datas['data']['icon'];
            $return['tags'] = $datas['data']['tags'];
            $return['version'] = $datas['data']['version'];
            $return['company'] = $datas['data']['company'];
//墨客派使用的字段
            $return['filesize'] = $datas['data']['version'][0]['fileSize']; //增加文件大小
            $return['language'] = '中文';
        }
        return $return;
    }

    /*
     * 按類型
     */

    public function type_lists($data) {
        $catid = intval($data['catid']);
        $typeid = intval($data['typeid']);
        $data['order'] = 'inputtime DESC';

        if (!$this->set_modelid($catid))
            return false;

        $array = array();
        if (!$catid) {
            return $array;
        } else {
            if (strpos($data['catid'], ',')) {
                $catids_str = addslashes(trim($data['catid']));
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            } elseif ($this->category[$catid]['child']) {
                $catids_str = $this->category[$catid]['arrchildid'];
                $pos = strpos($catids_str, ',') + 1;
                $catids_str = substr($catids_str, $pos);
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            } else {
                $sql = "status=99 AND catid='$catid'" . $thumb;
            }

            if ($typeid) {
                $sql .= " AND typeid='$typeid'";
            }
            $array = $this->db->select($sql, '*', $data['limit'], $data['order'], '', 'id');

//調用副表的數據
            if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {
                $ids = array();
                foreach ($array as $v) {
                    if (isset($v['id']) && !empty($v['id'])) {
                        $ids[] = $v['id'];
                    } else {
                        continue;
                    }
                }
                if (!empty($ids)) {
                    $this->db->table_name = $this->db->table_name . '_data';
                    $ids = implode('\',\'', $ids);
                    $r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
                    if (!empty($r)) {
                        foreach ($r as $k => $v) {
                            if (isset($array[$k])) {
                                $array[$k]['pic_sum'] = substr_count($v['pictureurls'], 'url');
                            }
                        }
                    }
                }
            }

// 統計數據查詢
            foreach ($array as $k => $v) {
                $statics_data = get_statics(array('catid' => $v['catid'], 'id' => $v['id'], 'type' => 'all'));
                foreach ($statics_data as $key => $val) {
                    $array[$k][$key] = $val;
                }
            }
            return $array;
        }
    }

    /**
     * 查詢分類列表
     */
    public function type($data) {
        $description = trim($data['description']);
        $typeid = intval($data['typeid']);
        $array = array();
        if (!$description) {
            return $array;
        } else {
            if (!$typeid) {
                $array = $this->type_db->select(array('description' => $description), '*', $data['limit']);
            } else {
                $array = $this->type_db->select(array('description' => $description, 'typeid' => $typeid), '*', $data['limit']);
            }
            return $array;
        }
    }

    /**
     * 推薦位新功能，可按catid,posid,typeid類別進行過濾
     * @param $data
     */
    public function position_new($data) {
        $data['num'] = $data['num'] ? $data['num'] : 10;
//獲取指定欄目，推薦位的數據
        $position_array = array();
        $position_array = $this->position->select(array("catid" => $data['catid'], "posid" => $data['posid']), 'id');
        $content_db = pc_base::load_model('content_model');
        $content_db->set_catid($data['catid']);
        $return = array();
        if (!empty($position_array)) {
            foreach ($position_array as $key => $value) {
//循環查詢屬於該類別的數據
                $array = $content_db->get_one(array("id" => $value['id']), '*', 'inputtime desc');
                if ($array['typeid'] == $data['typeid']) {
                    $return[] = $array;
                }
            }
        }
        return $return;
    }

    /**
     * 按catid,date日期從數據類別進行過濾
     * @param $data
     */
    public function lists_meiri($data) {

//獲取指定欄目，推薦位的數據 
        $content_db = pc_base::load_model('content_model');
        $content_db->set_catid($data['catid']);
        $return = array();
        $array = $content_db->get_one(array("catid" => $data['catid'], "hd_date" => $data['hd_date']), '*', 'inputtime desc');
        $return[] = $array;
        return $return;
    }

    /**
     * 列表頁標簽 (主要為取是否關聯新庫遊戲使用 - 官慶)
     * @param $data
     */
    public function lists_new($data) {
        $catid = intval($data['catid']);
        $field = $data['field'] ? : '*';
        if (!$this->set_modelid($catid))
            return false;
        if (isset($data['top']) && $data['top'] = "grade") {
            $sql = "select `video`.id,`video`.catid,`video`.url,`video`.grade,`video_d`.relation_game from www_review as video,www_review_data as video_d where `video`.id = `video_d`.id and `video_d`.relation_game!='' order by `video`.grade desc limit 0,5";
        } else {
            $sql = "select `video`.id,`video`.catid,`video`.url,`video`.grade,`video_d`.relation_game from www_review as video,www_review_data as video_d where `video`.id = `video_d`.id and `video_d`.relation_game!='' order by `video`.id desc limit 0,5";
        }
        $sql_return = $this->db->query($sql);
        $return = $this->db->fetch_array();
//調用遊戲數據
        if (isset($data['gameinfo']) && intval($data['gameinfo']) == 1) {

            $return = $this->gameinfo_pingce_new($return);
        }
// print_r($return);exit;
// if($data['comment_order']){
// 	$new = array();
// 	foreach($return as $key=>$val){
// 		$total = get_comments(id_encode('content_'.$val['catid'],$val['id'],1));
// 		$val['total']=$total;
// 		$new[]=$val;
// 	}
// 	unset($return);
// 	$return = arr_ksort($new,'total');
// 	$return = array_slice($return, 0, $data['comment_num']);
// }
//       if($data['total']){
//           $return['contents'] = $return;
//           $return['content_total'] = $content_total;
//       }
        return $return;
    }

    /**
     * 根據返回排序好的Id賦值數據
     * $param $ids array/string 
     * */
    public function from_ids_info($data) {
//ddd($data);
        $catid = intval($data['catid']);
        $field = $data['field'] ? : '*';

        if (is_array($data['ids'])) { // 將排序的好的newid 遍歷賦值
            $return = array();
            $rs1 = array();
            foreach ($data['ids'] as $k => $v) {
                $where = "catid = " . $data['catid'] . " and id = " . intval($v);
                $rs = $this->db->get_content($data['catid'], $v);
                $rs1['catid'] = $rs['catid'];
                $rs1['id'] = $rs['id'];
                $rs1['url'] = $rs['url'];
                $rs1['relation_game'] = $rs['relation_game'];
                $rs1['grade'] = $rs['grade'];

                $return[] = $rs1;
            }
        } else {
            $sql = "select `video`.id,`video`.catid,`video`.url,'video'.grade,`video_d`.relation_game from www_review as video,www_review_data as video_d where `video`.id = `video_d`.id and `video_d`.relation_game!='' order by `video`.id desc limit 0,5";
            $sql_return = $this->db->query($sql);
            $return = $this->db->fetch_array();
        }
//調用遊戲數據
        if (isset($data['gameinfo']) && intval($data['gameinfo']) == 1) {

            $return = $this->gameinfo_pingce_new($return);
        }
        return $return;
    }

    /**
     * 遊戲信息查詢，針對評測 （調新庫遊戲）
     * @author 王官慶
     */
    public function gameinfo_pingce_new($return) {
//調取遊戲數據
        $gameinfos = array();
        $num = 0;
        foreach ($return as $k => $v) {
            $num ++;
            $relation_game['gameid'] = trim($v['relation_game'], '|');
//獲取遊戲信息
            $val = $this->get_game_info($relation_game);
//ddd($val);
            $v = array();
            $return[$k]['game_title'] = $val['title'];
            $return[$k]['game_icon'] = $val['icon'];
            $return[$k]['game_comment'] = $val['comment'];
            $return[$k]['game_author_name'] = $val['author_name'];
            $return[$k]['game_filesize'] = $val['filesize'];
            $return[$k]['game_brief'] = $val['brief'];
            $return[$k]['game_url'] = $val['url'];
        }
        return $return;
    }

    /**
     * 內容頁最下方 - 熱門遊戲PC標簽
     * @author 王官慶
     */
    public function iosgame_lists_new($data) {
        $type = intval($data['type']);
        $number = intval($data['num']);
        if (!$type) {
            $type = 1;
        }
        if (!$number) {
            $number = 5;
        }
//調取遊戲數據
        $request_api = "http://game.mofang.com.tw/api/web/GetGameByType?type=" . $type . "&limit=" . $number;
        $datas = mf_curl_get($request_api);
        $datas = json_decode($datas, true);
        $return = $datas['data'];
        return $return;
    }

    /**
     * 列表頁標簽
     * @param $data
     */
    public function user_lists($data) {

        $catid = intval($data['catid']);
        $field = $data['field'] ? : '*';
        $outhorname = $data['outhorname'] ? : '';
        if (!$this->set_modelid($catid))
            return false;
        if (isset($data['where'])) {
            $sql = $data['where'];
        } else {
            $thumb = intval($data['thumb']) ? " AND thumb != ''" : '';
            if (strpos($data['catid'], ',')) {
                $catids_str = addslashes(trim($data['catid']));
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            } elseif ($this->category[$catid]['child']) {
                $catids_str = $this->category[$catid]['arrchildid'];
                $pos = strpos($catids_str, ',') + 1;
                $catids_str = substr($catids_str, $pos);
                $sql = "status=99 AND catid IN ($catids_str)" . $thumb;
            } else {
                $sql = "status=99 AND catid='$catid'" . $thumb;
            }
            if (!empty($outhorname)) {
                $sql .= " AND `outhorname` = '$outhorname'";
            }
        }
        $order = $data['order'];
        if (!empty($data['limitd']))
            $data['limit'] = $data['limitd'];

        $siteids = getcache('category_content', 'commons');
        $siteid = $siteids[$catid];

        $return = $this->db->select($sql, $field, $data['limit'], $order, '', 'id');
//調用遊戲數據
        if (isset($data['gameinfo']) && intval($data['gameinfo']) == 1) {
            $return = $this->gameinfo_pingce($return);
        }
//調用副表的數據
        if (isset($data['moreinfo']) && intval($data['moreinfo']) == 1) {
            $ids = array();
            foreach ($return as $v) {
                if (isset($v['id']) && !empty($v['id'])) {
                    $ids[] = $v['id'];
                } else {
                    continue;
                }
            }
            if (!empty($ids)) {
                $this->db->table_name = $this->db->table_name . '_data';
                $ids = implode('\',\'', $ids);
                $r = $this->db->select("`id` IN ('$ids')", '*', '', '', '', 'id');
                if (!empty($r)) {
                    foreach ($r as $k => $v) {
                        if (isset($return[$k]))
                            $return[$k] = array_merge($v, $return[$k]);
                    }
                }
            }
        }
        if ($data['comment_order']) {
            $new = array();
            foreach ($return as $key => $val) {
                $total = get_comments(id_encode('content_' . $val['catid'], $val['id'], 1));
                $val['total'] = $total;
                $new[] = $val;
            }
            unset($return);
            $return = arr_ksort($new, 'total');
            $return = array_slice($return, 0, $data['comment_num']);
        }

        return $return;
    }

    /**
     * 遊戲中心最新遊戲讀取
     * @param $data 請求參數
     * limit int 請求禮包數量 默認10
     */
    public function lasest_games($data) {

        $data['limit'] = $data['limit']? : 10;

        $url = $this->lasest_games_url . http_build_query($data);
        $return = mf_curl_get($url);
        $result = json_decode($return, true);
        $data = array();
        if ($result['code'] == 0 && !empty($result['data'])) {
            $data = $result['data'];
        }

        return $data;
    }

    /**
     * 發號中心推薦禮包讀取
     * @param $data 請求參數
     * limit int 請求禮包數量 默認10
     */
    public function recommends($data) {
        $data['appkey'] = $this->appkey;
        $data['limit'] = $data['limit']? : 10;
        $data['expire'] = $data['expire']? : 9999999999;
        $data['sign'] = $this->getSign($data);

        $url = $this->recommend_url . http_build_query($data);
        $return = mf_curl_get($url);
        $result = json_decode($return, true);
        $data = array();
        if ($result['code'] == 0 && !empty($result['data'])) {
            $data = $result['data'];
        }
        return $data;
    }

    /**
     * 屈龍提供的PAI認證獲取
     * @param $data array ,
     * @return strting 加密認證
     * */
    function getSign($data) {
        ksort($data);
        $s_tmp = '';
        foreach ($data as $k => $v) {
            $s_tmp.=$k . '=' . $v;
        }
        return md5($s_tmp . $this->secret);
    }

    /**
     * 获取游戏排行榜前三天top20的历史数据
     * by maxinliang 20150502
     */
    private function _getGameRankingHistory($last_date) {
        $three_date = date('Y-m-d', strtotime($last_date) - 3 * 24 * 3600);

        $where = "last_date < '" . $last_date . "' AND last_date >= '" . $three_date . "'";
        $fields = "`name`";
        $three_list = $this->ranking_history->select($where, $fields);

        return count($three_list) > 0 ? $three_list : array();
    }

    /**
     * 首页游戏排行榜打new标签
     * by maxinliang 20150502
     */
    private function _setGameRankingTag($game_list, $last_date) {
        $three_list = $this->_getGameRankingHistory($last_date);
        if (!$three_list)
            return $game_list;

//获取前三天的游戏名列表
        $game_name_list = array();
        foreach ($three_list as $i => $item) {
            $game_name_list[$i] = $item['name'];
        }
        $game_name_list = array_unique($game_name_list);

//为游戏打new标签
        foreach ($game_list as $i => $game) {
            $game_list[$i]['is_new'] = false;
            if (!in_array($game['name'], $game_name_list)) {
                $game_list[$i]['is_new'] = true;
            }
        }

        return $game_list;
    }

    /**
     * 将游戏排行榜结果写入历史表
     * by maxinliang 20150502
     */
    private function _addGameRankingData($game_list, $last_date) {
//检测last_date的记录是否存在
        $counts = $this->ranking_history->count("last_date = '" . $last_date . "'");
        if ($counts >= 20)
            return false;

        foreach ($game_list as $i => $item) {
            $data = array();
            $data['name'] = $item['name'];
            $data['order'] = $i + 1;
            $data['last_date'] = $last_date;

            $this->ranking_history->insert($data);
        }

        return true;
    }

    /**
     * 主站首页游戏排行榜
     * by maxinliang 20150422
     */
    function getGameRanking($data) {
//获取最新的last_date
        $records = $this->game_ranking->select("", "last_date", "1", "last_date DESC");
        if (!$records[0]['last_date']) {
            return array();
        }
        $last_date = trim($records[0]['last_date']);
//判断数据是否够20条
        $count = $this->game_ranking->count("last_date = '" . $last_date . "'");
        if (!$count || $count < 20)
            return array();

//获取游戏排行榜数据
        $list = array();

        $sql = "SELECT name, strategy_url, score FROM " . $this->game_ranking->table_name . " WHERE last_date = '" . $last_date . "' ORDER BY score DESC LIMIT " . $data['limit'];
        $query = $this->game_ranking->query($sql);
        while ($row = mysql_fetch_assoc($query)) {
            $list[] = $row;
        }
        if ($list) {
            $list = $this->_setGameRankingTag($list, $last_date);
            $this->_addGameRankingData($list, $last_date);
        }

        return $list;
    }

    /**
     * 检测排行榜升降
     * by maxinliang 20150503
     */
    private function _checkGameRankingOrder($game_list, $last_game_list) {
        $game_order = array();
        $last_game_order = array();

        foreach ($game_list as $i => $item) {
            $game_order[$item['name']]['order'] = $i + 1;
            $game_order[$item['name']]['ud'] = 0;
        }
        foreach ($last_game_list as $i => $item) {
            $last_game_order[$item['name']]['order'] = $i + 1;
        }

//判断升降
        foreach ($game_order as $name => $order) {
            if ($last_game_order[$name]) {
                $game_order[$name]['ud'] = $last_game_order[$name]['order'] - $order['order'];
            } else {
//10000代表新增
                $game_order[$name]['ud'] = 10000;
            }
        }

//返回升降信息 
        foreach ($game_list as $i => $item) {
            $game_list[$i]['ud'] = $game_order[$item['name']]['ud'];
        }

        return $game_list;
    }

    /**
     * 游戏排行榜更多
     * by maxinliang 20150503
     */
    public function getGameRankingMore($data) {
//获取昨天、前天两个last_date
        $records = $this->game_ranking->select("", "last_date", "1", "last_date DESC");
        if (count($records) <= 0) {
            return array();
        }
        $records[1]['last_date'] = date('Y-m-d', strtotime($records[0]['last_date']) - 24 * 3600);

//获取昨天、前天的游戏排行榜
        $list = array();

        $fields = "name, strategy_url, score";
        $order = "score DESC";
        $limit = 50;
        foreach ($records as $i => $record) {
            $list[$i] = $this->game_ranking->select("last_date = '" . $record['last_date'] . "'", $fields, $limit, $order);
        }
        if ($list[1]) {
//进行排名升降处理(保证list[0]、list[1]数量一致?)
            $list[0] = $this->_checkGameRankingOrder($list[0], $list[1]);
        }

        return $list[0];
    }

    /**
     * 發號中心推薦禮包讀取
     * @param $data 請求參數
     * limit int 請求禮包數量 默認10
     */
    public function fahao($data) {
        $data['appkey'] = $this->appkey;
        $data['limit'] = $data['limit']? : 10;
        $data['expire'] = $data['expire']? : time() + 600;
        $data['sign'] = $this->getSign($data);

        $url = $this->recommend_url . http_build_query($data);
        $return = mf_curl_get($url);
        $result = json_decode($return, true);
        $data = array();
        if ($result['code'] == 0 && !empty($result['data'])) {
            $data = $result['data'];
        }
        return $data;
    }

    /** by Sbencer
     * 取得ios最新熱門排行 
     * 
     */
    public function get_top_ios() {

        $ios_top_js =  CRON_PATH. "top_ios.js";
				$json_str =  json_decode(file_get_contents ($ios_top_js));
      		$ary = array();
					foreach($json_str as $val)
					{
						 array_push($ary, array('img_url' => $val->img_url, 'url' => $val->url, 'img_alt' => $val->img_alt));
					}
        
        return $ary;
    }

    /** by Sbencer
     * 取得andriod最新熱門排行 
     * 
     */
    public function get_top_andriod() {
				$andriod_top_js =  CRON_PATH. "top_andriod.js";
				$json_str =  json_decode(file_get_contents ($andriod_top_js));
      		$ary = array();
					foreach($json_str as $val)
					{
						 array_push($ary, array('img_url' => $val->img_url, 'url' => $val->url, 'img_alt' => $val->img_alt));
					}
        return $ary;
    }
    
    /** by Sbencer
     * 取得該tag的文章 
     * 
     */
		public function relation_tag($data){
				
				
				$order = $data['order'];
        if (!empty($data['limitd']))
            $data['limit'] = $data['limitd'];
			
			//還要過濾不含自已
				$sql = "status=99 AND id <> '" . $data['nid'] . "' AND tag = " . $data['tag'];
				$field = $data['field'] ? : '*';
				$order = $data['order'];
        $return = $this->db->select($sql, $field, $data['limit'], $order, '', 'id');
        return $return;
			
		}

}



