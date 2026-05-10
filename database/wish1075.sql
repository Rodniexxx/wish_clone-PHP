-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2026 at 10:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wish1075`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `social_facebook` varchar(255) DEFAULT NULL,
  `social_instagram` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT NULL,
  `social_spotify` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `status` enum('draft','published') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `slug`, `bio`, `image`, `genre`, `social_facebook`, `social_instagram`, `social_twitter`, `social_spotify`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kenan', 'kenan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'published', '2026-05-10 07:33:18', '2026-05-10 07:33:18'),
(2, 'Silent Sanctuary', 'silent-sanctuary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'published', '2026-05-10 07:33:18', '2026-05-10 07:33:18'),
(3, 'Yazmin Aziz', 'yazmin-aziz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'published', '2026-05-10 07:33:18', '2026-05-10 07:33:18'),
(4, 'Gwyn Dorado', 'gwyn-dorado', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'published', '2026-05-10 07:33:18', '2026-05-10 07:33:18'),
(5, 'Over October', 'over-october', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'published', '2026-05-10 07:33:18', '2026-05-10 07:33:18'),
(6, 'Jan Roberts', 'jan-roberts-and-johnoy-danao', '', NULL, '', '', '', '', '', 1, 'published', '2026-05-10 07:33:18', '2026-05-10 08:09:29'),
(7, 'Wilbert Ross', '', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 07:53:31', '2026-05-10 07:53:31'),
(8, 'Julie Anne San Jose', '-6a003b04511cb', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 08:00:04', '2026-05-10 08:00:04'),
(9, 'Chloe Redondo', '-6a003bc75b260', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 08:03:19', '2026-05-10 08:03:19'),
(10, 'Smugglaz', '-6a003bd0c07bb', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 08:03:28', '2026-05-10 08:03:28'),
(11, 'Sisa', '-6a003c7326081', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 08:06:11', '2026-05-10 08:06:11'),
(12, 'Oh Stella!', '-6a003c98e8a19', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 08:06:48', '2026-05-10 08:06:48'),
(13, 'Johnoy Danao', '-6a003d401becc', '', '', '', '', '', '', '', 0, 'published', '2026-05-10 08:09:36', '2026-05-10 08:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `artist_videos`
--

CREATE TABLE `artist_videos` (
  `artist_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist_videos`
--

INSERT INTO `artist_videos` (`artist_id`, `video_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 9),
(9, 11),
(10, 10),
(11, 10),
(12, 12),
(13, 6);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'News', 'news', '2026-05-09 15:17:03'),
(2, 'Features', 'features', '2026-05-09 15:17:03'),
(3, 'Wishclusives', 'wishclusives', '2026-05-09 15:17:03'),
(4, 'Shows', 'shows', '2026-05-09 15:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `status` enum('draft','published') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `excerpt`, `image`, `category_id`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Jessica Sanchez\'s Homecoming Concert is a Star-Studded Affair', 'jessica-sanchez-homecoming-concert', '<p>Powerhouse vocalist Jessica Sanchez is coming home to the Philippines, and what better way to celebrate it than with a concert that puts her vocal mastery to the fore.</p>', 'Powerhouse vocalist Jessica Sanchez is coming home to the Philippines.', 'uploads/news_69ff70efa2953.jpg', 1, 1, 'published', '2026-05-08 02:00:00', '2026-05-09 17:37:51'),
(2, 'Simple Plan is Bringing Their Tour in Manila this November', 'simple-plan-manila-tour', '<p>Celebrating their 25th anniversary, multi-platinum pop-punk band Simple Plan announced their highly anticipated comeback to Manila this November.</p>', 'Multi-platinum pop-punk band Simple Plan is coming to Manila.', 'uploads/news_69ff712fc5fc9.png', 1, 1, 'published', '2026-05-05 02:00:00', '2026-05-09 17:38:55'),
(3, '5 Ben&Ben Songs Fans Wish to Hear at Stopover Sessions', 'benben-songs-stopover-sessions', '<p>From their recent hit \"Lifetime (Reimagined)\" to the classic \"Leaves,\" here are five Ben&amp;Ben songs fans wish to hear at their upcoming Stopover Sessions.</p>', 'Five Ben&amp;Ben songs fans wish to hear at Stopover Sessions.', 'uploads/news_69ff7137540c2.jpg', 2, 1, 'published', '2026-05-04 02:00:00', '2026-05-09 17:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'site_title', 'Wish 107.5'),
(2, 'site_description', 'Your gateway to the world of music'),
(3, 'stream_url', 'https://example.com/stream'),
(4, 'facebook_url', '#'),
(5, 'twitter_url', '#'),
(6, 'instagram_url', '#'),
(7, 'youtube_url', '#'),
(8, 'tiktok_url', '#'),
(9, 'about_content', '<p>We are all about celebrating music, bringing OPM talents to the world, and paying it forward.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `day_of_week` varchar(20) DEFAULT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `dj_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`id`, `title`, `slug`, `day_of_week`, `start_time`, `end_time`, `description`, `dj_name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Morning Wish', 'morning-wish', 'Mon-Fri', '5:00 AM', '9:00 AM', 'Start your day on a good note. Morning Wish brings you a selection of feel-good hits.', 'DJ Ray Holiday', NULL, 'published', '2026-05-09 15:17:04', '2026-05-09 15:17:04'),
(2, 'Wonderland', 'wonderland', 'Mon-Fri', '9:00 AM', '12:00 PM', 'Let good music be your escape. Indulge in contemporary tunes.', 'DJ Debra', NULL, 'published', '2026-05-09 15:17:04', '2026-05-09 15:17:04'),
(3, 'Wish List', 'wish-list', 'Mon-Fri', '12:00 PM', '4:00 PM', 'Freshen up your afternoon with our playlist of in-demand hits.', 'DJ Faye', NULL, 'published', '2026-05-09 15:17:04', '2026-05-09 15:17:04'),
(4, 'Roadshow', 'roadshow', 'Mon-Fri', '4:00 PM', '8:00 PM', 'Bringing the radio to the streets, hosted live from the Wish 107.5 Bus.', 'DJ Adam', NULL, 'published', '2026-05-09 15:17:04', '2026-05-09 15:17:04'),
(5, 'Wishpers of Love', 'wishpers-of-love', 'Mon-Fri', '8:00 PM', '12:00 AM', 'Tender tunes fill the air as Wishpers of Love concludes your day.', 'DJ', NULL, 'published', '2026-05-09 15:17:04', '2026-05-09 15:17:04'),
(6, 'Moonlight Wishes', 'moonlight-wishes', 'Mon-Fri', '12:00 AM', '5:00 AM', 'Staying awake in the wee hours? Mellow songs to keep you company.', 'DJ', NULL, 'published', '2026-05-09 15:17:04', '2026-05-09 15:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-05-09 15:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `artist` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `youtube_id` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `status` enum('draft','published') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `slug`, `artist`, `description`, `youtube_id`, `thumbnail`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Huling Sandali', 'huling-sandali', 'Kenan', 'Kenan performs \"Huling Sandali\" live on the Wish 107.5 Bus. The song is all about yearning for a lost love.', '96-fxzT2ee4?si=i47QQidJ3Y2SF3MV', 'uploads/vid_69ff7ce6e8ae5.jpg', 1, 'published', '2026-05-06 02:00:00', '2026-05-10 07:42:47'),
(2, 'Una', 'una', 'Silent Sanctuary', 'Silent Sanctuary performs \"Una\" live on the Wish 107.5 Bus. The song expresses the emotional turmoil someone feels for a person they consider the most important in their life.', 'BINVRpFRc1E', 'uploads/vid_69ff7cf2ac51e.jpg', 1, 'published', '2026-05-05 02:00:00', '2026-05-10 07:44:45'),
(3, 'Nagpalinlang', 'nagpalinlang', 'Yazmin Aziz', 'Yazmin Aziz performs \"Nagpalinlang\" live on the Wish 107.5 Bus. Penned by Aziz and Adonis Tabanda, this debut Tagalog track of the Malaysian-Filipina act is about a \"hopeless romantic who just wanted to be loved.\"', 'peoXy9WbLRM', 'uploads/vid_69ff7cfb65b5c.jpg', 1, 'published', '2026-05-04 02:00:00', '2026-05-10 07:46:29'),
(4, 'I Want You', 'i-want-you', 'Gwyn Dorado', 'Gwyn Dorado performs \"I Want You\" live on the Wish Bus South Korea. A ballad that\'s confessional and filled with longing, the bilingual song speaks of the ache of missing and loving someone.', 'CuesfvazpzE', 'uploads/vid_69ff7d03e44aa.jpg', 1, 'published', '2026-05-03 02:00:00', '2026-05-10 07:47:31'),
(5, 'Manatili', 'manatili', 'Over October', 'Over October performs \"Manatili\" live on the Wish 107.5 Bus. An ode to fleeting moments, this song is about holding onto love even if parting ways is inevitable.', 'QiMJL6uF3NU', 'uploads/vid_69ff7d0c9b52b.jpg', 1, 'published', '2026-05-02 02:00:00', '2026-05-10 07:48:38'),
(6, 'Kung Masusunod', 'kung-masusunod', 'Jan Roberts and Johnoy Danao', 'Jan Roberts and Johnoy Danao perform \"Kung Masusunod\" live on the Wish 107.5 Bus. The song carries a selfless wish to ease a loved one’s pain and give them a happier life.', 'ANDTqCKJNNY', 'uploads/vid_69ff7d1624139.jpg', 1, 'published', '2026-05-01 02:00:00', '2026-05-10 07:49:21'),
(7, 'Dulo ng Pahina', 'dulo-ng-pahina', 'Wilbert Ross', 'Wilbert Ross performs \"Dulo ng Pahina\" live on the Wish 107.5 Bus. This self-penned song from his debut album \"Aking Musika\" is a heartfelt track about wanting to share life’s journey with the one he loves.', 'ife92anRvlU', 'uploads/vid_6a0039e154170.jpg', 1, 'published', '2026-05-10 07:55:13', '2026-05-10 07:55:13'),
(8, 'D.T.M.G (Don\'t Touch My Girl)', 'd-t-m-g-don-t-touch-my-girl', 'Fern., Because, Al James, dot.jaime & O SIDE MAFIA', 'Fern., Because, Al James, dot.jaime & O SIDE MAFIA perform \"D.T.M.G (Don\'t Touch My Girl)\" live on the Wish 107.5 Bus. The song combines \"West Coast bounce with that smooth-but-serious, don’t-play-about-mine energy.\"', 'E1SCTb02QGI', 'uploads/vid_6a003aaf497cb.jpg', 1, 'published', '2026-05-10 07:58:39', '2026-05-10 07:58:39'),
(9, 'Kung Ikaw Ay Bibitaw', 'kung-ikaw-ay-bibitaw', 'Julie Anne San Jose', 'Julie Anne San Jose performs \"Kung Ikaw Ay Bibitaw\" live on the Wish 107.5 Bus. Composed by Julie Anne herself, the bittersweet tune \"carries an emotional message about steadfast love and devotion even amid uncertainty.\"', '9pS-Xxqpe1c', 'uploads/vid_6a003b3e5e49d.jpg', 1, 'published', '2026-05-10 08:01:02', '2026-05-10 08:01:02'),
(10, 'Dahil May Kayo', 'dahil-may-kayo', 'Smugglaz (feat. Sisa)', 'Smugglaz (feat. Sisa of Crazy as Pinoy) performs \"Dahil May Kayo\" live on the Wish 107.5 Bus. Taken from the album \"Soundtrack sa Pelikula,\" this track expresses gratitude to family, friends, and supporters.', 'xmRMY1eHp9g', 'uploads/vid_6a003bb5bde12.png', 1, 'published', '2026-05-10 08:03:01', '2026-05-10 08:03:01'),
(11, 'Mahal Naman Kita', 'mahal-naman-kita', 'Chloe Redondo', 'Chloe Redondo performs \"Mahal Naman Kita\" live on the Wish 107.5 Bus. Popularized by Jamie Rivera, this OPM song is a classic anthem about unrequited love.', 'vor7VBWhrvI', 'uploads/vid_6a003c2d38dfc.jpg', 1, 'published', '2026-05-10 08:05:01', '2026-05-10 08:05:01'),
(12, 'Fallin', 'fallin', 'Oh Stella!', 'Oh Stella! performs \"Fallin\" live on the Wish 107.5 Bus. All too relatable for many listeners, the song explores falling in love with a friend', 'swXh7yS5x8c', 'uploads/vid_6a003cca2d5fb.jpg', 1, 'published', '2026-05-10 08:07:38', '2026-05-10 08:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `wishes`
--

CREATE TABLE `wishes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `wish_type` enum('song','wish') DEFAULT 'song',
  `song_artist` varchar(255) DEFAULT NULL,
  `song_title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishes`
--

INSERT INTO `wishes` (`id`, `name`, `email`, `wish_type`, `song_artist`, `song_title`, `message`, `status`, `created_at`, `approved_at`) VALUES
(1, 'Rodnie Calmada', 'calmadarodz@gmail.com', 'song', 'Eraserheads', 'With a Smile', 'please play this song po', 'approved', '2026-05-10 07:33:39', '2026-05-10 01:35:13'),
(2, 'Rods', 'rodnie@gmail.com', 'song', 'The Red Jumpsuit Apparatus', 'Your Guardian Angel', 'play this song please', 'pending', '2026-05-10 07:34:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `artist_videos`
--
ALTER TABLE `artist_videos`
  ADD PRIMARY KEY (`artist_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `wishes`
--
ALTER TABLE `wishes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `wishes`
--
ALTER TABLE `wishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artist_videos`
--
ALTER TABLE `artist_videos`
  ADD CONSTRAINT `artist_videos_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `artist_videos_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
