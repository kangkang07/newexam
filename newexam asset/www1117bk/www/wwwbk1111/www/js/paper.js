var app = angular.module('paper', []);
app.controller('default', function($scope,$http,$sce) {
 
    $http.get("/Paperapi/GetAll").then(function(response){
		$scope.paperlist= response.data;
	});
    $http.get("/Chapterapi/GetAll").then(function(response){
        $scope.chaplist=response.data;
    });
    $scope.gotfocus=function(a){
    	for(i in $scope.paperlist)
    		{
    		$scope.paperlist[i].isfocus=undefined;
    		}
    	a.isfocus="active";
    };
    $scope.chapchoose=function(c)
    {
        for(i in $scope.chaplist)
        {
            if($scope.chaplist[i].idchapter==c.idchapter)
            {
                if($scope.chaplist[i].isactive=="active")
                    $scope.chaplist[i].isactive="";
                else
                    $scope.chaplist[i].isactive="active";
            }
        }
    };
    $scope.paperclick=function(a){
    	$scope.gotfocus(a);
    	$scope.getpaper(a);
    };
    $scope.chooseall=false;
    $scope.chooseallchap=function(){
        for(i in $scope.chaplist)
        {
            if(!$scope.chooseall)
             $scope.chaplist[i].isactive="active";
         else
            $scope.chaplist[i].isactive="";
        }
        $scope.chooseall=!$scope.chooseall;
    };
    $scope.getpaper=function(a)
    {
    	$http.get("/PaperDetailsapi/GetPaper/"+a.idpaper).then(function(response){
    		//response.content=$sce.trustAsHtml(response.data);
    		$scope.questionlist=response.data;
    		angular.forEach($scope.questionlist,function(data){
    			data.maintext=$sce.trustAsHtml(data.maintext);
    			data.o1=$sce.trustAsHtml(data.o1);
    			data.o2=$sce.trustAsHtml(data.o2);
    			data.o3=$sce.trustAsHtml(data.o3);
    			data.o4=$sce.trustAsHtml(data.o4);
    		});
    		
    	});
    };
    $scope.generatepaper=function(){
        var chaps=[];
        var papername=$scope.papername;
        for(i in $scope.chaplist)
        {
            if($scope.chaplist[i].isactive=="active")
                chaps.push($scope.chaplist[i].idchapter)
        }
        $.post('/Paperapi/GeneratePaper',
            {
                "pname":papername,
                "chaps":chaps
            },
            function(data){
                console.log(data);
            window.location=window.location;
            }
            );
        // $http({
        //     method:'post',
        //     url:'/Paperapi/GeneratePaper',
        //     data:{
        //         "pname":papername,
        //         "chaps":chaps
        //     }

        // }).success(function(resp){
        //     console.log(resp);
        //     window.location=window.location;
        // })
    }

    $scope.deletepaper=function(p)
    {
        event.stopPropagation();
        if(confirm("确定要删除吗？"))
        {
            $.get("/Paperapi/DeletePaper/"+p.idpaper,function(data){
                window.location=window.location;
            });
        }
    }

});
app.service('getpapers',function($http){
	this.myFunc=function(){
		$http.get("/Paperapi/GetAll").then(function(data){
			return data;
		});
	};
});

