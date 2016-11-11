<?php 
/**
 * 臨時處理辦法
 */
function get_app_version(){
    return '1.2.0.00';
}

/**
 * 是否是測試機
 */
function is_test_server(){
    if ( strpos($_SERVER['SERVER_ADDR'], '192.168.1') === 0 ) return true;
    return false;
}

/**
 * 獲取簽名
 *
 * @param array $data
 * @param string $key // 驗證信息
 * secret: a221371a59d37f34ad600baa4c64223c
 * @return string
 */
function getsign($data,$key=''){
    if(empty($key)){
        $secret = 'a221371a59d37f34ad600baa4c64223c';
    }else{
        $secret = $key;
    }
    ksort($data);

    $_tmp = '';
    foreach ($data as $k => $v) {
        $_tmp .= $k .'='. $v;
    }

    return md5($_tmp . $secret);
}

/**
  * 判斷是否wap頁
  */
function is_wap(){
    $domain = $_SERVER['HTTP_HOST'];

    if ($domain) {
        $domains = pc_base::load_config('domains');
        $wap_domain_array = array(
            $domains['wap_domain'],
            $domains['wap_m_domain'],
            $domains['wap_a_domain'],
            $domains['wap_c_domain'],
            $domains['wap_v_domain'],
            $domains['wap_i_domain'],
            $domains['fahao_m_domain'],
            $domains['wap_chinajoy_domain'],
            $domains['wap_tgc_domain'],
            $domains['wap_h5_domain'],
            $domains['wap_tu_domain']
        );

        $is_wap = false;
        foreach($wap_domain_array as $key=>$value){
            if(strstr($domain, $value)){
                $is_wap = true;
                break;
            }
        }
    }

    if($is_wap!==false){
        return true;
    }else{
        return false;
    }
}

/*
 * 生成web頁地址
 *
 **/
function pc_url($url){
    $domain = $url;
    $mobile_domain = pc_base::load_config('domains','mobile_domain');
    if ($mobile_domain) {

        $domains = pc_base::load_config('domains');
        $mobile_exclude_domain = pc_base::load_config('domains','mobile_exclude_domain');

        $is_exclude=0;
        foreach($mobile_exclude_domain as $k_me=>$v_me){
            if( strstr($domain, $v_me)!==false ){
                $is_exclude=1;
                break;
            }
        }
        if(!$is_exclude){
            if( strstr($url, $domains['fahao_m_domain']) ) {
                $base_domain = $domains['fahao_domain'];
                $mobile_domain = $domains['fahao_m_domain'];
             } else if( strstr($url, $domains['wap_chinajoy_domain']) ){//chinajoy.mofang.com
                $base_domain = $domains['web_chinajoy_domain'];
                $mobile_domain = $domains['wap_chinajoy_domain'];
            } else if( strstr($url, $domains['wap_domain']) ){//www.m.mofang.com
                $base_domain = $domains['web_domain'];
                $mobile_domain = $domains['wap_domain'];
            }else if (strstr($url, $domains['wap_a_domain'])){//a.mofang.com
                $base_domain = $domains['web_a_domain'];
                $mobile_domain = $domains['wap_a_domain'];
            }else if(strstr($url, $domains['wap_c_domain'])){//c.mofang.com
                $base_domain = $domains['web_c_domain'];
                $mobile_domain = $domains['wap_c_domain'];
            }else if (strstr($url, $domains['wap_i_domain'])){//i.mofang.com
                $base_domain = $domains['web_i_domain'];
                $mobile_domain = $domains['wap_i_domain'];
            }else if (strstr($url, $domains['wap_v_domain'])){//i.mofang.com
                $base_domain = $domains['web_v_domain'];
                $mobile_domain = $domains['wap_v_domain'];
            }else if(strstr($url, $domains['wap_tu_domain'])){//tu.mofang.com
                $base_domain = $domains['web_tu_domain'];
                $mobile_domain = $domains['wap_tu_domain'];
            }else if(strstr($url, $domains['wap_domain'])){//www.mofang.com
                $base_domain = $domains['web_domain'];
                $mobile_domain = $domains['wap_domain'];
            }else if(strstr($url, $domains['wap_h5_domain'])){//www.mofang.com
                $base_domain = $domains['web_h5_domain'];
                $mobile_domain = $domains['wap_h5_domain'];
            }
            $domain = str_ireplace($mobile_domain, $base_domain, $domain);
        }
    } else {
        return '';
    }
    return $domain;
}

/*
 * 生成wap頁地址
 *
 **/
function wap_url($url){
    $domain = $url;
    $mobile_domain = pc_base::load_config('domains','mobile_domain');
    if ($mobile_domain) {

        $domains = pc_base::load_config('domains');
        $mobile_exclude_domain = pc_base::load_config('domains','mobile_exclude_domain');

        $is_exclude=0;
        foreach($mobile_exclude_domain as $k_me=>$v_me){
            if( strstr($domain, $v_me)!==false ){
                $is_exclude=1;
                break;
            }
        }
        if(!$is_exclude){
            if( strstr($url, $domains['fahao_domain']) ) {
                $base_domain = $domains['fahao_domain'];
                $mobile_domain = $domains['fahao_m_domain'];
            }else if( strstr($url, $domains['web_chinajoy_domain']) ){//chinajoy.mofang.com
                $base_domain = $domains['web_chinajoy_domain'];
                $mobile_domain = $domains['wap_chinajoy_domain'];
            }else if( strstr($url, $domains['web_tgc_domain']) ){//ｔｇｃ.mofang.com
                $base_domain = $domains['web_tgc_domain'];
                $mobile_domain = $domains['wap_tgc_domain'];
            }else if( strstr($url, $domains['wap_m_domain']) ){//www.m.mofang.com
                $base_domain = $domains['wap_m_domain'];
                $mobile_domain = $domains['wap_domain'];
            }else if (strstr($url, $domains['web_a_domain'])){//a.mofang.com
                $base_domain = $domains['web_a_domain'];
                $mobile_domain = $domains['wap_a_domain'];
            }else if(strstr($url, $domains['web_c_domain'])){//c.mofang.com
                $base_domain = $domains['web_c_domain'];
                $mobile_domain = $domains['wap_c_domain'];
            }else if (strstr($url, $domains['web_i_domain'])){//i.mofang.com
                $base_domain = $domains['web_i_domain'];
                $mobile_domain = $domains['wap_i_domain'];
            }else if (strstr($url, $domains['web_v_domain'])){//i.mofang.com
                $base_domain = $domains['web_v_domain'];
                $mobile_domain = $domains['wap_v_domain'];
            }else if(strstr($url, $domains['web_tu_domain'])){//tu.mofang.com
                $base_domain = $domains['web_tu_domain'];
                $mobile_domain = $domains['wap_tu_domain'];
            }else if(strstr($url, $domains['web_domain'])){//www.mofang.com
                $base_domain = $domains['web_domain'];
                $mobile_domain = $domains['wap_domain'];
            }else if(strstr($url, $domains['web_h5_domain'])){//h5.mofang.com
                $base_domain = $domains['web_h5_domain'];
                $mobile_domain = $domains['wap_h5_domain'];
            }
            $domain = str_ireplace($base_domain, $mobile_domain, $domain);
        }
    } else {
        return '';
    }
    return $domain;
}
/*
* 設別列表頁url
* @Param
*   $action
*   $catid
*   $sid
*
**/
function fahao_url_device($action, $catid, $sid, $curr_page=false, $pagenum=0){
    switch($action){
        case 'fahao':
            $action_html = '';
            break;
        case 'taohao':
            $action_html = 'taohao';
            break;
    }

    //禮包類型
    switch($catid){
        case 0:
            $cat_html = '';
            break;
        case 1:
            $cat_html = 'libao-';
            break;
        case 2:
            $cat_html = 'xinshouka-';
            break;
        case 3:
            $cat_html = 'jihuoma-';
            break;
    }

    //設備標識
    switch($sid){
        case 1:
            $device_html = 'ios';
            break;
        case 3:
            $device_html = 'all';
            break;
        case 4:
            $device_html = 'android';
            break;
    }

    //頁碼
    if(!$pagenum){
        $page_code = ($curr_page==false) ? 1 : '{$page}';
    }else{
        $page_code = intval($pagenum);
    }
    if($action=='fahao'){
        return 'http://fahao.mofang.com.tw/'.$cat_html.$device_html.'/'.$page_code.'.html';
    }elseif($action=='taohao'){
        return 'http://fahao.mofang.com.tw/'.$action.'-'.$device_html.'/'.$page_code.'.html';
    }
}
/*
   * 發號詳情頁url
   * @Param
   *   $type_id    優惠類型id
   *   $id         優惠碼id
   *
   **/
function fahao_url_detail($type_id, $id){
    switch($type_id){
        case 1:
            $type_html = 'libao';
            break;
        case 2:
            $type_html = 'xinshouka';
            break;
        case 3:
            $type_html = 'jihuoma';
            break;
    }
    return  'http://fahao.mofang.com.tw/'.$type_html.'/'.$id.'.html';
}
/**
 * 判定數組內全部元素值為空
 */ 
function array_is_null($array){
    $asign = 0 ;
    foreach ($array as $k => $v) {
        if (trim($v) != null){
            $asign++ ;
        }
    }
    if($asign == 0){
        return true;
    }else{
        return false;
    }
}
/**
 * 開服開測分頁url規則
 */
function kaifu_url_rule($first_url,$code,$end_url){
    $code = (empty($code))? '{$page}' : '{$'.$code.'}';
    return $first_url.$code.$end_url;
}
/**
 *  extention.func.php 用戶自定義函數庫
 *
 * @copyright           (C) 2005-2010 PHPCMS
 * @license             http://www.phpcms.cn/license/
 * @lastmodify          2010-10-27
 */

/**
 * 獲取當前頁面基本URL地址
 */
function get_base_url() {
    $full_url = get_url();
    $parsed_url = parse_url($full_url);
    return sprintf('%s://%s%s', $parsed_url['scheme'], $parsed_url['host'], $parsed_url['path']);
}

/*
 * 根據url匹配catid
 *  @Param
 *      $match_rule   匹配規則
 *      $part_url   專區url
 *      $is_array   是否返回多個match
 *
 **/
function match_catid_by_url( $match_rule, $part_url, $is_array=0 ) {
    $matches = array();
    preg_match($match_rule, $part_url, $matches);
    if( $matches[1] && $is_array==1){//匹配子組
        return $matches;
    }else if($matches[1]){
        return $matches[1];
    }else{
        return "0";
    }
}

/**
  * 根據二級域名檢測返回相應url
  *
  *
  */
function partition_url(){
    $domain = str_ireplace( '.mofang.com.tw', '', $_SERVER['HTTP_HOST'] );
    if( strpos($domain, 'zc.test') === 0 ){
        return APP_PATH.'p/'.$_GET['p'].'/';
    }else if(!$GLOBALS['is_domain']){//未啟用二級域名及測試環境
        return APP_PATH.$_GET['p'].'/';
    }else{
        return 'http://'.$_SERVER['HTTP_HOST'].'/';
    }
}
/**
 * 獲取專區訪問url
 * @param partid int 專區id
 */
function partition_url2( $partid = '' ){
    $domain = str_ireplace( '.mofang.com.tw', '', $_SERVER['HTTP_HOST'] );
    if( empty($partid) && isset($_GET['p']) ){
        $partid = $_GET['p'];
    }
    $db_partition = pc_base::load_model('partition_model');
    $res = $db_partition->get_one("`catid`=".$partid, 'domain_dir,is_domain');
    $domain_dir = $res['domain_dir'];
    $is_domain = $res['is_domain'];
    if( strpos($domain, 'test') ){
        return APP_PATH.'p/'.$domain_dir.'/';
    }elseif(!$is_domain){//未啟用二級域名
        return APP_PATH.$domain_dir.'/';
    }else{
        return 'http://'.$domain_dir.'.mofang.com.tw';
    }
}

/**
 * 生成SEO
 * @param $siteid       站點ID
 * @param $catid        欄目ID
 * @param $title        標題
 * @param $description  描述
 * @param $keyword      關鍵詞
 */
function seo_partition_detail($part_mod, $siteid, $catid = '', $title = '', $description = '', $keyword = '') {
    if (!empty($title))$title = strip_tags($title);
    if (!empty($description)) $description = strip_tags($description);
    if (!empty($keyword)) $keyword = str_replace(' ', ',', strip_tags($keyword));
    $sites = getcache('sitelist', 'commons');
    $site = $sites[$siteid];
    $cat = array();
    if (!empty($catid)) {
        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
        $categorys = getcache('category_content_'.$siteid,'commons');
        $cat = $categorys[$catid];
        $cat['setting'] = string2array($cat['setting']);
    }

    $temp_seo = seo_info( $part_mod );

    $seo['keyword'] = !empty($keyword) ? $keyword : '';
    $seo['description'] = isset($description) && !empty($description) ? $description : '';
    //$seo['keyword'] = !empty($keyword) ? $keyword : $temp_seo['keyword'];
    //$seo['description'] = isset($description) && !empty($description) ? $description : $temp_seo['description'];
    $seo['title'] =  $title.' - '.$temp_seo['title'];
    foreach ($seo as $k=>$v) {
        $seo[$k] = str_replace(array("\n","\r"),    '', $v);
    }
    return $seo;
}

/**
  * SEO信息
  * @Param
    $part_mod   所屬專區
    $catid      欄目id | 空
  *
  *
  */
function seo_info( $part_mod, $catid = ''){

    $db_partition = pc_base::load_model('partition_model');

    $SEO = seo(1);
    $temp_setting = $db_partition->get_one("`domain_dir`='".$part_mod."'", 'setting,catname');
    $setting = string2array($temp_setting['setting']);

    $SEO['title'] = $setting['meta_title'] ? $setting['meta_title'] : $temp_setting['catname'];
    $SEO['keyword'] = $setting['meta_keywords'] ? $setting['meta_keywords'] : $SEO['keyword'];
    $SEO['description'] = $setting['meta_description'] ? $setting['meta_description'] : $SEO['description'];
    
    if( $catid ){//欄目SEO
        $temp_channel_setting = $db_partition->get_one("`catid`=".$catid, 'setting,catname');
        $channel_setting = string2array($temp_channel_setting['setting']);
        $channel['title'] = $channel_setting['meta_title'] ? $channel_setting['meta_title'] : $temp_channel_setting['catname'];
        $SEO['title'] = $channel['title'].' - '.$SEO['title'];
        $SEO['keyword'] = $channel_setting['meta_keywords'] ? $channel_setting['meta_keywords'] : $SEO['keyword'];
        $SEO['description'] = $channel_setting['meta_description'] ? $channel_setting['meta_description'] : $SEO['description'];
    }

    return $SEO;
}

/**
 * Balances tags of string using a modified stack.
 *
 * @since 2.0.4
 *
 * @author Leonard Lin <leonard@acm.org>
 * @license GPL
 * @copyright November 4, 2001
 * @version 1.1
 * @todo Make better - change loop condition to $text in 1.2
 * @internal Modified by Scott Reilly (coffee2code) 02 Aug 2004
 *      1.1  Fixed handling of append/stack pop order of end text
 *           Added Cleaning Hooks
 *      1.0  First Version
 *
 * @param string $text Text to be balanced.
 * @return string Balanced text.
 */
function force_balance_tags( $text ) {
    $tagstack = array();
    $stacksize = 0;
    $tagqueue = '';
    $newtext = '';
    // Known single-entity/self-closing tags
    $single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );
    // Tags that can be immediately nested within themselves
    $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

    // WP bug fix for comments - in case you REALLY meant to type '< !--'
    $text = str_replace('< !--', '<    !--', $text);
    // WP bug fix for LOVE <3 (and other situations with '<' before a number)
    $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);

    while ( preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $regex) ) {
        $newtext .= $tagqueue;

        $i = strpos($text, $regex[0]);
        $l = strlen($regex[0]);

        // clear the shifter
        $tagqueue = '';
        // Pop or Push
        if ( isset($regex[1][0]) && '/' == $regex[1][0] ) { // End Tag
            $tag = strtolower(substr($regex[1],1));
            // if too many closing tags
            if( $stacksize <= 0 ) {
                $tag = '';
                // or close to be safe $tag = '/' . $tag;
            }
            // if stacktop value = tag close value then pop
            else if ( $tagstack[$stacksize - 1] == $tag ) { // found closing tag
                $tag = '</' . $tag . '>'; // Close Tag
                // Pop
                array_pop( $tagstack );
                $stacksize--;
            } else { // closing tag not at top, search for it
                for ( $j = $stacksize-1; $j >= 0; $j-- ) {
                    if ( $tagstack[$j] == $tag ) {
                    // add tag to tagqueue
                        for ( $k = $stacksize-1; $k >= $j; $k--) {
                            $tagqueue .= '</' . array_pop( $tagstack ) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }

        } else { // Begin Tag
            $tag = strtolower($regex[1]);

            // Tag Cleaning

            // If it's an empty tag "< >", do nothing
            if ( '' == $tag ) {
                // do nothing
            }
            // ElseIf it presents itself as a self-closing tag...
            elseif ( substr( $regex[2], -1 ) == '/' ) {
                // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such and
                // immediately close it with a closing tag (the tag will encapsulate no text as a result)
                if ( ! in_array( $tag, $single_tags ) )
                    $regex[2] = trim( substr( $regex[2], 0, -1 ) ) . "></$tag";
            }
            // ElseIf it's a known single-entity tag but it doesn't close itself, do so
            elseif ( in_array($tag, $single_tags) ) {
                $regex[2] .= '/';
            }
            // Else it's not a single-entity tag
            else {
                // If the top of the stack is the same as the tag we want to push, close previous tag
                if ( $stacksize > 0 && !in_array($tag, $nestable_tags) && $tagstack[$stacksize - 1] == $tag ) {
                    $tagqueue = '</' . array_pop( $tagstack ) . '>';
                    $stacksize--;
                }
                $stacksize = array_push( $tagstack, $tag );
            }

            // Attributes
            $attributes = $regex[2];
            if( ! empty( $attributes ) && $attributes[0] != '>' )
                $attributes = ' ' . $attributes;

            $tag = '<' . $tag . $attributes . '>';
            //If already queuing a close tag, then put this tag on, too
            if ( !empty($tagqueue) ) {
                $tagqueue .= $tag;
                $tag = '';
            }
        }
        $newtext .= substr($text, 0, $i) . $tag;
        $text = substr($text, $i + $l);
    }

    // Clear Tag Queue
    $newtext .= $tagqueue;

    // Add Remaining text
    $newtext .= $text;

    // Empty Stack
    while( $x = array_pop($tagstack) )
        $newtext .= '</' . $x . '>'; // Add remaining tags to close

    // WP fix for the bug with HTML comments
    $newtext = str_replace("< !--","<!--",$newtext);
    $newtext = str_replace("<    !--","< !--",$newtext);

    return $newtext;
}

/**
  * 專區列表按時間排序
  *
  */
function partition_list_cmp( $a, $b ){
    if( $a['updatetime'] == $b['updatetime'] ){
        return 0;
    }
    return ($a['updatetime'] > $b['updatetime']) ? -1: 1;
}
/**
  * 專區列表按listorder排序
  *
  */
function partition_list_cmp_listorder( $a, $b ){
    if( $a['listorder'] == $b['listorder'] ){
        return 0;
    }
    return ($a['listorder'] > $b['listorder']) ? 1: -1;
}
/**
  * 專區列表按訪問量排序
  *
  */
function partition_list_cmp_views( $a, $b ){
    if( $a['views'] == $b['views'] ){
        return 0;
    }
    return ($a['views'] > $b['views']) ? -1: 1;
}

/**
 * 獲取攻略url
 * @param   catid   文章catid
 *      id  內容id
 *      short_name  所屬專區簡寫
 *      modelid     模型id()
 *
 */
function get_stra_url( $id, $modelid = 1 ){
    $db_content = pc_base::load_model('content_model');
    $db_content->set_model($modelid);
    $catid = $db_content->get_one('`id`='.$id,'catid');
    $catid = $catid['catid'];
    return partition_url().$catid.'_'.$id.'.html';
}

/**
 * 獲取資訊新聞url
 * @param   catid   文章catid
 *      id  文章id
 *      short_name  所屬專區英文標識
 * @author jozh liu
 */

function get_info_url( $catid, $id, $short_name='' ){
    // return APP_PATH.'p/'.$short_name.'/'.$catid.'_'.$id.'.html';
    // if(!empty($short_name)){
    //     return 'http://'.$short_name.'.mofang.com/'.$catid.'_'.$id.'.html';
    // }else{
        return partition_url().$catid.'_'.$id.'.html';
    // }
}

function get_part_url( $catid, $short_name = '', $curr_page = false ){
    $page_code = ($curr_page==false) ? 1 : '{$page}';
    //return APP_PATH.'p/'.$short_name.'/list_'.$catid.'_'.$page_code.'.html';
    return partition_url().'list_'.$catid.'_'.$page_code.'.html';
}
/**
 * 獲取文章內容中圖片
 *
 */
function get_content_images( $id, $num=1 ){
    $db_content = pc_base::load_model('content_model');
    $db_content->set_model(1);
    $db_content->table_name = $db_content->table_name.'_data';
    $data = $db_content->get_one('`id`='.$id, 'content');

    preg_match_all("/src=('|\")([^'\"]+)('|\")/", $data['content'], $match);
    $new = array_unique($match[0]);

    foreach($new as $key=>$val){
        if($key>$num-1){
            unset($new[$key]);
        }
    }
    return $new;
}

function html5_convert($html) {
    require_once dirname(__FILE__) . '/../../htmlpurifier/HTMLPurifier.auto.php';

    $config = HTMLPurifier_Config::createDefault();

    // configuration goes here:
    $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
    $config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype
    $config->set('HTML.BlockWrapper', 'p');
    $config->set('AutoFormat.RemoveEmpty', true);
    $config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
    $config->set('AutoFormat.AutoParagraph', true);
    $config->set('HTML.SafeEmbed', true);
    $config->set('HTML.SafeIframe', true);
    $config->set('URI.SafeIframeRegexp', '%^https://(www.youtube.com/embed/|player.vimeo.com/video/)%'); 
    $config->set('HTML.AllowedElements', array('a', 'p', 'img', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'div', 'b', 'strong', 'object', 'embed', 'br', 'font', 'iframe'));
    $config->set('CSS.AllowedProperties', array('text-align', 'width', 'height'));
    $config->set('HTML.AllowedAttributes', array(
                'a.href',
                'div.style',
                'embed.src',
                'table.border',
                'th.rowspan',
                'th.colspan',
                'td.rowspan',
                'td.colspan',
                '*.align',
                'img.src',
                'img.alt',
                'font.color',
                'iframe.src',
                ));

    $purifier = new HTMLPurifier($config);

    $html = $purifier->purify($html);
    $html = preg_replace('/<(\/)?div/', '<$1p', $html);
    $html = preg_replace('/pics\.mofang\.com/', 'pic0.mofang.com', $html);
    //$html = preg_replace('/(<img[^>]+)style\=\"[^\"]+\"/', '$1', $html);
    $html = embed2js($html);
    return $html;
}

function is_mobile() {
    return ( preg_match('/mofangapp/i', $_SERVER['HTTP_USER_AGENT']) ||
            preg_match('/\swanyou$/i', $_SERVER['HTTP_USER_AGENT'])
           );
}

function embed2js($content){
    $search1 = '/<object.*height="(.*?)".*sid\/(.*?)\/v.swf.*width="(.*?)".*<\/object>/i';
    $search2 = '/<embed.*height="(.*?)".*sid\/(.*?)\/v.swf.*width="(.*?)".*(<\/embed>|\/>)/i';
    $replace = '<iframe class="youkuplayer" width="\\3" height="\\1" src="http://player.youku.com/embed/\\2" frameborder=0 allowfullscreen></iframe>';
    $replace2 = '<div id="youkuplayer\\2"></div>
    <script>
    player\\2 = new YKU.Player("youkuplayer\\2",{
    client_id: "04a4fa40c0634318",
    vid: "\\2",
        width: \\3,
        height: \\1,
        autoplay: false,
        show_related: false
 });
      </script>';
      $content = preg_replace($search1, $replace, $content);
      $content = preg_replace($search2, $replace, $content);
    
    $search1 = '/<object.*height="(.*?)".*www\.youtube\.com\/v\/([^\?]*)\?version.*width="(.*?)".*<\/object>/i';
    $search2 = '/<embed.*height="(.*?)".*sid\/(.*?)\/v.swf.*width="(.*?)".*(<\/embed>|\/>)/i';
    $replace = '<iframe class="youkuplayer" type="text/html" width="\\3" height="\\1" src="https://www.youtube.com/embed/\\2" frameborder="0" allowfullscreen></iframe>';
    $content = preg_replace($search1, $replace, $content);
    $content = preg_replace($search2, $replace, $content);
    return $content;
}

/**
 * apk文件信息提取yu
 * @param $file 要解析到文件路徑
 * @param $tmp  解壓出來的臨時變量存放位置
 * @return array | false 成功返回詳細信息，失敗則返回false
 */
function get_apk_info($file){
    $file = pc_base::load_config('system','upload_path').$file;
    $tmp = sys_get_temp_dir() . '/';
    $binfile =  $tmp.'AndroidManifest.xml';
    $xmlfile =  $tmp.'AndroidManifest_00.xml';
    exec("/usr/bin/unzip $file AndroidManifest.xml -d $tmp",$result,$status);
    if($status == 0){
        $AXML = PHPCMS_PATH . '/statics/tool/AXMLPrinter2.jar';
        exec("java -jar '$AXML' $binfile >> $xmlfile",$result,$status);
        if($status == 0){
            $content = file_get_contents($xmlfile);
            $p = xml_parser_create();
            xml_parse_into_struct($p, $content, $vals, $index);
            xml_parser_free($p);
            //獲取基本信息
            $infos['DisplayName']       = $vals[$index['MANIFEST'][0]]["attributes"]["PACKAGE"]?:'undefined';
            $infos['Version']       = $vals[$index['MANIFEST'][0]]["attributes"]["ANDROID:VERSIONNAME"]?:'undefined';
            $infos['PlatForm']      = $vals[$index['USES-SDK'][0]]["attributes"]["ANDROID:MINSDKVERSION"];
            $infos['PlatFormTarget']    = $vals[$index['USES-SDK'][0]]["attributes"]["ANDROID:TARGETSDKVERSION"];
            $infos['PlatFormMax']       = $vals[$index['USES-SDK'][0]]["attributes"]["ANDROID:MAXSDKVERSION"];
            //獲取屏幕信息
            if($vals[$index['SUPPORTS-SCREENS']]){
                foreach($vals[$index['SUPPORTS-SCREENS'][0]]['attributes'] as $key=>$val){  //獲取軟件權限
                    if($val){
                        $infos['Screen'][] = $key;
                    }
                }
            }else{
                $infos['screen'] = 'undefined';
            }
            //獲取用戶權限
            foreach($index['USES-PERMISSION'] as $vkey){    //獲取軟件權限
                $infos['Permission'][] = $vals[$vkey]['attributes']['ANDROID:NAME'];
            }
            //返回XML完整數據
            $infos['xml'] = $content;
        }else{
            $infos = false;
        }
    }else{
        $infos = false;
    }
    unlink($binfile);
    unlink($xmlfile);
    return($infos);
}

/**
 * ipa文件信息提取yu
 * @param $file 要解析到文件路徑
 * @param $tmp  解壓出來的臨時變量存放位置
 * @return array | false 成功返回詳細信息，失敗則返回false
 */
function get_ipa_info($file){
    $file = pc_base::load_config('system','upload_path').$file;
    $keys = array('CFBundleDevelopmentRegion','CFBundleDisplayName','CFBundleExecutable','CFBundleIdentifier','CFBundleName','CFBundleVersion','MinimumOSVersion','CFBundleLocalizations','UIDeviceFamily');
    $tmp = sys_get_temp_dir() . '/';
    $plist_url = $tmp.'Info.plist';
    $xml_url = $tmp.'Info.xml';
    //解壓文件中的Info.plist
    exec("unzip -j '$file' 'Payload/*.app/Info.plist' -d $tmp",$result,$status);
    if(!$status){
        //將二進制文件轉換成XML
        $BIN2XML = PHPCMS_PATH . '/statics/tool/bin2xml.jar';
        exec("java -jar $BIN2XML $plist_url $xml_url",$result,$status);
        if(!$status){
            //讀取Info明文信息
            $content = file_get_contents($xml_url);
            $p = xml_parser_create();
            xml_parse_into_struct($p,$content,$vals,$index);
            xml_parser_free($p);
            //獲得需要的數據
            foreach($index["KEY"] as $vkey){
                if(!in_array($vals[$vkey]["value"],$keys)){
                    continue;
                }
                switch($vals[$vkey+2]["tag"]){
                    case "STRING":
                        $res[$vals[$vkey]["value"]] = $vals[$vkey+2]["value"];
                        break;
                    case "TRUE":
                    case "FALSE":
                        $res[$vals[$vkey]["value"]] = $vals[$vkey+2]["tag"];
                        break;
                    case "ARRAY":
                        $arr_key = $vkey + 2;
                        if($vals[$arr_key]["type"] != "open"){
                            break;
                        }else{
                            $arr_key++;
                        }
                        while($vals[$arr_key]["type"] != "close"){
                            $res[$vals[$vkey]["value"]][] = $vals[$arr_key]["value"];
                            $arr_key += 2;
                        }
                        $res[$vals[$vkey]["value"]] = implode('/',$ipa[$vals[$vkey]["value"]]);
                }
            }
            //自定義key替換
            $peplace_key = array('CFBundleDisplayName'=>'DisplayName','CFBundleExecutable'=>'Executable','CFBundleVersion'=>'Version','MinimumOSVersion'=>'PlatForm','CFBundleLocalizations'=>'Language','UIDeviceFamily'=>'Family');
            foreach($peplace_key as $key=>$value){
                $infos[$value] = $res[$key];
            }
            //返回原始XML內容
            $infos['xml'] = $content;
            unset($res);
        }else{
            $infos = false;
        }
    }else{
        $infos = false;
    }
    unlink($plist_url);
    unlink($xml_url);
    return $infos;
}

/**
 * 獲取文章的統計信息
 * @param comment 評論
 *        sarcasm 吐槽
 *        mood 頂踩
 *        view 點擊瀏覽
 * @author jozh Liu
 */
function get_statics($data){
    $catid = $data['catid'];
    $id = $data['id'];
    $type = $data['type'];

    // 數據處理
    switch ($type) {
        case 'mood':
            $mood_db = pc_base::load_model('mood_model');
            $data= $mood_db->get_one(array("catid"=>$catid,"contentid"=>$id),"n5,n7") ? : array('n5'=>0, 'n7'=>rand(50, 120));
        break;
        case 'comment':
            $data = get_comments(id_encode('content_'.$catid,$id,1)) ? : 0;
        break;
        case 'sarcasm':
            $stag = pc_base::load_app_class('sarcasm_tag','sarcasm');
            $sarcasm = $stag->lists(array('sarcasmid'=>'content_'.$catid.'-'.$id.'-1', 'hot'=>1));
            $data = $sarcasm ? count($sarcasm) : 0;
        break;
        case 'view':
            $re = set_content_db($catid);
            $modelid = $re['modelid'];
            $data = get_views('c-'.$modelid.'-'.$v['id']);
        break;
        default:
            // 頂踩
            $mood_db = pc_base::load_model('mood_model');
            $data['mood']= $mood_db->get_one(array("catid"=>$catid,"contentid"=>$id),"n5,n7") ? : array('n7'=>rand(50, 120), 'n5'=>0);
            // 評論個數???現在使用多說了
            $data['comment'] = get_comments(id_encode('content_'.$catid,$id,1)) ? : 0;
            // 吐槽個數
            $stag = pc_base::load_app_class('sarcasm_tag','sarcasm');
            $sarcasm = $stag->lists(array('sarcasmid'=>'content_'.$catid.'-'.$id.'-1'));
            $data['sarcasm'] = $sarcasm ? count($sarcasm) : 0;
            // 瀏覽量
            $re = set_content_db($catid);
            $modelid = $re['modelid'];
            $data['view'] = get_views('c-'.$modelid.'-'.$v['id']);
        break;
    }

    return $data;

}

/**
 * sdk版本號轉android版本號yu
 *
 * @param $api XML中獲得到sdk版本號
 * @param string 返回android版本號
 */
function sdk_to_android($api){
    if($api == null) $api = 0;
    $versions = array('undefined','Android 1.0','Android 1.1','Android 1.5','Android 1.6','Android 2.0','Android 2.0.1','Android 2.1.x','Android 2.2.x','Android 2.3.x','Android 2.3.3','Android 3.0.x','Android 3.1.x','Android 3.2.x','Android 4.0.x','Android 4.0.3','Android 4.1.x','Android 4.2.x',);
    return $versions[$api];
}

/**
 * 將平台代碼轉為字符串
 *
 * @param $device 設備名稱：apk, ipa
 * @param $platform 平台代碼
 */
function platform_output($device, $platform) {
    $platforms['apk'] = array('undefined','Android 1.0','Android 1.1','Android 1.5','Android 1.6','Android 2.0','Android 2.0.1','Android 2.1.x','Android 2.2.x','Android 2.3.x','Android 2.3.3','Android 3.0.x','Android 3.1.x','Android 3.2.x','Android 4.0.x','Android 4.0.3','Android 4.1.x','Android 4.2.x',);
    $platforms['ipa'] = array('4'=>'iOS 4.0', '4.1'=>'iOS 4.1', '4.2'=>'iOS 4.2', '4.3'=>'iOS 4.3', '5'=>'iOS 5.0', '5.1'=>'iOS 5.1', '5.2'=>'iOS 5.2', '6'=>'iOS 6');
    return isset($platforms[$device][$platform])?$platforms[$device][$platform]:'';
}

/**
 * 輸出格式化的價格
 * @param  integer $price_number        價格
 * @param  integer $price_unit          價格單位
 * @param  integer $limit_free          是否限免
 * @param  integer $limit_free_timeline 限免期限
 * @return string
 */
function output_price($price_number, $price_unit, $limit_free = 0, $limit_free_timeline = 0) {
    if ($limit_free && $limit_free_timeline > time()) {
        return '限時免費';
    } elseif ($price_number == 0) {
        return '免費';
    } else {
        if ($price_unit == 2) {
            return '$' . number_format($price_number, 2);
        } else {
            return '￥' . number_format($price_number, 2);
        }
    }
}

/**
 * 輸出格式化的文件大小
 * @param  integer $filesize        文件大小
 * @return string
 */
function output_filesize($filesize) {
    if ( !is_numeric($filesize) ) {
        return strtoupper($filesize);
    } else {
        if ( $filesize > pow(1024, 3) ) {
            return round( $filesize / pow(1024,3), 2 ) . ' GB';
        } elseif ( $filesize > pow(1024, 2) ) {
            return round( $filesize / pow(1024,2), 2 ) . ' MB';
        } elseif ( $filesize > 1024 ) {
            return round( $filesize / 1024, 2 ) . ' KB';
        } else {
            return $filesize . ' Bytes';
        }
    }
}

function mfpages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 5, $prev_text = '上一頁', $next_text = '下一頁') {
    if(defined('URLRULE') && $urlrule == '') {
        $urlrule = URLRULE;
        $array = $GLOBALS['URL_ARRAY'];
    } elseif($urlrule == '') {
        $urlrule = url_par('page={$page}');
    }
    $multipage = '';
    if($num > $perpage) {
        $multipage .= '<a  target="_self" href="'.pageurl($urlrule, 1, $array).'"class="page-first">首頁</a>';
        $page = $setpages;
        $offset = ceil($setpages/2) - 1;
        $pages = ceil($num / $perpage);
        if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
        $from = $curr_page - $offset;
        $to = $curr_page + $offset;
        if($page >= $pages) {
            $from = 2;
            $to = $pages;
        } else {
            if($from <= 1) {
                $to = $page;
                $from = 2;
            }  elseif($to >= $pages) {
                $to = $pages - 1;
                $from = $to - $setpages + 2;
            }
        }
        if ( $to == $pages ) $to--;
        $ignore_str = ' <span class="ignore">·&nbsp;·&nbsp;·</span>';
        if($curr_page>1) {
            $multipage .= ' <a target="_self" href="'.pageurl($urlrule, $curr_page-1, $array).'" class="page-l">'.$prev_text.'</a>';
            $multipage .= ' <a target="_self" href="'.pageurl($urlrule, 1, $array).'">1</a>';
        } else {
            $multipage .= ' <a target="_self" class="page-l">'.$prev_text.'</a>';
            $multipage .= ' <a target="_self" class="page-on">1</a>';
        }
        if ( $from > 2 ) {
            $multipage .= $ignore_str;
        }
        for($i = $from; $i <= $to; $i++) {
            if($i != $curr_page) {
                $multipage .= ' <a target="_self" href="'.pageurl($urlrule, $i, $array).'">'.$i.'</a>';
            } else {
                $multipage .= ' <a target="_self" class="page-on">'.$i.'</a>';
            }
        }
        if ( $to < $pages - 1 ) {
            $multipage .= $ignore_str;
        }
        if($curr_page < $pages) {
            $multipage .= ' <a  target="_self" href="'.pageurl($urlrule, $pages, $array).'">' . $pages . '</a>';
            $multipage .= ' <a  target="_self" href="'.pageurl($urlrule, $curr_page+1, $array).'" class="page-r">'.$next_text.'</a>';
        } elseif($curr_page==$pages) {
            $multipage .= ' <a  target="_self" class="page-on">' . $pages . '</a>';
            $multipage .= ' <a  target="_self" class="page-r">'.$next_text.'</a>';
        }
        $multipage .= '<a  target="_self" href="'.pageurl($urlrule, $pages, $array).'"class="page-end">尾頁</a>';
    }
    return $multipage;
}
/**
 * 魔方網分頁函數
 *
 * @param integer $num 信息總數
 * @param integer $curr_page 當前分頁
 * @param integer $perpage 每頁顯示數
 * @param $urlrule URL規則
 * @param $array 需要傳遞的數組，用於增加額外的方法
 * @return 分頁
 * @ 該函數使用新的 pageurl_new（）方法，此方法對第一頁進行index.html替換 
 */
function mfpages_new($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 5, $prev_text = '上一頁', $next_text = '下一頁') {
    if(defined('URLRULE') && $urlrule == '') {
        $urlrule = URLRULE;
        $array = $GLOBALS['URL_ARRAY'];
    } elseif($urlrule == '') {
        $urlrule = url_par('page={$page}');
    }

    $multipage = '';
    if($num > $perpage) {
        $multipage .= '<a  target="_self" href="'.pageurl_new($urlrule, 1, $array).'"class="page-first">首頁</a>';
        $page = $setpages;
        $offset = ceil($setpages/2) - 1;
        $pages = ceil($num / $perpage);
        if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
        $from = $curr_page - $offset;
        $to = $curr_page + $offset;

        if($page >= $pages) {
            $from = 2;
            $to = $pages;
        } else {
            if($from <= 1) {
                $to = $page;
                $from = 2;
            }  elseif($to >= $pages) {
                $to = $pages - 1;
                $from = $to - $setpages + 2;
            }
        }
        if ( $to == $pages ) $to--;
        $ignore_str = ' <span class="ignore">·&nbsp;·&nbsp;·</span>';
        if($curr_page>1) {
            $multipage .= ' <a target="_self" href="'.pageurl_new($urlrule, $curr_page-1, $array).'" class="page-l">'.$prev_text.'</a>';
            $multipage .= ' <a target="_self" href="'.pageurl_new($urlrule, 1, $array).'">1</a>';
        } else {
            $multipage .= ' <a target="_self" class="page-l">'.$prev_text.'</a>';
            $multipage .= ' <a target="_self" class="page-on">1</a>';
        }
        if ( $from > 2 ) {
            $multipage .= $ignore_str;
        }
        for($i = $from; $i <= $to; $i++) {
            if($i != $curr_page) {
                $multipage .= ' <a target="_self" href="'.pageurl_new($urlrule, $i, $array).'">'.$i.'</a>';
            } else {
                $multipage .= ' <a target="_self" class="page-on">'.$i.'</a>';
            }
        }
        if ( $to < $pages - 1 ) {
            $multipage .= $ignore_str;
        }
        if($curr_page < $pages) {
            $multipage .= ' <a  target="_self" href="'.pageurl_new($urlrule, $pages, $array).'">' . $pages . '</a>';
            $multipage .= ' <a  target="_self" href="'.pageurl_new($urlrule, $curr_page+1, $array).'" class="page-r">'.$next_text.'</a>';
        } elseif($curr_page==$pages) {
            $multipage .= ' <a  target="_self" class="page-on">' . $pages . '</a>';
            $multipage .= ' <a  target="_self" class="page-r">'.$next_text.'</a>';
        }
        $multipage .= '<a  target="_self" href="'.pageurl_new($urlrule, $pages, $array).'"class="page-end">尾頁</a>';
    }
    return $multipage;
}

/**
 * 返回指定欄目的URL
 *
 * @param $catid 欄目id
 */
function cat_url($catid,$new_url=''){
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $category_arr = getcache('category_content_'.$siteid,'commons');
    if(!isset($category_arr[$catid])) return '';
    $url = $category_arr[$catid]['url'];
    if(strpos($url, '://') === false) $url = $siteurl.$url;
    if($new_url!=''){
        //對URL去掉catid-1.html操作
        $new_url = '';
        $new_url = str_replace("http://", '', $url);
        $array = explode("/", $new_url);
        $array_num = count($array);
        if($array_num==3){
            $url = "http://".$array[0].DIRECTORY_SEPARATOR.$array[1]."/";
        }
    }
    return $url;
}

/**
 * 返回指定欄目的欄目名稱
 *
 * @param $catid 欄目id
 */
function cat_name($catid){
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $category_arr = getcache('category_content_'.$siteid,'commons');
    if(!isset($category_arr[$catid])) return '';
    $name = $category_arr[$catid]['catname'];
    return $name;
}

/**
 * 當前路徑
 * 返回指定欄目路徑層級
 *
 * @param $catid 欄目id
 * @param $symbol 欄目間隔符
 */
function mfcatpos($catid, $symbol=' &gt; ', $last = false){
    $cur_catid = $catid;
    $category_arr = array();
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $category_arr = getcache('category_content_'.$siteid,'commons');
    if(!isset($category_arr[$catid])) return '';
    $pos = '';
    $siteurl = siteurl($category_arr[$catid]['siteid']);
    $arrparentid = array_filter(explode(',', $category_arr[$catid]['arrparentid'].','.$catid));
    array_shift($arrparentid);
    foreach($arrparentid as $catid) {
        $url = $category_arr[$catid]['url'];
        if(strpos($url, '://') === false) $url = $siteurl.$url;
        if ($last && $cur_catid == $catid) {
            $pos .= '<span class="' . $last . '">'.$category_arr[$catid]['catname'].'</span>';
        } else {
            $pos .= '<a href="'.$url.'" target="_self">'.$category_arr[$catid]['catname'].'</a>'.$symbol;
        }
    }
    return $pos;
}

/**
 * 當前路徑
 * 返回指定欄目路徑層級
 * 2013-10-30 版使用
 *
 * @param $catid 欄目id
 * @param $symbol 欄目間隔符
 */
function mfcatpos2($catid, $symbol=' &gt; ', $last = false){
    $cur_catid = $catid;
    $category_arr = array();
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $category_arr = getcache('category_content_'.$siteid,'commons');
    if(!isset($category_arr[$catid])) return '';
    $pos = '';
    $siteurl = siteurl($category_arr[$catid]['siteid']);
    $arrparentid = array_filter(explode(',', $category_arr[$catid]['arrparentid'].','.$catid));
    array_shift($arrparentid);
    foreach($arrparentid as $catid) {
        $url = $category_arr[$catid]['url'];
        if(strpos($url, '://') === false) $url = $siteurl.$url;
        if ($last && $cur_catid == $catid) {
            $pos .= '<li><span>'.$category_arr[$catid]['catname'].'</span></li>';
        } else {
            $pos .= '<li><a href="'.$url.'" target="_self">'.$category_arr[$catid]['catname'].'</a>'.$symbol.'</li>';
        }
    }
    return $pos;
}

/**
 * 當前路徑
 * 返回指定欄目路徑層級
 * 2014-04-01 版使用
 *
 * @param $catid 欄目id
 * @param $symbol 欄目間隔符
 */
function mfcatpos3($catid, $symbol=' &gt; ', $last = false){
    $cur_catid = $catid;
    $category_arr = array();
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $category_arr = getcache('category_content_'.$siteid,'commons');
    if(!isset($category_arr[$catid])) return '';
    $pos = '';
    $siteurl = siteurl($category_arr[$catid]['siteid']);
    $arrparentid = array_filter(explode(',', $category_arr[$catid]['arrparentid'].','.$catid));
    foreach($arrparentid as $catid) {
        $url = $category_arr[$catid]['url'];
        if(strpos($url, '://') === false) $url = $siteurl.$url;
        if ($last && $cur_catid == $catid) {
            $pos .=  $symbol.'<span>'.$category_arr[$catid]['catname'].'</span>';
        } else {
            $pos .= $symbol.'<a href="'.$url.'" target="_blank">'.$category_arr[$catid]['catname'].'</a></li>';
        }
    }
    return $pos;
}
/**
 * trim字符串（包括去除全解空格）
 *
 * @param string $str
 */
function mftrim($str) {
    return mb_ereg_replace('^(([ \r\n\t])*(　)*)*', '', $str);
}

/**
 * 返回 JSON 格式信息
 * ajax_showmessage(0, '登錄成功', array('默認跳轉地址'=>'http://www.phpcms.cn'));
 * @param int $code 狀態碼
 * @param string $msg 提示信息
 * @param mixed(string/array) $url_forward 跳轉地址
 * @param int $ms 跳轉等待時間
 */
function ajax_showmessage($code, $msg, $url_forward = '') {
    $arr = array();
    $arr['code'] = $code;
    $arr['msg'] = $msg;
    if ($url_forward) {
        $arr['url_forward'] = $url_forward;
    } else {
        $arr['url_forward'] = HTTP_REFERER;
    }
    echo json_encode($arr);
    exit;
}

function format_time($n) {
    $str = '';
    while ($n > 0) {
        $str = ':' . sprintf("%02d", $n % 60) . $str;
        $n = intval($n / 60);
    }
    return substr($str, 1);
}

/**
 * 獲取點擊數量
 * @param $hitsid
 */
function get_views($hitsid) {
    global $db;
    if(!$hitsid){ return false;}
    $db = pc_base::load_model('hits_model');
    $r = $db->get_one(array('hitsid'=>$hitsid));
    if($r){
        return $r['views']; 
    }else{
        return '0';
    }
}

/**
 * 獲取表態數
 * @param $catid
 *        $id
 */
function get_mood($catid, $id) {
    global $db;
    $db = pc_base::load_model('mood_model');
    $r = $db->get_one(array('catid'=>$catid, 'contentid'=>$id));
    if($r){
        return array('total' => $r['total'], 
                     'good'  => ($r['n1']+$r['n2']+$r['n3']),
                     'bad'   => ($r['n4']+$r['n5']+$r['n6']));  
    }else{
        return NULL;
    }
}

/**
 * 獲取表態數
 * @author jozh liu
 * @param $catid
 *        $id
 */
function get_moods($catid, $id) {
    global $db;
    $db = pc_base::load_model('mood_model');
    $r = $db->get_one(array('catid'=>$catid, 'contentid'=>$id));
    if($r){
        return $r['total']; 
    }else{
        return NULL;
    }
}

/**
 * 獲取評論數
 * @param $comment
 */
function get_comments($commentid) {
    global $db;
    if(!$commentid){return false;}
    $db = pc_base::load_model('comment_model');
    $r = $db->get_one(array('commentid'=>$commentid));  
    if($r){
        return $r['total']; 
    }else{
        return '0';
    }
}
/**
 * 獲取吐槽數目
 * @param string sarcasmid => content_catid-id-siteid
 * @return string
 */
function get_sarcasms($sarcasmid){
    global $db;
    if(!$sarcasmid){return false;}
    $db = pc_base::load_model('sarcasm_model');
    $result = $db->get_one(array('sarcasmid'=>$sarcasmid));
    if($result){
        return $result['total'];
    }else{
        return '0';
    }
}
/**
 * 獲取期待網遊
 * @param $catid
 * @param $num 獲取數目
 * @return Array {'game_type'=>'遊戲類型','game_name'=>'遊戲名稱','count'=>'熱度'}
 */
function get_expects($catid, $num = 10){
    global $db;
    $num = intval($num);
    if(!$catid || !$num){ return array();}
    //判斷文件緩存是否存在,且未過期
    $cache = getcache('game_expects_'.$catid,'content');
    if($cache){
        if(SYS_TIME < $cache['timeout']){
            return $cache['data'];
        }
    }
    set_content_db($catid);
    $r = $db->select(' catid = '.$catid,'keywords,url');
    $result = array();
    $temp = array();
    if($r){
        $count = array();
        foreach($r as $k=>$v){
            $keywords = explode(',',$v['keywords']);
            if(3 != count($keywords)){
                $keywords = explode(' ',$v['keywords']);
            }
            if(count($keywords) == 3){
                if(!array_key_exists($keywords[0],$temp)){
                    $v['count'] = 1;
                    $v['game_type'] = $keywords[2];
                    $v['game_name'] = $keywords[0];
                    $temp[$keywords[0]] = $v;
                    $count[$keywords[0]] = 1;
                }else{
                    $temp[$keywords[0]]['count'] += 1;
                    $count[$keywords[0]] += 1;
                }
            }
        }
        array_multisort($count,SORT_DESC,$temp);
    }
    $result['data'] = array_slice($temp, 0, $num);
    $result['timeout'] = SYS_TIME + 3600;
    setcache('game_expects_'.$catid,$result,'content');
    return $result['data'];
}
/**
 * @param int catid 欄目ID
 * @return Array {'tablename'=>'表名','modelid'=>'模型ID','siteid'=>'網站ID'}
 */
function set_content_db($catid){
    global $db;
    $db = pc_base::load_model('content_model');
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $cat = getcache('category_content_'.$siteid,'commons');
    $model = getcache('model','commons');
    $modelid = $cat[$catid]['modelid'];
    $db->table_name = $db->db_tablepre.$model[$modelid]['tablename'];
    return array('tablename'=>$db->table_name, 'modelid'=>$modelid, 'siteid'=>$siteid);
}
/**
 * @param int catid 欄目ID
 * @param int num 數量
 * @param string select 字段
 * @param string where 選擇條件
 * @param string order 排序條件
 */
function hot_games($catid, $num = 10, $select = '',$where = '', $order = ''){
    global $db;
    $num = intval($num);
    if(!$num || !$catid){ return array();}
    $info = set_content_db($catid);
    $select = "g.url,g.title,h.views".($select ? ','.$select : '');
    $where = "h.hitsid = CONCAT('c-".$info['modelid']."-',g.id)".($where ? ' AND '.$where : '');
    $order = "h.views DESC".($order ? " ,".$order :  '');
    $sql = sprintf("SELECT %s FROM %s g,%s h WHERE %s ORDER BY %s LIMIT %d",
        $select,
        $db->table_name,
        $db->db_tablepre.'hits',
        $where,
        $order,
        $num);
    $db->query($sql);
    return $db->fetch_array();
}
/**
 * @param int num 數量
 * @return Array { 'url'=>'鏈接', 'name'=>'遊戲類型', 'view'=>'訪問數'}
 */
function hot_games_all($num = 10, $select = '', $where = '', $order = ''){
    $num = intval($num);
    if(!$num){ return array();}
    $ios = hot_games(20, $num, "'iOS' as name".($select ? ','.$select : ''),$where, $order);
    $android = hot_games(134, $num, "'安卓' as name".($select ? ','.$select : ''),$where, $order);
    $games = array_merge($ios,$android);
    $count = array();
    foreach($games as $game){
        $count[] = $game['views'];
    }
    array_multisort($count,SORT_DESC,$games);
    return $games;
}

function get_search_url($str) {
    $url = APP_PATH . "/index.php?m=search&q=" . rawurlencode($str);
    return $url;
}
/**
 * 專區搜索的url
 */
function get_part_search_url($str,$partid,$type='news') {
    $url = 'http://www.mofang.com.tw/tag/'. intval($partid) . '/' . rawurlencode($str) . '-' . $type . '-1.html';
    $url = APP_PATH . $_GET['p'] . "/search/?q=" . rawurlencode($str);
    return $url;
}

function gamelist_by_tagid_url( $catid, $tagid ) {
    $url = APP_PATH . "index.php?m=content&c=index&a=iosgames&catid=$catid&l1=$tagid#list_filter";
    return $url;
}
function game_tag_url($tag, $catid = 20,$type = 'default'){
    $type_arr = array('default','hits','score');
    $href = array(20=>'http://i.mofang.com.tw/',134=>'http://a.mofang.com.tw/');
    if(!$catid || !array_key_exists($catid, $href)){
        $catid = 20;
    }
    if( $type != 'default' && in_array($type, $type_arr) ){
        $url = $href[$catid] . 'gamelist/' . $tag . '-' . $type . '-1.html';
    } else {
        $url = $href[$catid] . 'gamelist/' . $tag . '.html';
    }
    return $url;
}

function hot_search_tags() {
    return array('瘋狂猜圖', '我叫MT', '植物大戰僵屍', '王者之劍', '瘋狂猜歌', '百萬亞瑟王', '跑酷', '神廟逃亡', '水果忍者', '時空獵人', '賽車', '塔防', '密室', '保衛蘿卜', '我叫MT攻略', '極品飛車', '會說話的湯姆貓', '都市賽車');
}
/**
 * 合並兩個欄目結果，key必須相同
 */
function cat_merge_sort($arr1, $arr2, $sort = '', $num = -1, $sort_type = SORT_DESC){
    if(is_array($arr1) && is_array($arr2)){
        $num = intval($num);
        $arr = array_merge($arr1,$arr2);
        if($sort){
            $temp = array();
            foreach($arr as $val){
                $temp[] = $val[$sort];
            }
            array_multisort($temp,$sort_type,$arr);
        }
        if(-1 == $num){
            return $arr;
        }
        return array_splice($arr,0,$num); 
    }
}

function parse_sub_link($str) {
    $sublinks = array();
    $lines = preg_split('/(\n|\r\n)/', $str);
    if ($lines) foreach($lines as $line) {
        if ($line = trim($line)) {
            list($title, $url) = explode('|', $line);
            $sublinks[] = array($title, $url);
        }
    }
    return $sublinks;
}

function qiniuthumb($imgurl, $width = 100, $height = 100, $no_pic = '') {
    if (preg_match('/pic[s\d].mofang.com/', $imgurl)) {
        $n = crc32($imgurl) % 3;
        if ($width == $height) {
            $style = "{$width}";
        } else {
            $style = "{$width}x{$height}";
        }
        return preg_replace('/pics.mofang.com/', "pic$n.mofang.com", $imgurl) . '/' . $style;
    } else {
        return thumb($imgurl, $width, $height, 1, $no_pic);
    }
}

function get_game_type($catid, $id) {
    $ldb = pc_base::load_model('linktag_model');
    $sql = "select tag_name from www_linktag l join www_linktag_to_content lc on l.tag_id = lc.linktag_id where lc.catid = '{$catid}' and lc.content_id = '{$id}' and l.parent_id = 2";
    $ret = $ldb->query($sql);
    $rows = $ldb->fetch_array();
    if ($rows) {
        return $rows[0]['tag_name'];
    } else {
        return false;
    }
}

function get_news_type($id) {
    $types = array();
    $types['1'] = '速報';
    $types['2'] = '新聞';
    $types['3'] = '評測';
    $types['4'] = '攻略';
    $types['5'] = '視頻';
    $types['6'] = '美女';
    $types['7'] = '八卦';
    $types['8'] = '產業';
    $types['9'] = '專題';
    $types['10'] = '活動';
    $types['11'] = '論壇';
    $types['12'] = '爆料';
    $types['13'] = '討論';
    $types['14'] = '視頻';
    $types['15'] = '數據';
    $types['16'] = '財報';
    $types['17'] = '言論';
    $types['18'] = '會議';
    $types['19'] = '良心';
    $types['20'] = '焦點';
    $types['21'] = '專區';
    $types['22'] = '橫評';
    $types['23'] = '嘗試';
    $types['24'] = '話題';
    $types['25'] = '合輯';
    return $types[$id];
}

function get_news_type_url($url, $type) {
    $cms = array(3,4,5,6,7,9,14,15,16,17,18,20,12,13,22,23,24);
    $base = array(11,21);
    $fixed = array(1=>"http://www.mofang.com/xinyou/687-1.html",2=>"http://www.mofang.com/xinyou/687-1.html",8=>"http://c.mofang.com",10=>"http://bbs.mofang.com/forum-66-1.html",19=>cat_url(255),25=>"http://www.mofang.com/teji/922-1.html");
    $urlinfo = pathinfo($url);
    if (in_array($type, $cms)) {
    if ($catid = intval($urlinfo['filename'])) {
        return cat_url($catid);
    } else if(preg_match('/&catid=(\d+)&/', $urlinfo['basename'], $match)) {
        return cat_url($match[1]);
    }
    } else if (in_array($type, $base)) {
        return $urlinfo['dirname'];
    } else if (array_key_exists($type, $fixed)) {
        return $fixed[$type];
    }   
}

function get_news_type_url2($id, $category) {
    $types = array();
    $types['ios']['1'] = cat_url(81);
    $types['ios']['2'] = cat_url(182);
    $types['ios']['3'] = cat_url(82);
    $types['ios']['4'] = cat_url(83);
    $types['ios']['5'] = cat_url(471);
    $types['ios']['6'] = cat_url(174);
    $types['ios']['7'] = cat_url(127);
    $types['ios']['8'] = cat_url(121);
    $types['ios']['9'] = 'javascritp:void(0)';
    $types['android']['1'] = cat_url(101);
    $types['android']['2'] = cat_url(188);
    $types['android']['3'] = cat_url(102);
    $types['android']['4'] = cat_url(103);
    $types['android']['5'] = cat_url(471);
    $types['android']['6'] = cat_url(174);
    $types['android']['7'] = cat_url(127);
    $types['android']['8'] = cat_url(121);
    $types['android']['9'] = 'javascritp:void(0)';

    return $types[$category][$id];
}

function get_game_scores($catid, $id) {
    $scores = array();
    $scores['total'] = 170;
    $scores['avg'] = 4.5;
    $scores['1']['total'] = 4;
    $scores['2']['total'] = 2;
    $scores['3']['total'] = 7;
    $scores['4']['total'] = 12;
    $scores['5']['total'] = 145;
    $scores['1']['percent'] = intval($scores['1']['total'] / $scores['total'] * 100);
    $scores['2']['percent'] = intval($scores['2']['total'] / $scores['total'] * 100);
    $scores['3']['percent'] = intval($scores['3']['total'] / $scores['total'] * 100);
    $scores['4']['percent'] = intval($scores['4']['total'] / $scores['total'] * 100);
    $scores['5']['percent'] = intval($scores['5']['total'] / $scores['total'] * 100);

    return $scores;
}

/**
* 多長時間以前
*
*/
function get_time_long( $time ){
    if( $time<60 ){
        return $time.'秒前';
    }else if( $time<3600 ){
        return floor($time/60).'分鐘前';
    }else if( $time<86400 ){
        return floor($time/3600).'小時前';
    }else{
        return floor($time/86400).'天前';    
    }
}

/**
 * 魔方網分頁函數(僅有上一頁和下一頁)
 *
 * @param integer $num 信息總數
 * @param integer $curr_page 當前分頁
 * @param integer $perpage 每頁顯示數
 * @param $urlrule URL規則
 * @param $array 需要傳遞的數組，用於增加額外的方法
 * @return 分頁
 */
function mfpages2($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 5, $prev_text = '', $next_text = '') {
    if(defined('URLRULE') && $urlrule == '') {
        $urlrule = URLRULE;
        $array = $GLOBALS['URL_ARRAY'];
    } elseif($urlrule == '') {
        $urlrule = url_par('page={$page}');
    }

    $multipage = '';
    //if($num > $perpage) {
        $multipage .= '';
        $page = $setpages;
        $offset = ceil($setpages/2) - 1;
        $pages = ceil($num / $perpage);
        if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
        $from = $curr_page - $offset;
        $to = $curr_page + $offset;
        if($page >= $pages) {
            $from = 2;
            $to = $pages;
        } else {
            if($from <= 1) {
                $to = $page;
                $from = 2;
            }  elseif($to >= $pages) {
                $to = $pages - 1;
                $from = $to - $setpages + 2;
            }
        }
        if ( $to == $pages ) $to--;

        if($curr_page>1) {
            $multipage .= ' <a target="_self" href="'.pageurl($urlrule, $curr_page-1, $array).'" class="fahao-content-pre">'.$prev_text.'</a>';
        } else {
            $multipage .= ' <a target="_self" class="page2-start">'.$prev_text.'</a>';
        }

        if($curr_page < $pages) {
            $multipage .= ' <a  target="_self" href="'.pageurl($urlrule, $curr_page+1, $array).'" class="fahao-content-next">'.$next_text.'</a>';
        } elseif($curr_page==$pages) {
            $multipage .= ' <a  target="_self" class="page2-end">'.$next_text.'</a>';
        }
        $multipage .= "";
    //}
    return $multipage;
}

function mf_curl( $url, $data ){

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);

    return $response;
}

function mf_curl_get( $url ){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $response = curl_exec($ch);
    return $response;
}

function mf_get_fahao( $data ){
    $url = "http://fahao.mofang.com.tw/api/v1/gift/list?";
    $data['sign'] = getSign_libao($data);
    $url .= http_build_query($data);
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $response = curl_exec($ch);
    return $response;
}

/*
 * 判斷給定id的內容所在專區(note:可能會不準確)
 * @Param $glid id
 *
 **/
function id_to_partid( $glid ){
    $db_partition_game = pc_base::load_model('partition_games_model');
    $pid = $db_partition_game->get_one('`gameid`='.$glid.' AND `part_id` IN(38,263,262,261,260,46,257,256,258,259)', 'part_id');
    if( $pid ){
        $pid = $pid['part_id'];
    }else{
        $pid = 0;
    }
    return $pid;
}

/*
 * 判斷給定id的內容所在專區欄目信息(note:可能會不準確)
 * @Param $glid id
 *
 **/
function id_to_partinfo( $glid, $part_id ){
    $db_partition_game = pc_base::load_model('partition_games_model');
    $db_partition = pc_base::load_model('partition_model');
    $catids = $db_partition->select("`arrparentid` like '%".$part_id."%'", "catid");
    $part_ids = '';
    foreach( $catids as $kc=>$vc ){
        $part_ids .= ','.$vc['catid'];
    }
    $part_ids = trim($part_ids, ',');

    $pid = $db_partition_game->get_one('`gameid`='.$glid.' AND `part_id` IN('.$part_ids.')', 'part_id');
    if( $pid['part_id'] ){
        $temp_catname = $db_partition->get_one("`catid`=".$pid['part_id'], "catname");
        $return['catid'] = $pid['part_id'];
        $return['catname'] = $temp_catname['catname'];
    }else{
        $return = 0;
    }
    return $return;
}

function get_sub_category($catid) {
    $sub_categories = array();
    $sub_categories['687'] = array(81, 182, 101, 188, 1149, 1150, 1166, 1167);
    $sub_categories['688'] = array(82, 183, 102, 189);
    $sub_categories['689'] = array(1019, 83, 184, 103, 190);
	$sub_categories['81'] = array(1149, 1150, 1166, 1167);
   // $sub_categories['1016'] = array(81,182,101,188,1016);
    $sub_categories['1016'] = array(1149,1150,1166,1167);
    $sub_categories['1459'] = array(1476,1477);
    $sub_categories['1478'] = array(1462,1458,1476,1477);
    // $sub_categories['1017'] = array(81,82,1073);
    // $sub_categories['1018'] = array(83,184,103,190); 

    return $sub_categories[$catid];
}

function get_cat_category($catid) {
    $siteids = getcache('category_content','commons');
    $siteid = $siteids[$catid];
    $category_arr = getcache('category_content_'.$siteid,'commons');
    if(!isset($category_arr[$catid])) return '';
    $url = $category_arr[$catid]['url'];
    $cat_parentids = explode(',', $category_arr[$catid]['arrparentid']);
    if (count($cat_parentids) > 1) {
        $top_parentid = $cat_parentids[1];
    }
    switch ( $top_parentid ) {
        case 80:
            $category = 'ios';
            break;
        case 100:
            $category = 'android';
            break;
        case 121:
            $category = 'chanye';
            break;
        case 471:
            $category = 'video';
            break;
        default:
            $category = '';
            break;
    }
    return $category;
}

function linktags($catid, $id) {
    $linktag_content_db = pc_base::load_model('linktag_to_content_model');
    $linktag_db = pc_base::load_model('linktag_model');

    $data = $linktag_content_db->select(array('catid'=>$catid,'content_id'=>$id), 'linktag_id');
    if ($data) {
        foreach($data as $row) {
            $linktag_ids[] = $row['linktag_id'];
        }
    } else {
        return false;
    }

    $data = $linktag_db->select('tag_id in ('.implode(',',$linktag_ids).')', 'parent_id, tag_id, tag_name');
    if ($data) {
        foreach ($data as $row) {
            $tags[$row['parent_id'] . '_' . $row['tag_id']] = $row['tag_name'];
        }
        return $tags;
    } else {
        return false;
    }
}

/**
 * 通過萬遊的appid獲取魔方對應的遊戲id
 * @param int $appid    萬遊ID
 * @return array  魔方對應games id
 */
function get_wanyou_games($appid) {
    $appid = intval(trim($appid))?:0;
    if ($appid == 0) return 0;

    $games_db = pc_base::load_model('content_model');
    $games_db->table_name = $games_db->db_tablepre.'androidgames';

    $data = $games_db->get_one(array('appid'=>$appid), 'id');
    if ($data) {
        return $data['id'];
    } else {
        return 0;
    }
}

function get_category_url($category,$is_wap=0) {
    $sub_domain = pc_base::load_config('domains',$category);
    if ($sub_domain) {
        $base_domain = pc_base::load_config('domains','base_domain');
        $web_url='http://' . $sub_domain . $base_domain;
        if($is_wap){
            return wap_url($web_url);
        }else{
            return $web_url;
        }
    } else {
        return '';
    }
}

/**
 * 將魔方網有攻略的遊戲appid告知萬遊接口
 * @param int $appid    萬遊ID
          int $type     默認1
                            1 - 攻略
                            2 - 禮包
 * @return json         萬遊反饋結果
 */
function wanyou_tui_api($appid, $type=1) {
       $base_url = "http://wanyou.lehe.com/api2/openapi.php";

        $data['m'] = "info_publish";
        $data['appkey'] = "10000001";
        $data['type'] = $type;
        $md1 = "6bcd7faedcc3e0a598d9669933648c29";

        $data['appid'] = $appid;
        ksort($data);
        $param = array();
        foreach($data as $k=>$v) {
            $param[] .= $k."=".$v;
        }
        $sig = md5(implode('',$param).$md1);
        $params =  "?".implode('&', $param);
        $url = $base_url.$params."&sig=".$sig;
        return pc_file_get_contents($url);
}

/**
 * 判斷用戶訪問是否使用移動設備
 * date： 2014-01-04
 */
function isMobile()
{ 
    require_once(dirname(__FILE__) . '/../../mobiledetect/Mobile_Detect.php');
    $detect = new Mobile_Detect;
    return $detect->isMobile();
} 
/**
 * 返回指定的關聯或索引數組
 * date:  2014-02-28
 * $array() 待處理數組
 * $type 數組類型：0 是關聯 1 是索引
 */
function only_array($array,$type){
    $array_type = $type?:0;
    foreach($array as $k => $v){
        if($array_type == 0){
            if(is_string($k)){
                unset($v);
            }else{
                $new_array[$k] = $v;
            }
        }else{
            if(is_int($k)){
                unset($v);
            }else{
                $new_array[$k] = $v;
            }
        }
    }
    return $new_array;
}
/**
 * 返回按指定鍵排序後的數組
 * date 2014-02-28
 * $array 待處理數組
 * $key 排序依據的鍵名,針對於其值為int類型
 */
function keysort($array,$key){
    sort($array);
    foreach($array as $k => $v){
        if($ks=$v[$key]) {
            $tmp_array[$ks]=$v;
        }
    }
    return $tmp_array;
}

/**
 * 指定月份的第一天和最後一天
 * @param  $data string 依據時間
 *         $type string   查詢情況：true 該月第一天最後一天  false 該月第一天下月第一天
 * @author jozh liu
 */
function getthemonth($date,$type = 'true'){
    $firstday = date('Y-m-01', strtotime($date));
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    if($type == 'true'){
        $return = array(strtotime($firstday),strtotime($lastday));
    }else{
        $return = array(strtotime($firstday),strtotime($lastday)+24*3600);
    }
    return $return;
}

/**
 * 返回keyword數組
 * @param $keywords  string or array  SEO的keywords字串
 * @param $begin     int              數組開始位置
 * @param $length    int              返回數組長度
 * @author jozh liu
 */
function keyword_arr($keywords,$begin = 0,$length = 3) {
    if ( is_string($keywords) ) {
        $keyword=explode(' ',$keywords);
        // $keyword=array_filter($keyword);
        sort($keyword);
        $keyword=array_slice($keyword,$begin,$length);
        return $keyword;
    } elseif ( is_array($keywords) ) {
        if(count($keywords)==1){
            $keywords=explode(' ',$keywords[0]);
            foreach($keywords as $k=>$v){
                if(empty($v)){
                   unset($keywords[$k]); 
                }
            }
            // $keyword=array_filter($keyword);
        }
        // sort($keywords);
        $keyword=array_slice($keywords,$begin,$length);
        return $keyword;
    } else {
        return false;
    }
}

/**
 * 獲取用戶頭像
 * 不傳入userid取當前用戶nickname,如果nickname為空取username
 * 傳入field，取用戶$field字段信息
 */
function get_header_img($username='', $field='') {
    $return = '';
    
    $ucenter = "http://u.mofang.com.tw/api/get_detail_by_user";
    $data = array('type' => 1, 'user' =>$username);
    $user_info = json_decode(mf_curl($ucenter, $data));
    if($user_info->code == 1) {
        $return = $user_info->data->portrait;
    } else {
        $return = 'http://u.mofang.com.tw/img/user.png';
    }

    return $return;
}

//獲取文章內容來源
function get_copyfrom($copyfrom){
    if(empty($copyfrom)){
        return '魔方網';
    }else{
        $array = explode('|',$copyfrom);
        if(!empty($array[0])){
            return $array[0]; 
        }else{
            return '魔方網';
        }
    } 
}

//獲取專區裡指定欄目ID下的一級子欄目 
function get_partition_child($catid,$order='catid desc'){
    if(empty($catid)){
        return false;
    }
    $catid = intval($catid);
    //如果指定listorder 就按指定的排序，沒有則默認按catid desc 
    // $listorder = $order ? $order : 'catid desc';
    $return = array();
    $db_content = pc_base::load_model('content_model');
    $db_partition = pc_base::load_model('partition_model');
    //查詢父ID為當前ID的欄目信息
    $return = $db_partition->select(array("parentid"=>$catid), 'catid,catname,image','',$order);
    return $return;
        
}

//根據配置按權重來調用不同的數據庫 array('default'=>20,'slave1'=>80,'slave2'=>40); 
// 值大的調的機會更多 
function weight_rand($weight = array()) {
    $roll = rand (1, array_sum ($weight));
    $_tmp = 0;
    $rollnum = 0;
    foreach ($weight as $k => $v) {
        $min = $_tmp;
        $_tmp += $v;
        $max = $_tmp;
        if ($roll > $min && $roll <= $max) {
            $rollnum = $k;
            break;
        }
    }
    return $rollnum;
}
//根據數據的Key排序
function arr_ksort($arr,$val){
	if(is_array($arr)){
		$new = array();
		foreach($arr as $key=>$v){
			$new[$key]=$v[''.$val];		
		}
			if(array_multisort($new,SORT_DESC,$arr)){
				return $arr;
			};
	}else{
		return false;
	}
}
//--打印測試
function ddd($data){
echo "<pre>";
var_dump($data);
echo "</pre>";
}
//---獲取遊戲庫的一個版本信息, 1是安卓0是IOS , 針對於遊戲評分欄目,依賴李偉的接口返回
function getVers($arr=""){
	if(is_array($arr)){
	$arr2 = array();
	foreach($arr as $k=>$v){
		if(!$v['type']){	
			if(!empty($arr2['ios'])){
				continue;
			}else{
				$arr2['ios']=$v;
			}
		}else{
			if(!empty($arr2['and'])){
				continue;
			}else{
				$arr2['and']=$v;
			}
		}
	}
	return $arr2;
	}else{
	return false;
	}
}

/*評分模型獲取分數的方法*/
function getPf($id){
$db = pc_base::load_model("content_model");
$db->table_name="www_pingce_new_data";
$rs = $db->get_one(array("id"=>$id),"pingfen_total");
	if($rs){
		return $rs['pingfen_total'];
	}else{
		return false;
	}
}
/** 獲取當前時間戳，精確到毫秒 */
function microtime_float(){
   list($usec, $sec) = explode(" ", microtime());
   $f_num = (float)$usec;
   $f_num = str_replace("0.", '', $f_num);
   return ($f_num.'_'.(float)$sec);
}

/** 格式化時間戳，精確到毫秒，x代表毫秒 */
function microtime_format($tag, $time){
   list($usec, $sec) = explode(".", $time);
   $date = date($tag,$usec);
   return str_replace('x', $sec, $date);
}


/** 判斷當前欄目的DIR目錄是否唯一 **/
function page_need_index($catdir){
    //查主站欄目，是否存在
    $category_db = pc_base::load_model('category_model');
    $array = $category_db->select(array('catdir'=>$catdir));
    $num = count($array);
    if($num>1){
        return 0;
    }elseif($num==1){
        return 1;
    }
}
/**
*隨即生成點擊數
*@param $min int 最小值
*@param $max int 最大值
*@param $total int 獲取多少條
*return array()
**/
function hits_hand($min,$max,$total=10,$order="desc"){
if($total == 1){
	$arr=rand($min,$max);
}else{
	$arr = array();
	for($i=0;$i<$total;$i++){
		$arr[]=rand($min,$max);
	}
	
	switch($order){
		case "desc":
		rsort($arr);
		break;
		case "asc":
		sort($arr);
		break;

	}
}
	return $arr;
}
/**
 * 時間間距
 * @param $type 1 return string 天時
 *              2 return string 天時分
 *              3 return string 天時分秒
 * @author Jozh liu
 */
function left_time($big, $small, $type=1){
    if ( strlen($big) != 10 || !is_int($big) ) return false;
    if ( strlen($small) != 10 || !is_int($small) ) return false;
    if ($big < $small) return false;

    $return = $re = abs($big-$small);

    $return = '';
    if ($d = floor($re/3600/24)) $return .= $d.'天';
    if ($h = floor(($re-3600*24*$d)/3600)) $return .= $h.'小時';
    if ( $type == 2 ) {
        $i = floor(($re-3600*24*$d-3600*$h)/60);
        $return .= $i.'分';
    }
    if ( $type == 3 ) {
        $i = floor(($re-3600*24*$d-3600*$h)/60);
        $return .= $i.'分';
        $s = floor($re-3600*24*$d-3600*$h-60*$i);
        $return .= $s.'秒';
    }

    return $return;
}
/**
*二維數組排序
*@param $arr 需要排序的數組
*@param $field 對比排序的字段
*@param $type  排序方式 1 /0
*return array 返回數組
**/
function multi_array($arr,$field,$type=""){
    $arr1 = array();
    if(is_array($arr)){
    	array_values($arr);
    	foreach($arr as $k=>$v){
    		foreach($v as $ke=>$va){
    			$arr1[$ke][$k] = $va;
    		}
    	}
    	if($type){
    	array_multisort($arr1[$field],SORT_ASC,$arr);
    	}else{
    	array_multisort($arr1[$field],SORT_DESC,$arr);
    	}
    	return $arr;
    }
}

/**
* PHP Curl實時推送新發文章到百度Sitemap 
* 默認access_token為www_mofang.com主站的密鑰，目前主站所有域名分別對應不同的密鑰
* @url 要推送的文章URL
* @siteurl 當前文章所屬域名
* @access_token 當前域名對應的密鑰 
**/
function tobaidu($url,$siteurl){ 
    $ntime=time(); 
    $now=date('Y-m-d',$ntime); 
    $data='<?xml version="1.0" encoding="UTF-8"?>'; 
    $data.='   <urlset>'; 
    $data.='       <url>'; 
    $data.='           <loc><![CDATA['.$url.']]></loc>'; 
    $data.='           <lastmod>'.$now.'</lastmod>'; 
    $data.='           <changefreq>daily</changefreq>'; 
    $data.='           <priority>0.8</priority>'; 
    $data.='       </url>'; 
    $data.='   </urlset>'; 
    //默認為主站域名
    $siteurl = $siteurl ? $siteurl : 'www.mofang.com.tw';
    //獲取配置的密鑰
    $ping_baidu = getcache('ping_baidu','commons');//跳轉配置文件
    if($ping_baidu[$siteurl]){
        $access_token = $ping_baidu[$siteurl];
    }else{
        return false;
    }
    // $access_token = $ping_baidu[$siteurl] ? $ping_baidu[$siteurl] : 'Ky4iA3kO';
  
    $pingurl="http://ping.baidu.com/sitemap?site=".$siteurl."&resource_name=sitemap&access_token=".$access_token; 
    $curl= curl_init();// 啟動一個CURL會話 
    curl_setopt($curl, CURLOPT_URL,$pingurl); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($curl, CURLOPT_USERAGENT,"curl/7.12.1");// 模擬用戶使用的瀏覽器 
    curl_setopt($curl, CURLOPT_COOKIE,$cookie); 
    curl_setopt($curl, CURLOPT_REFERER,""); 
    curl_setopt($curl, CURLOPT_POST, 1);//發送一個常規的Post請求 
    curl_setopt($curl, CURLOPT_POSTFIELDS,$data);// Post提交的數據包 
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $tmpInfo= curl_exec($curl);
    if(curl_errno($curl)) { 
       // echo'Errno'.curl_error($curl);//捕抓異常 
        return false;
    } 
    curl_close($curl);// 關閉CURL會話 
    return $tmpInfo;// 返回數據 
}

/**
* 從字符串中獲取域名
* @url 帶域名的字符串
**/
function get_domain($url){
    $pattern = "/[w-] .(com|net|org|gov|cc|biz|info|cn)(.(cn|hk))*/";
    preg_match($pattern, $url, $matches);
    if(count($matches) > 0) {
        return $matches[0];
    }else{
        $rs = parse_url($url);
        $main_url = $rs["host"];
        if(!strcmp(long2ip(sprintf("%u",ip2long($main_url))),$main_url)) {
            return $main_url;
        }else{
            $arr = explode(".",$main_url);
            $count=count($arr);
            $endArr = array("com","net","org","3322");//com.cn net.cn 等情況
            if (in_array($arr[$count-2],$endArr)){
                $domain = $arr[$count-3].".".$arr[$count-2].".".$arr[$count-1];
            }else{
                $domain = $arr[$count-2].".".$arr[$count-1];
            }
            return $domain;
        }// end if(!strcmp...)
    }// end if(count...)
}// end function

    /**
    * 通過圖片模型返回圖集的標題URL  
    * @param array  文章id ,
    * @param string  返回類型 數組or json
    **/
    function get_tuji_data($arr,$returnType="array"){
        if(is_array($arr)){
        $db = pc_base::load_model("content_model");
        $imgs_new_data = array();
        $db->set_model(3);
            foreach ($arr as $key => $value) {
                $lunbo_img_data = $db->get_one(array("id"=>$value));
                $imgs_new_data[$value]['url']=$lunbo_img_data['url'];
                $imgs_new_data[$value]['id']=$value;
                $imgs_new_data[$value]['catid']=$lunbo_img_data['catid'];
            }
            unset($lunbo_img_data); 
            $db->table_name =$db->table_name."_data";
            foreach ($arr as $key => $value) {
                $lunbo_img_data = $db->get_one(array("id"=>$value));
                $imgs_new_data[$value]['img_url']=string2array($lunbo_img_data['pictureurls']);
            }
                if(!empty($imgs_new_data) && $returnType == "array"){
                    return $imgs_new_data;
                }elseif(!empty($imgs_new_data) && $returnType == "json"){
                    return json_encode($imgs_new_data);
                }
        }
    }

    /**
    * 屈龍提供的PAI認證獲取
    * @param $data array ,
    * @return strting 加密認證
    **/
    function getSign_libao($data){
    $secret = '59d37a2a4d60a22a4d673a00b1a14236';
    ksort($data);
    $s_tmp='';
        foreach($data as $k=>$v){
            $s_tmp.=$k.'='.$v;
        }
        return md5($s_tmp.$secret);

    }

    /**
     *
    **/
    function get_uid($name='') {  
        $db = pc_base::load_model('admin_model');
        $info = $db->get_one(array('username'=>$name),'mf_uid');
        if(!empty($info)) {
            $uid = $info['mf_uid'];    
        } else {
            $uid = 0;    
        }

        return $uid;
    }
/**
 * 获取用户列表url
 **/
function get_user_url($str) {
    //$url = APP_PATH . "index.php?m=content&c=index&a=user_lists&catid=10000050&page=1&outhorname=" . rawurlencode($str);
    $url = APP_PATH . "user/".rawurlencode($str)."-1.html";
    return $url;
}

/**
 * 获取卡牌库详情页url
 **/
function card_detail_url($setid, $id, $p) {
    return APP_PATH.$p.'/dcard_'.$setid.'_'.$id.'.html';    
}

/**
 * 获取卡牌库详情页url
 **/
function card_list_url($setid, $p, $page = false) {
    if($page) {
        return APP_PATH.$p.'/lcard_'.$setid.'_{$page}.html';    
    } else {
        return APP_PATH.$p.'/lcard_'.$setid.'_1.html';    
    }
}

/**
 * 获取文章是否收藏
 * 参数:userid , modelid,contentid 
 */

function get_is_favorite($userid,$modelid,$contentid){
    if($userid=='' || $modelid =='' || $contentid ==''){
        return 0;exit;
    }
    $app_favorite_db= pc_base::load_model('app_favorite_model');
    $array = $app_favorite_db->get_one(array("userid"=>$userid,"modelid"=>$modelid,"contentid"=>$contentid));
    if($array && !empty($array)){
        return 1;
    }else{
        return 0;
    }

}

/**
 * 以文章ID，模型ID获取文章关联的游戏ID
 * 参数：$id,$modelid,$catid 
 */

function get_relation_game($id,$modelid){
    $id = intval($id);
    $modelid = intval($modelid);
    if(!$id || !$modelid){
        return '';
    }
    $relation_game_db= pc_base::load_model('relation_game_model');
    $array = $relation_game_db->get_one(array("id"=>$id,"modelid"=>$modelid),'*');
    if(!empty($array)){
        return $array['gameid'];
    }else{
        return '';
    }
}

/**
 * 获取文章对应的FEED 帖子ID + flagid
 * 参数：modelid,id 
 */

function get_commentid_flagid($modelid,$id){
    $modelid = intval($modelid);
    $id = intval($id);
    if(!$modelid || !$id){
        return 0;exit;
    }
    //查询commentid 
    $relation_feed_db= pc_base::load_model('relation_feed_model');
    $array = $relation_feed_db->get_one(array("modelid"=>$modelid,"contentid"=>$id));
    $return = array();
    if($array && !empty($array)){
        $return['flag'] = $array['flag'];
        $return['feedid'] = $array['feedid'];

        //如果flag为空，则重新请求接口获取feedid，并把flag入库
        // if($array['flag']==''){
        //     $ty_comment = array();
        //     $ty_comment['flag'] = "cms:art_".$modelid."_".$id; 
        //     //获取接口地址
        //     $feed_config = pc_base::load_config('feed_config'); 
        //     $comment_api_url = $feed_config['comment_api_url'];
        //     $request_api = $comment_api_url."comment/gettid";
        //     //提交数据，获取结果
        //     $datas = post_curl($request_api,$ty_comment);
        //     $datas = json_decode($datas,true);
        //     if($datas['code']==0){
        //         $feed_id = $datas['data']['tid'];
        //     }
        //     //更新relation关系，把新feedid及flag一起入库里
        //     $relation_feed_db->update(array("flag"=>$ty_comment['flag'],"feedid"=>$feed_id),array("id"=>$array['id']));
        //     //使用新的id
        //     $return['flag'] = "cms:art_".$modelid."_".$id; 
        //     $return['feedid'] = $feed_id;

        // }else{
        //     $return['flag'] = $array['flag'];
        //     $return['feedid'] = $array['feedid'];
        // }
    }
    return $return;;
}


