<?php
/**
 * 工具模型
 * 2014-05-17
 * model() 創建一個模型對象，是靜態方法
 * tableName() 返回當前數據表的名字
 */
class Tools extends CActiveRecord{
    /**
     * 返回當前模型對象的靜態方法
     */
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    /**
     * 返回當前模型的名字
     */
    public function tableName(){
        return '{{tools}}';
    }
    public function attributeLabels(){
        return array(
            'name'=>'工具名稱',
            'icon'=>'工具圖標',
            'download_url'=>'下載地址',
            'type'=>'工具類型',
            'description'=>'工具描述',
            'bbs_url'=>'論壇URL',
            'has_ads'=>'是否要廣告',
            'ads_url'=>'廣告URL',
        );
    }
}
