	
	<div class="h3"><?php echo $paper->papername;?></div>
	<?php foreach ($qstlist as $q): ?>
	<div class="panel panel-default" >
        <div class="panel-body">
            <?php echo $q->maintext; ?>

            <hr />
            <?php if($q->type==1){?>
            <div>
                <div>选项1：<?php echo $q->o1; ?></div>
            </div>
            <div>
                选项2：
                <div>
                <?php echo $q->o2; ?>
                </div>
            </div>
            <div>
                <div>选项1：<?php echo $q->o3; ?></div>
            </div>
            <div>
                <div>选项1：<?php echo $q->o4; ?></div>
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
           
        </div>
		</div>
		<?php endforeach;?>
<?php
?>