<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
if($_GET["chucnang"] == "timKiem" && isset($_GET["q"])) {
    //Khai báo thư viện html purifier
    include_once("./includes/htmlpurifier/HTMLPurifier.auto.php");
    $htmlPurifier_config = HTMLPurifier_Config::createDefault();
    $htmlPurifier_config->set('HTML.Allowed', '');
    $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
    $qDaXuLy = $htmlPurifier->purify($_GET["q"]);
    
    //Set tiêu đề
    $tieuDe = "Tìm kiếm \"".$qDaXuLy."\" - ".layTuyChon("tenWebsite");
    
    //Query database
    //Đếm kết quả
    $dem_sql = "SELECT COUNT(*) as demKetQua FROM baiviet WHERE MATCH(tenBaiViet,noiDung) AGAINST ('".$csdl->real_escape_string($qDaXuLy)."')";
    $dem = $csdl->query($dem_sql);
    if($dem) {
        $dem = $dem->fetch_array(MYSQLI_ASSOC);
        $dem = $dem["demKetQua"];
    }
    //List kết quả
    $trang = isset($_GET['trang']) ? ((int) $_GET['trang']) : 1;
    $batDau =  ($trang - 1) * 10;
    
    $dsBaiViet_sql = "SELECT * FROM baiviet WHERE MATCH(tenBaiViet,noiDung) AGAINST ('".$csdl->real_escape_string($qDaXuLy)."') LIMIT $batDau, 10";
    $dsBaiViet = $csdl->query($dsBaiViet_sql);
    if($dsBaiViet->num_rows >= 1) {
        $j = 0;
        while($dsBaiViet_ketQua = $dsBaiViet->fetch_array(MYSQLI_ASSOC)) {
            $dsBaiViet_data[$j] = $dsBaiViet_ketQua;
            $timeago = explode(" ",$dsBaiViet_data[$j]["ngayDang"]);
            $dsBaiViet_data[$j]["timeago"] = $timeago[0]."T".$timeago[1]."+07:00";
            $j++;
        }
    }
    include_once("./includes/pagination/Pagination.class.php");
    

    // instantiate; set current page; set number of records
    $phanTrang = (new Pagination());
    $phanTrang->setCurrent($trang);
    $phanTrang->setTotal($dem);

    // grab rendered/parsed pagination markup
    $phanTrang_html = $phanTrang->parse();
}