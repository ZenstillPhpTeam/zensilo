<header>
  <div class="header_section-login" >
    <div class="container">
      
	  <div class="col-lg-3 col-md-3 col-sm-2 col-xs-3">
	  <div class="clearfix">
	  </div>
	  </div>
	  <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 login mrg-top text-center" style="margin-bottom:30px;" >
	  <form name="forgot_password" method="post" action="">
		  <div class="bg-color padd-rgt padd-lft" style="margin-right:-15px; margin-left:-12px;">
		  <h3 style="margin:0; padding: 10px 0;">Have trouble signing in?</h3>
		  </div>
		  <div class="heading">
		  <p class="folder" style="margin-top:30px;">To recover your password,<br>enter the Email associated with your account.</p>
		  </div>
		  <div class="row">
			  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			  	<div class="clearfix"></div>
			  </div>
			  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 mar-top">
			  	<input autocomplete="off" type="email" class="form-details lan-view" id="Business" placeholder="Email" name="email" ng-model="email" required="" unique-username>
			  	<!--<span ng-show="forgot_password.email.$invalid  && (!forgot_password.email.$pristine || clicked)" class="fa fa-times errmsg hide"></span>
				<span ng-show="forgot_password.email.$valid" class="fa fa-check successmsg"></span>-->

			  </div>
		  </div>
		  <div class="row">
		   
		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left marg-bot">
		    <p><a href="<?= $this->Url->build(array('controller' => 'users', 'action'=>'login'));?>" class="btn btn-back" style="margin-left:-12px;">  <i class="fa fa-angle-double-left" aria-hidden="true"></i>BACK
          	</a></p>
		  </div>
		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left  marg-bot">
		  <p><a class="btn btn-next" style="margin-right:-15px;" ng-click="submit();">SUBMIT <i class="fa fa-angle-double-right" aria-hidden="true"></i>
			</a></p>
		  </div>
		  
	  </div>
	  </div>
    </div>
  </div>

</header>

