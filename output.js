
var app = angular.module("GruntDemo",['ui.bootstrap']);
app.controller('HelloController', ['$scope','$http', function($scope,$http){	
	$scope.save = function(){
		console.log($scope.name);
	};
$scope.$watch("dt", function(newValue, oldValue) {
    console.log("I've changed : ", newValue);
    $scope.search();
});
    $scope.search = function(frm){
		var dt = new Date($scope.dt);

		 var fulldate = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();

		console.log(fulldate);
		 $http({
        method : "GET",
        url : "../search.php?date="+fulldate,
        dataType:"JSON",
        data:{date:fulldate}
    }).then(function mySucces(response) {
        console.log(response);
        if(response.data.status == 'success')
        {
        	console.log($scope.msg);
        	$scope.myWelcome = response.data;
		$scope.msg ="";
        }
        else{
        	$scope.msg = response.data.msg;
        }
    }, function myError(response) {
        $scope.myWelcome = response.statusText;
    });
	};



	 $scope.today = function() {
    $scope.dt = new Date();
  };
  $scope.today();

  $scope.clear = function() {
    $scope.dt = null;
  };

  $scope.options = {
    customClass: getDayClass,
    minDate: new Date(),
    showWeeks: true
  };

  // Disable weekend selection
  function disabled(data) {
    var date = data.date,
      mode = data.mode;
    return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
  }

  $scope.toggleMin = function() {
    $scope.options.minDate = $scope.options.minDate ? null : new Date();
  };

  $scope.toggleMin();

  $scope.setDate = function(year, month, day) {
    $scope.dt = new Date(year, month, day);
  };

  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  var afterTomorrow = new Date(tomorrow);
  afterTomorrow.setDate(tomorrow.getDate() + 1);
  $scope.events = [
    {
      date: tomorrow,
      status: 'full'
    },
    {
      date: afterTomorrow,
      status: 'partially'
    }
  ];

  function getDayClass(data) {
    var date = data.date,
      mode = data.mode;
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i = 0; i < $scope.events.length; i++) {
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  }


}]);

app.directive("hello",function(){

	return {
		scope:{
			to:"="
		},
		templateUrl:"hello.html",
		controller:"HelloController"

	};

});;app.controller("FirstController",['$scope','$http',function($scope,$http){
	$scope.title = "Welcome!";
	$scope.name = "kkkk"; 
	$scope.user = {};
	$scope.save = function(frm)
	{
		console.log(frm.$valid);
		if(frm.$valid)
		{
		console.log($scope.user);
		}
	};


	$scope.search = function(frm){

		console.log(frm);
	};
}]);