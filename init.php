<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
//Tạo và đọc session
session_start();

//Tạo object csdl
if(file_exists("./includes/csdl.class.php")) {
    include_once("./includes/csdl.class.php");
} else {
    echo "<script>document.location.href = 'caidat/';</script>";
    exit();
}
//Include các hàm khác
include_once("./includes/functions.php");

//Include các hàm đăng nhập
include_once("./includes/dangnhap.class.php");

//Cấu hình base path cho web
$_SESSION["baseURL"] = parse_url(layTuyChon("urlChinh"),PHP_URL_PATH);

//Tạo sesion xem bài viết
if(!isset($_SESSION["xemBaiViet"])) $_SESSION["xemBaiViet"] = array();

//
$dangNhap = new dangNhap();

?>