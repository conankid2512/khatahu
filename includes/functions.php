<?php

/*************************/
/*Global Function Section*/
/*************************/

//Lấy các tùy chỉnh của trang web từ csdl
function layTuyChon($tenTuyChon,$cache = true) {
    global $csdl, $tuychon;
    
    //Kiểm tra tính năng cache và tồn tại của cache
    if($cache && isset($tuychon[$tenTuyChon])) {
        
        //Trả về giá trị đã cache
        return $tuychon[$tenTuyChon];
    }
    
    //Lấy thông tin từ csdl
    $layTuyChon_sql = "SELECT noiDung FROM tuychon WHERE tenTuyChon = '". $csdl->real_escape_string($tenTuyChon) ."'";
    $layTuyChon = $csdl->query($layTuyChon_sql);
    
    //Nếu có trong csdl
    if($layTuyChon) {
        $layTuyChon_ketQua = $layTuyChon->fetch_array(MYSQLI_ASSOC);
        $tuychon[$tenTuyChon] = $layTuyChon_ketQua["noiDung"];
        return $layTuyChon_ketQua["noiDung"];
    } else {
        
        //Nếu không có trong csdl
        $tuychon[$tenTuyChon] = "##ERROR##";
        return "##ERROR##";
    }
}


//Lưu lại các tùy chọn và csdl
function luuTuyChon($tenTuyChon,$giaTrituyChon) {
    global $csdl;
    
    //Escape string trước khi viết lệnh SQL
    $giaTrituyChon = $csdl->real_escape_string($giaTrituyChon);
    
    //Chèn thông tin vào csdl, nếu tùy chọn đã có tiến hành update
    $luuTuyChon_sql = "INSERT INTO tuychon (tenTuyChon,noiDung) VALUES ('".$tenTuyChon."','".$giaTrituyChon."') ON DUPLICATE KEY UPDATE noiDung=VALUES(noiDung)";
    
    //Thực hiện câu lệnh SQL
    $luuTuyChon = $csdl->query($luuTuyChon_sql);
    
    //Trả về kết quả thực hiện
    return $luuTuyChon;
}

//Hiển thị tên quyền hạn
$tenQuyenHan[0] = "Khách vãng lai";
$tenQuyenHan[1] = "Phóng viên";
$tenQuyenHan[2] = "Biên tập viên";
$tenQuyenHan[3] = "Quản trị viên";
function tenQuyenHan($maQuyenHan) {
    if($maQuyenHan < 0) {
        return "Bị khóa";
    }
    global $tenQuyenHan;
    return $tenQuyenHan[$maQuyenHan];
}

//Hiển thị trạng thái bài viết
$tenTrangThai[0] = "Lưu nháp";
$tenTrangThai[1] = "Chờ duyệt";
$tenTrangThai[2] = "Đã duyệt";
$tenTrangThai[3] = "Bị từ chối";
function tenTrangThaiBaiViet($maTrangThai) {
    global $tenTrangThai;
    return $tenTrangThai[$maTrangThai];
}

//Lấy cấu trúc thể loại
function layCautrucTheLoai($theLoai = 0) {
    global $csdl;
    $cauTrucTheLoai = null;
    $tmp = null;
    if($theLoai == 0 || $theLoai === "all") {
        $cauTruc_sql = "SELECT maTheLoai, tenTheLoai, tTMenu, tTTrangChu FROM theloai WHERE maTheLoaiCha IS NULL ORDER BY tenTheLoai ASC";
    } else {
        $cauTruc_sql = "SELECT maTheLoai, tenTheLoai, tTMenu, tTTrangChu FROM theloai WHERE maTheLoaiCha = ".$theLoai."  ORDER BY tenTheLoai ASC";
    }
    $cauTruc = $csdl->query($cauTruc_sql);
    if($cauTruc) {
        while($cauTruc_ketQua = $cauTruc->fetch_array(MYSQLI_ASSOC)) {
            $cauTrucTheLoai[$cauTruc_ketQua["maTheLoai"]] = $cauTruc_ketQua;
            if($theLoai === "all") {
                $tmp = layCautrucTheLoai($cauTruc_ketQua["maTheLoai"],true);
                if($tmp != null) {
                    $cauTrucTheLoai[$cauTruc_ketQua["maTheLoai"]]["theLoaiCon"] = $tmp;
                }
            }
        }
    } 
    return $cauTrucTheLoai;
}

//Hiển thị top menu
function hienThiTopMenu() {
    global $csdl;
    $topMenu = "<li class=\"active\"><a href=\"".layTuyChon("urlChinh")."\">TRANG CHủ</a></li>";
    $topLevel_sql = "SELECT maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha IS NULL AND tTMenu > 0 ORDER BY tTMenu ASC, tenTheLoai ASC";
    $topLevel = $csdl->query($topLevel_sql);
    if($topLevel) {
        while($topLevel_ketQua = $topLevel->fetch_array(MYSQLI_ASSOC)) {
            $secondLevel_sql = "SELECT maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha = ".$topLevel_ketQua["maTheLoai"]." AND tTMenu > 0 ORDER BY tTMenu ASC, tenTheLoai ASC";
            $secondLevel = $csdl->query($secondLevel_sql);
            if($secondLevel && $secondLevel->num_rows > 0) {
                $topMenu .= "<li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"".layTuyChon("urlChinh")."?chucnang=theLoai&maTheLoai=".$topLevel_ketQua["maTheLoai"]."\">".$topLevel_ketQua["tenTheLoai"]."</a><span data-toggle=\"dropdown\" class=\"dropdown-toggle ion-ios7-arrow-down nav-icn khatahu\"></span>";
                $topMenu .= "<ul class=\"dropdown-menu text-capitalize\" role=\"menu\">";
                while($secondLevel_ketQua = $secondLevel->fetch_array(MYSQLI_ASSOC)) {
                    $topMenu .= "<li><a href=\"".layTuyChon("urlChinh")."?chucnang=theLoai&maTheLoai=".$secondLevel_ketQua["maTheLoai"]."\"><span class=\"ion-ios7-arrow-right nav-sub-icn\"></span>".$secondLevel_ketQua["tenTheLoai"]."</a></li>";
                }
                $topMenu .= "</ul></li>";
            } else {
                $topMenu .= "<li><a href=\"".layTuyChon("urlChinh")."?chucnang=theLoai&maTheLoai=".$topLevel_ketQua["maTheLoai"]."\">".$topLevel_ketQua["tenTheLoai"]."</a></li>";
            }
        }
    }
    return $topMenu;
}

//Lấy thông tin top bài viết
function topBaiViet() {
    global $csdl;
    $topBaiViet = NULL;
    $xemNhieu_sql = "SELECT * FROM baiViet WHERE ngayDang > DATE_SUB(NOW(), INTERVAL 30 DAY) AND trangThai = 2 ORDER BY luotXem DESC, ngayDang DESC LIMIT 5";
    $xemNhieu = $csdl->query($xemNhieu_sql);
    if($xemNhieu) {
        $i = 0;
        while($xemNhieu_ketQua = $xemNhieu->fetch_array(MYSQLI_ASSOC)) {
            $topBaiViet["xemNhieu"][$i] = $xemNhieu_ketQua;
            $timeago = explode(" ",$topBaiViet["xemNhieu"][$i]["ngayDang"]);
            $topBaiViet["xemNhieu"][$i]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
            $i++;
        }
    }
    
    $binhLuanNhieu_sql = "SELECT * FROM baiViet WHERE ngayDang > DATE_SUB(NOW(), INTERVAL 30 DAY) AND trangThai = 2 ORDER BY luotBinhLuan DESC, ngayDang DESC LIMIT 5";
    $binhLuanNhieu = $csdl->query($binhLuanNhieu_sql);
    if($binhLuanNhieu) {
        $i = 0;
        while($binhLuanNhieu_ketQua = $binhLuanNhieu->fetch_array(MYSQLI_ASSOC)) {
            $topBaiViet["binhLuanNhieu"][$i] = $binhLuanNhieu_ketQua;
            $timeago = explode(" ",$topBaiViet["binhLuanNhieu"][$i]["ngayDang"]);
            $topBaiViet["binhLuanNhieu"][$i]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
            $i++;
        }
    }
    
    $moiNhat_sql = "SELECT * FROM baiViet ORDER BY ngayDang DESC LIMIT 5";
    $moiNhat = $csdl->query($moiNhat_sql);
    if($moiNhat) {
        $i = 0;
        while($moiNhat_ketQua = $moiNhat->fetch_array(MYSQLI_ASSOC)) {
            $topBaiViet["moiNhat"][$i] = $moiNhat_ketQua;
            $timeago = explode(" ",$topBaiViet["moiNhat"][$i]["ngayDang"]);
            $topBaiViet["moiNhat"][$i]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
            $i++;
        }
    }
    return $topBaiViet;
}

//Hàm Gravatar
function layGravatar( $email, $s = 64, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

/************************/
/*Admin Function Section*/
/************************/

//Tô màu menu tương ứng với chức năng
function activeMenu($mucActive,$class = true) {
    global $cauHinhChucNang;
    if($cauHinhChucNang[$_GET["chucnang"]]["activeMenu"] == $mucActive) {
        if($class) {
            echo " class=\"active\"";
        } else echo "active";
    }
}

//Mở sub menu tương ứng chức năng
function subOpen($mucOpen) {
    global $cauHinhChucNang;
    if(isset($cauHinhChucNang[$_GET["chucnang"]]["subOpen"]) && $cauHinhChucNang[$_GET["chucnang"]]["subOpen"] == $mucOpen) {
        echo " open";
    }
}

//Kiểm tra tồn tại thể loại
function kiemTraTheLoai(array $theLoai) {
    global $csdl;
    $kiemTraTheLoai_sql = "SELECT IFNULL(GROUP_CONCAT(maTheLoai),'NULL') as maTheLoai FROM theloai WHERE maTheLoai IN (".implode(",",$theLoai).")";
    $kiemTraTheLoai = $csdl->query($kiemTraTheLoai_sql);
    if($kiemTraTheLoai) {
        $kiemTraTheLoai_ketQua = $kiemTraTheLoai->fetch_array(MYSQLI_ASSOC);
        $kiemTraTheLoai_ketQua = explode(",",$kiemTraTheLoai_ketQua["maTheLoai"]);
        return $kiemTraTheLoai_ketQua;
    }
    return "NULL";
}