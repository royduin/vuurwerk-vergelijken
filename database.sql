-- MySQL dump 10.13  Distrib 5.6.35, for osx10.9 (x86_64)
--
-- Host: localhost    Database: vuurwerk-vergelijken
-- ------------------------------------------------------
-- Server version	5.6.35

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
-- Table structure for table `beoordelingen`
--

DROP TABLE IF EXISTS `beoordelingen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beoordelingen` (
  `beoordeling_id` int(255) NOT NULL AUTO_INCREMENT,
  `product_id` int(255) NOT NULL,
  `winkel_id` int(255) NOT NULL,
  `ip_adres` varchar(25) NOT NULL,
  `beoordeling` int(1) NOT NULL,
  PRIMARY KEY (`beoordeling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beoordelingen`
--

LOCK TABLES `beoordelingen` WRITE;
/*!40000 ALTER TABLE `beoordelingen` DISABLE KEYS */;
/*!40000 ALTER TABLE `beoordelingen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filialen`
--

DROP TABLE IF EXISTS `filialen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filialen` (
  `filiaal_id` int(11) NOT NULL AUTO_INCREMENT,
  `winkel_id` int(11) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `plaats` varchar(255) NOT NULL,
  `provincie` varchar(255) NOT NULL,
  `telefoon` varchar(20) NOT NULL,
  `lat` varchar(20) NOT NULL,
  `lng` varchar(20) NOT NULL,
  PRIMARY KEY (`filiaal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filialen`
--

LOCK TABLES `filialen` WRITE;
/*!40000 ALTER TABLE `filialen` DISABLE KEYS */;
/*!40000 ALTER TABLE `filialen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruikers`
--

DROP TABLE IF EXISTS `gebruikers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruikers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `weergave_naam` varchar(20) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruikers`
--

LOCK TABLES `gebruikers` WRITE;
/*!40000 ALTER TABLE `gebruikers` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruikers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruikers_groepen`
--

DROP TABLE IF EXISTS `gebruikers_groepen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruikers_groepen` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruikers_groepen`
--

LOCK TABLES `gebruikers_groepen` WRITE;
/*!40000 ALTER TABLE `gebruikers_groepen` DISABLE KEYS */;
INSERT INTO `gebruikers_groepen` VALUES (1,'admin','Administrator'),(2,'gebruiker','Gebruiker');
/*!40000 ALTER TABLE `gebruikers_groepen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruikers_groepen_fk`
--

DROP TABLE IF EXISTS `gebruikers_groepen_fk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruikers_groepen_fk` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `gebruikers_groepen` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruikers_groepen_fk`
--

LOCK TABLES `gebruikers_groepen_fk` WRITE;
/*!40000 ALTER TABLE `gebruikers_groepen_fk` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruikers_groepen_fk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gebruikers_login`
--

DROP TABLE IF EXISTS `gebruikers_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gebruikers_login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gebruikers_login`
--

LOCK TABLES `gebruikers_login` WRITE;
/*!40000 ALTER TABLE `gebruikers_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `gebruikers_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `importeurs`
--

DROP TABLE IF EXISTS `importeurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `importeurs` (
  `importeur_id` int(255) NOT NULL AUTO_INCREMENT,
  `importeur_naam` varchar(255) NOT NULL,
  `importeur_slug` varchar(255) NOT NULL,
  `importeur_omschrijving` text NOT NULL,
  PRIMARY KEY (`importeur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `importeurs`
--

LOCK TABLES `importeurs` WRITE;
/*!40000 ALTER TABLE `importeurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `importeurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merken`
--

DROP TABLE IF EXISTS `merken`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merken` (
  `merk_id` int(11) NOT NULL AUTO_INCREMENT,
  `merk_naam` varchar(255) NOT NULL,
  `merk_slug` varchar(255) NOT NULL,
  `merk_omschrijving` text NOT NULL,
  `merk_omschrijving_meta` varchar(255) NOT NULL,
  PRIMARY KEY (`merk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merken`
--

LOCK TABLES `merken` WRITE;
/*!40000 ALTER TABLE `merken` DISABLE KEYS */;
/*!40000 ALTER TABLE `merken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijzen`
--

DROP TABLE IF EXISTS `prijzen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prijzen` (
  `prijs_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `prijs` decimal(10,2) NOT NULL,
  `jaar` int(4) NOT NULL,
  `winkel_id` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  `gekeurd` tinyint(1) NOT NULL,
  `ip_adres` varchar(25) NOT NULL,
  `bron` varchar(255) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  PRIMARY KEY (`prijs_id`),
  UNIQUE KEY `Unieke prijs` (`product_id`,`jaar`,`winkel_id`,`aantal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijzen`
--

LOCK TABLES `prijzen` WRITE;
/*!40000 ALTER TABLE `prijzen` DISABLE KEYS */;
/*!40000 ALTER TABLE `prijzen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producten`
--

DROP TABLE IF EXISTS `producten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producten` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `soort_id` int(1) NOT NULL,
  `artikelnummer` varchar(255) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `merk_id` int(11) NOT NULL,
  `importeur_id` int(11) NOT NULL,
  `aantal` int(11) DEFAULT NULL,
  `gram` decimal(11,2) DEFAULT NULL,
  `tube` decimal(11,2) DEFAULT NULL,
  `schoten` int(11) DEFAULT NULL,
  `duur` int(11) DEFAULT NULL,
  `hoogte` int(11) DEFAULT NULL,
  `lengte` int(11) DEFAULT NULL,
  `inch` decimal(11,2) DEFAULT NULL,
  `nieuw` int(4) DEFAULT NULL,
  `buitenland` tinyint(1) NOT NULL DEFAULT '0',
  `video` varchar(255) NOT NULL,
  `omschrijving` text NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `gekeurd` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `artikelnummer` (`artikelnummer`,`merk_id`),
  UNIQUE KEY `slug` (`slug`,`merk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producten`
--

LOCK TABLES `producten` WRITE;
/*!40000 ALTER TABLE `producten` DISABLE KEYS */;
/*!40000 ALTER TABLE `producten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soorten`
--

DROP TABLE IF EXISTS `soorten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soorten` (
  `soort_id` int(11) NOT NULL AUTO_INCREMENT,
  `soort_naam` varchar(255) NOT NULL,
  `soort_naam_enkel` varchar(255) NOT NULL,
  `soort_slug` varchar(255) NOT NULL,
  `soort_omschrijving_kort` text NOT NULL,
  `soort_omschrijving_lang` text NOT NULL,
  `soort_omschrijving_meta` varchar(255) NOT NULL,
  `soort_afbeelding` varchar(255) NOT NULL,
  `soort_specificaties` varchar(255) NOT NULL,
  `soort_vuurwerktitel` tinyint(1) NOT NULL,
  `soort_volgorde` int(11) NOT NULL,
  PRIMARY KEY (`soort_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soorten`
--

LOCK TABLES `soorten` WRITE;
/*!40000 ALTER TABLE `soorten` DISABLE KEYS */;
INSERT INTO `soorten` VALUES (1,'Cakes','cake','cakes','Vuurwerk cakes bestaan uit een aantal kleine shells, meestal hebben deze meerdere effecten met als resultaat een prachtige vuurwerk show.','Cakes zijn razend populair bij consumenten, dit komt doordat deze slechts eenmaal aangestoken hoeven te worden waarna er een geweldige vuurwerk show te bezichtigen is. Tevens loop je minder risico bij een cake doordat deze meestal verzwaard zijn met klei zodat deze niet om kan vallen of waaien. Mede door de populariteit van cakes zijn er meerdere soorten ontstaan. Bijvoorbeeld de V-vorm (deze schiet meestal tegelijk naar links en rechts), de W-vorm (deze schiet naar links, rechts én recht omhoog) en de F-vorm (een waaier van links naar rechts waarbij de F staat voor fan, waaier in het Engels).','Alle vuurwerk cakes eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','cakes.jpg','gram,tube,schoten,duur,hoogte',0,1),(2,'Vuurpijlen','vuurpijlen','vuurpijlen','De oudste soort vuurwerk, aangedreven door een pyrotechnisch mengsel met vervolgens een prachtige explosie als resultaat.','Een vuurpijl is eigenlijk een kleine raket die aangedreven wordt door een pyrotechnisch mengsel dat door de druk bij ontbranding zich voortstuwt.','Alle vuurpijlen eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','vuurpijlen.jpg','aantal,gram,hoogte',1,2),(3,'Pakketten','pakket','pakketten','Vuurwerk pakketten bestaan meestal uit aan aantal cakes, fonteinen en vuurpijlen. Met een mooi pakket heb je alles in huis voor een knallende jaarwisseling!','Bekijk en vergelijk alle pakketten!','Alle vuurwerk pakketten eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','pakketten.jpg','aantal,gram',0,4),(4,'Matten','mat','matten','Ook wel chinese rol of ratelband genoemd, een \"must have\" in je vuurwerk collectie, tegenwoordig vrijwel allemaal voorzien van een eind bom.','Bekijk en vergelijk alle matten!','Alle vuurwerk matten eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','matten.jpg','aantal,gram,lengte,duur',0,5),(5,'Fonteinen','fontein','fonteinen','','Bekijk en vergelijk alle fonteinen!','Alle vuurwerk fonteinen eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','fonteinen.jpg','gram,duur,hoogte',0,6),(6,'Knalvuurwerk','knalvuurwerk','knalvuurwerk','','Bekijk en vergelijk al het knalvuurwerk!','Al het knalvuurwerk eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','knalvuurwerk.jpg','aantal,gram',1,7),(7,'Klein siervuurwerk','siervuurwerk','klein-siervuurwerk','','Bekijk en vergelijk al het kleine siervuurwerk!','Al het siervuurwerk eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','klein-siervuurwerk.jpg','aantal,gram,duur',1,8),(8,'Romeinse kaarsen','romeinse kaarsen','romeinse-kaarsen','','Bekijk en vergelijk alle romeinse kaarsen!','Alle romeinse kaarsen eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','romeinse-kaarsen.jpg','aantal,schoten,gram,hoogte,duur',1,9),(9,'Mortieren','mortieren','mortieren','','Bekijk en vergelijk alle mortieren!','Alle vuurwerk mortieren eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','mortieren.jpg','aantal,gram,hoogte',0,10),(10,'Shells','shell','shells','','Bekijk en vergelijk alle shells!','Alle vuurwerk shells eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','shells.jpg','inch,gram,hoogte',0,11),(11,'Cakeboxen','cakebox','cakeboxen','Meerdere op elkaar afgestemde cakes in een doos, veelal zijn de cakes voorzien van een tweede lont zodat het mogelijk is om deze door te lonten.','Bekijk en vergelijk alle cakeboxen!','Alle vuurwerk cakeboxen eenvoudig vergelijken! ✓ Op prijs en specificaties ✓ Alle vuurwerk winkels','cakebox.jpg','aantal,gram,tube,schoten,duur,hoogte',0,3);
/*!40000 ALTER TABLE `soorten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `gekeurd` tinyint(1) NOT NULL,
  `ip_adres` varchar(25) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `winkels`
--

DROP TABLE IF EXISTS `winkels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `winkels` (
  `winkel_id` int(11) NOT NULL AUTO_INCREMENT,
  `winkel_naam` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `omschrijving` text NOT NULL,
  `omschrijving_meta` varchar(255) NOT NULL,
  `affiliate` tinyint(1) NOT NULL,
  `gemiddeld` int(11) NOT NULL,
  PRIMARY KEY (`winkel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `winkels`
--

LOCK TABLES `winkels` WRITE;
/*!40000 ALTER TABLE `winkels` DISABLE KEYS */;
/*!40000 ALTER TABLE `winkels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-27 17:24:16
