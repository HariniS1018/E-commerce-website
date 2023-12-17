<?php

include "authguard.php";

$userid=$_SESSION['User_Id'];
$pid=$_GET['pid'];

include_once "../shared/connection.php";

$sql_query = mysqli_query($conn,"select pid from cart where userid=$userid and pid=$pid");
$row = mysqli_fetch_assoc($sql_query);

if($row !=null){
    $query = mysqli_query($conn,"update cart set quantity = quantity+1 where userid=$userid and pid=$pid");
    if($query){
    echo "<script>alert('already in cart... so incremented the quantity in cart');
                  window.location=`home.php`;
            </script>";
    }
    else{
        echo mysqli_error($conn);
    }
}
else{
    $status=mysqli_query($conn,"insert into cart(pid,userid) values($pid,$userid)");
    if($status){
        header("location:home.php");
    }
    else{
        echo mysqli_error($conn);
    }
}
?>