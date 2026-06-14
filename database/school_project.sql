-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2025 at 06:21 AM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `actionable_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_id` int UNSIGNED NOT NULL,
  `action_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `actionable_type`, `actionable_id`, `action_name`, `admin_id`, `created_at`) VALUES
(1, 'App\\Models\\Product', 1, 'CREATED', 1, '2025-03-18 11:28:00'),
(2, 'App\\Models\\Customer', 1, 'CREATED', 1, '2025-03-18 11:28:48'),
(3, 'App\\Models\\Supplier', 1, 'CREATED', 1, '2025-03-18 12:13:15'),
(4, 'App\\Models\\Purchase', 1, 'CREATED', 1, '2025-03-18 12:14:24'),
(5, 'App\\Models\\Sale', 1, 'CREATED', 1, '2025-03-18 12:17:42'),
(6, 'App\\Models\\Product', 1, 'UPDATED', 1, '2025-03-18 20:45:35'),
(7, 'App\\Models\\Customer', 1, 'CREATED', 1, '2025-03-20 04:37:11'),
(8, 'App\\Models\\Product', 15, 'CREATED', 1, '2025-03-22 14:18:51'),
(9, 'App\\Models\\Customer', 2, 'CREATED', 1, '2025-03-30 13:16:15'),
(10, 'App\\Models\\Customer', 2, 'UPDATED', 1, '2025-03-30 13:24:20'),
(11, 'App\\Models\\Customer', 2, 'UPDATED', 1, '2025-03-30 13:28:02'),
(12, 'App\\Models\\Customer', 2, 'UPDATED', 1, '2025-03-30 13:28:16'),
(13, 'App\\Models\\Customer', 2, 'UPDATED', 1, '2025-03-30 13:28:30'),
(14, 'App\\Models\\Customer', 2, 'UPDATED', 1, '2025-03-30 13:47:59'),
(15, 'App\\Models\\Customer', 2, 'UPDATED', 1, '2025-03-30 13:49:09'),
(16, 'App\\Models\\Customer', 3, 'CREATED', 1, '2025-03-30 13:54:29'),
(17, 'App\\Models\\Customer', 4, 'CREATED', 6, '2025-04-01 17:55:22'),
(18, 'App\\Models\\Customer', 5, 'CREATED', 6, '2025-04-13 10:43:09'),
(19, 'App\\Models\\Supplier', 2, 'CREATED', 6, '2025-05-02 05:38:18'),
(20, 'App\\Models\\Employe', 3, 'UPDATED', 6, '2025-05-02 05:50:00'),
(21, 'App\\Models\\Customer', 6, 'CREATED', 6, '2025-05-31 13:23:17'),
(22, 'App\\Models\\Customer', 7, 'CREATED', 6, '2025-05-31 13:28:29'),
(23, 'App\\Models\\Customer', 8, 'CREATED', 6, '2025-05-31 13:30:53'),
(24, 'App\\Models\\Customer', 7, 'UPDATED', 6, '2025-05-31 13:43:02'),
(25, 'App\\Models\\Customer', 7, 'UPDATED', 6, '2025-05-31 13:52:11'),
(26, 'App\\Models\\Customer', 7, 'UPDATED', 6, '2025-05-31 13:52:38'),
(27, 'App\\Models\\Customer', 7, 'UPDATED', 6, '2025-05-31 13:57:00'),
(28, 'App\\Models\\Customer', 7, 'UPDATED', 6, '2025-05-31 13:59:05'),
(29, 'App\\Models\\Employe', 4, 'CREATED', 1, '2025-06-21 15:44:33'),
(30, 'App\\Models\\Employe', 4, 'UPDATED', 1, '2025-06-21 15:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 => Enable,\r\nDisabled => 0',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partner` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addresh` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fields` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role_id`, `name`, `email`, `mobile`, `username`, `image`, `password`, `status`, `remember_token`, `profile`, `partner`, `phone`, `addresh`, `code`, `fields`, `created_at`, `updated_at`) VALUES
(1, 0, 'Super Admin', 'admin@site.com', NULL, 'admin', '668faec6ec6401720692422.png', '$2y$12$Ygqtxc.TI.DKXMhDhn.ivOWau.8YEl0lo7wVJozldpMHXNZhdD5mC', 1, 'KXfkKEW2vkEQ3Z68z6HOH5IcmN7YTxZYdgNtLz1YQJh7HT7d6GzYqptr4kGT', NULL, NULL, NULL, NULL, NULL, 'student_name,profile,father_name,father_image,mother_name,mother_image,guardian_image,dob,mobile,address,class,section,session,adm_no,studen_signature,employe_signature,medium,bus,blood_group,roll_no,email_id,designation,husband_name,emp_id,emp_name,blank_1,blank_2,created_at', NULL, '2025-03-18 08:41:32'),
(8, 2, 'svp school', 'svp@gmail.com', '8767986756', 'svpschool', '6857c728f2bd91750583080.jpg', '$2y$12$MAQGoM8nJAVSjckocM1YrOWs0h6.j0LEhu7MSStelGgex//8xwB0O', 1, NULL, NULL, NULL, NULL, 'palsana', 'SVP', 'student_name,profile,father_name,father_image,mother_name,mother_image,guardian_image,class,studen_signature,employe_signature,created_at', '2025-06-21 08:44:30', '2025-06-24 17:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
CREATE TABLE IF NOT EXISTS `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

DROP TABLE IF EXISTS `admin_password_resets`;
CREATE TABLE IF NOT EXISTS `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`id`, `email`, `token`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin@site.com', '774522', 0, '2024-07-11 04:22:15', NULL),
(2, 'admin@site.com', '994519', 0, '2025-03-18 08:39:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

DROP TABLE IF EXISTS `extensions`;
CREATE TABLE IF NOT EXISTS `extensions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"------------\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2024-05-08 03:23:13'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2025-04-19 06:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
CREATE TABLE IF NOT EXISTS `general_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `site_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `active_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `available_version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `active_template`, `sms_template`, `sms_from`, `mail_config`, `sms_config`, `global_shortcodes`, `en`, `sn`, `system_customized`, `paginate_number`, `currency_format`, `available_version`, `created_at`, `updated_at`) VALUES
(1, 'Shree Ram id card Palsana', 'INR', '₹', 'dileepsaini029@gmail.com', 'Preence', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<!--[if !mso]><!-->\r\n<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />\r\n<!--<![endif]-->\r\n<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />\r\n<title></title>\r\n<style type=\"text/css\">\r\n  .ReadMsgBody {\r\n    width: 100%;\r\n    background-color: #ffffff;\r\n  }\r\n  .ExternalClass {\r\n    width: 100%;\r\n    background-color: #ffffff;\r\n  }\r\n  .ExternalClass,\r\n  .ExternalClass p,\r\n  .ExternalClass span,\r\n  .ExternalClass font,\r\n  .ExternalClass td,\r\n  .ExternalClass div {\r\n    line-height: 100%;\r\n  }\r\n  html {\r\n    width: 100%;\r\n  }\r\n  body {\r\n    -webkit-text-size-adjust: none;\r\n    -ms-text-size-adjust: none;\r\n    margin: 0;\r\n    padding: 0;\r\n  }\r\n  table {\r\n    border-spacing: 0;\r\n    table-layout: fixed;\r\n    margin: 0 auto;\r\n    border-collapse: collapse;\r\n  }\r\n  table table table {\r\n    table-layout: auto;\r\n  }\r\n  .yshortcuts a {\r\n    border-bottom: none !important;\r\n  }\r\n  img:hover {\r\n    opacity: 0.9 !important;\r\n  }\r\n  a {\r\n    color: #0087ff;\r\n    text-decoration: none;\r\n  }\r\n  .textbutton a {\r\n    font-family: \"open sans\", arial, sans-serif !important;\r\n  }\r\n  .btn-link a {\r\n    color: #ffffff !important;\r\n  }\r\n\r\n  @media only screen and (max-width: 480px) {\r\n    body {\r\n      width: auto !important;\r\n    }\r\n    *[class=\"table-inner\"] {\r\n      width: 90% !important;\r\n      text-align: center !important;\r\n    }\r\n    *[class=\"table-full\"] {\r\n      width: 100% !important;\r\n      text-align: center !important;\r\n    }\r\n    /* image */\r\n    img[class=\"img1\"] {\r\n      width: 100% !important;\r\n      height: auto !important;\r\n    }\r\n  }\r\n</style>\r\n\r\n<table\r\n  bgcolor=\"#414a51\"\r\n  width=\"100%\"\r\n  border=\"0\"\r\n  align=\"center\"\r\n  cellpadding=\"0\"\r\n  cellspacing=\"0\"\r\n>\r\n  <tbody>\r\n    <tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td\r\n        align=\"center\"\r\n        style=\"text-align: center; vertical-align: top; font-size: 0\"\r\n      >\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody>\r\n            <tr>\r\n              <td align=\"center\" width=\"600\">\r\n                <!--header-->\r\n                <table\r\n                  class=\"table-inner\"\r\n                  width=\"95%\"\r\n                  border=\"0\"\r\n                  align=\"center\"\r\n                  cellpadding=\"0\"\r\n                  cellspacing=\"0\"\r\n                >\r\n                  <tbody>\r\n                    <tr>\r\n                      <td\r\n                        bgcolor=\"#0087ff\"\r\n                        style=\"\r\n                          border-top-left-radius: 6px;\r\n                          border-top-right-radius: 6px;\r\n                          text-align: center;\r\n                          vertical-align: top;\r\n                          font-size: 0;\r\n                        \"\r\n                        align=\"center\"\r\n                      >\r\n                        <table\r\n                          width=\"90%\"\r\n                          border=\"0\"\r\n                          align=\"center\"\r\n                          cellpadding=\"0\"\r\n                          cellspacing=\"0\"\r\n                        >\r\n                          <tbody>\r\n                            <tr>\r\n                              <td height=\"20\"></td>\r\n                            </tr>\r\n                            <tr>\r\n                              <td\r\n                                align=\"center\"\r\n                                style=\"\r\n                                  font-family: \'Open sans\', Arial, sans-serif;\r\n                                  color: #ffffff;\r\n                                  font-size: 16px;\r\n                                  font-weight: bold;\r\n                                \"\r\n                              >\r\n                                This is a System Generated Email\r\n                              </td>\r\n                            </tr>\r\n                            <tr>\r\n                              <td height=\"20\"></td>\r\n                            </tr>\r\n                          </tbody>\r\n                        </table>\r\n                      </td>\r\n                    </tr>\r\n                  </tbody>\r\n                </table>\r\n                <!--end header-->\r\n                <table\r\n                  class=\"table-inner\"\r\n                  width=\"95%\"\r\n                  border=\"0\"\r\n                  cellspacing=\"0\"\r\n                  cellpadding=\"0\"\r\n                >\r\n                  <tbody>\r\n                    <tr>\r\n                      <td\r\n                        bgcolor=\"#FFFFFF\"\r\n                        align=\"center\"\r\n                        style=\"\r\n                          text-align: center;\r\n                          vertical-align: top;\r\n                          font-size: 0;\r\n                        \"\r\n                      >\r\n                        <table\r\n                          align=\"center\"\r\n                          width=\"90%\"\r\n                          border=\"0\"\r\n                          cellspacing=\"0\"\r\n                          cellpadding=\"0\"\r\n                        >\r\n                          <tbody>\r\n                            <tr>\r\n                              <td height=\"35\"></td>\r\n                            </tr>\r\n                            <!--logo-->\r\n                            <tr>\r\n                              <td\r\n                                align=\"center\"\r\n                                style=\"vertical-align: top; font-size: 0\"\r\n                              >\r\n                                <a href=\"#\">\r\n                                  <img\r\n                                  width=\"200px\"\r\n                                    style=\"\r\n                                      display: block;\r\n                                      line-height: 0px;\r\n                                      font-size: 0px;\r\n                                      border: 0px;\r\n                                    \"\r\n                                    src=\"https://orderpresence.in/assets/logo/LOGO 1.png\"\r\n                                    alt=\"img\"\r\n                                  />\r\n                                </a>\r\n                              </td>\r\n                            </tr>\r\n                            <!--end logo-->\r\n\r\n                            <!--headline-->\r\n                            <tr></tr>\r\n                            <!--end headline-->\r\n                            <tr>\r\n                              <td\r\n                                align=\"center\"\r\n                                style=\"\r\n                                  text-align: center;\r\n                                  vertical-align: top;\r\n                                  font-size: 0;\r\n                                \"\r\n                              >\r\n                                <table\r\n                                  width=\"40\"\r\n                                  border=\"0\"\r\n                                  align=\"center\"\r\n                                  cellpadding=\"0\"\r\n                                  cellspacing=\"0\"\r\n                                >\r\n                                  <tbody></tbody>\r\n                                </table>\r\n                              </td>\r\n                            </tr>\r\n                            <tr>\r\n                              <td height=\"20\"></td>\r\n                            </tr>\r\n                            <!--content-->\r\n                            <tr>\r\n                              <td\r\n                                align=\"left\"\r\n                                style=\"\r\n                                  font-family: \'Open sans\', Arial, sans-serif;\r\n                                  color: #7f8c8d;\r\n                                  font-size: 16px;\r\n                                  line-height: 28px;\r\n                                \"\r\n                              >\r\n                                {{message}}\r\n                              </td>\r\n                            </tr>\r\n                            <!--end content-->\r\n                            <tr>\r\n                              <td height=\"40\"></td>\r\n                            </tr>\r\n                          </tbody>\r\n                        </table>\r\n                      </td>\r\n                    </tr>\r\n                    <tr>\r\n                      <td\r\n                        height=\"45\"\r\n                        align=\"center\"\r\n                        bgcolor=\"#f4f4f4\"\r\n                        style=\"\r\n                          border-bottom-left-radius: 6px;\r\n                          border-bottom-right-radius: 6px;\r\n                        \"\r\n                      >\r\n                        <table\r\n                          align=\"center\"\r\n                          width=\"90%\"\r\n                          border=\"0\"\r\n                          cellspacing=\"0\"\r\n                          cellpadding=\"0\"\r\n                        >\r\n                          <tbody>\r\n                            <tr>\r\n                              <td height=\"10\"></td>\r\n                            </tr>\r\n                            <!--preference-->\r\n                            <tr>\r\n                              <td\r\n                                class=\"preference-link\"\r\n                                align=\"center\"\r\n                                style=\"\r\n                                  font-family: \'Open sans\', Arial, sans-serif;\r\n                                  color: #95a5a6;\r\n                                  font-size: 14px;\r\n                                \"\r\n                              >\r\n                                © 2025 <a href=\"#\">{{site_name}}</a>&nbsp;. All\r\n                                Rights Reserved.\r\n                              </td>\r\n                            </tr>\r\n                            <!--end preference-->\r\n                            <tr>\r\n                              <td height=\"10\"></td>\r\n                            </tr>\r\n                          </tbody>\r\n                        </table>\r\n                      </td>\r\n                    </tr>\r\n                  </tbody>\r\n                </table>\r\n              </td>\r\n            </tr>\r\n          </tbody>\r\n        </table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody>\r\n</table>', 'basic', '{{message}}', 'ViserAdmin', '{\"name\":\"php\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 1, 1, 0, 20, 1, '2.0', NULL, '2025-06-22 07:26:57');

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

DROP TABLE IF EXISTS `notification_logs`;
CREATE TABLE IF NOT EXISTS `notification_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

DROP TABLE IF EXISTS `notification_templates`;
CREATE TABLE IF NOT EXISTS `notification_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `created_at`, `updated_at`) VALUES
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, NULL, NULL, 0, NULL, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, NULL, NULL, 1, NULL, '2021-11-03 12:00:00', '2022-04-05 03:46:35'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, '2019-09-14 13:14:22', '2021-11-04 09:38:55'),
(18, 'ADD_STAFF', 'Staff Add', 'Appointed as a staff', 'Hello,&nbsp;{{ name }},<br><br>Your {{ site_name }}\r\nlogin credential is username: {{username}} password: {{password}}', 'Your {{ site_name }} login credential  is  username: {{username}} password: {{password}}', '{\"name\":\"full Name\",\"username\":\"Access his/her guard username\",\"password\":\"Access his/her guard password\"}', 1, NULL, NULL, 1, NULL, '2019-09-14 13:14:22', '2022-10-17 10:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group`, `code`) VALUES
(1, 'Dashboard', 'AdminController', 'admin.dashboard'),
(5, 'Banned', 'AdminController', 'admin.banned'),
(13, 'Download Attachment', 'AdminController', 'admin.download.attachment'),
(18, 'Roles Index', 'RolesController', 'admin.roles.index'),
(19, 'Roles Add', 'RolesController', 'admin.roles.add'),
(20, 'Roles Edit', 'RolesController', 'admin.roles.edit'),
(21, 'Roles Save', 'RolesController', 'admin.roles.save'),
(180, 'Setting System', 'GeneralSettingController', 'admin.setting.system'),
(181, 'Setting General', 'GeneralSettingController', 'admin.setting.general'),
(182, 'Setting General Update', 'GeneralSettingController', 'admin.setting.general.update'),
(183, 'Setting System Configuration', 'GeneralSettingController', 'admin.setting.system.configuration'),
(184, 'Setting System Configuration Update', 'GeneralSettingController', 'admin.setting.system.configuration.update'),
(185, 'Setting Logo Icon', 'GeneralSettingController', 'admin.setting.logo.icon'),
(186, 'Setting Logo Icon', 'GeneralSettingController', 'admin.setting.logo.icon'),
(200, 'System Info', 'SystemController', 'admin.system.info'),
(201, 'System Server Info', 'SystemController', 'admin.system.server.info'),
(202, 'System Optimize', 'SystemController', 'admin.system.optimize'),
(203, 'System Optimize Clear', 'SystemController', 'admin.system.optimize.clear'),
(204, 'System Update', 'SystemController', 'admin.system.update'),
(205, 'System Update Process', 'SystemController', 'admin.system.update.process'),
(206, 'System Update Log', 'SystemController', 'admin.system.update.log'),
(249, 'Extensions Index', 'ExtensionController', 'admin.extensions.index'),
(250, 'Extensions Update', 'ExtensionController', 'admin.extensions.update'),
(251, 'Extensions Status', 'ExtensionController', 'admin.extensions.status'),
(257, 'Request Report', 'AdminController', 'admin.request.report'),
(258, 'Request Report Store', 'AdminController', 'admin.request.report.store'),
(295, 'Student Index', 'EmployeController', 'admin.student.index'),
(296, 'Student Store', 'EmployeController', 'admin.student.store'),
(298, 'Student Csv', 'EmployeController', 'admin.student.csv'),
(299, 'Student Import', 'EmployeController', 'admin.student.import'),
(300, 'Student ImportAll', 'EmployeController', 'admin.student.importAll'),
(301, 'Student GetSchool', 'EmployeController', 'admin.student.getSchool'),
(302, 'School Index', 'StaffController', 'admin.school.index'),
(303, 'School Save', 'StaffController', 'admin.school.save'),
(304, 'School Status', 'StaffController', 'admin.school.status'),
(305, 'School Login', 'StaffController', 'admin.school.login'),
(306, 'Student Upload', 'EmployeController', 'admin.student.upload'),
(307, 'Student Edit', 'EmployeController', 'admin.student.edit'),
(308, 'Student Create', 'EmployeController', 'admin.student.create'),
(309, 'School Add', 'StaffController', 'admin.school.add'),
(310, 'School Edit', 'StaffController', 'admin.school.edit'),
(311, 'Student Delete', 'EmployeController', 'admin.student.delete'),
(312, 'Student Download', 'EmployeController', 'admin.student.download');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES
(6, 1, 1),
(113, 5, 1),
(121, 13, 1),
(140, 180, 1),
(141, 181, 1),
(142, 182, 1),
(143, 183, 1),
(144, 184, 1),
(145, 185, 1),
(146, 186, 1),
(147, 187, 1),
(148, 188, 1),
(149, 189, 1),
(150, 190, 1),
(151, 191, 1),
(152, 192, 1),
(153, 193, 1),
(154, 194, 1),
(155, 195, 1),
(156, 196, 1),
(157, 197, 1),
(158, 198, 1),
(159, 199, 1),
(160, 200, 1),
(161, 201, 1),
(162, 202, 1),
(163, 203, 1),
(164, 204, 1),
(165, 205, 1),
(166, 206, 1),
(167, 18, 1),
(168, 19, 1),
(169, 20, 1),
(170, 21, 1),
(184, 295, 2),
(185, 1, 2),
(192, 296, 2),
(197, 301, 2),
(200, 302, 2),
(204, 306, 2),
(206, 308, 2),
(207, 303, 2),
(208, 310, 2),
(209, 304, 2),
(210, 305, 2),
(212, 307, 2),
(213, 311, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2025-03-18 08:48:36', '2025-04-17 04:31:11'),
(2, 'school', '2025-03-27 05:38:51', '2025-06-21 10:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

DROP TABLE IF EXISTS `tbl_student`;
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_id` int NOT NULL,
  `student_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `father_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adm_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `medium` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `studen_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employe_signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` text COLLATE utf8mb4_unicode_ci,
  `husband_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blank_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blank_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `school_id`, `student_name`, `profile`, `email_id`, `mobile`, `address`, `father_name`, `father_image`, `mother_name`, `mother_image`, `guardian_image`, `dob`, `class`, `section`, `session`, `adm_no`, `medium`, `studen_signature`, `employe_signature`, `bus`, `blood_group`, `roll_no`, `designation`, `husband_name`, `emp_id`, `emp_name`, `blank_1`, `blank_2`, `created_at`, `updated_at`) VALUES
(1, 8, 'Indrans Kashyap', NULL, 'kiarawalla@balasubramanian.net', '3454453615', '19/363, Seth Street, Machilipatnam-376415', 'Samarth Gandhi', '', 'Gatik Bhalla', '', '', '18-09-2014', '4', 'A', '2024-2025', 'ADM001', 'https://dummyimage.com/445x509', NULL, NULL, 'BUS33', 'B-', '1', 'Helper', '', 'EMP001', 'Armaan Barad', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(2, 8, 'Renee Bhakta', NULL, 'vohraamira@yahoo.com', '6475939016', 'H.No. 47, Lalla Circle, Tiruchirappalli-393658', 'Yuvraj  Sur', '', 'Ela Balan', '', '', '15-12-2018', '4', 'C', '2024-2025', 'ADM002', 'https://dummyimage.com/126x454', NULL, NULL, 'BUS32', 'A+', '2', 'Teacher', '', 'EMP002', 'Azad Chahal', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(3, 8, 'Adah Bava', NULL, 'sana30@agarwal.com', '9.15484E+11', 'H.No. 56, Korpal Marg, Udaipur-789694', 'Amira Sandhu', '', 'Romil Bansal', '', '', '01-01-2018', '6', 'A', '2024-2025', 'ADM003', 'https://placekitten.com/63/417', NULL, NULL, 'BUS32', 'A+', '3', 'Student', 'Umang Gulati', 'EMP003', 'Madhup Saran', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(4, 8, 'Anya Khosla', NULL, 'beradiya@hotmail.com', '7692776794', '98/327, Krishnan Path, Dhule-985283', 'Adira Gaba', '', 'Manikya Mane', '', '', '20-03-2007', '2', 'A', '2024-2025', 'ADM004', 'https://placeimg.com/349/222/any', NULL, NULL, 'BUS45', 'O+', '4', 'Teacher', 'Tejas Samra', 'EMP004', 'Oorja Date', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(5, 8, 'Neelofar Virk', NULL, 'xsawhney@hotmail.com', '9.16047E+11', '47, Basak, Dindigul-686718', 'Madhav Randhawa', '', 'Rohan Dutta', '', '', '25-03-2009', '7', 'C', '2024-2025', 'ADM005', 'https://placeimg.com/224/936/any', NULL, NULL, 'BUS43', 'B+', '5', 'Student', '', 'EMP005', 'Heer Jani', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(6, 8, 'Kartik Anand', NULL, 'hbhasin@sane.com', '7629317413', 'H.No. 423, Datta Chowk, Shivpuri-838588', 'Anahita Cheema', '', 'Raghav Sem', '', '', '04-06-2018', '3', 'A', '2024-2025', 'ADM006', 'https://placekitten.com/430/427', NULL, NULL, 'BUS49', 'AB+', '6', 'Helper', 'Divit Lalla', 'EMP006', 'Tanya Lal', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(7, 8, 'Baiju Sane', NULL, 'reyansh27@contractor.biz', '1311551919', '39, Randhawa Circle, Guntur 078357', 'Advika Chowdhury', '', 'Bhavin Borde', '', '', '21-06-2011', '10', 'C', '2024-2025', 'ADM007', 'https://dummyimage.com/404x250', NULL, NULL, 'BUS35', 'O-', '7', 'Staff', 'Shlok Kashyap', 'EMP007', 'Zeeshan Sankar', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(8, 8, 'Kartik Sachdeva', NULL, 'saanvisanghvi@loyal.com', '2875108663', '36, Singhal Marg, Baranagar 149309', 'Vidur Bath', '', 'Suhana Bains', '', '', '01-02-2012', '9', 'A', '2024-2025', 'ADM008', 'https://dummyimage.com/348x880', NULL, NULL, 'BUS13', 'B+', '8', 'Teacher', '', 'EMP008', 'Eva Venkataraman', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(9, 8, 'Jayesh Yohannan', NULL, 'reneedoctor@hotmail.com', '9.10251E+11', 'H.No. 98, Saxena Street, Rajahmundry-914618', 'Neysa Sachdev', '', 'Mamooty Gill', '', '', '05-10-2015', '2', 'C', '2024-2025', 'ADM009', 'https://placeimg.com/193/1008/any', NULL, NULL, 'BUS25', 'AB-', '9', 'Staff', '', 'EMP009', 'Chirag Thakkar', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(10, 8, 'Aarush De', NULL, 'priyansh28@ghose.com', '803701363', '04, Raman Ganj, Pali 630667', 'Farhan Bahl', '', 'Vivaan Mani', '', '', '19-06-2008', '7', 'C', '2024-2025', 'ADM010', 'https://www.lorempixel.com/695/497', NULL, NULL, 'BUS3', 'AB+', '10', 'Staff', '', 'EMP010', 'Taimur Kadakia', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(11, 8, 'Rania Chaudhari', NULL, 'vedikagoswami@gmail.com', '1300974957', '96/90, Aggarwal Marg, Kakinada 147935', 'Miraan Bhasin', '', 'Myra Karan', '', '', '16-11-2014', '12', 'B', '2024-2025', 'ADM011', 'https://dummyimage.com/647x913', NULL, NULL, 'BUS27', 'B-', '11', 'Helper', '', 'EMP011', 'Zoya Balasubramanian', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(12, 8, 'Eva Thaman', NULL, 'pari10@gmail.com', '9.10917E+11', 'H.No. 574, Wagle Chowk, Tirunelveli-789596', 'Prerak Yogi', '', 'Ishita Chandran', '', '', '26-06-2019', '7', 'C', '2024-2025', 'ADM012', 'https://placekitten.com/149/829', NULL, NULL, 'BUS35', 'B+', '12', 'Helper', 'Pranay Chacko', 'EMP012', 'Hazel Vala', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(13, 8, 'Renee Bains', NULL, 'taran03@gmail.com', '9.11152E+11', '24/99, Dugal Road, Bokaro-527425', 'Sahil Majumdar', '', 'Vanya Kala', '', '', '20-11-2007', '1', 'C', '2024-2025', 'ADM013', 'https://placekitten.com/752/240', NULL, NULL, 'BUS50', 'B-', '13', 'Teacher', 'Nakul Mane', 'EMP013', 'Taran Jayaraman', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(14, 8, 'Baiju Luthra', NULL, 'darshitsarin@yahoo.com', '9.19743E+11', 'H.No. 07, Walla Road, Patna-252147', 'Mamooty Behl', '', 'Kabir Gopal', '', '', '16-08-2016', '1', 'C', '2024-2025', 'ADM014', 'https://dummyimage.com/238x20', NULL, NULL, 'BUS19', 'AB-', '14', 'Student', '', 'EMP014', 'Advik Borah', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(15, 8, 'Vidur Gara', NULL, 'hridaan66@yahoo.com', '9.11547E+11', '60/84, Sinha, Kalyan-Dombivli 588286', 'Mohanlal Chand', '', 'Madhav Sankaran', '', '', '08-07-2017', '8', 'C', '2024-2025', 'ADM015', 'https://dummyimage.com/746x803', NULL, NULL, 'BUS50', 'O-', '15', 'Staff', '', 'EMP015', 'Alisha Barad', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(16, 8, 'Indrans Bhandari', NULL, 'anaya90@gmail.com', '7622105593', 'H.No. 569, Ratta Path, Bhalswa Jahangir Pur-773917', 'Jiya Iyengar', '', 'Ivan Sandal', '', '', '06-02-2012', '12', 'B', '2024-2025', 'ADM016', 'https://www.lorempixel.com/103/121', NULL, NULL, 'BUS27', 'B+', '16', 'Student', '', 'EMP016', 'Zeeshan Thakur', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(17, 8, 'Oorja Bhatti', NULL, 'hbora@yahoo.com', '9312460526', '57/119, Wadhwa Path, Nagpur 136498', 'Suhana Krish', '', 'Uthkarsh Uppal', '', '', '25-09-2008', '3', 'A', '2024-2025', 'ADM017', 'https://placeimg.com/932/255/any', NULL, NULL, 'BUS43', 'B+', '17', 'Staff', 'Gokul Hora', 'EMP017', 'Azad Kannan', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(18, 8, 'Shlok Mahal', NULL, 'tsule@contractor.com', '7270384053', 'H.No. 809, Dhaliwal Chowk, Tiruchirappalli-168976', 'Taimur Rajan', '', 'Gatik Chatterjee', '', '', '28-09-2013', '8', 'B', '2024-2025', 'ADM018', 'https://dummyimage.com/949x739', NULL, NULL, 'BUS23', 'B+', '18', 'Helper', 'Shaan Sheth', 'EMP018', 'Emir Shah', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(19, 8, 'Kiaan Sharaf', NULL, 'utiwari@ramesh.com', '2334657838', '75/03, Malhotra Nagar, Srinagar 017132', 'Inaaya  Soman', '', 'Indrans Sampath', '', '', '02-03-2012', '1', 'B', '2024-2025', 'ADM019', 'https://dummyimage.com/362x933', NULL, NULL, 'BUS1', 'A-', '19', 'Staff', '', 'EMP019', 'Vanya Suresh', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(20, 8, 'Yashvi Bakshi', NULL, 'wkeer@kulkarni.org', '4803069722', '87, Saran Zila, Chennai 597709', 'Ishita De', '', 'Manikya Wali', '', '', '26-09-2016', '7', 'B', '2024-2025', 'ADM020', 'https://placeimg.com/281/271/any', NULL, NULL, 'BUS19', 'B+', '20', 'Helper', '', 'EMP020', 'Anvi Chahal', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(21, 8, 'Saksham Buch', NULL, 'badal15@gmail.com', '460570667', '339, Mandal Marg, Ambattur-990298', 'Anahi Bhandari', '', 'Shlok Atwal', '', '', '11-11-2006', '4', 'B', '2024-2025', 'ADM021', 'https://dummyimage.com/528x50', NULL, NULL, 'BUS25', 'O-', '21', 'Staff', 'Ahana  Wagle', 'EMP021', 'Reyansh Hari', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(22, 8, 'Neysa Gulati', NULL, 'yuvraj-01@gmail.com', '9.18683E+11', 'H.No. 39, Banerjee Zila, Vasai-Virar-312823', 'Dhanush Sastry', '', 'Misha Hegde', '', '', '10-02-2012', '2', 'A', '2024-2025', 'ADM022', 'https://placeimg.com/115/83/any', NULL, NULL, 'BUS35', 'O+', '22', 'Helper', '', 'EMP022', 'Pranay Batra', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(23, 8, 'Ranbir Thaker', NULL, 'divyanshchoudhury@tara.com', '456794993', 'H.No. 30, Mane, Sambalpur 340414', 'Aaina Dey', '', 'Faiyaz Mani', '', '', '11-06-2016', '10', 'B', '2024-2025', 'ADM023', 'https://dummyimage.com/898x60', NULL, NULL, 'BUS14', 'B+', '23', 'Teacher', '', 'EMP023', 'Riaan Kibe', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(24, 8, 'Rania Grewal', NULL, 'blad@gmail.com', '9.19514E+11', 'H.No. 619, Gopal, Nellore-742103', 'Anya Randhawa', '', 'Madhup Balan', '', '', '03-06-2012', '9', 'B', '2024-2025', 'ADM024', 'https://dummyimage.com/893x902', NULL, NULL, 'BUS20', 'O-', '24', 'Teacher', '', 'EMP024', 'Ivana Borra', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(25, 8, 'Riya Chander', NULL, 'arhaan69@gmail.com', '7819475095', '879, Rege Zila, Gaya 547265', 'Parinaaz Madan', '', 'Vardaniya Vyas', '', '', '15-09-2010', '10', 'C', '2024-2025', 'ADM025', 'https://placekitten.com/58/592', NULL, NULL, 'BUS10', 'O-', '25', 'Student', '', 'EMP025', 'Devansh Taneja', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(26, 8, 'Faiyaz Subramanian', NULL, 'taranshroff@dani-dey.biz', '8050567228', '16/18, Dhawan Ganj, Ujjain-864574', 'Khushi Choudhury', '', 'Gokul Biswas', '', '', '09-10-2010', '6', 'C', '2024-2025', 'ADM026', 'https://placekitten.com/402/142', NULL, NULL, 'BUS7', 'AB-', '26', 'Teacher', '', 'EMP026', 'Aradhya Goda', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(27, 8, 'Biju Gole', NULL, 'uthkarshgulati@char.com', '4457135268', '25/53, Bail, Bhavnagar 580386', 'Keya Sawhney', '', 'Jayan Mahajan', '', '', '27-01-2019', '7', 'C', '2024-2025', 'ADM027', 'https://placekitten.com/892/972', NULL, NULL, 'BUS19', 'A-', '27', 'Student', 'Miraan Kunda', 'EMP027', 'Sana Dube', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(28, 8, 'Anika Krishnan', NULL, 'cganesan@krish.info', '9.19515E+11', '28/560, Sibal Marg, Ozhukarai 219201', 'Badal Kadakia', '', 'Jivin Bhatia', '', '', '15-07-2006', '2', 'A', '2024-2025', 'ADM028', 'https://www.lorempixel.com/423/776', NULL, NULL, 'BUS20', 'AB+', '28', 'Teacher', 'Dishani Comar', 'EMP028', 'Nitya Loyal', '', NULL, '2025-06-24 20:18:23', '2025-06-24 20:18:23'),
(29, 8, 'Vardaniya Sheth', 'SVP_1750796875profile.png', 'qthakur@hotmail.com', '4207423648', 'H.No. 715, Sangha, Indore 235769', 'Dhanush Jhaveri', 'SVP_1750796875father_image.jpg', 'Samar Kamdar', 'SVP_1750796875mother_image.png', 'SVP_1750796875guardian_image.png', NULL, '9', 'C', '2024-2025', 'ADM029', 'hindi', 'signatures/studen_signature_685b0a4b8cc3a.png', 'signatures/employe_signature_685b0a4b8d813.png', 'BUS47', 'A-', '29', 'Teacher', 'Dhanuk Tiwari', 'EMP029', 'Saanvi Srinivasan', NULL, NULL, '2025-06-24 20:18:23', '2025-06-24 20:27:55'),
(30, 8, 'Parinaaz Maharaj', 'SVP_1750796528profile.jpeg', 'inaaya-ravel@gmail.com', '8554002798', '822, Chanda Circle, Kottayam-435003', 'Nakul Madan', '', 'Ryan Chakraborty', '', '', NULL, '3', 'B', '2024-2025', 'ADM030', 'English', 'signatures/studen_signature_685b08f02380b.png', 'signatures/employe_signature_685b08f024dde.png', 'BUS41', 'O-', '30', 'Teacher', NULL, 'EMP030', 'Samiha Krishnamurthy', NULL, NULL, '2025-06-24 20:18:23', '2025-06-24 20:22:08'),
(31, 8, 'rajesh', 'C:\\wamp64\\tmp\\php5799.tmp', NULL, NULL, NULL, 'tsag', 'SVP_1750831140father_image.jpeg', 'fsf', 'SVP_1750831140mother_image.jpeg', 'SVP_1750831140guardian_image.jpeg', NULL, '4', NULL, NULL, NULL, NULL, 'signatures/studen_signature_685b9024dffa1.png', 'signatures/employe_signature_685b9024e0837.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-25 05:59:00', '2025-06-25 05:59:00'),
(32, 8, 'raj', 'SVP_1750832213profile.jpeg', NULL, NULL, NULL, 'gagd', 'SVP_1750831220father_image.jpeg', 'dsfas', 'SVP_1750831220mother_image.jpeg', 'SVP_1750831220guardian_image.jpeg', NULL, '4', NULL, NULL, NULL, NULL, 'signatures/studen_signature_685b9074c64fa.png', 'signatures/employe_signature_685b9074c6c99.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-25 06:00:20', '2025-06-25 06:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

DROP TABLE IF EXISTS `update_logs`;
CREATE TABLE IF NOT EXISTS `update_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `update_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
