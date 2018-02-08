-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db654262744.db.1and1.com
-- Généré le :  Sam 30 Septembre 2017 à 15:02
-- Version du serveur :  5.5.57-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db654262744`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `auteur` varchar(25) NOT NULL,
  `date_p` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commande` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `date_p` varchar(255) NOT NULL,
  `ida` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `auteur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `harsh`
--

CREATE TABLE IF NOT EXISTS `harsh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_p` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `marijuana` varchar(255) NOT NULL,
  `heroine` varchar(255) NOT NULL,
  `cocaine` varchar(255) NOT NULL,
  `speed` varchar(255) NOT NULL,
  `bmarijuana` varchar(255) NOT NULL,
  `bheroine` varchar(255) NOT NULL,
  `bcocaine` varchar(255) NOT NULL,
  `bspeed` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `musique`
--

CREATE TABLE IF NOT EXISTS `musique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `date_p` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `date_p` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `product_name` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `product_desc` tinytext COLLATE latin1_general_ci NOT NULL,
  `product_img_name` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `price` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_code` (`product_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=45 ;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_desc`, `product_img_name`, `price`) VALUES
(1, '1', 'G19', '', 'g19.png', '20000'),
(2, '2', 'TT33', '', 'tt33.png', '30000'),
(3, '3', 'UZI', '', 'uzi.png', '60000'),
(4, '4', 'MK2', '', 'mk2.png', '50000'),
(5, '5', 'Deagle', '', 'deagle.png', '60000'),
(6, '6', 'PDW', '', 'pdw.jpg', '150000'),
(8, '8', 'SG553', '', 'sg.png', '250000'),
(9, '9', 'M16A4', '', 'm16a4.png', '250000'),
(10, '10', 'AKS74U', '', 'aks74u.png', '250000'),
(11, '11', 'AK12', '', 'ak12.png', '250000'),
(12, '12', 'AKS74', '', 'aks74.png', '250000'),
(13, '13', 'AEK971', '', 'ake971.png', '250000'),
(14, '14', 'Katiba', '', 'katiba.png', '300000'),
(15, '15', 'VZ61', '', 'vz61.png', '60000'),
(16, '16', 'Aug A3', '', 'auga3.png', '300000'),
(17, '17', 'ACP', '', 'acp.png', '30000'),
(18, '18', 'Chemlight', '', 'chemlight.png', '300'),
(19, '19', 'Viseur ACO', '', 'aco.png', '10000'),
(20, '20', 'Viseur Yorris', '', 'yorris.png', '5000'),
(21, '21', 'Viseur Barska', '', 'barska.png', '10000'),
(22, '22', 'Viseur RCO', '', 'rco.png', '25000'),
(23, '23', 'Viseur MRCO', '', 'mrco.png', '20000'),
(24, '24', 'Viseur Holo', '', 'holo.png', '18500'),
(26, '26', 'Viseur DMS', '', 'dms.png', '50000'),
(27, '27', 'Lampe', '', 'lampe.png', '1000'),
(28, '28', 'Fumigene', '', 'fumigene.png', '1000'),
(29, '29', 'Masque a Gaz', '', 'gaz.png', '2500'),
(30, '30', 'Bipied', '', 'bibpied.png', '750'),
(31, '31', 'RPK12', '', 'rpk12.png', '350000'),
(32, '32', 'AKM', '', 'akm.png', '350000'),
(33, '33', 'AK47', '', 'ak47.png', '350000'),
(34, '34', 'RK62', '', 'rk62.png', '400000'),
(35, '35', 'SIG5104', '', 'sig.png', '400000'),
(36, '36', 'Benelli', '', 'benelli.png', '400000'),
(37, '37', 'Pointeur laser', '', 'laser.png', '2000'),
(38, '38', 'Chargeurs ( Tous )', '', 'chargeurs.png', '3500'),
(39, '39', 'Tenue', '', 'tenue.png', '5000'),
(40, '40', 'Guillie 1', '', 'guillie1.png', '5000'),
(41, '41', 'Guillie 2', '', 'guillie2.png', '5000'),
(42, '42', 'Gillet P3', '', 'gillet.png', '15000'),
(43, '43', 'Gillet P4', '', 'gillet1.png', '15000'),
(44, '44', 'Serflex', '', 'serflex.png', '200');

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

CREATE TABLE IF NOT EXISTS `rencontre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statue` varchar(255) NOT NULL,
  `dangerosite` varchar(255) NOT NULL,
  `identite` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `informations` text NOT NULL,
  `pdv` text NOT NULL,
  `carte` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `revendication`
--

CREATE TABLE IF NOT EXISTS `revendication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `date_p` varchar(255) NOT NULL,
  `avatar` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `stockage`
--

CREATE TABLE IF NOT EXISTS `stockage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `nbcoffres` varchar(255) NOT NULL,
  `coordonnees` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `surnom` varchar(255) NOT NULL,
  `Cocaïne` varchar(255) NOT NULL,
  `Héroïne` varchar(255) NOT NULL,
  `Marijuana` varchar(255) NOT NULL,
  `Speed` varchar(255) NOT NULL,
  `commentaire` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `surnom` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `surnom2` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
