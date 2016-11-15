    <div id="page-title">
          <h2>Bootstrap carousel</h2>
          <p>Use the markups below to create Bootstrap powered carousels.</p>
        </div>
        <script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/carousel/carousel.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $this->Url->build("/"); ?>assets/widgets/owlcarousel/owlcarousel.css">
        <script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/owlcarousel/owlcarousel.js"></script><script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/owlcarousel/owlcarousel-demo.js"></script>

        <?= $this->Html->script(array('../assets/widgets/modal/modal')) ?>
        
        <style type="text/css">
          .owl-buttons{color: #ccc}
        </style>

        <?php foreach($gallery as $gal){?>
        <div class="panel">
          <div class="panel-body">
            <div class="row">
              <h3 class="title-hero clearfix">
                <?= $gal->title;?>
                <button class="btn btn-default pull-right review_link" data-toggle="modal" data-target=".review_modal<?= $gal->id; ?>" data-id="<?= $gal->id; ?>">Reviews</button>
              </h3>
              <div class="example-box-wrapper">
                <div class="owl-carousel-1 slider-wrapper carousel-wrapper">
                  <?php 
                  $galimages = $this->Custom->get_gallery_images($gal->id);
                  $galreviews = $this->Custom->get_gallery_reviews($gal->id);
                  foreach($galimages as $img){
                  ?>
                  <div>
                    <div class="thumbnail-box"><a class="thumb-link" href="#" title=""></a>
                      <img class="show_image" src="<?= $this->Url->build("/upload/preview/".$img->image); ?>" alt=""></div>
                  </div>
                  <?php }?>
                </div>
              </div>
              <div class="clearfix">
                <span>No. of Reveiws : <?= count($galreviews);?></span>
              </div>

              <div class="modal fade review_modal<?= $gal->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">
                        Reviews for "<?= $gal->title;?>"
                        <button class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target=".new_review_modal">Add New</button>
                        </h4>
                      </div>
                      <div class="modal-body">
                        <div class="content-box-wrapper">
                              
                              <?php if(count($galreviews)){ foreach($galreviews as $review){?>
                              <div class="panel">
                                <div class="panel-body">
                                  <div class="clearfix">
                                    <span class="pull-left">Review by: <b><?= $review->name;?></b></span>
                                    <span class="pull-right">Review on : <b><?= $review->review_on;?></b></span>
                                  </div>
                                  <div class="clearfix" style="margin-top: 20px;">
                                    <?= $review->review;?>
                                  </div>
                                </div>
                              </div>
                              <?php }}else{?>
                                <p>No Results Found!!</p>
                              <?php }?>

                          </div>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                      </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <?php }?>

      </div>

      <script>
        $(document).ready(function(){
          $(".review_link").click(function(){
              $("#gallery_id").val($(this).data("id"));
          });

          $(document).on("click", ".thumbnail-box", function(){
              $("#full_image").attr("src", $(this).find("img").attr("src"));
              $(".image_modal").modal("show");
          });
        });
      </script>

      <div class="modal fade new_review_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">New Review</h4>
                      </div>
                      <div class="modal-body">
                        <div class="content-box-wrapper">
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Review by</label>
                                <div class="col-sm-6">
                                  <input name="name" class="form-control" id="" placeholder="Example placeholder..." type="text">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Review</label>
                                <div class="col-sm-6">
                                  <textarea name="review" id="" class="form-control"></textarea>
                                </div>
                              </div>

                          </div>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                        <input type="hidden" name="gallery_id" id="gallery_id">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


              <div class="modal fade image_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                          <div class="content-box-wrapper">
                                
                                <div class="example-box-wrapper text-center">
                                  <img src="" id="full_image">
                                </div>

                            </div>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                        </div>
                    </div>
                  </div>
                </div>