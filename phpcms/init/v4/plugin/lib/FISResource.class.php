<?php
/**
 * Class FISResource
 * 靜態資源的收集，包括查詢map表，頁面html收集等
 */
class FISResource {

    private static $arrMap = array();
    private static $arrLoaded = array();
    private static $arrAsyncDeleted = array();
    /**
     * array(
     *     js: array(), css: array(), script: array(), async: array()
     * )
     * @var array
     */
    private static $arrStaticCollection = array();
    //收集require.async組件
    private static $arrRequireAsyncCollection = array();
    private static $arrWidgetStatic = array();
    private static $arrWidgetRequireAsync = array();

    private static $arrScriptPool = array();
    private static $arrStylePool = array();

    private static $arrWidgetScript = array();
    private static $arrWidgetStyle = array();

    //標識是否在分析一個widget
    private static $isInnerWidget = false;

    public static $framework = null;

    private static $cdn = array();

    public static function reset() {
        self::$arrStaticCollection = array();
        self::$arrRequireAsyncCollection = array();
        self::$arrLoaded = array();
        self::$arrAsyncDeleted = array();
        self::$arrScriptPool = array();
        self::$arrStylePool = array();
    }

    static public function setCdn($cdn) {
        self::$cdn = $cdn;
    }

    static public function getCdn($type = 'sync') {
        if ($type == 'async') {
            return self::$cdn[1];
        }
        return self::$cdn[0];
    }

    public static function widgetStart() {
        self::$isInnerWidget = true;

        self::$arrWidgetStatic = array();
        self::$arrWidgetRequireAsync = array();
        self::$arrWidgetStatic = array();
        self::$arrWidgetStyle = array();
    }

    public static function widgetEnd() {

        self::$isInnerWidget = false;
        $ret = array();
        //{{{ 還原
        if (self::$arrWidgetRequireAsync) {
            foreach (self::$arrWidgetRequireAsync as $key => $val) {
                foreach ($val as $id => $info) {
                    unset(self::$arrLoaded[$id]);
                    unset(self::$arrAsyncDeleted[$id]);
                }
            }
            $ret['async'] = self::getResourceMap(self::$arrWidgetRequireAsync, self::getCdn('async'));
        }

        foreach (self::$arrWidgetStatic as $key => $val) {
            foreach ($val as $uri) {
                foreach (array_keys(self::$arrLoaded, $uri) as $id) {
                    unset(self::$arrLoaded[$id]);
                    unset(self::$arrAsyncDeleted[$id]);
                }
            }
        }
        //}}}
        if (self::$arrWidgetStatic['js']) {
            $ret['js'] = self::$arrWidgetStatic['js'];
        }
        if (self::$arrWidgetStatic['css']) {
            $ret['css'] = self::$arrWidgetStatic['css'];
        }
        if (self::$arrWidgetScript) {
            $ret['script'] = self::$arrWidgetScript;
        }
        if (self::$arrWidgetStyle) {
            $ret['style'] = self::$arrWidgetStyle;
        }
        return $ret;
    }

    public static function addStatic($uri, $type) {
        if (self::$isInnerWidget) {
            self::$arrWidgetStatic[$type][] = $uri;
        } else {
            self::$arrStaticCollection[$type][] = $uri;
        }
    }

    public static function addAsync($id, $info, $type) {
        if (self::$isInnerWidget) {
            self::$arrWidgetRequireAsync[$type][$id] = $info;
        } else {
            self::$arrRequireAsyncCollection[$type][$id] = $info;
        }
    }

    public static function delAsync($id, $type) {
        if (self::$isInnerWidget) {
            unset(self::$arrWidgetRequireAsync[$type][$id]);
        } else {
            unset(self::$arrRequireAsyncCollection[$type][$id]);
        }
    }

    public static function getAsync($id, $type) {
        if (self::$isInnerWidget) {
            return self::$arrWidgetRequireAsync[$type][$id];
        } else {
            return self::$arrRequireAsyncCollection[$type][$id];
        }
    }

    //設置framewok mod.js
    public static function setFramework($strFramework) {
        self::$framework = $strFramework;
    }

    public static function getFramework() {
        return self::$framework;
    }

    public static function addScriptPool($code) {
        if (!self::$isInnerWidget) {
            self::$arrScriptPool[] = $code;
        } else {
            self::$arrWidgetScript[] = $code;
        }
    }

    public static function addStylePool($code) {
        if (!self::$isInnerWidget) {
            self::$arrStylePool[] = $code;
        } else {
            self::$arrWidgetStyle[] = $code;
        }
    }

    public static function getArrStaticCollection() {
        //內嵌腳本
        if (self::$arrScriptPool) {
            self::$arrStaticCollection['script'] = self::$arrScriptPool;
        }

        if (self::$arrStylePool) {
            self::$arrStaticCollection['style'] = self::$arrStylePool;
        }

        //異步腳本
        if (self::$arrRequireAsyncCollection) {
            self::$arrStaticCollection['async'] = self::getResourceMap(self::$arrRequireAsyncCollection, self::getCdn('async'));
        }
        unset(self::$arrStaticCollection['tpl']);
        return self::$arrStaticCollection;
    }

    //獲取異步js資源集合，變為json格式的resourcemap
    public static function getResourceMap($arr, $cdn = '') {
        $ret = '';
        $arrResourceMap = array();
        if (isset($arr['res'])) {
            foreach ($arr['res'] as $id => $arrRes) {
                $deps = array();
                if (!empty($arrRes['deps'])) {
                    foreach ($arrRes['deps'] as $strName) {
                        if (preg_match('/\.js$/i', $strName)) {
                            $deps[] = $strName;
                        }
                    }
                }

                $arrResourceMap['res'][$id] = array(
                    'url' => $cdn . $arrRes['uri'],
                );

                if (!empty($arrRes['pkg'])) {
                    $arrResourceMap['res'][$id]['pkg'] = $arrRes['pkg'];
                    //如果包含到了某一個包，則模塊的url是多余的
                    if (!isset($_GET['fis_debug'])) {
                        //@TODO
                        unset($arrResourceMap['res'][$id]['url']);
                    }
                }

                if (!empty($deps)) {
                    $arrResourceMap['res'][$id]['deps'] = $deps;
                }
            }
        }
        if (isset($arr['pkg'])) {
            foreach ($arr['pkg'] as $id => $arrRes) {
                $arrResourceMap['pkg'][$id] = array(
                    'url' => $cdn . $arrRes['uri'],
                    'has' => $arrRes['has']
                );
            }
        }
        if (!empty($arrResourceMap)) {
            $ret = $arrResourceMap;
        }
        return  $ret;
    }

    //獲取命名空間的map.json
    public static function register($strNamespace, $smarty){
        if($strNamespace === '__global__'){
            $strMapName = 'map';
        } else {
            $strMapName = $strNamespace . '-map';
        }
        $arrConfigDir = $smarty->getConfigDir();
        foreach ($arrConfigDir as $strDir) {
            $strPath = preg_replace('/[\\/\\\\]+/', '/', $strDir . '/' . $strMapName);
            if(is_file($strPath . '.php')){
                self::$arrMap[$strNamespace] = require($strPath . '.php');
                return true;
            } else if (is_file($strPath . '.json')) {
                self::$arrMap[$strNamespace] = json_decode(file_get_contents($strPath . '.json'), true);
                return true;
            }
        }
        return false;
    }

    public static function getUri($strName, $smarty) {
        $infos = self::getStaticInfo($strName, $smarty);
        return $infos['uri'];
    }

	public static function getStaticInfo($strName, $smarty) {
        $intPos = strpos($strName, ':');
        if($intPos === false){
            $strNamespace = '__global__';
        } else {
            $strNamespace = substr($strName, 0, $intPos);
        }
        if(isset(self::$arrMap[$strNamespace]) || self::register($strNamespace, $smarty)) {
            $arrMap = &self::$arrMap[$strNamespace];
            $arrRes = &$arrMap['res'][str_replace($strNamespace.":","",$strName)];
            if (isset($arrRes)) {
                return $arrRes;
            }
        }
    }

    /**
     * 分析組件依賴
     * @param array $arrRes  組件信息
     * @param Object $smarty  smarty對象
     * @param bool $async   是否異步
     */
    private static function loadDeps($arrRes, $smarty, $async) {
        if(isset($arrRes['deps'])){
            foreach ($arrRes['deps'] as $strDep) {
                self::load($strDep, $smarty, $async);
            }
        }

        //require.async
        if (isset($arrRes['extras']) && isset($arrRes['extras']['async'])) {
            foreach ($arrRes['extras']['async'] as $uri) {
                self::load($uri, $smarty, true);
            }
        }
    }

    /**
     * 已經分析到的組件在後續被同步使用時在異步組裡刪除。
     * @param $strName
     * @return bool
     */
    private static function delAsyncDeps($strName) {
        if (isset(self::$arrAsyncDeleted[$strName])) {
            return true;
        } else {
            self::$arrAsyncDeleted[$strName] = true;
            $arrRes = self::getAsync($strName, 'res');
            if ($arrRes['pkg']) {
                $arrPkg = self::getAsync($arrRes['pkg'], 'pkg');
                if ($arrPkg) {
                    self::addStatic($arrPkg['uri'], 'js');
                    self::delAsync($arrRes['pkg'], 'pkg');
                    foreach ($arrPkg['has'] as $strHas) {
                        self::$arrLoaded[$strHas] = $arrPkg['uri'];
                        if (self::getAsync($strHas, 'res')) {
                            self::delAsyncDeps($strHas);
                        }
                    }
                } else {
                    self::delAsync($strName, 'res');
                }
            } else {
                //已經分析過的並且在其他文件裡同步加載的組件，重新收集在同步輸出組
                $res = self::getAsync($strName, 'res');
                self::addStatic($res['uri'], 'js');
                self::$arrLoaded[$strName] = $res['uri'];
                self::delAsync($strName, 'res');
            }
            if ($arrRes['deps']) {
                foreach ($arrRes['deps'] as $strDep) {
                    //if (isset(self::$arrRequireAsyncCollection['res'][$strDep])) {
                    if (self::getAsync($strDep, 'res')) {
                        self::delAsyncDeps($strDep);
                    }
                }
            }
        }
    }

    /**
     * 加載組件以及組件依賴
     * @param $strName      id
     * @param $smarty       smarty對象
     * @param bool $async   是否為異步組件（only JS）
     * @return mixed
     */
    public static function load($strName, $smarty, $async = false){
        if(isset(self::$arrLoaded[$strName])) {
            //同步組件優先級比異步組件高
            if (!$async && self::getAsync($strName, 'res')) {
                self::delAsyncDeps($strName);
            }
            return self::$arrLoaded[$strName];
        } else {
            $intPos = strpos($strName, ':');
            if($intPos === false){
                $strNamespace = '__global__';
            } else {
                $strNamespace = substr($strName, 0, $intPos);
            }
            if(isset(self::$arrMap[$strNamespace]) || self::register($strNamespace, $smarty)){
                $arrMap = &self::$arrMap[$strNamespace];
                $arrRes = &$arrMap['res'][str_replace($strNamespace.":","",$strName)];
                $arrPkg = null;
                $arrPkgHas = array();
                if(isset($arrRes)) {
                    if(!array_key_exists('fis_debug', $_GET) && isset($arrRes['pkg'])){
                        $arrPkg = &$arrMap['pkg'][$arrRes['pkg']];
                        $strURI = $arrPkg['uri'];
                        foreach ($arrPkg['has'] as $strResId) {
                            self::$arrLoaded[$strResId] = $strURI;
                        }
                        foreach ($arrPkg['has'] as $strResId) {
                            $arrHasRes = &$arrMap['res'][$strResId];
                            if ($arrHasRes) {
                                $arrPkgHas[$strResId] = $arrHasRes;
                                self::loadDeps($arrHasRes, $smarty, $async);
                            }
                        }
                    } else {
                        $strURI = $arrRes['uri'];
                        self::$arrLoaded[$strName] = $strURI;
                        self::loadDeps($arrRes, $smarty, $async);
                    }

                    if ($async && $arrRes['type'] === 'js') {
                        if ($arrPkg) {
                            self::addAsync($arrRes['pkg'], $arrPkg, 'pkg');
                            foreach ($arrPkgHas as $id => $val) {
                                self::addAsync($id, $val, 'res');
                            }
                        } else {
                            self::addAsync($strName, $arrRes, 'res');
                        }
                    } else {
                        self::addStatic($strURI, $arrRes['type']);
                    }
                    return $strURI;
                } else {
                    self::triggerError($strName, 'undefined resource "' . $strName . '"', E_USER_NOTICE);
                }
            } else {
                self::triggerError($strName, 'missing map file of "' . $strNamespace . '"', E_USER_NOTICE);
            }
        }
        self::triggerError($strName, 'unknown resource "' . $strName . '" load error', E_USER_NOTICE);
    }

    /**
     * 用戶代碼自定義js組件，其沒有對應的文件
     * 只有有後綴的組件找不到時進行報錯
     * @param $strName       組件ID
     * @param $strMessage    錯誤信息
     * @param $errorLevel    錯誤level
     */
    private static function triggerError($strName, $strMessage, $errorLevel) {
        $arrExt = array(
            'js',
            'css',
            'tpl',
            'html',
            'xhtml',
        );
        if (preg_match('/\.('.implode('|', $arrExt).')$/', $strName)) {
            trigger_error(date('Y-m-d H:i:s') . '   ' . $strName . ' ' . $strMessage, $errorLevel);
        }
    }

}
