-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2021 at 01:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ta_zulfikar`
--

-- --------------------------------------------------------

--
-- Table structure for table `ta_absensi`
--

CREATE TABLE `ta_absensi` (
  `ID_ABSENSI` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `TGL_ABSEN` varchar(125) NOT NULL,
  `JAM_MASUK` varchar(30) NOT NULL,
  `JAM_PULANG` varchar(30) NOT NULL,
  `STATUS_USER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ta_absensi`
--

INSERT INTO `ta_absensi` (`ID_ABSENSI`, `USER_ID`, `TGL_ABSEN`, `JAM_MASUK`, `JAM_PULANG`, `STATUS_USER`) VALUES
(13, 1, 'Rabu, 18 Agustus 2021', '15:39:29', '16:38:44', 2),
(17, 5, 'Rabu, 18 Agustus 2021', '18:49:14', '19:37:37', 2),
(19, 1, 'Kamis, 19 Agustus 2021', '09:15:14', '16:38:44', 1),
(20, 5, 'Kamis, 19 Agustus 2021', '11:21:23', '-', 2),
(21, 1, 'Selasa, 21 September 2021', '09:26:07', '16:38:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ta_foto_user`
--

CREATE TABLE `ta_foto_user` (
  `ID_FOTO_USER` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `FOTO1` varchar(500) DEFAULT NULL,
  `FOTO2` varchar(500) DEFAULT NULL,
  `FOTO3` varchar(500) DEFAULT NULL,
  `LENGKAP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ta_foto_user`
--

INSERT INTO `ta_foto_user` (`ID_FOTO_USER`, `USER_ID`, `FOTO1`, `FOTO2`, `FOTO3`, `LENGKAP`) VALUES
(4, 1, '1.jpg', '2.jpg', '3.jpg', 1),
(5, 2, '1.jpg', '2.jpg', '3.jpg', 1),
(6, 3, '1.jpg', NULL, NULL, 0),
(7, 4, '1.jpg', '2.jpg', '3.jpg', 1),
(8, 5, '1.jpg', '2.jpg', '3.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ta_setting`
--

CREATE TABLE `ta_setting` (
  `ID_SETTING` int(11) NOT NULL,
  `NAMA_APP` varchar(20) NOT NULL,
  `ABSEN_MULAI` varchar(30) NOT NULL,
  `ABSEN_MULAI_SAMPAI` varchar(30) NOT NULL,
  `ABSEN_VALID` varchar(30) NOT NULL,
  `ABSEN_PULANG` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ta_setting`
--

INSERT INTO `ta_setting` (`ID_SETTING`, `NAMA_APP`, `ABSEN_MULAI`, `ABSEN_MULAI_SAMPAI`, `ABSEN_VALID`, `ABSEN_PULANG`) VALUES
(1, 'TA ZULFIKAR', '06:00:00', '10:00:00', '12:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ta_user`
--

CREATE TABLE `ta_user` (
  `ID_USER` int(11) NOT NULL,
  `NAMA_DEPAN` varchar(125) NOT NULL,
  `NAMA_BELAKANG` varchar(125) NOT NULL,
  `TANGGAL_LAHIR` varchar(50) NOT NULL,
  `TEMPAT_LAHIR` varchar(50) NOT NULL,
  `JENIS_KELAMIN` varchar(20) NOT NULL,
  `STATUS_PERNIKAHAN` varchar(20) NOT NULL,
  `ALAMAT` varchar(100) NOT NULL,
  `ALAMAT2` varchar(100) DEFAULT NULL,
  `KODE_POS` varchar(80) NOT NULL,
  `KOTA` varchar(80) NOT NULL,
  `PROVINSI` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ta_user`
--

INSERT INTO `ta_user` (`ID_USER`, `NAMA_DEPAN`, `NAMA_BELAKANG`, `TANGGAL_LAHIR`, `TEMPAT_LAHIR`, `JENIS_KELAMIN`, `STATUS_PERNIKAHAN`, `ALAMAT`, `ALAMAT2`, `KODE_POS`, `KOTA`, `PROVINSI`) VALUES
(1, 'Fahreza', 'Isnanto', '2002-05-10', 'Semarang', 'L', '3', 'Jalan Pandan Wangi II A/80', '-', '50273', 'Semarang', 'Jawa Tengah'),
(5, 'Zulfikar ', 'Isnanto', '1999-11-06', 'Semarang', 'L', '3', 'Jalan Pandan Wangi II A/80', '-', '50273', 'Semarang', 'Jawa Tengah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ta_absensi`
--
ALTER TABLE `ta_absensi`
  ADD PRIMARY KEY (`ID_ABSENSI`,`USER_ID`);

--
-- Indexes for table `ta_foto_user`
--
ALTER TABLE `ta_foto_user`
  ADD PRIMARY KEY (`ID_FOTO_USER`,`USER_ID`);

--
-- Indexes for table `ta_setting`
--
ALTER TABLE `ta_setting`
  ADD PRIMARY KEY (`ID_SETTING`);

--
-- Indexes for table `ta_user`
--
ALTER TABLE `ta_user`
  ADD PRIMARY KEY (`ID_USER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ta_absensi`
--
ALTER TABLE `ta_absensi`
  MODIFY `ID_ABSENSI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ta_foto_user`
--
ALTER TABLE `ta_foto_user`
  MODIFY `ID_FOTO_USER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ta_setting`
--
ALTER TABLE `ta_setting`
  MODIFY `ID_SETTING` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ta_user`
--
ALTER TABLE `ta_user`
  MODIFY `ID_USER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
