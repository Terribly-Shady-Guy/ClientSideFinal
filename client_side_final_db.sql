-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 07, 2022 at 07:28 PM
-- Server version: 8.0.18
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `client_side_final_db`
--
CREATE DATABASE IF NOT EXISTS `client_side_final_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `client_side_final_db`;

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `PortID` int(11) UNSIGNED NOT NULL,
  `UserID` int(11) UNSIGNED NOT NULL,
  `Picture` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `DateTaken` date NOT NULL,
  `Description` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `UploadDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`PortID`, `UserID`, `Picture`, `DateTaken`, `Description`, `UploadDate`) VALUES
(1, 1, 'Bodiam-castle.jpg', '2022-04-20', 'A picture of Bodium Castle.', '2022-05-04'),
(6, 1, 'Himeji-Castle.jpg', '2022-02-01', 'A picture of Himeji Castle.', '2022-05-06'),
(7, 1, 'eagle.jpg', '2021-07-05', 'An eagle in a forest.', '2022-05-06'),
(8, 1, 'everest.jpg', '2021-12-16', 'A picture of Mt. Everest.', '2022-05-06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) UNSIGNED NOT NULL,
  `FirstName` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `LastName` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `Username`, `Password`) VALUES
(1, 'Tyler', 'Kaufmann', 'someemail@example.com', 'Ty', '$2y$10$oRWSyXCbpYwsn56SZKGSze1Gc/50RMBdraNY.qsDdjqePc6RG7F6S'),
(2, 'test', 'test', 'testemail@example.com', 'test', '$2y$10$9PCqnLq4AFT4mMSApuSjfuagM3XXLoFYv1EuPV/4mkc/00ybmcLXa'),
(3, 'test2', 'test', 'test2@example.com', 'test2', '$2y$10$7h1wNGys7e3Q.L7Y0LPkx.tpdnBUSfX3VJcYgYxiHGmEYmopyTEqW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`PortID`),
  ADD KEY `FK_UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `PortID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD CONSTRAINT `FK_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
