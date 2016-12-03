<div class="panel panel-default">
    <div class="panel-heading">
        <h3>考试结果</h3>
    </div>
    <div class="panel-body">
        <table class="table">
            <tr>
                <td>考试名：</td>
                <td><? echo $answersheet->examname;?></td>
            </tr>
            <tr>
                <td>开始时间：</td>
                <td><? echo $answersheet->answerstart;?></td>
            </tr>
            <tr>
                <td>结束时间：</td>
                <td><? echo $answersheet->answerend;?></td>
            </tr>

            <tr>
                <td>总分：</td>
                <td><? echo $answersheet->finalscore;?></td>
            </tr>
        </table>
    </div>
    
</div>

<?php
$i=1;
    foreach ($details as $q): ?>
<div class="panel panel-default">
    <div class="panel-body">
        <? echo $i++;?>. 
        <?php echo $q->maintext; ?>

        <hr />
        <?php if($q->type==1){?>
        <div>
            选项1：<?php echo $q->o1; ?>
        </div>
        <div>
            选项2：<?php echo $q->o2; ?>
        </div>
        <div>
            选项3：<?php echo $q->o3; ?>
        </div>
        <div>
            选项4：<?php echo $q->o4; ?>
        </div>
        <?php } ?>

    </div>
    <div class="panel-heading">
        
        
        <div>
            正确答案：<?php
          if($q->answer=="r")
              echo "正确";
          else if($q->answer=="w")
              echo "正确";
					else
                        echo $q->answer; ?>
        </div>
        <div>
            用户答案：<?php
          if($q->myanswer=="r")
              echo "正确";
          else if($q->myanswer=="w")
              echo "正确";
          else
              echo $q->myanswer; ?>
        </div>
        <div>
            分数：<?php echo $q->result; ?>
        </div>
    </div>
</div>
<?php endforeach;?>
