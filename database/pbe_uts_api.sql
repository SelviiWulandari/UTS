/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.4.21-MariaDB : Database - pbe_uts_api
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pbe_uts_api` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pbe_uts_api`;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2021_10_07_023349_create_users_table',1),
(2,'2021_10_07_023809_create_playlists_table',2),
(3,'2021_10_07_024211_create_songs_table',3),
(4,'2021_10_07_030111_create_playlistsongs_table',4);

/*Table structure for table `playlists` */

DROP TABLE IF EXISTS `playlists`;

CREATE TABLE `playlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `playlists_user_id_foreign` (`user_id`),
  CONSTRAINT `playlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `playlists` */

insert  into `playlists`(`id`,`name`,`user_id`,`created_at`,`updated_at`) values 
(1,'Musik K-Pop',1,'2021-10-11 05:09:19','2021-10-11 05:09:19'),
(2,'Musik Rock',2,'2021-10-11 05:11:23','2021-10-11 05:11:23'),
(3,'Musik DJ',2,NULL,NULL),
(5,'Musik Dance',2,NULL,NULL),
(9,'Musik Santai',3,'2021-10-13 00:24:57','2021-10-13 00:24:57'),
(10,'Kumpulan Lagu DJ',3,'2021-10-13 00:27:00','2021-10-13 00:27:00');

/*Table structure for table `playlistsongs` */

DROP TABLE IF EXISTS `playlistsongs`;

CREATE TABLE `playlistsongs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `playlist_id` bigint(20) unsigned NOT NULL,
  `song_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `playlistsongs_playlist_id_foreign` (`playlist_id`),
  KEY `playlistsongs_song_id_foreign` (`song_id`),
  CONSTRAINT `playlistsongs_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`),
  CONSTRAINT `playlistsongs_song_id_foreign` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `playlistsongs` */

insert  into `playlistsongs`(`id`,`playlist_id`,`song_id`,`created_at`,`updated_at`) values 
(1,1,2,'2021-10-11 05:56:45','2021-10-11 05:56:45'),
(4,1,1,'2021-10-11 06:11:10','2021-10-11 06:11:10'),
(5,1,1,'2021-10-11 06:59:00','2021-10-11 06:59:00'),
(6,9,1,'2021-10-13 00:34:31','2021-10-13 00:34:31'),
(7,3,1,'2021-10-13 01:10:11','2021-10-13 01:10:11'),
(8,2,2,'2021-10-13 01:39:17','2021-10-13 01:39:17'),
(9,3,2,'2021-10-13 01:40:51','2021-10-13 01:40:51');

/*Table structure for table `songs` */

DROP TABLE IF EXISTS `songs`;

CREATE TABLE `songs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `artist` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gendre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `songs` */

insert  into `songs`(`id`,`title`,`year`,`artist`,`gendre`,`duration`,`created_at`,`updated_at`) values 
(1,'To The Bone',2019,'Pamungkas','Pop','00:04:12','2021-10-11 05:50:35','2021-10-11 05:50:35'),
(2,'Bobo dimana',2019,'Lucinta Luna','Dance','00:04:34','2021-10-11 05:51:07','2021-10-11 05:51:07');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('superuser','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_token_unique` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`password`,`role`,`fullname`,`token`,`created_at`,`updated_at`) values 
(1,'selvi@gmail.com','$2y$10$xuTqpjq3NF/bsfksY8GDsuxehsLo2JQNUgo12Woj7oHTsxQY8jPcu','superuser','selviwulandari','NVkYn3XrROcjp3LjZ4EGxzPV8JL8mbeO6ajyok3MCdBAgdjXjEFk5JZ4H5BNwYX6QWcGhbBiDpYALSbFaW1toI3A7bVt6bKFPIhKOPPtj',NULL,'2021-10-13 01:41:25'),
(2,'wulan@gmail.com','$2y$10$HIgXl4oSpo/w9FXAdlnUw.OQte7BPsuOYA97bRav5nZgkTvgt1wW2','user','wulandari','Vezm3Acnw6CQDiKGg6zJkgDjc8DVOU5grasO5mQ7VNjVDYJ7VIjpK964F857gW2gFq984tlmJDcYWqD3a5BooSVhXkj2503mg7fBVRFnc',NULL,'2021-10-13 01:41:50'),
(3,'lely@gmail.com','$2y$10$pEOFe2aAxiZhE9F1HpwwLOylFlY1ctzgGBYhfr4aWC52KRiwmczuG','user','lelysusanti','MhxKD19s9kOqrkWhUSHXzcDVqXLJv9RNUQRRBkFuTBnVVnYLNjiZg2dgbPmxZJZrnvWv6pzDGeCtMwbtadGXR3pcM5ZhZmhTWvxUvWrbW','2021-10-11 05:07:37','2021-10-13 00:24:14'),
(4,'anton@gmail.com','$2y$10$bGsIShajEnQC.6ZwYku2G.n8FJ9MRz69HsC03FxFZ9zDd8f.BVaS6','user','putra antonio',NULL,'2021-10-12 07:05:53','2021-10-12 07:05:53');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
