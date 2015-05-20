-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2015 at 11:19 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aptech`
--
CREATE DATABASE IF NOT EXISTS `#dbname#` DEFAULT CHARACTER SET utf8 COLLATE utf8_vietnamese_ci;
USE `#dbname#`;

-- --------------------------------------------------------

--
-- Table structure for table `baiviet`
--

DROP TABLE IF EXISTS `baiviet`;
CREATE TABLE IF NOT EXISTS `baiviet` (
`maBaiViet` int(10) unsigned NOT NULL,
  `maKiemDuyet` int(10) unsigned DEFAULT NULL COMMENT 'Mã nhân viên kiểm duyệt',
  `maTacGia` int(10) unsigned NOT NULL COMMENT 'Mã nhân viên viết bài',
  `tenBaiViet` text COLLATE utf8_vietnamese_ci NOT NULL,
  `noiDung` mediumtext COLLATE utf8_vietnamese_ci NOT NULL,
  `hinhNho` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `luotXem` int(10) unsigned NOT NULL DEFAULT '0',
  `luotBinhLuan` int(10) unsigned NOT NULL DEFAULT '0',
  `trangThai` tinyint(4) NOT NULL COMMENT 'Nháp, Chờ duyệt, Đã duyệt',
  `ngayDang` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ngayKiemDuyet` timestamp NULL DEFAULT NULL COMMENT 'Ngày được sếp duyệt bài'
)#engine#AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

DROP TABLE IF EXISTS `binhluan`;
CREATE TABLE IF NOT EXISTS `binhluan` (
`maBinhLuan` int(10) unsigned NOT NULL,
  `maBaiViet` int(10) unsigned NOT NULL,
  `noiDung` text CHARACTER SET utf8 NOT NULL,
  `ngayDang` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tenNguoiGui` varchar(255) CHARACTER SET utf8 NOT NULL,
  `emailGui` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Email của độc giả',
  `trangThai` tinyint(1) NOT NULL COMMENT 'Hiển thị/Không hiển thi (Do toà soan quyết định)'
)#engine#AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Triggers `binhluan`
--
DROP TRIGGER IF EXISTS `del_binhluan`;

CREATE TRIGGER `del_binhluan` AFTER DELETE ON `binhluan`
 FOR EACH ROW BEGIN
  UPDATE baiviet SET luotBinhLuan = luotBinhLuan - OLD.trangThai WHERE maBaiViet = OLD.maBaiViet;
END;

DROP TRIGGER IF EXISTS `ins_binhluan`;

CREATE TRIGGER `ins_binhluan` AFTER INSERT ON `binhluan`
 FOR EACH ROW BEGIN
  UPDATE baiviet SET luotBinhLuan = luotBinhLuan + NEW.trangThai WHERE maBaiViet = NEW.maBaiViet;
END;

DROP TRIGGER IF EXISTS `upd_binhluan`;

CREATE TRIGGER `upd_binhluan` AFTER UPDATE ON `binhluan`
 FOR EACH ROW BEGIN
  UPDATE baiviet SET luotBinhLuan = luotBinhLuan + NEW.trangThai - OLD.trangThai WHERE maBaiViet = NEW.maBaiViet;
END;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
`maNhanVien` int(10) unsigned NOT NULL,
  `tenDangNhap` varchar(64) CHARACTER SET utf8 NOT NULL,
  `tenHienThi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `matKhauHash` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quyenHan` tinyint(4) NOT NULL,
  `moTaNgan` text CHARACTER SET utf8 NOT NULL
)#engine#AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phanloai`
--

DROP TABLE IF EXISTS `phanloai`;
CREATE TABLE IF NOT EXISTS `phanloai` (
  `maBaiViet` int(10) unsigned NOT NULL,
  `maTheLoai` int(10) unsigned DEFAULT NULL
)#engine#DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

DROP TABLE IF EXISTS `theloai`;
CREATE TABLE IF NOT EXISTS `theloai` (
`maTheLoai` int(10) unsigned NOT NULL,
  `tenTheLoai` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `maTheLoaiCha` int(10) unsigned DEFAULT NULL,
  `tTMenu` int(10) NOT NULL DEFAULT '0',
  `tTTrangChu` int(10) NOT NULL DEFAULT '0'
)#engine#AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuychon`
--

DROP TABLE IF EXISTS `tuychon`;
CREATE TABLE IF NOT EXISTS `tuychon` (
`maTuyChon` int(10) unsigned NOT NULL,
  `tenTuyChon` varchar(32) CHARACTER SET utf8 NOT NULL,
  `noiDung` text CHARACTER SET utf8 NOT NULL
)#engine#AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baiviet`
--
ALTER TABLE `baiviet`
 ADD PRIMARY KEY (`maBaiViet`), ADD KEY `maTacGia` (`maTacGia`), ADD KEY `maKiemDuyet` (`maKiemDuyet`), ADD KEY `trangThai` (`trangThai`), ADD FULLTEXT KEY `baiviet` (`tenBaiViet`,`noiDung`);

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
 ADD PRIMARY KEY (`maBinhLuan`), ADD KEY `maBaiViet` (`maBaiViet`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
 ADD PRIMARY KEY (`maNhanVien`), ADD UNIQUE KEY `tenDangNhap` (`tenDangNhap`);

--
-- Indexes for table `phanloai`
--
ALTER TABLE `phanloai`
 ADD PRIMARY KEY (`maBaiViet`,`maTheLoai`), ADD KEY `maTheLoai` (`maTheLoai`);

--
-- Indexes for table `theloai`
--
ALTER TABLE `theloai`
 ADD PRIMARY KEY (`maTheLoai`), ADD KEY `maTheLoaiCha` (`maTheLoaiCha`);

--
-- Indexes for table `tuychon`
--
ALTER TABLE `tuychon`
 ADD PRIMARY KEY (`maTuyChon`), ADD UNIQUE KEY `tenTuyChon` (`tenTuyChon`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baiviet`
--
ALTER TABLE `baiviet`
MODIFY `maBaiViet` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
MODIFY `maBinhLuan` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
MODIFY `maNhanVien` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `theloai`
--
ALTER TABLE `theloai`
MODIFY `maTheLoai` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `tuychon`
--
ALTER TABLE `tuychon`
MODIFY `maTuyChon` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `baiviet`
--
ALTER TABLE `baiviet`
ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`maKiemDuyet`) REFERENCES `nhanvien` (`maNhanVien`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `baiviet_ibfk_2` FOREIGN KEY (`maTacGia`) REFERENCES `nhanvien` (`maNhanVien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`maBaiViet`) REFERENCES `baiviet` (`maBaiViet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phanloai`
--
ALTER TABLE `phanloai`
ADD CONSTRAINT `phanloai_ibfk_1` FOREIGN KEY (`maBaiViet`) REFERENCES `baiviet` (`maBaiViet`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `phanloai_ibfk_2` FOREIGN KEY (`maTheLoai`) REFERENCES `theloai` (`maTheLoai`) ON DELETE SET NULL;

--
-- Constraints for table `theloai`
--
ALTER TABLE `theloai`
ADD CONSTRAINT `theloai_ibfk_1` FOREIGN KEY (`maTheLoaiCha`) REFERENCES `theloai` (`maTheLoai`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
