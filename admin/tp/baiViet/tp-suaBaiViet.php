<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<h1>Thêm bài viết</h1>
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
if($quyenSua && $maBaiViet_data) {
    $theLoai_array = explode(",",$maBaiViet_data["maTheLoai"]);
?>
<div class="row">
    <div class="col-md-12">
        <form role="form" id="templatemo-preferences-form" data-toggle="validator" action="" method="POST">
            <div class="row">
                <div class="col-md-12 margin-bottom-15 form-group">
                    <label for="tenBaiViet">Tên bài viết</label>
                    <input class="form-control" id="tenBaiViet" value="<?php echo $maBaiViet_data["tenBaiViet"]; ?>" type="text" name="tenBaiViet" data-error="Vui lòng nhập tựa bài viết" required />
                    <div class="help-block with-errors"></div>   
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8 margin-bottom-15 form-group">
                    <label for="noiDung">Nội dung</label>
                    <textarea class="form-control" rows="3" id="noiDung" name="noiDung" style="width: 100%;height: 500px"><?php echo $maBaiViet_data["noiDung"]; ?></textarea>
                </div>
                <div class="col-md-4">
                    <div class="row margin-bottom-30 form-group">
                        <label for="trangThai">Trạng thái bài viết</label>
                        <select class="form-control" id="trangThai" name="trangThai">
                            <option value="0" <?php echo $maBaiViet_data["trangThai"] == 0 ? "selected" : null; ?>>Lưu nháp</option>
                            <?php if($dangNhap->kiemTraQuyenHan() <= 1) echo "<option value=\"1\" ".($maBaiViet_data["trangThai"] == 1 ? "selected" : null).">Chờ duyệt</option>"; ?>
                            <?php if($dangNhap->kiemTraQuyenHan() > 1) echo "<option value=\"2\" ".($maBaiViet_data["trangThai"] == 2 ? "selected" : null).">Đã duyệt</option>"; ?>
                        </select>
                        <div class="help-block with-errors"></div>                       
                    </div>
                    <div class="row margin-bottom-30 form-group">
                        <label for="trangThai">Hình đại diện cho bài viết</label>
                        <div class="input-group">
                    	    <input data-remote="<?php echo layTuyChon("urlChinh"); ?>kiemTraHinhAnh.php" value="<?php echo $maBaiViet_data["hinhNho"]; ?>" class="form-control" id="hinhNho" name="hinhNho" data-error="Hình đại diện không hợp lệ! Vui lòng chọn hình đại diện từ thư viện hình." value="" type="text" required />
                            <span class="input-group-btn">
                    	       <a href="<?php echo layTuyChon("urlChinh"); ?>filemanager/dialog.php?type=1&amp;field_id=hinhNho" class="btn btn-info iframe-btn" type="button">Chọn hình</a>
                            </span>
                    	</div>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="row margin-bottom-30 form-group">
                        <label for="dStheLoai">Thể loại</label>
                        <?php if(!empty($dSTheLoai_data)) { ?>
                        <div style="max-height: 375px; overflow-y: auto;">
                        <table class="table table-striped" id="dStheLoai">
                            <tbody>
                            <?php foreach($dSTheLoai_data as $theLoai_data) { ?>
                                <tr>
                                    <td><input type="checkbox" name="theLoai[]" value="<?php echo $theLoai_data["maTheLoai"]; ?>" <?php echo in_array($theLoai_data["maTheLoai"],$theLoai_array) ? "checked" : null ?>/></td>
                                    <td><?php echo $theLoai_data["tenTheLoai"]; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
                       
            <div class="row templatemo-form-buttons">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                    <button type="reset" class="btn btn-default">Hủy bỏ</button>    
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo layTuyChon("urlChinh"); ?>js/fancybox/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo layTuyChon("urlChinh"); ?>js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
$('.iframe-btn').fancybox({	
	'type':'iframe',
    'autoSize':false,
    'height': 600,
    'width':900
});
tinymce.init({
    theme: "modern",
    skin: "light",
    language : "vi",
    selector: "#noiDung",
    plugins: "advlist, charmap, contextmenu, image, media, visualblocks, link, paste, textcolor, emoticons, hr, table, responsivefilemanager",
    toolbar: "undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify formatselect | fontselect fontsizeselect | bullist numlist | outdent indent | blockquote removeformat | subscript superscript | hr | forecolor backcolor | table | link unlink | emoticons image media responsivefilemanager",
    contextmenu: "link image inserttable | cell row column deletetable",
    paste_data_images: false,
    image_advtab: true,
    relative_urls: false,
   
    external_filemanager_path:"<?php echo layTuyChon("urlChinh"); ?>filemanager/",
    filemanager_title:"Quản lý tập tin",
    external_plugins: { "filemanager" : "<?php echo layTuyChon("urlChinh"); ?>filemanager/plugin.min.js"}
 });
</script>
<?php
}
?>