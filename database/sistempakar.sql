-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2021 at 03:51 PM
-- Server version: 8.0.18
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistempakar`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `kode_akun` int(11) NOT NULL,
  `nama_lengkap` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipe_akun` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`kode_akun`, `nama_lengkap`, `username`, `password`, `tipe_akun`) VALUES
(1, 'Admin Sistem', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(3, 'User', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(7, 'User 2', 'user2', '7e58d63b60197ceb55a1c487989a3720', 0);

-- --------------------------------------------------------

--
-- Table structure for table `aturan`
--

CREATE TABLE `aturan` (
  `kode_rule` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_penyakit` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_ikan` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aturan`
--

INSERT INTO `aturan` (`kode_rule`, `kode_penyakit`, `kode_ikan`) VALUES
('RA01', 'PA01', 'I01'),
('RA02', 'PA02', 'I01'),
('RA03', 'PA03', 'I01'),
('RA04', 'PA04', 'I01'),
('RA05', 'PA05', 'I01'),
('RA06', 'PA06', 'I01'),
('RA07', 'PA07', 'I01'),
('RC01', 'PC01', 'I02'),
('RC02', 'PC02', 'I02'),
('RC03', 'PC03', 'I02'),
('RC04', 'PC04', 'I02'),
('RC05', 'PC05', 'I02'),
('RC06', 'PC06', 'I02');

-- --------------------------------------------------------

--
-- Table structure for table `detail_aturan`
--

CREATE TABLE `detail_aturan` (
  `kode_rule` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_gejala` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_aturan`
--

INSERT INTO `detail_aturan` (`kode_rule`, `kode_gejala`) VALUES
('RA03', 'GA08'),
('RA03', 'GA09'),
('RA02', 'GA03'),
('RA02', 'GA05'),
('RA02', 'GA06'),
('RA02', 'GA07'),
('RA04', 'GA10'),
('RA05', 'GA11'),
('RA05', 'GA12'),
('RA07', 'GA13'),
('RC01', 'GC01'),
('RC01', 'GC02'),
('RC01', 'GC03'),
('RC02', 'GC04'),
('RC02', 'GC05'),
('RC02', 'GC08'),
('RC03', 'GC01'),
('RC03', 'GC06'),
('RC03', 'GC07'),
('RC03', 'GC08'),
('RC04', 'GC09'),
('RC04', 'GC10'),
('RC05', 'GC11'),
('RC05', 'GC12'),
('RC06', 'GC12'),
('RA06', 'GA11'),
('RA06', 'GA12'),
('RA01', 'GA01'),
('RA01', 'GA02'),
('RA01', 'GA03'),
('RA01', 'GA04'),
('RR01', 'GA01'),
('RR01', 'GA03'),
('RR01', 'GA04'),
('RR01', 'GA09');

-- --------------------------------------------------------

--
-- Table structure for table `detail_diagnosa_gejala`
--

CREATE TABLE `detail_diagnosa_gejala` (
  `kode_detail_gejala` int(11) NOT NULL,
  `kode_diagnosa` int(11) NOT NULL,
  `kode_gejala` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_diagnosa_gejala`
--

INSERT INTO `detail_diagnosa_gejala` (`kode_detail_gejala`, `kode_diagnosa`, `kode_gejala`) VALUES
(1, 1, 'GA01'),
(2, 1, 'GA02'),
(3, 1, 'GA03'),
(4, 1, 'GA06'),
(5, 2, 'GA01'),
(6, 2, 'GA02'),
(7, 2, 'GA03'),
(8, 3, 'GC04'),
(9, 3, 'GC06'),
(10, 3, 'GC07');

-- --------------------------------------------------------

--
-- Table structure for table `detail_diagnosa_penyakit`
--

CREATE TABLE `detail_diagnosa_penyakit` (
  `kode_detail_penyakit` int(11) NOT NULL,
  `kode_diagnosa` int(11) NOT NULL,
  `kode_penyakit` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `persentase` double(3,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_diagnosa_penyakit`
--

INSERT INTO `detail_diagnosa_penyakit` (`kode_detail_penyakit`, `kode_diagnosa`, `kode_penyakit`, `persentase`) VALUES
(1, 1, 'PA01', 75),
(2, 1, 'PA02', 50),
(3, 1, 'PA03', 0),
(4, 1, 'PA04', 0),
(5, 1, 'PA05', 0),
(6, 1, 'PA06', 0),
(7, 1, 'PA07', 0),
(8, 2, 'PA01', 75),
(9, 2, 'PA02', 25),
(10, 2, 'PA03', 0),
(11, 2, 'PA04', 0),
(12, 2, 'PA05', 0),
(13, 2, 'PA06', 0),
(14, 2, 'PA07', 0),
(15, 3, 'PC03', 50),
(16, 3, 'PC02', 33),
(17, 3, 'PC01', 0),
(18, 3, 'PC04', 0),
(19, 3, 'PC05', 0),
(20, 3, 'PC06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `diagnosa`
--

CREATE TABLE `diagnosa` (
  `kode_diagnosa` int(11) NOT NULL,
  `kode_ikan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kode_akun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnosa`
--

INSERT INTO `diagnosa` (`kode_diagnosa`, `kode_ikan`, `tanggal`, `kode_akun`) VALUES
(1, 'I01', '2021-07-22 07:30:11', NULL),
(2, 'I01', '2021-07-23 14:39:31', 3),
(3, 'I02', '2021-07-23 14:41:18', 7);

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `kode_gejala` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gejala` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_ikan` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`kode_gejala`, `gejala`, `kode_ikan`) VALUES
('GA01', 'Sisik ada bercak hitam', 'I01'),
('GA02', 'Ikan parkir atau kurang aktif', 'I01'),
('GA03', 'Nafsu makan berkurang', 'I01'),
('GA04', 'Sisik mengembang seperti nanas', 'I01'),
('GA05', 'Gaya renang tidak sejajar', 'I01'),
('GA06', 'Perut buncit', 'I01'),
('GA07', 'Kepala kebawah badan', 'I01'),
('GA08', 'Kemerahan di sekitar anus', 'I01'),
('GA09', 'Sulit pup', 'I01'),
('GA10', 'Mata turun', 'I01'),
('GA11', 'Ikan menggesekkan badan ke aquarium', 'I01'),
('GA12', 'Bercak hitam di sisik atas', 'I01'),
('GA13', 'Ingsang mulai membuka', 'I01'),
('GC01', 'Nafsu makan berkurang', 'I02'),
('GC02', 'Warna ikan terlihat pucat', 'I02'),
('GC03', 'Sirip dan ekor menguncup', 'I02'),
('GC04', 'Warna Kemerahan pada sirip', 'I02'),
('GC05', 'Sirip sobek dan rontok', 'I02'),
('GC06', 'Gerakan ikan pasif', 'I02'),
('GC07', 'Sirip menguncup', 'I02'),
('GC08', 'Warna memudar', 'I02'),
('GC09', 'Perut membesar', 'I02'),
('GC10', 'Sisik mengembang seperti nanas', 'I02'),
('GC11', 'Warna insang cupang terlihat merah', 'I02'),
('GC12', 'Insang tidak tertutup', 'I02'),
('GC13', 'Pup mencair', 'I02'),
('GK01', 'Mata berkabut', 'I03'),
('GK010', 'Perut membengkak.', 'I03'),
('GK011', 'Produksi lendir berlebih', 'I03'),
('GK012', 'Mata menonjol', 'I03'),
('GK013', 'Badan ikan kurus', 'I03'),
('GK014', 'Tulang sirip dan ekor ikan menjadi buram', 'I03'),
('GK015', 'Sirip dan ekor mulai membusuk', 'I03'),
('GK02', 'Terdapat cacing yang menempel pada tubuh', 'I03'),
('GK03', 'Menurunya kekebalan tubuh / lemas', 'I03'),
('GK04', 'Sering menggesekkan tubuh pada dinding', 'I03'),
('GK05', 'Terdapat bintik-bintik hitam (bukan corak)', 'I03'),
('GK06', 'Terdapat bintik-bintik putih (bukan corak)', 'I03'),
('GK07', 'Sisik yang mulai tanggal dari badan ikan', 'I03'),
('GK08', 'Badan gembur', 'I03'),
('GK09', 'Kesulitan dalam berenang', 'I03');

-- --------------------------------------------------------

--
-- Table structure for table `ikan`
--

CREATE TABLE `ikan` (
  `kode_ikan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_ikan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ikan`
--

INSERT INTO `ikan` (`kode_ikan`, `nama_ikan`, `photo`, `deskripsi`) VALUES
('I01', 'Arwana', '1626881079-arwana.jpeg', 'Spesies ikan air tawar dari Asia Tenggara. Ikan ini memiliki badan yang panjang; sirip dubur terletak jauh di belakang badan.'),
('I02', 'Cupang', '1626881359-cupang.JPG', 'ikan air tawar yang habitat asalnya adalah beberapa negara di Asia Tenggara'),
('I03', 'Koi', '1626881373-koi.jpeg', 'koi berasal dari bahasa Jepang yang berarti ikan karper. Di Jepang, koi menjadi semacam simbol cinta dan persahabatan');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `kode_penyakit` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_penyakit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penanganan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `kode_ikan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`kode_penyakit`, `nama_penyakit`, `penanganan`, `kode_ikan`) VALUES
('PA01', 'Kembang Sisik', '<ol><li><b>Kalo masih gejala awal cukup, </b></li><li>Pasang heater di set 32° + garam ikan</li></ol>', 'I01'),
('PA02', 'Kembung', 'Air larutan jahe. \nSetting ketinggian air 2x tinggi badan ikan. \nKasih arus', 'I01'),
('PA03', 'Ambien', 'Beri pakan cacing tanah. \nSampai bengkak hilang.', 'I01'),
('PA04', 'Drop Eye', 'Operasi Manual.\nIkan d bius. \nLalu di ambil selaput putih bagian dalam atas matanya', 'I01'),
('PA05', 'Jamur', 'Cukup heater + garam ikan. \nObat ikan pomate.', 'I01'),
('PA06', 'Sisik Lepas', 'Cukup heater + garam ikan. \nObat ikan pomate.', 'I01'),
('PA07', 'Ingsang Nglipat', 'Ganti air aqua.\nPasang heater di set -+32° + Garam ikan.', 'I01'),
('PC01', 'White Spot', 'Lakukan karantina Bersihkan terminal dan ganti airnya Tambahkan obat biru dan garam Biasakan ikan terkena sinar matahari', 'I02'),
('PC02', 'Sirip Busuk', 'Ganti air baru Beri antibiotik dan garam khusus ikan', 'I02'),
('PC03', 'Pop Eye', 'Lakukan karantina Berikan antibiotik dan garam ikan Ganti air setiap 3 hari sekali', 'I02'),
('PC04', 'Dropsy', 'Ganti air baru tambahkan Tetra Chlor secukupnya dan antibiotik', 'I02'),
('PC05', 'Insang Merah', 'Ganti air setiap 2 hari sekali Beri Methylene Blue dan garam ikan', 'I02'),
('PC06', 'Berak Putih', 'Ganti air baru beri Acryflavine/Worm X/Verminox', 'I02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`kode_akun`) USING BTREE;

--
-- Indexes for table `aturan`
--
ALTER TABLE `aturan`
  ADD PRIMARY KEY (`kode_rule`),
  ADD KEY `kode_penyakit` (`kode_penyakit`);

--
-- Indexes for table `detail_aturan`
--
ALTER TABLE `detail_aturan`
  ADD KEY `kode_gejala` (`kode_gejala`);

--
-- Indexes for table `detail_diagnosa_gejala`
--
ALTER TABLE `detail_diagnosa_gejala`
  ADD PRIMARY KEY (`kode_detail_gejala`) USING BTREE,
  ADD KEY `id_diagnosa` (`kode_diagnosa`),
  ADD KEY `id_gejala` (`kode_gejala`);

--
-- Indexes for table `detail_diagnosa_penyakit`
--
ALTER TABLE `detail_diagnosa_penyakit`
  ADD PRIMARY KEY (`kode_detail_penyakit`) USING BTREE,
  ADD KEY `id_diagnosa` (`kode_diagnosa`),
  ADD KEY `kode_penyakit` (`kode_penyakit`);

--
-- Indexes for table `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD PRIMARY KEY (`kode_diagnosa`) USING BTREE,
  ADD KEY `kode_ikan` (`kode_ikan`),
  ADD KEY `kode_akun` (`kode_akun`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`kode_gejala`) USING BTREE,
  ADD KEY `kode_ikan` (`kode_ikan`);

--
-- Indexes for table `ikan`
--
ALTER TABLE `ikan`
  ADD PRIMARY KEY (`kode_ikan`) USING BTREE;

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD KEY `id_penyakit` (`kode_penyakit`),
  ADD KEY `kode_ikan` (`kode_ikan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `kode_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_diagnosa_gejala`
--
ALTER TABLE `detail_diagnosa_gejala`
  MODIFY `kode_detail_gejala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detail_diagnosa_penyakit`
--
ALTER TABLE `detail_diagnosa_penyakit`
  MODIFY `kode_detail_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `diagnosa`
--
ALTER TABLE `diagnosa`
  MODIFY `kode_diagnosa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aturan`
--
ALTER TABLE `aturan`
  ADD CONSTRAINT `aturan_ibfk_1` FOREIGN KEY (`kode_penyakit`) REFERENCES `penyakit` (`kode_penyakit`);

--
-- Constraints for table `detail_aturan`
--
ALTER TABLE `detail_aturan`
  ADD CONSTRAINT `detail_aturan_ibfk_2` FOREIGN KEY (`kode_gejala`) REFERENCES `gejala` (`kode_gejala`);

--
-- Constraints for table `detail_diagnosa_gejala`
--
ALTER TABLE `detail_diagnosa_gejala`
  ADD CONSTRAINT `detail_diagnosa_gejala_ibfk_1` FOREIGN KEY (`kode_diagnosa`) REFERENCES `diagnosa` (`kode_diagnosa`),
  ADD CONSTRAINT `detail_diagnosa_gejala_ibfk_2` FOREIGN KEY (`kode_gejala`) REFERENCES `gejala` (`kode_gejala`);

--
-- Constraints for table `detail_diagnosa_penyakit`
--
ALTER TABLE `detail_diagnosa_penyakit`
  ADD CONSTRAINT `detail_diagnosa_penyakit_ibfk_1` FOREIGN KEY (`kode_diagnosa`) REFERENCES `diagnosa` (`kode_diagnosa`),
  ADD CONSTRAINT `detail_diagnosa_penyakit_ibfk_2` FOREIGN KEY (`kode_penyakit`) REFERENCES `penyakit` (`kode_penyakit`);

--
-- Constraints for table `diagnosa`
--
ALTER TABLE `diagnosa`
  ADD CONSTRAINT `diagnosa_ibfk_1` FOREIGN KEY (`kode_ikan`) REFERENCES `ikan` (`kode_ikan`),
  ADD CONSTRAINT `diagnosa_ibfk_2` FOREIGN KEY (`kode_akun`) REFERENCES `akun` (`kode_akun`);

--
-- Constraints for table `gejala`
--
ALTER TABLE `gejala`
  ADD CONSTRAINT `gejala_ibfk_1` FOREIGN KEY (`kode_ikan`) REFERENCES `ikan` (`kode_ikan`);

--
-- Constraints for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD CONSTRAINT `penyakit_ibfk_1` FOREIGN KEY (`kode_ikan`) REFERENCES `ikan` (`kode_ikan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
