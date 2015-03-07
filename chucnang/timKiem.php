<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
if($_GET["chucnang"] == "timKiem" && isset($_POST["q"])) {
    //Khai báo thư viện html purifier
    include_once("./includes/htmlpurifier/HTMLPurifier.auto.php");
    $htmlPurifier_config = HTMLPurifier_Config::createDefault();
    $htmlPurifier_config->set('HTML.Allowed', '');
    $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
    $qDaXuLy = $htmlPurifier->purify($_POST["q"]);
    
    //Set tiêu đề
    $tieuDe = "Tìm kiếm \"".$qDaXuLy."\" - ".layTuyChon("tenWebsite");
    
    //Query database
    //Đếm kết quả
    $dem_sql = "SELECT COUNT(*) as demKetQua FROM baiviet WHERE MATCH(tenBaiViet,noiDung) AGAINST ('".$csdl->real_escape_string($_POST["q"])."')";
    $dem = $csdl->query($dem_sql);
    if($dem) {
        $dem = $dem->fetch_array(MYSQLI_ASSOC);
        $dem = $dem["demKetQua"];
    }
    //List kết quả
    $dsBaiViet_sql = "SELECT * FROM baiviet WHERE MATCH(tenBaiViet,noiDung) AGAINST ('".$csdl->real_escape_string($_POST["q"])."')";
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
}