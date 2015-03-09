<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}

$maBaiViet_data = null;
if($_GET["chucnang"] == "baiViet") {
    if(!empty($_GET["maBaiViet"])) {
        //Anti SQL-Ịnection
        $_GET["maBaiViet"] = sprintf("%d",$_GET["maBaiViet"]);
        $maBaiViet_sql =  "SELECT bv.*, (SELECT GROUP_CONCAT(maTheLoai) FROM phanloai WHERE maBaiViet = ".$_GET["maBaiViet"].") as maTheLoai, tg.tenHienThi as tenTacGia, tg.email as emailTacGia, tg.moTaNgan as moTaTacGia FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien WHERE maBaiViet = ".$_GET["maBaiViet"]." AND trangThai = 2";
        $maBaiViet = $csdl->query($maBaiViet_sql);
        if ($maBaiViet->num_rows == 1) {
            //Cập nhật lượt xem
            if(!in_array($_GET["maBaiViet"],$_SESSION["xemBaiViet"])) {
                $_SESSION["xemBaiViet"][] = $_GET["maBaiViet"];
                $demLuotXem_sql = "UPDATE `baiviet` SET `luotXem`= luotXem + 1 WHERE `maBaiViet` = ".$_GET["maBaiViet"];
                $csdl->query($demLuotXem_sql);
            }
            
            //Lấy thông tin bài viết
            $maBaiViet_data = $maBaiViet->fetch_array(MYSQLI_ASSOC);
            $timeago = explode(" ",$maBaiViet_data["ngayDang"]);
            $maBaiViet_data["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
            
            //Gán tiêu đề cho trang
            $tieuDe = $maBaiViet_data["tenBaiViet"]." - ".layTuyChon("tenWebsite");
            
            //Nếu có hành động gửi bình luận
            if(isset($_POST["tenNguoiBinhLuan"])) {
                if(empty($_POST["tenNguoiBinhLuan"]) || empty($_POST["emailBinhLuan"]) || empty($_POST["noiDungBinhLuan"])) {
                    $baoLoi = "Vui lòng nhập đầy đủ thông tin bình luận!";
                } elseif(!filter_var($_POST["emailBinhLuan"], FILTER_VALIDATE_EMAIL) || strlen($_POST["emailBinhLuan"]) > 255) {
                    $baoLoi = "Email không đúng định dạng hoặc dài hơn 255 ký tự";
                } elseif(strlen($_POST["tenNguoiBinhLuan"]) > 64) {
                    $baoLoi = "Họ tên không được dài hơn 64 ký tự";
                } else {
                    $dangNhap->kiemTraQuyenHan() > 0 ? $trangThai = 1 : $trangThai = 0;
                    //Khai báo thư viện html purifier
                    include_once("./includes/htmlpurifier/HTMLPurifier.auto.php");
                    $htmlPurifier_config = HTMLPurifier_Config::createDefault();
                    $htmlPurifier_config->set('HTML.Allowed', '');
                    $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
                    
                    $_POST["tenNguoiBinhLuan"] = $csdl->real_escape_string($_POST["tenNguoiBinhLuan"]);
                    $_POST["emailBinhLuan"] = $csdl->real_escape_string($_POST["emailBinhLuan"]);
                    $_POST["noiDungBinhLuan"] = $csdl->real_escape_string($htmlPurifier->purify($_POST["noiDungBinhLuan"]));
                    $_POST["noiDungBinhLuan"] = $csdl->real_escape_string($_POST["noiDungBinhLuan"]);
                    
                    $guiBinhLuan_sql = sprintf("INSERT INTO `binhluan`(`maBaiViet`, `noiDung`, `tenNguoiGui`, `emailGui`, `trangThai`) VALUES (%d,'%s','%s','%s',%d)",
                                            $_GET["maBaiViet"],
                                            $_POST["noiDungBinhLuan"],
                                            $_POST["tenNguoiBinhLuan"],
                                            $_POST["emailBinhLuan"],
                                            $trangThai);
                    $guiBinhLuan = $csdl->query($guiBinhLuan_sql);
                    if($guiBinhLuan) {
                        $thanhCong = "Bình luận của bạn đã được gửi thành công!";
                    } else {
                        $baoLoi = "Không thể thêm bình luận của bạn, vui lòng thử lại hoặc liên hệ quản trị viên!";
                    }
                }
            }
            
            //Lấy thông tin bình luận
            $dSBinhLuan_sql = "SELECT * FROM `binhluan` WHERE maBaiViet = ".$_GET["maBaiViet"]." AND trangThai = 1 ORDER BY trangThai ASC, ngayDang ASC";
            $dSBinhLuan = $csdl->query($dSBinhLuan_sql);
            $i = 0;
            while($dSBinhLuan_ketQua = $dSBinhLuan->fetch_array(MYSQLI_ASSOC)) {
                $dSBinhLuan_data[$i] = $dSBinhLuan_ketQua;
                $timeago = explode(" ",$dSBinhLuan_data[$i]["ngayDang"]);
                $dSBinhLuan_data[$i]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
                $i++;
            }
            
        } else {
            include_once("404.php");
            $_GET["chucnang"] = "404";
        }
    } else {
        include_once("404.php");
        $_GET["chucnang"] = "404";
    }
}

if($_GET["chucnang"] == "kiemDuyetBaiViet") {
    if($dangNhap->kiemTraQuyenHan() > 1) {
        if(!empty($_GET["maBaiViet"])) {
            //Anti SQL-Ịnection
            $_GET["maBaiViet"] = sprintf("%d",$_GET["maBaiViet"]);
            $maBaiViet_sql =  "SELECT bv.*, (SELECT GROUP_CONCAT(maTheLoai) FROM phanloai WHERE maBaiViet = ".$_GET["maBaiViet"].") as maTheLoai, tg.tenHienThi as tenTacGia, tg.email as emailTacGia, tg.moTaNgan as moTaTacGia FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien WHERE maBaiViet = ".$_GET["maBaiViet"]." AND trangThai != 0";
            $maBaiViet = $csdl->query($maBaiViet_sql);
            if ($maBaiViet->num_rows == 1) {
                $maBaiViet_data = $maBaiViet->fetch_array(MYSQLI_ASSOC);
                //Gán tiêu đề cho trang
                $tieuDe = $maBaiViet_data["tenBaiViet"]." - ".layTuyChon("tenWebsite");
                //Lấy cấu trúc thể loại;
                $cauTrucTheLoai = layCautrucTheLoai("all");
                if(!empty($cauTrucTheLoai)) {
                    $i = 0;
                    foreach($cauTrucTheLoai as $maTheloaiCha => $theLoaiCha_data) {
                        $dSTheLoai_data[$i]["tenTheLoai"] = $theLoaiCha_data["tenTheLoai"];
                        $dSTheLoai_data[$i]["maTheLoai"] = $maTheloaiCha;
                        $i++;
                        if(isset($theLoaiCha_data["theLoaiCon"])) {
                            foreach($theLoaiCha_data["theLoaiCon"] as $maTheLoaiCon => $theLoaiCon_data) {
                                $dSTheLoai_data[$i]["tenTheLoai"] = $theLoaiCha_data["tenTheLoai"]." / ".$theLoaiCon_data["tenTheLoai"];
                                $dSTheLoai_data[$i]["maTheLoai"] = $maTheLoaiCon;
                                $i++;
                            }
                        }
                    }
                }
                $theLoai_array = explode(",",$maBaiViet_data["maTheLoai"]);
    
            } else {
                echo "1";
                include_once("404.php");
                $_GET["chucnang"] = "404";
            }
        } else {
            echo "2";
            include_once("404.php");
            $_GET["chucnang"] = "404";
        }
    } else {
        echo "3";
        include_once("404.php");
        $_GET["chucnang"] = "404";
    }
}