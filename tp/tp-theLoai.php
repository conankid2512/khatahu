<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
          <div class="row">
          
          <?php $i = 0; foreach($dsBaiViet_data as $baiViet_data) { ?>
            <div class="sec-topic col-sm-16 col-md-8 wow fadeInDown animated <?php if($i % 2 == 1) echo "left-bordered" ?>" data-wow-delay="0.5s"> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$baiViet_data["maBaiViet"];?>"><img alt="<?php echo $baiViet_data["tenBaiViet"]; ?>" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/600",$baiViet_data["hinhNho"]) ; ?>" class="img-thumbnail">
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
            <?php if($i % 2 == 1) echo "<div style=\"clear:both\"></div>" ?>
          <?php $i++;} ?>

            <div class="col-sm-16">
              <hr>
                <?php echo $phanTrang_html; ?>
            </div>
          </div>