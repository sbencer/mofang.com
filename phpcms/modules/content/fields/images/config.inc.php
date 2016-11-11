<?php
defined('IN_ADMIN') or exit('No permission resources.');

$field_type				= 'mediumtext'; //字段數據庫類型	
$field_basic_table		= 0; //是否允許作為主表字段
$field_allow_index		= 0; //是否允許建立索引
$field_minlength		= 0; //字符長度默認最小值
$field_maxlength		= ''; //字符長度默認最大值
$field_allow_search		= 0; //作為搜索條件
$field_allow_fulltext	= 0; //作為全站搜索信息
$field_allow_isunique	= 0; //是否允許值唯一
?>