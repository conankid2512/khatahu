<?php
if (!defined("ADMIN")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<div class="row">
    <div class="col-md-6 margin-bottom-15">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Bạn đang có tổng cộng <?php echo $dem_PV_data[4]; ?> bài viết. Trong đó:
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr class="text-success">
                        <td><strong><?php echo $dem_PV_data[2]; ?></strong></td><td> bài viết đã được đăng</td>
                    </tr>
                    <tr class="text-info">
                        <td><strong><?php echo $dem_PV_data[1]; ?></strong></td><td> bài viết đang chờ duyệt</td>
                    </tr>
                    <tr class="text-warning">
                        <td><strong><?php echo $dem_PV_data[0]; ?></strong></td><td> bài viết đang lưu nháp</td>
                    </tr>
                    <tr class="text-danger">
                        <td><strong><?php echo $dem_PV_data[3]; ?></strong></td><td> bài viết bị từ chối</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php if($dangNhap->kiemTraQuyenHan() >= 2) { ?>
<div class="row">
    <div class="col-md-6 margin-bottom-15">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Website có tổng cộng <?php echo $dem_all_data[4]; ?> bài viết. Trong đó:
            </div>
            <div class="panel-body">
                <table class="table">
                    <tr class="text-success">
                        <td><strong><?php echo $dem_all_data[2]; ?></strong></td><td> bài viết đã được đăng</td>
                    </tr>
                    <tr class="text-info">
                        <td><strong><?php echo $dem_all_data[1]; ?></strong></td><td> bài viết đang chờ duyệt</td>
                    </tr>
                    <tr class="text-danger">
                        <td><strong><?php echo $dem_all_data[3]; ?></strong></td><td> bài viết bị từ chối</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>