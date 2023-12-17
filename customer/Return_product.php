<?php

include_once "../shared/connection.php";

if(isset($_GET['orderid'])){
    $orderid=$_GET['orderid'];

    $return_date = mysqli_query($conn,"select DATE(DATE_ADD(orders.created_date, INTERVAL 15 DAY)) > curdate() as can_return from orders where orderid=$orderid");
    $can_return = mysqli_fetch_assoc($return_date);
    $row = $can_return['can_return'];
    
    if($row == 1){
        $status=mysqli_query($conn,"update orders set status = 'returning' where orderid=$orderid");
        echo "<script>alert('Your order can be returned... Once our staff collected the product, will refund ur payment');
                window.location=`view_orders.php`;</script>";
    }
    elseif($row == 0){
        echo "<script>alert('Your order can be returned... Once our staff collected the product, will refund ur payment');
                window.location=`view_orders.php`;</script>";
    }
    else{
        mysqli_error($conn);
    }
    
}

?>