<div class="login-container container">
    <div class="panel panel-default col-md-4 col-md-offset-4" style="width:30%">
        <div class="panel-body">
            <form method="get" action="/AnswerDetailsapi/FromCode">
                <h3>请输入学号和考试码进入考试：</h3>
                <br>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">学号</span>
                    <input type="text" class="form-control" id="schoolid" name="schoolid" aria-describedby="basic-addon1">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">考试码</span>
                    <input type="text" class="form-control" id="invicode" name="invicode" aria-describedby="basic-addon1">
                </div>
                <br>
                <input type="submit" class="btn" style="float:right" value="提交" />
            </form>
        </div>
    </div>
</div>