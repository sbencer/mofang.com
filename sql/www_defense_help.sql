CREATE TABLE `www_defense_help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gameid` int(10) unsigned DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `content` text,
  `userid` int(11) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `parentid` int(11) DEFAULT 0,
  `reply` int(11) DEFAULT 0,
  `time` int(11) DEFAULT NULL,
  `retime` int(11) DEFAULT NULL,
  `support` int(11) DEFAULT 0,
  `oppose` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `gameid` (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
