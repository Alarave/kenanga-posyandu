-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: posyandu_db
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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `action_type` varchar(255) NOT NULL,
  `entity_type` varchar(255) DEFAULT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_action_index` (`user_id`,`action_type`),
  KEY `activity_logs_model_type_model_id_index` (`entity_type`,`entity_id`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,12,'Ibu Arimbi','superadmin','update','App\\Models\\Article',1,'Memperbarui data Article','{\"content\":\"<p>Pelayanan rutin Posyandu terus ditingkatkan untuk memastikan tumbuh kembang anak yang optimal dan kesehatan ibu yang terjaga. Melalui berbagai program seperti imunisasi, pemberian vitamin, dan edukasi gizi, Posyandu menjadi garda terdepan dalam menciptakan generasi yang sehat dan kuat.<\\/p><p>Pemeriksaan rutin setiap bulan sangat penting untuk memantau perkembangan berat badan dan tinggi badan anak, serta memberikan konseling gizi kepada para ibu.<\\/p>\",\"thumbnail\":null,\"slug\":\"menjaga-kesehatan-ibu-dan-anak\",\"updated_at\":\"2026-06-30T04:30:03.000000Z\"}','{\"content\":\"[{\\\"type\\\":\\\"paragraph\\\",\\\"content\\\":\\\"<p>Pelayanan rutin Posyandu terus ditingkatkan untuk memastikan tumbuh kembang anak yang optimal dan kesehatan ibu yang terjaga. Melalui berbagai program seperti imunisasi, pemberian vitamin, dan edukasi gizi, Posyandu menjadi garda terdepan dalam menciptakan generasi yang sehat dan kuat.<\\/p><p>Pemeriksaan rutin setiap bulan sangat penting untuk memantau perkembangan berat badan dan tinggi badan anak, serta memberikan konseling gizi kepada para ibu.<\\/p>\\\"}]\",\"thumbnail\":\"articles\\/MGrXd6GKefS12YCBLkszq5nXAGC9Orb2NKT5r3Pg.png\",\"slug\":\"menjaga-kesehatan-ibu-dan-anak-peran-posyandu-dalam-masyarakat\",\"updated_at\":\"2026-06-30 11:40:25\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-30 04:40:25',NULL),(2,12,'Ibu Arimbi','superadmin','update','App\\Models\\Article',2,'Memperbarui data Article','{\"content\":\"<p>Panduan gizi penting selama masa kehamilan agar ibu dan janin tetap sehat dan bertenaga sepanjang hari. MPASI yang sehat harus mengandung nutrisi makro dan mikro yang seimbang, mulai dari karbohidrat, protein hewani, hingga lemak sehat.<\\/p>\",\"thumbnail\":null,\"slug\":\"menu-sehat-mpasi-terbaik\",\"updated_at\":\"2026-06-30T04:30:03.000000Z\"}','{\"content\":\"[{\\\"type\\\":\\\"paragraph\\\",\\\"content\\\":\\\"<p>Panduan gizi penting selama masa kehamilan agar ibu dan janin tetap sehat dan bertenaga sepanjang hari. MPASI yang sehat harus mengandung nutrisi makro dan mikro yang seimbang, mulai dari karbohidrat, protein hewani, hingga lemak sehat.<\\/p>\\\"}]\",\"thumbnail\":\"articles\\/AQIb6xWiFzqb5LbtmmNjwZASIMYRWO5FknyrpJcU.png\",\"slug\":\"menu-sehat-pendamping-asi-mpasi-terbaik\",\"updated_at\":\"2026-06-30 11:43:54\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-30 04:43:54',NULL),(3,12,'Ibu Arimbi','superadmin','update','App\\Models\\Article',5,'Memperbarui data Article','{\"content\":\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.<\\/p>\",\"thumbnail\":null,\"slug\":\"tips-kesehatan-keluarga-2\",\"updated_at\":\"2026-06-30T04:30:03.000000Z\"}','{\"content\":\"[{\\\"type\\\":\\\"paragraph\\\",\\\"content\\\":\\\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.<\\/p>\\\"}]\",\"thumbnail\":\"articles\\/edsdysqDdeORd0VkxrRilHxUForOygDdPymScBvE.png\",\"slug\":\"tips-kesehatan-keluarga-bagian-2\",\"updated_at\":\"2026-06-30 11:47:57\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-30 04:47:57',NULL),(4,12,'Ibu Arimbi','superadmin','update','App\\Models\\Article',4,'Memperbarui data Article','{\"content\":\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.<\\/p>\",\"thumbnail\":null,\"slug\":\"tips-kesehatan-keluarga-1\",\"updated_at\":\"2026-06-30T04:30:03.000000Z\"}','{\"content\":\"[{\\\"type\\\":\\\"paragraph\\\",\\\"content\\\":\\\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.<\\/p>\\\"}]\",\"thumbnail\":\"articles\\/FkioJITwfL0Cw2MdZzk0CcJ52MdOwTiuZSoKRXCs.jpg\",\"slug\":\"tips-kesehatan-keluarga-bagian-1\",\"updated_at\":\"2026-06-30 11:49:15\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-30 04:49:15',NULL),(5,12,'Ibu Arimbi','superadmin','update','App\\Models\\Article',3,'Memperbarui data Article','{\"content\":\"<p>Imunisasi adalah cara terbaik untuk melindungi anak dari berbagai penyakit berbahaya yang dapat dicegah. Pastikan anak Anda mendapatkan jadwal imunisasi yang lengkap sesuai anjuran tenaga kesehatan di Posyandu terdekat.<\\/p>\",\"thumbnail\":null,\"updated_at\":\"2026-06-30T04:30:03.000000Z\"}','{\"content\":\"[{\\\"type\\\":\\\"paragraph\\\",\\\"content\\\":\\\"<p>Imunisasi adalah cara terbaik untuk melindungi anak dari berbagai penyakit berbahaya yang dapat dicegah. Pastikan anak Anda mendapatkan jadwal imunisasi yang lengkap sesuai anjuran tenaga kesehatan di Posyandu terdekat.<\\/p>\\\"}]\",\"thumbnail\":\"articles\\/CvanpYGFdbmSG9iY3DNrm38RFh1khVD64unx1VrW.jpg\",\"updated_at\":\"2026-06-30 11:51:38\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-30 04:51:38',NULL),(6,12,'Ibu Arimbi','superadmin','update','App\\Models\\Article',6,'Memperbarui data Article','{\"content\":\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.<\\/p>\",\"thumbnail\":null,\"slug\":\"tips-kesehatan-keluarga-3\",\"updated_at\":\"2026-06-30T04:30:03.000000Z\"}','{\"content\":\"[{\\\"type\\\":\\\"paragraph\\\",\\\"content\\\":\\\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.<\\/p>\\\"}]\",\"thumbnail\":\"articles\\/z4QRRsiAJUyeMZZNWFplVxfVJbRrzY5eZjFc3Mgx.jpg\",\"slug\":\"tips-kesehatan-keluarga-bagian-3\",\"updated_at\":\"2026-06-30 11:53:27\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-30 04:53:27',NULL);
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_snapshots`
--

DROP TABLE IF EXISTS `analytics_snapshots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analytics_snapshots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posyandu_id` bigint(20) unsigned DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `last_computed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_snapshots_posyandu_id_key_index` (`posyandu_id`,`key`),
  CONSTRAINT `analytics_snapshots_posyandu_id_foreign` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_snapshots`
--

LOCK TABLES `analytics_snapshots` WRITE;
/*!40000 ALTER TABLE `analytics_snapshots` DISABLE KEYS */;
INSERT INTO `analytics_snapshots` VALUES (3,NULL,'year_2026','{\"analytics_data\":{\"totalBalita\":51,\"totalIbuHamil\":5,\"totalLansia\":22,\"totalKunjungan\":147,\"kaderAktif\":14,\"trendLabels\":[\"Jan\",\"Feb\",\"Mar\",\"Apr\",\"Mei\",\"Jun\",\"Jul\",\"Agt\",\"Sep\",\"Okt\",\"Nov\",\"Des\"],\"trendVisitsBalita\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendVisitsIbuHamil\":[0,1,3,3,3,5,0,0,0,0,0,0],\"trendVisitsLansia\":[22,22,22,22,22,22,0,0,0,0,0,0],\"stuntingRate\":0,\"cakupanImunisasi\":0,\"trendNormal\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendStunting\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendRisk\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendAvgWeight\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendAvgHeight\":[0,0,0,0,0,0,0,0,0,0,0,0],\"nutritionLabels\":[],\"nutritionData\":[],\"stuntingByPosyandu\":[{\"name\":\"KENANGA 1\",\"rate\":0,\"stunting\":0,\"total\":0,\"width\":0,\"color\":\"bg-green-500\",\"text\":\"text-green-600\"},{\"name\":\"KENANGA 2\",\"rate\":0,\"stunting\":0,\"total\":0,\"width\":0,\"color\":\"bg-green-500\",\"text\":\"text-green-600\"}],\"usia0_12\":0,\"usia12_24\":0,\"usia24plus\":0,\"vaccineLabels\":[\"HB-0\",\"BCG\",\"Polio 1\",\"Polio 2\",\"Polio 3\",\"Polio 4\",\"DPT-HB-Hib 1\",\"DPT-HB-Hib 2\",\"DPT-HB-Hib 3\",\"PCV 1\",\"PCV 2\",\"PCV 3\",\"RV 1\",\"RV 2\",\"RV 3\",\"IPV 1\",\"IPV 2\",\"MR\"],\"vaccineData\":[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],\"hypertensionRiskRate\":20,\"feComplianceRate\":0,\"trendPregnancyHypertension\":[0,0,0,0,0,40,0,0,0,0,0,0],\"trendPregnancyFe\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendPregnancyAvgWeightGain\":[0,0,0,0,0,0,0,0,0,0,0,0],\"trendPregnancyAvgLila\":[0,0,0,0,0,0,0,0,0,0,0,0],\"lansiaHypertensionRate\":31.8,\"lansiaHyperglycemiaRate\":9.1,\"lansiaHypercholesterolemiaRate\":40.9,\"lansiaHyperuricemiaRate\":18.2,\"trendLansiaHypertension\":[31.8,40.9,40.9,54.5,27.3,31.8,0,0,0,0,0,0],\"trendLansiaHyperglycemia\":[4.5,18.2,22.7,18.2,31.8,9.1,0,0,0,0,0,0],\"trendLansiaHypercholesterolemia\":[36.4,22.7,13.6,31.8,31.8,40.9,0,0,0,0,0,0],\"trendLansiaHyperuricemia\":[9.1,31.8,22.7,18.2,18.2,18.2,0,0,0,0,0,0],\"trendLansiaAvgSystolic\":[130.3,135,134.5,138.2,129.3,130,0,0,0,0,0,0],\"trendLansiaAvgDiastolic\":[79.5,84.8,81,83.2,78.3,80,0,0,0,0,0,0],\"trendLansiaAvgBloodSugar\":[142.5,136.8,149.3,148.9,163,132.2,0,0,0,0,0,0],\"trendLansiaAvgUricAcid\":[4.94,5.93,5.84,5.51,5.08,5.36,0,0,0,0,0,0],\"trendLansiaAvgCholesterol\":[194.5,184.4,178.9,192.1,191.4,197.8,0,0,0,0,0,0]},\"dashboard_stats\":{\"totalBalita\":51,\"totalIbuHamil\":5,\"totalRemaja\":0,\"totalLansia\":22,\"kunjunganBaru\":27,\"totalPemeriksaan\":147,\"totalImunisasi\":0,\"nutritionStatusDistribution\":{\"labels\":[],\"data\":[]},\"monthlyWeighingData\":{\"labels\":[\"Jul 2025\",\"Agt 2025\",\"Sep 2025\",\"Okt 2025\",\"Nov 2025\",\"Des 2025\",\"Jan 2026\",\"Mar 2026\",\"Mar 2026\",\"Apr 2026\",\"Mei 2026\",\"Jun 2026\"],\"data\":[0,0,0,0,0,0,22,25,25,25,25,27]},\"lansiaDemografi\":{\"60_69\":7,\"70_plus\":15},\"bumilTrimester\":{\"T1\":2,\"T2\":2,\"T3\":1},\"kehadiranBalita\":{\"hadir\":0,\"tidak_hadir\":51,\"persentase\":0},\"kelahiranBulanIni\":0}}','2026-06-30 04:31:03','2026-06-30 04:31:03','2026-06-30 04:31:03');
/*!40000 ALTER TABLE `analytics_snapshots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `content` text NOT NULL,
  `content_blocks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`content_blocks`)),
  `thumbnail` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_user_id_foreign` (`user_id`),
  KEY `articles_category_id_foreign` (`category_id`),
  CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,1,1,'Menjaga Kesehatan Ibu dan Anak: Peran Posyandu dalam Masyarakat',NULL,'[{\"type\":\"paragraph\",\"content\":\"<p>Pelayanan rutin Posyandu terus ditingkatkan untuk memastikan tumbuh kembang anak yang optimal dan kesehatan ibu yang terjaga. Melalui berbagai program seperti imunisasi, pemberian vitamin, dan edukasi gizi, Posyandu menjadi garda terdepan dalam menciptakan generasi yang sehat dan kuat.</p><p>Pemeriksaan rutin setiap bulan sangat penting untuk memantau perkembangan berat badan dan tinggi badan anak, serta memberikan konseling gizi kepada para ibu.</p>\"}]',NULL,'articles/MGrXd6GKefS12YCBLkszq5nXAGC9Orb2NKT5r3Pg.png','menjaga-kesehatan-ibu-dan-anak-peran-posyandu-dalam-masyarakat','published','2026-06-30 04:30:03','2026-06-30 04:30:03','2026-06-30 04:40:25'),(2,1,2,'Menu Sehat Pendamping ASI (MPASI) Terbaik',NULL,'[{\"type\":\"paragraph\",\"content\":\"<p>Panduan gizi penting selama masa kehamilan agar ibu dan janin tetap sehat dan bertenaga sepanjang hari. MPASI yang sehat harus mengandung nutrisi makro dan mikro yang seimbang, mulai dari karbohidrat, protein hewani, hingga lemak sehat.</p>\"}]',NULL,'articles/AQIb6xWiFzqb5LbtmmNjwZASIMYRWO5FknyrpJcU.png','menu-sehat-pendamping-asi-mpasi-terbaik','published','2026-06-29 04:30:03','2026-06-30 04:30:03','2026-06-30 04:43:54'),(3,1,3,'Pentingnya Imunisasi Dasar Lengkap',NULL,'[{\"type\":\"paragraph\",\"content\":\"<p>Imunisasi adalah cara terbaik untuk melindungi anak dari berbagai penyakit berbahaya yang dapat dicegah. Pastikan anak Anda mendapatkan jadwal imunisasi yang lengkap sesuai anjuran tenaga kesehatan di Posyandu terdekat.</p>\"}]',NULL,'articles/CvanpYGFdbmSG9iY3DNrm38RFh1khVD64unx1VrW.jpg','pentingnya-imunisasi-dasar-lengkap','published','2026-06-28 04:30:03','2026-06-30 04:30:03','2026-06-30 04:51:38'),(4,1,1,'Tips Kesehatan Keluarga Bagian 1',NULL,'[{\"type\":\"paragraph\",\"content\":\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.</p>\"}]',NULL,'articles/FkioJITwfL0Cw2MdZzk0CcJ52MdOwTiuZSoKRXCs.jpg','tips-kesehatan-keluarga-bagian-1','published','2026-06-27 04:30:03','2026-06-30 04:30:03','2026-06-30 04:49:15'),(5,1,3,'Tips Kesehatan Keluarga Bagian 2',NULL,'[{\"type\":\"paragraph\",\"content\":\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.</p>\"}]',NULL,'articles/edsdysqDdeORd0VkxrRilHxUForOygDdPymScBvE.png','tips-kesehatan-keluarga-bagian-2','published','2026-06-26 04:30:03','2026-06-30 04:30:03','2026-06-30 04:47:57'),(6,1,3,'Tips Kesehatan Keluarga Bagian 3',NULL,'[{\"type\":\"paragraph\",\"content\":\"<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.</p>\"}]',NULL,'articles/z4QRRsiAJUyeMZZNWFplVxfVJbRrzY5eZjFc3Mgx.jpg','tips-kesehatan-keluarga-bagian-3','published','2026-06-25 04:30:03','2026-06-30 04:30:03','2026-06-30 04:53:27'),(7,1,1,'Tips Kesehatan Keluarga Bagian 4',NULL,'<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.</p>',NULL,NULL,'tips-kesehatan-keluarga-4','published','2026-06-24 04:30:03','2026-06-30 04:30:03','2026-06-30 04:30:03'),(8,1,4,'Tips Kesehatan Keluarga Bagian 5',NULL,'<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.</p>',NULL,NULL,'tips-kesehatan-keluarga-5','published','2026-06-23 04:30:03','2026-06-30 04:30:03','2026-06-30 04:30:03'),(9,1,1,'Tips Kesehatan Keluarga Bagian 6',NULL,'<p>Ini adalah artikel edukasi kesehatan untuk memberikan wawasan lebih mendalam tentang pola hidup sehat di lingkungan keluarga.</p>',NULL,NULL,'tips-kesehatan-keluarga-6','published','2026-06-22 04:30:03','2026-06-30 04:30:03','2026-06-30 04:30:03');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('posyandu_cache_5c785c036466adea360111aa28563bfd556b5fba','i:1;',1782794180),('posyandu_cache_5c785c036466adea360111aa28563bfd556b5fba:timer','i:1782794180;',1782794180),('posyandu_cache_7b52009b64fd0a2a49e6d8a939753077792b0554','i:1;',1782795261),('posyandu_cache_7b52009b64fd0a2a49e6d8a939753077792b0554:timer','i:1782795261;',1782795261);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Kesehatan Ibu','kesehatan-ibu','2026-06-30 04:30:03','2026-06-30 04:30:03'),(2,'Nutrisi & Gizi','nutrisi-gizi','2026-06-30 04:30:03','2026-06-30 04:30:03'),(3,'Tumbuh Kembang','tumbuh-kembang','2026-06-30 04:30:03','2026-06-30 04:30:03'),(4,'Info Layanan','info-layanan','2026-06-30 04:30:03','2026-06-30 04:30:03');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `child_developments`
--

DROP TABLE IF EXISTS `child_developments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `child_developments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medical_record_id` bigint(20) unsigned NOT NULL,
  `age_group_months` int(11) NOT NULL COMMENT 'Bulan usia untuk target KPSP (misal: 3, 6, 9, 12, dst)',
  `motor_gross` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Motorik Kasar',
  `motor_fine` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Motorik Halus',
  `language` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Bahasa / Bicara',
  `social` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Sosialisasi / Kemandirian',
  `development_status` enum('Sesuai','Meragukan','Penyimpangan') DEFAULT NULL COMMENT 'Kesimpulan Perkembangan',
  `note` text DEFAULT NULL COMMENT 'Catatan tambahan perkembangan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `child_developments_medical_record_id_foreign` (`medical_record_id`),
  CONSTRAINT `child_developments_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `child_developments`
--

LOCK TABLES `child_developments` WRITE;
/*!40000 ALTER TABLE `child_developments` DISABLE KEYS */;
/*!40000 ALTER TABLE `child_developments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posyandu_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `gallery_folder_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `photo` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_posyandu_id_foreign` (`posyandu_id`),
  KEY `galleries_user_id_foreign` (`user_id`),
  KEY `galleries_gallery_folder_id_foreign` (`gallery_folder_id`),
  CONSTRAINT `galleries_gallery_folder_id_foreign` FOREIGN KEY (`gallery_folder_id`) REFERENCES `gallery_folders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `galleries_posyandu_id_foreign` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `galleries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,1,2,NULL,'Kegiatan Posyandu Januari','Foto-foto kegiatan posyandu bulan Januari','kegiatan-januari.jpg','activity','2026-06-30 04:30:03','2026-06-30 04:30:03'),(2,1,2,NULL,'Imunisasi Campak','Foto kegiatan imunisasi campak','imunisasi-campak.jpg','immunization','2026-06-30 04:30:03','2026-06-30 04:30:03'),(3,2,2,NULL,'Penyuluhan Gizi','Foto kegiatan penyuluhan gizi','penyuluhan-gizi.jpg','education','2026-06-30 04:30:03','2026-06-30 04:30:03');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_folders`
--

DROP TABLE IF EXISTS `gallery_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_folders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posyandu_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_folders_posyandu_id_foreign` (`posyandu_id`),
  KEY `gallery_folders_user_id_foreign` (`user_id`),
  CONSTRAINT `gallery_folders_posyandu_id_foreign` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gallery_folders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_folders`
--

LOCK TABLES `gallery_folders` WRITE;
/*!40000 ALTER TABLE `gallery_folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_records`
--

DROP TABLE IF EXISTS `medical_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `pregnancy_number` int(11) DEFAULT NULL,
  `pregnancy_spacing` varchar(255) DEFAULT NULL,
  `starting_weight` decimal(5,2) DEFAULT NULL,
  `starting_height` decimal(5,2) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_method` varchar(255) DEFAULT NULL,
  `gestational_age` varchar(255) DEFAULT NULL,
  `imt_plotting_status` varchar(255) DEFAULT NULL,
  `lila_plotting_status` varchar(255) DEFAULT NULL,
  `bp_plotting_status` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `visit_date` date NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `imt` decimal(5,2) DEFAULT NULL,
  `weight_status` varchar(100) DEFAULT NULL,
  `kpsp_status` varchar(100) DEFAULT NULL,
  `tbc_screening_cough` tinyint(1) NOT NULL DEFAULT 0,
  `tbc_screening_fever` tinyint(1) NOT NULL DEFAULT 0,
  `tbc_screening_contact` tinyint(1) NOT NULL DEFAULT 0,
  `tbc_screening_weight_loss` tinyint(1) NOT NULL DEFAULT 0,
  `tbc_screening_lethargy` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Anak Lesu / Tidak Aktif',
  `tbc_screening_lumps` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Benjolan di Leher',
  `other_symptoms` text DEFAULT NULL,
  `pmt_given` varchar(255) DEFAULT NULL,
  `counseling_notes` text DEFAULT NULL,
  `education` text DEFAULT NULL,
  `referral_type` varchar(255) NOT NULL DEFAULT 'None',
  `nakes_gives_fe_mms` varchar(255) DEFAULT NULL,
  `consumes_fe_mms_regularly` varchar(255) DEFAULT NULL,
  `nakes_gives_mt_kek` varchar(255) DEFAULT NULL,
  `mt_package_details` varchar(255) DEFAULT NULL,
  `consumes_mt_kek_regularly` varchar(255) DEFAULT NULL,
  `counseling_topic` varchar(255) DEFAULT NULL,
  `joins_pregnant_class` varchar(255) DEFAULT NULL,
  `anc_referral` text DEFAULT NULL,
  `postpartum_period` varchar(255) DEFAULT NULL,
  `postpartum_imt_plotting` varchar(255) DEFAULT NULL,
  `postpartum_bp_plotting` varchar(255) DEFAULT NULL,
  `nakes_gives_vit_a` varchar(255) DEFAULT NULL,
  `vit_a_capsule_count` varchar(255) DEFAULT NULL,
  `consumes_vit_a_regularly` varchar(255) DEFAULT NULL,
  `is_breastfeeding` varchar(255) DEFAULT NULL,
  `postpartum_kb` varchar(255) DEFAULT NULL,
  `postpartum_counseling_topic` varchar(255) DEFAULT NULL,
  `postpartum_referral` text DEFAULT NULL,
  `height` decimal(5,2) NOT NULL,
  `measurement_method` enum('recumbent','standing') NOT NULL DEFAULT 'recumbent',
  `head_circumference` decimal(5,2) DEFAULT NULL,
  `upper_arm_circumference` decimal(5,2) DEFAULT NULL COMMENT 'Lingkar lengan atas dalam cm',
  `waist_circumference` decimal(5,2) DEFAULT NULL,
  `eye_test` varchar(255) DEFAULT NULL,
  `ear_test` varchar(255) DEFAULT NULL,
  `puma_screening` varchar(255) DEFAULT NULL,
  `tbc_screening_status` varchar(255) DEFAULT NULL,
  `mental_screening` varchar(255) DEFAULT NULL,
  `contraception` varchar(255) DEFAULT NULL,
  `family_disease_history` text DEFAULT NULL,
  `risk_behaviors` text DEFAULT NULL,
  `immunization` varchar(255) DEFAULT NULL,
  `vaccine_name` varchar(255) DEFAULT NULL,
  `vaccine_dose` int(11) DEFAULT NULL,
  `is_basic_immunization_complete` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Status Imunisasi Dasar Lengkap',
  `vitamin_a` tinyint(1) NOT NULL DEFAULT 0,
  `vitamin_a_color` enum('biru','merah','none') NOT NULL DEFAULT 'none',
  `deworming_medicine` tinyint(1) NOT NULL DEFAULT 0,
  `pill_fe` tinyint(1) NOT NULL DEFAULT 0,
  `is_exclusive_breastfeeding` tinyint(1) NOT NULL DEFAULT 0,
  `mp_asi` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Pemberian Makanan Pendamping ASI',
  `complaint` text NOT NULL,
  `diagnosis` text NOT NULL,
  `disease_history` text DEFAULT NULL,
  `health_note` text DEFAULT NULL,
  `nutrition_status` varchar(255) DEFAULT NULL,
  `systolic_bp` int(10) unsigned DEFAULT NULL,
  `diastolic_bp` int(10) unsigned DEFAULT NULL,
  `blood_sugar` int(10) unsigned DEFAULT NULL,
  `hemoglobin` decimal(5,2) DEFAULT NULL,
  `uric_acid` decimal(4,2) DEFAULT NULL,
  `cholesterol` int(10) unsigned DEFAULT NULL,
  `current_medication` text DEFAULT NULL,
  `stunting_status` varchar(100) DEFAULT NULL,
  `wasting_status` varchar(100) DEFAULT NULL,
  `z_score` decimal(5,2) DEFAULT NULL COMMENT 'Z-score BB/U WHO/Kemenkes',
  `z_score_hfa` decimal(5,2) DEFAULT NULL COMMENT 'Z-Score Height-for-Age (stunting)',
  `z_score_wfh` decimal(5,2) DEFAULT NULL COMMENT 'Z-Score Weight-for-Height (wasting)',
  `z_score_bfa` decimal(5,2) DEFAULT NULL COMMENT 'Z-Score BMI-for-Age (obesitas)',
  `nutrition_trend` enum('naik','turun','tetap') DEFAULT NULL COMMENT 'Tren vs bulan sebelumnya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_records_patient_id_foreign` (`patient_id`),
  KEY `medical_records_user_id_foreign` (`user_id`),
  KEY `medical_records_visit_date_index` (`visit_date`),
  CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medical_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_records`
--

LOCK TABLES `medical_records` WRITE;
/*!40000 ALTER TABLE `medical_records` DISABLE KEYS */;
INSERT INTO `medical_records` VALUES (1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-01-10',65.50,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal di punggung','Pemantauan',NULL,NULL,NULL,139,84,138,NULL,5.30,174,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:03','2026-06-30 04:30:03'),(2,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-01-10',60.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Tidak ada keluhan','Sehat',NULL,NULL,NULL,117,80,110,NULL,4.40,191,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:03','2026-06-30 04:30:03'),(3,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-02-10',64.50,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal di punggung','Pemantauan',NULL,NULL,NULL,127,80,115,NULL,5.30,174,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(4,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-02-10',57.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Tidak ada keluhan','Sehat',NULL,NULL,NULL,112,77,107,NULL,4.50,186,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(5,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-03-10',66.50,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal di punggung','Pemantauan',NULL,NULL,NULL,130,83,136,NULL,5.80,178,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(6,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-03-10',58.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Tidak ada keluhan','Sehat',NULL,NULL,NULL,121,85,100,NULL,3.80,196,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(7,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-04-10',65.50,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal di punggung','Pemantauan',NULL,NULL,NULL,134,87,139,NULL,5.80,188,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(8,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-04-10',57.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Tidak ada keluhan','Sehat',NULL,NULL,NULL,110,77,103,NULL,4.30,188,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(9,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-05-10',64.50,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal di punggung','Pemantauan',NULL,NULL,NULL,144,83,140,NULL,6.20,176,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(10,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-05-10',57.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Tidak ada keluhan','Sehat',NULL,NULL,NULL,124,80,107,NULL,4.60,187,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(11,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-06-10',63.50,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal di punggung','Pemantauan',NULL,NULL,NULL,139,89,129,NULL,5.80,170,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(12,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,'2026-06-10',57.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Tidak ada keluhan','Sehat',NULL,NULL,NULL,111,80,100,NULL,3.70,192,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(13,54,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-05',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,152,88,293,NULL,3.50,274,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(14,54,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-09',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,158.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,149,103,256,NULL,6.80,185,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(15,54,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-09',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,166.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,174,103,112,NULL,3.60,187,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(16,54,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-11',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,114,67,133,NULL,6.40,158,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(17,54,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-02',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,163.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,132,99,126,NULL,3.60,187,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(18,54,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-04',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,136,107,101,NULL,6.10,263,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(19,55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-09',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,69,165,NULL,4.00,146,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(20,55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-05',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,132,110,136,NULL,6.40,143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(21,55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-02',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,173,97,127,NULL,6.00,213,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(22,55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-03',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,177,85,97,NULL,3.30,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(23,55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-09',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,166.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,153,97,295,NULL,5.70,165,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(24,55,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-12',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,168,88,137,NULL,5.00,173,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(25,56,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-19',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,156.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,180,102,92,NULL,3.60,166,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(26,56,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-06',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,158.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,125,78,122,NULL,3.30,164,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(27,56,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-15',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,158.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,121,75,92,NULL,4.70,231,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(28,56,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-05',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,154.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,131,99,136,NULL,5.70,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(29,56,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-05',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,157.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,114,77,190,NULL,3.30,165,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(30,56,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-12',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,161.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,157,101,102,NULL,7.80,234,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(31,57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-20',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,161.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,117,69,136,NULL,5.30,236,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(32,57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-20',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,168.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,129,70,91,NULL,5.10,184,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(33,57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-17',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,154,82,293,NULL,5.50,143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(34,57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-28',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,159.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,156,107,101,NULL,3.10,153,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(35,57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-07',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,124,65,137,NULL,5.30,277,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(36,57,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-27',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,137,99,99,NULL,3.20,143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(37,58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-16',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,140,88,125,NULL,4.00,176,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(38,58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-14',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,69,134,NULL,9.70,174,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(39,58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-14',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,166.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,113,69,139,NULL,3.80,194,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(40,58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-10',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,122,65,98,NULL,4.30,162,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(41,58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-04',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,119,72,130,NULL,4.20,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(42,58,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-12',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,131,107,112,NULL,3.10,206,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(43,59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-15',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,124,64,185,NULL,3.40,208,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(44,59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-13',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,161.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,160,102,104,NULL,4.10,167,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(45,59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-14',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,146,80,107,NULL,6.10,142,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(46,59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-08',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,114,66,179,NULL,5.60,184,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(47,59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-10',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,124,66,208,NULL,3.00,144,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(48,59,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-10',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,158.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,127,67,108,NULL,4.60,275,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(49,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-24',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,163.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,128,62,178,NULL,5.00,196,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(50,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-09',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,170,97,130,NULL,5.40,184,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(51,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-13',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,118,61,138,NULL,7.90,144,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(52,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-24',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,138,109,200,NULL,5.70,179,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(53,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-12',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,117,79,282,NULL,3.70,169,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(54,60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-14',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,154.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,113,68,97,NULL,4.50,213,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(55,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-06',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,111,68,132,NULL,5.90,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(56,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-12',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,148,107,235,NULL,4.10,141,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(57,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-17',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,146,81,92,NULL,8.80,181,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(58,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-24',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,167,89,149,NULL,3.00,177,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(59,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-11',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,123,67,243,NULL,3.30,220,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(60,61,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-19',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,112,64,90,NULL,4.60,201,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(61,62,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-21',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,125,75,105,NULL,7.80,249,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(62,62,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-16',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,127,72,136,NULL,7.30,202,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(63,62,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-12',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,134,107,141,NULL,4.20,141,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(64,62,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-14',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,117,65,133,NULL,9.90,174,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(65,62,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-01',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,149,95,92,NULL,9.00,149,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(66,62,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-23',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,157.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,129,70,135,NULL,5.10,180,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(67,63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-23',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,122,72,198,NULL,5.30,203,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(68,63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-17',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,129,78,95,NULL,7.10,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(69,63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-15',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,123,69,133,NULL,5.80,183,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(70,63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-12',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,159,87,265,NULL,9.50,172,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(71,63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-25',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,166.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,61,131,NULL,5.10,260,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(72,63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-06',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,156.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,66,133,NULL,7.30,152,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(73,64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-03',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,159.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,130,108,146,NULL,3.30,226,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(74,64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-01',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,126,75,265,NULL,9.00,151,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(75,64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-12',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,159.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,118,63,285,NULL,8.30,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(76,64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-16',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,127,62,261,NULL,5.80,198,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(77,64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-08',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,157,109,119,NULL,3.40,169,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(78,64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-01',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,163.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,77,157,NULL,7.40,147,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(79,65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-11',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,156.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,125,78,190,NULL,5.40,298,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(80,65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-13',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,129,74,222,NULL,3.80,145,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(81,65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-20',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,159,109,125,NULL,3.40,188,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(82,65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-10',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,176,85,150,NULL,6.40,224,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(83,65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-09',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,117,73,260,NULL,8.40,200,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(84,65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-07',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,157.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,69,214,NULL,9.90,146,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(85,66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-19',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,121,71,99,NULL,9.00,174,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(86,66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-21',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,147,101,122,NULL,9.80,160,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(87,66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-04',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,154.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,119,67,276,NULL,9.70,186,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(88,66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-19',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,159,88,104,NULL,4.70,155,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(89,66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-05',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,167,81,121,NULL,4.00,145,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(90,66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-11',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,77,123,NULL,3.70,152,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(91,67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-05',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,143,96,109,NULL,3.20,164,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(92,67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-10',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,163,100,91,NULL,7.00,158,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(93,67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-10',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,151.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,123,78,202,NULL,3.90,287,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(94,67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-28',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,170.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,137,108,90,NULL,4.90,220,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(95,67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-15',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,157.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,118,71,212,NULL,7.60,155,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(96,67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-24',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,124,66,125,NULL,5.70,281,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(97,68,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-12',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,120,64,98,NULL,4.30,141,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(98,68,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-06',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,163.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,139,106,97,NULL,7.30,187,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(99,68,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-21',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,113,66,92,NULL,5.70,168,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(100,68,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-23',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,150.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,148,105,131,NULL,8.90,239,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(101,68,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-14',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,161.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,119,68,124,NULL,5.60,292,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(102,68,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-04',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,173,105,136,NULL,5.80,292,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(103,69,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-18',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,166.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,123,69,128,NULL,6.00,178,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(104,69,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-01',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,128,74,92,NULL,4.90,215,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(105,69,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-16',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,121,63,105,NULL,6.20,143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(106,69,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-12',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,154.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,162,87,160,NULL,4.60,229,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(107,69,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-16',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,165.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,125,78,93,NULL,4.40,258,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(108,69,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-07',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,166.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,113,65,296,NULL,5.60,150,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(109,70,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-12',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,164.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,68,151,NULL,5.70,201,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(110,70,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-14',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,113,63,92,NULL,5.30,272,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(111,70,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-20',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,135,108,144,NULL,5.60,177,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(112,70,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-17',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,158.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,116,61,126,NULL,3.30,272,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(113,70,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-01',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,127,77,121,NULL,3.00,181,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(114,70,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-06',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,170.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,110,65,124,NULL,5.50,281,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(115,71,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-23',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,121,71,158,NULL,5.10,186,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(116,71,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-15',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,123,75,130,NULL,3.20,170,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(117,71,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-08',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,126,62,109,NULL,4.10,198,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(118,71,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-28',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,159.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,131,93,118,NULL,4.70,267,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(119,71,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-03',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,170.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,127,74,108,NULL,5.50,267,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(120,71,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-03',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,158,85,115,NULL,5.60,161,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(121,72,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-10',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,156.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,156,92,103,NULL,3.20,170,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(122,72,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-04',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,160.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,120,68,125,NULL,5.50,282,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(123,72,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-06',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,159.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,173,101,200,NULL,9.70,142,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(124,72,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-19',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,150.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,127,66,294,NULL,7.60,251,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(125,72,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-24',45.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,128,73,245,NULL,5.70,153,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(126,72,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-14',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,152.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,134,82,132,NULL,4.20,176,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(127,73,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-01-11',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,153.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pusing','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,140,110,97,NULL,5.90,176,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(128,73,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-02-10',75.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,167.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,157,87,113,NULL,5.50,265,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(129,73,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-03-26',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,157.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,120,74,136,NULL,5.80,167,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(130,73,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-04-04',55.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,161.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,119,73,108,NULL,3.70,143,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(131,73,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-05-27',65.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,170.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Cepat Lelah','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,121,77,101,NULL,7.20,144,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(132,73,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2026-06-05',85.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,170.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'Pegal linu','-',NULL,'Pemeriksaan rutin posyandu lansia',NULL,123,62,144,NULL,3.70,163,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(133,74,NULL,NULL,NULL,NULL,NULL,NULL,'10',NULL,NULL,NULL,1,'2026-06-29',65.80,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,147.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,129,87,NULL,11.40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(134,74,NULL,NULL,NULL,NULL,NULL,NULL,'17',NULL,NULL,NULL,1,'2026-05-27',52.00,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,127,87,NULL,9.30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(135,74,NULL,NULL,NULL,NULL,NULL,NULL,'23',NULL,NULL,NULL,1,'2026-04-29',62.60,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,162.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,125,79,NULL,13.30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(136,74,NULL,NULL,NULL,NULL,NULL,NULL,'36',NULL,NULL,NULL,1,'2026-03-29',70.30,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,149.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,137,71,NULL,13.60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(137,75,NULL,NULL,NULL,NULL,NULL,NULL,'15',NULL,NULL,NULL,1,'2026-06-26',66.70,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,145.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,140,78,NULL,11.30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(138,76,NULL,NULL,NULL,NULL,NULL,NULL,'36',NULL,NULL,NULL,1,'2026-06-28',71.40,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,149.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,108,73,NULL,12.80,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(139,76,NULL,NULL,NULL,NULL,NULL,NULL,'26',NULL,NULL,NULL,1,'2026-05-28',65.10,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,163.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,116,71,NULL,11.40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(140,76,NULL,NULL,NULL,NULL,NULL,NULL,'36',NULL,NULL,NULL,1,'2026-04-26',64.10,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,169.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,126,87,NULL,11.60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(141,76,NULL,NULL,NULL,NULL,NULL,NULL,'34',NULL,NULL,NULL,1,'2026-03-27',70.70,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,145.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,118,79,NULL,9.60,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(142,76,NULL,NULL,NULL,NULL,NULL,NULL,'26',NULL,NULL,NULL,1,'2026-02-25',80.80,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,157.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,132,80,NULL,13.10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(143,77,NULL,NULL,NULL,NULL,NULL,NULL,'11',NULL,NULL,NULL,1,'2026-06-29',71.30,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,168.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,106,77,NULL,12.90,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(144,78,NULL,NULL,NULL,NULL,NULL,NULL,'34',NULL,NULL,NULL,1,'2026-06-26',66.20,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,156.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,140,74,NULL,9.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(145,78,NULL,NULL,NULL,NULL,NULL,NULL,'20',NULL,NULL,NULL,1,'2026-05-26',69.90,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,148.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,133,81,NULL,13.50,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(146,78,NULL,NULL,NULL,NULL,NULL,NULL,'12',NULL,NULL,NULL,1,'2026-04-25',69.90,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,146.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,134,77,NULL,10.50,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:10','2026-06-30 04:30:10'),(147,78,NULL,NULL,NULL,NULL,NULL,NULL,'10',NULL,NULL,NULL,1,'2026-03-29',72.30,NULL,NULL,NULL,0,0,0,0,0,0,NULL,NULL,NULL,NULL,'None','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,155.00,'recumbent',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'none',0,0,0,0,'-','-',NULL,'-',NULL,124,77,NULL,9.30,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:10','2026-06-30 04:30:10');
/*!40000 ALTER TABLE `medical_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_07_13_042020_create_pedukuhans_table',1),(4,'2025_07_13_042021_create_posyandus_table',1),(5,'2025_07_13_042022_create_users_table',1),(6,'2025_07_13_042023_create_schedules_table',1),(7,'2025_07_13_042024_create_galleries_table',1),(8,'2025_07_13_042025_create_patients_table',1),(9,'2025_07_13_042026_create_articles_table',1),(10,'2025_07_13_042027_create_medical_records_table',1),(11,'2025_07_13_042028_create_activity_logs_table',1),(12,'2026_03_21_000000_update_schema_for_phase2',1),(13,'2026_03_24_000001_create_categories_table',1),(14,'2026_03_24_000002_add_category_id_to_articles_table',1),(15,'2026_03_25_000000_add_posyandu_id_to_users_table',1),(16,'2026_04_25_000001_make_phone_number_nullable_in_patients',1),(17,'2026_04_26_053513_add_growth_monitoring_fields_to_medical_records',1),(18,'2026_05_01_000000_add_z_score_and_nutrition_trend_to_medical_records_table',1),(19,'2026_05_02_000000_create_who_weight_for_age_table',1),(20,'2026_05_02_175246_create_analytics_snapshots_table',1),(21,'2026_05_02_180827_add_id_number_hash_to_patients_table',1),(22,'2026_05_03_000001_create_who_lms_tables',1),(23,'2026_05_03_000002_add_extended_nutrition_to_medical_records',1),(24,'2026_05_03_000003_add_whatsapp_notification_to_schedules',1),(25,'2026_05_03_190404_make_nutrition_status_nullable_in_medical_records_table',1),(26,'2026_05_04_000000_fix_activity_logs_columns',1),(27,'2026_05_04_000001_add_kader_to_user_roles_enum',1),(28,'2026_05_04_231955_add_last_notifications_read_at_to_users_table',1),(29,'2026_05_04_233555_make_immunization_nullable_in_medical_records_table',1),(30,'2026_05_05_101543_update_patient_category_enum',1),(31,'2026_05_05_120423_add_comprehensive_fields_to_patients_table',1),(32,'2026_05_05_120430_add_comprehensive_fields_to_medical_records_table',1),(33,'2026_05_06_000000_add_performance_indexes',1),(34,'2026_05_06_103000_add_immunization_tracking_to_medical_records',1),(35,'2026_05_07_203731_add_kia_fields_to_medical_records_table',1),(36,'2026_05_07_203749_create_child_developments_table',1),(37,'2026_05_08_084600_update_patients_and_medical_records_for_new_ui',1),(38,'2026_05_08_101800_add_additional_tbc_screening_to_medical_records',1),(39,'2026_05_08_135357_increase_status_column_lengths_in_medical_records_table',1),(40,'2026_05_08_140253_delete_coordinator_role_users',1),(41,'2026_05_08_140959_clean_up_user_roles_enum',1),(42,'2026_05_10_124300_create_roles_and_permissions_tables',1),(43,'2026_05_21_095958_add_lansia_fields_to_patients_and_medical_records_tables',1),(44,'2026_05_24_080000_add_cadre_fields_to_users_table',1),(45,'2026_05_25_000000_fix_activity_logs_user_foreign_key',1),(46,'2026_06_04_150140_add_description_to_articles_table',1),(47,'2026_06_10_201106_add_anc_and_postpartum_fields_to_patients_and_medical_records',1),(48,'2026_06_10_210400_add_lansia_checkup_fields_to_medical_records',1),(49,'2026_06_26_104036_add_analytics_columns_to_patients_and_medical_records',1),(50,'2026_06_28_134300_make_description_nullable_in_schedules_and_galleries',1),(51,'2026_06_29_014153_create_gallery_folders_table',1),(52,'2026_06_29_014154_add_gallery_folder_id_to_galleries_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
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
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posyandu_id` bigint(20) unsigned NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'balita',
  `status_mutasi` varchar(255) NOT NULL DEFAULT 'aktif',
  `full_name` varchar(255) NOT NULL,
  `husband_name` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `head_of_family_name` varchar(255) DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `guardian_status` varchar(255) DEFAULT NULL COMMENT 'ibu kandung / wali',
  `education` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `number_of_children` int(11) NOT NULL DEFAULT 0,
  `is_pregnant` tinyint(1) NOT NULL DEFAULT 0,
  `living_status` varchar(255) DEFAULT NULL COMMENT 'sendiri / dengan keluarga',
  `independence_status` varchar(255) DEFAULT NULL COMMENT 'mandiri / butuh bantuan',
  `family_member_count` int(11) DEFAULT NULL,
  `house_condition` varchar(255) DEFAULT NULL,
  `water_access` varchar(255) DEFAULT NULL,
  `has_latrine` tinyint(1) NOT NULL DEFAULT 0,
  `economic_status` varchar(255) DEFAULT NULL,
  `mother_nik` varchar(16) DEFAULT NULL,
  `kia_book_ownership` tinyint(1) NOT NULL DEFAULT 0,
  `id_number` varchar(255) NOT NULL,
  `id_number_hash` varchar(255) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `hpht` date DEFAULT NULL,
  `weight_at_birth` decimal(5,2) DEFAULT NULL,
  `height_at_birth` decimal(5,2) DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `gender` char(255) NOT NULL,
  `address` text NOT NULL,
  `dusun_rt_rw` varchar(255) DEFAULT NULL,
  `desa_kelurahan` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `rt_domisili` varchar(10) DEFAULT NULL,
  `historical_diseases` text DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT '',
  `profile_photo` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_id_number_unique` (`id_number`),
  KEY `patients_id_number_hash_index` (`id_number_hash`),
  KEY `patients_category_index` (`category`),
  KEY `patients_posyandu_id_category_index` (`posyandu_id`,`category`),
  CONSTRAINT `patients_posyandu_id_foreign` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,1,'lansia','aktif','H. Amri',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275011704550020','bee13404f267fed72349c8a1972afbb97d7b3d884068e66d56d64471dc49c7e8','1955-04-17',NULL,NULL,NULL,NULL,'L','Aren Jaya, RT 01',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:03','2026-06-30 04:30:03'),(2,1,'lansia','aktif','Meita Indriati',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275015905630012','3c25df920ee88b9d5f31ba540d9613eff2e4a644fc535baf20ab98f12c0db430','1963-05-19',NULL,NULL,NULL,NULL,'P','Aren Jaya, RT 02',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:03','2026-06-30 04:30:03'),(3,1,'balita','aktif','A. ZAFRAN. U.R',NULL,NULL,NULL,NULL,'RYAN. R. R',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275010608224411','a9b15f60c398e66fca9f64c747075f214202ab1a41f3cfb3211956a866ef1e94','2022-08-06',NULL,NULL,NULL,NULL,'L','JL. P. NUSANTARA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(4,1,'balita','aktif','ABHIPRAYA ATTAR SOESENO',NULL,NULL,NULL,NULL,'ARIEF S. S',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012008240003','d89282710c298b27587cc9541245a0d5b2b33daa99a6b3d8205a72e8a8769f35','2024-08-20',NULL,NULL,NULL,NULL,'L','JL. P. BALI 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(5,1,'balita','aktif','ABRAHAM',NULL,NULL,NULL,NULL,'RISWAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275400202244084','f37e05b1da9c1689fe3f0f23d29559e1b4882587ae221a28b6ab1acb3287097b','2024-02-02',NULL,NULL,NULL,NULL,'L','JL. LOMBOK RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(6,1,'balita','aktif','ADITAMA A. F',NULL,NULL,NULL,NULL,'DODI FIRMANSYAH',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275402204236068','341d1f43e5b9300e4425d6a8409191e4e18e8e6bde626e214080f353cf2aa5e8','2023-04-22',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:04','2026-06-30 04:30:04'),(7,1,'balita','aktif','AISYAH HANIN.K',NULL,NULL,NULL,NULL,'YUNIAR. P',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275011101223311','379468bc3bf9c65d4610308f59bd34d82eeb834b740980549a180a127688f849','2022-01-11',NULL,NULL,NULL,NULL,'P','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(8,1,'balita','aktif','ALBIRU R. H',NULL,NULL,NULL,NULL,'ARIESTYA. H',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275402503236529','4e7f0d3f4a48a02727c9bcf60a526e0fefd11f9a78937d3e714bdedab1138b0a','2023-03-25',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(9,1,'balita','aktif','ALENA SALIHAH',NULL,NULL,NULL,NULL,'GHEMA P.',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275404310249271','9688f4f3aca7240f3e6514311b3fa1f918a932a45d06b7f58b9515aea5859ffa','2024-10-03',NULL,NULL,NULL,NULL,'P','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(10,1,'balita','aktif','ANINDYA ZHEA JUSTITIA',NULL,NULL,NULL,NULL,'M. ASYASYAM',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275016903220003','5c192d26bbabf53119c9f227616baca316afbfbbaaebf4937889d1de42766918','2022-03-29',NULL,NULL,NULL,NULL,'P','JL.. P. BALI 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(11,1,'balita','aktif','ANNISA ZAFRAN A',NULL,NULL,NULL,NULL,'RIANGGA RIDWAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275404910235077','d9e7f5698da6d22f1d416dfe92f64f390210179c36f7e14c63fe77ba05b03927','2023-10-09',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(12,1,'balita','aktif','AQEELA FIDA. K',NULL,NULL,NULL,NULL,'UJANG S',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275010707220411','71b65e7f1b7ca2126734b359cf76c663b7c9703e61cb9b6fc3e2b4fcbe9c055c','2022-07-07',NULL,NULL,NULL,NULL,'P','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(13,1,'balita','aktif','ARFAN SIDQI. A',NULL,NULL,NULL,NULL,'JODI',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275011905220005','4182328e99db564fd8002a6f99e8133abb098210ce2067975d649b6ca280d95b','2022-05-19',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(14,1,'balita','aktif','ARGAWIRA ARSYSNENDRA. A',NULL,NULL,NULL,NULL,'ALDIFA FAHRUL HUDA. SH',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275040705240001','75a2fca8bbb06e7e3fa6d9c5c175d3787ed0bd7a57369e7ae3af667678226155','2024-05-07',NULL,NULL,NULL,NULL,'L','JL. P. BALI RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(15,1,'balita','aktif','ARKA',NULL,NULL,NULL,NULL,'SUHERMAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275011303222211','b5390edfc5d36ee5f98bc461497d007fc14829d1e4bec6eea02d97dec291aa87','2022-03-13',NULL,NULL,NULL,NULL,'L','JL. P. BALI 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(16,1,'balita','aktif','ASHRAF FAIZAN',NULL,NULL,NULL,NULL,'ALAN FIRMANSYAH',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275402902244948','11e63b8ae4b83afb9fabdf7a308f9cce629750f322716460dc33a844e80439a7','2024-02-29',NULL,NULL,NULL,NULL,'L','JL. P. BALI RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(17,1,'balita','aktif','AZAM RAFASYA. A',NULL,NULL,NULL,NULL,'IRVANSYAH',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275401109237265','3aafca4ef34af8cae2d901f9bebc810b969525610338341f626616dbdf9313bf','2023-09-11',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(18,1,'balita','aktif','ELISA SHANUM A.',NULL,NULL,NULL,NULL,'PUTRA T.A.',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275406309241090','43f21fbe7be4808b16935f85b567c9cf42882f7e71fbec1fd7f8453ee555b2b3','2024-09-23',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(19,1,'balita','aktif','FAIZA TAKZIA. S',NULL,NULL,NULL,NULL,'HARDIAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275405510232326','918c537e57a3757ecb92799102565f3bc33de77b82a8877c8e28f0e1cc5187cb','2023-10-15',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(20,1,'balita','aktif','FATIMAH YUMI A.',NULL,NULL,NULL,NULL,'ANDIKA. A',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012206221111','69fc1f6b49c5ed05bf7b97cb08d7d4f409abb4f38fd4d7e4cd21b88b1da415f8','2022-06-22',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(21,1,'balita','aktif','GALVIN ZANE. K',NULL,NULL,NULL,NULL,'ANANDA A.',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275402205237048','7201f681488f25c1b6f2092a7dfff2fbb2051a39122a41148c3d32129e3136e5','2023-05-22',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(22,1,'balita','aktif','GANES M. D.',NULL,NULL,NULL,NULL,'ADI RASA',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275401601225280','9a55d3acc469ac24114bbec912531e8ac333179994e44e192bcc33367b0cbcd3','2022-01-16',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(23,1,'balita','aktif','GLADIS ASMARALAYA',NULL,NULL,NULL,NULL,'ADI RASA',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275016106230004','181fcd05f97c1475324558e27d1bacaf1a4a31afe8c0e7ad0c57ff3cd56b61b9','2023-06-21',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(24,1,'balita','aktif','GRACE VELIORA',NULL,NULL,NULL,NULL,'BACHTIAR',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275406607259161','35618223f22af1a83ef7f8f7280d25b70fb62556316c99bb49b568c243e0edbf','2025-07-26',NULL,NULL,NULL,NULL,'P','JL. P. BALI',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(25,1,'balita','aktif','HAURA R. R,',NULL,NULL,NULL,NULL,'RIDWAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275400910243970','50a27f05d619a67b1405a5637f07729b79a4b7a882af08ba16db2f40df884c53','2024-10-09',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(26,1,'balita','aktif','KHAIZANU. R. AL',NULL,NULL,NULL,NULL,'HERIYAWAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012105220211','0117ebbda38e0e0239f2a63e3e0b1506504bd3b5ec3126ab2b505fcacf9273a2','2022-05-21',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(27,1,'balita','aktif','KIREI HIFZA H.',NULL,NULL,NULL,NULL,'RAHMAT TRI',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275406303244019','16ae6892c473defb7befbd3e64cd76f002bdb68c4c2d5fb6e9f3ec602895a2c3','2024-03-23',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(28,1,'balita','aktif','M MAULINA R.',NULL,NULL,NULL,NULL,'ERA P',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275404509249122','f802d959239ef401ea1bc582a37c51c5cac5e99c0cdb16a5b281e0708158fd4b','2024-09-05',NULL,NULL,NULL,NULL,'P','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(29,1,'balita','aktif','M. ALBIFARDZAN Z.',NULL,NULL,NULL,NULL,'M. YUDA',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275400808247108','26a04a36d28c3aa1d8fbe2d8dc3476209f51845cb56ca7c33bbcb2c34d9bf94e','2024-08-08',NULL,NULL,NULL,NULL,'L','JL. P.SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(30,1,'balita','aktif','M. AZZUMAR',NULL,NULL,NULL,NULL,'M. KAMALUDIN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275401604231495','d6fe27796d4cd4d34a4286f8985cf63d469786af19510f5e1ef45b4f9cd12d23','2023-04-16',NULL,NULL,NULL,NULL,'L','JL. P. BALI 4',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(31,1,'balita','aktif','M. IBRAHIM',NULL,NULL,NULL,NULL,'HARDIAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275402709257850','d1ca719904fb8b0725f6f27e852d4ca23ae708c10539eef223a27ab573535581','2025-09-27',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA 8',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(32,1,'balita','aktif','M. ICHSAN AL. F',NULL,NULL,NULL,NULL,'IMAM',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275406606237297','fbc30bbae265819dd60a90e6f9e2efce3e79d5f9bb787e2853498bf03a77cdbf','2023-06-26',NULL,NULL,NULL,NULL,'P','JL. P. LOMBOK',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(33,1,'balita','aktif','M. ZACKY J.',NULL,NULL,NULL,NULL,'M. ASYSYAM. J',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275400108254730','91d73162fe8abf5f994a2ac5d8b0c3c817ba478e55d2edbe7b59d9ebce4994ba','2025-08-01',NULL,NULL,NULL,NULL,'L','JL. P. BALI 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(34,1,'balita','aktif','M. ZAID U.',NULL,NULL,NULL,NULL,'HARRY L.',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275402005252533','8d1a79cfdd8292df8b1e3c52a82bb805a6e5ed64d5bb0ba550083e6716eba91e','2025-05-20',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(35,1,'balita','aktif','M. ZIDAN A',NULL,NULL,NULL,NULL,'RAFDI H',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275011009230003','4ef3d2c79eace9068cfdf63ffdf31a47de7087ae4d118a6a33f1ac1379b5c010','2023-09-10',NULL,NULL,NULL,NULL,'L','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(36,1,'balita','aktif','M.SAID. R',NULL,NULL,NULL,NULL,'RAGIL.T',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012004210111','e3887ee97b68af51b5d40cc8fd84c96f11758a673ae07ee9eb4113984f68662b','2021-04-20',NULL,NULL,NULL,NULL,'L','JL.P.SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(37,1,'balita','aktif','MAHIRA. N. E. P. B',NULL,NULL,NULL,NULL,'DUTA AGENG',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275011507220111','19b309bdfae777087d6c8e249ea731d396689ece40fb616a48dcd6ff0650a4e2','2022-07-15',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(38,1,'balita','aktif','MIKAEL',NULL,NULL,NULL,NULL,'WINSON. F. D',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275010304220004','88be5ac89b04d00863feeae7b4e90b2d22898ae685d16f41327ef87b90e90fd0','2022-04-03',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(39,1,'balita','aktif','MIKAIL AURIGA R.',NULL,NULL,NULL,NULL,'OKI P',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012204240002','54f36c837216c41ae73d9c46fd6202550669ac1fab94828b698e93cbef112cc7','2024-04-22',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(40,1,'balita','aktif','MIKHAYLA. A. F',NULL,NULL,NULL,NULL,'CATUR. I',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012612223311','a3d981f3ac9d2c46ecc475da3c536c4791cb2e19aa067f033a89d177ab24de9e','2022-12-26',NULL,NULL,NULL,NULL,'P','JL.P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(41,1,'balita','aktif','MISHAEL N. P. A',NULL,NULL,NULL,NULL,'NUEL K.',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275406403252457','937413aeaefb33be00c003c53dc14a9764ba33d665092078895ba9e99bd8c617','2025-03-24',NULL,NULL,NULL,NULL,'P','JL. P. BALI 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(42,1,'balita','aktif','MORIEL N. P. E.',NULL,NULL,NULL,NULL,'NUEL KISNANDA',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275405902235886','27b43de59e0468e29b2ab581b4dffbfcb56151db52e98e6751168237b133c2fb','2023-02-19',NULL,NULL,NULL,NULL,'P','JL. P. BALI 3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(43,1,'balita','aktif','NABILA WARNA QIRANI',NULL,NULL,NULL,NULL,'ANDRI MOHAMAD SOFAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275015307220005','52d5b605fefc873b1eac2be173f221c623356c1f2f4bd8b8105344dd2323e338','2022-07-13',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(44,1,'balita','aktif','NATA NAEL',NULL,NULL,NULL,NULL,'MARJOHAN',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012107210111','e20ff38a2fbbe83c53c25791ed33389e49c5c0b6408306be1274e25b774046b3','2021-07-21',NULL,NULL,NULL,NULL,'L','JL.P.SUMBA RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(45,1,'balita','aktif','RATU RALINE V. C. B',NULL,NULL,NULL,NULL,'BACHTIAR',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275013011222211','44191266e396058f6d718cb31a15b36cb02bea09427d35e77daa8adeb59c05f2','2022-11-30',NULL,NULL,NULL,NULL,'P','JL. P. BALI 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(46,1,'balita','aktif','RYUGA. A. H',NULL,NULL,NULL,NULL,'RAHMAT. T',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275010302220001','77409a368e955f28912d4682250d882e11e83b51346c661642a9f5de6460b73d','2022-02-03',NULL,NULL,NULL,NULL,'L','JL. P. SUMBA RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(47,1,'balita','aktif','SABHIRA',NULL,NULL,NULL,NULL,'NURDIANSYAH',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275010409210111','28f8ffe5d165f6af187ec03d9f8a06a3151571c467bda05849dc5cef6893e9eb','2021-09-04',NULL,NULL,NULL,NULL,'P','JL.P.SUMBA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(48,1,'balita','aktif','SAFIQ',NULL,NULL,NULL,NULL,'WISNU',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275400501232088','3348a5d65d414f34743ffaca69fde8038b60230ff91e8cdf1bf31b7d5892fad5','2023-01-05',NULL,NULL,NULL,NULL,'L','JL. P. BALI 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(49,1,'balita','aktif','SALWA. D. Z',NULL,NULL,NULL,NULL,'HERY. S',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275016906210003','528f3eadeaeec3090c4b845e215c2db44d2e2ea12d69837f253206a4a5851fcd','2021-06-29',NULL,NULL,NULL,NULL,'P','JL.P.SUMBA RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(50,1,'balita','aktif','SHAYNALA A. P',NULL,NULL,NULL,NULL,'SYAHMI RIZAL',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275405004235083','bd5bc7e623fe94d584b339948800ca65016e45860639696491cd2df37940dbed','2023-04-10',NULL,NULL,NULL,NULL,'P','JL. P. MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(51,1,'balita','aktif','SOCA M. N.',NULL,NULL,NULL,NULL,'IVAN B. P.',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275404503255311','2602f34cd4f9255fd11a5c544b76854b6113ebb605cd6b111a14b51c10361248','2025-03-05',NULL,NULL,NULL,NULL,'P','JL. P. SUMBA RAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(52,1,'balita','aktif','TSABINA. A. L',NULL,NULL,NULL,NULL,'ASTU. K. J',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275116911210003','373f66209c62af1b28dd684880f9a7a86e0b9b99726d985cee7706383ac76348','2021-11-29',NULL,NULL,NULL,NULL,'P','JL.P.MADURA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(53,1,'balita','aktif','VALLERA DARREN. R',NULL,NULL,NULL,NULL,'USMAN MUHAMMAD. Y',NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3275012304210211','48bba1e2537e04c93315a0958ae6ad45e5e95cb737f21581257f5d93b21b4e0d','2021-04-23',NULL,NULL,NULL,NULL,'L','JL.P.BALI 3 NO.351',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-30 04:30:05','2026-06-30 04:30:05'),(54,1,'lansia','aktif','Galih Najmudin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275015335098644688170','12ec697cb9b07c2722e5cbb0ac12c3b41e440d3038977010eb815ad0087e37ef','1954-01-10',NULL,NULL,NULL,NULL,'P','Jln. Karel S. Tubun No. 153, Cirebon 31808, Kalsel',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(55,1,'lansia','aktif','Shakila Lailasari',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'C',NULL,NULL,NULL,0,NULL,NULL,0,'3275017889032585809799','c8828201aa0f8cc2b78d1a3101b1dddc43520ea995a3a4b64c298d6f9b62fb8e','1948-04-21',NULL,NULL,NULL,NULL,'P','Psr. PHH. Mustofa No. 314, Dumai 71637, Kalsel',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(56,1,'lansia','aktif','Ani Rahayu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275011855049381836416','7323cc3359fde1b2f682603b09390e3a1ed5cb1ac7fb6bcc81f447e389f63ece','1947-09-14',NULL,NULL,NULL,NULL,'P','Psr. B.Agam 1 No. 574, Parepare 87061, Pabar',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(57,1,'lansia','aktif','Abyasa Adriansyah',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275015815327515989129','5369acb3f5e4a56195339166e16aadcfde4c05075286742e1853cdb4042fce40','1956-04-23',NULL,NULL,NULL,NULL,'P','Ds. Baiduri No. 617, Palopo 63162, NTT',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(58,1,'lansia','aktif','Tira Tira Yuniar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275012046978823822932','4f390fcf112b6b388f0ad47ce21470cbf81e59613403f820b9c4df5e8300a0c9','1957-07-29',NULL,NULL,NULL,NULL,'P','Gg. Raya Ujungberung No. 509, Sorong 10936, Banten',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(59,1,'lansia','aktif','Gina Yolanda S.Pd',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'A',NULL,NULL,NULL,0,NULL,NULL,0,'3275013230827603953810','ae887e7669fb0b33d32832973ba9f106578009492f58d86124f54a7be1a49b04','1954-07-04',NULL,NULL,NULL,NULL,'P','Ki. Babakan No. 152, Dumai 32957, DIY',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:06','2026-06-30 04:30:06'),(60,1,'lansia','aktif','Salman Mansur',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'A',NULL,NULL,NULL,0,NULL,NULL,0,'3275012707234500762880','8e337e825ddfe7f75b28ca13c2e51016e5f06571946b434ddd8b88b0f05cb7fd','1950-12-18',NULL,NULL,NULL,NULL,'P','Jln. Babadak No. 613, Palopo 62958, Kalteng',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(61,1,'lansia','aktif','Eka Margana Sitompul S.H.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'A',NULL,NULL,NULL,0,NULL,NULL,0,'3275010187471569493086','db99f34f0ec66141fd62872cc1acb7d21dae2b6b24896b273e50ac780be52d43','1961-06-20',NULL,NULL,NULL,NULL,'P','Ki. Achmad Yani No. 781, Samarinda 63181, Malut',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(62,1,'lansia','aktif','Gilda Mila Agustina',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275019289972094322674','171b92d7ca442b219797287723437e00792bc3983b21bdd62a444878eabd3253','1946-12-01',NULL,NULL,NULL,NULL,'L','Dk. Industri No. 682, Surakarta 26983, Kalbar',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(63,1,'lansia','aktif','Hasta Kuswoyo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275018221348545993886','0b9d29b20986f56de1297a134049686390289839c6baeab4cfa825317a4bce18','1947-07-10',NULL,NULL,NULL,NULL,'L','Ds. Wahid Hasyim No. 934, Cirebon 48253, Kepri',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:07','2026-06-30 04:30:07'),(64,1,'lansia','aktif','Asmadi Nainggolan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'C',NULL,NULL,NULL,0,NULL,NULL,0,'3275012047515639768253','cf194e98a5b2a974880a37e1c9b8893ccebd6c0e60a73376a8e4a27e515c4f00','1956-08-07',NULL,NULL,NULL,NULL,'P','Jln. Salatiga No. 546, Manado 40636, Jateng',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(65,1,'lansia','aktif','Simon Latupono',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275017108635034490838','15978b90225b65d663d80f3d3fcfebfca4c4f0aa420efc4cf8094ca1420b1dee','1959-06-24',NULL,NULL,NULL,NULL,'P','Jln. Bakau Griya Utama No. 712, Mojokerto 48646, Aceh',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(66,1,'lansia','aktif','Zulaikha Hasna Yuniar S.Farm',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'C',NULL,NULL,NULL,0,NULL,NULL,0,'3275014047833905032005','f969cd3c08198d0760a8442829c1fc06bd31ce61df8d7c68e828acb23ade6792','1952-10-09',NULL,NULL,NULL,NULL,'L','Ki. Lembong No. 316, Tanjung Pinang 50095, Kalteng',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(67,1,'lansia','aktif','Eman Aditya Gunawan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275016967962423536610','7cb146f28fd37ea48c400c910500b6cd5d8d2f15044393dc0e8be8bb71c03065','1958-07-16',NULL,NULL,NULL,NULL,'P','Gg. Banal No. 211, Serang 51184, Kalsel',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(68,1,'lansia','aktif','Cakrajiya Prakasa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'C',NULL,NULL,NULL,0,NULL,NULL,0,'3275018002376951410616','b33ed4e822459ee740f4a8bea1933bb93abd7dfefb7652378d5d6dc1a88309fc','1941-11-06',NULL,NULL,NULL,NULL,'L','Ds. Cihampelas No. 596, Sukabumi 53755, Kaltara',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(69,1,'lansia','aktif','Jindra Damanik M.M.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'C',NULL,NULL,NULL,0,NULL,NULL,0,'3275016284831662938480','34e5082bdd281b69d4edcf39e6df20a2febb13b8a32e784578d9d9d7edcb444f','1959-08-19',NULL,NULL,NULL,NULL,'P','Gg. Kartini No. 65, Semarang 83254, Aceh',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(70,1,'lansia','aktif','Nilam Wulandari M.Farm',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275012994577961926532','5057d94ff5fd858de686c60f9a1e54d729bbb535590df5e1adea748c01a8e91d','1941-12-10',NULL,NULL,NULL,NULL,'L','Ds. Ujung No. 29, Sibolga 70779, Bali',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:08','2026-06-30 04:30:08'),(71,1,'lansia','aktif','Ifa Riyanti S.T.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'A',NULL,NULL,NULL,0,NULL,NULL,0,'3275019341529133041974','2a03636a0e368ae91b13c0b55ad8a94c077e78a239a8d0bc7adbae51d82c4b8f','1954-05-11',NULL,NULL,NULL,NULL,'P','Gg. Ters. Jakarta No. 732, Probolinggo 66783, Kaltim',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(72,1,'lansia','aktif','Yani Uchita Puspita',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'B',NULL,NULL,NULL,0,NULL,NULL,0,'3275010788277283346036','6d5fdde1793083dc5035556828379fadc875b1aa37563e4ce223d91556574d60','1944-06-19',NULL,NULL,NULL,NULL,'P','Kpg. Ikan No. 267, Administrasi Jakarta Utara 24827, Gorontalo',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(73,1,'lansia','aktif','Sakti Hakim M.Farm',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,'A',NULL,NULL,NULL,0,NULL,NULL,0,'3275014852265110169414','798244e8b22848c96404903be1e6a2d132de39e364839f9044314f887cdb1d25','1953-12-04',NULL,NULL,NULL,NULL,'P','Jr. Cut Nyak Dien No. 419, Sawahlunto 74050, Sulut',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(74,2,'ibu_hamil','aktif','Wulan Kiandra Hartati',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'9561841102102905','b28328d1a5954d2d77ebdef458ab0d2a289a339f8f365e5b3cc65bfb6fa6741c','1993-02-21','2026-03-19',NULL,NULL,NULL,'P','Jr. Jakarta No. 733, Pekalongan 58669, Kalsel',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(75,1,'ibu_hamil','aktif','Umi Palastri S.Pt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'3199482172519132','9e798d94297562036b30763d2cc830da9a1d765a96d66420f4f8613bef8f49f8','2003-06-10','2026-03-28',NULL,NULL,NULL,'P','Jr. Tangkuban Perahu No. 111, Kendari 77393, Bengkulu',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(76,1,'ibu_hamil','aktif','Tina Mandasari',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'0410754595381040','0ed07c446218616d2fc461310e758629052e893c7add9f77b0a2d546afa4e839','1985-09-08','2025-11-15',NULL,NULL,NULL,'P','Kpg. Baja Raya No. 459, Solok 41034, Sulut',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(77,2,'ibu_hamil','aktif','Salwa Utami',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'0362697971677065','b28522e18faa1fae2e2bfa4a74a8ee7d1ebef3d02bb32d70403f47e0a72d7e7a','1992-02-19','2026-03-26',NULL,NULL,NULL,'P','Psr. Babadak No. 325, Administrasi Jakarta Timur 25708, Kalteng',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09'),(78,2,'ibu_hamil','aktif','Melinda Suryatmi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,'1488247268681474','fb28651954e5dfc47e8c27812bcb5d5db9235c4d99da82fe08b6fb197a1e5e91','1992-05-31','2026-04-19',NULL,NULL,NULL,'P','Ki. Baranang Siang No. 430, Cilegon 59108, Sumbar',NULL,NULL,NULL,NULL,NULL,'',NULL,'2026-06-30 04:30:09','2026-06-30 04:30:09');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedukuhans`
--

DROP TABLE IF EXISTS `pedukuhans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedukuhans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `geo_location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`geo_location`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedukuhans`
--

LOCK TABLES `pedukuhans` WRITE;
/*!40000 ALTER TABLE `pedukuhans` DISABLE KEYS */;
INSERT INTO `pedukuhans` VALUES (1,'Dukuh A','55281','{\"lat\":-7.123456,\"lng\":110.123456}','2026-06-30 04:29:57','2026-06-30 04:29:57'),(2,'Aren Jaya','17111','{\"lat\":-6.234567,\"lng\":107.012345}','2026-06-30 04:29:57','2026-06-30 04:29:57');
/*!40000 ALTER TABLE `pedukuhans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
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
-- Table structure for table `posyandus`
--

DROP TABLE IF EXISTS `posyandus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posyandus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pedukuhan_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `unique_code` varchar(255) NOT NULL,
  `logo_photo` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posyandus_unique_code_unique` (`unique_code`),
  KEY `posyandus_pedukuhan_id_foreign` (`pedukuhan_id`),
  CONSTRAINT `posyandus_pedukuhan_id_foreign` FOREIGN KEY (`pedukuhan_id`) REFERENCES `pedukuhans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posyandus`
--

LOCK TABLES `posyandus` WRITE;
/*!40000 ALTER TABLE `posyandus` DISABLE KEYS */;
INSERT INTO `posyandus` VALUES (1,2,'KENANGA 1','Aren Jaya, RW 11, Bekasi Timur','PSY003',NULL,'2026-06-30 04:29:57','2026-06-30 04:29:57'),(2,2,'KENANGA 2','Aren Jaya, RW 12, Bekasi Timur','PSY002',NULL,'2026-06-30 04:29:57','2026-06-30 04:29:57');
/*!40000 ALTER TABLE `posyandus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_has_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
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
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posyandu_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `whatsapp_notif_sent_at` timestamp NULL DEFAULT NULL COMMENT 'Timestamp pengiriman notifikasi WA terakhir',
  `whatsapp_notif_count` smallint(5) unsigned NOT NULL DEFAULT 0 COMMENT 'Jumlah notifikasi WA yang berhasil terkirim',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_posyandu_id_foreign` (`posyandu_id`),
  KEY `schedules_user_id_foreign` (`user_id`),
  CONSTRAINT `schedules_posyandu_id_foreign` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,1,13,'Posyandu Bulanan','Kegiatan posyandu rutin bulanan untuk pemeriksaan bayi dan balita','2026-07-05 11:30:03','2026-07-05 14:30:03','KENANGA 1','upcoming',NULL,0,'2026-06-30 04:30:03','2026-06-30 04:30:03'),(2,2,15,'Imunisasi Campak','Program imunisasi campak untuk bayi usia 9 bulan','2026-07-07 11:30:03','2026-07-07 13:30:03','KENANGA 2','upcoming',NULL,0,'2026-06-30 04:30:03','2026-06-30 04:30:03'),(3,1,13,'Penyuluhan Gizi','Penyuluhan tentang gizi seimbang untuk ibu hamil dan balita','2026-07-10 11:30:03','2026-07-10 13:30:03','KENANGA 1','upcoming',NULL,0,'2026-06-30 04:30:03','2026-06-30 04:30:03');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posyandu_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` enum('superadmin','admin','kader') DEFAULT 'admin',
  `last_notifications_read_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `verified_email` tinyint(1) NOT NULL DEFAULT 0,
  `attempt_login` int(11) NOT NULL DEFAULT 0,
  `block_expires` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cadre_role` varchar(255) DEFAULT NULL,
  `ttl` varchar(255) DEFAULT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_posyandu_id_foreign` (`posyandu_id`),
  CONSTRAINT `users_posyandu_id_foreign` FOREIGN KEY (`posyandu_id`) REFERENCES `posyandus` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,3,'Sri Hartati','denyyoga2212@gmail.com','sri_434',NULL,'$2y$12$UZmTY917rheAMwSK3j4ThuMbKF.j83GhRDD3T1xqa.n8nvdYOls5y',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:47','2026-06-30 04:29:47','Ketua Kader','Lampung, 12 April 1962','3275015204620012','SLTA','Jl P. Sumba 8 No. 232 RT 001 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081380473365','assets/img/kaders/sri_hartati.png'),(2,3,'Widayanti Christiani','widayantichristiani@yahoo.co.id','widayanti_200',NULL,'$2y$12$5XmbLIH5lVua7y11t7etXu9qYYvCVd2RmpGYzAsj5PTeD/kMWJPye',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:48','2026-06-30 04:29:48','Sekretaris','Jakarta, 05 April 1982','3275014504820054','SLTA','Jl P. Bali 1 No. 330 RT 002 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','08139914428','assets/img/kaders/widayanti.jpg'),(3,3,'Parniyati','parniyati15.71@gmail.com','parniyati_315',NULL,'$2y$12$BJoNSrmEBDz4JYyvZYtTc.RN/vBdn/jBoAqU.zE.Q52SLZc/.U3US',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:49','2026-06-30 04:29:49','Bendahara','Karanganyar, 15 Juli 1971','3275015507710014','SLTA','Jl P. Madura 3 No 37 RT 004 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','085770153741','assets/img/kaders/parniyati.png'),(4,3,'Arimbi Kurniasari','arimbi28sari@ggmail.com','arimbi_425',NULL,'$2y$12$pHn1aZ3fj7DNGl54B9qUMeKVLzZeWZuvl1QU.MrysMHI2ed4QdB1W',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:50','2026-06-30 04:29:50','Anggota','Klaten, 28 November 1976','3275016811760020','Magister','Jl P. Madura 4 No. 15 RT 003 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081297963177','assets/img/kaders/arimbi.png'),(5,3,'Dewi Pastrinah','dewigedhe81@gmail.com','dewi_438',NULL,'$2y$12$vzwrwrA6WuHio/pBQjc5YO38/jfehm2Fmby06pYm9JroS/1Xc0./e',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:50','2026-06-30 04:29:50','Anggota','Jakarta, 29 Desember 1981','3275016912810022','SMK','Jl P. Madura 4 No. 22 RT 003 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081517001791','assets/img/kaders/dewi_pastrinah.png'),(6,3,'Tionar Maulina Purba','tionar.mp@gmail.com','tionar_490',NULL,'$2y$12$Y5ubl6QmGrFfM7SmDNFCqukwZB313KqJv/LD/dUW5VTtAQn6.ybCi',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:51','2026-06-30 04:29:51','Anggota','Dolok Sanggul, 25 Januari 1959','3275016501590013','SLTA','Jl P. Madura 3 No 38 RT 004 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081218385669','assets/img/kaders/tionar.png'),(7,3,'Maita Indriati','Maitaindriati1905@gmail.com','maita_619',NULL,'$2y$12$5JKa0r1Vo4iHq9TKZtHf6uZkVnjipjDJV8nUTE3vGswxS8hmSVyuC',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:52','2026-06-30 04:29:52','Anggota','Jakarta, 19 Mei 1963','3275015905630012','Sarjana','Jl Sumba Raya No 03 RT 001 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081295743714','assets/img/kaders/maita.png'),(8,3,'Arfah','arfah.6715@gmail.com','arfah_441',NULL,'$2y$12$E0JRi616N/gMGMH.5AMuzuVIp3vaEZw3BqQ4N4giwoFxmnfDX1I32',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:52','2026-06-30 04:29:52','Anggota','Jakarta, 15 Mei 1967','3275015505670018','SLTA','Jl Sumba Raya No 27 RT 002 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','087856068033','assets/img/kaders/arfah.png'),(9,3,'Mustikasari','Mustikasari@gmail.com','mustikasari_401',NULL,'$2y$12$8lcYorGxXYO9DWBHFG9ZfOwWi30jHdEdYCDvxWcAiClv/BNQo7W..',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:53','2026-06-30 04:29:53','Anggota','Subang, 09 September 1956','3275014909560018','SLTA','Jl P. Sumba 7 No. 254 RT 001 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081293290635','assets/img/kaders/mustikasari.png'),(10,3,'Ika Rakhmawati','ika@posyandu.com','ika_729',NULL,'$2y$12$FcOTPkYPo6yKjPDbh5Q7auHDXyzvoaPXxosYsqBtrddBskkXEaN4O',NULL,'kader',NULL,1,0,0,NULL,'2026-06-30 04:29:54','2026-06-30 04:29:54','Anggota','Jakarta, 15 Agustus 1978','3275015508780053','SLTA','Jl P. Madura 2 No. 58 RT 004 RW 011 Kel. Aren Jaya, Kec. Bekasi Timur','081315662377','assets/img/kaders/ika.jpeg'),(11,NULL,'Sekretaris Posyandu','sekretaris@posyandu.com','sekretaris','2026-06-30 04:29:58','$2y$12$0Eyh.7PDZ3spHUlXFe3WMuic/J2eL4EPYFU8ICqr9XtMkT2e7Br4u',NULL,'superadmin',NULL,1,1,0,NULL,'2026-06-30 04:29:58','2026-06-30 04:29:58',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,NULL,'Ibu Arimbi','arimbi@posyandu.com','arimbi','2026-06-30 04:29:59','$2y$12$60JQCRqiSDIHTgU88FXdFu3YnAMDf3aun2MlLqK1tKFiGlL0s2or6',NULL,'superadmin',NULL,1,1,0,NULL,'2026-06-30 04:29:59','2026-06-30 04:29:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,1,'Kader Kenanga 1','kader.kenanga1@posyandu.com','kader_kenanga1','2026-06-30 04:30:00','$2y$12$Ii4oVDd6SZuWDPTWkTpxHOUZ1wGAMR44NoVoybEfEBHlUrd9hC4jO',NULL,'kader',NULL,1,1,0,NULL,'2026-06-30 04:30:00','2026-06-30 04:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,1,'Admin Kenanga 1','admin.kenanga1@posyandu.com','admin_kenanga1','2026-06-30 04:30:01','$2y$12$RcM7JStnCUqdD6GfbDkBKOqKD9nrx/UM1VLwWhI/CznjiDSi57wgm',NULL,'admin',NULL,1,1,0,NULL,'2026-06-30 04:30:01','2026-06-30 04:30:01',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,2,'Kader Kenanga 2','kader.kenanga2@posyandu.com','kader_kenanga2','2026-06-30 04:30:02','$2y$12$NHk/hnwXnS8ipXKv9xbm7eK51Hi5kBMyiG.D1Vg04CmgO7KLQh6sq',NULL,'kader',NULL,1,1,0,NULL,'2026-06-30 04:30:02','2026-06-30 04:30:02',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,2,'Admin Kenanga 2','admin.kenanga2@posyandu.com','admin_kenanga2','2026-06-30 04:30:03','$2y$12$tEeWmSambUblwB30KnP04O7npKUW7TRTuJ3CVRIOSL5xBo88pdAMK',NULL,'admin',NULL,1,1,0,NULL,'2026-06-30 04:30:03','2026-06-30 04:30:03',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `who_bmi_for_age`
--

DROP TABLE IF EXISTS `who_bmi_for_age`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `who_bmi_for_age` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gender` enum('M','F') NOT NULL,
  `age_months` tinyint(3) unsigned NOT NULL COMMENT 'Usia dalam bulan (0-60)',
  `l_value` decimal(8,5) NOT NULL,
  `m_value` decimal(8,5) NOT NULL,
  `s_value` decimal(8,5) NOT NULL,
  `sd_minus3` decimal(5,2) NOT NULL,
  `sd_minus2` decimal(5,2) NOT NULL,
  `sd_plus1` decimal(5,2) NOT NULL,
  `sd_plus2` decimal(5,2) NOT NULL,
  `sd_plus3` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `who_bmi_for_age_gender_age_months_unique` (`gender`,`age_months`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `who_bmi_for_age`
--

LOCK TABLES `who_bmi_for_age` WRITE;
/*!40000 ALTER TABLE `who_bmi_for_age` DISABLE KEYS */;
/*!40000 ALTER TABLE `who_bmi_for_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `who_height_for_age`
--

DROP TABLE IF EXISTS `who_height_for_age`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `who_height_for_age` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gender` enum('M','F') NOT NULL COMMENT 'M=Laki-laki, F=Perempuan',
  `age_months` tinyint(3) unsigned NOT NULL COMMENT 'Usia dalam bulan (0-60)',
  `l_value` decimal(8,5) NOT NULL COMMENT 'L (Box-Cox power)',
  `m_value` decimal(8,5) NOT NULL COMMENT 'M (Median)',
  `s_value` decimal(8,5) NOT NULL COMMENT 'S (Coefficient of variation)',
  `sd_minus3` decimal(5,1) NOT NULL,
  `sd_minus2` decimal(5,1) NOT NULL,
  `sd_plus2` decimal(5,1) NOT NULL,
  `sd_plus3` decimal(5,1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `who_height_for_age_gender_age_months_unique` (`gender`,`age_months`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `who_height_for_age`
--

LOCK TABLES `who_height_for_age` WRITE;
/*!40000 ALTER TABLE `who_height_for_age` DISABLE KEYS */;
INSERT INTO `who_height_for_age` VALUES (1,'M',0,1.00000,49.90000,0.03800,44.2,46.1,53.7,55.6),(2,'M',1,1.00000,54.70000,0.03730,48.9,50.8,58.6,60.6),(3,'M',2,1.00000,58.40000,0.03680,52.4,54.4,62.4,64.4),(4,'M',3,1.00000,61.40000,0.03640,55.3,57.3,65.5,67.6),(5,'M',4,1.00000,63.90000,0.03610,57.6,59.7,68.0,70.1),(6,'M',5,1.00000,65.90000,0.03590,59.6,61.7,70.1,72.2),(7,'M',6,1.00000,67.60000,0.03570,61.2,63.3,71.9,74.0),(8,'M',7,1.00000,69.20000,0.03550,62.7,64.8,73.5,75.7),(9,'M',8,1.00000,70.60000,0.03530,64.0,66.2,75.0,77.2),(10,'M',9,1.00000,72.00000,0.03520,65.2,67.5,76.5,78.7),(11,'M',10,1.00000,73.30000,0.03510,66.4,68.7,77.9,80.1),(12,'M',11,1.00000,74.50000,0.03500,67.5,69.9,79.2,81.5),(13,'M',12,1.00000,75.70000,0.03490,68.6,71.0,80.5,82.9),(14,'M',13,1.00000,76.80000,0.03483,69.7,72.0,81.7,84.2),(15,'M',14,1.00000,77.90000,0.03477,70.7,73.0,82.9,85.4),(16,'M',15,1.00000,79.00000,0.03470,71.8,74.0,84.1,86.7),(17,'M',16,1.00000,80.10000,0.03463,72.9,74.9,85.3,87.9),(18,'M',17,1.00000,81.20000,0.03457,73.9,75.9,86.5,89.2),(19,'M',18,1.00000,82.30000,0.03450,75.0,76.9,87.7,90.4),(20,'M',19,1.00000,83.21667,0.03445,75.8,77.8,88.6,91.3),(21,'M',20,1.00000,84.13333,0.03440,76.7,78.8,89.5,92.2),(22,'M',21,1.00000,85.05000,0.03435,77.5,79.7,90.5,93.1),(23,'M',22,1.00000,85.96667,0.03430,78.3,80.6,91.4,94.0),(24,'M',23,1.00000,86.88333,0.03425,79.2,81.6,92.3,94.9),(25,'M',24,1.00000,87.80000,0.03420,80.0,82.5,93.2,95.8),(26,'M',25,1.00000,88.49167,0.03418,80.7,83.2,93.9,96.5),(27,'M',26,1.00000,89.18333,0.03417,81.4,83.9,94.6,97.2),(28,'M',27,1.00000,89.87500,0.03415,82.1,84.6,95.3,97.9),(29,'M',28,1.00000,90.56667,0.03413,82.7,85.2,96.0,98.6),(30,'M',29,1.00000,91.25833,0.03412,83.4,85.9,96.7,99.3),(31,'M',30,1.00000,91.95000,0.03410,84.1,86.6,97.4,100.0),(32,'M',31,1.00000,92.64167,0.03408,84.8,87.3,98.0,100.6),(33,'M',32,1.00000,93.33333,0.03407,85.5,88.0,98.7,101.3),(34,'M',33,1.00000,94.02500,0.03405,86.2,88.7,99.4,102.0),(35,'M',34,1.00000,94.71667,0.03403,86.8,89.3,100.1,102.7),(36,'M',35,1.00000,95.40833,0.03402,87.5,90.0,100.8,103.4),(37,'M',36,1.00000,96.10000,0.03400,88.2,90.7,101.5,104.1),(38,'M',37,1.00000,96.70000,0.03398,88.7,91.2,102.2,104.8),(39,'M',38,1.00000,97.30000,0.03397,89.2,91.8,102.8,105.5),(40,'M',39,1.00000,97.90000,0.03395,89.8,92.3,103.5,106.2),(41,'M',40,1.00000,98.50000,0.03393,90.3,92.9,104.1,106.9),(42,'M',41,1.00000,99.10000,0.03392,90.8,93.4,104.8,107.6),(43,'M',42,1.00000,99.70000,0.03390,91.3,94.0,105.5,108.3),(44,'M',43,1.00000,100.30000,0.03388,91.8,94.5,106.1,109.0),(45,'M',44,1.00000,100.90000,0.03387,92.3,95.0,106.8,109.7),(46,'M',45,1.00000,101.50000,0.03385,92.9,95.6,107.4,110.4),(47,'M',46,1.00000,102.10000,0.03383,93.4,96.1,108.1,111.1),(48,'M',47,1.00000,102.70000,0.03382,93.9,96.7,108.7,111.8),(49,'M',48,1.00000,103.30000,0.03380,94.4,97.2,109.4,112.5),(50,'M',49,1.00000,103.85833,0.03378,94.9,97.7,110.0,113.1),(51,'M',50,1.00000,104.41667,0.03377,95.5,98.2,110.6,113.8),(52,'M',51,1.00000,104.97500,0.03375,96.0,98.7,111.2,114.4),(53,'M',52,1.00000,105.53333,0.03373,96.5,99.2,111.8,115.0),(54,'M',53,1.00000,106.09167,0.03372,97.0,99.7,112.4,115.6),(55,'M',54,1.00000,106.65000,0.03370,97.6,100.3,113.0,116.3),(56,'M',55,1.00000,107.20833,0.03368,98.1,100.8,113.5,116.9),(57,'M',56,1.00000,107.76667,0.03367,98.6,101.3,114.1,117.5),(58,'M',57,1.00000,108.32500,0.03365,99.1,101.8,114.7,118.1),(59,'M',58,1.00000,108.88333,0.03363,99.7,102.3,115.3,118.8),(60,'M',59,1.00000,109.44167,0.03362,100.2,102.8,115.9,119.4),(61,'M',60,1.00000,110.00000,0.03360,100.7,103.3,116.5,120.0),(62,'F',0,1.00000,49.10000,0.03810,43.6,45.4,52.9,54.7),(63,'F',1,1.00000,53.70000,0.03750,47.8,49.8,57.6,59.5),(64,'F',2,1.00000,57.10000,0.03700,51.0,53.0,61.1,63.2),(65,'F',3,1.00000,59.80000,0.03660,53.5,55.6,64.0,66.1),(66,'F',4,1.00000,62.10000,0.03630,55.6,57.8,66.4,68.6),(67,'F',5,1.00000,64.00000,0.03610,57.4,59.6,68.5,70.7),(68,'F',6,1.00000,65.70000,0.03590,58.9,61.2,70.3,72.5),(69,'F',7,1.00000,67.30000,0.03570,60.3,62.7,71.9,74.2),(70,'F',8,1.00000,68.70000,0.03560,61.7,64.0,73.5,75.8),(71,'F',9,1.00000,70.10000,0.03540,63.2,65.3,75.0,77.4),(72,'F',10,1.00000,71.50000,0.03530,64.3,66.5,76.4,78.9),(73,'F',11,1.00000,72.80000,0.03520,65.5,67.8,77.8,80.3),(74,'F',12,1.00000,74.00000,0.03510,66.8,69.2,78.9,81.3),(75,'F',13,1.00000,75.11667,0.03507,67.9,70.2,80.1,82.6),(76,'F',14,1.00000,76.23333,0.03503,68.9,71.2,81.3,83.8),(77,'F',15,1.00000,77.35000,0.03500,70.0,72.2,82.6,85.1),(78,'F',16,1.00000,78.46667,0.03497,71.0,73.2,83.8,86.3),(79,'F',17,1.00000,79.58333,0.03493,72.1,74.2,85.0,87.6),(80,'F',18,1.00000,80.70000,0.03490,73.1,75.2,86.2,88.8),(81,'F',19,1.00000,81.65000,0.03485,73.9,76.1,87.3,89.9),(82,'F',20,1.00000,82.60000,0.03480,74.7,76.9,88.3,91.0),(83,'F',21,1.00000,83.55000,0.03475,75.6,77.8,89.4,92.1),(84,'F',22,1.00000,84.50000,0.03470,76.4,78.6,90.4,93.2),(85,'F',23,1.00000,85.45000,0.03465,77.2,79.5,91.5,94.3),(86,'F',24,1.00000,86.40000,0.03460,78.0,80.3,92.5,95.4),(87,'F',25,1.00000,87.12500,0.03458,78.7,81.0,93.2,96.2),(88,'F',26,1.00000,87.85000,0.03457,79.4,81.7,94.0,97.0),(89,'F',27,1.00000,88.57500,0.03455,80.1,82.4,94.7,97.7),(90,'F',28,1.00000,89.30000,0.03453,80.8,83.1,95.5,98.5),(91,'F',29,1.00000,90.02500,0.03452,81.5,83.8,96.2,99.3),(92,'F',30,1.00000,90.75000,0.03450,82.2,84.5,97.0,100.1),(93,'F',31,1.00000,91.47500,0.03448,82.9,85.2,97.7,100.8),(94,'F',32,1.00000,92.20000,0.03447,83.6,85.9,98.4,101.6),(95,'F',33,1.00000,92.92500,0.03445,84.3,86.6,99.2,102.4),(96,'F',34,1.00000,93.65000,0.03443,85.0,87.3,99.9,103.2),(97,'F',35,1.00000,94.37500,0.03442,85.7,88.0,100.7,103.9),(98,'F',36,1.00000,95.10000,0.03440,86.4,88.7,101.4,104.7),(99,'F',37,1.00000,95.73333,0.03438,87.0,89.3,102.1,105.4),(100,'F',38,1.00000,96.36667,0.03437,87.6,89.9,102.7,106.0),(101,'F',39,1.00000,97.00000,0.03435,88.2,90.6,103.4,106.7),(102,'F',40,1.00000,97.63333,0.03433,88.8,91.2,104.0,107.3),(103,'F',41,1.00000,98.26667,0.03432,89.4,91.8,104.7,108.0),(104,'F',42,1.00000,98.90000,0.03430,90.0,92.4,105.4,108.7),(105,'F',43,1.00000,99.53333,0.03428,90.6,93.0,106.0,109.3),(106,'F',44,1.00000,100.16667,0.03427,91.2,93.6,106.7,110.0),(107,'F',45,1.00000,100.80000,0.03425,91.8,94.3,107.3,110.6),(108,'F',46,1.00000,101.43333,0.03423,92.4,94.9,108.0,111.3),(109,'F',47,1.00000,102.06667,0.03422,93.0,95.5,108.6,111.9),(110,'F',48,1.00000,102.70000,0.03420,93.6,96.1,109.3,112.6),(111,'F',49,1.00000,103.25833,0.03418,94.1,96.6,109.9,113.2),(112,'F',50,1.00000,103.81667,0.03417,94.7,97.1,110.5,113.8),(113,'F',51,1.00000,104.37500,0.03415,95.2,97.7,111.1,114.4),(114,'F',52,1.00000,104.93333,0.03413,95.7,98.2,111.7,114.9),(115,'F',53,1.00000,105.49167,0.03412,96.2,98.7,112.3,115.5),(116,'F',54,1.00000,106.05000,0.03410,96.8,99.2,112.9,116.1),(117,'F',55,1.00000,106.60833,0.03408,97.3,99.7,113.5,116.7),(118,'F',56,1.00000,107.16667,0.03407,97.8,100.2,114.1,117.3),(119,'F',57,1.00000,107.72500,0.03405,98.3,100.8,114.7,117.9),(120,'F',58,1.00000,108.28333,0.03403,98.9,101.3,115.3,118.4),(121,'F',59,1.00000,108.84167,0.03402,99.4,101.8,115.9,119.0),(122,'F',60,1.00000,109.40000,0.03400,99.9,102.3,116.5,119.6);
/*!40000 ALTER TABLE `who_height_for_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `who_weight_for_age`
--

DROP TABLE IF EXISTS `who_weight_for_age`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `who_weight_for_age` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gender` char(1) NOT NULL COMMENT 'M untuk laki-laki, F untuk perempuan',
  `age_months` tinyint(3) unsigned NOT NULL COMMENT 'Usia dalam bulan (0-59)',
  `sd_minus3` decimal(5,2) NOT NULL COMMENT 'Standar deviasi -3 (Gizi Buruk)',
  `sd_minus2` decimal(5,2) NOT NULL COMMENT 'Standar deviasi -2 (Gizi Kurang)',
  `median` decimal(5,2) NOT NULL COMMENT 'Median (Normal)',
  `sd_plus2` decimal(5,2) NOT NULL COMMENT 'Standar deviasi +2 (Gizi Lebih)',
  `sd_plus3` decimal(5,2) NOT NULL COMMENT 'Standar deviasi +3',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_gender_age` (`gender`,`age_months`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `who_weight_for_age`
--

LOCK TABLES `who_weight_for_age` WRITE;
/*!40000 ALTER TABLE `who_weight_for_age` DISABLE KEYS */;
INSERT INTO `who_weight_for_age` VALUES (1,'M',0,2.10,2.50,3.30,4.40,5.00),(2,'M',1,2.90,3.40,4.50,5.80,6.60),(3,'M',2,3.80,4.30,5.60,7.10,8.00),(4,'M',3,4.40,5.00,6.40,8.00,9.00),(5,'M',4,4.90,5.60,7.00,8.70,9.70),(6,'M',5,5.30,6.00,7.50,9.30,10.40),(7,'M',6,5.70,6.40,7.90,9.80,10.90),(8,'M',7,5.90,6.70,8.30,10.30,11.40),(9,'M',8,6.20,6.90,8.60,10.70,11.90),(10,'M',9,6.40,7.10,8.90,11.00,12.30),(11,'M',10,6.60,7.40,9.20,11.40,12.70),(12,'M',11,6.80,7.60,9.40,11.70,13.00),(13,'M',12,6.90,7.70,9.60,12.00,13.30),(14,'M',13,7.10,7.90,9.90,12.30,13.70),(15,'M',14,7.20,8.10,10.10,12.60,14.00),(16,'M',15,7.40,8.30,10.30,12.80,14.30),(17,'M',16,7.50,8.40,10.50,13.10,14.60),(18,'M',17,7.70,8.60,10.70,13.40,14.90),(19,'M',18,7.80,8.80,10.90,13.70,15.30),(20,'M',19,8.00,8.90,11.10,14.00,15.60),(21,'M',20,8.10,9.10,11.30,14.20,15.90),(22,'M',21,8.20,9.20,11.50,14.50,16.20),(23,'M',22,8.40,9.40,11.80,14.70,16.50),(24,'M',23,8.50,9.50,12.00,15.00,16.80),(25,'M',24,8.60,9.70,12.20,15.30,17.10),(26,'M',25,8.80,9.80,12.40,15.50,17.50),(27,'M',26,8.90,10.00,12.50,15.80,17.80),(28,'M',27,9.00,10.10,12.70,16.10,18.10),(29,'M',28,9.10,10.20,12.90,16.30,18.40),(30,'M',29,9.20,10.40,13.10,16.60,18.70),(31,'M',30,9.40,10.50,13.30,16.90,19.00),(32,'M',31,9.50,10.70,13.50,17.10,19.30),(33,'M',32,9.60,10.80,13.70,17.40,19.60),(34,'M',33,9.70,10.90,13.80,17.60,19.90),(35,'M',34,9.80,11.00,14.00,17.80,20.20),(36,'M',35,9.90,11.20,14.20,18.10,20.40),(37,'M',36,10.00,11.30,14.30,18.30,20.70),(38,'M',37,10.10,11.40,14.50,18.60,21.00),(39,'M',38,10.20,11.50,14.70,18.80,21.30),(40,'M',39,10.30,11.60,14.80,19.00,21.60),(41,'M',40,10.40,11.80,15.00,19.30,21.90),(42,'M',41,10.50,11.90,15.20,19.50,22.10),(43,'M',42,10.60,12.00,15.30,19.70,22.40),(44,'M',43,10.70,12.10,15.50,20.00,22.70),(45,'M',44,10.80,12.20,15.70,20.20,23.00),(46,'M',45,10.90,12.40,15.80,20.50,23.30),(47,'M',46,11.00,12.50,16.00,20.70,23.60),(48,'M',47,11.10,12.60,16.20,20.90,23.90),(49,'M',48,11.20,12.70,16.30,21.20,24.20),(50,'M',49,11.30,12.80,16.50,21.40,24.50),(51,'M',50,11.40,12.90,16.70,21.70,24.80),(52,'M',51,11.50,13.10,16.80,21.90,25.10),(53,'M',52,11.60,13.20,17.00,22.20,25.40),(54,'M',53,11.70,13.30,17.20,22.40,25.70),(55,'M',54,11.80,13.40,17.30,22.70,26.00),(56,'M',55,11.90,13.50,17.50,22.90,26.30),(57,'M',56,12.00,13.60,17.70,23.20,26.60),(58,'M',57,12.10,13.70,17.80,23.40,26.90),(59,'M',58,12.20,13.80,18.00,23.70,27.20),(60,'M',59,12.30,14.00,18.20,23.90,27.50),(61,'F',0,2.00,2.40,3.20,4.20,4.80),(62,'F',1,2.70,3.20,4.20,5.50,6.20),(63,'F',2,3.40,3.90,5.10,6.60,7.50),(64,'F',3,4.00,4.50,5.80,7.50,8.50),(65,'F',4,4.40,5.00,6.40,8.20,9.30),(66,'F',5,4.80,5.40,6.90,8.80,10.00),(67,'F',6,5.10,5.70,7.30,9.30,10.60),(68,'F',7,5.30,6.00,7.60,9.80,11.10),(69,'F',8,5.60,6.30,7.90,10.20,11.60),(70,'F',9,5.80,6.50,8.20,10.50,12.00),(71,'F',10,5.90,6.70,8.50,10.90,12.40),(72,'F',11,6.10,6.90,8.70,11.20,12.80),(73,'F',12,6.30,7.00,8.90,11.50,13.10),(74,'F',13,6.40,7.20,9.20,11.80,13.50),(75,'F',14,6.60,7.40,9.40,12.10,13.80),(76,'F',15,6.70,7.60,9.60,12.40,14.10),(77,'F',16,6.90,7.70,9.80,12.60,14.50),(78,'F',17,7.00,7.90,10.00,12.90,14.80),(79,'F',18,7.20,8.10,10.20,13.20,15.10),(80,'F',19,7.30,8.20,10.40,13.50,15.40),(81,'F',20,7.50,8.40,10.60,13.70,15.70),(82,'F',21,7.60,8.60,10.90,14.00,16.00),(83,'F',22,7.80,8.70,11.10,14.30,16.40),(84,'F',23,7.90,8.90,11.30,14.60,16.70),(85,'F',24,8.10,9.00,11.50,14.80,17.00),(86,'F',25,8.20,9.20,11.70,15.10,17.30),(87,'F',26,8.40,9.40,11.90,15.40,17.70),(88,'F',27,8.50,9.50,12.10,15.70,18.00),(89,'F',28,8.60,9.70,12.30,15.90,18.30),(90,'F',29,8.80,9.80,12.50,16.20,18.60),(91,'F',30,8.90,10.00,12.70,16.50,18.90),(92,'F',31,9.00,10.10,12.90,16.80,19.30),(93,'F',32,9.10,10.30,13.10,17.00,19.60),(94,'F',33,9.30,10.40,13.30,17.30,19.90),(95,'F',34,9.40,10.50,13.50,17.60,20.20),(96,'F',35,9.50,10.70,13.70,17.80,20.50),(97,'F',36,9.60,10.80,13.90,18.10,20.90),(98,'F',37,9.70,10.90,14.00,18.30,21.20),(99,'F',38,9.80,11.10,14.20,18.60,21.50),(100,'F',39,9.90,11.20,14.40,18.80,21.80),(101,'F',40,10.10,11.30,14.60,19.10,22.10),(102,'F',41,10.20,11.50,14.80,19.40,22.50),(103,'F',42,10.30,11.60,15.00,19.60,22.80),(104,'F',43,10.40,11.70,15.20,19.90,23.10),(105,'F',44,10.50,11.80,15.30,20.10,23.40),(106,'F',45,10.60,12.00,15.50,20.40,23.70),(107,'F',46,10.70,12.10,15.70,20.70,24.10),(108,'F',47,10.80,12.20,15.90,20.90,24.40),(109,'F',48,10.90,12.30,16.10,21.20,24.70),(110,'F',49,11.00,12.40,16.30,21.50,25.00),(111,'F',50,11.10,12.60,16.40,21.70,25.30),(112,'F',51,11.20,12.70,16.60,22.00,25.70),(113,'F',52,11.30,12.80,16.80,22.20,26.00),(114,'F',53,11.40,12.90,17.00,22.50,26.30),(115,'F',54,11.50,13.00,17.20,22.80,26.60),(116,'F',55,11.60,13.20,17.30,23.00,27.00),(117,'F',56,11.70,13.30,17.50,23.30,27.30),(118,'F',57,11.80,13.40,17.70,23.60,27.60),(119,'F',58,11.90,13.50,17.90,23.80,27.90),(120,'F',59,12.00,13.70,18.10,24.10,28.30);
/*!40000 ALTER TABLE `who_weight_for_age` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `who_weight_for_height`
--

DROP TABLE IF EXISTS `who_weight_for_height`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `who_weight_for_height` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gender` enum('M','F') NOT NULL,
  `height_cm` decimal(5,1) NOT NULL COMMENT 'Tinggi badan dalam cm (45.0–120.0)',
  `l_value` decimal(8,5) NOT NULL,
  `m_value` decimal(8,5) NOT NULL,
  `s_value` decimal(8,5) NOT NULL,
  `sd_minus3` decimal(5,2) NOT NULL,
  `sd_minus2` decimal(5,2) NOT NULL,
  `sd_plus2` decimal(5,2) NOT NULL,
  `sd_plus3` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `who_weight_for_height_gender_height_cm_unique` (`gender`,`height_cm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `who_weight_for_height`
--

LOCK TABLES `who_weight_for_height` WRITE;
/*!40000 ALTER TABLE `who_weight_for_height` DISABLE KEYS */;
/*!40000 ALTER TABLE `who_weight_for_height` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-30 12:03:23
