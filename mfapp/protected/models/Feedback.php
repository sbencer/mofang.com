<?php
/**
 * 工具模型
 * 2014-05-17
 * model() 創建一個模型對象，是靜態方法
 * tableName() 返回當前數據表的名字
 */
class Feedback extends CActiveRecord{
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
        return '{{tools_feedback}}';
    }
}
