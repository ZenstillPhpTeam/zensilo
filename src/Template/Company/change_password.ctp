<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley')) ?>

        <div class="panel">
          <div class="panel-body content-box">
            <h3 class="title-hero bg-primary">Change Password</h3>
            <div class="example-box-wrapper">

            <div class="panel">
        <div class="panel-body">

        <div class="example-box-wrapper">
          <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate="">
          <div>

 <div class="row">
                  
                  <div class="col-md-12">

                <div class="form-group">
                    <label class="col-sm-3 control-label">Password<em>*</em></label>
                    <div class="col-sm-6">
                      <input type="password"  required class="form-control" name="old_password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">New Password<em>*</em></label>
                    <div class="col-sm-6">
                      <input type="password" id="ps1" required class="form-control" name="new_password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Confirm Password<em>*</em></label>
                    <div class="col-sm-6">
                      <input type="password" data-parsley-equalto="#ps1" required class="form-control" name="confirm_password">
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

            </div>
          </div>
        </div>
        
