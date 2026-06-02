-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: project
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
-- Table structure for table `addon_subscriptions`
--

DROP TABLE IF EXISTS `addon_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addon_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `feature_id` bigint(20) unsigned NOT NULL,
  `price` decimal(64,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 => Discontinue next billing, 1 => Continue',
  `payment_transaction_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addon_subscriptions_school_id_foreign` (`school_id`),
  KEY `addon_subscriptions_feature_id_foreign` (`feature_id`),
  KEY `addon_subscriptions_subscription_id_foreign` (`subscription_id`),
  KEY `addon_subscriptions_payment_transaction_id_foreign` (`payment_transaction_id`),
  CONSTRAINT `addon_subscriptions_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `addon_subscriptions_payment_transaction_id_foreign` FOREIGN KEY (`payment_transaction_id`) REFERENCES `payment_transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `addon_subscriptions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `addon_subscriptions_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addon_subscriptions`
--

LOCK TABLES `addon_subscriptions` WRITE;
/*!40000 ALTER TABLE `addon_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `addon_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `addons`
--

DROP TABLE IF EXISTS `addons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `price` decimal(64,2) NOT NULL,
  `feature_id` bigint(20) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => Inactive, 1 => Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `addons_feature_id_unique` (`feature_id`),
  CONSTRAINT `addons_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addons`
--

LOCK TABLES `addons` WRITE;
/*!40000 ALTER TABLE `addons` DISABLE KEYS */;
INSERT INTO `addons` VALUES (1,'fee',10.00,16,1,'2025-12-12 23:05:08','2025-12-12 23:05:56',NULL),(2,'Announce Management',100.00,12,0,'2025-12-20 12:27:14','2025-12-20 12:27:14',NULL),(3,'Timetable add on',200.00,7,0,'2025-12-20 12:30:12','2025-12-20 12:30:12',NULL),(4,'Pro Exclusive',200.00,9,0,'2025-12-20 12:39:42','2025-12-20 12:39:42',NULL),(5,'Assignment management',5000.00,11,0,'2026-01-11 23:43:47','2026-01-11 23:43:47',NULL);
/*!40000 ALTER TABLE `addons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcement_classes`
--

DROP TABLE IF EXISTS `announcement_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcement_classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `announcement_id` bigint(20) unsigned DEFAULT NULL,
  `class_section_id` bigint(20) unsigned DEFAULT NULL,
  `class_subject_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcement_classes_announcement_id_foreign` (`announcement_id`),
  KEY `announcement_classes_class_section_id_foreign` (`class_section_id`),
  CONSTRAINT `announcement_classes_announcement_id_foreign` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `announcement_classes_class_section_id_foreign` FOREIGN KEY (`class_section_id`) REFERENCES `class_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcement_classes`
--

LOCK TABLES `announcement_classes` WRITE;
/*!40000 ALTER TABLE `announcement_classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcement_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `description` longtext DEFAULT NULL,
  `session_year_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_session_year_id_foreign` (`session_year_id`),
  KEY `announcements_school_id_foreign` (`school_id`),
  CONSTRAINT `announcements_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `announcements_session_year_id_foreign` FOREIGN KEY (`session_year_id`) REFERENCES `session_years` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_groups`
--

DROP TABLE IF EXISTS `class_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_groups_school_id_foreign` (`school_id`),
  CONSTRAINT `class_groups_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_groups`
--

LOCK TABLES `class_groups` WRITE;
/*!40000 ALTER TABLE `class_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_sections`
--

DROP TABLE IF EXISTS `class_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint(20) unsigned NOT NULL,
  `section_id` bigint(20) unsigned NOT NULL,
  `medium_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`class_id`,`section_id`,`medium_id`),
  KEY `class_sections_section_id_foreign` (`section_id`),
  KEY `class_sections_medium_id_foreign` (`medium_id`),
  KEY `class_sections_school_id_foreign` (`school_id`),
  CONSTRAINT `class_sections_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_sections_medium_id_foreign` FOREIGN KEY (`medium_id`) REFERENCES `mediums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_sections`
--

LOCK TABLES `class_sections` WRITE;
/*!40000 ALTER TABLE `class_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_subjects`
--

DROP TABLE IF EXISTS `class_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` bigint(20) unsigned NOT NULL,
  `subject_id` bigint(20) unsigned NOT NULL,
  `type` varchar(32) NOT NULL COMMENT 'Compulsory / Elective',
  `elective_subject_group_id` bigint(20) unsigned DEFAULT NULL COMMENT 'if type=Elective',
  `semester_id` bigint(20) unsigned DEFAULT NULL,
  `virtual_semester_id` int(11) GENERATED ALWAYS AS (case when `semester_id` is not null then `semester_id` else 0 end) VIRTUAL,
  `school_id` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_ids` (`class_id`,`subject_id`,`virtual_semester_id`),
  KEY `class_subjects_subject_id_foreign` (`subject_id`),
  KEY `class_subjects_elective_subject_group_id_foreign` (`elective_subject_group_id`),
  KEY `class_subjects_semester_id_foreign` (`semester_id`),
  KEY `class_subjects_school_id_foreign` (`school_id`),
  CONSTRAINT `class_subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_subjects_elective_subject_group_id_foreign` FOREIGN KEY (`elective_subject_group_id`) REFERENCES `elective_subject_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_subjects_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_subjects`
--

LOCK TABLES `class_subjects` WRITE;
/*!40000 ALTER TABLE `class_subjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `include_semesters` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 - no 1 - yes',
  `medium_id` bigint(20) unsigned NOT NULL,
  `shift_id` bigint(20) unsigned DEFAULT NULL,
  `stream_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_medium_id_foreign` (`medium_id`),
  KEY `classes_shift_id_foreign` (`shift_id`),
  KEY `classes_stream_id_foreign` (`stream_id`),
  KEY `classes_school_id_foreign` (`school_id`),
  CONSTRAINT `classes_medium_id_foreign` FOREIGN KEY (`medium_id`) REFERENCES `mediums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classes_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `classes_stream_id_foreign` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_inquiry`
--

DROP TABLE IF EXISTS `contact_inquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_inquiry` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `message` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_inquiry`
--

LOCK TABLES `contact_inquiry` WRITE;
/*!40000 ALTER TABLE `contact_inquiry` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_inquiry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elective_subject_groups`
--

DROP TABLE IF EXISTS `elective_subject_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elective_subject_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `total_subjects` int(11) NOT NULL,
  `total_selectable_subjects` int(11) NOT NULL,
  `class_id` bigint(20) unsigned NOT NULL,
  `semester_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `elective_subject_groups_class_id_foreign` (`class_id`),
  KEY `elective_subject_groups_semester_id_foreign` (`semester_id`),
  KEY `elective_subject_groups_school_id_foreign` (`school_id`),
  CONSTRAINT `elective_subject_groups_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `elective_subject_groups_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `elective_subject_groups_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elective_subject_groups`
--

LOCK TABLES `elective_subject_groups` WRITE;
/*!40000 ALTER TABLE `elective_subject_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `elective_subject_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extra_school_datas`
--

DROP TABLE IF EXISTS `extra_school_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extra_school_datas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_inquiry_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `form_field_id` bigint(20) unsigned NOT NULL,
  `data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `extra_school_datas_school_inquiry_id_foreign` (`school_inquiry_id`),
  KEY `extra_school_datas_school_id_foreign` (`school_id`),
  KEY `extra_school_datas_form_field_id_foreign` (`form_field_id`),
  CONSTRAINT `extra_school_datas_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`) ON DELETE CASCADE,
  CONSTRAINT `extra_school_datas_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `extra_school_datas_school_inquiry_id_foreign` FOREIGN KEY (`school_inquiry_id`) REFERENCES `school_inquiries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extra_school_datas`
--

LOCK TABLES `extra_school_datas` WRITE;
/*!40000 ALTER TABLE `extra_school_datas` DISABLE KEYS */;
INSERT INTO `extra_school_datas` VALUES (1,NULL,2,1,NULL,'2025-12-10 19:26:30','2025-12-10 19:26:30',NULL),(2,NULL,3,1,NULL,'2025-12-10 19:36:17','2025-12-10 19:36:17',NULL),(3,NULL,4,1,NULL,'2025-12-10 19:59:59','2025-12-10 19:59:59',NULL);
/*!40000 ALTER TABLE `extra_school_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_school_id_foreign` (`school_id`),
  CONSTRAINT `faqs_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feature_section_lists`
--

DROP TABLE IF EXISTS `feature_section_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feature_section_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feature_section_id` bigint(20) unsigned NOT NULL,
  `feature` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_section_lists_feature_section_id_foreign` (`feature_section_id`),
  CONSTRAINT `feature_section_lists_feature_section_id_foreign` FOREIGN KEY (`feature_section_id`) REFERENCES `feature_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feature_section_lists`
--

LOCK TABLES `feature_section_lists` WRITE;
/*!40000 ALTER TABLE `feature_section_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `feature_section_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feature_sections`
--

DROP TABLE IF EXISTS `feature_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feature_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `heading` varchar(191) DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feature_sections`
--

LOCK TABLES `feature_sections` WRITE;
/*!40000 ALTER TABLE `feature_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `feature_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => No, 1 => Yes',
  `status` int(11) NOT NULL DEFAULT 1,
  `required_vps` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'Student Management',1,1,0,'2025-12-09 19:02:17','2025-12-09 19:02:54'),(2,'Academics Management',1,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(3,'Slider Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(4,'Teacher Management',1,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(5,'Session Year Management',1,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(6,'Holiday Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(7,'Timetable Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(8,'Attendance Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(9,'Exam Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(10,'Lesson Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(11,'Assignment Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(12,'Announcement Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(13,'Staff Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(14,'Expense Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(15,'Staff Leave Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(16,'Fees Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(17,'School Gallery Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(18,'ID Card - Certificate Generation',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(19,'Website Management',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(20,'Chat Module',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(21,'Transportation Module',0,1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54');
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `modal_type` varchar(191) NOT NULL,
  `modal_id` bigint(20) unsigned NOT NULL,
  `file_name` varchar(1024) DEFAULT NULL,
  `file_thumbnail` varchar(1024) DEFAULT NULL,
  `type` tinytext NOT NULL COMMENT '1 = File Upload, 2 = Youtube Link, 3 = Video Upload, 4 = Other Link',
  `file_url` varchar(1024) NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `files_modal_type_modal_id_index` (`modal_type`,`modal_id`),
  KEY `files_school_id_foreign` (`school_id`),
  CONSTRAINT `files_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_fields`
--

DROP TABLE IF EXISTS `form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL COMMENT 'text,number,textarea,dropdown,checkbox,radio,fileupload',
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `default_values` text DEFAULT NULL COMMENT 'values of radio,checkbox,dropdown,etc',
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`school_id`),
  KEY `form_fields_school_id_foreign` (`school_id`),
  CONSTRAINT `form_fields_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_fields`
--

LOCK TABLES `form_fields` WRITE;
/*!40000 ALTER TABLE `form_fields` DISABLE KEYS */;
INSERT INTO `form_fields` VALUES (1,'sri chaitanya','text',0,NULL,NULL,1,'2025-12-10 15:23:28','2025-12-10 22:57:06','2025-12-10 22:57:06');
/*!40000 ALTER TABLE `form_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(191) DEFAULT NULL,
  `session_year_id` bigint(20) unsigned DEFAULT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_school_id_foreign` (`school_id`),
  CONSTRAINT `galleries_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guidances`
--

DROP TABLE IF EXISTS `guidances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guidances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `link` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guidances`
--

LOCK TABLES `guidances` WRITE;
/*!40000 ALTER TABLE `guidances` DISABLE KEYS */;
/*!40000 ALTER TABLE `guidances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (43,'default','{\"uuid\":\"feb39a38-fefe-4498-80aa-6db57b3f3218\",\"displayName\":\"App\\\\Jobs\\\\SetupSchoolDatabase\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":\"120\",\"timeout\":300,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SetupSchoolDatabase\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\SetupSchoolDatabase\\\":3:{s:38:\\\"\\u0000App\\\\Jobs\\\\SetupSchoolDatabase\\u0000schoolId\\\";i:7;s:39:\\\"\\u0000App\\\\Jobs\\\\SetupSchoolDatabase\\u0000packageId\\\";N;s:46:\\\"\\u0000App\\\\Jobs\\\\SetupSchoolDatabase\\u0000schoolCodePrefix\\\";s:3:\\\"SCH\\\";}\"}}',0,NULL,1770306681,1770306681);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `code` varchar(64) NOT NULL,
  `file` varchar(512) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>active',
  `is_rtl` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English','en','en.json',1,0,'2025-12-09 19:02:54','2025-12-09 19:02:54');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marketplace_products`
--

DROP TABLE IF EXISTS `marketplace_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marketplace_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_percentage` double DEFAULT 0,
  `category` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `contact_info` text DEFAULT NULL,
  `link` varchar(191) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `user_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marketplace_products_user_id_foreign` (`user_id`),
  KEY `marketplace_products_school_id_foreign` (`school_id`),
  CONSTRAINT `marketplace_products_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `marketplace_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marketplace_products`
--

LOCK TABLES `marketplace_products` WRITE;
/*!40000 ALTER TABLE `marketplace_products` DISABLE KEYS */;
INSERT INTO `marketplace_products` VALUES (1,'test','test',5000.00,10,'Software',NULL,NULL,NULL,1,1,NULL,'2026-02-05 15:27:05','2026-02-05 15:27:05'),(2,'test','demo',4000.00,15,'Software',NULL,NULL,NULL,1,1,NULL,'2026-02-06 12:13:45','2026-02-16 07:30:05');
/*!40000 ALTER TABLE `marketplace_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mediums`
--

DROP TABLE IF EXISTS `mediums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediums` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mediums_school_id_foreign` (`school_id`),
  CONSTRAINT `mediums_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mediums`
--

LOCK TABLES `mediums` WRITE;
/*!40000 ALTER TABLE `mediums` DISABLE KEYS */;
/*!40000 ALTER TABLE `mediums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_04_01_091033_create_permission_tables',1),(6,'2022_04_01_105826_all_tables',1),(7,'2023_11_16_134449_version1-0-1',1),(8,'2023_12_07_120054_version1_1_0',1),(9,'2024_01_30_092228_version1_2_0',1),(10,'2024_03_12_173521_version1_3_0',1),(11,'2024_05_21_094714_version1_3_2',1),(12,'2024_07_21_093657_version1_4_0',1),(13,'2024_08_08_094709_version1_4_1',1),(14,'2024_10_17_112347_version1_5_0',1),(15,'2025_01_22_102146_version1_5_2',1),(16,'2025_04_10_100137_version1_5_4',1),(17,'2025_05_02_095829_version1_6_0',1),(18,'2025_07_28_123928_version1_7_0',1),(19,'2025_09_09_125830_version1_8_0',1),(20,'2026_02_05_201156_create_marketplace_products_table',2),(21,'2026_02_05_204200_add_commission_to_marketplace_products_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(4,'App\\Models\\User',8),(4,'App\\Models\\User',9);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package_features`
--

DROP TABLE IF EXISTS `package_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package_features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint(20) unsigned NOT NULL,
  `feature_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`package_id`,`feature_id`),
  KEY `package_features_package_id_index` (`package_id`),
  KEY `package_features_feature_id_index` (`feature_id`),
  CONSTRAINT `package_features_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_features_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package_features`
--

LOCK TABLES `package_features` WRITE;
/*!40000 ALTER TABLE `package_features` DISABLE KEYS */;
INSERT INTO `package_features` VALUES (1,1,2,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(2,1,5,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(3,1,1,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(4,1,4,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(5,1,12,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(6,1,11,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(7,1,8,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(8,1,20,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(9,1,9,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(10,1,14,'2025-12-10 19:40:02','2025-12-10 19:40:02'),(11,2,2,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(12,2,5,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(13,2,1,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(14,2,4,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(15,2,12,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(16,2,11,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(17,2,8,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(18,2,20,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(19,2,14,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(20,2,16,'2025-12-11 16:28:21','2025-12-12 22:57:50'),(31,2,9,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(32,2,17,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(33,2,3,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(34,2,15,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(35,2,13,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(36,2,7,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(37,2,21,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(38,2,19,'2025-12-12 22:56:33','2025-12-12 22:57:50'),(67,3,2,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(68,3,5,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(69,3,1,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(70,3,4,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(71,3,12,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(72,3,11,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(73,3,8,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(74,3,20,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(75,3,9,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(76,3,14,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(77,3,16,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(78,3,6,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(79,3,18,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(80,3,10,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(81,3,17,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(82,3,15,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(83,3,13,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(84,3,19,'2025-12-12 23:15:51','2025-12-12 23:43:04'),(85,3,3,'2025-12-12 23:34:39','2025-12-12 23:43:04'),(86,3,21,'2025-12-12 23:34:39','2025-12-12 23:43:04'),(105,3,7,'2025-12-12 23:35:12','2025-12-12 23:43:04'),(147,4,2,'2025-12-20 12:24:39','2026-01-02 10:56:57'),(148,4,5,'2025-12-20 12:24:39','2026-01-02 10:56:57'),(149,4,1,'2025-12-20 12:24:39','2026-01-02 10:56:57'),(150,4,4,'2025-12-20 12:24:39','2026-01-02 10:56:57'),(157,4,16,'2025-12-20 12:24:39','2026-01-02 10:56:57'),(161,4,3,'2025-12-20 12:24:39','2026-01-02 10:56:57'),(182,4,9,'2025-12-20 12:37:43','2026-01-02 10:56:57'),(196,4,12,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(197,4,11,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(198,4,8,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(199,4,20,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(200,4,14,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(201,4,6,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(202,4,18,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(203,4,10,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(204,4,17,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(205,4,15,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(206,4,13,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(207,4,7,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(208,4,21,'2025-12-20 12:41:32','2026-01-02 10:56:57'),(216,5,2,'2025-12-20 12:46:48','2025-12-20 12:46:48'),(217,5,5,'2025-12-20 12:46:48','2025-12-20 12:46:48'),(218,5,1,'2025-12-20 12:46:48','2025-12-20 12:46:48'),(219,5,4,'2025-12-20 12:46:48','2025-12-20 12:46:48'),(240,4,19,'2026-01-02 10:56:57','2026-01-02 10:56:57'),(261,6,2,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(262,6,5,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(263,6,1,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(264,6,4,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(265,6,12,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(267,6,8,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(268,6,20,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(269,6,9,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(270,6,14,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(271,6,16,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(272,6,6,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(273,6,18,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(274,6,10,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(275,6,17,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(276,6,3,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(277,6,15,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(278,6,13,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(279,6,7,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(280,6,21,'2026-01-11 23:41:44','2026-01-11 23:42:23'),(281,6,19,'2026-01-11 23:41:44','2026-01-11 23:42:23');
/*!40000 ALTER TABLE `package_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `tagline` varchar(191) DEFAULT NULL,
  `student_charge` double(8,2) NOT NULL,
  `staff_charge` double(8,2) NOT NULL,
  `days` int(11) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '0 => Prepaid, 1 => Postpaid',
  `no_of_students` int(11) NOT NULL DEFAULT 0,
  `no_of_staffs` int(11) NOT NULL DEFAULT 0,
  `charges` double(64,4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => Unpublished, 1 => Published',
  `is_trial` int(11) NOT NULL DEFAULT 0,
  `highlight` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => No, 1 => Yes',
  `rank` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (1,'free','free','free',0.00,0.00,20,1,0,0,0.0000,0,0,0,0,NULL,'2025-12-10 19:55:32','2025-12-10 19:55:32'),(2,'free',NULL,'free',0.00,0.00,20,0,100,15,10.0000,1,0,1,4,NULL,'2026-01-15 02:28:29',NULL),(3,'Pro','Pro',NULL,20.00,20.00,30,1,0,0,0.0000,1,0,0,5,NULL,'2026-01-15 02:28:29',NULL),(4,'Pro Exclusive',NULL,NULL,15.00,20.00,250,1,0,0,0.0000,0,0,1,1,NULL,'2026-01-15 02:28:29',NULL),(5,'PREMIUM',NULL,NULL,20.00,20.00,200,1,0,0,0.0000,0,0,0,2,NULL,'2026-01-15 02:28:29',NULL),(6,'supraja premium','best for value','best',10.00,20.00,250,1,0,0,0.0000,1,0,0,3,NULL,'2026-01-15 02:28:29',NULL);
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_configurations`
--

DROP TABLE IF EXISTS `payment_configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_configurations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(191) NOT NULL,
  `api_key` varchar(191) NOT NULL,
  `secret_key` varchar(191) NOT NULL,
  `webhook_secret_key` varchar(191) NOT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `account_name` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
  `currency_code` varchar(128) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 - Disabled, 1 - Enabled',
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_configurations_school_id_foreign` (`school_id`),
  CONSTRAINT `payment_configurations_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_configurations`
--

LOCK TABLES `payment_configurations` WRITE;
/*!40000 ALTER TABLE `payment_configurations` DISABLE KEYS */;
INSERT INTO `payment_configurations` VALUES (1,'Stripe','pk_test_51NxxxxxxDummyPublishableKey1234567890','sk_test_51NxxxxxxDummySecretKey0987654321','whsec_dummyWebhookSecret_123456789abcdef','','','','INR',0,NULL,'2025-12-10 15:20:57','2025-12-12 23:38:58'),(2,'Razorpay','rzp_test_DummyKeyId123456','DummyKeySecret_abcdefghijklmnopqrstuvwxyz','dummy_webhook_secret_razorpay_12345','','','','INR',0,NULL,'2025-12-10 15:20:57','2025-12-12 23:38:58'),(3,'Paystack','pk_test_dummyPublicKey_1234567890','sk_test_dummySecretKey_abcdefghijklmnopqrstuvwxyz','paystack_dummy_webhook_secret_12345','','','','INR',0,NULL,'2025-12-10 15:20:57','2025-12-12 23:38:58'),(4,'Flutterwave','FLWPUBK_TEST-DummyPublishableKey1234567890-X','FLWSECK_TEST-DummySecretKey_abcdefghijklmnopqrstuvwxyz-X','','','','','INR',0,NULL,'2025-12-10 15:20:57','2025-12-12 23:38:58');
/*!40000 ALTER TABLE `payment_configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_transactions`
--

DROP TABLE IF EXISTS `payment_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` double(64,2) NOT NULL,
  `payment_gateway` varchar(191) NOT NULL,
  `order_id` varchar(191) DEFAULT NULL COMMENT 'order_id / payment_intent_id',
  `payment_id` varchar(191) DEFAULT NULL,
  `payment_signature` varchar(191) DEFAULT NULL,
  `payment_status` enum('failed','succeed','pending') NOT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_transactions_school_id_foreign` (`school_id`),
  KEY `payment_transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `payment_transactions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payment_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_transactions`
--

LOCK TABLES `payment_transactions` WRITE;
/*!40000 ALTER TABLE `payment_transactions` DISABLE KEYS */;
INSERT INTO `payment_transactions` VALUES (1,2,10.00,'Cash',NULL,NULL,NULL,'succeed',1,'2025-12-11 16:29:35','2025-12-11 16:29:35'),(2,4,10.00,'Cash',NULL,NULL,NULL,'succeed',3,'2025-12-12 21:58:54','2025-12-12 21:58:54'),(3,5,10.00,'Cash',NULL,NULL,NULL,'succeed',4,'2025-12-16 16:10:33','2025-12-16 16:10:33');
/*!40000 ALTER TABLE `payment_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'role-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(2,'role-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(3,'role-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(4,'role-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(5,'language-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(6,'language-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(7,'language-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(8,'language-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(9,'schools-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(10,'schools-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(11,'schools-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(12,'schools-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(13,'package-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(14,'package-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(15,'package-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(16,'package-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(17,'addons-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(18,'addons-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(19,'addons-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(20,'addons-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(21,'guidance-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(22,'guidance-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(23,'guidance-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(24,'guidance-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(25,'system-setting-manage','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(26,'fcm-setting-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(27,'email-setting-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(28,'privacy-policy','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(29,'contact-us','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(30,'about-us','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(31,'terms-condition','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(32,'app-settings','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(33,'subscription-view','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(34,'staff-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(35,'staff-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(36,'staff-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(37,'staff-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(38,'faqs-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(39,'faqs-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(40,'faqs-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(41,'faqs-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(42,'fcm-setting-manage','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(43,'front-site-setting','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(44,'payment-settings','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(45,'subscription-settings','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(46,'subscription-change-bills','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(47,'school-terms-condition','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(48,'subscription-bill-payment','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(49,'web-settings','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(50,'email-template','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(51,'custom-school-email','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(52,'database-backup','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(53,'school-custom-field-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(54,'school-custom-field-create','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(55,'school-custom-field-edit','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(56,'school-custom-field-delete','web','2025-12-09 19:02:54','2025-12-09 19:02:54'),(57,'contact-inquiry-list','web','2025-12-09 19:02:54','2025-12-09 19:02:54');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(1,3),(1,4),(2,1),(2,3),(2,4),(3,1),(3,3),(3,4),(4,1),(4,3),(4,4),(5,1),(5,3),(5,4),(6,1),(6,3),(6,4),(7,1),(7,3),(7,4),(8,1),(8,3),(8,4),(9,1),(9,3),(9,4),(10,1),(10,3),(10,4),(11,1),(11,3),(11,4),(12,1),(12,3),(12,4),(13,1),(13,3),(13,4),(14,1),(14,3),(14,4),(15,1),(15,3),(15,4),(16,1),(16,3),(16,4),(17,1),(17,3),(17,4),(18,1),(18,3),(18,4),(19,1),(19,3),(19,4),(20,1),(20,3),(20,4),(21,1),(21,3),(21,4),(22,1),(22,3),(22,4),(23,1),(23,3),(23,4),(24,1),(24,3),(24,4),(25,1),(25,3),(26,1),(26,3),(26,4),(27,1),(27,3),(27,4),(28,1),(28,3),(28,4),(29,1),(29,3),(29,4),(30,1),(30,3),(30,4),(31,1),(31,3),(32,1),(32,3),(32,4),(33,1),(33,3),(33,4),(34,1),(34,3),(34,4),(35,1),(35,3),(35,4),(36,1),(36,3),(36,4),(37,1),(37,3),(37,4),(38,1),(38,3),(38,4),(39,1),(39,3),(39,4),(40,1),(40,3),(40,4),(41,1),(41,3),(41,4),(42,1),(42,3),(42,4),(45,1),(45,3),(45,4),(46,1),(46,3),(46,4),(47,1),(47,3),(47,4),(48,1),(48,3),(48,4),(49,1),(49,3),(51,1),(51,3),(51,4),(52,1),(52,3),(52,4),(53,1),(53,3),(53,4),(54,1),(54,3),(54,4),(55,1),(55,3),(55,4),(56,1),(56,3),(56,4),(57,1),(57,3),(57,4);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `custom_role` tinyint(1) NOT NULL DEFAULT 1,
  `editable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_school_id_unique` (`name`,`guard_name`,`school_id`),
  KEY `roles_school_id_foreign` (`school_id`),
  CONSTRAINT `roles_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','web',NULL,0,0,'2025-12-09 19:02:54','2025-12-09 19:02:54'),(3,'student','web',NULL,1,1,'2025-12-10 19:40:35','2025-12-10 19:40:35'),(4,'Admin','web',NULL,1,1,'2025-12-20 13:01:59','2025-12-20 13:01:59'),(5,'Teacher','web',NULL,1,1,'2026-02-10 07:45:02','2026-02-10 07:45:02'),(6,'Parent','web',NULL,1,1,'2026-02-10 07:45:02','2026-02-10 07:45:02'),(7,'School Admin','web',NULL,1,1,'2026-02-10 07:45:02','2026-02-10 07:45:02');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_inquiries`
--

DROP TABLE IF EXISTS `school_inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_inquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(191) NOT NULL,
  `school_address` varchar(191) NOT NULL,
  `school_phone` varchar(191) NOT NULL,
  `school_email` varchar(191) NOT NULL,
  `school_tagline` varchar(191) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_inquiries`
--

LOCK TABLES `school_inquiries` WRITE;
/*!40000 ALTER TABLE `school_inquiries` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_settings`
--

DROP TABLE IF EXISTS `school_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `data` text NOT NULL,
  `type` varchar(191) DEFAULT NULL COMMENT 'datatype like string , file etc',
  `school_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `school_settings_name_school_id_unique` (`name`,`school_id`),
  KEY `school_settings_school_id_foreign` (`school_id`),
  CONSTRAINT `school_settings_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_settings`
--

LOCK TABLES `school_settings` WRITE;
/*!40000 ALTER TABLE `school_settings` DISABLE KEYS */;
INSERT INTO `school_settings` VALUES (1,'session_year','1','number',1),(2,'school_name','Demo School','string',1);
/*!40000 ALTER TABLE `school_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `support_phone` varchar(191) NOT NULL,
  `support_email` varchar(191) NOT NULL,
  `tagline` varchar(191) NOT NULL,
  `logo` varchar(191) NOT NULL,
  `admin_id` bigint(20) unsigned DEFAULT NULL COMMENT 'user_id',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => Deactivate, 1 => Active',
  `installed` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Not installed, 1: Installed',
  `domain` varchar(191) DEFAULT NULL,
  `database_name` varchar(191) DEFAULT NULL,
  `code` varchar(191) DEFAULT NULL,
  `domain_type` varchar(191) DEFAULT 'default',
  `type` varchar(191) DEFAULT 'custom',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schools_admin_id_foreign` (`admin_id`),
  CONSTRAINT `schools_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (1,'Demo School','123 Demo Street','1234567890','demo@school.com','Demo Tagline','',2,1,1,'school1','project','SCH20251','default','demo','2025-12-10 15:23:47','2026-02-10 07:36:13',NULL),(2,'TechNova School','Hyderabad','09392511176','saisuppu1@gmail.com','best education','super-admin/school/694139b37857d0.726851821765882291.png',3,1,1,'beta','school_db','SCH20252','default','custom','2025-12-10 19:26:30','2025-12-16 16:21:31',NULL),(3,'Sarthak Edge','Plot no 54, Flat no 306 OM Residency Bapujinagar, Bowenpally, Secunderabad Hyderabad, Telanagana 500011','7207971984','mmtsofttech@gmail.com','AI-powered SaaS-based','super-admin/school/69397e599a0753.011945231765375577.png',4,1,1,'mmt','school_db','SCH20252','default','custom','2025-12-10 19:36:17','2025-12-11 16:31:35',NULL),(4,'TechNova School','Hyderabad','789456123','technova@gmail.com','Best bet for Education','super-admin/school/694137211353a4.548596141765881633.png',5,0,1,'crudbook.in','school_db','SCH20254','custom','custom','2025-12-10 19:59:59','2025-12-16 16:20:16','2025-12-16 16:20:16'),(6,'Tech Stars','Hyderabad','8179709818','info@sarthakedge.com','Best Bet for Education','super-admin/school/694645d7459237.720339081766213079.png',7,1,1,'beta1','school_db','SCHO20254','default','custom','2025-12-20 12:14:39','2025-12-20 12:15:37',NULL),(7,'Demomain','demo','09392511176','bizbyaravind@gmail.com','test','super-admin/school/6984bc78449472.755283691770306680.png',10,0,0,'test','school_db','SCH20267','default','custom','2026-02-05 15:51:20','2026-02-05 15:51:20',NULL);
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_school_id_foreign` (`school_id`),
  CONSTRAINT `sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semesters`
--

DROP TABLE IF EXISTS `semesters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semesters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `start_month` tinyint(4) NOT NULL,
  `end_month` tinyint(4) NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `semesters_school_id_foreign` (`school_id`),
  CONSTRAINT `semesters_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semesters`
--

LOCK TABLES `semesters` WRITE;
/*!40000 ALTER TABLE `semesters` DISABLE KEYS */;
/*!40000 ALTER TABLE `semesters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_years`
--

DROP TABLE IF EXISTS `session_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_years` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `default` tinyint(4) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_years_name_school_id_unique` (`name`,`school_id`),
  KEY `session_years_school_id_foreign` (`school_id`),
  CONSTRAINT `session_years_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_years`
--

LOCK TABLES `session_years` WRITE;
/*!40000 ALTER TABLE `session_years` DISABLE KEYS */;
INSERT INTO `session_years` VALUES (1,'2026',1,'2026-01-01','2026-12-31',1,'2026-02-10 08:03:05','2026-02-10 08:03:05',NULL);
/*!40000 ALTER TABLE `session_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shifts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shifts_school_id_foreign` (`school_id`),
  CONSTRAINT `shifts_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(191) NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `link` varchar(191) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '1: App, 2: Web, 3: Both',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sliders_school_id_foreign` (`school_id`),
  CONSTRAINT `sliders_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_support_schools`
--

DROP TABLE IF EXISTS `staff_support_schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_support_schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_school` (`user_id`,`school_id`),
  KEY `staff_support_schools_school_id_foreign` (`school_id`),
  CONSTRAINT `staff_support_schools_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `staff_support_schools_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_support_schools`
--

LOCK TABLES `staff_support_schools` WRITE;
/*!40000 ALTER TABLE `staff_support_schools` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_support_schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `qualification` varchar(512) DEFAULT NULL,
  `salary` double NOT NULL DEFAULT 0,
  `joining_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `staffs_user_id_foreign` (`user_id`),
  CONSTRAINT `staffs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffs`
--

LOCK TABLES `staffs` WRITE;
/*!40000 ALTER TABLE `staffs` DISABLE KEYS */;
INSERT INTO `staffs` VALUES (1,8,NULL,0,'1970-01-01','2026-01-13 12:18:02','2026-01-13 12:24:49'),(2,9,NULL,0,'1970-01-01','2026-01-14 20:54:35','2026-01-14 20:54:35');
/*!40000 ALTER TABLE `staffs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `streams`
--

DROP TABLE IF EXISTS `streams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `streams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `streams_school_id_foreign` (`school_id`),
  CONSTRAINT `streams_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `streams`
--

LOCK TABLES `streams` WRITE;
/*!40000 ALTER TABLE `streams` DISABLE KEYS */;
/*!40000 ALTER TABLE `streams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `class_section_id` bigint(20) unsigned NOT NULL,
  `admission_no` varchar(512) NOT NULL,
  `roll_number` int(11) DEFAULT NULL,
  `admission_date` date NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `guardian_id` bigint(20) unsigned NOT NULL,
  `session_year_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_class_section_id_foreign` (`class_section_id`),
  KEY `students_school_id_foreign` (`school_id`),
  KEY `students_guardian_id_foreign` (`guardian_id`),
  KEY `students_session_year_id_foreign` (`session_year_id`),
  CONSTRAINT `students_class_section_id_foreign` FOREIGN KEY (`class_section_id`) REFERENCES `class_sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_guardian_id_foreign` FOREIGN KEY (`guardian_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_session_year_id_foreign` FOREIGN KEY (`session_year_id`) REFERENCES `session_years` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `bg_color` varchar(32) NOT NULL,
  `image` varchar(512) NOT NULL,
  `medium_id` bigint(20) unsigned NOT NULL,
  `type` varchar(64) NOT NULL COMMENT 'Theory / Practical',
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subjects_medium_id_foreign` (`medium_id`),
  KEY `subjects_school_id_foreign` (`school_id`),
  CONSTRAINT `subjects_medium_id_foreign` FOREIGN KEY (`medium_id`) REFERENCES `mediums` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_bills`
--

DROP TABLE IF EXISTS `subscription_bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription_bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `amount` decimal(64,2) NOT NULL,
  `total_student` bigint(20) NOT NULL,
  `total_staff` bigint(20) NOT NULL,
  `payment_transaction_id` bigint(20) unsigned DEFAULT NULL,
  `due_date` date NOT NULL,
  `school_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_bill` (`subscription_id`,`school_id`),
  KEY `subscription_bills_school_id_foreign` (`school_id`),
  KEY `subscription_bills_payment_transaction_id_foreign` (`payment_transaction_id`),
  CONSTRAINT `subscription_bills_payment_transaction_id_foreign` FOREIGN KEY (`payment_transaction_id`) REFERENCES `payment_transactions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscription_bills_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscription_bills_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_bills`
--

LOCK TABLES `subscription_bills` WRITE;
/*!40000 ALTER TABLE `subscription_bills` DISABLE KEYS */;
INSERT INTO `subscription_bills` VALUES (1,1,NULL,10.00,100,15,1,'2025-12-11',1,'2025-12-11 16:29:35','2025-12-11 16:29:35'),(2,2,NULL,10.00,100,15,2,'2025-12-12',3,'2025-12-12 21:58:54','2025-12-12 21:58:54'),(3,4,NULL,10.00,100,15,3,'2025-12-16',4,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(4,5,NULL,0.00,0,0,NULL,'2025-12-25',6,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(5,3,NULL,18.00,2,1,NULL,'2025-12-25',2,'2025-12-20 12:58:38','2025-12-20 12:58:38'),(6,7,NULL,3.64,3,1,NULL,'2026-01-07',2,'2026-01-02 11:03:18','2026-01-02 11:03:18');
/*!40000 ALTER TABLE `subscription_bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_features`
--

DROP TABLE IF EXISTS `subscription_features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription_features` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `feature_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`subscription_id`,`feature_id`),
  KEY `subscription_features_feature_id_foreign` (`feature_id`),
  CONSTRAINT `subscription_features_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscription_features_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_features`
--

LOCK TABLES `subscription_features` WRITE;
/*!40000 ALTER TABLE `subscription_features` DISABLE KEYS */;
INSERT INTO `subscription_features` VALUES (1,1,1,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(2,1,2,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(3,1,4,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(4,1,5,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(5,1,8,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(6,1,11,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(7,1,12,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(8,1,14,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(9,1,16,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(10,1,20,'2025-12-11 16:29:35','2025-12-12 22:57:50'),(11,2,1,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(12,2,2,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(13,2,4,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(14,2,5,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(15,2,8,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(16,2,11,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(17,2,12,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(18,2,14,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(19,2,16,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(20,2,20,'2025-12-12 21:58:54','2025-12-12 22:57:50'),(21,1,9,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(22,2,9,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(23,1,17,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(24,2,17,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(25,1,3,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(26,2,3,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(27,1,15,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(28,2,15,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(29,1,13,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(30,2,13,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(31,1,7,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(32,2,7,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(33,1,21,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(34,2,21,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(35,1,19,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(36,2,19,'2025-12-12 22:57:50','2025-12-12 22:57:50'),(96,4,1,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(97,4,2,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(98,4,3,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(99,4,4,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(100,4,5,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(101,4,7,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(102,4,8,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(103,4,9,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(104,4,11,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(105,4,12,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(106,4,13,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(107,4,14,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(108,4,15,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(109,4,16,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(110,4,17,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(111,4,19,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(112,4,20,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(113,4,21,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(124,6,1,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(125,6,2,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(126,6,3,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(127,6,4,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(128,6,5,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(129,6,6,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(130,6,7,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(131,6,8,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(132,6,9,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(133,6,10,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(134,6,11,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(135,6,12,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(136,6,13,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(137,6,14,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(138,6,15,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(139,6,16,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(140,6,17,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(141,6,18,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(142,6,20,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(143,6,21,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(164,8,1,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(165,8,2,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(166,8,3,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(167,8,4,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(168,8,5,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(169,8,6,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(170,8,7,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(171,8,8,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(172,8,9,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(173,8,10,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(174,8,11,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(175,8,12,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(176,8,13,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(177,8,14,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(178,8,15,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(179,8,16,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(180,8,17,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(181,8,18,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(182,8,19,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(183,8,20,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(184,8,21,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(185,9,19,'2026-02-06 07:45:05','2026-02-06 07:45:05');
/*!40000 ALTER TABLE `subscription_features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` bigint(20) unsigned NOT NULL,
  `package_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `student_charge` decimal(64,2) NOT NULL,
  `staff_charge` decimal(64,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `package_type` int(11) NOT NULL DEFAULT 1 COMMENT '0 => Prepaid, 1 => Postpaid',
  `no_of_students` int(11) NOT NULL DEFAULT 0,
  `no_of_staffs` int(11) NOT NULL DEFAULT 0,
  `charges` decimal(64,2) NOT NULL,
  `billing_cycle` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_school_id_foreign` (`school_id`),
  KEY `subscriptions_package_id_foreign` (`package_id`),
  CONSTRAINT `subscriptions_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subscriptions_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,1,2,'free',0.00,0.00,'2025-12-11','2025-12-30',0,100,15,10.00,20,'2025-12-11 16:29:35','2025-12-11 16:29:35'),(2,3,2,'free',0.00,0.00,'2025-12-12','2025-12-31',0,100,15,10.00,20,'2025-12-12 21:58:54','2025-12-12 21:58:54'),(3,2,3,'Pro',20.00,20.00,'2025-12-12','2025-12-20',1,0,0,0.00,30,'2025-12-12 23:32:59','2025-12-20 12:58:38'),(4,4,2,'free',0.00,0.00,'2025-12-16','2026-01-04',0,100,15,10.00,20,'2025-12-16 16:10:33','2025-12-16 16:10:33'),(5,6,4,'Pro Exclusive',15.00,20.00,'2025-12-20','2025-12-20',1,0,0,0.00,250,'2025-12-20 12:34:37','2025-12-20 12:44:38'),(6,6,4,'Pro Exclusive',15.00,20.00,'2025-12-20','2026-08-26',1,0,0,0.00,250,'2025-12-20 12:44:38','2025-12-20 12:44:38'),(7,2,4,'Pro Exclusive',15.00,20.00,'2025-12-20','2026-01-02',1,0,0,0.00,250,'2025-12-20 12:58:38','2026-01-02 11:03:18'),(8,2,4,'Pro Exclusive',15.00,20.00,'2026-01-02','2026-09-08',1,0,0,0.00,250,'2026-01-02 11:03:18','2026-01-02 11:03:18'),(9,1,2,'free',0.00,0.00,'2026-02-06','2027-02-06',1,0,0,0.00,365,'2026-02-06 07:45:05','2026-02-06 07:45:05');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `data` text NOT NULL,
  `type` varchar(191) DEFAULT NULL COMMENT 'datatype like string , file etc',
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_settings_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=431 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'hero_title_1','Opt for SarthakEdge Schoolmanagement System for 14+ robust features for an enhanced educational experience.','text'),(2,'hero_title_2','Top Rated Instructors','text'),(3,'about_us_title','A modern and unique style','text'),(4,'about_us_heading','Why it is best?','text'),(5,'about_us_description','SarthakEdge is the pinnacle of school management, offering advanced technology, user-friendly features, and personalized solutions. It simplifies communication, streamlines administrative tasks, and elevates the educational experience for all stakeholders. With SarthakEdge, excellence in education management is guaranteed.','text'),(6,'about_us_points','Affordable price,Easy to manage admin panel,Data Security','text'),(7,'custom_package_status','1','text'),(8,'custom_package_description','Tailor your experience with our custom package options. From personalized services to bespoke solutions, we offer flexibility to meet your unique needs.','text'),(9,'download_our_app_description','Join the ranks of true trivia champions and quench your thirst for knowledge with Masters of Trivia - the ultimate quiz app designed to test your wits and unlock a world of fun facts. Challenge your brain, compete with friends, and discover fascinating tidbits from diverse categories. Don\'t miss out on the exhilarating experience that awaits you - get started now!Join the ranks of true trivia champions and quench your thirst for knowledge with Masters of Trivia - the ultimate quiz app designed to test your wits and unlock a world of fun facts.','text'),(10,'theme_primary_color','#2c8e2c','text'),(11,'theme_secondary_color','#1d1a1a','text'),(12,'theme_secondary_color_1','#0e0e0e','text'),(13,'theme_primary_background_color','#111010','text'),(14,'theme_text_secondary_color','#ffffff','text'),(15,'tag_line','','text'),(16,'mobile','918179709818','text'),(17,'hero_description','Experience the future of education with our eSchool SaaS platform. Streamline attendance, assignments, exams, and more. Elevate your school\'s efficiency and engagement.','text'),(18,'display_school_logos','1','text'),(19,'display_counters','','text'),(20,'email_template_school_registration','&lt;p&gt;Dear {school_admin_name},&lt;/p&gt; &lt;p&gt;Welcome to {system_name}!&lt;/p&gt; &lt;p&gt;We are excited to have you as part of our educational community. Below are your registration details to access the system:&lt;/p&gt; &lt;hr&gt; &lt;p&gt;&lt;strong&gt;School Name:&lt;/strong&gt; {school_name}&lt;/p&gt; &lt;p&gt;&lt;strong&gt;System URL:&lt;/strong&gt; {url}&lt;/p&gt; &lt;p&gt;&lt;strong&gt;Your Login Credentials:&lt;/strong&gt;&lt;/p&gt; &lt;ul&gt; &lt;li&gt;&lt;strong&gt;Email:&lt;/strong&gt; {email}&lt;/li&gt; &lt;li&gt;&lt;strong&gt;Password:&lt;/strong&gt; {password}&lt;/li&gt; &lt;li&gt;&lt;strong&gt;School Code:&lt;/strong&gt; {code}&lt;/li&gt; &lt;/ul&gt; &lt;hr&gt; &lt;p&gt;&lt;strong&gt;Please follow these steps to complete your registration:&lt;/strong&gt;&lt;/p&gt; &lt;ol&gt; &lt;li&gt;Click on the system URL provided above.&lt;/li&gt; &lt;li&gt;Enter your email and password.&lt;/li&gt; &lt;li&gt;Follow the instructions to complete your profile setup.&lt;/li&gt; &lt;/ol&gt; &lt;p&gt;&lt;strong&gt;Important:&lt;/strong&gt;&lt;/p&gt; &lt;ul&gt; &lt;li&gt;For security reasons, please change your password after your first login.&lt;/li&gt; &lt;li&gt;If you encounter any issues during the registration process, please do not hesitate to contact our support team at {support_email} or call {contact}.&lt;/li&gt; &lt;/ul&gt; &lt;p&gt;Thank you for choosing {system_name}. We are committed to providing you with the best educational tools and resources.&lt;/p&gt; &lt;p&gt;Best regards,&lt;/p&gt; &lt;p&gt;{super_admin_name}&lt;br&gt;{system_name}&lt;br&gt;{support_email}&lt;br&gt;{url}&lt;/p&gt; &lt;br&gt; &lt;p&gt;&lt;strong&gt;This email was auto-generated, so don&#039;t reply.&lt;/strong&gt;&lt;/p&gt;','text'),(21,'system_version','1.8.0','string'),(23,'email_template_two_factor_authentication_code','&lt;p&gt;Dear {school_admin_name},&lt;/p&gt; &lt;p&gt;Welcome to {system_name}!&lt;/p&gt; &lt;p&gt;We are excited to have you as part of our educational community. To enhance the security of your account, we have enabled Two-Factor Authentication (2FA) for your login.&lt;/p&gt; &lt;p&gt;&lt;strong&gt;Your Verification Code:&lt;/strong&gt;&lt;/p&gt; &lt;p&gt;&lt;strong&gt;{verification_code}&lt;/strong&gt;&lt;/p&gt; &lt;p&gt;This verification code is required to complete your login process. Please enter the code within the next {expiration_time} minutes. If the code expires, you can request a new one by following the same process.&lt;/p&gt; &lt;hr&gt; &lt;p&gt;&lt;strong&gt;Important:&lt;/strong&gt;&lt;/p&gt; &lt;ul&gt; &lt;li&gt;If you did not request this verification code, please contact our support team immediately at {support_email} or call {support_contact} to secure your account.&lt;/li&gt; &lt;li&gt;For additional security, ensure that no one else has access to your email or device when retrieving your verification code.&lt;/li&gt; &lt;/ul&gt; &lt;p&gt;If you have any issues with the 2FA process or need assistance, our support team is ready to help at {support_email} or {support_contact}.&lt;/p&gt; &lt;p&gt;Thank you for taking extra steps to secure your account. We appreciate your commitment to keeping your information safe.&lt;/p&gt; &lt;p&gt;Best regards,&lt;/p&gt; &lt;p&gt;{super_admin_name}&lt;br&gt;{system_name}&lt;br&gt;{support_email}&lt;br&gt;{url}&lt;/p&gt; &lt;br&gt; &lt;p&gt;&lt;strong&gt;This email was auto-generated, so please do not reply.&lt;/strong&gt;&lt;/p&gt;','text'),(24,'school_inquiry','1','string'),(25,'file_upload_size_limit','2','string'),(26,'wizard_checkMark','1','integer'),(27,'system_settings_wizard_checkMark','1','integer'),(28,'notification_settings_wizard_checkMark','1','integer'),(29,'email_settings_wizard_checkMark','1','integer'),(30,'verify_email_wizard_checkMark','1','integer'),(31,'email_template_settings_wizard_checkMark','1','integer'),(32,'payment_settings_wizard_checkMark','1','integer'),(33,'third_party_api_settings_wizard_checkMark','1','integer'),(34,'database_root_user','1','integer'),(35,'laravel_queue_setup','1','integer'),(36,'wildcard_domain','1','integer'),(37,'web_socket_setup','1','integer'),(38,'notification_settings','1','integer'),(39,'time_zone','Asia/Kolkata','string'),(40,'date_format','m-d-Y','date'),(41,'time_format','h:i A','time'),(42,'theme_color','#3b13ab','string'),(43,'session_year','1','string'),(44,'email_verified','1','string'),(45,'subscription_alert','7','integer'),(46,'currency_code','INR','string'),(47,'currency_symbol','“éc%','string'),(48,'additional_billing_days','5','integer'),(49,'system_name','SarthakEdge, an AI-powered  School Management System','string'),(50,'address','Plot no 54, Flat no 306 OM Residency Bapujinagar, Bowenpally, Secunderabad Hyderabad,Telanagana 500011','string'),(51,'billing_cycle_in_days','30','integer'),(52,'current_plan_expiry_warning_days','7','integer'),(53,'front_site_theme_color','#e9f9f3','text'),(54,'primary_color','#3ccb9b','text'),(55,'secondary_color','#245a7f','text'),(56,'short_description','SarthakEdge -Ai powered school management System - Manage Your School','text'),(57,'facebook','https://www.facebook.com','text'),(58,'instagram','https://www.instagram.com','text'),(59,'linkedin','https://in.linkedin.com','text'),(60,'footer_text','<p>&copy; SarthakEdge. All Rights Reserved</p>','text'),(61,'tagline','We Provide the best Education','text'),(62,'super_admin_name','Super Admin','text'),(69,'web_maintenance','','string'),(100,'school_code_prefix','SCH','string'),(113,'firebase_project_id','schoolapp-f7a57','string'),(114,'mail_mailer','smtp','string'),(115,'mail_host','mail.mmtsofttech.com','string'),(116,'mail_port','587','string'),(117,'mail_username','noreply@mmtsofttech.com','string'),(118,'mail_password','MMT@789!@#sa','string'),(119,'mail_encryption','TLS','string'),(120,'mail_send_from','noreply@mmtsofttech.com','string'),(122,'school_reject_template','','string'),(123,'school_inquiry_template','','string'),(220,'horizontal_logo','super-admin/system-settings/69397cfdb4c333.432217321765375229.png','file'),(221,'vertical_logo','super-admin/system-settings/69397cfdb6b357.521057591765375229.png','file'),(222,'favicon','super-admin/system-settings/69397cfdb779c3.562964331765375229.png','file'),(223,'login_page_logo','super-admin/system-settings/69397cfdb7dd03.955086371765375229.png','file'),(263,'school_prefix','SCHO','text'),(266,'firebase_service_file','super-admin/system-settings/6942408e267598.716139561765949582.json','file');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `gender` varchar(16) DEFAULT NULL,
  `image` varchar(512) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `current_address` varchar(191) DEFAULT NULL,
  `permanent_address` varchar(191) DEFAULT NULL,
  `occupation` varchar(128) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `reset_request` tinyint(4) NOT NULL DEFAULT 0,
  `fcm_id` varchar(1024) DEFAULT NULL,
  `school_id` bigint(20) unsigned DEFAULT NULL,
  `language` varchar(191) NOT NULL DEFAULT 'en',
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `two_factor_enabled` tinyint(4) NOT NULL DEFAULT 1,
  `two_factor_secret` varchar(191) DEFAULT NULL,
  `two_factor_expires_at` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_school_id_foreign` (`school_id`),
  CONSTRAINT `users_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'super','admin','','superadmin@gmail.com','$2y$10$T5MpdjVz5Wuf2WWRD76GjekHt.efXfS20.DiKoywzO0mgvKP7nzye','male','logo.svg',NULL,NULL,NULL,NULL,1,0,NULL,NULL,'en',NULL,'2025-12-09 19:02:54',0,NULL,NULL,'2025-12-09 19:02:54','2026-01-11 23:35:19',NULL),(2,'Demo','Admin','1234567890','demo@school.com','$2y$10$GttNZGtcoYsu8Pyrj89M6.0hGmys2mdwtI5WhYbdlzhFlCsU8g0XW',NULL,'dummy_logo.jpg',NULL,NULL,NULL,NULL,1,0,NULL,1,'en',NULL,'2025-12-10 15:23:47',0,NULL,NULL,'2025-12-10 15:23:47','2025-12-10 19:56:04',NULL),(3,'School','Admin','09392511176','saisuppu1@gmail.com','$2y$10$NmeDitfDXkvFz74Y3Cxoy.sqbfo9fQLykDOTzJcwJMY3TYWdptyj6',NULL,'',NULL,NULL,NULL,NULL,1,0,NULL,2,'en',NULL,'2025-12-11 18:02:58',0,NULL,NULL,'2025-12-10 19:26:30','2025-12-11 15:58:53',NULL),(4,'School','Admin','7207971984','mmtsofttech@gmail.com','$2y$10$VwlnVhq88V9f.ERgcxHr5O78bg3afYyBrlVkYU0l9f3KiOv1Y9Mrm',NULL,'super-admin/user/69397e59a8ff30.098231871765375577.png',NULL,NULL,NULL,NULL,1,0,NULL,3,'en',NULL,NULL,0,NULL,NULL,'2025-12-10 19:36:17','2025-12-10 19:36:17',NULL),(5,'School','Admin','789456321','x@gmail.com','$2y$10$jFJ31NS3Bl2S3Hl5Pd.kNO.YOVOoXbuPXgNZmnKbg5ANcgg./sFX2',NULL,'super-admin/user/693983e79e6931.602273561765376999.png',NULL,NULL,NULL,NULL,1,0,NULL,4,'en',NULL,NULL,0,NULL,NULL,'2025-12-10 19:59:59','2025-12-16 16:20:16','2025-12-16 16:20:16'),(7,'School','Admin','8179709818','info@sarthakedge.com','$2y$10$1fLQ6Lo0cpcPVRjyHeIPfuf/y6q69oWz1ll8gQjwIceRKX8SYa/yC',NULL,'super-admin/user/694645d75b2e78.065387951766213079.png',NULL,NULL,NULL,NULL,1,0,NULL,6,'en',NULL,'2025-12-20 12:18:03',0,NULL,NULL,'2025-12-20 12:14:39','2025-12-20 12:14:39',NULL),(8,'sarthakedge','admin','123456789','info1@sarthakedge.com','$2y$10$6aq8dypM5.bcFHcy.VCA0e6H1.vSY4Unbqz6onXNLYu3x/CoCbLe.','male',NULL,'2000-03-05','Hyderabad','Hyderabad',NULL,1,0,NULL,NULL,'en',NULL,NULL,0,NULL,NULL,'2026-01-13 12:18:02','2026-01-14 20:52:01',NULL),(9,'sarthak','edge','789456123','sarthak@gmail.com','$2y$10$SW3zaKgRZ0KXAJZuOoM0Heq09n6jREk9G78gdCJaWUcqrhNOQT6NS',NULL,NULL,'2000-05-03',NULL,NULL,NULL,1,0,NULL,NULL,'en',NULL,NULL,0,NULL,NULL,'2026-01-14 20:54:35','2026-01-14 20:54:35',NULL),(10,'School','Admin','09392511176','bizbyaravind@gmail.com','$2y$10$zINFUgdkqZg37PIBpnx.2eRMkQk8gr9Vwc1wqVrsm5rrY4AIHbQke',NULL,'super-admin/user/6984bc78c69293.736395021770306680.png',NULL,NULL,NULL,NULL,1,0,NULL,7,'en',NULL,NULL,0,NULL,NULL,'2026-02-05 15:51:20','2026-02-05 15:51:20',NULL);
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

-- Dump completed on 2026-02-16 22:40:23
