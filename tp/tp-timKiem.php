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
                      <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $baiViet_data["luotBinhLuan"]; ?></div>
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
<?php } else { ?>
          <div class="row">
            <div class="col-sm-16">
              <h3>Sorry, we didn't find any result but you can still try:</h3>
            </div>
            <div class="col-sm-16">
              <ul class="icn-list">
                <li>Check your spelling.</li>
                <li>Try more general words.</li>
                <li>Try different words that mean the same thing.</li>
                <li><a href="#">Post a request</a> and we will help you.</li>
              </ul>
              <hr>
              <h3>Or you can discover populat topics in:</h3>
              <ul class="icn-list">
                <li><a href="#">In enim justo.</a></li>
                <li><a href="#">Aenean vulputate eleifend tellus.</a></li>
                <li><a href="#"> Etiam ultricies nisi vel.</a></li>
                <li><a href="#">Nam quam nunc.</a></li>
              </ul>
            </div>
          </div>
<?php } ?>