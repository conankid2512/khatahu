-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2015 at 08:15 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `baiviet`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `baiviet`
--

INSERT INTO `baiviet` (`maBaiViet`, `maKiemDuyet`, `maTacGia`, `tenBaiViet`, `noiDung`, `hinhNho`, `luotXem`, `luotBinhLuan`, `trangThai`, `ngayDang`, `ngayKiemDuyet`) VALUES
(3, 1, 1, 'Sigma dp3 Quattro xuất hiện trên website của hãng: Cảm biến 29MP, ống kính 50mm F/2.8', '<h3><img src="/khatahu/uploads/source/2813966_dp3_quattro_front-slant.jpg" alt="2813966_dp3_quattro_front-slant" /></h3>\r\n<p>Hãng sản xuất máy ảnh và ống kính Sigma vừa đăng tải lên website của họ hình ảnh của chiếc compact dp3 Quattro. Đây là thế hệ thứ 3 của dòng máy compact này và máy vẫn dùng chung cảm biến CMOS Foveon X3 Quattro độ phân giải 29 megapixel như hai thế hệ trước. Tuy nhiên điểm khác biệt của chiếc dp3 này nằm ở ống kính đi kèm. Trong khi chiếc ống kính của chiếc dp1 là 19mm F/2.8, chiếc dp2 là 30mm F/2.8 thì chiếc dp3 này sẽ có ống kính đi kèm với tiêu cự 50mm F/2.8. Chiếc máy ảnh compact này sẽ xuất hiện tại CP+ 2015, giá dự kiến $999 (xấp xỉ 21 triệu đồng).</p>\r\n<h3>Thông số kỹ thuật</h3>\r\n<ul><li>Tiêu cự ống kính: 50mm , tương đương 75mm trên cảm biến Full Frame</li>\r\n<li>Khẩu độ lớn nhất: f/2.8 - Nhỏ nhất F/16</li>\r\n<li>Cấu tạo thấu kính: 10 thấu kính trong 8 nhóm, 7 lá khẩu</li>\r\n<li>Cảm biến ảnh: CMOS Foveon X3 Direct, 23.5 x 15.7 mm</li>\r\n<li>Độ phân giải hữu dụng: 29 MP</li>\r\n<li>Độ phân giải đầy đủ: 33 MP</li>\r\n<li>Màn hình LCD: 3” độ phân giải 920,000 điểm ảnh</li>\r\n<li>ISO: 100 - 6.400</li>\r\n<li>Tốc độ màn trập: 1/2.000 giây</li>\r\n<li>Hệ thống lấy nét: tương phản</li>\r\n<li>Định dạng ảnh: RAW / JPEG</li>\r\n<li>Độ phân giải ảnh tối đa: 7.680 x 5.120 pixel (39,33 MP)</li>\r\n<li>Thẻ nhớ: SDHC/SDXC</li>\r\n<li>Kích thước: 16,14 x 6,7 x 8,16 cm</li>\r\n<li>Trọng lượng: 395 g</li>\r\n</ul><p><img src="/khatahu/uploads/source/2813967_dp3_quattro_front.jpg" alt="2813967_dp3_quattro_front" /><img src="/khatahu/uploads/source/2813965_dp3_quattro_back.jpg" alt="2813965_dp3_quattro_back" /><img src="/khatahu/uploads/source/2813964_dp3_quattro_back-slant.jpg" alt="2813964_dp3_quattro_back-slant" /></p>', '/uploads/source/2813966_dp3_quattro_front-slant.jpg', 0, 0, 2, '2015-02-14 05:24:05', '2015-02-14 05:24:05'),
(4, 1, 1, 'Sigma dp3 Quattro xuất hiện trên website của hãng: Cảm biến 29MP, ống kính 50mm F/2.8', '<h3><img src="/khatahu/uploads/source/2813966_dp3_quattro_front-slant.jpg" alt="2813966_dp3_quattro_front-slant" /></h3>\r\n<p>Hãng sản xuất máy ảnh và ống kính Sigma vừa đăng tải lên website của họ hình ảnh của chiếc compact dp3 Quattro. Đây là thế hệ thứ 3 của dòng máy compact này và máy vẫn dùng chung cảm biến CMOS Foveon X3 Quattro độ phân giải 29 megapixel như hai thế hệ trước. Tuy nhiên điểm khác biệt của chiếc dp3 này nằm ở ống kính đi kèm. Trong khi chiếc ống kính của chiếc dp1 là 19mm F/2.8, chiếc dp2 là 30mm F/2.8 thì chiếc dp3 này sẽ có ống kính đi kèm với tiêu cự 50mm F/2.8. Chiếc máy ảnh compact này sẽ xuất hiện tại CP+ 2015, giá dự kiến $999 (xấp xỉ 21 triệu đồng).</p>\r\n<h3>Thông số kỹ thuật</h3>\r\n<ul><li>Tiêu cự ống kính: 50mm , tương đương 75mm trên cảm biến Full Frame</li>\r\n<li>Khẩu độ lớn nhất: f/2.8 - Nhỏ nhất F/16</li>\r\n<li>Cấu tạo thấu kính: 10 thấu kính trong 8 nhóm, 7 lá khẩu</li>\r\n<li>Cảm biến ảnh: CMOS Foveon X3 Direct, 23.5 x 15.7 mm</li>\r\n<li>Độ phân giải hữu dụng: 29 MP</li>\r\n<li>Độ phân giải đầy đủ: 33 MP</li>\r\n<li>Màn hình LCD: 3” độ phân giải 920,000 điểm ảnh</li>\r\n<li>ISO: 100 - 6.400</li>\r\n<li>Tốc độ màn trập: 1/2.000 giây</li>\r\n<li>Hệ thống lấy nét: tương phản</li>\r\n<li>Định dạng ảnh: RAW / JPEG</li>\r\n<li>Độ phân giải ảnh tối đa: 7.680 x 5.120 pixel (39,33 MP)</li>\r\n<li>Thẻ nhớ: SDHC/SDXC</li>\r\n<li>Kích thước: 16,14 x 6,7 x 8,16 cm</li>\r\n<li>Trọng lượng: 395 g</li>\r\n</ul><p><img src="/khatahu/uploads/source/2813967_dp3_quattro_front.jpg" alt="2813967_dp3_quattro_front" /><img src="/khatahu/uploads/source/2813965_dp3_quattro_back.jpg" alt="2813965_dp3_quattro_back" /><img src="/khatahu/uploads/source/2813964_dp3_quattro_back-slant.jpg" alt="2813964_dp3_quattro_back-slant" /></p>', '/uploads/source/2813966_dp3_quattro_front-slant.jpg', 0, 0, 2, '2015-02-14 05:25:21', '2015-02-14 05:25:21'),
(5, 1, 1, 'Sigma dp3 Quattro xuất hiện trên website của hãng: Cảm biến 29MP, ống kính 50mm F/2.8', '<h3><img src="/khatahu/uploads/source/2813966_dp3_quattro_front-slant.jpg" alt="2813966_dp3_quattro_front-slant" /></h3>\r\n<p>Hãng sản xuất máy ảnh và ống kính Sigma vừa đăng tải lên website của họ hình ảnh của chiếc compact dp3 Quattro. Đây là thế hệ thứ 3 của dòng máy compact này và máy vẫn dùng chung cảm biến CMOS Foveon X3 Quattro độ phân giải 29 megapixel như hai thế hệ trước. Tuy nhiên điểm khác biệt của chiếc dp3 này nằm ở ống kính đi kèm. Trong khi chiếc ống kính của chiếc dp1 là 19mm F/2.8, chiếc dp2 là 30mm F/2.8 thì chiếc dp3 này sẽ có ống kính đi kèm với tiêu cự 50mm F/2.8. Chiếc máy ảnh compact này sẽ xuất hiện tại CP+ 2015, giá dự kiến $999 (xấp xỉ 21 triệu đồng).</p>\r\n<h3>Thông số kỹ thuật</h3>\r\n<ul><li>Tiêu cự ống kính: 50mm , tương đương 75mm trên cảm biến Full Frame</li>\r\n<li>Khẩu độ lớn nhất: f/2.8 - Nhỏ nhất F/16</li>\r\n<li>Cấu tạo thấu kính: 10 thấu kính trong 8 nhóm, 7 lá khẩu</li>\r\n<li>Cảm biến ảnh: CMOS Foveon X3 Direct, 23.5 x 15.7 mm</li>\r\n<li>Độ phân giải hữu dụng: 29 MP</li>\r\n<li>Độ phân giải đầy đủ: 33 MP</li>\r\n<li>Màn hình LCD: 3” độ phân giải 920,000 điểm ảnh</li>\r\n<li>ISO: 100 - 6.400</li>\r\n<li>Tốc độ màn trập: 1/2.000 giây</li>\r\n<li>Hệ thống lấy nét: tương phản</li>\r\n<li>Định dạng ảnh: RAW / JPEG</li>\r\n<li>Độ phân giải ảnh tối đa: 7.680 x 5.120 pixel (39,33 MP)</li>\r\n<li>Thẻ nhớ: SDHC/SDXC</li>\r\n<li>Kích thước: 16,14 x 6,7 x 8,16 cm</li>\r\n<li>Trọng lượng: 395 g</li>\r\n</ul><p><img src="/khatahu/uploads/source/2813967_dp3_quattro_front.jpg" alt="2813967_dp3_quattro_front" /><img src="/khatahu/uploads/source/2813965_dp3_quattro_back.jpg" alt="2813965_dp3_quattro_back" /><img src="/khatahu/uploads/source/2813964_dp3_quattro_back-slant.jpg" alt="2813964_dp3_quattro_back-slant" /></p>', '/uploads/source/2813966_dp3_quattro_front-slant.jpg', 0, 0, 2, '2015-02-14 05:25:34', '2015-02-14 05:25:34'),
(6, 1, 1, 'Sigma dp3 Quattro xuất hiện trên website của hãng: Cảm biến 29MP, ống kính 50mm F/2.8', '<h3><img src="/khatahu/uploads/source/2813966_dp3_quattro_front-slant.jpg" alt="2813966_dp3_quattro_front-slant" /></h3>\r\n<p>Hãng sản xuất máy ảnh và ống kính Sigma vừa đăng tải lên website của họ hình ảnh của chiếc compact dp3 Quattro. Đây là thế hệ thứ 3 của dòng máy compact này và máy vẫn dùng chung cảm biến CMOS Foveon X3 Quattro độ phân giải 29 megapixel như hai thế hệ trước. Tuy nhiên điểm khác biệt của chiếc dp3 này nằm ở ống kính đi kèm. Trong khi chiếc ống kính của chiếc dp1 là 19mm F/2.8, chiếc dp2 là 30mm F/2.8 thì chiếc dp3 này sẽ có ống kính đi kèm với tiêu cự 50mm F/2.8. Chiếc máy ảnh compact này sẽ xuất hiện tại CP+ 2015, giá dự kiến $999 (xấp xỉ 21 triệu đồng).</p>\r\n<h3>Thông số kỹ thuật</h3>\r\n<ul><li>Tiêu cự ống kính: 50mm , tương đương 75mm trên cảm biến Full Frame</li>\r\n<li>Khẩu độ lớn nhất: f/2.8 - Nhỏ nhất F/16</li>\r\n<li>Cấu tạo thấu kính: 10 thấu kính trong 8 nhóm, 7 lá khẩu</li>\r\n<li>Cảm biến ảnh: CMOS Foveon X3 Direct, 23.5 x 15.7 mm</li>\r\n<li>Độ phân giải hữu dụng: 29 MP</li>\r\n<li>Độ phân giải đầy đủ: 33 MP</li>\r\n<li>Màn hình LCD: 3” độ phân giải 920,000 điểm ảnh</li>\r\n<li>ISO: 100 - 6.400</li>\r\n<li>Tốc độ màn trập: 1/2.000 giây</li>\r\n<li>Hệ thống lấy nét: tương phản</li>\r\n<li>Định dạng ảnh: RAW / JPEG</li>\r\n<li>Độ phân giải ảnh tối đa: 7.680 x 5.120 pixel (39,33 MP)</li>\r\n<li>Thẻ nhớ: SDHC/SDXC</li>\r\n<li>Kích thước: 16,14 x 6,7 x 8,16 cm</li>\r\n<li>Trọng lượng: 395 g</li>\r\n</ul><p><img src="/khatahu/uploads/source/2813967_dp3_quattro_front.jpg" alt="2813967_dp3_quattro_front" /><img src="/khatahu/uploads/source/2813965_dp3_quattro_back.jpg" alt="2813965_dp3_quattro_back" /><img src="/khatahu/uploads/source/2813964_dp3_quattro_back-slant.jpg" alt="2813964_dp3_quattro_back-slant" /></p>', '/uploads/source/2813966_dp3_quattro_front-slant.jpg', 0, 0, 2, '2015-02-14 05:25:43', '2015-02-14 05:25:43'),
(7, 1, 1, 'Sigma dp3 Quattro xuất hiện trên website của hãng: Cảm biến 29MP, ống kính 50mm F/2.8', '<h3><img src="/khatahu/uploads/source/2813966_dp3_quattro_front-slant.jpg" alt="2813966_dp3_quattro_front-slant" /></h3>\r\n<p>Hãng sản xuất máy ảnh và ống kính Sigma vừa đăng tải lên website của họ hình ảnh của chiếc compact dp3 Quattro. Đây là thế hệ thứ 3 của dòng máy compact này và máy vẫn dùng chung cảm biến CMOS Foveon X3 Quattro độ phân giải 29 megapixel như hai thế hệ trước. Tuy nhiên điểm khác biệt của chiếc dp3 này nằm ở ống kính đi kèm. Trong khi chiếc ống kính của chiếc dp1 là 19mm F/2.8, chiếc dp2 là 30mm F/2.8 thì chiếc dp3 này sẽ có ống kính đi kèm với tiêu cự 50mm F/2.8. Chiếc máy ảnh compact này sẽ xuất hiện tại CP+ 2015, giá dự kiến $999 (xấp xỉ 21 triệu đồng).</p>\r\n<h3>Thông số kỹ thuật</h3>\r\n<ul><li>Tiêu cự ống kính: 50mm , tương đương 75mm trên cảm biến Full Frame</li>\r\n<li>Khẩu độ lớn nhất: f/2.8 - Nhỏ nhất F/16</li>\r\n<li>Cấu tạo thấu kính: 10 thấu kính trong 8 nhóm, 7 lá khẩu</li>\r\n<li>Cảm biến ảnh: CMOS Foveon X3 Direct, 23.5 x 15.7 mm</li>\r\n<li>Độ phân giải hữu dụng: 29 MP</li>\r\n<li>Độ phân giải đầy đủ: 33 MP</li>\r\n<li>Màn hình LCD: 3” độ phân giải 920,000 điểm ảnh</li>\r\n<li>ISO: 100 - 6.400</li>\r\n<li>Tốc độ màn trập: 1/2.000 giây</li>\r\n<li>Hệ thống lấy nét: tương phản</li>\r\n<li>Định dạng ảnh: RAW / JPEG</li>\r\n<li>Độ phân giải ảnh tối đa: 7.680 x 5.120 pixel (39,33 MP)</li>\r\n<li>Thẻ nhớ: SDHC/SDXC</li>\r\n<li>Kích thước: 16,14 x 6,7 x 8,16 cm</li>\r\n<li>Trọng lượng: 395 g</li>\r\n</ul><p><img src="/khatahu/uploads/source/2813967_dp3_quattro_front.jpg" alt="2813967_dp3_quattro_front" /><img src="/khatahu/uploads/source/2813965_dp3_quattro_back.jpg" alt="2813965_dp3_quattro_back" /><img src="/khatahu/uploads/source/2813964_dp3_quattro_back-slant.jpg" alt="2813964_dp3_quattro_back-slant" /></p>', '/uploads/source/2813966_dp3_quattro_front-slant.jpg', 0, 0, 2, '2015-02-14 05:25:53', '2015-02-14 05:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE IF NOT EXISTS `binhluan` (
`maBinhLuan` int(10) unsigned NOT NULL,
  `maBaiViet` int(10) unsigned NOT NULL,
  `noiDung` text CHARACTER SET utf8 NOT NULL,
  `tenNguoiGui` varchar(255) CHARACTER SET utf8 NOT NULL,
  `emailGui` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Email của độc giả',
  `trangThai` tinyint(1) NOT NULL COMMENT 'Hiển thị/Không hiển thi (Do toà soan quyết định)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE IF NOT EXISTS `nhanvien` (
`maNhanVien` int(10) unsigned NOT NULL,
  `tenDangNhap` varchar(64) CHARACTER SET utf8 NOT NULL,
  `tenHienThi` varchar(255) CHARACTER SET utf8 NOT NULL,
  `matKhauHash` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quyenHan` tinyint(4) NOT NULL,
  `moTaNgan` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`maNhanVien`, `tenDangNhap`, `tenHienThi`, `matKhauHash`, `email`, `quyenHan`, `moTaNgan`) VALUES
(1, 'admin', 'Administrator', '$2y$10$cvXrXu7Eq/oa1yq.2SRhDuIT8DN8C/lOO12DdZ5ilbUYuKEznJZ9e', 'admin@conankid.com', 3, ''),
(2, 'conankid', 'Võ Minh Khánh', '$2y$10$FGI.KySsP06wGCXH3b9DaenGrtWUfmAEQbefPlCUKjEUxDbEwNdMu', 'vnprohkn@gmail.com', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `phanloai`
--

CREATE TABLE IF NOT EXISTS `phanloai` (
`sTT` int(10) unsigned NOT NULL,
  `maBaiViet` int(10) unsigned NOT NULL,
  `maTheLoai` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `phanloai`
--

INSERT INTO `phanloai` (`sTT`, `maBaiViet`, `maTheLoai`) VALUES
(41, 3, 3),
(44, 4, 1),
(45, 5, 5),
(46, 6, 2),
(47, 7, 2),
(48, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `quangcao`
--

CREATE TABLE IF NOT EXISTS `quangcao` (
`maQuangCao` int(10) unsigned NOT NULL,
  `maViTri` varchar(20) CHARACTER SET utf8 NOT NULL,
  `noiDung` text CHARACTER SET utf8 NOT NULL,
  `ngayBatDau` date NOT NULL,
  `ngayKetThuc` date NOT NULL,
  `trangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

CREATE TABLE IF NOT EXISTS `theloai` (
`maTheLoai` int(10) unsigned NOT NULL,
  `tenTheLoai` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `maTheLoaiCha` int(10) unsigned DEFAULT NULL,
  `tTMenu` int(10) unsigned NOT NULL DEFAULT '0',
  `tTTrangChu` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`maTheLoai`, `tenTheLoai`, `maTheLoaiCha`, `tTMenu`, `tTTrangChu`) VALUES
(1, 'Parent 1', NULL, 5, 1),
(2, 'Parent 2', NULL, 2, 2),
(3, 'Child 1', 1, 2, 0),
(4, 'Child 2', 1, 1, 0),
(5, 'Child 3', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `theodoitruycap`
--

CREATE TABLE IF NOT EXISTS `theodoitruycap` (
`soThuTu` int(10) unsigned NOT NULL,
  `maBaiViet` int(10) unsigned NOT NULL,
  `tGTruyCap` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời điểm ghi nhận truy cập'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuychon`
--

CREATE TABLE IF NOT EXISTS `tuychon` (
`maTuyChon` int(10) unsigned NOT NULL,
  `tenTuyChon` varchar(32) CHARACTER SET utf8 NOT NULL,
  `noiDung` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `tuychon`
--

INSERT INTO `tuychon` (`maTuyChon`, `tenTuyChon`, `noiDung`) VALUES
(1, 'urlChinh', 'http://localhost/khatahu/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baiviet`
--
ALTER TABLE `baiviet`
 ADD PRIMARY KEY (`maBaiViet`), ADD KEY `maTacGia` (`maTacGia`), ADD KEY `maKiemDuyet` (`maKiemDuyet`);

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
 ADD PRIMARY KEY (`sTT`), ADD UNIQUE KEY `unique` (`maBaiViet`,`maTheLoai`), ADD KEY `maTheLoai` (`maTheLoai`);

--
-- Indexes for table `quangcao`
--
ALTER TABLE `quangcao`
 ADD PRIMARY KEY (`maQuangCao`);

--
-- Indexes for table `theloai`
--
ALTER TABLE `theloai`
 ADD PRIMARY KEY (`maTheLoai`), ADD KEY `maTheLoaiCha` (`maTheLoaiCha`);

--
-- Indexes for table `theodoitruycap`
--
ALTER TABLE `theodoitruycap`
 ADD PRIMARY KEY (`soThuTu`), ADD KEY `maBaiViet` (`maBaiViet`);

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
MODIFY `maBaiViet` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
MODIFY `maBinhLuan` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
MODIFY `maNhanVien` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `phanloai`
--
ALTER TABLE `phanloai`
MODIFY `sTT` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `quangcao`
--
ALTER TABLE `quangcao`
MODIFY `maQuangCao` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `theloai`
--
ALTER TABLE `theloai`
MODIFY `maTheLoai` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `theodoitruycap`
--
ALTER TABLE `theodoitruycap`
MODIFY `soThuTu` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tuychon`
--
ALTER TABLE `tuychon`
MODIFY `maTuyChon` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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

--
-- Constraints for table `theodoitruycap`
--
ALTER TABLE `theodoitruycap`
ADD CONSTRAINT `theodoitruycap_ibfk_1` FOREIGN KEY (`maBaiViet`) REFERENCES `baiviet` (`maBaiViet`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
