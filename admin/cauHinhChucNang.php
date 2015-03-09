<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<?php
//Chức năng trang chủ admin
$cauHinhChucNang["bangDieuKhien"]["functionFile"] = "bangDieuKhien.php";
$cauHinhChucNang["bangDieuKhien"]["tpFile"] = "tp-bangDieuKhien.php";
$cauHinhChucNang["bangDieuKhien"]["activeMenu"] = "bangDieuKhien";


/************************/
/*Cụm chức năng bài viết*/
/************************/

//Chức năng thêm bài viết
$cauHinhChucNang["themBaiViet"]["functionFile"] = "baiViet.php";
$cauHinhChucNang["themBaiViet"]["tpFile"] = "baiViet/tp-themBaiViet.php";
$cauHinhChucNang["themBaiViet"]["activeMenu"] = "themBaiViet";
$cauHinhChucNang["themBaiViet"]["subOpen"] = "baiViet";

//Chức năng sửa bài viết
$cauHinhChucNang["suaBaiViet"]["functionFile"] = "baiViet.php";
$cauHinhChucNang["suaBaiViet"]["tpFile"] = "baiViet/tp-suaBaiViet.php";
$cauHinhChucNang["suaBaiViet"]["activeMenu"] = "dSBaiViet";
$cauHinhChucNang["suaBaiViet"]["subOpen"] = "baiViet";

//Chức năng xóa bài viết
$cauHinhChucNang["xoaBaiViet"]["functionFile"] = "baiViet.php";
$cauHinhChucNang["xoaBaiViet"]["tpFile"] = "baiViet/tp-dSBaiViet.php";
$cauHinhChucNang["xoaBaiViet"]["activeMenu"] = "dSBaiViet";
$cauHinhChucNang["xoaBaiViet"]["subOpen"] = "baiViet";

//Chức năng danh sách bài viết
$cauHinhChucNang["dSBaiViet"]["functionFile"] = "baiViet.php";
$cauHinhChucNang["dSBaiViet"]["tpFile"] = "baiViet/tp-dSBaiViet.php";
$cauHinhChucNang["dSBaiViet"]["activeMenu"] = "dSBaiViet";
$cauHinhChucNang["dSBaiViet"]["subOpen"] = "baiViet";

//Chức năng kiểm duyệt bài viết
$cauHinhChucNang["kiemDuyetBaiViet"]["functionFile"] = "baiViet.php";
if(isset($_GET["maBaiViet"])) {
    $cauHinhChucNang["kiemDuyetBaiViet"]["tpFile"] = "baiViet/tp-kiemDuyetBaiViet.php";
} else {
    $cauHinhChucNang["kiemDuyetBaiViet"]["tpFile"] = "baiViet/tp-dSBaiViet.php";
}
$cauHinhChucNang["kiemDuyetBaiViet"]["activeMenu"] = "kiemDuyetBaiViet";
$cauHinhChucNang["kiemDuyetBaiViet"]["subOpen"] = "baiViet";

/*************************/
/*Cụm chức năng nhân viên*/
/*************************/

//Chức năng thêm nhân viên
$cauHinhChucNang["themNhanVien"]["functionFile"] = "nhanVien.php";
$cauHinhChucNang["themNhanVien"]["tpFile"] = "nhanVien/tp-themNhanVien.php";
$cauHinhChucNang["themNhanVien"]["activeMenu"] = "themNhanVien";
$cauHinhChucNang["themNhanVien"]["subOpen"] = "nhanVien";

//Chức năng sửa nhân viên
$cauHinhChucNang["suaNhanVien"]["functionFile"] = "nhanVien.php";
$cauHinhChucNang["suaNhanVien"]["tpFile"] = "nhanVien/tp-suaNhanVien.php";
$cauHinhChucNang["suaNhanVien"]["activeMenu"] = "dSNhanVien";
$cauHinhChucNang["suaNhanVien"]["subOpen"] = "nhanVien";

//Chức năng danh sách nhân viên
$cauHinhChucNang["dSNhanVien"]["functionFile"] = "nhanVien.php";
$cauHinhChucNang["dSNhanVien"]["tpFile"] = "nhanVien/tp-dSNhanVien.php";
$cauHinhChucNang["dSNhanVien"]["activeMenu"] = "dSNhanVien";
$cauHinhChucNang["dSNhanVien"]["subOpen"] = "nhanVien";

//Chức năng xóa nhân viên
$cauHinhChucNang["xoaNhanVien"]["functionFile"] = "nhanVien.php";
$cauHinhChucNang["xoaNhanVien"]["tpFile"] = "nhanVien/tp-dSNhanVien.php";
$cauHinhChucNang["xoaNhanVien"]["activeMenu"] = "dSNhanVien";
$cauHinhChucNang["xoaNhanVien"]["subOpen"] = "nhanVien";

//Chức năng khóa nhân viên
$cauHinhChucNang["khoaNhanVien"]["functionFile"] = "nhanVien.php";
$cauHinhChucNang["khoaNhanVien"]["tpFile"] = "nhanVien/tp-dSNhanVien.php";
$cauHinhChucNang["khoaNhanVien"]["activeMenu"] = "dSNhanVien";
$cauHinhChucNang["khoaNhanVien"]["subOpen"] = "nhanVien";



/************************/
/*Cụm chức năng thể loại*/
/************************/

//Chức năng thêm thể loại
$cauHinhChucNang["themTheLoai"]["functionFile"] = "theLoai.php";
$cauHinhChucNang["themTheLoai"]["tpFile"] = "theLoai/tp-themTheLoai.php";
$cauHinhChucNang["themTheLoai"]["activeMenu"] = "themTheLoai";
$cauHinhChucNang["themTheLoai"]["subOpen"] = "theLoai";

//Chức năng sửa thể loại
$cauHinhChucNang["suaTheLoai"]["functionFile"] = "theLoai.php";
$cauHinhChucNang["suaTheLoai"]["tpFile"] = "theLoai/tp-suaTheLoai.php";
$cauHinhChucNang["suaTheLoai"]["activeMenu"] = "dSTheLoai";
$cauHinhChucNang["suaTheLoai"]["subOpen"] = "theLoai";

//Chức năng xóa thể loại
$cauHinhChucNang["xoaTheLoai"]["functionFile"] = "theLoai.php";
$cauHinhChucNang["xoaTheLoai"]["tpFile"] = "theLoai/tp-dSTheLoai.php";
$cauHinhChucNang["xoaTheLoai"]["activeMenu"] = "dSTheLoai";
$cauHinhChucNang["xoaTheLoai"]["subOpen"] = "theLoai";

//Chức năng danh sách thể loại
$cauHinhChucNang["dSTheLoai"]["functionFile"] = "theLoai.php";
$cauHinhChucNang["dSTheLoai"]["tpFile"] = "theLoai/tp-dSTheLoai.php";
$cauHinhChucNang["dSTheLoai"]["activeMenu"] = "dSTheLoai";
$cauHinhChucNang["dSTheLoai"]["subOpen"] = "theLoai";

/************************/
/*Cụm chức năng thể loại*/
/************************/

//Chức năng kiểm duyệt bình luận
$cauHinhChucNang["kiemDuyetBinhLuan"]["functionFile"] = "binhLuan.php";
$cauHinhChucNang["kiemDuyetBinhLuan"]["tpFile"] = "baiViet/tp-dSBinhLuan.php";
$cauHinhChucNang["kiemDuyetBinhLuan"]["activeMenu"] = "quanLyBinhLuan";
$cauHinhChucNang["kiemDuyetBinhLuan"]["subOpen"] = "baiViet";

//Chức năng xóa bình luận
$cauHinhChucNang["xoaBinhLuan"]["functionFile"] = "binhLuan.php";
$cauHinhChucNang["xoaBinhLuan"]["tpFile"] = "baiViet/tp-dSBinhLuan.php";
$cauHinhChucNang["xoaBinhLuan"]["activeMenu"] = "quanLyBinhLuan";
$cauHinhChucNang["xoaBinhLuan"]["subOpen"] = "baiViet";

//Chức năng danh sách bình luận
$cauHinhChucNang["dSBinhLuan"]["functionFile"] = "binhLuan.php";
$cauHinhChucNang["dSBinhLuan"]["tpFile"] = "baiViet/tp-dSBinhLuan.php";
$cauHinhChucNang["dSBinhLuan"]["activeMenu"] = "quanLyBinhLuan";
$cauHinhChucNang["dSBinhLuan"]["subOpen"] = "baiViet";


//Chức năng chỉnh sủa tài khoản
$cauHinhChucNang["taiKhoan"]["functionFile"] = "nhanVien.php";
$cauHinhChucNang["taiKhoan"]["tpFile"] = "nhanVien/tp-suaNhanVien.php";
$cauHinhChucNang["taiKhoan"]["activeMenu"] = "taiKhoan";
$cauHinhChucNang["taiKhoan"]["subOpen"] = "taiKhoan";


?>