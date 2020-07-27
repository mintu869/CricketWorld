-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2020 at 05:53 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cricket_world`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id_1` int(11) NOT NULL,
  `team_id_2` int(11) NOT NULL,
  `team_1_runs` int(11) DEFAULT NULL,
  `team_2_runs` int(11) DEFAULT NULL,
  `match_date` date NOT NULL,
  `winner_id` int(11) DEFAULT NULL,
  `result` enum('Win and loss','Tie','No result','Being Played','Yet To Be Played') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Yet To Be Played',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `winning_points` int(11) DEFAULT NULL,
  `points_to_both` int(11) DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_07_23_044858_teams', 2),
(4, '2020_07_23_045056_players', 3),
(5, '2020_07_23_045418_matches', 3),
(6, '2020_07_23_045454_points', 3),
(7, '2020_07_23_051844_create_player_history', 4),
(8, '2020_07_25_061656_alter_matches', 5),
(9, '2020_07_25_061723_alter_teams', 5),
(10, '2020_07_25_062434_alter_players', 5),
(11, '2020_07_25_064623_create_venues_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jersey_number` int(11) NOT NULL,
  `country` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` char(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `team_id`, `first_name`, `last_name`, `jersey_number`, `country`, `deleted_at`, `created_at`, `updated_at`, `image`) VALUES
(1, 1, 'PlayerL', 'LastT', 78, 'country5', NULL, '2020-07-23 01:33:27', '2020-07-23 01:33:27', ''),
(2, 1, 'Playerg', 'Last8', 22, 'country5', NULL, '2020-07-23 01:33:30', '2020-07-23 01:33:30', ''),
(3, 1, 'Playerp', 'LastE', 88, 'country2', NULL, '2020-07-23 01:33:32', '2020-07-23 01:33:32', ''),
(4, 1, 'Player6', 'Lastp', 18, 'country6', NULL, '2020-07-23 01:33:34', '2020-07-23 01:33:34', ''),
(5, 1, 'PlayerP', 'Lastu', 35, 'country9', NULL, '2020-07-23 01:33:36', '2020-07-23 01:33:36', ''),
(6, 1, 'PlayerE', 'LastW', 6, 'country10', NULL, '2020-07-23 01:33:37', '2020-07-23 01:33:37', ''),
(7, 1, 'Player6', 'LastX', 71, 'country3', NULL, '2020-07-23 01:33:39', '2020-07-23 01:33:39', ''),
(8, 1, 'Playerj', 'LastV', 29, 'country10', NULL, '2020-07-23 01:33:41', '2020-07-23 01:33:41', ''),
(9, 1, 'PlayerQ', 'Lasti', 97, 'country4', NULL, '2020-07-23 01:33:42', '2020-07-23 01:33:42', ''),
(10, 1, 'Playert', 'LastU', 7, 'country4', NULL, '2020-07-23 01:33:44', '2020-07-23 01:33:44', ''),
(11, 1, 'Playerl', 'Lastz', 39, 'country9', NULL, '2020-07-23 01:33:46', '2020-07-23 01:33:46', '');

-- --------------------------------------------------------

--
-- Table structure for table `player_histories`
--

CREATE TABLE `player_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player_id` int(11) NOT NULL,
  `matches` int(11) NOT NULL,
  `runs` int(11) NOT NULL,
  `highest_score` int(11) NOT NULL,
  `fifties` int(11) NOT NULL,
  `hundreds` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player_histories`
--

INSERT INTO `player_histories` (`id`, `player_id`, `matches`, `runs`, `highest_score`, `fifties`, `hundreds`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 23, 245, 56, 2, 0, NULL, NULL, NULL),
(2, 2, 23, 350, 70, 2, 0, NULL, NULL, NULL),
(3, 3, 23, 650, 110, 2, 1, NULL, NULL, NULL),
(4, 4, 23, 132, 90, 1, 0, NULL, NULL, NULL),
(5, 5, 23, 345, 119, 2, 2, NULL, NULL, NULL),
(6, 6, 23, 243, 134, 2, 1, NULL, NULL, NULL),
(7, 7, 23, 675, 67, 1, 1, NULL, NULL, NULL),
(8, 8, 23, 278, 23, 0, 0, NULL, NULL, NULL),
(9, 9, 23, 367, 56, 6, 0, NULL, NULL, NULL),
(10, 10, 23, 212, 78, 4, 0, NULL, NULL, NULL),
(11, 11, 23, 115, 98, 2, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `club` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `logo`, `club`, `deleted_at`, `created_at`, `updated_at`, `points`) VALUES
(1, 'Team 1', 'logo_3.jpg', 'Club 9', NULL, '2020-07-23 01:25:58', '2020-07-26 22:18:30', 9),
(2, 'Team 2', 'logo_2.png', 'Club 1', NULL, '2020-07-23 01:26:39', '2020-07-26 10:38:50', 1),
(3, 'Team 3', 'logo_1.png', 'Club 6', NULL, '2020-07-23 01:30:11', '2020-07-23 01:30:11', 0),
(8, 'Team 4', 'logo_1.png', 'Club 3', NULL, '2020-07-23 01:30:11', '2020-07-23 01:30:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mhTvmjzjP3', 'lYTsZg8BpU@gmail.com', NULL, '$2y$10$kgVq7DZ1f5cfzABvmrgrBeviQjsK4AlgUshcMrLZzS9Z.lm/KKdVa', NULL, '2020-07-23 00:54:24', '2020-07-23 00:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Venue 1', NULL, NULL),
(2, 'Venue 2', NULL, NULL),
(3, 'Venue 3', NULL, NULL),
(4, 'Venue 4', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_histories`
--
ALTER TABLE `player_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `player_histories`
--
ALTER TABLE `player_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
