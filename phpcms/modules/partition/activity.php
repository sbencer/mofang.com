<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
pc_base::load_sys_class('format','',0);
class activity extends admin {
	private $db,$admin_db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('partition_activity_model');
		$this->data_db = pc_base::load_model('partition_activity_data_model');
		$this->admin_db = pc_base::load_model('admin_model');
		$this->siteid = $this->get_siteid();
	}
	
    // 活动默认页面
	public function init () {
		if(empty($_GET['catid'])) showmessage(L('params_error'));

        // 獲得原有配置
        $data = $this->db->get_one(array('pid' => $_GET['catid']));

        $lists = $this->data_db->select(array('pid' => $_GET['catid']), '*', '', 'id desc');

		include $this->admin_tpl('activity_list');
	}

    // 活动样式修改
    public function manage() {
        // 獲得表單數據
        $data['pid'] = (int)$_GET['catid'];
        $data['color_t'] = $_GET['bgcolor'];
        $data['color_o'] = $_GET['oncolor'];
        $data['color_w'] = $_GET['wlcolor'];
        $data['color_l'] = $_GET['lkcolor'];

        // 檢測新建還是更新
        $info = $this->db->get_one(array('pid' => $data['pid']));

        if(!$info) {
            $this->db->insert($data);
        } else {
            $this->db->update($data, array('pid'=>$data['pid']));
        }
        
        showmessage(L('operation_success'),HTTP_REFERER);
    }

    // 添加新活动
    public function add() {

        if($_POST['dosubmit']) {
            $datas = $_POST['activity'];
            $data['pid'] = intval($datas['pid']);
            $data['title'] = $datas['title'];
            $data['image'] = $datas['image'];
            $data['url'] = $datas['url'];
            $data['circle'] = $datas['circle'];
            $data['start_time'] = strtotime($datas['start_time']);
            $data['end_time'] = strtotime($datas['end_time']);

            $data['limit_time'] = $datas['limit_time'] == 'on' ? 1 : 0;    

            if($this->data_db->insert($data)) {
                showmessage(L('operation_success'),HTTP_REFERER);
            }
        } else {
            if(empty($_GET['catid'])) showmessage(L('params_error'));

            include $this->admin_tpl('activity_add');    
        }
        
    }

    // 修改活动信息
    public function edit() {

        if($_POST['dosubmit']) {
            $datas = $_POST['activity'];
            $data['title'] = $datas['title'];
            $data['image'] = $datas['image'];
            $data['url'] = $datas['url'];
            $data['circle'] = $datas['circle'];
            $data['start_time'] = strtotime($datas['start_time']);
            $data['end_time'] = strtotime($datas['end_time']);

            $data['limit_time'] = $datas['limit_time'] == 'on' ? 1 : 0;    

            if($this->data_db->update($data, array('id' => $datas['id']))) {
                showmessage(L('operation_success'),HTTP_REFERER);
            }
        } else {
            if(empty($_GET['catid']) || empty($_GET['id'])) showmessage(L('params_error'));
            $info = $this->data_db->get_one(array('pid' => $_GET['catid'], 'id' => $_GET['id']));

            include $this->admin_tpl('activity_edit');    
        }
        
    }

    /**
     * 删除活动
     */
    public function delete() {
        
        if(empty($_GET['partitionid']) || empty($_GET['id'])) {
			showmessage(L('illegal_action'), HTTP_REFERER);
        }     

        if($this->data_db->delete(array('pid' => $_GET['partitionid'], 'id' => $_GET['id']))) {
		    showmessage(L('operation_success'), HTTP_REFERER);
        } else {
			showmessage(L('operation_failure'), HTTP_REFERER);
        }
    }


}
