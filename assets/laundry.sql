-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2026 at 03:53 AM
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
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `telepon` varchar(11) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `layanan` varchar(11) NOT NULL,
  `catatan` varchar(250) NOT NULL,
  `status` enum('Pending','Diproses','Selesai','Dibatalkan') NOT NULL DEFAULT 'Pending',
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp(),
  `harga` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama`, `telepon`, `alamat`, `layanan`, `catatan`, `status`, `tanggal_pesanan`, `harga`) VALUES
(5, 'Dani Irawan', '08564570560', 'Boro            ', 'sepatu', 'Cuci Baju', 'Selesai', '2026-11-20 07:38:03', 0.00),
(6, 'Irawan', '08564570560', 'Siraman            ', 'kilat', 'Butuh cepet', 'Selesai', '2026-11-20 07:43:34', 0.00),
(7, 'Joko', '08564570560', 'Olak-alen            ', 'dryclean', 'Mambaglu ulama', 'Diproses', '2026-11-20 14:44:52', 0.00),
(8, 'Padly', '0823-2261-1', 'Selorejo            ', 'reguler', 'Pokok kudu resik', 'Diproses', '2026-11-20 15:17:14', 0.00),
(9, 'Adam', '08564578698', 'Ds.Boro', 'dryclean', 'Mau Baju kering poll', 'Diproses', '2026-11-21 01:15:14', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
