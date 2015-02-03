<?php

//Bật chức năng debug
error_reporting(E_ALL);
ini_set('display_errors', true);

//Chống chạy trực tiếp các file con của admin
define("ADMIN",true);
include_once("./admin-init.php");

//Kiểm tra đăng nhập
if(!$dangNhap->kiemTraQuyenHan()) {
    //Hiển thị giao diện đăng nhập - báo lỗi đăng nhập
    include ("../tp/admin/tp-login.php");
} else {
    
    //Include cấu hình chức năng
    include_once("./cauHinhChucNang.php");
    
    //Cấu hình chức năng mặc định
    if(empty($_GET["chucnang"]) || !isset($cauHinhChucNang[$_GET["chucnang"]])) $_GET["chucnang"] = "bangDieuKhien";
    
    //Include Functtion chức năng
    include("../chucnang/admin/".$cauHinhChucNang[$_GET["chucnang"]]["functionFile"]);

    //Hiển thị giao diện admin
    include ("../tp/admin/tp-admin-core.php");
}
?>