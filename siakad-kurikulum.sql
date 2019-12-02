-- MySQL dump 10.13  Distrib 8.0.17, for Linux (x86_64)
--
-- Host: localhost    Database: siakad-kurikulum
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
  `id_kaprodi` int(11) NOT NULL,
  `aktif` tinyint(1) DEFAULT '0',
  `nama` varchar(100) NOT NULL,
  `nama_inggris` varchar(100) NOT NULL,
  `sks_lulus` tinyint(4) NOT NULL,
  `sks_wajib` tinyint(4) NOT NULL,
  `sks_pilihan` tinyint(4) NOT NULL,
  `semester_normal` tinyint(4) NOT NULL,
  `tahun_mulai` smallint(6) NOT NULL,
  `tahun_selesai` smallint(6) NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kaprodi` (`id_kaprodi`),
  CONSTRAINT `kurikulum_ibfk_1` FOREIGN KEY (`id_kaprodi`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `pokok_bahasan_mk`
--

DROP TABLE IF EXISTS `pokok_bahasan_mk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pokok_bahasan_mk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mk` char(36) NOT NULL,
  `deskripsi` text NOT NULL,
  `deskripsi_inggris` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_mk` (`id_mk`),
  CONSTRAINT `pokok_bahasan_mk_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-02 14:54:54
