-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 05 月 10 日 19:02
-- 服务器版本: 5.5.31-0ubuntu0.13.04.1
-- PHP 版本: 5.4.9-4ubuntu2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `phpcms`
--

-- --------------------------------------------------------

--
-- 表的结构 `v9_app_package`
--

CREATE TABLE IF NOT EXISTS `v9_app_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '包ID',
  `pid` int(10) unsigned NOT NULL COMMENT '产品ID',
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `filename` varchar(200) NOT NULL COMMENT '产品名',
  `size` varchar(100) NOT NULL COMMENT '包大小',
  `filepath` varchar(200) NOT NULL COMMENT '存放地址',
  `userid` int(11) NOT NULL COMMENT '上传者',
  `uploadtime` int(11) NOT NULL COMMENT '上传时间',
  `uploadip` varchar(15) NOT NULL COMMENT '上传者IP',
  `infos` text NOT NULL COMMENT '其他信息',
  `xml` text NOT NULL COMMENT 'XML信息',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
