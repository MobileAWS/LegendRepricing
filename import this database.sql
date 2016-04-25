-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: spd
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.12.04.1

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `consumer_key` varchar(255) NOT NULL,
  `consumer_secret_key` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `username` varchar(150) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `followers` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  `total_tweets` int(11) NOT NULL,
  `description` text NOT NULL,
  `listed_count` int(11) NOT NULL,
  `profile_image` text NOT NULL,
  `since_id` bigint(20) NOT NULL,
  `create_date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (0,2,3244284348,'3244284348-Oup3dQArty1vJ7YlLPKhhXandXLgJz6FddqiTjZ','IiDB9sXyvvACcJm4iqmUuo6K1LPQTqVjmx5wEQahYQsTb','active','test201517','','','',1,3,0,'',0,'http://abs.twimg.com/sticky/default_profile_images/default_profile_4_normal.png',0,1434272821,1434272821),(0,2,2247509784,'2247509784-vrtXMzfPqIqnRniR8IRW1x3vWZIPjxio1fiKt5pLl','XoxGhCKgQpnZdKYhhslpCjK5luW6dKZRutYyDUW7qFJej','active','jimmycarter256','','','',2,35,19,'',0,'http://abs.twimg.com/sticky/default_profile_images/default_profile_2_normal.png',0,1434273018,1434273018);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deck_user`
--

DROP TABLE IF EXISTS `deck_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deck_user` (
  `deck_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `name` varchar(255) NOT NULL,
  `type` enum('admin','user') NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_image` text NOT NULL,
  `schedule_status` enum('yes','no') NOT NULL DEFAULT 'yes',
  `schedule_time` int(11) NOT NULL DEFAULT '15',
  `create_date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `consumer_key` varchar(1000) NOT NULL,
  `consumer_secret_key` varchar(1000) NOT NULL,
  PRIMARY KEY (`deck_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deck_user`
--

LOCK TABLES `deck_user` WRITE;
/*!40000 ALTER TABLE `deck_user` DISABLE KEYS */;
INSERT INTO `deck_user` VALUES (1,'active','user','user','ee11cbb19052e40b07aac0ca060c23ee','','','yes',15,0,0,'testing','okfine'),(2,'active','admin','admin','21232f297a57a5a743894a0e4a801fc3','','','yes',15,0,0,'VR3TGLufZQhpkXqNqPaObPMTm','30qAzpr1u4Z5f28P7mnLcmyUMnVYXl4Hku86o61RgYgVuN1kJu');
/*!40000 ALTER TABLE `deck_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `error_log`
--

DROP TABLE IF EXISTS `error_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `error_log` (
  `error_id` int(11) NOT NULL AUTO_INCREMENT,
  `deck_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `screen_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tweet_id` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `retweet_id` varchar(255) NOT NULL,
  `favorite_id` varchar(255) NOT NULL,
  `create_date` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `error_code` int(11) DEFAULT NULL,
  `error_message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`error_id`),
  KEY `deck_id` (`deck_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `error_log`
--

LOCK TABLES `error_log` WRITE;
/*!40000 ALTER TABLE `error_log` DISABLE KEYS */;
INSERT INTO `error_log` VALUES (3,2,'2247509784','@jimmycarter256','','RT','rhby','',1434112173,'127.0.0.1',34,'Sorry, that page does not exist'),(4,2,'3244284348','@test201517','','RT','trgtr','',1434272861,'127.0.0.1',34,'Sorry, that page does not exist'),(5,2,'3244284348','@test201517','','RT','wfdrfr','',1434273073,'127.0.0.1',34,'Sorry, that page does not exist'),(6,2,'2247509784','@jimmycarter256','','RT','wfdrfr','',1434273074,'127.0.0.1',34,'Sorry, that page does not exist'),(7,2,'3244284348','@test201517','','RT','rtgtgt','',1434273116,'127.0.0.1',34,'Sorry, that page does not exist'),(8,2,'2247509784','@jimmycarter256','','RT','rtgtgt','',1434273116,'127.0.0.1',34,'Sorry, that page does not exist');
/*!40000 ALTER TABLE `error_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_log`
--

DROP TABLE IF EXISTS `message_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_log` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `deck_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `tweet_id` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `retweet_id` varchar(255) NOT NULL,
  `favorite_id` varchar(255) NOT NULL,
  `create_date` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `deck_id` (`deck_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_log`
--

LOCK TABLES `message_log` WRITE;
/*!40000 ALTER TABLE `message_log` DISABLE KEYS */;
INSERT INTO `message_log` VALUES (1,2,'2247509784','609271486008815616','RT','541259781420617728','',1434096618,'127.0.0.1'),(2,2,'2247509784','609274686719963136','RT','541259781420617728','',1434097380,'127.0.0.1'),(3,2,'2247509784','','unRT','541259781420617728','',1434098836,'127.0.0.1');
/*!40000 ALTER TABLE `message_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `deck_id` int(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `rt_id` bigint(20) NOT NULL,
  `create_time` bigint(20) NOT NULL,
  `delete_time` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (5,2,0,541259781420617728,0,0);
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_message` text NOT NULL,
  `rules` text NOT NULL,
  `favorite` enum('yes','no') NOT NULL DEFAULT 'no',
  `autounret_time` int(11) NOT NULL DEFAULT '1',
  `retweet_limit` int(11) DEFAULT '1',
  `close_deck` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'.','.','yes',10,10,'no');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_accounts`
--

DROP TABLE IF EXISTS `user_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_accounts` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `deck_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `principle_account` varchar(255) NOT NULL,
  `alternative_account` text NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` int(11) NOT NULL,
  PRIMARY KEY (`acc_id`),
  KEY `deck_id` (`deck_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_accounts`
--

LOCK TABLES `user_accounts` WRITE;
/*!40000 ALTER TABLE `user_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_accounts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-14 17:23:59
