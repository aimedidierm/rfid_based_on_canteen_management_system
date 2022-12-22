<?php
require 'php-includes/connect.php';
if(isset($_POST['card'])){
    //$card = $_POST['card'];
    $card= "E3 DA 21 AB";
    $money = $_POST['money'];
    //$pass = $_POST['pass'];
    $pass = 123;
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
                $arr = array('c' => 4,'ba' => $newamount);
                echo $data = json_encode($arr)."\n";
            } 
        } else {
                //no balance
                $arr = array('c' => 2,'b' => 2);
                echo $data = json_encode($arr)."\n";
        } 
    
    } else {
        //incorrect pass
        $arr = array('c' => 3,'b' => 2);
        echo $data = json_encode($arr)."\n";
    }
}
?>