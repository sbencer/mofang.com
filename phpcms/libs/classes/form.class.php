<?php
class form {
	/**
	 * 編輯器
	 * @param int $textareaid
	 * @param int $toolbar
	 * @param string $module 模塊名稱
	 * @param int $catid 欄目id
	 * @param int $color 編輯器顏色
	 * @param boole $allowupload  是否允許上傳
	 * @param boole $allowbrowser 是否允許瀏覽文件
	 * @param string $alowuploadexts 允許上傳類型
	 * @param string $height 編輯器高度
	 * @param string $disabled_page 是否禁用分頁和子標題
	 */
	public static function editor($textareaid = 'content', $toolbar = 'basic', $module = '', $catid = '', $color = '', $allowupload = 0, $allowbrowser = 1,$alowuploadexts = '',$height = 200,$disabled_page = 0, $allowuploadnum = '10') {
		$str ='';
		if(!defined('EDITOR_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'ckeditor/ckeditor.js"></script>';
			define('EDITOR_INIT', 1);
		}
		if($toolbar == 'basic') {
			$toolbar = defined('IN_ADMIN') ? "['Source']," : '';
			$toolbar .= "['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],['Maximize'],\r\n";
		} elseif($toolbar == 'full') {
			if(defined('IN_ADMIN')) {
				$toolbar = "['Source',";
			} else {
				$toolbar = '[';
			}
			$toolbar .= "'-','Templates'],
		    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
		    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['ShowBlocks'],['Image','Capture','Flash','MyVideo','YouKu'],['Maximize'],
		    '/',
		    ['Bold','Italic','Underline','Strike','-'],
		    ['Subscript','Superscript','-'],
		    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		    ['Link','Unlink','Anchor'],
		    ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		    '/',
		    ['Styles','Format','Font','FontSize'],
		    ['TextColor','BGColor'],
		    ['attachment'],\r\n";
		} elseif($toolbar == 'desc') {
			$toolbar = "['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Image', '-','Source'],['Maximize'],\r\n";
		} else {
			$toolbar = '';
		}
		$str .= "<script type=\"text/javascript\">\r\n";
		$str .= "CKEDITOR.replace( '$textareaid',{";
		$str .= "height:{$height},";

		$show_page = ($module == 'content' && !$disabled_page) ? 'true' : 'false';
		$str .="pages:$show_page,subtitle:$show_page,textareaid:'".$textareaid."',module:'".$module."',catid:'".$catid."',\r\n";
		if($allowupload) {
			$authkey = upload_key("$allowuploadnum,$alowuploadexts,$allowbrowser");
			$str .="flashupload:true,alowuploadexts:'".$alowuploadexts."',allowbrowser:'".$allowbrowser."',allowuploadnum:'".$allowuploadnum."',authkey:'".$authkey."',\r\n";
		}
        if($allowupload) $str .= "filebrowserUploadUrl : '".APP_PATH."index.php?m=attachment&c=attachments&a=upload&module=".$module."&catid=".$catid."&dosubmit=1',\r\n";
		if($color) {
			$str .= "extraPlugins : 'uicolor',uiColor: '$color',";
		}
		$str .= "toolbar :\r\n";
		$str .= "[\r\n";
		$str .= $toolbar;
		$str .= "]\r\n";
		//$str .= "fullPage : true";
		$str .= "});\r\n";
		$str .= '</script>';
		$ext_str = "<div class='editor_bottom'>";
		if(!defined('IMAGES_INIT')) {
			$ext_str .= '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$ext_str .= "<div id='page_title_div'>
		<table cellpadding='0' cellspacing='1' border='0'><tr><td class='title'>".L('subtitle')."<span id='msg_page_title_value'></span></td><td>
		<a class='close' href='javascript:;' onclick='javascript:$(\"#page_title_div\").hide();'><span>×</span></a></td>
		<tr><td colspan='2'><input name='page_title_value' id='page_title_value' class='input-text' value='' size='30'>&nbsp;<input type='button' class='button' value='".L('submit')."' onclick=insert_page_title(\"$textareaid\",1)></td></tr>
		</table></div>";
		$ext_str .= "</div>";
		if(is_ie()) $ext_str .= "<div style='display:none'><OBJECT id='PC_Capture' classid='clsid:021E8C6F-52D4-42F2-9B36-BCFBAD3A0DE4'><PARAM NAME='_Version' VALUE='0'><PARAM NAME='_ExtentX' VALUE='0'><PARAM NAME='_ExtentY' VALUE='0'><PARAM NAME='_StockProps' VALUE='0'></OBJECT></div>";
		$str .= $ext_str;
		return $str;
	}

	/**
	 *
	 * @param string $name 表單名稱
	 * @param int $id 表單id
	 * @param string $value 表單默認值
	 * @param string $moudle 模塊名稱
	 * @param int $catid 欄目id
	 * @param int $size 表單大小
	 * @param string $class 表單風格
	 * @param string $ext 表單擴展屬性 如果 js事件等
	 * @param string $alowexts 允許圖片格式
	 * @param array $thumb_setting
	 * @param int $watermark_setting  0或1
	 */
	public static function images($name, $id = '', $value = '', $moudle='', $catid='', $size = 50, $class = '', $ext = '', $alowexts = '',$thumb_setting = array(),$watermark_setting = 0 ) {
		if(!$id) $id = $name;
		if(!$size) $size= 50;
		if(!empty($thumb_setting) && count($thumb_setting)) $thumb_ext = $thumb_setting[0].','.$thumb_setting[1];
		else $thumb_ext = ',';
		if(!$alowexts) $alowexts = 'jpg|jpeg|gif|bmp|png';
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("1,$alowexts,1,$thumb_ext,$watermark_setting");
		return $str."<input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $ext/>  <input type=\"button\" class=\"button\" onclick=\"javascript:flashupload('{$id}_images', '".L('attachmentupload')."','{$id}',submit_images,'1,{$alowexts},1,{$thumb_ext},{$watermark_setting}','{$moudle}','{$catid}','{$authkey}')\"/ value=\"".L('imagesupload')."\">";
	}

	/**
	 *
	 * @param string $name 表單名稱
	 * @param int $id 表單id
	 * @param string $value 表單默認值
	 * @param string $moudle 模塊名稱
	 * @param int $catid 欄目id
	 * @param int $size 表單大小
	 * @param string $class 表單風格
	 * @param string $ext 表單擴展屬性 如果 js事件等
	 * @param string $alowexts 允許上傳的文件格式
	 * @param array $file_setting
	 */
	public static function upfiles($name, $id = '', $value = '', $moudle='', $catid='', $size = 50, $class = '', $ext = '', $alowexts = '',$file_setting = array() ) {
		if(!$id) $id = $name;
		if(!$size) $size= 50;
		if(!empty($file_setting) && count($file_setting)) $file_ext = $file_setting[0].','.$file_setting[1];
		else $file_ext = ',';
		if(!$alowexts) $alowexts = 'rar|zip';
		if(!defined('IMAGES_INIT')) {
			$str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
			define('IMAGES_INIT', 1);
		}
		$authkey = upload_key("1,$alowexts,1,$file_ext");
		return $str."<input type=\"text\" name=\"$name\" id=\"$id\" value=\"$value\" size=\"$size\" class=\"$class\" $ext/>  <input type=\"button\" class=\"button\" onclick=\"javascript:flashupload('{$id}_files', '".L('attachmentupload')."','{$id}',submit_attachment,'1,{$alowexts},1,{$file_ext}','{$moudle}','{$catid}','{$authkey}')\"/ value=\"".L('filesupload')."\">";
	}

	/**
	 * 日期時間控件
	 *
	 * @param $name 控件name，id
	 * @param $value 選中值
	 * @param $isdatetime 是否顯示時間
	 * @param $loadjs 是否重復加載js，防止頁面程序加載不規則導致的控件無法顯示
	 * @param $showweek 是否顯示周，使用，true | false
	 */
	public static function date($name, $value = '', $isdatetime = 0, $loadjs = 0, $showweek = 'true', $timesystem = 1) {
		if($value == '0000-00-00 00:00:00') $value = '';
		$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
		if($isdatetime) {
			$size = 21;
			$format = '%Y-%m-%d %H:%M:%S';
			if($timesystem){
				$showsTime = 'true';
			} else {
				$showsTime = '12';
			}

		} else {
			$size = 10;
			$format = '%Y-%m-%d';
			$showsTime = 'false';
		}
		$str = '';
		if($loadjs || !defined('CALENDAR_INIT')) {
			define('CALENDAR_INIT', 1);
			$str .= '<link rel="stylesheet" type="text/css" href="'.JS_PATH.'calendar/jscal2.css"/>
			<link rel="stylesheet" type="text/css" href="'.JS_PATH.'calendar/border-radius.css"/>
			<link rel="stylesheet" type="text/css" href="'.JS_PATH.'calendar/win2k.css"/>
			<script type="text/javascript" src="'.JS_PATH.'calendar/calendar.js"></script>
			<script type="text/javascript" src="'.JS_PATH.'calendar/lang/en.js"></script>';
		}
		$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" size="'.$size.'" class="date" readonly>&nbsp;';
		$str .= '<script type="text/javascript">
			Calendar.setup({
			weekNumbers: '.$showweek.',
		    inputField : "'.$id.'",
		    trigger    : "'.$id.'",
		    dateFormat: "'.$format.'",
		    showTime: '.$showsTime.',
		    minuteStep: 1,
		    onSelect   : function() {this.hide();}
			});
        </script>';
		return $str;
	}

	/**
	 * 專區選擇
	 * @param string $file 欄目緩存文件名
	 * @param intval $id 選中的ID，多選是可以是數組
	 * @param string $str 屬性
	 * @param string $default_option 默認選項
	 */
	public static function select_area($file = '',$id = 0, $str = '', $default_option = '') {
		$tree = pc_base::load_sys_class('tree');
		$result = getcache($file,'commons');
		$string = '<select '.$str.'>';
		if($default_option) $string .= "<option value='0'>$default_option</option>";
		if (is_array($result)) {
			foreach($result as $r) {
 				//檢查當前會員組，在該欄目處是否允許投稿？
				$r['selected'] = '';
				if(is_array($id)) {
					$r['selected'] = in_array($r['id'], $id) ? 'selected' : '';
				} elseif(is_numeric($id)) {
					$r['selected'] = $id==$r['id'] ? 'selected' : '';
				}
				$r['html_disabled'] = "0";
				if (!empty($onlysub) && $r['child'] != 0) {
					$r['html_disabled'] = "1";
				}
				$categorys[$r['id']] = $r;
				if($modelid && $r['modelid']!= $modelid ) unset($categorys[$r['id']]);
			}
		}
		$str  = "<option value='\$id' \$selected>\$spacer \$name</option>;";
		$str2 = "<optgroup label='\$spacer \$name'></optgroup>";

		$tree->init($categorys);
		$string .= $tree->get_tree_category(0, $str, $str2);

		$string .= '</select>';
		return $string;
	}


    /**
     * 分區欄目選擇
     * @param string $file 欄目緩存文件名
     * @param intval/array $catid 別選中的ID，多選是可以是數組
     * @param string $str 屬性
     * @param string $default_option 默認選項
     * @param intval $modelid 按所屬模型篩選
     * @param intval $type 欄目類型
     * @param intval $onlysub 只可選擇子欄目
     * @param intval $siteid 如果設置了siteid 那麼則按照siteid取
     */
    public static function select_partition( $is_content=0, $sub_catid = 0,$file = '',$catid = 0, $str = '', $default_option = '', $modelid = 0, $type = -1, $onlysub = 0,$sitid = 0,$is_push = 0) {
        $tree = pc_base::load_sys_class('tree');
        if(!$siteid) {
            $siteid = param::get_cookie('siteid');
        }
        if (!$file) {
            $file = 'category_content_'.$siteid;
        }
        //$result = getcache($file,'commons');
        //$partition_model = pc_base::load_model("category_model");
        $partition_model = pc_base::load_model("partition_model");
        if( !$is_content ){
            $temp_arrparentid = $partition_model->get_one("`module`='partition' AND `catid`=".$catid, 'arrparentid');
            $temp_arrparentid = explode(',', $temp_arrparentid['arrparentid']);
            $temp_catid = $temp_arrparentid[1] ? $temp_arrparentid[1] : $catid;
            $result = $partition_model->select("`module`='partition' AND `arrparentid` LIKE '%".$temp_catid."%' OR `catid`=".$temp_catid);
        }elseif( $sub_catid ){
            $result = $partition_model->select("`module`='partition' AND `arrparentid` LIKE '%".$sub_catid."%' OR `catid`=".$sub_catid);
        }else{
            $result = $partition_model->select("`module`='partition' AND `parentid`=0");
        }

        $string = '<select '.$str.'>';
        if($default_option) $string .= "<option value='0'>$default_option</option>";
        //加載權限表模型 ,獲取會員組ID值,以備下面投入判斷用
        if($is_push=='1'){
            $priv = pc_base::load_model('category_priv_model');
            $user_groupid = param::get_cookie('_groupid') ? param::get_cookie('_groupid') : 8;
        }
        if (is_array($result)) {
            foreach($result as $r) {

                //檢查當前會員組，在該欄目處是否允許投稿？
                if($is_push=='1' and $r['child']=='0'){
                    $sql = array('catid'=>$r['catid'],'roleid'=>$user_groupid,'action'=>'add');
                    $array = $priv->get_one($sql);
                    if(!$array){
                        continue;
                    }
                }
                if($siteid != $r['siteid'] || ($type >= 0 && $r['type'] != $type)) continue;
                $r['selected'] = '';
                if(is_array($catid)) {
                    $r['selected'] = in_array($r['catid'], $catid) ? 'selected' : '';
                } elseif(is_numeric($catid)) {
                    $r['selected'] = $catid==$r['catid'] ? 'selected' : '';
                }

                //ok
                $r['html_disabled'] = "0";
                //if (!empty($onlysub) && $r['child'] != 0) {
                //if (!empty($onlysub) && $r['arrchildid'] != $r['catid']) {
                if (!empty($onlysub) && $r['parentid'] == 0 ) {
                    $r['html_disabled'] = "1";
                }

                $categorys[$r['catid']] = $r;
                if ($modelid && $r['modelid']!= $modelid ) {
                    unset($categorys[$r['catid']]);
                }
            }
        }
        $str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>;";
        $str2 = "<optgroup label='\$spacer \$catname'></optgroup>";

        $tree->init($categorys);
        $string .= $tree->get_tree_category(0, $str, $str2);

        $string .= '</select>';
        return $string;
    }

	/**
	 * 欄目選擇
	 * @param string $file 欄目緩存文件名
	 * @param intval/array $catid 別選中的ID，多選是可以是數組
	 * @param string $str 屬性
	 * @param string $default_option 默認選項
	 * @param intval $modelid 按所屬模型篩選
	 * @param intval $type 欄目類型
	 * @param intval $onlysub 只可選擇子欄目
	 * @param intval $siteid 如果設置了siteid 那麼則按照siteid取
	 */
	public static function select_category($file = '',$catid = 0, $str = '', $default_option = '', $modelid = 0, $type = -1, $onlysub = 0,$siteid = 0,$is_push = 0) {
		$tree = pc_base::load_sys_class('tree');
		if(!$siteid) $siteid = param::get_cookie('siteid');
		if (!$file) {
			$file = 'category_content_'.$siteid;
		}
		$result = getcache($file,'commons');
		$string = '<select '.$str.'>';
		if($default_option) $string .= "<option value='0'>$default_option</option>";
		//加載權限表模型 ,獲取會員組ID值,以備下面投入判斷用
		if($is_push=='1'){
			$priv = pc_base::load_model('category_priv_model');
			$user_groupid = param::get_cookie('_groupid') ? param::get_cookie('_groupid') : 8;
		}
		if (is_array($result)) {
			foreach($result as $r) {
 				//檢查當前會員組，在該欄目處是否允許投稿？
				if($is_push=='1' and $r['child']=='0'){
					$sql = array('catid'=>$r['catid'],'roleid'=>$user_groupid,'action'=>'add');
					$array = $priv->get_one($sql);
					if(!$array){
						continue;
					}
				}
				if($siteid != $r['siteid'] || ($type >= 0 && $r['type'] != $type)) continue;
				$r['selected'] = '';
				if(is_array($catid)) {
					$r['selected'] = in_array($r['catid'], $catid) ? 'selected' : '';
				} elseif(is_numeric($catid)) {
					$r['selected'] = $catid==$r['catid'] ? 'selected' : '';
				}
				$r['html_disabled'] = "0";
				if (!empty($onlysub) && $r['child'] != 0) {
					$r['html_disabled'] = "1";
				}
				$categorys[$r['catid']] = $r;
				if($modelid && $r['modelid']!= $modelid ) unset($categorys[$r['catid']]);
			}
		}
		$str  = "<option value='\$catid' \$selected>\$spacer \$catname</option>;";
		$str2 = "<optgroup label='\$spacer \$catname'></optgroup>";

		$tree->init($categorys);
		$string .= $tree->get_tree_category(0, $str, $str2);

		$string .= '</select>';
		return $string;
	}

	public static function select_linkage($keyid = 0, $parentid = 0, $name = 'parentid', $id ='', $alt = '', $linkageid = 0, $property = '') {
		$tree = pc_base::load_sys_class('tree');
		$result = getcache($keyid,'linkage');
		$id = $id ? $id : $name;
		$string = "<select name='$name' id='$id' $property>\n<option value='0'>$alt</option>\n";
		if($result['data']) {
			foreach($result['data'] as $area) {
				$categorys[$area['linkageid']] = array('id'=>$area['linkageid'], 'parentid'=>$area['parentid'], 'name'=>$area['name']);
			}
		}
		$str  = "<option value='\$id' \$selected>\$spacer \$name</option>";

		$tree->init($categorys);
		$string .= $tree->get_tree($parentid, $str, $linkageid);

		$string .= '</select>';
		return $string;
	}
	/**
	 * 下拉選擇框
	 */
	public static function select($array = array(), $id = 0, $str = '', $default_option = '',$js = '') {
		$string = '<select '.$str.$js.'>';
		$default_selected = (empty($id) && $default_option) ? 'selected' : '';
		if($default_option) $string .= "<option value='' $default_selected>$default_option</option>";
		if(!is_array($array) || count($array)== 0) return false;
		$ids = array();
		if(isset($id)) $ids = explode(',', $id);
		foreach($array as $key=>$value) {
			$selected = in_array($key, $ids) ? 'selected' : '';
			$string .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
		$string .= '</select>';
		return $string;
	}

	/**
	 * 復選框
	 *
	 * @param $array 選項 二維數組
	 * @param $id 默認選中值，多個用 '逗號'分割
	 * @param $str 屬性
	 * @param $defaultvalue 是否增加默認值 默認值為 -99
	 * @param $width 寬度
	 */
	public static function checkbox($array = array(), $id = '', $str = '', $defaultvalue = '', $width = 0, $field = '') {
		$string = '';
		$id = trim($id);
		if($id != '') $id = strpos($id, ',') ? explode(',', $id) : array($id);
		if($defaultvalue) $string .= '<input type="hidden" '.$str.' value="-99">';
		$i = 1;
		foreach($array as $key=>$value) {
			$key = trim($key);
			$checked = ($id && in_array($key, $id)) ? 'checked' : '';
			if($width) $string .= '<label class="ib" style="width:'.$width.'px">';
			$string .= '<input type="checkbox" '.$str.' id="'.$field.'_'.$i.'" '.$checked.' value="'.new_html_special_chars($key).'"> '.new_html_special_chars($value);
			if($width) $string .= '</label>';
			$i++;
		}
		return $string;
	}

	/**
	 * 單選框
	 *
	 * @param $array 選項 二維數組
	 * @param $id 默認選中值
	 * @param $str 屬性
	 */
	public static function radio($array = array(), $id = 0, $str = '', $width = 0, $field = '') {
		$string = '';
		foreach($array as $key=>$value) {
			$checked = trim($id)==trim($key) ? 'checked' : '';
			if($width) $string .= '<label class="ib" style="width:'.$width.'px">';
			$string .= '<input type="radio" '.$str.' id="'.$field.'_'.new_html_special_chars($key).'" '.$checked.' value="'.$key.'"> '.$value;
			if($width) $string .= '</label>';
		}
		return $string;
	}
	/**
	 * 模板選擇
	 * 
	 * @param $style  風格
	 * @param $module 模塊
	 * @param $id 默認選中值
	 * @param $str 屬性
	 * @param $pre 模板前綴
	 */
	public static function select_template($style, $module, $id = '', $str = '', $pre = '') {
        $tpl_root = pc_base::load_config('system', 'tpl_root');
		$templatedir = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
		$templatedir = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR;
		$confing_path = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.'config.tpl';
        $localdir = str_replace(array('/', '\\'), '|', $tpl_root).'|'.$style;
		$templates = glob($templatedir.$pre.'*.tpl');
		if(empty($templates)) {
			$style = 'default';
			$templatedir = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR;
			$confing_path = PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.'config.tpl';
			$localdir = str_replace(array('/', '\\'), '', $tpl_root).'|'.$style.'|'.$module;
			$templates = glob($templatedir.$pre.'*.html');
		}
		if(empty($templates)) return false;
		$files = @array_map('basename', $templates);
		$names = array();
		if(file_exists($confing_path)) {
			$names = include $confing_path;
		}
		$templates = array();
		if(is_array($files)) {
			foreach($files as $file) {
				$key = substr($file, 0, -5);
				$key = pathinfo($file, PATHINFO_FILENAME);
				$templates[$key] = isset($names['file_explan'][$localdir][$file]) && !empty($names['file_explan'][$localdir][$file]) ? $names['file_explan'][$localdir][$file].'('.$file.')' : $file;
			}
		}
		ksort($templates);
		return self::select($templates, $id, $str,L('please_select'));
	}

	/**
	 * 驗證碼
	 * @param string $id            生成的驗證碼ID
	 * @param integer $code_len     生成多少位驗證碼
	 * @param integer $font_size    驗證碼字體大小
	 * @param integer $width        驗證圖片的寬
	 * @param integer $height       驗證碼圖片的高
	 * @param string $font          使用什麼字體，設置字體的URL
	 * @param string $font_color    字體使用什麼顏色
	 * @param string $background    背景使用什麼顏色
	 */
	public static function checkcode($id = 'checkcode',$code_len = 4, $font_size = 20, $width = 130, $height = 50, $font = '', $font_color = '', $background = '') {
		return "<img id='$id' onclick='this.src=this.src+\"&\"+Math.random()' src='".SITE_PROTOCOL.SITE_URL.WEB_PATH."api.php?op=checkcode&code_len=$code_len&font_size=$font_size&width=$width&height=$height&font_color=".urlencode($font_color)."&background=".urlencode($background)."'>";
	}
	/**
	 * url  規則調用
	 *
	 * @param $module 模塊
	 * @param $file 文件名
	 * @param $ishtml 是否為靜態規則
	 * @param $id 選中值
	 * @param $str 表單屬性
	 * @param $default_option 默認選項
	 */
	public static function urlrule($module, $file, $ishtml, $id, $str = '', $default_option = '') {
		if(!$module) $module = 'content';
		$urlrules = getcache('urlrules_detail','commons');
		$array = array();
		foreach($urlrules as $roleid=>$rules) {
			if($rules['module'] == $module && $rules['file']==$file && $rules['ishtml']==$ishtml) $array[$roleid] = $rules['example'];
		}

		return form::select($array, $id,$str,$default_option);
	}

   /**
    *
    * @param string $name 表單名稱
    * @param int $id 表單id
    * @param string $value 表單默認值
    * @param string $moudle 模塊名稱
    * @param int $catid 欄目id
    * @param int $size 表單大小
    * @param string $class 表單風格
    * @param string $ext 表單擴展屬性 如果 js事件等
    * @param string $alowexts 允許圖片格式
    * @param array $thumb_setting
    * @param int $watermark_setting  0或1
    */
   public static function images_partition($name, $id = '', $value = '', $moudle='', $catid='', $size = 50, $class = '', $ext = '', $alowexts = '',$thumb_setting = array(),$watermark_setting = 0 ) {
       if(!$id) $id = $name;
       if(!$size) $size= 50;
       if(!empty($thumb_setting) && count($thumb_setting)) $thumb_ext = $thumb_setting[0].','.$thumb_setting[1];
       else $thumb_ext = ',';
       if(!$alowexts) $alowexts = 'jpg|jpeg|gif|bmp|png';
       if(!defined('IMAGES_INIT')) {
           $str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
           define('IMAGES_INIT', 1);
       }
       $authkey = upload_key("1,$alowexts,1,$thumb_ext,$watermark_setting");
       return $str."<input type='text' name='{$name}' id='$id' value='$value' size='$size' class='$class' $ext/>  <input type='button' class='button' onclick=\"javascript:flashupload('{$id}_images', '".L('attachmentupload')."','{$id}',submit_images,'1,{$alowexts},1,{$thumb_ext},{$watermark_setting}','{$moudle}','{$catid}','{$authkey}')\" value='".L('imagesupload')."'>";
   }

}
?>
