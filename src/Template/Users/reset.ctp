<header>
  <?= $this->Form->create($user) ?>
  <div class="header_section-login">
    <div class="container">
      <div class="row">
	  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
	  <div class="clearfix">
	  </div>
	  </div>
	  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 login mrg-top text-center">
	  <div class="bg-color padd-rgt padd-lft row">
	  <h3>Reset Password</h3>
	  </div>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	  		<input type="password" name="password" ng-model="company.password" class="form-details add-bot" placeholder="Password" required=""  maxlength="15" minlength="8" ng-pattern="/^(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/">
	  </div>
	  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    <span ng-show="new_company.password.$invalid && (!new_company.password.$pristine || clicked)" class="fa errmsg">Should contain 8 characters and special characters.</span>
		<span ng-show="new_company.password.$valid" class="fa fa-check successmsg"></span>	
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	  <input type="password" name="confirm_password" ng-model="company.confirm_password" class="form-details add-bot" placeholder="confirm Password" required="" compare-to="company.password" maxlength="15">
	  </div>
	  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	  <span ng-show="new_company.confirm_password.$invalid && (!new_company.confirm_password.$pristine || clicked)" class="fa fa-times errmsg">Not Matching</span>
		<span ng-show="new_company.confirm_password.$valid" class="fa fa-check successmsg"></span>
	  </div>
	  <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 text-left marg-bot">
	  <div class="clearfix"></div>
	  </div>
	  
	  </div>
	  </div>
    </div>
  </div>
  <?= $this->Form->end() ?>
</header>