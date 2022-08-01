-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220731.160d6efbe8
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 01, 2022 at 12:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_socket`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `content` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` longtext NOT NULL,
  `session_val` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `session_val`) VALUES
('q1b5c7ndnq6ilqk1c437379fv1', '{\"userId\":27,\"userEmail\":\"deneme\",\"denene\":\"sdaf\"}'),
('a3fpqnv031f5vetettkpu3abna', '{\"userId\":27,\"userEmail\":\"deneme\"}'),
('qfnutjjml071oue5os6v3q6d60', '{\"userId\":27,\"userEmail\":\"deneme\"}'),
('vhjpb63i7k3o9ea747f5upsp9r', '{\"userId\":\"28\",\"userEmail\":\"serhat\"}'),
('uf3qom3q22cncagsfohkaf1rp4', '{\"userId\":\"29\",\"userEmail\":\"serhat3\"}'),
('jnog65kvvieksm49vkvh2fmpn7', '{\"userId\":\"30\",\"userEmail\":\"son\"}'),
('fse479mplh619k9fa7hu1h8pba', '{\"userId\":\"31\",\"userEmail\":\"aaa\"}'),
('12mjj5kfq3blqorva5ann4h6lt', '{\"userId\":27,\"userEmail\":\"deneme\"}'),
('0vh1s6qhqr1528i7mbvf703j29', '{\"userId\":27,\"userEmail\":\"deneme\"}'),
('dtlepctif919oq0ihvrknf9l6s', '{\"userId\":\"32\",\"userEmail\":\"test\"}'),
('cl8p3cicfuo496n70uknn9im9d', '{\"userId\":34,\"userEmail\":\"test\"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_email` varchar(250) DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `user_surname` varchar(250) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `password` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_email`, `user_name`, `user_surname`, `is_admin`, `password`) VALUES
(33, 'admin@admin.com', 'admin', 'admin', 1, 'ea51cb5660a7afbadf09a0c4b88cdbf99c08888f9756e68af9edd6fda5690fb5'),
(34, 'test', 'test', 'test', 0, '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
