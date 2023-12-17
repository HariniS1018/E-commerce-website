<?php

include_once "connection.php";

$uname = $_POST['uname'];
$npass = $_POST['npass'];

$enc_pass = md5($npass);
//echo $enc_pass."<br>";

$sql_query = "update security set password = '$enc_pass' where User_name = '$uname'";
mysqli_query($conn, $sql_query);

if(mysqli_affected_rows($conn) >0){
    echo "New Password Updation successful
            <a href='login.html'>Go to login</a>";

}
else{
    echo "New Password Updation unsuccessful
            <a href='login.html'>Go to login</a>";
}
mysqli_close($conn);
?>