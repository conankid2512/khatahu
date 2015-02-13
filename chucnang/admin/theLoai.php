<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<?php


$maTheLoai_data = null;
//Kiểm tra mã thể loại
if(!empty($_GET["maTheLoai"])) {
    //Anti SQL-Ịnection
    $_GET["maTheLoai"] = sprintf("%d",$_GET["maTheLoai"]); 
    $maTheLoai_sql =  "SELECT maTheLoai, tenTheLoai, tTMenu, tTTrangChu, IFNULL(maTheLoaiCha,0) as maTheLoaiCha FROM theloai WHERE maTheLoai = ".$_GET["maTheLoai"];
    $maTheLoai = $csdl->query($maTheLoai_sql);
    if ($maTheLoai->num_rows == 1) {
        $maTheLoai_data = $maTheLoai->fetch_array(MYSQLI_ASSOC);
    } else {
        $baoLoi = "Mã thể loại không tồn tại";
    }
}

//Chức năng thêm thể loại
if($_GET["chucnang"] == "themTheLoai") {
    if($dangNhap->kiemTraQuyenHan(0) != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } else {
        if(!empty($_POST["tenTheLoai"])) {
            if(empty($_POST["maTheLoaiCha"])) {
                $_POST["maTheLoaiCha"] = 0;
            }
            $_POST["maTheLoaiCha"] = sprintf("%d",$_POST["maTheLoaiCha"]);

            if(empty($_POST["tTMenu"])) {
                $_POST["tTMenu"] = 0;
            }
            $_POST["tTMenu"] = sprintf("%d",$_POST["tTMenu"]);
            
            if(empty($_POST["tTTrangChu"]) || $_POST["maTheLoaiCha"] != 0) {
                $_POST["tTTrangChu"] = 0;
            }
            $_POST["tTTrangChu"] = sprintf("%d",$_POST["tTTrangChu"]);
            
            if(!$_POST["maTheLoaiCha"]) {
                $_POST["maTheLoaiCha"] = "NULL";
            }
            
            $themTheLoai_sql = "INSERT INTO `theloai`(`tenTheLoai`, `maTheLoaiCha`, `tTMenu`, `tTTrangChu`) VALUES ('".$csdl->real_escape_string($_POST["tenTheLoai"])."',".$_POST["maTheLoaiCha"].",".$_POST["tTMenu"].",".$_POST["tTTrangChu"].")";
            $themTheLoai = $csdl->query($themTheLoai_sql);
            if($themTheLoai) {
                $thanhCong = "Thêm thể loại ".$_POST["tenTheLoai"]." thành công";
            } else {
                $baoLoi = "Không thể thêm thể loại ".$_POST["tenTheLoai"].", vui lòng thử lại hoặc liên hệ quản trị viên";
            }            
        }
        $theLoaiCha = layCautrucTheLoai();
    }
}

//Chức năng sửa thể loại
if($_GET["chucnang"] == "suaTheLoai") {
    if($dangNhap->kiemTraQuyenHan(0) != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } elseif($maTheLoai_data) {
        $theLoaiCha = layCautrucTheLoai(0);
        if(!empty($_POST["tenTheLoai"])) {
            
            if(in_array($_GET["maTheLoai"],array_keys($theLoaiCha)) && $_POST["maTheLoaiCha"] != 0) {
                $baoLoi = "Hiện tại chỉ hổ trợ thể loại tối đa 2 cấp";
            } elseif (!in_array($_POST["maTheLoaiCha"],array_keys($theLoaiCha)) && $_POST["maTheLoaiCha"] != 0) {
                $baoLoi = "Mã thể loại cha không hợp lệ";
            }elseif($_POST["maTheLoaiCha"] != $maTheLoai_data["maTheLoai"]) {
                if(empty($_POST["maTheLoaiCha"])) {
                    $_POST["maTheLoaiCha"] = 0;
                }
                $_POST["maTheLoaiCha"] = sprintf("%d",$_POST["maTheLoaiCha"]);
                
                if(empty($_POST["tTMenu"])) {
                    $_POST["tTMenu"] = 0;
                }
                $_POST["tTMenu"] = sprintf("%d",$_POST["tTMenu"]);
                
                if(empty($_POST["tTTrangChu"]) || $_POST["maTheLoaiCha"] != 0) {
                    $_POST["tTTrangChu"] = 0;
                }
                $_POST["tTTrangChu"] = sprintf("%d",$_POST["tTTrangChu"]);
                
                if(!$_POST["maTheLoaiCha"]) {
                    $_POST["maTheLoaiCha"] = "NULL";
                }
                
                $suaTheLoai_sql = "UPDATE `theloai` SET `tenTheLoai`='".$csdl->real_escape_string($_POST["tenTheLoai"])."',`maTheLoaiCha`= ".$_POST["maTheLoaiCha"].",`tTMenu`=".$_POST["tTMenu"].",`tTTrangChu`=".$_POST["tTTrangChu"]." WHERE maTheLoai = ".$_GET["maTheLoai"];
                $suaTheLoai = $csdl->query($suaTheLoai_sql);
                if($suaTheLoai) {
                    // Lấy lại thông tin thể loại sau khi sửa
                    $maTheLoai_sql =  "SELECT maTheLoai, tenTheLoai, tTMenu, tTTrangChu, IFNULL(maTheLoaiCha,0) as maTheLoaiCha FROM theloai WHERE maTheLoai = ".$_GET["maTheLoai"];
                    $maTheLoai = $csdl->query($maTheLoai_sql);
                    $maTheLoai_data = $maTheLoai->fetch_array(MYSQLI_ASSOC);
                    
                    //Thông báo sửa thành công
                    $thanhCong = "Cập nhật thể loại ".$_POST["tenTheLoai"]." thành công";
                } else {
                    $baoLoi = "Không thể cập nhật thể loại ".$_POST["tenTheLoai"].", vui lòng thử lại hoặc liên hệ quản trị viên";
                }            
            } else {
                $baoLoi = "Thể loại không thể là con của chính nó!";
            }
        }
        
        //Loại bỏ mã thể loại đang chỉnh sủa khỏi danh sách thể loại cha
        if(isset($theLoaiCha[$_GET["maTheLoai"]])) {
            unset($theLoaiCha[$_GET["maTheLoai"]]);
        }
    }
}

//Chức năng xóa thể loại
if($_GET["chucnang"] == "xoaTheLoai") {
    if($dangNhap->kiemTraQuyenHan(0) != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } elseif($maTheLoai_data) {
        $xoaTheLoai_sql = "DELETE FROM theloai WHERE maTheLoai = ".$_GET["maTheLoai"];
        $xoaTheLoai = $csdl->query($xoaTheLoai_sql);
        if($xoaTheLoai) {
            $thanhCong = "Xóa thể loại ".$maTheLoai_data["tenTheLoai"]." thành công";
        } else {
            $baoLoi = "Không thể xóa thể loại ".$maTheLoai_data["tenTheLoai"].", vui lòng thử lại hoặc liên hệ quản trị viên";
        }
    }
}

//Chức năng danh sách thể loại
if($_GET["chucnang"] == "dSTheLoai" || $_GET["chucnang"] == "xoaTheLoai") {
    if($dangNhap->kiemTraQuyenHan(0) != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } else {
        $cauTrucTheLoai = layCautrucTheLoai("all");
        if(empty($cauTrucTheLoai)) {
            $baoLoi = "Chưa có thể loại nào cả!";
        } else {
            $i = 0;
            foreach($cauTrucTheLoai as $maTheloaiCha => $theLoaiCha_data) {
                $dSTheLoai_data[$i] = $theLoaiCha_data;
                $dSTheLoai_data[$i]["tenTheLoai"] = $theLoaiCha_data["tenTheLoai"];
                $dSTheLoai_data[$i]["maTheLoai"] = $maTheloaiCha;
                $dSTheLoai_data[$i]["linkEdit"] = "<a href=\"".layTuyChon("urlChinh")."admin/?chucnang=suaTheLoai&maTheLoai=".$maTheloaiCha."\"><i class=\"fa fa-edit\"></i></a>";
                $dSTheLoai_data[$i]["linkDel"] = "<a data-matheloai=\"".$maTheloaiCha."\" data-tentheloai=\"".$theLoaiCha_data["tenTheLoai"]."\" class=\"xoaTheLoaiURL\" href=\"javascript:;\" data-toggle=\"modal\" data-target=\"#xoaTheLoaiModal\"><i class=\"fa fa-times\"></i></a>";
                $i++;
                if(isset($theLoaiCha_data["theLoaiCon"])) {
                    foreach($theLoaiCha_data["theLoaiCon"] as $maTheLoaiCon => $theLoaiCon_data) {
                        $dSTheLoai_data[$i]["tTMenu"] = "-------- ".$theLoaiCon_data["tTMenu"];
                        $dSTheLoai_data[$i]["tTTrangChu"] = "";
                        $dSTheLoai_data[$i]["tenTheLoai"] = $theLoaiCha_data["tenTheLoai"]." / ".$theLoaiCon_data["tenTheLoai"];
                        $dSTheLoai_data[$i]["maTheLoai"] = $maTheLoaiCon;
                        $dSTheLoai_data[$i]["linkEdit"] = "<a href=\"".layTuyChon("urlChinh")."admin/?chucnang=suaTheLoai&maTheLoai=".$maTheLoaiCon."\"><i class=\"fa fa-edit\"></i></a>";
                        $dSTheLoai_data[$i]["linkDel"] = "<a data-matheloai=\"".$maTheLoaiCon."\" data-tentheloai=\"".$dSTheLoai_data[$i]["tenTheLoai"]."\" class=\"xoaTheLoaiURL\" href=\"javascript:;\" data-toggle=\"modal\" data-target=\"#xoaTheLoaiModal\"><i class=\"fa fa-times\"></i></a>";
                        $i++;
                    }
                }
            }            
        }
    }
}