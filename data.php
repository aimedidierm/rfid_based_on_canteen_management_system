<?php
require 'php-includes/connect.php';
if(isset($_REQUEST['card'])){
    //$card = $_REQUEST['card'];
    $card = "12";
    $code = $_REQUEST['code'];
    $pass = $_REQUEST['pass'];
    $query = "SELECT s.id,s.balance FROM student AS s WHERE card = ? AND password = ? limit 1";
    $stmt = $db->prepare($query);
    $stmt->execute(array($card,$pass));
    if ($stmt->rowCount()>0) {
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $user=$rows['id'];
    $am=$rows['balance'];
    $query = "SELECT amount,code FROM orders WHERE code = ? limit 1";
    $stmt = $db->prepare($query);
    $stmt->execute(array($code));
    if ($stmt->rowCount()>0) {
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $money=$rows['amount'];
        if ($money <= $am) {
            $newamount=$am-$money;
            $sql ="UPDATE student SET balance = ? WHERE id = ? limit 1";
            $stm = $db->prepare($sql);
            $stm->execute(array($newamount, $user));
            $sql ="INSERT INTO transactions (credit, student) VALUES (?,?)";
            $stm = $db->prepare($sql);
            $stm->execute(array($money, $user));
            $arr = array('c' => 4,'b' => $newamount);
            echo $data = json_encode($arr)."\n";
        } else {
                //no balance
                $arr = array('c' => 2,'b' => 2);
                echo $data = json_encode($arr)."\n";
        }
    
    } else {
        //invalid code
        $arr = array('c' => 5,'b' => 2);
        echo $data = json_encode($arr)."\n";
    }
}   else {
    //user not found
    $arr = array('c' => 6,'b' => 2);
    echo $data = json_encode($arr)."\n";
}
}
?>