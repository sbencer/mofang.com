<?php

/**
 * Class shorturl
 */
class shorturlService {

    public function __construct() {
        $this->db = pc_base::load_model('shorturl_model');
        $this->shorturlauto = pc_base::load_model('shorturlauto_model');
    }

    /**
     * 短连接统计及跳转
     * 统计点击的，然后是跳转
     */
    public function jump($url) {

        $sql = "select * from phpcms_shorturl where binary shorturl='" . $url . "'";
        $this->db->query($sql);
        $urlData = $this->db->fetch_array();
        if (!$urlData) {
            exit("找不到该地址");
        }

        // 记录  如果今天又那么+1 没有新插入一条
        $day = mktime(0, 0, 0);
        $sql = "select id from phpcms_shorturlcount where shorturlid=" . $urlData[0]['id'] . " and day=" . $day;
        $this->db->query($sql);
        $countId = $this->db->fetch_array();
        $from = $this->getFrom();
        // 没记录
        if (!$countId) {
            $sql = "insert into phpcms_shorturlcount(shorturlid,count,uniquecount," . $from . "count,day) values(" . $urlData[0]['id'] . ", 1,1,1, " . $day . ")";
        } else {
            // 同一ip每天计算一次
            $ip = $this->GetIP();
            $key = 'shorturl-' . $ip;
            $updateArr = array('count=count+1', $from . 'count=' . $from . 'count+1');

            if ($ip != 'unknown') {
                if (!getcache($key, '', 'memcache', 'html')) {
                    $time = mktime(0, 0, 0) + 86400 - time();
                    setcache($key, 1, '', 'memcache', 'html', $time);
                    $updateArr[] = 'uniquecount=uniquecount+1';
                }
            } else {
                $updateArr[] = 'uniquecount=uniquecount+1';
            }

            $sql = "update phpcms_shorturlcount set " . implode(',', $updateArr) . " where id=" . $countId[0]['id'];
        }
        $this->db->query($sql);
        // 跳转

        //header("HTTP/1.1 301 Moved Permanently");
        header("Location:" . $urlData[0]['url']);
    }
    private function getFrom(){
        $referer = $_SERVER['HTTP_REFERER'];
        if (!($url = parse_url($referer)) || empty($url['host'])) {
            return 'other';
        }
        $sourcesArr = array('facebook', 'twitter', 'plurk', 'google', 'yahoo', 'baidu');
        foreach ($sourcesArr as $val) {
            if (strpos($referer, $val) !== false) {
                return $val;
            }
        }
        return 'other';
    }
    /**
     * 获取ip
     */
    private function GetIP(){
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }
    /**
     * 增加一条记录   根据url和cid  返回对应的短连接
     * @param $url
     * @param $cid
     * @param $web
     * @return mixed
     */
    public function add($url, $cid, $web) {
        $url = trim($url);
        $cid = trim($cid);
        try {
            if (empty($url) || !is_numeric($cid) || $cid < 0 || !($web == 1 || $web == 2)) {
                throw new Exception('参数不正确！');
            }
            // 查询是否已经有过
            $isExist = $this->db->get_one("url='" . $url . "' and cid=" . $cid ." and webhost=" . $web, 'shorturl');
            if ($isExist) {
                return $isExist['shorturl'];
            }

            // 查询超过了500条没
            $res = $this->db->get_one('create_time>' . mktime(0, 0, 0), 'count(*) as total');
            if ($res['total'] > 500) {
                throw new Exception('今日增加的太多了！');
            }

            $shorturl = $this->db->tenTo62($this->getAuto());
            // 插入操作
            $data = array(
                'url' => $url,
                'cid' => $cid,
                'webhost' => $web,
                'shorturl' => $shorturl,
                'create_time' => time()
            );
            if ($this->db->insert($data)) {
                return $shorturl;
            } else {
                throw new Exception('插入失败！');
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * 自增然后返回增长后的
     * @return mixed
     * @throws Exception
     */
    protected function getAuto() {
        $this->shorturlauto->update(array('id' => '+=1'), '1=1');
        $one = $this->shorturlauto->get_one();
        if (!$one) {
            throw new Exception("自增1或者查询失败");
        }
        return $one['id'];
    }

    /**
     * @param $id
     */
    public function shorturlDelete($id) {
        $sql = "delete from phpcms_shorturl where id=" . $id . " limit 1";
        return $this->db->query($sql);
    }
}
