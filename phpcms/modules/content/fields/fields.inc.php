<?php
$fields = array('text'=>'單行文本',
				'textarea'=>'多行文本',
				'editor'=>'編輯器',
				'catid'=>'欄目',
				'title'=>'標題',
				'box'=>'選項',
				'games'=>'關聯遊戲',
				'image'=>'圖片',
				'images'=>'多圖片',
				'number'=>'數字',
				'datetime'=>'日期和時間',
				'posid'=>'推薦位',
				'keyword'=>'關鍵詞',
				'author'=>'作者',
				'copyfrom'=>'來源',
				'groupid'=>'會員組',
				'islink'=>'轉向鏈接',
				'template'=>'模板',
				'pages'=>'分頁選擇',
				'typeid'=>'類別',
				'readpoint'=>'積分、點數',
				'linkage'=>'聯動菜單',
				'downfile'=>'鏡像下載',
				'downfiles'=>'多文件上傳',
				'map'=>'地圖字段',
				'omnipotent'=>'萬能字段',
				'video'=>'視頻庫',
				'linktag'=>'添加標簽',
				'package'=>'軟件包上傳',
				'relation'=>'文章關聯',
                'sarcasm' => '吐槽字段',
				'partition'=>'分區關聯',
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
