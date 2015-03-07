<?php if(file_exists("../includes/csdl.class.php")) {
    echo "Website đã được cài đặt thành công. Trong trường hợp muốn cài đặt lại, vui lòng xóa file includes/csdl.class.php và thử lại";
    exit();
}

if(version_compare(PHP_VERSION, '5.3.7', '<')) {
    die("Hệ thống yêu cầu phiên bản PHP tối thiểu 5.3.7");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("../includes/password.php");
}

if(isset($_POST["dbHost"])) {
    $csdl = new mysqli($_POST["dbHost"], $_POST["dbUsername"], $_POST["dbPass"]);
    if ($csdl->connect_error) {
        die('Connect Error: ' . $mysqli->connect_error);
    }
    if($csdl->server_version < 50600) {
        die('Yêu cầu Mysql phiên bản 5.6 trở lên!');
    }
    if(!file_exists("../includes/csdl.tp.php")) {
        die('Không tìm thấy file includes/csdl.tp.php');
    }
    if(!file_exists("./caidat.sql")) {
        die('Không tìm thấy file caidat.sql');
    }
    $cauTruc_sql = file_get_contents("./caidat.sql");
    $cauTruc_sql = str_replace("#dbname",$_POST["dbName"],$cauTruc_sql);
    $cauTruc = $csdl->multi_query($cauTruc_sql);
    while ($csdl->next_result()) {;} // flush multi_queries
    if($cauTruc) {
        $csdl->select_db($_POST["dbName"]);        
        $tuyChon_sql = "INSERT INTO `tuychon` (`tenTuyChon`, `noiDung`) VALUES ('urlChinh', '".$csdl->real_escape_string($_POST["urlChinh"])."'),('tenWebsite', '".$csdl->real_escape_string($_POST["tenWebsite"])."')";
        echo $tuyChon_sql;
        $tuyChon = $csdl->query($tuyChon_sql);
        if($tuyChon) {
            $admin_sql = "INSERT INTO `nhanvien`(`maNhanVien`,`tenDangNhap`, `tenHienThi`, `matKhauHash`, `email`, `quyenHan`) VALUES (1,'".$csdl->real_escape_string($_POST["admLogin"])."','".$csdl->real_escape_string($_POST["admName"])."','".$csdl->real_escape_string(password_hash($_POST["admPass"], PASSWORD_DEFAULT))."','".$csdl->real_escape_string($_POST["admEmail"])."',3)";
            $admin = $csdl->query($admin_sql);
            if($admin) {
                $cauHinhCSDL = file_get_contents("../includes/csdl.tp.php");
                $cauHinhCSDL = str_replace("#host",$_POST["dbHost"],$cauHinhCSDL);
                $cauHinhCSDL = str_replace("#username",$_POST["dbUsername"],$cauHinhCSDL);
                $cauHinhCSDL = str_replace("#password",$_POST["dbPass"],$cauHinhCSDL);
                $cauHinhCSDL = str_replace("#database",$_POST["dbName"],$cauHinhCSDL);
                if(file_put_contents("../includes/csdl.class.php",$cauHinhCSDL)) {
                    header('Location: '.$_POST["urlChinh"]);
                    exit();
                } else {
                    $baoLoi = "Không thể tạo file cấu hình csdl, vui lòng kiểm tra và thử lại";
                }
            } else {
                $baoLoi = "Không thể tạo tài khoản admin, vui lòng kiểm tra và thử lại";
            }
        } else {
            $baoLoi = "Không thể cấu hình tùy chọn, vui lòng kiểm tra và thử lại";
        }
    } else {
        $baoLoi = "Không thể tạo cấu trúc cơ sở dữ liệu, vui lòng kiểm tra và thử lại";
    }
}

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <title>Cài đặt website</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width">        
    <link rel="stylesheet" type="text/css" href="../css/templatemo_main.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/validator.min.js"></script>
</head>
<body>
  <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1>Cài đặt website</h1></div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button> 
      </div>   
    </div>
    <div class="template-page-wrapper">
      <div class="navbar-collapse collapse templatemo-sidebar">
        <ul class="templatemo-sidebar-menu">
            <li class="active"><a href="#"><i class="fa fa-home"></i>Cài đặt website</a></li>
        </ul>
      </div><!--/.navbar-collapse -->

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          
<h1 class="margin-bottom-15">Cài đặt website</h1>
<div class="row">
    <div class="col-md-12">
    <?php if(!empty($baoLoi)) {
        echo
            '<div class="col-md-12 alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Tắt</span></button>
                '.$baoLoi.'
            </div>';
    } ?>
    <?php if(!empty($thanhCong)) {
        echo
            '<div class="col-md-12 alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Tắt</span></button>
                '.$thanhCong.'
            </div>';
    } ?>
    </div>
</div>
<div class="row">
    <form role="form" id="templatemo-preferences-form" data-toggle="validator" action="" method="POST">
        <div class="row">
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="dbHost">Database Host</label>
                <input class="form-control" id="dbHost" value="localhost" type="text" name="dbHost" data-error="Database host không thể rỗng" required />
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="dbName">Database Name</label>
                <input class="form-control" id="dbName" type="text" name="dbName" data-error="Database Name không thể rỗng" required />
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="dbUsername">Database Username</label>
                <input class="form-control" id="dbUsername" value="root" type="text" name="dbUsername" data-error="Database host không thể rỗng" required />
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="dbPass">Database Password</label>
                <input class="form-control" id="dbPass" value="" type="password" name="dbPass"/>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="admLogin">Admin Login</label>
                <input class="form-control" pattern="^([_a-z0-9]){3,64}$" id="admLogin" value="admin" type="text" name="admLogin" data-minlength="3" maxlength="64" data-error="Tối thiểu 3, tối đa 64 ký tự chữ thường, số, và &quot;_&quot;" required />
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="admName" class="control-label">Admin Name</label>
                <input class="form-control" id="admName" value="" type="text" name="admName" data-minlength="3" maxlength="64" data-error="Tối thiểu 3, tối đa 64 ký tự" required />
                <div class="help-block with-errors"></div>                  
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="admPass">Admin Password</label>
                <input class="form-control" type="password" id="admPass" name="admPass" data-minlength="8" data-error="Mật khẩu tối thiểu 8 ký tự" required />
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="admPassRe">Admin Password Repeat</label>
                <input class="form-control" type="password" id="admPassRe" name="admPassRe" data-match="#admPass" data-error="Xác nhận mật khẩu không trùng khớp" required />
                <div class="help-block with-errors"></div>  
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="email">Admin Email</label>
                <input class="form-control" id="email" value="" type="email" name="email" maxlength="255" data-error="Email không đúng định dạng hoặc dài hơn 255 ký tự" required />
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="admEmail">Website Name</label>
                <input class="form-control" id="tenWebsite" value="" type="text" name="tenWebsite" data-error="Tên website không thể rỗng" required />
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="admPass">Main URL</label>
                <input class="form-control" id="urlChinh" value="" type="text" name="urlChinh" data-error="Url Chính không thể rỗng" required/>
                <div class="help-block with-errors"></div>
            </div>
        </div>
                     
        <div class="row templatemo-form-buttons">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Cài đặt</button>
                <button type="reset" class="btn btn-default">Hủy bỏ</button>    
            </div>
        </div>
    </form>
</div>
          
        </div>
      </div>
      <footer class="templatemo-footer">
        <div class="templatemo-copyright">
          <p>Copyright &copy; 2084 Your Company Name <!-- Credit: www.templatemo.com --></p>
        </div>
      </footer>
    </div>
</body>
</html>