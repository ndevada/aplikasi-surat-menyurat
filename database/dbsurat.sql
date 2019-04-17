-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 06, 2018 at 07:47 AM
-- Server version: 5.7.19
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsurat`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail`
--

DROP TABLE IF EXISTS `detail`;
CREATE TABLE IF NOT EXISTS `detail` (
  `kd_detail` int(11) NOT NULL AUTO_INCREMENT,
  `nm_detail` varchar(50) NOT NULL,
  `kd_simpan` varchar(8) NOT NULL,
  PRIMARY KEY (`kd_detail`),
  KEY `kd_simpan` (`kd_simpan`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail`
--

INSERT INTO `detail` (`kd_detail`, `nm_detail`, `kd_simpan`) VALUES
(1, 'RAK 1', 'PN-002'),
(2, 'RAK 2', 'PN-002'),
(3, 'RAK 3', 'PN-002'),
(7, 'RAK 4', 'PN-002');

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

DROP TABLE IF EXISTS `disposisi`;
CREATE TABLE IF NOT EXISTS `disposisi` (
  `id_disposisi` varchar(25) NOT NULL,
  `sifat` varchar(20) NOT NULL,
  `kd_bagian` varchar(8) NOT NULL,
  `tgpn` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `urut` varchar(25) NOT NULL,
  `tgl_disposisi` date DEFAULT NULL,
  PRIMARY KEY (`id_disposisi`),
  KEY `kd_bagian` (`kd_bagian`),
  KEY `urut` (`urut`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disposisi`
--

INSERT INTO `disposisi` (`id_disposisi`, `sifat`, `kd_bagian`, `tgpn`, `isi`, `urut`, `tgl_disposisi`) VALUES
('0001/DISPOSISI/2017', 'SEGERA', 'BG-002', 'PROSES LEBIH LANJUT', 'SEGERA HADIRI RAPAT DI DINAS PERPUSTAKAAN DAN ARSIP KOTA BANJARMASIN', '001/DISKOMINFOTIK/2017', '2017-12-26'),
('0001/DISPOSISI/2018', 'SEGERA', 'BG-003', 'TANGGAPAN DAN SARAN', 'ASDASDASSA', '001/DISKOMINFOTIK/2018', '2018-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `ip`
--

DROP TABLE IF EXISTS `ip`;
CREATE TABLE IF NOT EXISTS `ip` (
  `address` char(16) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `minstansi`
--

DROP TABLE IF EXISTS `minstansi`;
CREATE TABLE IF NOT EXISTS `minstansi` (
  `kd_instansi` char(8) NOT NULL,
  `nm_instansi` varchar(70) NOT NULL,
  `almt_instansi` text NOT NULL,
  PRIMARY KEY (`kd_instansi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minstansi`
--

INSERT INTO `minstansi` (`kd_instansi`, `nm_instansi`, `almt_instansi`) VALUES
('IN-003', 'AISMD\'ASDAS\'ASDA', 'ASDIMASD\'ASDSA\''),
('IN-001', 'DINAS PENDIDIKAN KOTA BANJARMASIN', 'JLN. KP. TENDEAN NO.29 BANJARMASIN'),
('IN-002', 'KEPALA BAGIAN UMUM SETDAKO BANJARMASIN', 'JALAN R. E. MARTADINATA');

-- --------------------------------------------------------

--
-- Table structure for table `mjenis`
--

DROP TABLE IF EXISTS `mjenis`;
CREATE TABLE IF NOT EXISTS `mjenis` (
  `kd_jenis` varchar(8) NOT NULL,
  `nm_jenis` char(30) NOT NULL,
  PRIMARY KEY (`kd_jenis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mjenis`
--

INSERT INTO `mjenis` (`kd_jenis`, `nm_jenis`) VALUES
('JN-001', 'UNDANGAN'),
('JN-002', 'PENGANTAR'),
('JN-003', 'RAHASIA');

-- --------------------------------------------------------

--
-- Table structure for table `mkadis`
--

DROP TABLE IF EXISTS `mkadis`;
CREATE TABLE IF NOT EXISTS `mkadis` (
  `id_kadis` varchar(8) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nm_kadis` varchar(30) NOT NULL,
  `thn_mnjbt` char(4) NOT NULL,
  PRIMARY KEY (`id_kadis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mpnympn`
--

DROP TABLE IF EXISTS `mpnympn`;
CREATE TABLE IF NOT EXISTS `mpnympn` (
  `kd_simpan` varchar(8) NOT NULL,
  `nm_simpan` varchar(70) NOT NULL,
  PRIMARY KEY (`kd_simpan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mpnympn`
--

INSERT INTO `mpnympn` (`kd_simpan`, `nm_simpan`) VALUES
('PN-002', 'LEMARI SURAT');

-- --------------------------------------------------------

--
-- Table structure for table `m_bagian`
--

DROP TABLE IF EXISTS `m_bagian`;
CREATE TABLE IF NOT EXISTS `m_bagian` (
  `kd_bagian` varchar(8) NOT NULL,
  `nm_bagian` char(70) NOT NULL,
  PRIMARY KEY (`kd_bagian`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_bagian`
--

INSERT INTO `m_bagian` (`kd_bagian`, `nm_bagian`) VALUES
('BG-001', 'SEKRETARIS'),
('BG-002', 'KABID PENGELOLAAN DAN PELAYANAN INFORMASI PUBLIK'),
('BG-003', 'KABID TEKNOLOGI INFORMASI DAN KOMUNIKASI'),
('BG-004', 'KABID LAYANAN E-GOVERMENT'),
('BG-005', 'KABID STATISTIK DAN PERSANDIAN');

-- --------------------------------------------------------

--
-- Table structure for table `tpengguna`
--

DROP TABLE IF EXISTS `tpengguna`;
CREATE TABLE IF NOT EXISTS `tpengguna` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `username` char(10) NOT NULL,
  `password` varchar(225) NOT NULL,
  `nama_user` char(30) NOT NULL,
  `level` char(8) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tpengguna`
--

INSERT INTO `tpengguna` (`user_id`, `username`, `password`, `nama_user`, `level`) VALUES
(1, 'admin', '$2y$10$zDM3/fx42Eg3V.4hVzWu9e.b.zu1BRYs6B/B/Zpx1VT0NeSWXGK1W', 'FAISHAL RISFANDI', 'admin'),
(2, 'user', '$2y$10$zDM3/fx42Eg3V.4hVzWu9e.b.zu1BRYs6B/B/Zpx1VT0NeSWXGK1W', 'Faishal Risfandi', 'pegawai');

-- --------------------------------------------------------

--
-- Table structure for table `tsuratkeluar`
--

DROP TABLE IF EXISTS `tsuratkeluar`;
CREATE TABLE IF NOT EXISTS `tsuratkeluar` (
  `kode_srtkeluar` varchar(8) NOT NULL,
  `no_urutkl` int(11) NOT NULL AUTO_INCREMENT,
  `kd_klasifikasi` varchar(15) NOT NULL,
  `ket_nmr` varchar(50) NOT NULL,
  `tgl_surat` date NOT NULL,
  `kd_jenis` varchar(25) NOT NULL,
  `kd_instansi` varchar(25) NOT NULL,
  `perihal` text NOT NULL,
  PRIMARY KEY (`kode_srtkeluar`),
  UNIQUE KEY `no_urutkl` (`no_urutkl`),
  KEY `kd_instansi` (`kd_instansi`),
  KEY `kd_jenis` (`kd_jenis`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tsuratkeluar`
--

INSERT INTO `tsuratkeluar` (`kode_srtkeluar`, `no_urutkl`, `kd_klasifikasi`, `ket_nmr`, `tgl_surat`, `kd_jenis`, `kd_instansi`, `perihal`) VALUES
('001/2018', 1, '870-sekr', 'DISKOMINFOTIK/I/2018', '2018-01-17', 'JN-001', 'IN-001', 'TES SAJA'),
('002/2018', 2, '870-sekr', 'DISKOMINFOTIK/I/2018', '2018-01-22', 'JN-001', 'IN-001', 'DQWDQQDQQD');

-- --------------------------------------------------------

--
-- Table structure for table `tsuratmasuk`
--

DROP TABLE IF EXISTS `tsuratmasuk`;
CREATE TABLE IF NOT EXISTS `tsuratmasuk` (
  `no_urut` varchar(25) NOT NULL,
  `tgl_surat` date NOT NULL,
  `nmr_surat` text NOT NULL,
  `kd_instansi` varchar(8) NOT NULL,
  `tgl_diterima` date NOT NULL,
  `perihal` text NOT NULL,
  `catatan` text NOT NULL,
  `kd_simpan` varchar(8) NOT NULL,
  `kd_detail` varchar(8) NOT NULL,
  PRIMARY KEY (`no_urut`),
  KEY `kd_instansi` (`kd_instansi`),
  KEY `kd_simpan` (`kd_simpan`),
  KEY `kd_detail` (`kd_detail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tsuratmasuk`
--

INSERT INTO `tsuratmasuk` (`no_urut`, `tgl_surat`, `nmr_surat`, `kd_instansi`, `tgl_diterima`, `perihal`, `catatan`, `kd_simpan`, `kd_detail`) VALUES
('001/DISKOMINFOTIK/2018', '2018-01-13', '700/8192/02193', 'IN-001', '2018-01-13', 'WDWDWDWDWED', 'DASDAS', 'PN-002', '1'),
('001/DISKOMINFOTIK/2017', '2017-12-12', '700/8192/02191', 'IN-001', '2017-12-12', 'RAPAT', 'TANGGAL : 5 JANUARI 2017\r\n\r\nTEMPAT : DINAS PERPUSTAKAAN DAN ARSIP KOTA', 'PN-002', '1'),
('002/DISKOMINFOTIK/2018', '2018-01-18', '700/8192/01231', 'IN-001', '2018-01-18', 'RAPAT', 'RAPAT DI KANTOR DINAS PENDIDIKAN KOTA BANJARMASIN', 'PN-002', '3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
