-- MariaDB dump 10.19  Distrib 10.5.23-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: osidemo-server.mysql.database.azure.com    Database: simoninvdemo-database
-- ------------------------------------------------------
-- Server version	8.0.39-azure

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `company_details`
--

DROP TABLE IF EXISTS `company_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handleBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `outstanding` decimal(10,2) NOT NULL DEFAULT '0.00',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_details_address_unique` (`address`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_details`
--

LOCK TABLES `company_details` WRITE;
/*!40000 ALTER TABLE `company_details` DISABLE KEYS */;
INSERT INTO `company_details` VALUES (1,'The Director,','kumar@krishmaniam.com','Krish Maniam Holding (Pvt) Ltd','40, Galle Face Court 2, Colombo 03.','1',1791654.94,1,'2024-07-31 08:51:42','2024-10-24 08:56:08'),(2,'The Director,','kumar@krishmaniam.com,','Parapet (Private) Limited','No 40, Galle Face Court 2,\r\nColombo 03..','1',328094.00,1,'2024-07-31 08:53:15','2024-10-09 09:18:48'),(4,'The Director,','kumar@krishmaniam .com\'','Krish Maniam Investments (Private) Limited.','40, Galle Face Court 2, Colombo 03.,','1',0.00,1,'2024-07-31 09:00:08','2024-07-31 09:00:08'),(5,'The Accountant,','das@slaasmb.gov.lk anushamohotti@slaasmb.gov.lk','SLAASMB','No 293, Galle Road, Colombo 03.','2',-43109.00,1,'2024-07-31 09:03:07','2024-10-23 11:47:10'),(6,'The Accountant,','ravindu.tharaka@aipl.lk','AJRJ Holdings (Pvt) Ltd.','No 100 , Elvitigala Mawatha, Colombo 08.','1',0.00,1,'2024-08-06 11:40:10','2024-08-06 11:40:10'),(7,'The Accountant,','ravindu.tharaka@aipl.lk,','AJRJ Leisure (Pvt) Ltd,','No 137, Mahena Road, Siyambalape.','1',0.00,1,'2024-08-06 11:42:42','2024-08-06 11:42:42'),(8,'The Accountant,','ravindu.tharaka@aipl.lk, nalaka@aipl.lk','Analytical Properties (Pvt) Ltd.','No 100, 4th Floor, Elvitigala Mawatha, Colombo 08.','1',0.00,1,'2024-08-06 11:45:31','2024-08-06 11:45:31'),(9,'The Accountant,','ravindu.tharaka@aipl.lk, nalaka@aipl.lk,','Biomedical Technical Services Services (Pvt) Ltd.','No 100 , 4th Floor, Elvitigala Mawatha, Colombo 08.,','1',0.00,1,'2024-08-06 11:48:31','2024-08-06 11:48:31'),(12,'The Accountant,','Ravindu.tharaka@aipl.lk.','CT NORA (Pvt) Ltd.','137, Mahena Road, Siyambalape.','1',0.00,1,'2024-08-06 11:56:24','2024-08-06 11:56:24'),(13,'The Accountant,','Ravindu.tharaka@aipl.lk. Nalaka@aipl.lk,','E Health Care Solutions (Pvt) Ltd.','no 137, \r\nMahena Road,\r\nSiyambalape','1',0.00,1,'2024-08-09 05:14:15','2024-08-09 05:14:15'),(14,'The Accountant,','Ravindu.Tharaka@aipl.lk. nalaka@aipl.lk,','Health Innovation (Pvt) Ltd.','No 85/35, \r\nPolhengoda Lane,\r\nColombo 05.','1',0.00,1,'2024-08-09 05:17:05','2024-08-09 05:17:05'),(15,'The Accountant,','ravindu.tharaka@aipl.lk. Nalaka@aipl.lk,','H 2 O Life Tech (Pvt) Ltd.','No 100, \r\nElvitigala Mawatha, \r\nColombo 08.','1',0.00,1,'2024-08-09 05:20:33','2024-08-09 05:20:33'),(16,'The Accountant,','Ravindu tharaka@aipl.lk. nalaka @aipl.lk,','Charter House International (Pvt) Ltd.','No 161, Nawala Road,\r\nNarahenpita,\r\nColombo 05.','1',0.00,1,'2024-08-09 05:24:11','2024-08-09 05:24:11'),(17,'The Accountant,','ravindu tharaka@aipl.lk. nalaka @aipl.lk,','Point of Care Testing (Pvt) Ltd.','No 100/1, \r\nElvitigala Mawatha,\r\nColombo 08.','1',0.00,1,'2024-08-09 05:26:43','2024-08-09 05:26:43'),(18,'The Accountant,','Ravindu .tharaka@aipl.lk. Nalaka@aipl.lk,','Smart Lanka Diagnostics (Pvt) Ltd.','No 37/3, Bullers Lane,\r\nColombo 07.','1',0.00,1,'2024-08-09 05:30:28','2024-08-09 05:30:28'),(20,'The Accountant,','ravindu .tharaka@aipl.lk.,','Target Laboratory (Pvt) Ltd.','No 85/35.,\r\nPolhengoda Lane.,\r\nColombo 05.','1',0.00,1,'2024-08-09 05:42:23','2024-08-09 05:42:23'),(21,'The Accountant,','ravindu .tharaka@aipl.lk., nalaka@aipl.lk','Analytical Technologies (Pvt) Ltd.','No 137, \r\nMahena Road.,\r\nSiyambalape.','1',0.00,1,'2024-08-09 07:34:14','2024-08-09 07:34:14'),(22,'The Accountant,','suranga@etsteas.co.uk niluza badurdeen@etsteas.co.uk','Amazon Teas (Pvt) Ltd.','No 72/6, \r\nKohilawatha Road.\r\nKudabuthgamuwa,\r\nAngoda.','2',-24500.00,1,'2024-08-22 04:35:28','2024-10-18 04:57:26'),(23,'The Accountant,','Suranga@etsteas.co.uk, niluza badurdeen@etsteas.co.uk','Eden Grove Ceylon Tea Estates (Pvt) Ltd.','72/06, \r\nKohilawatha Road.\r\nKudabuthgamuwa,\r\nAngoda.','2',-24500.00,1,'2024-08-22 04:40:59','2024-10-18 04:57:43'),(24,'The Director.','ajjantha@gmail.com, flying possum@bigpond.com.','Flying Possum (Private) Limited.','No 40,\r\nGalle Face Court 02, \r\nColombo. 03','1',0.00,1,'2024-08-22 04:56:59','2024-08-22 04:56:59'),(25,'The Accountant,','accounts@nce.lk','National Institute of Exports,','131/6,\r\nElvitigala Mawatha,\r\nColombo 08.','1',0.00,1,'2024-08-22 05:05:57','2024-08-22 05:05:57'),(26,'The Accountant,','accounts@nce.lk,','The National Chamber of Exporters of Sri Lanka','No 131/6, \r\nElvitigala Mawatha,\r\nColombo 8.','1',0.00,1,'2024-08-22 05:10:17','2024-08-22 05:10:17'),(27,'The Accountant,','pamela.oleary@tcd.ie','Cashell Green (Pvt) Ltd.','No 40. Galle Face Court 02, Colombo 03.','2',0.00,1,'2024-08-26 06:03:53','2024-08-26 06:03:53'),(28,'The Director,','apollochansri@gmail.com','Weligam Bay Hotels (Pvt) Ltd,','No 40, Galle Face Court 02, Colombo 03,.','3',0.00,1,'2024-08-26 06:09:34','2024-08-26 06:09:34'),(29,'The Director,','lahirudilshandesilva@gmail.com','The Frangipani Estates (Private) Limited,','No 39, \r\nPedlar Street, \r\nFort, \r\nGalle.','1',0.00,1,'2024-08-26 06:16:21','2024-08-26 06:16:21'),(30,'The Director,','lahirudilshandesilva@gmail.com, theprintersvilla@gmail.com','Printers Villa (Private) Limited.','No 39, \r\nPedlar Street., \r\nFort, \r\nGalle.,','1',0.00,1,'2024-08-26 06:19:38','2024-08-26 06:19:38'),(31,'The Accountant,','nimali.ncpc@gmail.com','National Cleaner Production Centre,','No 65/1,  \r\nDevala Road,\r\nNugegoda.','2',0.00,1,'2024-08-26 07:39:19','2024-10-28 09:25:56'),(32,'The Accountant,','rajeevnicholas@yahoo.co.uk','Ibbagamuwa Hall,','No 789/S, \r\nBaduwatta,\r\nIpalawa,\r\nGokarella.','1',0.00,1,'2024-08-26 07:48:04','2024-08-26 07:48:04'),(33,'The Accountant,','indrika@multiformchemicals.com','Multiform Chemicals (Pvt) Ltd.','No 659, \r\nAlwitigala Mawatha,\r\nColombo 05.','3',0.00,1,'2024-08-26 07:53:17','2024-08-26 07:53:17'),(34,'The Director,','koji.itakura@gmail.com','Muhudu Palati Villas (Private) Limited.','40. \r\nGalle Face Court 02,  \r\nColombo 03.','1',0.00,1,'2024-08-26 07:57:52','2024-08-26 07:57:52'),(35,'The Director,','kanchana@zpmc.lk','Z P M C Lanka Company (Private) Limited.','No 278,\r\nUnion Place,\r\nColombo 02.','3',0.00,1,'2024-08-26 08:09:13','2024-08-26 08:09:13'),(36,'The Accountant,','sameera@waltersbay.lk','Walters Bay Teas (Pvt) Ltd.','356/2, \r\nKohalawatta Road,\r\nKuda Buthgamuwa.','3',0.00,1,'2024-08-26 08:57:42','2024-08-26 08:57:42'),(37,'The Director,','mohan.Jakshapathi@gardiner-group.com wasana.Alles@gallefacegroup.com','Unionco (Private) Limited.','No 327, \r\nUnion Place,\r\nColombo 02.','2',0.00,1,'2024-08-26 10:13:46','2024-08-26 10:13:46'),(38,'The Director,','vbeekjan@gmail.com','Seagull Trades (Private) Limited.','Mahagodawatta, Ibbawela, Weligama','1',0.00,1,'2024-08-28 05:35:45','2024-08-28 05:35:45'),(39,'The Director,','sahan2sag@gmail.com, anuruddhasanka@gmail.com','N S I Retreat (Private) Limited','352/2, Biyagama Road,\r\nMabima,\r\nHeiyanthuduwa','1',0.00,1,'2024-09-05 05:03:33','2024-09-05 05:03:33'),(40,'The Director,','sahan2sag@gmail.com, anuruddhasanka@gmail.com','N S I Investment (Private) Limited','352/2,\r\nMabima\r\nHeiyanthuduwa','1',0.00,1,'2024-09-05 05:21:11','2024-09-05 05:21:11'),(41,'The Director,','cantablife@gmail.com','Island Processes (Pvt) Ltd','No 40, Galle Face Court 2,\r\nColombo 03','3',0.00,1,'2024-09-09 06:46:20','2024-09-09 06:46:20'),(42,'The Director,','hurbeng@nadathur.com','Roehampton (Private) Limited','# 40, GALLE FACE Court 2','4',0.00,1,'2024-09-25 07:09:11','2024-09-25 07:09:11'),(43,'The Director,','tdingler@gmail.com','Trinavest (Private) Limited','No 40 Galle Face Court 2 Colombo 3','4',447.00,1,'2024-10-01 06:39:31','2024-10-01 06:39:31'),(44,'The Director,','giles@ulpotha.com','Aloka Lanka (Private) Limited,','# 36, Galle Face Court 02,\r\nColombo 03.','1',33000.00,1,'2024-10-03 04:35:45','2024-11-04 05:24:17'),(45,'The Director,','giles@ulpotha.com','Isthmus Garden (Pvt) Ltd','Galle Face Court 2,','1',0.00,1,'2024-10-03 04:57:40','2024-10-03 04:57:40'),(46,'The Director,','shantanu@expolanka.com aruni.john@gmail.com','Ama Dablam Associates (Private) Limited','25 Galle Face Court 2.','1',0.00,1,'2024-10-03 05:12:52','2024-10-03 05:12:52'),(47,'The Director,','mwsaunders@gmail.com','Ambawatta (Private) Limited','25,Colombo 03','1',0.00,1,'2024-10-03 05:45:10','2024-10-03 05:45:10'),(48,'The Director,','mwsaunders@gmail.com','Red Oil (Private) Limited','25 Colombo 3','1',0.00,1,'2024-10-03 06:01:04','2024-10-03 06:01:04'),(49,'The Director,','simonanthea@gmail.com','Anter Teas (Private) Limited.','No. 40, \r\nGalle Face Court 02, \r\nColombo 03.,','1',0.00,1,'2024-10-04 05:16:24','2024-10-04 05:16:24'),(50,'The Director,','MarkGriffiths@peacockestates.com','Muhudu Sihinaya (Private) Limited','40..Galle Face Court 2','3',0.00,1,'2024-10-09 04:30:07','2024-10-09 04:30:07'),(51,'The Director,','MarkGriffiths@peacockestates.com','Southern Reef (Private) Limited','No,40, Galle Face Court 2 Colombo 3','3',0.00,1,'2024-10-09 05:49:54','2024-10-09 05:49:54'),(52,'The Director,','mwsaunders@gmail.com','Red Tropic (Private) Limited','# 40, Galle Face Court 2 Colombo 3','1',0.00,1,'2024-10-15 05:41:51','2024-10-15 05:41:51'),(53,'The Director,','garywatmore@gmail.com','Aspen Tree Lanka (Private) Limited','* 40 \r\nGALLE FACE COURT 2 COLOMBO 3','1',0.00,1,'2024-10-15 06:41:40','2024-10-15 06:41:40'),(54,'The Director,','Anura Rambukwella <anurak@thefinance.lk','Telford Educational Services (Private) Limited,','# 55, R.A.DE.MEL Mawatha,Colombo 04.','1',99260.94,1,'2024-10-15 08:22:25','2024-11-04 07:33:05'),(55,'The Director,','nimali.ncpc@gmail.com','National Cleaner Production Centre','# 66/1, Devala Road,\r\nNugegoda','2',0.00,0,'2024-10-24 05:07:19','2024-10-28 09:24:48'),(56,'The Director,','patriciap@anthoneysfeeds.com','New Anthoney’s Feeds Ltd','#205, Vystwyke Road \r\nColombo 15.','1',0.00,1,'2024-10-28 06:27:54','2024-10-28 06:27:54'),(57,'The Director,','mahinda@malwatte.lk','Malwatte Valley Plantations PLC','No 280, Dam Street\r\nColombo 12.','4',0.00,1,'2024-10-30 06:51:05','2024-10-30 06:51:05'),(58,'The Director,','mwsaunders@gmail.com','Pride Mountain Holdings (Private) Limited','# Galle Face Court 2Colombo 003','1',0.00,1,'2024-11-01 06:56:12','2024-11-01 06:56:46'),(59,'The Director,','antonynbrown@yahoo.com','Forty -Five Pedlar Street (Private) Limited','40 Galle Face Court Colombo 3','1',0.00,1,'2024-11-04 10:30:27','2024-11-04 10:30:27');
/*!40000 ALTER TABLE `company_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `handlers`
--

DROP TABLE IF EXISTS `handlers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `handlers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `handlers`
--

LOCK TABLES `handlers` WRITE;
/*!40000 ALTER TABLE `handlers` DISABLE KEYS */;
INSERT INTO `handlers` VALUES (1,'Mr. Kosala','2024-07-31 08:49:38','2024-07-31 08:49:38'),(2,'Mrs. Dilrukshi','2024-07-31 08:49:55','2024-07-31 08:49:55'),(3,'Mrs. Dineli','2024-07-31 08:50:14','2024-07-31 08:50:14'),(4,'Mrs. Christeen','2024-07-31 08:50:33','2024-07-31 08:50:33');
/*!40000 ALTER TABLE `handlers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(3,1) NOT NULL DEFAULT '0.0',
  `Reimbursables` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `currancy` int NOT NULL DEFAULT '0',
  `dollerRate` decimal(6,3) NOT NULL DEFAULT '1.000',
  `invoiceNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` int DEFAULT NULL,
  `pom` decimal(10,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `invoiceID` int DEFAULT NULL,
  `mark_status` int NOT NULL DEFAULT '0',
  `convertToD` int NOT NULL DEFAULT '0',
  `isReceipt` int NOT NULL DEFAULT '0',
  `secAddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_details`
--

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
INSERT INTO `invoice_details` VALUES (1,'Secretarial fees from 1st October 2023 to 31st March 2024 at the rate of Rs.8300.00 per month.',49800.00,0.0,'0',1,0,1.000,'Sec/24/K/8950',6,8300.00,NULL,'2023-10-01',NULL,1,1,0,NULL,'2024-07-31 09:05:26','2024-09-25 05:02:39'),(2,'Secretarial fees from 1st October 2023 to 31st March 2024 at the rate of Rs.8300.00 per month.',49800.00,0.0,'0',1,0,1.000,'Sec/24/P/8951',6,8300.00,NULL,'2023-10-01',NULL,1,1,0,NULL,'2024-07-31 09:06:50','2024-09-25 05:42:26'),(3,'Secretarial fees from 1st October 2023 to 31st March 2024 at the rate of Rs.8300.00 per month.',49800.00,0.0,'0',1,0,1.000,'Sec/24/K/8952',6,8300.00,NULL,'2023-10-01',NULL,1,1,0,NULL,'2024-07-31 09:07:44','2024-10-15 11:07:42'),(4,'Secretarial fees from 12th June 2024 to 31st July 2024 at the rate of Rs.10000.00 per month.',16000.00,0.0,'0',1,0,1.000,'Sec/24/S/8953',1,10000.00,'','2024-06-12',NULL,1,1,0,NULL,'2024-07-31 09:10:54','2024-08-13 10:45:17'),(5,'26/06/2024- Board Meeting - 4.30 pm - 7.10 pm',11500.00,0.0,'1',1,0,1.000,'Sec/24/S/8953',NULL,NULL,NULL,'2024-06-30',NULL,1,1,0,NULL,'2024-07-31 09:18:29','2024-08-13 10:45:17'),(6,'29/07/2024 - Board Meeting -4.20 pm -6.30 pm',8000.00,0.0,'1',1,0,1.000,'Sec/24/S/8953',NULL,NULL,NULL,'2024-07-31',NULL,1,1,0,NULL,'2024-07-31 09:22:10','2024-08-13 10:45:17'),(7,'26/06/2024-Travelling for Board Meeting',1460.00,0.0,'1',1,0,1.000,'Sec/24/S/8953',NULL,NULL,NULL,'2024-07-31',NULL,1,1,0,NULL,'2024-07-31 09:24:46','2024-08-13 10:45:17'),(8,'29/07/2024 - Travelling for Board Meeting',665.00,0.0,'1',1,0,1.000,'Sec/24/S/8953',NULL,NULL,NULL,'2024-07-31',NULL,1,1,0,NULL,'2024-07-31 09:25:59','2024-08-13 10:45:17'),(10,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/A/8954',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 06:07:57','2024-09-05 08:57:48'),(11,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/A/8955',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 06:13:07','2024-09-05 09:06:31'),(12,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/A/8956',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 07:21:26','2024-09-06 07:34:22'),(13,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/A/8957',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:01:48','2024-09-06 07:41:13'),(14,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/B/8958',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:06:03','2024-09-06 07:47:14'),(15,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/C/8959',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:07:25','2024-09-06 07:52:40'),(16,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/E/8960',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:09:05','2024-09-06 08:44:43'),(17,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/H/8961',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:10:45','2024-09-06 08:59:18'),(18,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/H/8962',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:12:16','2024-09-06 09:15:02'),(19,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/C/8963',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:13:59','2024-09-06 09:39:07'),(20,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/P/8964',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:15:55','2024-09-06 09:45:32'),(21,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/S/8965',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:17:45','2024-09-06 09:54:43'),(22,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.2500.00 per month.',15000.00,0.0,'0',1,0,1.000,'Sec/24/T/8966',6,2500.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-08-09 08:19:06','2024-09-06 10:01:28'),(23,'Secretarial fees from 1st July 2024 to 30th September 2024 at the rate of Rs.4000.00 per month.',12000.00,0.0,'0',0,0,1.000,'Sec/24/A/8967',3,4000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:13:51','2024-08-22 09:50:13'),(24,'Annual Return Fee for -2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/A/8967',1,8500.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:16:12','2024-08-22 09:50:14'),(25,'Printing and Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/A/8967',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:17:28','2024-08-22 09:50:14'),(26,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/A/8967',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:18:22','2024-08-22 09:50:14'),(27,'Secretarial fees from 1st July 2024 to 30th September 2024 at the rate of Rs.4000.00 per month.',12000.00,0.0,'0',0,0,1.000,'Sec/24/E/8968',3,4000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:30:31','2024-08-22 09:57:16'),(28,'Annual Return Fee for -2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/E/8968',1,8500.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:31:38','2024-08-22 09:57:16'),(29,'Printing and Stationery',2000.00,0.0,'0',0,0,1.000,'Sec/24/E/8968',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:32:48','2024-08-22 09:57:16'),(30,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/E/8968',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:33:32','2024-08-22 09:57:16'),(31,'Secretarial fees from 1st July 2024 to 30th September 2024 at the rate of USS 38.00 per month. (1USD = Rs 305.00 )',34770.00,0.0,'0',1,0,1.000,'Sec/24/F/8969',3,11590.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:38:07','2024-08-30 04:36:55'),(32,'Annual Return Fee for- 2024',8500.00,0.0,'1',1,0,1.000,'Sec/24/F/8969',1,8500.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:39:16','2024-08-30 04:36:55'),(33,'Printing and Stationery',2000.00,0.0,'1',1,0,1.000,'Sec/24/F/8969',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:40:45','2024-08-30 04:36:55'),(34,'Travelling',2000.00,0.0,'1',1,0,1.000,'Sec/24/F/8969',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:42:00','2024-08-30 04:36:55'),(35,'Secretarial fees from 1st July 2024 to 30th September 2024 at the rate of Rs.4000.00 per month.',12000.00,0.0,'0',0,0,1.000,'Sec/24/N/8970',3,4000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:44:28','2024-08-22 10:03:00'),(36,'Annual Return Fee for - 2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/N/8970',1,8500.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:45:11','2024-08-22 10:03:00'),(37,'Printing and Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/N/8970',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:46:22','2024-08-22 10:03:00'),(38,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/N/8970',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:47:01','2024-08-22 10:03:00'),(39,'Secretarial fees from 1st July 2024 to 30th September 2024 at the rate of Rs.5500.00 per month.',16500.00,0.0,'0',0,0,1.000,'Sec/24/T/8971',3,5500.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:48:29','2024-08-22 10:03:39'),(40,'Annual Return Fee for - 2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/T/8971',1,8500.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:49:18','2024-08-22 10:03:39'),(41,'Printing and Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/T/8971',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:50:12','2024-08-22 10:03:39'),(42,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/T/8971',1,2000.00,NULL,'2024-07-01',NULL,1,1,0,NULL,'2024-08-22 05:51:20','2024-08-22 10:03:39'),(43,'PROFESSIONAL FEES FOR STRIKE OFF PROCEDURE',60000.00,0.0,'0',1,0,1.000,'Sec/24/S/8972',NULL,NULL,NULL,'2024-08-28',NULL,1,1,0,NULL,'2024-08-28 05:39:07','2024-10-10 04:43:34'),(49,'Secretarial fees from 1st August 2024 to 31st August 2024',10000.00,0.0,'0',0,0,1.000,'Sec/24/S/8973',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-09-05 04:21:24','2024-09-06 04:26:27'),(50,'26/08/2024-Board Meeting - 4.30pm- 7.00pm',11500.00,0.0,'1',0,0,1.000,'Sec/24/S/8973',NULL,NULL,NULL,'2024-08-01',NULL,1,1,0,NULL,'2024-09-05 04:25:44','2024-09-06 04:26:27'),(51,'26/08/2024-Travelling for Board Meeting',1609.00,0.0,'1',0,0,1.000,'Sec/24/S/8973',NULL,NULL,NULL,'2024-09-05',NULL,1,1,0,NULL,'2024-09-05 04:26:30','2024-09-06 04:26:27'),(52,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.5,000.00 per month.',30000.00,0.0,'0',0,0,1.000,'Sec/24/N/8974',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-09-05 05:08:14','2024-09-06 04:30:29'),(54,'Secretarial fees from 1st January 2024 to 30th June 2024 at the rate of Rs.5,000.00 per month.',30000.00,0.0,'0',0,0,1.000,'Sec/24/N/8975',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-09-05 05:22:22','2024-09-06 04:34:09'),(55,'Secretarial fees from 1st January 2024 to 31st December 2024 at the rate of USD 44.00 per month.',528.00,0.0,'0',0,1,1.000,'Sec/24/I/8976',12,44.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-09-09 07:09:17','2024-09-27 10:14:00'),(56,'Annual Return fees-2024',40.00,0.0,'1',0,1,1.000,'Sec/24/I/8976',NULL,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-09-09 07:10:56','2024-09-27 10:14:00'),(57,'Printing and Stationery',8.00,0.0,'1',0,1,1.000,'Sec/24/I/8976',NULL,NULL,NULL,'2024-09-09',NULL,1,1,0,NULL,'2024-09-09 07:13:08','2024-09-27 10:14:00'),(58,'Traveling',8.00,0.0,'1',0,1,1.000,'Sec/24/I/8976',NULL,NULL,NULL,'2024-09-09',NULL,1,1,0,NULL,'2024-09-09 07:13:51','2024-09-27 10:14:00'),(59,'Secretarial fees from 1st January 2023 to 31st December 2023 at the rate of USD 41.00 per month.',492.00,0.0,'0',0,1,1.000,'Sec/23/I/8977',12,41.00,NULL,'2023-01-01',NULL,1,1,0,NULL,'2024-09-09 07:52:07','2024-09-27 06:36:00'),(60,'Annual Return fees-2023',40.00,0.0,'1',0,1,1.000,'Sec/23/I/8977',NULL,NULL,NULL,'2024-09-09',NULL,1,1,0,NULL,'2024-09-09 07:52:53','2024-09-27 06:36:00'),(61,'Printing and Stationery',6.00,0.0,'1',0,1,1.000,'Sec/23/I/8977',NULL,NULL,NULL,'2024-09-09',NULL,1,1,0,NULL,'2024-09-09 07:53:34','2024-09-27 06:36:00'),(63,'Traveling',6.00,0.0,'1',0,1,1.000,'Sec/23/I/8977',NULL,NULL,NULL,'2024-09-09',NULL,1,1,0,NULL,'2024-09-09 07:56:02','2024-09-27 06:36:00'),(64,'Secretarial fees from 1st September 2024 to 30th September 2024 at the rate of Rs.10000.00 per month.',10000.00,0.0,'0',0,0,1.000,'Sec/24/S/8978',1,10000.00,NULL,'2024-09-01',NULL,1,1,0,NULL,'2024-09-25 06:15:21','2024-10-01 08:40:25'),(65,'Secretarial fees from 1st April 2024 to 30th September 2024',323.00,0.0,'0',0,1,1.000,'Sec/24/R/8979',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-09-25 07:12:26','2024-09-27 06:32:14'),(66,'01/04/2024-ROC Charges Form 18 & 20',18.00,0.0,'1',0,1,1.000,'Sec/24/R/8979',NULL,NULL,NULL,'2024-04-01',NULL,1,1,0,NULL,'2024-09-25 07:14:47','2024-09-27 06:32:14'),(68,'04/04/2024-ROC charges- Certified Copy',5.00,0.0,'1',0,1,1.000,'Sec/24/R/8979',NULL,NULL,NULL,'2024-09-25',NULL,1,1,0,NULL,'2024-09-25 07:25:08','2024-09-27 06:32:14'),(71,'Annual Return Fee for 2024',40.00,0.0,'1',0,1,1.000,'Sec/24/R/8979',NULL,NULL,NULL,'2024-09-25',NULL,1,1,0,NULL,'2024-09-25 08:45:55','2024-09-27 06:32:14'),(72,'Printing and Stationery',8.00,0.0,'1',0,1,1.000,'Sec/24/R/8979',NULL,NULL,NULL,'2024-09-25',NULL,1,1,0,NULL,'2024-09-25 08:49:22','2024-09-27 06:32:14'),(73,'Travelling',8.00,0.0,'1',0,1,1.000,'Sec/24/R/8979',NULL,NULL,NULL,'2024-09-25',NULL,1,1,0,NULL,'2024-09-25 08:50:43','2024-09-27 06:32:14'),(75,'Secretarial fees from 1st April 2024 to 31st December 2024 at the rate of Rs.44.00 per month.',396.00,0.0,'0',1,1,1.000,'Sec/24/T/8980',9,44.00,NULL,'2024-04-01',NULL,1,1,0,NULL,'2024-10-01 06:42:40','2024-10-24 08:51:08'),(76,'Annual Return Fee for -2024',40.00,0.0,'1',1,1,1.000,'Sec/24/T/8980',NULL,NULL,NULL,'2024-10-01',NULL,1,1,0,NULL,'2024-10-01 06:43:39','2024-10-24 08:56:08'),(77,'Printing and Stationery',8.00,0.0,'1',1,1,1.000,'Sec/24/T/8980',NULL,NULL,NULL,'2024-10-01',NULL,1,1,0,NULL,'2024-10-01 06:44:36','2024-10-24 08:56:08'),(78,'Travelling',8.00,0.0,'1',1,1,1.000,'Sec/24/T/8980',NULL,NULL,NULL,'2024-10-01',NULL,1,1,0,NULL,'2024-10-01 06:45:16','2024-10-24 08:56:08'),(79,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of Rs.5500.00 per month.',33000.00,0.0,'0',0,0,1.000,'Sec/24/A/8981',6,5500.00,NULL,'2024-10-01',NULL,1,1,0,NULL,'2024-10-03 04:41:19','2024-10-15 09:11:15'),(80,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of Rs.5500.00 per month.',33000.00,0.0,'0',0,0,1.000,'Sec/24/I/8982',6,5500.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-10-03 04:59:10','2024-10-03 04:59:10'),(81,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of USD 33 per month. (01USD = Rs.300)',59400.00,0.0,'0',0,0,1.000,'Sec/24/A/8983',NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,'2024-10-03 05:22:47','2024-11-04 06:55:59'),(82,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of US$53.00 per month.',318.00,0.0,'0',0,0,1.000,'Sec/24/A/8984',6,53.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-10-03 05:47:10','2024-10-15 05:50:16'),(83,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of US$.53.00 per month.',318.00,0.0,'0',0,0,1.000,'Sec/24/R/8985',6,53.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-10-03 06:02:47','2024-10-15 05:53:25'),(84,'Our professional fees relative to receiving your instructions to incorporate the captioned company, applying to the Registrar of Companies (ROC) for the approval of the company name, drafting the Articles of Association of the said Company; preparing and filing the documents for incorporation and receiving the Certificate of Incorporation and for general legal advice.',75000.00,0.0,'0',1,0,1.000,'SEC/24/A/8986',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-04 05:30:36','2024-10-11 09:04:47'),(85,'Name Approval',2750.00,0.0,'1',1,0,1.000,'SEC/24/A/8986',1,2750.00,NULL,'2024-10-04',NULL,1,1,0,NULL,'2024-10-04 05:32:26','2024-10-11 09:04:48'),(86,'•	Expenses incurred at the Registrar of Companies',19500.00,0.0,'1',1,0,1.000,'SEC/24/A/8986',1,19500.00,NULL,'2024-10-04',NULL,1,1,0,NULL,'2024-10-04 05:33:46','2024-10-11 09:04:48'),(87,'•	Polymer seal, embossed seal and Share Certificate book',11000.00,0.0,'1',1,0,1.000,'SEC/24/A/8986',1,11000.00,NULL,'2024-10-04',NULL,1,1,0,NULL,'2024-10-04 05:34:39','2024-10-11 09:04:48'),(88,'Secretarial fees from 1st January 2021 to 31st December 2021 at the rate of USD 30.00 per month. (01 USD = Rs.300.00)',108000.00,0.0,'0',0,0,1.000,'Sec/21/M/8987',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 04:44:43','2024-10-09 09:16:10'),(89,'Printing & Stationery',600.00,0.0,'1',0,0,1.000,'Sec/21/M/8987',NULL,600.00,NULL,'2021-01-01',NULL,1,1,0,NULL,'2024-10-09 04:47:19','2024-10-09 09:16:10'),(90,'Secretarial fees from 1st January 2022 to 31st December 2022 at the rate of USD 30.00 per month. (01 USD = Rs.300.00)',108000.00,0.0,'0',0,0,1.000,'Sec/22/M/8988',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 04:55:24','2024-10-09 09:19:02'),(91,'Printing & Stationery',600.00,0.0,'1',0,0,1.000,'Sec/22/M/8988',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 04:58:03','2024-10-09 09:19:02'),(92,'Secretarial fees from 1st January 2023 to 31st December 2023 at the rate of USD 35.00 per month. (01 USD = Rs.300)',126000.00,0.0,'0',0,0,1.000,'Sec/23/M/8989',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 05:18:21','2024-10-09 09:21:32'),(93,'Printing & Stationery',600.00,0.0,'1',0,0,1.000,'Sec/23/M/8989',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 05:19:49','2024-10-09 09:21:32'),(94,'Secretarial fees from 1st January 2024 to 30th September 2024 at the rate of USD 40.00 per month. (01USD =Rs.300)',108000.00,0.0,'0',0,0,1.000,'Sec/24/M/8990',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 05:28:33','2024-10-09 09:24:34'),(95,'Printing & Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/M/8990',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-09 05:29:44','2024-10-09 09:24:34'),(96,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/M/8990',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-09 05:44:54','2024-10-09 09:24:34'),(97,'Secretarial fees from 1st January 2021 to 31st December 2021 at the rate of USD 30.00 per month. (01 USD = Rs.300.00)',108000.00,0.0,'0',0,0,1.000,'Sec/21/S/8991',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 05:52:19','2024-10-09 09:32:04'),(98,'Printing & Stationery',600.00,0.0,'1',0,0,1.000,'Sec/21/S/8991',12,NULL,NULL,'2021-01-01',NULL,1,1,0,NULL,'2024-10-09 05:53:28','2024-10-09 09:32:04'),(99,'Secretarial fees from 1st January 2022 to 31st December 2022 at the rate of USD 30.00 per month. (01 USD = Rs.300)',108000.00,0.0,'0',0,0,1.000,'Sec/22/S/8992',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 05:58:11','2024-10-09 09:33:58'),(100,'Printing & Stationery',600.00,0.0,'1',0,0,1.000,'Sec/22/S/8992',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 05:59:35','2024-10-09 09:33:58'),(101,'Secretarial fees from 1st January 2023 to 31st December 2023 at the rate of USD 35.00 per month. (01 USD = Rs.300.00)',126000.00,0.0,'0',0,0,1.000,'SEc/23/S/8993',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 06:09:36','2024-10-09 09:35:16'),(102,'Printing & Stationery',600.00,0.0,'1',0,0,1.000,'SEc/23/S/8993',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 06:10:56','2024-10-09 09:35:16'),(103,'Secretarial fees from 1st January 2024 to 30th September 2024 at the rate of USD 40.00 per month. (01USD=Rs.300)',108000.00,0.0,'0',0,0,1.000,'Sec/24/S/8994',NULL,NULL,NULL,NULL,NULL,1,1,0,NULL,'2024-10-09 06:15:55','2024-10-09 09:36:41'),(104,'Printing & Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/S/8994',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-09 06:17:12','2024-10-09 09:36:41'),(105,'Traveling',2000.00,0.0,'1',0,0,1.000,'Sec/24/S/8994',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-09 06:18:10','2024-10-09 09:36:41'),(106,'Secretarial fees from 1st October 2023 to 31st March 2024 at the rate of US$.53.00 per month.',318.00,0.0,'0',0,0,1.000,'SEC/24/R/8995',6,53.00,NULL,'2023-10-01',NULL,0,0,0,NULL,'2024-10-15 05:44:47','2024-10-15 05:55:40'),(107,'Secretarial fees from 1st January 2024 to 31st December 2024 at the rate of Rs.7000.00 per month.',84000.00,0.0,'0',1,0,1.000,'Sec/24/T/8997',12,7000.00,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-15 08:32:16','2024-10-18 07:14:02'),(108,'26/01/2024-ROC Charges-Form 20',2760.94,0.0,'1',1,0,1.000,'Sec/24/T/8997',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-15 08:34:46','2024-10-18 07:14:03'),(109,'Annual Return Fee for -2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/T/8997',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-15 08:38:36','2024-10-15 09:49:47'),(110,'Printing & Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/T/8997',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-15 08:40:00','2024-10-15 09:49:47'),(111,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/T/8997',12,NULL,NULL,'2024-01-01',NULL,1,1,0,NULL,'2024-10-15 08:40:55','2024-10-15 09:49:47'),(140,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of Rs.4000.00 per month.',24000.00,0.0,'0',0,0,1.000,'Sec/24/N/8998',6,4000.00,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-28 04:40:26','2024-11-04 06:01:59'),(141,'26/04/2024- Board Meeting -from 9.30am to 11.40am',8000.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 04:41:40','2024-10-28 04:41:40'),(142,'18/07/2024-Board Meeting -from 3.00pm to 4.30pm',8000.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 04:51:38','2024-10-28 04:51:38'),(143,'20/08/2024-Board Meeting -from 2.00pm to 4.00pm',8000.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 04:52:35','2024-10-28 04:52:35'),(144,'30/09/2024-Annual General Meeting- From 9.00am to 9.15am',4500.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 04:55:17','2024-10-28 04:55:17'),(145,'30/09/2024- Board meeting -From 9.15am to 10.30am',8000.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 04:56:33','2024-10-28 04:56:33'),(146,'26/04/2024-Travelling for Board Meeting',1999.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-25',NULL,0,0,0,NULL,'2024-10-28 04:59:23','2024-10-28 04:59:23'),(147,'18/07/2024-Travelling for Board Meeting',1957.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-25',NULL,0,0,0,NULL,'2024-10-28 05:00:30','2024-10-28 05:00:30'),(149,'20/08/2024-Travelling for board Meeting',2442.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:02:18','2024-10-28 05:02:18'),(150,'30/09/2024-Travelling for Board Meeting',2174.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:03:44','2024-10-28 05:03:44'),(151,'22/06/2024-ROC Charges-Form 13',2760.94,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:04:52','2024-10-28 05:04:52'),(152,'26/06/2024-ROC Charges-Certified Copy Form 13',1380.47,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:06:54','2024-10-28 05:06:54'),(153,'Annual Return Fee for -2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:13:38','2024-10-28 05:13:38'),(154,'Printing and Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:15:40','2024-10-28 05:15:40'),(155,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/N/8998',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 05:18:04','2024-10-28 05:18:04'),(156,'Secretarial fees from 1st April 2024 to 30th September 2024 at the rate of Rs.5000.00 per month.',30000.00,0.0,'0',0,0,1.000,'Sec/24/N/8999',6,5000.00,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-28 06:58:34','2024-11-04 05:43:09'),(157,'07/06/2024-Board Meeting-From 2.00pm to 3.45pm',8000.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:01:27','2024-11-04 05:43:09'),(158,'31/08/2024- Board Meeting - From 3.00pm to 5.05pm',8000.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:03:47','2024-11-04 05:43:09'),(159,'07/06/2024-Travelling for Board Meeting',2076.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:13:35','2024-11-04 05:43:09'),(161,'31/08/2024-Travelling for Board Meeting',2005.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:26:40','2024-11-04 05:43:09'),(162,'Annual Return Fee for -2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:27:41','2024-11-04 05:43:09'),(163,'Printing and Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:28:18','2024-11-04 05:43:09'),(164,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/N/8999',NULL,NULL,NULL,'2024-10-28',NULL,0,0,0,NULL,'2024-10-28 07:29:04','2024-11-04 05:43:09'),(165,'Secretarial fees from 1st April 2024 to 30th September 2024 at the rate of Rs.11500.00 per month.',69000.00,0.0,'0',0,0,1.000,'Sec/24/M/9000',6,11500.00,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 06:53:04','2024-10-30 06:53:04'),(166,'19/01/2024- Board Meeting - 11.00am-1.15pm',6000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-30',NULL,0,0,0,NULL,'2024-10-30 06:56:15','2024-10-30 06:56:15'),(168,'19/02/2024- Audit Committee Meeting, \r\n                        Related Party-RPTR           , Board Meeting -12.15pm-3.30pm',6000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',6,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 07:04:08','2024-10-30 07:55:52'),(169,'03/05/2024-Audit Committee Meeting, Related Party-RPTR ,Board Meeting-9.30am-1.45pm',6000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 07:55:02','2024-10-30 07:55:02'),(170,'17/05/2024- Audit Committee Meeting-12.00noon-1.30pm',6000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 07:57:21','2024-10-30 07:57:21'),(172,'25/05/2024-Annual General Meeting- 10.30am-12.00noon',7500.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 08:03:27','2024-10-30 08:03:27'),(173,'30/07/2024- Audit Committee Meeting, Related Party-RPTR , Board Meeting -10.30am - 2.30pm',6000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 08:17:31','2024-10-30 08:17:31'),(174,'30/08/2024- Audit Committee Meeting-11.30am - 2.00pm',5000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 08:20:31','2024-10-30 08:20:31'),(175,'19/01/2024-Travelling for Board Meeting-',1723.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 08:31:27','2024-10-30 08:31:27'),(176,'19/02/2024-Travelling for Board Meeting',1823.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 08:32:30','2024-10-30 08:32:30'),(177,'03/05/2024-Travelling for Board Meeting',1980.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 08:42:04','2024-10-30 08:42:04'),(178,'17/05/2024-Travelling for Audit Committee Meeting',870.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 08:56:21','2024-10-30 08:56:21'),(179,'25/05/2024--Travelling for Annual General Meeting',3560.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 08:57:02','2024-10-30 08:57:02'),(180,'30/07/2024-Travelling for Audit Committee Meeting',1583.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 08:58:39','2024-10-30 08:58:39'),(181,'30/08/2024-Travelling for Audit Committee Meeting',702.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 08:59:38','2024-10-30 08:59:38'),(182,'Annual Return Fee for -2024',8500.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 09:04:03','2024-10-30 09:04:03'),(183,'Printing and Stationery',2000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 09:05:49','2024-10-30 09:05:49'),(184,'Travelling',2000.00,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 09:07:54','2024-10-30 09:07:54'),(186,'06/02/2024-ROC Charges- Form 14',2760.94,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-10-30',NULL,0,0,0,NULL,'2024-10-30 09:11:53','2024-10-30 09:11:53'),(187,'11/07/2024- ROC Charges-Form 39',2760.94,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 09:13:18','2024-10-30 09:34:31'),(188,'11/07/2024-ROC Charges-PCA 03 Certificate',2400.81,0.0,'1',0,0,1.000,'Sec/24/M/9000',NULL,NULL,NULL,'2024-04-01',NULL,0,0,0,NULL,'2024-10-30 09:31:00','2024-10-30 09:31:00'),(189,'Secretarial fees from 1st October 2024 to 31st October 2024 at the rate of Rs.10,000.00 per month.',10000.00,0.0,'0',0,0,1.000,'Sec/24/S/9001',1,10000.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-10-31 08:36:16','2024-11-04 05:15:50'),(190,'28/10/2024-Board Meeting - From 4.30pm to 8.20pm',15000.00,0.0,'1',0,0,1.000,'Sec/24/S/9001',NULL,NULL,NULL,'2024-10-31',NULL,0,0,0,NULL,'2024-10-31 08:39:05','2024-10-31 08:39:05'),(191,'28/10/2024-Travelling for Board Meeting',1614.00,0.0,'1',0,0,1.000,'Sec/24/S/9001',NULL,NULL,NULL,'2024-10-31',NULL,0,0,0,NULL,'2024-10-31 08:40:48','2024-10-31 08:40:48'),(192,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of USD 53.00 per month.',318.00,0.0,'0',0,0,1.000,'Sec/24/P/9002',6,53.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-11-01 06:59:03','2024-11-01 06:59:03'),(194,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of USD 46.00 per month.',276.00,0.0,'0',0,0,1.000,'Sec/24/A/8996',6,46.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-11-04 09:16:06','2024-11-04 09:16:06'),(195,'Secretarial fees from 1st October 2024 to 31st March 2025 at the rate of USD38.00 per month (1USD=Rs 298.00)',67944.00,0.0,'0',0,0,1.000,'Sec/24/F/9003',6,38.00,NULL,'2024-10-01',NULL,0,0,0,NULL,'2024-11-04 10:34:15','2024-11-04 10:34:15');
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoiceNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'LKR',
  `dollerRate` decimal(10,2) NOT NULL DEFAULT '1.00',
  `date` date NOT NULL DEFAULT '2024-07-31',
  `sendDate` date NOT NULL DEFAULT '2024-07-31',
  `handleBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resend` int NOT NULL DEFAULT '0',
  `refID` int NOT NULL,
  `customerRefId` int NOT NULL,
  `bankId` int DEFAULT NULL,
  `debtor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9006 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (8949,'8','The Accountant','Test@gmail.com','Test Company','Test,Address','Sec/24/O/8949','LKR',1.00,'2024-07-30','2024-07-30','',0,0,0,NULL,NULL,'2024-07-29 21:43:53',NULL),(8950,'8','The Director,','kumar@krishmaniam.com','Krish Maniam Holding (Pvt) Ltd','40, Galle Face Court 2, Colombo 03.','Sec/24/K/8950','LKR',1.00,'2024-08-09','2024-08-09','1',1,1,1,1,NULL,'2024-07-31 09:04:08','2024-10-30 07:43:30'),(8951,'8','The Director,','kumar@krishmaniam.com,','Parapet (Private) Limited','No 40, Galle Face Court 2,\r\nColombo 03..','Sec/24/P/8951','LKR',1.00,'2024-08-12','2024-08-12','1',0,1,2,1,NULL,'2024-07-31 09:06:15','2024-10-30 07:43:30'),(8952,'8','The Director,','kumar@krishmaniam .com\'','Krish Maniam Investments (Private) Limited.','40, Galle Face Court 2, Colombo 03.,','Sec/24/K/8952','LKR',1.00,'2024-08-12','2024-08-12','1',0,1,4,1,NULL,'2024-07-31 09:07:17','2024-10-30 07:43:30'),(8953,'8','The Accountant,','das@slaasmb.gov.lk anushamohotti@slaasmb.gov.lk','SLAASMB','No 293, Galle Road, Colombo 03.','Sec/24/S/8953','LKR',1.00,'2024-08-12','2024-08-12','2',0,1,5,1,NULL,'2024-07-31 09:08:48','2024-10-30 07:43:30'),(8954,'8','The Accountant,','ravindu.tharaka@aipl.lk','AJRJ Holdings (Pvt) Ltd.','No 100 , Elvitigala Mawatha, Colombo 08.','Sec/24/A/8954','LKR',1.00,'2024-08-12','2024-08-12','1',0,1,6,1,NULL,'2024-08-09 06:05:24','2024-10-30 07:43:30'),(8955,'8','The Accountant,','ravindu.tharaka@aipl.lk,','AJRJ Leisure (Pvt) Ltd,','No 137, Mahena Road, Siyambalape.','Sec/24/A/8955','LKR',1.00,'2024-08-14','2024-08-14','1',1,1,7,1,NULL,'2024-08-09 06:12:30','2024-10-30 07:43:30'),(8956,'8','The Accountant,','ravindu.tharaka@aipl.lk, nalaka@aipl.lk','Analytical Properties (Pvt) Ltd.','No 100, 4th Floor, Elvitigala Mawatha, Colombo 08.','Sec/24/A/8956','LKR',1.00,'2024-08-14','2024-08-14','1',1,1,8,1,NULL,'2024-08-09 07:20:52','2024-10-30 07:43:30'),(8957,'8','The Accountant,','ravindu .tharaka@aipl.lk., nalaka@aipl.lk','Analytical Technologies (Pvt) Ltd.','No 137, \r\nMahena Road.,\r\nSiyambalape.','Sec/24/A/8957','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,21,1,NULL,'2024-08-09 07:59:09','2024-10-30 07:43:30'),(8958,'8','The Accountant,','ravindu.tharaka@aipl.lk, nalaka@aipl.lk,','Biomedical Technical Services Services (Pvt) Ltd.','No 100 , 4th Floor, Elvitigala Mawatha, Colombo 08.,','Sec/24/B/8958','LKR',1.00,'2024-08-12','2024-08-12','1',0,1,9,1,NULL,'2024-08-09 08:04:40','2024-10-30 07:43:30'),(8959,'8','The Accountant,','Ravindu.tharaka@aipl.lk.','CT NORA (Pvt) Ltd.','137, Mahena Road, Siyambalape.','Sec/24/C/8959','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,12,1,NULL,'2024-08-09 08:07:06','2024-10-30 07:43:30'),(8960,'8','The Accountant,','Ravindu.tharaka@aipl.lk. Nalaka@aipl.lk,','E Health Care Solutions (Pvt) Ltd.','no 137, \r\nMahena Road,\r\nSiyambalape','Sec/24/E/8960','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,13,1,NULL,'2024-08-09 08:08:06','2024-10-30 07:43:30'),(8961,'8','The Accountant,','Ravindu.Tharaka@aipl.lk. nalaka@aipl.lk,','Health Innovation (Pvt) Ltd.','No 85/35, \r\nPolhengoda Lane,\r\nColombo 05.','Sec/24/H/8961','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,14,1,NULL,'2024-08-09 08:10:19','2024-10-30 07:43:30'),(8962,'8','The Accountant,','ravindu.tharaka@aipl.lk. Nalaka@aipl.lk,','H 2 O Life Tech (Pvt) Ltd.','No 100, \r\nElvitigala Mawatha, \r\nColombo 08.','Sec/24/H/8962','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,15,1,NULL,'2024-08-09 08:11:51','2024-10-30 07:43:30'),(8963,'8','The Accountant,','Ravindu tharaka@aipl.lk. nalaka @aipl.lk,','Charter House International (Pvt) Ltd.','No 161, Nawala Road,\r\nNarahenpita,\r\nColombo 05.','Sec/24/C/8963','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,16,1,NULL,'2024-08-09 08:13:41','2024-10-30 07:43:30'),(8964,'8','The Accountant,','ravindu tharaka@aipl.lk. nalaka @aipl.lk,','Point of Care Testing (Pvt) Ltd.','No 100/1, \r\nElvitigala Mawatha,\r\nColombo 08.','Sec/24/P/8964','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,17,1,NULL,'2024-08-09 08:15:30','2024-10-30 07:43:30'),(8965,'8','The Accountant,','Ravindu .tharaka@aipl.lk. Nalaka@aipl.lk,','Smart Lanka Diagnostics (Pvt) Ltd.','No 37/3, Bullers Lane,\r\nColombo 07.','Sec/24/S/8965','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,18,1,NULL,'2024-08-09 08:17:14','2024-10-30 07:43:30'),(8966,'8','The Accountant,','ravindu .tharaka@aipl.lk.,','Target Laboratory (Pvt) Ltd.','No 85/35.,\r\nPolhengoda Lane.,\r\nColombo 05.','Sec/24/T/8966','LKR',1.00,'2024-08-13','2024-08-13','1',0,1,20,1,NULL,'2024-08-09 08:18:21','2024-10-30 07:43:30'),(8967,'8','The Accountant,','suranga@etsteas.co.uk niluza badurdeen@etsteas.co.uk','Amazon Teas (Pvt) Ltd.','No 72/6, \r\nKohilawatha Road.\r\nKudabuthgamuwa,\r\nAngoda.','Sec/24/A/8967','LKR',1.00,'2024-08-22','2024-08-22','2',0,1,22,1,NULL,'2024-08-22 05:13:18','2024-10-18 04:57:26'),(8968,'8','The Accountant,','Suranga@etsteas.co.uk, niluza badurdeen@etsteas.co.uk','Eden Grove Ceylon Tea Estates (Pvt) Ltd.','72/06, \r\nKohilawatha Road.\r\nKudabuthgamuwa,\r\nAngoda.','Sec/24/E/8968','LKR',1.00,'2024-08-22','2024-08-22','2',0,1,23,1,NULL,'2024-08-22 05:29:38','2024-10-18 04:57:43'),(8969,'8','The Director.','ajjantha@gmail.com, flying possum@bigpond.com.','Flying Possum (Private) Limited.','No 40,\r\nGalle Face Court 02, \r\nColombo. 03','Sec/24/F/8969','LKR',1.00,'2024-08-22','2024-08-22','1',0,1,24,1,NULL,'2024-08-22 05:34:35','2024-10-30 07:43:30'),(8970,'7','The Accountant,','accounts@nce.lk','National Institute of Exports,','131/6,\r\nElvitigala Mawatha,\r\nColombo 08.','Sec/24/N/8970','LKR',1.00,'2024-08-22','2024-08-22','1',0,1,25,1,NULL,'2024-08-22 05:43:58','2024-08-22 10:03:00'),(8971,'7','The Accountant,','accounts@nce.lk,','The National Chamber of Exporters of Sri Lanka','No 131/6, \r\nElvitigala Mawatha,\r\nColombo 8.','Sec/24/T/8971','LKR',1.00,'2024-08-22','2024-08-22','1',0,1,26,1,NULL,'2024-08-22 05:48:04','2024-08-22 10:03:39'),(8972,'8','The Director,','vbeekjan@gmail.com','Seagull Trades (Private) Limited.','Mahagodawatta, Ibbawela, Weligama','Sec/24/S/8972','LKR',1.00,'2024-08-28','2024-08-28','1',0,1,38,1,NULL,'2024-08-28 05:36:08','2024-10-30 07:43:30'),(8973,'8','The Accountant,','das@slaasmb.gov.lk anushamohotti@slaasmb.gov.lk','SLAASMB','No 293, Galle Road, Colombo 03.','Sec/24/S/8973','LKR',1.00,'2024-09-06','2024-09-06','2',0,1,5,1,NULL,'2024-09-05 04:14:57','2024-10-23 11:39:30'),(8974,'7','The Director,','sahan2sag@gmail.com, anuruddhasanka@gmail.com','N S I Retreat (Private) Limited','352/2, Biyagama Road,\r\nMabima,\r\nHeiyanthuduwa','Sec/24/N/8974','LKR',1.00,'2024-09-06','2024-09-06','1',1,1,39,1,NULL,'2024-09-05 05:03:54','2024-09-09 10:19:07'),(8975,'7','The Director,','sahan2sag@gmail.com, anuruddhasanka@gmail.com','N S I Investment (Private) Limited','352/2,\r\nMabima\r\nHeiyanthuduwa','Sec/24/N/8975','LKR',1.00,'2024-09-06','2024-09-06','1',0,1,40,1,NULL,'2024-09-05 05:21:30','2024-10-30 07:43:30'),(8976,'7','The Director,','cantablife@gmail.com','Island Processes (Pvt) Ltd','No 40, Galle Face Court 2,\r\nColombo 03','Sec/24/I/8976','USD',1.00,'2024-09-27','2024-09-27','3',1,1,41,1,NULL,'2024-09-09 07:08:02','2024-09-27 10:14:00'),(8977,'7','The Director,','cantablife@gmail.com','Island Processes (Pvt) Ltd','No 40, Galle Face Court 2,\r\nColombo 03','Sec/23/I/8977','USD',1.00,'2024-09-27','2024-09-27','3',1,2,41,2,NULL,'2024-09-09 07:49:46','2024-09-27 10:12:59'),(8978,'8','The Accountant,','das@slaasmb.gov.lk anushamohotti@slaasmb.gov.lk','SLAASMB','No 293, Galle Road, Colombo 03.','Sec/24/S/8978','LKR',1.00,'2024-10-01','2024-10-01','2',0,1,5,1,NULL,'2024-09-25 06:13:51','2024-10-23 11:39:56'),(8979,'7','The Director,','hurbeng@nadathur.com','Roehampton (Private) Limited','# 40, GALLE FACE Court 2','Sec/24/R/8979','USD',1.00,'2024-09-27','2024-09-27','4',1,2,42,2,NULL,'2024-09-25 07:10:42','2024-09-27 10:00:24'),(8980,'8','The Director,','tdingler@gmail.com','Trinavest (Private) Limited','No 40 Galle Face Court 2 Colombo 3','Sec/24/T/8980','USD',1.00,'2024-10-02','2024-10-02','4',0,1,43,2,NULL,'2024-10-01 06:40:45','2024-10-24 08:57:12'),(8981,'6','The Director,','giles@ulpotha.com','Aloka Lanka (Private) Limited,','# 36, Galle Face Court 02,\r\nColombo 03.','Sec/24/A/8981','LKR',1.00,'2024-10-15','2024-10-15','1',1,1,44,1,NULL,'2024-10-03 04:36:20','2024-11-04 05:24:17'),(8982,'4','The Director,','giles@ulpotha.com','Isthmus Garden (Pvt) Ltd','Galle Face Court 2,','Sec/24/I/8982','LKR',1.00,'2024-07-31','2024-07-31','1',0,1,45,1,NULL,'2024-10-03 04:58:26','2024-11-05 03:09:49'),(8983,'4','The Director,','shantanu@expolanka.com aruni.john@gmail.com','Ama Dablam Associates (Private) Limited','25 Galle Face Court 2.','Sec/24/A/8983','LKR',1.00,'2024-07-31','2024-07-31','1',0,1,46,1,NULL,'2024-10-03 05:14:07','2024-11-05 03:10:22'),(8984,'4','The Director,','mwsaunders@gmail.com','Ambawatta (Private) Limited','25,Colombo 03','Sec/24/A/8984','LKR',1.00,'2024-07-31','2024-07-31','1',0,2,47,2,NULL,'2024-10-03 05:46:19','2024-11-05 03:10:56'),(8985,'4','The Director,','mwsaunders@gmail.com','Red Oil (Private) Limited','25 Colombo 3','Sec/24/R/8985','LKR',1.00,'2024-07-31','2024-07-31','1',0,1,48,2,NULL,'2024-10-03 06:01:49','2024-11-05 03:11:35'),(8986,'8','The Director,','simonanthea@gmail.com','Anter Teas (Private) Limited.','No. 40, \r\nGalle Face Court 02, \r\nColombo 03.,','SEC/24/A/8986','LKR',1.00,'2024-10-07','2024-10-07','1',1,1,49,1,NULL,'2024-10-04 05:29:37','2024-10-11 09:48:59'),(8987,'7','The Director,','MarkGriffiths@peacockestates.com','Muhudu Sihinaya (Private) Limited','40..Galle Face Court 2','Sec/21/M/8987','LKR',1.00,'2024-10-09','2024-10-09','3',0,2,50,1,NULL,'2024-10-09 04:31:07','2024-10-09 09:16:10'),(8988,'7','The Director,','MarkGriffiths@peacockestates.com','Muhudu Sihinaya (Private) Limited','40..Galle Face Court 2','Sec/22/M/8988','LKR',1.00,'2024-10-09','2024-10-09','3',0,2,50,1,NULL,'2024-10-09 04:52:46','2024-10-09 09:19:02'),(8989,'7','The Director,','MarkGriffiths@peacockestates.com','Muhudu Sihinaya (Private) Limited','40..Galle Face Court 2','Sec/23/M/8989','LKR',1.00,'2024-10-09','2024-10-09','3',0,1,50,1,NULL,'2024-10-09 05:07:20','2024-10-09 09:21:32'),(8990,'7','The Director,','MarkGriffiths@peacockestates.com','Muhudu Sihinaya (Private) Limited','40..Galle Face Court 2','Sec/24/M/8990','LKR',1.00,'2024-10-09','2024-10-09','3',0,1,50,1,NULL,'2024-10-09 05:23:58','2024-10-09 09:24:34'),(8991,'7','The Director,','MarkGriffiths@peacockestates.com','Southern Reef (Private) Limited','No,40, Galle Face Court 2 Colombo 3','Sec/21/S/8991','LKR',1.00,'2024-10-09','2024-10-09','3',0,1,51,1,NULL,'2024-10-09 05:51:01','2024-10-09 09:32:04'),(8992,'7','The Director,','MarkGriffiths@peacockestates.com','Southern Reef (Private) Limited','No,40, Galle Face Court 2 Colombo 3','Sec/22/S/8992','LKR',1.00,'2024-10-09','2024-10-09','3',0,1,51,1,NULL,'2024-10-09 05:55:17','2024-10-09 09:33:58'),(8993,'7','The Director,','MarkGriffiths@peacockestates.com','Southern Reef (Private) Limited','No,40, Galle Face Court 2 Colombo 3','SEc/23/S/8993','LKR',1.00,'2024-10-09','2024-10-09','3',0,1,51,1,NULL,'2024-10-09 06:00:46','2024-10-09 09:35:16'),(8994,'7','The Director,','MarkGriffiths@peacockestates.com','Southern Reef (Private) Limited','No,40, Galle Face Court 2 Colombo 3','Sec/24/S/8994','LKR',1.00,'2024-10-09','2024-10-09','3',0,1,51,1,NULL,'2024-10-09 06:12:43','2024-10-09 09:36:42'),(8995,'4','The Director,','mwsaunders@gmail.com','Red Tropic (Private) Limited','# 40, Galle Face Court 2 Colombo 3','SEC/24/R/8995','LKR',1.00,'2024-07-31','2024-07-31','1',0,2,52,2,NULL,'2024-10-15 05:43:22','2024-11-05 03:11:58'),(8996,'2','The Director,','garywatmore@gmail.com','Aspen Tree Lanka (Private) Limited','* 40 \r\nGALLE FACE COURT 2 COLOMBO 3','Sec/24/A/8996','LKR',1.00,'2024-07-31','2024-07-31','1',0,2,53,2,NULL,'2024-10-15 06:43:44','2024-11-04 09:20:46'),(8997,'7','The Director,','Anura Rambukwella <anurak@thefinance.lk','Telford Educational Services (Private) Limited,','# 55, R.A.DE.MEL Mawatha,Colombo 04.','Sec/24/T/8997','LKR',1.00,'2024-11-04','2024-11-04','1',1,1,54,1,NULL,'2024-10-15 08:24:44','2024-11-04 07:33:21'),(9000,'9','The Accountant,','nimali.ncpc@gmail.com','National Cleaner Production Centre,','No 65/1,  \r\nDevala Road,\r\nNugegoda.','Sec/24/N/8998','LKR',1.00,'2024-07-31','2024-07-31','2',0,1,31,1,NULL,'2024-10-24 08:16:18','2024-11-05 03:15:49'),(9001,'4','The Director,','patriciap@anthoneysfeeds.com','New Anthoney’s Feeds Ltd','#205, Vystwyke Road \r\nColombo 15.','Sec/24/N/8999','LKR',1.00,'2024-07-31','2024-07-31','1',0,1,56,1,NULL,'2024-10-28 06:45:50','2024-11-05 03:19:07'),(9002,'4','The Director,','mahinda@malwatte.lk','Malwatte Valley Plantations PLC','No 280, Dam Street\r\nColombo 12.','Sec/24/M/9000','LKR',1.00,'2024-07-31','2024-07-31','4',0,1,57,1,NULL,'2024-10-30 06:52:13','2024-11-05 03:27:36'),(9003,'4','The Accountant,','das@slaasmb.gov.lk anushamohotti@slaasmb.gov.lk','SLAASMB','No 293, Galle Road, Colombo 03.','Sec/24/S/9001','LKR',1.00,'2024-07-31','2024-07-31','2',0,1,5,1,NULL,'2024-10-31 08:33:14','2024-11-05 03:28:03'),(9004,'4','The Director,','mwsaunders@gmail.com','Pride Mountain Holdings (Private) Limited','# Galle Face Court 2Colombo 003','Sec/24/P/9002','LKR',1.00,'2024-07-31','2024-07-31','1',0,2,58,2,NULL,'2024-11-01 06:57:30','2024-11-05 03:28:18'),(9005,'2','The Director,','antonynbrown@yahoo.com','Forty -Five Pedlar Street (Private) Limited','40 Galle Face Court Colombo 3','Sec/24/F/9003','LKR',1.00,'2024-07-31','2024-07-31','1',0,1,59,1,NULL,'2024-11-04 10:31:38','2024-11-04 10:35:37');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2019_12_14_000001_create_personal_access_tokens_table',1),(4,'2024_03_21_060912_create_company_details_table',1),(5,'2024_03_21_060921_create_invoices_table',1),(6,'2024_03_21_060927_create_invoice_details_table',1),(7,'2024_03_30_113917_create_handlers_table',1),(8,'2024_04_02_035853_create_payments_table',1),(9,'2024_04_07_082137_create_modelreceipts_table',1),(10,'2024_09_02_050114_create_otps_table',2),(11,'2024_09_13_054458_add_customer_ref_id_to_invoices_table',2),(12,'2024_10_15_083233_add_invoice_i_d_to_invoice_details_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelreceipts`
--

DROP TABLE IF EXISTS `modelreceipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelreceipts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoiceNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiptNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `payedDate` date NOT NULL,
  `offline` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelreceipts`
--

LOCK TABLES `modelreceipts` WRITE;
/*!40000 ALTER TABLE `modelreceipts` DISABLE KEYS */;
INSERT INTO `modelreceipts` VALUES (1,'Sec/24/S/8953','R0001','0','2024-08-13',0,'2024-08-13 10:45:17','2024-08-13 10:45:17'),(2,'Sec/24/K/8950','R0002','0','2024-08-23',1,'2024-08-23 09:23:06','2024-08-23 09:23:06'),(3,'Sec/24/K/8950','R0003','0','2024-08-23',1,'2024-08-23 09:23:39','2024-08-23 09:23:39'),(4,'Sec/24/K/8950','R0004','0','2024-08-23',1,'2024-08-23 09:24:46','2024-08-23 09:24:46'),(5,'Sec/24/K/8950','R0005','0','2024-08-23',1,'2024-08-23 09:26:07','2024-08-23 09:26:07'),(6,'Sec/24/K/8950','R0006','0','2024-08-23',1,'2024-08-23 09:26:22','2024-08-23 09:26:22'),(7,'Sec/24/K/8950','R0007','0','2024-08-23',1,'2024-08-23 09:26:22','2024-08-23 09:26:22'),(8,'Sec/24/F/8969','R 6669','0','2024-08-30',0,'2024-08-30 04:36:55','2024-08-30 04:36:55'),(9,'Sec/24/A/8954','6681','0','2024-09-05',0,'2024-09-05 08:57:48','2024-09-05 08:57:48'),(10,'Sec/24/A/8955','6682','0','2024-09-05',0,'2024-09-05 09:06:31','2024-09-05 09:06:31'),(11,'Sec/24/A/8956','6683','0','2024-09-06',0,'2024-09-06 07:34:22','2024-09-06 07:34:22'),(12,'Sec/24/A/8957','6684','0','2024-09-06',0,'2024-09-06 07:41:13','2024-09-06 07:41:13'),(13,'Sec/24/B/8958','6685','0','2024-09-06',0,'2024-09-06 07:47:14','2024-09-06 07:47:14'),(14,'Sec/24/C/8959','6686','0','2024-09-06',0,'2024-09-06 07:52:40','2024-09-06 07:52:40'),(15,'Sec/24/E/8960','6687','0','2024-09-06',0,'2024-09-06 08:44:43','2024-09-06 08:44:43'),(16,'Sec/24/H/8961','6688','0','2024-09-06',0,'2024-09-06 08:59:18','2024-09-06 08:59:18'),(17,'Sec/24/H/8962','6689','0','2024-09-06',0,'2024-09-06 09:15:02','2024-09-06 09:15:02'),(18,'Sec/24/C/8963','6690','0','2024-09-06',0,'2024-09-06 09:39:07','2024-09-06 09:39:07'),(19,'Sec/24/P/8964','6691','0','2024-09-06',0,'2024-09-06 09:45:32','2024-09-06 09:45:32'),(20,'Sec/24/S/8965','6692','0','2024-09-06',0,'2024-09-06 09:54:43','2024-09-06 09:54:43'),(21,'Sec/24/T/8966','6693','0','2024-09-06',0,'2024-09-06 10:01:28','2024-09-06 10:01:28'),(22,'Sec/24/K/8950','6721','0','2024-09-25',0,'2024-09-25 05:02:39','2024-09-25 05:02:39'),(23,'Sec/24/P/8951','6721','0','2024-09-25',0,'2024-09-25 05:42:27','2024-09-25 05:42:27'),(24,'Sec/24/S/8972','6745','0','2024-10-10',0,'2024-10-10 04:43:34','2024-10-10 04:43:34'),(25,'SEC/24/A/8986','6746','0','2024-10-11',0,'2024-10-11 09:04:48','2024-10-11 09:04:48'),(26,'Sec/24/K/8952','6750','0.00','2024-10-15',0,'2024-10-15 11:07:42','2024-10-15 11:07:42'),(27,'Sec/24/A/8967','R6753','0','2024-10-18',0,'2024-10-18 04:57:26','2024-10-18 04:57:26'),(28,'Sec/24/E/8968','R6753','0','2024-10-18',0,'2024-10-18 04:57:43','2024-10-18 04:57:43'),(31,'Sec/24/S/8973','R 6757','0','2024-10-23',0,'2024-10-23 11:39:30','2024-10-23 11:39:30'),(32,'Sec/24/S/8978','R 6757','0','2024-10-23',0,'2024-10-23 11:39:56','2024-10-23 11:39:56'),(33,'Sec/24/S/8978','R 6757','0','2024-10-23',0,'2024-10-23 11:47:10','2024-10-23 11:47:10'),(34,'Sec/24/T/8980','R 6758','0','2024-10-24',0,'2024-10-24 08:51:08','2024-10-24 08:51:08'),(35,'Sec/24/T/8980','6758','0','2024-10-24',0,'2024-10-24 08:56:08','2024-10-24 08:56:08');
/*!40000 ALTER TABLE `modelreceipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otps`
--

DROP TABLE IF EXISTS `otps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otps`
--

LOCK TABLES `otps` WRITE;
/*!40000 ALTER TABLE `otps` DISABLE KEYS */;
/*!40000 ALTER TABLE `otps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `acName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountNo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `swiftCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_accountno_unique` (`accountNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'SECRETARIUS (PVT) LTD.','000910010182','SAMPATH BANK PLC- Nawam Mawatha Branch.','46/38, Navam Mawatha, Colombo 02','BSAMLKLX',0,'2024-07-31 08:44:22','2024-07-31 08:44:22'),(2,'SECRETARIUS (PVT) LTD.','500930003800','SAMPATH BANK PLC- Nawam Mawatha Branch.','46/38, Navam Mawatha, Colombo 02','BSAMLKLX',0,'2024-07-31 08:46:04','2024-07-31 08:46:04');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@gmail.com','2024-07-31 07:21:51','$2y$10$F99kZOZmfS38wncQt37Qa.EpHXGSaiu.52clLJ1IauJ08tD8QfiMe',2,NULL,'2024-07-31 07:21:51','2024-07-31 07:21:51'),(2,'Neelababile','simonsec@simonas.net','2024-07-31 07:21:51','$2y$10$//ZE8kAykrfYAo7R3l17jOAdLkCmKahI.qS/g/11DOo2xNzLiPtUe',1,NULL,'2024-07-31 07:21:51','2024-07-31 07:21:51'),(3,'Dilrukshi','dilrukshi@simonas.net','2024-07-31 07:21:51','$2y$10$LrKVpfFY2r5LPxA6GO01dOH3Jb.1dsoAay63TOz/iweOKPNcg/Wem',3,NULL,'2024-07-31 07:21:51','2024-07-31 07:21:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-05  4:15:41
