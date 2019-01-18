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
-- Dumping data for table `Addresses`
--

LOCK TABLES pc4u.Images WRITE;
/*!40000 ALTER TABLE pc4u.Images DISABLE KEYS */;
INSERT INTO pc4u.Images VALUES (1, '/', 'testimage', NULL,NULL);
/*!40000 ALTER TABLE pc4u.Images ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES pc4u.Addresses WRITE;
/*!40000 ALTER TABLE pc4u.Addresses DISABLE KEYS */;
INSERT INTO pc4u.Addresses VALUES (1,'straatje','1337','2560XD','dorpje','2018-02-27 06:54:37','2018-02-27 06:54:37'),(2,'autistraat','123A','2020EZ','stadje',NULL,NULL);
/*!40000 ALTER TABLE pc4u.Addresses ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Categories`
--

LOCK TABLES pc4u.Categories WRITE;
/*!40000 ALTER TABLE pc4u.Categories DISABLE KEYS */;
INSERT INTO pc4u.Categories VALUES (1,'Processors','Een computer component voor je moeder\'s bord', 1, NULL,NULL);
/*!40000 ALTER TABLE pc4u.Categories ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ContactData`
--

LOCK TABLES pc4u.ContactData WRITE;
/*!40000 ALTER TABLE pc4u.ContactData DISABLE KEYS */;
INSERT INTO pc4u.ContactData VALUES (1,'bladiebla@gmail.com','0612345678',2,NULL,NULL);
/*!40000 ALTER TABLE pc4u.ContactData ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `OrderProducts`
--

LOCK TABLES pc4u.OrderProducts WRITE;
/*!40000 ALTER TABLE pc4u.OrderProducts DISABLE KEYS */;
INSERT INTO pc4u.OrderProducts VALUES (1,1,1,1,NULL,NULL);
/*!40000 ALTER TABLE pc4u.OrderProducts ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `OrderStatusHistory`
--

LOCK TABLES pc4u.OrderStatusHistory WRITE;
/*!40000 ALTER TABLE pc4u.OrderStatusHistory DISABLE KEYS */;
INSERT INTO pc4u.OrderStatusHistory VALUES (1,1,1,'2011-12-18 13:17:17',NULL,NULL);
/*!40000 ALTER TABLE pc4u.OrderStatusHistory ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `OrderStatuses`
--

LOCK TABLES pc4u.OrderStatuses WRITE;
/*!40000 ALTER TABLE pc4u.OrderStatuses DISABLE KEYS */;
INSERT INTO pc4u.OrderStatuses VALUES (1,'Order is ontvangen',NULL,NULL),(2,'Order wordt verwerkt',NULL,NULL),(3,'Order is op weg naar het postkantoor',NULL,NULL),(4,'Order is op gearriveerd op het postkantoor',NULL,NULL);
/*!40000 ALTER TABLE pc4u.OrderStatuses ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Orders`
--

LOCK TABLES pc4u.Orders WRITE;
/*!40000 ALTER TABLE pc4u.Orders DISABLE KEYS */;
INSERT INTO pc4u.Orders VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE pc4u.Orders ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Products`
--

LOCK TABLES pc4u.Products WRITE;
/*!40000 ALTER TABLE pc4u.Products DISABLE KEYS */;
INSERT INTO pc4u.Products VALUES (1,'Intel i9 1337','Intel processor i9 met leuke dingetjes',512.00,21.00, 1, NULL,NULL);
/*!40000 ALTER TABLE pc4u.Products ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Properties`
--

LOCK TABLES pc4u.Properties WRITE;
/*!40000 ALTER TABLE pc4u.Properties DISABLE KEYS */;
INSERT INTO pc4u.Properties VALUES (1,'Kloksnelheid','De kloksnelheid, vaak uitgedrukt in hertz of een veelvoud daarvan, duidt aan hoe vaak per seconde een signaal gelezen, geschreven of verwerkt wordt in bijvoorbeeld de processor van een computer. Bij een computer is het vaak bepaald door de frequentie van een kristaloscillator. Typisch voor deze kristaloscillator is een vaste sinusoïdale golfvorm, het frequentie-referentie-signaal. Elektronische circuits vertalen de golfvorm in een vierkante golf van dezelfde frequentie.\n\nEen kloksnelheid van 1 Hz komt overeen met één bewerking per seconde. Wanneer men spreekt over de kloksnelheid van een computer, wordt hiermee meestal de kloksnelheid van de processor bedoeld. Moderne processors werken rond de 3 GHz. Ze voeren dus 3 miljard keer per seconde hun bewerkingen uit.\'\n\nDe kloksnelheid wordt dikwijls genoemd als de bepalende factor voor de snelheid van een systeem. De architectuur van een processor is echter minstens even belangrijk. Een processor van 3 GHz kan in de praktijk sneller werken dan een processor van 4 GHz, omdat deze een efficiëntere architectuur kan hebben. Aan hoge kloksnelheden zijn ook nadelen verbonden: de chips zijn duurder en moeilijker te fabriceren, en ze verbruiken meer stroom. Bovendien worden processoren met een hogere kloksnelheid warmer waardoor de levensduur afneemt.',1,'',' Hz',NULL,NULL),(2,'Cache','Een cache (spreek uit: kesj of kasj, van het Franse werkwoord \'cacher\', verbergen) is een opslagplaats waarin gegevens tijdelijk worden opgeslagen om sneller toegang tot deze data mogelijk te maken. Essentieel van een cache is ook dat het transparant is in die zin dat het bij het ophalen van data niet zichtbaar is of het bij de originele bron wordt opgehaald of uit de cache wordt gehaald, afgezien van de korte toegangstijd.\n\nHet opslaan van gegevens op een sneller medium om sneller toegang tot deze data te hebben wordt caching genoemd. De term cache wordt meestal gebruikt voor zowel de data die gecachet worden als voor de opslagplaats waar deze data gecachet worden.',1,'',' mb',NULL,NULL);
/*!40000 ALTER TABLE pc4u.Properties ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `PropertyValues`
--

LOCK TABLES pc4u.PropertyValues WRITE;
/*!40000 ALTER TABLE pc4u.PropertyValues DISABLE KEYS */;
INSERT INTO pc4u.PropertyValues VALUES (1,1,1,'3200',NULL,NULL),(2,2,1,'100',NULL,NULL);
/*!40000 ALTER TABLE pc4u.PropertyValues ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `RepairProducts`
--

LOCK TABLES pc4u.RepairProducts WRITE;
/*!40000 ALTER TABLE pc4u.RepairProducts DISABLE KEYS */;
/*!40000 ALTER TABLE pc4u.RepairProducts ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `RepairStatusHistory`
--

LOCK TABLES pc4u.RepairStatusHistory WRITE;
/*!40000 ALTER TABLE pc4u.RepairStatusHistory DISABLE KEYS */;
/*!40000 ALTER TABLE pc4u.RepairStatusHistory ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `RepairStatuses`
--

LOCK TABLES pc4u.RepairStatuses WRITE;
/*!40000 ALTER TABLE pc4u.RepairStatuses DISABLE KEYS */;
/*!40000 ALTER TABLE pc4u.RepairStatuses ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `Repairs`
--

LOCK TABLES pc4u.Repairs WRITE;
/*!40000 ALTER TABLE pc4u.Repairs DISABLE KEYS */;
/*!40000 ALTER TABLE pc4u.Repairs ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `StockProducts`
--

LOCK TABLES pc4u.StockProducts WRITE;
/*!40000 ALTER TABLE pc4u.StockProducts DISABLE KEYS */;
INSERT INTO pc4u.StockProducts VALUES (1,1,13,NULL,NULL);
/*!40000 ALTER TABLE pc4u.StockProducts ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES pc4u.users WRITE;
/*!40000 ALTER TABLE pc4u.users DISABLE KEYS */;
INSERT INTO pc4u.users VALUES (1,'qwe@qwe.nl','$2y$10$61oVEMSJ/DkUPnAtd1CjpurNT300VqDp3byDh0VlLZ.y5Rn7eX/Xe','errie','win',1,1,1,NULL,'2018-02-27 06:54:37','2018-02-27 06:54:37');
/*!40000 ALTER TABLE pc4u.users ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-27 11:17:38

