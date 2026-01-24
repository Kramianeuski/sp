-- MySQL dump 10.13  Distrib 8.4.8, for Linux (x86_64)
--
-- Host: localhost    Database: system_power
-- ------------------------------------------------------
-- Server version	8.4.8

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
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'electrical-enclosures','published'),(2,'floor-boxes','published');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--

DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `official_seller` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `faq` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `indexable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_category_translation` (`category_id`,`language`),
  CONSTRAINT `category_translations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
INSERT INTO `category_translations` VALUES (1,1,'ru','Щиты механизации РУСП (IP54)','Щиты механизации РУСП System Power (IP54)','Щиты для распределения питания и подключения потребителей 220/380 В на строительных и производственных площадках. Исполнения формируются под типовые задачи объекта: понятные выходы, маркировка, комплект документов.','Щиты механизации РУСП System Power (IP54)','РУСП — распределительные щиты для безопасного распределения питания и подключения потребителей 220/380 В на площадке.','Ключевые особенности\n\nстепень защиты корпуса: IP54\n\nисполнение под типовые потребности площадки (по конфигурации модели)\n\nудобство подключения: силовые выходы 220/380 В в зависимости от исполнения\n\nсопроводительная документация по изделию\n\nДокументы\n\nПаспорт и схема предоставляются для соответствующих исполнений. Подтверждающие документы (сертификат/декларация) — при наличии для конкретной модели/партии.','','[]',1),(2,1,'en','RUSP IP54 distribution boards','System Power RUSP IP54 distribution boards','RUSP boards are designed for construction and industrial sites to distribute power and connect 230/400V loads. Configurations range by model (50–100A; IP54 enclosure; typical 230V/400V outputs depending on configuration).','System Power RUSP IP54 distribution boards','RUSP boards for on-site power distribution with IP54 enclosures and 50–100A configurations.','Documentation\nProduct passports and wiring diagrams are provided for applicable models. Certificates/declarations are supplied when available for the specific configuration.','','[]',1),(3,2,'ru','Металлические напольные лючки (45×45)','Металлические напольные лючки System Power (45×45)','Лючки для скрытой установки в пол и организации точек подключения силовых и слаботочных линий. Стальной корпус, вводы под трубы M25, модульная компоновка 45×45. Доступны серии с IP41 и IP54 — в зависимости от условий эксплуатации.','Металлические напольные лючки System Power (45×45)','Металлические напольные лючки System Power 45×45 с вводами M25 и сериями IP41/IP54.','Конструкция и монтаж\n\nстальной корпус\n\nвводы под трубы M25 (по модели)\n\nмодульная компоновка 45×45\n\nсерии IP41 и IP54 — в зависимости от условий эксплуатации','','[]',1),(4,2,'en','Metal floor boxes 45×45','System Power metal floor boxes 45×45','System Power floor boxes are designed for concealed floor installation for power and low-current connections. Steel housing, modular 45×45 layout, and M25 conduit entries (model-dependent). IP41 and IP54 series are available.','System Power metal floor boxes 45×45','Steel 45×45 modular floor boxes with M25 entries and IP41/IP54 series.','Design and installation logic\nsteel housing\nM25 conduit entries (model-dependent)\nmodular 45×45 layout\nIP41/IP54 series based on conditions','','[]',1);
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
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
-- Table structure for table `footer_links`
--

DROP TABLE IF EXISTS `footer_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `footer_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `footer_links`
--

LOCK TABLES `footer_links` WRITE;
/*!40000 ALTER TABLE `footer_links` DISABLE KEYS */;
INSERT INTO `footer_links` VALUES (7,'ru','Каталог продукции','/ru/products/',1),(8,'ru','Производство и контроль','/ru/manufacturing/',2),(9,'ru','Документация','/ru/documentation/',3),(10,'en','Product catalog','/en/products/',1),(11,'en','Manufacturing and control','/en/manufacturing/',2),(12,'en','Documentation','/en/documentation/',3);
/*!40000 ALTER TABLE `footer_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `navigation_items`
--

DROP TABLE IF EXISTS `navigation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `navigation_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `navigation_items`
--

LOCK TABLES `navigation_items` WRITE;
/*!40000 ALTER TABLE `navigation_items` DISABLE KEYS */;
INSERT INTO `navigation_items` VALUES (15,'ru','Продукция','/ru/products/',1),(16,'ru','О бренде','/ru/about/',2),(17,'ru','Производство','/ru/manufacturing/',3),(18,'ru','Документация','/ru/documentation/',4),(19,'ru','Контакты','/ru/contacts/',6),(20,'ru','Где купить','/ru/where-to-buy/',7),(21,'en','Products','/en/products/',1),(22,'en','About','/en/about/',2),(23,'en','Manufacturing','/en/manufacturing/',3),(24,'en','Documentation','/en/documentation/',4),(25,'en','Support','/en/support/',5),(26,'en','Contacts','/en/contacts/',6),(27,'en','Where to buy','/en/where-to-buy/',7);
/*!40000 ALTER TABLE `navigation_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_blocks`
--

DROP TABLE IF EXISTS `page_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_blocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_key` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `page_blocks_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_blocks`
--

LOCK TABLES `page_blocks` WRITE;
/*!40000 ALTER TABLE `page_blocks` DISABLE KEYS */;
INSERT INTO `page_blocks` VALUES (37,1,'en','hero','System Power — engineered solutions for on-site power distribution','A new brand built by a team with hands-on experience in electrical engineering and field operation.\nOur product scope is focused and practical: RUSP IP54 distribution boards (50–100A) and 45×45 modular metal floor boxes for power and low-current connections.',1),(38,1,'en','brand','About','System Power is a new brand created by a professional team with experience in selecting and applying electrical solutions for energy, construction and industrial facilities. While the brand is new, the product approach is based on safety, repeatable configurations and proper documentation. We develop two clear product directions to keep specifications transparent and predictable.',2),(39,1,'en','categories','Product directions','Two focused directions for on-site power tasks.',3),(40,1,'en','certificates','Documentation','Product passports, wiring diagrams (where applicable), and supporting certificates/declarations are provided depending on the specific model and configuration. Downloads are available on each product page.',4),(41,1,'en','where-to-buy','Where to buy','Available via our partner network. The “Where to buy” page lists official distributors and a marketplace channel for current configurations.',5),(42,1,'en','support','Support','Contact support for application and documentation inquiries.',6),(44,2,'en','generic','','System Power is a manufacturing brand focused on practical on-site electrical tasks: power distribution and safe connection points. The brand is new, yet built by an experienced engineering team. Our product scope is intentionally focused to maintain clear specifications, repeatable configurations and documentation.',1),(46,3,'en','generic','','System Power manufacturing follows ISO 9001:2015 quality management principles with a process approach, planned operations, documented control points and risk prevention. Requirements, configuration and documentation are fixed at the start of each order, and any changes are approved through a controlled workflow.\n\nMeasurement and calibration follow ISO 10012 practices with verified instruments and traceable records. Incoming inspection validates components, markings and documentation before production. Assembly is executed per work instructions with checks for layout, fastening, labeling and compliance with electrical schematics.\n\nElectrical verification includes continuity checks, protective conductors, and functional tests of outputs and protection devices where applicable. Nonconformities are isolated and corrected by repair, rework or replacement with documented root-cause actions.\n\nDocumentation package includes the product passport, wiring diagram (where applicable), packing list and certificates/declarations when available.\n\nProduct-specific control:\n— RUSP and other switchgear: output labeling, protection logic, enclosure rating, documentation completeness.\n— Floor boxes: geometry, fit, coating, conduit entries and 45×45 modular compatibility.\n\nContinuous improvement is maintained through regular review of instructions, feedback analysis and staff training to ensure stable performance and predictable quality.',1),(48,4,'en','generic','','This section provides product-specific documentation: passports, wiring diagrams and supporting documents depending on the model and configuration. Files are published on each product page. Contact support if you need a specific document.',1),(52,6,'en','generic','','Support email: teh@sissol.ru\n\nPhone: +7 (4812) 54-82-55\nAddress: 15 Tenisheva St, Smolensk, Russia\n\nSystemnye Resheniya LLC — manufacturer and distributor with 10+ years of experience. Please include product type, SKU/configuration and region in your inquiry.',1),(54,7,'en','generic','','System Power products are available via official distributors and a marketplace channel. Choose a supplier based on project needs, region and documentation requirements.\n\nPartner map\nKey partner locations: Smolensk — Systemnye Resheniya, Moscow — Argument Energo. (Interactive map: OpenStreetMap; more points added as the network expands.)',1),(55,1,'ru','hero','System Power — инженерные решения для электроснабжения на объекте','Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации. Делаем два направления, которые реально применяются на площадке: щиты механизации РУСП (IP54) и металлические напольные лючки 45×45.',1),(56,1,'ru','brand','О бренде','System Power — это бренд с короткой и понятной логикой продукта: стабильные исполнения, предсказуемые характеристики и корректная документация. Бренд новый, но команда за ним — опытная: мы работали с подбором и применением электротехнических решений на объектах энергетики, строительства и промышленности. Поэтому в линейке нет “лишнего”: только изделия, которые упрощают монтаж, эксплуатацию и закупку.',2),(57,1,'ru','categories','Направления продукции','',3),(58,1,'ru','production','Производство и контроль','На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки. Для каждого изделия предусмотрена сопроводительная документация; подтверждающие документы (сертификат/декларация) предоставляются при наличии для конкретной модели.',4),(59,1,'ru','certificates','Документы','Документы публикуются по моделям: паспорт, схема (где предусмотрено), сопроводительные файлы. Актуальные версии доступны в карточке изделия.',5),(60,1,'ru','where-to-buy','Где купить','Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Выберите поставщика по региону, формату закупки и требованиям к документам.',6),(61,1,'ru','support','Контакты','Технические и общие вопросы по продукции System Power:\nteh@sissol.ru\n· +7 (4812) 54-82-55 · Смоленск, ул. Тенишевой 15',7),(62,2,'ru','generic','','System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов. Мы развиваем линейку изделий, которые используются в условиях площадки и эксплуатации: распределение питания, подключение потребителей, организация точек подключения в полу.\n\nБренд новый, но создан командой специалистов с опытом в электротехнике, поставках и применении оборудования на объектах. Наш принцип — делать исполнения понятными и стабильными: чтобы монтаж, ввод в эксплуатацию и последующее обслуживание проходили без “сюрпризов”.\n\nФокус линейки:\n\nщиты механизации РУСП (IP54)\n\nметаллические напольные лючки 45×45 (вводы M25; серии IP41/IP54)',1),(63,3,'ru','generic','','На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки. Для каждого изделия предусмотрена сопроводительная документация; подтверждающие документы (сертификат/декларация) предоставляются при наличии для конкретной модели.',1),(64,4,'ru','generic','','В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация. Набор документов зависит от модели и исполнения.\n\nКак устроено\n\nдокументы публикуются в карточке конкретного изделия;\nпаспорт и схема — по соответствующим моделям;\nсертификат/декларация соответствия — при наличии для конкретной модели/партии.\n\nЕсли вам нужен документ, которого нет на сайте, направьте запрос на почту — укажите артикул и исполнение изделия.',1),(65,7,'ru','partners','Партнёры','[Официальные дистрибьюторы]\nАргумент Энерго (Москва) | https://argument-energo.ru | Официальный дистрибьютор | Аргумент Энерго специализируется на поставках электротехнической продукции для объектов и монтажных организаций. Позиции System Power представлены в структурированном каталоге по сериям и исполнениям, что ускоряет подбор. Партнёр ориентирован на корректный документооборот и понятные условия поставки. Подходит для закупок под проект и плановых поставок.\nООО «Системные Решения» / SISSOL (Смоленск) | https://sissol.ru | Официальный дистрибьютор | ООО «Системные Решения» работает в сфере электроснабжения и электроосвещения более 10 лет. Решения формируются на продукции проверенных торговых марок и поставляются на основании прямых дистрибьюторских контрактов, что позволяет подтверждать происхождение и качество и соблюдать гарантийные обязательства. Компания ориентирована не только на продажу, но и на подбор оптимального решения под задачу. География проектов включает регионы России и страны ЕАЭС — в зависимости от проекта.\n\n[Маркетплейсы]\nВсеИнструменты | https://www.vseinstrumenti.ru | Маркетплейс / онлайн-гипермаркет | Канал для оперативных закупок и широкой доступности ассортимента. Удобен для быстрого заказа, сравнения характеристик и понятной логистики. Подходит как массовый канал присутствия System Power для монтажников и конечных заказчиков. Условия поставки и документооборот зависят от формата конкретной продажи на платформе.',1),(66,6,'ru','generic','','Email: teh@sissol.ru\n\nТелефон: +7 (4812) 54-82-55\nАдрес: ул. Тенишевой 15, Смоленск, Россия\n\nЮридическое лицо\n\nООО «Системные Решения» — производитель и дистрибьютор электрооборудования с историей более 10 лет. Компания формирует решения на базе продукции проверенных торговых марок и поставляет оборудование по прямым дистрибьюторским контрактам, что позволяет подтверждать происхождение и качество продукции и обеспечивать соблюдение гарантийных обязательств. По вопросам продукции System Power предоставляется консультация по исполнению, применению и документации.\n\nКак быстрее получить ответ\n\nВ письме укажите: тип изделия (РУСП / люк), артикул (если есть), нужные параметры (ток/исполнение/IP/модульность), регион и формат закупки (проект/оперативно).',1);
/*!40000 ALTER TABLE `page_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_translations`
--

DROP TABLE IF EXISTS `page_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `canonical` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `robots` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_html` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_css` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_layout` tinyint(1) NOT NULL DEFAULT '1',
  `replace_styles` tinyint(1) NOT NULL DEFAULT '0',
  `indexable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page_translation` (`page_id`,`language`),
  CONSTRAINT `page_translations_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_translations`
--

LOCK TABLES `page_translations` WRITE;
/*!40000 ALTER TABLE `page_translations` DISABLE KEYS */;
INSERT INTO `page_translations` VALUES (1,1,'ru','System Power','System Power — инженерные решения для электроснабжения на объекте','System Power — инженерные решения для электроснабжения на объекте','Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации.','','index,follow','System Power — инженерные решения для электроснабжения на объекте','Новый бренд, созданный командой с практическим опытом в электротехнике и эксплуатации.','','',1,0,1),(2,1,'en','System Power','System Power — engineered solutions for on-site power distribution','System Power — engineered solutions for on-site power distribution','A new brand built by a team with hands-on experience in electrical engineering and field operation.','','index,follow','System Power — engineered solutions for on-site power distribution','A new brand built by a team with hands-on experience in electrical engineering and field operation.','','',1,0,1),(3,2,'ru','О бренде System Power','О бренде System Power','О бренде System Power','System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов.','','index,follow','О бренде System Power','System Power — производственное направление, ориентированное на практические задачи электроснабжения объектов.','','',1,0,1),(4,2,'en','About','About System Power','About System Power','System Power is a manufacturing brand focused on practical on-site electrical tasks.','','index,follow','About System Power','System Power is a manufacturing brand focused on practical on-site electrical tasks.','','',1,0,1),(5,3,'ru','Производство и контроль','Производство и контроль','Производство и контроль System Power','На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки.','','index,follow','Производство и контроль System Power','На производстве применён регламентированный контроль сборки и приёмки: входной контроль комплектующих, контроль компоновки и маркировки, контроль соответствия документации, фиксация результатов проверки.','','',1,0,1),(6,3,'en','Manufacturing & Quality','Manufacturing & Quality','System Power manufacturing and quality control','Quality management follows ISO 9001:2015 principles with documented control points and verification.','','index,follow','Manufacturing & Quality','Quality management follows ISO 9001:2015 principles with documented control points and verification.','','',1,0,1),(7,4,'ru','Документы и сертификаты','Документы и сертификаты','Документы и сертификаты System Power','В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация.','','index,follow','Документы и сертификаты','В этом разделе размещаются файлы, связанные с конкретными изделиями System Power: паспорта, схемы (где предусмотрено), сопроводительная документация.','','',1,0,1),(8,4,'en','Documents','Documents','System Power documents','Product passports, wiring diagrams and supporting documents are published per model.','','index,follow','Documents','Product passports, wiring diagrams and supporting documents are published per model.','','',1,0,1),(11,6,'ru','Контакты','Контакты','Контакты System Power','Email: teh@sissol.ru','','index,follow','Контакты','Email: teh@sissol.ru','<section class=\"content-block\">\n    <div class=\"container\">\n        <h2>Контакты — Яндекс.Карты</h2>\n        <iframe\n          src=\"https://yandex.ru/map-widget/v1/?ll=32.055806%2C54.774769&z=16&pt=32.055806%2C54.774769,pm2rdm\"\n          width=\"100%\" height=\"420\" frameborder=\"0\"\n          style=\"border:0;border-radius:16px;overflow:hidden\"\n          allowfullscreen>\n        </iframe>\n    </div>\n</section>\n<section class=\"content-block\">\n    <div class=\"container\">\n        <h2>Контакты — OpenStreetMap</h2>\n        <iframe\n          width=\"100%\" height=\"420\" frameborder=\"0\" scrolling=\"no\"\n          style=\"border:0;border-radius:16px;overflow:hidden\"\n          src=\"https://www.openstreetmap.org/export/embed.html?bbox=32.045806%2C54.769769%2C32.065806%2C54.779769&layer=mapnik&marker=54.774769%2C32.055806\">\n        </iframe>\n    </div>\n</section>','',1,0,1),(12,6,'en','Contacts','Contacts','System Power contacts','Support email, phone and office address for System Power.','','index,follow','Contacts','Support email, phone and office address for System Power.','','',1,0,1),(13,7,'ru','Где купить System Power','Где купить System Power','Где купить System Power','Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Для проектных закупок рекомендуем официальных дистрибьюторов; для оперативных заказов — маркетплейс.','','index,follow','Где купить System Power','Продукция System Power доступна через официальных дистрибьюторов и маркетплейс-канал. Для проектных закупок рекомендуем официальных дистрибьюторов; для оперативных заказов — маркетплейс.','<section class=\"content-block\">\n    <div class=\"container\">\n        <h2>Карта партнёров — Яндекс.Карты</h2>\n        <iframe\n          src=\"https://yandex.ru/map-widget/v1/?ll=34.765130%2C55.202455&z=5&pt=32.055806%2C54.774769,pm2rdm~37.474453%2C55.630141,pm2blm\"\n          width=\"100%\" height=\"420\" frameborder=\"0\"\n          style=\"border:0;border-radius:16px;overflow:hidden\"\n          allowfullscreen>\n        </iframe>\n    </div>\n</section>\n<section class=\"content-block\">\n    <div class=\"container\">\n        <h2>Карта партнёров — OpenStreetMap</h2>\n        <h3>Смоленск (Системные Решения)</h3>\n        <iframe\n          width=\"100%\" height=\"420\" frameborder=\"0\" scrolling=\"no\"\n          style=\"border:0;border-radius:16px;overflow:hidden\"\n          src=\"https://www.openstreetmap.org/export/embed.html?bbox=32.045806%2C54.769769%2C32.065806%2C54.779769&layer=mapnik&marker=54.774769%2C32.055806\">\n        </iframe>\n        <h3>Москва (Аргумент Энерго)</h3>\n        <iframe\n          width=\"100%\" height=\"420\" frameborder=\"0\" scrolling=\"no\"\n          style=\"border:0;border-radius:16px;overflow:hidden\"\n          src=\"https://www.openstreetmap.org/export/embed.html?bbox=37.464453%2C55.625141%2C37.484453%2C55.635141&layer=mapnik&marker=55.630141%2C37.474453\">\n        </iframe>\n    </div>\n</section>','',1,0,1),(14,7,'en','Where to buy','Where to buy','Where to buy System Power','System Power products are available via official distributors and a marketplace channel.','','index,follow','Where to buy','System Power products are available via official distributors and a marketplace channel.','','',1,0,1);
/*!40000 ALTER TABLE `page_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'home','published'),(2,'about','published'),(3,'manufacturing','published'),(4,'documentation','published'),(6,'contacts','published'),(7,'where-to-buy','published');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_documents`
--

DROP TABLE IF EXISTS `product_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_documents_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_documents`
--

LOCK TABLES `product_documents` WRITE;
/*!40000 ALTER TABLE `product_documents` DISABLE KEYS */;
INSERT INTO `product_documents` VALUES (1,1,'ru','Паспорт изделия','/storage/uploads/passport-sp01-0212.pdf',1),(2,1,'ru','Инструкция по монтажу и эксплуатации','/storage/uploads/manual-sp01-0212.pdf',2),(3,1,'ru','Схема электрическая','/storage/uploads/scheme-sp01-0212.pdf',3),(4,1,'en','Product passport','/storage/uploads/passport-sp01-0212.pdf',1),(5,1,'en','Installation and operation manual','/storage/uploads/manual-sp01-0212.pdf',2),(6,1,'en','Electrical diagram','/storage/uploads/scheme-sp01-0212.pdf',3);
/*!40000 ALTER TABLE `product_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_faqs`
--

DROP TABLE IF EXISTS `product_faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_faqs_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_faqs`
--

LOCK TABLES `product_faqs` WRITE;
/*!40000 ALTER TABLE `product_faqs` DISABLE KEYS */;
INSERT INTO `product_faqs` VALUES (1,1,'ru','Какая глубина установки лючка?','Глубина установки регулируется и может быть изменена до 20 мм.',1),(2,1,'ru','Какие модули совместимы?','Совместимы модули 220 В, RJ45, ТВ и другие стандартные подключения.',2),(3,1,'en','What is the installation depth?','Installation depth is adjustable up to 20 mm.',1),(4,1,'en','Which modules are compatible?','Compatible with 220 V, RJ45, TV, and other standard modules.',2);
/*!40000 ALTER TABLE `product_faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'ru','/themes/default/placeholder-product.svg','System Power SP01-0212',1),(2,1,'en','/themes/default/placeholder-product.svg','System Power SP01-0212',1);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_specs`
--

DROP TABLE IF EXISTS `product_specs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_specs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_specs_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specs`
--

LOCK TABLES `product_specs` WRITE;
/*!40000 ALTER TABLE `product_specs` DISABLE KEYS */;
INSERT INTO `product_specs` VALUES (1,1,'ru','Степень защиты','IP54','','string',1),(2,1,'ru','Габариты','200x245x120','мм','number',2),(3,1,'ru','Вместимость','до 6 розеток 45×45 мм или до 12 модулей 22.5×45 мм','','string',3),(4,1,'ru','Материал корпуса','Сталь','','string',4),(5,1,'ru','Кабельные вводы','Отверстия под трубы M25','','string',5),(6,1,'en','Protection rating','IP54','','string',1),(7,1,'en','Dimensions','200x245x120','mm','number',2),(8,1,'en','Capacity','Up to 6 outlets 45×45 mm or up to 12 modules 22.5×45 mm','','string',3),(9,1,'en','Enclosure material','Steel','','string',4),(10,1,'en','Cable entries','Stamped openings for M25 conduits','','string',5);
/*!40000 ALTER TABLE `product_specs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_translations`
--

DROP TABLE IF EXISTS `product_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `h1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `indexable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_product_translation` (`product_id`,`language`),
  CONSTRAINT `product_translations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_translations`
--

LOCK TABLES `product_translations` WRITE;
/*!40000 ALTER TABLE `product_translations` DISABLE KEYS */;
INSERT INTO `product_translations` VALUES (1,1,'ru','Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212','Напольный лючок-невидимка на 12 модулей (6 розеток 45x45) IP54 System Power SP01-0212','Электротехническое изделие для распределения электропитания и подключения оборудования в составе инженерных систем здания.','Серия System Power SP01-02 — это решение для тех, кто ценит удобный и безопасный доступ к электропроводке и слаботочным кабелям внутри помещений. Люк этой серии легко встраивается в конструкцию пола и благодаря скрытому монтажу органично вписывается в любой интерьер, не нарушая его эстетики. Идеально подходит для жилых, офисных и коммерческих пространств. Корпус люка изготовлен из прочной стали и оснащён штампованными отверстиями под трубы диаметром M25. По запросу доступны варианты из алюминия или нержавеющей стали — под любые условия эксплуатации.','Лючок-невидимка System Power SP01-0212','Напольный лючок-невидимка IP54 System Power SP01-0212 с 12 модулями и скрытым монтажом.',1),(2,1,'en','Floor box invisible 12 modules (6 outlets 45x45) IP54 System Power SP01-0212','Floor box invisible 12 modules (6 outlets 45x45) IP54 System Power SP01-0212','Electrical product for power distribution and equipment connection within engineering systems.','System Power SP01-02 series provides convenient and safe access to power and low-voltage cables indoors. The floor box integrates into the floor structure with concealed mounting and fits interior aesthetics. Suitable for residential, office, and commercial spaces. The enclosure is made of durable steel with stamped openings for M25 conduits. Aluminum or stainless steel versions are available upon request.','System Power SP01-0212 floor box','Invisible floor box IP54 System Power SP01-0212 with 12 modules and concealed mounting.',1);
/*!40000 ALTER TABLE `product_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `slug` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,'sp01-0212','SP01-0212','published');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_setting` (`language`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (1,'ru','brand_name','System Power'),(2,'ru','brand_description','Производитель электротехнического оборудования для инженерных систем.'),(3,'ru','site_title','System Power — официальный сайт бренда'),(4,'ru','site_description','Бренд-портал производителя System Power: продукция, документация и официальные партнёры.'),(5,'ru','header_show_logo','0'),(6,'ru','header_logo_link','/ru/'),(7,'ru','header_logo_alt','System Power'),(8,'ru','header_logo_path',''),(9,'ru','footer_title','System Power'),(10,'ru','footer_text','Официальный бренд-портал производителя электротехнической продукции.'),(11,'ru','footer_copyright','© System Power'),(12,'ru','footer_contacts_title','Контакты'),(13,'ru','footer_contacts','Служба поддержки: teh@sissol.ru'),(14,'ru','official_seller_text','Эксклюзивный официальный дистрибьютор продукции System Power.'),(15,'en','brand_name','System Power'),(16,'en','brand_description','Manufacturer of electrical equipment for engineering systems.'),(17,'en','site_title','System Power — official brand site'),(18,'en','site_description','Brand portal of System Power: products, documentation, and official distributors.'),(19,'en','header_show_logo','0'),(20,'en','header_logo_link','/en/'),(21,'en','header_logo_alt','System Power'),(22,'en','header_logo_path',''),(23,'en','footer_title','System Power'),(24,'en','footer_text','Official brand portal of the electrical equipment manufacturer.'),(25,'en','footer_copyright','© System Power'),(26,'en','footer_contacts_title','Contacts'),(27,'en','footer_contacts','Support: info@systempower.example\r\nPartner: sissol.ru'),(28,'en','official_seller_text','Exclusive official distributor of System Power products.');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_translation` (`language`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (1,'ru','hero.products','Продукция'),(2,'ru','hero.where','Где приобрести'),(3,'ru','where_to_buy.button','Где купить'),(4,'ru','official.seller_title','Официальный продавец'),(5,'ru','official.seller_text','Эксклюзивный официальный дистрибьютор продукции System Power'),(6,'ru','official.seller_button','Перейти на сайт sissol.ru'),(7,'ru','official.seller_link','https://sissol.ru'),(8,'ru','products.title','Продукция System Power'),(9,'ru','products.h1','Продукция System Power'),(10,'ru','products.meta_title','Продукция System Power'),(11,'ru','products.meta_description','Линейка System Power включает два направления, разработанные для применения на объектах строительства, эксплуатации и промышленности.\n\n1) Щиты механизации РУСП (IP54)\nРаспределительные щиты для организации питания и подключения потребителей 220/380 В на площадке. Исполнения под типовые сценарии объекта и задачи электроснабжения.\n\n2) Металлические напольные лючки 45×45\nЛючки для скрытой установки в пол с модульной компоновкой 45×45. Стальной корпус и вводы M25 обеспечивают аккуратный подвод кабельных линий и монтажную готовность.'),(12,'ru','faq.title','FAQ'),(13,'ru','seo.title','System Power'),(14,'ru','product.description_title','Описание'),(15,'ru','product.specs_title','Характеристики'),(16,'ru','product.documents_title','Документация'),(17,'ru','product.related_title','Похожие товары'),(18,'ru','error.not_found','Страница не найдена'),(19,'ru','error.not_found_text','Запрашиваемая страница недоступна.'),(20,'ru','breadcrumb.home','Главная'),(21,'ru','admin.login_title','Вход в админку'),(22,'ru','admin.username','Логин'),(23,'ru','admin.password','Пароль'),(24,'ru','admin.login','Войти'),(25,'ru','admin.login_failed','Неверные учетные данные'),(26,'ru','admin.panel_title','Админка System Power'),(27,'ru','admin.nav_pages','Страницы'),(28,'ru','admin.nav_categories','Категории'),(29,'ru','admin.nav_products','Продукты'),(30,'ru','admin.nav_translations','Переводы'),(31,'ru','admin.nav_files','Файлы'),(32,'ru','admin.logout','Выход'),(33,'ru','admin.pages_title','Страницы'),(34,'ru','admin.page_slug','Слаг'),(35,'ru','admin.page_title','Заголовок'),(36,'ru','admin.page_h1','H1'),(37,'ru','admin.page_edit_title','Редактирование страницы'),(38,'ru','admin.meta_title','Title'),(39,'ru','admin.meta_description','Description'),(40,'ru','admin.canonical','Canonical'),(41,'ru','admin.robots','Robots'),(42,'ru','admin.og_title','OG Title'),(43,'ru','admin.og_description','OG Description'),(44,'ru','admin.indexable','Индексировать'),(45,'ru','admin.blocks','Блоки'),(46,'ru','admin.blocks_title','Блоки страницы'),(47,'ru','admin.block_key','Ключ блока'),(48,'ru','admin.block_title','Заголовок блока'),(49,'ru','admin.block_body','Текст блока'),(50,'ru','admin.block_edit_title','Редактирование блока'),(51,'ru','admin.sort_order','Порядок'),(52,'ru','admin.categories_title','Категории'),(53,'ru','admin.category_slug','Слаг'),(54,'ru','admin.category_name','Название'),(55,'ru','admin.category_h1','H1'),(56,'ru','admin.category_description','Описание'),(57,'ru','admin.category_edit_title','Редактирование категории'),(58,'ru','admin.seo_text','SEO текст'),(59,'ru','admin.official_seller','Официальный продавец'),(60,'ru','admin.faq','FAQ JSON'),(61,'ru','admin.products_title','Продукты'),(62,'ru','admin.product_slug','Слаг'),(63,'ru','admin.product_sku','Артикул'),(64,'ru','admin.product_name','Название'),(65,'ru','admin.product_h1','H1'),(66,'ru','admin.product_short','Краткое описание'),(67,'ru','admin.product_description','Описание'),(68,'ru','admin.product_edit_title','Редактирование продукта'),(69,'ru','admin.specs','Характеристики'),(70,'ru','admin.specs_title','Характеристики продукта'),(71,'ru','admin.spec_label','Параметр'),(72,'ru','admin.spec_value','Значение'),(73,'ru','admin.spec_unit','Ед. изм.'),(74,'ru','admin.translations_title','Переводы'),(75,'ru','admin.translation_key','Ключ'),(76,'ru','admin.translation_value','Значение'),(77,'ru','admin.translation_edit_title','Редактирование перевода'),(78,'ru','admin.files_title','Файлы'),(79,'ru','admin.file_upload','Загрузка файла'),(80,'ru','admin.upload','Загрузить'),(81,'ru','admin.file_name','Имя файла'),(82,'ru','admin.file_path','Путь'),(83,'ru','admin.language','Язык'),(84,'ru','admin.language_ru','RU'),(85,'ru','admin.language_en','EN'),(86,'ru','admin.status','Статус'),(87,'ru','admin.status_published','Опубликовано'),(88,'ru','admin.status_archived','Архив'),(89,'ru','admin.status_draft','Черновик'),(90,'ru','admin.edit','Редактировать'),(91,'ru','admin.save','Сохранить'),(92,'ru','admin.add','Добавить'),(93,'ru','admin.create','Создать'),(94,'ru','admin.back','Назад к списку'),(95,'ru','admin.blocks_ru','Блоки RU'),(96,'ru','admin.blocks_en','Блоки EN'),(97,'ru','admin.specs_ru','Характеристики RU'),(98,'ru','admin.specs_en','Характеристики EN'),(99,'ru','admin.page_create_title','Создание страницы'),(100,'ru','admin.category_create_title','Создание категории'),(101,'ru','admin.product_create_title','Создание продукта'),(102,'ru','admin.select_category','Выберите категорию'),(103,'ru','admin.product_category','Категория'),(104,'ru','admin.custom_html','HTML редактор'),(105,'ru','admin.custom_css','CSS редактор'),(106,'ru','admin.use_layout','Использовать общий шаблон'),(107,'ru','admin.replace_styles','Отключить глобальные стили'),(108,'ru','admin.nav_header','Header'),(109,'ru','admin.nav_footer','Footer'),(110,'ru','admin.footer_title','Footer'),(111,'ru','admin.footer_text','Текст/копирайт'),(112,'ru','admin.footer_copyright','Копирайт'),(113,'ru','admin.footer_contacts','Контакты'),(114,'ru','admin.footer_links','Ссылки'),(115,'ru','admin.footer_link_label','Текст ссылки'),(116,'ru','admin.footer_link_url','URL'),(117,'ru','admin.header_title','Header'),(118,'ru','admin.header_logo_file','Логотип (SVG/PNG)'),(119,'ru','admin.header_show_logo','Показывать логотип'),(120,'ru','admin.header_logo_link','Ссылка логотипа'),(121,'ru','admin.header_logo_alt','Alt-текст логотипа'),(122,'ru','admin.header_logo_current','Текущий логотип'),(123,'ru','admin.translation_search','Поиск по ключу'),(124,'ru','admin.translation_search_placeholder','Введите ключ перевода'),(125,'ru','admin.search','Найти'),(126,'ru','nav.toggle','Открыть меню'),(127,'ru','header.region_label','Регион'),(128,'ru','header.region_value','Все регионы'),(129,'ru','footer.links','Быстрые ссылки'),(130,'ru','cta.catalog','Каталог продукции'),(131,'ru','cta.production','Производство и контроль'),(132,'ru','cta.open_category','Перейти в направление'),(133,'ru','cta.view_models','Каталог моделей'),(134,'ru','cta.browse_categories','Смотреть категории'),(135,'ru','cta.buy_partners','Купить у партнёров'),(136,'ru','cta.view_specs','Характеристики'),(137,'ru','cta.visit','Перейти'),(138,'ru','filters.search_label','Поиск по названию или артикулу'),(139,'ru','filters.search_placeholder','Введите название или артикул'),(140,'ru','filters.sort_label','Сортировка'),(141,'ru','filters.sort_name','По названию'),(142,'ru','filters.sort_new','По новизне'),(143,'ru','filters.apply','Показать'),(144,'ru','product.sku','Артикул'),(145,'ru','products.empty','По выбранным фильтрам товары не найдены.'),(146,'ru','sidebar.documents_title','Документы'),(147,'ru','sidebar.documents_text','Паспорта, схемы и инструкции для выбранной категории.'),(148,'ru','sidebar.documents_link','Документация'),(149,'ru','sidebar.parameters_title','Ключевые параметры'),(150,'ru','sidebar.parameters_text','Параметры моделей и типовые исполнения.'),(151,'ru','sidebar.where_title','Где купить'),(152,'ru','sidebar.where_text','Поставка через партнёров и дистрибьюторов.'),(153,'ru','sidebar.where_link','Где купить'),(154,'ru','sidebar.support_title','Поддержка'),(155,'ru','sidebar.support_text','Консультации по подбору и опросным листам.'),(156,'ru','sidebar.support_link','Связаться'),(157,'en','hero.products','Products'),(158,'en','hero.where','Where to buy'),(159,'en','where_to_buy.button','Where to buy'),(160,'en','official.seller_title','Official distributor'),(161,'en','official.seller_text','Exclusive official distributor of System Power products'),(162,'en','official.seller_button','Go to sissol.ru'),(163,'en','official.seller_link','https://sissol.ru'),(164,'en','products.title','System Power products'),(165,'en','products.h1','System Power products'),(166,'en','products.meta_title','System Power products'),(167,'en','products.meta_description','Two focused directions: RUSP IP54 boards (50–100A) for on-site distribution, and 45×45 modular steel floor boxes with M25 entries (IP41/IP54 series).'),(168,'en','faq.title','FAQ'),(169,'en','seo.title','System Power'),(170,'en','product.description_title','Description'),(171,'en','product.specs_title','Specifications'),(172,'en','product.documents_title','Documentation'),(173,'en','product.related_title','Related products'),(174,'en','error.not_found','Page not found'),(175,'en','error.not_found_text','The requested page is unavailable.'),(176,'en','breadcrumb.home','Home'),(177,'en','nav.toggle','Open menu'),(178,'en','header.region_label','Region'),(179,'en','header.region_value','All regions'),(180,'en','footer.links','Quick links'),(181,'en','cta.catalog','Catalogue'),(182,'en','cta.production','Manufacturing & Quality'),(183,'en','cta.open_category','Go to direction'),(184,'en','cta.view_models','Model catalog'),(185,'en','cta.buy_partners','Buy from partners'),(186,'en','cta.view_specs','View specifications'),(187,'en','cta.browse_categories','Browse categories'),(188,'en','cta.visit','Visit'),(189,'en','filters.search_label','Search by name or SKU'),(190,'en','filters.search_placeholder','Enter name or SKU'),(191,'en','filters.sort_label','Sort'),(192,'en','filters.sort_name','By name'),(193,'en','filters.sort_new','Newest'),(194,'en','filters.apply','Apply'),(195,'en','product.sku','SKU'),(196,'en','products.empty','No products found for the selected filters.'),(197,'en','sidebar.documents_title','Documents'),(198,'en','sidebar.documents_text','Passports, diagrams, and instructions for the selected category.'),(199,'en','sidebar.documents_link','Documentation'),(200,'en','sidebar.parameters_title','Key parameters'),(201,'en','sidebar.parameters_text','Model parameters and standard configurations.'),(202,'en','sidebar.where_title','Where to buy'),(203,'en','sidebar.where_text','Supply through partners and distributors.'),(204,'en','sidebar.where_link','Where to buy'),(205,'en','sidebar.support_title','Support'),(206,'en','sidebar.support_text','Consultations on selection and questionnaires.'),(207,'en','sidebar.support_link','Contact support'),(208,'ru','cta.about','О бренде'),(209,'en','cta.about','About'),(210,'ru','cta.documents','Документы и сертификаты'),(211,'en','cta.documents','Documents'),(212,'ru','cta.contacts','Контакты'),(213,'en','cta.contacts','Contacts'),(214,'ru','admin.delete','Удалить'),(215,'en','admin.delete','Delete'),(216,'ru','admin.header_links','Ссылки в хэдере'),(217,'en','admin.header_links','Header links'),(218,'ru','admin.header_link_label','Название'),(219,'en','admin.header_link_label','Label'),(220,'ru','admin.header_link_url','Ссылка'),(221,'en','admin.header_link_url','URL');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'system_power'
--

--
-- Dumping routines for database 'system_power'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-24 10:03:12
