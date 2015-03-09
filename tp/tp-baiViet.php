<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
          <div class="row"> 
            <!-- post details start -->
            <div class="col-sm-16">
              <div class="row">
                <div class="sec-topic col-sm-16  wow fadeInDown animated " data-wow-delay="0.5s">
                  <div class="row">
                    <div class="col-sm-16 sec-info">
                      <h3><?php echo $maBaiViet_data["tenBaiViet"]; ?></h3>
                      <div class="text-danger sub-info-bordered">
                        <div class="author"><span class="ion-person icon"></span>Viết bởi: <?php echo $maBaiViet_data["tenTacGia"]; ?></div>
                        <div class="time"><span class="ion-clock icon"></span><time class="timeago" datetime="<?php echo $maBaiViet_data["timeago"]; ?>"><?php echo $maBaiViet_data["ngayDang"]; ?> GMT+7</time></div>
                        <div class="comments" title="<?php echo $maBaiViet_data["luotBinhLuan"]; ?> lượt bình luận"><span class="ion-chatbubbles icon"></span><?php echo $maBaiViet_data["luotBinhLuan"]; ?></div>
                        <div class="views" title="<?php echo $maBaiViet_data["luotXem"]; ?> lượt xem"><span class="ion-eye icon"></span><?php echo $maBaiViet_data["luotXem"]; ?></div>
                      </div>
                        <?php echo $maBaiViet_data["noiDung"]; ?>
                      <hr>
                    </div>
                  </div>
                </div>
                <?php if(trim($maBaiViet_data["moTaTacGia"]) != "") { ?>
                <div class="col-sm-16 author-box">
                  <div class="row">
                    <div class=" col-xs-4 col-sm-2"><img class="img-thumbnail" data-src="holder.js/64x64/text:Khatahu" src="<?php echo layGravatar($maBaiViet_data["emailTacGia"],128);?>" width="128" height="128" alt=""/></div>
                    <div class="col-xs-12 col-sm-14">
                      <h4><?php echo $maBaiViet_data["tenTacGia"]; ?></h4>
                      <p><?php echo $maBaiViet_data["moTaTacGia"]; ?></p>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php if($_GET["chucnang"] == "baiViet") { ?>
                <?php if(isset($dSBinhLuan_data)) { ?>
                <div class="col-sm-16 comments-area">
                  <div class="main-title-outer pull-left">
                    <div class="main-title">Ý kiến bạn đọc</div>
                  </div>
                  <div class="opinion pull-left">
                  
                    <?php //Hiển thị bình luận 
                    foreach ($dSBinhLuan_data as $binhLuan_data) { ?>
                    <div class="media"> <a href="#" class="pull-left"> <img alt="64x64" data-src="holder.js/64x64/text:Khatahu" class="media-object" style="width: 64px; height: 64px;" src="<?php echo layGravatar($binhLuan_data["emailGui"]);?>"> </a>
                      <div class="media-body">
                        <div>
                          <h4 class="media-heading"><?php echo $binhLuan_data["tenNguoiGui"];?></h4>
                          <div class="time"><span class="ion-clock icon"></span><time class="timeago" datetime="<?php echo $binhLuan_data["timeago"]; ?>"><?php echo $binhLuan_data["ngayDang"]; ?> GMT+7</time></div>
                        </div>
                        <?php echo $binhLuan_data["noiDung"];?>
                        <?php if($dangNhap->kiemTraQuyenHan() == 3) {
                            //Nút xóa bình luận
                            echo "<div class=\"col-sm-16\"><a href=\"".layTuyChon("urlChinh")."admin/?chucnang=xoaBinhLuan&maBinhLuan=".$binhLuan_data["maBinhLuan"]."\"><span class=\"reply pull-right ion-android-delete icon\"></span></a></div>";
                        } ?>
                      </div>
                    </div>
                    <?php } ?>
                    
                  </div>
                </div>
                <?php } ?>
                <div class="col-sm-16">
                  <div class="main-title-outer pull-left">
                    <div class="main-title">Gửi ý kiến của bạn</div>
                  </div>
                  <div class="col-xs-16 wow zoomIn animated">
                    <form action="" method="post" name="" class="comment-form">
                      <div class="row">
                        <div class="form-group col-sm-8 name-field">
                          <input name="tenNguoiBinhLuan" type="text" placeholder="Họ và tên*" required class="form-control" value="<?php echo isset($_SESSION["dangNhap"]["tenHienThi"]) ? $_SESSION["dangNhap"]["tenHienThi"] : ""; ?>" />
                        </div>
                        <div class="form-group col-sm-8 email-field">
                          <input name="emailBinhLuan" type="email" placeholder="Email*" required class="form-control" value="<?php echo isset($_SESSION["dangNhap"]["email"]) ? $_SESSION["dangNhap"]["email"] : ""; ?>" />
                        </div>
                        <div class="form-group col-sm-16">
                          <textarea name="noiDungBinhLuan" placeholder="Nội dung*" rows="8" class="form-control" required id="message" name="message"></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-danger" type="submit"> Gửi ý kiến </button>
                      </div>
                    </form>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <!-- post details end -->
          </div>
          