
  <div class="panel">
    <div class="panel-body content-box">
      <h3 class="title-hero bg-primary">Expense Request</h3>
      <div class="example-box-wrapper">

        <div class="panel">
        <div class="panel-body">
          <h3 class="title-hero"> </h3>

        <div class="example-box-wrapper">
        <div id="datatable-example_wrapper" class="dataTables_wrapper form-inline no-footer">
      
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable no-footer" id="datatable-example" role="grid" aria-describedby="datatable-example_info">
        <thead>
        <tr role="row">
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" aria-sort="ascending">
        #
        </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" > User Name </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" > Project Name </th>

        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" > Type </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" > Incurred Date</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
        Amount
        </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 258px;">Reason</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"">Requested On</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" > Status </th>
      
        <th tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1">Actions</th>

        </tr>
        </thead>
        <tbody>
          <?php foreach($requests as $k=>$request_det){ ?>

            <tr class="gradeA <?php if($k%2 == 0) {?>odd <?php } else { ?> even <?php } ?>" role="row">
              <td><?= $k+1?></td>
              <td class="sorting_1"><?= $request_det->users['username']; ?></td>
              <td class="sorting_1"><?= $this->Custom->get_projectname($request_det->expense_name); ?></td>
              <td class="sorting_1"><?= $request_det->expense_types['type']; ?></td>
              <td class="sorting_1"><?= $request_det->applied_date ?></td>
              <td class="center"><?= $request_det->currency." ".$request_det->amount ?></td>
              <td class="center"><?= $request_det->reason ?></td>
              <td class="center"><?= $request_det->created ?></td>
              <td class="center"> 
                <?php if($request_det->status == 0){ ?> <div class="bs-label bg-yellow"> Pending</div> <?php } ?> 
                <?php if($request_det->status == 1){ ?> <div class="bs-label bg-green"> Approved</div> <?php } ?>
                <?php if($request_det->status == 2){ ?> 
                <a href="#" class=" popover-button-default bs-label bg-red" data-content="<?= $request_det->approved_remarks ?>" title="" data-trigger="hover" data-placement="top" data-original-title="Reject Reason">Rejected<div class="ripple-wrapper"></div></a>  <?php } ?>
              </td>
              <td class="center">
               
                <a href="<?= $this->Url->build(array("action" => "response", $request_det->id));?>"><i class="glyph-icon demo-icon tooltip-button icon-elusive-eye" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"></i></a>

              </td>
            </tr>
          <?php } ?>
        </tbody>
        </table>

        <div class="row">
        <div class="col-sm-6">
        <div class="dataTables_info" id="datatable-example_info" role="status" aria-live="polite"></div>
        </div>
        <div class="col-sm-6">
        <div class="dataTables_paginate paging_bootstrap" id="datatable-example_paginate">
        
        </div>
        </div>
        </div>

        </div>
        </div>
        </div>
        </div>

            </div>
          </div>
        </div>
        
<?php if(isset($request)){?> 

<button id="editclient" class="btn btn-default" style="display:none;" data-toggle="modal" data-target=".bs-edit-modal-lg">Add New</button>

<script type="text/javascript">
  $(document).ready(function(){
    $("#editclient").trigger("click");
  });
</script>  
<?php foreach($request as $k=>$req){ ?>
<div class="modal fade bs-remark-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate="" action="<?= $this->Url->build(array("action" => "response", $req->id,'reject'));?>"> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Reason for Reject</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper form-views">
              <div class="row">
              <div class="form-group">
                  <label class="col-sm-3 control-label">Reason</label>
                  <div class="col-sm-6">
                    <textarea name="approved_remarks" class="form-control" required></textarea>
                  </div>
                </div>
              </div>
          </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php } ?>
<div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Expense Request</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper form-views">
              <div class="row">
                <?php foreach($request as $k=>$req){ ?>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Name</label>
                  <div class="col-sm-6">
                    <span><?= $req->users['username']; ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Type</label>
                  <div class="col-sm-6">
                    <span><?= $req->leave_types['type']; ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Reason</label>
                  <div class="col-sm-6">
                    <p><?= $req->reason; ?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Amount</label>
                  <div class="col-sm-6">
                    <span><?= $req->amount; ?></span>
                  </div>
                </div>

                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Incurred Date</label>
                  <div class="col-sm-6">
                    <span><?= $req->applied_date ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Requested On</label>
                  <div class="col-sm-6">
                     <span><?= $req->created ?></span>
                  </div>
                </div>
                
                <?php } ?>
               </div>

             <input type="hidden" name="id" value="<?= $req->id ?>">
          
        </div>
        <div class="modal-footer">
          <?php if($req->status == 0) { ?>
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> 
          <a class="btn btn-hover btn-success" href="<?= $this->Url->build(array("action" => "response", $req->id,'accept'));?>">Accept</a>
          <a class="btn btn-hover btn-danger reject_button_dismiss" href="#"  data-targett=".bs-edit-modal-lg">Reject</a>
          <?php } elseif($req->status == 1) { ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          <a class="btn btn-hover btn-danger reject_button_dismiss" href="#"   data-targett=".bs-remark-modal-lg">Reject
          </a>
          <?php } elseif($req->status == 2) { ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
          <a class="btn btn-hover btn-success" href="<?= $this->Url->build(array("action" => "response", $req->id,'accept'));?>">Accept</a>
          <?php } ?>

        </div>
      </form>
    </div>
  </div>
</div>



<?php } ?>





<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<script>
function setprojectid(id){
  $('#project_doc_id').val(id);
}

$(document).on("click", ".reject_button_dismiss", function(){
  $(".bs-edit-modal-lg").modal("hide");
  setTimeout(function(){
    $(".bs-remark-modal-lg").modal("show");
  }, 1500);
});
</script>