<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley')) ?>

        <div class="panel">
          <div class="panel-body content-box">
            <h3 class="title-hero bg-primary">Designations / User Roles</h3>
            <div class="example-box-wrapper">

            <div class="panel">
        <div class="panel-body">
        <h3 class="title-hero"><button class="btn btn-alt btn-hover btn-primary0 float-right"  data-toggle="modal" data-target=".bs-example-modal-lg"><span>Add New</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button></h3>

        <div class="example-box-wrapper">
        <div id="datatable-example_wrapper" class="dataTables_wrapper form-inline no-footer">
        <div class="row">
        <div class="col-sm-6">
        <div class="dataTables_length" id="datatable-example_length">
        <label>
        
        </label>
        </div>
        </div>
        <div class="col-sm-6">
        <div id="datatable-example_filter" class="dataTables_filter">
        <label>
        
        </label>
        </div>
        </div>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dataTable no-footer" id="datatable-example" role="grid" aria-describedby="datatable-example_info">
        <thead>
        <tr role="row">
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" aria-sort="ascending">
        #
        </th>
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending"  aria-sort="ascending">
             Designations / User Roles   </th>
        <th>Access Project</th>
        <th>Access Client</th>
        <th>Access User</th>
        <th>Access Setting</th>
        <th tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1"  >Actions</th>
        
        </tr>
        </thead>
        <tbody>
          <?php foreach($designation as $k=>$user_det){?>
        <tr class="gradeA <?php if($k%2 == 0) {?>odd <?php } else { ?> even <?php } ?>" role="row">
        <td><?= $k+1?></td>
        <td class="sorting_1"><?= $user_det->designation ?></td>
        <td><?= $user_det->project_access ? 'Yes' : 'No';?></td>
        <td><?= $user_det->client_access ? 'Yes' : 'No';?></td>
        <td><?= $user_det->user_access ? 'Yes' : 'No';?></td>
        <td><?= $user_det->setting_access ? 'Yes' : 'No';?></td>
        <td class="center">
              <a href="<?= $this->Url->build(array("controller" => "company", "action" => "designation", $user_det->id));?>"><i class="glyph-icon demo-icon tooltip-button icon-elusive-pencil"></i></a>&nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("controller" => "company", "action" => "designation", $user_det->id, "delete"));?>" onclick="return confirm('Are you sure want to delete this Designation?')"><i class="glyph-icon demo-icon tooltip-button icon-elusive-trash"></i></a></td>
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
        
<?php if(isset($client)){?> 
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
          <h4 class="modal-title">Edit Designation</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">
                  <div class="col-md-12">

                <div class="form-group append_more_values">
                  <label class="col-sm-3 control-label">Designation<em>*</em></label>
                  <div class="col-sm-6">
                    <input name="designation" class="form-control" id="" placeholder="Client Name" type="text" required="" value="<?= $client->designation ?>" />
                    <br>
                    <span>Rights To : </span>
                    <input type="checkbox" name="checkbox_dummy" <?= $client->project_access ? 'checked' : '' ?>>
                    <input type="hidden" name="project_access" value="<?= $client->project_access ?>">
                    <span>Project&nbsp;</span>
                    <input type="checkbox" name="checkbox_dummy" <?= $client->client_access ? 'checked' : '' ?>>
                    <input type="hidden" name="client_access" value="<?= $client->client_access ?>">
                    <span>Client&nbsp;</span>
                    <input type="checkbox" name="checkbox_dummy" <?= $client->user_access ? 'checked' : '' ?>>
                    <input type="hidden" name="user_access" value="<?= $client->user_access ?>">
                    <span>User&nbsp;</span>
                    <input type="checkbox" name="checkbox_dummy" <?= $client->setting_access ? 'checked' : '' ?>>
                    <input type="hidden" name="setting_access" value="<?= $client->setting_access ?>">
                    <span>Settings&nbsp;</span>
                  </div>
                  
                </div>
                
                  
                <input type="hidden" name="id" value="<?= $client->id ?>">

                </div>
                </div>

            </div>
          
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
          <h4 class="modal-title">New Designation</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row append_more_values">
                <div class="form-group list_designation">
                  <label class="col-sm-3 control-label">Designation<em>*</em></label>
                  <div class="col-sm-6">
                    <input name="designation[]" class="form-control" id="" placeholder="Client Name" type="text" required="">
                    <br>
                    <span>Rights To : </span>
                    <input type="checkbox" name="checkbox_dummy">
                    <input type="hidden" name="project_access[]" value="0">
                    <span>Project&nbsp;</span>
                    <input type="checkbox" name="checkbox_dummy">
                    <input type="hidden" name="client_access[]" value="0">
                    <span>Client&nbsp;</span>
                    <input type="checkbox" name="checkbox_dummy">
                    <input type="hidden" name="user_access[]" value="0">
                    <span>User&nbsp;</span>
                    <input type="checkbox" name="checkbox_dummy">
                    <input type="hidden" name="setting_access[]" value="0">
                    <span>Settings&nbsp;</span>
                  </div>
                  <div class="col-sm-3">
                    <i class="glyph-icon icon-plus add_more btn btn-success"></i>
                    <i class="glyph-icon icon-times delete_more btn btn-danger"></i>
                  </div>
                </div>
                </div>

            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> 
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/template" id="add_more_template">
  <div class="form-group list_designation">
    <label class="col-sm-3 control-label">Designation<em>*</em></label>
    <div class="col-sm-6">
      <input name="designation[]" class="form-control" id="" placeholder="Client Name" type="text" required="">
      <br>
      <span>Rights To : </span>
      <input type="checkbox" name="checkbox_dummy">
      <input type="hidden" name="project_access[]" value="0">
      <span>Project&nbsp;</span>
      <input type="checkbox" name="checkbox_dummy">
      <input type="hidden" name="client_access[]" value="0">
      <span>Client&nbsp;</span>
      <input type="checkbox" name="checkbox_dummy">
      <input type="hidden" name="user_access[]" value="0">
      <span>User&nbsp;</span>
      <input type="checkbox" name="checkbox_dummy">
      <input type="hidden" name="setting_access[]" value="0">
      <span>Settings&nbsp;</span>
    </div>
    <div class="col-sm-3">
      <i class="glyph-icon icon-plus add_more btn btn-success"></i>
      <i class="glyph-icon icon-times delete_more btn btn-danger"></i>
    </div>
  </div>
</script>

<script type="text/javascript">
  $(document).on("click", ".add_more", function(){
    $(this).parents(".list_designation").after($("#add_more_template").html());
  });
  $(document).on("click", ".delete_more", function(){
    $(this).parents(".list_designation").remove();
    if($(".list_designation").length == 1)
    {
      $(".delete_more").hide();
    }
    else
    {
      $(".delete_more").show();
    }
  });
  $(document).on("click", ".append_more_values input[type='checkbox']", function(){
    $(this).next("input[type='hidden']").val($(this).is(":checked") ? 1 : 0);
  });
</script>