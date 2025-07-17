-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2025 at 06:37 AM
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
-- Database: `db_cateringnabila`
--

-- --------------------------------------------------------

--
-- Table structure for table `nabila_paket`
--

CREATE TABLE `nabila_paket` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `min_tamu` int(11) NOT NULL,
  `max_tamu` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nabila_paket`
--

INSERT INTO `nabila_paket` (`id`, `nama_paket`, `deskripsi`, `harga`, `min_tamu`, `max_tamu`, `photo`, `dibuat_pada`) VALUES
(1, '1. Paket Royal Luxury (Premium)', 'Pembuka: Canapé (salmon blini, truffle arancini), Utama: Lobster thermidor, wagyu steak, risotto truffle, Penutup: Dessert table (macarons, mini cakes, chocolate fountain) ; \r\nFasilitas:Live cooking station, Butler service, Dekorasi meja premium, Free flow mocktail', 99999999.99, 80, 150, 'paket_68787972509b5.jpeg', '2025-07-17 04:17:54'),
(2, '2. Paket Elegant Garden (Premium)', 'Pembuka: Salad bar dengan dressing khusus, Utama: Grilled salmon, beef wellington, pasta bar, Penutup: Mini desserts (tiramisu, fruit tart) ; Fasilitas:Garden-themed decoration, Coffee & tea station, Photobooth', 85000000.00, 100, 200, 'paket_687879cb9b561.jpeg', '2025-07-17 04:19:23'),
(6, '3. Paket Classic Romance (Menengah Atas)', 'Pembuka: Soup station (cream of mushroom, pumpkin), Utama: Chicken cordon bleu, beef black pepper, garlic mashed potato, Penutup: Pudding, fresh fruits ; Fasilitas:Basic table setting, Free soft drinks', 70000000.00, 150, 300, 'paket_68787aeee5af5.jpeg', '2025-07-17 04:24:14'),
(7, '4. Paket Traditional Minang (Menengah)', 'Pembuka: Lamang Tapai), Utama: Rendang daging sapi (utama), Gulai ayam kampung, Gulai tunjang (kikil), Penutup: Ampiang Dadiah ; Fasilitas:Live music tradisional Minang (saluang/gandang), Sajian \"Talam\" (nasi kotak ala Minang untuk tamu VIP)', 60000000.00, 300, 500, 'paket_68787bcb0d89d.jpeg', '2025-07-17 04:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `nabila_reservasi`
--

CREATE TABLE `nabila_reservasi` (
  `id` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `tanggal_acara` date NOT NULL,
  `jumlah_tamu` int(11) NOT NULL,
  `permintaan_khusus` text DEFAULT NULL,
  `status` enum('menunggu','dikonfirmasi','ditolak','selesai') DEFAULT 'menunggu',
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nabila_reservasi`
--

INSERT INTO `nabila_reservasi` (`id`, `id_users`, `id_paket`, `tanggal_acara`, `jumlah_tamu`, `permintaan_khusus`, `status`, `dibuat_pada`) VALUES
(1, 2, 1, '2025-07-24', 100, NULL, 'menunggu', '2025-07-17 04:31:41'),
(2, 2, 1, '2025-07-24', 100, NULL, 'menunggu', '2025-07-17 04:32:38'),
(3, 2, 1, '2025-07-24', 100, NULL, 'menunggu', '2025-07-17 04:33:36'),
(4, 2, 1, '2025-07-24', 100, NULL, 'menunggu', '2025-07-17 04:36:03'),
(5, 2, 1, '2025-07-24', 100, NULL, 'menunggu', '2025-07-17 04:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `nabila_users`
--

CREATE TABLE `nabila_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nabila_users`
--

INSERT INTO `nabila_users` (`id`, `username`, `password`, `level`, `nama_lengkap`, `email`, `no_telepon`, `dibuat_pada`) VALUES
(1, 'admin', '$2y$10$B9CgKz5O5zsdFWbTj0FcceRi/k2MZ/cQ2G0Dq2Xc.jNl.TiYXpVwe', 'admin', 'Nabila Rahmadani', 'nabilarahmadani2609@gmail.com', '08464868794', '2025-07-17 04:13:11'),
(2, 'nabila', '$2y$10$TbevUPJAmeNwNYE/4UVq.OWtzl5LonkT2F0oz8ohu2AOAdcwFqaJa', 'user', 'Nabila Rahmadani', 'naeoxonana@gmail.com', '07467890674636', '2025-07-17 04:30:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nabila_paket`
--
ALTER TABLE `nabila_paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nabila_reservasi`
--
ALTER TABLE `nabila_reservasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indexes for table `nabila_users`
--
ALTER TABLE `nabila_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nabila_paket`
--
ALTER TABLE `nabila_paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nabila_reservasi`
--
ALTER TABLE `nabila_reservasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nabila_users`
--
ALTER TABLE `nabila_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nabila_reservasi`
--
ALTER TABLE `nabila_reservasi`
  ADD CONSTRAINT `nabila_reservasi_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `nabila_users` (`id`),
  ADD CONSTRAINT `nabila_reservasi_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `nabila_paket` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
