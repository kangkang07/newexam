<link href="../../datatables/dataTables.bootstrap.min.css" rel="stylesheet" />
<script src="../../datatables/jquery.dataTables.js"></script>
<link href="../../datatables/datatables.min.css" rel="stylesheet" />
<link href="../../datatables/jquery.dataTables.min.css" rel="stylesheet" />
<h3><?php 
    echo $exam->examname;
    ?></h3>
<div class="panel panel-default">
    <div class="panel-body">
        <table id="tables" class="cell-border">
            <thead>
                <tr>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>考试状态</th>
                    <th>考试成绩</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sheets as $st): ?>
                <tr>
                    <td>
                        <?php echo $st->schoolid; ?>
                    </td>
                    <td>
                        <?php echo $st->name; ?>
                    </td>
                    <td>
                        <?php echo $st->answerstart; ?>
                    </td>
                    <td>
                        <?php echo $st->answerend; ?>
                    </td>
                    <td>
                        <?php
                    if($st->answerstart!=null&&$st->answerend==null)
                        echo "进行中";
                    else
                        echo "已结束";
                        ?>
                    </td>
                    <td>
                        <?php echo $st->finalscore; ?>
                    </td>
                    <td>
                        <a href="/AnswerDetailsapi/viewdetails/<?php echo $st->idanswersheet; ?>" target="_blank">查看答题情况</a>

                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>

    $(function () {
        $("#tables").DataTable({
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
</script>