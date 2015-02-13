<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<h1 class="margin-bottom-15">Quản lý thể loại</h1>
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
if(!empty($dSTheLoai_data) && $dangNhap->kiemTraQuyenHan() == 3) {
?>
<div class="row">
    <div class="col-md-12 margin-bottom-15">
        <div class="panel panel-primary">
            <div class="panel-heading">Danh sách thể loại</div>
                <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên thể loại</th>
                            <th>TT Menu</th>
                            <th>TT trang chủ</th>
                            <th><i class="fa fa-edit"></i> Sửa</th>
                            <th><i class="fa fa-times"></i> Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($dSTheLoai_data as $theLoai_data) { ?>
                        <tr>
                            <td><input type="checkbox" name="idDaChon[]" value="<?php echo $theLoai_data["maTheLoai"]; ?>" /></td>
                            <td><?php echo $theLoai_data["tenTheLoai"]; ?></td>
                            <td><?php echo $theLoai_data["tTMenu"]; ?></td>
                            <td><?php echo $theLoai_data["tTTrangChu"]; ?></td>
                            <td><?php echo $theLoai_data["linkEdit"]; ?></td>
                            <td><?php echo $theLoai_data["linkDel"]; ?></i></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="xoaTheLoaiModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="xoaTheLoaiLabel"></h4>
                    </div>
                    <div class="modal-footer">
                        <a id="xoaTheLoaiURL" href="" class="btn btn-primary">Có</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".xoaTheLoaiURL", function () {
     $("#xoaTheLoaiLabel").html("Bạn có muốn xóa thể loại <span style=\"color:red\">" + $(this).data("tentheloai") + "</span> không?<br/>Thao tác này <span style=\"color:red\">không thể phục hồi</span> được!");
     $("#xoaTheLoaiURL").attr("href", "<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=xoaTheLoai&maTheLoai=" + $(this).data("matheloai"))
});
</script>
<?php
}
?>