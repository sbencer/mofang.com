<?php
/**
 * 中文分詞操作類
 * @author wangcanjia
 *
 */
class segment {
	public $rank_dic = array();
	public $one_name_dic = array();
	public $two_name_dic = array();
	public $new_word = array();
	public $source_string = '';
	public $result_string = '';
	public $split_char = ' '; //分隔符
	public $SplitLen = 4; //保留詞長度
	public $especial_char = "和|的|是";
	public $new_word_limit = "在|的|與|或|就|你|我|他|她|有|了|是|其|能|對|地";
	public $common_unit = "年|月|日|時|分|秒|點|元|百|千|萬|億|位|輛";
	public $cn_number = "０|１|２|３|４|５|６|７|８|９|＋|－|％|．|ａ|ｂ|ｃ|ｄ|ｅ|ｆ|ｇ|ｈ|ｉ|ｊ|ｋ|ｌ|ｍ|ｎ|ｏ|ｐ|ｑ|ｒ|ｓ |ｔ|ｕ|ｖ|ｗ|ｘ|ｙ|ｚ|Ａ|Ｃ|Ｄ|Ｅ|Ｆ|Ｇ|Ｈ|Ｉ|Ｊ|Ｋ|Ｌ|Ｍ|Ｎ|Ｏ|Ｐ|Ｑ|Ｒ|Ｓ|Ｔ|Ｕ|Ｖ|Ｗ|Ｘ|Ｙ|Ｚ";
	public $cn_sg_num = "一|二|三|四|五|六|七|八|九|十|百|千|萬|億|數";
	public $max_len = 13; //詞典最大 7 中文字，這裡的數值為字節數組的最大索引
	public $min_len = 3;  //最小 2 中文字，這裡的數值為字節數組的最大索引
	public $cn_two_name = "端木 南宮 譙笪 軒轅 令狐 鐘離 閭丘 長孫 鮮於 宇文 司徒 司空 上官 歐陽 公孫 西門 東門 左丘 東郭 呼延 慕容 司馬 夏侯 諸葛 東方 赫連 皇甫 尉遲 申屠";
	public $cn_one_name = "趙錢孫李周吳鄭王馮陳褚衛蔣沈韓楊朱秦尤許何呂施張孔曹嚴華金魏陶姜戚謝鄒喻柏水竇章雲蘇潘葛奚範彭郎魯韋昌馬苗鳳花方俞任袁柳酆鮑史唐費廉岑薛雷賀倪湯滕殷羅畢郝鄔安常樂於時傅皮卡齊康伍余元卜顧孟平黃穆蕭尹姚邵堪汪祁毛禹狄米貝明臧計伏成戴談宋茅龐熊紀舒屈項祝董粱杜阮藍閔席季麻強賈路婁危江童顏郭梅盛林刁鐘徐邱駱高夏蔡田樊胡凌霍虞萬支柯咎管盧莫經房裘繆干解應宗宣丁賁鄧郁單杭洪包諸左石崔吉鈕龔程嵇邢滑裴陸榮翁荀羊於惠甄魏加封芮羿儲靳汲邴糜鬆井段富巫烏焦巴弓牧隗谷車侯宓蓬全郗班仰秋仲伊宮寧仇欒暴甘鈄厲戎祖武符劉姜詹束龍葉幸司韶郜黎薊薄印宿白懷蒲台從鄂索咸籍賴卓藺屠蒙池喬陰郁胥能蒼雙聞莘黨翟譚貢勞逄姬申扶堵冉宰酈雍郤璩桑桂濮牛壽通邊扈燕冀郟浦尚農溫別莊晏柴翟閻充慕連茹習宦艾魚容向古易慎戈廖庚終暨居衡步都耿滿弘匡國文寇廣祿闕東毆殳沃利蔚越夔隆師鞏厙聶晁勾敖融冷訾辛闞那簡饒空曾沙須豐巢關蒯相查後江遊竺";
  
	function __construct($loaddic=true) {
  	if($loaddic) {
  	  for($i=0;$i<strlen($this->cn_one_name);$i++){
  		  $this->one_name_dic[$this->cn_one_name[$i].$this->cn_one_name[$i+1]] = 1;
  		  $i++;
  	  }
  	  $twoname = explode(" ",$this->cn_two_name);
  	  foreach($twoname as $n){ $this->two_name_dic[$n] = 1; }
  	  unset($twoname);
  	  unset($this->cn_two_name);
  	  unset($this->cn_one_name);
  	  $dicfile = PC_PATH.'libs'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'dict'.DIRECTORY_SEPARATOR.'dict.csv';
  	  $fp = fopen($dicfile,'r');
  	  while($line = fgets($fp,64)){
  		  $ws = explode(' ',$line);
  		  $this->rank_dic[strlen($ws[0])][$ws[0]] = $ws[1];
  	  }
  	  fclose($fp);
    }
  }

  function clear() {
  	unset($this->rank_dic);
  }
  function get_source($str) {
  	if(CHARSET == 'utf-8') $str = iconv('utf-8','gbk',$str);
  	$this->source_string = $str;
  	$this->result_string = '';
  }
  function simple_split($str) {
  	$this->source_string = $this->revise_string($str);
  	return $this->source_string;
  }
  function split_result($str='',$try_num_name=true,$try_diff=true) {
  	$str = trim($str);
  	if($str!='') $this->get_source($str);
  	else return '';
  	$this->source_string = preg_replace('/ {1,}/',' ',$this->revise_string($this->source_string));
  	$spwords = explode(' ',$this->source_string);
  	$spLen = count($spwords) - 1;
  	$spc = $this->split_char;
  	for($i=$spLen;$i>=0;$i--){
  		if(ord($spwords[$i][0])<33) continue;
  		else if(!isset($spwords[$i][$this->min_len])) $this->result_string = $spwords[$i].$spc.$this->result_string;
  		else if(ord($spwords[$i][0])<0x81){
  			$this->result_string = $spwords[$i].$spc.$this->result_string;
  		} else {
  		  $this->result_string = $this->split_mm($spwords[$i],$try_num_name,$try_diff).$spc.$this->result_string;
  	  }
  	}
  	if(CHARSET=='utf-8') $okstr = iconv('gbk','utf-8',$this->result_string);
  	else $okstr = $this->result_string;
  	return $okstr;
  }
  function par_number($str) {
  	if($str == '') return '';
  	$ws = explode(' ',$str);
  	$wlen = count($ws);
  	$spc = $this->split_char;
  	$reStr = '';
  	for($i=0;$i<$wlen;$i++){
  		if($ws[$i]=='') continue;
  		if($i>=$wlen-1) $reStr .= $spc.$ws[$i];
  		else{ $reStr .= $spc.$ws[$i]; }
    }
    return $reStr;
  }
  function par_other($word_array) {
  	$wlen = count($word_array)-1;
  	$rsStr = '';
  	$spc = $this->split_char;
  	for($i=$wlen;$i>=0;$i--) {
  		if(preg_match('/'.$this->cn_sg_num.'/',$word_array[$i])) {
  			$rsStr .= $spc.$word_array[$i];
  			if($i>0 && preg_match('/^'.$this->common_unit.'/',$word_array[$i-1]) ) {
				$rsStr .= $word_array[$i-1]; $i--;
			} else {
  				while($i>0 && preg_match("/".$this->cn_sg_num."/",$word_array[$i-1]) ){ $rsStr .= $word_array[$i-1]; $i--; }
  			}
  			continue;
  		}
  		if(strlen($word_array[$i])==4 && isset($this->two_name_dic[$word_array[$i]])) {
  			$rsStr .= $spc.$word_array[$i];
  			if($i>0&&strlen($word_array[$i-1])==2){
  				$rsStr .= $word_array[$i-1];$i--;
  				if($i>0&&strlen($word_array[$i-1])==2){ $rsStr .= $word_array[$i-1];$i--; }
  			}
  		} else if(strlen($word_array[$i])==2 && isset($this->one_name_dic[$word_array[$i]])) {
  			$rsStr .= $spc.$word_array[$i];
  			if($i>0&&strlen($word_array[$i-1])==2){
  				 if(preg_match("/".$this->especial_char."/",$word_array[$i-1])) continue;
  				 $rsStr .= $word_array[$i-1];$i--;
  				 if($i>0 && strlen($word_array[$i-1])==2 &&
  				  !preg_match("/".$this->especial_char."/",$word_array[$i-1]))
  				 { $rsStr .= $word_array[$i-1];$i--; }
  			}
  		} else {
  			$rsStr .= $spc.$word_array[$i];
  		}
  	}
  	$rsStr = preg_replace("/^".$spc."/","",$rsStr);
  	return $rsStr;
  }
  function split_mm($str,$try_num_name=true,$try_diff=true) {
  	$spc = $this->split_char;
  	$spLen = strlen($str);
  	$rsStr = $okWord = $tmpWord = '';
  	$word_array = array();
  	for($i=($spLen-1);$i>=0;) {
  		if($i<=$this->min_len){
  			if($i==1){
  			  $word_array[] = substr($str,0,2);
  		  } else {
  			   $w = substr($str,0,$this->min_len+1);
  			   if($this->is_word($w)){
  			   	$word_array[] = $w;
  			   }else{
  				   $word_array[] = substr($str,2,2);
  				   $word_array[] = substr($str,0,2);
  			   }
  		  }
  			$i = -1; break;
  		}
  		if($i>=$this->max_len) $max_pos = $this->max_len;
  		else $max_pos = $i;
  		$isMatch = false;
  		for($j=$max_pos;$j>=0;$j=$j-2){
  			 $w = substr($str,$i-$j,$j+1);
  			 if($this->is_word($w)){
  			 	$word_array[] = $w;
  			 	$i = $i-$j-1;
  			 	$isMatch = true;
  			 	break;
  			 }
  		}
  		if(!$isMatch){
  			if($i>1) {
  				$word_array[] = $str[$i-1].$str[$i];
  				$i = $i-2;
  			}
  		}
  	}//End For

  	if($try_num_name) {
		$rsStr = $this->par_other($word_array);
	} else {
  		$wlen = count($word_array)-1;
  		for($i=$wlen;$i>=0;$i--){
  	  	$rsStr .= $spc.$word_array[$i];
  	  }
  	}
  	if($try_diff) $rsStr = $this->test_diff(trim($rsStr));
  	return $rsStr;
  }
  function auto_description($str,$keyword,$strlen) {
  	$this->source_string = $this->revise_string($this->source_string);
  	$spwords = explode(" ",$this->source_string);
  	$keywords = explode(" ",$this->keywords);
  	$regstr = "";
  	foreach($keywords as $k=>$v) {
  		if($v=="") continue;
  		if(ord($v[0])>0x80 && strlen($v)<3) continue;
  		if($regstr=="") $regstr .= "($v)";
  		else $regstr .= "|($v)";
  	}
  }
  function test_diff($str) {
  	$str = preg_replace("/ {1,}/"," ",$str);
  	if($str == ""||$str == " ") return "";
  	$ws = explode(' ',$str);
  	$wlen = count($ws);
  	$spc = $this->split_char;
  	$reStr = "";
  	for($i=0;$i<$wlen;$i++) {
  		if($i>=($wlen-1)) {
  			$reStr .= $spc.$ws[$i];
  		} else {
  			if($ws[$i]==$ws[$i+1]){
  				$reStr .= $spc.$ws[$i].$ws[$i+1];
  				$i++; continue;
  			}
  			if(strlen($ws[$i])==2 && strlen($ws[$i+1])<8 && strlen($ws[$i+1])>2) {
  				$addw = $ws[$i].$ws[$i+1];
  				$t = 6;
  				$testok = false;
  				while($t>=4) {
  				  $w = substr($addw,0,$t);
  				  if($this->is_word($w) && ($this->get_rank($w) > $this->get_rank($ws[$i+1])*2) ) {
  					   $limit_word = substr($ws[$i+1],strlen($ws[$i+1])-$t-2,strlen($ws[$i+1])-strlen($w)+2);
  					   if($limit_word!="") $reStr .= $spc.$w.$spc.$limit_word;
  					   else $reStr .= $spc.$w;
  					   $testok = true;
  					   break;
  				  }
  				  $t = $t-2;
  			  }
  			  if(!$testok) $reStr .= $spc.$ws[$i];
  			  else $i++;
  			} else if(strlen($ws[$i])>2 && strlen($ws[$i])<8 && strlen($ws[$i+1])>2 && strlen($ws[$i+1])<8) {
  				$t21 = substr($ws[$i+1],0,2);
  				$t22 = substr($ws[$i+1],0,4);
  				if($this->is_word($ws[$i].$t21)) {
  					if(strlen($ws[$i])==6||strlen($ws[$i+1])==6){
  						$reStr .= $spc.$ws[$i].$t21.$spc.substr($ws[$i+1],2,strlen($ws[$i+1])-2);
  						$i++;
  					} else {
  						$reStr .= $spc.$ws[$i];
  					}
  				} else if(strlen($ws[$i+1])==6) {
  					if($this->is_word($ws[$i].$t22)) {
  						$reStr .= $spc.$ws[$i].$t22.$spc.$ws[$i+1][4].$ws[$i+1][5];
  						$i++;
  					} else { $reStr .= $spc.$ws[$i]; }
  				} else if(strlen($ws[$i+1])==4) {
  					$addw = $ws[$i].$ws[$i+1];
  					$t = strlen($ws[$i+1])-2;
  					$testok = false;
  					while($t>0) {
  						$w = substr($addw,0,strlen($ws[$i])+$t);
  						if($this->is_word($w) && ($this->get_rank($w) > $this->get_rank($ws[$i+1])*2) ) {
  				       $limit_word = substr($ws[$i+1],$t,strlen($ws[$i+1])-$t);
  					     if($limit_word!="") $reStr .= $spc.$w.$spc.$limit_word;
  					     else $reStr .= $spc.$w;
  					     $testok = true;
  					     break;
  				    }
  				    $t = $t-2;
  					}
  					if(!$testok) $reStr .= $spc.$ws[$i];
  			    else $i++;
  				}else {
  					$reStr .= $spc.$ws[$i];
  				}
  			} else {
  				$reStr .= $spc.$ws[$i];
  			}
  		}
    }//End For
  	return $reStr;
  }
  function is_word($okWord){
  	$slen = strlen($okWord);
  	if($slen > $this->max_len) return false;
  	else return isset($this->rank_dic[$slen][$okWord]);
  }
  function revise_string($str) {
  	$spc = $this->split_char;
    $slen = strlen($str);
    if($slen==0) return '';
    $okstr = '';
    $prechar = 0; // 0-空白 1-英文 2-中文 3-符號
    for($i=0;$i<$slen;$i++){
      if(ord($str[$i]) < 0x81) {
        if(ord($str[$i]) < 33){
          //$str[$i]!="\r"&&$str[$i]!="\n"
          if($prechar!=0) $okstr .= $spc;
          $prechar=0;
          continue;
        } else if(preg_match("/[^0-9a-zA-Z@\.%#:\\/\\&_-]/",$str[$i])) {
          if($prechar==0) {
          	$okstr .= $str[$i]; $prechar=3;
          } else {
          	$okstr .= $spc.$str[$i]; $prechar=3;
          }
        } else {
        	if($prechar==2||$prechar==3) {
        		$okstr .= $spc.$str[$i]; $prechar=1;
        	} else {
        	  if(preg_match("/@#%:/",$str[$i])){ $okstr .= $str[$i]; $prechar=3; }
        	  else { $okstr .= $str[$i]; $prechar=1; }
        	}
        }
      } else{
        if($prechar!=0 && $prechar!=2) $okstr .= $spc;
        if(isset($str[$i+1])){
          $c = $str[$i].$str[$i+1];
          if(preg_match("/".$this->cn_number."/",$c)) {
          	$okstr .= $this->get_alab_num($c); $prechar = 2; $i++; continue;
          }
          $n = hexdec(bin2hex($c));
          if($n>0xA13F && $n < 0xAA40) {
            if($c=="《"){
            	if($prechar!=0) $okstr .= $spc." 《";
            	else $okstr .= " 《";
            	$prechar = 2;
            } else if($c=="》"){
            	$okstr .= "》 ";
            	$prechar = 3;
            } else{
            	if($prechar!=0) $okstr .= $spc.$c;
            	else $okstr .= $c;
            	$prechar = 3;
            }
          } else {
            $okstr .= $c;
            $prechar = 2;
          }
          $i++;
        }
      }//中文字符
    }//結束循環
    return $okstr;
  }
  function find_new_word($str,$maxlen=6) {
    $okstr = "";
    return $str;
  }
  function get_keyword($str,$ilen=-1) {
    if($str=='') return '';
    else $this->split_result($str,true,true);
    $okstr = $this->result_string;
    $ws = explode(' ',$okstr);
    $okstr = $wks = '';
    foreach($ws as $w) {
      $w = trim($w);
      if(strlen($w)<2) continue;
      if(!preg_match("/[^0-9:-]/",$w)) continue;
      if(strlen($w)==2&&ord($w[0])>0x80) continue;
      if(isset($wks[$w])) $wks[$w]++;
      else $wks[$w] = 1;
    }
    if(is_array($wks)) {
      arsort($wks);
      if($ilen==-1) {
		foreach($wks as $w=>$v) {
      		if($this->get_rank($w)>500) $okstr .= $w." ";
        }
      }  else {
        foreach($wks as $w=>$v){
          if((strlen($okstr)+strlen($w)+1)<$ilen) $okstr .= $w." ";
          else break;
        }
      }
    }
    if(CHARSET=='utf-8') $okstr = iconv('gbk','utf-8',$okstr);
    return trim($okstr);
  }
  function get_rank($w){
  	if(isset($this->rank_dic[strlen($w)][$w])) return $this->rank_dic[strlen($w)][$w];
  	else return 0;
  }
  function get_alab_num($fnum){
	  $nums = array("０","１","２","３","４","５","６",
	  "７","８","９","＋","－","％","．",
	  "ａ","ｂ","ｃ","ｄ","ｅ","ｆ","ｇ","ｈ","ｉ","ｊ","ｋ","ｌ","ｍ",
	  "ｎ","ｏ","ｐ","ｑ","ｒ","ｓ ","ｔ","ｕ","ｖ","ｗ","ｘ","ｙ","ｚ",
	  "Ａ","Ｂ","Ｃ","Ｄ","Ｅ","Ｆ","Ｇ","Ｈ","Ｉ","Ｊ","Ｋ","Ｌ","Ｍ",
	  "Ｎ","Ｏ","Ｐ","Ｑ","Ｒ","Ｓ","Ｔ","Ｕ","Ｖ","Ｗ","Ｘ","Ｙ","Ｚ");
	  $fnums = "0123456789+-%.abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $fnum = str_replace($nums,$fnums,$fnum);
	  return $fnum;
  }
}
?>
