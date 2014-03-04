# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 192.168.3.10 (MySQL 5.1.73)
# Database: command_api_dev
# Generation Time: 2014-03-03 12:14:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `salt` varchar(40) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;

INSERT INTO `account` (`id`, `username`, `password`, `salt`, `created_at`, `updated_at`)
VALUES
	(1,'admin','588cd204f63a0720e3f56c09654b024aaf8abfd0','23ced00ff02dc3505ac65a3f90ed8b41fc336efc','2014-01-16 12:31:49','2014-01-16 12:33:31');

/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table administrator
# ------------------------------------------------------------

DROP TABLE IF EXISTS `administrator`;

CREATE TABLE `administrator` (
  `id` mediumint(8) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_administrator_id` FOREIGN KEY (`id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;

INSERT INTO `administrator` (`id`, `created_at`, `updated_at`)
VALUES
	(1,'2014-01-16 12:34:58','2014-01-16 12:34:58');

/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `title`, `created_at`, `updated_at`)
VALUES
	(1,'Consectetur Mattis','2014-01-12 09:36:00','2014-01-12 09:36:00'),
	(2,'Aenean Adipiscing Ultricies','2014-01-12 09:36:08','2014-01-12 09:36:08'),
	(3,'Cursus Lorem Vulputate','2014-01-12 09:36:17','2014-01-12 09:36:17');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table client
# ------------------------------------------------------------

DROP TABLE IF EXISTS `client`;

CREATE TABLE `client` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `identifier` varchar(50) NOT NULL DEFAULT '',
  `key` varchar(40) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `un_client_identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;

INSERT INTO `client` (`id`, `name`, `identifier`, `key`, `created_at`, `updated_at`)
VALUES
	(1,'Gijs Nieuwenhuis','gnoesiboe','6fad6c91124a1afe7dd9bb08ce4014b4bc99e04c','2014-01-16 12:29:12','2014-01-16 12:29:12');

/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table client_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `client_permission`;

CREATE TABLE `client_permission` (
  `client_id` tinyint(3) unsigned NOT NULL,
  `permission_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`client_id`,`permission_id`),
  KEY `fk_client_permission_permission_id` (`permission_id`),
  CONSTRAINT `fk_client_permission_client_id` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_client_permission_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `client_permission` WRITE;
/*!40000 ALTER TABLE `client_permission` DISABLE KEYS */;

INSERT INTO `client_permission` (`client_id`, `permission_id`)
VALUES
	(1,1),
	(1,2),
	(1,3);

/*!40000 ALTER TABLE `client_permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table newsitem
# ------------------------------------------------------------

DROP TABLE IF EXISTS `newsitem`;

CREATE TABLE `newsitem` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` mediumint(8) unsigned NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_new_category_id` (`category_id`),
  CONSTRAINT `fk_new_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `newsitem` WRITE;
/*!40000 ALTER TABLE `newsitem` DISABLE KEYS */;

INSERT INTO `newsitem` (`id`, `category_id`, `title`, `description`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,1,'Ullamcorper Etiam Sit','Sed posuere consectetur est at lobortis. Nullam quis risus eget urna mollis ornare vel eu leo. Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Donec ullamcorper nulla non metus auctor fringilla.\r\rAenean lacinia bibendum nulla sed consectetur. Sed posuere consectetur est at lobortis. Nullam quis risus eget urna mollis ornare vel eu leo. Nullam quis risus eget urna mollis ornare vel eu leo.\r\rNulla vitae elit libero, a pharetra augue. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur blandit tempus porttitor. Nullam quis risus eget urna mollis ornare vel eu leo. Curabitur blandit tempus porttitor. Sed posuere consectetur est at lobortis. Curabitur blandit tempus porttitor.','2014-01-10 07:08:59','2014-01-10 07:08:59',NULL),
	(2,2,'Euismod Pharetra Ligula Venenatis','Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.\r\rDonec ullamcorper nulla non metus auctor fringilla. Curabitur blandit tempus porttitor. Nullam id dolor id nibh ultricies vehicula ut id elit. Nullam id dolor id nibh ultricies vehicula ut id elit. Aenean lacinia bibendum nulla sed consectetur. Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla.','2014-01-10 07:09:26','2014-01-10 07:09:26',NULL),
	(3,3,'Vehicula Ullamcorper','Cras justo odio, dapibus ac facilisis in, egestas eget quam. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Donec ullamcorper nulla non metus auctor fringilla. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Donec ullamcorper nulla non metus auctor fringilla. Nullam id dolor id nibh ultricies vehicula ut id elit.\r\rMaecenas faucibus mollis interdum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed posuere consectetur est at lobortis. Aenean lacinia bibendum nulla sed consectetur. Nullam id dolor id nibh ultricies vehicula ut id elit.','2013-12-04 10:00:04','2013-12-04 10:00:04',NULL),
	(4,1,'Cras Aenean Fusce','Quam Egestas Bibendum Magna','2014-01-10 22:06:36','2014-01-10 22:06:36',NULL);

/*!40000 ALTER TABLE `newsitem` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(50) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;

INSERT INTO `permission` (`id`, `identifier`, `created_at`, `updated_at`)
VALUES
	(1,'newsitem_get','2014-01-16 12:29:52','2014-01-16 12:29:52'),
	(2,'newsitem_create-newsitem_post','2014-02-14 07:47:29','2014-02-14 07:47:29'),
	(3,'category_get','2014-03-03 04:13:15','2014-03-03 04:13:15');

/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
