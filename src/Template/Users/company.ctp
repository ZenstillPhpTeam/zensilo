<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley','../assets/geocomplete/jquery.geocomplete','../assets/geocomplete/logger')) ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABoNKJFpUbthmMDNobEWxO1sICZ6GkfBc&libraries=places"></script>
<style type="text/css">
  .pac-container{z-index: 10000!important;}
</style>
        <div class="panel">
          <div class="panel-body content-box">
            <h3 class="title-hero bg-primary">Companies</h3>
            <div class="example-box-wrapper">

            <div class="panel">
        <div class="panel-body">
        <h3 class="title-hero">Company List <button class="btn btn-alt btn-hover btn-primary float-right"  data-toggle="modal" data-target=".bs-example-modal-lg"><span>Add New</span> <i class="glyph-icon icon-arrow-right"></i><div class="ripple-wrapper"></div></button></h3>

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
        <th class="sorting_asc" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 201px;" aria-sort="ascending">
        Company Name
        </th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 258px;">Email</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 240px;">Mobile</th>
        <th class="sorting" tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 170px;">Location</th>
        <th tabindex="0" aria-controls="datatable-example" rowspan="1" colspan="1"  >Actions</th>
        
        </tr>
        </thead>
        <tbody>
          <?php foreach($users as $k=>$user_det){?>
        <tr class="gradeA <?php if($k%2 == 0) {?>odd <?php } else { ?> even <?php } ?>" role="row">
        <td><?= $k+1?></td>
        <td class="sorting_1"><?= $user_det->client_name ?></td>
        <td><?= $user_det->user->email ?></td>
        <td><?= $user_det->mobile ?></td>
        <td class="center"><?= $user_det->location ?></td>
        <td class="center">
              <a href="<?= $this->Url->build(array("action" => "company", $user_det->user_id));?>"><i class="glyph-icon demo-icon tooltip-button icon-elusive-pencil"></i></a>&nbsp;&nbsp;
                <a href="<?= $this->Url->build(array("action" => "company", $user_det->user_id, "delete"));?>" onclick="javascript:confirm('Are you sure want to delete this Company?')"><i class="glyph-icon demo-icon tooltip-button icon-elusive-trash"></i></a></td>
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
     $("#geocomplete1").geocomplete();
  });
</script>  
<div class="modal fade bs-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate=""> 
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit Company</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

              <div class="row">
                  <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Company Name</label>
                  <div class="col-sm-6">
                    <input name="client_name" class="form-control" id="" placeholder="Company Name" type="text" required="" value="<?= $client->client_name ?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">About Company</label>
                  <div class="col-sm-6">
                    <textarea name="about_client" id="" class="form-control" required=""><?= $client->about_client ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-6">
                    <input name="email" class="form-control" id="" type="text" data-parsley-type="email" required="" value="<?= $client->user->email ?>"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Mobile</label>
                  <div class="col-sm-6">
                    <input name="mobile" class="form-control" id="" type="text" data-parsley-type="digits" required="" data-parsley-minlength="10" data-parsley-maxlength="10" value="<?= $client->mobile ?>"/>
                  </div>
                </div>
                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Username</label>
                  <div class="col-sm-6">
                    <input name="username" class="form-control" id="" type="text" data-parsley-type="alphanum" required="" readonly value="<?= $client->user->username ?>">
                  </div>
                </div>

                </div>
                  <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Address 1</label>
                  <div class="col-sm-6">
                    <input name="address1" class="form-control"   type="text" required="" value="<?= $client->address1 ?>"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Address 2</label>
                  <div class="col-sm-6">
                    <input name="address2" class="form-control" id="" type="text" value="<?= $client->address2 ?>"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Location</label>
                  <div class="col-sm-6">
                    <input name="location" class="form-control" id="geocomplete1" type="text" required="" value="<?= $client->location ?>">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Zip code</label>
                  <div class="col-sm-6">
                    <input name="zip" class="form-control" id="" type="text" data-parsley-type="digits" required="" value="<?= $client->zip ?>">
                  </div>
                </div>
                <input type="hidden" name="id" value="<?= $client->user_id ?>">

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
          <h4 class="modal-title">New Company</h4>
        </div>
        <div class="modal-body">
          <div class="content-box-wrapper">

          <div class="row">
                  <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Company Name</label>
                  <div class="col-sm-6">
                    <input name="client_name" class="form-control" id="" placeholder="Company Name" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">About Company</label>
                  <div class="col-sm-6">
                    <textarea name="about_client" id="" class="form-control" required=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-6">
                    <input name="email" class="form-control" id="" type="text" data-parsley-type="email" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Mobile</label>
                  <div class="col-sm-6">
                    <input name="mobile" class="form-control" id="" type="text" data-parsley-type="digits" required="" data-parsley-minlength="10" data-parsley-maxlength="10">
                  </div>
                </div>
                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Username</label>
                  <div class="col-sm-6">
                    <input name="username" class="form-control" id="" type="text" data-parsley-type="alphanum" required="">
                  </div>
                </div>

                </div>
                  <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Address 1</label>
                  <div class="col-sm-6">
                    <input name="address1" class="form-control" id="" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Address 2</label>
                  <div class="col-sm-6">
                    <input name="address2" class="form-control" id="" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Location</label>
                  <div class="col-sm-6">
                    <input name="location" class="form-control" id="geocomplete" type="text" required="">
                  </div>
                </div>
               
                <div class="form-group">
                  <label class="col-sm-3 control-label">Zip code</label>
                  <div class="col-sm-6">
                    <input name="zip" class="form-control" id="" type="text" data-parsley-type="digits" required="">
                  </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-6">
                      <input type="text" id="ps1" required class="form-control" name="password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Confirm Password</label>
                    <div class="col-sm-6">
                      <input type="text" data-parsley-equalto="#ps1" required class="form-control" name="confirm_password">
                    </div>
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
<script type="text/javascript">
  $(document).ready(function() {
  $("#geocomplete").geocomplete();
  });
</script>