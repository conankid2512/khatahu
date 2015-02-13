<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<h1 class="margin-bottom-15">Thêm thể loại</h1>
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
                <label for="tenTheLoai">Tên thể loại</label>
                <input class="form-control" id="tenTheLoai" value="" type="text" name="tenTheLoai" data-minlength="3" maxlength="64" data-error="Tối thiểu 3, tối đa 64 ký tự" required />
                <div class="help-block with-errors"></div>
            </div>
            <div class="col-md-6 margin-bottom-15 form-group">
                <label for="maTheLoaiCha">Thể loại cha</label>
                <select class="form-control" id="maTheLoaiCha" name="maTheLoaiCha">
                    <option value="0">Không có</option>
                    <?php
                    foreach($theLoaiCha as $key => $value){
                        echo "<option value=\"".$key."\">".$value["tenTheLoai"]."</option>";
                    }
                    ?>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-12 alert alert-warning">
                    Các tùy chọn sau chỉ có hiệu lực với thể loại cha. Nhập số 0 để không hiển thị trên menu hoặc trang chủ.
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="tenTheLoai">Thứ tự trên Menu chính</label>
                    <input class="form-control" id="tTMenu" value="" type="text" name="tTMenu" pattern="^([0-9]){1,5}$" data-error="Số nguyên dương, tối đa 5 chữ số" />
                    <div class="help-block with-errors"></div>
                </div>
                <div class="col-md-6 margin-bottom-15 form-group">
                    <label for="tenTheLoai">Thứ tự trên trang chủ</label>
                    <input class="form-control" id="tTTrangChu" value="" type="text" name="tTTrangChu" pattern="^([0-9]){1,5}$" data-error="Số nguyên dương, tối đa 5 chữ số" />
                    <div class="help-block with-errors"></div>
                </div>
            </div>
                     
        <div class="row templatemo-form-buttons">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Thêm thể loại</button>
                <button type="reset" class="btn btn-default">Hủy bỏ</button>    
            </div>
        </div>
    </form>
</div>