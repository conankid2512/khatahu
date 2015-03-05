        <div class="row">          
        <?php
        $i = 0;
        foreach($nhomTheLoaiTrangChu as $theLoai) {
            if($i % 2 == 0) {
        ?>
          <div class="col-sm-16">
            <div class="row">
        <?php
            }
        ?>
              <div class="col-xs-16 col-sm-8  wow fadeInLeft animated science" data-wow-delay="0.5s" data-wow-offset="130">
                <div class="main-title-outer pull-left">
                  <div class="main-title"><a href="<?php echo layTuyChon("urlChinh")."?chucnang=theLoai&maTheLoai=".$theLoai["maTheLoai"];?>" ><?php echo $theLoai["tenTheLoai"]; ?></a></div>
                  <div class="span-outer"><span class="pull-right text-danger last-update"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $theLoai["baiViet"][0]["timeago"]; ?>"><?php echo $theLoai["baiViet"][0]["ngayDang"]; ?> GMT+7</time></span> </div>
                </div>
                <div class="row">
                  <div class="topic col-sm-16"> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$theLoai["baiViet"][0]["maBaiViet"];?>"><img class="img-thumbnail" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/600",$theLoai["baiViet"][0]["hinhNho"]) ; ?>" alt="<?php echo $theLoai["baiViet"][0]["tenBaiViet"]; ?>"/>
                    <h3><?php echo $theLoai["baiViet"][0]["tenBaiViet"]; ?></h3>
                    <div class="text-danger sub-info-bordered ">
                      <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $theLoai["baiViet"][0]["timeago"]; ?>"><?php echo $theLoai["baiViet"][0]["ngayDang"]; ?> GMT+7</time></div>
                      <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $theLoai["baiViet"][0]["luotBinhLuan"]; ?></div>
                    </div>
                    </a>
                    <p><?php echo mb_substr(strip_tags($theLoai["baiViet"][0]["noiDung"]),0,150)."..." ;  ?></p>
                  </div>
        <?php
            if(isset($theLoai["baiViet"][1])) {
        ?>
                  <div class="col-sm-16">
                    <ul class="list-unstyled  top-bordered ex-top-padding">
                      <li> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$theLoai["baiViet"][1]["maBaiViet"];?>">
                        <div class="row">
                          <div class="col-lg-3 col-md-4 hidden-sm  "><img width="76" height="76" alt="" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/150",$theLoai["baiViet"][1]["hinhNho"]) ; ?>" class="img-thumbnail pull-left"> </div>
                          <div class="col-lg-13 col-md-12">
                            <h4><?php echo $theLoai["baiViet"][1]["tenBaiViet"]; ?></h4>
                            <div class="text-danger sub-info">
                              <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $theLoai["baiViet"][1]["timeago"]; ?>"><?php echo $theLoai["baiViet"][1]["ngayDang"]; ?> GMT+7</time></div>
                              <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $theLoai["baiViet"][1]["luotBinhLuan"]; ?></div>
                            </div>
                          </div>
                        </div>
                        </a> </li>
        <?php
                if(isset($theLoai["baiViet"][2])) {
        ?>
                      <li> <a href="<?php echo layTuyChon("urlChinh")."?chucnang=baiViet&maBaiViet=".$theLoai["baiViet"][2]["maBaiViet"];?>">
                        <div class="row ">
                          <div class="col-lg-3 col-md-4 hidden-sm  "><img width="76" height="76" alt="" src="<?php echo str_replace("/uploads/source",$_SESSION["baseURL"]."uploads/thumbs/150",$theLoai["baiViet"][2]["hinhNho"]) ; ?>" class="img-thumbnail pull-left"> </div>
                          <div class="col-lg-13 col-md-12">
                            <h4><?php echo $theLoai["baiViet"][2]["tenBaiViet"]; ?></h4>
                            <div class="text-danger sub-info">
                              <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $theLoai["baiViet"][2]["timeago"]; ?>"><?php echo $theLoai["baiViet"][2]["ngayDang"]; ?> GMT+7</time></div>
                              <div class="comments"><span class="ion-chatbubbles icon"></span><?php echo $theLoai["baiViet"][2]["luotBinhLuan"]; ?></div>
                            </div>
                          </div>
                        </div>
                        </a> </li>
        <?php
                }
        ?>
                    </ul>
                  </div>
        <?php
            }
        ?>
                </div>
              </div>
        <?php
            if($i %2 == 1) {
        ?>
            </div>
            <hr>
          </div>
        <?php
            }
            $i++;
        }
        ?>
        <?php
        if($i %2 == 1) {
        ?>
            </div>
            <hr>
          </div>
        <?php
        }
        ?>        
          <!--wide ad start-->
          <div class="col-sm-16 wow fadeInDown animated " data-wow-delay="0.5s" data-wow-offset="25"><img class="img-responsive" src="images/ads/728-90-ad.gif" width="728" height="90" alt=""/></div>
          <!--wide ad end--> 
          
        </div>