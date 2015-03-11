<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}

$maNhanVien_data = null;
$dSNhanVien_data = null;

/************************************************/
/*Kiểm tra xem mã nhân viên có tồn tại hay không*/
/************************************************/
if($_GET["chucnang"] == "taiKhoan") {
    $_GET["maNhanVien"] = $_SESSION["dangNhap"]["maNhanVien"];
}
if($_GET["chucnang"] == "taiKhoan" || $_GET["chucnang"] == "suaNhanVien" || $_GET["chucnang"] == "xoaNhanVien" || $_GET["chucnang"] == "khoaNhanVien") {
    if(!empty($_GET["maNhanVien"])) {
        //Anti SQL-Ịnection
        $_GET["maNhanVien"] = sprintf("%d",$_GET["maNhanVien"]); 
        $maNhanVien_sql =  "SELECT * FROM nhanvien WHERE maNhanVien = ".$_GET["maNhanVien"];
        $maNhanVien = $csdl->query($maNhanVien_sql);
        if ($maNhanVien->num_rows == 1) {
            $maNhanVien_data = $maNhanVien->fetch_array(MYSQLI_ASSOC);
        } else {
            $baoLoi = "Mã nhân viên không tồn tại!";
        }
    } else {
        $baoLoi = "Không có mã nhân viên!";
    }
}

/**************************/
/*Chức năng thêm nhân viên*/
/**************************/

if($_GET["chucnang"] == "themNhanVien" && $dangNhap->kiemTraQuyenHan() != 3) {
    $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
} elseif($_GET["chucnang"] == "themNhanVien" && isset($_POST["tenDangNhap"])) {
    //Kiểm tra dữ liệu đầu vào
    if(empty($_POST["tenDangNhap"])) {
        $baoLoi = "Tên đăng nhập rỗng";
    } elseif(empty($_POST["matKhau"]) || empty($_POST["nhapLaiMatKhau"])) {
        $baoLoi = "Mật khẩu rỗng";
    } elseif($_POST["matKhau"] != $_POST["nhapLaiMatKhau"]) {
        $baoLoi = "Xác nhân mật khẩu không trùng khớp, vui lòng kiểm tra lại!";
    } elseif(strlen($_POST["matKhau"]) < 8) {
        $baoLoi = "Mật khẩu tối thiểu 8 ký tự";
    } elseif(strlen($_POST["tenDangNhap"]) > 64 || strlen($_POST["tenDangNhap"]) < 3 || !preg_match('/^[_a-z0-9]{3,64}$/i', $_POST["tenDangNhap"])) {
        $baoLoi = "Tên đăng nhập tối thiểu 3, tối đa 64 ký tự chữ thường, số, và &quot;_&quot;";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"]) > 255) {
        $baoLoi = "Email không đúng định dạng hoặc dài hơn 255 ký tự";
    } elseif(empty($_POST["tenHienThi"])) {
        $baoLoi = "Tên hiển thị rỗng";
    } elseif(strlen($_POST["tenHienThi"]) > 255) {
        $baoLoi = "Tên hiển thị quá dài"; //Tên hiển thị sử dụng Unicode, độ dài tối đa 255byte
    } elseif(empty($_POST["quyenHan"]) || $_POST["quyenHan"] > 3 || $_POST["quyenHan"] < 1) {
        $baoLoi = "Mã quyền hạn không hợp lệ";
    } elseif($dangNhap->kiemTraQuyenHan(0) == 3) {
        
        //Khai báo thư viện html purifier
        include_once("../includes/htmlpurifier/HTMLPurifier.auto.php");
        $htmlPurifier_config = HTMLPurifier_Config::createDefault();
        $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
        
        $themNhanVien_sql = "INSERT INTO `nhanvien`(`tenDangNhap`, `tenHienThi`, `matKhauHash`, `email`, `quyenHan`, `moTaNgan`) VALUES ('%s','%s','%s','%s',%d,'%s')";
        $themNhanVien_sql = sprintf($themNhanVien_sql,
                                    $csdl->real_escape_string($_POST["tenDangNhap"]),
                                    $csdl->real_escape_string($_POST["tenHienThi"]),
                                    $csdl->real_escape_string(password_hash($_POST["matKhau"], PASSWORD_DEFAULT)),
                                    $csdl->real_escape_string($_POST["email"]),
                                    $_POST["quyenHan"],
                                    $csdl->real_escape_string($htmlPurifier->purify($_POST["moTaNgan"])));
        $themNhanVien = $csdl->query($themNhanVien_sql);
        if($themNhanVien) {
            $thanhCong = "Thêm nhân viên ".$_POST["tenDangNhap"]." thành công!";
        } else {
            $baoLoi = "Tên đăng nhập đã tồn tại, không thể thêm nhân viên vào cơ sở dữ liệu!";
        }
    } else {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    }
}


/*************************/
/*Chức năng sửa nhân viên*/
/*************************/

//Kiểm tra quyền sửa nhân viên
if($_GET["chucnang"] == "suaNhanVien" && $dangNhap->kiemTraQuyenHan() != 3) {
    $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
} elseif($_GET["chucnang"] == "suaNhanVien" && !empty($_POST["tenDangNhap"]) && !empty($_GET["maNhanVien"]) && $maNhanVien_data) { //Cập nhật thông tin nhân viên vào csdl
    //Kiểm tra dữ liệu đầu vào
    if(empty($_POST["tenDangNhap"])) {
        $baoLoi = "Tên đăng nhập rỗng";
    } elseif($_POST["matKhau"] != $_POST["nhapLaiMatKhau"]) {
        $baoLoi = "Xác nhân mật khẩu không trùng khớp, vui lòng kiểm tra lại!";
    } elseif(!empty($_POST["matKhau"]) && strlen($_POST["matKhau"]) < 8) {
        $baoLoi = "Mật khẩu tối thiểu 8 ký tự";
    } elseif(strlen($_POST["tenDangNhap"]) > 64 || strlen($_POST["tenDangNhap"]) < 3 || !preg_match('/^[_a-z0-9]{3,64}$/i', $_POST["tenDangNhap"])) {
        $baoLoi = "Tên đăng nhập tối thiểu 3, tối đa 64 ký tự chữ thường, số, và &quot;_&quot;";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"]) > 255) {
        $baoLoi = "Email không đúng định dạng hoặc dài hơn 255 ký tự";
    } elseif(empty($_POST["tenHienThi"])) {
        $baoLoi = "Tên hiển thị rỗng";
    } elseif(strlen($_POST["tenHienThi"]) > 255) {
        $baoLoi = "Tên hiển thị quá dài"; //Tên hiển thị sử dụng Unicode, độ dài tối đa 255byte
    } elseif(empty($_POST["quyenHan"]) || $_POST["quyenHan"] > 3 || $_POST["quyenHan"] < 1) {
        $baoLoi = "Mã quyền hạn không hợp lệ";
    } elseif($_POST["quyenHan"] != 3 && $_GET["maNhanVien"] == 1) {
        $baoLoi = "Không thể thay đổi quyền của quản trị viên gốc!";
    } elseif($dangNhap->kiemTraQuyenHan(0) == 3) {
        if(!empty($_POST["matKhau"])) {
            $matKhau_sql = "`matKhauHash`='".$csdl->real_escape_string(password_hash($_POST["matKhau"], PASSWORD_DEFAULT))."',";
        } else {
            $matKhau_sql = "";
        }
        
        //Khai báo thư viện html purifier
        include_once("../includes/htmlpurifier/HTMLPurifier.auto.php");
        $htmlPurifier_config = HTMLPurifier_Config::createDefault();
        $htmlPurifier = new HTMLPurifier($htmlPurifier_config);
        
        $suaNhanVien_sql = "UPDATE `nhanvien` SET `tenDangNhap`='%s',`tenHienThi`='%s',%s`email`='%s',`quyenHan`='%s',`moTaNgan`='%s' WHERE maNhanVien = ".$_GET["maNhanVien"];
        $suaNhanVien_sql = sprintf($suaNhanVien_sql,
                                    $csdl->real_escape_string($_POST["tenDangNhap"]),
                                    $csdl->real_escape_string($_POST["tenHienThi"]),
                                    $matKhau_sql,
                                    $csdl->real_escape_string($_POST["email"]),
                                    $_POST["quyenHan"],
                                    $csdl->real_escape_string($htmlPurifier->purify($_POST["moTaNgan"])));
        $suaNhanVien = $csdl->query($suaNhanVien_sql);
        
        if($suaNhanVien) {
            
            //Lây lại thông tin nhân viên mới cập nhật
            $maNhanVien_sql =  "SELECT * FROM nhanvien WHERE maNhanVien = ".$_GET["maNhanVien"];
            $maNhanVien = $csdl->query($maNhanVien_sql);
            $maNhanVien_data = $maNhanVien->fetch_array(MYSQLI_ASSOC);

            //Thông báo thành công
            $thanhCong = "Cập nhật thông tin nhân viên ".$_POST["tenDangNhap"]." thành công!";
        } else {
            $baoLoi = "Cập nhật thông tin nhân viên ".$_POST["tenDangNhap"]." thất bại, vui lòng thử lại hoặc liên hệ quản trị viên!";
        }
    } else {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    }
}

/*************************/
/*Chức năng xóa nhân viên*/
/*************************/

if($_GET["chucnang"] == "xoaNhanVien" && !empty($_GET["maNhanVien"]) && $maNhanVien_data) {
    if($dangNhap->kiemTraQuyenHan(0) != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } elseif($_GET["maNhanVien"] == 1) {
        $baoLoi = "Không thể xóa tài khoản quản trị gốc!";
    } elseif($_GET["maNhanVien"] == $_SESSION["dangNhap"]["maNhanVien"]) {
        $baoLoi = "Bạn không thể xóa tài khoản của chính mình!";
    } else {
        $xoaNhanVien_sql = "DELETE from nhanvien WHERE maNhanVien = ".$_GET["maNhanVien"];
        $xoaNhanVien = $csdl->query($xoaNhanVien_sql);
        if($xoaNhanVien) {
            $thanhCong = "Xóa nhân viên ".$maNhanVien_data["tenDangNhap"]." và các bài viết thành công";
        } else {
            $baoLoi = "Không thể xóa nhân viên ".$maNhanVien_data["tenDangNhap"]." vui lòng thử lại hoặc liên hệ quản trị viên";
        }        
    }
}


/*************************/
/*Chức năng sửa tài khoản*/
/*************************/

//Kiểm tra quyền sửa tài khoản
if($_GET["chucnang"] == "taiKhoan" && isset($_POST["tenDangNhap"])) {
    //Kiểm tra dữ liệu đầu vào
    if($_POST["matKhau"] != $_POST["nhapLaiMatKhau"]) {
        $baoLoi = "Xác nhân mật khẩu không trùng khớp, vui lòng kiểm tra lại!";
    } elseif(!empty($_POST["matKhau"]) && strlen($_POST["matKhau"]) < 8) {
        $baoLoi = "Mật khẩu tối thiểu 8 ký tự";
    } elseif(empty($_POST["tenHienThi"])) {
        $baoLoi = "Tên hiển thị rỗng";
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) || strlen($_POST["email"]) > 255) {
        $baoLoi = "Email không đúng định dạng hoặc dài hơn 255 ký tự";
    } elseif(strlen($_POST["tenHienThi"]) > 255) {
        $baoLoi = "Tên hiển thị quá dài"; //Tên hiển thị sử dụng Unicode, độ dài tối đa 255byte
    } else {
        if(!empty($_POST["matKhau"])) {
            $matKhau_sql = "`matKhauHash`='".$csdl->real_escape_string(password_hash($_POST["matKhau"], PASSWORD_DEFAULT))."',";
        } else {
            $matKhau_sql = "";
        }
        $suaNhanVien_sql = "UPDATE `nhanvien` SET `tenHienThi`='%s',%s`moTaNgan`='%s' WHERE maNhanVien = ".$_GET["maNhanVien"];
        $suaNhanVien_sql = sprintf($suaNhanVien_sql,
                                    $csdl->real_escape_string($_POST["tenHienThi"]),
                                    $matKhau_sql,
                                    $csdl->real_escape_string($_POST["moTaNgan"]));
        $suaNhanVien = $csdl->query($suaNhanVien_sql);
        
        if($suaNhanVien) {
            
            //Lây lại thông tin nhân viên mới cập nhật
            $maNhanVien_sql =  "SELECT * FROM nhanvien WHERE maNhanVien = ".$_GET["maNhanVien"];
            $maNhanVien = $csdl->query($maNhanVien_sql);
            $maNhanVien_data = $maNhanVien->fetch_array(MYSQLI_ASSOC);

            //Thông báo thành công
            $thanhCong = "Cập nhật thông tin nhân viên ".$_POST["tenDangNhap"]." thành công!";
        } else {
            $baoLoi = "Cập nhật thông tin nhân viên ".$_POST["tenDangNhap"]." thất bại, vui lòng thử lại hoặc liên hệ quản trị viên!";
        }
    }
}

/************************************/
/*Chức năng Khóa / Mở khóa nhân viên*/
/************************************/

if($_GET["chucnang"] == "khoaNhanVien" && !empty($_GET["maNhanVien"]) && $maNhanVien_data) {
    if($maNhanVien_data["quyenHan"] < 0) {
        $khoa = "Mở khóa";
    } else {
        $khoa = "Khóa";
    }
    if($dangNhap->kiemTraQuyenHan(0) != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } elseif($_GET["maNhanVien"] == 1) {
        $baoLoi = "Không thể khóa tài khoản quản trị gốc!";
    } elseif($_GET["maNhanVien"] == $_SESSION["dangNhap"]["maNhanVien"]) {
        $baoLoi = "Bạn không thể khóa tài khoản của chính mình!";
    } else {
        $xoaNhanVien_sql = "UPDATE nhanvien SET quyenHan = -1 * quyenHan WHERE maNhanVien = ".$_GET["maNhanVien"];
        $xoaNhanVien = $csdl->query($xoaNhanVien_sql);
        if($xoaNhanVien) {
            $thanhCong = $khoa." nhân viên ".$maNhanVien_data["tenDangNhap"]." thành công!";
        } else {
            $baoLoi = $khoa." nhân viên ".$maNhanVien_data["tenDangNhap"]." thất bại, vui lòng thử lại hoặc liên hệ quản trị viên!";
        }        
    }
}

/*******************************/
/*Chức năng danh sách nhân viên*/
/*******************************/

if($_GET["chucnang"] == "dSNhanVien" || $_GET["chucnang"] == "xoaNhanVien" || $_GET["chucnang"] == "khoaNhanVien") {
    if($dangNhap->kiemTraQuyenHan() != 3) {
        $baoLoi = "Bạn không có đủ quyền thực hiện tác vụ này!";
    } else {
        $dSNhanVien_sql = "SELECT maNhanVien, tenDangNhap, tenHienThi, email, quyenHan FROM nhanvien";
        $dSNhanVien = $csdl->query($dSNhanVien_sql);
        $i = 0;
        while($dSNhanVien_ketQua = $dSNhanVien->fetch_array(MYSQLI_ASSOC)) {
            $dSNhanVien_data[$i] = $dSNhanVien_ketQua;
            $dSNhanVien_data[$i]["linkEdit"] = "<a href=\"".layTuyChon("urlChinh")."admin/?chucnang=suaNhanVien&maNhanVien=".$dSNhanVien_ketQua["maNhanVien"]."\"><i class=\"fa fa-edit\"></i></a>";
            if($dSNhanVien_ketQua["quyenHan"] < 0) {
                $un = "un";
                $unalt = "Mở khóa";
            } else {
                $un = "";
                $unalt = "Khóa";
            }
            $dSNhanVien_data[$i]["linkLock"] = "<a title=\"".$unalt."\" href=\"".layTuyChon("urlChinh")."admin/?chucnang=khoaNhanVien&maNhanVien=".$dSNhanVien_ketQua["maNhanVien"]."\"><i class=\"fa fa-".$un."lock\"></i></a>";
            $dSNhanVien_data[$i]["linkDel"] = "<a data-manhanvien=\"".$dSNhanVien_ketQua["maNhanVien"]."\" data-tendangnhap=\"".$dSNhanVien_ketQua["tenDangNhap"]."\" data-tenhienthi=\"".$dSNhanVien_ketQua["tenHienThi"]."\" class=\"xoaNhanVienURL\" href=\"javascript:;\" data-toggle=\"modal\" data-target=\"#xoaNhanVienModal\"><i class=\"fa fa-times\"></i></a>";
            $i++;
        }
    }        
}