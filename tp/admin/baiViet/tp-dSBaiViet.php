<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<h1 class="margin-bottom-15">Quản lý bài viết</h1>
<div class="row">
    <div class="col-md-12 margin-bottom-15">
        <a href="<?php echo layTuyChon("urlChinh")."admin/?chucnang=dSBaiViet"; ?>" <?php echo $trangThai == 4 ? "class=\"btn btn-primary\"" : ""; ?>>Tất cả (<?php echo $dem_trangThai_data[4]; ?>)</a> | <a href="<?php echo layTuyChon("urlChinh")."admin/?chucnang=dSBaiViet&trangThai=luuNhap"; ?>" <?php echo $trangThai == 0 ? "class=\"btn btn-primary\"" : ""; ?>>Lưu nháp (<?php echo $dem_trangThai_data[0]; ?>)</a> | <a href="<?php echo layTuyChon("urlChinh")."admin/?chucnang=dSBaiViet&trangThai=choDuyet"; ?>" <?php echo $trangThai == 1 ? "class=\"btn btn-primary\"" : ""; ?>>Chờ duyệt (<?php echo $dem_trangThai_data[1]; ?>)</a> | <a href="<?php echo layTuyChon("urlChinh")."admin/?chucnang=dSBaiViet&trangThai=daDuyet"; ?>" <?php echo $trangThai == 2 ? "class=\"btn btn-primary\"" : ""; ?>>Đã duyệt (<?php echo $dem_trangThai_data[2]; ?>)</a> | <a href="<?php echo layTuyChon("urlChinh")."admin/?chucnang=dSBaiViet&trangThai=tuChoi"; ?>" <?php echo $trangThai == 3 ? "class=\"btn btn-primary\"" : ""; ?>>Bị từ chối (<?php echo $dem_trangThai_data[3]; ?>)</a>
    </div>
</div>
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
if(!empty($dSBaiViet_data)) {
?>
<div class="row">
    <div class="col-md-12 margin-bottom-15">
        <div class="panel panel-primary">
            <div class="panel-heading">Danh sách bài viết</div>
                <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên bài viết</th>
                            <th>Tác giả</th>
                            <th>Ngày viết</th>
                            <th>Trạng thái</th>
                            <?php
                            if ($dangNhap->kiemTraQuyenHan() == 3) {
                                echo '<th><i class="fa fa-tasks"></i> Kiểm duyệt</th>';
                            }
                            ?>
                            <th><i class="fa fa-edit"></i> Sửa</th>
                            <th><i class="fa fa-times"></i> Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($dSBaiViet_data as $baiViet_data) { ?>
                        <tr>
                            <td><input type="checkbox" name="idDaChon[]" value="<?php echo $baiViet_data["maBaiViet"]; ?>" /></td>
                            <td><?php echo $baiViet_data["linkBaiViet"]; ?></td>
                            <td><?php echo $baiViet_data["tenTacGia"]; ?></td>
                            <td><?php echo $baiViet_data["ngayDang"]; ?></td>
                            <td><?php echo tenTrangThaiBaiViet($baiViet_data["trangThai"]); ?></td>
                            <?php echo $baiViet_data["linkKiemDuyet"]; ?>
                            <td><?php echo $baiViet_data["linkEdit"]; ?></td>
                            <td><?php echo $baiViet_data["linkDel"]; ?></i></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="xoaBaiVietModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="xoaBaiVietLabel"></h4>
                    </div>
                    <div class="modal-footer">
                        <a id="xoaBaiVietURL" href="" class="btn btn-primary">Có</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 margin-bottom-15">
        <?php echo $phanTrang_html; ?>
    </div>
</div>
<script>
$(document).on("click", ".xoaBaiVietURL", function () {
     $("#xoaBaiVietLabel").html("Bạn có muốn xóa bài viết <span style=\"color:red\">" + $(this).data("tenbaiviet") + "</span> của <span style=\"color:red\">" + $(this).data("tentacgia") + "</span> không?<br/>Thao tác này <span style=\"color:red\">không thể phục hồi</span> được!");
     $("#xoaBaiVietURL").attr("href", "<?php echo layTuyChon("urlChinh"); ?>admin/?chucnang=xoaBaiViet&maBaiViet=" + $(this).data("mabaiviet"))
});
</script>
<?php
}
?>