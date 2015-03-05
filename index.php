<?php

//Bật chức năng debug
error_reporting(E_ALL);
ini_set('display_errors', true);

//Chống chạy trực tiếp các file con của admin
define("KHATAHU",true);
include_once("./init.php");

//Include cấu hình chức năng
include_once("./cauHinhChucNang.php");

//Cấu hình chức năng mặc định
if(!isset($_GET["chucnang"])) $_GET["chucnang"] = "trangChu";

if(empty($_GET["chucnang"]) || !isset($cauHinhChucNang[$_GET["chucnang"]])) $_GET["chucnang"] = "404";

//Include Functtion chức năng
include("./chucnang/".$cauHinhChucNang[$_GET["chucnang"]]["functionFile"]);

//Hiển thị giao diện trang chủ
include ("./tp/tp-core.php");

?>