-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 06:59 AM
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
-- Database: `halu`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jumlah` decimal(12,2) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `tanggal_pembayaran` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `user_id`, `jumlah`, `bukti_transfer`, `status`, `tanggal_pembayaran`) VALUES
(1, 2, 250000.00, 'uploads/bukti_budi.png', 'pending', '2025-05-21 09:30:00'),
(2, 3, 150000.00, 'uploads/bukti_sari.png', 'verified', '2025-05-20 14:15:00'),
(3, 4, 300000.00, 'uploads/bukti_dewi.png', 'verified', '2025-05-19 10:00:00'),
(4, 5, 180000.00, 'uploads/bukti_andi.png', 'pending', '2025-05-21 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user','provider') DEFAULT 'user',
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin HaLu', 'admin@halu.com', 'admin', 'admin', 'verified', '2025-05-21 04:51:37'),
(2, 'Budi Provider', 'budi@provider.com', '9c5fa085ce256c7c598f6710584ab25d', 'provider', 'pending', '2025-05-21 04:51:37'),
(3, 'Sari Pengguna', 'sari@user.com', 'e9ee75b57bb1303190c8869621cad05b', 'user', 'verified', '2025-05-21 04:51:37'),
(4, 'Dewi Provider', 'dewi@provider.com', 'fde0b737496c53bb85d07b31a02985a3', 'provider', 'verified', '2025-05-21 04:51:37'),
(5, 'Andi Pengguna', 'andi@user.com', '03339dc0dff443f15c254baccde9bece', 'user', 'verified', '2025-05-21 04:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `verifikasi_dokumen`
--

CREATE TABLE `verifikasi_dokumen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jenis_dokumen` enum('ktp','izin_usaha') DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verifikasi_dokumen`
--

INSERT INTO `verifikasi_dokumen` (`id`, `user_id`, `jenis_dokumen`, `file_path`, `status`, `uploaded_at`) VALUES
(1, 2, 'ktp', 'uploads/dokumen_ktp_budi.jpg', 'pending', '2025-05-21 04:51:37'),
(2, 4, 'izin_usaha', 'uploads/izin_usaha_dewi.pdf', 'approved', '2025-05-21 04:51:37');

--
  -- Create tasks table
  
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `due_time` time NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `verifikasi_dokumen`
--
ALTER TABLE `verifikasi_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `verifikasi_dokumen`
--
ALTER TABLE `verifikasi_dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `verifikasi_dokumen`
--
ALTER TABLE `verifikasi_dokumen`
  ADD CONSTRAINT `verifikasi_dokumen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
