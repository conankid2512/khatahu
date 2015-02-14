<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}

//Lấy nhóm thể loại trang chủ
$top_sql = "SELECT maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha IS NULL AND tTTrangChu > 0 ORDER BY tTTrangChu ASC, tenTheLoai ASC";
$top = $csdl->query($top_sql);
if($top) {
    $i = 0;
    $nhomTheLoaiTrangChu = null;
    while($top_ketQua = $top->fetch_array(MYSQLI_ASSOC)) {
        $nhomTheLoaiTrangChu[$i]["tenTheLoai"] = $top_ketQua["tenTheLoai"];
        $second_sql = "SELECT IFNULL(GROUP_CONCAT(maTheLoai),'NULL') as maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha = ".$top_ketQua["maTheLoai"];
        $second = $csdl->query($second_sql);
        if($second) {
            $second_ketQua = $second->fetch_array(MYSQLI_ASSOC);
        } else {
            $second_ketQua["maTheLoai"] = "NULL";
        }
        
        if($second_ketQua["maTheLoai"] === "NULL") {
            $nhomTheLoaiTrangChu[$i]["maNhom"] = $top_ketQua["maTheLoai"];
        } else {
            $nhomTheLoaiTrangChu[$i]["maNhom"] = $top_ketQua["maTheLoai"].",".$second_ketQua["maTheLoai"];
        }
        
        $baiViet_sql = "SELECT baiviet.* FROM baiviet INNER JOIN phanloai ON baiviet.maBaiViet = phanloai.maBaiViet WHERE phanloai.maTheLoai IN (".$nhomTheLoaiTrangChu[$i]["maNhom"].") GROUP BY maBaiViet ORDER BY ngayDang DESC LIMIT 3";
        $baiViet = $csdl->query($baiViet_sql);
        if($baiViet->num_rows > 1) {
            $j = 0;
            while($baiViet_ketQua = $baiViet->fetch_array(MYSQLI_ASSOC)) {
                $nhomTheLoaiTrangChu[$i]["baiViet"][$j] = $baiViet_ketQua;
                $timeago = explode(" ",$nhomTheLoaiTrangChu[$i]["baiViet"][$j]["ngayDang"]);
                $nhomTheLoaiTrangChu[$i]["baiViet"][$j]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
                $j++;
            }
        } else {
            //Không hiển thị thể loại chưa có bài viết lên trang chủ
            unset($nhomTheLoaiTrangChu[$i]);
        }
        $i++;
    }
}