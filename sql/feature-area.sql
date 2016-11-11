ALTER TABLE `www_product`  ADD `letter` VARCHAR(100) NOT NULL AFTER `title`,  ADD `initial` VARCHAR(20) NOT NULL AFTER `letter`,  ADD INDEX (`letter`), ADD INDEX (`initial`);
CREATE TABLE `www_area` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `productid` int(11) NOT NULL,
    `catid` int(11) NOT NULL,
    `name` varchar(30) NOT NULL,
    `letter` varchar(30) NOT NULL,
    `parentid` int(11) NOT NULL,
    `child` tinyint(4) NOT NULL,
    `title` varchar(300) NOT NULL,
    `items` int(11) NOT NULL,
    `description` varchar(300) NOT NULL,
    `keywords` varchar(300) NOT NULL,
    `template` varchar(50) NOT NULL,
    `setting` mediumtext NOT NULL,
    PRIMARY KEY (`id`),
    KEY `parentid` (`parentid`)
) DEFAULT CHARSET=utf8;
