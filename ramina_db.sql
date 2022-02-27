-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 04 fév. 2022 à 07:52
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
-- Base de données : `ramina_db`
--
CREATE DATABASE IF NOT EXISTS `ramina_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ramina_db`;

-- --------------------------------------------------------

--
-- Structure de la table `form`
--

DROP TABLE IF EXISTS `form`;
CREATE TABLE IF NOT EXISTS `form` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(127) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `color_primary` varchar(6) NOT NULL,
  `color_secondary` varchar(6) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `organisation` varchar(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `form`
--

INSERT INTO `form` (`id`, `title`, `description`, `image`, `color_primary`, `color_secondary`, `start_date`, `end_date`, `organisation`) VALUES
(1, 'La ville de demain', 'Le 14 septembre 2022 Ã  Nantes (citÃ© des congrÃ¨s) entre 14h et 20h.\r\n1Ã¨re Ã©dition interprofessionnel de la ville de demain avec (Architecture, les transports, les nouvelles technologies) ', '2022-02-03-14-44-15_Vinci Immobilier-La ville de demain.jpg', 'abe1a8', '20ac4f', '2022-02-03', '2022-07-31', 'Vinci Immobilier'),
(2, 'PrÃ©sentation des placements', 'Le 05 mai 2022 Ã  l\'agence de Sainte Luce sur Loire de 17h Ã  18h.\r\nPrÃ©sentation des diffÃ©rents placements financiers avec leurs avantages et leurs risques.', '2022-02-03-15-13-31_Banque Populaire Grand Ouest-PrÃ©sentation des placements.jpg', 'a8b7ff', '0806a2', '2022-02-03', '2022-04-30', 'Banque Populaire Grand Ouest'),
(3, 'Festival annuel de la photo', 'Le 20 juin Ã  Paris.\r\nTroisiÃ¨me Ã©dition du festival de la photo. Cette annÃ©e le thÃ¨me est la solidaritÃ©.', '2022-02-03-20-00-17_ParisArt-Festival annuel de la photo.jpg', 'ddd497', '8e6306', '2022-03-01', '2022-06-17', 'ParisArt'),
(4, 'Biennale de Venise', 'Ouverture le 30 fÃ©vrier 2022 Ã  Venise.\r\nComme tout les ans la ville organise un festival des arts visuels. Cette annÃ©e la cÃ©rÃ©monie d\'ouverture met Ã  l\'honneur la peinture.', '2022-02-03-20-06-51_Comune di Venezia-Biennale de Venise.jpg', 'd6a8a8', '8f0000', '2021-12-01', '2022-02-01', 'Comune di Venezia');

-- --------------------------------------------------------

--
-- Structure de la table `form_data`
--

DROP TABLE IF EXISTS `form_data`;
CREATE TABLE IF NOT EXISTS `form_data` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `civility` tinyint(3) UNSIGNED NOT NULL COMMENT '(0: Homme, 1: Femme, 2: Autre)',
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel_mob` varchar(10) DEFAULT NULL,
  `tel_fix` varchar(10) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'False: Particulier, True: Entreprise',
  `comp_name` varchar(32) DEFAULT NULL,
  `people_num` smallint(12) UNSIGNED NOT NULL,
  `news` tinyint(1) NOT NULL,
  `score` smallint(12) UNSIGNED NOT NULL,
  `id_form` int(10) UNSIGNED NOT NULL,
  `id_category` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_formdata_form` (`id_form`),
  KEY `fk_formdata_category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `form_data`
--

INSERT INTO `form_data` (`id`, `civility`, `firstname`, `lastname`, `email`, `tel_mob`, `tel_fix`, `type`, `comp_name`, `people_num`, `news`, `score`, `id_form`, `id_category`) VALUES
(1, 0, 'Jean-Paul', 'Dupain', 'jeanpaul.dupain@gmail.com', '0634346723', '0278376109', 0, NULL, 2, 1, 5, 4, NULL),
(2, 1, 'Emma-Louise', 'Bossons', 'emmalouise@psynapse.fr', '0767235617', '0927183463', 1, 'Psynapse', 1, 0, 6, 4, 9),
(3, 2, 'Ylesoa', 'Cesar', 'ylesoa.cesar@gmx.fr', NULL, NULL, 1, 'PrintExpress', 5, 1, 9, 4, 4),
(7, 0, 'Quentin', 'Kasimirczak', 'quentin.kasimirczak@epsi.fr', NULL, NULL, 1, 'Raminagrobis', 1, 0, 4, 1, 1),
(8, 0, 'Tom', 'Chanson', 'tom.chanson@epsi.fr', NULL, NULL, 1, 'Raminagrobis', 1, 0, 4, 1, 1),
(9, 0, 'Louis', 'Ducruet', 'louis.ducruet@epsi.fr', NULL, NULL, 1, 'Raminagrobis', 1, 0, 4, 1, 1),
(11, 1, 'Michelle', 'Chocolatine', 'm.chocolatine@pain-au-choc.fr', NULL, NULL, 0, NULL, 1, 0, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `form_sector`
--

DROP TABLE IF EXISTS `form_sector`;
CREATE TABLE IF NOT EXISTS `form_sector` (
  `id_form` int(10) UNSIGNED NOT NULL,
  `id_sector` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_form`,`id_sector`),
  KEY `fk_formsector_sector` (`id_sector`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `form_sector`
--

INSERT INTO `form_sector` (`id_form`, `id_sector`) VALUES
(1, 1),
(2, 1),
(3, 1),
(2, 2),
(2, 3),
(2, 4),
(4, 4),
(1, 5),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 8),
(4, 8),
(2, 9),
(3, 9),
(4, 9),
(1, 10),
(2, 10),
(2, 11),
(1, 12),
(2, 12),
(2, 13),
(2, 14),
(1, 15),
(2, 15),
(3, 15),
(4, 15);

-- --------------------------------------------------------

--
-- Structure de la table `sector`
--

DROP TABLE IF EXISTS `sector`;
CREATE TABLE IF NOT EXISTS `sector` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sector`
--

INSERT INTO `sector` (`id`, `name`) VALUES
(1, 'Informatique'),
(2, 'Agroalimentaire'),
(3, 'Banque / Assurance'),
(4, 'Imprimerie'),
(5, 'BTP'),
(6, 'Chimie'),
(7, 'Commerce'),
(8, 'MultimÃ©dia'),
(9, 'Conseils'),
(10, 'Electronique'),
(11, 'SantÃ©'),
(12, 'Transport'),
(13, 'Textile'),
(14, 'Industrie'),
(15, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` char(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`) VALUES
(1, 'admin', 'admin', 'admin@raminagrobis.fr'),
(2, 'Kevin', '1234', 'kevin@raminagrobis.fr');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `form_data`
--
ALTER TABLE `form_data`
  ADD CONSTRAINT `fk_formdata_category` FOREIGN KEY (`id_category`) REFERENCES `sector` (`id`),
  ADD CONSTRAINT `fk_formdata_form` FOREIGN KEY (`id_form`) REFERENCES `form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `form_sector`
--
ALTER TABLE `form_sector`
  ADD CONSTRAINT `fk_fomcat_category` FOREIGN KEY (`id_sector`) REFERENCES `sector` (`id`),
  ADD CONSTRAINT `fk_formcat_form` FOREIGN KEY (`id_form`) REFERENCES `form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
