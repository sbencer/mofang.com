-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2013 年 04 月 28 日 06:17
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `tphpcms`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `v9_linktag`
-- 

CREATE TABLE `v9_linktag` (
  `sort` mediumint(9) NOT NULL,
  `tag_id` int(11) NOT NULL auto_increment,
  `tag_name` char(12) NOT NULL,
  `count` tinyint(4) NOT NULL default '0',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) default NULL,
  `delete_flag` tinyint(4) NOT NULL default '0' COMMENT '0默认显示1删除标志',
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY  (`tag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;



-- 
-- 表的结构 `v9_linktag_to_content`
-- 

CREATE TABLE `v9_linktag_to_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `linktag_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;



