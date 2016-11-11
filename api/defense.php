<?php

/**
 * 塔防迷 接口
 * star time: 2013-10-17
 *
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$games = new defense;
// $games->get_tags();
$action = !empty($_GET['a'])?$_GET['a']:'init'; 
// $games->game_list($query_tags);
// $games->game_info(1244);
// $games->init();
$games->$action($_GET);

class defense {

    function __construct() {
        $this->db = pc_base::load_model('content_model');
        if ($_SERVER['HTTP_HOST'] == 'a.mofang.com') {
            $this->modelid = 21;
            $this->catid = 134;
        } else {
            $this->modelid = 20;
            $this->catid = 20;
        }
        $MODEL = getcache('model','commons');
        $this->db->table_name = $this->db->db_tablepre.$MODEL[$this->modelid]['tablename'];
        $this->tag_db = clone $this->db;
        $this->tag_db->table_name = $this->db->db_tablepre.'linktag_to_content';
        // var_dump($this->tag_db);
    }

    /**
     * 塔防迷無請求報錯
     */
    function init() {
        $info['error'] = true;
        $info['message'] = 'NO ACTION REQUEST';

        echo json_encode($info);
    }

    /**
     * 塔防迷首頁banner鏈接
     */
    function banner() {
        // echo 'banner';
        $this->db->table_name = $this->db->db_tablepre.'links';
        $banner = $this->db->select(array('catid'=>'694'),"title,thumb,url",3,"inputtime desc");
        foreach ($banner as $key => $value) {
            preg_match('/gameinfo\/(\d+).html/i', $value['url'], $match);
            if ($match[1]) {
                $banner[$key]['gameid'] = $match[1];
            } else {
                $banner[$key]['gameid'] = '';
            }
        }
        if(empty($banner)){
            $info['error'] = true;
            $info['message'] = 'No query results';
            echo json_encode($info);
            return;
        } else {
            $info['error'] = false;
            $info['message'] = $banner;
            echo json_encode($info);
            return;
        }
        
    }

    /**
     * 新聞列表
     * @param $data
     */
    public function news_list($data) {
        // echo 'news_list';

        $game_id = intval($data['id']);
        if ($this->modelid == 21) {
            $catids = '101,474';
        } else {
            $catids = '81,474';
        }
        $list = $this->relation($game_id,$catids);
        $page = intval($data['page']);
        if(empty($page)) {
            $page = 1;
        }
        $limit = 10;
        $start = ($page-1)*$limit;
        if($start < 0 ) $start = 0;
        $return = array_slice($list,$start,10);

        if(empty($return)){
            $info['error'] = true;
            $info['message'] = 'No query results';
            echo json_encode($info);
            return;
        } else {
            $info['error'] = false;
            $info['message'] = $return;
            // var_dump($info);
            echo json_encode($info);
            return;
        }
    }

    
    /**
     * 評測列表
     * @param $data
     */
    public function comment_list($data) {
        // echo 'comment_list';

        $game_id = intval($data['id']);
        if ($this->modelid == 21) {
            $catids = '102,473';
        } else {
            $catids = '82,473';
        }
        $list = $this->relation($game_id,$catids);

        $page = intval($data['page']);
        if(empty($page)) {
            $page = 1;
        }
        $limit = 10;
        $start = ($page-1)*$limit;
        if($start < 0 ) $start = 0;
        $return = array_slice($list,$start,10);

        if(empty($return)){
            $info['error'] = true;
            $info['message'] = 'No query results';
            echo json_encode($info);
            return;
        } else {
            $info['error'] = false;
            $info['message'] = $return;
            // var_dump($info);
            echo json_encode($info);
            return;
        }
    }

    /**
     * 塔防迷內容頁content鏈接
     * @param $data
     */
    function content($data) {
        $catid = intval($data['catid']);
        $id = intval($data['id']);
        if(empty($catid) || empty($id)) {
            $info['error'] = true;
            $info['message'] = 'Parameter is not complete';
            echo json_encode($info);
            return;
        }
        // 先查詢文章表中內容
        // $this->db->query("SELECT 'news' type,title,username,inputtime,outhorname,shortname,username,content,copyfrom FROM www_news n LEFT JOIN www_news_data d ON n.id=d.id WHERE catid={$catid} AND n.id={$id}");
        $this->db->query("SELECT 'news' type,url FROM www_news");
        $result = $this->db->fetch_array();
        // 文章表沒有數據再從視頻中查找
        if(empty($result)){
            // $this->db->query("SELECT 'video' type,title,youkuid,username,inputtime, '魔方網' outhorname,shortname,username, description content FROM www_video n LEFT JOIN www_video_data d ON n.id=d.id WHERE catid={$catid} AND n.id={$id}");
            $this->db->query("SELECT 'video' type,url FROM www_video");
            $result = $this->db->fetch_array();
        }
        // 如果沒有結果，返回錯誤信息,有結果返回結果
        if(empty($result)){
            $info['error'] = true;
            $info['message'] = 'No query results';
            echo json_encode($info);
            return;
        } else {
            $info['error'] = false;
            $info['message'] = $result[0];
            // var_dump($info);
            echo json_encode($info);
            return;
        }
        
    }

    /**
     * 塔防迷圖解詳情頁 pictures
     * @param $data
     */
    function pictures($data) {
        $id = intval($data['id']);
        if(empty($id)) {
            $info['error'] = true;
            $info['message'] = 'Parameter is not complete';
            echo json_encode($info);
            return;
        }

        $this->db->table_name = $this->db->table_name.'_data';
        $result = $this->db->get_one(array('id'=>$id),'screenshots');
        $screenshots = string2array($result['screenshots']);
        foreach ($screenshots as $value) {
            $return[] = $value['url'];
        }
        // 如果沒有結果，返回錯誤信息,有結果返回結果
        if(empty($return)){
            $info['error'] = true;
            $info['message'] = 'No query results';
            echo json_encode($info);
            return;
        } else {
            $info['error'] = false;
            $info['message'] = $return;
            // var_dump($info);
            echo json_encode($info);
            return;
        }
    }

    /**
     * 獲得所有符合條件的遊戲索引
     */
    function gameindex($tag_ids) {
        // echo 'gameindex';
        $defense_index = $this->tag_db->select(array('linktag_id'=>'43','catid'=>$this->catid),'content_id');
        foreach ($defense_index as $key => $value) {
            $index['d'][] = $value['content_id'];
        }
        // 搜索字段遊戲索引
        if(is_array($tag_ids)) {
            foreach ($tag_ids as $key => $value) {
                if(!intval($value)) continue;
                $tags_index = $this->tag_db->select(array('linktag_id'=>$value),"content_id");

                foreach ($tags_index as $value) {
                    $index[$key][] = $value['content_id'];
                }
            }    
        }
        // 四個字段索引補全
        for($i=0;$i<=3;$i++){
            if(!isset($index[$i])){
                $index[$i] = $index['d'];
            }
        }
        // 取符合所有字段的遊戲索引
        $games_index = array_intersect($index['d'],$index[0],$index[1],$index[2],$index[3]);
        // 遊戲數量
        $count = count($games_index);
        return array(
            'games_index'=>$games_index,
            'count' => $count
            );
    }

    /**
     * 獲得所有遊戲列表
     */
    protected function gamelist($tag_ids=array(),$page='',$order='',$free='') {
        // echo 'gamelist';
        // 查詢條件
        if($page != '') {
            $perpage = 10;
            $start = ($page-1)*$perpage;
            if($start < 0 ) $start = 0;
            $limit = "LIMIT {$start},{$perpage}";
        } else {
            $limit = '';
        }

        // 獲得符合條件的遊戲索引
        $indexinfo = $this->gameindex($tag_ids);
        $games_index = $indexinfo['games_index'];

        // 添加免費查詢條件
        if($free == 1) {
            $free = "AND d.price_number=0";
        }

        // 索引數組轉換索引字符串
        $index = implode(',', $games_index);
        // 從遊戲庫中查詢遊戲信息
        if(!empty($index)) {
            $this->db->query("SELECT i.id,title,icon,icon_tag,price_number,price,price_unit,score,release_time FROM {$this->db->table_name} i LEFT JOIN {$this->db->table_name}_data d ON i.id=d.id WHERE i.id IN ({$index}) {$free} {$order} {$limit}");
            $games = $this->db->fetch_array();
        }
        if ($games) {
            return $games;
        } else {
            return array();
        }

    }

    /**
     * 排行榜ranks
     */
    function ranks($data) {
        // echo 'ranks';
        if($data['paint'] != 0){
            $tag_ids[] = intval($data['paint']);
        }
        if($data['theme'] != 0){
            $tag_ids[] = intval($data['theme']);
        }
        if($data['play'] != 0){
            $tag_ids[] = intval($data['play']);
        }
        if($data['feature'] != 0){
            $tag_ids[] = intval($data['feature']);
        }
        $page = $_GET['page']?:1;
        $free = intval(trim($_GET['free'])) == 1 ?:'';
        $gameindex = $this->gameindex();
        $order = 'ORDER BY score DESC';
        $ranks = $this->gamelist($tag_ids,$page,$order,$free);

        $this->db->table_name = $this->db->db_tablepre.'hits';
        foreach ($ranks as $key => $value) {
            $played = $this->db->get_one(array('hitsid'=>"c-{$this->modelid}-{$value['id']}"));
            $ranks[$key]['played'] = $played['views'];
            $ranks[$key]['score'] *= 2;

            unset($ranks[$key]['icon_tag']);
            unset($ranks[$key]['price']);
            unset($ranks[$key]['price_number']);
            unset($ranks[$key]['price_free']);
            unset($ranks[$key]['price_unit']);
            unset($ranks[$key]['release_time']);
        }

        if(!empty($ranks)) {
            $info['error'] = false;
            $info['count'] = $gameindex['count'];
            $info['message'] = $ranks;
            // var_dump($info);
            echo json_encode($info);
        } else {
            $info['error'] = true;
            $info['message'] = '沒有更多遊戲';
            echo json_encode($info);
            return;
        }
    }

    /**
     * 遊戲庫 library
     */
    function library() {
        pc_base::load_sys_func('iconv');
        $all_games = $this->gamelist();
        foreach ($all_games as $key => $value) {
            unset($all_games[$key]['price_number']);
            unset($all_games[$key]['price_free']);
            unset($all_games[$key]['price_unit']);
            unset($all_games[$key]['score']);
            $english = gbk_to_pinyin(substr($all_games[$key]['title'],0,3))?:$all_games[$key]['title'][0];
            $all_games[$key]['en'] = $english[0];
            if ($all_games[$key]['icon_tag'] == 4) {
                $all_games[$key]['hot'] = 1;
            } else {
                $all_games[$key]['hot'] = 0;
            }
            unset($all_games[$key]['icon_tag']);
        }
        
        $count = count($all_games);
        if(!empty($all_games)) {
            $info['error'] = false;
            $info['count'] = $count;
            $info['message'] = $all_games;
            // var_dump($info);
            echo json_encode($info);
        } else {
            $info['error'] = true;
            $info['message'] = 'No more games';
            echo json_encode($info);
            return;
        }
    }

    /**
     * 獲取免費所有遊戲
     */
    function free($data) {
        // 搜索塔防遊戲id 索引
        $all_games = $this->gamelist();
        foreach ($all_games as $game) {
            $index[] = $game['id'];
        }
        $index = implode(',', $index);
        // 搜索限免 冰點遊戲 信息
        $result1 = $this->db->query("SELECT i.id,icon,title,price,price_number,price_unit,score FROM {$this->db->table_name} i LEFT JOIN {$this->db->table_name}_data d ON d.id=i.id WHERE i.id IN ($index) AND price_number=0 AND price_number<price");
        $apps_free = $this->db->fetch_array();
        $result2 = $this->db->query("SELECT i.id,icon,title,price,price_number,price_unit,score FROM {$this->db->table_name} i LEFT JOIN {$this->db->table_name}_data d ON d.id=i.id WHERE i.id IN ($index) AND ((price_number>=6 AND price_unit=1) OR (price_number>=0.99 AND price_unit=2)) AND price_number<price");
        $free_point = $this->db->fetch_array();

        $frees = array_merge($apps_free,$free_point);
        $count = count($frees);

        $page = intval($data['page']);
        if(empty($page)) {
            $page = 1;
        }
        $limit = 10;
        $start = ($page-1)*$limit;
        if($start < 0 ) $start = 0;
        $return = array_slice($frees,$start,10);

        if(!empty($return)) {
            $info['error'] = false;
            $info['count'] = $count;
            $info['message'] = $return;
            // var_dump($info);
            echo json_encode($info);
        } else {
            $info['error'] = true;
            $info['message'] = 'No more games';
            // var_dump($info);
            echo json_encode($info);
            return;
        }
        
    }

    /**
     * 遊戲詳情頁
     */
    public function details($data) {
        // echo 'details';

        $id = intval($data['id']);
        if(empty($id)) {
            $info['error'] = true;
            $info['message'] = 'Parameter is not complete';
            echo json_encode($info);
            return;
        }
        $gameinfo = $this->game_info($id);
        $activity = $this->activity($id);
        $hot_commet = $this->hot_commet($id);
        $comment_count = $this->comment_count($id);
        $news_count = $this->news_count($id);
        $samegame = $this->samegame($id);
        $news = $this->news($id);

        if(empty($gameinfo['title'])) {
            $info['error'] = true;
            $info['message'] = 'No find game';
            echo json_encode($info);
            return;
        }

        $infos['gameinfo'] = $gameinfo;
        $infos['activity'] = $activity;
        $infos['hot_commet'] = $hot_commet;
        $infos['comment_count'] = $comment_count;
        $infos['samegame'] = $samegame;
        $infos['news_count'] = $news_count;
        $infos['news'] = $news;
        

        $info['error'] = false;
        $info['message'] = $infos;
        // var_dump($info);
        echo json_encode($info);


    }
    

    /**
     * 獲取遊戲詳細信息
     */
    protected function game_info($game_id) {
        $system = $this->db->get_one(array('id'=>$game_id),'title,icon,language,score');
        foreach ($system as $key => $value) {
            if($key=='score') {
                $info[$key] = $value*2;
            } else {
                $info[$key] = $value;
            }
        }
        $this->db->table_name = $this->db->table_name.'_data';
        if ($this->modelid == 21) {
            $model = $this->db->get_one(array('id'=>$game_id),'screenshots,brief,release_time,price_number,price_unit,version,author_name,platform,filesize,package');
        } else {
            $model = $this->db->get_one(array('id'=>$game_id),'screenshots,brief,release_time,price_number,price_unit,version,author_name,platform,filesize,itunes_id,package,s_icon,s_title,s_url,s_description');
        }
        foreach ($model as $key => $value) {
            $info[$key] = $value;
        }
        $info['screenshots'] = string2array($info['screenshots']);
        $package = string2array($info['package']);
        $info['package'] = $package['fileurl'];
        $info['tags'] = linktags($this->catid, $game_id);
        $info['filesize'] = output_filesize($info['filesize']);

        return $info;
    }

    /**
     * 最新活動
     * @param $data
     */
    protected function activity($id) {
        // echo 'activity';

        $this->db->table_name = $this->db->db_tablepre.'relation';
        $this->db->query("SELECT sid,scat FROM www_relation WHERE scat =695 AND tcat=20 AND tid={$id}");
        $index = $this->db->fetch_array();

        $this->db->table_name = $this->db->db_tablepre.'news';
        foreach ($index as $v) {
            $result = $this->db->get_one(array('id'=>$v['sid'],'catid'=>$v['scat']),'id,title,url');
            if($result) {$info[] = $result;}
        }

        $MODEL = getcache('model','commons');
        $this->db->table_name = $this->db->db_tablepre.$MODEL[$this->modelid]['tablename'];
        if ($info[0]) {
            return $info[0];
        } else {
            return '';
        }
    }    

    /**
     * 相似遊戲
     * @param $data
     */
    protected function samegame($id) {
        // echo 'samegame';
        
        $this->db->table_name = $this->db->db_tablepre.'linktag_to_content';

        $tags = $this->db->select(array('catid'=>$this->catid,'content_id'=>$id),'linktag_id');

        foreach ($tags as $value) {
            if($value['linktag_id'] == 43) continue;
            $index[] = $value['linktag_id'];
        }
        $index = implode(',', $index);

        $defense = $this->db->select(array('catid'=>$this->catid,'linktag_id'=>43),'content_id');
        foreach ($defense as $value) {
            if($value['content_id'] == $id) continue;
                $def[] = $value['content_id'];
        }
        if(!empty($index)) {
            $this->db->query("SELECT content_id FROM phpcms_linktag_to_content WHERE catid=$this->catid AND linktag_id IN ($index)");
            $games = $this->db->fetch_array();
        }

        foreach ($games as $game) {
            if(in_array($game['content_id'],$def)) {
                $count[$game['content_id']] +=1;
            }
        }

        foreach ($count as $key => $value) {
            $kk[$value][] =$key;
        }
        krsort($kk);
        $count = 0;
        foreach ($kk as $k) {
            foreach ($k as $value) {
                $sames[] = $value;
                $count += 1;
                if($count > 2) break 2;
            }
            
        }

        $sames = implode(',', $sames);
        if(!empty($sames)) {
            if ($this->modelid == 21) {
                $this->db->query("SELECT title,id,icon FROM phpcms_androidgames WHERE catid=$this->catid AND id IN ($sames)");
            } else {
                $this->db->query("SELECT title,id,icon FROM phpcms_iosgames WHERE catid=$this->catid AND id IN ($sames)");
            }
            $return = $this->db->fetch_array();
        }

        return $return;
    }

    /**
     * 相關新聞
     * @param $data
     */
    protected function news($id) {
        // echo 'relation';

        if ($this->modelid == 21) {
            $catids = '101,474';
        } else {
            $catids = '81,474';
        }
        $this->db->query("SELECT scat,sid FROM phpcms_relation WHERE tcat=$this->modelid AND tid={$id} AND scat IN ($catids)");
        $index = $this->db->fetch_array();
        $index = array_slice($index,$start,2);

        $info = '';

        $this->db->table_name = $this->db->db_tablepre.'news';
        foreach ($index as $v) {
            $result = $this->db->get_one(array('id'=>$v['sid'],'catid'=>$v['scat']),'id,title,url');
            if($result) {
                $info[] = $result;
            }
        }

        return $info;

    }

    /**
     * 相關評測
     * @param $data
     */
    protected function relation($game_id, $catids) {
        // echo 'relation->';

        if($game_id) {
            $this->db->table_name = $this->db->db_tablepre.'relation';
            $this->db->query("SELECT sid,scat FROM www_relation WHERE scat IN ({$catids}) AND tcat=$this->modelid AND tid={$game_id}");
            $index = $this->db->fetch_array();
        } else {
            $index = array();
        }
        $this->db->table_name = $this->db->db_tablepre.'video';
        foreach ($index as $v) {
            $result = $this->db->get_one(array('id'=>$v['sid'],'catid'=>$v['scat']),'id,catid,title,url,youkuid');
            if($result) {$info[] = $result;}
        }
        $this->db->table_name = $this->db->db_tablepre.'news';
        foreach ($index as $v) {
            $result = $this->db->get_one(array('id'=>$v['sid'],'catid'=>$v['scat']),'id,catid,title,url');
            if($result) {$info[] = $result;}
        }

        return $info;
        
    }

    /**
     * 相關評測
     * @param $data
     */
    protected function relation_count($id, $catids) {
        // echo 'relation_count->';

        $this->db->table_name = $this->db->db_tablepre.'relation';
        $count = $this->db->count("scat IN ({$catids}) AND tcat=$this->modelid AND tid={$id}");
        return $count;

    }

    /*
     * 首推評測
     */
    protected function hot_commet($id) {
        // echo 'hot_commet->';

        $index = $this->db->get_one(array('id'=>$id),'comment');
        preg_match('/\/(\d+)[_-](\d+)(-1)?.html/i', $index['comment'], $match);
        list($temp, $catid, $id) = $match;

        $this->db->table_name = $this->db->db_tablepre.'video';        
        $result = $this->db->get_one(array('id'=>$id,'catid'=>$catid),'id,title,url,youkuid');

        if(!$result) {
            $this->db->table_name = $this->db->db_tablepre.'news';
            $result = $this->db->get_one(array('id'=>$id,'catid'=>$catid),'id,title,url');
            $result['youkuid'] = '';
        }
        if ($result) {
            return $result;
        } else {
            return array(
                'id' => '',
                'catid' => '',
                'title' => '',
                'youkuid' => '');
        }
        
    }

    /**
     * 評測數目
     * @param $data
     */
    protected function comment_count($id) {
        // echo 'comment_count->';

        if ($this->modelid == 21) {
            $catids = '102,473';
        } else {
            $catids = '82,473';
        }
        $list = $this->relation_count($id,$catids);
        return $list;
    }


    /**
     * 新聞條目
     * @param $id
     */
    protected function news_count($id) {
        // echo 'news_count->';

        if ($this->modelid == 21) {
            $catids = '101,474';
        } else {
            $catids = '81,474';
        }
        $list = $this->relation_count($id,$catids);
        return $list;
    }

    /*
     * 魔盒匹配遊戲
     */
    function NextBox($data) {

        $first = $data['first'];
        $second = $data['second'];
        if(empty($first) && empty($second)) {
            $info['error'] = true;
            $info['message'] = 'Please change one game';
            echo json_encode($info);
            return;
        }

        $result1 = $this->tag_db->select(array('content_id'=>$first),'linktag_id');
        $result2 = $this->tag_db->select(array('content_id'=>$second),'linktag_id');

        $all = array_merge($result1, $result2);

        $tags = array();
        foreach ($all as $value) {
            if (!in_array($value['linktag_id'], $tags)) {
                $tags[] = $value['linktag_id'];
            }
        }

        $tags = implode(',', $tags);

        $defense = $this->tag_db->select(array('catid'=>$this->catid,'linktag_id'=>43),'content_id');
        foreach ($defense as $value) {
            $id_arr[] = $value['content_id'];
        }

        $defense_index = implode(',', $id_arr); 
        do {
            $this->db->query("SELECT * FROM phpcms_linktag_to_content WHERE catid=$this->catid AND content_id IN ($defense_index) AND linktag_id IN ($tags) ORDER BY RAND() LIMIT 1");
            $game = $this->db->fetch_array();
            $id = $game[0]['content_id'];
            $gameinfo = $this->db->get_one(array('id'=>$id),'id,title,icon,score');
            $score = $gameinfo['score'];
        } while(!in_array($id, $id_arr) || $id==$first || $id==$second || $score<3);

        if ($gameinfo) {
            $info['error'] = 'false';
            $info['message'] = $gameinfo;
            echo json_encode($info);
            return;
        } else {
            $info['error'] = 'true';
            $info['message'] = 'NextBox Error';
            echo json_encode($info);
            return;
        }
    }

}
