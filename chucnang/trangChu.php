<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
$tieuDe = layTuyChon("tenWebsite")." - Trang Chủ";
//Lấy nhóm thể loại trang chủ
$top_sql = "SELECT maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha IS NULL AND tTTrangChu > 0 ORDER BY tTTrangChu ASC, tenTheLoai ASC";
$top = $csdl->query($top_sql);
if($top) {
    $i = 0;
    $nhomTheLoaiTrangChu = null;
    while($top_ketQua = $top->fetch_array(MYSQLI_ASSOC)) {
        $nhomTheLoaiTrangChu[$i]["tenTheLoai"] = $top_ketQua["tenTheLoai"];
        $nhomTheLoaiTrangChu[$i]["maTheLoai"] = $top_ketQua["maTheLoai"];
        $second_sql = "SELECT CONCAT_WS(',',GROUP_CONCAT(maTheLoai),'".$top_ketQua["maTheLoai"]."') as maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha = ".$top_ketQua["maTheLoai"];
        $second = $csdl->query($second_sql);
        if($second) {
            $second_ketQua = $second->fetch_array(MYSQLI_ASSOC);
            $nhomTheLoaiTrangChu[$i]["maNhom"] = $second_ketQua["maTheLoai"];
        }

        $baiViet_sql = "SELECT baiviet.* FROM baiviet INNER JOIN phanloai ON baiviet.maBaiViet = phanloai.maBaiViet WHERE phanloai.maTheLoai IN (".$nhomTheLoaiTrangChu[$i]["maNhom"].") AND trangThai = 2 GROUP BY maBaiViet ORDER BY ngayDang DESC LIMIT 3";
        $baiViet = $csdl->query($baiViet_sql);
        if($baiViet->num_rows >= 1) {
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