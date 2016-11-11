<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index {
	private $setting, $catid, $contentid, $siteid, $mood_id;
	public function __construct() {
		$this->setting = getcache('mood_program', 'commons');
		
		
		$this->mood_id = isset($_GET['id']) ? $_GET['id'] : '';
		if(!strpos($this->mood_id,"|")){
		if(!preg_match("/^[a-z0-9_\-]+$/i",$this->mood_id)) showmessage((L('illegal_parameters')));
		}
		if (empty($this->mood_id)) {
			showmessage(L('id_cannot_be_empty'));
		}
		list($this->catid, $this->contentid, $this->siteid) = id_decode($this->mood_id);
		
		$this->setting = isset($this->setting[$this->siteid]) ? $this->setting[$this->siteid] : array();
		
		foreach ($this->setting as $k=>$v) {
			if (empty($v['use'])) unset($this->setting[$k]);
		}
		
		define('SITEID', $this->siteid);
	}
	
	//顯示心情
	public function init() {
		$mood_id =& $this->mood_id;
		$setting =& $this->setting;
		$mood_db = pc_base::load_model('mood_model');
		$data = $mood_db->get_one(array('catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid));
		foreach ($setting as $k=>$v) {
			$setting[$k]['fields'] = 'n'.$k;
			if (!isset($data[$setting[$k]['fields']])) $data[$setting[$k]['fields']] = 0;
			if (isset($data['total']) && !empty($data['total'])) {
				$setting[$k]['hei'] = ceil(($data[$setting[$k]['fields']]/$data['total']) * 200)?:2;
				$setting[$k]['per'] =floor($data[$setting[$k]['fields']]/$data['total']*100);
			} else {
                $setting[$k]['per'] = 0;
                $setting[$k]['hei'] = 2;
			}
		}

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $smarty->assign('setting', $setting);
        $smarty->assign('data', $data);
        $smarty->assign('mood_id', $mood_id);
        $smarty->assign('is_init', true);
        $html = $smarty->fetch('content/biaotai.tpl');
        
        header("Content-type:application/x-javascript");
        echo format_js($html);

        /*
        ob_start();
		include template('mood', 'index');
		$html = ob_get_contents();
		ob_clean();
        echo format_js($html);
         */
	}
	
	//提交選中
	public function post() {
		if (isset($_GET['callback']) && !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $_GET['callback']))  unset($_GET['callback']);
		$mood_id =& $this->mood_id;
		$setting =& $this->setting;
		$cookies = param::get_cookie('mood_id');
		$cookie = explode(',', $cookies);
		if (in_array($this->mood_id, $cookie)) {
			$this->_show_result(0, L('expressed'));
		} else {
			$mood_db = pc_base::load_model('mood_model');
			$key = isset($_GET['k']) && intval($_GET['k']) ? intval($_GET['k']) : '';
			$fields = 'n'.$key;
			if ($data = $mood_db->get_one(array('catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid))) {
				$mood_db->update(array('total'=>'+=1', $fields=>'+=1', 'lastupdate'=>SYS_TIME), array('id'=>$data['id']));
				$data['total']++;
				$data[$fields]++;
			} else {
				$mood_db->insert(array('total'=>'1', $fields=>'1', 'catid'=>$this->catid, 'siteid'=>$this->siteid, 'contentid'=>$this->contentid,'
				lastupdate'=>SYS_TIME));
				$data['total'] = 1;
				$data[$fields] = 1;
			}
			param::set_cookie('mood_id', $cookies.','.$mood_id);
			foreach ($setting as $k=>$v) {
				$setting[$k]['fields'] = 'n'.$k;
				if (!isset($data[$setting[$k]['fields']])) $data[$setting[$k]['fields']] = 0;
				if (isset($data['total']) && !empty($data['total'])) {
					$setting[$k]['hei'] = ceil(($data[$setting[$k]['fields']]/$data['total']) * 200)?:2;
                    $setting[$k]['per'] =floor($data[$setting[$k]['fields']]/$data['total']*100);
                } else {
                    $setting[$k]['per'] = 0;
                    $setting[$k]['hei'] = 2;
                }
			}
            require(PC_PATH."init/smarty.php");
            $smarty = use_v4();
            $smarty->assign('setting', $setting);
            $smarty->assign('data', $data);
            $smarty->assign('mood_id', $mood_id);
            $smarty->assign('is_init', false);
            $html = $smarty->fetch('content/biaotai.tpl');

            $this->_show_result(1,$html);
            /*
			ob_start();
			include template('mood', 'index');
			$html = ob_get_contents();
			ob_clean();
            $this->_show_result(1,$html);
             */
		}
	}
	
	//顯示AJAX結果
	protected function _show_result($status = 0, $msg = '') {
		if(CHARSET != 'utf-8') {
			$msg = iconv(CHARSET, 'utf-8', $msg);
		}
		exit(trim_script($_GET['callback']).'('.json_encode(array('status'=>$status, 'data'=>$msg)).')');
	}
	public function mf_good(){
		if(isset($_GET['id']) && !empty($_GET['id'])){
			list($catid,$id) = explode("|",trim($_GET['id']));
			$mood_db = pc_base::load_model('mood_model');
			$plan = json_decode($_GET['code']);
			if($plan <0){
				$plan_p = "n5";
			}else{
				$plan_p = "n7";
			}
            $rs = $mood_db->get_one(array("catid"=>$catid,"contentid"=>$id));
            if(!$rs){
                $ins_rs = $mood_db->insert(array("catid"=>$catid,"contentid"=>$id,"siteid"=>1,$plan_p=>1,"lastupdate"=>time()));			
            }else{
                $ins_rs = $mood_db->update(array($plan_p=>"+=1","lastupdate"=>time()),"catid =".$catid." AND contentid =".$id);					
            }
            if($ins_rs){
                $arr = array(
                    "code"=>0,
                    "catid_id"=>$_GET['id']
                );		
            }else{
                $arr = array(
                    "code"=>1
                );
            }
		}else{
			$arr = array(
					"code"=>1
				);
		}
        $response = json_encode($arr);
        // jsonp 調用,360靜態頁面時增加
		$callback = $_GET['callback'];
        if (isset($callback)) {
            $response = $callback."(".$response.");";
        }
		echo $response; 
	}
}
