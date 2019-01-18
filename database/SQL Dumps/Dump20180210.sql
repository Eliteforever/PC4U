-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: pc4u
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.17.10.1

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
-- Table structure for table `Addresses`
--

DROP TABLE IF EXISTS `Addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Addresses` (
  `id` int(11) NOT NULL,
  `streetName` varchar(45) DEFAULT NULL,
  `houseNumber` varchar(10) DEFAULT NULL,
  `postalCode` varchar(10) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Addresses`
--

LOCK TABLES `Addresses` WRITE;
/*!40000 ALTER TABLE `Addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `Addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ContactData`
--

DROP TABLE IF EXISTS `ContactData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContactData` (
  `id` int(11) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `addressID` int(11) NOT NULL,
  PRIMARY KEY (`addressID`),
  KEY `addressID_idx` (`addressID`),
  CONSTRAINT `id` FOREIGN KEY (`addressID`) REFERENCES `Addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContactData`
--

LOCK TABLES `ContactData` WRITE;
/*!40000 ALTER TABLE `ContactData` DISABLE KEYS */;
/*!40000 ALTER TABLE `ContactData` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrderProducts`
--

DROP TABLE IF EXISTS `OrderProducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderProducts` (
  `id` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_opProduct_idx` (`productID`),
  KEY `fk_opOrder_idx` (`orderID`),
  CONSTRAINT `fk_opOrder` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_opProduct` FOREIGN KEY (`productID`) REFERENCES `Products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderProducts`
--

LOCK TABLES `OrderProducts` WRITE;
/*!40000 ALTER TABLE `OrderProducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `OrderProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrderStatusHistory`
--

DROP TABLE IF EXISTS `OrderStatusHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderStatusHistory` (
  `id` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `orderStatusID` int(11) NOT NULL,
  `statusDatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oshOrder_idx` (`orderID`),
  KEY `fk_orderStatus_idx` (`orderStatusID`),
  CONSTRAINT `fk_orderStatus` FOREIGN KEY (`orderStatusID`) REFERENCES `OrderStatuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_oshOrder` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderStatusHistory`
--

LOCK TABLES `OrderStatusHistory` WRITE;
/*!40000 ALTER TABLE `OrderStatusHistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `OrderStatusHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrderStatuses`
--

DROP TABLE IF EXISTS `OrderStatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OrderStatuses` (
  `id` int(11) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrderStatuses`
--

LOCK TABLES `OrderStatuses` WRITE;
/*!40000 ALTER TABLE `OrderStatuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `OrderStatuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oUser_idx` (`userID`),
  CONSTRAINT `fk_oUser` FOREIGN KEY (`userID`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Orders`
--

LOCK TABLES `Orders` WRITE;
/*!40000 ALTER TABLE `Orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `Orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` mediumtext,
  `price` decimal(45,0) DEFAULT NULL,
  `btw` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Properties`
--

DROP TABLE IF EXISTS `Properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Properties` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` mediumtext,
  `categoryID` int(11) NOT NULL,
  `required` bit(1) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_idx` (`categoryID`),
  CONSTRAINT `fk_category` FOREIGN KEY (`categoryID`) REFERENCES `Categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Properties`
--

LOCK TABLES `Properties` WRITE;
/*!40000 ALTER TABLE `Properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `Properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PropertyValues`
--

DROP TABLE IF EXISTS `PropertyValues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PropertyValues` (
  `id` int(11) NOT NULL,
  `propertyID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pvProduct_idx` (`productID`),
  KEY `fk_property_idx` (`propertyID`),
  CONSTRAINT `fk_property` FOREIGN KEY (`propertyID`) REFERENCES `Properties` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pvProduct` FOREIGN KEY (`productID`) REFERENCES `Products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PropertyValues`
--

LOCK TABLES `PropertyValues` WRITE;
/*!40000 ALTER TABLE `PropertyValues` DISABLE KEYS */;
/*!40000 ALTER TABLE `PropertyValues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RepairProducts`
--

DROP TABLE IF EXISTS `RepairProducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RepairProducts` (
  `id` int(11) NOT NULL,
  `repairID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_repair_idx` (`repairID`),
  KEY `fk_rpProduct_idx` (`productID`),
  CONSTRAINT `fk_rpProduct` FOREIGN KEY (`productID`) REFERENCES `Products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rpRepair` FOREIGN KEY (`repairID`) REFERENCES `Repairs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RepairProducts`
--

LOCK TABLES `RepairProducts` WRITE;
/*!40000 ALTER TABLE `RepairProducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `RepairProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RepairStatusHistory`
--

DROP TABLE IF EXISTS `RepairStatusHistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RepairStatusHistory` (
  `id` int(11) NOT NULL,
  `repairID` int(11) NOT NULL,
  `repairStatusID` int(11) NOT NULL,
  `statusDatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_repair_idx` (`repairID`),
  KEY `fk_repairStatus_idx` (`repairStatusID`),
  CONSTRAINT `fk_repair` FOREIGN KEY (`repairID`) REFERENCES `Repairs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_repairStatus` FOREIGN KEY (`repairStatusID`) REFERENCES `RepairStatuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RepairStatusHistory`
--

LOCK TABLES `RepairStatusHistory` WRITE;
/*!40000 ALTER TABLE `RepairStatusHistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `RepairStatusHistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RepairStatuses`
--

DROP TABLE IF EXISTS `RepairStatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RepairStatuses` (
  `id` int(11) NOT NULL,
  `description` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RepairStatuses`
--

LOCK TABLES `RepairStatuses` WRITE;
/*!40000 ALTER TABLE `RepairStatuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `RepairStatuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Repairs`
--

DROP TABLE IF EXISTS `Repairs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Repairs` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `requestedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_idx` (`userID`),
  CONSTRAINT `fk_user` FOREIGN KEY (`userID`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Repairs`
--

LOCK TABLES `Repairs` WRITE;
/*!40000 ALTER TABLE `Repairs` DISABLE KEYS */;
/*!40000 ALTER TABLE `Repairs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StockProducts`
--

DROP TABLE IF EXISTS `StockProducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StockProducts` (
  `id` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stProduct_idx` (`productID`),
  CONSTRAINT `fk_stProduct` FOREIGN KEY (`productID`) REFERENCES `Products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StockProducts`
--

LOCK TABLES `StockProducts` WRITE;
/*!40000 ALTER TABLE `StockProducts` DISABLE KEYS */;
/*!40000 ALTER TABLE `StockProducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `addressID` int(11) NOT NULL,
  `deliveryAddressID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`addressID`,`deliveryAddressID`),
  KEY `bla_idx` (`addressID`),
  KEY `fk_deliveryAddress_idx` (`deliveryAddressID`),
  CONSTRAINT `fk_address` FOREIGN KEY (`addressID`) REFERENCES `Addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_deliveryAddress` FOREIGN KEY (`deliveryAddressID`) REFERENCES `Addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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

-- Dump completed on 2018-02-10  0:13:43
