var app = angular.module('myexam', []);
app.controller('default', function($scope,$http,$sce) {
	 $scope.refreshdata=function(){
      	$http.get("/Examapi/GetAll").then(function(response){
			$scope.itemlist= response.data;
		});
      };
      $scope.refreshdata();
      $scope.examclick=function(e){
      	$scope.gotfocus(e);
      	$scope.cexam=e;
      	var now=new Date();
      	var examendtime=new Date($scope.cexam.examend);
      	if(now>examendtime)
      	{
      		$scope.btnaction="考试已结束"
      		$scope.btndisabled=true;
      	}
      	else{
      		$scope.btndisabled=false;
      		$scope.btnaction="开始答题";
      	}

      }
      $scope.btnclick=function(){
      	if($scope.btnaction=="开始答题")
      	{
      		window.location="/AnswerDetailsapi/answertime/"+$scope.cexam.idexam;
      	}
      }
       $scope.gotfocus=function(a){
	    	for(i in $scope.itemlist)
	    		{
	    		$scope.itemlist[i].isfocus=undefined;
	    		}
	    	a.isfocus="active";
	    };

});