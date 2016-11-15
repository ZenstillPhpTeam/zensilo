<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
<header>

  <div class="header_section-login" ng-app="buzztm" ng-controller="AddController">
    <div class="container">
      
	  <div class="col-lg-3 col-md-3 col-sm-2 col-xs-3">
	  <div class="clearfix">
	  </div>
	  </div>
	  <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 login mrg-top text-center" style="margin-bottom:30px;" >
	  <form name="forgot_password" method="post">
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
		    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center marg-bot " style="padding-right:0; margin-bottom:10px;">
		  <p style="color:red; margin-top:7px;" class="folder" ng-show="forgot_password.email.$invalid && forgot_password.email.$error.unique && !forgot_password.email.$error.required && !forgot_password.email.$error.email">The Email you entered is incorrect.</p>
		  <p style="color:green; margin-top:7px; text-align:center;" class="folder" ng-show="forgot_password.email.$valid">Valid email</p>
		  </div>
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

<script>
  var buzztm = angular.module('buzztm', []).service('userService', ['$q', '$http', UserService]).directive('uniqueUsername', ['userService', UniqueUsernameDirective]);
  buzztm.controller('AddController', ['$scope', '$http', '$timeout',
    function($scope, $http, $timeout) {
      
      $scope.submit = function() {
			 $scope.clicked = true;
			 if($scope.forgot_password.$valid) {
			
			 $http.post('<?= $this->Url->build(["controller" => "admin", "action" => "forgot_password"]);?>', {email: $scope.email})
			 .then(function(res){
			 	console.log(res);
	                if(res['data'] == 'error')
	                {
	                	console.log("error");
	                }
	                else
	                {
	                 	window.location.assign("<?= $this->Url->build(["controller" => "users", "action" => "login"]);?>");
	                }
				});
			}
		};

   }]);

  
  function notEmpty(value) {
    return (angular.isDefined(value))
	}
  function UniqueUsernameDirective(userService) {
      return {
           restrict: 'A',
           require: 'ngModel',
           link: function (scope, element, attrs, ngModel) {
               scope.$watch(attrs.ngModel, function(value) {
                    if(attrs.type == "email") {
	                      userService.isUniqueEmail(value)
	                      .then(function(data) {
	                        ngModel.$setValidity('unique', data.data ? true : false);
	                      })
	                      .catch(function() {
	                           ngModel.$setValidity('unique', false);
	                      });
                 	 }
               });
           }
      };
}
function UserService($q, $http) {

    this.isUniqueEmail = function(email) {
        if (notEmpty(email)) {
            var uri = '<?= $this->Url->build('/admin/check_email/');?>' + email;
            return $http.get(uri);
        }
        return $q.reject("Email already registered!!");
    }

}
</script>