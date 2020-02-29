-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 29, 2020 at 11:43 PM
-- Server version: 10.1.44-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `googlegame`
--

-- --------------------------------------------------------

--
-- Table structure for table `app`
--

CREATE TABLE `app` (
  `id` bigint(50) NOT NULL,
  `developerID` bigint(50) NOT NULL,
  `token` varchar(100) NOT NULL,
  `packageName` varchar(100) NOT NULL,
  `publicKey` text NOT NULL,
  `privateKey` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app`
--

INSERT INTO `app` (`id`, `developerID`, `token`, `packageName`, `publicKey`, `privateKey`, `datetime`) VALUES
(1, 1, 'd4f5g6df4gd5f6ge4r89rf48', 'com.asrez.test', 'x1x1x1x1x1x1', 'PasswortPasswort', '2020-02-29 00:16:50'),
(2, 1, 'ucwobvouul31ckexvot27inyh7uol6xmakn8soyzsrjlfi1gi8', 'org.max.blog', 'z75fxn0vfsg55g1p644dua42dpdni0supavq6nkvnhg430bqcs', 'kpdezyuejx77yb0xtakcqn8ls29s34f266onn1lme4id0x6wy3', '2020-02-29 22:47:39'),
(3, 1, 'qn2vwnad16rjfcxb6vu9u3neb153ca7wotbacphyl6dklj5it8', 'org.max.bloga', 'ksqmpzlduf80i5s9ljhce2g9n9yurxl0kfw6avrdgftm4zzqyn', 'p0b20j48ugxhm5qfdp9jftb43o327c1uzq0f0mf433j8lvagp5', '2020-02-29 22:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

CREATE TABLE `developer` (
  `id` bigint(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `token` varchar(100) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `developer`
--

INSERT INTO `developer` (`id`, `username`, `password`, `token`, `datetime`) VALUES
(1, 'basemax', 'maxmax', 'd4f5g6df4gd5f6ge4r89rf48', '2020-02-29 22:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `id` bigint(50) NOT NULL,
  `appID` bigint(50) NOT NULL,
  `userID` bigint(50) NOT NULL,
  `session` varchar(100) NOT NULL,
  `value` bigint(50) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`id`, `appID`, `userID`, `session`, `value`, `datetime`) VALUES
(3, 2, 1, 'vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v', 500, '2020-02-29 23:38:43'),
(4, 2, 1, 'vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v', 840, '2020-02-29 23:38:53'),
(5, 2, 1, 'vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v', 1648, '2020-02-29 23:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(50) NOT NULL,
  `appID` bigint(50) NOT NULL,
  `deviceInformation` text NOT NULL,
  `appVersion` varchar(20) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(100) NOT NULL,
  `publicKey` text NOT NULL,
  `privateKey` text NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `appID`, `deviceInformation`, `appVersion`, `datetime`, `token`, `publicKey`, `privateKey`, `email`) VALUES
(1, 2, 'samsung-SL10', '1.0.0', '2020-02-29 22:53:14', 'qdzaqo15dp7uemt2n3cytsbc4c6p1oud46stg0p4n2zb291orx', '6mxc6qv5o4jto0kel1ta9ynor65uyupj30tu7jxgpq9cwlubfy', 'a532hgaloa6tb6djd9kp8ap616keze7bxj6en6u91dylzdbivj', 'max@asrez.com');

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `id` bigint(50) NOT NULL,
  `appID` bigint(50) NOT NULL,
  `userID` bigint(50) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` varchar(10) NOT NULL,
  `hasUse` int(1) NOT NULL DEFAULT '0',
  `session` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verify`
--

INSERT INTO `verify` (`id`, `appID`, `userID`, `datetime`, `code`, `hasUse`, `session`) VALUES
(1, 2, 1, '2020-02-29 23:15:51', 'fdbd6', -1, '59cf4zw8iby2nivvy2af145nb94g47g10p2ik6gfr738homrv6'),
(2, 2, 1, '2020-02-29 23:19:02', '196d9', 1, 'vb9jbwuuwh1qyr07yp6kd8dwjkf2xz18d29vx8b0p20q4kvu1v');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app`
--
ALTER TABLE `app`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developer`
--
ALTER TABLE `developer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app`
--
ALTER TABLE `app`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `developer`
--
ALTER TABLE `developer`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `id` bigint(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
