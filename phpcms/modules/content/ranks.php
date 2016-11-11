<?php
defined('IN_PHPCMS') or exit('No permission resources.');

class ranks {
	private $db;
	private $idb;
	function __construct() {
		$this->db = pc_base::load_model('ranks_model');
		$this->idb = pc_base::load_model('menu_model');
		$this->idb->table_name = $this->db->db_tablepre.'iosgames';
		$this->adb = pc_base::load_model('content_model');
		$this->adb->table_name = $this->db->db_tablepre.'androidgames';
		$this->rdb = pc_base::load_model('comment_model');
		$this->rdb->table_name = $this->db->db_tablepre.'ranks_relation';

		

		$this->ch = curl_init();
		$this->user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36';

	}

	// 蘋果app store apple()
	// 91 iphone周榜 weeki91()
	// 當樂周榜top100 week100dcn()

	// 360飆升榜 rise360()
	// wo商店top100 week100wo()
	// 91手機助手 shoujizhushou()
	// 豌豆莢周榜 wandoujia()
	// 百度應用中心 baidu()
	// 應用寶 myapp()
	// 安卓市場總榜 hiapk()
	// 機鋒市場遊戲排行 gfan()

	public function init(){
		include template('content','rank_home');
	}

	public function lists() {

		$ios = array('apple'=>'蘋果App Store','91'=>'91 iPhone周榜','dcn'=>'當樂iPhone周榜');
		$android = array('360'=>'360飆升榜','wo'=>'wo商店top10','shoujizhushou'=>'91手機助手','wandoujia'=>'豌豆莢周榜','baidu'=>'百度應用中心','myapp'=>'應用寶','hiapk'=>'安卓市場總榜','gfan'=>'機鋒市場排行');
		
		// ranklist($$_GET['t']);
		foreach ($$_GET['t'] as $key => $value) {
			$data[$value] = $this->db->select(array('website'=>$key),'*',10);
		}
		// var_dump($data);
		foreach ($data as $site => $value) {
			// echo $key;
			foreach ($value as $key => $value) {
				if($value['lid'] != 0){
					if($_GET['t'] == 'ios'){
						$data[$site][$key]['info'] = $this->idb->get_one(array('id'=>$value['lid']));
					}else {
						$data[$site][$key]['info'] = $this->adb->get_one(array('id'=>$value['lid']),'url,icon,description,thumb');
					}
				}else{
					$data[$site][$key]['info'] = array('id'=>false,'url'=>'javascript:;');
				}
			}
		}
		// var_dump($data);
		include template('content','rank_list');

		// $this->getlid();
	}


	public function oneday(){
		$data = $this->apple();
	}

	public function oneweek(){
		$data = $this->weeki91();
		$data = $this->week100dcn();

		$data = $this->rise360();
		$data = $this->week100wo();
		$data = $this->shoujizhushou();
		$data = $this->wandoujia();
		$data = $this->baidu();
		$data = $this->myapp();
		$data = $this->hiapk();
		$data = $this->gfan();
	}


	// 存庫操作
	private function save($data,$platform){

		$info['date'] = time();
		$info['website'] = $data['website'];
		$info['platform'] = $platform;

		foreach ($data['rank'] as $key => $value) {
			$info['rid'] = $key;
			$info['name'] = $value;
			$info['lid'] = $this->getlid($value,$platform);

			// var_dump($info);
			$this->db->insert($info);
		}
	}

	function edit(){
		$data = trim($_GET['data']);
		$info = explode('-', $data);
		// var_dump($info);
		if(count($info) == 3){
			$gname = $info[0];
			$rid   = $info[1];
			$lid   = $info[2];
			
			// 更新採集庫關聯
			$this->updata(array('lid'=>$lid),array('id'=>$rid));
		}else{
			return false;
		}
	}

	public function getlid($gname,$platform){
		$r = $this->rdb->get_one(array('gname'=>addslashes($gname),'platform'=>$platform),'lid');
		// var_dump($r['lid']);
		return $r['lid'];
	}

	function othernames(){

	}

	function insertiosrelation(){
		$this->adb->table_name = $this->db->db_tablepre.'ranks_relation';
		$ginfo = $this->idb->select();
		// var_dump($ginfo);
		// $data['id'] = null;
		$data['platform'] = 'ios';
		foreach ($ginfo as $key => $value) {
			$data['lid'] = $value['id'];
			$data['gname'] = $value['title'];
			// $data[$value['id']] = $value['title'];
			$this->adb->insert($data);
			// $r = $this->adb->select();

		}

		// var_dump($r);
	}

	function insertandroidrelation(){
		
		$ginfo = $this->adb->select();
		$this->adb->table_name = $this->db->db_tablepre.'ranks_relation';
		// var_dump($ginfo);
		// $data['id'] = null;
		$data['platform'] = 'android';
		foreach ($ginfo as $key => $value) {
			$data['lid'] = $value['id'];
			$data['gname'] = $value['title'];
			// $data[$value['id']] = $value['title'];
			$this->adb->insert($data);
			// $r = $this->adb->select();

		}

		// var_dump($r);
	}

	// public function getioslid($gname){
	// 	$r = $this->idb->get_one(array('title'=>addslashes($gname)),'id');
	// 	// $r = $this->idb->select("title='".addslashes($gname)."' or en_title='".addslashes($gname)."'","id");
	// 	return $r['id'];
	// }

	// public function getandroidlid($gname){
	// 	$r = $this->adb->get_one(array('title'=>addslashes($gname)),'id');
	// 	// $r = $this->idb->select("title='".addslashes($gname)."' or en_title='".addslashes($gname)."'","id");
	// 	return $r['id'];
	// }

	// 91 iphone周榜
	private function weeki91(){
		$platform = 'ios';

		$url = 'http://play.91.com/index.php?a=getList&m=Rank&cg=1&device=iphone';
		$referer = 'http://play.91.com/iphone/Rank/index-1.html';

		curl_setopt($this->ch,CURLOPT_URL,$url);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($this->ch,CURLOPT_REFERER,$referer);
		
		// 不將結果輸出到屏幕
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);	

		$result = curl_exec($this->ch);
		$json = json_decode($result);

		// var_dump($json->content);
		$data['website'] = '91';

		foreach ($json->content as $value) {
			$data['rank'][$value->index] = addslashes($value->name);
			// var_dump($value);
		}
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 應用寶
	private function myapp(){
		$platform = 'android';

		$url = 'http://android.myapp.com/android/qrycategoryranking_web?cid=120&ranktype=0&icfa=15144206000120000000&pageNo=1&pageIndex=1&pageSize=100&r=0.28331757662817836';
		$referer = 'http://android.myapp.com/android/game.jsp';

		curl_setopt($this->ch,CURLOPT_URL,$url);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($this->ch,CURLOPT_REFERER,$referer);
		
		// 不將結果輸出到屏幕
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);	

		$result = curl_exec($this->ch);
		$json = json_decode($result);

		// var_dump($json->info);
		$data['website'] = 'myapp';
		$data['rank'][0] = '';

		foreach ($json->info->value as $value) {
			$data['rank'][] = addslashes($value->softname);
			// var_dump($value);
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// wo商店top100
	private function week100wo(){
		$platform = 'android';

		$url = 'http://store.wo.com.cn/indexPage_queryWithForeignObjFreeToplist.do';
		$referer = 'http://store.wo.com.cn/indexPage_returnTop.do?mometype=1&rankType=weekly&isGame=true&flag=2&homeset=9000000000';

		curl_setopt($this->ch,CURLOPT_URL,$url);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($this->ch,CURLOPT_REFERER,$referer);

		// 我們在POST數據哦！
		$post_data = 'flag=2&pageParam.pageNo=1&pageParam.pageSize=100&mometype=1&isGame=true&rankType=weekly';
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
		
		// 不將結果輸出到屏幕
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);	

		$result = curl_exec($this->ch);
		$json = json_decode($result);

		// var_dump($json->result);
		$data['website'] = 'wo';

		foreach ($json->result as $key => $value) {
			$data['rank'][$key] = addslashes($value->cnname);
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 當樂周榜top100
	private function week100dcn(){
		$platform = 'ios';

		$url = 'http://ios.d.cn/Utility/RankPageForAll.ashx';
		$referer = 'http://ios.d.cn/newrank/iphone.html';

		curl_setopt($this->ch,CURLOPT_URL,$url);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($this->ch,CURLOPT_REFERER,$referer);

		$data['website'] = 'dcn';
		$data['rank'][0] = '';

		$limits = array(0,20,40,60,80);
		foreach ($limits as $limit) {
		
			// 我們在POST數據哦！
			$post_data = 'currentlimit='.$limit.'&platform=iphone&AppType=Games';
			curl_setopt($this->ch, CURLOPT_POST, 1);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
			
			// 不將結果輸出到屏幕
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);	

			$result = curl_exec($this->ch);
			$json = json_decode($result);

			// var_dump($json);

			foreach ($json->DataByWeek as $key => $value) {
				$data['rank'][] = addslashes($value->Name);
			}
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 360飆升榜 
	private function rise360(){
		$platform = 'android';

		$data['website'] = '360';
		$data['rank'][] = '';
		for ($i=1; $i <= 21; $i++) { 	
			$url = 'http://zhushou.360.cn/list/index/cid/2/size/all/lang/all/order/rise/?page='.$i;
			$contents = file_get_contents($url);

			$pattern = '/"zhushou360:\/\/type=apk&name=(.*?)"/';
			preg_match_all($pattern, $contents, $matches);
			// var_dump($matches);
			foreach ($matches[1] as $value) {
				$data['rank'][] = addslashes($value);
			}
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 蘋果app store
	private function apple(){
		$platform = 'ios';

		$data['website'] = 'apple';
		$data['rank'][] = '';

		$url = 'http://itunes.apple.com/cn/genre/ios-you-xi/id6014?mt=8';
		$contents = file_get_contents($url);

		// $pattern = '/href\=\"https:\/\/itunes\.apple\.com\/cn\/app\/[^\/]+\/id\d+\?mt\=8\"\>(.*?)\<\/a\>/';
		$pattern = '/<li><a href="https:\/\/itunes\.apple\.com\/cn\/app.*?>(.*?)<\/a>/';
		preg_match_all($pattern, $contents, $matches);
		// var_dump($matches);
		foreach ($matches[1] as $value) {
			$data['rank'][] = addslashes($value);
		}

		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 豌豆莢周榜
	private function wandoujia(){
		$platform = 'android';

		$data['website'] = 'wandoujia';
		$data['rank'][] = '';
		for ($i=1; $i <= 3; $i++) { 	
			$url = 'http://www.wandoujia.com/tag/%E5%85%A8%E9%83%A8%E6%B8%B8%E6%88%8F/weekly?page='.$i;
			$contents = file_get_contents($url);

			$pattern = '/<span class="txt">(.*?)<\/span>/';
			preg_match_all($pattern, $contents, $matches);
			// var_dump($matches);
			foreach ($matches[1] as $value) {
				$data['rank'][] = addslashes($value);
			}
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 百度應用中心 
	private function baidu(){
		$platform = 'android';

		$data['website'] = 'baidu';
		$data['rank'][] = '';
		for ($i=1; $i <= 4; $i++) { 	
			$url = 'http://as.baidu.com/a/asgame?cid=102&s=1&pn='.$i;
			$contents = file_get_contents($url);

			$pattern = '/<h4><span class="tit">(.*?)<\/span><\/h4>/';
			preg_match_all($pattern, $contents, $matches);
			// var_dump($matches);
			foreach ($matches[1] as $key => $value) {
				if($key%2){
					$data['rank'][] = addslashes($value);
					// echo $key;
				}
			}
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 安卓市場總榜
	private function hiapk(){
		$platform = 'android';

		$url = 'http://apk.hiapk.com/Game.aspx?action=FindGameSoftList';
		$referer = 'http://apk.hiapk.com/games';

		curl_setopt($this->ch,CURLOPT_URL,$url);
		curl_setopt($this->ch, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($this->ch,CURLOPT_REFERER,$referer);

		$data['website'] = 'hiapk';
		$data['rank'][0] = '';

		$limits = array(1,2,3,4,5,6,7,8,9,10);
		foreach ($limits as $limit) {
		
			// 我們在POST數據哦！
			$post_data = 'currentHash='.$limit.'_1_0_0_0_0_0';
			curl_setopt($this->ch, CURLOPT_POST, 1);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);
			
			// 不將結果輸出到屏幕
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);	

			$result = curl_exec($this->ch);

			$pattern = '/alt="(.*?)"/';
			preg_match_all($pattern, $result, $matches);

			foreach ($matches[1] as $key => $value) {
				$data['rank'][] = addslashes($value);
			}
		}
		unset($data['rank'][0]);
		// var_dump($data);
		// return $data;
		$this->save($data,$platform);
	}

	// 機鋒市場遊戲排行
	private function gfan(){
		$platform = 'android';

		$i = 1;
		$data['website'] = 'gfan';
		$data['rank'][0] = '';

		$limits = array(1,2);
		foreach ($limits as $limit) {
			
			$url = 'http://wandoujia.apk.gfan.com/game.aspx?softCategory=8&orderBy=DownNum&CurrPage='.$limit;
			$contents = file_get_contents($url);

			$pattern = '/\/><span>(.*?)<\/span>/';
			preg_match_all($pattern, $contents, $matches);

			
			foreach ($matches[1] as $key => $value) {
				$data['rank'][] = addslashes($value);
				$i++;
				if($i>100){
					unset($data['rank'][0]);
					// var_dump($data);
					// return $data;
					break 2;
				}
			}
		}
		$this->save($data,$platform);
		
	}

	// 91手機助手
	private function shoujizhushou(){
		$platform = 'android';

		$i = 1;
		$data['website'] = 'shoujizhushou';
		$data['rank'][0] = '';

		$limits = array(1,2,3,4);
		foreach ($limits as $limit) {
			
			$url = 'http://bbx2.sj.91.com/soft/phone/list.aspx?act=239&mt=4&sv=3.3&osv=4.1&cpu=armeabi-v7a,armeabi&imei=860955021902303&nt=10&tag=1&iv=7&st=12&imsi=&pi='.$limit;
			$contents = file_get_contents($url);

			$json = json_decode($contents);
			
			foreach ($json->Result->items as $value) {
				$data['rank'][] = addslashes($value->name);
				$i++;
				if($i>100){
					unset($data['rank'][0]);
					break 2;
				}
			}
		}
		// var_dump($data);
		$this->save($data,$platform);
		
	}
}
?>