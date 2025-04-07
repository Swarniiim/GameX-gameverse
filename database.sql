-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2025 at 03:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinegamerating`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `game_id`, `created_at`) VALUES
(9, 6, 21, '2025-04-05 00:46:59'),
(11, 6, 16, '2025-04-05 00:47:07'),
(13, 6, 26, '2025-04-05 01:34:53'),
(16, 7, 22, '2025-04-05 01:38:26'),
(17, 7, 15, '2025-04-05 01:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) DEFAULT 'new',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `genre`, `platform`, `image`, `created_at`, `category`, `description`) VALUES
(1, 'Mother Machine', 'Adventure', 'PC', '1743733640_mothermachine.PNG', '2025-04-04 02:27:20', 'new', 'Mother Machine on Steam. Climb, jump, and explore procedurally generated alien caves in this 1-4 player co-op action-RPG platformer. Customize your cute gremlin, embrace the creative chaos, and unlock a vast array of mutations to shape your personal playstyle and role in a group!'),
(2, 'PUBG', 'Action', 'PC, Mobile', '1743736158_Pubg.PNG', '2025-04-04 03:09:18', 'top', 'PUBG: BATTLEGROUNDS is a battle royale that pits 100 players against each other. Players will land, loot, and survive in a shrinking battleground as they outplay their opponents to become the lone survivor'),
(3, 'Dota', 'Action', 'PC, PlayStation 5', '1743736190_dota.PNG', '2025-04-04 03:09:50', 'top', 'Dota 2 is a 2013 multiplayer online battle arena video game by Valve. The game is a sequel to Defense of the Ancients, a community-created mod for Blizzard Entertainment\'s Warcraft III: Reign of Chaos'),
(4, 'Freefire', 'Action', 'PC, Mobile', '1743736210_freefire.PNG', '2025-04-04 03:10:10', 'top', 'Free Fire formerly known as Garena Free Fire is a free-to-play battle royale game developed and published by Garena for Android and iOS. Released on December 8, 2017, the game gained widespread popularity, becoming the most downloaded mobile game globally in 2019'),
(5, 'Elroy', 'Adventure', 'PC, Mobile', '1743736227_elroy.jpg', '2025-04-04 03:10:27', 'new', 'Play as Elroy, a rocket engineer, and Peggie, a reporter. Solve puzzles, uncover secrets, and explore alien mysteries, in a hand-drawn 2D point-and-click'),
(6, 'Call of Duty', 'Action', 'PC, PlayStation 5, Mobile', '1743737915_callofduty.PNG', '2025-04-04 03:38:35', 'top', 'Call of Duty is a military first-person shooter video game series and media franchise published by Activision, starting in 2003. The games were first developed by Infinity Ward, then by Treyarch and Sledgehammer Games. Several spin-off and handheld games were made by other developers.'),
(7, 'Grand Theft Auto: Vice City', 'Action', 'PC, PlayStation 5, Xbox Series X', '1743738033_gta.PNG', '2025-04-04 03:40:33', 'top', 'Grand Theft Auto: Vice City is a 2002 action-adventure game developed by Rockstar North and published by Rockstar Games. It is the fourth main game in the Grand Theft Auto series, following 2001\'s Grand Theft Auto III, and the sixth entry overall'),
(8, 'Counter-Strike', 'first person shooter', 'PC, Xbox Series X', '1743739862_counter.PNG', '2025-04-04 04:11:02', 'top', 'Counter-Strike is a series of multiplayer tactical first-person shooter video games, in which opposing teams attempt to complete various objectives.'),
(9, 'Valorant', 'first person shooter', 'PC, PlayStation 5, Xbox Series X', '1743740076_valorant.PNG', '2025-04-04 04:14:36', 'top', 'Blend your style and experience on a global, competitive stage. You have 13 rounds to attack and defend your side using sharp gunplay and tactical abilities'),
(10, 'Sid Meier\'s Civilization', 'Strategy', 'PC', '1743741203_civilization.PNG', '2025-04-04 04:33:23', 'top', 'Civilization is a series of turn-based strategy video games, first released in 1991. Sid Meier developed the first game in the series and has had creative input for most of the rest, and his name is usually included in the formal title of these games, such as Sid Meier\'s Civilization VI'),
(11, 'Kaiserpunk', 'Strategy', 'PC', '1743741412_kaiserpunk.PNG', '2025-04-04 04:36:52', 'new', 'Build a city to rule the world in Kaiserpunk, a grand city builder blending production-focused city building with the world conquest of strategy games in an alternate 20th century world. Manage your city, grow industries, build a military, and defeat rivals to become the greatest empire.'),
(12, 'Dollhouse: Behind The Broken Mirror', 'Horror', 'PlayStation 5, Xbox Series X', '1743741552_dollhouse.PNG', '2025-04-04 04:39:12', 'upcoming', 'Dollhouse: Behind The Broken Mirror is a terrifying first-person horror adventure game that tells a dark and mysterious story in a cinematic style. Enter the broken mind of Eliza de Moor, a once-celebrated singer, now trapped in the labyrinth of her own forgotten memories'),
(13, 'Blades of Fire', 'Action', 'PC, PlayStation 5, Xbox Series X', '1743741652_blades.PNG', '2025-04-04 04:40:52', 'upcoming', 'From the award-winning MercurySteam comes a new action-adventure where you forge weapons, face fierce enemies in a unique combat system.'),
(14, 'Breakout Beyond', 'Action', 'PC, PlayStation 5, Xbox Series X, Mobile', '1743741752_breakoutbeyond.PNG', '2025-04-04 04:42:32', 'upcoming', 'In this neon-drenched take on the classic, you\'ll need to literally break through each puzzle by clearing bricks to breach the final goal'),
(15, 'South of Midnight', 'Adventure', 'PC, PlayStation 5, Mobile', '1743741910_southof midnight.PNG', '2025-04-04 04:45:10', 'upcoming', 'South of Midnight is an upcoming 2025 action-adventure game developed by Compulsion Games and published by Xbox Game Studios. The game is set in a fictionalized American Deep South.'),
(16, 'Fatal Fury: City of the Wolves', 'Action', 'PlayStation 5, Mobile', '1743742043_fatalfurry.PNG', '2025-04-04 04:47:23', 'upcoming', 'Fatal Fury: City of the Wolves is an upcoming fighting game developed and published by SNK. It is the first new entry in the Fatal Fury series in 26 years, following the release of Garou: Mark of the Wolves, and serves as a continuation of that game\'s story'),
(17, 'The Hundred Line: Last Defense Academy', 'Role_play', 'PC, PlayStation 5', '1743742169_hundredline.PNG', '2025-04-04 04:49:29', 'upcoming', 'The Hundred Line: Last Defense Academy is an upcoming tactical role-playing game developed by Too Kyo Games and Media.Vision and published by Aniplex'),
(18, 'Tempest Rising', 'Strategy', 'PC, PlayStation 5, Xbox Series X', '1743742302_tempestrising.PNG', '2025-04-04 04:51:42', 'upcoming', 'Tempest Rising is an upcoming real-time strategy video game developed by Slipgate Ironworks and 2B Games, and published by 3D Realms and Knights Peak'),
(19, 'Borderlands 4', 'first person shooter', 'PC, Mobile', '1743742432_borderlands4.PNG', '2025-04-04 04:53:52', 'upcoming', 'Borderlands 4 is an upcoming first-person shooter video game developed by Gearbox Software and published by 2K. It is a sequel to Borderlands 3 and the fifth entry in the main Borderlands series'),
(20, 'Assassin\'s Creed Shadows', 'Role_play', 'PC, PlayStation 5, Xbox Series X, Nintendo Switch,', '1743742557_asssincreedshadow.PNG', '2025-04-04 04:55:57', 'new', 'Assassin\'s Creed Shadows is a 2025 action role-playing game developed by Ubisoft Quebec and published by Ubisoft. The game is the fourteenth major installment in the Assassin\'s Creed series and the successor to Assassin\'s Creed Mirage'),
(21, 'BLEACH Rebirth of Souls', 'Action', 'PC, PlayStation 5, Xbox Series X', '1743742657_bleach.PNG', '2025-04-04 04:57:37', 'new', 'Bleach Rebirth of Souls is a fine one-on-one fighting game that summarises some of the best parts of the franchise\'s story. The gameplay is also engaging and fun to play once you get accustomed to its combat system.'),
(22, 'Suikoden I & II HD Remaster: Gate Rune and Dunan Unification Wars', 'Action', 'PlayStation 5, Xbox Series X', '1743742804_suikoden.PNG', '2025-04-04 05:00:04', 'new', 'A hero\'s destiny is written in the Stars— The legendary Konami JRPGs Suikoden I and Suikoden II have now been remastered in HD'),
(23, 'Alife Virtual', 'Adventure', 'PC', '1743743175_alifevirtual.PNG', '2025-04-04 05:06:15', 'new', 'Experience the ultimate 3D avatar world with limitless customization in Alife Virtual. Participate in exciting events, competitions, adventures.');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'sanish dhungana', 'sanish5@gmail.com', '$2y$10$OH9/e6G.Fgpmi9Lrwg3L/.9kW06ahnjkfPTUi7BuhO1jkq2yxGYJm', 0, '2025-04-04 01:11:32'),
(3, 'rijan', 'rijan1@gmail.com', '$2y$10$TYGi9i5ju6MHRX0T8Du9N.APybsL.E95qUL5RGoZtD.92wrmbO42q', 0, '2025-04-04 01:17:21'),
(4, 'Dana', 'Dana1@gmail.com', '$2y$10$5swzMVyihJSWA4Jx9VqZ/.Da85fHxMcVTuPZDnaXjLPShTLAMGkEK', 0, '2025-04-04 01:22:03'),
(5, 'admin', 'admin@gmail.com', '$2y$10$Z2.ekK8ULPvDFWd5r1fp9eRhLOXtQcFSYWXBfx0W6fW/CvCFcpzr2', 1, '2025-04-04 05:43:39'),
(6, 'Mausam', 'Mausam@gmail.com', '$2y$10$OGiaVqK/mLN6yOlLL3tINemg8Zmkln2iwy1MFAPQshBmW3PTMxv9O', 0, '2025-04-04 06:38:56'),
(7, 'Rijan', 'Rijan@gmail.com', '$2y$10$hVuIiEs/gRq0vuTRigpJBemklBaFOsFn5CZ6lv/2WXpj3w/CXlMmC', 0, '2025-04-05 01:37:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_favorite` (`user_id`,`game_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
