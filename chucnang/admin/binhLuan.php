<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
if($dangNhap->kiemTraQuyenHan(0) == 3) {
    if($_GET["chucnang"] == "kiemDuyetBinhLuan" || $_GET["chucnang"] == "xoaBinhLuan") {
        if(!empty($_GET["maBinhLuan"])) {
            //Anti SQL-Ịnection
            $_GET["maBinhLuan"] = sprintf("%d",$_GET["maBinhLuan"]); 
            $maBinhLuan_sql =  "SELECT * FROM binhluan WHERE maBinhLuan = ".$_GET["maBinhLuan"];
            $maBinhLuan = $csdl->query($maBinhLuan_sql);
            if ($maBinhLuan->num_rows == 1) {
                $maBinhLuan_data = $maBinhLuan->fetch_array(MYSQLI_ASSOC);
            } else {
                $baoLoi = "Mã bình luận không tồn tại!";
            }
        } else {
            $baoLoi = "Không có mã bình luận!";
        }
    }
    
    
    /********************************/
    /*Chức năng kiểm duyệt bình luận*/
    /********************************/
    if($_GET["chucnang"] == "kiemDuyetBinhLuan" && !empty($maBinhLuan_data)) {
        $maBinhLuan_data["trangThai"] == 0 ? $trangThai = 1 : $trangThai = 0;
        $kiemDuyet_sql = "UPDATE binhluan SET trangThai = ".$trangThai." WHERE maBinhLuan = ".$_GET["maBinhLuan"];
        $kiemDuyet = $csdl->query($kiemDuyet_sql);
        if($kiemDuyet) {
            if($trangThai == 1) {
                $thanhCong = "Duyệt bình luận thành công";
            } else {
                $thanhCong = "Gỡ bỏ bình luận thành công";
            }
        } else {
            $baoLoi = "Lỗi truy vấn SQL, vui lòng thử lại hoặc liên hệ quản trị viên!";
        }
    }
    
    /*************************/
    /*Chức năng xóa bình luận*/
    /*************************/
    if($_GET["chucnang"] == "xoaBinhLuan" && !empty($maBinhLuan_data)) {
        $xoaBinhLuan_sql = "DELETE FROM binhluan WHERE maBinhLuan = ".$_GET["maBinhLuan"];
        $xoaBinhLuan = $csdl->query($xoaBinhLuan_sql);
        if($xoaBinhLuan) {
            $thanhCong = "Xóa bình luận thành công";
        } else {
            $baoLoi = "Lỗi truy vấn SQL, vui lòng thử lại hoặc liên hệ quản trị viên!";
        }
    }
    
    /*******************************/
    /*Chức năng danh sách bình luận*/
    /*******************************/
    if($_GET["chucnang"] == "dSBinhLuan" || $_GET["chucnang"] == "xoaBinhLuan" || $_GET["chucnang"] == "kiemDuyetBinhLuan") {
        if($dangNhap->kiemTraQuyenHan(0) < 2) {
            $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
        } else {
            $dSBinhLuan_sql = "SELECT bl.*, bv.tenBaiViet as tenBaiViet FROM `binhluan` bl LEFT JOIN baiviet bv ON bv.maBaiViet = bl.maBaiViet ORDER BY trangThai ASC, ngayDang DESC";
            $dSBinhLuan = $csdl->query($dSBinhLuan_sql);
            $i = 0;
            while($dSBinhLuan_ketQua = $dSBinhLuan->fetch_array(MYSQLI_ASSOC)) {
                $dSBinhLuan_data[$i] = $dSBinhLuan_ketQua;
                $dSBinhLuan_data[$i]["tenBaiViet"] = "<a href=\"".layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$dSBinhLuan_ketQua["maBaiViet"]."\">".mb_substr($dSBinhLuan_ketQua["tenBaiViet"],0,47)."...</a>";
                $dSBinhLuan_data[$i]["linkDel"] = "<a href=\"".layTuyChon("urlChinh")."admin/?chucnang=xoaBinhLuan&maBinhLuan=".$dSBinhLuan_ketQua["maBinhLuan"]."\"><i class=\"fa fa-times\"></i></a>";
                $dSBinhLuan_data[$i]["linkDuyet"] = "<a href=\"".layTuyChon("urlChinh")."admin/?chucnang=kiemDuyetBinhLuan&maBinhLuan=".$dSBinhLuan_ketQua["maBinhLuan"]."\"<i class=\"fa fa-tasks\"></i></a>";
                $i++;
            }
        }
    }
} else {
    $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
}
