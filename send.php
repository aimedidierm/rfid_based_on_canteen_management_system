<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
require 'php-includes/connect.php';
function getToken() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL . '/auth/agents/authorize',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{"client_id": "437b2c04-82cc-11ed-9bef-dead986dd4f7","client_secret": "bff4ad8c4de23242b46a306e9293989ada39a3ee5e6b4b0d3255bfef95601890afd80709"}',
      CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    ));
  
    $response = curl_exec($curl);
  
    curl_close($curl);
  
    return json_decode($response)->access;
}
if(isset($_POST['pay'])){
    $card=$_POST['sid'];
    $number=$_POST['number'];
    $amount=$_POST['amount'];
    $query = "SELECT * FROM student WHERE card= ? limit 1";
    $stmt = $db->prepare($query);
    $stmt->execute(array($card));
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount()>0) {
        //some codes here
        $myid=$rows['id'];
        $balance=$rows['balance'];
        $req = '{"amount":'.$amount.',"number":"'.$number.'"}';
    define('BASE_URL', 'https://payments.paypack.rw/api');
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => BASE_URL . '/transactions/cashin?Idempotency-Key=OldbBsHAwAdcYalKLXuiMcqRrdEcDGRv',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $req,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . getToken(),
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    //echo $response;
    //Insert data in database
    $newbalance=$balance+$amount;
    $sql ="UPDATE student SET balance = ? WHERE id = ? limit 1";
    $stm = $db->prepare($sql);
    if ($stm->execute(array($newbalance,$myid))) {
        //continue
        $sql ="INSERT INTO transactions (debit,student) VALUES (?,?)";
        $stm = $db->prepare($sql);
        if ($stm->execute(array($amount,$myid))) {
            print "<script>alert('Money send');window.location.assign('send.php')</script>";
        } else {
            print "<script>alert('Transaction history add fail');window.location.assign('send.php')</script>";
        }
    } else{
        print "<script>alert('Balance update fail');window.location.assign('send.php')</script>";
    }
    } else {
        echo "<script>alert('User not found');window.location.assign('send.php')</script>";
    }
}
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
                                    <form id="login-form" class="form" method="post">
                                        <div class="form-group">
                                            <label>Card ID:</label>
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
                                            <input name="number" class="form-control" placeholder="Enter phone number" type="number">
                                        </div>
                                        <div class="form-group">
                                        <input type="submit" name="pay" class="btn btn-danger" value="Send money">
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