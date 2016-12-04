<link href="/datatables/dataTables.bootstrap.min.css" rel="stylesheet" />
<script src="/datatables/jquery.dataTables.js"></script>

<link href="/datatables/jquery.dataTables.min.css" rel="stylesheet" />


<span>年级</span>
<select id="grade" onchange="datarefresh()">
    <option></option>
    <?php foreach ($grades as $grade): ?>
    <option><?php echo $grade->grade; ?></option>
    <?php endforeach; ?>
</select>
<span>班级</span>
<select id="class" onchange="datarefresh()">
    <option></option>
    <?php foreach ($classes as $class): ?>
        <option><?php echo $class->class; ?></option>
    <?php endforeach; ?>

</select>

<button class="btn btn-default" onclick="importmodal()">导入考生</button>
<!--<button class="btn btn-default" onclick="exporttable()" >导出列表</button>-->


<div class="panel panel-default">
    <div class="panel-body">
        <table id="tables" class="cell-border">

        </table>
    </div>
</div>
<div class="modal fade" id="importmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">导入考生</h4>
            </div>
            <div class="modal-body">
                <h5>
                    <b>请确保导入的文件使用以下模板：</b>
                </h5>
                <a href="/导入考生模板.xlsx">点击下载导入考生模板</a>
                <h5><b>模板填入填入数据后，选择上传，点击‘导入’</b></h5>
                <form action="/UseAPI/ImportUser" method="post" id="importform" enctype="multipart/form-data" accept-charset="utf-8">
                    <input type="file" name="usersheet" />

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('importform').submit()">导入</button>
            </div>
        </div>
    </div>
</div>
<script>

    var usertable;
    $(function () {
        usertable=$("#tables").DataTable({
            serverSide: true,
            "ordering":false,
            ajax:{
                "url":"/UserAPI/Edit",
                "method":"POST",
                "data":function(d){
                    d.grade=$("#grade").val();
                    d.class=$("#class").val();
                }
            },
            columns:[
                {data:"iduser"},
                {data:"schoolid",title:"学号"},
                {data:"name",title:"姓名"},
                {data:"grade",title:"年级"},
                {data:"class",title:"班级"},
                {title:"操作"}
            ],
            columnDefs:[
                {
                    "visible":false,
                    "targets": [0]
                },
                {
                    "render":function(data, type,row){
                        return "<a onclick='deleteuser("+row.iduser+")'>删除</a>"
                    },
                    "targets":5
                }
            ],
            language: {
                "sProcessing": "处理中...",
                "sLengthMenu": "显示 _MENU_ 项结果",
                "sZeroRecords": "没有匹配结果",
                "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix": "",
                "sSearch": "搜索:",
                "sUrl": "",
                "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上页",
                    "sNext": "下页",
                    "sLast": "末页"
                },
                "oAria": {
                    "sSortAscending": ": 以升序排列此列",
                    "sSortDescending": ": 以降序排列此列"
                }
            }
        });
    });


    var importmodal = function () {
        $("#importmodal").modal("show");
    };

    //TODO change it
    var exporttable = function () {

    };

    var deleteuser=function(id){
        if(confirm("确定要删除该用户吗？"))
        $.ajax({
            url:"/UserAPI/DeleteByID/"+id,
            method:"POST",
            success:function(data){
                alert("删除成功！");
                usertable.ajax.reload();
            }

        });
    }
    var datarefresh=function(){
        usertable.ajax.reload();
    }
</script>