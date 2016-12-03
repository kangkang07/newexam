<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache"> 
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-store, must-revalidate"> 
    <META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT"> 
    <META HTTP-EQUIV="expires" CONTENT="0">    
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="/style/bootstrap-datetimepicker.min.css">
    <!--    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="/style/style.css">
    <script src="/js/jquery-1.10.2.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/js/common.js"></script>
	
</head>

<body>

	<div style="height:75px"></div>

    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img class="logo" width="50px" src="/img/logo1.png">考试系统</a>
        </div>

              <ul class="nav navbar-nav navbar-right">

               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo @$_SESSION["user"]->name; ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
						
                        <li><a href="/userapi">退出</a>
                        </li>
                        
                       
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
    <div class="container" id="container">