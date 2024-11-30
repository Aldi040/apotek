-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 06:34 PM
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
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `ID_OBAT` int(11) NOT NULL,
  `NAMA_OBAT` varchar(50) NOT NULL,
  `KATREGORI` varchar(100) DEFAULT NULL,
  `KETERANGAN` varchar(10000) NOT NULL,
  `JUMLAH_STOCK` int(11) NOT NULL DEFAULT 0,
  `HARGA` decimal(10,2) NOT NULL,
  `EXP` date DEFAULT NULL,
  `ID_SUPPLIER` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`ID_OBAT`, `NAMA_OBAT`, `KATREGORI`, `KETERANGAN`, `JUMLAH_STOCK`, `HARGA`, `EXP`, `ID_SUPPLIER`) VALUES
(1, 'Paracetamol', 'Painkiller', '', 100, 5000.00, '2025-12-31', 1),
(2, 'Aspirin', 'Painkiller', '', 50, 3000.00, '2024-12-31', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` int(11) NOT NULL,
  `NAMA_PELANGGAN` varchar(60) NOT NULL,
  `JENIS_KELAMIN` enum('Laki-Laki','Perempuan') NOT NULL,
  `ALAMAT` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `JENIS_KELAMIN`, `ALAMAT`) VALUES
(1, 'John Doe', 'Laki-Laki', ''),
(2, 'Jane Smith', 'Laki-Laki', ''),
(3, 'Budi Santoso', 'Laki-Laki', ''),
(4, 'fathan', 'Laki-Laki', 'Indonesia 1');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_obat`
--

CREATE TABLE `pembelian_obat` (
  `ID_PELANGGAN` int(11) NOT NULL,
  `ID_OBAT` int(11) NOT NULL,
  `QTY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_obat`
--

INSERT INTO `pembelian_obat` (`ID_PELANGGAN`, `ID_OBAT`, `QTY`) VALUES
(4, 1, 1),
(4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `ID_SUPPLIER` int(11) NOT NULL,
  `NAMA_SUPPLIER` varchar(100) NOT NULL,
  `ALAMAT_SUPPLIER` varchar(255) DEFAULT NULL,
  `TELEPON_SUPPLIER` varchar(20) DEFAULT NULL,
  `EMAIL_SUPPLIER` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`ID_SUPPLIER`, `NAMA_SUPPLIER`, `ALAMAT_SUPPLIER`, `TELEPON_SUPPLIER`, `EMAIL_SUPPLIER`) VALUES
(1, 'PT. Sehat Pharmacy', 'Jl. Sehat No. 10, Jakarta', '021-12345678', 'info@sehatpharmacy.com'),
(2, 'CV. Farma Sehat', 'Jl. Farma No. 5, Bandung', '022-87654321', 'contact@farmasehat.com');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_TRANSAKSI` int(11) NOT NULL,
  `ID_PELANGGAN` int(11) DEFAULT NULL,
  `TANGGAL_TRANSAKSI` date DEFAULT NULL,
  `JUMLAH_TRANSAKSI` int(11) DEFAULT NULL,
  `TOTAL_HARGA` decimal(10,2) DEFAULT NULL,
  `METODE_PEMBAYARAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`ID_TRANSAKSI`, `ID_PELANGGAN`, `TANGGAL_TRANSAKSI`, `JUMLAH_TRANSAKSI`, `TOTAL_HARGA`, `METODE_PEMBAYARAN`) VALUES
(1, 1, '2024-11-01', 2, 10000.00, 'Cash'),
(2, 2, '2024-11-02', 1, 3000.00, 'Credit Card'),
(3, 3, '2024-11-03', 5, 15000.00, 'Transfer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`ID_OBAT`),
  ADD KEY `ID_SUPPLIER` (`ID_SUPPLIER`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`);

--
-- Indexes for table `pembelian_obat`
--
ALTER TABLE `pembelian_obat`
  ADD KEY `ID_OBAT` (`ID_OBAT`),
  ADD KEY `ID_PELANGGAN` (`ID_PELANGGAN`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`ID_SUPPLIER`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`ID_TRANSAKSI`),
  ADD KEY `ID_PELANGGAN` (`ID_PELANGGAN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `ID_OBAT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_PELANGGAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `ID_SUPPLIER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `ID_TRANSAKSI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_ibfk_1` FOREIGN KEY (`ID_SUPPLIER`) REFERENCES `supplier` (`ID_SUPPLIER`);

--
-- Constraints for table `pembelian_obat`
--
ALTER TABLE `pembelian_obat`
  ADD CONSTRAINT `pembelian_obat_ibfk_1` FOREIGN KEY (`ID_OBAT`) REFERENCES `obat` (`ID_OBAT`),
  ADD CONSTRAINT `pembelian_obat_ibfk_2` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
