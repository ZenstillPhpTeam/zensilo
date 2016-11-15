<script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/carousel/carousel.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $this->Url->build("/"); ?>assets/widgets/owlcarousel/owlcarousel.css">
<script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/owlcarousel/owlcarousel.js"></script><script type="text/javascript" src="<?= $this->Url->build("/"); ?>assets/widgets/owlcarousel/owlcarousel-demo.js"></script>
<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/modal/modal')) ?>
<div class="panel">
  <div class="panel-body">
    <h3 class="title-hero">
    Tickets
    </h3>
    <div class="example-box-wrapper">
      <div class="hide-columns">
        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Subject</th>
              <th>Message</th>
              <th>Media</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($tickets as $k=>$cat){?>
            <tr>
              <td><?= $k+1?></td>
              <td><?= $cat->name;?><?php if($cat->status == 0){?><sup class="bs-label badge-yellow">New</sup><?php }?></td>
              <td><?= $cat->email;?></td>
              <td><?= $cat->mobile;?></td>
              <td><?= $cat->subject;?></td>
              <td><?= $cat->message;?></td>
              <td>
                <?php if(trim($cat->media) && count(explode(",", $cat->media))){?>
                <i class="glyph-icon icon-eye" data-toggle="modal" data-target=".review_modal<?= $cat->id; ?>"></i>
                <div class="modal fade review_modal<?= $cat->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h4 class="modal-title">
                          Ticket from "<?= $cat->name;?>"
                          </h4>
                        </div>
                        <div class="modal-body">
                          <div class="content-box-wrapper">
                                
                                <div class="example-box-wrapper">
                                  <div class="owl-carousel-1 slider-wrapper carousel-wrapper">
                                    <?php 
                                    foreach(explode(",", $cat->media) as $ii){
                                    ?>
                                    <div>
                                      <div class="thumbnail-box"><a class="thumb-link" href="#" title=""></a>
                                        <img src="<?= $this->Url->build("/upload/tickets/".$ii); ?>" alt=""></div>
                                    </div>
                                    <?php }?>
                                  </div>
                                </div>

                            </div>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                        </div>
                    </div>
                  </div>
                </div>
                <?php }?>
              </td>
              <td>
                <?php if($cat->status == 0){?>
                <a href="<?= $this->Url->build(array("action" => "tickets", $cat->id, 1));?>"><i class="glyph-icon icon-check"></i></a>&nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("action" => "tickets", $cat->id, 2));?>" onclick="javascript:confirm('Are you sure want to reject this ticket?')"><i class="glyph-icon icon-times"></i></a>
                <?php }elseif($cat->status == 1){?>
                <span class="bs-label label-success">Approved</span>
                <?php }else{ ?>
                <span class="bs-label label-primary">Rejected</span>
                <?php } ?>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>