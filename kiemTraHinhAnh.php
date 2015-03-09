<?php
session_start();

if($_GET["hinhNho"]) {
    if (substr($_GET["hinhNho"], 0, strlen($_SESSION["baseURL"])) == $_SESSION["baseURL"]) {
        $_GET["hinhNho"] = substr($_GET["hinhNho"], strlen($_SESSION["baseURL"]));
    }
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