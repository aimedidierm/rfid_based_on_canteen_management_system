<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
session_start();
require 'php-includes/connect.php';
$p1=floatval( $_POST['p1'] ?? 0);
$p2=floatval( $_POST['p2'] ?? 0);
$p3=floatval( $_POST['p3'] ?? 0);
$p4=floatval( $_POST['p4'] ?? 0);
$p5=floatval( $_POST['p5'] ?? 0);
$p6=floatval( $_POST['p6'] ?? 0);
$p7=floatval( $_POST['p7'] ?? 0);
$p8=floatval( $_POST['p8'] ?? 0);
$p9=floatval( $_POST['p9'] ?? 0);
$p10=floatval( $_POST['p10'] ?? 0);
$p11=floatval( $_POST['p11'] ?? 0);
$p12=floatval( $_POST['p12'] ?? 0);
$code = rand(0,9999);
$sum=$p1+$p2+$p3+$p4+$p5+$p6+$p7+$p8+$p9+$p10+$p11+$p12;
$sql ="INSERT INTO orders (p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,amount,code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stm = $db->prepare($sql);
    if ($stm->execute(array($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11,$p12,$sum,$code))) {
	echo "<script>alert('Your code is ".$code."');window.location.assign('index.php')</script>";
}else{
	echo "<script>alert('Your Order fail, Please try again');window.location.assign('index.php')</script>";
}
?>