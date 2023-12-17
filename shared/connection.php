<?php

$conn = new mysqli("localhost","root","root","acme23_may");

if($conn->connect_error){
    echo "Error in sql connection";
    die;
}

?>