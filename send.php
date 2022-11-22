<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
require 'php-includes/connect.php';
?>
<!DOCTYPE html>
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student card</title>
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<h1 class="page-header">Smart student card system</h1>
    <div>
		
            <div id="page-inner"> 
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form id="login-form" class="form" action="login.php" method="post">
                                        <div class="form-group">
                                            <label>Student ID:</label>
                                            <input name="sid" class="form-control" placeholder="Enter ID" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Your name:</label>
                                            <input name="name" class="form-control" placeholder="Enter names" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Amount:</label>
                                            <input name="amount" class="form-control" placeholder="Enter amount" type="number">
                                        </div>
                                        <div class="form-group">
                                            <label>MOMO number:</label>
                                            <input name="number" class="form-control" placeholder="Enter phone number" type="email">
                                        </div>
                                        <div class="form-group">
                                        <input type="submit" name="submit" class="btn btn-danger" value="Send money">
                                        </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>