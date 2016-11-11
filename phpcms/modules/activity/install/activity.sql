-- 专区表
DROP TABLE IF EXISTS `phpcms_activity`;
CREATE TABLE IF NOT EXISTS `phpcms_activity` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `activity_name` varchar(30) NOT NULL COMMENT '活动名称',
  `domain_dir` varchar(255) NOT NULL DEFAULT '' COMMENT '英文标识唯一',
  `page_name` varchar(30) NOT NULL DEFAULT 'index' COMMENT '活动单页名称，默认index',
  `is_use_ad` int(10) unsigned NOT NULL default '1' COMMENT '启用加加广告，默认启用',
  `is_use_footer` int(10) unsigned NOT NULL default '1' COMMENT '是否使用通底，默认使用',
  `bg_pic` text COMMENT '背景图',
  `render_pics` mediumtext NOT NULL COMMENT '背景裁切后数组',
  `map_setting` mediumtext NOT NULL COMMENT '热区配置',
  `qr_code` text COMMENT '二维码',
  `setting` mediumtext NOT NULL COMMENT 'SEO配置',
  `float_win` mediumtext NOT NULL COMMENT '浮窗配置',
  `weixin` mediumtext NOT NULL COMMENT '微信分享',
  `staticstics_code` mediumtext NOT NULL COMMENT '统计代码',
  `roulette` mediumtext NOT NULL COMMENT '轮盘配置',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM ;
