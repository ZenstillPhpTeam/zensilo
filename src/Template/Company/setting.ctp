<?= $this->Html->script(array('../assets/widgets/wizard/wizard', '../assets/widgets/wizard/wizard-demo', '../assets/widgets/tabs/tabs', '../assets/widgets/chosen/chosen', '../assets/widgets/chosen/chosen-demo','../assets/widgets/parsley/parsley')) ?>

        <div class="panel">
          <div class="panel-body content-box">
            <h3 class="title-hero bg-primary">My Account</h3>
            <div class="example-box-wrapper">

            <div class="panel">
        <div class="panel-body">

        <div class="example-box-wrapper">
          <form method="post" enctype="multipart/form-data" class="form-horizontal bordered-row" data-parsley-validate="">
          <div>
 <div class="row">
                  <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Company Name<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->client_name;?>" name="client_name" class="form-control" id="" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">About Company</label>
                  <div class="col-sm-6">
                    <textarea name="about_client" id="" class="form-control"><?= $profile->about_client;?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Email<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $myacc->email;?>" name="email" readonly="" class="form-control" id="" type="text" data-parsley-type="email" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Mobile<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->mobile;?>" name="mobile" class="form-control" id="" type="text" data-parsley-type="digits" required="" data-parsley-minlength="10" data-parsley-maxlength="10">
                  </div>
                </div>
                <div class="form-group .bordered-row">
                  <label class="col-sm-3 control-label">Username<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $myacc->username;?>" name="username" readonly="" class="form-control" id="" type="text" required="">
                  </div>
                </div>

                </div>
                  <div class="col-md-6">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Address 1<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->address1;?>" name="address1" class="form-control" id="" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Address 2</label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->address2;?>" name="address2" class="form-control" id="" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">City<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->city;?>" name="city" class="form-control" id="" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">State<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->state;?>" name="state" class="form-control" id="" type="text" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Zip code<em>*</em></label>
                  <div class="col-sm-6">
                    <input value="<?= $profile->zip;?>" name="zip" class="form-control" id="" type="text"  required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Image</label>
                  <div class="col-sm-6">
                    <input name="image" class="form-control" type="file"  >
                  </div>
                  <?php if(isset($profile->image) && !empty($profile->image)){?>
                  <img width="100" src="<?= $profile->image;?>">
                  <?php }?>
                </div>


                </div>
                </div>

            </div>
            <div class="modal-footer">
          <button type="submit" class="btn btn-hover btn-primary">Save changes</button>
        </div>
            </form>
        </div>
        </div>
        </div>

            </div>
          </div>
        </div>
        
