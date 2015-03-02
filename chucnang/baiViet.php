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
        $maBaiViet_sql =  "SELECT bv.*, (SELECT GROUP_CONCAT(maTheLoai) FROM phanloai WHERE maBaiViet = ".$_GET["maBaiViet"].") as maTheLoai, tg.tenHienThi as tenTacGia FROM `baiviet` bv LEFT JOIN nhanvien tg ON bv.maTacGia = tg.maNhanVien WHERE maBaiViet = ".$_GET["maBaiViet"];
        $maBaiViet = $csdl->query($maBaiViet_sql);
        if ($maBaiViet->num_rows == 1) {
            $maBaiViet_data = $maBaiViet->fetch_array(MYSQLI_ASSOC);
            $timeago = explode(" ",$maBaiViet_data["ngayDang"]);
            $maBaiViet_data["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
        } else {
            $baoLoi = "Mã bài viết không tồn tại!";
        }
    } else {
        $baoLoi = "Không có mã bài viết!"; 
    }
}