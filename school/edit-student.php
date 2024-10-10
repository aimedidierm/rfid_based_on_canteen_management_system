<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../php-includes/connect.php';
require 'php-includes/check-login.php';

$student_id = $_GET['id'];

$sql = "SELECT * FROM student WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->execute(array($student_id));
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "<script>alert('Student not found!');window.location.assign('students.php');</script>";
}

if (isset($_POST['update'])) {
    $names = $_POST['names'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $card = $_POST['card'];
    $password = $_POST['password'];

    $sql = "UPDATE student SET names = ?, email = ?, phone = ?, card = ?, password = ? WHERE id = ?";
    $stmt = $db->prepare($sql);

    if ($stmt->execute(array($names, $email, $phone, $card, $password, $student_id))) {
        echo "<script>alert('Student updated successfully');window.location.assign('students.php');</script>";
    } else {
        echo "<script>alert('Update failed. Try again.');window.location.assign('edit-student.php?id=$student_id');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Student</title>
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
                <h1 class="page-header">Edit Student</h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="students.php">Students</a></li>
                    <li class="active">Edit Student</li>
                </ol>
            </div>
            <div id="page-inner">
                <form method="post">
                    <div class="form-group">
                        <label>Names</label>
                        <input class="form-control" type="text" name="names" value="<?php echo $student['names']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="<?php echo $student['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" type="number" name="phone" value="<?php echo $student['phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Card number</label>
                        <input class="form-control" type="text" name="card" value="<?php echo $student['card']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="text" name="password" value="<?php echo $student['password']; ?>" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" name="update">
                            <span class="glyphicon glyphicon-check"></span> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>