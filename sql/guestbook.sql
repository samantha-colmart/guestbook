-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 29 jan. 2026 à 10:25
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `guestbook`
--

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_message` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `id_user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `message`, `id_user`, `date`) VALUES
(1, 'Très bon restaurant familial. La carte et les plats du jour sont très bons. La cuisine réalisée par un vrai chef est gouteuse et de qualité. le personnel est agréable et sympathique. L\'endroit est accueillant et les prix très corrects.', 1, '2026-01-28 18:40:15'),
(2, 'Restaurant irréprochable, le service l’accueil des plats raffinés. Séduite par cet endroit. La cuisine est très bonne et savoureuse, tout est maison, purée, frites etc. Un chef qui aime son métier, et une équipe aux petits soins. N’hésitez plus car les prix sont plus que corrects. Merci', 1, '2026-01-28 18:41:38'),
(3, 'Le Bistrot Français, un restaurant où l’on vient pour trouver des plats frais, traditionnels et authentiques ! Le chef cuisine avec passion et avec amour, et dans l’assiette on le sent directement. Une équipe au top et très conviviale dans un restaurant à la fois moderne et classique.', 1, '2026-01-28 18:43:02'),
(4, 'Super resto que je recommande vivement ! La cuisine y est simple mais excellente, l\'ambiance chaleureuse. Et les propriétaires vraiment très sympathiques. J\'y ai passé un moment très agréable.', 2, '2026-01-28 18:44:32'),
(5, 'Restaurant famille où, l’accueil, la qualité ainsi que les quantités sont toutes au rendez-vous. Les plats sont fait avec amour, et les desserts maisons à moindre coup. Rapport qualité prix irréprochable !', 2, '2026-01-28 18:45:49'),
(6, 'Très bon restaurant avec un service impeccable les plats sont frais. Je recommande vivement les prix sont très acceptables.', 2, '2026-01-28 18:46:36'),
(7, 'Restauration de qualité, prix adapté aux assiettes bien fournies de les de qualité, accueil chaleureux. Bravo', 3, '2026-01-28 18:48:12'),
(8, 'Bravo aux développeurs web pour ce site intuitif !', 3, '2026-01-28 18:49:07'),
(9, 'Merci la zone !!', 3, '2026-01-28 18:49:38'),
(10, 'Enfin un restaurant où l’accueil est très sympathique, service rapide, bonne qualité du plat du jour, tarif intéressant. En plus , ambiance familiale et cadre intérieur très reposant . A refaire', 3, '2026-01-28 19:01:46');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`) VALUES
(1, 'Samantha', '$2y$10$qYXSE5j24HlSmEr/Ei.vlOMXfaz6TLcm4YyKmUZyVXLgNbUiyUqzK'),
(2, 'Lorenzo', '$2y$10$NUryTeZ/Ad7OOmdKXoDQPO/AZLnUFdbuT8wY2GtTOwM3LZJM/olPC'),
(3, 'flogelin', '$2y$10$mga4UZhu2kpr9M6j5wkjZOMUsFytinsjQFtxHq6T/b9i8FWtjYuRK');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
