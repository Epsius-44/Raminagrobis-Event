-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 déc. 2021 à 14:24
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
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `color_primary` varchar(8) NOT NULL,
  `color_secondary` varchar(8) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `organisation` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `form_data`
--

DROP TABLE IF EXISTS `form_data`;
CREATE TABLE IF NOT EXISTS `form_data` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `civility` tinyint(3) UNSIGNED NOT NULL COMMENT '(0: Homme, 1: Femme, 2: Autre)',
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel_mob` varchar(255) NOT NULL,
  `tel_fix` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'False: Particulier, True: Entreprise',
  `comp_name` varchar(255) NOT NULL,
  `people_num` tinyint(3) UNSIGNED NOT NULL,
  `news` tinyint(1) NOT NULL,
  `score` tinyint(3) UNSIGNED NOT NULL,
  `id_form` int(10) UNSIGNED NOT NULL,
  `id_category` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_formdata_form` (`id_form`),
  KEY `fk_formdata_category` (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `sector`
--

DROP TABLE IF EXISTS `sector`;
CREATE TABLE IF NOT EXISTS `sector` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
