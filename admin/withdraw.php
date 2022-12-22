<?php
require '../php-includes/connect.php';
require 'php-includes/check-login.php';
?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
	<!-- Bootstrap Styles-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- Morris Chart Styles-->
   
        <!-- Custom Styles-->
    <link href="../assets/css/custom-styles.css" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
<div id="wrapper">
        <?php require 'php-includes/nav.php';?>
        <div id="page-wrapper">
		  <div class="header"> 
        <h1 class="page-header">Seller pending withdraw</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li>Withdraw</li>
            <li class="active">Sellers</li>
          </ol>
			<h1>						
		</div>
		
            <div id="page-inner"> 
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>N</th>
                                            <th>Names</th>
                                            <th>Amount</th>
                                            <th>Mobile</th>
                                            <th>Time</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sql = "SELECT p.id,p.seller,p.amount,p.time,s.id AS s_id,s.phone,s.names FROM pending_withdraw AS p JOIN seller AS s ON p.seller=s.id";
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                        if ($stmt->rowCount() > 0) {
                                            $count = 1;
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                        <tr>
                                            <td><?php print $count?></td>
                                            <td><?php print $row['names']?></td>
                                            <td><?php print $row['amount']?></td>
                                            <td><?php print $row['phone']?></td>
                                            <td><?php print $row['time']?></td>
                                            <td><form method="post"><button type="submit" class="btn btn-success" id="<?php echo $row["id"];$sid=$row["id"];$seller=$row["seller"];$namount=$row['amount']; ?>" name="com"><span class="glyphicon glyphicon-trash"></span> Comfirm</button></form></td>
                                        </tr>
                                        <?php
                                        $count++;
                                        }
                                    }
                                    if(isset($_POST['com'])){

                                        $query = "SELECT * FROM seller WHERE id= ? limit 1";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute(array($seller));
                                        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                                        if ($stmt->rowCount()>0) {
                                            $balance=$rows['balance'];
                                        }
                                        $newbalance=$balance-$namount;
                                        $sql ="UPDATE seller SET balance = ? WHERE id = ? limit 1";
                                        $stm = $db->prepare($sql);
                                        if ($stm->execute(array($newbalance,$seller))) {
                                            $sql ="DELETE FROM pending_withdraw WHERE id = ?";
                                            $stm = $db->prepare($sql);
                                            if ($stm->execute(array($sid))) {
                                                $sql ="INSERT INTO transactions (credit,seller) VALUES (?,?)";
                                                $stm = $db->prepare($sql);
                                                if ($stm->execute(array($namount,$seller))) {
                                                    print "<script>alert('Comfirmed');window.location.assign('withdraw.php')</script>";
                                        
                                                } else {
                                                    print "<script>alert('Fail');window.location.assign('withdraw.php')</script>";
                                                }
                                            } else {
                                                print "<script>alert('Fail');window.location.assign('withdraw.php')</script>";
                                            }
                                        } else {
                                            print "<script>alert('Fail');window.location.assign('withdraw.php')</script>";
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
               <footer><p>All right reserved. </footer>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- Custom Js -->
    <script src="../assets/js/custom-scripts.js"></script>
    
   
</body>
</html>