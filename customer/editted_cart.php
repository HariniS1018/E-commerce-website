<?php

include "authguard.php";

$userid=$_SESSION['User_Id'];
$cartid=$_POST['cartid'];
$quantity=$_POST['qty'];

include_once "../shared/connection.php";

$status=mysqli_query($conn," update cart set quantity=$quantity where cartid= $cartid");
if($status){
    header("location:view_cart.php");
}
else{
    echo mysqli_error($conn);
}
?>