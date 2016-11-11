<?php
if (!class_exists('FISResource')) require_once(dirname(__FILE__) . '/FISResource.class.php');



/**
 * Checks a string for UTF-8 encoding.
 *
 * @param  string $string
 * @return boolean
 */
function isUtf8($string) {
    $length = strlen($string);

    for ($i = 0; $i < $length; $i++) {
        if (ord($string[$i]) < 0x80) {
            $n = 0;
        }

        else if ((ord($string[$i]) & 0xE0) == 0xC0) {
            $n = 1;
        }

        else if ((ord($string[$i]) & 0xF0) == 0xE0) {
            $n = 2;
        }

        else if ((ord($string[$i]) & 0xF0) == 0xF0) {
            $n = 3;
        }

        else {
            return FALSE;
        }

        for ($j = 0; $j < $n; $j++) {
            if ((++$i == $length) || ((ord($string[$i]) & 0xC0) != 0x80)) {
                return FALSE;
            }
        }
    }

    return TRUE;
}

/**
 * Converts a string to UTF-8 encoding.
 *
 * @param  string $string
 * @return string
 */
function convertToUtf8($string) {

    if (!is_string($string)) {
        return '';
    }

    if (!isUtf8($string)) {
        if (function_exists('mb_convert_encoding')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'GBK');
        } else {
            $string = iconv('GBK','UTF-8//IGNORE', $string);
        }
    }

    return $string;
}

/**
 * Class FISPagelet
 * DISC:
 * 構造pagelet的html以及所需要的靜態資源json
 */
class FISPagelet {

    const CSS_LINKS_HOOK = '<!--[FIS_CSS_LINKS_HOOK]-->';
    const JS_SCRIPT_HOOK = '<!--[FIS_JS_SCRIPT_HOOK]-->';
    const JS_LOADER_HOOK = '<!--[FIS_JS_LOADER_HOOK]-->';

    const MODE_NOSCRIPT = 0;
    const MODE_QUICKLING = 1;
    const MODE_BIGPIPE = 2;

    /**
     * 收集widget內部使用的靜態資源
     * array(
     *  0: array(), 1: array(), 2: array()
     * )
     * @var array
     */
    static protected $inner_widget = array(
        array(),
        array(),
        array()
    );

    /**
     * 記錄pagelet_id
     * @var string
     */
    static private $_pagelet_id = null;

    static private $_session_id = 0;
    static private $_context = array();
    static private $_contextMap = array();
    static private $_pagelets = array();
    static private $_title = '';
    static private $_pagelet_group = array();
    /**
     * 解析模式
     * @var number
     */
    static protected $mode = null;

    static protected $default_mode = null;

    /**
     * 某一個widget使用那種模式渲染
     * @var number
     */
    static protected  $widget_mode;

    static protected  $filter;

    static public $cp;
    static public $arrEmbeded = array();

    static public $cdn;
    //auto package
    static private $sampleRate = 1;
    static private $fid;
    static private $pageName = "";
    static private $usedStatics = array();

    static public function addHashTable($strId, $smarty){
        $staticInfo = FISResource::getStaticInfo($strId, $smarty);
        self::$usedStatics[]  = $staticInfo['hash'];
    }

    static public function getUsedStatics(){
        return self::$usedStatics;
    }

    /**
     * 設置渲染模式及其需要渲染的widget
     * @param $default_mode string 設置默認渲染模式
     */
    static public function init($default_mode) {
        if (is_string($default_mode)
            && in_array(
                self::_parseMode($default_mode),
                array(self::MODE_BIGPIPE, self::MODE_NOSCRIPT))
        ) {
            self::$default_mode = self::_parseMode($default_mode);
        } else {
            self::$default_mode = self::MODE_NOSCRIPT;
        }

        $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
        //TODO:AJAX BIGPIPE
        $is_ajax = false;
        if ($is_ajax) {
            self::setMode(self::MODE_QUICKLING);
        } else {
            self::setMode(self::$default_mode);
        }
        self::setFilter($_GET['pagelets']);
    }

    static public function setMode($mode){
        if (self::$mode === null) {
            self::$mode = isset($mode) ? intval($mode) : 1;
        }
    }

    static public function setFilter($ids) {
        if (!is_array($ids)) {
            $ids = array($ids);
        }
        foreach ($ids as $id) {
            self::$filter[$id] = true;
        }
    }

    static public function setTitle($title) {
        self::$_title = $title;
    }

    static public function getUri($strName, $smarty) {
        return FISResource::getUri($strName, $smarty);
    }

    static public function addScript($code) {
        if(self::$_context['hit'] || self::$mode == self::$default_mode){
            FISResource::addScriptPool($code);
        }
    }

    static public function addStyle($code) {
        if(self::$_context['hit'] || self::$mode == self::$default_mode){
            FISResource::addStylePool($code);
        }
    }

    public static function cssHook() {
        return self::CSS_LINKS_HOOK;
    }

    public static function jsHook() {
        return self::JS_SCRIPT_HOOK;
    }

    public static function jsLoaderHook() {
        return self::JS_LOADER_HOOK;
    }
    static function load($str_name, $smarty, $async = false) {
        if(self::$_context['hit'] || self::$mode == self::$default_mode){
            FISResource::load($str_name, $smarty, $async);
        }
    }

    static private function _parseMode($str_mode) {
        $str_mode = strtoupper($str_mode);
        $mode = self::$mode;
        switch($str_mode) {
            case 'BIGPIPE':
                $mode = self::MODE_BIGPIPE;
                break;
            case 'QUICKLING':
                $mode = self::MODE_QUICKLING;
                break;
            case 'NOSCRIPT':
                $mode = self::MODE_NOSCRIPT;
                break;
        }
        return $mode;
    }
    /**
     * WIDGET START
     * 解析參數，收集widget所用到的靜態資源
     * @param $id
     * @param $mode
     * @param $group
     * @return bool
     */
    static public function start($id, $mode = null, $group = null) {
        $has_parent = !empty(self::$_context);

        //這個是用來判斷是否widget是async加載的。
        $special_flag = false;
        if ($mode !== null) {
            $special_flag = true;
        }

        if ($mode) {
            self::$widget_mode = self::_parseMode($mode);
        } else {
            self::$widget_mode = self::$mode;
        }
        self::$_pagelet_id = $id;
        $parent_id = $has_parent ? self::$_context['id'] : '';
        $qk_flag = self::$mode == self::MODE_QUICKLING ? '_qk_' : '';
        $id = empty($id) ? '__elm_' . $parent_id . '_' . $qk_flag . self::$_session_id ++ : $id;

        //widget是否命中，默認命中
        $hit = true;

        switch(self::$widget_mode) {
            case self::MODE_NOSCRIPT:
                // TODO:BigBipe open
                // echo '<div id="' . $id . '">';
                break;
            case self::MODE_QUICKLING:
                $hit = self::$filter[$id];
            case self::MODE_BIGPIPE:
                $context = array( 'id' => $id, 'async' => false);
                //widget調用時mode='quickling'，so，打出異步加載代碼
                if ($special_flag && !$hit) {
                    if (!$group) {
                        echo '<textarea class="g_fis_bigrender" style="display:none;">'
                            .'BigPipe.asyncLoad({id: "'.$id.'"});'
                            .'</textarea>';
                    } else {
                        if (isset(self::$_pagelet_group[$group])) {
                            self::$_pagelet_group[$group][] = $id;
                        } else {
                            self::$_pagelet_group[$group] = array($id);
                            echo "<!--" . $group . "-->";
                        }
                    }
                    $context['async'] = true;
                }

                $parent = self::$_context;
                if(!empty($parent)) {
                    $parent_id = $parent['id'];
                    self::$_contextMap[$parent_id] = $parent;
                    $context['parent_id'] = $parent_id;
                    if($parent['hit'] && !$special_flag) {
                        $hit = true;
                    } else if($hit && self::$mode === self::MODE_QUICKLING){
                        unset($context['parent_id']);
                    }
                }
                $context['hit'] = $hit;


                self::$_context = $context;

                if (empty($parent) && $hit) {
                    FISResource::widgetStart();
                } else if (!empty($parent) && !$parent['hit'] && $hit) {
                    FISResource::widgetStart();
                }
                echo '<div id="' . $id . '">';
                ob_start();
                break;
        }
        return $hit;
    }

    /**
     * WIDGET END
     * 收集html，收集靜態資源
     */
    static public function end() {
        $ret = true;
        if (self::$widget_mode !== self::MODE_NOSCRIPT) {
            $html = ob_get_clean();
            $pagelet = self::$_context;
            //end
            if (isset($pagelet['parent_id'])) {
                $parent = self::$_contextMap[$pagelet['parent_id']];
                if (!$parent['hit'] && $pagelet['hit']) {
                    self::$inner_widget[self::$widget_mode][] = FISResource::widgetEnd();

                }
            } else {
                if ($pagelet['hit']) {
                    self::$inner_widget[self::$widget_mode][] = FISResource::widgetEnd();
                }
            }

            if($pagelet['hit'] && !$pagelet['async']){
                unset($pagelet['hit']);
                unset($pagelet['async']);
                $pagelet['html'] = $html;
                self::$_pagelets[] = &$pagelet;
                unset($pagelet);
            } else {
                $ret = false;
            }
            $parent_id = self::$_context['parent_id'];
            if(isset($parent_id)){
                self::$_context = self::$_contextMap[$parent_id];
                unset(self::$_contextMap[$parent_id]);
            } else {
                self::$_context = null;
            }
            self::$widget_mode = self::$mode;
        }
        // TODO:BigBipe open
        // echo '</div>';

        return $ret;
    }


    /**
     * 設置cdn
     */
    static public function setCdn($syncCdn, $asyncCdn) {
        $syncCdn = trim($syncCdn);
        $asyncCdn = trim($asyncCdn);
        FISResource::setCdn(array($syncCdn, $asyncCdn));
    }

    static public function getCdn($type = 'sync') {
        return FISResource::getCdn($type);
    }

    static private function isSample($sample){
        $tmp_sample = rand(1, 10000) / 10000;
        return $sample >= $tmp_sample;
    }

    static private function getCountUrl($res){
        $js_num = count($res['js']);
        $css_num = count($res['css']);
        $req_num = $js_num + $css_num;
        $code = "";
        $sampleRate = self::getSampleRate();
        if(self::isSample($sampleRate)){
            $fid = self::getFid();
            $pageName = self::getPageName();
            if (!empty(self::$usedStatics)) {
                $timeStamp = time();
                $hashStr = '';
                self::$usedStatics= array_filter(array_unique(self::$usedStatics));
                $tmpStr = implode(',', self::$usedStatics);
                $hashStr .= $tmpStr;
                $code .= '(new Image()).src="http://nsclick.baidu.com/u.gif?pid=242&v=1&data=' . $tmpStr . "&page=" . $pageName . '&reqnum=' . $req_num . '&sid=' . $timeStamp . '&hash=<STATIC_HASH>' . '&fid=' . $fid . '";';
                $code = str_replace("<STATIC_HASH>", substr(md5($hashStr), 0, 10), $code);
            }
        }
        return $code;
    }

    static public function setFid($fid){
        self::$fid = $fid;
    }

    static public function setSampleRate($rate){
        self::$sampleRate = $rate;
    }

    static public function getFid(){
        return self::$fid;
    }

    static public function getSampleRate(){
        return self::$sampleRate;
    }

    static public function getPageName(){
        return self::$pageName;
    }

    static public function setPageName($page){
        self::$pageName = $page;
    }


    /**
     * 渲染靜態資源
     * @param $html
     * @param $arr
     * @param bool $clean_hook
     * @return mixed
     */
    static public function renderStatic($html, $arr, $clean_hook = false) {
        if (!empty($arr)) {
            $code = '';

            // 異步加載資源
            $resource_map = $arr['async'];
            $loadModJs = (FISResource::getFramework() && ($arr['js'] || $resource_map));
            if ($loadModJs) {
                foreach ($arr['js'] as $js) {
                    // sea.js **-config.js文件放到head元素內
                    if ( preg_match("/sea([_a-f0-9]{8})*\.js/",$js) || preg_match("/boot([_a-f0-9]{8})*\.js/",$js) || preg_match("/-config([_a-f0-9]{8})*\.js/",$js)) {
                        $code .= '<script type="text/javascript" src="' . self::getCdn() . $js . '"></script>';
                    }
                    if ($js == FISResource::getFramework()) {
                        if ($resource_map) {
                            $code .= '<script type="text/javascript">';
                            $code .= 'require.resourceMap('.json_encode($resource_map).');';
                            $code .= '</script>';
                        }
                    }
                }
            }
            $html = str_replace(self::JS_LOADER_HOOK, $code . self::JS_LOADER_HOOK, $html);

            $code = "";
            // 其余js文件放到頁面底部
            $arr['js'] = $arr['js'] ? $arr['js'] : array();
            $arr['js'] = array_unique($arr['js']); 
            if (!empty($arr['js'])) {
                foreach ($arr['js'] as $js) {
                    if ( preg_match("/sea([_a-f0-9]{8})*\.js/",$js) || preg_match("/boot([_a-f0-9]{8})*\.js/",$js) || preg_match("/-config([_a-f0-9]{8})*\.js/",$js)) {
                    }else{
                        $code .= '<script type="text/javascript" src="' . self::getCdn() . $js . '"></script>';
                    }
                }
            }
            $html = str_replace(self::JS_SCRIPT_HOOK, $code . self::JS_SCRIPT_HOOK, $html);

            $code = '';

            if (!empty($arr['script'])) {
                $code .= '<script type="text/javascript">'. PHP_EOL;
                foreach ($arr['script'] as $inner_script) {
                    $code .= '!function(){'.$inner_script.'}();'. PHP_EOL;
                }
                $code .= '</script>';
            }

            //auto pack
            // $jsCode = self::getCountUrl($arr);
            // if($jsCode != ""){
            //     $code .=  '<script type="text/javascript">' . $jsCode . '</script>';
            // }

            /**php xiugai**/
            $html = str_replace(self::JS_SCRIPT_HOOK, $code . self::JS_SCRIPT_HOOK, $html);
            

            $code = '';
            $arr['css'] = array_unique($arr['css']);
            if (!empty($arr['css'])) {
                $code = '<link rel="stylesheet" type="text/css" href="' . self::getCdn()
                    . implode('" /><link rel="stylesheet" type="text/css" href="' . self::getCdn(), $arr['css'])
                    . '" />';
            }
            if (!empty($arr['style'])) {
                $code .= '<style type="text/css">';
                foreach ($arr['style'] as $inner_style) {
                    $code .= $inner_style;
                }
                $code .= '</style>';
            }
            //替換
            $html = str_replace(self::CSS_LINKS_HOOK, $code . self::CSS_LINKS_HOOK, $html);
        }
        // 清除fis標識字符串
        if ($clean_hook) {
            $html = str_replace(array(self::CSS_LINKS_HOOK, self::JS_SCRIPT_HOOK,self::JS_LOADER_HOOK), '', $html);
        }
        return $html;
    }

    /**
     * @param $html string html頁面內容
     * @return mixed
     */
    static public function insertPageletGroup($html) {
        if (empty(self::$_pagelet_group)) {
            return $html;
        }
        $search = array();
        $replace = array();
        foreach (self::$_pagelet_group as $group => $ids) {
            $search[] = '<!--' . $group . '-->';
            $replace[] = '<textarea class="g_fis_bigrender g_fis_bigrender_'.$group.'" style="display: none">BigPipe.asyncLoad([{id: "'.
                implode('"},{id:"', $ids)
            .'"}])</textarea>';
        }
        return str_replace($search, $replace, $html);
    }

    static public function display($html) {
        $html = self::insertPageletGroup($html);
        $pagelets = self::$_pagelets;
        $mode = self::$mode;
        $res = array(
            'js' => array(),
            'css' => array(),
            'script' => array(),
            'style' => array(),
            'async' => array(
                'res' => array(),
                'pkg' => array()
            )
        );

        //{{{
        foreach (self::$inner_widget[$mode] as $item) {
            foreach ($res as $key => $val) {
                if (isset($item[$key]) && is_array($item[$key])) {
                    if ($key != 'async') {
                        $arr = array_merge($res[$key], $item[$key]);
                        $arr = array_merge(array_unique($arr));
                    } else {
                        $arr = array(
                            'res' => array_merge($res['async']['res'], (array)$item['async']['res']),
                            'pkg' => array_merge($res['async']['pkg'], (array)$item['async']['pkg'])
                        );
                    }
                    //合並收集
                    $res[$key] = $arr;
                }
            }
        }
        //if empty, unset it!
        foreach ($res as $key => $val) {
            if (empty($val)) {
                unset($res[$key]);
            }
        }
        //}}}

        //add cdn
        foreach ((array)$res['js'] as $key => $js) {
            $res['js'][$key] = self::getCdn() . $js;
        }

        foreach ((array)$res['css'] as $key => $css) {
            $res['css'][$key] = self::getCdn() . $css;
        }

        //tpl信息沒有必要打到頁面
        switch($mode) {
            case self::MODE_NOSCRIPT:
                //渲染widget以外靜態文件
                $all_static = FISResource::getArrStaticCollection();
                $html = self::renderStatic(
                    $html,
                    $all_static,
                    true
                );
                break;
            case self::MODE_QUICKLING:
                header('Content-Type: text/json;charset: utf-8');
                if ($res['script']) {
                    $res['script'] = convertToUtf8(implode("\n", $res['script']));
                }
                if ($res['style']) {
                    $res['style'] = convertToUtf8(implode("\n", $res['style']));
                }
                foreach ($pagelets as &$pagelet) {
                    $pagelet['html'] = convertToUtf8(self::insertPageletGroup($pagelet['html']));
                }
                unset($pagelet);
                //auto pack
                $jsCode = self::getCountUrl($res);
                if($jsCode != "" && !$_GET['fis_widget']){
                    $res['script'] = $res['script'] ? $res['script'] . $jsCode : $jsCode;
                }
                $title = convertToUtf8(self::$_title);
                $html = json_encode(array(
                    'title' => $title,
                    'pagelets' => $pagelets,
                    'resource_map' => $res
                ));
                break;
            case self::MODE_BIGPIPE:
                $external = FISResource::getArrStaticCollection();
                $page_script = $external['script'];
                unset($external['script']);
                $html = self::renderStatic(
                    $html,
                    $external,
                    true
                );
                $html .= "\n";
                $html .= '<script type="text/javascript">';
                $html .= 'BigPipe.onPageReady(function() {';
                $html .= implode("\n", $page_script);
                $html .= '});';
                $html .= '</script>';
                $html .= "\n";

                if ($res['script']) {
                    $res['script'] = convertToUtf8(implode("\n", $res['script']));
                }
                if ($res['style']) {
                    $res['style'] = convertToUtf8(implode("\n", $res['style']));
                }
                $html .= "\n";
                foreach($pagelets as $index => $pagelet){
                    $id = '__cnt_' . $index;
                    $html .= '<code style="display:none" id="' . $id . '"><!-- ';
                    $html .= str_replace(
                        array('\\', '-->'),
                        array('\\\\', '--\\>'),
                        self::insertPageletGroup($pagelet['html'])
                    );
                    unset($pagelet['html']);
                    $pagelet['html_id'] = $id;
                    $html .= ' --></code>';
                    $html .= "\n";
                    $html .= '<script type="text/javascript">';
                    $html .= "\n";
                    $html .= 'BigPipe.onPageletArrived(';
                    $html .= json_encode($pagelet);
                    $html .= ');';
                    $html .= "\n";
                    $html .= '</script>';
                    $html .= "\n";
                }
                $html .= '<script type="text/javascript">';
                $html .= "\n";
                $html .= 'BigPipe.register(';
                if(empty($res)){
                    $html .= '{}';
                } else {
                    $html .= json_encode($res);
                }
                $html .= ');';
                $html .= "\n";
                $html .= '</script>';
                break;
        }

        return $html;
    }

    //smarty output filter
    static function renderResponse($content, $smarty) {
        return self::display($content);
    }
}
