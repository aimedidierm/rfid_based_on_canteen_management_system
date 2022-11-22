<?php
require '../php-includes/connect.php';
if(isset($_POST['card'])){
    $card = $_POST['card'];
    $sql = "SELECT * FROM student where card = ? limit 1";
    $stmt = $db->prepare($sql);
    $stmt->execute(array($card));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row>0){
    $names = $row['names'];
    $balance = $row['balance'];
    $data = array('names' =>$names, 'outml' =>$balance); 
    echo $response = json_encode($data);
    } else {
        echo 'error';
    }
}
?>