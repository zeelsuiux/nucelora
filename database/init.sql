-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: lymko_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT 1,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,1,'Lymko Admin','admin@lymko.in','$2y$10$C4gmr1pQ86LYTAiUl.GnBuj1TeEl1r3Mw6HQ5Q6QAfVf0R0IjyyaW','active','2026-11-04 09:49:10','2026-10-29 17:54:35','2026-11-04 04:19:10');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details_json`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `badge_text` varchar(100) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT 'Shop now',
  `button_url` varchar(255) DEFAULT '/collections/all',
  `desktop_image_url` varchar(255) NOT NULL,
  `mobile_image_url` varchar(255) DEFAULT NULL,
  `bg_tint` varchar(50) DEFAULT '#f7f6f4',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'Good skin. Better you.','Targeted botanical serums and daily rituals formulated for radiant, healthy Indian skin.','Skincare | Haircare','Shop Now','/collections/all','https://lymko.in/cdn/shop/files/01_00038bd1-1c41-476d-9bcc-3d3055e5027f.jpg',NULL,'#f7f6f4',1,1),(2,'Curated Daily Rituals','Complete 4-step morning and evening routines designed to simplify your skincare journey.','Curated Sets','Explore Rituals','/collections/rituals','https://lymko.in/cdn/shop/files/01_00038bd1-1c41-476d-9bcc-3d3055e5027f.jpg',NULL,'#fdeee6',2,1);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `variant_id` int(10) unsigned DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `cart_id` (`cart_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (1,9,1,NULL,2,499.00,'2026-10-29 18:14:30','2026-10-29 18:14:30'),(5,34,1,NULL,1,499.00,'2026-11-03 06:30:00','2026-11-03 06:30:00'),(6,35,1,NULL,1,499.00,'2026-11-03 06:31:47','2026-11-03 06:31:47'),(7,38,1,NULL,1,499.00,'2026-11-03 06:40:31','2026-11-03 06:40:31'),(8,32,1,NULL,1,499.00,'2026-11-03 06:42:59','2026-11-03 06:48:25'),(9,41,1,NULL,1,499.00,'2026-11-03 06:45:52','2026-11-03 06:45:52'),(10,44,1,NULL,1,499.00,'2026-11-03 06:47:29','2026-11-03 06:47:29'),(12,49,1,NULL,1,499.00,'2026-11-03 06:51:50','2026-11-03 06:51:50'),(13,60,1,NULL,1,499.00,'2026-11-03 07:08:14','2026-11-03 07:08:14');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_token` varchar(100) NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_token` (`session_token`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,'3acd5bf13f6064972cdb15774dd1660a',NULL,NULL,'2026-10-29 18:13:05','2026-10-29 18:13:05'),(2,'d1e4b078f8c9537ee879df2004300b5b',NULL,NULL,'2026-10-29 18:13:35','2026-10-29 18:13:35'),(3,'b109629a4bef53a669ec8d20ceccb389',NULL,NULL,'2026-10-29 18:13:51','2026-10-29 18:13:51'),(4,'dd5ef251854ecf1c3375b1d8860df7f4',NULL,NULL,'2026-10-29 18:13:51','2026-10-29 18:13:51'),(5,'83469c99238c32235ff33afe0c7d27c0',NULL,NULL,'2026-10-29 18:13:51','2026-10-29 18:13:51'),(6,'5d1575dfccfccd6c502dcbebd15e1d0e',NULL,NULL,'2026-10-29 18:13:51','2026-10-29 18:13:51'),(7,'ec404492a8c6e05cb58bd5b588258ffc',NULL,NULL,'2026-10-29 18:13:51','2026-10-29 18:13:51'),(8,'4e9dc5f09bfc82ed36c545b5c2ed79ea',NULL,NULL,'2026-10-29 18:13:59','2026-10-29 18:13:59'),(9,'414605a2c56216f111247e71dfc745f9',NULL,NULL,'2026-10-29 18:14:30','2026-10-29 18:14:30'),(10,'ecba535eb5b8908a1f7044715b632c65',NULL,NULL,'2026-10-29 18:15:21','2026-10-29 18:15:21'),(11,'e26e3487ac8ccb2a65485cf440487e78',NULL,NULL,'2026-10-29 18:16:16','2026-10-29 18:16:16'),(12,'d1c1c3841357ac20df481a4482875e16',NULL,NULL,'2026-10-29 18:18:20','2026-10-29 18:18:20'),(13,'416d7a08c7d2a49b731f7f9673eeb6ed',NULL,NULL,'2026-10-29 18:18:49','2026-10-29 18:18:49'),(14,'6535e6216b4a8068b13f0120f98d58c4',NULL,NULL,'2026-10-29 18:28:11','2026-10-29 18:28:11'),(15,'83b6bd2800688074d6e9877cecaa17a5',NULL,NULL,'2026-10-29 18:28:31','2026-10-29 18:28:31'),(16,'4cd107851e27571907195a479b458925',NULL,NULL,'2026-10-29 18:29:45','2026-10-29 18:29:45'),(17,'c80575ff153ce89bfe2ddffd4423060d',NULL,NULL,'2026-10-29 18:30:25','2026-10-29 18:30:25'),(18,'0d8fc963c72142c3312d1f538cc736c0',NULL,NULL,'2026-11-02 06:50:42','2026-11-02 06:50:42'),(19,'7dca79660be34b2a24fed2eb856a60d6',NULL,NULL,'2026-11-02 06:51:11','2026-11-02 06:51:11'),(20,'39b60081689e0e7d8d98434539e74b87',NULL,NULL,'2026-11-02 06:51:20','2026-11-02 06:51:20'),(21,'a557c5b7ca1e07bb796becdc300285eb',NULL,NULL,'2026-11-02 06:51:31','2026-11-02 06:51:31'),(22,'dacbd2f7977e1acb7b5cb48804c4ff69',NULL,NULL,'2026-11-02 06:51:37','2026-11-02 06:51:37'),(23,'51704480e41d099ee329f66840eaeaea',NULL,NULL,'2026-11-02 06:51:43','2026-11-02 06:51:43'),(24,'db87e057b73bbb5e0d6a9ad06f37c475',NULL,NULL,'2026-11-02 06:52:04','2026-11-02 06:52:04'),(25,'6a299d1cefedb56360d5e4f065cd8fa7',NULL,NULL,'2026-11-02 07:04:50','2026-11-02 07:04:50'),(26,'c69210a5eb5bd7431dafc00a321c1b7b',NULL,NULL,'2026-11-02 07:05:49','2026-11-02 07:05:49'),(27,'602e35013b602db8c5022bfde36e1069',NULL,NULL,'2026-11-02 07:06:56','2026-11-02 07:06:56'),(28,'bc6c0fe556c4a8e11fed71ae60de0b4b',NULL,NULL,'2026-11-02 07:07:02','2026-11-02 07:07:02'),(29,'e1b855803e0a723a3b9e558dbd22a286',NULL,NULL,'2026-11-02 07:13:27','2026-11-02 07:13:27'),(30,'21c29818d6cd5becfeaf6b6aa4f68ca5',NULL,NULL,'2026-11-03 06:18:30','2026-11-03 06:18:30'),(31,'e749bad148511524584d4578ff8b509d',NULL,NULL,'2026-11-03 06:19:03','2026-11-03 06:19:03'),(32,'dc5f0b0680e54f9260e21a5cf8e31d09',NULL,NULL,'2026-11-03 06:19:14','2026-11-03 06:19:14'),(33,'c6ccf87c762ee349d97ddc27c0b4090e',NULL,NULL,'2026-11-03 06:29:48','2026-11-03 06:29:48'),(34,'5d5b145d425b6c116a536a54916e1422',NULL,NULL,'2026-11-03 06:30:00','2026-11-03 06:30:00'),(35,'081e402ef6c35085dc50ebc4e45bc162',NULL,NULL,'2026-11-03 06:31:47','2026-11-03 06:31:47'),(36,'fd9378ba840b2cc8a1e9628763ff4588',NULL,NULL,'2026-11-03 06:37:14','2026-11-03 06:37:14'),(37,'37021e5dc0fafca754fd02c2c0f1f61d',NULL,NULL,'2026-11-03 06:40:24','2026-11-03 06:40:24'),(38,'ecf6c1ccc117db3668a1d291cb4abc54',NULL,NULL,'2026-11-03 06:40:31','2026-11-03 06:40:31'),(39,'af13bbe1d9847e3c0c94f002b288bffc',NULL,NULL,'2026-11-03 06:43:32','2026-11-03 06:43:32'),(40,'24a2ec6710258c2b7f1dd11cc8ea57ba',NULL,NULL,'2026-11-03 06:43:42','2026-11-03 06:43:42'),(41,'9d1619086a033a5a502f52b6e2781ff1',NULL,NULL,'2026-11-03 06:45:52','2026-11-03 06:45:52'),(42,'abfeff18584a9939d30e7d7bcf733e62',NULL,NULL,'2026-11-03 06:46:14','2026-11-03 06:46:14'),(43,'a16ecf9958b80d2d2917f84574d36b2d',NULL,NULL,'2026-11-03 06:46:47','2026-11-03 06:46:47'),(44,'d6a9c5892b6f5838d734e4f27d7f6c34',NULL,NULL,'2026-11-03 06:47:29','2026-11-03 06:47:29'),(45,'7f4e2de8581f3c3623b17f14da293c24',NULL,NULL,'2026-11-03 06:48:03','2026-11-03 06:48:03'),(46,'9f9c8a3d49239e175e2aecd53ae8b123',NULL,NULL,'2026-11-03 06:49:43','2026-11-03 06:49:43'),(47,'89ab6a50a6050572268b3c475fb6ff35',NULL,NULL,'2026-11-03 06:51:23','2026-11-03 06:51:23'),(48,'300a18ecfc873d12503dafe11e068559',NULL,NULL,'2026-11-03 06:51:29','2026-11-03 06:51:29'),(49,'7e2c644579d0ffb585096d010af028fe',NULL,NULL,'2026-11-03 06:51:50','2026-11-03 06:51:50'),(50,'12cb54dddf18a5f9c4e9d814d4133906',NULL,NULL,'2026-11-03 06:52:04','2026-11-03 06:52:04'),(51,'96cb26610481be2263b0dc0b793a65e8',NULL,NULL,'2026-11-03 06:54:17','2026-11-03 06:54:17'),(52,'f14a62d008d82a7902187cefa395d554',NULL,NULL,'2026-11-03 06:56:15','2026-11-03 06:56:15'),(53,'9ebaa68ffa79f23491084ae7c3c7e102',NULL,NULL,'2026-11-03 06:56:15','2026-11-03 06:56:15'),(54,'383cf05c120cb74fdfca70fb418cc490',NULL,NULL,'2026-11-03 06:56:15','2026-11-03 06:56:15'),(55,'00072533d0f49c33feed5891e0732137',NULL,NULL,'2026-11-03 06:56:15','2026-11-03 06:56:15'),(56,'91b5fd29e9f90a01aa69ef92da88b2f5',NULL,NULL,'2026-11-03 06:56:24','2026-11-03 06:56:24'),(57,'74ca6d6fecb3bb945d83e3d715d71078',NULL,NULL,'2026-11-03 06:56:31','2026-11-03 06:56:31'),(58,'3d3a4fab04bdd91ff4e79fc61b3768d6',NULL,NULL,'2026-11-03 07:06:48','2026-11-03 07:06:48'),(59,'6ecaf2600f82fd97a09e7ff50692d45e',NULL,NULL,'2026-11-03 07:07:00','2026-11-03 07:07:00'),(60,'84484f6ce398d36c11b14e2f852711e4',NULL,NULL,'2026-11-03 07:07:11','2026-11-03 07:07:11'),(61,'f420f69efb746859310b724a42005f95',NULL,NULL,'2026-11-03 07:10:27','2026-11-03 07:10:27'),(62,'4c318d6e8bc401b03e251cdc45f9da93',NULL,NULL,'2026-11-03 07:10:55','2026-11-03 07:10:55'),(63,'7d7cf74113cc5cdc3ec5a77172e01f9e',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(64,'162a65f1746493d83a5614720af9852a',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(65,'5c68748aa344dfc7247e11217ad0c7b5',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(66,'004288513f4fd41f29aa750bb34705f9',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(67,'fb2929d0cbdb6a8ec940fd3f8d75c30c',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(68,'aaf091f1de64157387984920f765070d',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(69,'75984e809146f3752a4e700f8db76deb',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(70,'5cb0eea969b94c7b60a2ad4053711125',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(71,'0c6bd1b212777d0dc6bb1243f6c29b5f',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(72,'f16cba111bda7e4ee753f4586bf043b7',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(73,'630c6c9ef1295115a5ef2c6250a1c5d4',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(74,'d59d18faf9c241852b94b0da8bdc50ca',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(75,'ba1167b2a5417a5d45f7b3841be31549',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(76,'9c6732504d4039725e0baa063f1a217b',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(77,'fa49e58d27726a33d039c89e625904a1',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(78,'6c0c45897e1a6892a15b23c15a42995a',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(79,'6b77a21669b14618eeb4ee249a41cda3',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(80,'b10b70b59c91e387ee417b511928abe8',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(81,'2a278a97e9ed9922b4ea950289ad069c',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(82,'6b028d5e4263bfcaeb90dd285eaedefb',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(83,'7a4f1f7a5e752996c05fef461f33ba16',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(84,'c7fd8700af580c7db34ccf6fa0db1943',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(85,'5d7848626a42ab40bfccd699ccc55d02',NULL,NULL,'2026-11-04 04:15:00','2026-11-04 04:15:00'),(86,'69ed6da75922112e5754a6c4dc647f2b',NULL,NULL,'2026-11-04 04:15:52','2026-11-04 04:15:52'),(87,'13ec603e05f2e1af1803935c9571848d',NULL,NULL,'2026-11-04 04:25:35','2026-11-04 04:25:35'),(88,'85c0bb8049cb79965f38d354b0f2af1b',NULL,NULL,'2026-11-04 04:26:34','2026-11-04 04:26:34'),(89,'10b4e99d8fde2c3dc5d0c5e0c3f86856',NULL,NULL,'2026-11-04 04:30:29','2026-11-04 04:30:29'),(90,'7ef03adc87653b998c9445a2ab2544d7',NULL,NULL,'2026-11-04 04:30:30','2026-11-04 04:30:30'),(91,'c37eb245b981f4c2d83de81d29b1cd9e',NULL,NULL,'2026-11-04 04:30:30','2026-11-04 04:30:30'),(92,'f919e551c1e378490d4d0ac79d413cdb',NULL,NULL,'2026-11-04 04:30:30','2026-11-04 04:30:30'),(93,'e09402658bb6fdb8ef0e3e9079e05b74',NULL,NULL,'2026-11-04 04:30:30','2026-11-04 04:30:30'),(94,'c0bb4ee1e949a99411edc1eef59a3a2e',NULL,NULL,'2026-11-04 04:30:30','2026-11-04 04:30:30'),(95,'fe18fff122559fb6eb92eca559369534',NULL,NULL,'2026-11-04 04:30:30','2026-11-04 04:30:30'),(96,'7c92f1b69107064bd6ad612fbbabb793',NULL,NULL,'2026-11-04 04:30:36','2026-11-04 04:30:36'),(97,'055864b1a11c2a522211728e42a0feb0',NULL,NULL,'2026-11-04 04:33:44','2026-11-04 04:33:44'),(98,'285f4b3b3761a19d7a6f0e4e38191c70',NULL,NULL,'2026-11-04 04:33:50','2026-11-04 04:33:50'),(99,'d897152eae1f37b8eb8a50feb8e44aa4',NULL,NULL,'2026-11-04 04:36:29','2026-11-04 04:36:29'),(100,'798f3a08fc95682a034e845818087f52',NULL,NULL,'2026-11-04 04:46:18','2026-11-04 04:46:18'),(101,'e2cc5afb6735d7847e8fc87385a7712c',NULL,NULL,'2026-11-04 04:46:18','2026-11-04 04:46:18'),(102,'d5b326c4c18610ea4e2b01900d0b872e',NULL,NULL,'2026-11-04 04:46:18','2026-11-04 04:46:18'),(103,'76c20435374c94c427de29e9d32bf2d3',NULL,NULL,'2026-11-04 04:46:18','2026-11-04 04:46:18'),(104,'21439825a73b702c0a65f98c557611f8',NULL,NULL,'2026-11-04 04:46:18','2026-11-04 04:46:18'),(105,'391145750a946041602bb8781ac8283a',NULL,NULL,'2026-11-04 04:46:18','2026-11-04 04:46:18'),(106,'9f158a5ed737a5c02ac311ce9e054cb4',NULL,NULL,'2026-11-04 04:47:28','2026-11-04 04:47:28'),(107,'c7f0060d58116d5232431ab4626e451a',NULL,NULL,'2026-11-04 05:31:11','2026-11-04 05:31:11'),(108,'4021cba1927a0a2d1d9b6636349f712b',NULL,NULL,'2026-11-04 05:31:36','2026-11-04 05:31:36'),(109,'056acd2f3f6e117878c7a28768e2ce89',NULL,NULL,'2026-11-04 06:10:21','2026-11-04 06:10:21'),(110,'d429442134de633f1c25f20095c6673d',NULL,NULL,'2026-11-04 06:10:22','2026-11-04 06:10:22'),(111,'d59d8d9cbfb801e6780b2641507b019c',NULL,NULL,'2026-11-04 06:10:42','2026-11-04 06:10:42'),(112,'a9bef34d662c84ca1f187d6f6947c983',NULL,NULL,'2026-11-04 06:11:01','2026-11-04 06:11:01'),(113,'1fa47ebce7a3e467cba4e65de59da9cc',NULL,NULL,'2026-11-04 06:15:39','2026-11-04 06:15:39'),(114,'64a63ea1d02ea0a00c56042aabf26dc8',NULL,NULL,'2026-11-04 06:15:45','2026-11-04 06:15:45'),(115,'1ea93cd1338a0d72c9f6e6b29afd125c',NULL,NULL,'2026-11-04 06:16:03','2026-11-04 06:16:03'),(116,'86cc205c67049518eda5034126758b49',NULL,NULL,'2026-11-04 06:16:11','2026-11-04 06:16:11'),(117,'b72e4b1273621613f378cc12770e7f2f',NULL,NULL,'2026-11-04 06:19:11','2026-11-04 06:19:11'),(118,'7fcba812f125970b9bb86b9d31e20414',NULL,NULL,'2026-11-04 06:19:12','2026-11-04 06:19:12'),(119,'0bac84611018bdbd413d66634b6e75bf',NULL,NULL,'2026-11-04 06:19:12','2026-11-04 06:19:12'),(120,'2fdb5e4521b5c66a54ed0951b70fb5ac',NULL,NULL,'2026-11-04 06:19:12','2026-11-04 06:19:12'),(121,'9a589f06b5f44ff1bf77f3172a698988',NULL,NULL,'2026-11-04 06:19:13','2026-11-04 06:19:13'),(122,'10a9d1b1f63aee7eeb242be635939fe1',NULL,NULL,'2026-11-04 06:19:23','2026-11-04 06:19:23'),(123,'ae390e8ba9d259214808c790a4442278',NULL,NULL,'2026-11-04 07:42:05','2026-11-04 07:42:05'),(124,'3bb240bb35db7b76c281815e075ce102',NULL,NULL,'2026-11-04 07:42:22','2026-11-04 07:42:22'),(125,'aa02e48e6e85e6d1e88358dc3f987acd',NULL,NULL,'2026-11-04 07:42:24','2026-11-04 07:42:24'),(126,'3207de1a1f30c704a4516efa31e5bda8',NULL,NULL,'2026-11-04 08:04:37','2026-11-04 08:04:37'),(127,'147d40039f6cee3708353c058ee8b448',NULL,NULL,'2026-11-04 08:07:20','2026-11-04 08:07:20'),(128,'595689171073c8d922b093261f685d01',NULL,NULL,'2026-11-04 08:08:35','2026-11-04 08:08:35');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,NULL,'Face Serums','face-serums','Targeted facial treatment serums formulated with clinically proven botanical actives',NULL,1,1,NULL,NULL,'2026-10-29 17:54:35'),(2,NULL,'Face Wash','face-wash','Gentle, pH-balanced cleansers that purify without stripping natural moisture',NULL,2,1,NULL,NULL,'2026-10-29 17:54:35'),(3,NULL,'Moisturizers','moisturizer','Deep hydration and skin barrier strengthening creams and lotions',NULL,3,1,NULL,NULL,'2026-10-29 17:54:35'),(4,NULL,'Sun Protection','sunscreen','Broad spectrum SPF protection against UVA and UVB rays without white cast',NULL,4,1,NULL,NULL,'2026-10-29 17:54:35'),(5,NULL,'Hair Care','hair-care','Scalp therapy and hair flyaway finishing sticks',NULL,5,1,NULL,NULL,'2026-10-29 17:54:35'),(6,NULL,'Rituals & Bundles','rituals','Curated step-by-step skincare rituals for comprehensive skin wellness',NULL,6,1,NULL,NULL,'2026-10-29 17:54:35'),(7,NULL,'Best Sellers','best-selling','Most loved everyday essentials by thousands of happy customers',NULL,7,1,NULL,NULL,'2026-10-29 17:54:35');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_pages`
--

DROP TABLE IF EXISTS `cms_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content_html` longtext NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_pages`
--

LOCK TABLES `cms_pages` WRITE;
/*!40000 ALTER TABLE `cms_pages` DISABLE KEYS */;
INSERT INTO `cms_pages` VALUES (1,'About Us','about-us','<h2>Our Philosophy</h2><p>At Lymko, we believe skincare should be intuitive, effective, and grounded in transparent science. Inspired by minimalist Korean routines and tailored specifically for Indian skin climates, our formulations pair proven botanical extracts with high-efficacy active ingredients.</p><p>Every formula is crafted without parabens, sulfates, artificial dyes, or heavy synthetic fragrances. We are 100% cruelty-free and committed to sustainable, eco-conscious packaging.</p>','About Lymko Skincare','Learn about Lymko natural skincare, Korean inspiration, and our clean beauty mission.',1,'2026-10-29 17:54:35'),(2,'Shipping Policy','shipping','<h2>Shipping Across India</h2><p>We are pleased to offer <b>Free Standard Shipping</b> on all orders across India, with no minimum purchase requirement.</p><p>Orders are dispatched from our fulfillment facility within 24-48 business hours. Typical delivery timelines range from 3 to 5 business days depending on your delivery postal pincode. Real-time SMS and email tracking links are provided once dispatched.</p>','Shipping Policy ÔÇö lymko.in','Free standard shipping across India on all Lymko orders.',1,'2026-10-29 17:54:35'),(3,'Returns & Refund Policy','returns','<h2>Hassle-Free 7-Day Returns</h2><p>We stand by the quality of our skincare formulations. If you receive a damaged, defective, or incorrect product, you are eligible for an immediate replacement or full refund within 7 days of delivery.</p><p>To initiate a return, reach out to our dedicated support team at <b>contact@lymko.in</b> or call <b>+91 88666 11621</b> with your order number and product photos.</p>','Return & Refund Policy ÔÇö lymko.in','Our 7-day return policy and refund guidelines.',1,'2026-10-29 17:54:35'),(4,'Privacy Policy','privacy','<h2>Your Privacy Matters</h2><p>This Privacy Policy explains how Lymko collects, uses, and safeguards your personal data when you browse our website or make a purchase. We use industry-standard SSL encryption and strict session controls. We never sell or share your personal data with third-party advertisers.</p>','Privacy Policy ÔÇö lymko.in','Read about our data protection and privacy policies.',1,'2026-10-29 17:54:35'),(5,'Terms and Conditions','terms','<h2>Terms of Service</h2><p>Welcome to Lymko. By accessing our website, browsing our catalog, or making a purchase, you agree to comply with our terms of service, payment procedures, and applicable laws in India.</p>','Terms of Service ÔÇö lymko.in','Lymko store terms of service and user agreements.',1,'2026-10-29 17:54:35'),(6,'Sustainability','sustainability','<h2>Every Drop a Ritual. Plant Your Tree.</h2><p>Our commitment to green beauty goes beyond packaging. For every ritual set purchased, Lymko plants a native sapling to help reforest rural India. We utilize recyclable glass containers and post-consumer recycled boxes for 100% eco-friendly fulfillment.</p>','Sustainability & Green Pledge ÔÇö lymko.in','Learn about Lymko eco-friendly packaging and tree plantation initiative.',1,'2026-10-29 17:54:35'),(7,'Ingredients Glossary','ingredients','<h2>Transparent Skin Science</h2><p>We believe you should know exactly what goes on your skin. Our key actives include <b>Vitamin C</b> (3-O-Ethyl Ascorbic Acid for gentle brightening), <b>Niacinamide 10%</b> (sebum regulation & pore refinement), <b>Sodium Hyaluronate</b> (multi-molecular deep hydration), and <b>Rice Water Ferment</b> (natural skin barrier nourishment).</p>','Ingredients Glossary ÔÇö lymko.in','A complete guide to ingredients and scientific benefits used in Lymko products.',1,'2026-10-29 17:54:35'),(8,'Skincare Guide','skincare-guide','<h2>Find Your Optimal Daily Routine</h2><p>Skincare works best when consistent and layered correctly. Always remember the golden rule: apply from thinnest to thickest texture (Cleanser &rarr; Toner &rarr; Serum &rarr; Moisturizer &rarr; Sunscreen).</p>','Skincare Guide & Journal ÔÇö lymko.in','Step-by-step skincare guide and expert tips for healthy, glowing skin.',1,'2026-10-29 17:54:35'),(9,'Frequently Asked Questions','faq','<div style=\"display:flex; flex-direction:column; gap:20px;\">\n  <div style=\"background:#fff; border:1px solid var(--line); border-radius:12px; padding:24px;\">\n    <h3 style=\"font-size:18px; margin:0 0 10px; color:var(--ink);\">How do I choose the right Nucelora serum for my skin concern?</h3>\n    <p style=\"margin:0; color:var(--ink2); line-height:1.6;\">We recommend taking our 60-second <a href=\"/projects/lymko/pages/routine-finder\" style=\"color:var(--or); font-weight:600;\">AI Routine Finder</a>. For dark spots and hyperpigmentation, choose our <b>20% Vitamin C Serum</b>. For acne, redness, and enlarged pores, our <b>10% Niacinamide + Zinc Serum</b> is optimal. For fine lines and skin renewal, our <b>Retinol Night Serum</b> is ideal.</p>\n  </div>\n  <div style=\"background:#fff; border:1px solid var(--line); border-radius:12px; padding:24px;\">\n    <h3 style=\"font-size:18px; margin:0 0 10px; color:var(--ink);\">Are all Nucelora formulas cruelty-free and dermatologically tested?</h3>\n    <p style=\"margin:0; color:var(--ink2); line-height:1.6;\">Yes, 100%. All Nucelora botanical formulations are certified cruelty-free, 100% vegan, and free from harmful parabens, sulphates, silicones, and artificial fragrances. Every formula undergoes rigorous dermatological safety testing on Indian skin types.</p>\n  </div>\n  <div style=\"background:#fff; border:1px solid var(--line); border-radius:12px; padding:24px;\">\n    <h3 style=\"font-size:18px; margin:0 0 10px; color:var(--ink);\">Can I use Vitamin C in the morning and Niacinamide or Retinol at night?</h3>\n    <p style=\"margin:0; color:var(--ink2); line-height:1.6;\">Absolutely! In fact, that is our recommended ritual. Apply 3-4 drops of Vitamin C Serum in the morning followed by broad-spectrum SPF 50 sunscreen. In the evening, cleanse thoroughly and apply Niacinamide or Retinol Serum followed by a nourishing barrier moisturizer.</p>\n  </div>\n  <div style=\"background:#fff; border:1px solid var(--line); border-radius:12px; padding:24px;\">\n    <h3 style=\"font-size:18px; margin:0 0 10px; color:var(--ink);\">What are the shipping charges and delivery timelines?</h3>\n    <p style=\"margin:0; color:var(--ink2); line-height:1.6;\">We provide <b>FREE Express Shipping across India</b> on all orders. Metro cities usually receive orders within 2 to 3 business days, while non-metro locations take 3 to 5 business days. You will receive an SMS and email with live courier tracking upon dispatch.</p>\n  </div>\n  <div style=\"background:#fff; border:1px solid var(--line); border-radius:12px; padding:24px;\">\n    <h3 style=\"font-size:18px; margin:0 0 10px; color:var(--ink);\">Do you offer Cash on Delivery (COD)?</h3>\n    <p style=\"margin:0; color:var(--ink2); line-height:1.6;\">Yes! Cash on Delivery is available across 99% of Indian pin codes. You can pay with cash or scan the courier partner\'s UPI QR code (Google Pay, PhonePe, Paytm) right at your doorstep.</p>\n  </div>\n  <div style=\"background:#fff; border:1px solid var(--line); border-radius:12px; padding:24px;\">\n    <h3 style=\"font-size:18px; margin:0 0 10px; color:var(--ink);\">What is your return and replacement policy?</h3>\n    <p style=\"margin:0; color:var(--ink2); line-height:1.6;\">We stand behind our skincare science with a 7-day hassle-free replacement guarantee for any damaged, leaked, or incorrect items received. Contact our customer care at <a href=\"mailto:care@nucelora.com\" style=\"color:var(--or); font-weight:600;\">care@nucelora.com</a> or WhatsApp us at +91 88666 11621.</p>\n  </div>\n</div>','Frequently Asked Questions (FAQ) — Nucelora Skincare','Find answers to common questions about Nucelora skincare formulations, ingredients, orders, shipping across India, and Cash on Delivery.',1,'2026-11-04 04:25:30');
/*!40000 ALTER TABLE `cms_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `is_resolved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_usage`
--

DROP TABLE IF EXISTS `coupon_usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_usage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `discount_applied` decimal(10,2) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `coupon_id` (`coupon_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `coupon_usage_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coupon_usage_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_usage`
--

LOCK TABLES `coupon_usage` WRITE;
/*!40000 ALTER TABLE `coupon_usage` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `usage_limit_total` int(11) DEFAULT NULL,
  `usage_limit_per_user` int(11) NOT NULL DEFAULT 1,
  `times_used` int(11) NOT NULL DEFAULT 0,
  `starts_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'WELCOME10','percentage',10.00,499.00,200.00,1000,1,0,NULL,NULL,1,'2026-10-29 17:54:35'),(2,'NUC50','fixed',50.00,399.00,50.00,500,1,0,NULL,NULL,1,'2026-10-29 17:54:35'),(3,'GLOW20','percentage',20.00,999.00,500.00,500,1,0,NULL,NULL,1,'2026-10-29 17:54:35'),(4,'NUCELORA50','fixed',50.00,399.00,NULL,NULL,1,0,NULL,NULL,1,'2026-11-04 04:29:24');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_addresses`
--

DROP TABLE IF EXISTS `customer_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `type` enum('shipping','billing','both') NOT NULL DEFAULT 'both',
  `full_name` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL DEFAULT 'India',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `customer_addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_addresses`
--

LOCK TABLES `customer_addresses` WRITE;
/*!40000 ALTER TABLE `customer_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active',
  `email_verified_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (2,'svsdfgdfgdf','','hhfghg@gmail.com','9773216606','$2y$10$wAlf2PbKF5mN54KQBlZt6OJ0trEu1ZgAGeeUoLEKTZ0iaHSntaQ9W','active',NULL,NULL,'2026-11-04 07:34:42','2026-11-04 07:34:42');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `homepage_sections`
--

DROP TABLE IF EXISTS `homepage_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `homepage_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content_json`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_key` (`section_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `homepage_sections`
--

LOCK TABLES `homepage_sections` WRITE;
/*!40000 ALTER TABLE `homepage_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `homepage_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_movements`
--

DROP TABLE IF EXISTS `inventory_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_movements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `variant_id` int(10) unsigned DEFAULT NULL,
  `quantity_change` int(11) NOT NULL,
  `movement_type` enum('purchase','sale','refund','adjustment','reservation') NOT NULL,
  `reference_id` varchar(100) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `inventory_movements_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_movements`
--

LOCK TABLES `inventory_movements` WRITE;
/*!40000 ALTER TABLE `inventory_movements` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned DEFAULT NULL,
  `variant_id` int(10) unsigned DEFAULT NULL,
  `product_title` varchar(255) NOT NULL,
  `variant_title` varchar(100) DEFAULT NULL,
  `sku` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,NULL,'Vitamin C Brightening Face Serum','30 ml','SKU-1',1,499.00,499.00),(2,2,1,NULL,'Vitamin C Brightening Face Serum','30 ml','SKU-1',1,499.00,499.00),(3,3,2,NULL,'Niacinamide Face Serum','30 ml','SKU-2',1,549.00,549.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status_history`
--

DROP TABLE IF EXISTS `order_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `status` varchar(50) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `notify_customer` tinyint(1) NOT NULL DEFAULT 0,
  `created_by_admin_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status_history`
--

LOCK TABLES `order_status_history` WRITE;
/*!40000 ALTER TABLE `order_status_history` DISABLE KEYS */;
INSERT INTO `order_status_history` VALUES (1,1,'pending','Order placed by customer',0,NULL,'2026-10-29 18:15:21'),(2,2,'pending','Order placed by customer',0,NULL,'2026-11-03 06:49:43'),(3,3,'pending','Order placed by customer',0,NULL,'2026-11-04 07:34:35');
/*!40000 ALTER TABLE `order_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `guest_email` varchar(150) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` enum('razorpay','cod') NOT NULL DEFAULT 'cod',
  `shipping_address_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`shipping_address_json`)),
  `billing_address_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`billing_address_json`)),
  `customer_notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `customer_id` (`customer_id`),
  KEY `idx_order_number` (`order_number`),
  KEY `idx_status` (`status`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'LYM-20261029-9F38',NULL,'testcustomer@example.com',499.00,0.00,0.00,0.00,499.00,NULL,'pending','pending','cod','{\"full_name\":\"Anjali Patel\",\"phone\":\"9876543210\",\"address_line1\":\"102 Green Heights, Ring Road\",\"address_line2\":\"Opposite City Center\",\"city\":\"Surat\",\"state\":\"Gujarat\",\"postal_code\":\"395007\",\"country\":\"India\"}','{\"full_name\":\"Anjali Patel\",\"phone\":\"9876543210\",\"address_line1\":\"102 Green Heights, Ring Road\",\"address_line2\":\"Opposite City Center\",\"city\":\"Surat\",\"state\":\"Gujarat\",\"postal_code\":\"395007\",\"country\":\"India\"}',NULL,NULL,'2026-10-29 18:15:21','2026-10-29 18:15:21'),(2,'LYM-20261103-E2F5',NULL,'test@nucelora.com',499.00,0.00,0.00,0.00,499.00,NULL,'pending','pending','cod','{\"full_name\":\"Test Customer\",\"phone\":\"9876543210\",\"address_line1\":\"123 Luxury Road\",\"address_line2\":\"Floor 4\",\"city\":\"Ahmedabad\",\"state\":\"Gujarat\",\"postal_code\":\"380015\",\"country\":\"India\"}','{\"full_name\":\"Test Customer\",\"phone\":\"9876543210\",\"address_line1\":\"123 Luxury Road\",\"address_line2\":\"Floor 4\",\"city\":\"Ahmedabad\",\"state\":\"Gujarat\",\"postal_code\":\"380015\",\"country\":\"India\"}',NULL,NULL,'2026-11-03 06:49:43','2026-11-03 06:49:43'),(3,'NUC-20261104-6CF8',2,'hhfghg@gmail.com',549.00,0.00,0.00,0.00,549.00,NULL,'pending','pending','cod','{\"full_name\":\"svsdfgdfgdf\",\"phone\":\"9773216606\",\"address_line1\":\"asdfasdfasdf\",\"address_line2\":\"\",\"city\":\"asdfsdf\",\"state\":\"asdfsdf\",\"postal_code\":\"963258\",\"country\":\"India\"}','{\"full_name\":\"svsdfgdfgdf\",\"phone\":\"9773216606\",\"address_line1\":\"asdfasdfasdf\",\"address_line2\":\"\",\"city\":\"asdfsdf\",\"state\":\"asdfsdf\",\"postal_code\":\"963258\",\"country\":\"India\"}',NULL,NULL,'2026-11-04 07:34:35','2026-11-04 07:34:42');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `gateway_order_id` varchar(100) DEFAULT NULL,
  `gateway_payment_id` varchar(100) DEFAULT NULL,
  `gateway_signature` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'INR',
  `status` enum('pending','successful','failed','refunded') NOT NULL DEFAULT 'pending',
  `response_payload` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'https://lymko.in/cdn/shop/files/01_00038bd1-1c41-476d-9bcc-3d3055e5027f.jpg','Vitamin C Brightening Face Serum',1,1,'2026-10-29 17:54:35'),(2,2,'https://lymko.in/cdn/shop/files/01_9ec9034e-b3cf-4b7d-9442-506c3696980c.jpg','Niacinamide Face Serum',1,1,'2026-10-29 17:54:35'),(3,3,'https://lymko.in/cdn/shop/files/01_876e3b91-9f67-43e1-89d2-cf84310fc5cb.jpg','Night Skin Face Serum',1,1,'2026-10-29 17:54:35'),(4,4,'https://lymko.in/cdn/shop/files/01_3e564c46-f72d-48aa-b9d6-ba3103fd3e3e.jpg','SPF 50 Sunscreen Spray',1,1,'2026-10-29 17:54:35'),(5,5,'https://lymko.in/cdn/shop/files/01_8f6862d0-b7fa-46e8-a8c5-6934f087fef9.jpg','Pigmentation Correcting Serum',1,1,'2026-10-29 17:54:35'),(6,6,'https://lymko.in/cdn/shop/files/01_0344e0e0-23c8-49a7-8be4-4fc8748f392f.jpg','Vitamin E Moisturizer with Sodium Hyaluronate &amp; Allantoin',1,1,'2026-10-29 17:54:35'),(7,7,'https://lymko.in/cdn/shop/files/01_b92ef97e-284e-478f-a622-6efb08ad80c4.jpg','Anti Acne Face Serum',1,1,'2026-10-29 17:54:35'),(8,8,'https://lymko.in/cdn/shop/files/01_605b3cb7-a035-4eb3-bfa9-b52d5a1a9579.jpg','Under Eye Face Serum',1,1,'2026-10-29 17:54:35'),(9,9,'https://lymko.in/cdn/shop/files/01_b723305c-9e81-4a49-a74f-15f1305382d1.jpg','Scalp Repair Shampoo',1,1,'2026-10-29 17:54:35'),(10,10,'https://lymko.in/cdn/shop/files/01.jpg','Niacinamide &amp; Rice Water Face Wash',1,1,'2026-10-29 17:54:35'),(11,11,'https://lymko.in/cdn/shop/files/01_86e740f4-3dfd-4105-a724-ab902c77ef98.jpg','Retinol Anti-Aging Serum',1,1,'2026-10-29 17:54:35'),(12,12,'https://lymko.in/cdn/shop/files/01_fb095240-ab1f-4997-95e9-bc9bd7a9a4e3.jpg','Hair Finishing Stick White',1,1,'2026-10-29 17:54:35'),(13,14,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1.webp','Daily Glow Ritual',1,1,'2026-10-29 17:54:35'),(14,15,'https://lymko.in/cdn/shop/files/lk-g-vitamin-c-brightening-face-serum-1_bfd0da0a-572c-4c40-85ce-dfff94c5591d.webp','Bright Skin Ritual',1,1,'2026-10-29 17:54:35'),(15,16,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_d470834e-fb94-4fbe-8724-1c604c414377.webp','Complete Skin Ritual',1,1,'2026-10-29 17:54:35'),(16,17,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_b306d75e-96a3-4dbb-b9c0-5bd6e863e825.webp','Acne Care Ritual',1,1,'2026-10-29 17:54:35'),(17,18,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_d48d2fd2-34ee-4c12-843b-ec09484f569d.webp','Oil Control Ritual',1,1,'2026-10-29 17:54:35'),(18,19,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_c948f968-62f6-49c6-bf1b-f9c59699cd5d.webp','Clear Skin Essentials',1,1,'2026-10-29 17:54:35'),(19,20,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_c50b22ba-27e8-4f7d-9740-c1c703368195.webp','Beginner Ritual',1,1,'2026-10-29 17:54:35'),(20,21,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_142ec8a6-7848-4ba8-bf32-ac4b49f31cf3.webp','Pigmentation Care Ritual',1,1,'2026-10-29 17:54:35'),(21,22,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_623b6712-eaee-43b2-a3e9-efedcc12d080.webp','Night Repair Ritual',1,1,'2026-10-29 17:54:35'),(22,23,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_cdd7d4e0-3fa4-46fe-a30c-6c11ed3723e0.webp','Age Defense Day &amp; Night',1,1,'2026-10-29 17:54:35'),(23,24,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_be4f43ac-d1bd-4276-bf0d-e31f9b30f3fa.webp','Hydration Ritual',1,1,'2026-10-29 17:54:35'),(24,25,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_5faf9c5a-1eb6-42e7-afd0-feccd2bba2dc.webp','Bright Eyes Ritual',1,1,'2026-10-29 17:54:35'),(25,26,'https://lymko.in/cdn/shop/files/lk-g-niacinamide-rice-water-face-wash-1_e0384aee-6f31-413d-921c-e3a63b49ab5c.webp','Signature Glow Ritual',1,1,'2026-10-29 17:54:35'),(26,27,'https://lymko.in/cdn/shop/files/lk-g-scalp-repair-shampoo-1.webp','Scalp &amp; Hair Ritual',1,1,'2026-10-29 17:54:35');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_ingredients`
--

DROP TABLE IF EXISTS `product_ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_ingredients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `percentage` varchar(50) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `is_key_ingredient` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_ingredients_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_ingredients`
--

LOCK TABLES `product_ingredients` WRITE;
/*!40000 ALTER TABLE `product_ingredients` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reviews`
--

DROP TABLE IF EXISTS `product_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `reviewer_name` varchar(100) NOT NULL,
  `reviewer_email` varchar(150) NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL DEFAULT 5,
  `title` varchar(150) DEFAULT NULL,
  `content` text NOT NULL,
  `is_verified_buyer` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reviews`
--

LOCK TABLES `product_reviews` WRITE;
/*!40000 ALTER TABLE `product_reviews` DISABLE KEYS */;
INSERT INTO `product_reviews` VALUES (1,1,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(2,1,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(3,2,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(4,2,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(5,3,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(6,3,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(7,4,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(8,4,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(9,5,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(10,5,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(11,6,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(12,6,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(13,7,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(14,7,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(15,8,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(16,8,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(17,9,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(18,9,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(19,10,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(20,10,NULL,'Rohan Mehta','rohan@example.com',5,'Worth every rupee','Very light texture, no strong fragrance, and delivered genuine results. Will definitely repurchase.',1,1,'2026-10-29 17:54:35'),(21,11,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(22,12,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(23,13,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(24,14,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(25,15,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(26,16,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(27,17,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(28,18,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(29,19,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(30,20,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(31,21,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(32,22,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(33,23,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(34,24,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(35,25,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(36,26,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35'),(37,27,NULL,'Pooja Sharma','pooja@example.com',5,'Highly recommend!','Noticeable improvement in skin texture within 2 weeks of daily use. Absorbs instantly without greasiness.',1,1,'2026-10-29 17:54:35');
/*!40000 ALTER TABLE `product_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 100,
  `options_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options_json`)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `directions` text DEFAULT NULL,
  `size_volume` varchar(50) DEFAULT '30 ml',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 100,
  `low_stock_threshold` int(11) NOT NULL DEFAULT 5,
  `badge_text` varchar(50) DEFAULT NULL,
  `skin_concern` varchar(100) DEFAULT NULL,
  `routine_step` enum('cleanse','treat','moisturize','protect') DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `sku` (`sku`),
  KEY `category_id` (`category_id`),
  KEY `idx_slug` (`slug`),
  KEY `idx_price` (`price`),
  KEY `idx_active` (`is_active`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Vitamin C Brightening Face Serum','vitamin-c-brightening-face-serum','LYM-1001','Experience visible skin radiance with Lymko Vitamin C Brightening Face Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Vitamin C Brightening Face Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',499.00,999.00,148,5,'Save 50%','pigmentation','treat',1,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-11-03 06:49:43'),(2,1,'Niacinamide Face Serum','niacinamide-face-serum','LYM-1002','Experience visible skin radiance with Lymko Niacinamide Face Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Niacinamide Face Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',549.00,999.00,149,5,'Save 45%','glow','treat',1,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-11-04 07:34:35'),(3,1,'Night Skin Face Serum','night-skin-face-serum','LYM-1003','Experience visible skin radiance with Lymko Night Skin Face Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Night Skin Face Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1399.00,1899.00,150,5,'Save 26%','anti-aging','treat',1,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(4,4,'SPF 50 Sunscreen Spray','spf-50-sunscreen-spray','LYM-1004','Experience visible skin radiance with Lymko SPF 50 Sunscreen Spray. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>SPF 50 Sunscreen Spray</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','50 ml',549.00,799.00,150,5,'Save 31%','glow','protect',1,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(5,1,'Pigmentation Correcting Serum','pigmentation-correcting-serum','LYM-1005','Experience visible skin radiance with Lymko Pigmentation Correcting Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Pigmentation Correcting Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1399.00,1899.00,150,5,'Save 26%','pigmentation','treat',1,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(6,3,'Vitamin E Moisturizer with Sodium Hyaluronate &amp; Allantoin','vitamin-e-moisturizer-with-sodium-hyaluronate-allantoin','LYM-1006','Experience visible skin radiance with Lymko Vitamin E Moisturizer with Sodium Hyaluronate &amp; Allantoin. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Vitamin E Moisturizer with Sodium Hyaluronate &amp; Allantoin</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','100 ml',499.00,649.00,150,5,'Save 23%','hydration','moisturize',1,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(7,1,'Anti Acne Face Serum','anti-acne-face-serum','LYM-1007','Experience visible skin radiance with Lymko Anti Acne Face Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Anti Acne Face Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1399.00,1899.00,150,5,'Save 26%','acne','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(8,1,'Under Eye Face Serum','under-eye-face-serum','LYM-1008','Experience visible skin radiance with Lymko Under Eye Face Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Under Eye Face Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1399.00,1899.00,150,5,'Save 26%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(9,5,'Scalp Repair Shampoo','scalp-repair-shampoo','LYM-1009','Experience visible skin radiance with Lymko Scalp Repair Shampoo. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Scalp Repair Shampoo</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','100 ml',399.00,499.00,150,5,'Save 20%','glow','cleanse',0,0,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(10,2,'Niacinamide &amp; Rice Water Face Wash','niacinamide-rice-water-face-wash','LYM-1010','Experience visible skin radiance with Lymko Niacinamide &amp; Rice Water Face Wash. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Niacinamide &amp; Rice Water Face Wash</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','100 ml',399.00,499.00,150,5,'Save 20%','glow','cleanse',0,0,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(11,1,'Retinol Anti-Aging Serum','retinol-anti-aging-serum','LYM-1011','Experience visible skin radiance with Lymko Retinol Anti-Aging Serum. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Retinol Anti-Aging Serum</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',599.00,1099.00,150,5,'Save 45%','anti-aging','treat',0,0,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(12,5,'Hair Finishing Stick White','hair-finishing-stick-white','LYM-1012','Experience visible skin radiance with Lymko Hair Finishing Stick White. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Hair Finishing Stick White</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','15 ml',399.00,590.00,150,5,'Save 32%','glow','treat',0,0,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(13,5,'hair-finishing-stick','hair-finishing-stick','LYM-1013','Experience visible skin radiance with Lymko hair-finishing-stick. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>hair-finishing-stick</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',499.00,999.00,150,5,'Save 50%','glow','treat',0,0,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(14,6,'Daily Glow Ritual','daily-glow-ritual','LYM-1014','Experience visible skin radiance with Lymko Daily Glow Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Daily Glow Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1299.00,2297.00,150,5,'Save 43%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(15,6,'Bright Skin Ritual','bright-skin-ritual','LYM-1015','Experience visible skin radiance with Lymko Bright Skin Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Bright Skin Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1444.00,2447.00,150,5,'Save 41%','pigmentation','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(16,6,'Complete Skin Ritual','complete-skin-ritual','LYM-1016','Experience visible skin radiance with Lymko Complete Skin Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Complete Skin Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1799.00,2946.00,150,5,'Save 39%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(17,6,'Acne Care Ritual','acne-care-ritual','LYM-1017','Experience visible skin radiance with Lymko Acne Care Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Acne Care Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1999.00,3197.00,150,5,'Save 37%','acne','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(18,6,'Oil Control Ritual','oil-control-ritual','LYM-1018','Experience visible skin radiance with Lymko Oil Control Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Oil Control Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1349.00,2148.00,150,5,'Save 37%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(19,6,'Clear Skin Essentials','clear-essentials-trio','LYM-1019','Experience visible skin radiance with Lymko Clear Skin Essentials. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Clear Skin Essentials</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1399.00,2297.00,150,5,'Save 39%','glow','treat',0,0,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(20,6,'Beginner Ritual','beginner-skincare-ritual','LYM-1020','Experience visible skin radiance with Lymko Beginner Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Beginner Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1799.00,2946.00,150,5,'Save 39%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(21,6,'Pigmentation Care Ritual','pigmentation-care-ritual','LYM-1021','Experience visible skin radiance with Lymko Pigmentation Care Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Pigmentation Care Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1999.00,3197.00,150,5,'Save 37%','pigmentation','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(22,6,'Night Repair Ritual','night-repair-ritual','LYM-1022','Experience visible skin radiance with Lymko Night Repair Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Night Repair Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1399.00,2248.00,150,5,'Save 38%','anti-aging','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(23,6,'Age Defense Day &amp; Night','age-defense-ritual','LYM-1023','Experience visible skin radiance with Lymko Age Defense Day &amp; Night. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Age Defense Day &amp; Night</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1849.00,3046.00,150,5,'Save 39%','anti-aging','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(24,6,'Hydration Ritual','hydration-ritual','LYM-1024','Experience visible skin radiance with Lymko Hydration Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Hydration Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1999.00,3048.00,150,5,'Save 34%','hydration','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(25,6,'Bright Eyes Ritual','bright-eyes-ritual','LYM-1025','Experience visible skin radiance with Lymko Bright Eyes Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Bright Eyes Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',1999.00,3048.00,150,5,'Save 34%','pigmentation','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(26,6,'Signature Glow Ritual','signature-glow-ritual','LYM-1026','Experience visible skin radiance with Lymko Signature Glow Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Signature Glow Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',2999.00,4845.00,150,5,'Save 38%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35'),(27,6,'Scalp &amp; Hair Ritual','scalp-hair-ritual','LYM-1027','Experience visible skin radiance with Lymko Scalp &amp; Hair Ritual. Lightweight, non-comedogenic, and suitable for all Indian skin types.','<p>Formulated with high-potency bio-actives and Korean skincare philosophy, the <b>Scalp &amp; Hair Ritual</b> delivers targeted efficacy while respecting the skin\'s moisture barrier.</p><ul><li>Promotes healthy cell turnover</li><li>Restores balanced hydration</li><li>Dermatologically tested and 100% cruelty-free</li></ul>','Hydrates deep layers ┬À Enhances skin luminosity ┬À Calms redness & inflammation ┬À Protects against free radicals','Apply 2-3 drops onto freshly cleansed face and neck. Gently pat until absorbed. Follow with moisturizer and daytime sunscreen.','30 ml',999.00,1679.00,150,5,'Save 41%','glow','treat',0,1,1,NULL,NULL,'2026-10-29 17:54:35','2026-10-29 17:54:35');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refunds`
--

DROP TABLE IF EXISTS `refunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refunds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `payment_id` int(10) unsigned DEFAULT NULL,
  `refund_amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `gateway_refund_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `refunds_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refunds`
--

LOCK TABLES `refunds` WRITE;
/*!40000 ALTER TABLE `refunds` DISABLE KEYS */;
/*!40000 ALTER TABLE `refunds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_permissions` (
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Administrator','super-admin','Full access to all system controls and settings','2026-10-29 17:54:35'),(2,'Store Manager','manager','Manage products, orders, customers, and CMS','2026-10-29 17:54:35');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `carrier_name` varchar(100) NOT NULL DEFAULT 'BlueDart / Delhivery',
  `tracking_number` varchar(100) NOT NULL,
  `tracking_url` varchar(255) DEFAULT NULL,
  `shipped_at` datetime DEFAULT NULL,
  `estimated_delivery` date DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `status` enum('manifested','in_transit','out_for_delivery','delivered','failed') NOT NULL DEFAULT 'manifested',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_settings`
--

DROP TABLE IF EXISTS `website_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(50) NOT NULL DEFAULT 'general',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_settings`
--

LOCK TABLES `website_settings` WRITE;
/*!40000 ALTER TABLE `website_settings` DISABLE KEYS */;
INSERT INTO `website_settings` VALUES (1,'site_name','lymko.in','general','Official Website Brand Name'),(2,'site_tagline','Natural Skincare & Daily Rituals','general','Header Tagline'),(3,'contact_email','contact@lymko.in','contact','Customer Support Email'),(4,'contact_phone','+918866611621','contact','Customer Helpline Phone'),(5,'contact_address','Surat, Gujarat, India - 395006','contact','Registered Office Address'),(6,'instagram_url','https://www.instagram.com/lymko.in','social','Instagram Profile Link'),(7,'free_shipping_threshold','0','shipping','Minimum cart total for free delivery (0 = Always Free)'),(8,'standard_shipping_fee','0','shipping','Standard Shipping Fee in INR'),(9,'currency_symbol','Ôé╣','currency','Display Currency Symbol'),(10,'currency_code','INR','currency','ISO Currency Code'),(11,'razorpay_key_id','rzp_test_1DP5mmOlF5G5ag','payment','Razorpay Test Key ID'),(12,'razorpay_key_secret','test_secret_key_lymko','payment','Razorpay Secret Key'),(13,'cod_enabled','1','payment','Allow Cash on Delivery Checkout (1=Yes, 0=No)');
/*!40000 ALTER TABLE `website_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_cust_prod` (`customer_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-04 13:59:03
