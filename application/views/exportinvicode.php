
        <table id="tables" class="cell-border">
            <thead>
                <tr>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>考试编号</th>
                    <th>开始时间</th>
                    <th>结束时间</th>

                    <th>考试状态</th>
                    <th>考试成绩</th>
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
                        <?php echo $st->idexam; ?>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
   
