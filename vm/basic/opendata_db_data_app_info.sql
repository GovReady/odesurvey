-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: opendata_db
-- ------------------------------------------------------
-- Server version	5.7.12-log

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
-- Table structure for table `data_app_info`
--

DROP TABLE IF EXISTS `data_app_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_app_info` (
  `object_id` varchar(45) NOT NULL,
  `advocacy` varchar(45) DEFAULT NULL,
  `advocacy_desc` varchar(45) DEFAULT NULL,
  `org_opt` varchar(45) DEFAULT NULL,
  `org_opt_desc` varchar(45) DEFAULT NULL,
  `other` varchar(45) DEFAULT NULL,
  `other_desc` varchar(45) DEFAULT NULL,
  `prod_srvc` varchar(45) DEFAULT NULL,
  `prod_srvc_desc` varchar(45) DEFAULT NULL,
  `research` varchar(45) DEFAULT NULL,
  `research_desc` varchar(45) DEFAULT NULL,
  `profile_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`object_id`),
  KEY `fk_data_use_idx` (`profile_id`),
  CONSTRAINT `fk_data_app_new` FOREIGN KEY (`profile_id`) REFERENCES `org_profiles` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_app_info`
--

LOCK TABLES `data_app_info` WRITE;
/*!40000 ALTER TABLE `data_app_info` DISABLE KEYS */;
INSERT INTO `data_app_info` VALUES ('qac','false',NULL,'true',NULL,'false',NULL,'false',NULL,'false',NULL,'FlMCBAYWAx'),('qax','false',NULL,'false',NULL,'false',NULL,'false',NULL,'true',NULL,'VWMlvcLUA9'),('qaz','true',NULL,'false',NULL,'false',NULL,'false',NULL,'false',NULL,'ZPUViPEx49');
/*!40000 ALTER TABLE `data_app_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-28  0:22:42
