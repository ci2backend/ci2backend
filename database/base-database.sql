-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2017 at 08:17 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `base_code_ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_key` varchar(32) DEFAULT NULL,
  `lang_display` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lang_folder` varchar(255) DEFAULT NULL,
  `lang_class_flag` varchar(32) DEFAULT NULL,
  `is_default` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`lang_key`, `lang_display`, `lang_folder`, `lang_class_flag`, `is_default`) VALUES
('en', 'English', 'english', 'flag-us', 1),
('vn', 'Viet Nam', 'vietnam', 'flag-vn', 0),
('jp', 'Japanese', 'japanese', 'flag-jp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip_address` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET latin1 NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_access` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `token_key` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`token_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_key`, `session_id`, `email`, `username`) VALUES
('F14CA6E92811-3F67-D632-4CDB96FD736F', '3F67-D632-4CDB96FD736F', 'truong.van.phu@bpotech.com.vn', ''),
('F1aCA6E92811-3F67-D632-4CDB96FD736F', '3F67-D632-4CDB96FD736F', 'phu_tv@live.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `constants`
--

DROP TABLE IF EXISTS `constants`;
CREATE TABLE IF NOT EXISTS `constants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `constant` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

DROP TABLE IF EXISTS `extensions`;
CREATE TABLE IF NOT EXISTS `extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension_name` varchar(255) NOT NULL,
  `extension_key` varchar(255) NOT NULL,
  `system_load` int(1) NOT NULL DEFAULT '0',
  `description` varchar(255) NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `allow_delete` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `extension_name`, `extension_key`, `system_load`, `description`, `create_date`, `allow_delete`) VALUES
(1, 'Jquery', 'jquery', 0, 'jQuery is a fast, small, and feature-rich JavaScript library.', '2017-06-09 16:21:38', 0),
(2, 'Bootstrap 3.3.7', 'bootstrap', 0, 'Bootstrap 3.3.7', '2017-06-09 16:21:38', 0),
(3, 'Uniform', 'uniform', 0, 'Uniform', '2017-06-09 16:21:38', 0),
(6, 'Jquery validation', 'jquery-validation', 0, 'The jQuery Validation Plugin provides drop-in validation for your existing forms, while making all kinds of customizations to fit your application really easy.', '2017-06-09 16:21:38', 0),
(8, 'Confirmation bootstrap', 'confirmation', 0, 'Confirmation bootstrap', '2017-06-09 16:21:38', 0),
(9, 'Font Awesome v4.5', 'font-awesome', 0, 'Font Awesome v4.5', '2017-06-09 16:21:38', 0),
(10, 'Form Builder', 'formbuilder', 0, 'Form Builder', '2017-06-09 16:21:38', 0),
(11, 'Jquery UI 1.11.4', 'jquery-ui', 0, 'Jquery UI 1.11.4', '2017-06-09 16:21:38', 0),
(12, 'elFinder 2.1.14', 'elfinder', 0, 'elFinder file manager for web', '2017-06-09 16:21:38', 0),
(13, 'CodeMirror - 5.1.1', 'codemirror', 0, 'CodeMirror - 5.1.1', '2017-06-09 16:21:38', 0),
(14, 'DropZone Upload File', 'dropzone', 0, 'Dropzone is an easy to use drag\'n\'drop library. It supports image previews and shows nice progress bars.', '2017-06-09 16:21:38', 0),
(15, 'Jquery Chosen', 'jquery-chosen', 0, 'Jquery Chosen', '2017-06-09 16:21:38', 0),
(16, 'Form Post Download', 'ajax_download', 0, 'Form Post Download', '2017-06-09 16:21:38', 0),
(17, 'Bootstrap File Input', 'bootstrap-fileinput', 0, 'An enhanced HTML 5 file input for Bootstrap 3.x with file preview, multiple selection, and more features.', '2017-06-09 16:21:38', 0),
(18, 'Jquery slug URL', 'jquery-slug-url', 0, 'Jquery slug URL', '2017-06-09 16:21:38', 0),
(19, 'Preview tool', 'preview-tool', 0, 'Preview tool', '2017-06-09 16:23:10', 0),
(20, 'Overlay', 'overlay', 0, 'Overlay', '2017-06-09 16:25:24', 0),
(21, 'Messi Notify', 'messi', 0, 'Messi Notify', '2017-06-09 16:27:35', 0),
(22, 'Ajax.org Cloud9 Editor', 'ace-builds', 0, 'Ace is a code editor written in JavaScript.', '2017-06-09 16:42:44', 0),
(23, 'Bootbox', 'bootbox', 0, 'Bootbox - Bootstrap powered alert, confirm and flexible dialog boxes', '2017-06-09 16:50:17', 0),
(24, 'Table Search Plugin', 'jquery.tablesearch', 0, 'A jQuery plugin for a quick search in big tables. Will display only the line that matchs the query and hightlight the terms in the line', '2017-06-09 16:50:17', 0),
(25, 'Table Sorter Plugin', 'tablesorter', 0, 'Flexible client-side table sorting', '2017-06-22 02:48:49', 0);


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `security` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `security`) VALUES
(1, 'admin', 'Administrator', 1),
(2, 'members', 'General User', 0);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_key` varchar(255) NOT NULL,
  `action_router` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_show` int(1) NOT NULL DEFAULT '1',
  `is_delete` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title_key`, `action_router`, `icon`, `description`, `is_show`, `is_delete`, `created`, `modified`) VALUES
(1, 'Dashboard', 'dev/index', NULL, 'Manage all module in the system', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(2, 'Views', 'views/index', NULL, 'Manage page in the system', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(3, 'Controllers', 'controllers/index', NULL, 'Manage all controller in the sysytem', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(4, 'MyQuery', 'models/index', NULL, 'Manage all model in the sysytem', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(5, 'Languages', 'languages/index', NULL, 'Manage all language in the sysytem', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(6, 'Databases', 'databases/index', NULL, 'Manage all database in the sysytem', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(7, 'Users', 'users/index', NULL, 'Manage all user in the sysytem', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(8, 'Menus', 'menus/index', NULL, 'Manage all menu in the system', 0, 0, '2017-06-13 08:15:34', '2017-06-23 11:41:39'),
(9, 'Settings', 'dev/setting', NULL, 'Setting in the system', 1, 0, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(10, 'Templates', 'templates/index', NULL, 'Manage template', 0, 1, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(11, 'Platforms', 'platforms/index', NULL, 'Manage platform', 0, 1, '2017-06-13 08:15:34', '2017-06-13 08:15:34'),
(12, 'Extensions', 'extensions/index', NULL, 'Manage extension', 0, 0, '2017-06-18 21:54:20', '2017-06-18 14:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_key` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `is_show` int(1) NOT NULL DEFAULT '1',
  `icon` varchar(255) NOT NULL,
  `description` varchar(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `title_key`, `action`, `is_show`, `icon`, `description`) VALUES
(1, 'Views', 'views/index', 1, 'modules/manage_view.png', 'Manage View'),
(2, 'Controllers', 'controllers/index', 1, 'modules/manage_controller.png', 'Manage Controller'),
(3, 'MyQueries', 'models/index', 1, 'modules/manage_model.png', 'Manage Model'),
(4, 'Languages', 'languages/index', 1, 'modules/manage_language.png', 'Manage Language'),
(5, 'Databases', 'databases/index', 1, 'modules/manage_database.png', 'Manage Database'),
(6, 'Users', 'users/index', 1, 'modules/manage_user.png', 'Manage User'),
(7, 'Menus', 'menus/index', 0, 'modules/menu.png', 'Main Menu'),
(8, 'Platforms', 'platforms/index', 1, 'modules/manage_platform.png', 'Manage Platform'),
(9, 'Routers', 'routers/index', 1, 'modules/manage_router.png', 'Router'),
(10, 'Commons', 'commons/index', 0, 'modules/manage_common.png', 'Common file'),
(11, 'Templates', 'templates/index', 1, 'modules/manage_template.png', 'Manage Template'),
(12, 'Elements', 'elements/index', 0, 'modules/manage_element.png', 'Form Elements'),
(13, 'Extensions', 'extensions/index', 1, 'modules/manage_extension.png', 'Manage Extension'),
(14, 'Supports', 'supports/index', 1, 'modules/support.png', 'Support'),
(15, 'Settings', 'dev/setting', 1, 'modules/setting.png', 'Settings');


-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

DROP TABLE IF EXISTS `platforms`;
CREATE TABLE IF NOT EXISTS `platforms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform_key` varchar(255) NOT NULL,
  `platform_name` varchar(255) NOT NULL,
  `description` varchar(255) NULL,
  `is_default` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `platform`
--

INSERT INTO `platforms` (`id`, `platform_key`, `platform_name`, `description`, `is_default`) VALUES
(1, 'web', "Desktop browser", 'Website for desktop', 1),
(2, 'mobile', "Mobile browser", 'Mobile browser for Wap, Wap2, Imode', 0),
(3, 'smartphone', "Smartphone browser", 'Smartphone for iPod, iPhone, Android, IEMobile', 0),
(4, 'sys_admin', "Backend System", 'Admin System is a customize platform for all devices', 0);

-- --------------------------------------------------------

--
-- Table structure for table `routers`
--

DROP TABLE IF EXISTS `routers`;
CREATE TABLE IF NOT EXISTS `routers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `router_source` varchar(255) NOT NULL,
  `router_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `router_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `routers`
--

INSERT INTO `routers` (`router_source`, `router_key`, `router_value`) VALUES
('dev/index', 'dev/index', 'admin.html'),
('dev/index', 'dev/index', 'admin'),
('dev/profile', 'dev/profile', 'profile'),
('dev/profile', 'dev/profile', 'profile.html'),
('dev/setting', 'dev/setting/database_settings', 'database_settings.html'),
('dev/setting', 'dev/setting/configure', 'configure.html'),
('dev/setting', 'dev/setting', 'configure.html'),
('dev/setting', 'dev/setting/constant_define', 'constant_define.html'),
('dev/setting', 'dev/setting/repair_database', 'repair_database.html'),
('dev/setting', 'dev/setting/site_settings', 'site_settings.html'),
('dev/index', 'dev/index', 'admin.html'),
('dev/index', 'dev/index', 'admin'),
('users/login', 'users/login', 'login.html'),
('dev/setting', 'dev/setting/database_settings', 'database_settings.html'),
('dev/setting', 'dev/setting/configure', 'configure.html'),
('dev/setting', 'dev/setting', 'configure.html'),
('dev/setting', 'dev/setting/constant_define', 'constant_define.html'),
('dev/setting', 'dev/setting/repair_database', 'repair_database.html'),
('dev/setting', 'dev/setting/site_settings', 'site_settings.html'),
('dev/setting', 'dev/setting/site_settings', 'site_settings.html'),
('dev/setting', 'dev/setting/email_configure', 'email_configure.html'),
('dev/form_ajax', 'dev/form_ajax', 'ajax.html'),
('dev/form_ajax', 'dev/form_ajax/$1', 'ajax.html/(:any)'),
('users/logout', 'users/logout', 'logout.html'),
('extensions/index', 'extensions/index', 'local_extension.html'),
('extensions/index', 'extensions/index/local_extension', 'local_extension.html'),
('extensions/index', 'extensions/index/new_extension', 'new_extension.html');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

DROP TABLE IF EXISTS `sub_menus`;
CREATE TABLE IF NOT EXISTS `sub_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_key` varchar(255) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `action_router` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_show` int(1) NOT NULL DEFAULT '1',
  `description` varchar(255) NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menus_id` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`id`, `title_key`, `menu_id`, `action_router`, `icon`, `is_show`, `description`) VALUES
(1, 'Create_new', 8, 'menus/create', NULL, 1, 'Create new menu'),
(2, 'Create_sub_menu', 8, 'menus/sub_menu', NULL, 1, 'Create sub menu'),
(3, 'Platforms', 1, 'platforms/index', NULL, 1, 'Manage platform'),
(4, 'Routers', 1, 'routers/index', NULL, 1, 'Manage router'),
(5, 'Commons', 1, 'commons/index', NULL, 0, 'Manage common'),
(6, 'Templates', 1, 'templates/index', NULL, 1, 'Manage template'),
(7, 'Elements', 1, 'elements/index', NULL, 0, 'Manage form'),
(8, 'Extensions', 1, 'extensions/index', NULL, 1, 'Manage extension'),
(9, 'Supports', 1, 'supports/index', NULL, 1, 'Support online'),
(10, 'Create_page', 2, 'views/create', NULL, 1, 'Create new page'),
(11, 'Create_controller', 3, 'controllers/create', NULL, 1, 'Create new controller'),
(12, 'Create_query', 4, 'models/create', NULL, 1, 'Create new query file'),
(13, 'Region_list', 5, 'languages/region', NULL, 1, 'Region list'),
(14, 'Create_group', 7, 'auth/create_group', NULL, 1, 'Add a new group'),
(15, 'Create_user', 7, 'auth/create_user', NULL, 1, 'Add a new user'),
(16, 'Add_new_template', 10, 'templates/create', NULL, 1, 'Add new template'),
(17, 'Add_new_platform', 11, 'platforms/create', NULL, 1, 'Add new platform'),
(18, 'View_detail', 2, 'views/detail', NULL, 0, 'View detai'),
(19, 'Edit_content', 2, 'views/edit', NULL, 0, 'Edit content'),
(20, 'Compare_language', 5, 'dev/compare_lang', NULL, 0, 'Compare language'),
(21, 'Extension_detail', 12, 'extensions/detail', NULL, 0, 'Extension detail'),
(22, 'Template_detail', 10, 'templates/detail', NULL, 1, ''),
(23, 'Compare_language', 5, 'languages/compare', NULL, 0, 'Compare language page'),
(24, 'Edit_content', 5, 'languages/edit', NULL, 0, 'Edit language page'),
(25, 'Add_new_language', 5, 'languages/create', NULL, 1, 'Add new language'),
(26, 'Edit_content', 3, 'controllers/edit', NULL, 0, 'Edit content'),
(27, 'Access_right', 7, 'users/access_right', NULL, 1, 'Access right'),
(28, 'Edit_content', 4, 'models/edit', NULL, 0, 'Edit content'),
(29, 'Detail_controller', 3, 'controllers/detail', NULL, 1, 'Detail controller');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_setting` varchar(255) NOT NULL,
  `value_setting` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_setting` (`key_setting`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key_setting`, `value_setting`) VALUES
(1, 'MULTI_PLATFORM', '1'),
(2, 'ENABLE_AUTHENTICATION', '1'),
(3, 'DEVELOPER_PLATFORM', 'sys_admin'),
(4, 'DEVELOPER_TEMPLATE', 'sys_admin'),
(5, 'AUTO_GENERATE_ASSEST_FILE', '1'),
(6, 'AUTO_GENERATE_LANGUAGE_FILE', '1'),
(7, 'ENABLE_PRODUCTION', '0'),
(8, 'AUTO_LOAD_VIEW', '1');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `template_key` varchar(255) NOT NULL,
  `page_content_default` varchar(255) NULL,
  `description` varchar(255) NULL,
  `enable_customize_view` int(1) NOT NULL DEFAULT '0',
  `customize_view_folder` varchar(255) NULL DEFAULT 'custom_view',
  `is_default` int(1) NOT NULL DEFAULT '0',
  `is_backend` int(1) NOT NULL DEFAULT '0',
  `allow_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`template_name`, `template_key`, `page_content_default`, `is_default`, `is_backend`) VALUES
('Admin System', 'sys_admin', '<div class="grid_12">

  <div class="module">

    <h2 class="text-primary"><span>Title</span></h2>

    <div class="module-body">

      <div class="grid_12 grid">

      </div>

    </div>

  </div>

</div>', 0, 1),
('Web Application', 'web', '', 1, 0),
('No Template', 'notemplate', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `templates_extensions`
--

DROP TABLE IF EXISTS `templates_extensions`;
CREATE TABLE IF NOT EXISTS `templates_extensions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_key` varchar(50) NOT NULL,
  `extension_key` varchar(50) NOT NULL,
  `is_load` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates_extensions`
--

INSERT INTO `templates_extensions` (`id`, `template_key`, `extension_key`, `is_load`) VALUES
(1, 'sys_admin', 'bootbox', 1),
(3, 'web', 'jquery', 1),
(4, 'web', 'bootstrap', 1);

-- --------------------------------------------------------

--
-- Table structure for table `templates_menus`
--

DROP TABLE IF EXISTS `templates_menus`;
CREATE TABLE IF NOT EXISTS `templates_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_key` varchar(50) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `is_load` int(11) NOT NULL DEFAULT '1',
  `priority` int(11) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates_menus`
--

INSERT INTO `templates_menus` (`id`, `template_key`, `menu_id`, `is_load`, `priority`, `created`, `modified`) VALUES
(1, 'sys_admin', 1, 1, 0, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(2, 'sys_admin', 2, 1, 1, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(3, 'sys_admin', 3, 1, 2, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(4, 'sys_admin', 4, 1, 3, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(5, 'sys_admin', 5, 1, 4, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(6, 'sys_admin', 6, 1, 5, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(7, 'sys_admin', 7, 1, 6, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(8, 'sys_admin', 8, 1, 7, '2017-06-13 08:15:35', '2017-06-13 08:15:35'),
(9, 'sys_admin', 9, 1, 8, '2017-06-13 08:15:35', '2017-06-13 08:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `lang_folder` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `lang_folder`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1268889823, 1, 'Admin', 'istrator', 'ADMIN', '0', 'english');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

DROP TABLE IF EXISTS `views`;
CREATE TABLE IF NOT EXISTS `views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `view_name` varchar(255) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `allow_delete` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `controllers`
--

DROP TABLE IF EXISTS `controllers`;
CREATE TABLE IF NOT EXISTS `controllers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_name` varchar(255) NOT NULL,
  `controller_key` varchar(255) NOT NULL,
  `directory` varchar(255) NOT NULL,
  `template_key` varchar(255) NOT NULL,
  `is_backend` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_controllers`
--

INSERT INTO `controllers` (`id`, `controller_name`, `controller_key`, `template_key`, `is_backend`, `created`, `modified`) VALUES
(1, 'Admin.php', 'admin', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(2, 'Ajax.php', 'ajax', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(3, 'Auth.php', 'auth', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(4, 'Code.php', 'code', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(5, 'Commons.php', 'commons', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(6, 'Controllers.php', 'controllers', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(7, 'Databases.php', 'databases', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(8, 'Elements.php', 'elements', 'sys_admin', 1, '2017-06-24 11:33:16', '2017-06-24 04:33:16'),
(9, 'Extensions.php', 'extensions', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(10, 'Home.php', 'home', 'web', 0, '2017-06-24 11:33:17', '2017-06-24 08:24:52'),
(11, 'Languages.php', 'languages', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(12, 'Menus.php', 'menus', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(13, 'Models.php', 'models', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(14, 'Modules.php', 'modules', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(15, 'My_constants.php', 'my_constants', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(16, 'Platforms.php', 'platforms', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(17, 'Routers.php', 'routers', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(18, 'Supports.php', 'supports', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(19, 'Templates.php', 'templates', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(20, 'Tree.php', 'tree', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(21, 'Users.php', 'users', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(22, 'Views.php', 'views', 'sys_admin', 1, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(23, 'Welcome.php', 'welcome', 'web', 0, '2017-06-24 11:33:17', '2017-06-24 04:33:17'),
(24, 'Dev.php', 'dev', 'sys_admin', 1, '2017-06-24 15:23:52', '2017-06-24 08:23:52'),
(25, 'Generate.php', 'generate', 'sys_admin', 1, '2017-06-24 15:23:52', '2017-06-24 08:23:52');


DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `country`
--

INSERT INTO `country` (`code`, `name`) VALUES
('AD', 'Andorra'),
('AE', 'United Arab Emirates'),
('AF', 'Afghanistan'),
('AG', 'Antigua and Barbuda'),
('AI', 'Anguilla'),
('AL', 'Albania'),
('AM', 'Armenia'),
('AN', 'Netherlands Antilles'),
('AO', 'Angola'),
('AQ', 'Antarctica'),
('AR', 'Argentina'),
('AS', 'American Samoa'),
('AT', 'Austria'),
('AU', 'Australia'),
('AW', 'Aruba'),
('AX', 'Ă…land Islands'),
('AZ', 'Azerbaijan'),
('BA', 'Bosnia and Herzegovina'),
('BB', 'Barbados'),
('BD', 'Bangladesh'),
('BE', 'Belgium'),
('BF', 'Burkina Faso'),
('BG', 'Bulgaria'),
('BH', 'Bahrain'),
('BI', 'Burundi'),
('BJ', 'Benin'),
('BL', 'Saint BarthĂ©lemy'),
('BM', 'Bermuda'),
('BN', 'Brunei'),
('BO', 'Bolivia'),
('BQ', 'British Antarctic Territory'),
('BR', 'Brazil'),
('BS', 'Bahamas'),
('BT', 'Bhutan'),
('BV', 'Bouvet Island'),
('BW', 'Botswana'),
('BY', 'Belarus'),
('BZ', 'Belize'),
('CA', 'Canada'),
('CC', 'Cocos [Keeling] Islands'),
('CD', 'Congo - Kinshasa'),
('CF', 'Central African Republic'),
('CG', 'Congo - Brazzaville'),
('CH', 'Switzerland'),
('CI', 'CĂ´te dâ€™Ivoire'),
('CK', 'Cook Islands'),
('CL', 'Chile'),
('CM', 'Cameroon'),
('CN', 'China'),
('CO', 'Colombia'),
('CR', 'Costa Rica'),
('CS', 'Serbia and Montenegro'),
('CT', 'Canton and Enderbury Islands'),
('CU', 'Cuba'),
('CV', 'Cape Verde'),
('CX', 'Christmas Island'),
('CY', 'Cyprus'),
('CZ', 'Czech Republic'),
('DD', 'East Germany'),
('DE', 'Germany'),
('DJ', 'Djibouti'),
('DK', 'Denmark'),
('DM', 'Dominica'),
('DO', 'Dominican Republic'),
('DZ', 'Algeria'),
('EC', 'Ecuador'),
('EE', 'Estonia'),
('EG', 'Egypt'),
('EH', 'Western Sahara'),
('ER', 'Eritrea'),
('ES', 'Spain'),
('ET', 'Ethiopia'),
('FI', 'Finland'),
('FJ', 'Fiji'),
('FK', 'Falkland Islands'),
('FM', 'Micronesia'),
('FO', 'Faroe Islands'),
('FQ', 'French Southern and Antarctic Territories'),
('FR', 'France'),
('FX', 'Metropolitan France'),
('GA', 'Gabon'),
('GB', 'United Kingdom'),
('GD', 'Grenada'),
('GE', 'Georgia'),
('GF', 'French Guiana'),
('GG', 'Guernsey'),
('GH', 'Ghana'),
('GI', 'Gibraltar'),
('GL', 'Greenland'),
('GM', 'Gambia'),
('GN', 'Guinea'),
('GP', 'Guadeloupe'),
('GQ', 'Equatorial Guinea'),
('GR', 'Greece'),
('GS', 'South Georgia and the South Sandwich Islands'),
('GT', 'Guatemala'),
('GU', 'Guam'),
('GW', 'Guinea-Bissau'),
('GY', 'Guyana'),
('HK', 'Hong Kong SAR China'),
('HM', 'Heard Island and McDonald Islands'),
('HN', 'Honduras'),
('HR', 'Croatia'),
('HT', 'Haiti'),
('HU', 'Hungary'),
('ID', 'Indonesia'),
('IE', 'Ireland'),
('IL', 'Israel'),
('IM', 'Isle of Man'),
('IN', 'India'),
('IO', 'British Indian Ocean Territory'),
('IQ', 'Iraq'),
('IR', 'Iran'),
('IS', 'Iceland'),
('IT', 'Italy'),
('JE', 'Jersey'),
('JM', 'Jamaica'),
('JO', 'Jordan'),
('JP', 'Japan'),
('JT', 'Johnston Island'),
('KE', 'Kenya'),
('KG', 'Kyrgyzstan'),
('KH', 'Cambodia'),
('KI', 'Kiribati'),
('KM', 'Comoros'),
('KN', 'Saint Kitts and Nevis'),
('KP', 'North Korea'),
('KR', 'South Korea'),
('KW', 'Kuwait'),
('KY', 'Cayman Islands'),
('KZ', 'Kazakhstan'),
('LA', 'Laos'),
('LB', 'Lebanon'),
('LC', 'Saint Lucia'),
('LI', 'Liechtenstein'),
('LK', 'Sri Lanka'),
('LR', 'Liberia'),
('LS', 'Lesotho'),
('LT', 'Lithuania'),
('LU', 'Luxembourg'),
('LV', 'Latvia'),
('LY', 'Libya'),
('MA', 'Morocco'),
('MC', 'Monaco'),
('MD', 'Moldova'),
('ME', 'Montenegro'),
('MF', 'Saint Martin'),
('MG', 'Madagascar'),
('MH', 'Marshall Islands'),
('MI', 'Midway Islands'),
('MK', 'Macedonia'),
('ML', 'Mali'),
('MM', 'Myanmar [Burma]'),
('MN', 'Mongolia'),
('MO', 'Macau SAR China'),
('MP', 'Northern Mariana Islands'),
('MQ', 'Martinique'),
('MR', 'Mauritania'),
('MS', 'Montserrat'),
('MT', 'Malta'),
('MU', 'Mauritius'),
('MV', 'Maldives'),
('MW', 'Malawi'),
('MX', 'Mexico'),
('MY', 'Malaysia'),
('MZ', 'Mozambique'),
('NA', 'Namibia'),
('NC', 'New Caledonia'),
('NE', 'Niger'),
('NF', 'Norfolk Island'),
('NG', 'Nigeria'),
('NI', 'Nicaragua'),
('NL', 'Netherlands'),
('NO', 'Norway'),
('NP', 'Nepal'),
('NQ', 'Dronning Maud Land'),
('NR', 'Nauru'),
('NT', 'Neutral Zone'),
('NU', 'Niue'),
('NZ', 'New Zealand'),
('OM', 'Oman'),
('PA', 'Panama'),
('PC', 'Pacific Islands Trust Territory'),
('PE', 'Peru'),
('PF', 'French Polynesia'),
('PG', 'Papua New Guinea'),
('PH', 'Philippines'),
('PK', 'Pakistan'),
('PL', 'Poland'),
('PM', 'Saint Pierre and Miquelon'),
('PN', 'Pitcairn Islands'),
('PR', 'Puerto Rico'),
('PS', 'Palestinian Territories'),
('PT', 'Portugal'),
('PU', 'U.S. Miscellaneous Pacific Islands'),
('PW', 'Palau'),
('PY', 'Paraguay'),
('PZ', 'Panama Canal Zone'),
('QA', 'Qatar'),
('RE', 'RĂ©union'),
('RO', 'Romania'),
('RS', 'Serbia'),
('RU', 'Russia'),
('RW', 'Rwanda'),
('SA', 'Saudi Arabia'),
('SB', 'Solomon Islands'),
('SC', 'Seychelles'),
('SD', 'Sudan'),
('SE', 'Sweden'),
('SG', 'Singapore'),
('SH', 'Saint Helena'),
('SI', 'Slovenia'),
('SJ', 'Svalbard and Jan Mayen'),
('SK', 'Slovakia'),
('SL', 'Sierra Leone'),
('SM', 'San Marino'),
('SN', 'Senegal'),
('SO', 'Somalia'),
('SR', 'Suriname'),
('ST', 'SĂ£o TomĂ© and PrĂ­ncipe'),
('SU', 'Union of Soviet Socialist Republics'),
('SV', 'El Salvador'),
('SY', 'Syria'),
('SZ', 'Swaziland'),
('TC', 'Turks and Caicos Islands'),
('TD', 'Chad'),
('TF', 'French Southern Territories'),
('TG', 'Togo'),
('TH', 'Thailand'),
('TJ', 'Tajikistan'),
('TK', 'Tokelau'),
('TL', 'Timor-Leste'),
('TM', 'Turkmenistan'),
('TN', 'Tunisia'),
('TO', 'Tonga'),
('TR', 'Turkey'),
('TT', 'Trinidad and Tobago'),
('TV', 'Tuvalu'),
('TW', 'Taiwan'),
('TZ', 'Tanzania'),
('UA', 'Ukraine'),
('UG', 'Uganda'),
('UM', 'U.S. Minor Outlying Islands'),
('US', 'United States'),
('UY', 'Uruguay'),
('UZ', 'Uzbekistan'),
('VA', 'Vatican City'),
('VC', 'Saint Vincent and the Grenadines'),
('VD', 'North Vietnam'),
('VE', 'Venezuela'),
('VG', 'British Virgin Islands'),
('VI', 'U.S. Virgin Islands'),
('VN', 'Vietnam'),
('VU', 'Vanuatu'),
('WF', 'Wallis and Futuna'),
('WK', 'Wake Island'),
('WS', 'Samoa'),
('YD', 'People\'s Democratic Republic of Yemen'),
('YE', 'Yemen'),
('YT', 'Mayotte'),
('ZA', 'South Africa'),
('ZM', 'Zambia'),
('ZW', 'Zimbabwe'),
('ZZ', 'Unknown or Invalid Region');


--
-- Table structure for table `access_right`
--

DROP TABLE IF EXISTS `access_rights`;
CREATE TABLE IF NOT EXISTS `access_rights` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `control` varchar(255) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `require_login` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `allow_delete` int(11) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `access_rights` (`id`, `control`, `action`, `require_login`, `allow_delete`) VALUES
(1, 'Admin', 'index', 1, 1),
(2, 'Admin', 'edit', 1, 1),
(3, 'Admin', 'delete', 1, 1),
(4, 'Ajax', 'index', 1, 1),
(5, 'Auth', 'index', 1, 1),
(6, 'Auth', 'delete_user', 1, 1),
(7, 'Auth', 'change_password', 1, 1),
(8, 'Auth', 'forgot_password', 0, 1),
(9, 'Auth', 'reset_password', 0, 1),
(10, 'Auth', 'activate', 0, 1),
(11, 'Auth', 'deactivate', 1, 1),
(12, 'Auth', 'create_user', 1, 1),
(13, 'Auth', 'edit_user', 1, 1),
(14, 'Auth', 'create_group', 1, 1),
(15, 'Auth', 'edit_group', 1, 1),
(16, 'Auth', '_get_csrf_nonce', 1, 1),
(17, 'Auth', '_valid_csrf_nonce', 1, 1),
(18, 'Auth', '_render_page', 1, 1),
(19, 'Code', 'eval_php', 1, 1),
(20, 'Code', 'getErrorName', 1, 1),
(21, 'Code', 'index', 1, 1),
(22, 'Code', 'edit', 1, 1),
(23, 'Code', 'delete', 1, 1),
(24, 'Commons', 'index', 1, 1),
(25, 'Commons', 'create', 1, 1),
(26, 'Commons', 'edit', 1, 1),
(27, 'Commons', 'delete', 1, 1),
(28, 'Controllers', 'index', 1, 1),
(29, 'Controllers', 'create', 1, 1),
(30, 'Controllers', 'edit', 1, 1),
(31, 'Controllers', 'detail', 1, 1),
(32, 'Controllers', 'delete', 1, 1),
(33, 'Databases', 'index', 1, 1),
(34, 'Databases', 'reset', 1, 1),
(35, 'Databases', 'create', 1, 1),
(36, 'Databases', 'edit', 1, 1),
(37, 'Databases', 'delete', 1, 1),
(38, 'Databases', 'rename', 1, 1),
(39, 'Dev', 'index', 1, 1),
(40, 'Dev', 'profile', 1, 1),
(41, 'Dev', 'user_profile', 1, 1),
(42, 'Dev', 'user_settings', 1, 1),
(43, 'Dev', 'db_resetdb', 1, 1),
(44, 'Dev', 'db_check_database', 1, 1),
(45, 'Dev', 'db_check_connection', 1, 1),
(46, 'Dev', 'change_db_setting', 1, 1),
(47, 'Dev', 'form_ajax', 1, 1),
(48, 'Dev', 'setting', 1, 1),
(49, 'Dev', 'formbuilder', 1, 1),
(50, 'Dev', 'delete', 1, 1),
(51, 'Dev', 'parse_arr_2_str', 1, 1),
(52, 'Dev', 'loop_var_value', 1, 1),
(53, 'Dev', 'confirm_delete', 1, 1),
(54, 'Elements', 'index', 1, 1),
(55, 'Elements', 'create', 1, 1),
(56, 'Elements', 'edit', 1, 1),
(57, 'Elements', 'delete', 1, 1),
(58, 'Extensions', 'index', 1, 1),
(59, 'Extensions', 'edit', 1, 1),
(60, 'Extensions', 'download', 1, 1),
(61, 'Extensions', 'detail', 1, 1),
(62, 'Extensions', 'create', 1, 1),
(63, 'Extensions', 'delete', 1, 1),
(64, 'Extensions', 'import', 1, 1),
(65, 'Extensions', 'check_existed_extension_key', 1, 1),
(66, 'Extensions', 'get_list_extension', 1, 1),
(67, 'Generate', 'index', 1, 1),
(68, 'Generate', 'controller', 1, 1),
(69, 'Generate', 'model', 1, 1),
(70, 'Generate', 'write_php_ini', 1, 1),
(71, 'Generate', 'view', 1, 1),
(72, 'Generate', 'library', 1, 1),
(73, 'Generate', 'helper', 1, 1),
(74, 'Generate', '_add_contruct', 1, 1),
(75, 'Generate', 'result', 1, 1),
(76, 'Home', 'index', 1, 1),
(77, 'Languages', 'index', 1, 1),
(78, 'Languages', 'create', 1, 1),
(79, 'Languages', 'edit', 1, 1),
(80, 'Languages', 'delete', 1, 1),
(81, 'Languages', 'common', 1, 1),
(82, 'Languages', 'compare', 1, 1),
(83, 'Languages', 'region', 1, 1),
(84, 'Menus', 'index', 1, 1),
(85, 'Menus', 'sub_menu', 1, 1),
(86, 'Menus', 'create', 1, 1),
(87, 'Menus', 'edit', 1, 1),
(88, 'Menus', 'delete', 1, 1),
(89, 'Models', 'index', 1, 1),
(90, 'Models', 'create', 1, 1),
(91, 'Models', 'edit', 1, 1),
(92, 'Models', 'delete', 1, 1),
(93, 'Modules', 'index', 1, 1),
(94, 'Modules', 'create', 1, 1),
(95, 'Modules', 'edit', 1, 1),
(96, 'Modules', 'delete', 1, 1),
(97, 'My_constants', 'checkConstantExist', 1, 1),
(98, 'My_constants', 'create', 1, 1),
(99, 'My_constants', 'edit', 1, 1),
(100, 'My_constants', 'delete', 1, 1),
(101, 'Platforms', 'index', 1, 1),
(102, 'Platforms', 'create', 1, 1),
(103, 'Platforms', 'edit', 1, 1),
(104, 'Platforms', 'set_default', 1, 1),
(105, 'Platforms', 'delete', 1, 1),
(106, 'Platforms', 'get_default_platform', 1, 1),
(107, 'Routers', 'index', 1, 1),
(108, 'Routers', 'create', 1, 1),
(109, 'Routers', 'edit', 1, 1),
(110, 'Routers', 'delete', 1, 1),
(111, 'Supports', 'index', 1, 1),
(112, 'Supports', 'create', 1, 1),
(113, 'Supports', 'edit', 1, 1),
(114, 'Supports', 'delete', 1, 1),
(115, 'Templates', 'index', 1, 1),
(116, 'Templates', 'create', 1, 1),
(117, 'Templates', 'edit', 1, 1),
(118, 'Templates', 'detail', 1, 1),
(119, 'Templates', 'delete', 1, 1),
(120, 'Templates', 'check_existed_template_key', 1, 1),
(121, 'Templates', 'create_template_directory', 1, 1),
(122, 'Templates', 'template_loader', 1, 1),
(123, 'Templates', 'get_default_template', 1, 1),
(124, 'Tree', 'index', 1, 1),
(125, 'Tree', 'loadExtensionFolder', 1, 1),
(126, 'Tree', 'loadTemplateFolder', 1, 1),
(127, 'Tree', 'loadTemplateCommonFolder', 1, 1),
(128, 'Users', 'index', 1, 1),
(129, 'Users', 'edit', 1, 1),
(130, 'Users', 'access_right', 1, 1),
(131, 'Users', 'enable_access_right', 1, 1),
(132, 'Users', 'set_require_login', 1, 1),
(133, 'Users', 'delete', 1, 1),
(134, 'Users', 'update_last_login', 1, 1),
(135, 'Users', 'check_expired_session', 1, 1),
(136, 'Users', 'change_language', 1, 1),
(137, 'Views', 'index', 1, 1),
(138, 'Views', 'detail', 1, 1),
(139, 'Views', 'create', 1, 1),
(140, 'Views', 'edit', 1, 1),
(141, 'Views', 'delete', 1, 1),
(142, 'Views', 'preview', 1, 1),
(143, 'Views', 'get_preview_box', 1, 1),
(144, 'Views', 'edit_info', 1, 1),
(145, 'Welcome', 'index', 1, 1);

DROP TABLE IF EXISTS `access_right_groups`;
CREATE TABLE IF NOT EXISTS `access_right_groups` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `access_right_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `enable` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_access_rights_groups` (`access_right_id`,`group_id`),
  KEY `fk_access_rights_access_right_groups1_idx` (`access_right_id`),
  KEY `fk_access_right_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `access_right_groups` (`id`, `access_right_id`, `group_id`, `enable`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 2, 1, 1),
(5, 2, 2, 0),
(6, 2, 3, 0),
(7, 3, 1, 1),
(8, 3, 2, 0),
(9, 3, 3, 0),
(10, 4, 1, 1),
(11, 4, 2, 0),
(12, 4, 3, 0),
(13, 5, 1, 1),
(14, 5, 2, 0),
(15, 5, 3, 0),
(16, 6, 1, 1),
(17, 6, 2, 0),
(18, 6, 3, 0),
(19, 7, 1, 1),
(20, 7, 2, 0),
(21, 7, 3, 0),
(22, 8, 1, 1),
(23, 8, 2, 1),
(24, 8, 3, 1),
(25, 9, 1, 1),
(26, 9, 2, 1),
(27, 9, 3, 1),
(28, 10, 1, 1),
(29, 10, 2, 1),
(30, 10, 3, 1),
(31, 11, 1, 1),
(32, 11, 2, 0),
(33, 11, 3, 0),
(34, 12, 1, 1),
(35, 12, 2, 0),
(36, 12, 3, 0),
(37, 13, 1, 1),
(38, 13, 2, 0),
(39, 13, 3, 0),
(40, 14, 1, 1),
(41, 14, 2, 0),
(42, 14, 3, 0),
(43, 15, 1, 1),
(44, 15, 2, 0),
(45, 15, 3, 0),
(46, 16, 1, 1),
(47, 16, 2, 0),
(48, 16, 3, 0),
(49, 17, 1, 1),
(50, 17, 2, 0),
(51, 17, 3, 0),
(52, 18, 1, 1),
(53, 18, 2, 0),
(54, 18, 3, 0),
(55, 19, 1, 1),
(56, 19, 2, 0),
(57, 19, 3, 0),
(58, 20, 1, 1),
(59, 20, 2, 0),
(60, 20, 3, 0),
(61, 21, 1, 1),
(62, 21, 2, 0),
(63, 21, 3, 0),
(64, 22, 1, 1),
(65, 22, 2, 0),
(66, 22, 3, 0),
(67, 23, 1, 1),
(68, 23, 2, 0),
(69, 23, 3, 0),
(70, 24, 1, 1),
(71, 24, 2, 0),
(72, 24, 3, 0),
(73, 25, 1, 1),
(74, 25, 2, 0),
(75, 25, 3, 0),
(76, 26, 1, 1),
(77, 26, 2, 0),
(78, 26, 3, 0),
(79, 27, 1, 1),
(80, 27, 2, 0),
(81, 27, 3, 0),
(82, 28, 1, 1),
(83, 28, 2, 0),
(84, 28, 3, 0),
(85, 29, 1, 1),
(86, 29, 2, 0),
(87, 29, 3, 0),
(88, 30, 1, 1),
(89, 30, 2, 0),
(90, 30, 3, 0),
(91, 31, 1, 1),
(92, 31, 2, 0),
(93, 31, 3, 0),
(94, 32, 1, 1),
(95, 32, 2, 0),
(96, 32, 3, 0),
(97, 33, 1, 1),
(98, 33, 2, 0),
(99, 33, 3, 0),
(100, 34, 1, 1),
(101, 34, 2, 0),
(102, 34, 3, 0),
(103, 35, 1, 1),
(104, 35, 2, 0),
(105, 35, 3, 0),
(106, 36, 1, 1),
(107, 36, 2, 0),
(108, 36, 3, 0),
(109, 37, 1, 1),
(110, 37, 2, 0),
(111, 37, 3, 0),
(112, 38, 1, 1),
(113, 38, 2, 0),
(114, 38, 3, 0),
(115, 39, 1, 1),
(116, 39, 2, 0),
(117, 39, 3, 0),
(118, 40, 1, 1),
(119, 40, 2, 0),
(120, 40, 3, 0),
(121, 41, 1, 1),
(122, 41, 2, 0),
(123, 41, 3, 0),
(124, 42, 1, 1),
(125, 42, 2, 0),
(126, 42, 3, 0),
(127, 43, 1, 1),
(128, 43, 2, 0),
(129, 43, 3, 0),
(130, 44, 1, 1),
(131, 44, 2, 0),
(132, 44, 3, 0),
(133, 45, 1, 1),
(134, 45, 2, 0),
(135, 45, 3, 0),
(136, 46, 1, 1),
(137, 46, 2, 0),
(138, 46, 3, 0),
(139, 47, 1, 1),
(140, 47, 2, 0),
(141, 47, 3, 0),
(142, 48, 1, 1),
(143, 48, 2, 0),
(144, 48, 3, 0),
(145, 49, 1, 1),
(146, 49, 2, 0),
(147, 49, 3, 0),
(148, 50, 1, 1),
(149, 50, 2, 0),
(150, 50, 3, 0),
(151, 51, 1, 1),
(152, 51, 2, 0),
(153, 51, 3, 0),
(154, 52, 1, 1),
(155, 52, 2, 0),
(156, 52, 3, 0),
(157, 53, 1, 1),
(158, 53, 2, 0),
(159, 53, 3, 0),
(160, 54, 1, 1),
(161, 54, 2, 0),
(162, 54, 3, 0),
(163, 55, 1, 1),
(164, 55, 2, 0),
(165, 55, 3, 0),
(166, 56, 1, 1),
(167, 56, 2, 0),
(168, 56, 3, 0),
(169, 57, 1, 1),
(170, 57, 2, 0),
(171, 57, 3, 0),
(172, 58, 1, 1),
(173, 58, 2, 0),
(174, 58, 3, 0),
(175, 59, 1, 1),
(176, 59, 2, 0),
(177, 59, 3, 0),
(178, 60, 1, 1),
(179, 60, 2, 0),
(180, 60, 3, 0),
(181, 61, 1, 1),
(182, 61, 2, 0),
(183, 61, 3, 0),
(184, 62, 1, 1),
(185, 62, 2, 0),
(186, 62, 3, 0),
(187, 63, 1, 1),
(188, 63, 2, 0),
(189, 63, 3, 0),
(190, 64, 1, 1),
(191, 64, 2, 0),
(192, 64, 3, 0),
(193, 65, 1, 1),
(194, 65, 2, 0),
(195, 65, 3, 0),
(196, 66, 1, 1),
(197, 66, 2, 0),
(198, 66, 3, 0),
(199, 67, 1, 1),
(200, 67, 2, 0),
(201, 67, 3, 0),
(202, 68, 1, 1),
(203, 68, 2, 0),
(204, 68, 3, 0),
(205, 69, 1, 1),
(206, 69, 2, 0),
(207, 69, 3, 0),
(208, 70, 1, 1),
(209, 70, 2, 0),
(210, 70, 3, 0),
(211, 71, 1, 1),
(212, 71, 2, 0),
(213, 71, 3, 0),
(214, 72, 1, 1),
(215, 72, 2, 0),
(216, 72, 3, 0),
(217, 73, 1, 1),
(218, 73, 2, 0),
(219, 73, 3, 0),
(220, 74, 1, 1),
(221, 74, 2, 0),
(222, 74, 3, 0),
(223, 75, 1, 1),
(224, 75, 2, 1),
(225, 75, 3, 1),
(226, 76, 1, 1),
(227, 76, 2, 0),
(228, 76, 3, 0),
(229, 77, 1, 1),
(230, 77, 2, 0),
(231, 77, 3, 0),
(232, 78, 1, 1),
(233, 78, 2, 0),
(234, 78, 3, 0),
(235, 79, 1, 1),
(236, 79, 2, 0),
(237, 79, 3, 0),
(238, 80, 1, 1),
(239, 80, 2, 0),
(240, 80, 3, 0),
(241, 81, 1, 1),
(242, 81, 2, 0),
(243, 81, 3, 0),
(244, 82, 1, 1),
(245, 82, 2, 0),
(246, 82, 3, 0),
(247, 83, 1, 1),
(248, 83, 2, 0),
(249, 83, 3, 0),
(250, 84, 1, 1),
(251, 84, 2, 0),
(252, 84, 3, 0),
(253, 85, 1, 1),
(254, 85, 2, 0),
(255, 85, 3, 0),
(256, 86, 1, 1),
(257, 86, 2, 0),
(258, 86, 3, 0),
(259, 87, 1, 1),
(260, 87, 2, 0),
(261, 87, 3, 0),
(262, 88, 1, 1),
(263, 88, 2, 0),
(264, 88, 3, 0),
(265, 89, 1, 1),
(266, 89, 2, 0),
(267, 89, 3, 0),
(268, 90, 1, 1),
(269, 90, 2, 0),
(270, 90, 3, 0),
(271, 91, 1, 1),
(272, 91, 2, 0),
(273, 91, 3, 0),
(274, 92, 1, 1),
(275, 92, 2, 0),
(276, 92, 3, 0),
(277, 93, 1, 1),
(278, 93, 2, 0),
(279, 93, 3, 0),
(280, 94, 1, 1),
(281, 94, 2, 0),
(282, 94, 3, 0),
(283, 95, 1, 1),
(284, 95, 2, 0),
(285, 95, 3, 0),
(286, 96, 1, 1),
(287, 96, 2, 0),
(288, 96, 3, 0),
(289, 97, 1, 1),
(290, 97, 2, 0),
(291, 97, 3, 0),
(292, 98, 1, 1),
(293, 98, 2, 0),
(294, 98, 3, 0),
(295, 99, 1, 1),
(296, 99, 2, 0),
(297, 99, 3, 0),
(298, 100, 1, 1),
(299, 100, 2, 0),
(300, 100, 3, 0),
(301, 101, 1, 1),
(302, 101, 2, 0),
(303, 101, 3, 0),
(304, 102, 1, 1),
(305, 102, 2, 0),
(306, 102, 3, 0),
(307, 103, 1, 1),
(308, 103, 2, 0),
(309, 103, 3, 0),
(310, 104, 1, 1),
(311, 104, 2, 0),
(312, 104, 3, 0),
(313, 105, 1, 1),
(314, 105, 2, 0),
(315, 105, 3, 0),
(316, 106, 1, 1),
(317, 106, 2, 0),
(318, 106, 3, 0),
(319, 107, 1, 1),
(320, 107, 2, 0),
(321, 107, 3, 0),
(322, 108, 1, 1),
(323, 108, 2, 0),
(324, 108, 3, 0),
(325, 109, 1, 1),
(326, 109, 2, 0),
(327, 109, 3, 0),
(328, 110, 1, 1),
(329, 110, 2, 0),
(330, 110, 3, 0),
(331, 111, 1, 1),
(332, 111, 2, 0),
(333, 111, 3, 0),
(334, 112, 1, 1),
(335, 112, 2, 0),
(336, 112, 3, 0),
(337, 113, 1, 1),
(338, 113, 2, 0),
(339, 113, 3, 0),
(340, 114, 1, 1),
(341, 114, 2, 0),
(342, 114, 3, 0),
(343, 115, 1, 1),
(344, 115, 2, 0),
(345, 115, 3, 0),
(346, 116, 1, 1),
(347, 116, 2, 0),
(348, 116, 3, 0),
(349, 117, 1, 1),
(350, 117, 2, 0),
(351, 117, 3, 0),
(352, 118, 1, 1),
(353, 118, 2, 0),
(354, 118, 3, 0),
(355, 119, 1, 1),
(356, 119, 2, 0),
(357, 119, 3, 0),
(358, 120, 1, 1),
(359, 120, 2, 0),
(360, 120, 3, 0),
(361, 121, 1, 1),
(362, 121, 2, 0),
(363, 121, 3, 0),
(364, 122, 1, 1),
(365, 122, 2, 0),
(366, 122, 3, 0),
(367, 123, 1, 1),
(368, 123, 2, 0),
(369, 123, 3, 0),
(370, 124, 1, 1),
(371, 124, 2, 0),
(372, 124, 3, 0),
(373, 125, 1, 1),
(374, 125, 2, 0),
(375, 125, 3, 0),
(376, 126, 1, 1),
(377, 126, 2, 0),
(378, 126, 3, 0),
(379, 127, 1, 1),
(380, 127, 2, 0),
(381, 127, 3, 0),
(382, 128, 1, 1),
(383, 128, 2, 0),
(384, 128, 3, 0),
(385, 129, 1, 1),
(386, 129, 2, 0),
(387, 129, 3, 0),
(388, 130, 1, 1),
(389, 130, 2, 0),
(390, 130, 3, 0),
(391, 131, 1, 1),
(392, 131, 2, 0),
(393, 131, 3, 0),
(394, 132, 1, 1),
(395, 132, 2, 0),
(396, 132, 3, 0),
(397, 133, 1, 1),
(398, 133, 2, 0),
(399, 133, 3, 0),
(400, 134, 1, 1),
(401, 134, 2, 0),
(402, 134, 3, 0),
(403, 135, 1, 1),
(404, 135, 2, 0),
(405, 135, 3, 0),
(406, 136, 1, 1),
(407, 136, 2, 0),
(408, 136, 3, 0),
(409, 137, 1, 1),
(410, 137, 2, 0),
(411, 137, 3, 0),
(412, 138, 1, 1),
(413, 138, 2, 0),
(414, 138, 3, 0),
(415, 139, 1, 1),
(416, 139, 2, 0),
(417, 139, 3, 0),
(418, 140, 1, 1),
(419, 140, 2, 0),
(420, 140, 3, 0),
(421, 141, 1, 1),
(422, 141, 2, 0),
(423, 141, 3, 0),
(424, 142, 1, 1),
(425, 142, 2, 0),
(426, 142, 3, 0),
(427, 143, 1, 1),
(428, 143, 2, 0),
(429, 143, 3, 0),
(430, 144, 1, 1),
(431, 144, 2, 1),
(432, 144, 3, 1);
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET FOREIGN_KEY_CHECKS = 1;