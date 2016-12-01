angular_module.controller('TimesheetCtrl', function($scope,$http,$location,$rootScope,$filter) {

	var siteUrl = $site_url;

	$scope.TimeSheetData = [];

  $scope.SelectMonth = 'Select month';
  $scope.SelectWeek = 'Select week';
  $scope.nextTSWeekId = 0;

	$http.get(siteUrl+'timesheet/getData').then(function (res) {

		$scope.TimeSheetData = res.data; 

  });

	$scope.add_new_row = function(){

		var hrs = {};
		angular.forEach($scope.TimeSheetData.dates, function(dates , val) {
			hrs[dates] = '';
		});
		var newrow = {'project':0,'task':0,'project_name':'Select Project','task_name':'Select Task','days_hrs':hrs};
		$scope.TimeSheetData.days.push(newrow);
	}

	$scope.remove_row = function(key){

		if($scope.TimeSheetData.days.length > 1 ) $scope.TimeSheetData.days.splice(key, 1);    
	}

  $scope.save_timeSheet = function(data,status){

    var data = {'status': status,'data':data};
    $http.post(siteUrl+'timesheet/add',data).then(function (res) {

      //console.log(res);
          
    });
  }

  $scope.change_timeSheet_month = function(data){

    $scope.SelectMonth = $filter('date')(data.start_date, "MMM yyyy");
  }

  $scope.change_timeSheet_week = function(data){

    $scope.SelectWeek = $filter('date')(data.start_date, "EEE d") +' - '+ $filter('date')(data.end_date, "EEE d");
    $scope.nextTSWeekId = data.id;

  }

  $scope.is_already_taken = function(id , action,rkey){
    var res = true;
    angular.forEach($scope.TimeSheetData.days, function(val , key){
      if(val[action] == id && rkey != key) res = false;
    });
    return res;
  }

  $scope.change_timeSheet_range = function(id){

    $http.get(siteUrl+'timesheet/getData/'+id).then(function (res) {

      $scope.TimeSheetData = res.data; 
      $scope.SelectMonth = 'Select month';
      $scope.SelectWeek = 'Select week';
      $scope.nextTSWeekId = 0;

    });

  }


});

angular_module.controller('LeaveAvailableCtrl', function($scope,$http,$location,$rootScope,$filter) {

  var siteUrl = $site_url;

  $scope.Leaves = {'users':[], 'info':[]};

  $scope.SelectUser = 'Select User';

  $http.get(siteUrl+'leaverequests/getUserLeave').then(function (res) {

    $scope.Leaves.users = res.data;
    $scope.Leaves.info = []; 

  });

  

  $scope.get_user_leaves = function(user){

    $scope.SelectUser = user.username;

    $http.get(siteUrl+'leaverequests/getUserLeave/'+user.id).then(function (res) {

      $scope.Leaves.info = res.data; 

    });

  }


});