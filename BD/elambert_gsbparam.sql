
-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 18 Octobre 2019 à 12:09
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `elambert_gsbparam`
--

DROP DATABASE IF EXISTS `elambert_gsbparam`;
CREATE DATABASE `elambert_gsbparam`;

--
-- Utilisateur pour la base de données : `elambert_gsbparam`
--
DROP USER IF EXISTS 'visiteurSite'@'localhost';
CREATE USER 'visiteurSite'@'localhost' IDENTIFIED BY 'a5UTXhjsMreUpAJU';
GRANT ALL PRIVILEGES ON `elambert_gsbparam`.* TO 'visiteurSite'@'localhost';

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`administrateur`
--

CREATE TABLE `elambert_gsbparam`.`administrateur` (
  `nom` char(32) COLLATE latin1_bin NOT NULL,
  `mdp` char(255) COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Contenu de la TABLE `elambert_gsbparam`.`administrateur`
--

INSERT INTO `elambert_gsbparam`.`administrateur` (`nom`, `mdp`) VALUES
('root1', 'root'),
('root', '$2y$10$vd3tGpa182f5ZzKy.2FaIORZ9wDktPzrQyAYJerkgOxOYhfCOwhO2');

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`categorie`
--

CREATE TABLE `elambert_gsbparam`.`categorie` (
  `id` char(32) COLLATE utf8_bin NOT NULL,
  `libelle` char(32) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la TABLE `elambert_gsbparam`.`categorie`
--

INSERT INTO `elambert_gsbparam`.`categorie` (`id`, `libelle`) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`client`
--

CREATE TABLE `elambert_gsbparam`.`client` (
  `mail` varchar(90) COLLATE utf8_bin NOT NULL,
  `mdp` varchar(255) COLLATE utf8_bin NOT NULL,
  `nom` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `prenom` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `rue` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `cp` char(5) COLLATE utf8_bin DEFAULT NULL,
  `ville` varchar(60) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la TABLE `elambert_gsbparam`.`client`
--

INSERT INTO `elambert_gsbparam`.`client` (`mail`, `mdp`, `nom`, `prenom`, `rue`, `cp`, `ville`) VALUES
('dupont@wanadoo.fr', '$2y$10$C099mWcA2WqRaQuLVCiH.OEQW5rJonwEn7RjxwYGkEWnHzY62cy3C', 'Dupont', 'Jacques', '12, rue haute', '75001', 'Paris'),
('durant@free.fr', '$2y$10$C099mWcA2WqRaQuLVCiH.OEQW5rJonwEn7RjxwYGkEWnHzY62cy3C', 'Durant', 'Yves', '23, rue des ombres', '75012', 'Paris'),
('guillaume.elambert@yahoo.fr', '$2y$10$C099mWcA2WqRaQuLVCiH.OEQW5rJonwEn7RjxwYGkEWnHzY62cy3C', 'Elambert', 'Guillaume', '8 bis rue de Saint Benoit', '78610', 'Auffargis');

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`commande`
--

CREATE TABLE `elambert_gsbparam`.`commande` (
  `id` char(32) COLLATE utf8_bin NOT NULL,
  `dateCommande` date DEFAULT NULL,
  `mailClient` varchar(90) COLLATE utf8_bin NOT NULL,
  `nomClient` varchar(90) COLLATE utf8_bin NOT NULL,
  `prenomClient` varchar(90) COLLATE utf8_bin NOT NULL,
  `rueClient` varchar(90) COLLATE utf8_bin NOT NULL,
  `cpClient` char(5) COLLATE utf8_bin NOT NULL,
  `villeClient` varchar(90) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la TABLE `elambert_gsbparam`.`commande`
--

INSERT INTO `elambert_gsbparam`.`commande` (`id`, `dateCommande`, `mailClient`, `nomClient`, `prenomClient`, `rueClient`, `cpClient`, `villeClient`) VALUES
('1101461660', '2011-07-12', 'dupont@wanadoo.fr', '', '', '', '', ''),
('1101461665', '2011-07-20', 'durant@free.fr', '', '', '', '', ''),
('1101461666', '2019-09-24', 'guillaume.elambert@yahoo.fr', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`contenir`
--

CREATE TABLE `elambert_gsbparam`.`contenir` (
  `idCommande` char(32) COLLATE utf8_bin NOT NULL,
  `idProduit` char(32) COLLATE utf8_bin NOT NULL,
  `qte` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`panier_client`
--

CREATE TABLE `elambert_gsbparam`.`panier_client` (
  `mailClient` varchar(90) COLLATE utf8_bin NOT NULL,
  `produit` char(32) COLLATE utf8_bin NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`produit`
--

CREATE TABLE `elambert_gsbparam`.`produit` (
  `id` char(32) COLLATE utf8_bin NOT NULL,
  `description` char(50) COLLATE utf8_bin DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `image` char(100) COLLATE utf8_bin DEFAULT NULL,
  `idCategorie` char(32) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la TABLE `elambert_gsbparam`.`produit`
--

INSERT INTO `elambert_gsbparam`.`produit` (`id`, `description`, `prix`, `image`, `idCategorie`) VALUES
('c01', 'Laino Shampooing Douche au Thé Vert BIO', '4.00', 'images/laino-shampooing-douche-au-the-vert-bio-200ml.png', 'CH'),
('c02', 'Klorane shampoo', '12.00', 'images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', 'CH'),
('c03', 'Weleda Kids 2in1 Shower & Shampoo Orange fruitée', '4.00', 'images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', 'CH'),
('c04', 'Weleda Kids 2in1 Shower & Shampoo vanille douce', '4.00', 'images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', 'CH'),
('c05', 'Klorane Shampooing sec à l\'extrait d\'ortie', '6.10', 'images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', 'CH'),
('c06', 'Phytopulp mousse volume intense', '18.00', 'images/phytopulp-mousse-volume-intense-200ml.jpg', 'CH'),
('c07', 'Bio Beaute by Nuxe Shampooing nutritif', '8.00', 'images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', 'CH'),
('f01', 'Nuxes Men Contour des Yeux Multi-Fonctions', '12.05', 'images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', 'FO'),
('f02', 'Tisane romon nature sommirel bio sachet 20', '5.50', 'images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', 'FO'),
('f03', 'La Roche Posay Cicaplast crème pansement', '11.00', 'images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', 'FO'),
('f04', 'Futuro sport stabilisateur pour cheville', '26.50', 'images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', 'FO'),
('f05', 'Microlife pèse-personne électronique weegschaal', '63.00', 'images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', 'FO'),
('f06', 'Melapi Miel Thym Liquide 500g', '6.50', 'images/melapi-miel-thym-liquide-500g.jpg', 'FO'),
('f07', 'Meli Meliflor Pollen 200g', '8.60', 'images/melapi-pollen-250g.jpg', 'FO'),
('p01', 'Avène solaire Spray très haute protection', '22.00', 'images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', 'PS'),
('p02', 'Mustela Solaire Lait très haute Protection', '17.50', 'images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', 'PS'),
('p03', 'Isdin Eryfotona aAK fluid', '29.00', 'images/isdin-eryfotona-aak-fluid-100-50ml.jpg', 'PS'),
('p04', 'La Roche Posay Anthélios 50+ Brume Visage', '8.75', 'images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', 'PS'),
('p05', 'Nuxe Sun Huile Lactée Capillaire Protectrice', '15.00', 'images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', 'PS'),
('p06', 'Uriage Bariésun stick lèvres SPF30 4g', '5.65', 'images/uriage-bariesun-stick-levres-spf30-4g.jpg', 'PS'),
('p07', 'Bioderma Cicabio creme SPF50+ 30ml', '13.70', 'images/bioderma-cicabio-creme-spf50-30ml.png', 'PS');

-- --------------------------------------------------------

--
-- Structure de la TABLE `elambert_gsbparam`.`promotion`
--

CREATE TABLE `elambert_gsbparam`.`promotion` (
  `idProduit` char(32) COLLATE utf8_bin NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `tauxPromo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la TABLE `elambert_gsbparam`.`administrateur`
--
ALTER TABLE `elambert_gsbparam`.`administrateur`
  ADD PRIMARY KEY (`nom`);

--
-- Index pour la TABLE `elambert_gsbparam`.`categorie`
--
ALTER TABLE `elambert_gsbparam`.`categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la TABLE `elambert_gsbparam`.`client`
--
ALTER TABLE `elambert_gsbparam`.`client`
  ADD PRIMARY KEY (`mail`);

--
-- Index pour la TABLE `elambert_gsbparam`.`commande`
--
ALTER TABLE `elambert_gsbparam`.`commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_client_commande_mail` (`mailClient`);

--
-- Index pour la TABLE `elambert_gsbparam`.`contenir`
--
ALTER TABLE `elambert_gsbparam`.`contenir`
  ADD PRIMARY KEY (`idCommande`,`idProduit`),
  ADD KEY `I_FK_CONTENIR_COMMANDE` (`idCommande`),
  ADD KEY `I_FK_CONTENIR_Produit` (`idProduit`);

--
-- Index pour la TABLE `elambert_gsbparam`.`panier_client`
--
ALTER TABLE `elambert_gsbparam`.`panier_client`
  ADD PRIMARY KEY (`produit`),
  ADD KEY `FK_client_panierClient_mailClient` (`mailClient`);

--
-- Index pour la TABLE `elambert_gsbparam`.`produit`
--
ALTER TABLE `elambert_gsbparam`.`produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `I_FK_Produit_CATEGORIE` (`idCategorie`);

--
-- Index pour la TABLE `elambert_gsbparam`.`promotion`
--
ALTER TABLE `elambert_gsbparam`.`promotion`
  ADD PRIMARY KEY (`idProduit`,`dateDebut`);


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la TABLE `elambert_gsbparam`.`commande`
--
ALTER TABLE `elambert_gsbparam`.`commande`
  ADD CONSTRAINT `FK_client_commande_mail` FOREIGN KEY (`mailClient`) REFERENCES `elambert_gsbparam`.`client` (`mail`);

--
-- Contraintes pour la TABLE `elambert_gsbparam`.`contenir`
--
ALTER TABLE `elambert_gsbparam`.`contenir`
  ADD CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `elambert_gsbparam`.`commande` (`id`),
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `elambert_gsbparam`.`produit` (`id`);

--
-- Contraintes pour la TABLE `elambert_gsbparam`.`produit`
--
ALTER TABLE `elambert_gsbparam`.`produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `elambert_gsbparam`.`categorie` (`id`);

--
-- Contraintes pour la TABLE `elambert_gsbparam`.`promotion`
--
ALTER TABLE `elambert_gsbparam`.`promotion`
  ADD CONSTRAINT `FK_idProduit_produit_promotion` FOREIGN KEY (`idProduit`) REFERENCES `elambert_gsbparam`.`produit` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
