<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}

/***********************************************/
/*Kiểm tra xem mã bài viết có tồn tại hay không*/
/***********************************************/

$maBaiViet_data = null;
if($_GET["chucnang"] == "suaBaiViet" || $_GET["chucnang"] == "xoaBaiViet" || $_GET["chucnang"] == "kiemDuyetBaiViet") {
    if(!empty($_POST["maBaiViet"])) $_GET["maBaiViet"] = $_POST["maBaiViet"];
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
            $_POST["hinhNho"] = urldecode($_POST["hinhNho"]);
            if (substr($_POST["hinhNho"], 0, strlen($_SESSION["baseURL"])) == $_SESSION["baseURL"]) {
                $_POST["hinhNho"] = substr($_POST["hinhNho"], strlen($_SESSION["baseURL"]));
            }
            echo $_POST["hinhNho"];
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
        $quyenSua = false;
        $baoLoi = "Bạn chỉ có thể chỉnh sửa bài viết của chính mình!";
    } elseif($maBaiViet_data["trangThai"] == 2 && $dangNhap->kiemTraQuyenHan() < 2) {
        $quyenSua = false;
        $baoLoi = "Bài viết đã được duyệt, vui lòng yêu cầu biên tập viên đưa về trạng thái chờ duyệt trước khi chỉnh sửa!";
    } elseif(isset($_POST["tenBaiViet"])) {//Xử lý thông tin bài viết
        //Kiểm tra hình đại diện
        $kiemTraHinh = false;
        if(!empty($_POST["hinhNho"])) {
            $_POST["hinhNho"] = urldecode($_POST["hinhNho"]);
            if (substr($_POST["hinhNho"], 0, strlen($_SESSION["baseURL"])) == $_SESSION["baseURL"]) {
                $_POST["hinhNho"] = substr($_POST["hinhNho"], strlen($_SESSION["baseURL"]));
            }
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

/*******************************/
/*Chức năng kiểm duyệt bài viết*/
/*******************************/

if($_GET["chucnang"] == "kiemDuyetBaiViet" && $maBaiViet_data) {
    //Kiểm tra quyền edit
    if($dangNhap->kiemTraQuyenHan() < 2) {
        $baoLoi = "Bạn không có quyền sử dụng chức năng này!";
    } elseif($maBaiViet_data["trangThai"] == 0) {
        $baoLoi = "Bài viết hiện còn đang lưu nháp, bạn không thể kiểm duyệt được!";
    } elseif(isset($_POST["maBaiViet"])) {//Xử lý thông tin bài viết
        //Kiểm tra hình đại diện
        $kiemTraHinh = false;
        
        if(!empty($_POST["hinhNho"])) {
            $_POST["hinhNho"] = urldecode($_POST["hinhNho"]);
            if (substr($_POST["hinhNho"], 0, strlen($_SESSION["baseURL"])) == $_SESSION["baseURL"]) {
                $_POST["hinhNho"] = substr($_POST["hinhNho"], strlen($_SESSION["baseURL"]));
            }
            if(file_exists("..".$_POST["hinhNho"])) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $kieuFile = finfo_file($finfo, "..".$_POST["hinhNho"]);
                $kieuHinh = array("image/gif","image/jpeg","image/png","image/bmp");
                if(in_array($kieuFile,$kieuHinh)) {
                    $kiemTraHinh = true;
                }
            }
        }
        if (!$kiemTraHinh) {
            $baoLoi = "Hình đại diện không hợp lệ!";
        } elseif ($_POST["trangThai"] == 0 || !is_numeric($_POST["trangThai"])) {
            $baoLoi = "Mã trạng thái không hợp lệ";
        } else {
            
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
            $maKiemDuyet = $_SESSION["dangNhap"]["maNhanVien"];
            $ngayKiemDuyet = "CURRENT_TIMESTAMP";
            
            //Bắt đầu mysql transaction
            $csdl->autocommit(false);
            
            //Đưa thông tin bài viết vào mysql
            
            $kiemDuyetBaiViet_sql = "UPDATE `baiviet` SET `maKiemDuyet`= %d,`hinhNho`= '%s',`trangThai`= %d,`ngayDang`= CURRENT_TIMESTAMP,`ngayKiemDuyet`= CURRENT_TIMESTAMP WHERE `maBaiViet`= ".$_GET["maBaiViet"];
            $kiemDuyetBaiViet_sql = sprintf($kiemDuyetBaiViet_sql,
                                       $_SESSION["dangNhap"]["maNhanVien"],
                                       $csdl->real_escape_string($_POST["hinhNho"]),
                                       $_POST["trangThai"]);
                                       
            $kiemDuyetBaiViet = $csdl->query($kiemDuyetBaiViet_sql);
            
            //Nếu query không thành công, báo lỗi, rollback
            if($kiemDuyetBaiViet) {
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
                        $thanhCong = "Kiểm duyệt bài viết thành công!";
                        
                        //Lấy thông tin bài viết vừa cập nhật
                        $maBaiViet = $csdl->query($maBaiViet_sql);
                        $maBaiViet_data = $maBaiViet->fetch_array(MYSQLI_ASSOC);
                    } else {
                        $csdl->rollback();
                        $baoLoi = "Không thể kiểm duyệt bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
                    }    
                } else {
                    $csdl->rollback();
                    $baoLoi = "Không thể kiểm duyệt bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
                }
                
            } else {
                $csdl->rollback();
                $baoLoi = "Không thể kiểm duyệt bài viết, vui lờng thử lại hoặc liên hệ quản trị viên!";
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

if($_GET["chucnang"] == "dSBaiViet" || $_GET["chucnang"] == "xoaBaiViet" || ($_GET["chucnang"] == "kiemDuyetBaiViet" && $dangNhap->kiemTraQuyenHan(0) >= 2)) {
    $_GET["chucnang"] = "dSBaiViet";
    $trang = isset($_GET['trang']) ? ((int) $_GET['trang']) : 1;
    $batDau =  ($trang - 1) * 10;
    
    $trangThai_sql[4] = "";
    $trangThai_sql[3] = " AND trangThai = 3";
    $trangThai_sql[2] = " AND trangThai = 2";
    $trangThai_sql[1] = " AND trangThai = 1";
    $trangThai_sql[0] = " AND trangThai = 0";
    
    $trangThai = isset($_GET['trangThai']) ? $_GET['trangThai'] : "tatCa";
    
    switch ($trangThai) {
        case "luuNhap":
            $trangThai = 0;
            break;
        case "choDuyet":
            $trangThai = 1;
            break;
        case "daDuyet":
            $trangThai = 2;
            break;
        case "tuChoi":
            $trangThai = 3;
            break;
        default:
            $trangThai = 4;
    }
    
    
    if($dangNhap->kiemTraQuyenHan(0) >= 2) {
        $dSBaiViet_sql = "SELECT bv.*, tg.tenDangNhap as tenTacGia, kd.tenDangNhap as tenKiemDuyet FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien LEFT JOIN nhanvien kd ON bv.maKiemDuyet = kd.maNhanVien WHERE (bv.`maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." OR `trangThai` > 0)".$trangThai_sql[$trangThai]." ORDER BY ngayDang DESC LIMIT $batDau, 10";
        $dem_sql = "SELECT COUNT(*) as demBaiViet FROM baiviet WHERE (`maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." OR `trangThai` > 0)".$trangThai_sql[$trangThai];
        $dem_trangThai_sql = "SELECT COUNT(*) as demBaiViet, trangThai FROM baiviet WHERE `maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." OR `trangThai` > 0 GROUP BY trangThai";
    } else {
        $dSBaiViet_sql = "SELECT bv.*, tg.tenDangNhap as tenTacGia, kd.tenDangNhap as tenKiemDuyet FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien LEFT JOIN nhanvien kd ON bv.maKiemDuyet = kd.maNhanVien WHERE bv.`maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"].$trangThai_sql[$trangThai]." ORDER BY ngayDang DESC LIMIT $batDau, 10";
        $dem_sql = "SELECT COUNT(*) as demBaiViet FROM baiviet WHERE `maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"].$trangThai_sql[$trangThai];
        $dem_trangThai_sql = "SELECT COUNT(*) as demBaiViet, trangThai FROM baiviet WHERE `maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." GROUP BY trangThai";
    }
    
    $dem = $csdl->query($dem_sql);
    if($dem) {
        $dem = $dem->fetch_array(MYSQLI_ASSOC);
        $dem = $dem["demBaiViet"];
    }
    //
    include_once("../includes/pagination/Pagination.class.php");

    // instantiate; set current page; set number of records
    $phanTrang = (new Pagination());
    $phanTrang->setCurrent($trang);
    $phanTrang->setTotal($dem);
    $phanTrang_html = $phanTrang->parse();
    
    
    $dem_trangThai_data[0] = 0;
    $dem_trangThai_data[1] = 0;
    $dem_trangThai_data[2] = 0;
    $dem_trangThai_data[3] = 0;
    $dem_trangThai_data[4] = 0;
    
    $dem_trangThai = $csdl->query($dem_trangThai_sql);
    while($dem_trangThai_ketQua = $dem_trangThai->fetch_array(MYSQLI_ASSOC)) {
        $dem_trangThai_data[$dem_trangThai_ketQua["trangThai"]] = $dem_trangThai_ketQua["demBaiViet"];
        $dem_trangThai_data[4] += $dem_trangThai_ketQua["demBaiViet"];
    }
    
    $dSBaiViet = $csdl->query($dSBaiViet_sql);
    $i = 0;
    while($dSBaiViet_ketQua = $dSBaiViet->fetch_array(MYSQLI_ASSOC)) {
        $dSBaiViet_data[$i] = $dSBaiViet_ketQua;
        if($dangNhap->kiemTraQuyenHan() < 2) {
            $dSBaiViet_data[$i]["linkKiemDuyet"] = "";
        } else {
            $dSBaiViet_data[$i]["linkKiemDuyet"] = "<td><a href=\"".layTuyChon("urlChinh")."?chucnang=kiemDuyetBaiViet&maBaiViet=".$dSBaiViet_ketQua["maBaiViet"]."\"><i class=\"fa fa-tasks\"></i></a></td>";
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