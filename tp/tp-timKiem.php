<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
<?php if(!empty($dsBaiViet_data)) { ?>
          <div class="row">
            <div class="col-sm-16">
              <h3>Có <?php echo $dem; ?> kết quả tìm kiếm cho "<?php echo $qDaXuLy; ?>"</h3>
              <hr>
            </div>
            <?php foreach($dsBaiViet_data as $baiViet_data) { ?>
            <div class="sec-topic col-sm-16 wow fadeInDown animated " data-wow-delay="0.5s">
              <div class="row">
                <div class="col-sm-7"><img alt="<?php echo $baiViet_data["tenBaiViet"]; ?>" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/600",$baiViet_data["hinhNho"]) ; ?>" class="img-thumbnail"></div>
                <div class="col-sm-9"> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$baiViet_data["maBaiViet"];?>">
                  <div class="sec-info">
                    <h3><?php echo $baiViet_data["tenBaiViet"]; ?></h3>
                    <div class="text-danger sub-info-bordered">
                      <div class="time"><span class="ion-clock icon"></span><time class="timeago" datetime="<?php echo $baiViet_data["timeago"]; ?>"><?php echo $baiViet_data["ngayDang"]; ?> GMT+7</time></div>
                      <div class="comments" title="<?php echo $baiViet_data["luotBinhLuan"]; ?> lượt bình luận"><span class="ion-chatbubbles icon"></span><?php echo $baiViet_data["luotBinhLuan"]; ?></div>
                      <div class="views" title="<?php echo $baiViet_data["luotXem"]; ?> lượt xem"><span class="ion-eye icon"></span><?php echo $baiViet_data["luotXem"]; ?></div>
                    </div>
                  </div>
                  </a>
                  <p><?php echo mb_substr(strip_tags($baiViet_data["noiDung"]),0,150)."..." ;  ?></p>
                </div>
              </div>
            </div>
            <?php } ?>

            <div class="col-sm-16">
              <hr>
                <?php echo $phanTrang_html; ?>
            </div>
          </div>
<?php } else { ?>
          <div class="row">
            <div class="col-sm-16">
              <h3>Xin lỗi, chúng tôi không tìm thấy bất kỳ bài viết nào, bạn vui lòng:</h3>
            </div>
            <div class="col-sm-16">
              <ul class="icn-list">
                <li>Kiểm tra chính tả của từ khóa.</li>
                <li>Sử dung từ khóa có dấu, hiện giờ chúng tôi chưa hổ trợ tìm kiếm tiếng việt không dấu.</li>
                <li>Sử dụng những từ khóa phổ biến hơn.</li>
                <li>Sử dụng những từ khóa đồng nghĩa.</li>
              </ul>
            </div>
          </div>
<?php } ?>