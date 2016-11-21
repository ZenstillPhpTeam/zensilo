<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley','../assets/widgets/datepicker/datepicker','../assets/widgets/datepicker-ui/datepicker')) ?>

  <div class="panel">
    <div class="panel-body content-box">
      <h3 class="title-hero bg-primary">Leave Request</h3>
      <div class="example-box-wrapper">

        <div class="panel">
        <div class="panel-body">
          <h3 class="title-hero"> Leave Request List 
            <button class="btn btn-alt btn-hover btn-primary float-right"  data-toggle="modal" data-target=".bs-example-modal-lg">
              <span>Add New</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div>
            </button>
          </h3>

        <div class="example-box-wrapper">
        <div id="datatable-example_wrapper" class="dataTables_wrapper form-inline no-footer">
      
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable no-footer" id="datatable-example" role="grid" aria-describedby="datatable-example_info">
        <thead>
        <tr role="row">
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" aria-sort="ascending">
        #
        </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" > Start Date</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" > End Date</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
        No Of Days
        </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 258px;">Reason</th>
         <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"">Requested On</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" > Status </th>
      
        <th tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1">Actions</th>

        </tr>
        </thead>
        <tbody>
          <?php foreach($requests as $k=>$request_det){?>

            <tr class="gradeA <?php if($k%2 == 0) {?>odd <?php } else { ?> even <?php } ?>" role="row">
              <td><?= $k+1?></td>
              <td class="sorting_1"><?= $request_det->start_date ?></td>
              <td><?= $request_det->end_date ?></td>
              <td><?= $request_det->no_of_days ?></td>
              <td class="center"><?= $request_det->reason ?></td>
              <td class="center"><?= $request_det->created ?></td>
              <td class="center"> 
                <?php if($request_det->status == 0){ ?> <div class="bs-label bg-yellow"> Pending</div> <?php } ?> 
                <?php if($request_det->status == 1){ ?> <div class="bs-label bg-green"> Approved</div> <?php } ?>
                <?php if($request_det->status == 2){ ?> <div class="bs-label bg-red"> Rejected </div> <?php } ?>
              </td>
              <td class="center">
               <?php if($request_det->status == 0){ ?> 
                <a href="<?= $this->Url->build(array("action" => "request", $request_det->id));?>"><i class="glyph-icon demo-icon tooltip-button icon-elusive-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>
                 &nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("action" => "request", $request_det->id, "delete"));?>" onclick="javascript:confirm('Are you sure want to delete this Project?')"><i class="glyph-icon demo-icon tooltip-button icon-elusive-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i></a>
                <?php } else{ ?> 
                <a href="javascript:;"><i class="glyph-icon demo-icon tooltip-button icon-elusive-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>
                 &nbsp;&nbsp;
                <a href="javascript:;"><i class="glyph-icon demo-icon tooltip-button icon-elusive-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"></i></a>
                <?php }  ?>

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

<div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit Request</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Reason</label>
                  <div class="col-sm-6">
                    <textarea name="reason" id="" class="form-control" required=""><?= $request->reason; ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">No of days</label>
                  <div class="col-sm-6">
                    <input name="no_of_days" class="form-control" type="number" value="<?= $request->no_of_days; ?>">
                  </div>
                </div>

                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Estimated Start Date</label>
                  <div class="col-sm-6">
                    <input name="start_date"  id="" type="text" class="bootstrap-datepicker form-control"  data-date-format="yyyy-mm-dd" required="" value="<?= $request->start_date ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Estimated End Date</label>
                  <div class="col-sm-6">
                    <input name="end_date"  id="" type="text" class="bootstrap-datepicker1 form-control"  data-date-format="yyyy-mm-dd" value="<?= $request->end_date ?>">
                  </div>
                </div>
                
              </div>

             <input type="hidden" name="id" value="<?= $request->id ?>">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php } ?>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">New Leave Request</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">
            <div class="row">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Reason</label>
                  <div class="col-sm-6">
                    <textarea name="reason" id="" class="form-control" required=""></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">No of days</label>
                  <div class="col-sm-6">
                    <input name="no_of_days" class="form-control" type="number">
                  </div>
                </div>

                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Estimated Start Date</label>
                  <div class="col-sm-6">
                    <input name="start_date"  id="" type="text" class="bootstrap-datepicker form-control"  data-date-format="yyyy-mm-dd" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Estimated End Date</label>
                  <div class="col-sm-6">
                    <input name="end_date"  id="" type="text" class="bootstrap-datepicker1 form-control"  data-date-format="yyyy-mm-dd">
                  </div>
                </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save request</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

<?= $this->Html->script(array('../assets/widgets/multi-upload/jquery.iframe-transport', '../assets/widgets/multi-upload/jquery.fileupload', '../assets/widgets/multi-upload/jquery.fileupload-process', '../assets/widgets/multi-upload/jquery.fileupload-image', '../assets/widgets/multi-upload/jquery.fileupload-audio', '../assets/widgets/multi-upload/jquery.fileupload-video', '../assets/widgets/multi-upload/jquery.fileupload-validate', '../assets/widgets/multi-upload/jquery.fileupload-ui', '../assets/widgets/multi-upload/main')); ?>
<!--[if (gte IE 8)&(lt IE 10)]>
<?= $this->Html->script(array('../assets/widgets/multi-upload/cors/jquery.xdr-transport')); ?>
<![endif]-->

<script>
function setprojectid(id){
  //console.log(id);
  $('#project_doc_id').val(id);
  //console.log($('#project_doc_id').val());
}
</script>