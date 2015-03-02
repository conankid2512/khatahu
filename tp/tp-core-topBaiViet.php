            <?php $topBaiViet = topBaiViet(); ?>
            <!-- activities start -->
            <div class="col-sm-16 bt-space wow fadeInUp animated" data-wow-delay="1s" data-wow-offset="130"> 
              <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-justified " role="tablist">
                <li class="active"><a href="#xemnhieu" role="tab" data-toggle="tab">Xem nhiều</a></li>
                <li><a href="#baimoi" role="tab" data-toggle="tab">Bài mới</a></li>
                <li><a href="#binhluan" role="tab" data-toggle="tab">Bình luận</a></li>
              </ul>
              
              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane active" id="xemnhieu">
                  <ul class="list-unstyled">
                  <?php foreach($topBaiViet["xemNhieu"] as $xemNhieu) { ?>
                    <li> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$xemNhieu["maBaiViet"];?>">
                      <div class="row">
                        <div class="col-sm-5 col-md-4"><img class="img-thumbnail pull-left" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/150",$xemNhieu["hinhNho"]) ; ?>" width="164" height="152" alt=""/> </div>
                        <div class="col-sm-11 col-md-12">
                          <h4><?php echo $xemNhieu["tenBaiViet"]; ?></h4>
                          <div class="text-danger sub-info">
                            <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $xemNhieu["timeago"]; ?>"><?php echo $xemNhieu["ngayDang"]; ?> GMT+7</time></div>
                            <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $xemNhieu["luotBinhLuan"]; ?></div>
                          </div>
                        </div>
                      </div>
                      </a> </li>
                  <?php } ?>
                  </ul>
                </div>
                <div class="tab-pane" id="baimoi">
                  <ul class="list-unstyled">
                  <?php foreach($topBaiViet["moiNhat"] as $baiMoi) { ?>
                    <li> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$baiMoi["maBaiViet"];?>">
                      <div class="row">
                        <div class="col-sm-5 col-md-4"><img class="img-thumbnail pull-left" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/150",$baiMoi["hinhNho"]) ; ?>" width="164" height="152" alt=""/> </div>
                        <div class="col-sm-11 col-md-12">
                          <h4><?php echo $baiMoi["tenBaiViet"]; ?></h4>
                          <div class="text-danger sub-info">
                            <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $baiMoi["timeago"]; ?>"><?php echo $baiMoi["ngayDang"]; ?> GMT+7</time></div>
                            <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $baiMoi["luotBinhLuan"]; ?></div>
                          </div>
                        </div>
                      </div>
                      </a> </li>
                  <?php } ?>
                  </ul>
                </div>
                <div class="tab-pane" id="binhluan">
                  <ul class="list-unstyled">
                  <?php foreach($topBaiViet["binhLuanNhieu"] as $binhLuanNhieu) { ?>
                    <li> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$binhLuanNhieu["maBaiViet"];?>">
                      <div class="row">
                        <div class="col-sm-5 col-md-4"><img class="img-thumbnail pull-left" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/150",$binhLuanNhieu["hinhNho"]) ; ?>" width="164" height="152" alt=""/> </div>
                        <div class="col-sm-11 col-md-12">
                          <h4><?php echo $binhLuanNhieu["tenBaiViet"]; ?></h4>
                          <div class="text-danger sub-info">
                            <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $binhLuanNhieu["timeago"]; ?>"><?php echo $binhLuanNhieu["ngayDang"]; ?> GMT+7</time></div>
                            <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $binhLuanNhieu["luotBinhLuan"]; ?></div>
                          </div>
                        </div>
                      </div>
                      </a> </li>
                  <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
            <!-- activities end -->