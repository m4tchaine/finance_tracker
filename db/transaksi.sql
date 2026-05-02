-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2026 at 12:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
--
-- Database: `finance_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis` enum('pemasukan','pengeluaran') DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `jenis`, `kategori`, `jumlah`, `keterangan`, `user_id`) VALUES
(5, '2026-01-10', 'pemasukan', 'Gaji', 500000, 'Gaji bulan Januari', NULL),
(6, '2026-01-12', 'pengeluaran', 'Makan', 50000, 'Makan siang', NULL),
(7, '2026-02-05', 'pemasukan', 'Bonus', 300000, 'Bonus kerja', NULL),
(8, '2026-02-10', 'pengeluaran', 'Transport', 70000, 'Ojek', NULL),
(10, '2026-04-22', 'pengeluaran', 'makanan', 2000, 'test', 1),
(11, '2026-04-14', 'pengeluaran', 'g', 678000, 'r', 1),
(12, '2026-04-09', 'pemasukan', 'gaji', 400000, 'gaji bulan April', 1),
(13, '2026-04-11', 'pemasukan', 'uang jajan', 500000, 'uang jajan', 1),
(14, '2026-03-14', 'pemasukan', 'gaji', 500000, 'gaji bulan maret', 1),
(15, '2026-05-06', 'pemasukan', 'gaji', 600000, 'gaji bulan mei', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
