<?php

include "authguard.php";
session_start();

$name = $_POST['pro_name'];
$price = $_POST['pro_price'];
$details = $_POST['pro_details'];
$discount = $_POST['pro_discount'];
$dest_file_path = "../shared/images/".$_FILES['pro_img']['name'];
$uploaded_by = $_SESSION['User_Id'];

move_uploaded_file($_FILES['pro_img']['tmp_name'],$dest_file_path);

include_once "../shared/connection.php";
$status = mysqli_query($conn,"insert into product(name,price,details,impath,uploaded_by,discount) values('$name','$price','$details','$dest_file_path','$uploaded_by','$discount')");
if($status){
    echo "product uploaded successfully!";
    header("location:view_products.php");
}
else{
    echo mysqli_error($conn);
}
?>