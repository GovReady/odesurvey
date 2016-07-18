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
-- Table structure for table `org_profiles`
--

DROP TABLE IF EXISTS `org_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `org_profiles` (
  `object_id` varchar(20) NOT NULL,
  `createdAt` varchar(45) DEFAULT NULL,
  `industry_id` varchar(45) DEFAULT NULL,
  `industry_other` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `no_org_url` varchar(45) DEFAULT NULL,
  `org_additional` varchar(45) DEFAULT NULL,
  `org_description` varchar(200) DEFAULT NULL,
  `org_greatest_impact` varchar(45) DEFAULT NULL,
  `org_greatest_impact_detail` varchar(45) DEFAULT NULL,
  `org_name` varchar(45) DEFAULT NULL,
  `org_open_corporates_id` varchar(45) DEFAULT NULL,
  `org_profile_category` varchar(45) DEFAULT NULL,
  `org_profile_src` varchar(45) DEFAULT NULL,
  `org_profile_status` varchar(45) DEFAULT NULL,
  `org_profile_year` varchar(45) DEFAULT NULL,
  `org_size_id` varchar(45) DEFAULT NULL,
  `org_type` varchar(45) DEFAULT NULL,
  `org_type_other` varchar(45) DEFAULT NULL,
  `org_url` varchar(45) DEFAULT NULL,
  `org_year_founded` varchar(45) DEFAULT NULL,
  `profile_id` varchar(20) DEFAULT NULL,
  `updatedAt` varchar(45) DEFAULT NULL,
  `org_loc_id` varchar(25) DEFAULT NULL,
  `data_use_type` varchar(45) DEFAULT NULL,
  `data_use_type_other` varchar(45) DEFAULT NULL,
  `machine_readable` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`object_id`),
  KEY `fk_org_prof_id_idx` (`profile_id`),
  KEY `fk_org_loc_id_idx` (`org_loc_id`),
  CONSTRAINT `fk_org_loc_new_id` FOREIGN KEY (`org_loc_id`) REFERENCES `org_locations` (`object_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_org_prof_new_id` FOREIGN KEY (`profile_id`) REFERENCES `surveys` (`object_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `org_profiles`
--

LOCK TABLES `org_profiles` WRITE;
/*!40000 ALTER TABLE `org_profiles` DISABLE KEYS */;
INSERT INTO `org_profiles` VALUES ('bcd','2015-09-27T20:57:57.332Z','Governance',NULL,'7.2571325','5.2057909','false',NULL,'The Nigeria Open Data Access (NODA) provides a portal that provides its users with full access and rights to open data.','Governance',NULL,'Nigeria Open Data Access','null','research','AODC Participant List','publish','2015','null','Developer group','null','http://opendata.com.ng/','0','ZPUViPEx49','2015-09-27T20:57:57.332Z','pqr','null',NULL,'false'),('bcf','2015-08-18T01:55:30.743Z','Energy',NULL,'-31.9535959','115.8570118','false',NULL,'Gas Generators Australia is Australia’s fastest growing Gas Generation company offering the world’s leading Nitrogen, Oxygen and Hydrogen generation solutions.','Environmental',NULL,'Gas Generators Australia','null','research','OD500AU','publish','2015','11-50','For-profit','null','http://www.gasgen.com.au','2008','VWMlvcLUA9','2015-08-18T01:55:30.743Z','pqs','null',NULL,'false'),('bcg','2015-08-28T07:25:24.641Z','Consumer services',NULL,'-41.2864603','174.776236','false',NULL,'Retail New Zealand assists its members by providing retail advice, member benefit savings, industry information and education,, and are the main retail industry lobby group to government.','Economic',NULL,'NZ Retailers Association','null','research','CODE Research','publish','2015','11-50','other','Association','http://www.retail.org.nz','0','FlMCBAYWAx','2015-08-28T07:25:24.641Z','pqt','null',NULL,'false');
/*!40000 ALTER TABLE `org_profiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-28  0:22:41
