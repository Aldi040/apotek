-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 04:04 PM
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
(2, 'Aspirin', 'Painkiller', '', 50, 3000.00, '2024-12-31', 2),
(3, 'Amoxicillin', 'Antibiotik', 'Antibiotik untuk infeksi bakteri', 150, 25000.00, '2025-06-30', 1),
(4, 'Panadol', 'Analgesik', 'Pereda nyeri dan demam', 200, 15000.00, '2025-08-15', 2),
(5, 'Omeprazole', 'Antasida', 'Obat maag dan asam lambung', 120, 35000.00, '2025-07-20', 1),
(6, 'Simvastatin', 'Kolesterol', 'Penurun kolesterol', 80, 45000.00, '2025-09-10', 2),
(7, 'Metformin', 'Diabetes', 'Pengontrol gula darah', 100, 30000.00, '2025-08-25', 1),
(8, 'Amlodipine', 'Antihipertensi', 'Penurun tekanan darah', 90, 40000.00, '2025-07-15', 2),
(9, 'Cetirizine', 'Antihistamin', 'Obat alergi', 180, 12000.00, '2025-06-20', 1),
(10, 'Vitamin C', 'Vitamin', 'Suplemen daya tahan tubuh', 300, 8000.00, '2025-10-30', 2),
(11, 'Ibuprofen', 'Analgesik', 'Pereda nyeri dan peradangan', 160, 18000.00, '2025-08-05', 1),
(12, 'Lansoprazole', 'Antasida', 'Obat maag', 110, 32000.00, '2025-07-25', 2),
(13, 'Diazepam', 'Antiansietas', 'Penenang dan anti cemas', 70, 50000.00, '2025-06-15', 1),
(14, 'Loratadine', 'Antihistamin', 'Obat alergi non drowsy', 140, 15000.00, '2025-09-20', 2),
(15, 'Metronidazole', 'Antibiotik', 'Antibiotik spektrum luas', 95, 28000.00, '2025-08-10', 1),
(16, 'Captopril', 'Antihipertensi', 'Penurun tekanan darah', 85, 35000.00, '2025-07-30', 2),
(17, 'Vitamin B Complex', 'Vitamin', 'Suplemen vitamin B', 250, 12000.00, '2025-10-15', 1),
(18, 'Clobazam', 'Antiepilepsi', 'Anti kejang', 60, 55000.00, '2025-06-25', 2),
(19, 'Fluoxetine', 'Antidepresan', 'Obat depresi', 75, 48000.00, '2025-09-05', 1),
(20, 'Ranitidine', 'Antasida', 'Obat maag', 130, 25000.00, '2025-08-20', 2),
(21, 'Tramadol', 'Analgesik', 'Pereda nyeri kuat', 65, 42000.00, '2025-07-10', 1),
(22, 'Calcium', 'Mineral', 'Suplemen kalsium', 220, 10000.00, '2025-10-25', 2),
(23, 'Cefadroxil', 'Antibiotik', 'Antibiotik oral', 140, 30000.00, '2025-06-30', 1),
(24, 'Meloxicam', 'Analgesik', 'Anti inflamasi', 110, 38000.00, '2025-09-15', 2),
(25, 'Alprazolam', 'Antiansietas', 'Penenang', 55, 52000.00, '2025-08-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` int(11) NOT NULL,
  `NAMA_PELANGGAN` varchar(60) NOT NULL,
  `JENIS_KELAMIN` enum('Laki-Laki','Perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `JENIS_KELAMIN`) VALUES
(1, 'John Doe', 'Laki-Laki'),
(2, 'Jane Smith', 'Laki-Laki'),
(3, 'Budi Santoso', 'Laki-Laki');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_obat`
--

CREATE TABLE `pembelian_obat` (
  `ID_PELANGGAN` int(11) NOT NULL,
  `ID_OBAT` int(11) NOT NULL,
  `QTY` int(11) NOT NULL,
  `ID_TRANSAKSI` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `TOTAL_HARGA` decimal(10,2) DEFAULT NULL,
  `METODE_PEMBAYARAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`ID_TRANSAKSI`, `ID_PELANGGAN`, `TANGGAL_TRANSAKSI`, `TOTAL_HARGA`, `METODE_PEMBAYARAN`) VALUES
(1, 1, '2024-11-01', 125000.00, 'Cash'),
(2, 2, '2024-11-02', 118000.00, 'Credit Card'),
(3, 3, '2024-11-03', 130000.00, 'Transfer');

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
  ADD KEY `pembelian_obat_ibfk_1` (`ID_OBAT`),
  ADD KEY `pembelian_obat_ibfk_2` (`ID_PELANGGAN`),
  ADD KEY `pembelian_obat_ibfk_3` (`ID_TRANSAKSI`);

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
  MODIFY `ID_OBAT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_PELANGGAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `ID_SUPPLIER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `ID_TRANSAKSI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  ADD CONSTRAINT `pembelian_obat_ibfk_1` FOREIGN KEY (`ID_OBAT`) REFERENCES `obat` (`ID_OBAT`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelian_obat_ibfk_2` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelian_obat_ibfk_3` FOREIGN KEY (`ID_TRANSAKSI`) REFERENCES `transaksi` (`ID_TRANSAKSI`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
