/*
 Navicat Premium Data Transfer

 Source Server         : lokal maria
 Source Server Type    : MariaDB
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : appmotor

 Target Server Type    : MariaDB
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 30/04/2019 10:15:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for auth_groups
-- ----------------------------
DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE `auth_groups`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_groups
-- ----------------------------
INSERT INTO `auth_groups` VALUES (1, 'admin', 'Administrator');
INSERT INTO `auth_groups` VALUES (2, 'members', 'General User');

-- ----------------------------
-- Table structure for auth_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `auth_login_attempts`;
CREATE TABLE `auth_login_attempts`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `login` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_login_attempts
-- ----------------------------
INSERT INTO `auth_login_attempts` VALUES (1, '127.0.0.1', 'member', 1555311657);
INSERT INTO `auth_login_attempts` VALUES (2, '127.0.0.1', 'andre', 1555311667);

-- ----------------------------
-- Table structure for auth_users
-- ----------------------------
DROP TABLE IF EXISTS `auth_users`;
CREATE TABLE `auth_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `salt` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(254) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `activation_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `forgotten_password_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED NULL DEFAULT NULL,
  `remember_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED NULL DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `company` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_users
-- ----------------------------
INSERT INTO `auth_users` VALUES (1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1551674214, 1, 'Admin', '', '', '085258434274');
INSERT INTO `auth_users` VALUES (3, '127.0.0.1', 'desy1234', '$2y$08$z.y7uYQk1EhFNhS1CuBwTOWdMRU6Hijf69EIs6wqlen0wiEpPpk5C', NULL, 'desy@app.com', NULL, NULL, NULL, NULL, 1550121815, 1555311695, 1, 'Desy', '', '', '081939432238');
INSERT INTO `auth_users` VALUES (4, '127.0.0.1', 'b4affan', '$2y$08$aFkyDqIRn/jxA0Tal1l9Q.q/IjKFVw5dhAUAHCsAMCv/UcnnfjQyi', NULL, 'b4affan@gmail.com', NULL, NULL, NULL, NULL, 1551195888, 1551196039, 1, 'Moh. Affan', '', '', '085258434274');

-- ----------------------------
-- Table structure for auth_users_groups
-- ----------------------------
DROP TABLE IF EXISTS `auth_users_groups`;
CREATE TABLE `auth_users_groups`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uc_users_groups`(`user_id`, `group_id`) USING BTREE,
  INDEX `fk_users_groups_users1_idx`(`user_id`) USING BTREE,
  INDEX `fk_users_groups_groups1_idx`(`group_id`) USING BTREE,
  CONSTRAINT `auth_users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `auth_users_groups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_users_groups
-- ----------------------------
INSERT INTO `auth_users_groups` VALUES (18, 1, 1);
INSERT INTO `auth_users_groups` VALUES (19, 1, 2);
INSERT INTO `auth_users_groups` VALUES (30, 3, 2);
INSERT INTO `auth_users_groups` VALUES (31, 4, 2);

-- ----------------------------
-- Table structure for log_rek
-- ----------------------------
DROP TABLE IF EXISTS `log_rek`;
CREATE TABLE `log_rek`  (
  `id_log` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `motor_id` int(11) NOT NULL,
  `metode` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nilai` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `urutan` int(11) NOT NULL,
  `exec_time` float NOT NULL,
  `sesi` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_log`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 163 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of log_rek
-- ----------------------------
INSERT INTO `log_rek` VALUES (103, 40, 'tsukamoto', '0.0035714285714287', 1, 0.0143, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (104, 50, 'tsukamoto', '0.035714285714286', 2, 0.0143, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (105, 37, 'tsukamoto', '0.096458333333333', 3, 0.0143, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (106, 6, 'tsukamoto', '0.125', 4, 0.0143, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (107, 38, 'tsukamoto', '0.14229166666667', 5, 0.0143, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (108, 40, 'mamdani', '0.0000064004096262166', 1, 0.0152, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (109, 50, 'mamdani', '0.00066137566137566', 2, 0.0152, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (110, 37, 'mamdani', '0.0051487443317193', 3, 0.0152, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (111, 6, 'mamdani', '0.0089285714285714', 4, 0.0152, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (112, 38, 'mamdani', '0.011802915755809', 5, 0.0152, 'UBX1Ztlw', '2019-03-04 05:35:33', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (113, 31, 'tsukamoto', '0.67469879518072', 1, 0.0138, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (114, 15, 'tsukamoto', '0.67469879518072', 2, 0.0138, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (115, 13, 'tsukamoto', '0.67469879518072', 3, 0.0138, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (116, 12, 'tsukamoto', '0.68469879518072', 4, 0.0138, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (117, 22, 'tsukamoto', '0.69638554216867', 5, 0.0138, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (118, 48, 'mamdani', '0.000071715433161216', 1, 0.0153, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (119, 26, 'mamdani', '0.016666666666667', 2, 0.0153, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (120, 25, 'mamdani', '0.016666666666667', 3, 0.0153, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (121, 29, 'mamdani', '0.016666666666667', 4, 0.0153, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (122, 27, 'mamdani', '0.016666666666667', 5, 0.0153, '07DhvMQk', '2019-04-15 09:04:28', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (123, 59, 'tsukamoto', '0.13253012048193', 1, 0.0049, 'IHxmOMVD', '2019-04-15 09:06:35', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (124, 60, 'tsukamoto', '0.19375', 2, 0.0049, 'IHxmOMVD', '2019-04-15 09:06:35', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (125, 57, 'mamdani', '0.25918307375845', 1, 0.0126, 'IHxmOMVD', '2019-04-15 09:06:35', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (126, 52, 'mamdani', '1.5658163294508', 2, 0.0126, 'IHxmOMVD', '2019-04-15 09:06:35', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (127, 60, 'mamdani', '1.6775201612903', 3, 0.0126, 'IHxmOMVD', '2019-04-15 09:06:35', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (128, 59, 'mamdani', '2.8389923329682', 4, 0.0126, 'IHxmOMVD', '2019-04-15 09:06:35', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (129, 59, 'tsukamoto', '0.13253012048193', 1, 0.0063, 'OqyPjH73', '2019-04-15 09:10:01', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (130, 60, 'tsukamoto', '0.19375', 2, 0.0063, 'OqyPjH73', '2019-04-15 09:10:01', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (131, 57, 'mamdani', '0.25918307375845', 1, 0.01, 'OqyPjH73', '2019-04-15 09:10:01', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (132, 52, 'mamdani', '1.5658163294508', 2, 0.01, 'OqyPjH73', '2019-04-15 09:10:01', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (133, 60, 'mamdani', '1.6775201612903', 3, 0.01, 'OqyPjH73', '2019-04-15 09:10:02', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (134, 59, 'mamdani', '2.8389923329682', 4, 0.01, 'OqyPjH73', '2019-04-15 09:10:02', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (135, 59, 'tsukamoto', '0.13253012048193', 1, 0.0055, 'pGAORWPB', '2019-04-15 09:12:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (136, 60, 'tsukamoto', '0.19375', 2, 0.0055, 'pGAORWPB', '2019-04-15 09:12:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (137, 57, 'mamdani', '0.25918307375845', 1, 0.0131, 'pGAORWPB', '2019-04-15 09:12:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (138, 52, 'mamdani', '1.5658163294508', 2, 0.0131, 'pGAORWPB', '2019-04-15 09:12:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (139, 60, 'mamdani', '1.6775201612903', 3, 0.0131, 'pGAORWPB', '2019-04-15 09:12:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (140, 59, 'mamdani', '2.8389923329682', 4, 0.0131, 'pGAORWPB', '2019-04-15 09:12:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (141, 59, 'tsukamoto', '0.13253012048193', 1, 0.0045, 'GzTMh54e', '2019-04-15 09:12:42', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (142, 60, 'tsukamoto', '0.19375', 2, 0.0045, 'GzTMh54e', '2019-04-15 09:12:42', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (143, 57, 'mamdani', '0.25918307375845', 1, 0.0157, 'GzTMh54e', '2019-04-15 09:12:42', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (144, 52, 'mamdani', '1.5658163294508', 2, 0.0157, 'GzTMh54e', '2019-04-15 09:12:42', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (145, 60, 'mamdani', '1.6775201612903', 3, 0.0157, 'GzTMh54e', '2019-04-15 09:12:42', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (146, 59, 'mamdani', '2.8389923329682', 4, 0.0157, 'GzTMh54e', '2019-04-15 09:12:42', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (147, 59, 'tsukamoto', '0.13253012048193', 1, 0.0045, '9TRYP1Sg', '2019-04-15 09:13:08', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (148, 60, 'tsukamoto', '0.19375', 2, 0.0045, '9TRYP1Sg', '2019-04-15 09:13:09', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (149, 57, 'mamdani', '0.25918307375845', 1, 0.01, '9TRYP1Sg', '2019-04-15 09:13:09', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (150, 52, 'mamdani', '1.5658163294508', 2, 0.01, '9TRYP1Sg', '2019-04-15 09:13:09', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (151, 60, 'mamdani', '1.6775201612903', 3, 0.01, '9TRYP1Sg', '2019-04-15 09:13:09', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (152, 59, 'mamdani', '2.8389923329682', 4, 0.01, '9TRYP1Sg', '2019-04-15 09:13:09', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (153, 59, 'tsukamoto', '0.13253012048193', 1, 0.0055, 'Uk7wPSeZ', '2019-04-15 09:14:17', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (154, 60, 'tsukamoto', '0.19375', 2, 0.0055, 'Uk7wPSeZ', '2019-04-15 09:14:17', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (155, 57, 'mamdani', '0.25918307375845', 1, 0.0104, 'Uk7wPSeZ', '2019-04-15 09:14:17', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (156, 52, 'mamdani', '1.5658163294508', 2, 0.0104, 'Uk7wPSeZ', '2019-04-15 09:14:17', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (157, 60, 'mamdani', '1.6775201612903', 3, 0.0104, 'Uk7wPSeZ', '2019-04-15 09:14:17', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (158, 59, 'mamdani', '2.8389923329682', 4, 0.0104, 'Uk7wPSeZ', '2019-04-15 09:14:17', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (159, 59, 'tsukamoto', '0.13253012048193', 1, 0.0049, 'kc46Mdlr', '2019-04-15 09:18:40', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (160, 60, 'tsukamoto', '0.19375', 2, 0.0049, 'kc46Mdlr', '2019-04-15 09:18:40', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (161, 60, 'mamdani', '1.6775201612903', 1, 0.0044, 'kc46Mdlr', '2019-04-15 09:18:41', 3, NULL, NULL);
INSERT INTO `log_rek` VALUES (162, 59, 'mamdani', '2.8389923329682', 2, 0.0044, 'kc46Mdlr', '2019-04-15 09:18:41', 3, NULL, NULL);

-- ----------------------------
-- Table structure for motor
-- ----------------------------
DROP TABLE IF EXISTS `motor`;
CREATE TABLE `motor`  (
  `id_motor` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merek` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tipe` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `tangki` float NOT NULL,
  `kecepatan` float NOT NULL,
  `tipetransmisi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `transmisi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bagasi` float NOT NULL,
  `berat` float NOT NULL,
  `warna` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_motor`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of motor
-- ----------------------------
INSERT INTO `motor` VALUES (1, 'Honda', 'SUPRA X FI SP', 17670000, 3.7, 125, 'Manual', 'Manual, 4-kecepatan', 5.3, 103, 'Hitam', '2018-09-19 11:37:31', 1, NULL, NULL);
INSERT INTO `motor` VALUES (2, 'Honda', 'SUPRA X FI CW', 18740000, 3.7, 125, 'Manual', 'Manual, 4-kecepatan', 5.3, 104, 'Hitam', '2018-09-19 11:37:36', 1, NULL, NULL);
INSERT INTO `motor` VALUES (3, 'Honda', 'SUPRA X FI CW Luxury', 18740000, 4, 124.89, 'Manual', 'Manual, 4-kecepatan', 5.3, 104, 'Merah', '2018-09-19 11:37:39', 1, NULL, NULL);
INSERT INTO `motor` VALUES (4, 'Honda', 'SUPRA X HI FI', 19100000, 4, 124.89, 'Manual', 'Manual, 4-kecepatan', 19.5, 107, 'Biru, Merah, Ungu', '2018-09-19 11:37:46', 1, NULL, NULL);
INSERT INTO `motor` VALUES (5, 'Honda', 'SUPRA GTR SPORTY', 22620000, 4.5, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 119, 'Orange, Merah', '2018-09-19 11:37:48', 1, NULL, NULL);
INSERT INTO `motor` VALUES (6, 'Honda', 'SUPRA GTR EXCLUSIVE', 22820000, 4.5, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 119, 'Hitam', '2018-09-19 11:37:54', 1, NULL, NULL);
INSERT INTO `motor` VALUES (7, 'Honda', 'BLADE 125 FI ', 17640000, 4, 124.89, 'Manual', 'Manual, 4-kecepatan', 7, 106, 'Merah, Kuning', '2018-09-19 11:37:54', 1, NULL, NULL);
INSERT INTO `motor` VALUES (8, 'Honda', 'BLADE FI REPSOL', 18040000, 4, 124.89, 'Manual', 'Manual, 4-kecepatan', 7, 106, 'Orange', '2018-09-19 11:37:54', 1, NULL, NULL);
INSERT INTO `motor` VALUES (9, 'Honda', 'REVO FIT FI', 14520000, 4, 109.17, 'Manual', 'Manual, 4-kecepatan', 7, 98, 'Hitam', '2018-09-19 11:37:54', 1, NULL, NULL);
INSERT INTO `motor` VALUES (10, 'Honda', 'REVO SP FI', 15220000, 4, 109.17, 'Manual', 'Manual, 4-kecepatan', 7, 99, 'Biru, Hitam', '2018-09-19 11:37:54', 1, NULL, NULL);
INSERT INTO `motor` VALUES (11, 'Honda', 'REVO CW FI', 16120000, 4, 109.17, 'Manual', 'Manual, 4-kecepatan', 7, 99, 'Hijau, Merah', '2018-09-19 11:37:54', 1, NULL, NULL);
INSERT INTO `motor` VALUES (12, 'Honda', 'All New Beat Sporty CW', 16130000, 4, 110, 'Matic', 'Otomatis, V-matic', 11.2, 92, 'Hitam, Putih', '2018-09-19 11:38:39', 1, NULL, NULL);
INSERT INTO `motor` VALUES (13, 'Honda', 'All New Beat Sporty CBS', 16330000, 4, 110, 'Matic', 'Otomatis, V-matic', 11.2, 93, 'Merah, Hitam, Biru', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (14, 'Honda', 'All New Beat Sporty CBS ISS', 16810000, 4, 110, 'Matic', 'Otomatis, V-matic', 11.2, 93, 'Pink, Biru, Merah', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (15, 'Honda', 'BEAT STREET CBS', 16810000, 4, 108.2, 'Matic', 'Otomatis, V-matic', 11.2, 94, 'Hitam, Putih', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (16, 'Honda', 'New Beat Pop Esp CW Pixel/Comic', 15690000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 11.2, 94, 'Putih, hitam', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (17, 'Honda', 'New Beat Pop Esp CBS Pixel/Comic', 15890000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 11.2, 95, 'Biru, Merah', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (18, 'Honda', 'New Beat Pop Esp CBS ISS Pixel/Comic', 16290000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 11.2, 95, 'Pink', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (19, 'Honda', 'SPACY HI FI', 15310000, 5.5, 108, 'Matic', 'Otomatis, V-matic', 18, 99, 'Hitam, Putih, Biru', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (20, 'Honda', 'Vario 110 Esp CBS', 17420000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 13, 109, 'Putih, Hitam, Merah', '2018-09-19 11:38:40', 1, '2019-02-15 06:41:12', NULL);
INSERT INTO `motor` VALUES (21, 'Honda', 'Vario 110 Esp CBS (variasi warna doff)', 17520000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 13, 109, 'Abu-abu', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (22, 'Honda', 'Vario 110 Esp CBS ISS', 18210000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 13, 109, 'Putih, Hitam, Merah', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (23, 'Honda', 'Vario 110 Esp CBS ISS (variasi warna doff)', 18310000, 3.7, 108.2, 'Matic', 'Otomatis, V-matic', 13, 109, 'Abu-abu', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (24, 'Honda', 'New Vario 125 FI CBS', 19060000, 5.5, 124.8, 'Matic', 'Otomatis, V-matic', 18, 109, 'Hitam, Putih', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (25, 'Honda', 'New Vario 125 FI CBS ISS', 19530000, 5.5, 124.8, 'Matic', 'Otomatis, V-matic', 18, 109, 'Hitam,Merah,Putih', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (26, 'Honda', 'Vario 150 Sporty', 21840000, 5.5, 149.3, 'Matic', 'Otomatis, V-matic', 18, 109, 'Putih, Merah, Hitam', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (27, 'Honda', 'Vario 150 Exclusive', 21950000, 5.5, 149.3, 'Matic', 'Otomatis, V-matic', 18, 109, 'Hitam, Coklat', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (28, 'Honda', 'Vario 150 Exclusive (Acc)', 22000000, 5.5, 149.3, 'Matic', 'Otomatis, V-matic', 18, 109, 'Putih, Biru', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (29, 'Honda', 'PCX', 42570000, 8, 149.3, 'Matic', 'Otomatis, V-matic', 25, 131, 'Hitam, Putih, Merah', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (30, 'Honda', 'ALL NEW SCOOPY STYLISH LP', 18705000, 4, 110, 'Matic', 'Otomatis, V-matic', 15.4, 96, 'Coklat, Hitam', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (31, 'Honda', 'ALL NEW SCOOPY SPORTY  LP', 18705000, 4, 110, 'Matic', 'Otomatis, V-matic', 15.4, 96, 'Hitam, Merah, Putih', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (32, 'Honda', 'ALL NEW SCOOPY PLAYFULL  LP', 18705000, 4, 110, 'Matic', 'Otomatis, V-matic', 15.4, 96, 'Biru, Hijau', '2018-09-19 11:38:40', 1, NULL, NULL);
INSERT INTO `motor` VALUES (33, 'Honda', 'PRO FI LP', 22845000, 12.3, 150, 'Manual', 'Manual, 5-kecepatan', 0, 129, 'Merah, Hitam, Biru', '2018-09-19 11:38:07', 1, NULL, NULL);
INSERT INTO `motor` VALUES (34, 'Honda', 'VERZA 150 SP LP', 19575000, 12.3, 150, 'Manual', 'Manual, 5-kecepatan', 0, 129, 'Merah, Hitam', '2018-09-19 11:38:07', 1, NULL, NULL);
INSERT INTO `motor` VALUES (35, 'Honda', 'VERZA 150 CW LP', 20425000, 12.3, 150, 'Manual', 'Manual, 5-kecepatan', 0, 129, 'Abu-abu, Biru', '2018-09-19 11:38:07', 1, NULL, NULL);
INSERT INTO `motor` VALUES (36, 'Honda', 'NEW CB150R LP', 26315000, 12, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 136, 'Merah, Putih, Hitam', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (37, 'Honda', 'NEW CB150R SPECIAL EDITION LP', 27415000, 12, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 136, 'Hitam', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (38, 'Honda', 'CBR 250 RR STD (grey&black) LP', 63895000, 14.5, 249.7, 'Manual', 'Manual, 6-kecepatan', 0, 168, 'Hitam', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (39, 'Honda', 'CBR 250 RR STD (merah) LP', 64495000, 14.5, 249.7, 'Manual', 'Manual, 6-kecepatan', 0, 168, 'merah', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (40, 'Honda', 'CBR 250 RR ABS (grey&black) LP', 69905000, 14.5, 249.7, 'Manual', 'Manual, 6-kecepatan', 0, 168, 'Hitam', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (41, 'Honda', 'CBR 250 RR ABS (merah) LP', 70505000, 14.5, 249.7, 'Manual', 'Manual, 6-kecepatan', 0, 168, 'merah', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (42, 'Honda', 'CBR 150 LP', 34145000, 13.2, 150, 'Manual', 'Manual, 6-kecepatan', 0, 135, 'Putih', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (43, 'Honda', 'CBR 150(red)LP', 34845000, 13.2, 150, 'Manual', 'Manual, 6-kecepatan', 0, 135, 'Merah', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (44, 'Honda', 'CBR 150(repsol)LP', 35045000, 13.2, 150, 'Manual', 'Manual, 6-kecepatan', 0, 135, 'Orange', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (45, 'Honda', 'CBR 250RR ABS Repsol Acc LP', 72755000, 13, 250, 'Manual', 'Manual, 6-kecepatan', 0, 168, 'Orange', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (46, 'Honda', 'CBR 250 RR KABUKI', 71205000, 14.5, 249.7, 'Manual', 'Manual, 6-kecepatan', 0, 168, 'Hitam', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (47, 'Honda', 'CRF250', 63359000, 10.1, 249, 'Manual', 'Manual,5-kecepatan', 0, 122, 'Merah, Abu-abu', '2018-09-19 11:38:08', 1, NULL, NULL);
INSERT INTO `motor` VALUES (48, 'Honda', 'SH150', 45015000, 7.5, 150, 'Matic', 'Otomatis, V-matic', 18, 136, 'Merah, Putih, Hitam', '2018-09-19 11:38:32', 1, NULL, NULL);
INSERT INTO `motor` VALUES (49, 'Honda', 'SONIC 150 R', 22670000, 4, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 114, 'Merah', '2018-09-19 11:38:13', 1, NULL, NULL);
INSERT INTO `motor` VALUES (50, 'Honda', 'SONIC 150 R SE', 23070000, 4, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 114, 'Hitam', '2018-09-19 11:38:13', 1, NULL, NULL);
INSERT INTO `motor` VALUES (51, 'Honda', 'SONIC 150 Repsol', 23070000, 4, 149.16, 'Manual', 'Manual, 6-kecepatan', 0, 114, 'Orange', '2018-09-19 11:38:13', 1, NULL, NULL);
INSERT INTO `motor` VALUES (52, 'Yamaha', 'MIO 125 CW', 16975000, 4.2, 125, 'Matic', 'Otomatis, V-matic', 10.1, 94, 'kuning, hitam', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (53, 'Yamaha', 'MIO Z', 17400000, 4.2, 125, 'Matic', 'Otomatis, V-matic', 10.1, 94, 'merah,putih', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (54, 'Yamaha', 'MIO S', 17525000, 4.2, 125, 'Matic', 'Otomatis, V-matic', 10.1, 94, 'biru, toska', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (55, 'Yamaha', 'FINO 125', 19150000, 4.2, 125, 'Matic', 'Otomatis, V-matic', 8.7, 98, 'orange, merah', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (56, 'Yamaha', 'FINO 125 GRANDE', 20500000, 4.2, 125, 'Matic', 'Otomatis, V-matic', 8.7, 98, 'biru', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (57, 'Yamaha', 'NEW XRIDE', 19075000, 4.2, 125, 'Matic', 'Otomatis, V-matic', 10, 98, 'merah, hijau, hitam', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (58, 'Yamaha', 'AEROX 155 VVA', 24300000, 4.6, 155, 'Matic', 'Otomatis, V-matic', 25, 116, 'kuning, merah', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (59, 'Yamaha', 'AEROX S VERSION', 28650000, 4.6, 155, 'Matic', 'Otomatis, V-matic', 25, 118, 'hitam', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (60, 'Yamaha', 'NMAX NON ABS', 27550000, 6.6, 155, 'Matic', 'Otomatis, V-matic', 23, 127, 'merah, hitam', '2018-09-19 11:38:29', 1, NULL, NULL);
INSERT INTO `motor` VALUES (61, 'Yamaha', 'NMAX ABS', 31050000, 6.6, 155, 'Matic', 'Otomatis, V-matic', 23, 127, 'putih,abu-abu', '2018-09-19 11:38:24', 1, NULL, NULL);
INSERT INTO `motor` VALUES (62, 'Yamaha', 'MX KING', 23275000, 4.2, 150, 'Manual', 'Manual, 6-kecepatan', 0, 116, 'merah, hitam, putih', '2018-09-19 11:38:20', 1, NULL, NULL);
INSERT INTO `motor` VALUES (63, 'Yamaha', 'N-VIXION', 27275000, 12, 149.8, 'Manual', 'Manual, 5-kecepatan', 0, 132, 'abu-abu', '2018-09-19 11:38:20', 1, NULL, NULL);
INSERT INTO `motor` VALUES (64, 'Yamaha', 'N-VIXION GP', 27975000, 12, 149.8, 'Manual', 'Manual, 5-kecepatan', 0, 131, 'hitam', '2018-09-19 11:38:20', 1, NULL, NULL);
INSERT INTO `motor` VALUES (65, 'Yamaha', 'N-VIXION R', 30205000, 11, 155, 'Manual', 'Manual, 5-kecepatan', 0, 131, 'merah, biru', '2018-09-19 11:38:20', 1, NULL, NULL);
INSERT INTO `motor` VALUES (66, 'Yamaha', 'R15 VVA 155', 36850000, 11, 155, 'Manual', 'Manual, 6-kecepatan', 0, 137, 'biru,merah,hitam', '2018-09-19 11:38:20', 1, NULL, NULL);

-- ----------------------------
-- Table structure for rule
-- ----------------------------
DROP TABLE IF EXISTS `rule`;
CREATE TABLE `rule`  (
  `id_rule` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `harga` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tangki` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kecepatan` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bagasi` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `berat` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nilai` int(3) NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_rule`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 244 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of rule
-- ----------------------------
INSERT INTO `rule` VALUES (1, 'min', 'min', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (2, 'min', 'min', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (3, 'min', 'min', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (4, 'min', 'min', 'min', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (5, 'min', 'min', 'min', 'mid', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (6, 'min', 'min', 'min', 'mid', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (7, 'min', 'min', 'min', 'max', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (8, 'min', 'min', 'min', 'max', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (9, 'min', 'min', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (10, 'min', 'min', 'mid', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (11, 'min', 'min', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (12, 'min', 'min', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (13, 'min', 'min', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (14, 'min', 'min', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (15, 'min', 'min', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (16, 'min', 'min', 'mid', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (17, 'min', 'min', 'mid', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (18, 'min', 'min', 'mid', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (19, 'min', 'min', 'max', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (20, 'min', 'min', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (21, 'min', 'min', 'max', 'min', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (22, 'min', 'min', 'max', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (23, 'min', 'min', 'max', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (24, 'min', 'min', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (25, 'min', 'min', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (26, 'min', 'min', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (27, 'min', 'min', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (28, 'min', 'mid', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (29, 'min', 'mid', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (30, 'min', 'mid', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (31, 'min', 'mid', 'min', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (32, 'min', 'mid', 'min', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (33, 'min', 'mid', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (34, 'min', 'mid', 'min', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (35, 'min', 'mid', 'min', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (36, 'min', 'mid', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (37, 'min', 'mid', 'mid', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (38, 'min', 'mid', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (39, 'min', 'mid', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (40, 'min', 'mid', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (41, 'min', 'mid', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (42, 'min', 'mid', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (43, 'min', 'mid', 'mid', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (44, 'min', 'mid', 'mid', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (45, 'min', 'mid', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (46, 'min', 'mid', 'max', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (47, 'min', 'mid', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (48, 'min', 'mid', 'max', 'min', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (49, 'min', 'mid', 'max', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (50, 'min', 'mid', 'max', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (51, 'min', 'mid', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (52, 'min', 'mid', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (53, 'min', 'mid', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (54, 'min', 'mid', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (55, 'min', 'max', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (56, 'min', 'max', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (57, 'min', 'max', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (58, 'min', 'max', 'min', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (59, 'min', 'max', 'min', 'mid', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (60, 'min', 'max', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (61, 'min', 'max', 'min', 'max', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (62, 'min', 'max', 'min', 'max', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (63, 'min', 'max', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (64, 'min', 'max', 'mid', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (65, 'min', 'max', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (66, 'min', 'max', 'mid', 'min', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (67, 'min', 'max', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (68, 'min', 'max', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (69, 'min', 'max', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (70, 'min', 'max', 'mid', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (71, 'min', 'max', 'mid', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (72, 'min', 'max', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (73, 'min', 'max', 'max', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (74, 'min', 'max', 'max', 'min', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (75, 'min', 'max', 'max', 'min', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (76, 'min', 'max', 'max', 'mid', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (77, 'min', 'max', 'max', 'mid', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (78, 'min', 'max', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (79, 'min', 'max', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (80, 'min', 'max', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (81, 'min', 'max', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (82, 'mid', 'min', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (83, 'mid', 'min', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (84, 'mid', 'min', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (85, 'mid', 'min', 'min', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (86, 'mid', 'min', 'min', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (87, 'mid', 'min', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (88, 'mid', 'min', 'min', 'max', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (89, 'mid', 'min', 'min', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (90, 'mid', 'min', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (91, 'mid', 'min', 'mid', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (92, 'mid', 'min', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (93, 'mid', 'min', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (94, 'mid', 'min', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (95, 'mid', 'min', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (96, 'mid', 'min', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (97, 'mid', 'min', 'mid', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (98, 'mid', 'min', 'mid', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (99, 'mid', 'min', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (100, 'mid', 'min', 'max', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (101, 'mid', 'min', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (102, 'mid', 'min', 'max', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (103, 'mid', 'min', 'max', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (104, 'mid', 'min', 'max', 'mid', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (105, 'mid', 'min', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (106, 'mid', 'min', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (107, 'mid', 'min', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (108, 'mid', 'min', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (109, 'mid', 'mid', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (110, 'mid', 'mid', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (111, 'mid', 'mid', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (112, 'mid', 'mid', 'min', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (113, 'mid', 'mid', 'min', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (114, 'mid', 'mid', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (115, 'mid', 'mid', 'min', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (116, 'mid', 'mid', 'min', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (117, 'mid', 'mid', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (118, 'mid', 'mid', 'mid', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (119, 'mid', 'mid', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (120, 'mid', 'mid', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (121, 'mid', 'mid', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (122, 'mid', 'mid', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (123, 'mid', 'mid', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (124, 'mid', 'mid', 'mid', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (125, 'mid', 'mid', 'mid', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (126, 'mid', 'mid', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (127, 'mid', 'mid', 'max', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (128, 'mid', 'mid', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (129, 'mid', 'mid', 'max', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (130, 'mid', 'mid', 'max', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (131, 'mid', 'mid', 'max', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (132, 'mid', 'mid', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (133, 'mid', 'mid', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (134, 'mid', 'mid', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (135, 'mid', 'mid', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (136, 'mid', 'max', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (137, 'mid', 'max', 'min', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (138, 'mid', 'max', 'min', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (139, 'mid', 'max', 'min', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (140, 'mid', 'max', 'min', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (141, 'mid', 'max', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (142, 'mid', 'max', 'min', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (143, 'mid', 'max', 'min', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (144, 'mid', 'max', 'min', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (145, 'mid', 'max', 'mid', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (146, 'mid', 'max', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (147, 'mid', 'max', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (148, 'mid', 'max', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (149, 'mid', 'max', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (150, 'mid', 'max', 'mid', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (151, 'mid', 'max', 'mid', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (152, 'mid', 'max', 'mid', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (153, 'mid', 'max', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (154, 'mid', 'max', 'max', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (155, 'mid', 'max', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (156, 'mid', 'max', 'max', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (157, 'mid', 'max', 'max', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (158, 'mid', 'max', 'max', 'mid', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (159, 'mid', 'max', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (160, 'mid', 'max', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (161, 'mid', 'max', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (162, 'mid', 'max', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (163, 'max', 'min', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (164, 'max', 'min', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (165, 'max', 'min', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (166, 'max', 'min', 'min', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (167, 'max', 'min', 'min', 'mid', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (168, 'max', 'min', 'min', 'mid', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (169, 'max', 'min', 'min', 'max', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (170, 'max', 'min', 'min', 'max', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (171, 'max', 'min', 'min', 'max', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (172, 'max', 'min', 'mid', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (173, 'max', 'min', 'mid', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (174, 'max', 'min', 'mid', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (175, 'max', 'min', 'mid', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (176, 'max', 'min', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (177, 'max', 'min', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (178, 'max', 'min', 'mid', 'max', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (179, 'max', 'min', 'mid', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (180, 'max', 'min', 'mid', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (181, 'max', 'min', 'max', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (182, 'max', 'min', 'max', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (183, 'max', 'min', 'max', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (184, 'max', 'min', 'max', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (185, 'max', 'min', 'max', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (186, 'max', 'min', 'max', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (187, 'max', 'min', 'max', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (188, 'max', 'min', 'max', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (189, 'max', 'min', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (190, 'max', 'mid', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (191, 'max', 'mid', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (192, 'max', 'mid', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (193, 'max', 'mid', 'min', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (194, 'max', 'mid', 'min', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (195, 'max', 'mid', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (196, 'max', 'mid', 'min', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (197, 'max', 'mid', 'min', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (198, 'max', 'mid', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (199, 'max', 'mid', 'mid', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (200, 'max', 'mid', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (201, 'max', 'mid', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (202, 'max', 'mid', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (203, 'max', 'mid', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (204, 'max', 'mid', 'mid', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (205, 'max', 'mid', 'mid', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (206, 'max', 'mid', 'mid', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (207, 'max', 'mid', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (208, 'max', 'mid', 'max', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (209, 'max', 'mid', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (210, 'max', 'mid', 'max', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (211, 'max', 'mid', 'max', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (212, 'max', 'mid', 'max', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (213, 'max', 'mid', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (214, 'max', 'mid', 'max', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (215, 'max', 'mid', 'max', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (216, 'max', 'mid', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (217, 'max', 'max', 'min', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (218, 'max', 'max', 'min', 'min', 'mid', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (219, 'max', 'max', 'min', 'min', 'min', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (220, 'max', 'max', 'min', 'mid', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (221, 'max', 'max', 'min', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (222, 'max', 'max', 'min', 'mid', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (223, 'max', 'max', 'min', 'max', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (224, 'max', 'max', 'min', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (225, 'max', 'max', 'min', 'max', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (226, 'max', 'max', 'mid', 'min', 'max', 1, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (227, 'max', 'max', 'mid', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (228, 'max', 'max', 'mid', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (229, 'max', 'max', 'mid', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (230, 'max', 'max', 'mid', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (231, 'max', 'max', 'mid', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (232, 'max', 'max', 'mid', 'max', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (233, 'max', 'max', 'mid', 'max', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (234, 'max', 'max', 'mid', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (235, 'max', 'max', 'max', 'min', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (236, 'max', 'max', 'max', 'min', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (237, 'max', 'max', 'max', 'min', 'min', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (238, 'max', 'max', 'max', 'mid', 'max', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (239, 'max', 'max', 'max', 'mid', 'mid', 2, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (240, 'max', 'max', 'max', 'mid', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (241, 'max', 'max', 'max', 'max', 'max', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (242, 'max', 'max', 'max', 'max', 'mid', 3, '2019-02-20 10:39:07', 1, NULL, NULL);
INSERT INTO `rule` VALUES (243, 'max', 'max', 'max', 'max', 'min', 3, '2019-02-20 10:39:07', 1, NULL, NULL);

-- ----------------------------
-- Table structure for variabel
-- ----------------------------
DROP TABLE IF EXISTS `variabel`;
CREATE TABLE `variabel`  (
  `id_variabel` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `variabel` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `min` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `max` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tabel` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `field` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `updated_by` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_variabel`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of variabel
-- ----------------------------
INSERT INTO `variabel` VALUES (1, 'Harga', '24000000:48000000', '48000000:72000000', 'motor', 'harga', '2019-02-16 04:32:27', 1, '2019-02-17 02:41:15', 1);
INSERT INTO `variabel` VALUES (2, 'Kapasitas Tangki', '4:9', '9:14.5', 'motor', 'tangki', '2019-02-17 02:42:16', 1, NULL, NULL);
INSERT INTO `variabel` VALUES (3, 'Kecepatan Mesin', '83:166', '166:250', 'motor', 'kecepatan', '2019-02-17 02:43:08', 1, NULL, NULL);
INSERT INTO `variabel` VALUES (4, 'Kapasitas Bagasi', '8.3:16.6', '16.6:25', 'motor', 'bagasi', '2019-02-17 02:44:06', 1, NULL, NULL);
INSERT INTO `variabel` VALUES (5, 'Berat', '56:112', '112:168', 'motor', 'berat', '2019-02-17 02:44:59', 1, NULL, NULL);

-- ----------------------------
-- View structure for vw_log_pengunjung
-- ----------------------------
DROP VIEW IF EXISTS `vw_log_pengunjung`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_log_pengunjung` AS SELECT l.id_log, l.metode, l.nilai, l.urutan, l.exec_time, l.sesi, m.merek, m.tipe, CONCAT(u.first_name,' | ',u.email) as pengguna FROM (log_rek l INNER JOIN motor m ON l.motor_id = m.id_motor) INNER JOIN auth_users u ON l.created_by = u.id ;

-- ----------------------------
-- View structure for vw_pengunjung
-- ----------------------------
DROP VIEW IF EXISTS `vw_pengunjung`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_pengunjung` AS SELECT l.id_log, l.metode, l.nilai, l.urutan, l.exec_time, l.sesi, l.created_at, CONCAT(a.first_name,' | ',a.email) as pengguna FROM log_rek l INNER JOIN auth_users a ON l.created_by = a.id GROUP BY sesi ;

SET FOREIGN_KEY_CHECKS = 1;
