<?php

include "authguard.php";
include "menu.html";

$userid=$_SESSION['User_Id'];
$pid = $_POST['pid'];
$orderid=$_POST['orderid'];
$star = $_POST['star'];
$review = $_POST['review'];

include_once "../shared/connection.php";

$sql_cursor=mysqli_query($conn,"insert into customer_reviews(pid,userid,orderid,star_rate,review) values($pid,$userid,$orderid,$star,'$review')");

if($sql_cursor){
    echo "<script>alert('Thanks for ur genuine review...');
            window.location = `home.php`;
        </script>";
}
else{
    echo mysqli_error($conn);
}
?>