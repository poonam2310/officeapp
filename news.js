app.controller("newsCtrl",['$scope','$http',function($scope,$http){
	$scope.newsObj={};
	$scope.news=[];
	$scope.save =function(frm){

		var obj = {};
		$http({
                    url:"http://localhost/demoyii/web/index.php?r=newsapi/create",
                    method:"post",
                    data.title:$scope.newsObj
                }).then(function(res){

                   $scope.msg= "successfully register; ";
                    console.log(res);
                    frm.$prestine = true;   
                });
		};
	$scope.show=function(){
		$http({
           	 url:"http://localhost/demoyii/web/index.php?r=newsapi",
         }).then(function(res){
				 $scope.msg= "successfully register; ";  
                  $scope.news = res.data;
                });
		}();
	$scope.deleteNews = function(id){
		console.log(id);
				$http({
					method:'post',
                    url:"http://localhost/demoyii/web/index.php?r=newsapi/delete",
                    params:{id:id}
                	}).then(function(res){
                    console.log(res); 
                }); 
		};
	$scope.updateNews=function(){
		
	};

	
}]);