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
-- Table structure for table `org_contacts`
--

DROP TABLE IF EXISTS `org_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_contacts` (
  `object_id` varchar(20) NOT NULL,
  `createdAt` varchar(45) DEFAULT NULL,
  `profile_id` varchar(45) DEFAULT NULL,
  `survey_contact_email` varchar(45) DEFAULT NULL,
  `survey_contact_first` varchar(45) DEFAULT NULL,
  `survey_contact_last` varchar(45) DEFAULT NULL,
  `survey_contact_phone` varchar(45) DEFAULT NULL,
  `survey_contact_title` varchar(45) DEFAULT NULL,
  `updatedAt` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`object_id`),
  KEY `fk_org_contact_idx` (`profile_id`),
  CONSTRAINT `fk_org_contact_new` FOREIGN KEY (`profile_id`) REFERENCES `org_profiles` (`profile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org_contacts`
--

LOCK TABLES `org_contacts` WRITE;
/*!40000 ALTER TABLE `org_contacts` DISABLE KEYS */;
INSERT INTO `org_contacts` VALUES ('qwe','2015-09-27T20:57:56.510Z','ZPUViPEx49',NULL,NULL,NULL,NULL,NULL,'2015-09-27T20:57:56.510Z'),('qwr','2015-08-18T01:55:30.835Z','VWMlvcLUA9',NULL,NULL,NULL,NULL,NULL,'2015-08-18T01:55:30.835Z'),('qwt','2015-08-28T07:25:24.419Z','FlMCBAYWAx',NULL,NULL,NULL,NULL,NULL,'2015-08-28T07:25:24.419Z');
/*!40000 ALTER TABLE `org_contacts` ENABLE KEYS */;
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
