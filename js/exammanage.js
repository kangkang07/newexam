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
            //$scope.$apply();
        });
        //$scope.$apply();
    });

    var dtpstart = $("#examstart").datetimepicker();
    var dtpend = $("#examend").datetimepicker();


    $scope.refreshdata = function () {
        $http.get("/Examapi/GetAll").then(function (response) {
            $scope.itemlist = response.data;
            for(i in $scope.itemlist)
            {
                for(j in $scope.itemlist[i].chapters)
                {
                    $scope.itemlist[i].chapters[j] = $scope.itemlist[i].chapters[j].toString();
                }
            }
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
        //for (i in $scope.chapterlist) {
        //    $scope.chapterlist[i].selected = false;
        //}
        //for (j in $scope.chapterlist) {
        //    for (i in e.chapters) {
        //        if (e.chapters[i].chapter == $scope.chapterlist[j].idchapter)
        //            $scope.chapterlist[j].selected = true;
        //    }

        //}
        //$scope.chapterlist=$scope.chapterlist;
        $scope.cexam= angular.copy(e);
        //$scope.cexam = e;
        $timeout(function(){
           $('#chapterselect').multiselect('refresh');
        });
        //$('#chapterselect').multiselect('refresh');
    };

    var makemodel = function () {
        return {
            examstart: $scope.cexam.examstart,
            examend: $scope.cexam.examend,
            duration: $scope.cexam.duration,
            examname: $scope.cexam.examname,
            enabled: $scope.cexam.enabled,
            chapters: $scope.cexam.chapters,
            nselnum: $scope.cexam.nselnum,
            nchknum: $scope.cexam.nchknum,
            sselnum: $scope.cexam.sselnum,
            schknum: $scope.cexam.schknum,
            nselscore: $scope.cexam.nselscore,
            nchkscore: $scope.cexam.nchkscore,
            sselscore: $scope.cexam.sselscore,
            schkscore: $scope.cexam.schkscore,

        }
    }
    $scope.saveexam = function () {


        if ($scope.cexam.idexam != undefined)
            $.post(
                "/Examapi/UpdateExam", {
                    id: $scope.cexam.idexam,
                    data: makemodel()
                },
                function (data) {
                    //window.location=window.location;
                    $scope.refreshdata();
                    alert("保存成功！");
                },"json"
            );
        else
            $.post(
                "/Examapi/CreateExam", {
                    data: makemodel()
                },
                function (data) {
                    //window.location=window.location;
                    $scope.refreshdata();
					$scope.cexam.idexam=data["idexam"];
                    alert("保存成功！");
                },"json"
            );
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

    $scope.viewexamusers = function () {
        window.open("/Answersheetapi/ExamUsers/" + $scope.cexam.idexam);
    }
	$scope.deleteexam=function(){
		if(confirm("确定要删除该考试吗？"))
		$.get("/Examapi/DeleteByID/"+$scope.cexam.idexam,function(){
			window.location=window.location;
		});
	}

});

