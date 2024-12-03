-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 12:30 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jcollab_4x_cali`
--

-- --------------------------------------------------------

--
-- Table structure for table `stat_store`
--

CREATE TABLE `stat_store` (
  `id` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `libelle` varchar(35) NOT NULL,
  `date` date NOT NULL,
  `totalht` decimal(13,2) NOT NULL DEFAULT '0.00',
  `totalttc` decimal(13,2) NOT NULL DEFAULT '0.00',
  `fdcaisse` decimal(13,2) NOT NULL DEFAULT '0.00',
  `especes` decimal(13,2) NOT NULL DEFAULT '0.00',
  `carte` decimal(13,2) NOT NULL DEFAULT '0.00',
  `cheque` decimal(13,2) NOT NULL DEFAULT '0.00',
  `wallet` decimal(13,2) NOT NULL DEFAULT '0.00',
  `credit` decimal(13,2) NOT NULL DEFAULT '0.00',
  `virement` decimal(13,2) NOT NULL DEFAULT '0.00',
  `bachat` decimal(13,2) NOT NULL DEFAULT '0.00',
  `ccadeau` decimal(13,2) NOT NULL DEFAULT '0.00',
  `offert` decimal(13,2) NOT NULL DEFAULT '0.00',
  `ecommerce` decimal(10,3) NOT NULL,
  `remise` decimal(13,2) NOT NULL DEFAULT '0.00',
  `annules` decimal(13,2) NOT NULL DEFAULT '0.00',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stat_store`
--
ALTER TABLE `stat_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_date` (`date`),
  ADD KEY `idx_store` (`storeid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stat_store`
--
ALTER TABLE `stat_store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
