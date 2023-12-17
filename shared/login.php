<?php

session_start();
$_SESSION["login_status"] = false;

include_once "connection.php";

$uname = $_POST['uname'];
$upass = $_POST['upass'];

$enc_pass = md5($upass);
echo $enc_pass."<br>";

$sql_query = mysqli_query($conn,"select *from security where User_name = '$uname' and password = '$enc_pass'");

$total_rows = mysqli_num_rows($sql_query);

if($total_rows == 0){
    echo "login unsuccessful";
}
else{
    echo "login successful";
    $row = mysqli_fetch_assoc($sql_query);
    $User_type = $row['User_type'];
    $User_name = $row['User_name'];
    $User_Id = $row['User_Id'];

    if($User_type == "vendor"){
        $_SESSION["login_status"] = true;
        $_SESSION["User_type"] = $User_type;
        $_SESSION["User_name"] = $User_name;
        $_SESSION["User_Id"] = $User_Id;

        header("location:../vendor/home.php");
    }
    else if($User_type == "customer"){
        $_SESSION["login_status"] = true;
        $_SESSION['User_name'] = $User_name;
        $_SESSION['User_type'] = $User_type;
        $_SESSION['User_Id'] = $User_Id;
        
        header("location:../customer/home.php");
    }
}
?>