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
    <title>RFID Canteen MS</title>
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
<h1 class="page-header">RFID Canteen MS</h1>
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
                                    <label>Email</label>
                                    <input name="email" class="form-control" placeholder="Enter email" type="email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input name="password" class="form-control" placeholder="Enter password" type="password">
                                </div>
                                <a href="forget.php" >Forget password</a>
                                <br><br>
                                <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                                </div>
                                <a href="send.php" class="btn btn-danger">Send money</a>
                            </form>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                    <form id="login-form" class="form" action="order.php" method="post">
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Milk: 400 Rwf/L</label>
                                    <input name="p1" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Cream: 1000 Rwf/1</label>
                                    <input name="p2" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Butter: 500 Rwf/1</label>
                                    <input name="p3" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                </div>
                        </div>
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Chees: 250 Rwf/1</label>
                                    <input name="p4" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Yogurt: 800 Rwf/1</label>
                                    <input name="p5" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Baguette: 2500 Rwf/1</label>
                                    <input name="p6" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                        </div>
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Bread: 1200 Rwf/1</label>
                                    <input name="p7" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Mango Juice: 250 Rwf/1</label>
                                    <input name="p8" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Apple Juices: 250 Rwf/1</label>
                                    <input name="p9" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                        </div>
                        <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Fresh Fruit Juice: 2000 Rwf/1</label>
                                    <input name="p10" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Lemon: 100 Rwf/1</label>
                                    <input name="p11" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <div class="form-group">
                                    <label>Banana: 50 Rwf/1</label>
                                    <input name="p12" class="form-control" placeholder="Enter amount" type="number">
                                </div>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="order">
                        </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    </form>
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