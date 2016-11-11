<?php
/**
 *  contentpage.class.php 文章內容頁分頁類
 *  
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-8-12
 */

class contentpage {
	private $additems = array (); //定義需要補全的開頭html代碼
	private $bottonitems = array (); //定義需要補全的結尾HTML代碼
	private $html_tag = array (); //HTML標記數組
	private $surplus; //剩余字符數
	public $content; //定義返回的字符
	
	public function __construct() {
		//定義HTML數組
		$this->html_tag = array ('p', 'div', 'h', 'span', 'strong', 'ul', 'ol', 'li', 'table', 'tr', 'tbody', 'dl', 'dt', 'dd');
		$this->html_end_tag = array ('/p', '/div', '/h', '/span', '/strong', '/ul', '/ol', '/li', '/table', '/tr', '/tbody', '/dl', '/dt', '/dd');
		$this->content = ''; //臨時內容存儲器
		$this->data = array(); //內容存儲
	}
	
	/**
	 * 處理並返回字符串
	 * 
	 * @param string $content 待處理的字符串
	 * @param intval $maxwords 每頁最大字符數。去除HTML標記後字符數
	 * @return 處理後的字符串
	 */
	public function get_data($content = '', $maxwords = 10000) {
		if (!$content) return '';
		$this->data = array();
		$this->content = '';
		//exit($maxwords);
		$this->surplus = $maxwords; //開始時將剩余字符設置為最大
		//判斷是否存在html標記，不存在直接按字符數分頁；如果存在HTML標記，需要補全缺失的HTML標記
		if (strpos($content, '<')!==false) {
			$content_arr = explode('<', $content); //將字符串按‘<’分割成數組
			$this->total = count($content_arr); //計算數組值的個數，便於計算是否執行到字符串的尾部
			foreach ($content_arr as $t => $c) {
				if ($c) {
					$s = strtolower($c); //大小寫不區分
					//$isadd = 0;
					
					if ((strpos($c, ' ')!==false) && (strpos($c, '>')===false)) {
						$min_point = intval(strpos($c, ' '));
					} elseif ((strpos($c, ' ')===false) && (strpos($c, '>')!==false)) {
						$min_point = intval(strpos($c, '>'));
					} elseif ((strpos($c, ' ')!==false) && (strpos($c, '>')!==false)) {
						$min_point = min(intval(strpos($c, ' ')), intval(strpos($c, '>')));
					}
					$find = substr($c, 0, $min_point);
					//if ($t>26) echo $s.'{}'.$find.'<br>';
					//preg_match('/(.*)([^>|\s])/i', $c, $matches);
					if (in_array(strtolower($find), $this->html_tag)) {
						$str = '<'.$c;
						$this->bottonitems[$t] = '</'.$find.'>'; //屬於定義的HTML範圍，將結束標記存入補全的結尾數組
						if(preg_match('/<'.$find.'(.*)>/i', $str, $match)) {
							$this->additems[$t] = $match[0]; //匹配出開始標記，存入補全的開始數組
						}
						$this->separate_content($str, $maxwords, $match[0], $t); //加入返回字符串中
					} elseif (in_array(strtolower($find), $this->html_end_tag)) { //判斷是否屬於定義的HTML結尾標記
						ksort($this->bottonitems); 
						ksort($this->additems);
						if (is_array($this->bottonitems) && !empty($this->bottonitems)) array_pop($this->bottonitems); //當屬於是，將開始和結尾的補全數組取消一個
						if (is_array($this->additems) && !empty($this->additems)) array_pop($this->additems);
						$str = '<'.$c;
						$this->separate_content($str, $maxwords, '', $t); //加入返回字符串中
					} else {
						$tag = '<'.$c;
						if ($this->surplus >= 0) {
							$this->surplus = $this->surplus-strlen(strip_tags($tag));
							if ($this->surplus<0) {
								$this->surplus = 0;
							}
						}
						$this->content .= $tag; //不在定義的HTML標記範圍，則將其追加到返回字符串中
						if (intval($t+1) == $this->total) { //判斷是否還有剩余字符
							$this->content .= $this->bottonitem();
							$this->data[] = $this->content;
						}
					}
				}
			}
		} else {
			$this->content .= $this->separate_content($content, $maxwords); //純文字時
		}
		return implode('[page]', $this->data);
	}
	
	/**
	 * 處理每條數據
	 * @param string $str 每條數據
	 * @param intval $max 每頁的最大字符
	 * @param string $tag HTML標記
	 * @param intval $t 處理第幾個數組,方便判斷是否到字符串的末尾
	 * @param intval $n 處理的次數
	 * @param intval $total 總共的次數，防止死循環
	 * @return boolen
	 */
	private function separate_content($str = '', $max, $tag = '', $t = 0, $n = 1, $total = 0) {
		$html = $str;
		$str = strip_tags($str);
		if ($str) $str = @str_replace(array('　'), '', $str);
		if ($str) {
			if ($n == 1) {
				$total = ceil((strlen($str)-$this->surplus)/$max)+1;
			}
			if ($total<$n) {
				return true;
			} else {
				$n++;
			}
			if (strlen($str)>$this->surplus) { //當前字符數超過最大分頁數時
				$remove_str = str_cut($str, $this->surplus, '');
				$this->content .= $tag.$remove_str; //連同標記加入返回字符串
				$this->content .= $this->bottonitem(); //補全尾部標記
				$this->data[] = $this->content; //將臨時的內容放入數組中
				$this->content = ''; //設置為空
				$this->content .= $this->additem(); //補全開始標記
				$str = str_replace($remove_str, '', $str); //去除已加入
				$this->surplus = $max;
				return $this->separate_content($str, $max, '', $t, $n, $total); //判斷剩余字符
			} elseif (strlen($str)==$this->surplus) { //當前字符剛好等於時(彩票幾率)
				$this->content .= $html;
				$this->content .= $this->bottonitem();
				if (intval($t+1) != $this->total) { //判斷是否還有剩余字符
					$this->data[] = $this->content; //將臨時的內容放入數組中
					$this->content = ''; //設置為空
					$this->content .= $this->additem();
				}
				$this->surplus = $max;
			} else { //當前字符數少於最大分頁數
				$this->content .= $html;
				if (intval($t+1) == $this->total) { //判斷是否還有剩余字符
					$this->content .= $this->bottonitem();
					$this->data[] = $this->content;
				}
				$this->surplus = $this->surplus-strlen($str);
			}
		} else {
			$this->content .= $html;
			if ($this->surplus == 0) {
				$this->content .= $this->bottonitem();
				if (intval($t+1) != $this->total) { //判斷是否還有剩余字符
					$this->data[] = $this->content; //將臨時的內容放入數組中
					$this->content = ''; //設置為空
					$this->surplus = $max;
					$this->content .= $this->additem();
				}
			}
		}
		if ($t==($this->total-1)) {
			$pop_arr = array_pop($this->data);
			if ($pop = strip_tags($pop_arr)) {
				$this->data[] = $pop_arr;
			}
		}
		return true;
	}
	
	/**
	 * 補全開始HTML標記
	 */
	private function additem() {
		$content = '';
		if (is_array($this->additems) && !empty($this->additems)) {
			ksort($this->additems);
			foreach ($this->additems as $add) {
				$content .= $add;
			}
		}
		return $content;
	}
	
	/**
	 * 補全結尾HTML標記
	 */
	private function bottonitem() {
		$content = '';
		if (is_array($this->bottonitems) && !empty($this->bottonitems)) {
			krsort($this->bottonitems);
			foreach ($this->bottonitems as $botton) {
				$content .= $botton;
			}
		}
		return $content;
	}
	
}
?> 