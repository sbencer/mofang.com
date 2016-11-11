<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型緩存路徑
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//定義在單獨操作內容的時候，同時更新相關欄目頁面
define('RELATION_HTML',true);

define('CNINFO_URL', 'http://itunes.apple.com/lookup?country=cn&id=');
define('TWINFO_URL', 'http://itunes.apple.com/lookup?country=tw&id=');
define('USINFO_URL', 'http://itunes.apple.com/lookup?country=us&id=');

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
pc_base::load_app_func('util');
pc_base::load_sys_class('format','',0);

class collect {

	public function get_game_info() {

        $itunes_id = intval($_GET['itunes_id']);
        $area = $_GET['area'];

        if ($_GET['action'] == 'add') {
            $this->db = pc_base::load_model('content_model');
            $this->db->table_name = $this->db->db_tablepre.'iosgames_data';
            $exits = $this->db->get_one(array('itunes_id'=>$itunes_id),'id,itunes_id');
            if ($exits) {
                $this->db->table_name = $this->db->db_tablepre.'iosgames';
                $info = $this->db->get_one(array('id'=>$exits['id']),'title');
                $result['code'] = '2';
                $result['data'] = $info['title'];
                echo json_encode($result);
                return;
            }
        }
		$game_info = $this->parse_game_info($itunes_id, $area);
		$result = array();
		if ($game_info) {
			$result['code'] = '0';
			$result['data'] = $game_info;
		} else {
			$result['code'] = '1';
			$result['data'] = 'Failed';
		}

		echo json_encode($result);
	}

	private function parse_game_info($id, $area) {
		$gameinfo = $this->get_gameinfo($id, $area);
		if (!$gameinfo) {
			return false;
		}
		$insert_info['info']['en_title'] = $gameinfo['trackName'];
		if (isset($gameinfo['artworkUrl512'])) {
			$insert_info['info']['icon'] = $this->upload_image_to_attachments($gameinfo['artworkUrl512']);
		} else {
			$insert_info['info']['icon'] = $this->upload_image_to_attachments($gameinfo['artworkUrl60']);
		}
		//$insert_info['info']['labels'] = implode(',', $gameinfo['genres']);
		$insert_info['info']['price_number'] = $gameinfo['price'];
		$insert_info['info']['release_time'] = date('Y-m-d', strtotime($gameinfo['releaseDate']));
		$insert_info['info']['author_name'] = $gameinfo['artistName'];
		$insert_info['info']['stars'] = round($gameinfo['averageUserRating']);
		if (in_array('EN', $gameinfo['languageCodesISO2A'])) {
			$insert_info['info']['language'] = '英文';
		} else {
			$insert_info['info']['language'] = '簡體中文';
		}
		$insert_info['info']['platform'] = '4.3';
		$insert_info['info']['version'] = $gameinfo['version'];
		$insert_info['info']['filesize'] = $gameinfo['fileSizeBytes'];
		$insert_info['info']['itunes_id'] = $gameinfo['trackId'];
		$insert_info['info']['author_itunes_id'] = $gameinfo['artistId'];
		$insert_info['info']['content'] = preg_replace("/\n|\r\n/", '<br />', htmlspecialchars($gameinfo['description']));
		$insert_info['package_fileurl'] = $gameinfo['trackViewUrl'];
		if ($gameinfo['screenshotUrls']) {
			foreach ($gameinfo['screenshotUrls'] as $url) {
				$insert_info['screenshots_url'][] = $this->upload_image_to_attachments($url);
			}
		}
		return $insert_info;
	}

	private function upload_image_to_attachments($imgurl) {
	    $icon_content = $this->get_content($imgurl);
	    if ($icon_content) {
	        $tmp_file = sys_get_temp_dir() . '/' . basename($imgurl);
	        file_put_contents($tmp_file, $icon_content);

	        $params = array();
	        $params['Filename'] = basename($tmp_file);
	        $params['isadmin'] = 1;
	        $params['SWFUPLOADSESSID'] = '1370165345';
	        $params['userid'] = '8';
	        $params['swf_auth_key'] = '9aa2a15c47c48d207b52da2178cc869a';
	        $params['siteid'] = '1';
	        $params['module'] = 'content';
	        $params['watermark_enable'] = '0';
	        $params['dosubmit'] = '1';
	        $params['filetype_post'] = 'gif|jpg|jpeg|png';
	        $params['catid'] = '20';
	        $params['Upload'] = 'Submit Query';
	        $params['Filedata'] = '@' . $tmp_file;

	        $url = get_category_url('www') . '/index.php?m=attachment&c=attachments&a=swfupload&dosubmit=1';
	        $cookie = 'cYpqt_siteid=dc83AQZWBwZTUlVVAANYCgUHDAZUDwZQAFIJBAMH;';
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array('mofang-collect: 1', 'cookie: cYpqt_siteid=dc83AQZWBwZTUlVVAANYCgUHDAZUDwZQAFIJBAMH;'));
	        $ret = curl_exec($ch);
	        $info = curl_getinfo($ch);

	        unlink($tmp_file);

	        if ($ret && $info['http_code'] == 200) {
	            $retarr = explode(',', $ret);
	            $newurl = $retarr[1];
	            return $newurl;
	        } else {
	            return $imgurl;
	        }
	    } else {
	        return $imgurl;
	    }
	}

	private function get_gameinfo($id, $area) {
        if ($area == 'cn') {
            $cninfo_json = $this->get_content(CNINFO_URL . $id);
            if ($cninfo_json) {
                $arr = json_decode($cninfo_json, true);
                if (isset($arr['resultCount']) && $arr['resultCount'] == 1) {
                    $gameinfo = $arr['results'][0];
                } else {
                    return false;
                }
                $usinfo_json = $this->get_content(USINFO_URL . $id);
                if ($usinfo_json) {
                    $arr = json_decode($usinfo_json, true);
                    if (isset($arr['resultCount']) && $arr['resultCount'] == 1) {
                        $gameinfo['trackName'] = $arr['results'][0]['trackName'];
                    }
                }
            }
        } else if ($area == 'tw') {
            $twinfo_json = $this->get_content(TWINFO_URL . $id);
            if ($twinfo_json) {
                $arr = json_decode($twinfo_json, true);
                if (isset($arr['resultCount']) && $arr['resultCount'] == 1) {
                    $gameinfo = $arr['results'][0];
                } else {
                    return false;
                }
            }
        } else if ($area == 'us') {
            $usinfo_json = $this->get_content(USINFO_URL . $id);
            if ($usinfo_json) {
                $arr = json_decode($usinfo_json, true);
                if (isset($arr['resultCount']) && $arr['resultCount'] == 1) {
                    $gameinfo = $arr['results'][0];
                } else {
                    return false;
                }
            }
        }
        if ($gameinfo) {
            return $gameinfo;
        } else {
            return false;
        }
	}

	private function get_content($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$ret = curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($ret && $info['http_code'] == 200) {
			return $ret;
		} else {
			return false;
		}
	}

}
?>
