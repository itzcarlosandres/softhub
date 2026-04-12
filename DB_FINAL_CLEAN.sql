-- DATABASE FINAL CLEAN FOR CYBERPANEL (SoftHub v2.0)
-- --------------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Usuarios
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','editor') DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`username`, `password`, `name`, `email`, `role`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'admin@descargas.plus', 'admin');

-- 2. Categorías de Software
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT 'fa-cube',
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Software
DROP TABLE IF EXISTS `software`;
CREATE TABLE `software` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `license` varchar(50) DEFAULT 'free',
  `version` varchar(20) DEFAULT NULL,
  `developer` varchar(100) DEFAULT NULL,
  `operating_system` varchar(100) DEFAULT 'Windows',
  `price` varchar(20) DEFAULT 'Free',
  `buy_url` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 4.50,
  `rating_count` int(11) DEFAULT 0,
  `downloads` int(11) DEFAULT 0,
  `views` int(11) DEFAULT 0,
  `status` enum('approved','pending','rejected') DEFAULT 'approved',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_trending` tinyint(1) DEFAULT 0,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Enlaces de Descarga
DROP TABLE IF EXISTS `download_links`;
CREATE TABLE `download_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `software_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT 'Link',
  `url` varchar(255) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `type` varchar(20) DEFAULT 'direct',
  `click_count` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Licencias
DROP TABLE IF EXISTS `licenses`;
CREATE TABLE `licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `licenses` (`name`, `slug`, `description`) VALUES
('Free / Gratis', 'free', 'Software de uso gratuito'),
('Premium / Paid', 'premium', 'Software que requiere pago');

-- 6. Configuración del Sitio
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `setting_type` varchar(20) DEFAULT 'text',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('site_name', 'SoftHub v2', 'text', 'Nombre del sitio'),
('site_logo', '', 'text', 'Ruta del logo'),
('site_favicon', '', 'text', 'Ruta del favicon'),
('seo_title', 'SoftHub - Los Mejores Programas', 'text', 'Título SEO Global'),
('seo_description', 'Descarga software premium y gratis', 'text', 'Descripción SEO Global'),
('ai_enabled', '1', 'boolean', 'Activar funciones de IA'),
('gemini_api_key', '', 'text', 'Clave API de Google Gemini');

-- 7. Blog Categorías
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Blog Entradas (CORREGIDO blog_category_id)
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `blog_category_id` int(11) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `views` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
