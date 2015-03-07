<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}

/***********************************************/
/*Kiểm tra xem mã bài viết có tồn tại hay không*/
/***********************************************/

$maBaiViet_data = null;
if($_GET["chucnang"] == "suaBaiViet" || $_GET["chucnang"] == "xoaBaiViet") {
    if(!empty($_GET["maBaiViet"])) {
        //Anti SQL-Ịnection
        $_GET["maBaiViet"] = sprintf("%d",$_GET["maBaiViet"]);
        $maBaiViet_sql =  "SELECT *, (SELECT GROUP_CONCAT(maTheLoai) FROM phanloai WHERE maBaiViet = ".$_GET["maBaiViet"].") as maTheLoai FROM baiviet WHERE maBaiViet = ".$_GET["maBaiViet"];
        $maBaiViet = $csdl->query($maBaiViet_sql);
        if ($maBaiViet->num_rows == 1) {
            $maBaiViet_data = $maBaiViet->fetch_array(MYSQLI_ASSOC);
        } else {
            $baoLoi = "Mã bài viết không tồn tại!";
        }
    } else {
        $baoLoi = "Không có mã bài viết!"; 
    }
}


/*************************/
/*Chức năng thêm bài viết*/
/*************************/

if($_GET["chucnang"] == "themBaiViet") {
    //Lấy cấu trúc thể loại
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
    //Xử lý thông tin bài viết
    if(isset($_POST["tenBaiViet"])) {
        //Kiểm tra hình đại diện
        $kiemTraHinh = false;
        if(!empty($_POST["hinhNho"])) {
            $_POST["hinhNho"] = str_replace($_SESSION["baseURL"],"/",$_POST["hinhNho"]);
            if(file_exists("..".$_POST["hinhNho"])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $kieuFile = finfo_file($finfo, "..".$_POST["hinhNho"]);
                $kieuHinh = array("image/gif","image/jpeg","image/png","image/bmp");
                if(in_array($kieuFile,$kieuHinh)) {
                    $kiemTraHinh = true;
                }
            }
        }
        if(empty($_POST["tenBaiViet"])) {
            $baoLoi = "Tên bài viết rỗng";
        } elseif (!$kiemTraHinh) {
            $baoLoi = "Hình đại diện không hợp lệ!";
        } elseif (($dangNhap->kiemTraQuyenHan(0) < 2 && $_POST["trangThai"] == 2) || $_POST["trangThai"] > 2 || $_POST["trangThai"] < 0 || !is_numeric($_POST["trangThai"])) {
            $baoLoi = "Mã trạng thái không hợp lệ";
        } else {
            //Khai báo thư viện html purifier
            include_once("../includes/htmlpurifier/HTMLPurifier.auto.php");
            $htmlPurifier_config = HTMLPurifier_Config::createDefault();
            $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
            
            //Lọc lại các thông tin
            $_POST["tenBaiViet"] = strip_tags($_POST["tenBaiViet"]);
            $_POST["noiDung"] = $htmlPurifier->purify($_POST["noiDung"]);
            
            //Kiểm tra tính hợp lệ của mã thể loại
            if(!empty($_POST["theLoai"])) {
                $_POST["theLoai"] = array_filter($_POST["theLoai"], "is_numeric");
            }
            if(!empty($_POST["theLoai"])) {
                $_POST["theLoai"] = kiemTraTheLoai($_POST["theLoai"]);
            } else {
                $_POST["theLoai"] = array("NULL");
            }

            //Kiểm tra mã kiểm duyệt
            if($_POST["trangThai"] == 2) {
                $maKiemDuyet = $_SESSION["dangNhap"]["maNhanVien"];
                $ngayKiemDuyet = "CURRENT_TIMESTAMP";
            } else {
                $maKiemDuyet = "NULL";
                $ngayKiemDuyet = "NULL";
            }
            //Bắt đầu mysql transaction
            $csdl->autocommit(false);
            
            //Đưa thông tin bài viết vào mysql
            $themBaiViet_sql = "INSERT INTO `baiviet`(`maTacGia`, `tenBaiViet`, `noiDung`, `hinhNho`, `trangThai`, `maKiemDuyet`, `ngayKiemDuyet`) VALUES (%d,'%s','%s','%s',%d, ".$maKiemDuyet.",".$ngayKiemDuyet.")";
            $themBaiViet_sql = sprintf($themBaiViet_sql,
                                       $_SESSION["dangNhap"]["maNhanVien"],
                                       $csdl->real_escape_string($_POST["tenBaiViet"]),
                                       $csdl->real_escape_string($_POST["noiDung"]),
                                       $csdl->real_escape_string($_POST["hinhNho"]),
                                       $_POST["trangThai"]);
            $themBaiViet = $csdl->query($themBaiViet_sql);
            if($themBaiViet) {
                //Thêm phân loại vào mysql
                foreach($_POST["theLoai"] as $maTheLoai) {
                    $phanLoai_sqlvalue[] = "(".$csdl->insert_id.",".$maTheLoai.")";
                }
                $phanLoai_sqlvalue = implode(",",$phanLoai_sqlvalue);
                $phanLoai_sql = "INSERT INTO `phanloai`(`maBaiViet`, `maTheLoai`) VALUES ".$phanLoai_sqlvalue;
                $phanLoai = $csdl->query($phanLoai_sql);
                if($phanLoai) {
                    //Kết thúc mysql transaction
                    $csdl->commit();
                    $csdl->autocommit(true);
                    $thanhCong = "Thêm bài viết thành công!";
                } else {
                    $csdl->rollback();
                    $baoLoi = "Không thể thêm bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
                }
            } else {
                $csdl->rollback();
                $baoLoi = "Không thể thêm bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
            }
        }
    }
}

/************************/
/*Chức năng sửa bài viết*/
/************************/

if($_GET["chucnang"] == "suaBaiViet" && $maBaiViet_data) {
    //Lấy cấu trúc thể loại
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
    
    //Kiểm tra quyền edit
    $quyenSua = true;
    if($maBaiViet_data["maTacGia"] != $_SESSION["dangNhap"]["maNhanVien"]) {
        $baoLoi = "Bạn chỉ có thể chỉnh sửa bài viết của chính mình!";
        $quyenSua = false;
    } elseif($maBaiViet_data["trangThai"] == 2 && $dangNhap->kiemTraQuyenHan() < 2) {
        $baoLoi = "Bài viết đã được duyệt, vui lòng yêu cầu biên tập viên đưa về trạng thái chờ duyệt trước khi chỉnh sửa!";
        $quyenSua = false;
    } elseif(isset($_POST["tenBaiViet"])) {//Xử lý thông tin bài viết
        //Kiểm tra hình đại diện
        $kiemTraHinh = false;
        if(!empty($_POST["hinhNho"])) {
            $_POST["hinhNho"] = str_replace($_SESSION["baseURL"],"/",$_POST["hinhNho"]);
            if(file_exists("..".$_POST["hinhNho"])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $kieuFile = finfo_file($finfo, "..".$_POST["hinhNho"]);
                $kieuHinh = array("image/gif","image/jpeg","image/png","image/bmp");
                if(in_array($kieuFile,$kieuHinh)) {
                    $kiemTraHinh = true;
                }
            }
        }
        
        if(empty($_POST["tenBaiViet"])) {
            $baoLoi = "Tên bài viết rỗng";
        } elseif (!$kiemTraHinh) {
            $baoLoi = "Hình đại diện không hợp lệ!";
        } elseif (($dangNhap->kiemTraQuyenHan(0) < 2 && $_POST["trangThai"] == 2) || $_POST["trangThai"] > 2 || $_POST["trangThai"] < 0 || !is_numeric($_POST["trangThai"])) {
            $baoLoi = "Mã trạng thái không hợp lệ";
        } else {
            //Khai báo thư viện html purifier
            include_once("../includes/htmlpurifier/HTMLPurifier.auto.php");
            $htmlPurifier_config = HTMLPurifier_Config::createDefault();
            $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
            
            //Lọc lại các thông tin
            $_POST["tenBaiViet"] = strip_tags($_POST["tenBaiViet"]);
            $_POST["noiDung"] = $htmlPurifier->purify($_POST["noiDung"]);
            
            //Kiểm tra tính hợp lệ của mã thể loại
            if(!empty($_POST["theLoai"])) {
                $_POST["theLoai"] = array_filter($_POST["theLoai"], "is_numeric");
            }
            if(!empty($_POST["theLoai"])) {
                $_POST["theLoai"] = kiemTraTheLoai($_POST["theLoai"]);
            } else {
                $_POST["theLoai"] = array("NULL");
            }


            //Kiểm tra mã kiểm duyệt
            if($_POST["trangThai"] == 2) {
                $maKiemDuyet = $_SESSION["dangNhap"]["maNhanVien"];
                $ngayKiemDuyet = "CURRENT_TIMESTAMP";
            } else {
                $maKiemDuyet = "NULL";
                $ngayKiemDuyet = "NULL";
            }
            
            //Bắt đầu mysql transaction
            $csdl->autocommit(false);
            
            //Đưa thông tin bài viết vào mysql
            
            $suaBaiViet_sql = "UPDATE `baiviet` SET `maKiemDuyet`= ".$maKiemDuyet.",`tenBaiViet`= '%s',`noiDung`= '%s',`hinhNho`= '%s',`trangThai`= %d,`ngayDang`= CURRENT_TIMESTAMP,`ngayKiemDuyet`= ".$ngayKiemDuyet." WHERE `maBaiViet`= ".$_GET["maBaiViet"];
            $suaBaiViet_sql = sprintf($suaBaiViet_sql,
                                       $csdl->real_escape_string($_POST["tenBaiViet"]),
                                       $csdl->real_escape_string($_POST["noiDung"]),
                                       $csdl->real_escape_string($_POST["hinhNho"]),
                                       $_POST["trangThai"]);
                                       
            $suaBaiViet = $csdl->query($suaBaiViet_sql);
            
            //Nếu query không thành công, báo lỗi, rollback
            if($suaBaiViet) {
                //Xóa các khóa phân loại cũ
                $xoaPhanLoai_sql = "DELETE FROM `phanloai` WHERE `maBaiViet` = ".$_GET["maBaiViet"];
                $xoaPhanLoai = $csdl->query($xoaPhanLoai_sql);
                
                //Nếu query không thành công, báo lỗi, rollback                
                if($xoaPhanLoai) {
                    //Thêm phân loại mới vào mysql
                    foreach($_POST["theLoai"] as $maTheLoai) {
                        $phanLoai_sqlvalue[] = "(".$_GET["maBaiViet"].",".$maTheLoai.")";
                    }
                    $phanLoai_sqlvalue = implode(",",$phanLoai_sqlvalue);
                    $phanLoai_sql = "INSERT INTO `phanloai`(`maBaiViet`, `maTheLoai`) VALUES ".$phanLoai_sqlvalue;
                    $phanLoai = $csdl->query($phanLoai_sql);
                    if($phanLoai) {
                        //Kết thúc mysql transaction
                        $csdl->commit();
                        $csdl->autocommit(true);
                        $thanhCong = "Cập nhật bài viết thành công!";
                        
                        //Lấy thông tin bài viết vừa cập nhật
                        $maBaiViet = $csdl->query($maBaiViet_sql);
                        $maBaiViet_data = $maBaiViet->fetch_array(MYSQLI_ASSOC);
                    } else {
                        $csdl->rollback();
                        $baoLoi = "Không thể chỉnh sửa bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
                    }    
                } else {
                    $csdl->rollback();
                    $baoLoi = "Không thể chỉnh sửa bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
                }
                
            } else {
                $csdl->rollback();
                $baoLoi = "Không thể chỉnh sửa bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
            }
        }
    }
}

/************************/
/*Chức năng xóa bài viết*/
/************************/

if($_GET["chucnang"] == "xoaBaiViet" && $maBaiViet_data) {
    $quyenXoa = 0;
    
    //Kiểm tra quyền xóa
    if($dangNhap->kiemTraQuyenHan(0) == 1) { //Phóng viên
        if($maBaiViet_data["maTacGia"] != $_SESSION["dangNhap"]["maNhanVien"]) { //Phóng viên khác
            $baoLoi = "Bạn chỉ có thể xóa bài viết của mình!";
        } elseif ($maBaiViet_data["maTacGia"] == $_SESSION["dangNhap"]["maNhanVien"] && $maBaiViet_data["trangThai"] == 2) { //Phóng viên tác giả, bài viết đã duyệt
            $baoLoi = "Bài viết đã được duyệt, vui lòng yêu cầu biên tập viên đưa về trạng thái chờ duyệt trước khi xóa!";
        } else { //Phóng viên tác giả, bài viết chưa duyệt
            $quyenXoa = 1;
        }
        
    } else { //BTV, QTV
        if($maBaiViet_data["maTacGia"] == $_SESSION["dangNhap"]["maNhanVien"]) { //Admin, có quyền tác giả
            $quyenXoa = 1;
        } elseif($maBaiViet_data["trangThai"] == 1 || $maBaiViet_data["trangThai"] == 4) { //Admin, không có quyền tác giả, bài viết đang lưu nháp hoặc bị từ chối
            $baoLoi = "Bạn không thể xóa bài viết đang lưu nháp của tác giả khác!";
        } else { //Admin, không có quyền tác giả, bài viết chờ duyệt / đã duyệt
            $quyenXoa = 1;
        }
    }
    
    //Xóa bài viết
    $xoaBaiViet_sql = "DELETE FROM `baiviet` WHERE `maBaiViet` = ".$_GET["maBaiViet"];
    $xoaBaiViet = $csdl->query($xoaBaiViet_sql);
    if($xoaBaiViet) {
        $thanhCong = "Đã xóa bài viết thành công!";
    } else {
        $baoLoi = "Truy vấn csdl thất bại, vui lòng thử lại!";
    }
}




/******************************/
/*Chức năng danh sách bài viết*/
/******************************/

if($_GET["chucnang"] == "dSBaiViet" || $_GET["chucnang"] == "xoaBaiViet" || ($_GET["chucnang"] == "kiemDuyetBaiViet" && !isset($_GET["maBaiViet"])) ) {
    $dSBaiViet_sql = "SELECT bv.*, tg.tenDangNhap as tenTacGia, kd.tenDangNhap as tenKiemDuyet FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien LEFT JOIN nhanvien kd ON bv.maKiemDuyet = kd.maNhanVien WHERE bv.`maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." ORDER BY ngayDang DESC";
    if($_GET["chucnang"] == "kiemDuyetBaiViet" && $dangNhap->kiemTraQuyenHan(0) >= 2) {
        $dSBaiViet_sql = "SELECT bv.*, tg.tenDangNhap as tenTacGia, kd.tenDangNhap as tenKiemDuyet FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien LEFT JOIN nhanvien kd ON bv.maKiemDuyet = kd.maNhanVien WHERE `trangThai` = 1 ORDER BY ngayDang DESC";
    } elseif($dangNhap->kiemTraQuyenHan(0) >= 2) {
        $dSBaiViet_sql = "SELECT bv.*, tg.tenDangNhap as tenTacGia, kd.tenDangNhap as tenKiemDuyet FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien LEFT JOIN nhanvien kd ON bv.maKiemDuyet = kd.maNhanVien WHERE `maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." OR `trangThai` > 0 ORDER BY ngayDang DESC";
    }
    $dSBaiViet = $csdl->query($dSBaiViet_sql);
    $i = 0;
    while($dSBaiViet_ketQua = $dSBaiViet->fetch_array(MYSQLI_ASSOC)) {
        $dSBaiViet_data[$i] = $dSBaiViet_ketQua;
        if($dangNhap->kiemTraQuyenHan() < 2) {
            $dSBaiViet_data[$i]["linkKiemDuyet"] = "";
        } else {
            $dSBaiViet_data[$i]["linkKiemDuyet"] = "<td><a href=\"".layTuyChon("urlChinh")."admin/?chucnang=kiemDuyetBaiViet&maBaiViet=".$dSBaiViet_ketQua["maBaiViet"]."\"><i class=\"fa fa-tasks\"></i></a></td>";
        }
        
        if($dSBaiViet_ketQua["maTacGia"] == $_SESSION["dangNhap"]["maNhanVien"]) {
            $dSBaiViet_data[$i]["linkEdit"] = "<a href=\"".layTuyChon("urlChinh")."admin/?chucnang=suaBaiViet&maBaiViet=".$dSBaiViet_ketQua["maBaiViet"]."\"><i class=\"fa fa-edit\"></i></a>";
        } else {
            $dSBaiViet_data[$i]["linkEdit"] = "<i class=\"fa fa-edit\"></i>";
        }
        
        $dSBaiViet_data[$i]["linkDel"] = "<a data-mabaiviet=\"".$dSBaiViet_ketQua["maBaiViet"]."\" data-tenbaiviet=\"".$dSBaiViet_ketQua["tenBaiViet"]."\" data-tentacgia=\"".$dSBaiViet_ketQua["tenTacGia"]."\" class=\"xoaBaiVietURL\" href=\"javascript:;\" data-toggle=\"modal\" data-target=\"#xoaBaiVietModal\"><i class=\"fa fa-times\"></i></a>";
        $dSBaiViet_data[$i]["linkBaiViet"] = "<a href=\"".layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$dSBaiViet_ketQua["maBaiViet"]."\">".$dSBaiViet_ketQua["tenBaiViet"]."</a>";
        $i++;
    }
    if($i == 0) {
        $baoLoi = "Danh sách bài viết rỗng!";
    }
}

?>