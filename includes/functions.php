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
function tenQuyenHan($maQuyenHan) {
    if($maQuyenHan < 0) {
        return "Bị khóa";
    }
    $quyenHan[0] = "Khách vãng lai";
    $quyenHan[1] = "Phóng viên";
    $quyenHan[2] = "Biên tập viên";
    $quyenHan[3] = "Quản trị viên";
    return $quyenHan[$maQuyenHan];
}

//Lấy cấu trúc thể loại
function layCautrucTheLoai($theLoai = 0) {
    global $csdl;
    $cauTrucTheLoai = null;
    $tmp = null;
    if($theLoai == 0 || $theLoai === "all") {
        $cauTruc_sql = "SELECT maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha IS NULL ORDER BY tenTheLoai ASC";
    } else {
        $cauTruc_sql = "SELECT maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha = ".$theLoai."  ORDER BY tenTheLoai ASC";
    }
    $cauTruc = $csdl->query($cauTruc_sql);
    if($cauTruc) {
        while($cauTruc_ketQua = $cauTruc->fetch_array(MYSQLI_ASSOC)) {
            $cauTrucTheLoai[$cauTruc_ketQua["maTheLoai"]]["tenTheLoai"] = $cauTruc_ketQua["tenTheLoai"];
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