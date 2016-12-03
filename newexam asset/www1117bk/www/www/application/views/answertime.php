<script src="/js/angular.js" ></script>
<script src="/js/answertime.js"></script>
<script>
var asid=<?php echo $asid;?>;

</script>
<div ng-app="answertime" ng-controller="default">

<div class="col-md-9">
   
<div ng-repeat="q in qstlist" class="panel" ng-show="q.index==cindex">
    <h2><span class="label label-info">{{(q.index)}}.</span>  </h2>
<div class="panel-heading" data-ng-bind-html="q.maintext">
</div>
<div class="panel-body">
<div ng-show="q.type==1">
    <div class="panel panel-default" style="padding:5px" ng-repeat="o in q.randoptions">
<span ng-show="q.o1!=''">{{abcd[$index]}}</span><div data-ng-bind-html="o.op"></div></div>
<!--
    <div class="panel panel-default" style="padding:5px">
<span ng-show="q.o1!=''">A:</span><div data-ng-bind-html="q.o1"></div></div>
    <div class="panel panel-default" style="padding:5px">
<span ng-show="q.o2!=''">B:</span><div data-ng-bind-html="q.o2"></div></div>
    <div class="panel panel-default" style="padding:5px">
<span ng-show="q.o3!=''">C:</span><div data-ng-bind-html="q.o3"></div></div>
    <div class="panel panel-default" style="padding:5px">
<span ng-show="q.o4!=''">D:</span><div data-ng-bind-html="q.o4"></div></div>
-->


	</div>
    <hr>
	<div class="form-inline">
		答案：
        
		<select class="form-control" style="width:200px" ng-show="q.type==1" ng-model="q.myanswer" ng-change="answer(q)" ng-disabled="lockbutton">
			<option ng-show="q.type==1" value="1">A</option>
			<option ng-show="q.type==1" value="2">B</option>
			<option ng-show="q.type==1" value="3">C</option>
			<option ng-show="q.type==1" value="4">D</option>
			

		</select>
		<select class="form-control" style="width:200px" ng-show="q.type==2"  ng-model="q.myanswer" ng-change="answer(q)" ng-disabled="lockbutton">
			<option ng-show="q.type==2" value="r">正确</option>
			<option ng-show="q.type==2" value="w">错误</option>
		</select>	
        <button class="btn" ng-click="mark(q)" ng-disabled="lockbutton">做标记</button>
        <span class="label label-danger" ng-show="q.flag==1">标记</span>
	</div>


	</div>

</div>

</div>

<div class="col-md-3">
<div class="panel">
<div class="h3">


</div>
<div class="h2">{{lefthour}}:{{leftmin}}:{{leftsec}}</div>
<button class="btn" ng-click="endexam()" ng-disabled="lockbutton">结束考试</button>
    <hr>
    <button class="btn" ng-click="preq()" ng-disabled="cindex=='1'||lockbutton">上一题</button>
<button class="btn" ng-click="nextq()" ng-disabled="cindex==qstcount||lockbutton">下一题</button>
<br>
    <ul class="list-group" style="max-height:600px;overflow-y:scroll">
    <li class="list-group-item qstlist-item" ng-repeat="q in qstlist" ng-click="chooseq(q.index)">
        <span class="label label-default" ng-show="q.myanswer==null">未答</span>
        <span class="label label-success" ng-show="q.myanswer!=null">已答</span>
        <span class="label label-danger" ng-show="q.flag==1">标记</span>
        
        {{q.index}}. {{q.title}}</li>
    </ul>
</div>
</div>

</div>
<style>
    .qstlist-item{
        cursor: pointer;
        font-size: 10pt;
        outline-width: thin;
    }
</style>