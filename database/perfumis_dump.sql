-- MySQL dump 10.13  Distrib 9.3.0, for macos14.7 (x86_64)
--
-- Host: localhost    Database: perfumis_db
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `category_type` enum('standard','featured') DEFAULT 'standard',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Men\'s Fragrance','standard'),(2,'Women\'s Fragrance','standard'),(3,'Unisex','standard'),(4,'Luxury Scents','featured'),(5,'Best Sellers','featured'),(6,'New Arrivals','featured'),(7,'Gift Sets','featured'),(8,'Everyday Wear','standard'),(9,'Citrus Fresh','standard'),(10,'Floral Bouquet','standard'),(11,'Woody & Warm','standard'),(12,'Oriental Spice','standard'),(13,'Aquatic Fresh','standard'),(14,'Gourmand Sweet','standard'),(15,'Limited Edition','featured'),(16,'Travel Size','standard');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,1,89.99),(2,2,2,1,120.00),(3,2,3,1,105.50);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `order_type` enum('Online','In-Store') DEFAULT NULL,
  `channel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,89.99,'2025-05-30 00:53:12','Online','web'),(2,3,225.50,'2025-05-30 00:53:12','Online','mobile'),(3,4,120.00,'2025-06-20 01:44:19','Online','web'),(4,5,685.49,'2025-07-13 10:44:19','Online','web');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Rose Bloom','A romantic floral scent with hints rose and jasmine. Perfect for special occasions and romantic evenings.',89.99,50,1,'perfume_images/rose_bloom.jpg','2025-05-30 00:52:57'),(2,'Oud Intense','Deep woody fragrance with spicy undertones. Sophisticated and long-lasting for evening wear.',120.00,25,2,'perfume_images/oud_intense.jpg','2025-05-30 00:52:57'),(3,'Mystic Amber','Warm oriental scent with amber and vanilla. Cozy and comforting for daily elegance.',105.50,30,3,'perfume_images/mystic_amber.jpg','2025-05-30 00:52:57'),(4,'Ethereal Garden','Delicate blend of white florals with gardenia and lily. Fresh and elegant for spring days.',94.50,35,2,'perfume_images/anna-daudelin-m9lnm9jL918-unsplash_resized.jpeg','2025-06-13 10:51:08'),(5,'Citrus Bloom','Vibrant citrus blend with bergamot and jasmine. Energizing and perfect for morning wear.',78.99,42,1,'perfume_images/gift-habeshaw-9I_hAW8JUUg-unsplash.jpg','2025-06-13 10:51:08'),(6,'Ocean Breeze','Fresh aquatic fragrance with sea salt and driftwood. Captures the essence of ocean breeze.',85.00,28,5,'perfume_images/guy-basabose-Ex154b30Ows-unsplash.jpg','2025-06-13 10:51:08'),(7,'Velvet Rose','Luxurious Bulgarian rose with amber and sandalwood. Sophisticated floral for modern women.',125.00,18,2,'perfume_images/karly-jones-NllIT940nAY-unsplash.jpg','2025-06-13 10:51:08'),(8,'Midnight Oud','Rich and mysterious aged oud with black pepper. Intense fragrance for special occasions.',185.00,12,4,'perfume_images/jeroen-den-otter-2b0JeJTEclQ-unsplash.jpg','2025-06-13 10:51:08'),(9,'Sandalwood Dreams','Creamy Australian sandalwood with vanilla orchid. Warm and utterly feminine fragrance.',98.75,25,3,'perfume_images/laura-chouette-4sKdeIMiFEI-unsplash_resized.jpeg','2025-06-13 10:51:08'),(10,'Spiced Amber','Warm amber resin with cinnamon and golden honey. Perfect for autumn and winter evenings.',89.50,31,4,'perfume_images/laura-chouette-aVs_PcvTe0E-unsplash.jpg','2025-06-13 10:51:08'),(11,'Cedar & Sage','Earthy cedarwood with fresh sage and bergamot. Unisex fragrance that bridges seasons.',92.00,29,3,'perfume_images/maxim-lozyanko-qFsxwpoDIB4-unsplash.jpg','2025-06-13 10:51:08'),(12,'Golden Elixir','Precious blend of saffron and rose gold accord. Limited edition luxury fragrance.',245.00,8,7,'perfume_images/laura-chouette-p8_aTbYqoEU-unsplash.jpg','2025-06-13 10:51:08'),(13,'Diamond Mist','Sparkling aldehydes with white diamonds accord. Radiant and unforgettable luxury scent.',198.00,15,7,'perfume_images/judith-girard-marczak-HIYPiNfih5A-unsplash.jpg','2025-06-13 10:51:08'),(14,'Royal Orchid','Exotic purple orchid with Madagascar vanilla. Precious amber for royal elegance.',156.00,20,4,'perfume_images/laura-chouette-gbT2KAq1V5c-unsplash_resized.jpeg','2025-06-13 10:51:08'),(15,'Lemon Verbena','Bright lemon verbena with green leaves and tea. Fresh and invigorating daily wear.',68.99,45,1,'perfume_images/gift-habeshaw-C1qrJ9i4EPc-unsplash.jpg','2025-06-13 10:51:08'),(16,'Mediterranean Breeze','Sun-kissed bergamot with sea breeze and herbs. Captures Mediterranean coastal essence.',82.50,33,5,'perfume_images/chris-mai-3p1BJjJRthk-unsplash.jpg','2025-06-13 10:51:08'),(17,'White Tea Blossom','Delicate white tea with cherry blossom bamboo. Zen-like tranquility in elegant bottle.',74.00,38,2,'perfume_images/eve-maier-M3PWXjCiRbQ-unsplash_resized.jpeg','2025-06-13 10:51:08'),(18,'Vanilla Cashmere','Rich Madagascar vanilla with cashmere wood. Cozy and indulgent comfort fragrance.',95.00,27,6,'perfume_images/heidi-walley-m6sh2vS0Yjk-unsplash.jpg','2025-06-13 10:51:08'),(19,'Honey Almond','Sweet almond milk with acacia honey flowers. Comforting and deliciously warm scent.',79.99,35,6,'perfume_images/karly-jones-WTw-yVFUFO0-unsplash.jpg','2025-06-13 10:51:08'),(20,'Forest Walk','Pine needles with morning dew and moss. Perfect nature-inspired unisex fragrance.',88.00,22,3,'perfume_images/non-YTCxJqtzmVk-unsplash.jpg','2025-06-13 10:51:08'),(21,'Urban Essence','Modern blend of concrete accord and ivy. Captures the dynamic pulse of city life.',91.50,26,3,'perfume_images/siora-photography-LkT5-JCePUY-unsplash.jpg','2025-06-13 10:51:08'),(22,'Noir Elegance','Sophisticated black currant with dark rose. Drama and elegance perfectly combined.',134.00,19,4,'perfume_images/laura-chouette-nF_VBoF3IAY-unsplash.jpg','2025-06-13 10:51:08'),(23,'Starlight Serenade','Sparkling star anise with night-blooming jasmine. Magical and ethereal evening fragrance.',118.00,21,2,'perfume_images/laura-chouette-Y-LVXQRD-Lk-unsplash.jpg','2025-06-13 10:51:08'),(24,'Pure Simplicity','Clean white cotton with soft lily breeze. Everyday elegance in its purest form.',58.99,50,8,'perfume_images/marisa-garrido-3aql6Y9LKFo-unsplash.jpg','2025-06-13 10:51:08'),(25,'Morning Dew','Fresh morning air with green grass lily. Perfect fragrance for new beginnings.',65.50,41,8,'perfume_images/mitra-jml-vPVBZxfyHOQ-unsplash.jpg','2025-06-13 10:51:08'),(26,'Autumn Leaves','Crisp autumn air with golden leaves cider. Captures the warm essence of fall.',76.00,32,6,'perfume_images/nataliya-melnychuk-MMDpGAmmZpc-unsplash.jpg','2025-06-13 10:51:08'),(27,'Summer Twilight','Warm summer evening with night-blooming cereus. Romantic and dreamy seasonal scent.',87.50,29,2,'perfume_images/parth-natani-uqJdOfHGb-w-unsplash_resized.jpeg','2025-06-13 10:51:08'),(28,'Artisan Blend','Hand-crafted with rare botanicals and vanilla. Small batch artisanal excellence.',142.00,16,7,'perfume_images/vishal-banik-OhBmysUAjio-unsplash.jpg','2025-06-13 10:51:08'),(29,'Vintage Charm','Classic aldehydic florals with powdery iris. Timeless elegance and vintage charm.',108.00,23,2,'perfume_images/william-bout-TY4QMCrS6P4-unsplash.jpg','2025-06-13 10:51:08'),(30,'Modern Muse','Contemporary blend of pink pepper electronic accord. Fashion-forward and bold modern scent.',97.50,24,1,'perfume_images/yixian-zhao-q7iZCOXGOWY-unsplash.jpg','2025-06-13 10:51:08'),(31,'Crystal Clear','Transparent florals with crystal water accord. Minimalist luxury and clean elegance.',84.99,36,5,'perfume_images/deanna-alys-xQwRvghauaU-unsplash.jpg','2025-06-13 10:51:08'),(32,'Heritage Rose','Traditional English rose with heritage blooms. Classic beauty and timeless elegance.',115.00,17,2,'perfume_images/delfina-iacub-nrkgRRskOBo-unsplash.jpg','2025-06-13 10:51:08'),(33,'Imperial Gold','Majestic blend of golden amber imperial jasmine. Luxury redefined in precious bottle.',167.00,14,7,'perfume_images/laura-chouette-YGuaaoNnv3c-unsplash.jpg','2025-06-13 10:51:08');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_options`
--

DROP TABLE IF EXISTS `quiz_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_options` (
  `option_id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `option_image` varchar(255) DEFAULT NULL,
  `scent_tags` json DEFAULT NULL,
  `option_order` int NOT NULL,
  PRIMARY KEY (`option_id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `quiz_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`question_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_options`
--

LOCK TABLES `quiz_options` WRITE;
/*!40000 ALTER TABLE `quiz_options` DISABLE KEYS */;
INSERT INTO `quiz_options` VALUES (1,1,'Floral','quiz_images/floral.jpg','[\"romantic\", \"feminine\", \"garden\", \"roses\", \"jasmine\"]',1),(2,1,'Woody','quiz_images/woody.jpg','[\"warm\", \"masculine\", \"earthy\", \"cedar\", \"sandalwood\"]',2),(3,1,'Citrus','quiz_images/citrus.jpg','[\"fresh\", \"energetic\", \"zesty\", \"lemon\", \"bergamot\"]',3),(4,1,'Fresh','quiz_images/fresh.jpg','[\"clean\", \"aquatic\", \"crisp\", \"marine\", \"green\"]',4),(5,2,'Daily','quiz_images/daily.jpg','[\"everyday\", \"office\", \"casual\", \"light\"]',1),(6,2,'Special Occasions','quiz_images/special.jpg','[\"evening\", \"formal\", \"intense\", \"luxury\"]',2),(7,2,'Work','quiz_images/work.jpg','[\"professional\", \"subtle\", \"clean\", \"sophisticated\"]',3),(8,2,'Casual Outings','quiz_images/casual.jpg','[\"relaxed\", \"friendly\", \"approachable\", \"versatile\"]',4),(9,3,'Sweet & Romantic','quiz_images/sweet.jpg','[\"vanilla\", \"fruity\", \"gourmand\", \"soft\", \"warm\"]',1),(10,3,'Bold & Musky','quiz_images/bold.jpg','[\"strong\", \"sensual\", \"musk\", \"amber\", \"intense\"]',2),(11,3,'Light & Airy','quiz_images/light.jpg','[\"subtle\", \"delicate\", \"powdery\", \"clean\", \"soft\"]',3),(12,3,'Spicy & Warm','quiz_images/spicy.jpg','[\"cinnamon\", \"pepper\", \"exotic\", \"oriental\", \"rich\"]',4),(13,4,'Spring','quiz_images/spring.jpg','[\"fresh\", \"blooming\", \"green\", \"light\", \"renewal\"]',1),(14,4,'Summer','quiz_images/summer.jpg','[\"citrus\", \"aquatic\", \"cooling\", \"energetic\", \"bright\"]',2),(15,4,'Autumn','quiz_images/autumn.jpg','[\"warm\", \"spicy\", \"amber\", \"cozy\", \"rich\"]',3),(16,4,'Winter','quiz_images/winter.jpg','[\"intense\", \"woody\", \"deep\", \"luxurious\", \"bold\"]',4),(17,5,'Subtle','quiz_images/subtle.jpg','[\"light\", \"delicate\", \"understated\", \"gentle\"]',1),(18,5,'Moderate','quiz_images/moderate.jpg','[\"balanced\", \"noticeable\", \"everyday\", \"versatile\"]',2),(19,5,'Strong','quiz_images/strong.jpg','[\"bold\", \"statement\", \"long-lasting\", \"powerful\"]',3),(20,5,'Very Intense','quiz_images/intense.jpg','[\"dramatic\", \"luxurious\", \"evening\", \"unforgettable\"]',4),(21,1,'Floral','quiz_images/floral.jpg','[\"romantic\", \"feminine\", \"garden\", \"roses\", \"jasmine\"]',1),(22,1,'Woody','quiz_images/woody.jpg','[\"warm\", \"masculine\", \"earthy\", \"cedar\", \"sandalwood\"]',2),(23,1,'Citrus','quiz_images/citrus.jpg','[\"fresh\", \"energetic\", \"zesty\", \"lemon\", \"bergamot\"]',3),(24,1,'Fresh','quiz_images/fresh.jpg','[\"clean\", \"aquatic\", \"crisp\", \"marine\", \"green\"]',4),(25,2,'Daily','quiz_images/daily.jpg','[\"everyday\", \"office\", \"casual\", \"light\"]',1),(26,2,'Special Occasions','quiz_images/special.jpg','[\"evening\", \"formal\", \"intense\", \"luxury\"]',2),(27,2,'Work','quiz_images/work.jpg','[\"professional\", \"subtle\", \"clean\", \"sophisticated\"]',3),(28,2,'Casual Outings','quiz_images/casual.jpg','[\"relaxed\", \"friendly\", \"approachable\", \"versatile\"]',4),(29,3,'Sweet & Romantic','quiz_images/sweet.jpg','[\"vanilla\", \"fruity\", \"gourmand\", \"soft\", \"warm\"]',1),(30,3,'Bold & Musky','quiz_images/bold.jpg','[\"strong\", \"sensual\", \"musk\", \"amber\", \"intense\"]',2),(31,3,'Light & Airy','quiz_images/light.jpg','[\"subtle\", \"delicate\", \"powdery\", \"clean\", \"soft\"]',3),(32,3,'Spicy & Warm','quiz_images/spicy.jpg','[\"cinnamon\", \"pepper\", \"exotic\", \"oriental\", \"rich\"]',4),(33,4,'Spring','quiz_images/spring.jpg','[\"fresh\", \"blooming\", \"green\", \"light\", \"renewal\"]',1),(34,4,'Summer','quiz_images/summer.jpg','[\"citrus\", \"aquatic\", \"cooling\", \"energetic\", \"bright\"]',2),(35,4,'Autumn','quiz_images/autumn.jpg','[\"warm\", \"spicy\", \"amber\", \"cozy\", \"rich\"]',3),(36,4,'Winter','quiz_images/winter.jpg','[\"intense\", \"woody\", \"deep\", \"luxurious\", \"bold\"]',4),(37,5,'Subtle','quiz_images/subtle.jpg','[\"light\", \"delicate\", \"understated\", \"gentle\"]',1),(38,5,'Moderate','quiz_images/moderate.jpg','[\"balanced\", \"noticeable\", \"everyday\", \"versatile\"]',2),(39,5,'Strong','quiz_images/strong.jpg','[\"bold\", \"statement\", \"long-lasting\", \"powerful\"]',3),(40,5,'Very Intense','quiz_images/intense.jpg','[\"dramatic\", \"luxurious\", \"evening\", \"unforgettable\"]',4),(41,1,'Floral','quiz_images/floral.jpg','[\"romantic\", \"feminine\", \"garden\", \"roses\", \"jasmine\"]',1),(42,1,'Woody','quiz_images/woody.jpg','[\"warm\", \"masculine\", \"earthy\", \"cedar\", \"sandalwood\"]',2),(43,1,'Citrus','quiz_images/citrus.jpg','[\"fresh\", \"energetic\", \"zesty\", \"lemon\", \"bergamot\"]',3),(44,1,'Fresh','quiz_images/fresh.jpg','[\"clean\", \"aquatic\", \"crisp\", \"marine\", \"green\"]',4),(45,2,'Daily','quiz_images/daily.jpg','[\"everyday\", \"office\", \"casual\", \"light\"]',1),(46,2,'Special Occasions','quiz_images/special.jpg','[\"evening\", \"formal\", \"intense\", \"luxury\"]',2),(47,2,'Work','quiz_images/work.jpg','[\"professional\", \"subtle\", \"clean\", \"sophisticated\"]',3),(48,2,'Casual Outings','quiz_images/casual.jpg','[\"relaxed\", \"friendly\", \"approachable\", \"versatile\"]',4),(49,3,'Sweet & Romantic','quiz_images/sweet.jpg','[\"vanilla\", \"fruity\", \"gourmand\", \"soft\", \"warm\"]',1),(50,3,'Bold & Musky','quiz_images/bold.jpg','[\"strong\", \"sensual\", \"musk\", \"amber\", \"intense\"]',2),(51,3,'Light & Airy','quiz_images/light.jpg','[\"subtle\", \"delicate\", \"powdery\", \"clean\", \"soft\"]',3),(52,3,'Spicy & Warm','quiz_images/spicy.jpg','[\"cinnamon\", \"pepper\", \"exotic\", \"oriental\", \"rich\"]',4),(53,4,'Spring','quiz_images/spring.jpg','[\"fresh\", \"blooming\", \"green\", \"light\", \"renewal\"]',1),(54,4,'Summer','quiz_images/summer.jpg','[\"citrus\", \"aquatic\", \"cooling\", \"energetic\", \"bright\"]',2),(55,4,'Autumn','quiz_images/autumn.jpg','[\"warm\", \"spicy\", \"amber\", \"cozy\", \"rich\"]',3),(56,4,'Winter','quiz_images/winter.jpg','[\"intense\", \"woody\", \"deep\", \"luxurious\", \"bold\"]',4),(57,5,'Subtle','quiz_images/subtle.jpg','[\"light\", \"delicate\", \"understated\", \"gentle\"]',1),(58,5,'Moderate','quiz_images/moderate.jpg','[\"balanced\", \"noticeable\", \"everyday\", \"versatile\"]',2),(59,5,'Strong','quiz_images/strong.jpg','[\"bold\", \"statement\", \"long-lasting\", \"powerful\"]',3),(60,5,'Very Intense','quiz_images/intense.jpg','[\"dramatic\", \"luxurious\", \"evening\", \"unforgettable\"]',4);
/*!40000 ALTER TABLE `quiz_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_questions`
--

DROP TABLE IF EXISTS `quiz_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_questions` (
  `question_id` int NOT NULL AUTO_INCREMENT,
  `question_text` varchar(255) NOT NULL,
  `question_order` int NOT NULL,
  `question_type` enum('single_choice','multiple_choice') DEFAULT 'single_choice',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_questions`
--

LOCK TABLES `quiz_questions` WRITE;
/*!40000 ALTER TABLE `quiz_questions` DISABLE KEYS */;
INSERT INTO `quiz_questions` VALUES (1,'Which fragrance family do you prefer?',1,'single_choice','2025-06-19 16:40:02'),(2,'When do you usually wear perfume?',2,'single_choice','2025-06-19 16:40:02'),(3,'What kind of scent do you prefer?',3,'single_choice','2025-06-19 16:40:02'),(4,'Which season do you prefer?',4,'single_choice','2025-06-19 16:40:02'),(5,'What\'s your preferred intensity?',5,'single_choice','2025-06-19 16:40:02'),(6,'Which fragrance family do you prefer?',1,'single_choice','2025-06-19 16:40:04'),(7,'When do you usually wear perfume?',2,'single_choice','2025-06-19 16:40:04'),(8,'What kind of scent do you prefer?',3,'single_choice','2025-06-19 16:40:04'),(9,'Which season do you prefer?',4,'single_choice','2025-06-19 16:40:04'),(10,'What\'s your preferred intensity?',5,'single_choice','2025-06-19 16:40:04');
/*!40000 ALTER TABLE `quiz_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quiz_results`
--

DROP TABLE IF EXISTS `quiz_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quiz_results` (
  `result_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `quiz_answers` json DEFAULT NULL,
  `recommended_scent_profile` varchar(100) DEFAULT NULL,
  `recommended_products` json DEFAULT NULL,
  `quiz_completed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`result_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quiz_results`
--

LOCK TABLES `quiz_results` WRITE;
/*!40000 ALTER TABLE `quiz_results` DISABLE KEYS */;
INSERT INTO `quiz_results` VALUES (1,4,'[{\"id\": 3, \"icon\": \"🍊\", \"tags\": [\"fresh\", \"energetic\", \"zesty\"], \"text\": \"Citrus\"}, {\"id\": 4, \"icon\": \"🎉\", \"tags\": [\"relaxed\", \"friendly\", \"versatile\"], \"text\": \"Casual Outings\"}, {\"id\": 2, \"icon\": \"🔥\", \"tags\": [\"strong\", \"sensual\", \"intense\"], \"text\": \"Bold & Musky\"}, {\"id\": 1, \"icon\": \"🌱\", \"tags\": [\"fresh\", \"blooming\", \"renewal\"], \"text\": \"Spring\"}, {\"id\": 2, \"icon\": \"🌤️\", \"tags\": [\"balanced\", \"noticeable\", \"versatile\"], \"text\": \"Moderate\"}]','Fresh & Clean','[{\"name\": \"Ocean Breeze\", \"price\": 85, \"category\": \"Fresh\"}, {\"name\": \"Citrus Bloom\", \"price\": 78.99, \"category\": \"Citrus\"}, {\"name\": \"Morning Dew\", \"price\": 92, \"category\": \"Fresh\"}]','2025-06-19 16:52:57'),(2,4,'[{\"id\": 2, \"icon\": \"🌳\", \"tags\": [\"warm\", \"masculine\", \"earthy\"], \"text\": \"Woody\"}, {\"id\": 1, \"icon\": \"☀️\", \"tags\": [\"everyday\", \"office\", \"casual\"], \"text\": \"Daily\"}, {\"id\": 2, \"icon\": \"🔥\", \"tags\": [\"strong\", \"sensual\", \"intense\"], \"text\": \"Bold & Musky\"}, {\"id\": 1, \"icon\": \"🌱\", \"tags\": [\"fresh\", \"blooming\", \"renewal\"], \"text\": \"Spring\"}, {\"id\": 2, \"icon\": \"🌤️\", \"tags\": [\"balanced\", \"noticeable\", \"versatile\"], \"text\": \"Moderate\"}]','Bold & Confident','[{\"name\": \"Midnight Oud\", \"price\": 150, \"category\": \"Oriental\"}, {\"name\": \"Bold Statement\", \"price\": 135, \"category\": \"Woody\"}, {\"name\": \"Dark Mystery\", \"price\": 145, \"category\": \"Musky\"}]','2025-06-20 03:44:47'),(3,5,'[{\"id\": 1, \"icon\": \"🌸\", \"tags\": [\"romantic\", \"feminine\", \"garden\"], \"text\": \"Floral\"}, {\"id\": 4, \"icon\": \"🎉\", \"tags\": [\"relaxed\", \"friendly\", \"versatile\"], \"text\": \"Casual Outings\"}, {\"id\": 2, \"icon\": \"🔥\", \"tags\": [\"strong\", \"sensual\", \"intense\"], \"text\": \"Bold & Musky\"}, {\"id\": 1, \"icon\": \"🌱\", \"tags\": [\"fresh\", \"blooming\", \"renewal\"], \"text\": \"Spring\"}, {\"id\": 4, \"icon\": \"💥\", \"tags\": [\"dramatic\", \"luxurious\", \"unforgettable\"], \"text\": \"Very Intense\"}]','Bold & Confident','[{\"name\": \"Midnight Oud\", \"price\": 150, \"category\": \"Oriental\"}, {\"name\": \"Bold Statement\", \"price\": 135, \"category\": \"Woody\"}, {\"name\": \"Dark Mystery\", \"price\": 145, \"category\": \"Musky\"}]','2025-07-13 00:35:14');
/*!40000 ALTER TABLE `quiz_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `report_name` varchar(100) DEFAULT NULL,
  `date_generated` date DEFAULT NULL,
  `report_type` enum('Sales','Users','Inventory') DEFAULT NULL,
  `status` enum('Completed','In Progress') DEFAULT NULL,
  `generated_by` int DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `generated_by` (`generated_by`),
  CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,'Monthly Sales - May','2025-05-29','Sales','Completed',1),(2,'Inventory Snapshot','2025-05-29','Inventory','Completed',1);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `reviews_chk_1` CHECK ((`rating` between 1 and 5))
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (11,2,1,5,'I absolutely love Rose Bloom! The scent is so romantic and elegant. Perfect for date nights and special occasions. The rose and jasmine blend beautifully and it lasts all day long. This has become my signature fragrance!','2025-06-10 14:30:00'),(12,NULL,1,4,'Beautiful fragrance! Rose Bloom is perfect for spring and summer. The floral notes are lovely without being overwhelming. Only wish the bottle was a bit larger for the price, but the quality is definitely there.','2025-06-11 09:15:00'),(13,3,1,5,'Rose Bloom exceeded all my expectations! The packaging is gorgeous and the scent is even better. I get compliments every time I wear it. Will definitely be ordering more when this bottle runs out.','2025-06-11 16:45:00'),(14,2,2,5,'Oud Intense is absolutely incredible! This is luxury in a bottle. The woody and spicy notes are perfectly balanced. A little goes a very long way - this bottle will last me months. Perfect for evening wear.','2025-06-09 11:20:00'),(15,NULL,2,4,'Very sophisticated scent. Oud Intense is definitely for special occasions - its quite powerful! The quality is outstanding and the fragrance develops beautifully throughout the day. My husband loves it on me.','2025-06-10 18:30:00'),(16,3,2,5,'Amazing fragrance! Oud Intense is so unique and luxurious. The spicy undertones make it really special. Fast shipping and excellent customer service too. Highly recommend for anyone who wants something distinctive.','2025-06-12 13:10:00'),(17,NULL,3,4,'Mystic Amber is warm and cozy - perfect for fall and winter! The amber and vanilla combination is comforting without being too sweet. Great for everyday wear when you want something a bit special.','2025-06-08 15:45:00'),(18,2,3,5,'Love this oriental scent! Mystic Amber is so sophisticated and long-lasting. It develops beautifully on my skin throughout the day. The customer service was excellent and packaging was beautiful.','2025-06-09 20:15:00'),(19,3,3,5,'Mystic Amber is absolutely gorgeous! The warm, vanilla notes are perfect for cooler weather. I feel so elegant wearing this. The bottle is beautiful too - looks great on my vanity. Will definitely repurchase!','2025-06-12 10:30:00'),(20,NULL,1,4,'Rose Bloom is lovely! Perfect for someone who enjoys floral scents. The longevity is good and the scent isnt too overpowering. Great for office wear or casual outings. Happy with my purchase!','2025-06-12 19:20:00'),(21,NULL,2,5,'Oud Intense is phenomenal! This is definitely a statement fragrance. The quality is exceptional and a little truly goes a long way. Perfect for evening events or when you want to feel luxurious.','2025-06-13 08:45:00'),(22,NULL,3,4,'Really enjoying Mystic Amber! The scent is warm and inviting. Great for daily wear and the price point is reasonable for the quality. Shipping was fast and the bottle arrived perfectly packaged.','2025-06-13 14:15:00');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `ticket_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` text,
  `status` enum('Open','Closed','Pending') DEFAULT 'Open',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ticket_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,3,'Missing Order','I placed an order two days ago but haven’t received a confirmation.','Open','2025-05-30 00:54:02'),(2,2,'Wrong Product Delivered','I received a different perfume from what I ordered.','Open','2025-05-30 00:54:02'),(3,NULL,'General Inquiry','test','Open','2025-06-13 15:21:59');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin@perfumis.com','hashed_admin_pw','admin','2025-05-30 00:52:32'),(2,'Brenda Chelimo','brenda@email.com','hashed_pw_123','customer','2025-05-30 00:52:32'),(3,'Lydia Karungi','lydia@email.com','hashed_pw_456','customer','2025-05-30 00:52:32'),(4,NULL,'lydiakarungi43@gmail.com','$2y$12$UvqnDCoPrBSAoz8JwWioP.kFjHs2XbbZsLufOKTXFWdpBC7xvxgGu','customer','2025-06-20 01:12:48'),(5,NULL,'lydia@test.com','$2y$12$VlhEt34zcGAJkyXYwH9AaOW5sTJr9sWzNqaoO4fg6dgU3Z22m4/Q.','customer','2025-07-10 17:31:05');
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

-- Dump completed on 2025-07-25 14:12:35
