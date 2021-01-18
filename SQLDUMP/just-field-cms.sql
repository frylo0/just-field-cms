-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: localhost    Database: just-field-cms
-- ------------------------------------------------------
-- Server version	8.0.22-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `jf-cms_T_field`
--

DROP TABLE IF EXISTS `jf-cms_T_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_field` (
  `id_field` int NOT NULL AUTO_INCREMENT,
  `field_value` text NOT NULL,
  PRIMARY KEY (`id_field`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_field`
--

LOCK TABLES `jf-cms_T_field` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_field` DISABLE KEYS */;
INSERT INTO `jf-cms_T_field` VALUES (48,'Сайт психолога'),(49,'Ирены Беркуты'),(95,'О себе'),(106,'1'),(107,'О проекте'),(108,'0'),(109,'Консультации психолога'),(110,'1'),(111,'Мероприятия'),(112,'0'),(115,'Нумерология'),(116,'1'),(117,'Магазин шпаргалок'),(118,'0'),(119,'Блог'),(120,'1'),(124,'#'),(125,'Facebook'),(126,'#'),(127,'@inst.account'),(128,'#'),(129,'skypelogin'),(130,'79780000000'),(131,'email.email@email.email'),(132,'2021');
/*!40000 ALTER TABLE `jf-cms_T_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_T_image`
--

DROP TABLE IF EXISTS `jf-cms_T_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_image` (
  `id_image` int NOT NULL AUTO_INCREMENT,
  `image_src` varchar(20000) DEFAULT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_image`
--

LOCK TABLES `jf-cms_T_image` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_image` DISABLE KEYS */;
INSERT INTO `jf-cms_T_image` VALUES (16,'16.jpg'),(70,'70.jpg'),(71,'71.svg'),(72,'72.jpg'),(73,'73.svg'),(74,'74.jpg'),(75,'75.svg'),(76,'76.jpg'),(77,'77.svg'),(80,'80.jpg'),(81,'81.svg'),(82,'82.jpg'),(83,'83.svg'),(84,'84.jpg'),(85,'85.svg');
/*!40000 ALTER TABLE `jf-cms_T_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_T_text`
--

DROP TABLE IF EXISTS `jf-cms_T_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_text` (
  `id_text` int NOT NULL AUTO_INCREMENT,
  `text_value` int NOT NULL,
  PRIMARY KEY (`id_text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_text`
--

LOCK TABLES `jf-cms_T_text` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_text` DISABLE KEYS */;
/*!40000 ALTER TABLE `jf-cms_T_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_account`
--

DROP TABLE IF EXISTS `jf-cms_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_account` (
  `id_account` int NOT NULL AUTO_INCREMENT,
  `account_email` varchar(75) NOT NULL,
  `account_login` varchar(35) NOT NULL,
  `account_password` varchar(35) NOT NULL,
  PRIMARY KEY (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_account`
--

LOCK TABLES `jf-cms_account` WRITE;
/*!40000 ALTER TABLE `jf-cms_account` DISABLE KEYS */;
INSERT INTO `jf-cms_account` VALUES (1,'nikonovfedor36936@gmail.com','frity','6918c6cfd0dead1f0f0b4783949d8359'),(2,'','mart','25d55ad283aa400af464c76d713c07ad');
/*!40000 ALTER TABLE `jf-cms_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_db-access`
--

DROP TABLE IF EXISTS `jf-cms_db-access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_db-access` (
  `id_db-access` int NOT NULL AUTO_INCREMENT,
  `db-access_id_account` int NOT NULL,
  `db-access_id_db-item` int NOT NULL,
  PRIMARY KEY (`id_db-access`),
  KEY `db-access_id_account` (`db-access_id_account`,`db-access_id_db-item`),
  KEY `db-access_id_db-item` (`db-access_id_db-item`),
  CONSTRAINT `jf-cms_db-access_ibfk_1` FOREIGN KEY (`db-access_id_account`) REFERENCES `jf-cms_account` (`id_account`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jf-cms_db-access_ibfk_2` FOREIGN KEY (`db-access_id_db-item`) REFERENCES `jf-cms_db-item` (`id_db-item`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_db-access`
--

LOCK TABLES `jf-cms_db-access` WRITE;
/*!40000 ALTER TABLE `jf-cms_db-access` DISABLE KEYS */;
/*!40000 ALTER TABLE `jf-cms_db-access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_db-item`
--

DROP TABLE IF EXISTS `jf-cms_db-item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_db-item` (
  `id_db-item` int NOT NULL AUTO_INCREMENT,
  `db-item_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `db-item_name` varchar(255) NOT NULL,
  `db-item_value` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `db-item_value-type` int NOT NULL,
  `db-item_value-subtype` int DEFAULT NULL,
  `db-item_parent` int DEFAULT NULL,
  PRIMARY KEY (`id_db-item`),
  KEY `db-item_id_type` (`db-item_value-type`) USING BTREE,
  KEY `db-item_value-subtype` (`db-item_value-subtype`),
  KEY `db-item_parent` (`db-item_parent`),
  CONSTRAINT `jf-cms_db-item_ibfk_1` FOREIGN KEY (`db-item_value-type`) REFERENCES `jf-cms_type` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jf-cms_db-item_ibfk_2` FOREIGN KEY (`db-item_value-subtype`) REFERENCES `jf-cms_type` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `jf-cms_db-item_ibfk_3` FOREIGN KEY (`db-item_parent`) REFERENCES `jf-cms_db-item` (`id_db-item`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_db-item`
--

LOCK TABLES `jf-cms_db-item` WRITE;
/*!40000 ALTER TABLE `jf-cms_db-item` DISABLE KEYS */;
INSERT INTO `jf-cms_db-item` VALUES (1,'/','/','81,124',4,NULL,NULL),(81,'pages','Страницы','82',4,NULL,1),(82,'main','Главная','108,127,302,317',4,NULL,81),(108,'title','Заголовок','109,110',4,NULL,82),(109,'normal','Простая часть','48',1,NULL,108),(110,'shadow','Выделенная часть','49',1,NULL,108),(124,'logo','Логотип','16',3,NULL,1),(127,'sections','Секции','230,266,271,276,286,291,296',4,NULL,82),(230,'about-me','О себе','231,263,264,265',4,NULL,127),(231,'title','Заголовок','95',1,NULL,230),(263,'image','Картинка','70',3,NULL,230),(264,'icon','Фоновая иконка','71',3,NULL,230),(265,'is_image_right','Картинка справа?','106',1,NULL,230),(266,'about-project','О проекте','267,268,269,270',4,NULL,127),(267,'title','Заголовок','107',1,NULL,266),(268,'image','Картинка','72',3,NULL,266),(269,'icon','Фоновая иконка','73',3,NULL,266),(270,'is_image_right','Картинка справа?','108',1,NULL,266),(271,'consult','Консультации психолога','272,273,274,275',4,NULL,127),(272,'title','Заголовок','109',1,NULL,271),(273,'image','Картинка','74',3,NULL,271),(274,'icon','Фоновая иконка','75',3,NULL,271),(275,'is_image_right','Картинка справа?','110',1,NULL,271),(276,'events','Мероприятия','277,278,279,280',4,NULL,127),(277,'title','Заголовок','111',1,NULL,276),(278,'image','Картинка','76',3,NULL,276),(279,'icon','Фоновая иконка','77',3,NULL,276),(280,'is_image_right','Картинка справа?','112',1,NULL,276),(286,'numerology','Нумерология','287,288,289,290',4,NULL,127),(287,'title','Заголовок','115',1,NULL,286),(288,'image','Картинка','80',3,NULL,286),(289,'icon','Фоновая иконка','81',3,NULL,286),(290,'is_image_right','Картинка справа?','116',1,NULL,286),(291,'shop','Магазин шпаргалок','292,293,294,295',4,NULL,127),(292,'title','Заголовок','117',1,NULL,291),(293,'image','Картинка','82',3,NULL,291),(294,'icon','Фоновая иконка','83',3,NULL,291),(295,'is_image_right','Картинка справа?','118',1,NULL,291),(296,'blog','Блог','297,298,299,300',4,NULL,127),(297,'title','Заголовок','119',1,NULL,296),(298,'image','Картинка','84',3,NULL,296),(299,'icon','Фоновая иконка','85',3,NULL,296),(300,'is_image_right','Картинка справа?','120',1,NULL,296),(302,'contacts','Контакты','306,309,312,315,316',4,NULL,82),(306,'facebook','Фейсбук','307,308',4,NULL,302),(307,'link','Ссылка','124',1,NULL,306),(308,'title','Заголовок','125',1,NULL,306),(309,'inst','Инстаграм','310,311',4,NULL,302),(310,'link','Ссылка','126',1,NULL,309),(311,'title','Заголовок','127',1,NULL,309),(312,'skype','Скайп','313,314',4,NULL,302),(313,'link','Ссылка','128',1,NULL,312),(314,'title','Заголовок','129',1,NULL,312),(315,'phone','Телефон','130',1,NULL,302),(316,'email','Электронная почта','131',1,NULL,302),(317,'copywrite','Дата копирайта','132',1,NULL,82);
/*!40000 ALTER TABLE `jf-cms_db-item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_type`
--

DROP TABLE IF EXISTS `jf-cms_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_type` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `type_is-basic` tinyint(1) NOT NULL,
  `type_name` varchar(75) NOT NULL,
  `type_descr` json DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_type`
--

LOCK TABLES `jf-cms_type` WRITE;
/*!40000 ALTER TABLE `jf-cms_type` DISABLE KEYS */;
INSERT INTO `jf-cms_type` VALUES (1,1,'field','\"string\"'),(2,1,'text',NULL),(3,1,'image','{\"src\": \"string\", \"name\": \"string\"}'),(4,1,'object',NULL),(5,1,'list',NULL),(6,1,'space',NULL);
/*!40000 ALTER TABLE `jf-cms_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-19  1:57:45
