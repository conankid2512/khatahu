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
                        <div class="time"><span class="ion-android-data icon"></span><time class="timeago" datetime="<?php echo $maBaiViet_data["timeago"]; ?>"><?php echo $maBaiViet_data["ngayDang"]; ?> GMT+7</time></div>
                        <div class="comments"><span class="ion-chatbubbles icon"></span>204</div>
                        <div class="stars"><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star-half"></span></div>
                      </div>
<?php echo $maBaiViet_data["noiDung"]; ?>
                      <hr>
                    </div>
                  </div>
                </div>
                <div class="col-sm-16 author-box">
                  <div class="row">
                    <div class=" col-xs-4 col-sm-2"><img class="img-thumbnail" src="images/comments/com-1.jpg" width="128" height="128" alt=""/></div>
                    <div class="col-xs-12 col-sm-14">
                      <h4><a href="#">Author Name</a></h4>
                      <p>Nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-16 related">
                  <div class="main-title-outer pull-left">
                    <div class="main-title">related topics</div>
                  </div>
                  <div class="row">
                    <div class="item topic col-sm-5 col-xs-16"> <a href="#"> <img class="img-thumbnail" src="images/sec/sec-1.jpg" width="1000" height="606" alt=""/>
                      <h4>Etiam rhoncus. Maecenas tempus, tellus eget condimentum</h4>
                      <div class="text-danger sub-info-bordered remove-borders">
                        <div class="time"><span class="ion-android-data icon"></span>Dec 9 2014</div>
                        <div class="comments"><span class="ion-chatbubbles icon"></span>204</div>
                        <div class="stars"><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star-half"></span></div>
                      </div>
                      </a> </div>
                    <div class="item topic col-sm-5 col-xs-16"> <a href="#"> <img class="img-thumbnail" src="images/sec/sec-2.jpg" width="1000" height="606" alt=""/>
                      <h4>Etiam rhoncus. Maecenas tempus, tellus eget condimentum</h4>
                      <div class="text-danger sub-info-bordered remove-borders">
                        <div class="time"><span class="ion-android-data icon"></span>Dec 9 2014</div>
                        <div class="comments"><span class="ion-chatbubbles icon"></span>204</div>
                        <div class="stars"><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star-half"></span></div>
                      </div>
                      </a> </div>
                    <div class="item topic col-sm-5 col-xs-16"> <a href="#"> <img class="img-thumbnail" src="images/sec/sec-3.jpg" width="1000" height="606" alt=""/>
                      <h4>Etiam rhoncus. Maecenas tempus, tellus eget condimentum</h4>
                      <div class="text-danger sub-info-bordered remove-borders">
                        <div class="time"><span class="ion-android-data icon"></span>Dec 9 2014</div>
                        <div class="comments"><span class="ion-chatbubbles icon"></span>204</div>
                        <div class="stars"><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star"></span><span class="ion-ios7-star-half"></span></div>
                      </div>
                      </a> </div>
                  </div>
                </div>
                <div class="col-sm-16 comments-area">
                  <div class="main-title-outer pull-left">
                    <div class="main-title">comments</div>
                  </div>
                  <div class="opinion pull-left">
                    <div class="media"> <a href="#" class="pull-left"> <img alt="64x64" data-src="holder.js/64x64" class="media-object" style="width: 64px; height: 64px;" src="images/comments/com-1.jpg"> </a>
                      <div class="media-body">
                        <div>
                          <h4 class="media-heading">John Doe</h4>
                          <div class="time text-danger"><span class="ion-android-data icon"></span>Dec 9 2014</div>
                        </div>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <div class="col-sm-16"><a href="#"><span class="reply pull-right ion-ios7-compose"></span></a></div>
                      </div>
                    </div>
                    <div class="media"> <a href="#" class="pull-left"> <img alt="64x64" data-src="holder.js/64x64" class="media-object" style="width: 64px; height: 64px;" src="images/comments/com-2.jpg"> </a>
                      <div class="media-body">
                        <div>
                          <h4 class="media-heading">John Doe</h4>
                          <div class="time text-danger"><span class="ion-android-data icon"></span>Dec 9 2014</div>
                        </div>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla.
                        <div class="col-sm-16"><a href="#"><span class="reply pull-right ion-ios7-compose"></span></a></div>
                        <div class="media nested-rep pull-left"> <a href="#" class="pull-left"> <img alt="64x64" class="media-object" style="width: 64px; height: 64px;" src="images/comments/com-1.jpg"> </a>
                          <div class="media-body ">
                            <div>
                              <h4 class="media-heading">John Doe</h4>
                              <div class="time text-danger"><span class="ion-android-data icon"></span>Dec 9 2014</div>
                            </div>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                            <div class="col-sm-16"><a href="#"><span class="reply pull-right ion-ios7-compose"></span></a></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-16">
                  <div class="main-title-outer pull-left">
                    <div class="main-title">leave a comment</div>
                  </div>
                  <div class="col-xs-16 wow zoomIn animated">
                    <form action="#" method="post" name="" class="comment-form">
                      <div class="row">
                        <div class="form-group col-sm-8 name-field">
                          <input type="text" placeholder="Name*" required="" class="form-control">
                        </div>
                        <div class="form-group col-sm-8 email-field">
                          <input type="email" placeholder="Email*" required="" class="form-control" >
                        </div>
                        <div class="form-group col-sm-16">
                          <textarea placeholder="Your Message" rows="8" class="form-control" required id="message" name="message">                  </textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-danger" type="submit"> Post Reply </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- post details end --> 
            
          </div>