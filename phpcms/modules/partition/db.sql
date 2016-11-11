INSERT INTO `www_module` VALUES ('partition','专区','partition/',1,'1.0','专区','',0,0,'2013-08-22','2013-08-22');
INSERT INTO `www_menu` VALUES (1719,'partition',0,'partition','partition','init','',17,'1',1,1,1,1,1),(1720,'partition_publish',1719,'partition','partition','init','',0,'1',1,1,1,1,1),(1721,'partition_cat',1720,'partition','partition','init','',0,'1',1,1,1,1,1),(1722,'add_partition',1721,'partition','partition','add','s=0',1,'1',1,1,1,1,1),(1723,'edit_category',1721,'partition','partition','edit','',0,'',1,1,1,1,1);
-- MySQL dump 10.14  Distrib 5.5.31-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: mofang_test
-- ------------------------------------------------------
-- Server version	5.5.31-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `www_partition`
--

DROP TABLE IF EXISTS `www_partition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_partition` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `module` varchar(15) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL,
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `arrchildid` mediumtext NOT NULL,
  `catname` varchar(30) NOT NULL,
  `style` varchar(5) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `parentdir` varchar(100) NOT NULL,
  `catdir` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL,
  `items` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `setting` mediumtext NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `sethtml` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `letter` varchar(30) NOT NULL,
  `usable_type` varchar(255) NOT NULL,
  `is_area_menu` tinyint(1) NOT NULL DEFAULT '0',
  `is_domain` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否启用独立域名',
  `domain_dir` varchar(255) NOT NULL DEFAULT '' COMMENT '域名目录',
  `domain` varchar(255) NOT NULL DEFAULT '' COMMENT '绑定域名',
  PRIMARY KEY (`catid`),
  KEY `module` (`module`,`parentid`,`listorder`,`catid`),
  KEY `siteid` (`siteid`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=329 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `www_partition`
--

LOCK TABLES `www_partition` WRITE;
/*!40000 ALTER TABLE `www_partition` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_partition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `www_partition_games`
--

DROP TABLE IF EXISTS `www_partition_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `www_partition_games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modelid` int(10) unsigned NOT NULL DEFAULT '0',
  `gameid` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=375 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `www_partition_games`
--

LOCK TABLES `www_partition_games` WRITE;
/*!40000 ALTER TABLE `www_partition_games` DISABLE KEYS */;
/*!40000 ALTER TABLE `www_partition_games` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-09-03 17:56:04
