<?php
if (!defined("KHATAHU")) {
    echo "Vui lòng liên hệ quản trị viên";
    exit();
}
?>
          <div class="row">
          <?php foreach($dsBaiViet_data as $baiViet_data) { ?>
            <div class="sec-topic col-sm-16 col-md-8 wow fadeInDown animated " data-wow-delay="0.5s"> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$baiViet_data["maBaiViet"];?>"><img alt="<?php echo $baiViet_data["tenBaiViet"]; ?>" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/600",$baiViet_data["hinhNho"]) ; ?>" class="img-thumbnail">
              <div class="sec-info">
                <h3><?php echo $baiViet_data["tenBaiViet"]; ?></h3>
                <div class="text-danger sub-info-bordered">
                  <div class="time"><span class="ion-clock icon"></span><time class="timeago" datetime="<?php echo $baiViet_data["timeago"]; ?>"><?php echo $baiViet_data["ngayDang"]; ?> GMT+7</time></div>
                  <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $baiViet_data["luotBinhLuan"]; ?></div>
                </div>
              </div>
              </a>
              <p><?php echo mb_substr(strip_tags($baiViet_data["noiDung"]),0,150)."..." ;  ?></p>
            </div>
          <?php } ?>

            <div class="col-sm-16">
              <hr>
              <ul class="pagination">
                <li><a href="#">&laquo;</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&raquo;</a></li>
              </ul>
            </div>
          </div>