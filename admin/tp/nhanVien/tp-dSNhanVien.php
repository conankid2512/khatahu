<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<h1 class="margin-bottom-15">Quản lý nhân viên</h1>
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
<?php
if(!empty($dSNhanVien_data) && $dangNhap->kiemTraQuyenHan() == 3) {
?>
<div class="row">
    <div class="col-md-12 margin-bottom-15">
        <div class="panel panel-primary">
            <div class="panel-heading">Danh sách nhân viên</div>
                <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Quyền hạn</th>
                            <th><i class="fa fa-edit"></i> Sửa</th>
                            <th><i class="fa fa-lock"></i> Khóa</th>
                            <th><i class="fa fa-times"></i> Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($dSNhanVien_data as $nhanVien_data) { ?>
                        <tr>
                            <td><input type="checkbox" name="idDaChon[]" value="<?php echo $nhanVien_data["maNhanVien"]; ?>" /></td>
                            <td><?php echo $nhanVien_data["tenDangNhap"]; ?></td>
                            <td><?php echo $nhanVien_data["tenHienThi"]; ?></td>
                            <td><?php echo $nhanVien_data["email"]; ?></td>
                            <td><?php echo tenQuyenHan($nhanVien_data["quyenHan"]); ?></td>
                            <td><?php echo $nhanVien_data["linkEdit"]; ?></td>
                            <td><?php echo $nhanVien_data["linkLock"]; ?></i></td>
                            <td><?php echo $nhanVien_data["linkDel"]; ?></i></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="xoaNhanVienModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="xoaNhanVienLabel"></h4>
                    </div>
                    <div class="modal-footer">
                        <a id="xoaNhanVienURL" href="" class="btn btn-primary">Có</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".xoaNhanVienURL", function () {
     $("#xoaNhanVienLabel").html("Bạn có muốn xóa nhân viên <span style=\"color:red\">" + $(this).data("tenhienthi") + "</span> với tên đăng nhập <span style=\"color:red\">" + $(this).data("tendangnhap") + "</span> và <span style=\"color:red\">tất cả bài viết</span> của nhân viên này không?<br/>Thao tác này <span style=\"color:red\">không thể phục hồi</span> được!");
     $("#xoaNhanVienURL").attr("href", "<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=xoaNhanVien&maNhanVien=" + $(this).data("manhanvien"))
});
</script>
<?php
}
?>