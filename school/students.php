<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../php-includes/connect.php';
require 'php-includes/check-login.php';
$sql = "SELECT * FROM school WHERE email = ? limit 1";
$stmt = $db->prepare($sql);
$stmt->execute(array($_SESSION['code']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$school = $row['id'];
if (isset($_POST['save'])) {
    $names = $_POST['names'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $card = $_POST['card'];
    $password = $_POST['password'];
    $sql = "INSERT INTO student (names, card, email, phone, balance, school,password) VALUES (?,?,?,?,'0',?,?)";
    $stm = $db->prepare($sql);
    if ($stm->execute(array($names, $card, $email, $phone, $school, $password))) {
        print "<script>alert('Student added');window.location.assign('students.php')</script>";
    } else {
        echo "<script>alert('Error! try again');window.location.assign('students.php')</script>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School</title>
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
        <?php require 'php-includes/nav.php'; ?>
        <div id="page-wrapper">
            <div class="header">
                <h1 class="page-header">Students management</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Home</a></li>
                    <li class="active">Students</li>
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
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>N</th>
                                                <th>Names</th>
                                                <th>Email</th>
                                                <th>phone</th>
                                                <th>Balance</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM school WHERE email = ?";
                                            $stmt = $db->prepare($sql);
                                            $stmt->execute(array($_SESSION['code']));
                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $myid = $row['id'];
                                            $sql = "SELECT * FROM student WHERE school = ?";
                                            $stmt = $db->prepare($sql);
                                            $stmt->execute(array($myid));
                                            if ($stmt->rowCount() > 0) {
                                                $count = 1;
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                    <tr>
                                                        <td><?php print $count ?></td>
                                                        <td><?php print $row['names'] ?></td>
                                                        <td><?php print $row['email'] ?></td>
                                                        <td><?php print $row['phone'] ?></td>
                                                        <td><?php print $row['balance'] ?></td>
                                                        <td>
                                                            <form method="post"><button type="submit" class="btn btn-danger" id="<?php echo $row["id"];
                                                                                                                                    $sid = $row["id"]; ?>" name="delete"><span class="glyphicon glyphicon-trash"></span> Delete</button></form>
                                                            <a href="edit-student.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
                                                                <span class="glyphicon glyphicon-pencil"></span> Edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $count++;
                                                }
                                            }
                                            if (isset($_POST['delete'])) {
                                                $sql = "DELETE FROM student WHERE id = ?";
                                                $stm = $db->prepare($sql);
                                                if ($stm->execute(array($sid))) {
                                                    print "<script>alert('Student deleted');window.location.assign('students.php')</script>";
                                                } else {
                                                    print "<script>alert('Delete fail');window.location.assign('students.php')</script>";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!--End Advanced Tables -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form method="post">
                                        <div class="form-group">
                                            <label>Names</label>
                                            <input class="form-control" type="text" name="names" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" type="number" name="phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Card number</label>
                                            <input class="form-control" type="text" name="card" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" type="text" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" name="save"><span class="glyphicon glyphicon-check"></span> Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <p>All right reserved.
            </footer>
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
        $(document).ready(function() {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- Custom Js -->
    <script src="../assets/js/custom-scripts.js"></script>


</body>

</html>