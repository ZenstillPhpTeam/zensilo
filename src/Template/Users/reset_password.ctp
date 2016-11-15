<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
<header>

  <div class="header_section-login" ng-app="buzztm" ng-controller="AddController">
    <div class="container">
      <div class="row">
	  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
	  <div class="clearfix">
	  </div>
	  </div>
	  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 login mrg-top text-center">
	  <form name="forgot_password" method="post">
		  <div class="bg-color padd-rgt padd-lft row">
		  <h3>PASSWORD RECOVERY</h3>
		  </div>
		  <div class="heading">
		  <p class="folder" style="margin-top:30px;">Enter your email address below and we'll send you password reset instructions</p>
		  </div>
		  <div class="row">
			  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 mar-top">
			  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				  	<input type="password" class="form-details" id="Business" placeholder="New Password" name="password" ng-model="password" required="" ng-pattern="/^(?=.*?[a-z])(?=.*?[#?!@$%^&*-]).{8,}$/">
				  	<span ng-show="forgot_password.password.$invalid  && (!forgot_password.password.$pristine || clicked)" class="fa fa-times errmsg"></span>
					<span ng-show="forgot_password.password.$valid" class="fa fa-check successmsg"></span>
					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;">
				  	<input type="password" class="form-details" id="Business" placeholder="Confirm Password" name="cpassword" ng-model="cpassword" required="" compare-to="password">
				  	<span ng-show="forgot_password.cpassword.$invalid  && (!forgot_password.cpassword.$pristine || clicked)" class="fa fa-times errmsg"></span>
					<span ng-show="forgot_password.cpassword.$valid" class="fa fa-check successmsg"></span>
					
				</div>
			  </div>
			  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			  	Should contain 8 characters and a special character.
			  </div>
		  </div>
		  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left marg-bot">
		  <div class="clearfix"></div>
		  </div>
		  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left row marg-bot1">
		  <p><span>Be cool.</span><a class="btn btn-next" ng-click="submit();">SUBMIT <i class="fa fa-angle-double-right" aria-hidden="true"></i>
	</a></p>
		  </div>
	  </div>
	  </div>
    </div>
  </div>

</header>

<script>
  var buzztm = angular.module('buzztm', []);
  buzztm.controller('AddController', ['$scope', '$http', '$timeout',
    function($scope, $http, $timeout) {
      
      $scope.submit = function() {
			 $scope.clicked = true;
			 if($scope.forgot_password.$valid) {
			
			 $http.post('<?= $this->Url->build(["controller" => "admin", "action" => "reset_password"]);?>', {password: $scope.password, user_id: <?= $user_id?>})
			 .then(function(res){
			 	console.log(res);
	                if(res['data'] == 'error')
	                {
	                	console.log("error");
	                }
	                else
	                {
	                 	<?php if($redirectto){?>
	                 		window.location.assign("<?= $this->Url->build(['controller' => 'book', "action" => 'preview', base64_encode(base64_encode($redirectto[0])), $redirectto[1]]);?>");
	                 	<?php }else{?>
	                 		window.location.assign("<?= $this->Url->build(["controller" => "users", "action" => "login"]);?>");
	                 	<?php }?>
	                }
				});
			}
		};

   }]);

  buzztm.directive('compareTo',function() {
    return {
        require: "ngModel",
        scope: {
            otherModelValue: "=compareTo"
        },
        link: function(scope, element, attributes, ngModel) {
             
            ngModel.$validators.compareTo = function(modelValue) {
                return modelValue == scope.otherModelValue;
            };
 
            scope.$watch("otherModelValue", function() {
                ngModel.$validate();
            });
        }
    };
});

</script>