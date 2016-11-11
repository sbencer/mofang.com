<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class ipbanned_model extends model {
	public $table_name = '';
	public function __construct() {
			$this->db_config = pc_base::load_config('database');
			$this->db_setting = 'default';
			$this->table_name = 'ipbanned';
			parent::__construct();
	}
	
  	/**
 	 * 
 	 * 把IP進行格式化，統一為IPV4， 參數：$op --操作類型 max 表示格式為該段的最大值，比如：192.168.1.* 格式化為：192.168.1.255 ，其它任意值表示格式化最小值： 192.168.1.1
 	 * @param $op	操作類型,值為(min,max)
 	 * @param $ip	要處理的IP段(127.0.0.*) 或者IP值 (127.0.0.5)
 	 */
	public function convert_ip($op,$ip){
		  $arr_ip = explode(".",$ip); 
		  $arr_temp = array();
		  $i = 0;
		  $ip_val= $op== "max" ? "255":"1"; 
		  foreach($arr_ip as $key => $val ){ 
		    $i++; 
		    $val = $val== "*" ? $ip_val:$val; 
		    $arr_temp[]= $val; 
		  } 
		  for($i=4-$i;$i>0;$i--){ 
		    $arr_temp[]=$ip_val; 
		  } 
		  $comma = ""; 
		  foreach($arr_temp as $v){ 
		    $result.= $comma.$v; 
		    $comma = "."; 
		  } 
		  return $result; 
	}
	
	/**
	 * 
	 * 判斷IP是否被限並返回
	 * @param $ip		當前IP	
	 * @param $ip_from	開始IP段
	 * @param $ip_to	結束IP段
	 */
	public function ipforbidden($ip,$ip_from,$ip_to){ 
		$from = strcmp($ip,$ip_from); 
		$to = strcmp($ip,$ip_to); 
		if($from >=0 && $to <= 0){ 
		return 0; 
		} else {
		return 1; 
		}
	}
	
	/**
	 * 
	 * IP禁止判斷接口,供外部調用 ...
	 */
	public function check_ip(){
		$ip_array = array();
		//當前IP
		$ip = ip();
 		//加載IP禁止緩存
		$ipbanned_cache = getcache('ipbanned','commons');
		if(!empty($ipbanned_cache)) {
			foreach($ipbanned_cache as $data){
				$ip_array[$data['ip']] = $data['ip'];
				//是否是IP段
				if(strpos($data['ip'],'*')){
					$ip_min = $this->convert_ip("min",$data['ip']);
					$ip_max = $this->convert_ip("max",$data['ip']);
					$result = $this->ipforbidden($ip,$ip_min,$ip_max);
					if($result==0 && $data['expires']>SYS_TIME){
						//被封
						showmessage('你在IP禁止段內,所以禁止你訪問');
					}
				} else {
					//不是IP段,用絕對匹配
					if($ip==$data['ip']&& $data['expires']>SYS_TIME){
						showmessage('IP地址絕對匹配,禁止你訪問');
					}
				}
			}
		}
	}
}
?>