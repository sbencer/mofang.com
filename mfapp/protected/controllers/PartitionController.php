<?php
/**
 * 專區或攻略列表頁
 * @author Jozh Liu
 * @date-time 2014-05-24
 */
class PartitionController extends Controller{
    function actionIndex(){
        //$cacheKey = "partition.lists";
        //if ( false === ($lists_info = Yii::app()->cache->get($cacheKey)) ) {
            $catid = 935;
            $sql = 'select id,url,thumb,shortname,inputtime from {{links}} where catid = :catid order by `listorder` DESC';
            if(strpos($_SERVER['HTTP_HOST'], 'test')){
                $command = Yii::app()->cms_db->createCommand($sql);
            }else{
                $command = Yii::app()->db->createCommand($sql);
            }
            $command->bindParam(':catid',$catid,PDO::PARAM_INT);
            $lists = $command->queryAll();

            $lists_info = array();
            foreach($lists as $k=>$v){
                $domain_arr = explode('/',$v['url']);
                if( count($domain_arr) > 3 ) {
                    if ( $domain_arr[3] != '' ) {
                        $domain_dir = $domain_arr[3];
                    }else{
                        $domain_arr = explode('.',$domain_arr[2]);
                        $domain_dir = $domain_arr[0];
                    }
                    $sql = 'select setting from {{partition}} where domain_dir = :domain_dir';
                    if(strpos($_SERVER['HTTP_HOST'], 'test')){
                        $command = Yii::app()->cms_db->createCommand($sql);
                    }else{
                        $command = Yii::app()->db->createCommand($sql);
                    }
                    $command->bindParam(':domain_dir',$domain_dir,PDO::PARAM_INT);
                    $setting = $command->queryRow();

                    $setting_arr = $this->string2array($setting['setting']);
                    if ($setting_arr['is_mobile_template'] == 1) {
                         $lists_info[] = $v;
                    }
                }
            }
            //$cache_time = 3600;
            //if ( count($lists_info) != 0) {
            //    Yii::app()->cache->set($cacheKey, $lists_info, $cache_time);
            //}
        //}

        $this->smarty->assign('lists_info', $lists_info);
        $this->smarty->display('raiderslist/index.tpl');
    }
    function actionList(){
        $catid = 935;
        $sql = 'select id,url,thumb,shortname,inputtime from {{links}} where catid = :catid order by `listorder` DESC';
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':catid',$catid,PDO::PARAM_INT);
        $lists = $command->queryAll();

        $lists_info = array();
        foreach($lists as $k=>$v){
            $domain_arr = explode('/',$v['url']);
            if( count($domain_arr) > 3 ) {
                if ( $domain_arr[3] != '' ) {
                    $domain_dir = $domain_arr[3];
                }else{
                    $domain_arr = explode('.',$domain_arr[2]);
                    $domain_dir = $domain_arr[0];
                }
                $sql = 'select setting from {{partition}} where domain_dir = :domain_dir';
                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(':domain_dir',$domain_dir,PDO::PARAM_INT);
                $setting = $command->queryRow();

                $setting_arr = $this->string2array($setting['setting']);
                if ($setting_arr['is_mobile_template'] == 1) {
                     $lists_info[] = $v;
                }
            }
        }

        $this->smarty->assign('lists_info', $lists_info);
        $this->smarty->display('raiderslist/index.tpl');
    }

    /**
    * 將字符串轉換為數組
    *
    * @param    string  $data   字符串
    * @return   array   為空，則返回空數組
    */
    function string2array($data) {
        if($data == '') return array();
        @eval("\$array = $data;");
        return $array;
    }
}
