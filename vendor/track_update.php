<?php

$orderid=$_GET['orderid'];

include_once "../shared/connection.php";
$cur_status = mysqli_query($conn,"select status from orders where orderid=$orderid");
$current_status = mysqli_fetch_assoc($cur_status);
$row = $current_status['status'];

switch ($row) {
    case "placed":
        echo "<script>confirm('Are you sure the order is confirmed?');</script>";
        $status=mysqli_query($conn,"update orders set status = 'confirmed' where orderid=$orderid");
        forwardpage($status,$conn);
        break;
    case "confirmed":
        echo "<script>confirm('Are you sure the order is shipped?');</script>";
        $status=mysqli_query($conn,"update orders set status = 'shipped' where orderid=$orderid");
        forwardpage($status,$conn);
        break;
    case "shipped":
        echo "<script>confirm('Are you sure the order can be out for delivery?');</script>";
        $status=mysqli_query($conn,"update orders set status = 'out for delivery' where orderid=$orderid");
        forwardpage($status,$conn);
        break;
    case "out for delivery":
        echo "<script>confirm('Are you sure the order is delivered?');</script>";
        $status=mysqli_query($conn,"update orders set status = 'delivered' where orderid=$orderid");
        forwardpage($status,$conn);
        break;
    case "returning":
        echo "<script>confirm('Are you sure the order is returned?');</script>";
        $status=mysqli_query($conn,"update orders set status = 'returned' where orderid=$orderid");
        forwardpage($status,$conn);
        break;
    default:
        echo "<script>confirm('Are you sure the order is returned?');</script>";
        $status=true;
        forwardpage($status,$conn);
        break;
    }                 

function forwardpage($status,$conn){
    if($status){
        header("location:view_orders.php");
    }
    else{
        echo mysqli_error($conn);
    }
}

?>