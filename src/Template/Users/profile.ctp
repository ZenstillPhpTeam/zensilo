<div ng-app="buzztm" ng-controller="AddController" ng-cloak>
<form action="" name="new_company">
<div class="profile-header">
  <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="profile-title">
  <h3>My Profile</h3>
  </div>
  </div>
  </div>
</div>
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <div class="profile">
    <h3>PERSONAL DETAILS <span class="save-icon" ng-show="edit1" ng-click="next('personal_info');"><i class="fa fa-floppy-o" aria-hidden="true"></i>
    Save</span><span class="pro-icon" ng-show="!edit1"  ng-click="edit1=true;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</span></h3>
    
    <input type="hidden" name="user_id" ng-model="company.user_id" />
    <div class="row">
    <div class="form-group">
          <label class="control-label col-lg-2 col-md-2 col-sm-4 col-xs-12" for="Company">Name:</label>
          <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
            <label ng-show="!edit1">{{user_details.contact_person}}</label> 
            <input type="text" class="form-details2" id="Company" placeholder="M Anand Ram" name="contact_person" ng-model="company.contact_person" ng-if="edit1"/>
          </div>
        </div>
    	</div>
    	<div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-2 col-md-2 col-sm-4 col-xs-12" for="Company">Email:</label>
          <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
          <label ng-show="!edit1">{{user_details.email}}</label>
            <input type="email" class="form-details2" id="Company" placeholder="anand@myingage.com" ng-show="edit1" name="email" ng-model="company.email" disabled="" />
          </div>
        </div>
    	</div>
    	<div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-2 col-md-2 col-sm-4 col-xs-12" for="Company">Phone:</label>
          <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
          <label ng-show="!edit1">{{user_details.mobile}}</label>
            <input ng-class="{field_invalid:edit1 && new_company.mobile.$invalid && (!new_company.mobile.$pristine || clicked), field_valid:edit1 && new_company.mobile.$valid && (!new_company.mobile.$pristine || clicked)}" type="text" class="form-details2" id="Company" placeholder="9045784598" ng-show="edit1" name="mobile" ng-model="company.mobile" required="" ng-pattern="/^[0-9]*$/" minlength="10" maxlength="10"/>
          </div>
        </div>
    	</div>
    <h3>BUSINESS DETAILS<span class="save-icon" ng-show="edit2" ng-click="next('business_info');"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span> <span class="pro-icon" ng-show="!edit2"  ng-click="edit2=true;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</span></h3> 
    <div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="Company">Company Name:</label>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
          <label ng-show="!edit2">{{user_details.company_name}}</label>
            <input ng-class="{field_invalid:edit2 && new_company.company_name.$invalid && (!new_company.company_name.$pristine || clicked), field_valid:edit2 &&  new_company.company_name.$valid && (!new_company.company_name.$pristine || clicked)}" type="text" class="form-details2" id="Company" placeholder="Ingage Technologies Pvt, Ltd." ng-show="edit2" name="company_name" ng-model="company.company_name" required="" />
          </div>
        </div>
    	</div>
    	<div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="Company">Category:</label>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
          <label ng-show="!edit2">{{user_details.business_category_name}}</label>
            <select ng-class="{field_invalid:edit2 && new_company.business_category.$invalid && (!new_company.business_category.$pristine || clicked), field_valid:edit2 &&  new_company.business_category.$valid && (!new_company.business_category.$pristine || clicked)}" name="business_category" ng-model="company.business_category" ng-show="edit2" required="" class="form-details2" >
              <option value="">Select</option>
              <option  ng-repeat="cat in categories" value="{{cat.id}}">{{cat.name}}</option>
            </select>
            <img ng-show="edit2" class="select-arrow" src=<?= $this->Url->build('/img/select.png'); ?>>
          </div>
        </div>
    	</div>
    	
      <div class="row" ng-hide="edit2">
      <div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="Company">Address</label>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
          <label ng-show="!edit2">{{user_details.address}}, {{user_details.address1}}</label><br>
            {{user_details.city_name}}, {{user_details.state_name}}<br>
            {{user_details.country_name}} - {{user_details.zipcode}}
          </div>
        </div>
      </div>

      <div class="row" ng-show="edit2">
    	<div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="Company">Address Line 1:</label>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
          <input ng-class="{field_invalid:edit2 && new_company.address.$invalid && (!new_company.address.$pristine || clicked), field_valid:edit2 &&  new_company.address.$valid && (!new_company.address.$pristine || clicked)}" type="text" class="form-details2" id="Company" placeholder="Ingage Technologies Pvt, Ltd." ng-show="edit2" name="address" ng-model="company.address" required="" />
          </div>
        </div>
    	</div>
    	<div class="row" ng-show="edit2">
    	<div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="Company">Address Line 2:</label>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
          <input type="text" class="form-details2" id="Company" placeholder="Ingage Technologies Pvt, Ltd." ng-show="edit2" name="address1" ng-model="company.address1" />
            
          </div>
        </div>
    	</div>
    	<div class="row" ng-show="edit2">
    	<div class="form-group">
          <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12" for="City">Country:</label>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label ng-show="!edit2">{{user_details.country_name}}</label>
            <select ng-class="{field_invalid:edit2 && new_company.country.$invalid && (!new_company.country.$pristine || clicked), field_valid:edit2 &&  new_company.country.$valid && (!new_company.country.$pristine || clicked)}" class="form-details1" id="City" ng-show="edit2" name="country"  ng-show="edit2"  ng-model="company.country"  ng-change="company.state=''" required="">
            <option value="">Select</option>
             <option ng-repeat="c in country_list" ng-if="c.cid" value="{{c.cid}}">{{c.cname}}</option>
            </select>
            <img ng-show="edit2" class="select-arrow1" src=<?= $this->Url->build('/img/select.png'); ?>>
          </div>
    	  <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12" for="Pin">State:</label>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label ng-show="!edit2">{{user_details.state_name}}</label>
            <select ng-class="{field_invalid:edit2 && new_company.state.$invalid && (!new_company.state.$pristine || clicked), field_valid:edit2 &&  new_company.state.$valid && (!new_company.state.$pristine || clicked)}" class="form-details1" id="Pin" ng-show="edit2"  name="state" ng-model="company.state" required=""  ng-change="company.city=''">
            <option value="">Select</option>
            <option ng-repeat="c in get_state_list(company.country) track by $index" value="{{c.sid}}">{{c.sname}}</option>
            </select>
            <img ng-show="edit2" class="select-arrow1" src=<?= $this->Url->build('/img/select.png'); ?>>
          </div>
        </div>	
    	</div>
    	<div class="row" ng-show="edit2">
    	<div class="form-group">
          <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12" for="City">City:</label>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label ng-show="!edit2">{{user_details.city_name}}</label>
            <select ng-class="{field_invalid:edit2 && new_company.city.$invalid && (!new_company.city.$pristine || clicked), field_valid:edit2 &&  new_company.city.$valid && (!new_company.city.$pristine || clicked)}" class="form-details1" id="City" ng-show="edit2"  ng-show="edit2"  name="city" ng-model="company.city"  required="">
            <option value="">Select</option>
            <option ng-repeat="c in get_city_list(company.state) track by $index" value="{{c.ciid}}">{{c.ciname}}</option>
            </select>
            <img ng-show="edit2" class="select-arrow1" src=<?= $this->Url->build('/img/select.png'); ?>>
          </div>
    	  <label class="control-label col-sm-2 col-xs-12" for="Pin">Pin:</label>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label ng-show="!edit2">{{user_details.zipcode}}</label>
            <input ng-class="{field_invalid:edit2 && new_company.zipcode.$invalid && (!new_company.zipcode.$pristine || clicked), field_valid:edit2 &&  new_company.zipcode.$valid && (!new_company.zipcode.$pristine || clicked)}" type="text" class="form-details1" ng-show="edit2" placeholder="600003"  ng-show="edit2"  name="zipcode" ng-model="company.zipcode"  required="" ng-pattern="/^[0-9]*$/"  maxlength="6" minlength="6"/>
          </div>
        </div>	
    	</div>
    	<div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-12" for="Company">Office Phone:</label>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
          <label ng-show="!edit2">{{user_details.phone}}</label>
            <input ng-class="{field_invalid:edit2 && new_company.phone.$invalid && (!new_company.phone.$pristine || clicked), field_valid:edit2 &&  new_company.phone.$valid && (!new_company.phone.$pristine || clicked)}" type="text" class="form-details2" id="Company" placeholder="044 - 2256987" ng-show="edit2" name="phone" ng-model="company.phone" ng-pattern="/^[0-9]*$/" maxlength="15" minlength="6"/>
          </div>
        </div>
    	</div>
    </div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
    <div class="profile_section marg-top">
    <img src="{{company.logo}}" ng-if="company.logo" id="logo-img"/>
    <img src="<?= $this->Url->build('/images/profile.png'); ?>" ng-if="!company.logo" id="logo-img"/>
    <input type="file"  ng-model="company.logo" name="logo" id="company_logo" class="hide">
    <span class="profile_name change">CHANGE IMAGE</span>
    </div>
    <div class="profile">
    <h3>LOGIN DETAILS</h3>
    <div class="row">
    <div class="form-group">
     <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-6" for="Company">Username :</label> 
     <label class="control-label col-lg-7 col-md-7 col-sm-7 col-xs-6" id="Company">{{user_details.username}}</label> 
   
     </div>
    </div>
    <div class="row" ng-show="edit4">
    <div class="form-group">
     <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-6" for="Company">Old Password :</label> 
     <label class="control-label col-lg-7 col-md-7 col-sm-7 col-xs-6" id="Company">
       <input ng-class="{field_invalid:edit4 && new_company.old_password.$invalid && (!new_company.old_password.$pristine || clicked), field_valid:edit4 &&  new_company.old_password.$valid && (!new_company.old_password.$pristine || clicked)}" type="password" class="form-details1" id="Company" placeholder="*********" ng-show="edit4" name="old_password" ng-model="company.old_password" >
     </label> 
   
     </div>
    </div>
    
    <div class="row">
    <div class="form-group">
     <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-6" for="Company">Password : </label> 
     <label class="control-label col-lg-4 col-md-4 col-sm-4 col-xs-6" id="Company" ng-show="!edit4">*********</label>
     <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6">
     <input required ng-class="{field_invalid:edit4 && new_company.password.$invalid && (!new_company.password.$pristine || clicked), field_valid:edit4 &&  new_company.password.$valid && (!new_company.password.$pristine || clicked)}" type="password" class="form-details1" id="Company" placeholder="*********" ng-if="edit4" name="password" ng-model="company.password" maxlength="15" minlength="9" ng-pattern="/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{9,}$/">
      <div class="password_pattern_check" style="width: 290px; left: -65px; top: 40px;">
                            <label class="control-label " for="Role">Your password must</label><br/>
                            <span >
                              <i ng-class="{'fa-check success':!new_company.password.$error.minlength && !new_company.password.$error.required,'fa-times':new_company.password.$error.minlength || new_company.password.$error.required}" class="fa fa-check-circle"></i>Be atleast 9 characters
                            </span>
                            <span>
                            <i ng-class="{'fa-check success':passwordcheck(new_company.password.$viewValue, 'validupper'), 'fa-times':!passwordcheck(new_user.password.$viewValue, 'validupper')}" class="fa fa-check-circle"></i>Include upper case
                          </span>
                          <span>
                            <i ng-class="{'fa-check success':passwordcheck(new_company.password.$viewValue, 'validlower'), 'fa-times':!passwordcheck(new_user.password.$viewValue, 'validlower')}" class="fa fa-check-circle"></i>Include lowercase
                          </span>
                          <span>
                            <i ng-class="{'fa-check success':passwordcheck(new_company.password.$viewValue, 'validnumber'), 'fa-times':!passwordcheck(new_user.password.$viewValue, 'validnumber')}" class="fa fa-check-circle"></i>include a number
                          </span>
                          <span>
                            <i ng-class="{'fa-check success':passwordcheck(new_company.password.$viewValue, 'validspecial'), 'fa-times':!passwordcheck(new_user.password.$viewValue, 'validspecial')}" class="fa fa-check-circle"></i>Include special character
                          </span>
                          
                         
                          <span>
                            <i ng-class="{'fa-check success':passwordcheck(new_company.password.$viewValue, 'validwhitespace'), 'fa-times':!passwordcheck(new_user.password.$viewValue, 'validwhitespace')}" class="fa fa-check-circle"></i>not start or end with whitespace
                          </span>
      </div>
     </div>
     </div>
    </div>
    <div class="row" ng-show="edit4">
    <div class="form-group">
     <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-6" for="Company">Confirm Password :</label> 
     <label class="control-label col-lg-7 col-md-7 col-sm-7 col-xs-6" id="Company">
       <input ng-class="{field_invalid:edit4 && new_company.confirm_password.$invalid && (!new_company.confirm_password.$pristine || clicked), field_valid:edit4 &&  new_company.confirm_password.$valid && (!new_company.confirm_password.$pristine || clicked)}" type="password" class="form-details1" id="Company" placeholder="*********" ng-show="edit4" name="confirm_password" ng-model="company.confirm_password" compare-to="company.password">
     </label> 
   
     </div>
    </div>
    
    <div class="row">
    <div class="form-group">
     <span class="save-icon" ng-show="edit4" ng-click="next('chpassword');"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span>
     <label class="control-label col-lg-5 col-md-5 col-sm-5 col-xs-6" id="Company" ng-show="!edit4" ng-click="edit4=true;"><span class="pro-icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </span>Change</label> 
     </div>
    </div>
    <h3>SUB-DOMAIN</h3>
    <p><label>{{user_details.subdomain}}</label>.mybuzztm.com</p>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="profile">
    <h3>COMPANY DESCRIPTION <span class="save-icon" ng-show="edit3" ng-click="next('about');"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span> <span class="pro-icon" ng-show="!edit3"  ng-click="edit3=true;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</span>
    </h3>
    <div class="profile">
    <label ng-show="!edit3">{{user_details.about}}</label>
    <textarea style="resize: none" rows="6" class="form-details2" ng-show="edit3" name="about" ng-model="company.about">{{user_details.about}}</textarea>
    </div>
    <h3 class="hide">PAYMENT METHODS</h3>
    <div class="payment hide">
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
    	<div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="Company">CARD NUMBER</label>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="card number" id="Company" placeholder="****" maxlength="4" minlength="4">
    		<input type="text" class="card" id="Company" placeholder="****" maxlength="4" minlength="4">
    		<input type="text" class="card" id="Company" placeholder="****" maxlength="4" minlength="4">
    		<input type="text" class="card number1" id="Company" placeholder="****" maxlength="4" minlength="4">
          </div>
        </div>
    	</div>
    		<div class="row">
    		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
          <label class="control-label" for="City">EXPIRES ON</label>
            <input type="text" class="card1 number" id="Company" placeholder="08" maxlength="2" minlength="2">
    		    <input type="text" class="card1 number1" id="Company" placeholder="18" maxlength="2" minlength="2">
    	  </div>
    	  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">	
    	  <label class="control-label" for="Pin">SECURITY </label>     
            <input type="text" class="form-details2" id="Company" placeholder="***" maxlength="3" minlength="3">       	
    	</div>
    	</div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center ">
    <label class="control-label" for="Pin">CARD TYPE</label> 
    <img src=<?= $this->Url->build('/images/cord.png'); ?>>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
    	<div class="row">
    	<div class="form-group">
          <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="Company">NAME ON CARD</label> 
    	   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-details2" id="Company" placeholder="M.ANAND RAM">
    		</div>
        </div>
    	<div class="col-lg-6 col-md-6 col-sm-6 col-xa-12" style=" margin-top: 10px;">
    		<a href="" class="btn btn-7">CANCEL</a>
    		</div>
    		<div class="col-lg-6 col-md-6 col-sm-6 col-xa-12" style=" margin-top: 10px;">
    		<a href="" class="btn btn-6">SAVE CARD</a>
    		</div>
    	</div>
    </div>
    </div>
    </div>
</div>
</form>
</div>

<script>

 $(document).ready(function(){
   
    $(".profile_name").click(function(e){
      e.preventDefault();
      $("#company_logo").trigger("click");
    });

  });
var buzztm = angular.module('buzztm', []).service('userService', ['$q', '$http', UserService]).directive('uniqueUsername', ['userService', UniqueUsernameDirective]);

  buzztm.controller('AddController', ['$scope', '$http', '$timeout',
    function($scope, $http, $timeout) {
      $scope.clicked = false;
    $scope.indexOf = function(array, item) {
        for (var i = 0; i < array.length; i++) {
            if (JSON.stringify(array[i])  === JSON.stringify(item)) return i;
        }
        return -1;
    }

    $scope.company = {};
    $scope.country = <?= json_encode($countries); ?>;
    $scope.categories = <?= json_encode($categories);?>;
    user_det = <?= json_encode($user); ?>;
    $scope.user_details = user_det[0];
    $scope.company = user_det[0];
    company_details = [];
    $scope.country_list = [];
    $scope.state_list = [];
    $scope.city_list = [];
    $scope.books = [];

    angular.forEach($scope.country, function(v,k){
      $scope.country_list[parseInt(v.cid)] = v;
      $scope.state_list[parseInt(v.cid)] = $scope.state_list[parseInt(v.cid)] === undefined ? [] : $scope.state_list[parseInt(v.cid)];
      state = {sid: v.sid, sname: v.sname};
      if($scope.indexOf($scope.state_list[parseInt(v.cid)], state) === -1)
      $scope.state_list[parseInt(v.cid)].push(state);
      $scope.city_list[parseInt(v.sid)] = $scope.city_list[parseInt(v.sid)] === undefined ? [] : $scope.city_list[parseInt(v.sid)];
      $scope.city_list[parseInt(v.sid)].push(v);
    });

    
    $scope.get_state_list = function(id){
      return $scope.state_list[parseInt(id)] === undefined ? [] : $scope.state_list[parseInt(id)];
    };

    $scope.get_city_list = function(id){
      $res = $scope.city_list[parseInt(id)] === undefined ? [] : $scope.city_list[parseInt(id)];
      return $res;
    };

      country = $scope.company.country;
      delete $scope.company.country;
      state = $scope.company.state;
      delete $scope.company.state;
      city = $scope.company.city;
      delete $scope.company.city;
      delete $scope.company.password;
      cat = $scope.company.business_category;
      delete $scope.company.business_category;
      $timeout(function(){
                      $scope.company.country =  country;
                       $scope.company.business_category = cat;
                      $timeout(function(){
                        $scope.company.state =  state;
                        $timeout(function(){
                          $scope.company.city = city;
                        }, 100);
                      }, 100);
                    }, 100);



     $scope.passwordcheck = function(val,type) {
      if(val === undefined) return false;

      pattern = {};
      pattern['validnumber'] = /\d+/;
      pattern['validlower'] = /[a-z]+/; //lowercase values
      pattern['validupper'] = /[A-Z]+/; //uppercase values
      pattern['validspecial'] = /\W+/;    //special characters
      pattern['validwhitespace'] = /^\S+$/;   //no whitespace allowed
      return pattern[type].test(val);
    };

     $scope.next = function($val)
        {
            $scope.clicked = true;
                 if($scope.new_company.$valid) {
              if($val == 'personal_info')
                $scope.data = {contact_person: $scope.company.contact_person, email: $scope.company.email, mobile: $scope.company.mobile ,user_id:$scope.company.user_id };
              else if($val == 'business_info')
              $scope.data = {business_category: $scope.company.business_category, company_name: $scope.company.company_name, address: $scope.company.address, address1: $scope.company.address1, country: $scope.company.country, state: $scope.company.state, city: $scope.company.city, zipcode: $scope.company.zipcode, phone: $scope.company.phone,user_id:$scope.company.user_id};
              else if($val == 'about')
                $scope.data = {about:$scope.company.about ,user_id:$scope.company.user_id};
              else if($val == 'chpassword')
              {  
                $scope.data = {old_password:$scope.company.old_password, password:$scope.company.password ,user_id:$scope.company.user_id};

                if($scope.company.old_password == $scope.company.password)
                {
                  swal({
                      title: "",
                      text: "The old password should not match the new password!",
                      type: "error",
                      showCancelButton: false,
                      confirmButtonColor: '#DD6B55',
                      confirmButtonText: 'Okay'
                  });
                  return false;
                }
              }

            $http.post('<?= $this->Url->build(["controller" => "users", "action" => "add_client"]);?>', $scope.data)
             .then(function(res){
              console.log(res);
                        if(res['data'] == 'error')
                        {
                          console.log("error");
                          if($val == 'chpassword')
                          {
                              swal({
                                  title: "",
                                  text: "Invalid old Password",
                                  type: "error",
                                  showCancelButton: false,
                                  confirmButtonColor: '#DD6B55',
                                  confirmButtonText: 'Okay'
                              });
                          }
                        }
                        else
                        {
                          if($val == 'personal_info')
                          $scope.edit1 = false;
                          else if($val == 'business_info')
                          $scope.edit2 = false;
                        else if($val == 'about')
                          $scope.edit3 = false;
                         else if($val == 'chpassword')
                          $scope.edit4 = false;
                         //window.location.reload();

                          if($val == 'business_info')
                          {
                              $scope.user_details.business_category_name = res['data'][0].business_category_name;
                              $scope.user_details.state_name = res['data'][0].state_name;
                              $scope.user_details.city_name = res['data'][0].city_name;
                              $scope.user_details.country_name = res['data'][0].country_name;
                          }

                            if($val == 'chpassword')
                            {
                              $scope.company.old_password = '';
                              $scope.company.confirm_password = '';
                              $scope.company.password = '';
                              swal({
                                  title: "",
                                  text: "Password Reset successfully",
                                  type: "success",
                                  showCancelButton: false,
                                  confirmButtonColor: '#DD6B55',
                                  confirmButtonText: 'Okay'
                              });
                            }
                            else
                            {
                              swal({
                                  title: "",
                                  text: "Client details Updated",
                                  type: "success",
                                  showCancelButton: false,
                                  confirmButtonColor: '#DD6B55',
                                  confirmButtonText: 'Okay'
                              });
                            }
                            
                        }
              });
        }

        };
          var formData = 0;

        $(document).on("change", "#company_logo", function(e){
            $scope.handleFileSelect(e, true);
            $scope.changelogo();
        });

        $scope.handleFileSelect = function(evt, manual) {
          evt.stopPropagation();
          evt.preventDefault();
          f = evt.target.files[0];
          formData = new FormData();
          formData.append('file', f);
          formData.append('filename', f.name);
          formData.append('image_key', f.name);
          formData.append('apikey', 'summa_token');
        }
        $scope.changelogo = function()
        {
         if(formData)
                  {
                    $(".common_preloader").show();

                    $.ajax({
                        url : '//api.mybuzztm.com/0.1/image/upload',
                        crossDomain: true,
                        type: "POST",
                        data : formData,
                        processData: false,
                        contentType: false,
                        dataType:'json',
                        success:function(response, textStatus, jqXHR){
                           $(".common_preloader").hide();
                           if(response.status)
                           {
                              $("#logo-img").attr("src",response.image_url+"?ts="+new Date().getTime());
                              $scope.$apply(function(){
                                $scope.company.logo = response.image_url;
                                $scope.data = {logo:response.image_url ,user_id:$scope.company.user_id};
                                $http.post('<?= $this->Url->build(["controller" => "users", "action" => "add_client"]);?>', $scope.data)
                                       .then(function(res){
                                        console.log(res);
                                                  if(res['data'] == 'error')
                                                  {
                                                    console.log("error");
                                                  }
                                                  else
                                                  {
                                                    
                                                  }
                                        });
                              });
                           }
                           else
                           {
                              $(".dashboard_section .message").remove();
                              $(".dashboard_section").prepend('<div onclick="this.classList.add(\'hidden\')" class="message error">Error While Uploading Image. Try Again!!.</div>');
                           }
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            $(".dashboard_section .message").remove();
                            $(".dashboard_section").prepend('<div onclick="this.classList.add(\'hidden\')" class="message error">Error While Uploading Image. Try Again!!.</div>');
                        }
                    });
                  }
                };

    }]);
  buzztm.directive('confirmationNeeded', function () {
  return {
    priority: 1,
    terminal: true,
    link: function (scope, element, attr) {
      var msg = attr.confirmationNeeded || "Are you sure?";
      var clickAction = attr.ngClick;
      element.bind('click',function () {
        if ( window.confirm(msg) ) {
          scope.$eval(clickAction)
        }
      });
    }
  };
});

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
                          ngModel.$setValidity('unique', data.data ? false : true);
                        })
                        .catch(function() {
                             ngModel.$setValidity('unique', false);
                        });
                   } else { 
                    userService.isUnique(value, attrs.name)
                        .then(function(data) {
                          console.log(data.data);
                          ngModel.$setValidity('unique', data.data ? false : true);
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

    this.isUnique = function(username, type) {
        if (notEmpty(username)) {
            var uri = '<?= $this->Url->build('/admin/');?>check_'+type+'/' + username;
            return $http.get(uri);
        }
        return $q.reject("Invalid User name");
    }



    this.isUniqueEmail = function(email) {
        if (notEmpty(email)) {
            var uri = '<?= $this->Url->build('/admin/');?>check_email/' + email;
            return $http.get(uri);
        }
        return $q.reject("Email already registered!!");
    }

}


</script>
	