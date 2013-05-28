-- MySQL dump 10.13  Distrib 5.1.67, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: Coder4Hire
-- ------------------------------------------------------
-- Server version	5.1.67

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
-- Table structure for table `Job_Applications`
--

DROP TABLE IF EXISTS `Job_Applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Job_Applications` (
  `ApplicationID` int(100) NOT NULL AUTO_INCREMENT,
  `JobID` int(100) NOT NULL,
  `OwnerID` varchar(64) NOT NULL,
  `Comment` varchar(128) NOT NULL,
  `Cost` int(3) NOT NULL DEFAULT '0',
  `Revoked` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ApplicationID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Job_Applications`
--

LOCK TABLES `Job_Applications` WRITE;
/*!40000 ALTER TABLE `Job_Applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `Job_Applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Job_Comments`
--

DROP TABLE IF EXISTS `Job_Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Job_Comments` (
  `CommentID` int(128) NOT NULL AUTO_INCREMENT,
  `OwnerID` varchar(64) NOT NULL,
  `JobID` int(10) NOT NULL,
  `Comment` varchar(128) NOT NULL,
  PRIMARY KEY (`CommentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Job_Comments`
--

LOCK TABLES `Job_Comments` WRITE;
/*!40000 ALTER TABLE `Job_Comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `Job_Comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Job_Feedback`
--

DROP TABLE IF EXISTS `Job_Feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Job_Feedback` (
  `JobID` int(10) NOT NULL,
  `HirerFeedback` int(1) NOT NULL DEFAULT '0',
  `CoderFeedback` int(1) NOT NULL DEFAULT '0',
  `HirerComment` varchar(128) NOT NULL,
  `CoderComment` varchar(128) NOT NULL,
  PRIMARY KEY (`JobID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Job_Feedback`
--

LOCK TABLES `Job_Feedback` WRITE;
/*!40000 ALTER TABLE `Job_Feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `Job_Feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Jobs`
--

DROP TABLE IF EXISTS `Jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Jobs` (
  `JobID` int(10) NOT NULL AUTO_INCREMENT,
  `OwnerID` varchar(64) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Price` int(3) NOT NULL,
  `Description` varchar(256) NOT NULL,
  `JobTime` datetime NOT NULL,
  `JobCreated` datetime NOT NULL,
  `Accepted_ID` varchar(64) NOT NULL DEFAULT '',
  `Finished` int(1) NOT NULL DEFAULT '0',
  `Closed` int(1) NOT NULL,
  `Close_Reason` varchar(128) NOT NULL,
  `Tags` varchar(64) NOT NULL,
  PRIMARY KEY (`JobID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Jobs`
--

LOCK TABLES `Jobs` WRITE;
/*!40000 ALTER TABLE `Jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reports`
--

DROP TABLE IF EXISTS `Reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reports` (
  `ReportID` int(16) NOT NULL AUTO_INCREMENT,
  `ReporterID` varchar(64) NOT NULL,
  `WarningID` varchar(64) NOT NULL,
  `Type` varchar(32) NOT NULL,
  `Message` varchar(128) NOT NULL,
  PRIMARY KEY (`ReportID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reports`
--

LOCK TABLES `Reports` WRITE;
/*!40000 ALTER TABLE `Reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `Reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Scripts`
--

DROP TABLE IF EXISTS `Scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Scripts` (
  `ScriptID` int(10) NOT NULL AUTO_INCREMENT,
  `OwnerID` varchar(64) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Price` int(3) NOT NULL,
  `Description` varchar(256) NOT NULL,
  `Image_1` varchar(256) NOT NULL,
  `TImeCreated` datetime NOT NULL,
  `Closed` int(1) NOT NULL DEFAULT '0',
  `Close_Reason` varchar(128) NOT NULL,
  `Tags` varchar(64) NOT NULL,
  PRIMARY KEY (`ScriptID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Scripts`
--

LOCK TABLES `Scripts` WRITE;
/*!40000 ALTER TABLE `Scripts` DISABLE KEYS */;
/*!40000 ALTER TABLE `Scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `CoderRep_UP` int(2) NOT NULL DEFAULT '0',
  `HireRep_UP` int(2) NOT NULL DEFAULT '0',
  `CoderRep_DOWN` int(2) NOT NULL DEFAULT '0',
  `HireRep_DOWN` int(2) NOT NULL DEFAULT '0',
  `SteamID64` varchar(64) NOT NULL,
  `EMail` varchar(128) NOT NULL,
  `Activation_Key` varchar(64) NOT NULL,
  `Activated` int(1) NOT NULL DEFAULT '0',
  `Banned` int(1) NOT NULL DEFAULT '0',
  `BanTime` datetime DEFAULT NULL,
  `Banner` varchar(64) NOT NULL,
  `Moderator` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `SteamID64` (`SteamID64`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-18 17:00:01
