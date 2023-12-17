<?php

$orderid=$_GET['orderid'];

include_once "../shared/connection.php";

$status=mysqli_query($conn,"delete from orders where orderid=$orderid");

if($status){
    header("location:view_orders.php");
}
else{
    echo mysqli_error($conn);
}

?>