-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 04:06 PM
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
  `invoice_id` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `jumlah` decimal(12,2) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `buyer` varchar(100) DEFAULT NULL,
  `seller` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `invoice_id`, `user_id`, `jumlah`, `bukti_transfer`, `status`, `tanggal_pembayaran`, `date`, `buyer`, `seller`, `location`) VALUES
(1, 'INV-000001', 2, 250000.00, 'uploads/bukti_budi.png', 'pending', '2025-05-21 09:30:00', '2025-05-21 09:30:00', NULL, NULL, NULL),
(2, 'INV-000002', 3, 150000.00, 'uploads/bukti_sari.png', 'verified', '2025-05-20 14:15:00', '2025-05-20 14:15:00', NULL, NULL, NULL),
(3, 'INV-000003', 4, 300000.00, 'uploads/bukti_dewi.png', 'verified', '2025-05-19 10:00:00', '2025-05-19 10:00:00', NULL, NULL, NULL),
(4, 'INV-000004', 5, 180000.00, 'uploads/bukti_andi.png', 'pending', '2025-05-21 08:00:00', '2025-05-21 08:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date NOT NULL,
  `due_time` time NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `due_date`, `due_time`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Membahas statistik penjualan', 'Membahas tentang statistik penjualan', '2025-05-21', '17:22:00', 'completed', 1, '2025-05-21 10:23:01', '2025-05-21 12:03:26'),
(2, 'dawdaw', 'dada', '2025-05-21', '17:29:00', 'pending', 1, '2025-05-21 10:29:49', '2025-05-21 11:01:50'),
(3, 'dwad', 'awdawd', '2025-05-21', '18:50:00', 'pending', 1, '2025-05-21 11:50:20', '2025-05-21 11:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user','provider') DEFAULT 'user',
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `dob`, `gender`, `email`, `phone`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Admin HaLu', NULL, NULL, NULL, NULL, 'admin@halu.com', NULL, '21232f297a57a5a743894a0e4a801fc3', 'admin', 'verified', '2025-05-21 04:51:37'),
(2, 'Budi Provider', NULL, NULL, NULL, NULL, 'budi@provider.com', NULL, '9c5fa085ce256c7c598f6710584ab25d', 'provider', 'pending', '2025-05-21 04:51:37'),
(3, 'Sari Pengguna', NULL, NULL, NULL, NULL, 'sari@user.com', NULL, 'e9ee75b57bb1303190c8869621cad05b', 'user', 'verified', '2025-05-21 04:51:37'),
(4, 'Dewi Provider', NULL, NULL, NULL, NULL, 'dewi@provider.com', NULL, 'fde0b737496c53bb85d07b31a02985a3', 'provider', 'verified', '2025-05-21 04:51:37'),
(5, 'Andi Pengguna', NULL, NULL, NULL, NULL, 'andi@user.com', NULL, '03339dc0dff443f15c254baccde9bece', 'user', 'verified', '2025-05-21 04:51:37'),
(6, 'ferdi', NULL, NULL, NULL, NULL, 'ferdiansyah@gmail.com', '08123456789', '8bf4bb0e2efad01abe522bf314504a49', '', 'pending', '2025-05-21 10:36:57'),
(7, 'coba', NULL, NULL, NULL, NULL, 'cobates@gmail.com', '08987654321', 'c3ec0f7b054e729c5a716c8125839829', '', 'pending', '2025-05-21 10:37:20'),
(8, 'yayyaa', NULL, NULL, NULL, NULL, 'yayaya@gmail.com', '08987654322', 'eac9b82480302429c93051234999e210', '', 'pending', '2025-05-21 10:40:09');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

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
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `verifikasi_dokumen`
--
ALTER TABLE `verifikasi_dokumen`
  ADD CONSTRAINT `verifikasi_dokumen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
