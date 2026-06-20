-- phpMyAdmin SQL Dump
-- Host: localhost
-- Generation Time: Jun 20, 2026 at 11:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_koperasi`
--
CREATE DATABASE IF NOT EXISTS `db_koperasi`;
USE `db_koperasi`;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$OzlZq0H1Nnkn0yS88kF5nuMA1zOCE4QnKhjtMe/a8vk5n44syXlUS');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(50) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date NOT NULL,
  `status_anggota` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'nophoto.jpg',
  PRIMARY KEY (`id_anggota`),
  UNIQUE KEY `no_anggota` (`no_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `no_anggota`, `nama`, `alamat`, `no_hp`, `pekerjaan`, `tanggal_daftar`, `status_anggota`, `foto`) VALUES
(1, 'AGT0001', 'Andika Pratama', 'Yogyakarta', '081234567890', 'Wiraswasta', '2026-06-20', 'Aktif', 'nophoto.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_anggota`
--

CREATE TABLE `user_anggota` (
  `no_anggota` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`no_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_anggota` (Password: 12345)
--

INSERT INTO `user_anggota` (`no_anggota`, `password`) VALUES
('AGT0001', '$2y$10$GHc7rNilT.K6vVWbp7m9Ae/2P2lDgrk90vPqvYDrjf82JPS0R28YC');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan`
--

CREATE TABLE `simpanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(50) NOT NULL,
  `jenis_simpanan` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `simpanan`
--

INSERT INTO `simpanan` (`id`, `no_anggota`, `jenis_simpanan`, `jumlah`, `tanggal`) VALUES
(1, 'AGT0001', 'Simpanan Pokok', 100000, '2026-06-20'),
(2, 'AGT0001', 'Simpanan Wajib', 50000, '2026-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(50) NOT NULL,
  `jumlah_pinjaman` int(11) NOT NULL,
  `lama_angsuran` int(11) NOT NULL,
  `bunga` float NOT NULL,
  `tanggal_pinjaman` date NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `no_anggota`, `jumlah_pinjaman`, `lama_angsuran`, `bunga`, `tanggal_pinjaman`, `status`) VALUES
(1, 'AGT0001', 1000000, 10, 2, '2026-06-20', 'Belum Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `angsuran`
--

CREATE TABLE `angsuran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pinjaman` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `angsuran`
--

INSERT INTO `angsuran` (`id`, `id_pinjaman`, `tanggal_bayar`, `jumlah_bayar`) VALUES
(1, 1, '2026-06-20', 120000);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
