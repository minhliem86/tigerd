/*
Navicat MySQL Data Transfer

Source Server         : LIEMPHAN-C
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : tigerd

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-01-16 18:04:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for agencies
-- ----------------------------
DROP TABLE IF EXISTS `agencies`;
CREATE TABLE `agencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `img_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of agencies
-- ----------------------------
INSERT INTO `agencies` VALUES ('1', 'Stracke, Shanahan and Purdy', 'stracke-shanahan-and-purdy', 'Ut autem hic reprehenderit at qui dolorem nisi. Quo nesciunt molestiae dolores a qui cupiditate. Repellat provident quo rerum quae.', '10', '1', 'public/upload/photos/shares/Armani.jpg', '2018-01-15 08:24:34', '2018-01-15 08:25:23');
INSERT INTO `agencies` VALUES ('2', 'Brown LLC', 'brown-llc', 'Ex nihil minima non et a aliquam rerum. Excepturi id id adipisci hic aperiam. Rerum dolore facere temporibus nam illum dolores amet. Sit consequatur deleniti aliquid sint.', '6', '1', 'public/upload/photos/shares/chanel.jpeg', '2018-01-15 08:24:34', '2018-01-15 08:25:30');
INSERT INTO `agencies` VALUES ('3', 'Stiedemann-Brown', 'stiedemann-brown', 'Id est est iure repellendus veritatis rem. Sint aut tempora dolorem ea sunt impedit et quia. Aliquid quo assumenda omnis in temporibus adipisci unde.', '10', '1', 'public/upload/photos/shares/ferrari.jpg', '2018-01-15 08:24:34', '2018-01-15 08:25:37');
INSERT INTO `agencies` VALUES ('4', 'Waters Inc', 'waters-inc', 'Fuga et quas qui animi odio quaerat dolores iste. Pariatur deserunt temporibus ducimus nulla debitis. Ratione ratione repudiandae deserunt labore ducimus quam exercitationem a. Fugit inventore pariatur eius eveniet tempore quia ea.', '3', '1', 'public/upload/photos/shares/lamborghini.jpg', '2018-01-15 08:24:34', '2018-01-15 08:25:44');
INSERT INTO `agencies` VALUES ('5', 'Johnson LLC', 'johnson-llc', 'Eveniet voluptas ratione quas error mollitia. Optio qui nihil autem odit sed.', '10', '1', 'public/upload/photos/shares/polo.jpg', '2018-01-15 08:24:34', '2018-01-15 08:25:52');

-- ----------------------------
-- Table structure for attributes
-- ----------------------------
DROP TABLE IF EXISTS `attributes`;
CREATE TABLE `attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attributes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of attributes
-- ----------------------------
INSERT INTO `attributes` VALUES ('2', 'Thể Tích', 'thetich', null, '1', '2018-01-15 08:28:04', '2018-01-15 08:28:04');
INSERT INTO `attributes` VALUES ('3', 'Size', 'size', null, '1', '2018-01-15 08:33:42', '2018-01-15 08:33:42');
INSERT INTO `attributes` VALUES ('4', 'Trọng lượng', 'trongluong', null, '1', '2018-01-15 08:38:56', '2018-01-15 08:38:56');

-- ----------------------------
-- Table structure for attribute_values
-- ----------------------------
DROP TABLE IF EXISTS `attribute_values`;
CREATE TABLE `attribute_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value_price` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `attribute_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_values_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of attribute_values
-- ----------------------------
INSERT INTO `attribute_values` VALUES ('2', '50ml', '1200000', '1', '1', '2', '2018-01-15 08:28:17', '2018-01-15 08:28:17');
INSERT INTO `attribute_values` VALUES ('3', '100ml', '2000000', '2', '1', '2', '2018-01-15 08:28:32', '2018-01-15 08:28:32');
INSERT INTO `attribute_values` VALUES ('4', '30ml', '900000', '3', '1', '2', '2018-01-15 08:32:51', '2018-01-15 08:32:51');
INSERT INTO `attribute_values` VALUES ('5', 'S', '', '4', '1', '3', '2018-01-15 08:33:49', '2018-01-15 08:33:49');
INSERT INTO `attribute_values` VALUES ('7', '600g', '', '6', '1', '4', '2018-01-15 08:39:06', '2018-01-15 08:39:06');
INSERT INTO `attribute_values` VALUES ('8', 'M', '', '7', '1', '3', '2018-01-15 08:40:35', '2018-01-15 08:40:35');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `sku_cate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `img_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agency_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_sku_cate_unique` (`sku_cate`),
  KEY `categories_agency_id_foreign` (`agency_id`),
  CONSTRAINT `categories_agency_id_foreign` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Ebert-Kirlin', 'ebert-kirlin', 'In dolorum qui eaque magnam occaecati eaque. Dolores numquam culpa ex provident dicta minus. Impedit asperiores rerum ab in iure facere dolor. Minima minima nihil veniam et.', 'EK', '8', '1', 'public/upload/photos/shares/Armani.jpg', '1', '2018-01-15 08:24:34', '2018-01-15 08:26:08');
INSERT INTO `categories` VALUES ('2', 'Gerhold, Dach and Dietrich', 'gerhold-dach-and-dietrich', 'Rerum debitis placeat esse non. Sequi qui ducimus earum quo. Aut excepturi doloremque laudantium aliquid. Dolores molestiae voluptatem totam.', 'GDD', '10', '1', 'public/upload/photos/shares/chanel.jpeg', '2', '2018-01-15 08:24:34', '2018-01-15 08:26:18');
INSERT INTO `categories` VALUES ('3', 'Thompson Inc', 'thompson-inc', 'Dolorem molestiae ut temporibus illum illo illum. Exercitationem tenetur sed qui ut dolore. Id ut neque sit temporibus molestias sunt ut quaerat. Accusamus sint tempora quis dolore.', 'TI', '10', '1', 'public/upload/photos/shares/ferrari.jpg', '3', '2018-01-15 08:24:35', '2018-01-15 08:26:28');
INSERT INTO `categories` VALUES ('4', 'Schimmel PLC', 'schimmel-plc', 'Distinctio iusto quas qui molestias. Explicabo voluptate eligendi consequuntur maiores magnam voluptatem repudiandae. Id ab eum necessitatibus sint repellendus odit. Quis voluptas mollitia cupiditate sed cumque consequatur et.', 'PLC', '8', '1', 'public/upload/photos/shares/lamborghini.jpg', '4', '2018-01-15 08:24:35', '2018-01-15 08:26:43');
INSERT INTO `categories` VALUES ('5', 'Von, Wisozk and Bartoletti', 'von-wisozk-and-bartoletti', 'Sed quo architecto occaecati repudiandae aut culpa molestiae dolor. Amet voluptatem consequatur quis dolor. Ut id nisi quo.', 'VWB', '8', '1', 'public/upload/photos/shares/polo.jpg', '5', '2018-01-15 08:24:35', '2018-01-15 08:26:56');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `approval` tinyint(1) NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_product_id_foreign` (`product_id`),
  CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for company_informations
-- ----------------------------
DROP TABLE IF EXISTS `company_informations`;
CREATE TABLE `company_informations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `map` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of company_informations
-- ----------------------------
INSERT INTO `company_informations` VALUES ('1', 'ruecker.marguerite@hotmail.com', '41090 Julien Forks Apt. 229', '866-263-1345', '0', '2018-01-15 08:24:35', '2018-01-15 08:24:35');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '1',
  `birthday` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`),
  UNIQUE KEY `customers_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', 'Porter', 'Howe', 'gnienow@example.org', 'alisa.ward', '$2y$10$0abyBNDX244YCQVzmjzr4OcrH27hj.E8VnJTsCwyBZ2SmcreMgv0i', '1-740-981-7160', '0', '1986-02-02', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('2', 'Elian', 'Stroman', 'schmitt.deron@example.com', 'eladio.wiza', '$2y$10$4lFEo3OwLPa4FYrBaRW4D.hDe3XO6MDoqE4KDOOO6gbaUiuD/7MPy', '796-688-2336 x310', '0', '1946-04-29', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('3', 'Christelle', 'Goyette', 'conner74@example.net', 'matteo.mclaughlin', '$2y$10$ESPa2c5ezbLEErMXoMdV1ep9W7IkM8d47epIVGeanlNc6sXlfgwge', '1-746-316-2619', '0', '1982-01-14', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('4', 'Gerson', 'Franecki', 'colby.boyle@example.com', 'kuhn.buster', '$2y$10$kGlynPERVfGlHMj.JOwc3e7wlHOlCQz7h/IyqazQ5D0eP/AadhVde', '1-753-279-7207 x25980', '0', '1954-09-05', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('5', 'Ike', 'Mayert', 'luigi.dooley@example.com', 'jfay', '$2y$10$qs2QQtZJQkdrbq82E6RGsuSJOUc3HDFz3VrVOc/T3rr9JA3LAtz4y', '635.956.1114 x09412', '0', '1986-02-02', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('6', 'Noble', 'Nolan', 'bdeckow@example.com', 'vledner', '$2y$10$GKPGIXrX7Ar96gC7unPSfO5XTp7kacpO4iL/HPlBWjViI8mW5h8nq', '+12953016662', '0', '1951-04-23', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('7', 'Monserrate', 'Aufderhar', 'heath.jenkins@example.net', 'streich.aglae', '$2y$10$lraDy1hPg/ybV7v8fO.e5O8M31o50P654IDGI3jE48wZtJs.tHGGu', '(256) 237-0736', '0', '1963-03-23', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('8', 'Myron', 'O\'Reilly', 'aylin.harber@example.net', 'omertz', '$2y$10$94QHU9FVlf4Gh0TlZl/fiuypXhLyu2UfGWimwd8jcmdMSc6gZRzIe', '(324) 906-6407 x80001', '0', '1986-02-02', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('9', 'Ivory', 'Haley', 'yjacobs@example.com', 'klein.efrain', '$2y$10$rr4noe8vhqEwk2CE.Rj9IekMuhhKnsncE7StubM9HcfULsMGYpjtS', '+1.879.599.3475', '0', '1986-02-02', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');
INSERT INTO `customers` VALUES ('10', 'Vanessa', 'Koch', 'franecki.sonya@example.org', 'simonis.erica', '$2y$10$3Q1TaTFVNWpKB9czAByXruD27yFPlugNF.rraqn6MKwTqeVI7w0W.', '979-223-1599 x16279', '0', '1986-02-02', null, '2018-01-15 08:24:36', '2018-01-15 08:24:36');

-- ----------------------------
-- Table structure for feedbacks
-- ----------------------------
DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `messages` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of feedbacks
-- ----------------------------
INSERT INTO `feedbacks` VALUES ('1', 'Dr. Brock Hilpert III', '1-855-547-7455', 'louvenia.ledner@example.net', 'Laborum non aut voluptatem ut eos eaque maxime quo. Magni eos animi ut repellendus asperiores corporis eveniet. Repellendus odit a sequi deserunt molestias commodi sit.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('2', 'Jerry Nicolas', '877-353-3036', 'bosco.verlie@example.org', 'Esse officiis tempora quis sapiente quis architecto. Dolore eveniet et sit quia. Laudantium dolorem distinctio eveniet doloribus.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('3', 'Heidi Jacobson', '(866) 520-3029', 'rebeca98@example.net', 'Impedit aperiam quia fugiat perspiciatis. Ad dicta et cupiditate facilis voluptatem.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('4', 'Winfield Feeney', '877.208.3189', 'annabell57@example.net', 'Omnis ut molestiae cumque. Et sequi dicta libero magnam et repudiandae. Dicta nobis ad dolorum et earum.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('5', 'Modesto Simonis PhD', '800-951-2651', 'hershel.steuber@example.org', 'Rerum deserunt atque voluptas dolores velit expedita facilis. Sequi libero quas dignissimos tenetur aut dicta quia. Nisi dolorem velit nesciunt asperiores voluptatum alias. Tenetur est tempore aspernatur perferendis.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('6', 'Mr. Art Mertz', '855.753.5548', 'csimonis@example.net', 'Quam eligendi vitae tempore in dolores deserunt. Et aut et excepturi maxime voluptatem aut consequatur. Beatae dolorem a quod asperiores deleniti omnis omnis.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('7', 'Ms. Simone Lehner', '888-310-6271', 'xadams@example.org', 'Quas voluptas commodi a et repellat. Porro omnis odit illo sit eum et. Neque voluptatem dolorem temporibus commodi.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('8', 'Mrs. Gracie Bode II', '888-356-8560', 'jaiden.robel@example.org', 'Suscipit aut eos fuga rem in explicabo. Aspernatur quis odio voluptatibus doloribus eos voluptas nostrum. Natus qui rerum earum nostrum explicabo et.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('9', 'Dr. Dale Beier I', '1-800-794-0280', 'kautzer.magdalena@example.net', 'Aperiam quis veniam tempora voluptatum perferendis non. Aut quibusdam ipsum eveniet ad tenetur suscipit. Natus consequuntur exercitationem ducimus corporis laboriosam numquam est. Expedita sed natus quas enim esse.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('10', 'Sonny Blick', '1-855-899-8665', 'zoie.lebsack@example.com', 'Omnis voluptatem quis cum error fugit. Non vel consequatur dolor quibusdam esse tempora fugit. Et dolor quae iure dolores. Aut magni non aliquam ut. Beatae iusto aut molestias ipsa consequatur.', '0', '2018-01-15 08:24:37', '2018-01-15 08:24:37');
INSERT INTO `feedbacks` VALUES ('11', 'Phan Minh Liêm', '01234567789', 'tester@localhost.com', 'test area', '0', '2018-01-16 04:54:58', '2018-01-16 04:54:58');

-- ----------------------------
-- Table structure for hotstatus
-- ----------------------------
DROP TABLE IF EXISTS `hotstatus`;
CREATE TABLE `hotstatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL DEFAULT '2' COMMENT '1: Nổi bật, 2: Default',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of hotstatus
-- ----------------------------

-- ----------------------------
-- Table structure for meta_configurations
-- ----------------------------
DROP TABLE IF EXISTS `meta_configurations`;
CREATE TABLE `meta_configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `metable_id` int(10) unsigned NOT NULL,
  `metable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `meta_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of meta_configurations
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2017_06_15_031022_create_photos_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050325_create_agencies_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050344_create_categories_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050400_create_products_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050403_create_comments_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050435_create_feedbacks_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050455_create_company_informations_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050509_create_news_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050518_create_pages_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050534_create_payment_methods_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050621_create_attributes_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_050649_create_attribute_values_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051040_create_ship_payments_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051120_create_promotions_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051130_create_payment_status_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051135_create_shipping_status_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051210_create_customers_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051215_create_orders_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051216_create_ship_addresses_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051217_create_order_products_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_051250_create_customer_addresses_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_071109_create_meta_configurations_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_095647_create_hotstatus_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_100542_laratrust_setup_tables', '1');
INSERT INTO `migrations` VALUES ('2017_12_20_141011_create_payment_suppliers_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_22_104534_create_product_attribute_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_23_084550_add_time_to_promotion_table', '1');
INSERT INTO `migrations` VALUES ('2017_12_31_111449_create_product_value_table', '1');
INSERT INTO `migrations` VALUES ('2018_01_15_075525_create_transaction_table', '1');
INSERT INTO `migrations` VALUES ('2018_01_15_081007_create_subcribe_table', '1');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `img_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'Sauer-DuBuque', 'sauer-dubuque', '<p>Amet molestiae quia facere ratione labore eius ratione. Ex placeat porro quis sunt aut expedita. Ea sed fuga delectus iure molestiae esse repudiandae. Voluptatem id rem consequuntur amet.</p>', 'Laborum distinctio officiis vel perspiciatis. Amet quod totam vel qui ut cum illo. Perspiciatis corrupti nulla saepe. Vitae veniam voluptatem qui.', 'public/upload/photos/shares/Armani.jpg', '9', '1', '2018-01-15 08:24:36', '2018-01-15 08:43:01');
INSERT INTO `news` VALUES ('2', 'Bernier-Miller', 'bernier-miller', '<p>Assumenda qui non voluptas voluptatem alias sint quia. Rerum et sunt deserunt sed est voluptatem consequatur. Qui quia possimus velit corporis dicta perspiciatis officiis. Rerum est voluptas accusantium occaecati et quibusdam.</p>', 'Quis ipsam ea repellendus culpa sequi quia. Dolor iste quia occaecati qui corporis ullam.', 'public/upload/photos/shares/lamborghini.jpg', '10', '1', '2018-01-15 08:24:36', '2018-01-15 08:43:09');
INSERT INTO `news` VALUES ('3', 'Koss, Mayer and Pouros', 'koss-mayer-and-pouros', '<p>Ratione a modi veniam laudantium veniam. Laborum repudiandae veniam velit expedita et. Reprehenderit non recusandae maxime optio non.</p>', 'Tempora quod autem consequatur ipsam aut ducimus. Nostrum velit dolore voluptate neque officiis. Delectus in porro sint ipsa voluptatibus.', 'public/upload/photos/shares/ferrari.jpg', '10', '1', '2018-01-15 08:24:36', '2018-01-15 08:43:18');
INSERT INTO `news` VALUES ('4', 'Hoppe, Will and Douglas', 'hoppe-will-and-douglas', '<p>Ut aspernatur perspiciatis in necessitatibus labore est ad earum. Aliquid officiis in dignissimos porro incidunt non id voluptatem. Ipsum expedita natus nisi voluptatem sit. Impedit nemo laborum voluptas. Temporibus nemo cumque explicabo.</p>', 'A incidunt velit qui rerum id sunt in. Qui eum ullam eos sapiente maiores. Nesciunt autem nobis commodi. Cumque voluptate harum esse distinctio et.', 'public/upload/photos/shares/polo.jpg', '10', '1', '2018-01-15 08:24:36', '2018-01-15 08:43:27');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_date` datetime DEFAULT NULL,
  `shipping_cost` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `total` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `customer_id` int(10) unsigned NOT NULL,
  `promotion_id` int(10) unsigned NOT NULL,
  `shipcost_id` int(10) unsigned NOT NULL,
  `paymentmethod_id` int(10) unsigned NOT NULL,
  `shipstatus_id` int(10) unsigned NOT NULL,
  `paymentstatus_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  KEY `orders_promotion_id_foreign` (`promotion_id`),
  KEY `orders_shipcost_id_foreign` (`shipcost_id`),
  KEY `orders_paymentmethod_id_foreign` (`paymentmethod_id`),
  KEY `orders_shipstatus_id_foreign` (`shipstatus_id`),
  KEY `orders_paymentstatus_id_foreign` (`paymentstatus_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_paymentmethod_id_foreign` FOREIGN KEY (`paymentmethod_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_paymentstatus_id_foreign` FOREIGN KEY (`paymentstatus_id`) REFERENCES `paymentstatus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_shipcost_id_foreign` FOREIGN KEY (`shipcost_id`) REFERENCES `ship_payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_shipstatus_id_foreign` FOREIGN KEY (`shipstatus_id`) REFERENCES `shipstatus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for order_products
-- ----------------------------
DROP TABLE IF EXISTS `order_products`;
CREATE TABLE `order_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quality` int(11) NOT NULL DEFAULT '1',
  `unit_price` int(11) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_products_product_id_foreign` (`product_id`),
  KEY `order_products_order_id_foreign` (`order_id`),
  CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of order_products
-- ----------------------------

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'Hướng dẫn mua hàng', 'huong-dan-mua-hang', '<p>Quis voluptatem quasi temporibus omnis cum. Esse sunt dolorum natus dolorem modi aperiam. Aut cumque deleniti amet vel fugiat animi reprehenderit. Et aut ex totam eligendi nemo.</p>', '1', '1', '2018-01-15 08:24:37', '2018-01-16 08:16:33');
INSERT INTO `pages` VALUES ('2', 'Chính sách bảo mật', 'chinh-sach-bao-mat', '<p>Aut suscipit iure et. Reprehenderit et et non inventore. Esse vel vel dolor sit commodi sed dolorum.</p>', '2', '1', '2018-01-15 08:24:37', '2018-01-16 08:16:33');
INSERT INTO `pages` VALUES ('3', 'Hỗ trợ khách hàng', 'ho-tro-khach-hang', '<p>Dolor est autem eligendi cumque. Voluptatibus alias harum qui facere. Qui eos voluptas ut est voluptatum temporibus quis. Sit est id est officia unde accusantium sed quia.</p>', '3', '1', '2018-01-15 08:24:37', '2018-01-16 08:16:33');
INSERT INTO `pages` VALUES ('4', 'Giới Thiệu', 'gioi-thieu', '<p>Thế kỷ 21 chứng kiến sự to&agrave;n cầu ho&aacute; v&agrave; ph&aacute;t triển vượt bậc của c&ocirc;ng nghệ, đ&ograve;i hỏi c&aacute;c bạn trẻ sự tự tin, khả năng th&iacute;ch ứng để hội nhập v&agrave; th&agrave;nh c&ocirc;ng. <br />Tại ILA, ch&uacute;ng t&ocirc;i gi&uacute;p học vi&ecirc;n kh&ocirc;ng chỉ giỏi tiếng Anh m&agrave; c&ograve;n n&acirc;ng cao 6 kỹ năng thiết yếu cho nghề nghiệp trong thế giới hiện đại ng&agrave;y nay gồm:<br />Communication - Kỹ năng giao tiếp, Collaboration - Kỹ năng hợp t&aacute;c, Creativity - Khả năng s&aacute;ng tạo, Critical thinking - Tư duy phản biện, <br />Digital literacy - Kiến thức c&ocirc;ng nghệ, Self-reflection - Khả năng tự ho&agrave;n thiện bản th&acirc;n.</p>', '4', '1', '2018-01-16 08:06:52', '2018-01-16 08:17:49');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for paymentstatus
-- ----------------------------
DROP TABLE IF EXISTS `paymentstatus`;
CREATE TABLE `paymentstatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL DEFAULT '1' COMMENT '1: Chưa Thanh Toán, 2: Đã Thanh Toán',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of paymentstatus
-- ----------------------------

-- ----------------------------
-- Table structure for payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------
INSERT INTO `payment_methods` VALUES ('1', 'COD', null, 'Thanh toán khi giao hàng', '1', '1', '2018-01-15 08:24:37', '2018-01-15 08:24:37');

-- ----------------------------
-- Table structure for payment_suppliers
-- ----------------------------
DROP TABLE IF EXISTS `payment_suppliers`;
CREATE TABLE `payment_suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `img_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of payment_suppliers
-- ----------------------------
INSERT INTO `payment_suppliers` VALUES ('1', 'OnePay', 'Thanh toán bằng OnePay', null, '1', '1', '2018-01-15 08:24:37', '2018-01-15 08:24:37');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'login', 'login', '', '2018-01-15 08:24:58', '2018-01-15 08:24:58');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');

-- ----------------------------
-- Table structure for permission_user
-- ----------------------------
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user` (
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_user
-- ----------------------------

-- ----------------------------
-- Table structure for photos
-- ----------------------------
DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumb_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `photoable_id` int(11) NOT NULL,
  `photoable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of photos
-- ----------------------------
INSERT INTO `photos` VALUES ('1', null, 'public/upload//origin/1516004918_chanel-coco.jpg', 'public/upload//thumbnails/100x100/1516004918_chanel-coco.jpg', null, '1', '1', 'App\\Models\\Product', '2018-01-15 08:28:38', '2018-01-15 08:28:38');
INSERT INTO `photos` VALUES ('2', null, 'public/upload//origin/1516004918_chanel-coco-02.jpg', 'public/upload//thumbnails/100x100/1516004918_chanel-coco-02.jpg', null, '1', '1', 'App\\Models\\Product', '2018-01-15 08:28:38', '2018-01-15 08:28:38');
INSERT INTO `photos` VALUES ('3', null, 'public/upload//origin/1516005175_chanel-coco-02.jpg', 'public/upload//thumbnails/100x100/1516005175_chanel-coco-02.jpg', null, '2', '2', 'App\\Models\\Product', '2018-01-15 08:32:55', '2018-01-15 08:32:55');
INSERT INTO `photos` VALUES ('4', null, 'public/upload//origin/1516005398_jean02.jpg', 'public/upload//thumbnails/100x100/1516005398_jean02.jpg', null, '3', '3', 'App\\Models\\Product', '2018-01-15 08:36:38', '2018-01-15 08:36:38');
INSERT INTO `photos` VALUES ('5', null, 'public/upload//origin/1516005561_lotion01.jpg', 'public/upload//thumbnails/100x100/1516005561_lotion01.jpg', null, '4', '6', 'App\\Models\\Product', '2018-01-15 08:39:21', '2018-01-15 08:39:21');
INSERT INTO `photos` VALUES ('6', null, 'public/upload//origin/1516005561_lotion02.jpg', 'public/upload//thumbnails/100x100/1516005561_lotion02.jpg', null, '4', '6', 'App\\Models\\Product', '2018-01-15 08:39:21', '2018-01-15 08:39:21');
INSERT INTO `photos` VALUES ('7', null, 'public/upload//origin/1516005640_jean01.jpg', 'public/upload//thumbnails/100x100/1516005640_jean01.jpg', null, '5', '8', 'App\\Models\\Product', '2018-01-15 08:40:40', '2018-01-15 08:40:40');
INSERT INTO `photos` VALUES ('8', null, 'public/upload//origin/1516005640_jean02.jpg', 'public/upload//thumbnails/100x100/1516005640_jean02.jpg', null, '5', '8', 'App\\Models\\Product', '2018-01-15 08:40:40', '2018-01-15 08:40:40');
INSERT INTO `photos` VALUES ('9', null, 'public/upload//origin/1516005692_glasses01.jpg', 'public/upload//thumbnails/100x100/1516005692_glasses01.jpg', null, '6', '9', 'App\\Models\\Product', '2018-01-15 08:41:32', '2018-01-15 08:41:32');
INSERT INTO `photos` VALUES ('10', null, 'public/upload//origin/1516005692_glasses02.jpg', 'public/upload//thumbnails/100x100/1516005692_glasses02.jpg', null, '6', '9', 'App\\Models\\Product', '2018-01-15 08:41:33', '2018-01-15 08:41:33');
INSERT INTO `photos` VALUES ('11', null, 'public/upload//origin/1516005748_lotion01.jpg', 'public/upload//thumbnails/100x100/1516005748_lotion01.jpg', null, '7', '10', 'App\\Models\\Product', '2018-01-15 08:42:28', '2018-01-15 08:42:28');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `sku_product` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `stock_quality` int(11) DEFAULT NULL,
  `img_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT '0',
  `count_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_product_unique` (`sku_product`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', 'Chanel Rose', 'chanel-rose', 'Maiores sed assumenda deserunt ad aut accusamus. Consequatur reprehenderit ex ducimus in consequuntur. Sequi tempore sint sunt placeat sed. Possimus rerum et non quaerat aspernatur et.', '<p>Quia laudantium aspernatur quibusdam id voluptatem tempora est recusandae. Aperiam eligendi sed aut consequuntur ab est. Totam eum ea sed quia.</p>', 'CR', '4512715', '0', '200', 'public/upload/photos/shares/NuocHoa/chanel-coco-02.jpg', '0', '0', '1', '1', '1', '2018-01-15 08:24:34', '2018-01-15 08:36:57');
INSERT INTO `products` VALUES ('2', 'Dòng hương gỗ', 'dong-huong-go', 'Aspernatur eius voluptas placeat velit corporis voluptas ut. Praesentium eligendi et velit et. Laboriosam dicta eveniet non incidunt distinctio error.', '<p>Nesciunt qui aut autem assumenda velit est ipsum. Sunt minus accusamus tenetur sit ut ipsum aut. Placeat fugit et ex quis totam voluptas eveniet.</p>', 'HG', '7701634', '0', '200', 'public/upload/photos/shares/NuocHoa/chanel-coco.jpg', '0', '0', '2', '1', '1', '2018-01-15 08:24:35', '2018-01-15 08:36:57');
INSERT INTO `products` VALUES ('3', 'Jean Summer', 'jean-summer', 'Ut eos et sed aut aut quas. Sapiente neque nobis cumque quo accusamus. Quia doloremque quasi rerum et assumenda et libero.', '<p>Id laboriosam occaecati eaque quae possimus. Quia dolorem deleniti rerum provident nihil. Unde ex voluptates et deleniti recusandae.</p>', 'JS', '8578568', '0', '200', 'public/upload/photos/shares/Quan Jean/jean01.jpg', '0', '0', '3', '1', '2', '2018-01-15 08:24:35', '2018-01-15 08:36:57');
INSERT INTO `products` VALUES ('6', 'Lotion Summer', 'lotion-summer', 'Eaque quam consequatur enim autem. Corrupti ut culpa quasi qui ipsum. Dolor minima nesciunt sed. Accusantium ut dolorem exercitationem in.', '<p>Recusandae corporis vel tempora illo temporibus. Consequatur quisquam est minima in perspiciatis. Voluptatem et vel deserunt.</p>', 'LS', '3896037', '0', '200', 'public/upload/photos/shares/Lotionscream/lotion03.jpg', '0', '0', '4', '1', '3', '2018-01-15 08:24:35', '2018-01-15 08:39:21');
INSERT INTO `products` VALUES ('8', 'Jean Rách', 'jean-rach', 'Totam placeat magnam et. Sapiente similique delectus quia eveniet et. At reprehenderit ea provident impedit. Exercitationem excepturi fuga ut est aliquid earum.', '<p>Tenetur architecto praesentium nulla aliquid. Alias non nulla quod enim. Consequuntur voluptatem aliquam nemo eligendi earum qui aut recusandae. Iste tempore necessitatibus nihil exercitationem.</p>', 'JR', '1641088', '0', '200', 'public/upload/photos/shares/Quan Jean/jean02.jpg', '0', '0', '5', '1', '2', '2018-01-15 08:24:35', '2018-01-15 08:40:40');
INSERT INTO `products` VALUES ('9', 'Kính Mát Nam', 'kinh-mat-nam', 'Dolores quia optio tempora est voluptatum sapiente. Ut nisi eum velit ut. Accusamus tempore ut blanditiis.', '<p>Illum reiciendis eligendi eos ipsa sapiente voluptatem veniam. Dolores rerum ut explicabo molestias qui velit quisquam.</p>', 'KMN', '3930951', '0', '200', 'public/upload/photos/shares/Glasses/glasses01.jpg', '0', '0', '6', '1', '3', '2018-01-15 08:24:35', '2018-01-15 08:41:32');
INSERT INTO `products` VALUES ('10', 'Night Lotion', 'night-lotion', 'Qui non voluptatibus quibusdam voluptatem. A consequuntur iste sunt eaque delectus sunt aut. Voluptas quia et enim. Iure fugiat voluptatum odit accusamus numquam cum.', '<p>Repudiandae ex hic voluptatum facilis. Quasi eum ut aperiam rem. Amet et illum tenetur neque sit. Natus qui velit voluptatum.</p>', 'NL', '3231004', '0', '200', 'public/upload/photos/shares/Lotionscream/lotion02.jpg', '0', '0', '0', '1', '4', '2018-01-15 08:24:35', '2018-01-15 08:42:28');

-- ----------------------------
-- Table structure for product_attribute
-- ----------------------------
DROP TABLE IF EXISTS `product_attribute`;
CREATE TABLE `product_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attribute_product_id_foreign` (`product_id`),
  KEY `product_attribute_attribute_id_foreign` (`attribute_id`),
  CONSTRAINT `product_attribute_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_attribute_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of product_attribute
-- ----------------------------
INSERT INTO `product_attribute` VALUES ('1', '1', '2', null, null);
INSERT INTO `product_attribute` VALUES ('2', '2', '2', null, null);
INSERT INTO `product_attribute` VALUES ('3', '3', '3', null, null);
INSERT INTO `product_attribute` VALUES ('4', '6', '2', null, null);
INSERT INTO `product_attribute` VALUES ('5', '6', '4', null, null);
INSERT INTO `product_attribute` VALUES ('6', '8', '3', null, null);
INSERT INTO `product_attribute` VALUES ('7', '10', '4', null, null);

-- ----------------------------
-- Table structure for product_value
-- ----------------------------
DROP TABLE IF EXISTS `product_value`;
CREATE TABLE `product_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `attribute_value_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_value_product_id_foreign` (`product_id`),
  KEY `product_value_attribute_value_id_foreign` (`attribute_value_id`),
  CONSTRAINT `product_value_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_value_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of product_value
-- ----------------------------
INSERT INTO `product_value` VALUES ('1', '1', '2', null, null);
INSERT INTO `product_value` VALUES ('2', '1', '3', null, null);
INSERT INTO `product_value` VALUES ('3', '2', '4', null, null);
INSERT INTO `product_value` VALUES ('4', '3', '5', null, null);
INSERT INTO `product_value` VALUES ('5', '6', '7', null, null);
INSERT INTO `product_value` VALUES ('6', '8', '5', null, null);
INSERT INTO `product_value` VALUES ('7', '8', '8', null, null);
INSERT INTO `product_value` VALUES ('8', '10', '7', null, null);

-- ----------------------------
-- Table structure for promotions
-- ----------------------------
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sku_promotion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'subtotal',
  `value` int(11) NOT NULL DEFAULT '-10',
  `value_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '%',
  `quality` int(11) NOT NULL DEFAULT '100',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `from_time` date NOT NULL,
  `to_time` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `num_use` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `promotions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of promotions
-- ----------------------------
INSERT INTO `promotions` VALUES ('1', 'Xuân 2018', 'xuan-2018', 'XUAN2018', 'Veritatis reiciendis ipsum eum eos enim mollitia odit. Iure ea expedita eveniet doloremque expedita assumenda. Nostrum dolorum natus facere aliquam perferendis quia. Inventore debitis corrupti laborum error sed ipsa.', null, 'subtotal', '-10', '%', '1', '1', '2018-01-15', '2018-01-16', '2018-01-15 08:24:37', '2018-01-15 08:51:32', '0');
INSERT INTO `promotions` VALUES ('2', 'Velentine 2018', 'velentine-2018', 'VLOVE2018', 'Aut eveniet voluptates numquam qui sed et dolores. Quasi fugit dolorem quo dolores sapiente cum. Unde nemo est sunt architecto cupiditate autem a veritatis.', null, 'subtotal', '-200000', 'vnd', '5', '1', '2018-01-15', '2018-01-24', '2018-01-15 08:24:37', '2018-01-15 08:48:08', '0');
INSERT INTO `promotions` VALUES ('3', 'Quốc Tế Phụ Nữ 2018', 'quoc-te-phu-nu-2018', 'WDAY', 'Deserunt earum harum soluta. Dolores sed et quasi est eum. Adipisci reprehenderit nobis commodi.', null, 'subtotal', '-30', '%', '10', '1', '2018-01-15', '2018-03-08', '2018-01-15 08:24:37', '2018-01-15 08:51:17', '0');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', 'admin', '', '2018-01-15 08:24:53', '2018-01-15 08:24:53');

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1', 'App\\Models\\User');

-- ----------------------------
-- Table structure for shipstatus
-- ----------------------------
DROP TABLE IF EXISTS `shipstatus`;
CREATE TABLE `shipstatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL DEFAULT '1' COMMENT '1: Trong Kho, 2: Đang Vận Chuyển Hoặc Sử Lý, 3: Đã Nhận Hàng',
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of shipstatus
-- ----------------------------

-- ----------------------------
-- Table structure for ship_addresses
-- ----------------------------
DROP TABLE IF EXISTS `ship_addresses`;
CREATE TABLE `ship_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `district` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `order_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ship_addresses_order_id_foreign` (`order_id`),
  CONSTRAINT `ship_addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ship_addresses
-- ----------------------------

-- ----------------------------
-- Table structure for ship_payments
-- ----------------------------
DROP TABLE IF EXISTS `ship_payments`;
CREATE TABLE `ship_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `value` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ship_payments
-- ----------------------------

-- ----------------------------
-- Table structure for subscribes
-- ----------------------------
DROP TABLE IF EXISTS `subscribes`;
CREATE TABLE `subscribes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of subscribes
-- ----------------------------

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `transaction_id` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `merchant_code` varchar(34) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of transactions
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '1',
  `birthday` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'LP', 'minhliemphp@gmail.com', '$2y$10$gGCqqHCrvb84QzmvwbIEiOhhf6ETSO/c52p685IMCgNK5cLgNkq9W', null, '1', null, null, '2018-01-15 08:25:14', '2018-01-15 08:25:14');

-- ----------------------------
-- Table structure for user_addresses
-- ----------------------------
DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE `user_addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `district` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_addresses_customer_id_foreign` (`customer_id`),
  CONSTRAINT `user_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user_addresses
-- ----------------------------
