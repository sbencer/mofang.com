<?php
defined('IN_ADMIN') or exit('No permission resources.');

$field_type				= 'varchar'; //字段數據庫類型	
$field_basic_table		= 1; //是否允許作為主表字段
$field_allow_index		= 0; //是否允許建立索引
$field_minlength		= 1; //字符長度默認最小值
$field_maxlength		= 80; //字符長度默認最大值
$field_allow_search		= 1; //作為搜索條件
$field_allow_fulltext	= 1; //作為全站搜索信息
$field_allow_isunique	= 0; //是否允許值唯一
?>