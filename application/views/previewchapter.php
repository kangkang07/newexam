<?php foreach ($qstlist as $q):?>
<div class="panel panel-default">
<div class="panel-body">
<?php
if($q->star>0)
	 echo '★';
if($q->group!='')
	$group="[题目组".$q->group."] ";
else
	$group="";
echo  $q->refid.". ".$group.$q->maintext;

if($q->type==1){
?>



<div class="options">
<ul>
<li><b>选项1：</b>
    <div><?php echo $q->o1; ?></div></li>
    <li><b>选项2：</b>
        <div><?php echo $q->o2; ?></div></li>
    <li><b>选项3：</b>
        <div><?php echo $q->o3; ?></div></li>
    <li><b>选项4：</b>
        <div><?php echo $q->o4; ?></div></li>
</ul>

</div>
<?php }?>
<div class="panel-footer">
正确答案：
<?php 
if($q->answer=='r')
	echo "选项1";
if($q->answer=='w')
	echo "选项2";
if($q->answer=='1')
	echo "选项1";
if($q->answer=='2')
	echo "选项2";
if($q->answer=='3')
	echo "选项3";
if($q->answer=='4')
	echo "选项4";
?>
</div>
</div>
</div>

<?php endforeach; ?>

