-- MySQL dump 10.13  Distrib 8.0.17, for Linux (x86_64)
--
-- Host: localhost    Database: kurikulum
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kurikulum`
--

DROP TABLE IF EXISTS `kurikulum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kurikulum` (
  `id` char(36) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `aktif` tinyint(1) DEFAULT '0',
  `nama` varchar(100) NOT NULL,
  `nama_inggris` varchar(100) NOT NULL,
  `sks_lulus` tinyint(4) unsigned NOT NULL,
  `sks_wajib` tinyint(4) unsigned NOT NULL,
  `sks_pilihan` tinyint(4) unsigned NOT NULL,
  `semester_normal` tinyint(4) NOT NULL,
  `tahun_mulai` smallint(6) NOT NULL,
  `tahun_selesai` smallint(6) NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_prodi` (`id_prodi`),
  CONSTRAINT `kurikulum_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kurikulum`
--

LOCK TABLES `kurikulum` WRITE;
/*!40000 ALTER TABLE `kurikulum` DISABLE KEYS */;
INSERT INTO `kurikulum` VALUES ('45cf2895-e52a-4afe-ba35-30f98f9aa5c7',1,0,'Kurikulum 2000 S1 Informatika','Curriculum 2000 Bachelor Degree of Informatics',144,120,24,8,2000,2004,'ganjil','2019-12-08 10:10:07','2019-12-08 10:10:07',NULL);
/*!40000 ALTER TABLE `kurikulum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mata_kuliah`
--

DROP TABLE IF EXISTS `mata_kuliah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mata_kuliah` (
  `id` char(36) NOT NULL,
  `id_rmk` char(36) NOT NULL,
  `kode_matkul` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_inggris` varchar(100) NOT NULL,
  `deskripsi` text,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_rmk` (`id_rmk`),
  CONSTRAINT `mata_kuliah_ibfk_1` FOREIGN KEY (`id_rmk`) REFERENCES `rmk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mata_kuliah`
--

LOCK TABLES `mata_kuliah` WRITE;
/*!40000 ALTER TABLE `mata_kuliah` DISABLE KEYS */;
/*!40000 ALTER TABLE `mata_kuliah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mk_kurikulum`
--

DROP TABLE IF EXISTS `mk_kurikulum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mk_kurikulum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mk` char(36) NOT NULL,
  `id_kurikulum` char(36) DEFAULT NULL,
  `sifat` enum('pilihan','wajib') NOT NULL,
  `sks` tinyint(4) NOT NULL,
  `semester` tinyint(4) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mk` (`id_mk`),
  KEY `id_kurikulum` (`id_kurikulum`),
  CONSTRAINT `mk_kurikulum_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id`),
  CONSTRAINT `mk_kurikulum_ibfk_2` FOREIGN KEY (`id_kurikulum`) REFERENCES `kurikulum` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mk_kurikulum`
--

LOCK TABLES `mk_kurikulum` WRITE;
/*!40000 ALTER TABLE `mk_kurikulum` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_kurikulum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mk_prasyarat`
--

DROP TABLE IF EXISTS `mk_prasyarat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mk_prasyarat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mk_utama` char(36) NOT NULL,
  `id_mk_syarat` char(36) NOT NULL,
  `jenis` enum('diambil_bersamaan','sudah_ambil') NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mk_utama` (`id_mk_utama`),
  KEY `id_mk_syarat` (`id_mk_syarat`),
  CONSTRAINT `mk_prasyarat_ibfk_1` FOREIGN KEY (`id_mk_utama`) REFERENCES `mata_kuliah` (`id`),
  CONSTRAINT `mk_prasyarat_ibfk_2` FOREIGN KEY (`id_mk_syarat`) REFERENCES `mata_kuliah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mk_prasyarat`
--

LOCK TABLES `mk_prasyarat` WRITE;
/*!40000 ALTER TABLE `mk_prasyarat` DISABLE KEYS */;
/*!40000 ALTER TABLE `mk_prasyarat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pokok_bahasan`
--

DROP TABLE IF EXISTS `pokok_bahasan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pokok_bahasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mk` char(36) NOT NULL,
  `deskripsi` text NOT NULL,
  `deskripsi_inggris` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mk` (`id_mk`),
  CONSTRAINT `pokok_bahasan_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokok_bahasan`
--

LOCK TABLES `pokok_bahasan` WRITE;
/*!40000 ALTER TABLE `pokok_bahasan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pokok_bahasan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodi`
--

DROP TABLE IF EXISTS `prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kaprodi` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_inggris` varchar(100) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kaprodi` (`id_kaprodi`),
  CONSTRAINT `prodi_ibfk_1` FOREIGN KEY (`id_kaprodi`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodi`
--

LOCK TABLES `prodi` WRITE;
/*!40000 ALTER TABLE `prodi` DISABLE KEYS */;
INSERT INTO `prodi` VALUES (1,1,'S1 Informatika','Bachelor Degree of Informatics','2019-12-08 09:58:16','2019-12-08 09:58:16',NULL);
/*!40000 ALTER TABLE `prodi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pustaka`
--

DROP TABLE IF EXISTS `pustaka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pustaka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(100) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `tahun_terbit` smallint(6) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `lokasi_penerbit` varchar(100) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pustaka`
--

LOCK TABLES `pustaka` WRITE;
/*!40000 ALTER TABLE `pustaka` DISABLE KEYS */;
/*!40000 ALTER TABLE `pustaka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pustaka_mk`
--

DROP TABLE IF EXISTS `pustaka_mk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pustaka_mk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pustaka` int(11) NOT NULL,
  `id_mk` char(36) NOT NULL,
  `tipe` enum('utama','penunjang') NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pustaka` (`id_pustaka`),
  KEY `id_mk` (`id_mk`),
  CONSTRAINT `pustaka_mk_ibfk_1` FOREIGN KEY (`id_pustaka`) REFERENCES `pustaka` (`id`),
  CONSTRAINT `pustaka_mk_ibfk_2` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pustaka_mk`
--

LOCK TABLES `pustaka_mk` WRITE;
/*!40000 ALTER TABLE `pustaka_mk` DISABLE KEYS */;
/*!40000 ALTER TABLE `pustaka_mk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rmk`
--

DROP TABLE IF EXISTS `rmk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rmk` (
  `id` char(36) NOT NULL,
  `id_kurikulum` char(36) NOT NULL,
  `id_ketua` int(11) NOT NULL,
  `kode_rmk` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_inggris` varchar(100) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kurikulum` (`id_kurikulum`),
  KEY `id_ketua` (`id_ketua`),
  CONSTRAINT `rmk_ibfk_1` FOREIGN KEY (`id_kurikulum`) REFERENCES `kurikulum` (`id`),
  CONSTRAINT `rmk_ibfk_2` FOREIGN KEY (`id_ketua`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rmk`
--

LOCK TABLES `rmk` WRITE;
/*!40000 ALTER TABLE `rmk` DISABLE KEYS */;
/*!40000 ALTER TABLE `rmk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'kaprodi','Kaprodi Dummy','$2y$12$whUd6w10eISwKivjsBu4Xeua7OqlaTNQc.Q8nbtJG81Q88QVy5MuC',5,'2019-12-08 09:56:31','2019-12-08 09:56:31',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-08 17:11:04