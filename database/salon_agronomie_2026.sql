-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 09 mars 2026 à 16:13
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
-- Base de données : `salon_agronomie_2026`
--

-- --------------------------------------------------------

--
-- Structure de la table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `scanned_by_user_id` int(11) NOT NULL,
  `operator_session_id` int(11) NOT NULL,
  `attended_at` datetime NOT NULL DEFAULT current_timestamp(),
  `attendance_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `location_label` varchar(150) DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `points_reward` int(11) NOT NULL DEFAULT 20,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `location_label`, `start_at`, `end_at`, `points_reward`, `is_active`, `created_at`) VALUES
(1, 'Conférence Agroécologie', 'Session sur les pratiques agroécologiques', 'Salle A', '2026-03-10 09:00:00', '2026-03-10 11:00:00', 20, 1, '2026-03-08 18:21:54');

-- --------------------------------------------------------

--
-- Structure de la table `event_attendance`
--

CREATE TABLE `event_attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `scanned_by_user_id` int(11) NOT NULL,
  `operator_session_id` int(11) NOT NULL,
  `attended_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `operator_sessions`
--

CREATE TABLE `operator_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `operator_full_name` varchar(150) NOT NULL,
  `operator_promotion` varchar(100) NOT NULL,
  `operator_role_context` enum('stand','event') NOT NULL,
  `stand_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `started_at` datetime NOT NULL DEFAULT current_timestamp(),
  `ended_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `operator_sessions`
--

INSERT INTO `operator_sessions` (`id`, `user_id`, `operator_full_name`, `operator_promotion`, `operator_role_context`, `stand_id`, `event_id`, `started_at`, `ended_at`, `is_active`) VALUES
(1, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:27:45', NULL, 1),
(2, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:28:26', NULL, 1),
(3, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:32:03', NULL, 1),
(4, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:33:59', NULL, 1),
(5, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:42:24', NULL, 1),
(6, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:43:23', NULL, 1),
(7, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:43:30', NULL, 1),
(8, 7, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'stand', 1, NULL, '2026-03-08 18:47:19', NULL, 1),
(9, 5, 'RAHARISON Tovoniaina Steve', 'FAIDRANTSA', 'event', NULL, 1, '2026-03-08 18:51:35', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `points`
--

CREATE TABLE `points` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `source_type` enum('attendance','stand','event','bonus','manual') NOT NULL,
  `source_id` int(11) DEFAULT NULL,
  `points` int(11) NOT NULL,
  `awarded_by_user_id` int(11) NOT NULL,
  `operator_session_id` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `awarded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `points`
--

INSERT INTO `points` (`id`, `student_id`, `source_type`, `source_id`, `points`, `awarded_by_user_id`, `operator_session_id`, `note`, `awarded_at`) VALUES
(1, 1, 'stand', 1, 5, 7, 8, 'Points attribués pour visite du stand', '2026-03-08 18:49:29');

-- --------------------------------------------------------

--
-- Structure de la table `stands`
--

CREATE TABLE `stands` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `location_label` varchar(150) DEFAULT NULL,
  `points_per_visit` int(11) NOT NULL DEFAULT 5,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stands`
--

INSERT INTO `stands` (`id`, `name`, `description`, `location_label`, `points_per_visit`, `is_active`, `created_at`) VALUES
(1, 'Stand Semences', 'Présentation des semences améliorées', 'Zone A', 5, 1, '2026-03-08 18:36:13');

-- --------------------------------------------------------

--
-- Structure de la table `stand_visits`
--

CREATE TABLE `stand_visits` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `stand_id` int(11) NOT NULL,
  `scanned_by_user_id` int(11) NOT NULL,
  `operator_session_id` int(11) NOT NULL,
  `visited_at` datetime NOT NULL DEFAULT current_timestamp(),
  `visit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stand_visits`
--

INSERT INTO `stand_visits` (`id`, `student_id`, `stand_id`, `scanned_by_user_id`, `operator_session_id`, `visited_at`, `visit_date`) VALUES
(1, 1, 1, 7, 8, '2026-03-08 18:49:29', '2026-03-08');

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_code` varchar(30) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `promotion` varchar(100) NOT NULL,
  `qr_token` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `students`
--

INSERT INTO `students` (`id`, `student_code`, `first_name`, `last_name`, `promotion`, `qr_token`, `is_active`, `created_at`) VALUES
(1, '', 'Steve', 'RAHARISON', 'FAIDRANTSA', 'token_steve_001', 1, '2026-03-08 18:44:54');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','stand_manager','event_manager') NOT NULL,
  `stand_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `stand_id`, `event_id`, `is_active`, `created_at`) VALUES
(3, 'admin', '$2y$10$3oAjGJPv6BDC/QnWWICOmelQmWqnjN3KX.Wg.tPsC4F2qeo/A4/Oa', 'admin', NULL, NULL, 1, '2026-03-08 17:30:49'),
(5, 'conf_agro', '$2y$10$uOvOnn4euurZPdJAJzaN/OL1YYr8yjLRRhZE7CsMAhELiHOvOUcZm', 'event_manager', NULL, 1, 1, '2026-03-08 18:24:20'),
(7, 'stand_semences', '$2y$10$AmbDKZRobzSkdApAGtwJneafnse4ZxvU.qhAMOVzekR.XXBH2/nvO', 'stand_manager', 1, NULL, 1, '2026-03-08 18:38:42');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_attendance_day` (`student_id`,`attendance_date`),
  ADD KEY `fk_attendance_user` (`scanned_by_user_id`),
  ADD KEY `fk_attendance_operator_session` (`operator_session_id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_student_event` (`student_id`,`event_id`),
  ADD KEY `fk_event_attendance_event` (`event_id`),
  ADD KEY `fk_event_attendance_user` (`scanned_by_user_id`),
  ADD KEY `fk_event_attendance_operator_session` (`operator_session_id`);

--
-- Index pour la table `operator_sessions`
--
ALTER TABLE `operator_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_operator_sessions_user` (`user_id`),
  ADD KEY `fk_operator_sessions_stand` (`stand_id`),
  ADD KEY `fk_operator_sessions_event` (`event_id`);

--
-- Index pour la table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_points_student` (`student_id`),
  ADD KEY `fk_points_user` (`awarded_by_user_id`),
  ADD KEY `fk_points_operator_session` (`operator_session_id`);

--
-- Index pour la table `stands`
--
ALTER TABLE `stands`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stand_visits`
--
ALTER TABLE `stand_visits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_stand_visit_day` (`student_id`,`stand_id`,`visit_date`),
  ADD KEY `fk_stand_visits_stand` (`stand_id`),
  ADD KEY `fk_stand_visits_user` (`scanned_by_user_id`),
  ADD KEY `fk_stand_visits_operator_session` (`operator_session_id`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qr_token` (`qr_token`),
  ADD UNIQUE KEY `student_code` (`student_code`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_stand` (`stand_id`),
  ADD KEY `fk_users_event` (`event_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `event_attendance`
--
ALTER TABLE `event_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `operator_sessions`
--
ALTER TABLE `operator_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `points`
--
ALTER TABLE `points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `stands`
--
ALTER TABLE `stands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `stand_visits`
--
ALTER TABLE `stand_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_operator_session` FOREIGN KEY (`operator_session_id`) REFERENCES `operator_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attendance_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attendance_user` FOREIGN KEY (`scanned_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `fk_event_attendance_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_attendance_operator_session` FOREIGN KEY (`operator_session_id`) REFERENCES `operator_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_attendance_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_event_attendance_user` FOREIGN KEY (`scanned_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `operator_sessions`
--
ALTER TABLE `operator_sessions`
  ADD CONSTRAINT `fk_operator_sessions_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_operator_sessions_stand` FOREIGN KEY (`stand_id`) REFERENCES `stands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_operator_sessions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `fk_points_operator_session` FOREIGN KEY (`operator_session_id`) REFERENCES `operator_sessions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_points_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_points_user` FOREIGN KEY (`awarded_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stand_visits`
--
ALTER TABLE `stand_visits`
  ADD CONSTRAINT `fk_stand_visits_operator_session` FOREIGN KEY (`operator_session_id`) REFERENCES `operator_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stand_visits_stand` FOREIGN KEY (`stand_id`) REFERENCES `stands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stand_visits_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stand_visits_user` FOREIGN KEY (`scanned_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_stand` FOREIGN KEY (`stand_id`) REFERENCES `stands` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

