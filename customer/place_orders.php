<?php

include "authguard.php";
include_once "../shared/connection.php";

$userid=$_SESSION['User_Id'];
$quantity=$_POST['qty'];

$status1 = mysqli_query($conn,"insert into orders(cartid,pid,userid,quantity) select cart.cartid,cart.pid,cart.userid,$quantity from cart where cart.cartid not in (select orders.cartid from orders where userid = $userid);");
$status2 = mysqli_query($conn,"delete from cart where cartid  in (select orders.cartid from orders where userid = 9002); ");
if($status1 && $status2){
    header("location:view_orders.php");
}
else{
    echo mysqli_error($conn);
}
?>