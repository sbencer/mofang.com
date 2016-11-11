<?php
/**
 *  模板解析緩存
 */
final class template_cache {
	
	/**
	 * 編譯模板
	 *
	 * @param $module	模塊名稱
	 * @param $template	模板文件名
	 * @param $istag	是否為標簽模板
	 * @return unknown
	 */
	
public function template_compile($module, $template, $style = 'default') {

		$tplfile = $_tpl = PC_PATH.'templates/'.$style.'/'.$module.'/'.$template.'.html';
		if ($style != 'default' && ! file_exists ( $tplfile )) {
			$tplfile = PC_PATH.'templates/default/'.$module.'/'.$template.'.html';
		}
		
		if (! file_exists ( $tplfile )) {

			showmessage ( "$_tpl is not exists!" );
		}
		$content = @file_get_contents ( $tplfile );
		
		$filepath = PHPCMS_PATH.'caches/caches_template/'.$module.'/';
	    if(!is_dir($filepath)) {
			mkdir($filepath, 0777, true);
	    }
		$compiledtplfile = $filepath.$template.'.'.$style.'.php';
		$content = $this->template_parse($content);
		$strlen = file_put_contents ( $compiledtplfile, $content );
		chmod ( $compiledtplfile, 0777 );

		return $strlen;
	}
public function template_compile_admin($module, $template) {

		$tplfile = $_tpl = PC_PATH.'templates/admin/'.$module.'/'.$template.'.html';
		$content = @file_get_contents ( $tplfile );
		$filepath = PHPCMS_PATH.'caches/caches_template/admintpl/'.$module.'/';
	    if(!is_dir($filepath)) {
			mkdir($filepath, 0777, true);
	    }
		$compiledtplfile = $filepath.$template.'.php';
		$content = $this->template_parse($content);
		$strlen = file_put_contents ( $compiledtplfile, $content );
		chmod ( $compiledtplfile, 0777 );
		return $strlen;
	}
	/**
	 * 更新模板緩存
	 *
	 * @param $tplfile	模板原文件路徑
	 * @param $compiledtplfile	編譯完成後，寫入文件名
	 * @return $strlen 長度
	 */
public function template_refresh($tplfile, $compiledtplfile) {
		$str = @file_get_contents ($tplfile);
		$str = $this->template_parse ($str);
		$strlen = file_put_contents ($compiledtplfile, $str );
		chmod ($compiledtplfile, 0777);
		return $strlen;
	}
	/**
	 * 更新指定模塊模板緩存
	 *
	 * @param $module	模塊名稱
	 * @return ture
	 */
public function template_module($module) {
		$files = glob ( TPL_ROOT . TPL_NAME . '/' . $module . '/*.html' );
		if (is_array ( $files )) {
			foreach ( $files as $tpl ) {
				$template = str_replace ( '.html', '', basename ( $tpl ) );
				$this->template_compile ( $module, $template );
			}
		}
		return TRUE;
	}
	/**
	 * 更新所有模板緩存
	 *
	 * @return ture
	 */
public function template_cache() {
		global $MODULE;
		if(!is_array($MODULE)) return FALSE;
		foreach ( $MODULE as $module => $m ) {
			$this->template_module ( $module );
		}
		return TRUE;
	}

	/**
	 * 解析模板
	 *
	 * @param $str	模板內容
	 * @param $istag	是否為標簽模板
	 * @return ture
	 */
public function template_parse($str, $istag = 0) {
		$str = preg_replace ( "/([\n\r]+)\t+/s", "\\1", $str );
		$str = preg_replace ( "/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $str );
		$str = preg_replace ( "/\{template\s+(.+)\}/", "<?php include template(\\1); ?>", $str );
		$str = preg_replace ( "/\{include\s+(.+)\}/", "<?php include \\1; ?>", $str );
		$str = preg_replace ( "/\{php\s+(.+)\}/", "<?php \\1?>", $str );
		$str = preg_replace ( "/\{if\s+(.+?)\}/", "<?php if(\\1) { ?>", $str );
		$str = preg_replace ( "/\{else\}/", "<?php } else { ?>", $str );
		$str = preg_replace ( "/\{elseif\s+(.+?)\}/", "<?php } elseif (\\1) { ?>", $str );
		$str = preg_replace ( "/\{\/if\}/", "<?php } ?>", $str );
		//for 循環
		$str = preg_replace("/\{for\s+(.+?)\}/","<?php for(\\1) { ?>",$str);
		$str = preg_replace("/\{\/for\}/","<?php } ?>",$str);
		//++ --
		$str = preg_replace("/\{\+\+(.+?)\}/","<?php ++\\1; ?>",$str);
		$str = preg_replace("/\{\-\-(.+?)\}/","<?php ++\\1; ?>",$str);
		$str = preg_replace("/\{(.+?)\+\+\}/","<?php \\1++; ?>",$str);
		$str = preg_replace("/\{(.+?)\-\-\}/","<?php \\1--; ?>",$str);
		$str = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\}/", "<?php if(is_array(\\1)) foreach(\\1 AS \\2) { ?>", $str );
		$str = preg_replace ( "/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/", "<?php if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>", $str );
		$str = preg_replace ( "/\{\/loop\}/", "<?php } ?>", $str );
		$str = preg_replace ( "/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace ( "/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace ( "/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", "<?php echo \\1;?>", $str );
		$str = preg_replace("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/es", "\$this->addquote('<?php echo \\1;?>')",$str);
		$str = preg_replace ( "/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>", $str );
		if (! $istag)
			$str = "<?php defined('IN_PHPCMS') or exit('No permission resources.'); ?>" . $str;
		return $str;
	}

	/**
	 * 轉義 // 為 /
	 *
	 * @param $var	轉義的字符
	 * @return 轉義後的字符
	 */
public function addquote($var) {
		return str_replace ( "\\\"", "\"", preg_replace ( "/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var ) );
	}
}
?>
