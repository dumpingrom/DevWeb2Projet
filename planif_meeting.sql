-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 13 Mai 2015 à 19:40
-- Version du serveur: 5.5.43-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `planif_meeting`
--

-- --------------------------------------------------------

--
-- Structure de la table `creneaux`
--

CREATE TABLE IF NOT EXISTS `creneaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heureDebut` time NOT NULL,
  `heureFin` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `creneaux`
--

INSERT INTO `creneaux` (`id`, `heureDebut`, `heureFin`) VALUES
(1, '10:00:00', '12:00:00'),
(2, '14:00:00', '16:00:00'),
(3, '16:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `propositions`
--

CREATE TABLE IF NOT EXISTS `propositions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateProp` date NOT NULL,
  `idReunion` int(11) NOT NULL,
  `idCreneau` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=55 ;

--
-- Contenu de la table `propositions`
--

INSERT INTO `propositions` (`id`, `dateProp`, `idReunion`, `idCreneau`) VALUES
(28, '2015-06-03', 25, 2),
(29, '2015-05-14', 26, 1),
(30, '2015-05-14', 26, 2),
(31, '2015-05-14', 26, 3),
(32, '2015-05-21', 26, 2),
(33, '2015-05-21', 26, 3),
(34, '2015-05-28', 26, 1),
(35, '2015-05-28', 26, 2),
(36, '2015-05-13', 27, 1),
(37, '2015-05-13', 27, 2),
(38, '2015-05-14', 27, 2),
(39, '2015-05-14', 27, 3),
(40, '2015-05-14', 27, 2),
(42, '2015-05-15', 27, 1),
(43, '2015-05-15', 27, 2),
(44, '2015-05-15', 27, 3),
(45, '2015-05-22', 27, 2),
(46, '2015-05-22', 27, 3),
(47, '2015-05-28', 27, 2),
(48, '2015-05-28', 27, 3),
(49, '2015-06-05', 27, 2),
(50, '2015-06-05', 27, 3),
(51, '2015-07-10', 27, 2),
(52, '2016-01-08', 27, 1),
(53, '2016-01-08', 27, 2),
(54, '2016-02-05', 27, 2);

-- --------------------------------------------------------

--
-- Structure de la table `reunions`
--

CREATE TABLE IF NOT EXISTS `reunions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `idCreateur` int(11) NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=28 ;

--
-- Contenu de la table `reunions`
--

INSERT INTO `reunions` (`id`, `nom`, `idCreateur`, `dateCreation`) VALUES
(25, 'Reunion 3', 1, '2015-05-13 10:02:49'),
(26, 'Reunion 2', 1, '2015-05-13 10:35:19'),
(27, 'RÃ©union de la mort qui tue', 2, '2015-05-13 14:11:59');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `pwd` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `pwd`, `nom`, `prenom`) VALUES
(1, 'user1', '7c6a180b36896a0a8c02787eeafb0e4c', 'Bon', 'Jean'),
(2, 'user2', '6cb75f652a9b52798eb6cf2201057c73', 'Atan', 'Charles');

-- --------------------------------------------------------

--
-- Structure de la table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `idProp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
