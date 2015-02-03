<?php
session_start();

if($_GET["hinhNho"]) {
	$_GET["hinhNho"] = str_replace($_SESSION["baseURL"],"/",$_GET["hinhNho"]);
    if(file_exists(".".$_GET["hinhNho"])) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $kieuFile = finfo_file($finfo, ".".$_GET["hinhNho"]);
        $kieuHinh = array("image/gif","image/jpeg","image/png","image/bmp");
        if(in_array($kieuFile,$kieuHinh)) {
            http_response_code(200);
            exit;
        }
    }
}
http_response_code(404);