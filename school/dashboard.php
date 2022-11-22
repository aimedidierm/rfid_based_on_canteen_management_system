<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
require '../php-includes/connect.php';
require 'php-includes/check-login.php';
$sql = "SELECT * FROM school WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute(array($_SESSION['code']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$myid = $row['id'];
$sql = "SELECT * FROM transactions WHERE school = ?";
$stmt = $db->prepare($sql);
$stmt->execute(array($myid));
$trnumb=$stmt->rowCount();
$sql = "SELECT * FROM student";
$stmt = $db->prepare($sql);
$stmt->execute();
$users=$stmt->rowCount();
$sql = "SELECT * FROM seller";
$stmt = $db->prepare($sql);
$stmt->execute();
$sellers=$stmt->rowCount();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School dashboard</title>
    <!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="../assets/js/Lightweight-Chart/cssCharts.css"> 
</head>

<body>
<div id="wrapper">
        <?php require 'php-includes/nav.php';?>
        <div id="page-wrapper">
		  <div class="header"> 
        <h1 class="page-header">Dashboard</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
          </ol>
			<h1>						
		</div>
            <div id="page-inner">

                <!-- /. ROW  -->
	
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-left pull-left blue">
                                <i class="fa fa-money fa-5x"></i>
                                
                            </div>
                            <div class="panel-right">
								<h3><?php echo $trnumb;?></h3>
                               <strong> Transactions</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                              <div class="panel-left pull-left blue">
                                <i class="fa fa-users fa-5x"></i>
								</div>
                                
                            <div class="panel-right">
							<h3><?php echo $users;?></h3>
                               <strong> Total students</strong>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-left pull-left blue">
                                <i class="fa fa fa-shopping-cart fa-5x"></i>
                               
                            </div>
                            <div class="panel-right">
							 <h3><?php echo $trnumb;?></h3>
                               <strong> Total sales</strong>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder blue">
                            <div class="panel-left pull-left blue">
                            <i class="fa fa-users fa-5x"></i>
                                
                            </div>
                            <div class="panel-right">
							<h3><?php echo $sellers;?></h3>
                             <strong>Total sellers</strong>

                            </div>
                        </div>
                    </div>
                </div>	
				</div> 
                     
                </div>
				<footer><p>All right reserved.</p>
				
        
				</footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="../assets/js/bootstrap.min.js"></script>
	 
    <!-- Metis Menu Js -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="../assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="../assets/js/morris/morris.js"></script>
	
	
	<script src="../assets/js/easypiechart.js"></script>
	<script src="../assets/js/easypiechart-data.js"></script>
	
	 <script src="../assets/js/Lightweight-Chart/jquery.chart.js"></script>
	
    <!-- Custom Js -->
    <script src="../assets/js/custom-scripts.js"></script>

      <script>
    
      </script>

</body>

</html>