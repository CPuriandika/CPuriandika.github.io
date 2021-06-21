-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_futsal
CREATE DATABASE IF NOT EXISTS `db_futsal` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_futsal`;

-- Dumping structure for table db_futsal.detail_pesanan
CREATE TABLE IF NOT EXISTS `detail_pesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_pesanan` varchar(50) DEFAULT NULL,
  `id_lapangan` varchar(50) DEFAULT NULL,
  `jm_mulai` timestamp NULL DEFAULT NULL,
  `jm_akhir` timestamp NULL DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `biaya` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table db_futsal.detail_pesanan: ~2 rows (approximately)
/*!40000 ALTER TABLE `detail_pesanan` DISABLE KEYS */;
INSERT INTO `detail_pesanan` (`id`, `kd_pesanan`, `id_lapangan`, `jm_mulai`, `jm_akhir`, `durasi`, `biaya`, `id_user`) VALUES
	(41, '0306210001', '1', '2021-06-05 20:00:00', '2021-06-05 21:00:00', 1, 100000, 7),
	(42, '0306210001', '4', '2021-06-04 19:00:00', '2021-06-04 20:00:00', 1, 50000, 7);
/*!40000 ALTER TABLE `detail_pesanan` ENABLE KEYS */;

-- Dumping structure for table db_futsal.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `no_invoice` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`no_invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_futsal.invoice: ~1 rows (approximately)
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` (`no_invoice`, `status`) VALUES
	('INV0001', 3);
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;

-- Dumping structure for table db_futsal.konf_bayar
CREATE TABLE IF NOT EXISTS `konf_bayar` (
  `id_bayar` int(11) NOT NULL AUTO_INCREMENT,
  `no_invoice` varchar(50) DEFAULT NULL,
  `nm_rek` varchar(50) DEFAULT NULL,
  `jml_tf` int(11) DEFAULT NULL,
  `nm_bank` varchar(50) DEFAULT NULL,
  `image_tf` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table db_futsal.konf_bayar: ~0 rows (approximately)
/*!40000 ALTER TABLE `konf_bayar` DISABLE KEYS */;
INSERT INTO `konf_bayar` (`id_bayar`, `no_invoice`, `nm_rek`, `jml_tf`, `nm_bank`, `image_tf`) VALUES
	(9, 'INV0001', 'rendi arisandi', 150000, 'bca', NULL);
/*!40000 ALTER TABLE `konf_bayar` ENABLE KEYS */;

-- Dumping structure for table db_futsal.lapangan
CREATE TABLE IF NOT EXISTS `lapangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_lapangan` varchar(50) NOT NULL DEFAULT '0',
  `jns_lapangan` varchar(50) NOT NULL DEFAULT '0',
  `tarif` int(11) NOT NULL DEFAULT '0',
  `image` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table db_futsal.lapangan: ~4 rows (approximately)
/*!40000 ALTER TABLE `lapangan` DISABLE KEYS */;
INSERT INTO `lapangan` (`id`, `kd_lapangan`, `jns_lapangan`, `tarif`, `image`) VALUES
	(1, 'Lapangan A', 'Rumput', 100000, 'A.jpg'),
	(2, 'Lapangan B', 'Rumput', 80000, 'B.jpg'),
	(3, 'Lapangan C', 'Cor / Semen', 60000, 'C.jpg'),
	(4, 'Lapangan D', 'Cor / Semen', 50000, 'D.jpg');
/*!40000 ALTER TABLE `lapangan` ENABLE KEYS */;

-- Dumping structure for table db_futsal.pesanan
CREATE TABLE IF NOT EXISTS `pesanan` (
  `kd_pesanan` varchar(50) NOT NULL DEFAULT '0',
  `tgl_pesanan` varchar(50) NOT NULL DEFAULT '0',
  `id_lapangan` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `tot_biaya` int(11) NOT NULL DEFAULT '0',
  `no_invoice` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`kd_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_futsal.pesanan: ~1 rows (approximately)
/*!40000 ALTER TABLE `pesanan` DISABLE KEYS */;
INSERT INTO `pesanan` (`kd_pesanan`, `tgl_pesanan`, `id_lapangan`, `id_user`, `tot_biaya`, `no_invoice`) VALUES
	('0306210001', '03-06-2021', 1, 7, 150000, 'INV0001');
/*!40000 ALTER TABLE `pesanan` ENABLE KEYS */;

-- Dumping structure for table db_futsal.temp
CREATE TABLE IF NOT EXISTS `temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lapangan` int(11) NOT NULL DEFAULT '0',
  `kd_lapangan` varchar(50) NOT NULL DEFAULT '0',
  `jns_lapangan` varchar(50) NOT NULL DEFAULT '0',
  `image` varchar(50) NOT NULL DEFAULT '0',
  `tarif` int(11) NOT NULL DEFAULT '0',
  `jm_mulai` timestamp NULL DEFAULT NULL,
  `jm_akhir` timestamp NULL DEFAULT NULL,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `email_user` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_futsal.temp: ~0 rows (approximately)
/*!40000 ALTER TABLE `temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp` ENABLE KEYS */;

-- Dumping structure for table db_futsal.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `telpon` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table db_futsal.user: ~3 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `telpon`, `role_id`, `is_active`, `date_created`) VALUES
	(4, 'admin', 'admin@gmail.com', 'default.jpg', '$2y$10$nkbeJlIc1i6RWtTB3o9OeeQ6BEQp2Y7uXtSIKjz6M.AWg5g2ysSCC', '089627878822', 1, 1, 1622171981),
	(6, 'lusi', 'lusi@gmail.com', 'pro1622717318.PNG', '$2y$10$bNtealBH3ZqbRkACIm1uGeXMVKIyL3LBBPxXAsm/Kzn3k1R3y9Owa', '0888866666', 2, 1, 1622717264),
	(7, 'rendi arisandi', 'rendi@gmail.com', 'pro1622722618.jpg', '$2y$10$G.DAw8NO8cXwRgKHKT0/kOIP3lz14wOk/nakCYuInKUPusM3RTlsG', '081212431340', 2, 1, 1622722529);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
