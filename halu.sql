-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 23 Apr 2025 pada 22.20
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

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
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `invoice_id` varchar(20) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `buyer` varchar(100) DEFAULT NULL,
  `seller` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `role` enum('Customers','Sellers') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Unverified',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT 'Male',
  `address` varchar(255) DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `id_expiry` date DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `other_info` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `email`, `phone`, `password`, `status`, `first_name`, `last_name`, `dob`, `gender`, `address`, `id_image`, `nik`, `id_expiry`, `nationality`, `other_info`) VALUES
(2, 'User456', 'Customers', 'user2@gmail.com', '08129876543', NULL, 'Unverified', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'User789', 'Customers', 'user3@gmail.com', '08125676789', NULL, 'Unverified', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'User000', 'Customers', 'user4@gmail.com', '08127980800', NULL, 'Unverified', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'admin', 'Customers', 'admin@gmail.com', '085266373847', NULL, 'Unverified', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'wsdsada', 'Customers', 'admin@gmail.com', '085266373847', NULL, 'Unverified', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'admin', 'Sellers', 'admin@gmail.com', NULL, NULL, 'Unverified', NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'udin', 'Customers', 'udin@gmail.com', '08214654189', NULL, 'Unverified', 'Udin', 'Saripudin', '1999-04-07', 'Male', 'Jakarta, Indonesia', 'ktp_udin.jpg', '3728445678200013', '2027-02-25', 'Indonesia', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
