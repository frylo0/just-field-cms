-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: just-field-cms
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

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
-- Table structure for table `jf-cms_T_audio`
--

DROP TABLE IF EXISTS `jf-cms_T_audio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_audio` (
  `id_audio` int NOT NULL AUTO_INCREMENT,
  `audio_src` text NOT NULL,
  PRIMARY KEY (`id_audio`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_audio`
--

LOCK TABLES `jf-cms_T_audio` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_audio` DISABLE KEYS */;
INSERT INTO `jf-cms_T_audio` VALUES (9,'a9.mp3');
/*!40000 ALTER TABLE `jf-cms_T_audio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_T_boolean`
--

DROP TABLE IF EXISTS `jf-cms_T_boolean`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_boolean` (
  `id_boolean` int NOT NULL AUTO_INCREMENT,
  `boolean_value` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_boolean`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_boolean`
--

LOCK TABLES `jf-cms_T_boolean` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_boolean` DISABLE KEYS */;
INSERT INTO `jf-cms_T_boolean` VALUES (15,1);
/*!40000 ALTER TABLE `jf-cms_T_boolean` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb3;
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
-- Table structure for table `jf-cms_T_file`
--

DROP TABLE IF EXISTS `jf-cms_T_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_file` (
  `id_file` int NOT NULL AUTO_INCREMENT,
  `file_src` text NOT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_file`
--

LOCK TABLES `jf-cms_T_file` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `jf-cms_T_file` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_image`
--

LOCK TABLES `jf-cms_T_image` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_image` DISABLE KEYS */;
INSERT INTO `jf-cms_T_image` VALUES (16,'16.png'),(70,'70.jpg'),(71,'71.svg'),(72,'72.jpg'),(73,'73.svg'),(74,'74.jpg'),(75,'75.svg'),(76,'76.jpg'),(77,'77.svg'),(80,'80.jpg'),(81,'81.svg'),(82,'82.jpg'),(83,'83.svg'),(84,'84.jpg'),(85,'85.svg');
/*!40000 ALTER TABLE `jf-cms_T_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_T_space`
--

DROP TABLE IF EXISTS `jf-cms_T_space`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_space` (
  `id_space` int NOT NULL AUTO_INCREMENT,
  `space_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_space`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_space`
--

LOCK TABLES `jf-cms_T_space` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_space` DISABLE KEYS */;
INSERT INTO `jf-cms_T_space` VALUES (15,'Длинный, не читаемый, комментарий, но очень полезный, в приницпе');
/*!40000 ALTER TABLE `jf-cms_T_space` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_T_text`
--

DROP TABLE IF EXISTS `jf-cms_T_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_text` (
  `id_text` int NOT NULL AUTO_INCREMENT,
  `text_value` text NOT NULL,
  `text_html` text NOT NULL,
  PRIMARY KEY (`id_text`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_text`
--

LOCK TABLES `jf-cms_T_text` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_text` DISABLE KEYS */;
INSERT INTO `jf-cms_T_text` VALUES (23,'{&quot;time&quot;:1641140793621,&quot;blocks&quot;:[{&quot;id&quot;:&quot;PiY2L9Hm0p&quot;,&quot;type&quot;:&quot;header&quot;,&quot;data&quot;:{&quot;text&quot;:&quot;\\u0414\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430\\u0446\\u0438\\u044f&quot;,&quot;level&quot;:3,&quot;anchor&quot;:&quot;&quot;},&quot;tunes&quot;:{&quot;alignment&quot;:{&quot;alignment&quot;:&quot;left&quot;}}},{&quot;id&quot;:&quot;apo0cPHf_4&quot;,&quot;type&quot;:&quot;image&quot;,&quot;data&quot;:{&quot;file&quot;:{&quot;url&quot;:&quot;http:\\/\\/localhost\\/just-field\\/dist\\/__assets\\/T_text\\/23\\/apo0cPHf_4.png&quot;},&quot;caption&quot;:&quot;\\u041f\\u043e \\u0432\\u0441\\u0442\\u0430\\u0432\\u043a\\u0435&quot;,&quot;withBorder&quot;:false,&quot;stretched&quot;:false,&quot;withBackground&quot;:false}},{&quot;id&quot;:&quot;AiqJDv4wvx&quot;,&quot;type&quot;:&quot;image&quot;,&quot;data&quot;:{&quot;file&quot;:{&quot;url&quot;:&quot;https:\\/\\/images.google.com\\/images\\/branding\\/googlelogo\\/1x\\/googlelogo_light_color_272x92dp.png&quot;},&quot;caption&quot;:&quot;\\u041f\\u043e \\u0441\\u0441\\u044b\\u043b\\u043a\\u0435&quot;,&quot;withBorder&quot;:false,&quot;stretched&quot;:false,&quot;withBackground&quot;:false}}],&quot;version&quot;:&quot;2.22.2&quot;}','<h3 style=\"text-align: left\" id=\"\">Документация</h3>\n            <figure>\n               <img \n                  src=\"http://localhost/just-field/dist/__assets/T_text/23/apo0cPHf_4.png\" \n                  width=\"\"\n                  data-with-border=\"false\"\n                  data-with-background=\"false\" />\n               <figcaption>По вставке</figcaption>\n            </figure>\n            \n            <figure>\n               <img \n                  src=\"https://images.google.com/images/branding/googlelogo/1x/googlelogo_light_color_272x92dp.png\" \n                  width=\"\"\n                  data-with-border=\"false\"\n                  data-with-background=\"false\" />\n               <figcaption>По ссылке</figcaption>\n            </figure>\n            ');
/*!40000 ALTER TABLE `jf-cms_T_text` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jf-cms_T_video`
--

DROP TABLE IF EXISTS `jf-cms_T_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jf-cms_T_video` (
  `id_video` int NOT NULL AUTO_INCREMENT,
  `video_src` text NOT NULL,
  PRIMARY KEY (`id_video`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_T_video`
--

LOCK TABLES `jf-cms_T_video` WRITE;
/*!40000 ALTER TABLE `jf-cms_T_video` DISABLE KEYS */;
INSERT INTO `jf-cms_T_video` VALUES (1,'v1.mp4');
/*!40000 ALTER TABLE `jf-cms_T_video` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
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
) ENGINE=InnoDB AUTO_INCREMENT=602 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_db-item`
--

LOCK TABLES `jf-cms_db-item` WRITE;
/*!40000 ALTER TABLE `jf-cms_db-item` DISABLE KEYS */;
INSERT INTO `jf-cms_db-item` VALUES (1,'/','/','81,124,519,561,576,588,589',4,NULL,NULL),(81,'pages','Страницы','82',4,NULL,1),(82,'main','Главная','108,127,302,317',4,NULL,81),(108,'title','Заголовок','109,110',4,NULL,82),(109,'normal','Простая часть','48',1,NULL,108),(110,'shadow','Выделенная часть','49',1,NULL,108),(124,'logo','Логотип','16',3,NULL,1),(127,'sections','Секции','230,266,271,276,286,291,296',4,NULL,82),(230,'about-me','О себе','231,263,264,265',4,NULL,127),(231,'title','Заголовок','95',1,NULL,230),(263,'image','Картинка','70',3,NULL,230),(264,'icon','Фоновая иконка','71',3,NULL,230),(265,'is_image_right','Картинка справа?','106',1,NULL,230),(266,'about-project','О проекте','267,268,269,270',4,NULL,127),(267,'title','Заголовок','107',1,NULL,266),(268,'image','Картинка','72',3,NULL,266),(269,'icon','Фоновая иконка','73',3,NULL,266),(270,'is_image_right','Картинка справа?','108',1,NULL,266),(271,'consult','Консультации психолога','272,273,274,275',4,NULL,127),(272,'title','Заголовок','109',1,NULL,271),(273,'image','Картинка','74',3,NULL,271),(274,'icon','Фоновая иконка','75',3,NULL,271),(275,'is_image_right','Картинка справа?','110',1,NULL,271),(276,'events','Мероприятия','277,278,279,280',4,NULL,127),(277,'title','Заголовок','111',1,NULL,276),(278,'image','Картинка','76',3,NULL,276),(279,'icon','Фоновая иконка','77',3,NULL,276),(280,'is_image_right','Картинка справа?','112',1,NULL,276),(286,'numerology','Нумерология','287,288,289,290',4,NULL,127),(287,'title','Заголовок','115',1,NULL,286),(288,'image','Картинка','80',3,NULL,286),(289,'icon','Фоновая иконка','81',3,NULL,286),(290,'is_image_right','Картинка справа?','116',1,NULL,286),(291,'shop','Магазин шпаргалок','292,293,294,295',4,NULL,127),(292,'title','Заголовок','117',1,NULL,291),(293,'image','Картинка','82',3,NULL,291),(294,'icon','Фоновая иконка','83',3,NULL,291),(295,'is_image_right','Картинка справа?','118',1,NULL,291),(296,'blog','Блог','297,298,299,300',4,NULL,127),(297,'title','Заголовок','119',1,NULL,296),(298,'image','Картинка','84',3,NULL,296),(299,'icon','Фоновая иконка','85',3,NULL,296),(300,'is_image_right','Картинка справа?','120',1,NULL,296),(302,'contacts','Контакты','306,309,312,315,316',4,NULL,82),(306,'facebook','Фейсбук','307,308',4,NULL,302),(307,'link','Ссылка','124',1,NULL,306),(308,'title','Заголовок','125',1,NULL,306),(309,'inst','Инстаграм','310,311',4,NULL,302),(310,'link','Ссылка','126',1,NULL,309),(311,'title','Заголовок','127',1,NULL,309),(312,'skype','Скайп','313,314',4,NULL,302),(313,'link','Ссылка','128',1,NULL,312),(314,'title','Заголовок','129',1,NULL,312),(315,'phone','Телефон','130',1,NULL,302),(316,'email','Электронная почта','131',1,NULL,302),(317,'copywrite','Дата копирайта','132',1,NULL,82),(519,'docs','Документация','23',2,NULL,1),(561,'is_docs_visible','Показывать документацию?','15',7,NULL,1),(576,NULL,'','15',6,NULL,1),(588,'scorpions','Here I am','9',9,NULL,1),(589,'haha','Смех в троллейбусе','1',10,NULL,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jf-cms_type`
--

LOCK TABLES `jf-cms_type` WRITE;
/*!40000 ALTER TABLE `jf-cms_type` DISABLE KEYS */;
INSERT INTO `jf-cms_type` VALUES (1,1,'field','\"string\"'),(2,1,'text','{\"html\": \"string\", \"value\": \"string\"}'),(3,1,'image','{\"src\": \"string\", \"name\": \"string\"}'),(4,1,'object',NULL),(5,1,'list',NULL),(6,1,'space','\"string\"'),(7,1,'boolean','\"int\"'),(8,1,'file','{\"src\": \"string\", \"name\": \"string\"}'),(9,1,'audio','{\"src\": \"string\", \"name\": \"string\"}'),(10,1,'video','{\"src\": \"string\", \"name\": \"string\"}');
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

-- Dump completed on 2022-01-04 14:14:43
