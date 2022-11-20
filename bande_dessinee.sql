-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 20 nov. 2022 à 12:14
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bande_dessinee`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `serie_id` int(11) DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `num` varchar(5) CHARACTER SET utf8 NOT NULL,
  `writer` varchar(100) CHARACTER SET utf8 NOT NULL,
  `illustrator` varchar(100) CHARACTER SET utf8 NOT NULL,
  `editor` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `releaseyear` smallint(5) UNSIGNED DEFAULT NULL,
  `strips` smallint(5) UNSIGNED DEFAULT NULL,
  `cover` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `rep` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `serie_id` (`serie_id`)
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `created`, `updated`, `serie_id`, `title`, `num`, `writer`, `illustrator`, `editor`, `releaseyear`, `strips`, `cover`, `rep`) VALUES
(41, '2022-11-15 17:30:29', '2022-11-15 17:39:13', 23, 'A Silent Voice Tome 1', '23597', 'Oima, Yoshitoki', 'Oima, Yoshitoki', 'Ki-oon', 2015, 192, 'assets/data/silentvoice1.jpg', 1),
(42, '2022-11-15 17:37:01', '2022-11-15 17:38:56', 23, 'A Silent Voice Tome 2', '24047', 'Oima, Yoshitoki', 'Oima, Yoshitoki', 'Ki-oon', 2015, 192, 'assets/data/silentvoice2.jpg', 1),
(43, '2022-11-16 00:03:46', '2022-11-16 13:13:43', 23, 'A Silent Voice Tome 3', '24633', 'Oima, Yoshitoki', 'Oima, Yoshitoki', 'Ki-oon', 2015, 172, 'assets/data/silentvoice3.jpg', 1),
(143, '2022-11-17 23:14:47', '2022-11-20 13:12:58', 23, 'A Silent Voice 4', '25067', 'Oima, Yoshitoki', 'Oima, Yoshitoki', 'Ki-oon', 2015, 188, 'assets/data/silentvoice4.jpg', 1),
(144, '2022-11-17 23:18:21', '2022-11-20 13:13:09', 23, 'A Silent Voice 5', '25067', 'Oima, Yoshitoki', 'Oima, Yoshitoki', 'Ki-oon', 2015, 188, 'assets/data/silentvoice5.jpg', 1),
(145, '2022-11-17 23:33:17', '2022-11-17 23:43:11', 27, 'Tintin au pays des Soviets', '32556', 'Hergé', 'Hergé', 'Casterman', 2004, 138, 'assets/data/tintin1.jpg', 1),
(146, '2022-11-17 23:37:55', '2022-11-17 23:43:27', 27, 'Tintin au congo', '32557', 'Hergé', 'Hergé', 'Casterman', 2004, 62, 'assets/data/tintin2.jpg', 1),
(147, '2022-11-17 23:42:27', '2022-11-18 00:00:08', 27, 'Tintin en Amérique', '32555', 'Hergé', 'Hergé', 'Casterman', 2004, 62, 'assets/data/tintin3.jpg', 1),
(148, '2022-11-20 12:56:01', '2022-11-20 13:05:59', 28, 'Le voyage de Chihiro 1', '24242', 'Miyazaki, Hayao', 'Miyazaki, Hayao', 'Glénat', 2003, 169, 'assets/data/Chihiro1.jpg', 1),
(149, '2022-11-20 12:58:36', '2022-11-20 12:58:54', 27, 'Tintin Les cigares au pharaon', '32559', 'Hergé', 'Hergé', 'Casterman', 2004, 62, 'assets/data/tintin4.jpg', 1),
(150, '2022-11-20 13:07:19', '2022-11-20 13:08:08', 28, 'Le voyage de Chihiro 2', '24244', 'Miyazaki, Hayao', 'Ghibli', 'Glénat', 2003, 169, 'assets/data/Chihiro2.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE IF NOT EXISTS `series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `origin` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `series`
--

INSERT INTO `series` (`id`, `created`, `updated`, `title`, `origin`) VALUES
(28, '2022-11-20 12:54:36', '2022-11-20 12:54:36', 'Le voyage de Chihiro', 'Japonais'),
(27, '2022-11-17 23:32:03', '2022-11-17 23:32:03', 'Tintin', 'Français'),
(23, '2022-11-15 17:28:54', '2022-11-16 12:47:17', 'A Silent Voice', 'Japonais');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
