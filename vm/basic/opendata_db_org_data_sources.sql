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
-- Table structure for table `org_data_sources`
--

DROP TABLE IF EXISTS `org_data_sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_data_sources` (
  `object_id` varchar(20) NOT NULL,
  `createdAt` varchar(45) DEFAULT NULL,
  `data_country_count` varchar(45) DEFAULT NULL,
  `data_type` varchar(45) DEFAULT NULL,
  `profile_id` varchar(45) DEFAULT NULL,
  `row_type` varchar(45) DEFAULT NULL,
  `updatedAt` varchar(45) DEFAULT NULL,
  `country_id` varchar(20) DEFAULT NULL,
  `data_src_gov_level` varchar(45) DEFAULT NULL,
  `machine_readable` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`object_id`),
  KEY `fk_data_source_coun_info` (`country_id`),
  KEY `fk_data_source_profile_info` (`profile_id`),
  CONSTRAINT `fk_data_source_coun_info` FOREIGN KEY (`country_id`) REFERENCES `country_info` (`country_id`),
  CONSTRAINT `fk_data_source_profile_info` FOREIGN KEY (`profile_id`) REFERENCES `org_profiles` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org_data_sources`
--

LOCK TABLES `org_data_sources` WRITE;
/*!40000 ALTER TABLE `org_data_sources` DISABLE KEYS */;
INSERT INTO `org_data_sources` VALUES ('zxa','2015-09-27T20:57:56.602Z',NULL,'Agriculture','ZPUViPEx49','data_use','2015-09-27T20:57:56.602Z','abc','National','false'),('zxb','2015-09-27T20:57:57.011Z',NULL,'Demographics and social','ZPUViPEx49','data_use','2015-09-27T20:57:57.011Z','abc','National','false'),('zxc','2015-09-27T20:57:57.657Z',NULL,'Government operations','ZPUViPEx49','data_use','2015-09-27T20:57:57.657Z','abc','National','false'),('zxd','2015-08-18T01:55:31.120Z',NULL,'Water','VWMlvcLUA9','data_use','2015-08-18T01:55:31.120Z','abd','Local','false'),('zxf','2015-08-28T07:25:24.522Z',NULL,'Demographics and social','FlMCBAYWAx','data_use','2015-08-28T07:25:24.522Z','abe','National','false'),('zxm','2015-09-27T20:57:57.437Z',NULL,'Geospatial/mapping','ZPUViPEx49','data_use','2015-09-27T20:57:57.437Z','abc','National','false'),('zxn','2015-09-27T20:57:57.225Z',NULL,'Environment','ZPUViPEx49','data_use','2015-09-27T20:57:57.225Z','abc','National','false'),('zxs','2015-08-18T01:55:30.928Z',NULL,'Health/healthcare','VWMlvcLUA9','data_use','2015-08-18T01:55:30.928Z','abd','National','false'),('zxv','2015-09-27T20:57:57.871Z',NULL,'Transportation','ZPUViPEx49','data_use','2015-09-27T20:57:57.871Z','abc','National','false');
/*!40000 ALTER TABLE `org_data_sources` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-28  0:22:43
