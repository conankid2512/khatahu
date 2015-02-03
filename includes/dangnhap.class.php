<?php
/**
* Class dangNhap chuyên quản lý quá trình đăng nhập, đăng xuất và quyền hạn của user
*/
class dangNhap {
    //Khai báo biến
    private $kncsdl = null;
    public $baoLoi = null;
    
    
    public function __construct() {
        global $csdl;
        //Ðua biến csdl vào class dangNhap
        $this->kncsdl = $csdl;
    }
    
    public function dangNhap($kiemTraLai = false) {
        if ($kiemTraLai) {
            $tenDangNhap = $_SESSION["dangNhap"]["tenDangNhap"];
            $matKhau = $_SESSION["dangNhap"]["matKhau"];
        } elseif(empty($_POST["tenDangNhap"])) {
            $this->baoLoi = "Tên đăng nhập rỗng";
            return false;
        } elseif (empty($_POST["matKhau"])) {
            $this->baoLoi = "Mật khẩu rỗng";
            return false;
        } else {
            $tenDangNhap = $_POST["tenDangNhap"];
            $matKhau = $_POST["matKhau"];
            //Anti session fixation
            session_regenerate_id(TRUE);
        }
        
        //Escape tên đăng nhập, hạn chế SQL injection
        $tenDangNhap = $this->kncsdl->real_escape_string($tenDangNhap);
        
        //Lấy thông tin người dùng
        $truyVanDangNhap_sql = "SELECT maNhanVien, tenDangNhap, tenHienThi, email, matKhauHash, quyenHan FROM nhanVien WHERE tenDangNhap = '".$tenDangNhap."' OR email = '".$tenDangNhap."';";
        $truyVanDangNhap = $this->kncsdl->query($truyVanDangNhap_sql);
        
        //Kiểm tra mật khẩu và quyền hạn
        if ($truyVanDangNhap->num_rows == 1) {
            $truyVanDangNhap_ketQua = $truyVanDangNhap->fetch_array(MYSQLI_ASSOC);
            if (password_verify($matKhau, $truyVanDangNhap_ketQua["matKhauHash"])) {
                if ($truyVanDangNhap_ketQua["quyenHan"] < 1) {
                    $_SESSION["dangNhap"] = array();
                    //Mật khẩu đúng nhưng tài khoản bị khóa
                    $this->baoLoi = "Tài khoản bị khóa, vui lòng liên hệ với quản trị viên!";
                } else {
                    //Mật khẩu và quyền hạn OK, lưu thông tin đăng nhập vào session
                    $_SESSION["dangNhap"]["maNhanVien"] = $truyVanDangNhap_ketQua["maNhanVien"];
                    $_SESSION["dangNhap"]["tenDangNhap"] = $truyVanDangNhap_ketQua["tenDangNhap"];
                    $_SESSION["dangNhap"]["tenHienThi"] = $truyVanDangNhap_ketQua["tenHienThi"];
                    $_SESSION["dangNhap"]["matKhau"] = $matKhau;
                    $_SESSION["dangNhap"]["email"] = $truyVanDangNhap_ketQua["email"];
                    $_SESSION["dangNhap"]["quyenHan"] = $truyVanDangNhap_ketQua["quyenHan"];
                    $_SESSION["dangNhap"]["tGKiemTra"] = time(true);
                    if($truyVanDangNhap_ketQua["quyenHan"] == 1) {
                        $_SESSION["dangNhap"]["tenQuyenHan"] = "phóng viên";
                    } elseif($truyVanDangNhap_ketQua["quyenHan"] == 2) {
                        $_SESSION["dangNhap"]["tenQuyenHan"] = "biên tập viên";
                    } elseif($truyVanDangNhap_ketQua["quyenHan"] == 3) {
                        $_SESSION["dangNhap"]["tenQuyenHan"] = "quản trị viên";
                    }
                    
                    //Lưu thông tin bổ sung cho filemanager
                    $_SESSION["RF"]["baseURL"] = $_SESSION["baseURL"];
                    $_SESSION["RF"]["subfolder"] = $_SESSION["dangNhap"]["maNhanVien"] != 1 ? "nhanvien".$_SESSION["dangNhap"]["maNhanVien"] : "";
                }
            } else {
                $_SESSION["dangNhap"] = array();
                $this->baoLoi = "Mật khẩu không đúng, vui lòng thử lại";
            }
        } else {
            $_SESSION["dangNhap"] = array();
            $this->baoLoi = "Tên đăng nhập không tồn tại";
        }
        
    }
    
    public function dangXuat() {
        //Hủy thông tin đăng nhập
        $_SESSION["dangNhap"] = array();
        //Thông báo cho người dùng
        $this->baoLoi = "Bạn đã đăng xuất thành công!";
    }
    
    public function kiemTraQuyenHan($tGHieuLuc = 300) {
        if (isset($_SESSION["dangNhap"]["quyenHan"])) {
            if ($_SESSION["dangNhap"]["tGKiemTra"] > time(true) - $tGHieuLuc) {
                return $_SESSION["dangNhap"]["quyenHan"];
            } else {
                $this->dangNhap(true);
                if (isset($_SESSION["dangNhap"]["quyenHan"])) {
                    return $_SESSION["dangNhap"]["quyenHan"];
                } else {
                    echo "<script type=\"text/javascript\">window.location = \"http://www.google.com/\"</script>";
                    return false;
                }
            }
        }
        return false;
    }
    
}