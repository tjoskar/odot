# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.25)
# Database: odot
# Generation Time: 2013-05-22 11:31:53 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `due_date` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;

INSERT INTO `items` (`id`, `list_id`, `title`, `completed`, `order`, `created_at`, `updated_at`, `due_date`)
VALUES
	(1,1,'Äta lunch',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(2,1,'Se på tv',0,1,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(3,1,'Läsa mail',0,2,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(4,1,'Vakna',1,3,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(5,2,'Löneförhandla',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(6,3,'Ta examen',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(7,4,'Run New York marathon',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(8,5,'Plantera om alla träd',1,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(9,6,'Ät godis',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(10,7,'Byt tändstift',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL),
	(11,8,'Gör klart alla labbar',0,0,'2013-05-22 11:31:26','2013-05-22 11:31:26',NULL);

/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lists`;

CREATE TABLE `lists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `lists` WRITE;
/*!40000 ALTER TABLE `lists` DISABLE KEYS */;

INSERT INTO `lists` (`id`, `title`, `order`, `created_at`, `updated_at`)
VALUES
	(1,'Today',0,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(2,'Work',1,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(3,'School',2,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(4,'Bucket List',3,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(5,'Trädgården',4,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(6,'Blandat',5,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(7,'Bilen',6,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(8,'Skolan',7,'2013-05-22 11:31:26','2013-05-22 11:31:26');

/*!40000 ALTER TABLE `lists` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2013_05_20_191149_create_items_table',1),
	('2013_05_20_192124_create_lists_table',1),
	('2013_05_20_192155_create_sub_items_table',1),
	('2013_05_20_192230_create_user_lists_table',1),
	('2013_05_20_192358_create_users_table',1),
	('2013_05_20_193515_rename_complete_to_completed_in_items',1),
	('2013_05_20_193648_add_due_date_items',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sub_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sub_items`;

CREATE TABLE `sub_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` int(11) NOT NULL,
  `order` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `sub_items` WRITE;
/*!40000 ALTER TABLE `sub_items` DISABLE KEYS */;

INSERT INTO `sub_items` (`id`, `list_id`, `item_id`, `title`, `completed`, `order`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'Beställa',1,'0','2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(2,1,1,'Äta',0,'1','2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(3,1,1,'Betala',0,'2','2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(4,1,2,'Family guy',0,'0','2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(5,1,2,'Dexter',1,'1','2013-05-22 11:31:26','2013-05-22 11:31:26');

/*!40000 ALTER TABLE `sub_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_lists`;

CREATE TABLE `user_lists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user_lists` WRITE;
/*!40000 ALTER TABLE `user_lists` DISABLE KEYS */;

INSERT INTO `user_lists` (`id`, `user_id`, `list_id`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(2,1,2,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(3,1,3,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(4,1,4,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(5,2,1,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(6,2,5,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(7,3,1,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(8,3,6,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(9,3,7,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(10,4,1,'2013-05-22 13:31:26','0000-00-00 00:00:00'),
	(11,4,8,'2013-05-22 13:31:26','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `user_lists` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visible_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `visible_name`, `facebook_id`, `created_at`, `updated_at`)
VALUES
	(1,'Oskar','$2y$08$NRN20Ekv8SoZXiFIOkxyTe32BcEQxpbxovs9GnkEV7Is6KxtAPBze','Oskar',NULL,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(2,'Jonas','$2y$08$d0KBIlBWMBJFyN.fyXrpdeV3O6ALRQ6EDkBQpQpZKVyvHCLMa.lf6','Jonas',NULL,'2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(3,'j.bromo',NULL,'Jonas Bromö','100000048721511','2013-05-22 11:31:26','2013-05-22 11:31:26'),
	(4,'JohnDoe','$2y$08$NTrhWf9P2qmKhWW1biId6ufc3BfzHtXDfRrmr/9n/fw8C2ZTkd8L6','John Doe',NULL,'2013-05-22 11:31:26','2013-05-22 11:31:26');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
