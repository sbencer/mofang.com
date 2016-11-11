<?php
/**
 * 短连接 统计页面
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_class('PHPExcel', 'admin', 0);
pc_base::load_app_class('shorturlService', 'admin', 0);
pc_base::load_app_func('adclass');

class shorturlcount extends admin {
    /**
     *
     */
    function __construct() {
        $this->db = pc_base::load_model('shorturl_model');
        parent::__construct();
    }

    /**
     * 统计分析结果页面    分块
     */
    public function index() {
        try {
            $allClass = getAllAdData();
            $formatAllClass = getAllClass($allClass);
            if (isset($_GET['cid'])) {
                // 参数处理
                $day = mktime(0, 0, 0);
                $cid = empty($_GET['cid']) ? "" : $_GET['cid'];
                $begintime = empty($_GET['begintime']) ? ($day - 86400) : strtotime($_GET['begintime']);
                $endtime = empty($_GET['endtime']) ? ($day) : strtotime($_GET['endtime']);

                if (empty($cid)) {
                    exit(L('params_error'));
                }
                // 找到所有的栏目
                $allClassData = getAllAdData();
                $allClass = array();
                foreach ($allClassData as $val) {
                    $allClass[$val['id']] = $val;
                }

                $shorturlArr = $this->getShorturls($cid);
                if (empty($shorturlArr)) {
                    throw new Exception(L('shortUrlInNull'));
                }
                $shorturlData = $shorturlArr['shorturlData'];
                $shorturlId = $shorturlArr['shorturlId'];

                $countArr = $this->getCount($shorturlId, $begintime, $endtime);
                $shorturlcountData = $countArr['shorturlcountData'];
                $shorturlcount = $countArr['shorturlcount'];

                include $this->admin_tpl('shorturlcount_chunk');
            } else {
                pc_base::load_sys_class('form');

                include $this->admin_tpl('shorturlcount_chunk');
            }
        } catch (Exception $e) {
            showmessage($e->getMessage());
        }

    }

    /**
     * 计算访问次数
     * @param $shorturlId
     * @param $begintime
     * @param $endtime
     * @return array|bool
     */
    function getCount($shorturlId, $begintime, $endtime) {
        $sql = "select shorturlid,sum(count) as total from phpcms_shorturlcount where shorturlid in (" . implode(',', $shorturlId) . ") and day>=$begintime and day<$endtime group by shorturlid";
        $this->db->query($sql);
        $shorturlcountData = $this->db->fetch_array();
        if (!$shorturlcountData) {
            return false;
        }
        $shorturlcount = array();
        foreach ($shorturlcountData as $val) {
            $shorturlcount[$val['shorturlid']] = $val;
        }
        return array(
            'shorturlcountData' => $shorturlcountData,
            'shorturlcount' => $shorturlcount
        );
    }

    /**
     * 找对应下面的短连接
     * @param $cid
     * @return array|bool
     */
    function getShorturls($cid) {
        $sql = "select * from phpcms_shorturl where cid in(" . implode(',', $cid) . ") order by cid asc,id asc";
        $this->db->query($sql);
        $shorturlData = $this->db->fetch_array();
        if (!$shorturlData) {
            return false;
        }
        $shorturlId = array();
        foreach ($shorturlData as $val) {
            $shorturlId[] = $val['id'];
        }
        return array(
            'shorturlData' => $shorturlData,
            'shorturlId' => $shorturlId,
        );
    }

    /**
     * 图表统计格式
     */
    public function chartCount() {
        try {
            $allClass = getAllAdData();
            $formatAllClass = getAllClass($allClass);
            if (isset($_GET['cid'])) {
                // 参数处理
                $day = mktime(0, 0, 0);
                $cid = empty($_GET['cid']) ? "" : $_GET['cid'];
                $begintime = empty($_GET['begintime']) ? ($day - 86400) : strtotime($_GET['begintime']);
                $endtime = empty($_GET['endtime']) ? ($day) : strtotime($_GET['endtime']);
                $type = empty($_GET['type']) ? 'day' : $_GET['type'];

                if (empty($cid) || empty($begintime) || empty($endtime)) {
                    exit(L('params_error'));
                }
                // 找到所有的栏目
                $allClassData = array();
                foreach ($allClass as $val) {
                    $allClassData[$val['id']] = $val;
                }
                // 找到短连接
                $shorturlArr = $this->getShorturls($cid);
                if (empty($shorturlArr)) {
                    throw new Exception(L('shortUrlInNull'));
                }

                $shorturlData = $shorturlArr['shorturlData'];
                $shorturlIdIndex = array();
                foreach ($shorturlData as $val) {
                    $shorturlIdIndex[$val['id']] = $val;
                }
                $shorturlId = $shorturlArr['shorturlId'];

                // 具体的图表数据
                switch ($type) {
                    case 'day':
                        $countArr = $this->getCountGroupDay($shorturlId, $begintime, $endtime);
                        $dateArr = range($begintime, $endtime, 86400);
                        break;
                    case 'month':
                        $countArr = $this->getCountGroupMonth($shorturlId, $begintime, $endtime);
                        $dateArr = $this->getMonthArr($begintime, $endtime);
                        break;
                    case 'week':
                        $countArr = $this->getCountGroupWeek($shorturlId, $begintime, $endtime);
                        $dateArr = $this->getWeekArr($begintime, $endtime);
                        break;
                }

                // 统计出来数据中做多的那个日期  主要是有的链接某天可能没有的点击，填0
                $dataGroup = array();
                // 把相同的url的分成一组，看看那个的日期最多
                foreach ($countArr as $val) {
                    $dataGroup[$val['shorturlid']][(string)$val['time']] = $val;
                }

                // 生成所有的数据
                $chartData = array();
                foreach ($shorturlData as $shortUrlOne) {
                    foreach ($dateArr as $dateOne) {
                        if (isset($dataGroup[$shortUrlOne['id']][(string)$dateOne])) {
                            $chartData[$shortUrlOne['id']][(string)$dateOne] = $dataGroup[$shortUrlOne['id']][(string)$dateOne];
                        } else {
                            $chartData[$shortUrlOne['id']][(string)$dateOne] = array(
                                'shorturlid' => $shortUrlOne['id'],
                                'day' => $dateOne,
                                'total' => 0,
                                'uniquetotal' => 0,
                                'facebooktotal' => 0,
                                'twittertotal' => 0,
                                'plurktotal' => 0,
                                'googletotal' => 0,
                                'yahoototal' => 0,
                                'baidutotal' => 0,
                                'othertotal' => 0,
                            );
                        }

                    }
                }
                // 可以表格可以图表
                $showType = empty($_GET['showType']) ? 'chart' : $_GET['showType'];
                if ($showType == 'chart') {
                    include $this->admin_tpl('shorturlcount_chart');
                } elseif ($showType == 'excel') {
                    $this->printExcel($shorturlData, $chartData, $allClassData, $begintime, $endtime, $type);
                } else {
                    include $this->admin_tpl('shorturlcount_chunk_chartdata');
                }
            } else {
//          $show_header  = true;
                pc_base::load_sys_class('form');
                include $this->admin_tpl('shorturlcount_chart');
            }
        } catch (Exception $e) {
            showmessage($e->getMessage());
        }
    }

    /**
     * 根据天来画出一个图表
     * @param $shorturlId
     * @param $begintime
     * @param $endtime
     * @return array|bool
     */
    function getCountGroupDay($shorturlId, $begintime, $endtime) {
        $sql = "select shorturlid,day time,`count` as total,uniquecount as uniquetotal,facebookcount as facebooktotal,twittercount as twittertotal,
            plurkcount as plurktotal, googlecount as googletotal, yahoocount as yahoototal,baiducount as baidutotal,othercount as othertotal
         from phpcms_shorturlcount where shorturlid in (" . implode(',', $shorturlId) . ") and day>=$begintime and day<=$endtime order by shorturlid asc";
        $this->db->query($sql);
        $shorturlcountData = $this->db->fetch_array();
        return $shorturlcountData;
    }

    /**
     * 根据月来画出一个图表
     * @param $shorturlId
     * @param $begintime
     * @param $endtime
     * @return array|bool
     */
    function getCountGroupMonth($shorturlId, $begintime, $endtime) {
        $sql = "select shorturlid,from_unixtime(`day`,'%Y%m') time,sum(count) as total,sum(uniquecount) as uniquetotal,sum(facebookcount) as facebooktotal,sum(twittercount) as twittertotal,sum(plurkcount) as plurktotal, sum(googlecount) as googletotal, sum(yahoocount) as yahoototal,sum(baiducount) as baidutotal,sum(othercount) as othertotal from phpcms_shorturlcount where shorturlid in (" . implode(',', $shorturlId) . ") and day>=$begintime and day<=$endtime group by time,shorturlid order by shorturlid asc";
        $this->db->query($sql);
        $shorturlcountData = $this->db->fetch_array();
        return $shorturlcountData;
    }

    /**
     * 取得月的信息
     * @param $begintime
     * @param $endtime
     * @return array
     */
    function getMonthArr($begintime, $endtime) {
        $beginTime = date('Ym', $begintime);
        $endTime = date('Ym', $endtime);
        $beginTimeF = date('Y-m-d', $begintime);
        $date = date_create($beginTimeF);
        $dateArr[] = $beginTime;
        do {
            date_add($date, date_interval_create_from_date_string('1 month'));
            $dateone = date_format($date, 'Ym');
            $dateArr[] = (string)$dateone;

        } while ($dateone < $endTime);
        return $dateArr;
    }


    /**
     * 根据月来画出一个图表
     * @param $shorturlId
     * @param $begintime
     * @param $endtime
     * @return array|bool
     */
    function getCountGroupWeek($shorturlId, $begintime, $endtime) {
        $sql = "select shorturlid,from_unixtime(`day`,'%Y%U') time,sum(count) as total,sum(uniquecount) as uniquetotal,sum(facebookcount) as facebooktotal,sum(twittercount) as twittertotal,sum(plurkcount) as plurktotal, sum(googlecount) as googletotal, sum(yahoocount) as yahoototal,sum(baiducount) as baidutotal,sum(othercount) as othertotal from phpcms_shorturlcount where shorturlid in (" . implode(',', $shorturlId) . ") and day>=$begintime and day<=$endtime group by time,shorturlid order by shorturlid asc";
        $this->db->query($sql);
        $shorturlcountData = $this->db->fetch_array();
        return $shorturlcountData;
    }

    /**
     * 取得月的信息
     * @param $begintime
     * @param $endtime
     * @return array
     */
    function getWeekArr($begintime, $endtime) {
        $beginTime = date('YW', $begintime);
        $endTime = date('YW', $endtime);
        $beginTimeF = date('Y-m-d', $begintime);
        $date = date_create($beginTimeF);
        $dateArr[] = $beginTime;
        do {
            date_add($date, date_interval_create_from_date_string('7 days'));
            $dateone = date_format($date, 'YW');
            $dateArr[] = (string)$dateone;

        } while ($dateone < $endTime);
        return $dateArr;
    }

    /**
     * 打印出来报表信息
     * @param $shorturlData
     * @param $chartData
     * @param $allClassData
     * @param $begintime
     * @param $endtime
     * @param $type
     */
    function printExcel($shorturlData, $chartData, $allClassData, $begintime, $endtime, $type) {

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        $objPHPExcel = new PHPExcel(); // Set document properties
        $objPHPExcel->getProperties()->setCreator("mofang")
            ->setLastModifiedBy("mofang")
            ->setTitle(L('excel_title'))
            ->setSubject(L('excel_subject'))
            ->setDescription(L('excel_description'))
            ->setKeywords(L('excel_keywords'))
            ->setCategory(L('excel_category'));



        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', L('adclass_name'))
            ->setCellValue('B1', L('shorturl_original_url'))
            ->setCellValue('C1', L('shorturl_short'))
            ->setCellValue('D1', L('shorturl_date'))
            ->setCellValue('E1', L('shorturlcount_count'))
            ->setCellValue('F1', L('shorturlcount_uniquecount'))
            ->setCellValue('G1', L('shorturlcount_facebookcount'))
            ->setCellValue('H1', L('shorturlcount_twittercount'))
            ->setCellValue('I1', L('shorturlcount_plurkcount'))
            ->setCellValue('J1', L('shorturlcount_googlecount'))
            ->setCellValue('K1', L('shorturlcount_yahoocount'))
            ->setCellValue('L1', L('shorturlcount_baiducount'))
            ->setCellValue('M1', L('shorturlcount_othercount'));

        $rowNum = 1;
        foreach ($shorturlData as $val) {
            foreach ($chartData[$val['id']] as $index=>$valTotal) {
                $dateFormat = '';
                switch($type) {
                    case 'day':
                        $dateFormat = date("Y/m/d", $index);
                        break;
                    case 'week':
                        $dateFormat = substr($index, 0, 4) . "年" . substr($index, 4, 2) ."周";
                        break;
                    case 'monty':
                        $dateFormat = substr($index, 0, 4) . "年" . substr($index, 4, 2) ."月";
                        break;
                }
                $rowNum++;
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $rowNum, $allClassData[$val['cid']]['name'])
                    ->setCellValue('B' . $rowNum, $val['url'])
                    ->setCellValue('C' . $rowNum, $val['shorturl'])
                    ->setCellValue('D' . $rowNum, $dateFormat)
                    ->setCellValue('E' . $rowNum, $valTotal['total'])
                    ->setCellValue('F' . $rowNum, $valTotal['uniquetotal'])
                    ->setCellValue('G' . $rowNum, $valTotal['facebooktotal'])
                    ->setCellValue('H' . $rowNum, $valTotal['twittertotal'])
                    ->setCellValue('I' . $rowNum, $valTotal['plurktotal'])
                    ->setCellValue('J' . $rowNum, $valTotal['googletotal'])
                    ->setCellValue('K' . $rowNum, $valTotal['yahoototal'])
                    ->setCellValue('L' . $rowNum, $valTotal['baidutotal'])
                    ->setCellValue('M' . $rowNum, $valTotal['othertotal']);
            }
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $nameType = "";
        switch($type) {
            case 'day':
                $nameType = '日';
                break;
            case 'week':
                $nameType = '周';
                break;
            case 'monty':
                $nameType = '月';
                break;
        }
        $name = sprintf(L('excel_file_name'),
            date('Y-m-d', $begintime),
            date('Y-m-d', $endtime),
            $nameType
        );
        // 从浏览器直接输出$m_strOutputExcelFileName
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type: application/vnd.ms-excel;");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=" . $name . ".xlsx");
        header("Content-Transfer-Encoding:binary");
        $objWriter->save("php://output");

    }

}