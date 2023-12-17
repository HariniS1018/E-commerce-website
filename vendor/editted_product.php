<?php

include "authguard.php";
include_once "../shared/connection.php";

$userid=$_SESSION['User_Id'];

$pid=$_GET['pid'];
$name=$_POST['pro_name'];
$details=$_POST['pro_details'];
$discount = $_POST['pro_discount'];
$price=$_POST['pro_price'];
$impath = "../shared/images/".$_FILES['pro_img']['name'];
move_uploaded_file($_FILES['pro_img']['tmp_name'],$impath);

if($impath==="../shared/images/"){
    $img = mysqli_query($conn,"select impath from product where pid=$pid");
    $row=mysqli_fetch_assoc($img);
    $imgpath=$row['impath'];
    $status=mysqli_query($conn,"update product set name='$name', price = $price, details='$details',  impath = '$imgpath',discount='$discount' where pid=$pid");
}
else{
    $status=mysqli_query($conn,"update product set name='$name', price = $price, details='$details',  impath = '$impath',discount='$discount' where pid=$pid");
}

if($status){
    header("location:view_products.php");
}
else{
    echo mysqli_error($conn);
}

?>