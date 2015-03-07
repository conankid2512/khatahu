<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
//Tạo và đọc session
session_start();

//Kiểm tra phiên bản PHP và chèn thư viện tương thích nếu cần
if(version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Hệ thống yêu cầu phiên bản PHP tối thiểu 5.3.7");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("../includes/password.php");
}

//Tạo object csdl
include_once("../includes/csdl.class.php");

//Include các hàm khác
include_once("../includes/functions.php");

//Include các hàm đăng nhập
include_once("../includes/dangnhap.class.php");

//Cấu hình base path cho web
$_SESSION["baseURL"] = parse_url(layTuyChon("urlChinh"),PHP_URL_PATH);

//Tạo object đăng nhập
$dangNhap = new dangNhap();

//Thực hiện chức năng đăng xuất nếu cần
if(isset($_GET["dangXuat"])) {
    $dangNhap->dangXuat();
}

//Thực hiện chức năng đăng nhập nếu cần
if(isset($_POST["tenDangNhap"]) && isset($_POST["matKhau"])) {
    if (!$dangNhap->kiemTraQuyenHan()) {
        $dangNhap->dangNhap();
    }
}
?>