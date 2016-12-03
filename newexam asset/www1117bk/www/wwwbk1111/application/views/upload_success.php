<html>
<head>
<title>Upload Form</title>
<meta charset="UTF-8">
</head>
<body>

<<<<<<< HEAD
<h3>Your file was successfully uploaded!</h3>
=======

>>>>>>> 9008a53e3e18369669a756c546ab4e69de9222fa
<!-- 
<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>
-->
<?php foreach ($questions as $q):?>
<div>
<?php echo $q["text"]; ?>
<ul>
<li><?php echo $q["a"]; ?></li>
<li><?php echo $q["b"]; ?></li>
<li><?php echo $q["c"]; ?></li>
<li><?php echo $q["d"]; ?></li>
</ul>
答案：<?php echo $q["as"]; ?>
</div>

<?php endforeach; ?>

<p><?php //echo anchor('upload', 'Upload Another File!'); ?></p>

</body>
</html>