<?php
/**
* 通用的樹型類，可以生成任何樹型結構
*/
class tree {
	/**
	* 生成樹型結構所需要的2維數組
	* @var array
	*/
	public $arr = array();

	/**
	* 生成樹型結構所需修飾符號，可以換成圖片
	* @var array
	*/
	public $icon = array('│','├','└');

	/**
	* @access private
	*/
	public $ret = '';

	/**
	* 構造函數，初始化類
	* @param array 2維數組，例如：
	* array(
	*      1 => array('id'=>'1','parentid'=>0,'name'=>'一級欄目一'),
	*      2 => array('id'=>'2','parentid'=>0,'name'=>'一級欄目二'),
	*      3 => array('id'=>'3','parentid'=>1,'name'=>'二級欄目一'),
	*      4 => array('id'=>'4','parentid'=>1,'name'=>'二級欄目二'),
	*      5 => array('id'=>'5','parentid'=>2,'name'=>'二級欄目三'),
	*      6 => array('id'=>'6','parentid'=>3,'name'=>'三級欄目一'),
	*      7 => array('id'=>'7','parentid'=>3,'name'=>'三級欄目二')
	*      )
	*/
	public function init($arr=array()){
       $this->arr = $arr;
	   $this->ret = '';
	   return is_array($arr);
	}

    /**
	* 得到父級數組
	* @param int
	* @return array
	*/
	public function get_parent($myid){
		$newarr = array();
		if(!isset($this->arr[$myid])) return false;
		$pid = $this->arr[$myid]['parentid'];
		$pid = $this->arr[$pid]['parentid'];
		if(is_array($this->arr)){
			foreach($this->arr as $id => $a){
				if($a['parentid'] == $pid) $newarr[$id] = $a;
			}
		}
		return $newarr;
	}

    /**
	* 得到子級數組
	* @param int
	* @return array
	*/
	public function get_child($myid){
		$a = $newarr = array();
		if(is_array($this->arr)){
			foreach($this->arr as $id => $a){
				if($a['parentid'] == $myid) $newarr[$id] = $a;
			}
		}
		return $newarr ? $newarr : false;
	}

    /**
	* 得到當前位置數組
	* @param int
	* @return array
	*/
	public function get_pos($myid,&$newarr){
		$a = array();
		if(!isset($this->arr[$myid])) return false;
        $newarr[] = $this->arr[$myid];
		$pid = $this->arr[$myid]['parentid'];
		if(isset($this->arr[$pid])){
		    $this->get_pos($pid,$newarr);
		}
		if(is_array($newarr)){
			krsort($newarr);
			foreach($newarr as $v){
				$a[$v['id']] = $v;
			}
		}
		return $a;
	}

    /**
	* 得到樹型結構
	* @param int ID，表示獲得這個ID下的所有子級
	* @param string 生成樹型結構的基本代碼，例如："<option value=\$id \$selected>\$spacer\$name</option>"
	* @param int 被選中的ID，比如在做樹型下拉框的時候需要用到
	* @return string
	*/
	public function get_tree($myid, $str, $sid = 0, $adds = '', $str_group = ''){
		$number=1;
		$child = $this->get_child($myid);
		if(is_array($child)){
		    $total = count($child);
			foreach($child as $id=>$a){
				$j=$k='';
				if($number==$total){
					$j .= $this->icon[2];
				}else{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';
				$selected = $id==$sid ? 'selected' : '';
				@extract($a);
				$parentid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree($id, $str, $sid, $adds.$k.'&nbsp;',$str_group);
				$number++;
			}
		}
		return $this->ret;
	}
    /**
	* 同上一方法類似,但允許多選
	*/
	public function get_tree_multi($myid, $str, $sid = 0, $adds = ''){
		$number=1;
		$child = $this->get_child($myid);
		if(is_array($child)){
		    $total = count($child);
			foreach($child as $id=>$a){
				$j=$k='';
				if($number==$total){
					$j .= $this->icon[2];
				}else{
					$j .= $this->icon[1];
					$k = $adds ? $this->icon[0] : '';
				}
				$spacer = $adds ? $adds.$j : '';
				
				$selected = $this->have($sid,$id) ? 'selected' : '';
				@extract($a);
				eval("\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree_multi($id, $str, $sid, $adds.$k.'&nbsp;');
				$number++;
			}
		}
		return $this->ret;
	}
	
	private function have($list,$item){
		return(strpos(',,'.$list.',',','.$item.','));
	}
}
?>