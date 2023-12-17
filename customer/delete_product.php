<?php

include_once "../shared/connection.php";

if(isset($_GET['cartid'])){
    $cartid=$_GET['cartid'];
    $status=mysqli_query($conn,"delete from cart where cartid=$cartid");

}
else{
    $status=mysqli_query($conn,"delete from cart");

}

if($status){
    header("location:view_cart.php");
}
else{
    mysqli_error($conn);
}

?>