                <form role="form" data-toggle="validator" action="<?php echo layTuyChon("urlChinh")."admin/?chucnang=kiemDuyetBaiViet"; ?>" method="POST">
                    <div class="col-sm-16 bt-space wow fadeInUp animated" data-wow-delay="1s" data-wow-offset="130">
                        <input type="hidden" name="maBaiViet" value="<?php echo $_GET["maBaiViet"]; ?>">
                        <label for="trangThai">Trạng thái bài viết</label>
                        <select class="form-control" id="trangThai" name="trangThai">
                            <?php echo "<option value=\"1\" ".($maBaiViet_data["trangThai"] == 1 ? "selected" : null).">Chờ duyệt</option>"; ?>
                            <?php echo "<option value=\"2\" ".($maBaiViet_data["trangThai"] == 2 ? "selected" : null).">Đã duyệt</option>"; ?>
                            <?php echo "<option value=\"3\" ".($maBaiViet_data["trangThai"] == 3 ? "selected" : null).">Từ chối</option>"; ?>                                                        
                        </select>
                        <div class="help-block with-errors"></div>                       
                    </div>
                    <div class="col-sm-16 bt-space wow fadeInUp animated" data-wow-delay="1s" data-wow-offset="130">
                        <label for="trangThai">Hình đại diện cho bài viết</label>
                        <div class="input-group">
                    	    <input data-remote="<?php echo layTuyChon("urlChinh"); ?>kiemTraHinhAnh.php" value="<?php echo $maBaiViet_data["hinhNho"]; ?>" class="form-control" id="hinhNho" name="hinhNho" data-error="Hình đại diện không hợp lệ! Vui lòng chọn hình đại diện từ thư viện hình." value="" type="text" required />
                            <span class="input-group-btn">
                    	       <a href="<?php echo layTuyChon("urlChinh"); ?>filemanager/dialog.php?type=1&amp;field_id=hinhNho" class="btn btn-danger iframe-btn" type="button">Chọn hình</a>
                            </span>
                    	</div>
                        <div class="help-block with-errors"></div>
                    </div>                                        
                    <div class="col-sm-16 bt-space wow fadeInUp animated" data-wow-delay="1s" data-wow-offset="130">
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
                    <div class="col-sm-16 bt-space">
                        <button type="submit" class="btn btn-danger">Kiểm duyệt bài viết</button>
                        <button type="reset" class="btn btn-default">Hủy bỏ</button>    
                    </div>
                </form>