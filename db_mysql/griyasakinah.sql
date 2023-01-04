-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2022 at 05:54 AM
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
-- Database: `griyasakinah`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_perumahan`
--

CREATE TABLE `access_perumahan` (
  `id_access` int(11) NOT NULL,
  `id_perum` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_perumahan`
--

INSERT INTO `access_perumahan` (`id_access`, `id_perum`, `id_user`) VALUES
(13, 1, 1),
(14, 2, 1),
(15, 3, 1),
(35, 1, 5),
(36, 2, 5),
(37, 3, 5),
(46, 1, 10),
(47, 3, 10),
(48, 1, 6),
(49, 3, 6),
(69, 1, 12),
(70, 3, 12),
(74, 1, 7),
(75, 3, 7),
(76, 1, 8),
(77, 2, 8),
(78, 3, 8),
(81, 1, 9),
(82, 2, 9),
(83, 3, 9),
(84, 1, 13),
(85, 2, 13),
(86, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `angsuran_bank`
--

CREATE TABLE `angsuran_bank` (
  `id_angsur` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_angsur` varchar(100) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(100) NOT NULL,
  `tgl_bayar` varchar(2) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `denda` varchar(20) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `angsuran_bank`
--

INSERT INTO `angsuran_bank` (`id_angsur`, `id_konsumen`, `jml_angsur`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(1, 48, '900000', '3', '300000', '1', 3, '2022-10-01', '2022-10-21', '30000', 4, 1),
(2, 48, '900000', '3', '300000', '1', 0, '2022-11-01', '0000-00-00', '', 0, 1),
(3, 48, '900000', '3', '300000', '1', 0, '2022-12-01', '0000-00-00', '', 0, 1),
(12, 46, '200000', '2', '100000', '2', 0, '2022-10-02', '0000-00-00', '', 0, 0),
(13, 46, '200000', '2', '100000', '2', 0, '2022-11-02', '0000-00-00', '', 0, 0),
(14, 50, '200000', '2', '100000', '3', 1, '2022-10-03', '2022-09-21', '0', 21, 0),
(15, 50, '200000', '2', '100000', '3', 0, '2022-11-03', '0000-00-00', '', 0, 0),
(16, 51, '500000', '1', '500000', '3', 3, '2022-11-03', '2022-11-26', '57500', 7, 1),
(17, 58, '300000', '3', '100000', '5', 1, '2023-01-05', '0000-00-00', '0', 21, 1),
(18, 58, '300000', '3', '100000', '5', 0, '2023-02-05', '0000-00-00', '0', 0, 1),
(19, 58, '300000', '3', '100000', '5', 0, '2023-03-05', '0000-00-00', '0', 0, 1),
(20, 59, '600000', '4', '150000', '4', 1, '2023-01-04', '0000-00-00', '0', 21, 1),
(21, 59, '600000', '4', '150000', '4', 0, '2023-02-04', '0000-00-00', '0', 0, 1),
(22, 59, '600000', '4', '150000', '4', 0, '2023-03-04', '0000-00-00', '0', 0, 1),
(23, 59, '600000', '4', '150000', '4', 0, '2023-04-04', '0000-00-00', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `approved_history`
--

CREATE TABLE `approved_history` (
  `id` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL,
  `id_title_kode` int(11) NOT NULL,
  `jumlah` varchar(20) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_history`
--

INSERT INTO `approved_history` (`id`, `id_perumahan`, `id_title_kode`, `jumlah`, `tanggal`) VALUES
(54, 1, 25, '500000', '2022-12-15'),
(55, 1, 19, '1000000', '2022-12-16'),
(56, 1, 10, '1500000', '2022-12-22'),
(57, 1, 3, '30000', '2022-12-22'),
(58, 1, 19, '20000', '2022-12-22'),
(59, 1, 15, '500000', '2022-12-22'),
(60, 1, 3, '20000', '2022-12-22'),
(61, 1, 19, '200000', '2022-12-22'),
(62, 1, 20, '20000', '2022-12-22'),
(63, 1, 19, '100000', '2022-12-22'),
(64, 1, 25, '200000', '2022-12-22'),
(65, 1, 14, '70000', '2022-12-22'),
(66, 1, 14, '20000', '2022-12-22'),
(67, 1, 15, '100000', '2022-12-22'),
(68, 1, 15, '100000', '2022-12-22'),
(69, 1, 3, '30000', '2022-12-22'),
(70, 1, 3, '20000', '2022-12-22'),
(71, 1, 19, '80000', '2022-12-22'),
(72, 1, 15, '20000', '2022-12-22'),
(73, 1, 20, '100000', '2022-12-22'),
(74, 1, 19, '100000', '2022-12-22'),
(75, 1, 25, '200000', '2022-12-22'),
(76, 1, 14, '800000', '2022-12-22'),
(77, 1, 15, '100000', '2022-12-22'),
(78, 1, 5, '200000', '2022-12-22'),
(79, 1, 20, '6500000', '2022-12-23'),
(80, 1, 5, '3333333', '2022-12-24'),
(81, 1, 20, '1000000', '2022-12-24'),
(82, 1, 20, '590000', '2022-12-24'),
(91, 1, 5, '50000', '2022-12-26'),
(92, 1, 5, '50000', '2022-12-26'),
(93, 1, 5, '50000', '2022-12-26'),
(94, 1, 6, '50000', '2022-12-27'),
(95, 1, 7, '150000', '2022-12-27'),
(96, 1, 8, '60000', '2022-12-27'),
(97, 1, 9, '50000', '2022-12-27'),
(99, 1, 9, '50000', '2022-12-27'),
(100, 1, 21, '50000', '2022-12-27'),
(101, 1, 22, '40000', '2022-12-27'),
(102, 1, 10, '3000000', '2022-12-27'),
(103, 1, 11, '54000', '2022-12-27'),
(104, 1, 12, '20000', '2022-12-27'),
(105, 1, 13, '50000', '2022-12-27'),
(106, 1, 5, '200000', '2022-12-27'),
(107, 1, 9, '1000000', '2022-12-27'),
(108, 1, 7, '52000', '2022-12-28'),
(109, 1, 8, '40000', '2022-12-28'),
(110, 1, 9, '110000', '2022-12-28'),
(111, 1, 27, '250000', '2022-12-28'),
(112, 1, 10, '20000', '2022-12-28'),
(113, 1, 27, '24000', '2022-12-28'),
(114, 1, 12, '340000', '2022-12-28'),
(115, 1, 20, '2310000', '2022-12-29'),
(116, 1, 4, '2000000', '2022-12-29'),
(117, 1, 4, '2500000', '2022-12-29'),
(118, 1, 4, '1500000', '2022-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_kt`
--

CREATE TABLE `bank_cicil_kt` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_kt`
--

INSERT INTO `bank_cicil_kt` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 57, '2022-12-27', '150000', 'avatar16.png', 'bg_login112.jpg', 3),
(2, 62, '2022-12-28', '52000', 'Screenshot_422.png', 'Screenshot_423.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_lain`
--

CREATE TABLE `bank_cicil_lain` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_lain`
--

INSERT INTO `bank_cicil_lain` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 59, '2022-12-27', '50000', 'bg_login10.jpg', 'avatar19.png', 3),
(2, 62, '2022-12-28', '110000', 'avatar31.png', 'logo222.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_pak`
--

CREATE TABLE `bank_cicil_pak` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_pak`
--

INSERT INTO `bank_cicil_pak` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 42, '2022-12-27', '60000', 'avatar17.png', 'bg_login110.jpg', 3),
(2, 47, '2022-12-28', '40000', 'Screenshot_426.png', 'logo1.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_pb`
--

CREATE TABLE `bank_cicil_pb` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_pb`
--

INSERT INTO `bank_cicil_pb` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 48, '2022-12-27', '40000', 'avatar22.png', 'bg_login29.jpg', 3),
(2, 53, '2022-12-28', '40000', 'Screenshot_425.png', 'pray4.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_rb`
--

CREATE TABLE `bank_cicil_rb` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_rb`
--

INSERT INTO `bank_cicil_rb` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 17, '2022-12-27', '50000', 'avatar21.png', 'bg_login28.jpg', 3),
(2, 20, '2022-12-28', '53000', 'Screenshot_424.png', 'icon5.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_tj`
--

CREATE TABLE `bank_cicil_tj` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_tj`
--

INSERT INTO `bank_cicil_tj` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 41, '2022-12-27', '200000', 'avatar25.png', 'avatar26.png', 3),
(2, 42, '2022-12-28', '40000', 'avatar28.png', 'bg_login31.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_tjl`
--

CREATE TABLE `bank_cicil_tjl` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_tjl`
--

INSERT INTO `bank_cicil_tjl` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(8, 116, '2022-12-26', '50000', '', '', 1),
(10, 117, '2022-12-26', '50000', '', '', 1),
(12, 116, '2022-12-27', '56500', '', '', 1),
(13, 117, '2022-12-27', '20000', '', '', 1),
(14, 119, '2022-12-28', '20000', 'avatar29.png', 'bg_login212.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bank_cicil_um`
--

CREATE TABLE `bank_cicil_um` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_cicil_um`
--

INSERT INTO `bank_cicil_um` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 58, '2022-12-27', '50000', 'avatar14.png', 'avatar15.png', 3),
(2, 58, '2022-12-27', '50000', '', '', 1),
(3, 63, '2022-12-28', '35000', 'avatar30.png', 'bg_login213.jpg', 0),
(4, 63, '2022-12-28', '35000', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `berkas_konsumen`
--

CREATE TABLE `berkas_konsumen` (
  `id_berkas` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `file` varchar(200) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berkas_konsumen`
--

INSERT INTO `berkas_konsumen` (`id_berkas`, `id_konsumen`, `file`, `keterangan`) VALUES
(5, 10, 'code-snapshot.png', 'KK'),
(10, 10, 'Capture.PNG', 'KTP'),
(13, 9, '1642995978050.jpg', 'Slip gaji 3 bulan terakhir'),
(14, 46, 'bg_login1.jpg', 'NPWP');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_pembayaran`
--

CREATE TABLE `bukti_pembayaran` (
  `id_bukti` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `db` varchar(200) NOT NULL,
  `bukti_pembayaran` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bukti_pembayaran`
--

INSERT INTO `bukti_pembayaran` (`id_bukti`, `id_pembayaran`, `db`, `bukti_pembayaran`) VALUES
(71, 40, 'kelebihan_tanah', 'bg_login24.jpg'),
(72, 30, 'pak', 'avatar4.png'),
(73, 26, 'lain_lain', 'g22.png'),
(74, 304, 'harga_kesepakatan_inhouse', 'avatar5.png'),
(75, 51, 'tanda_jadi_lokasi_inhouse', 'logooo.jpg'),
(76, 49, 'uang_muka_inhouse', 'bg_login25.jpg'),
(77, 44, 'kelebihan_tanah_inhouse', 'Screenshot_41.png'),
(78, 49, 'tanda_jadi_lokasi', 'avatar6.png'),
(79, 50, 'tanda_jadi_lokasi', 'bg_login13.jpg'),
(80, 40, 'uang_muka', 'avatar7.png'),
(81, 73, 'tanda_jadi_lokasi', 'bg_login14.jpg'),
(82, 49, 'uang_muka', 'g16.png'),
(83, 47, 'kelebihan_tanah', 'g222.png'),
(84, 34, 'pak', 'bg_login26.jpg'),
(85, 32, 'lain_lain', 'icon4.png'),
(86, 333, 'harga_kesepakatan_inhouse', 'Screenshot_42.png'),
(87, 65, 'tanda_jadi_lokasi_inhouse', 'pray2.png'),
(88, 53, 'uang_muka_inhouse', 'logo.png'),
(89, 48, 'kelebihan_tanah_inhouse', 'logo221.jpg'),
(90, 14, 'angsuran_bank', 'bg_login8.jpg'),
(91, 42, 'piutang_bank', 'bg_login27.jpg'),
(92, 108, 'tanda_jadi_lokasi', 'def.jpg'),
(93, 75, 'tanda_jadi_lokasi_inhouse', 'def1.jpg'),
(113, 32, 'tbl_transaksi_inhouse', 'Screenshot_420.png'),
(114, 38, 'tbl_transaksi_bank', 'logo_fix_SD_5.png'),
(115, 56, 'uang_muka', 'logo_fix_SD_52.png'),
(116, 16, 'angsuran_bank', 'logo_fix_SD_53.png'),
(117, 44, 'piutang_bank', '3d-business-black-and-blue-credit-card.png'),
(118, 58, 'lain_lain', 'logo_fix_SD_54.png'),
(119, 393, 'harga_kesepakatan_inhouse', 'logo_fix_SD_55.png'),
(120, 80, 'tanda_jadi_lokasi_inhouse', 'logo_fix_SD_56.png'),
(121, 60, 'uang_muka_inhouse', 'logo_fix_SD_57.png'),
(122, 113, 'tanda_jadi_lokasi', 'avatar11.png');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_spkb`
--

CREATE TABLE `bukti_spkb` (
  `id_bukti_spkb` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `bukti_spkb` varchar(200) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bukti_spkb`
--

INSERT INTO `bukti_spkb` (`id_bukti_spkb`, `id_konsumen`, `bukti_spkb`, `file_type`) VALUES
(4, 50, 'def.jpg', '.jpg'),
(5, 50, 'RAB.pdf', '.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_spr`
--

CREATE TABLE `bukti_spr` (
  `id_bukti_spr` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `bukti_spr` varchar(200) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bukti_spr`
--

INSERT INTO `bukti_spr` (`id_bukti_spr`, `id_konsumen`, `bukti_spr`, `file_type`) VALUES
(12, 48, 'def.jpg', '.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cicil_fee_marketing`
--

CREATE TABLE `cicil_fee_marketing` (
  `id_cicil` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_fee_marketing`
--

INSERT INTO `cicil_fee_marketing` (`id_cicil`, `id_marketing`, `tanggal`, `jumlah`, `bukti`, `status`) VALUES
(2, 46, '2022-12-13', '300000', 'default-image7.jpg', 2),
(3, 46, '2022-12-13', '200000', '', 2),
(4, 51, '2022-12-14', '20000', '', 2),
(5, 51, '2022-12-22', '30000', '', 2),
(6, 51, '2022-12-22', '20000', '', 2),
(7, 51, '2022-12-22', '30000', '', 2),
(8, 51, '2022-12-22', '20000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cicil_insidentil`
--

CREATE TABLE `cicil_insidentil` (
  `id_cicil` int(11) NOT NULL,
  `id_insidentil` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `jml_pengajuan` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_insidentil`
--

INSERT INTO `cicil_insidentil` (`id_cicil`, `id_insidentil`, `tgl_input`, `jml_pengajuan`, `bukti_transfer`, `status`) VALUES
(2, 9, '2022-12-11', '5200000', 'default-image3.jpg', 2),
(3, 9, '2022-12-11', '300000', '', 2),
(4, 10, '2022-12-16', '1000000', '', 2),
(5, 11, '2022-12-22', '100000', '', 2),
(6, 10, '2022-12-22', '100000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cicil_kas`
--

CREATE TABLE `cicil_kas` (
  `id_cicil` int(11) NOT NULL,
  `id_kas` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_kas`
--

INSERT INTO `cicil_kas` (`id_cicil`, `id_kas`, `tanggal`, `jumlah`, `bukti`, `status`) VALUES
(15, 1, '2022-12-12', '230000', 'default-image4.jpg', 2),
(17, 1, '2022-12-12', '27000', '', 2),
(18, 1, '2022-12-12', '500000', '', 2),
(19, 1, '2022-12-22', '200000', '', 2),
(20, 1, '2022-12-22', '200000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cicil_material`
--

CREATE TABLE `cicil_material` (
  `id_cicil` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `jml_pengajuan` varchar(100) NOT NULL,
  `bukti_pembayaran` varchar(200) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1. menunggu super admin\r\n2. approved super admin\r\n0. reject super admin\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_material`
--

INSERT INTO `cicil_material` (`id_cicil`, `id_pengajuan`, `tgl_pengajuan`, `jml_pengajuan`, `bukti_pembayaran`, `status`) VALUES
(3, 1, '2022-12-09', '500000', 'default-image1.jpg', 2),
(5, 1, '2022-12-10', '2300000', 'default-image2.jpg', 2),
(7, 1, '2022-12-10', '1875000', '', 2),
(8, 3, '2022-12-10', '2300000', '', 2),
(9, 3, '2022-12-10', '550000', '', 0),
(10, 4, '2022-12-15', '100000', '', 2),
(11, 4, '2022-12-22', '20000', '', 2),
(12, 3, '2022-12-22', '100000', '', 2),
(13, 7, '2022-12-23', '6500000', '', 2),
(14, 10, '2022-12-24', '1000000', 'avatar12.png', 2),
(15, 10, '2022-12-24', '590000', '', 2),
(16, 11, '2022-12-29', '2310000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cicil_pembatalan`
--

CREATE TABLE `cicil_pembatalan` (
  `id_cicil` int(11) NOT NULL,
  `id_pembatalan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_pembatalan`
--

INSERT INTO `cicil_pembatalan` (`id_cicil`, `id_pembatalan`, `tanggal`, `jumlah`, `bukti`, `status`) VALUES
(1, 5, '2022-12-13', '600000', 'default-image8.jpg', 2),
(3, 5, '2022-12-13', '1000000', '', 2),
(4, 5, '2022-12-13', '200000', '', 2),
(5, 5, '2022-12-22', '20000', '', 2),
(6, 5, '2022-12-22', '80000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cicil_pembebasan_lahan`
--

CREATE TABLE `cicil_pembebasan_lahan` (
  `id_cicil` int(11) NOT NULL,
  `id_pembebasan` int(11) NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(1) NOT NULL,
  `bukti` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_pembebasan_lahan`
--

INSERT INTO `cicil_pembebasan_lahan` (`id_cicil`, `id_pembebasan`, `jumlah`, `tanggal`, `status`, `bukti`) VALUES
(13, 10, '2000000', '2022-12-14', 2, 'default-image11.jpg'),
(15, 10, '200000', '2022-12-14', 2, ''),
(16, 12, '20000', '2022-12-22', 2, ''),
(17, 12, '70000', '2022-12-22', 2, ''),
(18, 10, '800000', '2022-12-22', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `cicil_pengeluaran_lain`
--

CREATE TABLE `cicil_pengeluaran_lain` (
  `id_cicil` int(11) NOT NULL,
  `id_pengeluaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_pengeluaran_lain`
--

INSERT INTO `cicil_pengeluaran_lain` (`id_cicil`, `id_pengeluaran`, `tanggal`, `jumlah`, `bukti`, `status`) VALUES
(3, 15, '2022-12-14', '200000', 'default-image10.jpg', 2),
(4, 15, '2022-12-14', '5000000', '', 2),
(5, 15, '2022-12-14', '300000', '', 0),
(6, 16, '2022-12-22', '100000', '', 2),
(7, 16, '2022-12-22', '100000', '', 2),
(8, 16, '2022-12-22', '100000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cicil_progres`
--

CREATE TABLE `cicil_progres` (
  `id_cicil` int(11) NOT NULL,
  `id_progres` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cicil_progres`
--

INSERT INTO `cicil_progres` (`id_cicil`, `id_progres`, `tanggal`, `jumlah`, `bukti`, `status`) VALUES
(2, 61, '2022-12-14', '150000', 'default-image9.jpg', 2),
(3, 61, '2022-12-14', '1350000', '', 2),
(4, 60, '2022-12-16', '500000', '', 2),
(5, 64, '2022-12-17', '2000000', '', 0),
(7, 60, '2022-12-22', '20000', '', 2),
(8, 65, '2022-12-29', '2000000', '', 2),
(9, 66, '2022-12-29', '2500000', '', 2),
(10, 66, '2022-12-29', '1500000', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `db_group`
--

CREATE TABLE `db_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(60) NOT NULL,
  `home` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `description` varchar(255) NOT NULL,
  `durasi_awal` time DEFAULT NULL,
  `durasi_akhir` time DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_diupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_group`
--

INSERT INTO `db_group` (`id`, `group_name`, `home`, `status`, `description`, `durasi_awal`, `durasi_akhir`, `tanggal_dibuat`, `tanggal_diupdate`, `user_id`, `active`) VALUES
(1, 'Super Administrator', 1, 1, '1', NULL, NULL, '2020-05-26 09:07:41', '2022-01-14 07:01:46', 1, 0),
(2, 'Administrator', 1, 1, '1', NULL, NULL, '2020-05-26 09:45:48', '2022-10-03 19:05:31', 1, 0),
(3, 'Accounting', 1, 1, '1', NULL, NULL, '2020-12-22 10:18:34', '2022-09-01 08:46:25', 1, 0),
(4, 'Marketing', 1, 1, '', NULL, NULL, '2021-01-22 13:50:28', '2022-06-09 01:20:44', 1, 0),
(5, 'Logistik', 1, 1, '', NULL, NULL, '2022-06-07 03:48:51', '2022-06-07 03:48:57', 1, 0),
(6, 'Pengawas Proyek', 1, 1, '', NULL, NULL, '2022-06-07 03:49:18', '2022-09-01 10:13:06', 1, 0),
(7, 'Asisten Accounting', 1, 1, '', NULL, NULL, '2022-09-01 09:18:23', '2022-11-24 02:24:38', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_group_module`
--

CREATE TABLE `db_group_module` (
  `group_id` int(11) NOT NULL,
  `modul_id` int(11) NOT NULL,
  `crud_create` int(11) DEFAULT NULL,
  `crud_update` int(11) DEFAULT NULL,
  `crud_delete` int(11) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `tanggal_diupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_group_module`
--

INSERT INTO `db_group_module` (`group_id`, `modul_id`, `crud_create`, `crud_update`, `crud_delete`, `tanggal_dibuat`, `tanggal_diupdate`) VALUES
(0, 75, 1, 1, 1, '2022-06-03 00:02:31', '2022-06-03 00:02:31'),
(1, 1, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 2, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 7, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 8, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 11, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 12, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 13, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 14, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 15, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 18, 2, 2, 2, '2022-09-01 22:28:41', '2022-09-01 22:28:41'),
(1, 48, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 49, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 50, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 51, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 52, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 53, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 54, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 55, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 56, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 57, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 58, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 59, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 60, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 61, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 62, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 63, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 64, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 65, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 67, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 68, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 69, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 70, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 71, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 72, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 73, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 74, 2, 2, 2, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 75, 1, 1, 1, '2022-06-09 01:32:42', '2022-06-09 01:32:42'),
(1, 76, 1, 1, 1, '2022-06-20 01:15:24', '2022-06-20 01:15:24'),
(1, 77, 1, 1, 1, '2022-06-20 01:15:24', '2022-06-20 01:15:24'),
(1, 78, 1, 1, 1, '2022-06-28 05:42:24', '2022-06-28 05:42:24'),
(1, 79, 1, 1, 1, '2022-06-28 05:42:24', '2022-06-28 05:42:24'),
(1, 80, 1, 1, 1, '2022-06-28 05:42:49', '2022-06-28 05:42:49'),
(1, 81, 1, 1, 1, '2022-06-28 05:42:49', '2022-06-28 05:42:49'),
(1, 82, 1, 1, 1, '2022-06-28 05:43:09', '2022-06-28 05:43:09'),
(1, 83, 1, 1, 1, '2022-07-20 07:07:28', '2022-07-20 07:07:28'),
(1, 84, 1, 1, 1, '2022-07-29 10:00:07', '2022-07-29 10:00:07'),
(1, 85, 1, 1, 1, '2022-08-18 08:06:04', '2022-08-18 08:06:04'),
(1, 86, 1, 1, 1, '2022-08-23 08:39:44', '2022-08-23 08:39:44'),
(1, 87, 1, 1, 1, '2022-09-01 22:46:50', '2022-09-01 22:46:50'),
(1, 88, 1, 1, 1, '2022-09-03 13:21:20', '2022-09-03 13:21:20'),
(1, 89, 1, 1, 1, '2022-09-04 03:58:24', '2022-09-04 03:58:24'),
(1, 90, 1, 1, 1, '2022-09-05 01:17:07', '2022-09-05 01:17:07'),
(1, 91, 1, 1, 1, '2022-09-06 03:41:55', '2022-09-06 03:41:55'),
(1, 93, 1, 1, 1, '2022-09-07 02:03:58', '2022-09-07 02:03:58'),
(1, 94, 1, 1, 1, '2022-09-12 02:42:33', '2022-09-12 02:42:33'),
(1, 95, 1, 1, 1, '2022-10-20 07:09:06', '2022-10-20 07:09:06'),
(2, 1, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 2, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 13, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 14, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 15, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 18, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 48, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 49, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 50, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 51, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 52, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 53, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 54, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 55, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 56, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 57, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 58, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 59, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 60, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 61, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 62, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 63, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 64, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 65, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 67, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 68, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 69, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 70, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 71, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 72, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 73, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 74, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 75, 2, 2, 2, '2022-06-09 16:38:40', '2022-06-09 16:38:40'),
(2, 77, 1, 1, 1, '2022-09-14 18:02:24', '2022-09-14 18:02:24'),
(2, 78, 1, 1, 1, '2022-09-14 18:02:24', '2022-09-14 18:02:24'),
(2, 79, 1, 1, 1, '2022-09-14 18:04:17', '2022-09-14 18:04:17'),
(2, 80, 1, 1, 1, '2022-09-14 18:04:17', '2022-09-14 18:04:17'),
(2, 81, 1, 1, 1, '2022-09-14 17:48:36', '2022-09-14 17:48:36'),
(2, 82, 1, 1, 1, '2022-09-14 17:48:36', '2022-09-14 17:48:36'),
(2, 83, 1, 1, 1, '2022-09-14 17:47:18', '2022-09-14 17:47:18'),
(2, 84, 1, 1, 1, '2022-09-14 17:54:41', '2022-09-14 17:54:41'),
(2, 85, 1, 1, 1, '2022-09-14 17:54:41', '2022-09-14 17:54:41'),
(2, 86, 1, 1, 1, '2022-09-14 17:55:53', '2022-09-14 17:55:53'),
(2, 87, 1, 1, 1, '2022-09-14 17:55:53', '2022-09-14 17:55:53'),
(2, 88, 1, 1, 1, '2022-09-14 17:57:23', '2022-09-14 17:57:23'),
(2, 89, 1, 1, 1, '2022-09-14 17:57:23', '2022-09-14 17:57:23'),
(2, 90, 1, 1, 1, '2022-09-14 17:58:12', '2022-09-14 17:58:12'),
(2, 91, 1, 1, 1, '2022-09-14 17:58:12', '2022-09-14 17:58:12'),
(2, 93, 1, 1, 1, '2022-09-14 17:58:50', '2022-09-14 17:58:50'),
(2, 94, 1, 1, 1, '2022-09-14 17:58:50', '2022-09-14 17:58:50'),
(2, 95, 1, 1, 1, '2022-10-20 07:09:06', '2022-10-20 07:09:06'),
(3, 1, 2, 2, 2, '2022-06-09 02:15:15', '2022-06-09 02:15:15'),
(3, 56, 2, 2, 2, '2022-06-09 02:15:15', '2022-06-09 02:15:15'),
(3, 57, 1, 1, 1, '2022-06-09 02:15:15', '2022-06-09 02:15:15'),
(3, 58, 1, 1, 1, '2022-06-09 02:15:15', '2022-06-09 02:15:15'),
(3, 73, 1, 1, 1, '2022-06-09 02:15:15', '2022-06-09 02:15:15'),
(3, 84, 1, 1, 1, '2022-07-29 10:00:07', '2022-07-29 10:00:07'),
(3, 85, 1, 1, 1, '2022-08-18 08:06:04', '2022-08-18 08:06:04'),
(3, 86, 1, 1, 1, '2022-08-23 08:39:44', '2022-08-23 08:39:44'),
(3, 88, 1, 1, 1, '2022-09-03 13:21:20', '2022-09-03 13:21:20'),
(3, 89, 1, 1, 1, '2022-09-04 03:58:24', '2022-09-04 03:58:24'),
(3, 90, 1, 1, 1, '2022-09-05 01:17:07', '2022-09-05 01:17:07'),
(3, 91, 1, 1, 1, '2022-09-06 03:41:55', '2022-09-06 03:41:55'),
(3, 93, 1, 1, 1, '2022-09-07 02:03:58', '2022-09-07 02:03:58'),
(3, 94, 1, 1, 1, '2022-09-09 06:13:56', '2022-09-09 06:13:56'),
(3, 95, 1, 1, 1, '2022-10-20 07:09:24', '2022-10-20 07:09:24'),
(4, 1, 2, 2, 2, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 2, 2, 2, 2, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 50, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 52, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 53, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 54, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 55, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 57, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 58, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(4, 73, 1, 1, 1, '2022-06-09 01:30:37', '2022-06-09 01:30:37'),
(5, 1, 2, 2, 2, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 11, 2, 2, 2, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 12, 2, 2, 2, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 59, 2, 2, 2, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 60, 1, 1, 1, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 61, 1, 1, 1, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 62, 1, 1, 1, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(5, 63, 1, 1, 1, '2022-06-09 01:51:12', '2022-06-09 01:51:12'),
(6, 1, 2, 2, 2, '2022-06-09 06:30:52', '2022-06-09 06:30:52'),
(6, 64, 2, 2, 2, '2022-06-09 06:30:52', '2022-06-09 06:30:52'),
(6, 65, 1, 1, 1, '2022-06-09 06:30:52', '2022-06-09 06:30:52'),
(6, 67, 1, 1, 1, '2022-06-09 06:30:52', '2022-06-09 06:30:52'),
(6, 81, 1, 1, 1, '2022-09-02 08:15:04', '2022-09-02 08:15:04'),
(6, 82, 1, 1, 1, '2022-09-02 08:15:54', '2022-09-02 08:15:54'),
(6, 83, 1, 1, 1, '2022-09-02 08:14:14', '2022-09-02 08:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `db_module`
--

CREATE TABLE `db_module` (
  `id` int(11) NOT NULL,
  `tipe` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `aktif` int(11) DEFAULT NULL,
  `icons` varchar(60) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_module`
--

INSERT INTO `db_module` (`id`, `tipe`, `title`, `url`, `tag`, `parent`, `level`, `aktif`, `icons`, `description`, `tanggal_dibuat`) VALUES
(1, 1010, 'Dashboard', 'dashboard/', NULL, 0, 1, 1, 'fas fa-tachometer-alt', '', '2022-01-14 07:01:46'),
(2, 1020, 'Manajemen Marketing', '#', NULL, 999, 1, 1, 'fas fa-file-alt', '', '2022-03-12 03:58:16'),
(3, 1027, 'Manajemen Keuangan', 'laporan_keuangan/bulanan/', NULL, 50, 1, 0, 'far fa-circle', '', '2022-06-09 14:46:15'),
(4, 1026, 'Laporan Tahunan', 'laporan_keuangan/tahunan/', NULL, 50, 1, 0, 'far fa-circle', '', '2022-06-09 14:46:25'),
(5, 1025, 'Setup Transaksi', 'laporan_keuangan/setup/', NULL, 50, 0, 0, 'far fa-circle', '', '2022-03-12 03:58:52'),
(6, 1030, 'Manajemen Proyek', 'inventaris/', NULL, 999, 1, 0, 'fas fa-archive', '', '2022-06-09 14:36:24'),
(7, 1031, 'Daftar Barang', 'inventaris/daftar_barang/', NULL, 6, 6, 1, 'far fa-circle', '', '2022-01-14 07:01:46'),
(8, 1032, 'Keluar Masuk Barang', 'inventaris/stok/', '', 6, 6, 1, 'far fa-circle', '', '2022-01-14 07:01:46'),
(9, 1033, 'Laporan', 'inventaris/laporan/', NULL, 6, 0, 0, 'far fa-circle', '', '2022-01-14 07:01:46'),
(10, 1040, 'Logistik', 'rab/', NULL, 999, 1, 0, 'fas fa-clipboard-list', '', '2022-06-09 14:37:13'),
(11, 1041, 'Buat RAB', 'rab/new/', NULL, 10, 0, 1, 'far fa-circle', '', '2022-01-15 21:20:04'),
(12, 1042, 'Daftar RAB', 'rab/list/', NULL, 10, 0, 1, 'far fa-circle', '', '2022-01-15 21:20:08'),
(13, 1130, 'Users & Groups', 'users_groups/', NULL, 999, 1, 0, 'fas fa-users', '', '2022-09-01 23:03:47'),
(14, 1131, 'Users', 'users_groups/users/', NULL, 13, 0, 1, 'far fa-circle', '', '2022-01-14 07:01:46'),
(15, 1132, 'Groups', 'users_groups/groups/', NULL, 13, 0, 1, 'far fa-circle', '', '2022-01-14 07:01:46'),
(16, 1133, 'Modules', 'users_groups/modules/', NULL, 13, 0, 0, 'far fa-circle', '', '2022-01-15 22:50:09'),
(17, 1023, 'Laba/Rugi', 'laporan_keuangan/laba_rugi/', '', 2, 0, 0, 'far fa-circle', '', '2022-01-14 07:01:46'),
(18, 1050, 'Master Perumahan', 'master/perumahan/', NULL, 0, 1, 0, 'far fa-circle', NULL, '2022-09-01 22:55:21'),
(22, 1050, 'Profile Lembaga', 'setup/', '', 0, 1, 0, 'fas fa-landmark', '', '2022-06-09 14:45:46'),
(48, 1050, 'Pembebasan Lahan', 'other/pembebasan_lahan/', NULL, 74, 74, 1, 'far fa-circle', NULL, '2022-05-31 03:41:35'),
(49, 1050, 'Pengeluaran Lain', 'other/pengeluaran_lain/', NULL, 74, 74, 1, 'far fa-circle', NULL, '2022-05-31 03:42:27'),
(50, 1021, 'Calon Konsumen', 'marketing/data_konsumen', NULL, 2, 2, 1, ' far fa-circle', NULL, '2022-03-13 04:58:32'),
(51, 1060, 'Master Kavling', 'master/kavling/', NULL, 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:53:07'),
(52, 1022, 'Transaksi Bank', 'marketing/transaksi_bank', NULL, 2, 2, 1, 'far fa-circle', NULL, '2022-03-15 06:22:02'),
(53, 1023, 'Transaksi Inhouse', 'marketing/transaksi_inhouse', '', 2, 2, 1, 'far fa-circle', NULL, '2022-03-17 06:22:39'),
(54, 1024, 'Konsumen', 'marketing/konsumen', NULL, 2, 2, 1, 'far fa-circle', NULL, '2022-03-19 15:12:14'),
(55, 1025, 'Pembatalan Transaksi', 'marketing/transaksi_batal', NULL, 2, 2, 1, 'far fa-circle', NULL, '2022-03-20 09:06:38'),
(56, 1070, 'Accounting', '#', NULL, 999, 1, 1, 'fas fa-dollar-sign', NULL, '2022-03-22 03:55:27'),
(57, 1071, 'Transaksi Bank', 'accounting/bank', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-03-22 04:11:41'),
(58, 1072, 'Transaksi Inhouse', 'accounting/inhouse', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-03-23 00:06:12'),
(59, 1043, 'Manajemen Logistik', 'logistik/', NULL, 999, 1, 1, 'fa fa-industry', NULL, '2022-03-29 06:57:12'),
(60, 1044, 'Ajukan Material', 'logistik/ajukan_material/', NULL, 59, 0, 1, 'far fa-circle', NULL, '2022-03-29 06:58:41'),
(61, 1045, 'Material Masuk', 'logistik/material_masuk/', NULL, 59, 0, 1, 'far fa-circle', NULL, '2022-03-29 06:58:41'),
(62, 1046, 'Material Keluar', 'logistik/material_keluar/', NULL, 59, 0, 1, 'far fa-circle', NULL, '2022-03-29 06:59:36'),
(63, 1046, 'Rekap Stok Material', 'logistik/rekap_stok_material/', NULL, 59, 0, 1, 'far fa-circle', NULL, '2022-06-28 09:00:45'),
(64, 1028, 'Management Proyek', 'proyek/', NULL, 999, 1, 1, 'fa fa-briefcase', NULL, '2022-11-21 18:06:37'),
(65, 1047, 'Ajukan Proyek', 'proyek/ajukan_proyek/', NULL, 64, 0, 1, 'far fa-circle', NULL, '2022-04-03 03:06:53'),
(67, 1049, 'RAB', 'proyek/rab/', NULL, 64, 0, 1, 'far fa-circle', NULL, '2022-04-08 04:18:16'),
(68, 1080, 'Admin KPR', '#', NULL, 999, 1, 1, 'fas fa-user', NULL, '2022-04-24 05:56:31'),
(69, 1081, 'Data Konsumen', 'kpr/konsumen', NULL, 68, 68, 1, 'far fa-circle', NULL, '2022-04-24 06:02:51'),
(70, 1082, 'Rekening Bank', 'kpr/rek_bank', NULL, 68, 68, 1, 'far fa-circle', NULL, '2022-04-24 06:03:00'),
(71, 1083, 'Berkas Konsumen', 'kpr/berkas_konsumen', NULL, 68, 68, 1, 'far fa-circle', NULL, '2022-04-24 06:03:08'),
(72, 1061, 'Master Cluster', 'master/cluster/', NULL, 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:54:18'),
(73, 1073, 'Fee Marketing', 'accounting/fee_marketing', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-05-09 06:08:44'),
(74, 1090, 'Menu lain-lain', '#', NULL, 999, 1, 1, 'fas fa-stream', NULL, '2022-05-31 03:37:32'),
(75, 1061, 'Master Material', 'master/material/', '', 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:54:36'),
(77, 1063, 'Master Tipe', 'master/tipe', NULL, 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:50:48'),
(78, 1062, 'Master Jenis Material', 'master/jenis_material/', NULL, 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:52:28'),
(79, 1064, 'Master Satuan Unit', 'master/unit/', NULL, 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:52:33'),
(80, 1065, 'Master Supplier', 'master/supplier/', NULL, 87, 0, 1, 'far fa-circle', NULL, '2022-09-01 22:52:38'),
(81, 1051, 'Pengajuan Material', 'proyek/pengajuan_material/', NULL, 64, 0, 1, 'far fa-circle', NULL, '2022-06-28 05:39:33'),
(82, 1052, 'Pekerjaan Insidentil', 'proyek/pekerjaan_insidentil/', NULL, 64, 0, 1, 'far fa-circle', NULL, '2022-11-21 00:41:17'),
(83, 1051, 'Progres Pembangunan', 'proyek/progres', NULL, 64, 0, 1, 'far fa-circle', NULL, '2022-11-21 00:45:41'),
(84, 1074, 'Upah Pekerja', 'accounting/pembangunan', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-03 11:42:25'),
(85, 1075, 'Management Kode', 'accounting/kode', '#', 56, 56, 0, 'far fa-circle', NULL, '2022-09-01 23:02:44'),
(86, 1076, 'Laporan Bulanan', 'accounting/laporan', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-08-23 08:38:12'),
(87, 1090, 'Management Master', '#', '#', 999, 1, 1, 'fas fa-star', NULL, '2022-09-01 22:45:08'),
(88, 1077, 'Pembebasan Lahan', 'accounting/pembebasan_lahan', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-03 13:19:28'),
(89, 1078, 'Pengeluaran Lain', 'accounting/pengeluaran_lain', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-04 03:57:39'),
(90, 1079, 'RAB', 'accounting/rab', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-05 01:16:29'),
(91, 1100, 'Pekerjaan Insidentil', 'accounting/insidentil', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-06 03:39:56'),
(93, 1101, 'Pengajuan Material', 'accounting/pengajuan_material', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-07 02:03:21'),
(94, 1102, 'Laporan Arus Kas', 'accounting/laporan_kas', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-09-09 06:12:07'),
(95, 1103, 'Pembatalan Transaksi', 'accounting/pembatalan_transaksi', NULL, 56, 56, 1, 'far fa-circle', NULL, '2022-10-20 07:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `db_status`
--

CREATE TABLE `db_status` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `action` int(11) NOT NULL DEFAULT 0,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_status`
--

INSERT INTO `db_status` (`id`, `nama`, `action`, `color`) VALUES
(1, 'Lunas', 0, 'primary'),
(2, 'Hutang', 0, 'danger'),
(3, 'Return', 0, 'warning'),
(4, 'Cancel', 0, 'info'),
(5, 'Delete', 1, 'danger');

-- --------------------------------------------------------

--
-- Table structure for table `db_user`
--

CREATE TABLE `db_user` (
  `id` int(11) NOT NULL,
  `group_id` varchar(3) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(60) NOT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `email` varchar(60) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT 0,
  `status` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT current_timestamp(),
  `tanggal_diupdate` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_user`
--

INSERT INTO `db_user` (`id`, `group_id`, `username`, `password`, `nama`, `email`, `avatar`, `employer_id`, `sales_id`, `store_id`, `status`, `description`, `tanggal_dibuat`, `tanggal_diupdate`, `active`) VALUES
(1, '1', NULL, '21232f297a57a5a743894a0e4a801fc3', 'Super Admin', '081234567890', 'profile-64aa55cabb1.jpg', NULL, NULL, 1, 1, 'Super Admin', '2020-05-26 10:15:14', '2022-11-02 20:05:43', 0),
(4, '4', NULL, 'bce240f59ddf9ed1a2aa255ed8b38c8a', 'nurul  ihsan', '087662551443', NULL, NULL, NULL, 1, 1, NULL, '2022-01-03 15:23:11', '2022-06-20 10:40:55', 1),
(5, '4', NULL, 'bce240f59ddf9ed1a2aa255ed8b38c8a', 'nurul', '081662441990', NULL, NULL, NULL, 1, 1, NULL, '2022-01-15 22:49:13', '2022-06-20 10:41:02', 0),
(6, '4', NULL, 'd8578edf8458ce06fbc5bb76a58c5ca4', 'Jordan el sable rampage', '085806021327', 'stok_in1.png', NULL, NULL, 1, 1, NULL, '2022-06-07 03:41:02', '2022-11-02 20:05:04', 0),
(7, '6', NULL, '25d55ad283aa400af464c76d713c07ad', 'Lich Crosswalt', '080987654321', NULL, NULL, NULL, 1, 1, NULL, '2022-06-07 03:54:47', '2022-11-24 02:45:27', 0),
(8, '5', NULL, '25d55ad283aa400af464c76d713c07ad', 'wachhell ristigm', '085662441321', NULL, NULL, NULL, 1, 1, NULL, '2022-06-09 01:44:36', '2022-11-24 02:40:12', 0),
(9, '3', NULL, '827ccb0eea8a706c4c34a16891f84e7b', 'Marie Lamperouge', '08122233342', NULL, NULL, NULL, 1, 1, NULL, '2022-06-09 02:13:46', '2022-12-02 02:37:44', 0),
(10, '2', NULL, '25d55ad283aa400af464c76d713c07ad', 'admin', '089000111222', NULL, NULL, NULL, 1, 1, NULL, '2022-06-09 13:22:56', '2022-06-20 10:40:35', 0),
(11, '3', NULL, '25d55ad283aa400af464c76d713c07ad', 'Roboot', '089772615241', NULL, NULL, NULL, 1, 1, NULL, '2022-06-20 18:32:17', '2022-06-20 18:33:15', 1),
(13, '7', NULL, '827ccb0eea8a706c4c34a16891f84e7b', 'Afls Hascwalt', '080999000999', NULL, NULL, NULL, 1, 1, NULL, '2022-11-24 02:26:46', '2022-11-24 02:26:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `db_user_history_login`
--

CREATE TABLE `db_user_history_login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `db_user_history_login`
--

INSERT INTO `db_user_history_login` (`id`, `user_id`, `last_login`) VALUES
(1, 1, '2022-01-14 07:01:47'),
(2, 1, '2022-01-14 07:01:47'),
(3, 1, '2022-01-14 07:01:47'),
(4, 1, '2022-01-14 07:01:47'),
(5, 1, '2022-01-14 07:01:47'),
(6, 1, '2022-01-14 07:01:47'),
(7, 1, '2022-01-14 07:01:47'),
(8, 1, '2022-01-14 07:01:47'),
(9, 1, '2022-01-14 07:01:47'),
(10, 1, '2022-01-14 07:01:47'),
(11, 1, '2022-01-14 07:01:47'),
(12, 1, '2022-01-14 07:01:47'),
(13, 1, '2022-01-14 07:01:47'),
(14, 1, '2022-01-14 07:01:47'),
(15, 1, '2022-01-14 07:01:47'),
(16, 1, '2022-01-14 07:01:47'),
(17, 1, '2022-01-14 07:01:47'),
(18, 1, '2022-01-14 07:01:47'),
(19, 1, '2022-01-14 07:01:47'),
(20, 1, '2022-01-14 07:01:47'),
(21, 4, '2022-01-14 07:01:47'),
(22, 1, '2022-01-14 07:01:47'),
(23, 1, '2022-01-14 07:01:47'),
(24, 1, '2022-01-14 07:01:47'),
(25, 1, '2022-01-14 07:01:47'),
(26, 1, '2022-01-14 07:01:47'),
(27, 1, '2022-01-14 07:01:47'),
(28, 1, '2022-01-14 07:01:47'),
(29, 1, '2022-01-14 07:01:47'),
(30, 1, '2022-01-14 07:01:47'),
(31, 1, '2022-01-14 07:34:56'),
(32, 1, '2022-01-14 07:56:18'),
(33, 1, '2022-01-15 14:34:59'),
(34, 1, '2022-01-15 14:37:54'),
(35, 1, '2022-01-15 21:16:03'),
(36, 1, '2022-01-15 22:56:31'),
(37, 1, '2022-01-15 23:49:55'),
(38, 1, '2022-01-15 23:51:26'),
(39, 1, '2022-01-16 01:07:35'),
(40, 1, '2022-01-16 01:08:03'),
(41, 1, '2022-01-17 13:17:50'),
(42, 1, '2022-02-25 05:21:14'),
(43, 1, '2022-02-25 13:48:48'),
(44, 1, '2022-02-26 14:08:51'),
(45, 1, '2022-02-26 21:58:35'),
(46, 1, '2022-02-27 00:52:41'),
(47, 1, '2022-02-27 01:04:56'),
(48, 1, '2022-02-27 01:06:50'),
(49, 1, '2022-02-27 01:09:08'),
(50, 1, '2022-03-10 02:02:51'),
(51, 1, '2022-03-10 02:03:34'),
(52, 1, '2022-03-10 12:44:38'),
(53, 1, '2022-03-12 01:44:52'),
(54, 1, '2022-03-12 01:49:12'),
(55, 1, '2022-03-12 03:45:33'),
(56, 1, '2022-03-12 08:42:25'),
(57, 1, '2022-03-13 01:10:20'),
(58, 1, '2022-03-13 23:03:22'),
(59, 1, '2022-03-14 04:13:37'),
(60, 1, '2022-03-14 14:04:52'),
(61, 1, '2022-03-14 23:41:11'),
(62, 1, '2022-03-15 02:21:46'),
(63, 1, '2022-03-15 04:23:24'),
(64, 1, '2022-03-15 08:11:21'),
(65, 1, '2022-03-15 21:18:09'),
(66, 1, '2022-03-16 00:27:21'),
(67, 1, '2022-03-16 04:37:33'),
(68, 1, '2022-03-16 17:19:31'),
(69, 1, '2022-03-16 22:07:05'),
(70, 1, '2022-03-17 02:12:56'),
(71, 1, '2022-03-17 05:54:04'),
(72, 1, '2022-03-17 05:55:25'),
(73, 1, '2022-03-17 06:42:25'),
(74, 1, '2022-03-17 13:01:21'),
(75, 1, '2022-03-17 16:42:01'),
(76, 1, '2022-03-17 21:38:00'),
(77, 1, '2022-03-18 03:30:13'),
(78, 1, '2022-03-19 14:15:47'),
(79, 1, '2022-03-19 21:40:15'),
(80, 1, '2022-03-19 22:10:28'),
(81, 1, '2022-03-19 22:11:20'),
(82, 1, '2022-03-19 22:12:49'),
(83, 1, '2022-03-20 04:44:57'),
(84, 1, '2022-03-20 10:14:48'),
(85, 1, '2022-03-20 10:15:49'),
(86, 1, '2022-03-20 12:36:41'),
(87, 1, '2022-03-20 12:41:32'),
(88, 1, '2022-03-20 12:42:02'),
(89, 1, '2022-03-20 15:22:19'),
(90, 1, '2022-03-20 21:56:21'),
(91, 1, '2022-03-21 02:45:12'),
(92, 1, '2022-03-22 01:31:39'),
(93, 1, '2022-03-22 15:50:19'),
(94, 1, '2022-03-22 15:50:19'),
(95, 1, '2022-03-22 15:51:15'),
(96, 1, '2022-03-22 15:51:53'),
(97, 1, '2022-03-22 23:38:28'),
(98, 1, '2022-03-22 23:39:33'),
(99, 1, '2022-03-23 06:14:31'),
(100, 1, '2022-03-28 01:03:24'),
(101, 1, '2022-03-28 03:24:11'),
(102, 1, '2022-03-28 03:33:48'),
(103, 1, '2022-03-29 07:22:44'),
(104, 1, '2022-03-29 13:20:31'),
(105, 1, '2022-03-31 04:27:12'),
(106, 1, '2022-03-31 07:42:55'),
(107, 1, '2022-04-01 04:00:40'),
(108, 1, '2022-04-02 04:43:32'),
(109, 1, '2022-04-02 11:14:55'),
(110, 1, '2022-04-02 15:27:02'),
(111, 1, '2022-04-02 15:30:02'),
(112, 1, '2022-04-02 15:43:44'),
(113, 1, '2022-04-03 02:43:01'),
(114, 1, '2022-04-03 15:16:13'),
(115, 1, '2022-04-04 03:50:02'),
(116, 1, '2022-04-04 14:12:10'),
(117, 1, '2022-04-05 11:37:36'),
(118, 1, '2022-04-06 03:51:01'),
(119, 1, '2022-04-06 13:10:15'),
(120, 1, '2022-04-07 14:04:29'),
(121, 1, '2022-04-08 03:30:07'),
(122, 1, '2022-04-08 11:14:55'),
(123, 1, '2022-04-09 03:47:54'),
(124, 1, '2022-04-09 14:13:02'),
(125, 1, '2022-04-10 08:19:13'),
(126, 1, '2022-04-11 02:31:58'),
(127, 1, '2022-04-11 10:05:58'),
(128, 1, '2022-04-11 16:42:43'),
(129, 1, '2022-04-12 03:43:16'),
(130, 1, '2022-04-12 10:16:54'),
(131, 1, '2022-04-12 17:43:06'),
(132, 1, '2022-04-13 03:05:34'),
(133, 1, '2022-04-14 04:06:53'),
(134, 1, '2022-04-15 02:14:20'),
(135, 1, '2022-04-18 02:10:20'),
(136, 1, '2022-04-19 01:52:50'),
(137, 1, '2022-04-19 06:26:22'),
(138, 1, '2022-04-20 06:00:23'),
(139, 1, '2022-04-21 06:53:26'),
(140, 1, '2022-04-21 15:09:58'),
(141, 1, '2022-04-22 03:12:47'),
(142, 1, '2022-04-22 06:37:02'),
(143, 1, '2022-04-23 03:00:11'),
(144, 1, '2022-04-23 11:19:28'),
(145, 1, '2022-04-23 15:50:48'),
(146, 1, '2022-04-24 04:45:30'),
(147, 1, '2022-04-24 14:17:32'),
(148, 1, '2022-04-24 14:17:32'),
(149, 1, '2022-04-24 14:33:19'),
(150, 1, '2022-04-24 14:33:40'),
(151, 1, '2022-04-24 14:46:26'),
(152, 1, '2022-04-25 09:04:37'),
(153, 1, '2022-04-25 11:04:43'),
(154, 1, '2022-05-29 23:51:54'),
(155, 1, '2022-05-30 13:21:47'),
(156, 1, '2022-05-31 09:09:48'),
(157, 1, '2022-05-31 14:46:54'),
(158, 1, '2022-06-01 04:51:51'),
(159, 1, '2022-06-01 10:27:38'),
(160, 1, '2022-06-02 03:26:58'),
(161, 1, '2022-06-02 08:10:36'),
(162, 1, '2022-06-02 09:17:23'),
(163, 1, '2022-06-03 00:56:17'),
(164, 1, '2022-06-03 05:41:27'),
(165, 1, '2022-06-04 14:22:04'),
(166, 1, '2022-06-06 06:42:34'),
(167, 1, '2022-06-06 07:36:29'),
(168, 1, '2022-06-10 02:34:01'),
(169, 1, '2022-06-10 06:51:02'),
(170, 1, '2022-06-10 09:28:10'),
(171, 1, '2022-06-13 12:47:02'),
(172, 1, '2022-06-14 02:40:28'),
(173, 1, '2022-06-14 13:51:39'),
(174, 1, '2022-06-15 02:57:19'),
(175, 1, '2022-06-15 13:28:25'),
(176, 1, '2022-06-16 02:36:27'),
(177, 1, '2022-06-16 08:29:50'),
(178, 1, '2022-06-17 02:45:51'),
(179, 1, '2022-06-17 05:15:39'),
(180, 1, '2022-06-18 00:42:05'),
(181, 1, '2022-06-18 15:43:30'),
(182, 1, '2022-06-19 08:14:08'),
(183, 1, '2022-06-19 08:14:09'),
(184, 1, '2022-06-19 11:53:51'),
(185, 1, '2022-06-20 07:28:26'),
(186, 1, '2022-06-21 03:13:00'),
(187, 1, '2022-06-21 13:31:41'),
(188, 1, '2022-06-23 03:01:22'),
(189, 1, '2022-06-23 03:58:03'),
(190, 1, '2022-06-24 02:51:20'),
(191, 1, '2022-06-24 02:56:39'),
(192, 1, '2022-06-25 05:09:04'),
(193, 1, '2022-06-25 05:42:37'),
(194, 1, '2022-06-25 16:09:39'),
(195, 1, '2022-06-26 05:26:33'),
(196, 1, '2022-06-27 01:49:46'),
(197, 1, '2022-06-27 06:12:55'),
(198, 1, '2022-06-28 03:17:01'),
(199, 1, '2022-06-28 04:54:34'),
(200, 1, '2022-06-28 05:47:18'),
(201, 1, '2022-06-28 08:32:22'),
(202, 1, '2022-06-28 10:21:22'),
(203, 1, '2022-06-28 11:58:50'),
(204, 1, '2022-06-28 12:11:57'),
(205, 1, '2022-06-28 13:35:14'),
(206, 9, '2022-06-28 13:40:40'),
(207, 1, '2022-06-29 01:16:21'),
(208, 1, '2022-06-29 01:16:38'),
(209, 1, '2022-06-29 01:19:38'),
(210, 1, '2022-06-29 04:17:50'),
(211, 9, '2022-06-29 04:18:48'),
(212, 1, '2022-06-29 10:47:54'),
(213, 1, '2022-06-29 10:49:36'),
(214, 9, '2022-06-29 10:50:07'),
(215, 1, '2022-06-30 00:58:15'),
(216, 9, '2022-06-30 02:09:53'),
(217, 1, '2022-06-30 03:34:14'),
(218, 1, '2022-06-30 03:59:14'),
(219, 1, '2022-07-08 02:03:46'),
(220, 1, '2022-07-08 02:22:11'),
(221, 1, '2022-07-08 02:23:53'),
(222, 1, '2022-07-08 02:54:05'),
(223, 1, '2022-07-08 06:17:23'),
(224, 1, '2022-07-10 00:26:44'),
(225, 1, '2022-07-10 06:12:54'),
(226, 1, '2022-07-11 03:17:06'),
(227, 1, '2022-07-11 08:07:16'),
(228, 1, '2022-07-12 01:21:58'),
(229, 1, '2022-07-12 04:04:01'),
(230, 1, '2022-07-12 04:08:34'),
(231, 1, '2022-07-13 00:59:56'),
(232, 1, '2022-07-13 06:04:10'),
(233, 1, '2022-07-14 01:03:25'),
(234, 1, '2022-07-15 01:00:05'),
(235, 1, '2022-07-15 06:31:15'),
(236, 1, '2022-07-19 09:37:51'),
(237, 1, '2022-07-20 01:07:52'),
(238, 1, '2022-07-20 07:01:09'),
(239, 1, '2022-07-20 10:52:27'),
(240, 1, '2022-07-20 13:53:23'),
(241, 1, '2022-07-20 15:54:27'),
(242, 1, '2022-07-21 00:06:09'),
(243, 1, '2022-07-21 07:54:00'),
(244, 1, '2022-07-21 14:53:16'),
(245, 1, '2022-07-22 00:57:54'),
(246, 1, '2022-07-22 01:08:28'),
(247, 1, '2022-07-22 01:10:58'),
(248, 1, '2022-07-22 01:35:04'),
(249, 1, '2022-07-22 06:15:29'),
(250, 1, '2022-07-25 01:20:30'),
(251, 1, '2022-07-25 12:51:39'),
(252, 1, '2022-07-26 01:01:08'),
(253, 1, '2022-07-26 01:21:23'),
(254, 1, '2022-07-26 03:39:23'),
(255, 9, '2022-07-26 04:40:02'),
(256, 1, '2022-07-26 04:42:03'),
(257, 9, '2022-07-26 04:46:32'),
(258, 1, '2022-07-28 08:00:45'),
(259, 1, '2022-07-28 13:06:28'),
(260, 1, '2022-07-29 08:00:41'),
(261, 1, '2022-07-29 09:18:31'),
(262, 9, '2022-07-29 09:57:51'),
(263, 9, '2022-07-29 13:15:13'),
(264, 9, '2022-07-29 13:39:33'),
(265, 9, '2022-07-29 13:40:22'),
(266, 1, '2022-07-29 13:40:45'),
(267, 9, '2022-07-29 13:48:04'),
(268, 9, '2022-07-29 13:52:52'),
(269, 1, '2022-08-01 07:56:46'),
(270, 9, '2022-08-01 08:01:15'),
(271, 1, '2022-08-01 17:39:59'),
(272, 1, '2022-08-03 08:03:12'),
(273, 1, '2022-08-04 08:04:58'),
(274, 1, '2022-08-05 12:59:51'),
(275, 1, '2022-08-05 19:22:40'),
(276, 1, '2022-08-08 13:29:13'),
(277, 1, '2022-08-08 23:13:22'),
(278, 1, '2022-08-08 18:15:36'),
(279, 1, '2022-08-08 18:56:16'),
(280, 1, '2022-08-08 18:56:39'),
(281, 9, '2022-08-08 19:30:07'),
(282, 1, '2022-08-10 01:48:11'),
(283, 1, '2022-08-10 06:08:49'),
(284, 1, '2022-08-11 00:59:50'),
(285, 9, '2022-08-11 02:02:57'),
(286, 1, '2022-08-11 06:22:37'),
(287, 1, '2022-08-12 01:10:26'),
(288, 1, '2022-08-12 06:26:18'),
(289, 1, '2022-08-13 04:07:31'),
(290, 9, '2022-08-13 04:12:29'),
(291, 1, '2022-08-13 05:16:00'),
(292, 1, '2022-08-13 05:20:16'),
(293, 1, '2022-08-13 13:10:08'),
(294, 1, '2022-08-15 08:02:26'),
(295, 1, '2022-08-15 13:18:48'),
(296, 1, '2022-08-16 07:53:59'),
(297, 1, '2022-08-18 08:01:04'),
(298, 9, '2022-08-18 13:33:36'),
(299, 1, '2022-08-19 07:57:10'),
(300, 9, '2022-08-19 08:02:22'),
(301, 1, '2022-08-19 08:36:50'),
(302, 9, '2022-08-19 08:37:17'),
(303, 1, '2022-08-19 13:11:39'),
(304, 9, '2022-08-19 13:12:21'),
(305, 1, '2022-08-22 02:03:28'),
(306, 9, '2022-08-22 02:15:41'),
(307, 1, '2022-08-22 06:10:55'),
(308, 1, '2022-08-23 08:08:21'),
(309, 9, '2022-08-23 09:02:27'),
(310, 1, '2022-08-24 01:31:41'),
(311, 1, '2022-08-24 10:29:10'),
(312, 1, '2022-08-25 08:11:45'),
(313, 1, '2022-08-25 11:06:14'),
(314, 1, '2022-08-25 14:04:06'),
(315, 1, '2022-08-26 08:05:19'),
(316, 9, '2022-08-26 09:59:57'),
(317, 1, '2022-08-29 08:16:09'),
(318, 1, '2022-08-29 09:42:25'),
(319, 1, '2022-08-29 10:43:51'),
(320, 1, '2022-08-29 20:15:53'),
(321, 8, '2022-08-29 20:20:10'),
(322, 7, '2022-08-29 20:20:49'),
(323, 1, '2022-08-29 20:21:50'),
(324, 1, '2022-08-29 20:22:03'),
(325, 1, '2022-08-29 20:24:24'),
(326, 1, '2022-08-29 20:26:38'),
(327, 1, '2022-08-29 20:27:38'),
(328, 1, '2022-08-29 20:28:41'),
(329, 1, '2022-08-29 20:29:29'),
(330, 1, '2022-08-29 20:37:48'),
(331, 7, '2022-08-29 20:38:31'),
(332, 9, '2022-08-29 20:39:02'),
(333, 1, '2022-08-29 21:26:30'),
(334, 1, '2022-08-29 21:27:29'),
(335, 1, '2022-08-29 21:28:06'),
(336, 1, '2022-08-30 08:08:39'),
(337, 1, '2022-08-30 08:10:09'),
(338, 1, '2022-08-31 08:04:25'),
(339, 1, '2022-08-31 21:17:37'),
(340, 1, '2022-09-01 07:54:08'),
(341, 1, '2022-09-01 08:37:53'),
(342, 12, '2022-09-01 16:22:23'),
(343, 12, '2022-09-01 16:23:54'),
(344, 12, '2022-09-01 16:27:06'),
(345, 12, '2022-09-01 16:27:49'),
(346, 1, '2022-09-01 21:33:10'),
(347, 1, '2022-09-01 21:59:36'),
(348, 1, '2022-09-01 22:07:35'),
(349, 1, '2022-09-01 22:12:30'),
(350, 9, '2022-09-01 22:13:01'),
(351, 1, '2022-09-01 22:14:58'),
(352, 8, '2022-09-01 22:15:21'),
(353, 9, '2022-09-01 22:15:41'),
(354, 1, '2022-09-01 22:19:01'),
(355, 1, '2022-09-01 22:21:29'),
(356, 1, '2022-09-02 08:03:55'),
(357, 1, '2022-09-02 08:09:52'),
(358, 9, '2022-09-02 08:10:09'),
(359, 8, '2022-09-02 08:10:56'),
(360, 7, '2022-09-02 08:11:31'),
(361, 7, '2022-09-02 08:16:45'),
(362, 6, '2022-09-02 08:17:09'),
(363, 1, '2022-09-02 08:18:00'),
(364, 9, '2022-09-02 08:18:19'),
(365, 1, '2022-09-02 08:33:26'),
(366, 1, '2022-09-02 08:50:54'),
(367, 1, '2022-09-02 08:55:48'),
(368, 9, '2022-09-02 08:56:18'),
(369, 1, '2022-09-02 10:08:58'),
(370, 1, '2022-09-02 13:01:15'),
(371, 1, '2022-09-02 13:01:42'),
(372, 9, '2022-09-02 13:02:47'),
(373, 1, '2022-09-03 11:40:37'),
(374, 1, '2022-09-03 13:00:07'),
(375, 9, '2022-09-03 13:00:26'),
(376, 1, '2022-09-04 03:45:40'),
(377, 9, '2022-09-04 03:46:12'),
(378, 1, '2022-09-05 01:01:15'),
(379, 9, '2022-09-05 01:01:36'),
(380, 1, '2022-09-05 01:04:05'),
(381, 1, '2022-09-05 01:04:20'),
(382, 9, '2022-09-05 01:12:54'),
(383, 1, '2022-09-05 06:51:50'),
(384, 1, '2022-09-05 06:52:50'),
(385, 1, '2022-09-05 06:53:10'),
(386, 1, '2022-09-06 01:01:02'),
(387, 9, '2022-09-06 01:01:24'),
(388, 9, '2022-09-06 06:14:06'),
(389, 1, '2022-09-06 06:14:26'),
(390, 1, '2022-09-07 01:08:28'),
(391, 1, '2022-09-07 01:10:32'),
(392, 9, '2022-09-07 01:11:26'),
(393, 9, '2022-09-08 01:34:25'),
(394, 9, '2022-09-08 01:35:25'),
(395, 1, '2022-09-08 01:58:57'),
(396, 1, '2022-09-08 02:11:05'),
(397, 1, '2022-09-08 02:15:35'),
(398, 1, '2022-09-08 02:17:16'),
(399, 9, '2022-09-08 02:19:17'),
(400, 1, '2022-09-08 08:54:58'),
(401, 9, '2022-09-09 01:07:08'),
(402, 1, '2022-09-09 01:08:29'),
(403, 9, '2022-09-09 06:09:46'),
(404, 1, '2022-09-09 06:12:47'),
(405, 9, '2022-09-10 10:36:51'),
(406, 9, '2022-09-12 01:36:24'),
(407, 1, '2022-09-12 02:39:38'),
(408, 1, '2022-09-14 17:14:22'),
(409, 9, '2022-09-14 17:20:24'),
(410, 6, '2022-09-14 17:30:12'),
(411, 8, '2022-09-14 17:32:11'),
(412, 7, '2022-09-14 17:39:11'),
(413, 10, '2022-09-14 17:41:26'),
(414, 1, '2022-09-16 17:46:33'),
(415, 1, '2022-09-16 17:54:04'),
(416, 9, '2022-09-16 17:54:28'),
(417, 7, '2022-09-16 17:55:30'),
(418, 8, '2022-09-16 17:56:17'),
(419, 9, '2022-09-16 18:00:06'),
(420, 6, '2022-09-16 18:05:18'),
(421, 9, '2022-09-16 18:09:51'),
(422, 1, '2022-09-18 18:08:48'),
(423, 7, '2022-09-18 23:18:32'),
(424, 1, '2022-09-18 23:43:07'),
(425, 1, '2022-09-19 06:16:09'),
(426, 1, '2022-09-19 18:34:54'),
(427, 1, '2022-09-21 01:18:14'),
(428, 9, '2022-09-21 01:33:51'),
(429, 1, '2022-09-21 03:22:03'),
(430, 1, '2022-09-21 07:02:57'),
(431, 1, '2022-09-22 01:05:12'),
(432, 1, '2022-09-22 18:24:30'),
(433, 10, '2022-09-22 18:26:49'),
(434, 6, '2022-09-22 18:29:03'),
(435, 1, '2022-09-22 18:36:06'),
(436, 10, '2022-09-22 18:36:34'),
(437, 9, '2022-09-22 19:33:18'),
(438, 1, '2022-09-22 19:41:39'),
(439, 1, '2022-09-22 23:04:42'),
(440, 9, '2022-09-22 23:06:11'),
(441, 10, '2022-09-22 23:07:34'),
(442, 7, '2022-09-22 23:15:04'),
(443, 10, '2022-09-22 23:19:11'),
(444, 7, '2022-09-22 23:35:41'),
(445, 7, '2022-09-22 23:39:50'),
(446, 10, '2022-09-22 23:40:48'),
(447, 8, '2022-09-23 01:33:10'),
(448, 8, '2022-09-23 01:33:55'),
(449, 1, '2022-10-03 18:18:18'),
(450, 1, '2022-10-04 03:36:23'),
(451, 1, '2022-10-05 18:02:34'),
(452, 1, '2022-10-05 23:07:10'),
(453, 1, '2022-10-09 18:35:05'),
(454, 1, '2022-10-09 23:19:28'),
(455, 1, '2022-10-10 03:56:21'),
(456, 1, '2022-10-15 03:09:16'),
(457, 1, '2022-10-16 18:04:14'),
(458, 9, '2022-10-16 18:05:01'),
(459, 1, '2022-10-17 17:58:22'),
(460, 1, '2022-10-18 06:30:56'),
(461, 1, '2022-10-18 23:18:58'),
(462, 9, '2022-10-18 23:20:27'),
(463, 9, '2022-10-18 23:37:00'),
(464, 1, '2022-10-19 04:39:58'),
(465, 1, '2022-10-20 00:51:59'),
(466, 1, '2022-10-20 10:18:03'),
(467, 9, '2022-10-20 10:18:38'),
(468, 1, '2022-10-21 01:08:31'),
(469, 9, '2022-10-21 01:10:26'),
(470, 9, '2022-10-21 02:02:29'),
(471, 9, '2022-10-21 02:23:10'),
(472, 6, '2022-10-21 02:29:33'),
(473, 9, '2022-10-21 05:43:06'),
(474, 1, '2022-10-22 14:16:24'),
(475, 1, '2022-10-24 05:08:37'),
(476, 1, '2022-10-24 20:55:21'),
(477, 7, '2022-10-24 20:56:16'),
(478, 1, '2022-10-25 02:25:21'),
(479, 7, '2022-10-25 02:26:02'),
(480, 8, '2022-10-25 02:27:29'),
(481, 1, '2022-10-26 01:31:53'),
(482, 1, '2022-10-26 01:32:30'),
(483, 7, '2022-10-26 01:46:41'),
(484, 1, '2022-10-26 09:14:16'),
(485, 7, '2022-10-26 09:15:10'),
(486, 1, '2022-10-26 19:08:16'),
(487, 8, '2022-10-26 19:08:46'),
(488, 7, '2022-10-26 19:12:08'),
(489, 8, '2022-10-26 19:12:43'),
(490, 1, '2022-10-26 23:03:33'),
(491, 9, '2022-10-26 23:07:34'),
(492, 1, '2022-10-28 20:34:38'),
(493, 1, '2022-10-30 17:59:18'),
(494, 1, '2022-11-02 01:10:56'),
(495, 1, '2022-11-02 18:01:28'),
(496, 6, '2022-11-02 18:08:32'),
(497, 6, '2022-11-02 18:09:48'),
(498, 1, '2022-11-02 18:10:33'),
(499, 6, '2022-11-02 18:14:26'),
(500, 1, '2022-11-02 18:16:43'),
(501, 6, '2022-11-02 18:18:07'),
(502, 1, '2022-11-02 18:27:08'),
(503, 1, '2022-11-02 18:28:00'),
(504, 6, '2022-11-02 18:28:39'),
(505, 1, '2022-11-02 19:36:00'),
(506, 6, '2022-11-02 19:36:34'),
(507, 1, '2022-11-02 20:05:21'),
(508, 9, '2022-11-02 20:06:21'),
(509, 1, '2022-11-06 18:30:29'),
(510, 1, '2022-11-10 07:58:17'),
(511, 1, '2022-11-13 02:44:11'),
(512, 10, '2022-11-13 02:53:23'),
(513, 10, '2022-11-13 02:57:41'),
(514, 8, '2022-11-13 02:58:17'),
(515, 7, '2022-11-13 02:59:00'),
(516, 9, '2022-11-13 02:59:28'),
(517, 1, '2022-11-13 18:16:30'),
(518, 6, '2022-11-13 18:48:17'),
(519, 1, '2022-11-13 19:17:44'),
(520, 10, '2022-11-13 20:26:54'),
(521, 9, '2022-11-13 20:27:20'),
(522, 6, '2022-11-13 20:27:44'),
(523, 8, '2022-11-13 20:29:05'),
(524, 7, '2022-11-13 20:29:34'),
(525, 1, '2022-11-13 20:30:51'),
(526, 1, '2022-11-13 20:44:57'),
(527, 1, '2022-11-13 20:44:57'),
(528, 1, '2022-11-14 17:55:31'),
(529, 1, '2022-11-14 20:49:49'),
(530, 1, '2022-11-16 00:22:19'),
(531, 1, '2022-11-16 08:38:51'),
(532, 1, '2022-11-16 17:16:24'),
(533, 1, '2022-11-16 23:21:01'),
(534, 1, '2022-11-17 20:25:44'),
(535, 1, '2022-11-17 23:03:48'),
(536, 1, '2022-11-18 03:10:42'),
(537, 1, '2022-11-18 20:56:45'),
(538, 1, '2022-11-19 02:49:23'),
(539, 1, '2022-11-20 02:53:26'),
(540, 1, '2022-11-20 18:24:37'),
(541, 1, '2022-11-21 00:09:24'),
(542, 1, '2022-11-21 18:00:51'),
(543, 7, '2022-11-21 18:30:17'),
(544, 9, '2022-11-21 18:49:59'),
(545, 1, '2022-11-23 06:11:56'),
(546, 1, '2022-11-23 07:09:32'),
(547, 1, '2022-11-23 17:28:26'),
(548, 1, '2022-11-24 00:59:04'),
(549, 1, '2022-11-24 01:28:12'),
(550, 10, '2022-11-24 01:28:35'),
(551, 1, '2022-11-24 01:38:41'),
(552, 9, '2022-11-24 01:39:05'),
(553, 1, '2022-11-24 01:44:19'),
(554, 1, '2022-11-24 01:47:50'),
(555, 10, '2022-11-24 01:49:46'),
(556, 1, '2022-11-24 01:55:07'),
(557, 10, '2022-11-24 02:01:26'),
(558, 9, '2022-11-24 02:08:00'),
(559, 1, '2022-11-24 02:25:09'),
(560, 1, '2022-11-24 02:32:14'),
(561, 6, '2022-11-24 02:33:13'),
(562, 8, '2022-11-24 02:36:34'),
(563, 7, '2022-11-24 02:41:04'),
(564, 7, '2022-11-24 02:44:30'),
(565, 13, '2022-11-24 02:46:52'),
(566, 1, '2022-11-24 02:56:55'),
(567, 9, '2022-11-24 06:18:00'),
(568, 1, '2022-11-25 00:58:15'),
(569, 9, '2022-11-25 01:00:05'),
(570, 7, '2022-11-25 02:33:19'),
(571, 1, '2022-11-25 06:19:57'),
(572, 9, '2022-11-25 12:08:30'),
(573, 1, '2022-11-26 06:20:22'),
(574, 1, '2022-11-27 06:17:08'),
(575, 1, '2022-11-28 01:02:38'),
(576, 9, '2022-11-28 01:03:02'),
(577, 1, '2022-11-28 06:38:06'),
(578, 9, '2022-11-28 06:41:01'),
(579, 1, '2022-11-29 01:03:03'),
(580, 9, '2022-11-29 01:05:16'),
(581, 1, '2022-11-30 01:01:22'),
(582, 9, '2022-11-30 01:02:38'),
(583, 9, '2022-11-30 06:29:16'),
(584, 1, '2022-12-01 00:58:29'),
(585, 1, '2022-12-02 00:58:23'),
(586, 8, '2022-12-02 02:35:56'),
(587, 1, '2022-12-02 06:15:03'),
(588, 1, '2022-12-02 11:53:33'),
(589, 1, '2022-12-03 07:32:43'),
(590, 1, '2022-12-04 05:06:13'),
(591, 1, '2022-12-04 05:15:48'),
(592, 1, '2022-12-04 05:25:07'),
(593, 1, '2022-12-05 00:59:29'),
(594, 1, '2022-12-06 01:00:05'),
(595, 1, '2022-12-06 02:14:32'),
(596, 9, '2022-12-06 02:14:49'),
(597, 9, '2022-12-06 06:21:49'),
(598, 1, '2022-12-06 15:06:56'),
(599, 9, '2022-12-06 15:08:02'),
(600, 1, '2022-12-07 00:57:54'),
(601, 1, '2022-12-07 12:59:07'),
(602, 1, '2022-12-08 01:03:11'),
(603, 9, '2022-12-08 04:31:18'),
(604, 1, '2022-12-08 10:08:57'),
(605, 1, '2022-12-09 01:00:53'),
(606, 9, '2022-12-09 02:10:01'),
(607, 1, '2022-12-09 06:00:57'),
(608, 9, '2022-12-09 06:01:16'),
(609, 1, '2022-12-09 12:32:45'),
(610, 1, '2022-12-09 12:34:42'),
(611, 9, '2022-12-09 12:35:54'),
(612, 1, '2022-12-09 23:14:32'),
(613, 9, '2022-12-09 23:15:13'),
(614, 1, '2022-12-10 10:06:44'),
(615, 9, '2022-12-10 10:07:04'),
(616, 1, '2022-12-10 22:08:04'),
(617, 9, '2022-12-10 22:08:36'),
(618, 7, '2022-12-10 22:59:45'),
(619, 9, '2022-12-10 23:22:45'),
(620, 1, '2022-12-11 04:17:48'),
(621, 9, '2022-12-11 04:18:24'),
(622, 9, '2022-12-11 04:18:25'),
(623, 9, '2022-12-11 09:44:14'),
(624, 9, '2022-12-11 10:26:58'),
(625, 1, '2022-12-11 12:27:20'),
(626, 1, '2022-12-12 01:16:19'),
(627, 9, '2022-12-12 01:18:20'),
(628, 1, '2022-12-12 13:48:07'),
(629, 9, '2022-12-12 13:48:30'),
(630, 1, '2022-12-13 01:17:43'),
(631, 1, '2022-12-13 01:28:03'),
(632, 9, '2022-12-13 01:28:21'),
(633, 1, '2022-12-13 06:34:31'),
(634, 9, '2022-12-13 06:42:24'),
(635, 1, '2022-12-13 13:21:22'),
(636, 9, '2022-12-13 13:21:50'),
(637, 1, '2022-12-14 01:02:55'),
(638, 9, '2022-12-14 01:03:36'),
(639, 9, '2022-12-14 14:11:25'),
(640, 1, '2022-12-15 01:09:36'),
(641, 9, '2022-12-15 01:16:20'),
(642, 1, '2022-12-15 06:04:06'),
(643, 9, '2022-12-15 07:06:37'),
(644, 13, '2022-12-15 09:12:51'),
(645, 1, '2022-12-16 01:26:06'),
(646, 1, '2022-12-16 06:43:25'),
(647, 9, '2022-12-16 06:48:36'),
(648, 1, '2022-12-16 15:45:20'),
(649, 9, '2022-12-16 15:46:27'),
(650, 1, '2022-12-18 16:39:45'),
(651, 1, '2022-12-19 01:13:14'),
(652, 9, '2022-12-19 01:14:03'),
(653, 1, '2022-12-19 01:35:40'),
(654, 1, '2022-12-21 05:24:23'),
(655, 9, '2022-12-21 05:30:47'),
(656, 1, '2022-12-22 01:02:38'),
(657, 9, '2022-12-22 01:02:56'),
(658, 1, '2022-12-22 10:53:18'),
(659, 9, '2022-12-22 10:54:21'),
(660, 1, '2022-12-23 01:02:11'),
(661, 9, '2022-12-23 01:03:26'),
(662, 9, '2022-12-23 06:26:17'),
(663, 1, '2022-12-24 00:52:38'),
(664, 9, '2022-12-24 00:53:13'),
(665, 1, '2022-12-25 11:15:53'),
(666, 1, '2022-12-25 11:20:03'),
(667, 1, '2022-12-25 16:04:42'),
(668, 1, '2022-12-26 01:10:30'),
(669, 9, '2022-12-26 04:15:56'),
(670, 9, '2022-12-26 06:38:09'),
(671, 1, '2022-12-26 11:10:29'),
(672, 9, '2022-12-26 11:11:29'),
(673, 1, '2022-12-27 01:04:34'),
(674, 9, '2022-12-27 01:04:50'),
(675, 9, '2022-12-27 09:31:07'),
(676, 9, '2022-12-27 13:44:29'),
(677, 1, '2022-12-28 01:04:42'),
(678, 9, '2022-12-28 01:04:58'),
(679, 9, '2022-12-28 03:24:27'),
(680, 1, '2022-12-28 06:23:39'),
(681, 9, '2022-12-28 06:24:30'),
(682, 1, '2022-12-28 16:50:51'),
(683, 9, '2022-12-28 16:55:27'),
(684, 1, '2022-12-29 01:03:51'),
(685, 9, '2022-12-29 01:04:14'),
(686, 1, '2022-12-29 01:04:30'),
(687, 9, '2022-12-29 07:36:16'),
(688, 1, '2022-12-29 12:42:59'),
(689, 9, '2022-12-29 12:43:15'),
(690, 1, '2022-12-31 04:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembatalan`
--

CREATE TABLE `detail_pembatalan` (
  `id_konsumen` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `nominal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembatalan`
--

INSERT INTO `detail_pembatalan` (`id_konsumen`, `keterangan`, `nominal`) VALUES
(46, 'Tanda Jadi Lokasi', '0'),
(46, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `harga_kesepakatan_inhouse`
--

CREATE TABLE `harga_kesepakatan_inhouse` (
  `id_kesepakatan` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_kesepakatan` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harga_kesepakatan_inhouse`
--

INSERT INTO `harga_kesepakatan_inhouse` (`id_kesepakatan`, `id_konsumen`, `jml_kesepakatan`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(333, 47, '110000000', '40', '2750000', '10', 1, '2022-09-10', '2022-09-08', '0', 10, 1),
(334, 47, '110000000', '40', '2750000', '10', 0, '2022-10-10', '', '', 0, 1),
(335, 47, '110000000', '40', '2750000', '10', 0, '2022-11-10', '', '', 0, 1),
(336, 47, '110000000', '40', '2750000', '10', 0, '2022-12-10', '', '', 0, 1),
(337, 47, '110000000', '40', '2750000', '10', 0, '2023-01-10', '', '', 0, 1),
(338, 47, '110000000', '40', '2750000', '10', 0, '2023-02-10', '', '', 0, 1),
(339, 47, '110000000', '40', '2750000', '10', 0, '2023-03-10', '', '', 0, 1),
(340, 47, '110000000', '40', '2750000', '10', 0, '2023-04-10', '', '', 0, 1),
(341, 47, '110000000', '40', '2750000', '10', 0, '2023-05-10', '', '', 0, 1),
(342, 47, '110000000', '40', '2750000', '10', 0, '2023-06-10', '', '', 0, 1),
(343, 47, '110000000', '40', '2750000', '10', 0, '2023-07-10', '', '', 0, 1),
(344, 47, '110000000', '40', '2750000', '10', 0, '2023-08-10', '', '', 0, 1),
(345, 47, '110000000', '40', '2750000', '10', 0, '2023-09-10', '', '', 0, 1),
(346, 47, '110000000', '40', '2750000', '10', 0, '2023-10-10', '', '', 0, 1),
(347, 47, '110000000', '40', '2750000', '10', 0, '2023-11-10', '', '', 0, 1),
(348, 47, '110000000', '40', '2750000', '10', 0, '2023-12-10', '', '', 0, 1),
(349, 47, '110000000', '40', '2750000', '10', 0, '2024-01-10', '', '', 0, 1),
(350, 47, '110000000', '40', '2750000', '10', 0, '2024-02-10', '', '', 0, 1),
(351, 47, '110000000', '40', '2750000', '10', 0, '2024-03-10', '', '', 0, 1),
(352, 47, '110000000', '40', '2750000', '10', 0, '2024-04-10', '', '', 0, 1),
(353, 47, '110000000', '40', '2750000', '10', 0, '2024-05-10', '', '', 0, 1),
(354, 47, '110000000', '40', '2750000', '10', 0, '2024-06-10', '', '', 0, 1),
(355, 47, '110000000', '40', '2750000', '10', 0, '2024-07-10', '', '', 0, 1),
(356, 47, '110000000', '40', '2750000', '10', 0, '2024-08-10', '', '', 0, 1),
(357, 47, '110000000', '40', '2750000', '10', 0, '2024-09-10', '', '', 0, 1),
(358, 47, '110000000', '40', '2750000', '10', 0, '2024-10-10', '', '', 0, 1),
(359, 47, '110000000', '40', '2750000', '10', 0, '2024-11-10', '', '', 0, 1),
(360, 47, '110000000', '40', '2750000', '10', 0, '2024-12-10', '', '', 0, 1),
(361, 47, '110000000', '40', '2750000', '10', 0, '2025-01-10', '', '', 0, 1),
(362, 47, '110000000', '40', '2750000', '10', 0, '2025-02-10', '', '', 0, 1),
(363, 47, '110000000', '40', '2750000', '10', 0, '2025-03-10', '', '', 0, 1),
(364, 47, '110000000', '40', '2750000', '10', 0, '2025-04-10', '', '', 0, 1),
(365, 47, '110000000', '40', '2750000', '10', 0, '2025-05-10', '', '', 0, 1),
(366, 47, '110000000', '40', '2750000', '10', 0, '2025-06-10', '', '', 0, 1),
(367, 47, '110000000', '40', '2750000', '10', 0, '2025-07-10', '', '', 0, 1),
(368, 47, '110000000', '40', '2750000', '10', 0, '2025-08-10', '', '', 0, 1),
(369, 47, '110000000', '40', '2750000', '10', 0, '2025-09-10', '', '', 0, 1),
(370, 47, '110000000', '40', '2750000', '10', 0, '2025-10-10', '', '', 0, 1),
(371, 47, '110000000', '40', '2750000', '10', 0, '2025-11-10', '', '', 0, 1),
(372, 47, '110000000', '40', '2750000', '10', 0, '2025-12-10', '', '', 0, 1),
(373, 52, '100000000', '20', '5000000', '1', 0, '2022-11-01', '', '', 0, 1),
(374, 52, '100000000', '20', '5000000', '1', 0, '2022-12-01', '', '', 0, 1),
(375, 52, '100000000', '20', '5000000', '1', 0, '2023-01-01', '', '', 0, 1),
(376, 52, '100000000', '20', '5000000', '1', 0, '2023-02-01', '', '', 0, 1),
(377, 52, '100000000', '20', '5000000', '1', 0, '2023-03-01', '', '', 0, 1),
(378, 52, '100000000', '20', '5000000', '1', 0, '2023-04-01', '', '', 0, 1),
(379, 52, '100000000', '20', '5000000', '1', 0, '2023-05-01', '', '', 0, 1),
(380, 52, '100000000', '20', '5000000', '1', 0, '2023-06-01', '', '', 0, 1),
(381, 52, '100000000', '20', '5000000', '1', 0, '2023-07-01', '', '', 0, 1),
(382, 52, '100000000', '20', '5000000', '1', 0, '2023-08-01', '', '', 0, 1),
(383, 52, '100000000', '20', '5000000', '1', 0, '2023-09-01', '', '', 0, 1),
(384, 52, '100000000', '20', '5000000', '1', 0, '2023-10-01', '', '', 0, 1),
(385, 52, '100000000', '20', '5000000', '1', 0, '2023-11-01', '', '', 0, 1),
(386, 52, '100000000', '20', '5000000', '1', 0, '2023-12-01', '', '', 0, 1),
(387, 52, '100000000', '20', '5000000', '1', 0, '2024-01-01', '', '', 0, 1),
(388, 52, '100000000', '20', '5000000', '1', 0, '2024-02-01', '', '', 0, 1),
(389, 52, '100000000', '20', '5000000', '1', 0, '2024-03-01', '', '', 0, 1),
(390, 52, '100000000', '20', '5000000', '1', 0, '2024-04-01', '', '', 0, 1),
(391, 52, '100000000', '20', '5000000', '1', 0, '2024-05-01', '', '', 0, 1),
(392, 52, '100000000', '20', '5000000', '1', 0, '2024-06-01', '', '', 0, 1),
(393, 53, '200000', '4', '50000', '2', 3, '2022-11-02', '2022-11-26', '6000', 10, 1),
(394, 53, '200000', '4', '50000', '2', 0, '2022-12-02', '', '', 0, 1),
(395, 53, '200000', '4', '50000', '2', 0, '2023-01-02', '', '', 0, 1),
(396, 53, '200000', '4', '50000', '2', 0, '2023-02-02', '', '', 0, 1),
(397, 54, '150000000', '60', '2500000', '5', 0, '2023-01-05', '', '', 0, 1),
(398, 54, '150000000', '60', '2500000', '5', 0, '2023-02-05', '', '', 0, 1),
(399, 54, '150000000', '60', '2500000', '5', 0, '2023-03-05', '', '', 0, 1),
(400, 54, '150000000', '60', '2500000', '5', 0, '2023-04-05', '', '', 0, 1),
(401, 54, '150000000', '60', '2500000', '5', 0, '2023-05-05', '', '', 0, 1),
(402, 54, '150000000', '60', '2500000', '5', 0, '2023-06-05', '', '', 0, 1),
(403, 54, '150000000', '60', '2500000', '5', 0, '2023-07-05', '', '', 0, 1),
(404, 54, '150000000', '60', '2500000', '5', 0, '2023-08-05', '', '', 0, 1),
(405, 54, '150000000', '60', '2500000', '5', 0, '2023-09-05', '', '', 0, 1),
(406, 54, '150000000', '60', '2500000', '5', 0, '2023-10-05', '', '', 0, 1),
(407, 54, '150000000', '60', '2500000', '5', 0, '2023-11-05', '', '', 0, 1),
(408, 54, '150000000', '60', '2500000', '5', 0, '2023-12-05', '', '', 0, 1),
(409, 54, '150000000', '60', '2500000', '5', 0, '2024-01-05', '', '', 0, 1),
(410, 54, '150000000', '60', '2500000', '5', 0, '2024-02-05', '', '', 0, 1),
(411, 54, '150000000', '60', '2500000', '5', 0, '2024-03-05', '', '', 0, 1),
(412, 54, '150000000', '60', '2500000', '5', 0, '2024-04-05', '', '', 0, 1),
(413, 54, '150000000', '60', '2500000', '5', 0, '2024-05-05', '', '', 0, 1),
(414, 54, '150000000', '60', '2500000', '5', 0, '2024-06-05', '', '', 0, 1),
(415, 54, '150000000', '60', '2500000', '5', 0, '2024-07-05', '', '', 0, 1),
(416, 54, '150000000', '60', '2500000', '5', 0, '2024-08-05', '', '', 0, 1),
(417, 54, '150000000', '60', '2500000', '5', 0, '2024-09-05', '', '', 0, 1),
(418, 54, '150000000', '60', '2500000', '5', 0, '2024-10-05', '', '', 0, 1),
(419, 54, '150000000', '60', '2500000', '5', 0, '2024-11-05', '', '', 0, 1),
(420, 54, '150000000', '60', '2500000', '5', 0, '2024-12-05', '', '', 0, 1),
(421, 54, '150000000', '60', '2500000', '5', 0, '2025-01-05', '', '', 0, 1),
(422, 54, '150000000', '60', '2500000', '5', 0, '2025-02-05', '', '', 0, 1),
(423, 54, '150000000', '60', '2500000', '5', 0, '2025-03-05', '', '', 0, 1),
(424, 54, '150000000', '60', '2500000', '5', 0, '2025-04-05', '', '', 0, 1),
(425, 54, '150000000', '60', '2500000', '5', 0, '2025-05-05', '', '', 0, 1),
(426, 54, '150000000', '60', '2500000', '5', 0, '2025-06-05', '', '', 0, 1),
(427, 54, '150000000', '60', '2500000', '5', 0, '2025-07-05', '', '', 0, 1),
(428, 54, '150000000', '60', '2500000', '5', 0, '2025-08-05', '', '', 0, 1),
(429, 54, '150000000', '60', '2500000', '5', 0, '2025-09-05', '', '', 0, 1),
(430, 54, '150000000', '60', '2500000', '5', 0, '2025-10-05', '', '', 0, 1),
(431, 54, '150000000', '60', '2500000', '5', 0, '2025-11-05', '', '', 0, 1),
(432, 54, '150000000', '60', '2500000', '5', 0, '2025-12-05', '', '', 0, 1),
(433, 54, '150000000', '60', '2500000', '5', 0, '2026-01-05', '', '', 0, 1),
(434, 54, '150000000', '60', '2500000', '5', 0, '2026-02-05', '', '', 0, 1),
(435, 54, '150000000', '60', '2500000', '5', 0, '2026-03-05', '', '', 0, 1),
(436, 54, '150000000', '60', '2500000', '5', 0, '2026-04-05', '', '', 0, 1),
(437, 54, '150000000', '60', '2500000', '5', 0, '2026-05-05', '', '', 0, 1),
(438, 54, '150000000', '60', '2500000', '5', 0, '2026-06-05', '', '', 0, 1),
(439, 54, '150000000', '60', '2500000', '5', 0, '2026-07-05', '', '', 0, 1),
(440, 54, '150000000', '60', '2500000', '5', 0, '2026-08-05', '', '', 0, 1),
(441, 54, '150000000', '60', '2500000', '5', 0, '2026-09-05', '', '', 0, 1),
(442, 54, '150000000', '60', '2500000', '5', 0, '2026-10-05', '', '', 0, 1),
(443, 54, '150000000', '60', '2500000', '5', 0, '2026-11-05', '', '', 0, 1),
(444, 54, '150000000', '60', '2500000', '5', 0, '2026-12-05', '', '', 0, 1),
(445, 54, '150000000', '60', '2500000', '5', 0, '2027-01-05', '', '', 0, 1),
(446, 54, '150000000', '60', '2500000', '5', 0, '2027-02-05', '', '', 0, 1),
(447, 54, '150000000', '60', '2500000', '5', 0, '2027-03-05', '', '', 0, 1),
(448, 54, '150000000', '60', '2500000', '5', 0, '2027-04-05', '', '', 0, 1),
(449, 54, '150000000', '60', '2500000', '5', 0, '2027-05-05', '', '', 0, 1),
(450, 54, '150000000', '60', '2500000', '5', 0, '2027-06-05', '', '', 0, 1),
(451, 54, '150000000', '60', '2500000', '5', 0, '2027-07-05', '', '', 0, 1),
(452, 54, '150000000', '60', '2500000', '5', 0, '2027-08-05', '', '', 0, 1),
(453, 54, '150000000', '60', '2500000', '5', 0, '2027-09-05', '', '', 0, 1),
(454, 54, '150000000', '60', '2500000', '5', 0, '2027-10-05', '', '', 0, 1),
(455, 54, '150000000', '60', '2500000', '5', 0, '2027-11-05', '', '', 0, 1),
(456, 54, '150000000', '60', '2500000', '5', 0, '2027-12-05', '', '', 0, 1),
(457, 57, '120000000', '10', '12000000', '3', 1, '2023-01-03', '', '0', 10, 1),
(458, 57, '120000000', '10', '12000000', '3', 0, '2023-02-03', '', '0', 0, 1),
(459, 57, '120000000', '10', '12000000', '3', 0, '2023-03-03', '', '0', 0, 1),
(460, 57, '120000000', '10', '12000000', '3', 0, '2023-04-03', '', '0', 0, 1),
(461, 57, '120000000', '10', '12000000', '3', 0, '2023-05-03', '', '0', 0, 1),
(462, 57, '120000000', '10', '12000000', '3', 0, '2023-06-03', '', '0', 0, 1),
(463, 57, '120000000', '10', '12000000', '3', 0, '2023-07-03', '', '0', 0, 1),
(464, 57, '120000000', '10', '12000000', '3', 0, '2023-08-03', '', '0', 0, 1),
(465, 57, '120000000', '10', '12000000', '3', 0, '2023-09-03', '', '0', 0, 1),
(466, 57, '120000000', '10', '12000000', '3', 0, '2023-10-03', '', '0', 0, 1),
(467, 60, '120000000', '20', '6000000', '1', 1, '2023-01-01', '', '0', 10, 1),
(468, 60, '120000000', '20', '6000000', '1', 0, '2023-02-01', '', '0', 0, 1),
(469, 60, '120000000', '20', '6000000', '1', 0, '2023-03-01', '', '0', 0, 1),
(470, 60, '120000000', '20', '6000000', '1', 0, '2023-04-01', '', '0', 0, 1),
(471, 60, '120000000', '20', '6000000', '1', 0, '2023-05-01', '', '0', 0, 1),
(472, 60, '120000000', '20', '6000000', '1', 0, '2023-06-01', '', '0', 0, 1),
(473, 60, '120000000', '20', '6000000', '1', 0, '2023-07-01', '', '0', 0, 1),
(474, 60, '120000000', '20', '6000000', '1', 0, '2023-08-01', '', '0', 0, 1),
(475, 60, '120000000', '20', '6000000', '1', 0, '2023-09-01', '', '0', 0, 1),
(476, 60, '120000000', '20', '6000000', '1', 0, '2023-10-01', '', '0', 0, 1),
(477, 60, '120000000', '20', '6000000', '1', 0, '2023-11-01', '', '0', 0, 1),
(478, 60, '120000000', '20', '6000000', '1', 0, '2023-12-01', '', '0', 0, 1),
(479, 60, '120000000', '20', '6000000', '1', 0, '2024-01-01', '', '0', 0, 1),
(480, 60, '120000000', '20', '6000000', '1', 0, '2024-02-01', '', '0', 0, 1),
(481, 60, '120000000', '20', '6000000', '1', 0, '2024-03-01', '', '0', 0, 1),
(482, 60, '120000000', '20', '6000000', '1', 0, '2024-04-01', '', '0', 0, 1),
(483, 60, '120000000', '20', '6000000', '1', 0, '2024-05-01', '', '0', 0, 1),
(484, 60, '120000000', '20', '6000000', '1', 0, '2024-06-01', '', '0', 0, 1),
(485, 60, '120000000', '20', '6000000', '1', 0, '2024-07-01', '', '0', 0, 1),
(486, 60, '120000000', '20', '6000000', '1', 0, '2024-08-01', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inhouse_cicil_hk`
--

CREATE TABLE `inhouse_cicil_hk` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inhouse_cicil_hk`
--

INSERT INTO `inhouse_cicil_hk` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 457, '2022-12-27', '3000000', 'avatar23.png', 'bg_login114.jpg', 3),
(2, 467, '2022-12-28', '20000', 'bg_login33.jpg', 'avatar33.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `inhouse_cicil_kt`
--

CREATE TABLE `inhouse_cicil_kt` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inhouse_cicil_kt`
--

INSERT INTO `inhouse_cicil_kt` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 65, '2022-12-27', '50000', 'Screenshot_421.png', 'pray3.png', 3),
(2, 70, '2022-12-28', '30000', 'Screenshot_427.png', 'Screenshot_428.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inhouse_cicil_tj`
--

CREATE TABLE `inhouse_cicil_tj` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inhouse_cicil_tj`
--

INSERT INTO `inhouse_cicil_tj` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 34, '2022-12-27', '1000000', 'avatar27.png', 'bg_login30.jpg', 3),
(2, 35, '2022-12-28', '250000', 'bg_login32.jpg', 'avatar32.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `inhouse_cicil_tjl`
--

CREATE TABLE `inhouse_cicil_tjl` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inhouse_cicil_tjl`
--

INSERT INTO `inhouse_cicil_tjl` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 85, '2022-12-27', '54000', 'avatar24.png', 'bg_login115.jpg', 3),
(2, 90, '2022-12-28', '24000', 'bg_login34.jpg', 'bg_login214.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `inhouse_cicil_um`
--

CREATE TABLE `inhouse_cicil_um` (
  `id_cicil` int(11) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(100) NOT NULL,
  `bukti_transfer` varchar(200) NOT NULL,
  `bukti_nota` varchar(200) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inhouse_cicil_um`
--

INSERT INTO `inhouse_cicil_um` (`id_cicil`, `id_pembayaran`, `tanggal`, `jumlah`, `bukti_transfer`, `bukti_nota`, `status`) VALUES
(1, 62, '2022-12-27', '20000', 'bg_login210.jpg', 'bg_login211.jpg', 3),
(2, 67, '2022-12-28', '340000', 'bg_login35.jpg', 'pray5.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kas_operasional`
--

CREATE TABLE `kas_operasional` (
  `id_kas` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `keterangan` text NOT NULL,
  `jumlah` varchar(20) NOT NULL,
  `id_perumahan` int(11) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_operasional`
--

INSERT INTO `kas_operasional` (`id_kas`, `tgl_input`, `keterangan`, `jumlah`, `id_perumahan`, `title_kode`, `status`) VALUES
(1, '2022-12-12', 'Liburan gan', '2300000', 1, 25, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kelebihan_tanah`
--

CREATE TABLE `kelebihan_tanah` (
  `id_kt` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_kt` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelebihan_tanah`
--

INSERT INTO `kelebihan_tanah` (`id_kt`, `id_konsumen`, `jml_kt`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(47, 46, '5000000', '5', '1000000', '1', 1, '2022-10-01', '2022-09-08', '0', 7, 1),
(48, 46, '5000000', '5', '1000000', '1', 0, '2022-11-01', '', '', 0, 1),
(49, 46, '5000000', '5', '1000000', '1', 0, '2022-12-01', '', '', 0, 1),
(50, 46, '5000000', '5', '1000000', '1', 0, '2023-01-01', '', '', 0, 1),
(51, 46, '5000000', '5', '1000000', '1', 0, '2023-02-01', '', '', 0, 1),
(52, 50, '5000000', '5', '1000000', '1', 0, '2022-10-01', '', '', 0, 0),
(53, 50, '5000000', '5', '1000000', '1', 0, '2022-11-01', '', '', 0, 0),
(54, 50, '5000000', '5', '1000000', '1', 0, '2022-12-01', '', '', 0, 0),
(55, 50, '5000000', '5', '1000000', '1', 0, '2023-01-01', '', '', 0, 0),
(56, 50, '5000000', '5', '1000000', '1', 0, '2023-02-01', '', '', 0, 0),
(57, 58, '150000', '5', '300000', '5', 1, '2023-01-05', '', '0', 7, 1),
(58, 58, '150000', '5', '300000', '5', 0, '2023-02-05', '', '0', 0, 1),
(59, 58, '150000', '5', '300000', '5', 0, '2023-03-05', '', '0', 0, 1),
(60, 58, '150000', '5', '300000', '5', 0, '2023-04-05', '', '0', 0, 1),
(61, 58, '150000', '5', '300000', '5', 0, '2023-05-05', '', '0', 0, 1),
(62, 59, '760000', '5', '152000', '2', 1, '2023-01-02', '', '0', 7, 1),
(63, 59, '760000', '5', '152000', '2', 0, '2023-02-02', '', '0', 0, 1),
(64, 59, '760000', '5', '152000', '2', 0, '2023-03-02', '', '0', 0, 1),
(65, 59, '760000', '5', '152000', '2', 0, '2023-04-02', '', '0', 0, 1),
(66, 59, '760000', '5', '152000', '2', 0, '2023-05-02', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kelebihan_tanah_inhouse`
--

CREATE TABLE `kelebihan_tanah_inhouse` (
  `id_kt` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_kt` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelebihan_tanah_inhouse`
--

INSERT INTO `kelebihan_tanah_inhouse` (`id_kt`, `id_konsumen`, `jml_kt`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(48, 47, '7000000', '10', '700000', '1', 1, '2022-10-01', '2022-09-08', '0', 13, 1),
(49, 47, '7000000', '10', '700000', '1', 0, '2022-11-01', '', '', 0, 1),
(50, 47, '7000000', '10', '700000', '1', 0, '2022-12-01', '', '', 0, 1),
(51, 47, '7000000', '10', '700000', '1', 0, '2023-01-01', '', '', 0, 1),
(52, 47, '7000000', '10', '700000', '1', 0, '2023-02-01', '', '', 0, 1),
(53, 47, '7000000', '10', '700000', '1', 0, '2023-03-01', '', '', 0, 1),
(54, 47, '7000000', '10', '700000', '1', 0, '2023-04-01', '', '', 0, 1),
(55, 47, '7000000', '10', '700000', '1', 0, '2023-05-01', '', '', 0, 1),
(56, 47, '7000000', '10', '700000', '1', 0, '2023-06-01', '', '', 0, 1),
(57, 47, '7000000', '10', '700000', '1', 0, '2023-07-01', '', '', 0, 1),
(60, 53, '4500000', '5', '900000', '2', 0, '2022-11-02', '', '', 0, 1),
(61, 53, '4500000', '5', '900000', '2', 0, '2022-12-02', '', '', 0, 1),
(62, 53, '4500000', '5', '900000', '2', 0, '2023-01-02', '', '', 0, 1),
(63, 53, '4500000', '5', '900000', '2', 0, '2023-02-02', '', '', 0, 1),
(64, 53, '4500000', '5', '900000', '2', 0, '2023-03-02', '', '', 0, 1),
(65, 57, '500000', '5', '100000', '3', 1, '2023-01-03', '', '0', 13, 1),
(66, 57, '500000', '5', '100000', '3', 0, '2023-02-03', '', '0', 0, 1),
(67, 57, '500000', '5', '100000', '3', 0, '2023-03-03', '', '0', 0, 1),
(68, 57, '500000', '5', '100000', '3', 0, '2023-04-03', '', '0', 0, 1),
(69, 57, '500000', '5', '100000', '3', 0, '2023-05-03', '', '0', 0, 1),
(70, 60, '2000000', '5', '400000', '25', 1, '2023-01-25', '', '0', 13, 1),
(71, 60, '2000000', '5', '400000', '25', 0, '2023-02-25', '', '0', 0, 1),
(72, 60, '2000000', '5', '400000', '25', 0, '2023-03-25', '', '0', 0, 1),
(73, 60, '2000000', '5', '400000', '25', 0, '2023-04-25', '', '0', 0, 1),
(74, 60, '2000000', '5', '400000', '25', 0, '2023-05-25', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kode`
--

CREATE TABLE `kode` (
  `id_kode` int(11) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `deskripsi_kode` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kode`
--

INSERT INTO `kode` (`id_kode`, `kode`, `deskripsi_kode`) VALUES
(5, '2', 'Pengeluaran'),
(6, '1', 'Pemasukan');

-- --------------------------------------------------------

--
-- Table structure for table `lain_lain`
--

CREATE TABLE `lain_lain` (
  `id_lain` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_lain` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lain_lain`
--

INSERT INTO `lain_lain` (`id_lain`, `id_konsumen`, `jml_lain`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(46, 46, '6740000', '2', '3370000', '5', 0, '2022-10-05', '', '', 0, 0),
(47, 46, '6740000', '2', '3370000', '5', 0, '2022-11-05', '', '', 0, 0),
(48, 50, '6740000', '10', '674000', '2', 0, '2022-10-02', '', '', 0, 0),
(49, 50, '6740000', '10', '674000', '2', 0, '2022-11-02', '', '', 0, 0),
(50, 50, '6740000', '10', '674000', '2', 0, '2022-12-02', '', '', 0, 0),
(51, 50, '6740000', '10', '674000', '2', 0, '2023-01-02', '', '', 0, 0),
(52, 50, '6740000', '10', '674000', '2', 0, '2023-02-02', '', '', 0, 0),
(53, 50, '6740000', '10', '674000', '2', 0, '2023-03-02', '', '', 0, 0),
(54, 50, '6740000', '10', '674000', '2', 0, '2023-04-02', '', '', 0, 0),
(55, 50, '6740000', '10', '674000', '2', 0, '2023-05-02', '', '', 0, 0),
(56, 50, '6740000', '10', '674000', '2', 0, '2023-06-02', '', '', 0, 0),
(57, 50, '6740000', '10', '674000', '2', 0, '2023-07-02', '', '', 0, 0),
(58, 51, '300000', '1', '300000', '3', 3, '2022-11-03', '2022-11-26', '34500', 22, 1),
(59, 58, '300000', '3', '100000', '5', 1, '2023-01-05', '', '0', 9, 1),
(60, 58, '300000', '3', '100000', '5', 0, '2023-02-05', '', '0', 0, 1),
(61, 58, '300000', '3', '100000', '5', 0, '2023-03-05', '', '0', 0, 1),
(62, 59, '1000000', '5', '200000', '25', 1, '2023-01-25', '', '0', 9, 1),
(63, 59, '1000000', '5', '200000', '25', 0, '2023-02-25', '', '0', 0, 1),
(64, 59, '1000000', '5', '200000', '25', 0, '2023-03-25', '', '0', 0, 1),
(65, 59, '1000000', '5', '200000', '25', 0, '2023-04-25', '', '0', 0, 1),
(66, 59, '1000000', '5', '200000', '25', 0, '2023-05-25', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id` int(11) NOT NULL,
  `tipe_id` int(11) DEFAULT NULL COMMENT '1 = pemasukan 2 = pengeluaran',
  `kategori_id` int(11) DEFAULT NULL COMMENT 'kategori transaksi',
  `nominal` int(11) DEFAULT NULL,
  `nama_transaksi` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `datetimes` timestamp NULL DEFAULT current_timestamp(),
  `jenis_kas` int(11) DEFAULT NULL COMMENT '1=kas besar, 2=kas kecil',
  `user_id` int(11) DEFAULT NULL,
  `user_update` int(11) DEFAULT NULL,
  `tanggal_update` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` int(11) DEFAULT 0 COMMENT '0 = aktif, 1=delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `laporan_keuangan`
--

INSERT INTO `laporan_keuangan` (`id`, `tipe_id`, `kategori_id`, `nominal`, `nama_transaksi`, `tanggal`, `datetimes`, `jenis_kas`, `user_id`, `user_update`, `tanggal_update`, `action`) VALUES
(1, 1, 3, 10000000, 'Saldo Awal Yayasan', '2020-12-28', '2020-12-28 13:28:44', 1, 1, 1, '2022-01-14 07:01:47', 1),
(2, 1, 18, 1500000, 'Donasi untuk makan anak Yatim Dhuafa', '2021-01-07', '2021-01-07 14:45:05', 1, 1, 1, '2022-01-14 07:01:47', 1),
(3, 1, 18, 1000000, 'Donasi untuk Iftor', '2021-01-06', '2021-01-07 14:46:35', 1, 1, 1, '2022-01-14 07:01:47', 1),
(4, 1, 20, 1250000, 'Donasi Yatim Dhuafa', '2021-01-08', '2021-01-08 13:30:07', 1, 1, 1, '2022-01-14 07:01:47', 1),
(5, 1, 11, 365000, 'dari Bang Janu', '2021-01-05', '2021-01-08 13:36:37', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(6, 2, 8, 250000, 'Belanja dapur untuk Iftor', '2021-01-14', '2021-01-08 13:49:14', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(7, 2, 4, 1800000, 'Gaji Udin', '2021-01-11', '2021-01-08 15:47:38', 1, 1, 1, '2022-01-14 07:01:47', 1),
(8, 1, 1, 750000, 'Hasil Jual sepeda BMX bekas', '2021-01-08', '2021-01-08 16:13:36', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(9, 2, 2, 450000, 'Beli Meja belajar Santri', '2021-01-09', '2021-01-08 16:15:17', 1, 1, 1, '2022-01-14 07:01:47', 1),
(10, 2, 8, 350000, 'Biaya konsumsi rapat Ahad 10-01-2021', '2021-01-10', '2021-01-11 03:40:16', 1, 1, 1, '2022-01-14 07:01:47', 1),
(11, 1, 3, 1000000, 'donasi', '2021-01-25', '2021-01-25 03:25:19', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(12, 1, 3, 7678888, 'Saldo awal Bln Desember', '2020-01-01', '2021-01-29 07:10:26', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(13, 1, 3, 7678888, 'saldo bln desember', '2020-01-01', '2021-01-29 07:14:07', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(14, 1, 26, 40000000, 'ambil dari BRI', '2020-01-01', '2021-01-29 07:30:27', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(15, 2, 8, 2560000, 'uang saku anak sekolah', '2020-01-01', '2021-01-29 07:32:29', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(16, 2, 7, 1760000, 'transport anak sekolah', '2020-01-01', '2021-01-29 07:33:38', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(17, 2, 9, 3800000, 'spp anak', '2020-01-01', '2021-01-29 07:35:01', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(18, 2, 10, 3000000, 'ops perwari dan pancaran kasih', '2020-01-01', '2021-01-29 07:37:13', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(19, 2, 12, 3500000, 'belanja dapur', '2020-01-01', '2021-01-29 07:39:31', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(20, 2, 13, 2500000, 'dana pengeluran rutin', '2020-01-01', '2021-01-29 07:41:46', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(21, 2, 19, 8000000, 'dana operasional', '2020-01-01', '2021-01-29 07:43:40', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(22, 2, 4, 17500000, 'transport pengurus', '2020-01-01', '2021-01-29 07:45:32', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(23, 1, 22, 500000, '20,589,90,91', '2020-01-02', '2021-01-29 07:47:40', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(24, 1, 22, 500000, 'no.20,589,90,91', '2020-01-02', '2021-01-29 07:49:12', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(25, 1, 22, 500000, 'donatur', '2020-01-02', '2021-01-29 07:51:05', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(26, 1, 30, 500000, 'donatur,20,589,90,91', '2020-01-02', '2021-01-29 08:23:16', 1, 1, NULL, '2022-01-14 07:01:47', 1),
(27, 1, 22, 2287000, '20,596,92,98,600,01,05', '2020-01-03', '2021-01-30 03:05:57', 1, 1, 3, '2022-01-14 07:01:47', 0),
(28, 1, 22, 600000, '20,606,07,10', '2020-01-05', '2021-01-30 03:12:43', 1, 1, 3, '2022-01-14 07:01:47', 0),
(29, 1, 22, 1600000, '20,631,32', '2020-01-06', '2021-01-30 03:14:58', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(30, 2, 16, 4880000, 'belanja barang', '2020-01-06', '2021-01-30 03:17:09', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(31, 1, 22, 1500000, '20,631', '2020-01-07', '2021-01-30 03:18:05', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(32, 1, 27, 500000, 'sewa kios pandawa', '2020-01-08', '2021-01-30 03:19:14', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(33, 2, 2, 150000, 'sabun cuci', '2020-01-08', '2021-01-30 03:20:41', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(34, 1, 22, 300000, '20,623', '2020-01-08', '2021-01-30 03:21:53', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(35, 1, 22, 300000, '20,631,32', '2020-01-09', '2021-01-30 03:33:32', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(36, 1, 22, 2287000, '20,633,38,39,40,41,42', '2020-01-10', '2021-01-30 03:35:20', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(37, 1, 22, 500000, '20,644', '2020-01-11', '2021-01-30 03:36:08', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(38, 1, 22, 1050000, '20,646,48,49,701,03', '2020-01-12', '2021-01-30 03:37:19', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(39, 1, 22, 1400000, '20,651,52', '2020-01-13', '2021-01-30 03:38:11', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(40, 2, 25, 5000000, 'Masuk BRI', '2020-01-14', '2021-01-30 03:41:08', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(41, 2, 25, 4000000, 'Masuk BRI', '2020-01-15', '2021-01-30 03:42:05', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(42, 1, 22, 1300000, '20,656,57,58', '2020-01-16', '2021-01-30 03:43:37', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(43, 1, 22, 2800000, '20/659,65,68', '2020-01-17', '2021-01-30 03:44:33', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(44, 1, 22, 99000, '20,674', '2020-01-19', '2021-01-30 03:45:25', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(45, 1, 22, 300000, '20,675,77', '2020-01-20', '2021-01-30 03:46:06', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(46, 1, 22, 300000, '20,682', '2020-01-22', '2021-01-30 03:47:12', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(47, 2, 9, 4000000, 'kursus montir dan nyopir agil', '2020-01-22', '2021-01-30 03:48:46', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(48, 2, 2, 1700000, 'pembelian CCTV', '2020-01-22', '2021-01-30 03:49:35', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(49, 2, 2, 1000000, 'acesoris', '2020-01-22', '2021-01-30 03:50:25', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(50, 1, 22, 300000, '20,685', '2020-01-23', '2021-01-30 03:51:14', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(51, 1, 22, 1350000, '20,686,87,88,89,90', '2020-01-24', '2021-01-30 03:58:14', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(52, 1, 22, 1400000, '20,694,96,97', '2020-01-25', '2021-01-30 04:05:32', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(53, 1, 30, 20000000, 'bukopin', '2020-01-25', '2021-01-30 04:06:48', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(54, 2, 25, 10000000, 'Masuk BRI', '2020-01-25', '2021-01-30 04:07:55', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(55, 2, 2, 10000000, 'keperluan panti', '2020-01-25', '2021-01-30 04:09:36', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(56, 1, 22, 1400000, '20,694,96,97', '2020-01-27', '2021-01-30 04:12:54', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(57, 1, 22, 250000, '20,707', '2020-01-28', '2021-01-30 04:13:42', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(58, 1, 22, 100000, '20,708', '2020-01-29', '2021-01-30 04:14:34', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(59, 1, 22, 1300000, '20,709,10,11,12', '2020-01-30', '2021-01-30 04:15:30', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(60, 2, 19, 224000, 'bayar gas', '2020-01-31', '2021-01-30 04:18:57', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(61, 2, 19, 694000, 'bayar PLN', '2020-01-31', '2021-01-30 04:20:15', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(62, 2, 19, 304000, 'bayar TLP/SPEEDY', '2020-01-31', '2021-01-30 04:21:09', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(63, 1, 22, 200000, 'test pertama', '2021-01-30', '2021-01-30 04:34:50', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(64, 1, 22, 250000, 'test kedua', '2021-01-30', '2021-01-30 04:35:01', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(65, 1, 22, 320000, 'test ketiga', '2021-01-30', '2021-01-30 04:35:17', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(66, 1, 22, 450000, 'test ke empat', '2021-01-30', '2021-01-30 04:35:31', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(67, 1, 22, 250000, 'test 5', '2021-01-30', '2021-01-30 04:35:45', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(68, 1, 22, 1250000, 'test 6', '2021-01-30', '2021-01-30 04:35:58', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(69, 1, 22, 255200, 'texst 7', '2021-01-30', '2021-01-30 04:36:14', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(70, 1, 30, 350000, 'test 8', '2021-01-30', '2021-01-30 04:36:38', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(71, 1, 30, 215600, 'test 9', '2021-01-30', '2021-01-30 04:36:58', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(72, 1, 30, 54600, 'test 10', '2021-01-30', '2021-01-30 04:37:11', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(73, 2, 8, 25000, 'keluar 1', '2021-01-30', '2021-01-30 04:39:02', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(74, 2, 12, 35000, 'keluar 2', '2021-01-30', '2021-01-30 04:39:16', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(75, 2, 8, 150000, 'keluar 3', '2021-01-30', '2021-01-30 04:40:03', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(76, 2, 6, 454000, 'fsdfds', '2021-01-30', '2021-01-30 04:40:19', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(77, 2, 6, 6657600, '4545656', '2021-01-30', '2021-01-30 04:41:32', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(78, 1, 22, 2500000, 'untuk beli buku', '2021-03-01', '2021-03-05 02:52:24', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(79, 1, 22, 350000, 'Sodaqoh', '2021-03-03', '2021-03-05 02:52:57', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(80, 2, 6, 50000, 'Bensin Guru', '2021-03-05', '2021-03-05 02:53:24', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(81, 1, 22, 2000000, 'Donasi Wakaf Tanah', '2021-08-02', '2021-08-02 13:32:46', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(82, 2, 12, 750000, 'Belanja Dapur Mingguan', '2021-08-02', '2021-08-02 13:33:18', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(83, 1, 1, 10000000, '20000', '2022-01-02', '2022-01-02 14:20:11', 1, 1, NULL, '2022-01-14 07:01:47', 0),
(84, 1, 1, 10000, ' penjualan unit', '2022-01-03', '2022-01-03 15:47:42', 1, 1, NULL, '2022-01-14 07:01:47', 0);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keuangan_kategori_induk`
--

CREATE TABLE `laporan_keuangan_kategori_induk` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `laporan_keuangan_kategori_induk`
--

INSERT INTO `laporan_keuangan_kategori_induk` (`id`, `nama_kategori`, `user_id`, `action`) VALUES
(1, 'Penjualan', 1, 0),
(2, 'Pembelian', 1, 0),
(3, 'SALDO', 1, 0),
(4, 'Beban-beban', 1, 0),
(5, 'Transaksi Bank', 1, 0),
(6, 'Peralatan', 1, 0),
(7, 'Hutang', 1, 0),
(8, 'Piutang', 1, 0),
(9, 'Transaksi Bank', 1, 0),
(10, 'Donasi Yatim & Dhuafa', 1, 0),
(11, 'Donasi Donatur', 1, 0),
(12, '101 Test', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keuangan_kategori_transaksi`
--

CREATE TABLE `laporan_keuangan_kategori_transaksi` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL,
  `tipe` int(11) DEFAULT NULL COMMENT '1 = Pemasukkan, 2=Pengeluaran',
  `induk` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `laporan_keuangan_kategori_transaksi`
--

INSERT INTO `laporan_keuangan_kategori_transaksi` (`id`, `nama_kategori`, `tipe`, `induk`, `user_id`, `action`) VALUES
(1, 'Penjualan', 1, 1, 1, 0),
(2, 'Pembelian', 2, 2, 1, 0),
(3, 'Saldo Awal', 1, 3, 1, 0),
(4, 'Transport Pengurus', 2, 4, 1, 0),
(5, 'Transport Pengasuh', 2, 4, 1, 0),
(6, 'Transport  Pengajar', 2, 4, 1, 0),
(7, 'Transport Anak Sekolah', 2, 4, 1, 0),
(8, 'Uang Saku Sekolah', 2, 4, 1, 0),
(9, 'Dana Pendidikan', 2, 4, 1, 0),
(10, 'Dana Santunan Luar Panti', 2, 4, 1, 0),
(11, 'Pembelian Barang', 1, 2, 1, 0),
(12, 'Belanja Dapur', 2, 4, 1, 0),
(13, 'Dana Kesehatan', 2, 4, 1, 0),
(14, 'Penjualan Barang', 2, 1, 1, 0),
(15, 'Pembelian Natura', 1, 2, 1, 0),
(16, 'Peralatan', 2, 6, 1, 0),
(17, 'Bayar Hutang', 2, 7, 1, 0),
(18, 'Peneriman Piutang', 1, 8, 1, 0),
(19, 'Dana Operasional', 2, 4, 1, 0),
(20, 'Pemindah bukuan dari Kas Kecil', 1, 3, 1, 0),
(21, 'Pemindah bukuan ke Kas Besar', 2, 3, 1, 0),
(22, 'Donatur', 1, 4, 1, 0),
(23, 'Potongan Piutang', 2, 8, 1, 0),
(24, 'Penjualan Natura', 2, 1, 1, 0),
(25, 'Transaksi  Bank', 2, 5, 1, 0),
(26, 'Pengambilan Dana', 1, 9, 1, 0),
(27, 'Penerimaan Khas Hutang', 1, 7, 1, 0),
(29, 'Donasi Uang / Barang / Natura', 2, 10, 1, 0),
(30, 'Donasi uang', 1, 11, 1, 0),
(31, 'Donasi Barang / Natura', 1, 11, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_keuangan_tipe`
--

CREATE TABLE `laporan_keuangan_tipe` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `warna` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `laporan_keuangan_tipe`
--

INSERT INTO `laporan_keuangan_tipe` (`id`, `nama`, `warna`) VALUES
(1, 'Pemasukan', 'primary'),
(2, 'Pengeluaran', 'danger');

-- --------------------------------------------------------

--
-- Table structure for table `logistik_stok`
--

CREATE TABLE `logistik_stok` (
  `id_stok` int(11) NOT NULL,
  `proyek_material_id` int(11) NOT NULL,
  `logistik_id` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(10) NOT NULL,
  `stok_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logistik_stok`
--

INSERT INTO `logistik_stok` (`id_stok`, `proyek_material_id`, `logistik_id`, `stok`, `created_at`, `type`, `stok_id`) VALUES
(62, 133, 157, 3, '2022-12-29 07:38:28', '0', '0'),
(63, 134, 158, 3, '2022-12-29 07:38:39', '0', '0'),
(64, 133, 159, 6, '2022-12-29 09:09:36', '1', '62'),
(65, 136, 160, 3, '2022-12-29 09:09:46', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mandor_proyek`
--

CREATE TABLE `mandor_proyek` (
  `id_mandor_proyek` int(11) NOT NULL,
  `id_mandor` int(11) NOT NULL,
  `id_proyek_upah` int(11) NOT NULL,
  `id_blok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mandor_proyek`
--

INSERT INTO `mandor_proyek` (`id_mandor_proyek`, `id_mandor`, `id_proyek_upah`, `id_blok`) VALUES
(1, 3, 75, 57),
(3, 3, 66, 46),
(5, 3, 75, 56),
(6, 3, 78, 58);

-- --------------------------------------------------------

--
-- Table structure for table `master_logistik`
--

CREATE TABLE `master_logistik` (
  `id` int(11) NOT NULL,
  `proyek_material_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `material_id` int(11) DEFAULT NULL,
  `jml_pengajuan` varchar(10) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT 'status 1 = approve pengajuan\r\n2 = masuk\r\n3 = Ditolak',
  `detail` int(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modify_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipe` int(1) NOT NULL,
  `time` int(11) NOT NULL,
  `id_proyek` int(11) NOT NULL,
  `stok_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_logistik`
--

INSERT INTO `master_logistik` (`id`, `proyek_material_id`, `kategori_id`, `material_id`, `jml_pengajuan`, `tgl_pengajuan`, `status`, `detail`, `user_id`, `created_at`, `modify_at`, `tipe`, `time`, `id_proyek`, `stok_id`) VALUES
(145, 124, 1, 39, '20', '2022-12-23', 0, 0, 1, '2022-12-23 01:49:08', '2022-12-23 06:55:09', 1, 1671760148, 113, 0),
(146, 123, 2, 16, '5', '2022-12-23', 0, 0, 1, '2022-12-23 01:49:08', '2022-12-23 06:55:16', 1, 1671760148, 113, 0),
(149, 124, 1, 39, '1', '2022-12-23', 0, 0, 1, '2022-12-23 06:33:50', '2022-12-23 06:55:35', 2, 1671777230, 109, 0),
(150, 104, 1, 36, '5', '2022-12-23', 0, 0, 1, '2022-12-23 06:33:50', '2022-12-23 06:55:41', 1, 1671777230, 109, 0),
(151, 127, 1, 36, '10', '2022-12-24', 0, 0, 1, '2022-12-24 01:55:29', '2022-12-24 01:55:29', 1, 1671846929, 0, 0),
(152, 128, 1, 39, '3', '2022-12-24', 0, 0, 1, '2022-12-24 01:55:29', '2022-12-24 01:55:29', 1, 1671846929, 0, 0),
(153, 129, 2, 16, '5', '2022-12-24', 0, 0, 1, '2022-12-24 01:55:29', '2022-12-24 01:55:29', 1, 1671846929, 0, 0),
(154, 130, 1, 37, '20', '2022-12-29', 0, 0, 1, '2022-12-29 02:52:00', '2022-12-29 02:52:00', 1, 1672282320, 115, 0),
(155, 132, 1, 39, '3', '2022-12-29', 0, 0, 1, '2022-12-29 02:52:00', '2022-12-29 02:52:00', 1, 1672282320, 115, 0),
(156, 131, 2, 19, '7', '2022-12-29', 0, 0, 1, '2022-12-29 02:52:00', '2022-12-29 02:52:00', 1, 1672282320, 115, 0),
(157, 133, 1, 36, '20', '2022-12-29', 0, 0, 1, '2022-12-29 07:34:27', '2022-12-29 07:34:27', 1, 1672299267, 119, 0),
(158, 134, 2, 15, '3', '2022-12-29', 0, 0, 1, '2022-12-29 07:34:27', '2022-12-29 07:34:27', 1, 1672299267, 119, 0),
(159, 133, 1, 36, '10', '2022-12-29', 0, 0, 1, '2022-12-29 09:07:45', '2022-12-29 09:07:45', 2, 1672304865, 120, 62),
(160, 136, 2, 19, '3', '2022-12-29', 0, 0, 1, '2022-12-29 09:07:45', '2022-12-29 09:07:45', 1, 1672304865, 120, 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_logistik_detail`
--

CREATE TABLE `master_logistik_detail` (
  `id_logistik_detail` int(11) NOT NULL,
  `logistik_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `harga_real` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL,
  `tgl_mcm` date DEFAULT NULL,
  `pembayaran` varchar(100) NOT NULL,
  `bukti_pembayaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_logistik_detail`
--

INSERT INTO `master_logistik_detail` (`id_logistik_detail`, `logistik_id`, `supplier_id`, `harga_real`, `created_at`, `status`, `title_kode`, `tgl_approve`, `tgl_mcm`, `pembayaran`, `bukti_pembayaran`) VALUES
(59, 145, 0, 300000, '2022-12-23 01:51:51', 0, 0, NULL, NULL, '', ''),
(60, 146, 0, 100000, '2022-12-23 01:51:51', 0, 0, NULL, NULL, '', ''),
(67, 149, 0, 0, '2022-12-23 06:34:49', 0, 0, NULL, NULL, '', ''),
(68, 150, 0, 230000, '2022-12-23 06:34:49', 0, 0, NULL, NULL, '', ''),
(69, 151, 0, 100000, '2022-12-24 01:56:37', 0, 0, NULL, NULL, '', ''),
(70, 152, 0, 105000, '2022-12-24 01:56:37', 0, 0, NULL, NULL, '', ''),
(71, 153, 0, 55000, '2022-12-24 01:56:37', 0, 0, NULL, NULL, '', ''),
(72, 154, 0, 85000, '2022-12-29 02:53:17', 0, 0, NULL, NULL, '', ''),
(73, 155, 0, 110000, '2022-12-29 02:53:17', 0, 0, NULL, NULL, '', ''),
(74, 156, 0, 40000, '2022-12-29 02:53:17', 0, 0, NULL, NULL, '', ''),
(75, 157, 0, 21000, '2022-12-29 07:35:37', 0, 0, NULL, NULL, '', ''),
(76, 158, 0, 45000, '2022-12-29 07:35:37', 0, 0, NULL, NULL, '', ''),
(77, 159, 0, 0, '2022-12-29 09:08:18', 0, 0, NULL, NULL, '', ''),
(78, 160, 0, 45000, '2022-12-29 09:08:18', 0, 0, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `master_logistik_keluar`
--

CREATE TABLE `master_logistik_keluar` (
  `id` bigint(11) NOT NULL,
  `proyek_material_id` int(11) NOT NULL,
  `logistik_id` int(11) NOT NULL,
  `material_keluar` int(20) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `kavling` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_logistik_keluar`
--

INSERT INTO `master_logistik_keluar` (`id`, `proyek_material_id`, `logistik_id`, `material_keluar`, `tgl_keluar`, `created_at`, `user_id`, `kavling`) VALUES
(67, 124, 145, 5, '2022-12-23', '2022-12-23 02:05:25', 1, 56),
(68, 123, 146, 2, '2022-12-23', '2022-12-23 02:07:15', 1, 56),
(69, 124, 149, 1, '2022-12-23', '2022-12-23 06:58:55', 1, 56),
(70, 133, 157, 7, '2022-12-29', '2022-12-29 07:41:11', 1, 59),
(71, 133, 159, 4, '2022-12-29', '2022-12-29 09:20:45', 1, 59);

-- --------------------------------------------------------

--
-- Table structure for table `master_logistik_masuk`
--

CREATE TABLE `master_logistik_masuk` (
  `id` int(11) NOT NULL,
  `proyek_material_id` int(11) NOT NULL,
  `logistik_id` int(11) NOT NULL,
  `material_masuk` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `dokumentasi` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_logistik_masuk`
--

INSERT INTO `master_logistik_masuk` (`id`, `proyek_material_id`, `logistik_id`, `material_masuk`, `tgl_masuk`, `created_at`, `dokumentasi`) VALUES
(64, 124, 145, 20, '2022-12-23', '2022-12-23', 'logo_fix_SD_5.png'),
(65, 123, 146, 5, '2022-12-23', '2022-12-23', 'Capture221212122.PNG'),
(68, 124, 149, 1, '2022-12-23', '2022-12-23', 'Capture221212123.PNG'),
(69, 104, 150, 5, '2022-12-23', '2022-12-23', 'Capture221212124.PNG'),
(70, 127, 151, 10, '2022-12-24', '2022-12-24', 'Capture.PNG'),
(71, 128, 152, 3, '2022-12-24', '2022-12-24', 'Capture221212125.PNG'),
(72, 129, 153, 5, '2022-12-24', '2022-12-24', 'Capture221212126.PNG'),
(73, 133, 157, 20, '2022-12-29', '2022-12-29', 'Screenshot_(1)1.png'),
(74, 134, 158, 3, '2022-12-29', '2022-12-29', 'Screenshot_(1)2.png'),
(75, 133, 159, 10, '2022-12-29', '2022-12-29', 'Screenshot_(1)3.png'),
(76, 136, 160, 3, '2022-12-29', '2022-12-29', 'Screenshot_(1)4.png');

-- --------------------------------------------------------

--
-- Table structure for table `master_mandor`
--

CREATE TABLE `master_mandor` (
  `id_mandor` int(11) NOT NULL,
  `nama_mandor` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `no_rekening` varchar(20) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `nama_bank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_mandor`
--

INSERT INTO `master_mandor` (`id_mandor`, `nama_mandor`, `no_telp`, `no_rekening`, `atas_nama`, `nama_bank`) VALUES
(2, 'Gremmy Washhalm', '081234678092', '23310097254', 'Gremmy Washhalm', 'BNI'),
(3, 'Basc Marx', '089772663441', '0992773415662', 'Basc Marx', 'BCA');

-- --------------------------------------------------------

--
-- Table structure for table `master_material`
--

CREATE TABLE `master_material` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `nama_material` varchar(225) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_material`
--

INSERT INTO `master_material` (`id`, `kategori_id`, `unit_id`, `nama_material`, `user_id`, `created_at`) VALUES
(15, 2, 13, 'Besi 6', 1, '2022-05-31 09:19:31'),
(16, 2, 13, 'Besi 8', 1, '2022-05-31 09:20:01'),
(17, 2, 13, 'Kawat Beton', 1, '2022-05-31 09:20:20'),
(18, 2, 12, 'Paku Reng', 1, '2022-05-31 09:21:05'),
(19, 2, 12, 'Paku Usuk', 1, '2022-05-31 09:21:22'),
(20, 2, 12, 'Paku Plafond', 1, '2022-05-31 09:21:36'),
(21, 2, 12, 'Paku Kalsibort', 1, '2022-05-31 09:21:48'),
(22, 4, 11, 'Kayu 4X6 3M', 1, '2022-05-31 09:22:13'),
(23, 4, 11, 'Kayu 4X7 3M', 1, '2022-05-31 09:22:30'),
(24, 4, 11, 'Sirap 0.2 x 3 m', 1, '2022-05-31 09:22:40'),
(25, 4, 11, 'Bambu', 1, '2022-05-31 09:22:53'),
(26, 4, 11, 'Triplek Cor', 1, '2022-05-31 09:23:04'),
(27, 5, 3, 'Keramik 20x20', 1, '2022-05-31 09:23:36'),
(28, 5, 3, 'Keramik 20x25', 1, '2022-05-31 09:23:49'),
(29, 5, 3, 'Keramik 30x30', 1, '2022-05-31 09:23:58'),
(30, 3, 1, 'Semen', 1, '2022-05-31 09:24:46'),
(31, 3, 1, 'PC Warna/Nut', 1, '2022-05-31 09:25:28'),
(32, 3, 3, 'Kapur', 1, '2022-05-31 09:25:42'),
(33, 3, 3, 'Mild', 1, '2022-05-31 09:25:53'),
(34, 3, 1, 'Kalsium', 1, '2022-05-31 09:26:08'),
(35, 3, 12, 'Lem Rajawali', 1, '2022-05-31 09:26:25'),
(36, 1, 21, 'Batu Belah', 1, '2022-05-31 09:26:57'),
(37, 1, 1, 'Pasir Pasang', 1, '2022-05-31 09:27:12'),
(38, 1, 4, 'Tanah Urug', 1, '2022-05-31 09:27:26'),
(39, 1, 4, 'Bata Merah', 1, '2022-05-31 09:29:55'),
(40, 1, 4, 'Buis Beton UD-20', 1, '2022-05-31 09:30:06'),
(41, 1, 4, 'Buis Beton D-40', 1, '2022-05-31 09:30:24'),
(42, 1, 4, 'Buis Beton D-80 ', 1, '2022-05-31 09:30:44'),
(43, 1, 4, 'Tutup D-80', 1, '2022-05-31 09:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `master_produk`
--

CREATE TABLE `master_produk` (
  `id` int(11) NOT NULL,
  `barcode` varchar(60) NOT NULL DEFAULT '',
  `nama_produk` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `harga` int(11) DEFAULT 0,
  `stok` int(11) NOT NULL,
  `status` int(11) DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `tanggal` date DEFAULT NULL,
  `tanggal_update` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `master_produk`
--

INSERT INTO `master_produk` (`id`, `barcode`, `nama_produk`, `kategori_id`, `unit_id`, `harga`, `stok`, `status`, `user_id`, `tanggal`, `tanggal_update`, `action`) VALUES
(1, 'A001', 'Semen', 1, 6, 11000, 0, 0, 1, '2021-01-12', '2022-05-31 16:15:12', 0),
(2, 'A002', 'Galvalum 4Meter', 1, 17, 350000, 0, 0, 1, '2021-01-12', '2022-05-31 16:15:18', 0),
(3, 'A003', 'Genteng', 1, 17, 5000, 0, 0, 1, '2021-01-12', '2022-05-31 16:15:26', 0),
(4, 'A004', 'Bata', 1, 17, 500, 0, 0, 1, '2021-01-12', '2022-05-31 16:15:36', 0),
(5, 'A005', 'Pasir', 1, 21, 300000, 0, 0, 1, '2021-01-12', '2022-05-31 16:15:39', 0),
(6, 'M001', 'Sepeda Motor', 1, 17, 5500000, 0, 0, 1, '2021-01-12', '2022-05-31 16:15:43', 1),
(7, 'A006', 'Telor', 1, 6, 23000, 0, 0, 1, '2021-01-15', '2022-01-14 07:01:47', 1),
(8, 'A0010', 'pasir gumuk', 1, 4, 500000, 0, 0, 1, '2022-01-06', '2022-05-31 16:15:47', 0),
(9, 'A0010', 'pasir gumuk', 5, 4, 1000, 0, 0, 1, '2022-01-16', '2022-01-16 05:46:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_produk_kategori`
--

CREATE TABLE `master_produk_kategori` (
  `id` int(11) NOT NULL,
  `kategori_produk` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `action` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `master_produk_kategori`
--

INSERT INTO `master_produk_kategori` (`id`, `kategori_produk`, `tanggal_dibuat`, `user_id`, `action`) VALUES
(1, 'MATERIAL ALAM ', '2022-06-10 10:20:37', 1, 0),
(2, 'BAHAN BESI', '2022-05-31 09:13:53', 1, 0),
(3, 'BAHAN PEREKAT', '2022-05-31 09:14:02', 1, 0),
(4, 'BAHAN KAYU', '2022-05-31 09:14:12', 1, 0),
(5, 'BAHAN LANTAI', '2022-05-31 09:14:20', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_produk_unit`
--

CREATE TABLE `master_produk_unit` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `action` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `master_produk_unit`
--

INSERT INTO `master_produk_unit` (`id`, `nama_satuan`, `tanggal_dibuat`, `user_id`, `action`) VALUES
(1, 'SAK', '2022-01-14 07:01:48', 1, 0),
(2, 'BTG', '2022-06-10 10:54:32', 1, 0),
(3, 'DUS', '2022-01-14 07:01:48', 1, 0),
(4, 'PICKUP', '2022-01-14 07:01:48', 1, 0),
(5, 'Kaleng', '2022-06-10 10:54:09', 1, 0),
(6, 'KG', '2022-01-14 07:01:48', 1, 0),
(7, 'KLG', '2022-06-10 11:15:18', 1, 0),
(9, 'Kotak', '2022-06-10 10:54:17', 1, 0),
(10, 'LSN', '2022-06-10 10:54:20', 1, 0),
(11, 'Meter', '2022-06-10 11:09:10', 1, 0),
(12, 'PAK', '2022-01-14 07:01:48', 1, 0),
(13, 'Pcs', '2022-01-14 07:01:48', 1, 0),
(14, 'ROL', '2022-06-10 10:54:25', 1, 0),
(15, 'Roll', '2022-04-03 06:52:12', 1, 0),
(16, 'SET', '2022-06-10 10:54:28', 1, 0),
(17, 'UNIT', '2022-06-10 11:15:11', 1, 0),
(19, 'Liter', '2022-06-10 11:51:55', 1, 0),
(20, 'Orang', '2022-01-14 07:01:48', 1, 0),
(21, 'Paket', '2022-01-14 07:01:48', 1, 0),
(22, 'Bungkus', '2022-01-14 07:01:48', 1, 0),
(23, 'sd', '2022-06-10 11:52:15', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_proyek`
--

CREATE TABLE `master_proyek` (
  `id` int(11) NOT NULL,
  `nama_proyek` varchar(225) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `approve` int(1) NOT NULL DEFAULT 0,
  `rab` int(11) NOT NULL DEFAULT 0,
  `print` int(1) NOT NULL DEFAULT 0,
  `end` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_proyek`
--

INSERT INTO `master_proyek` (`id`, `nama_proyek`, `user_id`, `tgl_pengajuan`, `approve`, `rab`, `print`, `end`, `created_at`) VALUES
(109, 'Pro2', 1, '2022-08-10', 1, 1, 0, 0, '2022-08-10 01:56:47'),
(110, 'Pro2.5', 1, '2022-08-10', 1, 1, 0, 0, '2022-08-10 06:20:17'),
(111, 'Proyek Calibre', 1, '2022-09-05', 1, 1, 0, 0, '2022-09-05 01:48:02'),
(112, 'Gulag Techno Redbull', 1, '2022-09-23', 1, 1, 0, 0, '2022-09-22 19:23:34'),
(113, 'ProOne', 1, '2022-11-24', 3, 1, 0, 1, '2022-11-24 06:12:15'),
(114, 'Pro1', 1, '2022-12-24', 1, 1, 0, 0, '2022-12-24 01:48:06'),
(115, 'ProMax', 1, '2022-12-29', 3, 1, 0, 1, '2022-12-29 02:40:03'),
(119, 'Big Proyek', 1, '2022-12-29', 3, 1, 0, 1, '2022-12-29 06:36:45'),
(120, 'BigBang', 1, '2022-12-29', 1, 1, 0, 0, '2022-12-29 07:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `master_proyek_kavling`
--

CREATE TABLE `master_proyek_kavling` (
  `id` int(11) NOT NULL,
  `proyek_id` int(11) NOT NULL,
  `kavling_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_proyek_kavling`
--

INSERT INTO `master_proyek_kavling` (`id`, `proyek_id`, `kavling_id`, `user_id`, `created_at`) VALUES
(190, 109, 46, 1, '2022-08-10 01:56:48'),
(191, 109, 47, 1, '2022-08-10 01:56:48'),
(192, 109, 43, 1, '2022-08-10 01:56:48'),
(193, 109, 45, 1, '2022-08-10 01:56:48'),
(194, 110, 48, 1, '2022-08-10 06:20:17'),
(195, 110, 44, 1, '2022-08-10 06:20:17'),
(196, 111, 50, 1, '2022-09-05 01:48:02'),
(197, 111, 51, 1, '2022-09-05 01:48:02'),
(198, 111, 52, 1, '2022-09-05 01:48:03'),
(199, 111, 53, 1, '2022-09-05 01:48:03'),
(200, 112, 49, 1, '2022-09-22 19:23:34'),
(203, 114, 54, 1, '2022-12-24 01:48:06'),
(208, 119, 59, 1, '2022-12-29 06:36:45'),
(209, 120, 60, 1, '2022-12-29 07:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `master_supplier`
--

CREATE TABLE `master_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `nama_toko` varchar(225) NOT NULL,
  `no_tlp` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_bank` varchar(100) NOT NULL,
  `atas_nama` varchar(100) NOT NULL,
  `no_rek` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_supplier`
--

INSERT INTO `master_supplier` (`id_supplier`, `nama`, `alamat`, `nama_toko`, `no_tlp`, `created_at`, `nama_bank`, `atas_nama`, `no_rek`) VALUES
(2, 'Kevin Sanjaya', 'Jember', 'Kevin Jaya', '081223819029', '2022-06-19 16:15:50', 'BRI', 'Lisa azkhlim', '990852437729'),
(3, 'Licht Ravens', 'Jl. Emperor ', 'Handal Building', '089226371890', '2022-11-28 07:40:20', 'BNI', 'Licht Fognar', '00928172635471');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `type` int(1) NOT NULL,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `icon`, `url`, `type`, `parent`) VALUES
(1, 'Dashboard', 'nav-icon fas fa-tachometer-alt', 'dashboard/', 0, 0),
(2, 'Marketing / Admin', 'nav-icon fas fa-file-alt', '#', 1, 0),
(3, 'Management Proyek', 'nav-icon fa fa-briefcase', '#', 1, 0),
(4, 'Management Logistik', 'nav-icon fa fa-industry', '#', 1, 0),
(5, 'Management Keuangan', 'nav-icon fas fa-dollar-sign', '#', 1, 0),
(6, 'Admin KPR', 'nav-icon fas fa-user', '#', 1, 0),
(7, 'Menu Lain-Lain', 'nav-icon fas fa-stream', '#', 1, 0),
(8, 'Management Master', 'nav-icon fas fa-star', '#', 1, 0),
(9, 'Calon Konsumen', 'far fa-circle nav-icon', 'marketing/data_konsumen', 3, 2),
(10, 'Transaksi Bank', 'far fa-circle nav-icon', 'marketing/transaksi_bank', 3, 2),
(11, 'Transaksi Inhouse', 'far fa-circle nav-icon', 'marketing/transaksi_inhouse', 3, 2),
(12, 'Konsumen', 'far fa-circle nav-icon', 'marketing/konsumen', 3, 2),
(13, 'Pembatalan Transaksi', 'far fa-circle nav-icon', 'marketing/transaksi_batal', 3, 2),
(14, 'Ajukan Proyek', 'far fa-circle nav-icon', 'proyek/ajukan_proyek', 3, 3),
(15, 'RAB', 'far fa-circle nav-icon', 'proyek/rab', 3, 3),
(16, 'Pengajuan Material', 'far fa-circle nav-icon', 'proyek/pengajuan_material', 3, 3),
(17, 'Progres Pembangunan', 'far fa-circle nav-icon', 'proyek/progres', 3, 3),
(18, 'Pekerjaan Insidentil', 'far fa-circle nav-icon', 'proyek/pekerjaan_insidentil', 3, 3),
(19, 'Ajukan Material', 'far fa-circle nav-icon', 'logistik/ajukan_material', 3, 4),
(20, 'Material Masuk', 'far fa-circle nav-icon', 'logistik/material_masuk', 3, 4),
(21, 'Material Keluar', 'far fa-circle nav-icon', 'logistik/material_keluar', 3, 4),
(22, 'Rekap Stok Material', 'far fa-circle nav-icon', 'logistik/rekap_stok_material', 3, 4),
(23, 'Pemasukan', 'far fa-dot-circle nav-icon', '#', 2, 5),
(24, 'Pengeluaran', 'far fa-dot-circle nav-icon', '#', 2, 5),
(25, 'Laporan', 'far fa-dot-circle nav-icon', '#', 2, 5),
(26, 'Transaksi Bank', 'far fa-circle nav-icon', 'accounting/bank', 3, 23),
(27, 'Transaksi Inhouse', 'far fa-circle nav-icon', 'accounting/inhouse', 3, 23),
(28, 'Lainnya', 'far fa-circle nav-icon', 'accounting/pemasukan_lain', 3, 23),
(29, 'Marketing', 'nav-icon far fa-circle text-info', '#', 4, 24),
(30, 'Proyek', 'nav-icon far fa-circle text-info', '#', 4, 24),
(31, 'Lain-lain', 'nav-icon far fa-circle text-info', '#', 4, 24),
(32, 'Fee Marketing', 'far fa-circle nav-icon', 'accounting/fee_marketing', 3, 29),
(33, 'Pembatalan Transaksi', 'far fa-circle nav-icon', 'accounting/pembatalan_transaksi', 3, 29),
(34, 'Upah Kerja', 'far fa-circle nav-icon', 'accounting/pembangunan', 3, 30),
(35, 'Pengajuan Material', 'far fa-circle nav-icon', 'accounting/pengajuan_material', 3, 30),
(36, 'Pekerjaan Insidentil', 'far fa-circle nav-icon', 'accounting/insidentil', 3, 30),
(37, 'Kas Operasional', 'far fa-circle nav-icon', 'accounting/kas_operasional', 3, 31),
(38, 'Pembebasan Lahan', 'far fa-circle nav-icon', 'accounting/pembebasan_lahan', 3, 31),
(39, 'Lainnya', 'far fa-circle nav-icon', 'accounting/pengeluaran_lain', 3, 31),
(40, 'Laporan Bulanan', 'far fa-circle nav-icon', 'accounting/laporan', 3, 25),
(41, 'Laporan Arus Kas', 'far fa-circle nav-icon', 'accounting/laporan_kas', 3, 25),
(42, 'Data Konsumen', 'far fa-circle nav-icon', 'kpr/konsumen', 3, 6),
(43, 'Rekening Bank', 'far fa-circle nav-icon', 'kpr/rek_bank', 3, 6),
(44, 'Berkas Konsumen', 'far fa-circle nav-icon', 'kpr/berkas_konsumen', 3, 6),
(45, 'Pembebasan Lahan', 'far fa-circle nav-icon', 'other/pembebasan_lahan/', 3, 7),
(46, 'Pengeluaran Lain', 'far fa-circle nav-icon', 'other/pengeluaran_lain/', 3, 7),
(47, 'Master Kavling', 'far fa-circle nav-icon', 'master/kavling/', 3, 8),
(48, 'Master Tipe', 'far fa-circle nav-icon', 'master/tipe', 3, 8),
(49, 'Master Cluster', 'far fa-circle nav-icon', 'master/cluster/', 3, 8),
(50, 'Master Material', 'far fa-circle nav-icon', 'master/material/', 3, 8),
(51, 'Master Jenis Material', 'far fa-circle nav-icon', 'master/jenis_material/', 3, 8),
(52, 'Master Satuan Unit', 'far fa-circle nav-icon', 'master/unit/', 3, 8),
(53, 'Master Supplier', 'far fa-circle nav-icon', 'master/supplier/', 3, 8),
(54, 'Master Mandor', 'far fa-circle nav-icon', 'master/mandor/', 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `menu_access`
--

CREATE TABLE `menu_access` (
  `id_access` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_access`
--

INSERT INTO `menu_access` (`id_access`, `id_group`, `id_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 1, 34),
(35, 1, 35),
(36, 1, 36),
(37, 1, 37),
(38, 1, 38),
(39, 1, 39),
(40, 1, 40),
(41, 1, 41),
(42, 1, 42),
(43, 1, 43),
(44, 1, 44),
(45, 1, 45),
(46, 1, 46),
(47, 1, 47),
(48, 1, 48),
(49, 1, 49),
(50, 1, 50),
(51, 1, 51),
(52, 1, 52),
(53, 1, 53),
(54, 2, 1),
(55, 2, 2),
(56, 2, 3),
(57, 2, 4),
(58, 2, 5),
(59, 2, 6),
(60, 2, 7),
(61, 2, 8),
(62, 2, 9),
(63, 2, 10),
(64, 2, 11),
(65, 2, 12),
(66, 2, 13),
(67, 2, 14),
(68, 2, 15),
(69, 2, 16),
(70, 2, 17),
(71, 2, 18),
(72, 2, 19),
(73, 2, 20),
(74, 2, 21),
(75, 2, 22),
(76, 2, 23),
(77, 2, 24),
(78, 2, 25),
(79, 2, 26),
(80, 2, 27),
(81, 2, 28),
(82, 2, 29),
(83, 2, 30),
(84, 2, 31),
(85, 2, 32),
(86, 2, 33),
(87, 2, 34),
(88, 2, 35),
(89, 2, 36),
(90, 2, 37),
(91, 2, 38),
(92, 2, 39),
(93, 2, 40),
(94, 2, 41),
(95, 2, 42),
(96, 2, 43),
(97, 2, 44),
(98, 2, 45),
(99, 2, 46),
(100, 2, 47),
(101, 2, 48),
(102, 2, 49),
(103, 2, 50),
(104, 2, 51),
(105, 2, 52),
(106, 2, 53),
(107, 3, 1),
(108, 3, 5),
(109, 3, 23),
(110, 3, 24),
(111, 3, 25),
(112, 3, 26),
(113, 3, 27),
(114, 3, 28),
(115, 3, 29),
(116, 3, 30),
(117, 3, 31),
(118, 3, 32),
(119, 3, 33),
(120, 3, 34),
(121, 3, 35),
(122, 3, 36),
(123, 3, 37),
(124, 3, 38),
(125, 3, 39),
(126, 3, 40),
(127, 3, 41),
(128, 4, 1),
(129, 4, 2),
(130, 4, 9),
(131, 4, 10),
(132, 4, 11),
(133, 4, 12),
(134, 4, 13),
(135, 5, 1),
(136, 5, 4),
(137, 5, 19),
(138, 5, 20),
(139, 5, 21),
(140, 5, 22),
(141, 6, 1),
(142, 6, 3),
(143, 6, 14),
(144, 6, 15),
(145, 6, 16),
(146, 6, 17),
(147, 6, 18),
(148, 7, 1),
(149, 7, 5),
(150, 7, 23),
(151, 7, 26),
(152, 7, 27),
(153, 7, 28),
(154, 1, 54);

-- --------------------------------------------------------

--
-- Table structure for table `nota_material`
--

CREATE TABLE `nota_material` (
  `id_nota` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `nota` varchar(200) NOT NULL,
  `tgl_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nota_material`
--

INSERT INTO `nota_material` (`id_nota`, `id_pengajuan`, `nota`, `tgl_upload`) VALUES
(1, 1, 'Screenshot_(3).png', '2022-12-02'),
(2, 1, 'Screenshot_(3)1.png', '2022-12-06'),
(3, 3, 'default-image.jpg', '2022-12-09'),
(4, 7, 'bg_login19.jpg', '2022-12-23'),
(5, 9, 'Capture.PNG', '2022-12-23'),
(6, 10, 'Capture1.PNG', '2022-12-24'),
(7, 11, 'Screenshot_(1)1.png', '2022-12-29'),
(8, 12, 'Screenshot_(1)2.png', '2022-12-29'),
(9, 13, 'Screenshot_(1)3.png', '2022-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `pak`
--

CREATE TABLE `pak` (
  `id_pak` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_pak` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(10) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pak`
--

INSERT INTO `pak` (`id_pak`, `id_konsumen`, `jml_pak`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(34, 46, '450000', '5', '90000', '1', 1, '2022-10-01', '2022-09-08', '0', 8, 1),
(35, 46, '450000', '5', '90000', '1', 0, '2022-11-01', '', '', 0, 1),
(36, 46, '450000', '5', '90000', '1', 0, '2022-12-01', '', '', 0, 1),
(37, 46, '450000', '5', '90000', '1', 0, '2023-01-01', '', '', 0, 1),
(38, 46, '450000', '5', '90000', '1', 0, '2023-02-01', '', '', 0, 1),
(39, 50, '450000', '3', '150000', '2', 0, '2022-10-02', '', '', 0, 0),
(40, 50, '450000', '3', '150000', '2', 0, '2022-11-02', '', '', 0, 0),
(41, 50, '450000', '3', '150000', '2', 0, '2022-12-02', '', '', 0, 0),
(42, 58, '800000', '5', '160000', '5', 1, '2023-01-05', '', '0', 8, 1),
(43, 58, '800000', '5', '160000', '5', 0, '2023-02-05', '', '0', 0, 1),
(44, 58, '800000', '5', '160000', '5', 0, '2023-03-05', '', '0', 0, 1),
(45, 58, '800000', '5', '160000', '5', 0, '2023-04-05', '', '0', 0, 1),
(46, 58, '800000', '5', '160000', '5', 0, '2023-05-05', '', '0', 0, 1),
(47, 59, '250000', '2', '125000', '4', 1, '2023-01-04', '', '0', 8, 1),
(48, 59, '250000', '2', '125000', '4', 0, '2023-02-04', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan_lain`
--

CREATE TABLE `pemasukan_lain` (
  `id_pemasukan` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `jumlah` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `bukti` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemasukan_lain`
--

INSERT INTO `pemasukan_lain` (`id_pemasukan`, `keterangan`, `jumlah`, `tanggal`, `bukti`, `status`, `title_kode`, `id_perumahan`) VALUES
(8, 'pak echo', '200000', '2022-12-22', 'avatar10.png', 2, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembatalan_transaksi`
--

CREATE TABLE `pembatalan_transaksi` (
  `id_pembatalan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `tgl_pembatalan` date NOT NULL,
  `total_pengembalian` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembatalan_transaksi`
--

INSERT INTO `pembatalan_transaksi` (`id_pembatalan`, `id_user`, `status`, `tgl_pembatalan`, `total_pengembalian`, `title_kode`) VALUES
(4, 46, 1, '2022-10-20', '91590000', 16),
(5, 47, 2, '2022-10-21', '90600000', 19),
(8, 58, 1, '2022-12-28', '300000', 0),
(9, 57, 1, '2022-12-28', '4124000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembebasan_lahan`
--

CREATE TABLE `pembebasan_lahan` (
  `id_pembebasan` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL,
  `nama_penjual` varchar(100) NOT NULL,
  `no_surat` varchar(100) NOT NULL,
  `jenis_surat` varchar(100) NOT NULL,
  `tgl_pengalihan` date NOT NULL,
  `total_pembelian` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembebasan_lahan`
--

INSERT INTO `pembebasan_lahan` (`id_pembebasan`, `id_perumahan`, `nama_penjual`, `no_surat`, `jenis_surat`, `tgl_pengalihan`, `total_pembelian`, `title_kode`, `status`) VALUES
(10, 1, 'Gims Ulrick', '0092764312', 'Girik', '2022-12-14', '20000000', 14, 2),
(11, 1, 'Ariel Noah', '9928735412', 'AJB', '2022-12-15', '5000000', 14, 2),
(12, 1, 'qwqwqw', '9928735412', 'HGB', '2022-12-16', '10000000', 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_material`
--

CREATE TABLE `pengajuan_material` (
  `id_pengajuan` int(11) NOT NULL,
  `id_proyek` int(11) NOT NULL,
  `id_tipe` int(11) NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status_pengajuan` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL,
  `title_kode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengajuan_material`
--

INSERT INTO `pengajuan_material` (`id_pengajuan`, `id_proyek`, `id_tipe`, `tgl_pengajuan`, `status_pengajuan`, `time`, `supplier`, `id_perumahan`, `title_kode`) VALUES
(7, 113, 1, '2022-12-23', 4, 1671760148, 3, 1, 20),
(8, 109, 1, '2022-12-23', 4, 1671762932, 3, 1, 20),
(9, 109, 1, '2022-12-23', 4, 1671777230, 3, 1, 20),
(10, 114, 3, '2022-12-24', 4, 1671846929, 3, 1, 20),
(11, 115, 1, '2022-12-29', 4, 1672282320, 2, 1, 20),
(12, 119, 1, '2022-12-29', 4, 1672299267, 3, 1, 20),
(13, 120, 1, '2022-12-29', 4, 1672304865, 3, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_lain`
--

CREATE TABLE `pengeluaran_lain` (
  `id_pengeluaran` int(11) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `jml_pengeluaran` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengeluaran_lain`
--

INSERT INTO `pengeluaran_lain` (`id_pengeluaran`, `tgl_pengeluaran`, `jml_pengeluaran`, `keterangan`, `status`, `title_kode`, `tgl_approve`, `id_perumahan`) VALUES
(14, '2022-09-08', '20000', 'wqrety', 1, 0, NULL, 2),
(15, '2022-12-14', '300000000', 'yakob\r\n', 2, 15, '2022-12-14', 1),
(16, '2022-12-15', '2300000', 'qweopo', 2, 15, '2022-12-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `piutang_bank`
--

CREATE TABLE `piutang_bank` (
  `id_piutang` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_piutang` varchar(100) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(100) NOT NULL,
  `tgl_bayar` varchar(2) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `denda` varchar(20) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `piutang_bank`
--

INSERT INTO `piutang_bank` (`id_piutang`, `id_konsumen`, `jml_piutang`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(42, 50, '100000', '2', '50000', '5', 1, '2022-10-05', '2022-09-21', '0', 22, 0),
(43, 50, '100000', '2', '50000', '5', 0, '2022-11-05', '0000-00-00', '', 0, 0),
(44, 51, '1200000', '4', '300000', '3', 3, '2022-11-04', '2022-11-26', '33000', 22, 1),
(45, 51, '1200000', '4', '300000', '3', 0, '2022-12-04', '0000-00-00', '', 0, 1),
(46, 51, '1200000', '4', '300000', '3', 0, '2023-01-04', '0000-00-00', '', 0, 1),
(47, 51, '1200000', '4', '300000', '3', 0, '2023-02-04', '0000-00-00', '', 0, 1),
(48, 58, '500000', '5', '100000', '5', 1, '2023-01-05', '0000-00-00', '0', 22, 1),
(49, 58, '500000', '5', '100000', '5', 0, '2023-02-05', '0000-00-00', '0', 0, 1),
(50, 58, '500000', '5', '100000', '5', 0, '2023-03-05', '0000-00-00', '0', 0, 1),
(51, 58, '500000', '5', '100000', '5', 0, '2023-04-05', '0000-00-00', '0', 0, 1),
(52, 58, '500000', '5', '100000', '5', 0, '2023-05-05', '0000-00-00', '0', 0, 1),
(53, 59, '720000', '3', '240000', '4', 1, '2023-01-03', '0000-00-00', '0', 22, 1),
(54, 59, '720000', '3', '240000', '4', 0, '2023-02-03', '0000-00-00', '0', 0, 1),
(55, 59, '720000', '3', '240000', '4', 0, '2023-03-03', '0000-00-00', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `progres_pembangunan`
--

CREATE TABLE `progres_pembangunan` (
  `id_progres` int(11) NOT NULL,
  `upah_id` int(11) NOT NULL,
  `kavling_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `progres` varchar(4) NOT NULL,
  `total` varchar(20) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `status` int(2) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progres_pembangunan`
--

INSERT INTO `progres_pembangunan` (`id_progres`, `upah_id`, `kavling_id`, `tanggal`, `progres`, `total`, `foto`, `status`, `title_kode`, `tgl_approve`) VALUES
(54, 66, 46, '2022-08-23', '3', '500000', 'bg_login10.jpg', 4, 4, '2022-09-02'),
(55, 66, 47, '2022-08-23', '5', '640000', 'g14.png', 4, 4, '2022-09-02'),
(56, 67, 43, '2022-08-23', '6', '780000', 'icon2.png', 4, 4, '2022-09-08'),
(57, 67, 45, '2022-08-23', '5', '500000', 'logo22.jpg', 4, 17, '2022-11-22'),
(58, 66, 46, '2022-09-02', '10', '500000', 'icon3.png', 4, 17, '2022-11-25'),
(60, 66, 46, '2022-11-30', '9', '2500000', 'Screenshot_(2).png', 3, 15, '2022-12-16'),
(61, 75, 56, '2022-12-14', '5', '1500000', 'default-image.jpg', 3, 4, '2022-12-14'),
(64, 75, 56, '2022-12-16', '10', '2000000', 'bg_login12.jpg', 3, 4, '2022-12-16'),
(65, 78, 58, '2022-12-29', '10', '2000000', 'Screenshot_(1)1.png', 3, 4, '2022-12-29'),
(66, 78, 58, '2022-12-29', '30', '4000000', 'Screenshot_(1)2.png', 3, 4, '2022-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `rab_detail`
--

CREATE TABLE `rab_detail` (
  `id` int(11) NOT NULL,
  `rab_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL COMMENT '1 = induk, 0 = parent',
  `parent` int(11) DEFAULT NULL COMMENT 'ambil dari id yang level nya 1, jika level 1 maka paren nya = 999',
  `deskripsi` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 4 COMMENT '1 = progres, 2, = cancel, 3 = delete, 4 = template, 5 = finish',
  `action` int(11) DEFAULT 0 COMMENT '0 = active, 1=non aktive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `rab_detail`
--

INSERT INTO `rab_detail` (`id`, `rab_id`, `level`, `parent`, `deskripsi`, `quantity`, `satuan`, `id_satuan`, `nominal`, `total`, `tanggal`, `user_id`, `status`, `action`) VALUES
(1, 1, 1, 999, 'Material Bangunan', NULL, NULL, NULL, NULL, NULL, '2022-01-16 05:28:32', 1, 3, 1),
(2, 2, 1, 999, 'Material Bangunan', NULL, NULL, NULL, NULL, NULL, '2022-01-16 05:17:39', 1, 1, 0),
(3, 1, 1, 999, 'Upah Pekerja', NULL, NULL, NULL, NULL, NULL, '2022-01-16 05:28:38', 1, 3, 1),
(4, NULL, 0, 1, 'Semen', 2000, 'SAK', 1, 50000, 100000000, '2022-01-16 05:18:45', 1, 3, 1),
(5, NULL, 0, 1, 'Batu Bata', 100000, 'UNIT', 17, 500, 50000000, '2022-01-16 05:28:06', 1, 3, 1),
(6, NULL, 0, 1, 'Genteng', 100000, 'UNIT', 17, 1000, 100000000, '2022-01-16 05:28:12', 1, 3, 1),
(7, NULL, 0, 1, 'Pasir', 20, 'PICKUP', 4, 400000, 8000000, '2022-01-16 05:28:17', 1, 3, 1),
(8, NULL, 0, 1, 'Cat Warna Putih', 20, 'Liter', 19, 20000, 400000, '2022-01-16 05:28:01', 1, 3, 1),
(9, NULL, 0, 3, 'upah 20 perkerja', 20, 'Orang', 20, 100000, 2000000, '2022-01-16 05:28:23', 1, 3, 1),
(58, 16, 1, 999, 'Bahan Material', NULL, NULL, NULL, NULL, NULL, '2022-01-16 05:24:18', 1, 4, 0),
(59, 16, 1, 999, 'Upah Pekerja', NULL, NULL, NULL, NULL, NULL, '2022-01-16 05:24:29', 1, 4, 0),
(60, 16, 0, 58, 'Semen', 1000, 'SAK', 1, 50000, 50000000, '2022-01-16 05:26:22', 1, 5, 0),
(61, 16, 0, 58, 'Batu Bata', 10000, 'UNIT', 17, 500, 5000000, '2022-01-16 05:25:35', 1, 1, 0),
(62, 16, 0, 59, 'upah 20 orang', 10, 'Orang', 20, 100000, 1000000, '2022-01-16 05:26:04', 1, 1, 0),
(63, 18, 1, 999, 'material ', NULL, NULL, NULL, NULL, NULL, '2022-01-16 08:21:07', 1, 4, 0),
(64, 18, 1, 999, 'upah pekerja', NULL, NULL, NULL, NULL, NULL, '2022-01-16 08:21:26', 1, 4, 0),
(65, 19, 1, 999, 'material', NULL, NULL, NULL, NULL, NULL, '2022-01-16 09:01:38', 1, 4, 0),
(66, 19, 1, 999, 'upah', NULL, NULL, NULL, NULL, NULL, '2022-01-16 09:01:47', 1, 4, 0),
(67, 19, 0, 65, 'semen', 100, 'SAK', 1, 50000, 5000000, '2022-01-16 09:05:23', 1, 5, 0),
(68, 19, 0, 65, 'batu bata', 1000, 'UNIT', 17, 500, 500000, '2022-01-16 09:04:39', 1, 1, 0),
(69, 19, 0, 66, 'upah', 1, 'Orang', 20, 100000, 100000, '2022-01-16 09:05:09', 1, 1, 0),
(70, 2, 1, 999, 'Berita', NULL, NULL, NULL, NULL, NULL, '2022-03-29 16:21:23', 1, 3, 1),
(74, 23, 1, 999, 'Material', NULL, NULL, NULL, NULL, NULL, '2022-03-29 17:20:19', 1, 4, 0),
(75, 23, 0, 74, 'Semen', 100, 'SAK', 1, 70000, 7000000, '2022-03-29 17:20:36', 1, 1, 0),
(76, 23, 1, 999, 'Genteng', NULL, NULL, NULL, NULL, NULL, '2022-03-29 17:29:14', 1, 3, 1),
(77, 17, 1, 999, 'Berita', NULL, NULL, NULL, NULL, NULL, '2022-03-31 12:00:51', 1, 4, 0),
(78, 17, 0, 77, 'as', 12, 'Bungkus', 22, 2000, 24000, '2022-03-31 12:01:17', 1, 1, 0),
(79, 1, 1, 999, 'Berita', NULL, NULL, NULL, NULL, NULL, '2022-04-03 14:03:16', 1, 4, 0),
(80, 1, 0, 79, 'as', 1, 'DUS', 3, 1000, 1000, '2022-04-03 14:04:33', 1, 1, 0),
(81, 2, 0, 2, 's', 2, 'DUS', 3, 2000, 4000, '2022-04-04 10:56:05', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rab_master`
--

CREATE TABLE `rab_master` (
  `id` int(11) NOT NULL,
  `judul_rab` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu` date DEFAULT NULL,
  `total_anggaran` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1 COMMENT '1 = progres, 2, = cancel, 3 = delete, 4 = template, 99 = selesai',
  `action` int(11) DEFAULT 0 COMMENT '0 = active, 1=non aktive, 2=temp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `rab_master`
--

INSERT INTO `rab_master` (`id`, `judul_rab`, `lokasi`, `keterangan`, `waktu`, `total_anggaran`, `tanggal`, `user_id`, `status`, `action`) VALUES
(1, 'Griya Asri Ajung A2', 'Griya Asri Ajung A2', 'Griya Asri Ajung A2', '2021-01-29', 1000, '2021-01-15', 1, 1, 0),
(2, 'Bazzar Murah Sekali', 'Jl. Lobunta Raya - Cirebon', 'Semoga sukses ya', '2021-01-24', 4000, '2021-01-15', 1, 1, 0),
(16, 'Pembangunan Griya Mangli A1-10', 'griya mangli', 'rab', '2022-01-16', 56000000, '2022-01-16', 1, 99, 0),
(17, 'Pembangunan Griya Mangli B1-5', 'griya mangli', 'RAB', '2022-01-16', 24000, '2022-01-16', 1, 1, 0),
(18, 'Pembangunan kaliwatesi A1-5', 'kaliwates', 'rab kaliwates', '2022-01-16', 0, '2022-01-16', 1, 1, 0),
(19, 'Pembangunan Mangli A1-5', 'griya mangli', 'rab', '2022-01-16', 5600000, '2022-01-16', 1, 1, 0),
(24, 'aa', 'a', 'a', '2022-03-31', 0, '2022-03-31', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rek_bank`
--

CREATE TABLE `rek_bank` (
  `id_rekening` int(11) NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `no_rekening` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rek_bank`
--

INSERT INTO `rek_bank` (`id_rekening`, `nama_bank`, `nama_pemilik`, `no_rekening`) VALUES
(3, 'BNI', 'Ahmad', '0662512271772');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id_sertifikat` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `tgl_upload` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_in_out`
--

CREATE TABLE `stok_in_out` (
  `id` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `stok_tipe` int(11) DEFAULT NULL COMMENT 'stok in atau out',
  `quantity` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1 COMMENT '1=ok, 2=cancel, 3 = return, 4 = delete',
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `tanggal_update` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL COMMENT 'user yang create stock',
  `action` int(11) NOT NULL DEFAULT 0 COMMENT '0 = aktif, 1 = tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `stok_in_out`
--

INSERT INTO `stok_in_out` (`id`, `id_produk`, `stok_tipe`, `quantity`, `harga`, `status`, `keterangan`, `tanggal`, `jam`, `tanggal_update`, `user_id`, `action`) VALUES
(1, 1, 1, 50, 0, 1, 'Donasi Bapak Johari', '2021-01-13', '14:13:32', '2022-01-14 07:01:48', 1, 1),
(2, 2, 1, 5, 0, 1, 'Dari hamba Allah', '2021-01-13', '14:15:54', '2022-01-14 07:01:48', 1, 0),
(3, 4, 1, 50, 0, 1, 'Donasi untuk Anak-anak Pondok', '2021-01-13', '14:37:56', '2022-01-14 07:01:48', 1, 0),
(4, 4, 1, 50, 0, 1, 'Donasi untuk Anak-anak Pondok', '2021-01-08', '14:39:31', '2022-01-14 07:01:48', 1, 0),
(5, 1, 2, 2, 0, 1, 'Buat makan siang dan sore', '2021-01-13', '14:55:50', '2022-01-14 07:01:48', 1, 0),
(6, 1, 2, 5, 0, 1, 'test lebih dari stok', '2021-01-13', '18:08:10', '2022-01-14 07:01:48', 1, 0),
(7, 2, 2, 5, 0, 1, 'test aja', '2021-01-13', '21:49:59', '2022-01-14 07:01:48', 1, 0),
(8, 6, 1, 1, 0, 1, 'Motor Honda Grand Astrea 1996', '2020-12-01', '05:17:50', '2022-01-14 07:01:48', 1, 1),
(9, 1, 1, 10, 0, 1, 'tunau', '2022-01-06', NULL, '2022-01-14 07:01:48', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stok_tipe`
--

CREATE TABLE `stok_tipe` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `stok_tipe`
--

INSERT INTO `stok_tipe` (`id`, `nama`) VALUES
(1, 'Barang Masuk'),
(2, 'Barang Keluar');

-- --------------------------------------------------------

--
-- Table structure for table `store_profile`
--

CREATE TABLE `store_profile` (
  `id` int(11) NOT NULL,
  `judul_web` varchar(17) DEFAULT NULL,
  `nama_lembaga` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `bidang` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `action` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='pada tabel user masuknya ke store_id' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `store_profile`
--

INSERT INTO `store_profile` (`id`, `judul_web`, `nama_lembaga`, `alamat`, `telp`, `hp`, `contact_person`, `bidang`, `logo`, `api_key`, `user_id`, `tanggal`, `action`) VALUES
(1, 'SISTEM MANAJEMEN ', 'PT TUNGGAL GRIYA SAKINAH', 'jember', '0821111111', '0821111111', 'bapak', 'Developer dan Real Estate', 'profile-64aa55cabb.jpg', 'F38Ry6AMXqkINwcm11', 1, '2021-01-13 09:47:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kode`
--

CREATE TABLE `sub_kode` (
  `id_sub` int(11) NOT NULL,
  `id_kode` int(11) NOT NULL,
  `sub_kode` varchar(100) NOT NULL,
  `deskripsi_sub_kode` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kode`
--

INSERT INTO `sub_kode` (`id_sub`, `id_kode`, `sub_kode`, `deskripsi_sub_kode`) VALUES
(14, 5, '1', 'Group1'),
(15, 5, '2', 'Group2'),
(18, 6, '1', 'Transaksi Bank'),
(19, 6, '2', 'Transaksi Inhouse'),
(20, 5, '3', 'Group 3'),
(21, 5, '4', 'Group4');

-- --------------------------------------------------------

--
-- Table structure for table `tanda_jadi_lokasi`
--

CREATE TABLE `tanda_jadi_lokasi` (
  `id_tjl` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_tjl` varchar(100) NOT NULL,
  `angsuran` varchar(100) NOT NULL,
  `cicilan_angsuran` varchar(100) NOT NULL,
  `tgl_bayar` varchar(2) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tanda_jadi_lokasi`
--

INSERT INTO `tanda_jadi_lokasi` (`id_tjl`, `id_konsumen`, `jml_tjl`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(103, 50, '105000000', '3', '35000000', '5', 0, '2022-10-05', '', '', 0, 0),
(104, 50, '105000000', '3', '35000000', '5', 0, '2022-11-05', '', '', 0, 0),
(105, 50, '105000000', '3', '35000000', '5', 0, '2022-12-05', '', '', 0, 0),
(106, 51, '1000000', '2', '500000', '3', 1, '2022-11-03', '2022-11-26', '132500', 5, 1),
(107, 51, '1000000', '2', '500000', '3', 0, '2022-12-03', '', '57500', 0, 1),
(108, 46, '105000000', '2', '52500000', '5', 3, '2022-11-05', '2022-10-17', '0', 5, 0),
(109, 46, '105000000', '2', '52500000', '5', 0, '2022-12-05', '', '', 0, 0),
(110, 55, '10000000', '3', '3333333', '2', 0, '2023-01-02', '', '', 0, 1),
(111, 55, '10000000', '3', '3333333', '2', 0, '2023-02-02', '', '', 0, 1),
(112, 55, '10000000', '3', '3333333', '2', 0, '2023-03-02', '', '', 0, 1),
(113, 56, '10000000', '3', '3333333', '2', 1, '2022-12-02', '2022-12-24', '399999.96', 5, 1),
(114, 56, '10000000', '3', '3333333', '2', 1, '2023-02-02', '', '0', 5, 1),
(115, 56, '10000000', '3', '3333333', '2', 0, '2023-03-02', '', '0', 0, 1),
(116, 58, '300000', '3', '100000', '5', 2, '2022-12-01', '', '6500', 5, 1),
(117, 58, '300000', '3', '100000', '5', 1, '2023-02-05', '', '0', 5, 1),
(118, 58, '300000', '3', '100000', '5', 0, '2023-03-05', '', '0', 0, 1),
(119, 59, '500000', '4', '125000', '2', 1, '2023-01-02', '', '0', 5, 1),
(120, 59, '500000', '4', '125000', '2', 0, '2023-02-02', '', '0', 0, 1),
(121, 59, '500000', '4', '125000', '2', 0, '2023-03-02', '', '0', 0, 1),
(122, 59, '500000', '4', '125000', '2', 0, '2023-04-02', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tanda_jadi_lokasi_inhouse`
--

CREATE TABLE `tanda_jadi_lokasi_inhouse` (
  `id_tjl` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_tjl` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tanda_jadi_lokasi_inhouse`
--

INSERT INTO `tanda_jadi_lokasi_inhouse` (`id_tjl`, `id_konsumen`, `jml_tjl`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(65, 47, '3000000', '10', '300000', '1', 1, '2022-10-01', '2022-09-08', '0', 11, 1),
(66, 47, '3000000', '10', '300000', '1', 0, '2022-11-01', '', '', 0, 1),
(67, 47, '3000000', '10', '300000', '1', 0, '2022-12-01', '', '', 0, 1),
(68, 47, '3000000', '10', '300000', '1', 0, '2023-01-01', '', '', 0, 1),
(69, 47, '3000000', '10', '300000', '1', 0, '2023-02-01', '', '', 0, 1),
(70, 47, '3000000', '10', '300000', '1', 0, '2023-03-01', '', '', 0, 1),
(71, 47, '3000000', '10', '300000', '1', 0, '2023-04-01', '', '', 0, 1),
(72, 47, '3000000', '10', '300000', '1', 0, '2023-05-01', '', '', 0, 1),
(73, 47, '3000000', '10', '300000', '1', 0, '2023-06-01', '', '', 0, 1),
(74, 47, '3000000', '10', '300000', '1', 0, '2023-07-01', '', '', 0, 1),
(75, 52, '5000000', '5', '1000000', '1', 3, '2022-11-01', '2022-10-17', '0', 11, 1),
(76, 52, '5000000', '5', '1000000', '1', 0, '2022-12-01', '', '', 0, 1),
(77, 52, '5000000', '5', '1000000', '1', 0, '2023-01-01', '', '', 0, 1),
(78, 52, '5000000', '5', '1000000', '1', 0, '2023-02-01', '', '', 0, 1),
(79, 52, '5000000', '5', '1000000', '1', 0, '2023-03-01', '', '', 0, 1),
(80, 53, '450000', '5', '90000', '2', 3, '2022-11-02', '2022-11-26', '10800', 14, 1),
(81, 53, '450000', '5', '90000', '2', 0, '2022-12-02', '', '', 0, 1),
(82, 53, '450000', '5', '90000', '2', 0, '2023-01-02', '', '', 0, 1),
(83, 53, '450000', '5', '90000', '2', 0, '2023-02-02', '', '', 0, 1),
(84, 53, '450000', '5', '90000', '2', 0, '2023-03-02', '', '', 0, 1),
(85, 57, '3000000', '5', '600000', '3', 1, '2023-01-03', '', '0', 11, 1),
(86, 57, '3000000', '5', '600000', '3', 0, '2023-02-03', '', '0', 0, 1),
(87, 57, '3000000', '5', '600000', '3', 0, '2023-03-03', '', '0', 0, 1),
(88, 57, '3000000', '5', '600000', '3', 0, '2023-04-03', '', '0', 0, 1),
(89, 57, '3000000', '5', '600000', '3', 0, '2023-05-03', '', '0', 0, 1),
(90, 60, '1300000', '4', '325000', '1', 1, '2023-01-01', '', '0', 27, 1),
(91, 60, '1300000', '4', '325000', '1', 0, '2023-02-01', '', '0', 0, 1),
(92, 60, '1300000', '4', '325000', '1', 0, '2023-03-01', '', '0', 0, 1),
(93, 60, '1300000', '4', '325000', '1', 0, '2023-04-01', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blok`
--

CREATE TABLE `tbl_blok` (
  `id_blok` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL,
  `blok` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cluster`
--

CREATE TABLE `tbl_cluster` (
  `id_cluster` int(11) NOT NULL,
  `id_perum` int(11) NOT NULL,
  `nama_cluster` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cluster`
--

INSERT INTO `tbl_cluster` (`id_cluster`, `id_perum`, `nama_cluster`) VALUES
(7, 2, 'Komodo'),
(8, 1, 'Kadal'),
(9, 1, 'Buaya'),
(10, 1, 'Banteng');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kavling`
--

CREATE TABLE `tbl_kavling` (
  `id_kavling` int(11) NOT NULL,
  `id_perum` int(11) NOT NULL,
  `id_cluster` int(11) NOT NULL,
  `id_tipe` int(11) NOT NULL,
  `blok` varchar(40) NOT NULL,
  `no_rumah` varchar(10) NOT NULL,
  `lt` varchar(100) NOT NULL,
  `lb` varchar(100) NOT NULL,
  `harga` varchar(30) NOT NULL,
  `status_kavling` int(11) NOT NULL DEFAULT 0,
  `proyek` int(11) NOT NULL DEFAULT 0,
  `sitemap_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kavling`
--

INSERT INTO `tbl_kavling` (`id_kavling`, `id_perum`, `id_cluster`, `id_tipe`, `blok`, `no_rumah`, `lt`, `lb`, `harga`, `status_kavling`, `proyek`, `sitemap_id`) VALUES
(43, 1, 8, 2, 'A', '2', '12', '10', '1000000', 1, 1, 'sitemap-11'),
(44, 1, 8, 2, 'E', '1', '12', '10', '120000000', 1, 1, 'sitemap-365'),
(45, 1, 8, 2, 'A', '1', '12', '10', '120000000', 1, 1, 'sitemap-41'),
(46, 1, 8, 1, 'D', '1', '12', '10', '120000000', 0, 1, 'sitemap-60'),
(47, 1, 8, 1, 'F', '1', '12', '10', '120000000', 0, 1, 'sitemap-71'),
(48, 1, 8, 1, 'E', '2', '10', '11', '120000000', 2, 1, 'sitemap-366'),
(49, 1, 8, 1, 'A', '10', '12', '10', '120000000', 0, 1, 'sitemap-39'),
(50, 1, 8, 1, 'b', '1', '13', '11', '150000000', 0, 1, 'sitemap-123'),
(51, 1, 8, 1, 'b', '3', '13', '10', '135000000', 0, 1, 'sitemap-124'),
(52, 1, 8, 2, 'q', '1', '10', '9', '100000000', 1, 1, 'sitemap-260'),
(53, 1, 8, 2, 'q', '2', '10', '9', '100000000', 0, 1, 'sitemap-261'),
(54, 1, 8, 3, 'Q', '3', '20', '15', '250000000', 0, 1, 'sitemap-27'),
(56, 1, 8, 1, 'Z', '1', '10', '9', '100000000', 1, 0, 'sitemap-254'),
(57, 1, 8, 1, 'Z', '2', '10', '9', '100000000', 0, 0, 'sitemap-253'),
(58, 1, 8, 1, 'S', '1', '20', '15', '200000000', 0, 0, 'sitemap-242'),
(59, 1, 8, 1, 'S', '2', '20', '17', '200000000', 0, 1, 'sitemap-243'),
(60, 1, 8, 1, 'S', '3', '20', '17', '200000000', 0, 1, 'sitemap-244');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_marketing`
--

CREATE TABLE `tbl_marketing` (
  `id_marketing` int(11) NOT NULL,
  `nama_konsumen` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `dapat_info` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `tempat_kerja` varchar(100) NOT NULL,
  `gaji` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `status_menikah` varchar(10) NOT NULL,
  `status_fee_marketing` int(1) NOT NULL,
  `img_fee_marketing` varchar(100) NOT NULL,
  `nominal_fee_marketing` varchar(20) NOT NULL,
  `spr` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_fee_marketing` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_marketing`
--

INSERT INTO `tbl_marketing` (`id_marketing`, `nama_konsumen`, `no_hp`, `jk`, `pekerjaan`, `dapat_info`, `status`, `nik`, `tempat_kerja`, `gaji`, `email`, `alamat`, `status_menikah`, `status_fee_marketing`, `img_fee_marketing`, `nominal_fee_marketing`, `spr`, `title_kode`, `tgl_fee_marketing`) VALUES
(46, 'bot1', '0823351661552', 'Laki-laki', 'Polri', 'Brosur', 0, '998271623678', 'NapolineStar', '4500000', 'both1@mail.com', 'Jl. Tegal Sewu', 'Belum', 2, 'Screenshot_4.png', '500000', 0, 3, '2022-09-08'),
(47, 'bot2', '08218271521', 'Laki-laki', 'PNS', 'Teman', 0, '8872641234567', 'Matahari', '4500000', 'bote2@mail.com', 'Jl. Brawijaya', 'Sudah', 1, 'bg_login11.jpg', '500000', 0, 0, NULL),
(48, 'boot3', '082182715217', 'Laki-laki', 'Karyawan Swasta', 'Media Sosial', 2, '8890082766142', 'Ahmad Djaya Jr', '4500000', 'ahgmad@mail.com', 'Jl. Tegal Sewu', 'Belum', 0, 'bg_login2.jpg', '2000000', 1, 3, '2022-09-02'),
(50, 'M. Ahmad Ramdani', '082182715212', 'Laki-laki', 'PNS', 'Brosur', 0, '998207253', 'NapolineStar', '5000000', 'ahmdad@mail.com', 'Jl. Tegal Sewu', 'Sudah', 0, '', '', 0, 0, NULL),
(51, 'Slamet kopling', '0821827521', 'Laki-laki', 'Polri', 'Teman', 8, '90876254132412', 'asdewq', '5000000', 'sumbulM@mail.com', 'Jl. Brawijaya', 'Sudah', 2, 'default-image.jpg', '500000', 0, 3, '2022-12-13'),
(52, 'Muhammad sumbul', '089221345600', 'Laki-laki', 'Karyawan Swasta', 'Lainnya', 0, '990827162543', 'Sinar surga', '3500000', 'asdfg@mail.com', 'Jl. Soeprapto', 'Belum', 0, '', '', 0, 0, NULL),
(53, 'Ali cilok', '085443299090', 'Laki-laki', 'Tenaga Kontrak', 'Media Sosial', 0, '99820817582512', 'asdgh', '5000000', 'asd@mail.com', 'Jl. Tegal Sewu', 'Belum', 4, '3d-business-black-and-blue-credit-card.png', '200000', 0, 3, '2022-11-24'),
(54, 'diki tubles', '081223789065', 'Laki-laki', 'PNS', 'Brosur', 0, '2000987762', 'Jember', '10000000', '12eew@mail.com', 'Jl Sumatra', 'Belum', 0, '', '', 0, 0, NULL),
(55, 'assdwe', '089926534126', 'Laki-laki', 'Wiraswasta', 'Brosur', 0, '009287712', 'asdfg', '8000000', 'as21d@mail.com', 'Jl Sumatra', 'Belum', 0, '', '', 0, 0, NULL),
(56, 'admnn', '782665241009', 'Laki-laki', 'Honorer / Sukwan', 'Media Sosial', 2, '7789009', 'asdfg', '9000000', 'as1d@mail.com', 'Jl Sumatra', 'Belum', 0, '', '', 0, 0, NULL),
(57, 'Diky inhouse', '90887665433', 'Laki-laki', 'Wiraswasta', 'Banner', 0, '2231112', 'Lumajang', '3000000', 'di@mail.com', 'Jl Java', 'Belum', 0, '', '', 0, 0, NULL),
(58, 'Akbar bank', '0812234567890', 'Laki-laki', 'TNI', 'Banner', 0, '2230991', 'Jember', '3000000', 'ada@mail.com', 'Jl Sumatra', 'Belum', 0, '', '', 0, 0, NULL),
(59, 'Ariel bank', '0899265341263', 'Laki-laki', 'Polri', 'Banner', 2, '22099122', 'Jember', '3000000', 'ariel@mail.com', 'Jl Java', 'Belum', 0, '', '', 0, 0, NULL),
(60, 'Baz inhouse', '09882199273', 'Laki-laki', 'Wiraswasta', 'Banner', 3, '200034', 'Lumajang', '4000000', 'bazx@mail.com', 'Jl Sumatra', 'Belum', 0, '', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_max_material`
--

CREATE TABLE `tbl_max_material` (
  `id_max` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `id_tipe` int(11) NOT NULL,
  `max` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_max_material`
--

INSERT INTO `tbl_max_material` (`id_max`, `material_id`, `kategori_id`, `id_tipe`, `max`, `created_at`) VALUES
(12, 16, 2, 1, 200, '2022-06-20 11:35:27'),
(13, 36, 1, 1, 100, '2022-06-20 11:54:22'),
(14, 17, 2, 1, 200, '2022-06-25 07:20:18'),
(15, 31, 3, 1, 50, '2022-06-25 07:20:39'),
(16, 18, 2, 1, 100, '2022-06-28 08:48:46'),
(17, 36, 1, 2, 20, '2022-08-05 14:10:54'),
(18, 37, 1, 2, 25, '2022-08-05 14:12:03'),
(20, 17, 2, 2, 200, '2022-08-08 23:57:00'),
(21, 39, 1, 1, 5, '2022-08-09 00:05:53'),
(25, 28, 5, 2, 100, '2022-08-16 10:05:45'),
(26, 30, 3, 2, 200, '2022-08-16 10:08:42'),
(27, 30, 3, 1, 100, '2022-08-16 10:09:14'),
(28, 30, 3, 3, 30, '2022-08-16 10:09:46'),
(29, 23, 4, 1, 70, '2022-08-16 10:11:32'),
(30, 29, 5, 1, 300, '2022-11-27 08:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pasangan`
--

CREATE TABLE `tbl_pasangan` (
  `id_pasangan` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `nik` varchar(100) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `tempat_kerja` varchar(200) NOT NULL,
  `gaji` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pasangan`
--

INSERT INTO `tbl_pasangan` (`id_pasangan`, `id_marketing`, `nik`, `nama`, `no_hp`, `email`, `jk`, `pekerjaan`, `tempat_kerja`, `gaji`) VALUES
(23, 50, '221346678', 'Sarinah', '089744524132', 'sarinah@mail.com', 'perempuan', 'Honorer / Sukwan', 'Kantor', '3500000'),
(24, 51, '99872651029873', 'Sri Kendi', '089009212653', 'sri@mail.com', 'perempuan', 'PNS', 'SMP Satir', '350000'),
(26, 47, '00817265142009', 'Annie marjan', '081223678098', 'annie@mail.com', 'perempuan', 'PNS', 'Kantor', '3500000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pelanggan`
--

CREATE TABLE `tbl_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL,
  `id_blok` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `jenis_kelamin` int(11) NOT NULL,
  `status_pelanggan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perumahan`
--

CREATE TABLE `tbl_perumahan` (
  `id_perumahan` int(11) NOT NULL,
  `nama_perumahan` varchar(200) NOT NULL,
  `kabupaten` varchar(200) NOT NULL,
  `alamat_perumahan` text NOT NULL,
  `cluster` int(1) NOT NULL,
  `logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_perumahan`
--

INSERT INTO `tbl_perumahan` (`id_perumahan`, `nama_perumahan`, `kabupaten`, `alamat_perumahan`, `cluster`, `logo`) VALUES
(1, 'Griya Mangli Jember', 'Jember', 'Jl. cempaka putih no 12 Kaliwates, Jember', 1, 'g22.png'),
(2, 'Kaliwates Residence', 'Jember', 'Jl. Ahmad Yani no. 33 Kaliwates, Jember', 1, 'bg_login1.jpg'),
(3, 'Griya Sakinah ', 'Surabaya', 'Jl. Brawijaya no 22 Surabaya', 0, 'icon1.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proyek_insidentil`
--

CREATE TABLE `tbl_proyek_insidentil` (
  `id` int(11) NOT NULL,
  `proyek_id` int(11) NOT NULL,
  `keterangan` varchar(225) NOT NULL,
  `nilai` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_insidentil` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_proyek_insidentil`
--

INSERT INTO `tbl_proyek_insidentil` (`id`, `proyek_id`, `keterangan`, `nilai`, `user_id`, `tanggal_insidentil`, `created_at`, `status`, `title_kode`, `tgl_approve`, `id_perumahan`) VALUES
(9, 113, 'Saluran Irigasi', 5500000, 1, '2022-12-11', '2022-12-10 22:49:17', 3, 19, '2022-12-11', 1),
(10, 113, '22020200910299912', 2000000, 1, '2022-12-15', '2022-12-15 02:20:04', 3, 19, '2022-12-15', 1),
(11, 111, 'sasas', 1000000, 1, '2022-12-15', '2022-12-15 02:30:41', 3, 19, '2022-12-22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proyek_lainnya`
--

CREATE TABLE `tbl_proyek_lainnya` (
  `id` int(11) NOT NULL,
  `proyek_id` int(11) NOT NULL,
  `tipe_id` int(11) NOT NULL,
  `keterangan` varchar(225) NOT NULL,
  `harga_lainnya` varchar(225) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_proyek_lainnya`
--

INSERT INTO `tbl_proyek_lainnya` (`id`, `proyek_id`, `tipe_id`, `keterangan`, `harga_lainnya`, `user_id`, `created_at`, `status`, `title_kode`, `tgl_approve`) VALUES
(46, 109, 1, 'Sumur Bor', '5000000', 1, '2022-08-10 02:17:14', 3, 18, '2022-09-06'),
(47, 109, 2, 'qwdrft', '400000', 1, '2022-08-10 03:50:59', 1, 0, NULL),
(48, 110, 1, 'Pagar', '700000', 1, '2022-08-11 01:23:46', 1, 0, NULL),
(49, 110, 2, 'pagar', '500000', 1, '2022-08-11 01:24:07', 1, 0, NULL),
(50, 111, 2, 'Paving', '340000', 1, '2022-09-05 01:56:41', 1, 0, NULL),
(51, 111, 1, 'Gerbang', '530000', 1, '2022-09-05 01:57:20', 3, 18, '2022-09-08'),
(52, 112, 1, 'Muken', '30000', 1, '2022-11-16 09:01:55', 1, 0, NULL),
(53, 112, 1, 'bang zen', '4000000', 1, '2022-11-16 09:02:21', 1, 0, NULL),
(54, 113, 1, 'makan, kopi, dan gorengan', '100000', 1, '2022-12-01 04:47:58', 1, 0, NULL),
(55, 114, 3, 'gal valum', '5000000', 1, '2022-12-24 01:52:18', 1, 0, NULL),
(56, 115, 1, 'hkkk', '200000', 1, '2022-12-29 02:47:02', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proyek_material`
--

CREATE TABLE `tbl_proyek_material` (
  `id` int(11) NOT NULL,
  `proyek_id` int(11) NOT NULL,
  `tipe_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `material_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `jml_out` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total` int(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_proyek_material`
--

INSERT INTO `tbl_proyek_material` (`id`, `proyek_id`, `tipe_id`, `kategori_id`, `material_id`, `quantity`, `jml_out`, `harga`, `total`, `user_id`, `created_at`, `status`, `title_kode`, `tgl_approve`) VALUES
(104, 109, 1, 1, 36, 20, 5, 300000, 6000000, 1, '2022-08-09', 3, 16, '2022-09-06'),
(105, 109, 2, 3, 30, 50, 10, 50000, 2500000, 1, '2022-08-09', 1, 0, NULL),
(106, 110, 1, 5, 27, 30, 15, 200000, 6000000, 1, '2022-08-10', 1, 0, NULL),
(107, 110, 2, 1, 39, 2, 0, 1500000, 3000000, 1, '2022-08-10', 1, 0, NULL),
(108, 110, 1, 2, 21, 30, 0, 50000, 1500000, 1, '2022-08-10', 1, 0, NULL),
(109, 110, 2, 5, 27, 50, 0, 70000, 3500000, 1, '2022-08-10', 1, 0, NULL),
(110, 109, 1, 4, 23, 50, 50, 135000, 6750000, 1, '2022-08-10', 1, 0, NULL),
(111, 109, 2, 5, 28, 60, 40, 230000, 13800000, 1, '2022-08-10', 1, 0, NULL),
(112, 109, 1, 1, 37, 100, 0, 140000, 14000000, 1, '2022-08-15', 1, 0, NULL),
(113, 111, 1, 2, 15, 10, 10, 100000, 1000000, 1, '2022-09-04', 3, 16, '2022-09-08'),
(114, 111, 2, 4, 25, 22, 22, 13000, 286000, 1, '2022-09-04', 1, 0, NULL),
(115, 112, 1, 2, 19, 10, 0, 20000, 200000, 1, '2022-10-31', 1, 0, NULL),
(116, 112, 1, 4, 25, 50, 0, 20000, 1000000, 1, '2022-10-31', 1, 0, NULL),
(118, 112, 1, 1, 37, 2, 2, 78000, 156000, 1, '2022-11-02', 1, 0, NULL),
(119, 112, 1, 1, 39, 3000, 3000, 1000, 3000000, 1, '2022-11-09', 1, 0, NULL),
(120, 112, 1, 5, 29, 50, 40, 150000, 7500000, 1, '2022-11-18', 1, 0, NULL),
(123, 113, 1, 2, 16, 10, 0, 120000, 1200000, 1, '2022-12-01', 1, 0, NULL),
(124, 113, 1, 1, 39, 40, 0, 550000, 22000000, 1, '2022-12-01', 1, 0, NULL),
(125, 113, 1, 1, 36, 100, 0, 240000, 24000000, 1, '2022-12-22', 1, 0, NULL),
(126, 113, 1, 4, 25, 100, 0, 10000, 1000000, 1, '2022-12-22', 1, 0, NULL),
(127, 114, 3, 1, 36, 20, 0, 120000, 2400000, 1, '2022-12-24', 1, 0, NULL),
(128, 114, 3, 1, 39, 5, 0, 1000000, 5000000, 1, '2022-12-24', 1, 0, NULL),
(129, 114, 3, 2, 16, 10, 0, 55000, 550000, 1, '2022-12-24', 1, 0, NULL),
(130, 115, 1, 1, 37, 30, 0, 80000, 2400000, 1, '2022-12-29', 1, 0, NULL),
(131, 115, 1, 2, 19, 10, 0, 45000, 450000, 1, '2022-12-29', 1, 0, NULL),
(132, 115, 1, 1, 39, 5, 0, 120000, 600000, 1, '2022-12-29', 1, 0, NULL),
(133, 119, 1, 1, 36, 30, 0, 20000, 600000, 1, '2022-12-29', 1, 0, NULL),
(134, 119, 1, 2, 15, 10, 0, 50000, 500000, 1, '2022-12-29', 1, 0, NULL),
(135, 120, 1, 1, 36, 20, 0, 20000, 400000, 1, '2022-12-29', 1, 0, NULL),
(136, 120, 1, 2, 19, 10, 0, 40000, 400000, 1, '2022-12-29', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_proyek_upah`
--

CREATE TABLE `tbl_proyek_upah` (
  `id` int(11) NOT NULL,
  `proyek_id` int(11) NOT NULL,
  `tipe_id` int(11) NOT NULL,
  `harga_kontrak` int(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `action` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `tgl_approve` date DEFAULT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_proyek_upah`
--

INSERT INTO `tbl_proyek_upah` (`id`, `proyek_id`, `tipe_id`, `harga_kontrak`, `user_id`, `created_at`, `action`, `status`, `title_kode`, `tgl_approve`, `ket`) VALUES
(66, 109, 1, 20000000, 1, '2022-08-10 02:01:20', 0, 3, 17, '2022-09-06', ''),
(67, 109, 2, 17000000, 1, '2022-08-10 02:01:59', 0, 1, 0, NULL, ''),
(68, 110, 1, 15000000, 1, '2022-08-11 01:22:30', 0, 1, 0, NULL, ''),
(69, 110, 2, 10500000, 1, '2022-08-11 01:23:06', 0, 1, 0, NULL, ''),
(70, 111, 1, 9000000, 1, '2022-09-05 01:55:26', 0, 1, 0, NULL, ''),
(71, 111, 2, 7500000, 1, '2022-09-05 01:55:59', 0, 3, 17, '2022-09-08', ''),
(72, 112, 1, 300000, 1, '2022-11-16 00:32:10', 0, 1, 0, NULL, ''),
(73, 112, 1, 2056000, 1, '2022-11-16 00:32:57', 0, 1, 0, NULL, 'sasasas'),
(74, 112, 1, 300000, 1, '2022-11-16 08:46:14', 0, 1, 0, NULL, 'asd'),
(75, 113, 1, 10000000, 1, '2022-12-01 04:47:18', 0, 1, 0, NULL, 'ok'),
(76, 114, 3, 10000000, 1, '2022-12-24 01:50:42', 0, 1, 0, NULL, 'asdf'),
(77, 114, 3, 2000000, 1, '2022-12-24 01:51:33', 0, 1, 0, NULL, 'listrik'),
(78, 115, 1, 20000000, 1, '2022-12-29 02:45:57', 0, 1, 0, NULL, 'asdf'),
(79, 119, 1, 10000000, 1, '2022-12-29 07:29:22', 0, 1, 0, NULL, 'ok'),
(80, 120, 1, 3000000, 1, '2022-12-29 09:06:28', 0, 1, 0, NULL, 'hshsh');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tipe`
--

CREATE TABLE `tbl_tipe` (
  `id_tipe` int(11) NOT NULL,
  `id_perum` int(11) NOT NULL,
  `id_cluster` int(11) DEFAULT NULL,
  `tipe` varchar(10) NOT NULL,
  `status` int(11) NOT NULL COMMENT 'Status Jika punya Max Material',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tipe`
--

INSERT INTO `tbl_tipe` (`id_tipe`, `id_perum`, `id_cluster`, `tipe`, `status`, `created_at`) VALUES
(1, 1, 8, '30', 0, '2022-06-06 08:24:38'),
(2, 1, 8, '20', 0, '2022-06-06 08:24:38'),
(3, 1, 8, 'B10', 0, '2022-06-06 08:25:22'),
(4, 2, 7, 'AA2', 0, '2022-06-06 08:25:22'),
(6, 3, 0, '30', 0, '2022-06-23 03:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_bank`
--

CREATE TABLE `tbl_transaksi_bank` (
  `id_transaksi_bank` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `harga_kesepakatan` varchar(40) NOT NULL,
  `tanda_jadi` varchar(100) NOT NULL,
  `tgl_tanda_jadi` date NOT NULL,
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaksi_bank`
--

INSERT INTO `tbl_transaksi_bank` (`id_transaksi_bank`, `id_konsumen`, `id_rumah`, `harga_kesepakatan`, `tanda_jadi`, `tgl_tanda_jadi`, `status`, `title_kode`) VALUES
(31, 46, 47, '120000000', '90500000', '2022-09-08', 0, 0),
(32, 48, 44, '120000000', '1000000', '2022-10-21', 2, 14),
(37, 50, 53, '100000000', '90500000', '2022-09-19', 0, 0),
(38, 51, 48, '120000000', '12000000', '2022-11-25', 2, 5),
(39, 55, 57, '100000000', '2000000', '2022-12-24', 0, 0),
(40, 56, 56, '100000000', '2000000', '2022-12-24', 0, 0),
(41, 58, 43, '1000000', '200000', '2022-12-26', 1, 5),
(42, 59, 43, '1000000', '400000', '2022-12-28', 1, 26);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi_inhouse`
--

CREATE TABLE `tbl_transaksi_inhouse` (
  `id_inhouse` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `tanda_jadi` varchar(20) NOT NULL,
  `tgl_tanda_jadi` date NOT NULL,
  `status` int(1) NOT NULL,
  `title_kode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaksi_inhouse`
--

INSERT INTO `tbl_transaksi_inhouse` (`id_inhouse`, `id_konsumen`, `id_rumah`, `tanda_jadi`, `tgl_tanda_jadi`, `status`, `title_kode`) VALUES
(29, 47, 46, '90500000', '2022-09-08', 0, 0),
(31, 52, 52, '100000000', '2022-10-10', 0, 0),
(32, 53, 47, '1000000', '2022-10-21', 2, 16),
(33, 54, 56, '2000000', '2022-12-24', 0, 0),
(34, 57, 45, '1000000', '2022-12-26', 1, 9),
(35, 60, 45, '1000000', '2022-12-28', 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `title_kode`
--

CREATE TABLE `title_kode` (
  `id_title` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `kode_title` varchar(100) NOT NULL,
  `deskripsi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `title_kode`
--

INSERT INTO `title_kode` (`id_title`, `id_sub`, `kode_title`, `deskripsi`) VALUES
(1, 3, 'b', 'sasas'),
(3, 14, 'a', 'Fee Marketing'),
(4, 14, 'b', 'Upah Pekerja'),
(5, 18, 'a', 'Tanda Jadi Lokasi Bank'),
(6, 18, 'b', 'Uang Muka Bank'),
(7, 18, 'c', 'kelebihan Tanah Bank'),
(8, 18, 'd', 'PAK'),
(9, 18, 'e', 'Lain - lain'),
(10, 19, 'a', 'Harga Kesepakatan'),
(11, 19, 'b', 'Tanda Jadi Lokasi Inhouse'),
(12, 19, 'c', 'Uang Muka Inhouse'),
(13, 19, 'd', 'kelebihan Tanah Inhouse'),
(14, 15, 'a', 'Pembebasan Lahan'),
(15, 15, 'b', 'Pengeluaran Lain'),
(16, 20, 'a', 'RAB Material'),
(17, 20, 'b', 'RAB Upah Pekerja'),
(18, 20, 'c', 'RAB Lain-lain'),
(19, 21, 'a', 'Pekerjaan insidentil'),
(20, 21, 'b', 'Pengajuan Material'),
(21, 18, 'f', 'Angsuran Bank'),
(22, 18, 'g', 'Piutang Bank'),
(25, 21, 'c', 'Kas Operasional'),
(26, 18, 'h', 'Tanda Jadi Bank'),
(27, 19, 'e', 'Tanda Jadi Inhouse');

-- --------------------------------------------------------

--
-- Table structure for table `uang_muka`
--

CREATE TABLE `uang_muka` (
  `id_um` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_um` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uang_muka`
--

INSERT INTO `uang_muka` (`id_um`, `id_konsumen`, `jml_um`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(49, 46, '1200000', '5', '240000', '1', 1, '2022-10-01', '2022-09-08', '0', 6, 1),
(50, 46, '1200000', '5', '240000', '1', 0, '2022-11-01', '', '', 0, 1),
(51, 46, '1200000', '5', '240000', '1', 0, '2022-12-01', '', '', 0, 1),
(52, 46, '1200000', '5', '240000', '1', 0, '2023-01-01', '', '', 0, 1),
(53, 46, '1200000', '5', '240000', '1', 0, '2023-02-01', '', '', 0, 1),
(54, 50, '1200000', '2', '600000', '1', 0, '2022-10-01', '', '', 0, 0),
(55, 50, '1200000', '2', '600000', '1', 0, '2022-11-01', '', '', 0, 0),
(56, 51, '300000', '2', '150000', '3', 3, '2022-11-03', '2022-11-26', '17250', 6, 1),
(57, 51, '300000', '2', '150000', '3', 0, '2022-12-03', '', '', 0, 1),
(58, 58, '500000', '5', '100000', '5', 2, '2023-01-05', '', '0', 6, 1),
(59, 58, '500000', '5', '100000', '5', 0, '2023-02-05', '', '0', 0, 1),
(60, 58, '500000', '5', '100000', '5', 0, '2023-03-05', '', '0', 0, 1),
(61, 58, '500000', '5', '100000', '5', 0, '2023-04-05', '', '0', 0, 1),
(62, 58, '500000', '5', '100000', '5', 0, '2023-05-05', '', '0', 0, 1),
(63, 59, '350000', '5', '70000', '2', 2, '2023-01-02', '', '0', 6, 1),
(64, 59, '350000', '5', '70000', '2', 0, '2023-02-02', '', '0', 0, 1),
(65, 59, '350000', '5', '70000', '2', 0, '2023-03-02', '', '0', 0, 1),
(66, 59, '350000', '5', '70000', '2', 0, '2023-04-02', '', '0', 0, 1),
(67, 59, '350000', '5', '70000', '2', 0, '2023-05-02', '', '0', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uang_muka_inhouse`
--

CREATE TABLE `uang_muka_inhouse` (
  `id_um` int(11) NOT NULL,
  `id_konsumen` int(11) NOT NULL,
  `jml_um` varchar(20) NOT NULL,
  `angsuran` varchar(20) NOT NULL,
  `cicilan_angsuran` varchar(20) NOT NULL,
  `tgl_bayar` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tgl_pembayaran` varchar(100) NOT NULL,
  `denda` varchar(100) NOT NULL,
  `title_kode` int(11) NOT NULL,
  `id_perumahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uang_muka_inhouse`
--

INSERT INTO `uang_muka_inhouse` (`id_um`, `id_konsumen`, `jml_um`, `angsuran`, `cicilan_angsuran`, `tgl_bayar`, `status`, `jatuh_tempo`, `tgl_pembayaran`, `denda`, `title_kode`, `id_perumahan`) VALUES
(53, 47, '500000', '5', '100000', '1', 1, '2022-10-01', '2022-09-08', '0', 12, 1),
(54, 47, '500000', '5', '100000', '1', 0, '2022-11-01', '', '', 0, 1),
(55, 47, '500000', '5', '100000', '1', 0, '2022-12-01', '', '', 0, 1),
(56, 47, '500000', '5', '100000', '1', 0, '2023-01-01', '', '', 0, 1),
(57, 47, '500000', '5', '100000', '1', 0, '2023-02-01', '', '', 0, 1),
(58, 52, '500000', '2', '250000', '1', 0, '2022-11-01', '', '', 0, 1),
(59, 52, '500000', '2', '250000', '1', 0, '2022-12-01', '', '', 0, 1),
(60, 53, '300000', '2', '150000', '2', 3, '2022-11-02', '2022-11-26', '18000', 14, 1),
(61, 53, '300000', '2', '150000', '2', 0, '2022-12-02', '', '', 0, 1),
(62, 57, '2000000', '5', '400000', '3', 1, '2023-01-03', '', '0', 12, 1),
(63, 57, '2000000', '5', '400000', '3', 0, '2023-02-03', '', '0', 0, 1),
(64, 57, '2000000', '5', '400000', '3', 0, '2023-03-03', '', '0', 0, 1),
(65, 57, '2000000', '5', '400000', '3', 0, '2023-04-03', '', '0', 0, 1),
(66, 57, '2000000', '5', '400000', '3', 0, '2023-05-03', '', '0', 0, 1),
(67, 60, '5000000', '10', '500000', '25', 1, '2023-01-25', '', '0', 12, 1),
(68, 60, '5000000', '10', '500000', '25', 0, '2023-02-25', '', '0', 0, 1),
(69, 60, '5000000', '10', '500000', '25', 0, '2023-03-25', '', '0', 0, 1),
(70, 60, '5000000', '10', '500000', '25', 0, '2023-04-25', '', '0', 0, 1),
(71, 60, '5000000', '10', '500000', '25', 0, '2023-05-25', '', '0', 0, 1),
(72, 60, '5000000', '10', '500000', '25', 0, '2023-06-25', '', '0', 0, 1),
(73, 60, '5000000', '10', '500000', '25', 0, '2023-07-25', '', '0', 0, 1),
(74, 60, '5000000', '10', '500000', '25', 0, '2023-08-25', '', '0', 0, 1),
(75, 60, '5000000', '10', '500000', '25', 0, '2023-09-25', '', '0', 0, 1),
(76, 60, '5000000', '10', '500000', '25', 0, '2023-10-25', '', '0', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_perumahan`
--
ALTER TABLE `access_perumahan`
  ADD PRIMARY KEY (`id_access`);

--
-- Indexes for table `angsuran_bank`
--
ALTER TABLE `angsuran_bank`
  ADD PRIMARY KEY (`id_angsur`);

--
-- Indexes for table `approved_history`
--
ALTER TABLE `approved_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_cicil_kt`
--
ALTER TABLE `bank_cicil_kt`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_lain`
--
ALTER TABLE `bank_cicil_lain`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_pak`
--
ALTER TABLE `bank_cicil_pak`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_pb`
--
ALTER TABLE `bank_cicil_pb`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_rb`
--
ALTER TABLE `bank_cicil_rb`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_tj`
--
ALTER TABLE `bank_cicil_tj`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_tjl`
--
ALTER TABLE `bank_cicil_tjl`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `bank_cicil_um`
--
ALTER TABLE `bank_cicil_um`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `berkas_konsumen`
--
ALTER TABLE `berkas_konsumen`
  ADD PRIMARY KEY (`id_berkas`);

--
-- Indexes for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD PRIMARY KEY (`id_bukti`);

--
-- Indexes for table `bukti_spkb`
--
ALTER TABLE `bukti_spkb`
  ADD PRIMARY KEY (`id_bukti_spkb`);

--
-- Indexes for table `bukti_spr`
--
ALTER TABLE `bukti_spr`
  ADD PRIMARY KEY (`id_bukti_spr`);

--
-- Indexes for table `cicil_fee_marketing`
--
ALTER TABLE `cicil_fee_marketing`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_insidentil`
--
ALTER TABLE `cicil_insidentil`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_kas`
--
ALTER TABLE `cicil_kas`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_material`
--
ALTER TABLE `cicil_material`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_pembatalan`
--
ALTER TABLE `cicil_pembatalan`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_pembebasan_lahan`
--
ALTER TABLE `cicil_pembebasan_lahan`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_pengeluaran_lain`
--
ALTER TABLE `cicil_pengeluaran_lain`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `cicil_progres`
--
ALTER TABLE `cicil_progres`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `db_group`
--
ALTER TABLE `db_group`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_group_module`
--
ALTER TABLE `db_group_module`
  ADD PRIMARY KEY (`group_id`,`modul_id`) USING BTREE;

--
-- Indexes for table `db_module`
--
ALTER TABLE `db_module`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_status`
--
ALTER TABLE `db_status`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user`
--
ALTER TABLE `db_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `db_user_history_login`
--
ALTER TABLE `db_user_history_login`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `harga_kesepakatan_inhouse`
--
ALTER TABLE `harga_kesepakatan_inhouse`
  ADD PRIMARY KEY (`id_kesepakatan`);

--
-- Indexes for table `inhouse_cicil_hk`
--
ALTER TABLE `inhouse_cicil_hk`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `inhouse_cicil_kt`
--
ALTER TABLE `inhouse_cicil_kt`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `inhouse_cicil_tj`
--
ALTER TABLE `inhouse_cicil_tj`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `inhouse_cicil_tjl`
--
ALTER TABLE `inhouse_cicil_tjl`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `inhouse_cicil_um`
--
ALTER TABLE `inhouse_cicil_um`
  ADD PRIMARY KEY (`id_cicil`);

--
-- Indexes for table `kas_operasional`
--
ALTER TABLE `kas_operasional`
  ADD PRIMARY KEY (`id_kas`);

--
-- Indexes for table `kelebihan_tanah`
--
ALTER TABLE `kelebihan_tanah`
  ADD PRIMARY KEY (`id_kt`);

--
-- Indexes for table `kelebihan_tanah_inhouse`
--
ALTER TABLE `kelebihan_tanah_inhouse`
  ADD PRIMARY KEY (`id_kt`);

--
-- Indexes for table `kode`
--
ALTER TABLE `kode`
  ADD PRIMARY KEY (`id_kode`);

--
-- Indexes for table `lain_lain`
--
ALTER TABLE `lain_lain`
  ADD PRIMARY KEY (`id_lain`);

--
-- Indexes for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `laporan_keuangan_kategori_induk`
--
ALTER TABLE `laporan_keuangan_kategori_induk`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `laporan_keuangan_kategori_transaksi`
--
ALTER TABLE `laporan_keuangan_kategori_transaksi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `laporan_keuangan_tipe`
--
ALTER TABLE `laporan_keuangan_tipe`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `logistik_stok`
--
ALTER TABLE `logistik_stok`
  ADD PRIMARY KEY (`id_stok`);

--
-- Indexes for table `mandor_proyek`
--
ALTER TABLE `mandor_proyek`
  ADD PRIMARY KEY (`id_mandor_proyek`);

--
-- Indexes for table `master_logistik`
--
ALTER TABLE `master_logistik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_logistik_detail`
--
ALTER TABLE `master_logistik_detail`
  ADD PRIMARY KEY (`id_logistik_detail`);

--
-- Indexes for table `master_logistik_keluar`
--
ALTER TABLE `master_logistik_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_logistik_masuk`
--
ALTER TABLE `master_logistik_masuk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `logistik_id` (`logistik_id`);

--
-- Indexes for table `master_mandor`
--
ALTER TABLE `master_mandor`
  ADD PRIMARY KEY (`id_mandor`);

--
-- Indexes for table `master_material`
--
ALTER TABLE `master_material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_produk`
--
ALTER TABLE `master_produk`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `master_produk_kategori`
--
ALTER TABLE `master_produk_kategori`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `master_produk_unit`
--
ALTER TABLE `master_produk_unit`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `master_proyek`
--
ALTER TABLE `master_proyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `master_proyek_kavling`
--
ALTER TABLE `master_proyek_kavling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyek_id` (`proyek_id`);

--
-- Indexes for table `master_supplier`
--
ALTER TABLE `master_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `menu_access`
--
ALTER TABLE `menu_access`
  ADD PRIMARY KEY (`id_access`);

--
-- Indexes for table `nota_material`
--
ALTER TABLE `nota_material`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indexes for table `pak`
--
ALTER TABLE `pak`
  ADD PRIMARY KEY (`id_pak`);

--
-- Indexes for table `pemasukan_lain`
--
ALTER TABLE `pemasukan_lain`
  ADD PRIMARY KEY (`id_pemasukan`);

--
-- Indexes for table `pembatalan_transaksi`
--
ALTER TABLE `pembatalan_transaksi`
  ADD PRIMARY KEY (`id_pembatalan`);

--
-- Indexes for table `pembebasan_lahan`
--
ALTER TABLE `pembebasan_lahan`
  ADD PRIMARY KEY (`id_pembebasan`);

--
-- Indexes for table `pengajuan_material`
--
ALTER TABLE `pengajuan_material`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indexes for table `pengeluaran_lain`
--
ALTER TABLE `pengeluaran_lain`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `piutang_bank`
--
ALTER TABLE `piutang_bank`
  ADD PRIMARY KEY (`id_piutang`);

--
-- Indexes for table `progres_pembangunan`
--
ALTER TABLE `progres_pembangunan`
  ADD PRIMARY KEY (`id_progres`);

--
-- Indexes for table `rab_detail`
--
ALTER TABLE `rab_detail`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rab_master`
--
ALTER TABLE `rab_master`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rek_bank`
--
ALTER TABLE `rek_bank`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indexes for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id_sertifikat`);

--
-- Indexes for table `stok_in_out`
--
ALTER TABLE `stok_in_out`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `stok_tipe`
--
ALTER TABLE `stok_tipe`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `store_profile`
--
ALTER TABLE `store_profile`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `sub_kode`
--
ALTER TABLE `sub_kode`
  ADD PRIMARY KEY (`id_sub`);

--
-- Indexes for table `tanda_jadi_lokasi`
--
ALTER TABLE `tanda_jadi_lokasi`
  ADD PRIMARY KEY (`id_tjl`);

--
-- Indexes for table `tanda_jadi_lokasi_inhouse`
--
ALTER TABLE `tanda_jadi_lokasi_inhouse`
  ADD PRIMARY KEY (`id_tjl`);

--
-- Indexes for table `tbl_blok`
--
ALTER TABLE `tbl_blok`
  ADD PRIMARY KEY (`id_blok`),
  ADD UNIQUE KEY `id_blok` (`id_blok`);

--
-- Indexes for table `tbl_cluster`
--
ALTER TABLE `tbl_cluster`
  ADD PRIMARY KEY (`id_cluster`);

--
-- Indexes for table `tbl_kavling`
--
ALTER TABLE `tbl_kavling`
  ADD PRIMARY KEY (`id_kavling`);

--
-- Indexes for table `tbl_marketing`
--
ALTER TABLE `tbl_marketing`
  ADD PRIMARY KEY (`id_marketing`);

--
-- Indexes for table `tbl_max_material`
--
ALTER TABLE `tbl_max_material`
  ADD PRIMARY KEY (`id_max`);

--
-- Indexes for table `tbl_pasangan`
--
ALTER TABLE `tbl_pasangan`
  ADD PRIMARY KEY (`id_pasangan`);

--
-- Indexes for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `tbl_perumahan`
--
ALTER TABLE `tbl_perumahan`
  ADD PRIMARY KEY (`id_perumahan`);

--
-- Indexes for table `tbl_proyek_insidentil`
--
ALTER TABLE `tbl_proyek_insidentil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_proyek_lainnya`
--
ALTER TABLE `tbl_proyek_lainnya`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyek_id` (`proyek_id`);

--
-- Indexes for table `tbl_proyek_material`
--
ALTER TABLE `tbl_proyek_material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyek_id` (`proyek_id`),
  ADD KEY `kavling_id` (`tipe_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `tbl_proyek_upah`
--
ALTER TABLE `tbl_proyek_upah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyek_id` (`proyek_id`),
  ADD KEY `kavling_id` (`tipe_id`);

--
-- Indexes for table `tbl_tipe`
--
ALTER TABLE `tbl_tipe`
  ADD PRIMARY KEY (`id_tipe`);

--
-- Indexes for table `tbl_transaksi_bank`
--
ALTER TABLE `tbl_transaksi_bank`
  ADD PRIMARY KEY (`id_transaksi_bank`);

--
-- Indexes for table `tbl_transaksi_inhouse`
--
ALTER TABLE `tbl_transaksi_inhouse`
  ADD PRIMARY KEY (`id_inhouse`);

--
-- Indexes for table `title_kode`
--
ALTER TABLE `title_kode`
  ADD PRIMARY KEY (`id_title`);

--
-- Indexes for table `uang_muka`
--
ALTER TABLE `uang_muka`
  ADD PRIMARY KEY (`id_um`);

--
-- Indexes for table `uang_muka_inhouse`
--
ALTER TABLE `uang_muka_inhouse`
  ADD PRIMARY KEY (`id_um`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_perumahan`
--
ALTER TABLE `access_perumahan`
  MODIFY `id_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `angsuran_bank`
--
ALTER TABLE `angsuran_bank`
  MODIFY `id_angsur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `approved_history`
--
ALTER TABLE `approved_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `bank_cicil_kt`
--
ALTER TABLE `bank_cicil_kt`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_cicil_lain`
--
ALTER TABLE `bank_cicil_lain`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_cicil_pak`
--
ALTER TABLE `bank_cicil_pak`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_cicil_pb`
--
ALTER TABLE `bank_cicil_pb`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_cicil_rb`
--
ALTER TABLE `bank_cicil_rb`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_cicil_tj`
--
ALTER TABLE `bank_cicil_tj`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_cicil_tjl`
--
ALTER TABLE `bank_cicil_tjl`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bank_cicil_um`
--
ALTER TABLE `bank_cicil_um`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `berkas_konsumen`
--
ALTER TABLE `berkas_konsumen`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `bukti_spkb`
--
ALTER TABLE `bukti_spkb`
  MODIFY `id_bukti_spkb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bukti_spr`
--
ALTER TABLE `bukti_spr`
  MODIFY `id_bukti_spr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cicil_fee_marketing`
--
ALTER TABLE `cicil_fee_marketing`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cicil_insidentil`
--
ALTER TABLE `cicil_insidentil`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cicil_kas`
--
ALTER TABLE `cicil_kas`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cicil_material`
--
ALTER TABLE `cicil_material`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cicil_pembatalan`
--
ALTER TABLE `cicil_pembatalan`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cicil_pembebasan_lahan`
--
ALTER TABLE `cicil_pembebasan_lahan`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cicil_pengeluaran_lain`
--
ALTER TABLE `cicil_pengeluaran_lain`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cicil_progres`
--
ALTER TABLE `cicil_progres`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `db_group`
--
ALTER TABLE `db_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `db_module`
--
ALTER TABLE `db_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `db_status`
--
ALTER TABLE `db_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `db_user`
--
ALTER TABLE `db_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `db_user_history_login`
--
ALTER TABLE `db_user_history_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=691;

--
-- AUTO_INCREMENT for table `harga_kesepakatan_inhouse`
--
ALTER TABLE `harga_kesepakatan_inhouse`
  MODIFY `id_kesepakatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- AUTO_INCREMENT for table `inhouse_cicil_hk`
--
ALTER TABLE `inhouse_cicil_hk`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inhouse_cicil_kt`
--
ALTER TABLE `inhouse_cicil_kt`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inhouse_cicil_tj`
--
ALTER TABLE `inhouse_cicil_tj`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inhouse_cicil_tjl`
--
ALTER TABLE `inhouse_cicil_tjl`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inhouse_cicil_um`
--
ALTER TABLE `inhouse_cicil_um`
  MODIFY `id_cicil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kas_operasional`
--
ALTER TABLE `kas_operasional`
  MODIFY `id_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelebihan_tanah`
--
ALTER TABLE `kelebihan_tanah`
  MODIFY `id_kt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `kelebihan_tanah_inhouse`
--
ALTER TABLE `kelebihan_tanah_inhouse`
  MODIFY `id_kt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `kode`
--
ALTER TABLE `kode`
  MODIFY `id_kode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lain_lain`
--
ALTER TABLE `lain_lain`
  MODIFY `id_lain` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `laporan_keuangan_kategori_induk`
--
ALTER TABLE `laporan_keuangan_kategori_induk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `laporan_keuangan_kategori_transaksi`
--
ALTER TABLE `laporan_keuangan_kategori_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `laporan_keuangan_tipe`
--
ALTER TABLE `laporan_keuangan_tipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `logistik_stok`
--
ALTER TABLE `logistik_stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `mandor_proyek`
--
ALTER TABLE `mandor_proyek`
  MODIFY `id_mandor_proyek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_logistik`
--
ALTER TABLE `master_logistik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `master_logistik_detail`
--
ALTER TABLE `master_logistik_detail`
  MODIFY `id_logistik_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `master_logistik_keluar`
--
ALTER TABLE `master_logistik_keluar`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `master_logistik_masuk`
--
ALTER TABLE `master_logistik_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `master_mandor`
--
ALTER TABLE `master_mandor`
  MODIFY `id_mandor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_material`
--
ALTER TABLE `master_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `master_produk`
--
ALTER TABLE `master_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `master_produk_kategori`
--
ALTER TABLE `master_produk_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `master_produk_unit`
--
ALTER TABLE `master_produk_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `master_proyek`
--
ALTER TABLE `master_proyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `master_proyek_kavling`
--
ALTER TABLE `master_proyek_kavling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT for table `master_supplier`
--
ALTER TABLE `master_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `menu_access`
--
ALTER TABLE `menu_access`
  MODIFY `id_access` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `nota_material`
--
ALTER TABLE `nota_material`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pak`
--
ALTER TABLE `pak`
  MODIFY `id_pak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `pemasukan_lain`
--
ALTER TABLE `pemasukan_lain`
  MODIFY `id_pemasukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pembatalan_transaksi`
--
ALTER TABLE `pembatalan_transaksi`
  MODIFY `id_pembatalan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembebasan_lahan`
--
ALTER TABLE `pembebasan_lahan`
  MODIFY `id_pembebasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pengajuan_material`
--
ALTER TABLE `pengajuan_material`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pengeluaran_lain`
--
ALTER TABLE `pengeluaran_lain`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `piutang_bank`
--
ALTER TABLE `piutang_bank`
  MODIFY `id_piutang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `progres_pembangunan`
--
ALTER TABLE `progres_pembangunan`
  MODIFY `id_progres` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `rab_detail`
--
ALTER TABLE `rab_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `rab_master`
--
ALTER TABLE `rab_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rek_bank`
--
ALTER TABLE `rek_bank`
  MODIFY `id_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id_sertifikat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stok_in_out`
--
ALTER TABLE `stok_in_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stok_tipe`
--
ALTER TABLE `stok_tipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_profile`
--
ALTER TABLE `store_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_kode`
--
ALTER TABLE `sub_kode`
  MODIFY `id_sub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tanda_jadi_lokasi`
--
ALTER TABLE `tanda_jadi_lokasi`
  MODIFY `id_tjl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tanda_jadi_lokasi_inhouse`
--
ALTER TABLE `tanda_jadi_lokasi_inhouse`
  MODIFY `id_tjl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `tbl_cluster`
--
ALTER TABLE `tbl_cluster`
  MODIFY `id_cluster` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_kavling`
--
ALTER TABLE `tbl_kavling`
  MODIFY `id_kavling` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_marketing`
--
ALTER TABLE `tbl_marketing`
  MODIFY `id_marketing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_max_material`
--
ALTER TABLE `tbl_max_material`
  MODIFY `id_max` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_pasangan`
--
ALTER TABLE `tbl_pasangan`
  MODIFY `id_pasangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_perumahan`
--
ALTER TABLE `tbl_perumahan`
  MODIFY `id_perumahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_proyek_insidentil`
--
ALTER TABLE `tbl_proyek_insidentil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_proyek_lainnya`
--
ALTER TABLE `tbl_proyek_lainnya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tbl_proyek_material`
--
ALTER TABLE `tbl_proyek_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `tbl_proyek_upah`
--
ALTER TABLE `tbl_proyek_upah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tbl_tipe`
--
ALTER TABLE `tbl_tipe`
  MODIFY `id_tipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_transaksi_bank`
--
ALTER TABLE `tbl_transaksi_bank`
  MODIFY `id_transaksi_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_transaksi_inhouse`
--
ALTER TABLE `tbl_transaksi_inhouse`
  MODIFY `id_inhouse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `title_kode`
--
ALTER TABLE `title_kode`
  MODIFY `id_title` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `uang_muka`
--
ALTER TABLE `uang_muka`
  MODIFY `id_um` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `uang_muka_inhouse`
--
ALTER TABLE `uang_muka_inhouse`
  MODIFY `id_um` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_logistik_masuk`
--
ALTER TABLE `master_logistik_masuk`
  ADD CONSTRAINT `master_logistik_masuk_ibfk_1` FOREIGN KEY (`logistik_id`) REFERENCES `master_logistik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_proyek_kavling`
--
ALTER TABLE `master_proyek_kavling`
  ADD CONSTRAINT `master_proyek_kavling_ibfk_1` FOREIGN KEY (`proyek_id`) REFERENCES `master_proyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_proyek_lainnya`
--
ALTER TABLE `tbl_proyek_lainnya`
  ADD CONSTRAINT `tbl_proyek_lainnya_ibfk_1` FOREIGN KEY (`proyek_id`) REFERENCES `master_proyek` (`id`);

--
-- Constraints for table `tbl_proyek_material`
--
ALTER TABLE `tbl_proyek_material`
  ADD CONSTRAINT `tbl_proyek_material_ibfk_1` FOREIGN KEY (`proyek_id`) REFERENCES `master_proyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_proyek_upah`
--
ALTER TABLE `tbl_proyek_upah`
  ADD CONSTRAINT `tbl_proyek_upah_ibfk_1` FOREIGN KEY (`proyek_id`) REFERENCES `master_proyek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
