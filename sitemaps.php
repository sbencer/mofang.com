<?php

if(PHP_SAPI != 'cli')
{
    header('location: sitemaps.xml');
    exit;
} 

define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';

pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('param', '', 0);

class googlesitemap {
	function __construct() {
		$this->header = "<\x3Fxml version=\"1.0\" encoding=\"UTF-8\"\x3F>\n\t<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
	    $this->charset = "UTF-8";
	    $this->footer = "\t</urlset>\n";
		$this->items = array();
		//生成欄目級別選項
        $this->siteid = 1;
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
	}
	
	function add_item2($new_item) {
        $this->items[] = $new_item;
    }
    
	function build( $file_name = null ) {
        $map = $this->header . "\n";
        foreach ($this->items AS $item){
            $map .= "\t\t<url>\n\t\t\t<loc>$item[loc]</loc>\n";
            $map .= "\t\t\t<lastmod>$item[lastmod]</lastmod>\n";
            $map .= "\t\t\t<changefreq>$item[changefreq]</changefreq>\n";
            $map .= "\t\t\t<priority>$item[priority]</priority>\n";
            $map .= "\t\t</url>\n\n";
        }
        $map .= $this->footer . "\n";
        if (!is_null($file_name)){
            	return file_put_contents($file_name, $map);
        	} else {
            	return $map;
        }
    }
  
	function google_sitemap_item($loc, $lastmod = '', $changefreq = '', $priority = '') {
		$data = array();
		$data['loc'] =  $loc;
		$data['lastmod'] =  $lastmod;
		$data['changefreq'] =  $changefreq;
		$data['priority'] =  $priority;
		return $data;
    } 
    
	/**
	 * 
	 * Enter 生成google sitemap, 百度新聞協議
	 */
	function set ($request) {
		$hits_db = pc_base::load_model('hits_model');
		
		//讀站點緩存
		$siteid = $this->siteid;
		$sitecache = getcache('sitelist','commons');
		//根據當前站點,取得文件存放路徑
  		$systemconfig = pc_base::load_config('system');
 		$html_root = substr($systemconfig['html_root'], 1);
 		//判斷當前站點目錄,是PHPCMS則把文件寫到根目錄下, 不是則寫到分站目錄下.(分站目錄用由靜態文件路經html_root和分站目錄dirname組成)
 		if($siteid==1){
 			$dir = PHPCMS_PATH;
 		}else {
 			$dir = PHPCMS_PATH.$html_root.DIRECTORY_SEPARATOR.$sitecache[$siteid]['dirname'].DIRECTORY_SEPARATOR;
 		}
 		//模型緩存
 		$modelcache = getcache('model','commons');
 		
 		//獲取當前站點域名,下面生成URL時會用到.
 		$this_domain = substr($sitecache[$siteid]['domain'], 0,strlen($sitecache[$siteid]['domain'])-1);

        //生成網站地圖
        $content_priority = $request['content_priority'];
        $content_changefreq = $request['content_changefreq']; 
        $num = $request['num'] ? intval($request['num']) : 100;
        
        $today = date('c');
        $domain = $this_domain;
        //生成地圖頭部　－第一條
        $smi = $this->google_sitemap_item($domain, $today, 'hourly', '1.0');
        $this->add_item2($smi);
        
        $this->content_db = pc_base::load_model('content_model');
        //只提取該站點的模型.再循環取數據,生成站點地圖.
        $modelcache = getcache('model','commons');
        $new_model = array();
        foreach ($modelcache as $modelid => $mod){
            if($mod['siteid']==$siteid){
                $new_model[$modelid]['modelid'] = $modelid;
                $new_model[$modelid]['name'] = $mod['name'];						
            }
        }

        $category_cache = $this->categorys;//欄目緩存
        $this->content_db = pc_base::load_model('content_model');
        foreach ($category_cache as $category) {
            if($category['issearch'] == 1) {

                if(!strstr($category['url'], '.php')) {
                    $smi = $this->google_sitemap_item($category['url'], $today, 'daily', '0.9');//推薦文件
                    $this->add_item2($smi);
                }

                $modelid = $category['modelid'];//根據欄目ID查出modelid 進而確定表名,並結合欄目ID:catid 檢索出對應欄目下的新聞條數
                $this->content_db->set_model($modelid);
                $result = $this->content_db->select("`catid`={$category['catid']} AND `status`=99 AND `url` LIKE 'http://www.mofang.com.tw/%'", '*', $limit = "0, $num", 'id desc');
                foreach ($result as $arr){
                    if(!strstr($arr['url'], '.php')) {
                        if(substr($arr['url'],0,1)=='/'){
                            $url = new_html_special_chars(strip_tags($domain.$arr['url']));
                        }else {
                            $url = new_html_special_chars(strip_tags($arr['url']));
                        }
                        $hit_r = $hits_db->get_one(array('hitsid'=>'c-'.$modelid.'-'.$arr['id']));
                        if($hit_r['views']>1000) $content_priority = 0.8;
                        $smi    = $this->google_sitemap_item($url, date('c', $arr['updatetime']), $content_changefreq, $content_priority);//推薦文件
                        $this->add_item2($smi);
                    }
                }
            } 
        }

        $sm_file = $dir.'sitemaps.xml';
        if($this->build($sm_file)){
            echo "Sucess!\n";
        }  
	}
} 

$request = array(
    'tabletype'=>'www_',
    'content_priority'=>'0.5',
    'content_changefreq'=>'weekly',//daily,monthly……
    'num'=>'30',
    'mark'=>'1',
    'time'=>'40',
    'email'=>'phpcms@phpcms.cn',
);
//当然你可以通过外部传递参数，修改$request的值
$maps = new googlesitemap();
$maps->set($request);


?>
