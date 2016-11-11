<?php
$fields = array('text'=>'單行文本',
				'textarea'=>'多行文本',
				'editor'=>'編輯器',
				'box'=>'選項',
				'image'=>'圖片',
				'images'=>'多圖片',
				'number'=>'數字',
				'datetime'=>'日期和時間',
				'linkage'=>'聯動菜單',
				);
//不允許刪除的字段，這些字段講不會在字段添加處顯示
$not_allow_fields = array('catid','typeid','title','keyword','posid','template','username');
//允許添加但必須唯一的字段
$unique_fields = array('pages','readpoint','author','copyfrom','islink');
//禁止被禁用的字段列表
$forbid_fields = array('catid','title','updatetime','inputtime','url','listorder','status','template','username');
//禁止被刪除的字段列表
$forbid_delete = array('catid','typeid','title','thumb','keywords','updatetime','inputtime','posids','url','listorder','status','template','username');
//可以追加 JS和CSS 的字段
$att_css_js = array('text','textarea','box','number','keyword','typeid');
?>