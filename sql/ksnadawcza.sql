-- MariaDB dump 10.19  Distrib 10.6.4-MariaDB, for Linux (x86_64)
--
-- Host: 10.43.144.142    Database: ksnadawcza
-- ------------------------------------------------------
-- Server version       10.6.4-MariaDB-1:10.6.4+maria~focal

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
-- Table structure for table `Pismo`
--

DROP TABLE IF EXISTS `Pismo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pismo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tresc` varchar(255) NOT NULL,
  `numer` varchar(45) NOT NULL,
  `symbol` varchar(45) NOT NULL,
  `data_pisma` datetime NOT NULL,
  `nadawca_id` int(11) NOT NULL,
  `Pracownik_id` int(11) NOT NULL,
  `uwagi` varchar(255) DEFAULT NULL,
  `kierunek` varchar(1) NOT NULL DEFAULT 'W',
  `aktualne` char(1) NOT NULL DEFAULT 'T',
  `kategoria_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `adresat_idx` (`nadawca_id`),
  KEY `pracownik_idx` (`Pracownik_id`),
  KEY `kategoria_idx` (`kategoria_id`),
  CONSTRAINT `adresat` FOREIGN KEY (`nadawca_id`) REFERENCES `nadawca` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `kategoria` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `pracownik` FOREIGN KEY (`Pracownik_id`) REFERENCES `Pracownik` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Pismo_plik`
--

DROP TABLE IF EXISTS `Pismo_plik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pismo_plik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plik` mediumblob NOT NULL,
  `pismo_id` int(11) NOT NULL,
  `pracownik_id` int(11) NOT NULL,
  `nazwa_pliku` varchar(150) COLLATE utf8mb3_unicode_ci NOT NULL,
  `typ_pliku` varchar(150) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `rozmiar` int(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prac_id__idx` (`pracownik_id`),
  KEY `pismo_id__idx` (`pismo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Pismo_zmiany`
--

DROP TABLE IF EXISTS `Pismo_zmiany`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pismo_zmiany` (
  `tresc_new` varchar(255) NOT NULL,
  `tresc_old` varchar(255) NOT NULL,
  `symbol_new` varchar(45) NOT NULL,
  `symbol_old` varchar(45) NOT NULL,
  `numer_new` varchar(45) NOT NULL,
  `numer_old` varchar(45) NOT NULL,
  `nadawca_id_old` varchar(255) NOT NULL,
  `nadawca_id_new` int(11) NOT NULL,
  `pracownik_id` int(11) NOT NULL,
  `pismo_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_zmiany` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uwagi_old` varchar(255) DEFAULT NULL,
  `uwagi_new` varchar(255) DEFAULT NULL,
  `kierunek_old` varchar(1) DEFAULT NULL,
  `kierunek_new` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pismo_id` (`pismo_id`),
  KEY `pracownik_id` (`pracownik_id`),
  KEY `nadawca_id_new` (`nadawca_id_new`),
  CONSTRAINT `Pismo_zmiany_ibfk_2` FOREIGN KEY (`pracownik_id`) REFERENCES `Pracownik` (`id`),
  CONSTRAINT `Pismo_zmiany_ibfk_4` FOREIGN KEY (`nadawca_id_new`) REFERENCES `nadawca` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Pracownik`
--

DROP TABLE IF EXISTS `Pracownik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pracownik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Imie` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `Nazwisko` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  `komorg_id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  KEY `komorg_id_idx` (`komorg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kategoria`
--

DROP TABLE IF EXISTS `kategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `nazwa_UNIQUE` (`nazwa`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `komorg`
--

DROP TABLE IF EXISTS `komorg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `komorg` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `skrot` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nadawca`
--

DROP TABLE IF EXISTS `nadawca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nadawca` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nazwa` varchar(255) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pracownik_id` int(11) NOT NULL,
  `miasto` varchar(80) DEFAULT NULL,
  `adres` varchar(120) DEFAULT NULL,
  `kodpocztowy` varchar(6) DEFAULT NULL,
  `kraj` varchar(60) DEFAULT NULL,
  `wojewodztwo` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_UNIQUE` (`ID`),
  KEY `zapis_przez_idx` (`pracownik_id`),
  CONSTRAINT `zapis_przez` FOREIGN KEY (`pracownik_id`) REFERENCES `Pracownik` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-14 17:55:07
