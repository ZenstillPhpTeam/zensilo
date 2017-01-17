<div ng-cloak ng-controller="StickyController" class="sticky_notes hide">
	<div ng-repeat="list in sticky_data track by $index" data-index="{{$index}}" on-finish-render class="notes_list" ng-style="{left:list.left, top:list.top}">
		<div class="notes_header" ng-style="{width:list.width}">
			<i ng-click="add_notes($index)" class="glyph-icon icon-plus"></i>
			<i ng-click="delete_notes($index)" class="glyph-icon icon-trash"></i>
		</div>
		<textarea ng-keyup="update()" class="notes_content" ng-mouseup="resize($index, $event);" ng-mousedown="resize($index, $event);" ng-style="{width:list.width, height:list.height}" ng-model="list['content']"></textarea>
	</div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	var sticky_data_fb = new Firebase('https://vinogautam.firebaseio.com/zensilo/sticky_data/<?= $loggedInUser['id']; ?>/');
	console.log(sticky_data_fb);

	angular_module.controller('StickyController', function($scope, OTSession, $http) {

		$("#stickynotes").click(function(){
			$(".sticky_notes").toggleClass("hide");
		});

		$scope.sticky_data = [];

		sticky_data_fb.on('value', function(snapshot, b, c, d) {
          	$scope.$apply(function(){
	    		if(snapshot.hasChildren())
	    			$scope.sticky_data = snapshot.val().data;
	    		else
	    		{	
	    			$scope.sticky_data[0] = {title:"", content:"", left:'50%', top:'15%', width:150, height:150};
	    			$scope.update();
	    		}
	    	});
      	});

		$scope.resize = function(i, e){
			$scope.sticky_data[i]['width'] = $(e.target).width() > 150 ? $(e.target).width() : 150;

			$scope.sticky_data[i]['height'] = $(e.target).height() > 150 ? $(e.target).height() : 150;

			$scope.update();
		};

		$scope.add_notes = function(i){
			$new_data = angular.copy($scope.sticky_data[i]);
			$new_data.title = "";
			$new_data.content = "";
			$new_data.left = (parseFloat($new_data.left) + 5 ) + "%";
			$new_data.top = (parseFloat($new_data.top) + 5 ) + "%";

			$scope.sticky_data.push($new_data);
			$scope.update();
		};

		$scope.update = function(){
			sticky_data_fb.update({data: $scope.sticky_data, ts:new Date().getTime()});
		};

		$scope.delete_notes = function(i){
			$scope.sticky_data.splice(i, 1);
			$scope.update();
		};
	})
	.directive('onFinishRender',['$timeout', '$parse', function ($timeout, $parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                    	$(".notes_list").draggable({
                    		stop: function( event, ui ) {
                    			ind = $(this).data("index");
                    			ttop = (ui.position.top / $(window).height()) * 100;
                    			lleft = (ui.position.left / $(window).width()) * 100;
                    			scope.$apply(function(){
                    				scope.sticky_data[ind]['top'] = ttop + "%";
                    				scope.sticky_data[ind]['left'] = lleft + "%";
                    				scope.update();
                    			});
                    		}
                    	});
                    });
                }
            }
        }
    }]);
</script>