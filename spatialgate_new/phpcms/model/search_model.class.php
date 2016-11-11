<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class search_model extends model {
	public $solr = '';
	public function __construct() {

        //搜索配置
        $setting = pc_base::load_config('solr');
        //检测服务器状态
        $this->solr = new Apache_Solr_Service($setting['hostname'], $setting['port'], $setting['path']);
        if ( ! $this->solr->ping() ) {
            echo 'Search service not responding.';
            return;;
        }
		parent::__construct();
		
	}
	/**
	 * 添加到全站搜索、修改已有内容
	 * @param $typeid
	 * @param $id
	 * @param $data
	 * @param $text 不分词的文本
	 * @param $adddate 添加时间
	 * @param $iscreateindex 是否是后台更新全文索引
	 */
	public function update_search($modelid ,$id = 0,$data = '') {

        //定义索引文档
        $document = new Apache_Solr_Document();
        //设置搜索唯一key
        $document->ukid = $modelid.'-'.$id;
        foreach ($data as $id=>$val) {
            if(is_array($val)) {
                foreach ($val as $datum) {
                    $document->setMultiValue($id, $datum);
                }
            } else {
                $document->$id = $val;
            }
        }

        try {
            $this->solr->addDocument($document);
            $this->solr->commit();
        } catch(Exception $e) {  //捕获异常，不做处理

        }

	}
	/*
	 * 删除全站搜索内容
	 */
	public function delete_search($modelid ,$id) {
        try {
            $this->solr->deleteByQuery('ukid:'.$modelid.'-'.$id);
            $this->solr->commit();
        } catch(Exception $e) {  //捕获异常，不做处理

        }
	}
}
?>
