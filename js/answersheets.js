var app = angular.module('exams', []);
app.controller('default', function ($scope, $http, $sce, $timeout) {


    $http.get("/Chapterapi/GetAll").then(function (response) {
        $scope.chapterlist = response.data;
//        for (i in $scope.chapterlist) {
//            $scope.chapterlist[i].selected = false;
//        }

        $timeout(function () {
            $scope.$apply();
            $('#chapterselect').multiselect({
                includeSelectAllOption: true,
                	selectAllText:"全选",
                 numberDisplayed: 100,
                delimiterText: '<br>',
                enableHTML:true,
                nonSelectedText: ''
       
            });
            $('#chapterselect').multiselect('disable')
            //$scope.$apply();
        });
        //$scope.$apply();
    });

    var dtpstart = $("#examstart").datetimepicker();
    var dtpend = $("#examend").datetimepicker();


    $scope.refreshdata = function () {
        $http.get("/Examapi/GetAll").then(function (response) {
            $scope.itemlist = response.data;
        });
    };
    $scope.refreshdata();
    $scope.gotfocus = function (a) {
        for (i in $scope.itemlist) {
            $scope.itemlist[i].isfocus = undefined;
        }
        a.isfocus = "active";
    };
    $scope.examclick = function (e) {
        $scope.gotfocus(e);

        //$scope.exampaper=$scope.findpaperbyid(e.paper);
//        for (i in $scope.chapterlist) {
//            $scope.chapterlist[i].selected = false;
//        }
//        for (j in $scope.chapterlist) {
//            for (i in e.chapters) {
//                if (e.chapters[i].chapter == $scope.chapterlist[j].idchapter)
//                    $scope.chapterlist[j].selected = true;
//            }
//
//        }
        //$scope.chapterlist=$scope.chapterlist;
        $scope.cexam= angular.copy(e);
        //$scope.cexam = e;
        $timeout(function(){
            $('#chapterselect').multiselect('refresh');
        });
        //$('#chapterselect').multiselect('refresh');
    };
    $scope.enterexam = function () {
        window.open("/answerdetailsapi/answertime/"+$scope.cexam.idexam);
    };
    //	 $scope.findpaperbyid=function(id)
    //	 {
    //	 	for(i in $scope.paperlist)
    //	 	{
    //	 		if($scope.paperlist[i].idpaper==id)
    //	 			return $scope.paperlist[i];
    //	 	}
    //	 	return null;
    //	 };
    $scope.newexam = function () {
        $scope.cexam = {
            examname: "",
            examstart: "",
            examend: "",
            duration: "",
            enabled: 1,
            paper: 0
        }
        $scope.exampaper = undefined;
        for (i in $scope.itemlist) {
            $scope.itemlist[i].isfocus = undefined;
        }
        for (i in $scope.chapterlist) {
            $scope.chapterlist[i].selected = false;
        }
    };
    //    $timeout(function(){
    //        $('#chapterselect').multiselect({
    //            includeSelectAllOption: true
    //        });
    //        $scope.$apply();
    //    });
    //    $timeout(function(){
    //        $('#chapterselect').multiselect('refresh');
    //        //$scope.$apply();
    //    });

});