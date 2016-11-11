<?php
/**
 * 工具模型
 * 2014-05-17
 * model() 創建一個模型對象，是靜態方法
 * tableName() 返回當前數據表的名字
 */
class Script extends CActiveRecord{
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
        return '{{tools_script}}';
    }
    public function attributeLabels(){
        return array(
            'name'=>'腳本名稱',
            'script_version'=>'版本號',
            'script_url'=>'上傳腳本',
            'spec'=>'特殊參數',
            'resolution'=>'分辨率',
            'rom'=>'系統版本',
            'device_ids'=>'選擇設備機型',
            'description'=>'腳本描述',
            'image_url'=>'描述圖片',
        );
    }
}
