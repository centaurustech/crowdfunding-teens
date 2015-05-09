-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2015 at 03:54 PM
-- Server version: 5.5.23
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `radar`
--

SET FOREIGN_KEY_CHECKS=0;

--
-- Truncate table before insert `permissions`
--

TRUNCATE TABLE `permissions`;

--
-- Truncate table before insert `modules`
--

TRUNCATE TABLE `modules`;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;

--
-- Truncate table before insert `radio_station`
--

TRUNCATE TABLE `radio_station`;

--
-- Truncate table before insert `radio_stations`
--

TRUNCATE TABLE `markets`;

--
-- Truncate table before insert `assoc_markets_users`
--

TRUNCATE TABLE `assoc_markets_users`;

--
-- Truncate table before insert `assoc_stations_users`
--

TRUNCATE TABLE `assoc_stations_users`;

--
-- Truncate table before insert `album`
--

TRUNCATE TABLE `album`;





--
-- Dumping data for table `modules`
--
INSERT INTO `modules` (`idmodule`, `modulename`, `url`, `id_parent`, `creationdate`, `editiondate`) VALUES
(100, 'Cadastro', NULL, NULL, '2015-01-26 21:57:37', NULL),
(101, 'Usuário', 'dashboard/view/users/', 100, '2015-01-19 11:45:00', NULL),
(102, 'Emissoras', 'dashboard/view/stations/', 100, '2015-01-19 11:45:00', NULL),
(103, 'Mercado / Setor Econômico', 'dashboard/view/markets/', 100, '2015-01-19 11:45:00', NULL),
(104, 'Associar Álbum', 'dashboard/view/albums_assoc/', 100, '2015-01-19 11:45:00', NULL),
(200, 'Consulta', NULL, NULL, '2015-01-26 21:58:31', NULL),
(201, 'Consulta Álbum com Imagens', 'dashboard/view/images_albums/', 200, '2015-01-19 11:45:00', NULL),
(300, 'Configurações', NULL, NULL, '2016-01-26 21:59:10', NULL),
(301, 'Integrações', 'integrations/', 300, '2015-01-19 11:45:00', NULL);


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `username`, `firstname`, `lastname`, `email`, `userpassword`, `changepassword`, `hash_value`, `hash_date`) VALUES
(1, 'admin', 'Administrador', '', 'admin@radar.com', 'e10adc3949ba59abbe56e057f20f883e', b'0', NULL, NULL);

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`idpermission`, `iduser`, `idmodule`, `user_role`) VALUES
(1, 1, 101, 2),
(2, 1, 102, 2),
(3, 1, 103, 2),
(4, 1, 104, 2),
(5, 1, 201, 2),
(6, 1, 301, 2);


DELETE FROM settings WHERE variable = 'IMGUR_CLIENT_ID';
INSERT INTO settings ( `variable`, `description`, `value`, `idusercreator`,`creationdate` )
VALUES('IMGUR_CLIENT_ID', 'ID Cliente para comunicar e consumir a API do Imgur', '', 1, NOW());

SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
