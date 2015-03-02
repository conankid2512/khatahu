<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<h1 class="margin-bottom-15">Quản lý bài viết</h1>
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
                            <th>Ngày đăng</th>
                            <th>Trạng thái</th>
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
                            <td><?php echo tenTrangThai($baiViet_data["trangThai"]); ?></td>
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