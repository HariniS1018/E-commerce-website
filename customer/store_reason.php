<?php

include "authguard.php";
include "menu.html";

$userid=$_SESSION['User_Id'];
$orderid=$_POST['orderid'];
$reason = $_POST['reason'];
$pid = $_POST['pid'];

include_once "../shared/connection.php";

$sql_cursor = mysqli_query($conn,"insert into return_reason(orderid,userid,pid,reason) values($orderid,$userid,$pid,'$reason')");

if($sql_cursor){
    echo "<script>alert('Thanks for ur reasoning... we will update ourselves to give better service');
    window.location = `home.php`;
</script>";
}
else{
    echo mysqli_error($conn);
}
?>