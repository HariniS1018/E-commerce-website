<?php

include_once "connection.php";

$uname = $_POST['uname'];
$upass = $_POST['upass'];
$enc_pass = md5($upass);
$utype = $_POST['utype'];

$status = mysqli_query($conn,"insert into security(User_name,password,User_type) values('$uname','$enc_pass','$utype')");

if($status){
    echo "<h1>Registeration successful</h1>
            <a href='login.html'>Go to login</a>";
}
else{
    echo "<h1>Registeration Failed</h1>
    <a href='login.html'>Go to login</a>";
    echo mysqli_error($conn);
}

?>