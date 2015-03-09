<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}

if(isset($_GET["maTheLoai"])) {
    $_GET["maTheLoai"] = sprintf("%d",$_GET["maTheLoai"]);
    $maTheLoai_sql =  "SELECT maTheLoai, tenTheLoai, tTMenu, tTTrangChu, IFNULL(maTheLoaiCha,0) as maTheLoaiCha FROM theloai WHERE maTheLoai = ".$_GET["maTheLoai"];
    $maTheLoai = $csdl->query($maTheLoai_sql);
    if ($maTheLoai->num_rows == 1) {
        $maTheLoai_data = $maTheLoai->fetch_array(MYSQLI_ASSOC);
        $tieuDe = $maTheLoai_data["tenTheLoai"]." - ".layTuyChon("tenWebsite");
        
        
        $maTheLoaiNhom_sql = "SELECT CONCAT_WS(',',GROUP_CONCAT(maTheLoai),'".$_GET["maTheLoai"]."') as maTheLoai, tenTheLoai FROM theloai WHERE maTheLoaiCha = ".$_GET["maTheLoai"];
        $maTheLoaiNhom = $csdl->query($maTheLoaiNhom_sql);
        if($maTheLoaiNhom) {
            $maTheLoaiNhom_ketQua = $maTheLoaiNhom->fetch_array(MYSQLI_ASSOC);
            //đếm kết quả
            $dem_sql = "SELECT COUNT(DISTINCT baiviet.`maBaiViet`) as demKetQua FROM baiviet INNER JOIN phanloai ON baiviet.maBaiViet = phanloai.maBaiViet WHERE phanloai.maTheLoai IN (".$maTheLoaiNhom_ketQua["maTheLoai"].") AND baiviet.trangThai = 2";
            $dem = $csdl->query($dem_sql);
            if($dem) {
                $dem = $dem->fetch_array(MYSQLI_ASSOC);
                $dem = $dem["demKetQua"];
            }
            $trang = isset($_GET['trang']) ? ((int) $_GET['trang']) : 1;
            $batDau =  ($trang - 1) * 10;
            //
            include_once("./includes/pagination/Pagination.class.php");

            // instantiate; set current page; set number of records
            $phanTrang = (new Pagination());
            $phanTrang->setCurrent($trang);
            $phanTrang->setTotal($dem);
        
            // grab rendered/parsed pagination markup
            $phanTrang_html = $phanTrang->parse();
            
            
            //Lấy bài viết
            $dsBaiViet_sql = "SELECT baiviet.* FROM baiviet INNER JOIN phanloai ON baiviet.maBaiViet = phanloai.maBaiViet WHERE phanloai.maTheLoai IN (".$maTheLoaiNhom_ketQua["maTheLoai"].") AND baiviet.trangThai = 2 GROUP BY baiviet.maBaiViet ORDER BY ngayDang DESC LIMIT $batDau, 10";
            $dsBaiViet = $csdl->query($dsBaiViet_sql);
            if($dsBaiViet->num_rows >= 1) {
                $j = 0;
                while($dsBaiViet_ketQua = $dsBaiViet->fetch_array(MYSQLI_ASSOC)) {
                    $dsBaiViet_data[$j] = $dsBaiViet_ketQua;
                    $timeago = explode(" ",$dsBaiViet_data[$j]["ngayDang"]);
                    $dsBaiViet_data[$j]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
                    $j++;
                }
            } else {
                include_once("404.php");
                $_GET["chucnang"] = "404";
            }
        }
    } else {
        include_once("404.php");
        $_GET["chucnang"] = "404";
    }
} else {
    include_once("404.php");
    $_GET["chucnang"] = "404";
}