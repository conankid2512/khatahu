<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
//Tạo và đọc session
session_start();

//Tạo object csdl
include_once("./includes/csdl.class.php");

//Include các hàm khác
include_once("./includes/functions.php");

//Include các hàm đăng nhập
include_once("./includes/dangnhap.class.php");

//Cấu hình base path cho web
$_SESSION["baseURL"] = parse_url(layTuyChon("urlChinh"),PHP_URL_PATH);

//
$dangNhap = new dangNhap();

?>