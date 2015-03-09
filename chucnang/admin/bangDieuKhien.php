<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
$phongVien_sql = "SELECT COUNT(*) as demBaiViet, trangThai FROM baiviet WHERE `maTacGia` = ".$_SESSION["dangNhap"]["maNhanVien"]." GROUP BY trangThai";

$phongVien = $csdl->query($phongVien_sql);

$dem_PV_data[0] = 0;
$dem_PV_data[1] = 0;
$dem_PV_data[2] = 0;
$dem_PV_data[3] = 0;
$dem_PV_data[4] = 0;

while($phongVien_ketQua = $phongVien->fetch_array(MYSQLI_ASSOC)) {
    $dem_PV_data[$phongVien_ketQua["trangThai"]] = $phongVien_ketQua["demBaiViet"];
    $dem_PV_data[4] += $phongVien_ketQua["demBaiViet"];
}

//Phần dành cho admin
if($dangNhap->kiemTraQuyenHan() >= 2) {
    $all_sql = "SELECT COUNT(*) as demBaiViet, trangThai FROM baiviet WHERE trangThai > 0 GROUP BY trangThai";
    
    $all = $csdl->query($all_sql);
    
    $dem_all_data[1] = 0;
    $dem_all_data[2] = 0;
    $dem_all_data[3] = 0;
    $dem_all_data[4] = 0;
    
    while($all_ketQua = $all->fetch_array(MYSQLI_ASSOC)) {
        $dem_all_data[$all_ketQua["trangThai"]] = $all_ketQua["demBaiViet"];
        $dem_all_data[4] += $all_ketQua["demBaiViet"];
    }
}
?>