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
$sc_id = $row['id'];
if(isset($_POST['withdraw'])){
$email=$_POST['email'];
$amount=$_POST['amount'];
$query = "SELECT * FROM student WHERE email= ? limit 1";
$stmt = $db->prepare($query);
$stmt->execute(array($email));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
$s_id=$rows['id'];
$balance=$rows['balance'];
if ($amount<=$balance){
    $sql ="INSERT INTO transactions (credit, student, school) VALUES (?,?,?)";
    $stm = $db->prepare($sql);
    if ($stm->execute(array($amount,$s_id, $sc_id))) {
        $newbal=$balance-$amount;
        $sql ="UPDATE student SET balance = ? WHERE id = ?";
        $stm = $db->prepare($sql);
        if ($stm->execute(array($newbal, $s_id))) {
        print "<script>alert('Money Removed');window.location.assign('withdraw.php')</script>";
        }
    }
} else{
    echo "<script>alert('low balance, prease try again');window.location.assign('withdraw.php')</script>";
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School</title>
	<!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <?php require 'php-includes/nav.php';?>
        <div id="page-wrapper">
		  <div class="header"> 
        <h1 class="page-header">Student withdraw</h1>
        <ol class="breadcrumb">
          <li><a href="dashboard.php">Home</a></li>
          <li class="active">Student withdraw</li>
        </ol>		
		  </div>
      <div id="page-inner"> 
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter details
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form method="post">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="email" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input class="form-control" type="number" name="amount">
                                        </div>
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-success" name="withdraw"><span class="glyphicon glyphicon-check"></span> Withdraw</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
    </div>
            <div id="page-inner"> 
				 <footer><p>All right reserved.</p></footer>
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
      <!-- Custom Js -->
    <script src="../assets/js/custom-scripts.js"></script>
    
   
</body>
</html>