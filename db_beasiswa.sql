-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2023 at 11:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_beasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendaftaran`
--

CREATE TABLE `tbl_pendaftaran` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `semester` tinyint(3) UNSIGNED NOT NULL,
  `gpa` float NOT NULL,
  `type` enum('Akademik','Non-Akademik') NOT NULL,
  `file` varchar(255) NOT NULL,
  `status` enum('Verified','Pending') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pendaftaran`
--

INSERT INTO `tbl_pendaftaran` (`id`, `name`, `email`, `phone`, `semester`, `gpa`, `type`, `file`, `status`) VALUES
(1, 'Aldy Prastyo', 'ayam@gmail.com', '081234408987', 7, 3.6, 'Akademik', 'ba4c9418e234b6822d293d6b0bc5f026.png', 'Pending'),
(2, 'Nanda', 'yuliananda013@gmail.com', '081733897645', 1, 3.5, 'Akademik', 'dcf5c099c482f46b545f8d6af9d174a4.png', 'Pending'),
(3, 'Asep', 'prayakays9e8@gmail.com', '082134137372', 4, 3.2, 'Akademik', '0cc070a17cd0309e9ca3bc2104df5b80.png', 'Pending'),
(4, 'udin', 'kiaranaoya2000@gmail.com', '089192934184', 5, 3.9, 'Akademik', '58793f1921fe0241c5b3867acf5772ad.png', 'Pending'),
(5, 'ssdfsdf', 'nengmahiru@gmail.com', '089192934112', 5, 3.7, 'Akademik', '1e5ad653d1038ff10e48b795393405c8.jpg', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `file` (`file`),
  ADD KEY `name` (`name`),
  ADD KEY `semester` (`semester`),
  ADD KEY `ipk` (`gpa`),
  ADD KEY `tipe` (`type`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_pendaftaran`
--
ALTER TABLE `tbl_pendaftaran`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
