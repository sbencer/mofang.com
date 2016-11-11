<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 点击统计
 */
$db = '';
$db = pc_base::load_model('content_model');
define('SYS_TIEM', time());

switch($_GET['act']) {
	case 'aniComic':
		aniComic();
	    break;
	case 'Manga':
        Manga();
	    break;	
	case 'ajax_gettopparent':
		ajax_gettopparent($_GET['id'],$_GET['keyid'],$_GET['callback'],$_GET['path']);
	    break;		
}

function aniComic() {
    global $db, $http;

    $data = array(
        'Command'=>'GetNew',
        'Language'=>'zh-tw'
    );
    $json = urlencode(json_encode($data));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://jp1.dna64.com/aniComic_Japan/WebAPI.php?json='.$json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);

    $result = json_decode($response, true);
    if(count($result['List']) == 5) {
        $db->query("SELECT id,cartoon_id FROM `acg_cartoon` WHERE `catid`=46");
        $oldcid = $db->fetch_array();
        foreach($oldcid as $oldid) {
            $oldcids[$oldid['cartoon_id']] = $oldid['id']; 
        }
        $db->query("update acg_cartoon set listorder=255 where catid=46");
        foreach($result['List'] as $key=>$val) {
            if(array_key_exists($val['ID'], $oldcids)) {
                foreach($val['EpisodeList'] as $k=>$v) {
                    $content[$k]['eid'] = $v;
                    $content[$k]['title'] = "第".($k+1)."話";
                }
                $content_str = array2string($content);
                $db->query("update acg_cartoon set listorder={$key},updatetime=".SYS_TIME." where id={$oldcids[$val['ID']]}");
                $db->query("update acg_cartoon_data set episode_list='{$content_str}' where id={$oldcids[$val['ID']]}");
            } else {
                $title = mysql_escape_string($val['Title']);
                $description = mysql_escape_string($val['Description']);
                $db->query("insert into acg_cartoon (listorder,catid,partner,status,title,description,cartoon_id,author_id,thumb,updatetime,inputtime) values({$key},46,2,99,'{$title}','{$description}',{$val['ID']},{$val['AID']},'{$val['Cover']}',".SYS_TIME.",".SYS_TIME.")");    

                $id = $db->insert_id();
                foreach($val['EpisodeList'] as $key=>$val) {
                    $content[$key]['eid'] = $val;
                    $content[$key]['title'] = "第".($key+1)."話";
                }
                $content_str = array2string($content);
                $db->query("insert into acg_cartoon_data (id,episode_list) values({$id},'{$content_str}')");
                // 生成第一节url作为漫画url
                $url = APP_PATH."cartoon/anicomic/46-{$id}-{$content[0]['eid']}.html";
                $db->query("update acg_cartoon set url='{$url}'  where id={$id}");
                //添加统计
                $hits_db = pc_base::load_model('hits_model');
                $hitsid = 'c-14-'.$id;
                $hits_db->insert(array('hitsid'=>$hitsid,'catid'=>46,'updatetime'=>SYS_TIME));
            }
        }
        echo 'Sucess';
    } else {
        echo 'Failds';
    }
}

function Manga() {
    global $db;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://manga.hk/api/cooperator/recommend');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);

    $result = json_decode($response, true);
    if($result['status'] == 'success') {
        //查询catid=47 栏目下所有数据 （ 这些数据是提前添加好的 ） 
        $db->query("SELECT id,cartoon_id FROM `acg_cartoon` WHERE `catid`=47");
        $oldcid = $db->fetch_array();
        foreach($oldcid as $oldid) {
            //漫画接口中的ID和文章的ID 对应起来 
            $oldcids[$oldid['cartoon_id']] = $oldid['id'];
        }

        $db->query("update acg_cartoon set listorder=9999 where partner=1");
        //循环处理接口中数据 
        foreach($result['data'] as $key => $val) {
            if(array_key_exists($val['id'], $oldcids)) {//漫画ID在栏目中已经存在 ，则进行处理 
                foreach($val['episodes'] as $k=>$v) {
                    $content[$k]['eid'] = $v['id'];
                    $content[$k]['title'] = $v['title'];
                }
                $content_str = array2string($content);
                // 更新文章的排序值
                $db->query("update acg_cartoon set listorder={$key},updatetime=".SYS_TIME." where id={$oldcids[$val['id']]}");
                // 把漫画数据存入字段中
                $db->query("update acg_cartoon_data set episode_list='{$content_str}' where id={$oldcids[$val['id']]}");
            } else {
                $db->query("insert into acg_cartoon (listorder,catid,partner,status,title,description,cartoon_id,thumb,inputtime,updatetime) values({$key},47,1,99,'{$val['title']}','{$val['description']}',{$val['id']},'{$val['image_url']}',".SYS_TIME.",".SYS_TIME.")");    
                $id = $db->insert_id();
                foreach($val['episodes'] as $k=>$v) {
                    $content[$k]['eid'] = $v['id'];
                    $content[$k]['title'] = $v['title'];
                }
                $content_str = array2string($content);
                $db->query("insert into acg_cartoon_data (id,episode_list) values({$id},'{$content_str}')");
                // 生成第一节url作为漫画url
                $url = APP_PATH."cartoon/manga/47-{$id}-{$content[0]['eid']}.html";
                $db->query("update acg_cartoon set url='{$url}'  where id={$id}");
                //添加统计
                $hits_db = pc_base::load_model('hits_model');
                $hitsid = 'c-14-'.$id;
                $hits_db->insert(array('hitsid'=>$hitsid,'catid'=>47,'updatetime'=>SYS_TIME));
            }
        }
        echo 'Sucess';
    } else {
        echo 'Failds';    
    }
}


