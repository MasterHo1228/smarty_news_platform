CREATE DATABASE IF NOT EXISTS `mvc_study` CHARACTER SET utf8mb4;
USE `mvc_study`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `author` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ip` varchar(15) NOT NULL
) DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` char(4) NOT NULL
) DEFAULT CHARSET=utf8mb4;

INSERT INTO admin VALUES(NULL ,'admin',MD5('123456msho'),'msho');
INSERT INTO admin VALUES(NULL ,'Demo1',MD5('123456demo'),'demo');
