<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <title>Quản trị website</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width">        
    <link rel="stylesheet" type="text/css" href="<?php echo layTuyChon("urlChinh"); ?>css/templatemo_main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo layTuyChon("urlChinh"); ?>js/fancybox/jquery.fancybox.css" media="screen" />
    <script src="<?php echo layTuyChon("urlChinh"); ?>js/jquery.min.js"></script>
    <script src="<?php echo layTuyChon("urlChinh"); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo layTuyChon("urlChinh"); ?>js/validator.min.js"></script>
    <script src="<?php echo layTuyChon("urlChinh"); ?>js/templatemo_script.js"></script>
</head>
<body>
  <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1>Quản trị website</h1></div>
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
          <li>
            <form class="navbar-form">
              <input type="text" class="form-control" id="templatemo_search_box" placeholder="Search...">
              <span class="btn btn-default">Go</span>
            </form>
          </li>
          <li<?php activeMenu('bangDieuKhien')?>><a href="#"><i class="fa fa-home"></i>Bảng điều khiển</a></li>
          
          <li class="sub<?php subOpen('baiViet')?>">
            <a href="javascript:;">
              <i class="fa fa-pencil"></i>Bài viết<div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li<?php activeMenu('dSBaiViet')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=dSBaiViet"><i class="fa fa-database"></i>Tất cả bài viết</a></li>
              <li<?php activeMenu('themBaiViet')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=themBaiViet"><i class="fa fa-plus"></i>Thêm bài viết</a></li>
              <li<?php activeMenu('suaXoaBaiViet')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=dSBaiViet"><i class="fa fa-edit"></i>Sửa/Xóa bài viết</a></li>
  <?php
if($dangNhap->kiemTraQuyenHan() >= 2) { //Phần chỉ dành cho quản trị viên - biên tập viên
?>              
              <li<?php activeMenu('kiemDuyetBaiViet')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=kiemDuyetBaiViet"><i class="fa fa-tasks"></i>Kiểm duyệt bài viết</a></li>
<?php
}
?>
            </ul>
          </li>

 <?php
if($dangNhap->kiemTraQuyenHan() == 3) { //Phần chỉ dành cho quản trị viên
?>         
          <li class="sub<?php subOpen('theLoai')?>">
            <a href="javascript:;">
              <i class="fa fa-folder-open"></i>Thể loại<div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li<?php activeMenu('dSTheLoai')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=dSTheLoai"><i class="fa fa-database"></i>Danh sách thể loại</a></li>
              <li<?php activeMenu('themTheLoai')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=themTheLoai"><i class="fa fa-plus"></i>Thêm thể loại</a></li>
              <li<?php activeMenu('suaXoaTheLoai')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=dSTheLoai"><i class="fa fa-edit"></i>Sửa/Xóa thể loại</a></li>
            </ul>
          </li>
          
          <li class="sub<?php subOpen('nhanVien')?>">
            <a href="javascript:;">
              <i class="fa fa-users"></i>Quản lý nhân viên<div class="pull-right"><span class="caret"></span></div>
            </a>
            <ul class="templatemo-submenu">
              <li<?php activeMenu('dSNhanVien')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=dSNhanVien"><i class="fa fa-database"></i>Tất cả nhân viên</a></li>
              <li<?php activeMenu('themNhanVien')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=themNhanVien"><i class="fa fa-user"></i>Thêm nhân viên</a></li>
              <li<?php activeMenu('suaXoaNhanVien')?>><a href="<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=dSNhanVien"><i class="fa fa-edit"></i>Sửa/Xóa nhân viên</a></li>
            </ul>
          </li>
<?php
}
?>          
          <li><a href="preferences.html"><i class="fa fa-cog"></i>Tùy chỉnh</a></li>
          <li><a href="javascript:;" data-toggle="modal" data-target="#confirmModal"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
        </ul>
      </div><!--/.navbar-collapse -->

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">
          <?php include("./tp/".$cauHinhChucNang[$_GET["chucnang"]]["tpFile"]); ?>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Bạn muốn đăng xuất?</h4>
            </div>
            <div class="modal-footer">
              <a href="<?php echo layTuyChon("urlChinh"); ?>admin/?dangXuat=1" class="btn btn-primary">Có</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
            </div>
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