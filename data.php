<?php
require 'php-includes/connect.php';
if(isset($_GET['card'])){
    $card = $_GET['card'];
    $money = $_GET['money'];
    $pass = $_GET['pass'];
    $query = "SELECT * FROM student WHERE card = ? AND password = ? limit 1";
    $stmt = $db->prepare($query);
    $stmt->execute(array($card,$pass));
    if ($stmt->rowCount()>0) {
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $user=$rows['id'];
    $am=$rows['balance'];
        if ($money <= $am) {
            $newamount=$am-$money;
            $sql ="UPDATE student SET balance = ? WHERE id = ? limit 1";
            $stm = $db->prepare($sql);
            if ($stm->execute(array($newamount, $user))) {
                $sql ="INSERT INTO transactions (credit, student) VALUES (?,?)";
                $stm = $db->prepare($sql);
                $stm->execute(array($money, $user));
                $data = array('cstatus' =>'1','balance' =>$newamount); 
                echo $response = json_encode($data);
            } 
        } else {
                //no balance
                $data = array('cstatus' =>'2'); 
                echo $response = json_encode($data);
        } 
    
    } else {
        //incorrect pass
        $data = array('cstatus' =>'3'); 
        echo $response = json_encode($data);
        

    }
}
?>