-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-01-2026 a las 05:52:04
-- Versión del servidor: 10.11.15-MariaDB-ubu2204
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `foro_forohost`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `software_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `created_at`, `updated_at`, `software_count`) VALUES
(1, 'Navegadores', 'navegadores', 'Navegadores web modernos y rápidos', '🌐', '2025-12-20 00:52:19', '2025-12-20 02:44:22', 3),
(2, 'Multimedia', 'multimedia', 'Reproductores y editores de audio y video', '🎬', '2025-12-20 00:52:19', '2025-12-20 02:44:22', 2),
(3, 'Productividad', 'productividad', 'Herramientas para aumentar tu productividad', '📊', '2025-12-20 00:52:19', '2025-12-20 02:44:22', 2),
(4, 'Seguridad', 'seguridad', 'Antivirus y herramientas de seguridad', '🔒', '2025-12-20 00:52:19', '2025-12-20 02:44:22', 2),
(5, 'Comunicación', 'comunicacion', 'Mensajería y comunicación', '💬', '2025-12-20 00:52:19', '2025-12-20 02:44:22', 2),
(6, 'Desarrollo', 'desarrollo', 'Herramientas para desarrolladores', '💻', '2025-12-20 00:52:19', '2025-12-20 02:44:22', 2),
(7, 'Antivirus', 'antivirus', '', 'fa-solid fa-file-shield', '2025-12-20 17:13:20', '2025-12-20 17:13:20', 0),
(8, 'Firewall', 'firewall', 'Protección de red y control de tráfico', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(9, 'VPN', 'vpn', 'Redes privadas virtuales para privacidad y seguridad', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(10, 'Anti-Malware', 'anti-malware', 'Eliminación de malware y spyware', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(11, 'Descargas', 'descargas', 'Gestores de descargas y torrents', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(12, 'FTP', 'ftp', 'Clientes FTP para transferencia de archivos', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(13, 'Mensajería', 'mensajeria', 'Aplicaciones de chat y mensajería instantánea', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(14, 'Email', 'email', 'Clientes de correo electrónico', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(15, 'Reproductores de Video', 'reproductores-video', 'Reproductores multimedia y de video', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(16, 'Reproductores de Audio', 'reproductores-audio', 'Reproductores de música y audio', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(17, 'Editores de Video', 'editores-video', 'Software de edición de video', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(18, 'Editores de Audio', 'editores-audio', 'Software de edición de audio y música', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(19, 'Editores de Imagen', 'editores-imagen', 'Software de edición y retoque fotográfico', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(20, 'Conversores', 'conversores', 'Conversores de formatos multimedia', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(21, 'Streaming', 'streaming', 'Software para streaming y transmisión', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(22, 'Ofimática', 'ofimatica', 'Suites de oficina y procesadores de texto', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(23, 'PDF', 'pdf', 'Lectores y editores de PDF', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(24, 'Notas', 'notas', 'Aplicaciones para tomar notas', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(25, 'Gestión de Proyectos', 'gestion-proyectos', 'Software de gestión y planificación', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(26, 'Calendario', 'calendario', 'Calendarios y organizadores', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(27, 'Editores de Código', 'editores-codigo', 'IDEs y editores para programación', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(28, 'Bases de Datos', 'bases-datos', 'Gestores de bases de datos', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(29, 'Servidores Web', 'servidores-web', 'Servidores web y aplicaciones', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(30, 'Control de Versiones', 'control-versiones', 'Git y sistemas de control de versiones', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(31, 'Compresión', 'compresion', 'Compresores y descompresores de archivos', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(32, 'Limpieza', 'limpieza', 'Limpiadores y optimizadores del sistema', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(33, 'Recuperación de Datos', 'recuperacion-datos', 'Recuperación de archivos eliminados', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(34, 'Backup', 'backup', 'Software de copias de seguridad', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(35, 'Particiones', 'particiones', 'Gestores de particiones de disco', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(36, 'Drivers', 'drivers', 'Actualizadores de controladores', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(37, 'Sistemas Operativos', 'sistemas-operativos', 'Sistemas operativos y distribuciones', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(38, 'Virtualización', 'virtualizacion', 'Máquinas virtuales y emuladores', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(39, 'Monitoreo', 'monitoreo', 'Monitores de sistema y rendimiento', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(40, 'Diseño Gráfico', 'diseno-grafico', 'Software de diseño y creatividad', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(41, 'CAD', 'cad', 'Diseño asistido por computadora', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(42, '3D', '3d', 'Modelado y animación 3D', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(43, 'Juegos', 'juegos', 'Videojuegos y entretenimiento', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(44, 'Emuladores', 'emuladores', 'Emuladores de consolas y sistemas', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(45, 'Plataformas de Juegos', 'plataformas-juegos', 'Steam, Epic Games, etc.', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(46, 'Educación', 'educacion', 'Software educativo y de aprendizaje', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(47, 'Idiomas', 'idiomas', 'Aprendizaje de idiomas', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(48, 'Matemáticas', 'matematicas', 'Software matemático y científico', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(49, 'Redes', 'redes', 'Herramientas de red y diagnóstico', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(50, 'Acceso Remoto', 'acceso-remoto', 'Control remoto de equipos', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(51, 'Personalización', 'personalizacion', 'Temas y personalización del sistema', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(52, 'Fondos de Pantalla', 'fondos-pantalla', 'Wallpapers y fondos de escritorio', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0),
(53, 'Capturas de Pantalla', 'capturas-pantalla', 'Software para capturas y grabación de pantalla', NULL, '2025-12-28 23:05:49', '2025-12-28 23:05:49', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `download_links`
--

CREATE TABLE `download_links` (
  `id` int(11) NOT NULL,
  `software_id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL COMMENT 'Windows, Mac, Linux, Android, iOS',
  `version` varchar(50) DEFAULT NULL,
  `download_url` text NOT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `download_links`
--

INSERT INTO `download_links` (`id`, `software_id`, `platform`, `version`, `download_url`, `file_size`, `created_at`) VALUES
(14, 53, 'Windows', NULL, 'https://www.ccleaner.com/ccleaner/download/standard', '116 MB', '2025-12-20 06:51:29'),
(15, 54, 'Windows', NULL, 'https://www.dvdfab.cn/mlink/download.php?g=UniFab_x64_CNT', '380 MB', '2025-12-20 06:51:29'),
(16, 55, 'Windows', NULL, 'https://github.com/brave/brave-browser/releases/download/v1.85.117/BraveBrowserStandaloneSetup32.exe', '121 MB', '2025-12-20 06:51:29'),
(17, 56, 'Windows', '', 'https://cdn-download.ccleanerbrowser.com/ccleaner/ccleaner_browser_setup.exe', '6,83 MB', '2025-12-20 06:55:52'),
(18, 57, 'Windows', '', 'https://download-installer.cdn.mozilla.net/pub/firefox/releases/146.0.1/win64/en-US/Firefox%20Setup%20146.0.1.exe', '97 MB', '2025-12-20 07:02:11'),
(19, 57, 'Mac', '', 'https://download-installer.cdn.mozilla.net/pub/firefox/releases/146.0.1/mac/en-US/Firefox%20146.0.1.dmg', '133 MB', '2025-12-20 07:02:11'),
(20, 58, 'Windows', 'x86', 'https://get.geo.opera.com/pub/opera_gx/125.0.5729.47/win/Opera_GX_125.0.5729.47_Setup.exe', '', '2025-12-20 07:36:47'),
(21, 58, 'Windows', 'x64', 'https://get.geo.opera.com/pub/opera_gx/125.0.5729.47/win/Opera_GX_125.0.5729.47_Setup_x64.exe', '', '2025-12-20 07:36:47'),
(22, 58, 'Mac', 'Mac', 'https://net.geo.opera.com/opera_gx/stable/mac', '99 MB', '2025-12-20 07:36:47'),
(23, 58, 'Android', 'ARM', 'https://play.google.com/store/apps/details?id=com.opera.gx', '', '2025-12-20 07:36:47'),
(24, 59, 'Windows', '', 'https://downloads.malwarebytes.com/file/mb-windows', '2.17 MB', '2025-12-20 16:35:41'),
(25, 59, 'Mac', '', 'https://downloads.malwarebytes.com/file/mb-windows', '100 MB', '2025-12-20 16:35:41'),
(26, 60, 'Windows', '', 'https://securedownloads.superantispyware.com/SUPERAntiSpyware.exe', '', '2025-12-20 17:07:05'),
(27, 60, 'Windows', '', 'https://securedownloads.superantispyware.com/SUPERAntiSpywarePro.exe', '', '2025-12-20 17:07:05'),
(28, 61, 'Windows', '', 'https://free.drweb.com/download+cureit/gr/?lng=en', '216 MB', '2025-12-20 17:12:55'),
(29, 62, 'Windows', '64-bit', 'https://downloads.preyproject.com/prey-client-releases/node-client/1.13.22/prey-windows-1.13.22-x64.exe?_gl=1*17yfsdh*_gcl_au*MTcwNDY4NTQyOC4xNzY2NTA5MTMx*_ga*NjQyMzAxNjkzLjE3NjY1MDkxMzE.*_ga_PQML3KDTRV*czE3NjY1MDkxMzAkbzEkZzAkdDE3NjY1MDkxMzAkajYwJGwwJGgyMTYwMzc5NDE.', '99 MB', '2025-12-23 17:01:15'),
(30, 62, 'Windows', '32-bit', 'https://downloads.preyproject.com/prey-client-releases/node-client/1.13.22/prey-windows-1.13.22-x86.exe?_gl=1*17yfsdh*_gcl_au*MTcwNDY4NTQyOC4xNzY2NTA5MTMx*_ga*NjQyMzAxNjkzLjE3NjY1MDkxMzE.*_ga_PQML3KDTRV*czE3NjY1MDkxMzAkbzEkZzAkdDE3NjY1MDkxMzAkajYwJGwwJGgyMTYwMzc5NDE.', '99 MB', '2025-12-23 17:01:15'),
(31, 62, 'Mac', 'Mac-ARM', 'https://downloads.preyproject.com/prey-client-releases/node-client/1.13.22/prey-mac-1.13.22-arm64.pkg?_gl=1*17yfsdh*_gcl_au*MTcwNDY4NTQyOC4xNzY2NTA5MTMx*_ga*NjQyMzAxNjkzLjE3NjY1MDkxMzE.*_ga_PQML3KDTRV*czE3NjY1MDkxMzAkbzEkZzAkdDE3NjY1MDkxMzAkajYwJGwwJGgyMTYwMzc5NDE.', '68 MB', '2025-12-23 17:01:15'),
(32, 62, 'Mac', 'Mac-intel', 'https://downloads.preyproject.com/prey-client-releases/node-client/1.13.22/prey-mac-1.13.22-x64.pkg?_gl=1*1iv92fn*_gcl_au*MTcwNDY4NTQyOC4xNzY2NTA5MTMx*_ga*NjQyMzAxNjkzLjE3NjY1MDkxMzE.*_ga_PQML3KDTRV*czE3NjY1MDkxMzAkbzEkZzEkdDE3NjY1MDkyMDQkajYwJGwwJGgyMTYwMzc5NDE.', '68 MB', '2025-12-23 17:01:15'),
(33, 62, 'Linux', 'Ubuntu', 'https://downloads.preyproject.com/prey-client-releases/node-client/1.13.22/prey_1.13.22_amd64.deb?_gl=1*1iv92fn*_gcl_au*MTcwNDY4NTQyOC4xNzY2NTA5MTMx*_ga*NjQyMzAxNjkzLjE3NjY1MDkxMzE.*_ga_PQML3KDTRV*czE3NjY1MDkxMzAkbzEkZzEkdDE3NjY1MDkyMDQkajYwJGwwJGgyMTYwMzc5NDE.', '60 MB', '2025-12-23 17:01:15'),
(34, 62, 'Android', 'Android', 'https://play.google.com/store/apps/details?id=com.prey&utm_source=prey-website', '', '2025-12-23 17:01:15'),
(35, 63, 'Windows', '', 'https://build.cyberlink.com/Retail/Promeo/1GS0S0HZRDH6VBT/CyberLink_Promeo_Downloader.exe', '5,4MB', '2025-12-23 18:00:24'),
(36, 63, 'Android', '', 'https://play.google.com/store/apps/details?id=com.cyberlink.addirector', '', '2025-12-23 18:00:24'),
(37, 63, 'iOS', '', 'https://apps.apple.com/us/app/promeo-ai-marketing-studio/id1521599139', '', '2025-12-23 18:00:24'),
(38, 64, 'Windows', '', 'https://apps.microsoft.com/detail/9PM860492SZD?hl=en-US&gl=US', '', '2025-12-23 20:06:23'),
(39, 69, 'Windows', '', 'https://www.aimp.ru/?do=download.file&id=3', '17,6 MB', '2025-12-24 05:45:04'),
(40, 69, 'Android', '', 'https://play.google.com/store/apps/details?id=com.aimp.player', '', '2025-12-24 05:45:04'),
(41, 70, 'Windows', '', 'https://www.rarlab.com/rar/winrar-x64-713.exe', '3,9 MB', '2025-12-24 07:09:38'),
(42, 71, 'Windows', '', 'https://www.greatissoftware.com/unhackme.zip', '44.2 MB', '2025-12-24 19:43:00'),
(43, 72, 'Windows', '', 'https://artifacts.videolan.org/vlc/release-win64/vlc-3.0.23-win64.exe', '', '2025-12-25 17:55:07'),
(44, 73, 'Android', '', 'https://play.google.com/store/apps/details?id=com.bitdefender.security', '', '2025-12-25 17:58:25'),
(45, 74, 'Windows', '', 'https://github.com/amir1376/ab-download-manager/releases/download/v1.8.3/ABDownloadManager_1.8.3_windows_x64.exe', '', '2025-12-26 20:53:46'),
(46, 74, 'Windows', '', 'https://github.com/amir1376/ab-download-manager/releases/download/v1.8.3/ABDownloadManager_1.8.3_windows_x64.zip', '', '2025-12-26 20:53:46'),
(47, 74, 'Mac', '', 'https://github.com/amir1376/ab-download-manager/releases/download/v1.8.3/ABDownloadManager_1.8.3_mac_arm64.dmg', '', '2025-12-26 20:53:46'),
(48, 74, 'Android', '', 'https://github.com/amir1376/ab-download-manager/releases/download/v1.8.3/ABDownloadManager_1.8.3_android_universal.apk', '', '2025-12-26 20:53:46'),
(49, 75, 'Windows', 'x64', 'https://personal-backup.rathlev-home.de/download/pb-setup-x64-6.4.0500.exe', '22.2 MB', '2025-12-27 06:49:13'),
(50, 75, 'Windows', 'x64', 'https://personal-backup.rathlev-home.de/download/pb-setup-6.4.0500.exe', '22.2MB', '2025-12-27 06:49:13'),
(51, 76, 'Windows', '', 'https://download.viber.com/desktop/windows/ViberSetup.exe', ' 2.54 MB', '2025-12-27 20:05:43'),
(52, 76, 'Windows', '32-bit', 'https://download.cdn.viber.com/desktop/windows_32/ViberSetup.exe', '', '2025-12-27 20:05:43'),
(53, 76, 'Mac', '', 'https://download.cdn.viber.com/desktop/mac/Viber.dmg', '', '2025-12-27 20:05:43'),
(54, 76, 'Mac', '', 'https://download.cdn.viber.com/cdn/desktop/Linux/viber.deb', '', '2025-12-27 20:05:43'),
(55, 76, 'Android', '', 'https://play.google.com/store/apps/details?id=com.viber.voip', '', '2025-12-27 20:05:43'),
(56, 76, 'iOS', '', 'https://itunes.apple.com/app/viber-free-phone-calls/id382617920?mt=8', '', '2025-12-27 20:05:43'),
(57, 77, 'Windows', '64-bit', 'https://inkscape.org/gallery/item/58918/inkscape-signed.exe', '112 MB', '2025-12-27 20:18:00'),
(58, 77, 'Windows', '32-bit', 'https://inkscape.org/gallery/item/44618/inkscape-1.3.2_2023-11-25_091e20ef0f-x86.exe', '', '2025-12-27 20:18:00'),
(59, 77, 'Mac', '', 'https://inkscape.org/gallery/item/58921/Inkscape-1.4.333103_x86_64_lVG7DLz.dmg', '', '2025-12-27 20:18:00'),
(60, 77, 'Linux', '', 'https://inkscape.org/gallery/item/58919/Inkscape-0d15f75-x86_64.AppImage', '', '2025-12-27 20:18:00'),
(61, 78, 'Windows', '', 'https://download.drivereasy.com/DriverEasy_Setup.exe', '6.77 MB', '2025-12-27 21:51:41'),
(62, 79, 'Windows', '', 'https://www.drivermax.com/soft/dmx/drivermax.exe', '7.24 MB', '2025-12-27 22:58:15'),
(63, 80, 'Windows', '', 'https://github.com/ventoy/Ventoy/releases/download/v1.1.10/ventoy-1.1.10-windows.zip', '15.9 MB', '2025-12-27 23:15:23'),
(64, 80, 'Linux', '', 'https://github.com/ventoy/Ventoy/releases/download/v1.1.10/ventoy-1.1.10-linux.tar.gz', '15.9 MB', '2025-12-27 23:15:23'),
(65, 81, 'Windows', '', 'https://rescuedisk.s.kaspersky-labs.com/updatable/2018/krd.iso', '671 MB', '2025-12-28 22:09:17'),
(66, 89, 'Windows', '', 'https://srtcdnstorage.blob.core.windows.net/software/nextgen/titansftp/titansftp-win-x64.exe', '297 MB', '2025-12-30 17:28:12'),
(67, 89, 'Mac', '', 'https://srtcdnstorage.blob.core.windows.net/software/nextgen/titansftp/titansftp-linux-x64.run', '297 MB', '2025-12-30 17:28:12'),
(68, 90, 'Windows', '', 'https://www.goodsync.com/download/GoodSync-vsub-Setup.exe', '75.3 MB', '2025-12-31 08:59:03'),
(69, 90, 'Windows', 'Portable', 'https://www.goodsync.com/download/GoodSync-vsub-2Go-Setup.exe', '75.3 MB', '2025-12-31 08:59:03'),
(70, 90, 'Mac', '', 'https://www.goodsync.com/download/affs/goodsync-mac.dmg', '73.5 MB', '2025-12-31 08:59:03'),
(71, 90, 'Linux', '', 'http://www.goodsync.com/download/', '', '2025-12-31 08:59:03'),
(72, 90, 'Android', '', 'http://www.goodsync.com/download/', '', '2025-12-31 08:59:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `software_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `setting_type` varchar(50) DEFAULT 'text' COMMENT 'text, number, boolean, json',
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `updated_at`) VALUES
(1, 'home_latest_count', '18', 'number', 'Cantidad de programas en \"Últimos Agregados\" (Home)', '2025-12-30 16:50:00'),
(2, 'home_featured_count', '8', 'number', 'Cantidad de programas destacados (Home)', '2025-12-30 16:50:15'),
(3, 'home_top_downloads', '10', 'number', 'Cantidad de programas en TOP 10 (Sidebar)', '2025-12-20 07:09:17'),
(4, 'site_name', 'SoftHub - Descarga el mejor software seguro y gratis', 'text', 'Nombre del sitio', '2025-12-30 19:04:50'),
(5, 'site_description', 'Descarga el mejor software gratis', 'text', 'Descripción del sitio', '2025-12-20 07:09:17'),
(6, 'items_per_page', '24', 'number', 'Programas por página en listados', '2025-12-20 07:09:17'),
(7, 'seo_title', 'SoftHub - Descarga el mejor software seguro y gratis', 'text', 'Título principal del sitio para SEO', '2025-12-30 19:04:50'),
(8, 'seo_description', 'Descarga software gratuito y de pago para Windows, Mac y Android. Miles de programas actualizados y verificados.', 'textarea', 'Descripción del sitio para resultados de búsqueda', '2025-12-23 16:54:26'),
(9, 'seo_keywords', 'descargar software, programas gratis, aplicaciones, windows, mac, android', 'text', 'Palabras clave para SEO', '2025-12-23 16:54:26'),
(10, 'seo_download_title_template', 'Descargar {TITULO}', 'text', 'Plantilla para títulos de páginas de descarga', '2025-12-23 16:54:26'),
(11, 'seo_show_version_in_title', '1', 'boolean', 'Mostrar versión en el título de descarga', '2025-12-23 16:54:26'),
(12, 'seo_version_separator', 'v', 'text', 'Separador para la versión en el título', '2025-12-23 20:03:51'),
(37, 'site_logo', 'uploads/branding/694ad30ddc583.png', 'file', 'Logo del sitio (aparece en el header)', '2025-12-23 17:36:13'),
(38, 'site_favicon', 'uploads/branding/695405c627209.webp', 'file', 'Favicon del sitio (icono de la pestaña)', '2025-12-30 17:03:02'),
(54, 'logo_height', '84', 'number', 'Altura del logo en píxeles (30-100)', '2025-12-30 19:07:36'),
(69, 'logo_height_display', '84', 'text', NULL, '2025-12-30 19:07:36'),
(138, 'gemini_api_key', '', 'text', 'API Key de Google Gemini para generación de descripciones', '2025-12-24 19:41:13'),
(154, 'ai_enabled', '1', 'text', 'Habilitar generación automática con IA', '2025-12-30 19:07:15'),
(158, 'home_latest_layout', 'grid', 'text', NULL, '2025-12-31 15:20:07'),
(320, 'home_latest_grid_cols', '6', 'text', NULL, '2025-12-30 17:25:44'),
(340, 'home_latest_grid_cols_md', '4', 'text', NULL, '2025-12-30 16:56:03'),
(341, 'home_latest_grid_cols_sm', '2', 'text', NULL, '2025-12-30 16:56:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_statistics`
--

CREATE TABLE `site_statistics` (
  `id` int(11) NOT NULL,
  `stat_date` date NOT NULL,
  `total_downloads` int(11) DEFAULT 0,
  `total_software` int(11) DEFAULT 0,
  `total_categories` int(11) DEFAULT 0,
  `total_reviews` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `site_statistics`
--

INSERT INTO `site_statistics` (`id`, `stat_date`, `total_downloads`, `total_software`, `total_categories`, `total_reviews`, `created_at`) VALUES
(1, '2025-12-26', 25, 20, 7, 0, '2025-12-26 17:35:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software`
--

CREATE TABLE `software` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `developer` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `download_url` varchar(500) DEFAULT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `license` varchar(100) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL,
  `downloads` int(11) DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `rating_count` int(11) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `badge_editors_choice` tinyint(1) DEFAULT 0,
  `badge_trending` tinyint(1) DEFAULT 0,
  `badge_new` tinyint(1) DEFAULT 0,
  `badge_updated` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `operating_system` varchar(100) DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `icon` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `software`
--

INSERT INTO `software` (`id`, `name`, `slug`, `description`, `short_description`, `version`, `developer`, `category_id`, `image`, `download_url`, `file_size`, `license`, `os`, `downloads`, `rating`, `rating_count`, `featured`, `badge_editors_choice`, `badge_trending`, `badge_new`, `badge_updated`, `status`, `created_at`, `updated_at`, `operating_system`, `requirements`, `icon`) VALUES
(53, 'CCleaner ', 'ccleaner', 'CCleaner sigue siendo la herramienta líder para limpiar y optimizar PC con Windows. Mejora la privacidad, optimiza la velocidad del sistema y refuerza la seguridad. Con la limpieza con un solo clic, los principiantes pueden optimizar sus ordenadores en segundos, mientras que los usuarios avanzados se benefician de un completo conjunto de funciones. Tanto si eres un usuario ocasional como un profesional con conocimientos tecnológicos, acelerar un ordenador lento sin actualizar el hardware es mucho más fácil gracias a las eficientes herramientas de optimización del sistema de CCleaner.\r\n\r\nCCleaner es una herramienta gratuita de optimización del sistema y privacidad que ayuda a mejorar el rendimiento de su PC. Elimina archivos no utilizados del sistema, lo que permite que Windows funcione más rápido y libera valioso espacio en el disco duro. El software también limpia los rastros de sus actividades en línea, incluyendo el historial de navegación y los archivos temporales de Internet.\r\n\r\nLa herramienta se ejecuta directamente desde una unidad USB, lo que la hace portátil y fácil de usar en varios ordenadores. Los usuarios pueden personalizar el proceso de limpieza especificando los archivos, carpetas o claves de registro que deseen excluir. Esta flexibilidad convierte a CCleaner en una práctica herramienta de optimización del sistema para un rendimiento de Windows más rápido.\r\n\r\nUna de sus mejores características es su velocidad. CCleaner se ejecuta en segundos, ofreciendo resultados rápidos sin ralentizar tu flujo de trabajo. No contiene spyware ni adware, lo que garantiza una experiencia limpia, segura y confiable en cada uso.', 'CCleaner sigue siendo la herramienta líder para limpiar y optimizar PC con Windows. Mejora la privacidad, optimiza la velocidad del sistema y refuerza la seguridad. Con la limpieza con un solo clic', 'v7.03.1130', 'CCleaner', 3, '/uploads/images/694638862e12e.png', 'https://www.ccleaner.com/ccleaner/download/standard', '116 MB', 'free', NULL, 6, 5.00, 1, 1, 1, 1, 1, 0, 'approved', '2025-12-20 05:47:50', '2026-01-08 16:21:50', 'Windows', 'Windows 11 (64 bits)\r\nWindows 10 (todas las ediciones, incluida la de 64 bits)\r\nWindows 8 (todas las ediciones, incluida la de 64 bits)\r\nWindows 7 (todas las ediciones, incluida la de 64 bits)\r\nWindows 2003, 2008 y 2012 Server (todas las ediciones)\r\nApple Mac con macOS 10.10 de 64 bits y superior.', '/uploads/icons/694638862e396.png'),
(54, 'UniFab ', 'unifab', 'UniFab de DVDFab es su solución de video definitiva y completa, que le permite convertir, comprimir y editar eficientemente más de 1000 formatos de video. Esto garantiza una reproducción fluida y de alta calidad en prácticamente cualquier dispositivo, sin comprometer la calidad del video original.\r\n\r\nComo conversor de vídeo fiable, UniFab permite una conversión fluida entre más de 1000 formatos de vídeo, garantizando la reproducción en prácticamente cualquier dispositivo móvil o portátil sin sacrificar la calidad. Esto significa que puedes convertir fácilmente cualquier vídeo a un formato perfectamente compatible con tus dispositivos, permitiéndote reproducir y disfrutar de tu contenido favorito en tu smartphone dondequiera que estés.\r\n\r\nAcceda a 8 herramientas avanzadas en una sola suite para mejorar sus proyectos de video y audio con escalado a 8K, reducción de ruido, conversión HDR y más: perfecto para usuarios que buscan mejorar su experiencia de visualización de videos.\r\n\r\nIA de eliminación de ruido\r\nEstabilizador de vídeo con IA\r\nMezcla ascendente de audio con IA\r\nDesentrelazado IA\r\nMejora de escala de video con IA\r\nIA más fluida\r\nConvertidor ascendente HDR AI\r\nConvertidor de vídeo\r\nUniFab All-In-One es la herramienta de mejora de video/audio de vanguardia con IA. Mejora videos a resolución hasta 8K/HDR. Convierte pistas de audio a EAC3 5.1/DTS 7.1.', 'UniFab de DVDFab es su solución de video definitiva y completa, que le permite convertir, comprimir y editar eficientemente más de 1000 formatos de video', '3.0.3.4', 'UniFab ', 2, NULL, 'https://www.dvdfab.cn/mlink/download.php?g=UniFab_x64_CNT', '380 MB', 'free', NULL, 1, 0.00, 0, 1, 0, 0, 1, 0, 'approved', '2025-12-20 06:31:08', '2026-01-08 16:22:42', 'Windows', 'Requisitos del sistema\r\nWindows 11, 10 (64 bits)\r\nIntel i3 o superior\r\n4 GB de RAM o más\r\n40 GB de espacio libre en el disco duro o más\r\nSe requiere conexión a Internet en vivo', 'uploads/icons/694642ac43ec1.webp'),
(55, 'Brave Browser ', 'brave-browser', 'Brave Browser es un navegador web gratuito, rápido y seguro, basado en Chromium, para todos tus dispositivos. Incluye un bloqueador de anuncios que previene automáticamente los rastreadores y protege tu privacidad. Esto no solo te mantiene seguro, sino que también optimiza el rendimiento de tus datos y batería para una navegación más rápida y fluida.\r\n\r\nBrave es más que un simple navegador web: representa un nuevo enfoque sobre cómo debería funcionar la web. Su misión es mejorar la web ofreciendo a los usuarios una experiencia de navegación más segura, rápida y eficiente, a la vez que apoya a los creadores de contenido mediante un innovador sistema de recompensas basado en la atención.\r\n\r\nEste navegador fue creado por un equipo de innovadores centrados en la privacidad y el rendimiento, entre ellos el inventor de JavaScript y el cofundador de Mozilla. Comienza por devolverte el control. Experimenta velocidad, seguridad y privacidad inigualables mediante el bloqueo de rastreadores. Gana recompensas al suscribirte a nuestros anuncios que respetan la privacidad y ayudar a los editores a recibir su parte justa de los ingresos de Internet.', 'Brave Browser es un navegador web gratuito, rápido y seguro, basado en Chromium, para todos tus dispositivos.', '1.85.118', 'Brave ', 6, NULL, 'https://github.com/brave/brave-browser/releases/download/v1.85.117/BraveBrowserStandaloneSetup32.exe', '121 MB', 'free', NULL, 3, 4.00, 1, 1, 1, 1, 1, 0, 'approved', '2025-12-20 06:48:22', '2026-01-08 16:23:02', 'Windows', 'Windows 10 o posterior\r\nmacOS Big Sur 11 o posterior\r\nUbuntu 18.04+ de 64 bits, Mint 19+, Debian 10+, openSUSE 15+, Fedora 28+ y Rocky 9+\r\niOS 15.0 o posterior.\r\nAndroid 8.0 o posterior', 'uploads/icons/694646b60eddd.png'),
(56, 'CCleaner Browser', 'ccleaner-browser', 'CCleaner Browser es un navegador web rápido, privado y seguro basado en Chromium para Windows. Incluye funciones de seguridad y privacidad integradas para mejorar la seguridad en línea. Equipado con herramientas esenciales, te ayuda a gestionar tu privacidad en línea, tu identidad y tus datos personales de forma eficiente.\r\n\r\nCleaner Browser es una aplicación ligera que utiliza hasta un 50 % menos de memoria gracias a su rendimiento mejorado y mayor velocidad. Esta mejora garantiza una experiencia de navegación más fluida y eficiente. Las pestañas no utilizadas se suspenden automáticamente en segundo plano según la memoria disponible del ordenador. Esta configuración se puede ajustar en la sección \"Administrador de Rendimiento\" de la página de configuración del navegador.\r\n\r\nNavegación más rápida . Bloquea los anuncios molestos, lo que reduce la carga y agiliza la navegación.\r\nPrivacidad total . Detiene los rastreadores y oculta tu huella digital, para que tu identidad permanezca anónima.\r\nSeguridad total . Navega, las tiendas y las instituciones financieras saben que estás protegido contra malware, estafas de phishing y robo de identidad.\r\nCCleaner Browser puede prolongar la duración de la batería hasta un 20%, permitiéndote navegar sin necesidad de conectarte a la red durante más tiempo. Normalmente, los navegadores pueden agotar considerablemente la batería de tu portátil. Sin embargo, algunas mejoras inteligentes permiten que el navegador use menos CPU y RAM cuando la batería está baja. Estos ajustes pueden prolongar la duración de la batería hasta un 20%, así que no tendrás que cargarla tan pronto. Puedes gestionar estas opciones para aumentar la duración de la batería desde la sección \"Administrador de Rendimiento\" de la página de configuración del navegador.', 'CCleaner Browser es un navegador web rápido, privado y seguro basado en Chromium para Windows.', '143.0.33333.52 ', 'CCleaner ', 1, NULL, '', '6,83 MB', 'free', NULL, 4, 3.00, 1, 1, 1, 1, 1, 0, 'approved', '2025-12-20 06:55:52', '2026-01-08 16:25:07', 'Windows', 'Sistemas operativos compatibles : Windows 11, 10.\r\n\r\n', 'uploads/icons/69464878d3b2a.png'),
(57, 'Firefox ', 'firefox', '<p><strong>Firefox </strong> es un navegador web moderno y eficiente que te permite navegar por Internet de forma r&aacute;pida y segura.</p>\r\n<p>Ofrece navegaci&oacute;n por pesta&ntilde;as, sincronizaci&oacute;n entre dispositivos, modo inc&oacute;gnito y protecci&oacute;n contra rastreadores.</p>\r\n<p>Ideal para usuarios que buscan velocidad, privacidad y una interfaz intuitiva.</p>\r\n<h3>Caracter&iacute;sticas Destacadas:</h3>\r\n<ul>\r\n<li>Interfaz moderna e intuitiva</li>\r\n<li>Alto rendimiento y optimizaci&oacute;n</li>\r\n<li>Actualizaciones regulares</li>\r\n<li>F&aacute;cil de usar</li>\r\n</ul>\r\n<p>Descarga <strong>Firefox </strong> ahora y descubre todas sus funcionalidades.</p>', 'Navegador web rápido, privado y seguro con funciones personalizables para una mejor experiencia en línea', '146.0.1', 'Firefox ', 1, NULL, 'https://www.ccleaner.com/ccleaner/download/standard', '97  MB', 'free', NULL, 8, 5.00, 1, 1, 1, 1, 1, 0, 'approved', '2025-12-20 07:02:11', '2026-01-08 16:21:33', 'Windows', 'Requisitos del sistema de Firefox:\r\nSistemas operativos Windows (32 bits y 64 bits)\r\nWindows 11\r\nWindows 10\r\nSistemas operativos Mac:\r\nmacOS 10.15\r\nmacOS 11\r\nmacOS 12\r\nmacOS 13', 'uploads/icons/694649f366cca.png'),
(58, 'Opera GX ', 'opera-gx', 'Opera GX Gaming Browser es una versión personalizada del navegador web Opera , diseñada para mejorar tu experiencia de juego. Este navegador incluye herramientas exclusivas que optimizan tanto la experiencia de juego como la navegación. Ofrece funciones enfocadas en juegos, como control de recursos, una opción de acceso permanente a juegos e integración con Razer Chroma.\r\n\r\nEl nuevo navegador Opera GX ofrece una apariencia y una experiencia distintas a las del navegador Opera estándar, con opciones de personalización únicas diseñadas para gamers. Si bien Opera cuenta con su propia tienda de extensiones, sus navegadores también son compatibles con las extensiones de Google Chrome . Esto convierte a Opera GX en una excelente opción para quienes buscan un navegador enfocado en juegos con limitadores de CPU y RAM para mejorar el rendimiento.\r\n\r\nEl limitador de RAM de GX Control le permite elegir la cantidad de memoria que utiliza el navegador Opera GX. La configuración predeterminada del limitador de RAM busca un equilibrio entre el uso de memoria y la experiencia.', 'Navegador de juegos gratuito con control de CPU, RAM y ancho de banda, bloqueador de anuncios y compatibilidad con Discord y Twitch.\r\n', '125.0.5729.61', 'Opera ', 1, NULL, '', '99 MB', 'free', NULL, 7, 5.00, 1, 1, 0, 1, 1, 0, 'approved', '2025-12-20 07:36:47', '2026-01-08 16:22:19', 'Windows, Mac, Android', 'Sistemas operativos compatibles:\r\nVentanas 11, 10.\r\nmacOS 10.13 o posterior\r\nAndroid 9 o posterior\r\niOS 15.0 o posterior', 'uploads/icons/6946520f13a4c.png'),
(59, 'Malwarebytes ', 'malwarebytes', 'Malwarebytes es un programa antimalware avanzado diseñado para proteger tu ordenador incluso de las amenazas más sofisticadas. Va más allá del software antivirus tradicional, ya que supervisa activamente cada proceso y detiene la actividad maliciosa incluso antes de que se inicie. Malwarebytes detecta y elimina amenazas que otros programas de seguridad suelen pasar por alto, ofreciéndote protección fiable en tiempo real.\r\n\r\nEste programa de seguridad de última generación va más allá de los antivirus tradicionales para protegerte de las amenazas más avanzadas (día cero). Su Módulo de Protección Proactiva mantiene tu sistema seguro mediante análisis heurístico avanzado para detener procesos maliciosos antes de que se inicien.\r\n\r\nMalwarebytes cuenta con un historial comprobado de protección integral de computadoras contra todo tipo de malware. El software está diseñado para eliminar por completo virus, troyanos, spyware, adware y rootkits, garantizando así la limpieza y seguridad de su sistema.\r\n\r\nEste software de seguridad integral ofrece protección integral al integrar antimalware, antiransomware, antiexploit y protección contra sitios web maliciosos en una única y potente solución. Además, incorpora un nuevo motor de análisis cuatro veces más rápido que las versiones anteriores, lo que garantiza un análisis de seguridad rápido y eficiente.', 'Antivirus en tiempo real con analizador heurístico, protección contra rootkits y defensa proactiva contra malware', '5.4.5.226', 'Malwarebytes ', 4, NULL, '', '', 'trial', NULL, 3, 2.00, 1, 0, 0, 1, 1, 0, 'approved', '2025-12-20 16:35:41', '2026-01-08 16:22:50', 'Windows, Mac', 'Sistemas operativos compatibles : Windows 7, 8, 8.1, 10, 11 (32 bits y 64 bits).\r\n\r\nIdiomas disponibles : inglés, albanés, árabe, bosnio, búlgaro, catalán, chino simplificado, chino tradicional, croata, checo, danés, holandés, estonio, finlandés, francés, alemán, griego, hebreo, húngaro, italiano, coreano, letón, macedonio, noruego, polaco, portugués, rumano, ruso, serbio, eslovaco, esloveno, español, sueco, turco, ucraniano.', 'uploads/icons/6946d05d272e8.webp'),
(60, 'SUPERAntiSpyware ', 'superantispyware', 'SUPERAntiSpyware está diseñado para detectar y eliminar miles de amenazas maliciosas, incluyendo spyware, adware, malware, troyanos, keyloggers, dialers, secuestradores y gusanos. Utiliza numerosas tecnologías únicas y potentes, logrando eliminar con éxito amenazas de spyware que otras aplicaciones de seguridad suelen pasar por alto. Esto lo convierte en una herramienta muy eficaz y necesaria para quienes buscan eliminar malware persistente que el software antivirus convencional no puede abordar.\r\n\r\nLa tecnología de escaneo multidimensional e interrogación de procesos de la herramienta proporciona una detección avanzada de spyware que las soluciones de la competencia suelen pasar desapercibidas. Esto incluye la eliminación sencilla de amenazas persistentes como WinFixer, SpyAxe, SpyFalcon y miles de otros programas maliciosos. Esta capacidad de escaneo avanzado es un factor clave para los usuarios que buscan una detección y eliminación superiores de amenazas de malware propietario y complejo.\r\n\r\nSUPERAntiSpyware Professional ofrece un conjunto premium de funciones, incluyendo el bloqueo esencial de amenazas en tiempo real, la comodidad del análisis programado y un servicio de atención al cliente gratuito e ilimitado por correo electrónico. Esto convierte a la versión Professional en la opción ideal para quienes buscan protección completa y permanente, y un soporte al cliente fiable para sus necesidades antispyware.\r\n\r\nEl software también incluye una función de reparación dedicada que permite restaurar diversas configuraciones del sistema y del navegador, frecuentemente alteradas por programas maliciosos, que no suelen corregirse simplemente eliminando el parásito. Esta herramienta es fundamental para que los usuarios restauren la integridad del sistema tras un ataque de malware, reparando las configuraciones dañadas que persisten incluso después de eliminar la amenaza inicial.', 'Detecta y elimina spyware, malware y adware para proteger tu PC de amenazas ocultas.', '10.0.1282 ', 'SUPERAntiSpyware ', 4, NULL, '', '', 'freemium', NULL, 1, 5.00, 1, 0, 0, 0, 1, 0, 'approved', '2025-12-20 17:07:05', '2026-01-08 16:22:46', 'Windows', 'Sistemas operativos compatibles : Windows 7, 8, 8.1, 10, 11 (32 bits y 64 bits).\r\n\r\nIdiomas disponibles : inglés, albanés, árabe, bosnio, búlgaro, catalán, chino simplificado, chino tradicional, croata, checo, danés, holandés, estonio, finlandés, francés, alemán, griego, hebreo, húngaro, italiano, coreano, letón, macedonio, noruego, polaco, portugués, rumano, ruso, serbio, eslovaco, esloveno, español, sueco, turco, ucraniano.', 'uploads/icons/6946d7b97310e.png'),
(61, 'Dr.Web CureIt ', 'dr-web-cureit', 'Dr.Web CureIt 2025 es una utilidad gratuita e intuitiva, diseñada específicamente para eliminar virus y diversos programas maliciosos de su ordenador. El escáner antivirus integrado funciona con el motor de escaneo Dr.Web, el potente núcleo presente en todos los productos Dr.Web, que garantiza un nivel de detección de virus excepcionalmente alto.\r\n\r\nDr.Web CureIt! Detecta y neutraliza una amplia gama de malware, incluyendo gusanos, virus, troyanos, rootkits, spyware, dialers, adware y herramientas de hacking. También encuentra y elimina otros objetos maliciosos que podrían haber pasado desapercibidos para su software antivirus actual.\r\n\r\nAnalice y limpie rápidamente su equipo Windows con esta aplicación. Elimina eficazmente las infecciones sin necesidad de instalar Dr.Web Antivirus.\r\n\r\nAnalice y elimine rápidamente amenazas maliciosas de su computadora con Dr.Web CureIt. ¡No requiere instalación! Este potente escáner de malware le permite monitorear su sistema sin desactivar su antivirus.\r\n\r\nDr.Web CureIt! 2025 contiene las bases de datos de virus Dr.Web más actualizadas, actualizadas hasta dos veces por hora durante períodos de alta actividad de malware.\r\n\r\nEsta utilidad es la solución ideal cuando no es posible instalar un antivirus debido a la actividad de virus u otras razones. Sin necesidad de instalación, este software funciona en sistemas operativos Microsoft Windows y Windows Server de 32 y 64 bits. Se actualiza constantemente con las últimas bases de datos de virus Dr.Web para garantizar su eficacia contra todas las amenazas de virus y otros programas maliciosos. Además, define automáticamente el idioma utilizado por su sistema operativo.', 'Un escáner de malware gratuito y portátil que detecta y elimina virus sin instalación.', '14/12/2025', 'Dr.Web', 7, NULL, 'https://free.drweb.com/download+cureit/gr/?lng=en', '264 MB', 'free', NULL, 6, 5.00, 3, 0, 1, 1, 1, 0, 'approved', '2025-12-20 17:12:55', '2026-01-08 16:21:01', 'Windows', '', 'uploads/icons/6946d9ac90029.png'),
(62, 'Prey ', 'prey', 'Prey te da la tranquilidad de rastrear y localizar tu laptop, celular y tableta en caso de robo o extravío. Este software potente, ligero y de código abierto te brinda control remoto completo sobre todos tus dispositivos desde una única y práctica plataforma, 24/7.\r\n\r\nEl software permite identificar rápidamente al responsable (mediante fotos de la cámara web), monitorear la actividad de su dispositivo (mediante capturas de pantalla) y rastrear su ubicación exacta mediante geoposicionamiento GPS o Wi-Fi. Esto facilita una recuperación eficaz del dispositivo.\r\n\r\nAsí funciona : instalas un pequeño agente en tu PC o teléfono móvil. Este permanece inactivo, listo para recibir una señal remota y entrar en acción, realizando sus tareas críticas.\r\n\r\nEsta señal puede enviarse por internet o mediante un mensaje SMS. Al activarse, permite recopilar información vital, como la ubicación, el hardware y el estado de la red del dispositivo, y, opcionalmente, activar acciones específicas en el dispositivo.\r\n\r\nPuedes averiguar rápidamente dónde se encuentra tu ordenador, quién lo usa y qué hace en él gracias al potente sistema de informes de Prey. Al marcar tu dispositivo como desaparecido, Prey recopilará toda la información solicitada y la enviará a tu cuenta del Panel de Control o directamente a tu buzón, según el método de informe que elijas.\r\n\r\nAdemás de recopilar datos, Prey te permite ejecutar acciones críticas a distancia. Puedes activar una alarma sonora o mostrar un mensaje personalizado en el dispositivo. Fundamentalmente, el software te permite borrar de forma remota contraseñas confidenciales almacenadas, proteger tus datos y tu PC, previniendo eficazmente el uso no autorizado. Estas funciones te garantizan un control total.', 'Software de seguimiento de dispositivos con control remoto, protección de datos y funciones de ubicación en tiempo real', '1.13.22 ', 'Prey ', 4, NULL, '', '', 'free', NULL, 5, 0.00, 0, 1, 0, 1, 1, 0, 'approved', '2025-12-23 17:01:15', '2026-01-08 16:21:21', 'Windows, Mac, Linux, Android', '', 'uploads/icons/694acadbac4a0.webp'),
(63, 'CyberLink Promeo ', 'cyberlink-promeo', 'CyberLink Promeo está diseñado para ayudarte a crear videos y gráficos impactantes para redes sociales y uso promocional con rapidez y facilidad. Su moderno storyboard y un enfoque basado en plantillas simplifican la creación de videos cortos y visuales para plataformas como YouTube, Instagram, Twitter y TikTok.\r\n\r\nA diferencia de los editores avanzados de líneas de tiempo y multipista como PowerDirector 365, que se centran en la producción de vídeo a gran escala y los ajustes detallados, Promeo está diseñado para la creación rápida de contenido. Prioriza la simplicidad y la eficiencia, lo que lo hace ideal para vídeos de marketing de formato corto en lugar de proyectos de vídeo largos.\r\n\r\nEsta aplicación integral de diseño y edición de video promocional te ayuda a crear contenido atractivo para publicaciones en redes sociales, pósteres, invitaciones, folletos y más. Promeo te permite diseñar videos y gráficos de calidad profesional en minutos, incluso sin experiencia previa en diseño, lo que la convierte en una opción práctica para creadores y profesionales del marketing que buscan resultados impecables rápidamente.', 'Una suite de diseño creativo creada para imágenes sociales, videos promocionales y flujos de trabajo rápidos basados ​​en plantillas.\r\n', '8.16.4718.0', 'CyberLink', 2, NULL, '', '', 'free', NULL, 3, 0.00, 0, 1, 1, 1, 1, 0, 'approved', '2025-12-23 18:00:24', '2026-01-08 17:05:18', 'Windows, Android, iOS', 'Sistemas operativos compatibles:\r\nWindows 11, 10 (solo SO de 64 bits, compatible con Windows 11 Arm64)\r\nAndroid 8 o posterior\r\niOS 13.0 o posterior.', 'uploads/icons/694ad8b8685b8.webp'),
(64, 'Microsoft PC Manager', 'microsoft-pc-manager', '```html\r\n<p><strong>Microsoft PC Manager</strong> es una herramienta de <strong>optimización de sistema</strong> desarrollada por Microsoft para mejorar el <strong>rendimiento de Windows</strong> y mantener tu PC en óptimas condiciones. Simplifica la gestión del sistema con funciones integradas para <strong>limpieza de archivos</strong>, <strong>gestión de almacenamiento</strong> y protección contra amenazas.</p>\r\n<h2>Características Principales</h2>\r\n<ul>\r\n<li><strong>Optimización con un clic:</strong> Realiza una limpieza rápida y completa del sistema con solo un clic, liberando espacio y mejorando la velocidad.</li>\r\n<li><strong>Gestión de almacenamiento:</strong> Identifica y elimina archivos grandes e innecesarios para optimizar el espacio en disco.</li>\r\n<li><strong>Protección contra amenazas:</strong> Ofrece protección básica contra malware y otras amenazas en línea.</li>\r\n</ul>\r\n<p><strong>Microsoft PC Manager</strong> es ideal para usuarios que buscan una forma sencilla y eficaz de mantener su PC funcionando de forma <strong>fluida y segura</strong>, prolongando su vida útil y mejorando la <strong>experiencia general del usuario</strong>.</p>\r\n```', 'Optimiza y mantiene tu PC con esta herramienta de Microsoft. Limpia, acelera y protege tu sistema para un rendimiento óptimo.', '3.19.1.0', 'Microsoft', 6, NULL, '', '', 'free', NULL, 1, 0.00, 0, 0, 0, 0, 1, 0, 'approved', '2025-12-23 20:06:23', '2026-01-08 16:22:55', 'Windows', '', 'uploads/icons/694af63f68187.png'),
(65, 'WhatsApp para PC ', 'whatsapp-para-pc', '<p><strong>WhatsApp para PC</strong> es la aplicaci&oacute;n de escritorio oficial de WhatsApp, que permite a los usuarios <strong>sincronizar sus chats</strong> y mensajes directamente desde su tel&eacute;fono a su computadora. Disfrute de una experiencia de mensajer&iacute;a fluida y eficiente en su <strong>entorno de escritorio</strong>, facilitando la comunicaci&oacute;n con amigos, familiares y colegas.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Sincronizaci&oacute;n en Tiempo Real:</strong> Mant&eacute;n tus conversaciones actualizadas en todos tus dispositivos, con mensajes sincronizados instant&aacute;neamente.</li>\r\n<li><strong>Notificaciones de Escritorio:</strong> Recibe notificaciones directamente en tu escritorio para no perderte ning&uacute;n mensaje importante.</li>\r\n<li><strong>Compartir Archivos F&aacute;cilmente:</strong> Env&iacute;a y recibe fotos, videos y documentos directamente desde tu PC, simplificando el intercambio de informaci&oacute;n.</li>\r\n<li><strong>Llamadas y Videollamadas:</strong> Realiza llamadas de voz y videollamadas gratuitas a tus contactos de WhatsApp desde tu computadora.</li>\r\n</ul>\r\n<p><strong>WhatsApp para PC</strong> ofrece la comodidad de <strong>chatear desde tu ordenador</strong>, aumentando la productividad al permitirte responder mensajes r&aacute;pidamente mientras trabajas. Disfruta de una <strong>experiencia de mensajer&iacute;a ininterrumpida</strong> y una gesti&oacute;n de conversaciones m&aacute;s eficiente, con la seguridad y la <strong>privacidad</strong> que caracterizan a WhatsApp.</p>', 'WhatsApp en tu PC: Mensajes, llamadas y archivos sincronizados. Comunícate fácil y rápido desde tu escritorio.', '2.2587.9.0 ', 'WhatsApp ', 5, NULL, '', '', 'free', NULL, 2, 0.00, 0, 0, 0, 0, 1, 0, 'approved', '2025-12-23 20:15:14', '2026-01-08 16:22:34', '', '', 'uploads/icons/694af852b48c5.jpg'),
(66, 'Telegram ', 'telegram', '<p><strong>Telegram Antivirus</strong> es una innovadora soluci&oacute;n de seguridad, desarrollada por Telegram, dise&ntilde;ada para <strong>proteger tus conversaciones y datos</strong> dentro de la plataforma. Ofrece <strong>an&aacute;lisis en tiempo real de archivos</strong> y enlaces compartidos, garantizando un <strong>entorno de comunicaci&oacute;n seguro y libre de amenazas</strong>. Con Telegram Antivirus, disfrute de la tranquilidad de saber que su experiencia en Telegram est&aacute; protegida contra malware y contenido malicioso.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>An&aacute;lisis en Tiempo Real:</strong> Escanea autom&aacute;ticamente todos los archivos y enlaces compartidos en tus chats para detectar amenazas potenciales.</li>\r\n<li><strong>Protecci&oacute;n Contra Malware:</strong> Identifica y bloquea la descarga de archivos maliciosos, previniendo infecciones en tu dispositivo.</li>\r\n<li><strong>Filtrado de Enlaces Maliciosos:</strong> Detecta y advierte sobre enlaces que puedan redirigir a sitios web peligrosos o de phishing.</li>\r\n<li><strong>Integraci&oacute;n Seamless:</strong> Funciona de forma transparente dentro de la aplicaci&oacute;n Telegram, sin interrumpir tu experiencia de usuario.</li>\r\n</ul>', 'Protección integral y comunicación segura en una sola app. Telegram: tu escudo antivirus para chats y archivos.', '25.10.10528.0', 'Telegram ', 7, NULL, '', '', 'free', NULL, 1, 0.00, 0, 0, 0, 0, 1, 0, 'approved', '2025-12-23 20:17:32', '2026-01-08 16:22:26', '', '', 'uploads/icons/694af8dcd0226.webp'),
(68, 'YouTube Downloader ', 'youtube-downloader', '<p><strong>YouTube Downloader</strong> es la herramienta definitiva para <strong>descargar videos de YouTube de forma r&aacute;pida y sencilla</strong>. Disfrute de sus videos favoritos sin conexi&oacute;n a internet y comp&aacute;rtalos f&aacute;cilmente. <strong>Convierta videos a diferentes formatos</strong> y disfrute de una experiencia de visualizaci&oacute;n personalizada. <strong>Descargue listas de reproducci&oacute;n completas con un solo clic</strong>.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Descarga de Videos:</strong> Permite descargar videos de YouTube en diversas resoluciones y formatos.</li>\r\n<li><strong>Conversi&oacute;n de Formatos:</strong> Convierte los videos descargados a formatos compatibles con diferentes dispositivos, como MP4, AVI, y MP3.</li>\r\n<li><strong>Descarga de Listas de Reproducci&oacute;n:</strong> Facilita la descarga de listas de reproducci&oacute;n completas con un solo clic, ahorrando tiempo y esfuerzo.</li>\r\n<li><strong>Interfaz Intuitiva:</strong> Ofrece una interfaz de usuario f&aacute;cil de usar, permitiendo a los usuarios navegar y descargar videos de manera eficiente.</li>\r\n</ul>', 'Descarga videos de YouTube fácilmente y guárdalos para verlos sin conexión. ¡Disfruta tu contenido favorito cuando quieras!', '2021', 'YouTube Downloader ', 5, NULL, '', '', 'free', NULL, 1, 0.00, 0, 0, 0, 0, 1, 0, 'approved', '2025-12-23 20:22:08', '2026-01-08 16:22:30', '', '', 'uploads/icons/694af9f0928cb.png'),
(69, 'AIMP', 'aimp', '<p><strong>AIMP</strong> es un potente reproductor de audio <strong>totalmente gratuito</strong>, conocido por su <strong>interfaz personalizable</strong> y su <strong>soporte para una amplia variedad de formatos</strong>. AIMP ofrece una experiencia de escucha superior, con un enfoque en la calidad del sonido y la facilidad de uso.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Soporte de M&uacute;ltiples Formatos:</strong> Reproduce una amplia gama de formatos de audio, incluyendo MP3, AAC, FLAC, WAV, OGG, y muchos m&aacute;s.</li>\r\n<li><strong>Ecualizador de 18 Bandas:</strong> Personaliza tu experiencia auditiva con un ecualizador de 18 bandas y efectos de sonido integrados.</li>\r\n<li><strong>Radio por Internet:</strong> Escucha tus estaciones de radio online favoritas directamente desde AIMP.</li>\r\n<li><strong>Conversor de Audio:</strong> Convierte archivos de audio entre diferentes formatos con facilidad.</li>\r\n<li><strong>Grabaci&oacute;n de Audio:</strong> Graba audio desde cualquier dispositivo de sonido en tu ordenador.</li>\r\n<li><strong>Interfaz Personalizable:</strong> Adapta la apariencia de AIMP a tu gusto con una variedad de skins y plugins.</li>\r\n<li><strong>Administrador de Listas de Reproducci&oacute;n:</strong> Crea y gestiona listas de reproducci&oacute;n de forma sencilla.</li>\r\n<li><strong>Bajo Consumo de Recursos:</strong> AIMP est&aacute; dise&ntilde;ado para funcionar sin problemas incluso en sistemas con recursos limitados.</li>\r\n</ul>', 'AIMP: Potente reproductor de audio con interfaz personalizable y amplia compatibilidad de formatos. Sonido de alta calidad y funciones avanzadas.', '5.40 (2703)', 'AIMP', 2, NULL, '', '', 'free', NULL, 1, 0.00, 0, 1, 1, 0, 1, 0, 'approved', '2025-12-24 05:45:04', '2026-01-08 16:21:13', 'Windows, Android', 'Sistemas operativos compatibles : Windows 7, 8, 8.1, 10, 11 (32 bits, 64 bits).\r\n\r\n', 'uploads/icons/694b7de0cf1f7.png'),
(70, 'WinRAR ', 'winrar', '<p><strong>WinRAR</strong> es la herramienta l&iacute;der en compresi&oacute;n y descompresi&oacute;n de archivos, que ofrece una <strong>soluci&oacute;n integral para archivar, encriptar y compartir tus datos de forma segura y eficiente</strong>. Con <strong>WinRAR</strong>, puedes reducir el tama&ntilde;o de tus archivos para ahorrar espacio en disco y facilitar su transferencia por internet, adem&aacute;s de protegerlos con contrase&ntilde;a. <strong>Su interfaz intuitiva y su amplia compatibilidad con formatos</strong> lo convierten en una herramienta indispensable para usuarios de todos los niveles.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Compresi&oacute;n Avanzada:</strong> Reduce el tama&ntilde;o de los archivos para ahorrar espacio y facilitar la transferencia.</li>\r\n<li><strong>Soporte Multi-Formato:</strong> Compatible con RAR, ZIP, 7Z, ACE, ARJ, BZ2, CAB, GZ, ISO, JAR, LZH, TAR, UUE, XZ, Z.</li>\r\n<li><strong>Encriptaci&oacute;n Robusta:</strong> Protege tus archivos con contrase&ntilde;as y algoritmos de encriptaci&oacute;n seguros.</li>\r\n<li><strong>Creaci&oacute;n de Archivos Autoextra&iacute;bles:</strong> Convierte archivos comprimidos en ejecutables para facilitar su distribuci&oacute;n.</li>\r\n<li><strong>Recuperaci&oacute;n de Archivos Da&ntilde;ados:</strong> Repara archivos comprimidos da&ntilde;ados o corruptos.</li>\r\n</ul>', 'Compresión y descompresión de archivos potente y versátil. Ideal para gestionar documentos y ahorrar espacio.', '7.13 ', 'rarlab', 3, NULL, '', '', 'free', NULL, 2, 0.00, 0, 1, 0, 0, 1, 0, 'approved', '2025-12-24 07:09:38', '2026-01-08 16:22:11', 'Windows', 'Sistemas operativos compatibles:\r\nWindows 7, 8, 8.1, 10, 11 (32 bits, 64 bits).\r\nServidor 2012, 2016, 2019, 2022.\r\nCompatible con Windows 11 y 10, disponible en más de 50 idiomas para sistemas de 32 y 64 bits, y con múltiples sistemas operativos. Es el único software de compresión totalmente compatible con todos los países que utilizan Unicode.', 'uploads/icons/694b91b28ce35.webp'),
(71, 'UnHackMe ', 'unhackme', '<p><strong>UnHackMe</strong> es una poderosa herramienta de seguridad dise&ntilde;ada para detectar y eliminar rootkits, malware y otras amenazas persistentes que los antivirus tradicionales a menudo pasan por alto. <strong>Ofrece una protecci&oacute;n proactiva</strong> contra software malicioso avanzado, <strong>analiza profundamente el sistema</strong> y <strong>restaura la configuraci&oacute;n original del sistema</strong> despu&eacute;s de una infecci&oacute;n.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Detecci&oacute;n de Rootkits:</strong> Identifica y elimina rootkits ocultos que comprometen la seguridad del sistema.</li>\r\n<li><strong>Eliminaci&oacute;n de Malware:</strong> Remueve eficazmente virus, troyanos, gusanos y otros tipos de software malicioso.</li>\r\n<li><strong>Protecci&oacute;n en Tiempo Real:</strong> Monitorea continuamente el sistema en busca de actividades sospechosas y previene infecciones.</li>\r\n<li><strong>Verificaci&oacute;n de Inicio:</strong> Analiza los programas y servicios que se inician con Windows para detectar elementos maliciosos.</li>\r\n<li><strong>Escaneo Profundo del Registro:</strong> Examina el registro de Windows en busca de entradas modificadas por malware.</li>\r\n<li><strong>Restauraci&oacute;n del Sistema:</strong> Revierte los cambios realizados por el malware para restaurar el sistema a su estado original.</li>\r\n<li><strong>Soporte para M&uacute;ltiples Navegadores:</strong> Protege contra extensiones y complementos maliciosos en Chrome, Firefox, Edge e Internet Explorer.</li>\r\n<li><strong>An&aacute;lisis de Archivos Sospechosos:</strong> Permite analizar archivos sospechosos en busca de comportamiento malicioso.</li>\r\n<li><strong>Creaci&oacute;n de Informes Detallados:</strong> Genera informes detallados sobre las amenazas detectadas y las acciones realizadas.</li>\r\n</ul>', 'Detecta y elimina rootkits, malware y programas no deseados. Restaura la configuración original de Windows.', '17.90.2025.1224', 'UnHackMe ', 7, NULL, '', '', 'trial', NULL, 2, 0.00, 0, 1, 0, 1, 1, 0, 'approved', '2025-12-24 19:43:00', '2026-01-08 16:16:44', 'Windows', '', 'uploads/icons/694c424457bad.webp'),
(72, 'VLC media player ', 'vlc-media-player', '<p><strong>VLC media player</strong> es un reproductor multimedia multiplataforma, gratuito y de c&oacute;digo abierto que reproduce la mayor&iacute;a de los archivos multimedia, as&iacute; como DVD, CD de Audio, VCD y diversos protocolos de transmisi&oacute;n. <strong>Es conocido por su versatilidad y compatibilidad con una amplia gama de formatos</strong>, sin necesidad de c&oacute;decs adicionales. <strong>VLC ofrece tambi&eacute;n funciones avanzadas como la conversi&oacute;n de formatos y la transmisi&oacute;n de v&iacute;deo en red</strong>. Disfruta de una experiencia multimedia completa con <strong>VLC media player</strong>.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Compatibilidad con m&uacute;ltiples formatos:</strong> Reproduce casi cualquier archivo de audio y v&iacute;deo sin necesidad de instalar c&oacute;decs adicionales.</li>\r\n<li><strong>Reproducci&oacute;n de DVD y Blu-ray:</strong> Permite reproducir DVD y Blu-ray directamente desde el disco o imagen ISO.</li>\r\n<li><strong>Transmisi&oacute;n en red:</strong> Puede transmitir contenido multimedia a trav&eacute;s de la red, incluyendo protocolos como HTTP, RTP/RTSP, HLS y muchos m&aacute;s.</li>\r\n<li><strong>Conversi&oacute;n de formatos:</strong> Convierte archivos multimedia a diferentes formatos de audio y v&iacute;deo.</li>\r\n<li><strong>Personalizaci&oacute;n:</strong> Ofrece una amplia gama de opciones de personalizaci&oacute;n, incluyendo skins e interfaces personalizadas.</li>\r\n<li><strong>Multiplataforma:</strong> Disponible para Windows, macOS, Linux, Android e iOS.</li>\r\n</ul>', 'Reproductor multimedia versátil y gratuito. Compatible con múltiples formatos y plataformas, ideal para disfrutar de tus videos y audios favoritos.', '3.0.23 ', 'VLC', 2, NULL, '', '', 'free', NULL, 1, 0.00, 0, 1, 0, 0, 1, 0, 'approved', '2025-12-25 17:55:07', '2026-01-08 16:22:22', 'Windows', '', 'uploads/icons/694d7a7b7c363.png'),
(73, 'Bitdefender ', 'bitdefender', '<p><strong>Bitdefender</strong> es una soluci&oacute;n de seguridad integral que protege tus dispositivos contra todo tipo de amenazas en l&iacute;nea. <strong>Ofrece una defensa proactiva contra virus, malware y ransomware.</strong> <strong>Mantiene tu informaci&oacute;n personal segura y privada.</strong> <strong>Garantiza un rendimiento &oacute;ptimo de tus dispositivos.</strong></p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Protecci&oacute;n Avanzada contra Amenazas:</strong> Detecta y bloquea virus, spyware, ransomware y otras amenazas antes de que puedan causar da&ntilde;o.</li>\r\n<li><strong>Antivirus con Inteligencia Artificial:</strong> Utiliza algoritmos avanzados de aprendizaje autom&aacute;tico para identificar y neutralizar amenazas desconocidas.</li>\r\n<li><strong>Protecci&oacute;n contra Ransomware de M&uacute;ltiples Capas:</strong> Protege tus archivos importantes del cifrado no autorizado y exige el pago de un rescate.</li>\r\n<li><strong>VPN Segura:</strong> Cifra tu tr&aacute;fico de Internet y protege tu privacidad en redes Wi-Fi p&uacute;blicas.</li>\r\n<li><strong>Control Parental:</strong> Supervisa la actividad en l&iacute;nea de tus hijos y bloquea contenido inapropiado.</li>\r\n<li><strong>Optimizaci&oacute;n del Sistema:</strong> Mejora el rendimiento de tu PC eliminando archivos innecesarios y optimizando la configuraci&oacute;n.</li>\r\n<li><strong>Administrador de Contrase&ntilde;as:</strong> Almacena y gestiona tus contrase&ntilde;as de forma segura.</li>\r\n<li><strong>Protecci&oacute;n de la Webcam:</strong> Evita el acceso no autorizado a tu webcam.</li>\r\n</ul>', 'Protección integral contra amenazas digitales. Seguridad avanzada y rendimiento óptimo para tu tranquilidad online.', '3.3.284.2542 ', 'Bitdefender', 4, NULL, '', '', 'free', NULL, 1, 0.00, 0, 1, 1, 0, 1, 0, 'approved', '2025-12-25 17:58:25', '2026-01-08 16:21:17', 'Android', '', 'uploads/icons/694d7b416d804.png'),
(74, 'AB Download Manager ', 'ab-download-manager', '<p><strong>AB Download Manager</strong> es una potente herramienta dise&ntilde;ada para <strong>optimizar y acelerar tus descargas</strong>. Ofrece una interfaz intuitiva y f&aacute;cil de usar, permiti&eacute;ndote <strong>gestionar tus descargas de forma eficiente</strong> y <strong>maximizar tu ancho de banda</strong>. Disfruta de una experiencia de descarga m&aacute;s fluida y organizada.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Descargas Aceleradas:</strong> Aumenta la velocidad de descarga dividiendo los archivos en m&uacute;ltiples segmentos.</li>\r\n<li><strong>Gesti&oacute;n de Descargas:</strong> Organiza, pausa, reanuda y programa tus descargas f&aacute;cilmente.</li>\r\n<li><strong>Soporte Multi-Protocolo:</strong> Compatible con HTTP, HTTPS y FTP.</li>\r\n<li><strong>Integraci&oacute;n con Navegadores:</strong> Se integra con los navegadores m&aacute;s populares para capturar enlaces de descarga autom&aacute;ticamente.</li>\r\n<li><strong>Programaci&oacute;n de Descargas:</strong> Programa tus descargas para que se ejecuten en momentos espec&iacute;ficos.</li>\r\n<li><strong>Reanudaci&oacute;n Autom&aacute;tica:</strong> Reanuda las descargas interrumpidas autom&aacute;ticamente.</li>\r\n<li><strong>Gesti&oacute;n de Ancho de Banda:</strong> Controla el ancho de banda utilizado por el gestor de descargas.</li>\r\n</ul>', 'Acelera y organiza tus descargas con AB Download Manager. Aumenta tu productividad y gestiona archivos eficientemente.', '1.8.3', 'AB Download Manager ', 3, NULL, 'https://github.com/amir1376/ab-download-manager/releases/download/v1.8.3/ABDownloadManager_1.8.3_android_universal.apk', '', 'free', NULL, 3, 5.00, 1, 1, 0, 0, 0, 0, 'approved', '2025-12-26 20:53:46', '2026-01-08 16:17:17', 'Windows', '**Requisitos del Sistema:**\r\n\r\n• Sistema Operativo: Windows 10 o superior (64-bit)\r\n• Procesador: Procesador Intel Core i3 o equivalente\r\n• Memoria RAM: 4 GB de RAM\r\n• Espacio en Disco: 500 MB de espacio disponible\r\n• Tarjeta Gráfica: Tarjeta gráfica compatible con DirectX 11\r\n• Adicional: Conexión a Internet para actualizaciones\r\n', 'uploads/icons/694ef5da2b37e.webp'),
(75, 'Personal Backup ', 'personal-backup', '<p><strong>Personal Backup</strong> es una soluci&oacute;n de software robusta y confiable dise&ntilde;ada para proteger sus datos m&aacute;s importantes. Ofrece <strong>copias de seguridad autom&aacute;ticas</strong>, <strong>restauraci&oacute;n sencilla</strong> y <strong>seguridad avanzada</strong> para garantizar la integridad de su informaci&oacute;n. Con <strong>Personal Backup</strong>, tenga la tranquilidad de saber que sus archivos est&aacute;n seguros y accesibles en todo momento.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Copia de Seguridad Autom&aacute;tica:</strong> Programa copias de seguridad peri&oacute;dicas para proteger sus datos de forma continua.</li>\r\n<li><strong>Restauraci&oacute;n Sencilla:</strong> Recupere f&aacute;cilmente archivos individuales o sistemas completos con unos pocos clics.</li>\r\n<li><strong>Cifrado Avanzado:</strong> Proteja sus copias de seguridad con cifrado de grado militar para garantizar la confidencialidad de sus datos.</li>\r\n<li><strong>Soporte para M&uacute;ltiples Destinos:</strong> Realice copias de seguridad en unidades locales, unidades de red o en la nube.</li>\r\n</ul>', 'Protege tus datos vitales con Personal Backup. Copias de seguridad sencillas y automatizadas para tu tranquilidad digital.', '6.4.5.0 ', 'Rathlevs', 3, NULL, '', '', 'free', NULL, 3, 0.00, 0, 0, 0, 0, 0, 0, 'approved', '2025-12-27 06:49:13', '2026-01-08 16:21:41', 'Windows', 'Windows XP, Vista, 7, 8, 8.1, 10, 11 (32-bit, 64-bit).\r\n', 'uploads/icons/694f8169c25b3.png'),
(76, 'Viber ', 'viber', '<p><strong>Viber</strong> es una aplicaci&oacute;n de mensajer&iacute;a y llamadas que te permite <strong>conectarte con amigos y familiares en todo el mundo</strong>. Disfruta de <strong>llamadas de alta calidad</strong>, env&iacute;a <strong>mensajes de texto y multimedia</strong>, y participa en chats grupales. Viber ofrece una plataforma segura y f&aacute;cil de usar para mantenerte en contacto.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Llamadas de Audio y Video:</strong> Realiza llamadas gratuitas a otros usuarios de Viber, sin importar d&oacute;nde se encuentren.</li>\r\n<li><strong>Mensajer&iacute;a Instant&aacute;nea:</strong> Env&iacute;a mensajes de texto, fotos, videos, stickers y archivos a tus contactos.</li>\r\n<li><strong>Chats Grupales:</strong> Crea y participa en chats grupales con hasta 250 personas.</li>\r\n<li><strong>Llamadas a N&uacute;meros Fijos y M&oacute;viles:</strong> Llama a n&uacute;meros de tel&eacute;fono fijos y m&oacute;viles a tarifas bajas con Viber Out.</li>\r\n<li><strong>Stickers y GIFs:</strong> Expr&eacute;sate con una amplia selecci&oacute;n de stickers y GIFs animados.</li>\r\n<li><strong>Encriptaci&oacute;n de Extremo a Extremo:</strong> Disfruta de conversaciones seguras con encriptaci&oacute;n de extremo a extremo por defecto.</li>\r\n<li><strong>Comunidades:</strong> &Uacute;nete a comunidades con intereses compartidos y con&eacute;ctate con personas de todo el mundo.</li>\r\n<li><strong>Viber Lens:</strong> Utiliza filtros y efectos de realidad aumentada en tus fotos y videos.</li>\r\n</ul>', 'Mensajería instantánea y llamadas de alta calidad. Conéctate globalmente con Viber, comparte momentos y descubre contenido multimedia.', '26.8.4.0', 'Viber ', 2, NULL, '', '', 'free', NULL, 4, 0.00, 0, 0, 0, 0, 0, 0, 'approved', '2025-12-27 20:05:43', '2026-01-08 16:17:21', 'Windows, Mac, Android, iOS', 'Runs on Windows 7, 8, 8.1, 10, and 11, supporting both 32-bit and 64-bit systems.\r\nmacOS X 10.13 (64-bit) and up.\r\nAndroid 5.0 or later\r\niOS 11.0 or later. Compatible with iPhone, iPad, and iPod touch.', 'uploads/icons/69503c175e3ae.png'),
(77, 'Inkscape ', 'inkscape', '<p><strong>Inkscape</strong> es un potente editor de gráficos vectoriales de código abierto, <strong>ideal para crear ilustraciones, logotipos y diseños web</strong>. Ofrece una amplia gama de herramientas y funcionalidades, además de ser <strong>compatible con el formato SVG</strong> y otros formatos populares. Su interfaz intuitiva y su <strong>gran comunidad de usuarios</strong> lo convierten en una excelente opción tanto para principiantes como para profesionales.</p><p>\r\n</p><h2>Características Principales</h2><p>\r\n</p><p><br></p>', 'Software de diseño vectorial profesional y gratuito. Crea gráficos escalables para web e impresión con herramientas potentes y flexibles.', '1.4.3 ', 'Inkscape ', 2, NULL, 'https://inkscape.org/gallery/item/58918/inkscape-signed.exe', '122 MB', 'free', NULL, 4, 0.00, 0, 1, 0, 0, 0, 0, 'approved', '2025-12-27 20:18:00', '2026-01-08 16:22:14', 'Multiplataforma', 'https://inkscape.org/release/inkscape-1.4.3/', 'uploads/icons/69503ef8a7e47.png'),
(78, 'Driver Easy ', 'driver-easy', '<p><strong>Driver Easy</strong> es una herramienta esencial para mantener tu PC funcionando de manera óptima. <strong>Escanea tu sistema en busca de drivers obsoletos, descargarlos e instalarlos automáticamente</strong>. Asegura la compatibilidad de tu hardware y <strong>mejora el rendimiento general del equipo</strong>, ahorrando tiempo y esfuerzo.</p><p>\r\n</p><h2>Características Principales</h2><p>\r\n</p><p><br></p>', 'Actualiza y gestiona tus drivers fácilmente. Mantén tu PC optimizado y libre de errores con Driver Easy.', 'v7.1.1.3511', 'Driver Easy ', 5, NULL, 'https://www.ccleaner.com/ccleaner/download/standard', '50', 'free', NULL, 2, 0.00, 0, 0, 0, 0, 0, 0, 'approved', '2025-12-27 21:51:41', '2026-01-08 16:17:13', 'Windows', 'Supported Operating Systems: Windows 11, 10, 8.1, 8, 7 (32-bit, 64-bit).\r\n\r\n', 'uploads/icons/695054eda1a61.jpg'),
(79, 'DriverMax ', 'drivermax', '<p><strong>DriverMax</strong> es una poderosa herramienta dise&ntilde;ada para mantener tu sistema actualizado y funcionando sin problemas. <strong>DriverMax</strong> escanea tu hardware en busca de drivers obsoletos, <strong>descarga las &uacute;ltimas versiones</strong> e incluso crea copias de seguridad de tus drivers actuales. Con <strong>DriverMax</strong>, podr&aacute;s optimizar el rendimiento de tu PC y evitar conflictos de hardware.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Actualizaci&oacute;n Autom&aacute;tica de Drivers:</strong> Detecta y descarga autom&aacute;ticamente las &uacute;ltimas versiones de los drivers para tu hardware.</li>\r\n<li><strong>Copia de Seguridad y Restauraci&oacute;n de Drivers:</strong> Crea copias de seguridad de tus drivers actuales para restaurarlos en caso de problemas.</li>\r\n<li><strong>Identificaci&oacute;n de Dispositivos Desconocidos:</strong> Identifica dispositivos de hardware desconocidos y encuentra los drivers correspondientes.</li>\r\n<li><strong>Programaci&oacute;n de Escaneos:</strong> Programa escaneos regulares para mantener tus drivers siempre actualizados.</li>\r\n</ul>', 'Actualiza y gestiona fácilmente los drivers de tu PC. DriverMax optimiza el rendimiento y la estabilidad de tu sistema.', '16.22.0.28', 'DriverMax ', 6, NULL, '', '', 'free', NULL, 2, 1.00, 2, 0, 0, 0, 0, 0, 'approved', '2025-12-27 22:58:15', '2026-01-08 16:22:03', 'Windows', 'Windows XP, Vista, 7, 8, 8.1, 10, 11 (32-bit, 64-bit).', 'uploads/icons/69506487610b8.webp');
INSERT INTO `software` (`id`, `name`, `slug`, `description`, `short_description`, `version`, `developer`, `category_id`, `image`, `download_url`, `file_size`, `license`, `os`, `downloads`, `rating`, `rating_count`, `featured`, `badge_editors_choice`, `badge_trending`, `badge_new`, `badge_updated`, `status`, `created_at`, `updated_at`, `operating_system`, `requirements`, `icon`) VALUES
(80, 'Ventoy ', 'ventoy', '<p><strong>Ventoy</strong> es una herramienta revolucionaria que <strong>simplifica la creaci&oacute;n de unidades USB de arranque m&uacute;ltiple</strong>. Con Ventoy, ya no necesitas formatear tu unidad USB repetidamente; simplemente copia los archivos ISO/WIM/IMG/VHD(x)/EFI a la unidad y arranca directamente. <strong>Ventoy ofrece una soluci&oacute;n r&aacute;pida y f&aacute;cil</strong> para probar diferentes sistemas operativos y herramientas de diagn&oacute;stico.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Arranque M&uacute;ltiple:</strong> Permite arrancar m&uacute;ltiples archivos ISO/WIM/IMG/VHD(x)/EFI desde una sola unidad USB.</li>\r\n<li><strong>Instalaci&oacute;n Sencilla:</strong> La instalaci&oacute;n de Ventoy es r&aacute;pida y no destructiva para los datos existentes en la unidad USB.</li>\r\n<li><strong>Soporte para Legacy + UEFI:</strong> Compatible con los modos de arranque Legacy BIOS y UEFI.</li>\r\n<li><strong>Soporte Amplio de Sistemas Operativos:</strong> Soporta una amplia gama de sistemas operativos Windows, Linux, VMware, Citrix XenServer, etc.</li>\r\n</ul>', 'Ventoy: Crea USBs booteables multi-ISO fácilmente. Almacena múltiples sistemas operativos y herramientas en un solo dispositivo.', '1.1.10', 'Ventoy ', 3, NULL, '', '', 'free', NULL, 2, 0.00, 0, 0, 0, 0, 0, 0, 'approved', '2025-12-27 23:15:23', '2026-01-08 16:22:06', 'Windows, Linux', '', 'uploads/icons/6950688b60511.jpeg'),
(81, 'Kaspersky Rescue Disk full', 'kaspersky-rescue-disk-full', '<p><strong>Kaspersky Rescue Disk</strong> es una herramienta indispensable para la limpieza y recuperaci&oacute;n de sistemas infectados que no pueden ser iniciados. <strong>Permite analizar y eliminar malware, rootkits y bootkits incluso antes de que el sistema operativo se cargue.</strong> <strong>Ideal para situaciones donde el sistema est&aacute; comprometido o da&ntilde;ado.</strong> Ofrece una soluci&oacute;n eficaz para restaurar la funcionalidad de tu equipo.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>An&aacute;lisis Previo al Inicio:</strong> Examina el sistema en un entorno seguro antes de que el sistema operativo se inicie, eliminando amenazas profundamente arraigadas.</li>\r\n<li><strong>Eliminaci&oacute;n de Malware:</strong> Detecta y elimina una amplia gama de malware, incluyendo virus, troyanos, gusanos y rootkits.</li>\r\n<li><strong>Restauraci&oacute;n del Sistema:</strong> Intenta restaurar el sistema operativo a un estado funcional despu&eacute;s de la eliminaci&oacute;n del malware.</li>\r\n<li><strong>Interfaz Gr&aacute;fica Intuitiva:</strong> Ofrece una interfaz f&aacute;cil de usar para facilitar el an&aacute;lisis y la eliminaci&oacute;n de amenazas.</li>\r\n<li><strong>Actualizaciones de Bases de Datos:</strong> Se actualiza regularmente con las &uacute;ltimas definiciones de malware para garantizar una protecci&oacute;n eficaz.</li>\r\n<li><strong>Soporte para M&uacute;ltiples Dispositivos:</strong> Puede ser grabado en un CD/DVD o una unidad USB para su uso en diferentes equipos.</li>\r\n</ul>', 'Selecciona la categoría más adecuada de las siguientes: Antivirus, Seguridad, Recuperación de datos, Herramientas del sistema.', '18.0.11.0c ', 'Kaspersky', 7, NULL, '', '', 'free', NULL, 2, 5.00, 2, 0, 0, 0, 0, 0, 'approved', '2025-12-28 22:09:17', '2026-01-08 16:21:05', 'Windows', '', 'uploads/icons/6951aa8d06fb7.png'),
(85, 'Spotify', 'spotify', '<p>Spotify es un servicio de música en streaming que te da acceso a millones de canciones y podcasts.</p><p>Características:</p><ul><li>Millones de canciones</li><li>Podcasts exclusivos</li><li>Listas de reproducción personalizadas</li><li>Modo sin conexión (Premium)</li><li>Sincronización entre dispositivos</li></ul>', 'Servicio de streaming de música y podcasts', '1.2.28', 'Spotify AB', 2, NULL, '', '', 'free', NULL, 18007, 4.70, 0, 1, 1, 0, 0, 0, 'approved', '2025-12-29 19:38:40', '2026-01-08 16:21:45', '', 'Windows 7 o superior, 2 GB RAM', 'uploads/icons/6952d9444a50a.webp'),
(86, 'Discord', 'discord', '<p>Discord es una aplicación de comunicación por voz, video y texto diseñada para crear comunidades.</p><p>Características:</p><ul><li>Chat de voz y video</li><li>Servidores personalizables</li><li>Compartir pantalla</li><li>Bots y integraciones</li><li>Streaming en vivo</li></ul>', 'Plataforma de comunicación para comunidades', '0.0.308', 'Discord Inc.', 5, NULL, '', '', 'free', NULL, 14002, 4.60, 0, 0, 0, 0, 0, 0, 'approved', '2025-12-29 19:38:40', '2026-01-08 16:17:01', '', 'Windows 7 o superior, 4 GB RAM', 'uploads/icons/6952d91b04251.webp'),
(87, 'Visual Studio Code', 'visual-studio-code', '<p>Visual Studio Code es un editor de código fuente desarrollado por Microsoft.</p><p>Características:</p><ul><li>IntelliSense (autocompletado)</li><li>Depuración integrada</li><li>Control de versiones Git</li><li>Extensiones ilimitadas</li><li>Terminal integrada</li></ul>', 'Editor de código fuente potente y gratuito', '1.85.1', 'Microsoft', 6, NULL, '', '', 'free', NULL, 16003, 4.90, 0, 0, 0, 0, 0, 0, 'approved', '2025-12-29 19:38:40', '2026-01-09 05:16:33', '', 'Windows 10 o superior, 4 GB RAM', 'uploads/icons/6952d8f4601a0.webp'),
(89, 'Titan SFTP Server ', 'titan-sftp-server', '<p><strong>Titan SFTP Server</strong> es una soluci&oacute;n robusta y segura para la transferencia de archivos, <strong>especialmente dise&ntilde;ada para entornos multimedia</strong>. Ofrece un alto rendimiento, <strong>una configuraci&oacute;n f&aacute;cil</strong> y una s&oacute;lida seguridad para proteger sus datos sensibles. <strong>Ideal para empresas que necesitan compartir grandes archivos multimedia de forma segura y eficiente</strong>.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Transferencia Segura de Archivos:</strong> Utiliza el protocolo SFTP (SSH File Transfer Protocol) para garantizar la encriptaci&oacute;n y la integridad de los datos durante la transferencia.</li>\r\n<li><strong>Autenticaci&oacute;n Avanzada:</strong> Soporta m&uacute;ltiples m&eacute;todos de autenticaci&oacute;n, incluyendo contrase&ntilde;as, claves p&uacute;blicas y autenticaci&oacute;n de dos factores (2FA) para mayor seguridad.</li>\r\n<li><strong>Administraci&oacute;n de Usuarios y Permisos:</strong> Permite crear y gestionar usuarios con permisos espec&iacute;ficos para controlar el acceso a los archivos y directorios.</li>\r\n<li><strong>Monitoreo y Registro:</strong> Proporciona un registro detallado de todas las actividades del servidor, incluyendo conexiones, transferencias y errores, para fines de auditor&iacute;a y seguridad.</li>\r\n<li><strong>Soporte para Grandes Archivos:</strong> Optimizado para la transferencia eficiente de archivos de gran tama&ntilde;o, como videos y archivos de audio de alta resoluci&oacute;n.</li>\r\n<li><strong>Integraci&oacute;n con Active Directory:</strong> Facilita la administraci&oacute;n de usuarios al integrarse con Active Directory para la autenticaci&oacute;n y la gesti&oacute;n de permisos.</li>\r\n<li><strong>Interfaz de Usuario Intuitiva:</strong> Ofrece una interfaz gr&aacute;fica de usuario f&aacute;cil de usar para la configuraci&oacute;n y el monitoreo del servidor.</li>\r\n<li><strong>Automatizaci&oacute;n de Tareas:</strong> Permite automatizar tareas comunes, como la copia de seguridad de archivos y la limpieza de directorios, mediante scripts y programaci&oacute;n de tareas.</li>\r\n</ul>', 'Servidor SFTP seguro y de alto rendimiento para transferencias multimedia rápidas y confiables. Ideal para flujos de trabajo profesionales.', '2.0.37.2954 ', 'Titan SFTP Server ', 2, NULL, '', '', 'free', NULL, 5, 5.00, 4, 0, 0, 0, 0, 0, 'approved', '2025-12-30 17:28:12', '2026-01-08 16:21:29', 'Windows, Mac', 'Features and Enhancements:\r\nAdded support for uploading and downloading files greater than 2GB in the web UI\r\nAdd the ability to unlock a user who was temporarily locked due to failed login attempts\r\nAdd the ability to edit a database connection for an existing server to update the DB credentials or database server.', 'uploads/icons/69540bac12661.webp'),
(90, 'GoodSync', 'goodsync', '<p><strong>GoodSync</strong> es una soluci&oacute;n de copia de seguridad y sincronizaci&oacute;n de archivos <strong>automatizada, f&aacute;cil de usar y segura</strong>. Permite realizar copias de seguridad de tus datos importantes en m&uacute;ltiples destinos, incluyendo discos locales, unidades de red, servidores FTP/SFTP, y servicios de almacenamiento en la nube. <strong>Protege tus datos contra la p&eacute;rdida y garantiza la disponibilidad</strong>, permitiendo una restauraci&oacute;n r&aacute;pida y sencilla. <strong>Ofrece sincronizaci&oacute;n bidireccional en tiempo real</strong> para mantener tus archivos actualizados en todos tus dispositivos.</p>\r\n<h2>Caracter&iacute;sticas Principales</h2>\r\n<ul>\r\n<li><strong>Sincronizaci&oacute;n Bidireccional:</strong> Sincroniza archivos y carpetas entre dos o m&aacute;s dispositivos en ambas direcciones.</li>\r\n<li><strong>Copias de Seguridad Automatizadas:</strong> Realiza copias de seguridad programadas de tus datos importantes de forma autom&aacute;tica.</li>\r\n<li><strong>Soporte para M&uacute;ltiples Destinos:</strong> Copia de seguridad en unidades locales, de red, servidores FTP/SFTP y servicios en la nube.</li>\r\n<li><strong>Detecci&oacute;n de Cambios en Tiempo Real:</strong> Detecta y sincroniza los cambios en los archivos al instante.</li>\r\n<li><strong>Control de Versiones:</strong> Guarda m&uacute;ltiples versiones de tus archivos para una f&aacute;cil restauraci&oacute;n.</li>\r\n<li><strong>Cifrado de Datos:</strong> Protege tus datos con cifrado AES de 256 bits durante la transferencia y el almacenamiento.</li>\r\n<li><strong>Sincronizaci&oacute;n P2P:</strong> Sincroniza directamente entre dispositivos sin necesidad de un servidor central.</li>\r\n<li><strong>Informes y Registros Detallados:</strong> Obt&eacute;n informes completos sobre las operaciones de sincronizaci&oacute;n y copia de seguridad.</li>\r\n</ul>', 'GoodSync: Copia de seguridad y sincronización de archivos automatizada. Protege tus datos con copias en tiempo real y fáciles de restaurar.', '12.9.21.1 ', 'GoodSync', 34, NULL, '', '', 'free', NULL, 7, 5.00, 7, 0, 0, 0, 0, 0, 'approved', '2025-12-31 08:59:03', '2026-01-08 16:21:09', 'Windows, Mac, Linux, Android', 'Sistemas operativos compatibles : Windows 7, 8, 8.1, 10, 11 (32 bits, 64 bits).\r\n\r\n', 'uploads/icons/6954e5d71551d.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_alternatives`
--

CREATE TABLE `software_alternatives` (
  `id` int(11) NOT NULL,
  `software_id` int(11) NOT NULL,
  `alternative_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `software_versions`
--

CREATE TABLE `software_versions` (
  `id` int(11) NOT NULL,
  `software_id` int(11) NOT NULL,
  `version_number` varchar(50) NOT NULL,
  `release_date` date DEFAULT NULL,
  `changelog` text DEFAULT NULL,
  `download_url` varchar(500) DEFAULT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `software_versions`
--

INSERT INTO `software_versions` (`id`, `software_id`, `version_number`, `release_date`, `changelog`, `download_url`, `file_size`, `created_at`) VALUES
(2, 55, '1.85.118', '2025-12-26', '', 'https://github.com/brave/brave-browser/releases/download/v1.85.118/BraveBrowserStandaloneSetup32.exe', NULL, '2025-12-26 20:40:29'),
(3, 58, '125.0.5729.58 ', '2025-12-26', '', 'https://get.geo.opera.com/pub/opera_gx/125.0.5729.58/win/Opera_GX_125.0.5729.58_Setup.exe\r\nhttps://get.geo.opera.com/pub/opera_gx/125.0.5729.58/win/Opera_GX_125.0.5729.58_Setup_x64.exe\r\nhttps://net.geo.opera.com/opera_gx/stable/mac', NULL, '2025-12-26 20:41:08'),
(4, 58, '125.0.5729.60', '2025-12-26', '', 'https://net.geo.opera.com/opera_gx/stable/mac', NULL, '2025-12-26 20:42:13'),
(5, 58, '125.0.5729.61', '2025-12-26', '', 'https://net.geo.opera.com/opera_gx/stable/mac', NULL, '2025-12-26 20:42:30'),
(6, 58, '125.0.5729.61', '2025-12-26', '', 'https://net.geo.opera.com/opera_gx/stable/mac', NULL, '2025-12-26 21:00:34'),
(7, 53, '7.03.1121', '2025-12-27', '', 'https://download.ccleaner.com/ccsetup639.exe\r\nhttps://download.ccleaner.com/professional/ccsetup639_pro.exe\r\nhttps://download.ccleaner.com/mac/CCMacSetup209.dmg\r\nhttps://play.google.com/store/apps/details?id=com.piriform.ccleaner #android', NULL, '2025-12-27 19:41:55'),
(8, 53, 'v7.03.1122', '2025-12-27', '', 'https://download.ccleaner.com/ccsetup639.exe\r\nhttps://download.ccleaner.com/mac/CCMacSetup209.dmg', NULL, '2025-12-27 19:44:08'),
(9, 53, 'v7.03.1130', '2025-12-27', '', 'https://download.ccleaner.com/mac/CCMacSetup209.dmg', NULL, '2025-12-27 19:52:01'),
(10, 78, 'v7.1.1.3511', '2025-12-27', 'Nada', '', NULL, '2025-12-27 22:54:33'),
(12, 79, 'v16.22.0.26', '2025-12-27', '', '', '', '2025-12-27 23:09:57'),
(13, 79, '16.22.0.27', '2025-12-27', '', 'https://download.drivereasy.com/DriverEasy_Setup.exe', '50 MB', '2025-12-27 23:10:25'),
(14, 79, '16.22.0.27', '2025-12-27', '', 'https://download.drivereasy.com/DriverEasy_Setup.exe', '50 MB', '2025-12-27 23:12:43'),
(15, 79, '16.22.0.28', '2025-12-27', '', 'https://download.drivereasy.com/DriverEasy_Setup.exe', '60.20MB', '2025-12-27 23:13:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT 'Administrador',
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Carlos', 'admin', 'pichoflow@gmail.com', '$2y$10$nvBHJFFr2W6YcJRkWhBin.AlqeddPA3HowXsbAr6vpqqdYrmTyud6', 'admin', '2025-12-20 00:52:19', '2025-12-29 18:22:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `download_links`
--
ALTER TABLE `download_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_software_id` (`software_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `software_id` (`software_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indices de la tabla `site_statistics`
--
ALTER TABLE `site_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_date` (`stat_date`),
  ADD KEY `idx_stat_date` (`stat_date`);

--
-- Indices de la tabla `software`
--
ALTER TABLE `software`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `software_alternatives`
--
ALTER TABLE `software_alternatives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_alternative` (`software_id`,`alternative_id`),
  ADD KEY `alternative_id` (`alternative_id`),
  ADD KEY `idx_software_alt` (`software_id`);

--
-- Indices de la tabla `software_versions`
--
ALTER TABLE `software_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_software_version` (`software_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `download_links`
--
ALTER TABLE `download_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT de la tabla `site_statistics`
--
ALTER TABLE `site_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `software`
--
ALTER TABLE `software`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `software_alternatives`
--
ALTER TABLE `software_alternatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `software_versions`
--
ALTER TABLE `software_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `download_links`
--
ALTER TABLE `download_links`
  ADD CONSTRAINT `download_links_ibfk_1` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `software`
--
ALTER TABLE `software`
  ADD CONSTRAINT `software_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `software_alternatives`
--
ALTER TABLE `software_alternatives`
  ADD CONSTRAINT `software_alternatives_ibfk_1` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `software_alternatives_ibfk_2` FOREIGN KEY (`alternative_id`) REFERENCES `software` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `software_versions`
--
ALTER TABLE `software_versions`
  ADD CONSTRAINT `software_versions_ibfk_1` FOREIGN KEY (`software_id`) REFERENCES `software` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
