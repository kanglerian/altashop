-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2021 at 11:37 AM
-- Server version: 10.2.38-MariaDB-cll-lve
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kans3893_alifashop`
--

-- --------------------------------------------------------

--
-- Table structure for table `det_penjualan`
--

CREATE TABLE `det_penjualan` (
  `id_det_penjualan` int(255) NOT NULL,
  `tgl_chat_masuk` date NOT NULL,
  `id_penjualan` varchar(255) NOT NULL,
  `id_produk` int(250) NOT NULL,
  `no_wa` varchar(25) NOT NULL,
  `chat_masuk` char(150) NOT NULL,
  `closing` char(150) NOT NULL,
  `jumlah` int(250) NOT NULL,
  `keterangan` char(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `det_penjualan`
--

INSERT INTO `det_penjualan` (`id_det_penjualan`, `tgl_chat_masuk`, `id_penjualan`, `id_produk`, `no_wa`, `chat_masuk`, `closing`, `jumlah`, `keterangan`) VALUES
(8, '2021-06-13', 'RECINTAN202106131', 2, '+6288191919', 'Follow Up', 'Transfer', 1, 'Toska - M'),
(10, '2021-06-13', 'RECINTAN202106131', 2, '62814141414', 'Today', 'Transfer', 2, 'Biru - M'),
(14, '2021-06-14', 'RECINTAN202106141', 2, '62812912881', 'Today', 'Transfer', 3, 'Maroon  -  L'),
(17, '2021-06-14', 'RECINTAN202106141', 2, '6281286501015', 'Today', 'Transfer', 2, 'Hijau-L'),
(18, '2021-06-15', 'RECINTAN202106151', 2, '6281286501015', 'Today', 'COD', 5, 'Merah-L'),
(20, '2021-06-15', 'RECINTAN202106151', 2, '6281286501013', 'Follow Up', 'Transfer', 7, 'Ungu-XL'),
(22, '2021-06-17', 'RECINTAN202106171', 2, '6281286501015', 'Today', 'Transfer', 5, 'Ungu - XL'),
(28, '2021-06-18', 'RECINTAN202106181', 2, '', 'Today', 'COD', 2, 'Merah xl,Maroon M'),
(29, '2021-06-18', 'RECINTAN202106181', 3, '', 'Follow Up', 'Transfer', 1, 'Biru M'),
(30, '2021-06-18', 'RECINTAN202106181', 2, '', 'Today', 'COD', 1, 'Biru M'),
(31, '2021-06-22', 'RECINTAN202106221', 2, '', 'Today', 'Transfer', 1, 'Biru M'),
(32, '2021-06-26', 'RECINTAN202106261', 3, '', 'Today', 'COD', 1, 'Biru M'),
(33, '2021-06-27', 'RECINTAN202106271', 2, '', 'Today', 'Transfer', 4, 'Biru M'),
(34, '2021-06-28', 'RECFAISAL202106283', 3, '', 'Today', 'Transfer', 1, 'Biru M'),
(35, '2021-06-28', 'RECFAISAL202106283', 7, '', 'Today', 'Batal', 1, 'Biru M'),
(36, '2021-06-28', 'RECFAISAL202106283', 7, '', 'Today', 'Transfer', 2, 'Merah xl,Maroon M'),
(37, '2021-06-29', 'RECFAISAL202106293', 8, '', 'Today', 'Transfer', 4, 'Biru M'),
(39, '2021-06-29', 'RECFAISAL202106293', 8, '', 'Today', 'Transfer', 2, 'Merah xl,Maroon M'),
(41, '2021-06-29', 'RECFAISAL202106293', 8, '', 'Today', 'Transfer', 1, 'Biru M');

-- --------------------------------------------------------

--
-- Table structure for table `grosir`
--

CREATE TABLE `grosir` (
  `id_grosir` int(250) NOT NULL,
  `id_produk` int(250) NOT NULL,
  `qty` int(250) NOT NULL,
  `harga` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grosir`
--

INSERT INTO `grosir` (`id_grosir`, `id_produk`, `qty`, `harga`) VALUES
(6, 2, 2, 40000),
(7, 7, 2, 65000),
(8, 7, 3, 60000),
(10, 7, 4, 55000),
(11, 2, 3, 35000),
(12, 2, 5, 30000),
(14, 8, 2, 32000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` char(80) NOT NULL,
  `range_harga` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `range_harga`) VALUES
(1, 'Buku', 50000),
(2, 'Hijab', 50000),
(21, 'T-shirt', 0),
(22, 'Elektronik', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` varchar(250) NOT NULL,
  `tgl_rekam` date NOT NULL,
  `id_user` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tgl_rekam`, `id_user`) VALUES
('RECFAISAL202106283', '2021-06-28', 3),
('RECFAISAL202106293', '2021-06-29', 3),
('RECINTAN202106131', '2021-06-13', 1),
('RECINTAN202106141', '2021-06-14', 1),
('RECINTAN202106151', '2021-06-15', 1),
('RECINTAN202106161', '2021-06-16', 1),
('RECINTAN202106171', '2021-06-17', 1),
('RECINTAN202106181', '2021-06-18', 1),
('RECINTAN202106191', '2021-06-19', 1),
('RECINTAN202106201', '2021-06-20', 1),
('RECINTAN202106221', '2021-06-22', 1),
('RECINTAN202106261', '2021-06-26', 1),
('RECINTAN202106271', '2021-06-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` char(250) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `stok` int(25) NOT NULL,
  `harga` int(25) NOT NULL,
  `harga_pokok` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_kategori`, `stok`, `harga`, `harga_pokok`) VALUES
(2, 'Hijab Pashmina', 2, 200, 45000, 35000),
(3, 'Hijab ghaol', 2, 0, 50000, 40000),
(7, 'Hijab Suneo', 2, 0, 70000, 30000),
(8, 'Kaos V-Neck', 21, 0, 35000, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` char(250) NOT NULL,
  `username` char(150) NOT NULL,
  `password` char(150) NOT NULL,
  `status` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `status`) VALUES
(1, 'Intan Pertiwi Sari', 'INTAN001', 'INTAN12345', 'CS'),
(3, 'Faisal S', 'csfaisal', 'csfaisal', 'CS'),
(4, 'Lerian Febriana', 'admin', 'admin', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `det_penjualan`
--
ALTER TABLE `det_penjualan`
  ADD PRIMARY KEY (`id_det_penjualan`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `grosir`
--
ALTER TABLE `grosir`
  ADD PRIMARY KEY (`id_grosir`),
  ADD KEY `id_barang` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `det_penjualan`
--
ALTER TABLE `det_penjualan`
  MODIFY `id_det_penjualan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `grosir`
--
ALTER TABLE `grosir`
  MODIFY `id_grosir` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `det_penjualan`
--
ALTER TABLE `det_penjualan`
  ADD CONSTRAINT `det_penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `det_penjualan_ibfk_2` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`);

--
-- Constraints for table `grosir`
--
ALTER TABLE `grosir`
  ADD CONSTRAINT `grosir_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
