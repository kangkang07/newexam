var app = angular.module('answertime', []);
app.controller('default', function($scope,$http,$sce,$interval) {

	// $scope.answerstart=new Date();
	// $scope.examstart=new Date($scope.examstart);
	// $scope.examend=new Date($scope.examend);
	// $scope.duration=parseInt($scope.duration)*1000;
	


	// if($scope.answerstart-$scope.examend<$scope.duration)
	// {
	// 	$scope.duration=$scope.answerstart-$scope.examend;
	// }
	//$scope.countdown.setSeconds(parseInt($scope.duration/1000));
	
	
    $scope.abcd=['A','B','C','D'];
    var omap=new Array();
    omap[1]=1234
    $http.get("/AnswerDetailsapi/getmysheet/" + asid).then(function (response) {
        
         angular.forEach(response.data,function(q,i)
                {
                    q.index=parseInt(i)+1;
                    q.maintext=$sce.trustAsHtml(q.maintext);
                    //乱序排列选项
                    var ro=new Array(4);
                    ro[0]={op:$sce.trustAsHtml(q.o1),ind:1};
                    ro[1]={op:$sce.trustAsHtml(q.o2),ind:2};
                    ro[2]={op:$sce.trustAsHtml(q.o3),ind:3};
                    ro[3]={op:$sce.trustAsHtml(q.o4),ind:4};
                    ro.sort(function(){return 0.5-Math.random()});
                    q.randoptions=ro;
                    
                });
        $scope.qstcount=response.data.length;
		$scope.qstlist= response.data;
            
        //倒计时
		var starttime = new Date(response.data[0].answerstart);
		var now = new Date();
		var duration = parseInt(response.data[0].duration);
		var endtime = new Date(starttime.setMinutes(starttime.getMinutes() + duration));
		//var leftseconds = endtime - now;
		$scope.countdown = new Date();
		$scope.countdown.setHours(0);
		$scope.countdown.setMinutes(0);
		$scope.countdown.setSeconds(0);
		$scope.countdown.setMilliseconds(endtime - now);
		$interval(function(){
		    $scope.countdown.setSeconds($scope.countdown.getSeconds() - 1);
		    $scope.lefthour = $scope.countdown.getHours();
			$scope.leftmin=$scope.countdown.getMinutes();
			$scope.leftsec=$scope.countdown.getSeconds();
			if($scope.leftsec==0 && $scope.leftmin==0)
			{
				$scope.endexam();
			}
		},1000);
	});
    $scope.cindex=1;
	
    $scope.preq=function(){
        $scope.cindex--;
    };
    $scope.nextq=function(){
        $scope.cindex++;
    };
    $scope.chooseq=function(id){
        $scope.cindex=id;  
    };
    $scope.mark = function (q) {
        q.flag = 1 - q.flag;
        $scope.answer(q);
    };
    $scope.lockbutton = false;
	 $scope.answer=function(q)
	 {
	     $scope.lockbutton = true;
	 	$.ajax({
	 		url:"/AnswerDetailsapi/answer",
	 		data:{
	 			id:q.idpaperquestion,
	 		    myanswer:q.myanswer,
                flag:q.flag
	 		},
	 		success: function () {
	 		    $scope.lockbutton = false;
	 		}
	 	});
	 }
	 $scope.endexam=function()
	 {
	     window.location = "/AnswerDetailsapi/EndExam/" + asid;
	 }
	 $scope.gotfocus=function(a){
	    	for(i in $scope.itemlist)
	    		{
	    		$scope.itemlist[i].isfocus=undefined;
	    		}
	    	a.isfocus="active";
	    };
}
);
