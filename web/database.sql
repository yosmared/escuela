CREATE DATABASE  IF NOT EXISTS `escuela` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `escuela`;
-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: escuela
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
-- Table structure for table `acl_classes`
--

DROP TABLE IF EXISTS `acl_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_classes`
--

LOCK TABLES `acl_classes` WRITE;
/*!40000 ALTER TABLE `acl_classes` DISABLE KEYS */;
INSERT INTO `acl_classes` VALUES (47,'Escuela\\CoreBundle\\Services\\EmployeeService'),(48,'Escuela\\CoreBundle\\Services\\InstituteService'),(46,'Escuela\\CoreBundle\\Services\\StudentService'),(44,'Escuela\\UserManagerBundle\\Services\\RolesService'),(45,'Escuela\\UserManagerBundle\\Services\\UserService');
/*!40000 ALTER TABLE `acl_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_entries`
--

DROP TABLE IF EXISTS `acl_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(10) unsigned NOT NULL,
  `object_identity_id` int(10) unsigned DEFAULT NULL,
  `security_identity_id` int(10) unsigned NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) unsigned NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  KEY `IDX_46C8B806EA000B10` (`class_id`),
  KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  KEY `IDX_46C8B806DF9183C9` (`security_identity_id`),
  CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_entries`
--

LOCK TABLES `acl_entries` WRITE;
/*!40000 ALTER TABLE `acl_entries` DISABLE KEYS */;
INSERT INTO `acl_entries` VALUES (44,44,NULL,14,NULL,0,128,1,'all',0,0),(45,45,NULL,14,NULL,0,128,1,'all',0,0),(46,46,NULL,14,NULL,1,128,1,'all',0,0),(47,47,NULL,14,NULL,1,128,1,'all',0,0),(48,48,NULL,14,NULL,1,128,1,'all',0,0),(49,46,NULL,15,NULL,0,128,1,'all',0,0),(50,47,NULL,15,NULL,0,128,1,'all',0,0),(51,48,NULL,15,NULL,0,128,1,'all',0,0);
/*!40000 ALTER TABLE `acl_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_object_identities`
--

DROP TABLE IF EXISTS `acl_object_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_object_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_object_identity_id` int(10) unsigned DEFAULT NULL,
  `class_id` int(10) unsigned NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`),
  CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_object_identities`
--

LOCK TABLES `acl_object_identities` WRITE;
/*!40000 ALTER TABLE `acl_object_identities` DISABLE KEYS */;
INSERT INTO `acl_object_identities` VALUES (44,NULL,44,'47',1),(45,NULL,45,'48',1),(46,NULL,46,'49',1),(47,NULL,47,'50',1),(48,NULL,48,'51',1);
/*!40000 ALTER TABLE `acl_object_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_object_identity_ancestors`
--

DROP TABLE IF EXISTS `acl_object_identity_ancestors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_object_identity_ancestors` (
  `object_identity_id` int(10) unsigned NOT NULL,
  `ancestor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  KEY `IDX_825DE299C671CEA1` (`ancestor_id`),
  CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_object_identity_ancestors`
--

LOCK TABLES `acl_object_identity_ancestors` WRITE;
/*!40000 ALTER TABLE `acl_object_identity_ancestors` DISABLE KEYS */;
INSERT INTO `acl_object_identity_ancestors` VALUES (44,44),(45,45),(46,46),(47,47),(48,48);
/*!40000 ALTER TABLE `acl_object_identity_ancestors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_security_identities`
--

DROP TABLE IF EXISTS `acl_security_identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_security_identities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_security_identities`
--

LOCK TABLES `acl_security_identities` WRITE;
/*!40000 ALTER TABLE `acl_security_identities` DISABLE KEYS */;
INSERT INTO `acl_security_identities` VALUES (14,'ROLE_ADMINISTRATOR',0),(15,'ROLE_DOCENTE',0);
/*!40000 ALTER TABLE `acl_security_identities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers_questionsecurity`
--

DROP TABLE IF EXISTS `answers_questionsecurity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers_questionsecurity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `qsid` int(11) DEFAULT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_77FD8EE3F132696E` (`userid`),
  KEY `IDX_77FD8EE35A90BB43` (`qsid`),
  CONSTRAINT `FK_77FD8EE35A90BB43` FOREIGN KEY (`qsid`) REFERENCES `questions_security` (`id`),
  CONSTRAINT `FK_77FD8EE3F132696E` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers_questionsecurity`
--

LOCK TABLES `answers_questionsecurity` WRITE;
/*!40000 ALTER TABLE `answers_questionsecurity` DISABLE KEYS */;
INSERT INTO `answers_questionsecurity` VALUES (14,14,57,'second'),(15,15,57,'prueba');
/*!40000 ALTER TABLE `answers_questionsecurity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_type_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `identification` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `director` tinyint(1) DEFAULT NULL,
  `grade_id` int(11) DEFAULT NULL,
  `institute_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_employee_type1_idx` (`employee_type_id`),
  KEY `fk_employee_grade1` (`grade_id`),
  KEY `fk_employee_institute1` (`institute_id`),
  CONSTRAINT `fk_employee_employee_type1` FOREIGN KEY (`employee_type_id`) REFERENCES `employee_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_institute1` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,28,'Janet','González','111111111','F',1,67,8);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_type`
--

DROP TABLE IF EXISTS `employee_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_type`
--

LOCK TABLES `employee_type` WRITE;
/*!40000 ALTER TABLE `employee_type` DISABLE KEYS */;
INSERT INTO `employee_type` VALUES (28,'Docente'),(29,'Administrativo'),(30,'Obrero');
/*!40000 ALTER TABLE `employee_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ext_log_entries`
--

DROP TABLE IF EXISTS `ext_log_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ext_log_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `logged_at` datetime NOT NULL,
  `object_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` int(11) NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_class_lookup_idx` (`object_class`),
  KEY `log_date_lookup_idx` (`logged_at`),
  KEY `log_user_lookup_idx` (`username`),
  KEY `log_version_lookup_idx` (`object_id`,`object_class`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ext_log_entries`
--

LOCK TABLES `ext_log_entries` WRITE;
/*!40000 ALTER TABLE `ext_log_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `ext_log_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ext_translations`
--

DROP TABLE IF EXISTS `ext_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ext_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lookup_unique_idx` (`locale`,`object_class`,`field`,`foreign_key`),
  KEY `translations_lookup_idx` (`locale`,`object_class`,`foreign_key`)
) ENGINE=InnoDB AUTO_INCREMENT=388 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ext_translations`
--

LOCK TABLES `ext_translations` WRITE;
/*!40000 ALTER TABLE `ext_translations` DISABLE KEYS */;
INSERT INTO `ext_translations` VALUES (353,'es_ES','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','57','¿Cuál es el segundo nombre de mi mamá?'),(354,'en_US','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','57','What is my mom\'s middle name?'),(355,'es_ES','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','58','¿Cuál es el nombre de mi primera mascota?'),(356,'en_US','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','58','What is the name of my first pet?'),(357,'es_ES','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','59','¿Que edad tiene mi hijo mayor?'),(358,'en_US','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','59','How old is my oldest son?'),(359,'es_ES','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','60','¿Fecha de nacimiento de su esposa?'),(360,'en_US','Escuela\\UserManagerBundle\\Entity\\QuestionSecurity','question','60','Your wife\'s date of birth?'),(361,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','47','Acceso'),(362,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','47','Gestión de Roles'),(363,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','47','Access'),(364,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','47','Roles Management'),(365,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','48','Acceso'),(366,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','48','Gestión de Usuarios'),(367,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','48','Access'),(368,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','48','User Management'),(369,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','49','Registros'),(370,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','49','Registro de Alumnos'),(371,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','49','Registros'),(372,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','49','Registro de Alumnos'),(373,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','50','Personal'),(374,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','50','Datos de empleados'),(375,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','50','Personal'),(376,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','50','Datos de empleados'),(377,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','51','Institución'),(378,'es_ES','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','51','Datos de la institución'),(379,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','modulename','51','Institución'),(380,'en_US','Escuela\\UserManagerBundle\\Entity\\ModuleClass','servicename','51','Datos de la institución'),(381,'es_ES','Escuela\\UserManagerBundle\\Entity\\Roles','name','15','Administrador'),(382,'es_ES','Escuela\\UserManagerBundle\\Entity\\Roles','description','15','Super Usuario'),(383,'en_US','Escuela\\UserManagerBundle\\Entity\\Roles','name','15','Administrator'),(384,'en_US','Escuela\\UserManagerBundle\\Entity\\Roles','description','15','Super User'),(385,'es_ES','Escuela\\UserManagerBundle\\Entity\\Roles','name','16','docente'),(386,'es_ES','Escuela\\UserManagerBundle\\Entity\\Roles','description','16',NULL),(387,'en_US','Escuela\\UserManagerBundle\\Entity\\Roles','name','16','docente');
/*!40000 ALTER TABLE `ext_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grade_section_idx` (`section_id`),
  CONSTRAINT `fk_grade_section` FOREIGN KEY (`section_id`) REFERENCES `section` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
INSERT INTO `grade` VALUES (67,28,'1º A'),(68,28,'2º A'),(69,28,'3º A'),(70,28,'4º A'),(71,28,'5º A'),(72,28,'6º A');
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institute`
--

DROP TABLE IF EXISTS `institute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_school` varchar(45) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `municipality` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `number_zone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institute`
--

LOCK TABLES `institute` WRITE;
/*!40000 ALTER TABLE `institute` DISABLE KEYS */;
INSERT INTO `institute` VALUES (8,'OD05070702','UNIDAD EDUCATIVA \"DR. MANUEL SALVADOR GOMEZ\"','Calle Mariscal Sucre, Barrio Simón Bolívar, Caicara del Orinoco','02846667339','CEDEÑO','BOLIVAR','02');
/*!40000 ALTER TABLE `institute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduleclass`
--

DROP TABLE IF EXISTS `moduleclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moduleclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `servicename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serviceclass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serviceid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduleclass`
--

LOCK TABLES `moduleclass` WRITE;
/*!40000 ALTER TABLE `moduleclass` DISABLE KEYS */;
INSERT INTO `moduleclass` VALUES (47,'Access','Roles Management','RolesService','escuela.usermanager.roles','roles_list',1),(48,'Access','User Management','UserService','escuela.usermanager.user','user_list',2),(49,'Registros','Registro de Alumnos','StudentService','escuela.core.student','student_list',3),(50,'Personal','Datos de empleados','EmployeeService','escuela.core.employee','employee_list',4),(51,'Institución','Datos de la institución','InstituteService','escuela.core.institute','institute_edit',5);
/*!40000 ALTER TABLE `moduleclass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `identification` int(11) NOT NULL,
  `nationality` varchar(45) NOT NULL,
  `birthdate` datetime NOT NULL,
  `address` text NOT NULL,
  `telephone` varchar(13) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `profession` varchar(45) DEFAULT NULL,
  `address_work` text,
  `alphabet` tinyint(1) DEFAULT NULL,
  `representant` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parents`
--

LOCK TABLES `parents` WRITE;
/*!40000 ALTER TABLE `parents` DISABLE KEYS */;
INSERT INTO `parents` VALUES (1,'José','Ramos',222222222,'VENEZOLANO','1968-01-01 00:00:00','caicara','0416958796','M','socio','ca',1,1);
/*!40000 ALTER TABLE `parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_security`
--

DROP TABLE IF EXISTS `questions_security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B7EF3764B6F7494E` (`question`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_security`
--

LOCK TABLES `questions_security` WRITE;
/*!40000 ALTER TABLE `questions_security` DISABLE KEYS */;
INSERT INTO `questions_security` VALUES (57,'What is my mom\'s middle name?',1),(58,'What is the name of my first pet?',1),(59,'How old is my oldest son?',1),(60,'Your wife\'s date of birth?',1);
/*!40000 ALTER TABLE `questions_security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(95) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC757698A6A` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (15,'Administrator','ROLE_ADMINISTRATOR','Super User',0),(16,'docente','ROLE_DOCENTE',NULL,0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_year`
--

DROP TABLE IF EXISTS `school_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(255) NOT NULL,
  `current` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=714 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_year`
--

LOCK TABLES `school_year` WRITE;
/*!40000 ALTER TABLE `school_year` DISABLE KEYS */;
INSERT INTO `school_year` VALUES (614,'2014',1),(615,'2015',0),(616,'2016',0),(617,'2017',0),(618,'2018',0),(619,'2019',0),(620,'2020',0),(621,'2021',0),(622,'2022',0),(623,'2023',0),(624,'2024',0),(625,'2025',0),(626,'2026',0),(627,'2027',0),(628,'2028',0),(629,'2029',0),(630,'2030',0),(631,'2031',0),(632,'2032',0),(633,'2033',0),(634,'2034',0),(635,'2035',0),(636,'2036',0),(637,'2037',0),(638,'2038',0),(639,'2039',0),(640,'2040',0),(641,'2041',0),(642,'2042',0),(643,'2043',0),(644,'2044',0),(645,'2045',0),(646,'2046',0),(647,'2047',0),(648,'2048',0),(649,'2049',0),(650,'2050',0),(651,'2051',0),(652,'2052',0),(653,'2053',0),(654,'2054',0),(655,'2055',0),(656,'2056',0),(657,'2057',0),(658,'2058',0),(659,'2059',0),(660,'2060',0),(661,'2061',0),(662,'2062',0),(663,'2063',0),(664,'2064',0),(665,'2065',0),(666,'2066',0),(667,'2067',0),(668,'2068',0),(669,'2069',0),(670,'2070',0),(671,'2071',0),(672,'2072',0),(673,'2073',0),(674,'2074',0),(675,'2075',0),(676,'2076',0),(677,'2077',0),(678,'2078',0),(679,'2079',0),(680,'2080',0),(681,'2081',0),(682,'2082',0),(683,'2083',0),(684,'2084',0),(685,'2085',0),(686,'2086',0),(687,'2087',0),(688,'2088',0),(689,'2089',0),(690,'2090',0),(691,'2091',0),(692,'2092',0),(693,'2093',0),(694,'2094',0),(695,'2095',0),(696,'2096',0),(697,'2097',0),(698,'2098',0),(699,'2099',0),(700,'2100',0),(701,'2101',0),(702,'2102',0),(703,'2103',0),(704,'2104',0),(705,'2105',0),(706,'2106',0),(707,'2107',0),(708,'2108',0),(709,'2109',0),(710,'2110',0),(711,'2111',0),(712,'2112',0),(713,'2113',0);
/*!40000 ALTER TABLE `school_year` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `score`
--

DROP TABLE IF EXISTS `score`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `score` (
  `stage_one` varchar(1) DEFAULT NULL,
  `stage_two` varchar(1) DEFAULT NULL,
  `stage_three` varchar(1) DEFAULT NULL,
  `score_final` varchar(1) DEFAULT NULL,
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `school_year_id` int(11) NOT NULL,
  PRIMARY KEY (`grade_id`,`student_id`,`school_year_id`),
  KEY `fk_score_grade1` (`grade_id`),
  KEY `fk_score_student1` (`student_id`),
  KEY `fk_score_school_year1_idx` (`school_year_id`),
  CONSTRAINT `fk_score_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_score_school_year1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_score_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `score`
--

LOCK TABLES `score` WRITE;
/*!40000 ALTER TABLE `score` DISABLE KEYS */;
INSERT INTO `score` VALUES ('C','A','B','B',67,1,614);
/*!40000 ALTER TABLE `score` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (26,'A'),(27,'A'),(28,'A');
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `identification` int(11) NOT NULL,
  `city_birth` varchar(45) NOT NULL,
  `birthdate` datetime NOT NULL,
  `address` longtext,
  `createAt` datetime NOT NULL,
  `telephone` varchar(13) DEFAULT NULL,
  `school_origin` varchar(45) DEFAULT NULL,
  `viruela` tinyint(1) DEFAULT NULL,
  `polio` tinyint(1) DEFAULT NULL,
  `tifus` tinyint(1) DEFAULT NULL,
  `tetano` tinyint(1) DEFAULT NULL,
  `sarampion` tinyint(1) DEFAULT NULL,
  `disease` tinyint(1) DEFAULT NULL,
  `explain` text,
  `gender` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'Ana','Garcia',2147483647,'San Antonio','2008-06-25 00:00:00',NULL,'2009-01-01 00:00:00',NULL,NULL,0,0,0,0,0,0,NULL,'F');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_grade`
--

DROP TABLE IF EXISTS `student_has_grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_grade` (
  `student_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`grade_id`),
  KEY `fk_student_has_grade_grade1_idx` (`grade_id`),
  KEY `fk_student_has_grade_student1_idx` (`student_id`),
  CONSTRAINT `fk_student_has_grade_grade1` FOREIGN KEY (`grade_id`) REFERENCES `grade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_has_grade_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_grade`
--

LOCK TABLES `student_has_grade` WRITE;
/*!40000 ALTER TABLE `student_has_grade` DISABLE KEYS */;
INSERT INTO `student_has_grade` VALUES (1,67);
/*!40000 ALTER TABLE `student_has_grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_has_parents`
--

DROP TABLE IF EXISTS `student_has_parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_has_parents` (
  `student_id` int(11) NOT NULL,
  `parents_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`parents_id`),
  KEY `fk_student_has_parents_parents1_idx` (`parents_id`),
  KEY `fk_student_has_parents_student1_idx` (`student_id`),
  CONSTRAINT `fk_student_has_parents_parents1` FOREIGN KEY (`parents_id`) REFERENCES `parents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_has_parents_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_has_parents`
--

LOCK TABLES `student_has_parents` WRITE;
/*!40000 ALTER TABLE `student_has_parents` DISABLE KEYS */;
INSERT INTO `student_has_parents` VALUES (1,1);
/*!40000 ALTER TABLE `student_has_parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionsecurity_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identification_card` int(11) NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone_celular` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649FF817607` (`identification_card`),
  KEY `IDX_8D93D64969212DE4` (`questionsecurity_id`),
  CONSTRAINT `FK_8D93D64969212DE4` FOREIGN KEY (`questionsecurity_id`) REFERENCES `questions_security` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (14,57,'admin','fhHtkf4o0I+ZnmUc9c73F9SmNLsGTsak2Wf+5UC1dY5Avex6x/kYGrKtZk4MaDuK2J2ZOQ0pNcDfz/aicbINsw==','8im09uq06zggks0g8gsgwsw08gsc0ws',1,'admin@softodonto.net','Super','Admin',111111111,NULL,NULL,NULL,0),(15,57,'prueba','17YW5lejNB/619VY1zg4zbpAeJtdhki98Xg8JyXVEz7G1aStoDCh9h4XU5jKA/9kzEER3Ndqi2NQi4b/pUllKA==','frgseu6e8kgk04w0ggwcogw4000k8oo',1,'prueba@prueba.com','Prueba','Principal',17856945,NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `userid` int(11) NOT NULL,
  `rolesid` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`rolesid`),
  KEY `IDX_51498A8EF132696E` (`userid`),
  KEY `IDX_51498A8EE7549D28` (`rolesid`),
  CONSTRAINT `FK_51498A8EE7549D28` FOREIGN KEY (`rolesid`) REFERENCES `roles` (`id`),
  CONSTRAINT `FK_51498A8EF132696E` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (14,15),(15,16);
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-30 14:15:48
