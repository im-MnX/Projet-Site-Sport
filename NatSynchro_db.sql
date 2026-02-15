-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 15 fév. 2026 à 14:13
-- Version du serveur : 10.11.14-MariaDB-0+deb12u2
-- Version de PHP : 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test_Nat`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

CREATE TABLE `actualite` (
  `idActualite` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`idActualite`, `titre`, `date`, `images`, `description`) VALUES
(3, 'Championnat', '2025-12-31', 'perou_11698c4e8da5f16-698c5fb7da985.jpg', 'championnat !!!'),
(4, 'inscriptions aux compétitions', '2026-12-17', 'Logo_60ans.png', 'inscriptiosn');

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE `album` (
  `idAlbum` int(11) NOT NULL,
  `description` longtext DEFAULT NULL,
  `idCategorieAlbum` int(11) NOT NULL,
  `priorite` int(11) NOT NULL DEFAULT 0,
  `archive` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `album`
--

INSERT INTO `album` (`idAlbum`, `description`, `idCategorieAlbum`, `priorite`, `archive`) VALUES
(1, 'Gala 2024', 1, 1, 0),
(2, 'Inter-Régional', 2, 2, 0),
(3, 'Jean-Bouin', 3, 3, 0),
(4, '60 ans', 4, 4, 0),
(5, 'Gala 2025', 1, 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `categoriealbum`
--

CREATE TABLE `categoriealbum` (
  `idCategorieAlbum` int(11) NOT NULL,
  `libelleCategorieAlbum` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categoriealbum`
--

INSERT INTO `categoriealbum` (`idCategorieAlbum`, `libelleCategorieAlbum`) VALUES
(1, 'Gala'),
(2, 'Compétition'),
(3, 'Piscine'),
(4, 'Evènements');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `idCommande` int(11) NOT NULL,
  `dateCommande` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260213122259', '2026-02-13 12:22:59', 26);

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`id`, `titre`, `identifiant`, `filename`, `updated_at`) VALUES
(1, 'Planning des cours', 'PLANNING_COURS', 'uploads/documents/PlanningCours-698ef4421c329.pdf', '2026-02-13 09:52:02'),
(2, 'Planning des compétitions', 'PLANNING_COMPETITIONS', 'PlanningCompetitions/PlanningCompetitions.pdf', '2026-02-12 14:01:32'),
(3, 'Fiche d\'inscription', 'FICHE_INSCRIPTION', 'FichiersInscription/Feuille-inscription.docx', '2026-02-12 14:01:32'),
(4, 'Feuille d\'urgence', 'FEUILLE_URGENCE', 'FichiersInscription/Feuille-urgence.pdf', '2026-02-12 14:01:32'),
(5, 'Moyen de paiement', 'MOYEN_PAIEMENT', 'FichiersInscription/Feuille-inscription-comptabilite.docx', '2026-02-12 14:01:32'),
(6, 'Formulaire licence FFN', 'FORMULAIRE_LICENCE_FFN', 'FichiersInscription/Formulairelicencemineur20252026remplissable.pdf', '2026-02-12 14:01:32');

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `idEvenement` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `dateEvenement` date NOT NULL,
  `idTypeEvenement` int(11) NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `horaire` time NOT NULL,
  `brochure_filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evenement`
--

INSERT INTO `evenement` (`idEvenement`, `nom`, `dateEvenement`, `idTypeEvenement`, `images`, `description`, `horaire`, `brochure_filename`) VALUES
(1, 'Evenement Test', '2026-05-21', 1, 'perou-23-698dd8538de91-698f21ea38418.jpg', '<figure class=\"image\"><img style=\"aspect-ratio:275/183;\" src=\"/uploads/editor/imageschat-698f21d5cf40f.jpg\" width=\"275\" height=\"183\"></figure><h2><strong>🎭 Grand Gala Annuel : \"Éclats d\'Eau\"</strong></h2><p>Plongez au cœur d\'un spectacle inoubliable ! Les nageuses et nageurs d\'<strong>Angers Nat Synchro</strong> vous invitent à leur grand gala de fin d\'année. Cette édition spéciale, intitulée <strong>\"Éclats d\'Eau\"</strong>, vous fera voyager à travers des chorégraphies dynamiques, alliant <strong>grâce</strong>, <strong>musique</strong> et <strong>prouesse technique</strong>.</p><figure class=\"media\"><oembed url=\"https://youtu.be/DozU24Mr0-w?si=P-yrDsJXnDZZKlVG\"></oembed></figure><p>Ce que vous réserve cette soirée :</p><ul><li><strong>Plus de 15 tableaux</strong> originaux présentés par toutes nos sections.</li><li>Une mise en scène exceptionnelle avec des <strong>jeux de lumières</strong> aquatiques.</li><li>Une <strong>buvette et petite restauration</strong> disponible sur place.</li></ul><p>📅 <strong>Informations Pratiques :</strong></p><ul><li><strong>Lieu :</strong> Piscine Jean Bouin, Angers.</li><li><strong>Ouverture des portes :</strong> 19h30.</li><li><strong>Début du spectacle :</strong> 20h00 précises.</li></ul><p>🎟️ <strong>Billetterie :</strong> Ne manquez pas ce rendez-vous exceptionnel ! Les places sont limitées. 👉 <a href=\"https://www.helloasso.com/\"><strong>Réservez vos places en ligne ici</strong></a> (paiement sécurisé).</p><p>Pour toute question concernant l\'événement, vous pouvez nous envoyer un message via notre</p><p>&nbsp;</p><p>formulaire de contact ou télécharger le programme complet ci-dessous.</p>', '11:30:00', 'Document-sans-titre-698f1a5a74582.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `idCommande` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixUnitaire` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
  `idFaq` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partenaires`
--

CREATE TABLE `partenaires` (
  `id` int(11) NOT NULL,
  `nom_partenaire` varchar(255) NOT NULL,
  `logo_partenaire` varchar(255) NOT NULL,
  `lien_partenaire` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partenaires`
--

INSERT INTO `partenaires` (`id`, `nom_partenaire`, `logo_partenaire`, `lien_partenaire`) VALUES
(3, 'Maison Barthelaix', 'BarthelaixLogo-698ef5c083224.png', 'https://www.barthelaix49.com/'),
(4, 'Flunch', 'FlunchLogo-698ef64da06b2.png', 'https://www.flunch.fr/'),
(5, 'SynchrOLoc', 'SynchrOLocLogo-698ef6e66809c.gif', 'https://www.synchroloc.fr/');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `idPhoto` int(11) NOT NULL,
  `idAlbum` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `cheminImage` varchar(255) DEFAULT NULL,
  `datePhoto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`idPhoto`, `idAlbum`, `titre`, `cheminImage`, `datePhoto`) VALUES
(1, 5, 'Test', 'photo1.jpg', '2025-12-12'),
(2, 1, 'Test', 'photo2.jpg', '2025-12-12'),
(3, 1, 'Test', 'photo3.jpg', '2025-12-12'),
(4, 1, 'Test', 'photo4.jpg', '2025-12-12'),
(5, 1, 'Test', 'photo5.jpg', '2025-12-12'),
(6, 2, 'Test', 'photo1.jpg', '2025-12-12'),
(7, 2, 'Test', 'photo2.jpg', '2025-12-12'),
(8, 2, 'Test', 'photo3.jpg', '2025-12-12'),
(9, 2, 'Test', 'photo4.jpg', '2025-12-12'),
(10, 2, 'Test', 'photo5.jpg', '2025-12-12'),
(11, 3, 'Test', 'photo1.jpg', '2025-12-12'),
(12, 3, 'Test', 'photo2.jpg', '2025-12-12'),
(13, 3, 'Test', 'photo3.png', '2025-12-12'),
(14, 3, 'Test', 'photo4.jpeg', '2025-12-12'),
(15, 4, 'Test', 'photo1.jpg', '2025-12-12'),
(16, 4, 'Test', 'photo2.png', '2025-12-12');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `idProduit` int(11) NOT NULL,
  `nomProduit` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `nomProduit`, `description`, `prix`, `stock`, `image`) VALUES
(1, 'Bonnet de bain', 'bonnet super', 30.00, 10, 'Logo_60ans.png'),
(2, 'Pince-nez', NULL, 10.00, 150, 'Logo_60ans.png');

-- --------------------------------------------------------

--
-- Structure de la table `typeEvenement`
--

CREATE TABLE `typeEvenement` (
  `idTypeEvenement` int(11) NOT NULL,
  `libelleTypeEvenement` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `typeEvenement`
--

INSERT INTO `typeEvenement` (`idTypeEvenement`, `libelleTypeEvenement`) VALUES
(1, 'Gala'),
(2, 'Championnat'),
(3, 'Inscription');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `email`, `password`, `roles`) VALUES
(4, 'admin@club.com', '$2y$13$4r.7zGCBecTggjv5n12vNuyku9ZUUYaFogZOBGBB8p9Jcg.ZsfWiW', '[\"ROLE_ADMIN\"]');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualite`
--
ALTER TABLE `actualite`
  ADD PRIMARY KEY (`idActualite`);

--
-- Index pour la table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`idAlbum`),
  ADD KEY `IDX_39986E43E495F98` (`idCategorieAlbum`);

--
-- Index pour la table `categoriealbum`
--
ALTER TABLE `categoriealbum`
  ADD PRIMARY KEY (`idCategorieAlbum`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idCommande`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D8698A76C90409EC` (`identifiant`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`idEvenement`),
  ADD KEY `IDX_B26681EA00CD40F` (`idTypeEvenement`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idCommande`,`idProduit`),
  ADD KEY `IDX_FE866410391C87D5` (`idProduit`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`idFaq`);

--
-- Index pour la table `partenaires`
--
ALTER TABLE `partenaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`idPhoto`),
  ADD KEY `IDX_14B784182E5C2D5E` (`idAlbum`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`idProduit`);

--
-- Index pour la table `typeEvenement`
--
ALTER TABLE `typeEvenement`
  ADD PRIMARY KEY (`idTypeEvenement`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `UNIQ_1D1C63B3E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actualite`
--
ALTER TABLE `actualite`
  MODIFY `idActualite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `album`
--
ALTER TABLE `album`
  MODIFY `idAlbum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `categoriealbum`
--
ALTER TABLE `categoriealbum`
  MODIFY `idCategorieAlbum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `idEvenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `idFaq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partenaires`
--
ALTER TABLE `partenaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `idPhoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `idProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `typeEvenement`
--
ALTER TABLE `typeEvenement`
  MODIFY `idTypeEvenement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`idCategorieAlbum`) REFERENCES `categoriealbum` (`idCategorieAlbum`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`idTypeEvenement`) REFERENCES `typeEvenement` (`idTypeEvenement`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `commande` (`idCommande`),
  ADD CONSTRAINT `facture_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`idAlbum`) REFERENCES `album` (`idAlbum`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
