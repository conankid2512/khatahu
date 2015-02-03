<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<?php
if(!$maNhanVien_data) $baoLoi = "Mã nhân viên không tồn tại";
?>
<h1>Sửa nhân viên</h1>
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
if($dangNhap->kiemTraQuyenHan() == 3 && $maNhanVien_data) {
?>
<div class="row">
    <div class="col-md-12">
        <form role="form" id="templatemo-preferences-form" data-toggle="validator" action="" method="POST">
            <div class="row">
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="tenDangNhap">Tên đăng nhập</label>
                    <input class="form-control" pattern="^([_a-z0-9]){3,64}$" id="tenDangNhap" value="<?php echo $maNhanVien_data["tenDangNhap"]; ?>" type="text" name="tenDangNhap" data-minlength="3" maxlength="64" data-error="Tối thiểu 3, tối đa 64 ký tự chữ thường, số, và &quot;_&quot;" required />
                    <div class="help-block with-errors"></div>   
                </div>
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="quyenHan">Quyền hạn nhân viên</label>
                    <select class="form-control" id="quyenHan" name="quyenHan" required data-error="Vui lòng chọn quyền hạn cho nhân viên">
                        <option value="">Vui lòng chọn...</option>
                        <option value="3" <?php if($maNhanVien_data["quyenHan"] == 3) echo "selected";?>>Quản trị viên</option>
                        <option value="2" <?php if($maNhanVien_data["quyenHan"] == 2) echo "selected";?>>Biên tập viên</option>
                        <option value="1" <?php if($maNhanVien_data["quyenHan"] == 1) echo "selected";?>>Phóng viên</option>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="matKhau">Mật Khẩu</label>
                    <input class="form-control" type="password" id="matKhau" name="matKhau" data-minlength="8" data-error="Mật khẩu tối thiểu 8 ký tự" />
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="nhapLaiMatKhau">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" id="nhapLaiMatKhau" name="nhapLaiMatKhau" data-match="#matKhau" data-error="Xác nhận mật khẩu không trùng khớp" />
                    <div class="help-block with-errors"></div>  
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="tenHienThi" class="control-label">Họ và Tên</label>
                    <input class="form-control" id="tenHienThi" value="<?php echo $maNhanVien_data["tenHienThi"]; ?>" type="text" name="tenHienThi" data-minlength="3" maxlength="64" data-error="Tối thiểu 3, tối đa 64 ký tự" required />
                    <div class="help-block with-errors"></div>                  
                </div>
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="email">Địa chỉ Email</label>
                    <input class="form-control" id="email" value="<?php echo $maNhanVien_data["email"]; ?>" type="email" name="email" maxlength="255" data-error="Email không đúng định dạng hoặc dài hơn 255 ký tự" required />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 margin-bottom-15 form-group">
                    <label for="moTaNgan">Mô tả ngắn</label>
                    <textarea class="form-control" rows="3" id="moTaNgan" name="moTaNgan" style="width: 100%;"><?php echo $maNhanVien_data["moTaNgan"]; ?></textarea>
                </div>
            </div>
            
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="checkbox">
                        <label>
                            <input value="" type="checkbox">
                            Gửi thông tin đăng nhập cho nhân viên qua email
                        </label>
                    </div>              
                </div>                            
            </div> -->               
            <div class="row templatemo-form-buttons">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <button type="reset" class="btn btn-default">Hủy bỏ</button>    
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo layTuyChon("urlChinh"); ?>js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    theme: "modern",
    skin: "light",
    language : "vi",
    selector: "#moTaNgan",
    plugins: "advlist, charmap, contextmenu, image, media, visualblocks, link, paste, textcolor, emoticons, hr, table, responsivefilemanager",
    toolbar: "undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify formatselect | fontselect fontsizeselect | bullist numlist | outdent indent | blockquote removeformat | subscript superscript | hr | forecolor backcolor | table | link unlink | emoticons image media responsivefilemanager",
    contextmenu: "link image inserttable | cell row column deletetable",
    paste_data_images: false,
    image_advtab: true,
    relative_urls: false,
   
    external_filemanager_path:"<?php echo $_SESSION["RF"]["baseURL"]; ?>filemanager/",
    filemanager_title:"Quản lý tập tin",
    external_plugins: { "filemanager" : "<?php echo $_SESSION["RF"]["baseURL"]; ?>filemanager/plugin.min.js"}
 });
</script>
<?php
}
?>